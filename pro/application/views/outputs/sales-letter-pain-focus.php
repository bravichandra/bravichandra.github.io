<?php $this->load->view('common/meta_outputs');?>
<title>Sales Letter &#45; Pain Focus</title>
</head>
<body>
<div id="content">
<?php echo $this->load->view('common/logo');?>
	<h1 align="center">Sales Letter &#45; Pain Focus</h1>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p>
		            <span class="dynamic_value">[Your Company]</span> <br />
		            <span class="dynamic_value">[Company Address]</span> <br />
		            <span class="dynamic_value">[City, State Zip]</span> <br /> <br />
		        </p>
		        <p>
		            <span class="dynamic_value">[Date]</span> <br /> <br />
		            
		            <span class="dynamic_value">[Target Prospect]</span> <br />
		            <span class="dynamic_value">[Target Contact Title]</span> <br />
		            <span class="dynamic_value">[Target Company]</span> <br />
		            <span class="dynamic_value">[Target Company Address]</span> <br />
		            <span class="dynamic_value">[City, State Zip]</span>
		        </p>
		    	
		        <p>Dear Mr./Ms. <span class="dynamic_value">[Prospect Last Name]</span>,</p>
		        
		        <p>I am with <span class="dynamic_value">[Your Company]</span> and we help 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to 
		        <span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : Null);?></span>. 
		        Reason for this letter is that we find that it is very common for organizations like yours to face challenges with 
					
					<?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT'); ?>
								<?php $detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');?>
										<?php if(!empty($technical_data)):?>
											<?php $no=1; foreach ($technical_data as $technical):?>
												<?php if($technical->Qus_status == 1) { ?>
													<span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo (!$technical->value AND $no==1) ? "[technical pain $no]" : $technical->value;?></span>, 
												<?php } ?>
											<?php $no++; endforeach;?>
										<?php endif?>
										<?php if (!empty($detail_tech_data)):?>
											<?php $no=1; foreach ($detail_tech_data as $detail_tech):?>
												<span class="<?php echo (!empty($detail_tech->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech->id;?>__desc_tech_pain__tpd"><?php echo (!$detail_tech->value AND $no==1) ? "[cause of technical pain $no]" : $detail_tech->value;?></span>, 
											<?php $no++; endforeach;?>
										<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
				</p>
		        
		        <p>This can often lead to 
		        <?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php $business_data = $this->home->get_value_pain($product->product_id, 'PB'); ?>
								<?php $detail_bus_data = $this->home->get_value_pain($product->product_id, 'DB');?>
										<?php if(!empty($business_data)):?>
											<?php $no=1; foreach ($business_data as $business):?>
												<?php if($business->Qus_status == 1) { ?>
													<span class="<?php echo (!empty($business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business->id;?>__tech_pain__tpd"><?php echo (!$business->value) ? "[business pain $no]" : $business->value;?></span>, 
												<?php } ?>
											<?php $no++; endforeach;?>
										<?php endif?>
										<?php if (!empty($detail_bus_data)):?>
											<?php $no=1; foreach ($detail_bus_data as $detail_bus):?>
												<span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech->id;?>__desc_tech_pain__tpd"><?php echo (!$detail_bus->value) ? "[cause of business pain $no]" : $detail_bus->value;?></span>, 
											<?php $no++; endforeach;?>
										<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>. 
		        I do not know if you are concerned about these challenges or not but we help to decrease and offset those areas and that is the purpose for me reaching out to you.</p>
		        
		        <p>I will call your office over the next few weeks to schedule a 
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['0']->value) ? $sales_process['0']->value : Null);?></span> 
		         to   
		        <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (isset($sales_process['1']->value) ? $sales_process['1']->value : Null);?></span>. 
		        If you would like to schedule that meeting ahead of us connecting over the phone, simply send an email to the address in my signature with your availability and I will look forward to talking with you then.</p>
		        
		        <p>Best Regards,</p>
		        <p> 
				[Your Name] <br />
				[Your Title] <br />
				[Your Company] <br />
				[Your Phone Number]<br />
				[Your Email Address]</p>
			</td>
		</tr>
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 