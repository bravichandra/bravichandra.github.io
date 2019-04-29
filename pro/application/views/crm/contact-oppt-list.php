<?php if($oppty_list){?>
<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>                        
            <th class='no-border'>Action</th>
            <th class='no-border'>Opportunity Name</th>
            <th class='no-border'>Record Owner</th>
            <th class='no-border'>Stage</th>
            <th class='no-border'>Amount</th>
            <th class='no-border'>Close Date</th>            
        </tr>
    </thead>
    <tbody>
        <?php foreach($oppty_list as $crow)    {?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url("crm/opportunities/edit/".$crow->oppt_id);?>">Edit</a> | <a href="<?php echo base_url("crm/opportunities/delete/".$crow->oppt_id);?>" onclick="if(!confirm('Are you sure you want to delete this opportunity?')) return false;">Delete</a></td>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/opportunities/view/<?php echo $crow->oppt_id;?>"><?php echo $crow->oppt_name;?></a></td>
            <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            <td class='no-border'><?php echo $crow->stage;?></td>
            <td class='no-border'><?php if($crow->amount)echo "$".number_format($crow->amount);?></td>
            <td class='no-border'><?php if($crow->close_date)echo date("m/d/Y",strtotime($crow->close_date))?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<?php }?>