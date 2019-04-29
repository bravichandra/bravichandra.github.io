<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<style></style>

<!-- Sidebar begins -->
<div id="sidebar">	
	<?php echo $this->load->view('common/left_navigation');?>    
	
	<!-- Secondary nav -->    
	<div class="secNav">        	
		<div class="clear"></div>   
	</div>
</div><!-- Sidebar ends -->
	
	<!-- Content begins -->
	<div id="content">
		<!-- Breadcrumbs line --> 
		<?php echo $this->load->view('common/top_credibility_nav');?> 

		<!-- Main content -->    
			<div class="wrapper">   
            	<input type="hidden" id="getanswer" value="0" />
                <div id="NameBlock1" style="display:none;">
                    <div class="popupbox uapboxyr" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Reuse one of your past answers by selecting from below</div>
                            <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
							$valtemps = array();
                            if($credibilities_data_names)
                            foreach ($credibilities_data_names  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_danswer('.$ansval->answid.',1)" id="anchor1_0'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
				<div id="NameBlock2" style="display:none;">
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
                            if($templateuser_credibilities_data_names)
                            foreach ($templateuser_credibilities_data_names  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_danswer('.$ansval->answid.',2)" id="anchor2_0'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
                <div id="AnsBlock1" style="display:none;">
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
                            if($credibilities_data)
                            foreach ($credibilities_data  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
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
                            <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
                            if($templateuser_credibilities_data)
                            foreach ($templateuser_credibilities_data  as $ansval) {
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
                <div id="AnsBlock21" style="display:none;">
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
                            if($credibilities_data_provided)
                            foreach ($credibilities_data_provided  as $ansval) {
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
                            if($templateuser_credibilities_data_provided)
                            foreach ($templateuser_credibilities_data_provided  as $ansval) {
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
                <div id="AnsBlock31" style="display:none;">
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
                            if($credibilities_data_when)
                            foreach ($credibilities_data_when  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',31)" id="anchor31_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
				<div id="AnsBlock32" style="display:none;">
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
                            if($templateuser_credibilities_data_when)
                            foreach ($templateuser_credibilities_data_when  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',32)" id="anchor32_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
                <div id="ProfileBlock1" style="display:none;">
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
                            if($credibilities_data_profile)
                            foreach ($credibilities_data_profile  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
				<div id="ProfileBlock2" style="display:none;">
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
                            if($templateuser_credibilities_data_profile)
                            foreach ($templateuser_credibilities_data_profile  as $ansval) {
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
				<!-- <h5 style="margin-top:30px;">Identify a client story that you can share</h5> -->

				<form id="validate" action="<?php echo current_url();?>" method="post"> 
					<?php if (isset($credibilities)):?> 
					<?php 
					
					$data = $this->home->get_meta_data($credibilities->c_id, 'credibility', 'tcd');
					$customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;
					$customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : '[past or current client]';	
					$worked_id = $data['worked']['id'];
					$worked_value = isset($data['worked']['value']) ? $data['worked']['value']: '[service provided]';
					$provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;
					$provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : '[technical improvement]';	 
					$when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;
					$when_value = isset($data['when']['value']) ? $data['when']['value']: '[business improvement]';	
					//By Dev@4489					
					$profile_id = isset($data['profile']['id']) ? $data['profile']['id']: NULL;
					$profile_value = isset($data['profile']['value']) ? $data['profile']['value']: $credibilities->credibility_name;
					$PN_S4_id 	= isset($data['profile']['id']) ? $data['profile']['id']: '5';
					////
					$C_S1_id 	= isset($data['customer']['id']) ? $data['customer']['id']: '1';	     
  					$W_S2_id 	= isset($data['worked']['id']) ? $data['worked']['id'] : '2';
					$P_S3_id 	= isset($data['provided']['id']) ? $data['provided']['id'] : '3';
					$W_S4_id 	= isset($data['when']['id']) ? $data['when']['id']: '4';	       				//echo '<pre>'; print_r($data);       				?>			       
					
					<div id="story_1">			    	
					
					<div class="widget tableTabs">		
					<div class="tab_container">	
					<div id="ttab1" class="tab_content">
					<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
						<tbody>			                        	
										                            
							<tr>			                                
								<td class="no-border"  width="70%" id="ansListhc0">Share a current or past customer of yours that is name droppable.</td>			                                
								<td class="no-border" width="20%">
									<div class="grid5">
                                    	<div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_dname_id('c0',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_dname_id('c0',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansListc0"></div>
                                        </div>
										<textarea class="validate[required] dynamicTxt gansc0" style="width:500px;" name="dropname" id="S<?php echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?> " cols="" rows="" onchange="set_profilename(this.value)"><?php echo $credibilities->credibility_name; ?></textarea>
										<input type="hidden" name="editnamedrop" value="<?php echo $credibilities->c_id; ?>"/>
                                        
									</div>
								</td>
								<td class="no-border" >									
									
								</td>			                           
							</tr>
							<tr>
								<td class="no-border"  style="width: 13%;" id="ansListhc1">
									What product or service did you provide
								</td>
				
								<td class="no-border">
									<div class="grid5">
                                    	<div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('c1',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('c1',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansListc1"></div>
                                        </div>
										<textarea class="validate[required] dynamicTxt gansc1" style="width:500px;" name="tcd_<?php echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?>[worked][<?php echo $worked_id;?>][]" id="S<?php echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?>_<?php echo $W_S2_id;?>"  cols="" rows=""><?php echo $worked_value;?></textarea>                                        
									</div>
								</td>
								<td class="no-border" >
									<!-- <div class="grid5">
									 <div id="17" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div> 
									</div> -->
								</td>
							</tr>
							<tr>
								<td class="no-border" id="ansListhc2" style="vertical-align: top;" >
									What was the technical improvement?
									<div align="right">
										<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
										This helped them to (with)
									</div>
								</td>
								
								<td class="no-border">
									<div class="grid5">
                                    	<div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('c2',21,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('c2',22,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansListc2"></div>
                                        </div>
										<textarea class="validate[required] dynamicTxt gansc2" style="width:500px;" name="tcd_<?php echo (isset($credibility->c_id) ? $credibility->c_id : $credibility_id);?>[provided][<?php echo $provided_id;?>][]" id="S<?php echo (isset($credibility->c_id) ? $credibility->c_id : $credibility_id);?>_<?php echo $P_S3_id;?>" cols="" rows=""><?php echo $provided_value;?></textarea>
                                        
									</div>
								</td>
								<td class="no-border">	</td>
							</tr>
							<tr>
								<td class="no-border" id="ansListhc3" style="vertical-align: top;" >
									What was the business improvement? 
									<div align="right">
										<span class="boldWeight">  Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
										And this led to
									</div>
								</td>
								<td class="no-border">
									<div class="grid5">
                                    	<div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('c3',31,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('c3',32,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansListc3"></div>
                                        </div>
										<textarea class="validate[required] dynamicTxt gansc3" style="width:500px;" name="tcd_<?php echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?>[when][<?php echo $when_id;?>][]" id="S<?php echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?>_<?php echo $W_S4_id;?>" cols="" rows=""><?php echo $when_value;?></textarea>
                                        
									</div>
									<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
									
									<!-- <div align="center">
											We worked with <span class="dynamicTxt_S<?php // echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?> TextColor"><?php // echo $credibilities->credibility_name;?></span> and provided <span class="dynamicTxt_S<?php // echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?>_<?php // echo $W_S2_id;?> TextColor"><?php // echo $worked_value;?></span> This helped them to (with) <span class="dynamicTxt_S<?php // echo (isset($credibilities->c_id) ? $credibilities->c_id : $credibility_id);?>_<?php // echo $P_S3_id;?> TextColor"><?php // echo $provided_value;?></span> which lead to 
										<span class="dynamicTxt_S<?php // echo (isset($credibility->c_id) ? $credibility->c_id : $credibility_id);?>_<?php // echo $W_S4_id;?> TextColor"><?php // echo $when_value;?></span>
									</div>
									-->
								</td>
								<td class="no-border" ></td>
							</tr>
                            <tr style="display:none;">
                            	<th colspan="3" align="left" style="color: #b30814">Name Drop Profile Name</th>
                            </tr>
                            <tr style="display:none;">
								<td class="no-border" id="ansListhc4" >
									Enter a descriptive label for this name drop example. You can include details like customer name, size, industry, etc.
								</td>
								
								<td class="no-border">
									<div class="grid5">
                                    	<div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_dprofile_id('c4',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_dprofile_id('c4',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansListc4"></div>
                                        </div>
                                        <input type="hidden" id="ndprofile_edit" value="<?php echo $profile_value;?>" />
										<textarea class="validate[required] dynamicTxt gansc4 ndprofile" style="width:500px;" name="tcd_<?php echo (isset($credibility->c_id) ? $credibility->c_id : $credibility_id);?>[profile][<?php echo $profile_id;?>][]" id="S<?php echo (isset($credibility->c_id) ? $credibility->c_id : $credibility_id);?>_<?php echo $PN_S4_id;?>" cols="" rows=""><?php echo $profile_value;?></textarea>                                        
									</div>
								</td>
								<td class="no-border" >	</td>
							</tr>
                             <tr>
                            	<td  style="border:0px;">&nbsp;
                                	
                                </td>
                                <td colspan="2" style="border:0px;">
                                  <div class="fluid" style="text-align:center;">
                                    <a href="javascript:void(0);" class="buttonM bRed preview-answers" onclick="preview_answer()">Preview Answer</a> 
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
		
					<?php endif;?>
					<div class="container-story"></div>
					<div align="right">
					 <!-- <input type="button"  <?php if($is_paid) { ?> id="btn1" class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Story" style="margin-top:10px;color:white !important;"/> -->
					</div>
					<div class="fluid" style="margin-top:15px;">
						<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" />
						<input type="submit" class="buttonM bRed" name="submit" value="Done" />
						<input type="hidden" name="step" value="credibility"> 
					</div>
				</form>
			</div>
		</div>
        <div class="formRow" id="preview-answer" style="height:auto !important;">
            <div class="value-preview-button">
            	<a class="vpclose" href="javascript:void(0)" onclick="$('#preview-answer').hide();">X</a>
                <div class="ghquest">
                    <span class="ghquest-text">
                   	 	  Name Drop:
                    </span>
                    <div class="val-answers">
                    	 We worked with <?php echo $active_name_drop_exp['worked']->credibility_name ?> and provided <?php echo  $active_name_drop_exp['worked']->value ?>.
                    </div> 
                     <div class="val-answers">
                         This helped them to <?php echo  $active_name_drop_exp['provided']->value ?>, which led to <?php echo  $active_name_drop_exp['when']->value ?>.
                    </div>                                                        
                </div>
            </div>
        </div>
	</div>
	<!-- Main content ends -->
	</div>
<!-- Content ends -->
<script type="text/javascript">
	//set Answer
	function set_danswer(gans,uans) {
		$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_0"+gans).html()); 		
		$("#pastanswers").hide();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		//set profile name
		if(uans==1) set_profilename($("#anchor"+uans+"_0"+gans).html());
	}
	function preview_answer(){		    
        $("#preview-answer").show();
    }
	//Set Profile name 
	function set_profilename(dropname) {
		if($("#ndprofile_edit").val()=="[past client name]") $(".ndprofile").val(dropname);
	}
	//set Name id
	function set_dname_id(gans,uans,dis) {
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var qheader = $("#ansListh"+gans).html();
		var AnList= $("#NameBlock"+uans).html().replace("NNNNNNNN","pastanswers");
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$("#pastanswers .uapboxyr_box2 span").html(qheader);
		$(dis).addClass('btactive');
		$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
		$(".btactive .ansdown").hide();
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
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var qheader = $("#ansListh"+gans).html();
		var AnList= $("#AnsBlock"+uans).html().replace("NNNNNNNN","pastanswers");
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$("#pastanswers .uapboxyr_box2 span").html(qheader);
		$(dis).addClass('btactive');
		$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
		$(".btactive .ansdown").hide();
	}
	//set Profile id
	function set_dprofile_id(gans,uans,dis) {
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var qheader = $("#ansListh"+gans).html();
		var AnList= $("#ProfileBlock"+uans).html().replace("NNNNNNNN","pastanswers");
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
</script>
<?php $this->load->view('common/footer');?>