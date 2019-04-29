<div class="wrapper">

	<!-- <div style="margin-top:10px;">							    		

	<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									

	<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        

		<div class="fluid">
<div class="fluid">

			<div class="grid12">

				<div class="quatabs">
		            <div><a href="<?php echo base_url('crm/settings/organization')?>">Current Organization</a></div>
		            <div><a href="<?php echo base_url('crm/settings/teamsearch')?>">Add New Connections</a></div>
		            <div class="active"><a href="<?php echo base_url('crm/settings/invitation')?>">Invitations to Connect</a></div>
		        </div><br clear="all" />
<div class="widget">
								<h1 class="pt10" style="margin-left:10px;">Open Invitations</h1>
								<div class="">
									<div class="body">
									<?php if (!empty($receive_invitations)): ?>								       	
										<table cellpadding="0" cellspacing="0" width="50%" class="tDefault">
											<thead>
												<tr>
													<th class="no-border" width="30%">
														<h6>Username</h6>
													</th>
													<th class="no-border" width="30%">
														<h6>First Name</h6>
													</th>
													<!-- 
													<th class="no-border">
														<h6>Last Name</h6>
													</th> -->
													<th class="no-border" width="40%">
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
														<a <?php if ($is_paid) { ?> href="#_" onclick="inv_requestAccept('<?php echo $invitations->receiver_id; ?>');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="accept" value="Accept" /></a>&nbsp;											         	<a <?php if ($is_paid) { ?> href="#_" onclick="inv_deleteFrndRequest('<?php echo $invitations->receiver_id; ?>','rec','<?php echo $invitations->sender_id; ?>','<?php echo $invitations->t_session_id; ?>');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>											       </td>
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
			<!-- End Existing Team Members Conection -->
	<!-- End Search for a Team Member Form -->      
	</div>
</div>
</div>
<script>
function inv_deleteFrndRequest(frnd_id,action,sender_id,team_session_id)
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
			  	window.location.href = BASE_URL + 'crm/settings/invitation';
			  }
			});
	}
	else
	{
		return;
	}

}


function inv_requestAccept(invitation_user_id)
{
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/invitation_accept/',
		  data: 'invitation_user_id='+invitation_user_id,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
			window.location.href = BASE_URL + 'crm/settings/invitation';
		  }
		});
}
</script>
