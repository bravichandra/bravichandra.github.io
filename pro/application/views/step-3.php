<?php $this->load->view('common/meta');?>
<?php $this->load->view('common/header');?>
<style>.delete {font-size: 20px;}#breadcrumbs {
    display: none;
}</style>
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
  <?php
    // var_dump($tech_qualify_pain);
  ?>
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
                        
                        <div class="box active">
                            <div class="bxtitle bxtitle1"><h3>Compose Probing Questions</h3></div>
                            <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
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
					<div class="myfloder_box1 myfloder_box4 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div><br clear="all" />
                </div><?php */?>
                
                <div class="quatabs" style="width:85%; float:left; margin:0px 0px -3px; padding-top:6px;">
                <div >
                    <a href="<?php echo base_url(); ?>campaign/startcampaigncreate" rel="box1">
                        Campaign Focus
                    </a>
                </div>
                <div>
                    <a href="<?php echo base_url(); ?>step/value" rel="box2">
                        Benefits
                    </a>
                </div>
                <div>
                    <a href="<?php echo base_url(); ?>step/pain" rel="box3">
                        Pain Points

                    </a>
                </div>
                <div class="active">
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
           <div class="bxlink" style="float:right;margin:0px 0px 15px 0px;"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div><br clear="all">
            </div>
  	<input type="hidden" id="getanswer" value="0" />
    	<div id="qResponse">
        	<div class="formRow" id="NNNNNNNN">
            	<div class="qrbox">
                    <div class="abox1">Prospect Response</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#qresp').remove();"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
    			<form id="frm-qresp" action="<?php echo current_url();?>" method="post">
                    <input type="hidden" name="qresponse" id="qresponse" value="yes" />
                    <input type="hidden" name="qid" id="qid" value="" />
                    <input type="hidden" name="qrespid" id="qrespid" value="0" />
                    <input type="hidden" name="qpid" id="qpid" value="0" />
                    <div class="qabox1" id="ansListhQR1"><span class="qrhead">Enter a prospect response to your question</span>:<br /><span class="TextColor" id="parent_answer"></span></div>
                    <div class="qabox2">
                    	<div class="answerbox">
                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_qranswer_id('QR1',15,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_qranswer_id('QR1',25,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div id="ansListQR1"></div>
                        </div>
                    	<textarea name="txtresp1" class="txtresp1 gansQR1" placeholder="Enter prospect response"></textarea>
                        
                    </div><br clear="all" />
                    <div class="qabox1" id="ansListhQR2"><span class="qrhead">Enter a follow-up question or action</span>: </div>
                    <div class="qabox2">
                    	<div class="answerbox">
                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_qranswer_id('QR2',14,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_qranswer_id('QR2',24,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div id="ansListQR2"></div>
                        </div>
                    	<textarea name="txtresp2" class="txtresp2 gansQR2" placeholder="Enter sales response"></textarea>
                        
                    </div><br clear="all" />
                    <div class="abox2"><input type="button" class="buttonM bRed" value="Save" onclick="save_qresponse(this);" />
                    	<span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                    </div>
                </form>
            </div>
        </div>
    	<div id="AnsBlock11" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($tech_qualify_pains)
                    foreach ($tech_qualify_pains  as $sintechpainQualify) {
                        if(!empty($sintechpainQualify->value)) {
							if(in_array($sintechpainQualify->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$sintechpainQualify->tech_q_id.',11)" id="anchor11_'.$sintechpainQualify->tech_q_id.'">'.$sintechpainQualify->value.'</a></div>';
							$valtemps[]=$sintechpainQualify->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        
        <div id="AnsBlock12" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($tech_qualify_painsE1)
                    foreach ($tech_qualify_painsE1  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',12)" id="anchor12_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock13" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($tech_qualify_painsE2)
                    foreach ($tech_qualify_painsE2  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',13)" id="anchor13_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock14" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($tech_qualify_responses)
                    foreach ($tech_qualify_responses  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',14)" id="anchor14_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock15" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($tech_qualify_responsesmain)
                    foreach ($tech_qualify_responsesmain  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',15)" id="anchor15_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock21" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_qualify_pains)
                    foreach ($templateuser_tech_qualify_pains  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',21)" id="anchor21_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        
        <div id="AnsBlock22" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_qualify_painsE1)
                    foreach ($templateuser_tech_qualify_painsE1  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',22)" id="anchor22_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock23" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_qualify_painsE2)
                    foreach ($templateuser_tech_qualify_painsE2  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',23)" id="anchor23_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock24" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_qualify_responses)
                    foreach ($templateuser_tech_qualify_responses  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',24)" id="anchor24_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock25" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span class="TextColor"></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					if($templateuser_tech_qualify_responsesmain)
                    foreach ($templateuser_tech_qualify_responsesmain  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',25)" id="anchor25_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
    <form id="frm-input" action="<?php echo current_url();?>" method="post">
		<?php $q_cols_counts = 0;$q_cols = array();$q_cols_counts += count($tech_qualify_pain); ?>		
			<!--<h3 style="margin-top:30px;color: black;"><span style="color: #B30814;">Questions to Probe for Pain</span></h3>-->
				<!--- Technical Section -->
				<div class="widget tableTabs">
					<div class="tab_container">
						<?php $i= 1; ?>
						<div id="ttab1" class="tab_content">
							<table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="tq_table_<?php echo $i;?>">
								<tbody id="TechQualifyTbody">
                                		<?php if($tech_qualify_pain){?>
                                		<tr class="TechQualifyTrClass">
                                            <td colspan="3">What question would you ask 
													<span class="TextColor">[ 
														<?php 
															if($campaign_info->campaign_target == '1'){	
																echo $campaign_info->individual;
															}else{
																echo $campaign_info->organization;
															}
														?>
														
													]</span> to identify if they have any of the following problems? </td>
                                                    <td>Order</td>
                                        </tr>
									<?php foreach($tech_qualify_pain as $sintechpainQualify) { ?>
										<tr class="QualifyBR_<?php echo $sintechpainQualify->tech_qualify_id ; ?> TechQualifyTrClass">
											<td class="no-border"  width="70%" align="left" valign="middle" id="ansListh<?php echo $sintechpainQualify->tech_qualify_id;?>">
												
													<span class="TextColor"><?php echo (!empty($sintechpainQualify->tech_pain_val ) ? $sintechpainQualify->tech_pain_val : NULL);?></span>
                                                    
											</td>
											<td class="no-border">
												<div class="grid5">
                                                	<div class="answerbox">
                                                        <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('<?php echo $sintechpainQualify->tech_qualify_id;?>',11,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                        <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('<?php echo $sintechpainQualify->tech_qualify_id;?>',21,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                        <div id="ansList<?php echo $sintechpainQualify->tech_qualify_id;?>"></div>
                                                    </div>
													<?php /*?><div align="center" class="TextColorH">Yes - How</div><?php */?>
													<textarea  class="validate[required] gans<?php echo $sintechpainQualify->tech_qualify_id;?>"  style="width:500px;" id="QQ_7" name="tbl[tqd][<?php echo $sintechpainQualify->tech_qualify_id ?>][tech_qualify]" cols="" rows=""><?php echo $sintechpainQualify->tech_qualify_val ?></textarea>                                                    <div  style="margin-top: 20px;">
                                                        <div><input type="checkbox" value="1" <?php if(!$sintechpainQualify->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $sintechpainQualify->tech_qualify_id; ?>,this,0);" /> Do not display answer in templates</div>
                                                         <div style="padding-top:10px;">
                                                            <input type="checkbox" value="1" <?php if($sintechpainQualify->highlight) echo 'checked="checked"'; ?>  onchange="updateTechHighlightAnswer(<?php echo $sintechpainQualify->tech_qualify_id; ?>,this,0);" /> Highlight answer in sales scripts
                                                        </div><br />
                                                        <div align="center">
                                                        	 <?php /*?><a href="javascript:void(0);" class="buttonM bRed" 
                                                             onClick="show_qresponse(<?php echo $sintechpainQualify->tech_qualify_id;?>,0)">Add a Follow-Up Question</a><?php */?>
                                                        </div>
													</div>					   
												</div>
											</td>
											<td class="no-border" >
												<div class="grid5">
													<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
													<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $sintechpainQualify->tech_qualify_id;?>" onclick="hide_box_status('<?php echo $sintechpainQualify->tech_qualify_id;?>','tqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
												</div>
											</td>
                                            <td><input type="text" class="qorder" value="<?php echo $sintechpainQualify->qus_id; ?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $sintechpainQualify->tech_qualify_id; ?>,this.value);" /></td>
										</tr>
                                        <?php 
											//display qualify responses
											qualify_resplist_htmledit_view($sintechpainQualify->tech_qualify_id,$campaign_info->campaign_id);
										?>
									<?php } ?>
                                    
                                    <?php } ?>
									
									
									<?php if($tech_qualify_pain_orph) {$q_cols_counts += count($tech_qualify_pain_orph); ?>
										<?php  foreach($tech_qualify_pain_orph  as $sintechpainQualifyOrp) {
												//by Dev@4489
												if($sintechpainQualifyOrp->q_col) {
													$q_cols[$sintechpainQualifyOrp->q_col]=$sintechpainQualifyOrp;
													continue;
												}
												////
										 ?>
											<tr class="TechQualifyTrClass">
												<td class="no-border" width="70%" align="left" valign="middle" id="ansListh<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>">
													<?php /*?>What additional technical question would you ask   
													<span class="TextColor">[	
													<?php 
														if($campaign_info->campaign_target == '1'){	
															echo $campaign_info->individual;
														}else{
															echo $campaign_info->organization;
														}
													?>]</span>?<?php */?>
                                                    <span class="TextColor"><?php echo (!empty($sintechpainQualifyOrp->tech_pain_val ) ? $sintechpainQualifyOrp->tech_pain_val : 'Common Problem');?></span> 
                                                    
												</td> 
												<td class="no-border" style="width: 32%;">
													<div class="grid5">
                                                    	<div class="answerbox">
                                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>',11,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>',21,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                            <div id="ansList<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>"></div>
                                                        </div>
														<?php /*?><div align="center" class="TextColorH">Yes - How</div><?php */?>
														<textarea class="validate[required] dynamicTxt gans<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>" style="width:500px;" name="tbl[tqd][<?php echo $sintechpainQualifyOrp->tech_qualify_id ?>][tech_qualify]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id;?>_<?php echo $sintechpainQualifyOrp->tech_qualify_id ?>"><?php echo $sintechpainQualifyOrp->tech_qualify_val ?></textarea>
                                                        <div  style="margin-top: 20px;">
                                                        	  <div><input type="checkbox" value="1" <?php if(!$sintechpainQualifyOrp->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $sintechpainQualifyOrp->tech_qualify_id; ?>,this,0);" /> Do not display answer in templates</div>
                                                               <div style="padding-top:10px;">
                                                               <input type="checkbox" value="1" <?php if($sintechpainQualifyOrp->highlight) echo 'checked="checked"'; ?>  onchange="updateTechHighlightAnswer(<?php echo $sintechpainQualifyOrp->tech_qualify_id; ?>,this,0);" />Highlight answer in sales scripts<br />
                                                            </div><br />
                                                            <?php /*?><div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_qresponse(<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>,0)">Add a Follow-Up Question</a></div><?php */?>
                                                        </div>
		                                             </div>
												</td>
												<td class="no-border" >
												  <div class="grid5">
														<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
														<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>" onclick="hide_box_status('<?php echo $sintechpainQualifyOrp->tech_qualify_id;?>','tqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
												  </div>
												</td>
                                                <td><input type="text" class="qorder" value="<?php echo $sintechpainQualifyOrp->qus_id; ?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $sintechpainQualifyOrp->tech_qualify_id; ?>,this.value);" /></td>
											</tr>
                                            <?php 
												//display qualify responses
												qualify_resplist_htmledit_view($sintechpainQualifyOrp->tech_qualify_id,$campaign_info->campaign_id);
											?>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
                            <!--EXTRA 2 Qualify questions-->
                           <?php /*?> <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
								<tbody>
                                	<tr class="TechQualifyTrClass eqn1 QualifyBR_eqn1">
                                        <td colspan="4" class="no-border">
                                            What question should you ask to identify if the prospect uses what you currently sell or if they are currently using or have purchased something similar to what you sell?
                                        </td> 
                                    </tr>    
                                    <tr class="TechQualifyTrClass eqn1 QualifyBR_eqn1">
                                        <td class="no-border" width="70%" id="ansListh<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:'N1');?>">&nbsp;
                                            <span class="TextColor" style="display:none;">What question should you ask to identify if the prospect uses what you currently sell or if they are currently using or have purchased something similar to what you sell?</span>
                                            
                                        </td> 
                                        <td class="no-border" style="width: 32%;">
                                            <div class="grid5">
                                            	<div class="answerbox">
                                                    <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:'N1');?>',12,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:'N1');?>',22,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div id="ansList<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:'N1');?>"></div>
                                                </div>
                                                <textarea class="validate[required] dynamicTxt gans<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:'N1');?>" style="width:500px;" name="<?php echo (isset($q_cols[1])?'tbl[tqd]['.$q_cols[1]->tech_qualify_id.'][tech_qualify]':'qtbl[tqd][1][value]');?>" cols="" rows="" id="P<?php echo $campaign_info->campaign_id;?>_<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:'N1');?>"><?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_val:'');?></textarea>
                                                <div align="center" style="margin-top: 20px;">
														<?php if(isset($q_cols[1])){?>
	    											   <div><input type="checkbox" value="1" <?php if(!$q_cols[1]->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $q_cols[1]->tech_qualify_id; ?>,this,0);" /> Do not display answer in templates</div><div style="padding-top:10px;">
                                                       
                                                       <input type="checkbox" value="1" <?php if($q_cols[1]->highlight) echo 'checked="checked"'; ?>  onchange="updateTechHighlightAnswer(<?php echo $q_cols[1]->tech_qualify_id; ?>,this,0);" /> Highlight answer in sales scripts</div><br>
                                                       <div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_qresponse(<?php echo $q_cols[1]->tech_qualify_id;?>,0)">Add a Follow-Up Question</a></div>
                                                      <?php }?></div>                                                        
                                                      
                                                </div>
                                        </td>
                                        
                                        <td class="no-border">
                                            <div class="grid5">
												<?php if(isset($q_cols[1])) {?>
                                                <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $q_cols[1]->tech_qualify_id;?>" onclick="hide_box_status('<?php echo $q_cols[1]->tech_qualify_id;?>','tqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
                                                <?php }else{?>
                                                <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_eqn1" onclick="$('.eqn1').remove()">X</span></div>
                                                <?php }?>
                                            </div>
                                        </td>
                                        <td><input type="text" class="qorder" <?php if(!isset($q_cols[1])) echo ' name="qtbl[tqd][1][qorder]"';?> value="<?php echo (isset($q_cols[1])?$q_cols[1]->qus_id:$q_cols_counts+1);?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder('<?php echo (isset($q_cols[1])?$q_cols[1]->tech_qualify_id:0);?>',this.value);" /></td>
                                    </tr>
                                    <?php if(isset($q_cols[1])){
											//display qualify responses
											qualify_resplist_htmledit_view($q_cols[1]->tech_qualify_id,$campaign_info->campaign_id);
										  }
									?>
                                    <tr class="TechQualifyTrClass eqn2 QualifyBR_eqn2">
                                        <td class="no-border" colspan="4">
                                            What question should you ask to determine if the prospect is the right person for you to be talking with?
                                        </td> 
                                    </tr>    
                                    <tr class="TechQualifyTrClass eqn2 QualifyBR_eqn2">
                                        <td class="no-border" width="70%" id="ansListh<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:'N2');?>">&nbsp;
                                            <span class="TextColor" style="display:none;">What question should you ask to determine if the prospect is the right person for you to be talking with?</span>
                                            
                                        </td> 
                                        <td class="no-border" style="width: 32%;">
                                            <div class="grid5">	
                                            	<div class="answerbox">
                                                    <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:'N2');?>',13,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:'N2');?>',23,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div id="ansList<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:'N2');?>"></div>
                                                </div>
                                                <textarea class="validate[required] dynamicTxt gans<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:'N2');?>" style="width:500px;" name="<?php echo (isset($q_cols[2])?'tbl[tqd]['.$q_cols[2]->tech_qualify_id.'][tech_qualify]':'qtbl[tqd][2][value]');?>" cols="" rows="" id="P<?php echo $campaign_info->campaign_id;?>_<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:'N2');?>"><?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_val:'');?></textarea>
                                                <div align="center" style="margin-top: 20px;">
													  <?php if(isset($q_cols[2])){?>
                                                      <div><input type="checkbox" value="1" <?php if(!$q_cols[2]->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $q_cols[2]->tech_qualify_id; ?>,this,0);" /> Do not display answer in templates</div> <div style="padding-top:10px;">
                                                      <input type="checkbox" value="1" <?php if($q_cols[2]->highlight) echo 'checked="checked"'; ?>  onchange="updateTechHighlightAnswer(<?php echo $q_cols[2]->tech_qualify_id; ?>,this,0);" />Highlight answer in sales scripts</div><br>
	    											  <div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_qresponse(<?php echo $q_cols[2]->tech_qualify_id;?>,0)">Add a Follow-Up Question</a></div>
                                                      <?php }?></div>                                                        
                                                      
                                                </div>
                                        </td>
                                        <td class="no-border" >
                                            <div class="grid5">
												<?php if(isset($q_cols[2])) {?>
                                                <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $q_cols[2]->tech_qualify_id;?>" onclick="hide_box_status('<?php echo $q_cols[2]->tech_qualify_id;?>','tqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
                                                <?php }else{?>
                                                <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_eqn2" onclick="$('.eqn2').remove()">X</span></div>
                                                <?php }?>
                                            </div>
                                        </td>
                                        <td><input type="text" class="qorder" <?php if(!isset($q_cols[2])) echo ' name="qtbl[tqd][2][qorder]"';?> value="<?php echo (isset($q_cols[2])?$q_cols[2]->qus_id:$q_cols_counts+2);?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder('<?php echo (isset($q_cols[2])?$q_cols[2]->tech_qualify_id:0);?>',this.value);" /></td>
                                    </tr>
                                    <?php if(isset($q_cols[2])){
											//display qualify responses
											qualify_resplist_htmledit_view($q_cols[2]->tech_qualify_id,$campaign_info->campaign_id);
										   }
									?>
                                </tbody>
                            </table><?php */?>
                            <!--END OF EXTRA 2 Qualify questions-->
						</div>
					</div>
					<div class="clear"></div>
				</div>        
				<?php if($is_paid):?>
				<div align="right">
					<input type="button" <?php if($is_paid) { ?> onclick='DynamicAddRowTechQualify(this)' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?>  value="Add a Question" style="margin-top:10px;color:white !important;"/>	        	
				</div>
				<?php else:?>
				<div align="right">
					<input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add a Question" style="margin-top:10px;color:white !important;"/>
				</div>
				<?php endif;?> 			
		
		<?php /** These sections are commented to hide these in PRO version - Developer-A?>
		<?php if($biz_qualify_pain) { ?>
			<!--- Business Section -->
			<h3 style="margin-top:30px;color: black;"><span style="color: #B30814;">Business Questions</span></h3>
			<div class="widget tableTabs">
				<div class="tab_container">
					<?php $i= 1; ?>
					<div id="ttab1" class="tab_content">
						<table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="bq_table_<?php echo $i;?>">
							<tbody id="BizQualifyTbody">
							<?php foreach($biz_qualify_pain as $sinbizqualifypain) { ?>
									<tr class="QualifyBR_<?php echo $sinbizqualifypain->biz_qualify_id ?> BizQualifyTrClass">  
										<td class="no-border" colspan="3" width="70%">
											What question would you ask 
											<span class="TextColor">[
												<?php 
													if($campaign_info->campaign_target == '1'){	
														echo $campaign_info->individual;
													}else{
														echo $campaign_info->organization;
													}
												?>
											]</span>
											to identify if they have
											<span class="TextColor">[<?php echo (!empty($sinbizqualifypain->biz_pain_val) ? $sinbizqualifypain->biz_pain_val : Null);?>]</span>?
										</td>
										<td class="no-border" >
											<div class="grid5">
												<div align="center" class="TextColorH">Yes - How</div>
												<textarea  class="validate[required]"  style="width:350px;" id="QQ_7" name="tbl[bqd][<?php echo $sinbizqualifypain->biz_qualify_id ?>][bus_qualify]" cols="" rows=""><?php echo $sinbizqualifypain->biz_qualify_val ;?></textarea>
											</div>
										</td>
										<td class="no-border" >
											<div class="grid5">
											  <div align="center" class="TextColorH">No </div>
											  <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $sinbizqualifypain->biz_qualify_id;?>" onclick="hide_box_status('<?php echo $sinbizqualifypain->biz_qualify_id;?>','bqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
											</div>
										</td>
									</tr>
							    <?php } ?>
								
								<!-- Show Additional Business Qualifying Question  -->
								
								<?php if($biz_qualify_pain_orph) { ?>
									<?php foreach($biz_qualify_pain_orph as $sinbizqualifypainOrg) { ?>
										<tr class="BizQualifyTrClass">		                            			
											<td class="no-border" colspan="3" style="width: 70%;" >
												What additional business question would you ask
													<span class="TextColor">[
													<?php 
														if($campaign_info->campaign_target == '1'){	
															echo $campaign_info->individual;
														}else{
															echo $campaign_info->organization;
														}
													?>]</span>? 
											</td>								               	
																			                
																			                
											<td class="no-border" >
												<div class="grid5">
													<div align="center" class="TextColorH">Yes - How</div>
													<textarea  class="validate[required]"  style="width:350px;" id="QQ_7" name="tbl[bqd][<?php echo $sinbizqualifypainOrg->biz_qualify_id ?>][bus_qualify]" cols="" rows=""><?php echo $sinbizqualifypainOrg->biz_qualify_val ;?></textarea>
												</div>
																			                
											</td>								                
											<td class="no-border">
												<div class="grid5">
												  <div align="center" class="TextColorH">No </div>
												  <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $sinbizqualifypainOrg->biz_qualify_id;?>" onclick="hide_box_status('<?php echo $sinbizqualifypainOrg->biz_qualify_id;?>','bqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
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
		   <?php if($is_paid):?>            
			<div align="right">
				<input type="button" <?php if($is_paid) { ?> onclick='DynamicAddRowBizQualify(this)' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?>  value="Add Business Question" style="margin-top:10px;color:white !important;"/>	        	
			</div>	     
			  <?php else:?>		 	
			<div align="right">
				<input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Business Question" style="margin-top:10px;color:white !important;"/>
			</div>		
			<?php endif;?> 
			
        <?php } ?>
		
		<?php  if($per_qualify_pain) { ?>
			<!--- Personal Section -->
			<h3 style="margin-top:30px;color: black;"><span style="color: #B30814;">Personal Questions</span></h3>
			<div class="widget tableTabs">
				<?php $i= 1; ?>
				<div class="tab_container">
					<div id="ttab1" class="tab_content">
						<table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="pq_table_<?php echo $i;?>">
							<tbody id="PerQualifyTbody">
								
								<?php  foreach($per_qualify_pain  as $sigPerQualifyPain ) { ?>
									<tr class="QualifyBR_<?php echo $sigPerQualifyPain->per_qualify_id ;?> PerQualifyTrClass">
									  <td class="no-border" colspan="3" style="width: 70%;">
										What question would you ask 
										<span class="TextColor">[
											<?php 
												if($campaign_info->campaign_target == '1'){	
													echo $campaign_info->individual;
												}else{
													echo $campaign_info->organization;
												}
											?>
										]</span> 
										to identify if they have
										<span class="TextColor">[<?php echo (!empty($sigPerQualifyPain->per_pain_val) ? $sigPerQualifyPain->per_pain_val : NULL);?>]</span>?
									  </td>
									  
									  <td class="no-border">
										<div class="grid5">
											<div align="center" class="TextColorH">Yes - How</div>
											<textarea  class="validate[required]"  style="width:350px;" id="QQ_15" name="tbl[pqd][<?php echo $sigPerQualifyPain->per_qualify_id;?>][pers_qualify]" cols="" rows=""><?php echo $sigPerQualifyPain->per_qualify_val; ?></textarea>	
										</div>
									  </td>
									  <td class="no-border" >
										<div class="grid5">
										  <div align="center" class="TextColorH">No </div>
										    <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $sigPerQualifyPain->per_qualify_id;?>" onclick="hide_box_status('<?php echo $sigPerQualifyPain->per_qualify_id; ?>','pqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
										</div>
									  </td>
									</tr>
								<?php } ?>
								
								<!-- Show Additional Personal Qualifying Question -->								
								<?php if($per_qualify_pain_orph) {?>
									<?php foreach($per_qualify_pain_orph as  $sigPerQualifyPainOrp ) { ?>
										<tr class="PerQualifyTrClass">
										  <td class="no-border" colspan="3" style="width: 70%;">
											What additional personal question would you ask 
												<span class="TextColor">[
													<?php 
														if($campaign_info->campaign_target == '1'){	
															echo $campaign_info->individual;
														}else{
															echo $campaign_info->organization;
														}
													?>]</span>? 
										  </td>
										  
										  <td class="no-border" >
											<div class="grid5">
											  <div align="center" class="TextColorH">Yes - How</div>
											  <textarea  class="validate[required]"  style="width:350px;" id="QQ_15" name="tbl[pqd][<?php echo $sigPerQualifyPainOrp->per_qualify_id;?>][pers_qualify]" cols="" rows=""><?php echo $sigPerQualifyPainOrp->per_qualify_val; ?></textarea>	
											</div>
										  </td>
										  <td class="no-border">
											<div class="grid5">
												<div align="center" class="TextColorH">No </div>
												<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $sigPerQualifyPainOrp->per_qualify_id;?>" onclick="hide_box_status('<?php echo $sigPerQualifyPainOrp->per_qualify_id; ?>','pqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
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
			<?php if($is_paid):?>            
			<div align="right">
				<input type="button" <?php if($is_paid) { ?> onclick='DynamicAddRowPerQualify(this)' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?>  value="Add Personal Question" style="margin-top:10px;color:white !important;"/>
			</div>	     
			  <?php else:?>		 	
			<div align="right">
				<input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Personal Question" style="margin-top:10px;color:white !important;"/>
			</div>		
			<?php endif;?>      	
       <?php } ?>
        <?php **/ ?>
        <div class="fluid" style="margin-top:15px;">
			<?php if($session_status != '2'):?>
				<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
				<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
				<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
				<input type="hidden" name="step" value="qualify" />
				<input type="hidden" id="redirect_url" name="redirect_url" value="" / >			
			<?php else:?>         	
				<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
				<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
				<input type="hidden" name="step" value="qualify" />
				<input type="hidden" id="redirect_url" name="redirect_url" value="" / >	      
			<?php endif;?>
        </div>
    </form>
  </div>
</div>
</div>
<!-- Main content ends -->
</div>
<!-- Content ends -->
<script type="text/javascript">
	//Update Tech qualify sort order by Dev@4489
	function updateSorder(rcid,oval)
	{
		if(rcid=='0') return;
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
	//set Answer
	function set_answer(gans,uans) {
		$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_"+gans).html());
		$("#pastanswers").hide();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}

	//set Answer id
	function set_answer_id(gans,uans,dis) {
		$("#qresp").remove();
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
	 *  this is name drop 
	 */
	function hide_box_status(id,srttbl_name,campain_id){
		if(!confirm('Are u sure you want to delete?')) return;
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."campaign/makingfielsddisabled/" ?>', 
			data : { 'meta_key' : srttbl_name, 'cid': campain_id,'p_id' : id},
			success : function(data){
				// console.log(data);
				// window.location=window.location;
				// location.reload(false);
				$('#frm-input').submit();
			}
		});
	}
	
	/***
	 *   dynamic add new technical qualify question and answer
	 */
	function DynamicAddRowTechQualify(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		var newiddy ;
		var numItems = $('.TechQualifyTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicTechQualify" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#TechQualifyTbody').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
				$('.qorder:last').val($('.qorder').length+1);//by Dev@4489
			}
		});
	}
	
	/***
	 *   dynamic add new technical qualify question and answer
	 */
	function DynamicAddRowBizQualify(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		var newiddy ;
		var numItems = $('.BizQualifyTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicBizQualify" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#BizQualifyTbody').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
			}
		});
	}
	
	/***
	 *   dynamic add new technical qualify question and answer
	 */
	function DynamicAddRowPerQualify(obj)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		var newiddy ;
		var numItems = $('.PerQualifyTrClass').length
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicPerQualify" ?>',
			data :  {'totalcount': numItems+1},
			success : function(data){
				$('#PerQualifyTbody').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
			}
		});
	}
	
	//Update Tech Value display option
    function updateTechDisplay(rcid,dis,qp) {
        var vis = dis.checked?0:1;
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=QualifyShowupdate&val='+vis+'&qp='+qp,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                //  
            }
        });

    }
	
	//Update Tech Value Highlight display option
    function updateTechHighlightAnswer(rcid,dis,qp) {
        var vis = dis.checked?1:0;
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=QualifyShowHighlightupdate&val='+vis+'&qp='+qp,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                //  
            }
        });

    }
	
	//Question trees show_qresponse by Dev@4489
	//show response
	function show_qresponse(qfid,qrparent) {
		$("#qresp").remove();
		$("#pastanswers").remove();
		var AnList= $("#qResponse").html().replace("NNNNNNNN","qresp");
		AnList = AnList.replace("noBorderB","");
		$("#ansListh"+qfid).prepend(AnList);
		if($("#ansList"+qfid).width()>400) $("#qresp").css("margin-left",($("#ansList"+qfid).width()-400)+"px");
		$("#qresp #qid").val(qfid);
		$("#qresp #qpid").val(qrparent);
		//$("#qresp #parent_answer").html($(".gans"+qfid).val());
		$("#qresp #parent_answer").html($(".gans"+(qrparent?'QR'+qrparent:qfid)).val());
		//Save Qualify answer
		save_all_qanswers();
		<?php /*?>var etext = $(".gans"+qfid).val();
		var eid = qfid;
		var etype = 'q';
		if(qrparent) {
			etext = $(".gansQR"+qrparent).val();
			eid = qrparent;
			etype = 'qr';
		}
		$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: {action:'saveqrinfo',etext:etext,eid:eid,etype:etype},
				cache: false,
				success: function(responce)
				{
					//Saved
				}
			});<?php */?>
	}
		
	//Save Qualify all questions
	function save_all_qanswers() {
		var tclass = '';
		var t1;
		var etext,eid,etype;
		$( "textarea[class*=' gans']" ).each(function( index ) {
			etext = $(this).val();
			tclass = $(this).attr("class");
			etext=='';
			eid='';
			etype='';
			if(tclass.indexOf("gansQR")!=-1) {
				t1 = tclass.split("gansQR");
				eid = t1[1];
				etype = 'qr';
			} else if(tclass.indexOf("gans")!=-1) {
				t1 = tclass.split("gans");
				eid = t1[1];
				etype = 'q';
			}
			if(etext && eid && etype) {
			$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: {action:'saveqrinfo',etext:etext,eid:eid,etype:etype},
				cache: false,
				success: function(responce)
				{
					//Saved
				}
			});
			}
		});
		return;
	}
	//Save Response
	function save_qresponse(sbtn) {
		var rform = $(sbtn).parent();
		var rdiv = rform.parent();
		if($("#qresp .txtresp1").val()=="") {
			$("#qresp .txtresp1").focus();
			alert("Enter prospect response");
			return;
		}
		if($("#qresp .txtresp2").val()=="") {
			$("#qresp .txtresp2").focus();
			alert("Enter follow-up question");
			return;
		}
		
		$("#qresp .loader").show();
		$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: $("#qresp form").serialize(),
				cache: false,
				dataType: 'json',
				success: function(responce)
				{
					$("#qresp .loader").hide();
					location.replace("<?php echo current_url();?>");
				}
			});	
	}
	//Delete Response by Dev@4489
	function delresp(qrespid) {
		if(!confirm('Are u sure you want to delete?')) return;
		$("#qrid_"+qrespid+" .loader").show();
		$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: {action:'deleteResp',qrid:qrespid},
				cache: false,
				dataType: 'json',
				success: function(responce)
				{
					$(".qr_"+qrespid).remove();
				}
			});	
	}	
	//set Answer id for Qualify response popup
	function set_qranswer_id(gans,uans,dis) {
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var qheader = $("#qresp #ansListh"+gans+" span.qrhead").html();
		var AnList= $("#AnsBlock"+uans).html().replace("NNNNNNNN","pastanswers");
		$("#qresp #ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$("#pastanswers .uapboxyr_box2 span").html(qheader);
		$(dis).addClass('btactive');
		$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
		$(".btactive .ansdown").hide();
	}
	//end of question trees
	
</script>
<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/IaxnAdzR63w?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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