<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 *  This is crmlite model class file.

 *  @PHP > 5.2

 *  @version 1.0

 *  @author Bineet Kumar Chaubey

 *  @package Codeigniter

 *  @subpackage salescripter 

 *  @link

 *  @see

 */

class Applicant_model extends CI_Model 

{

	/**

	 * Properties

	 */

	private $_table_users;

	private $_table_campaign;

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

	private $_table_intw_applicants;	

	private $_table_intw_address;

	private $_table_intw_app_notes;

	private $_table_intw_app_tasks;

	private $_table_intw_jobpost_section;

	private $_table_intw_jobpost;



	/**

	 * Constructor

	 */

    function __construct()

    {

        parent::__construct();

        //Define Table names

        $this->_table_users		 				= $this->config->item('table_users');

		$this->_table_campaign 					= $this->config->item('table_campaigns');

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

		$this->_table_intw_applicants			= $this->config->item('table_intw_applicants');

		$this->_table_intw_address				= $this->config->item('table_intw_address');

		$this->_table_intw_app_notes			= $this->config->item('table_intw_app_notes');

		$this->_table_intw_app_tasks			= $this->config->item('table_intw_app_tasks');

		$this->_table_intw_jobpost_section		= $this->config->item('table_intw_jobpost_section');

		$this->_table_intw_jobpost				= $this->config->item('table_intw_jobpost');

    }

	//your profile

	function save_yourprofile($data)

	{

		$user_id = $_SESSION['ss_user_id'];

		$atype=2;

		$this->db->select('*');	

		$this->db->from($this->_table_intw_applicants);

		$this->db->where('userid', $user_id);

		$this->db->where('atype', $atype);

		$query = $this->db->get();

		

		if($query->num_rows() == 0) {

			 $edata = array('user_first'=>$data['yfname'],'user_last'=>$data['ylname'],'user_title'=>$data['ytitle'].'','phone'=>$data['yphone'].'','userid'=>$user_id,'share_user_id'=>$user_id,'atype'=>$atype,'email'=>$data['yemail'],'modify_date'=>date("Y-m-d H:i:s"));

			 

			$this->db->insert($this->_table_intw_applicants, $edata);

			//echo $this->db->last_query(); exit;

			 return 1;

		}

		return 0;

	  

	}

	

	//get yorprofile id

	 function get_profileid(){

	 	$user_id = $_SESSION['ss_user_id'];

		$atype=2;

	 	$this->db->select('*');

		$this->db->from($this->_table_intw_applicants);

		$this->db->where('userid', $user_id);

		$this->db->where('atype', $atype);

		$query = $this->db->get();

		if($query->num_rows() == 0) return array();

		$row = $query->row_array();

		$row['amail']=$this->get_address($row['contact_id'],'amail','C');

		return $row;

	 }

	 

	 // save apply job

	 function save_applyjob($edata)

	{

		$this->db->insert($this->_table_intw_applicants, $edata);

		//echo $this->db->last_query();

		return $this->db->insert_id();

		/*$user_id = $_SESSION['ss_user_id'];

		$this->db->select('*');	

		$this->db->from($this->_table_intw_applicants);

		$this->db->where('userid', $user_id);

		$this->db->where('jobpost_id', $job_id);

		$query = $this->db->get();

		

		if($query->num_rows() == 0) {

	   		$edata = array('user_first'=>$data['first_name'],'user_last'=>$data['last_name'],'user_title'=>$data['title'].'','phone'=>$data['phone'].'','userid'=>$user_id,'jobpost_id'=>$job_id,'share_user_id'=>$user_id);

			$this->db->insert($this->_table_intw_applicants, $edata);

			//$contact_id = $this->db->insert_id();

			//echo $this->db->last_query(); exit;

			 return 1;

		}

	  return 0;*/

	}

	//check user applied job

	 function user_applied_job($email,$dtwhere='')

