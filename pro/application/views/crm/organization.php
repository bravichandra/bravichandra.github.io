<div class="wrapper">

	<!-- <div style="margin-top:10px;">							    		

	<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									

	<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        

		<div class="fluid">

			<div class="grid12">

				<div class="quatabs">
		            <div class="active"><a href="<?php echo base_url('crm/settings/organization')?>">Current Organization</a></div>
		            <div><a href="<?php echo base_url('crm/settings/teamsearch')?>">Add New Connections</a></div>
		            <div><a href="<?php echo base_url('crm/settings/invitation')?>">Invitations to Connect</a></div>
		        </div><br clear="all" />

				<div class="widget">

					<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Connected Pro Users</h1>

				<table cellpadding="0" cellspacing="0" width="50%" class="tDefault">

					<thead>

						<tr>

							<th class="no-border" width="20%">

								<h6>Username</h6>

							</th>

							<th class="no-border" width="20%">

								<h6>First Name</h6>

							</th>

							 

							<th class="no-border" width="20%">

								<h6>Last Name</h6>

							</th>

							

							<th class="no-border" width="40%">

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

							<a href="#_" onclick="delete_connected_iuser('<?php echo $requests->receiver_id; ?>','rec','<?php echo $requests->sender_id; ?>','<?php echo $requests->t_session_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>																         																	       </td>

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

								<a href="#_" onclick="delete_connected_iuser('<?php echo $requests->sender_id; ?>','send','<?php echo $requests->sender_id; ?>','<?php echo $requests->t_session_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>															       

							</td>

						</tr>

						<?php endforeach; ?>														

						<?php endif; ?>																										  

					</tbody>

				</table>

				</div>

                <?php if(!empty($all_shared_users)): 
                	$ssuser_plans = $this->config->item('ssuser_plans');
                	$sharenames = $ssuser_plans['uplevel_names'];
                ?>	

                <div class="widget">

					<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Connected Lite Users</h1>

				<table cellpadding="0" cellspacing="0" width="50%" class="tDefault">

					<thead>

						<tr>

							<th class="no-border" width="20%">

								<h6>Username</h6>

							</th>

							<th class="no-border" width="20%">

								<h6>First Name</h6>

							</th>

							 

							<th class="no-border" width="20%">

								<h6>Last Name</h6>

							</th>

							<th class="no-border" width="20%">

								<h6>Shared</h6>

							</th>

							<th class="no-border" width="15%">

								<h6>Access</h6>

							</th>

							

							<th class="no-border" width="5%">

								<h6>Action</h6>

							</th>

						</tr>

					</thead>

					<tbody>

						<?php foreach ($all_shared_users as $suser): 
							$accesnames = "";
							if($suser->access) {
								$accessoptions = explode(",", $suser->access);
								foreach ($accessoptions as $acval) {
									if($accesnames) $accesnames .= ", ";
									$accesnames .= $sharenames[$acval];
								}
							}
						?>															  		

						<tr class="align-center">

							<td class="no-border"><?php echo $suser->username; ?></td>

							<td class="no-border"><?php echo $suser->first_name; ?></td>

							<td class="no-border"><?php echo $suser->last_name; ?></td>

							<td class="no-border"><?php echo $accesnames; ?></td>

							<td class="no-border"><?php echo ($suser->accessview=="Own"?"Only User's Records":'All Records'); ?></td>

							<td class="no-border">

							<a  class="buttonM bRed"  onClick="if(!confirm('Are u sure you want to delete this user?')) return false;" href="<?php echo base_url() ?>home/share_remove/<?php echo $suser->user_id; ?>">Delete</a>																							       									</td>

						</tr>

						<?php endforeach; ?>													 									

					</tbody>

				</table>

				</div>

                <?php endif; ?>

			</div>						

		</div>

	<?php // endif; ?>							

</div>
<script type="text/javascript">
	function delete_connected_iuser(frnd_id,action,sender_id,team_session_id)
	{
		//show confirm message
		var answer = confirm("Are you sure you want to proceed?")
		if (answer){
			$.ajax({
				  type: "POST",
				  url: BASE_URL + 'home/delete_frnd_request/',
				  data: 'frnd_id='+frnd_id+'&action='+action+'&sender_id='+sender_id+'&team_session_id='+team_session_id,
				  cache: false,
				  dataType: 'json',
				  success: function(response)
				  {
				  	window.location.href = BASE_URL + 'crm/settings/organization';
				  }
				});
		}
		else
		{
			return;
		}

	}
</script>