<?php $this->load->view('common/meta_outputs');
?>
<title>Last Attempt Email - Value</title>
</head>
<body>
<div id="content">
	<?php
		$url = current_url();
		$templatename_ref = end(explode('/',$url));
		if($action != 'download'){
	?>
	<div class="sendtosalesforce"><a target="_blank" href="http://salesscripter.com/pro/page1.php?template=<?php echo $templatename_ref;?>" title="Send to Salesforce"><img src="http://salesscripter.com/launch/images/icons/download1.png"/></a></div>
    <?php } ?>
	<?php if($action != 'download'){?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">Last Attempt Email - Value</h1>
	
	<p class="topTxt">
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
		        <p><strong>Subject line:</strong> 
					<?php // echo $campaign_per_summary->value; ?>
					Checking In 
		        </p>
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
				<ul>
					<?php if(isset($campaign_output_tech_val)){
						foreach($campaign_output_tech_val as $comp){
						?>
							<li>
								<?php echo $comp->value ?>
							</li>
						<?php 
						}
					}
					?>
				</ul>
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file. </p>
		        <p>No problem if that is the direction you prefer.</p>
				<p>Best Regards,</p>
		        <p>
		        	<span><?php echo $company_meta['your_name'] ?></span><br/>
		            <span><?php echo $company_meta['your_title'] ?></span> <br/>
		            <span><?php echo $company_info->company_name ?></span> <br/>
		            <span><?php echo $company_meta['your_phone'] ?></span> <br/>
		            <span><?php echo $company_meta['your_email'] ?></span> <br/>
		        </p>
		        <br>
			</td>
		</tr>
		
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 