<?php $this->load->view('common/meta'); ?>	



<?php $this->load->view('common/header'); ?>



<script type="text/javascript" src="<?php echo site_url('tiny_mce/tiny_mce.js'); ?>?test=<?php echo rand(); ?>"></script>

<script type="text/javascript">

	tinyMCE.init({

        document_base_url : "<?php echo base_url();?>",

        relative_urls : false,

        remove_script_host : false,

        convert_urls : true,

		selector: "textarea",

		mode : "specific_textareas",

        editor_selector : "tinyMCE",

		theme : "advanced",

		height : "250",

		width: "700",

		

		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,jbimages",



		// Theme options

		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",

		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor,jbimages",

		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",

		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",

		theme_advanced_toolbar_location : "top",

		theme_advanced_toolbar_align : "left",

		theme_advanced_statusbar_location : "bottom"

	});

</script>



<style type="text/css">

		.contact-edit {

			width: 80% !important;

		}

</style>



<!-- Sidebar begins -->



<div id="sidebar">



    <?php $this->load->view('common/left_navigation'); ?>



	<!-- Secondary nav -->    



    <div class="secNav">



        <div class="clear"></div>



    </div>



</div>



<style>







</style>







<!-- Sidebar ends --> <!-- Content begins -->



<div id="content">



	<!-- Breadcrumbs line -->



	<?php  		



	$this->load->view('common/crm_nav');



	?>



	<?php 

	//Mailchimp

	if($maildelv=="integrations") include("settings_mailchimp.php"); 

	else if($maildelv=="teamsearch") { //TEAM FOLDER SEARCH

    	include("teamsearch.php");

    } else if($maildelv=="organization") { //TEAM FOLDER USERS

    	include("organization.php");

    } else if($maildelv=="invitation") { //TEAM FOLDER USERS

    	include("invitation_contact.php");

    } 	

	else if($maildelv=="teamsearch") { ?>



    		<div class="wrapper">



				<!-- <div style="margin-top:10px;">							    		



				<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									



				<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        



					<div class="fluid">						



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



													<div class="grid4"><label>Enter username, first name, or last name</label></div>



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



                                                    <?php } else echo $data->action;?>                                                                                                          																		 													</td>



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



    <?php } else if($maildelv=="organization") { ?>



    



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



					</div>



				<?php // endif; ?>							



			</div>



    



    <?php } else { ?>



	<!-- Main content -->



    <div class="main-wrapper crmlite">



        <?php if($er) {?>



        <div class="crm-error"><?php echo implode("<br />",$er);?></div>



        <?php }?>



		<!-- Main content -->



        <form method="post" id="frmsmtp" onsubmit="return save_record();" action="<?php echo current_url();?>">



        	<input type="hidden" name="action" value="save" />



        



        	<?php if($maildelv=="zone") {?>



        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px;" >



        	<tr>



            	<th class="title" colspan="4">Time Zone</th>



            </tr>



            <tr>



                <th class="one">Time Zone</th>



                <td class="two">



                <select name="tzone" id="timezone">



                    <option value="">Select</option>



                    <?php foreach($timezones as $tzi=>$tmzone){//$tmzone='(GMT '.($tmzone>=0?'+':'-').' '.date("h:i",str_replace('-','',$tmzone)).')'?>



                    <option value="<?php echo $tzi?>"<?php if($tzi==$tzone) echo ' selected="selected"';?>><?php echo $tmzone//.' '.$tzi?></option>



                    <?php }?>



				</select>



                </td>



            </tr>



        </table>



          <?php }  else if($maildelv=="fields") {

            		include("custom-fields-settings.php");

				}	

				else if($maildelv=="edata") include("export-data.php");			

				else if($maildelv=="layout") include("settings-fields_layout.php");

				else if($maildelv=="columns") include("settings-fields_column.php");

				else if($maildelv=="dropdowns"){

					include("edit_dropdowns.php");

			   }else if($maildelv=="sign") {?>



		<table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px;" >



        	<tr>



            	<th class="title" colspan="4">Email Signature</th>



            </tr>



           <?php /*?> <tr>



                <th class="one">First Name Last Name</th>



                <td class="two">



                	<input type="text" value="<?php if(isset($sign['yname'])) echo form_prep($sign['yname'])?>" name="sign[yname]" id="yname" />



                </td>



            </tr>



            <tr>



                <th class="one">Title</th>



                <td class="two">



                	<input type="text" value="<?php if(isset($sign['ytitle'])) echo form_prep($sign['ytitle'])?>" name="sign[ytitle]" id="ytitle" />



                </td>



            </tr>



            <?php /*?><tr>



                <th class="one">Company</th>



                <td class="two">



                	<input type="text" value="<?php if(isset($sign['ycompany'])) echo form_prep($sign['ycompany'])?>" name="sign[ycompany]" id="ycompany" />



                </td>



            </tr>

			<tr>



                <th class="one">Phone</th>



                <td class="two">



                	<input type="text" value="<?php if(isset($sign['yphone'])) echo form_prep($sign['yphone'])?>" name="sign[yphone]" id="yphone" />



                </td>



            </tr>



			<tr>



                <th class="one">Email Address</th>



                <td class="two">



                	<input type="text" value="<?php if(isset($sign['yemail'])) echo form_prep($sign['yemail'])?>" name="sign[yemail]" id="yemail" />



                </td>



            </tr>



			<tr>



                <th class="one">Website</th>



                <td class="two">



                	<input type="text" value="<?php if(isset($sign['ywebsite'])) echo form_prep($sign['ywebsite'])?>" name="sign[ywebsite]" id="ywebsite" />



                </td>



            </tr><?php */?>

            

            

            <tr>

            	<td class="one">&nbsp;

                	

                </td>

                <td class="two">

                	<?php 

						//echo '<pre>'; print_r($aMember); echo '</pre>'; 

						

						$amember_data = Am_Lite::getInstance()->getUser();

						//echo '<pre>'; print_r($amember_data); echo '</pre>'; 

						

						$mfname = $amember_data['name_f'];

						$mlname = $amember_data['name_l'];

						$mname = $mfname." ".$mlname;

						if($mname=='') {$member_name ='[First Name] [Last Name]'; } else { if($mname=="0 0") $member_name ='[First Name] [Last Name]'; else $member_name = $mname; }

						

						

						$cname = $aMember['ycompany'];

						if($cname!='' || $cname!=0) $company_name = $cname; else $company_name ='[Company Name]';

						

						$pnumber = $amember_data['phone'];

						if($pnumber!='' || $pnumber!=0) $phone_number = $pnumber; else $phone_number ='[Phone Number]';										

						

						$email = $amember_data['email'];

						

						if($email=='') {$email_address ='[Email Address]'; } else { if($email=="0") $email_address ='[Email Address]'; else $email_address = $email; }

						

						$website_field = $aMember['ywebsite'];

						if($website_field!='') $website = $website_field; else $website='[Website Address]';

						

						if(isset($sign['email_signature']) && $sign['email_signature']!='') $sg =  form_prep($sign['email_signature']);

						else $sg = $member_name."<br/>".$company_name."<br/>".$phone_number."<br/>".$email_address."<br/>".$website;

						

						//echo form_prep($sign['email_signature']);

						

						//echo '<pre>'; print_r($sign['email_signature']); echo '</pre>';

					?>

					<textarea id="contentdb" class="tinyMCE" name="sign[email_signature]"><?php echo $sg;?></textarea>                            

                </td>

            </tr>



        </table>



            <?php } else if($maildelv=="settings"){?>



        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px;" >



            <tr>



            	<th class="title" colspan="4">Email Settings</th>



            </tr>

            <tr>



                <th class="one" width="200px">From Name</th><td class="two"><input type="text" value="<?php if(isset($smtp['fromname'])) echo form_prep($smtp['fromname'])?>" name="smtp[fromname]" id="fromname" /></td>



            </tr>



            <tr>



                <th class="one">From Email Address</th><td class="two"><input type="text" value="<?php if(isset($smtp['fromemail'])) echo form_prep($smtp['fromemail'])?>" name="smtp[fromemail]" id="fromemail" /></td>



            </tr>

            

            

             <tr>

            	<td class="one" style="vertical-align:top;">

                	Email Signature

                </td>

                <td class="two">

                	<?php 

						//echo '<pre>'; print_r($cdetail); echo '</pre>'; 

						

						$amember_data = Am_Lite::getInstance()->getUser();

						//echo '<pre>'; print_r($amember_data); echo '</pre>'; 

						

						$mfname = $amember_data['name_f'];

						$mlname = $amember_data['name_l'];

						$mname = $mfname." ".$mlname;

						if($mname=='') {$member_name ='[First Name] [Last Name]'; } else { if($mname=="0 0") $member_name ='[First Name] [Last Name]'; else $member_name = $mname; }

						

						

						$cname = $aMember['ycompany'];

						if($cname!='' || $cname!=0) $company_name = $cname; else $company_name ='[Company Name]';

						

						$pnumber = $amember_data['phone'];

						if($pnumber!='' || $pnumber!=0) $phone_number = $pnumber; else $phone_number ='[Phone Number]';										

						

						$email = $amember_data['email'];

						

						if($email=='') {$email_address ='[Email Address]'; } else { if($email=="0") $email_address ='[Email Address]'; else $email_address = $email; }

						

						$website_field = $aMember['ywebsite'];

						if($website_field!='') $website = $website_field; else $website='[Website Address]';

						

						if(isset($smtp['email_signature']) && $smtp['email_signature']!='') $sg =  form_prep($smtp['email_signature']);

						else $sg = $member_name."<br/>".$company_name."<br/>".$phone_number."<br/>".$email_address."<br/>".$website;

						

						//echo '<pre>'; print_r($sign['email_signature']); echo '</pre>';

					?>

					<textarea class="tinyMCE" style="width:300px !important;"  name="smtp[email_signature]" id="email_signature"  ><?php echo $sg;?></textarea>                            

                </td>

            </tr>



        </table>



            <?php }if($maildelv!="dropdowns" && $maildelv!="layout"  && $maildelv!="columns" && $maildelv!="edata") { ?>



        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px;" >



            <tr>



          <?php if($maildelv=="fields") {  ?><td class="two"><input type="button" class="buttonM bRed" value="Add Custom Field" onclick="addeditor()" /> </td> <?php } ?>



            	<td colspan="4" align="center">



                    <div class="fluid" style="margin-top:15px;">



                    	<span class="loader"></span>



                        <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" />

                        

                    </div>



                    <div style="text-align: left;padding-left: 10px;" id="esettings"></div>		



                </td>



            </tr>            



        </table>

        <?php } ?>



        </form>



	</div>



    <?php } ?>



    <!-- Main content ends -->



