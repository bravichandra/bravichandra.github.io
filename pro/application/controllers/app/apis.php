<?php  defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL);
/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';
class Apis extends REST_Controller
{
	function __construct()
    {
        // Construct the parent class
       parent::__construct();
	   $this->output->nocache();
	   //Load Helpers 
        $this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->library('session');
		$this->load->library('form_validation');
		//$this->load->helper(array('form', 'url'));
		$this->load->model('api_model', 'api');
		$this->load->model('home_model', 'home');
        $this->load->model('crm_model', 'crm');
        $this->load->model('applicant_model', 'applicant');
		$this->load->model('campaign_model', 'campaign');
		
    }
	
	public function check_user()
	{
		$_header = getallheaders();
		$where = array('value'=>$_header['Activekey'],'field_type'=>'Activekey');
		$user_info = $this->home->getUserData($where);
		//print_r($user_info);
		if(!$user_info) {
			$this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(array('status' => FALSE,'message' =>'Session expired.','expired' => TRUE)));
		}
		else{
			//echo $user_info[0]->user_id ;
			$info =$this->home->get_single_user_info($user_info[0]->user_id );
			 $info->user_id = $user_info[0]->user_id;
			 $this->_user = $info;
		}
	}
	
	function login_post(){
		$username=$this->post('username');
		$password=$this->post('password');
		if(empty($username)){
			//$message= array('username'=>'Required');
			$message="username required";
			$this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(array('status' => FALSE,'message' => $message)));
		}
		else if(empty($password)){
			//$message = array('password'=>'Required');
			$message="password required";
			$this->output
            ->set_content_type('application/json')
            ->set_status_header(400)
            ->set_output(json_encode(array('status' => FALSE ,'message' => $message)));
		}
		 else{
		 	require_once '/home/mhalper2000/public_html/members/bootstrap.php';
		 	Am_Di::getInstance()->auth->logout();
			//$result = Am_Di::getInstance()->auth->login($username, $password,$_SERVER['REMOTE_ADDR']);
			$result = Am_Di::getInstance()->auth->login(new Am_Auth_Adapter_Password($username, $password, Am_Di::getInstance()->userTable), $_SERVER['REMOTE_ADDR']);
			if($result->isValid()) {
				$subscribed= $this->Subscribed($username,$password);
				$user_id=$this->home->get_user_by_username($username);
					$log_user_key = substr(get_random_alpha_string(8),0,8).$user_id.substr(get_random_alpha_string(4),0,4);
					$logkey=md5($log_user_key);
					$where = array('user_id'=>$user_id,'field_type'=>'Activekey');
					$info=$this->home->getUserData($where);
					$idata= array('user_id'=>$user_id,'field_type'=>'Activekey','value'=>$logkey);
					$udata= array('value'=>$logkey);
					if(!$info) $this->home->saveUserData($idata); 
					else $this->home->saveUserData($udata,$where); 
					$this->output->set_content_type('application/json')
							 ->set_status_header(200)
							 ->set_output(json_encode(array('status' => TRUE ,'message' => 'Suceesfully Login','Activekey'=>$logkey,'subscriptions'=>$subscribed)));				
				
				if($subscribed!=0){
					
				}/*
				else{
					$this->output
					->set_content_type('application/json')
					->set_status_header(400)
					->set_output(json_encode(array('status' => FALSE,'message' => 'No Subscriptions')));
				}*/
				
			} else {
				$this->output
				->set_content_type('application/json')
				->set_status_header(400)
				->set_output(json_encode(array('status' => FALSE,'message' => 'Invalid Login Details')));

		 }
		 
		}
	}
	function Subscribed($username,$password){
	
		$amember_api = "e9AHVS8lMlc4xdiHeKeP";		
		$act_url = 'https://salesscripter.com/members/api/check-access/by-login-pass?_key='.$amember_api.'&login='.$username.'&pass='.$password;
		$ch = curl_init($act_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		//echo $output."<pre>";print_r($info);
		if($output && $info['http_code']==200) {
			$amemb = json_decode($output);
			if(!$amemb->ok) {
				return 0;
			}
		   else if(isset($amemb->subscriptions)) {
				//return 1;
				return $amemb->subscriptions;
			}
		}
	}
	
	function dropdown_get(){
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
		$data['drop_campaign'] = $this->api->get_drop_campaign();
		$data['drop_company'] = $this->api->get_drop_company();
		$data['drop_name'] = $this->api->get_drop_name_profiles();
		$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE,  'campaign'=> $data['drop_campaign'], 'company' => $data['drop_company'] , 'name' =>$data['drop_name'] )));
		}
	}
	//sales script
	function salesListing_get()
	{
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
			$newactive_com = $this->get('company');
			$newactivedrop_id =$this->get('name');
			$newactive_cam =$this->get('compaign');
		
			if($newactivedrop_id!=''){
					$this->campaign->incativeAllcredibility();
					$this->campaign->activedropname($newactivedrop_id);
				}
				
			if($newactive_cam != ''){
					$this->campaign->incativeAllCampaign();
					$this->campaign->activeSingleCampaign($newactive_cam);
					//$this->session->set_userdata('ss_session_id',$newactive_cam);
				}
				
			if($newactive_com != ''){
					$this->campaign->inAnctiveallcompany();
					$this->campaign->activateCompany($newactive_com);
				}
				$block="Sales Scripts";
				$alltemplates = $this->api->get_alltemplates($block);
				//print_r($alltemplates);
				$alltemplate=array();
				foreach($alltemplates as $alltemp){
					if($alltemp->temp_id=='9' || $alltemp->temp_id=='10' || $alltemp->temp_id=='11'  || $alltemp->temp_id=='72')
					$n="0"; else $n="1";
					$alltemplate[]= array("temp_id"=>$alltemp->temp_id,"temp_title"=>$alltemp->temp_title,"temp_sort"=>$alltemp->temp_sort,"temp_slug"=>$alltemp->temp_slug,"interactive"=>$n);
				}
				//print_r($alltemplate); exit;
				
				$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE, 'download_link'=>'https://salesscripter.com/pro/output/', 'list'=> $alltemplate)));
		}
	}
	
	
	//email
	function prospecting_emails_get()
	{
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
			$newactive_com = $this->get('company');
			$newactivedrop_id =$this->get('name');
			$newactive_cam =$this->get('compaign');
		
			if($newactivedrop_id!=''){
					$this->campaign->incativeAllcredibility();
					$this->campaign->activedropname($newactivedrop_id);
				}
				
			if($newactive_cam != ''){
					$this->campaign->incativeAllCampaign();
					$this->campaign->activeSingleCampaign($newactive_cam);
					//$this->session->set_userdata('ss_session_id',$newactive_cam);
				}
				
			if($newactive_com != ''){
					$this->campaign->inAnctiveallcompany();
					$this->campaign->activateCompany($newactive_com);
				}
				$block="Emails and Letters";
				$alltemplates = $this->api->get_alltemplates($block);	
				$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE, 'download_link'=>'https://salesscripter.com/pro/output/', 'list'=> $alltemplates)));
		}
	}
	
	
	//voice mail
	function voicemails_get()
	{
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
			$newactive_com = $this->get('company');
			$newactivedrop_id =$this->get('name');
			$newactive_cam =$this->get('compaign');
		
			if($newactivedrop_id!=''){
					$this->campaign->incativeAllcredibility();
					$this->campaign->activedropname($newactivedrop_id);
				}
				
			if($newactive_cam != ''){
					$this->campaign->incativeAllCampaign();
					$this->campaign->activeSingleCampaign($newactive_cam);
					//$this->session->set_userdata('ss_session_id',$newactive_cam);
				}
				
			if($newactive_com != ''){
					$this->campaign->inAnctiveallcompany();
					$this->campaign->activateCompany($newactive_com);
				}
				$block="Voicemail Scripts";
				$alltemplates = $this->api->get_alltemplates($block);	
				$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE, 'download_link'=>'https://salesscripter.com/pro/output/', 'list'=> $alltemplates)));
		}
	}
	
	//key questions mail
	function key_question_get()
	{
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
			$newactive_com = $this->get('company');
			$newactivedrop_id =$this->get('name');
			$newactive_cam =$this->get('compaign');
		
			if($newactivedrop_id!=''){
					$this->campaign->incativeAllcredibility();
					$this->campaign->activedropname($newactivedrop_id);
				}
				
			if($newactive_cam != ''){
					$this->campaign->incativeAllCampaign();
					$this->campaign->activeSingleCampaign($newactive_cam);
					//$this->session->set_userdata('ss_session_id',$newactive_cam);
				}
				
			if($newactive_com != ''){
					$this->campaign->inAnctiveallcompany();
					$this->campaign->activateCompany($newactive_com);
				}
				$block="Key Questions";
				$alltemplates = $this->api->get_alltemplates($block);	
				$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE, 'download_link'=>'https://salesscripter.com/pro/output/', 'list'=> $alltemplates)));
		}
	}
	
	//marketing
	function marketing_get()
	{
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
			$newactive_com = $this->get('company');
			$newactivedrop_id =$this->get('name');
			$newactive_cam =$this->get('compaign');
			$subscription =$this->get('subscription');
		
			if($newactivedrop_id!=''){
					$this->campaign->incativeAllcredibility();
					$this->campaign->activedropname($newactivedrop_id);
				}
				
			if($newactive_cam != ''){
					$this->campaign->incativeAllCampaign();
					$this->campaign->activeSingleCampaign($newactive_cam);
					//$this->session->set_userdata('ss_session_id',$newactive_cam);
				}
				
			if($newactive_com != ''){
					$this->campaign->inAnctiveallcompany();
					$this->campaign->activateCompany($newactive_com);
				}
				//$block="Key Questions";
				//$alltemplates = $this->api->get_alltemplates($block);	
				$sub=array('6','2','9','10','14','15','18','28','5','3','29','30','31');
				if (in_array($subscription, $sub)){
					$option1="View";
					$option2="Download";
					$link="";
				}
				else {
					$option1="Only Available in Pro";
					$option2="Upgrade Here";
					$link="https://salesscripter.com/members/signup";
				}
				$alltemplates[0]=array('temp_title'=>'Product Matrix','temp_slug'=>'product-matrix','option1'=>'View','option2'=>'Download','Link'=>'');
				$alltemplates[1]=array('temp_title'=>'Email Marketing Topics','temp_slug'=>'email-marketing-topics','option1'=>$option1,'option2'=>$option2,'Link'=>$link);
				$alltemplates[2]=array('temp_title'=>'Content Marketing Topics','temp_slug'=>'content-marketing-topics','option1'=>$option1,'option2'=>$option2,'Link'=>$link);
				$alltemplates[3]=array('temp_title'=>'Sales Presentation','temp_slug'=>'sales-presentation','option1'=>$option1,'option2'=>$option2,'Link'=>$link);
				$alltemplates[4]=array('temp_title'=>'Value Statements','temp_slug'=>'elevator-pitch','option1'=>$option1,'option2'=>$option2,'Link'=>$link);
				$alltemplates[5]=array('temp_title'=>'Building Interest Silver Bullets','temp_slug'=>'building-interest','option1'=>$option1,'option2'=>$option2,'Link'=>$link);
				$alltemplates[6]=array('temp_title'=>'Name Drop Statement','temp_slug'=>'name-drop-statments','option1'=>$option1,'option2'=>$option2,'Link'=>$link);
				$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE, 'download_link'=>'https://salesscripter.com/pro/output/', 'list'=> $alltemplates)));
		}
	}
	
	function salesView_get(){
		$this->check_user();
		$_SESSION['ss_user_id'] = $this->_user->user_id;
		if($_SESSION['ss_user_id']){
			$camp=$this->get('compaign');
			if($camp!="") $this->_data['campaign_info']= $this->campaign->getCampaignData($camp);
			$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'value-statement-intro','title'=>'Value Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Company and Product Info'),

					  6=>array('name'=>'close','title'=>'Close'));

			$lastid = 6;
			//include('../interactive/objection_controller.php');
			//include(CDOC_ROOT."output/indirect-cold-call-script");
			include(CDOC_ROOT.'betapro/application/controllers/interactive/objection_controller.php');
			
			$this->_data['lastid'] = $lastid;
			$this->_data['parts'] = $parts;
			$this->_data['button'] = False;
			echo "<pre>";
			print_r($this->_data['template_sections']);
			exit;
			$html = $this->load->view('outputs/indirect_call', $this->_data, TRUE);
			$this->output
				->set_content_type('application/json')
				->set_status_header(200)
				->set_output(json_encode(array('status' => TRUE, 'list'=> $html)));
			
		}
	
	}
	
	function user_get()
    {
        if(!$this->get('id'))
        {
        	$this->response(NULL, 400);
        }
        // $user = $this->some_model->getSomething( $this->get('id') );
    	$users = array(
			1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
			2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!'),
		);
		
    	$user = @$users[$this->get('id')];
    	
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
	
	
	
    function user_post()
    {
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->get('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
    	//$this->some_model->deletesomething( $this->get('id') );
        $message = array('id' => $this->get('id'), 'message' => 'DELETED!');
        
        $this->response($message, 200); // 200 being the HTTP response code
    }
    
    function users_get()
    {
        //$users = $this->some_model->getSomething( $this->get('limit') );
        $users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com'),
		);
        
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }
}