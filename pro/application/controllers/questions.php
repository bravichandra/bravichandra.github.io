<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//error_reporting(E_ALL);
require_once APPPATH.'libraries/facebook/facebook.php';
session_start();
class Questions extends MY_Controller {
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
	 * 
	 * @author Bineet Kumar Chaubey <> 
	 */ 
	var $_data = array();
    function __construct()
    {   
        parent::__construct();
		$this->output->nocache();
		//Load Helpers 
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->library('session');
		$this->loadConfig();
		am_auth();
		$this->_data['ivs'] = "quests";
		$breadcrumbs = array();
		$breadcrumbs[] = array('label'=>'Questions','url'=>base_url('interviewer/builder'));
		$this->_data['breadcrumbs']=$breadcrumbs;
    }
	/**
	 *  User home dashboard
	 *  
	 *  @return Return_Description
	 */
	public function index()
	{
		//$userid = $this->session->userdata('userid');
                $userid = $_SESSION['ss_user_id'];
		$this->session->unset_userdata('cur_list_que_id');
		$this->session->unset_userdata('isedit');
		$this->session->unset_userdata('post_data_dev');
		$this->_data['allIntvQuestion'] = $this->QuestionModel->getAllInterViewQuestion($userid);
		$this->load->view('interview/question_list',$this->_data);
	}
	/**
	 *  Create question action 
	 */
	public function createquestion()
	{
	    $userid = $this->session->userdata('userid');
		$isEdit = $this->session->userdata('isedit');
		
		if(!array_key_exists('QUestionSubmit',$_POST))
		{
			$this->session->unset_userdata('cur_list_que_id');	
			$this->session->unset_userdata('isedit');	
			$this->session->unset_userdata('post_data_dev');
			//exit;
		}
		if(array_key_exists('QUestionSubmit',$_POST) && !$isEdit)
		{
			//$this->session->set_userdata('preview_intr',$_POST);
			$this->session->set_userdata('closing_Ques',$_POST);
			$cur_list_que_id = $this->session->userdata('cur_list_que_id');
			$isIntroOk = $this->session->userdata('intro_ok');
			$isEdit = $this->session->userdata('isedit');
			if(!$isIntroOk) redirect(base_url().'questions/createquestion');
			if($cur_list_que_id)
			{
				$closing_questions = $_POST['Question_ID'];
				$closes = array();
				foreach($closing_questions as $close)
				{
					$closes[]= array('ques_id' => $close,'interv_ques_id' => $cur_list_que_id);
				}
				$this->QuestionModel->saveInterViewWithQuestionID($closes);
				$this->session->set_userdata('close_ok',true);
				redirect(base_url().'questions/previewinterviewProfile/'.$this->input->post('jobProfileID').'/'.$cur_list_que_id);
			}else redirect(base_url().'questions/createquestion');
			//redirect(base_url().'questions/previewinterviewProfile');
			
			/* 
			$AllQuestion_ID = $this->input->post('Question_ID');
			if($AllQuestion_ID == false)
			{
				$this->session->set_flashdata('error','Please drag question from right side to left side panel.');
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			// form submitted, where 'QUestionSubmit' is the name of submit button			
			$savedata['interview_ques_name'] = $this->input->post('QuestionName');
			$savedata['job_id'] = $this->input->post('jobProfileID');
			$savedata['user_id'] = $userid;
			$GetInterViewQuestionID = $this->QuestionModel->addquestions($savedata);
			// now update join table with question_id and interview-question-id  
			if($GetInterViewQuestionID)
			{
				
				// var_dump($AllQuestion_ID); die();
				$saveAuestionID = array();
				if(is_array($AllQuestion_ID)){
					foreach($AllQuestion_ID  as $singleQuesID)
					{
						$saveAuestionID[]= array(
												'ques_id' => $singleQuesID,
												'interv_ques_id' => $GetInterViewQuestionID
											);	
					}
					$this->QuestionModel->saveInterViewWithQuestionID($saveAuestionID);
				}
			}
			$this->session->set_flashdata('message','Interview Question saved successfully.');
			redirect(base_url().'questions'); */
		}
		if($isEdit)
		{
			
			$inteViewQuesID = $this->session->userdata('cur_list_que_id');
			$savedata['interview_ques_name'] = $this->input->post('QuestionName');
			$savedata['job_id'] = $this->input->post('jobProfileID');
			// $savedata['user_id'] = $userid;
			$this->QuestionModel->updateInterViewProfileQuestion($savedata,$inteViewQuesID,$userid);
			$this->QuestionModel->dltIntrvwQuesByIQIDClose($inteViewQuesID);
			/**
			 *  Then update all question with job profile id
			 */
			$AllQuestion_ID = $this->input->post('Question_ID');
			// var_dump($AllQuestion_ID); die();
			$saveAQuestionID = array();
			foreach($AllQuestion_ID  as $singleQuesID)
			{
				$saveAQuestionID[]= array(
										'ques_id' => $singleQuesID,
										'interv_ques_id' => $inteViewQuesID
									);	
			}
			$this->QuestionModel->saveInterViewWithQuestionID($saveAQuestionID);
			
			//$this->session->set_flashdata('message','Interview Question update successfully.');
			redirect(base_url().'questions/previewinterviewProfile/'.$this->input->post('jobProfileID').'/'.$inteViewQuesID);
		}
		$this->_data['ivs'] = "quest";
		$this->_data['alljobprfile']= $this->jobprofile_model->getAlljob($userid);
		$this->load->view('interview/createquestion',$this->_data);
	}

