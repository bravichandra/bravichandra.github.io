<?php
	if($_SESSION['templatename']=="indirect-cold-call-script") 
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'value-statement-intro','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-focus-product")
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

				      2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-focus-pain")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'about-us','title'=>'Information About Us'),

					  5=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-name-drop")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-webinar-follow-up")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call_script_email_follow_up_qualify")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-technical-focus")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-business-focus")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="call-script-personal-focus")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					  2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="inbound-call-script")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Greeting'),

					  2=>array('name'=>'prospect-request','title'=>"Prospect's Request"),

					  3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					  4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					  5=>array('name'=>'about-us','title'=>'Information About Us'),

					  6=>array('name'=>'schedule-next','title'=>'Scheduling the Next Discussion'));
	else if($_SESSION['templatename']=="call-script-quick-close")				  
	$parts = array(1=>array('name'=>'intro','title'=>'Introduction'),

					   2=>array('name'=>'attention-grabbing','title'=>'Attention Grabbing Statement'),

 					   3=>array('name'=>'pre-qualifying-questions','title'=>'Pre-Qualifying Questions'),

					   4=>array('name'=>'common-problems','title'=>'Examples of Common Problems'),

					   5=>array('name'=>'about-us','title'=>'Information About Us'),

					   6=>array('name'=>'close','title'=>'Close'));
	else if($_SESSION['templatename']=="custom-script") {//Custom Script
		$active_campaign = $this->_data['campaign_info']->campaign_id;
		$customTemplateInfo = $this->campaign->getCampaignCustomdata($active_campaign);
		array_unshift($customTemplateInfo, null);
		unset($customTemplateInfo[0]);
		$parts = array();
		$ik = 0;
		foreach($customTemplateInfo as $key => $temp_info)
		{
			$parts[$key]['name'] = 'cstmstage'.$key;
			$parts[$key]['title'] = $temp_info->heading;
			$ik++;
		}
	}
	if($parts) $lastid = count($parts); else $lastid=0;
	//print_r($parts);echo $lastid;
?>