<?php $this->load->view('common/meta_outputs');?>
<title>Post-Voicemail Email – Product Focus</title>
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
	<h1 align="center">Post &#45; Voicemail Email &#45; Product Focus</h1>
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
				<p><strong>Subject line:</strong>  Following up my voicemail - <?php  echo $company_info->company_name; ?>  </p>
		        
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        <p>As I mentioned in a voicemail I just left you, I am with 
					<span><?php  echo $company_info->company_name; ?> </span>

					and we help to 
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>to <?php echo $campaign_tech_summary->value ?>.
				</p>
		        <p>We do this by providing <?php echo $P_Q1->value; ?> which <?php echo $product_desc->value; ?>.</p>
				<p>
					Some ways that we differ from other options out there:<?php /*?> are <?php echo $diff1->value; ?>  <?php echo $diff2->value; ?>, and <?php echo $diff3->value; ?><?php */?>
				</p>
                <ul>
                	<li><?php echo $diff1->value; ?></li>
                    <li><?php echo $diff2->value; ?></li>
                    <li><?php echo $diff3->value; ?></li>
                </ul>
				<?php /*?><p>We worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?> and this led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>
		        <p>I don't know if you are interested in any of those improvements and that is why I am reaching out to you. I will try to give you a call next week. </p><?php */?>
				<p><?php /*?>If you are interested in talking before then, I can schedule<?php */?>Are you interested in a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
		        <p>Best Regards,</p>
		        <p>
		        	<span> <?php echo $company_meta['your_name']; ?> </span>  <br />
		            <span> <?php echo $company_meta['your_title']; ?> </span> <br />
		            <span> <?php echo $company_info->company_name; ?> </span> <br />
		            <span> <?php echo $company_meta['your_phone']; ?> </span> <br />
		            <span> <?php echo $company_meta['your_email']; ?> </span> <br />
		        </p>
			</td>
		</tr>
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 