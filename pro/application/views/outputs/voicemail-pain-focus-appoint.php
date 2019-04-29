<?php $this->load->view('common/meta_outputs');?>
<title>Voicemail Script – Pain Focus (Appointment)</title>
</head>
<body>

<div id="content">
<?php $this->load->view('common/logo');?>
<h1 align="center">Voicemail Script &#45; Pain Focus (Appointment)</h1>
<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
					<td>
						<p>Hello [Prospect Name], this is [Your Name] from [Your Company].</p>
						<p>Purpose for my call is that we find that many <span class="<?php echo (!empty($custome_fields['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : $this->config->item('message'));?></span> have challenges with:</p>
						<p class="red-area">(Share up to three of below pain points)</p>
						<ul>
						<?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT'); ?>
										<?php if(isset($technical_data)):?>
											<?php foreach ($technical_data as $technical):?>
												<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo $technical->value;?></span></li><?php } ?>
											<?php endforeach;?>
										<?php endif?>
							<?php endforeach;?>
						<?php endif;?> 
						</ul>
						<p>We help to resolve those and that is why I was calling you set up a 15 to 20 minute call to discuss.</p>
						<p>Please let me know if next Tuesday or Thursday at 10AM or 2PM would be best for such a phone call.  You can reach me at [Your Number].</p>
						<p>Again, this is [Your Name] calling from [Your Company], [Your Number].</p>
						<p>Thank you and I look forward to talking with you soon.</p>
					</td>
				</tr>
		</table>
<?php $this->load->view('common/footer_outputs');?>
 