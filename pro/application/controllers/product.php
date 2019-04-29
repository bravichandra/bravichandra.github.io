<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  salescripter Product class controller file
 *  
 *  PHP 5.2
 *  @version 1.0
 *  @author Bineet Kumar Chaubey
 *  @package Codeigniter
 *  @subpackage Salescripter
 */
class Product extends CI_Controller {
	
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
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15), 'Restricted access'); //  This array is Updated by Aavid developer on 17-April-2014
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
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15'));//  This array is Updated by Aavid developer on 17-April-2014
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','32'));//  By Dev@4489 24-Oct-2015
			// 9  is for Scripter Pro 3 Month
			// 10 is for Scripter Pro 1 Year

			// Check User Subscription PAID OR FREE
			$this->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;
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
	    
	}
	
	public function index($id = NULL)
	{
		$this->_data['page'] = 'register';
		redirect(base_url() . 'step/product');
	}

	/**
	 *  new campaign now !depreciated  
	 */
	function newcampaign($type=NULL)
	{
		$this->_data['page'] = '';
		$this->_data['d_page'] = '';
		$this->_data['camtype'] = $type;
	    $this->load->view('newcampaign', $this->_data);
	}
	
	function createcampaign()
	{
		$data['step'] = 'product';
		$this->home->update_progress_menu_manual($data,$this->_data['active_session_id']);
		redirect(base_url().'step/value');
	}
	/**
	 *  create a new product page
	 */
	public function create_product()
	{
		$product_id = $this->productModel->create_product();
		$this->session->set_userdata('edit_product',$product_id);
		redirect(base_url().'step/product');
		// redirect(base_url().'folder/my-folder');	
	}
	/**
	 *   create a dynamic tech value question  
	 */
	public function dynamicTechValue()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_tech_val_id']= $this->productModel->createTechValue($active_campaign,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicTechV', $this->_data);
	}
	/**
	 *   create a dynamic business value  question and answer 
	 */
	public function dynamicbizValue()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_biz_val_id']= $this->productModel->createDynamciBizValue($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicBizV', $this->_data);
	}
	
	/**
	 *   create a dynamic business value  question and answer 
	 */
	public function dynamicPerValue()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_per_val_id']= $this->productModel->createPersonalvalue($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicPerV', $this->_data);
	}
	
	
	/**
	 *   create a dynamic Technical pain  question and answer 
	 */
	public function dynamicTechPain()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_tech_pain_id']= $this->productModel->createTechPain($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->_data['totalcount'] = $totalcount;			//added by developer 29-2-2016
		$this->load->view('dynamicTechPain', $this->_data);
	}
	
	
	/**
	 *   create a dynamic business pain  question and answer 
	 */
	public function dynamicBizPain()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_biz_pain_id']= $this->productModel->createBizPain($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicBizPain', $this->_data);
	}
	
	/**
	 *   create a dynamic business pain  question and answer 
	 */
	public function dynamicPerPain()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_per_pain_id']= $this->productModel->createPerPain($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicPerPain', $this->_data);
	}
	
	/**
	 *   create a dynamic Technical qualify question and answer 
	 */
	public function dynamicTechQualify()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_tech_qualify_id']= $this->productModel->createTechQualify($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicTechQualify', $this->_data);
	}
	
	
	public function dynamicSalesQuestion()
	{	
		$totalcount = $_POST['totalcount'];
		$type = $_POST['type'];
		$this->db->select();
		$this->db->from('campaigns');
		$this->db->where('user_id',$this->_user_id);
		$this->db->where('status','1');	
		$record = $this->db->get();
		$active_campaign_res = $record->result();
		$active_campaign = $active_campaign_res[0]->campaign_id;
		$this->_data['new_sales_question_id']= $this->productModel->createSalesQuestion($active_campaign,NULL,$totalcount,$type);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicSalesQuestion', $this->_data);
	}
	
	
	/**
	 *   create a dynamic Business qualify question and answer 
	 */
	public function dynamicBizQualify()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_biz_qualify_id']= $this->productModel->createBizQualify($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicBizQualify', $this->_data);
	}
	
	/**
	 *   create a dynamic Personal qualify question and answer 
	 */
	public function dynamicPerQualify()
	{	
		$totalcount = $_POST['totalcount'];
		$active_campaign = $this->session->userdata('active_campaign');
		$this->_data['new_per_qualify_id']= $this->productModel->createPerQualify($active_campaign,NULL,$totalcount);
		$this->_data['campaign_info'] = $this->campaign->getCampaignData();
		$this->load->view('dynamicPerQualify', $this->_data);
	}
	
	public function dy_cam_up_entry()
	{
	   /** id format will
	    *   [short_table_name]_[uniqe_id]_[campaign_id];
	    *  
	    */
		$id = $_POST['id'];
		$exp_array= explode('_',$id); 
		$tbl_name = $exp_array[0];
		$prim_id = $exp_array[1];
		$camp_id = $exp_array[2];
		$key_value = $_POST['value'];
		
		/** first campain is current user campaign */
		$current_user = $_SESSION['ss_user_id'];
		$isCamap = $this->productModel->isCampaignValidUser($current_user,$camp_id);
			
		if($isCamap)
		{
			/**  now update those change **/
			$this->productModel->dym_camp_update_entry($tbl_name,$prim_id,$key_value,$camp_id);
		}
		echo $key_value ;
	}
	
	function readDefaultSample()
	{
	
		$jsonsdata = $this->load->file(APPPATH."config/default.json",true);
		
		echo "<pre>";
		print_r(json_decode($jsonsdata));
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
	
}
/* End of file campaign.php */
/* Location: ./application/controllers/campaign.php */
