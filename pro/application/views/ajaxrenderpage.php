	<h3 style="margin-top:30px;color: black;">
		<span style="color: #B30814;">Campaign Coordinate #2 – Target Audience</span>
	</h3>
				
	<div class="widget tableTabs">
		
		<div class="tab_container">
			<div id="ttab1" class="tab_content">
				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
					<tbody>
						<tr id="TechTR" class="TechTrClass TechTR_<?php echo $target_audiance->product_data_id;?>">
								<td  style="width: 70%;"> What is the title or role for the ideal individual that you want to direct this campaign at? 
										<br/> <br/> Examples: VP of IT, HR manager, Home owner, etc. </td>
								
								<td class="no-border" width="20%">
								<div class="grid5">
									<textarea class="validate[required] dynamicTxt txttobech_<?php echo $target_audiance->product_data_id;?>" style="width:350px;" name="tpd_<?php echo $target_audiance->product_id;?>[target-audience][<?php echo $target_audiance->product_data_id;?>][]" id="V<?php echo $target_audiance->product_id;?>_<?php echo $target_audiance->product_data_id;?>" cols="" rows="" onkeyup="changetext(<?php echo $target_audiance->product_data_id; ?>)" ><?php echo (!empty($target_audiance->value) ? $target_audiance->value : NULL);?></textarea>
									<div align="center" class="TextColorH">Answer Checker</div>
									<div align="center">
									We want to sell <span class="dynamicFillTecArea TextColor"><?php echo $target_product_name->session_name ?></span> to <span class="change_id_<?php echo $target_audiance->product_data_id;?> TextColor"><?php echo (!empty($target_audiance->value) ? $target_audiance->value : NULL);?></span>.
									</div>
								</div>
								</td>
								<td class="no-border"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="widget tableTabs">
		<div class="tab_container">
			<div id="ttab1" class="tab_content">
				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
					<tbody>
						<tr>
							<td style="width: 70%;">What type of organization do you want to direct this campaign to?<br/><br/>Examples of organizations to target are businesses, small businesses, hospitals, IT departments, nonprofits, etc.<br/>
							</td>
							<td class="no-border">
							<textarea  class="validate[required] dynamicTxt txttobech_<?php echo $target_company->user_data_id;?>" style="width:350px;" name="tud_[users][<?php echo $target_company->user_data_id; ?>][]" id="vs" cols="" rows="" onkeyup="changetext(<?php echo $target_company->user_data_id; ?>)" ><?php echo isset($target_company->value) ?  $target_company->value : 'businesses';?></textarea>
								<div align="center" class="TextColorH">Answer Checker</div>
							<div align="center">
								We want to sell <span class=" TextColor "><?php  echo $target_product_name->session_name; ?></span> to <span class="change_id_<?php echo $target_company->user_data_id;?> TextColor"><?php echo (!empty($target_company->value) ? $target_company->value : NULL);?></span>. 
							</div>
							</td>
							<td class="no-border">
								<!-- <div id="5" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div> -->
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	
	<div class="widget tableTabs">
		<div class="tab_container">
			<div id="ttab1" class="tab_content">
				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
					<tbody>
						<tr id="TechTR<?php echo '';?>" class="TechTrClass TechTR_<?php echo '';?>">
								
								
								<td style="width: 70%;" > Do you want to direct this campaign at <span class="change_id_<?php echo $target_audiance->product_data_id;?> TextColor"><?php echo $target_audiance->value; ?></span> or <span class="change_id_<?php echo $target_company->user_data_id;?> TextColor"><?php echo $target_company->value; ?></span> ? </td>
								
								
								<!-- <td class="no-border" style="width: 38em;">a technical improvement (systems, processes, people) that it provides is that it helps to</td> -->
								<td class="no-border" width="20%">
								<div class="grid5">
									<div align="center" class="TextColorH">Select One</div>
									<!-- <textarea class="validate[required] dynamicTxt dynamicFillTec_<?php echo $direct_campaign->product_id;?> TechValues" style="width:350px;" name="tpd_<?php echo $direct_campaign->product_id;?>[direct_campaign][<?php echo $direct_campaign->product_data_id;?>][]" id="V<?php echo $direct_campaign->product_id;?>_<?php echo $direct_campaign->product_data_id;?>" cols="" rows="" onkeyup="TechdynamicText();"><?php echo (!empty($direct_campaign->value) ? $direct_campaign->value : NULL);?></textarea> -->
									
									<input onClick="changeLastAnsChecker(this)" type="radio" name="tpd_<?php echo $direct_campaign->product_id;?>[direct_campaign][<?php echo $direct_campaign->product_data_id;?>][]" value="individual"  <?php echo  ($direct_campaign->value == 'individual') ?  'checked ' : '' ; ?> />  <span class="change_id_<?php echo $target_audiance->product_data_id;?> TextColor"><?php echo $target_audiance->value; ?></span>
									<br/>
									<input onClick="changeLastAnsChecker(this)" type="radio" name="tpd_<?php echo $direct_campaign->product_id;?>[direct_campaign][<?php echo $direct_campaign->product_data_id;?>][]" value="organization"  <?php echo  ($direct_campaign->value == 'organization') ?  'checked ' : '' ; ?> /> <span class="change_id_<?php echo $target_company->user_data_id;?> TextColor"><?php echo $target_company->value; ?></span>
									
									
									<div align="center" class="TextColorH">Answer Checker</div>
									<div align="center">
										We want to sell 
										<span class="TextColor ">
											<?php  echo $target_product_name->session_name; ?>
										</span>  to 
										<span class="dynamicTxt_V<?php echo $direct_campaign->product_id;?>_<?php echo $direct_campaign->product_data_id;?> TextColor">
											
											<span id='individual' class="change_id_<?php echo $target_audiance->product_data_id;?>" style="display:<?php if($direct_campaign->value != 'individual') {echo 'none'; }?>" > <?php  {echo  $target_audiance->value ;}?></span>
											<span id='organization' class="change_id_<?php echo $target_company->user_data_id;?>" style="display:<?php if($direct_campaign->value != 'organization') {echo 'none';}?>" > <?php  { echo $target_company->value ;} ?></span>
											
										</span>.
									</div>
								</div>
								</td>
								<td class="no-border"></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" >
	
		function changeLastAnsChecker(obj){	
			var id = obj.value;
		    if(obj.checked){
				$('#individual').css('display','none');
				$('#organization').css('display','none');
				$('#'+id).css('display','inline');
			}
		}
	</script>
	