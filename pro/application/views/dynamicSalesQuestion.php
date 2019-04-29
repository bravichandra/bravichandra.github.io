<tr class="SalesQuestionTrClass" id="sque_<?php echo $new_sales_question_id; ?>">
  <input type="hidden" name="qid[]" value="<?php echo $new_sales_question_id; ?>" />
  <td class="no-border" width="70%" align="left" valign="middle" id="ansListh<?php echo $new_sales_question_id;?>">
	<span class="TextColor">Question</span>
  </td> 
  <td class="no-border" style="width: 32%;">
	<div class="grid5">     
		<textarea style="width:500px;" name="need_questions[]" cols="" rows=""><?php echo 'Answer' ?></textarea>  
        <div style="margin-top:20px;"><input type="checkbox" value="1" onchange="updateNeedDisplay(<?php echo $new_sales_question_id; ?>,this,0);" /> Do not display answer in templates</div>
        <div style="margin-top:10px;"><input type="checkbox" value="1" onchange="updateNeedHighlight(<?php echo $new_sales_question_id; ?>,this,0);" /> Highlight answer in sales scripts</div><br>
        <div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_qresponse(<?php echo $new_sales_question_id;?>,0)">Add a Follow-Up Question</a></div>
	</td>
    <td class="no-border noBorderB">
       <div class="grid5">
            <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $new_sales_question_id;?>" onclick="hide_box_status2('<?php echo $new_sales_question_id; ?>','tqd','<?php echo $campaign_info->campaign_id ?>')">X</span></div>
       </div>
  </td>
  <td class="noBorderB">
      <input type="text" name="qus_id[]" class="qorder" value="1" style="height:20px; border:1px solid #999999; text-align:center;" size="2" 
      onchange="updateSorder2(<?php echo $new_sales_question_id; ?>,this.value);">
  </td>
</tr>