<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>
	<!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>
<style type="text/css">.datepicker{z-index: 90000;}</style>
<!-- Sidebar ends --> <!-- Content begins -->
<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$( "td.edtable" ).hover(
		  function() {
		  	var eicon = '<a href="javascript:void(0);" onclick="edit_column(this);" class="edit"><span class="iconn icon-pencil" data-icon="&amp;#e123;"></span></a>';
			$(this).append(eicon);
		  }, function() {
			$(this).find("a.edit").remove();
		  }		
		);
		$("#birthdate").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
	});
	var ectrl;
	var ebox;
	
	//Edit Column
	function edit_column(dis) {
		$(".erbox").html('');
		ectrl = $(dis).parent();
		ebox = ectrl.attr("data-field");
		$("#eblock").val(ebox);
		$("#crmpopup .qebox .box").hide();
		$("#crmpopup .abox1 span").html($("#crmpopup .qebox .box_"+ebox).attr('title'));
		$("#crmpopup .qebox .box_"+ebox).show();
		$("#crmpopup").show();
		$(".overlayBackground").show();
		if(ebox=="account_id") getLookup('account','account');
	}
	//Hide Fade
	function hide_fade(){
		$(".erbox").html('');
		$("#crmpopup").hide();
		$(".overlayBackground").hide();
		$('#cLookup').hide();
	}
	//Update 
	function save_record()
	{
		$(".erbox").html('');
		$.ajax({
			type : 'POST',
			url : '<?php echo current_url();?>',
			data: $("#frmRecord").serialize(),
			cache: false,
			dataType: 'json',
			success: function(responce)
			{
				if(responce.status=="Y") {
					if(ebox=="target") $("#target").prop('checked',responce.cinfo=="1"?true:false);
					else ectrl.html(responce.cinfo);
					$("#crmpopup .qebox .box_"+ebox).hide();
					hide_fade();
				} else if(responce.status=="N")
					$(".erbox").html('<div class="crm-error">'+responce.error+'</div>');				
			}
		});		
	}
	var objname='';
	//Get Lookup
	function getLookup(rcname,obname) {
		objname = obname;
		var popboxhead = '';
		var ajxmethod='';
		$(".new_account").hide();
		if(rcname=="account") {
			popboxhead = 'Account Lookup';
			ajxmethod='accounts_lookup';
			$("#new_account_name").val('');
			$(".new_account").show();
		} else if(rcname=="contact") {
			popboxhead = 'Contact Lookup';
			ajxmethod='contacts_lookup';
		} else if(rcname=="share") {
			popboxhead = 'Contact Owner';
			ajxmethod='share_user_lookup';
		}
		$("#cLookup .abox1").html(popboxhead);
		$("#cLookup").show();
		$("#cLookup .search-list").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		$( "#cLookup .search-list" ).load( "<?php echo base_url()."crm/"?>"+ajxmethod, function() {
		  $('.dsTable').dataTable({
				"bJQueryUI": false,
				"bAutoWidth": false,
				"sPaginationType": "full_numbers",
				"sDom": '<"H"fl>t<"F"ip>'
			});
			if(rcname=="account") {
				$(".dataTables_filter label span").html("Search to find existing account");
				$(".dataTables_filter").width(370);
			}
		});
	}
	//Set lookup
	function setLookup(dis) {
		$("#"+objname+"_title").val($(dis).html());
		$("#"+objname+"_id").val($(dis).attr("data_id"));
		$("#cLookup").hide();
	}
	//Set New Account Name
	function set_newaccount() {
		if($("#new_account_name").val()=="") {
			alert("Enter new account name");
			$("#new_account_name").focus();
			return;
		}
		$("#account_title").val($("#new_account_name").val());
		$("#account_id").val(0);
		$("#cLookup").hide();
	}
