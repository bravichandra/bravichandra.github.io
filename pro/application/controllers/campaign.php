<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  salescripter campaign class controller file
 *  
 *  PHP 5.2
 *  @version 1.0
 *  @author Bineet Kumar Chaubey
 *  @package Codeigniter
 *  @subpackage Salescripter
 */
class Campaign extends CI_Controller {
	
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
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,32), 'Restricted access'); //  By Dev@4489 24-Oct-2015
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
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15'));//  This array is sukhdev by Aavid developer on 17-April-2014
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','32'));//  By Dev@4489 24-Oct-2015
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
			////
		}  
		// For local testing  
        else 
        {
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

       $this->_user_id = $this->_data['user_id'];
       $_SESSION['ss_user_id'] = $this->_user_id;

		if(isset($just_registered))
		{
       		// Add pre-filled session
	   		$redirect = base_url().'folder/my-folder';
			$this->defaultNewproduct($redirect, 1, "My first product profile");
		}
		// Check if Product is Add or Not
		$is_product = $this->home->check_product($this->_user_id);
		if(empty($is_product))
		{
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

        $this->_data['all_sessions'] = $this->home->get_all_sessions();
        $this->_data['total_sessions'] = count($this->_data['all_sessions']);
		$this->_data['receive_invitations'] = $this->home->getAllRequests($this->_user_id, 'receiver');
		$this->_data['accept_invitations'] = $this->home->acceptInvitations($this->_user_id);
		$this->_data['accept_invitations_receiver'] = $this->home->acceptInvitationsReceiver($this->_user_id);
	    
		/**  get active session name data */
		$this->_data['active_name_drop_exp'] = $this->campaign->findActiveNameDrop();
	}

	public function index($id = NULL)
	{
		$this->_data['page'] = 'register';
		redirect(base_url() . 'step/product');
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
	
	function newcampaign($type=NULL)
	{
		$this->_data['page'] = '';
		$this->_data['d_page'] = '';
		$this->_data['camtype'] = $type;
	    $this->load->view('newcampaign', $this->_data);
	}
	/**
	 *   create a new campaign
	 */
	function createcampaign()
	{
		/** we are going to create a compaign  initial. **/
		$campaign_id = $this->productModel->createNewCampaign();
		$this->session->set_userdata('active_campaign',$campaign_id);
		redirect(base_url().'campaign/startcampaigncreate');
	}
	/**
	 *  create new company profile page.
	 */
	function createcompanyprofile()
	{
		$data['step'] = 'credibility';
		// $this->home->update_progress_menu_manual($data,$this->_data['active_session_id']);
		/**
		 *  create a new company profile for that user
		 */
        $company_id = $this->campaign->createCompany();
		$this->session->set_userdata('actcmp_session_id',$company_id);		
		redirect(base_url().'step/interest');
	}
	/**
	 *  Create new drop name profile
	 */
	function createdropname()
	{
		$data['step'] = 'sales_process';
		// $this->home->update_progress_menu_manual($data,$this->_data['active_session_id']);
		
		/** first incative all ceradibility profile */
		$this->campaign->incativeAllcredibility();
		$credibility_id = $this->campaign->addCredibility($this->session->userdata('ss_session_id'));
		// Add default Credibility Values
		$user_data[0] = array('c_id' => $credibility_id, 'field_type' => "customer", 'value' => "[past or current client]");
		$user_data[1] = array('c_id' => $credibility_id, 'field_type' => "worked", 'value' => "[service provided]");
		$user_data[2] = array('c_id' => $credibility_id, 'field_type' => "provided", 'value' => "[technical improvement]");
		$user_data[3] = array('c_id' => $credibility_id, 'field_type' => "when", 'value' => "[business improvement]");
		foreach($user_data as $user_data_child) {
			$this->home->addSessionCredibility($user_data_child);
		}
		redirect(base_url().'step/credibility');
	}
	
	/**
	 *  remove assocaited compaign page
	 *  
	 *  @param [in] $pagename Parameter_Description
	 *  @param [in] $question_no Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function makingfielsddisabled()
	{
		$tblname = $_POST['meta_key'];
		$campaign_id = $_POST['cid'];
		$p_id = $_POST['p_id'];
		$user_id = $_SESSION['ss_user_id'];
		$this->productModel->deleteCampaignSec($p_id,$campaign_id,$tblname,$user_id);
		//By Dev@4489		
		//delete this question responses
		$this->campaign->deleteCampQualifyQuestResp($p_id,$campaign_id,$tblname);
		////
	}
	
	function deletesquestion()
	{
		$sq_id = $_POST['sq_id'];
		$this->campaign->deleteSalesQuestion($sq_id);
	}
	
	function changeactiveelement()
	{
		if(isset($_POST))
		{
			//By Dev@4489
			//Check & Get the shared user id for Lite Users
			if($this->_data['is_prolite'] && !$this->_data['eScripter']) {
				$saUser = $this->home->SharedUser($this->_user_id);
				if($saUser) $_SESSION['ss_user_id'] = $saUser;
			}
			////
			if($_POST['activedropname'] != ''){
				
				$newactivedrop_id = $_POST['activedropname'];
				$this->campaign->incativeAllcredibility();
				$this->campaign->activedropname($newactivedrop_id);
			}
			
			if($_POST['activecompaignname'] != ''){
			
				$newactive_cam = $_POST['activecompaignname'];
				// die();
				
				$this->campaign->incativeAllCampaign();
				$this->campaign->activeSingleCampaign($newactive_cam);
				$this->session->set_userdata('ss_session_id',$newactive_cam);
				//$this->session->set_userdata('active_campaign',$newactive_cam);
			}
			
			if($_POST['activecompanyname'] != ""){
				
				$newactive_cam = $_POST['activecompanyname'];
				$this->campaign->inAnctiveallcompany();
				$this->campaign->activateCompany($newactive_cam);
			}
		}
		if(!count($_POST)) $this->session->set_flashdata('flashInfo', 'Selected option not activated, please try again.');
		redirect($_SERVER['HTTP_REFERER']);	
	}
	/**
	 *  @brief Brief
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function activatecompanysession()
	{
		$company_id = $_POST['company_id'];
		$this->campaign->inAnctiveallcompany();
		return $this->campaign->activateCompany($company_id );	
	}
	/**
	 *  Activate and credibility or name drop 
	 *  
	 *  @return Return_Description
	 */
	function activatecredibilitysession()
	{
		$credibility_id = $_POST['namedrop_id'];
		$this->campaign->incativeAllcredibility();
		return $this->campaign->activedropname($credibility_id);
	}
	/**
	 *  @brief Brief
	 *  
	 *  @return Return_Description
	 */
	function edit_company()
	{
		$newname = $_POST['value'];
		$idstring = $_POST['id'];
		$idarray = explode('_',$idstring);
		$id = $idarray[1];
		$result = $this->campaign->updateCompanyName($newname,$id);
		
		if($result){
		   echo $newname;
		}
	}
	/**
	 *  Edit drop name 
	 *  
	 *  @return Return_Description
	 */
	function edit_drop_name()
	{
		$newname = $_POST['value'];
		$idstring = $_POST['id'];
		$idarray = explode('_',$idstring);
		$id = $idarray[1];
		$result = $this->campaign->edit_drop_name($newname,$id);
		if($result){
		   echo $newname;
		}
	}
	/**
	 *  Edit campaign name  with inline ajax from myfolder page. 
	 */
	function edit_campaign_session()
	{
		$newname = $_POST['value'];
		$idstring = $_POST['id'];
		$idarray = explode('_',$idstring);
		$id = $idarray[1];
		$result = $this->campaign->edit_campaign_session($newname,$id);
		if($result){
		   echo $newname;
		}
	}
	/**
	 *  Delete Company from user profile 
	 *  
	 *  @return Return_Description
	 */
	function deleteCompanySess()
	{
		$company_id = $_POST['company_id'];
		$status = $_POST['status'];
		$this->campaign->deleteCompany($company_id,$status);
	}
	/**
	 *  Delete name drop with ajax
	 *  
	 *  @return Return_Description
	 */
	function deleteNameDropSess()
	{
		$credibility_id = $_POST['credibility_id'];
		$status = $_POST['status'];
		$this->campaign->deleteNameDropSess($credibility_id,$status);	
	}
		
	/**
	 *  @brief Brief
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function startcampaigncreate()
	{
		//Pro List user cant access this page
		if($this->_data['is_prolite']) redirect(base_url()."folder/my-folder");//By Dev@4489
	   if(!$this->session->userdata('active_campaign')){
	   
			redirect(base_url().'folder/campaigns');	
	   }
	   
	   $campain_id = $this->session->userdata('active_campaign');
	   
	   if(isset($_POST['campaign']) && !empty($_POST['campaign'])){
		
			$compaigndata = $_POST['campaign'];
			/* var_dump($compaigndata);
			die(); */
			$savedata = array();
			foreach($compaigndata as $key => $value)
			{
				$savedata[$key] = $value;
			}			
			
			/**
			 *   Start logic to make campaign name.
			 *   campaign name should be create synamic wit  product name and
			 *   target audience 
			 */
			
			// $_POST['campaign']['campaign_target']
			$all_campaign_post_data = $this->input->post('campaign'); 
			//by Dev@4489
			//New campaign product
			if($this->input->post('product_id_opt')=="2" && $this->input->post('product_id_txt') ) {
				$txt_prod = $this->input->post('product_id_txt');
				if(!empty($txt_prod)) {
					if($all_campaign_post_data['product_id']) {
						$edit_product = $this->productModel->getProduct($all_campaign_post_data['product_id']);
						if($edit_product && $edit_product->product_name=="[my product]") {
							$cproduct_id = $all_campaign_post_data['product_id'];
						}
					}
					if(empty($cproduct_id)) $cproduct_id = $this->productModel->campaign_new_product_name($txt_prod);
				}
				if($cproduct_id) {
					$all_campaign_post_data['product_id']=$cproduct_id;
					$savedata['product_id']=$cproduct_id;
				}
			}
			//Save Product name first time when product data saved
			if($edit_product && $txt_prod) {
				$editproduct_id = $savedata['product_id'];
				$edit_product = $this->productModel->getProduct($editproduct_id);
				if($edit_product && $edit_product->product_name=="[my product]" && $txt_prod<>"[my product]") {
					$this->productModel->updateProductNameWithservicename($editproduct_id,$txt_prod);
					$this->productModel->update_product_data($editproduct_id,$txt_prod,'P_Q1');
				}
			}
			////
			 
			// print_r($all_campaign_post_data );
			
			$findproductinfo = $this->productModel->getProduct($all_campaign_post_data['product_id']);  
			$product_name = $findproductinfo->product_name ;
			if($all_campaign_post_data['campaign_target'] == 1)
			{
				$org_name = $all_campaign_post_data['individual'];	
			}else{
				$org_name = $all_campaign_post_data['organization'];
			}
			//by Dev@4489
			//New campaign target prospect
			if($this->input->post('tp_opt')=="2" && $this->input->post('tp_txt') ) {
				$txt_prod = $this->input->post('tp_txt');
				if(!empty($txt_prod)) {
					$targetProspect=array("ids"=>array(0),"names"=>array($txt_prod));
					$tpr = $this->campaign->save_targetProspect($targetProspect);
					$org_name = $txt_prod;
					if($all_campaign_post_data['campaign_target'] == 1)
					{
						$savedata['individual']=$org_name;	
					}else{
						$savedata['organization']=$org_name;
					}
				}
			}
			////
			$actual_p_name_to_save = $product_name ." for ".$org_name;
			$savedata['campaign_name'] = $actual_p_name_to_save;
			// $campain_id = $_POST['activeCampaign'];
			$updateCampresult = $this->productModel->UpdateCamStep1($savedata,$campain_id);
			$this->home->update_progress_menu($campain_id);
			
			/** update company name */
			if($_POST['form_submit'] == 'Continue') {
				redirect(base_url().'step/value');	
			} 
		}
		
		$this->_data['page'] = '0';
		$this->_data['d_page'] = '';
		$this->_data['lnav'] = 'Y2';
		/**  find current active data campaign data */
		
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		// $current_a_sess = $this->_data['active_session_id'];
		
		$this->_data['allproduct'] = $this->campaign->getAllProduct();
		//Campaign Target Prospects
		$this->_data['target_prospects'] = $this->campaign->get_targetProspects();//by Dev@4489
		//by Dev@4489
		//$this->_data['product_profiles'] = $this->campaign->get_cc_products();
		//$this->_data['template_product_profiles'] = $this->campaign->getTuser_cc_products();
		//$this->_data['template_target_prospects'] = $this->campaign->getTuser_targetProspects();
		////
		$this->load->view('startcampaigncreate',$this->_data);
		
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param integer $product_id 
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function ajaxrender($session_id)
	{
		$this->_data['target_audiance'] = $this->campaign->findNewTargetProductTable('target-audience',$session_id);
		$this->_data['direct_campaign'] = $this->campaign->findNewTargetProductTable('direct_campaign',$session_id);
		$this->_data['target_company'] = $this->campaign->findNewTargetCompany($session_id);
		$this->_data['target_product_name'] = $this->campaign->productName($session_id); 
		$this->load->view('ajaxrenderpage',$this->_data);
	}
	/**
	 *  Change title of campain on ajax request when user select drop donw on campaign cordinate page.
	 */
	function changeTitle($product_id)
	{
		$this->_data['NewCampaignName'] = $this->campaign->changeCampaignName($product_id);
		$this->load->view('ajaxcampaigntitlepage',$this->_data);
	}
	/**
	 *  save teammate credibilities on current user credibilities table 
	 *  
	 *  @return Return_Description
	 *  @details Details
	 */
	public function savetomycredibility()
	{
		$uncrd_id = $_POST['crd_id'];
		$name =  $_POST['name'];
		$user_id =  $_POST['user_id'];
		$retuRn_Result = $this->campaign->savetomycredibility($uncrd_id,$name,$user_id);
		$this->session->set_flashdata('session_msg', 'Name Drop Example saved to My Folder');
		exit();
	}
	/**
	 *  Copy company info from friend  to user profile  
	 */
	public function copycompany()
	{
		$company_id = $this->input->post('company_id');
		$user_id	= $this->input->post('user_id');
		$company_name	= $this->input->post('company_name');
		$this->campaign->copyCompanyProfile($company_id,$user_id,$company_name);		
		$this->session->set_flashdata('session_msg', 'Company Profile saved to My Folder');
		exit();
	}
	/**
	 *  make campaign id active also make status change in database
	 */
	function edit_campaign()
	{
		$active_campaign_id = $_POST['session_id'];
		$this->session->set_userdata('active_campaign',$active_campaign_id);
		$this->productModel->edit_campaign($active_campaign_id);
	}
	/***
	 * delete campaign and all associated data   
	 */
	public function deleteCampaign()
	{
		$c_user_id = $_SESSION['ss_user_id'];
		$campaign_id = $_POST['campaign_id'];
		$this->campaign->deleteCampaign($campaign_id,$c_user_id);
		echo 1;
	}
	/**
	 *   copy add campaign data to user myfolder profile.
	 */
	public function copyCampaignToMyFolder()
	{
	
		$campaign_id = $this->input->post('campaign_id');
		$user_id	= $this->input->post('user_id');		
		$product_id = $this->campaign->copyCampaignToMyFolder($campaign_id,$user_id);
		
		$this->session->set_flashdata('session_msg', 'Sales Pitch Profile saved to My Folder');
		exit();
			/* }else{
				$this->session->set_flashdata('session_msg', 'There are something happen wrong please contact to administrator');
				exit();
			} */
	}
	/**
	 *   clone campaign data to current user campaigns. by Dev@4489
	 */
	public function cloneCampaignToCurUser()
	{
	
		$campaign_id = $this->input->post('campaign_id');
		$user_id	= $_SESSION['ss_user_id'];		
		$product_id = $this->campaign->copyCampaignToMyFolder($campaign_id,$user_id,1);
		
		$this->session->set_flashdata('session_msg', 'Sales Pitch Cloned');
		exit();
	}

	public function hideCampaigns()
	{
	
		$campaign_id = $this->input->post('campaign_id');
		$user_id	= $_SESSION['ss_user_id'];	
		$val = 	$this->input->post('val');
		$product_id = $this->campaign->hideCampaign($campaign_id,$user_id,$val);	
	}
	
	//By Dev@4489
	/***
	 * delete campaign custom content   
	 */
	public function deleteCampaignCustom()
	{
		$c_user_id = $_SESSION['ss_user_id'];
		$campaign_id = $_POST['campaign_id'];
		$this->campaign->deleteCampaignCustom($campaign_id,$c_user_id);
		echo 1;
	}
	////
	//By Dev@4489
	/**
	 *  Edit drop profile name 
	 *  
	 *  @return Return_Description
	 */
	function edit_drop_prname()
	{
		$newname = $_POST['value'];
		$idstring = $_POST['id'];
		$idarray = explode('_',$idstring);
		$id = $idarray[1];
		$cdid = $idarray[2];
		$result = $this->campaign->edit_drop_prname($newname,$id,$cdid);
		if($result){
		   echo $newname;
		}
	}
	
	
	
}
/* End of file campaign.php */
/* Location: ./application/controllers/campaign.php */
