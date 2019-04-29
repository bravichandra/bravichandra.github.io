<?php if($emails_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <th class='no-border' style="width:80px;">Action</th>
            <th class='no-border' width="30%">Subject</th>
            <th class='no-border'>Email Template</th>
			<th class='no-border' style="width:100px;">Record Owner</th>
            <th class='no-border' style="width:130px;">Date Scheduled</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($emails_list as $crow)    {?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/emails/delete/<?php echo $crow->sch_id;?>" onclick="if(!confirm('Are you sure you want to delete this email?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/emails/view/<?php echo $crow->sch_id;?>"><?php echo $crow->sch_subject;?></a></td>
            <td class='no-border'><?php echo $crow->sch_etname;?></td>
			<td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            <td class='no-border'><?php echo date("m/d/Y h:i A",strtotime($crow->sch_date)+date("Z"))?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>