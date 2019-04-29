<?php
/**
 *  user model class for 
 *  
 *  
 *  this model class is responsible to perfome all database related task to user table 
 *  
 *  PHP > 5.3
 *  @version 1.2
 *  @author Bineet kuamr chaubey
 *  
 */
class user_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
    function __construct()
    {
        parent::__construct();
    }
    public function checklogin($email,$password)
    {
        $result = $this->db->query("select * from users where uemail='$email' and upassword='$password'");
		if($result->num_rows > 0)
		{
           return $result->row();
		}else
		{	
           return NULL;
		}
    }
    public function adduser($fname,$lname,$address,$city,$email,$password,$userid)
    {
           $query = $result = $this->db->query("INSERT INTO `users` ( `user_id`,`fname` , `lname` , `uemail` , `upassword` , `address` , `city` ) VALUES ('$userid','$fname','$lname', '$email', '$password', '$address', '$city')");
           return $query;
    }
    public function checkuserbyemail($email)
    {
           $query = $this->db->query("select * from users where uemail='$email'");
           return $query;
    }
	/**
	 *  get user by Id
	 *  
	 *  @parmas integer $userid
	 */
    public function getuserbyid($userid)
    {
        $query = $this->db->query("select * from users where user_id='$userid'");       
		if($query->num_rows > 0) {
			return $query->row();
		}else{
			return false;
		}
    }
	
	public function changepassword()
	{
           $userid=$this->session->userdata('userid');
           $result=$this->db->query("select upassword from users where user_id='$userid'");
           return $result;
	}
	
	public function changepasswordprocess($password,$userid)
    {
           $userid = $this->session->userdata('userid');
           $result=$this->db->query("UPDATE `users` SET `upassword`='$password' WHERE user_id='$userid'");
           return $result;
    }
	/**
	 *  update  new password
	 */
    public function NewPassword($password,$userid)
    {
           $result=$this->db->query("UPDATE `users` SET `upassword`='$password' WHERE user_id='$userid'");
           return $result;
    }
	/**
	 *  edit user information 
	 */
	public function ediuser($fname,$lname,$address,$city,$email,$userid)
    {
           // $userid = $this->session->userdata('userid'); 
           $result = $this->db->query("UPDATE `users` SET `fname`='$fname',`lname`='$lname',`address`='$address',`city`='$city',`uemail`='$email' WHERE user_id='$userid'");
           return $result;
    }
	
	/**
	 *  fetch all user for admin
	 */
	public function getAllUserForAdmin($search = NULL,$page = NULL,$per_page=10)
	{
		$this->db->where('is_admin','0');
		
		if($search!=NULL)
		{
			$this->db->like('fname',$search);
		}
		if($page!=NULL)
		{
			$startpoint = ($page-1)* $per_page ;
			$this->db->limit($per_page,$startpoint);
		}
		$query = $this->db->get('users');
		// echo $this->db->last_query(); die();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		
		return array();
	}
	
	/**
	 *  fetch count for user for admin
	 */
	public function getTotalUserCountForAdmin($search=NULL)
	{
		$this->db->select('count(user_id) as totalcount');
		if($search!=NULL)
		{
			$this->db->like('fname',$search);
		}
		$this->db->where('is_admin','0');
		$query = $this->db->get('users');
		if($query->num_rows > 0)
		{
			return $query->row()->totalcount;
		}
		return null;
	}
	
}