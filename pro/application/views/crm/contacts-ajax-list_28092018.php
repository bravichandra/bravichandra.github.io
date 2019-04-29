<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
    <thead>
        <tr class="rheader">
            <th class='no-border'><?php if(!isset($listall)){?><input type="checkbox" id="selectall" /><?php }?></th>
            <th class='no-border'><a href="javascript:void(0)" data-col="name" data-sort="<?php echo ($sortcol=='name' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Name</a></th>
            <th class='no-border'><a href="javascript:void(0)" data-col="title" data-sort="<?php echo ($sortcol=='title' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Title</a></th>
            <th class='no-border' style="width:180px;"><a href="javascript:void(0)" data-col="account" data-sort="<?php echo ($sortcol=='account' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Account</a></th>
            <?php /*if(!isset($mine)){?><th class='no-border'>Record Owner</th><?php }*/?>
            <th class='no-border' style="width:100px;"><a href="javascript:void(0)" data-col="phone" data-sort="<?php echo ($sortcol=='phone' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Phone</a></th>
            <th class='no-border' style="width:150px;"><a href="javascript:void(0)" data-col="email" data-sort="<?php echo ($sortcol=='email' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Email</a></th>
            <th style="width:140px;" class='no-border alcenter'><a href="javascript:void(0)" data-col="qp" data-sort="<?php echo ($sortcol=='qp' && $sortval=='asc'?'desc':'asc');?>" class="rhsort">Quality Points</a></th>
            <?php /*?><th class='no-border'>Task</th><?php */?>
        </tr>
    </thead>
    <tbody>
    	<?php foreach($contacts as $crow)    {
			//$next_task = $this->crm->get_next_task($crow->contact_id,'C');
            //$crow->qpoints = $this->crm->qualify_points('C',$crow->contact_id);
		?>
        <tr>
			<td class='no-border'><input type="checkbox" value="<?php echo $crow->contact_id;?>" name="recids[]" class="rcselect" /></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a></td>
            <td class='no-border'><?php echo $crow->user_title;?></td>
            <td class='no-border'><?php echo $crow->account_name;?></td>
            <?php /*if(!isset($mine)){?><td class='no-border'><?php echo ucfirst($crow->usrname);?></td><?php }*/?>
            <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>
            <td class='no-border'><?php if($crow->email) echo '<a href="mailto:'.$crow->email.'">'.$crow->email.'</a>';?></td>
            <td class='no-border alcenter'><?php echo ($crow->qpoints?$crow->qpoints:'');?></td>
            <?php /*?><td class='no-border'><?php if($next_task){?><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $next_task[task_id];?>"><?php echo ucfirst($next_task[task_subject])?></a><?php }?></td><?php */?>
        </tr>
        <?php }?>
    </tbody>
</table>
<div><?php echo $records_info ?></div>
<div align="center" id="morepages"><?php echo $this->pagination->create_links();?></div>