	/**
	 *   Rendor all attribute question of partiular job profile.
	 *  
	 */
	function getAjaxAttrQues($jobID=NULL)
	{
		$this->_data['all_attributes'] = $this->attribute->getAttibuteWithJObID($jobID);
		$this->load->view('interview/attrQuestion',$this->_data);
		
	}
	function getQuesByAttribute($attrID=NULL)
	{
		
		$this->_data['attribute_info']=$this->attribute->getAttributeWithID($attrID);
		$this->load->view('interview/getAjaxQestionList2',$this->_data);
		
	}
	

	/**
	 *   edit interview question  
	 */
	public function edit($InterViewQuesID=NUll)
	{
		if($InterViewQuesID == NULL){
			redirect(base_url()."questions");
		}
		$userid = $this->session->userdata('userid');
		$inteViewQuesID = $InterViewQuesID;
		$this->session->set_userdata('cur_list_que_id', $inteViewQuesID);
		$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getInterViewQuestionByIDAndUserID($inteViewQuesID,$userid);
        //print_r($this->_data['interviewQuestionInfo']);
		
		if(empty($this->_data['interviewQuestionInfo']))
		{
			redirect(base_url()."questions");
		}
	    if(array_key_exists('QUestionSubmit',$_POST))
		{
			//echo $errNo   = $this->db->_error_number();
			//echo $errMess1 = $this->db->_error_message(); exit;
			// form submitted, where 'QUestionSubmit' is the name of submit button	
			$this->session->set_userdata('isedit', true);		
			$savedata['interview_ques_name'] = $this->input->post('QuestionName');
			$savedata['job_id'] = $this->input->post('jobProfileID');
			
			//Data for addIntroQuestion
			$this->session->set_userdata('post_data_dev', $_POST);
			// $savedata['user_id'] = $userid;
			$this->QuestionModel->updateInterViewProfileQuestion($savedata,$inteViewQuesID,$userid);
			// first delete all question from join table and then insert interview related question id 
			
			$this->QuestionModel->dltIntrvwQuesByIQIDAttr($inteViewQuesID);
			/**
			 *  Then update all question with job profile id
			 */
			$AllQuestion_ID = $this->input->post('Question_ID');
			// var_dump($AllQuestion_ID); die();
			$saveAQuestionID = array();
			foreach($AllQuestion_ID  as $singleQuesID)
			{
				$saveAQuestionID[]= array(
										'ques_id' => $singleQuesID,
										'interv_ques_id' => $inteViewQuesID
									);	
			}
			$this->QuestionModel->saveInterViewWithQuestionID($saveAQuestionID);
			
			//$this->session->set_flashdata('message','Interview Question update successfully.');
			redirect(base_url().'questions/addIntroQuestion');
		}
		$this->_data['ivs'] = "quest";
		$this->_data['alljobprfile']= $this->jobprofile_model->getAlljob($userid);
		$this->load->view('interview/edit_interview',$this->_data);
	}
	/**
	 *  Ajax quetion list at a time on edit interview question 
	 */
	public function getAjaxQestionList()
	{
		// var_dump($_POST); die();
		$jobProfileID = $this->input->post('jobProfileID');
		$question_id_pre = $this->input->post('Question_ID');
		// find all question for jobprofile 
		$this->_data['pre_questionid'] = is_array($question_id_pre) ? $question_id_pre : array();
		$this->_data['all_attributes'] = $this->attribute->getAttibuteWithJObID($jobProfileID);
		$this->load->view('interview/getAjaxQestionList',$this->_data);
		//$this->load->view('attrQuestion',$this->_data);
	}
	
