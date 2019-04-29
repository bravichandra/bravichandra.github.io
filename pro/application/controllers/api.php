<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller  
{
	/**
	 * Properties
	 */
	private $_api_key;
	private $_verify_key;
	private $_api_url;
	private $_format;
	private $_fields = array();
	//--------------------------------------------------------------
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->output->nocache();
		$this->_api_key = "4j626eK2ghfKxvCTV2dF";
		$this->_verify_key = "K2ghfKxv";
		$this->_api_url = "https://salesscripter.com/members/api/";
		$this->_format = "json";
		$this->_reset_fields();
	}
	//--------------------------------------------------------------
	/**
	 * Index
	 */
	public function index()
	{
		if($this->input->get('reg_source') == "website")
		{
			$this->_users_add(TRUE);
		}else{
			echo "Sales Scripter";
		}
	}
	//--------------------------------------------------------------
	/**
	 * Users
	 * 
	 * @return boolean
	 */
	public function users($method = 'add')
	{
		if(!$this->_validate_key())
		{
			echo json_encode(array('error'=>'Invalid Key', 'code'=>902));
			exit;
		}
		if($method == 'add')
		{
			return $this->_users_add();
		}
		if($method == 'update')
		{
			return $this->_users_update();
		}
		if($method == 'get')
		{
			return $this->_users_get();
		}
	}
//--------------------------------------------------------------
	/**
	 * Add a new user
	 * 
	 * @return boolean
	 */
	private function _users_add($web=NULL)
	{
		
		// Load string helper
  		$this->load->helper('string');
		$pass = random_string('alnum', 8);
		$username = $this->input->get('login');
		if($web)
		{
			$temp_username = $username;
		}
		if($username AND !$web)
		{
			$username = explode("_", $username);
			$username = $username[0];
			$no = 0;
			do 
			{
				if(!isset($unique))
				{
					$temp_username = $username;
				}
				$unique = TRUE;
				if($this->_username_exists($temp_username))
				{
					$unique = FALSE;
					$temp_username = $username . random_string('numeric', 3);
					if($no == 5)
					{
						break;
					}
				}
				$no++;
			} while (!$unique);
		}
		$fields = array(
		        'login' => $temp_username,
		        'pass' => $this->input->get('pass') ? $this->input->get('pass') : $pass,
		        'email' => $this->input->get('email'),
		        'name_f' => $this->input->get('name_f'),
		        'name_l' => $this->input->get('name_l'),
				'phone' => str_replace(" ", "-", $this->input->get('phone')),
				'status' => 1
		    );			
		if(!$web) {$fields['aff_id'] = 249;}
		// Check username
		if($this->_username_exists($username))
		{
			echo json_encode(array('error'=>'Username exists', 'code'=>901));
			exit;
		}
		else 
		{
			$this->_reset_fields();
			foreach ($fields as $key=>$value) 
			{
				$this->_fields[$key] = $value;
			}			
			$data = $this->_curl("users", $this->_fields, TRUE);
			$data = json_decode($data);
			// var_dump($data); 
			if(!empty($data[0]->user_id))
			{
				// Add Scripter Basic Access
				$this->_add_scripter_basic($data[0]->user_id);
				if($web)
				{
					$redirect_url = $this->input->get('redirect_url');
					header("location: $redirect_url");
					exit;
				}
				echo json_encode(array('success'=>'ok', 'code'=>200));
				exit;
			}
		}
	}
	public function _add_scripter_basic($user_id)
	{
		$start_date = date("Y-m-d", time());
		$end_date = date("Y-m-d", strtotime("+30 days"));
		$fields = array(
		    // Access record
		    'nested[invoice-items][0][item_id]' => 5,
		    'nested[access][0][user_id]' => $user_id,
		    'nested[access][0][product_id]' => 5,
		    'nested[access][0][transaction_id]' => "Added_via_API",
		    'nested[access][0][begin_date]' => $start_date,
		    'nested[access][0][expire_date]' => $end_date
		);
		$res = $this->_curl("invoices", $fields, TRUE);
	}
//--------------------------------------------------------------
	/**
	 * Updates a user
	 * 
	 * @return boolean
	 */
	private function _users_update()
	{
		$fields = array(
		        'login' => $this->input->get('login'),
		        'pass' => $this->input->get('pass'),
				'_method' => 'PUT'
		    );
		// Check username
		if(!$data = $this->_username_exists($this->input->get('login')))
		{
			echo json_encode(array('error'=>'Username does not exist', 'code'=>901));
			exit;
		}
		else 
		{
			$no =0;
			foreach ($data as $key=>$value)
			{
				if($no == 1)
				{
					$data = $value;
					break;
				}
				$no++;
			}
			$this->_reset_fields();
			foreach ($fields as $key=>$value) 
			{
				$this->_fields[$key] = $value;
			}
			$data_upd = $this->_curl("users/" . $data->user_id, $this->_fields, TRUE);
			$data_upd = json_decode($data_upd);
			if(!empty($data_upd[0]->user_id))
			{
				echo json_encode(array('success'=>'ok', 'code'=>200));
				exit;
			}
		}
	}
//--------------------------------------------------------------
	/**
	 * Check if username exists
	 * 
	 * @param $username
	 * 
	 * @return boolean
	 */
	private function _users_get()
	{
		$username = $this->input->get('login');
		$this->_fields['_filter[login]'] = $username;
		$data = $this->_curl("users", $this->_fields);
		// var_dump($data);
		return $data;
	}
