<?php $this->load->view('common/meta_outputs');?>
<title>Pre-Call Email – Value Focus</title>
</head>
<body>
<div id="content">
<?php echo $this->load->view('common/logo');?>
	<h1 align="center">Pre&#45;Call Email &#45; Value Focus</h1>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p><strong>Description:</strong> This email is the first contact attempt with the prospect and designed to be an introduction that provides a little information to at least make a future cold call warmer if there is not response to the email. It is designed to be brief and primarily communicate technical and business value points to try to capture attention and interest.</p>
		        <p><strong>Timing:</strong> This email should be sent around 3 to 5 business days before a call is made to the prospect.</p>
		        <p><strong>Subject line:</strong> <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span></p>
		        <p><strong>Attachment:</strong> Ideal to attach a company or product brochure/datasheet or you could attach a different document now like a case study talking about one of your clients.</p>
		        <p><strong>Email body:</strong></p>
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        <p>To quickly introduce myself, I am with  
		        <span>[Your Company]</span> and we help 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.</p>
		        <p>
		        	From our research and what has been discussed, it sounds like there is the strong potential to have a productive conversation as we help 
		        	<span class="<?php echo (!empty($custome_fields['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : $this->config->item('message'));?></span> 
		        	to 
		        	<span class="<?php echo (!empty($summary['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['1']->user_data_id) ? $summary['1']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['1']->value) ? $summary['1']->value : Null);?></span>. 
				</p>
		        <p>I actually don't know if you need what our services provide and that is why I am reaching out to you.
		         </p>

				<p>I will try to give you a call next week. If you are interested in talking more about your challenges and learning about what value and insight we have to offer, I can schedule a <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span>  next Tuesday or Thursday morning where we can <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>.</p>
		        <p>Best Regards,</p>
		        <p>
		        	<span>[Your Name]</span><br/>
		            <span>[Your Title]</span> <br/>
		            <span>[Your Company]</span> <br/>
		            <span>[Your Phone Number]</span> <br/>
		            <span>[Your Email Address]</span> <br/>
		        </p>
		        <br>
			</td>
		</tr>
		
	</table>
	
<?php echo $this->load->view('common/footer_outputs');?> 