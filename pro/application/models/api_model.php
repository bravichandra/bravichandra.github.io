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
class Api_model extends CI_Model 
{
	/**
	 * Properties
	 */
	 
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
	private $_table_ios_payments;
	 
	 
	 
	function __construct()
		{
			parent::__construct();
			  
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
			$this->_table_ios_payments 				= $this->config->item('table_ios_payments');
	}
/** dropdown **/	
	function get_drop_campaign()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('campaign_id,campaign_name,status');
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->from($this->_table_campaign);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('campaign_name','asc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_drop_company()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('company_id , company_name,status');
		$this->db->where('trash',0);
		$this->db->where('user_id',$user_id);
		$this->db->from($this->_table_company);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('company_name','asc');	
		$query = $this->db->get();
		return $query->result();		
	}
	

	function get_drop_name_profiles()
	{	
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('c_id , credibility_name,status');
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->order_by("sorder","asc");
		$this->db->order_by("credibility_name","asc");
		$query = $this->db->get($this->_table_credibility);
		//echo $this->db->last_query();
		//return $query->result();
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
	
	}
	/** dropdown **/
	public function get_alltemplates($sect)
	{
		//Original template
		$this->db->select('temp_id,temp_title,temp_sort,temp_slug');
		$this->db->from('tbl_templates');
		$this->db->where('temp_type',$sect);
		if($sect=="Sales Scripts")
			$this->db->where_not_in('temp_id',array(12,13,14));
		else if($sect=="Interview Emails")
			$this->db->where_not_in('temp_id',array(74,75));
		else if($sect=="Emails and Letters")	
			$this->db->where('((temp_id BETWEEN 15 and 30) OR temp_id in (68,69,70,71,73))',NULL,NULL);
		else if($sect=="Voicemail Scripts")
			$this->db->where_in('temp_id',array(31,32,33,34));
		//else
		//$this->db->where_not_in('temp_id',array(12,13,14));		
		$this->db->order_by("temp_sort","asc");
		$get_value = $this->db->get();
		return $get_value->result();
	}
	

	//Save IOS Payment
	function save_payment($data,$where=array())
	{
	   $id = 0;	
	   if($where) {
	   		foreach($where as $wk=>$wval)
	   			$this->db->where($wk, $wval);
	   		$this->db->update($this->_table_ios_payments,$data);
		} else {
	   		$this->db->insert($this->_table_ios_payments,$data);
	   		$id = $this->db->insert_id();
		}	
	   	return $id;
	}
	//Get expired ios payments
	public function get_expired_ios_payments() {
		//$this->db->select("s.*,c.user_first,c.user_last,c.email");
		$this->db->from($this->_table_ios_payments);
		$this->db->where('status', 1);
		$this->db->where("end_date<'".date("Y-m-d")."'",NULL,FALSE);
		$this->db->order_by('end_date', 'asc');
    	$query = $this->db->get();
		//echo $this->db->last_query().'--';
    	if ($query->num_rows() > 0)
    	{
			return $query->result();
    	}
		return array();
	}
}