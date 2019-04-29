<?php $this->load->view('common/meta_outputs');?>
<title>Post-Voicemail Email – Name Drop Focus</title>
</head>
<body>

<div id="content">
		<?php
		$url = current_url();
		$templatename_ref = end(explode('/',$url));
		if($action != 'download'){
		?>
		<div class="sendtosalesforce"><a target="_blank" href="http://salesscripter.com/pro/page1.php?template=<?php echo $templatename_ref;?>" title="Send to Salesforce"><img src="http://salesscripter.com/pro/images/icons/download1.png"/></a></div>
		<?php } ?>
		<?php if($action != 'download'){?>
			<?php 	$this->load->view('common/logo');?>
		<?php } ?>
		<h1 align="center">Post&#45;Voicemail Email &#45; Name Drop Focus</h1>
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

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
			<tr><td class="border">&nbsp;</td></tr>
			<tr>
				<td>
					<p><strong>Subject:</strong> Following up my voicemail - <?php 
					  echo $company_info->company_name ; ?>
					</p>
					
					<p>Hello [Prospect First Name],</p>
					<p>As I mentioned in a voicemail I just left you, I am with <?php echo $company_info->company_name; ?> and we help to 
						<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
						?> to  <?php echo $campaign_tech_summary->value ?>.
					</p>
					
					<p>Reason for the email is that we worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided  <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to  <?php  echo  $active_name_drop_exp['provided']->value; ?>,  which led to <?php  echo  $active_name_drop_exp['when']->value; ?> .</p>
					
					<p>I don't know if you are interested in any of those improvements and that is why I am reaching out to you. I will try to give you a call next week.</p>
					<p>If you are interested in talking before then, I can schedule a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				
					<p>Best Regards,</p>
					
					<p>
						<span><?php echo $company_meta['your_name'] ?></span><br />
						<span><?php echo $company_meta['your_title'] ?></span> <br />
						<span><?php echo $company_info->company_name ?></span> <br />
						<span><?php echo $company_meta['your_phone'] ?></span> <br />
						<span><?php echo $company_meta['your_email'] ?></span> <br />
					</p>
				</td>
			</tr>
		</table>
		</div>
<?php $this->load->view('common/footer_outputs');?>
 