	<?php
		$findproduct = $this->campaign->getProduct($campaign_info->product_id);
	?>
<tr id="TechTR<?php echo $TechRowCounter;?>" class="TechTrClass TechTR_<?php echo $new_tech_val_id ;?>">										
	<td style="vertical-align:top;padding-top: 22px;"> 
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
		</span> to 
		
		<!-- <span class="dynamicTxt_V<?php echo $campaign_info->product_id;?>_<?php echo $new_tech_val_id;?> TextColor"><?php echo 'Value'; ?></span>. -->
	</div>
	
	</td>
	
	<td class="no-border" width="20%">
		<div class="grid5" style="width:100%;">
			<?php /*?><div align="center" class="TextColorH">Yes - How?</div><?php */?>
            <div class="answerbox">
                <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id(<?php echo $new_tech_val_id;?>,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id(<?php echo $new_tech_val_id;?>,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                <div id="ansList<?php echo $new_tech_val_id;?>"></div>
            </div>
			<textarea class="validate[required] dynamicTxt dynamicFillTec_<?php echo $new_tech_val_id;?> TechValuesdy gans<?php echo $new_tech_val_id;?>" style="width:500px;" name="tbl[tvd][<?php echo $new_tech_val_id ; ?>][tech_value]" id="V<?php echo $campaign_info->product_id;?>_<?php echo $new_tech_val_id;?>" cols="" rows="" onkeyup="TechdynamicText();" vno="<?php echo $new_tech_val_id;?>" sno=<?php echo $new_tech_val_id;?>><?php echo 'Value';?></textarea>
			<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
            <div style="margin-top: 20px;">
            	<div><input type="checkbox" value="1" onchange="updateTechValueDisplay(<?php echo $new_tech_val_id; ?>,this);" /> Do not display answer in templates</div>
                <div style="padding-top:10px;"><input type="checkbox" value="1"onchange="updateTechValueHighlight(<?php echo $new_tech_val_id; ?>,this);" /> Highlight answer in sales scripts</div><br />        
                <div align="center">
                	 <a href="javascript:void(0);" class="buttonM bRed" onclick="get_hint(<?php echo $new_tech_val_id;?>)">Value Setup Tool</a> 
                     <a href="javascript:void(0);" class="buttonM bRed preview-answers" onclick="preview_answer('V<?php echo $campaign_info->product_id;?>_<?php echo $new_tech_val_id;?>')">Preview Answer</a><br />
                </div>
            		
		</div>
	</td>
	<td class="no-border">
		<div class="grid4">
			<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
			<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $new_tech_val_id;?>" onclick="hide_box_status('<?php echo $new_tech_val_id ;?>','tvd','<?php echo $campaign_info->campaign_id; ?>');">X</span></div>
		</div>
	</td>
    <td><input type="text" class="qorder" value="1" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $new_tech_val_id; ?>,this.value);" /></td>
</tr>