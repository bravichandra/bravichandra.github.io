<input type="hidden" id="getsanswer" value="0" />
<div id="qsResponse">
    <div class="formRow" id="NNNNNNNN">
        <div class="qrbox">
            <div class="abox1">Prospect Response</div>
            <div class="abox2"><a href="javascript:void(0)" onClick="$('#qsresp').remove();"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
        </div>
        <form id="frm-qsresp" action="<?php echo current_url();?>" method="post">
            <input type="hidden" name="qsresponse" id="qsresponse" value="yes" />
            <input type="hidden" name="qid" id="qid" value="" />
            <input type="hidden" name="qsrespid" id="qsrespid" value="0" />
            <input type="hidden" name="qpid" id="qpid" value="0" />
            <div class="qabox1" id="ansListhQR1">
            	<span class="qrhead">Enter a prospect response to your question</span>:<br />
            	<span class="TextColor" id="parent_answer"></span>
            </div>
            <div class="qabox2">
                <textarea name="txtresp1" class="txtresp1 gansQR1" placeholder="Enter prospect response"></textarea>
            </div><br clear="all" />
            <div class="qabox1" id="ansListhQR2"><span class="qrhead">Enter a follow-up question or action</span>: </div>
            <div class="qabox2">
                <textarea name="txtresp2" class="txtresp2 gansQR2" placeholder="Enter sales response"></textarea>
            </div><br clear="all" />
            <div class="abox2"><input type="button" class="buttonM bRed" value="Save" onClick="save_qsresponse(this);" />
                <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
            </div>
        </form>
    </div>
