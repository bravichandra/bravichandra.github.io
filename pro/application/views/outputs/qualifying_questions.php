<?php $this->load->view('common/meta_outputs');?>
<title>QUALIFYING QUESTIONS</title>
</head>

<body>

<div id="content">
<?php echo $this->load->view('common/logo');?>
<h1 align="center">QUALIFYING QUESTIONS</h1>

		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
					<td>
					<strong>Technical Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are soft qualifying questions to determine if there is a potential fit for the prospect with what you have to offer from a technical standpoint.</p>
						<ul>
							<?php if (isset($products)):?>
								<?php foreach ($products as $product):?>
										<?php
											$tech_qualify_data = $this->home->get_value_pain($product->product_id, 'QT');
											$detail_tech_data = $this->home->get_value_pain($product->product_id, 'QDT');
										?>
										<?php if(isset($tech_qualify_data)):?>
										<?php $counter=1; foreach ($tech_qualify_data as $technical):?>
										<?php if($counter == 1):?>
											<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_qualify__tpd"><?php echo $technical->value;?></span></li><?php } ?>
											<?php if(!empty($detail_tech_data[0]->value)) { ?><li><span class="<?php echo (!empty($detail_tech_data[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech_data[0]->id;?>__desc_tech_qualify__tpd"><?php echo $detail_tech_data[0]->value;?></span></li><?php } ?>
										<?php else:?>
											<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_qualify__tpd"><?php echo $technical->value;?></span></li><?php } ?>
										<?php endif;?>
										<?php $counter++; endforeach;?>
										<?php endif?>
								<?php endforeach;?>
								
								<?php foreach ($products as $product):?>
										<?php
											$single_technical_data = $this->home->get_value_pain($product->product_id, 'QTS');
										?>
										<?php if(isset($single_technical_data)):?>
										<?php foreach ($single_technical_data as $single_technical):?>
											<?php if(!empty($single_technical->value)) { ?><li><span class="<?php echo (!empty($single_technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $single_technical->id;?>__single_tech_qualify__tpd"><?php echo $single_technical->value;?></span></li><?php } ?>
										<?php endforeach;?>
										<?php endif?>
								<?php endforeach;?>
							<?php endif;?> 
						</ul>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Business Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are soft qualifying questions to determine if there is a potential fit for the prospect with what you have to offer from a business standpoint.</p>
						<ul>
							<?php if (isset($products)):?>
										<?php foreach ($products as $product):?>
											<?php 
											$bus_qualify_data  = $this->home->get_value_pain($product->product_id, 'QB');
											$detail_bus_data  = $this->home->get_value_pain($product->product_id, 'QDB'); 
											?>
											<?php if(isset($bus_qualify_data)):?>
													<?php $counter=1; foreach ($bus_qualify_data as $business):?>
														<?php if($counter == 1):?>
															<?php if(!empty($business->value)) { ?><li><span class="<?php echo (!empty($business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business->id;?>__bus_qualify__tpd"><?php echo $business->value;?></span></li><?php } ?>
															<?php if(!empty($detail_bus_data[0]->value)) { ?><li><span class="<?php echo (!empty($detail_bus_data[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus_data[0]->id;?>__desc_bus_qualify__tpd"><?php echo $detail_bus_data[0]->value;?></span></li><?php } ?>
														<?php else:?>
															<?php if(!empty($business->value)) { ?><li><span class="<?php echo (!empty($business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business->id;?>__bus_qualify__tpd"><?php echo $business->value;?></span></li><?php } ?>
														<?php endif;?>
													<?php $counter++; endforeach;?>
											<?php endif?>
									<?php endforeach;?>
									
									<?php foreach ($products as $product):?>
										<?php
											$single_business_data  = $this->home->get_value_pain($product->product_id, 'QBS');
										?>
										<?php if(isset($single_business_data)):?>
										<?php foreach ($single_business_data as $single_business):?>
											<?php if(!empty($single_business->value)) { ?><li><span class="<?php echo (!empty($single_business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $single_business->id;?>__single_bus_qualify__tpd"><?php echo $single_business->value;?></span></li><?php } ?>
										<?php endforeach;?>
										<?php endif?>
								<?php endforeach;?>
								<?php endif;?> 
						</ul>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Personal Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are soft qualifying questions to determine if there is a potential fit for the prospect with what you have to offer from a personal standpoint.</p>
						<ul>
							<?php if (isset($products)):?>
									<?php foreach ($products as $product):?>
											<?php
						       					$pers_qualify_data  = $this->home->get_value_pain($product->product_id, 'QP');
						       					$detail_pers_data  = $this->home->get_value_pain($product->product_id, 'QDP');
											?>
										<?php if(isset($pers_qualify_data)):?>
											<?php $counter=1; foreach ($pers_qualify_data as $personal):?>
												<?php if($counter == 1):?>
													<?php if(!empty($personal->value)) { ?><li><span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_qualify__tpd"><?php echo $personal->value;?></span></li><?php } ?>
													<?php if(!empty($detail_pers_data[0]->value)) { ?><li><span class="<?php echo (!empty($detail_pers_data[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_pers_data[0]->id;?>__desc_pers_qualify__tpd"><?php echo $detail_pers_data[0]->value;?></span></li><?php } ?>
												<?php else:?>
													<?php if(!empty($personal->value)) { ?><li><span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_qualify__tpd"><?php echo $personal->value;?></span></li><?php } ?>
												<?php endif;?>
											<?php $counter++; endforeach;?>
										<?php endif?>
						<?php endforeach;?>
						<?php foreach ($products as $product):?>
										<?php
											$single_personal_data  = $this->home->get_value_pain($product->product_id, 'QPS');
										?>
										<?php if(isset($single_personal_data)):?>
										<?php foreach ($single_personal_data as $single_personal):?>
											<?php if(!empty($single_personal->value)) { ?><li><span class="<?php echo (!empty($single_personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $single_personal->id;?>__single_pers_qualify__tpd"><?php echo $single_personal->value;?></span></li><?php } ?>
										<?php endforeach;?>
										<?php endif?>
								<?php endforeach;?>
							<?php endif;?> 
						</ul>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Need vs. Want Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are hard qualifying questions to determine if there prospect's level of interest is more built on a true need or if it is more of a "want". If it is a want, the prospect is not as qualified.</p>
						<ul>
							<li>What happens if you do not do anything and do not make a purchase or make any changes?</li>
			                <li>What improvements will you see if move forward with this purchase?</li>
			                <li>Is there at date when this purchase needs to be made?</li>
			                <li>What happens if the purchase is not made by that date?</li>
			                <li>What is the time frame that the project needs to work along?</li> 
						</ul>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Availability of Funding Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are hard qualifying questions to determine how available funding is should the prospect decide to move forward with a purchase.</p>
						<ul>
							<li>Is there a budget approved for this project?</li>
			                <li>What is the budget range that the project needs to fit in?</li>
			                <li>Have the funds been allocated to this purchase?</li>
			                <li>What budget (department) will this purchase be made under?</li>
			                <li>Are there other purchases that this funding may end being used for?</li>
			                <li>How does the project fit with other initiatives from a priority standpoint?</li> 
						</ul>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Decision Making Authority Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are hard qualifying questions to determine how much purchasing and decision making power the prospect has.</p>
						<ul>
							<li>What is the decision making process?</li>
			                <li>What parties will be involved in making the decision?</li>
			                <li>What functional areas (departments) will be impacted by the purchase?</li>
			                <li>Who is the ultimate decision maker?</li>
			                <li>Who is the person that will need to sign the agreement/contract?</li> 
						</ul>
						<br>
					</td>
				</tr>
				
				<tr>
					<td><strong>Level of Interest Questions</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<p><strong>Description:</strong> These are hard qualifying questions to determine how much competition you have.</p>
						<ul>
							<li>Why did you take time out of your schedule to meet with us? Why did you contact us?</li>
			                <li>What other options are you considering?</li>
			                <li>How do you feel about their solution (product)?</li>
			                <li>What do you like about their solution (product)?</li>
			                <li>What do you not like about their solution (product)?</li>
			                <li>How does their solution (product) compare with what we have to offer?</li>
			                <li>Is there a reason why you would choose us?</li>
			                <li>If you had to make a decision today, which way would you lean?</li>
			                <li>What are the key factors that the decision to purchase will be based on?</li>  
						</ul>
						<br>
					</td>
				</tr>
		</table>
</div>

  <?php echo $this->load->view('common/footer_outputs');?>
