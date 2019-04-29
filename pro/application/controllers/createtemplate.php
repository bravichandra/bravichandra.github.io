<?php
session_start();
//error_reporting(E_ALL);

class CreateTemplate extends CI_Controller {
	public function __construct()
	{
		ini_set("soap.wsdl_cache_enabled", "0");

		parent::__construct();
		$this->output->nocache();
		//Load Helpers 
	$this->load->helper('form');
        $this->load->helper('cookie');
        $this->load->library('session');
        //Load Models
        $this->load->model('home_model', 'home');
        $this->load->model('campaign_model', 'campaign');
        $this->load->model('product_model', 'productModel');
		
		if(!$this->config->item('is_local'))
		{
			include(CDOC_ROOT."members/library/Am/Lite.php"); 
                      
            //Am_Lite::getInstance()->checkAccess(array(2,6,5), 'Restricted access');
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15), 'Restricted access'); //  This array is Updated by sukhdev developer on 20-March-2014
			Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15,18,28,32), 'Restricted access'); //  By Dev@4489 24-Oct-2015
			// 9  is for Scripter Pro 3 Month
			// 10 is for Scripter Pro 1 Year
			// 18 is for Pro Lite 1 Year
			
			$amember_username = Am_Lite::getInstance()->getUsername();
	        // Get user from DB by username
	        if($user_id = $this->home->get_user_by_username($amember_username))
	        {
	        	$this->_data['user_id'] = $user_id;
	        }
	        else 
			{
				// Get Full Name
				$amember_full_username = Am_Lite::getInstance()->getName();
				$name = explode(" ", $amember_full_username);
				//Insert Register User information into database.
				$this->_data['user_id'] = $this->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));
				$just_registered = TRUE;
			}

            //$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2'));
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14'.'15'));//  This array is Updated by Aavid developer on 17-April-2014
			$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15','18','28','5','3','32'));//  By Dev@4489 24-Oct-2015
			// 9  is for Scripter Pro 3 Month
			// 10 is for Scripter Pro 1 Year

			// Check User Subscription PAID OR FREE
			$this->_data['is_paid'] = !empty($haveSubscriptions) ? TRUE : FALSE;
			
			//aMember Profile
			$this->_data['aMember'] = array('yname'=>'','yemail'=>'','yphone'=>'');
			$amember_data = Am_Lite::getInstance()->getUser();
			if($amember_data) {
				$this->_data['aMember'] = array('yname'=>ucfirst($amember_data['name_f'].' '.$amember_data['name_l']),'yemail'=>$amember_data['email'],'yphone'=>$amember_data['phone']);
			}
			
		}else 
        {
			// For local testing 
        	$amember_username = "a_ehmad";
	        // Get user from DB by username
	        if($user_id = $this->home->get_user_by_username($amember_username))
	        {
	        	$this->_data['user_id'] = $user_id;
	        }
	        else 
			{
				// Get Full Name
				$amember_full_username = "Fraz Ahmed";
				$name = explode(" ", $amember_full_username);
				//Insert Register User information into database.
				$this->_data['user_id'] = $this->home->registration(array('username'=>$amember_username, 'first_name'=>$name['0'], 'last_name'=>$name['1']));
				$just_registered = TRUE;
			}
			$this->_data['user_id'] = 2;
        	$this->_data['is_paid'] = TRUE;
        }
	   
	   $this->_user_id = $this->_data['user_id'];
       $_SESSION['ss_user_id'] = $this->_user_id;

       if(isset($just_registered))
       {
       		// Add pre-filled session
	   		$redirect = base_url().'folder/my-folder';
	   		// $redirect = base_url().'memeber/member';	
	   		// $this->newSession($redirect, 1, "My first product profile");
			$this->defaultNewproduct($redirect, 1, "My first product profile");
			
       }
	   
		// Check if Product is Add or Not
		$is_product = $this->home->check_product($this->_user_id);
		if(empty($is_product))
		{
			// Add Product into Database
			$status = '2';
			$redirect = base_url().'folder/my-folder';
			$this->defaultNewproduct($redirect, 1, "My first product profile");	
		}
		
		if($session_id = $this->home->get_session_status($this->session->userdata('ss_session_id')))
        {
        	$this->_data['session_status'] = TRUE;
        }
        else 
        {
        	$this->_data['session_status'] = FALSE;
        }

        
		$active_session_id = NULL;
        // Get Active SESSION ID
        if(isset($user_session_id) AND (!$this->session->userdata('ss_session_id')))
        {
        	$this->_data['active_session_id'] = $user_session_id;
        }
        else 
        {
        	$this->_data['active_session_id'] = $this->session->userdata('ss_session_id');
        }
		
        $this->_data['all_sessions'] = $this->home->get_all_sessions();
        $this->_data['total_sessions'] = count($this->_data['all_sessions']);

		/**  now find all active campaign data name drop , company name etc */
		$active_campaign_data =  $this->campaign->get_campaign_active($this->_user_id);
		if($active_campaign_data == false)
		{
			$this->session->set_flashdata('session_msg','Please Create campaign ,company profile and name drop');
			redirect(base_url()."folder/my-folder");
		}
		
		/** campaign info data */
		$this->_data['campaign_info'] = $active_campaign_data;
		$this->_data['campaign_output_tech_val'] = $this->campaign->getOutputTechValue($active_campaign_data->campaign_id);
		$this->_data['campaign_output_biz_val'] = $this->campaign->getOutputBizValue($active_campaign_data->campaign_id);
		$this->_data['campaign_output_per_val'] = $this->campaign->getOutputPerValue($active_campaign_data->campaign_id);
		$this->_data['campaign_output_tech_pain'] = $this->campaign->getOutputTechPain($active_campaign_data->campaign_id);
		$this->_data['campaign_output_biz_pain'] = $this->campaign->getOutputBizPain($active_campaign_data->campaign_id);
		$this->_data['campaign_output_per_pain'] = $this->campaign->getOutputPerPain($active_campaign_data->campaign_id);
		$this->_data['campaign_output_tech_qualify'] = $this->campaign->getOutputTechQualify($active_campaign_data->campaign_id);
		$this->_data['campaign_output_biz_qualify'] = $this->campaign->getOutputBizQualify($active_campaign_data->campaign_id);
		$this->_data['campaign_output_per_qualify'] = $this->campaign->getOutputPerQualify($active_campaign_data->campaign_id);
		
		$this->_data['campaign_tech_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'tech_val_summary');
		$this->_data['campaign_biz_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'bus_val_summary');
		$this->_data['campaign_per_summary'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'per_val_summary');
		$this->_data['sale_process_close1'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close1');
		$this->_data['sale_process_close2'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close2');
		$this->_data['sale_process_close3'] = $this->campaign->getCampaignMetadata($active_campaign_data->campaign_id,'sale_process_close3');
		
		// var_dump($this->_data['campaign_biz_summary']) ; die();
		/** product related query **/
		$this->_data['P_Q1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'P_Q1');
		$this->_data['product_desc'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'P_Desc');
		$this->_data['diff1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB1');
		$this->_data['diff2'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB2');
		$this->_data['diff3'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'interestB3');
		
		$this->_data['negative_impact1'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact1');
		$this->_data['negative_impact2'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact2');
		$this->_data['negative_impact3'] = $this->productModel->getProMetaData($active_campaign_data->product_id,'negative_impact3');
		
		/**  get active session name data */
		$this->_data['active_name_drop_exp'] = $this->campaign->findActiveNameDropForOutput();
		
		/* var_dump($this->_data['active_name_drop_exp']);
		 */  
		/**  find data about company profile **/
		$company_info_detail = $this->productModel->getCompanyInfo($this->_user_id);
		$this->_data['company_info'] = $company_info_detail;
		$this->_data['company_meta'] = $this->productModel->getAllMetaValue($company_info_detail->company_id);	
	}
	public function getSSTemplateData($templatename) 
		{
			
			//echo $templatename;
			
			if(!$this->_data['is_paid']){
				$this->session->set_flashdata('session_msg','Please upgrade your account');
				redirect(base_url()."folder/my-folder");
			}
			
			// Configurations
			$this->_data['cwd'] = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
			//print_r($this->_data); echo '<hr/>';
			$this->_data['img_dir'] = $this->_data['cwd'] . "images" . DIRECTORY_SEPARATOR;
			//print_r($this->_data); echo '<hr/>';

			$this->_data['action'] = null;
			//print_r($this->_data); echo '<hr/>';

			$this->_data['button'] = TRUE;
			//print_r($this->_data); echo '<hr/>';

			$this->_data['method_name'] = 'getSSTemplateData';
			//print_r($this->_data); echo '<hr/>';

			$this->_data['img_dir'] = base_url() . 'images/';
			//echo '<pre>';
			if($templatename!='post-voicemail-name-drop-focus' && $templatename!='internal-referral-email' && $templatename!='pre-call-email-product-focus' && $templatename!='pre-call-email-namedrop-focus' && $templatename!='call-script-focus-pain')
			$templatename = str_replace('-','_',$templatename);
			$page = $this->load->view('outputs/'.$templatename, $this->_data,TRUE); 
			//$page = ob_get_contents();
			return $page;
			//echo '</pre><hr/>';

			
			//$this->load->view('outputs/call-script-focus-pain', $this->_data);
		}
		
	public function login($templatename)
	{
		try{
		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');
		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');
		//print_r($_POST);
		if($_POST['loginsf'])
		{
		// Salesforce Login information
		$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';
		$userName = $_POST['username'];
		$password = $_POST['password'].$_POST['securitytoken'];
		
		// Process of logging on and getting a salesforce.com session
		$client = new SforcePartnerClient();
		$client->createConnection($wsdl);
		$loginResult = $client->login($userName, $password);
		if($loginResult)
		{
			$_SESSION['sf_login_u']=$_POST['username'];
			$_SESSION['sf_login_p']=$_POST['password'];
			$_SESSION['sf_login_s']=$_POST['securitytoken'];
			$_SESSION['sf_login_sid']=$client->getSessionId();
			$_SESSION['sf_login_loc']=$client->getLocation();
			//print_r($_SESSION['sf_login_sid']);
			//print_r($_SESSION['sf_login_loc']);
			// Define constants for the web service. We'll use these later
			$parsedURL = parse_url($client->getLocation());
			define ("_SFDC_SERVER_", substr($parsedURL['host'],0,strpos($parsedURL['host'], '.')));
			define ("_WS_NAME_", 'SalesScripterWebservice');
			define ("_WS_WSDL_", _WS_NAME_ . '.xml');
			define ("_WS_ENDPOINT_", 'https://' . _SFDC_SERVER_ . '.salesforce.com/services/wsdl/class/salesscripter/' . _WS_NAME_);
			define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/salesscripter/' . _WS_NAME_);
			$_SESSION['sf_server'] = _SFDC_SERVER_;
			$_SESSION['sf_ws_name'] = _WS_NAME_;
			$_SESSION['sf_ws_wsdl'] = _WS_WSDL_;
			$_SESSION['sf_ws_endpoint'] = _WS_ENDPOINT_;
			$_SESSION['sf_ws_namespace'] = _WS_NAMESPACE_;
			//Creating Webservice WSDL file
			$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');
			$current_instance =  _SFDC_SERVER_;
			$wsdlcontent = str_replace('na16.salesforce.com',$current_instance.'.salesforce.com',$wsdlcontent);
			if(!file_exists(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$current_instance.'.xml'))
			{
				$fp = fopen(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$current_instance.'.xml', "w");
				if(fwrite($fp, $wsdlcontent))
				{
					//Creating Webservice WSDL file - Completed
					header('location:http://salesscripter.com/launch/index.php/createtemplate/index/'.$templatename);
				}
				fclose($fp);
			}
			else header('location:http://salesscripter.com/launch/index.php/createtemplate/index/'.$templatename);
		}
		else
		{
			echo "Invalid Details";
		}
		
		}
		}catch(Exception $r4)
		{
			echo 'Username/ Passowrd is wrong (or) Security token required to login from thirdparty applications, get one from <a href="https://help.salesforce.com/apex/HTViewHelpDoc?id=user_security_token.htm">here</a>';
		}
		?>
		<html>
		<body>
		<h1>SALESFORCE LOGIN</h1>
		<?php /*?><h2>Account with SalesScripter Application Installed</h2>
		<form method="post">
		<label style="width:120px;display:inline-block;">Username: </label>
		<input type="text" name="username" value="test_test07@test.com"/><br/><br/>
		<label style="width:120px;display:inline-block;">Password: </label>
		<input type="password" name="password" value="Z123456T"/><br/><br/>
		<label style="width:120px;display:inline-block;">Security token: </label>
		<input type="text" name="securitytoken" value="6Olea1bMrDy8yE43SwJt6SfeA"/><br/><br/>
		<input type="submit" name="loginsf">
		</form><?php */?>
       		<?php /*?><h2>Account with SalesScripter Application Installed</h2>
		<form method="post">
		<label style="width:120px;display:inline-block;">Username: </label>	
		<input type="text" name="username" value="mhalper@salesscripter.com"/><br/><br/>
		<label style="width:120px;display:inline-block;">Password: </label>
		<input type="password" name="password" value="Sunday14"/><br/><br/>
		<label style="width:120px;display:inline-block;">Security token: </label>
		<input type="text" name="securitytoken" value="2E2LbosTlvYMekOLxDjgsMh9S"/><br/><br/>
		<input type="submit" name="loginsf">
		</form> <?php */?>
		<h2>Account with SalesScripter Application</h2>
		<form method="post">
		<label style="width:120px;display:inline-block;">Username: </label>
		<input type="text" name="username" value="rak@rak.com"/><br/><br/>
		<label style="width:120px;display:inline-block;">Password: </label>
		<input type="password" name="password" value="ZwebdevTR435"/><br/><br/>
		<label style="width:120px;display:inline-block;">Security token: </label>
		<input type="text" name="securitytoken" value="LWqUeyeBDMmTSgIzKAL0dXxw"/>&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://help.salesforce.com/apex/HTViewHelpDoc?id=user_security_token.htm">How to get Security Token</a><br/><br/>
		<input type="submit" name="loginsf">
		</form>
		</body>
		</html>
	<?php }	
	function middlestring($s,$s1,$s2) {
			$found = "";
			$string_s = stripos($s,$s1,0);
			if($string_s!==false) {//echo $string_s;
				$string_s += strlen($s1);
				$string_e = stripos($s,$s2,$string_s);
				$found = substr($s,$string_s, $string_e-$string_s);
			}
			return $found;
		}
	public function index($templatename)
	{
		
		//Creating Webservice WSDL file
		$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');
		$wsdlcontent = str_replace('na16.salesforce.com',$_SESSION['sf_server'].'.salesforce.com',$wsdlcontent);
		if(!file_exists(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['sf_server'].'.xml'))
		{
			$fp = fopen(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['sf_server'].'.xml', "w");
			if(fwrite($fp, $wsdlcontent))
			{
				header('location:http://salesscripter.com/launch/index.php/createtemplate/index/'.$templatename);
			}
			fclose($fp);
		}
		//Creating Webservice WSDL file - Completed

		if($templatename!='')
		{
			if($_SESSION['sf_login_u']=='') header('location:http://salesscripter.com/launch/index.php/createtemplate/login/'.$templatename);
			//echo $templatename;
			echo '<title>SalesScripter to Salesforce</title>';
			require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');
			require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');
			$location_data=array();
			$business_data=array();
			$user_data=array();
			// Salesforce Login information
			$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';
			$servicewsdl = dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['sf_server'].'.xml';
			
			
			$location = $_SESSION['sf_login_loc'];
			$sessionId = $_SESSION['sf_login_sid'];
			
			// Process of logging on and getting a salesforce.com session
			$client = new SforcePartnerClient();
			$client->createConnection($wsdl);
			$client->setEndpoint($location);
			$client->setSessionHeader($sessionId);
			
			$service = new SoapClient($servicewsdl,array("trace" => 1, "soap_version" => SOAP_1_1));
			$sforce_header = new SoapHeader($_SESSION['sf_ws_namespace'], "SessionHeader", array("sessionId" => $client->getSessionId()));
			$service->__setSoapHeaders(array($sforce_header));
			//GET STRING BETWEEN GIVEN TAGS
			
		
		
		
		
			$result = $this->getSSTemplateData($templatename);

			//print_r($result);
			$main_info=str_replace('<a href="https://salesscripter.com/launch/output/'.$templatename.'/download" class="btnDownload" title="Download">&nbsp;</a>','',$result);
			$main_info=str_replace('<img src="https://salesscripter.com/launch/images/logo.jpg" />','',$main_info);
			$main_info=str_replace('[Prospect First Name]','{!Contact.FirstName}',$main_info);
			$title = $this->middlestring($main_info,'<title>','</title>');
			$title = str_replace('&#45','',$title);
			$title = str_replace('Â','',$title);
			$title = str_replace('\x96\r\n','',$title);

			$title = filter_var(utf8_encode($title), FILTER_SANITIZE_STRING);
			$title = str_replace('Â','',$title);
						
			$uniquename = utf8_encode($title);
			$uniquename = preg_replace("/[^A-Za-z0-9]/", '', $uniquename);
			
			$subject = $this->middlestring($main_info,'<p><strong>Subject line:</strong>', '</p>');
			
			$subjecttag = '<p><strong>Subject line:</strong>'.$subject.'</p>';
			
			$subject = strip_tags($subject);
			
			$subtitle = $this->middlestring($main_info,'<p class="topTxt">', '</p>');
			$subtitle = $title.' - '.strip_tags($subtitle);
			
			$templateheader = $this->middlestring($main_info, '<h1 align="center">','</p>');
			$templateheader = '<h1 align="center">'.$templateheader.'</p>';
			$totalheader = $this->middlestring($main_info,'<html>',$templateheader);
			$main_info = str_replace($totalheader,'',$main_info);
			$main_info = str_replace($templateheader,'',$main_info);
			$main_info = str_replace($subjecttag,'',$main_info);
			$main_info = str_replace('<td class="border">&nbsp;</td>','',$main_info);
			
			$main_info = str_replace("\r",'',$main_info);
			$main_info = str_replace("\n",'',$main_info);
			
			$main_info = strip_tags($main_info,'<p><ul><li><br /><br><br/>');
				
			$breaks = array("<br />","<br>","<br/>","</p>","</li>","</ul>");  
			$main_info = str_ireplace($breaks, "\r\n\r\n", $main_info);
			
			$main_info = str_replace(array('<p>','<li>','<ul>','&nbsp;'),'',$main_info);
			
			$templatearray = array('Name' => utf8_encode($title), 'UniqueName' => utf8_encode($uniquename), 'Subject' => utf8_encode($subject), 'Body' => utf8_encode($main_info),'Description' => $subtitle);
			$template = array('t'=>$templatearray);
			//print_r($template);
			try{	
				$response = $service->createTemplate($template);
				echo '<script>alert("'.$response->result.'"); window.close();</script>';
			}catch(Exception $e)
			{
				/*echo '<br/><pre>';
				print_r($e);
				echo '</pre><br/>';*/
				echo '<script>alert("In order create a email tempalte in your salesforce account, you have to install SalesScripter Application > v1.11");window.close();</script>';
			}
		}
		else
		{
			echo 'No Template Selected';
			session_destroy();
		}
	}
}


/*
$template = array('t'=>array(	'Name' => 'Sample Template',
								'UniqueName' => 'SampleTemplateByWebService'.date('Ymdhis',time()),
								'Description' => 'Sample Template Description',
								'Subject' => 'Sample Template Subject',
								'Body' => 'Sample Template Body'				));
echo '<br/><pre>';
echo 'Data Sent<br/>';
echo '<br/>Template Name		:'.$template['t']['Name'];
echo '<br/>Template UniqueName	:'.$template['t']['UniqueName'];
echo '<br/>Template Description	:'.$template['t']['Description'];
echo '<br/>Template Subject	:'.$template['t']['Subject'];
echo '<br/>Template Body		:'.$template['t']['Body'];
echo '</pre><br/>';
					
try{

$response = $service->createTemplate($template);

}catch(Exception $e)
{
	echo '<br/><pre>';
	print_r($e);
	echo '</pre><br/>';
}

echo '<br/><pre>';
echo 'Result<br/>';
echo $response->result;
echo '</pre><br/>';
*/
?>
