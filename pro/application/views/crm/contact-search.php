<table style='background: none repeat scroll 0 0 #E6E6E6; width:100%' class='tDefault dsTable'>
    <thead>
        <tr>
            <th class='no-border'>Name</th>
            <th class='no-border'>Account Name</th>
            <th class='no-border'>Email Address</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($contacts as $crow)    {?>
        <tr>
            <td class='no-border'><a href="javascript:void(0);" data_uns="<?php echo $crow->unsubscribed;?>" data_id="<?php echo $crow->contact_id;?>" onclick="setLookup(this);"><?php echo trim($crow->user_first.' '.$crow->user_last);?></td>
            <td class='no-border'><?php echo $crow->account_name;?></td>
            <td class='no-border'><?php if($crow->email) echo '<a href="mailto:'.$crow->email.'">'.$crow->email.'</a>';?></td>
        </tr>
        <?php }?>
    </tbody>
</table>