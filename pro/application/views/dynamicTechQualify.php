<tr class="TechQualifyTrClass">
  <td class="no-border" width="70%" align="left" valign="middle" id="ansListh<?php echo $new_tech_qualify_id;?>">
	<span class="TextColor">Common Problem</span>
  </td> 
  <td class="no-border" style="width: 32%;">
	<div class="grid5">
    	<div class="answerbox">
            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id(<?php echo $new_tech_qualify_id;?>,11,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id(<?php echo $new_tech_qualify_id;?>,21,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
            <div id="ansList<?php echo $new_tech_qualify_id;?>"></div>
        </div>
		<?php /*?><div align="center" class="TextColorH">Yes - How</div><?php */?>
		<textarea class="validate[required] dynamicTxt gans<?php echo $new_tech_qualify_id;?>" style="width:500px;" name="tbl[tqd][<?php echo $new_tech_qualify_id ?>][tech_qualify]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id;?>_<?php echo $new_tech_qualify_id ; ?>"><?php echo 'Qualify' ?></textarea> 
        <div style="margin-top: 20px;"><div><input type="checkbox" value="1" onchange="updateTechDisplay(<?php echo $new_tech_qualify_id; ?>,this,0);" /> Do not display answer in templates</div><div style="margin-top:10px;"><input type="checkbox" value="1" onchange="updateTechHighlightAnswer(<?php echo $new_tech_qualify_id; ?>,this,0);" /> Highlight answer in sales scripts</div><br><div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_qresponse(<?php echo $new_tech_qualify_id;?>,0)">Add a Follow-Up Question</a></div></div>                                                                   
	</td>
	<td class="no-border" >
	  <div class="grid5">
			<?php /*?><div align="center" class="TextColorH">No </div><?php */?>
			<div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $new_tech_qualify_id;?>" onclick="hide_box_status('<?php echo $new_tech_qualify_id; ?>','tqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
	  </div>
	</td>
    <td><input type="text" class="qorder" value="1" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateSorder(<?php echo $new_tech_qualify_id; ?>,this.value);" /></td>
</tr>