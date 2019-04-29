<?php $this->load->view('common/meta_outputs');?>
<title>Voicemail Script - Value Focus</title>
</head>
<body>
<div id="content">
<?php $this->load->view('common/logo');?>

<h1 align="center">Voicemail Script &#45; Value Focus</h1>
<br>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
			<tr>
				<td>
					<p>Hello [Prospect Name], this is [Your Name] from [Your Company].</p>
					<p>Purpose for my call is that we help <span class="<?php echo (!empty($custome_fields['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : $this->config->item('message'));?></span> to <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : $this->config->item('message'));?></span>. I actually do not know if you all need what we provide and that is why I was calling you with a question or two.</p>
					<p>I will try you again next week. If you would like to reach me in the meantime, my number is [Your Number].</p>
					<p>Again, this is [Your Name] calling from [Your Company], [Your Number].</p>
					<p>Thank you and I look forward to talking with you soon.</p>
				</td>
			</tr>
	</table>
		
<?php $this->load->view('common/footer_outputs');?>
 