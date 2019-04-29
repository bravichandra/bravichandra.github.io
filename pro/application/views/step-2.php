<?php $this->load->view('common/meta');?>
<?php $this->load->view('common/header');?>
<style>.delete {font-size: 20px;}#breadcrumbs {
    display: none;
}
.fluid .grid5 {
    width: 40.425531911%;
}
</style>
<!-- Sidebar begins -->
<div id="sidebar">
<?php echo $this->load->view('common/left_navigation');?>
<!-- Secondary nav -->
	<div class="secNav">
		<div class="clear"></div>
	</div>
</div>
<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
    <!-- Breadcrumbs line -->
    <?php echo $this->load->view('common/campaign_nav'); 
		/*$progress_data = json_decode($this->home->get_progress_data($campaign_info->campaign_id));
		$boxes = array();
		foreach($progress_data as $key => $value){
			if($key=='workflow' && $value > 0) $boxes[] = 'value';
			else if($key=='value' && $value > 0) $boxes[] = 'pain';
			else if($key=='pain' && $value > 0) $boxes[] = 'qualify';
			else if($key=='qualify' && $value > 0) $boxes[] = 'close';
		}*/?>
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
                        <div class="box">
                            <div class="bxtitle">
                                <h3>Identify Benefits</h3>                
                            </div>
                            <div class="bxlink">
                                <a href="<?php echo base_url(); ?>step/value" class="buttonM bRed">Go Here</a>
                            </div>
                        </div>
                        <?php } if(in_array('pain',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>                        
                        <div class="box active">
                            <div class="bxtitle bxtitle1">
                                <h3>Identify Pain Points</h3>                
                            </div>
                           <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
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
					<div class="myfloder_box1 myfloder_box3 bxlink"> 
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
                        <div class="second">
                            <a href="<?php echo base_url(); ?>step/value" rel="box2">
                                Benefits
                            </a>
                        </div>
                        <div  class="active"> 
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
            <br clear="all" />
		<input type="hidden" id="getanswer" value="0" />
        <div class="formRow" id="preview-answer" style="height:auto !important;">
              <?php /*?><div class="qrbox">
                   <div class="abox1">
                        Pain Answers Preview
                   </div>
                   <div class="abox2" onClick="$('#preview-answer').hide();">
                        <a href="javascript:void(0)" onClick="$('#preview-answers').hide();">X</a>
                   </div>
                   <br clear="all" />
              </div><?php */?>
              <div class="value-preview-button">
              		<a class="vpclose" href="javascript:void(0)" onclick="$('#preview-answer').hide();">X</a>
                    <div class="ghquest">
                        <span style="font-size:17px;">
                            When we talk with other
                            <span class="TextColor">
                                <?php 
                                    if($campaign_info->campaign_target == '1'){ 
                                        echo $campaign_info->individual;
                                    }else{
                                        echo $campaign_info->organization;
                                    }
                                ?>,
                            </span>
                            <span class="ghqt" style="font-size:17px;"> we have noticed that they often express challenges with:</span>
                        </span>
                        <div class="val-answers" style="padding-bottom:10px;">
                        	 They don't currently have any disability coverage for their employees<br />
							 It can be tough to attract and retain good employees
                        </div>
                        <span style="font-size:17px;">Are any of those areas that you are concerned about?</span>
                    </div>
              </div>
        </div>
        <div id="gHintBox">
        	<div class="formRow" id="NNNNNNNN">
            	<div class="qrbox">
                    <div class="abox1">Pain Setup Tool</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#ghint').remove();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
                </div>                
    			<form action="<?php echo current_url();?>">                	
                    <div id="gh_anbox">
                        <div class="ghquest">
                            <span class="qstn1">When you help <span class="TextColor"><?php 
                                                                    if($campaign_info->campaign_target == '1'){	
                                                                        echo $campaign_info->individual;
                                                                    }else{
                                                                        echo $campaign_info->organization;
                                                                    }
                                                                ?></span> to <span class="TextColor qstn2value"></span>, <span class="ghqt">is there a challenge or problem that is resolved, minimized, or avoided?</span></span>         
                            <br />
                                                                
                        </div>
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
                                <a href="javascript:void(0);" class="buttonM bGreen btnskip" onclick="skip_hint()">Skip</a>
                                <a href="javascript:void(0);" class="buttonM bRed" onclick="set_hint()">Save</a>
                            </div>
                        </div><br clear="all" />
                    </div>
                    <div id="gh_qtbox">
                        <div class="qabox3">
                            <span class="qstn1">When you help <span class="TextColor"><?php 
                                                                    if($campaign_info->campaign_target == '1'){	
                                                                        echo $campaign_info->individual;
                                                                    }else{
                                                                        echo $campaign_info->organization;
                                                                    }
                                                                ?></span> to <span class="TextColor qstn2value"></span>, <span class="ghqt">is there a challenge or problem that is resolved, minimized, or avoided?</span></span>
                                                        
                        </div>
                        <div class="qabox4">
                            <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                                <a href="javascript:void(0);" class="buttonM bGreen" onclick="skip_hint_yes();">Yes</a>
                                <a href="javascript:void(0);" class="buttonM bRed" onclick="skip_hint()">No</a>
                            </div>
                        </div><br clear="all" />
                    </div>
                </form>
            </div>
        </div>
        <div id="AnsBlock1" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Select a Past Answer</div>
                    <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($tech_val_pains)
                    foreach ($tech_val_pains  as $singletechpain) {
                        if(!empty($singletechpain->value)) {
							if(in_array($singletechpain->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$singletechpain->tech_p_id.',1)" id="anchor1_'.$singletechpain->tech_p_id.'">'.$singletechpain->value.'</a></div>';
							$valtemps[]=$singletechpain->value;
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
                    <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_val_pains)
					foreach ($templateuser_tech_val_pains  as $ansval) {
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
		<?php 
			/* find productinfo */
			$getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
		?>
		
        <form id="frm-input" action="<?php echo current_url();?>" method="post" >
        	<input type="hidden" name="vit[ignore]" id="vit_ignore" value='<?php if($vit_ignore_list) echo $vit_ignore_list->iqlist;?>' />
            <input type="hidden" name="vit[qid]" id="vit_qid" value="<?php if($vit_ignore_list) echo (int)$vit_ignore_list->qid;?>" />
		<?php $i= 1; ?>
        <?php $TechRowCounter = 1;$flag=0;?>
		<?php if($tech_val_pain) { ?>
        <div class="widget tableTabs"> 
            <div class="tab_container">
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="technical_table_<?php echo $i;?>">
                        <tbody id="TechPainTbody">
                        	<?php if($tech_val_pain) {?>
                            	<tr id="improveService" class="BizTrClass improveService1">
                                    <td colspan="3"><?php /*?>Enter at least one challenge or problem that <span class="TextColor"><?php echo $getProdcutinfo->product_name;?></span> helps <span class="TextColor"><?php if($campaign_info->campaign_target == '1') echo $campaign_info->individual; else echo $campaign_info->organization;?></span> to resolve, minimize, or avoid.<?php */?></td>
                                    <td>Order</td>
                                </tr>
							<?php foreach($tech_val_pain  as $singletechpain) {?>
                            	<?php if($singletechpain->tech_benefit_val) $pain_values .= ','.$singletechpain->tech_pain_id.':"'.str_replace('"','\"',$singletechpain->tech_benefit_val).'"';?>
								<tr class="PainPageTR_<?php echo $singletechpain->tech_pain_id; ?> TechPainTrClass qtpain<?php echo ($flag?' tabbglight':' tabbgdark');?>" <?php //if($TechRowCounter>1) echo 'style="display:none;"';?> style="border-bottom: 0px solid #DFDFDF;">
									
									<td class="no-border"  colspan="3" id="ansListh<?php echo $singletechpain->tech_pain_id;?>">										
                                    	<span>When you help <span class="TextColor"><?php if($campaign_info->campaign_target == '1'){	echo $campaign_info->individual;}else{echo $campaign_info->organization;}?></span> to <span class="TextColor"><?php echo (!empty($singletechpain->tech_benefit_val) ? $singletechpain->tech_benefit_val : 'Common Problem');?></span>, <span>is there a challenge or problem that is resolved, minimized, or avoided?</span></span>
									</td>
                                    <td></td>
								</tr>
                                <tr class="PainPageTR_<?php echo $singletechpain->tech_pain_id; ?> TechPainTrClass<?php echo ($flag?' tabbglight':' tabbgdark');$flag=!$flag;?>" <?php //if($TechRowCounter>1) echo 'style="display:none;"';?> style="border-top: 0px solid #DFDFDF;">
									
									<td class="no-border" valign="top" style="vertical-align: top;" align="right">										
                                        <br /><br />
										<span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp; A lot of 
										<span class="TextColor">
                                        <?php if($campaign_info->campaign_target == '1'){	echo $campaign_info->individual;}else{echo $campaign_info->organization;}?>
										</span> have a concern that:
									</td>
									<td class="no-border">
										<div class="grid5" style="width:100%;">
                                        	<div class="answerbox" style="width:100%;">
                                                <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id(<?php echo $singletechpain->tech_pain_id;?>,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id(<?php echo $singletechpain->tech_pain_id;?>,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                <div id="ansList<?php echo $singletechpain->tech_pain_id;?>"></div>
                                            </div>
											<?php /*?><div align="center" class="TextColorH">Yes - How</div><?php */?>
											<textarea  class="validate[required] dynamicTxt gans<?php echo $singletechpain->tech_pain_id;?>" name="tbl[tpnd][<?php echo $singletechpain->tech_pain_id;?>][tech_pain]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singletechpain->tech_pain_id;?>" style="width:555px;" vno="<?php echo $singletechpain->tech_pain_id;?>" sno=<?php echo $TechRowCounter++;?>><?php echo $singletechpain->tech_pain_val; ?></textarea>
                                            <div style="margin-top: 20px;">
                                                <div><input type="checkbox" value="1" <?php if(!$singletechpain->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $singletechpain->tech_pain_id; ?>,this);" /> Do not display answer in templates</div>
                                                <div style="padding-top:5px;">
                                                    <input type="checkbox" value="1" <?php if($singletechpain->highlight) echo 'checked="checked"';?> onchange="updateTechPainHighlight(<?php echo $singletechpain->tech_pain_id ?>,this);" /> Highlight answer in sales scripts
                                                </div><br />
                                                <div align="center">
                                                      <a href="javascript:void(0);" class="buttonM bRed preview-answers" onclick="preview_answer('P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singletechpain->tech_pain_id;?>')">Preview Answer</a>   
                                                </div>
                                            </div>
                                             
										</div>
									</td>
									<td class="no-border">
										<div class="grid4">
											<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
											<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singletechpain->tech_pain_id ;?>" onclick="hide_box_status('<?php echo $singletechpain->tech_pain_id ;?>','tpnd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/>
										</div>
									</td>                                    
                                    <td><input type="text" class="qorder" value="<?php echo $singletechpain->qus_id; ?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $singletechpain->tech_pain_id; ?>,this.value);" /></td>
								</tr>
								
								<?php } ?>
                                <?php } ?>
							
								<?php if($tech_val_pain_orph) { ?>
								<?php foreach($tech_val_pain_orph as $singlepainorph) { ?>
                                	<?php if($singlepainorph->tech_benefit_val) $pain_values .= ','.$singlepainorph->tech_pain_id.':"'.str_replace('"','\"',$singletechpain->tech_benefit_val).'"';?>
										<tr class="TechPainTrClass qtpain<?php echo ($flag?' tabbglight':' tabbgdark');?>" <?php //if($TechRowCounter>1) echo 'style="display:none;"';?> style="border-bottom: 0px solid #DFDFDF;">
											<td class="no-border"  colspan="4" id="ansListh<?php echo $singlepainorph->tech_pain_id;?>" >
                                            <span>When you help <span class="TextColor"><?php if($campaign_info->campaign_target == '1'){	echo $campaign_info->individual;}else{echo $campaign_info->organization;}?></span> to <span class="TextColor"><?php echo (!empty($singlepainorph->tech_benefit_val) ? $singlepainorph->tech_benefit_val : 'Common Problem');?></span>, <span>is there a challenge or problem that is resolved, minimized, or avoided?</span></span>
											
												</td>
											
										</tr>
                                        <tr class="TechPainTrClass<?php echo ($flag?' tabbglight':' tabbgdark');$flag=!$flag;?>" <?php //if($TechRowCounter>1) echo 'style="display:none;"';?> style="border-top: 0px solid #DFDFDF;">
											<td class="no-border" valign="top" style="vertical-align: top;" align="right" >
                                            <br /><br />
                                            <span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;A lot of 
                                                    <span class="TextColor">
                                        <?php if($campaign_info->campaign_target == '1'){	echo $campaign_info->individual;}else{echo $campaign_info->organization;}?>
										</span> have a concern that:
												<?php /*?>What is another technical challenge or problem that 
													<span class="TextColor">
															<?php echo $getProdcutinfo->product_name; ?>
													</span> 
													helps 
												
													<span class="TextColor">
														<?php 
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
															}else{
																echo $campaign_info->organization;
															}
														?>
													</span>to resolve?
													<br /><br /><?php */?>
                                                    <?php /*?><span class="TextColor"><?php echo (!empty($singlepainorph->tech_benefit_val) ? $singlepainorph->tech_benefit_val : 'Common Problem');?></span><?php */?>
													<?php /*?><div align="right">
														<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
														A lot of <span class="dynamicFillTecArea TextColor">
															<?php 
																if($campaign_info->campaign_target == '1'){	
																	echo $campaign_info->individual;
																}else{
																	echo $campaign_info->organization;
																}
															?>
														</span> express concerns with  
														<!-- <span class="dynamicTxt_P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singlepainorph->tech_pain_id ?> TextColor"> <?php  echo $singlepainorph->tech_pain_val; ?></span>. -->
													</div><?php */?>
											
												</td>
												<td class="no-border">
													<div class="grid5" style="width:100%;">
                                                    	<div class="answerbox">
                                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id(<?php echo $singlepainorph->tech_pain_id;?>,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id(<?php echo $singlepainorph->tech_pain_id;?>,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                            <div id="ansList<?php echo $singlepainorph->tech_pain_id;?>"></div>
                                                        </div>
													<?php /*?><div align="center" class="TextColorH">Common Problem</div><?php */?>
														<textarea class="validate[required] dynamicTxt gans<?php echo $singlepainorph->tech_pain_id;?>" style="width:555px;" name="tbl[tpnd][<?php echo $singlepainorph->tech_pain_id;?>][tech_pain]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singlepainorph->tech_pain_id ?>" vno="<?php echo $singlepainorph->tech_pain_id;?>" sno=<?php echo $TechRowCounter++;?>><?php  echo $singlepainorph->tech_pain_val; ?></textarea>
                                                        
                                                        <div style="margin-top: 20px;">
                                                            <div><input type="checkbox" value="1" <?php if(!$singlepainorph->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $singlepainorph->tech_pain_id; ?>,this);" /> Do not display answer in templates</div>
                                                            <div style="padding-top:5px;">
                                                                <input type="checkbox" value="1" <?php if($singlepainorph->highlight) echo 'checked="checked"';?> onchange="updateTechPainHighlight(<?php echo $singlepainorph->tech_pain_id ?>,this);" /> Highlight answer in sales scripts
                                                            </div><br />
                                                            <div align="center">
                                                                   <a href="javascript:void(0);" class="buttonM bRed preview-answers" onclick="preview_answer('P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singlepainorph->tech_pain_id ?>')">Preview Answer</a>   
														 
                                                            </div>
                                                        </div>
													</div>
												</td>
												<td class="no-border" >
													<div class="grid5">
														<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
														<div align="center" ><span class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $singlepainorph->tech_pain_id; ?>','tpnd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
													</div>
												</td>
                                                <td><input type="text" class="qorder" value="<?php echo $singlepainorph->qus_id; ?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $singlepainorph->tech_pain_id; ?>,this.value);" /></td>
                                                
											
										</tr>
									<?php } ?>
								<?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <div class="clear"></div>
        </div>
		
		
		
        <?php if($is_paid): ?>
        <div align="right">
            <input type="button" <?php if($is_paid) { ?> onclick='DynamicAddRowTechPain(this)' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Common Problem" style="margin-top:10px;color:white !important;"/>
         </div>
        <?php else:?>
        <div align="right">
            <input type="button"  onclick='DynamicAddRowTechPain(this)' class="buttonM bBlack"  value="Add Common Problem" style="margin-top:10px;color:white !important;"/>
			<!-- <input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Technical Pain" style="margin-top:10px;color:white !important;"/> -->
        </div>
        <?php endif;?>
		
		<?php } ?>
        
		<?php /**   These lines are commented to hide these sections in PRO version - Developer-A ?>
		<?php if($biz_val_pain) { ?>		
		<!-- Business Pain  -->
        <h3 style="margin-top:30px;">Business Pain</h3>
        <div class="widget tableTabs"> 
            <div class="tab_container">
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="business_table_<?php echo $i;?>">
                        <tbody id="BizPainTbody">
								<?php foreach($biz_val_pain as $singlebizpain) { ?>
								
									<tr class="PainPageTR_<?php echo $singlebizpain->biz_pain_id;?> BiZPainTrClass">
										<td class="grid5 no-border" colspan="3" width="70%">
											What challenge or problem is decreased when the improvement of
											<span class="TextColor">[<?php echo (!empty($singlebizpain->biz_benefit_val) ? $singlebizpain->biz_benefit_val : 'Added Business Pain');?>]
											</span>  is seen?
											<br /><br />
											<div align="right">
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												A lot of <span class="dynamicFillTecArea TextColor">
													<?php 
														if($campaign_info->campaign_target == '1'){	
															echo $campaign_info->individual;
														}else{
															echo $campaign_info->organization;
														}
													?>
												</span> express concerns with  
												<!-- <span class="dynamicTxt_P<?php echo $campaign_info->campaign_id;?>_<?php echo $singlebizpain->biz_pain_id;?>_i TextColor"><?php echo $singlebizpain->biz_pain_val;?></span>. -->
											</div>
										</td>
										<td class="no-border" >
											<div class="grid5">
												<div align="center" class="TextColorH">Business Pain</div>
												<textarea  class="validate[required] dynamicTxt" name="tbl[bpd][<?php echo $singlebizpain->biz_pain_id;?>][bus_pain]" style="width:350px;" cols="" rows="" id="P<?php echo $campaign_info->campaign_id;?>_<?php echo $singlebizpain->biz_pain_id;?>_i"><?php echo $singlebizpain->biz_pain_val;?></textarea>
												<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											</div>
										</td>
										
										<td class="no-border"><div class="grid4"><div align="center" class="TextColorH">No </div>
											<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singlebizpain->biz_pain_id; ?>" onclick="hide_box_status('<?php echo $singlebizpain->biz_pain_id; ?>','bpd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/>
											</div>
										</td>
									</tr>
								<?php } ?>
									
								<?php if($biz_val_pain_orph) { ?>	
								<?php foreach($biz_val_pain_orph as $singlebizpainorph) { ?>	
									<tr class="BiZPainTrClass" >
										<td class="grid5 no-border"  colspan="3" width="70%" >
											What is another business challenge or problem that 
											<span class="TextColor">
													<?php echo $getProdcutinfo->product_name; ?>
											</span> 
											helps 
										
											<span class="TextColor">
												<?php 
													if($campaign_info->campaign_target == '1'){	
														echo $campaign_info->individual;
													}else{
														echo $campaign_info->organization;
													}
												?> 
											</span>to resolve?
											<br /><br />
											<div align="right">
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												A lot of <span class="dynamicFillTecArea TextColor">
													<?php 
														if($campaign_info->campaign_target == '1'){	
															echo $campaign_info->individual;
														}else{
															echo $campaign_info->organization;
														}
													?>
												</span> express concerns with  
												<!-- <span class="dynamicTxt_P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singlebizpainorph->biz_pain_id ;?> TextColor"><?php  echo $singlebizpainorph->biz_pain_val; ?></span>. -->
											</div>
										</td>
										<td class="no-border">
											<div class="grid5">
												<div align="center" class="TextColorH">Business Pain</div>
												<textarea class="validate[required] dynamicTxt" style="width:350px;" name="tbl[bpd][<?php echo $singlebizpainorph->biz_pain_id;?>][bus_pain]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id ;?>_<?php echo $singlebizpainorph->biz_pain_id ;?>"><?php  echo $singlebizpainorph->biz_pain_val ?></textarea>
												<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											
											</div>
										</td>
										<td class="no-border" >
											<div class="grid5">
												<div align="center" class="TextColorH">No </div>
												<div align="center"><span class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $singlebizpainorph->biz_pain_id ?>','bpd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
											</div>
										</td>
										
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
		
		
        <?php if($is_paid): ?>
        <div align="right">
            <input type="button" <?php if($is_paid) { ?> onclick='DynamicAddRowBizPain(this)' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Business Pain" style="margin-top:10px;color:white !important;"/>
        </div>
        <?php else:?>
        <div align="right">
            <input type="button"  onclick='DynamicAddRowBizPain(this)' class="buttonM bBlack"  value="Add Business Pain" style="margin-top:10px;color:white !important;"/>
			<!-- <input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Business Pain" style="margin-top:10px;color:white !important;"/> -->
        </div>
        <?php endif;?>
		
        <?php if($per_val_pain) { ?>
			<!-- Personal Pain  -->
			<h3 style="margin-top:30px;">Personal Pain</h3>
			<div class="widget tableTabs">
				<div class="tab_container">
					<div id="ttab1" class="tab_content">
						<table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="pesonal_table_<?php echo $i;?>">
							<tbody id="PerPainTbody">
								<?php foreach($per_val_pain as $singleperpain) { ?>
									<tr class="PainPageTR_<?php // ;?> PerPainTrClass">
										<td class="grid5 no-border" colspan="3"  width="70%">What challenge or problem is decreased when the improvement of 
											<span class="TextColor">[<?php echo (!empty($singleperpain->per_benefit_val) ? $singleperpain->per_benefit_val : 'Added Personal Pain');?>]
											</span> is seen?
											<br /><br />
											<div align="right">
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												A lot of 
												<span class="dynamicFillTecArea TextColor">
													<?php 
														if($campaign_info->campaign_target == '1'){	
															echo $campaign_info->individual;
														}else{
															echo $campaign_info->organization;
														}
													?>
												</span> express concerns with 
												<!-- <span class="dynamicTxt_P<?php echo $campaign_info->campaign_id; ?>_<?php echo $singleperpain->per_pain_id;?> TextColor"><?php echo $singleperpain->per_pain_val ?></span>. -->
											</div>
										</td>
										<td class="no-border" >
											<div class="grid5">
												<div align="center" class="TextColorH">Personal Pain</div>
												<textarea  class="validate[required] dynamicTxt" name="tbl[ppd][<?php echo $singleperpain->per_pain_id;?>][pers_pain]" style="width:350px;" cols="" rows="" id="P<?php echo $campaign_info->campaign_id; ?>_<?php echo $singleperpain->per_pain_id;?>"><?php echo $singleperpain->per_pain_val ?></textarea>
												<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
												
											</div>
										</td>
										<td class="no-border">
											<div class="grid4">
												<div align="center" class="TextColorH">No </div>
										  
										<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $singleperpain->per_pain_id; ?>" onclick="hide_box_status('<?php echo $singleperpain->per_pain_id;?>','ppd','<?php echo $campaign_info->campaign_id ?>');">X</span></div><br/></div></td>
									</tr>
								<?php } ?>
								
								
								<?php if ($per_val_pain_orph) { ?>
								<?php foreach($per_val_pain_orph  as $singleperpainorph) { ?>
								<tr class="PerPainTrClass">
									<td class="grid5 no-border" colspan="3" width="70%" >
										What is another Personal challenge or problem that 
										<span class="TextColor">
												<?php echo $getProdcutinfo->product_name; ?>
										</span> 
										helps 
									
										<span class="TextColor">
											<?php 
												if($campaign_info->campaign_target == '1'){	
													echo $campaign_info->individual;
												}else{
													echo $campaign_info->organization;
												}
											?>
										</span>to resolve?
										<br /><br />
										<div align="right">
											<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
											A lot of <span class="dynamicFillTecArea TextColor">
												<?php 
													if($campaign_info->campaign_target == '1'){	
														echo $campaign_info->individual;
													}else{
														echo $campaign_info->organization;
													}
												?>
											</span> express concerns with  
											<!-- <span class="dynamicTxt_P<?php echo $campaign_info->campaign_id; ?>_<?php echo $singleperpainorph->per_pain_id;?> TextColor"><?php echo $singleperpainorph->per_pain_val;?></span>. -->
										</div>
										
									</td>
									<td class="no-border">
										<div class="grid5">
											<div align="center" class="TextColorH">Personal Pain</div>
											<textarea class="validate[required] dynamicTxt" style="width:350px;" name="tbl[ppd][<?php echo $singleperpainorph->per_pain_id;?>][pers_pain]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id; ?>_<?php echo $singleperpainorph->per_pain_id;?>"><?php echo $singleperpainorph->per_pain_val;?></textarea>
											<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											
										</div>
									</td>
									<td class="no-border" >
									<div class="grid5">
										<div align="center" class="TextColorH">No </div>
										<div align="center"> <span class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $singleperpainorph->per_pain_id; ?>','ppd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
									</td>
									
								   
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

        <?php if($is_paid): ?>
        <div align="right">
            <input type="button" <?php if($is_paid) { ?> onclick='DynamicAddRowPerPain(this)' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Personal Pain" style="margin-top:10px;color:white !important;"/>
        </div>
        <?php else:?>
        <div align="right">
            <input type="button"  onclick='DynamicAddRowPerPain(this)' class="buttonM bBlack" value="Add Personal Pain" style="margin-top:10px;color:white !important;"/>
			<!-- <input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Personal Pain" style="margin-top:10px;color:white !important;"/> -->
        </div>
        <?php endif;?>
        <?php **/ ?>
		<div class="fluid" style="margin-top:15px;">
            <?php if($session_status != '2'):?>
                <input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                <input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
                <!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
                <input type="hidden" name="step" value="pain">
                <input type="hidden" id="redirect_url" name="redirect_url" value="" />
            <?php else:?>
                <input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                <input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
                <input type="hidden" name="step" value="pain">
                <input type="hidden" id="redirect_url" name="redirect_url" value="" />         
            <?php endif;?>        
        </div>        
        </form>     
    </div>        
</div>    
</div>
<!-- Main content ends -->
</div><!-- Content ends -->
<script type="text/javascript">
	
	//Update Tech pain sort order by Dev@4489
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
	
	//Value answers preview
    function preview_answer(tech_pain_id){
		ansrs = $("#"+tech_pain_id).val();
		console.log(ansrs);
        $(".val-answers").html(ansrs);        
        $("#preview-answer").show();
    }
    
    //Update Tech Value display option
    function updateTechDisplay(rcid,dis) {
        var vis = dis.checked?0:1;
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=PainShowupdate&val='+vis,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                //  
            }
        });

    }
	//Update Tech Highlight value
	function updateTechPainHighlight(rcid,dis) {
        var tpha = dis.checked?1:0;
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=HighlightPainupdate&val='+tpha,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                //  
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
		var qheader = $("#ansListh"+gans+" span.TextColor").html();
		var AnList= $("#AnsBlock"+uans).html().replace("NNNNNNNN","pastanswers");
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$("#pastanswers .uapboxyr_box2 span").html(qheader);
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
				// console.log(data);
				// location.reload(false);
				$('#frm-input').submit();
			}
		});
	}
	
	/***
	 *   dynamic add new technical pain question and answer
	 */
	function DynamicAddRowTechPain(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		
		var newiddy ;
		var numItems = $('.TechPainTrClass').length/2;
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicTechPain" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#TechPainTbody').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
				$('.qorder:last').val($('.qorder').length+1);//by Dev@4489
			}
		});
	}
	
	/***
	 *   dynamic add new Business pain question and answer
	 */
	function DynamicAddRowBizPain(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		var newiddy ;
		var numItems = $('.BiZPainTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicBizPain" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#BizPainTbody').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
			}
		});
	}
	
	
	/***
	 *   dynamic add new Business pain question and answer
	 */
	function DynamicAddRowPerPain(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		var newiddy ;
		var numItems = $('.PerPainTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicPerPain" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#PerPainTbody').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
			}
		});
	}
	
	//PAIN IDENTIFIER TOOL: GET HINT
	function get_hint(qfid) {
		//ghCurQt=-1;
		qsno = ghCurQt;
		ghCurQt--;
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
		if($("#ghint textarea").val().length) {
			$(".gans"+$("#getanswer").val()).val($("#ghint textarea").val());
		}
		$("#ghint").hide();
		$(".upaborder").removeClass('upaborder');
	}
	
	//Pain Setup Tool: Get Hint skip questions
	var ghsquest = {<?php if($pain_values) echo str_replace("\n","",substr($pain_values,1));?>};
	var vit_emesg = 'You have all our questions at this point. Either enter a common problems that you can think of or close the answer box.';
	var ghCQt=Object.keys(ghsquest).length;
	<?php 
		$ghCurQt=0;
		$qsno = 0;
		$CurQid=0;
		$vit_ignores='';
		if($vit_ignore_list) {
			$iqArr = explode(",",$vit_ignore_list->iqlist);
			$qsno=count($iqArr);
			$ghCurQt=$qsno;
			$CurQid=$vit_ignore_list->qid;
			$vit_ignores=$vit_ignore_list->iqlist;
	}?>
	var vit_ignores = {<?php echo $vit_ignores;?>};
	var qsno = <?php echo $qsno;?>;
	var ghCurQt=Object.keys(vit_ignores).length+1;
	var CurQid = parseInt($('textarea[sno='+ghCurQt+']').attr('vno'));
	//Skip hint
	function skip_hint(){
		var Cq = parseInt($("#getanswer").val());
		ghCurQt++;
		if(ghCurQt>ghCQt) {
			//ghCurQt=0;
			vit_ignores[CurQid]=0;
			$("#vit_qid").val(CurQid);
			jsonStr = JSON.stringify(vit_ignores);
			var res = jsonStr.substr(1, jsonStr.length-2);
			$("#vit_ignore").val(res);
			$("#ghint .ghquest").html(vit_emesg);
			$("#ghint #gh_qtbox").hide();
			$("#ghint #gh_anbox").show();
			$("#ghint .btnskip").hide();
			return;
		}
		if(ghCurQt>1 && qsno!=ghCurQt) {
			vit_ignores[CurQid]=0;
			$("#vit_qid").val(CurQid);
			jsonStr = JSON.stringify(vit_ignores);
			var res = jsonStr.substr(1, jsonStr.length-2);
			$("#vit_ignore").val(res);
		}
		CurQid = parseInt($('textarea[sno='+ghCurQt+']').attr('vno'));
		$("#ghint .qstn2value").html(ghsquest[CurQid]);
		$("#ghint #gh_anbox").hide();
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
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/BI6OffmiiDE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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

<body>9247
 <div class="video">
    




 </div>
</body>
</html></div>
<?php $this->load->view('common/footer');?>