</div>



<div class="help_dialogvideo" title="Video">



    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



	<html xmlns="http://www.w3.org/1999/xhtml">



	<head>



	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



	<title>Video</title>



	</head>







	<body>



	 <div class="video">







	 </div>



	</body>



	</html>



</div>	







<script type="text/javascript">



var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z24pqundavY" frameborder="0" allowfullscreen></iframe>';



$( document ).ready(function() {



    $('.help_dialogvideo').dialog({



        autoOpen: false,



        height: 400,



        width: 600,



        buttons: {



            "Close": function () {



                $('.video').html('');



                $(this).dialog("close");



            }



        }    



    });



        // Invitation Dialog Link



    $('.dialogvideo_help').click(function (e) {



         $('.video').html(iframe);



         $('.help_dialogvideo').dialog('open');         



         return false;



    });



    $('.ui-icon-closethick').click(function (e) {



         $('.video').html('');



          $('.help_dialogvideo').dialog('close');



        return false;



    });







    //search tabs



    $('.quatabs a').click(function(e){



        $('.quatabs div').removeClass("active");



        $(this).parent().addClass("active");



        $('.tabbox').hide();



        $('.tabbox.'+$(this).attr("rel")).show();



        if($(this).attr("rel")=="box2") $("#ctab").val(2); else $("#ctab").val(1);



    });



});    



	//Skip hint



	function save_record(){



		$(".loader").html('');



		$("#esettings").html('');



		<?php if($maildelv=="fields") {?>



		/*if($("#field1").val().length==0) {



			alert("Contact Custom field 1 required");



			$("#field1").focus();



			return false;



		}



		if($("#field2").val().length==0) {



			alert("Contact Custom field 2 required");



			$("#field2").focus();



			return false;



		}



		if($("#field3").val().length==0) {



			alert("Contact Custom field 3 required");



			$("#field3").focus();



			return false;



		}



		if($("#afield1").val().length==0) {



			alert("Account Custom field 1 required");



			$("#afield1").focus();



			return false;



		}



		if($("#afield2").val().length==0) {



			alert("Account Custom field 2 required");



			$("#afield2").focus();



			return false;



		}



		if($("#afield3").val().length==0) {



			alert("Account Custom field 3 required");



			$("#afield3").focus();



			return false;



		}*/



		<?php } else if($maildelv=="sign") {?>



		var signature = tinyMCE.get('contentdb').getContent();		

		$("#contentdb").val(signature);

		

		<?php /*?>if($("#yname").val().length==0) {



			alert("Name required");



			$("#yname").focus();



			return false;



		}



		if($("#ytitle").val().length==0) {



			alert("Title required");



			$("#ytitle").focus();



			return false;



		}



		if($("#ycompany").val().length==0) {



			alert("Company required");



			$("#ycompany").focus();



			return false;



		}



		if($("#yphone").val().length==0) {



			alert("Phone required");



			$("#yphone").focus();



			return false;



		}



		if($("#yemail").val().length==0) {



			alert("Email address required");



			$("#yemail").focus();



			return false;



		}



		if($("#ywebsite").val().length==0) {



			alert("Website required");



			$("#ywebsite").focus();



			return false;



		}<?php */?>



		<?php } else if($maildelv=="zone") {?>



		if($("#timezone").val().length==0) {



			alert("Time Zone required");



			$("#timezone").focus();



			return false;



		}



		<?php }else if($maildelv=="settings"){?>



		var signature = tinyMCE.get('email_signature').getContent();

		$("#email_signature").val(signature);



		if($("#fromname").val().length==0) {



			alert("From name required");



			$("#fromname").focus();



			return false;



		}



		if($("#fromemail").val().length==0) {



			alert("From email required");



			$("#fromemail").focus();



			return false;



		}	



		<?php }?>



		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');



		$.ajax({



		  type: "POST",



		  url: "<?php echo current_url();?>",



		  data: $('#frmsmtp').serialize()



			}).done(function( data ) {				



				$(".loader").html('');

				

				<?php if($maildelv=="layout") {?>

					$(".esettings").html(data);

				if($("#layout_action").val()=='reset' || $("#layout_action").val()=='reset_account') location.replace("<?php echo current_url();?>");

				

				<?php } else {?>

				$(".esettings").html(data);

				$("#esettings").html(data);

				<?php }?>



		  })



		  .fail(function() {



			alert( "Unable to setup settings, please try again" );



		  });



		return false;



	}



