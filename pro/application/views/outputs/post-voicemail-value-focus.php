<?php $this->load->view('common/meta_outputs');?>
<title>Post-Voicemail Email – Value Focus</title>
</head>
<body>
<div id="content">
<?php $this->load->view('common/logo');?>

<h1 align="center">Post&#45;Voicemail Email &#45; Value Focus</h1>
<p class="topTxt"><strong>Description:</strong>This email is designed to be sent to the prospect right after you leave a voicemail message and to be used when leaving the voicemail message that has a value focus.</p>  
<br>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
			<tr>
				<td>
					<p><strong>Subject Line:</strong><span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : $this->config->item('message'));?></span></p>
					<p><strong>Email Body:</strong></p>
					<p>Hello [Prospect First Name],</p>
						
					
					<p>As I mentioned on a voicemail that I just left you, I am with [Your Company] and we help  <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : 'businesses');?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span>  to <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : $this->config->item('message'));?></span>. I actually do not know if you all need what we provide and that is why I was calling you with a question or two.</p>
					<p>I actually do not know if you all are concerned about any of those areas and that is why I was calling you with a question or two.</p>
					<p>I will try to give you a call next week. If you are interested in talking more about your challenges and learning about what value and insight we have to offer, I can schedule a <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (!empty($sales_process[0]->value) ? $sales_process[0]->value : '');?></span> next Tuesday or Thursday morning where we can <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (!empty($sales_process[1]->value) ? $sales_process[1]->value : '');?></span>.</p>
					<p>Best Regards,</p>
						
					<p>
						[Your Name]<br>
						[Your Title]<br>
						[Your Company]<br>
						[Your Phone Number]<br>
						[Your Email Address]</p>
				</td>
			</tr>
	</table>
		
<?php $this->load->view('common/footer_outputs');?>
 