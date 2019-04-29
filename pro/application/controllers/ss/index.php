<?php
ini_set("soap.wsdl_cache_enabled", "0");
require_once ('forceapi/soapclient/SforcePartnerClient.php');
require_once ('forceapi/soapclient/SforceHeaderOptions.php');
$location_data=array();
$business_data=array();
$user_data=array();
// Salesforce Login information
$wsdl = 'forceapi/soapclient/partner.wsdl.xml';
$servicewsdl = 'forceapi/soapclient/SalesScripterWebservice.xml';

session_start();
if($_SESSION['sf_login_u']=='') header('location: login.php');
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


if($_GET['templatename']!='')
{
	
	echo $form_url = "https://salesscripter.com/pro/output/".$_GET['templatename'];
	echo file_get_contents($form_url);
	//echo "<h1>$form_url</h1>";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$form_url);  
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, TRUE); 
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_COOKIE, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
	curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
	curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
	curl_setopt ($ch, CURLOPT_REFERER, $form_url);
	$result = curl_exec($ch);  
	curl_close($ch);
	print_r($result);
	$main_info=str_replace('<a href="https://salesscripter.com/pro/output/'.$_GET['templatename'].'/download" class="btnDownload" title="Download">&nbsp;</a>','',$result);
	$main_info=str_replace('<img src="https://salesscripter.com/pro/images/logo.jpg" />','',$main_info);
	$main_info=str_replace('[Prospect First Name]','{!Contact.FirstName}',$main_info);
	$title = middlestring($main_info,'<title>','</title>');
	$title = str_replace('&#45','',$title);
	
	$uniquename = utf8_encode($title);
	$uniquename = preg_replace("/[^A-Za-z0-9]/", '', $uniquename);
	
	$subject = middlestring($main_info,'<p><strong>Subject line:</strong>', '</p>');
	
	$subjecttag = '<p><strong>Subject line:</strong>'.$subject.'</p>';
	
	$subject = strip_tags($subject);
	
	$subtitle = middlestring($main_info,'<p class="topTxt">', '</p>');
	$subtitle = $title.' - '.strip_tags($subtitle);
	
	$templateheader = middlestring($main_info, '<h1 align="center">','</p>');
	$templateheader = '<h1 align="center">'.$templateheader.'</p>';
	$totalheader = middlestring($main_info,'<html>',$templateheader);
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
	print_r($template);
	try{	
	$response = $service->createTemplate($template);
	echo $response->result;
	}catch(Exception $e)
	{
		echo '<br/><pre>';
		print_r($e);
		echo '</pre><br/>';
	}
}
else
{
	echo 'No Template Selected';
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