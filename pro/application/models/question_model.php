<?php
/**
 * Class file for queston Model
 *  
 * This is question model file having peform all acivity for Query with question \
 * and related table 
 *  
 *  PHP > 5.2
 *  
 *  @author Bineet kumar chaubey 
 *  @package codeigniter
 *  @subpackage Interview scripter
 *  @version 1.0
 *  
 */
class question_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
    function __construct()
    {
                parent::__construct();               
    }
    /**
     * Function name  : getcategory
     * Function Use   :This function is use to fetch category records.
     * Function Param :NULL
     * Return Value:Result. 
     */ 
	public function getcategory()
	{
            $result=$this->db->query("select * from category");
            return $result;
    }
	

    /**
     * Function name  : addquestions
     * Function Use   :This function is use to fetch category records.
     * Function Param :NULL
	 * @params  $array questionData
     * @return integer OR boolean last insert id 
	 
     */ 
	public function addquestions($questionData)
	{
	   if(is_array($questionData)){
			$this->db->insert('interview_question',$questionData);
			return $this->db->insert_id();
	   }
	   return false;
    }
	
	/**
	 *  save Question id with interview question ID in Join Tabel interview_qus_question
	 *  @params array $saveQuestionID multi dimensional associative array 
	 */
	public function saveInterViewWithQuestionID($saveQuestionID)
	{
		if(!empty($saveQuestionID) && is_array($saveQuestionID))
		{
			return $this->db->insert_batch('interview_qus_question',$saveQuestionID);
		}
		return false;
	}
	
	/**
     * Function name  : getquestions
     * Function Use   :This function is use to fetch questions
     * Function Param :$subcat
     * Return Value:Result. 
     */ 
	public function getquestions($subcat)
	{
		$result=$this->db->query("select * from questions where subcat_id='$subcat'");
		return $result;
    }

	/**
	 *  Fetch all interview question for loggedin User
	 *  @params interger $userid	 
	 */
	public function getAllInterViewQuestion($userid)
	{
		$this->db->where('user_id',$userid);
		$query = $this->db->get('interview_question');
	    if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	}
	/**
	 *   get interview profile question by id and user id 
	 */
	public function getInterViewQuestionByIDAndUserID($inteViewQuesID,$user_id)
	{
		$this->db->where('interv_ques_id',(int)$inteViewQuesID);
		$this->db->where('user_id',(int)$user_id);
		$query = $this->db->get('interview_question');
		$responce = array();
		if($query->num_rows > 0)
		{
			$responce['interiView'] = $query->row();
			//  now select data from join table
			$this->db->select('a.ques_id,a.question_name ,a.attr_id,b.intr_qus_qes_id,b.interv_ques_id');
			$this->db->from('questions a');
			$this->db->join('interview_qus_question b','a.ques_id = b.ques_id');
			$this->db->where('b.interv_ques_id',$inteViewQuesID);
			//echo $this->db->last_query();
			$query2 = $this->db->get();
			
			if($query->num_rows > 0)
			{
				$responce['QuestionInfo'] = $query2->result();
			}
		}
		return $responce ;
	}
	/**
	 *  update interviewProfileQuestion section 
	 *  @params array $savedata , data to be update
	 *  @params integer $inteViewQuesID interviewProfileQuestion id
	 *  @params $userid  current user id;
	 */	 
	public function updateInterViewProfileQuestion($savedata,$interViewQuesID,$userid)
	{
		$this->db->where('interv_ques_id',$interViewQuesID);
		$this->db->where('user_id',$userid);
		$this->db->update('interview_question',$savedata);	
	}
	
	public function deluserQuest($intrvwquesid)
	{		
		$this->db->query("DELETE FROM questions WHERE ques_id = ".$intrvwquesid." and user_id=".$_SESSION['ss_user_id']);		
	}
	public function delListQuest($intrvwquesid)
	{		
		$this->db->query("DELETE FROM interview_qus_question WHERE ques_id = ".$intrvwquesid );		
	}
	
	public function dltIntrvwQuesByIQIDAttr($intrvwquesid)
	{
		//echo "DELETE FROM interview_qus_question WHERE intr_qus_qes_id = ".$intrvwquesid." and ques_id IN (SELECT ques_id FROM questions WHERE attr_id NOT IN(70,71))";
		//exit;
		$result = $this->db->query("DELETE FROM interview_qus_question WHERE interv_ques_id = ".$intrvwquesid." and ques_id IN (SELECT ques_id FROM questions WHERE attr_id  NOT IN(70,71))");
		return $result;
	}
	
	public function dltIntrvwQuesByIQIDIntro($intrvwquesid)
	{
		$result = $this->db->query("DELETE FROM interview_qus_question WHERE interv_ques_id = ".$intrvwquesid." and ques_id IN (SELECT ques_id FROM questions WHERE attr_id = 70)");
		return $result;
	}
	
	public function dltIntrvwQuesByIQIDClose($intrvwquesid)
	{
		$result = $this->db->query("DELETE FROM interview_qus_question WHERE interv_ques_id = ".$intrvwquesid." and ques_id IN (SELECT ques_id FROM questions WHERE attr_id = 71)");
		return $result;
	}
	/**
	 *  delete jobProfile question with a  join table interview_qus_question
	 */
	public function deleteInterViewProfileQuestion($inteViewQuesID)
	{
		$this->db->where('interv_ques_id',$inteViewQuesID);
		$this->db->delete('interview_qus_question');
	}
	/**
	 *  Add dynamic question in question table by user id 
	 */
	public function AddDynamicQuestion($dynamicQuestion)
	{	
		//print_r($dynamicQuestion); exit;
		if($this->db->insert('questions',$dynamicQuestion))
		{
			return $this->db->insert_id();
		}
		return false;
	}
	/**
	 *  delete interview Question profile form database. 
	 */
	public function delQuestion($InterViewProfielId,$user_id)
	{
		$this->db->where('interv_ques_id',$InterViewProfielId);
		$this->db->where('user_id',$user_id);
		$this->db->delete('interview_question');
		// echo $this->db->last_query(); die();
		$affectedrow =$this->db->affected_rows();
		if($affectedrow > 0)
		{
		  return true;
		}
		 return false;
	}
	/**
	 *   get interview profile question with question id
	 *  
	 *  @params integer interview profile id 
	 */
    public function getQuestionBulkWithID($id)
	{
		//print_r($id);
		

		if(is_array($id)){
			if(!empty($id))
			{
			$this->db->where_in('ques_id',$id);
			$fieldshort = implode(',',$id);
			}
			else return array();
		}else{
			$this->db->where('ques_id',$id);
			$fieldshort = $id;
		}
		$ordeBY = "FIELD(ques_id,$fieldshort)";
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by($ordeBY);
		$this->db->_protect_identifiers = TRUE;
		$query = $this->db->get('questions');
		// echo $this->db->last_query();
		
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	}

	public function getTotalQuestionCountForAdmin($search)
	{
		$this->db->select('count(ques_id) as totalcount');
		if($search!=NULL)
		{
			$this->db->like('question_name',$search);
		}
		$this->db->from('questions');
		// $this->db->join('users', 'users.user_id = questions.user_id');
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			return $query->row()->totalcount;
		}
		return null;
	}
	/**
	 *  get questions list with limit for admin dashbord section 
	 */
	public function getAllQuestionListForAdmin($search=NULL,$page=NULL,$per_page=10)
	{
		// $this->db->select('count(ques_id) as totalcount');
		if($search!=NULL)
		{
			$this->db->like('question_name',$search);
		}
		if($page!=NULL)
		{
			$startpoint = ($page-1)* $per_page ;
			$this->db->limit($per_page,$startpoint);
		}
		$this->db->from('questions');
		$this->db->join('users', 'users.user_id = questions.user_id','left');
		$query = $this->db->get();
		
		// echo $this->db->last_query(); die();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	}
	/**
	 *  update question by admin
	 */
	public function update($question_id,$savearray)
	{
		$this->db->update('questions',$savearray,array('ques_id' =>$question_id ));
		return true;
	}
	/**
	 *   delete question by admin
	 */
	public function delQuestionByID($quesID)
	{
		$this->db->where('ques_id',$quesID);
		$query = $this->db->delete('questions');
		if($query)
		{
			return true;
		}else{
			return false;
		}
	}

	public function getQuestionDetail($quesID)
	{
		$this->db->select('interview_ques_name as QuestionName,job_id as jobProfileID');
		//$this->db->from('interview_question');
		$this->db->where('interv_ques_id',$quesID);
		$query = $this->db->get('interview_question');
		
		// echo $this->db->last_query(); die();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
		return array();
	} 
	

	public function getInterViewQuestionByID($inteViewQuesID)
	{
		$this->db->where('interv_ques_id',$inteViewQuesID);
		$query = $this->db->get('interview_question');
		$responce = array();
		if($query->num_rows > 0)
		{
			//$responce['interiView'] = $query->row();
			//  now select data from join table
			$this->db->select('a.ques_id,a.question_name');
			$this->db->from('questions a');
			$this->db->join('interview_qus_question b','a.ques_id = b.ques_id');
			$this->db->where('b.interv_ques_id',$inteViewQuesID);
			$query2 = $this->db->get();
			
			if($query->num_rows > 0)
			{
				//$responce['QuestionInfo'] = $query2->result();
				//$responce[]=$query2->result();
				return $query2->result();
			}
		}
		//return $responce ;
	}
	//Question Actions
	//Save Question
	function question_save($data,$id=0)
	{
	   $user_id = $_SESSION['ss_user_id'];
	   if($id) {
	    	$this->db->where('interv_ques_id', $id);
	   		$this->db->update('interview_question',$data);
		} else {
			$data['user_id']=$user_id;
	   		$this->db->insert('interview_question',$data);
	   		$id = $this->db->insert_id();
		}
	   return $id;
	}
	//Get Question
	public function question_get($QuesID)
	{
		$user_id = $_SESSION['ss_user_id'];
		//$this->db->select('a.ques_id,a.question_name ,a.attr_id,b.intr_qus_qes_id,b.interv_ques_id');
		$this->db->from('interview_question');
		$this->db->where('user_id',$user_id);
		$this->db->where('interv_ques_id',$QuesID);
		$query2 = $this->db->get();		
		if($query2->num_rows > 0)
		{
			return $query2->row_array();
		}
		return array();
	}
	//Get Question Attributes
	public function question_attributes($QuesID)
	{
		$this->db->select('q.*,qa.intr_qus_qes_id');
		$this->db->from('interview_qus_question qa');
		$this->db->join("questions q", 'q.ques_id = qa.ques_id','left');
		$this->db->where('qa.interv_ques_id',$QuesID);
		$query2 = $this->db->get();	
		if($query2->num_rows > 0)
		{
			return $query2->result();
		}
		return array();
	}
	//Delete Question Attributes
	function question_attributes_delete($qid,$aids)
	{
	   $this->db->where('interv_ques_id',$qid);
	   $this->db->where_in('ques_id',$aids);
	   $this->db->delete('interview_qus_question');	   
	}
	//Get Identify Attribute Questions
	public function identify_attributes($atrids)
	{
		$this->db->from('attributes');
		$this->db->where_in('attr_id',$atrids);
		$query2 = $this->db->get();			
		if($query2->num_rows > 0)
		{
			return $query2->result();
		}
		return array();
	}
	
	public function questionId_questions($QuesID)
	{
		$this->db->select('q.ques_id');
		$this->db->from('interview_qus_question qq');
		$this->db->join("questions q", 'q.ques_id = qq.ques_id','left');		
		$this->db->where('qq.interv_ques_id',$QuesID);
		$this->db->where("q.question_name<>''",NULL,FALSE);
		$this->db->order_by("q.attr_id","asc");
		$query2 = $this->db->get();			
		if ($query2->num_rows() > 0)
    	{
    		return $query2->result();
    	}
	}
}
/** end file  */