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

<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">
	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/crm_nav');
	?>
	<!-- Main content -->
    <div class="main-wrapper">
        <div class="formRow crmlite" id="cLookup">
            <div class="qrbox">
                <div class="abox1">Account Lookup</div>
                <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
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
        
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
        <form method="post" onsubmit="return save_record();" action="<?php echo current_url();?>"  enctype="multipart/form-data">
        	<input type="hidden" name="action" value="save" />
			<?php if($record['atype']==2){ ?><input type="hidden" name="record[atype]" value="<?php echo $record['atype']; ?>" /><?php }?>
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<?php if($record['atype']==2){ ?><th class="title" colspan="4">Your Profile Information</th><?php } else {?>
				<th class="title" colspan="4">Applicant Information</th><?php } ?>
            </tr>
            <?php /*?><tr>
                <th class="one">Shared User ID</th><td class="two"><input type="text" /></td><th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>
            </tr><?php */?>
            <tr>
                <th class="one">Record Owner</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[share_user_id])) echo form_prep($record[share_user_id])?>" name="record[share_user_id]" id="share_user_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[share_user_title])) echo form_prep($record[share_user_title])?>" name="record[share_user_title]" id="share_user_title" />
                <?php //if(!$record[contact_id] || $record[userid]==$user_id){?>
                <a href="javascript:void(0);" onclick="getLookup('share','share_user');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                <?php //}?>
                </td>
                <?php if($record['atype']==2){ ?>
                <th class="one">Check to make your profile visible to employers</th><td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>
                <?php }else{?>
                <th class="one">Target Applicant</th><td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>
                <?php }?>
                
            </tr>
            <tr>
                <th class="one">First Name*</th><td class="two">
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
                <input type="text" value="<?php if(isset($record[user_first])) echo form_prep($record[user_first])?>" name="record[user_first]" id="user_first" /></td>
                <th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>
            </tr>
            <tr>
                <th class="one">Last Name*</th><td class="two"><input type="text" value="<?php if(isset($record[user_last])) echo form_prep($record[user_last])?>" name="record[user_last]" id="user_last" /></td>
                <th class="one">Mobile</th><td class="two"><input type="text" value="<?php if(isset($record[mobile])) echo form_prep($record[mobile])?>" name="record[mobile]" /></td>
            </tr>            
            <tr>
                <?php if($ivs=='employee') {?><th class="one">Other Phone</th><td class="two"><input type="text" value="<?php if(isset($record[other_phone])) echo form_prep($record[other_phone])?>" name="record[other_phone]" /></td><?php } ?>
				 <th class="one">Email</th><td class="two"><input type="text" value="<?php if(isset($record[email])) echo form_prep($record[email])?>" name="record[email]" id="user_email" /></td>
                               
            </tr>
            <tr>
                <th class="one">Birthdate</th><td class="two"><input type="text" value="<?php if(isset($record[birthdate])) echo form_prep($record[birthdate])?>" name="record[birthdate]" id="birthdate" /></td>
				<th class="one">LinkedIn Profile</th>
				<td class="two">
                <input type="text" value="<?php if(isset($record[linkedin])) echo form_prep($record[linkedin])?>" name="record[linkedin]" id="linkedin" /></td>
            </tr>
            <?php if($ivs=='applicant') {?>			
            <tr>
                <th class="one">Job Applied For</th>
                <td class="two"><input type="text" value="<?php if(isset($record[job_applied_for])) echo form_prep($record[job_applied_for])?>" name="record[job_applied_for]" /></td>
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
            <?php }?>
            <tr>
                <?php if($ivs=='employee') {?><th class="one">Website</th><td class="two"><input type="text" value="<?php if(isset($record[website])) echo form_prep($record[website])?>" name="record[website]" /></td><?php } ?>
				 <?php if($ivs=='employee') {?><th class="one"><?php if(isset($custom['field1'])) echo $custom['field1']?></th>
				<td class="two">
                <input type="text" value="<?php if(isset($record[custom1_value])) echo form_prep($record[custom1_value])?>" name="record[custom1_value]" id="custom1_value" maxlength="100" /></td><?php } ?>
            </tr>
            <?php if($ivs=='employee') {?>
            <tr>
                <th class="one"><?php if(isset($custom['field2'])) echo $custom['field2']?></th><td class="two"><input type="text" value="<?php if(isset($record[custom2_value])) echo form_prep($record[custom2_value])?>" name="record[custom2_value]" maxlength="100" /></td>
				<th class="one"><?php if(isset($custom['field3'])) echo $custom['field3']?></th>
				<td class="two">
                <input type="text" value="<?php if(isset($record[custom3_value])) echo form_prep($record[custom3_value])?>" name="record[custom3_value]" id="custom3_value" maxlength="100" /></td>
            </tr>
            <?php } ?>
            <tr>
                <th class="one">Pay Rate</th><td class="two"><input type="text" value="<?php if(isset($record[pay_rate])) echo form_prep($record[pay_rate])?>" name="record[pay_rate]" id="pay_rate" /></td>
            </tr>
			<tr><th>&nbsp;</th></tr>
        	
            <tr>
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Address Information</th>
            </tr>
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
            <tr><th>&nbsp;</th></tr>
        	<?php if($ivs=='employee') {?><tr>
            	<th class="title" colspan="4">Description Information</th>
            </tr>
            <tr>
                <th class="one">Description</th><td class="two"><textarea name="record[description]" style="height:100px;"><?php if(isset($record[description])) echo $record[description]?></textarea></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr><?php } ?>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
						<?php if($record[atype]==2) { ?>
                        <a href="<?php echo base_url();?>interviewer/yourprofile" class="buttonM bRed">Back</a>
						<?php } else {?>
						 <a href="<?php echo base_url();?>interviewer/applicant" class="buttonM bRed">Back</a><?php } ?>
                    </div>
                </td>
            </tr>
        </table>		
        </form>
	</div>
    <!-- Main content ends -->    
</div>
<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	//Save record
	function save_record(){
		if($("#user_first").val().length==0) {
			alert("First Name required");
			$("#user_first").focus();
			return false;
		}
		if($("#user_last").val().length==0) {
			alert("Last Name required");
			$("#user_last").focus();
			return false;
		}
		return true;
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
	$(document).ready(function(){
		$("#birthdate").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
		<?php
			//Email guesser contact details
			$pam4 = $this->uri->segment(4);
			if($pam4 && substr($pam4,0,2)=="cc") {
		?>
		if(localStorage.getItem("cm_<?php echo $pam4?>_fname")!=null) 
			$("#user_first").val(localStorage.getItem("cm_<?php echo $pam4?>_fname"));
		if(localStorage.getItem("cm_<?php echo $pam4?>_lname")!=null) 
			$("#user_last").val(localStorage.getItem("cm_<?php echo $pam4?>_lname"));
		if(localStorage.getItem("cm_<?php echo $pam4?>_email")!=null) 
			$("#user_email").val(localStorage.getItem("cm_<?php echo $pam4?>_email"));	
		<?php	
			}
		?>
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>