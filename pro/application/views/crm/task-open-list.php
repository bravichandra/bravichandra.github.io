<?php if($otasks_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
		<tr>                        
            <th class='no-border' style="width:80px;">Action</th>
            <th class='no-border'>Subject</th>
            <th class='no-border' style="width:100px;">Record Owner</th>
            <th class='no-border' style="width:130px;">Due Date</th>
        </tr>
        <?php /*?><tr>                        
            <th class='no-border'>Action</th>
            <th class='no-border'>Subject</th>
            <th class='no-border'>Record Owner</th>            
            <th class='no-border'>Due Date</th>
            <th class='no-border'>Status</th>
            <th class='no-border'>Priority</th>
        </tr><?php */?>
    </thead>
    <tbody>
        <?php foreach($otasks_list as $crow){?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url("crm/tasks/edit/".$crow->task_id);?>">Edit</a> | <a href="<?php echo base_url("crm/tasks/delete/".$crow->task_id);?>" onclick="if(!confirm('Are you sure you want to delete this task?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
            <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
			<td class='no-border'><?php if((int)$crow->task_duedate)echo date("m/d/Y",strtotime($crow->task_duedate))?></td>
            <?php /*?>
			<td class='no-border'><?php echo date("m/d/Y",strtotime($crow->task_modified))?></td>
			<td class='no-border'><?php if((int)$crow->task_duedate)echo date("m/d/Y",strtotime($crow->task_duedate))?></td>
            <td class='no-border'><?php echo $crow->task_status;?></td>
            <td class='no-border'><?php echo $crow->task_priority;?></td><?php */?>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>