</script>
<div class="overlayBackground" onclick="hide_fade()"></div>
<div id="content">
	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/crm_nav');
	?>
    <div class="formRow crmlite" id="cLookup">
        <div class="qrbox">
            <div class="abox1">Account Lookup</div>
            <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
        </div>
        <div>
            <div class="new_account">
                <div style="float:left; padding:4px;">
                    <b>Enter name to create a new account</b>
                </div>
                <div style="float:left; padding:4px;">
                    <input type="text" id="new_account_name" />
                </div>
                <div style="float:left; padding:4px;">
                    <input type="button" class="buttonM bBlue" onclick="set_newaccount()" value="Add" />
                </div>                	
            </div>
            <div class="search-list"></div>
        </div>
    </div> 
    <div id="crmpopup">
        <div class="formRow">
            <div class="qrbox">
                <div class="abox1">Edit <span>Name</span></div>
                <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>
            <form action="<?php echo current_url();?>" id="frmRecord" method="post" enctype="multipart/form-data">
            	<input type="hidden" name="action" value="update" />
                <input type="hidden" name="eblock" id="eblock" value="" />
                <div id="gh_anbox">     
                    <div>
                    	<div class="qebox">
                        	<div class="erbox"></div>
                        	<div class="box box_target" title="Target Applicant">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Target Applicant</th>
                                        <td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_address" title="Mailing Address">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                        <th class="one">Mailing Street</th><td class="two"><textarea name="record[amail][street]"><?php if(isset($record[amail][street])) echo $record[amail][street]?></textarea></td>
                                    </tr>
                                    <tr>
                                        <th class="one">Mailing City</th><td class="two"><input type="text" value="<?php if(isset($record[amail][city])) echo form_prep($record[amail][city])?>" name="record[amail][city]" /></td>
                                    </tr>
                                    <tr>
                                        <th class="one">Mailing State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[amail][state])) echo form_prep($record[amail][state])?>" name="record[amail][state]" /></td>
                                    </tr>
                                    <tr>
                                        <th class="one">Mailing Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[amail][zipcode])) echo form_prep($record[amail][zipcode])?>" name="record[amail][zipcode]" /></td>
                                    </tr>
                                    <tr style="border-bottom:0px;">
                                        <th class="one">Mailing Country</th><td class="two"><input type="text" value="<?php if(isset($record[amail][country])) echo form_prep($record[amail][country])?>" name="record[amail][country]" /></td>
                                    </tr>
                                </table>
                            </div>
                        	<div class="box box_user_first" title="Name">
                                <table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                        <th>Name</th>
                                        <td>
                                        <select name="record[user_prefix]">
                                            <option value="">None</option>
                                            <option value="Mr."<?php $sel='';if(isset($record[user_prefix]) && $record[user_prefix]=="Mr.") echo $sel=' selected="selected"'?>>Mr.</option>
                                            <option value="Ms."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Ms.") echo $sel=' selected="selected"'?>>Ms.</option>
                                            <option value="Mrs."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Mrs.") echo $sel=' selected="selected"'?>>Mrs.</option>
                                            <option value="Dr."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Dr.") echo $sel=' selected="selected"'?>>Dr.</option>
                                            <option value="Prof."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Prof.") echo $sel=' selected="selected"'?>>Prof.</option>
                                            <?php if(!$sel && !empty($record[user_prefix])){?>
                                            <option value="<?php echo $record[user_prefix];?>" selected="selected"><?php echo $record[user_prefix];?></option>
                                            <?php }?>
                                        </select>
                                        </td>
                                        <td>
                                        <input type="text" value="<?php if(isset($record[user_first])) echo form_prep($record[user_first])?>" name="record[user_first]" id="user_first" />
                                        </td>
                                        <td><input type="text" value="<?php if(isset($record[user_last])) echo form_prep($record[user_last])?>" name="record[user_last]" id="user_last" /></td>
                                    </tr>
                                </table>
                            </div>                            
                           
							<div class="box box_linkedin" title="LinkedIn Profile">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">LinkedIn Profile</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[linkedin])) echo form_prep($record[linkedin])?>" name="record[linkedin]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_website" title="Website">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Website</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[website])) echo form_prep($record[website])?>" name="record[website]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_birthdate" title="Birthdate">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Birthdate</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[birthdate])) echo form_prep($record[birthdate])?>" name="record[birthdate]" id="birthdate" /></td>
                                    </tr>
                                </table>
                            </div>                            
                            <div class="box box_lead_source" title="Lead Source">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Lead Source</th>
                                        <td class="two"><select name="record[lead_source]">
                                            <option value="">None</option>
                                            <option value="External Referral"<?php $sel='';if(isset($record[lead_source]) && $record[lead_source]=="External Referral") echo $sel=' selected="selected"'?>>External Referral</option>
                                            <option value="Web"<?php if(isset($record[lead_source]) && $record[lead_source]=="Web") echo $sel=' selected="selected"'?>>Web</option>
                                            <option value="Phone Inquiry"<?php if(isset($record[lead_source]) && $record[lead_source]=="Phone Inquiry") echo $sel=' selected="selected"'?>>Phone Inquiry</option>
                                            <option value="Partner Referral"<?php if(isset($record[lead_source]) && $record[lead_source]=="Partner Referral") echo $sel=' selected="selected"'?>>Partner Referral</option>
                                            <option value="Purchased List"<?php if(isset($record[lead_source]) && $record[lead_source]=="Purchased List") echo $sel=' selected="selected"'?>>Purchased List</option>
                                            <option value="Other"<?php if(isset($record[lead_source]) && $record[lead_source]=="Other") echo $sel=' selected="selected"'?>>Other</option>                
                                            <?php if(!$sel && !empty($record[lead_source])){?>
                                            <option value="<?php echo $record[lead_source];?>" selected="selected"><?php echo $record[lead_source];?></option>
                                            <?php }?>
                                        </select></td>
                                    </tr>
                                </table>
                            </div>
                           
                            <div class="box box_phone" title="Phone">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Phone</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>
                                    </tr>
                                </table>
                            </div>
                          
                            <div class="box box_mobile" title="Mobile">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Mobile</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[mobile])) echo form_prep($record[mobile])?>" name="record[mobile]" /></td>
                                    </tr>
                                </table>
                            </div>
                           <?php if($ivs=='employee') {?>  <div class="box box_other_phone" title="Other Phone">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Other Phone</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[other_phone])) echo form_prep($record[other_phone])?>" name="record[other_phone]" /></td>
                                    </tr>
                                </table>
                            </div><?php } ?>
                            <div class="box box_email" title="Email">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Email</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[email])) echo form_prep($record[email])?>" name="record[email]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_description" title="Description">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<td class="two"><textarea name="record[description]" style="height:100px;width: 500px;"><?php if(isset($record[description])) echo $record[description]?></textarea></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_custom1_value" title="<?php if(isset($custom['field1'])) echo $custom['field1']?>">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                    	<th class="one"><?php if(isset($custom['field1'])) echo $custom['field1']?></th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[custom1_value])) echo form_prep($record[custom1_value])?>" name="record[custom1_value]" maxlength="100" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_custom2_value" title="<?php if(isset($custom['field2'])) echo $custom['field2']?>">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                    	<th class="one"><?php if(isset($custom['field2'])) echo $custom['field2']?></th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[custom2_value])) echo form_prep($record[custom2_value])?>" name="record[custom2_value]" maxlength="100" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_custom3_value" title="<?php if(isset($custom['field3'])) echo $custom['field3']?>">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                    	<th class="one"><?php if(isset($custom['field3'])) echo $custom['field3']?></th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[custom3_value])) echo form_prep($record[custom3_value])?>" name="record[custom3_value]" maxlength="100" /></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if($ivs=='applicant') {?>
                            <div class="box box_job_applied_for" title="Job Applied For">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <th class="one">Job Applied For</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[job_applied_for])) echo form_prep($record[job_applied_for])?>" name="record[job_applied_for]" maxlength="100" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_stage" title="Stage">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <th class="one">Stage</th>
                                        <td class="two">
                                            <select name="record[stage]">
                                                <option value=""></option>
                                                <option value="Applied"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Applied") echo $sel=' selected="selected"'?>>Applied</option>
                                                <option value="Pre-Interview"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Pre-Interview") echo $sel=' selected="selected"'?>>Pre-Interview</option>
                                                <option value="Interview Round 1"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Interview Round 1") echo $sel=' selected="selected"'?>>Interview Round 1</option>
                                                <option value="Interview Round 2"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Interview Round 2") echo $sel=' selected="selected"'?>>Interview Round 2</option>
                                                <option value="Interview Round 3"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Interview Round 3") echo $sel=' selected="selected"'?>>Interview Round 3</option>
                                                <option value="Offer Presented"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Offer Presented") echo $sel=' selected="selected"'?>>Offer Presented</option>
                                                <option value="Offer Accepted"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Offer Accepted") echo $sel=' selected="selected"'?>>Offer Accepted</option>
                                                <option value="Paperwork Processed"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Paperwork Processed") echo $sel=' selected="selected"'?>>Paperwork Processed</option>
                                                <option value="Converted to Employee"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Converted to Employee") echo $sel=' selected="selected"'?>>Converted to Employee</option>
                                                <option value="Disqualified"<?php $sel='';if(isset($record[stage]) && $record[stage]=="Disqualified") echo $sel=' selected="selected"'?>>Disqualified</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>	
                            <?php }?>	
                            <div class="box box_pay_rate" title="Pay Rate">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <th class="one">Pay Rate</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[pay_rate])) echo form_prep($record[pay_rate])?>" name="record[pay_rate]" maxlength="100" /></td>
                                    </tr>
                                </table>
                            </div>				
							
                            
                        </div>
                        <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                            <a href="javascript:void(0);" class="buttonM bGreen" onclick="hide_fade()">Cancel</a>
                            <a href="javascript:void(0);" class="buttonM bRed" onclick="save_record()">Save</a>
                        </div>
                    </div><br clear="all" />
                </div>
                
            </form>
        </div>
    </div>
	<!-- Main content -->
    <div class="main-wrapper crmlite"> 
    	<div class="crm-menu"> 
			<?php if($ivs=='employee') {?>
            <a href="<?php echo base_url();?>interviewer/employee" class="buttonM bBlack">Back</a> 
            <a href="<?php echo base_url();?>interviewer/employee/edit/<?php echo $record[contact_id]?>" class="buttonM bBlack">Edit</a> 
            <a href="<?php echo base_url();?>interviewer/employee/delete/<?php echo $record[contact_id]?>" onclick="if(!confirm('Are you sure you want to delete this contact?')) return false;" class="buttonM bBlack">Delete</a> 
			<div align="center" style="float:right;"> 
			<?php if($record[atype]) {?>     
			<a href="<?php echo base_url();?>interviewer/employee/d2a/<?php echo $record[contact_id]?>" class="buttonM bRed">Demote to Applicant</a>
			<?php } else{ ?>
			<a href="<?php echo base_url();?>interviewer/employee/p2e/<?php echo $record[contact_id]?>" class="buttonM bRed">Promote to Employee</a>
			 <?php } }else {?>
			 <a href="<?php echo base_url();?>interviewer/applicant" class="buttonM bBlack">Back</a> 
            <a href="<?php echo base_url();?>interviewer/applicant/edit/<?php echo $record[contact_id]?>" class="buttonM bBlack">Edit</a> 
            <a href="<?php echo base_url();?>interviewer/applicant/delete/<?php echo $record[contact_id]?>" onclick="if(!confirm('Are you sure you want to delete this contact?')) return false;" class="buttonM bBlack">Delete</a> 
			<div align="center" style="float:right;"> 
             <a href="<?php echo base_url();?>interviewer/compose/<?php echo $record[contact_id]?>" class="buttonM bRed">Send Email</a>
			<?php if($record[atype]) {?>     
			<a href="<?php echo base_url();?>interviewer/applicant/d2a/<?php echo $record[contact_id]?>" class="buttonM bRed">Demote to Applicant</a>
			<?php } else{ ?>
			<a href="<?php echo base_url();?>interviewer/applicant/p2e/<?php echo $record[contact_id]?>" class="buttonM bRed">Promote to Employee</a>
			<?php } ?>
            <a href="<?php echo base_url();?>interviewer/qualifier/applicant/<?php echo $record[contact_id]?>" class="buttonM bRed">Applicant Qualifier</a>
			<?php  }?>
			</div>
        </div>
        <?php if($error) {?>
        <div class="crm-error"><?php echo implode("<br />",$error);?></div>
        <?php }//echo "<pre>";print_r($rowsdata);echo "</pre>";?>
		<!-- Main content -->
        <div>
		<table cellpadding="0" cellspacing="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" width="100%" border="0" align="center" class="contact-list view">
            <tbody>
            	<?php /*?><tr>
                	<th class="one">Shared User ID</th><td class="two"></td><th class="one">Phone</th><td class="two"><?php echo $record[phone]?></td>
                </tr><?php */?>
                <tr>
                	<th class="one">Record Owner</th><td class="two"><?php echo ucfirst($record[share_user_title])?></td><td class="gap"></td>
                    <th class="one">Target Applicant</th><td class="two edtable" data-field="target"><input type="checkbox" id="target" disabled="disabled" <?php if($record[target]) echo ' checked="checked"'?> /></td>
                    <td class="gap"></td>
                    <th class="one">Mailing Address</th><td class="two edtable" data-field="address"><?php $adr_mail=array_filter($record[amail]);unset($adr_mail['parent_id']);unset($adr_mail['adr_type']);unset($adr_mail['parent_type']); echo implode(", ",$adr_mail);?></td>
                </tr>
                <tr>
                	<th class="one">Name</th><td class="two edtable" data-field="user_first"><?php echo $record[user_prefix].' '.ucfirst($record[user_first].' '.$record[user_last])?></td><td class="gap"></td>
                	<th class="one">LinkedIn Profile</th><td class="two edtable" data-field="linkedin"><?php if($record[linkedin]) echo '<a href="'.$record[linkedin].'" target="_blank">View Profile</a>';?></td><td class="gap"></td>
                    <th class="one">Birthdate</th><td class="two edtable" data-field="birthdate"><?php echo $record[birthdate]?></td>                    
                </tr>                
                <tr>
                	<?php if($ivs=='employee') {?><th class="one">Website</th><td class="two edtable" data-field="website"><?php if($record[website]) echo '<a href="'.$record[website].'" target="_blank">'.$record[website].'</a>';?></td><td class="gap"></td> <?php } ?>
					<th class="one">Phone</th><td class="two edtable" data-field="phone"><?php if($record[phone]) echo '<a href="tel:'.$record[phone].'">'.$record[phone].'</a>';?></td><td class="gap"></td>
                    <th class="one">Created</th><td class="two"><?php echo date("m/d/Y",strtotime($record[create_date]))?></td><td class="gap"></td>
                    <?php if($ivs=='applicant') {?>
                    <th class="one">Job Applied For</th><td class="two edtable" data-field="job_applied_for"><?php echo $record[job_applied_for]?></td>
                    <?php }?>
                </tr>
                <tr>
                	<th class="one">Mobile</th><td class="two edtable" data-field="mobile"><?php if($record[mobile]) echo '<a href="tel:'.$record[mobile].'">'.$record[mobile].'</a>';?></td><td class="gap"></td>                             
                    <?php if($ivs=='employee') {?><th class="one">Subscribe Status</th><td class="two" style="color:#FF0000;"><?php if($record[unsubscribed]) echo 'Unsubscribed';?></td><td class="gap"></td><?php } ?>
					 <th class="one">Last Modified</th><td class="two"><?php echo date("m/d/Y",strtotime($record[modify_date]))?></td><td class="gap"></td>
                     <?php if($ivs=='applicant') {?>
                    <th class="one">Stage</th><td class="two edtable" data-field="stage"><?php echo $record[stage]?></td>
                    <?php }?>
                </tr>
                <tr>                	
                	<?php if($ivs=='employee') {?> <th class="one">Other Phone</th><td class="two edtable" data-field="other_phone"><?php if($record[other_phone]) echo '<a href="tel:'.$record[other_phone].'">'.$record[other_phone].'</a>';?></td><td class="gap"></td>   <?php } ?>             	
                    
                   <?php if($ivs=='employee') {?> <th class="one" id="custom1_title"><?php if(isset($custom['field1'])) echo $custom['field1']?></th><td class="two edtable" data-field="custom1_value" id="custom1_value"><?php echo $record[custom1_value]?></td><?php } ?>
                </tr>
                <tr>
                	<th class="one">Email</th><td class="two edtable" data-field="email"><?php if($record[email]) echo '<a href="mailto:'.$record[email].'">'.$record[email].'</a>';?></td><td class="gap"></td>
                    <th class="one">Pay Rate</th><td class="two edtable" data-field="pay_rate"><?php if(isset($record['pay_rate'])) echo $record['pay_rate']?></td><td class="gap"></td>
                   <?php if($ivs=='employee') {?> <th class="one" id="custom2_title"><?php if(isset($custom['field2'])) echo $custom['field2']?></th><td class="two edtable" data-field="custom2_value" id="custom2_value"><?php echo $record[custom2_value]?></td>
				   <?php } ?>
                   
                </tr>
                <tr>
                    <?php if($ivs=='employee') {?><th class="one">Description</th><td class="two edtable" data-field="description" colspan="4"><?php echo str_replace("\n","<br>",$record[description])?></td><td class="gap"></td><?php } ?>
                    <?php if($ivs=='employee') {?><th class="one" id="custom3_title"><?php if(isset($custom['field3'])) echo $custom['field3']?></th><td class="two edtable" data-field="custom3_value" id="custom3_value"><?php echo $record[custom3_value]?></td><?php } ?>
                </tr>
            </tbody>
        </table><hr/>
         <?php if($ivs=='applicant') { ?>
         <?php if($total_points){?> 
        <div class="subsections chart">
       
        	<table cellpadding="0" cellspacing="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" width="100%" border="0" align="center" class="contact-list view">
            	<tr>
                	<th>Quality Points:<?php echo $total_points[ipt]?></th>
                    <th>Pursuit Points:<?php echo $total_points[ppt]?></th>
                    <th>
                    	<select id="chartfilter" onchange="updategraph(this.value)">	
                        	<option value="0">Last 7 Days</option>
                            <option value="1" <?php if($gft==1) echo ' selected="selected"';?>>Last 30 Days</option>
                            <option value="2" <?php if($gft==2) echo ' selected="selected"';?>>>This Month</option>
                            <option value="3" <?php if($gft==3) echo ' selected="selected"';?>>>Last Month</option>
                            <option value="4" <?php if($gft==4) echo ' selected="selected"';?>>>Last 3 Months</option>
                            <option value="5" <?php if($gft==5) echo ' selected="selected"';?>>>Last 6 Months</option>
                            <option value="6" <?php if($gft==6) echo ' selected="selected"';?>>>Last Year</option>
                        </select>
                    </th>
                </tr>
            </table>
        <!--<hr /><div id="chart_div"></div>-->
         <div id="chart_div"></div>
        </div><hr />
        <script src="<?php echo base_url();?>js/chart-loader.js"></script>
<script type="text/javascript">
//var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
var graphData = <?php echo $chartData;?>;//alert(graphData);
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawLineColors);

function drawLineColors() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'Quality Points');
      data.addColumn('number', 'Pursuit Points');

      <?php /*?>data.addRows([
        ['Day 1', 0, 0],    ['Day 2', 10, 5]
      ]);<?php */?>
      <?php /*?>data.addRows([<?php echo $chartData;?>]);<?php */?>
      //var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
      data.addRows(graphData);    
      var gDL=graphData.length;   
      var sTE=1;
      if($("#chartfilter").val()=="2") {
        if(gDL>15) sTE=3;
      } else if($("#chartfilter").val()=="1" || $("#chartfilter").val()=="3") sTE=3;
      else if($("#chartfilter").val()=="4") sTE=15;
      else if($("#chartfilter").val()=="5") sTE=15;
      else if($("#chartfilter").val()=="6") sTE=30;
      /*if(gDL>8 && gDL<=32) sTE=2;
      else if(gDL>32 && gDL<=115) sTE=7;
      else if(gDL>115 && gDL<=210) sTE=15;
      else if(gDL>210) sTE=30;
      console.log("L:"+gDL+" S:"+sTE);*/

      var options = {
        hAxis: {
          title: 'Date',
          showTextEvery : sTE
        },
        vAxis: {
          title: 'Points'
        },
        colors: ['#56458c', '#8ab529'],
        pointShape : 'circle',
        pointsVisible : true 
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    var gd3;
    //update graph data
    function updategraph(val)
    {
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'gft='+val+'&cid=<?php echo $record[contact_id]?>&action=graph',
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                graphData=responce;
                drawLineColors();   
            }
        });
    }
