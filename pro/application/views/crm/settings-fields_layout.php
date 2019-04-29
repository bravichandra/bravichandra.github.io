<table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="margin-top: 0px;margin-bottom: 0px;" >
     <tbody>
	    <tr>
	       <td class="title" colspan="5">
    	<!--<th class="title" colspan="4">Fieds Layout
    		<input type="hidden" name="layout_action" id="layout_action" value="save" />
    	</th>-->
            <div class="quatabs">
                    <div class="active"><a href="javascript:void(0);" rel="box1">Contacts Fieds Layout</a>
                    <input type="hidden" name="layout_action" id="layout_action" value="save" /></div>
                    <div><a href="javascript:void(0);" rel="box2">Accounts Fieds Layout</a></div>
             </div>
            </td>
   		</tr>   
   </tbody>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="box1 tabbox contact-edit"  style="margin-top: 0px;margin-bottom: 0px;" >
	<?php
		$col=0;
		foreach($contact_fields as $lkey) {
			$val = $layout_fields[$lkey];
			$col++;
			if($col==1) echo '<tr>';
			?>
			<th class="one"><?php echo $val['label']?></th>
			<td class="two "><select name="fields[]"><option value="<?php echo $lkey?>">Change Field</option><?php echo $layout_field_options?></select></td>
			<?php
			if($col==3) {
				echo '<tr>';
				$col=0;
			}
		}
		if($layout_keys) 
		foreach($layout_keys as $lkey) {
			$val = $layout_fields[$lkey];
			$col++;
			if($col==1) echo '<tr>';
			?>
			<th class="one">Not Mapped</th>
			<td class="two "><select name="fields[]"><option value="">Change Field</option><?php echo $layout_field_options?></select></td>
			<?php
			if($col==3) {
				echo '<tr>';
				$col=0;
			}
		}
		if($col>0) echo '</tr>';
	?>
    <tr>
    <table cellpadding="0" cellspacing="0" border="0" class="box1 tabbox  contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px;" >

            <tr>
            	<td colspan="4" align="center">

                    <div class="fluid" style="margin-top:15px;">

                    	<span class="loader"></span>

                        <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" />
                     <input type="button" class="buttonM bRed" value="Reset" onclick="reset_contact_layout();" />
                        

                    </div>

                    <div style="text-align: left;padding-left: 10px;" class="esettings"></div>		

                </td>

            </tr>            

        </table>
        </tr>
</table>

<table cellpadding="0" cellspacing="0" border="0" class="box2 tabbox contact-edit"  style="display:none;margin-top: 0px;margin-bottom: 0px;" >
	<?php
		$col=0;
		foreach($account_fields as $lkey) {
			$val = $alayout_fields[$lkey];
			$col++;
			if($col==1) echo '<tr>';
			?>
			<th class="one"><?php echo $val['label']?></th>
			<td class="two "><select name="afields[]"><option value="<?php echo $lkey?>">Change Field</option><?php echo $alayout_field_options?></select></td>
			<?php
			if($col==3) {
				echo '<tr>';
				$col=0;
			}
		}
		if($alayout_keys) 
		foreach($alayout_keys as $lkey) {
			$val = $alayout_fields[$lkey];
			$col++;
			if($col==1) echo '<tr>';
			?>
			<th class="one">Not Mapped</th>
			<td class="two "><select name="afields[]"><option value="">Change Field</option><?php echo $alayout_field_options?></select></td>
			<?php
			if($col==3) {
				echo '<tr>';
				$col=0;
			}
		}
		if($col>0) echo '</tr>';
	?>
    <tr>
    <table cellpadding="0" cellspacing="0" border="0" class="box2 tabbox  contact-edit" id="settings" style="display:none;margin-top: 0px;margin-bottom: 0px;" >

            <tr>
            	<td colspan="4" align="center">

                    <div class="fluid" style="margin-top:15px;">

                    	<span class="loader"></span>

                        <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" />
                     <input type="button" class="buttonM bRed" value="Reset" onclick="reset_account_layout();" />
                        

                    </div>

                    <div style="text-align: left;padding-left: 10px;" class="esettings"></div>		

                </td>

            </tr>            

        </table>
        </tr>
</table>