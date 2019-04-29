<?php $this->load->view('common/meta_outputs');?>
<title>Value Statements</title>
</head>
<body>
<div id="content">
	<?php if($action != 'download'){?>
		<?php 	$this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">Value Statements </h1>
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
				<td><strong>Simple Value Statements</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $technical):?>
								
									<li>We help <?php 
											if($campaign_info->campaign_target == '1'){	
													 echo $campaign_info->individual;
												}else{ 
													echo $campaign_info->organization;
											}
										?> to <?php echo $technical->value; ?>.</li>
								
							<?php endforeach;?>
						<?php endif?>
								
						 <?php /*?><li>We help  <?php 
											if($campaign_info->campaign_target == '1'){	
													 echo $campaign_info->individual;
												}else{ 
													echo $campaign_info->organization;
											}
										?>
							to <span class="" id=""><?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : Null);?></span>.
						</li><?php */?> 
					</ul>
					<br />
				</td>
			</tr>
			
			<tr>
				<td><strong>Product-based Statements</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
					<ul>
						<li> We provide <?php echo $P_Q1->value; ?>.</li>
						<li> We provide <?php echo $P_Q1->value; ?> and it <?php echo $product_desc->value; ?>.</li>
					</ul>
					<br>
				</td>
			</tr> 
			<tr>
				<td><strong>Statements that Connect Products with Technical Value</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
				    <ul>
					<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $singletech):?>
								<li>We provide  <?php echo $P_Q1->value; ?>  and it helps <?php 
										if($campaign_info->campaign_target == '1'){	
												 echo $campaign_info->individual;
											}else{ 
												echo $campaign_info->organization;
										}
									?> to <?php echo $singletech->value; ?>. 
								</li>
						<?php endforeach;?>
					<?php endif ?>
						<?php /*?><li>We provide  <?php echo $P_Q1->value; ?>  and it helps <?php 
										if($campaign_info->campaign_target == '1'){	
												 echo $campaign_info->individual;
											}else{ 
												echo $campaign_info->organization;
										}
									?> to <?php echo $campaign_tech_summary->value; ?>. 
								</li><?php */?>
					</ul>
					<br>
				</td>
			</tr>
		</table>
	</div>
	<?php $this->load->view('common/footer_outputs');?>