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
                <?php //$this->load->view('common/progress_bar');?>
    <!-- Breadcrumbs line -->

    <?php $this->load->view('common/top_navigation');?>
 
    <!-- Main content -->
    <div class="wrapper">
    	<div style="margin-top:10px;">
    		<a <?php if($is_paid) { ?> href="<?php echo base_url();?>user-management" <?php }else {?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php }?>><input type="button" class="buttonM bRed" name="request" value="User Management" /></a>
    	</div>
    	<div align="center"><h2>Search for a Team Member</h2></div>
    	<div style="margin-top:10px; color:green;"><?php echo $this->session->flashdata('msg');?></div>
       	<form id="validate" action="<?php echo current_url(); ?>" method="post"> 
           <div class="fluid">
                	<div class="widget grid12">
	                    <div class="formRow">
	                        <div class="grid4"><label>Search By User Name</label></div>
	                        <div class="grid6"><input style="height:30px !important;" type="text" class="validate[required]" name="search_name" id="search_name" value=""></div>
	                        <div class="grid2"><input type="submit" class="buttonM bBlue" name="submit" value="Search" /></div>
	                        <div class="clear"></div>
	                    </div>
                    </div>
            </div>
        </form>
        
        <!-- Search Result Start -->
        <?php if(!empty($user_data)):?>
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
					  	<?php foreach ($user_data as $data):?>
						   <tr class="align-center">
						       <td class="no-border"><?php echo $data->username;?></td>
						       <td class="no-border"><?php echo $data->first_name;?></td>
						       <td class="no-border"><?php echo $data->last_name;?></td>
						       <td class="no-border">
						         	<a <?php if($is_paid) { ?>href="<?php echo base_url();?>home/send_invitation/<?php echo $data->user_id;?>" <?php }else {?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php }?>><input type="button" class="buttonM bRed" name="request" value="Send Invitaion" /></a>
						       </td>
						    </tr>
					    <?php endforeach;?>
					  </tbody>
					</table>
				</div>
			</div>
		<?php endif;?>
		 <!-- Search Result End -->
</div>
    <!-- Main content ends -->
</div>
<?php $this->load->view('common/footer');?>