	/**
	 *  dynamic add a new question in attribute  with job profile
	 */
	public function addAttrQuestionDynamic()
	{
		$questionstring = $this->input->post('questionstring');
		$attr_id = $this->input->post('attr_id');
		$this->session->set_userdata('isNavigated',true);
		if(!empty($questionstring) && !empty($attr_id)){
		
			$dynamicSave = array(
								'question_name' => $questionstring,
								'user_id' =>  $this->session->userdata('userid'),
								'attr_id' =>  $attr_id,
							);		
			$getQuestionid = $this->QuestionModel->AddDynamicQuestion($dynamicSave);
			if($getQuestionid){
				$clas = 'Question_ID';
				if($attr_id==70 || $attr_id==71) $clas = 'intr_questions';
				echo "<div class='ui-state-highlight' id='ques-".$getQuestionid."'>$questionstring <input name='Question_ID[]' type='hidden' class='$clas' value='$getQuestionid' />
						<div style='float:right; width:8px;cursor:pointer; margin-top:-10px;'><a onclick='deleteQues(".$getQuestionid.")'><span style='cursor:pointer; color:#C6C6C6; font-size:10px; font-weight:bold;'>X</span></a></div>
														</div>";
			}
			
		}
	}
	/***
	 *  delete user question profile.
	 *  
	 *  @params integer $questionProFileID  // interview Profile id
	 */
	public function delQuestion($questionProFileID = NULL)
	{
		$user_id = $this->session->userdata('userid');
		if($questionProFileID == NULL)
		{
			$this->session->set_flashdata('error','you are trying to access  wrong url');
			redirect(base_url().'interviewer/builder');
		}	
		$InterViewProfielId =  $questionProFileID;
		if($this->QuestionModel->delQuestion($InterViewProfielId,$user_id))
		{
			$this->QuestionModel->deleteInterViewProfileQuestion($InterViewProfielId);
			$this->session->set_flashdata('message','Successfully delete interview profile question');
			redirect(base_url().'interviewer/builder');
		}else{
			$this->session->set_flashdata('error','there are some happen thing wrong, to delete this interview profile id');
			redirect(base_url().'interviewer/builder');
		}
	}

	


