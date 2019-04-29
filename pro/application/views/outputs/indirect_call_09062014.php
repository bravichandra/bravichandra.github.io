<?php $this->load->view('common/meta_outputs');?>
<title>Call Script – Qualify Focus</title>
</head>

<body>

<div id="content">
	<?php echo $this->load->view('common/logo');?>
	
	<h1 align="center">Call Script &#45; Qualify Focus</h1>
	<p class="topTxt"><strong>Description:</strong> This is an indirect cold call script and that refers to the fact that the script is designed to create a conversation versus going directly for the close.</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		  <tr><td colspan="3" class="border-bottom">&nbsp;</td></tr>
		  <tr style="border-bottom:1px solid #000;">
		    <td style="width:15%;"><strong>Objective:</strong></td>
		    <td style="width:5%">&nbsp;</td>
		    <td style="width:80%;">Option A: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (!empty($sales_process[0]->value) ? $sales_process[0]->value : $this->config->item('message'));?></span> <br/> Option B:  <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['2']->user_data_id) ? $sales_process['2']->user_data_id : Null);?>__close__tud"><?php echo (!empty($sales_process[2]->value) ? $sales_process[2]->value : $this->config->item('message'));?></span></td>
		  </tr>
		  <tr><td colspan="3" class="border">&nbsp;</td></tr>
		  <!--<tr>
		    <td><strong>Ideal Prospect</strong></td>
		    <td>&nbsp;</td>
		    <td>
			    <table> 
				    <tr>
					    <td width="55%">
								<strong>Demographic Details</strong>
							    	<br><br><strong>Geography:</strong> <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['0']->user_data_id) ? $target['0']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['0']->value) ? $target['0']->value : NULL);?></span>
							    	<br><br><strong>Size:</strong> <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['1']->user_data_id) ? $target['1']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['1']->value) ? $target['1']->value : NULL);?></span> to <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['2']->user_data_id) ? $target['2']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['2']->value) ? $target['2']->value : NULL);?></span>
							    	<br><br>
							    	
							    	<strong>Industry:</strong>
									      <ul>
									        <li >Focus: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['3']->user_data_id) ? $target['3']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['3']->value) ? $target['3']->value : NULL);?></span></li> 
									        <li >Avoid: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['4']->user_data_id) ? $target['4']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['4']->value) ? $target['4']->value : NULL);?></span></li>
									      </ul>
							    	<br>
							    	<strong>Department: </strong>
										<ul>
										  <li>Primary: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['5']->user_data_id) ? $target['5']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['5']->value) ? $target['5']->value : NULL);?></span></li>
										  <li>Secondary: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['6']->user_data_id) ? $target['6']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['6']->value) ? $target['6']->value : NULL);?></span></li>
										</ul>
										
									<br>
									<strong>Title:</strong>
										<ul>
										 <li >Primary: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['7']->user_data_id) ? $target['7']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['7']->value) ? $target['7']->value : NULL);?></span></li>
										 <li >Secondary: <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['8']->user_data_id) ? $target['8']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['8']->value) ? $target['8']->value : NULL);?></span></li>
										</ul>
							    	<br>
						</td>
				    	<td width="2%">&nbsp;</td>
					     <td width="43%">
								<strong>Environmental Details</strong>
							    	 <br><br>
							    			    	<strong>Technical</strong>
							      <ul>
							       		<?php if (isset($products)):?>
											<?php foreach ($products as $product):?>
												<?php $detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');?>
												<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT');?>
													<?php if(isset($detail_tech_data)):?>
														<?php foreach ($technical_data as $technical):?>
															<li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo $technical->value;?></span></li>
														<?php endforeach;?>
														<?php foreach ($detail_tech_data as $detail_tech):?>
															<li><span class="<?php echo (!empty($detail_tech->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech->id;?>__desc_tech_pain__tpd"><?php echo $detail_tech->value;?></span></li>
														<?php endforeach;?>
												<?php endif?>
											<?php endforeach;?>
										<?php endif;?> 
							      </ul>
							      <br>
							      <strong>Business</strong>
							      <ul>
							       		<?php if (isset($products)):?>
											<?php foreach ($products as $product):?>
												<?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>
												<?php $business_data  = $this->home->get_value_pain($product->product_id, 'PB');?>
													<?php if(isset($detail_bus_data)):?>
														<?php foreach ($business_data as $business):?>
															<li><span class="<?php echo (!empty($business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business->id;?>__bus_pain__tpd"><?php echo $business->value;?></span></li>
														<?php endforeach;?>
														<?php foreach ($detail_bus_data as $detail_bus):?>
															<li><span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span></li>
														<?php endforeach;?>
												<?php endif?>
											<?php endforeach;?>
										<?php endif;?> 
							      </ul>
							      <br>
									<strong>Personal</strong>
								      <ul>
								       		<?php if (isset($products)):?>
													<?php foreach ($products as $product):?>
														<?php $detail_pers_data  = $this->home->get_value_pain($product->product_id, 'DP'); ?>
														<?php $personal_data  = $this->home->get_value_pain($product->product_id, 'PP');?>
														<?php if(isset($detail_pers_data)):?>
															<?php foreach ($personal_data as $personal):?>
																<li><span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_pain__tpd"><?php echo $personal->value;?></span></li>
															<?php endforeach;?>
															<?php foreach ($detail_pers_data as $detail_pers):?>
																<li><span class="<?php echo (!empty($detail_pers->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_pers->id;?>__desc_pers_pain__tpd"><?php echo $detail_pers->value;?></span></li>
															<?php endforeach;?>
														<?php endif?>
													<?php endforeach;?>
											<?php endif;?> 
								      </ul>
					                <br> 	
							    	</td>
				  		</tr>	  
				  </table>	
				</td>
		  </tr>
		  <tr><td colspan="3" class="border">&nbsp;</td></tr>-->
		  <tr>
		    <td class="td-pad-b"><strong>Introduction to Gatekeeper</strong><br></td>
		    <td>&nbsp;</td>
		    <td>Hello, I am trying to connect with  <span class="red-area">[insert name or title]</span>.  Can you point me in the right direction?
			</td>
  		 </tr>
  
    	<tr><td colspan="3" class="border">&nbsp;</td></tr>
	  <tr>
	    <td class="td-pad-b"><strong>Introduction to contact</strong></td>
	    <td>&nbsp;</td>
	    <td>Hello  <span class="dynamic_value red-area">[Contact's Name]</span>, this is  <span>[Insert Name]</span> from  <span>[Insert Company]</span>, have I caught you in the middle of anything?<br>
		</td>
	  </tr>
  
      <tr><td colspan="3" class="border">&nbsp;</td></tr>
	  <tr>
	    <td><strong>Value Statement</strong></td>
	    <td>&nbsp;</td>
	    <td>Purpose of my call is that &#45; <span class="red-area">(Choose one of below)</span>
	    <ul>
	    <li>We help  
	    	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> to  
	    	<span class="<?php echo (!empty($summary['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['0']->user_data_id) ? $summary['0']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['0']->value) ? $summary['0']->value : NULL);?></span>.
	    </li>
	    <!--  <li>We help  <span class="<?php echo (!empty($summary['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['1']->user_data_id) ? $summary['1']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['1']->value) ? $summary['1']->value : Null);?></span>.</li> -->
	   <li>We help  
	    	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> to  
	    	<span class="<?php echo (!empty($summary['1']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['1']->user_data_id) ? $summary['1']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['1']->value) ? $summary['1']->value : NULL);?></span>.
	    </li>
	    <li>We help  
	    	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['5']->user_data_id) ? $target['5']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['5']->value) ? $target['5']->value : NULL);?></span> 
	    	<span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($target['7']->user_data_id) ? $target['7']->user_data_id : NULL);?>__target__tud"><?php echo (isset($target['7']->value) ? $target['7']->value : NULL);?></span>s to  
	    	<span class="<?php echo (!empty($summary['2']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($summary['2']->user_data_id) ? $summary['2']->user_data_id : Null);?>__summary__tud"><?php echo (isset($summary['2']->value) ? $summary['2']->value : Null);?></span>.
	    </li>
	    <li>We provide  
	    <span class="<?php echo (!empty($custome_fields['0']->user_data_id) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['0']->user_data_id) ? $custome_fields['0']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['0']->value) ? $custome_fields['0']->value : NULL);?></span>.</li>
	    </ul>
		<br></td>
	  </tr>
    
    <tr><td colspan="3" class="border">&nbsp;</td></tr>
    <tr>
	    <td><strong>Disqualify Statement</strong></td>
	    <td>&nbsp;</td>
	    <td class="td-pad-b">I actually don't know if you need what our services provide so I just had a question or two. <span class="red-area">(pause or ask for agreement or availability)</span>  If you have a couple of minutes?
		<br></td>
  	</tr>
  	<tr><td colspan="3" class="border">&nbsp;</td></tr>
    <tr>
    <td><strong>Soft Qualifying Questions</strong></td>
    <td>&nbsp;</td>
    <td><strong>Technical Questions:</strong>
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
											<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_qualify__tpd"><?php echo $technical->value;?></span></li><?php  }?>
											<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($detail_tech_data[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech_data[0]->id;?>__desc_tech_qualify__tpd"><?php echo $detail_tech_data[0]->value;?></span></li><?php  }?>
										<?php else:?>
											<?php if(!empty($technical->value)) { ?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_qualify__tpd"><?php echo $technical->value;?></span></li><?php  }?>
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
											<?php if(!empty($single_technical->value)) { ?><li><span class="<?php echo (!empty($single_technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $single_technical->id;?>__single_tech_qualify__tpd"><?php echo $single_technical->value;?></span></li><?php }?>
										<?php endforeach;?>
										<?php endif?>
								<?php endforeach;?>
							<?php endif;?> 
						</ul>
						<br>
	<strong>Business Questions:</strong>

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
	<strong>Personal Questions:</strong>

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
        <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <tr>
    <td><strong>Common Pain Points</strong></td>
    <td>&nbsp;</td>
    <td>Oh, OK. Well, as we talk with other <span class="dynamic_value red-area">[insert prospect's title]</span>, we have noticed that they often express challenges with:<br/><span class="red-area">(Share any of the below pain examples)</span><br/>
	    	<br>
	    	<strong>Technical Pain</strong>
		      <ul>
		       		<?php if (isset($products)):?>
						<?php foreach ($products as $product):?>
							<?php $detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');?>
							<?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT');?>
								<?php if(isset($detail_tech_data)):?>
									<?php foreach ($technical_data as $technical):?>
										<?php if (!empty($technical->value)) {?><li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo $technical->value;?></span></li><?php } ?>
									<?php endforeach;?>
									<?php foreach ($detail_tech_data as $detail_tech):?>
										<?php if (!empty($detail_tech->value)) {?><li><span class="<?php echo (!empty($detail_tech->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech->id;?>__desc_tech_pain__tpd"><?php echo $detail_tech->value;?></span></li><?php } ?>
									<?php endforeach;?>
							<?php endif?>
						<?php endforeach;?>
					<?php endif;?> 
		      </ul>
		      <br>
		      <strong>Business Pain</strong>
		      <ul>
		       		<?php if (isset($products)):?>
						<?php foreach ($products as $product):?>
							<?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>
							<?php $business_data  = $this->home->get_value_pain($product->product_id, 'PB');?>
								<?php if(isset($detail_bus_data)):?>
									<?php foreach ($business_data as $business):?>
										<?php if (!empty($business->value)) {?><li><span class="<?php echo (!empty($business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business->id;?>__bus_pain__tpd"><?php echo $business->value;?></span></li><?php } ?>
									<?php endforeach;?>
									<?php foreach ($detail_bus_data as $detail_bus):?>
										<?php if (!empty($detail_bus->value)) {?><li><span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span></li><?php } ?>
									<?php endforeach;?>
							<?php endif?>
						<?php endforeach;?>
					<?php endif;?> 
		      </ul>
		      <br>
				<strong>Personal Pain</strong>
			      <ul>
			       		<?php if (isset($products)):?>
								<?php foreach ($products as $product):?>
									<?php $detail_pers_data  = $this->home->get_value_pain($product->product_id, 'DP'); ?>
									<?php $personal_data  = $this->home->get_value_pain($product->product_id, 'PP');?>
									<?php if(isset($detail_pers_data)):?>
										<?php foreach ($personal_data as $personal):?>
                                                                                <?php if($business->value !== '') { ?><li><span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_pain__tpd"><?php echo $personal->value;?></span></li><?php } ?>
										<?php endforeach;?>
										<?php foreach ($detail_pers_data as $detail_pers):?>
											<?php if($detail_pers->value !== '') { ?><li><span class="<?php echo (!empty($detail_pers->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_pers->id;?>__desc_pers_pain__tpd"><?php echo $detail_pers->value;?></span></li><?php } ?>
										<?php endforeach;?>
									<?php endif?>
								<?php endforeach;?>
						<?php endif;?> 
			      </ul>
	        <p>Which one of those are you most concerned with?</p><br>
	</td>
  </tr>
  
        <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <tr>
    <td><strong>Building Interest Points</strong></td>
    <td>&nbsp;</td>
    <td>Well, based on what you shared, it might productive for us to talk in more detail.  The reason why is<br/><span class="red-area">(Share any of the below as appropriate as you try to trigger interest)</span><br><br>
			<strong>Company Details:</strong>
			<ul>
				<li>As I said, I am with <span>[Insert Company]</span> and we provide:</li>
	            <ul>
	            	<?php if (isset($products)):?>
							<?php $i = 0; foreach ($products as $product):?>
							<?php  
								$data = $this->home->get_meta_data($product->product_id, 'product', 'tpd');
								$product_1_value 	= isset($data['P_Q1']['value']) ? $data['P_Q1']['value'] : NULL;
								$product_1_id 	= isset($data['P_Q1']['id']) ? $data['P_Q1']['id'] : NULL;
								
								$total = $i + 1;
								?>
								<span class="<?php echo (!empty($product_1_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $product_1_id;?>__P_Q1__tpd"><?php echo $product_1_value;?><?php echo (isset($product_1_value) ? ',' : '');?></span>
							<?php $i++; endforeach;?>
					<?php endif;?> 
					
					
	            	<li><span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['0']->user_data_id) ? $custome_fields['0']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['0']->value) ? $custome_fields['0']->value : Null);?></span>.</li>
	            </ul>
	            </ul>
	            <ul>
	            <li>Our products/services:</li>
	            <ul>
	           <?php if (isset($products)):?>
						<?php foreach ($products as $product):?>
							<?php  
							$data = $this->home->get_meta_data($product->product_id, 'product', 'tpd');
							$product_2_value 	= isset($data['P_Q3']['value']) ? $data['P_Q3']['value'] : NULL;
							$product_2_id 	= isset($data['P_Q3']['id']) ? $data['P_Q3']['id'] : NULL;
							?>
							<li><span class="dynamic_value edit_area" id="edit_<?php echo $product->product_id;?>_<?php echo $product_2_id;?>__P_Q3__tpd"><?php echo $product_2_value;?></span></li>
						<?php endforeach;?>
				<?php endif;?> 
	            </ul>
			</ul>
			<br>
			<strong>Connect Pain with Value:</strong>
				<ul>
					
					<?php if (isset($products)):?>
							<?php foreach ($products as $product):?>
								<?php 
								$technical_pain = $this->home->get_value_pain($product->product_id, 'PT');
								$technical_value = $this->home->get_value_pain($product->product_id, 'T');
		       					$business_value  = $this->home->get_value_pain($product->product_id, 'B');
		       					$detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');
								?>
								
									<li>We help <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($custome_fields['1']->user_data_id) ? $custome_fields['1']->user_data_id : Null);?>__users__tud"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to deal with
									
									<span class="<?php echo (!empty($technical_pain) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical_pain[0]->id;?>__tech_pain__tpd"><?php echo (isset($technical_pain[0]->value) ? $technical_pain[0]->value: NULL);?></span> by helping to 
									<span class="<?php echo (!empty($technical_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical_value[0]->id;?>__tech_value__tpd"><?php echo (isset($technical_value[0]->value) ? $technical_value[0]->value : NULL);?></span> and this can typically lead to 
									<span class="<?php echo (!empty($business_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo isset($business_value[0]->id) ? $business_value[0]->id: NULL;?>__bus_value__tpd"><?php echo (isset($business_value[0]->value) ? $business_value[0]->value : NULL);?></span>.
									</li>
							<?php endforeach;?>
						<?php endif;?>
				</ul>
			<br>
			<strong>ROI Statements:</strong>
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
       							<li>We have helped to  <span class="<?php echo (!empty($provided_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> and that led to <span class="<?php echo (!empty($when_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</li>
       						<?php $i++; endforeach;?>
       		<?php endif;?>
			</ul>
			<br>
			<strong>Differentiation:</strong>
				<ul><li>Some ways that we differ from other options out there are <span class="<?php echo (!empty($interestB1[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['0']->user_data_id) ? $interestB1['0']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[0]->value) ? $interestB1[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interestB1[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['1']->user_data_id) ? $interestB1['1']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[1]->value) ? $interestB1[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interestB1[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['2']->user_data_id) ? $interestB1['2']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[2]->value) ? $interestB1[2]->value : NULL);?></span>
				</li></ul>
			<br>
			<strong>Threats of Doing Nothing:</strong>
				<ul><li>Some things to be concerned with when not doing anything in this area are <span class="<?php echo (!empty($interestB2[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['0']->user_data_id) ? $interestB2['0']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[0]->value) ? $interestB2[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interestB2[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['1']->user_data_id) ? $interestB2['1']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[1]->value) ? $interestB2[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interestB2[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['2']->user_data_id) ? $interestB2['2']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[2]->value) ? $interestB2[2]->value : NULL);?></span>
				</li></ul>
			<br>
			<strong>Company Facts:</strong>
			<ul>
				<li>Other key details about us are that we <span class="<?php echo (!empty($interes[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['0']->user_data_id) ? $interes['0']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[0]->value) ? $interes[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interes[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['1']->user_data_id) ? $interes['1']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[1]->value) ? $interes[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interes[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['2']->user_data_id) ? $interes['2']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[2]->value) ? $interes[2]->value : NULL);?></span>.</li>
			</ul><br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <tr>
    <td><strong>Scheduling the next discussion</strong></td>
    <td>&nbsp;</td>
    <td class="td-pad-b">But, since I have called you out of the blue, I do not want to take anymore of your time to talk right now.<br/>
	            Do you have interest in talking more about this?<br/>
	            If you have interest, a great next step would be for us to schedule a <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['0']->user_data_id) ? $sales_process['0']->user_data_id : Null);?>__close__tud"><?php echo (!empty($sales_process[0]->value) ? $sales_process[0]->value : '');?></span> where we can <span class="dynamic_value edit_area" id="edit_<?php echo $user_id;?>_<?php echo (isset($sales_process['1']->user_data_id) ? $sales_process['1']->user_data_id : Null);?>__close__tud"><?php echo (!empty($sales_process[1]->value) ? $sales_process[1]->value : '');?></span>.<br/>
	            Are you available to put this on the calendar next Tuesday or Thursday morning? <br>
	</td>
  </tr>
    
      <tr><td colspan="3" class="border">&nbsp;</td></tr>
        <tr>
		    <td><strong>Name drop</strong></td>
		    <td>&nbsp;</td>
		    <td class="td-pad-b"><span class="red-area">(Share any of below at any time when talking to a prospect)</span><br>
			    <?php if (isset($credibilities)):?>
			       		<?php $i = 1; foreach ($credibilities as $credibility):?>
		       				<?php 
			       				$data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');
			       				
		       					$customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;
		       					$customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;
		       					
		       					$worked_id = isset($data['worked']['id']) ? $data['worked']['id'] : NULL;
		       					$worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;
		       					
		       					$provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;
		       					$provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;
		       					
		       					$when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;
		       					$when_value = isset($data['when']['value']) ? $data['when']['value']: NULL; 
			       			
		       				?>
					    	<br>
					    	<strong>Name Drop #<?php echo $i;?>:</strong>
					    	<br>
					    	We worked with 
					    	<span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $customer_id;?>__customer__tcd"><?php echo $customer_value;?></span> and provided 
					    	<span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $worked_id;?>__worked__tcd"><?php echo $worked_value;?></span>.
					    	<br>
					    	This helped them to 
					    	<span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span>, which led to 
					    	<span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.
					        <br>
				        <?php $i++; endforeach;?>
			<?php endif;?>
		 </td>
 </tr>
 <tr><td colspan="3" class="border">&nbsp;</td></tr>
	          
	</table>
</div>
<?php $this->load->view('common/footer_outputs');?>