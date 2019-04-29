<table style='background: none repeat scroll 0 0 #E6E6E6; width:100%' class='tDefault dsTable'>
    <thead>
        <tr>
            <th class='no-border'>Name</th>
        </tr>
    </thead>
    <tbody>    
        <?php foreach($sharedUsers as $crow)    {?>
        <tr>
            <td class='no-border'><a href="javascript:void(0);" data_id="<?php echo $crow->user_id;?>" onclick="setLookup(this);"><?php echo ucfirst($crow->usrname);?></td>
        </tr>
        <?php }?>
    </tbody>
</table>