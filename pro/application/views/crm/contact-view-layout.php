<table cellpadding="0" cellspacing="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" width="100%" border="0" align="center" class="contact-list view">
	<tbody>
		<?php
			$col=0;
			foreach($contact_fields as $lkey) {
				if(!isset($layout_fields[$lkey])) continue;
				if($val['type']=='custom') {
					//if(!isset($contact_customField_values[$lkey])) continue;
					if(!isset($contact_customField_values[$lkey])) $contact_customField_values[$lkey]='';
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
				else if($lkey=="address") {
					$adr_mail=array_filter($record[amail]);
					unset($adr_mail['parent_id']);
					unset($adr_mail['adr_type']);
					unset($adr_mail['parent_type']); 
					echo implode(", ",$adr_mail);
				} 
				//Name
				else if($lkey=="user_first") echo $record[user_prefix].' '.ucfirst($record[user_first].' '.$record[user_last]);
				//Linkedin
				else if($lkey=="linkedin") {
					if($record[$lkey]) echo '<a href="'.$record[$lkey].'" target="_blank">View Profile</a>';
				} 
				//Website
				else if($lkey=="website") {
					/*if($record[$lkey]) echo '<a href="'.$record[$lkey].'" target="_blank">'.$record[$lkey].'</a>';*/					
					if($record[$lkey]) {
						$URL = $record[$lkey];
						/*if(strpos($record[$lkey], "http://")) $URL = $URL;
						else $URL = "http://$URL";
						 echo '<a href="'.$URL.'" target="_blank">'.$record[$lkey].'</a>';*/
						 echo '<a href="'.(substr($URL,0,4)<>"http"?'http://':'').$URL.'" target="_blank">'.$URL.'</a>';	
					}
				} 
				//Phone
				else if($lkey=="phone" || $lkey=="mobile" || $lkey=="asst_phone" || $lkey=="other_phone") {
					if($record[$lkey]) echo '<a href="tel:'.$record[$lkey].'">'.$record[$lkey].'</a>';
				}
				//Email
				else if($lkey=="email") {
					if($record[$lkey]) echo '<a href="mailto:'.$record[$lkey].'">'.$record[$lkey].'</a>';
				}
				//Account
				else if($lkey=="account_id") {
					if($record[$lkey]) echo '<a href="'.base_url().'crm/accounts/view/'.$record[account_id].'">'.ucfirst($record[account_title]).'</a>';
				}
				//Reports To
				else if($lkey=="report_id") echo $record[report_title];
				//Subscribe Status
				else if($lkey=="unsubscribed") {
					if($record[$lkey]) echo 'Unsubscribed';
				}
				//Dates
				else if($lkey=="create_date" || $lkey=="modify_date") echo date("m/d/Y",strtotime($record[$lkey]));
				//Description
				else if($lkey=="description") echo str_replace("\n","<br>",$record[$lkey]);
				//Custom Field
				else if($val['type']=='custom') {
					$cval = $contact_customField_values[$lkey];
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