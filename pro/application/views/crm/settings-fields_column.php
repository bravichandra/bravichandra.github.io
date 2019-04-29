<table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="margin-top: 0px;margin-bottom: 0px; width:100%;" >
     <tbody>
	    <tr>
	       <td class="title" colspan="5">
              <div class="quatabs">
                    <div class="active"><a href="javascript:void(0);" rel="box1">Contacts List Pages</a>
                    <input type="hidden" name="layout_action" id="layout_action" value="save" /></div>
                    <div><a href="javascript:void(0);" rel="box2">Accounts List Pages</a></div>
              </div>
            </td>
   		</tr>   
   </tbody>
</table>
<style type="text/css">
	div.add-column .col-sm-3
	{
		float:left !important;
	}
	div.add-column .col-sm-3.one {
		width: 45%;
		white-space: pre;
		word-break: normal;
		margin-right: 10px;
		margin-bottom: 8px;
	}
</style>
<table cellpadding="0" cellspacing="0" border="0" class="box1 tabbox contact-edit"  style="margin-top: 0px;margin-bottom: 0px;" >	
      <tr>
    	<td>
        	<div class="col-sm-12 edit-columns">
                <div class="cadd-column add-column">
                <?php
                    $i=0;
                    foreach($contact_fields as $lkey) {
                        //echo '<pre>'; print_r($lkey); echo '</pre>';
                        $val = $layout_fields[$lkey];
                        if($lkey=='no_mapping') $label = 'Not Mapped';
                        else $label = $val['label'];
                        ?>
                        <div class="col-sm-3 one A<?php echo $col; ?>"><?php echo $label; ?></div>
                        <div class="col-sm-3 two">
                            <input type="hidden" name="position[]" value="<?php echo $col; ?>" />
                            <select name="fields[]" class="tbcol">
                            <option value="<?php echo $lkey?>">Change Field</option>
                            <option value="no_mapping">Not Mapped</option>
                            <?php echo $layout_field_options?>
                            </select>
                        </div>
                        <?php 
                    }
                ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
    	<td>
            <table cellpadding="0" cellspacing="0" border="0" class="box1 tabbox  contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100%;">        
                <tr>
                    <td colspan="4" align="center">
                        <div class="fluid" style="margin-top:15px;">
                            <span class="loader"></span>
                            <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" />
                            <input type="button" class="buttonM bRed" value="Reset" onclick="reset_contact_layout();" />
                           <input type="button" class="buttonM bRed" value="Add" onclick="add_contact_layout();" />     
                        </div>
                        <div style="text-align: left;padding-left: 10px;" class="esettings"></div>	
                    </td>
                </tr>
            </table>
       </td>
  </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" class="box2 tabbox contact-edit"  style="margin-top: 0px;margin-bottom: 0px;width:100%; display:none;">
    <tr>
    	<td>        	
            <div class="col-sm-12 edit-columns">
                <div class="acadd-column add-column">
                <?php
                    $i=0;
                    foreach($account_fields as $lkey) {
                        $val = $alayout_fields[$lkey];
                        if($lkey=='no_mapping') $label = 'Not Mapped';
                        else $label = $val['label'];
                        ?>
                        <div class="col-sm-3 one A<?php echo $col; ?>"><?php echo $label; ?></div>
                        <div class="col-sm-3 two">
                            <input type="hidden" name="position[]" value="<?php echo $col; ?>" />
                            <select name="afields[]" class="tbcol">
                            <option value="<?php echo $lkey?>">Change Field</option>
                            <option value="no_mapping">Not Mapped</option>
                            <?php echo $alayout_field_options?>
                            </select>
                        </div>
                        <?php 
                    }
                ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
    	<td>
            <table cellpadding="0" cellspacing="0" border="0" class="box2 tabbox  contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px;width:100%;" >
                    <tr>
                        <td colspan="4" align="center">
                            <div class="fluid" style="margin-top:15px;">    
                                <span class="loader"></span>    
                                <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" />
                                <input type="button" class="buttonM bRed" value="Reset" onclick="reset_account_layout();" />
                                <input type="button" class="buttonM bRed" value="Add" onclick="add_account_layout();" />     
                            </div>    
                            <div style="text-align: left;padding-left: 10px;" class="esettings"></div>
                        </td>
                    </tr>   
              </table>
            </td>
        </tr>
</table>