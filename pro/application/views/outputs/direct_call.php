<html>
<head>
<style type="text/css">
body {font-size:13px;font-family: Arial, Helvetica, sans-serif;color:#000;}

ul {margin-bottom:0;}

#content {margin:0 auto;width:990px;overflow:hidden;}
#content, table.output, table.output table {font-size:13px;font-weight: normal !important;line-height: 1.85px;}

table.output tr th {font-weight: bold;font-size:13px;}
table.output tr td span {}
table.output tr td.border {border-top:1px solid #000;}
table.output tr td.border-bottom {border-bottom:1px solid #000;}

h1 { font-size:16px;}
p.topTxt {font-size: 13px; text-align: center; font-weight:bold;}

span.red, span.red-area, .red-area {color:red;}

</style>

<?php if($button == True):?>

<style type="text/css">
table, caption, tbody, tfoot, thead, tr, th, td { margin: 0; padding: 0; border: 0; outline: 0; vertical-align: baseline; }
body, #content, table.output, table.output table {line-height: 18px;}

span.edit_area:hover {background: #F2F0A5;}

.td-pad-b {padding-bottom:17px;}

.btnDownload {background:url("../images/btn-download.jpg");width:108px;height:69px;display:block;}
.btnDownload:hover {background-position:0 -69px;}
</style>

<link rel="shortcut icon" href="http://salesscripter.com/wp-content/themes/Avada/images/favicon.ico" />
<link href="<?php echo base_url();?>css/jeditable_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jeditable.js"></script>
<script>
$(document).ready(function() {

    $('.edit_area').editable('<?php echo base_url();?>product/dy_cam_up_entry', { 
    	   name       : 'value',
           id         : 'id',
    	   type : 'textarea',
    	   submit   : 'Update',
    	   width      : '400px',
           height     : '100px',
           tooltip : "Click to edit...",
           style : "",
           requireProductTxt : "[Requires another product to be added]",
           clsName				: 'edit_area',
           callback : function(value, settings) {
           }
    });

});
</script>
<?php endif; ?>
<title>Call Script – Quick Close </title>
</head>
<body>
	<div id="content">
		<?php if($action != 'download'){ ?>
			<?php echo $this->load->view('common/logo');?>
		<?php } ?>
		
		<h1 align="center">Call Script &#45; Quick Close</h1>
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
			<tr><td colspan="3" class="border-bottom">&nbsp;</td></tr>
			<tr style="border-bottom:1px solid #000;">
				<td style="width:15%;"><strong>Objective:</strong></td>
				<td style="width:5%">&nbsp;</td> 
				<td style="width:80%;">Option A: <span class="dynamic_value edit_area" id="ccd_<?php echo $sale_process_close1->cam_com_id ?>_<?php echo $campaign_info->campaign_id; ?> "><?php echo (!empty($sale_process_close1->value) ? $sale_process_close1->value : $this->config->item('message'));?></span> 
				<br/> Option B:  <span class="dynamic_value edit_area" id="ccd_<?php $sale_process_close3->cam_com_id ?>_<?php echo $campaign_info->campaign_id; ?>"><?php echo (!empty($sale_process_close3->value) ? $sale_process_close3->value : $this->config->item('message'));?></span></td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
				  
			<tr>
				<td class="td-pad-b"><strong>Introduction to Gatekeeper</strong><br></td>
				<td>&nbsp;</td>
				<td>Hello, I am trying to connect with  <span class="red-area">
				<?php 
					if($campaign_info->campaign_target == '1'){	
							echo $campaign_info->individual;
						}else{
							echo $campaign_info->organization;
					}
				?></span>. Can you point me in the right direction?
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
			<tr>
				<td class="td-pad-b"><strong>Introduction to Target Contact</strong></td>
				<td>&nbsp;</td>
				<td>Hello  <span class="red-area">[Contact's Name]</span>, this is  <span><?php echo $company_meta['your_name'] ?></span> from  <span><?php echo $active_name_drop_exp['worked']->credibility_name; ?></span>, have I caught you in the middle of anything?<br>
					
					<p><span class="red-area">(If not available respond with below)</span></p>
					
					<p>Oh, I understand. I can be very brief or I can call you back at another time, which do you prefer?</p>
						
					<span class="red-area"> -or- </span>
					
					<p>Oh, I understand. When would be the best time for me to call you back?</p>
					<br/>
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
			<tr>
				<td><strong>Close</strong></td>
				<td>&nbsp;</td>
				<td class="td-pad-b">
						And what I would like to do is schedule a/an <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close1->value ) ? $sale_process_close1->value: '');?></span> where we can <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close2->value) ? $sale_process_close2->value : '');?></span>.<br/>
						Are you available to put this on the calendar next Tuesday or Thursday morning? <br>
				
						<p><span class="red-area"> (If not able to close for meeting, move to next section)</span></p>
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
			
			<tr>
				<td><strong>Value Statement</strong></td>
				<td>&nbsp;</td>
				<td>
					<span class="red-area">(If they want to know more about what you do) </span>
					Great. The Purpose of my call is that &#45; <span class="red-area">(Choose one of below)</span>
					<ul>
						<li>We help  
							<span class="dynamic_value edit_area_old" id=""><?php 
								if($campaign_info->campaign_target == '1'){	
										echo $campaign_info->individual;
									}else{
										echo $campaign_info->organization;
								}
							?></span> to  
							<span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $campaign_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : NULL);?></span>.
						</li>
					   <li>We help  
							<span class="dynamic_value edit_area_old" id=""><?php 
								if($campaign_info->campaign_target == '1'){	
										echo $campaign_info->individual;
									}else{
										echo $campaign_info->organization;
								}
							?></span> to  
							<span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $campaign_biz_summary->cam_com_id ;?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($campaign_biz_summary->value) ? $campaign_biz_summary->value : NULL);?></span>.
						</li>
						<li>We help  
							
							<span class="dynamic_value edit_area_old" id=""><?php 
								if($campaign_info->campaign_target == '1'){	
										echo $campaign_info->individual;
									}else{
										echo $campaign_info->organization;
								}
							?></span> to  
							<span class="<?php echo  'dynamic_value edit_area' ?>" id="ccd_<?php echo $campaign_per_summary->value;  ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($campaign_per_summary->value) ? $campaign_per_summary->value : Null);?></span>.
						</li>
						<li>We provide  
							<span class="<?php echo  'dynamic_value edit_area_old'?>" id=""><?php echo (isset($P_Q1->value) ?  $P_Q1->value : NULL);?></span>.
						</li>
					</ul>
				<br>
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
			<tr>
				<td><strong>Pre-Qualifying Questions</strong></td>
				<td>&nbsp;</td>
				<td>
					<p>Great, if I could ask you real quick:</p>
					<p><span class="red-area">(Ask 3 to 5 of below)</span></p>
					<strong>Technical Questions:</strong>
						
						<?php if (isset($campaign_output_tech_qualify)):?>
							<ul>
								<?php foreach ($campaign_output_tech_qualify as $single_tech_qualify):?>
									<?php // print_r($single_tech_value) ?>
									<li><span class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $single_tech_qualify->tech_q_id ?>_<?php echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_qualify->value;?></span></li>
								<?php endforeach;?>
							</ul>
						<?php endif;?> 
						
						<br/>
						<strong>Business Questions:</strong>
							<?php if (isset($campaign_output_biz_qualify)):?>
								<ul>
									<?php foreach ($campaign_output_biz_qualify as $single_biz_qualify):?>
											<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="bqd_<?php echo $single_biz_qualify->biz_q_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_biz_qualify->value;?></span></li>
									<?php endforeach;?>
								</ul>
							<?php endif;?>
						<br/>
						<strong>Personal Questions:</strong>
							<?php if (isset($campaign_output_per_qualify)):?>
								<ul>
									<?php foreach ($campaign_output_per_qualify as $single_per_qualify):?>
											<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="pqd_<?php echo $single_per_qualify->per_q_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_per_qualify->value;?></span></li>
									<?php endforeach;?>
								</ul>
							<?php endif;?>
						<br/>
						<p><span class="red-area">(If you get an answer that justifies moving on to <?php echo $sale_process_close1->value ?>, skip ahead to closing for a <?php echo $sale_process_close1->value ?>)</span></p>

						<p><span class="red-area">(If you do not, move to next section) </span></p>
						<br/>
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
			<tr>
				<td><strong>Examples of Common Problems</strong></td>
				<td>&nbsp;</td>
				<td>Oh, OK. Well, as we talk with other <span class="dynamic_value "><?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}
						?></span>, we have noticed that they often express challenges with <span class="red-area">(or concerns around)</span>: <br/>
						<br/>
						<strong>Technical Pain</strong>
								<?php if (isset($campaign_output_tech_pain)):?>
									<ul>
										<?php foreach ($campaign_output_tech_pain as $single_tech_pain):?>
											<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_pain->value;?></span></li>
										<?php endforeach;?>
									</ul>
								<?php endif;?> 
							
						  <br/>
						  <strong>Business Pain</strong>
								<?php if (isset($campaign_output_biz_pain)):?>
									<ul>
										<?php foreach ($campaign_output_biz_pain as $single_biz_pain):?>
											<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="bpd_<?php echo $single_biz_pain->biz_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_biz_pain->value;?></span></li>
										<?php endforeach;?>
									</ul>
								<?php endif;?>				 
						   <br/>
							<strong>Personal Pain</strong>
								<?php if (isset($campaign_output_per_pain)):?>
									<ul>
										<?php foreach ($campaign_output_per_pain as $single_per_pain):?>
											<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ppd_<?php echo $single_per_pain->per_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_per_pain->value;?></span></li>
										<?php endforeach;?>
									</ul>
								<?php endif;?>
							<p>Can you relate to any of those?</p>
							<p><span class="red-area">-or-</span></p>
							<p>Which one of those are you most concerned with?</p>
							<p><span class="red-area">(If you get an answer that justifies moving on to <?php echo $sale_process_close1->value ?>, skip ahead to closing for a <?php echo $sale_process_close1->value ?>)</span></p>
							<p><span class="red-area">	(If you do not, move to next section)</span></p>
							
							
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>
			<tr>
				<td><strong>Information About Us</strong></td>
				<td>&nbsp;</td>
				<td>Well, based on what you shared, it might productive for us to talk in more detail.  The reason why is<br/>
				<span class="red-area">(Share any of the below as appropriate as you try to trigger interest)</span><br><br>
					<strong>Product Details:</strong>
					<ul>
						<li>As I said, I am with <span><?php  echo $company_info->company_name; ?></span> and we provide <?php echo $P_Q1->value; ?></li>
						
						<li>Our <span class="dynamic_value edit_area_old" id=""><?php echo $P_Q1->value; ?></span>  <?php echo $product_desc->value; ?></li>
					</ul>
					<br/>
					<strong>Connect Pain with Value:</strong>
						<ul>
							<li>We help <?php 
									if($campaign_info->campaign_target == '1'){	
											echo $campaign_info->individual;
										}else{
											echo $campaign_info->organization;
									}
								?> to deal with <?php echo $campaign_output_tech_pain[0]->value ?> by helping to
								<?php echo $campaign_output_tech_val[0]->value ?>and this can typically lead to <?php echo $campaign_output_biz_val[0]->value ?>
							</li>
						</ul>
					<br>
					<strong>ROI Statements:</strong>
						<ul>
						
							<li>We have helped  
								<span class="<?php echo 'dynamic_value edit_area_old' ?>" id="">
									<?php 
										if($campaign_info->campaign_target == '1'){	
												echo $campaign_info->individual;
											}else{
												echo $campaign_info->organization;
										}
									?>
								</span> to <?php echo $active_name_drop_exp['provided']->value   ?> and that led to <span class="<?php echo 'dynamic_value edit_area' ?>" id=""><?php echo $active_name_drop_exp['when']->value   ?></span>.</li>
								
						</ul>
					<br/>
					<strong>Differentiation:</strong>
						<ul>
							<li>Some ways that we differ from other options out there are <span class="<?php echo 'dynamic_value edit_area_old'; ?>" id=""><?php echo (!empty($diff1->value) ? $diff1->value : NULL);?></span>, <span class="<?php echo 'dynamic_value edit_area_old';?>" id=""><?php echo (!empty($diff2->value) ? $diff2->value : NULL);?></span>, and <span class="<?php echo  'dynamic_value edit_area'; ?>" id=""><?php echo (!empty($diff3->value) ? $diff3->value : NULL);?></span></li>
						</ul>
					<br>
					<strong>Name Drop: </strong>
					<ul>
					  <li> We worked with <?php echo $active_name_drop_exp['worked']->credibility_name ?> and provided <?php echo  $active_name_drop_exp['worked']->value ?>. </li> 
					  <li> This helped them to <?php echo  $active_name_drop_exp['provided']->value ?>, which led to <?php echo  $active_name_drop_exp['when']->value ?>. </li>
					</ul>
					<br/>
					<strong>Threats of Doing Nothing:</strong>
						<ul>				    
							<li>Some things to be concerned with when not doing anything in this area are <span class="<?php 'dynamic_value edit_area_old' ?>" id=""><?php echo (!empty($negative_impact1->value) ? $negative_impact1->value : NULL);?></span>, <span class="<?php echo 'dynamic_value edit_area_old'; ?>" id=""><?php echo (!empty($negative_impact2->value) ? $negative_impact2->value : NULL);?></span>, and <span class="<?php echo 'dynamic_value edit_area_old' ;?>" id=""><?php echo (!empty($negative_impact3->value) ? $negative_impact3->value : NULL);?></span></li>				
						</ul>
					<br/>
					<strong>Company Facts:</strong>
						
						<?php // print_r($company_meta); ?>
						
						<ul>
							<li>We have been in business for  <?php echo isset($company_meta['business_exp']) ? $company_meta['business_exp'] : 'experience'  ?>.</li>
							<li>We operate in <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
							<li>We have won awards for <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
							<li>Other key details about us are that we <?php echo $company_meta['interest'][0] ?> , <?php echo $company_meta['interest'][1] ?> and <?php echo $company_meta['interest'][2] ?>.</li>
						</ul>
						
					<span class="red-area"> (Redirect back to close at this point) </span>
					<br>
				</td>
			</tr>
			<tr><td colspan="3" class="border">&nbsp;</td></tr>			
		</table>
	</div>
	<br/>
	<div align="center" style="margin-top:15px; font-size:12px; clear:both;">Helpful information can be found at <a href="www.salesscripter.com/library" target="_blank">www.salesscripter.com/library</a><br />
							Contact us at (713) 802-2026 / info@salesscripter.com<br />
							Copyright 2012-2015 SalesScripter, LLC  All Rights Reserved
	</div>
	<?php if($button == True):?>
		<div style="margin:10px 0;" align="center">
					<a href="<?php echo base_url(); ?>output/<?php echo $method_name;?>/download" class="btnDownload" title="Download">&nbsp;</a>
			</div>
	<?php endif;?>
</body>
</html>