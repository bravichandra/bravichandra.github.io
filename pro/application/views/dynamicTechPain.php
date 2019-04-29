<?php 
	/* find productinfo */
	$getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
?>
<tr class="TechPainTrClass qtpain<?php echo (($totalcount-1)%2==1?' tabbglight':' tabbgdark');?>" style="border-bottom: 0px solid #DFDFDF;">
	<td class="no-border" colspan="3" id="ansListh<?php echo $new_tech_pain_id;?>" >
		<span>Enter a common problem that you can help <span class="TextColor"><?php if($campaign_info->campaign_target == '1'){	echo $campaign_info->individual;}else{echo $campaign_info->organization;}?></span> with.</span>
	</td>
    <td></td>
</tr>
<tr class="TechPainTrClass<?php echo (($totalcount-1)%2==1?' tabbglight':' tabbgdark');?>" style="border-top: 0px solid #DFDFDF;" >
	<td class="no-border" valign="top" style="vertical-align: top;width:100%;" align="right" id="ansListh<?php echo $new_tech_pain_id;?>" >
        <br /><br />
        <span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp; A lot of 
        <span class="TextColor"><?php if($campaign_info->campaign_target == '1'){	echo $campaign_info->individual;}else{echo $campaign_info->organization;}?></span> have a concern that:
	</td>
	
	
	<td class="no-border">
		<div class="grid5" style="width:100%;">
        	<div class="answerbox">
                <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id(<?php echo $new_tech_pain_id;?>,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id(<?php echo $new_tech_pain_id;?>,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                <div id="ansList<?php echo $new_tech_pain_id;?>"></div>
            </div> 
		<?php /*?><div align="center" class="TextColorH">Yes - How</div><?php */?>
			<textarea class="validate[required] dynamicTxt gans<?php echo $new_tech_pain_id;?>" style="width:555px;" name="tbl[tpnd][<?php echo $new_tech_pain_id;?>][tech_pain]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id ;?>_<?php echo $new_tech_pain_id ?>" vno="<?php echo $new_tech_pain_id ?>" sno=<?php echo $totalcount;?>><?php  echo 'Common Problem'; ?></textarea>
            <?php /*?><div align="center" style="margin-top: 8px;">
            	<a href="javascript:void(0);" class="buttonM bRed" onclick="get_hint(<?php echo $new_tech_pain_id;?>)">Pain Setup Tool</a>
            </div><?php */?>
            <div style="margin-top: 20px;">
                <div><input type="checkbox" value="1" onchange="updateTechDisplay(<?php echo $new_tech_pain_id; ?>,this);" /> Do not display answer in templates</div></div>
                <div style="margin-top: 10px;">
                    <input type="checkbox" value="1" onChange="updateTechPainHighlight(<?php echo $new_tech_pain_id ?>,this);" /> Highlight answer in sales scripts
                </div><br />
                <div align="center">
                     <?php /*?><a href="javascript:void(0);" class="buttonM bRed" onclick="get_hint(<?php echo $singletechpain->tech_pain_id;?>)">Pain Setup Tool</a><?php */?>
                      <a href="javascript:void(0);" class="buttonM bRed preview-answers" onClick="preview_answer('P<?php echo $campaign_info->campaign_id ;?>_<?php echo $new_tech_pain_id;?>')">Preview Answer</a>   
                </div>
			</div>
		</div>
			<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
			
		</div>
	</td>
	<td class="no-border" >
		<div class="grid5" style="width:100%;">
			<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
			<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $new_tech_pain_id ;?>" onclick="hide_box_status('<?php echo $new_tech_pain_id ;?>','tpnd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
		</div>
	</td>
    <td><input type="text" class="qorder" value="1" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $new_tech_pain_id; ?>,this.value);" /></td>
</tr>