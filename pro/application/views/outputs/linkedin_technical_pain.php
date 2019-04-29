<?php $this->load->view('common/meta_outputs');
?>
<title>LinkedIn Connection Accept Follow-Up - Pain Focus</title>
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
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">LinkedIn Connection Accept Follow-Up - Pain Focus</h1>
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
		        <p><strong>Subject line:</strong> 
					Thanks for connecting
		        <?php 
				 // echo $campaign_tech_summary->value; ?>
		        </p>		        
		        
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        
		        <p>Thank you for connecting, I came across your profile because I work a lot with
					 <span class="red-area">[insert contact's title]</span>
					and I know that they often express concerns with:
				
					<ul>
						<?php if(isset($campaign_output_tech_pain)){
							foreach($campaign_output_tech_pain as $comp){
							?>
								<li>
									<?php echo $comp->value ?>
								</li>
							<?php 
							}
						}
						?>
					</ul>
				</p>
		        
		        <p>If you are concerned with any of those, we might be able to have a productive conversation as those are the types of challenges that we help to resolve.</p>
				<p>Let me know if you want to put a brief conversation on the calendar. I would be very interested in learning more about what you all are doing.</p>
		        <p>Look forward to possibly talking with you.</p>
		        <p>
		        	<span><?php echo $company_meta['your_name'] ?></span>
		            
		        </p>
		        <br />
			</td>
		</tr>
		
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 