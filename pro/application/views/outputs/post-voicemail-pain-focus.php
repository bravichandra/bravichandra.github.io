<?php $this->load->view('common/meta_outputs');?>
<title>Post-Voicemail Email – Pain Focus</title>
</head>
<body>

<div id="content">
<?php $this->load->view('common/logo');?>
<h1 align="center">Post&#45;Voicemail Email &#45; Pain Focus</h1>
<p class="topTxt"><strong>Description:</strong>This email is designed to be sent to the prospect right after you leave a voicemail message and to be used when leaving the voicemail message that has a pain focus.</p>    
<br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
					<td>
						<p><strong>Subject Line:</strong>
						<?php if (isset($products)):?>
						<?php $counter=0;foreach ($products as $product):?>
							<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT'); ?>
									<?php if(isset($technical_data)):?>
										<?php if($counter == '0'):?>
											<span class="<?php echo (!empty($technical_data[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical_data[0]->id;?>__tech_pain__tpd"><?php echo $technical_data[0]->value;?></span>
										<?php endif;?>
									<?php endif;?>
						<?php $counter++; endforeach;?>
						<?php endif;?> 
						</p>
						<p><strong>Email Body:</strong></p>
						<p>Hello [Prospect First Name],</p>
						<p>As I mentioned on a voicemail that I just left you, I am with [Your Company] and I am reaching out to you as we work with a lot of businesses like yours and they often have some of the following challenges:</p>
						<ul>
						<?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT'); ?>
								<?php $detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');?>
										<?php if(isset($technical_data)):?>
											<?php foreach ($technical_data as $technical):?>
												<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo $technical->value;?></span></li><?php } ?>
											<?php endforeach;?>
										<?php endif?>
										<?php if (!empty($detail_tech_data)):?>
											<?php foreach ($detail_tech_data as $detail_tech):?>
												<?php if(!empty($detail_tech->value)) { ?><li><span class="<?php echo (!empty($detail_tech->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech->id;?>__desc_tech_pain__tpd"><?php echo $detail_tech->value;?></span></li><?php } ?>
											<?php endforeach;?>
										<?php endif;?>
							<?php endforeach;?>
						<?php endif;?> 
						</ul>
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
 