<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
     * Function name  : checkuserlogin
     * Function Use   :This function is use to check user is login to system or not.
     * Function Param :NULL 
     * Return Value:userid or false
     */ 

	function checkuserlogin()
	{
		return 1;
		$CI = & get_instance();
		$userid = $CI->session->userdata('userid');
		//var_dump($userid) ; die('sdasdsadsdasdasdsa');
		if($userid)
		{
				return $userid;
		}
		else
		{
		   return false;
		}
	}

	function am_auth()
	{		
		$CI = & get_instance();
		$CI->load->model('home_model','home');
		$CI->load->model('crm_model', 'crm');
		if(!$CI->config->item('is_local'))
		{
			include(CDOC_ROOT."members/library/Am/Lite.php"); 
                      
            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28), 'Restricted access'); //  This array is Updated by Dev@4489 on 23-Oct-2015
			// 9  is for Scripter Pro 3 Month
			// 10 is for Scripter Pro 1 Year
			
			$amember_username = Am_Lite::getInstance()->getUsername();
	        // Get user from DB by username
	        if($user_id = $CI->home->get_user_by_username($amember_username))
	        {
	        	$CI->_data['user_id'] = $user_id;
	        }
	        else 
			{
				// Get Full Name
				$amember_full_username = Am_Lite::getInstance()->getName();
				$name = explode(" ", $amember_full_username);
				//Insert Register User information into database.
				$CI->_data['user_id'] = $CI->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));
				$just_registered = TRUE;
			}
			//aMember Profile
			$CI->_data['aMember'] = array('yname'=>'','yemail'=>'','yphone'=>'','ytitle'=>'','ycompany'=>'','ywebsite'=>'');
			$amember_data = Am_Lite::getInstance()->getUser();
			if($amember_data) {
				$CI->_data['aMember'] = array('yname'=>ucfirst($amember_data['name_f'].' '.$amember_data['name_l']),'yemail'=>$amember_data['email'],'yphone'=>$amember_data['phone'],'ytitle'=>$amember_data['utitle'],'ycompany'=>'','ywebsite'=>'');
			}
			

            //$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2'));
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10'));//  This array is Updated by Aavid developer on 17-April-2014
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3'));//  This array is Updated by Dev@4489 on 17-April-2014
			// 9  is for Scripter Pro 3 Month
			// 10 is for Scripter Pro 1 Year

			// Check User Subscription PAID OR FREE
			$CI->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;
			
			//By Dev@4489
			//Modify access
			$eSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('3','5','6','10','14','15'));//Scripter Pro for Editing  By Dev@4489 24-Oct-2015
			//Pro Lite Subscription
			$PLSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('18','28'));
			if($PLSubscribe && !$eSubscribe) $CI->_data['is_prolite'] = TRUE;
			if($eSubscribe) $CI->_data['eScripter'] = TRUE;
			////
			
		}else 
        {
			// For local testing 
        	$amember_username = "a_ehmad";
	        // Get user from DB by username
	        if($user_id = $CI->home->get_user_by_username($amember_username))
	        {
	        	$CI->_data['user_id'] = $user_id;
	        }
	        else 
			{
				// Get Full Name
				$amember_full_username = "Fraz Ahmed";
				$name = explode(" ", $amember_full_username);
				//Insert Register User information into database.
				$CI->_data['user_id'] = $CI->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));
				$just_registered = TRUE;
			}
			$CI->_data['user_id'] = 2;
        	$CI->_data['is_paid'] = TRUE;
        }
		//Unset Marketing dropdown all option sessions
		$CI->session->unset_userdata('dpall_namedrop');
		$CI->session->unset_userdata('dpall_campaign');
		$CI->session->unset_userdata('dpall_company');

		//Timezone
		$CI->_data['tzone']="America/Chicago";
		$where = array();
		$where['user_id'] = $CI->_data['user_id'];
		$where['field_type'] = 'timezone';
		$user_info = $CI->home->getUserData($where);
		if($user_info) {
			$user_info = $user_info[0];
			if(isset($user_info->value)) $CI->_data['tzone']=$user_info->value;			
		}
		date_default_timezone_set($CI->_data['tzone']);
		//User notifications
		$user_notifys = $CI->crm->get_user_notifications($CI->_data['user_id']);
		if($user_notifys) $CI->_data['user_notifiys'] = $user_notifys;
		//Check & Get the shared user id for Lite Users
		if($PLSubscribe && !$eSubscribe) {
			$saUser = $CI->home->SharedUser($CI->_data['user_id']);
			if($saUser) {
				//$this->_data['user_id'] = $saUser;
				//if this is defined then Lite user cant access for dynamic editings on HTML page
				$CI->_data['eLusrNotBS'] = $saUser;
			}
		}

		//Parents
		$record_owners = array();
		$record_owners[] = $CI->_data['user_id'];
		if($CI->_data['is_prolite']) {
			$parent_id = $CI->home->SharedUser($CI->_data['user_id']);
		} else $parent_id = $CI->_data['user_id'];
		if($parent_id) {
			$record_owners[] = $parent_id;
			$share_ids = $CI->home->getSharedUsers($parent_id);
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
			$record_owners = array_unique($record_owners);
		}
		$CI->_parent_users = $record_owners;
		
		$CI->_user_id = $CI->_data['user_id'];
		$_SESSION['ss_user_id'] = $CI->_user_id;
		$CI->session->set_userdata('userid',$CI->_user_id);
        $CI->session->set_userdata('username',$CI->_data['aMember']['yname']);
        $CI->session->set_userdata('useremail',$CI->_data['aMember']['yemail']);
	}

	 /**
	  *  find assests url
	  */
	 function assets_url()
	 {
		return base_url()."assets/";
	 }
/* End of file common_helper.php */
/* Location: ./application/helpers/common_helper.php */