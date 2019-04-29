<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
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
		
		if(!$this->config->item('is_local'))
		{
			include(CDOC_ROOT."members/library/Am/Lite.php"); 
                      
            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,29,32), 'Restricted access'); //  This array is Updated by Dev@4489 on 23-Oct-2015
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
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','29','32'));//  This array is Updated by Dev@4489 on 17-April-2014
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
		$this->_data['ivs'] = 'applicant';
	}	
	public function index($id = NULL)
	{
		$this->_data['page'] = 'register';
		redirect(base_url() . 'interviewer/applicant');
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
	//builder
	function builder($action = NULL)
	{
		$this->load->view('interview/builder', $this->_data);
		$this->_data['ivs'] = 'builder';
	}
	// jopb seeker jobs
	function jobs($action = NULL)
	{
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
				$job_applicant=$this->applicant->user_applied_job($job_id,$detail['yemail']);
				if($job_applicant) {
					$er= "You are already applied for this job";
				} else {
					$edata = array('user_first'=>$detail['yfname'],'user_last'=>$detail['ylname'],'user_title'=>$detail['ytitle'].'','phone'=>$detail['yphone'].'','email'=>$detail['yemail'],'userid'=>$jobinfo['user_id'],'share_user_id'=>$jobinfo['user_id'],'jobpost_id'=>$job_id,'atype'=>0,'job_applied_for'=>$jobinfo['job_title'],'stage'=>'Applied');
					$this->applicant->save_applyjob($edata);
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
	
	//Yourprofile
	function yourprofile($action = NULL)
	{
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
			
		if($record)
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
				$this->applicant->delete_notes($id);
			}
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
							$upload['allowed_types'] = 'jpg|docx|csv|xls|xlsx';
							$upload['max_size'] = '2048000';
							$ext = end(explode(".", $_FILES['upload']));
							$upload['file_name'] = $this->user_id."_4".basename($_FILES['upload']);
							$this->load->library('upload', $upload);
							if (!$this->upload->do_upload('upload')) {
								$error = array('error' => $this->upload->display_errors());
							$this->_data['error']=$error;
							} else { 
								$data = $this->upload->data();
								$filename = $data['file_name'];
								$record['upload']=$filename;
							}
						}
						//end document
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
			$record['section'] = $this->applicant->get_jobsection($id); //echo "test"; echo "<pre>";print_r($record); exit;
			
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
					redirect(base_url() . 'interviewer/jobpost');
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
				$document="/home/mhalper2000/public_html/betapro/upload/".$filename;
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
			$owner=$this->_user_id;
			if($pam3=="all") {$owner=0;$target=0;}
			else if($pam3=="my") $target=0;
			$this->_data['contacts'] = $this->applicant->get_all_contacts($owner,$target,$this->_parent_users,0,'atype=0');
			$this->load->view('interview/applicant-list', $this->_data);
		}
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
				} else if($eblock=="address" && $address1) {
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
}
/* End of file interviewer.php */
/* Location: ./application/controllers/interviewer.php */