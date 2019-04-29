<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chromeapp_model extends CI_Model 
{
	/**
	 * Properties
	 */
	private $_table_users;
	private $_table_campaign;
	private $_table_company;
	private $_table_crm_contacts;
	private $_table_crm_address;
	private $_table_crm_accounts;
	private $_table_crm_leads;
	private $_table_crm_oppurtinity;
	private $_table_crm_notes;
	private $_table_crm_tasks;
	private $_table_user_shared;
	private $_table_prospect_points;
	private $_table_objections_usage;
	private $_table_objections_count;
	private $_table_interaction_usage;
	private $_table_email_templates;	
	private $_table_crm_notifies;	
	private $_table_crm_schemail;
	

	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
        //Define Table names
        $this->_table_users		 				= $this->config->item('table_users');
		$this->_table_campaign 					= $this->config->item('table_campaigns');
		$this->_table_company 					= $this->config->item('table_company');
		$this->_table_crm_contacts		 		= $this->config->item('table_crm_contacts');
		$this->_table_crm_address		 		= $this->config->item('table_crm_address');
		$this->_table_crm_accounts		 		= $this->config->item('table_crm_accounts');
		$this->_table_crm_leads		 			= $this->config->item('table_crm_leads');
		$this->_table_crm_oppurtinity		 	= $this->config->item('table_crm_oppurtinity');
		$this->_table_crm_notes		 			= $this->config->item('table_crm_notes');
		$this->_table_crm_tasks		 			= $this->config->item('table_crm_tasks');
		$this->_table_user_shared		 		= $this->config->item('table_user_shared');
		$this->_table_prospect_points			= $this->config->item('table_prospect_points');
		$this->_table_objections_usage			= $this->config->item('table_objections_usage');
		$this->_table_objections_count			= $this->config->item('table_objections_count');
		$this->_table_interaction_usage			= $this->config->item('table_interaction_usage');
		$this->_table_email_templates			= $this->config->item('table_email_templates');
		$this->_table_crm_notifies				= $this->config->item('table_crm_notifies');
		$this->_table_crm_schemail				= $this->config->item('table_crm_schemail');
    }

    function ucustom_template($template,$campaign_id,$user_id) {
		$this->db->from('tbl_template_user');
		$this->db->where('temp_id',$template);
		$this->db->where('campaign_id',$campaign_id);
		$this->db->where('temp_user',$user_id);		
		$get_value = $this->db->get();
		$etemp = $get_value->result();
		if($etemp) return $etemp[0];
		return $etemp;
	}

    public function getUser($user_name) {
		$this->db->from('users');
		$this->db->where('username',$user_name);
		$get_value = $this->db->get();
		return $get_value->row_array();
	}

	//Save Task
	public function save_task($data,$task_id=0)
	{	   
		$this->db->insert($this->_table_crm_tasks,$data);
		$task_id = $this->db->insert_id();		
	   	return $task_id;
	}

	//Get Contact record
    public function get_contact($email,$parent_id) 
    {
		$user_id = $_SESSION['ss_user_id'];
		$this->db->select("c.contact_id,c.email");
		$this->db->where('c.email', $email);
		$this->db->where(" (c.userid=$parent_id or c.share_user_id=$parent_id)",NULL,FALSE);
		$this->db->from($this->_table_crm_contacts." c");
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
    	if ($query->num_rows() > 0)
    	{
			$row = $query->row_array();			
			return $row;
    	}
		return array();
    }

    

    /**
	 *  get campaign names
	 */
	function get_campaigns()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('campaign_id as id,campaign_name as title,status');
		$this->db->where('user_id',$user_id);
		$this->db->where('trash',0);
		$this->db->from($this->_table_campaign);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('campaign_name','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	//get companies
	function get_companies()
	{
		$user_id =  $_SESSION['ss_user_id'];
		$this->db->select('company_id as id,company_name as title,status');
		$this->db->where('trash',0);
		$this->db->where('user_id',$user_id);
		$this->db->from($this->_table_company);
		$this->db->order_by('sorder','asc');
		$this->db->order_by('company_name','asc');
		$query = $this->db->get();
		return $query->result_array();
	}
	
}
/*end of Chrome App model class */