//--------------------------------------------------------------
	/**
	 * Check if username exists
	 * 
	 * @param $username
	 * 
	 * @return boolean
	 */
	private function _username_exists($username)
	{
		$this->_fields['_filter[login]'] = $username;
		$data = json_decode($this->_curl("users", $this->_fields));
		if($data->_total > 0)
		{
			return $data;//TRUE;
		}
	}
//--------------------------------------------------------------
	/**
	 * Verify key
	 * 
	 * @return boolean
	 */
	private function _validate_key()
	{
		$key = $this->input->get('key');
		if($key == $this->_verify_key)
		{
			return TRUE;
		}
	}
//--------------------------------------------------------------
	/**
	 * Reset fields
	 */
	private function _reset_fields()
	{
		$this->_fields = array();
		$this->_fields['_key'] = $this->_api_key;
		$this->_fields['_format'] = $this->_format;
	}
//--------------------------------------------------------------
	/**
	 * cURL method to talk with API
	 */
	private function _curl($controller, $fields, $is_post = FALSE)
	{
		$url = $this->_api_url . $controller . "?";
		$fields['_key'] = $this->_api_key;
		$fields['_format'] = $this->_format;
		$fields_string  = http_build_query($fields);
		if(!$is_post)
		{
			$url = $url . $fields_string;
		}
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		if($is_post)
		{
			curl_setopt($ch,CURLOPT_POST,count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		return $result;
	}
	//When email viewed then add quality points to User interactions
	public function eview($rkey)
	{
		echo "https://www.salesscripter.com/logo.png";
		$stop=0;
		if(empty($rkey)) $stop=1;
		else if(strlen($rkey)<10) $stop=1;
		$contact_id = $this->uri->segment(4);
		if(empty($contact_id)) $stop=1;
		else if(strlen($contact_id)<11) $stop=1;
		$etime = $this->uri->segment(5);
		if(empty($etime)) $stop=1;
		if($stop) exit;
		$user_id = (int)substr($rkey,6,strlen($rkey)-9);
		$contact_id = (int)substr($contact_id,6,strlen($contact_id)-10);
		if(!$user_id || !$contact_id) exit;
		$this->load->model('crm_model', 'crm');
		//User
		$exuser=$this->crm->get_CurrentUser($user_id);
		if(!$exuser) return;
		//Verify contact person already viewed that sent email
		$email_views=array();
		$this->load->model('home_model', 'home');
		$where = array();
		$where['user_id'] = $user_id;
		$where['field_type'] = 'Email-Views';
		$user_info = $this->home->getUserData($where);
		if($user_info) $email_views = explode(",",$user_info[0]->value);
		if(in_array($etime,$email_views)!==FALSE) exit;
		//Save email viewed time
		$data = array();
		$email_views_times = $email_views;
		$email_views_times[] = $etime;
		$data['value'] = implode(",",$email_views_times);
		if($email_views) $this->home->saveUserData($data,$where);
		else {
			$data['user_id'] = $user_id;
			$data['field_type'] = 'Email-Views';
			$this->home->saveUserData($data);
		}
		//Clear email subject from db
		$email_viewed_subject = '';
		$where = array();
		$where['user_id'] = $user_id;
		$where['field_type'] = 'Email-Subjects';
		$esuser_info = $this->home->getUserData($where);
		if($esuser_info) {
			if($esuser_info[0]->value) {
				$email_subjects = $esuser_info[0]->value;
				$email_subjects = json_decode($email_subjects);
				$etime = "$etime";
				if(isset($email_subjects->$etime)) {
					$email_viewed_subject = $email_subjects->$etime;
					/*unset($email_subjects->$etime);
					if($email_subjects) $email_subjects = json_encode($email_subjects);
					else $email_subjects = '';
					if($email_subjects && $email_subjects=="{}") $email_subjects = '';
					$edata = array();
					$edata['value'] = $email_subjects;
					$this->home->saveUserData($edata,$where);*/
				}
			}
		}
		//echo "<pre>";print_r($exuser);echo "</pre>".$contact_id;
		//Contact
		$contact=$this->crm->get_contact($contact_id,array($user_id));
		if(!$contact) return;
		//echo "<pre>";print_r($contact);echo "</pre>";
		//Timezone
		$tzone="America/Chicago";
		$where = array();
		$where['user_id'] = $user_id;
		$where['field_type'] = 'timezone';
		$user_info = $this->home->getUserData($where);
		if($user_info) {
			$user_info = $user_info[0];
			if(isset($user_info->value)) $tzone=$user_info->value;
		}
		date_default_timezone_set($tzone);
		//Qaulity Points
		$this->load->helper('scripts');		
		//$categories = crm_options();
		$categories = crm_introptions();
		$c=2;
		$s=1;
		$opt=5;
		$sec_val = $categories['category'][$c][$s];
		$sec_opt = $sec_val['options'];
		$oname = $sec_opt[$opt]['name'];
		$points = $sec_opt[$opt]['points'];
		$pursuit = $sec_opt[$opt]['pursuit'];		
		$idate = date("Y-m-d");
		//Email Template name
		$template_name = $this->uri->segment(6);
		if($template_name) {
			$template_name = str_replace("-","=",$template_name);
			$template_name = base64_decode($template_name);
		} else $template_name='';
		//Create completed task : Log a Call
		$taskdata = array(
					'task_subject'=>'Email opened',
					//'task_name'=>$template_name,
					'task_name'=>$email_viewed_subject,
					'task_priority'=>'Normal',
					'task_status'=>'Completed',
					'task_duedate'=>$idate,
					'task_related'=>'C',
					'task_relatedto'=>$contact_id,
					'share_user_id'=>$user_id,
					'userid'=>$user_id,
					'task_created'=>$idate." 00:00:00",
					'task_modified'=>$idate." 00:00:00",
					'task_info'=>'They opened the email'
					);
		$tid = $this->crm->save_task($taskdata,0);
		//Interaction Points
		$where = array('userid'=>$user_id,'contact'=>$contact_id,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
		$cont_points = $this->crm->get_points($where);
		if($cont_points) {
			$update_data = array(
					'userid'=>$user_id,
					'contact'=>$contact_id,
					'cat'=>$c,
					'pdate'=>$idate,
					'rctype'=>'C'
					);
			$points_data = array(
					'intpoints'=>$cont_points['intpoints']+$points,
					'purpoints'=>$cont_points['purpoints']+$pursuit,
					'taskid'=>$tid
					);
			$this->crm->save_points($points_data,$update_data);
		} else {
			$points_data = array(
					'userid'=>$user_id,
					'contact'=>$contact_id,
					'rctype'=>'C',
					'pdate'=>$idate,
					'intpoints'=>$points,
					'purpoints'=>$pursuit,
					'cat'=>$c,
					'taskid'=>$tid
					);
			$this->crm->save_points($points_data);
		}
		//echo "<pre>IP";print_r($points_data);echo "</pre>";
		//echo "<pre>IPW";print_r($update_data);echo "</pre>";
		//Interaction Usage
		$intr_sno=$c."-".$s."-".$opt;
		//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$user_id);
		$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$contact_id);
		$intrdata = $this->crm->check_interaction_date($where,$user_id);
		if($intrdata) {
			$update = array('intr_count'=>$intrdata['intr_count']+1);
			//update email template info
			if($template_name) {
				if($intrdata['intr_info']) {
					$etinfo = json_decode($intrdata['intr_info']);
					if(isset($etinfo->tnames)) {
						$etinfo->tnames[]=$template_name;
					} else {
						$etinfo->tnames=array($template_name);
					}
					$etinfo->tnames = array_unique($etinfo->tnames);
					//Subject line				
					if($email_viewed_subject) {
						if(isset($etinfo->subjects)) {
							$etinfo->subjects->$tid=$email_viewed_subject;
						} else {
							$etinfo->subjects=array($tid=>$email_viewed_subject);
						}	
					}
					$etinfo = json_encode($etinfo);
				} else {
					$etinfo = array('tnames'=>array($template_name));
					//Subject line
					if($email_viewed_subject) $etinfo['subjects']=array($tid=>$email_viewed_subject);
					$etinfo = json_encode($etinfo);
				}
				$update['intr_info']=$etinfo;
			}
			$this->crm->save_interaction_date($update,$intrdata);
		} else {
			$update = array(
				'intr_user'=>$user_id,
				'intr_cat'=>$c,
				'intr_sect'=>$s,
				'intr_opt'=>$opt,
				'intr_otype'=>'I',
				'intr_sno'=>$intr_sno,
				'intr_rctype'=>'C',
				'intr_recid'=>$contact_id,
				'intr_task'=>$tid,
				'intr_date'=>$idate);
			//Insert Email template info
			if($template_name) {
				$etinfo = array('tnames'=>array($template_name));
				//Subject line
				if($email_viewed_subject) $etinfo['subjects']=array($tid=>$email_viewed_subject);
				$etinfo = json_encode($etinfo);
				$update['intr_info']=$etinfo;
			}	
			$this->crm->save_interaction_date($update);
		}
		//Save notification
		$update = array(
			'userid'=>$user_id,
			'info'=>'<a href="'.base_url("crm/contacts/view/$contact_id").'">'.ucfirst($contact[user_first].' '.$contact[user_last]).'</a> opened email "'.trim($email_viewed_subject).'"',
			'datetime'=>date("Y-m-d H:i:s"));
		$this->crm->save_email_notify($update);
		//echo "<pre>IU";print_r($update);echo "</pre>";
		//echo "<pre>IU W";print_r($intrdata);echo "</pre>";		
	}
	//When links clicked on email then add quality points to User interactions
	public function eclick($rkey)
	{
		$url = "https://www.salesscripter.com";
		$stop=0;
		if(empty($rkey)) $stop=1;
		else if(strlen($rkey)<10) $stop=1;
		$contact_id = $this->uri->segment(4);
		if(empty($contact_id)) $stop=1;
		else if(strlen($contact_id)<11) $stop=1;
		$redurl = $this->uri->segment(5);
		if(empty($redurl)) $stop=1;
		else {
			$redurl = str_replace("-","=",$redurl);
			$redurl = base64_decode($redurl);
		}
		if($stop) {
			header("location: $url");
			exit;
		}
		$url = $redurl;
		$user_id = (int)substr($rkey,6,strlen($rkey)-9);
		$contact_id = (int)substr($contact_id,6,strlen($contact_id)-10);
		if(!$user_id || !$contact_id) {
			header("location: $url");
			exit;
		}
		$this->load->model('crm_model', 'crm');
		//User
		$exuser=$this->crm->get_CurrentUser($user_id);
		if(!$exuser) {
			header("location: $url");
			exit;
		}
		//echo "<pre>";print_r($exuser);echo "</pre>".$contact_id;
		//Contact
		$contact=$this->crm->get_contact($contact_id,array($user_id));
		if(!$contact) {
			header("location: $url");
			exit;
		}
		//echo "<pre>";print_r($contact);echo "</pre>";
		//echo $url;exit;
		$this->load->model('home_model', 'home');
		//Time parameter for subject line
		$etime = $this->uri->segment(6);
		//Timezone
		$tzone="America/Chicago";
		$where = array();
		$where['user_id'] = $user_id;
		$where['field_type'] = 'timezone';
		$user_info = $this->home->getUserData($where);
		if($user_info) {
			$user_info = $user_info[0];
			if(isset($user_info->value)) $tzone=$user_info->value;
		}
		date_default_timezone_set($tzone);
		//Qaulity Points
		$this->load->helper('scripts');		
		//$categories = crm_options();
		$categories = crm_introptions();
		$c=2;
		$s=1;
		$opt=7;
		$sec_val = $categories['category'][$c][$s];
		$sec_opt = $sec_val['options'];
		$oname = $sec_opt[$opt]['name'];
		$points = $sec_opt[$opt]['points'];
		$pursuit = $sec_opt[$opt]['pursuit'];		
		$idate = date("Y-m-d");
		//Create completed task : Log a Call
		$taskdata = array(
					'task_subject'=>'Link in email clicked',
					'task_name'=>'<a target="_blank" href="'.$url.'">'.$url.'</a>',
					'task_priority'=>'Normal',
					'task_status'=>'Completed',
					'task_duedate'=>$idate,
					'task_related'=>'C',
					'task_relatedto'=>$contact_id,
					'share_user_id'=>$user_id,
					'userid'=>$user_id,
					'task_created'=>$idate." 00:00:00",
					'task_modified'=>$idate." 00:00:00",
					'task_info'=>'The link clicked was <a href="'.$url.'" target="_blank">'.$url.'</a>'
					//'task_info'=>'They clicked a link in the email'
					);
		$tid = $this->crm->save_task($taskdata,0);
		//Interaction Points
		$where = array('userid'=>$user_id,'contact'=>$contact_id,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
		$cont_points = $this->crm->get_points($where);
		if($cont_points) {
			$update_data = array(
					'userid'=>$user_id,
					'contact'=>$contact_id,
					'cat'=>$c,
					'pdate'=>$idate,
					'rctype'=>'C'
					);
			$points_data = array(
					'intpoints'=>$cont_points['intpoints']+$points,
					'purpoints'=>$cont_points['purpoints']+$pursuit,
					'taskid'=>$tid
					);
			$this->crm->save_points($points_data,$update_data);
		} else {
			$points_data = array(
					'userid'=>$user_id,
					'contact'=>$contact_id,
					'rctype'=>'C',
					'pdate'=>$idate,
					'intpoints'=>$points,
					'purpoints'=>$pursuit,
					'cat'=>$c,
					'taskid'=>$tid
					);
			$this->crm->save_points($points_data);
		}
		//echo "<pre>IP";print_r($points_data);echo "</pre>";
		//echo "<pre>IPW";print_r($update_data);echo "</pre>";
		//email subject from db
		$email_viewed_subject = '';
		$where = array();
		$where['user_id'] = $user_id;
		$where['field_type'] = 'Email-Subjects';
		$esuser_info = $this->home->getUserData($where);
		if($esuser_info) {
			if($esuser_info[0]->value) {
				$email_subjects = $esuser_info[0]->value;
				$email_subjects = json_decode($email_subjects);
				$etime = "$etime";
				if(isset($email_subjects->$etime)) {
					$email_viewed_subject = $email_subjects->$etime;
				}
			}
		}
		//Interaction Usage
		$intr_sno=$c."-".$s."-".$opt;
		//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$user_id);
		$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$contact_id);
		$intrdata = $this->crm->check_interaction_date($where,$user_id);
		if($intrdata) {
			$update = array('intr_count'=>$intrdata['intr_count']+1);
			if($url) {
				if($intrdata['intr_info']) {
					$etinfo = json_decode($intrdata['intr_info']);
					if(isset($etinfo->elinks)) {
						$etinfo->elinks[]=$url;
					} else {
						$etinfo->elinks=array($url);
					}
					$etinfo->elinks = array_unique($etinfo->elinks);
					//Subject line
					if($email_viewed_subject) {
						if(isset($etinfo->subjects)) {
							$etinfo->subjects->$tid=$email_viewed_subject;
						} else {
							$etinfo->subjects=array($tid=>$email_viewed_subject);
						}	
					}
					$etinfo = json_encode($etinfo);
				} else {
					$etinfo = array('elinks'=>array($url));
					//Subject line
					if($email_viewed_subject) $etinfo['subjects']=array($tid=>$email_viewed_subject);
					$etinfo = json_encode($etinfo);
				}
				$update['intr_info']=$etinfo;
			}
			$this->crm->save_interaction_date($update,$intrdata);
		} else {
			$update = array(
				'intr_user'=>$user_id,
				'intr_cat'=>$c,
				'intr_sect'=>$s,
				'intr_opt'=>$opt,
				'intr_otype'=>'I',
				'intr_sno'=>$intr_sno,
				'intr_rctype'=>'C',
				'intr_recid'=>$contact_id,
				'intr_task'=>$tid,
				'intr_date'=>$idate);
			//Insert Email link info
			if($url) {
				$etinfo = array('elinks'=>array($url));
				//Subject line
				if($email_viewed_subject) $etinfo['subjects']=array($tid=>$email_viewed_subject);
				$etinfo = json_encode($etinfo);
				$update['intr_info']=$etinfo;
			}	
			$this->crm->save_interaction_date($update);
		}
		//Save notification
		$update = array(
			'userid'=>$user_id,
			'info'=>'<a href="'.base_url("crm/contacts/view/$contact_id").'">'.ucfirst($contact[user_first].' '.$contact[user_last]).'</a> clicked the link <a target="_blank" href="'.$url.'">'.$url.'</a>',
			'datetime'=>date("Y-m-d H:i:s"));
		$this->crm->save_email_notify($update);
		//echo "<pre>IU";print_r($update);echo "</pre>";
		header("location: $url");
		exit;
	}
	
	//When links clicked on email then add quality points to User interactions
	public function euscribe($rkey)
	{
		$this->output->nocache();
		date_default_timezone_set('UTC');
		$url = "https://www.salesscripter.com";
		$stop=0;
		if(empty($rkey)) $stop=1;
		else if(strlen($rkey)<10) $stop=1;
		$contact_id = $this->uri->segment(4);
		if(empty($contact_id)) $stop=1;
		else if(strlen($contact_id)<11) $stop=1;		
		if($stop) {
			header("location: $url");
			exit;
		}
		$url = $redurl;
		$user_id = (int)substr($rkey,6,strlen($rkey)-9);
		$contact_id = (int)substr($contact_id,6,strlen($contact_id)-10);
		if(!$user_id || !$contact_id) {
			header("location: $url");
			exit;
		}
		$this->load->model('crm_model', 'crm');
		//User
		$exuser=$this->crm->get_CurrentUser($user_id);
		if(!$exuser) {
			header("location: $url");
			exit;
		}
		//Contact
		$contact=$this->crm->get_contact($contact_id,array($user_id));
		if(!$contact) {
			header("location: $url");
			exit;
		}
		//check for unsubscribed
		if($contact['unsubscribed']=="1") {
			echo '<h2>Already unsubscribed.</h2>';
			exit;
		}
		$sdate = date("Y-m-d H:i:00");
		$this->load->model('home_model', 'home');
		//Timezone
		$tzone="America/Chicago";
		$where = array();
		$where['user_id'] = $user_id;
		$where['field_type'] = 'timezone';
		$user_info = $this->home->getUserData($where);
		if($user_info) {
			$user_info = $user_info[0];
			if(isset($user_info->value)) $tzone=$user_info->value;
		}
		date_default_timezone_set($tzone);
		//Unsubscribe contact
		$record=array('unsubscribed'=>'1');
		$cid = $this->crm->save_contact($record,$contact_id);
		//Delete future scheduled emails
		$where = array();
		$where['userid'] = $user_id;
		$where['contact'] = $contact_id;
		$where['sdate'] = $sdate;
		$this->crm->delete_schedule_email(0,$where);
		
		//Qaulity Points
		$this->load->helper('scripts');		
		//$categories = crm_options();
		$categories = crm_introptions();
		$c=2;
		$s=1;
		$opt=6;
		$sec_val = $categories['category'][$c][$s];
		$sec_opt = $sec_val['options'];
		$oname = $sec_opt[$opt]['name'];
		$points = $sec_opt[$opt]['points'];
		$pursuit = $sec_opt[$opt]['pursuit'];		
		$idate = date("Y-m-d");
		//Create completed task : Log a Call
		$taskdata = array(
					'task_subject'=>'Unsubscribed',
					'task_priority'=>'Normal',
					'task_status'=>'Completed',
					'task_duedate'=>$idate,
					'task_related'=>'C',
					'task_relatedto'=>$contact_id,
					'share_user_id'=>$user_id,
					'userid'=>$user_id,
					'task_created'=>$idate." 00:00:00",
					'task_modified'=>$idate." 00:00:00",
					'task_info'=>'Contact unsubscribed from receiving emails'
					);
		$tid = $this->crm->save_task($taskdata,0);
		//Interaction Points
		$where = array('userid'=>$user_id,'contact'=>$contact_id,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
		$cont_points = $this->crm->get_points($where);
		if($cont_points) {
			$update_data = array(
					'userid'=>$user_id,
					'contact'=>$contact_id,
					'cat'=>$c,
					'pdate'=>$idate,
					'rctype'=>'C'
					);
			$points_data = array(
					'intpoints'=>$cont_points['intpoints']+$points,
					'purpoints'=>$cont_points['purpoints']+$pursuit,
					'taskid'=>$tid
					);
			$this->crm->save_points($points_data,$update_data);
		} else {
			$points_data = array(
					'userid'=>$user_id,
					'contact'=>$contact_id,
					'rctype'=>'C',
					'pdate'=>$idate,
					'intpoints'=>$points,
					'purpoints'=>$pursuit,
					'cat'=>$c,
					'taskid'=>$tid
					);
			$this->crm->save_points($points_data);
		}
		//Interaction Usage
		$intr_sno=$c."-".$s."-".$opt;
		//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$user_id);
		$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$contact_id);
		$intrdata = $this->crm->check_interaction_date($where,$user_id);
		if($intrdata) {
			$update = array('intr_count'=>$intrdata['intr_count']+1);
			$this->crm->save_interaction_date($update,$intrdata);
		} else {
			$update = array(
				'intr_user'=>$user_id,
				'intr_cat'=>$c,
				'intr_sect'=>$s,
				'intr_opt'=>$opt,
				'intr_otype'=>'I',
				'intr_sno'=>$intr_sno,
				'intr_rctype'=>'C',
				'intr_recid'=>$contact_id,
				'intr_task'=>$tid,
				'intr_date'=>$idate);
			$this->crm->save_interaction_date($update);
		}
		//Save notification
		$update = array(
			'userid'=>$user_id,
			'info'=>'<a href="'.base_url("crm/contacts/view/$contact_id").'">'.ucfirst($contact[user_first].' '.$contact[user_last])."</a> unsubscribed",
			'datetime'=>date("Y-m-d H:i:s"));
		$this->crm->save_email_notify($update);
		echo '<h2>Unsubscribed successfully.</h2>';
		exit;
	}


	//Forward non sent old scheduled emails to Next 10mins email schedule
	public function ssforwardmails() {
		$this->output->nocache();
		date_default_timezone_set('UTC');
		$this->load->model('crm_model', 'crm');
		$dt1 = date("Y-m-d H:i:00");
		//$dt1 = "2018-03-10 19:15:00";
		$dt2 = date("Y-m-d H:i:00",strtotime($dt1)-10*60);
		$dt3 = date("Y-m-d H:i:00",strtotime($dt1)+5*60);
		//echo " $dt1 $dt2 $dt3 "; exit;
		$schemails=$this->crm->get_scheduled_emails_bytime($dt2,$dt1);
		//print_r($schemails);
		if(($schemails && $schemails['smcount'])) {
			$edata = array('sch_date'=>$dt3);
			$dt4 = "(sch_date>='$dt2' and sch_date<'$dt1')";
			$this->crm->save_scheduled_email($edata,0,$dt4);
			echo $schemails['smcount']." records shifted to ".$dt3;
		}
	}
	
	//Sending scheduled emails cron
	public function ssecron() {
		$this->output->nocache();
		date_default_timezone_set('UTC');
		$this->load->model('crm_model', 'crm');		
		$schemails=$this->crm->get_scheduled_emails();
		if(!$schemails) {exit;}
		$this->load->model('home_model', 'home');
		$this->load->helper('scripts');
		//require_once APPPATH."/third_party/mail/class.phpmailer.php";
		$user_id = 0;
		$smtp = array();
		$prev_sent_mail='';
		foreach($schemails as $scemail) {
			if($user_id<>$scemail->sch_user) {
				//get user smtp data
				$where = array();
				$where['user_id'] = $scemail->sch_user;
				$where['field_type'] = 'smtp';
				$user_info = $this->home->getUserData($where);
				if($user_info) $user_info = $user_info[0];			
				$smtp = array();
				if(isset($user_info->value)) {
					$smtp=unserialize($user_info->value);
					/*$smtp['username']=base64_decode($smtp['username']);
					$smtp['password']=base64_decode($smtp['password']);*/
				}				
			}
			$user_id = $scemail->userid;
			$appuser = $this->home->get_single_user_info($user_id);	
			$email_count = $appuser->email_count;
			if(!$smtp) {
				$data = array("sch_status"=>"Email settings not configured");
				$this->crm->save_scheduled_email($data,$scemail->sch_id);
				continue;
			}
			if($email_count>10000) {
				$data = array("sch_status"=>"Your Month Limit Exists");
				$this->crm->save_scheduled_email($data,$scemail->sch_id);
				continue;
			}
			$curSubject = str_replace(" ","",$scemail->sch_subject);
			$curSubject = strtolower($curSubject);
			$current_sending_mail=$scemail->sch_contact.'-'.$curSubject;
			if($current_sending_mail==$prev_sent_mail) continue;
			$prev_sent_mail=$current_sending_mail;
			//Mail 
			$email_content = $scemail->sch_content;
			
			
			
			
			$ufname = $appuser->first_name;
			$ulname = $appuser->last_name;
			$uphone = $appuser->phone;
			
			
			$cid =  $scemail->sch_contact;
			$acid = $scemail->account_id;
			
			
			$address_List = $this->crm->get_address($cid,'amail','C');
			$street = $address_List['street'];
			$city = $address_List['city'];
			$state = $address_List['state'];
			$zipcode = $address_List['zipcode'];
			$country = $address_List['country'];
			
			
			$ced_esign = $aMember['email_signature'];
			$where = array();
			$where['user_id'] = $user_id;
			$where['field_type'] = 'smtp';
			$user_info = $this->home->getUserData($where);
			if($user_info && isset($user_info[0]))
			{
				$k = unserialize($user_info[0]->value);
				if(isset($k['email_signature']) && $k['email_signature'])
				{
					$ced_esign =  $k['email_signature'];
				}
			}
			$email_signature = $ced_esign;
			
			$arecord = $this->crm->get_account($acid,'');			
			$acname = $arecord['account_name'];
			
			$email_content = str_replace("{contact first name}",$scemail->user_first,$email_content);							
			$email_content = str_replace("{contact last name}",$scemail->user_last,$email_content);							
			$email_content = str_replace("{user first name}",$ufname,$email_content);
			$email_content = str_replace("{user last name}",$ulname,$email_content);
			$email_content = str_replace("{account name}",$acname,$email_content);
			$email_content = str_replace("{contact title}",$scemail->user_title,$email_content);
			$email_content = str_replace("{contact phone}",$scemail->phone,$email_content);
			$email_content = str_replace("{user phone}",$uphone,$email_content);
			$email_content = str_replace("{contact website}",$scemail->website,$email_content);			
			$email_content = str_replace("[Prospect First Name]",$scemail->user_first,$email_content);
			$email_content = str_replace("{mailing street}",$street,$email_content);
			$email_content = str_replace("{mailing city}",$city,$email_content);
			$email_content = str_replace("{mailing state}",$state,$email_content);
			$email_content = str_replace("{mailing zip}",$zipcode,$email_content);
			$email_content = str_replace("{mailing country}",$country,$email_content);
			$email_content = str_replace("{email signature}",$email_signature,$email_content);	
			
			$task_email_content = $email_content;
			$track_data = array();
			$track_data['content'] = $email_content;
			$track_data['subject'] = $scemail->sch_subject;
			$track_data['etime'] = time();
			$track_data['userid'] = $scemail->sch_user;
			$track_data['contactid'] = $scemail->sch_contact;
			//Email Template
			$template_name=$scemail->sch_etname;
			$track_data['template_name'] = $template_name;
			$email_content = format_email_tracks($track_data);
			
			/*$mail = new PHPMailer(true); 
			$mail->IsMail();
			$mail->IsHTML(true);*/

			/*
			$mail->isSMTP();
			//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
			$mail->SMTPAuth   = true;			
			if($smtp['crypto']) $mail->SMTPSecure = $smtp['crypto'];
			$mail->Host       = $smtp['server'];
			$mail->Port       = $smtp['port'];
			$mail->Username   = $smtp['username'];
			$mail->Password   = $smtp['password'];			
			*/
			
			try {
				$toname = $scemail->user_first;
			  	if($scemail->user_last) $toname .= " ".$scemail->user_last;

			  /*$mail->AddAddress($scemail->email, $toname);
			  $mail->SetFrom($smtp['fromemail'], $smtp['fromname']);
			  $mail->Subject = $scemail->sch_subject;
			  $mail->MsgHTML($email_content);
			  $mail->Send();*/

			  //Send grid
				$eparams = array(
					'toname'=>$toname,
					'tomail'=>$scemail->email,
					'fromname'=>$smtp['fromname'],
					'frommail'=>$smtp['fromemail'],
					'subject'=>$scemail->sch_subject,
					'body'=>$email_content
				);
				$emailSent = sendgrid_mail($eparams);
				if($emailSent == false) {					
					$data = array("sch_status"=>"Unable to send mail");
					$this->crm->save_scheduled_email($data,$scemail->sch_id);
					continue;
				}
				
				/**/
				
				$esuemail_count = $this->home->get_single_user_info($user_id);
				$ecount = $esuemail_count->email_count+1;
				$this->home->update_email_count($user_id,$ecount);

				//Schedule Follow up Task
				if($scemail->task_info) {
					$idate = date("Y-m-d");	
					$sctasks = json_decode($scemail->task_info);
					foreach($sctasks as $stask) {
						$taskdata = array(
									'task_subject'=>$stask->subject,
									'task_priority'=>'Normal',
									'task_status'=>'In Progress',
									'task_related'=>'C',
									'task_relatedto'=>$scemail->sch_contact,
									'share_user_id'=>$scemail->sch_user,
									'userid'=>$scemail->sch_user,  
									'task_created'=>$idate." 00:00:00",
									'task_modified'=>$idate." 00:00:00",
									'task_duedate'=>$stask->duedate,
									'task_info'=>$stask->info
									);
						$tid = $this->crm->save_task($taskdata,0);
					}
				}

				//Save sent email subjects
			    $email_subjects = array();
				$where = array();
				$where['user_id'] = $scemail->sch_user;
				$where['field_type'] = 'Email-Subjects';
				$esuser_info = $this->home->getUserData($where);
				if($esuser_info) {					
					if($esuser_info[0]->value) {
						$email_subjects = $esuser_info[0]->value;
						$email_subjects = json_decode($email_subjects);
						$email_subjects = (array)$email_subjects;
					}
				}
				$email_subjects["".$track_data['etime'].""] = $scemail->sch_subject;
				$email_subjects = json_encode($email_subjects);
				$edata = array();
				$edata['value'] = $email_subjects;
				if($esuser_info) $this->home->saveUserData($edata,$where);
				else {
					$edata['user_id'] = $scemail->sch_user;
					$edata['field_type'] = 'Email-Subjects';
					$this->home->saveUserData($edata);
				}
			  //Save an interaction Log
			  //$categories = crm_options();
			  $categories = crm_introptions();
				$c=2;
				$s=1;
				$opt=1;
				$sec_val = $categories['category'][$c][$s];
				$sec_opt = $sec_val['options'];
				$points = $sec_opt[$opt]['points'];
				$pursuit = $sec_opt[$opt]['pursuit'];
				$iname = $sec_opt[$opt]['name'];
			    $idate = date("Y-m-d");				
				//Create completed task : Log a Call
				//$task_email_content=str_replace("\n","",$task_email_content);
				$taskdata = array(
							'task_subject'=>"Email Sent",
							'task_name'=>$scemail->sch_subject,//$template_name,
							'task_priority'=>'Normal',
							'task_status'=>'Completed',
							'task_duedate'=>$idate,
							'task_related'=>'C',
							'task_relatedto'=>$scemail->sch_contact,
							'share_user_id'=>$scemail->sch_user,  
							'userid'=>$scemail->sch_user,  
							'task_created'=>$idate." 00:00:00",
							'task_modified'=>$idate." 00:00:00",
							'task_info'=>$task_email_content
							);
				$tid = $this->crm->save_task($taskdata,0);
				
				//check points and save
				$where = array('contact'=>$scemail->sch_contact,'userid'=>$scemail->sch_user,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
				$cont_points = $this->crm->get_points($where);
				//print_r($cont_points);
				if($cont_points) {
					$update_data = array(
							'contact'=>$scemail->sch_contact,
							'userid'=>$scemail->sch_user,
							'cat'=>$c,
							'pdate'=>$idate,
							'rctype'=>'C'
							);
					$points_data = array(
							'intpoints'=>$cont_points['intpoints']+$points,
							'purpoints'=>$cont_points['purpoints']+$pursuit,
							'taskid'=>$tid
							);
					$this->crm->save_points($points_data,$update_data);
				} else {
					$points_data = array(
							'contact'=>$scemail->sch_contact,
							'userid'=>$scemail->sch_user,
							'rctype'=>'C',
							'pdate'=>$idate,
							'intpoints'=>$points,
							'purpoints'=>$pursuit,
							'taskid'=>$tid,
							'cat'=>$c
							);
					$this->crm->save_points($points_data);
				}
				//Interaction Usage
				//Subject line
				$subjectLine = $scemail->sch_subject;
				$intr_sno=$c."-".$s."-".$opt;
				//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$scemail->sch_user);
				$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$scemail->sch_contact);
				$intrdata = $this->crm->check_interaction_date($where,$scemail->sch_user);
				if($intrdata) {
					$update = array('intr_count'=>$intrdata['intr_count']+1);
					//update email template info
					if($template_name) {
						if($intrdata['intr_info']) {
							$etinfo = json_decode($intrdata['intr_info']);
							if(isset($etinfo->tnames)) {
								$etinfo->tnames[]=$template_name;
							} else {
								$etinfo->tnames=array($template_name);
							}
							//Subject line							
							if(isset($etinfo->subjects)) {
								$etinfo->subjects->$tid=$subjectLine;
							} else {
								$etinfo->subjects=array($tid=>$subjectLine);
							}
							$etinfo->tnames = array_unique($etinfo->tnames);
							$etinfo = json_encode($etinfo);
						} else {
							$etinfo = array('tnames'=>array($template_name));
							//Subject line
							$etinfo['subjects']=array($tid=>$subjectLine);
							$etinfo = json_encode($etinfo);
						}
						$update['intr_info']=$etinfo;
					}
					$this->crm->save_interaction_date($update,$intrdata);
				} else {
					$update = array(
						'intr_cat'=>$c,
						'intr_sect'=>$s,
						'intr_opt'=>$opt,
						'intr_otype'=>'I',
						'intr_sno'=>$intr_sno,
						'intr_rctype'=>'C',
						'intr_recid'=>$scemail->sch_contact,
						'intr_task'=>$tid,
						'intr_user'=>$scemail->sch_user,
						'intr_date'=>$idate);
					//Insert Email template info
					if($template_name) {
						$etinfo = array('tnames'=>array($template_name));
						//Subject line
						$etinfo['subjects']=array($tid=>$subjectLine);
						$etinfo = json_encode($etinfo);
						$update['intr_info']=$etinfo;
					}	
					$this->crm->save_interaction_date($update);
				}
			  //Update status	
			  //$data = array("sch_status"=>"1");
			  //$this->crm->save_scheduled_email($data,$scemail->sch_id);
			  //detete schedule
			  	$where = array();
				$where['userid'] = $scemail->sch_user;
				$where['scid'] = $scemail->sch_id;
				$this->crm->delete_schedule_email(0,$where);
			/*} catch (phpmailerException $e) {
			  //echo "Unable to send mail, please check below error \n";
			  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
			  $data = array("sch_status"=>$e->errorMessage());
			  $this->crm->save_scheduled_email($data,$scemail->sch_id);*/
			} catch (Exception $e) {
			  //echo "Unable to send mail, please check below error \n";	
			  //echo $e->getMessage(); //Boring error messages from anything else!
			  $data = array("sch_status"=>$e->errorMessage());
			  $this->crm->save_scheduled_email($data,$scemail->sch_id);
			}  
		}
		echo "DONE";
	}
//--------------------------------------------------------------
}
/* End of file api.php */
/* Location: ./application/controllers/api.php */