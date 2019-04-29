<?php $this->load->view('common/meta_outputs');?>
<title>Building Interest Points</title>
</head>
<body>
	<div id="content">
	<?php if($action != 'download'){?>
		<?php 	$this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">BUILDING INTEREST POINTS</h1>
	<p class="topTxt"  >
		<?php echo $P_Q1->value; ?>  for 
		<?php 
			if($campaign_info->campaign_target == '1'){	
					 echo $campaign_info->individual;
				}else{ 
					echo $campaign_info->organization;
			}
		?>
	</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr>
			<td><strong>Differentiation Statement</strong></td>
		</tr>
		<tr><td><hr class="hrline" /></td></tr>
		<tr>
			<td>
				Some ways that we differ from other options out there are <?php echo $diff1->value ?>, <?php echo $diff2->value ?>, and <?php echo $diff3->value ?>. 
				<br />
			</td>
		</tr>
		<?php /*?><tr>
			<td><strong>Statements that Connect Pain with Value</strong></td>
		</tr>
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
			
				
				<?php
				      $techVal_tech_pain_biz_value = $this->campaign->get_busvalWithTechvalue_techpain($campaign_info->campaign_id);
				?>
				<ul>
				<?php
					if (isset($techVal_tech_pain_biz_value)):?>
							<?php $i= 0; ?>
							<?php foreach ($techVal_tech_pain_biz_value as $tech_pain_value_biz_val):?>
								
									<li>We help <?php 
											if($campaign_info->campaign_target == '1'){	
													 echo $campaign_info->individual;
												}else{ 
													echo $campaign_info->organization;
											}
										?> to deal with <?php echo $tech_pain_value_biz_val->tech_pain_val; ?>
								by helping to <?php echo $tech_pain_value_biz_val->tech_val ?>
								lead to <?php echo $tech_pain_value_biz_val->biz_value_val ?>
								</li>	
							<?php endforeach;?>
						<?php endif?>
					</ul>
				
				
				<br>
			</td>
		</tr>
		<tr>
			<td><strong>ROI Statements</strong></td>
		</tr>
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<ul>
					<li>
						We have helped  
						<?php 
							if($campaign_info->campaign_target == '1'){	
									 echo $campaign_info->individual;
								}else{ 
									echo $campaign_info->organization;
						} ?>
						to/with  <?php echo $active_name_drop_exp['provided']->value; ?> and that led to <?php echo $active_name_drop_exp['when']->value; ?>.
						
					</li>
				</ul>
				
				<br />
			</td>
		</tr><?php */?>
		
		<tr>
			<td><strong>Threats of Doing Nothing</strong></td>
		</tr>
		<tr><td><hr class="hrline" /></td></tr>
		<tr>
			<td>
				
				<ul>
					<li>Some things to be concerned with when not doing anything in this area are that you could experience: </span> </li>
				</ul>
				
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach ($campaign_output_tech_pain as $techpain):?>
							
								<li><?php echo $techpain->value ?></li>
							
						<?php endforeach;?>
					<?php endif?>
					
				</ul>
			
				<br />
			</td>
		</tr>
		<tr>
			<td><strong>Company Facts Statement</strong></td>
		</tr>
		<tr><td><hr class="hrline" /></td></tr>
		<tr>
			<td>
					<ul>
						<li>We have been in business for  <?php echo isset($company_meta['business_exp']) ? $company_meta['business_exp'] : 'experience'  ?>.</li>
						<li>We operate in <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
						<li>We have won awards for <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
						<li>Other key details about us are that we <?php echo $company_meta['interest'][0] ?> , <?php echo $company_meta['interest'][1] ?> and <?php echo $company_meta['interest'][2] ?>.</li>
					</ul>
				<br>
			</td>
		</tr>
</table>    
<?php echo $this->load->view('common/footer_outputs');?>