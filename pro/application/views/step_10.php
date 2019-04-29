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
    <!-- Main content -->
    <div class="wrapper">
        <form id="frm-input" action="<?php echo current_url();?>" method="post">
			<h3 style="margin-top:30px;color: black" id="BusinessHeading">
			   <span style="color: #B30814;">Business Benefits</span> 					   
			</h3>
			<?php $i = 1;?>
			<?php
			   /* find productinfo */
			   $getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
			?>
			
			<?php if($campaign_tech) { ?>		
				<div class="widget tableTabs" id="BusinessDiv">
					<div class="tab_container">
						<div id="ttab1" class="tab_content">
							<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"  id="Bus_table_<?php echo $i;?>">
								<tbody id="BusTbody"> 

									<?php $BusRowCounter = 1; ?>
									<?php foreach($campaign_tech  as $singletech) { ?>
										<?php
											// for each eh value find question 
											$bussinesvalue = $this->campaign->getBusinessValue($singletech->tech_v_id); 	
										?>
										<?php if($bussinesvalue) { 
												foreach($bussinesvalue as $singlebussines) {
											?>
		
											<?php if($singlebussines->qus_id==1){ ?>
												<tr id="BusTR<?php echo $BusRowCounter; ?>" class="BussTR_<?php echo $singlebussines->biz_v_id;?> BizTrClass" >
												
													<td class="no-border" colspan="3" >
														Does the benefit of
														<span class="dynamicFillTecArea_<?php echo  $singletech->campaign_id ;?> TextColor">[<?php echo (!empty($singletech->value) ? $singletech->value : NULL);?>]</span>
														help 																
													   <span class="TextColor">
															<?php 
																if($campaign_info->campaign_target == '1'){	
																		echo $campaign_info->individual;
																	}else{
																		echo $campaign_info->organization;
																}
															?>
													   </span> 
													   to increase revenue?
													   <br /><br />
													   <div align="right">
															<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
																We help <span class="dynamicFillTecArea TextColor">
																	<?php 
																		if($campaign_info->campaign_target == '1'){	
																			echo $campaign_info->individual;
																			}else{
																				echo $campaign_info->organization;
																		}
																	?>
																</span> 
																to 
																<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id;?>_<?php echo $singlebussines->biz_v_id;?> TextColor"><?php echo (!empty($singlebussines->value) ? $singlebussines->value : NULL);?></span>. -->
														</div>
													</td>
													<td class="no-border" width="20%" >
														<div class="grid5">
														<div align="center" class="TextColorH">Yes - How?</div>
														<textarea class="validate[required] dynamicTxt vs_p_table_<?php echo $i;?> dynamicFillBus_<?php echo $singlebussines->biz_v_id;?> BusValues" name="tbl[bvd][<?php echo $singlebussines->biz_v_id; ?>][biz_value]" id="V<?php echo $campaign_info->campaign_id; ?>_<?php echo $singlebussines->biz_v_id;?>" style="width:350px;" cols="" rows="" onkeyup="BusdynamicText();"><?php echo $singlebussines->value; ?></textarea>
														<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
														
														</div>
													</td>
													<td class="no-border"><div class="grid4"><div align="center" class="TextColorH">No </div>
													<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singlebussines->biz_v_id;?>" onclick="hide_box_status('<?php echo $singlebussines->biz_v_id;?>','bvd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/></div></td>
												</tr>
											<?php }elseif($singlebussines->qus_id == 2){ ?>
													<tr id="BusTR<?php echo $BusRowCounter;?>" class="BussTR_<?php echo $singlebussines->biz_v_id;?> BizTrClass" >
														
															<td class="no-border" colspan="3" >
																Does the benefit of
																<span class="dynamicFillTecArea_<?php echo  $singletech->campaign_id; ?> TextColor">[<?php echo (!empty($singletech->value) ? $singletech->value : NULL);?>]</span>
																help 																
															   <span class="TextColor">
																	<?php 
																		if($campaign_info->campaign_target == '1'){	
																				echo $campaign_info->individual;
																			}else{
																				echo $campaign_info->organization;
																		}
																	?>
															   </span> 
															   to decrease costs?
															   <br /><br />
															   <div align="right">
																	<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
																	We help <span class="dynamicFillTecArea TextColor">
																		<?php 
																			if($campaign_info->campaign_target == '1'){	
																					echo $campaign_info->individual;
																				}else{
																					echo $campaign_info->organization;
																			}
																		?>
																	</span> 
																	to 
																	<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id ;?>_<?php echo $singlebussines->biz_v_id;?> TextColor"><?php echo (!empty($singlebussines->value) ? $singlebussines->value : NULL);?></span>. -->
																</div>
															</td>
															<td class="no-border" width="20%" >
																<div class="grid5">
																<div align="center" class="TextColorH">Yes - How?</div>
																<textarea class="validate[required] dynamicTxt vs_p_table_<?php echo $i;?> dynamicFillBus_<?php echo $singlebussines->biz_v_id;?> BusValues" name="tbl[bvd][<?php echo $singlebussines->biz_v_id; ?>][biz_value]" id="V<?php echo $campaign_info->campaign_id; ?>_<?php echo $singlebussines->biz_v_id;?>" style="width:350px;" cols="" rows="" onkeyup="BusdynamicText();"><?php echo $singlebussines->value; ?></textarea>
																<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
																
																</div>
															</td>
															<td class="no-border"><div class="grid4"><div align="center" class="TextColorH">No </div>
															 <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singlebussines->biz_v_id;?>" onclick="hide_box_status('<?php echo $singlebussines->biz_v_id;?>','bvd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/></div></td>
														</tr>
												<?php }elseif ($singlebussines->qus_id == 3){ ?>				
													<tr id="BusTR<?php echo $BusRowCounter;?>" class="BussTR_<?php echo $singlebussines->biz_v_id;?> BizTrClass" >
													
														<td class="no-border " colspan="3" >
															Does the benefit of
															<span class="dynamicFillTecArea_<?php echo  $singletech->campaign_id ;?> TextColor">[<?php echo (!empty($singletech->value) ? $singletech->value : NULL);?>]</span>
															help 																
														   <span class="TextColor">
																<?php 
																	if($campaign_info->campaign_target == '1'){	
																		echo $campaign_info->individual;
																		}else{
																			echo $campaign_info->organization;
																	}
																?>
														   </span> 
														   to  improve the services they provide?
														   <br /><br />
														   <div align="right">
																<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
																We help <span class="dynamicFillTecArea TextColor">
																	<?php 
																		if($campaign_info->campaign_target == '1'){	
																			echo $campaign_info->individual;
																		}else{
																			echo $campaign_info->organization;
																		}
																	?>
																</span> 
																to 
																<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id;?>_<?php echo $singlebussines->biz_v_id;?> TextColor"><?php echo (!empty($singlebussines->value) ? $singlebussines->value : NULL);?></span>. -->
															</div>
														   
														   
														</td>
														<td class="no-border" width="20%" >
															<div class="grid5">
																<div align="center" class="TextColorH">Yes - How?</div>
																<textarea class="validate[required] dynamicTxt vs_p_table_<?php echo $i;?> dynamicFillBus_<?php echo $singlebussines->biz_v_id;?> BusValues" name="tbl[bvd][<?php echo $singlebussines->biz_v_id; ?>][biz_value]" id="V<?php echo $campaign_info->campaign_id; ?>_<?php echo $singlebussines->biz_v_id;?>" style="width:350px;" cols="" rows="" onkeyup="BusdynamicText();"><?php echo $singlebussines->value; ?></textarea>
																<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
															
															</div>
														</td>
														<td class="no-border"><div class="grid4"><div align="center" class="TextColorH">No </div>
														  <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singlebussines->biz_v_id;?>" onclick="hide_box_status('<?php echo $singlebussines->biz_v_id;?>','bvd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/></div></td>
													</tr>
												<?php }?>
												
											
											
											<?php } ?>
										<?php } ?>
										<?php } ?>
										
										  <?php
											/** find all those bussiness value which have no parent records  **/
											$orphan_business_value = $this->campaign->getBizValueOrphan($campaign_info->campaign_id);
											// var_dump($orphan_business_value);
											?>
										
										   <?php if($orphan_business_value) { ?>
												<?php foreach($orphan_business_value  as $sin_orp_bus_val) { ?>
													<tr id="BusTR<?php echo $BusRowCounter;?>" class="BizTrClass">
														<td class="no-border" colspan="3" >
															Does 
															<span class="TextColor">
																<?php echo $getProdcutinfo->product_name; ?>
															</span> help 
															<span class="dynamicFillTecArea TextColor">
																<?php 
																	if($campaign_info->campaign_target == '1'){	
																		echo $campaign_info->individual;
																		}else{
																			echo $campaign_info->organization;
																	}
																?>
															</span>
															
															to create any other business improvements?
															<br /><br />
															<div align="right">
																<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
																We help 
																<span class="dynamicFillTecArea TextColor">
																	<?php 
																		if($campaign_info->campaign_target == '1'){	
																			echo $campaign_info->individual;
																			}else{
																				echo $campaign_info->organization;
																		}
																	?>
																</span> to 
																<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id;?>_<?php echo $sin_orp_bus_val->biz_v_id;?> TextColor"><?php echo (!empty($sin_orp_bus_val->value) ? $sin_orp_bus_val->value : NULL);?></span>. -->
															</div>
													
														</td>
														
														<td class="no-border">
															<div align="center" class="TextColorH">Business Value</div>
																<textarea class="validate[required] dynamicTxt BusValues" style="width:350px;" name="tbl[bvd][<?php echo $sin_orp_bus_val->biz_v_id; ?>][biz_value]" id="V<?php echo $campaign_info->campaign_id;?>_<?php echo $sin_orp_bus_val->biz_v_id;?>" cols="" rows="" onkeyup="BusdynamicText();"><?php echo (!empty($sin_orp_bus_val->value) ? $sin_orp_bus_val->value : NULL);?></textarea>
															    <!-- <div align="center" class="TextColorH">Answer Checker</div> -->
															
														</td>
														<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $sin_orp_bus_val->biz_v_id;?>', 'bvd','<?php echo $campaign_info->campaign_id ?>');">&times;</a></td>
													</tr>
											 <?php } ?>
											<?php } ?>
										
												 
								</tbody>
							</table>
						</div>
					</div>	
					<div class="clear"></div>		 
				</div>
			<?php } ?>
							
					
			<div align="right">
				<!-- <input type="button" style="margin-top:10px;color:white !important;" value="Add a Business Benefit" onclick='DynamicAddRow("","B","","Yes",""," ")' class="buttonM bBlack" id="TechAnswerRadioId" name="TechAnswer" /> -->
				<input type="button" style="margin-top:10px;color:white !important;" value="Add a Business Benefit" onclick='DynamicAddRowBizVal(this)' class="buttonM bBlack" id="TechAnswerRadioId" name="TechAnswer" />
			</div>					
					   
			<h3 id="show-bus-heading-summary" style="color:black; margin-top:30px;">
				<span style="color: #B30814;">Consolidate Your Answers </span>
			</h3>
						
			<div id="show-bus" style="display:block;">
				<div class="widget tableTabs">
					<?php
					  $findAllBiz_value = $this->campaign->getAllBizVal($campaign_info->campaign_id);
					?>							
					<div class="tab_container">
						<div id="ttab1" class="tab_content" style="min-height: 180px;">
							<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
								<tbody>
									<tr>
										<td class="no-border" colspan="3">
											<div style="margin-top:10px;margin-bottom:10px;margin-left: 5px;">
												Either pick one below as the dominant, best, or most important point or compose as new answer that summarizes all points.
											</div>
										</td>
									</tr>
									<tr>
										<td class="no-border" width="30%"  >
											<div style="float:left;" id="bus-value" class="BizvalueSummarydy">
												<?php if($findAllBiz_value) {?>
													<ul class="bulletpoint">
													<?php foreach($findAllBiz_value as $singleallbizvalue){ ?>
														<li> <!-- <p style="font-size: 98%;" class="summarybx_<?php  echo  $singleallbizvalue->biz_v_id;?>" > --><span class="TextColor dynamicTxt_V<?php echo $campaign_info->campaign_id ?>_<?php echo $singleallbizvalue->biz_v_id;?>"><?php echo $singleallbizvalue->value; ?></span><!-- </p> --></li>
													<?php } ?>
													</ul>
												<?php } ?>						
											</div>
									    </td>
										<td class="no-border" >
											<br /><br /><br/>
											<div align="right" > 
													<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
													We help 
													<span class="dynamicFillTecArea TextColor">
														<?php 
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
																}else{
																	echo $campaign_info->organization;
															}
														?>
													</span> to 
													<!-- <span class="dynamicTxt_Vbus-s TextColor"><?php echo $campaign_business_summary->value; ?></span>. -->
											</div>
										</td>
										<td class="no-border" width="16%" >
											<div style="float:right;">
												<div align="right" style="margin-right: 42px; margin-top: -25px;">
													<div align="center" class="TextColorH" >Business Value</div>
													 
													<textarea class="validate[required] dynamicTxt" id="Vbus-s" name="tbl[ccd][<?php echo $campaign_business_summary->cam_com_id; ?>][bus_val_summary]" style="width:350px;" cols="" rows=""><?php echo (isset($campaign_business_summary->value) ? $campaign_business_summary->value : '');?></textarea>
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
       			// var product_data = $.parseJSON('<?php // echo json_encode($product_data); ?>');
       	</script>
       

			<div class="fluid" style="margin-top:15px;">
				<?php if($session_status != '2'):?>
						<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
						<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
						<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
						<input type="hidden" name="step" value="value2">
						<input type="hidden" id="redirect_url" name="redirect_url" value="">
				 <?php else:?>
						<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
						<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
						<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
						<input type="hidden" name="step" value="value2">
						<input type="hidden" id="redirect_url" name="redirect_url" value="">
				 <?php endif;?>
			</div>
        </form>
     </div>
  </div>
<!-- Main content ends -->
<style>
.bulletpoint{ list-style: disc;padding: 0 10px;}
</style>


<script type="text/javascript">
	/**
	 *  delete question dynamically 
	 */
	function hide_box_status(id,srttbl_name,campain_id){
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."campaign/makingfielsddisabled/" ?>', 
			data : { 'meta_key' : srttbl_name, 'cid': campain_id,'p_id' : id},
			success : function(data){
				// console.log(data);
				// location.reload(false);
				// window.location = window.location;
				$('#frm-input').submit();
			}
		});
	}
	
	/***
	 *   dynamic add new technical question and answer 
	 *  
	 */
	function DynamicAddRowBizVal(obj)
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
			url : '<?php echo base_url()."product/dynamicbizValue" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#BusTbody').append(data);
				newiddy = $('.BusValuesDY:last').attr('id');
				var newvaluetoadd = $('.BusValuesDY:last').val();
				// console.log(newiddy);
				var newaddele = '<li class="summarybx" style="font-size: 98%;">'
								+'<span class="TextColor dynamicTxt_'+newiddy
								+'">'+newvaluetoadd+'</span></li>';
				$('.bulletpoint').append(newaddele);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
			}
		});
	}
</script>
<?php $this->load->view('common/footer'); ?>