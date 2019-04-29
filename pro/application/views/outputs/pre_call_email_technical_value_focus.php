<?php $this->load->view('common/meta_outputs');
?>
<title>Pre-Call Email – Value Focus</title>
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
	<h1 align="center">Pre-Call Email – Value Focus</h1>
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
		        
		        <?php 
				echo $campaign_tech_summary->value; ?>
		        </p>		        
		        
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        
		        <p>To quickly introduce myself, I am with   
					<span><?php echo $company_info->company_name ?></span> and we help  
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?> to:<?php /*?> deal with <?php echo  $campaign_output_tech_pain[0]->value ; ?>.<?php */?>
				</p> 
		        
		        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
				</p>
		        
		        <p>I don’t know if you are interested in any of those and that is why I am reaching out to you. I will try to give you a call next week.  </p>
				<p>If you are interested in talking before then, I can schedule a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
		        <p>Best Regards,</p>
		        <p>
		        	<span><?php echo $company_meta['your_name'] ?></span><br />
		            <span><?php echo $company_meta['your_title'] ?></span> <br />
		            <span><?php echo $company_info->company_name ?></span> <br />
		            <span><?php echo $company_meta['your_phone'] ?></span> <br />
		            <span><?php echo $company_meta['your_email'] ?></span> <br />
		        </p>
		        <br>
			</td>
		</tr>
		
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 