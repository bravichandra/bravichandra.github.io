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
    <div class="main-wrapper crmlite">    	
        <div class="formRow crmlite" id="cLookup">
            <div class="qrbox">
                <div class="abox1">Account Lookup</div>
                <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>
            <div class="search-list"></div>
        </div>
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
        <form method="post" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="4">Task Information</th>
            </tr>
            <tr>
                <th class="one">Assigned To</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[share_user_id])) echo form_prep($record[share_user_id])?>" name="record[share_user_id]" id="share_user_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[share_user_title])) echo form_prep($record[share_user_title])?>" name="record[share_user_title]" id="share_user_title" />
                <?php //if(!$record[task_id] || $record[userid]==$user_id){?>
                <a href="javascript:void(0);" onclick="getLookup('share','share_user');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                <?php //}?>
                </td>
				<th class="one">Priority*</th><td class="two">
                <select name="record[task_priority]">
                	<option value="High">High</option>
                    <option value="Normal"<?php if(isset($record[task_priority]) && $record[task_priority]=="Normal") echo ' selected="selected"'?>>Normal</option>
                    <option value="Low"<?php if(isset($record[task_priority]) && $record[task_priority]=="Low") echo ' selected="selected"'?>>Low</option>
                </select>
                </td>                
            </tr>
            <tr>
                <th class="one">Subject*</th><td class="two"><input type="text" value="<?php if(isset($record[task_subject])) echo form_prep($record[task_subject])?>" name="record[task_subject]" id="task_subject" /></td><th class="one">Status*</th><td class="two">
                <select name="record[task_status]">
                	<option value="Not Started">Not Started</option>
                    <option value="In Progress"<?php if(isset($record[task_status]) && $record[task_status]=="In Progress") echo ' selected="selected"'?>>In Progress</option>
                    <option value="Completed"<?php if(isset($record[task_status]) && $record[task_status]=="Completed") echo ' selected="selected"'?>>Completed</option>
                    <option value="Waiting on someone else"<?php if(isset($record[task_status]) && $record[task_status]=="Waiting on someone else") echo ' selected="selected"'?>>Waiting on someone else</option>
                    <option value="Deferred"<?php if(isset($record[task_status]) && $record[task_status]=="Deferred") echo ' selected="selected"'?>>Deferred</option>
                </select></td>
            </tr>
            <tr>
                <th class="one">Due Date</th><td class="two"><input type="text" value="<?php if(isset($record[task_duedate])) echo form_prep($record[task_duedate])?>" name="record[task_duedate]" id="task_duedate" /></td><th class="one">Related To *</th><td class="two">
                <select name="record[task_related]" id="task_related">
                	<option value="C">Contacts</option>
                    <option value="A"<?php if(isset($record[task_related]) && $record[task_related]=="A") echo ' selected="selected"'?>>Account</option>
                    <?php /*?><option value="O"<?php if(isset($record[task_related]) && $record[task_related]=="O") echo ' selected="selected"'?>>Opportunity</option><?php */?>
                </select>
                <input type="hidden" value="<?php if(isset($record[task_relatedto])) echo form_prep($record[task_relatedto])?>" name="record[task_relatedto]" id="related_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[related_title])) echo form_prep($record[related_title])?>" name="record[related_title]" id="related_title" /><a href="javascript:void(0);" onclick="getLookup('related','related');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                </td>
            </tr>
            <tr>
                <th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[task_phone])) echo form_prep($record[task_phone])?>" name="record[task_phone]" /></td><th class="one">Email</th><td class="two"><input type="text" value="<?php if(isset($record[task_email])) echo form_prep($record[task_email])?>" name="record[task_email]" /></td>
            </tr>    
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Description Information</th>
            </tr>
            <tr style="border-bottom:0px;">
                <th class="one">Comments</th><td class="two" colspan="3"><textarea name="record[task_info]" style="height:100px;"><?php if(isset($record[task_info])) echo $record[task_info]?></textarea></td>
            </tr>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <a href="<?php echo base_url();?>crm/<?php echo ($parent_id?$parent_section."/view/".$parent_id:'tasks');?>" class="buttonM bRed">Back</a>
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
	//Skip hint
	function save_record(){
		if($("#task_subject").val().length==0) {
			alert("Subject required");
			$("#task_subject").focus();
			return false;
		}
		if($("#task_related").val().length==0) {
			alert("Select related to Contact/Account");
			$("#task_related").focus();
			return false;
		}
		if($("#related_title").val().length==0) {
			alert("Subject related to");
			$("#related_title").focus();
			return false;
		}
		return true;
	}
	$(document).ready(function(){
		$('#task_duedate').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
		$('#task_related').change(function(e){
			$("#related_title").val('');
			$("#related_id").val(0);
		});
	});
	var objname='';
	//Get Lookup
	function getLookup(rcname,obname) {
		if(rcname!="share")
			rcname=$("#task_related").val();
		objname = obname;
		var popboxhead = '';
		var ajxmethod='';
		if(rcname=="A") {
			popboxhead = 'Account Lookup';
			ajxmethod='accounts_lookup';
            rcname="account";
            $("#cLookup .abox1").html(popboxhead);
            Records_getLookup(rcname,obname);return;
		} else if(rcname=="C") {
			popboxhead = 'Contact Lookup';
			ajxmethod='contacts_lookup';
            rcname="contact";
            $("#cLookup .abox1").html(popboxhead);
            Records_getLookup(rcname,obname);return;
		} else if(rcname=="share") {
			popboxhead = 'Assigned To';
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
		});
	}
	//Set lookup
	function setLookup(dis) {
		$("#"+objname+"_title").val($(dis).html());
		$("#"+objname+"_id").val($(dis).attr("data_id"));
		$("#cLookup").hide();
	}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>