<?php if($notes_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <th class='no-border' style="width:80px;">Action</th>
            <th class='no-border'>Title</th>
            <th class='no-border' style="width:150px;"  >Document Link</th>
            <th class='no-border' style="width:100px;">Record Owner</th>
            <th class='no-border' style="width:130px;">Date Modified</th>           
        </tr>
    </thead>
    <tbody>
        <?php foreach($notes_list as $crow)    {?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/notes/edit/<?php echo $crow->notes_id;?>">Edit</a> | <a href="<?php echo base_url(); ?>crm/notes/delete/<?php echo $crow->notes_id;?>" onclick="if(!confirm('Are you sure you want to delete this notes?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/notes/view/<?php echo $crow->notes_id;?>"><?php echo $crow->notes_title;?></a></td>
            <td class='no-border' ><?php if($crow->upload) echo '<a href="'.base_url().'upload/'.$crow->upload.'" target="_blank">View Document </a>';?></td>
            <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            <td class='no-border'><?php echo date("m/d/Y",strtotime($crow->notes_modify))?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>