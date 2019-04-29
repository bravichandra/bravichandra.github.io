<?php
session_start();
//error_reporting(E_ALL);
class CreateTemp extends CI_Controller {
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
			//Am_Lite::getInstance()->checkAccess(array(2,6,5,9,10,14,15), 'Restricted access'); //  This array is Updated by sukhdev developer on 17-April-2014
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
			//$haveSubscriptions = Am_Lite::getInstance()->haveSubscriptions(array('6','2','9','10','14','15'));//  This array is Updated by sukhdev developer on 17-April-2014
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

			$this->_data['button'] = FALSE;
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
		if($templatename!='')
		{
			header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=token&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_uri=https://salesscripter.com/pro/salesfrocecallback.php&display=popup&state='.$templatename);
		}else header('location: http://salesscripter.com/pro/folder/email-templates');
	}	
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
	public function verifylogin($dapi)
	{
		//print_r($_COOKIE);
		//print_r($_SESSION);
		//print_r($_POST);
		//print_r($_GET);
		//print_r($_SERVER);
		//echo current_url();
		//echo $dapi;
		/*echo '<script>alert(window.location.href);</script>';*/
	}
	public function index($templatename="")
	{
		//print_r($_SESSION);
		//UNSET NOTES TO SALESFORCE
		$this->session->unset_userdata('ss_vrcid');
		unset($_SESSION['ss_vrcid']);
		
		$templatename= $_SESSION['templatename'];
		//Creating Webservice WSDL file
		$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');
		$wsdlcontent = str_replace('na16.salesforce.com',$_SESSION['instance'].'.salesforce.com',$wsdlcontent);
		if(!file_exists(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml'))
		{
			$fp = fopen(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml', "w");
			if(fwrite($fp, $wsdlcontent))
			{
				header('location:http://salesscripter.com/pro/index.php/createtemplate/index/'.$templatename);
			}
			fclose($fp);
		}
		//Creating Webservice WSDL file - Completed

		if($templatename!='')
		{
			if($_SESSION['access_token']=='') header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_uri=https://salesscripter.com/pro/salesfrocecallback.php&prompt=login&display=popup&state='.$templatename);
			//echo $templatename;
			require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');
			require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');
			$location_data=array();
			$business_data=array();
			$user_data=array();
			// Salesforce Login information
			$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';
			$servicewsdl = dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml';
			

			$sid = explode('%21',$_SESSION['access_token']);
			//$location = 'https://'.$_SESSION['instance'].'.salesforce.com/services/Soap/u/32.0/'.$sid[0];
			
			
			$location = $_SESSION['ws_endpoint'];
			$sessionId = $_SESSION['access_token'];
			
			// Process of logging on and getting a salesforce.com session
			$client = new SforcePartnerClient();
			$client->createConnection($wsdl);
			$client->setEndpoint($location);
			$client->setSessionHeader($sessionId);
			
			$service = new SoapClient($servicewsdl,array("trace" => 1, "soap_version" => SOAP_1_1));
			$sforce_header = new SoapHeader($_SESSION['ws_namespace'], "SessionHeader", array("sessionId" => $client->getSessionId()));
			$service->__setSoapHeaders(array($sforce_header));
			//print_r($sforce_header);
			//GET STRING BETWEEN GIVEN TAGS
			
		
		
		
		
			$result = $this->getSSTemplateData($templatename);

			//print_r($result);
			$main_info=str_replace('<a href="https://salesscripter.com/pro/output/'.$templatename.'/download" class="btnDownload" title="Download">&nbsp;</a>','',$result);
			$main_info=str_replace('<img src="https://salesscripter.com/pro/images/logo.jpg" />','',$main_info);
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
			$main_info = str_replace($totalheader,'<style>p, ul {font-size:10pt; font-family:Arial, Helvetica, sans-serif;}</style>',$main_info);
			$main_info = str_replace($templateheader,'',$main_info);
			$main_info = str_replace($subjecttag,'',$main_info);
			$main_info = str_replace('<td class="border">&nbsp;</td>','',$main_info);
			$footer = $this->middlestring($main_info,'<div align="center" style="margin-top:15px; font-size:12px; clear:both;">','</div>');
			$footer = '<div align="center" style="margin-top:15px; font-size:12px; clear:both;">'.$footer.'</div>';
			$main_info = str_replace($footer,'',$main_info);
			$main_info = str_replace("\r",'',$main_info);
			$main_info = str_replace("\n",'',$main_info);
			
			
			//----------------------------------------
			$campaign_id = $_SESSION['drop_campaign_id'];
			$campaign_name = $_SESSION['drop_campaign_name'];
			//----------------------------------------
			//$main_info = strip_tags($main_info,'<p><ul><li><br /><br><br/>');
				
			//$breaks = array("<br />","<br>","<br/>","</p>","</li>","</ul>");  
			//$main_info = str_ireplace($breaks, "\r\n\r\n", $main_info);
			
			//$main_info = str_replace(array('<p>','<li>','<ul>','&nbsp;'),'',$main_info);
			
			
			
			$templatearray = array('Name' => utf8_encode($title).'-'.$campaign_name, 'UniqueName' => utf8_encode($uniquename).$campaign_id, 'Subject' => utf8_encode($subject), 'Body' => utf8_encode($main_info),'Description' => $subtitle);
			$template = array('t'=>$templatearray);
			//print_r($template);
			try{	
				$response = $service->createTemplate($template);
				if($response->result != 'Duplicate' && $response->result != 'Error')
				{
					if($response->result == 'Created')
					{
						echo '<script>alert("Created, Upgrade your salesscripter app to latest Version in Salesforce"); window.close();</script>';
					}
					else
					{
						$resp = json_decode($response->result);
						//print_r($resp);
						header('location: '.$_SESSION['instance_url'].'/'.$resp->id);
					}
				}
				else
				echo '<script>alert("'.$response->result.'"); window.close();</script>';
			}catch(Exception $e)
			{
				//echo '<br/><pre>';
				//print_r($e);
				//echo '</pre><br/>';
				if(strstr($e->faultcode,'INVALID_SESSION_ID')!=false)
				{
					header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_uri=https://salesscripter.com/pro/salesfrocecallback.php&prompt=login&display=popup&state='.$templatename);
				}
				else
				echo '<script>alert("In order create a email tempalte in your salesforce account, you have to install SalesScripter Application > v1.11");window.close();</script>';
				//header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=token&client_id=3MVG9fMtCkV6eLherTq7Re0WKA5b05NHXK3kcw5MCD1IK.QyfQR5Zvq9Jq7nxwOtGoRIHC1TD3insdmwCYIVQ&redirect_uri=https://salesscripter.com/pro/salesfrocecallback.php&display=popup&state='.$templatename);
			}
		}
		else
		{
			echo 'No Template Selected';
			session_destroy();
		}
	}
	//Notes to Salesforce
	public function ntosf($templatename)
	{/*echo dirname(__FILE__);
		error_reporting(E_ALL);
		ini_set("display_errors", 1);*/
		//session_destroy();
		//print_r($_SESSION);print_r($_POST);exit;		
		if(!$this->session->userdata('ss_vrcid')) {
			echo '<script>alert("There is no Contact/Lead/Account/Opportunity"); window.close();</script>';
			exit;
		}
		if(!$this->session->userdata('ss_sfcomment')) {
			$this->session->set_userdata('ss_sfcomment', 'yes');
			$_SESSION['ss_sfcomment']='yes';
			if($_SESSION['templatename']=="custom-script")
				header("location: ".base_url()."output/".$_SESSION['templatename']."/cstmstage1");
			else
				header("location: ".base_url()."output/".$_SESSION['templatename']."/intro");
			exit;
		}
		
		include('interactive/sfparts_controller.php');
		include('interactive/objection_controller.php');		
		$sfcomment="";
		if(isset($_POST['sfaction']) && $_POST['sfaction']=="ntosf" && $_POST['sfpartids']) {
			$dpartids = json_decode($_POST['sfpartids']);
			foreach($dpartids as $dpartid)
			{
				if($_POST[$parts[$dpartid]['name']])
				{					
					$dam = $_POST[$parts[$dpartid]['name']];
					$dam = str_replace("\n","<br/>",$dam);
					$sfcomment .=$parts[$dpartid]['title'].":".$dam."\n";
				}
			}
			if($sfcomment) $this->session->set_userdata('ss_sfnotes', $sfcomment);
			unset($_SESSION['ss_sfcomment']);
			$this->session->unset_userdata('ss_sfcomment');
			//echo "Saleforce Comment : ".$sfcomment;//exit;
		}
		//echo "<pre>";print_r($_SESSION);print_r($_POST);print_r($parts);echo "</pre>";
		//echo $this->session->userdata('ss_vrcid');
		//$sfcomment = "Activity History";
		if(!$sfcomment) $sfcomment=$this->session->userdata('ss_sfnotes');
		if(!$sfcomment) {
			echo '<script>alert("There is no notes to post"); window.close();</script>';
			exit;
		}
		//exit;
		//echo $sfcomment;
		$templatename= $_SESSION['templatename'];
		//Salesforce Record Reference ID : OBJECTID-USERID
		$wid= $this->session->userdata('ss_vrcid');
		$wid= explode("-",$wid);
		$wid = $wid[0];
		$uid = $wid[1];
		//$wid = "003j0000005vHb8";
		//unset($_SESSION['ss_vrcid']);
		unset($_SESSION['ss_sfcomment']);
		//$this->session->unset_userdata('ss_vrcid');
		$this->session->unset_userdata('ss_sfcomment');
		//exit;
		//Creating Webservice WSDL file
		$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');
		$wsdlcontent = str_replace('na16.salesforce.com',$_SESSION['instance'].'.salesforce.com',$wsdlcontent);
		if(!file_exists(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml'))
		{
			$fp = fopen(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml', "w");
			if(fwrite($fp, $wsdlcontent))
			{
				header('location: /pro/createtemp/ntosf/');
			}
			fclose($fp);
		}
		//Creating Webservice WSDL file - Completed

		if($templatename!='')
		{
			//if($_SESSION['access_token']=='') header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_url=https://salesscripter.com/pro/ntosalesfrocecallback.php&prompt=login&display=popup&state='.$templatename);
			if($_SESSION['access_token']=='') header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_url=https://salesscripter.com/pro/salesfrocecallback.php&prompt=login&nts=1&display=popup&state='.$templatename);
			
			
			
			//echo $templatename;
			require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');
			require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');
			$location_data=array();
			$business_data=array();
			$user_data=array();
			// Salesforce Login information
			$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';
			$servicewsdl = dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml';
			//echo " $wsdl <br> $servicewsdl <br> ";
			

			$sid = explode('%21',$_SESSION['access_token']);
			//$location = 'https://'.$_SESSION['instance'].'.salesforce.com/services/Soap/u/32.0/'.$sid[0];
			
			
			$location = $_SESSION['ws_endpoint'];
			$sessionId = $_SESSION['access_token'];
			
			// Process of logging on and getting a salesforce.com session
			$client = new SforcePartnerClient();
			$client->createConnection($wsdl);
			$client->setEndpoint($location);
			$client->setSessionHeader($sessionId);
			
			$service = new SoapClient($servicewsdl,array("trace" => 1, "soap_version" => SOAP_1_1));
			$sforce_header = new SoapHeader($_SESSION['ws_namespace'], "SessionHeader", array("sessionId" => $client->getSessionId()));
			$service->__setSoapHeaders(array($sforce_header));
			//print_r($sforce_header);
			//GET STRING BETWEEN GIVEN TAGS
			
		
		
		
		
			//$result = $this->getSSTemplateData($templatename);
			$result = strtoupper($templatename);
			$title = str_replace('-',' ',$result);
			$title = str_replace('_',' ',$title);
			//$result = '<title>Activity</title>';
			//$main_info=$result;

			//print_r($result);
			//$main_info=str_replace('<a href="https://salesscripter.com/launch/output/'.$templatename.'/download" class="btnDownload" title="Download">&nbsp;</a>','',$result);
			//$title = $this->middlestring($main_info,'<title>','</title>');
			$title = str_replace('&#45','',$title);
			$title = str_replace('Â','',$title);
			$title = str_replace('\x96\r\n','',$title);

			$title = filter_var(utf8_encode($title), FILTER_SANITIZE_STRING);
			$title = str_replace('Â','',$title);			
			
			$main_info = $sfcomment;
			//$main_info = str_replace("\r",'',$main_info);
			//$main_info = str_replace("\n",'',$main_info);
			
			
			//----------------------------------------
			//$campaign_id = $_SESSION['drop_campaign_id'];
			//$campaign_name = $_SESSION['drop_campaign_name'];
			//----------------------------------------
			//$main_info = strip_tags($main_info,'<p><ul><li><br /><br><br/>');
				
			//$breaks = array("<br />","<br>","<br/>","</p>","</li>","</ul>");  
			//$main_info = str_ireplace($breaks, "\r\n\r\n", $main_info);
			
			//$main_info = str_replace(array('<p>','<li>','<ul>','&nbsp;'),'',$main_info);
			
			
			
			//$templatearray = array('Name' => utf8_encode($title).'-'.$campaign_name, 'UniqueName' => utf8_encode($uniquename).$campaign_id, 'Subject' => utf8_encode($subject), 'Body' => utf8_encode($main_info),'Description' => $subtitle);
			$templatearray = array('Name' => utf8_encode($wid), 'Subject' => utf8_encode($title), 'Body' => utf8_encode($main_info));
			//$templatearray = array('Name' => utf8_encode($wid), 'UID' => utf8_encode($uid), 'Subject' => utf8_encode($title), 'Body' => utf8_encode($main_info));
			$template = array('t'=>$templatearray);
			//print_r($template);exit;
			try{	
				$response = $service->notescomment($template);				
				$this->session->unset_userdata('ss_sfnotes');
				$this->session->unset_userdata('ss_vrcid');
				unset($_SESSION['ss_vrcid']);
				//echo "<pre>";print_r($response);exit;
				if($response->result == 'success')
				{					
					echo '<script>alert("Notes submitted to Salesforce Notes section"); location.replace("https://'.$_SESSION['instance'].'.salesforce.com/'.$wid.'");</script>';					
				}
				/*echo '<br/>Method Called<pre>';
				print_r($response);
				echo '</pre><br/>';exit;*/
				else
				/*echo '<script>alert("'.$response->result.'"); window.close();</script>';*/
				echo '<script>alert("Comment not posted."); window.close();</script>';
				
			}catch(Exception $e)
			{
				/*echo '<br/>Error<pre>';
				print_r($e);
				echo '</pre><br/>';exit;*/
				echo '<script>alert("Comment not posted."); window.close();</script>';
				/*echo '<br/>Error<pre>';
				print_r($e);
				echo '</pre><br/>';exit;
				if(strstr($e->faultcode,'INVALID_SESSION_ID')!=false)
				{
					header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA5b05NHXK3kcw5MCD1IK.QyfQR5Zvq9Jq7nxwOtGoRIHC1TD3insdmwCYIVQ&redirect_uri=https://salesscripter.com/launch/salesfrocecallback.php&prompt=login&display=popup&state='.$templatename);
				}
				else
				echo '<script>alert("In order post comment to your salesforce account, you have to install SalesScripter Application > v1.11");window.close();</script>';*/
				//header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=token&client_id=3MVG9fMtCkV6eLherTq7Re0WKA5b05NHXK3kcw5MCD1IK.QyfQR5Zvq9Jq7nxwOtGoRIHC1TD3insdmwCYIVQ&redirect_uri=https://salesscripter.com/launch/salesfrocecallback.php&display=popup&state='.$templatename);
			}
		}
		else
		{
			echo 'No Template Selected';
			session_destroy();
		}
	}
	
	//Salesforce checkeer
	public function salesforce($action = NULL) {
		/*echo "<pre>";
		print_r($_SESSION);
		print_r($_COOKIE);
		echo "</pre>";*/
		$sflogin = 0;
		if($_SESSION['instance'] && $_SESSION['access_token'] && $_SESSION['expires']) {			
			$exp = date('Y-m-d h:i:s',strtotime($_SESSION['expires']));
			$pre = date('Y-m-d h:i:s');
			if($exp < $pre) {
				if(isset($_SESSION['instance'])) unset($_SESSION['instance']);
				if(isset($_SESSION['access_token'])) unset($_SESSION['access_token']);
				if(isset($_SESSION['expires'])) unset($_SESSION['expires']);
				header('location: page1.php?template=yes&crm=y');
			} else $sflogin = 1;
		}
		$this->_data['sflogin'] = $sflogin;
		if(!$sflogin && $action=="login") header('location: /pro/page1.php?template=yes&crm=y');
		if(!$sflogin) return;
		error_reporting(E_ALL);
		//Creating Webservice WSDL file
		$wsdlcontent = file_get_contents(dirname(__FILE__).'/ss/forceapi/soapclient/SalesScripterWebservice.xml');
		$wsdlcontent = str_replace('na16.salesforce.com',$_SESSION['instance'].'.salesforce.com',$wsdlcontent);
		if(!file_exists(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml'))
		{
			$fp = fopen(dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml', "w");
			if(fwrite($fp, $wsdlcontent))
			{
				fclose($fp);
				header('location: '.current_url());
			}
			fclose($fp);
		}
		//Creating Webservice WSDL file - Completed
		
		//Creating a Connection
		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforcePartnerClient.php');
		require_once (dirname(__FILE__).'/ss/forceapi/soapclient/SforceHeaderOptions.php');
		// Salesforce Login information
		$wsdl = dirname(__FILE__).'/ss/forceapi/soapclient/partner.wsdl.xml';
		//echo $wsdl;
		//if(file_exists($wsdl)) echo "Y"; else echo "N";
		$servicewsdl = dirname(__FILE__).'/ss/forceapi/soapclient/ws_wsdls/'.$_SESSION['instance'].'.xml';
		//echo $servicewsdl;
		//if(file_exists($servicewsdl)) echo "Y"; else echo "N";
		
		$location = $_SESSION['ws_endpoint'];
		$sessionId = $_SESSION['access_token'];
		
		
		echo " $wsdl , $location , $sessionId";
		
		// Process of logging on and getting a salesforce.com session
		$client = new SforcePartnerClient();
		$client->createConnection($wsdl);
		$client->setEndpoint($location);
		$client->setSessionHeader($sessionId);	
		
		echo $client->__getLastResponse();	
		
		//echo($client->__getLastResponse());
		//echo PHP_EOL;
		//echo($client->__getLastRequest());
		
		/*$service = new SoapClient($servicewsdl,array("trace" => 1, "soap_version" => SOAP_1_1));
		$sforce_header = new SoapHeader($_SESSION['ws_namespace'], "SessionHeader", array("sessionId" => $client->getSessionId()));
		$service->__setSoapHeaders(array($sforce_header));
		
		echo $error[] = "Connected Successfully.";
		$this->_data['error']=$error;*/
		
		$query = "SELECT Id, FirstName, LastName, Phone from Contact";
		$response = $client->query($query);
		$queryResult = new QueryResult($response);
		
		echo "Results of query '$query'<br/><br/>\n";
		for ($queryResult->rewind(); $queryResult->pointer < $queryResult->size; $queryResult->next()) {
			$record = $queryResult->current();
			// Id is on the $record, but other fields are accessed via
			// the fields object
			echo $record->Id.": ".$record->fields->FirstName." "
					.$record->fields->LastName." "
					.$record->fields->Phone."<br/>\n";
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
