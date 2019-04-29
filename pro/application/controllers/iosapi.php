<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Iosapi extends CI_Controller 
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
		$this->_api_key = "Xbd0aAhPcWkVwWBsml37";
		$this->_verify_key = "ssIpad";
		$this->_api_url = "https://salesscripter.com/members/api/";
		$this->_itunes_url = "https://sandbox.itunes.apple.com/verifyReceipt";
		$this->_itunes_key = "613fa38dad4f475bbfc9423816ea21de";
		$this->_format = "json";
		$this->load->model('api_model', 'api');
		$this->load->model('home_model', 'home');
	}
	/**
	 * Index
	 */
	public function index()
	{
		echo "Invalid Access";
		return;
	}
	//IPad user signup
	public function signup(){
		$api_headers = $this->input->request_headers();		
		if($api_headers['Accesskey'] <> $this->_verify_key) {
			$res = array('status'=>false,'message'=>'Invalid Access');
			echo json_encode($res);
			return;
		}
		//Validate POST method
		if ($this->input->server('REQUEST_METHOD') <> 'POST') {
			$res = array('status'=>false,'message'=>'Invalid Access');
			echo json_encode($res);
			return;
		}
   		$edata = $this->input->post();
		$fname = $edata['fname'];
		$lname = $edata['lname'];
		$email = $edata['email'];
		$phone = $edata['phone'];
		$username = $edata['username'];
		$password = $edata['password'];

		//Signup validation
		$ers = array();
		if(empty($fname)) $ers['fname'] = "First name required";
		if(empty($lname)) $ers['lname'] = "Last name required";
		if(empty($email)) $ers['email'] = "Email required";
		else {
			$this->load->helper('email');
			if (valid_email($email))
			{
				//Verify Email existance
				$fields = array('email'=>$email);
				$jresult = $this->_curl("check-access/by-email", $fields);
				//if($jresult==false) $ers['email'] = "Unable to validate email now, please try later.";
				//else if($jresult)
				if($jresult)
				{
					if($jresult->ok==true) $ers['email'] = "Email already exists";
				}    
			}
			else
			{
			    $ers['email']="Enter valid email address";
			}			
		}
		if(empty($username)) $ers['username'] = "Username required";
		else {
			//Verify username existance
			$fields = array('login'=>$username);
			$jresult = $this->_curl("check-access/by-login", $fields);
			if($jresult==false) $ers['username'] = "Unable to validate user now, please try later.";
			else if($jresult)
			{
				if($jresult->ok==true) $ers['username'] = "Username already exists";
			}
		}
		if(empty($password)) $ers['password'] = "Password required";
		if($ers) {
			$ers['status'] = false;
			$ers['message'] = "Registration Failed";
			echo json_encode($ers);
			return;
		}

		/*$ers['status'] = true;
		$ers['message'] = "User registered successfully.";
		$ers['userid'] = 4489;
		echo json_encode($ers);
		return;				*/

		//Save user information
		$username = strtolower($username);
		$fields = array('login'=>$username,'pass'=>$password,'email'=>$email,'phone'=>$phone,'name_f'=>$fname,'name_l'=>$lname);
		$jresult = $this->_curl("users", $fields,TRUE);
		if($jresult==false) {
			$ers['status'] = false;
			$ers['message'] = "Unable to register, please try again.";
			echo json_encode($ers);
			return;
		}
		else if($jresult)
		{		
			$ers['status'] = true;
			$ers['message'] = "User registered successfully.";
			$ers['userid'] = $jresult[0]->user_id;
			echo json_encode($ers);
			return;						
		}
		$ers['status'] = false;
		$ers['message'] = "Registration Failed";
		echo json_encode($ers);
		return;
	}

	//Payment Success
	public function paidaccess(){
		$api_headers = $this->input->request_headers();		
		if($api_headers['Accesskey'] <> $this->_verify_key) {
			$res = array('status'=>false,'message'=>'Invalid Access');
			echo json_encode($res);
			return;
		}
		//Validate POST method
		if ($this->input->server('REQUEST_METHOD') <> 'POST') {
			$res = array('status'=>false,'message'=>'Invalid Access');
			echo json_encode($res);
			return;
		}		
		$userid = 0;
		if(isset($api_headers['Userid'])) {
			$userid = (int)$api_headers['Userid'];
		}
		$username = 0;
		if(isset($api_headers['Username'])) {
			$username = $api_headers['Username'];
		}
		if(!$userid || !$username) {
			$res = array('status'=>false,'message'=>'Invalid User');
			echo json_encode($res);
			return;
		}
		$username = strtolower($username);
		$ePost = $this->input->post();
		$newcontent = "";
		foreach ($ePost as $key=>$value){
			$newcontent .= $key.' '.$value;
		}
		$res = array();

		$new = trim($newcontent);
		$new = trim($newcontent);
		$new = str_replace('_','+',$new);
		$new = str_replace(' =','==',$new);

		if (substr_count($new,'=') == 0){
			if (strpos('=',$new) === false){
				$new .= '=';
			}
		}

		$new = '{"receipt-data":"'.$new.'","password":"'.$this->_itunes_key.'"}';
		$receipt = $new;

		//Get user payment info
		$fh = fopen(CDOC_ROOT.'pro/iusers/i_'.$username.'.txt',w);
		fwrite($fh,$receipt);
		fclose($fh);
		$endpoint = $this->_itunes_url;
		
		$ch = curl_init($endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $receipt);
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		$errno = curl_errno($ch);
		$errmsg = curl_error($ch);
		curl_close($ch);
		$msg = $response.' - '.$errno.' - '.$errmsg;
		$rs = "";
		//echo $response;
		if($info['http_code']==200) {
			$response2 = json_decode($response);
			//echo "<pre>";print_r($info);echo "</pre>";
			//echo "<pre>";print_r($response2);echo "</pre>";
			if(isset($response2->status) && $response2->status==0 && isset($response2->latest_receipt_info)) {
				$receipt = $response2->latest_receipt_info;
				$receipt = $receipt[count($receipt)-1];
				//echo "<pre>";print_r($receipt);echo "</pre>";
				$transid = $receipt->transaction_id;
				$expdate = $receipt->expires_date;
				
				$expdate = explode(" ", $expdate);
				//echo "<pre>";print_r($expdate);echo "</pre>";
				$NewDate=date('Y-m-d',strtotime("+2 days", strtotime($expdate[0])));
				$expdate = $NewDate." ".$expdate[1];
				$expdate = strtotime($expdate);
				$expdate = $expdate-6*60*60;
				//echo " - $expdate -  ";
				$product_id = str_replace("ssp_", "", $receipt->product_id);
				$expdate =date("Y-m-d",$expdate);
				$rs = " $product_id - ".$expdate;
				//Create Access on Amember
				$start_date = date('Y-m-d');
				$fields = array('user_id'=>$userid,'product_id'=>$product_id,'begin_date'=>$start_date,'expire_date'=>$expdate);
				$jresult = $this->_curl("access", $fields,TRUE);				
				//$jresult =1;
				if($jresult)
				{		
					//Save access id
					
					//Payment Record
					/*$eaccess = array();
					$eaccess['user_id'] = 0;
					$eaccess['field_type'] = 'iosusers';
					$payinfo = array('auser_id'=>$userid,'auser'=>$username,'acccess_id'=>$jresult[0]->access_id,'transaction_id'=>$transid);
					$eaccess['value']=json_encode($payinfo);*/
					//$this->home->saveUserData($eaccess);

					$edata = array(
								'amember_id'=>$userid,
								'username'=>$username,
								'user_id'=>0,
								'start_date'=>$start_date,
								'end_date'=>$expdate,
								'product_id'=>$product_id,
								'access_id'=>$jresult[0]->access_id,
								'trans_id'=>$transid,
								'status'=>1
								);
					$tid = $this->api->save_payment($edata);
					$ers['status'] = true;
					$ers['message'] = "Subscription created successfully.";
					$ers['userid'] = $jresult[0]->user_id;
					echo json_encode($ers);
					return;						
				}				
			}
		}
		$ers['status'] = false;
		$ers['message'] = "Registration completed successfully but unable to create subscription access with payment, please contact Administrator.";
		echo json_encode($ers);
		return;
	}

	//Auto login
	public function autologin() {
		//$user,$pass
		$edata = $this->input->post();
		$user = $edata['user'];
		$pass = $edata['pass'];
		if($user && $pass) {
			$user = strtolower($user);
			require_once CDOC_ROOT.'members/bootstrap.php';
			$result = Am_Di::getInstance()->auth->login($user, $pass,$_SERVER['REMOTE_ADDR']);
			if($result->isValid()) {
				$ssurl = "https://salesscripter.com/pro/";
				header("location: $ssurl");
				exit;
			}	
		}
		echo "INVALID";
	}

	//IOS Users cron
	public function ioscron() {
		$payments=$this->api->get_expired_ios_payments();
		if(!$payments) {
			echo "Nothing";
			return;
		}
		//echo "yes";
		foreach($payments as $pay) {
			//echo "<pre>";print_r($pay);echo "</pre>"; 
			$reciept_file = CDOC_ROOT.'pro/iusers/i_'.$pay->username.'.txt';
			//echo $reciept_file; //continue;
			$receipt = file_get_contents($reciept_file);
			if($receipt) {
				$endpoint = $this->_itunes_url;		
				$ch = curl_init($endpoint);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $receipt);
				$response = curl_exec($ch);
				$info = curl_getinfo($ch);
				curl_close($ch);

				if($info['http_code']==200) {
					$response2 = json_decode($response);
					//echo "<pre>";print_r($info);echo "</pre>";
					//echo "<pre>";print_r($response2);echo "</pre>";
					if(isset($response2->status) && $response2->status==0 && isset($response2->latest_receipt_info)) {
						$receipt = $response2->latest_receipt_info;
						$receipt = $receipt[count($receipt)-1];
						//echo "<pre>";print_r($receipt);echo "</pre>";
						$transid = $receipt->transaction_id;
						$expdate = $receipt->expires_date;
						$expdate = explode(" ", $expdate);
						$expdate = $expdate[0]." ".$expdate[1];
						//echo " - $expdate -  ";
						$expdate = strtotime($expdate);
						$expdate = $expdate-6*60*60;
						//echo " - $expdate -  ";
						$product_id = str_replace("ssp_", "", $receipt->product_id);
						$expdate =date("Y-m-d",$expdate);
						if(strtotime($pay->end_date) >= strtotime($expdate) ) continue;
						$rs = " $product_id - ".$expdate;
						//Create Access on Amember
						$start_date = date('Y-m-d');
						$fields = array('user_id'=>$pay->amember_id,'product_id'=>$product_id,'begin_date'=>$start_date,'expire_date'=>$expdate);
						//print_r($fields); continue;
						$jresult = $this->_curl("access", $fields,TRUE);
						if($jresult)
						{		
							//Save access id
							
							//Payment Record
							$eaccess = array();
							$eaccess['user_id'] = 0;
							$eaccess['field_type'] = 'iosusers';
							$payinfo = array('auser_id'=>$pay->amember_id,'auser'=>$pay->username,'acccess_id'=>$jresult[0]->access_id,'transaction_id'=>$transid);
							$eaccess['value']=json_encode($payinfo);
							//$this->home->saveUserData($eaccess);

							//update cron status for old payments
							$where = array('amember_id'=>$pay->amember_id);
							$edata = array('status'=>0);
							$tid = $this->api->save_payment($edata,$where);

							//save payment
							$edata = array(
										'amember_id'=>$pay->amember_id,
										'username'=>$pay->username,
										'user_id'=>$pay->user_id,
										'start_date'=>$start_date,
										'end_date'=>$expdate,
										'product_id'=>$product_id,
										'access_id'=>$jresult[0]->access_id,
										'trans_id'=>$transid,
										'status'=>1
										);
							$tid = $this->api->save_payment($edata);							
						}				
					}
				}
			}
		}
		echo "Done";
	}

	//Payment notification
	public function ipn() {
		$put_data = "";
		ob_start();
		echo "\n Domain ".$_SERVER['HTTP_HOST']."\n\n";
		if(count($HTTP_POST_VARS)) {
			echo "\n HTTP_POST_VARS \n\n";
			print_r($HTTP_POST_VARS);
		}
		if(count($HTTP_GET_VARS)) {
			echo "\n HTTP_GET_VARS \n\n";
			print_r($HTTP_GET_VARS);
		}
		if(count($_POST)) {
			echo "\n POST \n\n";
			print_r($_POST);
		}
		if(count($_GET)) {
			echo "\n GET \n\n";
			print_r($_GET);
		}
		if(count($_REQUEST)) {	
			echo "\n REQUEST \n\n";
			print_r($_REQUEST);
		}
		if(count($_SESSION)) {
			echo "\n SESSION \n\n";
			print_r($_SESSION);
		}
		
		$put_data = ob_get_contents();
		ob_end_clean();
		$paylog = CDOC_ROOT.'pro/paylog/i_'.date("Y-m-d_H-i-s").'.txt';
		//$paylog = "paylog/paylog_".$_SERVER['HTTP_HOST'].".txt";
		$fp = fopen($paylog,"a"); // $fp is now the file pointer to file $filename
		if($fp){
			$put_data = date("m-d-Y h:i:s A")."\n".$put_data;
			fwrite($fp,$put_data);    //    Write information to the file
			fclose($fp);  //    Close the file		
		}
	}


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
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//execute post
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		//close connection
		curl_close($ch);

		if($info['http_code']<>200) return false;
		$result = json_decode($result);
		return $result;
	}
	
//--------------------------------------------------------------
}
/* End of file iosapi.php */
/* Location: ./application/controllers/iosapi.php */