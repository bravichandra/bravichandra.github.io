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
       if($d_page == 15 || $d_page == 16){
		
			$this->load->view('common/empty_nav');
	   }else{
			$this->load->view('common/drop_menu');
	   }
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
							<div class="widget">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Connected Scripter Users</h1>
							<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
								<thead>
									<tr>
										<th class="no-border">
											<h6>Username</h6>
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
								
									<?php
									
									  // var_dump($all_requests);
									?>
									
									<?php if(!empty($all_requests)): ?>															  	
									<?php foreach ($all_requests as $requests): ?>															  		
									<?php $detail = $this->home->getDetailForManagementListing($requests->receiver_id, 'receiver'); ?>																   
									<tr class="align-center">
										<td class="no-border"><?php echo $detail->username; ?></td>
										<td class="no-border"><?php echo $detail->first_name; ?></td>
										<td class="no-border"><?php echo $detail->last_name; ?></td>
										<td class="no-border">
										<a  class="buttonM bBlue" href="<?php echo base_url() ?>home/teammate_campaign/<?php echo $requests->receiver_id; ?>">View</a>
										<a href="#_" onclick="deleteFrndRequest('<?php echo $requests->receiver_id; ?>','rec','<?php echo $requests->sender_id; ?>','<?php echo $requests->t_session_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>																         																	       </td>
									</tr>
									<?php endforeach; ?>														
									<?php endif; ?>	 														 
									<?php if (!empty($all_receiver_requests)): ?>															 
									<?php foreach ($all_receiver_requests as $requests): ?>														  		
									<?php $detail = $this->home->getDetailForManagementListing($requests->sender_id, 'receiver'); ?>															   
									<tr class="align-center">
										<td class="no-border"><?php echo $detail->username; ?></td>
										<td class="no-border"><?php echo $detail->first_name; ?></td>
										<td class="no-border"><?php echo $detail->last_name; ?></td>
										<td class="no-border">															         	
											<a  class="buttonM bBlue" href="<?php echo base_url() ?>home/teammate_campaign/<?php echo $requests->sender_id; ?>">View</a>
											<a href="#_" onclick="deleteFrndRequest('<?php echo $requests->sender_id; ?>','send','<?php echo $requests->sender_id; ?>','<?php echo $requests->t_session_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>															       
										</td>
									</tr>
									<?php endforeach; ?>														
									<?php endif; ?>																										  
								</tbody>
							</table>
							</div>
                            <?php if(!empty($all_shared_users)): ?>	
                            <div class="widget">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Connected Prospecter Users</h1>
							<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
								<thead>
									<tr>
										<th class="no-border">
											<h6>Username</h6>
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
									<?php foreach ($all_shared_users as $suser): ?>															  		
									<tr class="align-center">
										<td class="no-border"><?php echo $suser->username; ?></td>
										<td class="no-border"><?php echo $suser->first_name; ?></td>
										<td class="no-border"><?php echo $suser->last_name; ?></td>
										<td class="no-border">
										<a  class="buttonM bRed"  onClick="if(!confirm('Are u sure you want to delete this user?')) return false;" href="<?php echo base_url() ?>home/share_remove/<?php echo $suser->user_id; ?>">Delete</a>																							       									</td>
									</tr>
									<?php endforeach; ?>													 									
								</tbody>
							</table>
							</div>
                            <?php endif; ?>
						</div>
						<div class="grid6">
							<div class="widget">
								<!-- <div style="margin-top:10px;">						    		
								<a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>user-management" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="User Management" /></a>						    	</div> -->						    							    	
								<?php $msg = $this->session->flashdata('msg'); ?>						    	<?php if (isset($msg)): ?>
								<div style="margin-top:10px; color:green;margin-left: 10px;"><?php echo $msg; ?></div>
								<?php endif; ?>						       	
								<form id="validate" name="SearchForm" action="<?php echo current_url(); ?>" method="POST">
									<div class="">
										<div class="">
											<h1 style="margin-left:10px;" class="pt10">Search for a User</h1>
												<div class="formRow">
													<div class="grid4"><label>username, first name, or last name</label></div>
													<div class="grid4"><input style="height:auto;"  type="text" class="validate[required]" name="search_name" id="search_name" value=""></div>
													<div class="grid4" style="text-align: right;"><input type="submit" class="buttonM bBlue" name="submit" value="Search" /></div>
													<div style="display: inline-block;margin-top: 15px;text-align: right;width: 100%;"><input type="button" class="dialog_invitation buttonM bBlue" value="Invite New User" data-icon="&#xe090;"/>							                        </div>
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
									<div class="">
										<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
											<thead>
												<tr>
												<th class="no-border">
												<h6>Username</h6>
												</th>
												<th class="no-border">
												<h6>First Name</h6>
												</th>
												<!-- <th class="no-border">
												<h6>Last Name</h6>
												</th> -->
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
													<!-- <td class="no-border"><?php echo $data->last_name; ?></td> -->
													<td class="no-border">	
                                                    <?php if(isset($data->invite)) {?>											         	
													<a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/send_invitation/<?php echo $data->user_id; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Invite" /></a>
                                                    <?php } else if(isset($data->share)) {?>
                                                    <a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/share_user/<?php echo $data->user_id; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Share" /></a>
                                                    <?php } else echo $data->action;?>												         													       </td>
												</tr>
												<?php endforeach; ?>											  
											</tbody>
										</table>
									</div>
								</div>
								<?php endif; ?>								 
							<!-- Search Result End -->
							</div>
							<div class="widget">
								<h1 class="pt10" style="margin-left:10px;">Open Invitations</h1>
								<div class="">
									<div class="body">
									<?php if (!empty($receive_invitations)): ?>								       	
										<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
											<thead>
												<tr>
													<th class="no-border">
														<h6>Username</h6>
													</th>
													<th class="no-border">
														<h6>First Name</h6>
													</th>
													<!-- 
													<th class="no-border">
														<h6>Last Name</h6>
													</th> -->
													<th class="no-border">
														<h6>Action</h6>
													</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($receive_invitations as $invitations): ?>												
												<?php $detail = $this->home->getDetailForManagementListing($invitations->sender_id, 'receiver'); ?>											   
													<tr class="align-center">
														<td class="no-border"><?php echo $detail->username; ?></td>
														<td class="no-border"><?php echo $detail->first_name; ?></td>
														<!-- <td class="no-border"><?php // echo $detail->last_name; ?></td> -->
														<td class="no-border">											         	
														<a <?php if ($is_paid) { ?> href="#_" onclick="requestAccept('<?php echo $invitations->receiver_id; ?>');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="accept" value="Accept" /></a>&nbsp;											         	<a <?php if ($is_paid) { ?> href="#_" onclick="deleteFrndRequest('<?php echo $invitations->receiver_id; ?>','rec');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>											       </td>
													</tr>
												<?php endforeach; ?>																					  
											</tbody>
										</table>
									<?php else: ?>											
									<div>There are not currently any open invitations</div>
									<?php endif; ?>				        			
									</div>
								</div>
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