	{

		$this->db->select('*');	

		$this->db->from($this->_table_intw_applicants);

		$this->db->where('email', $email);

		//$this->db->where('jobpost_id', $job_id);

		if($dtwhere) $this->db->where($dtwhere,NULL,FALSE);

		$query = $this->db->get();

		return $query->row_array();

	}

	 //jods get user data

	 public function get_user() 

    {		

		$user_id = $_SESSION['ss_user_id'];

		$this->db->select('*');	

		$this->db->from($this->_table_users);

		$this->db->where('user_id', $user_id);

		//$this->db->order_by("post_id","asc");

		$query = $this->db->get();

		return $query->row_array();

    }

	//jods list

	 public function get_all_jobs() 

    {		

		$user_id =  $_SESSION['ss_user_id'];

		$this->db->select('*');	

		//$this->db->where('user_id', $user_id);

		//$this->db->where("user_id <> '$user_id'",NULL,FALSE);

		$this->db->from($this->_table_intw_jobpost);

		$this->db->order_by("modify_date","desc");

		//$this->db->order_by("post_id","asc");

		$query = $this->db->get();

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	}

    }

	

	//Delete jobpost section

	function delete_jobSection($rec_id)

	{

	   $this->db->where('parent_id',$rec_id);

	   $this->db->delete($this->_table_intw_jobpost_section);

	}

	//Delete template section

	public function deljob_section_single($job_id, $id_sec)

	{

		$this->db->where('parent_id', $job_id);

		$this->db->where('sect_id', $id_sec);

		return $this->db->delete($this->_table_intw_jobpost_section);

	}

	//Delete jobpost

	function delete_jobpost($post_id)

	{

	   $this->db->where('post_id',$post_id);

	   //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");

	   $doneRows = $this->db->delete($this->_table_intw_jobpost);

	   if($doneRows) {

		   $this->delete_jobSection($post_id);

	   }

	}

	//Get job record

	public function get_job($post_id)

	{

		$this->db->select('*');

		$this->db->from($this->_table_intw_jobpost);

		$this->db->where('post_id',$post_id);

		//$get_value = $this->db->get();

		//return $get_value->result();

		$query = $this->db->get();

		return $query->row_array();

	}

	//Get job section

	 public function get_jobsection($post_id) 

    {		

		$user_id =  $_SESSION['ss_user_id'];		

		$this->db->select('*');

		$this->db->where('parent_id', $post_id);

		$this->db->from($this->_table_intw_jobpost_section);

		$this->db->order_by("sorder","asc");

		$query = $this->db->get();

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	}

    }

   

	//jobpost list

	 public function get_all_jobpost() 

    {		

		$user_id =  $_SESSION['ss_user_id'];	

		$this->db->select("j.post_id,j.job_title,j.location,j.playrate,j.user_id,j.modify_date,j.status,j.create_date,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");	

		//$this->db->select("post_id,job_title,location,create_date,modify_date");

		$this->db->where('j.user_id', $user_id);

		$this->db->from($this->_table_intw_jobpost." j");

		$this->db->join($this->_table_users." u", 'u.user_id = j.user_id','left');

		//$this->db->order_by("post_id","asc");

		$query = $this->db->get();

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	}

    }

	

		//Update jobpost content

	public function updateJobPostContent($data,$pid,$sid)

	{

		//echo "<pre>";print_r($data);echo "</pre>";exit;

		//$user_id =  $_SESSION['ss_user_id'];

		//Update jobpost

		$user_id =  $_SESSION['ss_user_id'];

		if(trim($data['job_title'])) {

			if($pid) {

				$edata = array('job_title'=>$data['job_title'],'location'=>$data['location'],'playrate'=>$data['playrate'],'modify_date' => date("Y-m-d H:i:s"),'user_id'=>$user_id);

				$this->db->where('post_id',$pid);

				//$this->db->where('temp_user',(int)$user_id);

				$this->db->update($this->_table_intw_jobpost, $edata);

				

			} 

			else {

				$edata = array('job_title'=>$data['job_title'],'location'=>$data['location'],'playrate'=>$data['playrate'],'create_date' => date("Y-m-d H:i:s"),'modify_date' => date("Y-m-d H:i:s"),'user_id'=>$user_id);

				//$this->db->where('post_id',(int)$data['post_id']);

				//echo "<pre>";print_r($edata);echo "</pre>";

				//$this->db->where('temp_user',(int)$user_id);

				$this->db->insert($this->_table_intw_jobpost, $edata);

				$post_id = $this->db->insert_id();

				//echo $this->db->last_query(); exit;

				

			} 

			

		}

		//$post_id = $data['post_id'];

		unset($data['job_title']);

		unset($data['location']);	

		unset($data['post_id']);

		$section = $data['section'];

		foreach($section as $key => $value)

		{

			if((int)$value['sect_id'])

			{	

				$edata = array('title'=>$value['title'],'content'=>$value['content'],'parent_id'=>$pid, 'sorder'=>$value['sorder'],'modify_date' => date("Y-m-d H:i:s"));

				$this->db->where('sect_id',$value['sect_id']);

				//$this->db->where('post_id',(int)$pid);

				//echo "<pre>";print_r($edata);echo "</pre>";

				$this->db->update($this->_table_intw_jobpost_section, $edata);

			} else {

				

				$ndata = array('title'=>$value['title'],'content'=>$value['content'],'parent_id'=>$post_id, 'sorder'=>$value['sorder'],'modify_date' => date("Y-m-d H:i:s"),'create_date' => date("Y-m-d H:i:s"));

				//echo "<pre>";print_r($ndata);echo "</pre>";

				$this->db->insert($this->_table_intw_jobpost_section, $ndata);

				

			}

		}

		

	}

	

	

	//Get Notes list as array

    public function get_all_notes($parent_id, $parent_type,$ntype,$limit=0) 

    {	

		$parentNote = $this->get_notes_parent($parent_id,$parent_type);

		if(!$parentNote) return array();

		//$user_id =  $_SESSION['ss_user_id'];		

		$this->db->select("n.sfid,n.notes_info,n.notes_company,n.upload,n.notes_location,n.notes_school,n.notes_degree,n.notes_field,n.notes_grade,n.notes_activity,n.notes_fmonth,n.notes_tmonth,n.notes_fyear,n.notes_tyear,

n.type,n.notes_private,n.notes_title,n.notes_modify,n.notes_id,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");

		//$this->db->where('notes_user', $user_id);

		$this->db->where('n.notes_parent', $parent_type);

		$this->db->where('n.notes_parentid', $parent_id);

		$this->db->where('n.type', $ntype);

		$this->db->from($this->_table_intw_app_notes." n");

		$this->db->join($this->_table_users." u", 'u.user_id = n.notes_user','left');

		$this->db->order_by("n.notes_modify","desc");

		if($limit) $this->db->limit($limit);

		$query = $this->db->get();

    	//$query = $this->db->get($this->_table_crm_notes);

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	} 

		return array();

    }

	//Get Notes record

    public function get_notes($notes_id) 

    {		

		//$user_id = $_SESSION['ss_user_id'];

		$this->db->where('notes_id', $notes_id);

    	//$this->db->where('notes_user', $user_id);

    	$query = $this->db->get($this->_table_intw_app_notes);

    	if ($query->num_rows() > 0)

    	{

			$notesRow = $query->row_array();

			$parentNote = $this->get_notes_parent($notesRow['notes_parentid'],$notesRow['notes_parent']);			

			if(!$parentNote) return array();

			return $notesRow;

    	}

		return array();

    }

	//Save Notes

	public function save_notes($data,$notes_id=0,$ntype)

	{

	   $user_id = $_SESSION['ss_user_id'];

	   if($notes_id) {

	   		$data['type']=$ntype;

			$data['notes_modify']=date("Y-m-d H:i:s");

	   		$this->db->where('notes_id', $notes_id);

    		//$this->db->where('notes_user', $user_id);

	   		$this->db->update($this->_table_intw_app_notes,$data);

		} else {

			if(!isset($data['notes_user'])) $data['notes_user']=$user_id;

			$data['type']=$ntype;

			$data['notes_created']=date("Y-m-d H:i:s");

			$data['notes_modify']=date("Y-m-d H:i:s");

	   	    $this->db->insert($this->_table_intw_app_notes,$data);

			//echo $this->db->last_query();echo $query->num_rows();exit;

	   		$notes_id = $this->db->insert_id(); 

			

		}

	   return $notes_id;

	}

	//Delete Notes

	public function delete_notes($notes_id)

	{

	   //$user_id = $_SESSION['ss_user_id'];

	   $this->db->where('notes_id', $notes_id);

   	   //$this->db->where('notes_user', $user_id);

	   $this->db->delete($this->_table_intw_app_notes);

	   $this->delete_prospect_points($notes_id,'CA','N');

	}

	//Search Notes

	public function search_notes($where) 

    {

		$this->db->where($where[0], $where[1]);//$where = array('column','value')

		$this->db->where_in('notes_user', $where[2]);

    	$query = $this->db->get($this->_table_intw_app_notes);

    	if ($query->num_rows() > 0) return $query->row_array();

		return array();

    }

	//Delete all notes from Specific Object

	public function delete_objectnotes($parent_id, $parent_type)

	{

	   //$user_id = $_SESSION['ss_user_id'];

   	   //$this->db->where('notes_user', $user_id);

	   $this->db->where('notes_parent', $parent_type);

	   $this->db->where('notes_parentid', $parent_id);

	   $this->db->delete($this->_table_intw_app_notes);

	}

	

	//Get Notes parent record

    public function get_notes_parent($parent_id,$parent_type='C') 

    {

		$user_id = $_SESSION['ss_user_id'];

		//$this->db->where('userid', $user_id);		

		//$this->db->where_in('userid', $this->_parent_users);

		//$this->db->where("(userid=$user_id OR share_user_id=$user_id)");

		

			$this->db->where('contact_id', $parent_id);

			$query = $this->db->get($this->_table_intw_applicants);

		//echo $this->db->last_query();echo $query->num_rows();exit;

    	if ($query->num_rows() > 0)

    	{

			return $query->row_array();

    	}

		return array();

    }

	//End of NOTES

	

	//TASKS

	//Get Task list as array

    public function get_all_tasks($parent_id=0, $parent_type='',$limit=0,$status='',$dtwhere='') 

    {	

		if($parent_id) {

			$parentNote = $this->get_notes_parent($parent_id,$parent_type);

			if(!$parentNote) return array();

		}	

		$user_id =  $_SESSION['ss_user_id'];

		$this->db->select("t.sfid,t.task_subject,t.task_modified,t.task_id,t.task_duedate,t.task_status,t.task_priority,t.task_related,t.task_relatedto,t.task_info,CONCAT((u.first_name),(' '),(u.last_name)) as usrname,t.task_name,(SELECT SUM(intpoints) FROM ".$this->_table_prospect_points." p WHERE p.rctype=t.task_related and p.contact=t.task_relatedto) as qpoints");

		//$this->db->where('userid', $user_id);		

		if($parent_type)$this->db->where('t.task_related', $parent_type);

		if($parent_id)$this->db->where('t.task_relatedto', $parent_id);

		if($status==1) $this->db->where('t.task_status', 'Completed');

		else if($status==2) $this->db->where('t.task_status !=', 'Completed');

		if($dtwhere) $this->db->where($dtwhere,NULL,FALSE);

		else if(!$parent_id) $this->db->where('t.share_user_id', $user_id);

		//if($limit && $status==2) $this->db->where('t.task_duedate >', '0000-00-00');

		$this->db->from($this->_table_intw_app_tasks." t");

		$this->db->join($this->_table_users." u", 'u.user_id = t.share_user_id','left');		

		if($limit && $status==2) $this->db->order_by("t.task_duedate","asc");

		if(!$limit) $this->db->order_by("t.task_duedate","asc");

		if($limit && $status==1) $this->db->order_by("t.task_id","desc"); 

		else $this->db->order_by("t.task_modified","desc");

		if($limit) $this->db->limit($limit);

		$query = $this->db->get();

    	//$query = $this->db->get($this->_table_crm_tasks);

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	} 

		return array();

    }

	//Search Task

	public function search_task($where) 

    {

		$this->db->where($where[0], $where[1]);//$where = array('column','value')

		$this->db->where_in('userid', $where[2]);

    	$query = $this->db->get($this->_table_intw_app_tasks);

    	if ($query->num_rows() > 0) return $query->row_array();

		return array();

    }

	//Get Next Task

    public function get_next_task($parent_id, $parent_type) 

    {	

		//$user_id =  $_SESSION['ss_user_id'];

		$today = date("Y-m-d");

		$this->db->select("task_subject,task_id");

		//$this->db->where('userid', $user_id);

		$this->db->where('task_related', $parent_type);

		$this->db->where('task_relatedto', $parent_id);

		//$this->db->where("task_duedate >=",$today);

		$this->db->where("task_duedate >= '$today'",NULL,FALSE);

		$this->db->where('task_status !=', 'Completed');

		$this->db->order_by("task_duedate","asc");

    	$query = $this->db->get($this->_table_intw_app_tasks);

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

			$taskRow = $query->row_array();

			$parentRow = $this->get_notes_parent($taskRow['task_relatedto'],$taskRow['task_related']);

			if(!$parentRow) return array();

			return $taskRow;

    	}

		return array();

    }

	//Get Task record

    public function get_task($task_id) 

    {

		$user_id = $_SESSION['ss_user_id'];

		$this->db->where('task_id', $task_id);

    	//$this->db->where('userid', $user_id);

    	$query = $this->db->get($this->_table_intw_app_tasks);

    	if ($query->num_rows() > 0)

    	{

			$taskRow = $query->row_array();

			$parentRow = $this->get_notes_parent($taskRow['task_relatedto'],$taskRow['task_related']);

			//print_r($parentRow);exit;

			if(!$parentRow) return array();

			return $taskRow;

			//return $query->row_array();

    	}

		return array();

    }

	//Save Task

	public function save_task($data,$task_id=0)

	{

	   $user_id = $_SESSION['ss_user_id'];

	   if($task_id) {

			$data['task_modified']=date("Y-m-d H:i:s");

	   		$this->db->where('task_id', $task_id);

    		//$this->db->where('userid', $user_id);

	   		$this->db->update($this->_table_intw_app_tasks,$data);

		} else {

			if(!isset($data['userid']))$data['userid']=$user_id;

			//if dates not set

			if(!isset($data['task_created'])) {

				$data['task_created']=date("Y-m-d H:i:s");

				$data['task_modified']=date("Y-m-d H:i:s");

			}

	   		$this->db->insert($this->_table_intw_app_tasks,$data);

	   		$task_id = $this->db->insert_id();

		}

	   return $task_id;

	}

	//Delete Task

	public function delete_task($task_id)

	{

	   //$user_id = $_SESSION['ss_user_id'];

	   $this->db->where('task_id', $task_id);

   	   //$this->db->where('userid', $user_id);

	   $this->db->delete($this->_table_intw_app_tasks);

	   $this->delete_prospect_points($task_id,'CA');

	   

	}

	//Delete all Task from Specific Object

	public function delete_objecttasks($parent_id, $parent_type)

	{

	   //$user_id = $_SESSION['ss_user_id'];

   	   //$this->db->where('userid', $user_id);

	   $this->db->where('task_related', $parent_type);

	   $this->db->where('task_relatedto', $parent_id);

	   $this->db->delete($this->_table_intw_app_tasks);

	}

	//End of Tasks

	

	

	//ADDRESS

	//Save address

	function save_address($data)

	{

	   $this->db->insert($this->_table_intw_address,$data);

	}

	//Get address

	function get_address($parent_id,$type,$ptype)

	{

	   $this->db->where('parent_id',$parent_id);

	   $this->db->where('adr_type',$type);

	   $this->db->where('parent_type',$ptype);

	   $query = $this->db->get($this->_table_intw_address);

	   return $query->row_array();

	}

	//Delete Contact address

	function delete_address($rec_id,$ptype,$adrtype='')

	{

	   $this->db->where('parent_id',$rec_id);

	   $this->db->where('parent_type',$ptype);

	   if($adrtype) $this->db->where('adr_type',$adrtype);

	   $this->db->delete($this->_table_intw_address);

	}

	//Get address search for Contact/Account

	function address_search($data,$atype,$ptype,$users,$apptype=0)

	{

		$this->db->select("c.contact_id,c.user_title,c.userid,c.user_first,c.user_last,c.phone,c.email,c.mobile,c.job_applied_for,c.stage,c.unsubscribed,c.sstrained,c.sstrained2,c.create_date,c.modify_date,c.pay_rate,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");

		$this->db->from($this->_table_intw_address." ad");		

		$this->db->join($this->_table_intw_applicants." c", 'c.contact_id = ad.parent_id','left');

		$this->db->join($this->_table_users." u", 'u.user_id = '.strtolower($ptype).'.share_user_id','left');

		$this->db->where('ad.adr_type',$atype);

		$this->db->where('ad.parent_type',$ptype);
		$this->db->where('c.target', '1');
		$this->db->where('c.atype', $apptype);

		$this->db->where_in(strtolower($ptype).'.share_user_id', $users);

		$nc = count($data);

		if($nc>1) {

			$ob="(";

			$cb=")";

		}

		$n=0;

		foreach($data as $ki=>$kval) {

			$n++;

			$sb="";

			if($n==1){

				if($ki=="zipcode") 

					$this->db->where($ob."ad.$ki='$kval'",NULL,FALSE);

				else $this->db->where($ob."ad.$ki LIKE '%$kval%'",NULL,FALSE);

			} else {

				if($n==$nc && $cb) $eb=$cb;

				if($ki=="zipcode") 

					$this->db->or_where("ad.$ki='$kval'".$eb,NULL,FALSE);

				else $this->db->or_where("ad.$ki LIKE '%$kval%'".$eb,NULL,FALSE);

			}			

		}

		$this->db->order_by("c.user_first","asc");

	   	$query = $this->db->get();

	   	//echo $this->db->last_query()."<br>";

	   	return $query->result();

	}

	//End of Address

	

	//CONTACT

	//Get search list for Contact

	function contact_search($data,$users)

	{

		$this->db->select("c.contact_id,c.user_first,c.user_last,c.phone,c.account_id,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");

		$this->db->from($this->_table_intw_applicants." c");

		$this->db->join($this->_table_users." u", 'u.user_id = c.share_user_id','left');

		$this->db->where_in('c.share_user_id', $users);

		$nc = count($data);

		if($nc>1) {

			$ob="(";

			$cb=")";

		}

		$n=0;

		foreach($data as $ki=>$kval) {

			$n++;

			$sb="";

			if($n==1){

				if($ki=="birthdate" || $ki=="email") 

					$this->db->where($ob."c.$ki='$kval'",NULL,FALSE);

				else $this->db->where($ob."c.$ki LIKE '%$kval%'",NULL,FALSE);

			} else {

				if($n==$nc && $cb) $eb=$cb;

				if($ki=="birthdate" || $ki=="email") 

					$this->db->or_where("c.$ki='$kval'".$eb,NULL,FALSE);

				else $this->db->or_where("c.$ki LIKE '%$kval%'".$eb,NULL,FALSE);

			}

		}

		$this->db->order_by("c.user_first","desc");

	   	$query = $this->db->get();

	   	//echo $this->db->last_query()."<br>";

	   	return $query->result();

	}

    //Get Contacts list as array

    public function get_all_contacts($owner=0,$target=0,$parent_ids=array(0),$limit=0,$dtwhere='',$pool=0) 

    {			

		$this->db->select("c.contact_id,c.user_title,c.user_first,c.user_last,c.phone,c.email,c.mobile,c.job_applied_for,c.stage,c.unsubscribed,c.sstrained,c.sstrained2,c.create_date,c.modify_date,c.pay_rate,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");

		if($pool) {$this->db->where('c.target', '1');}

		else if($target) {

			$user_id =  $_SESSION['ss_user_id'];

			$this->db->where("c.share_user_id",$user_id);

			$this->db->where('c.target', '1');

		} else if($owner) {

			$this->db->where('c.share_user_id', $owner);

		} else {

			//$user_id =  $_SESSION['ss_user_id'];

			//$this->db->where('c.userid', $user_id);

			$this->db->where_in('c.userid', $parent_ids);

		}

		$this->db->from($this->_table_intw_applicants." c");

		$this->db->join($this->_table_users." u", 'u.user_id = c.share_user_id','left');

		if($dtwhere) $this->db->where($dtwhere,NULL,FALSE);

		if($limit) $this->db->limit($limit);

		$this->db->order_by("c.modify_date","desc");

		$query = $this->db->get();

		//echo $this->db->last_query();

    	if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	}

    }

	//Search Contact

	public function search_contact($where) 

    {

		$this->db->where($where[0], $where[1]);//$where = array('column','value')

		$this->db->where_in('userid', $where[2]);

    	$query = $this->db->get($this->_table_intw_applicants);

    	if ($query->num_rows() > 0) return $query->row_array();

		return array();

    }

	//Get Contact record

    public function get_contact($contact_id,$parent_ids=array(0),$pool=0) 

    {

		$user_id = $_SESSION['ss_user_id'];

		$this->db->select("c.*");

		$this->db->where('c.contact_id', $contact_id);

		$this->db->from($this->_table_intw_applicants." c");

		$query = $this->db->get();

		

		//echo $this->db->last_query();exit;

    	if ($query->num_rows() > 0)

    	{

			$row = $query->row_array();

			/*

				Contact access conditions

				1. C Created ID, Shared ID

				2. else C Account ID > Created ID, Shared ID

			*/

			$access=0;

			//echo "$access <pre>";print_r($row);exit;

			if($user_id==$row['userid'] || $user_id==$row['share_user_id'] || in_array($row['userid'],$parent_ids)!==false) $access=1;

			if($pool) $access=1;

			if($access==1) {

				$row['amail']=$this->get_address($contact_id,'amail','C');

				//$row['other']=$this->get_address($contact_id,'other','C');

				return $row;

			}

    	}

		return array();

    }

	//Save Contact

	function save_contact($data,$contact_id=0)

	{

	   $user_id = $_SESSION['ss_user_id'];

	   if($contact_id) {

	   		//$this->db->where('userid', $user_id);

	    	$this->db->where('contact_id', $contact_id);

			//$this->db->where("(userid=$user_id OR share_user_id=$user_id)");

	   		$this->db->update($this->_table_intw_applicants,$data);

		} else {

			$data['userid']=$user_id;

	   		$this->db->insert($this->_table_intw_applicants,$data);

	   		$contact_id = $this->db->insert_id();

		}	

	   return $contact_id;

	}	

	//Delete contact

	function delete_contact($contact_id)

	{

	   //$user_id = $_SESSION['ss_user_id'];

	   //$this->db->where('userid',$user_id);

	   $this->db->where('contact_id',$contact_id);

	   //$this->db->where("(userid=$user_id OR share_user_id=$user_id)");

	   $doneRows = $this->db->delete($this->_table_intw_applicants);

	   if($doneRows) {

		   $this->delete_address($contact_id,'C');

		   $this->delete_objectnotes($contact_id,'C');

		   $this->delete_objecttasks($contact_id,'C');

	   }

	}	

	//End of CONTACTS

	public function get_CurrentUser($user_id=0) 

    {	

		$users_list = array();

		if(!$user_id) $user_id =  $_SESSION['ss_user_id'];

		$this->db->select("user_id,CONCAT((first_name),(' '),(last_name)) as usrname");

    	$this->db->where('user_id', $user_id);

    	$query = $this->db->get($this->_table_users);

    	if ($query->num_rows() > 0)

    	{

			$users_list[] = $query->row();

    	}

		return $users_list;

    }

	

