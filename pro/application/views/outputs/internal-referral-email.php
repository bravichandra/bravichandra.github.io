<?php $this->load->view('common/meta_outputs');?>
<title>Internal Referral Email</title>
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
<h1 align="center">Internal Referral Email</h1>	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">		
<tr>
<td class="border">&nbsp;</td>
</tr>	
<tr>			
	<td>		        
		<p><strong>Subject line:</strong> 		        
		<span>Appropriate person</span>		        
		</p>		        
		<p><strong>Email body:</strong></p>		       
		<p>Hi <span class="dynamic_value">[Prospect First Name]</span>,</p>	
		<p>I hope this finds you well. I am reaching out to you in the hopes of finding the appropriate person who handles <span class="red-area"> [Insert the functional area that serve or sell to – ex: payroll, data backup, employee training]. Optional name drop) </span>- I also wrote to [Internal contact 1], [Internal contact 2] and [Internal contact 3] in regards to this. </p>

		<p>If you are the right person to speak with, let me know how your calendar looks. I am available next Tuesday morning and Thursday afternoon. If you are not, any help in pointing me in the right direction would be greatly appreciated.</p>
		<p>Best Regards,</p>		       
		<p>                            
			<span><?php echo $company_meta['your_name'] ?></span>  <br />
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