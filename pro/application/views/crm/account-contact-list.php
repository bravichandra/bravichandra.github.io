<?php if($contact_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <th class='no-border'>Action</th>
            <th class='no-border'>Contact Name</th>
            <th class='no-border'>Record Owner</th>
            <th class='no-border'>Title</th>
            <th class='no-border'>Email</th>
            <th class='no-border'>Phone</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($contact_list as $crow)    {?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url("crm/contacts/edit/".$crow->contact_id);?>">Edit</a> | <a href="<?php echo base_url("crm/contacts/delete/".$crow->contact_id);?>" onclick="if(!confirm('Are you sure you want to delete this contact?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo ucfirst($crow->user_first." ".$crow->user_last);?></a></td>
   			<td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            <td class='no-border'><?php echo $crow->user_title;?></td>
            <td class='no-border'><?php if($crow->email) echo '<a href="mailto:'.$crow->email.'">'.$crow->email.'</a>';?></td>
            <td class='no-border'><?php echo $crow->phone;?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>