<table cellpadding="0" cellspacing="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" width="100%" border="0" align="center" class="contact-list view">
	<tbody>
		<?php
			$col=0;
			foreach($account_fields as $lkey) {
				if(!isset($layout_fields[$lkey])) continue;
				if($val['type']=='custom') {
					//if(!isset($account_customField_values[$lkey])) continue;
					if(!isset($account_customField_values[$lkey])) $account_customField_values[$lkey]='';
				}
				$val = $layout_fields[$lkey];
				$col++;
				if($col==1) echo '<tr>';
				if($lkey=='description') {
					if($col==2) echo '<td colspan="4"></td>';
					if($col==3) echo '<td colspan="2"></td>';
					echo '</tr><tr>';
					$col=3;
				}
				?>
				<th class="one"><?php echo $val['label']?></th>
				<td <?php if($lkey=='share_user_title' || $lkey=='create_date' || $lkey=='modify_date') echo 'class="two"'; 
				else echo 'class="two edtable" data-field="'.$lkey.'"';
				if($lkey=="unsubscribed") echo ' style="color:#FF0000;"';
				if($lkey=='description') echo ' colspan="5"';
				?>><?php 
				//Target
				if($lkey=="target") echo '<input type="checkbox" id="target" disabled="disabled" '.($record[target]?' checked="checked"':'').' />';
				//Mailing address					
				else if($lkey=="billing") {
					$adr_mail=array_filter($record[billing]);
					unset($adr_mail['parent_id']);
					unset($adr_mail['adr_type']);
					unset($adr_mail['parent_type']); 
					echo implode(", ",$adr_mail);
				} 
				//Shipping Address
				else if($lkey=="shipping") {
					$adr_mail=array_filter($record[shipping]);
					unset($adr_mail['parent_id']);
					unset($adr_mail['adr_type']);
					unset($adr_mail['parent_type']); 
					echo implode(", ",$adr_mail);
				} 
				//Name
				//else if($lkey=="user_first") echo $record[user_prefix].' '.ucfirst($record[user_first].' '.$record[user_last]);
				//Linkedin
				else if($lkey=="linkedin") {
					if($record[$lkey]) echo '<a href="'.$record[$lkey].'" target="_blank">View Profile</a>';
				} 
				//Website
				else if($lkey=="website") {
				    if($record[website]) echo '<a target="_blank" href="'.(substr($record[website],0,4)<>"http"?'http://':'').$record[website].'">'.$record[website].'</a>';
				} 
				//Phone
				else if($lkey=="phone" || $lkey=="mobile" || $lkey=="asst_phone" || $lkey=="other_phone") {
					if($record[$lkey]) echo '<a href="tel:'.$record[$lkey].'">'.$record[$lkey].'</a>';
				}
				//Annual Revenue
				else if($lkey=="revenue") {
					//if($record[$lkey]) echo '$'.$record[$lkey];
					if($record[$lkey]) echo number_format($record[$lkey]);
				}
				//Email
				else if($lkey=="email") {
					if($record[$lkey]) echo '<a href="mailto:'.$record[$lkey].'">'.$record[$lkey].'</a>';
				}
				//Parent Account
				else if($lkey=="account_parent") {
					if($record[$lkey]) echo '<a href="'.base_url().'crm/accounts/view/'.$record[account_parent].'">'.ucfirst($record[account_title]).'</a>';
				}
				
				//Dates
				else if($lkey=="create_date" || $lkey=="modify_date") echo date("m/d/Y",strtotime($record[$lkey]));
				//Description
				else if($lkey=="description") echo str_replace("\n","<br>",$record[$lkey]);
				//Custom Field
				else if($val['type']=='custom') {
					$cval = $account_customField_values[$lkey];
					echo '<span id="'.$lkey.'_hide" style="display:none;">';
					if($val['num']=='Y') echo number_format(str_replace(",","",$cval['cval'])); else echo $cval['cval'];
					echo '</span>';
					if($val['num']=='Y') echo number_format(str_replace(",","",$cval['cval'])); 
					else {
						if(strlen($cval['cval'])>15){
							echo substr($cval['cval'],0,15);?>
							<input type="button" value="See More" onclick="view_column('<?php echo $lkey; ?>');" />
						<?php } else echo $cval['cval'];
					}					
				}
				//Default
				else echo ucfirst($record[$lkey]);
				?></td>
				<?php
				if($col==3) {
					echo '<tr>';
					$col=0;
				}
			}
			if($col>0) echo '</tr>';
		?>
	</tbody>
</table>