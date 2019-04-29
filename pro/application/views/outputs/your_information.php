<?php $this->load->view('common/meta_outputs');?>
<title>Post-Call Email – Your Information</title>
</head>
<body>
<div id="content">
	<?php
		$url = current_url();
		$templatename_ref = end(explode('/',$url));
		if($action != 'download'){
	?>
	<div class="sendtosalesforce"><a target="_blank" href="http://salesscripter.com/pro/page1.php?template=<?php echo $templatename_ref;?>" title="Send to Salesforce"><img src="http://salesscripter.com/pro/images/icons/download1.png"/></a></div>
    <?php } ?>
    <?php if($action != 'download'){?> 
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">Post-Call Email – Your Information</h1>
	<p class="topTxt">
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
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
			<td>
				<p><strong>Subject line:</strong> Following up our conversation - <span> <?php echo $company_info->company_name; ?> </span> </p>
		        <p><strong>Email body:</strong></p>
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        
		        <p>It was good to briefly talk with you today. Here is some more information on us and why I am reaching out to you.</p>
				
				<p>
					A lot of  <?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>. that we work with have challenges with or concerns around:
					
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $single_tech_pain):?>
								<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_pain->value;?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $single_biz_pain):?>
								<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="bpd_<?php echo $single_biz_pain->biz_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_biz_pain->value;?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						<?php if (isset($campaign_output_per_pain)):?>
								<?php foreach ($campaign_output_per_pain as $single_per_pain):?>
									<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ppd_<?php echo $single_per_pain->per_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_per_pain->value;?></span></li>
								<?php endforeach;?>
						<?php endif;?><?php */?>
					</ul>
				</p>
		        
		        <p>I don't know if you are concerned about any of those but we help to resolve and mitigate those challenges by driving the following improvements:  
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $single_tech_value):?>
								<li><span class="<?php echo 'dynamic_value edit_area1' ;?>" id="tpnd_<?php echo $single_tech_value->tech_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_value->value;?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $single_biz_val):?>
								<li><span class="<?php echo 'dynamic_value edit_area1' ;?>" id="bpd_<?php echo $single_biz_val->biz_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_biz_val->value;?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						<?php if (isset($campaign_output_per_val)):?>
								<?php foreach ($campaign_output_per_val as $single_per_val):?>
									<li><span class="<?php echo 'dynamic_value edit_area1' ;?>" id="ppd_<?php echo $single_per_val->per_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_per_val->value;?></span></li>
								<?php endforeach;?>
						<?php endif;?><?php */?>
					</ul>
				
				</p>
				<p>We do this by providing <?php echo $P_Q1->value; ?> which <?php echo $product_desc->value; ?>.</p>
				<p>
					Some ways that we differ from other options out there are <?php echo $diff1->value; ?>  <?php echo $diff2->value; ?>, and <?php echo $diff3->value; ?>.
				</p>
				
				<p>
					For example, if we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo  $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.
				</p>
				
				<p> Other details about us are: 
					<ul>
						<li>We have been in business for  <?php echo isset($company_meta['business_exp']) ? $company_meta['business_exp'] : 'experience'  ?>.</li>
						<li>We operate in <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
						<li>We have won awards for <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
						<li>Other key details about us are that we <?php echo $company_meta['interest'][0] ?> , <?php echo $company_meta['interest'][1] ?> and <?php echo $company_meta['interest'][2] ?>.</li>
					</ul>
				
				</p>
				
		        <p>If you are interested in talking before then, I can schedule a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				<p>Best Regards,</p>
		        <p>
		        	<span> <?php echo $company_meta['your_name']; ?> </span>  <br />
		            <span> <?php echo $company_meta['your_title']; ?> </span> <br />
		            <span> <?php echo $company_info->company_name; ?> </span> <br />
		            <span> <?php echo $company_meta['your_phone']; ?> </span> <br />
		            <span> <?php echo $company_meta['your_email']; ?> </span> <br />
		        </p>
		        <br>
			</td>
		</tr>
		
	</table>
</div>
<style type="text/css" >
.td-pad-b {
    padding-bottom: 17px;
    width: 20%;
}
</style>	
<?php echo $this->load->view('common/footer_outputs');?> 