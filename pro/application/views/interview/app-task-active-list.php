<?php if($atasks_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault applicanttab'>
    <thead>
        <tr>                        
            <th class='no-border' style="width:150px;">Action</th>
            <th class='no-border' style="width:150px;" <?php if($applicantlite=="applicant") echo 'width="30%"'?>>Subject</th>
            <?php if($applicantlite=="applicant"){?>
            <th class='no-border'>Email Template</th>
            <?php }?>
            <th class='no-border' style="width:150px;">Record Owner</th>
            <th class='no-border' style="width:150px;">Date Modified </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($atasks_list as $crow){?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url("interviewer/tasks/edit/".$crow->task_id);?>">Edit</a> | <a href="<?php echo base_url("interviewer/tasks/delete/".$crow->task_id);?>" onclick="if(!confirm('Are you sure you want to delete this task?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
            <?php if($applicantlite=="applicant"){?>
            <td class='no-border'><?php echo ucfirst($crow->task_name);?></td>
            <?php }?>
            <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            <td class='no-border'><?php echo date("m/d/Y",strtotime($crow->task_modified))?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>