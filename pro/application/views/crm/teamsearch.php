<div class="wrapper">

		<div class="fluid">						

			<div class="grid12">

				<div class="quatabs">
		            <div><a href="<?php echo base_url('crm/settings/organization')?>">Current Organization</a></div>
		            <div class="active"><a href="<?php echo base_url('crm/settings/teamsearch')?>">Add New Connections</a></div>
		            <div><a href="<?php echo base_url('crm/settings/invitation')?>">Invitations to Connect</a></div>
		        </div><br clear="all" />			       	

				<div class="widget">		    	

					<?php $msg = $this->session->flashdata('msg'); ?>	
					<?php if (isset($msg)): ?>

					<div style="margin-top:10px; color:green;margin-left: 10px;"><?php echo $msg; ?></div>

					<?php endif; ?>						

					<form id="validate" name="SearchForm" action="<?php echo current_url(); ?>" method="POST">

						<div class="">

							<div class="">

								<h1 style="margin-left:10px;" class="pt10">Search for a User</h1>

									<div class="formRow">

										<div class="grid4"><label>Enter username, first name, or last name</label></div>

										<div class="grid4"><input style="height:auto;"  type="text" class="validate[required]" name="search_name" id="search_name" value=""></div>

										<div class="grid4" style="text-align: right;"><input type="submit" class="buttonM bBlue" name="submit" value="Search" /></div>

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
											<h6>User</h6>
										</th>

										<th class="no-border">
											<h6>Sales Pitch  Builder Share</h6>		
										</th>
										<th class="no-border">
											<h6>Sales Playbook Share</h6>		
										</th>
										<th class="no-border">
											<h6>CRM Share</h6>		
										</th>
										<th class="no-border">
											<h6>Staffing Share</h6>		
										</th>
										<th class="no-border">
											<h6>Access</h6>		
										</th>
										<th class="no-border">
											<h6>Action</h6>
										</th>
										<th class="no-border"></th>
									</tr>

								</thead>

								<tbody>

									<?php foreach ($user_data as $data): 
										if(!$data->plan) continue;
										$uplanoptions = isset($uplan_levels[$data->plan])?$uplan_levels[$data->plan]:array();
										$disabled = $data->disable?'disabled="disabled"':'';
										$shareall = $data->sharednames?0:1;
									?>

									<tr class="align-center shareElements" style="text-align: center;">

										<td class="no-border" style="text-align: left;"><?php echo $data->first_name; ?> <?php echo $data->last_name; ?> / <?php echo $data->email; ?></td>
										<td class="no-border">
											<?php 
												if(in_array('sales-pitch-builder',$uplanoptions)!==FALSE) {
													$checked = in_array('sales-pitch-builder', $data->access)!==FALSE || $shareall?'checked="checked"':'';
													echo '<input type="checkbox" value="sales-pitch-builder" class="shareopt" '.$checked.' '.$disabled.' />';
												}
											?>
											</td>										
										<td class="no-border">
											<?php 
												if(in_array('sales-playback',$uplanoptions)!==FALSE) {
													$checked = in_array('sales-playback', $data->access)!==FALSE  || $shareall?'checked="checked"':'';
													echo '<input type="checkbox" value="sales-playback" class="shareopt" '.$checked.' '.$disabled.' />';
												}
											?></td>
										<td class="no-border">
											<?php 
												if(in_array('crm',$uplanoptions)!==FALSE) {
													$checked = in_array('crm', $data->access)!==FALSE || $shareall?'checked="checked"':'';
													echo '<input type="checkbox" value="crm" class="shareopt" '.$checked.' '.$disabled.' />';
												}
											?></td>	
										<td class="no-border">
											<?php 
												if(in_array('staffing',$uplanoptions)!==FALSE) {
													$checked = in_array('staffing', $data->access)!==FALSE || $shareall?'checked="checked"':'';
													echo '<input type="checkbox" value="staffing" class="shareopt" '.$checked.' '.$disabled.' />';
												}
											?></td>
										<td class="no-border">
											<?php if(!$disabled){?>
											<select class="accessview">
					                            <option value="All"<?php if($data->accessview=="All") echo ' selected="selected"';?>>All Records</option>
					                            <option value="Own"<?php if($data->accessview=="Own") echo ' selected="selected"';?>>Only User's Records</option>
					                        </select>
					                        <?php }?>
										</td>
										<td class="no-border">												         	
											<form method="post" class="frmShare">
												<!--<input type="hidden" name="record[user2]" value="<?php echo $data->username?>" />-->
												<input type="hidden" name="record[share]" value="" class="sharevals" />
												<input type="hidden" name="record[access]" value="All" class="accessvals" />
												<input type="hidden" name="record[plan]" value="<?php echo $data->plan?>" />
												<input type="hidden" name="record[uid2]" value="<?php echo $data->uid?>" />
	                                        <?php // if(isset($data->invite)) {?>


											<?php if($data->plan=="eScripter") { ?>
											<a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/send_invitation/<?php echo $data->user_id; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Connect" /></a>
                                            <?php } ?>

	                                        <?php //} else if(isset($data->share)) {?>
											<?php if($data->plan=="is_prolite") { ?>
	                                        <a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/share_user/<?php echo $data->user_id; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>></a>
                                            <input type="button" class="buttonM bRed" name="request" onclick="saveOptions(this)"  value="Share" />
                                            <?php } ?>

	                                        <?php //} else echo $data->action;*/?>
	                                        <span class="message"><?php 
	                                        if($data->sharednames) {
	                                        	echo ($data->sharednames[0]=="You"?"You are":$data->sharednames[0]." is")." connected to ".$data->sharednames[1];
	                                        }
	                                        ?></span>
	                                        <span class="supdate"><?php 
	                                        if($data->sharednames) {
	                                        	if(!$data->disable) echo ' <input type="button" class="buttonM bRed" name="record[shareUpdate]" value="Update" onclick="saveOptions(this)" />';
	                                        }
	                                        ?></span>
	                                       <?php /*?> <span class="sconnect"><?php 
	                                        if(!$data->sharednames) {
	                                        	echo ' <input type="button" class="buttonM bRed" name="record[shareConnect]" onclick="saveOptions(this)" value="Connect" />';
	                                        }
	                                        ?></span><?php */?>

	                                        <?php //echo "<br>".$data->message;?>
	                                    	</form>	                                    	
	                                    </td>
	                                    <td class="no-border"><span class="loader"></span></td>
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

		</div>

	<?php // endif; ?>							

</div>
<script type="text/javascript">
	//Save
	function saveOptions(dis) {		
	//alert("test123");
	var tr = $(dis).parents("tr");
		tr.find(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		var shopts = '';
		if(tr.find(".shareopt:checked").length>0) {
			tr.find(".shareopt:checked").each(function(){
		        if(shopts) shopts += ",";
		        shopts += $(this).val();
		    });	
		}
		tr.find(".sharevals").val(shopts);
		//alert(tr.find(".accessview").val());
		tr.find(".accessvals").val(tr.find(".accessview").val());
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: tr.find(".frmShare").serialize(),
		  cache: false,
		  dataType: 'json'
			}).done(function( resp ) {
				//alert(resp);
				tr.find(".loader").html('');
				if(resp.status==true) {
					if(resp.actions==true) {
						tr.find(".message").html(resp.a_message);
						tr.find(".supdate").html(resp.a_supdate);
						tr.find(".sconnect").html(resp.a_sconnect);
					}	
				}
				
				alert(resp.message);
				window.location.href = BASE_URL + 'crm/settings/organization';
		  })

		  .fail(function() {
		  	tr.find(".loader").html('');
			alert( "Unable to setup settings, please try again" );
		  });
	}
</script>