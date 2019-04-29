<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

session_start();

class Mailchimpevents extends CI_Controller 
{

	/**

	 * Properties

	 */

	private $_data;

	//--------------------------------------------------------------

	/**

	 * Constructor

	 */

	public function __construct()

	{

		parent::__construct();

		$this->output->nocache();

		$this->load->helper('cookie');
        $this->load->library('session');
		
		$this->load->model('crm_model', 'crm');
		$this->load->model('home_model', 'home');
		/*error_reporting(E_ALL);
		ini_set("display_errors", 1);*/
	}

	//--------------------------------------------------------------

	//Tracking webhook
	public function track()
	{	
		echo "TRACKED.";

		$put_data = "";
		ob_start();
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

		echo "\n SERVER \n\n";
		print_r($_SERVER);
		
		$put_data = ob_get_contents();
		ob_end_clean();

		$paylog = CDOC_ROOT.'betapro/mc/tw_'.date("Ymd-His").'.txt';
		$fp = fopen($paylog,"a");
		if($fp){
			$put_data = date("m-d-Y h:i:s A")."\n".$put_data;
			fwrite($fp,$put_data);
			fclose($fp);
		}
	}

	//Tracking webhook API
	public function trackapi()
	{	
		echo "TRACKED API.";

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

		echo "\n SERVER \n\n";
		print_r($_SERVER);
		
		$put_data = ob_get_contents();
		ob_end_clean();

		$paylog = CDOC_ROOT.'betapro/mc/twi_'.date("Ymd-His").'.txt';
		$fp = fopen($paylog,"a");
		if($fp){
			$put_data = date("m-d-Y h:i:s A")."\n".$put_data;
			fwrite($fp,$put_data);
			fclose($fp);
		}
	}

	//Mailchimp Cron Start prepare
	public function mcecronstart() {
		$this->output->nocache();
		$this->crm->setMailchimpCronStatus();		
	}

