<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//error_reporting(E_ALL);

session_start();

class Interviewer extends CI_Controller {

	/**

	 * Properties

	 */

	public $_data;

	public $_user_id;

	public $_parent_users=array();



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

        $this->load->model('applicant_model', 'applicant');

        $this->load->model('campaign_model', 'campaign');

		$this->load->model('product_model', 'productModel');

		$this->load->model('question_model','QuestionModel');

		$this->load->model('category_model');

		$this->load->model('attribute_model','attribute');

		

		if(!$this->config->item('is_local'))

		{

			include(CDOC_ROOT."members/library/Am/Lite.php"); 

                      

            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');

			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014

			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,29,30,31,32), 'Restricted access'); //  This array is Updated by Dev@4489 on 23-Oct-2015

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

			$this->_data['aMember'] = array('yname'=>'','yemail'=>'','yphone'=>'','ytitle'=>'','ycompany'=>'','ywebsite'=>'','yfname'=>'','ylname'=>'');

			$amember_data = Am_Lite::getInstance()->getUser();

			if($amember_data) {

				$this->_data['aMember'] = array('yname'=>ucfirst($amember_data['name_f'].' '.$amember_data['name_l']),'yemail'=>$amember_data['email'],'yphone'=>$amember_data['phone'],'ytitle'=>$amember_data['utitle'],'ycompany'=>'','ywebsite'=>'','yfname'=>$amember_data['name_f'],'ylname'=>$amember_data['name_l']);

			}

			



            //$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2'));

			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10'));//  This array is Updated by Aavid developer on 17-April-2014

			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','29','30','31','32'));//  This array is Updated by Dev@4489 on 17-April-2014

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

			//Job Seeker

			$jobseeker = Am_Lite::getInstance()->haveSubscriptions(array('29'));

			if($jobseeker && !$eSubscribe) $this->_data['ejobseeker'] = TRUE;

			////

			// interviewer

			$interviewer = Am_Lite::getInstance()->haveSubscriptions(array('30','31'));// products

			if($interviewer) $this->_data['einterviewer'] = TRUE;

			

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

        //Shared Access to Staffing
		if($this->_data['AMuserShares']['staffing']==0) redirect(base_url('/'));

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

		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);

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

			$data1=$this->_data['aMember'];

			$this->_data['aMember']=unserialize($user_info->value);

			$this->_data['aMember']['yfname']=$data1['yfname'];

			$this->_data['aMember']['ylname']=$data1['ylname'];

		}

		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);

		if($company_info_detail){

			$this->_data['aMember']['ycompany']=$company_info_detail->company_name;

			$this->_data['aMember']['ywebsite']=$company_info_detail->company_website;

		}

		

	    $this->interviewer_plan_access();

	   

	   //Group User Custom fields

		$where = array();

		$where['user_id'] = isset($this->_data['eLusrNotBS'])?$this->_data['eLusrNotBS']:$this->_user_id;

		$where['field_type'] = 'custom';

		$user_info = $this->home->getUserData($where);

		if($user_info) $user_info = $user_info[0];

		$custom = array();

		if(isset($user_info->value)) {

			$custom=unserialize($user_info->value);

		}else {

			$custom['field1'] = 'Custom Fields 1';

			$custom['field2'] = 'Custom Fields 2';

			$custom['field3'] = 'Custom Fields 3';

		}

		$this->_data['custom']=$custom;

	   

	   



       /*if(isset($just_registered))

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

			

		}*///error_reporting(E_ALL);

		$this->_data['ivs'] = 'applicant';

	}	

	public function index($id = NULL)

	{

		$this->_data['page'] = 'register';

		redirect(base_url() . 'interviewer/applicant');

	}

	//Verify interviewer pages

	function interviewer_plan_access(){

		if(isset($this->_data['einterviewer'])){

			$pam2 = $this->uri->segment(2);

			if($pam2=="jobs" || $pam2=="yourprofile")

			 redirect(base_url('interviewer/builder'));

		}

	}

	//Verify Job seeker pages

	function jobseeker_plan_access($app_id=0){				

		if(isset($this->_data['ejobseeker'])) {		

			$pam3 = $this->uri->segment(3);//edit/delete



			$no_access = 1;	

			$js_record= $this->applicant->get_profileid();

			$jsid=$js_record['contact_id'];

			if($pam3<>"delete" && $app_id==$jsid) $no_access = 0;

			/*if(strpos($_SERVER['REQUEST_URI'],"notes")!=FALSE) {

				if(strpos($_SERVER['REQUEST_URI'],"applicant")!=FALSE) {

					$pam5 = $this->uri->segment(5);//applicant id

					if($pam5==$jsid) $no_access = 0;

				} else {



				}

			} else if(strpos($_SERVER['REQUEST_URI'],"applicant")!=FALSE) {

				$pam4 = $this->uri->segment(4);//applicant id

				if($pam4==$jsid) $no_access = 0;

			}*/

			if($no_access) redirect(base_url('folder/sales-prospecting-basics') );

		}

		

	}

	

	// jopb seeker jobs

	function jobs($action = NULL)

	{

		if(isset($this->_data['is_prolite'])) redirect(base_url());

		$this->_data['ivs'] = '';

		$this->_data['ivjs'] = 'jobs';

		$pam3 = $this->uri->segment(3);//edit/delete

		$pam4 = $this->uri->segment(4);//contact id

		$pam5 = $this->uri->segment(5);//contact id

		$breadcrumbs = array();

		

		$breadcrumbs[] = array('label'=>'Jobs','url'=>base_url('interviewer/jobs'));

		//else if($pam3=="my") {$breadcrumbs[] = array('label'=>'My Applicants','url'=>base_url('interviewer/applicant/my'));$this->_data['mine'] = 'yes';}

		if($pam3=="view" && (int)$pam4) {

			$id=(int)$pam4;

			$breadcrumbs[] = array('label'=>'View','url'=>base_url('interviewer/jobs/view/'.$id));

			$this->_data['record'] = $this->applicant->get_job($id);

			$this->_data['section'] = $this->applicant->get_jobsection($id);

			

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/jobs-view', $this->_data);

		}

		else if($pam3=="get" && (int)$pam4 ) {

			$job_id=(int)$pam4; 

			$jobinfo = $this->applicant->get_job($job_id);

			//$detail = $this->applicant->get_user();

			$detail = $this->_data['aMember'];

			$user_id =  $_SESSION['ss_user_id'];

			if($jobinfo['user_id']==$user_id) {

				$er= "You are the owner of this job, so cant apply.";

			} else {

				$job_applicant=$this->applicant->user_applied_job($detail['yemail'],'jobpost_id='.$job_id);

				if($job_applicant) {

					$er= "You are already applied for this job";

				} else {

					$this->copy_profile_to_applicant($jobinfo,$job_id);

					/*$edata = array('user_first'=>$detail['yfname'],'user_last'=>$detail['ylname'],'user_title'=>$detail['ytitle'].'','phone'=>$detail['yphone'].'','email'=>$detail['yemail'],'userid'=>$jobinfo['user_id'],'share_user_id'=>$jobinfo['user_id'],'jobpost_id'=>$job_id,'atype'=>0,'job_applied_for'=>$jobinfo['job_title'],'stage'=>'Applied');

					$this->applicant->save_applyjob($edata);*/

					$er="Your application has been submitted";

				}

			}

			$_SESSION['er']= $er;

			redirect(base_url() . 'interviewer/jobs/view/'.$job_id);

		}

		else { 

			

			$this->_data['jobs'] = $this->applicant->get_all_jobs();

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/jobs-list', $this->_data);

			

	   }

	   

	}



	//Copy profile to applicant

	function copy_profile_to_applicant($jobinfo,$jobid=0) {

		if($jobid) {

			$myprofile = $this->applicant->get_profileid();

			if(empty($myprofile)) {

				$amdetail = $this->_data['aMember'];

				$this->applicant->save_yourprofile($amdetail);

				$myprofile= $this->applicant->get_profileid();

			}

			$my_app_id = $myprofile['contact_id'];

			//save applicant

			$edata = array('user_prefix'=>$myprofile['user_prefix'],'user_first'=>$myprofile['user_first'],'user_last'=>$myprofile['user_last'],'mobile'=>$myprofile['mobile'].'','phone'=>$myprofile['phone'].'','email'=>$myprofile['email'],'birthdate'=>$myprofile['birthdate'],'linkedin'=>$myprofile['linkedin'],'userid'=>$jobinfo['user_id'],'share_user_id'=>$jobinfo['user_id'],'jobpost_id'=>$jobinfo['post_id'],'atype'=>0,'job_applied_for'=>$jobinfo['job_title'],'stage'=>'Applied','modify_date'=>date("Y-m-d H:i:s"));

		} else {

			//save applicant

			$myprofile = $jobinfo;

			$edata = array('user_prefix'=>$myprofile['user_prefix'],'user_first'=>$myprofile['user_first'],'user_last'=>$myprofile['user_last'],'mobile'=>$myprofile['mobile'].'','phone'=>$myprofile['phone'].'','email'=>$myprofile['email'],'birthdate'=>$myprofile['birthdate'],'linkedin'=>$myprofile['linkedin'],'userid'=>$_SESSION['ss_user_id'],'share_user_id'=>$_SESSION['ss_user_id'],'atype'=>0,'modify_date'=>date("Y-m-d H:i:s"));

		}

		

		$job_appid = $this->applicant->save_applyjob($edata);

		//address

		if($myprofile['amail']) {

			$app_address = $myprofile['amail'];

			$app_address['parent_id']=$job_appid;

			$this->applicant->save_address($app_address);

		}

		//attachments

		$appchilds = $this->applicant->get_all_notes($my_app_id,'C','docu');

		if($appchilds) {

			$ntype = 'docu';

			foreach($appchilds as $achild){

				$achild = (array)$achild;

				$app_child = array();

				$app_child['notes_title'] = $achild['notes_title'];

				$filename=$achild['upload'];

				$document1=$_SERVER['DOCUMENT_ROOT']."/betapro/upload/".$filename;

				$flarr = explode("_",$filename);

				$flarr[0] = time();

				$filename = implode("_",$flarr);

				$document2=$_SERVER['DOCUMENT_ROOT']."/betapro/upload/".$filename;

				@copy($document1,$document2);

				$app_child['upload'] = $filename;

				$parent_type='C';

				$app_child['notes_parent']='C';

				$app_child['notes_parentid']=$job_appid;

				$app_child['notes_private']=$achild['notes_private']?1:0;

				$cid = $this->applicant->save_notes($app_child,0,$ntype);

			}

		}

		//Experience

		$appchilds = $this->applicant->get_all_notes($my_app_id,'C','exp');

		if($appchilds) {

			$ntype = 'exp';

			foreach($appchilds as $achild){

				$achild = (array)$achild;

				$app_child = array();

				$app_child['notes_title'] = $achild['notes_title'];

				$app_child['notes_company'] = $achild['notes_company'];

				$app_child['notes_location'] = $achild['notes_location'];

				$app_child['notes_fmonth'] = $achild['notes_fmonth'];

				$app_child['notes_fyear'] = $achild['notes_fyear'];

				$app_child['notes_tmonth'] = $achild['notes_tmonth'];

				$app_child['notes_tyear'] = $achild['notes_tyear'];

				$app_child['notes_info'] = $achild['notes_info'];

				$parent_type='C';

				$app_child['notes_parent']='C';

				$app_child['notes_parentid']=$job_appid;

				$app_child['notes_private']=$achild['notes_private']?1:0;

				$cid = $this->applicant->save_notes($app_child,0,$ntype);

			}

		}

		//School

		$appchilds = $this->applicant->get_all_notes($my_app_id,'C','edu');

		if($appchilds) {

			$ntype = 'edu';

			foreach($appchilds as $achild){

				$achild = (array)$achild;

				$app_child = array();

				$app_child['notes_school'] = $achild['notes_school'];

				$app_child['notes_degree'] = $achild['notes_degree'];

				$app_child['notes_field'] = $achild['notes_field'];

				$app_child['notes_grade'] = $achild['notes_grade'];

				$app_child['notes_activity'] = $achild['notes_activity'];

				$app_child['notes_fyear'] = $achild['notes_fyear'];

				$app_child['notes_tyear'] = $achild['notes_tyear'];

				$app_child['notes_info'] = $achild['notes_info'];

				$parent_type='C';

				$app_child['notes_parent']='C';

				$app_child['notes_parentid']=$job_appid;

				$app_child['notes_private']=$achild['notes_private']?1:0;

				$cid = $this->applicant->save_notes($app_child,0,$ntype);

			}

		}

		//Skill

		$appchilds = $this->applicant->get_all_notes($my_app_id,'C','skill');

		if($appchilds) {

			$ntype = 'skill';

			foreach($appchilds as $achild){

				$achild = (array)$achild;

				$app_child = array();

				$app_child['notes_title'] = $achild['notes_title'];

				$app_child['notes_fyear'] = $achild['notes_fyear'];

				$app_child['notes_tyear'] = $achild['notes_tyear'];

				$app_child['notes_info'] = $achild['notes_info'];

				$parent_type='C';

				$app_child['notes_parent']='C';

				$app_child['notes_parentid']=$job_appid;				

				$cid = $this->applicant->save_notes($app_child,0,$ntype);

			}

		}

	}

	

	//Yourprofile

	function yourprofile($action = NULL)

	{

		if(isset($this->_data['is_prolite'])) redirect(base_url());

		/*$this->load->library('excel');

		$this->load->library('parsecsv');

		$csv = new Parsecsv();*/

		$this->_data['ivs'] = '';

		$this->_data['ivjs'] = 'yourprofile';

		$pam3 = $this->uri->segment(3);//edit/delete

		$pam4 = $this->uri->segment(4);//contact id

		$pam5 = $this->uri->segment(5);//contact id

		$breadcrumbs = array();

		

		$breadcrumbs[] = array('label'=>'Your Profile','url'=>base_url('interviewer/yourprofile'));

		$record=array();

		$record= $this->applicant->get_profileid();

		$id=$record['contact_id'];

		

		if(empty($record)){

			$detail = $this->_data['aMember'];

			//print_r($detail);

			$record1=$this->applicant->save_yourprofile($detail);

			$record= $this->applicant->get_profileid();

			//echo"<pre>"; print_r($record);

			$id=$record['contact_id'];

		}

		

	

		$record = $this->applicant->get_contact($id); //echo "<pre>";print_r($record);exit;

			

		if((int)$record['birthdate']) $record['birthdate']=date("m/d/Y",strtotime($record['birthdate']));

		else $record['birthdate']="";

		if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

		$sUser = $this->crm->get_CurrentUser($record['share_user_id']);

		$record['share_user_title']=ucfirst($sUser[0]->usrname);

		$this->_data['record'] = $record;

		$breadcrumbs = array();

		$breadcrumbs[] = array('label'=>'Your Profile','url'=>base_url('interviewer/yourprofile'));

		$breadcrumbs[] = array('label'=>ucfirst($record[user_first].' '.$record[user_last]),'url'=>base_url('interviewer/yourprofile'));

			

		

		$this->_data['breadcrumbs']=$breadcrumbs;

			$atype=2;

			$this->_data['contacts']= $this->applicant->get_profileid();

			$id=$this->_data['contacts']['contact_id'];

			$this->_data['notes_list2'] = $this->applicant->get_all_notes($id,'C','exp',10);

			$this->_data['notes_list3'] = $this->applicant->get_all_notes($id,'C','edu',10);

			$this->_data['notes_list4'] = $this->applicant->get_all_notes($id,'C','skill',10);

			$this->_data['notes_list5'] = $this->applicant->get_all_notes($id,'C','docu',10);

			

			$this->load->view('interview/job-yourprofile-view', $this->_data);

		

	}

	

	//Tasks

	function tasks($action = NULL)

	{

		//3-contacts/4-contactid/5-edit

		//3-contacts/4-contactid

		//3-view/4-notesid

		//3-edit/4-notesid

		//3-delete/4-notesid

		

		$applicantlite = 'task';

		$pam3 = $this->uri->segment(3);

		$pam4 = $this->uri->segment(4);

		$pam5 = $this->uri->segment(5);

		//echo "1.$pam3 2.$pam4 3.$pam5 ";

		//delete all		

		if($this->input->post('action')=="deleteall") {			

			$record=$this->input->post('recids');

			if($record) {

				foreach($record as $rcid) $this->applicant->delete_task($rcid);

			}

			redirect(current_url());

		}

		//delete

		if((int)$pam4 && $pam3=="delete") {

			$id = (int)$pam4;

			$record = $this->applicant->get_task($id);

			if(!$record) redirect(base_url() . 'interviewer/applicant');

			$this->applicant->delete_task($id);

			$parent_section='applicant';

			if($record['task_related']=='C') $parent_section='applicant';

			//else if($record['task_related']=='A') $parent_section='accounts';

			redirect(base_url() . "interviewer/$parent_section/view/".$record['task_relatedto']);

		}

		$breadcrumbs = array();

		//add/list

		if((int)$pam4 && ($pam3=="applicant" || $pam3=="applicant")) {

			$parent_id = (int)$pam4;

			if($pam3=='accounts') $parent_record =$this->applicant->get_notes_parent($parent_id,'A');

			//else if($pam3=='opportunities') $parent_record =$this->->get_notes_parent($parent_id,'O');

			else $parent_record =$this->applicant->get_notes_parent($parent_id,'C');

			if(!$parent_record) redirect(base_url() . 'interviewer/applicant');

			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

			$sUser = $this->applicant->get_CurrentUser($record['share_user_id']);

			$record['share_user_title']=ucfirst($sUser[0]->usrname);			

			$parent_section=$pam3;

			$applicantlite="applicant";

			if($pam3=='applicant') {$applicantlite="applicant";

				$breadcrumbs[] = array('label'=>'Applicant','url'=>base_url('interviewer/applicant'));

				$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('interviewer/applicant/view/'.$parent_id));

				$breadcrumbs[] = array('label'=>'Tasks','url'=>base_url('interviewer/tasks/applicant/'.$parent_id));

				//Related Contact

				$record['task_relatedto']=$parent_id;

				$record['related_title']=ucfirst($parent_record[user_first].' '.$parent_record[user_last]);

				$record['task_related']="C";

				$record['task_phone']=$parent_record['phone'];

				$record['task_email']=$parent_record['email'];

			}

			

			$this->_data['record'] = $record;

			$this->_data['parent_section'] = $parent_section;

			$this->_data['parent_id'] = $parent_id;

		}

		//edit / view

		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {

			$id = (int)$pam4;

			$record = $this->applicant->get_task($id);

			if(!$record) redirect(base_url() . 'interviewer/applicant');

			if((int)$record['task_duedate']) $record['task_duedate']=date("m/d/Y",strtotime($record['task_duedate']));

			else $record['task_duedate']="";			

			$applicantlite="applicant";

			if($record['task_related']=='C') {$parent_section='applicant';$applicantlite="applicant";}

			$this->_data['parent_section'] = $parent_section;

			$this->_data['parent_id'] = $record['task_relatedto'];

			if($record['task_related']=='C') {

				$parent_record =$this->applicant->get_notes_parent($record['task_relatedto'],'C');

				if($parent_record) {

					$this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);

					$record[related_title]=$this->_data['parent_name'];

					$breadcrumbs[] = array('label'=>'Applicant','url'=>base_url('interviewer/applicant'));

					$breadcrumbs[] = array('label'=>$this->_data['parent_name'],'url'=>base_url('interviewer/applicant/view/'.$record['task_relatedto']));

					$breadcrumbs[] = array('label'=>'Task','url'=>base_url('interviewer/tasks/applicant/'.$record['task_relatedto']));

				}	

			} 

			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

			$sUser = $this->applicant->get_CurrentUser($record['share_user_id']);

			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			$this->_data['record'] = $record;

			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');

			//Quick Update task record

			$this->quick_update_task($id);

		}

		if(empty($breadcrumbs)) {

			$breadcrumbs[] = array('label'=>'Task','url'=>base_url('/tasks'));

		}

		$this->_data['applicantlite'] = $applicantlite;

		$this->_data['breadcrumbs']=$breadcrumbs;

		//add/edit

		if( (($pam3=="applicant") && $pam5=="edit") || ($pam3=="edit" && $pam4) || $pam3=="edit" ) {

			if($pam3=="edit" && $pam4) $id = (int)$pam4;

			if($pam3=="edit" && empty($pam4)) $breadcrumbs[] = array('label'=>'Task','url'=>base_url('/tasks'));

			if($id) {

				if($record['task_related']=='C') {$parent_section='applicant';$applicantlite="applicant";}

				

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

					$cid = $this->applicant->save_task($record,$id);

					//Redirect to Related Parent

					if($parent_type=='C') redirect(base_url() . 'interviewer/applicant/view/'.$parent_id);

					

				}

				$this->_data['er']=$er;

				$this->_data['record']=$record;

			}

			if(!$record['share_user_title']) {

				$record['share_user_id']=$this->_user_id;

				$sUser = $this->applicant->get_CurrentUser($record['share_user_id']);



				$record['share_user_title']=ucfirst($sUser[0]->usrname);

				$this->_data['record']=$record;

			}

			$this->_data['applicantlite'] = $applicantlite;			

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/app-task-edit', $this->_data);

		} else if($pam3=="view") {

			

			$this->load->view('interview/app-task-view', $this->_data);

		} else {

			if($pam3=='applicat') $parent_type='C';

			

			$this->_data['parent_section']=$pam3;

			$this->_data['parent_id']=$parent_id;

			if($parent_id)

				$this->_data['tasks_list'] = $this->applicant->get_all_tasks($parent_id,$parent_type);

			else $this->_data['tasks_list'] = $this->applicant->get_all_tasks(0,'',0,2);

			$this->load->view('interview/app-task-list', $this->_data);

		}

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

				$cid = $this->applicant->save_task($record,$id);

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

		

	//Notes

	function notes($action = NULL)

	{		//3-contacts/4-contactid/5-edit

		//3-contacts/4-contactid

		//3-view/4-notesid

		//3-edit/4-notesid

		//3-delete/4-notesid

		

		

		$pam3 = $this->uri->segment(3);

		$pam4 = $this->uri->segment(4);

		$pam5 = $this->uri->segment(5);

		$pam6 = $this->uri->segment(6);

		//echo "1.$pam3 2.$pam4 3.$pam5 ";

		//check type

		$atype=0;

		if($pam3!="exp" && $pam3!="edu" && $pam3!="skill" && $pam3!="docu" && $pam3!="note" )

		{

			redirect(base_url() . "interviewer/applicant/all");

		}

		$ntype=$pam3;

		$this->_data['ntype']=$ntype;

		if($ntype=="note") $ntlabel="Notes";

		else if($ntype=="exp") $ntlabel="Experience";

		else if($ntype=="edu") $ntlabel="Education";

		else if($ntype=="docu") $ntlabel="Attached Documents";

		else if($ntype=="skill") $ntlabel="Skills, Certifications, Associations, and Hobbies";

		

		//delete

		if((int)$pam5 && $pam4=="delete" && $pam3) {

			$id = (int)$pam5;

			$record = $this->applicant->get_notes($id);

			if(!$record) redirect(base_url() . 'interviewer/applicant');

			if($record['upload']) {

				$this->jobseeker_plan_access($record['notes_parentid']);

				$filename=$record['upload'];

				$document=$_SERVER['DOCUMENT_ROOT']."/betapro/upload/".$filename;

				unlink($document);				

			}

			$this->applicant->delete_notes($id);

			$parent_section='applicant';

			if($record['notes_parent']=='C') $parent_section='applicant';

			$parent_record =$this->applicant->get_notes_parent($record['notes_parentid'],'C');

			$atype=$parent_record['atype'];

			if($atype==2){

				redirect(base_url() . "interviewer/yourprofile");

			}else{

				redirect(base_url() . "interviewer/$parent_section/view/".$record['notes_parentid']);

			}

		}

		$breadcrumbs = array();		

		//add/list

		if((int)$pam5 && ($pam4=="applicant")) {

			$parent_id = (int)$pam5;

			$this->jobseeker_plan_access($parent_id);

			if($pam4=='applicant') $parent_record =$this->applicant->get_notes_parent($parent_id,'C');

			$atype=$parent_record['atype'];

			if(!$parent_record) redirect(base_url() . 'interviewer/applicant');

			$this->_data['record'] = $record;

			$parent_section='applicant';

			$applicantlite="applicant";	

					

			if($pam4=='applicant') {$parent_section='applicant';$applicantlite="applicant";

				if($parent_record['atype']==2){

					$this->_data['ivs'] = '';

					$this->_data['ivjs'] = 'yourprofile';

					$breadcrumbs[] = array('label'=>'Your Profile','url'=>base_url('interviewer/yourprofile'));

					$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('interviewer/yourprofile'));

				}

				else{

					$breadcrumbs[] = array('label'=>'Applicant','url'=>base_url('interviewer/applicant'));

					$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('interviewer/applicant/view/'.$parent_id));

				}				

			}

			$breadcrumbs[] = array('label'=>$ntlabel,'url'=>base_url("interviewer/notes/$ntype/$parent_section/".$parent_id));

			//else if($record['notes_parent']=='O') {$parent_section='opportunities';$crmlite="opportunity";}			

			$this->_data['parent_section'] = $parent_section;

			$this->_data['parent_id'] = $parent_id;

		}

		//edit / view

		if((int)$pam5 && ($pam4=="edit" || $pam4=="view")) {

			$id = (int)$pam5;

			$record = $this->applicant->get_notes($id);

			if(!$record) redirect(base_url() . 'interviewer/applicant');			

			$applicantlite="applicant";

			$this->jobseeker_plan_access($record['notes_parentid']);

			if($record['notes_parent']=='C') {$parent_section='applicant';$applicantlite="applicant";

				$parent_record =$this->applicant->get_notes_parent($record['notes_parentid'],'C');

				$atype=$parent_record['atype'];

				if($parent_record) {

					$atype = $parent_record['atype'];				

					$this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);

					if($atype==2){

						$this->_data['ivs'] = '';

						$this->_data['ivjs'] = 'yourprofile';

						$breadcrumbs[] = array('label'=>'Your Profile','url'=>base_url('interviewer/yourprofile'));

						$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('interviewer/yourprofile'));

					}

					else{

						$breadcrumbs[] = array('label'=>'Applicant','url'=>base_url('interviewer/applicant'));

						$breadcrumbs[] = array('label'=>ucfirst($parent_record[user_first].' '.$parent_record[user_last]),'url'=>base_url('interviewer/applicant/view/'.$record['notes_parentid']));

					}					

				}

			}

			

			$breadcrumbs[] = array('label'=>$ntlabel,'url'=>base_url("interviewer/notes/$ntype/$parent_section/".$record['notes_parentid']));

			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

			$sUser = $this->applicant->get_CurrentUser($record['share_user_id']);

		

			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			$this->_data['parent_section'] = $parent_section;

			$this->_data['parent_id'] = $record['notes_parentid'];

			$this->_data['record'] = $record;

			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');

		} 

		$this->_data['applicantlite'] = $applicantlite;

		$this->_data['breadcrumbs']=$breadcrumbs;

		$this->_data['atype']=$atype;

		//add/edit

		if( (($pam4=="applicant") && $pam6=="edit") || ($pam4=="edit" && $pam5) ) {

			if($pam4=="edit" && $pam5) $id = (int)$pam5;

			if($id) {

				if($record['notes_parent']=='C') {$parent_section='applicant';$applicantlite="applicant";}

				$this->_data['parent_id'] = $record['notes_parentid'];

			} else $parent_section=$pam4;

			

			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');

			$this->_data['parent_section'] = $parent_section;

			if($this->input->post('action')=="save") {

				$record=$this->input->post('record');

				$er = array();

				//if(empty($record['notes_title'])) $er['notes_title']="Subject required";

				if($ntype=="note" && empty($record['notes_title'])) $er['notes_title']="Subject required";

				if(!$er) {

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

						//end document

					if(!$er) {

						if($pam4=='applicant') $parent_type='C';

						if($parent_type) $record['notes_parent']=$parent_type;

						if($parent_id) $record['notes_parentid']=$parent_id;

						$record['notes_private']=$record['notes_private']?1:0;

						$cid = $this->applicant->save_notes($record,$id,$ntype);	

						//Redirect to Related Parent

						if($atype==2){

							redirect(base_url() . 'interviewer/yourprofile');

						}else{

							redirect(base_url() . 'interviewer/'.$this->_data['parent_section'].'/view/'.$this->_data['parent_id']);

						}

						//redirect(base_url() . 'crm/notes/view/'.$cid);

					}

				}

				$this->_data['er']=$er;

				$this->_data['record']=$record;

			}

			$this->_data['applicantlite'] = $applicantlite;

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/app-notes-edit', $this->_data);

		} else if($pam4=="view") {

			if($record['notes_parent']=='C') {

				$parent_record =$this->applicant->get_notes_parent($record['notes_parentid'],'C');

				$atype=$parent_record['atype'];

				if($parent_record) $this->_data['parent_name']=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);

			} 

			$this->load->view('interview/app-notes-view', $this->_data);

		} else {

			if($pam4=='applicant') $parent_type='C';

			

			$this->_data['parent_section']=$pam4;

			$this->_data['parent_id']=$parent_id;

			$this->_data['notes'] = $this->applicant->get_all_notes($parent_id,$parent_type,$ntype);

			$this->load->view('interview/app-notes-list', $this->_data);

		}

	}

	

	//job posting

	function jobpost($action = NULL)

	{

		/*$this->load->library('excel');

		$this->load->library('parsecsv');

		$csv = new Parsecsv();*/

		$this->_data['ivs'] = 'jobpost';

		$pam3 = $this->uri->segment(3);//edit/delete

		$pam4 = $this->uri->segment(4);//contact id

		$pam5 = $this->uri->segment(5);//contact id

		$breadcrumbs = array();

		$breadcrumbs[] = array('label'=>'Job Postings','url'=>base_url('interviewer/jobpost'));

		

		//delete all		

		if($this->input->post('action')=="deleteall") {			

			$record=$this->input->post('recids');

			if($record) {

				foreach($record as $rcid) $this->applicant->delete_jobpost($rcid);

			}

			redirect(current_url());

		}

		//delete

		if((int)$pam4 && $pam3=="delete") {

			$id = (int)$pam4;

			$record = $this->applicant->get_job($id);

			if(!$record) redirect(base_url() . 'interviewer/applicant');

			$this->applicant->delete_jobpost($id);

			redirect(base_url() . 'interviewer/applicant');

		}

		//edit / view

		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {

			$id = (int)$pam4;

			$record = $this->applicant->get_job($id); 

			if(!$record) redirect(base_url() . 'interviewer/applicant');

			$record['section'] = $this->applicant->get_jobsection($id); //echo "test"; echo "<pre>";print_r($record); exit;

			

			//Delete job sub element

			if($_POST['action_dev'] == 'delete')

			{

				if($this->applicant->deljob_section_single($id, $_POST['id_dev']))

				{

					echo '1';

				}

				else echo '0'; 

				exit;

			}

			

			/*if(!$record['user_id']) $record['user_id']=$this->_user_id;

			$sUser = $this->applicant->get_CurrentUser($record['user_id']);

			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			$this->_data['record'] = $record;*/

			//echo "test"; echo "<pre>";print_r($record); exit;

		}

		$this->_data['breadcrumbs']=$breadcrumbs;

		

		

		//Edit

		if($pam3=="edit") {

		

			$id = (int)$pam4;

			$breadcrumbs = array();

			$breadcrumbs[] = array('label'=>'Job Postings','url'=>base_url('interviewer/jobpost'));

			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');

			if ($this->input->post('submit') || $this->input->post('submit_done')){

				$record = $_POST['cstm'];

				$er = array();

				//echo "<pre>"; print_r($record); exit;

				if(empty($record['job_title'])) $er['title']="Title required";

				if(empty($record['location'])) $er['location']="Location required";

				$pid=$record['post_id'];

				$sid=$record['sect_id'];

				if(!$er) {

					//echo "<pre>"; print_r($record); exit;

					$this->applicant->updateJobPostContent($record,$pid,$sid);

					if($this->input->post('submit_done'))

						redirect(base_url() . 'interviewer/jobpost');

					else

						redirect(base_url() . 'interviewer/jobpost/edit/'.$id);

				}

				$this->_data['er']=$er;

				$this->_data['record']=$record;

			}

			

			$this->_data['record']=$record;

			//echo "<pre>"; print_r($record);

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/jobPost-edit', $this->_data);

		}	

		else if($pam3=="view") {

			$this->_data['record'] = $this->applicant->get_job($id);

			$this->_data['section'] = $this->applicant->get_jobsection($id);

			$this->load->view('interview/jobpost-view', $this->_data);

		}

		else {

			

			$this->_data['jobpost'] = $this->applicant->get_all_jobpost();

			$this->load->view('interview/jobPosting-list', $this->_data);

		}

	}

	

	

	//Applicants

	function applicant($action = NULL)

	{

		/*$this->load->library('excel');

		$this->load->library('parsecsv');

		$csv = new Parsecsv();*/

		$this->_data['ivs'] = 'applicant';

		$pam3 = $this->uri->segment(3);//edit/delete

		$pam4 = $this->uri->segment(4);//contact id

		$this->jobseeker_plan_access($pam4);

		$pam5 = $this->uri->segment(5);//contact id

		$breadcrumbs = array();

		if($pam3=="all") {$breadcrumbs[] = array('label'=>'All Applicants','url'=>base_url('interviewer/applicant/all'));$this->_data['listall'] = 'yes';}

		else if($pam3=="my") {$breadcrumbs[] = array('label'=>'My Applicants','url'=>base_url('interviewer/applicant/my'));$this->_data['mine'] = 'yes';}

		else $breadcrumbs[] = array('label'=>'Target Applicants','url'=>base_url('interviewer/applicant/target'));

		//Get graph data

		if($this->input->post('action')=="graph") {

			$this->ppChartData($this->input->post('cid'),'CA',$this->input->post('gft'));

			echo $this->_data['chartData'];

			exit;

		}

		$atype=0;

		//Promote to employee

		if((int)$pam4 && $pam3=="p2e") {

			$id = (int)$pam4;

			$record=array();

			$record['atype']=1;

			$cid = $this->applicant->save_contact($record,$id);

			redirect(base_url() . 'interviewer/applicant/view/'.$id);

		}

		//Demote to applicant

		if((int)$pam4 && $pam3=="d2a") {

			$id = (int)$pam4;

			$record=array();

			$record['atype']=0;

			$cid = $this->applicant->save_contact($record,$id);

			redirect(base_url() . 'interviewer/applicant/view/'.$id);

		}

		//delete all		

		if($this->input->post('action')=="deleteall") {			

			$record=$this->input->post('recids');

			if($record) {

				foreach($record as $rcid) $this->applicant->delete_contact($rcid);

			}

			redirect(current_url());

		}

		//delete

		if((int)$pam4 && $pam3=="delete") {

			$id = (int)$pam4;

			$record = $this->applicant->get_contact($id,$this->_parent_users);

			if(!$record) redirect(base_url() . 'interviewer/applicant');

				$filename=$record['upload'];

				$document=$_SERVER['DOCUMENT_ROOT']."/betapro/upload/".$filename;

				 unlink($document);

			$this->applicant->delete_contact($id);

			redirect(base_url() . 'interviewer/applicant');

		}

		//edit / view

		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {

			$id = (int)$pam4;

			$record = $this->applicant->get_contact($id,$this->_parent_users);//echo "<pre>";print_r($record);exit;

			if(!$record) redirect(base_url() . 'interviewer/applicant');

		

			if((int)$record['birthdate']) $record['birthdate']=date("m/d/Y",strtotime($record['birthdate']));

			else $record['birthdate']="";

			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);

			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			$this->_data['record'] = $record;

			$breadcrumbs = array();

			if($record['atype']==2){

				$this->_data['ivs'] = '';

				$this->_data['ivjs'] = 'yourprofile';

				$breadcrumbs[] = array('label'=>'Your Profile','url'=>base_url('interviewer/yourprofile'));

				$breadcrumbs[] = array('label'=>ucfirst($record[user_first].' '.$record[user_last]),'url'=>base_url('interviewer/yourprofile'));

			}

			else {

				$breadcrumbs[] = array('label'=>'Applicants','url'=>base_url('interviewer/applicant/my'));

				$breadcrumbs[] = array('label'=>ucfirst($record[user_first].' '.$record[user_last]),'url'=>base_url('interviewer/applicant/view/'.$id));

			}

			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');			

			//Quick Update Contact record

			$this->quick_update_contact($id);

		}

		$this->_data['breadcrumbs']=$breadcrumbs;

		

		

		//Edit

		if($pam3=="edit") {

			$id = (int)$pam4;

			$breadcrumbs = array();

			if($record['atype']==2){

				$this->_data['ivs'] = '';

				$this->_data['ivjs'] = 'yourprofile';

				$breadcrumbs[] = array('label'=>'Your Profile','url'=>base_url('interviewer/yourprofile'));

			}

			else{

				$breadcrumbs[] = array('label'=>'Applicants','url'=>base_url('interviewer/applicant/my'));

			}

			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');

			if($this->input->post('action')=="save") {

				$record=$this->input->post('record');

				$er = array();

				if(empty($record['user_first'])) $er['user_first']="User first name required";

				if(empty($record['user_last'])) $er['user_last']="User last name required";

				

				if(!empty($record['email'])) {

					$this->load->helper('email');

					if (!valid_email($record['email'])) $er['email']="Enter valid email address";

				}

				if(!$er) {

					$address1 = $record['amail'];

					$address2 = $record['other'];

					unset($record['amail']);

					unset($record['other']);

					unset($record['share_user_title']);

					if(!$id) $record['create_date']=date("Y-m-d H:i:s");

					$record['modify_date']=date("Y-m-d H:i:s");

					if(!empty($record['birthdate'])) {

						$tmpdate = explode("/",$record['birthdate']);//m/d/y-012

						$record['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201

					}

					$atype=$record['atype'];

					$record['target']=$record['target']?1:0;

					$cid = $this->applicant->save_contact($record,$id);

					

					if($cid) {

						$this->applicant->delete_address($id,'C');

						$address1 = array_filter($address1);

						if($address1) {

							$address1['parent_id']=$cid;

							$address1['adr_type']='amail';

							$address1['parent_type']='C';

							$this->applicant->save_address($address1);

						}

						$address2 = array_filter($address2);

						if($address2) {

							$address2['parent_id']=$cid;

							$address2['adr_type']='other';

							$address2['parent_type']='C';

							$this->applicant->save_address($address2);

						}

					}

					if($atype==2){

						redirect(base_url() . 'interviewer/yourprofile');

					}else {

						redirect(base_url() . 'interviewer/applicant/view/'.$cid);

					}

				}

				$this->_data['er']=$er;

				$this->_data['record']=$record;

			}

			if(!$record['share_user_title']) {

				$record['share_user_id']=$this->_user_id;

				$sUser = $this->applicant->get_CurrentUser($record['share_user_id']);

				$record['share_user_title']=ucfirst($sUser[0]->usrname);

			}

			$this->_data['record']=$record;

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/applicant-edit', $this->_data);

		}

		else if($pam3=="view") {

			//Prospect Points

			$total_points = $this->crm->get_totalpoints_count($id,'CA');

			if($total_points[ipt]<>NULL) {

				$this->_data['total_points'] = $total_points;

				$this->ppChartData($id,'CA');

			}

			$this->_data['notes_list2'] = $this->applicant->get_all_notes($id,'C','exp',10);

			$this->_data['notes_list3'] = $this->applicant->get_all_notes($id,'C','edu',10);

			$this->_data['notes_list4'] = $this->applicant->get_all_notes($id,'C','skill',10);

			$this->_data['notes_list5'] = $this->applicant->get_all_notes($id,'C','docu',10);

			

			$this->_data['notes_list']  = $this->applicant->get_all_notes($id,'C','note',10);

			$this->_data['otasks_list'] = $this->applicant->get_all_tasks($id,'C',10,2);

			$this->_data['atasks_list'] = $this->applicant->get_all_tasks($id,'C',10,1);

			$this->load->view('interview/applicant-view', $this->_data);

		}	

		else {

			$target=1;

			$atype=" atype=0";

			if($_GET['stg']) { $stg= $_GET['stg']; $atype=" atype=0 and stage='$stg'"; }

			$owner=$this->_user_id;

			if($pam3=="all") {$owner=0;$target=0;}

			else if($pam3=="my") { $target=0;  }

			//$this->_data['contacts'] = $this->applicant->get_all_contacts($owner,$target,$this->_parent_users,0,'atype=0');

			$this->_data['contacts'] = $this->applicant->get_all_contacts($owner,$target,$this->_parent_users,0,$atype);

			$this->load->view('interview/applicant-list', $this->_data);

		}

	}

	//Prospect Points

	public function ppChartData($id,$sect='CA',$gft=1)

	{

		$tDt1 = date("Y-m-d");

		$tDt2 = date("Y-m-d");

		$dtF = "j-M";

		//echo $gft;exit;

		if($gft=='') $gft=1;

		if($gft==1) {$tDt1 = date("Y-m-d",strtotime($tDt1)-30*24*60*60);$dtF = "j-M";}

		else if($gft==2){$tDt1 = date("Y-m-01",strtotime($tDt1));$dtF = "j-M";}

		else if($gft==3){

			$dtF = "j-M";

			$tDt1 = date("Y-m-01",strtotime($tDt1));

			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);

			$tDt1 = date("Y-m-01",strtotime($tDt2));

		} else if($gft==4){

			$tDt1 = date("Y-m-01",strtotime($tDt1));

			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);

			$tDt1 = date("Y-m-01",strtotime($tDt2)-3*30*24*60*60);

		} else if($gft==5){

			$tDt1 = date("Y-m-01",strtotime($tDt1));

			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);

			$tDt1 = date("Y-m-01",strtotime($tDt2)-6*30*24*60*60);

		} else if($gft==6){

			$tDt1 = date("Y-m-01",strtotime($tDt1));

			$tDt2 = date("Y-m-d",strtotime($tDt1)-24*60*60);

			$tDt1 = date("Y-m-01",strtotime($tDt2)-12*30*24*60*60);

		} else {$tDt1 = date("Y-m-d",strtotime($tDt1)-6*24*60*60);$dtF = "j-M-Y";}

		//echo " $tDt1 - $tDt2 ";

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

		//$chartData[] = array('Day', $y1, $y2);			

		$results = $this->crm->get_points_list($id,$sect,"(pdate>='$tDt1' AND pdate<='$tDt2')");

		$tDt1 = strtotime($tDt1);

		$tDt2 = strtotime($tDt2);

		if($results) {

			foreach($results as $c) {

				while($tDt1<strtotime($c->pdate)){

					$chartData[]= array(date($dtF,$tDt1), $y1, $y2);

					$tDt1 = $tDt1+24*60*60;

				}			

				$tDt1=strtotime($c->pdate);

				$tmpmname =date($dtF,$tDt1);

				$y1 += $c->ipt;

				$y2 += $c->ppt;

				if($mname==$tmpmname) $chartData[count($chartData)-1]= array($tmpmname, $y1, $y2);

				else $chartData[]= array($tmpmname, $y1, $y2);

				$mname = $tmpmname;

				$tDt1 = $tDt1+24*60*60;

			}

		}

		while($tDt1<=$tDt2){

			$chartData[]= array(date($dtF,$tDt1), $y1, $y2);

			$tDt1 = $tDt1+24*60*60;

		}

		/*if(in_array($gft,array(0,1,2,3))!=FALSE && count($chartData)) {

			//echo "<pre>";

			//print_r($chartData);

			$chartData = array_chunk($chartData,15);

			$chartData = $chartData[0];

			print_r($chartData);

			//echo "</pre>";

		}*/

		$this->_data['chartData'] = json_encode($chartData);

		$this->_data['gft'] = $gft;

	}

	//Employee

	function employee($action = NULL)

	{

		/*$this->load->library('excel');

		$this->load->library('parsecsv');

		$csv = new Parsecsv();*/

		$this->_data['ivs'] = 'employee';

		$pam3 = $this->uri->segment(3);//edit/delete

		$pam4 = $this->uri->segment(4);//contact id

		$pam5 = $this->uri->segment(5);//contact id

		$breadcrumbs = array();

		if($pam3=="all") {$breadcrumbs[] = array('label'=>'All Employees','url'=>base_url('interviewer/emoloyee/all'));$this->_data['listall'] = 'yes';}

		else if($pam3=="my") {$breadcrumbs[] = array('label'=>'My Employees','url'=>base_url('interviewer/employee/my'));$this->_data['mine'] = 'yes';}

		else $breadcrumbs[] = array('label'=>'Target Employees','url'=>base_url('interviewer/employee/target'));

		//Promote to employee

		if((int)$pam4 && $pam3=="p2e") {

			$id = (int)$pam4;

			$record=array();

			$record['atype']=1;

			$cid = $this->applicant->save_contact($record,$id);

			redirect(base_url() . 'interviewer/employee/view/'.$id);

		}

		//Demote to applicant

		if((int)$pam4 && $pam3=="d2a") {

			$id = (int)$pam4;

			$record=array();

			$record['atype']=0;

			$cid = $this->applicant->save_contact($record,$id);

			redirect(base_url() . 'interviewer/employee/view/'.$id);

		}

		//delete all		

		if($this->input->post('action')=="deleteall") {			

			$record=$this->input->post('recids');

			if($record) {

				foreach($record as $rcid) $this->applicant->delete_contact($rcid);

			}

			redirect(current_url());

		}

		//delete

		if((int)$pam4 && $pam3=="delete") {

			$id = (int)$pam4;

			$record = $this->applicant->get_contact($id,$this->_parent_users);

			if(!$record) redirect(base_url() . 'interviewer/employee');

			$this->applicant->delete_contact($id);

			redirect(base_url() . 'interviewer/employee');

		}

		//edit / view

		if((int)$pam4 && ($pam3=="edit" || $pam3=="view")) {

			$id = (int)$pam4;

			$record = $this->applicant->get_contact($id,$this->_parent_users);//echo "<pre>";print_r($record);exit;

			if(!$record) redirect(base_url() . 'interviewer/employee');

			//Send to Salesforce

			if($pam5=="send") {

				$this->_data['sfMode']="cr-$id";

				$this->_data['sfRecord']=$record;

				$this->salesforce();

			}

			

			if((int)$record['birthdate']) $record['birthdate']=date("m/d/Y",strtotime($record['birthdate']));

			else $record['birthdate']="";

			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);

			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			$this->_data['record'] = $record;

			$breadcrumbs = array();

			$breadcrumbs[] = array('label'=>'Employees','url'=>base_url('interviewer/employee/my'));

			$breadcrumbs[] = array('label'=>ucfirst($record[user_first].' '.$record[user_last]),'url'=>base_url('interviewer/employee/view/'.$id));

			//if($pam3=="view") $breadcrumbs[] = array('label'=>'View');			

			//Quick Update Contact record

			$this->quick_update_contact($id);

		}

		$this->_data['breadcrumbs']=$breadcrumbs;

		

		

		//Edit

		if($pam3=="edit") {

			$id = (int)$pam4;

			$breadcrumbs = array();

			$breadcrumbs[] = array('label'=>'Employees','url'=>base_url('interviewer/employee/my'));

			$breadcrumbs[] = array('label'=>$id?"Edit":'Add New');

			if($this->input->post('action')=="save") {

				$record=$this->input->post('record');

				$er = array();

				if(empty($record['user_first'])) $er['user_first']="User first name required";

				if(empty($record['user_last'])) $er['user_last']="User last name required";

				if(!empty($record['email'])) {

					$this->load->helper('email');

					if (!valid_email($record['email'])) $er['email']="Enter valid email address";

				}

				if(!$er) {

					$address1 = $record['amail'];

					$address2 = $record['other'];

					unset($record['amail']);

					unset($record['other']);

					unset($record['share_user_title']);

					if(!$id) $record['create_date']=date("Y-m-d H:i:s");

					$record['modify_date']=date("Y-m-d H:i:s");

					if(!empty($record['birthdate'])) {

						$tmpdate = explode("/",$record['birthdate']);//m/d/y-012

						$record['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201

					}

					$record['target']=$record['target']?1:0;

					$record['atype']=1;

					$cid = $this->applicant->save_contact($record,$id);

					if($cid) {

						$this->applicant->delete_address($id,'C');

						$address1 = array_filter($address1);

						if($address1) {

							$address1['parent_id']=$cid;

							$address1['adr_type']='amail';

							$address1['parent_type']='C';

							$this->applicant->save_address($address1);

						}

						$address2 = array_filter($address2);

						if($address2) {

							$address2['parent_id']=$cid;

							$address2['adr_type']='other';

							$address2['parent_type']='C';

							$this->applicant->save_address($address2);

						}

					}

					

					redirect(base_url() . 'interviewer/employee/view/'.$cid);

				}

				$this->_data['er']=$er;

				$this->_data['record']=$record;

			}

			if(!$record['share_user_title']) {

				$record['share_user_id']=$this->_user_id;

				$sUser = $this->applicant->get_CurrentUser($record['share_user_id']);

				$record['share_user_title']=ucfirst($sUser[0]->usrname);

			}

			$this->_data['record']=$record;

			$this->_data['breadcrumbs']=$breadcrumbs;

			$this->load->view('interview/applicant-edit', $this->_data);

		}

		else if($pam3=="view") {

			$this->load->view('interview/applicant-view', $this->_data);

		}	

		else {

			$target=1;

			$owner=$this->_user_id;

			if($pam3=="all") {$owner=0;$target=0;}

			else if($pam3=="my") $target=0;

			$this->_data['contacts'] = $this->applicant->get_all_contacts($owner,$target,$this->_parent_users,0,'atype=1');

			$this->load->view('interview/applicant-list', $this->_data);

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

				}

			} else unset($record['email']);

			

			if(!$er) {

				$address1 = $record['amail'];

				unset($record['amail']);

				unset($record['share_user_title']);					

				$record['modify_date']=date("Y-m-d H:i:s");

				if(!empty($record['birthdate'])) {

					$tmpdate = explode("/",$record['birthdate']);//m/d/y-012

					$record['birthdate']="{$tmpdate[2]}-{$tmpdate[0]}-{$tmpdate[1]}";//y-m-d 201

				}

				$record['target']=$record['target']?1:0;

				$record['sstrained']=(int)$record['sstrained'];
				$record['sstrained2']=(int)$record['sstrained2'];
				$record['pay_rate']=(float)$record['pay_rate'];

				$cid = $this->applicant->save_contact($record,$id);

				//Mailing Address

				if($cid && $eblock=="address") {

					$this->applicant->delete_address($id,'C');

					$address1 = array_filter($address1);

					if($address1) {

						$address1['parent_id']=$cid;

						$address1['adr_type']='amail';

						$address1['parent_type']='C';

						$this->applicant->save_address($address1);

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

				} /*else if($eblock=="sstrained") {

					$string = $erecord['sstrained']?"1":"0";

				} */else if($eblock=="address" && $address1) {

					$address1 = $erecord['amail'];

					$address1 = array_filter($address1);

					$string = implode(", ",$address1);

				} else if($eblock=="user_first") {

					$string = $erecord['user_prefix']." ".$erecord['user_first']." ".$erecord['user_last'];

				} else if($eblock=="email" && $erecord['email']) {

					$string = '<a href="mailto:'.$erecord['email'].'">'.$erecord['email'].'</a>';

				} else if($eblock=="linkedin" && $erecord['linkedin']) {

					$string = '<a href="'.$erecord['linkedin'].'" target="_blank">View Profile</a>';		

				} else if($eblock=="website" && $erecord['website']) {

					$string = '<a href="'.$erecord['website'].'" target="_blank">'.$erecord['website'].'</a>';				
				} else if($eblock=="pay_rate") {

					$string = $erecord['pay_rate']>0?'$'.number_format($erecord['pay_rate'],2):'';	

				} else if(($eblock=="phone" || $eblock=="asst_phone" || $eblock=="mobile" || $eblock=="other_phone") && $erecord[$eblock]) {

					$string = '<a href="tel:'.$erecord[$eblock].'">'.$erecord[$eblock].'</a>';		

				} else if($eblock=="description" && $erecord['description']) {

					$string = str_replace("\n","<br>",$erecord[description]);		

				} else if($eblock=="custom1_value") {

					$string = $erecord[custom1_value];

				} else if($eblock=="custom2_value") {

					$string = $erecord[custom2_value];

				} else if($eblock=="custom3_value") {

					$string = $erecord[custom3_value];

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

	

	//Labor Tool

	function laborpool($action = NULL)

	{

		/*$this->load->library('excel');

		$this->load->library('parsecsv');

		$csv = new Parsecsv();*/

		$this->_data['ivs'] = 'pool';

		$pam3 = $this->uri->segment(3);//edit/delete

		$pam4 = $this->uri->segment(4);//contact id

		$this->jobseeker_plan_access($pam4);

		$pam5 = $this->uri->segment(5);//contact id

		$breadcrumbs = array();

		$breadcrumbs[] = array('label'=>'Labor Pool','url'=>base_url('interviewer/laborpool'));

		$atype=2;

		$this->_data['atype']=$atype;

		//edit / view

		if((int)$pam3) {

			$id = (int)$pam3;

			$record = $this->applicant->get_contact($id,array(0),1);//echo "<pre>";print_r($record);exit;

			if(!$record) redirect(base_url() . 'interviewer/applicant');

		

			if((int)$record['birthdate']) $record['birthdate']=date("m/d/Y",strtotime($record['birthdate']));

			else $record['birthdate']="";

			if(!$record['share_user_id']) $record['share_user_id']=$this->_user_id;

			$sUser = $this->crm->get_CurrentUser($record['share_user_id']);

			$record['share_user_title']=ucfirst($sUser[0]->usrname);

			$this->_data['record'] = $record;

			if($record['atype']==2 && $record['target']==1){

				//Add as Applicant

				if($pam4=="get") {					

					$user_id =  $_SESSION['ss_user_id'];

					if($record['userid']==$user_id) {

						$er= "You are the owner of this record, so cant add.";

					} else {

						$job_applicant=$this->applicant->user_applied_job($record['email'],'userid='.$user_id);

						if($job_applicant) {

							$er= "You already had this record as applicant.";

						} else {

							$this->copy_profile_to_applicant($record);

							$er="This record added as applicant.";

						}

					}

					$_SESSION['er']= $er;

					redirect(base_url() . 'interviewer/laborpool/'.$id);

				}

				if($_SESSION['er']) {

					$er = array($_SESSION['er']);

	     	        unset($_SESSION['er']);

					$this->_data['error'] = $er;

				}

			

				$this->_data['ivs'] = 'pool';

				$this->_data['ivjs'] = '';

				$breadcrumbs[] = array('label'=>ucfirst($record[user_first].' '.$record[user_last]),'url'=>base_url('interviewer/laborpool/'.$id));

				$this->_data['breadcrumbs']=$breadcrumbs;

				$atype=2;

				$this->_data['contacts']= $record;

				$this->_data['notes_list2'] = $this->applicant->get_all_notes($id,'C','exp');

				$this->_data['notes_list3'] = $this->applicant->get_all_notes($id,'C','edu');

				$this->_data['notes_list4'] = $this->applicant->get_all_notes($id,'C','skill');

				$this->_data['notes_list5'] = $this->applicant->get_all_notes($id,'C','docu');

				$this->load->view('interview/job-yourprofile-view', $this->_data);

			} else redirect(base_url() . 'interviewer/laborpool');

		}

		$this->_data['breadcrumbs']=$breadcrumbs;

		if(!$pam3){

			$owner=0;$target=0;

			$this->_data['contacts'] = $this->applicant->get_all_contacts($owner,$target,$this->_parent_users,0,'atype=2',1);

			$this->load->view('interview/applicant-list', $this->_data);

		}

	}

	//Job Questions - Interview Builder

	//builder

	function builder($action = NULL)

	{

		$breadcrumbs = array();		

		$breadcrumbs[] = array('label'=>'Interview Builder','url'=>base_url('interviewer/builder'));

		$this->_data['breadcrumbs']=$breadcrumbs;

		$this->_data['ivs'] = 'builder';

		$userid = $_SESSION['ss_user_id'];

		$this->_data['allIntvQuestion'] = $this->QuestionModel->getAllInterViewQuestion($userid);

		$this->load->view('interview/builder', $this->_data);		

	}

	//Question Add/Edit

	function question($id = NULL)

	{

		$breadcrumbs = array();		

		$breadcrumbs[] = array('label'=>'Interview Builder','url'=>base_url('interviewer/builder'));



		$this->_data['ivs'] = 'builder';

		$qinfo = array();

		if($id) {

			$qinfo = $this->QuestionModel->question_get($id);		

			if(!$qinfo) redirect(base_url('interviewer/builder') );

			$breadcrumbs[] = array('label'=>'Question List','url'=>base_url('interviewer/question/'.$id));

			if($qinfo['identify_attr']) {

				$identify_attrs = explode(",",$qinfo['identify_attr']);

				$idfQuests = $this->QuestionModel->identify_attributes($identify_attrs);

				if($idfQuests) $qinfo['identify_attributes'] = $idfQuests;

			}

			$Quest_attr = $this->QuestionModel->question_attributes($id);

			if($Quest_attr) {

				$qatr = array('attrib'=>array(),'intro'=>array(),'closing'=>array());

				foreach($Quest_attr as $quest) {

					if($quest->attr_id==70) $qatr['intro'][]=$quest;

					else if($quest->attr_id==71) $qatr['closing'][]=$quest;

					else $qatr['attrib'][]=$quest;

				}

				$qinfo['questions'] = $qatr;

			}

		}

		else $breadcrumbs[] = array('label'=>'Question List','url'=>base_url('interviewer/question'));

		$this->_data['breadcrumbs']=$breadcrumbs;

		$this->_data['qinfo'] = $qinfo;

		//$userid = $_SESSION['ss_user_id'];

		//$this->_data['allIntvQuestion'] = $this->QuestionModel->getAllInterViewQuestion($userid);

		$this->_data['profile_attribs'] = $this->category_model->profileattributes();

		$this->load->view('interview/question-edit', $this->_data);		

	}

	//Question Attributes

	function AjaxQuestAttrs($action = NULL)

	{

		$attrIds=$this->input->post('aids');

		$s3Ids=$this->input->post('s3ids');

		$this->_data['s3Ids'] = $s3Ids?explode(",",$s3Ids):array();

		$this->_data['all_attributes'] = $this->attribute->getAttibuteWithIdentAttr($attrIds);

		$this->load->view('interview/attrQuestion',$this->_data);

	}

	//Intro/Closing Questions

	function getQuesByAttribute($attrID=NULL)

	{

		$attrID=$this->input->post('aid');

		$nsIds=$this->input->post('nsIds');

		$this->_data['nsIds'] = $nsIds?explode(",",$nsIds):array();

		$this->_data['attribute_info']=$this->attribute->getAttributeWithID($attrID);

		$this->load->view('interview/getAjaxQestionList2',$this->_data);

		

	}

	//Save Question

	function Question_save()

	{

		$qTitle=$this->input->post('qTitle');

		$qId=$this->input->post('qId');

		if(!$qId) $qId=0;

		$qJIAttrib=$this->input->post('qJIAttrib');

		$qQuestions=$this->input->post('qQuestions');

		//Save Job

		$qdata = array('interview_ques_name'=>$qTitle,'identify_attr'=>$qJIAttrib);

		$Quest_Id = $this->QuestionModel->question_save($qdata,$qId);

		if($Quest_Id) {

			//Get attribute Questions

			$Quest_attr = $this->QuestionModel->question_attributes($Quest_Id);

			$Quest_attrs = array();

			if($Quest_attr) {

				foreach($Quest_attr as $qa) $Quest_attrs[]=$qa->ques_id;

			}

			$saved_ids = array();

			//Save Attribute Questions

			if($qQuestions) {

				$questions = explode(",",$qQuestions);

				$intros = array();

				foreach($questions as $intro)

				{

					$saved_ids[]=$intro;

					if(in_array($intro,$Quest_attrs)!==FALSE) continue;

					$intros[]= array('ques_id' => $intro,'interv_ques_id' => $Quest_Id);

				}

				if($intros) $this->QuestionModel->saveInterViewWithQuestionID($intros);	

			}

			$rm_ids = array_diff($Quest_attrs, $saved_ids);

			if($rm_ids) {

				$this->QuestionModel->question_attributes_delete($Quest_Id,$rm_ids);

			}

			echo $Quest_Id;

		} else echo "Unable to save information, please reload again.";

	}

	//end of Job Questions

	public function deleteAttributeFromList($attrId)

	{

		$user_id=$_SESSION['ss_user_id'];

		$this->attribute->deleteAttr($attrId);

		$question=$this->QuestionModel->getAllInterViewQuestion($user_id);

		foreach($question as $ques){

			$qId=$ques['interv_ques_id'];

			if($ques['identify_attr']!="") $attr= explode(",",$ques['identify_attr']);

			$key=array_search($arrId,$attr);

			if($key!=FALSE){

				unset($attr[$key]);

				$qJIAttrib=implode(",",$attr);

				$qdata = array('identify_attr'=>$qJIAttrib);

				$Quest_Id = $this->QuestionModel->question_save($qdata,$qId);

			}

		}

		

	}

	

	/**

	 *   dynamic add attribute in database

	 */

	public function addAttrDynamic()

	{

		$attr_name = $this->input->post('attrname');

		$attr_id = $this->input->post('attr_id');

		//$cuser_id = $this->session->userdata('userid');

		$cuser_id = $this->_user_id;

		$new_attr_id = $this->jobprofile_model->dynamicAddAttr($cuser_id,$attr_id,$attr_name);

		echo "<div class='ui-state-highlight' id='attr-".$new_attr_id."' >$attr_name<input type='hidden' name='attribute[]' class='idattrbs' value='$new_attr_id' /> 

		<div style='float:right; width:8px;cursor:pointer;font-size:10px;'><a onclick='deleteAttr(".$new_attr_id.")'><span style='cursor:pointer; color:#C6C6C6; font-weight:bold;  font-size:10px;'>X</span></a></div> </div>";

		die();

	}

	

	public function previewinterviewProfile($qset_id = null)

	{

		$this->_data['ivs'] = 'builder';

		$userid = $this->session->userdata('userid');

		$cur_list_que_id = $this->session->userdata('cur_list_que_id');

		//var_dump(!$cur_list_que_id); exit;

		$isCloseOk = $this->session->userdata('close_ok');

		

		if(array_key_exists('QUestionSubmit',$_POST) && $_POST['QUestionSubmit'] == 'Save' && false)

		{

			$AllQuestion_ID = $this->input->post('Question_ID');

			if($AllQuestion_ID == false)

			{

				$this->session->set_flashdata('error','Please drag question from right side to left side panel.');

				redirect($_SERVER['HTTP_REFERER']);

			}

			

			// form submitted, where 'QUestionSubmit' is the name of submit button			

			//$savedata['interview_ques_name'] = $this->input->post('QuestionName');

			//$savedata['job_id'] = $this->input->post('jobProfileID');

			//$savedata['user_id'] = $userid;

			//$GetInterViewQuestionID = $this->QuestionModel->addquestions($savedata);

			$GetInterViewQuestionID = $qset_id;

			

			// now update join table with question_id and interview-question-id  

			if($GetInterViewQuestionID)

			{

				

				// var_dump($AllQuestion_ID); die();

				$saveAuestionID = array();

				if(is_array($AllQuestion_ID)){

					foreach($AllQuestion_ID  as $singleQuesID)

					{

						$saveAuestionID[]= array(

												'ques_id' => $singleQuesID,

												'interv_ques_id' => $GetInterViewQuestionID

											);	

					}

					$this->QuestionModel->saveInterViewWithQuestionID($saveAuestionID);

				}

			}

			$this->session->set_flashdata('message','Interview Question saved successfully.');

			$this->session->unset_userdata('preview_intr');

			redirect(base_url().'interviewer/builder');

		}

		$this->session->unset_userdata('cur_list_que_id');

		if($qset_id != null)

		{

			$this->_data['qset_id'] = $qset_id;

			$this->db->select('*');			

			$this->db->where('interv_ques_id',$qset_id);

			$questionListId = $this->db->get('interview_question')->row();

			$this->_data['QuestionName'] = $questionListId->interview_ques_name;

			$this->_data['QuestionInfo'] = $questionListId;

			$this->_data['que_details_cur'] = $this->attribute->getAttibuteWithIdentAttr($questionListId->identify_attr);

			$desired_attributes = $this->attribute->getAttibuteWithIdentAttr($questionListId->identify_attr);										

			$this->_data['desired_attributes'] = $desired_attributes;



			//print_r($questionListId);

			

			if($questionListId->interv_ques_id == '')

			{

				$this->session->set_flashdata('Info','NO Questions added for this list, Please edit and Add Questions');

				redirect($_SERVER['HTTP_REFERER']);

			}

			

			// form submitted, where 'QUestionSubmit' is the name of submit button			

			//$savedata['interview_ques_name'] = $this->input->post('QuestionName');

			//$savedata['job_id'] = $this->input->post('jobProfileID');

			$savedata['user_id'] = $userid;

			$isViewOnly = true;

			$this->_data["isViewOnly"] = $isViewOnly;

			//$this->session->set_flashdata('message','Interview Question saved successfully.');

			//$this->session->unset_userdata('preview_intr');

			//redirect(base_url().'questions');

			//echo $questionListId; exit;

			$this->db->select('ques_id');

			$this->db->where('interv_ques_id',$qset_id);

			$questionIds = $this->db->get('interview_qus_question');

			$res = $questionIds->result();

			//print_r($res);

			$ques_ids = array();

			$ques_idsall = array();

			$introQuestion_ID = array();

			$closingQuestion_ID = array();

			foreach($res as $singRes)

			{

				//print_r($singRes); exit;

				$this->db->select('attr_id');

				$this->db->where('ques_id',$singRes->ques_id);

				$attr = $this->db->get('questions')->row();

				if($attr->attr_id == '70')	$introQuestion_ID[] = $singRes->ques_id;

				else if($attr->attr_id == '71')	$closingQuestion_ID[] = $singRes->ques_id;

				else $ques_ids[] = $singRes->ques_id;

				$ques_idsall[] = $singRes->ques_id;

			}



			$previewData = array('QuestionName' => $this->_data['QuestionName'],'Question_ID' => $ques_ids,'QUestionSubmit' => 'Download');

			//echo $this->db->last_query();

			//print_r($questionIds->ques_id);

			

			//$this->session->set_userdata('preview_intr',$previewData);

			$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getQuestionBulkWithID($ques_idsall);

			$this->load->view('interview/final_Question_List',$this->_data);

			if(isset($_POST['QUestionSubmit']) && $_POST['QUestionSubmit'] == 'Download')

			{

				$this->_data['button'] = False;

				$this->_data['que_details_intro'] = $this->QuestionModel->getQuestionBulkWithID($introQuestion_ID);

				$this->_data['que_details_closing'] = $this->QuestionModel->getQuestionBulkWithID($closingQuestion_ID);

				$html = $this->load->view('interview/download.php', $this->_data, TRUE);

				$name = url_title($this->_data['QuestionName']);

				// Creating a File

				$fp = fopen(APPPATH."files/".$name.".doc", "a+");

				ftruncate($fp, 0);			

				fwrite($fp,$html);

				//path to the file

				$file_path=APPPATH.'files/'.$name.".doc";

				//Call the download function with file path,file name and file type

				$this->output_file($file_path, ''.$name.'.doc', 'application/msword');

				exit;

				// $this->_tc_pdf($html, $name);

			}

			return;

		}

		

		

		if(isset($_POST['QUestionSubmit']) && $_POST['QUestionSubmit'] == 'Download') {



			$this->session->set_userdata('preview_intr',$_POST);

        }	

		

		$preview_intr = $this->session->userdata('preview_intr');

		if(empty($preview_intr))

		{

			redirect(base_url().'interviewer/question');	

		}

		$IntroQues=$this->session->userdata('Intro_Ques');

		if(!empty($IntroQues['Question_ID']))

		{

			$introQuestion_ID  = $IntroQues['Question_ID'];

			$this->_data['introQuestion_ID'] = $introQuestion_ID;

			//$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];

			$this->_data['interviewQuestionIntro'] = $this->QuestionModel->getQuestionBulkWithID($introQuestion_ID);

		}

		$closingQues=$this->session->userdata('closing_Ques');

		if(!empty($closingQues['Question_ID']))

		{

			$closingQuestion_ID  = $closingQues['Question_ID'];

			$this->_data['closingQuestion_ID'] = $closingQuestion_ID;

			//$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];

			$this->_data['interviewQuestionClosing'] = $this->QuestionModel->getQuestionBulkWithID($closingQuestion_ID);		

		}

		

		if(!empty($preview_intr['Question_ID']))

		{

			$Question_ID  = $preview_intr['Question_ID'];

			$this->_data['QuestionName'] = $preview_intr['QuestionName'];

			//$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];

			$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getQuestionBulkWithID($Question_ID);

		}

		if(isset($_POST['QUestionSubmit']) && $_POST['QUestionSubmit'] == 'Download')

		{

			$this->_data['button'] = False;

			$this->_data['que_details_intro'] = $this->QuestionModel->getQuestionBulkWithID($introQuestion_ID);

			$this->_data['que_details_closing'] = $this->QuestionModel->getQuestionBulkWithID($closingQuestion_ID);

			$html = $this->load->view('interview/download.php', $this->_data, TRUE);

			$name = url_title($this->_data['QuestionName']);

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			//Call the download function with file path,file name and file type

			//$this->output_file($file_path, ''.$name.'.doc', 'application/msword');

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		/*if($isEdit)

		{

			$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getInterViewQuestionByIDAndUserID($cur_list_que_id,$userid);

			$this->_data['jobProfileID'] = $_POST['jobProfileID'];

			$this->_data['isEdit'] = $isEdit;

		}*/

		$this->load->view('interview/final_Question_List',$this->_data);	

	}

	//Emails and Templates

	//builder

	function emails($action = NULL)

	{

		$breadcrumbs = array();		

		$breadcrumbs[] = array('label'=>'Emails and Templates','url'=>base_url('interviewer/emails'));

		$this->_data['breadcrumbs']=$breadcrumbs;

		$this->_data['ivs'] = 'emails';



		$cmpgid=0;

		$all_templates = array();

		$jpost = $this->applicant->get_activejobpost();

		if($jpost) $cmpgid=$jpost['post_id'];

		$etemplates = $this->campaign->get_etemplates($cmpgid);				

		$this->_data['etemplate'] = $etemplates['templates'];

		$this->_data['temphides'] = $etemplates['hidetemp'];

		$temp_sort = $etemplates['sorttemp'];			

		$block = 'Interview Emails';

		$alltemplates = $this->campaign->get_alltemplates($block);	

		if($temp_sort) {

			$uniq_sorts = array_unique($temp_sort);

			if(count($uniq_sorts)==1 && $uniq_sorts[0]==0) $temp_sort=NULL;

		}		

		if($temp_sort) {

			asort($temp_sort);

			foreach($alltemplates as $vtemp) {

				if(!isset($temp_sort[$vtemp->temp_id])) $temp_sort[$vtemp->temp_id]=0;

			}

			asort($temp_sort);

			$all_templates = $temp_sort;

			foreach($alltemplates as $vtemp) {

				$all_templates[$vtemp->temp_id] = $vtemp;

			}

		} else $all_templates=$alltemplates;

		

		$this->_data['all_templates'] = $all_templates;

		//Campaign dropdowns adding

		$this->_data['drop_jobpost'] = $this->applicant->get_all_jobpost();

		$this->_data['drop_company'] = $this->campaign->get_drop_company();

		$this->load->view('interview/emails-letters', $this->_data);		

	}

	//end of Emails and Templates

	//Compose Mail

	public function compose($action=NULL) {

		$cmpid = 0;

		$jpost = $this->applicant->get_activejobpost();

		if($jpost) $cmpid=$jpost['post_id'];

		$this->_data['ivs'] = "applicant";	

		//Delete saved template

		/*if($this->input->post('action')=="delsTemplate") {

			$etid = $this->input->post('stid');

			$etid = str_replace("T","",$etid);

			$this->crm->delete_email_template($etid);

			exit;

		}*/

		$breadcrumbs = array();

		$parent_id = (int)$action;

		$this->_data['ivs'] = "send_mail";

		//Contact Record

		if($parent_id) {

			$id = (int)$parent_id;

			$parent_record = $this->applicant->get_contact($id,array(0),1);//echo "<pre>";print_r($record);exit;

			if(!$parent_record) redirect(base_url() . 'interviewer/applicant');

			

			$contact_name = ucfirst($parent_record[user_first].' '.$parent_record[user_last]);

			$first_name = ucfirst($parent_record[user_first]);

			$last_name = ucfirst($parent_record[user_last]);

			$contact_email = $parent_record[email];

			$this->_data['parent_id'] = $parent_id;

			$this->_data['atype'] = $parent_record['atype'];

			$this->_data['contact_name'] = $contact_name;

			$this->_data['contact_fname'] = $first_name;

			$this->_data['contact_lname'] 	= $last_name;

			$this->_data['contact_email'] = $contact_email;

			$this->_data['unsubscribed'] = $parent_record['unsubscribed'];

			if($parent_record[atype]==0) {

				$this->_data['ivs'] = "applicant";

				$breadcrumbs[] = array('label'=>'Applicant','url'=>base_url('interviewer/applicant'));

				$breadcrumbs[] = array('label'=>$contact_name,'url'=>base_url('interviewer/applicant/view/'.$parent_id));	

			} else {

				$this->_data['ivs'] = "employee";

				$breadcrumbs[] = array('label'=>'Employee','url'=>base_url('interviewer/employee'));

				$breadcrumbs[] = array('label'=>$contact_name,'url'=>base_url('interviewer/employee/view/'.$parent_id));	

			}

				

			$breadcrumbs[] = array('label'=>'Send Email','url'=>base_url('interviewer/compose/'.$parent_id));

		} else {

			//redirect(base_url() . 'interviewer/applicant');

			//$breadcrumbs[] = array('label'=>'Send Email','url'=>base_url('interviewer/compose'));

			//To load email template

			if($action && strpos($action,"t")!==FALSE && strlen($action)>1) {

				$template_content_id = (int)substr($action,1);

				if($template_content_id) $this->_data['template_content_id'] = $template_content_id;

			} 

			//Load email thread

			if($action && strpos($action,"T")!==FALSE && strlen($action)>1) {

				$thread_id = (int)substr($action,1);

				if($thread_id) {

					$thread_main=$this->crm->get_uemail_templates(array('tid'=>$thread_id));

					if($thread_main) {

						$record=array('tempname'=>$thread_main[0]->tempname,'subject'=>$thread_main[0]->subject,'info'=>$thread_main[0]->content);

						$this->_data['record'] = $record;

						$this->_data['thread_id'] = $thread_id;

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

				if(empty($record['cname'])) $er['cname']="Contact name required";

				if(empty($record['cemail'])) $er['cemail']="Contact email required";

				else {

					$this->load->helper('email');

					if (!valid_email($record['cemail'])) $er['cemail']="Enter valid contact email address";

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

			//SMTP Data

			if($this->_data['smtp_info'] == 0) {

				$response = "Email settings not configured";

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

				} else {

					$data['etype'] = 'interview';

					$peid = $this->crm->save_email_template($data);

				}

				$savedEids[] =$peid;

				//Save schedule Email Templates

				if($peid) {

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

						$data['schtype'] = $record['schtype'][$si];

						$data['schtime'] = $record['schtime'][$si];

						$data['schmin'] = $record['schmin'][$si];

						$data['scham'] = $record['scham'][$si];

						$data['schparent'] = $peid;						

						if($etemp && $record['tid'][$si]) $eid = $this->crm->save_email_template($data,$record['tid'][$si]);

						else {

							$data['etype'] = 'interview';

							$eid = $this->crm->save_email_template($data);

						}

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

			$parent_id = 0;

			$contact_info = $this->crm->search_contact(array('email',$record['cemail'],$this->_parent_users));

			if($contact_info) {

				$parent_id = $contact_info['contact_id'];

				//Unsubscribe

				/*if($contact_info['unsubscribed'] == '1') {

					$response = $record['cname']." ".$record['lname']." Unsubscribed.";

					echo $response;

					exit;

				}*/

			} else {

				/*$cdata = array();

				$cdata['user_first']=$record['cname'];

				$cdata['user_last']=$record['lname'];

				$cdata['email']=$record['cemail'];

				$cdata['share_user_id']=$this->_user_id;

				$cdata['create_date']=date("Y-m-d H:i:s");

				$cdata['modify_date']=date("Y-m-d H:i:s");

				$cdata = array_filter($cdata);

				$parent_id = $this->crm->save_contact($cdata);*/

			}

			//Mail tracking elements adding

			//$rand_key = substr(random_alpha(6),0,6).$user_id.substr(random_alpha(3),0,3);

			//$user_id = (int)substr($rkey,6,strlen($rkey)-9);

			
			$this->load->helper('scripts');
			/*

			$userid = $this->_user_id;

			$rand_key = substr(get_random_alpha_string(6),0,6).$userid.substr(get_random_alpha_string(3),0,3);

			$rand_key2 = substr(get_random_alpha_string(6),0,6).$parent_id.substr(get_random_alpha_string(4),0,4);*/

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

			//Change all links to tracking links

			/*$track_data = array();

			$track_data['content'] = $email_content;

			$track_data['userid'] = $userid;

			$track_data['contactid'] = $parent_id;

			$track_data['template_name'] = $template_name;

			$this->load->helper('scripts');

			$email_content = format_email_tracks($track_data);*/

			

			//echo $email_content;exit;

			//Save email schedules

			if($record['subjects']) 

			//if($record['subjects'] && !isset($record['sametime'])) 

			{

				$schdate = time();

				foreach($record['subjects'] as $si=>$sval) {

					$data = array();

					$data['sch_subject'] = $sval;

					$semail_content = stripslashes($record['infos'][$si]);

					//$semail_content = str_replace("Hello ".$record['cname'],'Hello [Prospect First Name]',$semail_content);

					//$semail_content = str_replace("Hi ".$record['cname'],'Hi [Prospect First Name]',$semail_content);

					$data['sch_content'] = $semail_content;

					$schdate = $schdate+($record['schtype'][$si]==2?7:1)*(int)$record['schcount'][$si]*24*60*60;

					if(isset($record['sametime'])) {

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

					$data['sch_type'] = 'interview';

					$data['sch_etname'] = $saved_template_name?$saved_template_name:stripslashes($record['tnames'][$si]);

					$this->crm->save_scheduled_email($data);

				}

			}

			//Schedule Follow up Task

			if($record['sch']) {

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

				$tid = $this->applicant->save_task($taskdata,0);

			}

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

			

			try {

				//Replace Email Signature

				//$email_content = str_replace('[Email Signature]',$this->_data['email_signature'],$email_content);

			  $toname = $record['cname'];

			  if($record['lname']) $toname .= " ".$record['lname'];

			  /*$mail->AddAddress($record['cemail'], $toname);

			  $mail->SetFrom($smtp['fromemail'], $smtp['fromname']);

			  $mail->Subject = $record['subject'];

			  $mail->MsgHTML($email_content);

			  $mail->Send();*/

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

			  	//Save an interaction Log

			  	/*$categories = crm_options();

				$c=2;

				$s=1;

				$opt=1;

				$sec_val = $categories[$c]['sections'][$s];

				$sec_opt = $sec_val['options'];

				$points = $sec_opt[$opt]['points'];

				$pursuit = $sec_opt[$opt]['pursuit'];

				$iname = $sec_opt[$opt]['name'];

			    $idate = date("Y-m-d");				

				//Create completed task : Log a Call

				//$task_email_content=str_replace("\n","",$task_email_content);

				//task_name field can be used for Template name storing in task table

				$taskdata = array(

							'task_subject'=>"Email Sent",

							'task_name'=>$template_name,

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

				$intr_sno=$c."-".$s."-".$opt;

				$intrdata = $this->crm->check_interaction_date($intr_sno,$idate);

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

							$etinfo->tnames = array_unique($etinfo->tnames);

							$etinfo = json_encode($etinfo);

						} else {

							$etinfo = array('tnames'=>array($template_name));

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

						$etinfo = json_encode($etinfo);

						$update['intr_info']=$etinfo;

					}

					$this->crm->save_interaction_date($update);

				}*/

				//End of scheduled emails sending

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

		//$this->_data['allContacts'] = $this->crm->get_all_contacts(0,0,$this->_parent_users);

		$this->_data['allContacts'] = array();

		//All email templates with user modified data

		$email_templates = array();

		$alltemplates=$this->campaign->get_intervew_Email_templates();

		foreach($alltemplates as $atemplate) {

			$etemplate = $this->campaign->get_etemplate($atemplate->temp_id,$cmpid);

			if($etemplate && $etemplate->temp_title) $atemplate->temp_title=$etemplate->temp_title;

			$email_templates[] = $atemplate;

		}

		$this->_data['templates']=$email_templates;

		//Saved email templates list

		$ewhere = array('etype'=>'interview');

		$uemail_templates=$this->crm->get_uemail_templates($ewhere);

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

		$this->_data['drop_jobpost'] = $this->applicant->get_all_jobpost();

		$this->_data['drop_company'] = $this->campaign->get_drop_company();

		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();

		$this->load->view('interview/compose', $this->_data);	

	}

	

	//apllicant Lookup

	function applicant_lookup()

	{

		$this->_data['contacts'] = $this->applicant->get_all_contacts(0,0,$this->_parent_users,0,'atype=0');

		$this->load->view('interview/applicant-search', $this->_data);

	}

	

	//Qualifier

	function qualifier($action = NULL)

	{

			//ini_set('max_input_vars', -1);

		/*//Get Questions */

		if($this->input->post('act')=="questions" && $this->input->post('id')) {

			$Quest_Id = (int)$this->input->post('id');

			//Get attribute Questions

			//$Quest_attr = $this->QuestionModel->questionList_attributes($Quest_Id);

			$Quest_Ids = $this->QuestionModel->questionId_questions($Quest_Id);

			foreach($Quest_Ids as $Quest_Id){

				foreach($Quest_Id as $val){

					$temp[]=$val;

				}

			}

			$this->_data['Quest_Id']=$temp;

			/*$cat_id=array();

			foreach($Quest_questions as $q=>$Quests){

				$Cat_id=$this->QuestionModel->identify_attributes($Quests->attr_id);

				 $cat_id[] = array('question_id'=>$Quests->ques_id,'question_name'=>$Quests->question_name, 'attr_id'=>$Quests->attr_id, 'cat_id'=>$Cat_id[0]->cat_id);

			}*/

			$attr_list = $this->category_model->profileattributes();		

			if(!$attr_list) $attr_list=array();		

			if($attr_list) {

			

				foreach($attr_list as $atr) { 

				$temparray = array(); //$Quest_questions[$atr->cat_id] = $this->attribute->fetchAttributeWithCatID($atr->cat_id);

					$Quest = $this->attribute->fetchAttributeWithCatID($atr->cat_id);

					foreach($Quest as $quee){

						$allQuestion = $this->attribute->getQuestionWithAttr($quee->attr_id);

						//print_r($allQuestion);

						$temparray=array_merge($temparray,$allQuestion);

					}

					$Quest_questions[$atr->cat_id] = $temparray;

				}

			}

			//intro

			$atrid = 70;

			$attr_intro=$this->attribute->getAttributeWithID($atrid);				

			if($attr_intro) {

				$attr_intro->cat_id = $attr_intro->attr_id;

				$attr_intro->cat_name = $attr_intro->attr_name;

				$Quest_questions[$atrid] = $this->attribute->getQuestionWithAttr($atrid);			

				array_unshift($attr_list, $attr_intro);

			}

			//close

			$atrid = 71;

			$attr_close=$this->attribute->getAttributeWithID($atrid);

			if($attr_close) {

				$attr_close->cat_id = $attr_close->attr_id;

				$attr_close->cat_name = $attr_close->attr_name;

				$Quest_questions[$atrid] = $this->attribute->getQuestionWithAttr($atrid);

				array_push($attr_list,$attr_close);

			}

			//print_r($attr_list); exit;

			$this->_data['Quest_attr'] = $attr_list;

			$this->_data['Quest_questions']=$Quest_questions;

			$this->load->view('interview/qualifier-ajax', $this->_data);

			return;

		}

		$pam3 = $action;

		$pam4 = $this->uri->segment(4);		

		$parent_id = (int)$pam4;

		if($pam3=='applicant' && $parent_id) {

			//Contact qualifier

			$parent_record =$this->applicant->get_notes_parent($parent_id,'CA');

			//print_r($parent_record);

			//exit;

			if(!$parent_record) redirect(base_url() . 'interviewer/qualifier');

			$this->_data['parent_id'] = $parent_id;

			$record['contact']=$parent_id;

			$record['contact_title']=ucfirst($parent_record[user_first].' '.$parent_record[user_last]);

			$this->_data['record']=$record;

			$this->_data['parent_section']="contacts";

		} 

		//Save Qaulifier

		if($this->input->post('action')=="save") {

			$record=$this->input->post('record');

			//echo "<pre>";print_r($_POST);echo 'sssssss';print_r($record);echo "</pre>";exit;

			$qsections = $record['qsections'];

			$er = array();

			//if(empty($record['contact'])) $er['contact']="Contact required";

			if(empty($record['contact']) && empty($record['account'])) $er['contact']="Applicant required";

			if(empty($record['campaign'])) $er['campaign']="QuestionList required";

			$tasknotes='';

			$sect = 0;

			$qpoints = 0;

			

			//foreach($record['qsections'] as $qui=>$ques){

			//print_r($record['section']);

			

			$qcat=array();

			  foreach($record['section'] as $si=>$sblock) {

				$temp = '';

				

				foreach($sblock['task_notes'] as $qi=>$qv) {

					$sectn = $si;

					//echo $qi;

					$sqp = $sblock['qp'][$qi];

					if(!empty($qv) || (isset($sqp) && $sqp<>"0")) {

						$temp .=$sblock['task_label'][$qi]."\n\n";

						if(!empty($qv)) $temp .=" - ".$qv."\n";

						if((isset($sqp) && $sqp<>"0")) {$temp .=" - Quality Points: $sqp\n";$qpoints +=$sqp;  $qcat[$si] += $sqp;}

					}

					$sect = $sectn;

				}

				if($temp) $tasknotes .=$qsections[$si]."\n".$temp;

			}

			

			/*foreach($record['section'] as $si=>$sblock) {

				$temp = '';

				

				foreach($sblock['task_notes'] as $qi=>$qv) {

					$sectn = $si;

					echo $qi;

					exit;

					$sqp = $sblock['qp'][$qi];

					if(!empty($qv) || (isset($sqp) && $sqp<>"0")) {

						$temp .=$sblock['task_label'][$qi]."\n";

						if(!empty($qv)) $temp .=" - ".$qv."\n";

						if((isset($sqp) && $sqp<>"0")) {$temp .=" - Quality Points:$sqp\n";$qpoints +=$sqp;}

					}

					$sect = $sectn;

				}

				if($temp) $tasknotes .=$qsections[$si]."\n".$temp;

			}*/

			if(empty($tasknotes)) $er['notes']="Please enter atleast one notes";

			//echo $tasknotes;exit;

			//print_r($qcat);exit;

			if(!$er) {

				//Applicant Notes

				

				$parent_id = $record['contact'];

				$notes_data = array(

							'notes_title'=>"Questions / Answers",

							'notes_parent'=>'C',

							'notes_parentid'=>$parent_id,

							'notes_info'=>$tasknotes

							);

				$cid = $this->applicant->save_notes($notes_data,0,'note');

				

				//Qaulity points

				foreach($qcat as $qcati=>$qcatp){				

				//if($qpoints<>0) {

				 if($qcatp<>0) {

					$idate = date("Y-m-d");

					//Applicant points

					//check points and save

					$where = array('contact'=>$record['contact'],'cat'=>$qcati,'pdate'=>$idate,'rctype'=>'CA');

					$cont_points = $this->crm->get_points($where);

					if($cont_points) {

						$update_data = array(

								'contact'=>$record['contact'],

								'pdate'=>$idate,

								'cat'=>$qcati,

								'rctype'=>'CA'

								);

						$points_data = array(

								'intpoints'=>$cont_points['intpoints']+$qcatp,

								'purpoints'=>$cont_points['purpoints']

								);		

						$this->crm->save_points($points_data,$update_data);

					} else {

						$points_data = array(

								'contact'=>$record['contact'],

								'cat'=>$qcati,

								'rctype'=>'CA',

								'noteid'=>$cid,

								'pdate'=>$idate,

								'intpoints'=>$qcatp,

								'purpoints'=>0

								);						

						$this->crm->save_points($points_data);

					}

				}

				}

				//redirect(base_url() . 'crm/notes/view/'.$cid);

				echo "YES-".$cid."-".$record['contact'];

				exit;

			

			}

			echo implode("\n",$er);

			exit;

			$this->_data['er']=$er;

			$this->_data['record']=$record;

		}

		$breadcrumbs = array();		

		$breadcrumbs[] = array('label'=>'Applicant Qualifier','url'=>base_url('interviewer/qualifier'));

		$this->_data['breadcrumbs']=$breadcrumbs;

		$this->_data['ivs'] = 'qlf';

		$userid = $_SESSION['ss_user_id'];

		$this->_data['allIntvQuestion'] = $this->QuestionModel->getAllInterViewQuestion($userid);

		//print_r($this->_data['allIntvQuestion']);



		$Quest_questions = array();

		//Common attributes

		$attr_list = $this->category_model->profileattributes();

		//print_r($attr_list);		

		if(!$attr_list) $attr_list=array();		

		if($attr_list) {

		

			foreach($attr_list as $atr) { 

			$temparray = array(); //$Quest_questions[$atr->cat_id] = $this->attribute->fetchAttributeWithCatID($atr->cat_id);

				$Quest = $this->attribute->fetchAttributeWithCatID($atr->cat_id);

				foreach($Quest as $quee){

					$allQuestion = $this->attribute->getQuestionWithAttr($quee->attr_id);

					//print_r($allQuestion);

					$temparray=array_merge($temparray,$allQuestion);

				}

				$Quest_questions[$atr->cat_id] = $temparray;

			}

		}

		//intro

		$atrid = 70;

		$attr_intro=$this->attribute->getAttributeWithID($atrid);				

		if($attr_intro) {

			$attr_intro->cat_id = $attr_intro->attr_id;

			$attr_intro->cat_name = $attr_intro->attr_name;

			$Quest_questions[$atrid] = $this->attribute->getQuestionWithAttr($atrid);			

			array_unshift($attr_list, $attr_intro);

		}

		//close

		$atrid = 71;

		$attr_close=$this->attribute->getAttributeWithID($atrid);

		if($attr_close) {

			$attr_close->cat_id = $attr_close->attr_id;

			$attr_close->cat_name = $attr_close->attr_name;

			$Quest_questions[$atrid] = $this->attribute->getQuestionWithAttr($atrid);

			array_push($attr_list,$attr_close);

		}

		//$this->_data['Quest_attr'] = $attr_list;

		//$this->_data['Quest_questions'] = $Quest_questions;

		$this->load->view('interview/qualifier', $this->_data);

	}

	

	

	

	//Prospect Points

	function prospect($pam = NULL)

	{

		$pam3 = $this->uri->segment(3);

		$this->_data['ivs'] = "prospect";

		$breadcrumbs[] = array('label'=>'Applicant Ranker','url'=>base_url('interviewer/prospect'));

		if($pam3=="0-3-0") {$breadcrumbs[] = array('label'=>'All Applicants','url'=>base_url('interviewer/prospect/0-3-0')); $this->_data['ivs'] = "prospect";}

		else if($pam3=="1-3-0") {$breadcrumbs[] = array('label'=>'My Applicants','url'=>base_url('interviewer/prospect/1-3-0')); $this->_data['ivs'] = "prospect";}

		else if($pam3=="2-3-0")  $breadcrumbs[] = array('label'=>'Target Applicants','url'=>base_url('interviewer/prospect/2-3-0')); 

		$this->_data['breadcrumbs']=$breadcrumbs;

		/*//check for existance in crm database

		$crmpoints = $this->crm->prospect_user_points(array($this->_user_id),'1=1',1);

		if(!$crmpoints) {

			$this->_data['crmdbuser']=0;

			$this->load->view('crm/prospect-points', $this->_data);

			return;

		}*/

		$this->_data['crmdbuser']=1;

		if($pam==NULL) {

			$oUsr=0;

			$oDays=0;

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



		//Attributes

		//Common attributes

		$attr_list = $this->category_model->profileattributes();		

		if(!$attr_list) $attr_list=array();				

		//intro

		$atrid = 70;

		$attr_intro=$this->attribute->getAttributeWithID($atrid);				

		if($attr_intro) {

			$attr_intro->cat_id = $attr_intro->attr_id;

			$attr_intro->cat_name = $attr_intro->attr_name;

			array_unshift($attr_list, $attr_intro);

		}

		//close

		$atrid = 71;

		$attr_close=$this->attribute->getAttributeWithID($atrid);

		if($attr_close) {

			$attr_close->cat_id = $attr_close->attr_id;

			$attr_close->cat_name = $attr_close->attr_name;

			array_push($attr_list,$attr_close);

		}

		$this->_data['Quest_attr'] = $attr_list;

		

		//All Applicants

		//$this->_parent_users = array($this->_user_id);

		//$this->_data['dropdown_users'] = $this->crm->get_all_shared_users($this->_parent_users);

		$atype = " atype=0";

		if($oUsr==0) { $owner=0; $target=0; }

		else if($oUsr==1)  $target=0;

		else if($oUsr==2)  $target=1;

		if($_GET['stg']) { $stg= $_GET['stg']; $atype .=" and stage='$stg'"; }

		if($_GET['job']) { $jaf=$_GET['job']; $atype .=" and job_applied_for='$jaf' "; }

		$applicant_records = $this->applicant->get_all_contacts($owner,$target,$this->_parent_users,0,$atype);

		//Prospect users with date range

		$rctype="CA";

		$shuids = implode(",",$this->_parent_users);

		$dwhere = "userid in ($shuids)";

		$dwhere2 = "userid in ($shuids)";

		if($pam) $dwhere2 .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";

		if($applicant_records) {

			foreach($applicant_records as &$apval) {				

				$qt = 0;

				foreach($attr_list as $aid) {

					$dwhere3 = $dwhere2." and contact=".$apval->contact_id." and cat=".$aid->cat_id;

					$qpoints = $this->crm->applicant_quality_points($dwhere3,$rctype);

					$acat = 'cat'.$aid->cat_id;

					$apval->{$acat} = $qpoints['ipt']?$qpoints['ipt']:0;

					$qt += $qpoints['ipt'];

				}

				//others

				$dwhere4 = $dwhere2." and contact=".$apval->contact_id." and taskid!=0";

				$qpoints = $this->crm->applicant_quality_points($dwhere4,$rctype);	

				$apval->others = $qpoints['ipt']?$qpoints['ipt']:0;

				$qt += $qpoints['ipt']; //others

				$apval->qtotal = $qt;

			}

			

		}

		$this->_data['dropdown_users'] = $applicant_records;



		$shuids = implode(",",$this->_parent_users);

		$dwhere = "u.user_id in ($shuids)";

		

		//Prospect users with date range

		$dwhere2 = "u.user_id in ($shuids)";

		if($pam)$dwhere2 .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";

		//$dwhere2 .= " and p.rctype='CA'";

		$rctype="CA";

		if($oCat) $dwhere2 .= " and cat=$oCat ";

		$datebase_prospect_users = $this->crm->prospect_users($dwhere2,$orderby='',$rctype);

		$prospect_points = array();

		//print_r($datebase_prospect_users);

		//print_r($prospect_points);

		foreach($datebase_prospect_users as $prosp)  $prospect_points[$prosp->user_id]= array($prosp->ipt,$prosp->ppt);

		//print_r($prospect_points[$prosp->user_id]);		

		$this->_data['prospect_users'] = $prospect_points;

		//print_r($prospect_points);

		

		

		

		

		//Prospect Users	

		$rctype="CA";	

		$dwhere = "u.user_id in ($shuids)";

		//if($oUsr) $dwhere = "u.user_id=$oUsr";

		if($oCat) $dwhere .= " and cat=$oCat";

		$prospect_users = $this->crm->prospect_users($dwhere,$orderby='',$rctype);

	//print_r($prospect_users);

		//exit;

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

		}/* else if($oDays==1) {

			$ctemp = $rFormat;

			$ctemp[0]="";

			$chartData1[]= $ctemp;

			$chartData2[]= $ctemp;

		} */

		

		

		//foreach($n=1;$n<=count($prospect_users);$n++) $rFormat[]=0;

		//Points gained usres

		$rctype="CA";

		$dwhere = "u.user_id in ($shuids) ";

		//if($oUsr) $dwhere = "u.user_id=$oUsr";

		if($pam) $dwhere .= " and (pdate BETWEEN '$tDt1' AND '$tDt2')";

		if($oCat) $dwhere .= " and cat=$oCat";

		//$dwhere = "(pdate>='$tDt1' AND pdate<'$tDt2')";

		$prospect_users2 = $this->crm->prospect_users($dwhere,$orderby='',$rctype);		

		//print_r($prospect_users2);

	

		//Line Chart

		//Chart Users

		$pUsers = array();

		//$pUsersPoints = array();

		$Search = array(",",'"');

		$Replace = array("","");		

		foreach($prospect_users2 as $pUsr) {

			$pname = str_replace($Search,$Replace,$pUsr->usrname);

			$pUsers[$pUsr->user_id]=ucfirst($pname);

			//$pUsersPoints[$pUsr->user_id]=array($pUsr->ipt,$pUsr->ppt);			

		}

		//print_r($pUsersPoints);
		$dwhere = " 1=1 ";
		if($pam) $dwhere .= " AND (pdate BETWEEN '$tDt1' AND '$tDt2')";

		if($oCat) $dwhere .= " and cat=$oCat";

		

		//User Points		

		$tDt1 = strtotime($tDt1);

		$tDt2 = strtotime($tDt2);

		if($pUsers && $oDays) {

			$UserIds=array_keys($pUsers);

			$UsrDatePoints=array();

			//['Day 1', 0, 0]

			//$chartData[] = array('Day', $y1, $y2);

			

			$dates = array();

			$di=-1;

			$cInd=-1;

			$rctype="CA";

			$user_points = $this->crm->prospect_user_points($UserIds,$dwhere,$limit=0,$rctype);	

			//print_r($user_points);	

			

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

				$cInd=array_search($uPoints->userid,$UserIds)+1;

				//User date points

				/*$dtIndex = $uPoints->userid."_".$cDt;

				if(array_key_exists($dtIndex,$UsrDatePoints)===FALSE) {

					$dtTemp = $uPoints->intpoints;

					$dtTemp2 = $uPoints->purpoints;

				else {

					$dtTemp=$UsrDatePoints[$dtIndex];

					$dtTemp[0] +=$uPoints->intpoints;

					//$dtTemp[1] +=$uPoints->purpoints;

				}*/	

				

				//$ctemp[$cInd] += $uPoints->intpoints+$uPoints->purpoints;

				//$ctemp[$cInd] += $dtTemp[0]+$dtTemp[1];

				$ctemp[$cInd] += $uPoints->intpoints;

				$ctemp2[$cInd] += $uPoints->purpoints;

				//$ctemp[$cInd+1]= "<p><b>".$cDt.": ".$ctemp[$cInd]."</b></p><p>".$pUsers[$uPoints->userid]."</p><p>Quality Points: ".$dtTemp[0]."</p><p>Pursuit Points:".$dtTemp[1]."</p>";

				$chartData1[$ckey]= $ctemp;

				$chartData2[$ckey]= $ctemp2;

				//$UsrDatePoints[$dtIndex]=$dtTemp;

				//$chartData[$pi]= array($cDt,$uPoints->intpoints+$uPoints->purpoints);

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

		//echo "<pre>";print_r($rFormat);print_r($user_points);print_r($chartData1);print_r($chartData2);echo "</pre>";

		//exit;

		$chartData1 = array_values($chartData1);

		$chartData2 = array_values($chartData2);

		//$chartData[] = array('Day', value1, tooltip1, value2, tooltip2);

		//echo "<pre>";

		//print_r($user_points);print_r($rFormat);

		//print_r($dates);print_r($pUsers);print_r($UserIds);

		//print_r($chartData);print_r($UsrPoints);

		//print_r($UsrDatePoints);

		//echo "</pre>";

		//exit;

		//If there is no entries points table then list all users

		

		if(count($prospect_users)==0) {

			$prospect_users=$this->_data['dropdown_users'];

			//print_r($prospect_users);

			$chartData1 = array();

			$chartData2 = array();

		}

		//print_r($this->_parent_users);

		$this->_data['Jobs']= $this->applicant->job_applied_for($this->_parent_users);

		$this->_data['prospect_points'] = $prospect_users;

		//$this->_data['chartUserPoints'] = $pUsersPoints;

		$this->_data['chartData1'] = json_encode($chartData1);

		$this->_data['chartData2'] = json_encode($chartData2);

		//print_r($this->_data);

		$this->load->view('interview/prospect-points', $this->_data);

	}

}

/* End of file interviewer.php */

/* Location: ./application/controllers/interviewer.php */