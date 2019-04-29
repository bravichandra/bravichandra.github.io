<?php
session_start();
/*echo $_SERVER['HTTP_REFERER'];
echo '<pre>';
print_r($_SERVER);
print_r($_SESSION);
print_r($_COOKIE);
echo '</pre>';
exit;*/

if($_GET['template']!='')
{
	$templatename = $_GET['template'];
	$_SESSION['templatename'] = $templatename;
	$_SESSION['ss_vrcid']=$_GET['sfid'];
	if($_SESSION['access_token'] && $_SESSION['templatename']!='')
	{
		$exp = date('Y-m-d h:i:s',strtotime($_SESSION['expires']));
		$pre = date('Y-m-d h:i:s');
		if($exp < $pre) { session_destroy(); header('location: page2.php?template='.$templatename.'&sfid='.$_GET['sfid']);}
		else header('location: /pro/createtemp/ntosf/');
	}
	else if($_SESSION['templatename']!='')
	{
		$exp = date('Y-m-d h:i:s',strtotime($_SESSION['expires']));
		$pre = date('Y-m-d h:i:s');
		if($exp < $pre && $_SESSION['expires']!='') {
				header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_url=https://salesscripter.com/pro/salesfrocecallback.php&prompt=login&display=popup&nts=1&state='.$templatename);
		}
		else
		{
			header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_url=https://salesscripter.com/pro/salesfrocecallback.php&display=popup&nts=1&state='.$templatename);
		}
		
	}
	else
	{
		header('location: /pro/folder/sales-scripts/');
	}
}
?>