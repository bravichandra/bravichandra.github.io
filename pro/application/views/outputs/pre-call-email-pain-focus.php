<?php $this->load->view('common/meta_outputs');?>
<title>Pre-Call Email – Pain Focus</title>
</head>
<body>
<div id="content">
<?php echo $this->load->view('common/logo');?>
	<h1 align="center">Pre&#45;Call Email &#45; Pain Focus</h1>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p><strong>Description:</strong> This email is the first contact attempt with the prospect and designed to be an introduction that provides a little information to at least make a future cold call warmer if there is not response to the email. It is designed to be brief and primarily communicate technical and business pain points to try to capture attention and interest.</p>
		        <p><strong>Timing:</strong> This email should be sent around 3 to 5 business days before a call is made to the prospect.</p>
		        <p><strong>Subject line:</strong> 
		        
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
		        
		        <p><strong>Attachment:</strong> Ideal to attach a company or product brochure/datasheet</p>
		        
		        <p><strong>Email body:</strong></p>
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        
		        <p>To quickly introduce myself, I am with  
		        <span>[Your Company]</span> and we help
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.</p>
		        
		        <p>Reason for the email is that we find that it is very common for organizations like yours to face challenges with 
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
				</p>
		        
		        <p>I actually don't know if you are concerned with any of those and that is why I am reaching out to you. </p>
		        <p>I will try to give you a call next week. If you are interested in talking before then, 
		        I can schedule a 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span> 
		         next Tuesday or Thursday morning where we can  
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>.</p>
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
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 