</script>        
        <?php } }?>
        </div>
      
         
		  
		 
		
		
		<?php if($ivs=='applicant') { ?>
		<div class="subsections"><b>Attached Documents</b>  <a href="<?php echo base_url('interviewer/notes/docu/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list5,"ntype"=>"docu"));?>
        </div><hr />
		 
		 <div class="subsections"><b>Experience</b> <a href="<?php echo base_url('interviewer/notes/exp/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/exp/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list2,"ntype"=>"exp"));?>
        </div><hr />
		
		 <div class="subsections"><b>Education</b> <a href="<?php echo base_url('interviewer/notes/edu/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/edu/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list3,"ntype"=>"edu"));?>
        </div><hr />
		
		 <div class="subsections"><b>Skills, Certifications, Associations, and Hobbies</b> <a href="<?php echo base_url('interviewer/notes/skill/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/skill/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list4,"ntype"=>"skill"));?>
        </div><hr />
		
		
		 <div class="subsections"><b>Open Activities</b> 
        	<a href="<?php echo base_url('interviewer/tasks/applicant/'.$record[contact_id].'/edit');?>">New</a>
        </div>
        <div>
        	<?php $this->load->view('interview/app-task-open-list');?>
        </div><hr /> 
		 
		 <div class="subsections"><b>Activity History</b> <a href="<?php echo base_url('interviewer/tasks/applicant/'.$record[contact_id]);?>">View All</a></div>
        <div>
        	<?php $this->load->view('interview/app-task-active-list');?>
        </div><hr />
		
		<div class="subsections"><b>Notes</b> <a href="<?php echo base_url('interviewer/notes/note/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/note/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list,"ntype"=>"note"));?>
        </div><hr />
		
		    
	</div>
	<?php } ?>
    <!-- Main content ends -->
</div>

<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
