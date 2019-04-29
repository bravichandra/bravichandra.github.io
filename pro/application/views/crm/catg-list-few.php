<?php if($catg_list){?><table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>
            <th class='no-border' width="30%">Name</th>
            <th class='no-border'>Description</th>
            <?php if($crmlite=='contact'){?>
            <th class='no-border' width="100px">Date Added</th>
            <th class='no-border' width="100px">Contacts</th>
            <?php }?>
            <th class='no-border' width="100px">Remove</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($catg_list as $crow)    {
                if($crmlite=='contact') $total_records = $this->crm->get_category_records($crow->id,$crow->section,'');?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/lists/view/<?php echo $crow->id;?>"><?php echo $crow->name;?></a></td>
            <td class='no-border'><?php echo $crow->info;?></td>
            <?php if($crmlite=='contact'){?>
            <td class='no-border'><?php echo ((int)$crow->cdate?date("m/d/Y",strtotime($crow->cdate)):date("m/d/Y",strtotime($record['create_date'])));?></td>
            <td class='no-border'><?php echo number_format($total_records)?></td>
            <?php }?>
            <td><a href="<?php echo current_url(); ?>/<?php echo $crow->id;?>">Remove</a></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>