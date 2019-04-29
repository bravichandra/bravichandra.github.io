<?php
/**
 *  attributue model class file 
 *  
 *  
 *  Perfom all attribute table realated task
 *  
 *  PHP 5.2
 *  
 *  @author Bineet Kumar Chaubey
 *  @version  1.2
 *  @package codeigniter
 *  @subpackage interview scripter
 *  @see
 *  @link
 *  
 */
class Attribute_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
    function __construct()
    {
        parent::__construct();
    }
    public function fetchAttributeWithCatID($cat_id)
    {

		//$user_id = $this->session->userdata('userid');
		$user_id = $this->_user_id;
		$allatribute = $this->db->query('select * from attributes where cat_id='.$cat_id.' and (user_id is NULL || user_id = '.$user_id.')');
	
		if($allatribute->num_rows > 0)
		{
           return $allatribute->result();
		}else
		{	
           return NULL;
		}
    }
	/**
	 *  Get attributes with identify Attribute ids 
	 */
	public function getAttibuteWithIdentAttr($iAttrids)
	{		
		//$user_id = $this->session->userdata('userid');
		$user_id = $this->_user_id;
		//$query = $this->db->query("SELECT * FROM attributes WHERE attributes.attr_id IN ($iAttrids) AND (user_id is NULL || attributes.user_id=".$user_id.")");
		$query = $this->db->query("SELECT a.*,c.cat_name FROM attributes a left join category c on (c.cat_id=a.cat_id) WHERE a.attr_id IN ($iAttrids) AND (a.user_id is NULL || a.user_id=".$user_id.")");
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	}
	/**
	 *  Get attributes with job id 
	 */
	public function getAttibuteWithJObID($jobID)
	{
		
		//echo $user_id; exit;
		//$user_id = $this->session->userdata('userid');
		$user_id = $this->_user_id;
		$query = $this->db->query("SELECT * FROM (job_profile_attr) JOIN attributes ON attributes.attr_id =job_profile_attr.attr_id WHERE job_id = ".$jobID." AND attributes.user_id is NULL || attributes.user_id=".$user_id);
		//echo $this->db->last_query(); 
		//echo '<pre>';
		//print_r($query);
		//echo '</pre>';
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	}
	/**
	 * fetch attribute with attributes id
	 */
	public function getQuestionWithAttr($attr_id)
	{
		//$user_id = $this->session->userdata('userid');
		$user_id = $this->_user_id;
		$query = $this->db->query('select * from questions where attr_id='.$attr_id.' and (user_id is NULL || user_id = '.$user_id.')');	
		
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	}
	/**
	 *   get all attribute list
	 */
	public function getAllAttribute()
	{
		$finalarray = array();
		$this->db->select("category.cat_id,category.cat_name, attributes.attr_id, attributes.attr_name ");
		$this->db->from('attributes');
		$this->db->join('category','attributes.cat_id = category.cat_id');
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			return $query->result();
		}else
		{	
           return $finalarray;
		}
	}
	/**
	 *  save attribute in database
	 */
	public function save($data)
	{	
		$query = $this->db->insert('attributes',$data);
		if($query)
		{
			return $this->db->insert_id();
		}
		return false;	
	}
	
	
	/**
	 *   get all attribute list
	 */
	public function getAttributeWithID($attrID)
	{
		$finalarray = array();
		$this->db->select("attributes.attr_id,attributes.attr_name , attributes.cat_id ");
		$this->db->from('attributes');
		$this->db->where('attributes.attr_id',$attrID);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			return $query->row();
		}else
		{	
           return $finalarray;
		}
	}
	/**
	 *  update attribute list
	 */
	public function update($attrFID,$data)
	{
		$query = $this->db->update('attributes',$data,array('attr_id' => $attrFID));
		return true;
	}
	
	// delete attribute
	public function deleteAttr($attr_id)
	{
		$this->db->where('attr_id',$attr_id);
		$this->db->delete('attributes');
	}
	
	
}
