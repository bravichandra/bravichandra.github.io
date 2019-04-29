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
	$this->load->view('common/trash_nav');
	?> 	
	<!-- Start Search for a Team Member Form -->						    
	<!-- Main content -->
	<!-- Start Existing Team Members Conection -->							    
			<div class="wrapper">
				<!-- <div style="margin-top:10px;">							    		
				<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									
				<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        
					<div class="fluid">
						<div class="grid6">
							<div class="widget trash">
                            	<h1 class="pt10">Product Profiles</h1>
                                <table cellpadding="0" cellspacing="0"  class="tDefault">
                                    <tbody>
                                        <?php if ($product_profiles){ ?>
                                            <?php foreach ($product_profiles as $product): ?>	
                                        <tr>
                                            <td class="no-border" width="70%"><h6><?php echo $product->product_name; ?></h6></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/product/restore/'.$product->product_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to restore this product profile?')) return false;">Restore</a></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/product/delete/'.$product->product_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to delete permanently this product profile?')) return false;">Delete</a></td>     
                                        </tr>
                                            <?php endforeach; ?>					                           
                                        <?php }else{?>
                                        <tr>
                                            <td><h6>No Product profiles</h6></td>                        
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <hr />
                                <h1 class="pt10">Sales Pitch Campaigns</h1>
                                <table cellpadding="0" cellspacing="0"  class="tDefault">
                                    <tbody>
                                        <?php if ($salespitch_list){ ?>
                                            <?php foreach ($salespitch_list as $salespitch): ?>	
                                        <tr>
                                            <td class="no-border" width="70%"><h6><?php echo $salespitch->campaign_name; ?></h6></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/salespitch/restore/'.$salespitch->campaign_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to restore this sales pitch campaign?')) return false;">Restore</a></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/salespitch/delete/'.$salespitch->campaign_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to delete permanently this sales pitch campaign?')) return false;">Delete</a></td>
                                        </tr>
                                            <?php endforeach; ?>					                           
                                        <?php }else{?>
                                        <tr>
                                            <td><h6>No Sales Pitch Campaigns</h6></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>  
                                <hr />
                                <h1 class="pt10">Company profiles</h1>
                                <table cellpadding="0" cellspacing="0"  class="tDefault">
                                    <tbody>
                                        <?php if ($company_profiles){ ?>
                                            <?php foreach ($company_profiles as $company): ?>	
                                        <tr>
                                            <td class="no-border" width="70%"><h6><?php echo $company->company_name; ?></h6></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/company/restore/'.$company->company_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to restore this company profile?')) return false;">Restore</a></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/company/delete/'.$company->company_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to delete permanently this company profile?')) return false;">Delete</a></td>     
                                        </tr>
                                            <?php endforeach; ?>					                           
                                        <?php }else{?>
                                        <tr>
                                            <td><h6>No Company profiles</h6></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                <hr />
                                <h1 class="pt10">Name drop Examples</h1>
                                <table cellpadding="0" cellspacing="0"  class="tDefault">
                                    <tbody>
                                        <?php if ($namedrop_profiles){ ?>
                                            <?php foreach ($namedrop_profiles as $namedrop): ?>	
                                        <tr>
                                            <td class="no-border" width="70%"><h6><?php echo ($namedrop->value?$namedrop->value:$namedrop->credibility_name); ?></h6></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/namedrop/restore/'.$namedrop->c_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to restore this name drop example?')) return false;">Restore</a></td>
                                            <td class='no-border' width="15%"><a href="<?php echo base_url('folder/trash/namedrop/delete/'.$namedrop->c_id); ?>" class="buttonM bRed" onclick="if(!confirm('Are you sure you want to delete permanently this name drop example?')) return false;">Delete</a></td>   
                                        </tr>
                                            <?php endforeach; ?>					                           
                                        <?php }else{?>
                                        <tr>
                                            <td><h6>No Name drops</h6></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                                                              
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
