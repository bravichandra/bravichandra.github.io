<?php if(isset($tasks_list) && $tasks_list) foreach($tasks_list as $crow){
	$parent_name ='';
	if($crow->task_related=='C') {
		$parent_record =$this->crm->get_notes_parent($crow->task_relatedto,'C');
		if($parent_record) $parent_name=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);
	} else if($crow->task_related=='A') {
		$parent_record =$this->crm->get_notes_parent($crow->task_relatedto,'A');
		if($parent_record) $parent_name=ucfirst($parent_record['account_name']);
	}
    ?>
    <tr>
        <td class="no-border"><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
        <td class='no-border'><a href="<?php echo base_url(); ?>crm/<?php echo ($crow->task_related=='A'?'accounts':'contacts');?>/view/<?php echo $crow->task_relatedto;?>"><?php echo $parent_name;?></a></td>
        <td class='no-border'><?php if((int)$crow->task_duedate)echo date("m/d/Y",strtotime($crow->task_duedate))?></td>
    </tr>
    <?php
 }
 if(isset($opportunity_list) && $opportunity_list) foreach($opportunity_list as $crow){?>
<tr>
    <td class="no-border"><a href="<?php echo base_url(); ?>crm/opportunities/view/<?php echo $crow->oppt_id;?>"><?php echo ucfirst($crow->oppt_name);?></a></td>
    <td class='no-border'><?php if($crow->amount) echo '$'.number_format($crow->amount);?></td>
    <td class='no-border'><?php if((int)$crow->close_date) echo date("m/d/Y",strtotime($crow->close_date));?></td>                    
</tr>
<?php 
}
 if(isset($contact_list) && $contact_list) foreach($contact_list as $crow){?>
<tr>
    <td class="no-border"><a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo ucfirst($crow->user_first.' '.$crow->user_last);?></a></td>
    <td class='no-border'><?php echo ucfirst($crow->account_name);?></td>
    <td class='no-border'><?php echo ucfirst($crow->user_title);?></td>
    <td class='no-border' align="center"><?php echo $crow->qpoints;?></td>
</tr>
<?php 
}
if(isset($account_list) && $account_list) foreach($account_list as $crow){?>
<tr>
    <td class="no-border"><a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo ucfirst($crow->account_name);?></a></td>
    <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>
    <td class='no-border' align="center"><?php echo $crow->qpoints;?></td>
</tr>
<?php }?>