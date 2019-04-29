<?php $this->load->view('common/meta_outputs');?>
<title>Voicemail Script – Value Focus (Appointment)</title>
</head>
<body>

<div id="content">
<?php $this->load->view('common/logo');?>
<h1 align="center">Voicemail Script &#45; Value Focus (Appointment)</h1>
<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
					<td>
						<p>Hello [Prospect Name], this is [Your Name] from [Your Company].</p>
						<p>The purpose of my call is to set up a 15 to 20 minute call with you to discuss how we might be able to help you to <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : $this->config->item('message'));?></span> and <span class="<?php echo (!empty($summary['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['1']->user_data_id) ? $summary['1']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['1']->value) ? $summary['1']->value : $this->config->item('message'));?></span>.</p>
						<p>Please let me know if next Tuesday or Thursday at 10AM or 2PM would be best for such a phone call.  You can reach me at [Your Number].</p>
						<p>Again, this is [Your Name] calling from [Your Company], [Your Number]. </p>
						<p>Thank you and I look forward to talking with you soon.</p>
					</td>
				</tr>
		</table>
<?php $this->load->view('common/footer_outputs');?>
 