<!-- Tab links -->
<div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'General')">General</button>
  <button class="tablinks" onclick="openCity(event, 'Insurance')">Insurance</button>
</div>

<!-- Tab content -->
<div id="General" class="tabcontent" style="display:block;">
  <div class="fluid">
		   <div class="grid12">				
				<div class="">
					<div class="widget">
						<?php if(isset($teammateid)): ?>																	   								
						<?php // $detail = $this->home->getDetailForManagementListing($teammateid, 'receiver'); ?>																		 		
							<div class="body" style="border:0px !important; background:#EEE; padding:8px;">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<?php $all_campaign = $this->campaign->getAllCampaignWithUserID($teammateid); ?> 												
										
										<?php if (!empty($all_campaign)): ?>						                        		
											<?php foreach ($all_campaign as $single_campaign): ?>															
													<tr>
														<td class="no-border">
														<h6><span ><?php echo $single_campaign->campaign_name; ?></span></h6>
														</td>
                                                        <?php if($teammateid<>$cuserid){?>
														<td  width="20px;" class="no-border"><a href="#_" onClick="saveToMyFolderCampaign('<?php echo $single_campaign->campaign_id; ?>','<?php echo $single_campaign->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Select" /></a></td>													
														<?php }?>							                            
													</tr>
																	                            
											<?php endforeach; ?>						                            
										<?php endif; ?>						                        
									</tbody>
								</table>
							</div>                   			        		
						<?php endif; ?>							
					</div>
				</div>						
			</div>
		</div>
</div>

<div id="Insurance" class="tabcontent">
	 <div class="fluid">
		   <div class="grid12">				
				<div class="">
					<div class="widget">
						<?php if(isset($teammateid1)): ?>																	   								
						<?php // $detail = $this->home->getDetailForManagementListing($teammateid, 'receiver'); ?>																		 		
							<div class="body" style="border:0px !important; background:#EEE;  padding:8px;">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<?php $all_campaign = $this->campaign->getAllCampaignWithUserID($teammateid1); ?> 												
										
										<?php if (!empty($all_campaign)): ?>						                        		
											<?php foreach ($all_campaign as $single_campaign): ?>															
													<tr>
														<td class="no-border">
														<h6><span ><?php echo $single_campaign->campaign_name; ?></span></h6>
														</td>
                                                        <?php if($teammateid<>$cuserid){?>
														<td  width="20px;" class="no-border"><a href="#_" onClick="saveToMyFolderCampaign('<?php echo $single_campaign->campaign_id; ?>','<?php echo $single_campaign->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Select" /></a></td>													
														<?php }?>							                            
													</tr>
																	                            
											<?php endforeach; ?>						                            
										<?php endif; ?>						                        
									</tbody>
								</table>
							</div>                   			        		
						<?php endif; ?>							
					</div>
				</div>						
			</div>
		</div>
</div>
<style type="text/css">
		/* Style the tab */
		.tab {
			overflow: hidden;
			border: 0px solid #ccc;
			background-color: #f1f1f1;
		}
		
		/* Style the buttons that are used to open the tab content */
		.tab button {
			background-color: inherit;
			float: left;
			border: none;
			outline: none;
			cursor: pointer;
			padding: 14px 16px;
			transition: 0.3s;
			border: 1px solid #424242;
			padding: 8px;
			background: #757575;
			font-weight: bold;
			border-radius: 10px 10px 0% 0%;
			border-bottom: 0px;
			font-size:13px;
			color:#FFFFFF;
		}
		
		/* Change background color of buttons on hover */
		.tab button:hover {
			    background-color: #DF0000;
				border: 1px solid #424242;
				border-radius: 10px 10px 0% 0%;
				border-bottom: 0px;
		}
		
		/* Create an active/current tablink class */
		.tab button.active {
			    background-color: #DF0000;
				border: 1px solid #424242;
				border-radius: 10px 10px 0% 0%;
				border-bottom: 0px;
				font-size:13px;
				color:#FFFFFF;
				font-weight:bold;
		}
		
		/* Style the tab content */
		.tabcontent {
			display: none;
			padding: 0px;
			border: 0px solid #ccc;
			border-top: none;
		}
</style>
<script type="text/javascript">
		function openCity(evt, cityName) {
			// Declare all variables
			var i, tabcontent, tablinks;
		
			// Get all elements with class="tabcontent" and hide them
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
		
			// Get all elements with class="tablinks" and remove the class "active"
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
		
			// Show the current tab, and add an "active" class to the button that opened the tab
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}
</script>

<script>
function saveToMyFolderCompany(companyid,companyname,user_id)
{

	$.ajax({
		type : 'POST',
		url : '<?php echo base_url()?>campaign/copycompany',
		data: 'company_id='+companyid+'&company_name='+companyname+'&user_id='+user_id,
		cache: false,
		dataType: 'json',
		success: function(responce)
		{
			console.log(responce);
			location.reload(true);
		}
	});
}

function saveToMyFolderProduct(productid,userId)
{
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/copyProductToMyFolder/',
		  data: 'product_id='+productid+'&user_id='+userId,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
			// window.location.href = BASE_URL + 'folder/team-folder';
			location.reload(true);
		  }
		});
}
/**
 *  Copy all campaign data to current user profile.
 */
function saveToMyFolderCampaign(campaign_id,userId)
{
    // return ;
	$.ajax({
		type: "POST",
		url: BASE_URL + 'campaign/copyCampaignToMyFolder/',
		data: 'campaign_id='+campaign_id+'&user_id='+userId,
		cache: false,
		dataType: 'json',
		success: function(response)
		{
			// window.location.href = BASE_URL + 'folder/team-folder';
			location.reload(true);
			window.location.href = BASE_URL + 'folder/campaigns';
		}
	});
}	
</script>	