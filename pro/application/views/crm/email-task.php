<?php 
    $Schedules = array(
        'Follow up with a phone call',
        'Follow up with an email',
        'Stop by in person',
        'Follow up on social media',
        'Attend meeting',
        //'Date'
    );
    $ei=$blockno;
    //Main thread email tasks
    if(isset($thread_id)) {
        if(isset($email_tasks[$thread_id])) {
            $subemail_tasks = $email_tasks[$thread_id];
            foreach($subemail_tasks as $etask) {$ei++;
?>
<tr class="schrow<?php echo $ei?> tasknode" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr>
<tr class="schrow<?php echo $ei?> tasknode">    
    <td class="two" colspan="2">
        <div class="csect scftask setnodes<?php echo $blockno?>">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <th class="Title one" width="280px">Follow-Up Task</th>
                    <td colspan="2" align="right"><a href="javascript:void(0);" class="deletechild" onClick="delete_sch(<?php echo $ei?>,<?php echo $etask->id;?>)">X</a></td>
                </tr>
                <tr class="schrowTimes">
                    <th class="one">Schedule Timing</th>
                    <td colspan="2">
                        <?php
                            $task_duedate_parts = array('','');
                            if($etask->task_duedate) {
                                $task_duedate_parts = explode("-",$etask->task_duedate);
                            }
                            $schOpt=0;
                        ?>
                        <div>
                            <select name="record[tsk_schcounts][]" id="tsk_schcount<?php echo $ei?>"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"<?php if($task_duedate_parts[0]==$n) echo ' selected="selected"'?>><?php echo $n; ?></option><?php } ?></select> 
                            <select  name="record[tsk_schtypes][]" id="tsk_schtype<?php echo $ei?>"><option value="">Select Day/Week</option><option value="1"<?php if($task_duedate_parts[1]=="1") echo ' selected="selected"'?>>Days</option><option value="2"<?php if($task_duedate_parts[1]=="2") echo ' selected="selected"'?>>Weeks</option></select>
            
                        </div>
                    </td>
                </tr>
                <tr>
                    <th class="one"></th>
                    <td class="two">
                        <input type="hidden" name="record[schindx][]" value="<?php echo $ei;?>" />
                        <input type="hidden" name="record[blocktype][]" class="blocktype" value="task" />
                        <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $ei?>" />
                        <input type="hidden" name="record[schids][]" value="<?php echo $etask->id?>" />
                        
                        <?php foreach($Schedules as $ci=>$option) {
                            if($etask->task_subject==$option) {$sel=' checked="checked"';$schOpt=1;} else $sel='';
                            ?>
                        <div><input type="radio" class="optval" <?php echo $sel?> name="record[schs][<?php echo $ei;?>]" value="<?php echo $option;?>" onChange="inter_change(this)" /> <?php echo $option;?></div>
                        <?php }
                            if($etask->task_subject && !$schOpt) $sel=' checked="checked"'; else $sel='';
                        ?>
                        <div>
                            <input type="radio" name="record[schs][<?php echo $ei;?>]" class="optval schother" <?php echo $sel?> value="O" onChange="inter_change(this)" /> Other 
                            <span class="span_schother"  <?php echo ($sel?'':'style="display:none;"')?>>
                                <input name="record[sch_txts][]" type="text" value="<?php echo ($sel?$etask->task_subject:'')?>" class="scho_txt" />
                            </span>
                        </div>                                
                    </td>
                    <td class="two"><b>Notes:</b><br />
                        <textarea class="txtnotes" id="schinotes" name="record[schnotess][]" style="height:100px;"><?php echo $etask->task_info?></textarea>
                    </td>
                </tr>
                
            </table>
        </div>
    </td>              
</tr>
<tr class="schrow<?php echo $ei?> rowfue emailnode">
    <th class="one"></th>
   <td class="two"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onClick="addeditor(this)" />
     <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" data-colp="0" />
  </td>              
</tr>
<?php                
            }
        }
    }
?>