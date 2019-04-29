<form method="post" action="<?php echo base_url('widget/forms/'.$listrow['id']);?>" id="ssFrmList">
    <input type="hidden" name="clfaction" value="saveListform" />
    
<table cellpadding="4" cellspacing="4" border="0" class="contact-edit" align="center">
    <?php if($listrow['formtitle']){?>
    <tr>
        <th class="title" style="font-size: 20px;font-weight: bold;" colspan="2"><?php echo $listrow['formtitle'];?></th>
    </tr>
    <?php }?>
    <?php if($listrow['forminfo']){?>
    <tr>
        <td class="forminfo" colspan="2"><?php echo $listrow['forminfo'];?></td>
    </tr>
    <?php }?>
    <tr>
        <td class="title" colspan="2" id="ssFormResult" style="color: red;text-align: center;"><?php if(isset($er) && $er) echo $er?></th>
    </tr>
    <?php if(isset($listrow['form']) && $listrow['form'])
        foreach ($listrow['form'] as $value) {
        ?>
    <tr>
        <th class="one" width="200px"><?php echo $contact_fields[$value];?></th>
        <td class="two">
            <?php 
                if($value=="user_prefix" || $value=="lead_source" || $value=="account_type" || $value=="industry" || $value=="rating") {
                    $listArr = array();
                    if($value=="user_prefix") $listArr = $salutation; 
                    else if($value=="lead_source") $listArr = $lead;
                    else if($value=="account_type") $listArr = $account_types;
                    else if($value=="industry") $listArr = $industries;
                    else if($value=="rating") $listArr = $ratings;
            ?>
            <select name="list[<?php echo $value;?>]" class="ssforminput">
                <option value="">None</option>
                <?php  foreach($listArr as $sval){ ?>
                <option value="<?php echo $sval ?>" <?php if(isset($list[$value]) && $list[$value]==$sval) echo ' selected="selected"';?>><?php echo $sval; ?></option>
                <?php }  ?>
            </select>
            <?php } else {?>
            <input type="text" value="<?php if(isset($list[$value])) echo $list[$value];?>" name="list[<?php echo $value;?>]" class="ssforminput" />
            <?php }?>
        </td>                
    </tr>
    <?php }?>

    <tr>
        <td colspan="2" align="center">
            <input type="submit" class="buttonM bBlue" name="form_submit" value="Submit" />
        </td>
    </tr>

</table>
</form>