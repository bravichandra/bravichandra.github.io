<?php $this->load->view('common/meta_outputs');?>
<title>VOICEMAIL SCRIPT</title>
</head>

<body>

<div id="content">
<?php echo $this->load->view('common/logo');?>
<h1 align="center">VOICEMAIL SCRIPT</h1>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
					<td><strong>Value Message</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> This message is structured to primarily share the technical and business value offered to try to educate the prospect and trigger interest and curiosity.</p>
						<p><strong>Message:</strong> Hello <span class="dynamic_value">[Prospect First Name]</span>, this is 
				      	<span>[Insert Name]</span> 
				      	 calling from 
				      	<span>[Insert Company]</span> and we help 
				      	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
				      	<span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.</p>
				        <p>Purpose for my call is that we work with 
				        <span class="dynamic_value">[Prospect's title]</span> and help them to 
				        <span class="<?php echo (!empty($summary['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['1']->user_data_id) ? $summary['1']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['1']->value) ? $summary['1']->value : Null);?></span>.</p>
				        <p>I will try you again in a few weeks. If you would like to reach me in the meantime, my number is 
				        <span class="dynamic_value edit_area">[Insert Phone Number]</span>.</p>
				        <p>Again, this is <span>[Insert Name]</span> calling from 
				        <span>[Insert Company]</span>, 
				        <span>[Insert Phone Number]</span>.</p>
				        <p>Thanks and I look forward to talking with you soon.</p>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Pain Message</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> This message is structured to primarily share the technical and business value offered to try to educate the prospect and trigger interest and curiosity.</p>
				      	<p><strong>Message:</strong> Hello <span class="dynamic_value">[Prospect First Name]</span>, this is 
				      	<span>[Insert Name]</span> calling from 
				      	<span>[Insert Company]</span> and we help 
				      	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
				      	<span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.</p>
				        <p>Purpose for my call is that we work with <span class="dynamic_value">[Prospect's title]
				        </span> and they often express challenges with
				        <?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT'); ?>
										<?php if(isset($technical_data)):?>
											<?php foreach ($technical_data as $technical):?>
												<span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo $technical->value;?></span>,
											<?php endforeach;?>
										<?php endif?>
							<?php endforeach;?>
						<?php endif;?> 
				        <!-- <span class="<?php echo (!empty($target[6]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['6']->user_data_id) ? $target['6']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['6']->value) ? $target['6']->value : NULL);?></span>, 
				        <span class="<?php echo (!empty($target[7]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['7']->user_data_id) ? $target['7']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['7']->value) ? $target['7']->value : NULL);?></span>, and 
				        <span class="<?php echo (!empty($target[8]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['8']->user_data_id) ? $target['8']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['8']->value) ? $target['8']->value : NULL);?></span> -->.</p>
				        <p>I don't know if you are experiencing any of those same challenges and that is why I am reaching out to you as we help to resolve those.</p>
				        <p>I will try you again in a few weeks. If you would like to reach me in the meantime, my number is <span class="dynamic_value edit_area" id="edit_phone__users">[Insert Phone Number]</span>.</p>
				        <p>Again, this is <span>[Insert Name]</span> calling from 
				        <span>[Insert Company]</span>, 
				        <span>[Insert Phone Number]</span>.</p>
				        <p>Thanks and I look forward to talking with you soon.</p>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Building Interest Message</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> This message is structured to try to trigger interest and curiosity by using some of the building interest points.</p>
				      	<p><strong>Message:</strong> Hello <span class="dynamic_value">[Prospect First Name]</span>, this is 
				      	<span>[Insert Name]</span> calling from 
				      	<span>[Insert Company]</span> and we help 
				      	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
				      	<span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.</p>
				        <p>We do that through our <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['0']->user_data_id) ? $custome_fields['0']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['0']->value) ? $custome_fields['0']->value : Null);?></span> and we differ from other options out there are
				        <?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>
									<?php if(isset($detail_bus_data)):?>
											<?php foreach ($detail_bus_data as $detail_bus):?>
												<span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span>,
											<?php endforeach;?>
									<?php endif?>
							<?php endforeach;?>
						<?php endif;?>
						</p>
				        <p>II will try you again in a few weeks. If you would like to reach me in the meantime, my number is 
				        <span>[Insert Phone Number]</span>.</p>
				        <p>Again, this is <span>[Insert Name]</span> calling from 
				        <span>[Insert Company]</span>, <span>[Insert Phone Number]</span>.</p>
				        <p>Thanks and I look forward to talking with you soon.	</p>
						<br>
					</td>
				</tr>
				<tr>
					<td><strong>Product Message</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> This message is structured to try to trigger interest and curiosity by using some of the building interest points.</p>
				      	<p><strong>Message:</strong> Hello <span class="dynamic_value edit_area">[Prospect First Name]</span>, this is 
				      	<span>[Insert Name]</span> calling from 
				      	<span>[Insert Company]</span> and we provide 
								<span class="<?php echo (!empty($custome_fields['0']->user_data_id) ? 'dynamic_value edit_area' : 'dynamic_value edit_area');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $custome_fields['0']->user_data_id;?>__users__tud"><?php echo (!empty($custome_fields['0']->value) ? $custome_fields['0']->value : Null);?></span>
				        <p>We do that through our <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['0']->user_data_id) ? $custome_fields['0']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['0']->value) ? $custome_fields['0']->value : Null);?></span> and we differ from other options out there are
				        <?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>
									<?php if(isset($detail_bus_data)):?>
											<?php foreach ($detail_bus_data as $detail_bus):?>
												<span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span>,
											<?php endforeach;?>
									<?php endif?>
							<?php endforeach;?>
						<?php endif;?>
						</p>
				        <p>I will try you again in a few weeks. If you would like to reach me in the meantime, my number is <span class="dynamic_value edit_area">[Insert Phone Number]</span>.</p>
				        <p>Again, this is <span>[Insert Name]</span></span> calling from 
				        <span>[Insert Company]</span>, 
				        <span>[Insert Phone Number]</span>.</p>
				        <p>Thanks and I look forward to talking with you soon.</p>
						<br>
					</td>
				</tr>
		</table>
<?php echo $this->load->view('common/footer_outputs');?>
 