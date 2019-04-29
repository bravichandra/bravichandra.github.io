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
		//$this->load->view('common/precamp_nav');
		$this->load->view('common/empty_nav');
	?>	
	<div class="wrapper">
		<div style="text-align: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
        <table cellpadding="0" cellspacing="0" style="width:100%;" border="0" >
			<tr>
            	<td class="title" colspan="2">
                	<div class="quatabs">
                		<div  <?php echo($tb_insurance ? '':'class="active"');?>><a href="<?php echo base_url(); ?>folder/prebuilt-campaigns"  >General</a></div>
                        <div <?php echo($tb_insurance ? 'class="active"' : '');?>><a href="<?php echo base_url(); ?>folder/prebuilt-campaigns?insurance" >Insurance</a></div>
                	</div>
                </td>
            </tr>
        </table>
		<!-- Start Receiver Shared Data Listing if available -->							
		<?php $msg = $this->session->flashdata('session_msg'); ?>
		<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?>    
        <!--<h3 style="margin-top:30px;color: black" id="BusinessHeading">
            <span style="color: #B30814;">Prebuilt Campaigns</span> 					   
        </h3> -->              					    		
		<div class="fluid">
		   <div class="grid12">
				
				
				<div class="grid6">
					<div class="widget">
						<?php if(isset($teammateid)): ?>																	   								
						<?php // $detail = $this->home->getDetailForManagementListing($teammateid, 'receiver'); ?>																		 		
							<div class="body">
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
														<td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolderCampaign('<?php echo $single_campaign->campaign_id; ?>','<?php echo $single_campaign->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Select" /></a></td>													
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
			window.location.href = BASE_URL + 'folder/campaigns';
		}
	});
}
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/-OexXFgg_KA" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
$( document ).ready(function() {
    $('.help_dialog').dialog({
        autoOpen: false,
        height: 400,
        width: 600,
        buttons: {
            "Close": function () {
                $('.video').html('');
                $(this).dialog("close");
                
            }
        }    
    });
    
    // Invitation Dialog Link
    $('.dialog_help').click(function (e) {
         $('.video').html(iframe);
         $('.help_dialog').dialog('open');
         
        return false;
    });
    
    $('.ui-icon-closethick').click(function (e) {
         $('.video').html('');
          $('.help_dialog').dialog('close');
        return false;
    });
    
});	
</script>	
<div class="help_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video</title>
</head>

<body>
 <div class="video">

 </div>
</body>
</html></div>
<?php $this->load->view('common/footer'); ?>