	//Mailchimp email activity cron
	public function mcecron() {
		$this->output->nocache();
		ini_set('max_execution_time', 0);

		$ts1 = time();
		echo "<br />1. Time $ts1 ";

		$apikeys=$this->home->getUserMeta('mailchimp');
		if(!$apikeys) return;

		$this->load->library('MailChimp');

		//Points
		$this->load->helper('scripts');
		$categories = crm_introptions();
		$idate = date("Y-m-d");
		$mce_key = 'mailchimp_campaign_ids';

		foreach($apikeys as $mckey) {			
			//update time
			$where = array();
			$where['user_info_id'] = $mckey->user_info_id;
			$edata = array();
			$edata['updated'] = date("Y-m-d H:i:s");
			$this->home->saveUserData($edata,$where);

			$mailchimp_key = '';
			if(isset($mckey->value)) $mailchimp_key = $mckey->value;
			$mailchimp_key = str_replace(" ", "", $mailchimp_key);
			if(empty($mailchimp_key)) continue;
			//echo "<br>1. key: $mailchimp_key";
			//Set mailchimp key
			$this->config->set_item('Mailchimp_api_key', $mailchimp_key);

			$objmc = new MailChimp();
			$mc_account = array();
			try {
				$mc_account = $objmc->get('');
			}
			catch(Exception $e) {$mc_account = array();}
			//print_r($mc_account);
			if(!$mc_account) continue;
			if(!isset($mc_account['account_id'])) continue;

			//Continue mail activities
			$userid = $mckey->user_id;

			//Mailchimp email campaign id
			$mce_cid=0;
			$where_mc = array();
			$where_mc['user_id'] = $userid;
			$where_mc['field_type'] = $mce_key;
			$user_info_mc = $this->home->getUserData($where_mc);
			if($user_info_mc) $mce_cid = $user_info_mc[0]->user_info_id;
			

			//echo "<br>2. key: $userid";
			echo "<br>-2. Process user account";

			//get user emails
			//get count
			$useremails_Count = $this->crm->get_contacts_count($userid);
			if(!$useremails_Count) continue;

			echo "<br>--3.1. Processing user emails: $useremails_Count";


			$completed_emails = 0;
			//WHILE LOOPING FOR USER EMAILS
			while($completed_emails<$useremails_Count) {
				$useremails = $this->crm->get_contacts($userid);
				if(!$useremails) break;

				echo "<br>--3.2. Processing part of emails: ".count($useremails);

				//USER CONTACT EMAIL PROCESS FOR TRACKING
				//echo "<br>3. key: Emails";
				//Process emails
				foreach($useremails as $eml) {
					//save email mailchimp cron time
					$edata = array('mailchimp_cron_time'=>date("Y-m-d H:i:s"),'mailchimp_cron'=>1);
					$cid = $this->crm->save_contact($edata,$eml->contact_id);

					//echo "<br>4. key: ".$eml->email;
					$contact_mailchimp_time = strtotime($eml->mailchimp_last_time);
					//echo "<br>1.3. Process user account";
					//Get email listings
					$mc_result=array();
					try {
						$mc_result = $objmc->get('search-members?query='.$eml->email.'&fields');						
					}
					catch(Exception $e) {$mc_result=array();}
					if(!$mc_result) continue;
					//get exact email matches
					if(!isset($mc_result['exact_matches'])) continue;
					//get emails
					if($mc_result['exact_matches']['total_items']==0) continue;
					$emails = $mc_result['exact_matches']['members'];
					//echo "<br>5. key: Process search results";
					echo "<br>---4. Process activity";

					foreach($emails as $emval) {
						if($emval['status']<>"subscribed") continue;
						//get activity link
						if(!isset($emval['_links'])) continue;
						if(count($emval['_links'])==0) continue;
						$emlinks = $emval['_links'];
						foreach($emlinks as $elink) {
							if($elink['rel']<>'activity') continue;
							$activity_link = $elink['href'];
							$activity_link = explode("/lists/", $activity_link);
							$activity_link = "/lists/".$activity_link[1];

							//get activities
							$mc_activities=array();
							try {
								$mc_activities = $objmc->get($activity_link);
							}catch(Exception $e) {$mc_activities=array();}
							//echo '<div style="display:none;">';print_r($mc_activities);echo '</div>';continue;
							if(!isset($mc_activities['activity'])) continue;
							if(count($mc_activities['activity'])==0) continue;
							$em_activities = $mc_activities['activity'];

							$save_time = 0;
							echo "<br>---4.1 Processing email activities SOC";
							//break;
							//Loop activities
							foreach($em_activities as $eact) {
								$activity_time = $eact['timestamp'];
								$activity_time = str_replace("T", " ", $activity_time);
								$activity_time = str_replace("+00:00", "", $activity_time); //echo " :: $activity_time ";
								$activity_time2 = strtotime($activity_time);
								$idate = date("Y-m-d",$activity_time2);
								//stop activity time before contact last crawl time
								if($activity_time2<=$contact_mailchimp_time) {
									echo "<br>---4.2. Updated activities";
									break;
								}
								//print_r($eact);
								//continue;
								//save mailchimp recent time
								if($save_time==0) {
									$cdata = array('mailchimp_last_time'=>$activity_time);
									$parent_id = $this->crm->save_contact($cdata,$eml->contact_id);
									$save_time=1;
								}
								//Sent event
								if($eact['action']=='sent'){
									//get campaign subject
									$email_viewed_subject = $eact['title'];
									if(isset($eact['campaign_id'])) {
										$mc_campaign=array();
										try{
											$mc_campaign = $objmc->get('campaigns/'.$eact['campaign_id'].'?fields=settings.subject_line');
										}catch(Exception $e) {$mc_campaign=array();}
										if(isset($mc_campaign['settings'])) {
											if(isset($mc_campaign['settings']['subject_line'])) 
												$email_viewed_subject = $mc_campaign['settings']['subject_line'];
										}
									}
									//task
									$taskdata = array(
												'task_subject'=>"Email Sent",
												'task_name'=>$email_viewed_subject,
												'task_priority'=>'Normal',
												'task_status'=>'Completed',
												'task_duedate'=>$idate,
												'task_related'=>'C',
												'task_relatedto'=>$eml->contact_id,
												'share_user_id'=>$userid,  
												'userid'=>$userid,  
												'task_created'=>$idate." 00:00:00",
												'task_modified'=>$idate." 00:00:00",
												'task_info'=>$email_viewed_subject
												);
									$tid = $this->crm->save_task($taskdata,0);

									$c=2;
									$s=1;
									$opt=1;
									$sec_val = $categories['category'][$c][$s];
									$sec_opt = $sec_val['options'];
									$points = $sec_opt[$opt]['points'];
									$pursuit = $sec_opt[$opt]['pursuit'];
									$iname = $sec_opt[$opt]['name'];


									//check points and save
									$where = array('contact'=>$eml->contact_id,'userid'=>$userid,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
									$cont_points = $this->crm->get_points($where);
									//print_r($cont_points);
									if($cont_points) {
										$update_data = array(
												'contact'=>$eml->contact_id,
												'userid'=>$userid,
												'cat'=>$c,
												'pdate'=>$idate,
												'rctype'=>'C'
												);
										$points_data = array(
												'intpoints'=>$cont_points['intpoints']+$points,
												'purpoints'=>$cont_points['purpoints']+$pursuit,
												'taskid'=>$tid
												);
										$this->crm->save_points($points_data,$update_data);
									} else {
										$points_data = array(
												'contact'=>$eml->contact_id,
												'userid'=>$userid,
												'rctype'=>'C',
												'pdate'=>$idate,
												'intpoints'=>$points,
												'purpoints'=>$pursuit,
												'taskid'=>$tid,
												'cat'=>$c
												);
										$this->crm->save_points($points_data);
									}
									//Interaction Usage
									//Subject line
									$subjectLine = $email_viewed_subject;
									$intr_sno=$c."-".$s."-".$opt;
									//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$scemail->sch_user);
									$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$eml->contact_id);
									$intrdata = $this->crm->check_interaction_date($where,$userid);
									if($intrdata) {
										$update = array('intr_count'=>$intrdata['intr_count']+1);
										//update email template info
										if($subjectLine) {
											if($intrdata['intr_info']) {
												$etinfo = json_decode($intrdata['intr_info']);										
												//Subject line							
												if(isset($etinfo->subjects)) {
													$etinfo->subjects->$tid=$subjectLine;
												} else {
													$etinfo->subjects=array($tid=>$subjectLine);
												}
												$etinfo = json_encode($etinfo);
											} else {
												$etinfo = array();
												//Subject line
												$etinfo['subjects']=array($tid=>$subjectLine);
												$etinfo = json_encode($etinfo);
											}
											$update['intr_info']=$etinfo;
										}
										$this->crm->save_interaction_date($update,$intrdata);
									} else {
										$update = array(
											'intr_cat'=>$c,
											'intr_sect'=>$s,
											'intr_opt'=>$opt,
											'intr_otype'=>'I',
											'intr_sno'=>$intr_sno,
											'intr_rctype'=>'C',
											'intr_recid'=>$eml->contact_id,
											'intr_task'=>$tid,
											'intr_user'=>$userid,
											'intr_date'=>$idate);
										//Insert Email template info
										if($subjectLine) {
											$etinfo = array();
											//Subject line
											$etinfo['subjects']=array($tid=>$subjectLine);
											$etinfo = json_encode($etinfo);
											$update['intr_info']=$etinfo;
										}	
										$this->crm->save_interaction_date($update);
									}

								}
								//click event 
								else if($eact['action']=='click') {
									$url = $eact['url'];
									//task
									$taskdata = array(
													'task_subject'=>'Link in email clicked',
													'task_name'=>'<a target="_blank" href="'.$url.'">'.$url.'</a>',
													'task_priority'=>'Normal',
													'task_status'=>'Completed',
													'task_duedate'=>$idate,
													'task_related'=>'C',
													'task_relatedto'=>$eml->contact_id,
													'share_user_id'=>$userid,
													'userid'=>$userid,
													'task_created'=>$idate." 00:00:00",
													'task_modified'=>$idate." 00:00:00",
													//'task_info'=>'They clicked a link in the email'
													'task_info'=>'The link clicked was <a href="'.$url.'" target="_blank">'.$url.'</a>'
													);
									$tid = $this->crm->save_task($taskdata,0);

									$c=2;
									$s=1;
									$opt=7;
									$sec_val = $categories['category'][$c][$s];
									$sec_opt = $sec_val['options'];
									$oname = $sec_opt[$opt]['name'];
									$points = $sec_opt[$opt]['points'];
									$pursuit = $sec_opt[$opt]['pursuit'];

									//Interaction Points
									$where = array('userid'=>$userid,'contact'=>$eml->contact_id,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
									$cont_points = $this->crm->get_points($where);
									if($cont_points) {
										$update_data = array(
												'userid'=>$userid,
												'contact'=>$eml->contact_id,
												'cat'=>$c,
												'pdate'=>$idate,
												'rctype'=>'C'
												);
										$points_data = array(
												'intpoints'=>$cont_points['intpoints']+$points,
												'purpoints'=>$cont_points['purpoints']+$pursuit,
												'taskid'=>$tid
												);
										$this->crm->save_points($points_data,$update_data);
									} else {
										$points_data = array(
												'userid'=>$userid,
												'contact'=>$eml->contact_id,
												'rctype'=>'C',
												'pdate'=>$idate,
												'intpoints'=>$points,
												'purpoints'=>$pursuit,
												'cat'=>$c,
												'taskid'=>$tid
												);
										$this->crm->save_points($points_data);
									}

									//Interaction Usage
									$intr_sno=$c."-".$s."-".$opt;
									//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$user_id);
									$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$eml->contact_id);
									$intrdata = $this->crm->check_interaction_date($where,$userid);
									if($intrdata) {
										$update = array('intr_count'=>$intrdata['intr_count']+1);
										//update email link info
										if($url) {
											if($intrdata['intr_info']) {
												$etinfo = json_decode($intrdata['intr_info']);
												if(isset($etinfo->elinks)) {
													$etinfo->elinks[]=$url;
												} else {
													$etinfo->elinks=array($url);
												}
												$etinfo->elinks = array_unique($etinfo->elinks);
												$etinfo = json_encode($etinfo);
											} else {
												$etinfo = array('elinks'=>array($url));
												$etinfo = json_encode($etinfo);
											}
											$update['intr_info']=$etinfo;
										}
										$this->crm->save_interaction_date($update,$intrdata);
									} else {
										$update = array(
											'intr_user'=>$userid,
											'intr_cat'=>$c,
											'intr_sect'=>$s,
											'intr_opt'=>$opt,
											'intr_otype'=>'I',
											'intr_sno'=>$intr_sno,
											'intr_rctype'=>'C',
											'intr_recid'=>$eml->contact_id,
											'intr_task'=>$tid,
											'intr_date'=>$idate);
										//Insert Email link info
										if($url) {
											$etinfo = array('elinks'=>array($url));
											$etinfo = json_encode($etinfo);
											$update['intr_info']=$etinfo;
										}	
										$this->crm->save_interaction_date($update);
									}
									
									//Save notification
									$update = array(
										'userid'=>$userid,
										'info'=>'<a href="'.base_url("crm/contacts/view/".$eml->contact_id).'">'.ucfirst($eml->user_first.' '.$eml->user_last).'</a> clicked the link <a target="_blank" href="'.$url.'">'.$url.'</a>',
										'datetime'=>$activity_time);
									$this->crm->save_email_notify($update);
								}
								//open event
								else if($eact['action']=='open') {
									//check campaign existance
									$campid = 'M'.$eact['campaign_id'].'C,';
									if($mce_cid) {
										$where = "value like '%$campid%'";
										$mce_cmprow = $this->home->getUserMetaCustomize($mce_key,$where,$userid);
										if($mce_cmprow) continue;										
										$n = $this->home->saveMailchimpCampaigns($campid,$mce_cid);
									} else {
										$oinsert = array('user_id'=>$userid,'field_type'=>$mce_key,'value'=>$campid);
										$mce_cid = $this->home->saveMailchimpCampaigns($oinsert);
									}

									//get campaign subject
									$email_viewed_subject = $eact['title'];
									if(isset($eact['campaign_id'])) {
										$mc_campaign=array();
										try{
											$mc_campaign = $objmc->get('campaigns/'.$eact['campaign_id'].'?fields=settings.subject_line');
										}catch(Exception $e) {$mc_campaign=array();}
										if(isset($mc_campaign['settings'])) {
											if(isset($mc_campaign['settings']['subject_line'])) 
												$email_viewed_subject = $mc_campaign['settings']['subject_line'];
										}
									}
									
									//save open task
									$taskdata = array(
													'task_subject'=>'Email opened',
													//'task_name'=>$template_name,
													'task_name'=>$email_viewed_subject,
													'task_priority'=>'Normal',
													'task_status'=>'Completed',
													'task_duedate'=>$idate,
													'task_related'=>'C',
													'task_relatedto'=>$eml->contact_id,
													'share_user_id'=>$userid,
													'userid'=>$userid,
													'task_created'=>$idate." 00:00:00",
													'task_modified'=>$idate." 00:00:00",
													'task_info'=>'They opened the email'
													);
									$tid = $this->crm->save_task($taskdata,0);
									$c=2;
									$s=1;
									$opt=5;
									$sec_val = $categories['category'][$c][$s];
									$sec_opt = $sec_val['options'];
									$oname = $sec_opt[$opt]['name'];
									$points = $sec_opt[$opt]['points'];
									$pursuit = $sec_opt[$opt]['pursuit'];	

									//Interaction Points
									$where = array('userid'=>$userid,'contact'=>$eml->contact_id,'cat'=>$c,'pdate'=>$idate,'rctype'=>'C');
									$cont_points = $this->crm->get_points($where);
									if($cont_points) {
										$update_data = array(
												'userid'=>$userid,
												'contact'=>$eml->contact_id,
												'cat'=>$c,
												'pdate'=>$idate,
												'rctype'=>'C'
												);
										$points_data = array(
												'intpoints'=>$cont_points['intpoints']+$points,
												'purpoints'=>$cont_points['purpoints']+$pursuit,
												'taskid'=>$tid
												);
										$this->crm->save_points($points_data,$update_data);
									} else {
										$points_data = array(
												'userid'=>$userid,
												'contact'=>$eml->contact_id,
												'rctype'=>'C',
												'pdate'=>$idate,
												'intpoints'=>$points,
												'purpoints'=>$pursuit,
												'cat'=>$c,
												'taskid'=>$tid
												);
										$this->crm->save_points($points_data);
									}


									//Interaction Usage
									$intr_sno=$c."-".$s."-".$opt;
									//$intrdata = $this->crm->check_interaction_date($intr_sno,$idate,$user_id);
									$where = array('intr_sno'=>$intr_sno,'intr_date'=>$idate,'intr_rctype'=>'C','intr_recid'=>$eml->contact_id);
									$intrdata = $this->crm->check_interaction_date($where,$userid);
									if($intrdata) {
										$update = array('intr_count'=>$intrdata['intr_count']+1);
										//update email template info
										if($email_viewed_subject) {
											if($intrdata['intr_info']) {
												$etinfo = json_decode($intrdata['intr_info']);
												//Subject line				
												if($email_viewed_subject) {
													if(isset($etinfo->subjects)) {
														$etinfo->subjects->$tid=$email_viewed_subject;
													} else {
														$etinfo->subjects=array($tid=>$email_viewed_subject);
													}	
												}					
												$etinfo = json_encode($etinfo);
											} else {
												$etinfo = array();
												//Subject line
												if($email_viewed_subject) $etinfo['subjects']=array($tid=>$email_viewed_subject);
												$etinfo = json_encode($etinfo);
											}
											$update['intr_info']=$etinfo;
										}
										$this->crm->save_interaction_date($update,$intrdata);
									} else {			
										$update = array(
											'intr_user'=>$userid,
											'intr_cat'=>$c,
											'intr_sect'=>$s,
											'intr_opt'=>$opt,
											'intr_otype'=>'I',
											'intr_sno'=>$intr_sno,
											'intr_rctype'=>'C',
											'intr_recid'=>$eml->contact_id,
											'intr_task'=>$tid,
											'intr_date'=>$idate);
										//Insert Email template info
										if($template_name) {
											$etinfo = array();
											//Subject line
											if($email_viewed_subject) $etinfo['subjects']=array($tid=>$email_viewed_subject);
											$etinfo = json_encode($etinfo);
											$update['intr_info']=$etinfo;
										}	
										$this->crm->save_interaction_date($update);
									}

									//Save notification
									$update = array(
										'userid'=>$userid,
										'info'=>'<a href="'.base_url("crm/contacts/view/".$eml->contact_id).'">'.ucfirst($eml->user_first.' '.$eml->user_last).'</a> opened email "'.trim($email_viewed_subject).'"',
										'datetime'=>$activity_time);
									$this->crm->save_email_notify($update);
								}
							}
						}

						
					}
				}
				//end of USER CONTACT EMAIL PROCESS FOR TRACKING

				$completed_emails += count($useremails);
			}
			//end of WHILE LOOPING FOR USER EMAILS
			
			
		}
		$ts2 = time();
		echo "<br />Time 2. $ts2 ";
		$seconds_diff = $ts2 - $ts1;                            
		echo "<br />Seconds 3. $seconds_diff";
		echo "<br>DONE";
	}

	//Tracking webhook
	public function tracking()
	{	
		echo "TRACKING.";
	}

//--------------------------------------------------------------

}

/* End of file mailchimpevents.php */

/* Location: ./application/controllers/mailchimpevents.php */