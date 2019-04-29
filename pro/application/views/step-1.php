<?php $this->load->view('common/meta');?>	
<?php $this->load->view('common/header');?>
<style>
.button {color:red;}
.delete {font-size: 20px;}
span[id*='hide_'] {color:red;cursor:pointer;}
.ui-icon-closethick {
    background-position: -98px -128px;
}
#breadcrumbs {
    display: none;
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
    <!-- Breadcrumbs line -->
    <?php $this->load->view('common/campaign_nav');?>
	<?php
	  $findproduct = $this->campaign->getProduct($campaign_info->product_id); 
		/*$progress_data = json_decode($this->home->get_progress_data($campaign_info->campaign_id));
		$boxes = array();
		foreach($progress_data as $key => $value){
			if($key=='workflow' && $value > 0) $boxes[] = 'value';
			else if($key=='value' && $value > 0) $boxes[] = 'pain';
			else if($key=='pain' && $value > 0) $boxes[] = 'qualify';
			else if($key=='qualify' && $value > 0) $boxes[] = 'close';
		}*/
	?>
	
    <!-- Main content -->
    <div class="wrapper camptabs">
    	<div class="fluid">
            	<?php /*?><div class="grid12" style="width:100%; margin-left:0%;">
                	<div class="myfolder" align="center" style="margin-left:0%;">
						<div class="myfloder_box">
                    	<div class="box">
                            <div class="bxtitle"><h3>Set Campaign Focus</h3></div>
                            <div class="bxlink">                
                            <a href="<?php echo base_url(); ?>campaign/startcampaigncreate" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php if(in_array('value',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box active">
                            <div class="bxtitle bxtitle1">
                                <h3>Identify Benefits</h3>                
                            </div>
                            <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
                        </div>
                        <?php } if(in_array('pain',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>                        
                        <div class="box">
                            <div class="bxtitle">
                                <h3>Identify Pain Points</h3>                
                            </div>
                            <div class="bxlink">
                                <a href="<?php echo base_url(); ?>step/pain" class="buttonM bRed">Go Here</a>
                            </div>
                        </div>
                        <?php } if(in_array('qualify',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        
                        <div class="box">
                            <div class="bxtitle"><h3>Compose Probing Questions</h3></div>
                            <div class="bxlink">
                            <a href="<?php echo base_url(); ?>step/qualifying" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php } if(in_array('close',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box">
                            <div class="bxtitle"><h3>Identify Close Option</h3></div>
                            <div class="bxlink">
                            <a href="<?php echo base_url(); ?>step/ideal-sales-process" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php }?>
                    </div>
					</div>
					<div class="myfloder_box1 myfloder_box2 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div>
					<br clear="all" />
                </div><?php */?>
                <div class="quatabs" style="float:left; width:85%;">
                    <div class="first">
                        <a href="<?php echo base_url(); ?>campaign/startcampaigncreate" rel="box1">
                            Campaign Focus
                        </a>
                    </div>
                    <div  class="active">
                        <a href="<?php echo base_url(); ?>step/value" rel="box2">
                            Benefits
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo base_url(); ?>step/pain" rel="box3">
                            Pain Points
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo base_url(); ?>step/qualifying" rel="box4">
                            Questions
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo base_url(); ?>step/ideal-sales-process" rel="box5">
                            Close
                        </a>
                    </div>
                </div>
                <div class="bxlink" style="float:right;"><a href="#" class="buttonM bRed dialog_help">Help Video</a></div>
            <br clear="all">
    	<input type="hidden" id="getanswer" value="0" />
        <div class="formRow" id="preview-answer" style="height:auto !important;">
            <?php /*?><div class="qrbox">
                <div class="abox1">Value Answers Preview</div>
                <div class="abox2" onclick="$('#preview-answer').hide();"><a href="javascript:void(0)" onclick="$('#preview-answer').hide();">X</a></div><br clear="all" />
            </div><?php */?>
            <div class="value-preview-button">
            	<a class="vpclose" href="javascript:void(0)" onClick="$('#preview-answer').hide();">X</a>
                <div class="ghquest">
                    <span class="ghquest-text">
                    The purpose of my call is that we help <span class="TextColor"><?php 
                        if($campaign_info->campaign_target == '1'){ 
                            echo $campaign_info->individual;
                        }else{
                            echo $campaign_info->organization;
                        }
                    ?></span> <span class="ghqt">to:</span>
                    </span>
                    <div class="val-answers">
                        help their employees avoid disruptions in income<br>
                        to improve the benefits they offer enabling them to attract and retain better quality employees
                    </div>                                                       
                </div>
            </div>
        </div>
	  	<div id="gHintBox">
        	<div class="formRow" id="NNNNNNNN">
            	<div class="qrbox">
                    <div class="abox1">Value Builder</div>
                    <div class="abox2"><a href="javascript:void(0)" onClick="$('#ghint').remove();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
                </div>                
    			<form action="<?php echo current_url();?>">                	
                    <div id="gh_anbox">
                        <div class="ghquest">
                        	<span class="qstn1">
                            Does <span class="TextColor"><?php echo $findproduct->product_name;?></span> help <span class="TextColor"><?php 
                                                                    if($campaign_info->campaign_target == '1'){	
                                                                        echo $campaign_info->individual;
                                                                    }else{
                                                                        echo $campaign_info->organization;
                                                                    }
                                                                ?></span> <span class="ghqt">to improve any processes?</span>
                            </span>
                            <span class="qstn2">If you help <span class="TextColor"><?php 
                                                                    if($campaign_info->campaign_target == '1'){	
                                                                        echo $campaign_info->individual;
                                                                    }else{
                                                                        echo $campaign_info->organization;
                                                                    }
                                                                ?></span> to <span class="TextColor qstn2value"></span>, <span class="ghqt">will that improve any other proceses?</span></span>                                    
                            <br />
                                                                
                        </div><br />
                        <div class="qabox1">
                            <span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;														
                            We help <span class="dynamicFillTecArea TextColor">
                                <?php 
                                    if($campaign_info->campaign_target == '1'){	
                                        echo $campaign_info->individual;
                                    }else{
                                        echo $campaign_info->organization;
                                    }
                                ?>
                            </span> to &nbsp;
                        </div>
                        <div class="qabox2">
                            <textarea placeholder="Enter Answer"></textarea>
                            <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                                <a href="javascript:void(0);" class="buttonM bGreen btnskip" onClick="skip_hint()">Skip</a>
                                <a href="javascript:void(0);" class="buttonM bRed" onClick="set_hint()">Save</a>
                            </div>
                        </div><br clear="all" />
                    </div>
                    <div id="gh_qtbox">
                        <div class="qabox3">
                        	<span class="qstn1">
                        	Does <span class="TextColor"><?php echo $findproduct->product_name;?></span> help <span class="TextColor"><?php 
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
															}else{
																echo $campaign_info->organization;
															}
														?></span> <span class="ghqt"></span>
                            </span>
                            <span class="qstn2">If you help <span class="TextColor"><?php 
                                                                    if($campaign_info->campaign_target == '1'){	
                                                                        echo $campaign_info->individual;
                                                                    }else{
                                                                        echo $campaign_info->organization;
                                                                    }
                                                                ?></span> to <span class="TextColor qstn2value"></span>, <span class="ghqt">will that improve any other proceses?</span></span>
                                                        
                        </div>
                        <div class="qabox4">
                            <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                                <a href="javascript:void(0);" class="buttonM bGreen" onClick="skip_hint_yes();">Yes</a>
                                <a href="javascript:void(0);" class="buttonM bRed" onClick="skip_hint()">No</a>
                            </div>
                        </div><br clear="all" />
                    </div>
                </form>
            </div>
        </div>
        <div id="AnsBlock1" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	We help <span class="TextColor">
						<?php 
                            if($campaign_info->campaign_target == '1'){	
                                echo $campaign_info->individual;
                            }else{
                                echo $campaign_info->organization;
                            }
                        ?>
                    </span> to :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($campaign_tech_values)
                    foreach ($campaign_tech_values  as $single_campain_tech) {
                        if(!empty($single_campain_tech->value)) {
							if(in_array($single_campain_tech->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$single_campain_tech->tech_v_id.',1)" id="anchor1_'.$single_campain_tech->tech_v_id.'">'.$single_campain_tech->value.'</a></div>';
							$valtemps[]=$single_campain_tech->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock2" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	We help <span class="TextColor">
						<?php 
                            if($campaign_info->campaign_target == '1'){	
                                echo $campaign_info->individual;
                            }else{
                                echo $campaign_info->organization;
                            }
                        ?>
                    </span> to :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_values)
					foreach ($templateuser_tech_values  as $ansval) {
						if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',2)" id="anchor2_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}
					}
					unset($valtemps);
				?>
                </div>
            </div>
        </div>
        <div style="display: <?php echo ($campaign_tech?'none':'block')?>;" class="warning">
            <h1 style="color:#FF0000">You must enter at least one benefit in order to proceed to the next step.</h1>
        </div>
	
	  
	  
        <form id="frm-input" action="<?php echo current_url();?>" method="post">
        	<input type="hidden" name="vit[ignore]" id="vit_ignore" value='<?php if($vit_ignore_list) echo $vit_ignore_list->iqlist;?>' />
                <input type="hidden" name="vit[qid]" id="vit_qid" value="<?php if($vit_ignore_list) echo (int)$vit_ignore_list->qid;?>" />
                    <!-- <div style="width: 100%;color: black; display:none;"  id="YesNoQuestion" ><input type="radio" checked="checked" value="Yes" name="TechQuestion" id="TechRadioId" class="TechQuestion" onclick='AddNewRow("Tech_table_1","T","<?php // echo  $product->product_id;?>","TechTR0",this.value,"<?php // echo $pro_1_value;?>")'>Yes <br/><input type="radio" id="TechRadioId" value="No" name="TechQuestion" class="TechQuestion" onclick='AddNewRow("Tech_table_1","T","<?php // echo $product->product_id;?>","TechTR0",this.value,"<?php // echo $pro_1_value;?>")'>No</div> --> 
                    <div class="widget tableTabs" id="TechnicalDiv"> 
			        
			            <div class="tab_container">
			                <div id="ttab1" class="tab_content">
							
							   <?php $i = 1; ?>
			                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault"  id="Tech_table_<?php echo $i;?>">
			                        <tbody id="TechTbody">   
										<tr id="TechTR1" class="TechTrClass TechTR_4760">										
													<td colspan="3" width="90%"><div style="margin-top:10px;margin-bottom:10px;margin-left: 5px;">Enter at least one benefit that <span class="TextColor"><?php echo $findproduct->product_name;?></span> provides <span class="TextColor"><?php 
																if($campaign_info->campaign_target == '1'){	
																	echo $campaign_info->individual;
																}else{
																	echo $campaign_info->organization;
																}
															?></span>:</div></td>
                                                            <td>Order</td>
										</tr>
                                        <?php if($campaign_tech){ ?>
										<?php 
										$TechRowCounter = 1;
										
										foreach ($campaign_tech  as $single_campain_tech) {?>
									
											<tr id="TechTR<?php echo $TechRowCounter;?>" class="TechTrClass TechTR_<?php echo $single_campain_tech->tech_v_id;?>">										
													<td  style="vertical-align:top;padding-top: 22px;">
														<div align="right"><br />
														
														<span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
														
														We help <span class="dynamicFillTecArea TextColor">
															<?php 
																if($campaign_info->campaign_target == '1'){	
																	echo $campaign_info->individual;
																}else{
																	echo $campaign_info->organization;
																}
															?>
														</span> to <!-- <span class="dynamicTxt_V<?php  // echo $campaign_info->product_id;?>_<?php // echo $single_campain_tech->tech_v_id;?> TextColor"><?php // echo (!empty($single_campain_tech->value) ? $single_campain_tech->value : 'Techical value'); ?></span>. -->
														</div>
														
													</td>
													
													<td class="no-border" width="30%">
													<div class="grid5" style="width:100%;">
                                                    	<div class="answerbox">
                                                        	<div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onClick="set_answer_id(<?php echo $single_campain_tech->tech_v_id;?>,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onClick="set_answer_id(<?php echo $single_campain_tech->tech_v_id;?>,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                            <div id="ansList<?php echo $single_campain_tech->tech_v_id;?>"></div>
                                                        </div>
														<?php /*?><div align="center" class="TextColorH">Yes - How?</div><?php */?>
														<textarea class="validate[required] dynamicTxt dynamicFillTec_<?php echo $single_campain_tech->tech_v_id;?> TechValues gans<?php echo $single_campain_tech->tech_v_id;?>" style="width:500px;" name="tbl[tvd][<?php echo $single_campain_tech->tech_v_id ; ?>][tech_value]" id="V<?php echo $campaign_info->product_id;?>_<?php echo $single_campain_tech->tech_v_id;?>" cols="" rows="" onKeyUp="TechdynamicText();" vno="<?php echo $single_campain_tech->tech_v_id;?>" sno=<?php echo $TechRowCounter;?>><?php echo (!empty($single_campain_tech->value) ? $single_campain_tech->value : 'Value');?></textarea>
														 <!-- <div align="center" class="TextColorH">Answer Checker</div> -->
                                                         <div style="margin-top: 20px;">
                                                            <div><input type="checkbox" value="1" <?php if(!$single_campain_tech->visible) echo 'checked="checked"'; ?>  onchange="updateTechValueDisplay(<?php echo $single_campain_tech->tech_v_id; ?>,this);" /> Do not display answer in templates</div>
                                                             <div style="padding-top:10px;"><input type="checkbox" value="1" <?php if($single_campain_tech->highlight) echo 'checked="checked"'; ?>  onchange="updateTechValueHighlight(<?php echo $single_campain_tech->tech_v_id; ?>,this);" /> Highlight answer in sales scripts</div><br />
                                                            <div align="center">
                                                            	<a href="javascript:void(0);" class="buttonM bRed vst" 
                                                                onclick="get_hint(<?php echo $single_campain_tech->tech_v_id;?>)">Value Builder</a>
                                                                
                                                                <a href="javascript:void(0);" class="buttonM bRed preview-answers" onClick="preview_answer('V<?php echo $campaign_info->product_id;?>_<?php echo $single_campain_tech->tech_v_id;?>')">Preview Answer</a> 
                                                           </div>
                                                            
														
														
													</div></td>
													<td width="3%" class="no-border">
													<div class="grid4"><?php /*?><div align="center" class="TextColorH">No </div><?php */?>
													<div align="center" style="margin-left:8px;"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $single_campain_tech->tech_v_id;?>" onClick="hide_box_status('<?php echo $single_campain_tech->tech_v_id;?>','tvd','<?php echo $campaign_info->campaign_id; ?>');">X</span></div>
													</div>
													</td>
                                                    <td><input type="text" class="qorder" value="<?php echo $single_campain_tech->qus_id; ?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onChange="updateSorder(<?php echo $single_campain_tech->tech_v_id; ?>,this.value);" /></td>
											 </tr>
										<?php 
											++$TechRowCounter;
											
										} ?>
                                        <?php }  ?>
			                        </tbody>
			                    </table>
			                </div>
			            </div>
			            <div class="clear"></div>		 
			        </div>
						<!-- <div align="right"><input type="button" style="margin-top:10px;color:white !important;" value="Add a Technical Benefit" onclick='DynamicAddRow("Tech_table_<?php echo $i;?>","T","<?php echo $campaign_info->campaign_id;?>","Yes","<?php // echo $pro_1_value;?>","TechTRRadio<?php echo $TechRowCounter;?>")' class="buttonM bBlack" id="TechAnswerRadioId" name="TechAnswer" /></div> -->
                     
						<div align="right"><input type="button" style="margin-top:10px;color:white !important;" value="Add a Benefit" onclick='DynamicAddRowTech(this)' class="buttonM bBlack" id="TechAnswerRadioId" name="TechAnswer" /></div>
					 
						<?php /*?><h3 id="show-tech-heading-summary" style="margin-top:30px;color: black;">
							<span style="color: #B30814;">Consolidate Your Answers</span>
						</h3><?php */?>
						
						<!--<div id="show-tech" class="widget tableTabs" style="<?php if($total_tech_qus > 1 ):?>display:block; <?php else:?>display:none;<?php endif;?>">-->
						<?php /*?><div id="show-tech" class="widget tableTabs">
							<!-- <div class="whead"><h6>Technical Benefits</h6><div class="clear"></div></div> -->
							<div class="tab_container">
								<div id="ttab1" class="tab_content" style="min-height: 180px;">
									<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
										<tbody>
											<tr>
												<td colspan="3"  class="no-border">
													<div style="margin-top:10px;margin-bottom:10px;margin-left: 5px;">
														Either pick one below as the dominant, best, or most important point or compose as new answer that summarizes all points.
													</div>
												</td>
											</tr>
											<tr>
												<td  class="no-border" width="30%" >
													 <div style="float:left;" id="tech-value"   class="techvalueSummarydy"  > 
														<ul class="bulletpoint">
															<?php foreach($campaign_tech  as $single_campain_tech) { ?>
																<li class="TechVSumm_<?php echo $single_campain_tech->tech_v_id; ?>" > <!-- <p style="font-size: 98%;" class="TechVSumm_<?php echo $single_campain_tech->tech_v_id; ?>" > --> <span class="TextColor dynamicTxt_V<?php echo $campaign_info->product_id; ?>_<?php echo $single_campain_tech->tech_v_id; ?>"><?php echo(!empty($single_campain_tech->value) ? $single_campain_tech->value : NULL);?></span> <!-- </p> --> </li>
															<?php } ?>
														</ul>
													 
													 </div>
												</td>
												<td  class="no-border">
												    <br /><br />
													<div align="right" >
															<span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;					
															   We help <span class="dynamicFillTecArea TextColor">
																<?php 
																	if($campaign_info->campaign_target == '1'){	
																	echo $campaign_info->individual;
																	}else{
																		echo $campaign_info->organization;
																	}
																?>
															</span> to 
															<!-- <span class="dynamicTxt_Vtech-s TextColor"><?php // echo $campaign_tech_summary->value ;?></span>. -->
													 </div>
													
												</td>
												<td  class="no-border" width="16%">
													 <div style="float:left;">
															 <div align="right" style="margin-right: 42px; margin-top: -25px;">
																	 <div align="center" class="TextColorH" style="">Technical Value</div>
																	 <textarea class="validate[required] dynamicTxt" id="Vtech-s" name="tbl[ccd][<?php echo $campaign_tech_summary->cam_com_id ; ?>][tech_val_summary]" style="width:350px;" cols="" rows=""><?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : 'technical summary');?></textarea>
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
						 </div><?php */?>
				
		<style type="text/css">
			.bulletpoint{ list-style: disc;padding: 0 10px;}
		</style>		
		
      	<script>
       			// product_data = $.parseJSON('<?php // echo  json_encode($product_data); ?>');
       	</script>
       
        <div class="fluid" style="margin-top:15px;">
        <?php if($session_status != '2'):?>
          	<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
          	<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
          	<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
          	<input type="hidden" name="step" value="value">
          	<input type="hidden" id="redirect_url" name="redirect_url" value="">
         <?php else:?>
          		<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
				<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
				<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
				<input type="hidden" name="step" value="value">
				<input type="hidden" id="redirect_url" name="redirect_url" value="">
		 <?php endif;?>
        </div>
        </form>
     </div>
  </div>
</div>
<!-- Main content ends -->
</div>
<script type="text/javascript">
	//Update Tech value sort order by Dev@4489
	function updateSorder(rcid,oval)
	{
		if(oval) {
			$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: 'rcid='+rcid+'&action=SortOrderupdate&sord='+oval,
				cache: false,
				dataType: 'json',
				success: function(responce)
				{
					//	
				}
			});
		}
	}
    
    //Update Tech Value display option
    function updateTechValueDisplay(rcid,dis) {
        var vis = dis.checked?0:1;
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=ValueShowupdate&val='+vis,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                //  
            }
        });

    }
	
	//Update Tech Value Highlight option
	
	function updateTechValueHighlight(rcid,dis)
	{
		var hig = dis.checked?1:0;
		$.ajax({
			type: 'POST',
			url: '<?php echo current_url();?>',
			data: 'rcid='+rcid+'&action=HighlightAnswerupdate&val='+hig,
			cache: false,
			dataType: 'json',
			success: function(responce)
			{
			}
		});
		
	}
	
	
	//set Answer
	function set_answer(gans,uans) {
		$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_"+gans).html());
		$("#pastanswers").hide();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
	//set Answer id
	function set_answer_id(gans,uans,dis) {
		$("#ghint").remove();
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var AnList= $("#AnsBlock"+uans).html().replace("NNNNNNNN","pastanswers");
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$(dis).addClass('btactive');
		$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
		$(".btactive .ansdown").hide();
	}
	//Hide answer popup box
	function hide_answer() {
		$('#pastanswers').remove();
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
	
    $(document).ready(function() {
		
	});

	/**
	 *  This is name drop 
	 */
	function hide_box_status(id,srttbl_name,campain_id){
		if(!confirm('Are u sure you want to delete?')) return;
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."campaign/makingfielsddisabled/" ?>', 
			data : { 'meta_key' : srttbl_name, 'cid': campain_id,'p_id' : id},
			success : function(data){				
				// location.reload(true);
				//$('#frm-input').submit();
                $('.TechTR_'+id).remove();
				<?php /*?>location.replace('<?php echo base_url()."step/value/" ?>');<?php */?>
                if($(".TechTrClass").length<=1) $(".warning").show();
			}
		});
	}
	/***
	 *   dynamic add new technical question and answer 
	 *  
	 */
	function DynamicAddRowTech(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		
		var newiddy ;
		var numItems = $('.TechTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicTechValue" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#TechTbody').append(data);
				newiddy = $('.TechValuesdy:last').attr('id');
				var newvaluetoadd = $('.TechValuesdy:last').val();
				// console.log(newiddy);
				var newaddele = '<li class="TechVSumm_33" style="font-size: 98%;">'
								+'<span class="TextColor dynamicTxt_'+newiddy
								+'">'+newvaluetoadd+'</span></li>';
				// $('.techvalueSummarydy').append(newaddele);
				$('.bulletpoint').append(newaddele);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
				$('.qorder:last').val($('.qorder').length+1);//by Dev@4489
				$('.TechTrClass:last').find("textarea").attr("sno",numItems);//by Dev@4489
                if($(".TechTrClass").length>1) $(".warning").hide();
			}
		});
	}
    //Value answers preview
    function preview_answer(tech_v_id){
		/*console.log(tech_v_id);
		//var answers = $("#"+tech_v_id).val(); 
		//console.log(answers);
        $('#ghint').remove();
        var ansrs = '<ul>';
        $(".TechValues").each(function(){
            ansrs += '<li>'+$(this).val()+'</li>';
        });
        ansrs += '<ul>';*/
		
		ansrs = $("#"+tech_v_id).val();
        $(".val-answers").html(ansrs);        
        $("#preview-answer").show();
    }
	//VALUE IDENTIFIER TOOL: GET HINT
	function get_hint(qfid) {
        $("#preview-answer").hide();
		ghCurQt--;
		Curqsno = parseInt($('textarea[vno='+parseInt(qfid)+']').attr('sno'));
		$("#ghint").remove();
		$("#pastanswers").remove();
		$("#getanswer").val(qfid);
		var AnList= $("#gHintBox").html().replace("NNNNNNNN","ghint");
		AnList = AnList.replace("noBorderB","");
		$("#ansList"+qfid).prepend(AnList);
		skip_hint();
	}
	//set Answer
	function set_hint() {
		if($("#ghint textarea").val().length)
			$(".gans"+$("#getanswer").val()).val($("#ghint textarea").val());
		$("#ghint").hide();
		$(".upaborder").removeClass('upaborder');
	}
	
	//VALUE IDENTIFIER TOOL: Get Hint skip questions
	var ghsquest = {1:["to improve any processes?"],2:["to make anything work better?"],3:["to save time in any ways?"],4:["to make anything more reliable?"],5:["to decrease costs in any ways?"],6:["to increase income or revenue in any ways?"],7:["to improve the delivery of services in any ways?"],8:["improve the opportunity for recognition?"],9:["improve work/life balance in any ways?"],10:["decrease stress in any ways?"],11:["improve the workplace atmosphere?"],
		12:["will that improve any other proceses?"],13:["will that make anything work better?"],14:["will that help to save time in any ways?"],15:["will that help to make anything more reliable?"],16:["will that help to decrease costs in any ways?"],17:["will that help to increase income or revenue in any ways?"],18:["will that help to improve the delivery of services in any ways?"],19:["will that help to improve the opportunity for recognition?"],20:["will that help to improve work/life balance in any ways?"],21:["will that help to decrease stress in any ways?"],22:["will that help to improve the workplace atmosphere?"]
	};
	var vit_emesg = 'You have all our questions at this point. Either enter a benefit that you can think of or close the answer box.';
	
	var ghCQt=22;
	var ghfround = 11;
	<?php 
		$ghCurQt=1;
		$qsno = 0;
		$CurQid=0;
		$vit_ignores='';
		if($vit_ignore_list) {
			$iqArr = explode(",",$vit_ignore_list->iqlist);
			$qsno=count($iqArr)-1;
			$CurQid=$vit_ignore_list->qid;
			$vit_ignores=$vit_ignore_list->iqlist;
	}?>
	var vit_ignores = {<?php echo $vit_ignores;?>};
	var qsno = <?php echo $qsno;?>;
	var ghCurQt=<?php echo $ghCurQt;?>;	
	var CurQid=<?php echo $CurQid?$CurQid:0;?>;
	if(vit_ignores[CurQid]!=undefined) {
		ghCurQt=vit_ignores[CurQid];
		if(ghCurQt==0) {
			ghCurQt=12;
			qsno++;
		} else ghCurQt++;	
	} else if(CurQid>0) {
		ghCurQt=12;
		qsno++;
	}
	
	//Skip hint
	//Skip hint
	function skip_hint(){
		var Cq = parseInt($("#getanswer").val());
		var vitign = vit_ignores[CurQid];
		if( ghCurQt>0 && !(CurQid && ghCurQt<=ghfround)){
			//store to hidden variable
			vit_ignores[CurQid]=ghCurQt;
			jsonStr = JSON.stringify(vit_ignores);
			var res = jsonStr.substr(1, jsonStr.length-2);
			$("#vit_ignore").val(res);
			$("#vit_qid").val(CurQid);
		}
		ghCurQt++;
		if((Curqsno==1 && ghCurQt>ghfround) || Curqsno<=qsno || (Curqsno==qsno+1 && ghCurQt>ghCQt) ) {
			$("#ghint .ghquest").html(vit_emesg);
			$("#ghint #gh_qtbox").hide();
			$("#ghint #gh_anbox").show();
			$("#ghint .btnskip").hide();
			vit_ignores[0]=0;
			if(Curqsno==qsno+1) {
				vit_ignores[CurQid]=0;
				ghCurQt=12;
			}
			if(qsno<Curqsno) {
				qsno++;
				CurQid = parseInt($('textarea[sno='+qsno+']').attr('vno'));
				$("#vit_qid").val(CurQid);
			}
			//store to hidden variable
			jsonStr = JSON.stringify(vit_ignores);
			var res = jsonStr.substr(1, jsonStr.length-2);
			$("#vit_ignore").val(res);
			return;
		} else if(qsno<Curqsno && ( (qsno==0 && ghCurQt>ghfround) || ghCurQt>ghCQt)){
			ghCurQt=12;
			vit_ignores[0]=0;
			if(Curqsno>1) vit_ignores[CurQid]=0;
			qsno++;
			CurQid = parseInt($('textarea[sno='+qsno+']').attr('vno'));
			//store to hidden variable
			jsonStr = JSON.stringify(vit_ignores);
			var res = jsonStr.substr(1, jsonStr.length-2);
			$("#vit_ignore").val(res);
			$("#vit_qid").val(CurQid);
		}
		if(ghCurQt<=ghfround) {
			$("#ghint .qstn2").hide();
			$("#ghint .qstn1").show();
		} else {
			$("#ghint .qstn1").hide();
			$("#ghint .qstn2").show();
			$("#ghint .qstn2value").html($(".gans"+CurQid).val());
		}
		$("#ghint #gh_anbox").hide();
		$("#ghint .ghqt").html(ghsquest[ghCurQt][0]);
		$("#ghint #gh_qtbox").show();
	}
	//Skip hint
	function skip_hint2(){
		var Cq = parseInt($("#getanswer").val());
		var vitign = vit_ignores[CurQid];
		if( ghCurQt>0 && !(CurQid && ghCurQt<=ghfround)){
			//store to hidden variable
			vit_ignores[CurQid]=ghCurQt;
			jsonStr = JSON.stringify(vit_ignores);
			var res = jsonStr.substr(1, jsonStr.length-2);
			$("#vit_ignore").val(res);
			$("#vit_qid").val(CurQid);
		}
		ghCurQt++;
			//if((Curqsno==1 && ghCurQt>ghfround) || Curqsno<=qsno || (Curqsno==qsno+1 && ghCurQt>ghCQt) ) {
			if(ghCurQt>ghfround) {
				$("#ghint .ghquest").html(vit_emesg);
				$("#ghint #gh_qtbox").hide();
				$("#ghint #gh_anbox").show();
				$("#ghint .btnskip").hide();
				vit_ignores[0]=0;
				<?php /*?>if(Curqsno==qsno+1) {
					vit_ignores[CurQid]=0;
					ghCurQt=12;
				}
				if(qsno<Curqsno) {
					qsno++;
					CurQid = parseInt($('textarea[sno='+qsno+']').attr('vno'));
					$("#vit_qid").val(CurQid);
				}<?php */?>
				//store to hidden variable
				jsonStr = JSON.stringify(vit_ignores);
				var res = jsonStr.substr(1, jsonStr.length-2);
				$("#vit_ignore").val(res);
				return;
			}<?php /*?> else if(qsno<Curqsno && ( (qsno==0 && ghCurQt>ghfround) || ghCurQt>ghCQt)){
				ghCurQt=12;
				vit_ignores[0]=0;
				if(Curqsno>1) vit_ignores[CurQid]=0;
				qsno++;
				CurQid = parseInt($('textarea[sno='+qsno+']').attr('vno'));
				//store to hidden variable
				jsonStr = JSON.stringify(vit_ignores);
				var res = jsonStr.substr(1, jsonStr.length-2);
				$("#vit_ignore").val(res);
				$("#vit_qid").val(CurQid);
			}<?php */?>
		if(ghCurQt<=ghfround) {
			$("#ghint .qstn2").hide();
			$("#ghint .qstn1").show();
		} else {
			$("#ghint .qstn1").hide();
			$("#ghint .qstn2").show();
			$("#ghint .qstn2value").html($(".gans"+CurQid).val());
		}
		$("#ghint #gh_anbox").hide();
		$("#ghint .ghqt").html(ghsquest[ghCurQt][0]);
		$("#ghint #gh_qtbox").show();
	}
	
	function skip_hint3(){
		var Cq = parseInt($("#getanswer").val());
		//push ignore question
		var vitign = vit_ignores;		
		if(ghCurQt>0 && ghCurQt<=ghCQt) {
			var vign = $("#vit_ignore").val();
			if(vign) vign +=",";
			vign +=ghCurQt;
			$("#vit_ignore").val(vign);
			if(vitign==undefined) vitign = [];
			vitign.push(ghCurQt);
			vit_ignores=vitign;
		}
		ghCurQt++;
		if(ghCurQt>11) ghCurQt=1;
		//show message if questions skipped
		if(vitign!=undefined) {
			if(vitign.length>=ghCQt) {
				$("#ghint .ghquest").html(vit_emesg);
				$("#ghint #gh_qtbox").hide();
				$("#ghint #gh_anbox").show();
				$("#ghint .btnskip").hide();
				return;
			}
			for(var n=0;n<vitign.length;n++) {
				if(parseInt(vitign[n])==ghCurQt) {
					ghCurQt++;
					if(ghCurQt>ghCQt) ghCurQt=1;
					continue;
				}
			}
		}
		$("#ghint #gh_anbox").hide();
		$("#ghint .ghqt").html(ghsquest[ghCurQt][0]);
		$("#ghint #gh_qtbox").show();		
	}
	//Skip hint Yes
	function skip_hint_yes(){
		$("#ghint #gh_qtbox").hide();
		$("#ghint #gh_anbox").show();
		$("#ghint textarea").val('');
	}
	////
</script>
<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/pVm0Xurd2YE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
$( document ).ready(function() {
    $('.help_dialog').dialog({
        autoOpen: false,
        height: 400,
        width: 600,
        buttons: {
            "Close": function () {
				$('.video').html('');
                $(this).dialog("close");
				
            }
        }    
    });
    
    // Invitation Dialog Link
    $('.dialog_help').click(function (e) {
		 $('.video').html(iframe);
         $('.help_dialog').dialog('open');
		 
        return false;
    });
	
	$('.ui-icon-closethick').click(function (e) {
		 $('.video').html('');
		  $('.help_dialog').dialog('close');
        return false;
    });
	
});
    
</script>
<div class="help_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video</title>
</head>

<body>
 <div class="video">
    




 </div>
</body>
</html></div>

<?php $this->load->view('common/footer');?>