</script>	



<script>



//Add a Follow-Up Custom Fields



var etextcount = <?php echo ($custom?count($custom):1)?>;



var etextcounta = <?php echo ($customa?count($customa):1)?>;



		function addeditor(){



		//etextcount++;



		/*var numbers =document.getElementById("span").value;



		$.each(numbers , function (index, value){



		//$('#span').each(function (index, value){



   		console.log(value); 



		}); */



		



		/*$("span").each(function(){



        alert($(this).value())



    });*/



		



		/*$.each($('#span'), function (index, value) { 



  //console.log(index + ':' + $(value).text()); 



  console.log($(this).text());



});*/



		var cname = "";



		var ecount = 0;



		if($("#ctab").val()=="2") {



			cname = "a";



			ecount = etextcounta;



		} else {



			cname = "";



			ecount = etextcount;



		}



		



		ecount = ecount + 1;



		//var fehtml='<tr class="'+cname+'custom'+ecount+'"><th class="one" width="200px">Custom Field <span class="csno"></span></th><td class="two"><input type="text" value="" name="custom'+cname+'[field'+ecount+']" id="'+cname+'field'+ecount+'" /> </td><td class="one"><input type="checkbox" class="chkcustomNum" value="field'+ecount+'" name="customNum'+cname+'[]" /> </td><td class="one"><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+ecount+',\''+cname+'\')">X</span></td><td width="400px">&nbsp;</td></tr><tr class="'+cname+'custom'+(parseInt(ecount) +1)+'"><th class="one">Custom Field <span class="csno"></span></th><td class="two"><input type="text" value="" name="custom'+cname+'[field'+(parseInt(ecount) + 1)+']" id="'+cname+'field'+(parseInt(ecount) +1)+'" /></td><td class="one"><input type="checkbox" class="chkcustomNum" value="field'+(ecount+1)+'" name="customNum'+cname+'[]" /> </td><td class="one"><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+(parseInt(ecount) + 1)+',\''+cname+'\')">X</span></td><td width="400px">&nbsp;</td></tr><tr class="'+cname+'custom'+(parseInt(ecount) + 2)+'"><th class="one">Custom Field <span class="csno"></span></th><td class="two"><input type="text" value="" name="custom'+cname+'[field'+(parseInt(ecount) + 2)+']" id="'+cname+'field'+(parseInt(ecount) + 2)+'" /></td><td class="one"><input type="checkbox" class="chkcustomNum" value="field'+(ecount+1)+'" name="customNum'+cname+'[]" /> </td><td class="one"><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+(parseInt(ecount) + 2)+',\''+cname+'\')">X</span></td><td width="400px">&nbsp;</td></tr>';



		var fehtml='<tr class="'+cname+'custom'+ecount+'"><th class="one" width="200px">Custom Field <span class="csno"></span></th><td class="two"><input type="text" value="" name="custom'+cname+'[field'+ecount+']" id="'+cname+'field'+ecount+'" /> </td><td class="one"><input type="checkbox" class="chkcustomNum" value="field'+ecount+'" name="customNum'+cname+'[]" /> </td><td class="one"><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+ecount+',\''+cname+'\')">X</span></td><td width="400px">&nbsp;</td></tr>';



		



		<?php /*?>var fehtml='<tr class="custom'+etextcount+'"><th class="one">Custom Fields '+etextcount+'</th><td class="two"><input type="text" value="<?php if(isset($custom['field?>'+etextcount+'<?php'])) echo form_prep($custom['field?>'+etextcount+'<?php'])?>" name="custom[field'+etextcount+']" id="field'+etextcount+'" /> <span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+etextcount+')">X</span></td></tr><tr class="custom'+(parseInt(etextcount) +1)+'"><th class="one">Custom Fields'+  (parseInt(etextcount) + 1)+'</th><td class="two"><input type="text" value="<?php if(isset($custom['field?>'+((etextcount) + 1)+'<?php'])) echo form_prep($custom['field?>'+((etextcount) +1)+'<?php'])?>" name="custom[field'+(parseInt(etextcount) + 1)+']" id="field'+(parseInt(etextcount) +1)+'" /><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+(parseInt(etextcount) + 1)+')">X</span></td></tr><tr class="custom'+(parseInt(etextcount) + 2)+'"><th class="one">Custom Fields'+(parseInt(etextcount) + 2)+'</th><td class="two"><input type="text" value="<?php if(isset($custom['field?>'+((etextcount) + 2)+'<?php'])) echo form_prep($custom['field?>'+((etextcount) + 2)+' <?php'])?>" name="custom[field'+(parseInt(etextcount) + 2)+']" id="field'+(parseInt(etextcount) + 2)+'" /><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+(parseInt(etextcount) + 2)+')">X</span></td></tr>';<?php */?>



		



		$("#"+cname+"frmsfield").append(fehtml);



		//$("#"+cname+"kcount").val(ecount+2);

		$("#"+cname+"kcount").val(ecount);



		var i=0;



		$("table #"+cname+"frmsfield th span.csno").each(function(){



			i++;



	        $(this).html(i);



	    });



		//ecount = ecount + 2;

		ecount = ecount;







		if($("#ctab").val()=="2") {		



			etextcounta=ecount;



		} else {



			etextcount=ecount;



		}



	 }



	 



	 //Delete custom field



		function deletesch(schno,prefix='') {



			$("."+prefix+"custom"+schno).remove();



		}

		

		//Reset Contact Layout

	function reset_contact_layout() {

		$("#layout_action").val('reset');

		save_record();

	}

	

	//Reset Contact Layout

	function reset_account_layout() {

		$("#layout_action").val('reset_account');

		save_record();

	}

	

	//Add Contact Layout

	function add_contact_layout() {

		checkStatus();

		$.ajax({

			url: '<?PHP echo base_url('crm/custom_checking'); ?>',

			success: function(data) {

				$(".cadd-column").append(data);

			}

		});

	}

	

	

	//Add Contact Layout

	function add_account_layout() {

		checkStatus();

		$.ajax({

			url: '<?PHP echo base_url('crm/acustom_checking'); ?>',

			success: function(data) {

				$(".acadd-column").append(data);

			}

		});

	}

	

	//Reset Contact Layout

	function ds() {

		$("#layout_action").val('reset_account');

		save_record();

	}

	

	

	

	$(document).ready(function(){

		checkStatus();

	});

	

	function checkStatus()

	{

		$(".tbcol").change(function(){

			var dis=$(this);

			if(dis.val()=="") return;

			var sval = dis.val();

			var c=0;

			$(".tbcol").each(function(){

				if($(this).val()==sval) c++;

			});

			if(c>=2) {

				dis.val("");

				dis.parent().find("span").text("Select");

				alert("Field already selected.");

			}

		});

	}



</script>



<!-- Content ends -->



<?php $this->load->view('common/footer'); ?>