/*end of campaigm model class */



//Activate Interview Job posts

    function inactiveAlljobposts()

	{

		$user_id = $_SESSION['ss_user_id'];

		$updatedata = array('status' => '0');

		$this->db->where('user_id',$user_id);

		$this->db->update($this->_table_intw_jobpost,$updatedata);

	}





	function activejobpost($newactive_id)

	{

		$user_id = $_SESSION['ss_user_id'];

		$updatedata = array('status' => '1');

		$this->db->where('user_id',$user_id);

		$this->db->where('post_id',$newactive_id);

		$this->db->update($this->_table_intw_jobpost,$updatedata);

	}

		

	public function get_activejobpost() 

    {

    	$user_id = $_SESSION['ss_user_id'];

		$this->db->where('user_id',$user_id);

		$this->db->where('status', '1');

    	$query = $this->db->get($this->_table_intw_jobpost);

    	if ($query->num_rows() > 0) return $query->row_array();

		return array();

    }

	

	 function job_applied_for($parent_ids=array(0))

	{

		$user_id =  $_SESSION['ss_user_id'];

		$this->db->distinct();

		$this->db->select('job_applied_for');	

		$this->db->from($this->_table_intw_applicants);

		$this->db->where('job_applied_for!=" "',NULL,FALSE);

		$this->db->where('(share_user_id IN ('.implode(',', $parent_ids).') OR userid IN ('.implode(',', $parent_ids).'))',NULL,FALSE);

		//$this->db->where_in('share_user_id', $parent_ids);

		//$this->db->where_in("userid",$parent_ids);

		//$this->db->where('target', '1');

		$this->db->where('atype', '0');

		//$query = $this->db->get($this->_table_intw_applicants);

		$query = $this->db->get();

		//echo $this->db->last_query()."<br>";

		//exit;

		if ($query->num_rows() > 0)

    	{

    		return $query->result();

    	}

   }



   //Delete Prospect Points

	public function delete_prospect_points($recid,$rctype='CA',$notes='')

	{	   

		if($notes) {

			$this->db->where('noteid',$recid);

		} else if($rctype=="T") {

			$this->db->where('taskid',$recid);	

		}

		$this->db->where('rctype',$rctype);

	   $this->db->delete($this->_table_prospect_points);

	}

	//Get search list for Applicants

	function applicant_search($data,$users,$atype=0)

	{

		$this->db->select("c.contact_id,c.user_title,c.userid,c.user_first,c.user_last,c.phone,c.email,c.mobile,c.job_applied_for,c.stage,c.unsubscribed,c.sstrained,c.sstrained2,c.create_date,c.modify_date,c.pay_rate,CONCAT((u.first_name),(' '),(u.last_name)) as usrname");

		$this->db->from($this->_table_intw_applicants." c");

		$this->db->join($this->_table_users." u", 'u.user_id = c.share_user_id','left');

		$this->db->where_in('c.share_user_id', $users);
		$this->db->where('c.atype', $atype);

		$nc = count($data);

		if($nc>1) {

			$ob="(";

			$cb=")";

		}

		$n=0;

		foreach($data as $ki=>$kval) {

			$n++;

			$sb="";

			if($n==1){

				if($ki=="birthdate" || $ki=="email") 

					$this->db->where($ob."c.$ki='$kval'",NULL,FALSE);

				else $this->db->where($ob."c.$ki LIKE '%$kval%'",NULL,FALSE);

			} else {

				if($n==$nc && $cb) $eb=$cb;

				if($ki=="birthdate" || $ki=="email") 

					$this->db->or_where("c.$ki='$kval'".$eb,NULL,FALSE);

				else $this->db->or_where("c.$ki LIKE '%$kval%'".$eb,NULL,FALSE);

			}

		}

		$this->db->order_by("c.user_first","desc");

	   	$query = $this->db->get();

	   	//echo $this->db->last_query()."<br>";

	   	return $query->result();

	}

}

/*end of campaigm model class */