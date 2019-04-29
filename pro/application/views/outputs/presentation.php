<?php $this->load->view('common/meta_outputs');?>
<title>Overview Presentation</title>
</head>
<body>
	<div id="content">
	<?php if($action != 'download'){?>	<?php 	$this->load->view('common/logo');?>	<?php } ?>
	<h1 align="center">Overview Presentation</h1>	<h1 align="center" style="margin-bottom: 10px"><?php  echo $company_meta['your_name']; ?> </h1>	<h1 align="center" style="margin-bottom: 10px"><?php  echo $company_meta['your_title']; ?> </h1>	<h1 align="center" style="margin-bottom: 10px"><?php echo $company_info->company_name ?></h1>	
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
					<td><strong>Common Challenges</strong></td> 
				</tr>
				<tr><td><hr class="hrline" /></td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_tech_pain)):?>
								<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li> <?php echo $techpain->value ?> </li>
								<?php endforeach;?>
							<?php endif?>
						</ul>
						<br />
					</td>
				</tr>
				<?php /*?><tr>
					<td>
						<strong>Business:</strong>
						<ul>
								<?php if (isset($campaign_output_biz_pain)):?>
									<?php foreach ($campaign_output_biz_pain as $bizpain):?>
										<li> <?php echo $bizpain->value ?> </li>
									<?php endforeach;?>
								<?php endif?>
						</ul>
						<br />
					</td>
				</tr>
				<tr>
					<td>
						<strong>Personal:</strong>
						<ul>
							<?php if (isset($campaign_output_per_pain)):?>
								<?php foreach ($campaign_output_per_pain as $personalpain):?>
								<li> <?php echo $personalpain->value ?> </li>
								<?php endforeach;?>	
							<?php endif; ?> 
						</ul>
						<br>
					</td>
				</tr><?php */?>
				<?php /*?><tr>
					<td><strong>How We Help</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_tech_val)): ?>								
									<?php foreach ($campaign_output_tech_val as $techval) : ?>	
										<li><?php echo $techval->value ?> can improve your business </li>
									<?php endforeach; ?>							
								<?php endif; ?>													
								<?php if (isset($campaign_output_biz_val)):?>
									<?php foreach ($campaign_output_biz_val as $bizval):?>
								
										<li><?php echo $bizval->value ?> can improve your business</li>
									<?php endforeach;?>
								<?php endif?>
								<?php if (isset($campaign_output_per_val)):?>
									<?php foreach ($campaign_output_per_val as $personalval):?>	
										<li><?php echo $personalval->value ?>  can improve your business</li>
									<?php endforeach;?>
								<?php endif?>
						</ul>
						<br />
					</td>
				</tr><?php */?>	
                <?php /*?><tr>
					<td><strong>How We Help</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_tech_val)): ?>								
									<?php foreach ($campaign_output_tech_val as $techval) : ?>	
										<li><?php echo ucfirst($techval->value) ?> can improve your business </li>
									<?php endforeach; ?>							
								<?php endif; ?>
						</ul>
						<br />
					</td>
				</tr><?php */?>
                <tr>
					<td><strong>How We Help</strong></td>
				</tr>
				<tr><td><hr class="hrline" /></td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_tech_val)): ?>								
									<?php foreach ($campaign_output_tech_val as $techval) : ?>	
										<li><?php echo ucfirst($techval->value) ?></li>
									<?php endforeach; ?>							
								<?php endif; ?>							
						</ul>
						<br />
					</td>
				</tr>			
				<tr>
					<td><strong>Our Products</strong></td>
				</tr>
				<tr><td><hr class="hrline" /></td></tr>
				
				<tr>
					<td>
						<ul>
							<li><?php echo $P_Q1->value; ?></li>
							<li><?php echo $product_desc->value; ?></li>
						</ul>
						<br/>
					</td>
				</tr>
				<tr>
					<td><strong>How We Differ</strong></td>
				</tr>
				<tr><td><hr class="hrline" /></td></tr>
				<tr>
					<td>
						<ul>
							<li><span ><?php echo (!empty($diff1->value) ? $diff1->value : '');?></span></li> 
							<li><span ><?php echo (!empty($diff2->value) ? $diff2->value : '');?></span></li> 							<li><span ><?php echo (!empty($diff3->value) ? $diff3->value : '');?></span></li> 							
						</ul>
						<br>
					</td>
				</tr>
				<tr>
					<td><strong>Company Overview</strong></td>
				</tr>
				<tr><td><hr class="hrline" /></td></tr>
				<tr>
					<td>
						<ul>
							<li> We have been in business for <?php echo $company_meta['business_exp']; ?> </li>							<li> We operate in <?php echo $company_meta['area_operate']; ?> </li>							<li> We have won awards for  <?php echo $company_meta['area_operate']; ?> </li>							<li> <?php echo $company_meta['interest'][0]; ?> </li>							<li> <?php echo $company_meta['interest'][1]; ?> </li>							<li> <?php echo $company_meta['interest'][2]; ?> </li>						</ul>
						<br />
					</td>
				</tr>
				
				<tr>
					<td><strong>Case Study </strong></td>
				</tr>
				<tr><td><hr class="hrline" /></td></tr>
				<tr>
					<td>					   <strong> <?php echo $P_Q1->value; ?> </strong>
						<ul>
							<li> Service provided: <?php echo $active_name_drop_exp['worked']->value ; ?>. </li>
							<li> Technical benefit achieved: <?php echo $active_name_drop_exp['provided']->value ; ?> </li> 
							<li> Business benefit achieved: <?php echo $active_name_drop_exp['when']->value ; ?> </li>
						</ul>
					</td>
				</tr>
		</table>  	
	</div>		
<?php echo $this->load->view('common/footer_outputs');?>