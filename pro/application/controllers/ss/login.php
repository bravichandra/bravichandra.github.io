<?php
session_start();
require_once ('forceapi/soapclient/SforcePartnerClient.php');
require_once ('forceapi/soapclient/SforceHeaderOptions.php');
if($_POST['loginsf'])
{
// Salesforce Login information
$wsdl = 'forceapi/soapclient/partner.wsdl.xml';
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
	// Define constants for the web service. We'll use these later
	$parsedURL = parse_url($client->getLocation());
	define ("_SFDC_SERVER_", substr($parsedURL['host'],0,strpos($parsedURL['host'], '.')));
	define ("_WS_NAME_", 'SalesScripterWebservice');
	define ("_WS_WSDL_", _WS_NAME_ . '.xml');
	define ("_WS_ENDPOINT_", 'https://' . _SFDC_SERVER_ . '.salesforce.com/services/wsdl/class/sscripter/' . _WS_NAME_);
	define ("_WS_NAMESPACE_", 'http://soap.sforce.com/schemas/class/sscripter/' . _WS_NAME_);
	$_SESSION['sf_server'] = _SFDC_SERVER_;
	$_SESSION['sf_ws_name'] = _WS_NAME_;
	$_SESSION['sf_ws_wsdl'] = _WS_WSDL_;
	$_SESSION['sf_ws_endpoint'] = _WS_ENDPOINT_;
	$_SESSION['sf_ws_namespace'] = _WS_NAMESPACE_;
	header('location:index.php');
}
else
{
	echo "Invalid Details";
}
}
?>
<html>
<body>
<form method="post">
<label>Username: </label>
<input type="text" name="username" value="test_test07@test.com"/><br/>
<label>Password: </label>
<input type="password" name="password" value="Z123456T"/><br/>
<label>Security token: </label>
<input type="text" name="securitytoken" value="6Olea1bMrDy8yE43SwJt6SfeA"/><br/>
<input type="submit" name="loginsf">
</form>
</body>
</html>