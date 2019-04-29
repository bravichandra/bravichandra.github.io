<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>
	<!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>

<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">
	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/empty_nav');
	?> 	
	<!-- Start Search for a Team Member Form -->						    
	<!-- Main content -->
	<!-- Start Existing Team Members Conection -->							    
			<div class="wrapper">
				<!-- <div style="margin-top:10px;">							    		
				<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									
				<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        
					<div class="fluid">
						<div class="grid6" style="width:initial;">
							<div class="widget" style="padding-right:20px;">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Sales Playbook Training</h1>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUVJsDQgZIJWf8vOR0B9TAORXP3atFfC" frameborder="0" allowfullscreen></iframe>							
							</div>
						</div>						
					</div>
				<?php // endif; ?>							
			</div>
			<!-- End Existing Team Members Conection -->
	<!-- End Search for a Team Member Form -->      
	</div>
	<!-- Main content ends -->
<?php $this->load->view('common/footer'); ?>
