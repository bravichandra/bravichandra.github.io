<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/facebook/facebook.php';
session_start();
class Jobprofile extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	 public $_data = array();
	 public $_user_id;
	public $_parent_users=array();
	 
	 
    function __construct()
    {  
        parent::__construct();
		$this->output->nocache();
		//Load Helpers 
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->library('session');

		$this->load->model('category_model');		
		$this->load->model('user_model');
		$this->load->model('attribute_model','attribute');
		$this->load->model('jobprofile_model');
		$this->load->model('contact_model');
		$this->load->helper('common_helper');
		$this->config->load('facebook'); 
		am_auth();
		$this->_data['ivs'] = "jobs";
		$breadcrumbs = array();
		$breadcrumbs[] = array('label'=>'Applicant Attributes','url'=>base_url('user/jobprofile'));
		$this->_data['breadcrumbs']=$breadcrumbs;
		
    }
	/**
	 *  User home dashboard
	 *  
	 *  @return Return_Description
	 */
	public function index()
	{
		$outdata['title'] = 'jobprofile';
		$this->session->set_userdata('fromwhere','list');
		$outdata = array_merge($outdata,$this->_data);
		$this->load->view('interview/job_home',$outdata);
	}
	/**
	 *  Create a new job profile
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	public function create_job()
	{			
		
		if(isset($_POST['job_title']))			
		{		
			  $user= $this->session->userdata('userid');
			  $job= array(
							'job_name' => $this->input->post('job_title'),
							'user_id' => $user							
						);
			 $val = $this->input->post('attribute');
			 $job_id = $this->jobprofile_model->savejobprofile($job,$val);	
			 $this->session->set_userdata('fromwhere','create');
			 $this->session->set_flashdata('msg','Form Submitted Successfully....!!!! ');
             redirect(base_url().'jobprofile/job_profile_details/'.$job_id);			  
		}
		$this->_data['ivs'] = "job";
		$data['result'] = $this->category_model->profileattributes();
		$data = array_merge($data,$this->_data);		
		$this->load->view('interview/create_job',$data);
		
	}
	/**
	 *   job profile detail page
	 */
	public function job_profile_details($job_id,$download=NULL)
	{		
	
		$this->load->library('flexsin');
		$this->load->helper('file');
		$this->_data['fromwhere'] = $this->session->userdata('fromwhere');
		$this->_data['categories'] = $this->category_model->profileattributes();		
		$this->_data['jobnam'] = $this->jobprofile_model->jobname($job_id);		
		$this->_data['jobskill'] = $this->jobprofile_model->job_details($job_id);
		$this->_data['url_job_id'] = $job_id;
		
		if($download == 'download'){
			
			$html = $this->load->view('downloadProfile.php', $this->_data, TRUE);
			$name = url_title($this->_data['jobnam'][0]->job_name);
			
			// Creating a File
			$fp = fopen(APPPATH."files/".$name.".doc", "a+");
			ftruncate($fp, 0);			
			fwrite($fp,$html);
			
			//path to the file
			$file_path=APPPATH.'files/'.$name.".doc"; 
			
			
			
			//Call the download function with file path,file name and file type
			$this->flexsin->output_file($file_path, ''.$name.'.doc', 'application/msword');
			@delete_files($file_path);
			exit;
			//echo $this->load->view('downloadProfile.php', $this->_data, TRUE);
//			exit;
		}
		$this->load->view('interview/job_profile_details',$this->_data);
	}	
	/**
	 *   dynamic add attribute in database
	 */
	public function addAttrDynamic()
	{
		$attr_name = $this->input->post('attrname');
		$attr_id = $this->input->post('attr_id');
		//$cuser_id = $this->session->userdata('userid');
		$cuser_id = $this->_user_id;
		$new_attr_id = $this->jobprofile_model->dynamicAddAttr($cuser_id,$attr_id,$attr_name);
		echo "<div class='ui-state-highlight' id='attr-".$new_attr_id."' >$attr_name<input type='hidden' name='attribute[]' class='idattrbs' value='$new_attr_id' /> 
		<div style='float:right; width:8px;cursor:pointer;font-size:10px;'><a onclick='deleteAttr(".$new_attr_id.")'><span style='cursor:pointer; color:#C6C6C6; font-weight:bold;  font-size:10px;'>X</span></a></div> </div>";
		die();
	}
	
	
	/**
	 *  edit job 
	 *  
	 *  @params interger $job_id
	 */
	public function edit($job_id)
	{
		//$job_id = base64_decode($job_id);
		$cuser_id  = $this->session->userdata('userid');
		$this->session->set_userdata('fromwhere','create');
		try{
			$isJonExist = $this->jobprofile_model->isJobExist($job_id);
			if(!$isJonExist)
			{
				throw new Exception('job Id not found');
			}
			
			if($this->input->post('attribute')){			
				$jobtitle = $this->input->post('job_title');
				$jobattribute = $this->input->post('attribute');
				$this->jobprofile_model->updatejob($job_id,$jobtitle,$jobattribute,$cuser_id);
				$this->session->set_flashdata('message','Update Job profile successfully');
				//print_r($this->input->post()); echo $job_id; exit;
				if($this->input->post('done'))
				redirect(base_url()."jobprofile/job_profile_details/".$job_id);
				else if($this->input->post('create_questions'))
				redirect(base_url()."questions/createquestion?jobID=".$job_id);
				else if($this->input->post('download'))
				redirect(base_url()."jobprofile/job_profile_details/".$job_id."/download");
				else
				redirect(base_url()."jobprofile/edit/".$job_id);
			}
		}catch(Exception $e){
			echo $e->getMessage();
			// show_404(null,array('job is not found'));
			die();
		}
		$this->_data['ivs'] = "job";
		$this->_data['jobdetail'] = $isJonExist ;
		$this->_data['jobAttibute'] = $this->jobprofile_model->job_details($job_id);
		$this->_data['result'] = $this->category_model->profileattributes();
		$this->load->view('interview/edit_job',$this->_data);
	}
	// function to delete job profiles
	function delete_jobProfile( $id = null)
	{
		$checkuser=checkuserlogin();
		if($checkuser=='false' || $checkuser=="")
        {
            $this->session->set_flashdata('message', 'Please login to access this page.');
            redirect('login');
        }
		if($this->jobprofile_model->delete($id))
		{
			$this->session->set_flashdata('message', 'Job profile has been deleted successfully');
			redirect(base_url().'user/home/');
		}
		else
		{
			$this->session->set_flashdata('message', 'Something went Wrong');
			redirect(base_url().'user/home/');
		}
	}
}

/* End of file jobprofile.php */
/* Location: ./application/controllers/jobprofile.php */