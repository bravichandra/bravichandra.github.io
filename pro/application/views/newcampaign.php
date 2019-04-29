<?php $this->load->view('common/meta'); ?>	<?php $this->load->view('common/header'); ?>

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

<?php //$this->load->view('common/progress_bar');?>    <!-- Breadcrumbs line -->    

    <?php $this->load->view('common/top_navigation'); ?> 
					
					<div class="wrapper">
                        <div class="widget fluid">
                            <div class="grid12">
                                <div class="body">
								
								
								    <?php 
									   // var_dump($progress_data);
									?>
                                    <h1 class="pt10">Create new campaign </h1>
                                    <br>
									
									<div class="">
										<a class="buttonM bRed" href="<?php echo base_url(); ?>home/newsession">Create product</a>
									</div>
									
									<?php if($progress_data->start== true) { ?>
										<br />
										<div class="">
											<a class="buttonM bRed" href="<?php echo base_url(); ?>campaign/createcampaign">Create Campaign</a>
										</div>
									<?php } ?>
									
									
										<br />	
										<div class="">
											<a class="buttonM bRed" href="<?php echo base_url(); ?>campaign/cretaedropname">Create Name Drop </a>
										</div>
										
										<br />
										<div class="">
											<a class="buttonM bRed" href="<?php echo base_url(); ?>campaign/createcompanyprofile">Create Company Profile</a>
										</div>
									<br/>	
                                </div>
                            </div>
                        </div>
                        <br/>
                    </div>
				</div>
<!-- Main content ends --><?php $this->load->view('common/footer'); ?>