<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>	    <!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>

<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">
	<!-- Breadcrumbs line -->   
	<?php  
       if($d_page == 15 || $d_page == 16){
		
			$this->load->view('common/empty_nav');
	   }else{
			$this->load->view('common/drop_menu');
	   }
	?>   	
	<div class="wrapper">
		<!-- Start Receiver Shared Data Listing if available -->							
		<?php $msg = $this->session->flashdata('session_msg'); ?>
		<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?>                   					    		
		<div class="fluid">
		   <div class="grid12">
				<div class="grid6">
					<div class="widget">
						<?php if(isset($teammateid)): ?>																	   								
						<?php // $detail = $this->home->getDetailForManagementListing($teammateid, 'receiver'); ?>																		 		
							<div class="body">
								<h2 class="pt10">Campaign Profile</h2>
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<?php $all_campaign = $this->campaign->getAllCampaignWithUserID($teammateid); ?> 												
										
										<?php if (!empty($all_campaign)): ?>						                        		
											<?php foreach ($all_campaign as $single_campaign): ?>															
													<tr>
														<td class="no-border">
														<h6><span ><?php echo $single_campaign->campaign_name; ?></span></h6>
														</td>
														<td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolderCampaign('<?php echo $single_campaign->campaign_id; ?>','<?php echo $single_campaign->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>													
														<!-- <td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolderCampaign('<?php // echo $single_campaign->session_id; ?>','<?php // echo $single_campaign->session_name; ?>','<?php // echo $single_campaign->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td> -->
																							                            
													</tr>
																	                            
											<?php endforeach; ?>						                            
										<?php endif; ?>						                        
									</tbody>
								</table>
							</div>                   			        		
						<?php endif; ?>							
					</div>
					
				</div><br clear="all" />
				
				<div class="grid6" style="margin-left:0px;">
					<div class="widget">
						<?php if(isset($teammateid)): ?>													
						<?php // $detail = $this->home->getDetailForManagementListing($teammateid, 'receiver'); ?>																		 		
							<div class="body">
								<h2 class="pt10">Company Profiles</h2>
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<?php $all_user_company = $this->campaign->getCompanyProfileWithUserID($teammateid); ?> 												
										<?php if (!empty($all_user_company)): ?>						                        		
										<?php foreach ($all_user_company as $single_company): ?>						                        								                        			
																										
											<tr>
												<td class="no-border">
													<h6><span><?php echo $single_company->company_name; ?></span></h6>
												</td>
												<?php if ($single_company->status == '0'): ?>									                                	
												
												<td  width="20px;" class="no-border"><a href="javascript:void(0);" onclick="saveToMyFolderCompany('<?php echo $single_company->company_id; ?>','<?php echo $single_company->company_name; ?>','<?php echo $single_company->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
												<?php endif; ?>									                               
												<?php if ($single_company->status == '1'): ?>									                                											
													<td  width="20px;" class="no-border"><a href="javascript:void(0);" onclick="saveToMyFolderCompany('<?php echo $single_company->company_id; ?>','<?php echo $single_company->company_name; ?>','<?php echo $single_company->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
												<?php endif; ?>									                            
											</tr>
																	                            
											<?php endforeach; ?>						                            
										<?php endif; ?>						                        
									</tbody>
								</table>
							</div>                   			        		
						<?php endif; ?>					        							   							
					</div>
					
					<div class="widget">
					<?php if(isset($teammateid)): ?>								
					<?php // $detail = $this->home->getDetailForManagementListing($teammateid, 'receiver'); ?>																		 		
						<div class="body">
							<h2 class="pt10"><?php echo "Name Drop Examples" ?></h2>
							<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
								<tbody>
									<?php $all_credibility = $this->campaign->getAllNameDropByUserID($teammateid); ?> 												
									<?php if (!empty($all_credibility)): ?>						                        		
										<?php foreach ($all_credibility as $single_credibility): ?>																											
											<tr>
												<td class="no-border">
												<h6><span class=""><?php echo $single_credibility->credibility_name; ?></span></h6>
												</td>
												<?php if ($single_credibility->status == '0'): ?>									                                	
													<!-- <td  width="20px;" class="no-border"><a <?php if ($is_paid) { ?> href="#_" onclick="launchSession('<?php echo $single_credibility->c_id; ?>','yes');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="launch" value="Launch" /></a></td> -->
													<td  width="20px;" class="no-border"><a href="javascript:void(0)" onclick="saveToMyFolderCredibility('<?php echo $single_credibility->c_id; ?>','<?php echo $single_credibility->credibility_name; ?>','<?php echo $single_credibility->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
												<?php endif; ?>									                               
												<?php if ($single_credibility->status == '1'): ?>												
													<td  width="20px;" class="no-border"><a href="javascript:void(0);" onclick="saveToMyFolderCredibility('<?php echo $single_credibility->c_id; ?>','<?php echo $single_credibility->credibility_name; ?>','<?php echo $single_credibility->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
												<?php endif; ?>									                            
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
						
	<!-- End Receiver Shared Data Listing if available -->						
	</div>
	<!-- Start Search for a Team Member Form -->						    
    																		      
</div>
<!-- Main content ends -->
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
		}
	});
}
</script>
<?php $this->load->view('common/footer'); ?>