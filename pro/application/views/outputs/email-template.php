<?php $this->load->view('common/meta_outputs');

?>

<title><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></title>

</head>

<body>

<div id="content">

	

	<?php 

		$url = current_url();

		$templatename_ref = end(explode('/',$url));

		if($action != 'download' && $uCustTemplate['template_type']<>'Voicemail Scripts'){

	?>

	<div class="sendtosalesforce">

    	Send this email through: <a href="<?php echo base_url().($uCustTemplate['template_type']=='Interview Emails'?'interviewer':'crm')."/compose/t".$template_sections[0]->content_id;?>" title="Send this Email">SalesScripter</a> | 

    	<a href="https://chrome.google.com/webstore/detail/salesscripter/lmdokmfkjfkddpgelnihilnkgdhajihb?hl=en" target="_blank" title="Send this Email">Gmail</a> | 

        <a target="_blank" href="https://salesscripter.com/pro/page1.php?template=<?php echo $templatename_ref;?>" title="Send to Salesforce">Salesforce</a>

        

    	<?php /*?><a target="_blank" href="https://salesscripter.com/pro/page1.php?template=<?php echo $templatename_ref;?>" title="Send to Salesforce"><img src="<?php echo base_url();?>images/icons/download1.png"/></a><?php */?>

    </div>

    <?php } ?>

	<?php if($action != 'download'){?>

		<?php echo $this->load->view('common/logo');?>

	<?php } ?>

	<h1 align="center"><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></h1>

	<p class="topTxt"  >

		<?php echo $P_Q1->value; ?>  for 

		<?php 

			if($campaign_info->campaign_target == '1'){	

					 echo $campaign_info->individual;

				}else{ 

					echo $campaign_info->organization;

			}

		?>

	</p>

    <?php if($action != 'download' && $action!='download2') {

		include_once('interactive/go-through-button.php');

    }?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">

		<tr><td><hr class="hrline" /></td></tr>
		<?php if($uCustTemplate['template_type']=='Interview Emails' || $uCustTemplate['template_type']=='Emails and Letters'){?>
		<tr><td><a href="<?php echo base_url().($uCustTemplate['template_type']=='Interview Emails'?'interviewer':'crm')."/compose/t".$template_sections[0]->content_id;?>" title="Send this Email" style="margin-bottom: 8px;width: 40px;" class="buttonM bBlue">Send</a></td></tr>
		<?php }?>
		<tr>

			<td>

		        <?php 

					if(!empty($template_content)) {

						$sno=0;

						foreach($template_content as $tpldata) {

							//if($uCustTemplate['temp_no']==68) 

							{

								$sno++;

								if($sno>1)echo '<p><strong>Email #'.$sno.' - '.$tpldata->sect_title.'</strong></p>';

								if($sno>1)echo '<p><strong>Schedule Delivery: '.$tpldata->sect_dowcount.' '.($tpldata->sect_dow==1?'Day':'Week').($tpldata->sect_dowcount==1?'':'s').'</strong></p>';

								echo '<p><strong>Subject line:</strong>'.$tpldata->sect_subject.'</p>';

							}

							$email_content = $tpldata->sect_content;

							//$email_content = str_replace('[Email Signature]',$email_signature,$email_content);
							
							
							$ced_esign = $aMember['email_signature'];
							$where = array();
							$where['user_id'] = $user_id;
							$where['field_type'] = 'smtp';
							$user_info = $this->home->getUserData($where);
							if($user_info && isset($user_info[0]))
							{
								$k = unserialize($user_info[0]->value);
								if(isset($k['email_signature']) && $k['email_signature'])
								{
									$ced_esign =  $k['email_signature'];
								}
							}
							$email_signature = $ced_esign;

							$email_content = str_replace('{email signature}',$email_signature,$email_content);

							echo $email_content;

							//if($uCustTemplate['temp_no']==68) 

							echo '<hr />';

							//Email template task
							if(isset($email_tasks[$tpldata->temp_aid])) {	
								$subemail_tasks = $email_tasks[$tpldata->temp_aid];	
								foreach($subemail_tasks as $etask) {
									$template_task = "<p><b>Follow-Up Task</b></p>";
	                                if($etask->task_duedate) {
	                                    $task_duedate_parts = explode("-",$etask->task_duedate);
	                                	$template_task .= "<p><b>Schedule Timing:</b> ".$task_duedate_parts[1].' '.($task_duedate_parts[0]==1?'Day':'Week').($task_duedate_parts[1]<>1?'s':'')."</p>";
	                                }
	                                if($etask->task_subject) $template_task .= "<p><b>Task Type:</b> ".$etask->task_subject."</p>";
	                                if($etask->task_info) {
	                                	//$taskinfo = explode("\n", $etask->task_info);
	                                	$taskinfo = str_replace("\n", "<br />", $etask->task_info);
	                                	$template_task .= "<p><b>Notes:</b> ".$taskinfo."</p>";
	                                }
	                                if($template_task) echo $template_task."<hr />";	
								}														
							}

						}

					} else if(!empty($template_sections)) {

						foreach($template_sections as $tsection) {	

							$content_id=$tsection->content_id;

							include('custom_content/custom_etemplate_data.php');

							//if($uCustTemplate['temp_no']==68 || $uCustTemplate['temp_no']==69 || $uCustTemplate['temp_no']==70 || $uCustTemplate['temp_no']==71) echo '<hr />';
							
							if($uCustTemplate['temp_no']==68 || $uCustTemplate['temp_no']==69 || $uCustTemplate['temp_no']==70 || $uCustTemplate['temp_no']==71 || $uCustTemplate['temp_no']==81 || $uCustTemplate['temp_no']==83 || $uCustTemplate['temp_no']==84 || $uCustTemplate['temp_no']==85 || $uCustTemplate['temp_no']==86 || $uCustTemplate['temp_no']==87) echo '<hr />';

						}

					}

				?>

			</td>

		</tr>

		

	</table>

</div>	

<?php echo $this->load->view('common/footer_outputs');?> 