<?php 
//Mailchimp
if(isset($mailchimp_error)) echo '<div class="crm-error"><b>'.$mailchimp_error.'</b></div>';
if(isset($mailchimp_ok)) {?>
<table cellpadding="0" cellspacing="0" border="0" style="margin: 6px 30px;">  
    <tr>
        <th class="one" width="120px">MailChimp Lists</th>
        <td class="two" width="120px">
            <select id="mc_list_id">
                <option value="">Select List</option>
                <?php echo (isset($mc_lists)?$mc_lists:'');?>
            </select>            
        </td>
        <td class="one" width="120px">&nbsp;<input type="button" class="buttonM bBlue" onclick="mailchimp_add_contact()" value="Add to List" style="height: 27px;padding: 5px 15px;" /></td>
        <td><div class="loader"></div></td>
    </tr>
</table>
<?php if(isset($mc_contact_list) && $mc_contact_list){?>
<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault crmtab'>
    <thead>
        <tr>
            <th class='no-border'>Name</th>
            <th class='no-border' width="100px">Date Added</th>
            <th class='no-border' width="100px">Contacts</th>            
            <th class='no-border' width="100px">Remove</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($mc_contact_list as $crow)    {?>
        <tr>
            <td class='no-border'><a href="<?php echo base_url(); ?>crm/lists/view/<?php echo $crow->id;?>"><?php echo ucfirst($crow['name']);?></a></td>
            <td class='no-border'><?php echo $crow['contact_date'];?></td>
            <td class='no-border'><?php echo $crow['count'];?></td>
            <td><a href="javascript:void(0);" onclick="mailchimp_delete_contact('<?php echo $crow['listid'];?>')">Remove</a></td>
        </tr>
        <?php }?>
    </tbody>
</table><?php }?>
<?php }?>