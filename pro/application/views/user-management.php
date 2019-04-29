<?php $this->load->view('common/meta');?>	
<?php $this->load->view('common/header');?>
<style>
.button {color:red;}
.delete {font-size: 20px;}
.align-center{text-align: center;}
</style>

<script language='javascript' type='text/javascript'>

</script>

<!-- Sidebar begins -->
<div id="sidebar">
	<?php $this->load->view('common/left_navigation');?>
	
    <!-- Secondary nav -->
    <div class="secNav">    
    	<div class="clear"></div>
   </div>
</div>
<!-- Sidebar ends -->
 
 
<!-- Content begins -->
<div id="content">
                <?php $this->load->view('common/progress_bar');?>
    <!-- Breadcrumbs line -->

    <?php $this->load->view('common/top_navigation');?>
 
    <!-- Main content -->
    <div class="wrapper">
    	<div style="margin-top:10px;">
    		<a <?php if($is_paid) { ?> href="<?php echo base_url();?>for-team-member" <?php }else {?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php }?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>
    	</div>
    	<div align="center"><h2>User Management</h2></div>
		<?php if(!empty($all_requests) or !empty($all_receiver_requests)):?>
	        <div class="fluid">
	             <div class="widget grid12">     
					<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">  
					  <thead>
					    <tr>
					      <th class="no-border"><h6>User Name</h6></th>
					      <th class="no-border"><h6>First Name</h6></th>
					      <th class="no-border"><h6>Last Name</h6></th>
					      <th class="no-border"><h6>Action</h6></th>
					    </tr>
					  </thead>
					  <tbody>
						  	<?php if(!empty($all_requests)):?>
								  	<?php foreach ($all_requests as $requests):?>
								  		<?php $detail = $this->home->getDetailForManagementListing($requests->receiver_id, 'receiver');?>
									   <tr class="align-center">
									       <td class="no-border"><?php echo $detail->username;?></td>
									       <td class="no-border"><?php echo $detail->first_name;?></td>
									       <td class="no-border"><?php echo $detail->last_name;?></td>
									       <td class="no-border">
									         	<a href="#_" onclick="deleteFrndRequest('<?php echo $requests->receiver_id;?>','management');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>
									       </td>
									    </tr>
							<?php endforeach;?>
							<?php endif;?>	 
								 <?php if(!empty($all_receiver_requests)):?>
									 <?php foreach ($all_receiver_requests as $requests):?>
								  		<?php $detail = $this->home->getDetailForManagementListing($requests->sender_id, 'receiver');?>
									   <tr class="align-center">
									       <td class="no-border"><?php echo $detail->username;?></td>
									       <td class="no-border"><?php echo $detail->first_name;?></td>
									       <td class="no-border"><?php echo $detail->last_name;?></td>
									       <td class="no-border">
									         	<a href="#_" onclick="deleteFrndRequest('<?php echo $requests->sender_id;?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>
									       </td>
									    </tr>
									 <?php endforeach;?>
								 <?php endif;;?>
							
					  </tbody>
					</table>
				</div>
			</div>
		<?php endif;?>
</div>

    <!-- Main content ends -->
</div>
<?php $this->load->view('common/footer');?>
