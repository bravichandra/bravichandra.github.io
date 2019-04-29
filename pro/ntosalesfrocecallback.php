<?php
//echo 'Processing...';
session_start();
if($_GET['code']!='')
{
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"https://login.salesforce.com/services/oauth2/token");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "grant_type=authorization_code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&client_secret=2489853381304279889&redirect_uri=https://salesscripter.com/pro/ntosalesfrocecallback.php&code=".$_GET['code']."&format=json");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
$service_status = curl_getinfo($ch);
curl_close($ch);
$data = json_decode($server_output);
//print_r($data);
if ($service_status[http_code] == "200")
{
	define ("_WS_NAME_", 'SalesScripterWebservice');
	define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/salesscripter/' . _WS_NAME_);
	//$_SESSION['templatename'] = 'call-script-focus-pain';
	$_SESSION['access_token'] = $data->access_token;
	$_SESSION['instance_url'] = $data->instance_url;
	$_SESSION['issued_at'] = $data->issued_at;
	$_SESSION['signature'] = $data->signature;
	$_SESSION['id'] = $data->state;
	$_SESSION['scope'] = $_POST['scope'];
	$_SESSION['token_type'] = $data->token_type;
	$pre = date('Y-m-d h:i:s',strtotime('+1 Hour'));
	$_SESSION['expires'] = $pre;
	$tesend = explode('://',$_SESSION['instance_url']);
	$tesend = end($tesend);
	$tes = explode('.',$tesend);
	$_SESSION['instance'] = $tes[0];
	define ("_WS_ENDPOINT_", $data->instance_url . '/services/wsdl/class/salesscripter/' . _WS_NAME_);
	$_SESSION['ws_namespace'] = _WS_NAMESPACE_;
	$_SESSION['ws_endpoint'] = _WS_ENDPOINT_;
	$_SESSION['ws_name'] = _WS_NAME_;
	
	header('location: /pro/createtemp/ntosf/');
}
else
{
	header('location: /pro/folder/sales-scripts');
}
}
?>