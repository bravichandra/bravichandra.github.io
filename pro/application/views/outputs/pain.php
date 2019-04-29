<?php $this->load->view('common/meta_outputs');?>
<title>PROSPECT PAIN POINTS</title>
</head>
<body>
	<div id="content">
		<?php if($action != 'download'){?>
			<?php 	$this->load->view('common/logo');?>
		<?php } ?>
		<h1 align="center">PROSPECT PAIN POINTS</h1>
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
					<td><strong>Technical Pain</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_tech_pain)):?>
								<?php foreach ($campaign_output_tech_pain as $techpain):?>
									
										<li><?php echo $techpain->value ?></li>
									
								<?php endforeach;?>
							<?php endif?>
						</ul>
						<br>
					</td>
				</tr>
				<tr>
					<td><strong>Business Pain</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_biz_pain)):?>
								<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									
										<li><?php echo $bizpain->value ?></li>
									
								<?php endforeach;?>
							<?php endif?>
						</ul>
						<br />
					</td>
				</tr>
				<tr>
					<td><strong>Personal Pain</strong></td>
				</tr>
				<tr><td class="border">&nbsp;</td></tr>
				<tr>
					<td>
						<ul>
							<?php if (isset($campaign_output_per_pain)):?>
								<?php foreach ($campaign_output_per_pain as $personalpain):?>
										<li><?php echo $personalpain->value ?></li>
								<?php endforeach;?>
							<?php endif?>
						</ul>
						<br />
					</td>
				</tr>
		</table>
	</div>
<?php echo $this->load->view('common/footer_outputs');?>