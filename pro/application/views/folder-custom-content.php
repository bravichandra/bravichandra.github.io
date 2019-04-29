<!-- Main content -->	
<div class="wrapper">

	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 		
    
	<div class="fluid">
    	<div class="myfolder">
        	<div class="box">
            	<div class="bxtitle">
	            	<h3>Create Product Profile</h3>                
                </div>
                <div class="bxlink">
            		<a href="<?php echo base_url(); ?>folder/product-profile" class="buttonM bRed">Go Here</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Campaign</h3></div>
                <div class="bxlink">                
            	<a href="<?php echo base_url(); ?>folder/campaigns" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Company Profile</h3></div>
                <div class="bxlink">
            	<a href="<?php echo base_url(); ?>folder/company-profiles" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Name Drop</h3></div>
                <div class="bxlink">
            	<a href="<?php echo base_url(); ?>folder/name-drop-examples" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Question Trees</h3></div>
                <div class="bxlink">
            	<a href="<?php echo base_url(); ?>folder/question-trees" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box active">
            	<div class="bxtitle"><h3>Customize Your Scripts</h3></div>
                <div class="bxlink">
            	<b>You are Here</b></div>
            </div>
        </div>
	 <div class="grid12">
	  <div class="grid10">
		
		
    
    <!--  for campaign custom contents  -->
		<div class="widget">
			<div class="body">
				<h2 class="pt10">Custom Content</h2>
				<br>						
				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
					<tbody>
						<?php if(!empty($custom_contents)): ?>
							<?php foreach ($custom_contents as $singlecampaign): ?>
								<?php //if ($sessions->status != '2'): ?>															
									<tr>
										<td class="no-border">
											<h6><span><?php echo $singlecampaign->campaign_name;//echo ($singlecampaign->profile_name?$singlecampaign->profile_name:$singlecampaign->campaign_name); ?></span></h6>
										</td>
										<?php //if($sessions->status == '0'):?>								                                	
										<td  width="20px;" class="no-border"><a href="<?php echo base_url(); ?>step/custom_content/<?php echo $singlecampaign->campaign_id; ?>-cg"><input type="button" class="buttonM bGreen" name="launch" value="Edit" /></a></td>
										<td  width="20px;" class="no-border"><a href="#_" onclick="deleteCampaignCustom('<?php echo $singlecampaign->campaign_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
										<?php //endif;?>
									</tr>
								<?php // endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
				<br/>
				<a class="buttonM bRed" href="<?php echo base_url(); ?>step/custom_content">Create a Custom Content</a>
			</div>
		</div>
	
</div>
		

	</div>
	</div>
	<br/>
	
</div>

<script type="text/javascript">
//By Dev@4489
function deleteCampaignCustom(campaign_id)
{
	var answer = confirm("Are you sure you want to proceed?")
	/** call ajax functionality to find and ajax call */
	if(answer){
		$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>campaign/deleteCampaignCustom/',
				data: {campaign_id : campaign_id },
				cache: false,
				dataType: 'json',
				success: function(response)
				{
					console.log(response);
					location.reload(true);
					// window.location.href = BASE_URL + 'step/value';					
				}
			});
	}else{
		return;
	}
}
</script>