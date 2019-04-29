<?php $this->load->view('common/meta_outputs');?>
<title>Ideal Prospect Profile</title>

<style type="text/css">
table, th, td {
    border: 1px solid black;
}
</style>

</head>
<body>
<div id="content">
	<?php if($action != 'download'){?>
		<?php 	$this->load->view('common/logo');?>
	<?php } ?>
	
	<h1 align="center">IDEAL PROSPECT PROFILE</h1>
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
	<table width="100%"  cellspacing="0" cellpadding="0" class="output" style="margin: 0 auto; border: 1px solid black;">
		<tr >
			<td width="48%">
			 <strong>Demographic Details</strong>
			</td>
			
			<td width="48%"><strong>Environmental Details</strong></td>
		</tr> 
		<tr>
			<td>
				<strong>Title or Role:<strong>
					<ul>
						<li> <?php echo $campaign_info->individual; ?> </li>
					</ul>
					<br /><br />
			</td>
			
			<td> 
				<strong>Technical</strong>
		      <ul>
		       		<?php if(isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $technicalpain):?>										
									<li><span class="<?php echo (!empty($technicalpain->value) ? 'dynamic_value ' : '');?>" id=""><?php echo $technicalpain->value;?></span></li>
									
							<?php endforeach;?>
					<?php endif; ?>		
		      </ul>
		
			</td>
		</tr>
		<tr>	
			<td>
				<strong>Type of organization:<strong>
					<ul>
						<li> <?php echo $campaign_info->organization; ?></li>
					</ul>	
				<br /><br />
			</td>
			<td>
		      <strong>Business pain</strong>
		      <ul>
		       		<?php if(isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>										
									<li><span class="<?php echo (!empty($bizpain->value) ? 'dynamic_value ' : '');?>" id=""><?php echo $bizpain->value;?></span></li>
									
							<?php endforeach;?>
					<?php endif; ?>	
		      </ul>
		      <br />
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
			  <strong>Personal</strong>
			      <ul>
			       		<?php if(isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personlapain):?>										
									<li><span class="<?php echo (!empty($personlapain->value) ? 'dynamic_value ' : '');?>" id=""><?php echo $personlapain->value;?></span></li>
									
							<?php endforeach;?>
						<?php endif; ?> 
			      </ul>
			    
			</td>
		</tr>
	</table>
		<!-- <div align="right"><a href="http://leadferret.com/search" target="_blank"><img src="<?php echo $img_dir; ?>lf.jpg" width="200" style="border: 0 none;"/></a></div> -->
</div>
<?php $this->load->view('common/footer_outputs');?> 