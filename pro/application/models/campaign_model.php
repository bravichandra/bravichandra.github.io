<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  This is compaign model class file.
 *  @PHP > 5.2
 *  @version 1.0
 *  @author Bineet Kumar Chaubey
 *  @package Codeigniter
 *  @subpackage salescripter 
 *  @link
 *  @see
 */
class Campaign_model extends CI_Model 
{
	/**
	 * Properties
	 */
    private $_template_user = 3445;
	private $_table_users;
	private $_table_values;
	private $_table_plains;
	private $_table_close;

	private $_table_building_credibilities;
	private $_table_building_interests;
	private $_table_ideal_prospects;
	private $_table_objections;
	private $_table_qualifying;
	private $_table_products;
	private $_table_product_data;
	private $_table_credibility;
	private $_table_credibility_data;
	private $_table_objection;
	private $_table_objection_data;
	private $_table_user_data;
	private $_table_session;
	private $_table_team_sessions;
	private $_table_company;
	private $_table_company_data;
	private $_table_credibility_main;

	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
        //Define Table names
        $this->_table_users		 				= $this->config->item('table_users');
        $this->_table_values 	 				= $this->config->item('table_values');
        $this->_table_plains 	 				= $this->config->item('table_plains');
        $this->_table_close 	 				= $this->config->item('table_close');
        $this->_table_objections 				= $this->config->item('table_objections');
        $this->_table_qualifying 				= $this->config->item('table_qualifying');
        $this->_table_product_data 				= $this->config->item('table_product_data');
        $this->_table_building_credibilities 	= $this->config->item('table_building_credibilities');
        $this->_table_building_interests 		= $this->config->item('table_building_interests');
        $this->_table_ideal_prospects 			= $this->config->item('table_ideal_prospects');
        $this->_table_products 					= $this->config->item('table_products');
        $this->_table_product_data 				= $this->config->item('table_product_data');
        $this->_table_credibility 				= $this->config->item('table_credibility');
        $this->_table_credibility_data 			= $this->config->item('table_credibility_data');
        $this->_table_objection 				= $this->config->item('table_objection');
        $this->_table_objection_data 			= $this->config->item('table_objection_data');
        $this->_table_user_data 				= $this->config->item('table_user_data');
        $this->_table_session 	 				= $this->config->item('table_session');
        $this->_table_team_sessions 			= $this->config->item('table_team_sessions');
		$this->_table_company 					= $this->config->item('table_company');
		$this->_table_company_data 				= $this->config->item('table_company_data');
		$this->_table_credibility_main 			= $this->config->item('table_credibility_main');
		$this->_table_campaign 					= $this->config->item('table_campaigns');
		$this->_table_tech_value 				= $this->config->item('table_tech_value');
		$this->_table_biz_value 				= $this->config->item('table_biz_value');
		$this->_table_per_value 				= $this->config->item('table_per_value');
		$this->_table_campaign_comm 			= $this->config->item('table_campaign_comm');
		$this->_table_tech_qualify 				= $this->config->item('table_tech_qualify');
		$this->_table_tech_pain 				= $this->config->item('table_tech_pain');
		$this->_table_biz_qualify 				= $this->config->item('table_biz_qualify');
		$this->_table_biz_pain 					= $this->config->item('table_biz_pain');
		$this->_table_per_qualify 				= $this->config->item('table_per_qualify');
		$this->_table_per_pain 					= $this->config->item('table_per_pain');
        // $this->load->library('session'); 
    }
    
    public function get_all_users_sessions() 
    {
    	$query = $this->db->get($this->_table_session);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	
    public function get_single_user_info($user_id) 
    {
    	$this->db->select('first_name, last_name');
    	$this->db->where('user_id', $user_id);
    	$query = $this->db->get($this->_table_users);
    	if ($query->num_rows() > 0)
    	{
    		return $query->row();
    	}
    }

	
    public function get_all_users_products() 
    {
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_products);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

    public function get_all_users_credibilities() 
    {
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_credibility);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	
    public function get_all_users_objections() 
    {
    	$query = $this->db->get($this->_table_objection);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	
    /**
     *  @brief get full table name with shart name
     *  
     *  @param string $shortname Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    private function _get_table_name($shortname) 
    {
    	switch ($shortname) {

    		case 'tpd':
    		return $this->_table_product_data;
    		break;
			
    		case 'tud':
    		return $this->_table_user_data;
    		break;
    		case 'tcd':
    		return $this->_table_credibility_data;
    		break;

    		case 'tod':
    		return $this->_table_objection_data;
    		break;
    		
    		case 'tbc':
    		return $this->_table_building_credibilities;
    		break;
    		
    		case 'tbi':
    		return $this->_table_building_interests;
    		break;

    		case 'tcl':
    		return $this->_table_close;
    		break;
    		
    		case 'tip':
    		return $this->_table_ideal_prospects;
    		break;
    		

    		case 'tob':
    		return $this->_table_objections;
    		break;
    		
    		case 'tpa':
    		return $this->_table_plains;
    		break;
    		
    		case 'tql':
    		return $this->_table_qualifying;
    		break;
    		
    		case 'tvl':
    		return $this->_table_values;
    		break;
			
			case 'cmp':
				return $this->_table_company;
    		break;
			
			case 'cmpdt':
				return $this->_table_company_data;
    		break;
			
    	}
    }
	/**
	 *  Cretae a new company profile.
	 *  
	 *  @return new company profile id
	 *  
	 *  @details Details
	 */
	function createCompany()
	{
		$user_id = $_SESSION['ss_user_id'];	
	    $this->inAnctiveallcompany();
		$comsavedata = array(
							'user_id' => $user_id,
							'company_name' => 'default-company',
						);
		$this->db->insert($this->_table_company,$comsavedata);
		$last_company_id = $this->db->insert_id();
		$company_data = array(
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'business_exp',
							   'meta_value'	=> 'business exp',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'awards_won',
							   'meta_value'	=> 'awards you won',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'area_operate',
							   'meta_value'	=> 'area you operate',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'your_name',
							   'meta_value'	=> 'your name',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'your_title',
							   'meta_value'	=> 'your title',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'your_phone',
							   'meta_value'	=> 'your phone',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'your_email',
							   'meta_value'	=> 'your email',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'interest',
							   'meta_value'	=> '[company fact 1]',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'interest',
							   'meta_value'	=> '[company fact 2]',
							),
							array(
							   'company_id' => $last_company_id,
							   'user_id'	=> $user_id,
							   'meta_key'	=> 'interest',
							   'meta_value'	=> '[company fact 3]',
							)
						);
		$this->db->insert_batch($this->_table_company_data,$company_data);
		return $last_company_id;
	}
	/**
	 *  make all company status is 0 for current logged in user
	 */
	public function inAnctiveallcompany()
	{
		$updata = array('status' => '0');
		$user_id = $_SESSION['ss_user_id'];
		$this->db->where('user_id',$user_id);
		$this->db->update($this->_table_company,$updata);
		return true;
	}
	/**
	 *  Current user current active company profile data interestB2 meta_key
	 *  
	 *  @return array Return_Description
	 *  
	 *  @details Details
	 */
	public function findCompanyDataThreadNOAction()
	{
	    $user_id = $_SESSION['ss_user_id'];
		
		$this->db->select('*');
		$this->db->from('company');
		$this->db->join('company_data', 'company_data.company_id = company.company_id');
		$this->db->where('company.user_id',$user_id);
		$this->db->where('company.status',1);
		$this->db->where('trash',0);
		$this->db->where('company_data.meta_key','interestB2');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function findcompanyMetaData($camp_id,$key)
	{
	    $user_id = $_SESSION['ss_user_id'];
		$this->db->select('*');
		$this->db->from('company_data');
		$this->db->where('company_data.meta_key',$key);
		$this->db->where('company_data.company_id',$camp_id);
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->row();
	}
	
	
	/**
	 *  Find logged in user active company data for interest meta_key
	 *  
	 *  @return array resukt set 
	 *  
	 *  @details Details
	 */
	public function findCompanyDataFact()
	{
	    $user_id = $_SESSION['ss_user_id'];
		
		$this->db->select('*');
		$this->db->from('company');
		$this->db->join('company_data', 'company_data.company_id = company.company_id');
		$this->db->where('company.user_id',$user_id);
		$this->db->where('company.status',1);
		$this->db->where('trash',0);
		$this->db->where('company_data.meta_key','interest');
		$query = $this->db->get();
		return $query->result();
	}
	//by Dev@4489
	//Get all company insterest answers
	public function getcompany_interests()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('meta_value as value,company_data_id as answid');
		$this->db->from('company');
		$this->db->join('company_data', 'company_data.company_id = company.company_id');
		$this->db->where('company.user_id',$user_id);
		$this->db->where('company.status','0');
		$this->db->where('trash',0);
		$this->db->where('company_data.meta_key','interest');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	//Get Tempate User all company insterest answers
	public function getTusercompany_interests()
	{
		$user_id =  $this->_template_user;
		$this->db->select('meta_value as value,company_data_id as answid');
		$this->db->from('company');
		$this->db->join('company_data', 'company_data.company_id = company.company_id');
		$this->db->where('company.user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->where('company_data.meta_key','interest');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	////
	/**
	 *  updatecompanydata
	 *  
	 *  @param [in] $activedata Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function SaveCompanyData($activedata)
	{
	   $alldata = $_POST;
	   $user_id = $_SESSION['ss_user_id'];
	   
		// var_dump($alldata); die();
		$companypostnamedata = $_POST['cmp_']['company_name'];
	    /* $companyidarray = array_keys($companypostnamedata)); 
		$companynameid = $companyidarray[0]; */
		foreach($companypostnamedata as $key => $value)
		{
		    //Company website
			$companyWebsite = $_POST['cmp_']['company_website'];
			$WebsiteUrl = $companyWebsite[$key];
			//if($WebsiteUrl && substr($WebsiteUrl,0,4)<>"http") $WebsiteUrl = "http://".$WebsiteUrl;
			
			
			/*$emailSignature = $_POST['cmp_']['email_signature'];
			$eSignature = $emailSignature[$key];*/
			
			
		    $cmpupdate = array('company_name' => $value,'company_website' => $WebsiteUrl);
			//$cmpupdate = array('company_name' => $value);
			$this->db->where('company_id',$key);
			$this->db->where('user_id',$user_id);
			$this->db->update($this->_table_company,$cmpupdate);
		}
		
		$companydata = $_POST['cmpdt_'];
		foreach($companydata as $singletypedata)
		{
			foreach($singletypedata as $key => $value )
			{
			    $cmpupdatedate = array('meta_value' => $value);
				$this->db->where('company_data_id',$key);
				$this->db->where('user_id',$user_id);
				$this->db->update('company_data',$cmpupdatedate);			
			}
	   }
	}
	
	/**
     *  neew code for add cradibility in cradibility table related to user id
     *  
     *  @param [in] $sessionId Parameter_Description
     *  @return Return_Description
     *  
     *  @details Details
     */
    public function addCredibility() 
    {
    	$credibility = array();
		$credibility['user_id'] = $_SESSION['ss_user_id'];
		$credibility['credibility_name'] = '[past client name]';
		$this->db->insert($this->_table_credibility, $credibility);
		$credibility_id = $this->db->insert_id();
		return $credibility_id;
		
    }
	/**
	 *  @brief make inactive all credibility of an user 
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function incativeAllcredibility()
	{
		$user_id = $_SESSION['ss_user_id'];
		$updatedata = array('status' => '0');
		$this->db->where('user_id',$user_id);
		$this->db->update($this->_table_credibility,$updatedata);
	}
	/**
	 *  Return current active credibility value; 
	 *  
	 *  @param interger  $user_id Parameter_Description
	 *  @return array mysql result set
	 *  
	 *  @details Details
	 */
	function get_current_active_credibility($user_id, $campaign_session_id=NULL)
	{
		$user_id = $_SESSION['ss_user_id'];
		$this->db->where('user_id', $user_id);
		$this->db->where('status', 1);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_credibility);
		
		if($query->num_rows > 0)
		{
			return $query->row();
		}
		return NULL;
	}
	/**
	 *  Add new credibility with ajax request ;
	 *  
	 *  @param [in] $credibility_data Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function addCredibilityajax($credibility_data)
	{
		$user_id = $_SESSION['ss_user_id'];
	    $newfieldddata = array(
							'user_id' => $user_id,
							'crd_main_id' => $credibility_data[0]->crd_main_id,
						);
		$this->db->insert($this->_table_credibility,$newfieldddata);
		return $this->db->insert_id();
	}
	/**
	 *  update credibility name
	 *  
	 *  @return boolean
	 */
	function savecrediblityname($dropnamedata,$crd_id)
	{
		$current_user_id = $_SESSION['ss_user_id'];
		$updatedata = array('credibility_name' => $dropnamedata);
		$this->db->where('c_id',$crd_id);
		$this->db->where('user_id',$current_user_id);
		$this->db->update($this->_table_credibility,$updatedata);
		// echo $this->db->last_query();
	}
	/**
	 *  update campaign name 
	 *  
	 *  @param string $company_name Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function updatecampaignname($company_name,$product_id)
	{
		$updatedata = array('campaign_name' => $company_name );
	    $user_id = $_SESSION['ss_user_id'];
		$c_session_id = $product_id;
		$this->db->where('user_id',$user_id);
		$this->db->where('product_id',$c_session_id);
		// $this->db->where('session_id',$c_session_id);
		$this->db->update($this->_table_products,$updatedata);
		// echo $this->db->last_query();
	}
	
	/**
	 *  @brief Brief
	 *  
	 *  @param string $metakey field_type name in product_data table 
	 *  @param integer $question_number question_id number for that meta key 
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function inactivate($metakey,$question_number,$ac_p_id){
	    // echo "aaaa";
		$ac_session_id = $ac_p_id ;		 
		$user_id  =  $_SESSION['ss_user_id'];
		$updatedt = array('Qus_status' => '0');
		// $this->db->where('user_id',$user_id);
		$this->db->where('product_id',$ac_session_id);
		$this->db->where('field_type',$metakey);
		$this->db->where('question_id',$question_number);
		$result =  $this->db->update($this->_table_product_data,$updatedt);
		// var_dump($result);
		
	}
	/**
	 *  get campaign name
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function get_drop_campaign()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('count(userfrom) as qrcount,userfrom');
		$this->db->from('tbl_user_shared');
		$this->db->where('userto',$user_id);
		$record = $this->db->get();
		$result = $record->row_array();
		$count =  $result['qrcount'];
		if($count>0) $user = $result['userfrom'];
		else $user = $user_id;		
		$this->db->select('*');
		$this->db->where('user_id',$user);
		$this->db->where('trash',0);
		$this->db->from($this->_table_campaign);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('campaign_name','asc');
		$query = $this->db->get();
		// echo $this->db->last_query();
		return $query->result();
	}
	
	function get_drop_company()
	{
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
		$this->db->select();
		$this->db->where('user_id',$shuser);
		$this->db->where('trash',0);
		$this->db->from($this->_table_company);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('company_name','asc');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	function get_drop_name()
	{
		/*$user_id =  $_SESSION['ss_user_id'];
		$this->db->select();
		$this->db->where('user_id',$user_id);
		$this->db->from($this->_table_credibility);
		$query = $this->db->get();
		return $query->result();*/
		//By Dev@4489
		
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->order_by("sorder","asc");
		$this->db->order_by("credibility_name","asc");
		$query = $this->db->get($this->_table_credibility);
		$dropnames = $query->result();
		if($dropnames) {
			foreach($dropnames as $di=>$dnval) {
				$this->db->where('c_id',$dnval->c_id);
				$this->db->where('field_type','profile');
				$this->db->order_by("c_data_id","desc");
				$query = $this->db->get($this->_table_credibility_data);
				$cdrow = $query->row();
				if($cdrow) {
					$dnval->value=$cdrow->value;
					$dnval->c_data_id=$cdrow->c_data_id;
				}
				$dropnames[$di]=$dnval;
			}
			return $dropnames;
		}
		return array();
		
		/*$user_id =  $_SESSION['ss_user_id'];
		$ccquery="select c.*,ci.value from ".$this->_table_credibility." c 
			left join ".$this->_table_credibility_data." ci on (ci.c_id=c.c_id and ci.field_type='profile') 
			where c.user_id=".$user_id." and c.trash=0 order by c.credibility_name 
		";
		$ccrows=$this->db->query($ccquery);
		return $ccrows->result();*/
		////
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $newactivedrop_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function activedropname($newactivedrop_id)
	{
		$user_id = $_SESSION['ss_user_id'];
		$updatedata = array('status' => '1');
		$this->db->where('user_id',$user_id);
		$this->db->where('c_id',$newactivedrop_id);
		$this->db->update($this->_table_credibility,$updatedata);
	}
	/**
	 *  @brief Brief
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function incativeAllCampaign()
	{
		$user_id = $_SESSION['ss_user_id'];
		$updatedata = array('status' => '0');
		$this->db->where('user_id',$user_id);
		$this->db->update($this->_table_campaign,$updatedata);
		// echo $this->db->last_query();
		// die();
		
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param integer $session_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function activeSingleCampaign($campaign_id)
	{
		$user_id = $_SESSION['ss_user_id'];
		$updatedata = array('status' => '1');
		$this->db->where('user_id',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->update($this->_table_campaign,$updatedata);
		// echo $this->db->last_query();
		// die();
		
	}
	/**
	 *  active new campaign 
	 */
	function activateCompany($company_id)
	{
		$user_id = $_SESSION['ss_user_id'];
		$updatedata = array('status' => '1');
		$this->db->where('user_id',$user_id);
		$this->db->where('company_id',$company_id);
		return $this->db->update($this->_table_company,$updatedata);
		// var_dump($this->db->last_query());
	}
	
	/**
     * Update Record
	 *
     */
    public function getProductId() 
    {
		$user_id = $_SESSION['ss_user_id'];
    	$this->db->where('user_id', $user_id);
    	$this->db->where('status', '1');
		$query = $this->db->get($this->_table_session);
		
        if ($query->num_rows() > 0)
    	{
    		$activesession_id =  $query->row()->session_id;
			$this->db->where('session_id',$activesession_id);
			$this->db->where('user_id',$user_id);
			$this->db->where('trash',0);
			$query2 = $this->db->get($this->_table_products);
			if($query2->num_rows() > 0){
				return $query2->row()->product_id;
			}
    	}
		return NULL;
    }
	/**
	 *  @brief Brief
	 *  
	 *  @param string  $newname Parameter_Description
	 *  @param integer $id Parameter_Description
	 *  @return Return_Description
	 */
	function updateCompanyName($newname,$id)
	{
	   $updatedate = array('company_name' => $newname);
	   $user_id = $_SESSION['ss_user_id'];
	   $this->db->where('company_id',$id);
	   $this->db->where('user_id',$user_id);
	   return $this->db->update($this->_table_company,$updatedate);	
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param string $newname Parameter_Description
	 *  @param integer $id Parameter_Description
	 *  @return Return_Description
	 */
	function edit_drop_name($newname,$id)
	{
	   $updatedate = array('credibility_name' => $newname);
	   $user_id = $_SESSION['ss_user_id'];
	   $this->db->where('c_id',$id);
	   $this->db->where('user_id',$user_id);
	   return $this->db->update($this->_table_credibility,$updatedate);	
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param string $newname Parameter_Description
	 *  @param [in] $id Parameter_Description
	 *  @return Return_Description
	 */
	function edit_campaign_session($newname,$id)
	{
	   $updatedate = array('campaign_name' => $newname);
	   $user_id = $_SESSION['ss_user_id'];
	   $this->db->where('campaign_id',$id);
	   $this->db->where('user_id',$user_id);
	   return $this->db->update($this->_table_campaign,$updatedate);	
	}
	/**
	 *  Delete company profile
	 *  
	 *  @param [in] $company_id Parameter_Description
	 *  @param [in] $status Parameter_Description
	 *  @return Return_Description
	 */
	function deleteCompany($company_id,$status=0,$isdelete=0)
	{
	   $user_id = $_SESSION['ss_user_id'];
	   //Move to trash
		if($isdelete==0) {
			$statusUpdate = array('trash' => 1);
			$this->db->where('company_id',$company_id);
			$this->db->where('user_id',$user_id);
			$this->db->update($this->_table_company,$statusUpdate);
			$delResult = true;			
		} else if($isdelete==2) {//Restore
			$statusUpdate = array('trash' => 0);
			$this->db->where('company_id',$company_id);
			$this->db->where('user_id',$user_id);
			$this->db->update($this->_table_company,$statusUpdate);			
		} else {//Delete permanently
		   $this->db->where('user_id',$user_id);
		   $this->db->where('company_id',$company_id);
		   $delResult = $this->db->delete($this->_table_company);
		   
		   // also delete company_data table record ;
		   $this->db->where('user_id',$user_id);
		   $this->db->where('company_id',$company_id);
		   $this->db->delete($this->_table_company_data);
	   }	   
	   
	   if($delResult == true && $status == 1)
	   {
			$statusUpdate = array('status' => 1);
			$this->db->select('max(company_id) as last_c_id');
			$this->db->where('user_id',$user_id);
			$this->db->where('trash',0);
			$result2 =  $this->db->get($this->_table_company);
			
			if($result2->num_rows > 0){
				$last_c_id = $result2->row()->last_c_id;
				// now update that id
				$this->db->where('company_id',$last_c_id);
				$this->db->where('user_id',$user_id);
				$this->db->update($this->_table_company,$statusUpdate);
			}
	   }  
	}
	/**
	 *  delete a dropname profile 
	 */
	function deleteNameDropSess($credibility_id,$status=0,$isdelete=0)
	{
	   $user_id = $_SESSION['ss_user_id'];
	   //Move to trash
		if($isdelete==0) {
			$upd = array('trash' => 1);
			$this->db->where('c_id',$credibility_id);
			$this->db->where('user_id',$user_id);
			$this->db->update($this->_table_credibility,$upd);
			return true;
		}
		//Restore
		if($isdelete==2) {
			$upd = array('trash' => 0);
			$this->db->where('c_id',$credibility_id);
			$this->db->where('user_id',$user_id);
			$this->db->update($this->_table_credibility,$upd);
			//echo $this->db->last_query();
			return true;
		}
	   $this->db->where('user_id',$user_id);
	   $this->db->where('c_id',$credibility_id);
	    // also delete company_data table record ;
	   return $this->db->delete($this->_table_credibility);
	   
	}
	
	/**
	 *   this is depreceated code function 
	 */
	function GetActiveSessionrecord($active_session_id)
	{
		$this->db->where('session_id',$active_session_id);
		$singleresult = $this->db->get($this->_table_session);
		if($singleresult->num_rows > 0){
			return $singleresult->row();
		}else{
			return array();
		}
	}
	
	function findNewTargetProductTable($keyname,$session_id){
	
		/** first find product id **/ 
		$this->db->select('*');
		$this->db->from($this->_table_products);
		$this->db->join($this->_table_product_data, 'products.product_id = product_data.product_id');
		$this->db->where('session_id',$session_id);
		$this->db->where('field_type',$keyname);		
		$this->db->order_by('products.sorder','asc');
		$this->db->order_by('products.product_name','asc');	
		// $result_data = $this->db->get($this->_table_product_data);
		
		$result_data = $this->db->get();
		if($result_data->num_rows > 0)
		{
			return $result_data->row();
		}
		  return array();
	}
	
	function findNewTargetCompany($session_id)
	{
		$this->db->where('session_id',$session_id);
		$this->db->where('field_type','users');
		$result_data = $this->db->get($this->_table_user_data);
		// echo $this->db->last_query();
		if($result_data->num_rows > 0 )
		{
			return $result_data->row(1);
		}
		  return array();
	}
	

	/**
	 *  Find compaign name with session data 
	 *  
	 *  @param integer $session_id Parameter_Description
	 *  @return Return_Description
	 */
	function changeCampaignName($session_id)
	{
		$this->db->where('session_id',$session_id);
		$result = $this->db->get($this->_table_products);
		if($result->num_rows > 0)
		{
			return $result->row();
		}
		return array();
	}
	/**
	 *  Find active namedrop
	 *  
	 *  @return Return_Description
	 */
	function findActiveNameDrop()
	{
		$current_user_id = $_SESSION['ss_user_id'];
		$this->db->select('*');
		$this->db->from($this->_table_credibility);
		$this->db->join($this->_table_credibility_data,'credibility.c_id = credibility_data.c_id');
		$this->db->where('credibility.user_id',$current_user_id);
		$this->db->where('credibility.status',1);
		$this->db->where('trash',0);
		$result = $this->db->get();
		if($result->num_rows > 0)
		{
			return $result->result();
		}
		 return array();
	}
	/**
	 *  name drop for output pages
	 */
	public function findActiveNameDropForOutput()
	{
		
		$nameDrop = array();
		
		$current_user_id = $_SESSION['ss_user_id'];
		$this->db->select('*');
		$this->db->from($this->_table_credibility);
		$this->db->join($this->_table_credibility_data,'credibility.c_id = credibility_data.c_id');
		$this->db->where('credibility.user_id',$current_user_id);
		$this->db->where('credibility.status',1);
		$this->db->where('trash',0);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			foreach($query->result() as $singleDrop)
			{
				$nameDrop[$singleDrop->field_type] = $singleDrop ;
			}
			// $nameDrop['credibility_name'] = $query->row()->credibility_name;
			return $nameDrop;
		}
		return array();
	}
	
	
	
	
	
	
	
	
	
	/**
	 *  Get all campaign list with session id
	 *  
	 *  @param integer $user_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function getAllCampaignWithUserID($user_id) 
    {
		$this->db->select('*');
		$this->db->from($this->_table_campaign);
		// $this->db->join($this->_table_session,'session.session_id = products.session_id');
		$this->db->where('campaigns.user_id', $user_id);
		$this->db->where('trash',0);
		$query = $this->db->get();
    	// echo $this->db->last_query();
		if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }
	/**
	 *  get all company profile by user id
	 *  
	 *  @param integer $user_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function getCompanyProfileWithUserID($user_id)
	{
		$this->db->select('*');
		$this->db->from($this->_table_company);
		$this->db->where('company.user_id', $user_id);
		$this->db->where('trash',0);
		$this->db->order_by('company.sorder','asc');
		$this->db->order_by('company.company_name','asc');
		$query = $this->db->get();
    	// echo $this->db->last_query();
		if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $user_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function getAllNameDropByUserID($user_id)
	{
		$this->db->select('*');
		//$this->db->from($this->_table_credibility_main);
		$this->db->from($this->_table_credibility);
		$this->db->where('user_id', $user_id);
		$this->db->where('trash',0);
		$query = $this->db->get();
    	// echo $this->db->last_query();
		if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
	}
	/**
	 *  @brief Brief
	 *  
	 *  @param [in] $unique_id Parameter_Description
	 *  @param [in] $name Parameter_Description
	 *  @param [in] $user_id Parameter_Description
	 *  @return Return_Description
	 */
	public function savetomycredibility($unique_id,$name,$user_id)
	{
		$current_user_id = $_SESSION['ss_user_id'];
		// $credibilitymain = $this->_getdatacrdmain($unique_id,$name,$user_id);
		$crddata = $this->_getdatacrd($unique_id,$user_id);
		$cid = $crddata->c_id; 
		$crddatakeyvalule = $this->_getdatacrdkeyvalue($cid);
		//var_dump($crddatakeyvalule);
		if($crddatakeyvalule){
			
			/* insert in credibility table */
			$save_credibility = array('user_id' => $current_user_id, 'credibility_name ' => $crddata->credibility_name);
			$this->db->insert($this->_table_credibility,$save_credibility);
			$last_middle_id = $this->db->insert_id();
			foreach($crddatakeyvalule  as $single_crd)
			{
				$new_save_crd_data_t_val = array('c_id' => $last_middle_id,'field_type' => $single_crd->field_type,'value' => $single_crd->value);
				$this->db->insert($this->_table_credibility_data,$new_save_crd_data_t_val);	
			}
			return $last_middle_id;
		}
		
		return false;
	}
	
	function _getdatacrdmain($unique_id,$name,$user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('crd_main_id',$unique_id);
		$query = $this->db->get($this->_table_credibility_main);
	
		if($query->num_rows > 0)
		{
			return $query->row();
		}
	    return false;
	}
	
	function _getdatacrd($unique_id,$user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('c_id',$unique_id);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_credibility);
		if($query->num_rows > 0)
		{
			return $query->row();
		}
	    return false;
	}
	/**
	 *  private function 
	 */
	function _getdatacrdkeyvalue($cid)
	{
		$this->db->where('c_id',$cid);
		$query = $this->db->get($this->_table_credibility_data);
		// echo $this->db->last_query();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
	    return false;
	}
	/**
	 *  Copy teammate company profile into user profile
	 *  
	 */
	public function copyCompanyProfile($company_id,$user_id,$company_name)
	{
		$c_user_id = $_SESSION['ss_user_id'];
		$this->db->where('company_id',$company_id);
		$this->db->where('user_id',$user_id);
		$resultcompany = $this->db->get($this->_table_company_data);
		// var_dump($resultcompany);
		if($resultcompany->num_rows > 0)
		{
			$savecompanydata = array('user_id' => $c_user_id,'company_name' => $company_name);
			$this->db->insert($this->_table_company,$savecompanydata);
			$last_cmp_id = $this->db->insert_id();
			foreach($resultcompany->result() as $singlecompany)
			{
				$save_comp_data = array('company_id' => $last_cmp_id,'user_id' => $c_user_id,'meta_key' => $singlecompany->meta_key,'meta_value' => $singlecompany->meta_value);
				$this->db->insert($this->_table_company_data,$save_comp_data);
			}
		}
	}
	/**
	 *  chack user teammate status 
	 */
	public function checkTeammate($user_id)
	{
		$cuser_id = $_SESSION['ss_user_id'];
		$this->db->where('sender_id',$user_id);
		$this->db->or_where('sender_id',$cuser_id);
		$this->db->where('receiver_id',$user_id);
		$this->db->or_where('receiver_id',$cuser_id);
		$result = $this->db->get($this->_table_team_sessions);
		// echo $this->db->last_query();
		if($result->num_rows > 0){
			return true;
		}else{
			return false;
		}
	}
	/**
	 *  
	 */
	function getCampaignData($cam_id=NULL){
	
		if($cam_id!= NUll){
			$this->db->where('campaign_id',$cam_id);
		}else{
		
			$this->db->where('status','1');
		}
		$this->db->where('user_id',$_SESSION['ss_user_id']);
		$this->db->where('trash',0);
		$record = $this->db->get($this->_table_campaign);
	
		if($record ->num_rows > 0){
		
		   return $record->row();
		}
		return false;
	}
	
	/**
	 *   get product detail
	 */
	public function getProduct($p_id)
	{
		$this->db->where('trash',0);
		$this->db->where('product_id',$p_id);
		$record =  $this->db->get($this->_table_products);
		if($record->num_rows > 0)
		{
			return $record->row();
		}
		return false;
	}
	
	public function getAllProduct()
	{
		$c_user_id =  $_SESSION['ss_user_id'];
		$this->db->where('user_id',$c_user_id);
		$this->db->where('trash',0);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('product_name','asc');
		$getvalue = $this->db->get($this->_table_products);
		if($getvalue->num_rows > 0)
		{
			return $getvalue->result();
		}
		return false;
	}
	
	/**
	 *  fecth record form tech value table
	 */
	public function getTechValue($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$getvalue = $this->db->get($this->_table_tech_value);
		if($getvalue->num_rows > 0)
		{
			return $getvalue->result();
		}
		return false;
	}
	
	public function updateCustomContent($data, $campaign_id,$etemp)
	{
		//$this->db->where('campaign_id',(int)$campaign_id);
		//$this->db->delete('tbl_pro_custom');
		//echo $this->db->last_query(); exit;
		//print_r($data); 
		//$this->db->select('*');
		//$this->db->where('campaign_id',(int)$campaign_id);
		//$get_value = $this->db->get('tbl_pro_custom');
		
		$user_id =  $_SESSION['ss_user_id'];
		if(trim($data['title'])) {
			if($etemp) {
				$edata = array('temp_title'=>$data['title'],'temp_hide'=>$data['hide']?1:0);
				$this->db->where('temp_id',0);
				$this->db->where('temp_user',(int)$user_id);
				$this->db->where('campaign_id',(int)$campaign_id);
				$this->db->update('tbl_template_user', $edata);
			} else {
				$ndata = array('temp_id'=>0,'campaign_id'=>(int)$campaign_id,'temp_user'=>(int)$user_id,'temp_title'=>$data['title'],'temp_hide'=>$data['hide']?1:0);
				$this->db->insert('tbl_template_user', $ndata);
			}
		}
		unset($data['title']);
		
		
		$ndata = array();
		$udata = array();
		$new = 0;
		foreach($data as $key => $value)
		{
			if($key == 'new')
			{
				
				foreach($value as $kk => $vval)
				{	
					//print_r($vval); exit;
					$ndata[$new]['heading'] = $vval['heading'];
					$ndata[$new]['value'] = $vval['value'];
					$ndata[$new]['campaign_id'] = (int)$campaign_id;
					$ndata[$new]['namedrop'] = $vval['namedrop'];
					$ndata[$new]['campaign_id'] = (int)$campaign_id;
					$new++;
				}
			}
			else
			{
				$udata[$key]['heading'] = $value['heading'];
				$udata[$key]['value'] = $value['value'];
				$udata[$key]['companyid'] = $value['companyid'];
				$udata[$key]['namedrop'] = $value['namedrop'];
			}
		}
		//$count= 0;
		//print_r($ndata); exit;
		if(!empty($ndata))
		{
		foreach($ndata as $key => $dat)
		{
			//print_r($ndata); exit;
			$this->db->insert('tbl_pro_custom', $dat);
		}
		}
		if(!empty($udata))
		{
		foreach($udata as $key => $dat)
		{
			$this->db->where('id',(int)$key);
			$this->db->update('tbl_pro_custom', $dat);
		}
		}
		//echo $count;
		//exit;
			//exit;
	}	
	
	/**
	 *   return campaign meta data from campain table
	 */
	public function getCampaignMetadata($active_campaign,$key)
	{
	
		$this->db->where('campaign_id',$active_campaign);
		$this->db->where('field_type',$key);
		$getvalue = $this->db->get($this->_table_campaign_comm);
		//print_r($getvalue); exit;
		// echo $this->db->last_query();
		if($getvalue->num_rows > 0)
		{
			return $getvalue->row();
		}
		return false;
	}
	
	public function getCampaignCustomdata($active_campaign)
	{
		/*//By Dev@489
		if(!$active_campaign) return array();//redirect(base_url() . 'folder/my-folder');
		////
		$this->db->select('*');
		$this->db->from('tbl_pro_custom');		
		$this->db->where('campaign_id',$active_campaign);
		$this->db->order_by("campaign_id","asc");
		$get_value = $this->db->get();
		//echo $active_campaign;
		//print_r($get_value->result()); exit;
		return $get_value->result();*/
		//By Dev@489
		if(!$active_campaign) return array();//redirect(base_url() . 'folder/my-folder');
		$user_id =  $_SESSION['ss_user_id'];
		//get active company
		/*$active_company=0;
		$this->db->select('company_id');
		$this->db->where('user_id',$user_id);
		$this->db->where('status',1);
		$this->db->from($this->_table_company);
		$query = $this->db->get();
		$act_company = $query->result();
		if(!$act_company) {
			$this->db->select('company_id');
			$this->db->where('user_id',$user_id);
			$this->db->from($this->_table_company);
			$query = $this->db->get();
			$act_company = $query->result();
		}
		if($act_company)
		foreach($act_company as $cmp) {
			$active_company=$cmp->company_id;break;
		}*/
		//get active name drop
		/*$active_namedrop=0;
		$this->db->select('c_id');
		$this->db->where('user_id',$user_id);
		$this->db->where('status',1);
		$this->db->from($this->_table_credibility);
		$query = $this->db->get();
		$act_namedrops = $query->result();
		if(!$act_namedrops) {
			$this->db->select('c_id');
			$this->db->where('user_id',$user_id);
			$this->db->from($this->_table_credibility);
			$query = $this->db->get();
			$act_namedrops = $query->result();
		}
		if($act_namedrops)
		foreach($act_namedrops as $ndrop) {
			$active_namedrop=$ndrop->c_id;break;
		}*/		
		//get custom content data from Campain, Company, Name drop
		$this->db->select('*');
		$this->db->from('tbl_pro_custom');
		$this->db->where('campaign_id',$active_campaign);
		/*$this->db->where('companyid',$active_company);
		$this->db->where('namedrop',$active_namedrop);*/
		$this->db->order_by("id","asc");
		$get_value = $this->db->get();
		$customcontent = $get_value->result();		
		/*if(!$customcontent) {
			$this->db->select('*');
			$this->db->from('tbl_pro_custom');
			$this->db->where('campaign_id',$active_campaign);
			$this->db->where('(companyid=0 or namedrop=0)');
			$this->db->order_by("id","asc");
			$get_value = $this->db->get();
			$customcontent = $get_value->result();			
		}*/
		return $customcontent;
		////
	}
	/**
	 *   Get public function 
	 */
	public function getBusinessValue($tech_v_id)
	{
		$this->db->where('tech_v_id',$tech_v_id);
		$getvalue = $this->db->get($this->_table_biz_value);
		if($getvalue->num_rows > 0)
		{
			return $getvalue->result();
		}
		return false;
	}
	
	public function getBizValueOrphan($campaign_id)
	{
		$this->db->where('tech_v_id',NULL);
		$this->db->where('campaign_id',$campaign_id);
		$getvalue = $this->db->get($this->_table_biz_value);
		// echo $this->db->last_query();
		
		if($getvalue->num_rows > 0)
		{
			return $getvalue->result();
		}
		return false;
	}
	/**
	 *   all business 
	 */
	
	public function getAllBizVal($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$getvalue = $this->db->get($this->_table_biz_value);
		if($getvalue->num_rows > 0)
		{
			return $getvalue->result();
		}
		return false;
		
	}
	
	/**
	 *  Get Personal value Q/A with business value Q/A 
	 *  
	 *  @params interger $campaign_id
	 */
	function getPersonalValue($campaign_id)
	{
	
		$this->db->select('tbl_per_value.biz_v_id as pers_biz_id, 
							tbl_per_value.per_v_id as pers_id,
							tbl_per_value.field_type as pers_key, 
							tbl_per_value.value as per_val,
							tbl_biz_value.biz_v_id as biz_id,
							tbl_biz_value.field_type as biz_key, 
							tbl_biz_value.value as biz_val,
							tbl_biz_value.campaign_id as biz_cm_id
							');
		$this->db->from('tbl_biz_value');
		$this->db->join('tbl_per_value','tbl_per_value.biz_v_id= tbl_biz_value.biz_v_id');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	/**
	 *  Get Personal value Q/A With Technical Value
	 *  
	 *  @params integer $campaign_id
	 */
	function getTechPersValData($campaign_id)
	{
		$this->db->select('tbl_per_value.biz_v_id as pers_biz_id, 
							tbl_per_value.per_v_id as pers_id,
							tbl_per_value.field_type as pers_key, 
							tbl_per_value.value as per_val,
							tbl_tech_value.tech_v_id as tech_id,
							tbl_tech_value.field_type as tech_key, 
							tbl_tech_value.value as tech_val,
							tbl_tech_value.campaign_id as tech_cm_id
							');
		$this->db->from('tbl_per_value');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id= tbl_per_value.tech_v_id');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	/**
	 *   get orphan personal value
	 */
	function getOrphanPersonalValue($campaign_id)
	{
		$this->db->select('tbl_per_value.biz_v_id as pers_biz_id, 
							tbl_per_value.per_v_id as pers_id,
							tbl_per_value.field_type as pers_key, 
							tbl_per_value.value as per_val
							');
		$this->db->from('tbl_per_value');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		$this->db->where('tbl_per_value.biz_v_id',NULL);
		$this->db->where('tbl_per_value.tech_v_id',NULL);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	/**
	 *   geting technical benefit and technical pain join result for which have parent key 
	 */
	public function getTechValuePain($campaign_id)
	{
		$this->db->select(' tbl_tech_value.tech_v_id as tech_val_id,
							tbl_tech_value.field_type as tech_val_key, 
							tbl_tech_value.value as tech_benefit_val,
							tbl_tech_pain.tech_p_id as tech_pain_id,
							tbl_tech_pain.field_type as tech_pain_key, 
							tbl_tech_pain.value as tech_pain_val,
							tbl_tech_pain.campaign_id as tech_pain_cm_id,
							tbl_tech_pain.qus_id,
							tbl_tech_pain.visible,
							tbl_tech_pain.highlight
							');
		$this->db->from('tbl_tech_pain');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_tech_pain.tech_v_id');
		$this->db->where('tbl_tech_pain.campaign_id',$campaign_id);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	/**
	 *   geting technical benefit and technical pain join result for which have orphan 
	 */
	public function getTechValuePainOrph($campaign_id)
	{
		$this->db->select(' tbl_tech_pain.tech_p_id as tech_pain_id,
							tbl_tech_pain.field_type as tech_pain_key, 
							tbl_tech_pain.value as tech_pain_val,
							tbl_tech_pain.campaign_id as tech_pain_cm_id,
							tbl_tech_pain.qus_id,
							tbl_tech_pain.visible,
							tbl_tech_pain.highlight
							');
		$this->db->from('tbl_tech_pain');
		$this->db->where('tbl_tech_pain.campaign_id',$campaign_id);
		$this->db->where('tbl_tech_pain.tech_v_id',NULL);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	/**
	 *   geting bussiness benefit and bussiness pain join result for which have parent 
	 */
	public function getBusValuePain($campaign_id)
	{
		$this->db->select(' tbl_biz_value.biz_v_id as biz_val_id,
							tbl_biz_value.field_type as biz_val_key, 
							tbl_biz_value.value as biz_benefit_val,
							tbl_biz_pain.biz_p_id as biz_pain_id,
							tbl_biz_pain.field_type as biz_pain_key, 
							tbl_biz_pain.value as biz_pain_val,
							tbl_biz_pain.campaign_id as biz_pain_cm_id
							');
		$this->db->from('tbl_biz_pain');
		$this->db->join('tbl_biz_value','tbl_biz_value.biz_v_id = tbl_biz_pain.biz_v_id');
		$this->db->where('tbl_biz_pain.campaign_id',$campaign_id);
		$record = $this->db->get();
		//  echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	/**
	 *   geting bussiness benefit and bussiness pain join result for which have parent 
	 */
	public function getBusValuePainOrph($campaign_id)
	{
		$this->db->select(' tbl_biz_pain.biz_p_id as biz_pain_id,
							tbl_biz_pain.field_type as biz_pain_key, 
							tbl_biz_pain.value as biz_pain_val,
							tbl_biz_pain.campaign_id as biz_pain_cm_id
							');
		$this->db->from('tbl_biz_pain');
		$this->db->where('tbl_biz_pain.campaign_id',$campaign_id);
		$this->db->where('tbl_biz_pain.biz_v_id',NULL);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}

	/**
	 *   geting personal benefit and personal pain join result for which have parent 
	 */
	public function getPerValuePain($campaign_id)
	{
		$this->db->select(' tbl_per_value.per_v_id as per_val_id,
							tbl_per_value.field_type as per_val_key, 
							tbl_per_value.value as per_benefit_val,
							tbl_per_pain.per_p_id as per_pain_id,
							tbl_per_pain.field_type as per_pain_key, 
							tbl_per_pain.value as per_pain_val,
							tbl_per_pain.campaign_id as per_pain_cm_id
							');
		$this->db->from('tbl_per_pain');
		$this->db->join('tbl_per_value','tbl_per_value.per_v_id = tbl_per_pain.per_v_id');
		$this->db->where('tbl_per_pain.campaign_id',$campaign_id);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}

	/**
	 *   geting personal benefit and personal pain join result for which have orphan 
	 */
	public function getPerValuePainOrph($campaign_id)
	{
		$this->db->select('	tbl_per_pain.per_p_id as per_pain_id,
							tbl_per_pain.field_type as per_pain_key, 
							tbl_per_pain.value as per_pain_val,
							tbl_per_pain.campaign_id as per_pain_cm_id
							');
		$this->db->from('tbl_per_pain');
		$this->db->where('tbl_per_pain.campaign_id',$campaign_id);
		$this->db->where('tbl_per_pain.per_v_id',NULL);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	public function deleteCampaign($campaign_id,$c_user_id,$isdelete=0)
	{
		//Move to trash
		if($isdelete==0) {
			$upd = array('trash' => 1);
			$this->db->where('user_id',$c_user_id);
			$this->db->where('campaign_id',$campaign_id);
			$this->db->update($this->_table_campaign,$upd);
			return true;
		}
		//Restore
		if($isdelete==2) {
			$upd = array('trash' => 0);
			$this->db->where('user_id',$c_user_id);
			$this->db->where('campaign_id',$campaign_id);
			$this->db->update($this->_table_campaign,$upd);
			//echo $this->db->last_query();
			return true;
		}
		$this->db->where('user_id',$c_user_id);
		$this->db->where('campaign_id',$campaign_id);
		//By Dev@4489
		//return $this->db->delete($this->_table_campaign);	
		$delRes = $this->db->delete($this->_table_campaign);	
		if($delRes) {
			$this->db->where('ob_campaign', $campaign_id);
			$this->db->delete('tbl_objections');
			//delete camapaign custom data
			$this->db->where('campaign_id', $campaign_id);
			$this->db->delete('tbl_pro_custom');
			//delete question
			//1. Technical
			$this->db->where('campaign_id',$campaign_id);
			$this->db->delete('tbl_tech_qualify');
			//2. Business
			$this->db->where('campaign_id',$campaign_id);
			$this->db->delete('tbl_biz_qualify');
			//3. Personal
			$this->db->where('campaign_id',$campaign_id);
			$this->db->delete('tbl_per_qualify');
			//delete question responses
			$this->db->where('qr_cid',$campaign_id);
			$this->db->delete('tbl_qualify_response');
			//delete template titles
			$this->db->where('campaign_id',$campaign_id);
			$this->db->where('temp_user',$c_user_id);
			$this->db->delete('tbl_template_user');
			//delete template section contents
			$this->db->where('userid',$c_user_id);
			$this->db->where('campaign_id',$campaign_id);
			$this->db->delete('tbl_template_content');
		}		
		return $delRes;
		////
	}
	/**
	 *  get technical qualify and pain which have parent
	 */
	public function getTechQualifyPain($campaign_id,$type)
	{
		$this->db->select(' tbl_tech_qualify.tech_q_id as tech_qualify_id,
							tbl_tech_qualify.field_type as tech_qualify_key, 
							tbl_tech_qualify.value as tech_qualify_val,
							tbl_tech_qualify.campaign_id as tech_qualify_cm_id,
							tbl_tech_pain.tech_p_id as tech_pain_id,
							tbl_tech_pain.field_type as tech_pain_key, 
							tbl_tech_pain.value as tech_pain_val, 
							tbl_tech_qualify.qus_id,
							tbl_tech_qualify.visible,
							tbl_tech_qualify.highlight
							');
		$this->db->from('tbl_tech_qualify');
		$this->db->join('tbl_tech_pain','tbl_tech_pain.tech_p_id = tbl_tech_qualify.tech_p_id');
		$this->db->where('tbl_tech_qualify.campaign_id',$campaign_id);
		$this->db->order_by("tbl_tech_qualify.qus_id","asc");//by Dev@4489
		$record = $this->db->get();
		//echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	public function getTechQualify($campaign_id)
	{
		$this->db->select(' tbl_tech_qualify.tech_q_id as tech_qualify_id,
							tbl_tech_qualify.field_type as tech_qualify_key, 
							tbl_tech_qualify.value as tech_qualify_val,
							tbl_tech_qualify.campaign_id as tech_qualify_cm_id,
							tbl_tech_qualify.qus_id,
							tbl_tech_qualify.visible,
							tbl_tech_qualify.highlight
							');
		$this->db->from('tbl_tech_qualify');
		$this->db->where('tbl_tech_qualify.campaign_id',$campaign_id);
		$this->db->order_by("tbl_tech_qualify.qus_id","asc");//by Dev@4489
		$record = $this->db->get();
		//echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	/**
	 *   Techinical qualify quation with pain which have no parent
	 */
	public function getTechQualifyPainOrph($campaign_id)
	{
		$this->db->select(' tbl_tech_qualify.tech_q_id as tech_qualify_id,
							tbl_tech_qualify.field_type as tech_qualify_key, 
							tbl_tech_qualify.value as tech_qualify_val,
							tbl_tech_qualify.campaign_id as tech_qualify_cm_id, 
							tbl_tech_qualify.qus_id, 
							tbl_tech_qualify.q_col,
							tbl_tech_qualify.visible,
							tbl_tech_qualify.highlight
							');
		$this->db->from('tbl_tech_qualify');
		$this->db->where('tbl_tech_qualify.campaign_id',$campaign_id);
		$this->db->where('tbl_tech_qualify.tech_p_id',NULL);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	/**
	 *  Get business qualify and pain which have parent
	 */
	public function getBusQualifyPain($campaign_id)
	{
		$this->db->select(' tbl_biz_qualify.biz_q_id as biz_qualify_id,
							tbl_biz_qualify.field_type as biz_qualify_key, 
							tbl_biz_qualify.value as biz_qualify_val,
							tbl_biz_qualify.campaign_id as biz_qualify_cm_id,
							tbl_biz_pain.biz_p_id as biz_pain_id,
							tbl_biz_pain.field_type as biz_pain_key, 
							tbl_biz_pain.value as biz_pain_val
							');
		$this->db->from('tbl_biz_qualify');
		$this->db->join('tbl_biz_pain','tbl_biz_pain.biz_p_id = tbl_biz_qualify.biz_p_id');
		$this->db->where('tbl_biz_qualify.campaign_id',$campaign_id);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	/**
	 *  Get business qualify and pain which have no parent
	 */
	public function getBusQualifyPainOrph($campaign_id)
	{
		$this->db->select(' tbl_biz_qualify.biz_q_id as biz_qualify_id,
							tbl_biz_qualify.field_type as biz_qualify_key, 
							tbl_biz_qualify.value as biz_qualify_val,
							tbl_biz_qualify.campaign_id as biz_qualify_cm_id
							');
		$this->db->from('tbl_biz_qualify');
		$this->db->where('tbl_biz_qualify.campaign_id',$campaign_id);
		$this->db->where('tbl_biz_qualify.biz_p_id',NULL);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	/**
	 *  Personal qualify with pain which have parent    
	 */
	public function getPerQualifyPain($campaign_id)
	{
		$this->db->select(' tbl_per_qualify.per_q_id as per_qualify_id,
							tbl_per_qualify.field_type as per_qualify_key, 
							tbl_per_qualify.value as per_qualify_val,
							tbl_per_qualify.campaign_id as per_qualify_cm_id,
							tbl_per_pain.per_p_id as per_pain_id,
							tbl_per_pain.field_type as per_pain_key, 
							tbl_per_pain.value as per_pain_val
							');
		$this->db->from('tbl_per_qualify');
		$this->db->join('tbl_per_pain','tbl_per_pain.per_p_id = tbl_per_qualify.per_p_id');
		$this->db->where('tbl_per_qualify.campaign_id',$campaign_id);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	
	/**
	 *  Personal qualify with pain which have no parent    
	 */
	public function getPerQualifyPainOrph($campaign_id)
	{
		$this->db->select(' tbl_per_qualify.per_q_id as per_qualify_id,
							tbl_per_qualify.field_type as per_qualify_key, 
							tbl_per_qualify.value as per_qualify_val,
							tbl_per_qualify.campaign_id as per_qualify_cm_id
							');
		$this->db->from('tbl_per_qualify');
		$this->db->where('tbl_per_qualify.campaign_id',$campaign_id);
		$this->db->where('tbl_per_qualify.per_p_id',NULL);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}

	/**
	 *   find active campaign for current user if not then return last campaign 
	 */
	function get_campaign_active($user_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('status','1');
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_campaign);
		// echo $this->db->last_query();
		if($query->num_rows > 0){
			return $query->row();
		}else{
			$this->db->where('user_id',$user_id);
			$this->db->where('trash',0);
			$this->db->order_by('campaign_id DESC');
			$this->db->limit(1);
			$query2 = $this->db->get($this->_table_campaign);
			// echo $this->db->last_query();
			if($query2->num_rows > 0){
				return $query2->row();
			}else{
				return false;
			}
		}
	}

	/**
	 *   get all technical value of a campaign
	 */
	public function getOutputTechValue($campaign_id,$show=0)
	{
		$this->db->where('campaign_id',$campaign_id);
		if($show) $this->db->where('visible',$show);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$query = $this->db->get($this->_table_tech_value);
		
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	
	}

	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputBizValue($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_biz_value);
		
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	
	}

	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputPerValue($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_per_value);
		
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	
	}

	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputTechPain($campaign_id,$show=0)
	{
		$this->db->where('campaign_id',$campaign_id);
		if($show) $this->db->where('visible',$show);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$query = $this->db->get($this->_table_tech_pain);
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	}
	
	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputBizPain($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_biz_pain);
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	}
	
	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputPerPain($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_per_pain);
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	}
	
	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputTechQualify($campaign_id,$show=0)
	{
		$this->db->where('campaign_id',$campaign_id);
		if($show) $this->db->where('visible',$show);
		$query = $this->db->get($this->_table_tech_qualify);
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	}
	
	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputBizQualify($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_biz_qualify);
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	}
	
	/**
	 *   get all personal value of a campaign
	 */
	public function getOutputPerQualify($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_per_qualify);
		if($query->num_rows > 0){
			return $query->result();
		}
		return false;
	}
	
	/**
	 *   Business value with Technical value
	 */
	function get_busWithTech_value($campaign_id){
	
		$this->db->select(' tbl_biz_value.biz_v_id as biz_v_id,
							tbl_biz_value.field_type as biz_pain_key, 
							tbl_biz_value.value as biz_value_val,
							tbl_biz_value.campaign_id as biz_value_cm_id,
							tbl_tech_value.tech_v_id as tech_v_id,
							tbl_tech_value.field_type as tech_value_key,
							tbl_tech_value.value as tech_val
							');
		$this->db->from('tbl_biz_value');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_biz_value.tech_v_id');
		$this->db->where('tbl_biz_value.campaign_id',$campaign_id);
		
		$record = $this->db->get();
		 // echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	/**
	 *   Personal value with Technical value
	 */
	function get_persWithTech_value($campaign_id){
	
		$this->db->select(' tbl_per_value.per_v_id as per_v_id,
							tbl_per_value.field_type as per_value_key, 
							tbl_per_value.value as per_value_val,
							tbl_per_value.campaign_id as per_value_cm_id,
							tbl_tech_value.tech_v_id as tech_v_id,
							tbl_tech_value.field_type as tech_value_key,
							tbl_tech_value.value as tech_val
							');
		$this->db->from('tbl_per_value');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_per_value.tech_v_id');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		
		$record = $this->db->get();
		 // echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	/**
	 *   Personal value with Technical value
	 */
	function get_persWithbiz_value($campaign_id){
	
		$this->db->select(' tbl_per_value.biz_v_id as per_v_id,
							tbl_per_value.field_type as per_value_key, 
							tbl_per_value.value as per_value_val,
							tbl_per_value.campaign_id as per_value_cm_id,
							tbl_biz_value.tech_v_id as biz_v_id,
							tbl_biz_value.field_type as biz_value_key,
							tbl_biz_value.value as biz_val
							');
		$this->db->from('tbl_per_value');
		$this->db->join('tbl_biz_value','tbl_biz_value.biz_v_id = tbl_per_value.biz_v_id');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	
	/**
	 *   Personal value with Technical value
	 */
	function get_persWithbizWithtech_value($campaign_id){
	
		$this->db->select(' tbl_per_value.biz_v_id as per_v_id,
							tbl_per_value.field_type as per_value_key, 
							tbl_per_value.value as per_value_val,
							tbl_per_value.campaign_id as per_value_cm_id,
							tbl_biz_value.tech_v_id as biz_v_id,
							tbl_biz_value.field_type as biz_value_key,
							tbl_biz_value.value as biz_val,
							tbl_tech_value.tech_v_id as tech_v_id,
							tbl_tech_value.field_type as tech_value_key,
							tbl_tech_value.value as tech_val
							');
		$this->db->from('tbl_per_value');
		$this->db->join('tbl_biz_value','tbl_biz_value.biz_v_id = tbl_per_value.biz_v_id');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_biz_value.tech_v_id');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	/**
	 *   Business value with Technical value
	 */
	function get_busvalWithTechvalue_techpain($campaign_id){
	
		$this->db->select(' tbl_biz_value.biz_v_id as biz_v_id,
							tbl_biz_value.field_type as biz_pain_key, 
							tbl_biz_value.value as biz_value_val,
							tbl_biz_value.campaign_id as biz_value_cm_id,
							tbl_tech_value.tech_v_id as tech_v_id,
							tbl_tech_value.field_type as tech_value_key,
							tbl_tech_value.value as tech_val,
							tbl_tech_pain.tech_v_id as tech_p_id,
							tbl_tech_pain.field_type as tech_pain_key,
							tbl_tech_pain.value as tech_pain_val
							');
		$this->db->from('tbl_biz_value');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_biz_value.tech_v_id');
		$this->db->join('tbl_tech_pain','tbl_tech_value.tech_v_id = tbl_tech_pain.tech_v_id');
		$this->db->where('tbl_biz_value.campaign_id',$campaign_id);
		
		$record = $this->db->get();
		 // echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	
	/**
	 *   Business value with Technical value
	 */
	function get_busvalWithTechvalue_bizpain($campaign_id){
	
		$this->db->select(' tbl_biz_value.biz_v_id as biz_v_id,
							tbl_biz_value.field_type as biz_pain_key, 
							tbl_biz_value.value as biz_value_val,
							tbl_biz_value.campaign_id as biz_value_cm_id,
							tbl_tech_value.tech_v_id as tech_v_id,
							tbl_tech_value.field_type as tech_value_key,
							tbl_tech_value.value as tech_val,
							tbl_biz_pain.biz_p_id as biz_p_id,
							tbl_biz_pain.field_type as biz_pain_key,
							tbl_biz_pain.value as biz_pain_val
							');
		$this->db->from('tbl_biz_value');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_biz_value.tech_v_id');
		$this->db->join('tbl_biz_pain','tbl_biz_value.biz_v_id = tbl_biz_pain.biz_v_id');
		$this->db->where('tbl_biz_value.campaign_id',$campaign_id);
		
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	
	/**
	 *   Personal value with Technical value
	 */
	function get_perspainWithTech_valueWithper_value($campaign_id){
	
		$this->db->select(' tbl_per_value.per_v_id as per_v_id,
							tbl_per_value.field_type as per_value_key, 
							tbl_per_value.value as per_value_val,
							tbl_per_value.campaign_id as per_value_cm_id,
							tbl_tech_value.tech_v_id as tech_v_id,
							tbl_tech_value.field_type as tech_value_key,
							tbl_tech_value.value as tech_val,
							tbl_per_pain.per_p_id as per_p_id,
							tbl_per_pain.field_type as per_pain_key,
							tbl_per_pain.value as per_pain_val
							');
		$this->db->from('tbl_per_value');
		$this->db->join('tbl_tech_value','tbl_tech_value.tech_v_id = tbl_per_value.tech_v_id');
		$this->db->join('tbl_per_pain','tbl_per_value.per_v_id = tbl_per_pain.per_v_id');
		$this->db->where('tbl_per_value.campaign_id',$campaign_id);
		
		$record = $this->db->get();
		// echo $this->db->last_query();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return array();
	}
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getBusinessPainWithValueID($biz_v_id){
	
			$this->db->where('biz_v_id',$biz_v_id);
			$query = $this->db->get($this->_table_biz_pain);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	
	}
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getBusinessQualifyWithPainID($biz_p_id){
	
			$this->db->where('biz_p_id',$biz_p_id);
			$query = $this->db->get($this->_table_biz_qualify);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	}
	
	
	
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getTechPainWithValueID($tech_v_id){
	
			$this->db->where('tech_v_id',$tech_v_id);
			$query = $this->db->get($this->_table_tech_pain);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	}
	
	
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getTechQualifyWithPainID($tech_p_id){
	
			$this->db->where('tech_p_id',$tech_p_id);
			$query = $this->db->get($this->_table_tech_qualify);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	}
	
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getPerValueWithBizValueID($biz_v_id){
	
			$this->db->where('biz_v_id',$biz_v_id);
			$query = $this->db->get($this->_table_per_value);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	}
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getPerPainWithValueID($per_v_id){
	
			$this->db->where('per_v_id',$per_v_id);
			$query = $this->db->get($this->_table_per_pain);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	}
	
	
	
	/**
	 *  get business pain record with biz_v_id
	 */
	public function getPerQualifyWithPainID($per_p_id){
	
			$this->db->where('per_p_id',$per_p_id);
			$query = $this->db->get($this->_table_per_qualify);
	        if($query->num_rows > 0){
				return $query->result();
			}
			return array();
	}
	/**
	 *  get campaign data with campaign_id
	 */
	public function getCampaignWithID($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_campaign);
		if($query->num_rows > 0){
			return $query->result();
		}
		return array();
	}
	
	/**
	 *  get campaign data with campaign_id
	 */
	public function getCampaignMetadataWithID($campaign_id)
	{
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_campaign_comm);
		if($query->num_rows > 0){
			return $query->result();
		}
		return array();
	}
	
	public function deleteCampaignCustomdata($campaign_id, $id_dev)
	{
		$this->db->where('campaign_id', $campaign_id);
		$this->db->where('id', $id_dev);
		return $this->db->delete('tbl_pro_custom');
	}
	
	/**
	*	get all product with product id
	*/	
    public function get_products_by_ProductId($product_id) 
    {
    	$this->db->where('product_id', $product_id);
		$this->db->where('trash',0);
    	$query = $this->db->get($this->_table_products);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
		return array();
    }
	
	/**
	 *   get  product info  
	 */
	public function getProductinfo($product_id)
	{
		$this->db->where('product_id',$product_id);
		$record = $this->db->get($this->_table_product_data);
		if($record->num_rows > 0)
		{
			return $record->result();
		}
	     return false;
	}
	
	/**
	 *  add new product in product table
	 *  
	 *  @params array $data all key value for product table data
	 */
    public function add_own_products($data) 
    {
 		$this->db->insert($this->_table_products, $data);
 		return $this->db->insert_id();
    }
	
	/**
	 *  add new product in product table
	 *  
	 *  @params array $data all key value for product table data
	 */
    public function add_own_products_data($data) 
    {
 		$this->db->insert($this->_table_product_data, $data);
 		return $this->db->insert_id();
    }
	
	
	/**
	 *  copy campaign from friend to logged in user campaign account
	 */
	public function copyCampaignToMyFolder($campaign_id,$user_id,$clone=0)
	{
		
		$current_user_id = $_SESSION['ss_user_id'];
		// find campain data and meta data and save
		$allCampaign = $this->getCampaignWithID($campaign_id);
		
		if(!empty($allCampaign)){ 
			$allCampaignMetadata = $this->getCampaignMetadataWithID($campaign_id);
			// first need to copy product also which are related to this copy campaign
			$get_all_products = $this->get_products_by_ProductId($allCampaign[0]->product_id);
			$product_id = 0;
			if($clone) $product_id = $allCampaign[0]->product_id;
			if(!empty($get_all_products ) && $clone==0){
			//if(!empty($get_all_products )){
				$getProductsAllMetadata  = $this->getProductinfo($allCampaign[0]->product_id);
				$data = array('user_id'=> $current_user_id, 'product_name'=> $get_all_products[0]->product_name);
				$product_id = $this->add_own_products($data);
				// var_dump($product_id); die();
				
				foreach ($getProductsAllMetadata  as $products_data)
				{
					$product_data = array('product_id' => $product_id, 'field_type' => $products_data->field_type, 'value' => $products_data->value,'question_id' => $products_data->question_id,'Qus_status' => $products_data->Qus_status);
					$this->add_own_products_data($product_data);	
				}
			}
			
			$savacampaigndata = array(
									'campaign_name'=> $allCampaign[0]->campaign_name,
									'user_id'  => $current_user_id,
									'product_id' => $product_id,
									'individual' => $allCampaign[0]->individual,
									'organization' => $allCampaign[0]->organization,
									'campaign_target' => $allCampaign[0]->campaign_target,
									'status' =>  $allCampaign[0]->status,
									'progress_data' =>  $allCampaign[0]->progress_data
								);
			
			$this->db->insert($this->_table_campaign,$savacampaigndata);
			$new_Campaign_id = $this->db->insert_id();
			foreach($allCampaignMetadata as $singleCamMetadata)
			{
				$saveCampaignMeta = array(
										'campaign_id' => $new_Campaign_id,
										'field_type' => $singleCamMetadata->field_type,
										'value' => $singleCamMetadata->value
									);
				$this->db->insert($this->_table_campaign_comm,$saveCampaignMeta);
			}
			
			$this->copyTechValue($campaign_id,$new_Campaign_id);
			
			// now copy all orphan records
			$this->copyBizValueOrphan($campaign_id,$new_Campaign_id);
			$this->copyBizPainOrphan($campaign_id,$new_Campaign_id);
			$this->copyBizQualifyOrphan($campaign_id,$new_Campaign_id);
			$this->copyPerValueOrphan($campaign_id,$new_Campaign_id);
			$this->copyPerPainOrphan($campaign_id,$new_Campaign_id);
			$this->copyPerQualifyOrphan($campaign_id,$new_Campaign_id);
			$this->copyTechPainOrphan($campaign_id,$new_Campaign_id);
			$this->copyTechQualifyOrphan($campaign_id,$new_Campaign_id);
			$this->copyCustomContent($campaign_id,$new_Campaign_id);
			//By Dev@4489
			//copy objections
			$this->copyCustomobjections($campaign_id,$new_Campaign_id);
			$this->copyEtemplateContent($campaign_id,$new_Campaign_id);
			////
			
			
		}		
	}
	
	/**
	 *   copy technical value in current user campaign
	 */
	public function copyTechValue($campaign_id,$newcampainID)
	{
		// find all tech value
		$all_tech_value = $this->getTechValue($campaign_id);
		foreach($all_tech_value  as $singleValue)
		{
			$old_tech_v_id = $singleValue->tech_v_id;
			$save_data = array('campaign_id' => $newcampainID,'field_type' => 'tech_value' ,'qus_id' => $singleValue->qus_id, 'value' => $singleValue->value, 'visible' => $singleValue->visible, 'highlight' => $singleValue->highlight);
			$this->db->insert($this->_table_tech_value,$save_data);
			$new_tech_v_id = $this->db->insert_id();
			$this->copyBizValue($old_tech_v_id,$new_tech_v_id,$newcampainID);
			$this->copyTechPain($old_tech_v_id,$new_tech_v_id,$newcampainID);
		}
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyBizValue($old_tech_v_id,$new_tech_v_id,$newcampainID){
		
		// find all tech value
		$all_biz_value = $this->getBusinessValue($old_tech_v_id);
		foreach($all_biz_value  as $singleBizValue)
		{
			$old_biz_v_id = $singleBizValue->biz_v_id;
			$save_data = array('campaign_id' => $newcampainID,'tech_v_id' => $new_tech_v_id ,'field_type' => 'biz_value' ,'qus_id' => $singleBizValue->qus_id, 'value' => $singleBizValue->value);
			$this->db->insert($this->_table_biz_value,$save_data);
			$new_biz_v_id = $this->db->insert_id();
			$this->copyBizPain($old_biz_v_id,$new_biz_v_id,$newcampainID);
			$this->copyPerValue($old_biz_v_id,$new_biz_v_id,$newcampainID);
		}
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyBizPain($old_biz_v_id,$new_biz_v_id,$newcampainID){
		
		// find all tech value
		$all_pain_value = $this->getBusinessPainWithValueID($old_biz_v_id);
		foreach($all_pain_value  as $singleBizpain)
		{
			$old_biz_p_id = $singleBizpain->biz_p_id;
			$save_data = array('campaign_id' => $newcampainID,'biz_v_id' => $new_biz_v_id ,'field_type' => 'bus_pain' ,'qus_id' => $singleBizpain->qus_id, 'value' => $singleBizpain->value);
			$this->db->insert($this->_table_biz_pain,$save_data);
			$new_biz_p_id = $this->db->insert_id();
			$this->copyBizQualify($old_biz_p_id,$new_biz_p_id,$newcampainID);
		}
	
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyBizQualify($old_biz_p_id,$new_biz_p_id,$newcampainID){
		
		// find all tech value
		$all_pain_qualify = $this->getBusinessQualifyWithPainID($old_biz_p_id);
		foreach($all_pain_qualify  as $singleBizQualify)
		{
			$save_data = array('campaign_id' => $newcampainID,'biz_p_id' => $new_biz_p_id ,'field_type' => 'bus_qualify' , 'qus_id' => $singleBizQualify->qus_id, 'value' => $singleBizQualify->value);
			$this->db->insert($this->_table_biz_qualify,$save_data);
			$new_biz_q_id = $this->db->insert_id();
		}
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyTechPain($old_tech_v_id,$new_tech_v_id,$newcampainID){
		
		// find all tech value
		$all_tech_pain = $this->getTechPainWithValueID($old_tech_v_id);
		foreach($all_tech_pain  as $singleTachPain)
		{
			$old_tech_p_id = $singleTachPain->tech_p_id;
			$save_data = array('campaign_id' => $newcampainID,'tech_v_id' => $new_tech_v_id ,'field_type' => 'tech_pain' ,'qus_id' => $singleTachPain->qus_id, 'value' => $singleTachPain->value, 'visible' => $singleTachPain->visible, 'highlight' => $singleTachPain->highlight);
			$this->db->insert($this->_table_tech_pain,$save_data);
			$new_tech_p_id = $this->db->insert_id();
			$this->copyTechQualify($old_tech_p_id,$new_tech_p_id,$newcampainID);
		}
	
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyTechQualify($old_tech_p_id,$new_tech_p_id,$newcampainID){
		
		// find all tech value
		$all_tech_qualify = $this->getTechQualifyWithPainID($old_tech_p_id);
		
		// var_dump($all_tech_qualify);
		
		foreach($all_tech_qualify  as $singleTechQualify)
		{
			$save_data = array('campaign_id' => $newcampainID,'tech_p_id' => $new_tech_p_id ,'field_type' => 'tech_qualify' ,'qus_id' => $singleTechQualify->qus_id, 'value' => $singleTechQualify->value, 'visible' => $singleTechQualify->visible, 'highlight' => $singleTechQualify->highlight);
			// echo $this->_table_tech_qualify;
			$this->db->insert($this->_table_tech_qualify,$save_data);
			$new_tech_p_id = $this->db->insert_id();
			//copy qualify responses
			$old_tech_q_id = $singleTechQualify->tech_q_id;
			$campaign_id = $singleTechQualify->campaign_id;
			if($new_tech_p_id) $this->copyTechQualifyResponses($campaign_id,$newcampainID,$old_tech_q_id,$new_tech_p_id);
		}
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyPerValue($old_biz_v_id,$new_biz_v_id,$newcampainID){
		
		// find all tech value
		$all_per_value = $this->getPerValueWithBizValueID($old_biz_v_id);
		foreach($all_per_value  as $singlePerValue)
		{
			$old_per_v_id = $singlePerValue->per_v_id;
			$save_data = array('campaign_id' => $newcampainID,'biz_v_id' => $new_biz_v_id ,'field_type' => 'pers_value' ,'qus_id' => $singlePerValue->qus_id, 'value' => $singlePerValue->value);
			$this->db->insert($this->_table_per_value,$save_data);
			$new_per_v_id = $this->db->insert_id();
			$this->copyPerPain($old_per_v_id,$new_per_v_id,$newcampainID);
		}
	}
	
	/**
	 *  copy biz value data
	 */
	public function copyPerPain($old_per_v_id,$new_per_v_id,$newcampainID){
		
		// find all tech value
		$all_per_pain = $this->getPerPainWithValueID($old_per_v_id);
		foreach($all_per_pain as $singlePerPain)
		{
			$old_per_p_id = $singlePerPain->per_p_id;
			$save_data = array('campaign_id' => $newcampainID,'per_v_id' => $new_per_v_id ,'field_type' => 'pers_pain' , 'qus_id' => $singlePerPain->qus_id, 'value' => $singlePerPain->value);
			$this->db->insert($this->_table_per_pain,$save_data);
			$new_per_p_id = $this->db->insert_id();
			$this->copyPerQualify($old_per_p_id,$new_per_p_id,$newcampainID);
		}
	}
	/**
	 *  copy biz value data
	 */
	public function copyPerQualify($old_per_p_id,$new_per_p_id,$newcampainID){
		
		// find all tech value
		$all_per_qualify = $this->getPerQualifyWithPainID($old_per_p_id);
		foreach($all_per_qualify as $singlePerqualify)
		{
			$save_data = array('campaign_id' => $newcampainID,'per_p_id' => $new_per_p_id ,'field_type' => 'pers_qualify' , 'qus_id' => $singlePerqualify->qus_id,'value' => $singlePerqualify->value);
			$this->db->insert($this->_table_per_qualify,$save_data);
			$new_per_q_id = $this->db->insert_id();
		}
	}
	
	/**
	 *   copy orphan Business vallue 
	 */
	public function copyBizValueOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('tech_v_id' =>  NULL));
		 $query = $this->db->get($this->_table_biz_value);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanbizValue = $query->result();
		foreach($allorphanbizValue  as $singleBizValue)
		{
			$old_biz_v_id = $singleBizValue->biz_v_id;
			$save_data = array('campaign_id' => $newcampainID,'field_type' => 'biz_value' ,'qus_id' => $singleBizValue->qus_id, 'value' => $singleBizValue->value);
			$this->db->insert($this->_table_biz_value,$save_data);
			$new_biz_v_id = $this->db->insert_id();
			$this->copyBizPain($old_biz_v_id,$new_biz_v_id,$newcampainID);
			$this->copyPerValue($old_biz_v_id,$new_biz_v_id,$newcampainID);
		}
	}

	/**
	 *   copy orphan Business pain 
	 */
	public function copyBizPainOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('biz_v_id' =>  NULL));
		 $query = $this->db->get($this->_table_biz_pain);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanbizPain = $query->result();
		foreach($allorphanbizPain  as $singleBizPain)
		{
			$old_biz_p_id = $singleBizPain->biz_p_id ;
			$save_data = array('campaign_id' => $newcampainID,'field_type' => 'bus_pain' ,'qus_id' => $singleBizPain->qus_id, 'value' => $singleBizPain->value);
			$this->db->insert($this->_table_biz_pain,$save_data);
			$new_biz_p_id = $this->db->insert_id();
			$this->copyBizQualify($old_biz_p_id,$new_biz_p_id,$newcampainID);
			
		}
	}
	
	/**
	 *   copy orphan Business pain 
	 */
	public function copyBizQualifyOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('biz_p_id' =>  NULL));
		 $query = $this->db->get($this->_table_biz_qualify);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanbizQualify = $query->result();
		if(!empty($allorphanbizQualify)) {
			foreach($allorphanbizQualify  as $singleBizQualify)
			{
				$old_biz_q_id = $singleBizQualify->biz_q_id ;
				$save_data = array('campaign_id' => $newcampainID,'field_type' => 'bus_qualify' , 'qus_id' => $singleBizQualify->qus_id, 'value' => $singleBizQualify->value);
				$this->db->insert($this->_table_biz_qualify,$save_data);
				$new_biz_q_id = $this->db->insert_id();
				// $this->copyBizQualify($old_biz_p_id,$new_biz_p_id,$newcampainID);
			}
		}
	}
	
	/**
	 *   copy orphan Personal Value 
	 */
	public function copyPerValueOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('biz_v_id' =>  NULL));
		 $query = $this->db->get($this->_table_per_value);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanPerValue = $query->result();
		if(!empty($allorphanPerValue)) {
			foreach($allorphanPerValue  as $singlePerValue)
			{
				$old_per_v_id = $singlePerValue->per_v_id;
				$save_data = array('campaign_id' => $newcampainID,'field_type' => 'pers_value' ,'qus_id' => $singlePerValue->qus_id, 'value' => $singlePerValue->value);
				$this->db->insert($this->_table_per_value,$save_data);
				$new_per_v_id = $this->db->insert_id();
				$this->copyPerPain($old_per_v_id,$new_per_v_id,$newcampainID);
			}
		}
	}
	
	
	/**
	 *   copy orphan Personal pain 
	 */
	public function copyPerPainOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('per_v_id' =>  NULL));
		 $query = $this->db->get($this->_table_per_pain);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanPerPain = $query->result();
		if(!empty($allorphanPerPain)) {
			foreach($allorphanPerPain  as $singlePerPain)
			{
				$old_per_p_id = $singlePerPain->per_p_id;
				$save_data = array('campaign_id' => $newcampainID,'field_type' => 'pers_pain' , 'qus_id' => $singlePerPain->qus_id,'value' => $singlePerPain->value);
				$this->db->insert($this->_table_per_pain,$save_data);
				$new_per_p_id = $this->db->insert_id();
				$this->copyPerQualify($old_per_p_id,$new_per_p_id,$newcampainID);
			}
		}
	}
	
	/**
	 *   copy orphan Personal Value 
	 */
	public function copyPerQualifyOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('per_p_id' =>  NULL));
		 $query = $this->db->get($this->_table_per_qualify);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanPerQualify = $query->result();
		if(!empty($allorphanPerQualify)) {
			foreach($allorphanPerQualify  as $singlePerQualify)
			{
				$old_per_q_id = $singlePerQualify->per_q_id;
				$save_data = array('campaign_id' => $newcampainID,'field_type' => 'pers_qualify' ,'qus_id' => $singlePerQualify->qus_id, 'value' => $singlePerQualify->value);
				$this->db->insert($this->_table_per_qualify,$save_data);
				$new_per_q_id = $this->db->insert_id();
				// $this->copyPerQualify($old_per_p_id,$new_per_p_id,$newcampainID);
			}
		}
	}
	
	
	
	
	/**
	 *   Copy Custom Content Data 
	 */
	public function copyCustomContent($campaign_id,$newcampainID)
	{
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->order_by("id","asc");
		 $query = $this->db->get('tbl_pro_custom');
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allCustomContents = $query->result();
		if(!empty($allCustomContents)) {
			foreach($allCustomContents  as $singleCustomContent)
			{
				$save_data = array('campaign_id' => $newcampainID,'heading' => $singleCustomContent->heading ,'value' => $singleCustomContent->value);
				$this->db->insert('tbl_pro_custom',$save_data);
				$new_custom_id = $this->db->insert_id();
			}
		}
	}
	
	
	
	/**
	 *   copy orphan technical Value 
	 */
	public function copyTechPainOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('tech_v_id' =>  NULL));
		 $query = $this->db->get($this->_table_tech_pain);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanTechPain = $query->result();
		if(!empty($allorphanTechPain)) {
			foreach($allorphanTechPain  as $singleTechPain)
			{
				$old_tech_p_id = $singleTechPain->tech_p_id;
				$save_data = array('campaign_id' => $newcampainID,'field_type' => 'tech_pain' ,'qus_id' => $singleTechPain->qus_id, 'value' => $singleTechPain->value);
				$this->db->insert($this->_table_tech_pain,$save_data);
				$new_tech_p_id = $this->db->insert_id();
				$this->copyTechQualify($old_tech_p_id,$new_tech_p_id,$newcampainID);
			}
		}
	}
	
	/**
	 *   copy orphan technical Value 
	 */
	public function copyTechQualifyOrphan($campaign_id,$newcampainID)
	{
		//  find orphan biz value and then copy
		 $this->db->where('campaign_id',$campaign_id);
		 $this->db->where(array('tech_p_id' =>  NULL));
		 $query = $this->db->get($this->_table_tech_qualify);
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allorphanTechQualify = $query->result();
		if(!empty($allorphanTechQualify)) {
			foreach($allorphanTechQualify  as $singleTechQualify)
			{
				$old_tech_q_id = $singleTechQualify->tech_q_id;
				$save_data = array('campaign_id' => $newcampainID,'field_type' => 'tech_qualify' ,'qus_id' => $singleTechQualify->qus_id, 'value' => $singleTechQualify->value);
				$this->db->insert($this->_table_tech_qualify,$save_data);
				$new_tech_q_id = $this->db->insert_id();
				//copy qualify responses
				if($new_tech_q_id) $this->copyTechQualifyResponses($campaign_id,$newcampainID,$old_tech_q_id,$new_tech_q_id);
				
			}
		}
	}
	
	
	//Copy Campaign Qualify responses
	public function copyTechQualifyResponses($OCampaign,$NCampaign,$Oqid,$Nqid,$Oqparent=0,$Nqrsparent=0)
	{
		//  find response values and then copy
		$this->db->where('qr_cid',$OCampaign);
		$this->db->where('qr_qid',$Oqid);
		$this->db->where('qr_parent',$Oqparent);
		$this->db->order_by("qr_id","asc");
		$query = $this->db->get('tbl_qualify_response');
		if($query->num_rows == 0 ) return;
		$allQualifyResponses = $query->result();
		foreach($allQualifyResponses  as $sqResp1)
		{
			//left question
			$qresp_data1 = array('qr_cid' => $NCampaign, 'qr_qid' => $Nqid , 'qr_response' => $sqResp1->qr_response, 'qr_parent' => $Nqrsparent, 'qr_section' => $sqResp1->qr_section, 'qr_rstype' => $sqResp1->qr_rstype);
			$this->db->insert('tbl_qualify_response',$qresp_data1);
			$qresp_id1 = $this->db->insert_id();
			if($qresp_id1) {
				//right answer
				$sqResp2 = $this->getQualifyResponse($sqResp1->qr_id);
				if($sqResp2) {
					$qresp_data2 = array('qr_cid' => $NCampaign, 'qr_qid' => $Nqid , 'qr_response' => $sqResp2->qr_response, 'qr_parent' => $qresp_id1, 'qr_section' => $sqResp2->qr_section, 'qr_rstype' => $sqResp2->qr_rstype);
					$this->db->insert('tbl_qualify_response',$qresp_data2);
					$qresp_id2 = $this->db->insert_id();
					if($qresp_id2) $this->copyTechQualifyResponses($OCampaign,$NCampaign,$Oqid,$Nqid,$sqResp2->qr_id,$qresp_id2);
				}
			}
		}
	}
	
	//Copy Campaign Qualify responses
	public function getQualifyResponse($Oqrparent)
	{
		$this->db->where('qr_parent',$Oqrparent);
		$query = $this->db->get('tbl_qualify_response');
		return $query->row();
	}
	
	public function findSampleCampaignID()
	{
		$this->db->select('campaign_id , user_id');
		$this->db->where('sample','1');
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_campaign);
		if($query->num_rows > 0)
		{
			return $query->row();
		}else{
		
			return array();
		}
	}
	/**
	 *  find sample Company profile
	 */
	public function findSampleCompany()
	{
		$this->db->select('company_id , company_name, user_id');
		$this->db->where('sample','1');
		$this->db->where('trash',0);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('company_name','asc');
		$query = $this->db->get($this->_table_company);
		if($query->num_rows > 0)
		{
			return $query->row();
		}else{
		
			return array();
		}
	}
	/**
	 *   find default credibility product
	 */
	public function findSampleCredibility()
	{
		$this->db->select('c_id,credibility_name, user_id');
		$this->db->where('sample','1');
		$this->db->where('trash',0);
		$query = $this->db->get($this->_table_credibility);
		if($query->num_rows > 0)
		{
			return $query->row();
		}else{
			return array();
		}
	}
	//By Dev@4489
	
	//delete camapaign custom data
	public function deleteCampaignCustom($campaign_id,$cuserid)
	{
		//update campaign profile name
		/*$ccquery="update ".$this->_table_campaign." set profile_name='' where user_id=".(int)$cuserid." and campaign_id=".(int)$campaign_id;
		$this->db->query($ccquery);
		$this->db->flush_cache();*/
		//Delete custom campaign objections
		$this->db->where('ob_campaign', $campaign_id);
		$this->db->delete('tbl_objections');
		//delete camapaign custom data
		$this->db->where('campaign_id', $campaign_id);
		return $this->db->delete('tbl_pro_custom');
	}
	/**
	 *  get campaign custom contents
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 *  By Dev@4489
	 */
	function get_campaign_customcontents()
	{
		$user_id =  $_SESSION['ss_user_id'];
		/*$ccquery="select distinct tbl_pro_custom.campaign_id,campaigns.campaign_name,campaigns.profile_name from tbl_pro_custom 
			left join ".$this->_table_campaign." on campaigns.campaign_id = tbl_pro_custom.campaign_id 
			where campaigns.user_id=".$user_id."
		";*/
		$ccquery="select distinct tbl_pro_custom.campaign_id,campaigns.campaign_name from tbl_pro_custom 
			left join ".$this->_table_campaign." on campaigns.campaign_id = tbl_pro_custom.campaign_id 
			where campaigns.trash=0 and campaigns.user_id=".$user_id."
		";
		$ccrows=$this->db->query($ccquery);
		return $ccrows->result();
	}
	
	function get_uncampaign_customcontents()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$ccquery="select c.campaign_id, c.campaign_name from ".$this->_table_campaign." c 
			left join tbl_pro_custom pc on (pc.campaign_id=c.campaign_id) 
			where c.trash=0 and c.user_id=".$user_id." and pc.campaign_id is null order by c.campaign_name 
		";
		$ccrows=$this->db->query($ccquery);
		return $ccrows->result();
	}
	////
	
	//By Dev@4489
	//Get Drop name profiles
	function get_drop_name_profiles()
	{
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
		$this->db->where('user_id',$shuser);
		$this->db->where('trash',0);
		$this->db->order_by("sorder","asc");
		$this->db->order_by("credibility_name","asc");
		$query = $this->db->get($this->_table_credibility);
		$dropnames = $query->result();
		if($dropnames) {
			foreach($dropnames as $di=>$dnval) {
				$this->db->where('c_id',$dnval->c_id);
				$this->db->where('field_type','profile');
				$this->db->order_by("c_data_id","desc");
				$query = $this->db->get($this->_table_credibility_data);
				$cdrow = $query->row();
				if($cdrow) {
					$dnval->value=$cdrow->value;
					$dnval->c_data_id=$cdrow->c_data_id;
				}
				$dropnames[$di]=$dnval;
			}
			return $dropnames;
		}
		return array();
		/*$user_id =  $_SESSION['ss_user_id'];
		$ccquery="select c.*,ci.c_data_id,ci.value from ".$this->_table_credibility." c 
			left join ".$this->_table_credibility_data." ci on (ci.c_id=c.c_id and ci.field_type='profile') 
			where c.user_id=".$user_id." and c.trash=0 order by c.sorder,c.credibility_name 
		";
		$ccrows=$this->db->query($ccquery);
		return $ccrows->result();*/
	}
	/**
	 *  @brief Edit Drop profile name
	 */
	function edit_drop_prname($newname,$id,$cdid)
	{
		//Get creditibility profile value
		$this->db->select('c_data_id');
		$this->db->where('c_id',$id);
		$this->db->where('field_type','profile');
		$this->db->order_by("c_data_id","desc");
		$query = $this->db->get($this->_table_credibility_data);
		$cdrow = $query->row_array();
		$cdid = $cdrow['c_data_id'];
		if($cdid) {
			$updatedate = array('value' => $newname);
			$this->db->where('c_data_id',$cdid);
			$this->db->where('c_id',$id);
			$this->db->update($this->_table_credibility_data,$updatedate);		
			//update credibility name
			/*$user_id = $_SESSION['ss_user_id'];
			$updatedata = array('credibility_name' => $newname);
			$this->db->where('user_id',$user_id);
			$this->db->where('c_id',$id);
			$this->db->update($this->_table_credibility,$updatedata);*/
			return 1;
		} else {
			$save_data = array('c_id' => $id,'field_type' => 'profile' ,'value' => $newname);
			$this->db->insert($this->_table_credibility_data,$save_data);
			//update credibility name
			/*$user_id = $_SESSION['ss_user_id'];
			$updatedata = array('credibility_name' => $newname);
			$this->db->where('user_id',$user_id);
			$this->db->where('c_id',$id);
			$this->db->update($this->_table_credibility,$updatedata);*/
			return 1;
		}
	}
	////
	//By Dev@4489
	//Custom Content Objections
	//Get Campaign Objections
	public function getCampaignObjections($active_campaign)
	{
		if(!$active_campaign) return array();
		$this->db->select('*');
		$this->db->from('tbl_objections');
		$this->db->where('ob_campaign',$active_campaign);
		$this->db->order_by("ob_order","asc");
		$get_value = $this->db->get();
		return $get_value->result();
	}
	//Update campaign objections
	public function updateCampaignObjections($data, $campaign_id)
	{
		$ndata = array();
		$udata = array();
		$new = 0;
		foreach($data as $key => $value)
		{
			if($key == 'new')
			{
				
				foreach($value as $kk => $vval)
				{	
					//print_r($vval); exit;
					if($vval['ob_defid'] && $vval['ob_title'] && ($vval['ob_rsptitle1'] || $vval['ob_rsptitle2'] || $vval['ob_rsptitle3'] || $vval['ob_rspcontent1'] || $vval['ob_rspcontent2'] || $vval['ob_rspcontent3'])) {
						$ndata[$new]['ob_defid'] = (int)$vval['ob_defid'];
						$ndata[$new]['ob_title'] = $vval['ob_title'];
						$ndata[$new]['ob_order'] = $vval['ob_order'];
						$ndata[$new]['ob_rsptitle1'] = $vval['ob_rsptitle1'];
						$ndata[$new]['ob_rspcontent1'] = $vval['ob_rspcontent1'];
						$ndata[$new]['ob_rsptitle2'] = $vval['ob_rsptitle2'];
						$ndata[$new]['ob_rspcontent2'] = $vval['ob_rspcontent2'];
						$ndata[$new]['ob_rsptitle3'] = $vval['ob_rsptitle3'];
						$ndata[$new]['ob_rspcontent3'] = $vval['ob_rspcontent3'];
						$ndata[$new]['ob_campaign'] = (int)$campaign_id;
						$new++;
					}
				}
			}
			else
			{
				$udata[$key]['ob_title'] = $value['ob_title'];
				$udata[$key]['ob_order'] = $value['ob_order'];
				$udata[$key]['ob_rsptitle1'] = $value['ob_rsptitle1'];
				$udata[$key]['ob_rspcontent1'] = $value['ob_rspcontent1'];
				$udata[$key]['ob_rsptitle2'] = $value['ob_rsptitle2'];
				$udata[$key]['ob_rspcontent2'] = $value['ob_rspcontent2'];
				$udata[$key]['ob_rsptitle3'] = $value['ob_rsptitle3'];
				$udata[$key]['ob_rspcontent3'] = $value['ob_rspcontent3'];
			}
		}
		//echo "<pre>";print_r($ndata);print_r($udata);echo "</pre>";
		if(!empty($ndata))
		{
			foreach($ndata as $key => $dat)
			{
				$this->db->insert('tbl_objections', $dat);
			}
		}
		if(!empty($udata))
		{
			foreach($udata as $key => $dat)
			{
				$this->db->where('ob_id',(int)$key);
				$this->db->update('tbl_objections', $dat);
			}
		}
	}
	//Delete campaign objection
	public function deleteCampaignObjection($campaign_id, $id_dev)
	{
		$this->db->where('ob_campaign', $campaign_id);
		$this->db->where('ob_id', $id_dev);
		return $this->db->delete('tbl_objections');
	}
	////
	
	/**
	 *   Copy Custom Content Objections Data 
	 */
	public function copyCustomobjections($campaign_id,$newcampainID)
	{		 
		$this->db->from('tbl_objections');
		$this->db->where('ob_campaign',$campaign_id);
		$this->db->order_by("ob_order","asc");
		$query = $this->db->get();		 
		
		if($query->num_rows == 0 ){
			return false;
		}
		$allCustomObjections = $query->result();
		if(!empty($allCustomObjections)) {
			foreach($allCustomObjections  as $singleCustomObjection)
			{
				$save_data = array( 'ob_campaign' => $newcampainID,
									'ob_title' => $singleCustomObjection->ob_title ,
									'ob_defid' => $singleCustomObjection->ob_defid ,
									'ob_order' => $singleCustomObjection->ob_order ,
									'ob_rsptitle1' => $singleCustomObjection->ob_rsptitle1 ,
									'ob_rspcontent1' => $singleCustomObjection->ob_rspcontent1 ,
									'ob_rsptitle2' => $singleCustomObjection->ob_rsptitle2 ,
									'ob_rspcontent2' => $singleCustomObjection->ob_rspcontent2 ,
									'ob_rsptitle3' => $singleCustomObjection->ob_rsptitle3 ,
									'ob_rspcontent3' => $singleCustomObjection->ob_rspcontent3);
				$this->db->insert('tbl_objections',$save_data);
			}
		}
	}
	////
	////
	//By Dev@4489
	//Question tree : Qualify tree
	/**
	 *  get qualify questions
	 */
	public function getQualifyQuest($campaign_id,$show=0)
	{
		$this->db->select();
		$this->db->from('tbl_tech_qualify');
		$this->db->where('campaign_id',$campaign_id);
		if($show) $this->db->where('visible',$show);
		$this->db->order_by("qus_id","asc");
		$record = $this->db->get();		
		// echo $this->db->last_query();
		return $record->result();
	}
	/**
	 *  get qualify questions
	 */
	public function getQualifyQuestNext($campaign_id,$Cqid)
	{
		$this->db->select();
		$this->db->from('tbl_tech_qualify');
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('tech_q_id >',$Cqid);
		$this->db->order_by("qus_id","asc");
		$this->db->limit(1);
		$record = $this->db->get();
		// echo $this->db->last_query();
		$recs = $record->result();
		if(!$recs) {
			$this->db->select();
			$this->db->from('tbl_tech_qualify');
			$this->db->where('campaign_id',$campaign_id);
			$this->db->where('tech_q_id <>',$Cqid);
			$this->db->order_by("qus_id","asc");
			$this->db->limit(1);
			$record = $this->db->get();
			$recs = $record->result();
		}
		return $recs;
	}
	
	public function changeCampaign($c_id,$Uid)
	{
	
		$updatedata = array('status' => '0');
		$this->db->where('user_id',$Uid);
		$this->db->update($this->_table_campaign,$updatedata);
		$updatedata = array('status' => '1');
		$this->db->where('user_id',$Uid);
		$this->db->where('campaign_id',$c_id);
		$this->db->update($this->_table_campaign,$updatedata);
	}

	public function hideCampaign($c_id,$Uid,$value)
	{
		$updatedata = array('hide' => $value);
		$this->db->where('user_id',$Uid);
		$this->db->where('campaign_id',$c_id);
		$this->db->update($this->_table_campaign,$updatedata);
		//echo $this->db->last_query();
		//exit;
	}
	
	
	/**
	 *  get qualify question row by id
	 */
	public function getQualifyQuestRow($q_id,$Qcampid)
	{
		$this->db->select();
		$this->db->from('tbl_tech_qualify');
		$this->db->where('campaign_id',$Qcampid);
		$this->db->where('tech_q_id',$q_id);
		$record = $this->db->get();
		//echo $this->db->last_query();
		return $record->result();
	}
	/**
	 *  get qualify question responses
	 */
	public function getQualifyQuestResps($q_id,$Qcampid,$qrparent=0,$qsect=1,$show=0)
	{
		$this->db->select();
		$this->db->from('tbl_qualify_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_parent',$qrparent);
		if($show) $this->db->where('visible',$show);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();
		return $record->result();
	}
	/**
	 *  delete qualify question responses
	 */
	public function deleteQuestResp($campaign_id,$Cqrid)
	{
		$this->db->select();
		$this->db->from('tbl_qualify_response');
		$this->db->where('qr_cid',$campaign_id);
		$this->db->where('qr_parent',$Cqrid);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();		
		$recs = $record->result();
		//echo $this->db->last_query();
		//loop sub childs
		if($recs) {
			foreach($recs as $qresp) {
				$this->deleteQuestResp($campaign_id,$qresp->qr_id);
			}
		}
		//delete question response
		$this->db->where('qr_cid',$campaign_id);
		$this->db->where('qr_id',$Cqrid);
		$this->db->delete('tbl_qualify_response');
		//echo $this->db->last_query();
	}
	
	public function deleteSQuestResp($campaign_id,$Cqrid)
	{
		$this->db->select();
		$this->db->from('sales_question_response');
		$this->db->where('qr_cid',$campaign_id);
		$this->db->where('qr_parent',$Cqrid);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();		
		$recs = $record->result();
		//echo $this->db->last_query();
		//loop sub childs
		if($recs) {
			foreach($recs as $qresp) {
				$this->deleteSQuestResp($campaign_id,$qresp->qr_id);
			}
		}
		//delete question response
		$this->db->where('qr_cid',$campaign_id);
		$this->db->where('qr_id',$Cqrid);
		$this->db->delete('sales_question_response');
		//echo $this->db->last_query();
	}
	
	
	/**
	 *  get qualify question response row
	 */
	public function getQualifyQuestRespRow($q_id,$Qcampid,$qrparent=0,$qsect=1,$show=0)
	{
		$this->db->select();
		$this->db->from('tbl_qualify_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		if($show) $this->db->where('visible',$show);
		/*if($qrparent) $this->db->where('qr_id',$qrparent);
		else */
		$this->db->where('qr_parent',$qrparent);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();
		//echo $this->db->last_query();
		return $record->result();
	}
	/**
	 *  get qualify question responses count
	 */
	public function getQualifyQuestRespCount($q_id,$Qcampid,$qrparent=0,$qsect=1,$show=0)
	{
		$this->db->select('count(qr_section) as qrcount');
		$this->db->from('tbl_qualify_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_parent',$qrparent);
		if($show) $this->db->where('visible',$show);
		$record = $this->db->get();
		$result = $record->row_array();
		return $result['qrcount'];
	}
	
	
	public function getSalesQuestRespCount($q_id,$Qcampid,$qrparent=0,$qsect=1,$show=0)
	{
		$this->db->select('count(qr_section) as qrcount');
		$this->db->from('sales_question_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_parent',$qrparent);
		if($show) $this->db->where('visible',$show);
		$record = $this->db->get();
		$result = $record->row_array();
		return $result['qrcount'];
	}
	
	public function getSalesQuestRespRow($q_id,$Qcampid,$qrparent=0,$qsect=1,$show=0)
	{
		$this->db->select();
		$this->db->from('sales_question_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		if($show) $this->db->where('visible',$show);
		/*if($qrparent) $this->db->where('qr_id',$qrparent);
		else */
		$this->db->where('qr_parent',$qrparent);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();
		//echo $this->db->last_query();
		return $record->result();
	}
	
	public function getSalesQuestResps($q_id,$Qcampid,$qrparent=0,$qsect=1,$show=0)
	{
		$this->db->select();
		$this->db->from('sales_question_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_parent',$qrparent);
		if($show) $this->db->where('visible',$show);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();
		return $record->result();
	}
	
	
	//update qualify question order
	public function updateQuestOrder($quest_id, $qo_val)
	{
		$this->db->where('tech_q_id',(int)$quest_id);
		$this->db->update('tbl_tech_qualify', array("qus_id"=>$qo_val));
	}
	//save qualify question
	public function saveQualifyQuest($edata, $Qcampid)
	{
		if($edata['eid']) {
			$this->db->where('tech_q_id',(int)$edata['eid']);
			$this->db->where('campaign_id',$Qcampid);
			$this->db->update('tbl_tech_qualify', array('value' => $edata['qt'],"qus_id"=>$edata['od']));	
		} else {
			$save_data = array( 'field_type' => 'tech_qualify',
								'value' => $edata['qt'] ,
								'qus_id' => $edata['od'] ,
								'campaign_id' => $Qcampid);
			$this->db->insert('tbl_tech_qualify',$save_data);
		}
		
	}
	//save qualify question response
	public function saveQuestResp($edata, $Qcampid, $qsect=1)
	{
		if($edata['qrespid']) {
			$this->db->where('qr_id',(int)$edata['qrespid']);
			$this->db->where('qr_cid',$Qcampid);
			$this->db->update('tbl_qualify_response', array('qr_response' => $edata['txtresp']));
			$jdata = array("qrespid"=>$edata['qrespid'],'action'=>'edit');
		} else {
			$save_data = array( 'qr_parent' => $edata['qpid'],
								'qr_response' => $edata['txtresp'] ,
								'qr_qid' => $edata['qid'] ,
								'qr_section' => $qsect ,
								'qr_cid' => $Qcampid);
			$this->db->insert('tbl_qualify_response',$save_data);
			$new_qresp_id = $this->db->insert_id();
			$jdata = array("qrespid"=>$new_qresp_id,'action'=>'new');
		}	
		echo json_encode($jdata);	
	}
	//delete qualify question
	public function deleteQualifyQuest($quest_id,$Qcampid,$qsect=1)
	{
		//delete question
		$this->db->where('tech_q_id',(int)$quest_id);
		$this->db->where('campaign_id',$Qcampid);
		$this->db->delete('tbl_tech_qualify');
		//delete question responses
		$this->db->where('qr_qid',(int)$quest_id);
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_section',$qsect);
		$this->db->delete('tbl_qualify_response');
	}
	//delete qualify question from Campaign > Edit > Qualify Tab page
	public function deleteCampQualifyQuestResp($quest_id,$Qcampid,$qsect='tqd')
	{
		//delete question responses
		$dqsect = 0;
		if($qsect=="tqd") $dqsect = 1;
		else if($qsect=="bqd") $dqsect = 2;
		else if($qsect=="pqd") $dqsect = 3;
		if($dqsect) {
			$this->db->where('qr_qid',(int)$quest_id);
			$this->db->where('qr_cid',$Qcampid);
			$this->db->where('qr_section',$dqsect);
			$this->db->delete('tbl_qualify_response');
		}
	}
	
	//delete qualify question from Campaign > Edit > Qualify Tab page
	public function deleteSalesQuestion($sq_id)
	{
		$this->db->where('id',(int)$sq_id);
		$this->db->delete('sales_question');
	}
	
	//Editable Template section
	//get all templates
	public function get_alltemplates($sect)
	{
		//Original template
		$this->db->select('*');
		$this->db->from('tbl_templates');
		$this->db->where('temp_type',$sect);
		if($sect=="Sales Scripts")
			$this->db->where_not_in('temp_id',array(12,13,14));
		else if($sect=="'Interview Emails")
			$this->db->where_not_in('temp_id',array(74,75));
		else if($sect=="Emails and Letters")	
			$this->db->where('((temp_id BETWEEN 15 and 30) OR temp_id in (68,69,70,71,73,83,84,85,86,87))',NULL,NULL);
		else if($sect=="Voicemail Scripts")
			$this->db->where_in('temp_id',array(31,32,33,34));			
		$this->db->order_by("temp_sort","asc");
		$get_value = $this->db->get();
		return $get_value->result();
	}
	//Update template options
	public function updateTemplateOptions($edata, $where=array())
	{
		$user_id =  $_SESSION['ss_user_id'];
		if($where) {//update
			$this->db->where('temp_user',(int)$user_id);
			$this->db->where('temp_id',(int)$where['temp_id']);
			$this->db->where('campaign_id',(int)$where['campaign_id']);
			$this->db->update('tbl_template_user', $edata);
		} else {//insert			
			$edata['temp_user']=(int)$user_id;
			$this->db->insert('tbl_template_user', $edata);
		}
	}
	//get template
	public function get_template($template)
	{
		//Original template
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_templates');
		$this->db->where('temp_id',$template);
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		return $get_value->result();
	}
	//get email templates
	public function get_Email_templates()
	{
		$this->db->select('ts.sect_id,t.temp_id,t.temp_title');
		$this->db->from('tbl_templates t');
		$this->db->join("tbl_template_sections ts", 'ts.temp_id = t.temp_id');
		$this->db->where('t.temp_type','Emails and Letters');
		$this->db->where('((t.temp_id BETWEEN 15 and 30) OR t.temp_id in (68,69,70,71,73,83,84,85,86,87))',NULL,NULL);
		$this->db->order_by("t.temp_sort","asc");
		$this->db->order_by("t.temp_title","asc");
		$get_value = $this->db->get();
		return $get_value->result();
	}
	//Get main Template by slug
	public function get_maintemplate_byslug($tempslug)
	{
		//Original template
		//$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_templates');
		$this->db->where('temp_slug',$tempslug);
		$get_value = $this->db->get();
		$stemplate = $get_value->row_array();
		return $stemplate;
	}
	//get template by slug
	public function get_template_byslug($tempslug,$campaign_id)
	{
		//Original template
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_templates');
		$this->db->where('temp_slug',$tempslug);
		$get_value = $this->db->get();
		$stemplate = $get_value->result();
		if($stemplate) {
			$template_info = array("temp_no"=>$stemplate[0]->temp_id,"template_title"=>$stemplate[0]->temp_title,"template_type"=>$stemplate[0]->temp_type);
			$user_id =  $_SESSION['ss_user_id'];
			$this->db->flush_cache();
			$this->db->select('temp_title,temp_hide,ignored_sections');
			$this->db->from('tbl_template_user');
			$this->db->where('temp_id',$stemplate[0]->temp_id);
			$this->db->where('campaign_id',$campaign_id);
			$this->db->where('temp_user',$user_id);
			$get_value = $this->db->get();
			$etemp = $get_value->result();
			if($etemp) {
				if($etemp[0]->temp_hide) return 0;
				$template_info['template_title'] = $etemp[0]->temp_title;
				$template_info['ignored_sections'] = $etemp[0]->ignored_sections?explode(",",$etemp[0]->ignored_sections):array();
			}	
			return $template_info;
		}
		else return 0;
	}
	//get user template
	public function get_etemplate($template,$campaign_id)
	{
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
		$this->db->flush_cache();
		//$this->db->select('temp_title,temp_hide');
		$this->db->from('tbl_template_user');
		$this->db->where('temp_id',$template);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('temp_user',$shuser);
		$get_value = $this->db->get();
		$etemp = $get_value->result();
		if($etemp) return $etemp[0];
		return $etemp;
	}
	//get user template titles
	public function get_etemplates($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];		
		$this->db->flush_cache();
		$this->db->select('temp_id,temp_title,temp_hide,temp_sort');
		$this->db->from('tbl_template_user');
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('temp_user',$user_id);
		$this->db->order_by("temp_sort","asc");
		$get_value = $this->db->get();
		$temps = $get_value->result();
		$templates = array();
		$htemplates = array();
		$stemplates = array();
		if($temps) {
			foreach($temps as $temp) {
				$templates[$temp->temp_id] = $temp->temp_title;
				if($temp->temp_hide) $htemplates[$temp->temp_id] = 1;
				$stemplates[$temp->temp_id] = $temp->temp_sort;
			}	
		}
		$templates = array("templates"=>$templates,"hidetemp"=>$htemplates,"sorttemp"=>$stemplates);
		return $templates;
	}
	//get template sections
	public function get_template_sections($template)
	{
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_template_sections');
		$this->db->where('temp_id',$template);
		$this->db->where('content_id !=',1);
		$this->db->order_by("sorting","asc");
		$get_value = $this->db->get();
		$customcontent = $get_value->result();
		if(!empty($customcontent)) 
			foreach($customcontent as $tsi=>$tsection) 
				if($tsection->content_id==6) 
					$customcontent[$tsi]->sect_title="Company and Product Info";
		return $customcontent;
	}
	//get template content
	public function get_template_content($template,$campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_template_content');
		$this->db->where('temp_id',$template);
		$this->db->where('userid',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('sect_id >=',0);
		$this->db->order_by("sect_sort","asc");
		$get_value = $this->db->get();
		$customcontent = $get_value->result();
		return $customcontent;
	}
	//Delete template contents & Template name
	public function delete_template_content($template,$campaign_id)
	{
		//Delete template section contents
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->where('temp_id',$template);
		$this->db->where('userid',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->delete('tbl_template_content');
		//Delete user template details
		$this->db->where('temp_id',$template);
		$this->db->where('temp_user',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->delete('tbl_template_user');
	}
	//get template IS content
	public function get_template_iscontent($template,$campaign_id)
	{
		return array();
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->flush_cache();
		$this->db->select('*');
		$this->db->from('tbl_template_content');
		$this->db->where('temp_id',$template);
		$this->db->where('userid',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('sect_id <',0);
		$this->db->order_by("sect_sort","asc");
		$get_value = $this->db->get();
		$customcontent = $get_value->result();
		//echo $this->db->last_query();
		$Res = array();
		if($customcontent) {			
			foreach($customcontent as $rec) 
				$Res[$rec->sect_sort]=$rec;
		}
		return $Res;
	}
	//Update template content
	public function updateTemplateContent($data, $campaign_id,$etemp)
	{
		//echo "<pre>";print_r($data);exit;
		$user_id =  $_SESSION['ss_user_id'];
		//Update template name
		$ignore = array();		
		//Sales Scripts templates
		$sstemplates = 0;
		if(isset($data['ignore'])) $sstemplates = 1;
		if(trim($data['title'])) {
			if($data['ignore']) $ignore = explode(",",$data['ignore']);
			if($etemp) {
				$edata = array('temp_title'=>$data['title'],'temp_hide'=>$data['hide']?1:0);
				$this->db->where('temp_id',(int)$data['temp_id']);
				$this->db->where('temp_user',(int)$user_id);
				$this->db->where('campaign_id',(int)$campaign_id);
				$this->db->update('tbl_template_user', $edata);
			} else {
				$ndata = array('temp_id'=>(int)$data['temp_id'],'campaign_id'=>(int)$campaign_id,'temp_user'=>(int)$user_id,'temp_title'=>$data['title'],'temp_hide'=>$data['hide']?1:0);
				$this->db->insert('tbl_template_user', $ndata);
			}
		}
		$template_id = $data['temp_id'];
		unset($data['title']);
		unset($data['temp_id']);
		unset($data['hide']);
		unset($data['ignore']);
		//$data = array_values($data);
		//echo "<pre>";print_r($data);exit;
		//save template sections		
		foreach($data as $key => $value)
		{
			if((int)$key)
			{	
				$edata = array('sect_title'=>$value['heading'],'sect_content'=>$value['value'],'sect_sort'=>(int)$value['sorder'],'sect_id'=>(int)$value['tsid'],'sect_dowcount'=>(int)$value['dowcount'],'sect_dow'=>''.$value['dow'],'sect_subject'=>''.$value['subject']);
				$this->db->where('temp_aid',(int)$key);
				$this->db->where('temp_id',(int)$template_id);
				//$this->db->where('sect_id',(int)$key);
				$this->db->where('campaign_id',(int)$campaign_id);
				$this->db->where('userid',(int)$user_id);
				$this->db->update('tbl_template_content', $edata);
			} else {
				if($sstemplates) {
					if(!isset($value['standard'])) {
						$ignore[] = (int)$value['tsid'];
						$ndata = array('temp_id'=>(int)$template_id,'campaign_id'=>(int)$campaign_id,'userid'=>(int)$user_id,'sect_title'=>$value['heading'],'sect_content'=>$value['value'],'sect_sort'=>(int)$value['sorder'],'sect_id'=>(int)$value['tsid'],'sect_dowcount'=>(int)$value['dowcount'],'sect_dow'=>''.$value['dow'],'sect_subject'=>''.$value['subject']);
						$this->db->insert('tbl_template_content', $ndata);
					}
				} else {
					$ndata = array('temp_id'=>(int)$template_id,'campaign_id'=>(int)$campaign_id,'userid'=>(int)$user_id,'sect_title'=>$value['heading'],'sect_content'=>$value['value'],'sect_sort'=>(int)$value['sorder'],'sect_id'=>(int)$value['tsid'],'sect_dowcount'=>(int)$value['dowcount'],'sect_dow'=>''.$value['dow'],'sect_subject'=>''.$value['subject']);
					$this->db->insert('tbl_template_content', $ndata);
				}
				
			}
		}
		if($template_id && $ignore) {
			$ignore = array_unique($ignore);
			$ignore = implode(",",$ignore);	
			$edata = array('ignored_sections'=>$ignore);
			$this->db->where('temp_id',(int)$template_id);
			$this->db->where('temp_user',(int)$user_id);
			$this->db->where('campaign_id',(int)$campaign_id);
			$this->db->update('tbl_template_user', $edata);
		}
	}
	//Delete template section
	public function Remetemp_section($campaign_id, $id_dev)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->where('campaign_id', $campaign_id);
		$this->db->where('temp_aid', $id_dev);
		$this->db->where('userid',(int)$user_id);
		return $this->db->delete('tbl_template_content');
	}
	//get user template section
	public function get_etemplate_section($template,$campaign_id,$csection)
	{
		$user_id =  $_SESSION['ss_user_id'];		
		//$this->db->flush_cache();
		//$this->db->select('temp_title,temp_hide');
		$this->db->from('tbl_template_content');
		$this->db->where('temp_id',$template);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('temp_aid', $csection);
		$this->db->where('userid',$user_id);
		$get_value = $this->db->get();
		return $get_value->row_array();
	}
	//Copy editable template content of campaign to as a user new campaign template
	function copyEtemplateContent($campaign_id,$new_Campaign_id) {	
		$user_id =  $_SESSION['ss_user_id'];
		//copy campaign tempate contents
		$this->db->select('*');
		$this->db->from('tbl_template_content');
		$this->db->where('campaign_id',$campaign_id);
		$this->db->order_by("sect_sort","asc");
		$get_value = $this->db->get();
		$Campaign_eTempContents = $get_value->result();
		if(!empty($Campaign_eTempContents)) {
			foreach($Campaign_eTempContents  as $eTempContent)
			{
				$ndata = array('temp_id'=>(int)$eTempContent->temp_id,
				'campaign_id'=>(int)$new_Campaign_id,
				'userid'=>(int)$user_id,
				'sect_title'=>$eTempContent->sect_title,
				'sect_subject'=>$eTempContent->sect_subject,
				'sect_content'=>$eTempContent->sect_content,
				'sect_sort'=>(int)$eTempContent->sect_sort,
				'sect_id'=>(int)$eTempContent->sect_id);
				$this->db->insert('tbl_template_content', $ndata);
			}
		}
		//copy campaign template names
		$this->db->select('*');
		$this->db->from('tbl_template_user');
		$this->db->where('campaign_id',$campaign_id);
		$get_value = $this->db->get();
		$Campaign_eTempNames = $get_value->result();
		if(!empty($Campaign_eTempNames)) {
			foreach($Campaign_eTempNames  as $eTempName)
			{
				$ndata = array('temp_id'=>(int)$eTempName->temp_id,
				'campaign_id'=>(int)$new_Campaign_id,
				'temp_user'=>(int)$user_id,
				'temp_title'=>$eTempName->temp_title);
				$this->db->insert('tbl_template_user', $ndata);
			}
		}
	}
	//End of Editable templates
	////
	//by Dev@4489
	//File with existing answer
	//get user all campaigns value answers
	/**
	 *  fecth record form tech value table
	 */
	public function getTechValues($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,tech_v_id');
		$this->db->from($this->_table_tech_value);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_tech_value.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	/**
	 *  fecth template user record form tech value table  by Dev@4489
	 */
	public function getTuserTechValues()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,tech_v_id as answid');
		$this->db->from($this->_table_tech_value);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_tech_value.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	//get user all campaigns pain answers
	/**
	 *  fecth record form tech pain table
	 */
	public function getTechValuePains($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,tech_p_id');
		$this->db->from('tbl_tech_pain');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_tech_pain.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	/**
	 *  fecth template user record form tech pain table 27-2-2016 by Dev@4489
	 */
	public function getTuserTechValuePains()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,tech_p_id as answid');
		$this->db->from('tbl_tech_pain');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_tech_pain.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	//get user all campaigns qualify answers
	/**
	 *  fecth record form tech qualify table
	 */
	public function getTechQualifyPains($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,tech_q_id');
		$this->db->from('tbl_tech_qualify');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_tech_qualify.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		$this->db->where('tbl_tech_qualify.q_col','');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	/**
	 *  fecth template user record  form tech qualify table 29-2-2016 by Dev@4489
	 */
	
	public function getTuserTechQualifyPains()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,tech_q_id as answid');
		$this->db->from('tbl_tech_qualify');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_tech_qualify.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('tbl_tech_qualify.q_col','');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	//get user all campaigns ideal-sales-process 1
	/**
	 *  fecth record form campaign common table
	 */
	public function getCampaignMetadatas1($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,cam_com_id as answid');
		$this->db->from($this->_table_campaign_comm);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_campaign_comm.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		//$this->db->where_in($this->_table_campaign_comm.'.field_type',array('sale_process_close1','sale_process_close2','sale_process_close3'));
		$this->db->where($this->_table_campaign_comm.'.field_type','sale_process_close1');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	
	/**
	 *  fecth record form campaign common table 29-2-2016 by Dev@4489
	 */
	public function getTuserCampaignMetadatas1()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,cam_com_id as answid');
		$this->db->from($this->_table_campaign_comm);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_campaign_comm.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where($this->_table_campaign_comm.'.field_type','sale_process_close1');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}	
	//get user all campaigns ideal-sales-process 2
	/**
	 *  fecth record form campaign common table
	 */
	public function getCampaignMetadatas2($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,cam_com_id as answid');
		$this->db->from($this->_table_campaign_comm);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_campaign_comm.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		$this->db->where($this->_table_campaign_comm.'.field_type','sale_process_close2');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	/**
	 *  fecth record form campaign common table 29-2-2016 by Dev@4489
	 */
	public function gettTuserCampaignMetadatas2()
	{
		$user_id  =  $this->_template_user;
		$this->db->select('value,cam_com_id as answid');
		$this->db->from($this->_table_campaign_comm);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_campaign_comm.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where($this->_table_campaign_comm.'.field_type','sale_process_close2');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	//get user all campaigns ideal-sales-process 3
	/**
	 *  fecth record form campaign common table
	 */
	public function getCampaignMetadatas3($campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,cam_com_id as answid');
		$this->db->from($this->_table_campaign_comm);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_campaign_comm.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		$this->db->where($this->_table_campaign_comm.'.field_type','sale_process_close3');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	/**
	 *  fecth record form campaign common table 29-2-2016 by Dev@4489
	 */
	public function getTuserCampaignMetadatas3()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,cam_com_id as answid');
		$this->db->from($this->_table_campaign_comm);
		$this->db->join('campaigns', 'campaigns.campaign_id = '.$this->_table_campaign_comm.'.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where($this->_table_campaign_comm.'.field_type','sale_process_close3');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	//get user all name drop asnwers
	/**
	 *  fecth record form  credibility data table
	 */
	public function credibility_data_names()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('credibility_name as value,c_id as answid');
		$this->db->from($this->_table_credibility);
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where($this->_table_credibility.'.status','0');
		$this->db->where('trash',0);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	/**
	 *  fecth Template user record form  credibility data table 02-28-2016 by Dev@4489
	 */
	public function getTusercredibility_data_names()
	{
		$user_id =  $this->_template_user;
		$this->db->select('credibility_name as value,c_id as answid');
		$this->db->from($this->_table_credibility);
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where('trash',0);
		//$this->db->where($this->_table_credibility.'.status','0');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();	
		//echo $this->db->last_query();	
		return $getvalue->result();
	}
	//get user all name drop asnwers
	/**
	 *  fecth worked record form  credibility data table
	 */
	public function credibility_datas()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where($this->_table_credibility.'.status','0');
		$this->db->where('trash',0);
		//$this->db->where_not_in($this->_table_credibility_data.'.field_type',array('customer', 'profile'));
		//$this->db->where_in($this->_table_credibility_data.'.field_type',array('worked', 'provided','when'));
		$this->db->where($this->_table_credibility_data.'.field_type','worked');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	/**
	 *  fecth provided record form  credibility data table
	 */
	public function credibility_datas_provided()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where($this->_table_credibility.'.status','0');		
		$this->db->where('trash',0);
		//$this->db->where_not_in($this->_table_credibility_data.'.field_type',array('customer', 'profile'));
		//$this->db->where_in($this->_table_credibility_data.'.field_type',array('worked', 'provided','when'));
		$this->db->where($this->_table_credibility_data.'.field_type','provided');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	/**
	 *  fecth when record form  credibility data table
	 */
	public function credibility_datas_when()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where($this->_table_credibility.'.status','0');	
		$this->db->where('trash',0);	
		//$this->db->where_not_in($this->_table_credibility_data.'.field_type',array('customer', 'profile'));
		//$this->db->where_in($this->_table_credibility_data.'.field_type',array('worked', 'provided','when'));
		$this->db->where($this->_table_credibility_data.'.field_type','when');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	
	/**
	 *  fecth Template user  record form  credibility data table 02-28-2016 by Dev@4489
	 */
	public function getTusercredibility_datas()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where('trash',0);
		//$this->db->where($this->_table_credibility.'.status','0');
		//$this->db->where_not_in($this->_table_credibility_data.'.field_type',array('customer', 'profile'));
		//$this->db->where_in($this->_table_credibility_data.'.field_type',array('worked', 'provided','when'));
		$this->db->where($this->_table_credibility_data.'.field_type','worked');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	/**
	 *  fecth Template user provided  record form  credibility data table 02-28-2016 by Dev@4489
	 */
	public function getTusercredibility_datas_provided()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where('trash',0);
		//$this->db->where($this->_table_credibility.'.status','0');
		//$this->db->where_not_in($this->_table_credibility_data.'.field_type',array('customer', 'profile'));
		//$this->db->where_in($this->_table_credibility_data.'.field_type',array('worked', 'provided','when'));
		$this->db->where($this->_table_credibility_data.'.field_type','provided');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	
	/**
	 *  fecth Template user when  record form  credibility data table 02-28-2016 by Dev@4489
	 */
	public function getTusercredibility_datas_when()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where('trash',0);
		//$this->db->where($this->_table_credibility.'.status','0');
		//$this->db->where_not_in($this->_table_credibility_data.'.field_type',array('customer', 'profile'));
		//$this->db->where_in($this->_table_credibility_data.'.field_type',array('worked', 'provided','when'));
		$this->db->where($this->_table_credibility_data.'.field_type','when');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	//get user all name drop profiles
	/**
	 *  fecth record form  credibility data table
	 */
	public function credibility_data_profiles()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where($this->_table_credibility.'.status','0');
		$this->db->where('trash',0);
		$this->db->where($this->_table_credibility_data.'.field_type','profile');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}	
	
	/**
	 *  fecth Template user record form  credibility data table 02-28-2016 by Dev@4489
	 */
	public function getTusercredibility_data_profiles()
	{
		$user_id = $this->_template_user;
		$this->db->select('value,c_data_id as answid');
		$this->db->from($this->_table_credibility_data);
		$this->db->join($this->_table_credibility, $this->_table_credibility.'.c_id = '.$this->_table_credibility_data.'.c_id');
		$this->db->where($this->_table_credibility.'.user_id',(int)$user_id);
		$this->db->where('trash',0);
		//$this->db->where($this->_table_credibility.'.status','0');
		$this->db->where($this->_table_credibility_data.'.field_type','profile');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	//Interactive Script Voicemails editable content
	public function IS_voicemails($campaign_id) {
		if(!$campaign_id) return array();
		$this->db->select('tbl_template_content.temp_id,tbl_template_content.sect_content,tbl_template_user.temp_title');
		$this->db->from('tbl_template_content');
		$this->db->where('tbl_template_content.campaign_id',$campaign_id);
		$this->db->join('tbl_template_user', 'tbl_template_content.campaign_id = tbl_template_user.campaign_id and tbl_template_content.temp_id=tbl_template_user.temp_id');
		$this->db->where_in('tbl_template_content.temp_id',array(31,32,33,34));
		$this->db->order_by("tbl_template_content.temp_id","asc");
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		return $get_value->result();
	}	
	////
	//Get campaign products
	public function get_cc_products() {
		$user_id = $_SESSION['ss_user_id'];	
		$this->db->select('product_id,product_name');
		$this->db->from($this->_table_products);
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->order_by('sorder','asc');
		$this->db->order_by("product_name","asc");
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		return $get_value->result();
	}
	//Get campaign products of template user
	public function getTuser_cc_products() {
		$user_id = $this->_template_user;
		$this->db->select('product_id,product_name');
		$this->db->from($this->_table_products);
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->order_by('sorder','asc');
		$this->db->order_by("product_name","asc");
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		return $get_value->result();
	}
	//Get Target Prospects
	public function get_targetProspects() {
		$user_id = $_SESSION['ss_user_id'];	
		$this->db->select('tp_id,tp_text');
		$this->db->from('tbl_target_prospect');
		$this->db->where('tp_user',$user_id);
		$this->db->order_by("tp_text","asc");
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		$results = $get_value->result();
		if($results) return $results;
		//get user campaigns data if target prospects empty
		$this->db->select('individual,organization');
		$this->db->from($this->_table_campaign);
		$this->db->where('trash',0);
		$this->db->where('user_id',$user_id);
		$get_value = $this->db->get();		
		$ctp_results = $get_value->result();
		if($ctp_results) {
			foreach($ctp_results  as $ctp) {
				if($ctp->individual) {
					$this->db->from('tbl_target_prospect');
					$this->db->where('tp_user',$user_id);
					$this->db->where('tp_text',$ctp->individual);
					$get_value = $this->db->get();		
					$ctp_rows = $get_value->result();
					if(!$ctp_rows) {
						$data = array('tp_user' => $user_id,'tp_text' => $ctp->individual);
						$this->db->insert('tbl_target_prospect',$data);	
					}
				}
				if($ctp->organization) {
					$this->db->from('tbl_target_prospect');
					$this->db->where('tp_user',$user_id);
					$this->db->where('tp_text',$ctp->organization);
					$get_value = $this->db->get();		
					$ctp_rows = $get_value->result();
					if(!$ctp_rows) {
						$data = array('tp_user' => $user_id,'tp_text' => $ctp->organization);
						$this->db->insert('tbl_target_prospect',$data);	
					}
				}
			}
			return $this->get_targetProspects();	
		}
		//default target prospects if no data
		$data = array('tp_user' => $user_id,'tp_text' => 'business');
		$this->db->insert('tbl_target_prospect',$data);
		$data = array('tp_user' => $user_id,'tp_text' => 'target audience');
		$this->db->insert('tbl_target_prospect',$data);
		return $this->get_targetProspects();
	}
	//Delete Target Prospect by Dev@4489
	public function delTargetProspect($tpid) {
		$user_id = $_SESSION['ss_user_id'];
		$this->db->where('tp_user',$user_id);
		$this->db->where('tp_id',$tpid);
		$this->db->delete('tbl_target_prospect');
		exit;
	}
	//Get Target Prospects of template user
	public function getTuser_targetProspects() {
		$user_id = $this->_template_user;
		$this->db->select('tp_id,tp_text');
		$this->db->from('tbl_target_prospect');
		$this->db->where('tp_user',$user_id);
		$this->db->order_by("tp_text","asc");
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		$results = $get_value->result();
		return $results;		
	}
	/**
	 *  Save Target Prospect Data
	 */
	public function save_targetProspect($tpdata)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$prospect_ids = $tpdata['ids'];
		$prospect_names = $tpdata['names'];
		$msge=0;
		if ($prospect_ids) {
			foreach($prospect_ids as $pi=>$pv)
			{					
				$txt_prod = $prospect_names[$pi];
				if(!empty($txt_prod)) {						
					if($pv) {
						$updata = array('tp_text' => $txt_prod);
						$this->db->where('tp_user',$user_id);
						$this->db->where('tp_id',$pv);
						$this->db->update('tbl_target_prospect',$updata);
					} else {
						$data = array(
											'tp_user' => $user_id,
											'tp_text' => $txt_prod
										);
						$this->db->insert('tbl_target_prospect',$data);
					}
					$msge=1;
				}
			}
		}
		return $msge;
	}
	//End of Campaign Coordinates
	//by Dev@4489
	//Sort Orders
	//update tech value sort order
	public function updateTechVOrder($rc_id, $o_val)
	{
		$this->db->where('tech_v_id',(int)$rc_id);
		$this->db->update($this->_table_tech_value, array("qus_id"=>$o_val));
	}

	//update tech value display
	public function updateTechVShow($rc_id, $o_val)
	{
		$this->db->where('tech_v_id',(int)$rc_id);
		$this->db->update($this->_table_tech_value, array("visible"=>$o_val));
	}
	
	//update tech answer display
	public function updateTechHAnswer($rc_id, $o_val)
	{
		$this->db->where('tech_v_id',(int)$rc_id);
		$this->db->update($this->_table_tech_value, array("highlight"=>$o_val));
	}
	
	
	//update tech pain sort order
	public function updateTechPOrder($rc_id, $o_val)
	{
		$this->db->where('tech_p_id',(int)$rc_id);
		$this->db->update($this->_table_tech_pain, array("qus_id"=>$o_val));
	}
	//update tech value display
	public function updateTechPShow($rc_id, $o_val)
	{
		$this->db->where('tech_p_id',(int)$rc_id);
		$this->db->update($this->_table_tech_pain, array("visible"=>$o_val));
	}
	//update tech highlight answer
	public function updateTechPHAnswer($rc_id, $o_val)
	{
		$this->db->where('tech_p_id',(int)$rc_id);
		$this->db->update($this->_table_tech_pain, array("highlight"=>$o_val));
	}
	//update tech qualify sort order
	public function updateTechQOrder($rc_id, $o_val)
	{
		$this->db->where('tech_q_id',(int)$rc_id);
		$this->db->update($this->_table_tech_qualify, array("qus_id"=>$o_val));
	}
	
	//update tech qualify sort order
	public function updateNeedQOrder($rc_id, $o_val)
	{
		$this->db->where('id',(int)$rc_id);
		$this->db->update('sales_question', array("qus_id"=>$o_val));
	}
	
	
	//update tech value display
	public function updateTechQShow($rc_id, $o_val)
	{
		$this->db->where('tech_q_id',(int)$rc_id);
		$this->db->update($this->_table_tech_qualify, array("visible"=>$o_val));
	}

	//update tech qualify response display
	public function updateTechQRShow($rc_id, $o_val)
	{
		$this->db->where('qr_id',(int)$rc_id);
		$this->db->update('tbl_qualify_response', array("visible"=>$o_val));
	}
	
	
	//update tech qualify display
	public function updateNeedShow($rc_id, $o_val)
	{
		$this->db->where('id',(int)$rc_id);
		$this->db->update('sales_question', array("visible"=>$o_val));
	}
	
	//update tech qualify display
	public function updateNeedRShow($rc_id, $o_val)
	{
		$this->db->where('qr_id',(int)$rc_id);
		$this->db->update('sales_question_response', array("visible"=>$o_val));
	}
	
	
	////
	
	//update tech qualify display
	public function updateTechQHAShow($rc_id, $o_val)
	{
		$this->db->where('tech_q_id',(int)$rc_id);
		$this->db->update($this->_table_tech_qualify, array("highlight"=>$o_val));
	}
	//update tech qualify response display
	public function updateTechQRHAShow($rc_id, $o_val)
	{
		$this->db->where('qr_id',(int)$rc_id);
		$this->db->update('tbl_qualify_response', array("highlight"=>$o_val));
	}	
	////
	
	
	//update tech qualify response display
	public function updateNeedHAShow($rc_id, $o_val)
	{
		$this->db->where('id',(int)$rc_id);
		$this->db->update('sales_question', array("highlight"=>$o_val));
	}	
	////
	
	
	//update tech qualify response display
	public function updateNeedRHAShow($rc_id, $o_val)
	{
		$this->db->where('qr_id',(int)$rc_id);
		$this->db->update('tbl_qualify_response', array("highlight"=>$o_val));
	}	
	////
	
	
	
	public function get_temp_user($temp_id,$campaign_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('*');
		$this->db->from('tbl_template_user');
		$this->db->where('temp_id',$temp_id);
		$this->db->where('temp_user',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$get_value = $this->db->get();
		//echo $this->db->last_query();
		$results = $get_value->result();
	}
	
	public function get_primary_script($camp_id)	
	{
		$user_id = $_SESSION['ss_user_id'];
		$this->db->select('primary_script,temp_id');
		$this->db->from('tbl_template_user');
		$this->db->where('temp_user',$user_id);
		$this->db->where('primary_script',1);
		$this->db->where('campaign_id',$camp_id);
		$query = $this->db->get();
		$get_value = $query->result();	
		//echo '<pre>'; print_r($get_value); echo '</pre>';
		
		
		//echo $this->db->last_query();
		$primary_scripts = array("value"=>$get_value[0],"rows"=>$query->num_rows);
		//echo '<pre>'; print_r($primary_scripts['num_rows']); echo '</pre>';
		return $primary_scripts;
	}
	
	public function primaryscriptShow($temp_id, $o_val, $camp_id)
	{
		//echo "test1234";
		$user_id =  $_SESSION['ss_user_id'];
		$primaryScript = $this->get_primary_script($camp_id);
		//echo '<pre>'; print_r($primaryScript); echo '</pre>';
		
		//echo $primaryScript['rows'];
		//exit;
		if($primaryScript['rows']>0)
		{			
			//echo "Update";
			$this->db->where('primary_script',1);
			$this->db->where('temp_user',$user_id);
			$this->db->where('campaign_id',$camp_id);
			$this->db->update('tbl_template_user', array("primary_script"=>0));
			
			$this->db->where('temp_id',(int)$temp_id);
			$this->db->where('temp_user',$user_id);		
			$this->db->where('campaign_id',$camp_id);
			$this->db->update('tbl_template_user', array("primary_script"=>1));
		}
		else
		{	
			//echo "Insert";	
			$eTempName = $this->get_template($temp_id);
			$ndata = array('temp_id'=>(int)$temp_id,
			'campaign_id'=>(int)$camp_id,
			'temp_user'=>(int)$user_id,
			'temp_title'=>$eTempName[0]->temp_title,
			"primary_script"=>1);
			//echo '<pre>'; print_r($ndata); echo '</pre>';
			$this->db->insert('tbl_template_user', $ndata);
			//echo $this->db->last_query();
			//exit;
		}
	}	
	////
	
	
	//By Dev@4489
	//get user all campaigns extra individual qualify question answers by Dev@4489
	/**
	 *  fecth record form tech qualify table
	 */
	public function getTechExtraQualifyPains($campaign_id,$qcol)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,tech_q_id as answid');
		$this->db->from('tbl_tech_qualify');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_tech_qualify.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id !=',(int)$campaign_id);
		$this->db->where('tbl_tech_qualify.q_col',$qcol);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	/**
	 *  fecth template user record  form tech qualify extra question table 20-3-2016 by Dev@4489
	 */
	
	public function getTuserTechExtraQualifyPains($qcol)
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,tech_q_id as answid');
		$this->db->from('tbl_tech_qualify');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_tech_qualify.campaign_id');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('tbl_tech_qualify.q_col',$qcol);
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		return $getvalue->result();
	}
	////
	//Question Trees from Qualify Page
	//save qualify question response from Qualify Tab
	public function saveQuestRespTab($edata, $Qcampid, $qsect=1)
	{
		if($edata['qrespid']) {
			$this->db->where('qr_id',(int)$edata['qrespid']);
			$this->db->where('qr_cid',$Qcampid);
			$this->db->update('tbl_qualify_response', array('qr_response' => $edata['txtresp']));
			$jdata = array("qrespid"=>$edata['qrespid'],'action'=>'edit');
		} else {
			$save_data = array( 'qr_parent' => $edata['qpid'],
								'qr_response' => $edata['txtresp1'] ,
								'qr_qid' => $edata['qid'] ,
								'qr_section' => $qsect ,
								'qr_rstype' => 1 ,
								'qr_cid' => $Qcampid);
			$this->db->insert('tbl_qualify_response',$save_data);
			$new_qresp_id = $this->db->insert_id();
			$save_data = array( 'qr_parent' => $new_qresp_id,
								'qr_response' => $edata['txtresp2'] ,
								'qr_qid' => $edata['qid'] ,
								'qr_section' => $qsect ,
								'qr_cid' => $Qcampid);
			$this->db->insert('tbl_qualify_response',$save_data);
		}
	}
	
	public function saveSQuestRespTab($edata, $Qcampid, $qsect=1)
	{
		
		if($edata['qrespid']) {
			$this->db->where('qr_id',(int)$edata['qrespid']);
			$this->db->where('qr_cid',$Qcampid);
			$this->db->update('sales_question_response', array('qr_response' => $edata['txtresp']));
			$jdata = array("qrespid"=>$edata['qrespid'],'action'=>'edit');
		} else {
			$save_data = array( 'qr_parent' => $edata['qpid'],
								'qr_response' => $edata['txtresp1'] ,
								'qr_qid' => $edata['qid'] ,
								'qr_section' => $qsect ,
								'qr_rstype' => 1 ,
								'qr_cid' => $Qcampid);
			$this->db->insert('sales_question_response',$save_data);
			$new_qresp_id = $this->db->insert_id();
			$save_data = array( 'qr_parent' => $new_qresp_id,
								'qr_response' => $edata['txtresp2'] ,
								'qr_qid' => $edata['qid'] ,
								'qr_section' => $qsect ,
								'qr_cid' => $Qcampid);
			$this->db->insert('sales_question_response',$save_data);
		}
	}
	
	
	//save qualify answer
	public function saveQualifyAnswer($edata, $Qcampid)
	{
		if($edata['etype']=="q") {
			$this->db->where('tech_q_id',(int)$edata['eid']);
			$this->db->where('campaign_id',$Qcampid);
			$this->db->update('tbl_tech_qualify', array('value' => $edata['etext']));
		} elseif($edata['etype']=="qr") {
			$this->db->where('qr_id',(int)$edata['eid']);
			$this->db->where('qr_cid',$Qcampid);
			$this->db->update('tbl_qualify_response', array('qr_response' => $edata['etext']));
		}
	}
	
	public function saveSalesAnswer($edata, $Qcampid)
	{
		if($edata['etype']=="q") {
			$this->db->where('id',(int)$edata['eid']);
			$this->db->where('campaign',$Qcampid);
			$this->db->update('sales_question', array('question' => $edata['etext']));
		} elseif($edata['etype']=="qr") {
			$this->db->where('qr_id',(int)$edata['eid']);
			$this->db->where('qr_cid',$Qcampid);
			$this->db->update('sales_question_response', array('qr_response' => $edata['etext']));
		}
	}
	
	
	//Get Qualify question responses
	public function getQualifyResponses($q_id,$Qcampid,$qrparent=0,$qsect=1) {
		$this->db->select('qr_id,qr_response,visible,highlight');
		$this->db->from('tbl_qualify_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_parent',$qrparent);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();
		return $record->result();
	}
	//save qualify question answer responses
	public function saveQualifyQuestResps($edata, $Qcampid, $qsect=1)
	{
		if(!empty($edata)){
			foreach($edata as $eqans) {
				foreach($eqans as $eqi=>$eqva) {
					$this->db->where('qr_id',(int)$eqi);
					$this->db->where('qr_cid',$Qcampid);
					$this->db->update('tbl_qualify_response', array('qr_response' => $eqva));
				}
			}
		}	
	}
	
	
	//Get Qualify question responses
	public function getSalesResponses($q_id,$Qcampid,$qrparent=0,$qsect=1) {
		$this->db->select('qr_id,qr_response,visible,highlight');
		$this->db->from('sales_question_response');
		$this->db->where('qr_cid',$Qcampid);
		$this->db->where('qr_qid',$q_id);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_parent',$qrparent);
		$this->db->order_by("qr_id","asc");
		$record = $this->db->get();
		//echo $this->db->last_query(); 
		return $record->result();
	}
	
	
	public function getCatQuestions($active_campaign,$user_id)
    {

		//echo $type;
		$this->db->select('*');
		$this->db->from('tbl_qb_ctitles');
		$this->db->where('tbl_qb_ctitles.user_id',$user_id);
		$this->db->where('tbl_qb_ctitles.campaign_id',$active_campaign);
		$record = $this->db->get();	
		//echo $this->db->last_query(); 
		return $record->result();
    }
	
	//save question builder titles
	public function saveQuestionBuilderTitle($edata2,$k,$active_campaign,$user_id)
	{
		
		//$edata = array();
		$title_id = 0;
		$edata['id'] = $title_id;
		$edata['user_id'] = $user_id;
		$edata['campaign_id'] = $active_campaign;
		$edata['qb_type'] = $edata2['tabs'][$k];
		$edata['title'] = $edata2['title'][$k];
		$this->db->insert('tbl_qb_ctitles',$edata);  
	}
	
	
	public function saveQuestionBuilderTitle2($title_id,$title,$active_campaign,$user_id,$qb_type)
	{
		
		$this->db->where('id',(int)$title_id);
		$this->db->where('campaign_id',$active_campaign);
		$this->db->where('qb_type',$qb_type);
		$this->db->update('tbl_qb_ctitles', array('title' => $title));
		//echo $this->db->last_query(); 
	}
	
	
	public function getallSalesQuestion($campaign_id,$type)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('*');
		$this->db->from('sales_question');
		$this->db->join('campaigns', 'campaigns.campaign_id = sales_question.campaign');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('campaigns.campaign_id =',(int)$campaign_id);
		$this->db->where('sales_question.field_type =',$type);
		$this->db->order_by("qus_id","asc");
		$getvalue = $this->db->get();		
		//echo $this->db->last_query(); 
		return $getvalue->result();
	}
	
	
	public function getNeedWant($ans_id)
    {

		$this->db->select('*');
		$this->db->from('sales_question');
		$this->db->where('sales_question.id',$ans_id);
		$record = $this->db->get();
		//echo $this->db->last_query(); 	
		return $record->result();
    }
	
	
	public function saveNeedQuestions($edata,$active_campaign,$type)
	{	
		
		if(!empty($edata)){
			$qid = $edata['qid'];
			$question = $edata['question'];
			$qus_id = $edata['qus_id'];
			foreach($question as $key=>$value)
			{
				
				$getAnswer = $this->getNeedWant($qid[$key]);
				if(!empty($getAnswer))
				{
					$this->db->where('id',(int)$qid[$key]);
					$this->db->where('campaign',$active_campaign);
					$this->db->where('field_type',$type);
					$this->db->update('sales_question', array('question' => $value, 'qus_id' => $qus_id[$key]));
					//echo $this->db->last_query(); 
				}
				else
				{
					
					$save_data = array('question' => $value, 'qus_id' => 1, 'field_type' => $type, 'campaign' => $active_campaign);
					$this->db->insert('sales_question',$save_data);
					$new_qresp_id = $this->db->insert_id();
					//echo $this->db->last_query(); 
				}
			}
			
		}	
		//exit;
	}
	
	
	//Get Qualify question responses to popup answers 03-26-2016
	public function getQualifyResponseAnswers($Qcampid,$qr_rstype=0,$qsect=1) {
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('qr_id as answid,qr_response as value');
		$this->db->from('tbl_qualify_response');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_qualify_response.qr_cid');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('qr_cid !=',$Qcampid);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_rstype',$qr_rstype);
		$this->db->order_by("value","asc");
		$record = $this->db->get();		
		return $record->result();
	}
	//Get Template user Qualify question responses to popup answers 03-26-2016
	public function getTuserQualifyResponseAnswers($qr_rstype=0,$qsect=1) {
		$user_id =  $this->_template_user;
		$this->db->select('qr_id as answid,qr_response as value');
		$this->db->from('tbl_qualify_response');
		$this->db->join('campaigns', 'campaigns.campaign_id = tbl_qualify_response.qr_cid');
		$this->db->where('campaigns.user_id',(int)$user_id);
		$this->db->where('trash',0);
		$this->db->where('qr_section',$qsect);
		$this->db->where('qr_rstype',$qr_rstype);
		$this->db->order_by("value","asc");
		$record = $this->db->get();		
		return $record->result();
	}
	//update Content Builder Campaign, Name Drop sort order
	public function updateCBrecSorder($rc_id, $o_val,$sec)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$updateInfo = array("sorder"=>(int)$o_val);
		if($sec=="campaign") {
			$this->db->where('campaign_id',(int)$rc_id);
			$this->db->where('user_id',(int)$user_id);
			$this->db->update($this->_table_campaign, $updateInfo);
		} else if($sec=="namedrop") {
			$this->db->where('c_id',(int)$rc_id);
			$this->db->where('user_id',(int)$user_id);
			$this->db->update($this->_table_credibility, $updateInfo);
		} else if($sec=="company") {
			$this->db->where('company_id',(int)$rc_id);
			$this->db->where('user_id',(int)$user_id);
			$this->db->update($this->_table_company, $updateInfo);
		} else if($sec=="product") {
			$this->db->where('product_id',(int)$rc_id);
			$this->db->where('user_id',(int)$user_id);
			$this->db->update($this->_table_products, $updateInfo);
		}
	}
	/**
	 *   geting technical benefit and technical pain join result for which have orphan 
	 */
	public function getTechValueAnswersAll($campaign_id)
	{
		$this->db->select('value');
		$this->db->from($this->_table_tech_value);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->order_by("qus_id","asc");//by Dev@4489
		$record = $this->db->get();
		if($record->num_rows > 0)
		{
			return $record->result();
		}
		return false;
	}
	//Get Products from Trash
	public function getTrashProducts()
	{
		$c_user_id =  $_SESSION['ss_user_id'];
		$this->db->where('user_id',$c_user_id);
		$this->db->where('trash',1);
		$getvalue = $this->db->get($this->_table_products);
		if($getvalue->num_rows > 0)
		{
			return $getvalue->result();
		}
		return false;
	}
	//Get Companies from Trash
	function getTrashcompany()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select();
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',1);
		$this->db->from($this->_table_company);
		$query = $this->db->get();
		return $query->result();
	}
	//Get Name Drops from Trash
	function getTrashNamedrop()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',1);
		$this->db->order_by("sorder","asc");
		$this->db->order_by("credibility_name","asc");
		$query = $this->db->get($this->_table_credibility);
		$dropnames = $query->result();
		if($dropnames) {
			foreach($dropnames as $di=>$dnval) {
				$this->db->where('c_id',$dnval->c_id);
				$this->db->where('field_type','profile');
				$this->db->order_by("c_data_id","desc");
				$query = $this->db->get($this->_table_credibility_data);
				$cdrow = $query->row();
				if($cdrow) {
					$dnval->value=$cdrow->value;
					$dnval->c_data_id=$cdrow->c_data_id;
				}
				$dropnames[$di]=$dnval;
			}
			return $dropnames;
		}
		return array();
		/*$user_id =  $_SESSION['ss_user_id'];
		$ccquery="select c.*,ci.c_data_id,ci.value from ".$this->_table_credibility." c 
			left join ".$this->_table_credibility_data." ci on (ci.c_id=c.c_id and ci.field_type='profile') 
			where c.user_id=".$user_id." and c.trash=1 order by c.sorder,c.credibility_name 
		";
		$ccrows=$this->db->query($ccquery);
		return $ccrows->result();*/
	}
	//Get Campaigns from Trash
	function getTrashcampaign()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('*');
		$this->db->where('trash',1);
		$this->db->where('user_id',$user_id);
		$this->db->from($this->_table_campaign);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('campaign_name','asc');
		$query = $this->db->get();
		return $query->result();
	}

	//Email Templates with Tasks
	//Save template user
	function save_template_user($edata,$where=array())
	{
	   	if($where) {
	   		if(isset($where['temp_id'])) $this->db->where('temp_id',$where['temp_id']);
	   		if(isset($where['temp_user'])) $this->db->where('temp_user',$where['temp_user']);
	   		if(isset($where['campaign_id'])) $this->db->where('campaign_id',$where['campaign_id']);
	   		$this->db->update('tbl_template_user',$edata);
		} else {
	   		$this->db->insert('tbl_template_user',$edata);
		}	   	
	}
	function save_template_content($edata,$where=array())
	{
	   	if($where) {
	   		if(isset($where['temp_aid'])) $this->db->where('temp_aid',$where['temp_aid']);
	   		if(isset($where['temp_id'])) $this->db->where('temp_id',$where['temp_id']);
	   		if(isset($where['temp_user'])) $this->db->where('temp_user',$where['temp_user']);
	   		if(isset($where['campaign_id'])) $this->db->where('campaign_id',$where['campaign_id']);
	   		$this->db->update('tbl_template_content',$edata);
	   		$id = $where['temp_aid'];
		} else {
	   		$this->db->insert('tbl_template_content',$edata);
	   		$id = $this->db->insert_id();
		}	
		return $id;   	
	}
	//end of Email Templates with Tasks
	////
	
	//get interview email template
	public function get_intervew_Email_templates() 
	{
		$this->db->select('ts.sect_id,t.temp_id,t.temp_title');
		$this->db->from('tbl_templates t');
		$this->db->join("tbl_template_sections ts", 'ts.temp_id = t.temp_id');
		$this->db->where('t.temp_type','Interview Emails');
		$this->db->where_not_in('t.temp_id',array(74,75));
		$this->db->order_by("t.temp_sort","asc");
		$this->db->order_by("t.temp_title","asc");
		$get_value = $this->db->get();
		return $get_value->result();
	}
	//SIMPLE START CAMPAIGN
	//Save Campaign
	function save_campaign($data,$id=0)
	{
	   	if($id) {
	    	$this->db->where('id', $id);
	   		$this->db->update($this->_table_campaign,$data);
		} else {
	   		$this->db->insert($this->_table_campaign,$data);
	   		$id = $this->db->insert_id();
		}
	   	return $id;
	}
	//Save Campaign Values
	function save_campaign_values($data,$id=0)
	{
	   	if($id) {
	    	$this->db->where('id', $id);
	   		$this->db->update('tbl_tech_value',$data);
		} else {
	   		$this->db->insert('tbl_tech_value',$data);
	   		$id = $this->db->insert_id();
		}
	   	return $id;
	}
	//Save Campaign Pains
	function save_campaign_pains($data,$id=0)
	{
	   	if($id) {
	    	$this->db->where('id', $id);
	   		$this->db->update('tbl_tech_pain',$data);
		} else {
	   		$this->db->insert('tbl_tech_pain',$data);
	   		$id = $this->db->insert_id();
		}
	   	return $id;
	}
	//Save Campaign Questions
	function save_campaign_quests($data,$id=0)
	{
	   	if($id) {
	    	$this->db->where('id', $id);
	   		$this->db->update('tbl_tech_qualify',$data);
		} else {
	   		$this->db->insert('tbl_tech_qualify',$data);
	   		$id = $this->db->insert_id();
		}
	   	return $id;
	}
	//Save Campaign meta
	function save_campaign_meta($data,$id=0)
	{
	   	if($id) {
	    	$this->db->where('id', $id);
	   		$this->db->update('campaign_common',$data);
		} else {
	   		$this->db->insert('campaign_common',$data);
	   		$id = $this->db->insert_id();
		}
	   	return $id;
	}
	
}
/*end of campaigm model class */