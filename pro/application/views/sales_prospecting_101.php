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
	$this->load->view('common/sales101_nav');
	?> 	
	<!-- Start Search for a Team Member Form -->						    
	<!-- Main content -->
	<!-- Start Existing Team Members Conection -->							    
			<div class="wrapper">
				<!-- <div style="margin-top:10px;">							    		
				<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									
				<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        
					<div class="fluid">
                    	<?php if(!$week || $week=="all") {?>
                        <div class="grid6" style="width:initial;">
							<div class="widget" style="padding-right:20px;">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">SMART Sales Training Week 1</h1><br />
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUVJsDQgZIKzz7IHvTCxqJ4nUyTRg2Dn" frameborder="0" allowfullscreen></iframe>
							
							</div>
						</div><br />
                    	<?php } if($week==2 || $week=="all"){?>
                        <div class="grid6" style="width:initial;">
							<div class="widget" style="padding-right:20px;">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">SMART Sales Training Week 2</h1><br />
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUVJsDQgZII1D1xi-wUOnSBz9nzgFzjB" frameborder="0" allowfullscreen></iframe>
							
							</div>
						</div><br />
                        <?php }if($week==3 || $week=="all"){?>
                        <div class="grid6" style="width:initial;">
							<div class="widget" style="padding-right:20px;">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">SMART Sales Training Week 3</h1><br />
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUVJsDQgZIKOQnluOpbnLtUCQo9sELNl" frameborder="0" allowfullscreen></iframe>
							
							</div>
						</div><br />
                        <?php } if($week==4 || $week=="all"){?>
                        <div class="grid6" style="width:initial;">
							<div class="widget" style="padding-right:20px;">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">SMART Sales Training Week 4</h1><br />
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLoUVJsDQgZIIvJB7a41o4fGZ7S_VhpUfD" frameborder="0" allowfullscreen></iframe>
							
							</div>
						</div><br />	                        
                        <?php }?>
                     </div>
				<?php // endif; ?>							
			</div>
			<!-- End Existing Team Members Conection -->
	<!-- End Search for a Team Member Form -->      
	</div>
	<!-- Main content ends -->
<?php $this->load->view('common/footer'); ?>