	/**
	 *  $this function use for Interview profile detail page.
	 */
	public function detail($title,$InterViewProfileID=NULL)
	{
		if($InterViewProfileID==NULL)
		{
			show_404();
		}
		$userid = $this->session->userdata('userid');
		$inteViewQuesID = base64_decode($InterViewProfileID);
		$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getInterViewQuestionByIDAndUserID($inteViewQuesID,$userid);		
		
		$this->load->view('interview/interview_detail',$this->_data);
	}
	/**
	 *   This is second phase for preview  Interview scripter page.
	 */
    public function addIntroQuestion()
	{
		$userid = $this->session->userdata('userid');
		$cur_list_que_id = $this->session->userdata('cur_list_que_id');
		$isEdit = $this->session->userdata('isedit');
		if($cur_list_que_id)
		{
			$this->_data['interviewQuestionIntro'] = $this->QuestionModel->getInterViewQuestionByIDAndUserID($cur_list_que_id,$userid);
			$this->_data['cur_list_que_id'] = $cur_list_que_id;
		}
		
		if(array_key_exists('QUestionSubmit',$_POST) && !$isEdit)
		{
			$this->session->set_userdata('preview_intr',$_POST);
			//var_dump(!$cur_list_que_id); exit;
			if(!$cur_list_que_id)
			{
				$savedata['interview_ques_name'] = $this->input->post('QuestionName');
				$savedata['job_id'] = $this->input->post('jobProfileID');
				$savedata['user_id'] = $userid;
				$cur_list_que_id = $this->QuestionModel->addquestions($savedata);
				$this->session->set_userdata('cur_list_que_id',$cur_list_que_id);
				$this->_data['cur_list_que_id'] = $cur_list_que_id;
				$first_questions = $_POST['Question_ID'];
				$firsts = array();
				foreach($first_questions as $question)
				{
					$firsts[]= array('ques_id' => $question,'interv_ques_id' => $cur_list_que_id);
				}
				$this->QuestionModel->saveInterViewWithQuestionID($firsts);
				$this->session->set_userdata('first_ok',true);
			}
		}
		if($isEdit) $preview_intr = $this->session->userdata('post_data_dev');
		else $preview_intr = $this->session->userdata('preview_intr');
		/*if(empty($preview_intr))
		{
			redirect(base_url().'questions/createquestion');	
		}*/
		//$Question_ID  = $preview_intr['Question_ID'];
		$this->_data['alljobprfile']= $this->jobprofile_model->getAlljob($userid);
		$this->_data['QuestionName'] = $preview_intr['QuestionName'];
		$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];
		//$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getQuestionBulkWithID($Question_ID);		
		$this->load->view('interview/intro_question_list',$this->_data);	
	}
	
	public function addClosingQues()
	{
		$userid = $this->session->userdata('userid');
		$isEdit = $this->session->userdata('isedit');
		$cur_list_que_id = $this->session->userdata('cur_list_que_id');
		$this->session->set_userdata('preview_intr', $_POST);
		$this->_data['interviewQuestionClose'] = $this->QuestionModel->getInterViewQuestionByIDAndUserID($cur_list_que_id,$userid);
		if(array_key_exists('QUestionSubmit',$_POST) && !$isEdit)
		{
			$this->session->set_userdata('Intro_Ques',$_POST);
			$isFirstOk = $this->session->userdata('first_ok');
			if(!$isFirstOk) redirect(base_url().'questions/createquestion');
			//var_dump(!$cur_list_que_id); exit;
			if($cur_list_que_id)
			{
				$intro_questions = $_POST['Question_ID'];
				$intros = array();
				foreach($intro_questions as $intro)
				{
					$intros[]= array('ques_id' => $intro,'interv_ques_id' => $cur_list_que_id);
				}
				$this->QuestionModel->saveInterViewWithQuestionID($intros);
				$this->session->set_userdata('intro_ok',true);
			}else redirect(base_url().'questions/createquestion');
			//print_r($intro_questions); echo '<hr/>'.$cur_list_que_id; exit;
		}
		if($isEdit)
		{
			$this->session->set_userdata('preview_intr', $_POST);
			$inteViewQuesID = $this->session->userdata('cur_list_que_id');
			$savedata['interview_ques_name'] = $this->input->post('QuestionName');
			$savedata['job_id'] = $this->input->post('jobProfileID');
			// $savedata['user_id'] = $userid;
			$this->QuestionModel->updateInterViewProfileQuestion($savedata,$inteViewQuesID,$userid);
			$this->QuestionModel->dltIntrvwQuesByIQIDIntro($inteViewQuesID);
			/**
			 *  Then update all question with job profile id
			**/
			$AllQuestion_ID = $this->input->post('Question_ID');
			// var_dump($AllQuestion_ID); die();
			$saveAQuestionID = array();
			foreach($AllQuestion_ID  as $singleQuesID)
			{
				$saveAQuestionID[]= array(
										'ques_id' => $singleQuesID,
										'interv_ques_id' => $inteViewQuesID
									);	
			}
			$this->QuestionModel->saveInterViewWithQuestionID($saveAQuestionID);
			
			//$this->session->set_flashdata('message','Interview Question update successfully.');
			//redirect(base_url().'previewinterviewProfile');
		}
		$preview_intr = $this->session->userdata('preview_intr');
		$into_Ques=$this->session->userdata('Intro_Ques');
		if(empty($preview_intr) || (empty($into_Ques) && !$isEdit))
		{
			redirect(base_url().'questions/createquestion');	
		}
		//print_r($preview_intr); exit;
		$this->_data['QuestionName'] = $preview_intr['QuestionName'];
		$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];
		//$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getQuestionBulkWithID($Question_ID);		
		$this->load->view('interview/add_closing_question',$this->_data);
	}


	public function previewinterviewProfile($qset_id = null)
	{
		$this->_data['ivs'] = 'builder';
		$userid = $this->session->userdata('userid');
		$cur_list_que_id = $this->session->userdata('cur_list_que_id');
		//var_dump(!$cur_list_que_id); exit;
		$isCloseOk = $this->session->userdata('close_ok');
		
		if(array_key_exists('QUestionSubmit',$_POST) && $_POST['QUestionSubmit'] == 'Save' && false)
		{
			$AllQuestion_ID = $this->input->post('Question_ID');
			if($AllQuestion_ID == false)
			{
				$this->session->set_flashdata('error','Please drag question from right side to left side panel.');
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			// form submitted, where 'QUestionSubmit' is the name of submit button			
			//$savedata['interview_ques_name'] = $this->input->post('QuestionName');
			//$savedata['job_id'] = $this->input->post('jobProfileID');
			//$savedata['user_id'] = $userid;
			//$GetInterViewQuestionID = $this->QuestionModel->addquestions($savedata);
			$GetInterViewQuestionID = $qset_id;
			
			// now update join table with question_id and interview-question-id  
			if($GetInterViewQuestionID)
			{
				
				// var_dump($AllQuestion_ID); die();
				$saveAuestionID = array();
				if(is_array($AllQuestion_ID)){
					foreach($AllQuestion_ID  as $singleQuesID)
					{
						$saveAuestionID[]= array(
												'ques_id' => $singleQuesID,
												'interv_ques_id' => $GetInterViewQuestionID
											);	
					}
					$this->QuestionModel->saveInterViewWithQuestionID($saveAuestionID);
				}
			}
			$this->session->set_flashdata('message','Interview Question saved successfully.');
			$this->session->unset_userdata('preview_intr');
			redirect(base_url().'interviewer/builder');
		}
		$this->session->unset_userdata('cur_list_que_id');
		if($qset_id != null)
		{
			$this->_data['qset_id'] = $qset_id;
			$this->db->select('*');			
			$this->db->where('interv_ques_id',$qset_id);
			$questionListId = $this->db->get('interview_question')->row();
			$this->_data['QuestionName'] = $questionListId->interview_ques_name;
			$this->_data['QuestionInfo'] = $questionListId;
			$this->_data['que_details_cur'] = $this->attribute->getAttibuteWithIdentAttr($questionListId->identify_attr);
			$desired_attributes = $this->attribute->getAttibuteWithIdentAttr($questionListId->identify_attr);							
			$main_cats = array();
			if($desired_attributes)
			foreach($desired_attributes as $satr) {
				$main_cats[$satr->attr_id]=$satr->cat_name;
			}
			$this->_data['catnames'] = $main_cats;			
			$this->_data['desired_attributes'] = $desired_attributes;

			//print_r($questionListId);
			
			if($questionListId->interv_ques_id == '')
			{
				$this->session->set_flashdata('Info','NO Questions added for this list, Please edit and Add Questions');
				redirect($_SERVER['HTTP_REFERER']);
			}
			
			// form submitted, where 'QUestionSubmit' is the name of submit button			
			//$savedata['interview_ques_name'] = $this->input->post('QuestionName');
			//$savedata['job_id'] = $this->input->post('jobProfileID');
			$savedata['user_id'] = $userid;
			$isViewOnly = true;
			$this->_data["isViewOnly"] = $isViewOnly;
			//$this->session->set_flashdata('message','Interview Question saved successfully.');
			//$this->session->unset_userdata('preview_intr');
			//redirect(base_url().'questions');
			//echo $questionListId; exit;
			$this->db->select('ques_id');
			$this->db->where('interv_ques_id',$qset_id);
			$questionIds = $this->db->get('interview_qus_question');
			$res = $questionIds->result();
			//print_r($res);
			$ques_ids = array();
			$ques_idsall = array();
			$introQuestion_ID = array();
			$closingQuestion_ID = array();
			foreach($res as $singRes)
			{
				//print_r($singRes); exit;
				$this->db->select('attr_id');
				$this->db->where('ques_id',$singRes->ques_id);
				$attr = $this->db->get('questions')->row();
				if($attr->attr_id == '70')	$introQuestion_ID[] = $singRes->ques_id;
				else if($attr->attr_id == '71')	$closingQuestion_ID[] = $singRes->ques_id;
				else $ques_ids[] = $singRes->ques_id;
				$ques_idsall[] = $singRes->ques_id;
			}

			$previewData = array('QuestionName' => $this->_data['QuestionName'],'Question_ID' => $ques_ids,'QUestionSubmit' => 'Download');
			//echo $this->db->last_query();
			//print_r($questionIds->ques_id);
			
			//$this->session->set_userdata('preview_intr',$previewData);
			$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getQuestionBulkWithID($ques_idsall);
			$this->load->view('interview/final_Question_List',$this->_data);
			if(isset($_POST['QUestionSubmit']) && $_POST['QUestionSubmit'] == 'Download')
			{
				$this->_data['button'] = False;
				$this->_data['catnames'] = $main_cats;
				$this->_data['que_details_intro'] = $this->QuestionModel->getQuestionBulkWithID($introQuestion_ID);
				$this->_data['que_details_closing'] = $this->QuestionModel->getQuestionBulkWithID($closingQuestion_ID);
				$html = $this->load->view('interview/download.php', $this->_data, TRUE);
				$name = url_title($this->_data['QuestionName']);
				// Creating a File
				$fp = fopen(APPPATH."files/".$name.".doc", "a+");
				ftruncate($fp, 0);			
				fwrite($fp,$html);
				//path to the file
				$file_path=APPPATH.'files/'.$name.".doc";
				//Call the download function with file path,file name and file type
				$this->output_file($file_path, ''.$name.'.doc', 'application/msword');
				exit;
				// $this->_tc_pdf($html, $name);
			}
			return;
		}
		
		
		if(isset($_POST['QUestionSubmit']) && $_POST['QUestionSubmit'] == 'Download') {

			$this->session->set_userdata('preview_intr',$_POST);
        }	
		
		$preview_intr = $this->session->userdata('preview_intr');
		if(empty($preview_intr))
		{
			redirect(base_url().'interviewer/question');	
		}
		$IntroQues=$this->session->userdata('Intro_Ques');
		if(!empty($IntroQues['Question_ID']))
		{
			$introQuestion_ID  = $IntroQues['Question_ID'];
			$this->_data['introQuestion_ID'] = $introQuestion_ID;
			//$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];
			$this->_data['interviewQuestionIntro'] = $this->QuestionModel->getQuestionBulkWithID($introQuestion_ID);
		}
		$closingQues=$this->session->userdata('closing_Ques');
		if(!empty($closingQues['Question_ID']))
		{
			$closingQuestion_ID  = $closingQues['Question_ID'];
			$this->_data['closingQuestion_ID'] = $closingQuestion_ID;
			//$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];
			$this->_data['interviewQuestionClosing'] = $this->QuestionModel->getQuestionBulkWithID($closingQuestion_ID);		
		}
		
		if(!empty($preview_intr['Question_ID']))
		{
			$Question_ID  = $preview_intr['Question_ID'];
			$this->_data['QuestionName'] = $preview_intr['QuestionName'];
			//$this->_data['jobProfileID'] = $preview_intr['jobProfileID'];
			$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getQuestionBulkWithID($Question_ID);
		}
		if(isset($_POST['QUestionSubmit']) && $_POST['QUestionSubmit'] == 'Download')
		{
			$this->_data['button'] = False;
			$this->_data['que_details_intro'] = $this->QuestionModel->getQuestionBulkWithID($introQuestion_ID);
			$this->_data['que_details_closing'] = $this->QuestionModel->getQuestionBulkWithID($closingQuestion_ID);
			$html = $this->load->view('interview/download.php', $this->_data, TRUE);
			$name = url_title($this->_data['QuestionName']);
			// Creating a File
			$fp = fopen(APPPATH."files/".$name.".doc", "a+");
			ftruncate($fp, 0);			
			fwrite($fp,$html);
			//path to the file
			$file_path=APPPATH.'files/'.$name.".doc";
			//Call the download function with file path,file name and file type
			//$this->output_file($file_path, ''.$name.'.doc', 'application/msword');
			$this->output_file($file_path, ''.$name.'.doc', 'text/plain');
			exit;
			// $this->_tc_pdf($html, $name);
		}
		/*if($isEdit)
		{
			$this->_data['interviewQuestionInfo'] = $this->QuestionModel->getInterViewQuestionByIDAndUserID($cur_list_que_id,$userid);
			$this->_data['jobProfileID'] = $_POST['jobProfileID'];
			$this->_data['isEdit'] = $isEdit;
		}*/
		$this->load->view('interview/final_Question_List',$this->_data);	
	}
	
	public function deleteListQuestion($quesId){
		
		$this->QuestionModel->delListQuest($quesId);
	}

	public function deleteQuestionFromList($quesId)
	{
		$this->QuestionModel->deluserQuest($quesId);
		$tok=0;
		$introQues=$this->session->userdata('Intro_Ques');
		$preview_intr = $this->session->userdata('preview_intr');
		$closingQues=$this->session->userdata('closing_Ques');
		if(!empty($introQues['Question_ID']))
		{
			$tempIntro = $introQues['Question_ID'];
			if(is_array($tempIntro)){
				foreach($tempIntro as $key=>$qid)
				{
					if($qid==$quesId)
					{
						unset($introQues['Question_ID'][$key]);
						$tok=1;
					}
				}
			}
		}
		
		if(!empty($introQues['Question_ID']))
			{
				$this->session->set_userdata('Intro_Ques',$introQues);
			}
			else
			{
				$this->session->unset_userdata('Intro_Ques');
			}

		if(!empty($preview_intr['Question_ID']) && $tok==0)
		{
			$temp = $preview_intr['Question_ID'];
			if(is_array($temp)){
				foreach($temp as $key=>$qid)
				{
					if($qid==$quesId)
					{
						unset($preview_intr['Question_ID'][$key]);
						$tok=1;
					}
					
				}
			}
			
		}
			if(!empty($preview_intr['Question_ID']))
			{
				$this->session->set_userdata('preview_intr',$preview_intr);
			}
			else
			{
				$this->session->unset_userdata('preview_intr');
			}
		if(!empty($closingQues['Question_ID']) && $tok==0)
		{
			$temp = $closingQues['Question_ID'];
			$i=0;
			if(is_array($temp)){
				foreach($temp as $key=>$qid)
				{
					if($qid==$quesId)
					{
						unset($closingQues['Question_ID'][$key]);
						$tok=1;
					}
					$i++;
				}
			}
		}
		if(!empty($closingQues['Question_ID']))
			{
				$this->session->set_userdata('closing_Ques',$closingQues);
			}
			else
			{
				$this->session->unset_userdata('closing_Ques');
			}
			
		
	}


	//This application is developed by www.webinfopedia.com
	//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
	public function output_file($file, $name, $mime_type='')
	{
	 /*
	 This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
	 */

	 //Check the file premission
	 if(!is_readable($file)) die('File not found or inaccessible!');

	 $size = filesize($file);
	 $name = rawurldecode($name);

	 /* Figure out the MIME type | Check in array */
	 $known_mime_types=array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg"=> "image/jpg",
			"jpg" =>  "image/jpg",
			"php" => "text/plain"
	 );

	 if($mime_type==''){
			 $file_extension = strtolower(substr(strrchr($file,"."),1));
			 if(array_key_exists($file_extension, $known_mime_types)){
					$mime_type=$known_mime_types[$file_extension];
			 } else {
					$mime_type="application/force-download";
			 }
	 }

	 //turn off output buffering to decrease cpu usage
	 @ob_end_clean(); 

	 // required for IE, otherwise Content-Disposition may be ignored
	 if(ini_get('zlib.output_compression'))
	  ini_set('zlib.output_compression', 'Off');

	 header('Content-Type: ' . $mime_type);
	 header('Content-Disposition: attachment; filename="'.$name.'"');
	 header("Content-Transfer-Encoding: binary");
	 header('Accept-Ranges: bytes');

	 /* The three lines below basically make the 
		download non-cacheable */
	 header("Cache-control: private");
	 header('Pragma: private');
	 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	 // multipart-download and download resuming support
	 if(isset($_SERVER['HTTP_RANGE']))
	 {
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
					$range_end=$size-1;
			} else {
					$range_end=intval($range_end);
			}
			/*
		   ------------------------------------------------------------------------------------------------------
			//This application is developed by www.webinfopedia.com
			//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
		   ------------------------------------------------------------------------------------------------------
			*/
			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
	 } else {
			$new_length=$size;
			header("Content-Length: ".$size);
	 }

	 /* Will output the file itself */
	 $chunksize = 1*(1024*1024); //you may want to change this
	 $bytes_send = 0;
	 if ($file = fopen($file, 'r'))
	 {
			if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);

			while(!feof($file) && 
					(!connection_aborted()) && 
					($bytes_send<$new_length)
				  )
			{
					$buffer = fread($file, $chunksize);
					print($buffer); //echo($buffer); // can also possible
					flush();
					$bytes_send += strlen($buffer);
			}
		fclose($file);
	 } else {
		//If no permissiion
		die('Error - can not open file.');
		//die
		}
	die();
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */