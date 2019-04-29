<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);
class Home extends CI_Controller {
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
		
		if(!$this->config->item('is_local'))
		{
			include(CDOC_ROOT."members/library/Am/Lite.php"); 
                      
            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15), 'Restricted access'); //  This array is Updated by sukhdev developer on 17-April-2014
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18), 'Restricted access'); //  By Dev@4489 24-Oct-2015
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
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15'));//  This array is Updated by sukhdev developer on 17-April-2014
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18'));//  By Dev@4489 24-Oct-2015
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','5','3'));//  By Dev@4489 24-Oct-2015
			// 9  is for Scripter Pro 3 Month
			// 10 is for Scripter Pro 1 Year

			// Check User Subscription PAID OR FREE
			$this->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;
			//By Dev@4489
			//Modify access
			$eSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('3','5','6','10','14','15'));//Scripter Pro for Editing  By Dev@4489 24-Oct-2015
			//Pro Lite Subscription
			$PLSubscribe = Am_Lite::getInstance()->haveSubscriptions(array('18'));
			if($PLSubscribe && !$eSubscribe) $this->_data['is_prolite'] = TRUE;
			if($eSubscribe) $this->_data['eScripter'] = TRUE;
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
		
	   //By Dev@4489
		//Check & Get the shared user id for Lite Users
		if($PLSubscribe && !$eSubscribe) {
			$saUser = $this->home->SharedUser($this->_data['user_id']);
			if($saUser) $this->_data['user_id'] = $saUser;
		}
		////
	   $this->_user_id = $this->_data['user_id'];
       $_SESSION['ss_user_id'] = $this->_user_id;
	   //Verify User Campaigns once
		$ucsid = $this->session->userdata('ss_session_id');
		$uccid = $this->session->userdata('active_campaign');
		if(1 || $uccid) {
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
		if(empty($is_product))
		{
			// Add Product into Database
			$status = '2';
			// $data = $this->home->addProduct($status, NULL);
			// $this->_data['product_id'] = $data['product_id'];
			// $this->session->set_userdata('ss_session_id', $data['session_id']);
			
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
		
		
		/* $this->_data['products'] 	= $this->home->get_all_products($this->_user_id, $this->_data['active_session_id']);
        $this->_data['custome_fields'] 	= $this->home->get_custome_fields($this->_user_id, 'users', $this->_data['active_session_id']);
        $this->_data['summary'] 	= $this->home->get_custome_fields($this->_user_id, 'summary', $this->_data['active_session_id']);
        $this->_data['interes'] 	= $this->home->get_custome_fields($this->_user_id, 'interest', $this->_data['active_session_id']);
        // $this->_data['credibilities'] 	= $this->home->get_all_credibilities($this->_user_id, $this->_data['active_session_id']);
        $this->_data['credibilities'] 	= $this->home->get_all_credibilities_new($this->_user_id, $this->_data['active_session_id']);
		$this->_data['credibilities_data'] 	= $this->campaign->get_current_active_credibility($this->_user_id, $this->_data['active_session_id']);

		$this->_data['target'] 	= $this->home->get_custome_fields($this->_user_id, 'target', $this->_data['active_session_id']);
        $this->_data['sales_process'] 	= $this->home->get_custome_fields($this->_user_id, 'sales-process', $this->_data['active_session_id']);
        $this->_data['interestB1'] 	= $this->home->get_custome_fields($this->_user_id, 'interestB1', $this->_data['active_session_id']);
        $this->_data['interestB2'] 	= $this->home->get_custome_fields($this->_user_id, 'interestB2', $this->_data['active_session_id']);
        $this->_data['ideal_prospect_environment'] 	= $this->home->get_custome_fields($this->_user_id, 'ideal-prospect-environment', $this->_data['active_session_id']);
         */

        // Show/Hide Summary Boxes on Product and Value Tab
 
        /* $this->_data['total_products']	= count($this->_data['products']);

        if($this->_data['total_products'] == 1)
        {
        	$this->_data['display'] = 'style="display:none;"';
        	$this->_data['display_heading'] = 'display:none;';
        }
        else 
        {
        	$this->_data['display'] = 'style="display:block;"';
        	$this->_data['display_heading'] = 'display:block;';
        } */

        $this->_data['all_sessions'] = $this->home->get_all_sessions();
        $this->_data['total_sessions'] = count($this->_data['all_sessions']);

		
		$this->_data['receive_invitations'] = $this->home->getAllRequestsNew($this->_user_id, 'receiver');
		$this->_data['accept_invitations'] = $this->home->acceptInvitations($this->_user_id);
		$this->_data['accept_invitations_receiver'] = $this->home->acceptInvitationsReceiver($this->_user_id);
	    
		/**  get active session name data */
		$this->_data['active_name_drop_exp'] = $this->campaign->findActiveNameDrop();
		
		//By Dev@4489
		/**  now find all active campaign data name drop , company name etc */
		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);
		if($active_campaign_data == false) 
		{
			$this->session->set_flashdata('session_msg','Please Create campaign ,company profile and name drop');
			if(strpos($_SERVER['REQUEST_URI'],"my-folder")!=false)return;
			redirect(base_url()."folder/my-folder");
		}		

		/** campaign info data */
		$this->_data['campaign_info'] = $active_campaign_data;		
		//Qualify questions with responses
		$this->_data['campaign_output_qualify'] = $this->qualify_list_show($active_campaign_data->campaign_id);
		$this->_data['campaign_output_tech_val'] = $this->campaign->getOutputTechValue($active_campaign_data->campaign_id);
		$this->_data['campaign_output_biz_val'] = $this->campaign->getOutputBizValue($active_campaign_data->campaign_id);
		$this->_data['campaign_output_per_val'] = $this->campaign->getOutputPerValue($active_campaign_data->campaign_id);
		$this->_data['campaign_output_tech_pain'] = $this->campaign->getOutputTechPain($active_campaign_data->campaign_id);
		$this->_data['campaign_output_biz_pain'] = $this->campaign->getOutputBizPain($active_campaign_data->campaign_id);
		$this->_data['campaign_output_per_pain'] = $this->campaign->getOutputPerPain($active_campaign_data->campaign_id);
		$this->_data['campaign_output_tech_qualify'] = $this->campaign->getOutputTechQualify($active_campaign_data->campaign_id);
		$this->_data['campaign_output_biz_qualify'] = $this->campaign->getOutputBizQualify($active_campaign_data->campaign_id);
		$this->_data['campaign_output_per_qualify'] = $this->campaign->getOutputPerQualify($active_campaign_data->campaign_id);		

		$this->_data['campaign_tech_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'tech_val_summary');
		$this->_data['campaign_biz_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'bus_val_summary');
		$this->_data['campaign_per_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'per_val_summary');
		$this->_data['sale_process_close1'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close1');
		$this->_data['sale_process_close2'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close2');
		$this->_data['sale_process_close3'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close3');		

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

		/**  find data about company profile **/
		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);
		$this->_data['company_info'] = $company_info_detail;
		$this->_data['company_meta'] = $this->productModel->getAllMetaValue($company_info_detail->company_id);	
		////
		
	}

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
			fclose($myfile);
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
			fclose($myfile);
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/drop_statement', $this->_data, TRUE);
			$name = 'Drop-Statement';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/silver_bullets', $this->_data, TRUE);
			$name = 'Silver-Bullets';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/elevator_pitch', $this->_data, TRUE);
			$name = 'Elevator-Pitch';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/pre_qualifying_questions', $this->_data, TRUE);
			$name = 'Pre-Qualifying-Question';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/hard_qualifying_questions', $this->_data, TRUE);
			$name = 'Hard-Qualifying-Question';
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
		$this->_data['users'] 		= $this->home->get_data($this->_user_id, $this->config->item('table_users'));
		$this->_data['objections'] 	= $this->home->get_all_objections($this->_user_id, $this->_data['active_session_id']);
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/objection_map', $this->_data, TRUE);
			$name = 'Objection-Map';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/presentation', $this->_data, TRUE);
			$name = 'Sales-Presentation';
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
		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));
		
		
		
		
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/indirect_call', $this->_data, TRUE);
			$name = 'Indirect-Call';
                        
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
			$this->_data['method_name'] = 'indirect-cold-call-script';
			$this->_data['img_dir'] = base_url() . 'images/';
			
			/* echo "<pre>";
			echo 'this';
				print_r($this->_data);
			die(); */
			
			$this->load->view('outputs/indirect_call', $this->_data);
		}
	}

	/**
	 * Direct Cold Call Scrit Map HTML for Pdf
	 */
	public function direct_call($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/direct_call', $this->_data, TRUE);
			$name = 'Direct-Call';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/meeting_script', $this->_data, TRUE);
			$name = 'First-Meeting-Script';
			
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
			$this->_data['method_name'] = 'first-meeting-script';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/meeting_script', $this->_data);
		}
	}

	/**
	 * Post Call HTML for Pdf
	 */
	public function post_call($action = Null)
	{
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
	 * Before Call HTML for Pdf
	 */
	public function pre_call($action = Null)
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		// Get data from database to edit the record.
		$this->_data['users'] 	= $this->home->get_data($this->_user_id, $this->config->item('table_users'));

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/pre_call', $this->_data, TRUE);
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
			$this->load->view('outputs/pre_call', $this->_data);
		}
	}

	/**
	 * Befor Call HTML for Pdf
	 */
	public function content_marketing($action = Null)
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/content_marketing', $this->_data, TRUE);
			$name = 'Content Marketing Topics';
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
		}else {
			$this->_data['button'] = TRUE;
			$this->_data['method_name'] = 'content-marketing-topics';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/content_marketing', $this->_data);
		}
	}

	/**
	 * Closing Questions HTML for Pdf
	 */
	public function closing_question($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/closing_questions', $this->_data, TRUE);
			$name = 'Closing-Question';
			
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/pre-call-email-pain-focus.php', $this->_data, TRUE);
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
	 * Closing Questions HTML for Pdf
	 */
	public function pre_call_email_product_focus($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd()));
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/pre-call-email-product-focus.php', $this->_data, TRUE);
			$name = 'Pre-Call-Email-Product-Focus';
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
			$this->_data['method_name'] = 'pre-call-email-product-focus';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/pre-call-email-product-focus.php', $this->_data);
		}
	}

	/**
	 * Closing Questions HTML for Pdf
	 */
	public function pre_call_email_value_focus($action = Null) 
	{
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
	 * Function Created by Aavid developer
	 * on 04 March 2014
	 */
	public function pre_call_email_namedrop_focus($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')

		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/pre-call-email-namedrop-focus.php', $this->_data, TRUE);
			$name = 'Pre-Call-Email-Namedrop-Focus';
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
		}else{
			$this->_data['button'] = TRUE;
			$this->_data['method_name'] = 'pre-call-email-namedrop-focus';
			$this->_data['img_dir'] = base_url() . 'images/';
			
			// var_dump($this->_data); die();
			
			
			$this->load->view('outputs/pre-call-email-namedrop-focus.php', $this->_data);
		}
	}

	/**
	 * Sales Letter Pain Focus HTML for Pdf
	 */
	public function salesLetterPainFocus($action = Null) 
	{
		// Configurations
		// 
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/internal-referral-email.php', $this->_data, TRUE);
			$name = 'Internal-Referral-Email';
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
			$this->_data['method_name'] = 'internal-referral-email';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/internal-referral-email.php', $this->_data);
		}
	}	   
    
	// Function Created by Aavid Developer for page Campaign Development. 
	/**
	* Campaign page Development
	*/
    public function CampaignDevelopment($action = Null)
    {
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['objections'] 	= $this->home->get_all_objections($this->_user_id, $this->_data['active_session_id']);
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/campaign-development.php', $this->_data, TRUE);
			//$name = 'campaign-development';
            $name = 'Email Drip Campaign Guide';
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/inbound-call-script.php', $this->_data, TRUE);
			$name = 'Inbound-Call-Script';
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
			$this->_data['method_name'] = 'inbound-call-script';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/inbound-call-script.php', $this->_data);
		}
	}

	/**
	 * Closing Questions HTML for Pdf
	 */
	public function call_script_focus_product($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/call-script-focus-product.php', $this->_data, TRUE);
			$name = 'Call-Script-Focus-Product';
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
			$this->_data['method_name'] = 'call-script-focus-product';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/call-script-focus-product.php', $this->_data);
		}
	}

	/**
	 * Closing Questions HTML for Pdf
	 */
	public function call_script_focus_pain($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/call-script-focus-pain.php', $this->_data, TRUE);
			$name = 'Call-Script-Focus-Pain';
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
			$this->_data['method_name'] = 'call-script-focus-pain';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/call-script-focus-pain.php', $this->_data);
		}
	}

	/**
	 * Closing Questions HTML for Pdf
	 */
	public function call_script_name_drop($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/call-script-name-drop.php', $this->_data, TRUE);
			$name = 'Call-Script-Name-Drop';
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
			$this->_data['method_name'] = 'call-script-name-drop';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/call-script-name-drop.php', $this->_data);
		}
	}

	/**
	 * Voicemail Script ? Value Focus HTML for Pdf
	 */
	public function voicemail_value_focus($action = Null) 
	{
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
	 * Voicemail Script ? Value Focus HTML for Pdf
	 */
	public function post_voicemail_value_focus($action = Null) 
	{
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
	 * Voicemail Script ? Value Focus (Appointment) HTML for Pdf
	 */
	public function voicemail_value_focus_appoint($action = Null) 
	{
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
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;

		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/voicemail-name-drop-focus.php', $this->_data, TRUE);
			$name = 'Voicemail-Name-Drop-Focus';
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
			$this->_data['method_name'] = 'voicemail-name-drop-focus';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/voicemail-name-drop-focus.php', $this->_data);
		}
	}

	/**
	 * Voicemail Script ? Name Drop Focus HTML for Pdf
	 */
	public function post_voicemail_name_drop_focus($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/post-voicemail-name-drop-focus.php', $this->_data, TRUE);
			$name = 'Post-Voicemail-Name-Drop-Focus';
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
		}else{
			$this->_data['button'] = TRUE;
			$this->_data['method_name'] = 'post-voicemail-name-drop-focus';
			$this->_data['img_dir'] = base_url() . 'images/';
			$this->load->view('outputs/post-voicemail-name-drop-focus.php', $this->_data);
		}
	}

	/**
	 * Voicemail Script ? Name Drop Focus Appointment HTML for Pdf
	 */

	public function voicemail_name_drop_focus_appoint($action = Null) 
	{
		// Configurations
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
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
			fclose($myfile);
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
			$this->load->view('outputs/voicemail-name-drop-appoint.php', $this->_data);
		}
	}


	/**
	 * Voicemail Script ? Pain Focus Appointment HTML for Pdf
	 */
	public function voicemail_pain_focus_appoint($action = Null) 
	{
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
		if($action == 'download')
		{
			$this->_data['button'] = False;
			$html = $this->load->view('outputs/product_matrix', $this->_data, TRUE);
			$name = 'Product Matrix';
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
			/* //This section is commented to hide in PRO version Developer-A
			case 'ideal-prospect-profile':
			$d_page_name = 3;
			break;
			*/
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
			//By Dev@4489
			case 'campaigns':
			//Pro List user cant access this page
			if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
			$d_page_name = 41;
			break;
			case 'company-profiles':
			//Pro List user cant access this page
			if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
			$d_page_name = 42;
			break;
			case 'name-drop-examples':
			//Pro List user cant access this page
			if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
			$d_page_name = 43;
			break;
			case 'custom-content':
			$d_page_name = 44;
			break;
			case 'product-profile':
			//Pro List user cant access this page
			if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
			$d_page_name = 45;
			break;
			////

			case 'team-folder':
			//Pro List user cant access this page
			if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
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
		//shared users list
		$this->_data['all_shared_users'] = $this->home->getSharedUsers($this->_user_id);
		/**  find all records for drop down **/
		//By Dev@4489
		$this->_data['custom_contents'] = $this->campaign->get_campaign_customcontents();
		////
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['drop_company'] = $this->campaign->get_drop_company();
		//By Dev@4489
		//Name drop example
		//$this->_data['drop_name'] = $this->campaign->get_drop_name();
		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();
		//Editable template
		$etemplates = $this->campaign->get_etemplates($this->_data['campaign_info']->campaign_id);
		$this->_data['etemplate'] = $etemplates['templates'];
		$this->_data['temphides'] = $etemplates['hidetemp'];
		////
		if($this->input->post('submit'))
		{
				$search_name = $this->input->post('search_name');
				//By Dev@4489
				//Check for Lite Users
				$usr_data = $this->home->searchUser($search_name);
				if(empty($usr_data))
				{
						$this->_data['message'] = 'Not able to find user';
				} else if(isset($this->_data['eScripter'])){
					include(CDOC_ROOT."members/bootstrap.php"); 
					$Amuser = am_Di::getInstance()->userTable;										
					foreach ($usr_data as $usri=>$usr) {
						$receiver = $this->home->sharealreadyExist($usr->user_id);
						if($receiver=="Y") continue;
						$ausr = $Amuser->findBy(array('login'=>$usr->username));
						if($ausr) {
							$amuserid = $ausr[0]->user_id;
							$Am_user = $Amuser->load($amuserid, false);
							if($Am_user) {
								$products = $Am_user->getActiveProductIds();
								if(in_array(18, $products) || in_array(19, $products)){
									$usr->share="Y";
									$usr_data[$usri]=$usr;
								}
							}
						}
					}
				}
				$this->_data['user_data'] = $usr_data;
				////
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
                        
		
		$this->_data['page'] = '';
		$this->_data['d_page'] = $d_page_name;
		$this->_data['hidet'] = $this->uri->segment(3);//by Dev@4489
	    $this->load->view('download', $this->_data);
	}
	
	/**
	 *  My team mate folder page
	 *  
	 *  @return Return_Description
	 */
	public function team_folder_view()
	{
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		$d_page_name = 16;
		// For Existing Team Members Conection
		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');
		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);
		//shared users list
		$this->_data['all_shared_users'] = $this->home->getSharedUsers($this->_user_id);
		/**  find all records for drop down **/
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['drop_company'] = $this->campaign->get_drop_company();
		$this->_data['drop_name'] = $this->campaign->get_drop_name();
		if($this->input->post('submit'))
		{
				$search_name = $this->input->post('search_name');
				/*$this->_data['user_data'] = $this->home->searchUser($search_name);
				if(empty($this->_data['user_data']))
				{
						$this->_data['message'] = 'Not able to find user';
				}*/
				//By Dev@4489
				//Check for Lite Users
				//$this->_data['user_data'] = $this->home->searchUser($search_name);
				//if(empty($this->_data['user_data']))
				$usr_data = $this->home->searchUser($search_name);
				if(empty($usr_data))
				{
						$this->_data['message'] = 'Not able to find user';
				} else if(isset($this->_data['eScripter'])){
					include(CDOC_ROOT."members/bootstrap.php"); 
					$Amuser = am_Di::getInstance()->userTable;										
					foreach ($usr_data as $usri=>$usr) {
						$receiver = $this->home->sharealreadyExist($usr->user_id);
						if($receiver=="Y") continue;
						$ausr = $Amuser->findBy(array('login'=>$usr->username));
						if($ausr) {
							$amuserid = $ausr[0]->user_id;
							$Am_user = $Amuser->load($amuserid, false);
							if($Am_user) {
								$products = $Am_user->getActiveProductIds();
								if(in_array(18, $products) || in_array(19, $products)){
									$usr->share="Y";
									$usr_data[$usri]=$usr;
								}
							}
						}
					}
				}
				$this->_data['user_data'] = $usr_data;
				////
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
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
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
	 * To call specific step which is call.
	 * @param $step integer
	 */
	public function step($step) 
	{
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		$this->_data['step'] =	$step;

		switch ($step) {

			case 'product':
			$step_number = 0;
			break;

			case 'value':
			$step_number = 1;
			break;
			
			/*case 'value2':       // break value in 3 step value 1 , value 2 and value 3
			$step_number = 10;
			break;
			
			case 'value3':       // break value in 3 step value 1 , value 2 and value 3
			$step_number = 11;
			break;
			*/	//These are removed to  stop the functionality in campaigns for the PRO version - Developer-A
			
			case 'pain':
			$step_number = 2;
			break;

			case 'qualifying':
			$step_number = 3;
			break;

			case 'ideal-prospect':
			$step_number = 4;
			break;

			case 'credibility':
			$step_number = 5;
			break;

			case 'interest':
			$step_number = 6;
			break;

			case 'objections':
			$step_number = 8;
			break;

			case 'ideal-sales-process':
			$step_number = 7;
			break;
                    
            case 'ideal-prospect-environment':
			$step_number = 9;
			break;
			
			case 'custom_content':
			$step_number = 99;
			break;
			//By Dev@4489
			case 'objection':
			$step_number = 98;
			break;
			////
		}
		$step = 'step_' . $step_number;
		$this->$step();
	}
        
        
        /***** For Preview ****/

        /*
        public function preview($step) 
	{
		$this->_data['preview'] = $step;

		switch ($step) {

			case 'product':
			$step_number = 0;
			break;

			case 'value':
			$step_number = 1;
			break;

			case 'pain':
			$step_number = 2;
			break;

			case 'qualifying':
			$step_number = 3;
			break;

			case 'ideal-prospect':
			$step_number = 4;
			break;

			case 'credibility':
			$step_number = 5;
			break;

			case 'interest':
			$step_number = 6;
			break;

			case 'objections':
			$step_number = 8;
			break;

			case 'ideal-sales-process':
			$step_number = 7;
			break;
                    
                        case 'ideal-prospect-environment':
			$step_number = 9;
			break;
		}
		$step = 'preview_' . $step_number;
		$this->$step();
	}
        */
        /**** Product Preview ****/
        /*
        public function preview_0()
        {
            $this->_data['d_page'] = $d_page_name;
            $this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

            $this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
            
            $this->_data['button'] = TRUE;
            $this->_data['method_name'] = 'prospect-pain';
            $this->_data['img_dir'] = base_url() . 'images/';
            $this->load->view('preview', $this->_data);
        }
        */
	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $d_page_name Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */	
	public function preview($d_page_name)
	{
		//echo $d_page_name;
		$this->_data['d_page'] = $d_page_name;
		$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );

		$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
		
		$this->_data['button'] = TRUE;
		$this->_data['method_name'] = 'product-preview';
		$this->_data['img_dir'] = base_url() . 'images/';
		$this->load->view('preview', $this->_data);
	}
        
	/**
	 * Step 1
	 * Value - Input
	 */
	private function step_0()
	{
		
		$editproduct_id = $this->session->userdata('edit_product');
		$this->_data['page'] = 0;
		$this->_data['lnav'] = 'Y1';
		if ($this->input->post('form_submit'))
		{
			// $this->home->add(NULL, $this->_data['active_session_id']);
			
			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
		    // update productname //
			
			/**  for product name change logic start  **/
			$pro_data = $_POST['tbl']['tpd'];
			$productname_forsave = NULL;
			// var_dump($pro_data);
			if(is_array($pro_data)){
				foreach($pro_data  as $key=>$value){
					foreach($value  as $key2=>$value2){
						if($key2 == 'P_Q1')
						{
							$productname_forsave = $value2; 
						}
					}
				}
			}
			
			// echo $productname_forsave ;
			if($productname_forsave != NULL){
			
				$checkproduct = $this->productModel->checkprodcutnameUniqune($productname_forsave,$editproduct_id);			    
				$productNameIsSame = $this->productModel->isProductNameSame($editproduct_id,$checkproduct);
				if($productNameIsSame == false){
					$this->productModel->updateProductNameWithservicename($editproduct_id,$checkproduct);
				}
			}
			/**  for product name change logic start  **/
			
			
			
			if($this->input->post('form_submit') == "Save")
			{
				 // redirect(base_url().'step/product');
			}else{
				redirect(base_url().'folder/product-profile');
			}
		}
		$editproduct_id = $this->session->userdata('edit_product');
		$this->_data['edit_product'] = $this->productModel->getProduct($editproduct_id);
		$this->_data['product_names'] = $this->productModel->getProMetaNames($editproduct_id);//by Dev@4489
		$this->_data['product_desc'] = $this->productModel->getProMetaDesc($editproduct_id);//by Dev@4489
		$this->_data['product_profiles'] = $this->productModel->getProMetaDatas($editproduct_id);//by Dev@4489
		//template user 01-3-2016 by Dev@4489
		$this->_data['template_product_names'] 		= $this->productModel->getTuserProMetaNames();//by Dev@4489
		$this->_data['template_product_desc'] 		= $this->productModel->getTuserProMetaDesc();//by Dev@4489
		$this->_data['template_product_profiles'] 	= $this->productModel->getTuserProMetaDatas();//by Dev@4489
		// $this->_data['edit_product_info'] = $this->productModel->getProductInfo($editproduct_id);
		$this->load->view('step-0', $this->_data);
	}

	/**
	 * Step 1
	 * Value - Input 
	 */
	private function step_1() 
	{
	
		 // var_dump($this->_data); die();
		// $this->output->enable_profiler(true);
		
		$this->_data['page'] = 1;
		$active_campaign = $this->session->userdata('active_campaign');
		
		if(!$active_campaign)
		{
			redirect(base_url()."folder/campaigns");
		}
		//by Dev@4489
		//update tech value sort order
		if($this->input->post('action') && $this->input->post('action')=="SortOrderupdate")
		{
			$this->campaign->updateTechVOrder($this->input->post('rcid'),$this->input->post('sord'));
			exit;
		}
		////
		
		if($this->input->post('redirect_url'))
		{
			$this->home->add(null, $this->_data['active_session_id']);
			header("location: " . $this->input->post('redirect_url'));
			exit;
		}
		
		// var_dump($_POST); die();
		if ($this->input->post('step'))
		{    
			
			
			
			// $this->home->add(NULL, $this->_data['active_session_id']);
			//$this->home->update_progress_menu($this->_data['active_session_id']);
			
			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
			//by Dev@4489
			//Value Identifier Tool options saving ignore list
			$vit_igdata = $this->input->post('vit_ignore');
			$this->productModel->vit_ignore_save($vit_igdata,$active_campaign);
			////
			
			$this->home->update_progress_menu($active_campaign);
			
			if($this->input->post('form_submit') == "Continue")
			{
				/*redirect(base_url().'step/value2');*/
				redirect(base_url().'step/pain'); // Above Redirect URL is changed in PRO version to skip the steps in campaign creation/ updation Developer-A
			}	
		}
		
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['campaign_tech'] = $this->campaign->getTechValue($active_campaign);
		$this->_data['campaign_tech_summary'] = $this->campaign->getCampaignMetadata($active_campaign,'tech_val_summary');
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->_data['campaign_tech_values'] = $this->campaign->getTechValues($active_campaign);//by Dev@4489
		$this->_data['templateuser_tech_values'] = $this->campaign->getTuserTechValues();//by Dev@4489
		//by Dev@4489
		//Value Identifier Tool options
		//get VIT ignore list
		$vit_ignore_list = $this->productModel->vit_ignore_get($active_campaign);
		$this->_data['vit_ignore_list'] = $vit_ignore_list;
		////
		$this->load->view('step-1', $this->_data);
	}
	
	/**
	 * Step 1  for business benefits
	 * Value2 - Input 
	 */
	private function step_10() 
	{
	    
		$this->_data['page'] = 10;
		$active_campaign = $this->session->userdata('active_campaign');
		if(!$active_campaign)
		{
			redirect(base_url()."folder/my-folder");
		}
		
		if($this->input->post('redirect_url'))
		{
			$this->home->add(null, $this->_data['active_session_id']);
			header("location: " . $this->input->post('redirect_url'));
			exit;
		}

		if($this->input->post('step'))
		{    
			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
			$this->home->update_progress_menu($active_campaign);
			if($this->input->post('form_submit') == "Continue")
			{
				redirect(base_url().'step/value3');	
			}
		}
		
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['campaign_tech'] = $this->campaign->getTechValue($active_campaign);
		$this->_data['campaign_business_summary'] = $this->campaign->getCampaignMetadata($active_campaign,'bus_val_summary');
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('step_10', $this->_data);
		
	}
	
	/**
	 * Step 1  for personal benefits
	 * Value3 - Input 
	 */
	private function step_11() 
	{
	    
		$this->_data['page'] = 11;
		$active_campaign = $this->session->userdata('active_campaign');
		if(!$active_campaign)
		{
			redirect(base_url()."folder/my-folder");
		}
		
		if($this->input->post('redirect_url'))
		{
			$this->home->add(null, $this->_data['active_session_id']);
			header("location: " . $this->input->post('redirect_url'));
			exit;
		}
		
		if ($this->input->post('step'))
		{    
			/* $this->home->add(NULL, $this->_data['active_session_id']);
			$this->home->update_progress_menu($this->_data['active_session_id']); */
			/**  find question status is set or not **/
			
			$this->home->update_progress_menu($active_campaign);
			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
			if($this->input->post('form_submit') == "Continue")
			{
				redirect(base_url().'step/pain');
			}
		}
		
		$this->_data['campaign_personal_parent'] = $this->campaign->getPersonalValue($active_campaign);
	
		/* var_dump($this->_data['campaign_personal_parent']);
		die(); */
		
		$this->_data['campaign_tech_pers_val'] = $this->campaign->getTechPersValData($active_campaign);
		
		// die();
		$this->_data['campaign_personal_orphan'] = $this->campaign->getOrphanPersonalValue($active_campaign);		
		$this->_data['campaign_personal_summary'] = $this->campaign->getCampaignMetadata($active_campaign,'per_val_summary');
		
		
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();    
		$this->load->view('step_11', $this->_data);	
	}
	
	/**
	 * Step 2
	 * Plain - Input
	 */
	private function step_2()
	{
		$this->_data['page'] = 2;
		$active_campaign = $this->session->userdata('active_campaign');
		if(!$active_campaign)
		{
			redirect(base_url()."folder/campaigns");
		}
		//by Dev@4489
		//update tech pain sort order
		if($this->input->post('action') && $this->input->post('action')=="SortOrderupdate")
		{
			$this->campaign->updateTechPOrder($this->input->post('rcid'),$this->input->post('sord'));
			exit;
		}
		////
		if($this->input->post('redirect_url'))
		{
			$this->home->add(null, $this->_data['active_session_id']);
			header("location: " . $this->input->post('redirect_url'));
			exit;
		}

		if($this->input->post('step'))
		{	
			
			$this->home->update_progress_menu($active_campaign);
			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
			
			if($this->input->post('form_submit') == "Continue")
			{
				redirect(base_url().'step/qualifying');
			}
		}
	
		$this->_data['tech_val_pain'] = $this->campaign->getTechValuePain($active_campaign);
		$this->_data['tech_val_pain_orph'] = $this->campaign->getTechValuePainOrph($active_campaign);
		$this->_data['biz_val_pain'] = $this->campaign->getBusValuePain($active_campaign);
		$this->_data['biz_val_pain_orph'] = $this->campaign->getBusValuePainOrph($active_campaign);
		$this->_data['per_val_pain'] = $this->campaign->getPerValuePain($active_campaign);
		$this->_data['per_val_pain_orph'] = $this->campaign->getPerValuePainOrph($active_campaign);
		$this->_data['tech_val_pains'] = $this->campaign->getTechValuePains($active_campaign);//by Dev@4489
		$this->_data['templateuser_tech_val_pains'] = $this->campaign->getTuserTechValuePains();//by Dev@4489
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('step-2', $this->_data);
		
	}

	/**
	 * Step 4
	 * Qualifying - Input
	 */
	private function step_3() 
	{
		// $this->output->enable_profiler(TRUE);
		$this->_data['page'] = 3;
		$active_campaign = $this->session->userdata('active_campaign');
		if(!$active_campaign)
		{
			redirect(base_url()."folder/campaigns");
		}
		//by Dev@4489
		//update tech qualify sort order
		if($this->input->post('action') && $this->input->post('action')=="SortOrderupdate")
		{
			$this->campaign->updateTechQOrder($this->input->post('rcid'),$this->input->post('sord'));
			exit;
		}
		////
		
		if($this->input->post('redirect_url'))
		{
			$this->home->add(null, $this->_data['active_session_id']);
			header("location: " . $this->input->post('redirect_url'));
			exit;
		}
		//by Dev@4489
		//save question response
		if($this->input->post('qresponse'))
		{
			$respdata['qid'] = $this->input->post('qid');
			$respdata['qrespid'] = $this->input->post('qrespid');
			$respdata['qpid'] = $this->input->post('qpid');
			$respdata['txtresp1'] = $this->input->post('txtresp1');
			$respdata['txtresp2'] = $this->input->post('txtresp2');
			$this->campaign->saveQuestRespTab($respdata,$active_campaign);
			exit;
		}
		//delete question response
		if($this->input->post('action') && $this->input->post('action')=="deleteResp")
		{
			$this->campaign->deleteQuestResp($active_campaign,$this->input->post('qrid'));
			exit;
		}
		////
		if ($this->input->post('step'))
		{
			/* $this->home->add(Null, $this->_data['active_session_id']);
			$this->home->update_progress_menu($this->_data['active_session_id']);
			*/
			//by Dev@4489
			//Save Extra individual questions
			$tbl_data = $_POST['qtbl'];
			if($tbl_data) $this->productModel->extra_questions($tbl_data,$active_campaign);
			//save qualify question responses
			$tbl_data = $_POST['qrtbl'];
			if($tbl_data) $this->campaign->saveQualifyQuestResps($tbl_data,$active_campaign);
			////
			$this->home->update_progress_menu($active_campaign);
			
			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
			
			if($this->input->post('form_submit') == "Continue")
			{
				redirect(base_url().'step/ideal-sales-process');
			}
		}
		
		$this->_data['tech_qualify_pain'] = $this->campaign->getTechQualifyPain($active_campaign);
		$this->_data['tech_qualify_pain_orph'] = $this->campaign->getTechQualifyPainOrph($active_campaign);
		$this->_data['biz_qualify_pain'] = $this->campaign->getBusQualifyPain($active_campaign);
		$this->_data['biz_qualify_pain_orph'] = $this->campaign->getBusQualifyPainOrph($active_campaign);
		$this->_data['per_qualify_pain'] = $this->campaign->getPerQualifyPain($active_campaign);
		$this->_data['per_qualify_pain_orph'] = $this->campaign->getPerQualifyPainOrph($active_campaign);
	 	$this->_data['tech_qualify_pains'] = $this->campaign->getTechQualifyPains($active_campaign);//by Dev@4489
		$this->_data['templateuser_tech_qualify_pains'] = $this->campaign->getTuserTechQualifyPains();//by Dev@4489
		//by Dev@4489
		//Campaign Qualify Tab extra Individual Questions
		$this->_data['tech_qualify_painsE1'] = $this->campaign->getTechExtraQualifyPains($active_campaign,1);
		$this->_data['tech_qualify_painsE2'] = $this->campaign->getTechExtraQualifyPains($active_campaign,2);
		$this->_data['templateuser_tech_qualify_painsE1'] = $this->campaign->getTuserTechExtraQualifyPains(1);
		$this->_data['templateuser_tech_qualify_painsE2'] = $this->campaign->getTuserTechExtraQualifyPains(2);
		//Tech Qaulify question responses
		$this->load->helper('scripts');//load scripts helper for responses display in edit page
		$this->_data['tech_qualify_responses'] = $this->campaign->getQualifyResponseAnswers($active_campaign);
		$this->_data['templateuser_tech_qualify_responses'] = $this->campaign->getTuserQualifyResponseAnswers();
		$this->_data['tech_qualify_responsesmain'] = $this->campaign->getQualifyResponseAnswers($active_campaign,1);
		$this->_data['templateuser_tech_qualify_responsesmain'] = $this->campaign->getTuserQualifyResponseAnswers(1);
		////
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('step-3', $this->_data);
	}

	/**
	 * Step 3
	 * Ideal Prospect - Input
	 */
	private function step_4() 
	{
		$this->_data['page'] = 4;

		if ($this->input->post('submit'))
		{
			//Insert Step - 4  information into database.
			$this->home->add(NULL, $this->_data['active_session_id']);
			$this->home->update_progress_menu($this->_data['active_session_id']);
			if($this->input->post('submit') == "Save")
			{
				redirect(base_url().'step/ideal-prospect');
			}else {
				redirect(base_url().'step/credibility');
			}
		}
		$this->load->view('step-4', $this->_data);
	}
	
	/**
	 * Step 5
	 * Building Credibility - Input
	 */
	private function step_5() 
	{
	
		// $this->output->enable_profiler(true);
		$this->_data['page'] = 5;
		$is_credibility = $this->home->check_credibility($this->_user_id);

		if(empty($is_credibility))
		{
			// $this->_data['credibility_id'] = $this->home->addCredibility($this->_data['active_session_id']);
			redirect(base_url().'folder/name-drop-examples');
		}
		else 
		{
			$this->_data['credibility_id'] = $this->home->getCredibilityID($this->_user_id);
		}
		
		if ($this->input->post('submit'))
		{	
			//Insert Step - 5  information into database.
			$this->home->add(NULL,$this->_data['active_session_id']);
					
			
			
			$dropnamedata = $this->input->post('dropname');
			$crd_id = $this->input->post('editnamedrop');
			$this->campaign->savecrediblityname($dropnamedata,$crd_id);
			
			if($this->input->post('submit') == "Save")
			{
				// redirect(base_url().'step/credibility');
			}
			else {
				redirect(base_url().'folder/name-drop-examples');
			}
		}
		
		$this->_data['credibilities'] = $this->campaign->get_current_active_credibility($this->_user_id);
		//by Dev@4489
		//Name Drop data
		$this->_data['credibilities_data_names'] = $this->campaign->credibility_data_names();
		$this->_data['credibilities_data'] = $this->campaign->credibility_datas();
		$this->_data['credibilities_data_provided'] = $this->campaign->credibility_datas_provided();
		$this->_data['credibilities_data_when'] = $this->campaign->credibility_datas_when();
		$this->_data['credibilities_data_profile'] = $this->campaign->credibility_data_profiles();
		$this->_data['templateuser_credibilities_data_names'] = $this->campaign->getTusercredibility_data_names();
		$this->_data['templateuser_credibilities_data'] = $this->campaign->getTusercredibility_datas();
		$this->_data['templateuser_credibilities_data_provided'] = $this->campaign->getTusercredibility_datas_provided();
		$this->_data['templateuser_credibilities_data_when'] = $this->campaign->getTusercredibility_datas_when();
		$this->_data['templateuser_credibilities_data_profile'] = $this->campaign->getTusercredibility_data_profiles();
		////
		$this->load->view('step-5', $this->_data);
	}

	/**
	 * Step 6
	 * Building Interest - Input
	 */
	private function step_6() 
	{
	    // $this->output->enable_profiler(true);
		$this->_data['page'] = 6;

		if ($this->input->post('submit'))
		{
			//Insert Step - 6  information into database.
			// $this->home->add(NULL, $this->_data['active_session_id']);
			// $this->home->update_progress_menu($this->_data['active_session_id']);
		
			$this->campaign->SaveCompanyData($this->_data['active_session_id']);
			if($this->input->post('submit') == "Save")
			{
				// redirect(base_url().'step/interest');
			}
			else {
				// redirect(base_url().'step/objections');
				// redirect(base_url().'step/ideal-sales-process');
				redirect(base_url().'folder/company-profiles');	
			}
		}
		
		$this->_data['threats_no_action'] = $this->campaign->findCompanyDataThreadNOAction();
		$this->_data['company_fact'] = $this->campaign->findCompanyDataFact();
		//by Dev@4489
		//Company Interests
		$this->_data['companyInterest_data'] = $this->campaign->getcompany_interests();
		$this->_data['templateuser_companyInterest_data'] = $this->campaign->getTusercompany_interests();
		////
		
		
		$this->load->view('step-6', $this->_data);
	}

	/**
	 * Step 7
	 * Close - Input - Ideal Sales Process
	 */
	private function step_7() 
	{
		$this->_data['page'] = 7;
		$active_campaign = $this->session->userdata('active_campaign');
		
		
		$this->home->update_progress_menu($active_campaign);
		if ($this->input->post('submit'))
		{
			//Insert Step - 7  information into database.
			// $this->home->add(NULL, $this->_data['active_session_id']);

			$tbl_data = $_POST['tbl'];
			$this->productModel->add($tbl_data);
			redirect(base_url().'folder/campaigns');

			if($this->input->post('submit') == "Save")
			{
				// redirect(base_url().'step/ideal-sales-process');
			}
			/*else if($this->input->post('submit') == "Continue"){
				redirect(base_url().'step/custom_content');
			}*/
			else{
				redirect(base_url().'folder/campaigns');
			}
		}
		
		
		$this->_data['sale_process_close1'] = $this->campaign->getCampaignMetadata($active_campaign,'sale_process_close1');
		$this->_data['sale_process_close2'] = $this->campaign->getCampaignMetadata($active_campaign,'sale_process_close2');
		$this->_data['sale_process_close3'] = $this->campaign->getCampaignMetadata($active_campaign,'sale_process_close3');
		//by Dev@4489
		$this->_data['spclose1'] = $this->campaign->getCampaignMetadatas1($active_campaign);
		$this->_data['spclose2'] = $this->campaign->getCampaignMetadatas2($active_campaign);
		$this->_data['spclose3'] = $this->campaign->getCampaignMetadatas3($active_campaign);
		
		$this->_data['templateuser_spclose1'] = $this->campaign->getTuserCampaignMetadatas1();
		$this->_data['templateuser_spclose2'] = $this->campaign->gettTuserCampaignMetadatas2();
		$this->_data['templateuser_spclose3'] = $this->campaign->getTuserCampaignMetadatas3();
		////
		
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		
		$this->load->view('step-7', $this->_data);
	}
	
	/**
	 * Step 8
	 * Objection - Input
	 */
	private function step_8() 
	{
		$this->_data['page'] = 8;

		if ($this->input->post('submit'))
		{
			//Insert Step - 8  information into database.
			$this->home->add(NULL, $this->_data['active_session_id']);

			if($this->input->post('submit') == "Save")
			{
				redirect(base_url().'step/objections');
			}
			else 
			{
				redirect(base_url().'step/ideal-sales-process');
			}
		}

		if (!empty($this->_user_id))
		{
			// Get all Objections from database
			$this->_data['objections'] 	= $this->home->get_all_objections($this->_user_id, $this->_data['active_session_id']);
		}

		$this->load->view('step-8', $this->_data);
	}
        
    /**
	 * Step 9
	 * Ideal Prospect Environment - Input
	 */
	private function step_9()
	{
		$this->_data['page'] = 9;
		if($this->input->post('redirect_url'))
		{
			$this->home->add(null, $this->_data['active_session_id']);
			header("location: " . $this->input->post('redirect_url'));
			exit;
		}

		if($this->input->post('form_submit'))
		{	
			//$this->input->post('redirect_url');
			//Insert Step - 9  information into database.
			$this->home->add(null, $this->_data['active_session_id']);
			$this->home->update_progress_menu($this->_data['active_session_id']);
            
            $this->_data['ideal_prospect_environment'] = $this->home->get_custome_fields($this->_user_id, 'ideal-prospect-environment', $this->_data['active_session_id']);

			if($this->input->post('form_submit') == "Save")
			{
				redirect(base_url().'step/ideal-prospect-environment');
			}
			else 
			{
				redirect(base_url().'step/qualifying');
			}
		}
		$this->load->view('step-9', $this->_data);
	}

	/**
	 * Add Product
	 */

	public function addProduct()
	{
		$data = $this->home->addProduct(NULL, $this->_data['active_session_id']);
		$this->_data['p_id'] = $data['product_id'];
		//echo  $response = json_encode(array('id' => $this->_data['p_id']));
		return TRUE;
	}

	/**
	 * Add Objection
	 */
	public function addObjection() 
	{
		$this->_data['objection_id'] = $this->home->addObjection($this->_data['active_session_id']);
		echo  $response = json_encode(array('id' => $this->_data['objection_id']));
	}

	/**
	 * Add Credibility
	 */

	public function addCredibility() 
	{
		// $this->_data['c_id'] = $this->home->addCredibility($this->_data['active_session_id']);
		$this->_data['c_id'] = $this->campaign->addCredibilityajax($this->_data['credibilities_data']);
		echo  $response = json_encode(array('id' => $this->_data['c_id']));
	}

	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $product_id Parameter_Description
	 *  @param [in] $type Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function add($product_id = NULL,$type = NULL) 
	{
		$id = $this->home->addExtra(NULL);
		if($type = 'T')
		{
			$this->_data['count_tech_qus'] = $this->home->count_tech_qus($product_id);
			//$this->_data['count_tech_qus'] = $this->_data['count_tech_qus'] + 1;
		}
		else 
		{
			$this->_data['count_tech_qus'] = '0';
		}
		if($type = 'B')
		{
			$this->_data['count_bus_qus'] = $this->home->count_bus_qus($product_id);
		}
		else 
		{
			$this->_data['count_bus_qus'] = '0';
		}
		if($type = 'P')
		{
			$this->_data['count_pers_qus'] = $this->home->count_pers_qus($product_id);
		}
		else 
		{
			$this->_data['count_pers_qus'] = '0';
		}

		echo  $response = json_encode(array('id' => $id, 'tech_count' => $this->_data['count_tech_qus'], 'bus_count' => $this->_data['count_bus_qus'], 'pers_count' => $this->_data['count_pers_qus']));
	}

	/**
	 *  @brief Brief
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function addPain() 
	{
		$checkValues	=	$this->home->checkValues($_POST['p_id'],$_POST['type']);
		$getValue = NULL;

		if($_POST['type'] == 'T')
		{
			if($checkValues == '0')
			{
				$value = $this->home->getPainValues($_POST['p_id'],$_POST['type']);
				$value	= $value->value;
				$getValue	=	isset($value) ? $value : 'Added Technical Pain';
			}
			else 
			{
				$getValue = 'Added Technical Pain';
			}
		}
                
                
		if($_POST['type'] == 'B')
		{
			if($checkValues == '0')
			{
				$value = $this->home->getPainValues($_POST['p_id'],$_POST['type']);
				$value	= $value->value;
				$getValue	=	isset($value) ? $value : 'Added Business Pain';
				$static_value = '';
			}
			else 
			{
				$getValue = 'Added Business Pain';
			}
		}

		if($_POST['type'] == 'P')
		{
			if($checkValues == '0'  AND $_POST['type'] == 'P')
			{
				$value = $this->home->getPainValues($_POST['p_id'],$_POST['type']);
				$value	= $value->value;
				$getValue	=	isset($value) ? $value : 'Added Personal Pain';
			}
			else 
			{
				$getValue = 'Added Personal Pain';
			}
		}
		$data = $this->home->addExtraPain(NULL);
		echo  $response = json_encode(array('id' => $data['id'], 'd_id' => $data['d_id'], 'first_value' => $getValue, 'total_q' => $checkValues));
	}

	/**
	 *  Add qualify function
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function addQualify() 
	{
		$data = $this->home->addExtraQualify(NULL);
		echo  $response = json_encode(array('id' => $data['id'], 'd_id' => $data['d_id']));
	}


	/**
	 * Delete Product
	 * @param $product_id integer
	 */

	public function delete_product($product_id) 
	{
		$this->home->deleteProduct($product_id);
		redirect('/home/', 'refresh');
	}

	/**
	 * Delete Credibility
	 * @param $credibility_id integer
	 */

	public function delete_credibility() 
	{
		$credibility_id = $_POST['c_id'];
		$this->home->deleteCredibility($credibility_id);
		return TRUE;
	}

	/**
	 * Delete Additional Question
	 * @param integer $qus_id
	 * @param string $step
	 */
	public function delete_single_ques() 
	{
		$qus_id = $_GET['qus_id'];
		$step = $_GET['step'];
		// $step = $_GET['step'];
		$this->home->deleteQus($qus_id);
		redirect(base_url().'step/' . $step);
	}
	
	/**
	 * Delete Additional Question
	 * @param integer $qus_id
	 * @param string $step
	 */
	public function delete_ques() 
	{
		$qus_id = $_GET['qus_id'];
		$detail_id = $_GET['detail_id'];
		$step = $_GET['step'];
		$this->home->deleteQusPQ($qus_id, $detail_id);
		redirect(base_url().'step/' . $step);
		//return TRUE;
	}

	/**
	 * Update SESSION
	 */
	public function updateSession() 
	{
		$data = array('user_id' => $this->_user_id, 'session_name' => $_POST['session_name'], 'status' => '1');
		$session_id = $this->home->update_session($data);
		echo json_encode(array("success"=>"ok"));
	}

	/********************************************* This section added by Developer - A ************************************************/
	/**
	 * Step 99
	 * Close - Input - Custom Input
	 */
	private function step_99() 
	{
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		$this->_data['page'] = 99;
		//By Dev@4489
		$active_campaign = $this->_data['campaign_info']->campaign_id;
		////
		if($_POST['action_dev'] == 'delete')
		{
			if($this->campaign->deleteCampaignCustomdata($active_campaign, $_POST['id_dev']))
			{
				echo '1';
			}
			else echo '0'; 
			exit;
		}
		$etemplate = $this->campaign->get_etemplate(0,$active_campaign);
		$this->_data['template_user'] = $etemplate;
		/*if ($this->input->post('submit'))
		{
			//Insert Step - 7  information into database.
			// $this->home->add(NULL, $this->_data['active_session_id']);

			$tbl_data = $_POST['cstm'];
			$this->home->update_progress_menu($active_campaign);
			$this->campaign->updateCustomContent($tbl_data, $active_campaign);
			redirect(base_url().'folder/my-folder');

			//if($this->input->post('submit') == "Save")
//			{
//				// redirect(base_url().'step/ideal-sales-process');
//			}
//			else {
//				redirect(base_url().'folder/my-folder');
//			}
		}*/
		//By Dev@4489
		if ($this->input->post('submit') || $this->input->post('form_submit') || $this->input->post('submit_done'))
		{
			//Insert Step - 7  information into database.
			// $this->home->add(NULL, $this->_data['active_session_id']);
			$er="";
			if(!$active_campaign && !strlen(trim($_POST['campaignid']))) $er .="Select Campaign";
			
			if(!$er) {

				$tbl_data = $_POST['cstm'];
				//update campaign profile name
				$ecgid=$active_campaign;
				if($_POST['campaignid']) $ecgid=(int)$_POST['campaignid'];
				$this->home->update_progress_menu($ecgid);
				$this->campaign->updateCustomContent($tbl_data, $ecgid,$etemplate);
				if($this->input->post('submit_done')) redirect(base_url().'folder/sales-scripts');
				else redirect(base_url().'step/custom_content');
			} else $this->_data['err'] = $er;
		}
		////
		
		
		//By Dev@4489
		if($active_campaign) {
			$this->_data['customTemplateInfo'] = $this->campaign->getCampaignCustomdata($active_campaign);
		}
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['drop_company'] = $this->campaign->get_drop_company();
		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();
		$this->_data['ecampaign_id'] = $active_campaign;		
		//$this->_data['customTemplateInfo'] = $this->campaign->getCampaignCustomdata($active_campaign);
		//$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		////		
		$this->load->view('step-99', $this->_data);
	}
	
	/******************************************************************************************************************************/
	/**
	 *  Create New Session
	 *  
	 *  @param [in] $redirect Parameter_Description
	 *  @param [in] $session_status Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function newSession($redirect=NULL, $session_status = 2, $session_name = 'default') 
	{

		$get_draft_sessions = $this->home->get_draft_sessions($this->_user_id);
		if(!empty($get_draft_sessions))
		{
			foreach ($get_draft_sessions as $draft_id)
			{
				$this->home->deleteDraftSessions($draft_id->session_id);
			}
		}

		if(!$redirect)
		{
			$this->_data['credibilities'] 	= $this->home->get_all_credibilities($this->_user_id, $this->session->userdata('ss_session_id'));
			
			$this->_data['objections'] 		= $this->home->get_all_objections($this->_user_id, $this->session->userdata('ss_session_id'));
			$this->_data['target'] 	= $this->home->get_custome_fields($this->_user_id, 'target', $this->_data['active_session_id']);

			$this->_data['custome_fields'] 	= $this->home->get_custome_fields($this->_user_id, 'users', $this->_data['active_session_id']);

	        $this->_data['summary'] 	= $this->home->get_custome_fields($this->_user_id, 'summary', $this->_data['active_session_id']);

	        $this->_data['interes'] 	= $this->home->get_custome_fields($this->_user_id, 'interest', $this->_data['active_session_id']);

	        $this->_data['sales_process'] 	= $this->home->get_custome_fields($this->_user_id, 'sales-process', $this->_data['active_session_id']);

	        $this->_data['interestB1'] 	= $this->home->get_custome_fields($this->_user_id, 'interestB1', $this->_data['active_session_id']);

	        $this->_data['interestB2'] 	= $this->home->get_custome_fields($this->_user_id, 'interestB2', $this->_data['active_session_id']);

			// Deactive all sessions
			$all_sessions = $this->home->get_all_sessions();
		}
		/* var_dump($this->_data); 
		die('abcfff'); */
		
		if(!empty($all_sessions))
		{
			foreach ($all_sessions as $id)
			{
				$this->home->update_all_sessions($id->session_id, $status = '0');
			}
		}

		//echo '<pre>'; print_r($this->_data['credibilities']);exit();

		// UnSET last Session
		$this->session->unset_userdata('ss_session_id');

		// Add Product
		$data = $this->home->addProduct($session_status, NULL, $session_name);

		// Product ID
		$this->_data['product_id'] = $data['product_id'];

		// Set session_id into SESSION
		$this->session->set_userdata('ss_session_id', $data['session_id']);
		

		if(!empty($this->_data['target']))
		{
			$this->home->addData($this->_data['target'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'target';
			$target = array();
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[target geography]";
			$target[0] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[smallest prospect]";
			$target[1] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[largest prospect]";
			$target[2] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[target industries]";
			$target[3] = $obj;
			
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[excluded industries]";
			$target[4] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[target department]";
			$target[5] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[target department]";
			$target[6] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[target title]";
			$target[7] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[target title]";
			$target[8] = $obj;

			$this->home->addData($target, $this->session->userdata('ss_session_id'));
		}

		if(!empty($this->_data['custome_fields']))
		{
			$this->home->addData($this->_data['custome_fields'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'users';
			$custome_fields = array();

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[my product]";
			$custome_fields[0] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "businesses";
			$custome_fields[1] = $obj;
			$this->home->addData($custome_fields, $this->session->userdata('ss_session_id'));
		}

		if(!empty($this->_data['summary']))
		{
			$this->home->addData($this->_data['summary'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'summary';
			$summary = array();
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[technical value 1]";
			$summary[0] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[business value 1]";
			$summary[1] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[personal value 1]";
			$summary[2] = $obj;
			
			$this->home->addData($summary, $this->session->userdata('ss_session_id'));
		}

		/* if(!empty($this->_data['interes']))
		{
			$this->home->addData($this->_data['interes'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'interest';
			$interest = array();

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[company fact 1]";
			$interest[0] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[company fact 2]";
			$interest[1] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[company fact 3]";
			$interest[2] = $obj;
			
			$this->home->addData($interest, $this->session->userdata('ss_session_id'));
		} */

		if(!empty($this->_data['sales_process']))
		{
			$this->home->addData($this->_data['sales_process'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'close';
			$sales_process = array();
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "brief 15 to 20 minute meeting";
			$sales_process[0] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "discuss your goals and challenges and share any value and insight that we have to offer";
			$sales_process[1] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "get email address and send email with information";
			$sales_process[2] = $obj;

			$this->home->addData($sales_process, $this->session->userdata('ss_session_id'));
		}

		if(!empty($this->_data['interestB1']))
		{
			$this->home->addData($this->_data['interestB1'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'interestB1';
			$interestB1 = array();
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[differentiation point 1]";
			$interestB1[0] = $obj;
			
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[differentiation point 2]";
			$interestB1[1] = $obj;
			
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[differentiation point 3]";
			$interestB1[2] = $obj;

			$this->home->addData($interestB1, $this->session->userdata('ss_session_id'));
		}

		/* if(!empty($this->_data['interestB2']))
		{
			$this->home->addData($this->_data['interestB2'], $this->session->userdata('ss_session_id'));
		}
		else
		{
			$field_type = 'interestB2';
			$interestB2 = array();
			
			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[impact of doing nothing 1]";
			$interestB2[0] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[impact of doing nothing 1]";
			$interestB2[1] = $obj;

			$obj = new stdClass();
			$obj->field_type = $field_type;
			$obj->value = "[impact of doing nothing 1]";
			$interestB2[2] = $obj;

			$this->home->addData($interestB2, $this->session->userdata('ss_session_id'));
		} */

		/* if(!empty($this->_data['credibilities']))
		{
			foreach ($this->_data['credibilities'] as $credibility)
			{
				$data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');

				$credibility_id = $this->home->addCredibility($this->session->userdata('ss_session_id'));

				if($data)
				{
					foreach ($data as $key=>$value)
					{
						$user_data = array('c_id' => $credibility_id, 'field_type' => $key, 'value' => $value['value']);

						$this->home->addSessionCredibility($user_data);
					}
				}
				else 
				{
					// Add default Credibility Values

					$user_data[0] = array('c_id' => $credibility_id, 'field_type' => "customer", 'value' => "[past or current client]");

					$user_data[1] = array('c_id' => $credibility_id, 'field_type' => "worked", 'value' => "[service provided]");

					$user_data[2] = array('c_id' => $credibility_id, 'field_type' => "provided", 'value' => "[technical improvement]");

					$user_data[3] = array('c_id' => $credibility_id, 'field_type' => "when", 'value' => "[business improvement]");

					foreach($user_data as $user_data_child) {
						$this->home->addSessionCredibility($user_data_child);
					}
				}
			}
		}
		else 
		{
			$credibility_id = $this->home->addCredibility($this->session->userdata('ss_session_id'));
			// Add default Credibility Values
			$user_data[0] = array('c_id' => $credibility_id, 'field_type' => "customer", 'value' => "[past or current client]");
			$user_data[1] = array('c_id' => $credibility_id, 'field_type' => "worked", 'value' => "[service provided]");
			$user_data[2] = array('c_id' => $credibility_id, 'field_type' => "provided", 'value' => "[technical improvement]");
			$user_data[3] = array('c_id' => $credibility_id, 'field_type' => "when", 'value' => "[business improvement]");
			foreach($user_data as $user_data_child) {
				$this->home->addSessionCredibility($user_data_child);
			}
		} */

		if(!empty($this->_data['objections']))
		{
			foreach ($this->_data['objections'] as $objection)
			{
				$data = $this->home->get_meta_data($objection->obj_id, 'objection', 'tod');
				$objection_id = $this->home->addObjection($this->session->userdata('ss_session_id'));
				foreach ($data as $key=>$value)
				{
					$user_data = array('obj_id' => $objection_id, 'field_type' => $key, 'value' => $value['value']);
					$this->home->addSessionObjection($user_data);
				}
			}
		}
		if(!$redirect)
		{
			$redirect = base_url().'step/product';
		}
		$this->session->set_flashdata('session_msg', 'New Session Has been created');
		redirect($redirect);
		exit();
	}

	/**
	 * Delete Session 
	 * @param $credibility_id integer
	 */
	public function launch_session() 
	{
		$product_id = $_POST['session_id'];
		$t_m_session = $_POST['t_m_session'];
		$this->session->set_userdata('edit_product',$product_id);
		echo true;
	}

	/**
	 * Delete Session 
	 * @param $credibility_id integer
	 */
	public function delete_session() 
	{
		$session_id = $_POST['session_id'];
		$status = $_POST['status'];
		if($status == '1')
		{
			// UnSET last Session
			$this->session->unset_userdata('ss_session_id');
		}
		// $this->home->deleteSession($session_id);
		$result = $this->productModel->deleteProduct($session_id);
		if($result){
		    echo 1;
		}else{
			echo 0 ;
		}
	}

	/**
	 * Search for a Team Member Page 
	 * @param $credibility_id integer
	 */
	public function team_member() 
	{
		$this->_data['page'] = 15;
		if($this->input->post('submit'))
		{
			$search_name 				= $this->input->post('search_name');
			$this->_data['user_data']	= $this->home->searchUser($search_name);			
		}

		//$this->load->view('search-for-team-member', $this->_data);
		// Redirect to Member Searching Page
		redirect(base_url().'folder/team-folder');
	}

	/**
	 * User Management Page 
	 */
	public function user_management() 
	{
		$this->_data['page'] = 16;
		$this->_data['all_requests'] = $this->home->getAllRequests($this->_user_id, 'sender');
		$this->_data['all_receiver_requests'] = $this->home->getAllReceiverRequests($this->_user_id);
		// Redirect to Member Searching Page
		redirect(base_url().'folder/team-folder');
	}

	/**
	 * User Send Invitation 
	 */
	public function send_invitation($receiver_id) 
	{
		$receiver_exist = $this->home->alreadyExist($receiver_id,$this->_user_id);
		if(!isset($receiver_exist))
		{
			$data = array('sender_id' => $this->_user_id, 'receiver_id'=> $receiver_id, 'status' => '0');
			$this->home->addUser($data);
			$this->session->set_flashdata('msg', 'Your invitation request has been sent!.');
		}
		else 
		{
			$this->session->set_flashdata('msg', 'User Already Exist.');
		}

		// Redirect to Member Searching Page
		redirect(base_url().'folder/team-folder');
	}

    /**
	 * User Send Invitation 
	 */
	public function share_template($TemplateId) 
	{
		$GetTemplate = $this->home->GetTemplate($TemplateId);
		if(!empty($GetTemplate))
		{
				$this->_data['TemplateData'] = $GetTemplate;
		}
		
		if($this->input->post('submit'))
		{
				$search_name = $this->input->post('search_name');

				$this->_data['user_data'] = $this->home->searchUser($search_name);

				if(empty($this->_data['user_data']))
				{
						$this->_data['message'] = 'Not able to find user';
				}
		}
                
        // Redirect to Member Searching Page
		$this->_data['page'] = '';
		$this->_data['d_page'] = 19;
        $this->load->view('share_template', $this->_data);
	}
    
	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $TemplateId Parameter_Description
	 *  @param [in] $receiver_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function sharewithuser($TemplateId,$receiver_id) 
	{
		$receiver_exist = $this->home->alreadyExist($receiver_id);
		if(!isset($receiver_exist))
		{
			$data = array('sender_id' => $this->_user_id, 'receiver_id'=> $receiver_id, 'status' => '0');
			$this->home->addUser($data);
			$this->session->set_flashdata('msg', 'Invitation Request has been sent.');
		}else 
		{
			$this->session->set_flashdata('msg', 'User Already Exist.');
		}
		// Redirect to Member Searching Page
		redirect(base_url().'folder/team-folder');
        $this->load->view('share_template', $this->_data);
	}
                
	/**
	 * Delete Friend Request 
	 * @param $frnd_id integer
	 */
    /*
	public function delete_frnd_request() 
	{
		$frnd_id = $this->input->post('frnd_id');
		$action = $this->input->post('action');
		$this->home->deleteFrndRequest($frnd_id, $action);
		return TRUE;
	} */
    
    /**
     *  @brief Brief
     *  
     *  @return Return_Description
     *  
     *  @details Details
     */
    public function delete_frnd_request() 
	{
		$frnd_id = $this->input->post('frnd_id');
		$action = $this->input->post('action');
        $sender_id = $this->input->post('sender_id');
		$team_session_id = $this->input->post('team_session_id');
		$this->home->deleteFrndRequest($frnd_id, $action,$sender_id,$team_session_id);
		return TRUE;
	}

	/**
	 * Delete Session 
	 * @param $credibility_id integer
	 */

	public function invitation_accept() 
	{
		$invitaion_user_id = $this->input->post('invitation_user_id');
		$this->home->invitaionAccept($invitaion_user_id);
	}	

	/**
	 * Create New Session
	 */
	public function saveToMyFolder() 
	{
		$seesion_id = $this->input->post('session_id');
		$user_id	= $this->input->post('user_id');
		
		$this->_data['credibilities'] 	= $this->home->get_all_credibilities($user_id, $seesion_id);
		$this->_data['objections'] 		= $this->home->get_all_objections($user_id, $seesion_id);

		//echo '<pre>'; print_r($this->_data['credibilities']); exit();

		$this->_data['target'] 	= $this->home->get_custome_fields($user_id, 'target', $seesion_id);
		$this->_data['custome_fields'] 	= $this->home->get_custome_fields($user_id, 'users', $seesion_id);

        $this->_data['summary'] 	= $this->home->get_custome_fields($user_id, 'summary', $seesion_id);
        $this->_data['interes'] 	= $this->home->get_custome_fields($user_id, 'interest', $seesion_id);
        $this->_data['sales_process'] 	= $this->home->get_custome_fields($user_id, 'sales-process', $seesion_id);
        $this->_data['interestB1'] 	= $this->home->get_custome_fields($user_id, 'interestB1', $seesion_id);
        $this->_data['interestB2'] 	= $this->home->get_custome_fields($user_id, 'interestB2', $seesion_id);
        $session_all_info =  $this->campaign->GetActiveSessionrecord($seesion_id);		
		$session_data = array('user_id' => $_SESSION['ss_user_id'], 'session_name' => $this->input->post('session_name'), 'status' => '0','progress_data' => $session_all_info->progress_data);
        $my_session_id = $this->home->add_own_session($session_data);
		$my_campaignname = $this->campaign->changeCampaignName($seesion_id);
        $get_all_products 	= $this->home->get_products_by_sessionId($seesion_id);

		foreach ($get_all_products as $products)
		{
			$data = array('user_id'=>$this->_user_id, 'session_id'=>$my_session_id,'campaign_name' => $my_campaignname->campaign_name);
			$product_id = $this->home->add_own_products($data);
			$get_all_products_data = $this->home->get_all_product_data($products->product_id);

			foreach ($get_all_products_data as $products_data)
			{
				$product_data = array('product_id' => $product_id, 'field_type' => $products_data->field_type, 'value' => $products_data->value,'question_id' => $products_data->question_id,'Qus_status' => $products_data->Qus_status);
				$this->home->add_own_products_data($product_data);	
			}
		}

		if(!empty($this->_data['target']))
		{
			$this->home->addData($this->_data['target'], $my_session_id);
		}

		if(!empty($this->_data['custome_fields']))
		{
			$this->home->addData($this->_data['custome_fields'], $my_session_id);
		}

		if(!empty($this->_data['summary']))
		{
			$this->home->addData($this->_data['summary'], $my_session_id);
		}

		if(!empty($this->_data['interes']))
		{
			$this->home->addData($this->_data['interes'], $my_session_id);
		}

		if(!empty($this->_data['sales_process']))
		{
			$this->home->addData($this->_data['sales_process'], $my_session_id);
		}

		if(!empty($this->_data['interestB1']))
		{
			$this->home->addData($this->_data['interestB1'], $my_session_id);
		}

		if(!empty($this->_data['interestB2']))
		{
			$this->home->addData($this->_data['interestB2'], $my_session_id);
		}

		if(!empty($this->_data['credibilities']))
		{
			foreach ($this->_data['credibilities'] as $credibility)
			{
				$data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');
				$credibility_id = $this->home->addCredibility($my_session_id);

				foreach ($data as $key=>$value)
				{
					$user_data = array('c_id' => $credibility_id, 'field_type' => $key, 'value' => $value['value']);
					$this->home->addSessionCredibility($user_data);
				}	
			}
		}

		if(!empty($this->_data['objections']))
		{
			foreach ($this->_data['objections'] as $objection)
			{
				$data = $this->home->get_meta_data($objection->obj_id, 'objection', 'tod');
				$objection_id = $this->home->addObjection($my_session_id);

				foreach ($data as $key=>$value)
				{
					$user_data = array('obj_id' => $objection_id, 'field_type' => $key, 'value' => $value['value']);
					$this->home->addSessionObjection($user_data);
				}
			}
		}
		$this->session->set_flashdata('session_msg', 'Team Member Session has been saved into My Folder');
		exit();
	}

	
	/**
	 * Create User can copay friend product lits in his own folder
	 */
	public function copyProductToMyFolder() 
	{
		$product_id = $this->input->post('product_id');
		$user_id	= $this->input->post('user_id');
        $get_all_products 	= $this->home->get_products_by_sessionId($product_id);
        
		if(!empty($get_all_products )){
		
			$getProductsAllMetadata  = $this->productModel->getProductinfo($product_id);
			$data = array('user_id'=> $this->_user_id, 'product_name'=> $get_all_products[0]->product_name);
			$product_id = $this->home->add_own_products($data);
			foreach ($getProductsAllMetadata  as $products_data)
			{
				$product_data = array('product_id' => $product_id, 'field_type' => $products_data->field_type, 'value' => $products_data->value,'question_id' => $products_data->question_id,'Qus_status' => $products_data->Qus_status);
				$this->home->add_own_products_data($product_data);	
			}
			
			$this->session->set_flashdata('session_msg', 'Team Member Session has been saved into My Folder');
			exit();
		}else{
			$this->session->set_flashdata('session_msg', 'There are something happen wrong please contact to administrator');
			exit();
		}
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
     *  
     *  @return Return_Description
     *  
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
	
	/**
	 *  Prebuilt Campaigns page
	 *  
	 *  @return Return_Description
	 */
	public function prebuilt_campaigns()
	{		
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		$d_page_name = 46;	
		//$tlibuser=3445;
		if(isset($_GET['insurance'])) {
			$tb_insurance = 1;
			$tlibuser=4045;
		} else {
			$tb_insurance = 0;
			$tlibuser=3445;
		}
		$this->_data['tb_insurance'] = $tb_insurance;
		
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
		$this->_data['teammateid'] = $tlibuser ;
		$this->_data['cuserid'] = $this->_user_id ;
		
		$this->_data['d_page'] = $d_page_name;
	    $this->load->view('prebuilt_campaign', $this->_data);
	}
	//By Dev@4489
	/**
	 * Step 98
	 * Campaign - Input - Objection
	 */
	private function step_98() 
	{
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		$this->_data['page'] = 14;
		$active_campaign = $this->_data['campaign_info']->campaign_id;
		if($_POST['action_dev'] == 'delete' && $active_campaign)
		{
			if($this->campaign->deleteCampaignObjection($active_campaign, $_POST['id_dev']))
			{
				echo '1';
			}
			else echo '0'; 
			exit;
		}
		if(!is_numeric($active_campaign)) redirect(base_url().'folder/my-folder');
		
		if ($this->input->post('submit'))
		{			
			$er="";			
			if(!$er) {
				$tbl_data = $_POST['cstm'];
				//update campaign objections
				$ecgid=$active_campaign;
				//echo "<pre>";print_r($tbl_data);echo "</pre>";
				$this->campaign->updateCampaignObjections($tbl_data, $ecgid);
				redirect(base_url().'step/objection');
			} else $this->_data['err'] = $er;
		}
		
		$active_campaign_data =  $this->campaign->getCampaignData($active_campaign);
		//Qualify questions with responses
		$campaign_output_qualify = $this->qualify_list_show($active_campaign_data->campaign_id);
		$this->_data['campaign_output_qualify'] = $campaign_output_qualify;
		////
		$campaign_output_tech_val = $this->campaign->getOutputTechValue($active_campaign);		
		$this->_data['campaign_output_tech_val'] = $campaign_output_tech_val;
		$campaign_tech_summary = $this->campaign->getCampaignMetadata($active_campaign,'tech_val_summary');
		$this->_data['campaign_tech_summary'] = $campaign_tech_summary;
		$campaign_output_tech_qualify = $this->campaign->getOutputTechQualify($active_campaign);
		$this->_data['campaign_output_tech_qualify'] = $campaign_output_tech_qualify;
		$campaign_output_tech_pain = $this->campaign->getOutputTechPain($active_campaign);
		$this->_data['campaign_output_tech_pain'] = $campaign_output_tech_pain;
		$company_meta = $this->productModel->getAllMetaValue($active_campaign);
		$this->_data['company_meta'] = $company_meta;
		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);
		$this->_data['company_info'] = $company_info_detail;
		
		$this->_data['campaign_info'] = $active_campaign_data;
		$this->_data['objectionInfo'] = $this->campaign->getCampaignObjections($active_campaign);
		$this->_data['ecampaign_id'] = $active_campaign;
		//Objection data with responses
		$lastid = 0;
		$objedit=1;
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
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['drop_company'] = $this->campaign->get_drop_company();
		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();
		
		$this->load->view('step-98', $this->_data);
	}
	////
	//By Dev@4489
	/**
	 *  Question Tree page
	 *  
	 *  @return array
	 */
	//public function question_trees()
	public function question_trees_deleted()
	{return;
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		$active_campaign = $this->_data['campaign_info']->campaign_id;
		//update question order
		if($this->input->post('action') && $this->input->post('action')=="qaulifyupdate")
		{
			$this->campaign->updateQuestOrder($this->input->post('qid'),$this->input->post('qo'));
			exit;
		}
		//delete question response
		if($this->input->post('action') && $this->input->post('action')=="deleteResp")
		{
			$this->campaign->deleteQuestResp($active_campaign,$this->input->post('qrid'));
			exit;
		}
		//save question response
		if($this->input->post('txtresp') && $this->input->post('qid'))
		{
			$respdata['qid'] = $this->input->post('qid');
			$respdata['qrespid'] = $this->input->post('qrespid');
			$respdata['qpid'] = $this->input->post('qpid');
			$respdata['txtresp'] = $this->input->post('txtresp');			
			$this->campaign->saveQuestResp($respdata,$active_campaign);
			exit;
		}
		//delete question
		if($this->input->post('qRmid'))
		{
			$this->campaign->deleteQualifyQuest($this->input->post('qRmid'),$active_campaign);
			redirect(base_url().'folder/question-trees');
		}
		//add question		
		if($this->input->post('qedit'))
		{
			$this->_data['eqid']=$this->input->post('eqid');
			if($this->input->post('eqid') && $this->input->post('qedit')=="E") {
				$quest_row = $this->campaign->getQualifyQuestRow($this->input->post('eqid'),$active_campaign);
				if($quest_row) {
					$quest_row = $quest_row[0];
					$this->_data['txtquest']=$quest_row->value;
					$this->_data['txtorder']=$quest_row->qus_id;				
				}
			} else if($this->input->post('qsave')) {
				$this->_data['txtquest']=$this->input->post('txtquest');
				$this->_data['txtorder']=$this->input->post('txtorder');
				$edata = array('qt'=>$this->input->post('txtquest'),'od'=>$this->input->post('txtorder'),'eid'=>(int)$this->_data['eqid']);
				$this->campaign->saveQualifyQuest($edata,$active_campaign);
				redirect(base_url().'folder/question-trees');
			}
			$this->_data['quest_add']=1;
		}
		//active campaign
		if($this->input->post('campgnid'))
		{
			//$this->session->set_userdata('active_campaign',$this->input->post('campgnid'));
			//$this->productModel->edit_campaign($this->input->post('campgnid'));
			$this->campaign->incativeAllCampaign();
			$this->campaign->activeSingleCampaign($this->input->post('campgnid'));
			$this->session->set_userdata('ss_session_id',$this->input->post('campgnid'));
			redirect(base_url().'folder/question-trees');
		}
		//$qid = $this->uri->segment(3);
		//select follow up response
		$this->_data['qnext']=0;
		if($this->input->post('qid'))
		{
			$qid=$this->input->post('qid');
			$quest_row = $this->campaign->getQualifyQuestRow($qid,$active_campaign);
			$this->_data['quest_row'] = $quest_row;
			$quest_responses = $this->campaign->getQualifyQuestResps($qid,$active_campaign);
			ob_start();
			if($quest_responses && $quest_row) {$quest_row = $quest_row[0];
				$n=0;$n1=0;$level=1;
			?>               
				<?php
                    foreach($quest_responses as $qresp) {$n1++;
                        $qresponses = $this->campaign->getQualifyQuestResps($quest_row->tech_q_id,$quest_row->campaign_id,$qresp->qr_id);
                ?>  
                <div class="quest-resp">
                    <div align="center"><b>Prospect Response</b></div>
                    <div class="divfrm">
                        Enter a possible answer that the prospect might give to this question                            
                         <br />
                        <span class="TextColor rsprootNO"><?php echo $quest_row->value;?></span>                    
                    </div>
                    <form method="post" class="frm_resp">
                        <input type="hidden" name="qid" id="qid" value="<?php echo $quest_row->tech_q_id; ?>" />
                        <input type="hidden" name="qrespid" id="qrespid" value="<?php echo $qresp->qr_id; ?>" />
                        <input type="hidden" name="qpid" id="qpid" value="<?php echo $qresp->qr_parent; ?>" />
                        <textarea name="txtresp" class="txtresp" placeholder="Enter prospect response" style="margin-top:2px;margin-bottom:2px;"><?php echo $qresp->qr_response; ?></textarea><br />
                        <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                        <input type="button" class="buttonM bBlue bsave" value="Update" onclick="saveresp(<?php echo $level; ?>,this);" />&nbsp;
                        <?php /*?><input type="button" class="buttonM bBlue bapresp" value="Add a Prospect Response" onclick="addpresp(<?php echo $level; ?>,this);" style="margin-top: 2px; display:none;" /><?php */?>
                        <input type="button" class="buttonM bBlue baresp" value="Add a Sales Response" onclick="addresp(<?php echo $level; ?>,this);" style="margin-top: 2px;" />
                        <input type="button" class="buttonM bRed bdel" value="Delete" onclick="delresp(<?php echo $level; ?>,this);" style="margin-top: 2px;" />
                    </form><br clear="all" /><hr style="margin:4px;" />
                    <div id="dqresp<?php echo $qresp->qr_id; ?>"><?php if($qresponses) $this->qtree_response($level+1,$quest_row->tech_q_id,$quest_row->campaign_id,$qresp->qr_id,$qresp->qr_response,$qresponses);?></div>
                </div>
                <?php }?>
			<?php }
			$Question_responses=ob_get_contents();
			ob_end_clean();
			$this->_data['quest_responses'] = $Question_responses;
			if(!$this->_data['quest_row']) redirect(base_url().'folder/question-trees');
			$questNext_row = $this->campaign->getQualifyQuestNext($active_campaign,$this->input->post('qid'));
			if($questNext_row) {
				foreach($questNext_row as $qnrow) $this->_data['qnext']=$qnrow->tech_q_id;
			}
		}
				
		/*if($this->input->post('submit'))
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
		}*/
                        
		/**  find all records for drop down **/
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['actCampaign'] = $active_campaign;
		$this->_data['quest_tree'] = $this->campaign->getQualifyQuest($active_campaign);
		$this->_data['d_page'] = "qtree";
		/* print_r($this->_data);		
		die(); *//*error_reporting(E_ALL);
ini_set("display_errors", 1);*/
	    $this->load->view('question-trees', $this->_data);
	}
	//Get Question Responses
	public function qtree_response($level,$q_id,$Qcampid,$qrparent,$qresp_text,$quest_responses) {
		?>
        <div style="padding:4px; vertical-align:bottom;" id="rspsbox<?php echo $qrparent; ?>">
			<?php 
                if($quest_responses) {	$n1=0;
            ?>
				<?php 
                    foreach($quest_responses as $qresp) {$n1++;
                        $qresponses = $this->campaign->getQualifyQuestResps($q_id,$Qcampid,$qresp->qr_id);
                ?>
                <div class="quest-resp">
                    <div align="center"><b><?php echo ($level%2==0?'Sales Response':'Prospect Response');?></b></div>
                    <div class="divfrm">
                    	<?php echo ($level%2==0?'Enter a good response or question that you can say if the prospect has the response below':'Enter a possible answer that the prospect might give to this question');?>
                         <br />
                        <span class="TextColor rsproot<?php echo $qrparent; ?>"><?php echo $qresp_text;?></span>
                    </div>
                    <form method="post" class="frm_resp">
                        <input type="hidden" name="qid" id="qid" value="<?php echo $q_id; ?>" />
                        <input type="hidden" name="qrespid" id="qrespid" value="<?php echo $qresp->qr_id; ?>" />
                        <input type="hidden" name="qpid" id="qpid" value="<?php echo $qresp->qr_parent; ?>" />
                        <textarea name="txtresp" class="txtresp" placeholder="<?php echo ($n1==1?'Enter sales response':'enter prospect Response');?>" style="margin-top:2px;margin-bottom:2px;"><?php echo $qresp->qr_response; ?></textarea><br />
                        <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                        <input type="button" class="buttonM bBlue bsave" value="Update" onclick="saveresp(<?php echo $level; ?>,this);" />&nbsp;
                        
                        <?php /*?><input type="button" class="buttonM bBlue bapresp" value="Add a Prospect Response" onclick="addpresp(<?php echo $level; ?>,this);" style="margin-top: 2px;" /><?php */?>                            
                        <input type="button" class="buttonM bBlue baresp" value="<?php echo ($level%2==0?'Add a Prospect Response':'Add a Sales Response');?>" onclick="addresp(<?php echo $level; ?>,this);" style="margin-top: 2px;<?php //if($qresponses || $n1==1) echo 'display:none;';?>" />  
                        <input type="button" class="buttonM bRed bdel" value="Delete" onclick="delresp(<?php echo $level; ?>,this);" style="margin-top: 2px;" />                          
                    </form><br clear="all" /><hr style="margin:4px;" />
                    <div id="dqresp<?php echo $qresp->qr_id; ?>"><?php if($qresponses) $this->qtree_response($level+1,$q_id,$Qcampid,$qresp->qr_id,$qresp->qr_response,$qresponses);?></div>
                </div>
                <?php }?>     
            <?php }/*else{?>
            <?php //if($level<3){?>
            <div class="quest-resp">
                <div>
                    <form method="post" class="frm_resp">
                        <input type="hidden" name="qid" id="qid" value="<?php echo $q_id; ?>" />
                        <input type="hidden" name="qrespid" id="qrespid" value="0" />
                        <input type="hidden" name="qpid" id="qpid" value="<?php echo $qrparent; ?>" />
                        <textarea name="txtresp" class="txtresp" placeholder="Enter response" style="margin-top:2px;margin-bottom:2px;width:700px;"></textarea><br />
                        <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                        <input type="button" class="buttonM bBlue bsave" value="Save" onclick="saveresp(<?php echo $level; ?>,this);" />&nbsp;
                        <input type="button" class="buttonM bBlue bapresp" value="Add a Prospect Response" onclick="addpresp(<?php echo $level; ?>,this);" style="margin-top: 2px;display:none;" />
                        <input type="button" class="buttonM bBlue baresp" value="Add a Sales Response" onclick="addresp(<?php echo $level; ?>,this);" style="margin-top: 2px;display:none;" />
                        <input type="button" class="buttonM bRed bdel" value="Delete" onclick="delresp(<?php echo $level; ?>,this);" style="margin-top: 2px; display:none;" />
                    </form><br clear="all" /><hr style="margin:4px;" />   	
                </div>
            </div>           
            <?php }*/?>
        </div>
        <?php		
	}
	//Qualify questions with responses
	public function qualify_resplist_show($qid,$campgid,$qp=0,$level=1) {
		$questp_responses = $this->campaign->getQualifyQuestRespRow($qid,$campgid,$qp);
		if($questp_responses) {
			foreach ($questp_responses as $qpresp){
				$quest_responses = $this->campaign->getQualifyQuestResps($qid,$campgid,$qpresp->qr_id);
				echo '<ul>';
				if($quest_responses) {
					foreach ($quest_responses as $qresp){?>
					<li><span class="red-area">If [<?php echo $qpresp->qr_response; ?>]:</span> <?php echo $qresp->qr_response; ?>
						<?php $this->qualify_resplist_show($qid,$campgid,$qresp->qr_id,$level+1);?>
					</li>
					<?php }
				} else {
					?>
					<li><span class="red-area">If [<?php echo $qpresp->qr_response; ?>]</span></li>
					<?php
				}
				echo '</ul>';
			}
		}
	}
	//Qualify questions with responses
	public function qualify_list_show($campgid) {
		$campaign_output_tech_qualify = $this->campaign->getQualifyQuest($campgid);
		ob_start();
		if (isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify){
			?>
			<ul>
				<?php foreach ($campaign_output_tech_qualify as $single_tech_qualify):?>
					<?php // print_r($single_tech_value) ?>
					<li><span class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $single_tech_qualify->tech_q_id ?>_<?php echo $single_tech_qualify->campaign_id; ?>"><?php echo $single_tech_qualify->value;?></span>
					<?php $this->qualify_resplist_show($single_tech_qualify->tech_q_id,$campgid,0,1);?>
					</li>
				<?php endforeach;?>
			</ul>
			<?php				
		}
		$Question_responses=ob_get_contents();
		ob_end_clean();
		return $Question_responses;
		
	}
	////
	
	/**
	 * Editable Template
	 * Close - Input - Template ID
	 */
	public function editable_tempalte($id=0) {
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
		if(!$id) redirect(base_url().'folder/my-folder');
		$this->_data['eid'] = $id;
		$this->_data['etemplate'] = $id;
		$template_info = $this->campaign->get_template($id);
		if(!$template_info) redirect(base_url().'folder/my-folder');				
		//Set active dropdown value
		$params = explode("/",uri_string());
		$pamid = $params[count($params)-1];
		$pam2 = $params[count($params)-2];
		$eIS="";
		//if($pamid=="IS" || $pam2=="IS") $eIS="/IS";
		$active_campaign = $this->_data['campaign_info']->campaign_id;		
		$etemplate = $this->campaign->get_etemplate($id,$active_campaign);
		if($_POST['action_dev'] == 'delete')
		{
			if($this->campaign->Remetemp_section($active_campaign, $_POST['id_dev']))
			{
				echo '1';
			}
			else echo '0'; 
			exit;
		}
		if ($this->input->post('submit') || $this->input->post('submit_done'))
		{
			$er="";
			if(!$active_campaign && !strlen(trim($_POST['campaignid']))) $er .="Select Campaign";			
			if(!$er) {
				$tbl_data = $_POST['cstm'];
				//update campaign profile name
				$ecgid=$active_campaign;
				if($_POST['campaignid']) $ecgid=(int)$_POST['campaignid'];
				$this->campaign->updateTemplateContent($tbl_data, $ecgid,$etemplate);
				if($this->input->post('submit_done')) {
					if($template_info[0]->temp_type=='Emails and Letters') $tpage='email-templates';
					else if($template_info[0]->temp_type=='Voicemail Scripts') $tpage='voicemail-script'; 
					else $tpage='sales-scripts';
					redirect(base_url().'folder/'.$tpage);
				} else redirect(base_url().'home/etemplate/'.$id.$eIS);
			} else $this->_data['err'] = $er;
		}
		
		$this->_data['template_info'] = $template_info[0];
		$this->_data['template_user'] = $etemplate;
		$template_sections = $this->campaign->get_template_sections($id);
		$this->_data['template_sections'] = $template_sections;
		$sbox_options='<option value="">Select</option>';
		$sbox_js='';
		foreach($template_sections as $tsection) {
			$sbox_options .= '<option value="'.$tsection->content_id.'">'.str_replace("'","\'",$tsection->sect_title).'</option>';
			$sbox_js .=$tsection->content_id.':["'.$tsection->sect_title.'"],';
		}
		$this->_data['tsections'] = $sbox_options;
		$this->_data['sbox_js'] = $sbox_js;
		if($active_campaign) {
			$temp_content = array();
			$template_content = $this->campaign->get_template_content($id,$active_campaign);
			$this->_data['template_content'] = $template_content;
		}	
		$this->_data['drop_campaign'] = $this->campaign->get_drop_campaign();
		$this->_data['drop_company'] = $this->campaign->get_drop_company();
		$this->_data['drop_name'] = $this->campaign->get_drop_name_profiles();
		////
		$this->_data['ecampaign_id'] = $active_campaign;
		$this->_data['edittemp'] = 1;
		//Interactive script for Voicemails 1 to 4
		if($eIS) {
			$this->_data['eIS'] = $eIS;
			$IStemplate = $this->campaign->get_template_iscontent($id,$active_campaign);
			if(count($IStemplate)<4) {
				//$tmpIS=$IStemplate;
				$tmpIS=array();
				$ISres=array();
				$lastid = 0;
				include('interactive/objection_controller.php');
				$this->_data['lastid'] = $lastid;
				for($partid=1;$partid<=4;$partid++){
					if(!isset($IStemplate[$partid])) {
						$vtemplate = array();
						$vtemplate['tsid']=	"-".$partid;
						$vtemplate['heading']=	$parts[$partid]['title'];
						$vtemplate['sorder']=	$partid;
						$this->_data['partid'] = $partid;						
						$vtemplate['value']=$this->load->view('outputs/interactive/objection_data', $this->_data, TRUE);
						$tmpIS[$partid]=$vtemplate;
					} else $tmpIS[$partid]=$IStemplate[$partid];
				}
				$IStemplate=$tmpIS;
			}
			$this->_data['IStemplate'] = $IStemplate;
		}		
		////
		$this->load->view('editable-template', $this->_data);
	}
	//SHARING LITE USRES
	/**
	 * Share User for Team Folder
	 */
	public function share_user($receiver_id) 
	{
		$sender = $this->_user_id;
		if($this->_data['eScripter']) {
			$receiver = $this->home->sharealreadyExist($receiver_id);
			if($receiver && $receiver<>"Y" && $receiver<>"N")
			{
				include(CDOC_ROOT."members/bootstrap.php");
				$Amuser = am_Di::getInstance()->userTable;
				$ausr = $Amuser->findBy(array('login'=>$receiver));
				if($ausr) {
					$amuserid = $ausr[0]->user_id;
					$Am_user = $Amuser->load($amuserid, false);
					if($Am_user) {
						$products = $Am_user->getActiveProductIds();
						if(in_array(18, $products) || in_array(19, $products)){
							$data = array('userfrom' => $sender, 'userto'=> $receiver_id);
							$this->home->addtoShareUser($data);
							$this->session->set_flashdata('msg', 'User Shared!.');
							redirect(base_url().'folder/team-folder');
						}
					}
				}
				$this->session->set_flashdata('msg', 'User not available.');
			}
			else 
			{
				$this->session->set_flashdata('msg', 'User Already Shared.');
			}
		}
		// Redirect to Member Searching Page
		redirect(base_url().'folder/team-folder');
	}
	/**
	 * Share User for Team Folder
	 */
	public function share_remove($receiver_id) 
	{		
		$this->home->UnShareUser($this->_user_id,$receiver_id);
		redirect(base_url().'folder/team-folder');
	}
	//End of SHARING LITE USRES
	/** 
	 * Campaign Coordinates
	 */
	public function campaign_coordinates() {
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489		
		$this->_data['d_page'] = 51;
		if ($this->input->post('btn_save') || $this->input->post('btn_next')) {			
			$msge=0;
			//Products
			$product_ids = $this->input->post('prod_id');
			$product_names = $this->input->post('txt_product');			
			if ($product_ids) {
				foreach($product_ids as $pi=>$pv)
				{					
					$txt_prod = $product_names[$pi];
					if(!empty($txt_prod)) {						
						if($pv) {
							$data = array('product_name' => $txt_prod);
							$this->productModel->update_product_name($pv, $data);
							//$this->productModel->update_product_name_onccd($pv, $txt_prod);							
						} else $product_id = $this->productModel->create_product($txt_prod);
						$msge=1;
					}					
				}					
			}
			//Target Prospect
			$prospect_ids = $this->input->post('prospect_id');
			$prospect_names = $this->input->post('txt_prospect');
			$targetProspect=array("ids"=>$prospect_ids,"names"=>$prospect_names);
			$tpr = $this->campaign->save_targetProspect($targetProspect);
			if($tpr) $msge=$tpr;
			if($msge) {
				//$this->session->set_flashdata('session_ccmsg','Campaign Coordinates data saved.');
			} else $this->session->set_flashdata('session_ccmsg','No data entered.');
			if ($this->input->post('btn_next')) redirect(base_url()."home/potential-campaigns");
			redirect(base_url()."home/campaign-coordinates");
		}
		
		//$find_product = $this->campaign->getAllProduct();
		$find_product = $this->campaign->get_cc_products();
		$this->_data['product_profiles'] = $find_product;
		$this->_data['target_prospects'] = $this->campaign->get_targetProspects();
		$this->_data['msg'] = $this->session->flashdata('session_ccmsg');
		$this->load->view('campaign-coordinates', $this->_data);
	}
	/** 
	 * Campaign Coordinates
	 */
	public function potential_campaigns() {
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489		
		$this->_data['d_page'] = 51;
		if ($this->input->post('btn_done')) {
			$msge = "Campaign coordinates not selected";
			$pc_name = $this->input->post('pc_name');
			if($pc_name) {
				/*$pc_name = explode("-",$this->input->post('pc_name'));
				$prod_id = (int)$pc_name[1];
				$prosp_id = (int)$pc_name[0];
				$pcresult = $this->productModel->check_potcamp($prod_id,$prosp_id);*/
				$pcresult = $this->productModel->create_combination_campaigns($pc_name);
				if($pcresult=="0") $msge = "Campaign coordinates not found";
				else if($pcresult=="1") $msge = "Campaign already exists";
				else {
					$this->session->set_flashdata('session_msg','campaign created.');
					redirect(base_url()."folder/campaigns");
				}
			}
			$this->session->set_flashdata('session_ccmsg',$msge);
			redirect(base_url()."home/potential-campaigns");
		}
		$find_product = $this->campaign->get_cc_products();
		$this->_data['product_profiles'] = $find_product;
		$this->_data['target_prospects'] = $this->campaign->get_targetProspects();
		$this->_data['msg'] = $this->session->flashdata('session_ccmsg');
		$this->load->view('potential-campaigns', $this->_data);
	}
	////
	
}
/* End of file home.php */
/* Location: ./application/controllers/home.php */
