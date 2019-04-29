<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  salescripter  product_model  class model file
 *  
 *  PHP 5.2
 *  @version 1.0
 *  @author Bineet Kumar Chaubey
 *  @package Codeigniter
 *  @subpackage Salescripter
 */
class Product_model extends CI_Model 
{
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
	private $_table_vit_ignore;//by Dev@4489
	static  $uniquecount = 1;
	static  $uniquename;

    function __construct()
    {
        parent::__construct();
        //Define Table names
        $this->_table_users		 				= $this->config->item('table_users');
        $this->_table_values 	 				= $this->config->item('table_values');
        $this->_table_plains 	 				= $this->config->item('table_plains');
        $this->_table_close 					= $this->config->item('table_close');
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
		$this->_table_vit_ignore 				= $this->config->item('table_vit_ignore');//by Dev@4489
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
    	$query = $this->db->get($this->_table_products);
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    }

    public function get_all_users_credibilities() 
    {
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
			case 'tvd' ;
			  return $this->_table_tech_value;
			break;
			case 'ccd' ;
			  return $this->_table_campaign_comm;
			break;
			case 'bvd' ;
			  return $this->_table_biz_value;
			break;
			case 'pvd' ;
			  return $this->_table_per_value;
			break;
			case 'tpnd' ;
			  return $this->_table_tech_pain;
			break;
			case 'bpd' ;
			  return $this->_table_biz_pain;
			break;
			case 'ppd' ;
			  return $this->_table_per_pain;
			break;
			case 'tqd' ;
			  return $this->_table_tech_qualify;
			break;
			case 'bqd' ;
			  return $this->_table_biz_qualify;
			break;
			case 'pqd' ;
			  return $this->_table_per_qualify;
			break;
    	}
    }
	
	public function create_product($product_name = NULL)
	{
	    $user_id = $_SESSION['ss_user_id'];	
		
		if($product_name == NULL) {
			$create_product = array('user_id' => $user_id,'product_name' => 'default-product');
		}else{
			$create_product = array('user_id' => $user_id,'product_name' => $product_name);
		}
		
		$this->db->insert($this->_table_products,$create_product);
		$product_id = $this->db->insert_id();
		/* echo $this->db->last_query();
		 die(); */
		$create_product_data = array('product_id' => $product_id,'field_type' => 'P_Q1','value' => $product_name?$product_name:'[my product]');		
		$this->db->insert($this->_table_product_data,$create_product_data);
		
		
		$Product_desc_data = array('product_id' => $product_id,'field_type' => 'P_Desc','value' => 'Describe You Product');		
		$this->db->insert($this->_table_product_data,$Product_desc_data);
		
		/* create how we diffirentiat out competitor three answer */
		$i = 1;
		for($i;$i<=3;++$i){
			//$differ_data =  array('product_id' => $product_id,'field_type' => 'interestB'.$i,'value' => '[differentiation point '.$i.']');	
			$differ_data =  array('product_id' => $product_id,'field_type' => 'interestB'.$i,'value' => '');	
			$this->db->insert($this->_table_product_data,$differ_data);
			
		}
		
		/**
		 *  Three negative impact 
		 */
		/* 
		$j = 1;
		for($j;$j<=3;++$j){
			$negative_data =  array('product_id' => $product_id,'field_type' => 'negative_impact'.$j,'value' => '[impact of doing nothing '.$j.']');	
			$this->db->insert($this->_table_product_data,$negative_data);	
		} */
		
		return $product_id;
	}
	
	/**
	 *   Create a new campaign and all its question 
	 */
	//public function createNewCampaign()
	public function createNewCampaign($campaign_name='default-campaign',$organization='business',$prod_id=0)
	{
	    $user_id = $_SESSION['ss_user_id'];	
		
		$progresvalue = array(
							   "start" => false,
							   "workflow" => false,
							   "product" => false,
							   "value"=> false,
							   "value2" => false,
							   "value3" => false, 
							   "pain" => false,
							   "ideal_prospect_environment" => false,
							   "sales_process" => false,
							   "credibility" => false,
							   "qualify" => false,
							   "interest" => false,
							   "objection" => false
							  );
		$progressvaluetosave = json_encode($progresvalue);
		
		$campaign_dafault = array(
								'user_id' => $user_id,
								'campaign_name' => $campaign_name,//by Dev@4489
								'individual' => 'target audience',
								'organization' => $organization,//by Dev@4489
								'campaign_target' => '2',
								'product_id' => $prod_id,//by Dev@4489
								'progress_data' => $progressvaluetosave,
								);
		$this->db->insert($this->_table_campaign,$campaign_dafault);
		$campain_id = $this->db->insert_id();
		/* echo $this->db->last_query();
		die(); */	
			
		$k = 1;
		//by Dev@4489
		/*for($k;$k <= 3; ++$k){	
			$this->createTechValue($campain_id,$k);
		}*/
		$this->createTechValue($campain_id,$k);
		////
		/** inseart single tech value */
		$val_summary =  array(
								array(
									'campaign_id' => $campain_id, 
									'field_type' => 'tech_val_summary',
									'value' =>  'technical value 1'
									),
								array(
									'campaign_id' => $campain_id, 
									'field_type' => 'bus_val_summary',
									'value' => 'business value 1'
									),
								array(
									'campaign_id' => $campain_id, 
									'field_type' => 'per_val_summary',
									'value' => 'personal value1'
									),
								array(
									'campaign_id' => $campain_id, 
									'field_type' => 'sale_process_close1',
									'value' => 'brief 15 to 20 minute meeting'
									),
								array(
									'campaign_id' => $campain_id, 
									'field_type' => 'sale_process_close2',
									'value' => 'discuss your goals and challenges and share any value and insight that we have to offer',
									),
								array(
									'campaign_id' => $campain_id, 
									'field_type' => 'sale_process_close3',
									'value' => 'get email address and send email with information',
									),
							);
							
		$this->db->insert_batch($this->_table_campaign_comm, $val_summary);
		
		// make this campaign  active with database //	
		$this->makeActiveCampaign($campain_id);
		return $campain_id;
	}
	/**
	 *  make active a campaign
	 *  
	 *  @param [in] $campain_id Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function makeActiveCampaign($campain_id)
	{
		$c_user_id = $_SESSION['ss_user_id'];
		$this->db->where('user_id',$c_user_id);
		$updatedata = array('status' => '0');
		$this->db->update($this->_table_campaign,$updatedata);
		// echo $this->db->last_query();
		/** now make campain active */
		$this->db->where('campaign_id',$campain_id);
		$newupdatedata = array('status' => '1');
		$this->db->update($this->_table_campaign,$newupdatedata);
		// echo $this->db->last_query();
	}
	
	/**
	 *  Create Tech value deafult question and Answer 
	 *  
	 *  @param [in] $campaign_id Parameter_Description
	 *  @param [in] $qus_no Parameter_Description
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function createTechValue($campaign_id,$qus_no)
	{
		$techvaluedata = array('campaign_id' => $campaign_id ,'field_type' => 'tech_value','value' => 'Value'.$qus_no,'qus_id' => $qus_no);
		$this->db->insert($this->_table_tech_value,$techvaluedata);
		$tech_v_id = $this->db->insert_id();
		/** create bussiness value */
		$this->createBizValue($campaign_id,$tech_v_id,$qus_no);
		$this->createTechPain($campaign_id,$tech_v_id,$qus_no);
		$this->createTechVSpersonalVal($campaign_id,$tech_v_id,$qus_no);
		return $tech_v_id;
	}
	
	function createBizValue($campaign_id,$tech_v_id,$qus_no)
	{
		/** there are three question for a single tech question */
		$j = 1 ;
		$sym = (($qus_no-1)*3)+1 ;
		for($j;$j<=3;++$j){
		
		    // s$sym = ($j-1)* $qus_no;
			$biz_value_data = array('tech_v_id' => $tech_v_id, 'campaign_id' => $campaign_id ,'field_type' => 'biz_value','value' => 'business value'.$sym,'qus_id' => $j);
			$this->db->insert($this->_table_biz_value,$biz_value_data);
			$biz_value_id = $this->db->insert_id();
			/** create new record for personal value **/
			$this->createPersonalvalue($campaign_id,$biz_value_id,$sym);
			$this->createBizPain($campaign_id,$biz_value_id,$j);
			++$sym;
		}
	}
	/**
	 *   create  personal value question
	 */
	function createPersonalvalue($campaign_id,$biz_value_id,$sym)
	{
		$pers_val_data = array('biz_v_id' => $biz_value_id, 'campaign_id' => $campaign_id ,'field_type' => 'pers_value','value' => 'personal value'.$sym,'qus_id' => $sym);
		$this->db->insert($this->_table_per_value,$pers_val_data);
		$per_val_id = $this->db->insert_id();
		
	    /**  add curresponding  personal pain question **/
	    $this->createPerPain($campaign_id,$per_val_id,$sym);
		return $per_val_id;
	}
	
	/**
	 *  Create  personal value question based on technical value question
	 *  There are a relation ship between technical value Q/A and Personal Value Q/A 
	 */
	function createTechVSpersonalVal($campaign_id,$tech_val_id,$sym)
	{
		$pers_val_data = array('tech_v_id' => $tech_val_id, 'campaign_id' => $campaign_id ,'field_type' => 'pers_value','value' => 'personal value'.$sym,'qus_id' => $sym);
		$this->db->insert($this->_table_per_value,$pers_val_data);
		$per_val_id = $this->db->insert_id();
		
		/**  add curresponding  personal pain question **/
	    $this->createPerPain($campaign_id,$per_val_id,$sym);
		
		return $per_val_id;
	}
	
	/**
	 *   Create personal pain defalt question answer
	 */
	public function createPerPain($campaign_id,$per_val_id,$sym)
	{
		$pers_pain_data = array('per_v_id' => $per_val_id, 'campaign_id' => $campaign_id ,'field_type' => 'pers_pain','value' => 'personal pain'.$sym,'qus_id' => $sym);
		$this->db->insert($this->_table_per_pain,$pers_pain_data);
		$per_p_id = $this->db->insert_id();
		
		/**  need to create  personal qualify question **/
		$this->createPerQualify($campaign_id,$per_p_id,$sym);
		return $per_p_id;
	}
	
	public function createPerQualify($campaign_id,$per_p_id,$sym)
	{
		$pers_qualify_data = array('per_p_id' => $per_p_id, 'campaign_id' => $campaign_id ,'field_type' => 'pers_qualify','value' => 'personal qualify'.$sym,'qus_id' => $sym);
		$this->db->insert($this->_table_per_qualify,$pers_qualify_data);
		$per_q_id = $this->db->insert_id();
		return $per_q_id;
	}
	/**
	 *   create business pain default question 
	 */ 
	public function createBizPain($campaign_id,$biz_value_id,$sym)
	{	
		$bus_pain_data = array('biz_v_id' => $biz_value_id, 'campaign_id' => $campaign_id ,'field_type' => 'bus_pain','value' => 'business pain'.$sym,'qus_id' => $sym);
		$this->db->insert($this->_table_biz_pain,$bus_pain_data);
		$biz_p_id = $this->db->insert_id();
		$this->createBizQualify($campaign_id,$biz_p_id,$sym);
		return $biz_p_id;	
	}
	
	public function createBizQualify($campaign_id,$biz_p_id,$sym)
	{
		$bus_qualify_data = array('biz_p_id' => $biz_p_id, 'campaign_id' => $campaign_id ,'field_type' => 'bus_qualify','value' => 'business qualify'.$sym,'qus_id' => $sym);
		$this->db->insert($this->_table_biz_qualify,$bus_qualify_data);
		$biz_q_id = $this->db->insert_id();
		return $biz_q_id;
	}
	
	function createTechPain($campaign_id,$tech_v_id,$qus_no)
	{
		$tech_pain_data = array('tech_v_id' => $tech_v_id, 'campaign_id' => $campaign_id ,'field_type' => 'tech_pain','value' => 'Common Problem'.$qus_no,'qus_id' => $qus_no);
		$this->db->insert($this->_table_tech_pain,$tech_pain_data);
		$tech_pain_id = $this->db->insert_id();
		$this->createTechQualify($campaign_id,$tech_pain_id,$qus_no);
		return $tech_pain_id;
		
	}
	
	
	
	/**
	 *   create tech qualify default question answer
	 */
	public function createTechQualify($campaign_id,$tech_pain_id,$qus_id)
	{
		$tech_qualify_data = array('tech_p_id' => $tech_pain_id, 'campaign_id' => $campaign_id ,'field_type' => 'tech_qualify','value' => 'Qualify'.$qus_id,'qus_id' => $qus_id);
		$this->db->insert($this->_table_tech_qualify,$tech_qualify_data);
		$tech_qualify_id = $this->db->insert_id();
		return $tech_qualify_id;
	}
	/**
	 *  
	 */
	public function UpdateCamStep1($data,$camp_id)
	{
		$c_user_id = $_SESSION['ss_user_id'];
		$this->db->where('user_id',$c_user_id);
		$this->db->where('campaign_id',$camp_id);
		$this->db->update($this->_table_campaign,$data);
		// echo $this->db->last_query();
	}
	/**
	 *   get  product info  
	 */
	public function getProduct($product_id)
	{
		$this->db->where('product_id',$product_id);
		$record = $this->db->get($this->_table_products);
		if($record->num_rows > 0)
		{
			return $record->row();
		}
	     return false;
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
	 *   get product meta data 
	 */
	public function getProMetaData($product_id,$key_name)
	{
		$this->db->where('field_type',$key_name);
		$this->db->where('product_id',$product_id);
		$record = $this->db->get($this->_table_product_data);
		if($record->num_rows > 0)
		{
			return $record->row();
		}
		return false;
	}
	public function add($tbl_data)
	{
		if(!empty($tbl_data)){
		
			foreach($tbl_data as $table_name => $pre_name)
			{
				foreach($pre_name  as $primary_id => $key_value)
				{
					foreach($key_value as $key => $value)
					{
						$realtablename = $this->_get_table_name($table_name);
						$primary_key = $this->get_Primary_key($realtablename);
						$this->db->where('field_type',$key);
						$this->db->where($primary_key,$primary_id);
						$updaterecord = array('value' => $value);
						$this->db->update($realtablename,$updaterecord);
						// echo $this->db->last_query();
						// echo $this->db->last_query();
					}
				}
			}
		}		
	}
	/**
	 *  get primary key for each table
	 */
	function get_Primary_key($table_name)
	{
		switch($table_name)
		{
			case 'product_data';
				return 'product_data_id';
			break;
			case 'products';
				return 'product_id';
			break;
			case 'campaign_common';
				return 'cam_com_id';
				break;
			case 'tbl_tech_value';
				return 'tech_v_id';
			break;
			case 'tbl_biz_value';
				return 'biz_v_id';
			break;
			case 'tbl_per_value';
				return 'per_v_id';
			break;
			case 'tbl_tech_pain';
				return 'tech_p_id';
			break;
			case 'tbl_biz_pain';
				return 'biz_p_id';
			break;
			case 'tbl_per_pain';
				return 'per_p_id';
			break;
			case 'tbl_tech_qualify';
				return 'tech_q_id';
			break;
			case 'tbl_biz_qualify';
				return 'biz_q_id';
			break;
			case 'tbl_per_qualify';
				return 'per_q_id';
			break;
			default :
				return false;
			break;
		}
	}
	/***
	 *   update product name on post method
	 */
	public function updateProductName($product_id)
	{
		$pr_name = $_POST['product_name'];
		$c_user_id = $_SESSION['ss_user_id'];
		$upd = array('product_name' => $pr_name);
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id',$c_user_id);
		return $this->db->update($this->_table_products,$upd);
	}
	
	/***
	 *   update product name on post method
	 */
	public function updateProductNameWithservicename($product_id,$newname)
	{
		$pr_name = $newname;
		$c_user_id = $_SESSION['ss_user_id'];
		$upd = array('product_name' => $pr_name);
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id',$c_user_id);
		return $this->db->update($this->_table_products,$upd);
	}
	
	/**
	 *  
	 */
	function edit_campaign($campaign_id)
	{
		$this->makeActiveCampaign($campaign_id);
	}
	/**
	 *   delete campaign section 
	 */
	
	function deleteCampaignSec($p_id,$campaign_id,$tblname,$user_id)
	{
		$this->db->select('campaign_id');
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('user_id',$user_id);
		$finddata = $this->db->get($this->_table_campaign);
		
		if($finddata->num_rows > 0)
		{
			$realtablename = $this->_get_table_name($tblname);
			$primary_key = $this->get_Primary_key($realtablename);
			$this->db->where('campaign_id',$campaign_id);
			$this->db->where($primary_key,$p_id);
			$this->db->delete($realtablename);
		}
	}
	/**
	 *   Delete  product table
	 */
	public function deleteProduct($product_id)
	{
		$user_id = $_SESSION['ss_user_id'];
		/**
		 *  first check this product to associate any campaign or nothing
		 */
		
		$this->db->select('campaign_id');
		$this->db->from($this->_table_campaign);
		$this->db->where('product_id',$product_id);
		$query = $this->db->get();
		if($query->num_rows > 0){
			return false;
		}
		/**
		 *   delete product 
		 */
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id',$user_id);
		$this->db->delete($this->_table_products);
		// echo $this->db->last_query();
		return true;
	}
	
	/**
	 *   update product name on inline edit event
	 */
	public function update_product_name($product_id,$data)
	{ 
		$c_user_id = $_SESSION['ss_user_id'];
		$this->db->where('product_id',$product_id);
		$this->db->where('user_id',$c_user_id);
		return $this->db->update($this->_table_products,$data);
		// echo $this->db->last_query();
	}
	
	
	/**
	 *    create a single business question and andwer 
	 */
	function createDynamciBizValue($campaign_id,$tech_v_id,$qus_no)
	{
		/** there are three question for a single tech question */
		
		// s$sym = ($j-1)* $qus_no;
		$biz_value_data = array('tech_v_id' => $tech_v_id, 'campaign_id' => $campaign_id ,'field_type' => 'biz_value','value' => 'business value'.$qus_no,'qus_id' => $qus_no);
		$this->db->insert($this->_table_biz_value,$biz_value_data);
		
		
		$biz_value_id = $this->db->insert_id();
		/** create new record for personal value **/
		$this->createPersonalvalue($campaign_id,$biz_value_id,$qus_no);
		$this->createBizPain($campaign_id,$biz_value_id,$qus_no);
		return $biz_value_id ;
	}
	/**
	 *  Check uniquness product name
	 */
	public function checkprodcutnameUniqune($pname,$editproduct_id)
	{
		$user_id = $_SESSION['ss_user_id'];
		
		if(!isset(self::$uniquename)){
			self::$uniquename = $pname;
		}
		
		$this->db->select('count(product_id) as totalcount');
		$this->db->where('user_id',$user_id);
		$this->db->where('product_name',$pname);
		$this->db->where('product_id !=',$editproduct_id);
		$record = $this->db->get($this->_table_products);
		// echo $this->db->last_query();		
		if($record->row()->totalcount > 0 ){
			self::$uniquecount += $record->row()->totalcount ;
			$checkname = self::$uniquename.self::$uniquecount ;
			return $this->checkprodcutnameUniqune($checkname,$editproduct_id) ;
		}else{
			return $pname;
		}
		
	}
	
	
	
	public function isProductNameSame($product_id,$pname)
	{
		$user_id = $_SESSION['ss_user_id'];
		// $this->db->select('count(product_id) as totalcount');
		// $this->db->where('user_id',$user_id);
		$this->db->where('product_name',$pname);
		$this->db->where('product_id',$product_id);
		$record = $this->db->get($this->_table_products);
		// echo $this->db->last_query();
		
		if($record->num_rows > 0 ){
			return true ;
		}
		return false;
	}
	/**
	 *  check is user is valid for that campaign
	 *  
	 */
	public function isCampaignValidUser($user_id,$campaign_id)
	{
		$this->db->where('user_id',$user_id);
		$this->db->where('campaign_id',$campaign_id);
		$query = $this->db->get($this->_table_campaign);
	    if($query->num_rows > 0)
		{
			return $query->row(); 
		}
		return false; 
	}
	
	/**
	 *  dynamic update with output pages
	 */
	public function dym_camp_update_entry($tbl_name,$prim_id,$key_value,$camp_id)
	{
		$table_name = $this->_get_table_name($tbl_name);
		$primary_key = $this->get_Primary_key($table_name);
		$update_data = array('value' => $key_value);
		$this->db->where('campaign_id',$camp_id);
		$this->db->where($primary_key,$prim_id);
		$this->db->update($table_name,$update_data);
		// echo $this->db->last_query();
	}
	
	/**
	 *  Find active campany info  or last company info
	 *  
	 */
	public function getCompanyInfo($user_id){
	
		$this->db->where('user_id',$user_id);
		$this->db->where('status','1');
		$query = $this->db->get($this->_table_company);
		if($query->num_rows > 0)
		{
			return $query->row();
		}else{
			$this->db->where('user_id',$user_id);
			$this->db->order_by('company_id','DESC');
			$this->db->limit(1);
			$query2 = $this->db->get($this->_table_company);
			if($query2->num_rows > 0){
				return $query2->row();
			}else{
				return false;
			}
		}	
	}
	/**
	 *  get all metadata of a company 
	 */
	public function getAllMetaValue($company_id)
	{
		$query = $this->db->where('company_id',$company_id)->get($this->_table_company_data);
		$cmp = array();
		if($query->num_rows > 0){
			foreach($query->result() as $singleresult){
				
				if($singleresult->meta_key == 'interest'){
					$cmp['interest'][] = $singleresult->meta_value;
				}else{
					$cmp[$singleresult->meta_key] = $singleresult->meta_value;
				}	
			}
			return $cmp;
		}else{
			return false;
		}
		
	}
	//by Dev@4489
	//File with existing answer	
	//get user all product answers
	/**
	 *  fecth record form product_data table
	 */
	public function getProMetaDatas($product_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,product_data_id as answid');
		$this->db->from($this->_table_product_data);
		$this->db->join($this->_table_products, $this->_table_products.'.product_id = '.$this->_table_product_data.'.product_id');
		$this->db->where($this->_table_products.'.user_id',(int)$user_id);
		$this->db->where($this->_table_products.'.product_id !=',(int)$product_id);
		//$this->db->where($this->_table_product_data.'.field_type !=', 'P_Q1');
		$this->db->where_in($this->_table_product_data.'.field_type ', array('interestB1','interestB2','interestB3'));
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	
	/**
	 *  fecth template user record form product_data table 29-2-2016 by Dev@4489
	 */
	public function getTuserProMetaDatas()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,product_data_id as answid');
		$this->db->from($this->_table_product_data);
		$this->db->join($this->_table_products, $this->_table_products.'.product_id = '.$this->_table_product_data.'.product_id');
		$this->db->where($this->_table_products.'.user_id',(int)$user_id);
		//$this->db->where($this->_table_product_data.'.field_type !=', 'P_Q1');
		$this->db->where_in($this->_table_product_data.'.field_type ', array('interestB1','interestB2','interestB3'));
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		//echo $this->db->last_query();			
		return $getvalue->result();
	}
	//get user all product answers description
	/**
	 *  fecth record form product_data table
	 */
	public function getProMetaDesc($product_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,product_data_id as answid');
		$this->db->from($this->_table_product_data);
		$this->db->join($this->_table_products, $this->_table_products.'.product_id = '.$this->_table_product_data.'.product_id');
		$this->db->where($this->_table_products.'.user_id',(int)$user_id);
		$this->db->where($this->_table_products.'.product_id !=',(int)$product_id);
		$this->db->where($this->_table_product_data.'.field_type', 'P_Desc');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();	
		//echo $this->db->last_query();	
		return $getvalue->result(); 
	}
	
	/**
	 *  fecth template user record form product_data table 03-03-2016 by Dev@4489
	 */
	public function getTuserProMetaDesc()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,product_data_id as answid');
		$this->db->from($this->_table_product_data);
		$this->db->join($this->_table_products, $this->_table_products.'.product_id = '.$this->_table_product_data.'.product_id');
		$this->db->where($this->_table_products.'.user_id',(int)$user_id);
		$this->db->where($this->_table_product_data.'.field_type', 'P_Desc');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
				
		return $getvalue->result();
	}
	//get user all product names
	/**
	 *  fecth record form product_data table
	 */
	public function getProMetaNames($product_id)
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('value,product_data_id as answid');
		$this->db->from($this->_table_product_data);
		$this->db->join($this->_table_products, $this->_table_products.'.product_id = '.$this->_table_product_data.'.product_id');
		$this->db->where($this->_table_products.'.user_id',(int)$user_id);
		$this->db->where($this->_table_products.'.product_id !=',(int)$product_id);
		$this->db->where($this->_table_product_data.'.field_type', 'P_Q1');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();
		//echo $this->db->last_query();		
		return $getvalue->result();
	}
	
	/**
	 *  fecth template user record form product_data table 29-2-2016 by Dev@4489
	 */
	public function getTuserProMetaNames()
	{
		$user_id =  $this->_template_user;
		$this->db->select('value,product_data_id as answid');
		$this->db->from($this->_table_product_data);
		$this->db->join($this->_table_products, $this->_table_products.'.product_id = '.$this->_table_product_data.'.product_id');
		$this->db->where($this->_table_products.'.user_id',(int)$user_id);
		$this->db->where($this->_table_product_data.'.field_type', 'P_Q1');
		$this->db->order_by("value","asc");
		$getvalue = $this->db->get();		
		return $getvalue->result();
	}
	////
	//CAMPAIGN COORDINATES
	//Save multiple selected potentials campaigns
	public function create_combination_campaigns($pcampaigns)
	{
		$user_id = $_SESSION['ss_user_id'];	
		$pc_acts = array(0,0,0);
		foreach($pcampaigns as $pcv) {
			$pc_name = explode("-",$pcv);
			$prod_id = (int)$pc_name[1];
			$prosp_id = (int)$pc_name[0];
			//Product
			$this->db->select('product_name');
			$this->db->from($this->_table_products);
			$this->db->where('user_id',$user_id);
			$this->db->where('product_id',$prod_id);
			$get_value = $this->db->get();
			$product = $get_value->result();
			if($product) $product = $product[0];
			//Target Prospect
			$this->db->select('tp_text');
			$this->db->from('tbl_target_prospect');
			$this->db->where('tp_user',$user_id);
			$this->db->where('tp_id',$prosp_id);
			$get_value = $this->db->get();
			$targetp = $get_value->result();
			if($targetp) $targetp = $targetp[0];
			if(!$product || !$targetp) {
				$pc_acts[0] = 1;//Campaign coordinates not found
				continue;
			}	
			//check campaign exists
			$campaign_name = $product->product_name." for ".$targetp->tp_text;
			$this->db->from($this->_table_campaign);
			$this->db->where('user_id',$user_id);
			$this->db->where('campaign_name',$campaign_name);
			$get_value = $this->db->get();
			$campaign_row = $get_value->result();
			if($campaign_row) {
				$pc_acts[1] = 1;//Campaign already exists
				continue;
			}	
			$organization=$targetp->tp_text;
			$cgid = $this->createNewCampaign($campaign_name,$organization,$prod_id);	
			$pc_acts[2] = 2;//Campaign created
		}		
		if($pc_acts[2]) return "2";
		else if($pc_acts[1]) return "1";
		return "0";
	}
	
	/**
	 *   create campaign new product name
	 */
	public function campaign_new_product_name($product_name)
	{ 
		$c_user_id = $_SESSION['ss_user_id'];
		$data = array(
					'user_id' => $c_user_id,
					'product_name' => $product_name
				);
		$this->db->insert($this->_table_products,$data);		
		$product_id = $this->db->insert_id();
		return $product_id;
	}
	////end of CAMPAIGN COORDINATES
	////
	//by Dev@4489
	//save campaign additional qualify questions
	public function extra_questions($tbl_data,$active_campaign){
		if(!empty($tbl_data)){
		
			foreach($tbl_data as $table_name => $pre_name)
			{
				foreach($pre_name  as $primary_id => $key_value)
				{
					if(empty($key_value['value'])) continue;
					$realtablename = $this->_get_table_name($table_name);
					$primary_key = $this->get_Primary_key($realtablename);
					$updaterecord = array('value' => $key_value['value'],
											'field_type'=>'tech_qualify',
											'qus_id' => (int)$key_value['qorder'],
											'campaign_id' => $active_campaign,
											'q_col' => $primary_id);
					$this->db->insert($realtablename,$updaterecord);					
				}
			}
		}
	}
	//VALUE IDENTIFIER TOOL: saving ignore questions
	public function vit_ignore_save($vit_igdata,$campid,$iqtype='t')
	{			
		if(!empty($vit_igdata))
		{		
			//delete existance
			$this->db->where('campaign_id',$campid);
			$this->db->where('iqtype',$iqtype);
			$this->db->delete($this->_table_vit_ignore);					
			//insert record
			$updaterecord = array('campaign_id' => $campid,'iqlist' => $vit_igdata,'iqtype' => $iqtype);
			$this->db->insert($this->_table_vit_ignore,$updaterecord);
		}
	}
	//VALUE IDENTIFIER TOOL: get ignore questions
	public function vit_ignore_get($campid)
	{
		$this->db->select('qid,iqlist');
		$this->db->from($this->_table_vit_ignore);
		$this->db->where('campaign_id',$campid);
		$getvalue = $this->db->get();
		if ($getvalue->num_rows() > 0)
    	{
    		return $getvalue->row()->iqlist;
    	}
		return '';
	}
	////
	
	
	
	
	
}
/* End of file campaign.php */
/* Location: ./application/controllers/campaign.php */