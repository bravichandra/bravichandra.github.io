<?php
/**
 *  This is Category Model class file
 *   
 *  
 *  
 *  PHP > 5.2
 *  @version 1.1
 *  @author Bineet kumar chaubey
 *  @package Codeigniter
 *  @subpackage InterviewScripter
 *  @link
 *  @see
 */
class Category_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
    function __construct()
    {
        parent::__construct();
    }
	/**
	 *  
	 */
    public function profileattributes()
    {		
		$query = $this->db->query("select * from category WHERE cat_id!=7");
		if($query->num_rows > 0)
		{
			return $query->result();
		}else
		{	
           return NULL;
		}		
    }
	/**
	 *   get category 
	 */
    public function getCategoryAll()
    {		
		$query = $this->db->query("select cat_id,cat_name from category ");
		if($query->num_rows > 0)
		{
			return $query->result();
		}else
		{	
           return NULL;
		}		
    }
	
	/**
	 *   get category 
	 */
    public function getCategoryAllWithAttr()
    {		
	
		$finalarray = array();
		$this->db->select("category.cat_id,category.cat_name, attributes.attr_id, attributes.attr_name ");
		$this->db->from('category');
		$this->db->join('attributes','attributes.cat_id = category.cat_id');
		$this->db->where('attributes.user_id',NULL);
	
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			foreach($query->result()   as $singlecate)
			{
				$finalarray[$singlecate->cat_id]['cat_name'] = $singlecate->cat_name;
				$finalarray[$singlecate->cat_id]['atributes'][] = array(
																		'attr_id' => $singlecate->attr_id ,
																		'attr_name' => $singlecate->attr_name
																		);
			}
			
			return $finalarray;
		}else
		{	
           return $finalarray;
		}		
    }
	
	/**
	 *   save record in database
	 */
	public function save($data)
	{
		$query = $this->db->insert('category',$data);
		if($query)
		{
			return $this->db->insert_id();
		}
		return  false;
	}
	/**
	 *  Get single category info about id 
	 */
	public function getSingleCatByID($catID)
	{
		$query = $this->db->from('category')->where('cat_id',$catID)->get();
		if($query->num_rows > 0)
		{
			return $query->row();
		}else{
			return false;
		}
	}
	
	public function update($cat_ID,$save_array)
	{
		$this->db->update('category',$save_array,array('cat_id' => $cat_ID));
		return true;
	}
	
	
	
	
	
	
}
