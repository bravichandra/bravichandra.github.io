

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



//error_reporting(E_ALL); 



session_start();



class Crm extends CI_Controller {



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

				if($appuser) {

					if($appuser->first_name<>$amember_data['name_f'] || $appuser->last_name<>$amember_data['name_l']  || $appuser->phone<>$amember_data['phone']) {

						$amuser = array('first_name'=>$amember_data['name_f'],'last_name'=>$amember_data['name_l'],'phone'=>$amember_data['phone']);

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



		//User notifications



		$user_notifys = $this->crm->get_user_notifications($this->_data['user_id']);



		if($user_notifys) $this->_data['user_notifiys'] = $user_notifys;



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



	   



	   //By Dev@4489



		/**  active campaign data */

		
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$this->_user_id);
		$record = $this->db->get();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			 $shuser = $result['userfrom'];
			 $accessview =  $result['accessview'];
		}
		else $shuser = $user_id; 	
		
		
        $active_campaign_data = $this->campaign->get_campaign_active($shuser);


		//$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);



		if($active_campaign_data == false) 



		{



			$tempCampaign = array('campaign_id'=>0,'product_id'=>0);



			$active_campaign_data = (object)$tempCampaign;



		} else if(empty($is_product)) $active_campaign_data->product_id=0;		



		$this->_data['campaign_info'] = $active_campaign_data;



		



		//Signature



		$where = array();



		$where['user_id'] = $this->_user_id;



		$where['field_type'] = 'sign';



		$user_info = $this->home->getUserData($where);



		if($user_info) $user_info = $user_info[0];



		if(isset($user_info->value)) {



			$this->_data['aMember']=unserialize($user_info->value);



		}



		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);



		if($company_info_detail){



			$this->_data['aMember']['ycompany']=$company_info_detail->company_name;



			$this->_data['aMember']['ywebsite']=$company_info_detail->company_website;



		}



		$signature='';



		if($this->_data['aMember']) {



			$aMember = $this->_data['aMember'];



			$signature='<p><span>'.$aMember['yname'].'</span><br />';



			if($aMember['ytitle']) $signature .='<span>'.$aMember['ytitle'].'</span> <br />';



			$signature .='<span>'.$aMember['ycompany'].'</span> <br />';



			if($aMember['yphone'])$signature .='<span>'.$aMember['yphone'].'</span> <br />';



			$signature .='<span><a href="mailto:'.$aMember['yemail'].'">'.$aMember['yemail'].'</a></span> <br />';



			if($aMember['ywebsite']){



				if(substr($aMember['ywebsite'],0,4)<>"http") $WebsiteHttp = "http://"; else  $WebsiteHttp = "";



				$signature .='<span><a href="'.$WebsiteHttp.$aMember['ywebsite'].'" target="_blank">'.$aMember['ywebsite'].'</a></span> <br />';



			}



			$signature .='</p>';



		}



		$this->_data['email_signature'] = $signature;

		

		

		//dropdowns

		$where = array();
		
		
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			 $shuser = $result['userfrom'];
			 $accessview =  $result['accessview'];
		}
		else $shuser = $user_id;	



		//$where['user_id'] = $this->_user_id;

		$where['user_id'] = $shuser;

			$where['field_type'] = 'lead';

	

			$user_info = $this->home->getUserData($where);

			//print_r($user_info);



			if($user_info) $user_info = $user_info[0];



			//Lead Data



			$lead = array();

//echo "rrrrr";

			if(isset($user_info->value)) {

				//echo "tttttt";

				$lead=json_decode($user_info->value);

				//print_r($lead);



			}

			if(empty($lead)) $lead = $this->config->item('lead');



			$this->_data['lead']=$lead;	

			

			//stage

			$where1 = array();

			

			//$where1['user_id'] = $this->_user_id;
			
			$where1['user_id'] = $shuser;



			$where1['field_type'] = 'stage';

	

			$user_info = $this->home->getUserData($where1);



			if($user_info) $user_info = $user_info[0];



			//Stage Data



			$stage = array();



			if(isset($user_info->value)) {

				$stage=json_decode($user_info->value);

			}

			if(empty($stage)) $stage = $this->config->item('stage');

			$this->_data['stage']=$stage;



	   



	   //Group User Custom fields



		//CONTACTS

		$where = array();



		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;



		$where['field_type'] = 'custom';



		$user_info = $this->home->getUserData($where);



		if($user_info) $user_info = $user_info[0];



		$custom = array();



		if(isset($user_info->value)) {



			$custom=unserialize($user_info->value);



			if(isset($custom['kcount'])) unset($custom['kcount']);



		}



		/*else {



			$custom['field1'] = 'Custom Fields 1';



			$custom['field2'] = 'Custom Fields 2';



			$custom['field3'] = 'Custom Fields 3';



		}*/



		$this->_data['custom']=$custom;



		//Numeric custom fields



		$where = array();

		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;

		$where['field_type'] = 'customNum';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];

		$customNum = array();



		if(isset($user_info->value)) {

			$customNum=unserialize($user_info->value);

		}



		$this->_data['customNum']=$customNum;





		//ACCOUNTS

		$where = array();

		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;

		$where['field_type'] = 'customa';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];

		$customa = array();

		if(isset($user_info->value)) {

			$customa=unserialize($user_info->value);

			if(isset($customa['kcount'])) unset($customa['kcount']);

		}

		$this->_data['customa']=$customa;



		//Numeric custom fields



		$where = array();

		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;

		$where['field_type'] = 'customNuma';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];

		$customNuma = array();

		if(isset($user_info->value)) {

			$customNuma=unserialize($user_info->value);

		}

		$this->_data['customNuma']=$customNuma;



	   



	   







	   if(isset($just_registered))



	   {



			// Add pre-filled session



			$redirect = base_url().'folder/my-folder';



			// $redirect = base_url().'memeber/member';	



			// $this->newSession($redirect, 1, "My first product profile");



			$this->defaultNewproduct($redirect, 1, "My first product profile");



			



	   }



	   



		// Check if Product is Add or Not



		$is_product = $this->home->check_product($this->_user_id);



		if(empty($is_product))



		{



			// Add Product into Database



			$status = '2';



			// $data = $this->home->addProduct($status, NULL);



			// $this->_data['product_id'] = $data['product_id'];



			// $this->session->set_userdata('ss_session_id', $data['session_id']);



			



			$redirect = base_url().'folder/my-folder';



			$this->defaultNewproduct($redirect, 1, "My first product profile");



			



		}//error_reporting(E_ALL);



		$this->interviewer_plan_access();



	}



		



	function interviewer_plan_access(){



		if(isset($this->_data['einterviewer'])) {



			$pam2 = $this->uri->segment(2);



			$pam3 = $this->uri->segment(3);



			if($pam2!="settings" || $pam3=="fields")



			redirect(base_url('interviewer/builder'));



		}



	}



	public function index($id = NULL)



	{



		$this->_data['page'] = 'register';



		redirect(base_url() . 'crm/contacts');



	}



	//Redirect from salesforce



	public function sf2ss($item = NULL) {



		if($item=="a") redirect(base_url('crm/accounts/import/salesforce'));



		else if(strstr($item,"cr-")!==FALSE) {



			$cid = str_replace("cr-","",$item);



			redirect(base_url("crm/contacts/view/$cid/send"));



		}else redirect(base_url('crm/contacts/import/salesforce'));



	}



	



	//Contacts



	function contacts($action = NULL)



	{



		/*$this->load->library('excel');



		$this->load->library('parsecsv');



		$csv = new Parsecsv();*/



		$this->_data['crmlite'] = 'contact';



		$pam3 = $this->uri->segment(3);//edit/delete



		$pam4 = $this->uri->segment(4);//contact id



		$pam5 = $this->uri->segment(5);//extra parameter



		$mpaged = 0;

		if ($this->input->is_ajax_request()) {

		   $mpaged = 1;

		   //contact block childs

		   if($this->input->post('ccblock')=="contactchilds1") {

				$id = (int)$pam4;

				$this->_data['contact_id'] = $id;



				$this->_data['notes_list'] = $this->crm->get_all_notes($id,'C',10);



				$this->_data['docs_list'] = $this->crm->get_all_docs($id,'C',10);



				//$this->_data['oppty_list'] = $this->crm->get_contact_relatedto($id,'C');



				//$this->_data['otasks_list'] = $this->crm->get_all_tasks($id,'C',10,2);



				//$this->_data['atasks_list'] = $this->crm->get_all_tasks($id,'C',10,1);



				$this->_data['emails_list'] = $this->crm->get_scheduled_contact_emails($id,10);

				$html = $this->load->view('crm/contact-view-childs', $this->_data,true);

				echo $html;

				exit;	

		   }



		   //contact block childs

		   if($this->input->post('ccblock')=="contactchilds") {

				$id = (int)$pam4;

				$this->_data['contact_id'] = $id;



				//$this->_data['notes_list'] = $this->crm->get_all_notes($id,'C',10);



				//$this->_data['docs_list'] = $this->crm->get_all_docs($id,'C',10);



				$this->_data['oppty_list'] = $this->crm->get_contact_relatedto($id,'C');



				$this->_data['otasks_list'] = $this->crm->get_all_tasks($id,'C',10,2);



				$this->_data['atasks_list'] = $this->crm->get_all_tasks($id,'C',10,1);

                $this->_data['call_recordings'] = $this->crm->get_share_recordings($this->_parent_users, $id, 10);

				//$this->_data['emails_list'] = $this->crm->get_scheduled_contact_emails($id,10);

				$html = $this->load->view('crm/contact-view-childs-top', $this->_data,true);

				echo $html;

				exit;	

		   }

		   //Add Contact Records to List

		   $this->add_Records_to_List();

		   //Mailchimp

		   $this->mailchimp_contactview();





		}



		$breadcrumbs = array();

		$contactsurl = "crm/contacts/target";



		if($pam3=="all") {$contactsurl = "crm/contacts/all";$breadcrumbs[] = array('label'=>'All Contacts','url'=>base_url('crm/contacts/all'));$this->_data['listall'] = 'yes';}



		else if($pam3=="my") {$contactsurl = 'crm/contacts/my';$breadcrumbs[] = array('label'=>'My Contacts','url'=>base_url('crm/contacts/my'));$this->_data['mine'] = 'yes';}



		else $breadcrumbs[] = array('label'=>'Target Contacts','url'=>base_url('crm/contacts/target'));



		//Get graph data



		if($this->input->post('action')=="graph") {



			$this->ppChartData($this->input->post('cid'),'C',$this->input->post('gft'));



			echo $this->_data['chartData'];



			exit;



		}



		//delete all		



		if($this->input->post('action')=="deleteall") {			



			$record=$this->input->post('recids');



			if($record) {



				foreach($record as $rcid) $this->crm->delete_contact($rcid);



			}



			redirect(current_url());



		}



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$record = $this->crm->get_contact($id,$this->_parent_users);



			if(!$record) redirect(base_url() . 'crm/contacts/all');



			$this->crm->delete_contact($id);



			redirect(base_url() . 'crm/contacts/all'); 



		}



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view" || $pam3=="clone")) {



			$id = (int)$pam4;



			$record = $this->crm->get_contact($id,$this->_parent_users);//echo "<pre>";print_r($record);exit;



			if(!$record) redirect(base_url() . 'crm/contacts');

			

			

			//Send to Salesforce



			if($pam5=="send") {



				$this->_data['sfMode']="cr-$id";



				$this->_data['sfRecord']=$record;



				$this->salesforce();



			}

			else if($pam5) {

				$this->crm->delete_category_records($pam5,$id);

				redirect(base_url('crm/contacts/view/'.$id));

			}





			//custom fields



				/* 	//print_r($res);



					 $where['user_id'] =$record['userid'];



					$where['field_type'] = 'custom';



					$user_info = $this->home->getUserData($where);



					if($user_info) $user_info = $user_info[0];



					$custom = array();



					if(isset($user_info->value)) {



						$custom=unserialize($user_info->value);



						if(isset($custom['kcount'])) unset($custom['kcount']);



					}



					$this->_data['custom']=$custom;*/



			if((int)$record['birthdate']) $record['birthdate']=date("m/d/Y",strtotime($record['birthdate']));



			else $record['birthdate']="";



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			

			

			$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);

			$campaign_id = $active_campaign_data->campaign_id;

			$primary_script = $this->campaign->get_primary_script($campaign_id);

			$template_info = $this->campaign->get_template($primary_script['value']->temp_id);

			

			

			$slug = $template_info[0]->temp_slug;

			

			if($slug!='') $slug = $slug;

			else {

				$block = 'Sales Scripts';

				$alletemplates=$this->campaign->get_alltemplates($block);

				$slug = $alletemplates[0]->temp_slug;

			}

			

			$record['slug']=$slug;



			$this->_data['record'] = $record;



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts/my'));



			$breadcrumbs[] = array('label'=>ucfirst($record[user_first].' '.$record[user_last]),'url'=>base_url('crm/contacts/view/'.$id));



			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');



			//Quick Update Contact record



			$this->quick_update_contact($id);

			$this->update_record_catlist($id,1);			



		}



		//Account contact



		if((int)$pam4 && $pam3=="account") {



			$account_id = (int)$pam4;



			$arecord = $this->crm->get_account($account_id);



			if(!$arecord) redirect(base_url() . 'crm/accounts');



			$record['account_title']=$arecord['account_name'];



			$record['account_id']=$account_id;						



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);



			$this->_data['record']=$record;



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts/my'));



			$breadcrumbs[] = array('label'=>ucfirst($arecord[account_name]),'url'=>base_url('crm/accounts/view/'.$account_id));



			$pam3="edit";



			$pam4='';



		}



		$this->_data['breadcrumbs']=$breadcrumbs;



		



		//Import & Mapping



		if($pam3=="import" && $pam4=="map") {



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>'Import','url'=>base_url('crm/contacts/import'));



			$breadcrumbs[] = array('label'=>'Mapping','url'=>base_url('crm/contacts/import/map'));



			$parent_section = "contacts";



			$filename = $this->session->userdata('import_data');



			if(!$filename || !file_exists($filename)) redirect(base_url() . 'crm/contacts');



			$ext = substr(strrchr($filename,'.'),1);



			$rowdata = array();



			$this->load->helper('scripts');



			$table_fields = import_fields('contact');



			$this->_data['table_fields']=$table_fields;



			$save=0;



			if($this->input->post('action')=="save") $save=1;



			$header = array();

			$arr_data = array();



			$header2 = array();

			$exrows2 = array();

			$keys2 = array();

			$keys3 = array();



			$this->_data['file_ext']=$ext;



			if($ext=="xls" || $ext=="xlsx") {



				$this->load->library('excel');



				// Use PCLZip rather than ZipArchive

				PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

				$objPHPExcel = PHPExcel_IOFactory::load($filename);



				$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();

				$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();

				$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);



				if($lastRow<=1) $ermsg = "No data in Excel file";	



				if($ermsg=="") {					

					$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

					//get header

					$row=1;

					$alphno = 65;

					for($col = 0; $col<$colNumber;$col++) {

						$header2[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

						$alphabet = chr($alphno++);

						$keys2[] = $alphabet;

						//$keys3[$alphabet] = $col;

					}

					$row=2;

					for($col = 0; $col<$colNumber;$col++) {

						$exrows2[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

					}

					$rowdata = array('header'=>$header2,'values'=>$exrows2); 

					//$arr_data = $exrows;

					$this->_data['rowsdata']=array("keys"=>$keys2,"values"=>$header2,"rows"=>$exrows2,'total'=>$lastRow);

				}



			} else {



				$this->load->library('parsecsv');



				$csv = new Parsecsv();



				$csv->auto($filename);



				$csvdata = $csv->data;



				if($csvdata) {



					$header = $csvdata[0];



					$rowdata['header'] = $header;



					$lastRow = count($csvdata);



					if($save) $rowdata['values'] = $csvdata;



					else $rowdata['values'] = $csvdata[0];



					$column_keys = array_keys($header);



					$column_heads = $column_keys;



					$this->_data['rowsdata']=array("keys"=>$column_keys,"values"=>$column_heads,"rows"=>$rowdata['values'],'total'=>$lastRow);



				}



			}



			$er = array();



			//mapping



			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'mapping';



			$this->_data['userinfo'] = $this->home->getUserData($where);



			$this->session->set_userdata('cimport_no', 0);

			$_SESSION['cimport_no_2']=0;



			



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');

				//Category List ID

				$records_listid = (isset($record['listid']) && $record['listid'])?$record['listid']:0;



				$er = array();



				$tbcol = array_filter($record['tbcol']);



				if(!$tbcol) $er['file']="Select contact fields";



				if(!$er && false) {



					//Saving Contacts



					//echo "<pre>";



					//print_r($record);



					//Selected mapping fields



					$tabcols = array();



					foreach($record['tbcol'] as $ki=>$kv) {



						if(!$kv) continue;



						$tabcols[$kv]=$record['excol'][$ki];



					}



					//print_r($tabcols);



					//Target Contact



					if(isset($record['target'])) $target=1; else $target=0;



					//Target Account



					if(isset($record['target_account'])) $target_account=1; else $target_account=0;



					//Assign Record Owner



					if(isset($record['share_user_id']) && $record['share_user_id']) $record_owner=$record['share_user_id']; 



					else $record_owner=$this->_user_id;



					$adr = array('street','city','state','zipcode','country');



					//Contact rows



					foreach($rowdata['values'] as $fval) {						



						$tbval = array();



						$address = array();



						$custom=array();



						$tab_account_name = '';



						foreach($tabcols as $ci=>$cv) {



							if(empty($fval["$cv"])) continue;



							//custom



							if(substr($ci,0,5)=="field"){



								$custom[$ci]=$fval["$cv"]; 



								continue;



							}



							if($ci=="account") $tab_account_name = $fval["$cv"];



							else if(in_array($ci,$adr)!==false) $address[$ci]=$fval["$cv"];



							else $tbval[$ci]=$fval["$cv"];



						}



						if(!$tbval) continue;						



						$tbval['create_date']=date("Y-m-d H:i:s");



						$tbval['modify_date']=date("Y-m-d H:i:s");



						if(!empty($tbval['birthdate'])) {



							$tmpdate = explode("/",$tbval['birthdate']);//m/d/y-012



							$tbval['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



						}



						//Target Contact



						if($target) $tbval['target']=1; else 



						if($tbval['target']) {



							if((int)$tbval['target'] || strtolower($tbval['target'])=="y" || $tbval['target']=="YES") $tbval['target']=1;



						} else unset($tbval['target']);



						$tbval['share_user_id']=$record_owner;



						//Contact Account



						if($tab_account_name) {



							$tab_account_id=0;



							$account_info = $this->crm->search_account(array('account_name',$tab_account_name,$this->_parent_users));



							if($account_info) {



								$tab_account_id = $account_info['account_id'];



							} else {



								$tab_account = array();



								$tab_account['account_name']=$tab_account_name;



								if($target_account) $tab_account['target']=$target_account;



								$tab_account['share_user_id']=$record_owner;



								$tab_account['create_date']=date("Y-m-d H:i:s");



								$tab_account['modify_date']=date("Y-m-d H:i:s");								



								$tab_account_id = $this->crm->save_account($tab_account,0);



								//echo " Ac: ".$this->db->last_query();



							}



							$tbval['account_id']=$tab_account_id;



						}



						//print_r($tbval);

						//verify unique email address

						$redID = 0;

						if($tbval['email']) {

							$email_info = $this->crm->search_contact(array('email',$tbval['email'],$this->_parent_users));

							if($email_info) {

								$redID = $email_info['contact_id'];

								$tbval = array_filter($tbval);

							}	

						}

						



						$cid = $this->crm->save_contact($tbval,$redID);



						//echo " C: ".$this->db->last_query();



						//custom



						if($cid){

							//Category List ID & assign record to list

							if($records_listid) {

								$exist_record = $this->crm->get_category_record($records_listid,$cid);

								if(!$exist_record) {

									$info = array('category_id'=>$records_listid,'record_id'=>$cid);

									$this->crm->save_category_record($info,$id);	

								}

								

							}

							foreach($custom as $ci=>$cv) {



								$ecdata = array('section'=>'C','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv);



								$this->crm->save_custom_record($ecdata);



							}



						}



						//Address



						if($cid && $address) {



							$address['parent_id']=$cid;



							$address['adr_type']='amail';



							$address['parent_type']='C';



							$this->crm->save_address($address);



							//echo " Adr: ".$this->db->last_query();



						}



					}



					



					//mapping



						if(isset($record['mapping'])){



							$where = array();



							$where['user_id'] = $this->_user_id;



							$where['field_type'] = 'mapping';



							$user_info = $this->home->getUserData($where);



							$data = array();



							$headers=$rowdata['header'];



							//echo"headers"; print_r($headers);



							//echo "tbcols"; print_r($tabcols);



							foreach($tabcols as $key=>$value){



								$exheaders[$value]=$headers[$value];



							}



							$data1['val'] = $tbcol;



							$data1['excel']=$tabcols;



							//print_r($tbcol);



							//print_r($exheaders);



							//exit;



							//print_r($tabcols);



							$data1['headers']= $exheaders;



							$data['value']=serialize($data1);



							



							//print_r($data);



							if($user_info) $this->home->saveUserData($data,$where);



							else {



								$data['user_id'] = $this->_user_id;



								$data['field_type'] = 'mapping';



								//$data['value']=$data['data'];



								



								$this->home->saveUserData($data);



							}



						}



						//mapping



					//echo "</pre>";



					unlink($filename);



					$this->session->unset_userdata('import_data');



					redirect(base_url() . 'crm/contacts/my');



				}



				$this->_data['record']=$record;



				$this->_data['error']=$er;



			}			



			if(!$rowdata) $er[]="There is no rows in file.";			



			if(!$table_fields) $er[]="Contacts Structure not found";



			if($er) $this->_data['error']=$er;



			$this->_data['mapping']="yes";



			$this->_data['ext']=$ext;



			$this->_data['parent_section']=$parent_section;



			$this->_data['breadcrumbs']=$breadcrumbs;



			//Assign Record Owner



			$this->_data['dropdown_users'] = $this->crm->get_all_shared_users($this->_parent_users);

			//Category List ID

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));



			//Interaction for Contacts imported

			$this->_data['CustObjections'] = $this->crm->get_objections('Y');

			//Objections from Objection Map which are newly entered by user

			$this->_data['ObjectionsCampaign'] = $this->crm->get_objection_Campaign();

			$this->load->helper('scripts');

			$categories = crm_introptions();

			$this->_data['categories'] = $categories;

			if(isset($_SESSION['cimport_interaction'])) unset($_SESSION['cimport_interaction']);



			$this->load->view('crm/contacts-import', $this->_data);



		}



		//import



		else if($pam3=="import") {



			$filename = $this->session->userdata('import_data');



			if($filename && file_exists($filename)) unlink($filename);



			$this->session->unset_userdata('import_data');



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>'Import','url'=>base_url('crm/contacts/import'));



			$parent_section = "contacts";



			//Salesforce Import



			if($pam4=="salesforce") {



				$breadcrumbs[] = array('label'=>'Salesforce','url'=>base_url('crm/contacts/import/salesforce'));



				$this->_data['sfMode']="c";



				//Import Salesforce Contacts



				if($this->input->post('btn_rcimport')=="Import Records") $this->_data['importMode']=1;



				//Salesforce checker



				if($this->input->post('btn_disconnect')<>"Disconnect") $this->salesforce();



				//Import Salesforce Contacts



				if($this->input->post('btn_rcimport')=="Import Records") {



					$this->import_salesforce_Contact();



				} else if($this->input->post('btn_disconnect')=="Disconnect") {



					unset($_SESSION['templatename']);					



					unset($_SESSION['bcrmlog']);



					unset($_SESSION['bcrmlogrc']);



					unset($_SESSION['crmlog']);



					unset($_SESSION['crmlogrc']);



					unset($_SESSION['access_token']);



					unset($_SESSION['instance_url']);



					unset($_SESSION['issued_at']);



					unset($_SESSION['signature']);



					unset($_SESSION['id']);



					unset($_SESSION['scope']);



					unset($_SESSION['token_type']);



					unset($_SESSION['expires']);



					unset($_SESSION['instance']);



					unset($_SESSION['ws_namespace']);



					unset($_SESSION['ws_endpoint']);



					unset($_SESSION['ws_name']);



				}	



			}



			//End of Salesforce Contacts Imports



			if($this->input->post('action')=="save") {



				$er = array();



				if(empty($_FILES['import_file']['name'])) $er['file']="CSV or Excel required";



				if(!$er) {



					$config['upload_path'] = './import/';



					$config['allowed_types'] = 'csv|xls|xlsx';



					$config['max_size'] = '2048000';



					//$ext = end(explode(".", $_FILES['import_file']));



					$config['file_name'] = $this->_user_id."_4".basename($_FILES['import_file']);



					$this->load->library('upload', $config);



					if ( ! $this->upload->do_upload('import_file')) {



						$er = array('error' => $this->upload->display_errors());



						//$this->_data['error']=$error;



						//$this->load->view('upload_form', $error); 



					} else { 



						$data = $this->upload->data();



						//$this->_data['updata']=$data;



						//$ext = strtolower($data['file_ext']);



						//$this->_data['ext']=substr($ext,1);



						$filename = $data['full_path'];



						//$file_data = array("ext"=>$this->_data['ext'],"file"=>$filename);



						//$file_data = $filename;



						$this->session->set_userdata('import_data', $filename);



						redirect(base_url() . 'crm/contacts/import/map');



					}



				}



				$this->_data['error']=$er;



			}



			$this->_data['parent_section']=$parent_section;



			$this->_data['breadcrumbs']=$breadcrumbs;



			//Assign Record Owner

			$this->_data['dropdown_users'] = $this->crm->get_all_shared_users($this->_parent_users);

			//Category List ID

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));



			//get mailchimp contact lists

			$this->mailchimp_methods('lists');



			$this->load->view('crm/contacts-import', $this->_data);



		} else if($pam3=="edit" || $pam3=="clone") {

		

			if($pam3=="edit") $id = (int)$pam4;	

			if($pam3=="clone") $id = 0;



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts/my'));



			if($pam3=="clone") $breadcrumbs[] = array('label'=>'Clone');

			else $breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['user_first'])) $er['user_first']="User first name required";



				if(empty($record['user_last'])) $er['user_last']="User last name required";



				if(!empty($record['email'])) {



					$this->load->helper('email');



					if (!valid_email($record['email'])) $er['email']="Enter valid email address";

					else {

						//verify unique email address

						//Email existance in Organisation

						//$email_info = $this->crm->search_contact(array('email',$record['email'],$this->_parent_users));

						//$own = implode(",", $this->_parent_users_all);

						//$ownq = " AND userid IN ($own)";

						$email_info = $this->crm->get_acRecord_updated("LOWER(email)='".strtolower($record['email'])."'",'contact_id,userid','C');

						if($email_info) {

							//Email existance in Organisation

							if($this->_user_id<>$email_info['userid']) $er['email']="A contact with that email address already exists in the database and is currently assigned to another user.";

							else if($email_info['contact_id']<>$id) $er['email']="Contact already exists with that email address.";

						}

					}



				}



				if($id && $id==$record['report_id']) $er['report_id']="A contact must report to a different contact";



				if(!$er) {



					$address1 = $record['amail'];



					$address2 = $record['other'];



					//Account Creation



					if(!$record['account_id'] && $record['account_title']) {



						$account_info = $this->crm->search_account(array('account_name',$record['account_title'],$this->_parent_users));



						if($account_info) {



							$record['account_id'] = $account_info['account_id'];



						} else {



							$tab_account = array();



							$tab_account['account_name']=$record['account_title'];



							$tab_account['share_user_id']=$this->_user_id;



							$tab_account['create_date']=date("Y-m-d H:i:s");



							$tab_account['modify_date']=date("Y-m-d H:i:s");								



							$record['account_id'] = $this->crm->save_account($tab_account,0);



						}



					}



					//custom fields



					$custom_values=$record['custom'];



					unset($record['custom']);



					



					unset($record['amail']);



					unset($record['other']);



					unset($record['account_title']);



					unset($record['report_title']);



					unset($record['share_user_title']);



					if(!$id) $record['create_date']=date("Y-m-d H:i:s");



					$record['modify_date']=date("Y-m-d H:i:s");



					if(!empty($record['birthdate'])) {



						$tmpdate = explode("/",$record['birthdate']);//m/d/y-012



						$record['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					}



					$record['target']=$record['target']?1:0;



					$cid = $this->crm->save_contact($record,$id);



					if($cid) {



						//custom fields



						//$custom_values = array_filter($custom_values);



						foreach($custom_values as $ci=>$cv) {



							/*if($cv!=""){*/



								$ecdata = array('section'=>'C','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv);



								$this->crm->save_custom_record($ecdata);



							/*}



							else{



								$ecdata = array('section'=>'C','recid'=>$cid,'ckey'=>$ci);



								$this->crm->delete_custom_record($ecdata);



							}*/



						}						







						$this->crm->delete_address($id,'C');



						$address1 = array_filter($address1);



						if($address1) {



							$address1['parent_id']=$cid;



							$address1['adr_type']='amail';



							$address1['parent_type']='C';



							$this->crm->save_address($address1);



						}



						$address2 = array_filter($address2);



						if($address2) {



							$address2['parent_id']=$cid;



							$address2['adr_type']='other';



							$address2['parent_type']='C';



							$this->crm->save_address($address2);



						}



					}



					if($account_id) redirect(base_url() . 'crm/accounts/view/'.$account_id);



					else redirect(base_url() . 'crm/contacts/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			if(!$record['share_user_title']) {



				$record['share_user_id']=$this->_user_id;



				$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



				$record['share_user_title']=ucfirst($sUser[0]->usrname);



			}



			$this->_data['record']=$record;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$this->load->view('crm/contact-edit', $this->_data);



		}



		else if($pam3=="view") {

			//Mailchimp

			//$this->mailchimp_contactview();

			

			//Prospect Points



			$total_points = $this->crm->get_totalpoints_count($id,'C');



			if($total_points[ipt]<>NULL) {



				$this->_data['total_points'] = $total_points;



				$this->ppChartData($id,'C');



			}



			/*$this->_data['notes_list'] = $this->crm->get_all_notes($id,'C',10);



			$this->_data['docs_list'] = $this->crm->get_all_docs($id,'C',10);



			$this->_data['oppty_list'] = $this->crm->get_contact_relatedto($id,'C');



			$this->_data['otasks_list'] = $this->crm->get_all_tasks($id,'C',10,2);



			$this->_data['atasks_list'] = $this->crm->get_all_tasks($id,'C',10,1);



			$this->_data['emails_list'] = $this->crm->get_scheduled_contact_emails($id,10);*/



			//Category List

			$this->_data['catg_list'] = $this->crm->get_categories_attached($id,1);

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));

			$checked_catg = array();

			if($this->_data['catg_list'])

				foreach($this->_data['catg_list'] as $ecatval) $checked_catg[]= $ecatval->id;

			$this->_data['checked_catg'] = $checked_catg;

			

			//Contact New View Layout

			$this->load->helper('scripts');

			$layout_fields = layout_fields();

			//Contacts Custom Fields

			$contact_customField_values = array();

			if($this->_data['custom']) {

				$customNum = $this->_data['customNum']?$this->_data['customNum']:array();

				foreach($this->_data['custom'] as $ck=>$cv) {

					$layout_fields[$ck]=array('label'=>$cv,'type'=>'custom','num'=>(in_array($ck,$customNum)!==FALSE?'Y':'N'));

				}

				//seperate contact custom fields by key wise

				if($record['custom']) {					

					foreach($record['custom'] as $cval) $contact_customField_values[$cval['ckey']] = $cval;

				}

			}

			$this->_data['contact_customField_values']=$contact_customField_values;

			$this->_data['layout_fields']=$layout_fields;	



			//User fields

			$where = array();

			//$where['user_id'] = $this->_user_id;

			$where['user_id']= isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;

			$where['field_type'] = 'layout';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$layout_keys = array_keys($layout_fields);

			$contact_fields = $layout_keys;

			if(isset($user_info->value) && $user_info->value) {

				$contact_fields=json_decode($user_info->value);

				$contact_fields = (array)$contact_fields;

			}

			$this->_data['contact_fields']=$contact_fields;

			$layout_keys = array_diff($layout_keys, $contact_fields);

			$this->_data['layout_keys']=$layout_keys;



			//end of Contact New View Layout			



			$this->load->view('crm/contact-view', $this->_data);



		}	



		else {

			



			$target=1;



			$owner=$this->_user_id;



			if($pam3=="all") {$owner=0;$target=0;}



			else if($pam3=="my") $target=0;



			//$this->_data['contacts'] = $this->crm->get_all_contacts($owner,$target,$this->_parent_users);



			//$this->load->view('crm/contacts-list', $this->_data);



			//Search & Pagination

			$pgoffset = $this->input->get('per_page')?$this->input->get('per_page'):0;

			$skey = $this->input->get('search')?$this->input->get('search'):'';

			//Sorting

			$sortcol = $this->input->get('col')?$this->input->get('col'):'';

			$sortval = $this->input->get('sort')?$this->input->get('sort'):'';

			$sortfields = array('name'=>'c.user_first','title'=>'c.user_title','account'=>'a.account_name','phone'=>'c.phone','email'=>'c.email','qp'=>'qpoints');

			if($sortcol && isset($sortfields[$sortcol])) {

				$sortcol2 = $sortfields[$sortcol];

				$sortval2 = $sortval=='desc'?'desc':'asc';

			} else {

				$sortcol2='';

				$sortval2='';

			}

			$this->_data['sortcol'] = $sortcol;

			$this->_data['sortval'] = $sortval;

			

			$qsearch = "";

			$sparam = "";

			$acsq = "";

			

			if($this->input->get('col') && $this->input->get('sort'))

			{

				$acsq .= " ORDER BY ".$this->input->get('col')." ".$this->input->get('sort');

			}

			

			

			/*------------------------------------------------------NEW CODE SATART----------------------------*/

			

			

			if($skey) {

				$skey_parts = explode(" ",$skey);

				$ik = 0;

					foreach($searchfields as $kk => $sval) { 

					$ik = $ik + 1;

							 if($kk == 'target' || $kk =='linkedin' || $kk =='birthdate' || $kk =='website' || $kk =='lead_source' || $kk =='user_title' || $kk =='department' || $kk =='create_date' || $kk =='mobile' || $kk =='phone'  || $kk == 'assistant' || $kk =='unsubscribed' || $kk =='email' || $kk =='asst_phone' || $kk =='other_phone' || $kk =='description' || $kk =='ipoints' || $kk =='ppoints'){

							  if($qsearch) $qsearch .= " OR ";

							$qsearch .= "  c.".$kk." like '%$skey%'  ";	   

					} 

					

				 else if($kk == 'user_first'){

			   if($qsearch) $qsearch .= " OR ";

			   $qsearch .= " CONCAT( u.user_first,  ' ', u.user_last ) LIKE  '%$skey%' ";

			 }
			 
			 else if($kk == 'user_first'){

			   if($qsearch) $qsearch .= " OR ";

			   $qsearch .= " CONCAT( c.user_first,  ' ', c.user_last ) LIKE  '%$skey%' ";

			 }

			 

			 else if($kk == 'account_id'){

			  //if($qsearch) $qsearch .= " OR ";

			   //$qsearch .= "  ca.account_id LIKE  '%$skey%' ";

			 }

			 

			 else if($kk == 'address'){

			  if($qsearch) $qsearch .= " OR ";

			   $qsearch .= "  cad.address LIKE  '%$skey%' ";

			 }     

			 

			  else if($kk == 'first_name'){

				if($qsearch) $qsearch .= " OR ";

			   $qsearch .= "  first_name LIKE  '%$skey%' ";

			 }

			 

			   else if($kk == 'report_id'){

				if($qsearch) $qsearch .= " OR ";

			   $qsearch .= "  report_id LIKE  '%$skey%' ";

			 } 

			 

			 else {

			   if($qsearch) $qsearch .= " OR ";

				// $sel_q .= ' (SELECT cval FROM crm_custom_values  where ckey="'.$val.'" and section="C" and recid=c.contact_id) as '.$kk;

				 // if($qsearch) $qsearch .= " OR ";

			  // $qsearch .= "  ".$kk." LIKE  '%$skey%' ";

				$qsearch .= " cv$ik.cval LIKE  '%$skey%' ";

			 } 

				}

				

				/*foreach($skey_parts as $skpart) {

					if($qsearch) $qsearch .=" OR ";

					$qsearch .= " c.user_first like '%$skpart%' OR c.user_last like '%$skpart%' OR c.user_title like '%$skpart%' OR c.phone like '%$skpart%' OR c.email like '%$skpart%' ";

					

				}*/

				//$qsearch = " c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

			////	$qsearch = " CONCAT( c.user_first,  ' ', c.user_last ) LIKE  '%$skey%'  OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

				  

			

				// echo $qsearch;

				 

				 

				//$qsearch =  " c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

				if($qsearch) $qsearch =" ($qsearch) ";

				//$qsearch = "(c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%')";

				$sparam = "search=$skey";

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="&col=".$this->input->get('col')."&sort=".$this->input->get('sort');

			}

			

			if(!$skey){

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="col=".$this->input->get('col')."&sort=".$this->input->get('sort');

			}

			

			$ff_Results = $this->crm->get_all_contacts_total_latest($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,0,$sortcol2,$sortval2);

			

			//echo '<pre>'; print_r($ff_Results); echo '</pre>';

			//exit;

			

			/*------------------------------------------------------NEW CODE ENDS------------------------------*/

		

		

			//$total_records = $this->crm->get_all_contacts_total($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset);

			

			$total_records = $ff_Results['num_results'];



			$this->load->library('pagination');

			$perpage = 50;

			$config['base_url'] = base_url($contactsurl)."/?".$sparam;

			$config['total_rows'] = $total_records;

			$config['per_page'] = $perpage;

			//$config['uri_segment'] = 3;

			$config['num_links'] = 5;

			$config['page_query_string'] = TRUE;

			$this->pagination->initialize($config);



			/*$this->_data['records_info'] = "";					

			$this->_data['contacts'] = array();

			if($total_records) {

				$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

				if($to2>$total_records) $to2 = $total_records;

				$this->_data['contacts'] = $this->crm->get_all_contacts($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,0,$sortcol2,$sortval2);

				$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

			}*/

			

			

			/*----------------------------------------------------NEW CODE START----------------------------------------------*/

			

			

			//Custom Fields

			

			//Custom Fields

			//Contacts

			$where = array();

			 $custom_field_labels  = array();

			$where['user_id'] = $this->_user_id;

			$where['field_type'] = 'custom';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$custom = array();

			if(isset($user_info->value)) {

				$custom=unserialize($user_info->value);	

			}

			if($custom) {

				foreach($custom as $ck=>$cv) $layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

			} 

			

			 $custom_field_labels = $layout_fields;

			 

			 



			$this->_data['records_info'] = "";					

			$this->_data['contacts'] = array();

			 

			

			if($total_records) {

				$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

				if($to2>$total_records) $to2 = $total_records;

				//$resval = $this->crm->get_all_contactslist($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,0,$sortcol2,$sortval2);

				//$this->_data['contacts'] = $resval['rowres'];

				//$this->_data['selectedcolumns'] =  $resval['contact'];

				$this->_data['contacts'] = $ff_Results['rowres'];

				

			/*	echo "<pre>";

				   print_r($ff_Results['contact']); 

				echo "</pre>"; */

				

				

				/*		echo "<pre>";

				   print_r($ff_Results['rowres']); 

				echo "</pre>";*/

				

				//exit;

				

				$frow = array();

				foreach($ff_Results['rowres'] as $kk => $crow)  {

				$ref_id = $crow->contact_id;

				$crow = json_decode(json_encode($crow), true);

				$selectedcolumns = $ff_Results['contact'];

				//echo '<pre>'; print_r($selectedcolumns); echo '</pre>'; exit;

				 foreach($selectedcolumns  as $selk => $selval){

					if (array_key_exists($selk, $crow)) {

				}

				 else {

				  $crow[$selk] = "";

				 }

				} 

				

				

				

				$tempcrow = array();

				foreach($selectedcolumns as $kc => $kv){

				  $tempcrow[$kc] =  $crow[$kc];

				 

				}

				$tempcrow['contact_id'] = $ref_id;

			

				foreach($tempcrow as $key => $val) { 

					

				// echo $key."<br/>";

				

				 /*  if($key == 'target' || $key =='linkedin' || $key =='birthdate' || $key =='website' || $key =='lead_source' || $key =='user_title' || $key =='department' || $key =='create_date' || $key =='mobile' || $key =='phone' || $key =='assistant' || $key =='unsubscribed' || $key =='email' || $key =='asst_phone' || $key =='other_phone' || $key =='description' || $key =='ipoints' || $key =='ppoints' || $key == 'account_id' || $key == 'address' || $key == 'first_name' || $key == 'report_id' || $key = 'user_first') { 

					   echo "YYYYYYYYYYYYY";

				 

				} */

				if($key == 'contact_id'){

				  $tempcrow[$key] = $ref_id;

				}

				else if($key == 'target'|| $key =='linkedin' || $key =='birthdate' || $key =='website' || $key =='lead_source' || $key =='user_title' || $key =='department' || $key =='create_date' || $key =='mobile'|| $key =='phone' || $key =='assistant' || $key =='unsubscribed' || $key =='email' || $key =='asst_phone' || $key =='other_phone' || $key =='description' || $key =='ipoints' || $key =='ppoints' || $key == 'share_user_title' || $key == 'account_id'  || $key == 'address' || $key == 'first_name' || $key == 'report_id' || $key == 'user_first') { 

					   

				 

				} else {

				

				  $rces  = get_custom_fields($key,$ref_id);

				  

				 //echo '<pre>'; print_r( $rces ); echo '</pre>'; 

				

				  $tempcrow[$key] = $rces[0]->cv;

				

				}

				}

				  $frow[] = $tempcrow;

				} 

				 

		

				$this->_data['contacts'] = $frow;

				$this->_data['selectedcolumns'] =  $ff_Results['contact'];

				$this->_data['columnlabels'] =  col_fields();

				$this->_data['contact_customField_values'] =  $custom_field_labels;

				$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

				

				//echo '<pre>'; print_r($this->_data); echo '</pre>';

			}

			

			

			

			/*----------------------------------------------------NEW CODE END-------------------------------------------------*/

			

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));

			if($mpaged == 1)

				$this->load->view('crm/contacts-ajax-list', $this->_data);

			else

				$this->load->view('crm/contacts-list', $this->_data);



		

		}



	}



	//Quick update contact



	function quick_update_contact($id) {



	



		if($this->input->post('action')<>"update") return;



		



		$json = array();



		$record=$this->input->post('record');



		$eblock=$this->input->post('eblock');



		//$record=array_filter($record);



		$erecord=$record;



		



		if($record) {



			$er = array();



			//Name



			if($eblock=="user_first") {



				if(empty($record['user_first'])) $er['user_first']="User first name required";



				if(empty($record['user_last'])) $er['user_last']="User last name required";



			} else {



				unset($record['user_prefix']);



				unset($record['user_first']);



				unset($record['user_first']);



			}



			//Email



			if($eblock=="email") {



				if(!empty($record['email'])) {



					$this->load->helper('email');



					if (!valid_email($record['email'])) $er['email']="Enter valid email address";

					else {

						//verify unique email address

						$email_info = $this->crm->search_contact(array('email',$record['email'],$this->_parent_users));

						if($email_info) {

							if($email_info['contact_id']<>$id) $er['email']="Contact already exists with that email address.";

						}

					}



				}



			} else unset($record['email']);



			//Report to



			if($eblock=="report_id") {



				if($id && $id==$record['report_id']) $er['report_id']="A contact must report to a different contact";	



			} else unset($record['report_id']);



			//Custom



				$custom=$record['custom'];



				unset($record['custom']);



				foreach($custom as $key=>$val){



					$ecdata = array('section'=>'C','recid'=>$id,'ckey'=>$key,'cval'=>$val);



					$this->crm->save_custom_record($ecdata);



				}



			if(!$er) {



				$address1 = $record['amail'];



				//Account Creation



				if(!$record['account_id'] && $record['account_title']) {



					$account_info = $this->crm->search_account(array('account_name',$record['account_title'],$this->_parent_users));



					if($account_info) {



						$record['account_id'] = $account_info['account_id'];



					} else {



						$tab_account = array();



						$tab_account['account_name']=$record['account_title'];



						$tab_account['share_user_id']=$this->_user_id;



						$tab_account['create_date']=date("Y-m-d H:i:s");



						$tab_account['modify_date']=date("Y-m-d H:i:s");								



						$record['account_id'] = $this->crm->save_account($tab_account,0);



					}



					$erecord['account_id']=$record['account_id'];



				}



				unset($record['amail']);



				unset($record['account_title']);



				unset($record['report_title']);



				unset($record['share_user_title']);					



				$record['modify_date']=date("Y-m-d H:i:s");



				if(!empty($record['birthdate'])) {



					$tmpdate = explode("/",$record['birthdate']);//m/d/y-012



					$record['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				}



				$record['target']=$record['target']?1:0;



				$cid = $this->crm->save_contact($record,$id);



				//Mailing Address



				if($cid && $eblock=="address") {



					$this->crm->delete_address($id,'C');



					$address1 = array_filter($address1);



					if($address1) {



						$address1['parent_id']=$cid;



						$address1['adr_type']='amail';



						$address1['parent_type']='C';



						$this->crm->save_address($address1);



					}



				}



			}



			if($er) {



				$json['status']="N";



				$json['error']=implode("<br />",$er);



			} else {



				$string = "";



				if($eblock=="target") {



					$string = $erecord['target']?"1":"0";



				} else if($eblock=="address" && $address1) {



					$address1 = $erecord['amail'];



					$address1 = array_filter($address1);



					$string = implode(", ",$address1);



				} else if($eblock=="user_first") {



					$string = $erecord['user_prefix']." ".$erecord['user_first']." ".$erecord['user_last'];



				} else if($eblock=="account_id" && $erecord['account_id']) {



					$string = '<a href="'.base_url().'crm/accounts/view/'.$erecord['account_id'].'">'.$erecord['account_title'].'</a>';



				} else if($eblock=="report_id") {	



					$string = $erecord['report_title'];



				} else if($eblock=="email" && $erecord['email']) {



					$string = '<a href="mailto:'.$erecord['email'].'">'.$erecord['email'].'</a>';



				} else if($eblock=="linkedin" && $erecord['linkedin']) {



					$string = '<a href="'.$erecord['linkedin'].'" target="_blank">View Profile</a>';	



				} else if($eblock=="website" && $erecord['website']) {







					$string = '<a href="'.$erecord['website'].'" target="_blank">'.$erecord['website'].'</a>';	



				} else if(($eblock=="phone" || $eblock=="asst_phone" || $eblock=="mobile" || $eblock=="other_phone") && $erecord[$eblock]) {



					$string = '<a href="tel:'.$erecord[$eblock].'">'.$erecord[$eblock].'</a>';			



				}else if($eblock=="description" && $erecord['description']) {



					$string = str_replace("\n","<br>",$erecord[description]);		



				} 



				//custom 



				else if(strpos($eblock, 'field') !== false) {

				

					$esval = $erecord[custom][$eblock];

					

					//echo $esval;

					

					

					if(strlen($esval)>15){



						$string=substr($esval,0,15).'...<input type="button" value="See More" onclick="view_column(\''.$eblock.'\');"><span id="'.$eblock.'_hide" style="display:none;">'.$esval.'</span>';   



					 }



					else{



						$string = $esval;



					 }

					 

					 //echo $string;



				/*	$esval = $erecord[custom][$eblock];

					if(in_array($eblock,$this->_data['customNum'])!==FALSE) $esval = number_format(str_replace(",","",$esval));



					if(strlen($esval)>15){



						$string=substr($esval,0,15).'...<input type="button" value="See More" onclick="view_column(\''.$eblock.'\');">



						<span id="'.$eblock.'_hide" style="display:none;">'.$esval.'</span>';   



					 }



					else{



						$string = $esval;



					 }*/



				} 



				else {



					$string = $erecord[$eblock];



				}



				$json['cinfo']=$string;



				$json['status']="Y";



			}	



		} else $json['status']="N";



		echo json_encode($json);



		exit;		



	}



	//Quick update account



	function quick_update_account($id) {



	



		if($this->input->post('action')<>"update") return;



		



		$json = array();



		$record=$this->input->post('record');



		$eblock=$this->input->post('eblock');



		//$record=array_filter($record);



		$erecord=$record;



		



		if($record) {



			$er = array();



			//Name



			if($eblock=="account_name") {



				if(empty($record['account_name'])) $er['account_name']="account_name required";



			} else {



				unset($record['account_name']);



			}



			//Annual Revenue



			if($eblock=="revenue") {



				if(!empty($record['revenue'])) {



					if(!is_numeric($record['revenue'])) $er['revenue']="Annual Revenue Must be number";



				}



			} else {



				unset($record['revenue']);



			}



			//Employees



			if($eblock=="employees") {



				if(!empty($record['employees'])) {



					if(!is_numeric($record['employees'])) $er['employees']="Employees Must be number";



				}



			} else {



				unset($record['employees']);



			}



			//Number of Locations



			if($eblock=="numlocations") {



				if(!empty($record['numlocations'])) {



					if(!is_numeric($record['numlocations'])) $er['numlocations']="Number of Locations Must be number";



				}



			} else {



				unset($record['numlocations']);



			}



			//Parent Account



			if($eblock=="account_parent") {



				if($id && $id==$record['account_parent']) $er['account_parent']="A parent account can't be the child of an account it's already a parent of.";



			} else {



				unset($record['account_parent']);



			}



			//Custom



				$custom=$record['custom'];



				unset($record['custom']);



				foreach($custom as $key=>$val){



					$ecdata = array('section'=>'A','recid'=>$id,'ckey'=>$key,'cval'=>$val);



					$this->crm->save_custom_record($ecdata);



				}



			



			if(!$er) {



				$address1 = $record['billing'];



				$address2 = $record['shipping'];



				unset($record['billing']);



				unset($record['shipping']);



				unset($record['account_title']);



				unset($record['share_user_title']);



				$record['modify_date']=date("Y-m-d H:i:s");



				if(!empty($record['sla_expdate'])) {



					$tmpdate = explode("/",$record['sla_expdate']);//m/d/y-012



					$record['sla_expdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				}



				$record['target']=$record['target']?1:0;



				//$record = array_filter($record);



				$cid = $this->crm->save_account($record,$id);



				//Billing Address



				if($cid && $eblock=="billing") {



					$this->crm->delete_address($id,'A','billing');



					$address1 = array_filter($address1);



					if($address1) {



						$address1['parent_id']=$cid;



						$address1['adr_type']='billing';



						$address1['parent_type']='A';



						$this->crm->save_address($address1);



					}



				}



				//Shipping Address



				if($cid && $eblock=="shipping") {



					$this->crm->delete_address($id,'A','shipping');



					$address2 = array_filter($address2);



					if($address2) {



						$address2['parent_id']=$cid;



						$address2['adr_type']='shipping';



						$address2['parent_type']='A';



						$this->crm->save_address($address2);



					}



				}



			}



			if($er) {



				$json['status']="N";



				$json['error']=implode("<br />",$er);



			} else {



				$string = "";



				if($eblock=="target") {



					$string = $erecord['target']?"1":"0";



				} else if($eblock=="revenue") {



					$string = $erecord['revenue']?"$".$erecord['revenue']:"";	



				} else if($eblock=="billing" && $address1) {



					$address1 = $erecord['billing'];



					$address1 = array_filter($address1);



					$string = implode(", ",$address1);



				} else if($eblock=="shipping" && $address2) {



					$address1 = $erecord['shipping'];



					$address1 = array_filter($address1);



					$string = implode(", ",$address1);	



				} else if($eblock=="phone" && $erecord[$eblock]) {



					$string = '<a href="tel:'.$erecord[$eblock].'">'.$erecord[$eblock].'</a>';			



				} else if($eblock=="account_parent" && $erecord['account_parent']) {



					$string = '<a href="'.base_url().'crm/accounts/view/'.$erecord['account_parent'].'">'.$erecord['account_title'].'</a>';



				} else if($eblock=="website" && $erecord['website']) {



					$string = '<a href="'.(substr($erecord[website],0,4)<>"http"?'http://':'').$erecord['website'].'" target="_blank">'.$erecord['website'].'</a>';



				} else if($eblock=="description" && $erecord['description']) {



					$string = str_replace("\n","<br>",$erecord[description]);		



				}



				//custom



				else if(strpos($eblock, 'field') !== false) {



					$esval = $erecord[custom][$eblock];

					if(in_array($eblock,$this->_data['customNuma'])!==FALSE) $esval = number_format(str_replace(",","",$esval));



					if(strlen($esval)>15){



						$string=substr($esval,0,15).'...<input type="button" value="See More" onclick="view_column(\''.$eblock.'\');">



						<span id="'.$eblock.'_hide" style="display:none;">'.$esval.'</span>';   



					 }



					else{



						$string = $esval;



					 }



				} 



				 else {



					$string = $erecord[$eblock];



				}



				$json['cinfo']=$string;



				$json['status']="Y";



			}



		} else $json['status']="N";



		echo json_encode($json);



		exit;		



	}

	

	

	function salesprospectingdetails()

	{

		$user_id = $_SESSION['ss_user_id'];

		$srecord = $this->crm->get_sprospecting_count($user_id);

		$record=$this->input->post();

		$cid = $this->crm->sales_prospecting($record,$srecord);

	}
	
	
	function spbquestions()
	{
		
		$user_id = $_SESSION['ss_user_id'];
		$all_questions = array();
		$vid = $this->input->post('vid');
		
		//$spbquizdelete= $this->crm->spbquizdelete($vid,$user_id);
		
		$spbquizstatus = $this->crm->spbquizstatus($vid,$user_id);
		$spbquizcnumber = $this->crm->spbquizcnumber($vid,$user_id);
		$spbquizicnumber = $this->crm->spbquizicnumber($vid,$user_id);
		
		
		$type = $this->input->post('type');
		if($type==0)
		{
			$deleteall_qanwers = $this->crm->deleteall_qanwers($user_id,$vid);
		}
		$all_questions = $this->crm->get_all_spbquestions($vid);
		$vtitle = $this->crm->get_videotitle($vid);
		$vtitle = $vtitle[0]->title;
		$content .= "<h1>".$vtitle."</h1>";
		$i=0;
		foreach($all_questions as $key=>$value)
		{
			$i++;
			$content .= "<h3>".$i.") ".$value->title."</h3>";
			$qid = $value->id;
			$all_qanwers = $this->crm->get_all_spbqanswers($qid);
			$email_info = $this->crm->get_checkQuestion($user_id,$qid);
			if($email_info) 
			{
			 $answer = $email_info['answer'];
			 $status = $email_info['status'];
			}
			$content .= "<ul>";
			foreach($all_qanwers as $qkey=>$qvalue)
			{
				if($qvalue->title==$answer && $type==1)
				{
					if($status=='c') $color="green";
					else $color="red";
					$content .= '<li style="color:'.$color.'"><input checked="checked" type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
				else
				{
					$content .= '<li><input type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
			}
			$content .= "</ul>";
		}
		
		if($type==1)
		{
			$content .='<br/><h1 style="text-align: center;font-size: 20px;padding-bottom: 20px;color: green !important;">Summary</h1>';
			$content .='<ul style="text-align:center;font-size:20px;"><li><b style="font-size: 20px;">Correct:</b> <span style="color: green;font-size: 20px;">'.$spbquizcnumber.'</span></li>';
			$content .='<li><b style="font-size: 20px;">Incorrect:</b> <span style="color: red;font-size: 20px;">'.$spbquizicnumber.'</span></li>';
			if($spbquizstatus=="Passed") { $st = "Passed"; $color = "green"; }
			else { $st = "Did not pass"; $color = "red"; };
			$content .='<li><b style="font-size: 20px;">Status:</b> <span style="color: '.$color.';font-size: 20px;">'.$st.'</span></li></ul>';
		}
		
		
		echo json_encode(array('content'=>$content,'status'=>$st));
		exit;
	}
	
	
	
	function sptquestions()
	{
		
		$user_id = $_SESSION['ss_user_id'];
		$all_questions = array();
		$vid = $this->input->post('vid');
		
		//$spbquizdelete= $this->crm->spbquizdelete($vid,$user_id);
		
		$spbquizstatus = $this->crm->sptquizstatus($vid,$user_id);
		$spbquizcnumber = $this->crm->sptquizcnumber($vid,$user_id);
		$spbquizicnumber = $this->crm->sptquizicnumber($vid,$user_id);
		
		
		$type = $this->input->post('type');
		if($type==0)
		{
			$deleteall_qanwers = $this->crm->deleteall_sptqanwers($user_id,$vid);
		}
		$all_questions = $this->crm->get_all_sptquestions($vid);
		$vtitle = $this->crm->get_sptvideotitle($vid);
		$vtitle = $vtitle[0]->title;
		$content .= "<h1>".$vtitle."</h1>";
		$i=0;
		foreach($all_questions as $key=>$value)
		{
			$i++;
			$content .= "<h3>".$i.") ".$value->title."</h3>";
			$qid = $value->id;
			$all_qanwers = $this->crm->get_all_sptqanswers($qid);
			$email_info = $this->crm->get_checksptQuestion($user_id,$qid);
			if($email_info) 
			{
			 $answer = $email_info['answer'];
			 $status = $email_info['status'];
			}
			$content .= "<ul>";
			foreach($all_qanwers as $qkey=>$qvalue)
			{
				if($qvalue->title==$answer && $type==1)
				{
					if($status=='c') $color="green";
					else $color="red";
					$content .= '<li style="color:'.$color.'"><input checked="checked" type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
				else
				{
					$content .= '<li><input type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
			}
			$content .= "</ul>";
		}
		
		if($type==1)
		{
			$content .='<br/><h1 style="text-align: center;font-size: 20px;padding-bottom: 20px;color: green !important;">Summary</h1>';
			$content .='<ul style="text-align:center;font-size:20px;"><li><b style="font-size: 20px;">Correct:</b> <span style="color: green;font-size: 20px;">'.$spbquizcnumber.'</span></li>';
			$content .='<li><b style="font-size: 20px;">Incorrect:</b> <span style="color: red;font-size: 20px;">'.$spbquizicnumber.'</span></li>';
			if($spbquizstatus=="Passed") { $st = "Passed"; $color = "green"; }
			else { $st = "Did not pass"; $color = "red"; };
			$content .='<li><b style="font-size: 20px;">Status:</b> <span style="color: '.$color.';font-size: 20px;">'.$st.'</span></li></ul>';
		}
		
		
		echo json_encode(array('content'=>$content,'status'=>$st));
		exit;
	}
	
	
	function spbquizstatus()
	{
		$user_id = $_SESSION['ss_user_id'];
		$all_questions = array();
		$vid = $this->input->post('vid');
		$spbquizstatus = $this->crm->spbquizstatus($vid,$user_id);
		$spbquizcnumber = $this->crm->spbquizcnumber($vid,$user_id);
		$spbquizicnumber = $this->crm->spbquizicnumber($vid,$user_id);
		
		$all_questions = $this->crm->get_all_spbquestions($vid);
		$vtitle = $this->crm->get_videotitle($vid);
		$vtitle = $vtitle[0]->title;
		$content .= "<h1>".$vtitle."</h1>";
		$i=0;
		
		foreach($all_questions as $key=>$value)
		{
			$i++;
			$content .= "<h3>".$i.") ".$value->title."</h3>";
			$qid = $value->id;
			$all_qanwers = $this->crm->get_all_spbqanswers($qid);
			$email_info = $this->crm->get_checkQuestion($user_id,$qid);
			if($email_info) 
			{
			 $answer = $email_info['answer'];
			 $status = $email_info['status'];
			}
			$content .= "<ul>";
			foreach($all_qanwers as $qkey=>$qvalue)
			{
				if($qvalue->title==$answer && $type==1 || ($qvalue->title==$answer && ($spbquizstatus=="Passed" || $spbquizstatus=="Fail")))
				{
					if($status=='c') $color="green";
					else $color="red";
					$content .= '<li style="color:'.$color.'"><input checked="checked" type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
				else
				{
					$content .= '<li><input type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
			}
			$content .= "</ul>";
		}
		
		$content .='<br/><h1 style="text-align: center;font-size: 20px;padding-bottom: 20px;color: green !important;">Summary</h1>';
		$content .='<ul style="text-align:center;font-size:20px;"><li><b style="font-size: 20px;">Correct:</b> <span style="color: green;font-size: 20px;">'.$spbquizcnumber.'</span></li>';
			$content .='<li><b style="font-size: 20px;">Incorrect:</b> <span style="color: red;font-size: 20px;">'.$spbquizicnumber.'</span></li>';
			if($spbquizstatus=="Passed") { $st = "Passed"; $color = "green"; }
			else { $st = "Did not pass"; $color = "red"; };
			$content .='<li><b style="font-size: 20px;">Status:</b> <span style="color: '.$color.';font-size: 20px;">'.$st.'</span></li></ul>';	
		if($st=="Passed") $content .='<div style="text-align: center;margin: 20px auto;width: 170px !important;float: none;display: block;"><a href="/betapro/folder/sales-prospecting-basics" class="buttonM bGreen">Return to Training</a></div>';
		else $content .='<div style="text-align:center;padding: 20px 20px;"><input type="button" onclick="takeQuiz(0)" class="buttonM bGreen" name="launch" value="Take Quiz"> <a href="/betapro/folder/sales-prospecting-basics" class="buttonM bGreen">Return to Training</a></div>';	
			
		echo json_encode($content);
		exit;
	}
	
	
	
	
	function sptquizstatus()
	{
		$user_id = $_SESSION['ss_user_id'];
		$all_questions = array();
		$vid = $this->input->post('vid');
		$spbquizstatus = $this->crm->sptquizstatus($vid,$user_id);
		$spbquizcnumber = $this->crm->sptquizcnumber($vid,$user_id);
		$spbquizicnumber = $this->crm->sptquizicnumber($vid,$user_id);
		
		$all_questions = $this->crm->get_all_sptquestions($vid);
		$vtitle = $this->crm->get_sptvideotitle($vid);
		$vtitle = $vtitle[0]->title;
		$content .= "<h1>".$vtitle."</h1>";
		$i=0;
		
		//echo "<pre>"; print_r($all_questions); echo "</pre>";
		
		foreach($all_questions as $key=>$value)
		{
			$i++;
			$content .= "<h3>".$i.") ".$value->title."</h3>";
			$qid = $value->id;
			$all_qanwers = $this->crm->get_all_sptqanswers($qid);
			$email_info = $this->crm->get_checksptQuestion($user_id,$qid);
			if($email_info) 
			{
			 $answer = $email_info['answer'];
			 $status = $email_info['status'];
			}
			$content .= "<ul>";
			foreach($all_qanwers as $qkey=>$qvalue)
			{
				if($qvalue->title==$answer && $type==1 || ($qvalue->title==$answer && ($spbquizstatus=="Passed" || $spbquizstatus=="Fail")))
				{
					if($status=='c') $color="green";
					else $color="red";
					$content .= '<li style="color:'.$color.'"><input checked="checked" type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
				else
				{
					$content .= '<li><input type="radio" name="question'.$qvalue->question_id.'" value="'.$qvalue->title.'"/> '.$qvalue->title.'</li>';
				}
			}
			$content .= "</ul>"; 
		}
		
		$content .='<br/><h1 style="text-align: center;font-size: 20px;padding-bottom: 20px;color: green !important;">Summary</h1>';
		$content .='<ul style="text-align:center;font-size:20px;"><li><b style="font-size: 20px;">Correct:</b> <span style="color: green;font-size: 20px;">'.$spbquizcnumber.'</span></li>';
			$content .='<li><b style="font-size: 20px;">Incorrect:</b> <span style="color: red;font-size: 20px;">'.$spbquizicnumber.'</span></li>';
			if($spbquizstatus=="Passed") { $st = "Passed"; $color = "green"; }
			else { $st = "Did not pass"; $color = "red"; };
			$content .='<li><b style="font-size: 20px;">Status:</b> <span style="color: '.$color.';font-size: 20px;">'.$st.'</span></li></ul>';	
		if($st=="Passed") $content .='<div style="text-align: center;margin: 20px auto;width: 170px !important;float: none;display: block;"><a href="/betapro/folder/sales-prospecting-techniques" class="buttonM bGreen">Return to Training</a></div>';
		else $content .='<div style="text-align:center;padding: 20px 20px;"><input type="button" onclick="takeQuiz(0)" class="buttonM bGreen" name="launch" value="Take Quiz"> <a href="/betapro/folder/sales-prospecting-techniques" class="buttonM bGreen">Return to Training</a></div>';	
			
		echo json_encode($content);
		exit;
	}
	
	function submitquestions()
	{
		$allAnswers = $this->input->post();
		$vid = $this->input->post('vid');
		$user_id = $_SESSION['ss_user_id'];
		foreach($allAnswers as $akey=>$aval)
		{
			//echo $akey."<br/>";
			if($akey!='vid') 
			{
				$qid = str_replace("question","",$akey);
				$ans = $aval;
				
				$checkStatus = $this->crm->spb_checkstatus($qid,$ans);
				$status = $checkStatus[0]->status;
				
				$cdata = array();
				$cdata['vid']=$vid;
				$cdata['qid']=$qid;
				$cdata['uid']=$user_id;
				$cdata['answer']=$ans;
				$cdata['status']=$status;
				$cdata['cdtime']=date("Y-m-d H:i:s");
				$cdata['udtime']=date("Y-m-d H:i:s");
				$cdata = array_filter($cdata);
				//verify unique email address
				$econid=0;
				$email_info = $this->crm->get_checkQuestion($user_id,$qid);
				if($email_info) $econid = $email_info['id'];
				$parent_id = $this->crm->save_squestions($cdata,$econid);
			}
		}		
	}

	function submitsptquestions()
	{
		$allAnswers = $this->input->post();
		$vid = $this->input->post('vid');
		$user_id = $_SESSION['ss_user_id'];
		foreach($allAnswers as $akey=>$aval)
		{
			//echo $akey."<br/>";
			if($akey!='vid') 
			{
				$qid = str_replace("question","",$akey);
				$ans = $aval;
				
				$checkStatus = $this->crm->spt_checkstatus($qid,$ans);
				$status = $checkStatus[0]->status;
				
				$cdata = array();
				$cdata['vid']=$vid;
				$cdata['qid']=$qid;
				$cdata['uid']=$user_id;
				$cdata['answer']=$ans;
				$cdata['status']=$status;
				$cdata['cdtime']=date("Y-m-d H:i:s");
				$cdata['udtime']=date("Y-m-d H:i:s");
				$cdata = array_filter($cdata);
				//verify unique email address
				$econid=0;
				$email_info = $this->crm->get_checksptQuestion($user_id,$qid);
				if($email_info) $econid = $email_info['id'];
				$parent_id = $this->crm->save_sptquestions($cdata,$econid);
			}
		}
	}

	

	function salesprospectingtechniquesdetails()

	{

		$user_id = $_SESSION['ss_user_id'];

		$srecord = $this->crm->get_sprospecting_techniques_count($user_id);

		$record=$this->input->post();

		$cid = $this->crm->sales_prospecting_techniques($record,$srecord);

	}



	//Quick update opportunity



	function quick_update_opportunity($id) {



	



		if($this->input->post('action')<>"update") return;



		



		$json = array();



		$record=$this->input->post('record'); 



		$eblock=$this->input->post('eblock');



		$record=array_filter($record);



		$erecord=$record;



		



		if($record) {



			$er = array();



			//Close date



			if($eblock=="close_date") {



				if(empty($record['close_date'])) $er['close_date']="Close date required";



			} else {



				unset($record['close_date']);



			}



			//Opportunity



			if($eblock=="oppt_name") {



				if(empty($record['oppt_name'])) $er['oppt_name']="Opportunity required";



			} else {



				unset($record['oppt_name']);



			}



			//Stage



			if($eblock=="stage") {



				if(empty($record['stage'])) $er['stage']="Stage required";



			} else {



				unset($record['stage']);



			}



			//Amount



			if($eblock=="amount") {



				if(!empty($record['amount'])) {



					if(!is_numeric($record['amount'])) $er['amount']="Amount Must be number";



				}



			} else {



				unset($record['amount']);



			}



			//Probability



			if($eblock=="probability") {



				if(!empty($record['probability'])) {



					if(!is_numeric($record['probability'])) $er['probability']="Probability Must be number";



					else if((float)$record['probability']>100 || (float)$record['probability']<0) $er['probability']="Probability Must be between 0 to 100%";



				}



			} else {



				unset($record['probability']);



			}



			



			if(!$er) {				



				unset($record['account_title']);



				unset($record['contact_title']);



				unset($record['share_user_title']);



				$record['modify_date']=date("Y-m-d H:i:s");



				if(!empty($record['close_date'])) {



					$tmpdate = explode("/",$record['close_date']);//m/d/y-012



					$record['close_date']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				}



				$record['user_private']=$record['user_private']?1:0;



				//$record = array_filter($record);



				$cid = $this->crm->save_opportunity($record,$id);



			}



			if($er) {



				$json['status']="N";



				$json['error']=implode("<br />",$er);



			} else {



				$string = "";



				if($eblock=="private") {



					$string = $erecord['user_private']?"1":"0";



				} else if($eblock=="amount") {



					$string = $erecord['amount']?"$".$erecord['amount']:"";	



				} else if($eblock=="contact_id") {



					$string = $erecord['contact_title'];



					if($erecord['contact_id']) $string = '<a href="'.base_url('crm/contacts/view').'/'.$erecord[contact_id].'">'.$erecord['contact_title'].'</a>';	



				} else if($eblock=="account_id") {



					$string = $erecord['account_title'];



					if($erecord['account_id']) $string = '<a href="'.base_url('crm/accounts/view').'/'.$erecord[account_id].'">'.$erecord['account_title'].'</a>';



				} else if($eblock=="probability") {



					$string = $erecord['probability']?$erecord['probability'].'%':"";



				} else if($eblock=="description" && $erecord['description']) {



					$string = str_replace("\n","<br>",$erecord[description]);		



				} else {



					$string = $erecord[$eblock];



				}



				$json['cinfo']=$string;



				$json['status']="Y";



			}



		} else $json['status']="N";



		echo json_encode($json);



		exit;		



	}



	//Quick update task



	function quick_update_task($id) {



	



		if($this->input->post('action')<>"update") return;



		



		$json = array();



		$record=$this->input->post('record');



		$eblock=$this->input->post('eblock');



		$record=array_filter($record);



		$erecord=$record;



		



		if($record) {



			$er = array();



			//Subject



			if($eblock=="task_subject") {



				if(empty($record['task_subject'])) $er['task_subject']="Subject required";



			} else {



				unset($record['task_subject']);



			}



			//Related To



			if($eblock=="task_relatedto") {



				if(empty($record['related_title'])) $er['related_title']="Related To required";



			} else {



				unset($record['related_title']);



			}



			//email



			if($eblock=="task_email") {



				$this->load->helper('email');



				if (!valid_email($record['task_email'])) $er['task_email']="Enter valid email address";



			} else {



				unset($record['task_email']);



			}			



			if(!$er) {				



				unset($record['related_title']);



				unset($record['share_user_title']);



				$record['task_modified']=date("Y-m-d H:i:s");



				if(!empty($record['task_duedate'])) {



					$tmpdate = explode("/",$record['task_duedate']);//m/d/y-012



					$record['task_duedate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				}



				$record = array_filter($record);



				$cid = $this->crm->save_task($record,$id);



			}



			if($er) {



				$json['status']="N";



				$json['error']=implode("<br />",$er);



			} else {



				$string = "";



				if($eblock=="task_phone" && $erecord['task_phone']) {



					$string = '<a href="tel:'.$erecord['task_phone'].'">'.$erecord['task_phone'].'</a>';



				} else if($eblock=="task_email" && $erecord['task_email']) {



					$string = '<a href="mailto:'.$erecord['task_email'].'">'.$erecord['task_email'].'</a>';



				} else if($eblock=="task_relatedto" && $erecord['task_relatedto']) {



					$string = '<a href="'.base_url().'crm/'.($erecord['task_related']=="C"?'contacts':'accounts').'/view/'.$erecord['task_relatedto'].'">'.$erecord['related_title'].'</a>';



				} else if($eblock=="task_info" && $erecord['task_info']) {



					$string = str_replace("\n","<br>",$erecord[task_info]);	



				} else {



					$string = $erecord[$eblock];



				}



				$json['cinfo']=$string;



				$json['status']="Y";



			}



		} else $json['status']="N";



		echo json_encode($json);



		exit;		



	}



	//Prospect Points



	public function ppChartData_NEW($id,$sect='C',$gft=1)



	{



		$tDt1 = date("Y-m-d");



		$tDt2 = date("Y-m-d");



		$dtF = "j-M";		



		$CreateDate = $tDt1;

		if($sect=='A') 

			$recrow = $this->crm->get_acRecord("account_id=$id",'create_date','A');

		else

			$recrow = $this->crm->get_acRecord("contact_id=$id",'create_date','C');

		if($recrow) {

			$CreateDate = $recrow['create_date'];

		}



		$edate = $CreateDate;

		$rmonth = date("m",strtotime($edate));

		$ryear = date("Y",strtotime($edate));



		$dt1 = date_create(date("Y-m-d",strtotime($edate)));

		$dt2 = date_create(date("Y-m-d"));

		$diff=date_diff($dt1,$dt2);

		$rdays = $diff->format("%a");



		//Timings dropdown

		if(isset($this->_data['record'])) {

			

			$gft=1;			

			if($rdays<=7) $gft = 0;

			else if($rdays>7 && $rdays<=30) $gft = 1;

			else if($rdays>30) $gft = 4;

			if($rdays>120) $gft = 5;

			if($rdays>180) $gft = 6;

			if($rdays>365) $gft = 7;



			$steps=1;

			if($gft==1) $steps=3;

			else if($gft==4 || $gft==5) $steps=15;

			else if($gft==6) $steps=30;

			else if($gft==7) $steps=180;

			$this->_data['sTE']=$steps;



			/*$steps = 1;

			if($rdays<=15) $steps = 1;

			else if($rdays<=30) $steps = 3;

			else if($rdays<=180) $steps = 15;

			else $steps = 30;

			$this->_data['sTE']=$steps;*/



			$dayfilter = '<option value="0">Last 7 Days</option>';

			$dayfilter .= '<option value="1" '.($gft==1?'selected="selected"':'').'>Last 30 Days</option>';

			//$dayfilter .= '<option value="2" '.($gft==2?'selected="selected"':'').'>This Month</option>';

			//if(!($rmonth==date("m") && $ryear==date("Y"))) $dayfilter .= '<option value="3" '.($gft==3?'selected="selected"':'').'>Last Month</option>';

			$dayfilter .= '<option value="4" '.($gft==4?'selected="selected"':'').'>Last 3 Months</option>';

			$dayfilter .= '<option value="5" '.($gft==5?'selected="selected"':'').'>Last 6 Month</option>';

			$dayfilter .= '<option value="6" '.($gft==6?'selected="selected"':'').'>Last 12 Months</option>';

			$dayfilter .= '<option value="7" '.($gft==7?'selected="selected"':'').'>Last 5 Years</option>';

			$this->_data['dayfilter']=$dayfilter;

		} else {

			$timing_dropdown = 1;

			$steps=1;

			/*if($gft==2) {

				if($rdays>15) $sTE=3;

			}*/

			//else if($gft==1 || $gft==3) $sTE=3;			

			if($gft==1) {

				$steps=3;

				//if($rdays>15) $steps=3;

			}

			else if($gft==4 || $gft==5) {				

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else */$steps=15;

			}

			else if($gft==6) {

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else if($rdays<=180) $steps=15;

				else */$steps=30;

			}else if($gft==7) {

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else if($rdays<=180) $steps=15;

				else */

				$steps=180;

			}

			$this->_data['sTE']=$steps;

		}



		//if($gft=='') $gft=1;



		if($gft==1) {//Last 30 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}



		/*else if($gft==2){//This Month - removed

			$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}



		else if($gft==3){//Last Month - removed



			$dtF = "j-M";



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2));



		}*/

		 else if($gft==4){//Last 3 Months



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-3*30*24*60*60);



		} else if($gft==5){//Last 6 Month



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-6*30*24*60*60);



		} else if($gft==6){//Last 12 Months



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-12*30*24*60*60);



		} else if($gft==7){//Last 5 Years



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-5*12*30*24*60*60);

			$dtF = "j-M-Y";

		} else {

			//Last 7 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M-Y";}



		$dtF = "Y,m,d";



		//echo " $tDt1 - $tDt2 :: ";

		//chart start date should not before record created date

		//if(strtotime($CreateDate)>strtotime($tDt1)) $tDt1 = date("Y-m-d",strtotime($CreateDate));



		$y1 =0;



		$y2 = 0;



		$mname = '';



		$dpRec = $this->crm->get_totalpoints_count($id,$sect,"pdate<'$tDt1'");



		if($dpRec) {



			$y1 =$dpRec['ipt']!=NULL?round($dpRec['ipt']):0;



			$y2 = $dpRec['ppt']!=NULL?round($dpRec['ppt']):0;



		}



		//['Day 1', 0, 0]



		$seperator = "@";



		$chartData=array();

		//$chartData[] = array('.', 0, 0);



		//$chartData[] = array('Day', $y1, $y2);			



		$results = $this->crm->get_points_list($id,$sect,"(pdate>='$tDt1' AND pdate<='$tDt2')");



		$tDt1 = strtotime($tDt1);



		$tDt2 = strtotime($tDt2);



		if($results) {



			foreach($results as $c) {



				while($tDt1<strtotime($c->pdate)){



					//$chartData[]= array(date($dtF,$tDt1), $y1, $y2);

					$chartData[]= array('new Date('.date($dtF,$tDt1).')', $y1, $y2);



					$tDt1 = $tDt1+24*60*60;



				}			



				$tDt1=strtotime($c->pdate);



				$tmpmname =date($dtF,$tDt1);				



				$y1 += $c->ipt;



				$y2 += $c->ppt;



				if($mname==$tmpmname) {

					//$chartData[count($chartData)-1]= array($tmpmname, $y1, $y2);

					$chartData[count($chartData)-1]= array('new Date('.$tmpmname.')', $y1, $y2);

				}



				else {

					//$chartData[]= array($tmpmname, $y1, $y2);

					$chartData[]= array('new Date('.$tmpmname.')', $y1, $y2);

				}



				$mname = $tmpmname;



				$tDt1 = $tDt1+24*60*60;



			}



		}



		while($tDt1<=$tDt2){



			//$chartData[]= array(date($dtF,$tDt1), $y1, $y2);

			$chartData[]= array('new Date('.date($dtF,$tDt1).')', $y1, $y2);



			$tDt1 = $tDt1+24*60*60;



		}



		if ($this->input->is_ajax_request()) {

			$chdata = array('sTe'=>$steps,'chartData'=>$chartData);

			$this->_data['chartData'] = json_encode($chdata);

		} else 

			$this->_data['chartData'] = json_encode($chartData);



		$this->_data['gft'] = $gft;



	}



	public function ppChartData_ORIGINAL($id,$sect='C',$gft=1)



	{



		$tDt1 = date("Y-m-d");



		$tDt2 = date("Y-m-d");



		$dtF = "j-M";



		$CreateDate = $tDt1;

		if($sect=='A') 

			$recrow = $this->crm->get_acRecord("account_id=$id",'create_date','A');

		else

			$recrow = $this->crm->get_acRecord("contact_id=$id",'create_date','C');

		if($recrow) {

			$CreateDate = $recrow['create_date'];

		}



		$edate = $CreateDate;

		$rmonth = date("m",strtotime($edate));

		$ryear = date("Y",strtotime($edate));



		$dt1 = date_create(date("Y-m-d",strtotime($edate)));

		$dt2 = date_create(date("Y-m-d"));

		$diff=date_diff($dt1,$dt2);

		$rdays = $diff->format("%a");



		//Timings dropdown

		if(isset($this->_data['record'])) {

			

			$gft=1;			

			if($rdays<=7) $gft = 0;

			else if($rdays>7 && $rdays<=30) $gft = 1;

			else if($rdays>30) $gft = 4;

			if($rdays>120) $gft = 5;

			if($rdays>180) $gft = 6;

			if($rdays>365) $gft = 7;



			$steps=1;

			if($gft==1) $steps=3;

			else if($gft==4 || $gft==5) $steps=15;

			else if($gft==6) $steps=30;

			else if($gft==7) $steps=180;

			$this->_data['sTE']=$steps;



			/*$steps = 1;

			if($rdays<=15) $steps = 1;

			else if($rdays<=30) $steps = 3;

			else if($rdays<=180) $steps = 15;

			else $steps = 30;

			$this->_data['sTE']=$steps;*/



			$dayfilter = '<option value="0">Last 7 Days</option>';

			$dayfilter .= '<option value="1" '.($gft==1?'selected="selected"':'').'>Last 30 Days</option>';

			//$dayfilter .= '<option value="2" '.($gft==2?'selected="selected"':'').'>This Month</option>';

			//if(!($rmonth==date("m") && $ryear==date("Y"))) $dayfilter .= '<option value="3" '.($gft==3?'selected="selected"':'').'>Last Month</option>';

			$dayfilter .= '<option value="4" '.($gft==4?'selected="selected"':'').'>Last 3 Months</option>';

			$dayfilter .= '<option value="5" '.($gft==5?'selected="selected"':'').'>Last 6 Month</option>';

			$dayfilter .= '<option value="6" '.($gft==6?'selected="selected"':'').'>Last 12 Months</option>';

			$dayfilter .= '<option value="7" '.($gft==7?'selected="selected"':'').'>Last 5 Years</option>';

			$this->_data['dayfilter']=$dayfilter;

		} else {

			$timing_dropdown = 1;

			$steps=1;

			/*if($gft==2) {

				if($rdays>15) $sTE=3;

			}*/

			//else if($gft==1 || $gft==3) $sTE=3;			

			if($gft==1) {

				$steps=3;

				//if($rdays>15) $steps=3;

			}

			else if($gft==4 || $gft==5) {				

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else */$steps=15;

			}

			else if($gft==6) {

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else if($rdays<=180) $steps=15;

				else */$steps=30;

			}else if($gft==7) {

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else if($rdays<=180) $steps=15;

				else */

				$steps=180;

			}

			$this->_data['sTE']=$steps;

		}



		//if($gft=='') $gft=1;



		if($gft==1) {//Last 30 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}



		/*else if($gft==2){//This Month - removed

			$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}



		else if($gft==3){//Last Month - removed



			$dtF = "j-M";



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2));



		}*/

		 else if($gft==4){//Last 3 Months



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-3*30*24*60*60);



		} else if($gft==5){//Last 6 Month



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-6*30*24*60*60);



		} else if($gft==6){//Last 12 Months



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-12*30*24*60*60);



		} else if($gft==7){//Last 5 Years



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-5*12*30*24*60*60);

			$dtF = "j-M-Y";

		} else {

			//Last 7 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M-Y";}



		//echo " $tDt1 - $tDt2 :: ";

		//chart start date should not before record created date

		//if(strtotime($CreateDate)>strtotime($tDt1)) $tDt1 = date("Y-m-d",strtotime($CreateDate));



		$dtF = "Y,n,j";



		$y1 =0;



		$y2 = 0;



		$mname = '';



		$dpRec = $this->crm->get_totalpoints_count($id,$sect,"pdate<'$tDt1'");



		if($dpRec) {



			$y1 =$dpRec['ipt']!=NULL?round($dpRec['ipt']):0;



			$y2 = $dpRec['ppt']!=NULL?round($dpRec['ppt']):0;



		}



		//['Day 1', 0, 0]



		$seperator = "@";



		$chartData=array();

		//$chartData[] = array('.', 0, 0);



		//$chartData[] = array('Day', $y1, $y2);			



		$results = $this->crm->get_points_list($id,$sect,"(pdate>='$tDt1' AND pdate<='$tDt2')");



		$tDt1 = strtotime($tDt1);



		$tDt2 = strtotime($tDt2);



		if($results) {



			foreach($results as $c) {



				while($tDt1<strtotime($c->pdate)){



					//$chartData[]= array(date($dtF,$tDt1), $y1, $y2);

					$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);



					$tDt1 = $tDt1+24*60*60;



				}			



				$tDt1=strtotime($c->pdate);



				$tmpmname =date($dtF,$tDt1);				



				$y1 += $c->ipt;



				$y2 += $c->ppt;



				if($mname==$tmpmname) {

					//$chartData[count($chartData)-1]= array($tmpmname, $y1, $y2);

					$chartData[count($chartData)-1]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

				}



				else {

					//$chartData[]= array($tmpmname, $y1, $y2);

					$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

				}



				$mname = $tmpmname;



				$tDt1 = $tDt1+24*60*60;



			}



		}



		while($tDt1<=$tDt2){



			//$chartData[]= array(date($dtF,$tDt1), $y1, $y2);

			$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

			$tDt1 = $tDt1+24*60*60;



		}



		if ($this->input->is_ajax_request()) {

			$chdata = array('sTe'=>$steps,'chartData'=>$chartData);

			$this->_data['chartData'] = json_encode($chdata);

		} else 

			$this->_data['chartData'] = json_encode($chartData);



		$this->_data['gft'] = $gft;



	}





	public function ppChartData($id,$sect='C',$gft=1)



	{



		$tDt1 = date("Y-m-d");



		$tDt2 = date("Y-m-d");



		$dtF = "j-M";



		$CreateDate = $tDt1;

		if($sect=='A') 

			$recrow = $this->crm->get_acRecord("account_id=$id",'create_date','A');

		else

			$recrow = $this->crm->get_acRecord("contact_id=$id",'create_date','C');

		if($recrow) {

			$CreateDate = $recrow['create_date'];

		}



		$edate = $CreateDate;

		$rmonth = date("m",strtotime($edate));

		$ryear = date("Y",strtotime($edate));



		$dt1 = date_create(date("Y-m-d",strtotime($edate)));

		$dt2 = date_create(date("Y-m-d"));

		$diff=date_diff($dt1,$dt2);

		$rdays = $diff->format("%a");



		if ($this->input->is_ajax_request()) $ajaxed=1; else $ajaxed=0;



		//Timings dropdown

		if(isset($this->_data['record'])) {

			

			$gft=1;			

			if($rdays<=7) $gft = 0;

			else if($rdays>7 && $rdays<=30) $gft = 1;

			else if($rdays>30) $gft = 4;

			if($rdays>120) $gft = 5;

			if($rdays>180) $gft = 6;

			if($rdays>365) $gft = 7;



			$steps=1;

			if($gft==1) $steps=3;

			else if($gft==4 || $gft==5) $steps=15;

			else if($gft==6) $steps=30;

			else if($gft==7) $steps=180;

			$this->_data['sTE']=$steps;



			/*$steps = 1;

			if($rdays<=15) $steps = 1;

			else if($rdays<=30) $steps = 3;

			else if($rdays<=180) $steps = 15;

			else $steps = 30;

			$this->_data['sTE']=$steps;*/



			$dayfilter = '<option value="0">Last 7 Days</option>';

			$dayfilter .= '<option value="1" '.($gft==1?'selected="selected"':'').'>Last 30 Days</option>';

			//$dayfilter .= '<option value="2" '.($gft==2?'selected="selected"':'').'>This Month</option>';

			//if(!($rmonth==date("m") && $ryear==date("Y"))) $dayfilter .= '<option value="3" '.($gft==3?'selected="selected"':'').'>Last Month</option>';

			$dayfilter .= '<option value="4" '.($gft==4?'selected="selected"':'').'>Last 3 Months</option>';

			$dayfilter .= '<option value="5" '.($gft==5?'selected="selected"':'').'>Last 6 Month</option>';

			$dayfilter .= '<option value="6" '.($gft==6?'selected="selected"':'').'>Last 12 Months</option>';

			$dayfilter .= '<option value="7" '.($gft==7?'selected="selected"':'').'>Last 5 Years</option>';

			$this->_data['dayfilter']=$dayfilter;

			if($sect<>'C') return;

		} else {

			$timing_dropdown = 1;

			$steps=1;

			/*if($gft==2) {

				if($rdays>15) $sTE=3;

			}*/

			//else if($gft==1 || $gft==3) $sTE=3;			

			if($gft==1) {

				$steps=3;

				//if($rdays>15) $steps=3;

			}

			else if($gft==4 || $gft==5) {				

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else */$steps=15;

			}

			else if($gft==6) {

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else if($rdays<=180) $steps=15;

				else */$steps=30;

			}else if($gft==7) {

				/*if($rdays<=15) $steps=1;

				else if($rdays<=30) $steps=3;

				else if($rdays<=180) $steps=15;

				else */

				$steps=180;

			}

			$this->_data['sTE']=$steps;

		}



		//if($gft=='') $gft=1;



		if($gft==1) {//Last 30 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}



		/*else if($gft==2){//This Month - removed

			$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}



		else if($gft==3){//Last Month - removed



			$dtF = "j-M";



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2));



		}*/

		 else if($gft==4){//Last 3 Months



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-3*30*24*60*60);



		} else if($gft==5){//Last 6 Month



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-6*30*24*60*60);



		} else if($gft==6){//Last 12 Months



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-12*30*24*60*60);



		} else if($gft==7){//Last 5 Years



			//$tDt1 = date("Y-m-01",strtotime($tDt1));



			//$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-d",strtotime($tDt2)-5*12*30*24*60*60);

			$dtF = "j-M-Y";

		} else {

			//Last 7 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M-Y";}



		//echo " $tDt1 - $tDt2 :: ";

		//chart start date should not before record created date

		//if(strtotime($CreateDate)>strtotime($tDt1)) $tDt1 = date("Y-m-d",strtotime($CreateDate));

		if($ajaxed) $dtF = "Y,n,j";

		else $dtF = "F d, Y";//October 30, 2014

		$dtF = "Y,n,j";



		$y1 =0;



		$y2 = 0;



		$mname = '';



		$dpRec = $this->crm->get_totalpoints_count($id,$sect,"pdate<'$tDt1'");



		if($dpRec) {



			$y1 =$dpRec['ipt']!=NULL?round($dpRec['ipt']):0;



			$y2 = $dpRec['ppt']!=NULL?round($dpRec['ppt']):0;



		}



		//['Day 1', 0, 0]



		$seperator = "@";



		$chartData=array();

		//$chartData[] = array('.', 0, 0);



		//$chartData[] = array('Day', $y1, $y2);			



		$results = $this->crm->get_points_list($id,$sect,"(pdate>='$tDt1' AND pdate<='$tDt2')");



		$tDt1 = strtotime($tDt1);



		$tDt2 = strtotime($tDt2);



		if($results) {



			foreach($results as $c) {



				while($tDt1<strtotime($c->pdate)){



					//if($ajaxed) $chartData[]= array(date($dtF,$tDt1), $y1, $y2);

					//else $chartData[]= array('new Date('.date($dtF,$tDt1).')', $y1, $y2);

					$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

					$tDt1 = $tDt1+24*60*60;



				}			



				$tDt1=strtotime($c->pdate);



				$tmpmname =date($dtF,$tDt1);				



				$y1 += $c->ipt;



				$y2 += $c->ppt;



				if($mname==$tmpmname) {

					//if($ajaxed) $chartData[count($chartData)-1]= array($tmpmname, $y1, $y2);

					//else $chartData[count($chartData)-1]= array('new Date('.$tmpmname.')', $y1, $y2);

					$chartData[count($chartData)-1]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

				}

				else {

					//if($ajaxed) $chartData[]= array($tmpmname, $y1, $y2);

					//else $chartData[]= array('new Date('.$tmpmname.')', $y1, $y2);

					$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

				}



				$mname = $tmpmname;



				$tDt1 = $tDt1+24*60*60;



			}



		}



		while($tDt1<=$tDt2){



			/*if($ajaxed) $chartData[]= array(date($dtF,$tDt1), $y1, $y2);

			else $chartData[]= array('new Date('.date($dtF,$tDt1).')', $y1, $y2);*/

			$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

			$tDt1 = $tDt1+24*60*60;



		}



		if ($this->input->is_ajax_request()) {

			$chdata = array('sTe'=>$steps,'chartData'=>$chartData);

			$this->_data['chartData'] = json_encode($chdata);

		} else {

			$cdt = json_encode($chartData);

			//$cdt = str_replace('"', "", $cdt);

			$this->_data['chartData'] = $cdt;

		}



		$this->_data['gft'] = $gft;



	}



	public function ppChartData_PRO($id,$sect='C',$gft=1)



	{



		$tDt1 = date("Y-m-d");



		$tDt2 = date("Y-m-d");



		$dtF = "j-M";



		$CreateDate = $tDt1;

		if($sect=='A') 

			$recrow = $this->crm->get_acRecord("account_id=$id",'create_date','A');

		else

			$recrow = $this->crm->get_acRecord("contact_id=$id",'create_date','C');

		if($recrow) {

			$CreateDate = $recrow['create_date'];

		}



		$edate = $CreateDate;

		$rmonth = date("m",strtotime($edate));

		$ryear = date("Y",strtotime($edate));



		$dt1 = date_create(date("Y-m-d",strtotime($edate)));

		$dt2 = date_create(date("Y-m-d"));

		$diff=date_diff($dt1,$dt2);

		$rdays = $diff->format("%a");



		if ($this->input->is_ajax_request()) $ajaxed=1; else $ajaxed=0;



		//Timings dropdown

		if(isset($this->_data['record'])) {

			

			$gft=1;			

			if($rdays<=7) $gft = 0;

			else if($rdays>7 && $rdays<=30) $gft = 1;

			else if($rdays>30) $gft = 4;

			if($rdays>120) $gft = 5;

			if($rdays>180) $gft = 6;

			if($rdays>365) $gft = 7;



			$dayfilter = '<option value="0">Last 7 Days</option>';

			$dayfilter .= '<option value="1" '.($gft==1?'selected="selected"':'').'>Last 30 Days</option>';

			//$dayfilter .= '<option value="2" '.($gft==2?'selected="selected"':'').'>This Month</option>';

			//if(!($rmonth==date("m") && $ryear==date("Y"))) $dayfilter .= '<option value="3" '.($gft==3?'selected="selected"':'').'>Last Month</option>';

			$dayfilter .= '<option value="4" '.($gft==4?'selected="selected"':'').'>Last 3 Months</option>';

			$dayfilter .= '<option value="5" '.($gft==5?'selected="selected"':'').'>Last 6 Month</option>';

			$dayfilter .= '<option value="6" '.($gft==6?'selected="selected"':'').'>Last 12 Months</option>';

			$dayfilter .= '<option value="7" '.($gft==7?'selected="selected"':'').'>Last 5 Years</option>';

			$this->_data['dayfilter']=$dayfilter;

		}



		

		if($gft==1) {//Last 30 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}

		 else if($gft==4){//Last 3 Months



			$tDt1 = date("Y-m-d",strtotime($tDt2)-3*30*24*60*60);



		} else if($gft==5){//Last 6 Month



			$tDt1 = date("Y-m-d",strtotime($tDt2)-6*30*24*60*60);



		} else if($gft==6){//Last 12 Months



			$tDt1 = date("Y-m-d",strtotime($tDt2)-12*30*24*60*60);



		} else if($gft==7){//Last 5 Years



			$tDt1 = date("Y-m-d",strtotime($tDt2)-5*12*30*24*60*60);

			$dtF = "j-M-Y";

		} else {

			//Last 7 Days

			$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M-Y";}



		//echo " $tDt1 - $tDt2 :: ";

		//chart start date should not before record created date

		//if(strtotime($CreateDate)>strtotime($tDt1)) $tDt1 = date("Y-m-d",strtotime($CreateDate));

		$dtF = "Y,n,j";



		$y1 =0;



		$y2 = 0;



		$mname = '';



		$dpRec = $this->crm->get_totalpoints_count($id,$sect,"pdate<'$tDt1'");



		if($dpRec) {



			$y1 =$dpRec['ipt']!=NULL?round($dpRec['ipt']):0;



			$y2 = $dpRec['ppt']!=NULL?round($dpRec['ppt']):0;



		}



		//['Day 1', 0, 0]



		$seperator = "@";



		$chartData=array();

		//$chartData[] = array('.', 0, 0);



		//$chartData[] = array('Day', $y1, $y2);			



		$results = $this->crm->get_points_list($id,$sect,"(pdate>='$tDt1' AND pdate<='$tDt2')");



		$tDt1 = strtotime($tDt1);



		$tDt2 = strtotime($tDt2);



		if($results) {



			foreach($results as $c) {



				while($tDt1<strtotime($c->pdate)){



					//if($ajaxed) $chartData[]= array(date($dtF,$tDt1), $y1, $y2);

					//else $chartData[]= array('new Date('.date($dtF,$tDt1).')', $y1, $y2);

					$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

					$tDt1 = $tDt1+24*60*60;



				}			



				$tDt1=strtotime($c->pdate);



				$tmpmname =date($dtF,$tDt1);				



				$y1 += $c->ipt;



				$y2 += $c->ppt;



				if($mname==$tmpmname) {

					//if($ajaxed) $chartData[count($chartData)-1]= array($tmpmname, $y1, $y2);

					//else $chartData[count($chartData)-1]= array('new Date('.$tmpmname.')', $y1, $y2);

					$chartData[count($chartData)-1]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

				}

				else {

					//if($ajaxed) $chartData[]= array($tmpmname, $y1, $y2);

					//else $chartData[]= array('new Date('.$tmpmname.')', $y1, $y2);

					$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

				}



				$mname = $tmpmname;



				$tDt1 = $tDt1+24*60*60;



			}



		}



		while($tDt1<=$tDt2){



			/*if($ajaxed) $chartData[]= array(date($dtF,$tDt1), $y1, $y2);

			else $chartData[]= array('new Date('.date($dtF,$tDt1).')', $y1, $y2);*/

			$chartData[]= array(array(date("Y",$tDt1)-0,date("n",$tDt1)-1,date("j",$tDt1)-0), $y1, $y2);

			$tDt1 = $tDt1+24*60*60;



		}



		if ($this->input->is_ajax_request()) {

			$chdata = array('sTe'=>$steps,'chartData'=>$chartData);

			$this->_data['chartData'] = json_encode($chdata);

		} else {

			$cdt = json_encode($chartData);

			//$cdt = str_replace('"', "", $cdt);

			$this->_data['chartData'] = $cdt;

		}



		$this->_data['gft'] = $gft;



	}



	//accounts



	function accounts($action = NULL)



	{



		$this->_data['crmlite'] = 'account';



		$pam3 = $this->uri->segment(3);//edit/delete



		$pam4 = $this->uri->segment(4);//id



		$pam5 = $this->uri->segment(5);//extra slug parameter

		$mpaged = 0;

		if ($this->input->is_ajax_request()) {

		   $mpaged = 1;

		   //Add Contact Records to List

		   $this->add_Records_to_List();



		   //contact block childs

		   if($this->input->post('ccblock')=="accountchilds") {

				$id = (int)$pam4;

				$this->_data['account_id'] = $id;



				$this->_data['notes_list'] = $this->crm->get_all_notes($id,'A',10);			



				$this->_data['docs_list'] = $this->crm->get_all_docs($id,'A',10);



				$this->_data['contact_list'] = $this->crm->get_account_contacts($id);



				$this->_data['oppty_list'] = $this->crm->get_contact_relatedto($id,'A');



				$this->_data['otasks_list'] = $this->crm->get_all_tasks($id,'A',10,2);



				$this->_data['atasks_list'] = $this->crm->get_all_tasks($id,'A',10,1);

				$html = $this->load->view('crm/account-view-childs', $this->_data,true);

				echo $html;

				exit;	

		   }

		}



		//Get graph data



		if($this->input->post('action')=="graph") {



			$this->ppChartData($this->input->post('cid'),'A',$this->input->post('gft'));



			echo $this->_data['chartData'];



			exit;



		}



		//delete all		



		if($this->input->post('action')=="deleteall") {			



			$record=$this->input->post('recids');



			if($record) {



				foreach($record as $rcid) $this->crm->delete_account($rcid);



			}



			redirect(current_url());



		}



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$record = $this->crm->get_account($id,$this->_parent_users);



			if(!$record) redirect(base_url() . 'crm/accounts/all');



			$this->crm->delete_account($id);



			redirect(base_url() . 'crm/accounts/all');



		}



		$breadcrumbs = array();

		$accountsurl = 'crm/accounts';

		



		if($pam3=="all"){$accountsurl = 'crm/accounts/all';	$breadcrumbs[] = array('label'=>'All Accounts','url'=>base_url('crm/accounts/all'));$this->_data['listall'] = 'yes';}



		else if($pam3=="my") {$accountsurl = 'crm/accounts/my';$breadcrumbs[] = array('label'=>'My Accounts','url'=>base_url('crm/accounts/my'));$this->_data['mine'] = 'yes';}



		else $breadcrumbs[] = array('label'=>'Target Accounts','url'=>base_url('crm/accounts'));



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;



			$record = $this->crm->get_account($id,$this->_parent_users);



			if(!$record) redirect(base_url() . 'crm/accounts');



			//Delete account from Account List

			if($pam5) {

				$this->crm->delete_category_records($pam5,$id);

				redirect(base_url('crm/accounts/view/'.$id));

			}



			//Send to Salesforce



			if($pam5=="send") {



				$this->_data['sfMode']="ar-$id";



				$this->_data['sfRecord']=$record;



				$this->salesforce();



			}



			



			if((int)$record['sla_expdate']) $record['sla_expdate']=date("m/d/Y",strtotime($record['sla_expdate']));



			else $record['sla_expdate']="";



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);



			$this->_data['record'] = $record;



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts/all'));



			$breadcrumbs[] = array('label'=>ucfirst($record[account_name]),'url'=>base_url('crm/accounts/view/'.$id));



			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');



			//Quick Update Account record



			$this->quick_update_account($id);

			$this->update_record_catlist($id,2);



		}



		$this->_data['breadcrumbs']=$breadcrumbs;



		//Import & Mapping



		if($pam3=="import" && $pam4=="map") {



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



			$breadcrumbs[] = array('label'=>'Import','url'=>base_url('crm/accounts/import'));



			$breadcrumbs[] = array('label'=>'Mapping','url'=>base_url('crm/accounts/import/map'));



			$parent_section = "accounts";



			$filename = $this->session->userdata('aimport_data');



			if(!$filename || !file_exists($filename)) redirect(base_url() . 'crm/accounts');



			$ext = substr(strrchr($filename,'.'),1);



			$header = array();

			$arr_data = array();



			$header2 = array();

			$exrows2 = array();

			$keys2 = array();

			$keys3 = array();



			$this->load->helper('scripts');



			$table_fields = import_fields('account');



			$this->_data['table_fields']=$table_fields;



			$save=0;



			if($this->input->post('action')=="save") $save=1;



			if($ext=="xls" || $ext=="xlsx") {



				$this->load->library('excel');



				// Use PCLZip rather than ZipArchive

				PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

				$objPHPExcel = PHPExcel_IOFactory::load($filename);



				$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();

				$highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();

				$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn);



				if($lastRow<=1) $ermsg = "No data in Excel file";	



				if($ermsg=="") {					

					$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

					//get header

					$row=1;

					$alphno = 65;

					for($col = 0; $col<$colNumber;$col++) {

						$header2[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

						$alphabet = chr($alphno++);

						$keys2[] = $alphabet;

						//$keys3[$alphabet] = $col;

					}

					$row=2;

					for($col = 0; $col<$colNumber;$col++) {

						$exrows2[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();

					}

					$rowdata = array('header'=>$header2,'values'=>$exrows2); 

					//$arr_data = $exrows;

					$this->_data['rowsdata']=array("keys"=>$keys2,"values"=>$header2,"rows"=>$exrows2,'total'=>$lastRow);

				}



			} else {



				$this->load->library('parsecsv');



				$csv = new Parsecsv();



				$csv->auto($filename);



				$csvdata = $csv->data;



				if($csvdata) {



					$header = $csvdata[0];



					$rowdata['header'] = $header;



					$lastRow = count($csvdata);



					if($save) $rowdata['values'] = $csvdata;



					else $rowdata['values'] = $csvdata[0];



					$column_keys = array_keys($header);



					$column_heads = $column_keys;



					$this->_data['rowsdata']=array("keys"=>$column_keys,"values"=>$column_heads,"rows"=>$rowdata['values'],'total'=>$lastRow);



				}



			}



			$er = array();



			//amapping



			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'amapping';



			$this->_data['userinfo'] = $this->home->getUserData($where);



			$this->session->set_userdata('aimport_no', 0);

			$_SESSION['aimport_no_2']=0;



			//Direct post accounts importe disabled

			if($this->input->post('action')=="save" && false) {



				$record=$this->input->post('record');

				//Category List ID

				$records_listid = (isset($record['listid']) && $record['listid'])?$record['listid']:0;



				$er = array();



				$tbcol = array_filter($record['tbcol']);



				if(!$tbcol) $er['file']="Select contact fields";



				if(!$er) {



					//Saving Contacts



					//echo "<pre>";



					//print_r($record);



					//Selected mapping fields



					$tabcols = array();



					foreach($record['tbcol'] as $ki=>$kv) {



						if(!$kv) continue;



						$tabcols[$kv]=$record['excol'][$ki];



					}



					//print_r($tabcols);



					//Target Account



					if(isset($record['target'])) $target=1; else $target=0;



					//Assign Record Owner



					if(isset($record['share_user_id']) && $record['share_user_id']) $record_owner=$record['share_user_id']; else $record_owner=$this->_user_id;



					



					$adr = array('bstreet','bcity','bstate','bzipcode','bcountry');



					$adr2 = array('sstreet','scity','sstate','szipcode','scountry');



					//Contact rows



					foreach($rowdata['values'] as $fval) {						



						$tbval = array();



						$address = array();



						$address2 = array();



						$custom=array();



						foreach($tabcols as $ci=>$cv) {



							if(empty($fval["$cv"])) continue;



							//custom



							if(substr($ci,0,5)=="field"){



								$custom[$ci]=$fval["$cv"]; 



								continue;



							}



							if(in_array($ci,$adr)!==false) $address[substr($ci,1)]=$fval["$cv"];



							//else if(in_array($ci,$adr2)!==false) $address2[substr($ci,1)]=$fval["$cv"];



							else $tbval[$ci]=$fval["$cv"];



						}



						if(!$tbval) continue;						



						$tbval['create_date']=date("Y-m-d H:i:s");



						$tbval['modify_date']=date("Y-m-d H:i:s");



						if(!empty($tbval['sla_expdate'])) {



							$tmpdate = explode("/",$tbval['sla_expdate']);//m/d/y-012



							$tbval['sla_expdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



						}



						//Target Account



						if($target) $tbval['target']=1; else



						if($tbval['target']) {



							if((int)$tbval['target'] || strtolower($tbval['target'])=="y" || $tbval['target']=="YES") $tbval['target']=1;



						} else unset($tbval['target']);



						if(isset($tbval['revenue'])) $tbval['revenue']=(float)$tbval['revenue'];



						if(isset($tbval['employees'])) $tbval['employees']=(int)$tbval['employees'];



						if(isset($tbval['numlocations'])) $tbval['numlocations']=(int)$tbval['numlocations'];						



						$tbval['share_user_id']=$record_owner;



						$cid = $this->crm->save_account($tbval,0);



						//$cid =1;



						//custom



						if($cid){

							//Category List ID & assign record to list							

							if($records_listid) {

								$exist_record = $this->crm->get_category_record($records_listid,$cid);

								if(!$exist_record) {

									$info = array('category_id'=>$records_listid,'record_id'=>$cid);

									$this->crm->save_category_record($info,$id);

								}

							}



							foreach($custom as $ci=>$cv) {



								$ecdata = array('section'=>'A','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv);



								$this->crm->save_custom_record($ecdata);



							}



						}



						//Address



						if($cid) {



							if($address) {



								$address['parent_id']=$cid;



								$address['adr_type']='billing';



								$address['parent_type']='A';



								$this->crm->save_address($address);



							}



							if($address2) {



								$address2['parent_id']=$cid;



								$address2['adr_type']='shipping';



								$address2['parent_type']='A';



								$this->crm->save_address($address2);



							}



						}

 

						//print_r($address);



						//print_r($address2);



					}



					//mapping



						if(isset($record['mapping'])){



							$where = array();



							$where['user_id'] = $this->_user_id;



							$where['field_type'] = 'amapping';



							$user_info = $this->home->getUserData($where);



							$data = array();



							$headers=$rowdata['header'];



							//print_r($headers);



							foreach($tabcols as $key=>$value){



								$exheaders[$value]=$headers[$value];



							}



							$data1['val'] = $tbcol;



							$data1['excel']=$tabcols;



							//print_r($tbcol);



							//print_r($exheaders);



							//print_r($tabcols);



							$data1['headers']= $exheaders;



							$data['value']=serialize($data1);



							



							//print_r($data);



							if($user_info) $this->home->saveUserData($data,$where);



							else {



								$data['user_id'] = $this->_user_id;



								$data['field_type'] = 'amapping';



								//$data['value']=$data['data'];



								



								$this->home->saveUserData($data);



							}



						}



						//mapping



					//echo "</pre>";



					unlink($filename);



					$this->session->unset_userdata('aimport_data');



					redirect(base_url() . 'crm/accounts/my');



				}



				$this->_data['record']=$record;



				$this->_data['error']=$er;



			}			



			if(!$rowdata) $er[]="There is no rows in file.";			



			if(!$table_fields) $er[]="Accounts Structure not found";



			if($er) $this->_data['error']=$er;



			$this->_data['mapping']="yes";



			$this->_data['ext']=$ext;



			$this->_data['parent_section']=$parent_section;



			$this->_data['breadcrumbs']=$breadcrumbs;



			//Assign Record Owner



			$this->_data['dropdown_users'] = $this->crm->get_all_shared_users($this->_parent_users);

			//Category List ID

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>2));

			

			//Interaction for Contacts imported

			$this->_data['CustObjections'] = $this->crm->get_objections('Y');

			//Objections from Objection Map which are newly entered by user

			$this->_data['ObjectionsCampaign'] = $this->crm->get_objection_Campaign();

			$this->load->helper('scripts');

			$categories = crm_introptions();

			$this->_data['categories'] = $categories;

			if(isset($_SESSION['cimport_interaction'])) unset($_SESSION['cimport_interaction']);



			$this->load->view('crm/account-import', $this->_data);



		}



		//import



		else if($pam3=="import") {



			$filename = $this->session->userdata('aimport_data');



			if($filename && file_exists($filename)) unlink($filename);



			$this->session->unset_userdata('aimport_data');



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



			$breadcrumbs[] = array('label'=>'Import','url'=>base_url('crm/accounts/import'));



			$parent_section = "accounts";



			//Salesforce Import accounts



			if($pam4=="salesforce") {



				$breadcrumbs[] = array('label'=>'Salesforce','url'=>base_url('crm/accounts/import/salesforce'));



				$this->_data['sfMode']="a";



				//Import Salesforce Contacts



				if($this->input->post('btn_rcimport')=="Import Records") $this->_data['importMode']=1;



				//Salesforce checker



				if($this->input->post('btn_disconnect')<>"Disconnect") $this->salesforce();



				//Import Salesforce Contacts 



				if($this->input->post('btn_rcimport')=="Import Records") {



					$this->import_salesforce_Account();



				} else if($this->input->post('btn_disconnect')=="Disconnect") {



					unset($_SESSION['templatename']);



					unset($_SESSION['crmlog']);



					unset($_SESSION['bcrmlog']);



					unset($_SESSION['bcrmlogrc']);



					unset($_SESSION['access_token']);



					unset($_SESSION['instance_url']);



					unset($_SESSION['issued_at']);



					unset($_SESSION['signature']);



					unset($_SESSION['id']);



					unset($_SESSION['scope']);



					unset($_SESSION['token_type']);



					unset($_SESSION['expires']);



					unset($_SESSION['instance']);



					unset($_SESSION['ws_namespace']);



					unset($_SESSION['ws_endpoint']);



					unset($_SESSION['ws_name']);



				}	



			}



			if($this->input->post('action')=="save") {



				$er = array();



				if(empty($_FILES['import_file']['name'])) $er['file']="CSV or Excel required";



				if(!$er) {



					$config['upload_path'] = './import/';



					$config['allowed_types'] = 'csv|xls|xlsx';



					$config['max_size'] = '2048000';



					//$ext = end(explode(".", $_FILES['import_file']));



					$config['file_name'] = $this->_user_id."_4".basename($_FILES['import_file']);



					$this->load->library('upload', $config);



					if ( ! $this->upload->do_upload('import_file')) {



						$er = array('error' => $this->upload->display_errors());



						//$this->_data['error']=$error;



						//$this->load->view('upload_form', $error); 



					} else { 



						$data = $this->upload->data();



						//$this->_data['updata']=$data;



						//$ext = strtolower($data['file_ext']);



						//$this->_data['ext']=substr($ext,1);



						$filename = $data['full_path'];



						//$file_data = array("ext"=>$this->_data['ext'],"file"=>$filename);



						//$file_data = $filename;



						$this->session->set_userdata('aimport_data', $filename);



						redirect(base_url() . 'crm/accounts/import/map');



					}



				}



				$this->_data['error']=$er;



			}



			$this->_data['parent_section']=$parent_section;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$this->load->view('crm/excel-import', $this->_data);



		} else if($pam3=="edit") {



			$id = (int)$pam4;



			$breadcrumbs = array();



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts/all'));	



			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['account_name'])) $er['account_name']="account_name required";



				if(!empty($record['revenue'])) {



					if(!is_numeric($record['revenue'])) $er['revenue']="Annual Revenue Must be number";



				}



				if(!empty($record['employees'])) {



					if(!is_numeric($record['employees'])) $er['employees']="Employees Must be number";



				}



				if(!empty($record['numlocations'])) {



					if(!is_numeric($record['numlocations'])) $er['numlocations']="Number of Locations Must be number";



				}



				if($id && $id==$record['account_parent']) $er['account_parent']="A parent account can't be the child of an account it's already a parent of.";



				if(!$er) {



					$address1 = $record['billing'];



					$address2 = $record['shipping'];



					//custom fields



					$custom_values=$record['custom'];



					unset($record['custom']);



					



					unset($record['billing']);



					unset($record['shipping']);



					unset($record['account_title']);



					unset($record['share_user_title']);



					if(!$id) $record['create_date']=date("Y-m-d H:i:s");



					$record['modify_date']=date("Y-m-d H:i:s");



					if(!empty($record['sla_expdate'])) {



						$tmpdate = explode("/",$record['sla_expdate']);//m/d/y-012



						$record['sla_expdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					}



					$record['target']=$record['target']?1:0;



					$cid = $this->crm->save_account($record,$id);



					if($cid) {



						//custom fields



						//$custom_values = array_filter($custom_values);



						foreach($custom_values as $ci=>$cv) {



							/*if($cv!=""){*/



								$ecdata = array('section'=>'A','recid'=>$cid,'ckey'=>$ci,'cval'=>$cv);



								$this->crm->save_custom_record($ecdata);



							/*}else{



								$ecdata = array('section'=>'A','recid'=>$cid,'ckey'=>$ci);



								$this->crm->delete_custom_record($ecdata);



							}*/



						}



						



						$this->crm->delete_address($id,'A');



						$address1 = array_filter($address1);



						if($address1) {



							$address1['parent_id']=$cid;



							$address1['adr_type']='billing';



							$address1['parent_type']='A';



							$this->crm->save_address($address1);



						}





						$address2 = array_filter($address2);



						if($address2) {



							$address2['parent_id']=$cid;



							$address2['adr_type']='shipping';



							$address2['parent_type']='A';



							$this->crm->save_address($address2);



						}



					}



					redirect(base_url() . 'crm/accounts/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			if(!$record['share_user_title']) {



				$record['share_user_id']=$this->_user_id;



				$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



				$record['share_user_title']=ucfirst($sUser[0]->usrname);



			}



			$this->_data['record']=$record;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$this->load->view('crm/account-edit', $this->_data);



		}



		else if($pam3=="view") {



			//Prospect Points



			$total_points = $this->crm->get_totalpoints_count($id,'A');



			if($total_points[ipt]<>NULL) {



				$this->_data['total_points'] = $total_points;



				$this->ppChartData($id,'A');



			}			



			/*$this->_data['notes_list'] = $this->crm->get_all_notes($id,'A',10);			



			$this->_data['docs_list'] = $this->crm->get_all_docs($id,'A',10);



			$this->_data['contact_list'] = $this->crm->get_account_contacts($id);



			$this->_data['oppty_list'] = $this->crm->get_contact_relatedto($id,'A');



			$this->_data['otasks_list'] = $this->crm->get_all_tasks($id,'A',10,2);



			$this->_data['atasks_list'] = $this->crm->get_all_tasks($id,'A',10,1);*/



			//Category List

			$this->_data['catg_list'] = $this->crm->get_categories_attached($id,2);

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>2));

			$checked_catg = array();

			if($this->_data['catg_list'])

				foreach($this->_data['catg_list'] as $ecatval) $checked_catg[]= $ecatval->id;

			$this->_data['checked_catg'] = $checked_catg;

			

			

			//Account New View Layout

			$this->load->helper('scripts');

			$layout_fields = alayout_fields();

			//Account Custom Fields

			$account_customField_values = array();

			if($this->_data['customa']) {

				$customNum = $this->_data['customNuma']?$this->_data['customNuma']:array();

				foreach($this->_data['customa'] as $ck=>$cv) {

					$layout_fields[$ck]=array('label'=>$cv,'type'=>'custom','num'=>(in_array($ck,$customNum)!==FALSE?'Y':'N'));

				}

				//seperate Account custom fields by key wise

				if($record['custom']) {					

					foreach($record['custom'] as $cval) $account_customField_values[$cval['ckey']] = $cval;

				}

			}

			$this->_data['account_customField_values']=$account_customField_values;

			$this->_data['layout_fields']=$layout_fields;	



			//User fields

			$where = array();

			//$where['user_id'] = $this->_user_id;

			$where['user_id']= isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;

			$where['field_type'] = 'layout_account';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$layout_keys = array_keys($layout_fields);

			$account_fields = $layout_keys;

			if(isset($user_info->value) && $user_info->value) {

				$account_fields=json_decode($user_info->value);

				$account_fields = (array)$account_fields;

			}

			$this->_data['account_fields']=$account_fields;

			$layout_keys = array_diff($layout_keys, $account_fields);

			$this->_data['layout_keys']=$layout_keys;



			//end of Account New View Layout			



			$this->load->view('crm/account-view', $this->_data);			



		} else {

			



			$target=1;



			$owner=$this->_user_id;



			if($pam3=="all") {$owner=0;$target=0;



			}



			else if($pam3=="my") $target=0;



			//$this->_data['accounts'] = $this->crm->get_all_accounts($owner,$target,$this->_parent_users);



			//Search & Pagination

			$pgoffset = $this->input->get('per_page')?$this->input->get('per_page'):0;

			$skey = $this->input->get('search')?$this->input->get('search'):'';

			

			

			//Sorting

			

			

			$sortcol = $this->input->get('col')?$this->input->get('col'):'';

			$sortval = $this->input->get('sort')?$this->input->get('sort'):'';

			$sortfields = array('name'=>'a.account_name','owner'=>'usrname','phone'=>'a.phone','qp'=>'qpoints');

			if($sortcol && isset($sortfields[$sortcol])) {

				$sortcol2 = $sortfields[$sortcol];

				$sortval2 = $sortval=='desc'?'desc':'asc';

			} else {

				$sortcol2='';

				$sortval2='';

			}

			$this->_data['sortcol'] = $sortcol;

			$this->_data['sortval'] = $sortval;

			

			

			//echo $this->input->get('col');			

			//echo $this->input->get('sort');

			

			

			

			$qsearch = "";

			$sparam = "";

			$acsq = "";

			if($this->input->get('col') && $this->input->get('sort'))

			{

				$acsq .= " ORDER BY ".$this->input->get('col')." ".$this->input->get('sort');

			}

		  /*	if($skey) {

				//$qsearch = "(a.account_name like '%$skey%' OR a.phone like '%$skey%')";

				$skey_parts = explode(" ",$skey);

				foreach($skey_parts as $skpart) {

					if($qsearch) $qsearch .=" OR ";

					$qsearch .= " a.account_name like '%$skpart%' OR  a.phone like '%$skpart%'";

				}

				if($qsearch) $qsearch =" ($qsearch) ";

				$sparam = "search=$skey";

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="&col=".$this->input->get('col')."&sort=".$this->input->get('sort'); */

				

				

				// DEVELOPER MINE

				

						if($skey) {

				$skey_parts = explode(" ",$skey);

				$ik = 0;

					foreach($searchfields as $kk => $sval) { 

					$ik = $ik + 1;

							 if($kk == 'account_name' || $kk =='account_number' || $kk =='account_site' || $kk =='account_type' || $kk =='industry' || $kk =='revenue' || $kk =='rating' || $kk =='target' || $kk =='phone' || $kk =='fax' || $kk == 'website' || $kk =='ticker_symbol' || $kk =='ownership' || $kk =='employees' || $kk =='siccode' || $kk =='bstreet' || $kk =='bcity' || $kk =='bstate' || $kk =='bzipcode' || $kk =='bcountry' || $kk =='customer_priority' || $kk =='sla_expdate' || $kk =='numlocations' || $kk =='active' || $kk =='sla' || $kk =='sla_serialno' || $kk =='upsell_oppt' || $kk =='description'){

							  if($qsearch) $qsearch .= " OR ";

							$qsearch .= "  a.".$kk." like '%$skey%'  ";	   

					} 

					

				 else if($kk == 'user_first'){

			   if($qsearch) $qsearch .= " OR ";

			   $qsearch .= " CONCAT( c.user_first,  ' ', c.user_last ) LIKE  '%$skey%' ";

			 }

			 

			 else if($kk == 'address'){

			  if($qsearch) $qsearch .= " OR ";

			   $qsearch .= "  cad.address LIKE  '%$skey%' ";

			 }     

			 

			  else if($kk == 'first_name'){

				if($qsearch) $qsearch .= " OR ";

			   $qsearch .= "  first_name LIKE  '%$skey%' ";

			 }

			 

			   else if($kk == 'report_id'){

				if($qsearch) $qsearch .= " OR ";

			   $qsearch .= "  report_id LIKE  '%$skey%' ";

			 } 

			 

			 else {

			   if($qsearch) $qsearch .= " OR ";

				// $sel_q .= ' (SELECT cval FROM crm_custom_values  where ckey="'.$val.'" and section="C" and recid=c.contact_id) as '.$kk;

				 // if($qsearch) $qsearch .= " OR ";

			  // $qsearch .= "  ".$kk." LIKE  '%$skey%' ";

				$qsearch .= " cv$ik.cval LIKE  '%$skey%' ";

			 } 

				}

				

				/*foreach($skey_parts as $skpart) {

					if($qsearch) $qsearch .=" OR ";

					$qsearch .= " c.user_first like '%$skpart%' OR c.user_last like '%$skpart%' OR c.user_title like '%$skpart%' OR c.phone like '%$skpart%' OR c.email like '%$skpart%' ";

					

				}*/

				//$qsearch = " c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

			////	$qsearch = " CONCAT( c.user_first,  ' ', c.user_last ) LIKE  '%$skey%'  OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

				  

			

				// echo $qsearch;

				 

				 

				//$qsearch =  " c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

				if($qsearch) $qsearch =" ($qsearch) ";

				//$qsearch = "(c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%')";

				$sparam = "search=$skey";

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="&col=".$this->input->get('col')."&sort=".$this->input->get('sort');

			}

				// END DEVELOPER MINE

			/*}*/

			

			if(!$skey){

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="col=".$this->input->get('col')."&sort=".$this->input->get('sort');

			}

			//$total_records = $this->crm->get_accounts_total($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset);

			//exit;

			$ff_Results = $this->crm->get_all_accounts_latest($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset);

			 $total_records = $ff_Results['num_results'];

			//exit;

			



			$this->load->library('pagination');

			$perpage = 50;

			$config['base_url'] = base_url($accountsurl)."/?".$sparam;

			$config['total_rows'] = $total_records;

			$config['per_page'] = $perpage;

			//$config['uri_segment'] = 3;

			$config['num_links'] = 5;

			$config['page_query_string'] = TRUE;

			$this->pagination->initialize($config);

			

			

			//Custom Fields

			

			//Custom Fields

			//Contacts

			$where = array();

			 $acustom_field_labels  = array();

			$where['user_id'] = $this->_user_id;

			$where['field_type'] = 'customa';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$custom = array();

			if(isset($user_info->value)) {

				$custom=unserialize($user_info->value);	

			}

			if($custom) {

				foreach($custom as $ck=>$cv) $alayout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

			} 

			

			 $acustom_field_labels = $alayout_fields;

			

			

			$this->_data['records_info'] = "";					

			$this->_data['accounts'] = array();

			if($total_records) {

				$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

				if($to2>$total_records) $to2 = $total_records;

				//$this->_data['accounts'] = $this->crm->get_all_accounts($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,0,$sortcol2,$sortval2);

				$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

			}

			

			// CUSTOM DATA

			

				$frow = array();

				foreach($ff_Results['rowres'] as $kk => $crow)  {

				$ref_id = $crow->account_id;

				$crow = json_decode(json_encode($crow), true);

				$selectedcolumns = $ff_Results['contact'];

				 foreach($selectedcolumns  as $selk => $selval){

					if (array_key_exists($selk, $crow)) {

				}

				 else {

				  $crow[$selk] = "";

				 }

				} 

				

				$tempcrow = array();

				foreach($selectedcolumns as $kc => $kv){

				  $tempcrow[$kc] =  $crow[$kc];

				 

				}

				$tempcrow['account_id'] = $ref_id;

			

				foreach($tempcrow as $key => $val) { 

					

				// echo $key."<br/>";

				

				 /*  if($key == 'target' || $key =='linkedin' || $key =='birthdate' || $key =='website' || $key =='lead_source' || $key =='user_title' || $key =='department' || $key =='create_date' || $key =='mobile' || $key =='phone' || $key =='assistant' || $key =='unsubscribed' || $key =='email' || $key =='asst_phone' || $key =='other_phone' || $key =='description' || $key =='ipoints' || $key =='ppoints' || $key == 'account_id' || $key == 'address' || $key == 'first_name' || $key == 'report_id' || $key = 'user_first') { 

					   echo "YYYYYYYYYYYYY";

				 

				} */

				$kk = $key;

				if($key == 'account_id'){

				$tempcrow[$key] = $ref_id;

				}

				

				else if($kk == 'account_name' || $kk =='account_number' || $kk =='account_site' || $kk =='account_type' || $kk =='industry' || $kk =='revenue' || $kk =='rating' || $kk =='target' || $kk =='phone' || $kk =='fax' || $kk == 'website' || $kk =='ticker_symbol' || $kk =='ownership' || $kk =='employees' || $kk =='siccode' || $kk =='bstreet' || $kk =='bcity' || $kk =='bstate' || $kk =='bzipcode' || $kk =='bcountry' || $kk =='customer_priority' || $kk =='sla_expdate' || $kk =='numlocations' || $kk =='active' || $kk =='sla' || $kk =='sla_serialno' || $kk =='upsell_oppt' || $kk =='description' ||  $kk =='ipoints' ||  $kk =='ppoints' || $kk =='billing' || $kk=='share_user_title' ) { 

				

				

				} else {

				

				$rces  = get_account_custom_fields($key,$ref_id);

				

				$tempcrow[$key] = $rces[0]->cv;

				

				}

				}

				$frow[] = $tempcrow;

				} 

				 

			

			// END CUSTOM DATA

			

			   $this->_data['accounts'] = $frow;

				$this->_data['selectedcolumns'] =  $ff_Results['contact'];

				$this->_data['columnlabels'] =  acol_fields();

				$this->_data['account_customField_values'] =  $acustom_field_labels;

				

				/*echo "<pre>";

				  print_r($ff_Results['contact']);

				echo "</pre>";

				

				echo "<pre>";

				  print_r(acol_fields());

				echo "</pre>";

				

				

				exit; */

				

				

			$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>2));

			if($mpaged == 1)

				$this->load->view('crm/accounts-ajax-list', $this->_data);

			else

				$this->load->view('crm/accounts-list', $this->_data);

		

		}



	}



	//leads



	function leadsN($action = NULL)



	{



		$this->_data['crmlite'] = 'lead';



		$pam3 = $this->uri->segment(3);//edit/delete



		$pam4 = $this->uri->segment(4);//id



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$this->crm->delete_lead((int)$pam4);



			redirect(base_url() . 'crm/leads');



		}



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;



			$record = $this->crm->get_lead($id);



			if(!$record) redirect(base_url() . 'crm/leads');



			$this->_data['record'] = $record;



		}



		if($pam3=="edit") {



			$id = (int)$pam4;			



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['user_first'])) $er['user_first']="First name required";



				if(empty($record['user_last'])) $er['user_last']="Last name required";



				if(empty($record['user_company'])) $er['user_company']="Company required";



				if(!empty($record['email'])) {



					$this->load->helper('email');



					if (!valid_email($record['email'])) $er['email']="Enter valid email address";



				}



				if(empty($record['lead_status'])) $er['lead_status']="Lead status required";



				if(!empty($record['revenue'])) {



					if(!is_numeric($record['revenue'])) $er['revenue']="Annual Revenue Must be number";



				}



				if(!empty($record['employees'])) {



					if(!is_numeric($record['employees'])) $er['employees']="Employees Must be number";



				}



				if(!empty($record['numlocations'])) {



					if(!is_numeric($record['numlocations'])) $er['numlocations']="Number of Locations Must be number";



				}



				if(!$er) {



					$address1 = $record['home'];



					unset($record['home']);



					if(!$id) $record['create_date']=date("Y-m-d H:i:s");



					$record['modify_date']=date("Y-m-d H:i:s");



					$cid = $this->crm->save_lead($record,$id);



					if($cid) {



						$this->crm->delete_address($id,'L');



						$address1 = array_filter($address1);



						if($address1) {



							$address1['parent_id']=$cid;



							$address1['adr_type']='home';



							$address1['parent_type']='L';



							$this->crm->save_address($address1);



						}



					}



					redirect(base_url() . 'crm/leads/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			$this->load->view('crm/lead-edit', $this->_data);



		}



		else if($pam3=="view") $this->load->view('crm/lead-view', $this->_data);



		else {



			$this->_data['leads'] = $this->crm->get_all_leads();



			$this->load->view('crm/leads-list', $this->_data);



		}	



	}



	//opportunities



	function opportunities($action = NULL)



	{



		$this->_data['crmlite'] = 'opportunity';



		$pam3 = $this->uri->segment(3);//edit/delete



		$pam4 = $this->uri->segment(4);//id

		

		$pam5 = $this->uri->segment(5);//extra slug parameter

		

		

		

		if($this->input->post('ccblock')=="opportunitychilds") {

			//echo "test123";

			$id = (int)$pam4;

			$this->_data['opporunity_id'] = $id;

			

			$this->_data['notes_list'] = $this->crm->get_all_notes($id,'O',10);			

			

			$this->_data['otasks_list'] = $this->crm->get_all_tasks($id,'O',10,2);



			$this->_data['atasks_list'] = $this->crm->get_all_tasks($id,'O',10,1);

			

			$html = $this->load->view('crm/opportunity-view-childs', $this->_data,true);

			echo $html;

			exit;	

	   }

	   

	   

	   if($this->input->post('action')=="graph") {



			$this->ppChartData($this->input->post('cid'),'O',$this->input->post('gft'));



			echo $this->_data['chartData'];



			exit;



		}







		//delete all		



		if($this->input->post('action')=="deleteall") {			



			$record=$this->input->post('recids');



			if($record) {



				foreach($record as $rcid) $this->crm->delete_opportunity($rcid);



			}



			redirect(current_url());



		}



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$record = $this->crm->get_opportunity($id,$this->_parent_users);



			if(!$record) redirect(base_url() . 'crm/opportunities');



			$this->crm->delete_opportunity($id);



			redirect(base_url() . 'crm/opportunities');



		}



		$breadcrumbs = array();



		if($pam3=="all" || !empty($pam4)) $breadcrumbs[] = array('label'=>'Opportunities','url'=>base_url('crm/opportunities/all'));



		else $breadcrumbs[] = array('label'=>'Opportunities','url'=>base_url('crm/opportunities'));



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;			



			$record = $this->crm->get_opportunity($id,$this->_parent_users);



			if(!$record) redirect(base_url() . 'crm/opportunities');



			if((int)$record['close_date']) $record['close_date']=date("m/d/Y",strtotime($record['close_date']));



			else $record['close_date']="";



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);



			$this->_data['record'] = $record;



			$breadcrumbs[] = array('label'=>ucfirst($record[oppt_name]),'url'=>base_url('crm/opportunities/view/'.$id));



			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');



			//Quick Update opportunity record



			$this->quick_update_opportunity($id);



		}



		//contact opportunity



		if((int)$pam4 && $pam3=="contact") {



			$contact_id = (int)$pam4;



			$crecord = $this->crm->get_contact($contact_id);



			if(!$crecord) redirect(base_url() . 'crm/contacts');



			$this->_data['contact_id'] = $contact_id;



			//Auto Fill account details



			if($crecord[account_id]) {



				$record['account_id']=$crecord[account_id];



				$record['account_title']=ucfirst($crecord['account_title']);



				$this->_data['record']=$record;



			}



			$breadcrumbs[] = array('label'=>'Contact: '.ucfirst($crecord[user_first].' '.$crecord[user_last]),'url'=>base_url('crm/contacts/view/'.$contact_id));



			$pam3="edit";



			$pam4='';



		}



		//account opportunity



		if((int)$pam4 && $pam3=="account") {



			$account_id = (int)$pam4;



			$arecord = $this->crm->get_account($account_id);



			if(!$arecord) redirect(base_url() . 'crm/accounts');



			$record['account_title']=ucfirst($arecord['account_name']);



			$breadcrumbs[] = array('label'=>'Account: '.ucfirst($arecord['account_name']),'url'=>base_url('crm/accounts/view/'.$account_id));



			$record['account_id']=$account_id;



			$this->_data['record']=$record;



			$pam3="edit";



			$pam4='';



		}



		$this->_data['breadcrumbs']=$breadcrumbs;



		if($pam3=="edit") {



			$id = (int)$pam4;



			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['close_date'])) $er['close_date']="Close date required";



				if(empty($record['oppt_name'])) $er['oppt_name']="Opportunity required";



				if(empty($record['stage'])) $er['stage']="Stage required";



				if(!empty($record['amount'])) {



					if(!is_numeric($record['amount'])) $er['amount']="Amount Must be number";



				}



				if(!empty($record['probability'])) {



					if(!is_numeric($record['probability'])) $er['probability']="Probability Must be number";



					else if((float)$record['probability']>100 || (float)$record['probability']<0) $er['probability']="Probability Must be between 0 to 100%";



				}



				if(!$er) {



					if(!$id) $record['create_date']=date("Y-m-d H:i:s");



					$record['modify_date']=date("Y-m-d H:i:s");



					$record['user_private']=$record['user_private']?1:0;



					if(!empty($record['close_date'])) {



						$tmpdate = explode("/",$record['close_date']);//m/d/y-012



						$record['close_date']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					}



					unset($record['account_title']);



					unset($record['share_user_title']);



					$cid = $this->crm->save_opportunity($record,$id);



					if($account_id) redirect(base_url() . 'crm/accounts/view/'.$account_id);



					else if($contact_id) redirect(base_url() . 'crm/contacts/view/'.$record['contact_id']);



					else redirect(base_url() . 'crm/opportunities/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			if(!$record['share_user_title']) {



				$record['share_user_id']=$this->_user_id;



				$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



				$record['share_user_title']=ucfirst($sUser[0]->usrname);



			}



			$this->_data['record']=$record;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$this->load->view('crm/opportunity-edit', $this->_data);



		}



		else if($pam3=="view") {



			$this->_data['notes_list'] = $this->crm->get_all_notes($id,'O');

			

			$total_points = $this->crm->get_totalpoints_count($id,'O');



			if($total_points[ipt]<>NULL) {



				$this->_data['total_points'] = $total_points;



				$this->ppChartData($id,'O');



			}



			$this->load->view('crm/opportunity-view', $this->_data);



		} else {



			$owner=$this->_user_id; 



			if($pam3=="all") $owner=0;

			

			$res_opp = $this->crm->get_all_opportunitys($owner);

			 

			foreach($res_opp as $resop){

			

				$opp_id = $resop->oppt_id;	

				$total_points = $this->crm->get_totalpoints_count($opp_id,'O');

				$resop->qpointst =  $total_points['ipt'];

			}


			$this->_data['opportunities'] = $res_opp;			
			
			$record_owners = array();
			$record_owners[] = $this->_data['user_id'];
			if(isset($this->_data['is_prolite']) && $this->_data['is_prolite']) {
				$parent_id = $this->_data['user_id'];
			} else $parent_id = $this->_data['user_id'];
			if($parent_id) {
				$record_owners[] = $parent_id;
				$share_ids = $this->home->getSharedUsers($parent_id);
				if($share_ids)
				foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
				$record_owners = array_unique($record_owners);
			}
			
			//All shared users
			$shared_users = $this->crm->get_all_shared_users($record_owners);			
			$this->_data['shared_users'] = $shared_users;

			$this->load->view('crm/opportunities-list', $this->_data);



		}	



	}


	
	
	public function opp_statistics()
	{
		$this->_data['crmlite'] = 'opp_statistics';
		if($_GET['user_id']!='All') $owner = $_GET['user_id'];
		if($_GET['sid']!='All') $stage = $_GET['sid'];
		$res_opp = $this->crm->get_all_opportunityssta($owner,$stage);
		foreach ($res_opp as $resop) {
			$opp_id = $resop->oppt_id;

			$total_points = $this->crm->get_totalpoints_count($opp_id, 'O');

			$resop->qpointst = $total_points['ipt'];
		} 
		 $this->_data['opportunities'] = $res_opp;
			
		$record_owners = array();
		$record_owners[] = $this->_data['user_id'];
		if(isset($this->_data['is_prolite']) && $this->_data['is_prolite']) {
			$parent_id = $this->_data['user_id'];
		} else $parent_id = $this->_data['user_id'];
		if($parent_id) {
			$record_owners[] = $parent_id;
			$share_ids = $this->home->getSharedUsers($parent_id);
			if($share_ids)
			foreach($share_ids as $shrid) $record_owners[] = $shrid->user_id;
			$record_owners = array_unique($record_owners);
		}
		
		//All shared users
		$shared_users = $this->crm->get_all_shared_users($record_owners);			
		$this->_data['shared_users'] = $shared_users;
		$this->load->view('crm/opportunities-list', $this->_data);	
	}
	



	//Notes



	function notes($action = NULL)



	{



		//3-contacts/4-contactid/5-edit



		//3-contacts/4-contactid



		//3-view/4-notesid



		//3-edit/4-notesid



		//3-delete/4-notesid



		



		



		$pam3 = $this->uri->segment(3);



		$pam4 = $this->uri->segment(4);



		$pam5 = $this->uri->segment(5);



		//echo "1.$pam3 2.$pam4 3.$pam5 ";



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$record = $this->crm->get_notes($id);



			if(!$record) redirect(base_url() . 'crm/contacts');



			 



			$parent_section='contacts';



			if($record['notes_parent']=='C') $parent_section='contacts';



			else if($record['notes_parent']=='A') $parent_section='accounts';



			//else if($record['notes_parent']=='O') $parent_section='opportunities';


			$this->crm->delete_notes($id,$record['notes_parentid'],$record['notes_parent']);
			redirect(base_url() . "crm/$parent_section/view/".$record['notes_parentid']);



		}



		$breadcrumbs = array();		



		//add/list



		if((int)$pam4 && ($pam3=="contacts" || $pam3=="accounts" || $pam3=="opportunities")) {

			$parent_id = (int)$pam4;

            if ($pam3 == 'accounts') {
                $parent_record = $this->crm->get_notes_parent($parent_id, 'A');
            } elseif ($pam3 == 'opportunities') {
                $parent_record = $this->crm->get_notes_parent($parent_id, 'O');
            } else {
                $parent_record = $this->crm->get_notes_parent($parent_id, 'C');
            }

            if (!$parent_record) {
                redirect(base_url() . 'crm/contacts');
            }


			$this->_data['record'] = $record;



			$parent_section='contacts';



			$crmlite="contact";			



			if($pam3=='contacts') {$parent_section='contacts';$crmlite="contact";



				$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			}



			else if($pam3=='accounts') {$parent_section='accounts';$crmlite="account";



				$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record['account_name']),'url'=>base_url('crm/accounts/view/'.$parent_id));



			}



			$breadcrumbs[] = array('label'=>'Notes','url'=>base_url("crm/notes/$parent_section/".$parent_id));



			//else if($record['notes_parent']=='O') {$parent_section='opportunities';$crmlite="opportunity";}			



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $parent_id;



		}



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;



			$record = $this->crm->get_notes($id);
			
			



			if(!$record) redirect(base_url() . 'crm/contacts');			



			$crmlite="contact";



			



			if($record['notes_parent']=='C') {$parent_section='contacts';$crmlite="contact";



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'C');



				if($parent_record) {					



					$this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);



					$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



					$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$record['notes_parentid']));



				}



			}



			else if($record['notes_parent']=='A') {$parent_section='accounts';$crmlite="account";



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'A');



				if($parent_record) {					



					$this->_data['parent_name']=ucfirst($parent_record['account_name']);



					$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



					$breadcrumbs[] = array('label'=>ucfirst($parent_record['account_name']),'url'=>base_url('crm/accounts/view/'.$record['notes_parentid']));



				}



			}



			else if($record['notes_parent']=='O') {$parent_section='opportunities';$crmlite="opportunity";}



			$breadcrumbs[] = array('label'=>'Notes','url'=>base_url("crm/notes/$parent_section/".$record['notes_parentid']));



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $record['notes_parentid'];



			$this->_data['record'] = $record;



			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');



		}



		$this->_data['crmlite'] = $crmlite;



		$this->_data['breadcrumbs']=$breadcrumbs;



		//add/edit



		if( (($pam3=="contacts" || $pam3=="accounts" || $pam3=="opportunities") && $pam5=="edit") || ($pam3=="edit" && $pam4) ) {



			if($pam3=="edit" && $pam4) $id = (int)$pam4;



			if($id) {



				if($record['notes_parent']=='C') {$parent_section='contacts';$crmlite="contact";}



				else if($record['notes_parent']=='A') {$parent_section='accounts';$crmlite="account";}



				else if($record['notes_parent']=='O') {$parent_section='opportunities';$crmlite="opportunity";}



				$this->_data['parent_id'] = $record['notes_parentid'];



			} else $parent_section=$pam3;



			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			$this->_data['parent_section'] = $parent_section;



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['notes_title'])) $er['notes_title']="Subject required";

				

				//document

				

				

				if(!empty($_FILES['upload']['name'])){



					$upload['upload_path'] = './upload/';



					$upload['allowed_types'] = 'gif|png|jpg|doc|docx|xls|xlsx|pdf';



					$upload['max_size'] = '2048000';



					//$ext = end(explode(".", $_FILES['upload']));



					$upload['file_name'] = time()."_".basename($_FILES['upload']['name']);



					$this->load->library('upload', $upload);



					if (!$this->upload->do_upload('upload')) {



						$error = array('error' => $this->upload->display_errors());



						$er=$error;



						//print_r($error);



					} else { 								



						$data = $this->upload->data();



						//print_r($data);



						$filename = $data['file_name'];



						$record['upload']=$filename;



					}



				}





				if(!$er) {



					if($pam3=='contacts') $parent_type='C';



					else if($pam3=='accounts') $parent_type='A';



					else if($pam3=='opportunities') $parent_type='O';



					if($parent_type) $record['notes_parent']=$parent_type;



					if($parent_id) $record['notes_parentid']=$parent_id;



					$record['notes_private']=$record['notes_private']?1:0;



					$cid = $this->crm->save_notes($record,$id);



					//Redirect to Related Parent



					redirect(base_url() . 'crm/'.$this->_data['parent_section'].'/view/'.$this->_data['parent_id']);



					//redirect(base_url() . 'crm/notes/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			$this->_data['crmlite'] = $crmlite;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$this->load->view('crm/notes-edit', $this->_data);



		} else if($pam3=="view") {



			if($record['notes_parent']=='C') {



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'C');



				if($parent_record) $this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);



			} else if($record['notes_parent']=='A') {



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'A');



				if($parent_record) $this->_data['parent_name']=ucfirst($parent_record['account_name']);



			} else if($record['notes_parent']=='O') {



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'O');



				if($parent_record) $this->_data['parent_name']=ucfirst($parent_record['oppt_name']);



			}



			$this->load->view('crm/notes-view', $this->_data);



		} else {



			if($pam3=='contacts') $parent_type='C';



			else if($pam3=='accounts') $parent_type='A';



			else if($pam3=='opportunities') $parent_type='O';



			$this->_data['parent_section']=$pam3;



			$this->_data['parent_id']=$parent_id;



			$this->_data['notes'] = $this->crm->get_all_notes($parent_id,$parent_type);



			$this->load->view('crm/notes-list', $this->_data);



		}



	}



	//Tasks



	function tasks($action = NULL)



	{



		//3-contacts/4-contactid/5-edit



		//3-contacts/4-contactid



		//3-view/4-notesid



		//3-edit/4-notesid



		//3-delete/4-notesid



		



		$crmlite = 'task';



		$pam3 = $this->uri->segment(3);



		$pam4 = $this->uri->segment(4);



		$pam5 = $this->uri->segment(5);



		//echo "1.$pam3 2.$pam4 3.$pam5 ";



		//delete all		



		if($this->input->post('action')=="deleteall") {			



			$record=$this->input->post('recids');



			if($record) {



				foreach($record as $rcid) $this->crm->delete_task($rcid);



			}



			redirect(current_url());



		}



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$record = $this->crm->get_task($id);



			if(!$record) redirect(base_url() . 'crm/contacts');



			$this->crm->delete_task($id);



			$parent_section='contacts';



			if($record['task_related']=='C') $parent_section='contacts';



			else if($record['task_related']=='A') $parent_section='accounts';



			redirect(base_url() . "crm/$parent_section/view/".$record['task_relatedto']);



		}



		$breadcrumbs = array();



		//add/list



		if((int)$pam4 && ($pam3=="contacts" || $pam3=="accounts")) {



			$parent_id = (int)$pam4;



			if($pam3=='accounts') $parent_record =$this->crm->get_notes_parent($parent_id,'A');



			//else if($pam3=='opportunities') $parent_record =$this->crm->get_notes_parent($parent_id,'O');



			else $parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/contacts');



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);			



			$parent_section=$pam3;



			$crmlite="contact";



			if($pam3=='contacts') {$crmlite="contact";



				$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



				$breadcrumbs[] = array('label'=>'Tasks','url'=>base_url('crm/tasks/contacts/'.$parent_id));



				//Related Contact



				$record['task_relatedto']=$parent_id;



				$record['related_title']=ucfirst($parent_record[user_first].' '.$parent_record[user_last]);



				$record['task_related']="C";



				$record['task_phone']=$parent_record['phone'];



				$record['task_email']=$parent_record['email'];



			}



			else if($pam3=='accounts') {$crmlite="account";



				$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record[account_name]),'url'=>base_url('crm/accounts/view/'.$parent_id));



				$breadcrumbs[] = array('label'=>'Tasks','url'=>base_url('crm/tasks/accounts/'.$parent_id));



				//Related Account



				$record['task_relatedto']=$parent_id;



				$record['related_title']=ucfirst($parent_record[account_name]);



				$record['task_related']="A";



				$record['task_phone']=$parent_record['phone'];



			}



			/*else if($pam3=='opportunities') {$crmlite="opportunity";



				$breadcrumbs[] = array('label'=>'Opportunity: '.ucfirst($parent_record[oppt_name]),'url'=>base_url('crm/opportunities/view/'.$parent_id));



			}*/



			$this->_data['record'] = $record;



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $parent_id;



		}



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;



			$record = $this->crm->get_task($id);



			if(!$record) redirect(base_url() . 'crm/contacts');



			if((int)$record['task_duedate']) $record['task_duedate']=date("m/d/Y",strtotime($record['task_duedate']));



			else $record['task_duedate']="";			



			$crmlite="contact";



			if($record['task_related']=='C') {$parent_section='contacts';$crmlite="contact";}



			else if($record['task_related']=='A') {$parent_section='accounts';$crmlite="account";}



			//else if($record['task_related']=='O') {$parent_section='opportunities';$crmlite="opportunity";}



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $record['task_relatedto'];



			if($record['task_related']=='C') {



				$parent_record =$this->crm->get_notes_parent($record['task_relatedto'],'C');



				if($parent_record) {



					$this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);



					$record[related_title]=$this->_data['parent_name'];



					$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



					$breadcrumbs[] = array('label'=>$this->_data['parent_name'],'url'=>base_url('crm/contacts/view/'.$record['task_relatedto']));



					$breadcrumbs[] = array('label'=>'Task','url'=>base_url('crm/tasks/contacts/'.$record['task_relatedto']));



				}	



			} else if($record['task_related']=='A') {



				$parent_record =$this->crm->get_notes_parent($record['task_relatedto'],'A');



				if($parent_record) {



					$this->_data['parent_name']=ucfirst($parent_record['account_name']);



					$record[related_title]=$this->_data['parent_name'];



					$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



					$breadcrumbs[] = array('label'=>$this->_data['parent_name'],'url'=>base_url('crm/accounts/view/'.$record['task_relatedto']));



					$breadcrumbs[] = array('label'=>'Task','url'=>base_url('crm/tasks/accounts/'.$record['task_relatedto']));



				}



			}



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);



			$this->_data['record'] = $record;



			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');



			//Quick Update task record



			$this->quick_update_task($id);



		}



		if(empty($breadcrumbs)) {



			$breadcrumbs[] = array('label'=>'Task','url'=>base_url('crm/tasks'));



		}



		$this->_data['crmlite'] = $crmlite;



		$this->_data['breadcrumbs']=$breadcrumbs;



		//add/edit



		if( (($pam3=="contacts" || $pam3=="accounts" || $pam3=="opportunities") && $pam5=="edit") || ($pam3=="edit" && $pam4) || $pam3=="edit" ) {



			if($pam3=="edit" && $pam4) $id = (int)$pam4;



			if($pam3=="edit" && empty($pam4)) $breadcrumbs[] = array('label'=>'Task','url'=>base_url('crm/tasks'));



			if($id) {



				if($record['task_related']=='C') {$parent_section='contacts';$crmlite="contact";}



				else if($record['task_related']=='A') {$parent_section='accounts';$crmlite="account";}



				else if($record['task_related']=='O') {$parent_section='opportunities';$crmlite="opportunity";}



				$this->_data['parent_id'] = $record['task_relatedto'];



			} else $parent_section=$pam3;



			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			$this->_data['parent_section'] = $parent_section;



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['task_subject'])) $er['task_subject']="Subject required";



				if(empty($record['related_title'])) $er['related_title']="Related To required";



				if(!empty($record['task_email'])) {



					$this->load->helper('email');



					if (!valid_email($record['task_email'])) $er['task_email']="Enter valid email address";



				}



				if(!$er) {



					if(!empty($record['task_duedate'])) {



						$tmpdate = explode("/",$record['task_duedate']);//m/d/y-012



						$record['task_duedate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					}



					unset($record['related_title']);



					unset($record['share_user_title']);



					$parent_type = $record['task_related'];



					$parent_id=$record['task_relatedto'];



					$cid = $this->crm->save_task($record,$id);



					//Redirect to Related Parent



					if($parent_type=='C') redirect(base_url() . 'crm/contacts/view/'.$parent_id);



					else if($parent_type=='A') redirect(base_url() . 'crm/accounts/view/'.$parent_id);



					else redirect(base_url() . 'crm/tasks/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			if(!$record['share_user_title']) {



				$record['share_user_id']=$this->_user_id;



				$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



				$record['share_user_title']=ucfirst($sUser[0]->usrname);



				$this->_data['record']=$record;



			}



			$this->_data['crmlite'] = $crmlite;			



			$this->_data['breadcrumbs']=$breadcrumbs;

			$parent_type = $record['task_related'];
			if ($parent_type == 'C') {
				$contactList = $this->crm->get_contactinfo_id($this->_data['record']['task_relatedto']);
				if($this->_data['record']['task_phone']) $this->_data['record']['task_phone'] = $this->_data['record']['task_phone'];
				else $this->_data['record']['task_phone'] = $contactList[0]->phone;
				
				if($this->_data['record']['task_email']) $record['task_email'] = $this->_data['record']['task_email'];
				else $this->_data['record']['task_email'] = $contactList[0]->email;
			}
			
			if ($parent_type == 'A') {
				$contactList = $this->crm->get_account_contacts($this->_data['record']['task_relatedto']);
				if($this->_data['record']['task_phone']) $this->_data['record']['task_phone'] = $this->_data['record']['task_phone'];
				else $this->_data['record']['task_phone'] = $contactList[0]->phone;
				
				if($this->_data['record']['task_email']) $record['task_email'] = $this->_data['record']['task_email'];
				else $this->_data['record']['task_email'] = $contactList[0]->email;
			}

			$this->load->view('crm/task-edit', $this->_data);



		} else if($pam3=="view") {

			$parent_type = $record['task_related'];
			if ($parent_type == 'C') {
				$contactList = $this->crm->get_contactinfo_id($this->_data['record']['task_relatedto']);
				if($this->_data['record']['task_phone']) $this->_data['record']['task_phone'] = $this->_data['record']['task_phone'];
				else $this->_data['record']['task_phone'] = $contactList[0]->phone;
				
				if($this->_data['record']['task_email']) $record['task_email'] = $this->_data['record']['task_email'];
				else $this->_data['record']['task_email'] = $contactList[0]->email;
			}
			
			if ($parent_type == 'A') {
				$contactList = $this->crm->get_account_contacts($this->_data['record']['task_relatedto']);
				if($this->_data['record']['task_phone']) $this->_data['record']['task_phone'] = $this->_data['record']['task_phone'];
				else $this->_data['record']['task_phone'] = $contactList[0]->phone;
				
				if($this->_data['record']['task_email']) $record['task_email'] = $this->_data['record']['task_email'];
				else $this->_data['record']['task_email'] = $contactList[0]->email;
			}			

			$this->load->view('crm/task-view', $this->_data);



		} else {



			if($pam3=='contacts') $parent_type='C';



			else if($pam3=='accounts') $parent_type='A';



			else if($pam3=='opportunities') $parent_type='O';



			$this->_data['parent_section']=$pam3;



			$this->_data['parent_id']=$parent_id;



			if($parent_id)



				$this->_data['tasks_list'] = $this->crm->get_all_tasks($parent_id,$parent_type,0,1);



			else $this->_data['tasks_list'] = $this->crm->get_all_tasks(0,'',0,2);



			$this->load->view('crm/tasks-list', $this->_data);



		}



	}

	

	

	function edata()

	{ 

	   // get data $data = array(); 

	   $data['usersData'] = $this->crm->getContactDetails();

	   // load view 

	   $this->load->view('crm/export-data', $data);

	}

	public function exportContactCSV(){ 

	   // file name 

	   $filename = 'crm_contacts_'.date('Ymd').'.csv'; 

	   header("Content-Description: File Transfer"); 

	   header("Content-Disposition: attachment; filename=$filename"); 

	   header("Content-Type: application/csv; ");

	   

		$where = array();

		$where['user_id'] = $this->_user_id;

		$where['field_type'] = 'custom';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];



		$custom = array();

		if(isset($user_info->value)) {

			$custom=unserialize($user_info->value);

		}



				

	   // get data 

	   $usersData = $this->crm->getContactDetails();

	   $rces  = get_custom_fields($key,$ref_id);

	

	   // file creation 

	   $file = fopen('php://output', 'w');

	 

	   $header = array("User Prefix","First Name","Last Name","Title","Department","Birthdate","Lead Source","Phone","Home Phone","Mobile","Other Phone","Fax","Email","Assistant","Asst. Phone","Description","Create Date","Modify Date","Unsubscribed","LinkedIn Profile","Website","Quality Points","Pursuit Points","MailChimp Last Time","MailChimp Cron Time","MailChimp Cron","MailChimp List","MailChimp List Cron");

	   

	  

	   $contact_titles = array_merge($header,$layout_field_options);

	   

	   fputcsv($file, $header);

	   foreach ($usersData as $key=>$line) 

	   { 

		 

		 fputcsv($file,$line);

	   }

	   fclose($file); 

	   //exit; 

   }





   public function exportAccountCSV(){ 

	   // file name 

	   $filename = 'crm_accounts_'.date('Ymd').'.csv'; 

	   header("Content-Description: File Transfer"); 

	   header("Content-Disposition: attachment; filename=$filename"); 

	   header("Content-Type: application/csv; ");

	   

		$where = array();

		$where['user_id'] = $this->_user_id;

		$where['field_type'] = 'custom';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];



		$custom = array();

		if(isset($user_info->value)) {

			$custom=unserialize($user_info->value);

		}



				

	   // get data 

	   $usersData = $this->crm->getAccountDetails();

	

	   // file creation 

	   $file = fopen('php://output', 'w');

	 

	   $header = array("Account ID","User ID","Share User ID","Account Name","Account Parent","Account Number","Account Site","Account Type","Industry","Revenue","Rating","Phone","Fax","Website","Ticker Symbol","Ownership","Employees","SIC Code","Customer Priority","SLA EXPDate","NumLocations","ACTIVE","SLA","SLA Serial Number","Upsell Opportunity","Description","Create Date","Modify Date","Target","SFID","Quality Points","Pursuit Points");

	   

	  

	   $contact_titles = array_merge($header,$layout_field_options);

	   

	   fputcsv($file, $header);

	   foreach ($usersData as $key=>$line) 

	   { 

		 

		 fputcsv($file,$line);

	   }

	   fclose($file); 

	   //exit; 

   }

	

	 

	function custom_checking() {

	

		$layout_fields = col_fields();

		$layout_keys = array_keys($layout_fields);

		$contact_fields = $layout_keys;

		//Custom Fields

		//Contacts

		$where = array();

		$where['user_id'] = $this->_user_id;

		$where['field_type'] = 'custom';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];



		$custom = array();

		if(isset($user_info->value)) {

			$custom=unserialize($user_info->value);

		}

		if($custom) {

			foreach($custom as $ck=>$cv){

				 if($ck!='kcount')

				 {

					$layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				 }

			}

		}

		

		$this->_data['layout_fields']=$layout_fields;		

		foreach($layout_fields  as $key=>$val) $layout_field_options .= '<option value="'.$key.'">'.$val['label'].'</option>';

		$this->_data['layout_field_options'] = $layout_field_options;		

		//echo '<pre>'; print_r($layout_field_options); echo '</pre>';

		?>

		<div class="col-sm-3 one A">Not Mapped</div>

		<div class="col-sm-3 two">

			<input type="hidden" name="position[]" value="" />

			<div class="selector">

				<select name="fields[]" class="tbcol" style="position:relative; opacity:1;

				 border:0px; padding-top:5px;">

					<option value="no_mapping">Change Field</option>

					<option value="no_mapping">Not Mapped</option>

					<?php echo $layout_field_options?>

				</select>

			</div>

		</div>

		<?php   

	}  

	

	

	

	function acustom_checking() { 

	

		$alayout_fields = alayout_fields();

		$alayout_keys = array_keys($alayout_fields);

		$account_fields = $alayout_keys;

		//Custom Fields

		//Contacts

		$where = array();

		$where['user_id'] = $this->_user_id;

		$where['field_type'] = 'customa';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];



		$custom = array();

		if(isset($user_info->value)) {

			$custom=unserialize($user_info->value);

		}

		if($custom) 

		{

			foreach($custom as $ck=>$cv){

			 if($ck!='kcount')

			 {

				$alayout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

			 }

			}

		}

		$this->_data['alayout_fields']=$alayout_fields;		

		foreach($alayout_fields  as $key=>$val) $alayout_field_options .= '<option value="'.$key.'">'.$val['label'].'</option>';

		$this->_data['alayout_field_options'] = $alayout_field_options;		

		//echo '<pre>'; print_r($alayout_field_options); echo '</pre>';

		?>

		<div class="col-sm-3 one A">Not Mapped</div>

		<div class="col-sm-3 two" style="margin-right:20px;">

			<input type="hidden" name="position[]" value="" />

			<div class="selector">

				<select name="afields[]" class="tbcol" style="position:relative; opacity:1;

				 border:0px; padding-top:5px; width:103px !important;">

					<option value="no_mapping">Change Field</option>

					<option value="no_mapping">Not Mapped</option>

					<?php echo $alayout_field_options?>

				</select>

			</div>

			

			

		</div>

		<?php     

	}  

	

	

	

	//Accounts Lookup 



	function accounts_lookup()



	{



		//$this->_data['accounts'] = $this->crm->get_all_accounts(0,0,$this->_parent_users);

		//$this->load->view('crm/account-search', $this->_data);



		//Search & Pagination

		$accountsurl = "crm/accounts_lookup";

		$perpage = 50;

		$pgoffset = $this->input->get('per_page')?$this->input->get('per_page'):0;

		$skey = $this->input->get('search')?$this->input->get('search'):'';

		$qsearch = "";

		$sparam = "";

		if($skey) {

			$skey_parts = explode(" ",$skey);

			foreach($skey_parts as $skpart) {

				if($qsearch) $qsearch .=" OR ";

				$qsearch .= " a.account_name like '%$skpart%' OR a.phone like '%$skpart%' ";

			}

			if($qsearch) $qsearch =" ($qsearch) ";

			$sparam = "search=$skey";

		}

		$total_records = $this->crm->get_accounts_total(0,0,$this->_parent_users,$perpage,$qsearch,$pgoffset);



		$this->load->library('pagination');

		$config['base_url'] = base_url($accountsurl)."/?".$sparam;

		$config['total_rows'] = $total_records;

		$config['per_page'] = $perpage;

		$config['num_links'] = 5;

		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);



		$this->_data['searchkey'] = $skey;

		$this->_data['records_info'] = "";

		$this->_data['accounts'] = array();

		if($total_records) {

			$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

			if($to2>$total_records) $to2 = $total_records;

			$this->_data['accounts'] = $this->crm->get_all_accounts(0,0,$this->_parent_users,$perpage,$qsearch,$pgoffset);

			$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

		}

		$this->load->view('crm/account-search-lookup', $this->_data);



	}

	

	

	function opportunity_lookup()



	{

		//Search & Pagination

		$opportunityurl = "crm/opportunity_lookup";

		$perpage = 50;

		$pgoffset = $this->input->get('per_page')?$this->input->get('per_page'):0;

		$skey = $this->input->get('search')?$this->input->get('search'):'';

		$qsearch = "";

		$sparam = "";

		if($skey) {

			$skey_parts = explode(" ",$skey);

			foreach($skey_parts as $skpart) {

				if($qsearch) $qsearch .=" OR ";

				$qsearch .= " o.oppt_name like '%$skpart%'";

			}

			if($qsearch) $qsearch =" ($qsearch) ";

			$sparam = "search=$skey";

		}

		$total_records = $this->crm->get_opportunity_total(0,0,$this->_parent_users,$perpage,$qsearch,$pgoffset);



		$this->load->library('pagination');

		$config['base_url'] = base_url($opportunityurl)."/?".$sparam;

		$config['total_rows'] = $total_records;

		$config['per_page'] = $perpage;

		$config['num_links'] = 5;

		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);



		$this->_data['searchkey'] = $skey;

		$this->_data['records_info'] = "";

		$this->_data['opportunities'] = array();

		if($total_records) {

			//echo $total_records;

			$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

			if($to2>$total_records) $to2 = $total_records;

			//$this->_data['opportunity'] = $this->crm->get_all_opportunitys(0,0,$this->_parent_users,$perpage,$qsearch,$pgoffset);

			$owner=$this->_user_id;

			$this->_data['opportunities'] = $this->crm->get_all_opportunitys($owner,$perpage,$qsearch,$pgoffset);

			//echo '<pre>'; print_r($this->_data['opportunities']); echo '</pre>';

			$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

		}



		//$this->_data['accounts'] = $this->crm->get_all_accounts(0,0,$this->_parent_users);

		//$this->load->view('crm/account-search', $this->_data);

		$this->load->view('crm/opportunity-search-lookup', $this->_data);



	}



	//Contact Lookup



	function contacts_lookup()



	{



		//$this->_data['contacts'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);

		//$this->load->view('crm/contact-search', $this->_data);



		//Search & Pagination

		$perpage = 50;

		$contactsurl = "crm/contacts_lookup";

		$pgoffset = $this->input->get('per_page')?$this->input->get('per_page'):0;

		$skey = $this->input->get('search')?$this->input->get('search'):'';

		$qsearch = "";

		$sparam = "";

		if($skey) {

			$skey_parts = explode(" ",$skey);

			/*foreach($skey_parts as $skpart) {

				if($qsearch) $qsearch .=" OR ";

				$qsearch .= " c.user_first like '%$skpart%' OR c.user_last like '%$skpart%' OR c.user_title like '%$skpart%' OR c.phone like '%$skpart%' OR c.email like '%$skpart%' ";

			}*/

			$qsearch = " CONCAT( c.user_first,  ' ', c.user_last ) LIKE  '%$skey%'  OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

			if($qsearch) $qsearch =" ($qsearch) ";

			$sparam = "search=$skey";

		}

		$total_records = $this->crm->get_all_contacts_total(0,0,$this->_parent_users,$perpage,$qsearch,$pgoffset);



		$this->load->library('pagination');

		

		$config['base_url'] = base_url($contactsurl)."/?".$sparam;

		$config['total_rows'] = $total_records;

		$config['per_page'] = $perpage;

		$config['num_links'] = 5;

		$config['page_query_string'] = TRUE;

		$this->pagination->initialize($config);



		$this->_data['searchkey'] = $skey;

		$this->_data['records_info'] = "";					

		$this->_data['contacts'] = array();

		if($total_records) {

			$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

			if($to2>$total_records) $to2 = $total_records;

			$this->_data['contacts'] = $this->crm->get_all_contacts(0,0,$this->_parent_users,$perpage,$qsearch,$pgoffset);

			$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

		}

		$this->load->view('crm/contact-search-lookup', $this->_data);



	}



	//Share User Lookup



	function share_user_lookup()



	{



		$this->_data['sharedUsers'] = $this->crm->get_all_shared_users($this->_parent_users);



		$this->load->view('crm/shared-user-search', $this->_data);



	}



	//Qualifier



	function qualifier($action = NULL)



	{



		$crmlite = 'qualifier';



		$pam3 = $action;



		$pam4 = $this->uri->segment(4);		



		$parent_id = (int)$pam4;

		

		

		/*Sales Questions*/

		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);

		//echo '<pre>'; print_r($active_campaign_data); echo '</pre>';

		$active_campaign = $active_campaign_data->campaign_id;		

		//echo $active_campaign;

		$tabdata = $this->campaign->getCatQuestions($active_campaign,$this->_user_id);//by Dev@4489

		$this->_data['tabtitles'] = $tabdata;		

		//echo '<pre>'; print_r($this->_data['tabtitles']); echo '</pre>';

		//$this->_data['title'] = $this->campaign->getQuestionBuilderTitle($active_campaign,$this->_user_id,$this->input->post('squestions_type'));//by Dev@4489		

		$this->_data['questions'] = $this->campaign->getQualifyQuest($active_campaign);

		$this->_data['need_want_qus'] = $this->campaign->getallSalesQuestion($active_campaign,'tab2');//by Dev@4489

		$this->_data['funding_availability'] = $this->campaign->getallSalesQuestion($active_campaign,'tab3');//by Dev@4489

		$this->_data['decision_authority'] = $this->campaign->getallSalesQuestion($active_campaign,'tab4');//by Dev@4489

		$this->_data['intent_purchase'] = $this->campaign->getallSalesQuestion($active_campaign,'tab5');//by Dev@4489



		if($pam3=='contact' && $parent_id) {



			//Contact qualifier



			$parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/qualifier');



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'Qualifier','url'=>base_url('crm/qualifier/contact/'.$parent_id));



			$this->_data['parent_id'] = $parent_id;



			//Contact defaults



			$record['contact']=$parent_id;



			$record['contact_title']=ucfirst($parent_record[user_first].' '.$parent_record[user_last]);



			$this->_data['record']=$record;



			$this->_data['parent_section']="contacts";



		} else if($pam3=='account' && $parent_id) {	



			//Account qualifier



			$parent_record =$this->crm->get_notes_parent($parent_id,'A');



			if(!$parent_record) redirect(base_url() . 'crm/qualifier');



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[account_name]),'url'=>base_url('crm/accounts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'Qualifier','url'=>base_url('crm/Qualifier/account/'.$parent_id));



			$this->_data['parent_id'] = $parent_id;



			$record['account']=$parent_id;



			$record['account_title']=ucfirst($parent_record[account_name]);



			$this->_data['record']=$record;



			$this->_data['parent_section']="accounts";



		} 

		

		

		else if($pam3=='opportunities' && $parent_id) {	

		

			$parent_record =$this->crm->get_notes_parent($parent_id,'O');

			

			if(!$parent_record) redirect(base_url() . 'crm/qualifier');



			$breadcrumbs[] = array('label'=>'Opportunities','url'=>base_url('crm/opportunities'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[oppt_name]),'url'=>base_url('crm/opportunities/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'Qualifier','url'=>base_url('crm/qualifier/opportunities/'.$parent_id));

			

			$this->_data['parent_id'] = $parent_id;



			$this->_data['opportunities'] = $parent_id;

			

			$this->_data['opportunities_title'] = ucfirst($parent_record[oppt_name]);

			

			$this->_data['record']=$record;



			$this->_data['parent_section'] = "oportunities";



		}

		

		else {



			//default qualifier



			$this->_data['parent_id'] = 0;



			$breadcrumbs[] = array('label'=>'Qualifier','url'=>base_url('crm/qualifier'));



		}



		//Campaign Questions answers

		

		if($this->input->post('act')=="questions" && $this->input->post('id')) 

		{

			$this->campaign->changeCampaign($this->input->post('id'),$this->_user_id);

			exit;

		}



		$qualifier_data = qualifier_questions();



		if($this->input->post('action')=="save") {



			$record=$this->input->post('record');



			//echo "<pre>";print_r($record);echo "</pre>";exit;



			$qtitles = array();

			$i=0;

			foreach($tabdata as $key=>$val)

			{

				$i++;

				$qtitles[$i] = $val->title;

			}

			$qsections = $qtitles;

			//echo '<pre>'; print_r($qtitles); echo '</pre>';

			if($qtitles) $qsections = $qtitles;

			else $qsections = $qualifier_data['sections'];



			$er = array();



			//if(empty($record['contact'])) $er['contact']="Contact required";



			if(empty($record['contact']) && empty($record['account']) && empty($record['opportunity'])) $er['contact']="Atleast Contact/Account/Opportunity required";



			if(empty($record['campaign'])) $er['campaign']="Sales Pitch Campaign required";



			$tasknotes='';



			$sect = 0;



			$qpoints = 0;



			foreach($record['section'] as $si=>$sblock) {



				$temp = '';



				foreach($sblock['task_notes'] as $qi=>$qv) {



					$sectn = $si;



					$sqp = $sblock['qp'][$qi];



					if(!empty($qv) || (isset($sqp) && $sqp<>"0")) {



						$temp .=$sblock['task_label'][$qi]."\n";



						if(!empty($qv)) $temp .=" - ".$qv."\n";



						if((isset($sqp) && $sqp<>"0")) {$temp .=" - Quality Points: $sqp\n";$qpoints +=$sqp;}



						$temp .= "\n";	



					}



					$sect = $sectn;



				}



				if($temp) $tasknotes .=$qsections[$si]."\n".$temp;



			}



			/*foreach($record['task_notes'] as $qi=>$qv) {



				$sectn = $record['section'][$qi];



				$sqp = $record['qp'][$qi];



				if(!empty($qv) || (isset($sqp) && $sqp<>"0")) {



					if($sectn<>$sect) $tasknotes .=$qsections[$sectn]."\n";



					$tasknotes .=$record['task_label'][$qi]."\n";



					if(!empty($qv)) $tasknotes .=" - ".$qv."\n";



					if((isset($sqp) && $sqp<>"0")) {$tasknotes .=" - Quality Points:$sqp\n";$qpoints +=$sqp;}



				}



				$sect = $sectn;



			}*/



			if(empty($tasknotes)) $er['notes']="Please enter atleast one notes";



			//echo $tasknotes;exit;



			if(!$er) {



				$cid = 0;



				$cid1 = 0;



				$cid2 = 0;

				

				$cif = 3;



				//Contact Notes



				$parent_id = $record['contact'];



				if($record['contact']) {



					$notes_data = array(



								'notes_title'=>"Questions / Answers",



								'notes_parent'=>'C',



								'notes_parentid'=>$parent_id,



								'notes_info'=>$tasknotes



								);



					$cid1 = $this->crm->save_notes($notes_data,0);	



				}



				



				//Account Notes



				$parent_id2 = $record['account'];



				if($record['account']) {



					$notes_data = array(



								'notes_title'=>"Questions / Answers",



								'notes_parent'=>'A',



								'notes_parentid'=>$parent_id2,



								'notes_info'=>$tasknotes



								);



					$cid2 = $this->crm->save_notes($notes_data,0);	



				}

				

				//Opportunity Notes



				$parent_id3 = $record['opportunity'];



				if($parent_id3) {



					$notes_data = array(



								'notes_title'=>"Questions / Answers",



								'notes_parent'=>'O',



								'notes_parentid'=>$parent_id3,



								'notes_info'=>$tasknotes



								);

					//echo '<pre>'; print_r($notes_data); echo '</pre>';

					//exit;



					$cid3 = $this->crm->save_notes($notes_data,0);	



				}				



				



				//Qaulity points				



				if($qpoints<>0) {



					$idate = date("Y-m-d");



					//Contact points



					//check points and save



					if($record['contact']) {



						$where = array('contact'=>$record['contact'],'cat'=>0,'pdate'=>$idate,'rctype'=>'C', 'noteid' => $cid1);



						$cont_points = $this->crm->get_npoints($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['contact'],



									'cat'=>0,



									'pdate'=>$idate,



									'rctype'=>'C'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$qpoints,



									'purpoints'=>$cont_points['purpoints']



									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['contact'],



									'cat'=>0,



									'rctype'=>'C',



									'pdate'=>$idate,



									'noteid'=>$cid1,



									'intpoints'=>$qpoints,



									'purpoints'=>0



									);			



							$this->crm->save_points($points_data);



						}	



					}



					



					//Account points



					//check points and save



					if($record['account']) {



						$where = array('contact'=>$record['account'],'cat'=>0,'pdate'=>$idate,'rctype'=>'A', 'noteid' => $cid2);



						$cont_points = $this->crm->get_npoints($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['account'],



									'cat'=>0,



									'pdate'=>$idate,



									'rctype'=>'A'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$qpoints,



									'purpoints'=>$cont_points['purpoints']



									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['account'],



									'cat'=>0,



									'rctype'=>'A',



									'pdate'=>$idate,



									'noteid'=>$cid2,



									'intpoints'=>$qpoints,



									'purpoints'=>0



									);						



							$this->crm->save_points($points_data);



						}	



					}

					

					

					//Opportunity points



					//check points and save



					if($record['opportunity']) {



						$where = array('contact'=>$record['opportunity'],'cat'=>0,'pdate'=>$idate,'rctype'=>'O', 'noteid' => $cid3);



						$cont_points = $this->crm->get_npoints($where);

						

						//echo '<pre>'; print_r($cont_points); echo '</pre>';



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['opportunity'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'O'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$qpoints,



									'purpoints'=>$cont_points['purpoints']



									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['opportunity'],



									'rctype'=>'O',



									'cat'=>0,



									'pdate'=>$idate,



									'noteid'=>$cid3,



									'intpoints'=>$qpoints,



									'purpoints'=>0



									);						



							$this->crm->save_points($points_data);



						}	



					}





					



				}



				//redirect(base_url() . 'crm/notes/view/'.$cid);



				$x='';

				if($cid1) $x=$cid1;

				else if($cid2) $x=$cid2;

				else if($cid2) $x=$cid32;

				

				$y='';

				if($record['contact']) $y=$record['contact'];

				else if($record['account']) $y=$record['account'];

				else if($record['opportunity']) $y=$record['opportunity'];

				

				echo "YES-".$x."-".$y;



			}



			echo implode("\n",$er);



			exit;



			$this->_data['er']=$er;



			$this->_data['record']=$record;



		}	



		$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['crmlite'] = $crmlite;



		//For Shared User



		if($this->_data['eLusrNotBS']) {



			$LoggedUser = $this->_user_id;



			$this->_user_id = $this->_data['eLusrNotBS'];



			$_SESSION['ss_user_id'] = $this->_user_id;



		}



		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();



		//For Shared User



		if($this->_data['eLusrNotBS']) {



			$this->_user_id = $LoggedUser;



			$_SESSION['ss_user_id'] = $this->_user_id;



		}



		//additional tabs



		$this->load->helper('scripts');



		$this->_data['qualifier_questions'] = $qualifier_data['questions'];



		$this->_data['contacts'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);



		$this->load->view('crm/qualifier', $this->_data);



	}



	//Interaction OLD STRUCTURE	

	function interaction($action = NULL)

	{

		

		$pam3 = $action;



		$pam4 = $this->uri->segment(4);



		if(!(int)$pam4 || !($pam3=="contact" || $pam3=="account" || $pam3=="opportunities")) redirect(base_url() . 'crm/contacts');



		



		$contact = (int)$pam4;



		$parent_id = (int)$pam4;



		if($pam3=='contact' && $parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/contacts');



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/contact/'.$parent_id));



			$this->_data['crecord_id'] = $parent_id;

			

			$record['contact']=$parent_id;

			

			$this->_data['crecord_id_title'] = ucfirst($parent_record[user_first].' '.$parent_record[user_last]);



			$this->_data['parent_name'] = "Contact";



			$this->_data['parent_record'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);



		} else if($pam3=='account' && $parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'A');



			if(!$parent_record) redirect(base_url() . 'crm/accounts');



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[account_name]),'url'=>base_url('crm/accounts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/account/'.$parent_id));



			$this->_data['arecord_id'] = $parent_id;

			

			$record['account']=$parent_id;

			

			$this->_data['arecord_id_title'] = ucfirst($parent_record[account_name]);



			$this->_data['parent_name'] = "Account";



			$this->_data['parent_record'] = $this->crm->get_all_accounts(0,0,$this->_parent_users);



		} 

		else if($pam3=='opportunities' && $parent_id) {



			

		

			$parent_record =$this->crm->get_notes_parent($parent_id,'O');

			

			//echo '<pre>'; print_r($parent_record); echo '</pre>';

			//exit;



			if(!$parent_record) redirect(base_url() . 'crm/opportunities');



			$breadcrumbs[] = array('label'=>'Opportunities','url'=>base_url('crm/opportunities'));

			

			



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[oppt_name]),'url'=>base_url('crm/opportunities/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/opportunities/'.$parent_id));



			$this->_data['orecord_id'] = $parent_id;

			

			$this->_data['orecord_id_title'] = ucfirst($parent_record[oppt_name]);



			$this->_data['parent_name'] = "Oportunities";



			$this->_data['parent_record'] = $this->crm->get_all_opportunitys(0,0,$this->_parent_users);



		}

		else redirect(base_url() . 'crm/contacts');



		$parent_section=$pam3;



		$crmlite=$pam3;



		$this->load->helper('scripts');



		$categories = crm_introptions();



		$record=array();



		$this->_data['categories'] = $categories;



		if($this->input->post('action')=="save") {



			$record=$this->input->post('record');

			



			//echo "<pre>";print_r($record);echo "</pre>";

			

			//Create completed task : Log a Call/

				

			if($pam3=='contact') $ky = 'C';

			else if($pam3=='account') $ky = 'A';

			else if($pam3=='opportunities') $ky = 'O';

			

			$record_id='';

			if(isset($record['contact']) && $record['contact']>0) $record_id = $record['contact'];

			else if(isset($record['contact']) && record['account']>0) $record_id = $record['account'];

			else if(isset($record['opportunity']) && $record['opportunity']>0) $record_id = $record['opportunity'];



			$catg = 0;



			$er = array();



			//if(empty($record['record_id'])) $er['record_id']=$this->_data['parent_name']." required";

			if(empty($record['contact']) && empty($record['account']) && empty($record['opportunity'])) $er['contact']="Atleast Contact/Account/Opportunity required";



			/*if(empty($record['cat'])) $er['cat']="Category required";



			else $catg=(int)$record['cat'];*/

			$catg = 1;



			if(empty($record['idate'])) $er['idate']="Date required";



			//validate by section notes



			$notes = '';



			$points = 0;



			$pursuit = 0;



			$objection = "";



			$objections = array();



			//Track Interactions



			$interactions = array();



			//echo "<pre>";print_r($record);echo "</pre>";



			//echo "<pre>";						



			if($catg) {				



				//Cheched Options

				$CatgintOptions = $categories['category'];



				foreach($record['secnotes'] as $si=>$snval) {



					if(count($record['opt'][$si])>0 || !empty($snval)) {



						$chkval = $si;//1n1 <cat>n<sect>



						$chkval = explode("n",$chkval);//cat-sect



						//$sec_val = $categories[$chkval[0]]['sections'][$chkval[1]];

						$sect = $chkval[1];

						if($sect==1) $sec_val = $categories['category'][$chkval[0]][1];

						else $sec_val = $categories['sections'][$chkval[1]];



						//print_r($sec_val);



						$sec_opt = $sec_val['options'];



						//print_r($sec_opt);



						//$notes = $sec_val[''];



						$notes .= $sec_val['name'].":\n";



						if(count($record['opt'][$si])>0) {	



							//Editable points for Scripter User



							$epoints = 1;



							if($this->_data['is_prolite']) $epoints = 0;



							$points_qp = $record['qp'][$si];



							$points_pp = $record['pp'][$si];



							foreach($record['opt'][$si] as $oi=>$oval) {



								//objections



								$objId = 0;



								if($si==$catg."n4") {



									if($oval=="O") {//other objection



										$objection = $record['opto_txt'.$catg][$oi];



										$objId = $record['opto_id'.$catg][$oi];



										//if(empty($record['opto_select'.$catg]) && empty($record['opto_txt'.$catg])) $er['objection']="Objection other value required";



										if(empty($objection)) $er['objection']="Objection other value required";



										if($objection) {



											$notes .= "-".$objection."\n";



											$objOther = end($sec_opt);



											//Editable points for Scripter User



											if($epoints) {



												//$notes .= "Quality Points: ".$points_qp[$oval]."\n";



												$points += $points_qp[$oi];



												$pursuit += $points_pp[$oi];



											} else {



												//$notes .= "Quality Points: ".$objOther['points']."\n";



												$points += $objOther['points'];



												$pursuit += $objOther['pursuit'];	



											}



											$objections[] = array($objection,'Y');



											//Track Interactions



											if($objId) $interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$objId,'i'=>'O');



											else 



												$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>count($objections)-1,'i'=>'CO');



										}



										continue;



									} else $objections[] = array($sec_opt[$oval]['name'],'');



								}



								//Track Interactions								



								$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$oval,'i'=>'I');



								



								$notes .= "-".$sec_opt[$oval]['name']."\n";



								//Quality Points



								//Editable points for Scripter User



								if($epoints) {



									//$notes .= "Quality Points: ".$points_qp[$oval]."\n";



									$points += $points_qp[$oval];



									$pursuit += $points_pp[$oval];



								} else {



									//$notes .= "Quality Points: ".$sec_opt[$oval]['points']."\n";



									$points += $sec_opt[$oval]['points'];



									$pursuit += $sec_opt[$oval]['pursuit'];



								}



							}



						} 



						if($snval) {



							$notes .= "-".trim($snval)."\n";



						}



						$notes .= "\n";



					}



				}	



				//Schedule Follow-Up Task



				if(!empty($record['sch'][$catg]) || !empty($record['schnotes'][$catg])) {



					$notes .= "Schedule Follow-Up Task:\n";



					if($record['sch'][$catg]) {



						if($record['sch'][$catg]=="O") {



							if(empty($record['sch_txt'.$catg])) $er['sch']="Schedule Follow-Up Task other value required";



							else $record['sch'][$catg]=$record['sch_txt'.$catg];



						}



					}



					if($record['sch'][$catg]) $notes .= "-".$record['sch'][$catg]."\n";



					if(!empty($record['schnotes'][$catg])) 



						$notes .= "-".$record['schnotes'][$catg]."\n";



				}



			}



			//echo "</pre>";



			//echo " $notes ---- $points ----- $pursuit ";

			//exit;			



			if(empty($notes)) $er['notes']="Please check options";



			/*echo "<pre>";



			echo "record ";print_r($record);



			echo "objections ";print_r($objections);



			*/

			/*echo "objection ";print_r($objection);



			echo "interactions ";print_r($interactions);



			echo "</pre>";exit;*/



			//echo $notes;exit;



			if(!$er) {



				$tmpdate = explode("/",$record['idate']);//m/d/y-012



				$idate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				



				

				

				if(empty($record['contact']) && empty($record['account']) && empty($record['opportunity'])) $er['contact']="Atleast Contact/Account/Opportunity required";

				

				

				$record_id='';

				if(isset($record['contact']) && $record['contact']>0) $record_id = $record['contact'];

				else if(isset($record['contact']) && record['account']>0) $record_id = $record['account'];

				else if(isset($record['opportunity']) && $record['opportunity']>0) $record_id = $record['opportunity'];

				

				

				$cid1 = 0;



				$cid2 = 0;

				

				$cid3 = 0;

				

				$parent_id = $record['contact'];

				

				if($parent_id) {


						$contactList = $this->crm->get_contactinfo_id($parent_id);
						$phone = $contactList[0]->phone;
						$email = $contactList[0]->email;
					
					
						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',
						
						'task_phone' => $phone,
						
						'task_email' => $email,

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'C',

		

						'task_relatedto'=>$parent_id,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



				$cid1 = $this->crm->save_task($taskdata,0);



				}

				

				

				$parent_id2 = $record['account'];

				

				if($parent_id2) {


						$contactList = $this->crm->get_account_contacts($parent_id2);
						$phone = $contactList[0]->phone;
						$email = $contactList[0]->email;
					
					
						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',						
						
						'task_phone' => $phone,
						
						'task_email' => $email,		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'A',

		

						'task_relatedto'=>$parent_id2,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



					$cid2 = $this->crm->save_task($taskdata,0);



				}

				

				

				$parent_id3 = $record['opportunity'];

				

				if($parent_id3) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'O',

		

						'task_relatedto'=>$parent_id3,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		 

						);



					$cid3 = $this->crm->save_task($taskdata,0);



				}

				

				

				

				//Qaulity points				



				if($points<>0 || $pursuit<>0) {



					$idate = date("Y-m-d");



					//Contact points



					//check points and save



					if($record['contact']) {



						$where = array('contact'=>$record['contact'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'C');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['contact'],



									'pdate'=>$idate,



									'cat'=>$catg,



									'rctype'=>'C'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['contact']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['contact'],



									'cat'=>$catg,



									'rctype'=>'C',



									'pdate'=>$idate,



									'taskid'=>$cid1,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	



					}



					



					//Account points



					//check points and save



					if($record['account']) {

											



						$where = array('contact'=>$record['account'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'A');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['account'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'A'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['account']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['account'],



									'cat'=>$catg,



									'rctype'=>'A',



									'pdate'=>$idate,



									'taskid'=>$cid2,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	



					

					}

					

					

					

					

					//Opportunity points



					//check points and save



					if($record['opportunity']) {

						



						$where = array('contact'=>$record['opportunity'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'O');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['opportunity'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'O'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['opportunity']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['opportunity'],



									'cat'=>$catg,



									'rctype'=>'O',



									'pdate'=>$idate,



									'taskid'=>$cid3,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	

					

					}

				}

				



				//Objection


				$tid = "";
				
				if($cid1) $tid = $cid1;
				else if($cid2) $tid = $cid2;
				else if($cid3) $tid = $cid3;
				
				
				$cobjectIds = array();



				if($objections || $objection) {



					//$objdate = date("Y-m-d");



					$objdate = $idate;



					//Saving Objection usages



					foreach($objections as $obid=>$obval) {



						$objval = strtolower(str_replace(" ","",$obval[0]));



						$objid = $this->crm->check_objection($objval);



						if(!$objid) {



							$update = array('obj_val'=>$obval[0],'obj_custom'=>$obval[1],'obj_rctype'=>($pam3=='contact'?'C':'A'),'obj_recid'=>$record_id,'obj_task'=>$tid);



							$objid=$this->crm->save_objection($update);



						}



						if($objid && $obval[1]=="Y") $cobjectIds[$obid] = $objid;



						$objectn = $this->crm->check_objection_date($objid,$objdate);



						if($objectn) {



							$objtasks = $tid;



							if($objectn['objtask']) $objtasks = $objectn['objtask'].",".$objtasks;



							$update = array('objcount'=>$objectn['objcount']+1,'objtask'=>$objtasks);



							$this->crm->save_objection_date($update,$objectn);



						} else {



							$update = array('objid'=>$objid,'objdate'=>$objdate,'objtask'=>$tid);



							$this->crm->save_objection_date($update);



						}



					}



					



					//IGNORE THIS



					//default objections



					if($IGNORETHIS=='y') {



						foreach($objections as $obval) {



							$objval = strtolower(str_replace(" ","",$obval));



							/*$objectn = $this->crm->check_objection($objval);



							if($objectn) {



								$update = array('obj_count'=>$objectn['obj_count']+1);



								$this->crm->save_objection($update,$objectn['obj_id']);



							} else {



								$update = array('obj_val'=>$obval);



								$this->crm->save_objection($update);



							}*/



							$objid = $this->crm->check_objection($objval);//echo "1. $objid";



							if(!$objid) {



								$update = array('obj_val'=>$obval);//echo "2. ";print_r($update);



								$objid=$this->crm->save_objection($update);



							}



							$objectn = $this->crm->check_objection_date($objid,$objdate);//echo "3. ";print_r($update);



							if($objectn) {



								$update = array('objcount'=>$objectn['objcount']+1);//echo "5. ";print_r($update);



								$this->crm->save_objection_date($update,$objectn);



							} else {



								$update = array('objid'=>$objid,'objdate'=>$objdate);//echo "6. ";print_r($update);



								$this->crm->save_objection_date($update);



							}



						}



						//custom objection



						if($objection) {



							$objval = strtolower(str_replace(" ","",$objection));



							



							/*$objectn = $this->crm->check_objection($objval);



							if($objectn) {



								$update = array('obj_count'=>$objectn['obj_count']+1);



								$this->crm->save_objection($update,$objectn['obj_id']);



							} else {



								$update = array('obj_val'=>$objection,'obj_custom'=>'Y');



								$this->crm->save_objection($update);



							}*/



							



							$objid = $this->crm->check_objection($objval);//echo "11. $objid";



							if(!$objid) {



								$update = array('obj_val'=>$objection,'obj_custom'=>'Y');//echo "12. ";print_r($update);



								$objid=$this->crm->save_objection($update);



							}



							$objectn = $this->crm->check_objection_date($objid,$objdate);//echo "13. ";print_r($objectn);



							if($objectn) {



								$update = array('objcount'=>$objectn['objcount']+1);//echo "14. ";print_r($update);



								$this->crm->save_objection_date($update,$objectn);



							} else {



								$update = array('objid'=>$objid,'objdate'=>$objdate);//echo "15. ";print_r($update);



								$this->crm->save_objection_date($update);



							}



						}



					}//End of IGNORE THIS	



				}//exit;



				/*echo "<pre>";



				echo "record ";print_r($record);



				echo "objections ";print_r($objections);



				echo "cobjectIds ";print_r($cobjectIds);



				echo "interactions ";print_r($interactions);



				echo "</pre>";exit;*/



				//error_reporting(E_ALL);



				//Track Interactions Saving



				if($interactions) {



					//$intr_date = date("Y-m-d");



					$intr_date = $idate;



					foreach($interactions as $ival) {



						$intr_sno=$ival['c']."-".$ival['s']."-".$ival['o'];



						if($ival['i']=="CO") {



							$ival['o']=$cobjectIds[$ival['o']];



							if(!$ival['o']) continue;



							$ival['i']="O";



						}



						if($ival['i']=="O") $intr_sno=$ival['c']."-".$ival['s']."-O".$ival['o'];

						

						

						if($record['contact']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'C','intr_recid'=>$record['contact']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'C',

		

										'intr_recid'=>$record['contact'],

		

										'intr_task'=>$cid1,

		

										'intr_date'=>$intr_date);

		

										$this->crm->save_interaction_date($update);		

								}

						}

						

						

						if($record['account']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'A','intr_recid'=>$record['account']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'A',

		

										'intr_recid'=>$record['account'],

		

										'intr_task'=>$cid1,

		

										'intr_date'=>$intr_date);										

		

										$this->crm->save_interaction_date($update);	

								}

						}

						

						

						if($record['opportunity']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'O','intr_recid'=>$record['opportunity']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'O',

		

										'intr_recid'=>$record['opportunity'],

		

										'intr_task'=>$cid3,

		

										'intr_date'=>$intr_date);

		

										$this->crm->save_interaction_date($update);		

								}

						}



					}



				}



				//Schedule Follow up Task



				if($record['sch'][$catg]) {



					if(!empty($record['sdate'][$catg])) {



						$tmpdate = explode("/",$record['sdate'][$catg]);//m/d/y-012



						$schdate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					} else $schdate=date("Y-m-d");



					



					$task_related = '';

					if($pam3=='contact') $task_related='C';

					else if($pam3=='account') $task_related='A';

					else if($pam3=='opportunity') $task_related='O';



					$taskdata = array(



								'task_subject'=>$record['sch'][$catg],



								'task_priority'=>'Normal',



								'task_status'=>'In Progress',



								'task_related'=>$task_related,



								'task_relatedto'=>$record_id,



								'share_user_id'=>$this->_user_id,



								'task_duedate'=>$schdate,



								'task_info'=>$notes



								);



					$tid = $this->crm->save_task($taskdata,0);



				}



				//redirect(base_url() . 'crm/notes/view/'.$cid);

				

				/*$y='';

				if($record['contact']) $y=$record['contact'];

				else if($record['account']) $y=$record['account'];

				else if($record['opportunity']) $y=$record['opportunity'];

				

				echo "YES-".$record_id."-".$record_title;*/

				

				$x='';

				if($cid1) $x=$cid1;

				else if($cid2) $x=$cid2;

				else if($cid2) $x=$cid32;

				

				$y='';

				if($record['contact']) $y=$record['contact'];

				else if($record['account']) $y=$record['account'];

				else if($record['opportunity']) $y=$record['opportunity'];

				

				echo "YES-".$x."-".$y;



				exit;



			}



			echo implode("\n",$er);



			exit;



			$this->_data['er']=$er;



			$this->_data['record']=$record;



		}



		$this->_data['parent_section'] = $parent_section;



		$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['crmlite'] = $crmlite;



		$this->_data['CustObjections'] = $this->crm->get_objections('Y');



		//Objections from Objection Map which are newly entered by user



		$this->_data['ObjectionsCampaign'] = $this->crm->get_objection_Campaign();



		$this->load->view('crm/interaction-new', $this->_data);

	

	}



	//Interaction

	function interaction_0710208($action = NULL)

	{

		$pam3 = $action;



		$pam4 = $this->uri->segment(4);



		if(!(int)$pam4 || !($pam3=="contact" || $pam3=="account" || $pam3=="opportunities")) redirect(base_url() . 'crm/contacts');



		



		$contact = (int)$pam4;



		$parent_id = (int)$pam4;



		if($pam3=='contact' && $parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/contacts');



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/contact/'.$parent_id));



			$this->_data['crecord_id'] = $parent_id;

			

			$record['contact']=$parent_id;

			

			$this->_data['crecord_id_title'] = ucfirst($parent_record[user_first].' '.$parent_record[user_last]);



			$this->_data['parent_name'] = "Contact";



			$this->_data['parent_record'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);



		} else if($pam3=='account' && $parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'A');



			if(!$parent_record) redirect(base_url() . 'crm/accounts');



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[account_name]),'url'=>base_url('crm/accounts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/account/'.$parent_id));



			$this->_data['arecord_id'] = $parent_id;

			

			$record['account']=$parent_id;

			

			$this->_data['arecord_id_title'] = ucfirst($parent_record[account_name]);



			$this->_data['parent_name'] = "Account";



			$this->_data['parent_record'] = $this->crm->get_all_accounts(0,0,$this->_parent_users);



		} 

		

		else if($pam3=='opportunities' && $parent_id) {



			

		

			$parent_record =$this->crm->get_notes_parent($parent_id,'O');

			

			//echo '<pre>'; print_r($parent_record); echo '</pre>';

			//exit;



			if(!$parent_record) redirect(base_url() . 'crm/opportunities');



			$breadcrumbs[] = array('label'=>'Opportunities','url'=>base_url('crm/opportunities'));

			

			



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[oppt_name]),'url'=>base_url('crm/opportunities/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/opportunities/'.$parent_id));



			$this->_data['orecord_id'] = $parent_id;

			

			$this->_data['orecord_id_title'] = ucfirst($parent_record[oppt_name]);



			$this->_data['parent_name'] = "Oportunities";



			$this->_data['parent_record'] = $this->crm->get_all_opportunitys(0,0,$this->_parent_users);



		}

		

		else redirect(base_url() . 'crm/contacts');



		$parent_section=$pam3;



		$crmlite=$pam3;



		$this->load->helper('scripts');



		$categories = crm_introptions();



		$record=array();



		$this->_data['categories'] = $categories;



		if($this->input->post('action')=="save") {



			$record=$this->input->post('record');



			//echo "<pre>";print_r($record);echo "</pre>";exit;

			

			

			if($pam3=='contact') $ky = 'C';

			else if($pam3=='account') $ky = 'A';

			else if($pam3=='opportunities') $ky = 'O';

			

			$record_id='';

			if(isset($record['contact']) && $record['contact']>0) $record_id = $record['contact'];

			else if(isset($record['contact']) && record['account']>0) $record_id = $record['account'];

			else if(isset($record['opportunity']) && $record['opportunity']>0) $record_id = $record['opportunity'];



			$catg = 0;



			$er = array();



			//if(empty($record['record_id'])) $er['record_id']=$this->_data['parent_name']." required";

			

			if(empty($record['contact']) && empty($record['account']) && empty($record['opportunity'])) $er['contact']="Atleast Contact/Account/Opportunity required";





			/*if(empty($record['cat'])) $er['cat']="Category required";



			else $catg=(int)$record['cat'];*/

			$catg = 1;



			if(empty($record['idate'])) $er['idate']="Date required";



			//validate by section notes



			$notes = '';



			$points = 0;



			$pursuit = 0;



			$objection = "";



			$objections = array();



			//Track Interactions



			$interactions = array();



			//echo "<pre>";print_r($record);echo "</pre>";exit;



			//echo "<pre>";						



			if($catg) {				



				//Cheched Options

				$CatgintOptions = $categories['category'];



				foreach($record['secnotes'] as $si=>$snval) {



					if(count($record['opt'][$si])>0 || !empty($snval)) {



						$chkval = $si;//1n1 <cat>n<sect>



						$chkval = explode("n",$chkval);//cat-sect



						//$sec_val = $categories[$chkval[0]]['sections'][$chkval[1]];

						$sect = $chkval[1];

						if($sect==1) $sec_val = $categories['category'][$chkval[0]][1];

						else $sec_val = $categories['sections'][$chkval[1]];



						//print_r($sec_val);



						$sec_opt = $sec_val['options'];



						//print_r($sec_opt);



						//$notes = $sec_val[''];



						$notes .= $sec_val['name'].":\n";



						if(count($record['opt'][$si])>0) {	



							//Editable points for Scripter User



							$epoints = 1;



							if($this->_data['is_prolite']) $epoints = 0;



							$points_qp = $record['qp'][$si];



							$points_pp = $record['pp'][$si];



							foreach($record['opt'][$si] as $oi=>$oval) {



								//objections



								$objId = 0;



								if($si==$catg."n4") {



									if($oval=="O") {//other objection



										$objection = $record['opto_txt'.$catg][$oi];



										$objId = $record['opto_id'.$catg][$oi];



										//if(empty($record['opto_select'.$catg]) && empty($record['opto_txt'.$catg])) $er['objection']="Objection other value required";



										if(empty($objection)) $er['objection']="Objection other value required";



										if($objection) {



											$notes .= "-".$objection."\n";



											$objOther = end($sec_opt);



											//Editable points for Scripter User



											if($epoints) {



												//$notes .= "Quality Points: ".$points_qp[$oval]."\n";



												$points += $points_qp[$oi];



												$pursuit += $points_pp[$oi];



											} else {



												//$notes .= "Quality Points: ".$objOther['points']."\n";



												$points += $objOther['points'];



												$pursuit += $objOther['pursuit'];	



											}



											$objections[] = array($objection,'Y');



											//Track Interactions



											if($objId) $interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$objId,'i'=>'O');



											else 



												$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>count($objections)-1,'i'=>'CO');



										}



										continue;



									} else $objections[] = array($sec_opt[$oval]['name'],'');



								}



								//Track Interactions								



								$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$oval,'i'=>'I');



								



								$notes .= "-".$sec_opt[$oval]['name']."\n";



								//Quality Points



								//Editable points for Scripter User



								if($epoints) {



									//$notes .= "Quality Points: ".$points_qp[$oval]."\n";



									$points += $points_qp[$oval];



									$pursuit += $points_pp[$oval];



								} else {



									//$notes .= "Quality Points: ".$sec_opt[$oval]['points']."\n";



									$points += $sec_opt[$oval]['points'];



									$pursuit += $sec_opt[$oval]['pursuit'];



								}



							}



						} 



						if($snval) {



							$notes .= "-".trim($snval)."\n";



						}



						$notes .= "\n";



					}



				}	



				//Schedule Follow-Up Task



				if(!empty($record['sch'][$catg]) || !empty($record['schnotes'][$catg])) {



					$notes .= "Schedule Follow-Up Task:\n";



					if($record['sch'][$catg]) {



						if($record['sch'][$catg]=="O") {



							if(empty($record['sch_txt'.$catg])) $er['sch']="Schedule Follow-Up Task other value required";



							else $record['sch'][$catg]=$record['sch_txt'.$catg];



						}



					}



					if($record['sch'][$catg]) $notes .= "-".$record['sch'][$catg]."\n";



					if(!empty($record['schnotes'][$catg])) 



						$notes .= "-".$record['schnotes'][$catg]."\n";



				}



			}



			//echo "</pre>";



			//echo " $notes ---- $points ----- $pursuit ";

			//exit;			



			if(empty($notes)) $er['notes']="Please check options";



			/*echo "<pre>";



			echo "record ";print_r($record);



			echo "objections ";print_r($objections);



			*/

			/*echo "objection ";print_r($objection);



			echo "interactions ";print_r($interactions);



			echo "</pre>";exit;*/



			//echo $notes;exit;



			if(!$er) {



				$tmpdate = explode("/",$record['idate']);//m/d/y-012



				$idate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201





				

				if(empty($record['contact']) && empty($record['account']) && empty($record['opportunity'])) $er['contact']="Atleast Contact/Account/Opportunity required";

				

				

				$record_id='';

				if(isset($record['contact']) && $record['contact']>0) $record_id = $record['contact'];

				else if(isset($record['contact']) && record['account']>0) $record_id = $record['account'];

				else if(isset($record['opportunity']) && $record['opportunity']>0) $record_id = $record['opportunity'];

				

				

				$cid1 = 0;



				$cid2 = 0;

				

				$cid3 = 0;

				

				$parent_id = $record['contact'];

				



				//Create completed task : Log a Call



				if($parent_id) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'C',

		

						'task_relatedto'=>$parent_id,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



				$cid1 = $this->crm->save_task($taskdata,0);



				}

				

				

				$parent_id2 = $record['account'];

				

				if($parent_id2) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'A',

		

						'task_relatedto'=>$parent_id2,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



					$cid2 = $this->crm->save_task($taskdata,0);



				}

				

				$parent_id3 = $record['opportunity'];

				

				if($parent_id3) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'O',

		

						'task_relatedto'=>$parent_id3,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



					$cid3 = $this->crm->save_task($taskdata,0);



				}



				



				//Qaulity points				



				if($points<>0) {



					$idate = date("Y-m-d");



					//Contact points



					//check points and save



					if($record['contact']) {



						$where = array('contact'=>$record['contact'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'C');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['contact'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'C'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['contact']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['contact'],



									'cat'=>$catg,



									'rctype'=>'C',



									'pdate'=>$idate,



									'taskid'=>$cid1,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	



					}



					



					//Account points



					//check points and save



					if($record['account']) {

					

						



						$where = array('contact'=>$record['account'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'A');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['account'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'A'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['account']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['account'],



									'cat'=>$catg,



									'rctype'=>'A',



									'pdate'=>$idate,



									'taskid'=>$cid2,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	



					

					}

					

					

					

					

					//Opportunity points



					//check points and save



					if($record['opportunity']) {

						



						$where = array('contact'=>$record['opportunity'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'O');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['opportunity'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'O'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['opportunity']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['opportunity'],



									'cat'=>$catg,



									'rctype'=>'O',



									'pdate'=>$idate,



									'taskid'=>$cid3,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	

					

					}

				}

				



				//Objection



				$cobjectIds = array();



				if($objections || $objection) {



					//$objdate = date("Y-m-d");



					$objdate = $idate;



					//Saving Objection usages



					foreach($objections as $obid=>$obval) {



						$objval = strtolower(str_replace(" ","",$obval[0]));



						$objid = $this->crm->check_objection($objval);



						if(!$objid) {



							$update = array('obj_val'=>$obval[0],'obj_custom'=>$obval[1],'obj_rctype'=>($pam3=='contact'?'C':'A'),'obj_recid'=>$record['record_id'],'obj_task'=>$tid);



							$objid=$this->crm->save_objection($update);



						}



						if($objid && $obval[1]=="Y") $cobjectIds[$obid] = $objid;



						$objectn = $this->crm->check_objection_date($objid,$objdate);



						if($objectn) {



							$objtasks = $tid;



							if($objectn['objtask']) $objtasks = $objectn['objtask'].",".$objtasks;



							$update = array('objcount'=>$objectn['objcount']+1,'objtask'=>$objtasks);



							$this->crm->save_objection_date($update,$objectn);



						} else {



							$update = array('objid'=>$objid,'objdate'=>$objdate,'objtask'=>$tid);



							$this->crm->save_objection_date($update);



						}



					}



					



					//IGNORE THIS



					//default objections



					if($IGNORETHIS=='y') {



						foreach($objections as $obval) {



							$objval = strtolower(str_replace(" ","",$obval));



							/*$objectn = $this->crm->check_objection($objval);



							if($objectn) {



								$update = array('obj_count'=>$objectn['obj_count']+1);



								$this->crm->save_objection($update,$objectn['obj_id']);



							} else {



								$update = array('obj_val'=>$obval);



								$this->crm->save_objection($update);



							}*/



							$objid = $this->crm->check_objection($objval);//echo "1. $objid";



							if(!$objid) {



								$update = array('obj_val'=>$obval);//echo "2. ";print_r($update);



								$objid=$this->crm->save_objection($update);



							}



							$objectn = $this->crm->check_objection_date($objid,$objdate);//echo "3. ";print_r($update);



							if($objectn) {



								$update = array('objcount'=>$objectn['objcount']+1);//echo "5. ";print_r($update);



								$this->crm->save_objection_date($update,$objectn);



							} else {



								$update = array('objid'=>$objid,'objdate'=>$objdate);//echo "6. ";print_r($update);



								$this->crm->save_objection_date($update);



							}



						}



						//custom objection



						if($objection) {



							$objval = strtolower(str_replace(" ","",$objection));



							



							/*$objectn = $this->crm->check_objection($objval);



							if($objectn) {



								$update = array('obj_count'=>$objectn['obj_count']+1);



								$this->crm->save_objection($update,$objectn['obj_id']);



							} else {



								$update = array('obj_val'=>$objection,'obj_custom'=>'Y');



								$this->crm->save_objection($update);



							}*/



							



							$objid = $this->crm->check_objection($objval);//echo "11. $objid";



							if(!$objid) {



								$update = array('obj_val'=>$objection,'obj_custom'=>'Y');//echo "12. ";print_r($update);



								$objid=$this->crm->save_objection($update);



							}



							$objectn = $this->crm->check_objection_date($objid,$objdate);//echo "13. ";print_r($objectn);



							if($objectn) {



								$update = array('objcount'=>$objectn['objcount']+1);//echo "14. ";print_r($update);



								$this->crm->save_objection_date($update,$objectn);



							} else {



								$update = array('objid'=>$objid,'objdate'=>$objdate);//echo "15. ";print_r($update);



								$this->crm->save_objection_date($update);



							}



						}



					}//End of IGNORE THIS	



				}//exit;



				/*echo "<pre>";



				echo "record ";print_r($record);



				echo "objections ";print_r($objections);



				echo "cobjectIds ";print_r($cobjectIds);



				echo "interactions ";print_r($interactions);



				echo "</pre>";exit;*/



				//error_reporting(E_ALL);



				//Track Interactions Saving



				if($interactions) {



					//$intr_date = date("Y-m-d");



					$intr_date = $idate;



					foreach($interactions as $ival) {

						



						$intr_sno=$ival['c']."-".$ival['s']."-".$ival['o'];



						if($ival['i']=="CO") {



							$ival['o']=$cobjectIds[$ival['o']];



							if(!$ival['o']) continue;



							$ival['i']="O";



						}



						if($ival['i']=="O") $intr_sno=$ival['c']."-".$ival['s']."-O".$ival['o'];

						

						

						if($record['contact']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'C','intr_recid'=>$record['contact']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'C',

		

										'intr_recid'=>$record['contact'],

		

										'intr_task'=>$cid1,

		

										'intr_date'=>$intr_date);

		

										$this->crm->save_interaction_date($update);		

								}

						}

						

						

						if($record['account']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'A','intr_recid'=>$record['account']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'A',

		

										'intr_recid'=>$record['account'],

		

										'intr_task'=>$cid1,

		

										'intr_date'=>$intr_date);										

		

										$this->crm->save_interaction_date($update);		

								}

						}

						

						

						if($record['opportunity']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'O','intr_recid'=>$record['opportunity']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'O',

		

										'intr_recid'=>$record['opportunity'],

		

										'intr_task'=>$cid3,

		

										'intr_date'=>$intr_date);

		

										$this->crm->save_interaction_date($update);		

								}

						}

					}



				}



				//Schedule Follow up Task



				if($record['sch'][$catg]) {



					if(!empty($record['sdate'][$catg])) {



						$tmpdate = explode("/",$record['sdate'][$catg]);//m/d/y-012



						$schdate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					} else $schdate=date("Y-m-d");



					$task_related = '';

					if($pam3=='contact') $task_related='C';

					else if($pam3=='account') $task_related='A';

					else if($pam3=='opportunity') $task_related='O';





					$taskdata = array(



								'task_subject'=>$record['sch'][$catg],



								'task_priority'=>'Normal',



								'task_status'=>'In Progress',



								'task_related'=>$task_related,



								'task_relatedto'=>$record['record_id'],



								'share_user_id'=>$this->_user_id,



								'task_duedate'=>$schdate,



								'task_info'=>$notes



								);



					$tid = $this->crm->save_task($taskdata,0);



				}



				//redirect(base_url() . 'crm/notes/view/'.$cid);



				//echo "YES-".$record['record_id'];



				$x='';

				if($cid1) $x=$cid1;

				else if($cid2) $x=$cid2;

				else if($cid2) $x=$cid32;

				

				$y='';

				if($record['contact']) $y=$record['contact'];

				else if($record['account']) $y=$record['account'];

				else if($record['opportunity']) $y=$record['opportunity'];

				

				echo "YES-".$x."-".$y;



				exit;



			}



			echo implode("\n",$er);



			exit;



			$this->_data['er']=$er;



			$this->_data['record']=$record;



		}



		$this->_data['parent_section'] = $parent_section;



		$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['crmlite'] = $crmlite;



		$this->_data['CustObjections'] = $this->crm->get_objections('Y');



		//Objections from Objection Map which are newly entered by user



		$this->_data['ObjectionsCampaign'] = $this->crm->get_objection_Campaign();



		$this->load->view('crm/interaction-new', $this->_data);

	}



	//Old

	function interaction_backup12052017($action = NULL)



	{



		$pam3 = $action;



		$pam4 = $this->uri->segment(4);



		if(!(int)$pam4 || !($pam3=="contact" || $pam3=="account")) redirect(base_url() . 'crm/contacts');



		



		$contact = (int)$pam4;



		$parent_id = (int)$pam4;



		if($pam3=='contact' && $parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/contacts');



			$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/contact/'.$parent_id));



			$this->_data['record_id'] = $parent_id;



			$this->_data['parent_name'] = "Contact";



			$this->_data['parent_record'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);



		} else if($pam3=='account' && $parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'A');



			if(!$parent_record) redirect(base_url() . 'crm/accounts');



			$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



			$breadcrumbs[] = array('label'=>ucfirst($parent_record[account_name]),'url'=>base_url('crm/accounts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'interaction','url'=>base_url('crm/interaction/account/'.$parent_id));



			$this->_data['record_id'] = $parent_id;



			$this->_data['parent_name'] = "Account";



			$this->_data['parent_record'] = $this->crm->get_all_accounts(0,0,$this->_parent_users);



		} else redirect(base_url() . 'crm/contacts');



		$parent_section=$pam3;



		$crmlite=$pam3;



		$this->load->helper('scripts');



		$categories = crm_options();



		$record=array();



		$this->_data['categories'] = $categories;



		if($this->input->post('action')=="save") {



			$record=$this->input->post('record');



			//echo "<pre>";print_r($record);echo "</pre>";exit;



			$catg = 0;



			$er = array();



			if(empty($record['record_id'])) $er['record_id']=$this->_data['parent_name']." required";



			if(empty($record['cat'])) $er['cat']="Category required";



			else $catg=(int)$record['cat'];



			if(empty($record['idate'])) $er['idate']="Date required";



			//validate by section notes



			$notes = '';



			$points = 0;



			$pursuit = 0;



			$objection = "";



			$objections = array();



			//Track Interactions



			$interactions = array();



			//echo "<pre>";print_r($record);echo "</pre>";exit;



			//echo "<pre>";						



			if($catg) {				



				//Cheched Options



				foreach($record['secnotes'] as $si=>$snval) {



					if(count($record['opt'][$si])>0 || !empty($snval)) {



						$chkval = $si;//1n1 <cat>n<sect>



						$chkval = explode("n",$chkval);//cat-sect



						$sec_val = $categories[$chkval[0]]['sections'][$chkval[1]];



						//print_r($sec_val);



						$sec_opt = $sec_val['options'];



						//print_r($sec_opt);



						//$notes = $sec_val[''];



						$notes .= $sec_val['name'].":\n";



						if(count($record['opt'][$si])>0) {	



							//Editable points for Scripter User



							$epoints = 1;



							if($this->_data['is_prolite']) $epoints = 0;



							$points_qp = $record['qp'][$si];



							$points_pp = $record['pp'][$si];



							foreach($record['opt'][$si] as $oi=>$oval) {



								//objections



								$objId = 0;



								if($si==$catg."n4") {



									if($oval=="O") {//other objection



										$objection = $record['opto_txt'.$catg][$oi];



										$objId = $record['opto_id'.$catg][$oi];



										//if(empty($record['opto_select'.$catg]) && empty($record['opto_txt'.$catg])) $er['objection']="Objection other value required";



										if(empty($objection)) $er['objection']="Objection other value required";



										if($objection) {



											$notes .= "-".$objection."\n";



											$objOther = end($sec_opt);



											//Editable points for Scripter User



											if($epoints) {



												//$notes .= "Quality Points: ".$points_qp[$oval]."\n";



												$points += $points_qp[$oi];



												$pursuit += $points_pp[$oi];



											} else {



												//$notes .= "Quality Points: ".$objOther['points']."\n";



												$points += $objOther['points'];



												$pursuit += $objOther['pursuit'];	



											}



											$objections[] = array($objection,'Y');



											//Track Interactions



											if($objId) $interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$objId,'i'=>'O');



											else 



												$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>count($objections)-1,'i'=>'CO');



										}



										continue;



									} else $objections[] = array($sec_opt[$oval]['name'],'');



								}



								//Track Interactions								



								$interactions[] = array('c'=>$chkval[0],'s'=>$chkval[1],'o'=>$oval,'i'=>'I');



								



								$notes .= "-".$sec_opt[$oval]['name']."\n";



								//Quality Points



								//Editable points for Scripter User



								if($epoints) {



									//$notes .= "Quality Points: ".$points_qp[$oval]."\n";



									$points += $points_qp[$oval];



									$pursuit += $points_pp[$oval];



								} else {



									//$notes .= "Quality Points: ".$sec_opt[$oval]['points']."\n";



									$points += $sec_opt[$oval]['points'];



									$pursuit += $sec_opt[$oval]['pursuit'];



								}



							}



						} 



						if($snval) {



							$notes .= "-".trim($snval)."\n";



						}



						$notes .= "\n";



					}



				}	



				//Schedule Follow-Up Task



				if(!empty($record['sch'][$catg]) || !empty($record['schnotes'][$catg])) {



					$notes .= "Schedule Follow-Up Task:\n";



					if($record['sch'][$catg]) {



						if($record['sch'][$catg]=="O") {



							if(empty($record['sch_txt'.$catg])) $er['sch']="Schedule Follow-Up Task other value required";



							else $record['sch'][$catg]=$record['sch_txt'.$catg];



						}



					}



					if($record['sch'][$catg]) $notes .= "-".$record['sch'][$catg]."\n";



					if(!empty($record['schnotes'][$catg])) 



						$notes .= "-".$record['schnotes'][$catg]."\n";



				}



			}



			//echo "</pre>";



			//echo " $notes ---- $points ----- $pursuit";exit;			



			if(empty($notes)) $er['notes']="Please check options";



			/*echo "<pre>";



			echo "record ";print_r($record);



			echo "objections ";print_r($objections);



			echo "objection ";print_r($objection);



			echo "interactions ";print_r($interactions);



			echo "</pre>";exit;*/



			//echo $notes;exit;



			if(!$er) {



				$tmpdate = explode("/",$record['idate']);//m/d/y-012



				$idate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				



				

				

				if(empty($record['contact']) && empty($record['account']) && empty($record['opportunity'])) $er['contact']="Atleast Contact/Account/Opportunity required";

				

				

				$record_id='';

				if(isset($record['contact']) && $record['contact']>0) $record_id = $record['contact'];

				else if(isset($record['contact']) && record['account']>0) $record_id = $record['account'];

				else if(isset($record['opportunity']) && $record['opportunity']>0) $record_id = $record['opportunity'];

				

				

				$cid1 = 0;



				$cid2 = 0;

				

				$cid3 = 0;

				

				$parent_id = $record['contact'];



				//Create completed task : Log a Call



				if($parent_id) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'C',

		

						'task_relatedto'=>$parent_id,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



				$cid1 = $this->crm->save_task($taskdata,0);



				}

				

				$parent_id2 = $record['account'];

				

				if($parent_id2) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'A',

		

						'task_relatedto'=>$parent_id2,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



					$cid2 = $this->crm->save_task($taskdata,0);



				}

				

				

				$parent_id3 = $record['opportunity'];

				

				if($parent_id3) {



						$taskdata = array(



						//'task_subject'=>$categories[$catg]['name'],

						'task_subject'=>'Interaction',

		

						'task_priority'=>'Normal',

		

						'task_status'=>strtotime($idate)>time()?'In Progress':'Completed',

		

						'task_duedate'=>$idate,

		

						'task_related'=>'O',

		

						'task_relatedto'=>$parent_id3,

		

						'share_user_id'=>$this->_user_id,

		

						'task_created'=>$idate." 00:00:00",

		

						'task_modified'=>$idate." 00:00:00",

		

						'task_info'=>$notes

		

						);



					$cid3 = $this->crm->save_task($taskdata,0);



				}

				

				

				

				//Qaulity points				



				if($points<>0) {



					$idate = date("Y-m-d");



					//Contact points



					//check points and save



					if($record['contact']) {



						$where = array('contact'=>$record['contact'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'C');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['contact'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'C'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['contact']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['contact'],



									'cat'=>$catg,



									'rctype'=>'C',



									'pdate'=>$idate,



									'taskid'=>$cid1,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	



					}



					



					//Account points



					//check points and save



					if($record['account']) {

					

						



						$where = array('contact'=>$record['account'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'A');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['account'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'A'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['account']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['account'],



									'cat'=>$catg,



									'rctype'=>'A',



									'pdate'=>$idate,



									'taskid'=>$cid2,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	



					

					}

					

					

					

					

					//Opportunity points



					//check points and save



					if($record['opportunity']) {

						



						$where = array('contact'=>$record['opportunity'],'cat'=>$catg,'pdate'=>$idate,'rctype'=>'O');



						$cont_points = $this->crm->get_points($where);



						if($cont_points) {



							$update_data = array(



									'contact'=>$record['opportunity'],



									'pdate'=>$idate,



									'cat'=>0,



									'rctype'=>'O'



									);



							$points_data = array(



									'intpoints'=>$cont_points['intpoints']+$points,



									'purpoints'=>$cont_points['purpoints']+$pursuit,

		

									'taskid'=>$record['opportunity']

									);		



							$this->crm->save_points($points_data,$update_data);



						} else {



							$points_data = array(



									'contact'=>$record['opportunity'],



									'cat'=>$catg,



									'rctype'=>'O',



									'pdate'=>$idate,



									'taskid'=>$cid3,



									'intpoints'=>$points,



									'purpoints'=>$pursuit

									);						



							$this->crm->save_points($points_data);



						}	

					

					}

				}





				//Objection



				$cobjectIds = array();



				if($objections || $objection) {



					//$objdate = date("Y-m-d");



					$objdate = $idate;



					//Saving Objection usages



					foreach($objections as $obid=>$obval) {



						$objval = strtolower(str_replace(" ","",$obval[0]));



						$objid = $this->crm->check_objection($objval);



						if(!$objid) {



							$update = array('obj_val'=>$obval[0],'obj_custom'=>$obval[1],'obj_rctype'=>($pam3=='contact'?'C':'A'),'obj_recid'=>$record['record_id'],'obj_task'=>$tid);



							$objid=$this->crm->save_objection($update);



						}



						if($objid && $obval[1]=="Y") $cobjectIds[$obid] = $objid;



						$objectn = $this->crm->check_objection_date($objid,$objdate);



						if($objectn) {



							$objtasks = $tid;



							if($objectn['objtask']) $objtasks = $objectn['objtask'].",".$objtasks;



							$update = array('objcount'=>$objectn['objcount']+1,'objtask'=>$objtasks);



							$this->crm->save_objection_date($update,$objectn);



						} else {



							$update = array('objid'=>$objid,'objdate'=>$objdate,'objtask'=>$tid);



							$this->crm->save_objection_date($update);



						}



					}



					



					//IGNORE THIS



					//default objections



					if($IGNORETHIS=='y') {



						foreach($objections as $obval) {



							$objval = strtolower(str_replace(" ","",$obval));



							/*$objectn = $this->crm->check_objection($objval);



							if($objectn) {



								$update = array('obj_count'=>$objectn['obj_count']+1);



								$this->crm->save_objection($update,$objectn['obj_id']);



							} else {



								$update = array('obj_val'=>$obval);



								$this->crm->save_objection($update);



							}*/



							$objid = $this->crm->check_objection($objval);//echo "1. $objid";



							if(!$objid) {



								$update = array('obj_val'=>$obval);//echo "2. ";print_r($update);



								$objid=$this->crm->save_objection($update);



							}



							$objectn = $this->crm->check_objection_date($objid,$objdate);//echo "3. ";print_r($update);



							if($objectn) {



								$update = array('objcount'=>$objectn['objcount']+1);//echo "5. ";print_r($update);



								$this->crm->save_objection_date($update,$objectn);



							} else {



								$update = array('objid'=>$objid,'objdate'=>$objdate);//echo "6. ";print_r($update);



								$this->crm->save_objection_date($update);



							}



						}



						//custom objection



						if($objection) {



							$objval = strtolower(str_replace(" ","",$objection));



							



							/*$objectn = $this->crm->check_objection($objval);



							if($objectn) {



								$update = array('obj_count'=>$objectn['obj_count']+1);



								$this->crm->save_objection($update,$objectn['obj_id']);



							} else {



								$update = array('obj_val'=>$objection,'obj_custom'=>'Y');



								$this->crm->save_objection($update);



							}*/



							



							$objid = $this->crm->check_objection($objval);//echo "11. $objid";



							if(!$objid) {



								$update = array('obj_val'=>$objection,'obj_custom'=>'Y');//echo "12. ";print_r($update);



								$objid=$this->crm->save_objection($update);



							}



							$objectn = $this->crm->check_objection_date($objid,$objdate);//echo "13. ";print_r($objectn);



							if($objectn) {



								$update = array('objcount'=>$objectn['objcount']+1);//echo "14. ";print_r($update);



								$this->crm->save_objection_date($update,$objectn);



							} else {



								$update = array('objid'=>$objid,'objdate'=>$objdate);//echo "15. ";print_r($update);



								$this->crm->save_objection_date($update);



							}



						}



					}//End of IGNORE THIS	



				}//exit;



				/*echo "<pre>";



				echo "record ";print_r($record);



				echo "objections ";print_r($objections);



				echo "cobjectIds ";print_r($cobjectIds);



				echo "interactions ";print_r($interactions);



				echo "</pre>";exit;*/



				//error_reporting(E_ALL);



				//Track Interactions Saving



				if($interactions) {

					



					//$intr_date = date("Y-m-d");



					$intr_date = $idate;



					foreach($interactions as $ival) {



						$intr_sno=$ival['c']."-".$ival['s']."-".$ival['o'];



						if($ival['i']=="CO") {



							$ival['o']=$cobjectIds[$ival['o']];



							if(!$ival['o']) continue;



							$ival['i']="O";



						}



						if($ival['i']=="O") $intr_sno=$ival['c']."-".$ival['s']."-O".$ival['o'];

						

						

						if($record['contact']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'C','intr_recid'=>$record['contact']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'C',

		

										'intr_recid'=>$record['contact'],

		

										'intr_task'=>$cid1,

		

										'intr_date'=>$intr_date);

		

										$this->crm->save_interaction_date($update);		

								}

						}

						

						

						if($record['account']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'A','intr_recid'=>$record['account']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'A',

		

										'intr_recid'=>$record['account'],

		

										'intr_task'=>$cid1,

		

										'intr_date'=>$intr_date);										

		

										$this->crm->save_interaction_date($update);		

								}

						}

						

						

						if($record['opportunity']) {

								$where = array('intr_sno'=>$intr_sno,'intr_date'=>$intr_date,'intr_rctype'=>'O','intr_recid'=>$record['opportunity']);

								$intrdata = $this->crm->check_interaction_date($where);

								if($intrdata) {	

									$update = array('intr_count'=>$intrdata['intr_count']+1);	

									$this->crm->save_interaction_date($update,$intrdata);	

								} 

								else 

								{	

									$update = array(

		

										'intr_cat'=>$ival['c'],

		

										'intr_sect'=>$ival['s'],

		

										'intr_opt'=>$ival['o'],

		

										'intr_otype'=>$ival['i'],

		

										'intr_sno'=>$intr_sno,

		

										'intr_rctype'=>'O',

		

										'intr_recid'=>$record['opportunity'],

		

										'intr_task'=>$cid3,

		

										'intr_date'=>$intr_date);

		

										$this->crm->save_interaction_date($update);		

								}

						}



					}



				

				}



				//Schedule Follow up Task



				if($record['sch'][$catg]) {



					if(!empty($record['sdate'][$catg])) {



						$tmpdate = explode("/",$record['sdate'][$catg]);//m/d/y-012



						$schdate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



					} else $schdate=date("Y-m-d");



					$task_related = '';

					if($pam3=='contact') $task_related='C';

					else if($pam3=='account') $task_related='A';

					else if($pam3=='opportunity') $task_related='O';



					$taskdata = array(



								'task_subject'=>$record['sch'][$catg],



								'task_priority'=>'Normal',



								'task_status'=>'In Progress',



								'task_related'=>$task_related,



								'task_relatedto'=>$record_id,



								'share_user_id'=>$this->_user_id,



								'task_duedate'=>$schdate,



								'task_info'=>$notes



								);



					$tid = $this->crm->save_task($taskdata,0);



				}



				//redirect(base_url() . 'crm/notes/view/'.$cid);



				//echo "YES-".$record['record_id'];

				

				$x='';

				if($cid1) $x=$cid1;

				else if($cid2) $x=$cid2;

				else if($cid2) $x=$cid32;

				

				$y='';

				if($record['contact']) $y=$record['contact'];

				else if($record['account']) $y=$record['account'];

				else if($record['opportunity']) $y=$record['opportunity'];

				

				echo "YES-".$x."-".$y;



				exit;



			}



			echo implode("\n",$er);



			exit;



			$this->_data['er']=$er;



			$this->_data['record']=$record;



		}



		$this->_data['parent_section'] = $parent_section."s";



		$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['crmlite'] = $crmlite;



		$this->_data['CustObjections'] = $this->crm->get_objections('Y');



		//Objections from Objection Map which are newly entered by user



		$this->_data['ObjectionsCampaign'] = $this->crm->get_objection_Campaign();



		$this->load->view('crm/interaction', $this->_data);



	}



	



	



	//Import Salesforce Contacts



	public function import_salesforce_Contact() {



		$contact_Records = $this->_data['Salesforce_Records'];



		if(!$contact_Records) {



			$this->_data['error']=array("There is no Contacts to import");



			return;



		}



		$c=0;



		//Email existance in Organisation

		$own = implode(",", $this->_parent_users_all);

		$ownq = " AND userid IN ($own)";



		foreach($contact_Records as $crow) {



			//Contact Record



			$cdata = array();



			$cdata['sfid']=$crow->ID;



			$cdata['user_prefix']=$crow->Salutation;



			$cdata['user_first']=$crow->FirstName;



			$cdata['user_last']=$crow->LastName;



			$cdata['user_title']=$crow->Title;



			$cdata['department']=$crow->Department;



			$cdata['birthdate']=$crow->Birthdate;



			$cdata['phone']=$crow->Phone;



			$cdata['mobile']=$crow->MobilePhone;



			$cdata['home_phone']=$crow->OtherPhone;



			$cdata['lead_source']=$crow->LeadSource;



			$cdata['email']=$crow->Email;



			$cdata['assistant']=$crow->AssistantName;



			$cdata['asst_phone']=$crow->AssistantPhone;			



			$cdata['description']=$crow->Description;			



			$cdata['share_user_id']=$this->_user_id;



			$cdata['create_date']=date("Y-m-d H:i:s");



			$cdata['modify_date']=date("Y-m-d H:i:s");	



			//Contact Account



			if($crow->AccountId && $crow->Account) {



				$Arow = $crow->Account;



				$account_id=0;



				//First check Salesforce Account ID



				$sfaccount_info = $this->crm->search_account(array('sfid',$Arow->ID,$this->_parent_users));



				//Next check account name in database



				if(!$sfaccount_info) $account_info = $this->crm->search_account(array('account_name',$Arow->Name,$this->_parent_users));



				else {



					$account_info = $sfaccount_info;



					$sfaccount_info = $Arow->ID;					



				}



				if($account_info) {



					$account_id = $account_info['account_id'];



				}				



				//Account Record



				$tab_account = array();				



				$tab_account['sfid']=$Arow->ID;



				$tab_account['account_name']=$Arow->Name;



				$tab_account['phone']=$Arow->Phone;



				$tab_account['fax']=$Arow->Fax;



				$tab_account['website']=$Arow->Website;



				$tab_account['share_user_id']=$this->_user_id;



				$tab_account['create_date']=date("Y-m-d H:i:s");



				$tab_account['modify_date']=date("Y-m-d H:i:s");



				if($account_info && $account_info['sfid']<>$Arow->ID) $account_id=0;



				$account_id = $this->crm->save_account($tab_account,$account_id);



				//Account Billing Address



				$Aadr=array();



				$Aadr['street']=$Arow->BillingStreet;



				$Aadr['city']=$Arow->BillingCity;



				$Aadr['state']=$Arow->BillingState;



				$Aadr['country']=$Arow->BillingCountry;



				$Aadr['zipcode']=$Arow->BillingPostalCode;



				$Aadr = array_filter($Aadr);



				if($account_id && $Aadr) 



				{



					$this->crm->delete_address($account_id,'A','billing');



					$Aadr['parent_id']=$account_id;



					$Aadr['adr_type']='billing';



					$Aadr['parent_type']='A';



					$this->crm->save_address($Aadr);



				}				



				if($account_id) $cdata['account_id']=$account_isearch_contactd;



			}



			$cdata = array_filter($cdata);



			//First check Salesforce Account ID



			$cid=0;



			$sfcontact_info = $this->crm->search_contact(array('sfid',$crow->ID,$this->_parent_users));



			if($sfcontact_info) $cid = $sfcontact_info['contact_id'];



			//verify unique email address

			if(!$cid) {

				//$email_info = $this->crm->search_contact(array('email',$cdata['email'],$this->_parent_users));

				//if($email_info) $cid = $email_info['contact_id'];

				$email_info = $this->crm->get_acRecord("LOWER(email)='".strtolower($cdata['email'])."'".$ownq,'contact_id,userid','C');

				if($email_info) {

					//Email existance in Organisation

					if($this->_user_id<>$email_info['userid']) continue;

					$cid = $email_info['contact_id'];

				}

			}



			$cid = $this->crm->save_contact($cdata,$cid);



			



			



			//Mailing Address



			$cadr=array();



			$cadr['street']=$crow->MailingStreet;



			$cadr['city']=$crow->MailingCity;



			$cadr['state']=$crow->MailingState;



			$cadr['country']=$crow->MailingCountry;



			$cadr['zipcode']=$crow->MailingPostalCode;



			$cadr = array_filter($cadr);



			if($cid && $cadr) 



			{



				$this->crm->delete_address($cid,'C');



				$cadr['parent_id']=$cid;



				$cadr['adr_type']='amail';



				$cadr['parent_type']='C';



				$this->crm->save_address($cadr);



			}



			if(!$cid) continue;



			//Notes



			if(isset($crow->Notes)) {



				foreach($crow->Notes as $note) {



					$notes_info = $this->crm->search_notes(array('sfid',$note->ID,$this->_parent_users));



					if($notes_info) {



						$notes_data = array(



									'notes_title'=>$note->Title,



									'notes_info'=>$note->Body,



									'notes_private'=>$note->IsPrivate?1:''



									);



						$nid = $this->crm->save_notes($notes_data,$notes_info['notes_id']);



					} else {



						$notes_data = array(									



									'notes_parent'=>'C',



									'notes_parentid'=>$cid,



									'sfid'=>$note->ID,



									'notes_title'=>$note->Title,



									'notes_info'=>$note->Body,



									'notes_private'=>$note->IsPrivate?1:''									



									);



						$nid = $this->crm->save_notes($notes_data,0);



					}



				}



			}	



			//Tasks



			if(isset($crow->Tasks)) {



				foreach($crow->Tasks as $task) {



					$task_info = $this->crm->search_task(array('sfid',$task->ID,$this->_parent_users));



					if($task_info) {



						$task_data = array(



								'task_subject'=>$task->Subject,



								'task_priority'=>$task->Priority,



								'task_status'=>$task->Status,



								'task_duedate'=>$task->ActivityDate,



								'task_info'=>$task->Description



								);



						$tid = $this->crm->save_task($task_data,$task_info['task_id']);



					} else {



						$task_data = array(



								'task_subject'=>$task->Subject,



								'task_priority'=>$task->Priority,



								'task_status'=>$task->Status,



								'task_related'=>'C',



								'task_relatedto'=>$cid,



								'sfid'=>$task->ID,



								'share_user_id'=>$this->_user_id,



								'task_duedate'=>$task->ActivityDate,



								'task_info'=>$task->Description



								);



						$tid = $this->crm->save_task($task_data,0);



					}



				}



			}		



			$c++;



			//break;



		}



		//echo "<pre>";print_r($cdata);print_r($cadr);print_r($tab_account);print_r($Aadr);echo "</pre>";exit;



		$this->_data['error']=array("$c Contacts to imported");



		unset($this->_data['importMode']);



		$this->salesforce();



	}



	//Import Salesforce Accounts



	public function import_salesforce_Account() {



		$account_Records = $this->_data['Salesforce_Records'];



		if(!$account_Records) {



			$this->_data['error']=array("There is no Accounts to import");



			return;



		}



		$c=0;



		foreach($account_Records as $crow) {



			//Contact Record



			$cdata = array();



			$cdata['sfid']=$crow->ID;



			$cdata['account_name']=$crow->Name;



			$cdata['account_number']=$crow->AccountNumber;



			$cdata['account_site']=$crow->Site;



			$cdata['account_type']=$crow->Type;



			$cdata['industry']=$crow->Industry;



			$cdata['revenue']=(float)$crow->AnnualRevenue;



			$cdata['rating']=$crow->Rating;



			$cdata['phone']=$crow->Phone;



			$cdata['fax']=$crow->Fax;



			$cdata['website']=$crow->Website;



			$cdata['ticker_symbol']=$crow->TickerSymbol;



			$cdata['ownership']=$crow->Ownership;



			$cdata['employees']=(int)$crow->NumberOfEmployees;



			$cdata['siccode']=$crow->Sic;			



			$cdata['description']=$crow->Description;			



			$cdata['share_user_id']=$this->_user_id;



			$cdata['create_date']=date("Y-m-d H:i:s");



			$cdata['modify_date']=date("Y-m-d H:i:s");



			$cdata = array_filter($cdata);



			$cid=0;



			$sfaccount_info = $this->crm->search_account(array('sfid',$crow->ID,$this->_parent_users));



			if(!$sfaccount_info) $sfaccount_info = $this->crm->search_account(array('account_name',$crow->Name,$this->_parent_users));



			if($sfaccount_info) $cid = $sfaccount_info['account_id'];



			$cid = $this->crm->save_account($cdata,$cid);



			if(!$cid) continue;



			//Billing Address



			$cadr=array();



			$cadr['street']=$crow->BillingStreet;



			$cadr['city']=$crow->BillingCity;



			$cadr['state']=$crow->BillingState;



			$cadr['country']=$crow->BillingCountry;



			$cadr['zipcode']=$crow->BillingPostalCode;



			$cadr = array_filter($cadr);



			if($cid && $cadr) 



			{



				$this->crm->delete_address($cid,'A','billing');



				$cadr['parent_id']=$cid;



				$cadr['adr_type']='billing';



				$cadr['parent_type']='A';



				$this->crm->save_address($cadr);



			}



			//Shipping Address



			$cadr=array();



			$cadr['street']=$crow->ShippingStreet;



			$cadr['city']=$crow->ShippingCity;



			$cadr['state']=$crow->ShippingState;



			$cadr['country']=$crow->ShippingCountry;



			$cadr['zipcode']=$crow->ShippingPostalCode;



			$cadr = array_filter($cadr);



			if($cid && $cadr) 



			{



				$this->crm->delete_address($cid,'A','shipping');



				$cadr['parent_id']=$cid;



				$cadr['adr_type']='shipping';



				$cadr['parent_type']='A';



				$this->crm->save_address($cadr);



			}



			//Notes



			if(isset($crow->Notes)) {



				foreach($crow->Notes as $note) {



					$notes_info = $this->crm->search_notes(array('sfid',$note->ID,$this->_parent_users));



					if($notes_info) {



						$notes_data = array(



									'notes_title'=>$note->Title,



									'notes_info'=>$note->Body,



									'notes_private'=>$note->IsPrivate?1:''



									);



						$nid = $this->crm->save_notes($notes_data,$notes_info['notes_id']);



					} else {



						$notes_data = array(									



									'notes_parent'=>'A',



									'notes_parentid'=>$cid,



									'sfid'=>$note->ID,



									'notes_title'=>$note->Title,



									'notes_info'=>$note->Body,



									'notes_private'=>$note->IsPrivate?1:''									



									);



						$nid = $this->crm->save_notes($notes_data,0);



					}



				}



			}



			$c++;



		}



		//echo "<pre>";print_r($cdata);print_r($cadr);print_r($tab_account);print_r($Aadr);echo "</pre>";exit;



		$this->_data['error']=array("$c Accounts to imported");



		unset($this->_data['importMode']);



		$this->salesforce();



	}



	//Salesforce Date

	public function sforce_input($data) {

	   $data = trim($data);

	   $data = stripslashes($data);

	   $data = htmlspecialchars($data);

	   return $data;

	}

	



	//Salesforce checker



	public function salesforce($action = NULL) {



		/*echo "<pre>";



		print_r($_SESSION);



		print_r($_COOKIE);



		echo "</pre>";*/



		//exit;



		$rtype = $this->_data['sfMode'];		



		if(!$rtype) $rtype = $this->uri->segment(4);//contacts/accounts



		//echo "Act: " . $rtype;



		//exit;



		$sflogin=0;



		if($_SESSION['instance'] && $_SESSION['access_token'] && $_SESSION['expires']) {			



			$exp = strtotime($_SESSION['expires']);



			$pre = time();



			//if($exp < $pre) {



				/*if(isset($_SESSION['instance'])) unset($_SESSION['instance']);



				if(isset($_SESSION['access_token'])) unset($_SESSION['access_token']);



				if(isset($_SESSION['expires'])) unset($_SESSION['expires']);*/



				/*if($rtype=="accounts") $rcdtype = "a";



				else if($rtype=="contactRecord") $rcdtype = "cr";



				else $rcdtype = "c";*/



				//header('location: /pro/page1.php?template=yes&bcrm=y&rc='.$rtype);



			//} else $sflogin = 1;

			

			$sflogin = 1;

		}



		if(!$sflogin || $action=="login") header('location: /pro/page1.php?template=yes&bcrm=y&rc='.$rtype);



		$this->_data['sflogin']=$sflogin;

		

		if(!$sflogin) return;



		//error_reporting(E_ALL);



		//Creating Webservice WSDL file		



		$InstWsdl = dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml';



		if(!file_exists($InstWsdl))



		{



			$fp = fopen($InstWsdl, "w");



			$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');



			$wsdlcontent = str_replace('na16.salesforce.com',$_SESSION['instance'].'.salesforce.com',$wsdlcontent);



			if(fwrite($fp, $wsdlcontent))



			{



				fclose($fp);



				header('location: '.current_url());



			}



			fclose($fp);



		}



		//Creating Webservice WSDL file - Completed



		



		//Creating a Connection



		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');



		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');



		// Salesforce Login information



		$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';



		$servicewsdl = $InstWsdl;



		



		try {



		



			$endPoint = $_SESSION['ws_endpoint'];



			$sessionId = $_SESSION['access_token'];



			$instance = $_SESSION['instance_url'];



			



			$ssPart = explode("!",$sessionId);//For OrgID



			//sfdc.endpoint=https://test.salesforce.com/services/Soap/c/22.0/OrgID



			$location = $instance."/services/Soap/u/27.0/".$ssPart[0];



			



			// Process of logging on and getting a salesforce.com session



			$client = new SforcePartnerClient();



			$client->createConnection($wsdl);



			$client->setEndpoint($location);



			$client->setSessionHeader($sessionId);		



			



			/*$service = new SoapClient($servicewsdl,array("trace" => 1, "soap_version" => SOAP_1_1));



			$sforce_header = new SoapHeader($_SESSION['ws_namespace'], "SessionHeader", array("sessionId" => $client->getSessionId()));



			$service->__setSoapHeaders(array($sforce_header));*/



			//Import Account to salesforce



			if(strstr($rtype,"ar-")!==FALSE) {//echo "Wait"; exit;



				$cRecord = $this->_data['sfRecord'];



				$sfid = '';



				if($cRecord['sfid']) {



					$TRecord=$client->retrieve("Id","Account",array($cRecord['sfid']));



					if(isset($TRecord[0]->Id)) $sfid = $cRecord['sfid'];



				}



				//Account Record



				//echo "<pre>";print_r($cRecord);echo "</pre>";



				$records = array();



				$records[0] = new SObject();



				if($sfid) $records[0]->Id = $sfid;				



				$Account_record = array(



					'Name' => htmlspecialchars($cRecord['account_name']),



					'AccountNumber' => $cRecord['account_number'],



					'Site' => $cRecord['account_site'],



					'Type' => $cRecord['account_type'],



					'Industry' => $cRecord['industry'],



					'AnnualRevenue' => $cRecord['revenue'],



					'Rating' => $cRecord['rating'],



					'Phone' => $cRecord['phone'],



					'Fax' => $cRecord['fax'],



					'Website' => $cRecord['website'],



					'TickerSymbol' => $cRecord['ticker_symbol'],



					'Ownership' => $cRecord['ownership'],



					'NumberOfEmployees' => $cRecord['employees'],



					'Sic' => $cRecord['siccode'],



					'Description' => $cRecord['description']



				);



				//Billing Address



				if(isset($cRecord['billing'])) {



					$Account_record['BillingStreet']=$cRecord['billing']['street'];



					$Account_record['BillingCity']=$cRecord['billing']['city'];



					$Account_record['BillingState']=$cRecord['billing']['state'];



					$Account_record['BillingCountry']=$cRecord['billing']['country'];



					$Account_record['BillingPostalCode']=$cRecord['billing']['zipcode'];



				}



				//Shipping Address



				if(isset($cRecord['shipping'])) {



					$Account_record['ShippingStreet']=$cRecord['shipping']['street'];



					$Account_record['ShippingCity']=$cRecord['shipping']['city'];



					$Account_record['ShippingState']=$cRecord['shipping']['state'];



					$Account_record['ShippingCountry']=$cRecord['shipping']['country'];



					$Account_record['ShippingPostalCode']=$cRecord['shipping']['zipcode'];



				}



				$Account_record = array_filter($Account_record);



				$records[0]->fields = $Account_record;



				$records[0]->type = 'Account';



				//echo "<pre>";print_r($records);echo "</pre>";//exit;



				if($sfid) $response = $client->update($records);



				else $response = $client->create($records);



				$error = 0;



				foreach ($response as $result) {



					$er = $result->success == 1?false : "Error: ".$result->errors->message;



					if($er<>false) {



						$error=1;



						break;



					}	



				}

				

				

				if($error) $this->_data['error']=array($er);



				else {



					$accountID = $result->id;



					if($sfid=='') {



						$rectmp=array('sfid'=>$accountID);



						$cid = $this->crm->save_account($rectmp,$cRecord['account_id']);



						$sfmessage = "Account has been successfully created in Salesforce.";



					} else $sfmessage = "Account updates have been sent to Salesforce.";



					//Import notes to salesforce

					

					//echo "123".$sfmessage;



					$notes_list = $this->crm->get_all_notes($cRecord['account_id'],'A');



					if($notes_list) {



						foreach($notes_list as $notes) {



							$sfid='';



							if($notes->sfid) {



								$TRecord=$client->retrieve("Id","Note",array($notes->sfid));



								if(isset($TRecord[0]->Id)) $sfid = $notes->sfid;



							}



							$record = array();



							$record[0] = new SObject();							



							if($sfid) $record[0]->Id = $sfid;



							$NoteRow = array(



								'Title' => $notes->notes_title,



								'Body' => $notes->notes_info,



								'IsPrivate' =>$notes->notes_private=='1'?'true':'false',



								'ParentId' => !$sfid?$accountID:''



								);



							$NoteRow = array_filter($NoteRow);						



							$record[0]->fields = $NoteRow;



							$record[0]->type = 'Note';



							//echo "<pre>";print_r($record);echo "</pre>";



							if($sfid) $response = $client->update($record);



							else $response = $client->create($record);











							foreach ($response as $result) {



								if($result->success==1 && $sfid=='') {



									$rectmp=array('sfid'=>$result->id);



									$cid = $this->crm->save_notes($rectmp,$notes->notes_id);



									break;



								}	



							}



							//echo "<pre>";print_r($response);echo "</pre>";



						}



					}

					

					//echo "456".$sfmessage;

					

					



					$this->_data['error']=array($sfmessage);

					//exit;

					



				}



			}



			//Import contact to salesforce

				



			else if(strstr($rtype,"cr-")!==FALSE) { //echo "Wait"; exit;

			

				

				

				$cRecord = $this->_data['sfRecord'];



				$sfid = '';

				

				$sfname = $cRecord['user_first'];

				

				if($cRecord['user_last']) $sfname = $cRecord['user_last'];



				if($cRecord['sfid']) {



					$TRecord=$client->retrieve("Id","Contact",array($cRecord['sfid']));



					if(isset($TRecord[0]->Id)) $sfid = $cRecord['sfid'];



				}

				else

				{

					$query = "SELECT Id from Contact WHERE LastName='{$sfname}'";



					$response = $client->query($query);



					$queryResult = new QueryResult($response);



					



					$contact_Records = array();



					for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {



						$record = $queryResult->current();



						//$Irow = $record->fields;



						$sfid=$record->Id;



						//$contact_Records[] = $Irow;



						break;



					}

				}



				//Contact Record



				//echo "<pre>";print_r($cRecord);echo "</pre>";



				$records = array();



				$records[0] = new SObject();



				if($sfid) $records[0]->Id = $sfid;				



				$Contact_record = array(



					'Salutation' => $cRecord['user_prefix'],



					'Title' => $cRecord['user_title'],



					'Department' => $cRecord['department'],



					'Phone' => $cRecord['phone'],



					'MobilePhone' => $cRecord['mobile'],



					'OtherPhone' => $cRecord['home_phone'],



					'LeadSource' => $cRecord['lead_source'],



					'Email' => $cRecord['email'],



					'AssistantName' => $cRecord['assistant'],



					'AssistantPhone' => $cRecord['asst_phone'],



					'Description' => $cRecord['description']



				);



				if((int)$cRecord['birthdate']) $Contact_record['Birthdate']=$cRecord['birthdate'];

				

				if(($cRecord['user_first']!="") && ($cRecord['user_last']!=""))

				{ 

					$Contact_record['FirstName']=$cRecord['user_first'];

					$Contact_record['LastName']=$cRecord['user_last'];

				}

				else

				{

					$Contact_record['FirstName']=$cRecord['user_first'];

					$Contact_record['LastName']=$cRecord['user_first'];

				}



				if(isset($cRecord['amail'])) {



					$Contact_record['MailingStreet']=$cRecord['amail']['street'];



					$Contact_record['MailingCity']=$cRecord['amail']['city'];



					$Contact_record['MailingState']=$cRecord['amail']['state'];



					$Contact_record['MailingCountry']=$cRecord['amail']['country'];



					$Contact_record['MailingPostalCode']=$cRecord['amail']['zipcode'];



				}

				

				//echo '<pre>'; print_r($Contact_record); echo '</pre>';



				$Contact_record = array_filter($Contact_record);



				$records[0]->fields = $Contact_record;



				$records[0]->type = 'Contact';



				//echo "<pre>";print_r($records);echo "</pre>";



				if($sfid) $response = $client->update($records);



				else $response = $client->create($records);



				//echo "<pre>";print_r($response);echo "</pre>";//exit;



				$error = 0;



				foreach ($response as $result) {



					$er = $result->success == 1?false : "Error: ".$result->errors->message;



					if($er<>false) {



						$error=1;



						break;



					}	



				}

				//echo $error;

				//exit;

				

				if($error) $this->_data['error']=array($er);



				else {

				

					//echo "test"; //exit;



					$contactID = $result->id;



					if($sfid=='') {



						$rectmp=array('sfid'=>$contactID);



						$cid = $this->crm->save_contact($rectmp,$cRecord['contact_id']);



						$sfmessage = "Contact has been successfully created in Salesforce.";



					} else $sfmessage = "Contact updates have been sent to Salesforce.";

					

					$this->_data['error']=array($sfmessage);

					

					//echo "Test".$sfmessage."Test";



					//Import notes to salesforce



					$notes_list = $this->crm->get_all_notes($cRecord['contact_id'],'C');



					if($notes_list) {



						foreach($notes_list as $notes) {



							$sfid='';



							if($notes->sfid) {



								$TRecord=$client->retrieve("Id","Note",array($notes->sfid));



								if(isset($TRecord[0]->Id)) $sfid = $notes->sfid;



							}



							$record = array();



							$record[0] = new SObject();



							if($sfid) $record[0]->Id = $notes->sfid;



							$NoteRow = array(



								'Title' => $notes->notes_title,



								'Body' => $notes->notes_info,



								'IsPrivate' =>$notes->notes_info=='1'?'true':'false',



								'ParentId' => !$sfid?$contactID:''



								);		



							$NoteRow = array_filter($NoteRow);



							$record[0]->fields = $NoteRow;



							$record[0]->type = 'Note';



							//echo "<pre>";print_r($NoteRow);echo "</pre>";



							if($sfid) $response = $client->update($record);



							else $response = $client->create($record);



							foreach ($response as $result) {



								if($result->success==1 && $sfid=='') {



									$rectmp=array('sfid'=>$result->id);



									$cid = $this->crm->save_notes($rectmp,$notes->notes_id);



									break;



								}	



							}



							//echo "<pre>";print_r($response);echo "</pre>";



						}



					}



					//Import tasks to salesforce



					$tasks_list = $this->crm->get_all_tasks($cRecord['contact_id'],'C');



					if($tasks_list) {

						$n=0;

						foreach($tasks_list as $task) {

							$n++;							

							try {



							$sfid='';



							if($task->sfid) {



								$TRecord=$client->retrieve("Id","Task",array($task->sfid));



								if(isset($TRecord[0]->Id)) $sfid = $task->sfid;



							}



							$record = array();



							$record[0] = new SObject();



							if($sfid) $record[0]->Id = $task->sfid;

							

							$description = $this->sforce_input($task->task_info);



							$taskRow = array(



								'Subject' => $task->task_subject,



								'Priority' => $task->task_priority,



								'Status' =>$task->task_status,



								'Description' =>$description,



								'WhoId' => !$sfid?$contactID:''



								);



							if((int)$task->task_duedate) $taskRow['ActivityDate']=$task->task_duedate;



							$taskRow = array_filter($taskRow);



							$record[0]->fields = $taskRow;



							$record[0]->type = 'Task';

							

							/*echo "-----------------------------------$n-------------------------------<br/>";



							echo "<pre>";print_r($taskRow);echo "</pre>";*/



							/*echo "<pre>";print_r($record);echo "</pre>";

							

							echo "-----------------------------------$n-------------------------------<br/>";*/

							

							



							if($sfid) $response = $client->update($record);



							else $response = $client->create($record);



							foreach ($response as $result) {



								if($result->success==1 && $sfid=='') {



									$rectmp=array('sfid'=>$result->id);



									$cid = $this->crm->save_task($rectmp,$task->task_id);



									break;



								}	



							}



							//echo "<pre>";print_r($response);echo "</pre>";



							//exit;



							//break;

							

							}

							catch (Exception $e) {

								echo "Exception at $n<br/>";

							}

							//if($n==40) break;

						}

						//exit;

					}

				}	

				

				//$this->_data['error']=array($sfmessage);



			}



			//Grab contacts



			else if($rtype=="c") {				



			



				if(isset($this->_data['importMode'])) {



					$cntIds=$this->input->post('recids');			



					if(!$cntIds) {



						$this->_data['error']=array("Contacts not selected");



						return;



					}



					//Get selected contacts



					$sContacts=$client->retrieve("Id,Salutation,FirstName,LastName,AccountId,Title, Department,Birthdate,Phone,MobilePhone,OtherPhone,LeadSource,Email,AssistantName,AssistantPhone,MailingStreet,MailingCity,MailingState,MailingCountry,MailingPostalCode,Description","Contact",$cntIds);



					//echo "<pre>";print_r($sContacts);echo "</pre>";



					if($sContacts) {



						foreach($sContacts as $record) {



							$Irow = $record->fields;



							$Irow->ID=$record->Id;



							if(isset($Irow->AccountId) && $Irow->AccountId) 



							{



								$ARecord=$client->retrieve("Id,Name,BillingCity,BillingCountry,BillingPostalCode,BillingState,BillingStreet,Phone,Fax,Website","Account",array($Irow->AccountId));



								if($ARecord) {



									$Irow->Account=$ARecord[0]->fields;



									$Irow->Account->ID=$ARecord[0]->Id;



								}



							}



							//Notes



							$query2 = "SELECT Id,Title,Body,IsPrivate from Note WHERE ParentId='{$record->Id}'";


 
							$response2 = $client->query($query2);



							$queryResult2 = new QueryResult($response2);



							for ($queryResult2->rewind(); $queryResult2->pointer < $queryResult2->size; $queryResult2->next()) {



								$record2 = $queryResult2->current();



								$temp = $record2->fields;



								$temp->ID = $record2->Id;



								$Irow->Notes[]=$temp;



								//echo "<pre>";print_r($record2);echo "</pre>";



							}



							//Tasks



							$query2 = "SELECT Id,Subject,Status,Priority,Description,ActivityDate from Task WHERE WhoId='{$record->Id}'";



							$response2 = $client->query($query2);



							$queryResult2 = new QueryResult($response2);



							for ($queryResult2->rewind(); $queryResult2->pointer < $queryResult2->size; $queryResult2->next()) {



								$record2 = $queryResult2->current();



								$temp = $record2->fields;



								$temp->ID = $record2->Id;



								$Irow->Tasks[]=$temp;



								//echo "<pre>";print_r($record2);echo "</pre>";



							}



							$contact_Records[] = $Irow;



						}



					}



					//echo "<pre>";print_r($contact_Records);echo "</pre>";exit;



				} else {



					//Get all contacts



					$query = "SELECT Id,FirstName,LastName,Phone,Email from Contact";



					$response = $client->query($query);



					$queryResult = new QueryResult($response);



					



					$contact_Records = array();



					for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {



						$record = $queryResult->current();



						$Irow = $record->fields;



						$Irow->ID=$record->Id;



						$contact_Records[] = $Irow;



						//break;



					}



				}



				$Salesforce_Records=$contact_Records;



				



			}//End of Contacts grabing



			



			//Grab accounts



			else if($rtype=="a") {



				$account_Records = array();



				if(isset($this->_data['importMode'])) {



					$cntIds=$this->input->post('recids');			



					if(!$cntIds) {



						$this->_data['error']=array("Accounts not selected");



						return;



					}



					//Get selected accounts



					$sRecords=$client->retrieve("Id,Name,AccountNumber,Site,Type,Industry,AnnualRevenue,Rating,



						Phone,Fax,Website,TickerSymbol,Ownership,NumberOfEmployees,Sic,



						BillingCity,BillingCountry,BillingPostalCode,BillingState,BillingStreet,



						ShippingCity,ShippingCountry,ShippingPostalCode,ShippingState,ShippingStreet,Description","Account",$cntIds);



					if($sRecords) {



						foreach($sRecords as $record) {



							$Irow = $record->fields;



							$Irow->ID=$record->Id;



							//Notes



							$query2 = "SELECT Id,Title,Body,IsPrivate from Note WHERE ParentId='{$record->Id}'";



							$response2 = $client->query($query2);



							$queryResult2 = new QueryResult($response2);



							for ($queryResult2->rewind(); $queryResult2->pointer < $queryResult2->size; $queryResult2->next()) {



								$record2 = $queryResult2->current();



								$temp = $record2->fields;



								$temp->ID = $record2->Id;



								$Irow->Notes[]=$temp;



								//echo "<pre>";print_r($record2);echo "</pre>";



							}



							$account_Records[] = $Irow;							



						}



					}



					



				} else {



					//Get all accounts



					$query = "SELECT Id,Name,BillingCity,Phone from Account";



					$response = $client->query($query);



					$queryResult = new QueryResult($response);					



					



					for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {



						$record = $queryResult->current();



						$Irow = $record->fields;



						$Irow->ID=$record->Id;



						$account_Records[] = $Irow;



					}				



				}				



				$Salesforce_Records=$account_Records;				



			}//End of accounts grabing



			//echo "<pre>";print_r($contact_Records);echo "</pre>";exit;



			



			$this->_data['Salesforce_Records']=$Salesforce_Records;



		



		



		} catch (Exception $e) {



			//$this->_data['error']=array($e->faultstring);



			/*echo "Exception ".$e->faultstring."<br/><br/>\n";



			echo "Last Request:<br/><br/>\n";



			echo $client->getLastRequestHeaders();



			echo "<br/><br/>\n";



			echo $client->getLastRequest();



			echo "<br/><br/>\n";



			echo "Last Response:<br/><br/>\n";



			echo $client->getLastResponseHeaders();



			echo "<br/><br/>\n";



			echo $client->getLastResponse();*/



		}//echo "YES";exit;



		//exit;



	}



	//Salesforce checkeer



	public function salesforce123($action = NULL) {



		/*echo "<pre>";



		print_r($_SESSION);



		print_r($_COOKIE);



		echo "</pre>";*/



		//exit;



		$rtype = $this->_data['sfMode'];		



		if(!$rtype) $rtype = $this->uri->segment(4);//contacts/accounts



		//echo "Act: " . $rtype;



		//exit;



		$sflogin=0;



		if($_SESSION['instance'] && $_SESSION['access_token'] && $_SESSION['expires']) {			



			$exp = strtotime($_SESSION['expires']);



			$pre = time();



			//if($exp < $pre) {



				/*if(isset($_SESSION['instance'])) unset($_SESSION['instance']);



				if(isset($_SESSION['access_token'])) unset($_SESSION['access_token']);



				if(isset($_SESSION['expires'])) unset($_SESSION['expires']);*/



				/*if($rtype=="accounts") $rcdtype = "a";



				else if($rtype=="contactRecord") $rcdtype = "cr";



				else $rcdtype = "c";*/



				//header('location: /pro/page1.php?template=yes&bcrm=y&rc='.$rtype);



			//} else $sflogin = 1;

			

			$sflogin = 1;

		}



		if(!$sflogin || $action=="login") header('location: /pro/page1.php?template=yes&bcrm=y&rc='.$rtype);



		$this->_data['sflogin']=$sflogin;

		

		if(!$sflogin) return;



		//error_reporting(E_ALL);



		//Creating Webservice WSDL file		



		$InstWsdl = dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml';



		if(!file_exists($InstWsdl))



		{



			$fp = fopen($InstWsdl, "w");



			$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');



			$wsdlcontent = str_replace('na16.salesforce.com',$_SESSION['instance'].'.salesforce.com',$wsdlcontent);



			if(fwrite($fp, $wsdlcontent))



			{



				fclose($fp);



				header('location: '.current_url());



			}



			fclose($fp);



		}



		//Creating Webservice WSDL file - Completed



		



		//Creating a Connection



		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');



		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');



		// Salesforce Login information



		$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';



		$servicewsdl = $InstWsdl;



		



		try {



		



			$endPoint = $_SESSION['ws_endpoint'];



			$sessionId = $_SESSION['access_token'];



			$instance = $_SESSION['instance_url'];



			



			$ssPart = explode("!",$sessionId);//For OrgID



			//sfdc.endpoint=https://test.salesforce.com/services/Soap/c/22.0/OrgID



			$location = $instance."/services/Soap/u/27.0/".$ssPart[0];



			



			// Process of logging on and getting a salesforce.com session



			$client = new SforcePartnerClient();



			$client->createConnection($wsdl);



			$client->setEndpoint($location);



			$client->setSessionHeader($sessionId);		



			



			/*$service = new SoapClient($servicewsdl,array("trace" => 1, "soap_version" => SOAP_1_1));



			$sforce_header = new SoapHeader($_SESSION['ws_namespace'], "SessionHeader", array("sessionId" => $client->getSessionId()));



			$service->__setSoapHeaders(array($sforce_header));*/



			//Import Account to salesforce



			if(strstr($rtype,"ar-")!==FALSE) {//echo "Wait"; exit;



				$cRecord = $this->_data['sfRecord'];



				$sfid = '';



				if($cRecord['sfid']) {



					$TRecord=$client->retrieve("Id","Account",array($cRecord['sfid']));



					if(isset($TRecord[0]->Id)) $sfid = $cRecord['sfid'];



				}



				//Account Record



				//echo "<pre>";print_r($cRecord);echo "</pre>";



				$records = array();



				$records[0] = new SObject();



				if($sfid) $records[0]->Id = $sfid;				



				$Account_record = array(



					'Name' => htmlspecialchars($cRecord['account_name']),



					'AccountNumber' => $cRecord['account_number'],



					'Site' => $cRecord['account_site'],



					'Type' => $cRecord['account_type'],



					'Industry' => $cRecord['industry'],



					'AnnualRevenue' => $cRecord['revenue'],



					'Rating' => $cRecord['rating'],



					'Phone' => $cRecord['phone'],



					'Fax' => $cRecord['fax'],



					'Website' => $cRecord['website'],



					'TickerSymbol' => $cRecord['ticker_symbol'],



					'Ownership' => $cRecord['ownership'],



					'NumberOfEmployees' => $cRecord['employees'],



					'Sic' => $cRecord['siccode'],



					'Description' => $cRecord['description']



				);



				//Billing Address



				if(isset($cRecord['billing'])) {



					$Account_record['BillingStreet']=$cRecord['billing']['street'];



					$Account_record['BillingCity']=$cRecord['billing']['city'];



					$Account_record['BillingState']=$cRecord['billing']['state'];



					$Account_record['BillingCountry']=$cRecord['billing']['country'];



					$Account_record['BillingPostalCode']=$cRecord['billing']['zipcode'];



				}



				//Shipping Address



				if(isset($cRecord['shipping'])) {



					$Account_record['ShippingStreet']=$cRecord['shipping']['street'];



					$Account_record['ShippingCity']=$cRecord['shipping']['city'];



					$Account_record['ShippingState']=$cRecord['shipping']['state'];



					$Account_record['ShippingCountry']=$cRecord['shipping']['country'];



					$Account_record['ShippingPostalCode']=$cRecord['shipping']['zipcode'];



				}



				$Account_record = array_filter($Account_record);



				$records[0]->fields = $Account_record;



				$records[0]->type = 'Account';



				//echo "<pre>";print_r($records);echo "</pre>";//exit;



				if($sfid) $response = $client->update($records);



				else $response = $client->create($records);



				$error = 0;



				foreach ($response as $result) {



					$er = $result->success == 1?false : "Error: ".$result->errors->message;



					if($er<>false) {



						$error=1;



						break;



					}	



				}

				

				

				if($error) $this->_data['error']=array($er);



				else {



					$accountID = $result->id;



					if($sfid=='') {



						$rectmp=array('sfid'=>$accountID);



						$cid = $this->crm->save_account($rectmp,$cRecord['account_id']);



						$sfmessage = "Account has been successfully created in Salesforce.";



					} else $sfmessage = "Account updates have been sent to Salesforce.";



					//Import notes to salesforce

					

					//echo "123".$sfmessage;



					$notes_list = $this->crm->get_all_notes($cRecord['account_id'],'A');



					if($notes_list) {



						foreach($notes_list as $notes) {



							$sfid='';



							if($notes->sfid) {



								$TRecord=$client->retrieve("Id","Note",array($notes->sfid));



								if(isset($TRecord[0]->Id)) $sfid = $notes->sfid;



							}



							$record = array();



							$record[0] = new SObject();							



							if($sfid) $record[0]->Id = $sfid;



							$NoteRow = array(



								'Title' => $notes->notes_title,



								'Body' => $notes->notes_info,



								'IsPrivate' =>$notes->notes_private=='1'?'true':'false',



								'ParentId' => !$sfid?$accountID:''



								);



							$NoteRow = array_filter($NoteRow);						



							$record[0]->fields = $NoteRow;



							$record[0]->type = 'Note';



							//echo "<pre>";print_r($record);echo "</pre>";



							if($sfid) $response = $client->update($record);



							else $response = $client->create($record);











							foreach ($response as $result) {



								if($result->success==1 && $sfid=='') {



									$rectmp=array('sfid'=>$result->id);



									$cid = $this->crm->save_notes($rectmp,$notes->notes_id);



									break;



								}	



							}



							//echo "<pre>";print_r($response);echo "</pre>";



						}



					}

					

					//echo "456".$sfmessage;

					

					



					$this->_data['error']=array($sfmessage);

					//exit;

					



				}



			}



			//Import contact to salesforce

				



			else if(strstr($rtype,"cr-")!==FALSE) {//echo "Wait"; exit;

			

				

				

				$cRecord = $this->_data['sfRecord'];



				$sfid = '';



				if($cRecord['sfid']) {



					$TRecord=$client->retrieve("Id","Contact",array($cRecord['sfid']));



					if(isset($TRecord[0]->Id)) $sfid = $cRecord['sfid'];



				}



				//Contact Record



				//echo "<pre>";print_r($cRecord);echo "</pre>";



				$records = array();



				$records[0] = new SObject();



				if($sfid) $records[0]->Id = $sfid;				



				$Contact_record = array(



					'Salutation' => $cRecord['user_prefix'],



					'FirstName' => $cRecord['user_first'],



					'LastName' => $cRecord['user_last'],



					'Title' => $cRecord['user_title'],



					'Department' => $cRecord['department'],



					'Phone' => $cRecord['phone'],



					'MobilePhone' => $cRecord['mobile'],



					'OtherPhone' => $cRecord['home_phone'],



					'LeadSource' => $cRecord['lead_source'],



					'Email' => $cRecord['email'],



					'AssistantName' => $cRecord['assistant'],



					'AssistantPhone' => $cRecord['asst_phone'],



					'Description' => $cRecord['description']



				);



				if((int)$cRecord['birthdate']) $Contact_record['Birthdate']=$cRecord['birthdate'];



				if(isset($cRecord['amail'])) {



					$Contact_record['MailingStreet']=$cRecord['amail']['street'];



					$Contact_record['MailingCity']=$cRecord['amail']['city'];



					$Contact_record['MailingState']=$cRecord['amail']['state'];



					$Contact_record['MailingCountry']=$cRecord['amail']['country'];



					$Contact_record['MailingPostalCode']=$cRecord['amail']['zipcode'];



				}



				$Contact_record = array_filter($Contact_record);



				$records[0]->fields = $Contact_record;



				$records[0]->type = 'Contact';



				//echo "<pre>";print_r($records);echo "</pre>";



				if($sfid) $response = $client->update($records);



				else $response = $client->create($records);



				//echo "<pre>";print_r($response);echo "</pre>";exit;



				$error = 0;



				foreach ($response as $result) {



					$er = $result->success == 1?false : "Error: ".$result->errors->message;



					if($er<>false) {



						$error=1;



						break;



					}	



				}

				

				

				if($error) $this->_data['error']=array($er);



				else {



					$contactID = $result->id;



					if($sfid=='') {



						$rectmp=array('sfid'=>$contactID);



						$cid = $this->crm->save_contact($rectmp,$cRecord['contact_id']);



						$sfmessage = "Contact has been successfully created in Salesforce.";



					} else $sfmessage = "Contact updates have been sent to Salesforce.";

					

					$this->_data['error']=array($sfmessage);



					//Import notes to salesforce



					$notes_list = $this->crm->get_all_notes($cRecord['contact_id'],'C');



					if($notes_list) {



						foreach($notes_list as $notes) {



							$sfid='';



							if($notes->sfid) {



								$TRecord=$client->retrieve("Id","Note",array($notes->sfid));



								if(isset($TRecord[0]->Id)) $sfid = $notes->sfid;



							}



							$record = array();



							$record[0] = new SObject();



							if($sfid) $record[0]->Id = $notes->sfid;



							$NoteRow = array(



								'Title' => $notes->notes_title,



								'Body' => $notes->notes_info,



								'IsPrivate' =>$notes->notes_info=='1'?'true':'false',



								'ParentId' => !$sfid?$contactID:''



								);		



							$NoteRow = array_filter($NoteRow);



							$record[0]->fields = $NoteRow;



							$record[0]->type = 'Note';



							//echo "<pre>";print_r($NoteRow);echo "</pre>";



							if($sfid) $response = $client->update($record);



							else $response = $client->create($record);



							foreach ($response as $result) {



								if($result->success==1 && $sfid=='') {



									$rectmp=array('sfid'=>$result->id);



									$cid = $this->crm->save_notes($rectmp,$notes->notes_id);



									break;



								}	



							}



							//echo "<pre>";print_r($response);echo "</pre>";



						}



					}



					//Import tasks to salesforce



					$tasks_list = $this->crm->get_all_tasks($cRecord['contact_id'],'C');



					if($tasks_list) {

						$n=0;

						foreach($tasks_list as $task) {

							$n++;							

							try {



							$sfid='';



							if($task->sfid) {



								$TRecord=$client->retrieve("Id","Task",array($task->sfid));



								if(isset($TRecord[0]->Id)) $sfid = $task->sfid;



							}



							$record = array();



							$record[0] = new SObject();



							if($sfid) $record[0]->Id = $task->sfid;

							

							$description = $this->sforce_input($task->task_info);



							$taskRow = array(



								'Subject' => $task->task_subject,



								'Priority' => $task->task_priority,



								'Status' =>$task->task_status,



								'Description' =>$description,



								'WhoId' => !$sfid?$contactID:''



								);



							if((int)$task->task_duedate) $taskRow['ActivityDate']=$task->task_duedate;



							$taskRow = array_filter($taskRow);



							$record[0]->fields = $taskRow;



							$record[0]->type = 'Task';

							

							/*echo "-----------------------------------$n-------------------------------<br/>";



							echo "<pre>";print_r($taskRow);echo "</pre>";*/



							/*echo "<pre>";print_r($record);echo "</pre>";

							

							echo "-----------------------------------$n-------------------------------<br/>";*/

							

							



							if($sfid) $response = $client->update($record);



							else $response = $client->create($record);



							foreach ($response as $result) {



								if($result->success==1 && $sfid=='') {



									$rectmp=array('sfid'=>$result->id);



									$cid = $this->crm->save_task($rectmp,$task->task_id);



									break;



								}	



							}



							//echo "<pre>";print_r($response);echo "</pre>";



							//exit;



							//break;

							

							}

							catch (Exception $e) {

								echo "Exception at $n<br/>";

							}

							//if($n==40) break;

						}

						//exit;

					}

				}	

				

				$this->_data['error']=array($sfmessage);



			}



			//Grab contacts



			else if($rtype=="c") {				



			



				if(isset($this->_data['importMode'])) {



					$cntIds=$this->input->post('recids');			



					if(!$cntIds) {



						$this->_data['error']=array("Contacts not selected");



						return;



					}



					//Get selected contacts



					$sContacts=$client->retrieve("Id,Salutation,FirstName,LastName,AccountId,Title, Department,Birthdate,Phone,MobilePhone,OtherPhone,LeadSource,Email,AssistantName,AssistantPhone,MailingStreet,MailingCity,MailingState,MailingCountry,MailingPostalCode,Description","Contact",$cntIds);



					//echo "<pre>";print_r($sContacts);echo "</pre>";



					if($sContacts) {



						foreach($sContacts as $record) {



							$Irow = $record->fields;



							$Irow->ID=$record->Id;



							if(isset($Irow->AccountId) && $Irow->AccountId) 



							{



								$ARecord=$client->retrieve("Id,Name,BillingCity,BillingCountry,BillingPostalCode,BillingState,BillingStreet,Phone,Fax,Website","Account",array($Irow->AccountId));



								if($ARecord) {



									$Irow->Account=$ARecord[0]->fields;



									$Irow->Account->ID=$ARecord[0]->Id;



								}



							}



							//Notes



							$query2 = "SELECT Id,Title,Body,IsPrivate from Note WHERE ParentId='{$record->Id}'";



							$response2 = $client->query($query2);



							$queryResult2 = new QueryResult($response2);



							for ($queryResult2->rewind(); $queryResult2->pointer < $queryResult2->size; $queryResult2->next()) {



								$record2 = $queryResult2->current();



								$temp = $record2->fields;



								$temp->ID = $record2->Id;



								$Irow->Notes[]=$temp;



								//echo "<pre>";print_r($record2);echo "</pre>";



							}



							//Tasks



							$query2 = "SELECT Id,Subject,Status,Priority,Description,ActivityDate from Task WHERE WhoId='{$record->Id}'";



							$response2 = $client->query($query2);



							$queryResult2 = new QueryResult($response2);



							for ($queryResult2->rewind(); $queryResult2->pointer < $queryResult2->size; $queryResult2->next()) {



								$record2 = $queryResult2->current();



								$temp = $record2->fields;



								$temp->ID = $record2->Id;



								$Irow->Tasks[]=$temp;



								//echo "<pre>";print_r($record2);echo "</pre>";



							}



							$contact_Records[] = $Irow;



						}



					}



					//echo "<pre>";print_r($contact_Records);echo "</pre>";exit;



				} else {



					//Get all contacts



					$query = "SELECT Id,FirstName,LastName,Phone,Email from Contact";



					$response = $client->query($query);



					$queryResult = new QueryResult($response);



					



					$contact_Records = array();



					for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {



						$record = $queryResult->current();



						$Irow = $record->fields;



						$Irow->ID=$record->Id;



						$contact_Records[] = $Irow;



						//break;



					}



				}



				$Salesforce_Records=$contact_Records;



				



			}//End of Contacts grabing



			



			//Grab accounts



			else if($rtype=="a") {



				$account_Records = array();



				if(isset($this->_data['importMode'])) {



					$cntIds=$this->input->post('recids');			



					if(!$cntIds) {



						$this->_data['error']=array("Accounts not selected");



						return;



					}



					//Get selected accounts



					$sRecords=$client->retrieve("Id,Name,AccountNumber,Site,Type,Industry,AnnualRevenue,Rating,



						Phone,Fax,Website,TickerSymbol,Ownership,NumberOfEmployees,Sic,



						BillingCity,BillingCountry,BillingPostalCode,BillingState,BillingStreet,



						ShippingCity,ShippingCountry,ShippingPostalCode,ShippingState,ShippingStreet,Description","Account",$cntIds);



					if($sRecords) {



						foreach($sRecords as $record) {



							$Irow = $record->fields;



							$Irow->ID=$record->Id;



							//Notes



							$query2 = "SELECT Id,Title,Body,IsPrivate from Note WHERE ParentId='{$record->Id}'";



							$response2 = $client->query($query2);



							$queryResult2 = new QueryResult($response2);



							for ($queryResult2->rewind(); $queryResult2->pointer < $queryResult2->size; $queryResult2->next()) {



								$record2 = $queryResult2->current();



								$temp = $record2->fields;



								$temp->ID = $record2->Id;



								$Irow->Notes[]=$temp;



								//echo "<pre>";print_r($record2);echo "</pre>";



							}



							$account_Records[] = $Irow;							



						}



					}



					



				} else {



					//Get all accounts



					$query = "SELECT Id,Name,BillingCity,Phone from Account";



					$response = $client->query($query);



					$queryResult = new QueryResult($response);					



					



					for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {



						$record = $queryResult->current();



						$Irow = $record->fields;



						$Irow->ID=$record->Id;



						$account_Records[] = $Irow;



					}				



				}				



				$Salesforce_Records=$account_Records;				



			}//End of accounts grabing



			//echo "<pre>";print_r($contact_Records);echo "</pre>";exit;



			



			$this->_data['Salesforce_Records']=$Salesforce_Records;



		



		



		} catch (Exception $e) {



			//$this->_data['error']=array($e->faultstring);



			/*echo "Exception ".$e->faultstring."<br/><br/>\n";



			echo "Last Request:<br/><br/>\n";



			echo $client->getLastRequestHeaders();



			echo "<br/><br/>\n";



			echo $client->getLastRequest();



			echo "<br/><br/>\n";



			echo "Last Response:<br/><br/>\n";



			echo $client->getLastResponseHeaders();



			echo "<br/><br/>\n";



			echo $client->getLastResponse();*/



		}//echo "YES";exit;



		//exit;



	}



	



	//Interaction Objects



	function objections($pam=NULL) {



		$this->_data['crmlite'] = "objection";



		$breadcrumbs[] = array('label'=>'Objections','url'=>base_url('crm/objections'));



		//$this->_data['breadcrumbs']=$breadcrumbs;



		//check for existance in crm database



		/*$crmpoints = $this->crm->prospect_user_points(array($this->_user_id),'1=1',1);



		if(!$crmpoints) {



			$this->_data['crmdbuser']=0;



			$this->load->view('crm/objections', $this->_data);	



			return;



		}*/



		$this->_data['crmdbuser']=1;



		if($pam==NULL) {



			$oUsr=0;			



			$oDays='';



		} else {



			$Pam_Arr = explode("-",$pam);



			$oUsr=$Pam_Arr[0];



			$oDays=$Pam_Arr[1];



		}



		$this->_data['oUsr']=$oUsr;



		$this->_data['oDays']=$oDays;



		if($oUsr) $oUsr=array($oUsr);



		else $oUsr=$this->_parent_users;



		//Prospect Users



		//$dwhere = "1=1";



		$shuids = implode(",",$this->_parent_users);



		$dwhere = "u.user_id in ($shuids)";



		$prospect_users = $this->crm->prospect_users($dwhere);



		$this->_data['prospect_points'] = $prospect_users;



		//objection chart		



		//old



		/*$Objections = $this->crm->get_objections('',$oUsr);



		$chartData=array();



		$chartData[] = array('Objection', 'Usage');



		if($Objections) {



			foreach($Objections as $obj) $chartData[] = array($obj->obj_val, round($obj->obj_count));



		}*/



		//new



		//Date Range

		$all=1;

		$cf = $oDays;



		$tDt1 = date("Y-m-d");



		$tDt2 = date("Y-m-d");



		$dtF = "j-M";



		if($cf==1) {$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M";}



		else if($cf==2) {$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}



		else if($cf==3){$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}



		else if($cf==4){



			$dtF = "j-M";



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2));



		} else if($cf==5){



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2)-3*30*24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt1));



		} else if($cf==6){



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2)-6*30*24*60*60);



		} else if($cf==7){



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2)-12*30*24*60*60);



		} else if($cf=='0'){$tDt1 = date("Y-m-d");$dtF = "j-M-Y";$cf=0;}

		else  $all=0;



		//$dwhere = "(obc.objdate BETWEEN '$tDt1' AND '$tDt2') and obc.objid>0";

		$dwhere = " obc.objid>0 ";

		if($all==1) $dwhere .= " and (obc.objdate BETWEEN '$tDt1' AND '$tDt2') "; 



		$Objections = $this->crm->get_objections_byfilters($oUsr,$dwhere);



		$chartData=array();



		$chartData[] = array('Objection', 'Usage');



		if($Objections) {



			foreach($Objections as $obj) $chartData[] = array($obj->obj_val, round($obj->obj_count));



		}



		



		$this->_data['chartData']=json_encode($chartData);



		//Campaign dropdowns adding



		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();



		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();



		$this->_data['drop_company'] = $this->campaign->get_drop_company();



		$this->load->view('crm/objections', $this->_data);	



	}



	//Prospect Points



	function prospect($pam = NULL)



	{



		$this->_data['crmlite'] = "prospect";



		$breadcrumbs[] = array('label'=>'Prospect Points','url'=>base_url('crm/prospect'));



		//$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['crmdbuser']=1;



		if($pam==NULL) {



			$oUsr=0;



			$oDays=3;



			$oCat=0;



		} else {



			$Pam_Arr = explode("-",$pam);



			$oUsr=$Pam_Arr[0];



			$oDays=$Pam_Arr[1];



			$oCat=$Pam_Arr[2];



		}



		$this->_data['oUsr']=$oUsr;



		$this->_data['oDays']=$oDays;



		$this->_data['oCat']=$oCat;



		//Date Range



		if(!$oDays) $oDays=1;



		$cf = (int)$oDays;



		$tDt1 = date("Y-m-d");



		$tDt2 = date("Y-m-d");



		$dtF = "j-M";



		if($cf==1) {$tDt1 = date("Y-m-d");$dtF = "j-M-Y";$cf=0;}



		else if($cf==2) {$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M";}



		else if($cf==3) {$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}



		else if($cf==4){$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}



		else if($cf==5){



			$dtF = "j-M";



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2));



		} else if($cf==6){



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2)-3*30*24*60*60);



		} else if($cf==7){



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2)-6*30*24*60*60);



		} else if($cf==8){



			$tDt1 = date("Y-m-01",strtotime($tDt1));



			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);



			$tDt1 = date("Y-m-01",strtotime($tDt2)-12*30*24*60*60);



		}



		//Interaction categories



		$this->load->helper('scripts');



		//$categories = crm_options();

		$categories = crm_introptions();



		$this->_data['categories'] = $categories;



		//All users



		$this->_data['dropdown_users'] = $this->crm->get_all_shared_users($this->_parent_users_all);



		$shuids = implode(",",$this->_parent_users_all);



		$dwhere = "u.user_id in ($shuids)";



		



		//Prospect users with date range



		$dwhere2 = "u.user_id in ($shuids)";



		$dwhere2 .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";



		if($oCat) $dwhere2 .= " and cat=$oCat";



		$datebase_prospect_users = $this->crm->prospect_users($dwhere2);



		$prospect_points = array();



		foreach($datebase_prospect_users as $prosp) $prospect_points[$prosp->user_id]=array($prosp->ipt,$prosp->ppt);		



		$this->_data['prospect_users'] = $prospect_points;



		



		//Prospect Users		



		$dwhere = "u.user_id in ($shuids)";



		if($oUsr) $dwhere = "u.user_id=$oUsr";



		if($oCat) $dwhere .= " and cat=$oCat";



		$prospect_users = $this->crm->prospect_users($dwhere);



		$rFormat1 = array('');



		$rFormat2 = array_fill(1, count($prospect_users), 0);



		$rFormat=array_merge($rFormat1,$rFormat2);



		$chartData1=array();//Quality Points



		$chartData2=array();//Pursuit Points



		if($oDays==0) {



			$ctemp = $rFormat;



			$ctemp[0]="";



			$chartData1[]= $ctemp;



			$chartData2[]= $ctemp;



			$ctemp = array('');



			$ctemp2 = array('');



			foreach($prospect_users as $pUsr) {



				$ctemp[] = round($pUsr->ipt);



				$ctemp2[] = round($pUsr->ppt);



			}



			$chartData1[]= $ctemp;



			$chartData2[]= $ctemp2;



		}		



		



		//foreach($n=1;$n<=count($prospect_users);$n++) $rFormat[]=0;



		//Points gained usres



		$dwhere = "u.user_id in ($shuids)";



		if($oUsr) $dwhere = "u.user_id=$oUsr";





		if($oDays) $dwhere .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";



		if($oCat) $dwhere .= " and cat=$oCat";



		



		//$dwhere = "(pdate>='$tDt1' AND pdate<'$tDt2')";



		$prospect_users2 = $this->crm->prospect_users($dwhere);		



		



		//Line Chart



		//Chart Users



		$pUsers = array();



		$pUsersPoints = array();



		$Search = array(",",'"');



		$Replace = array("","");		



		foreach($prospect_users2 as $pUsr) {



			$pname = str_replace($Search,$Replace,$pUsr->usrname);



			$pUsers[$pUsr->user_id]=ucfirst($pname);



			$pUsersPoints[$pUsr->user_id]=array($pUsr->ipt,$pUsr->ppt);			



		}



		$dwhere = "(pdate BETWEEN '$tDt1' AND '$tDt2')";



		if($oCat) $dwhere .= " and cat=$oCat";



		//User Points		



		$tDt1 = strtotime($tDt1);



		$tDt2 = strtotime($tDt2);



		if($pUsers && $oDays) {



			//$UserIds=array_keys($pUsers);



			$UserIds=$this->_parent_users;



			if($oUsr) $UserIds=array($oUsr);



			else {



				$UserIds = array();



				foreach($this->_data['dropdown_users'] as $usr) $UserIds[] = $usr->user_id;



			}



			$UsrDatePoints=array();



			//['Day 1', 0, 0]



			//$chartData[] = array('Day', $y1, $y2);



			



			$dates = array();



			$di=-1;



			$cInd=-1;



			////COMMENTED

			////$user_points = $this->crm->prospect_user_points($UserIds,$dwhere);	

			$user_points = $this->crm->prospect_user_points_one($UserIds,$dwhere);		



			foreach($user_points as $uPoints) {



				while($tDt1<strtotime($uPoints->pdate)){



					$ctemp = $rFormat;



					$ctemp[0]= date($dtF,$tDt1);



					$di++;



					$ckey=$di;



					$chartData1[$ckey]= $ctemp;



					$chartData2[$ckey]= $ctemp;					



					$tDt1 = $tDt1+24*60*60;



				}



				$tDt1=strtotime($uPoints->pdate);



				$cDt = date($dtF,strtotime($uPoints->pdate));				



				if(array_search($cDt,$dates)===FALSE) {



					$di++;



					$ckey=$di;



					$dates[$di]=$cDt;



					$ctemp = $rFormat;



					$ctemp[0]= $cDt;



					$ctemp2 = $rFormat;



					$ctemp2[0]= $cDt;



				} else {



					$ckey=array_search($cDt,$dates);



					$ctemp = $chartData1[$ckey];



					$ctemp2 = $chartData2[$ckey];



				}



				////COMMENTED

				/*

				//$cInd=array_search($uPoints->userid,$UserIds)+1;

				$cInd=1;

				*/



				//User points on that date

				$user_date_points = $this->crm->prospect_user_points_two($UserIds,$uPoints->pdate);

				if($user_date_points) {

					foreach ($user_date_points as $datps) {

						$cInd=array_search($datps->userid,$UserIds)+1;

						$ctemp[$cInd] += $datps->intpoints;

						$ctemp2[$cInd] += $datps->purpoints;		

					}

				}



				////COMMENTED

				/*

				$ctemp[$cInd] += $uPoints->intpoints;

				$ctemp2[$cInd] += $uPoints->purpoints;

				*/



				$chartData1[$ckey]= $ctemp;



				$chartData2[$ckey]= $ctemp2;



				$tDt1 = $tDt1+24*60*60;



			}			



		}



		if($cf) {



			while($tDt1<=$tDt2){



				$ctemp = $rFormat;



				$ctemp[0]= date($dtF,$tDt1);



				$di++;



				$ckey=$di;



				$chartData1[$ckey]= $ctemp;



				$chartData2[$ckey]= $ctemp;					



				$tDt1 = $tDt1+24*60*60;



			}



		}



		$chartData1 = array_values($chartData1);



		$chartData2 = array_values($chartData2);



		//If there is no entries points table then list all users



		if(count($prospect_users)==0) {



			$prospect_users=$this->_data['dropdown_users'];



			$chartData1 = array();



			$chartData2 = array();



		}



		$this->_data['prospect_points'] = $prospect_users;



		$this->_data['chartUserPoints'] = $pUsersPoints;



		$this->_data['chartData1'] = json_encode($chartData1);



		$this->_data['chartData2'] = json_encode($chartData2);



		$this->load->view('crm/prospect-points', $this->_data);



	}



	



	//Advanced Search 



	public function search($action = NULL) {



		if ($this->input->is_ajax_request()) {

		   //Add Records to List

		   $this->add_search_Records_to_List();

		}



		$this->_data['crmlite'] = "crm";



		$breadcrumbs[] = array('label'=>'Advanced Search','url'=>base_url('crm/search'));



		$this->_data['breadcrumbs']=$breadcrumbs;



		//custom



		$record = $this->crm->get_contact($id,$this->_parent_users);







		//Feild based search



		//1 - text , 2 - number



		$contact_fields = array(



				array('user_first','Name',1), 



				array('user_title','Title',1), 



				array('department','Department',1), 



				array('birthdate','Birthdate',1), 



				array('lead_source','Lead Source',1), 



				array('email','Email',1), 

				

				array('description','Description',1),



				array('amail_street','Mailing Street',1) , 



				array('amail_city','Mailing City',1) , 



				array('amail_state','Mailing State/Province',1) , 



				array('amail_zipcode','Mailing Zip/Postal Code',1) , 



				array('amail_country','Mailing Country',1) 



			);



		$account_fields = array(



				array('account_name','Account Name',1), 



				array('industry','Industry',1), 



				array('account_type','Type',1), 



				array('revenue','Annual Revenue',2), 



				array('employees','Employees',2), 



				array('siccode','SIC Code',1), 

				

				array('description','Description',1),



				array('billing_street','Billing Street',1) , 



				array('billing_city','Billing City',1) , 



				array('billing_state','Billing State/Province',1) , 



				array('billing_zipcode','Billing Zip/Postal Code',1) , 



				array('billing_country','Billing Country',1), 



				array('shipping_street','Shipping Street',1) , 



				array('shipping_city','Shipping City',1) , 



				array('shipping_state','Shipping State/Province',1) , 



				array('shipping_zipcode','Shipping Zip/Postal Code',1) , 



				array('shipping_country','Shipping Country',1) 



			);

			

			

			$task_fields = array(

			

				array('task_subject','Subject',1), 



				array('task_status','Status',1), 



				array('task_duedate','Due Date',1), 



				array('task_related','Related To',1), 

				

				array('task_phone','Phone',1),

				

				array('task_email','Email',1),

				

				array('task_created','Created Date',1),



				array('task_modified','Modified Date',1) 

			);



		if($this->_data['custom']) {



			$cNum = $this->_data['customNum'];



			foreach($this->_data['custom'] as $ck=>$cv) {

			

			   if (!empty($cNum)) {



					$numeric_field = in_array($ck,$cNum)!==FALSE?2:1;

	

					$contact_fields[] = array('custom_'.$ck,$cv,$numeric_field);

				

				}

				

				else

				{

					$contact_fields[] = array('custom_'.$ck,$cv,1);

				}

				

			}



		}



		$this->_data['contact_fields']=$contact_fields;



		if($this->_data['customa']) {



			$cNum = $this->_data['customNuma'];



			foreach($this->_data['customa'] as $ck=>$cv) {



				$numeric_field = in_array($ck,$cNum)!==FALSE?2:1;

				

				if (!empty($cNum)) {



					$numeric_field = in_array($ck,$cNum)!==FALSE?2:1;

	

					$account_fields[] = array('custom_'.$ck,$cv,$numeric_field);

				

				}

				

				else

				{

					$account_fields[] = array('custom_'.$ck,$cv,1);

				}



			}



		}



		$this->_data['account_fields']=$account_fields;



		$this->_data['task_fields']=$task_fields;



		//search



		$record=array();



		if($this->input->post('action')=="search") {



		//error_reporting(E_ALL);



			$record=$this->input->post('record');



			$contact = $record['contact'];



			$amail = $contact['amail'];



			unset($contact['amail']);



			//field search



			$contactSearch = array();



			if($contact['colftype']) {



				$contactSearch['colftype'] = $contact['colftype'];



				$contactSearch['colsearch'] = $contact['colsearch'];



				$contactSearch['colstype'] = $contact['colstype'];



				$contactSearch['colsfield1'] = $contact['colsfield1'];



				$contactSearch['colsfield2'] = $contact['colsfield2'];



				$contactSearch = array_filter($contactSearch);



			}



			unset($contact['colftype']);



			unset($contact['colsearch']);



			unset($contact['colstype']);



			unset($contact['colsfield1']);



			unset($contact['colsfield2']);







			$account = $record['account'];



			//field search



			$accountSearch = array();



			if($account['colftype']) {



				$accountSearch['colftype'] = $account['colftype'];



				$accountSearch['colsearch'] = $account['colsearch'];



				$accountSearch['colstype'] = $account['colstype'];



				$accountSearch['colsfield1'] = $account['colsfield1'];



				$accountSearch['colsfield2'] = $account['colsfield2'];



				$accountSearch = array_filter($accountSearch);



			}



			unset($account['colftype']);



			unset($account['colsearch']);



			unset($account['colstype']);



			unset($account['colsfield1']);



			unset($account['colsfield2']);

			

			

			

			$task = $record['task'];



			//field search



			$taskSearch = array();



			if($task['colftype']) {



				$taskSearch['colftype'] = $task['colftype'];



				$taskSearch['colsearch'] = $task['colsearch'];



				$taskSearch['colstype'] = $task['colstype'];



				$taskSearch['colsfield1'] = $task['colsfield1'];



				$taskSearch['colsfield2'] = $task['colsfield2'];



				$taskSearch = array_filter($taskSearch);



			}



			unset($task['colftype']);



			unset($task['colsearch']);



			unset($task['colstype']);



			unset($task['colsfield1']);



			unset($task['colsfield2']);









			$billing = $account['billing'];



			unset($account['billing']);



			$shipping = $account['shipping'];



			unset($account['shipping']);



			



			//custom fields



			$Ccustom = $contact['Ccustom'];



			unset($contact['Ccustom']);



			$Acustom = $account['Acustom'];



			unset($account['Acustom']);



			



			$contact = array_filter($contact);



			$amail = array_filter($amail);



			$account = array_filter($account);



			$billing = array_filter($billing);



			$shipping = array_filter($shipping);



			



			$Ccustom = array_filter($Ccustom);



			$Acustom = array_filter($Acustom);



			



			$er = array();



			if(!$contact && !$amail && !$contactSearch && !$account && !$billing && !$shipping && !$accountSearch && !$Ccustom && !$Acustom && !$taskSearch) $er['error']="Enter search key";



			else {			



				//Contact





				$search_listc = array();

				$search_lista = array();

				$search_listt = array();



				//Field search



				if($contactSearch && isset($contactSearch['colsearch']) && (strstr($contactSearch['colsearch'],'amail_')===FALSE && strstr($contactSearch['colsearch'],'custom_')===FALSE)) {					



					$contact[$contactSearch['colsearch']] = $contactSearch['colsfield1'];



				}



				if($contact) {



					$record['contact']=$contact;



					foreach($contact as $ci=>$cval) {



						if($ci=="user_first") $contact['user_last']=$cval;



						else if($ci=="birthdate") {



							$tmpdate = explode("/",$cval);//m/d/y-012



							$contact['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



						}



					}



					$contacts = $this->crm->contact_search($contact,$this->_parent_users);



					if($contacts) $search_listc = array_merge($search_listc,$contacts);



				}



				//Address



				if($contactSearch && isset($contactSearch['colsearch']) && strstr($contactSearch['colsearch'],'amail_')!==FALSE) {



					$amail_str = str_replace('amail_', '', $contactSearch['colsearch']);



					$amail[$amail_str] = $contactSearch['colsfield1'];



				}



				if($amail) {



					$record['contact']['amail']=$amail;



					//error_reporting(E_ALL);



					$contacts = $this->crm->address_search($amail,'amail','C',$this->_parent_users);



					if($contacts) $search_listc = array_merge($search_listc,$contacts);



				}



				//Account



				//Field search



				if($accountSearch && isset($accountSearch['colsearch']) && (strstr($accountSearch['colsearch'],'billing_')===FALSE && strstr($accountSearch['colsearch'],'shipping_')===FALSE && strstr($accountSearch['colsearch'],'custom_')===FALSE)) {

					//numeric fields

					if($accountSearch['colsearch']=='revenue' || $accountSearch['colsearch']=='employees') {						



						$acol = $accountSearch['colsearch'];



						$acolval1 = (float)str_replace(",","",$accountSearch['colsfield1']);



						$acolval2 = (float)str_replace(",","",$accountSearch['colsfield2']);



						$atmp = '';



						if($accountSearch['colstype']==1) $atmp = "REPLACE(a.$acol,',','')<$acolval1";



						else if($accountSearch['colstype']==2) $atmp = "REPLACE(a.$acol,',','')>$acolval1";



						else if($accountSearch['colstype']==3) $atmp = "(REPLACE(a.$acol,',','')>=$acolval1 AND REPLACE(a.$acol,',','')<=$acolval2)";

						else $atmp = "REPLACE(a.$acol,',','')=$acolval1";



						$account[$accountSearch['colsearch']] = array($atmp);						



					} else  



						$account[$accountSearch['colsearch']] = $accountSearch['colsfield1'];	



				}



				if($account) {



					$record['account']=$account;



					/*foreach($account as $ai=>$aval) {



						if($ai=="revenue" || $ai=="employees") unset($account[$ai]);



					}*/



					if($account['revenue']) {



						if(!is_array($account['revenue'])) $account['revenue'] = (float)str_replace(",","",$account['revenue']);



					}



					if($account['employees']) {



						if(!is_array($account['employees'])) $account['employees'] = (int)str_replace(",","",$account['employees']);



					}



					$accounts = $this->crm->account_search($account,$this->_parent_users);



					if($accounts) $search_lista = array_merge($search_lista,$accounts);



				}



				//Address



				if($accountSearch && isset($accountSearch['colsearch']) && strstr($accountSearch['colsearch'],'billing_')!==FALSE) {



					$amail_str = str_replace('billing_', '', $accountSearch['colsearch']);



					$billing[$amail_str] = $accountSearch['colsfield1'];



				}



				if($billing) {



					$record['account']['billing']=$billing;



					$accounts = $this->crm->address_search($billing,'billing','A',$this->_parent_users);



					if($accounts) $search_lista = array_merge($search_lista,$accounts);



				}



				if($accountSearch && isset($accountSearch['colsearch']) && strstr($accountSearch['colsearch'],'shipping_')!==FALSE) {



					$amail_str = str_replace('shipping_', '', $accountSearch['colsearch']);



					$shipping[$amail_str] = $accountSearch['colsfield1'];



				}	



				if($shipping) {



					$record['account']['shipping']=$shipping;



					$accounts = $this->crm->address_search($shipping,'shipping','A',$this->_parent_users);



					if($accounts) $search_lista = array_merge($search_lista,$accounts);



				}

				

				

				

				//TASK

				

				if($taskSearch && isset($taskSearch['colsearch'])) {					



					$task[$taskSearch['colsearch']] = $taskSearch['colsfield1'];

			

				}

			

				if($task) {

			

					$record['task']=$task;

			

					foreach($task as $ci=>$cval) {	

			

						if($ci=="task_duedate") {

			

							$tmpdate = explode("/",$cval);//m/d/y-012

			

							$task['task_duedate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201

			

						}

						

						if($ci=="task_created") {

			

							$tmpdate = explode("/",$cval);//m/d/y-012

			

							$task['task_created']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201

			

						}

						

						if($ci=="task_modified") {

			

							$tmpdate = explode("/",$cval);//m/d/y-012

			

							$task['task_modified']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201

			

						}



			

					}

			

					$tasks = $this->crm->task_search($task,$this->_parent_users);

			

					if($tasks) $search_listt = array_merge($search_listt,$tasks);

					

					//echo '<pre>'; print_r($search_listt); echo '</pre>';

			

				}		

				

				



				//Ccustom field



				$contact_customs = array();



				if($contactSearch && isset($contactSearch['colsearch']) && strstr($contactSearch['colsearch'],'custom_')!==FALSE) {



					$amail_str = str_replace('custom_', '', $contactSearch['colsearch']);



					if(in_array($amail_str,$this->_data['customNum'])!==FALSE) {



						$acolval1 = (float)str_replace(",","",$contactSearch['colsfield1']);



						$acolval2 = (float)str_replace(",","",$contactSearch['colsfield2']);



						$contact_customs[] = $amail_str;



						$atmp = '';



						if($contactSearch['colstype']==1) $atmp = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))<".$acolval1;



						else if($contactSearch['colstype']==2) $atmp = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))>".$acolval1;



						else if($contactSearch['colstype']==3) $atmp = "(cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))>=".$acolval1." AND cast(



							REPLACE(ad.cval,',','') as DECIMAL(11,4))<=".$acolval2.")";



						else $atmp = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))=".$acolval1;



						$Cval=array($amail_str,$atmp);



						$contacts = $this->crm->custom_search($Cval,'C',$this->_parent_users,1);



						if($contacts) $search_listc = array_merge($search_listc,$contacts);



					} else $Ccustom[$amail_str] = $contactSearch['colsfield1'];					



				}



				//Contact custom

				if($Ccustom) {



					$record['contact']['Ccustom']=$Ccustom;



					foreach($Ccustom as $ai=>$aval) {



						if(in_array($ai,$contact_customs)!==FALSE) continue;



						//$accounts = $this->crm->account_search($account,$this->_parent_users);



						$Cval=array($ai,$aval);



						if(in_array($ai,$this->_data['customNum'])!==FALSE) {



							$aval2 = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))=".(float)str_replace(",","",$aval);



							$Cval=array($ai,$aval2);



							$contacts = $this->crm->custom_search($Cval,'C',$this->_parent_users,1);



						}



						else $contacts = $this->crm->custom_search($Cval,'C',$this->_parent_users);



						if($contacts) $search_listc = array_merge($search_listc,$contacts);



					}										



				}



				



				//Acustom field



				$account_customs = array();



				if($accountSearch && isset($accountSearch['colsearch']) && strstr($accountSearch['colsearch'],'custom_')!==FALSE) {



					$amail_str = str_replace('custom_', '', $accountSearch['colsearch']);					



					if(in_array($amail_str,$this->_data['customNuma'])!==FALSE) {



						$acolval1 = (float)str_replace(",","",$accountSearch['colsfield1']);



						$acolval2 = (float)str_replace(",","",$accountSearch['colsfield2']);



						$contact_customs[] = $amail_str;



						$atmp = '';



						if($accountSearch['colstype']==1) $atmp = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))<".$acolval1;



						else if($accountSearch['colstype']==2) $atmp = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))>".$acolval1;



						else if($accountSearch['colstype']==3) $atmp = "(cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))>=".$acolval1." AND cast(



							REPLACE(ad.cval,',','') as DECIMAL(11,4))<=".$acolval2.")";



						else $atmp = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))=".$acolval1;



						$Cval=array($amail_str,$atmp);



						$accounts = $this->crm->custom_search($Cval,'A',$this->_parent_users,1);



						if($accounts) $search_lista = array_merge($search_lista,$accounts);



					} else $Acustom[$amail_str] = $accountSearch['colsfield1'];



				}



				if($Acustom) {



					$record['account']['Acustom']=$Acustom;



					foreach($Acustom as $ai=>$aval) {



						if(in_array($ai,$account_customs)!==FALSE) continue;



						//$accounts = $this->crm->account_search($account,$this->_parent_users);



						$Cval=array($ai,$aval);



						if(in_array($ai,$this->_data['customNuma'])!==FALSE) {



							$aval2 = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))=".(float)str_replace(",","",$aval);



							$Cval=array($ai,$aval2);



							$accounts = $this->crm->custom_search($Cval,'A',$this->_parent_users,1);



						}



						else $accounts= $this->crm->custom_search($Cval,'A',$this->_parent_users);



						if($accounts) $search_lista = array_merge($search_lista,$accounts);						



					}					



				}



				



					



				if(!$search_listc && !$search_lista && !$search_listt) $er['error']="No matching records found";



			}		



			$this->_data['er']=$er;



		}



		//echo "<pre>";



		//echo "record";print_r($record);echo "contact";print_r($contact);echo "amail";print_r($amail);echo "account";print_r($account);echo "billing";print_r($billing);echo "shipping";print_r($shipping);



		//echo "search_list";print_r($search_list);echo "</pre>";



		$this->_data['record']=$record;



		$this->_data['search_listc']=$search_listc;

		$this->_data['search_lista']=$search_lista;

		$this->_data['search_listt']=$search_listt;

		$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));

		$this->_data['catlist2'] = $this->crm->get_all_catlist(array('section'=>2));



		$this->load->view('crm/search', $this->_data);



	}



	//Reporting

	function report($action = NULL)



	{



		$this->_data['crmlite'] = "report";



		$pam3 = $action;



		$breadcrumbs = array();



		$breadcrumbs[] = array('label'=>'Activity Reports','url'=>base_url('crm/report'),'single'=>'Y');



		$breadcrumbs[] = array('label'=>'Email Reports','url'=>base_url('crm/ereport'),'single'=>'N');



		$shared_users = $this->crm->get_all_shared_users($this->_parent_users);



		$this->_data['shared_users'] = $shared_users;



		$this->load->helper('scripts');



		//$categories = crm_options();

		$categories = crm_introptions();



		$record=array();



		$this->_data['categories'] = $categories;



		if($this->input->post('action')=="report") {



			$record=$this->input->post('record');



			//echo "<pre>";print_r($record);echo "</pre>";exit;



			$catg = 0;



			$er = array();



			/*if(empty($record['user'])) $er['user']="User required";



			if(empty($record['cat'])) $er['cat']="Category required";



			else $catg=(int)$record['cat'];*/

			$catg = 1;



			if(empty($record['ifdate'])) $er['ifdate']="From date required";



			if(empty($record['itdate'])) $er['itdate']="To date required";



			if($record['ifdate'] && $record['itdate']) {



				$dt = explode("/",$record['ifdate']);//m/d/y-012



				$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201



				$dt = explode("/",$record['itdate']);//m/d/y-012



				$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201



				if(strtotime($ifdate)>strtotime($itdate)) $er['itdate']="End date should be after from date";



			}



			//validate by section notes



			$notes = '';



			$points = 0;



			$pursuit = 0;



			$objection = "";



			$objections = array();



			//Track Interactions



			$interactions = array();



			//echo "<pre>";print_r($record);echo "</pre>";



			//echo "<pre>";						



			if($catg) {		



				/*$category = $categories[$catg];



				$sections = $category['sections'];		*/



				//Cheched Options



				$options = array();



				$sopts = array();



				if($record['opt']) {



					foreach($record['opt'] as $si=>$soptlist) {



						$chkval = $si;//1n1 <cat>n<sect>



						$chkval = explode("n",$chkval);//cat-sect

						$catg = $chkval[0];

						$section = $chkval[1];



						//$sect = $sections[$section]['options'];

						if($section==1) $sect = $categories['category'][$chkval[0]][1]['options'];

						else $sect = $categories['sections'][$chkval[1]]['options'];





						foreach($soptlist as $oi=>$oval) {



							if($oval=="O") {



								$objId = $record['opto_id'.$catg][$oi];



								$sno=$catg.'-'.$section.'-O'.$objId;



								$options[$sno] = array('c'=>$catg,'s'=>$section,'o'=>$objId,'i'=>'O','v'=>$record['opto_txt'.$catg][$oi]);



								$sopts[] = $catg.'-'.$section.'-O'.$objId;



							} else {



								$sno=$catg.'-'.$section.'-'.$oval;



								$options[$sno] = array('c'=>$catg,'s'=>$section,'o'=>$oval,'i'=>'I','v'=>$sect[$oval]['label']);



								$sopts[] = $catg.'-'.$section.'-'.$oval;



							}



						}



					}



				}







				if(count($options)==0) $er['options']="please check options";



			}



			//Error sending



			if($er) {



				$response = implode("\n",$er);



				echo "ERROR@".json_encode($response);



				exit;



			}	

			$suser = $record['user'];

			if(!$suser) $suser = $this->_parent_users;



			//Line chart Preparation			



			$dtwhere = "(intr_date BETWEEN '$ifdate' AND '$itdate')";



			$ilist = $this->crm->get_interaction_counts($suser,$dtwhere,$sopts);



			$intr_labels = array();



			$chartData=array();



			$chart=0;



			if($ilist) {



				//List labels



				foreach($ilist as $ival) {



					$intr_labels[$ival->intr_sno] = $options[$ival->intr_sno]['v'];



				}



				$intr_label_keys = array_keys($intr_labels);



				$rFormat1 = array('');



				$rFormat2 = array_fill(1, count($ilist), 0);



				$rFormat=array_merge($rFormat1,$rFormat2);



				$idtrows = $this->crm->get_interaction_date_counts($suser,$dtwhere,$sopts);



				$tDt1 = strtotime($ifdate);



				$tDt2 = strtotime($itdate);



				$dtF = "j-M";



				$dates = array();



				$di=-1;



				$cInd=-1;



				foreach($idtrows as $irow) {



					while($tDt1<strtotime($irow->intr_date)){



						$ctemp = $rFormat;



						$ctemp[0]= date($dtF,$tDt1);



						$di++;



						$ckey=$di;



						$chartData[$ckey]= $ctemp;				



						$tDt1 = $tDt1+24*60*60;



					}



					$tDt1=strtotime($irow->intr_date);



					$cDt = date($dtF,strtotime($irow->intr_date));



					if(array_search($cDt,$dates)===FALSE) {



						$di++;



						$ckey=$di;



						$dates[$di]=$cDt;



						$ctemp = $rFormat;



						$ctemp[0]= $cDt;



					} else {



						$ckey=array_search($cDt,$dates);



						$ctemp = $chartData[$ckey];



					}



					$cInd=array_search($irow->intr_sno,$intr_label_keys)+1;



					$ctemp[$cInd] += $irow->intr_count;



					//$ctemp[$cInd+1]= "<p><b>".$cDt.": ".$ctemp[$cInd]."</b></p><p>".$pUsers[$uPoints->userid]."</p><p>Quality Points: ".$dtTemp[0]."</p><p>Pursuit Points:".$dtTemp[1]."</p>";



					$chartData[$ckey]= $ctemp;



					//$UsrDatePoints[$dtIndex]=$dtTemp;



					//$chartData[$pi]= array($cDt,$uPoints->intpoints+$uPoints->purpoints);



					$tDt1 = $tDt1+24*60*60;					



				}



				while($tDt1<=$tDt2){



					$ctemp = $rFormat;



					$ctemp[0]= date($dtF,$tDt1);



					$di++;



					$ckey=$di;



					$chartData[$ckey]= $ctemp;



					$tDt1 = $tDt1+24*60*60;



				}



				$chart=1;



				$intr_labels = array_values($intr_labels);



			} else {



				$intr_labels[]="No Interactions";



			}



			$response = array("labels"=>$intr_labels,"cdata"=>$chartData,'lchart'=>$chart);



			echo json_encode($response);



			exit;



		}



		//$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['CustObjections'] = $this->crm->get_objections('Y');



		$this->load->view('crm/reporting-new', $this->_data);



	}



	//Backup

	function report_backu12052017($action = NULL)



	{



		$this->_data['crmlite'] = "report";



		$pam3 = $action;



		$breadcrumbs = array();



		$breadcrumbs[] = array('label'=>'Activity Reports','url'=>base_url('crm/report'),'single'=>'Y');



		$breadcrumbs[] = array('label'=>'Email Reports','url'=>base_url('crm/ereport'),'single'=>'N');



		$shared_users = $this->crm->get_all_shared_users($this->_parent_users);



		$this->_data['shared_users'] = $shared_users;



		$this->load->helper('scripts');



		$categories = crm_options();



		$record=array();



		$this->_data['categories'] = $categories;



		if($this->input->post('action')=="report") {



			$record=$this->input->post('record');



			$catg = 0;



			$er = array();



			if(empty($record['user'])) $er['user']="User required";



			if(empty($record['cat'])) $er['cat']="Category required";



			else $catg=(int)$record['cat'];



			if(empty($record['ifdate'])) $er['ifdate']="From date required";



			if(empty($record['itdate'])) $er['itdate']="To date required";



			if($record['ifdate'] && $record['itdate']) {



				$dt = explode("/",$record['ifdate']);//m/d/y-012



				$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201



				$dt = explode("/",$record['itdate']);//m/d/y-012



				$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201



				if(strtotime($ifdate)>strtotime($itdate)) $er['itdate']="End date should be after from date";



			}



			//validate by section notes



			$notes = '';



			$points = 0;



			$pursuit = 0;



			$objection = "";



			$objections = array();



			//Track Interactions



			$interactions = array();			



			if($catg) {		



				$category = $categories[$catg];



				$sections = $category['sections'];		



				//Cheched Options



				$options = array();



				$sopts = array();



				if($record['opt']) {



					foreach($record['opt'] as $si=>$soptlist) {



						$chkval = $si;//1n1 <cat>n<sect>



						$chkval = explode("n",$chkval);//cat-sect



						$section = $chkval[1];



						$sect = $sections[$section]['options'];



						foreach($soptlist as $oi=>$oval) {



							if($oval=="O") {



								$objId = $record['opto_id'.$catg][$oi];



								$sno=$catg.'-'.$section.'-O'.$objId;



								$options[$sno] = array('c'=>$catg,'s'=>$section,'o'=>$objId,'i'=>'O','v'=>$record['opto_txt'.$catg][$oi]);



								$sopts[] = $catg.'-'.$section.'-O'.$objId;



							} else {



								$sno=$catg.'-'.$section.'-'.$oval;



								$options[$sno] = array('c'=>$catg,'s'=>$section,'o'=>$oval,'i'=>'I','v'=>$sect[$oval]['name']);



								$sopts[] = $catg.'-'.$section.'-'.$oval;



							}



						}



					}



				}



				if(count($options)==0) $er['options']="please check options";



			}



			//Error sending



			if($er) {



				$response = implode("\n",$er);



				echo "ERROR@".json_encode($response);



				exit;



			}	



			//Line chart Preparation			



			$dtwhere = "(intr_date BETWEEN '$ifdate' AND '$itdate')";



			$ilist = $this->crm->get_interaction_counts($record['user'],$dtwhere,$sopts);



			$intr_labels = array();



			$chartData=array();



			$chart=0;



			if($ilist) {



				//List labels



				foreach($ilist as $ival) {



					$intr_labels[$ival->intr_sno] = $options[$ival->intr_sno]['v'];



				}



				$intr_label_keys = array_keys($intr_labels);



				$rFormat1 = array('');



				$rFormat2 = array_fill(1, count($ilist), 0);



				$rFormat=array_merge($rFormat1,$rFormat2);



				$idtrows = $this->crm->get_interaction_date_counts($record['user'],$dtwhere,$sopts);



				$tDt1 = strtotime($ifdate);



				$tDt2 = strtotime($itdate);



				$dtF = "j-M";



				$dates = array();



				$di=-1;



				$cInd=-1;



				foreach($idtrows as $irow) {



					while($tDt1<strtotime($irow->intr_date)){



						$ctemp = $rFormat;



						$ctemp[0]= date($dtF,$tDt1);



						$di++;



						$ckey=$di;



						$chartData[$ckey]= $ctemp;				



						$tDt1 = $tDt1+24*60*60;



					}



					$tDt1=strtotime($irow->intr_date);



					$cDt = date($dtF,strtotime($irow->intr_date));



					if(array_search($cDt,$dates)===FALSE) {



						$di++;



						$ckey=$di;



						$dates[$di]=$cDt;



						$ctemp = $rFormat;



						$ctemp[0]= $cDt;



					} else {



						$ckey=array_search($cDt,$dates);



						$ctemp = $chartData[$ckey];



					}



					$cInd=array_search($irow->intr_sno,$intr_label_keys)+1;



					$ctemp[$cInd] += $irow->intr_count;



					$chartData[$ckey]= $ctemp;



					$tDt1 = $tDt1+24*60*60;					



				}



				while($tDt1<=$tDt2){



					$ctemp = $rFormat;



					$ctemp[0]= date($dtF,$tDt1);



					$di++;



					$ckey=$di;



					$chartData[$ckey]= $ctemp;



					$tDt1 = $tDt1+24*60*60;



				}



				$chart=1;



				$intr_labels = array_values($intr_labels);



			} else {



				$intr_labels[]="No Interactions";



			}



			$response = array("labels"=>$intr_labels,"cdata"=>$chartData,'lchart'=>$chart);



			echo json_encode($response);



			exit;



		}



		$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['CustObjections'] = $this->crm->get_objections('Y');



		$this->load->view('crm/reporting', $this->_data);



	}



	



	



	//Reporting



	function ereport($action = NULL)



	{



		$this->_data['crmlite'] = "report";



		$pam3 = $action;



		$breadcrumbs = array();



		$breadcrumbs[] = array('label'=>'Activity Reports','url'=>base_url('crm/report'),'single'=>'N');



		$breadcrumbs[] = array('label'=>'Email Reports','url'=>base_url('crm/ereport'),'single'=>'Y');



		$shared_users = $this->crm->get_all_shared_users($this->_parent_users);



		$this->_data['shared_users'] = $shared_users;



		if ($this->input->is_ajax_request()) {

		   //Add Records to List

		   $this->add_emails_Records_to_List();

		}



		//$this->load->helper('scripts');



		//$categories = crm_options();



		$record=array();



		//$this->_data['categories'] = $categories;



		if($this->input->post('action')=="report") {



			$record=$this->input->post('record');



			$er = array();



			//if(empty($record['user'])) $er['user']="User required";



			$catg=2;



			if(empty($record['ifdate'])) $er['ifdate']="From date required";



			if(empty($record['itdate'])) $er['itdate']="To date required";



			if($record['ifdate'] && $record['itdate']) {



				$dt = explode("/",$record['ifdate']);//m/d/y-012



				$ifdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201



				$dt = explode("/",$record['itdate']);//m/d/y-012



				$itdate="{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201



				if(strtotime($ifdate)>strtotime($itdate)) $er['itdate']="End date should be after from date";



			}



			if(empty($record['efilter'])) $er['efilter']="Email filter required";



			//Error sending



			if(!$er) {

				$suser = $record['user'];

				if(!$suser) $suser = $this->_parent_users;

				$dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";

				if($record['subject']) {

					$dtwhere .= " AND i.intr_info like '%".$record['subject']."%' ";

				}



				$contacts = $this->crm->get_email_reports($suser,$dtwhere,$record['efilter']);



				//Counts

				$dtwhere = "(intr_date BETWEEN '$ifdate' AND '$itdate')";

				if($record['subject']) $dtwhere .= " AND intr_info like '%".$record['subject']."%' ";

				$ereportcounts = array();

				$ereportcounts['s'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-1");

				$ereportcounts['v'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-5");

				$ereportcounts['c'] = $this->crm->get_interaction_counts($suser,$dtwhere,"2-1-7");

				$this->_data['ereportcounts']=$ereportcounts;



				$this->_data['contacts']=$contacts;



			}



			



			$this->_data['record']=$record;			



		}



		//$this->_data['breadcrumbs']=$breadcrumbs;

		$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));



		//Email Subjects

		$email_subjects = array();

		$esubjects = $this->home->getEmailSubjects($this->_parent_users);

		if($esubjects) {

			foreach($esubjects as $esub) {

				$email_subjects[] = json_decode($esub->value);

			}

		}

		$this->_data['email_subjects'] = $email_subjects;



		$this->load->view('crm/email-reports', $this->_data);



    }
	
	
	public function sreport($action = null)
    {
        $this->_data['crmlite'] = 'report';

        $pam3 = $action;

        $breadcrumbs = [];

        $breadcrumbs[] = ['label' => 'Activity Reports', 'url' => base_url('crm/report'), 'single' => 'N'];

        $breadcrumbs[] = ['label' => 'Sales Reports', 'url' => base_url('crm/sreport'), 'single' => 'Y'];

        $shared_users = $this->crm->get_all_shared_users($this->_parent_users);

        $this->_data['shared_users'] = $shared_users;

        if ($this->input->is_ajax_request()) {

           //Add Records to List

            $this->add_emails_Records_to_List();
        }

        //$this->load->helper('scripts');

        //$categories = crm_options();

        $record = [];

        //$this->_data['categories'] = $categories;

        if ($this->input->post('action') == 'report') {
            $record = $this->input->post('record');

            $er = [];

            //if(empty($record['user'])) $er['user']="User required";

            $catg = 2;

            if (empty($record['ifdate'])) {
                $er['ifdate'] = 'From date required';
            }

            if (empty($record['itdate'])) {
                $er['itdate'] = 'To date required';
            }

            if ($record['ifdate'] && $record['itdate']) {
                $dt = explode('/', $record['ifdate']);//m/d/y-012

                $ifdate = "{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201

                $dt = explode('/', $record['itdate']);//m/d/y-012

                $itdate = "{$dt[2]}-{$dt[0]}-{$dt[1]}";//y-m-d 201

                if (strtotime($ifdate) > strtotime($itdate)) {
                    $er['itdate'] = 'End date should be after from date';
                }
            }

            if (empty($record['efilter'])) {
                $er['efilter'] = 'Email filter required';
            }

            //Error sending

            if (!$er) {
                $suser = $record['user'];

                if (!$suser) {
                    $suser = $this->_parent_users;
                }

                $dtwhere = "(i.intr_date BETWEEN '$ifdate' AND '$itdate')";

                if ($record['subject']) {
                    $dtwhere .= " AND i.intr_info like '%" . $record['subject'] . "%' ";
                }

                $contacts = $this->crm->get_email_reports($suser, $dtwhere, $record['efilter']);

                //Counts

                $dtwhere = "(intr_date BETWEEN '$ifdate' AND '$itdate')";

                if ($record['subject']) {
                    $dtwhere .= " AND intr_info like '%" . $record['subject'] . "%' ";
                }

                $ereportcounts = [];

                $ereportcounts['s'] = $this->crm->get_interaction_counts($suser, $dtwhere, '2-1-1');

                $ereportcounts['v'] = $this->crm->get_interaction_counts($suser, $dtwhere, '2-1-5');

                $ereportcounts['c'] = $this->crm->get_interaction_counts($suser, $dtwhere, '2-1-7');

                $this->_data['ereportcounts'] = $ereportcounts;

                $this->_data['contacts'] = $contacts;
            }

            $this->_data['record'] = $record;
        }

        //$this->_data['breadcrumbs']=$breadcrumbs;

        $this->_data['catlist'] = $this->crm->get_all_catlist(['section' => 1]);

        //Email Subjects

        $email_subjects = [];

        $esubjects = $this->home->getEmailSubjects($this->_parent_users);

        if ($esubjects) {
            foreach ($esubjects as $esub) {
                $email_subjects[] = json_decode($esub->value);
            }
        }

        $this->_data['email_subjects'] = $email_subjects;

        $this->load->view('crm/sales-reports', $this->_data);
    }
	

    

    // RingCentral Saving process

    public function saveRingCentralInfo(){

        $display = isset($_POST['display']) ? 1 : 0;

        $input = [

            'username' => $_POST['user_name'],

            'password' => base64_encode($_POST['password']),

            'display' => $display

        ];

        $data = [

            'user_id' => $this->_user_id,

            'field_type' => 'ringcentral',

            'value' => serialize($input)

        ];



        $where = [

            'user_id' => $this->_user_id,

            'field_type' => 'ringcentral'

        ];



        if( $this->home->getUserData($where) ){

            $this->home->saveUserData($data,$where);

        }else{

            $this->home->saveUserData($data);

        }

        

        echo json_encode('success');die();

    }



	//Save email records to category list

	function add_emails_Records_to_List() {			

		if (!$this->input->is_ajax_request()) return;

		if($this->input->post('action')<>"ereportrectolist") return;



		$record_Ids = $this->input->post('catrecids');

		if(!$record_Ids) exit;

		$record_Ids = explode(",",$record_Ids);

		if(count($record_Ids)==0) exit;

		$record=$this->input->post('record');

		if(!$record['catg']) exit;

		$ccats = $record['catg'];

		$csaved = 0;

		foreach($record_Ids as $record_id) {

			//Contacts

			if($ccats) {

				foreach($ccats as $cat) {

					$exist_record = $this->crm->get_category_record($cat,$record_id);				

					if(!$exist_record) {

						$info = array('category_id'=>$cat,'record_id'=>$record_id);

						$this->crm->save_category_record($info);

						$csaved++;

					}

				}	

			}		

		}

		if(!$csaved) echo "May be records already added to List";

		else {

			if($csaved) echo "$csaved Contact".($csaved>1?'s':'')." added to List";

		}

		exit;

	}



	//EMAIL



	public function settings($action="settings") {	



		$this->_data['maildelv'] = $action;	



		$breadcrumbs = array();



		if($action=="fields" && isset($this->_data['eScripter'])) {



			if(!isset($this->_data['eScripter'])) {



				redirect(base_url() . 'crm/settings');



			}



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));



			$breadcrumbs[] = array('label'=>'Custom Fields','url'=>base_url('crm/settings/fields'));



		} else if($action=="zone") {



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));		



			$breadcrumbs[] = array('label'=>'Timezone','url'=>base_url('crm/settings/zone'));



		} 

		

		else if($action=="edata") {



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));



			$breadcrumbs[] = array('label'=>'Export Data','url'=>base_url('crm/settings/edata'));



		}

		

		else if($action=="sign") {



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));



			$breadcrumbs[] = array('label'=>'Signature','url'=>base_url('crm/settings/sign'));		



		} else if($action=="dropdowns") {



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));



			$breadcrumbs[] = array('label'=>'Edit Dropdowns','url'=>base_url('crm/settings/dropdowns'));



		}else if($action=="layout" && isset($this->_data['eScripter'])) {



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));

			$breadcrumbs[] = array('label'=>'Fieds Layout','url'=>base_url('crm/settings/layout'));	



			$this->load->helper('scripts');

			$layout_fields = layout_fields();

			//Custom Fields

			//Contacts

			$where = array();

			$where['user_id'] = $this->_user_id;

			$where['field_type'] = 'custom';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$custom = array();

			if(isset($user_info->value)) {

				$custom=unserialize($user_info->value);

			}

			if($custom) {

				//foreach($custom as $ck=>$cv) $layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				foreach($custom as $ck=>$cv){

				 if($ck!='kcount')

				 {

					$layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				 }

				}

			}

			$this->_data['layout_fields']=$layout_fields;	



			//$layout_field_options = '<option value="">No Mapping</option>';			

			foreach($layout_fields  as $key=>$val) $layout_field_options .= '<option value="'.$key.'">'.$val['label'].'</option>';

			$this->_data['layout_field_options'] = $layout_field_options;			



			//Contact fields

			$wherec = array();

			$wherec['user_id'] = $this->_user_id;

			$wherec['field_type'] = 'layout';

			$user_infoc = $this->home->getUserData($wherec);

			if($user_infoc) $user_infoc = $user_infoc[0];



			$layout_keys = array_keys($layout_fields);

			$contact_fields = $layout_keys;

			if(isset($user_infoc->value) && $user_infoc->value) {

				$contact_fields=json_decode($user_infoc->value);

				$contact_fields = (array)$contact_fields;

			}

			$this->_data['contact_fields']=$contact_fields;

			$layout_keys = array_diff($layout_keys, $contact_fields);

			$this->_data['layout_keys']=$layout_keys;

			

			//acount

			$alayout_fields = alayout_fields();

			$where = array();

			$where['user_id'] = $this->_user_id;

			$where['field_type'] = 'customa';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$customa = array();

			if(isset($user_info->value)) {

				$customa=unserialize($user_info->value);

			}

			

			if($customa) 

			{

				foreach($customa as $ck=>$cv){

				 if($ck!='kcount')

				 {

					$alayout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				 }

				}

			}

			

			

			$this->_data['alayout_fields']=$alayout_fields;	



			//$alayout_field_options = '<option value="">No Mapping</option>';			

			foreach($alayout_fields  as $key=>$val) $alayout_field_options .= '<option value="'.$key.'">'.$val['label'].'</option>';

			$this->_data['alayout_field_options'] = $alayout_field_options;			



			//User fields

			$wherea = array();

			$wherea['user_id'] = $this->_user_id;

			$wherea['field_type'] = 'layout_account';

			$user_infoa = $this->home->getUserData($wherea);

			if($user_infoa) $user_infoa = $user_infoa[0];



			$alayout_keys = array_keys($alayout_fields);

			$account_fields = $alayout_keys;

			if(isset($user_infoa->value) && $user_infoa->value) {

				$account_fields=json_decode($user_infoa->value);

				$account_fields = (array)$account_fields;

			}

			$this->_data['account_fields']=$account_fields;

			$alayout_keys = array_diff($alayout_keys, $account_fields);

			$this->_data['alayout_keys']=$alayout_keys;

		}

		

		

		else if($action=="columns" && isset($this->_data['eScripter'])) {



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));

			$breadcrumbs[] = array('label'=>'Column Layout','url'=>base_url('crm/settings/columns'));	



			$this->load->helper('scripts');

			

			$layout_fields = col_fields();

			

			

			//Custom Fields

			//Contacts

			$where = array();

			$where['user_id'] = $this->_user_id;

			$where['field_type'] = 'custom';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$custom = array();

			if(isset($user_info->value)) {

				$custom=unserialize($user_info->value);

			}

			

			if($custom) {

				foreach($custom as $ck=>$cv){

				 if($ck!='kcount')

				 {

					$layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				 }

				}

			}

			

			

			$this->_data['layout_fields']=$layout_fields;	



			//$layout_field_options = '<option value="">No Mapping</option>';			

			foreach($layout_fields  as $key=>$val) $layout_field_options .= '<option value="'.$key.'">'.$val['label'].'</option>';

			$this->_data['layout_field_options'] = $layout_field_options;

			

				



			//Contact fields

			$wherec = array();

			$wherec['user_id'] = $this->_user_id;

			$wherec['field_type'] = 'column';

			$user_infoc = $this->home->getUserData($wherec);

			if($user_infoc) $user_infoc = $user_infoc[0];



			$layout_keys = array_keys($layout_fields);

			//$contact_fields = $layout_keys;

			$contact_fields = array();	

			if(isset($user_infoc->value) && $user_infoc->value) {

				$contact_fields=json_decode($user_infoc->value);

				$contact_fields = (array)$contact_fields;

			}

			if(!$contact_fields)

			{

				$contact_fields = array();	

				//echo "ewrwerewr";

				foreach($layout_keys as $key=>$value)

				{

					if($value=='user_first' || $value=='user_title'  || $value=='account_id' ||  $value=='phone' || $value=='email' || $value=='ipoints')

					{

						$contact_fields[$key] = $value;

					}

				}

			}

			$this->_data['contact_fields']=$contact_fields;

			$layout_keys = array_diff($layout_keys, $contact_fields);

			$this->_data['layout_keys']=$layout_keys;

			

			//acount

			$alayout_fields = alayout_fields();

			$where = array();

			$where['user_id'] = $this->_user_id;

			$where['field_type'] = 'customa';

			$user_info = $this->home->getUserData($where);

			if($user_info) $user_info = $user_info[0];



			$customa = array();

			if(isset($user_info->value)) {

				$customa=unserialize($user_info->value);

			}

			if($customa) {

				foreach($customa as $ck=>$cv){

				 if($ck!='kcount')

				 {

					$alayout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				 }

			  }

			}

			$this->_data['alayout_fields']=$alayout_fields;	



			//$alayout_field_options = '<option value="">No Mapping</option>';			

			foreach($alayout_fields  as $key=>$val) $alayout_field_options .= '<option value="'.$key.'">'.$val['label'].'</option>';

			$this->_data['alayout_field_options'] = $alayout_field_options;			



			//User fields

			$wherea = array();

			$wherea['user_id'] = $this->_user_id;

			$wherea['field_type'] = 'column_account';

			$user_infoa = $this->home->getUserData($wherea);

			if($user_infoa) $user_infoa = $user_infoa[0];

			

			



			$alayout_keys = array_keys($alayout_fields);

			//$account_fields = $alayout_keys;

			$account_fields = array();

			if(isset($user_infoa->value) && $user_infoa->value) {

				$account_fields=json_decode($user_infoa->value);

				$account_fields = (array)$account_fields;

				//echo '<pre>'; print_r($account_fields); echo '</pre>';exit;

			}

			if(!$account_fields)

			{

				$account_fields = array();	

				foreach($alayout_keys as $key=>$value)

				{

					if($value=='account_name' || $value=='share_user_title'  || $value=='billing' ||  $value=='phone' || $value=='ipoints')

					{

						$account_fields[$key] = $value;

					}

				}

			}

			$this->_data['account_fields']=$account_fields;

			$alayout_keys = array_diff($alayout_keys, $account_fields);

			$this->_data['alayout_keys']=$alayout_keys;

        }

        //Integrations

		else if($action=="integrations" && isset($this->_data['eScripter'])) {
			

			$breadcrumbs[] = array('label'=>'Integrations','url'=>base_url('crm/settings/integrations'));	



			$where_mc = array();

			$where_mc['user_id'] = $this->_user_id;

			$where_mc['field_type'] = 'mailchimp';

			$user_info_mc = $this->home->getUserData($where_mc);

			if($user_info_mc) $user_info_mc = $user_info_mc[0];

			$mailchimp = array('apikey'=>'');

            if(isset($user_info_mc->value)) $mailchimp['apikey'] = $user_info_mc->value;
			
			$this->_data['mailchimp'] = $mailchimp;

            //RingCentral Info

            $ringCentral = $this->home->getUserData([

                'user_id'=>$this->_user_id,

                'field_type'=>'ringcentral'

            ]);

            if( $ringCentral[0] ){

                $rc = unserialize($ringCentral[0]->value);

                $this->_data['mailchimp']=$mailchimp;

                $this->_data['ringcentral']=[

                    'username'=>$rc['username'],

                    'extension'=>$rc['extension'],

                    'password'=>base64_decode($rc['password']),

                    'display'=>$rc['display']

                ];

            }

		}

		

		

		//MailChimp
		/*else if($action=="mailchimp" && isset($this->_data['eScripter'])) {
			$breadcrumbs[] = array('label'=>'MailChimp','url'=>base_url('crm/settings/mailchimp'));	



			$where_mc = array();

			$where_mc['user_id'] = $this->_user_id;

			$where_mc['field_type'] = 'mailchimp';

			$user_info_mc = $this->home->getUserData($where_mc);

			if($user_info_mc) $user_info_mc = $user_info_mc[0];

			$mailchimp = array('apikey'=>'');

			if(isset($user_info_mc->value)) $mailchimp['apikey'] = $user_info_mc->value;

			$this->_data['mailchimp']=$mailchimp;

		}*/

		else if($action=="settings"){



			$breadcrumbs[] = array('label'=>'Settings','url'=>base_url('crm/settings'));



			$breadcrumbs[] = array('label'=>'Email','url'=>base_url('crm/settings'));



		}

		$this->_data['breadcrumbs']=$breadcrumbs;



		//SMTP



		if($action=="settings") {



			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'smtp';



			$user_info = $this->home->getUserData($where);



			if($user_info) $user_info = $user_info[0];



			//SMTP Data



			$smtp = array();



			if(isset($user_info->value)) {



				$smtp=unserialize($user_info->value);



				/*$smtp['username']=base64_decode($smtp['username']);



				$smtp['password']=base64_decode($smtp['password']);*/



			}



			$this->_data['smtp']=$smtp;	



		}

		//edit dropdowns

		else if($action=="dropdowns") {

			//lead

			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'lead';

	

			$user_info = $this->home->getUserData($where);



			if($user_info) $user_info = $user_info[0];



			//Lead Data



			$lead = array();



			if(isset($user_info->value)) {



				$lead=json_decode($user_info->value);



			}

			if(empty($lead)) $lead = $this->config->item('lead');



			$this->_data['lead']=$lead;	

			

			//stage

			$where1 = array();

			

			$where1['user_id'] = $this->_user_id;



			$where1['field_type'] = 'stage';

	

			$user_info = $this->home->getUserData($where1);



			if($user_info) $user_info = $user_info[0];



			//Stage Data



			$stage = array();



			if(isset($user_info->value)) {

				$stage=json_decode($user_info->value);

			}

			if(empty($stage)) $stage = $this->config->item('stage');

			$this->_data['stage']=$stage;	

			//print_r($this->_data['stage']);

			//print_r($this->_data['lead']); 



		}



		//Custom Fields



		else if($action=="fields" && isset($this->_data['eScripter'])) {



			//Contacts

			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'custom';



			$user_info = $this->home->getUserData($where);



			if($user_info) $user_info = $user_info[0];



			



			$custom = array();



			if(isset($user_info->value)) {



				$custom=unserialize($user_info->value);



			}



			$this->_data['custom']=$custom;



			//Numeric



			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'customNum';



			$user_info = $this->home->getUserData($where);



			if($user_info) $user_info = $user_info[0];



			



			$customNum = array();



			if(isset($user_info->value)) {



				$customNum=unserialize($user_info->value);



			}



			$this->_data['customNum']=$customNum;





			//Accounts

			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'customa';



			$user_info = $this->home->getUserData($where);



			if($user_info) $user_info = $user_info[0];



			



			$customa = array();



			if(isset($user_info->value)) {



				$customa=unserialize($user_info->value);



			}



			$this->_data['customa']=$customa;



			//Numeric



			$where = array();



			$where['user_id'] = $this->_user_id;



			$where['field_type'] = 'customNuma';



			$user_info = $this->home->getUserData($where);



			if($user_info) $user_info = $user_info[0];



			



			$customNuma = array();



			if(isset($user_info->value)) {



				$customNuma=unserialize($user_info->value);



			}



			$this->_data['customNuma']=$customNuma;



		}



		//Signature



		else if($action=="sign") {



			$sign = $this->_data['aMember'];

			

			//echo '<pre>'; print_r($sign); echo '</pre>';



			$this->_data['sign']=$sign;				



		}

		else if($action=="invitation" && isset($this->_data['eScripter'])){

			//invitation to contact

			$this->_data['receive_invitations'] = $this->home->getAllRequestsNew($this->_user_id, 'receiver');

		}

		//organization



		else if($action=="organization" && isset($this->_data['eScripter'])) {



			if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489



			//$d_page_name = 16;



			// For Existing Team Members Conection



			$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');



			$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);



			$this->_data['all_shared_users'] = $this->home->getSharedUsers($this->_user_id);



			/**  find all records for drop down **/



			$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();



			$this->_data['drop_company'] = $this->campaign->get_drop_company();



			$this->_data['drop_name'] = $this->campaign->get_drop_name();

			

			

			/* print_r($this->_data);		



			die(); */



			$this->_data['page'] = '';



			$this->_data['d_page'] = $d_page_name;



		} 



		



		//Save smtp details



		if($this->input->post('action')=="save") {



			if($action=="settings") {



				$smtp=$this->input->post('smtp');



				$record=$this->input->post('email');



			} else if($action=="dropdowns") {

				$lead=array();

				$stage=array();



				$lead=$this->input->post('lead');



				$stage=$this->input->post('stage');



			}else if($action=="zone"){



				$tzone=$this->input->post('tzone');



			} else if($action=="sign"){



				$sign=$this->input->post('sign');



			} else if($action=="fields"){



				$custom=$this->input->post('custom');

				$customNum=$this->input->post('customNum');



				$customa=$this->input->post('customa');

				$customNuma=$this->input->post('customNuma');



			}



			$er = array();



			if($action=="zone"){



				if(empty($tzone)) $er['tzone']="Time Zone required";



			} else if($action=="dropdowns"){



				//if(empty($tzone)) $er['tzone']="Time Zone required";



			}else if($action=="fields"){



				/*if(empty($custom['field1'])) $er['field1']="Contact Custom Field 1 required";

				if(empty($custom['field2'])) $er['field2']="Contact Custom Field 2 required";

				if(empty($custom['field3'])) $er['field3']="Contact Custom Field 3 required";



				if(empty($customa['field1'])) $er['afield1']="Account Custom Field 1 required";

				if(empty($customa['field2'])) $er['afield2']="Account Custom Field 2 required";

				if(empty($customa['field3'])) $er['afield3']="Account Custom Field 3 required";*/



			} else if($action=="sign"){//Signature



				/*if(empty($sign['yname'])) $er['yname']="Name required";



				if(empty($sign['ytitle'])) $er['ytitle']="Title required";



				//if(empty($sign['ycompany'])) $er['ycompany']="Company required";



				if(empty($sign['yphone'])) $er['yphone']="Phone required";



				if(empty($sign['yemail'])) $er['yemail']="Email address required";



				//if(empty($sign['ywebsite'])) $er['ywebsite']="Website required";*/



			} else if($action=="settings") {



				/*if(empty($smtp['server'])) $er['server']="Host required";



				if(empty($smtp['port'])) $er['port']="Port required";



				if(empty($smtp['username'])) $er['username']="Username required";



				if(empty($smtp['password'])) $er['password']="Password required";*/



				if(empty($smtp['fromname'])) $er['fromname']="From name required";			



				$this->load->helper('email');



				if(empty($smtp['fromemail'])) $er['fromemail']="From email required";



				else if (!valid_email($smtp['fromemail'])) $er['fromemail']="Enter valid email address";			



				/*if(empty($record['email'])) $er['email']="Test email required";



				else if (!valid_email($record['email'])) $er['email']="Enter valid email address";*/



			}

			//Mailchimp

			if($action=="integrations"){

				$mailchimp=$this->input->post('mailchimp');

				//if(empty($mailchimp['apikey'])) $er['apikey']="MailChimp API Key required";

			}	



			//Error sending



			if($er) {



				$response = implode("\n",$er);



				echo $response;



				exit;



			}



			if($action=="zone"){



				$where = array();



				$where['user_id'] = $this->_user_id;



				$where['field_type'] = 'timezone';



				$user_info = $this->home->getUserData($where);



				$data = array();



				$data['value'] = $tzone;



				if($user_info) $this->home->saveUserData($data,$where);



				else {



					$data['user_id'] = $this->_user_id;



					$data['field_type'] = 'timezone';



					$this->home->saveUserData($data);



				}



				echo '<div style="color:#5fba7d">Settings Updated successfully.</div>';



				exit;



			} 

			

			else if($action=="edata"){



				$data['usersData'] = $this->crm->getContactDetails();



				exit;



			}

			

			else if($action=="fields" && isset($this->_data['eScripter'])){



				//CONTACTS

				//Custom Field labels



				$where = array();



				$where['user_id'] = $this->_user_id;



				$where['field_type'] = 'custom';



				$user_info = $this->home->getUserData($where);



				$data = array();



				$data['value'] = serialize($custom);



				if($user_info) $this->home->saveUserData($data,$where);



				else {



					$data['user_id'] = $this->_user_id;



					$data['field_type'] = 'custom';



					$this->home->saveUserData($data);



				}



				//Custom Field Numerics



				$where = array();



				$where['user_id'] = $this->_user_id;



				$where['field_type'] = 'customNum';



				$user_info = $this->home->getUserData($where);



				$data = array();



				$data['value'] = $customNum?serialize($customNum):'';



				if($user_info) $this->home->saveUserData($data,$where);



				else {



					$data['user_id'] = $this->_user_id;



					$data['field_type'] = 'customNum';



					$this->home->saveUserData($data);



				}



				//ACCOUNTS

				//Custom Field labels



				$where = array();



				$where['user_id'] = $this->_user_id;



				$where['field_type'] = 'customa';



				$user_info = $this->home->getUserData($where);



				$data = array();



				$data['value'] = serialize($customa);



				if($user_info) $this->home->saveUserData($data,$where);



				else {



					$data['user_id'] = $this->_user_id;



					$data['field_type'] = 'customa';



					$this->home->saveUserData($data);



				}



				//Custom Field Numerics



				$where = array();



				$where['user_id'] = $this->_user_id;



				$where['field_type'] = 'customNuma';



				$user_info = $this->home->getUserData($where);



				$data = array();



				$data['value'] = $customNuma?serialize($customNuma):'';



				if($user_info) $this->home->saveUserData($data,$where);



				else {



					$data['user_id'] = $this->_user_id;



					$data['field_type'] = 'customNuma';



					$this->home->saveUserData($data);



				}



				echo '<div style="color:#5fba7d">Settings Updated successfully.</div>';



				exit;



			}else if($action=="sign"){//Signature



				$where = array();



				$where['user_id'] = $this->_user_id;



				$where['field_type'] = 'sign';



				$user_info = $this->home->getUserData($where);



				$data = array();





				$data['value'] = serialize($sign);



				if($user_info) $this->home->saveUserData($data,$where);



				else {



					$data['user_id'] = $this->_user_id;



					$data['field_type'] = 'sign';



					$this->home->saveUserData($data);



				}



				echo '<div style="color:#5fba7d">Settings Updated successfully.</div>';



				exit;



			}else if($action=='dropdowns'){

			

				$data = array();

				//print_r($lead);



				$data['value'] = json_encode($lead);

				//print_r($data['value']); exit;

	

				if($user_info) $this->home->saveUserData($data,$where);

	

				else {

	

					$data['user_id'] = $this->_user_id;

	

					$data['field_type'] = 'lead';

	

					$this->home->saveUserData($data);

	

				}

				//stage 

				$data1 = array();



				$data1['value'] = json_encode($stage);

	

				if($user_info) $this->home->saveUserData($data1,$where1);

	

				else {

	

					$data1['user_id'] = $this->_user_id;

	

					$data1['field_type'] = 'stage';

	

					$this->home->saveUserData($data1);

	

				}

	

				echo '<div style="color:#5fba7d">Dropdown Values Saved.</div>';

	

				exit;

			

			

			}else if($action=='layout' && isset($this->_data['eScripter'])){

				//Fields Layout

				$layout_action=$this->input->post('layout_action');

				if($layout_action=="reset") {

					$fields ="";

				} else if($layout_action=="reset_account") {

					$afields ="";

				} else {

					$fields=$this->input->post('fields');

					$fields = array_filter($fields);

					$fields = array_unique($fields);	

					//account

					$afields=$this->input->post('afields');

					$afields = array_filter($afields);

					$afields = array_unique($afields);

				}

				$data = array();

				if($layout_action!="reset_account"){

					$data['value'] = $fields?json_encode($fields):'';		

					//echo "test"	;	

					if($user_infoc) $this->home->saveUserData($data,$wherec);	

					else {

						$data['user_id'] = $this->_user_id;

						$data['field_type'] = 'layout';

						$this->home->saveUserData($data);

					}

				 } 

				 $data = array();

				 if($layout_action<>"reset"){

					$data['value'] = $afields?json_encode($afields):'';				

					if($user_infoa) $this->home->saveUserData($data,$wherea);	

					else {

						$data['user_id'] = $this->_user_id;

						$data['field_type'] = 'layout_account';

						$this->home->saveUserData($data);

					}

				 }





				echo '<div style="color:#5fba7d">Layout settings saved.</div>';	

				exit;



			}

			

			elseif(($action=='columns' && isset($this->_data['eScripter']))){				

				//Fields Layout

				$layout_action=$this->input->post('layout_action');

				if($layout_action=="reset") {

					$fields ="";

				} else if($layout_action=="reset_account") {

					$afields ="";

				} else {

					$fields=$this->input->post('fields');

					$fields = array_filter($fields);

					$fields = array_unique($fields);	

					//account

					$afields=$this->input->post('afields');

					$afields = array_filter($afields);

					$afields = array_unique($afields);

				}

				$data = array();

				if($layout_action!="reset_account"){

					$data['value'] = $fields?json_encode($fields):'';		

					//echo "test"	;	

					if($user_infoc) $this->home->saveUserData($data,$wherec);	

					else {

						$data['user_id'] = $this->_user_id;

						$data['field_type'] = 'column';

						$this->home->saveUserData($data);

					}

				 } 

				 $data = array();

				 if($layout_action<>"reset"){

					$data['value'] = $afields?json_encode($afields):'';				

					if($user_infoa) $this->home->saveUserData($data,$wherea);	

					else {

						$data['user_id'] = $this->_user_id;

						$data['field_type'] = 'column_account';

						$this->home->saveUserData($data);

					}      

				 }

		

				echo '<div style="color:#5fba7d">Column settings saved.</div>';	

				exit;

				

            }

			//Mailchimp

			else if($action=='mailchimp' && isset($this->_data['eScripter'])){

				$data = array();

				$data['value'] = $mailchimp['apikey'];

				if($user_info_mc) $this->home->saveUserData($data,$where_mc);

				else {

					$data['user_id'] = $this->_user_id;

					$data['field_type'] = 'mailchimp';

					$this->home->saveUserData($data);

				}



				echo '<div style="color:#5fba7d">MailChimp settings saved.</div>';

				return;

			}



			//save SMTP



			$smtpInfo = $smtp;			



			



			//Testing SMPT details			



			//Send Test Mail



			/*require_once APPPATH."/third_party/mail/class.phpmailer.php";



			$mail = new PHPMailer(true); 

			$mail->IsMail();

			$mail->IsHTML(true);*/



			/*

			$mail->isSMTP();	//Tell PHPMailer to use SMTP



			$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)



			$mail->SMTPAuth   = true;                  // enable SMTP authentication



			



			$mail->Host       = $smtpInfo['server']; // sets the SMTP server



			$mail->Port       = $smtpInfo['port'];                    // set the SMTP port for the GMAIL server



			$mail->Username   = $smtpInfo['username']; // SMTP account username



			$mail->Password   = $smtpInfo['password'];        // SMTP account password



			if($smtpInfo['crypto']) $mail->SMTPSecure = $smtpInfo['crypto'];					

			*/



			



			



			



			//SMTP SETTINGS ----------



			



			/*try {



			  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');



			  $mail->AddAddress($record['email'], 'SalesScripter');



			  $mail->SetFrom($smtpInfo['fromemail'], $smtpInfo['fromname']);



			  //$mail->AddReplyTo('name@yourdomain.com', 'First Last');



			  $mail->Subject = 'SalesScripter Test Mail';



			 // $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically



			  $mail->Body = 'SalesScripter Test Mail sent successfully!'; // optional - MsgHTML will create an alternate automatically



			  // $mail->MsgHTML(file_get_contents('contents.html'));



			  //$mail->AddAttachment('images/phpmailer.gif');      // attachment



			  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment  



			  $mail->Send();



			  echo '<br><div style="color:#5fba7d">Test Mail Sent, SMTP details correct.</div>';



			} catch (phpmailerException $e) {



			  echo "Unable to Setup SMTP details, please check below \n";



			  echo $e->errorMessage(); //Pretty error messages from PHPMailer



			  exit;



			} catch (Exception $e) {



			  echo "Unable to Setup SMTP details, please check below \n";	



			  echo $e->getMessage(); //Boring error messages from anything else!



			  exit;



			}*/



			



			//save



			/*$smtp['username']=base64_encode($smtp['username']);



			$smtp['password']=base64_encode($smtp['password']);*/



			$data = array();



			$data['value'] = serialize($smtp);



			if($user_info) $this->home->saveUserData($data,$where);



			else {



				$data['user_id'] = $this->_user_id;



				$data['field_type'] = 'smtp';



				$this->home->saveUserData($data);



			}



			echo '<div style="color:#5fba7d">Settings saved.</div>';



			exit;



		}



		if($action=="zone") {



			//Time Zone



			$this->load->helper('date');



			$this->load->helper('scripts');



			$this->_data['timezones'] = generate_timezone_list();



			//$this->_data['timezones'] = DateTimeZone::listIdentifiers(DateTimeZone::ALL);



		}	

		

		//echo '<pre>'; print_r($this->_data); echo '</pre>';



		$this->load->view('crm/settings', $this->_data);



	}



	//Compose Mail



	public function compose($action=NULL) {



		$cmpid = $this->_data['campaign_info']->campaign_id;



		$this->_data['crmlite'] = "compose";	



		//Delete saved template



		if($this->input->post('action')=="delsTemplate") {



			$etid = $this->input->post('stid');



			$etid = str_replace("T","",$etid);



			$this->crm->delete_email_template($etid);



			exit;



		}



		$breadcrumbs = array();



		$parent_id = (int)$action;



		//Contact Record



		if($parent_id) {



			$parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/compose');



			$contact_name = ucfirst($parent_record[user_first].' '.$parent_record[user_last]);



			$first_name = ucfirst($parent_record[user_first]);



			$last_name = ucfirst($parent_record[user_last]);



			$contact_email = $parent_record[email];



			$this->_data['parent_id'] = $parent_id;



			$this->_data['contact_name'] = $contact_name;



			$this->_data['contact_fname'] = $first_name;



			$this->_data['contact_lname'] 	= $last_name;



			$this->_data['contact_email'] = $contact_email;



			$this->_data['unsubscribed'] = $parent_record['unsubscribed'];



			$breadcrumbs[] = array('label'=>'Contact','url'=>base_url('crm/contacts'));



			$breadcrumbs[] = array('label'=>$contact_name,'url'=>base_url('crm/contacts/view/'.$parent_id));



			$breadcrumbs[] = array('label'=>'Send Email','url'=>base_url('crm/compose/'.$parent_id));



		} else {



			$breadcrumbs[] = array('label'=>'Send Email','url'=>base_url('crm/compose'));



			//To load email template



			if($action && strpos($action,"t")!==FALSE && strlen($action)>1) {



				$template_content_id = (int)substr($action,1);



				if(($template_content_id>=96 && $template_content_id<=111) || $template_content_id==161 || $template_content_id==167 || $template_content_id==173 || $template_content_id==179 || $template_content_id==221 || $template_content_id==227 || ($template_content_id>=213 && $template_content_id<=215)) $this->_data['template_content_id'] = $template_content_id;



			} 



			//Load email thread



			else if($action && strpos($action,"T")!==FALSE && strlen($action)>1) {



				$thread_id = (int)substr($action,1);



				if($thread_id) {



					$thread_main=$this->crm->get_uemail_templates(array('tid'=>$thread_id));



					if($thread_main) {



						$record=array('tempname'=>$thread_main[0]->tempname,'subject'=>$thread_main[0]->subject,'info'=>$thread_main[0]->content);



						$this->_data['record'] = $record;



						$this->_data['thread_id'] = $thread_id;

						$this->_data['thread_main'] = $thread_main[0];

						if($thread_main[0]->task_subject) $this->_data['thread_task'] = 1;



						//Thread sub ids

						$thread_subs=$this->crm->get_thread_template_ids($thread_id);

						$thread_ids = array($thread_id=>$thread_id);

						if($thread_subs) {

							foreach($thread_subs as $tsub) $thread_ids[$tsub->tid] = $tsub->tid;

						}

						//Thread Tasks						

						$thread_tasks=$this->crm->get_email_tasks($thread_id);

						$email_tasks = array();

						if($thread_tasks) {

							$eid = $thread_id;

							foreach($thread_tasks as $etask) {

								if(isset($thread_ids[$etask->email_id])) {

									$eid = $etask->email_id;

									if(!isset($email_tasks[$eid])) $email_tasks[$eid] = array();

								}								

								$email_tasks[$eid][] = $etask;

							}

						}

						$this->_data['email_tasks'] = $email_tasks;

					}

					$thread_sub=$this->crm->get_uemail_templates(array('schparent'=>$thread_id));



					if($thread_sub) $this->_data['thread_sub'] = $thread_sub;



				}



			}



		}	



		//SMTP Data



		$this->_data['smtp_info'] = 0;



		$where = array();



		$where['user_id'] = $this->_user_id;



		$where['field_type'] = 'smtp';



		$user_info = $this->home->getUserData($where);



		if($user_info) $user_info = $user_info[0];			



		$smtp = array();



		if(isset($user_info->value)) {



			$smtp=unserialize($user_info->value);



			/*$smtp['username']=base64_decode($smtp['username']);



			$smtp['password']=base64_decode($smtp['password']);*/



			$this->_data['smtp_info'] = 1;



		}





		//Save smtp details



		if($this->input->post('action')=="save") {



			$record=$this->input->post('record');



			$er = array();



			//if(empty($record['tid']) && empty($record['stid'])) $er['tid']="Email template required";



			if($record['act']=="send") {

				//Contact List

				if(empty($record['listid']) && (empty($record['cname']) || empty($record['lname'])) && empty($record['cemail'])) {

					$er['listid']="Select contact list or enter contact name and email address";

				} else if(empty($record['listid'])) {

					if(empty($record['cname'])) $er['cname']="Contact first name required";

					if(empty($record['lname'])) $er['lname']="Contact last name required";

					if(empty($record['cemail'])) $er['cemail']="Contact email required";

					else {

						$this->load->helper('email');

						if (!valid_email($record['cemail'])) $er['cemail']="Enter valid contact email address";

					}

				}



			}



			if(empty($record['subject'])) $er['subject']="Subject required";



			if(empty($record['info'])) $er['info']="Email content required";



			//if(empty($parent_record['email'])) $er['email']="Contact dont have email address";



			if(isset($record['esave'])) {



				if(empty($record['etitle'])) $er['etitle']="Save email template title required";



			}



			//Error sending



			if($er) {



				$er['er']="Please check required fields once.";



				$response = implode("\n",$er);



				echo $response;



				exit;



			}



			$esuemail_count = $this->home->get_single_user_info($this->_user_id);

			$ecount = $esuemail_count->email_count;



			//SMTP Data



			if($this->_data['smtp_info'] == 0) {



				$response = "Email settings not configured";



				echo $response;



				exit;



			}





			if(!isset($record['esave']) && $ecount > 10000) {



				$response = "This send request exceeds your monthly email limit.";



				echo $response;



				exit;



			}

			//echo "WORK INPROCESS for SHEDULE EMAIL";



			//echo "<pre>";print_r($record);echo "</pre>";



			//exit;



			//Delete Email template



			/*if(isset($record['edelete']) && $record['stid']) {



				$this->crm->delete_email_template($record['stid']);



				unset($record['stid']);



			}*/

			//Email Tasks

			$schindxes 	= $record['schindx'];

			$blocktype 	= $record['blocktype'];

			$slno 		= $record['slno'];

			$esrows 	= array();



			//Template task schedule fields

			$et_task_schedule_info = array();

			/*if(isset($record['sch']) && $record['sch']) {

				$et_task_schedule_info['task_subject'] = $record['sch']=="O"?$record['sch_txt']:$record['sch'];

				$et_task_schedule_info['task_duedate'] = $record['tsk_schcount']."-".$record['tsk_schtype'];

				$et_task_schedule_info['task_info']	  = $record['schnotes'];				

			}*/





			//Save Email template



			$savedEids ="";



			$saved_template_name = "";



			if(isset($record['esave'])) {				



				$data = array();



				$savedEids =array();



				$data['tempname'] = $record['etitle'];



				$template_name = $data['tempname'];



				$saved_template_name = $template_name;



				$data['subject'] = $record['subject'];



				$email_content = stripslashes($record['info']);



				if($record['cname']) {



					$email_content = str_replace("Hello ".$record['cname'],'Hello [Prospect First Name]',$email_content);



					$email_content = str_replace("Hi ".$record['cname'],'Hi [Prospect First Name]',$email_content);



				}



				$data['content'] = $email_content;



				$etemp=0;



				if($record['eoid'] && $record['etitle']==$record['eotitle']) {



					$peid = $this->crm->save_email_template($data,$record['eoid']);



					$etemp=1;		



					//Remove sub templates



					$rmtids = $this->input->post('etids');



					if($rmtids) {



						$rmtids = explode(",",$rmtids);



						$this->crm->delete_email_templates_sub($rmtids);



					}		

					

					//Remove template tasks

					$rmtids = $this->input->post('remschids');

					if($rmtids) {

						$rmtids = explode(",",$rmtids);

						$this->crm->delete_email_tasks($peid,$rmtids);

					}			



	



				} else $peid = $this->crm->save_email_template($data);



				$savedEids[] =$peid;				



				//Save schedule Email Templates



				if($peid) {

					$esrows[0] = $peid;

					$threads = 0;



					foreach($record['subjects'] as $si=>$sval) {



						$data = array();



						$data['subject'] = $sval;



						$email_content = stripslashes($record['infos'][$si]);



						if($record['cname']) {



							$email_content = str_replace("Hello ".$record['cname'],'Hello [Prospect First Name]',$email_content);



							$email_content = str_replace("Hi ".$record['cname'],'Hi [Prospect First Name]',$email_content);



						}



						$data['content'] = $email_content;



						$data['schcount'] = $record['schcount'][$si];



						$data['sorder'] = $record['sorder'][$si];



						$data['schtype'] = $record['schtype'][$si];



						$data['schtime'] = $record['schtime'][$si];



						$data['schmin'] = $record['schmin'][$si];



						$data['scham'] = $record['scham'][$si];



						$data['schparent'] = $peid;



						if($etemp && $record['tid'][$si]) $eid = $this->crm->save_email_template($data,$record['tid'][$si]);



						else $eid = $this->crm->save_email_template($data);

						//Template task schedule fields of child emails

						$emlindx = $record['emlindx'][$si];

						$emlkey = array_search($emlindx, $slno);

						$esrows[$emlkey] = $eid;





						$savedEids[] =$eid;



						if($eid) $threads++;



					}



					//Update parent as thread



					if($threads) {



						$data = array();



						$data['schparent'] = -1;



						$eid = $this->crm->save_email_template($data,$peid);



					}					



				}

				//Save email template tasks

				if($record['schids']) {

					$emlid = $eid;

					foreach($slno as $slnkey=>$slnval) {

						if(isset($esrows[$slnkey])) {

							$emlid = $esrows[$slnkey];

							continue;

						}

						$esrows[$slnkey] = $emlid;

					}

					foreach($record['schids'] as $schkey=>$schid) {								

						$eschtask = array();

						$schindx = $record['schindx'][$schkey];

						if(isset($record['schs'][$schindx]) && $record['schs'][$schindx]) {

							$eschtask['task_subject'] = $record['schs'][$schindx]=="O"?$record['sch_txts'][$schkey]:$record['schs'][$schindx];

							$eschtask['task_duedate'] = $record['tsk_schcounts'][$schkey]."-".$record['tsk_schtypes'][$schkey];

							$eschtask['task_info']	  = $record['schnotess'][$schkey];

							if($schid) {

								$emlkey = array_search($schindx, $slno);

								$eschtask['email_id']	  = $esrows[$emlkey];

								$estid = $this->crm->save_email_task($eschtask,$schid);

							} else {

								$eschtask['thread_id']	  = $peid;

								$emlkey = array_search($schindx, $slno);

								$eschtask['email_id']	  = $esrows[$emlkey];

								$estid = $this->crm->save_email_task($eschtask);

							}

						}								

					}

				}



				//Save Template only



				$savedEids = implode("-",$savedEids);



				if($record['act']=="save") {



					echo "SAVEDTEMPLATEIDS";



					exit;



				}				



				//echo $email_content;



				//echo "<br><hr><br>";



			} else $template_name = $record['tname'];



			//check contact



			$contact_info = $this->crm->search_contact(array('email',$record['cemail'],$this->_parent_users));



			if($contact_info) {



				$parent_id = $contact_info['contact_id'];



				//Unsubscribe



				if($contact_info['unsubscribed'] == '1') {



					$response = $record['cname']." ".$record['lname']." Unsubscribed.";



					echo $response;



					exit;



				}



			} else {



				$cdata = array();



				$cdata['user_first']=$record['cname'];



				$cdata['user_last']=$record['lname'];



				$cdata['email']=$record['cemail'];



				$cdata['share_user_id']=$this->_user_id;



				$cdata['create_date']=date("Y-m-d H:i:s");



				$cdata['modify_date']=date("Y-m-d H:i:s");



				$cdata = array_filter($cdata);



				//verify unique email address

				$econid=0;

				$email_info = $this->crm->search_contact(array('email',$cdata['email'],$this->_parent_users));

				if($email_info) $econid = $email_info['contact_id'];



				$parent_id = $this->crm->save_contact($cdata,$econid);



			}



			//Mail tracking elements adding



			//$rand_key = substr(random_alpha(6),0,6).$user_id.substr(random_alpha(3),0,3);



			//$user_id = (int)substr($rkey,6,strlen($rkey)-9);



			$this->load->helper('scripts');



			$userid = $this->_user_id;



			$rand_key = substr(get_random_alpha_string(6),0,6).$userid.substr(get_random_alpha_string(3),0,3);



			$rand_key2 = substr(get_random_alpha_string(6),0,6).$parent_id.substr(get_random_alpha_string(4),0,4);



			$email_content = $record['info'];



			$task_email_content = $email_content;



			//[[SSTAG TITLE="" URL=""]]



			/*$sstag = '[[SSTAG TITLE="';



			while(strpos($email_content,$sstag)!==FALSE) {



				$s1 = explode($sstag,$email_content);



				$orgLink = "";



				if(count($s1)>1) {



					$s1 = explode('"]]',$s1[1]);



					if(count($s1)>1) $orgLink = $sstag.$s1[0].'"]]';



				}



				if($orgLink) {



					$link_attr = explode('"',$orgLink);//0"1"2"3"4



					$link_text = $link_attr[1];



					$link_url = stripslashes($link_attr[3]);					



					$link_url = base64_encode($link_url);



					$link_url = str_replace("=","-",$link_url);



					$mail_click=base_url()."api/eclick/$rand_key/$rand_key2/$link_url";



					$email_link = '<a href="'.$mail_click.'" style="color:#005A9C;font-weight: bold;">'.$link_text.'</a>';



					$email_content = str_replace($orgLink,$email_link,$email_content);



				}



			}*/



			//Contact List : Prepare Email format data

			$Contact_email_info = array();

			if($record['listid']) {

				$Contact_email_info['sch_subject'] = $record['subject'];

				$semail_content = stripslashes($record['info']);

				if(strpos($semail_content,'[Prospect First Name]')===FALSE && $record['cname']) {

					$semail_content = str_replace("Hello ".$record['cname'],'Hello [Prospect First Name]',$semail_content);

					$semail_content = str_replace("Hi ".$record['cname'],'Hi [Prospect First Name]',$semail_content);

				}				

				$Contact_email_info['sch_content'] = $semail_content;

				$Contact_email_info['sch_contact'] = $record['listid'];

				$Contact_email_info['sch_etname'] = $template_name;

				$contacts_List = $this->crm->get_category_contacts($record['listid']);

				$cListtotalCount = count($contacts_List);

			}



			//Change all links to tracking links



			$track_data = array();

			$track_data['subject'] = $record['subject'];

			$track_data['etime'] = time();

			$track_data['content'] = $email_content;



			$track_data['userid'] = $userid;



			$track_data['contactid'] = $parent_id;



			$track_data['template_name'] = $template_name;



			//$this->load->helper('scripts');



			$email_content = format_email_tracks($track_data);



			//echo $email_content;exit;



			//Save email schedules



			if($record['subjects']) {



				$schdate = time();



				foreach($record['subjects'] as $si=>$sval) {



					$data = array();



					$data['sch_subject'] = $sval;



					$semail_content = stripslashes($record['infos'][$si]);



					//$semail_content = str_replace("Hello ".$record['cname'],'Hello [Prospect First Name]',$semail_content);



					//$semail_content = str_replace("Hi ".$record['cname'],'Hi [Prospect First Name]',$semail_content);



					$data['sch_content'] = $semail_content;



					$schdate = $schdate+($record['schtype'][$si]==2?7:1)*(int)$record['schcount'][$si]*24*60*60;



					//Same time schedules

					$emlval = $record['emlindx'][$si];

					if(isset($record['sametime'][$emlval]))  {



						$record['schtime'][$si]=date("H");



						$record['schmin'][$si]=date("i");



					} else {



						if($record['scham'][$si]=="0" && $record['schtime'][$si]=="12") $record['schtime'][$si]="00";



						else if($record['scham'][$si]=="1") {



							if($record['schtime'][$si]<>"12") $record['schtime'][$si]=(int)$record['schtime'][$si]+12;



						}



					}



					$schdate = date("Y-m-d",$schdate)." ".$record['schtime'][$si].":".$record['schmin'][$si].":00";



					$schdate = strtotime($schdate);



					$sch_date = $schdate-date("Z");



					$data['sch_date'] = date("Y-m-d H:i:00",$sch_date);



					$data['sch_contact'] = $parent_id;



					$data['sch_etname'] = $saved_template_name?$saved_template_name:stripslashes($record['tnames'][$si]);

					

					

					//Save schedule email follow up tasks under this email editor

					/*if($blocktype && $schindxes) {

						$eschtasks = array();

						$emlval = $record['emlindx'][$si];

						$bkey = array_search($emlval, $slno)+1;

						while(isset($blocktype[$bkey])) {

							if($blocktype[$bkey]<>"task") break;

							$schindx = $slno[$bkey];

							$schkey = array_search($schindx, $schindxes);

							$eschtask = array();

							if(isset($record['schs'][$schindx]) && $record['schs'][$schindx]) {

								$eschtask['subject'] = $record['schs'][$schindx]=="O"?$record['sch_txts'][$schkey]:$record['schs'][$schindx];		

								$eschtask['info']	  = $record['schnotess'][$schkey];

								$duedate = $schdate+($record['tsk_schtypes'][$schkey]==2?7:1)*(int)$record['tsk_schcounts'][$schkey]*24*60*60;

								$eschtask['duedate'] = date("Y-m-d",$duedate);

								$eschtasks[] = $eschtask;

							}

							$bkey++;

						}

						if($eschtasks) $data['task_info'] = json_encode($eschtasks);

					}*/



					//Conact List: Save schedules for Contact List emails

					if($Contact_email_info) {

						if($contacts_List) {

							if(strpos($semail_content,'[Prospect First Name]')===FALSE && $record['cname']) {

								$semail_content = str_replace("Hello ".$record['cname'],'Hello [Prospect First Name]',$semail_content);

								$semail_content = str_replace("Hi ".$record['cname'],'Hi [Prospect First Name]',$semail_content);

							}

							foreach($contacts_List as $reccontact) {					  			

								$data['sch_contact'] = $reccontact->record_id;

								$this->crm->save_scheduled_email($data);

							}

						}

					} else 

						$this->crm->save_scheduled_email($data);



				}



			}

			

			 if($cListtotalCount > 0) 

			  {

					$sECount = count($record['subjects']);

					$sECount = $sECount+1;

					$totalECount = $cListtotalCount * $sECount; 

					$esuemail_count = $this->home->get_single_user_info($this->_user_id);

					$oldCount = $esuemail_count->email_count;

					$finalCount = $oldCount+$totalECount;

					$this->home->update_email_count($this->_user_id,$finalCount);

			}

			else

			{

				$sECount = count($record['subjects']);

				$sECount = $sECount+1;

				$totalECount = $sECount;

				$esuemail_count = $this->home->get_single_user_info($this->_user_id);

				$oldCount = $esuemail_count->email_count;

				$finalCount = $oldCount+$totalECount;

				$this->home->update_email_count($this->_user_id,$finalCount);

			}



			//Schedule Follow up Task



			/*if(isset($record['sch']) && $record['sch']) {



				if(!empty($record['sdate'])) {



					$tmpdate = explode("/",$record['sdate']);//m/d/y-012



					$schdate="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201



				} else $schdate=date("Y-m-d");



				$sch_subject = ($record['sch']=="O"?$record['sch_txt']:$record['sch']);



				



				$taskdata = array(



							'task_subject'=>$sch_subject,



							'task_priority'=>'Normal',



							'task_status'=>'In Progress',



							'task_related'=>'C',



							'task_relatedto'=>$parent_id,



							'share_user_id'=>$this->_user_id,



							'task_duedate'=>$schdate,



							'task_info'=>$record['schnotes']



							);



				$tid = $this->crm->save_task($taskdata,0);



			}*/



			//echo $email_content;exit;



			//Send Email



			/*require_once APPPATH."/third_party/mail/class.phpmailer.php";



			$mail = new PHPMailer(true); 

			$mail->IsMail();

			$mail->IsHTML(true);*/



			/*

			$mail->isSMTP();



			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)



			$mail->SMTPAuth   = true;			



			if($smtp['crypto']) $mail->SMTPSecure = $smtp['crypto'];



			$mail->Host       = $smtp['server'];



			$mail->Port       = $smtp['port'];



			$mail->Username   = $smtp['username'];



			$mail->Password   = $smtp['password'];	

			*/		



			

			$emailSent = false;

			try {



				$toname = $record['cname'];



				if($record['lname']) $toname .= " ".$record['lname'];



			  /*$mail->AddAddress($record['cemail'], $toname);



			  $mail->SetFrom($smtp['fromemail'], $smtp['fromname']);



			  $mail->Subject = $record['subject'];



			  $mail->MsgHTML($email_content);



			  $mail->Send();				*/



			  //SEND BULK EMAIL IF CONTACT LIST SELECTED

			  //Conact List: Save schedules for Contact List emails

			  $oneContactId = 0;

			  if($Contact_email_info) {			  	

				if($contacts_List) {

					$schdate = time();

					$schdate = $schdate+1*60; // after 5mins

					$schdate = date("Y-m-d H:i:00",$schdate);

					$schdate = strtotime($schdate);

					$sch_date = $schdate-date("Z");

					$Contact_email_info['sch_date'] = date("Y-m-d H:i:00",$sch_date);

					

					//Save first schedule email follow up tasks under first email editor to contact list

					if($blocktype && $schindxes) {

						$eschtasks = array();

						$emlval = 1;

						$eml2 = -1;

						$bkey = array_search($emlval, $slno)+1;

						while(isset($blocktype[$bkey])) {

							//if($blocktype[$bkey]<>"task") break;

							if($blocktype[$bkey]<>"task") {

								if($eml2<>-1) {

									$schdate = $schdate+($record['schtype'][$eml2]==2?7:1)*(int)$record['schcount'][$eml2]*24*60*60;

								}

								$eml2++;

								$bkey++;

								continue;

							}

							$schindx = $slno[$bkey];

							$schkey = array_search($schindx, $schindxes);

							$eschtask = array();

							if(isset($record['schs'][$schindx]) && $record['schs'][$schindx]) {

								$eschtask['subject'] = $record['schs'][$schindx]=="O"?$record['sch_txts'][$schkey]:$record['schs'][$schindx];			

								$eschtask['info']	  = $record['schnotess'][$schkey];

								$duedate = $schdate+($record['tsk_schtypes'][$schkey]==2?7:1)*(int)$record['tsk_schcounts'][$schkey]*24*60*60;

								$eschtask['duedate'] = date("Y-m-d",$duedate);

								

								//$eschtasks[] = $eschtask;

								//prepate follow up task data

								$taskdata = array(

											'task_subject'=>$eschtask['subject'],

											'task_priority'=>'Normal',

											'task_status'=>'In Progress',

											'task_related'=>'C',

											'task_relatedto'=>0,//this will be replaced by contact id

											'share_user_id'=>$this->_user_id,

											'task_duedate'=>$eschtask['duedate'],

											'task_info'=>$eschtask['info']

											);

								$eschtasks[] = $taskdata;

							}

							$bkey++;

						}

						//if($eschtasks) $Contact_email_info['task_info'] = json_encode($eschtasks);

					}

					

					foreach($contacts_List as $reccontact) {

						if(!$oneContactId) $oneContactId = $reccontact->record_id;

						$Contact_email_info['sch_contact'] = $reccontact->record_id;

						$this->crm->save_scheduled_email($Contact_email_info);

						//save follow up tasks bulk with contact id

						if($eschtasks) {

							foreach($eschtasks as $etask) {

								$etask['task_relatedto'] = $reccontact->record_id;

								$tid = $this->crm->save_task($etask,0);

							}

						}

					}

					echo "SUCCESSContact@".$oneContactId;

					exit;

				} else {

					echo "There are no contacts in that selected list\n";

					exit;

				}

			  }

			  

			 

			 /*Short Code List*/ 

			if($record['contact']) $cid = $record['contact'];

			else $cid = $parent_id;

			$contacts_List = $this->crm->get_contact($cid);

			$user_id = $contacts_List['userid'];

			$appuser = $this->home->get_single_user_info($user_id);	

			//echo '<pre>'; print_r($appuser); echo '</pre>'; exit;

			if($record['cname']) $cfname = $record['cname'];

			else $cfname = $contacts_List['user_first'];

			if($record['lname']) $clname = $record['lname'];

			else $clname = $contacts_List['user_last'];			

			if($record['account_id']) $acid = $record['account_id'];

			else $acid = $contacts_List['account_id'];			

			$arecord = $this->crm->get_account($acid);			

			$acname = $arecord['account_name'];

			$ctitle = $contacts_List['user_title'];

			$cwebsite = $contacts_List['website'];

			$cphone = $contacts_List['phone'];

			$address_List = $this->crm->get_address($parent_id,'amail','C');

			$street = $address_List['street'];

			$city = $address_List['city'];

			$state = $address_List['state'];

			$zipcode = $address_List['zipcode'];

			$country = $address_List['country'];			

			$ufname = $appuser->first_name;

			$ulname = $appuser->last_name;

			$uphone = $appuser->phone;	

			$ced_esign = $aMember['email_signature'];

			$where = array();

			$where['user_id'] = $user_id;

			$where['field_type'] = 'smtp';

			$user_info = $this->home->getUserData($where);

			if($user_info && isset($user_info[0]))

			{

				$k = unserialize($user_info[0]->value);

				if(isset($k['email_signature']) && $k['email_signature'])

				{

					$ced_esign =  $k['email_signature'];

				}

			}

			$email_signature = $ced_esign;

			

			//echo $cfname."<br/>".$clname."<br/>".$ufname."<br/>".$ulname."<br/>".$acname."<br/>".$ctitle."<br/>".$cwebsite."<br/>".$cphone."<br/>".$uphone."<br/>".$street."<br/>".$city."<br/>".$state."<br/>".$zipcode."<br/>".$country;

			//exit;

			

			

			//echo $email_content;

			$email_content = str_replace("{contact first name}",$cfname,$email_content);							

			$email_content = str_replace("{contact last name}",$clname,$email_content);							

			$email_content = str_replace("{user first name}",$ufname,$email_content);

			$email_content = str_replace("{user last name}",$ulname,$email_content);

			$email_content = str_replace("{account name}",$acname,$email_content);

			$email_content = str_replace("{contact title}",$ctitle,$email_content);

			$email_content = str_replace("{contact phone}",$cphone,$email_content);

			$email_content = str_replace("{user phone}",$uphone,$email_content);

			$email_content = str_replace("{contact website}",$cwebsite,$email_content);

			$email_content = str_replace("{mailing street}",$street,$email_content);

			$email_content = str_replace("{mailing city}",$city,$email_content);

			$email_content = str_replace("{mailing state}",$state,$email_content);

			$email_content = str_replace("{mailing zip}",$zipcode,$email_content);

			$email_content = str_replace("{mailing country}",$country,$email_content);

			$email_content = str_replace("{email signature}",$email_signature,$email_content);	

			

			//echo $record['lname']."<br/>".$street."<br/>".$city."<br/>".$state."<br/>".$zip."<br/>".$country;

			//exit;



			  //Send grid

				$eparams = array(

					'toname'=>$toname,

					'tomail'=>$record['cemail'],

					'fromname'=>$smtp['fromname'],

					'frommail'=>$smtp['fromemail'],

					'subject'=>$record['subject'],

					'body'=>$email_content

				);

				$emailSent = sendgrid_mail($eparams);

				if($emailSent == false) {

					echo "Unable to send mail \n";	

					exit;	

				}



			  echo "SUCCESS@$parent_id";



			  //Save sent email subjects

				$email_subjects = array();

				$where = array();

				$where['user_id'] = $this->_user_id;

				$where['field_type'] = 'Email-Subjects';

				$esuser_info = $this->home->getUserData($where);

				if($esuser_info) {					

					if($esuser_info[0]->value) {

						$email_subjects = $esuser_info[0]->value;

						$email_subjects = json_decode($email_subjects);

						$email_subjects = (array)$email_subjects;

					}

				}

				$email_subjects["".$track_data['etime'].""] = $track_data['subject'];

				$email_subjects = json_encode($email_subjects);

				$edata = array();

				$edata['value'] = $email_subjects;

				if($esuser_info) $this->home->saveUserData($edata,$where);

				else {

					$edata['user_id'] = $this->_user_id;

					$edata['field_type'] = 'Email-Subjects';

					$this->home->saveUserData($edata);

				}

				//Save Schedule Follow up Task for first email sent

				if($blocktype && $schindxes) {

					$eml2 = -1;

					$schdate = time();

					foreach($blocktype as $bi=>$etblock) {

						//if($etblock=='email') $eml2++;

						if($etblock=='email') {

							if($eml2<>-1) {

								$schdate = $schdate+($record['schtype'][$eml2]==2?7:1)*(int)$record['schcount'][$eml2]*24*60*60;

							}

							$eml2++;

							continue; 

						}

						//if($eml2==2) break;

						//task

						if($etblock=='task') {

							$schindx = $slno[$bi];

							$schkey = array_search($schindx, $schindxes);

							$eschtask = array();

							if(isset($record['schs'][$schindx]) && $record['schs'][$schindx]) {

								$sch_subject = $record['schs'][$schindx]=="O"?$record['sch_txts'][$schkey]:$record['schs'][$schindx];				

								$task_schdate = $schdate+($record['tsk_schtypes'][$schkey]==2?7:1)*(int)$record['tsk_schcounts'][$schkey]*24*60*60;

								$eschtask['task_info']	  = $record['schnotess'][$schkey];				



								$taskdata = array(

											'task_subject'=>$sch_subject,

											'task_priority'=>'Normal',

											'task_status'=>'In Progress',

											'task_related'=>'C',

											'task_relatedto'=>$parent_id,

											'share_user_id'=>$this->_user_id,

											'task_duedate'=>date("Y-m-d",$task_schdate),

											'task_info'=>$record['schnotess'][$schkey]

											);

								$tid = $this->crm->save_task($taskdata,0);				

							}

						}

					}

				}



			  //Save an interaction Log



			  //$categories = crm_options();

			  $categories = crm_introptions();



				$c=2;



				$s=1;



				$opt=1;



				$sec_val = $categories['category'][$c][$s];



				$sec_opt = $sec_val['options'];



				$points = $sec_opt[$opt]['points'];



				$pursuit = $sec_opt[$opt]['pursuit'];



				$iname = $sec_opt[$opt]['name'];



				$idate = date("Y-m-d");				



				//Create completed task : Log a Call



				//$task_email_content=str_replace("\n","",$task_email_content);



				$taskdata = array(



							'task_subject'=>"Email Sent",



							'task_name'=>$record['subject'],//$template_name,



							'task_priority'=>'Normal',



							'task_status'=>'Completed',



							'task_duedate'=>$idate,



							'task_related'=>'C',



							'task_relatedto'=>$parent_id,



							'share_user_id'=>$this->_user_id,  



							'task_created'=>$idate." 00:00:00",



							'task_modified'=>$idate." 00:00:00",



							'task_info'=>$task_email_content



							);



				$tid = $this->crm->save_task($taskdata,0);



				



				//check points and save



				$where = array('contact'=>$parent_id,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');



				$cont_points = $this->crm->get_points($where);



				//print_r($cont_points);



				if($cont_points) {



					$update_data = array(



							'contact'=>$parent_id,



							'cat'=>$c,



							'pdate'=>$idate,



							'rctype'=>'C'



							);



					$points_data = array(



							'intpoints'=>$cont_points['intpoints']+$points,



							'purpoints'=>$cont_points['purpoints']+$pursuit,



							'taskid'=>$tid



							);



					$this->crm->save_points($points_data,$update_data);



				} else {



					$points_data = array(



							'contact'=>$parent_id,



							'rctype'=>'C',



							'pdate'=>$idate,



							'intpoints'=>$points,



							'purpoints'=>$pursuit,



							'taskid'=>$tid,



							'cat'=>$c



							);



					$this->crm->save_points($points_data);



				}



				//Interaction Usage

				//Subject line

				$subjectLine = $record['subject'];

				$intr_sno=$c."-".$s."-".$opt;



				//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate);

				$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$parent_id);

				$intrdata = $this->crm->check_interaction_date($where);



				if($intrdata) {



					$update = array('intr_count'=>$intrdata['intr_count']+1);



					//update email template info



					if($template_name) {



						if($intrdata['intr_info']) {



							$etinfo = json_decode($intrdata['intr_info']);



							if(isset($etinfo->tnames)) {



								$etinfo->tnames[]=$template_name;



							} else {



								$etinfo->tnames=array($template_name);



							}

							//Subject line							

							if(isset($etinfo->subjects)) {

								$etinfo->subjects->$tid=$subjectLine;

							} else {

								$etinfo->subjects=array($tid=>$subjectLine);

							}



							$etinfo->tnames = array_unique($etinfo->tnames);



							$etinfo = json_encode($etinfo);



						} else {



							$etinfo = array('tnames'=>array($template_name));

							//Subject line

							$etinfo['subjects']=array($tid=>$subjectLine);

							$etinfo = json_encode($etinfo);



						}



						$update['intr_info']=$etinfo;



					}



					$this->crm->save_interaction_date($update,$intrdata);



				} else {



					$update = array(



						'intr_cat'=>$c,



						'intr_sect'=>$s,



						'intr_opt'=>$opt,



						'intr_otype'=>'I',



						'intr_sno'=>$intr_sno,



						'intr_rctype'=>'C',



						'intr_recid'=>$parent_id,



						'intr_task'=>$tid,



						'intr_date'=>$idate);



					//Insert Email template info



					if($template_name) {



						$etinfo = array('tnames'=>array($template_name));

						//Subject line

						$etinfo['subjects']=array($tid=>$subjectLine);

						$etinfo = json_encode($etinfo);



						$update['intr_info']=$etinfo;



					}	



					$this->crm->save_interaction_date($update);



				}				



			  exit;



			/*} catch (phpmailerException $e) {



			  echo "Unable to send mail, please check below error \n";



			  echo $e->errorMessage(); //Pretty error messages from PHPMailer



			  if($savedEids) echo "SAVEDTEMPLATEIDS".$savedEids;



			  exit;*/



			} catch (Exception $e) {



			  echo "Unable to send mail, please check below error \n";	



			  echo $e->getMessage(); //Boring error messages from anything else!



			  if($savedEids) echo "SAVEDTEMPLATEIDS".$savedEids;



			  exit;



			}



			//When email sent then add quality points to User interactions



			



		}				



		



		$this->_data['breadcrumbs']=$breadcrumbs;



		$this->_data['allContacts'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);



		//All email templates with user modified data



		$alltemplates=$this->campaign->get_Email_templates();



		$email_templates = array();



		foreach($alltemplates as $atemplate) {



			$etemplate = $this->campaign->get_etemplate($atemplate->temp_id,$cmpid);



			if($etemplate && $etemplate->temp_title) $atemplate->temp_title=$etemplate->temp_title;



			$email_templates[] = $atemplate;



		}

		

		

		//Editable template

		

		$etemplates = $this->campaign->get_etemplates($this->_data['campaign_info']->campaign_id);

		$this->_data['etemplate'] = $etemplates['templates'];

		$this->_data['temphides'] = $etemplates['hidetemp'];		

		$this->_data['templates']=$email_templates;



		//Saved email templates list



		$uemail_templates=$this->crm->get_uemail_templates();



		if($uemail_templates) {



			$et1='';



			$et2='';



			foreach($uemail_templates as $et) {				



				if($et->schparent==-1) $et1 .='<option value="T'.$et->tid.'">'.$et->tempname.'</option>';				



				else if($et->schparent==0) $et2 .='<option value="'.$et->tid.'">'.($et->tempname?$et->tempname:$et->subject).'</option>';



			}



			if($et1) $et1='<optgroup label="Email Threads">'.$et1.'</optgroup>';



			if($et2) $et2='<optgroup label="Email Templates">'.$et2.'</optgroup>';



			$uemail_templates='<option value="">Select Saved Email Template</option>'.$et1.$et2;



			$this->_data['uemail_templates']=$uemail_templates;



		}



		



		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();



		$this->_data['drop_company'] = $this->campaign->get_drop_company();



		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();

		//Contact List

		$this->_data['catlist'] = $this->crm->get_all_catlist(array('section'=>1));

		

		$esuemail_count = $this->home->get_single_user_info($this->_user_id);

		$ecount = $esuemail_count->email_count;

		

		$this->_data['emails_stmonth'] = $ecount;

		

		$this->_data['emails_atsend'] = 10000-$ecount;

		

		$this->_data['emails_sbsent'] = $this->crm->get_all_catlist(array('section'=>1));



		$this->load->view('crm/sendmail', $this->_data);



	}	
	
	
	public function mkeySave()
    {
        $opt = $_POST['mKey'];

        $user_id = $_SESSION['ss_user_id'];

        $sql = 'select * from user_info where user_id=' . $user_id . " and field_type='mailchimp'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $sql = "update user_info set  value='" . $opt . "' where user_id='" . $user_id . "' and field_type='mailchimp'";

            $this->db->query($sql);

            echo 'API Key Updated';
        } else {
           $sql = "insert into user_info (user_id,field_type,value) values ('" . $user_id . "','mailchimp','" . $opt . "')";

            $this->db->query($sql);

            echo 'API Key Updated';
        }
    }



	//Get saved Email template



	public function get_saved_emailTemplate($template_id) {



		$emailTemplate=$this->crm->get_uemail_template($template_id);

		$setinfo = "";

		if($emailTemplate) $setinfo = $emailTemplate['content']."[SUBJECT@SUBJECT]".$emailTemplate['subject'];

		//Thread Tasks

		$blockno = $this->input->post('blockno');

		$bno = $blockno;

		$thread_id = $template_id;		

		$thread_tasks=$this->crm->get_email_tasks($thread_id);

		$email_tasks = array();

		if($thread_tasks) {

			foreach($thread_tasks as $etask) {

				if(!isset($email_tasks[$etask->email_id])) $email_tasks[$etask->email_id] = array();

				$email_tasks[$etask->email_id][] = $etask;

				$bno++;

			}

		}

		$this->_data['email_tasks'] = $email_tasks;

		$this->_data['thread_id'] = $thread_id;

		$this->_data['blockno'] = $blockno;

		$tasks_html = $this->load->view('crm/email-task.php', $this->_data, TRUE);

		$jsn = array('template'=>$setinfo,'tasks'=>$tasks_html,'bno'=>$bno);

		echo json_encode($jsn);

		return;



	}



	



	//Delete user notifications



	public function clear_notifys() {



		//$this->crm->delete_notifications();



		$this->crm->update_notifications();



		exit;



	}



	//Scheduled emails



	function emails($action = NULL)



	{		



		$this->_data['crmlite'] = "contact";



		$pam3 = $this->uri->segment(3);



		$pam4 = $this->uri->segment(4);



		$pam5 = $this->uri->segment(5);



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$this->crm->delete_schedule_email($id);



			redirect($_SERVER['HTTP_REFERER']);



		}



		$breadcrumbs = array();		



		if((int)$pam4 && ($pam3=="contacts")) {



			$parent_id = (int)$pam4;



			$parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/contacts');



			$this->_data['record'] = $record;



			$parent_section='contacts';



			$crmlite="contact";



			if($pam3=='contacts') {$parent_section='contacts';$crmlite="contact";



				$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			}



			$breadcrumbs[] = array('label'=>'Emails','url'=>base_url("crm/emails/$parent_section/".$parent_id));		



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $parent_id;



		}



		//edit / view



		if((int)$pam4 && ($pam3=="view")) {



			$id = (int)$pam4;



			$record = $this->crm->get_scheduled_email($id);



			if(!$record) redirect(base_url() . 'crm/contacts');



			$crmlite="contact";			



			$parent_section='contacts';$crmlite="contact";



			$parent_record =$this->crm->get_notes_parent($record['sch_contact'],'C');



			if($parent_record) {



				$this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);



				$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$record['sch_contact']));



			}



			$breadcrumbs[] = array('label'=>'Emails','url'=>base_url("crm/emails/$parent_section/".$record['sch_contact']));



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $record['sch_contact'];



			$this->_data['record'] = $record;



		}



		$this->_data['breadcrumbs']=$breadcrumbs;



		if($pam3=="view") {



			$this->load->view('crm/semail-view', $this->_data);



		} else {



			$this->_data['parent_section']="contacts";



			$this->_data['parent_id']=$parent_id;



			$this->_data['emails_list'] = $this->crm->get_scheduled_contact_emails($parent_id);



			$this->load->view('crm/semails-list', $this->_data);



		}



	}



	//EMAIL Guesser
	
	
	function emailCheck()
	{
		$record=$this->input->post('eguess');

			

			

				if(empty($record['fname'])) $er['fname']="First Name required";

				if(empty($record['lname'])) $er['lname']="Last Name required";

				else {

					$website = str_replace(" ", "", $record['website']);

					$website = str_replace("http://", "", $website);

					$website = str_replace("https://", "", $website);

					$website = str_replace("www.", "", $website);

					$website2 = explode(".", $website);

					if(count($website2)==1) $er['website']="Invalid Website field";

					else $record['website'] = $website;

				}

				//else if(strpos($record['website'],"www")!==FALSE) $er['website']="Dont use www for Website field";

				//else if(strpos($record['website'],"@")!==FALSE) $er['website']="Dont use @ for Website field";	

			


			if($er) {



				$response = implode("\n",$er);



				echo $response;



				exit;



			}	



			



			



			$email_list = array();



			

				$fname = str_replace(" ","",$record['fname']);



				$fname = strtolower($fname);



				$lname = str_replace(" ","",$record['lname']);



				$lname = strtolower($lname);



				$website = str_replace(" ","",$record['website']);



				$website = strtolower($website);	



				$email_list[] = $fname."_".$lname."@".$website;



				$email_list[] = $fname.".".$lname."@".$website;



				$email_list[] = $fname."@".$website;



				$email_list[] = $lname."@".$website;



				$email_list[] = substr($fname,0,1).$lname."@".$website;



				$email_list[] = $fname.substr($lname,0,1)."@".$website;



				$email_list[] = $fname.$lname."@".$website;

			

			

 

			// set API Access Key



			//$access_key = '62ac6023f98740cf95e804eab99fce04';



			//$access_key = '463093afe223f38f0a786aa03694571b';



			//Licensed



			$access_key = '3488d72fa942f66f449dff924c19c60f';



					



			$edata = '<br><table cellpadding="0" cellspacing="0" border="0" style="text-align: center;"><tr><th>S.No</th><th>Email Address</th><th>Format</th><th>SMTP</th><th></th></tr>';



			$eDomain = "";



			$ei=1;



			foreach($email_list as $ei=>$eml) {



				// Initialize CURL:



				$ch = curl_init('http://apilayer.net/api/check?access_key='.$access_key.'&email='.$eml.'');  



				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);				



				// Store the data:



				$json = curl_exec($ch);



				curl_close($ch);



				//print_r($json);



				// Decode JSON response:



				$validationResult = json_decode($json, true);



				$bold=$validationResult['smtp_check']=="true"?' style="color: green;font-weight: bold;"':'';



				$edata .= '<tr'.$bold.'><td>'.($ei+1).'</td><td style="text-align: left;">'.$eml.'</td>';



				if(isset($validationResult['error'])) {



					$edata .= "<td></td><td></td>";



					$edata .= "<td>".$validationResult['error']['info']."</td>";



				} else {



					$edata .= "<td>".($validationResult['format_valid']=="true"?"Valid":"Invalid")."</td>";



					//$eDomain = "<b>Domain</b>: ".($validationResult['mx_found']=="true"?"Valid":"Invalid");



					$edata .= "<td>".($validationResult['smtp_check']=="true"?"Valid":"Invalid")."</td><td></td>";	



					$edata .= "<td>";



					if($validationResult['smtp_check']=="true") 



						$edata .= '<a href="javascript:void(0);" target="_blank" onclick="selectemail(\''.$eml.'\');" class="buttonM bGreen">Select Email</a>'; 



					$edata .= "</td>";




				}



				$edata .= "</tr>";



			}



			$edata .= "</table>";



			$edata = "SUCCESS".$eDomain.$edata;



			echo $edata;



			exit;

	}




	public function eguesser($action=NULL) {	



		$this->_data['crmlite'] = "eguesser";	



		$breadcrumbs = array();



		$breadcrumbs[] = array('label'=>'Email Guesser','url'=>base_url('crm/eguesser'));



		$this->_data['breadcrumbs']=$breadcrumbs;



		



		//Generate



		if($this->input->post('action')=="save") {



			$record=$this->input->post('eguess');



			if($record['egtype']=="2") {

				if(empty($record['email'])) $er['email']="Exact email required";

				else {

					$this->load->helper('email');

					if (!valid_email($record['email'])) $er['email']="Enter valid email address";

				}

			} else {

				if(empty($record['fname'])) $er['fname']="First Name required";



				if(empty($record['lname'])) $er['lname']="Last Name required";



				if(empty($record['website'])) $er['website']="Website required";

				else {

					$website = str_replace(" ", "", $record['website']);

					$website = str_replace("http://", "", $website);

					$website = str_replace("https://", "", $website);

					$website = str_replace("www.", "", $website);

					$website2 = explode(".", $website);

					if(count($website2)==1) $er['website']="Invalid Website field";

					else $record['website'] = $website;

				}

			}



			//Error sending



			if($er) {



				$response = implode("\n",$er);



				echo $response;



				exit;



			}	



			$email_list = array();



			if($record['egtype']=="2") {

				$email_list[] = $record['email'];

			} else {

				$fname = str_replace(" ","",$record['fname']);



				$fname = strtolower($fname);



				$lname = str_replace(" ","",$record['lname']);



				$lname = strtolower($lname);



				$website = str_replace(" ","",$record['website']);



				$website = strtolower($website);	



				$email_list[] = $fname."_".$lname."@".$website;



				$email_list[] = $fname.".".$lname."@".$website;



				$email_list[] = $fname."@".$website;



				$email_list[] = $lname."@".$website;



				$email_list[] = substr($fname,0,1).$lname."@".$website;



				$email_list[] = $fname.substr($lname,0,1)."@".$website;



				$email_list[] = $fname.$lname."@".$website;

			}



			



			// set API Access Key



			//$access_key = '62ac6023f98740cf95e804eab99fce04';



			//$access_key = '463093afe223f38f0a786aa03694571b';



			//Licensed



			$access_key = '3488d72fa942f66f449dff924c19c60f';



					



			$edata = '<br><table cellpadding="0" cellspacing="0" border="0" style="text-align: center;"><tr><th>S.No</th><th>Email Address</th><th>Format</th><th>SMTP</th><th></th></tr>';



			$eDomain = "";



			$ei=1;



			foreach($email_list as $ei=>$eml) {



				// Initialize CURL:



				$ch = curl_init('http://apilayer.net/api/check?access_key='.$access_key.'&email='.$eml.'');  



				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);				



				// Store the data:



				$json = curl_exec($ch);



				curl_close($ch);



				//print_r($json);



				// Decode JSON response:



				$validationResult = json_decode($json, true);



				$bold=$validationResult['smtp_check']=="true"?' style="color: green;font-weight: bold;"':'';



				$edata .= '<tr'.$bold.'><td>'.($ei+1).'</td><td style="text-align: left;">'.$eml.'</td>';



				if(isset($validationResult['error'])) {



					$edata .= "<td></td><td></td>";



					$edata .= "<td>".$validationResult['error']['info']."</td>";



				} else {



					$edata .= "<td>".($validationResult['format_valid']=="true"?"Valid":"Invalid")."</td>";



					//$eDomain = "<b>Domain</b>: ".($validationResult['mx_found']=="true"?"Valid":"Invalid");



					$edata .= "<td>".($validationResult['smtp_check']=="true"?"Valid":"Invalid")."</td>";



					$edata .= "<td>";



					if($validationResult['smtp_check']=="true") 



						$edata .= '<a href="'.base_url('crm/contacts/edit/cc').time().'" target="_blank" onclick="return create_contact(\''.$eml.'\',\''.time().'\');" class="buttonM bGreen">Create Contact</a>';



					$edata .= "</td>";



				}



				$edata .= "</tr>";



			}



			$edata .= "</table>";



			$edata = "SUCCESS".$eDomain.$edata;



			echo $edata;



			exit;



		}



		$this->load->view('crm/email-guesser', $this->_data);



	}



	//End of EMAIL







	//DOCUMENTS  - Contacts , Accounts



	//Notes



	function docs($action = NULL)



	{



		//3-contacts/4-contactid/5-edit



		//3-contacts/4-contactid



		//3-view/4-notesid



		//3-edit/4-notesid



		//3-delete/4-notesid



		



		



		$pam3 = $this->uri->segment(3);



		$pam4 = $this->uri->segment(4);



		$pam5 = $this->uri->segment(5);



		//echo "1.$pam3 2.$pam4 3.$pam5 ";



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;



			$record = $this->crm->get_doc($id);



			if(!$record) redirect(base_url() . 'crm/contacts');



			if($record['upload']) {				



				$filename=$record['upload'];



				$document=$_SERVER['DOCUMENT_ROOT']."/betapro/upload/".$filename;



				unlink($document);				



			}



			$this->crm->delete_doc($id);



			$parent_section='contacts';



			if($record['notes_parent']=='C') $parent_section='contacts';



			else if($record['notes_parent']=='A') $parent_section='accounts';



			//else if($record['notes_parent']=='O') $parent_section='opportunities';



			redirect(base_url() . "crm/$parent_section/view/".$record['notes_parentid']);



		}



		$breadcrumbs = array();		



		//add/list



		if((int)$pam4 && ($pam3=="contacts" || $pam3=="accounts")) {



			$parent_id = (int)$pam4;



			if($pam3=='accounts') $parent_record =$this->crm->get_notes_parent($parent_id,'A');



			//else if($pam3=='opportunities') $parent_record =$this->crm->get_notes_parent($parent_id,'O');



			else $parent_record =$this->crm->get_notes_parent($parent_id,'C');



			if(!$parent_record) redirect(base_url() . 'crm/contacts');



			$this->_data['record'] = $record;



			$parent_section='contacts';



			$crmlite="contact";			



			if($pam3=='contacts') {$parent_section='contacts';$crmlite="contact";



				$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$parent_id));



			}



			else if($pam3=='accounts') {$parent_section='accounts';$crmlite="account";



				$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



				$breadcrumbs[] = array('label'=>ucfirst($parent_record['account_name']),'url'=>base_url('crm/accounts/view/'.$parent_id));



			}



			$breadcrumbs[] = array('label'=>'Document','url'=>base_url("crm/docs/$parent_section/".$parent_id));



			//else if($record['notes_parent']=='O') {$parent_section='opportunities';$crmlite="opportunity";}			



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $parent_id;



		}



		//edit / view



		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;



			$record = $this->crm->get_doc($id);



			if(!$record) redirect(base_url() . 'crm/contacts');			



			$crmlite="contact";



			



			if($record['notes_parent']=='C') {$parent_section='contacts';$crmlite="contact";



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'C');



				if($parent_record) {					



					$this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);



					$breadcrumbs[] = array('label'=>'Contacts','url'=>base_url('crm/contacts'));



					$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('crm/contacts/view/'.$record['notes_parentid']));



				}



			}



			else if($record['notes_parent']=='A') {$parent_section='accounts';$crmlite="account";



				$parent_record =$this->crm->get_notes_parent($record['notes_parentid'],'A');



				if($parent_record) {					



					$this->_data['parent_name']=ucfirst($parent_record['account_name']);



					$breadcrumbs[] = array('label'=>'Accounts','url'=>base_url('crm/accounts'));



					$breadcrumbs[] = array('label'=>ucfirst($parent_record['account_name']),'url'=>base_url('crm/accounts/view/'.$record['notes_parentid']));



				}



			}



			$breadcrumbs[] = array('label'=>'Document','url'=>base_url("crm/docs/$parent_section/".$record['notes_parentid']));



			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;



			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);



			$record['share_user_title']=ucfirst($sUser[0]->usrname);



			$this->_data['parent_section'] = $parent_section;



			$this->_data['parent_id'] = $record['notes_parentid'];



			$this->_data['record'] = $record;



			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');



		}



		$this->_data['crmlite'] = $crmlite;



		$this->_data['breadcrumbs']=$breadcrumbs;



		//add/edit



		if( (($pam3=="contacts" || $pam3=="accounts") && $pam5=="add") || ($pam3=="edit" && $pam4) ) {



			if($pam3=="edit" && $pam4) $id = (int)$pam4;



			if($id) {



				if($record['notes_parent']=='C') {$parent_section='contacts';$crmlite="contact";}



				else if($record['notes_parent']=='A') {$parent_section='accounts';$crmlite="account";}



				$this->_data['parent_id'] = $record['notes_parentid'];



			} else $parent_section=$pam3;



			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			$this->_data['parent_section'] = $parent_section;



			if($this->input->post('action')=="save") {



				$record=$this->input->post('record');



				$er = array();



				if(empty($record['notes_title'])) $er['notes_title']="Subject required";



				//document



				if(!empty($_FILES['upload']['name'])){



					$upload['upload_path'] = './upload/';



					$upload['allowed_types'] = 'gif|png|jpg|doc|docx|xls|xlsx|pdf';



					$upload['max_size'] = '2048000';



					//$ext = end(explode(".", $_FILES['upload']));



					$upload['file_name'] = time()."_".basename($_FILES['upload']['name']);



					$this->load->library('upload', $upload);



					if (!$this->upload->do_upload('upload')) {



						$error = array('error' => $this->upload->display_errors());



						$er=$error;



						//print_r($error);



					} else { 								



						$data = $this->upload->data();



						//print_r($data);



						$filename = $data['file_name'];



						$record['upload']=$filename;



					}



				}



				if(!$er) {



					if($pam3=='contacts') $parent_type='C';



					else if($pam3=='accounts') $parent_type='A';



					if($parent_type) $record['notes_parent']=$parent_type;



					if($parent_id) $record['notes_parentid']=$parent_id;



					$cid = $this->crm->save_doc($record,$id);



					//Redirect to Related Parent



					redirect(base_url() . 'crm/'.$this->_data['parent_section'].'/view/'.$this->_data['parent_id']);



					//redirect(base_url() . 'crm/notes/view/'.$cid);



				}



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			$this->_data['crmlite'] = $crmlite;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$this->load->view('crm/doc-edit', $this->_data);



		} else {



			if($pam3=='contacts') $parent_type='C';



			else if($pam3=='accounts') $parent_type='A';



			else if($pam3=='opportunities') $parent_type='O';



			$this->_data['parent_section']=$pam3;



			$this->_data['parent_id']=$parent_id;



			$this->_data['notes'] = $this->crm->get_all_notes($parent_id,$parent_type);



			$this->load->view('crm/notes-list', $this->_data);



		}



	}



	



	//Category Lists: Groups for Contact/Accounts



	function lists($action = NULL)



	{



		$this->_data['crmlite'] = 'lists';



		$pam3 = $this->uri->segment(3);//section



		$pam4 = $this->uri->segment(4);//id



		$pam5 = $this->uri->segment(5);//extra slug parameter



		$mpaged = 0;

		if ($this->input->is_ajax_request()) {

		   $mpaged = 1;

		}



		$section = $pam3==2?2:1;

		$this->_data['section']=$section;



		$secUrl = base_url() .'crm/lists'.($section==2?'/2':'');



		//delete all		



		if($this->input->post('action')=="deleteall") {			



			$record=$this->input->post('recids');



			if($record) {



				foreach($record as $rcid) $this->crm->delete_catlist($rcid);



			}



			redirect($secUrl);



		}



		//delete



		if((int)$pam4 && $pam3=="delete") {



			$id = (int)$pam4;

			$record = $this->crm->get_catlistrow($id);



			if(!$record) redirect($secUrl);



			$this->crm->delete_catlist($id);



			redirect($secUrl);



		}



		$breadcrumbs = array();



		$breadcrumbs[] = array('label'=>($section==2?'Account':'Contact').' Lists','url'=>$secUrl);



		//edit / view
		
		
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			 $shuser = $result['userfrom'];
			 $accessview =  $result['accessview'];
		}
		else $shuser = $user_id;


		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {



			$id = (int)$pam4;

			$record = $this->crm->get_catlistrow($id);



			if(!$record) redirect($secUrl);



			$section = $record['section'];

			$record['form'] = $record['form']?json_decode($record['form']):'';



			$secUrl = base_url() .'crm/lists'.($section==2?'/2':'');



			$this->_data['record'] = $record;

			$this->_data['section'] = $section;

			$breadcrumbs = array();

			$breadcrumbs[] = array('label'=>($section==2?'Account':'Contact').' Lists','url'=>$secUrl);

			$breadcrumbs[] = array('label'=>ucfirst($record[name]),'url'=>base_url('crm/lists/view/'.$id));

			if($pam3=="add") 

				$breadcrumbs[] = array('label'=>'Add '.($section==2?'Account':'Contact'),'url'=>base_url('crm/lists/add/'.$id));



			if($pam3=="view") {

				//delete all		

				if($this->input->post('action')=="records_deleteall") {					

					$record=$this->input->post('recids');

					if($record) {

						$rids = $record;

						$this->crm->delete_category_records($id,$rids);

						//foreach($record as $rcid) $this->crm->delete_category_records($rcid);

					}

					redirect(base_url('crm/lists/view/'.$id));

				}				

			}

		}



		$this->_data['secUrl']=$secUrl;



		$this->_data['breadcrumbs']=$breadcrumbs;

		//Save List record in ajax mode

		if($pam3=="view" && $mpaged && $this->input->post('action')=="saverecord") {

			//Save Record				

			if($this->input->post('action')=="saverecord") {



				$record=$this->input->post('record');

				$er = array();				

				if($section==2) {

					if(empty($record['account'])) $er['account']="Account required";

				} else {

					if(empty($record['contact'])) $er['contact']="Contact required";

				}

				if(!$er) {

					$recid = $section==2?$record['account']:$record['contact'];

					if($this->crm->get_category_record($id,$recid)) {

						echo "E";exit;

					} else {

						$info = array('category_id'=>$id,'record_id'=>$recid);

						$cid = $this->crm->save_category_record($info,$id);

						echo "R";exit;

					}	

				} else {

					echo "Error: ";

					echo implode("",$er);

					exit;

				}

				$this->_data['er']=$er;

				$this->_data['record']=$record;

			}

			$this->load->view('crm/category-record-add', $this->_data);	

		} else if($pam3=="view") {	



			//Search & Pagination

			$contactsurl = base_url('crm/lists/view/'.$id);

			$this->_data['pageurl']=$contactsurl;

			$pgoffset = $this->input->get('per_page')?$this->input->get('per_page'):0;

			$skey = $this->input->get('search')?$this->input->get('search'):'';

			//Sorting

			$sortcol = $this->input->get('col')?$this->input->get('col'):'';

			$sortval = $this->input->get('sort')?$this->input->get('sort'):'';

			if($section==2)

			$sortfields = array('name'=>'a.account_name','owner'=>'usrname','phone'=>'a.phone','qp'=>'qpoints');

			else

			$sortfields = array('name'=>'c.user_first','title'=>'c.user_title','account'=>'a.account_name','phone'=>'c.phone','email'=>'c.email','qp'=>'qpoints');

			if($sortcol && isset($sortfields[$sortcol])) {

				$sortcol2 = $sortfields[$sortcol];

				$sortval2 = $sortval=='desc'?'desc':'asc';

			} else {

				$sortcol2='';

				$sortval2='';

			}

			$this->_data['sortcol'] = $sortcol;

			$this->_data['sortval'] = $sortval;

			

			$qsearch = "";

			$sparam = "";

			$acsq = "";

			if($this->input->get('col') && $this->input->get('sort'))

			{

				$acsq .= " ORDER BY ".$this->input->get('col')." ".$this->input->get('sort');

			}

			if($skey) {

				/*if($section==2)

					$qsearch = "(a.account_name like '%$skey%' OR a.phone like '%$skey%')";

				else

					$qsearch = "(c.user_first like '%$skey%' OR c.user_last like '%$skey%' OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%')";*/



				$skey_parts = explode(" ",$skey);

				if($section==2){

					foreach($skey_parts as $skpart) {

						if($qsearch) $qsearch .=" OR ";

						$qsearch .= " a.account_name like '%$skpart%' OR a.phone like '%$skpart%' ";

					}

				}

				else

				{

					//$qsearch .= " c.user_first like '%$skpart%' OR c.user_last like '%$skpart%' OR c.user_title like '%$skpart%' OR c.phone like '%$skpart%' OR c.email like '%$skpart%' ";	

					$qsearch = " CONCAT( c.user_first,  ' ', c.user_last ) LIKE  '%$skey%'  OR c.user_title like '%$skey%' OR c.phone like '%$skey%' OR c.email like '%$skey%' ";

				

				}

				if($qsearch) $qsearch =" ($qsearch) ";

				$sparam = "search=$skey";

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="&col=".$this->input->get('col')."&sort=".$this->input->get('sort');

			}

			if(!$skey){

				if($this->input->get('col') && $this->input->get('sort')) $sparam .="col=".$this->input->get('col')."&sort=".$this->input->get('sort');

			}

			$total_records = $this->crm->get_category_records($id,$section,$qsearch);



			$this->load->library('pagination');

			$perpage = 50;

			$config['base_url'] = $contactsurl."/?".$sparam;

			$config['total_rows'] = $total_records;

			$config['per_page'] = $perpage;

			//$config['uri_segment'] = 3;

			$config['num_links'] = 5;

			$config['page_query_string'] = TRUE;

			$this->pagination->initialize($config);



			$this->_data['records_info'] = "";					

			$this->_data['contacts'] = array();

			if($total_records) {

				$to2 = $pgoffset?($pgoffset+$perpage):$perpage;

				if($to2>$total_records) $to2 = $total_records;

				if($section==2)

				{

					//$this->_data['accounts'] = $this->crm->get_all_accounts($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,$id,$sortcol2,$sortval2);

					

					//$this->_data['accounts'] = $this->crm->get_all_accounts($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,$id,$sortcol2,$sortval2);

					

					 //$results_f = $this->crm->get_all_accounts_latest($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,$id,$sortcol2,$sortval2);

					

						$this->_data['accounts'] = $this->crm->get_all_accounts($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,$id,$sortcol2,$sortval2);		

					  //$this->_data['accounts'] = $results_f['rowres'];

				  // CUSTOM LABELS AND RECORDS

		

					$contactlabels = $this->crm->getaccountLabels();

					/*echo "<pre>";

					   print_r($contactlabels);

					echo "</pre>";

					exit;*/

					$search_listc = $this->_data['accounts'];

										

			  

					$frow = array();

					foreach($search_listc as $kk => $crow)  {

					$ref_id = $crow->account_id;

					$username_val  =  $crow->user_first." ".$crow->user_last;

					$accountname_val  =  $crow->account_name;
					
					$share_user_title_val = $crow->usrname; 

					$crow = json_decode(json_encode($crow), true);

					$selectedcolumns = $contactlabels;

					 foreach($selectedcolumns  as $selk => $selval){

						if (array_key_exists($selk, $crow)) {

					}

					 else {

					  $crow[$selk] = "";

					 }

					} 

					

					//echo '<pre>'; print_r($selectedcolumns); echo '</pre>';

					

					$tempcrow = array();

					foreach($selectedcolumns as $kc => $kv){

					  $tempcrow[$kc] =  $crow[$kc];

					 

					}

					$tempcrow['account_id'] = $ref_id;

				

					//echo '<pre>'; print_r($tempcrow); echo '</pre>';

					//exit;

					foreach($tempcrow as $key => $val) { 

						

					if($key == 'contact_id'){

					  $tempcrow[$key] = $ref_id;

					}

					else if($key == 'user_first'){

					$tempcrow[$key] = $username_val;

					}
					
				  elseif ($key == 'share_user_title') {
						$tempcrow[$key] = $share_user_title_val;
					}

				  else if($key == 'account_id'){

					$tempcrow[$key] = $ref_id;

					}

					//else if($key == 'target'|| $key =='linkedin' || $key =='birthdate' || $key =='website' || $key =='lead_source' || $key =='user_title' || $key =='department' || $key =='create_date' || $key =='mobile'|| $key =='phone' || $key =='assistant' || $key =='unsubscribed' || $key =='email' || $key =='asst_phone' || $key =='other_phone' || $key =='description' || $key =='ipoints' || $key =='ppoints' || $key == 'account_id' || $key == 'address' || $key == 'first_name' || $key == 'report_id') { 

					

					else if($key == 'account_name'|| $key =='billing' || $key =='share_user_title' || $key =='phone' || $key =='ipoints' || $key =='account_parent' || $key =='customer_priority' || $key =='kcount' || $key =='account_site' || $key =='account_type' || $key =='industry' || $key =='revenue' || $key =='rating' || $key =='target' || $key =='phone'|| $key =='fax' || $key =='website' || $key =='ticker_symbol' || $key =='ownership' || $key =='employees' || $key =='siccode' || $key =='bstreet' || $key =='bcity' || $key =='bstate' || $key == 'bzipcode' || $key == 'bcountry' || $key == 'customer_priority' || $key == 'sla_expdate' || $key == 'numlocations' || $key == 'active' || $key == 'sla' || $key == 'sla_serialno' || $key == 'upsell_oppt' || $key == 'description') { 

						   

					 

					} else {

					

					  $rces  = get_custom_fields($key,$ref_id);

					

					  $tempcrow[$key] = $rces[0]->cv;

					

					}

				   }

				   $frow[] = $tempcrow;

				} 

					

					//echo '<pre>'; print_r($frow); echo '</pre>';

					//exit;

					 

					$where = array();

				 $custom_field_labels  = array();

				$where['user_id'] = $shuser;

				$where['field_type'] = 'customa';

				$user_info = $this->home->getUserData($where);

			//	echo $this->db->last_query();

				

				

				if($user_info) $user_info = $user_info[0];

	

				$custom = array();

				if(isset($user_info->value)) {

					$custom=unserialize($user_info->value);	

				}

				//echo '<pre>'; print_r($custom); echo '</pre>';

				//exit;  

				if($custom) {

					foreach($custom as $ck=>$cv) $layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

				} 

				

				 $custom_field_labels = $layout_fields;

					

					$layout_fields = layout_fields();

				 

				$this->_data['contact_customField_values']=$custom_field_labels;

				$this->_data['layout_fields']=$layout_fields;	

					

						/*echo "<pre>";

			   print_r($this->_data['contact_customField_values']);

			echo "</pre>";*/

			$this->_data['selectedcolumns']=$contactlabels;

			$this->_data['columnlabels'] =  acol_fields();

			$this->_data['cid'] =  $id;

			$this->_data['contacts'] = $frow; 

			

			//echo '<pre>'; print_r($this->_data['contacts']); echo '</pre>';

			// END CUSTOM LABELS AND RECORDS

				}

				else

				{

						$this->_data['contacts'] = $this->crm->get_all_contacts($owner,$target,$this->_parent_users,50,$qsearch,$pgoffset,$id,$sortcol2,$sortval2);

						$contactlabels = $this->crm->getcontactLabels();

						$search_listc = $this->_data['contacts'];

						

						$frow = array();

						

						foreach($search_listc as $kk => $crow)  {

							$ref_id = $crow->contact_id;

							$username_val  =  $crow->user_first." ".$crow->user_last;

							$accountname_val  =  $crow->account_name;
							
							$share_user_title_val = $crow->usrname;

							$crow = json_decode(json_encode($crow), true);

							$selectedcolumns = $contactlabels;

							 foreach($selectedcolumns  as $selk => $selval){

								if (array_key_exists($selk, $crow)) {

							}

							 else {

							  $crow[$selk] = "";

							 }

							} 

							

							$tempcrow = array();

							foreach($selectedcolumns as $kc => $kv){

							  $tempcrow[$kc] =  $crow[$kc];

							 

							}

							$tempcrow['contact_id'] = $ref_id;

							

							$tempcrow = array();

							foreach($selectedcolumns as $kc => $kv){

							  $tempcrow[$kc] =  $crow[$kc];							 

							}

							$tempcrow['contact_id'] = $ref_id;

							

							foreach($tempcrow as $key => $val) { 							

								if($key == 'contact_id'){

								  $tempcrow[$key] = $ref_id;

								}

								else if($key == 'user_first'){

								$tempcrow[$key] = $username_val;

								}
								
								elseif ($key == 'share_user_title') {
									$tempcrow[$key] = $share_user_title_val;
								}

								else if($key == 'account_id'){

								$tempcrow[$key] = $accountname_val;

								}

								else if($key == 'target'|| $key =='linkedin' || $key =='birthdate' || $key =='website' || $key =='lead_source' || $key =='user_title' || $key =='department' || $key =='create_date' || $key =='mobile'|| $key =='phone' || $key =='assistant' || $key =='unsubscribed' || $key =='email' || $key =='asst_phone' || $key =='other_phone' || $key =='description' || $key =='ipoints' || $key =='ppoints' || $key == 'account_id' || $key == 'address' || $key == 'first_name' || $key == 'report_id') { 

									   

								 

								} else {

								

								  $rces  = get_custom_fields($key,$ref_id);

								

								  $tempcrow[$key] = $rces[0]->cv;

								

								}

							   }

							   

							   $frow[] = $tempcrow;

						}	

						

						$where = array();

						 $custom_field_labels  = array();

						$where['user_id'] = $this->_user_id;

						$where['field_type'] = 'custom';

						$user_info = $this->home->getUserData($where);

						if($user_info) $user_info = $user_info[0];

			

						$custom = array();

						if(isset($user_info->value)) {

							$custom=unserialize($user_info->value);	

						}

						if($custom) {

							foreach($custom as $ck=>$cv) $layout_fields[$ck]=array('label'=>$cv,'type'=>'custom');

						} 

						

						 $custom_field_labels = $layout_fields;

							

							$layout_fields = layout_fields();

						 

						$this->_data['contact_customField_values']=$custom_field_labels;

						$this->_data['layout_fields']=$layout_fields;	

							

								/*echo "<pre>";

					   print_r($this->_data['contact_customField_values']);

					echo "</pre>";*/

					$this->_data['selectedcolumns']=$contactlabels;

					$this->_data['columnlabels'] =  col_fields();

					$this->_data['cid'] =  $id;

					$this->_data['contacts'] = $frow; 

					// echo '<pre>'; print_r($this->_data['contacts']); echo '</pre>'; exit;

					}

					$this->_data['records_info'] = 'Showing '.($pgoffset+1).' to '.$to2.' of '.number_format($total_records).' entries';

				}	

			if($mpaged == 1)

				$this->load->view('crm/category-records-ajax-list', $this->_data);

			else

				$this->load->view('crm/category-records-list', $this->_data);

		} else if(($pam3=="edit" || $pam4=="edit")) {



			$id = (int)$pam4;



			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');



			if($this->input->post('action')=="save") {



				$record2=$this->input->post('record');



				$er = array();



				if(empty($record2['name'])) $er['name']="Name required";



				if(!$er) {



					$record2['section']=$section;

					$record2['share']=isset($record2['share'])?1:0;

					if($section==1) {

						$record2['form']=isset($record2['cfield'])?json_encode($record2['cfield']):'';

						if(isset($record2['cfield'])) unset($record2['cfield']);	

					}

					$cid = $this->crm->save_catlist($record2,$id);

					if($this->input->post('form_submit_done')=="Done") redirect($secUrl);

					$record = $this->crm->get_catlistrow($id);

					$record['form'] = $record['form']?json_decode($record['form']):'';



				} else $record = $record2;



				$this->_data['er']=$er;



				$this->_data['record']=$record;



			}



			//List Forms

			$dbcontact_fields = import_fields($section==2?'account':'contact');

			$this->_data['contact_fields']=$dbcontact_fields;



			//Salutation

			$salutation = $this->config->item('salutation');

			$this->_data['salutation']=$salutation;



			//Type

			$account_types = $this->config->item('account_types');

			$this->_data['account_types']=$account_types;



			//Industry

			$industries = $this->config->item('industries');

			$this->_data['industries']=$industries;



			//Rating

			$ratings = $this->config->item('ratings');

			$this->_data['ratings']=$ratings;



			//$this->_data['record']=$record;
			
			if($id) $this->_data['record'] = $record;
			else $this->_data['record'] = "";

			$this->_data['listrow'] = $record;



			$this->_data['breadcrumbs']=$breadcrumbs;



			$catid = (int)$pam4;

			if($catid) $this->_data['listForm'] = $this->load->view('widget/list-widget-form', $this->_data,true);



			$this->load->view('crm/category-list-edit', $this->_data);



		} else {			

			$cparams = array('section'=>$section);			

			//$this->_data['catlist'] = $this->crm->get_all_catlist($section,$shared,$cparams);

			$this->_data['catlist'] = $this->crm->get_all_catlist($cparams);



			$this->load->view('crm/category-list', $this->_data);



		}



	}	



	//Save Record category list

	function update_record_catlist($record_id,$section) {	



		if (!$this->input->is_ajax_request()) return;

		if($this->input->post('action')<>"listupdate") return;



		/*$rcatlist = $this->crm->get_categories_attached($record_id,$section);

		if($rcatlist) {

			foreach($rcatlist as $catid) $this->crm->delete_category_records($catid->id,$record_id);

		}*/

		$record=$this->input->post('record');

		if($record) {

			$cats = $record['catg'];

			foreach($cats as $cat) {

				$exist_record = $this->crm->get_category_record($cat,$record_id);

				if(!$exist_record) {

					$info = array('category_id'=>$cat,'record_id'=>$record_id);

					$this->crm->save_category_record($info);

				}

			}

		}

		exit;

	}



	//Save selected records to category list

	function add_Records_to_List() {	



		if (!$this->input->is_ajax_request()) return;

		if($this->input->post('action')<>"rectolist") return;



		$record_Ids = $this->input->post('catrecids');

		if(!$record_Ids) exit;

		$record_Ids = explode(",",$record_Ids);

		if(count($record_Ids)==0) exit;

		$record=$this->input->post('record');

		if(!$record['catg']) exit;

		$saved = 0;

		foreach($record_Ids as $record_id) {

			$cats = $record['catg'];

			foreach($cats as $cat) {

				$exist_record = $this->crm->get_category_record($cat,$record_id);				

				if(!$exist_record) {

					$info = array('category_id'=>$cat,'record_id'=>$record_id);

					$this->crm->save_category_record($info);

					$saved = 1;

				}

			}

		}

		echo $saved;

		exit;

	}



	//Save selected Search records to category list

	function add_search_Records_to_List() {			

		if (!$this->input->is_ajax_request()) return;

		if($this->input->post('action')<>"srchrectolist") return;



		$record_Ids = $this->input->post('catrecids');

		if(!$record_Ids) exit;

		$record_Ids = explode(",",$record_Ids);

		if(count($record_Ids)==0) exit;

		$record=$this->input->post('record');

		if(!$record['catg'] && !$record['catg2']) exit;

		$ccats = $record['catg'];

		$acats = $record['catg2'];

		$csaved = 0;

		$asaved = 0;

		//print_r($record_Ids);print_r($ccats);print_r($acats);

		foreach($record_Ids as $record_id) {

			$ridarr = explode("-",$record_id);

			//Contacts

			if($ridarr[0]=="C" && $ccats) {

				foreach($ccats as $cat) {

					$exist_record = $this->crm->get_category_record($cat,$ridarr[1]);				

					if(!$exist_record) {

						$info = array('category_id'=>$cat,'record_id'=>$ridarr[1]);

						$this->crm->save_category_record($info);

						$csaved++;

					}

				}	

			}

			//Accounts

			if($ridarr[0]=="A" && $acats) {

				foreach($acats as $cat) {

					$exist_record = $this->crm->get_category_record($cat,$ridarr[1]);				

					if(!$exist_record) {

						$info = array('category_id'=>$cat,'record_id'=>$ridarr[1]);

						$this->crm->save_category_record($info);

						$asaved++;

					}

				}	

			}			

		}

		if(!$csaved && !$asaved) echo "May be records already added to List";

		else {

			if($csaved) echo "$csaved Contact".($csaved>1?'s':'')." added to List\n";

			if($asaved) echo "$asaved Account".($asaved>1?'s':'')." added to List";

		}

		

		exit;

	}





	//Global Search

	public function searchall() {

		$breadcrumbs = array();

		$breadcrumbs[] = array('label'=>'Search','url'=>base_url('crm/searchall'));		

		$this->_data['crmlite'] = 'crm';

		$this->_data['breadcrumbs']=$breadcrumbs;



		$gskey=$this->input->post('gskey');

		$this->_data['gskey']=$gskey;

		$esearch = 0;

		$search_list = array();

		$actab = '';

		//Search

		if($gskey) {

			$esearch = 1;

			//CONTACTS

			//contact fields

			$gskey1=explode(" ",$gskey);

			if(count($gskey1)>1){

				foreach($gskey1 as $gskey2){

					$ekeys = array(

						'user_first'=>$gskey2,

						'user_last'=>$gskey2,

						'user_title'=>$gskey2,

						'department'=>$gskey2,

						'lead_source'=>$gskey2,

						'phone'=>$gskey2,

						'mobile'=>$gskey2,

						'other_phone'=>$gskey2,

						'birthdate'=>$gskey2,

						'email'=>$gskey2,

						'assistant'=>$gskey2,

						'asst_phone'=>$gskey2,

						'linkedin'=>$gskey2,

						'website'=>$gskey2

					);

					$contacts = $this->crm->contact_search($ekeys,$this->_parent_users);

					if($contacts) $search_list['contacts'] = $contacts;

				}

			} else{

				//contact fields

				$ekeys = array(

					'user_first'=>$gskey,

					'user_last'=>$gskey,

					'user_title'=>$gskey,

					'department'=>$gskey,

					'lead_source'=>$gskey,

					'phone'=>$gskey,

					'mobile'=>$gskey,

					'other_phone'=>$gskey,

					'birthdate'=>$gskey,

					'email'=>$gskey,

					'assistant'=>$gskey,

					'asst_phone'=>$gskey,

					'linkedin'=>$gskey,

					'website'=>$gskey

				);

				$contacts = $this->crm->contact_search($ekeys,$this->_parent_users);

				if($contacts) $search_list['contacts'] = $contacts;

			}

			//contact address

			$ekeys = array(

				'street'=>$gskey,

				'city'=>$gskey,

				'state'=>$gskey,

				'zipcode'=>$gskey,

				'country'=>$gskey

			);

			$contacts = $this->crm->address_search($ekeys,'amail','C',$this->_parent_users);

			if($contacts) {

				if(!isset($search_list['contacts'])) $search_list['contacts']=array();

				$search_list['contacts'] = array_merge($search_list['contacts'],$contacts);

			}

			//custom fields

			if($this->_data['custom']) {

				$cNum = $this->_data['customNum'];

				foreach($this->_data['custom'] as $ck=>$cv) {

					$Cval=array($ck,$gskey);

					if(in_array($ck,$this->_data['customNum'])!==FALSE && ((float)$gskey || $gskey=="0")) {

						$aval2 = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))=".(float)str_replace(",","",$gskey);

						$Cval=array($ck,$aval2);

						$contacts = $this->crm->custom_search($Cval,'C',$this->_parent_users,1);

					}

					else $contacts = $this->crm->custom_search($Cval,'C',$this->_parent_users);

					if($contacts) {

						if(!isset($search_list['contacts'])) $search_list['contacts']=array();

						$search_list['contacts'] = array_merge($search_list['contacts'],$contacts);

					}

				}

			}

			if(!$actab && $search_list['contacts']) $actab = 'contacts';



			//ACCOUNTS

			//account fields

			$gskey1=explode(" ",$gskey);

			if(count($gskey1)>1){

				foreach($gskey1 as $gskey2) {

					$ekeys = array(

						'account_name'=>$gskey2,

						'account_number'=>$gskey2,

						'account_site'=>$gskey2,

						'account_type'=>$gskey2,

						'industry'=>$gskey2,

						'rating'=>$gskey2,

						'phone'=>$gskey2,

						'fax'=>$gskey2,

						'ticker_symbol'=>$gskey2,

						'ownership'=>$gskey2,

						'siccode'=>$gskey2

					);

					$accounts = $this->crm->account_search($ekeys,$this->_parent_users);

					if($accounts) $search_list['accounts'] = $accounts;

				}

			} else {

				$ekeys = array(

					'account_name'=>$gskey,

					'account_number'=>$gskey,

					'account_site'=>$gskey,

					'account_type'=>$gskey,

					'industry'=>$gskey,

					'rating'=>$gskey,

					'phone'=>$gskey,

					'fax'=>$gskey,

					'ticker_symbol'=>$gskey,

					'ownership'=>$gskey,

					'siccode'=>$gskey

				);

				$accounts = $this->crm->account_search($ekeys,$this->_parent_users);

				if($accounts) $search_list['accounts'] = $accounts;	

			}

			//Numeric fields

			$ekeys = array();

			if((float)$gskey || $gskey=="0") $ekeys['revenue']=(float)$gskey;

			if((int)$gskey || $gskey=="0") $ekeys['employees']=(int)$gskey;

			if($ekeys) {

				$accounts = $this->crm->account_search($ekeys,$this->_parent_users);

				if($accounts) $search_list['accounts'] = $accounts;

			}

			//contact shipping address

			$ekeys = array(

				'street'=>$gskey,

				'city'=>$gskey,

				'state'=>$gskey,

				'zipcode'=>$gskey,

				'country'=>$gskey

			);

			$accounts = $this->crm->address_search($ekeys,'shipping','A',$this->_parent_users);

			if($accounts) {

				if(!isset($search_list['accounts'])) $search_list['accounts']=array();

				$search_list['accounts'] = array_merge($search_list['accounts'],$accounts);

			}

			//contact billing address

			$ekeys = array(

				'street'=>$gskey,

				'city'=>$gskey,

				'state'=>$gskey,

				'zipcode'=>$gskey,

				'country'=>$gskey

			);

			$accounts = $this->crm->address_search($ekeys,'billing','A',$this->_parent_users);

			if($accounts) {

				if(!isset($search_list['accounts'])) $search_list['accounts']=array();

				$search_list['accounts'] = array_merge($search_list['accounts'],$accounts);

			}

			//custom fields

			if($this->_data['customa']) {

				$cNum = $this->_data['customNuma'];

				foreach($this->_data['customa'] as $ck=>$cv) {

					$Cval=array($ck,$gskey);

					if(in_array($ck,$this->_data['customNuma'])!==FALSE && ((float)$gskey || $gskey=="0")) {

						$aval2 = "cast(REPLACE(ad.cval,',','') as DECIMAL(11,4))=".(float)str_replace(",","",$gskey);

						$Cval=array($ck,$aval2);

						$accounts = $this->crm->custom_search($Cval,'A',$this->_parent_users,1);

					}

					else $accounts = $this->crm->custom_search($Cval,'A',$this->_parent_users);

					if($accounts) {

						if(!isset($search_list['accounts'])) $search_list['accounts']=array();

						$search_list['accounts'] = array_merge($search_list['accounts'],$accounts);

					}

				}

			}

			if(!$actab && $search_list['accounts']) $actab = 'accounts';

		}

		if(!$actab) $actab = 'contacts';

		$this->_data['esearch']=$esearch;

		$this->_data['actab']=$actab;

		$this->_data['search_list']=$search_list;

		$this->load->view('crm/global-search', $this->_data);

	}







	//MailChimp Methods

	public function mailchimp_methods($section) {

		// Composer Autoloader

		//require FCPATH.'vendor/autoload.php';

		$where_mc = array();
		
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom,accessview');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) {
			 $shuser = $result['userfrom'];
			 $accessview =  $result['accessview'];
		}
		else $shuser = $user_id; 
		
		$where_mc['user_id'] = $shuser;

		//$where_mc['user_id'] = $this->_user_id;

		$where_mc['field_type'] = 'mailchimp';

		$user_info_mc = $this->home->getUserData($where_mc);

		if(!$user_info_mc) return;

		if($user_info_mc) $user_info_mc = $user_info_mc[0];



		$mailchimp = array('apikey'=>'');

		if(isset($user_info_mc->value)) $mailchimp['apikey'] = $user_info_mc->value;

		if(empty($mailchimp['apikey'])) return;



		$this->config->set_item('Mailchimp_api_key', $mailchimp['apikey']);

		//error_reporting(E_ALL);

		//ini_set("display_errors", 1);

		$this->load->library('MailChimp');	

		//Get list

		if($section=="lists") {			

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



			$mc_lists = '';

			$mc_result = $this->mailchimp->get('lists');

			if($mc_result && isset($mc_result['lists'])) {

				foreach($mc_result['lists'] as $mcrec) {

					//$mc_lists[$mcrec['id']] = $mcrec['name'];

					$mc_lists .= '<option value="'.$mcrec['id'].'">'.ucfirst($mcrec['name']).'</option>';

				}

				$this->_data['mc_lists']=$mc_lists;

			}

		}

		//contact listings

		else if($section=="contact-listings") {

			//Get active record

			$crecord = $this->_data['record'];

			$email = $crecord['email'];

			$contact_id = $crecord['contact_id'];

			$mc_contact_list = array();



			//Get email listings

			$mc_result = $this->mailchimp->get('search-members?query='.$email.'&fields');

			if(!$mc_result) return;

			$idate = date("Y-m-d");

			//get exact email matches

			if(!isset($mc_result['exact_matches'])) return;

			//get emails

			if($mc_result['exact_matches']['total_items']==0) return;

			$emails = $mc_result['exact_matches']['members'];



			foreach($emails as $emval) {

				if($emval['status']<>"subscribed") continue;

				$listid = $emval['list_id'];

				$ctime = explode("T",$emval['timestamp_opt']);

				$ctime = $ctime[0];

				//get listing name and contacts count

				$mc_result = $this->mailchimp->get('lists/'.$listid.'?fields=name,stats.member_count');

				if(!$mc_result) continue;

				if(!isset($mc_result['name'])) continue;

				$mc_contact_list[] = array('listid'=>$listid,'name'=>$mc_result['name'],'count'=>$mc_result['stats']['member_count'],'contact_date'=>date("m/d/Y",strtotime($ctime)));

			}

			if($mc_contact_list) $this->_data['mc_contact_list']=$mc_contact_list;



			return;

		}

		//Add contact

		else if($section=="addContact") {

			$mc_result = $this->mailchimp->post("lists/".$this->_data['mc_newcontact_info']['listid']."/members", [

				'email_address' => $this->_data['mc_newcontact_info']['email'],

				'status'        => 'subscribed'

			]);

			if($mc_result['status']==400) {

				$json = array('message'=>"Contact already exists",'status'=>false);

				echo json_encode($json);

				exit;

			} else if($mc_result['status']=="subscribed") {

				$json = array('message'=>"Contact added to list",'status'=>true);

				echo json_encode($json);

				exit;

			} else {

				$json = array('message'=>$mc_result['details'],'status'=>false);

				echo json_encode($json);

				exit;

			}			

		}

		//delete contact

		else if($section=="removeContact") {

			$email = strtolower($this->_data['mc_deletecontact_info']['email']);

			$email = md5($email);			

			$mc_result = $this->mailchimp->delete("lists/".$this->_data['mc_deletecontact_info']['listid']."/members/".$email);

			if($mc_result=='') {

				$json = array('message'=>"Contact removed",'status'=>true);

				echo json_encode($json);

				exit;			

			} else {

				$json = array('message'=>$mc_result['details'],'status'=>false);

				echo json_encode($json);

				exit;

			}			

		}		

		return;

		//use \DrewM\MailChimp\MailChimp;



		//$MailChimp = new MailChimp($mailchimp['apikey']);

		//$result = $MailChimp->get('lists');

	}



	//Contact view mailchimp

	public function mailchimp_contactview() {

		$mctype=$this->input->post('mctype');

		//Add contact to list

		if($mctype=="addcontact") {

			$contact_id = $this->uri->segment(4);

			$contact_record = $this->crm->get_acRecord("contact_id=$contact_id",'email','C');

			if(!$contact_record) {

				$json = array('message'=>"Contact record not found",'status'=>false);

				echo json_encode($json);

				exit;

			}

			if(empty($contact_record['email'])) {

				$json = array('message'=>"Contact email required",'status'=>false);

				echo json_encode($json);

				exit;

			}

			$listid=$this->input->post('listid');

			if(empty($listid)) {

				$json = array('message'=>"MailChimp List required",'status'=>false);

				echo json_encode($json);

				exit;

			}

			$this->_data['mc_newcontact_info']=array('listid'=>$listid,'email'=>$contact_record['email']);

			$this->mailchimp_methods("addContact");

			exit;

		}

		//Remove contact from list

		if($mctype=="delcontact") {

			$contact_id = $this->uri->segment(4);

			$contact_record = $this->crm->get_acRecord("contact_id=$contact_id",'email','C');

			if(!$contact_record) {

				$json = array('message'=>"Contact record not found",'status'=>false);

				echo json_encode($json);

				exit;

			}

			if(empty($contact_record['email'])) {

				$json = array('message'=>"Contact email required",'status'=>false);

				echo json_encode($json);

				exit;

			}

			$listid=$this->input->post('listid');

			if(empty($listid)) {

				$json = array('message'=>"MailChimp List required",'status'=>false);

				echo json_encode($json);

				exit;

			}

			$this->_data['mc_deletecontact_info']=array('listid'=>$listid,'email'=>$contact_record['email']);

			$this->mailchimp_methods("removeContact");

			exit;

		}

		

		if($mctype=="mcinfo") {

			//Get active record

			//$crecord = $this->_data['record'];

			//$email = $crecord['email'];

			$contact_id = $this->uri->segment(4);

			$contact_record = $this->crm->get_acRecord("contact_id=$contact_id",'email','C');

			$email = $contact_record['email'];

			if(empty($email)) exit;

			$this->_data['record'] = $contact_record;

			//get mailchimp contact lists

			$this->mailchimp_methods('lists');



			$this->mailchimp_methods('contact-listings');

			$html = $this->load->view('crm/contact-mailchimp-info', $this->_data,true);

			echo $html;

			exit;	

		}



		//Track contact

		//$this->mailchimp_methods('trackContact');

	}

	//end of MailChimp Methods



	public function downdocx() {

		return;

	}



	public function totalContacts()

	{

		$list_id =  $_POST['list_id'];

		$total_records = $this->crm->get_category_records($list_id,1,'');

		echo $total_records;

		return;

	} 



	



}



/* End of file home.php */



/* Location: ./application/controllers/home.php */