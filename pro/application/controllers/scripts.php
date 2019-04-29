<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//error_reporting(E_ALL);

/**

 *  This is script class file  scripts.php

 *  

 * responciable to manage all template output content

 *  

 *  PHP 5.2

 *  @auhtor Bineet kumar chaubey

 *  @package controllers

 *  @subpackage scripts

 *  @see

 *  @link

 *  

 */

class Scripts extends CI_Controller {

	/**

	 * Properties

	 */

	private $_data;

	private $_user_id;



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

        $this->load->model('campaign_model', 'campaign');

        $this->load->model('product_model', 'productModel');
		
		$this->load->model('applicant_model', 'applicant');

		

		if(!$this->config->item('is_local'))

		{

			include(CDOC_ROOT."members/library/Am/Lite.php"); 

                      

            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');

			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,29,30,31,32), 'Restricted access'); //  By Dev@4489 24-Oct-2015

			// 9  is for Scripter Pro 3 Month

			// 10 is for Scripter Pro 1 Year
			// 18 is for Pro Lite 1 Year

			

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



            //$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2'));

			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15'));//  This array is Updated by Aavid developer on 17-April-2014
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','29','30','31','32'));//  By Dev@4489 24-Oct-2015

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
			
			//aMember Profile
			$this->_data['aMember'] = array('yname'=>'','yemail'=>'','yphone'=>'');
			$amember_data = Am_Lite::getInstance()->getUser();
			if($amember_data) {
				$this->_data['aMember'] = array('yname'=>ucfirst($amember_data['name_f'].' '.$amember_data['name_l']),'yemail'=>$amember_data['email'],'yphone'=>$amember_data['phone']);
			}

			

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
        $pam2 = $this->uri->segment(2);//template name
        $staffing_emails = array('iautomated-screening-interview-email','ischedule-phone-interview-email','ischedule-interview-email','ischedule-second-interview-email','icandidate-rejection-letter-email');
        if(in_array($pam2, $staffing_emails)!==FALSE) {
        	if($this->_data['AMuserShares']['staffing']==0) redirect(base_url('/'));
        } 
        else if(isset($this->_data['ejobseeker'])) {
        	//jobseeker access ok
        } else 
        //Shared Access to Sales Playbook        
		//if($this->_data['AMuserShares']['playbook']==0) redirect(base_url('/'));

	   
		//By Dev@4489
		$this->jobseeker_plan_access();
		//Check & Get the shared user id for Lite Users
		$_SESSION['OrgUser']=$this->_data['user_id'];
		if($PLSubscribe && !$eSubscribe) {
			$saUser = $this->home->SharedUser($this->_data['user_id']);
			if($saUser) {
				$this->_data['user_id'] = $saUser;
				//if this is defined then Lite user cant access for dynamic editings on HTML page
				$this->_data['eLusrNotBS'] = $saUser;
			}
		}
		////
	   $this->_user_id = $this->_data['user_id'];

       $_SESSION['ss_user_id'] = $this->_user_id;
	   
	   //Verify User Campaigns once
		$ucsid = $this->session->userdata('ss_session_id');
		$uccid = $this->session->userdata('active_campaign');
		if((1 || $uccid) && isset($this->_data['eScripter'])) {
			$user_id =  $this->_user_id;
			$this->db->select('campaign_id');
			$this->db->where('user_id',$user_id);
			$this->db->from($this->config->item('table_campaigns'));
			$this->db->order_by("status", "desc");
			$query = $this->db->get();
			$ucmpdata = $query->result();
			//echo "<pre>";print_r($ucmpdata);echo "</pre>";
			//if($ucsid) 
			{
				$tcmpid = '';
				foreach($ucmpdata as $ucmp) {
					if($ucsid==$ucmp->campaign_id) $tcmpid=$ucmp->campaign_id;
					if(!$tcmpid) $tcmpid=$ucmp->campaign_id;
				}
				if($tcmpid) $this->session->set_userdata('ss_session_id',$tcmpid);
				else $this->session->unset_userdata('ss_session_id');
			}
			if($uccid) {
				$tcmpid = '';
				foreach($ucmpdata as $ucmp) {
					if($uccid==$ucmp->campaign_id) $tcmpid=$ucmp->campaign_id;
					if(!$tcmpid) $tcmpid=$ucmp->campaign_id;
				}
				if($tcmpid) $this->session->set_userdata('active_campaign',$tcmpid);
				else $this->session->unset_userdata('active_campaign');
			}
		}
		//end of Verify User Campaigns once



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

		if(empty($is_product) && isset($this->_data['eScripter']))

		{

			// Add Product into Database

			$status = '2';

			$redirect = base_url().'folder/my-folder';

			$this->defaultNewproduct($redirect, 1, "My first product profile");	

		}

		

		if($session_id = $this->home->get_session_status($this->session->userdata('ss_session_id')))

        {

        	$this->_data['session_status'] = TRUE;

        }

        else 

        {

        	$this->_data['session_status'] = FALSE;

        }



        

		$active_session_id = NULL;

        // Get Active SESSION ID

        if(isset($user_session_id) AND (!$this->session->userdata('ss_session_id')))

        {

        	$this->_data['active_session_id'] = $user_session_id;

        }

        else 

        {

        	$this->_data['active_session_id'] = $this->session->userdata('ss_session_id');

        }

		

        $this->_data['all_sessions'] = $this->home->get_all_sessions();

        $this->_data['total_sessions'] = count($this->_data['all_sessions']);



		/**  now find all active campaign data name drop , company name etc */

		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);

		if($active_campaign_data == false && isset($this->_data['eScripter']))

		{

			//$this->session->set_flashdata('session_msg','Please Create campaign ,company profile and name drop');

			//redirect(base_url()."folder/my-folder");
			$tempCampaign = array('campaign_id'=>0);
			$active_campaign_data = (object)$tempCampaign;

		}

		

		/** campaign info data */

		$this->_data['campaign_info'] = $active_campaign_data;
		//By Dev@4489
		//Qualify questions with responses
		$this->_data['campaign_output_qualify'] = $this->qualify_list_show($active_campaign_data->campaign_id);
		//Get Campaign Value page all anwsers
		$this->_data['campaign_output_tech_val_asnwers'] = $this->campaign->getTechValueAnswersAll($active_campaign_data->campaign_id);
		////

		$this->_data['campaign_output_tech_val'] = $this->campaign->getOutputTechValue($active_campaign_data->campaign_id,1);

		$this->_data['campaign_output_biz_val'] = $this->campaign->getOutputBizValue($active_campaign_data->campaign_id);

		$this->_data['campaign_output_per_val'] = $this->campaign->getOutputPerValue($active_campaign_data->campaign_id);

		$this->_data['campaign_output_tech_pain'] = $this->campaign->getOutputTechPain($active_campaign_data->campaign_id,1);

		$this->_data['campaign_output_biz_pain'] = $this->campaign->getOutputBizPain($active_campaign_data->campaign_id);

		$this->_data['campaign_output_per_pain'] = $this->campaign->getOutputPerPain($active_campaign_data->campaign_id);

		$this->_data['campaign_output_tech_qualify'] = $this->campaign->getOutputTechQualify($active_campaign_data->campaign_id,1);

		$this->_data['campaign_output_biz_qualify'] = $this->campaign->getOutputBizQualify($active_campaign_data->campaign_id);

		$this->_data['campaign_output_per_qualify'] = $this->campaign->getOutputPerQualify($active_campaign_data->campaign_id);

		

		$this->_data['campaign_tech_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'tech_val_summary');

		$this->_data['campaign_biz_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'bus_val_summary');

		$this->_data['campaign_per_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'per_val_summary');

		$this->_data['sale_process_close1'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close1');

		$this->_data['sale_process_close2'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close2');

		$this->_data['sale_process_close3'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close3');

		

		// var_dump($this->_data['campaign_biz_summary']) ; die();

		/** product related query **/

		$this->_data['P_Q1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'P_Q1');

		$this->_data['product_desc'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'P_Desc');

		$this->_data['diff1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB1');

		$this->_data['diff2'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB2');

		$this->_data['diff3'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB3');

		

		$this->_data['negative_impact1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact1');

		$this->_data['negative_impact2'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact2');

		$this->_data['negative_impact3'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact3');

		

		/**  get active session name data */

		$this->_data['active_name_drop_exp'] = $this->campaign->findActiveNameDropForOutput();

		

		/* var_dump($this->_data['active_name_drop_exp']);

		 */  

		/**  find data about company profile **/

		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);
		
		//Signature
		$where = array();
		$where['user_id'] = $_SESSION['OrgUser'];
		$where['field_type'] = 'sign';
		$user_info = $this->home->getUserData($where);
		if($user_info) $user_info = $user_info[0];
		if(isset($user_info->value)) {
			$this->_data['aMember']=unserialize($user_info->value);
		}
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

		$this->_data['company_info'] = $company_info_detail;
		
		$this->_data['job_post'] = $this->applicant->get_activejobpost();
		
		$this->_data['company_meta'] = $this->productModel->getAllMetaValue($company_info_detail->company_id);	
		
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['drop_company'] = $this->campaign->get_drop_company();
		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();
		$this->_data['drop_jobpost'] = $this->applicant->get_all_jobpost();

	}

	//Verify Job seeker pages
	function jobseeker_plan_access(){		
		if(isset($this->_data['ejobseeker'])) {
			if(strpos($_SERVER['REQUEST_URI'],"sales-prospecting-basics")!=FALSE || strpos($_SERVER['REQUEST_URI'],"sales-prospecting-advanced")!=FALSE) {
				//acccess ok
			} else redirect(base_url('folder/sales-prospecting-basics') );
		}
	}

	

	/**

	 *   home page  index page 

	 */

	public function index($id = NULL)

	{

		$this->_data['page'] = 'register';

		redirect(base_url() . 'folder/my-folder');

	}



	function data_clean()

	{

       $get_all_sessions 			= $this->home->get_all_users_sessions();

       $get_all_products 			= $this->home->get_all_users_products();

	   $get_all_users_credibilities = $this->home->get_all_users_credibilities();

	   $get_all_objections 		 	= $this->home->get_all_users_objections();

	   $get_all_users_data 		 	= $this->home->get_all_users_data();



		//echo 'Total Count = ' . count($get_all_sessions) . '<br>';

		//echo 'Total Count = ' . count($get_all_products) . '<br>';

		//echo '<pre>'; print_r($get_all_products);

		//exit();

		$session_ids = array();

		foreach ($get_all_sessions as $sessions)

		{

			$session_ids[] =  $sessions->session_id;

		}



		foreach ($get_all_products as $products)

		{

			if (!in_array($products->session_id, $session_ids)) 

			{

	    		$this->home->delete_session_products($products->session_id);

			}

		}



		foreach ($get_all_users_credibilities as $credibilities)

		{

			if (!in_array($credibilities->session_id, $session_ids)) 

			{

	    		$this->home->delete_session_credibilities($credibilities->session_id);

			}

		}



		foreach ($get_all_objections as $objections)

		{

			if (!in_array($objections->session_id, $session_ids)) 

			{

	    		$this->home->delete_session_objections($objections->session_id);

			}

		}



		foreach ($get_all_users_data as $users_data)

		{

			if (!in_array($users_data->session_id, $session_ids)) 

			{

	    		$this->home->delete_session_users_data($users_data->session_id);

			}

		}



		echo 'Data has been Refined....' ;

		exit();

	}



	/**

	 * Editable Text

	 */

	public function editable() 

	{

		$field = str_replace("edit_","",$_POST['id']);

		$field = explode("__",$field);

		$count = count($field);



		if($count == 3)

		{

			$field_ids = explode("_",$field['0']);

			$product_id = $field_ids['0'];

			$product_data_id = $field_ids['1'];

			$field_type = $field['1'];

			$table_name = $field['2'];

			$value = $_POST['value'];



			if($table_name == 'tpd')

			{

				$data = array('product_id' => $product_id, 'field_type' => $field_type, 'value' => $value);

			}



			if($table_name == 'tud')

			{

				$data = array('user_id' => $product_id, 'field_type' => $field_type, 'value' => $value);

			}



			if($table_name == 'tcd')

			{

				$data = array('c_id' => $product_id, 'field_type' => $field_type, 'value' => $value);

			}



			if($table_name == 'tod')

			{

				$data = array('obj_id' => $product_id, 'field_type' => $field_type, 'value' => $value);

			}



			$this->home->update_description($table_name, $data, $product_data_id);



			echo $value;

		}



		if($count == 2)

		{

			$field_name = $field['0'];

			$table_name = $field['1'];

			$value = $_POST['value'];

			$data = array($field_name => $value);

			$this->home->update_description_users($table_name, $data);

			echo $value;

		}

	}

  

	public function editSession()

	{

		$session_id = str_replace("edit_","",$_POST['id']);

		$value = $_POST['value'];

		$data = array('product_name' => $value);

		// $this->home->update_session_name($session_id, $data);

		$this->productModel->update_product_name($session_id, $data);

		echo $value = $_POST['value'];	

	}



	/**

	 * Prospect Pain HTML for Pdf

	 */

	public function prospect_pain($action = Null) 

	{

		

		

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pain', $this->_data, TRUE);

			$name = 'Prospect-Pain';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'prospect-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/pain', $this->_data);

		}

	}



	/**

	 * Ideal Prospect HTML for Pdf

	 */

	public function ideal_prospect($action = Null) 

	{

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/ideal_prospect', $this->_data, TRUE);

			$name = 'Ideal-Prospect';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'ideal-prospect-profile';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/ideal_prospect', $this->_data);

		}

	}



	/**

	 * Name Drop Statement HTML for Pdf

	 */

	public function drop_statement($action = Null) 

	{

		

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		 

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/drop_statement', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Drop-Statement';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'name-drop-statments';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/drop_statement', $this->_data);

		}

	}



	/**

	 * Silver Bullets HTML for Pdf

	 */

	public function silver_bullets($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/silver_bullets', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Silver-Bullets';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'building-interest';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/silver_bullets', $this->_data);

		}

	}



	/**

	 * Elevator Pitch HTML for Pdf

	 */

	public function elevator_pitch($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/elevator_pitch', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Elevator-Pitch';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'elevator-pitch';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/elevator_pitch', $this->_data);

		}

	}



	/**

	 * Qualifying Question HTML for Pdf

	 */

	public function qualifying_questions($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath(getcwd()));

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/qualifying_questions', $this->_data, TRUE);

			$name = 'Qualifying-Question';

			$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'qualifying-questions';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/qualifying_questions', $this->_data);

		}

	}

        

	/**

	 * Pre Qualifying Question HTML for Pdf

     * Created by Aavid Developer on 06-March-2014

	 */

	public function pre_qualifying_questions($action = Null) 

	{

		

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_qualifying_questions', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Qualifying-Question';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-qualifying-questions';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/pre_qualifying_questions', $this->_data);

		}

	}

    

	/**

	 * Hard Qualifying Question HTML for Pdf

     * Created by Aavid Developer on 06-March-2014

	 */

	public function hard_qualifying_questions($action = Null) 

	{

		

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}
	
	
		$user_id = $_SESSION['ss_user_id'];
		$this->db->select();
		$this->db->from('campaigns');
		$this->db->where('user_id',$user_id);
		$this->db->where('status','1');	
		$record = $this->db->get();	
		//echo $this->db->last_query();
		$active_campaign_res = $record->result();
		//echo '<pre>'; print_r($active_campaign_res); echo '</pre>';		
		$active_campaign = $active_campaign_res[0]->campaign_id;
		//echo $active_campaign;
		//$this->_data['need_want_qus'] = $this->campaign->getallNeedWant($active_campaign);//by Dev@4489
		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489
		
		
		$active_campaign_data_new =  $this->campaign->get_campaign_active($this->_user_id);
		$active_campaign = $active_campaign_data_new->campaign_id;
		
		
		
		$tabdata = $this->campaign->getCatQuestions($active_campaign,$this->_user_id);//by Dev@4489
		$this->_data['tabtitles'] = $tabdata;	
		
		$this->load->helper('scripts');
		$qualifier_data = qualifier_questions();
		
		
		
		
		$this->_data['tech_qualify_pain'] = $this->campaign->getTechQualifyPain($active_campaign);	
		
		if($this->sales_list_show($active_campaign,'tab2'))
		$this->_data['need_want_qus'] =  $this->sales_list_show($active_campaign,'tab2');
		else 
		$this->_data['Need_Want'] = $qualifier_data['questions']['Need_Want'];	
		
		
		//echo '<pre>'; print_r($this->_data['need_want_qus']); echo '</pre>';
		
		//echo '<pre>'; print_r($this->_data['Need_Want']); echo '</pre>';
		//exit;
		
		
		if($this->sales_list_show($active_campaign,'tab3'))
		$this->_data['funding_availability'] =  $this->sales_list_show($active_campaign,'tab3');
		else 
		$this->_data['Funding_Availability'] = $qualifier_data['questions']['Funding_Availability'];	
		
		
		
		if($this->sales_list_show($active_campaign,'tab4'))
		$this->_data['decision_authority'] =  $this->sales_list_show($active_campaign,'tab4');
		else 
		$this->_data['Decision_Authority'] = $qualifier_data['questions']['Decision_Authority'];	
		
				
		if($this->sales_list_show($active_campaign,'tab5'))
		$this->_data['intent_purchase'] =  $this->sales_list_show($active_campaign,'tab5');
		else 
		$this->_data['Competition_Level'] = $qualifier_data['questions']['Competition_Level'];	
		
		//echo "test1232";
		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/hard_qualifying_questions', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Hard-Qualifying-Question';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			// Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'hard-qualifying-questions';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/hard_qualifying_questions', $this->_data);

		}

	}



	/**

	 * Qualifying Question HTML for Pdf

	 */

	public function voicemail($action = Null) 

	{

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script', $this->_data, TRUE);

			$name = 'Voicemail-Scripts';

			$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-scrip';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script', $this->_data);

		}

	}



	/**

	 * Voice Mail Follow UP Question HTML for Pdf

	 */

	public function voicemail_followup($action = Null) 

	{

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;



		// Get data from database to edit the record.



		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_follow_up', $this->_data, TRUE);

			$name = 'Voicemail Follow-up Email';

			$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-voicemail-email-thread';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_follow_up', $this->_data);

		}

	}



	/**

	 * Objection Map HTML for Pdf

	 */

	public function objection_map($action = Null) 

	{

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		//$this->_data['users'] 		= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		//$this->_data['objections'] 	= $this->home->get_all_objections($this->_user_id, $this->_data['active_session_id']);

		$this->_data['action'] = $action;
		//Template
		$params = explode("output/",uri_string());
		$cslug = explode("/",$params[1]);
		$uCustTemplate = $this->campaign->get_template_byslug($cslug[0],$this->_data['campaign_info']->campaign_id);
		
		//By Dev@4489
		//Adding customized objections to oupput
		$active_campaign = $this->_data['campaign_info']->campaign_id;
		$this->_data['objectionInfo'] = $this->campaign->getCampaignObjections($active_campaign);
		//Objection data with responses
		$lastid = 0;
		$Voicemails = false;
		include('interactive/objection_controller.php');if($action == 'download') $is_Page = false;
		else $is_Page = $this->in_array_custom($action,$parts);
		if($is_Page) {
			$this->_data['parts'] = $parts;
		} else {
			$this->_data['lastid'] = $lastid;
			foreach($parts as $pi=>$pv){
				if($pi<=4) continue;
				$oresp = $pv['resp'];
				//echo "<pre>";print_r($oresp);echo "</pre>";
				$this->_data['getresp'] = 1;
				$this->_data['objname'] = $pv['name'];
				$this->_data['rsp'] = 'r1';
				$oresp['respc1']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
				if(isset($oresp['resp2'])) {
					$this->_data['rsp'] = 'r2';
					$oresp['respc2']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
				}
				if(isset($oresp['resp3'])) {
					$this->_data['rsp'] = 'r3';
					$oresp['respc3']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
				}
				$parts[$pi]['resp']=$oresp;
			}
			$this->_data['parts'] = $parts;
		}
		////

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/objection_map', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Objection-Map';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['resp'] = False;

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'objections-map';
			$this->_data['ISshow'] = 1;

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/objection_map', $this->_data);

		}


		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'objections-map';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/objection_map', $this->_data);

		}

	}



	/**

	 * Overview Presentation Map HTML for Pdf

	 */

	public function presentation($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		// $this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/presentation', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Sales-Presentation';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'sales-presentation';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/presentation', $this->_data);

		}

	}



	/**

	 * Indirect Cold Call Scrit Map HTML for Pdf

	 */

	public function indirect_call($action = NULL) 

	{	

		//Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		// $this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/indirect_call', $this->_data, TRUE);

			$name = 'Call_Script_Qualify_Focus';

                        

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'indirect-cold-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/indirect_call', $this->_data);

		}

	}

	



	/**

	 * Direct Cold Call Scrit Map HTML for Pdf

	 */

	public function direct_call($action = Null) 

	{

		

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;



		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action']	= $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/direct_call', $this->_data, TRUE);

			$name = 'Call-Script-Quick-Close';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'direct-cold-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/direct_call', $this->_data);

		}

	}



	/**

	 * First Meeting Script HTML for Pdf

	 */

	public function meeting_script($action = Null) 

	{

		

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;
		
		
		
		$active_campaign_data_new =  $this->campaign->get_campaign_active($this->_user_id);
		$active_campaign = $active_campaign_data_new->campaign_id;
		$tabdata = $this->campaign->getCatQuestions($active_campaign,$this->_user_id);//by Dev@4489
		
		
		$this->load->helper('scripts');
		$qualifier_data = qualifier_questions();
		$this->_data['tabtitles'] = $tabdata;				
		
		$this->load->helper('scripts');
		$qualifier_data = qualifier_questions();
		$this->_data['tech_qualify_pain'] = $this->campaign->getTechQualifyPain($active_campaign);	
		
		if($this->sales_list_show($active_campaign,'tab2'))
		$this->_data['need_want_qus'] =  $this->sales_list_show($active_campaign,'tab2');
		else 
		$this->_data['Need_Want'] = $qualifier_data['questions']['Need_Want'];	
		
		
		if($this->sales_list_show($active_campaign,'tab3'))
		$this->_data['funding_availability'] =  $this->sales_list_show($active_campaign,'tab3');
		else 
		$this->_data['Funding_Availability'] = $qualifier_data['questions']['Funding_Availability'];	
		
		
		
		if($this->sales_list_show($active_campaign,'tab4'))
		$this->_data['decision_authority'] =  $this->sales_list_show($active_campaign,'tab4');
		else 
		$this->_data['Decision_Authority'] = $qualifier_data['questions']['Decision_Authority'];	
		
				
		if($this->sales_list_show($active_campaign,'tab5'))
		$this->_data['intent_purchase'] =  $this->sales_list_show($active_campaign,'tab5');
		else 
		$this->_data['Competition_Level'] = $qualifier_data['questions']['Competition_Level'];	
		
		

		//By Dev@4489
		$parts = array();
		$lastid = 0;
		$params = explode("output/",uri_string());
		$cslug = explode("/",$params[1]);
		$uCustTemplate = $this->campaign->get_template_byslug($cslug[0],$this->_data['campaign_info']->campaign_id);
		if($uCustTemplate) {
			$template_sections = $this->campaign->get_template_sections($uCustTemplate['temp_no']);
			foreach($template_sections as $ts) {
					if($ts->sect_title!='Hard Qualifying Questions'){
					$lastid++;
					$tsname = strtolower($ts->sect_title);
					$tsname = str_replace(" ", "-", $tsname);
					if($lastid==1) $tsname = 'intro';
					$this->_data['content_id']=$ts->content_id;
					$ts_content = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, TRUE);
					$parts[$lastid] = array('name'=>$tsname,'title'=>$ts->sect_title,'content'=>$ts_content,'sorder'=>$ts->sect_sort);
				}
			}			
		}
		
		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;
		////

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/scripts-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'First-Meeting-Script';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['resp'] = False;

			$this->_data['button'] = False;

			

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);
			

			$this->_data['method_name'] = 'first-meeting-script';
			$this->_data['ISshow'] = 1;

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'first-meeting-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

	}

	
	
	public function questions($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;
		
		
		$active_campaign_data_new =  $this->campaign->get_campaign_active($this->_user_id);
		$active_campaign = $active_campaign_data_new->campaign_id;
		//echo "wrnbwqn".$active_campaign;
		//echo "wrnbwqn".$this->_user_id;
		$tabdata = $this->campaign->getCatQuestions($active_campaign,$this->_user_id);//by Dev@4489
		
		
		$this->load->helper('scripts');
		$qualifier_data = qualifier_questions();	
		$this->_data['tabtitles'] = $tabdata;		
		
		
		
		$this->load->helper('scripts');
		$qualifier_data = qualifier_questions();
		$this->_data['tech_qualify_pain'] = $this->campaign->getTechQualifyPain($active_campaign);	
		
		
		if($this->sales_list_show($active_campaign,'tab2'))
		$this->_data['need_want_qus'] =  $this->sales_list_show($active_campaign,'tab2');
		else 
		$this->_data['Need_Want'] = $qualifier_data['questions']['Need_Want'];	
		
		
		if($this->sales_list_show($active_campaign,'tab3'))
		$this->_data['funding_availability'] =  $this->sales_list_show($active_campaign,'tab3');
		else 
		$this->_data['Funding_Availability'] = $qualifier_data['questions']['Funding_Availability'];	
		
		
		
		if($this->sales_list_show($active_campaign,'tab4'))
		$this->_data['decision_authority'] =  $this->sales_list_show($active_campaign,'tab4');
		else 
		$this->_data['Decision_Authority'] = $qualifier_data['questions']['Decision_Authority'];	
		
				
		if($this->sales_list_show($active_campaign,'tab5'))
		$this->_data['intent_purchase'] =  $this->sales_list_show($active_campaign,'tab5');
		else 
		$this->_data['Competition_Level'] = $qualifier_data['questions']['Competition_Level'];	
		
		
		
		
		$parts = array();
		$lastid = 0;
		$params = explode("output/",uri_string());
		$cslug = explode("/",$params[1]);
		$uCustTemplate = $this->campaign->get_template_byslug($cslug[0],$this->_data['campaign_info']->campaign_id);
		if($uCustTemplate) {
			$template_sections = $this->campaign->get_template_sections($uCustTemplate['temp_no']);
			foreach($template_sections as $ts) {
				//echo '<pre>'; print_r($ts); echo '</pre>';
				if($ts->sect_title!='Hard Qualifying Questions'){
					$lastid++;
					$tsname = strtolower($ts->sect_title);
					$tsname = str_replace(" ", "-", $tsname);
					if($lastid==1) $tsname = 'intro';
					$this->_data['content_id']=$ts->content_id;
					$ts_content = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, TRUE);
					$parts[$lastid] = array('name'=>$tsname,'title'=>$ts->sect_title,'content'=>$ts_content,'sorder'=>$ts->sect_sort);
				}
			}		
		}
		
		
		
		
		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;
		
		//echo '<pre>'; print_r($parts); echo '</pre>';

		$this->_data['parts'] = $parts;
		
		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/scripts-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Questions';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['resp'] = False;

			$this->_data['button'] = False;

			

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);
			

			$this->_data['method_name'] = 'questions';
			$this->_data['ISshow'] = 1;

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'questions';

			$this->_data['img_dir'] = base_url() . 'images/';
			//meeting_script.php
			$this->load->view('outputs/scripts-template', $this->_data);

		}
	}

	/**

	 * Networking scripts Script HTML for Pdf

	 */

	public function networking_scripts($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;

		//By Dev@4489
		$parts = array();
		$lastid = 0;
		$params = explode("output/",uri_string());
		$cslug = explode("/",$params[1]);
		$uCustTemplate = $this->campaign->get_template_byslug($cslug[0],$this->_data['campaign_info']->campaign_id);
		if($uCustTemplate) {
			$template_sections = $this->campaign->get_template_sections($uCustTemplate['temp_no']);
			foreach($template_sections as $ts) {
				$lastid++;
				$tsname = strtolower($ts->sect_title);
				$tsname = str_replace(" ", "-", $tsname);
				if($lastid==1) $tsname = 'intro';
				$this->_data['content_id']=$ts->content_id;
				$ts_content = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, TRUE);
				$parts[$lastid] = array('name'=>$tsname,'title'=>$ts->sect_title,'content'=>$ts_content,'sorder'=>$ts->sect_sort);
			}			
		}
		
		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;
		////

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/scripts-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'networking-script';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['resp'] = False;

			$this->_data['button'] = False;

			

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);
			

			$this->_data['method_name'] = 'networking-script';
			$this->_data['ISshow'] = 1;

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'networking-scripts';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

	}

	

	

	/**

	 * Networking scripts Script HTML for Pdf

	 */

	public function meeting_for_coffee_script($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;

		//By Dev@4489
		$parts = array();
		$lastid = 0;
		$params = explode("output/",uri_string());
		$cslug = explode("/",$params[1]);
		$uCustTemplate = $this->campaign->get_template_byslug($cslug[0],$this->_data['campaign_info']->campaign_id);
		if($uCustTemplate) {
			$template_sections = $this->campaign->get_template_sections($uCustTemplate['temp_no']);
			foreach($template_sections as $ts) {
				$lastid++;
				$tsname = strtolower($ts->sect_title);
				$tsname = str_replace(" ", "-", $tsname);
				if($lastid==1) $tsname = 'intro';
				$this->_data['content_id']=$ts->content_id;
				$ts_content = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, TRUE);
				$parts[$lastid] = array('name'=>$tsname,'title'=>$ts->sect_title,'content'=>$ts_content,'sorder'=>$ts->sect_sort);
			}			
		}
		
		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;
		////

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/scripts-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'meeting-for-coffee-script';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['resp'] = False;

			$this->_data['button'] = False;

			

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);
			

			$this->_data['method_name'] = 'meeting-for-coffee-script';
			$this->_data['ISshow'] = 1;

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'meeting-for-coffee-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/scripts-template', $this->_data);

		}

	}

	

	



	/**

	 *  Networking question  HTML for Pdf

	 */

	public function networking_question($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489
		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/networking_question', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'networking-question';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'networking-question';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/networking_question', $this->_data);

		}

	}

	

	/**

	 *  meeting over coffee questions   HTML for Pdf

	 */

	public function meeting_over_coffee_questions($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489
		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/meeting_over_coffee_questions', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'meeting-over-coffee-questions';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'meeting-over-coffee-questions';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/meeting_over_coffee_questions', $this->_data);

		}

	}

	

	

	/**

	 * Post Call HTML for Pdf

	 */

	public function post_call($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_call', $this->_data, TRUE);

			$name = 'Post-Call Email Thread';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		} else {

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-call-email-thread';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/post_call', $this->_data);

		}

	}
	
	/**
	 * LinkedIn Connection Accept Follow-Up Thread - Value/Pain/Name Drop/Qualify/Product/Last Attempt HTML for Pdf
	 */
	public function linkedin_value_thread($action = Null)
	{
		if(!$this->_data['is_paid']){
			$this->session->set_flashdata('session_msg','Please upgrade your account');
			redirect(base_url()."folder/my-folder");
		}	

		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;		
		$this->_data['action'] = $action;		
		$this->get_script_template();//By Dev@4489
		
		// Get data from database to edit the record.
		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;
			$name = 'LinkedIn Connection Accept Follow-Up Thread - Value_Pain_Name Drop_Qualify_Product_Last Attempt';
			// Creating a File
			$fp = fopen(APPPATH."files/".$name.".doc", "a+");
			ftruncate($fp, 0);
			fwrite($fp,$html);
			//path to the file
			$file_path=APPPATH.'files/'.$name.".doc";
			fclose($myfile);

			//Call the download function with file path,file name and file type
			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');
			exit;
		}
		else 
		{
			$this->_data['button'] = TRUE;
			$this->_data['method_name'] = 'linkedin-value-thread';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489
		}
	}
	
	/**
	 * LinkedIn Connection Accept Follow-Up Thread - Pain/Value/Name Drop/Qualify/Product/Last Attempt HTML for Pdf
	 */
	public function linkedin_pain_thread($action = Null)
	{
		if(!$this->_data['is_paid']){
			$this->session->set_flashdata('session_msg','Please upgrade your account');
			redirect(base_url()."folder/my-folder");
		}	

		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;		
		$this->_data['action'] = $action;		
		$this->get_script_template();//By Dev@4489
		
		// Get data from database to edit the record.
		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;
			$name = 'LinkedIn Connection Accept Follow-Up Thread - Pain_Value_Name Drop_Qualify_Product_Last Attempt';
			// Creating a File
			$fp = fopen(APPPATH."files/".$name.".doc", "a+");
			ftruncate($fp, 0);
			fwrite($fp,$html);
			//path to the file
			$file_path=APPPATH.'files/'.$name.".doc";
			fclose($myfile);

			//Call the download function with file path,file name and file type
			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');
			exit;
		}
		else 
		{
			$this->_data['button'] = TRUE;
			$this->_data['method_name'] = 'linkedin-pain-thread';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489
		}
	}



	/**

	 * Before Call HTML for Pdf

	 */

	public function pre_call($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			//$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call Email Thread';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-thread';

			$this->_data['img_dir'] = base_url() . 'images/';

			//$this->load->view('outputs/pre_call', $this->_data);
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489

		}

	}
	
	/**

	 * Before Call HTML for Pdf : pre-call-email-thread-v3

	 */

	public function pre_callv3($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			//$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call Email Thread V3';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-thread-v3';

			$this->_data['img_dir'] = base_url() . 'images/';

			//$this->load->view('outputs/pre_call', $this->_data);
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489

		}

	}
	
	
	
	/*Pre-Call Email Thread VShort Function Start*/

	public function pre_callv3short($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));		
		
		if($action == 'download')

		{

			$this->_data['button'] = False;

			//$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
			
			
			
			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call Email Thread VShort';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-thread-vshort';

			$this->_data['img_dir'] = base_url() . 'images/';
			
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489

		}

	}
	
	
	public function saw_value($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			//$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call Email Thread';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'saw-you-on-linkedin-email-thread';

			$this->_data['img_dir'] = base_url() . 'images/';

			//$this->load->view('outputs/pre_call', $this->_data);
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489

		}

	}


	public function saw_valuev3($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			//$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Saw You on LinkedIn Email Thread V3';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'saw-you-on-linkedin-email-thread-v3';

			$this->_data['img_dir'] = base_url() . 'images/';

			//$this->load->view('outputs/pre_call', $this->_data);
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489

		}

	}



	/**

	 * Befor Call HTML for Pdf

	 */

	public function content_marketing($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/content_marketing', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Content Marketing Topics';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else {

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'content-marketing-topics';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/content_marketing', $this->_data);

		}

	}



	/**

	 * Befor Call HTML for Pdf

	 */

	public function email_marketing_topics($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email_marketing_topics', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Email-Marketing-Topics';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else {

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'email-marketing-topics';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email_marketing_topics', $this->_data);

		}

	}

	

	

	

	

	/**

	 * Closing Questions HTML for Pdf

	 */

	public function closing_question($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/closing_questions', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Closing-Question';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else {

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'closing-questions';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/closing_questions', $this->_data);

		}

	}



	/**

	 * Closing Questions HTML for Pdf

	 */

	public function pre_call_email_pain_focus($action = Null) 

	{



		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );



		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre-call-email-pain-focus.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call-Email-Pain-Focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-pain-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/pre-call-email-pain-focus.php', $this->_data);

		}

	}

	

	/**

	 *   pre_call_email_technical_value_focus

	 */

	public function pre_call_email_technical_value_focus($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'pre-call-email-value-focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-technical-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}
	
	
	
	/**

	 *   saw_you_on_linkedin_value_focus

	 */

	public function saw_you_on_linkedin_value_focus($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'saw-you-on-linkedin-value-focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'saw-you-on-linkedin-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}
	
	
	
	
	/**

	 *   saw_you_on_linkedin_pain_focus

	 */

	public function saw_you_on_linkedin_pain_focus($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'saw-you-on-linkedin-pain-focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'saw-you-on-linkedin-pain-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}
	

	

	/**

	 *   linkedin_technical_value

	 */

	public function linkedin_technical_value($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'linkedin-value';
			

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'linkedin-technical-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	/**

	 *   linkedin_business_value

	 */

	public function linkedin_business_value($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/linkedin_business_value', $this->_data, TRUE);

			$name = 'linkedin-business-value';			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'linkedin-business-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/linkedin_business_value', $this->_data);

		}

	}

	

	/**

	 *   linkedin_personal_value

	 */

	public function linkedin_personal_value($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/linkedin_personal_value', $this->_data, TRUE);

			$name = 'linkedin-personal-value';			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'linkedin-personal-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/linkedin_personal_value', $this->_data);

		}

	}

	

	/**

	 *   linkedin_technical_pain

	 */

	public function linkedin_technical_pain($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'linkedin-pain';			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'linkedin-technical-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	/**

	 *   linkedin_business_pain

	 */

	public function linkedin_business_pain($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/linkedin_business_pain', $this->_data, TRUE);

			$name = 'linkedin-business-pain';			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'linkedin-business-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/linkedin_business_pain', $this->_data);

		}

	}

	

	/**

	 *   linkedin_personal_pain

	 */

	public function linkedin_personal_pain($action = Null) 

	{		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/linkedin_personal_pain', $this->_data, TRUE);

			$name = 'linkedin-personal-pain';			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'linkedin-personal-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/linkedin_personal_pain', $this->_data);

		}

	}

	

	/**

	 *   post call email technical value focus 

	 */

	public function post_call_email_technical_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'post-call-email-value-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_call_email_technical_value_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	/**

	 *   post call email business value focus 

	 */

	public function post_call_email_business_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_call_email_business_value_focus.php', $this->_data, TRUE);

			$name = 'post-call-email-business-value-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;	

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_call_email_business_value_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/post_call_email_business_value_focus', $this->_data);

		}

	}

	

	/**

	 *   Post call email personal value focus 

	 */

	public function post_call_email_personal_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_call_email_personal_value_focus.php', $this->_data, TRUE);

			$name = 'post-call-email-personal-value-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;	

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_call_email_personal_value_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			 

			$this->load->view('outputs/post_call_email_personal_value_focus', $this->_data);

		}

	}

	

	/**

	 *   Post call email technical pain focus 

	 */

	public function post_call_email_technical_pain_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'post-call-email-pain-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;	

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_call_email_technical_pain_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	



	/**

	 *   Post voice email business pain focus

	 */

	public function post_voice_email_business_pain_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_voice_email_business_pain_focus.php', $this->_data, TRUE);

			$name = 'post-voice-email-business-pain-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;	

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_voice_email_business_pain_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/post_voice_email_business_pain_focus', $this->_data);

		}

	}

	

	/**

	 *   Post voice email personal pain focus

	 */

	public function post_voice_email_personal_pain_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_voice_email_personal_pain_focus.php', $this->_data, TRUE);

			$name = 'post-voice-email-personal-pain-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;	

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_voice_email_personal_pain_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/post_voice_email_personal_pain_focus', $this->_data);

		}

	}

	

	

	

	

	

	/**

	 *   post-voicemail-email-product focus

	 */

	public function post_voicemail_email_product($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Post-voicemail-email-product';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;	

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_voicemail_email_product_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	

	

	/**

	 *   pre call email personal pain DOC File templates 

	 */

	public function pre_call_email_personal_pain($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_call_email_personal_pain.php', $this->_data, TRUE);

			$name = 'pre-call-email-personal-pain';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre_call_email_personal_pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/pre_call_email_personal_pain.php', $this->_data);

		}

	}

	

	

	/**

	 *   Pre call email technical qualify DOC File templates 

	 */

	public function pre_call_email_technical_qualify($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'pre-call-email-qualify';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre_call_email_technical_qualify';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	/**

	 *   pre call email business pain doc file template 

	 */

	public function pre_call_email_business_pain($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_call_email_business_pain.php', $this->_data, TRUE);

			$name = 'pre-call-email-business-pain';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre_call_email_business_pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/pre_call_email_business_pain.php', $this->_data);

		}

	}

	

	

	/**

	 *   pre call email business qualify doc file template 

	 */

	public function pre_call_email_business_qualify($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_call_email_business_qualify', $this->_data, TRUE);

			$name = 'pre-call-email-business-qualify';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre_call_email_business_qualify';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/pre_call_email_business_qualify', $this->_data);

		}

	}

	

	/**

	 *   pre call email business qualify doc file template

	 */

	public function pre_call_email_personal_qualify($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_call_email_personal_qualify', $this->_data, TRUE);

			$name = 'pre-call-email-personal-qualify';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre_call_email_personal_qualify';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/pre_call_email_personal_qualify', $this->_data);

		}

	}

	

	

	/**

	 *   last_attempt_email_technical_value doc file template

	 */

	public function last_attempt_email_technical_value($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'last-attempt-email-value';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'last-attempt-email-technical-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	

	

	/**

	 *   last attempt email business value doc/ html file template 

	 */

	public function last_attempt_email_business_value($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/last_attempt_email_business_value', $this->_data, TRUE);

			$name = 'last-attempt-email-business-value';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'last-attempt-email-business-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/last_attempt_email_business_value', $this->_data);

		}

	}

	

	

	/**

	 *   last attempt email personal value doc/ html file template 

	 */

	public function last_attempt_email_personal_value($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/last_attempt_email_personal_value', $this->_data, TRUE);

			$name = 'last-attempt-email-personal-value';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'last-attempt-email-personal-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/last_attempt_email_personal_value', $this->_data);

		}

	}

	

	/**

	 *  Pre call email technical pain templates doc file.

	 */

	public function pre_call_email_technical_pain($action = Null) 

	{



		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'pre-call-email-pain';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre_call_email_technical_pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	/**

	 *  pre_call_email_personal_value_focus

	 */

	public function pre_call_email_personal_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_call_email_personal_value_focus.php', $this->_data, TRUE);

			$name = 'pre-call-email-personal-value-focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-personal-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/pre_call_email_personal_value_focus.php', $this->_data);

		}

	}

	

	public function pre_call_email_business_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre_call_email_business_value_focus.php', $this->_data, TRUE);

			$name = 'pre-call-email-business-value-focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-business-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/pre_call_email_business_value_focus.php', $this->_data);

		}

	}



	/**

	 * Closing Questions HTML for Pdf

	 */

	public function pre_call_email_product_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd()));

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call-Email-Product-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-product-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template', $this->_data);

		}

	}



	/**

	 * Closing Questions HTML for Pdf

	 */

	public function pre_call_email_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/pre-call-email-value-focus.php', $this->_data, TRUE);

			$name = 'Pre-Call-Email-Value-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/pre-call-email-value-focus.php', $this->_data);

		}

	}

	

	/*

	 * pre call email namedrop focus

	 * 

	 */

	public function pre_call_email_namedrop_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call-Email-Namedrop-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-namedrop-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			

			// var_dump($this->_data); die();

			

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}



	/**

	 * Sales Letter Pain Focus HTML for Pdf

	 */

	public function salesLetterPainFocus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/sales-letter-pain-focus.php', $this->_data, TRUE);

			$name = 'Sales-Letter-Pain-Focus';

			// $this->_tc_pdf($html, $name);

			$this->_tc_doc($html, $name);

			// $this->_tc_doc_gen($html, $name);

			

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'sales-letter-pain-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/sales-letter-pain-focus.php', $this->_data);

		}

	}

	/**

	 * create a doc from html simple method

	 *

	 */

	private function _tc_doc($html,$name)

	{

		header("Content-type: application/vnd.ms-word");

		header("Content-Disposition: attachment;Filename=$name.doc");

		echo $html;

		die();

	}

	

	private function _tc_doc_gen($html,$name)

	{

		// require_once(APPPATH.'libraries/TCPDF/config/lang/eng.php');

		/* require_once (APPPATH.'libraries/DocClass/PHPWord.php');

		require_once (APPPATH.'libraries/DocClass/simple_html_dom.php');

		require_once (APPPATH.'libraries/DocClass/h2d_htmlconverter.php');

		require_once (APPPATH.'libraries/DocClass/styles.inc');

		require_once (APPPATH.'libraries/DocClass/support_functions.inc'); */

		

		require_once (APPPATH.'libraries/DocClass/phpword/PHPWord.php');

		require_once (APPPATH.'libraries/DocClass/simplehtmldom/simple_html_dom.php');

		require_once (APPPATH.'libraries/DocClass/htmltodocx_converter/h2d_htmlconverter.php');

		require_once (APPPATH.'libraries/DocClass/example_files/styles.inc');



		// Functions to support this example.

		require_once (APPPATH.'libraries/DocClass/documentation/support_functions.inc');

		

		

		

		// HTML fragment we want to parse:

		// $html = file_get_contents('example_files/example_html.html');

		// $html = file_get_contents('test/table.html');

		 

		// New Word Document:

		$phpword_object = new PHPWord();

		$section = $phpword_object->createSection();



		// HTML Dom object:

		$html_dom = new simple_html_dom();

		$html_dom->load($html);

		// Note, we needed to nest the html in a couple of dummy elements.



		// Create the dom array of elements which we are going to work on:

		$html_dom_array = $html_dom->find('html',0)->children();



		// We need this for setting base_root and base_path in the initial_state array

		// (below). We are using a function here (derived from Drupal) to create these

		// paths automatically - you may want to do something different in your

		// implementation. This function is in the included file 

		// documentation/support_functions.inc.

		$paths = htmltodocx_paths();



		// Provide some initial settings:

		$initial_state = array(

		  // Required parameters:

		  'phpword_object' => &$phpword_object, // Must be passed by reference.

		  // 'base_root' => 'http://test.local', // Required for link elements - change it to your domain.

		  // 'base_path' => '/htmltodocx/documentation/', // Path from base_root to whatever url your links are relative to.

		  'base_root' => $paths['base_root'],

		  'base_path' => $paths['base_path'],

		  // Optional parameters - showing the defaults if you don't set anything:

		  'current_style' => array('size' => '11'), // The PHPWord style on the top element - may be inherited by descendent elements.

		  'parents' => array(0 => 'body'), // Our parent is body.

		  'list_depth' => 0, // This is the current depth of any current list.

		  'context' => 'section', // Possible values - section, footer or header.

		  'pseudo_list' => TRUE, // NOTE: Word lists not yet supported (TRUE is the only option at present).

		  'pseudo_list_indicator_font_name' => 'Wingdings', // Bullet indicator font.

		  'pseudo_list_indicator_font_size' => '7', // Bullet indicator size.

		  'pseudo_list_indicator_character' => 'l ', // Gives a circle bullet point with wingdings.

		  'table_allowed' => TRUE, // Note, if you are adding this html into a PHPWord table you should set this to FALSE: tables cannot be nested in PHPWord.

		  'treat_div_as_paragraph' => TRUE, // If set to TRUE, each new div will trigger a new line in the Word document.

			  

		  // Optional - no default:    

		  'style_sheet' => htmltodocx_styles_example(), // This is an array (the "style sheet") - returned by htmltodocx_styles_example() here (in styles.inc) - see this function for an example of how to construct this array.

		  );    



		// Convert the HTML and put it into the PHPWord object

		htmltodocx_insert_html($section, $html_dom_array[0]->nodes, $initial_state);



		// Clear the HTML dom object:

		$html_dom->clear(); 

		unset($html_dom);



		// Save File

		$h2d_file_uri = tempnam('', 'htd');

		$objWriter = PHPWord_IOFactory::createWriter($phpword_object, 'Word2007');

		$objWriter->save($h2d_file_uri);



		// Download the file:

		header('Content-Description: File Transfer');

		header('Content-Type: application/octet-stream');

		header("Content-Disposition: attachment; filename=$name.docx");

		header('Content-Transfer-Encoding: binary');

		header('Expires: 0');

		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

		header('Pragma: public');

		header('Content-Length: ' . filesize($h2d_file_uri));

		ob_clean();

		flush();

		$status = readfile($h2d_file_uri);

		unlink($h2d_file_uri);

		exit;

	}

	

	/**

	 * Sales Letter Name Drop Focus HTML for Pdf

	 */

	public function salesLetterNameDropFocus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/sales-letter-name-drop-focus.php', $this->_data, TRUE);

			$name = 'Sales-Letter-Name-Drop-Focus';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'sales-letter-name-drop-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/sales-letter-name-drop-focus.php', $this->_data);

		}

	}



	/**

	 * Sales Letter Value Focus HTML for Pdf

	 */

	public function salesLetterValueFocus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/sales-letter-value-focus.php', $this->_data, TRUE);

			$name = 'Sales-Letter-Value-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'sales-letter-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/sales-letter-value-focus.php', $this->_data);

		}

	}

    

	/**

	 * Internal Referral Email HTML for Pdf

     */

	public function internalReferralEmail($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Internal-Referral-Email';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'internal-referral-email';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template', $this->_data);

		}

	}



	/**

	 *  your_information email template 

	 */

	public function your_information($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Your Information';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'your-information';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template.php', $this->_data);

		}

	}	

    

	/**

	 *  Post Call Email Technical Business Value Focus Email Template 

	 */

	public function post_call_email_technical_business_value_focus($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_call_email_technical_business_value_focus', $this->_data, TRUE);

			$name = 'post-call-email-technical-business-value-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-call-email-technical-business-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/post_call_email_technical_business_value_focus', $this->_data);

		}

	}

	

	/**

	 *  Post Call Email Technical Business Value Focus Email Template 

	 */

	public function post_call_email_business_technical_value_focus($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post_call_email_business_technical_value_focus', $this->_data, TRUE);

			$name = 'post-call-email-business-technical-value-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-call-email-business-technical-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/post_call_email_business_technical_value_focus', $this->_data);

		}

	}

	

	/**

	* Campaign page Development

	*/

    public function CampaignDevelopment($action = Null)

    {

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['objections'] 	= $this->home->get_all_objections($this->_user_id, $this->_data['active_session_id']);

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/campaign-development.php', $this->_data, TRUE);

			//$name = 'campaign-development';

            $name = 'Email Drip Sales Pitch Guide';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'campaign-development';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/campaign-development.php', $this->_data);

		}

    }	

	/**

	 * Inbound Call Script HTML for Pdf

     */

	public function inboundCallScript($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/inbound-call-script', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Inbound-Call-Script';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'inbound-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/inbound-call-script', $this->_data);

		}

	}



	/**

	 * Closing Questions HTML for Pdf

	 */

	public function call_script_focus_product($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-focus-product', $this->_data, TRUE);

			$name = 'Call-Script-Product-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-focus-product';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-focus-product', $this->_data);

		}

	}

	

	

	/**

	 * call script  webinar follow up HTML for Pdf

	 */

	public function call_script_webinar_follow_up($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_webinar_follow_up_and_qualify_focus', $this->_data, TRUE);

			$name = 'call-script-webinar-follow-up-qualify';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-webinar-follow-up';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_webinar_follow_up_and_qualify_focus', $this->_data);

		}

	}

	

	

	/**

	 * call script  webinar follow up HTML for Pdf

	 */

	public function call_script_emailfollowupandqualify($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_email_follow_up_and_qualify_focus', $this->_data, TRUE);

			$name = 'call-script-email-follow-up-qualify';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call_script_email_follow_up_qualify';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_email_follow_up_and_qualify_focus', $this->_data);

		}

	}

	





	/**

	 * Closing Questions HTML for Pdf

	 */

	public function call_script_focus_pain($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-focus-pain', $this->_data, TRUE);

			$name = 'Call-Script-Pain-Intro';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-focus-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-focus-pain', $this->_data);

		}

	}

	



	/**

	 * Closing Questions HTML for Pdf

	 */

	public function call_script_name_drop($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-name-drop', $this->_data, TRUE);

			$name = 'Call-Script-Name-Drop';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-name-drop';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-name-drop', $this->_data);

		}

	}



	



	

	/**

	 * Closing Questions HTML for Pdf

	 */

	public function call_script_technical_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_technical_focus', $this->_data, TRUE);

			$name = 'call-script-technical-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-technical-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_technical_focus', $this->_data);

		}

	}

	

	/**

	 * Closing Questions HTML for Pdf

	 */

	public function call_script_business_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_business_focus', $this->_data, TRUE);

			$name = 'call-script-business-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-business-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_business_focus', $this->_data);

		}

	}

	

	/**

	 * Closing Questions HTML for Pdf

	 */

	public function call_script_personal_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_personal_focus', $this->_data, TRUE);

			$name = 'call-script-personal-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-personal-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_personal_focus', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script ? Value Focus HTML for Pdf

	 */

	public function voicemail_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-value-focus.php', $this->_data, TRUE);

			$name = 'Voicemail-Script-Value-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-value-focus.php', $this->_data);

		}

	}



	/**

	 * Voicemail Script ? Value Focus HTML for Pdf !depreciate

	 */

	public function post_voicemail_value_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post-voicemail-value-focus.php', $this->_data, TRUE);

			$name = 'Post-Voicemail-Script-Value-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-voicemail-value-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/post-voicemail-value-focus.php', $this->_data);

		}

	}



	

	/**

	 *   Voiceemail technical value template doc file.

	 */

	public function voicemail_script_technical_value($action = Null) 

	{

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'voicemail-script-value';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-technical-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	

	/**

	 *   Voiceemail technical value template doc file.

	 */

	public function voicemail_script_technical_value_long($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_technical_value_long', $this->_data, TRUE);

			$name = 'voicemail-script-value-long';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-technical-value-long';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/voicemail_script_technical_value_long', $this->_data);

		}

	}

	

	

	

	/**

	 *   Voiceemail technical value  appointment templates doc 

	 */

	public function voicemail_script_technical_value_appointment($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_technical_value_appointment', $this->_data, TRUE);

			$name = 'voicemail-script-value-appointment';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-technical-value-appointment';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			

			$this->load->view('outputs/voicemail_script_technical_value_appointment', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script business Value Focus HTML for doc 

	 */

	public function voicemail_script_business_value($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-script-business-value.php', $this->_data, TRUE);

			$name = 'voicemail-script-business-value';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-business-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-script-business-value', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script business Value Focus HTML for doc 

	 */

	public function voicemail_script_business_value_long($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_business_value_long', $this->_data, TRUE);

			$name = 'voicemail-script-business-value-long';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-business-value-long';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_business_value_long', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script business Value Focus (Appointment) HTML for doc 

	 */

	public function voicemail_script_business_value_appointment($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_business_value_appointment.php', $this->_data, TRUE);

			$name = 'voicemail-script-business-value-appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-business-value-appointment';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_business_value_appointment', $this->_data);

		}

	}

	

	

	

	/**

	 * Voicemail Script persnal Value Focus  HTML for doc 

	 */

	public function voicemail_script_personal_value($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-script-personal-value.php', $this->_data, TRUE);

			$name = 'voicemail-script-personal-value';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-personal-value';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-script-personal-value.php', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script persnal Value Focus  HTML for doc 

	 */

	public function voicemail_script_personal_value_long($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_personal_value_long', $this->_data, TRUE);

			$name = 'voicemail-script-personal-value-long';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-personal-value-long';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_personal_value_long', $this->_data);

		}

	}

	

	

	

	/**

	 * Voicemail Script personal Value Focus (Appointment) HTML for doc 

	 */

	public function voicemail_script_personal_value_appointment ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_personal_value_appointment.php', $this->_data, TRUE);

			$name = 'voicemail-script-personal-value-appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-personal-value-appointment';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_personal_value_appointment', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script technical pain Focus (Appointment) HTML for doc 

	 */

	public function voicemail_script_technical_pain ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'voicemail-script-pain';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-technical-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script technical pain Focus (Appointment) HTML for doc 

	 */

	public function voicemail_script_technical_pain_appointment ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_technical_pain_appointment.php', $this->_data, TRUE);

			$name = 'voicemail-script-pain-appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-technical-pain-appointment';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_technical_pain_appointment', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script business pain Focus  HTML for doc 

	 */

	public function voicemail_script_business_pain ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_business_pain.php', $this->_data, TRUE);

			$name = 'voicemail-script-business-pain';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-business-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_business_pain', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script business pain Focus  [appointment] HTML for doc 

	 */

	public function voicemail_script_business_pain_appointment ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_business_pain_appointment.php', $this->_data, TRUE);

			$name = 'voicemail-script-business-pain-appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-business-pain-appointment';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_business_pain_appointment', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script personal pain Focus  HTML for doc 

	 */

	public function voicemail_script_personal_pain ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_personal_pain.php', $this->_data, TRUE);

			$name = 'voicemail-script-personal-pain';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-personal-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_personal_pain', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script business pain Focus  [appointment] HTML for doc 

	 */

	public function voicemail_script_personal_pain_appointment ($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_personal_pain_appointment.php', $this->_data, TRUE);

			$name = 'voicemail-script-personal-pain-appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-personal-pain-appointment';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_personal_pain_appointment', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script ? Value Focus (Appointment) HTML for doc  !depreciate

	 */

	public function voicemail_value_focus_appoint($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-value-focus-appoint.php', $this->_data, TRUE);

			$name = 'Voicemail-Script-Value-Focus-Appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-value-focus-appoint';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-value-focus-appoint.php', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script ? Name Drop Focus HTML for Pdf

	 */

	public function voicemail_name_drop_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Voicemail-Name-Drop-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-name-drop-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script ? product Focus HTML for Pdf

	 */

	public function voicemail_script_product($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Voicemail-Script-Product';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-product';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script ? product Focus HTML for Pdf

	 */

	public function voicemail_script_product_appoint($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail_script_product_appoint', $this->_data, TRUE);

			$name = 'voicemail-script-product-appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-script-product-appoint';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail_script_product_appoint', $this->_data);

		}

	}

	

	

	/**

	 * Voicemail Script ? Name Drop Focus HTML for Pdf

	 */

	public function post_voicemail_name_drop_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		$this->get_script_template();//By Dev@4489

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Post-Voicemail-Name-Drop-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}else{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-voicemail-name-drop-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/email-template', $this->_data);

		}

	}



	/**

	 * Voicemail Script ? Name Drop Focus Appointment HTML for Pdf

	 */



	public function voicemail_name_drop_focus_appoint($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-name-drop-appoint.php', $this->_data, TRUE);

			$name = 'Voicemail-Name-Drop-Appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-name-drop-appoint';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-name-drop-appoint', $this->_data);

		}

	}





	/**

	 * Voicemail Script ? Pain Focus Appointment HTML for Pdf

	 */

	public function voicemail_pain_focus_appoint($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-pain-focus-appoint.php', $this->_data, TRUE);

			$name = 'Voicemail-Pain-Focus-Appointment';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-pain-focus-appoint';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-pain-focus-appoint.php', $this->_data);

		}

	}



	/**

	 * Voicemail Script ? Pain Focus HTML for Pdf

	 */

	public function voicemail_pain_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/voicemail-pain-focus.php', $this->_data, TRUE);

			$name = 'Voicemail-Pain-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'voicemail-pain-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/voicemail-pain-focus.php', $this->_data);

		}

	}

	

	/**

	 * Voicemail Script ? Pain Focus HTML for Pdf

	 */

	public function post_voicemail_pain_focus($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/post-voicemail-pain-focus.php', $this->_data, TRUE);

			$name = 'Post-Voicemail-Pain-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post-voicemail-pain-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/post-voicemail-pain-focus.php', $this->_data);

		}

	}



	/**

	 * Step 7

	 * Close - Input - Ideal Sales Process

	 */

	public function productMatrix($action = Null) 

	{

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/product_matrix', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Product Matrix';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'product-matrix';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/product_matrix', $this->_data);

		}

	}



	/**

	 * Generate Pdf of given HTML

	 * @param $html

	 * @param $slug

	 */

	private function _tc_pdf($html = NULL, $name = Null)

	{

		require_once(APPPATH.'libraries/TCPDF/config/lang/eng.php');

		require_once(APPPATH.'libraries/TCPDF/tcpdf.php');



		// create new PDF document

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



		// set default header data



		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING);



		// set header and footer fonts



		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));



		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



		// set default monospaced font

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



		//set margins

		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);



		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);



		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		

		$pdf->SetPrintHeader(false);



		$pdf->SetPrintFooter(false);

		

		//set auto page breaks

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



		//set image scale factor

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



		// ---------------------------------------------------------



		// set default font subsetting mode

		$pdf->setFontSubsetting(true);



		// Set font



		// dejavusans is a UTF-8 Unicode font, if you only need to



		// print standard ASCII chars, you can use core fonts like



		// helvetica or times to reduce file size.

		$pdf->SetFont('dejavusans', '', 14, '', true);



		// Add a page



		// This method has several options, check the source code documentation for more information.

		$pdf->AddPage();



		// Print text using writeHTMLCell()

		$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



		// ---------------------------------------------------------



		// Close and output PDF document

		// This method has several options, check the source code documentation for more information.

		$pdf->Output($name . ".pdf", 'D');

	}



	/**

	 * Download Links in this page

	 * @param $html

	 * @param $slug

	 */

	function download($d_page = NULL)

	{

	

		switch ($d_page) {



			case 'elevator-pitch':

			$d_page_name = 1;

			break;



			case 'prospect-pain-points':

			$d_page_name = 2;

			break;



			case 'ideal-prospect-profile':

			$d_page_name = 3;

			break;



			case 'qualifying-questions':

			$d_page_name = 4;

			break;



			case 'building-interest':

			$d_page_name = 5;

			break;



			case 'sales-scripts':

			$d_page_name = 6;

			break;



			case 'objections-map':

			$d_page_name = 7;

			break;



			case 'voicemail-script':

			$d_page_name = 8;

			break;



			case 'email-templates':

			$d_page_name = 9;

			break;



			case 'name-drop-statments':

			$d_page_name = 10;

			break;



			case 'closing-questions':

			$d_page_name = 11;

			break;



			case 'sales-presentation':

			$d_page_name = 12;

			break;



			case 'marketing-output':

			$d_page_name = 13;

			break;



			case 'responses-questions':

			$d_page_name = 14;

			break;



			case 'my-folder':

			$d_page_name = 15;

			break;



			case 'team-folder':

			$d_page_name = 16;

            break;

                    

            case 'campaign-kits':

			$d_page_name = 17;

            break;

                    

            case 'pre-filled-campaigns':

			$d_page_name = 18;

            break;

			

		}



		// For Existing Team Members Conection

		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');

		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);

		if($this->input->post('submit'))

		{

				$search_name = $this->input->post('search_name');



				$this->_data['user_data'] = $this->home->searchUser($search_name);



				if(empty($this->_data['user_data']))

				{

						$this->_data['message'] = 'Not able to find user';

				}

		}

		

		if($this->input->post('searchtemplate'))

		{

				$template_name = $this->input->post('template_name');

				

				$this->_data['template_data'] = $this->home->searchTemplate($template_name);



				if(empty($this->_data['template_data']))

				{

						$this->_data['templatemessage'] = 'Not able to template';

				}

				$this->_data['serchedtemplate'] = $template_name;

		}

                        

		/**  find all records for drop down **/

		

		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();

		$this->_data['drop_company'] = $this->campaign->get_drop_company();

		$this->_data['drop_name'] = $this->campaign->get_drop_name();

		$this->_data['page'] = '';

		$this->_data['d_page'] = $d_page_name;

	    $this->load->view('download', $this->_data);

	}

	

	/**

	 *  My team mate folder page

	 *  

	 *  @return Return_Description

	 */

	public function team_folder_view()

	{

	

		$d_page_name = 16;

		// For Existing Team Members Conection

		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');

		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);

		if($this->input->post('submit'))

		{

				$search_name = $this->input->post('search_name');

				$this->_data['user_data'] = $this->home->searchUser($search_name);

				if(empty($this->_data['user_data']))

				{

						$this->_data['message'] = 'Not able to find user';

				}

		}

		if($this->input->post('searchtemplate'))

		{

				$template_name = $this->input->post('template_name');

				$this->_data['template_data'] = $this->home->searchTemplate($template_name);

				if(empty($this->_data['template_data']))

				{

					$this->_data['templatemessage'] = 'Not able to template';

				}

				$this->_data['serchedtemplate'] = $template_name;

		}

                        

		/**  find all records for drop down **/

		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();

		$this->_data['drop_company'] = $this->campaign->get_drop_company();

		$this->_data['drop_name'] = $this->campaign->get_drop_name();

		

		/* print_r($this->_data);		

		die(); */

		$this->_data['page'] = '';

		$this->_data['d_page'] = $d_page_name;

	    $this->load->view('team_folder_view', $this->_data);

	}

	/**

	 *  Teammate campaign with user id page

	 *  

	 *  @param integer $user_id Parameter_Description

	 *  @return Return_Description

	 *  

	 *  display all user product campaign , company ,name drop 

	 */

	function teammate_campaign($user_id)

	{

		$d_page_name = 16;

		

		/** find that user is current user teammate are not */

		$checkstatus = $this->campaign->checkTeammate($user_id);

		if(!$checkstatus){

			redirect(base_url()."folder/team-folder");

		}

		

		// For Existing Team Members Conection

		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');

		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);

		if($this->input->post('submit'))

		{

				$search_name = $this->input->post('search_name');

				$this->_data['user_data'] = $this->home->searchUser($search_name);

				if(empty($this->_data['user_data']))

				{

						$this->_data['message'] = 'Not able to find user';

				}

		}

		if($this->input->post('searchtemplate'))

		{

				$template_name = $this->input->post('template_name');

				$this->_data['template_data'] = $this->home->searchTemplate($template_name);

				if(empty($this->_data['template_data']))

				{

					$this->_data['templatemessage'] = 'Not able to template';

				}

				$this->_data['serchedtemplate'] = $template_name;

		}

                        

		/**  find all records for drop down **/

		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();

		$this->_data['drop_company'] = $this->campaign->get_drop_company();

		$this->_data['drop_name'] = $this->campaign->get_drop_name();

		

		/* print_r($this->_data);		

		die(); */

		$this->_data['page'] = '';

		$this->_data['teammateid'] = $user_id ;

		$this->_data['d_page'] = $d_page_name;

	    $this->load->view('teammate_campaign', $this->_data);

	}

	

	/**

	 * Update SESSION

	 */

	public function invitationEmail() 

	{

		$email 		= $this->input->post('email');

		$user_info	= $this->home->get_single_user_info($this->_user_id);

		$this->load->library('email');

		$this->email->from('no-reply@salesscripter.com', 'SalesScripter ');

		$this->email->to($email);

		$this->email->subject('Someone wants you to join SalesScripter');



		$message = NULL;

		$message .= "Hello!<br><br>";

		$message .= "$user_info->first_name $user_info->last_name is currently using SalesScripter as sales messaging tool and they feel like you might be able to benefit from this system as well.<br><br>";

		$message .= "It is free to sign up and you can do so by simply going to our website at <a href='http://www.salesscripter.com' target='_blank'>www.salesscripter.com</a>.<br><br>";

		$message .= "By simply answering a few questions, SalesScripter will build call scripts, email templates, voicemail scripts, objections responses, marketing tools, and more.<br><br>";

		$message .= "Once you sign up, you will be able to connect and share scripts with $user_info->first_name $user_info->last_name.<br><br>";

		$message .= "Thank you,<br>";

		$message .= "SalesScripter<br>";

		$message .= "info@salesscripter.com<br>";

		$message .= "<a href='http://www.salesscripter.com' target='_blank'>www.salesscripter.com</a><br>";

		$message .= "(713) 802-2026";



                $this->email->message($message);

		$this->email->send();

		$this->session->set_flashdata('msg', 'E-mail Invitation has been sent.');



		echo json_encode(array("success"=>"ok"));

	}

	

    /**

     *  @brief Brief

     *  

     *  @return Return_Description

     *  

     *  @details Details

     */

    public function PainCampaignKit()

    {

		// For Existing Team Members Conection

		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');

		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);

		if($this->input->post('submit'))

		{

			$search_name = $this->input->post('search_name');



			$this->_data['user_data']	= $this->home->searchUser($search_name);



			if(empty($this->_data['user_data']))

			{

					$this->_data['message'] = 'Not able to find user';

			}

		}



		$this->_data['page'] = '';

	    $this->load->view('paincampaignkit', $this->_data);

    }

	

    /**

     *  @brief Brief

     *  @return Return_Description

     *  @details Details

     */    

    public function ValueCampaignKit()

	{

		// For Existing Team Members Conection

		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');



		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);



		if($this->input->post('submit'))

		{

			$search_name = $this->input->post('search_name');



			$this->_data['user_data']	= $this->home->searchUser($search_name);



			if(empty($this->_data['user_data']))

			{

					$this->_data['message'] = 'Not able to find user';

			}

		}



		$this->_data['page'] = '';



		$this->load->view('valuecampaignkit', $this->_data);

	}

	/**

	 *  @brief Brief

	 *  

	 *  @return Return_Description

	 *  

	 *  @details Details

	 */   

	public function NameDropCampaignKit()

	{

		// For Existing Team Members Conection

		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');

		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);



		if($this->input->post('submit'))

		{

			$search_name = $this->input->post('search_name');

			$this->_data['user_data']	= $this->home->searchUser($search_name);



			if(empty($this->_data['user_data']))

			{

					$this->_data['message'] = 'Not able to find user';

			}

		}

		$this->_data['page'] = '';

		$this->load->view('namedropcampaignkit', $this->_data);

	} 

   

	//This application is developed by www.webinfopedia.com

	//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!

	function output_file($file, $name, $mime_type='')

	{

	 /*

	 This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).

	 */



	 //Check the file premission

	 if(!is_readable($file)) die('File not found or inaccessible!');



	 $size = filesize($file);

	 $name = rawurldecode($name);



	 /* Figure out the MIME type | Check in array */

	 $known_mime_types=array(

			"pdf" => "application/pdf",

			"txt" => "text/plain",

			"html" => "text/html",

			"htm" => "text/html",

			"exe" => "application/octet-stream",

			"zip" => "application/zip",

			"doc" => "application/msword",

			"xls" => "application/vnd.ms-excel",

			"ppt" => "application/vnd.ms-powerpoint",

			"gif" => "image/gif",

			"png" => "image/png",

			"jpeg"=> "image/jpg",

			"jpg" =>  "image/jpg",

			"php" => "text/plain"

	 );



	 if($mime_type==''){

			 $file_extension = strtolower(substr(strrchr($file,"."),1));

			 if(array_key_exists($file_extension, $known_mime_types)){

					$mime_type=$known_mime_types[$file_extension];

			 } else {

					$mime_type="application/force-download";

			 };

	 };



	 //turn off output buffering to decrease cpu usage

	 @ob_end_clean(); 



	 // required for IE, otherwise Content-Disposition may be ignored

	 if(ini_get('zlib.output_compression'))

	  ini_set('zlib.output_compression', 'Off');



	 header('Content-Type: ' . $mime_type);

	 header('Content-Disposition: attachment; filename="'.$name.'"');

	 header("Content-Transfer-Encoding: binary");

	 header('Accept-Ranges: bytes');



	 /* The three lines below basically make the 

		download non-cacheable */

	 header("Cache-control: private");

	 header('Pragma: private');

	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");



	 // multipart-download and download resuming support

	 if(isset($_SERVER['HTTP_RANGE']))

	 {

			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);

			list($range) = explode(",",$range,2);

			list($range, $range_end) = explode("-", $range);

			$range=intval($range);

			if(!$range_end) {

					$range_end=$size-1;

			} else {

					$range_end=intval($range_end);

			}

			/*

		   ------------------------------------------------------------------------------------------------------

			//This application is developed by www.webinfopedia.com

			//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!

		   ------------------------------------------------------------------------------------------------------

			*/

			$new_length = $range_end-$range+1;

			header("HTTP/1.1 206 Partial Content");

			header("Content-Length: $new_length");

			header("Content-Range: bytes $range-$range_end/$size");

	 } else {

			$new_length=$size;

			header("Content-Length: ".$size);

	 }



	 /* Will output the file itself */

	 $chunksize = 1*(1024*1024); //you may want to change this

	 $bytes_send = 0;

	 if ($file = fopen($file, 'r'))

	 {

			if(isset($_SERVER['HTTP_RANGE']))

			fseek($file, $range);



			while(!feof($file) && 

					(!connection_aborted()) && 

					($bytes_send<$new_length)

				  )

			{

					$buffer = fread($file, $chunksize);

					print($buffer); //echo($buffer); // can also possible

					flush();

					$bytes_send += strlen($buffer);

			}

	 fclose($file);

	 } else

	 //If no permissiion

	 die('Error - can not open file.');

	 //die

	die();

	}

	

	/**

	 *  create a sample product

	 */

	public function defaultNewproduct($redirect,$status,$product_name)

	{

		// find sample campaign id 

		$user_id = $_SESSION['ss_user_id'];

		$samplecompaigninfo = $this->campaign->findSampleCampaignID();

		if($samplecompaigninfo){

			$campaign_id = $samplecompaigninfo->campaign_id;

			$cam_user_id = $samplecompaigninfo->user_id;

			$this->campaign->copyCampaignToMyFolder($campaign_id,$cam_user_id);

			

		}

		

		// copy Sample company name

		$samplecompanyinfo = $this->campaign->findSampleCompany();

		if($samplecompanyinfo){

			$company_id = $samplecompanyinfo->company_id;

			$company_user_id = $samplecompanyinfo->user_id;

			$company_name = $samplecompanyinfo->company_name;

			$this->campaign->copyCompanyProfile($company_id,$company_user_id,$company_name);

		}

		

		// copy Sample credibility

		$samplecredibilityinfo = $this->campaign->findSampleCredibility();

		if($samplecredibilityinfo){

			$credibility_id = $samplecredibilityinfo->c_id;

			$user_id = $samplecredibilityinfo->user_id;

			$credibility_name = $samplecredibilityinfo->credibility_name;

			$this->campaign->savetomycredibility($credibility_id,$credibility_name,$user_id);

		}

		redirect(base_url().'folder/my-folder');

	}

	

	

	

	

	

	//Below Functions are Added by Developer-A ---------------------------------------------------------------------------------------------------------------------------

	//Some of the Above Functions are Overwritten By the following functions----------------------------------------------------------------------------------------------

	function in_array_custom($needle, $haystack) {

		//By Dev@4489
		//Redirect to intro if IS slug not exists
		if($needle) {
			$intro=0;
			foreach ($haystack as $item) {
				if($item['name'] == 'intro')$intro=1;
				if($item['name'] == $this->_data['goth_btn_ctr']) $intro=2;
				if($item['name'] == $needle){	
					return true;	
				}	
			}			
			if($intro == 2) $go2intro = str_replace($needle,$this->_data['goth_btn_ctr'],current_url());
			else if($intro==1) $go2intro = str_replace($needle,'intro',current_url());
			else $go2intro = str_replace("/".$needle,'',current_url());
			redirect($go2intro);
		}
		////
		////

	  return false;

	}

	function array_search_custom($array, $inner_index, $value) 

	{	

		foreach($array as $key => $item)

		{

			if($item[$inner_index] == $value) {
				if(isset($item['html'])) {
					//if(!isset($item['custom'])) $this->_data['ISleftNav']=0;
					return $item['partid'];
				}
				return $key; exit; }

		}

		return false;

	}

	

	public function indirect_call_developer($action = NULL)

	{	

		//Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		// $this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		$this->_data['action'] = $action;

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'value-statement-intro','title'=>'Value Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'close','title'=>'Close'));

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		
		

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/indirect_call', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Call_Script_Qualify_Focus';

                        

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/indirect_call', $this->_data, TRUE);

			$name = 'Call_Script_Qualify_Focus';

                        

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

			

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['resp'] = False;

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'indirect-cold-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/indirect_call', $this->_data);

		}

		else 

		{

			

			$this->_data['resp'] = False;

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'indirect-cold-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/indirect_call', $this->_data);

		}

	}

	

	public function call_script_focus_product_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

				      2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'close','title'=>'Close'));

		$lastid = 5;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-focus-product', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Call-Script-Product-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-focus-product', $this->_data, TRUE);

			$name = 'Call-Script-Product-Focus';

			// Creating a File

			$fp = fopen(APPPATH."files/Name.doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-focus-product';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-focus-product', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-focus-product';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-focus-product', $this->_data);

		}

	}

	

	public function call_script_focus_pain_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  5=>array('name'=>'close','title'=>'Close'));

		$lastid = 5;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-focus-pain', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Call-Script-Pain-Intro';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-focus-pain', $this->_data, TRUE);

			$name = 'Call-Script-Pain-Intro';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-focus-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-focus-pain', $this->_data);

		}



		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-focus-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-focus-pain', $this->_data);

		}

	}



	public function call_script_name_drop_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'close','title'=>'Close'));

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-name-drop', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Call-Script-Name-Drop';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-name-drop', $this->_data, TRUE);

			$name = 'Call-Script-Name-Drop';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-name-drop';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-name-drop', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-name-drop';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-name-drop', $this->_data);

		}

	}

	

	public function call_script_webinar_follow_up_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'webinar-related-questions','title'=>'Webinar Related Questions'),

					  4=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  5=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  6=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  7=>array('name'=>'close','title'=>'Close'));

		$lastid = 7;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_webinar_follow_up_and_qualify_focus', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'call-script-webinar-follow-up-qualify';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_webinar_follow_up_and_qualify_focus', $this->_data, TRUE);

			$name = 'call-script-webinar-follow-up-qualify';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-webinar-follow-up';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_webinar_follow_up_and_qualify_focus', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-webinar-follow-up';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_webinar_follow_up_and_qualify_focus', $this->_data);

		}

	}

	

	public function call_script_emailfollowupandqualify_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'email-related-questions','title'=>'Email Related Questions'),

					  4=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  5=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  6=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  7=>array('name'=>'close','title'=>'Close'));

		$lastid = 7;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;



		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_email_follow_up_and_qualify_focus', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'call-script-email-follow-up-qualify';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_email_follow_up_and_qualify_focus', $this->_data, TRUE);

			$name = 'call-script-email-follow-up-qualify-developer';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);



			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call_script_email_follow_up_qualify';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_email_follow_up_and_qualify_focus', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call_script_email_follow_up_qualify';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_email_follow_up_and_qualify_focus', $this->_data);

		}

	}

	

	public function call_script_technical_focus_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'close','title'=>'Close'));

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_technical_focus', $this->_data, TRUE);

			$name = 'call-script-technical-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_technical_focus', $this->_data, TRUE);

			$name = 'call-script-technical-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-technical-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_technical_focus', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-technical-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_technical_focus', $this->_data);

		}

	}

	

	public function call_script_business_focus_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'close','title'=>'Close'));

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_business_focus', $this->_data, TRUE);

			$name = 'call-script-business-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_business_focus', $this->_data, TRUE);

			$name = 'call-script-business-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-business-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_business_focus', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-business-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_business_focus', $this->_data);

		}

	}

	

	public function call_script_personal_focus_developer($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'close','title'=>'Close'));

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_personal_focus', $this->_data, TRUE);

			$name = 'call-script-personal-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call_script_personal_focus', $this->_data, TRUE);

			$name = 'call-script-personal-focus';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-personal-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_personal_focus', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-personal-focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call_script_personal_focus', $this->_data);

		}

	}

	

	public function inboundCallScript_developer($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Greeting'),

					  2=>array('name'=>'prospect-request','title'=>"Prospect's Request"),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'schedule-next','title'=>'Scheduling the Next Discussion'));

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/inbound-call-script', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Inbound-Call-Script';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/inbound-call-script', $this->_data, TRUE);

			$name = 'Inbound-Call-Script';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'inbound-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/inbound-call-script', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'inbound-call-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/inbound-call-script', $this->_data);

		}

	}

	

	public function call_script_quick_close_developer($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;

		

		$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),
					   2=>array('name'=>'close','title'=>'Close'),
					   3=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),
 					   4=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),
					   5=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),
					   6=>array('name'=>'about-us','title'=>'Company and Product Info')				   
					   );

		$lastid = 6;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$this->_data['parts'] = $parts;

		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-quick-close', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Call-Script-Quick-Close';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/call-script-quick-close', $this->_data, TRUE);

			$name = 'Call-Script-Quick-Close';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'call-script-quick-close';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-quick-close', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'call-script-quick-close';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/call-script-quick-close', $this->_data);

		}

	}

	

	

	public function custom_script_developer($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		//By Dev@4489
		$active_campaign = $this->_data['campaign_info']->campaign_id;
		$ntemplate = $this->campaign->get_etemplate(0,$active_campaign);
		if($ntemplate) {
			$uCustTemplate['template_title']=$ntemplate->temp_title;
			$this->_data['uCustTemplate'] = $uCustTemplate;
		}
		////
		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action;
		//By Dev@4489
		$cispage='cis';
		$this->_data['cis'] = $cis;
		////

		$customTemplateInfo = $this->campaign->getCampaignCustomdata($active_campaign);

		//print_r($customTemplateInfo); exit;
		array_unshift($customTemplateInfo, null);
		unset($customTemplateInfo[0]);
		$this->_data['customTemplateInfo'] = $customTemplateInfo;
		
		$parts = array();
		$ik = 0;
		foreach($customTemplateInfo as $key => $temp_info)
		{
			if($ik == 0) $this->_data['goth_btn_ctr'] = 'cstmstage'.$key;
			$parts[$key]['name'] = 'cstmstage'.$key;
			$parts[$key]['title'] = $temp_info->heading;
			$parts[$key]['content'] = $temp_info->value;
			$ik++;
		}

		$lastid = $ik;

		include('interactive/objection_controller.php');

		$this->_data['lastid'] = $lastid;

		$oblastid = count($parts);
		
		include('interactive/custom_controller.php');
		
		$this->_data['parts'] = $parts;
		
		$this->_data['oblastid'] = $oblastid;
		

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/custom_script', $this->_data, TRUE);

			$name = 'Custom-Script';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else if($action == 'download2')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/custom_script', $this->_data, TRUE);

			$name = 'Custom-Script';

			// Creating a File

			$fp = fopen(APPPATH."files/Notes.doc", "a+");

			ftruncate($fp, 0);			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/Notes.doc';

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, 'Notes.doc', 'text/plain');

			exit;

			//$this->_tc_pdf($html, $name);

		}

		else if($this->in_array_custom($action,$parts))

		{

			$this->_data['button'] = False;

			$this->_data['partid'] = $this->array_search_custom($parts,'name',$action);

			$this->_data['method_name'] = 'custom-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/custom_script', $this->_data);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'custom-script';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/custom_script', $this->_data);

		}

	}
	
	/**
	 *  New User Training page
	 *  
	 *  @return Return_Description
	 */
	public function new_user_training()
	{		
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		/* print_r($this->_data);		
		die(); */
		$this->_data['page'] = '';
		$this->_data['train'] = 'nut';
	    $this->load->view('new_user_training', $this->_data);
	}
	
	/**
	 *  Sales Prospecting 101 page
	 *  
	 *  @return Return_Description
	 */
	/*public function sales_prospecting_101()
	{	
		$this->_data['page'] = '';
		$week=$_GET['w'];
		$this->_data['week'] = $week;
		$this->_data['train'] = 'sp101';
	    $this->load->view('sales_prospecting_101', $this->_data);
	}*/

	/**
	 *  Sales Prospecting Basics
	 *  
	 *  @return Return_Description
	 */
	 
	 


	public function salesProspectingTechniques()
	{		
		$record=$this->input->post('ctype');
		$status=$this->input->post('status');

		$user_id = $_SESSION['ss_user_id'];
		$this->load->model('crm_model', 'crm');	
		$query = $this->crm->get_sprospecting_techniques($user_id);
		if($query[$status]) $k=1;
		else $k=0;
		$json['tstatus'] = $k;
		$json['status']=true;
		$json['record']=$record;
		echo json_encode($json);return;	
	}
	
	
	public function salesProspectingBasics()
	{		
		$record=$this->input->post('ctype');
		$status=$this->input->post('status');

		$user_id = $_SESSION['ss_user_id'];
		$this->load->model('crm_model', 'crm');	
		$query = $this->crm->get_sprospecting($user_id);
		if($query[$status]) $k=1;
		else $k=0;
		$json['tstatus'] = $k;
		$json['status']=true;
		$json['record']=$record;
		echo json_encode($json);return;	
	}

	public function sales_prospecting_basics_details()
	{		
		$this->_data['page'] = '';
		$this->_data['train'] = 'spb';
		$user_id = $_SESSION['ss_user_id'];
		$this->load->model('crm_model', 'crm');	
		$query = $this->crm->get_sprospecting($user_id);
		$this->_data['tstatus'] = $query['topic1_status'];
	    $this->load->view('sales_prospecting_basics_details', $this->_data);
	}
	
	
	public function sales_prospecting_basics()
	{		
		$this->_data['page'] = '';
		$this->_data['train'] = 'spb';
		$user_id = $_SESSION['ss_user_id'];
		$this->load->model('crm_model', 'crm');	
		$this->_data['videos_list'] = $this->crm->get_all_videos('spb');
		$query = $this->crm->get_sprospecting($user_id);
		$this->_data['tstatus1'] = $query['topic1_status'];
		$this->_data['tstatus2'] = $query['topic2_status'];
		$this->_data['tstatus3'] = $query['topic3_status'];
		$this->_data['tstatus4'] = $query['topic4_status'];
		$this->_data['tstatus5'] = $query['topic5_status'];
		$this->_data['tstatus6'] = $query['topic6_status'];
		$this->_data['tstatus7'] = $query['topic7_status'];
		$this->_data['tstatus8'] = $query['topic8_status'];
		$this->_data['tstatus9'] = $query['topic9_status'];
		//echo "<pre>"; print_r($this->_data); echo "</pre>";
	    $this->load->view('sales_prospecting_basics', $this->_data);
	}
	
	
	public function sales_prospecting_techniques()
	{		
		$this->_data['page'] = '';
		$this->_data['train'] = 'spa';
		$user_id = $_SESSION['ss_user_id'];
		$this->load->model('crm_model', 'crm');	
		$this->_data['videos_list'] = $this->crm->get_all_videos('spt');
		$query = $this->crm->get_sprospecting_techniques($user_id);
		$this->_data['tstatus1'] = $query['topic1_status'];
		$this->_data['tstatus2'] = $query['topic2_status'];
		$this->_data['tstatus3'] = $query['topic3_status'];
		$this->_data['tstatus4'] = $query['topic4_status'];
		$this->_data['tstatus5'] = $query['topic5_status'];
		$this->_data['tstatus6'] = $query['topic6_status'];
		$this->_data['tstatus7'] = $query['topic7_status'];
		$this->_data['tstatus8'] = $query['topic8_status'];
		$this->_data['tstatus9'] = $query['topic9_status'];
		$this->_data['tstatus10'] = $query['topic10_status'];
		$this->_data['tstatus11'] = $query['topic11_status'];
		$this->_data['tstatus12'] = $query['topic12_status'];
	    $this->load->view('sales_prospecting_techniques', $this->_data);
	}

	/**
	 *  Sales Prospecting Advanced
	 *  
	 *  @return Return_Description
	 */
	public function sales_prospecting_advanced()
	{		
		$this->_data['page'] = '';
		$this->_data['train'] = 'spa';
	    $this->load->view('sales_prospecting_advanced', $this->_data);
	}
	
	/**
	 *  Role-Play Software page
	 *  
	 *  @return Return_Description
	 */
	public function role_play_software()
	{		
		/* print_r($this->_data);		
		die(); */
		$this->_data['page'] = '';
		$this->_data['train'] = 'rps';
	    $this->load->view('role_play_software', $this->_data);
	}
	/**
	 *  Sales Playbook Training page
	 *  
	 *  @return Return_Description
	 */
	public function sales_training()
	{		
		/* print_r($this->_data);		
		die(); */
		$this->_data['page'] = '';
		$this->_data['train'] = 'st';
	    $this->load->view('sales_playbook_training', $this->_data);
	}
	/**
	 *  CRM Training page
	 *  
	 *  @return Return_Description
	 */
	public function crm_training()
	{		
		/* print_r($this->_data);		
		die(); */
		$this->_data['page'] = '';
		$this->_data['train'] = 'crmt';
	    $this->load->view('crm_training', $this->_data);
	}
	
	//By Dev@4489
	/**

	 *  Post call email technical value templates doc file.

	 */

	public function post_call_email_value_focus($action = Null) 

	{



		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'post-call-email-value';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_call_email_value_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}
	/**

	 *  Post call email technical pain templates doc file.

	 */

	public function post_call_email_pain_focus($action = Null) 

	{



		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'post-call-email-pain';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'post_call_email_pain_focus';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}
	////
	
	//By Dev@4489
	/**

	 * Custom Objection Map HTML for Pdf

	 */

	public function custom_objection_map($action = Null) 

	{
		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		//$this->_data['users'] 		= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		//$this->_data['objections'] 	= $this->home->get_all_objections($this->_user_id, $this->_data['active_session_id']);

		$this->_data['action'] = $action;
		//get active campaign
		$user_id =  $this->_user_id;
		$this->db->select('campaign_id');
		$this->db->where('user_id',$user_id);
		$this->db->from($this->config->item('table_campaigns'));
		$this->db->order_by("status", "desc");
		$query = $this->db->get();
		$ucmpdata = $query->result();
		$active_campaign = 0;
		foreach($ucmpdata as $ucmp) {
			$active_campaign = $ucmp->campaign_id;
			break;
		}
		$this->_data['objectionInfo'] = $this->campaign->getCampaignObjections($active_campaign);
		//Objection data with responses
		$lastid = 0;
		include('interactive/objection_controller.php');
		$this->_data['lastid'] = $lastid;
		foreach($parts as $pi=>$pv){
			if($pi<=4) continue;
			$oresp = $pv['resp'];
			//echo "<pre>";print_r($oresp);echo "</pre>";
			$this->_data['getresp'] = 1;
			$this->_data['objname'] = $pv['name'];
			$this->_data['rsp'] = 'r1';
			$oresp['respc1']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
			if(isset($oresp['resp2'])) {
				$this->_data['rsp'] = 'r2';
				$oresp['respc2']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
			}
			if(isset($oresp['resp3'])) {
				$this->_data['rsp'] = 'r3';
				$oresp['respc3']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
			}
			$parts[$pi]['resp']=$oresp;
		}
		$this->_data['parts'] = $parts;

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/custom_objection_map', $this->_data, TRUE);

			$name = 'Custom-Objections-Map';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'custom-objections-map';

			$this->_data['img_dir'] = base_url() . 'images/';

			$this->load->view('outputs/custom_objection_map', $this->_data);

		}

	}
	////
		
	//By Dev@4489
	//Qualify questions responses count
	public function qualify_resplist_count($qid,$campgid,$qp) {
		return $this->campaign->getQualifyQuestRespCount($qid,$campgid,$qp,1,1);
	}
	
	public function sales_resplist_count($qid,$campgid,$qp) {
		return $this->campaign->getSalesQuestRespCount($qid,$campgid,$qp,1,1);
	}
	
	
	//Qualify questions with responses
	public function qualify_resplist_show($qid,$campgid,$qp=0,$level=1) {
		$questp_responses = $this->campaign->getQualifyQuestRespRow($qid,$campgid,$qp,1,1);
		if($questp_responses) {
			foreach ($questp_responses as $qpresp){
				$quest_responses = $this->campaign->getQualifyQuestResps($qid,$campgid,$qpresp->qr_id,1,1);
				echo '<ul class="q-resp">';
				if($quest_responses) {
					foreach ($quest_responses as $qresp){?>
					<li><span class="red-area">If [<?php echo ucfirst($qpresp->qr_response); ?>]:</span> 
                    	<?php if($qresp->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = ''; ?>
						<span <?php echo $ssansbg;?>><?php echo ucfirst($qresp->qr_response); ?></span>
						<?php $this->qualify_resplist_show($qid,$campgid,$qresp->qr_id,$level+1);?>
					</li>
					<?php }
				} else {
					?>
					<li><span class="red-area">If [<?php echo ucfirst($qpresp->qr_response); ?>]</span></li>
					<?php
				}
				echo '</ul>';
			}
		}
	}
	
	
	
	//Qualify questions with responses
	public function qualify_saleslist_show($qid,$campgid,$qp=0,$level=1) {
		$questp_responses = $this->campaign->getSalesQuestRespRow($qid,$campgid,$qp,1,1);
		if($questp_responses) {			
			foreach ($questp_responses as $qpresp){
				$quest_responses = $this->campaign->getSalesQuestResps($qid,$campgid,$qpresp->qr_id,1,1);				
				echo '<ul class="q-resp">';
				if($quest_responses) {
					foreach ($quest_responses as $qresp){
						//echo '<pre>'; print_r($qresp); echo '</pre>';
						//exit;
					?>
					<li><span class="red-area">If [<?php echo ucfirst($qpresp->qr_response); ?>]:</span> 
					    <?php if($qresp->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = ''; ?>
						<span <?php echo $ssansbg;?>><?php echo ucfirst($qresp->qr_response); ?></span>
						<?php $this->qualify_saleslist_show($qid,$campgid,$qresp->qr_id,$level+1);?>
					</li>
					<?php }
				} else {
					?>
					<li><span class="red-area">If [<?php echo ucfirst($qpresp->qr_response); ?>]</span></li>
					<?php
				}
				echo '</ul>';
			}
		}
	}
	
	
	//Qualify questions with responses
	public function qualify_list_show($campgid) {
		$campaign_output_tech_qualify = $this->campaign->getQualifyQuest($campgid,1);
		ob_start();
		if (isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify){
			?>
			<ul class="q-resp">
				<?php foreach ($campaign_output_tech_qualify as $single_tech_qualify):
				if($single_tech_qualify->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
						$respCount = $this->qualify_resplist_count($single_tech_qualify->tech_q_id,$campgid,0);
				?>
					<?php // print_r($single_tech_value) ?>
					<li<?php echo ($respCount?' class="qfQuest"':'')?>><?php if($respCount) echo '<a href="javascript:void(0)" class="qfsublist" onclick="qfsublist(this)">+</a>';?><span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $single_tech_qualify->tech_q_id ?>_<?php echo $single_tech_qualify->campaign_id; ?>"><?php echo ucfirst($single_tech_qualify->value);?></span>
					<?php if($respCount) $this->qualify_resplist_show($single_tech_qualify->tech_q_id,$campgid,0,1);?>
					</li>
				<?php endforeach;?>
			</ul>
			<?php	  			
		}
		$Question_responses=ob_get_contents();
		ob_end_clean();
		return $Question_responses;
		
	}
	
	
	
	
	public function sales_list_show($campgid,$type) {
		$sales_qus = $this->campaign->getallSalesQuestion($campgid,$type);
		ob_start();
		if (isset($sales_qus) && $sales_qus){
			?>
			<ul class="q-resp">
				<?php foreach ($sales_qus as $sintechsalesQus):
					if($sintechsalesQus->visible==0) $show = ' style="display:none"'; else $show = ' style="display:block"';	
					if($sintechsalesQus->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
					$respCount = $this->sales_resplist_count($sintechsalesQus->id,$campgid,0);
				?>
                <li<?php echo $show; echo ($respCount?' class="qfQuest"':'')?>>
				<?php if($respCount) echo '<a href="javascript:void(0)" class="qfsublist" onclick="qfsublist(this)">+</a>';?>
                <span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $sintechsalesQus->id ?>_<?php echo $sintechsalesQus->campaign; ?>"><?php echo ucfirst($sintechsalesQus->question);?></span>
                <?php if($respCount) $this->qualify_saleslist_show($sintechsalesQus->id,$campgid,0,1);?>
                </li>
				<?php endforeach;?>
			</ul>
            
			<?php	
						
		} 
		$Question_responses=ob_get_contents();
		ob_end_clean();
		return $Question_responses;
		
	} 
	
	
	//Editable Concept
	//Custom template data getting
	public function get_script_template() {
		//$params = explode("output/",uri_string());
		//$cslug = explode("/",$params[1]);
		$cslug = $this->uri->segment(2);//template name
		$uMainTemplate = $this->campaign->get_maintemplate_byslug($cslug);
		$cmpgid = $this->_data['campaign_info']->campaign_id;
		if($uMainTemplate['temp_type']=='Interview Emails') {
			$jpost = $this->applicant->get_activejobpost();
			if($jpost) $cmpgid=$jpost['post_id'];
		}
		$uCustTemplate = $this->campaign->get_template_byslug($cslug,$this->_data['campaign_info']->campaign_id);
		if($uCustTemplate) {
			$this->_data['template_sections'] = $this->campaign->get_template_sections($uCustTemplate['temp_no']);
			$temp_content = $this->campaign->get_template_content($uCustTemplate['temp_no'],$this->_data['campaign_info']->campaign_id);
			$this->_data['template_content'] = $temp_content;
			$this->_data['uCustTemplate'] = $uCustTemplate;
			//Template Tasks
			$this->load->model('crm_model', 'crm');					
			$template_tasks=$this->crm->get_template_tasks($uCustTemplate['temp_no'],$cmpgid);			
			if($template_tasks) {
				$email_tasks = array();
				foreach($template_tasks as $etask) {					
					$eid = $etask->email_id;
					if(!isset($email_tasks[$eid])) $email_tasks[$eid] = array();					
					$email_tasks[$eid][] = $etask;
				}
				$this->_data['email_tasks'] = $email_tasks;
			}			
		}
	}
	/**

	 *   checking-back-in-email-pain

	 */

	public function checking_back_in_email_pain($action = Null) 

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['action'] = $action ;
		$this->get_script_template();//By Dev@4489

		if($action == 'download')

		{

			$this->_data['button'] = False;

			$html = $this->load->view('outputs/email-template', $this->_data, TRUE);
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'checking-back-in-email-pain';

			

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			// fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			

			//$this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'checking-back-in-email-pain';

			$this->_data['img_dir'] = base_url() . 'images/';

			/* echo '<pre>';

			print_r($this->_data); */

			$this->load->view('outputs/email-template', $this->_data);

		}

	}
	////
	//Interview Email Templates
	/**

	 * Before Call HTML for Pdf

	 */
	public function interview_emails($action = Null)

	{

		if(!$this->_data['is_paid']){

			$this->session->set_flashdata('session_msg','Please upgrade your account');

			redirect(base_url()."folder/my-folder");

		}
		//betapro/output/ipre-call-email-thread/abc
		$pam1 = $this->uri->segment(1);//output
		$pam2 = $this->uri->segment(2);//template name
		$action = $pam3 = $this->uri->segment(3);//action - download
		//echo "$action 1. $pam1-2. $pam2-3. $pam3";

		

		// Configurations

		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		$this->_data['action'] = $action;
		
		$this->get_script_template();//By Dev@4489

		// Get data from database to edit the record.

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));



		if($action == 'download')

		{

			$this->_data['button'] = False;

			//$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
			$html = $this->load->view('outputs/email-template.php', $this->_data, TRUE);//By Dev@4489
			//Download document
			$dlinfo = array('html'=>$html,'file'=>$this->uri->segment(2));
			$this->load->view('docx', $dlinfo);return;

			$name = 'Pre-Call Email Thread';

			// Creating a File

			$fp = fopen(APPPATH."files/".$name.".doc", "a+");

			ftruncate($fp, 0);

			

			fwrite($fp,$html);

			//path to the file

			$file_path=APPPATH.'files/'.$name.".doc";

			fclose($myfile);

			//Call the download function with file path,file name and file type

			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');

			exit;

			// $this->_tc_pdf($html, $name);

		}

		else 

		{

			$this->_data['button'] = TRUE;

			$this->_data['method_name'] = 'pre-call-email-thread';

			$this->_data['img_dir'] = base_url() . 'images/';

			//$this->load->view('outputs/pre_call', $this->_data);
			$this->load->view('outputs/email-template', $this->_data);//By Dev@4489

		}

	}
	//end of Interview Email Templates

	

}

/* End of file home.php */

/* Location: ./application/controllers/home.php */
