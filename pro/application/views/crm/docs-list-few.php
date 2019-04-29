<?php if($docs_list){?>
<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>  
            <th class='no-border' style="width:150px;">Action</th>
            <th class='no-border' style="width:150px;" >Title</th>
			<th class='no-border' style="width:150px;"  >Document Link</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($docs_list as $crow)    {?>
        <tr>
            <td class='no-border'>
                <a href="<?php echo base_url(); ?>crm/docs/edit/<?php echo $crow->notes_id;?>">Edit</a> | 
                <a href="<?php echo base_url(); ?>crm/docs/delete/<?php echo $crow->notes_id;?>" onclick="if(!confirm('Are you sure you want to delete this document?')) return false;">Delete</a>
            </td>
            <td class='no-border'><?php echo $crow->notes_title;?></td>
			<td class='no-border' ><?php if($crow->upload) echo '<a href="'.base_url().'upload/'.$crow->upload.'" target="_blank">View Document </a>';?></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>