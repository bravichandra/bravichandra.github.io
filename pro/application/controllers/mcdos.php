<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

session_start();

class Mcdos extends CI_Controller {

	/**

	 * Properties

	 */

	public $_data;

	public $_user_id;

	public $_parent_users=array();
	public $_parent_users_all=array();



	/**

	 * Constructor

	 */

	public function __construct()

	{

		parent::__construct();

		$this->output->nocache();

		//Load Helpers 

        $this->load->helper('form');

        $this->load->helper('cookie');

        $this->load->library('session');

        //Load Models

		$this->load->model('home_model', 'home');

        $this->load->model('crm_model', 'crm');

        $this->load->model('campaign_model', 'campaign');

		$this->load->model('product_model', 'productModel');

		

		if(!$this->config->item('is_local'))

		{

			include(CDOC_ROOT."members/library/Am/Lite.php"); 

                      

            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');

			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014

			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,30,31,32), 'Restricted access'); //  This array is Updated by Dev@4489 on 23-Oct-2015

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year

			

			$amember_username = Am_Lite::getInstance()->getUsername();

	        // Get user from DB by username

	        if($user_id = $this->home->get_user_by_username($amember_username))

	        {

	        	$this->_data['user_id'] = $user_id;

	        }

	        else 

			{

				// Get Full Name

				$amember_full_username = Am_Lite::getInstance()->getName();

				$name = explode(" ", $amember_full_username);

				//Insert Register User information into database.

				$this->_data['user_id'] = $this->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));

				$just_registered = TRUE;

			}

			//aMember Profile

			$this->_data['aMember'] = array('yname'=>'','yemail'=>'','yphone'=>'','ytitle'=>'','ycompany'=>'','ywebsite'=>'');

			$amember_data = Am_Lite::getInstance()->getUser();

			if($amember_data) {

				$this->_data['aMember'] = array('yname'=>ucfirst($amember_data['name_f'].' '.$amember_data['name_l']),'yemail'=>$amember_data['email'],'yphone'=>$amember_data['phone'],'ytitle'=>$amember_data['utitle'],'ycompany'=>'','ywebsite'=>'');
				//Update amember profile into App user info
				$appuser = $this->home->get_single_user_info($user_id);
				//print_r($this->_data['aMember']);print_r($appuser);
				if($appuser) {
					if($appuser->first_name<>$amember_data['name_f'] || $appuser->last_name<>$amember_data['name_l']) {
						$amuser = array('first_name'=>$amember_data['name_f'],'last_name'=>$amember_data['name_l']);
						$this->home->update_user_info($amember_username,$amuser);
					}

				}

			}

			



            //$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2'));

			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10'));//  This array is Updated by Aavid developer on 17-April-2014

			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','30','31','32'));//  This array is Updated by Dev@4489 on 17-April-2014

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year



			// Check User Subscription PAID OR FREE

			$this->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;

			

			//By Dev@4489

			//Modify access

			$eSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('3','5','6','10','14','15','32'));//Scripter Pro for Editing  By Dev@4489 24-Oct-2015

			//Pro Lite Subscription

			$PLSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('18','28'));

			if($PLSubscribe && !$eSubscribe) $this->_data['is_prolite'] = TRUE;

			if($eSubscribe) $this->_data['eScripter'] = TRUE;

			// interviewer

			$interviewer = Am_Lite::getInstance()->haveSubscriptions(array('30','31'));// products

			if($interviewer) $this->_data['einterviewer'] = TRUE;

			//$this->_data['einterviewer'] = TRUE;

			////

			

		}else 

        {

			// For local testing 

        	$amember_username = "a_ehmad";

	        // Get user from DB by username

	        if($user_id = $this->home->get_user_by_username($amember_username))

	        {

	        	$this->_data['user_id'] = $user_id;

	        }

	        else 

			{

				// Get Full Name

				$amember_full_username = "Fraz Ahmed";

				$name = explode(" ", $amember_full_username);

				//Insert Register User information into database.

				$this->_data['user_id'] = $this->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));

				$just_registered = TRUE;

			}

			$this->_data['user_id'] = 2;

        	$this->_data['is_paid'] = TRUE;

        }

        //Shared User Information
        $this->load->helper('scripts');
        $this->_data['AMuserShares'] = amb_share_verify($this->_data);        
        //End of Shared User Information

		//Shared Access to CRM
		if($this->_data['AMuserShares']['crm']==0) redirect(base_url('/'));

		//Unset Marketing dropdown all option sessions

		$this->session->unset_userdata('dpall_namedrop');

		$this->session->unset_userdata('dpall_campaign');

		$this->session->unset_userdata('dpall_company');

		//By Dev@4489

		//Check & Get the shared user id for Lite Users

		/*if($PLSubscribe && !$eSubscribe) {

			$saUser = $this->home->SharedUser($this->_data['user_id']);

			if($saUser) $this->_data['user_id'] = $saUser;

		}*/

		////
		

		//Timezone

		$this->_data['tzone']="America/Chicago";

		$where = array();

		$where['user_id'] = $this->_data['user_id'];

		$where['field_type'] = 'timezone';

		$user_info = $this->home->getUserData($where);

		if($user_info) {

			$user_info = $user_info[0];

			if(isset($user_info->value)) $this->_data['tzone']=$user_info->value;			

		}

		date_default_timezone_set($this->_data['tzone']);

		

		//Check & Get the shared user id for Lite Users

		if($PLSubscribe && !$eSubscribe) {

			$saUser = $this->home->SharedUser($this->_data['user_id']);

			if($saUser) {

				//$this->_data['user_id'] = $saUser;

				//if this is defined then Lite user cant access for dynamic editings on HTML page

				$this->_data['eLusrNotBS'] = $saUser;

			}

		}

		

		

		

		

		$record_owners = array();

		$record_owners[] = $this->_data['user_id'];

		if($this->_data['is_prolite']) {

			$parent_id = $this->home->SharedUser($this->_data['user_id']);

		} else $parent_id = $this->_data['user_id'];

		if($parent_id) {

			$record_owners[] = $parent_id;

			$share_ids = $this->home->getSharedUsers($parent_id);

			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;

			$record_owners = array_unique($record_owners);

		}

		$this->_parent_users = $record_owners;
		$this->_parent_users_all = $record_owners;

		

		//For Lite user access
		if(isset($this->_data['is_prolite'])) {
			$shareduser = $this->home->SharedUserInfo($this->_data['user_id']);
			if($shareduser) {
				if($shareduser->accessview=="Own") $this->_parent_users = array($this->_data['user_id']);
			}
		}

		

	   $this->_user_id = $this->_data['user_id'];

       $_SESSION['ss_user_id'] = $this->_user_id;	 

		//For ajax requests
		if ($this->input->is_ajax_request()) {
			$mcaction =$this->input->post('mctype');
			if(empty($mcaction)) {
				$json = array('message'=>"Invalid Action",'status'=>false);
				echo json_encode($json);
				exit;
			}		
		}

       

		


       	$where_mc = array();
		$where_mc['user_id'] = $this->_user_id;
		$where_mc['field_type'] = 'mailchimp';
		$user_info_mc = $this->home->getUserData($where_mc);
		if(!$user_info_mc) return;
		if($user_info_mc) $user_info_mc = $user_info_mc[0];

		$mailchimp = array('apikey'=>'');
		if(isset($user_info_mc->value)) $mailchimp['apikey'] = $user_info_mc->value;
		if(empty($mailchimp['apikey'])) {
			$json = array('message'=>"Invalid Mailchimp API key",'status'=>false);
			echo json_encode($json);
			exit;
		}

		$this->config->set_item('Mailchimp_api_key', $mailchimp['apikey']);
		
		$this->load->library('MailChimp');

		//verify mailchimp api
		/*$mc_account = $this->mailchimp->get('');
		//print_r($mc_account);
		if(!$mc_account) {
			$this->_data['mailchimp_error']="Invalid Mailchimp Api Key";
			return;
		}
		if(!isset($mc_account['account_id'])) {
			$this->_data['mailchimp_error']="Invalid Mailchimp Api Key";
			return;
		}*/
		$this->_data['mailchimp_ok']=1;

	}

	//Import contacts
	public function importContacts() {
		$mcaction =$this->input->post('mctype');
		if($mcaction<>"importcontacts") {
			$json = array('message'=>"Invalid Action",'status'=>false);
			echo json_encode($json);
			return;
		}

		if(isset($this->_data['mailchimp_error'])) {
			$json = array('message'=>$this->_data['mailchimp_error'],'status'=>false);
			echo json_encode($json);
			return;
		}
		$listid=$this->input->post('listid');
		if(empty($listid)) {
			$json = array('message'=>"MailChimp List required",'status'=>false);
			echo json_encode($json);
			return;
		}

		//Category List ID
		$sslistid=$this->input->post('aslist');
		$records_listid = $sslistid?(int)$sslistid:0;

		//Record owner
		$record_owner=$this->input->post('aro');
		$record_owner = $record_owner?(int)$record_owner:0;
		if(!$record_owner) $record_owner = $this->_user_id;

		$offset=$this->input->post('offset');
		$offset = $offset?(int)$offset:0;
		$limit = 50;

		$own = implode(",", $this->_parent_users_all);
		$ownq = " AND userid IN ($own)";

		$mc_result = $this->mailchimp->get('lists/'.$listid.'/members?status=subscribed&count='.$limit.'&offset='.$offset);
		if(!isset($mc_result['total_items'])) $cno = 0;
		else $cno = $mc_result['total_items'];

		if($cno==0) {
			$json = array('message'=>"No contacts to import",'status'=>false);
			echo json_encode($json);
			return;
		}
		$members = $mc_result['members'];
		$mcount = count($members);
		$done = $offset+$mcount;

		$imported=$this->input->post('imd');
		$imported = $imported?(int)$imported:0;
		
		if($mcount) {
			//$own = implode(",", $this->_parent_users);
			//$ownq = " AND userid IN ($own)";
			foreach($members as $cval) {
				$contact_id=0;
				$contact_record = $this->crm->get_acRecord("LOWER(email)='".strtolower($cval['email_address'])."'".$ownq,'contact_id','C');
				if($contact_record) {
					$contact_id = $contact_record['contact_id'];
				} else {
					//Save contact				
					$cdata = array();
					if(isset($cval['merge_fields']['FNAME']) && $cval['merge_fields']['FNAME']) 
						$cdata['user_first']=$cval['merge_fields']['FNAME'];
					else {
						$eml = explode("@", $cval['email_address']);
						$cdata['user_first'] = $eml[0];
					}
					if(isset($cval['merge_fields']['LNAME']) && $cval['merge_fields']['LNAME']) 
						$cdata['user_last']=$cval['merge_fields']['LNAME'];
					$cdata['email']=strtolower($cval['email_address']);
					if($contact_id==0) {
						$cdata['share_user_id']=$record_owner;
						$cdata['create_date']=date("Y-m-d H:i:s");
						$cdata['modify_date']=date("Y-m-d H:i:s");
					}
					$contact_id = $this->crm->save_contact($cdata,$contact_id);	
					if($contact_id) $imported++;
				}

				//Category List ID & assign record to list
				if($contact_id && $records_listid) {
					$exist_record = $this->crm->get_category_record($records_listid,$contact_id);
					if(!$exist_record) {
						$info = array('category_id'=>$records_listid,'record_id'=>$contact_id);
						$this->crm->save_category_record($info);
					}
				}
			}
		}
		$msg = "Contacts: $imported($cno) imported.";
		if($done<$cno) $msg .= " Importing remaining contacts...."; else $msg .= " Import process completed.";		
		$json = array('message'=>$msg,'status'=>true,'count'=>$cno,'done'=>$done,'imported'=>$imported);
		echo json_encode($json);
		return;

	}

	//Mailchimp Workflow Automations for List ids
	public function workflow() {
		$this->_data['maildelv'] = "workflow";
		$breadcrumbs = array();
		$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));
		$breadcrumbs[] = array('label'=>'Workflow Automation','url'=>base_url('mcdos/workflow'));
		$this->_data['breadcrumbs']=$breadcrumbs;

		$this->load->view('crm/settings_mailchimp_workflows', $this->_data);
	}

}

/* End of file mcdos.php */

/* Location: ./application/controllers/mcdos.php */	