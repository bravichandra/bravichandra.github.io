<?php $this->load->view('common/meta'); ?>	
    <?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>	    \
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
    <?php $this->load->view('common/top_navigation'); ?> 				    
        <?php if ($d_page == 19) {
        ?>				    	

            <?php if (!empty($TemplateData)): ?>
                        <?php
                              $Tdata = $TemplateData->row();
                        ?>
                                <div class="main-wrapper">
                                    <!-- Main content -->                        
                                    <div class="wrapper">
                                        <div class="widget fluid">
                                            <div class="grid12">
                                                <div class="body">
                                                    <h1 class="pt10"><?php echo $Tdata->TemplateName; ?></h1>
                                                    <p><?php echo $Tdata->Description; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="wrapper">
                                    <!-- <div style="margin-top:10px;">						    		
                                        <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>user-management" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="User Management" /></a>						    	</div> -->						    							    	
                                        <?php $msg = $this->session->flashdata('msg'); ?>						    	<?php if (isset($msg)): ?>
                                        <div style="margin-top:10px; color:green;"><?php echo $msg; ?></div>
                                        <?php endif; ?>						       	
                                        <form id="validate" name="SearchForm" action="<?php echo current_url(); ?>" method="POST">
                                            <div class="fluid">
                                                <div class="widget grid12">
                                                    <h1 style="margin-left:10px;" class="pt10">Search for team member</h1>
                                                        <div class="formRow">
                                                            <div class="grid4"><label>Search By User Name</label></div>
                                                            <div class="grid5"><input style="height:30px !important;" type="text" class="validate[required]" name="search_name" id="search_name" value=""></div>
                                                            <div class="grid1"><input type="submit" class="buttonM bBlue" name="submit" value="Search" /></div>
                                                            <div class="grid1"><input type="button" class="dialog_invitation buttonM bBlue" value="Invite New User" data-icon="&#xe090;"/>							                        </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                    <?php if (isset($message)): ?>
                                                    <h3 style="margin-left:10px;"><?php echo $message; ?></h3>
                                                    <?php endif; ?>							                    						                    
                                                </div>
                                            </div>
                                        </form>
                                        <!-- Search Result Start -->						        
                                        <?php if (!empty($user_data)): ?>							        
                                        <div class="fluid">
                                            <div class="widget grid12">
                                                <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                                    <thead>
                                                        <tr>
                                                        <th class="no-border">
                                                        <h6>User Name</h6>
                                                        </th>
                                                        <th class="no-border">
                                                        <h6>First Name</h6>
                                                        </th>
                                                        <th class="no-border">
                                                        <h6>Last Name</h6>
                                                        </th>
                                                        <th class="no-border">
                                                        <h6>Action</h6>
                                                        </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($user_data as $data): ?>												   
                                                        <tr class="align-center">
                                                            <td class="no-border"><?php echo $data->username; ?></td>
                                                            <td class="no-border"><?php echo $data->first_name; ?></td>
                                                            <td class="no-border"><?php echo $data->last_name; ?></td>
                                                            <td class="no-border">												         	
                                                            <a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/sharewithuser/<?php echo $Tdata->TemplateId; ?>/<?php echo $data->user_id; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="sharerequest" value="Share Template" /></a></td>
                                                        </tr>
                                                        <?php endforeach; ?>											  
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php endif; ?>								 
                                    <!-- Search Result End -->								 						
                                    </div>
                                </div>
                         
    
            <?php endif; ?>	
        <?php
        }                    
    ?>
</div>
<!-- Main content ends -->
<?php $this->load->view('common/footer'); ?>
