<?php $this->load->view('common/meta_outputs');?>
<title>Product Matrix</title>
<style>
table.matrix {border:0px;border-bottom:1px solid #666666; border-right:1px solid #666666;}
table.matrix tr {background:#fff;}
table th{text-align:left !important; width:25%; padding-left:5px !important;}
table.matrix td {padding:10px 15px 0px 10px !important; border-bottom:none; border-right:none; }
.th-pad-h{ padding:10px 5px 0px 10px !important; border-bottom:none; border-right:none; }
.td-pad-b {vertical-align: top;padding:10px 15px 5px 10px !important; border-bottom:none; border-right:none;}
table.matrix ul{margin-left: -25px !important;}
table.matrix ul li{margin-bottom: 7px;}
caption, tbody, tfoot, th, td {    border: 1px solid #666666;}
</style>
</head>
<body>
	<div id="content">
		<?php if($action != 'download'){?>
			<?php 	$this->load->view('common/logo');?>
		<?php } ?>
		<h1 align="center">Product Matrix</h1>
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
		
		<table border="0" width="100%" cellspacing="0" cellpadding="0" class="matrix">
						<tr>
							<th class="th-pad-h">Product</th>
							<th class="th-pad-h">Functionality</th>
							<th class="th-pad-h">Benefits</th>
							<th class="th-pad-h">Problems Resolved</th>
						</tr>
						<tr>
							<td class="td-pad-b"><?php echo ucfirst($P_Q1->value); ?></td>
							<td class="td-pad-b"><?php echo ucfirst($product_desc->value); ?></td>
							<td class="td-pad-b">
								<ul>
								<?php if (isset($campaign_output_tech_val)):?>
									<?php foreach ($campaign_output_tech_val as $techval):?>
											<li><?php echo ucfirst($techval->value) ?></li>
									<?php endforeach;?>
								<?php endif?>
								</ul>
							</td>
							<td class="td-pad-b">
								<ul>
								<?php if (isset($campaign_output_tech_pain)):?>
									<?php foreach ($campaign_output_tech_pain as $techpain):?>
										
											<li><?php echo ucfirst($techpain->value) ?></li>
										
									<?php endforeach;?>
								<?php endif?>
							</ul>
							
							
							</td>
							<?php /*?><td>
								<ul>
									<?php if (isset($campaign_output_biz_pain)):?>
										<?php foreach ($campaign_output_biz_pain as $bizpain):?>
												<li><?php echo $bizpain->value ?></li>
										<?php endforeach;?>
									<?php endif?>
								</ul>
							</td>
							<td>
								<ul>
									<?php if (isset($campaign_output_per_pain)):?>
										<?php foreach ($campaign_output_per_pain as $personalpain):?>
												<li><?php echo $personalpain->value ?></li>
										<?php endforeach;?>
									<?php endif?>
								</ul>
							</td><?php */?>
						</tr>
					</table>
	</div>
<?php echo $this->load->view('common/footer_outputs');?>