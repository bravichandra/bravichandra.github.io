<?php
session_start();
//echo $_SERVER['HTTP_REFERER'];
//print_r($_SERVER);
//echo '<pre>';
//print_r($_SESSION);
//print_r($_COOKIE);
//echo '</pre>';
if($_GET['template']!='')
{
	$templatename = $_GET['template'];
	unset($_SESSION['ss_vrcid']);
	$_SESSION['templatename'] = $templatename;
	//Notes to Salesforce
	if($_GET['sfid']) $sfcid = $_GET['sfid'];
	if($sfcid) $_SESSION['ss_vrcid']=$sfcid;
	//Salesforce Auth for CRM
	if($_GET['crm']) $crm = $_GET['crm'];
	if($crm) {
		$_SESSION['crmlog']=$crm;
		$crmrc = $_GET['rc'];
		$_SESSION['crmlogrc']=$crmrc;
	}
	if($_GET['bcrm']) $bcrm = $_GET['bcrm'];
	if($bcrm) {
		$_SESSION['bcrmlog']=$bcrm;
		$bcrmrc = $_GET['rc'];
		$_SESSION['bcrmlogrc']=$bcrmrc;
	}
	if($_SESSION['access_token'] && $_SESSION['templatename']!='')
	{
		$exp = strtotime($_SESSION['expires']);
		$pre = time();
		if($exp < $pre) { 
			session_destroy(); 
			if($sfcid) header('location: page1.php?template='.$templatename.'&sfid='.$sfcid);//Notes to Salesforce
			else if($crm) header('location: page1.php?template='.$templatename.'&crm='.$crm.'&rc='.$crmrc);//CRM
			else if($bcrm) header('location: page1.php?template='.$templatename.'&bcrm='.$bcrm.'&rc='.$bcrmrc);//CRM BETA
			else header('location: page1.php?template='.$templatename); 
		}		
		else {
			if($sfcid) header('location: index.php/createtemp/ntosf/');//Notes to Salesforce
			else if($crm) header("location: /pro/crm/sf2ss/".$crmrc);//header('location: /pro/crm/contacts/import');//CRM
			else if($bcrm) {//CRM BETA
				header("location: /betapro/crm/sf2ss/".$bcrmrc);
			}	
			else header('location: index.php/createtemp/index/');
		}	
	}
	else if($_SESSION['templatename']!='')
	{
		$exp = date('Y-m-d h:i:s',strtotime($_SESSION['expires']));
		$pre = date('Y-m-d h:i:s');
		if($exp < $pre && $_SESSION['expires']!='') {
				header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_uri=https://salesscripter.com/pro/salesfrocecallback.php&prompt=login&display=popup&state='.$templatename);
		}
		else
		{
			header('location: https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id=3MVG9fMtCkV6eLherTq7Re0WKA_OY_4RvSBdEqtBNAjKM7k39pcmTvAEa.3IWTqhvkLpGVzPrrMeqUMWznhF_&redirect_uri=https://salesscripter.com/pro/salesfrocecallback.php&display=popup&state='.$templatename);
		}
		
	}
	else
	{
		if($sfcid) header('location: index.php/folder/sales-scripts/');//Notes to Salesforce
		else if($crm) header("location: /pro/crm/sf2ss/".$crmrc);//header('location: /pro/crm/contacts/import');//CRM
		else if($bcrm) {//CRM BETA
			header("location: /betapro/crm/sf2ss/".$bcrmrc);
		}
		else header('location: index.php/output/email-templates/');
	}
}
?>