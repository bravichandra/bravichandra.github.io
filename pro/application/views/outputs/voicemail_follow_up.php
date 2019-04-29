<?php $this->load->view('common/meta_outputs');?>
<title>VOICEMAIL FOLLOW-UP EMAIL</title>
</head>

<body>

<div id="content">
<?php echo $this->load->view('common/logo');?>
	<h1 align="center">Post-Voicemail Email Thread</h1>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr>
			<td><strong>Email #1</strong></td>
		</tr>
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p><strong>Description:</strong> This first email is designed as a follow-up email after leaving a voicemail message for a prospect that you were cold calling and have never spoken with.</p>
		        <p>This first email is designed to be brief and primarily communicate technical and business pain points to try to capture attention and interest. There is not much information provided as we will start to share more information spread across the next two emails.</p>
		        
		        <p><strong>Timing:</strong> This email should be sent immediately after phone conversation.</p>
		        
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
		        
		        <p>As I mentioned in a voicemail that I just left you, I am with 
		        <span>[Your Company]</span> and we help 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>.</p>
		        
		        <p>We find that it is very common for organizations like yours to face challenges with
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
		        
		        <p>This can often lead to 
		        <span class="<?php //echo (!empty($ideal_prospects->IP_11) ? 'dynamic_value edit_area' : '');?>" id="edit_IP_11__ideal_prospects"><?php //echo (!empty($ideal_prospects->IP_11) ? $ideal_prospects->IP_11 : $this->config->item('message'));?></span>, 
		        <span class="<?php //echo (!empty($ideal_prospects->IP_12) ? 'dynamic_value edit_area' : '');?>" id="edit_IP_12__ideal_prospects"><?php //echo (!empty($ideal_prospects->IP_12) ? $ideal_prospects->IP_12 : $this->config->item('message'));?></span>, or 
		        <span class="<?php //echo (!empty($ideal_prospects->IP_13) ? 'dynamic_value edit_area' : '');?>" id="edit_IP_13__ideal_prospects"><?php //echo (!empty($ideal_prospects->IP_13) ? $ideal_prospects->IP_13 : $this->config->item('message'));?></span>. We help to decrease and offset those challenges and that is the purpose for my call.</p>
		        
		        <p>We help to decrease and offset those challenges and that is the purpose for my call.</p>
		        <p>Are you available to put a 		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span> next Tuesday or Thursday morning where we can 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>?</p>
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
		<tr>
			<td><strong>Email #2</strong></td>
		</tr>
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p><strong>Description:</strong> This second email is designed follow-up again with the prospect if there was no reply to the first or contact made. This email is also designed to be brief and build on what has already been sent over by providing a little more information.</p>
		        <p>While the first email centered around pain, this email is structured to emphasis the value that you offer.</p>
		        
		        <p><strong>Timing:</strong> This email should be sent two weeks after the first email if there has been no direct contact with the prospect.</p>
		        
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
		        
		        <p><strong>Attachment:</strong> Ideal to attach a company or product brochure/datasheet or you could attach a different document now like a case study talking about one of your clients.</p>
		        
		        <p><strong>Email body:</strong></p>
		        <p>Hello <span class="dynamic_value edit_area">[Prospect First Name]</span>,</p>
		        <p>I sent you information a couple of weeks ago on how help 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>. 
		        I just wanted to follow-up with you to see if you had a chance to look at it and if you had any questions or interest.</p>
		        <p>From our research and what has been discussed, it sounds like there is the strong potential to have a productive conversation. This is because we help 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['1']->user_data_id) ? $summary['1']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['1']->value) ? $summary['1']->value : Null);?></span>s. This can often lead to 
		        <span class="<?php echo (!empty($summary['2']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['2']->user_data_id) ? $summary['2']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['2']->value) ? $summary['2']->value : Null);?></span>.</p>
		        <p>We are able to drive these improvements through the delivery of our <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span>.</p>
		        <p>Are you available to put a 		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span> next Tuesday or Thursday morning where we can 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>?</p>
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
		<tr>
			<td><strong>Email #3</strong></td>
		</tr>
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p><strong>Description:</strong> This third email is designed follow-up one last time with the prospect if there still has not been a response. This email is designed to provide more information on you and includes your building interest points.</p>
        
		        <p><strong>Timing:</strong> This email should be sent two weeks after the second email and a best practice would be to try to call the prospect between emails #2 and #3.</p>
		        
		        <p><strong>Subject line:</strong>Checking back up</p>
		        
		        <p><strong>Attachment:</strong> Ideal to attach a company or product brochure/datasheet or you could attach a different document now like a case study talking about one of your clients.</p>
		        
		        <p><strong>Email body:</strong></p>
		        <p>Hello <span class="dynamic_value edit_area">[Prospect First Name]</span>,</p>
		        <p>I sent you a couple of emails over the past few weeks and I just wanted to try to connect with you one last time.</p>
		        <p>You have many options in this area and always have the option to do nothing as well. Some reasons that our clients came over to us and continue to stay with us are:</p>
		        <p><div class="red-area">(Choose 1 of below or summarize, these are technical pain connected with technical and business value)</div>
		        	<ul>
		        	<?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php 
								$technical_pain = $this->home->get_value_pain($product->product_id, 'PT');
								$technical_value = $this->home->get_value_pain($product->product_id, 'T');
		       					$business_value  = $this->home->get_value_pain($product->product_id, 'B');
								?>
									<li>We help <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to deal with
									
									<span class="<?php echo (!empty($technical_pain) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical_pain[0]->id;?>__tech_pain__tpd"><?php echo (isset($technical_pain[0]->value) ? $technical_pain[0]->value: NULL);?></span> and this can help to (with) 
									<span class="<?php echo (!empty($technical_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical_value[0]->id;?>__tech_value__tpd"><?php echo (isset($technical_value[0]->value) ? $technical_value[0]->value : NULL);?></span> and this can typically lead to 
									<span class="<?php echo (!empty($business_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business_value[0]->id;?>__bus_value__tpd"><?php echo (isset($business_value[0]->value) ? $business_value[0]->value : NULL);?></span>.
									</li>
							<?php endforeach;?>
						<?php endif;?>
		   			</ul>
		   		</p>
		        <p><div class="red-area">(Choose 1 of below or summarize, these are the benefits you delivered with your name drops)</div>
		        	<ul>
					     <?php if (isset($credibilities)):?>
		       						<?php $i = 1; foreach ($credibilities as $credibility):?>
		       						<?php
		       						$data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');
		       						
		       						$customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;
			       					$customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;
			       					
			       					$worked_id = $data['worked']['id'];
			       					$worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;
			       					
			       					$provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;
			       					$provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;
			       					
			       					$when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;
			       					$when_value = isset($data['when']['value']) ? $data['when']['value']: NULL; 
		       						?>
		       							<li>We have helped <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to (with) 
       								<span class="<?php echo (!empty($provided_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> and that led to <span class="<?php echo (!empty($when_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</li>
		       						<?php $i++; endforeach;?>
		       		<?php endif;?>
       			<li>Some ways that we differ from other options out there are 
			    <?php if (isset($products)):?>
					<?php foreach ($products as $product):?>
						<?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'PB');?>
							<?php if(isset($detail_bus_data)):?>
									<?php foreach ($detail_bus_data as $detail_bus):?>
										<span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__bus_pain__tpd"><?php echo $detail_bus->value;?></span>,
									<?php endforeach;?>
							<?php endif?>
					<?php endforeach;?>
				<?php endif;?>
				.</li>
	            <li>Some things to be concerned with when not doing anything in this area are 
            	<?php if (isset($products)):?>
					<?php foreach ($products as $product):?>
						<?php $bussiness_data  = $this->home->get_value_pain($product->product_id, 'DB'); ?>
								<?php if(isset($bussiness_data)):?>
									<?php foreach ($bussiness_data as $bussiness):?>
										<span class="<?php echo (!empty($bussiness->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $bussiness->id;?>__desc_bus_pain__tpd"><?php echo $bussiness->value;?></span>,
									<?php endforeach;?>
								<?php endif?>
					<?php endforeach;?>
				<?php endif;?> 
				.</li>
		            <li>Other key details about us are that we 
	         		<span class="<?php echo (!empty($interes[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['0']->user_data_id) ? $interes['0']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[0]->value) ? $interes[0]->value : $this->config->item('message'));?></span>, 
		            <span class="<?php echo (!empty($interes[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['1']->user_data_id) ? $interes['1']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[1]->value) ? $interes[1]->value : $this->config->item('message'));?></span>, and 
		            <span class="<?php echo (!empty($interes[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['2']->user_data_id) ? $interes['2']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[2]->value) ? $interes[2]->value : $this->config->item('message'));?></span>.</li>
		            </ul>
		   		</p>
		        <p>Let me know if you would like to schedule something soon. Thank you and we look forward to talking with you soon.</p>
		        <p>Best Regards,</p>
		        <p>
		        	<span>[Your Name]</span><br/>
		            <span>[Your Title]</span> <br/>
		            <span>[Your Company]</span> <br/>
		            <span>[Your Phone Number]</span> <br/>
		            <span>[Your Email Address]</span> <br/>
		        </p>
			</td>
		</tr>
	</table>
	
<?php echo $this->load->view('common/footer_outputs');?> 