</div>
<form  action="" method="post" onsubmit="step2();">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:20px 0px !important;">
                <tr>
                    <td width="43%" align="right" class="salesquestions_title">
                        <b>Category of Questions</b>
                    </td>
                    <td align="left">
                         <input type="hidden" name="squestions_title_id" value="<?php echo $tabtitles[1]->id;  ?>" class="qorder"/>
                            <input type="hidden" name='squestions_type' value="<?php echo $tabtitles[1]->qb_type;  ?>" />
                            <input type="text" class="cat_cus_title qorder" placeholder="Need vs. Want" value="<?php echo $tabtitles[1]->title;  ?>" name="squestions_title"/>
                    </td>
                </tr>
        </table>
        <div class="widget tableTabs">
             <div class="tab_container">
                  <div id="ttab1" class="tab_content">
                        <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="tq_table_1">
                           <tbody id="SalesQuestionTbody">
                                  <?php $i=0; $q_cols_counts = 0;$q_cols = array(); ?>
                                  <?php if($need_want_qus) {$q_cols_counts += count($need_want_qus);?>
                                  <tr id="improveService" class="BizTrClass improveService1">
                                       <td colspan="3" class="noBorderB">&nbsp;</td>
                                       <td class="noBorderB">Order</td>        
                                  </tr>
                                  <?php 
                                    foreach($need_want_qus as $sintechneedWant) { 
                                    $i++;
                                  ?>
                                  <tr class="SalesQuestionTrClass" id="sque_<?php echo $sintechneedWant->id; ?>">
                                  	 <input type="hidden" name="qid[]" value="<?php echo $sintechneedWant->id; ?>" />
                                      <td class="no-border noBorderB" width="70%" align="left" valign="middle" id="ansListh<?php echo $sintechneedWant->id;?>">
                                          <span class="TextColor">Question <?php echo $i; ?></span>
                                       </td>
                                       <td class="no-border noBorderB" style="width: 32%;">
                                           <div class="grid5"> 
                                                 <textarea class="validate[required] gans<?php echo $sintechneedWant->id;?>" style="width:500px;" id="QQ_7" name="need_questions[]"
                                                  cols="" rows=""><?php echo $sintechneedWant->question; ?></textarea>
                                                <div style="margin-top: 20px;">
                                                    <div> <input type="checkbox" value="1" <?php if(!$sintechneedWant->visible) echo 'checked="checked"'; ?>   
                                                    onchange="updateNeedDisplay(<?php echo $sintechneedWant->id; ?>,this,0);" /> Do not display answer in templates</div>
                                                    <div style="padding-top:10px;"> 
                                                        <input type="checkbox" value="1" <?php if($sintechneedWant->highlight) echo 'checked="checked"'; ?>  
                                                         onchange="updateNeedHighlight(<?php echo $sintechneedWant->id; ?>,this,0);" />
                                                        Highlight answer in sales scripts
                                                    </div><br>
                                                    <div align="center"><a href="javascript:void(0);" class="buttonM bRed" 
                                                    onClick="show_fquestions(<?php echo $sintechneedWant->id;?>,0)">Add a Follow-Up Question</a></div>
                                                </div>
                                           </div>
                                       </td>
                                       <td class="no-border noBorderB">
                                           <div class="grid5">
                                                <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_22476" onclick="hide_box_status2('<?php echo $sintechneedWant->id;?>');">X</span></div>
                                           </div>
                                      </td>
                                      <td class="noBorderB">
                                          <input type="text" name="qus_id[]" class="qorder" value="<?php echo $sintechneedWant->qus_id; ?>" 
                                          style="height:20px; border:1px solid #999999; text-align:center;" size="2" 
                                          onchange="updateSorder2(<?php echo $sintechneedWant->id; ?>,this.value,this);">
                                      </td>
                                  </tr>
                                  <?php 
                                        //display sales responses
                                        sales_resplist_htmledit_view($sintechneedWant->id,$campaign_info->campaign_id);
                                    ?> 
                                  <?php }} else { $qi=0;foreach($qualifier_questions['Need_Want'] as $qns){$qi++; ?>
                                  <input type="hidden" name="qid" value="" />
                                  <tr class="QualifyBR_22476 TechQualifyTrClass">
                                      <td class="no-border noBorderB" width="70%" align="left" valign="middle" id="ansListh22476">
                                          <span class="TextColor">Question <?php echo $qi; ?></span>
                                       </td>
                                       <td class="no-border noBorderB" style="width: 32%;">
                                           <div class="grid5"> 
                                                 <textarea class="validate[required] gans22476" style="width:500px;" id="QQ_7" name="need_questions[]"
                                                  cols="" rows=""><?php  echo $qns?></textarea>
                                                <div style="margin-top: 20px;">
                                                    <div><input type="checkbox" value="0" onchange="updateTechDisplay2();"> Do not display answer in templates</div>
                                                    <div style="padding-top:10px;">                                                        	
                                                        <input type="checkbox" value="0" onchange="updateTechHighlightAnswer2();">
                                                        
                                                        Highlight answer in sales scripts
                                                    </div><br>
                                                    <div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_fquestions()">Add a Follow-Up Question</a></div>
                                                </div>
                                           </div>
                                       </td>
                                       <td class="no-border noBorderB">
                                           <div class="grid5">
                                                <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_22476" onclick="hide_box_status2();">X</span></div>
                                           </div>
                                      </td>
                                      <td class="noBorderB">
                                          <input type="text" class="qorder" value="<?php echo $qi; ?>" name="qus_id[]" style="height:20px; border:1px solid #999999; text-align:center;" size="2" 
                                          onchange="updateSorder2(this);">
                                      </td>
                                  </tr>
                                  <?php }} ?>
                             </tbody>
                        </table>
                    </div>
                </div>
                <div class="clear"></div>
            </div>  
            <div style="background:#ffffff; padding:0px 8px 8px;">   
            <div align="right">
                <input type="button" onclick="DynamicAddRowSalesQuestion(this,'tab2')" class="buttonM bBlack" value="Add a Question" style="margin-top:10px;color:white !important;">	
            </div>
            <div class="fluid" style="margin-top:-5px; float:left;">
                    <input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit2" value="Save">
                    <!--<input type="submit" class="buttonM bRed" name="form_submit" value="Continue">-->
                    <!--a  id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" >Create New Session</a-->
                    <input type="hidden" name="step" value="qualify">
                    <input type="hidden" id="redirect_url" name="redirect_url" value="">			
             </div>
          </div>
 </form>