<?php $this->load->view('common/meta');?>	
<?php $this->load->view('common/header');?>
<style>
	.button {color:red;}
	.delete {font-size: 20px;}
	span[id*='hide_'] {color:red;cursor:pointer;}
	.ui-icon-closethick {
		background-position: -98px -128px;
	}
</style>
<link href="<?php echo base_url('css')?>/font.css" type="text/css" rel="stylesheet">

<!-- Sidebar begins -->
<div id="sidebar">
	<?php $this->load->view('common/left_navigation');?>
    <!-- Secondary nav -->
    <div class="secNav">    
    	<div class="clear"></div>
   </div>
</div>
<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
    <?php $this->load->view('common/campaign_nav');?>
	<?php
		//  var_dump($campaign_personal_parent);
		$i = 1;
		/* find productinfo */
		$getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
	?>
	
    <!-- Main content -->
    <div class="wrapper">
        <form id="frm-input" action="<?php echo current_url();?>" method="post">
			<h3 style="margin-top:30px;color: black;" id="PersonalHeading">
				<span style="color: #B30814;">Personal Benefits</span>
			</h3>
			<div class="widget tableTabs" id="PersonalDiv">			        
				<div class="tab_container">
					<div id="ttab1" class="tab_content">
						<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"  id="Pers_table_<?php echo $i;?>">
							<tbody id="PersTbody">
									
								<?php  $PersRowCounter = 1; ?>
								<?php 
								if($campaign_tech_pers_val) { 
								    foreach($campaign_tech_pers_val  as $singleTechPers) {
									?>
									<!-- technical value Q/A  related personal value -->
									<tr id="PersTR<?php echo $PersRowCounter;?>" class="PersTR_<?php  echo $singleTechPers->pers_id; ?> PerTrClass">
										<td class="no-border" colspan="3" width="70%">
											Does the benefit of
											<span class="dynamicFillBusArea_<?php echo $singleTechPers->pers_id ;?> TextColor">[<?php echo (!empty($singleTechPers->tech_val) ? $singleTechPers->tech_val : NULL);?>]</span>
											help the buyer in any personal ways like compensation, workload, stress, recognition, job security? 
											<br /> <br />
											<div align="right">
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												We help <span class="dynamicFillTecArea TextColor">
													
														<?php 
															echo $campaign_info->individual;
															/*
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
															}else{
																echo $campaign_info->organization;
															}
															*/
														?>
												</span> to 
												
												<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id;?>_<?php echo $singleTechPers->pers_id ;?> TextColor"><?php echo (!empty($singleTechPers->per_val) ? $singleTechPers->per_val : NULL);?></span>. -->
											</div>

											
										</td>
										<td class="no-border">
											<div class="grid5">
											<div align="center" class="TextColorH">Yes - How?</div>
											<textarea class="validate[required] vsp_p_table_<?php echo $i;?> dynamicTxt PersValues" name="tbl[pvd][<?php echo $singleTechPers->pers_id;?>][pers_value]" id="V<?php echo $campaign_info->campaign_id;?>_<?php echo $singleTechPers->pers_id;?>" style="width:350px;" cols="" rows="" onkeyup="PersdynamicText();"><?php echo $singleTechPers->per_val; ?></textarea>
											<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											
											</div>
										</td>
										<td class="no-border">
											<div class="grid4">
												<div align="center" class="TextColorH">No </div>
												<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singleTechPers->pers_id; ?>" onclick="hide_box_status('<?php echo $singleTechPers->pers_id; ?>','pvd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/>
											</div>
										</td>
									</tr>
								<?php }} ?>
									
								<?php if(!empty($campaign_personal_parent)) { ?>
								<?php foreach ($campaign_personal_parent as $singlePers){ ?>

									<tr id="PersTR<?php echo $PersRowCounter;?>" class="PersTR_<?php  echo $singlePers->pers_id; ?> PerTrClass">
										<td class="no-border" colspan="3" width="70%">
											Does the benefit of
											<span class="dynamicFillBusArea_<?php echo $singlePers->pers_id ;?> TextColor">[<?php echo (!empty($singlePers->biz_val) ? $singlePers->biz_val : NULL);?>]</span>
											help the buyer in any personal ways like compensation, workload, stress, recognition, job security?    
											<br /><br />
											<div align="right">
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												We help <span class="dynamicFillTecArea TextColor">
													
														<?php 
															echo $campaign_info->individual;
															
															/*
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
															}else{
																echo $campaign_info->organization;
															} */
														?>
												</span> to 
												<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id;?>_<?php echo $singlePers->pers_id ;?> TextColor"><?php echo (!empty($singlePers->per_val) ? $singlePers->per_val : NULL);?></span>. -->
											</div>
										
										
										</td>
										<td class="no-border">
											<div class="grid5">
												<div align="center" class="TextColorH">Yes - How?</div>
												<textarea class="validate[required] vsp_p_table_<?php echo $i;?> dynamicTxt PersValues" name="tbl[pvd][<?php echo $singlePers->pers_id;?>][pers_value]" id="V<?php echo $campaign_info->campaign_id;?>_<?php echo $singlePers->pers_id;?>" style="width:350px;" cols="" rows="" onkeyup="PersdynamicText();"><?php echo $singlePers->per_val; ?></textarea>
												<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											
											</div>
										</td>
										<td class="no-border"><div class="grid4">
											
											<div align="center" class="TextColorH">No </div>
											<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singlePers->pers_id; ?>" onclick="hide_box_status('<?php echo $singlePers->pers_id; ?>','pvd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/>
											
											</div>
										</td>
									</tr>
									
									<?php ++$PersRowCounter; ?>								
								<?php } } ?>		  

								<?php if($campaign_personal_orphan) { ?>	
									<?php foreach($campaign_personal_orphan  as $singleOrphanPers) {?>
										<tr id="PersTR<?php echo $PersRowCounter;?>" class="PerTrClass">
											<td class="no-border"  width="70%" colspan="3">
												Does 
												<span class="TextColor">
													<?php echo $getProdcutinfo->product_name; ?>
												</span>help 
												<span class="dynamicFillTecArea TextColor">
													<?php 
														if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
															}else{
																echo $campaign_info->organization;
														}
													?>
												</span>
												to create any other personal improvements?
												<br /> <br /><br />
												<div align="right">
													<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
													We help 
													<span class="dynamicFillTecArea TextColor">
														<?php 
															echo $campaign_info->individual;
															
															/*
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
																}else{
																	echo $campaign_info->organization;
															} */
														?>
													</span> to 
														<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id ;?>_<?php echo $singleOrphanPers->pers_id ?> TextColor"><?php echo (!empty($singleOrphanPers->per_val) ? $singleOrphanPers->per_val : NULL);?></span>. -->
												</div>
												
											</td>
											
											<td class="no-border">
												<div align="center" class="TextColorH">Personal Value</div>
												<textarea class="validate[required] dynamicTxt PersValues" style="width:350px;" name="tbl[pvd][<?php echo $singleOrphanPers->pers_id;?>][pers_value]" id="V<?php echo $campaign_info->campaign_id ;?>_<?php echo $singleOrphanPers->pers_id ;?>" cols="" rows="" onkeyup="PersdynamicText();"><?php echo (!empty($singleOrphanPers->per_val) ? $singleOrphanPers->per_val : NULL);?></textarea>
												<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
												
											</td>
											<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $singleOrphanPers->pers_id;?>','pvd','<?php echo $campaign_info->campaign_id ?>');">X</a></td>
										</tr>
									<?php  ++$PersRowCounter; ?>
									<?php } ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>	
				<div class="clear"></div>		 
			</div>
								
			<!-- <div align="right"><input type="button" style="margin-top:10px;color:white !important;" value="Add a Personal Benefits" onclick='DynamicAddRow("Pers_table_<?php echo $i;?>","P","<?php echo $product->product_id;?>","Yes","<?php echo $pro_1_value;?>","PersTRRadio<?php echo $PersRowCounter;?>")' class="buttonM bBlack" id="TechAnswerRadioId" name="TechAnswer" /></div> -->
			<div align="right">
				<input type="button" style="margin-top:10px;color:white !important;" value="Add a Personal Benefits" onclick='DynamicAddRowPerVal(this)' class="buttonM bBlack" id="TechAnswerRadioId" name="TechAnswer" />
			</div>
			
			<h3 id="show-pers-heading-summary" style="color: black; margin-top:30px;">
				<span style="color: #B30814;"> Consolidate Your Answers </span>
			</h3>
				<div id="show-pers" >
					<div class="widget tableTabs">
						<!-- <div class="whead"><h6>Personal Benefits</h6><div class="clear"></div></div> -->
						
						<div class="tab_container">
							<div id="ttab1" class="tab_content" style="min-height: 180px;">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<tr>
											<td colspan="3" class="no-border">
												<div style="margin-top:10px;margin-bottom:10px;margin-left: 5px;">
														 Either pick one below as the dominant, best, or most important point or compose as new answer that summarizes all points.
												</div>
											</td>
										</tr>
										<tr>
											<td class="no-border" width="30%">
												<div style="float:left;" id="pers-value" class="PervalueSummarydy">
													<ul class="bulletpoint">
													<?php if($campaign_tech_pers_val) {?>
														<?php foreach($campaign_tech_pers_val  as $singletechPersDY) {?>
															<li style="font-size: 98%;" class="PersVSumm_<?php echo $singletechPersDY->pers_id; ?>">
																<span class="TextColor dynamicTxt_V<?php echo $campaign_info->campaign_id; ?>_<?php echo $singletechPersDY->pers_id; ?>"><?php echo(isset($singletechPersDY->per_val) ? $singletechPersDY->per_val : NULL);?>
																</span>
															</li>
														<?php } ?>
															
													<?php } ?>
													
													<?php if($campaign_personal_parent) {?>
														
														
														<?php foreach($campaign_personal_parent  as $singleOrphanPers) {?>
															<li style="font-size: 98%;" class="PersVSumm_<?php echo $singleOrphanPers->pers_id; ?>">
																<span class="TextColor dynamicTxt_V<?php echo $campaign_info->campaign_id; ?>_<?php echo $singleOrphanPers->pers_id; ?>"><?php echo(isset($singleOrphanPers->per_val) ? $singleOrphanPers->per_val : NULL);?>
																</span>
															</li>
														<?php } ?>
													<?php } ?>
													
													<?php if($campaign_personal_orphan ) { ?>
														<?php foreach($campaign_personal_orphan  as $singleOrphanPers) {?>
															<li style="font-size: 98%;" class="PersVSumm_<?php echo $singleOrphanPers->pers_id; ?>">
																<span class="TextColor dynamicTxt_V<?php echo $campaign_info->campaign_id; ?>_<?php echo $singleOrphanPers->pers_id; ?>"><?php echo(isset($singleOrphanPers->per_val) ? $singleOrphanPers->per_val : NULL);?>
																</span>
															</li>
														<?php } ?>
													<?php } ?>
													</ul>
												</div>
											</td>
											<td class="no-border">
											     <br /><br />
												<div align="right" >
														<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
															We help 
															<span class="dynamicFillTecArea TextColor">
																<?php 
																	echo $campaign_info->individual;
																	/*
																	if($campaign_info->campaign_target == '1'){	
																		echo $campaign_info->individual;
																	}else{
																		echo $campaign_info->organization;
																	}
																	*/
																?>
															</span> to 
															<!-- <span class="dynamicTxt_Vpers-s TextColor"><?php // echo $campaign_personal_summary->value ?></span>. -->
												</div>
											</td>
											<td class="no-border" width="16%">
												<div style="float:right;">
													<div align="right" style="margin-right: 42px; margin-top: -25px;">
														<div align="center" class="TextColorH" style="">Personal Value</div>	 
														<textarea class="validate[required] dynamicTxt" id="Vpers-s" name="tbl[ccd][<?php echo $campaign_personal_summary->cam_com_id ?>][per_val_summary]" style="width:350px;" cols="" rows=""><?php echo (isset($campaign_personal_summary->value) ? $campaign_personal_summary->value : '');?></textarea>
														<!-- <div align="center" style="margin-left: 190px;" class="TextColorH">Answer Checker</div> -->
														
														<div id="4" data-icon="&#xe090;" style="margin-right: -23px;margin-top: -50px;" class="dialog_open fs1 iconb"></div>
													</div>
												</div>
											</td>
										
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>		 
					</div>
				</div>
				<script>
					// var	product_data = $.parseJSON('<?php // echo json_encode($product_data); ?>');
				</script>
				<div class="fluid" style="margin-top:15px;">
					<?php if($session_status != '2'):?>
						<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
						<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
						<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
						<input type="hidden" name="step" value="value3">
						<input type="hidden" id="redirect_url" name="redirect_url" value="">
					 <?php else:?>
						<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
						<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
						<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
						<input type="hidden" name="step" value="value3">
						<input type="hidden" id="redirect_url" name="redirect_url" value="">
					 <?php endif;?>
				</div>
			</form>
		</div>
	</div>
	</div>
</div>
<style>
.bulletpoint{ list-style: disc;padding: 0 10px;}
</style>

<script type="text/javascript">
	/**
	 *  this is name drop 
	 */
	function hide_box_status(id,srttbl_name,campain_id){
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."campaign/makingfielsddisabled/" ?>', 
			data : { 'meta_key' : srttbl_name, 'cid': campain_id,'p_id' : id},
			success : function(data){
				// console.log(data);
				// location.reload(false);
				// window.location=window.location;
				$('#frm-input').submit();
			}
		});
	}
	
	/***
	 *   dynamic add new personal question and answer 
	 *  
	 */
	function DynamicAddRowPerVal(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		
		var newiddy ;
		var numItems = $('.BizTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicPerValue" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#PersTbody').append(data);
				newiddy = $('.PersValuesDy:last').attr('id');
				var newvaluetoadd = $('.PersValuesDy:last').val();
				// console.log(newiddy);
				var newaddele = '<li class="summarybx" style="font-size: 98%;">'
								+'<span class="TextColor dynamicTxt_'+newiddy
								+'">'+newvaluetoadd+'</span></li >';
				$('.bulletpoint').append(newaddele);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
			}
		});
	}
</script>
<?php $this->load->view('common/footer');?>