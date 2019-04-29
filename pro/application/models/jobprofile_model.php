<?php
class Jobprofile_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
    function __construct()
    {
        parent::__construct();
    }
    public function savejobprofile($job,$val)
	{		
		$this->db->insert('job_profile',$job);		
		 $jobid= $this->db->insert_id();		 
		foreach($val as $value)
		{
			$data1 = array(
				   'job_id' =>  $jobid ,
					'attr_id'=> $value
				);			
			$this->db->insert('job_profile_attr', $data1); 
				
		}
		return $jobid;
	}
	
	/**
	 *  get job prfile detail with attributes  
	 */
	public function job_details($job_id)
	{	
		$this->db->select('job_profile_attr.attr_id,attributes.attr_name,attributes.cat_id');
		$this->db->from('attributes');
		$this->db->where('job_profile_attr.job_id',$job_id);
		$this->db->join('job_profile_attr', 'job_profile_attr.attr_id = attributes.attr_id');
		$query = $this->db->get();
		return $query->result();
	}
	
	/**
	 *   get a single job info with job detail 
	 */
	public function jobname($job_id)
    {
	   $query = $this->db->query("select job_id,job_name,user_id,status from job_profile where job_id = $job_id"); 
	 
		if($query->num_rows > 0)
		{		
           return $query->result();
		}
		return array();
    }
	/**
	 *   add dynamic attribute in database by user 
	 */
	public function dynamicAddAttr($cuser_id,$cat_id,$attr_name)
	{
		$data = array('cat_id' => $cat_id, 'attr_name' => $attr_name , 'user_id' => $cuser_id);
		$this->db->insert('attributes',$data);
		return $this->db->insert_id();
	}
	
	
	
	public function getAlljob($User_id)
	{
		$this->db->where('user_id',$User_id);
		$query = $this->db->get('job_profile');
		return $query->result();
	}
	/**
	 *  check is product is exits or not
	 */
	public function isJobExist($job_id)
	{
		$this->db->where('job_id',$job_id);
		$getquery = $this->db->get('job_profile');
		if($getquery->num_rows > 0)
		{
			return $getquery->row();
		}
		return false;
	}
	
	/**
	 *  Update job 
	 *  @params integer $job_id,
	 *  @params integer $jobtitle
	 *  @params array $jobattribute
	 *  @params integer $cuser_id
	 */
	public function updatejob($job_id,$jobtitle,$jobattribute,$cuser_id)
	{
	
		/** first delele all job attibute then add new job attributes **/
		$this->db->where('job_id',$job_id);
		$this->db->delete('job_profile_attr');
		
		/**  now add new attribute id in database */
		foreach($jobattribute as $attreinfo)
		{
			$savedata = array('job_id'=> $job_id,'attr_id' => $attreinfo);
			$this->db->insert('job_profile_attr',$savedata);
		}
		
		/**  now update job time name */
		$jobupdatedata = array('job_name' => $jobtitle);
		$this->db->where('job_id',$job_id);
		$this->db->update('job_profile',$jobupdatedata);
		return true;
	}
	public function delete($id = null)
	{
		if($id != '')
		{
			$user_id = $this->session->userdata('userid');
			$this->db->query('DELETE t1,t2 FROM interview_question t1 JOIN interview_qus_question t2 ON t1.interv_ques_id = t2.interv_ques_id WHERE t1.user_id = "'.$user_id.'"');
			if($this->db->delete('job_profile', array('job_id' => $id)))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
}
