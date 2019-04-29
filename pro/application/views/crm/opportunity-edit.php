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
	//$stages= array("Prospecting","Qualification","Needs Analysis","Value Proposition","Id. Decision Makers","Perception Analysis","Proposal/Price Quote","Negotiation/Review","Closed Won","Closed Lost");
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
            <?php if($contact_id){?>
            <input type="hidden" name="record[contact_id]" value="<?php echo (int)$contact_id;?>" />
            <?php }?>
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="4">Opportunity Information</th>
            </tr>
            <tr>
                <th class="one">Opportunity Owner</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[share_user_id])) echo form_prep($record[share_user_id])?>" name="record[share_user_id]" id="share_user_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[share_user_title])) echo form_prep($record[share_user_title])?>" name="record[share_user_title]" id="share_user_title" />
                <?php //if(!$record[oppt_id] || $record[userid]==$user_id){?>
                <a href="javascript:void(0);" onclick="getLookup('share','share_user');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                <?php //}?>
                </td>
                <th class="one">Amount</th><td class="two"><input type="text" value="<?php if(isset($record[amount]) && $record[amount]) echo form_prep($record[amount])?>" name="record[amount]" /></td>
            </tr>
            <tr>
                <th class="one">Private</th><td class="two"><input type="checkbox" value="1" <?php if(isset($record[user_private]) && $record[user_private]) echo ' checked="checked"'?> name="record[user_private]" /></td><th class="one">Close Date*</th><td class="two"><input type="text" value="<?php if(isset($record[close_date])) echo form_prep($record[close_date])?>" name="record[close_date]" id="close_date" /></td>
            </tr>
            <tr>
                <th class="one">Opportunity Name*</th><td class="two"><input type="text" value="<?php if(isset($record[oppt_name])) echo form_prep($record[oppt_name])?>" name="record[oppt_name]" id="oppt_name" /></td><th class="one">Next Step</th><td class="two"><input type="text" value="<?php if(isset($record[next_step])) echo form_prep($record[next_step])?>" name="record[next_step]" /></td>
            </tr>
            <tr>
            	 <th class="one">Contact</th><td class="two">
                	<input type="hidden" value="<?php if(isset($record[contact_id])) echo form_prep($record[contact_id])?>" name="record[contact_id]" id="contact_id" />
                	<input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title])?>" name="record[contact_title]" id="contact_id_title" /><a href="javascript:void(0);" onClick="Records_getLookup('contact','contact_id');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>               </td>
                <th class="one">Account Name</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[account_id])) echo form_prep($record[account_id])?>" name="record[account_id]" id="account_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_title" /><a href="javascript:void(0);" onclick="Records_getLookup('account','account');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                </td>
            </tr>    
            <tr>
                <th class="one">Type</th><td class="two">
                <select name="record[oppt_type]">
                	<option value="">None</option>
                    <option value="Existing Customer - Upgrade"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="Existing Customer - Upgrade") echo ' selected="selected"'?>>Existing Customer - Upgrade</option>
                    <option value="Existing Customer - Replacement"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="Existing Customer - Replacement") echo ' selected="selected"'?>>Existing Customer - Replacement</option>
                    <option value="Existing Customer - Downgrade"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="Existing Customer - Downgrade") echo ' selected="selected"'?>>Existing Customer - Downgrade</option>
                    <option value="New Customer"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="New Customer") echo ' selected="selected"'?>>New Customer</option>
                </select>
                <th class="one">Stage*</th><td class="two">
                <select name="record[stage]" id="stage">
                	<?php foreach($stage as $aval){?>
                    <option value="<?php echo $aval;?>"<?php if(isset($record[stage]) && $record[stage]==$aval) echo ' selected="selected"'?>><?php echo $aval;?></option>
                    <?php }?>
                    </select>
                </td>
            </tr>
            <tr style="border-bottom:0px;">
                <th class="one">Lead Source</th><td class="two"><select name="record[lead_source]">
                	<option value="">None</option>
                    <?php	foreach($lead as $led){ ?>
                 		<option value="<?php echo $led ?>"<?php $sel='';if(isset($record[lead_source]) && $record[lead_source]==$led) echo $sel=' selected="selected"'?>><?php echo $led; ?></option>
				<?php }  ?>                
                </select></td>
                </td><th class="one">Probability (%)</th><td class="two"><input type="text" value="<?php if(isset($record[probability]) && $record[probability]) echo form_prep($record[probability])?>" name="record[probability]" /></td>
            </tr>
            <tr style="border-bottom:0px;">
            	<th class="one">Primary Campaign Source</th><td class="two"><input type="text" value="" /></td>
            </tr>
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Additional Information</th>
            </tr>    
            <tr>
                <th class="one">Order Number</th><td class="two"><input type="text" value="<?php if(isset($record[order_number])) echo form_prep($record[order_number])?>" name="record[order_number]" /></td><th class="one">Main Competitor(s)</th><td class="two"><input type="text" value="<?php if(isset($record[main_competitor])) echo form_prep($record[main_competitor])?>" name="record[main_competitor]" /></td>
            </tr>    
            <tr>
                <th class="one">Current Generator(s)</th><td class="two"><input type="text" value="<?php if(isset($record[cur_generators])) echo form_prep($record[cur_generators])?>" name="record[cur_generators]" /></td><th class="one">Delivery/Installation Status</th><td class="two">
                <select name="record[delivery_status]">
                	<option value="">None</option>
                    <option value="In progress"<?php if(isset($record[delivery_status]) && $record[delivery_status]=="In progress") echo ' selected="selected"'?>>In progress</option>
                    <option value="Yet to begin"<?php if(isset($record[delivery_status]) && $record[delivery_status]=="Yet to begin") echo ' selected="selected"'?>>Yet to begin</option>
                    <option value="Completed"<?php if(isset($record[delivery_status]) && $record[delivery_status]=="Completed") echo ' selected="selected"'?>>Completed</option>
                </select>
                </td>
            </tr>   
            <tr style="border-bottom:0px;">
                <th class="one">Tracking Number</th><td class="two"><input type="text" value="<?php if(isset($record[track_number])) echo form_prep($record[track_number])?>" name="record[track_number]" /></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr>
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Description Information</th>
            </tr>
            <tr>
                <th class="one">Description</th><td class="two"><textarea name="record[description]" style="height:100px;"><?php if(isset($record[description])) echo $record[description]?></textarea></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <a href="<?php echo base_url();?>crm/opportunities" class="buttonM bRed">Back</a>
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
		if($("#close_date").val().length==0) {
			alert("Close date required");
			$("#close_date").focus();
			return false;
		}
		if($("#oppt_name").val().length==0) {
			alert("Opportunity name required");
			$("#oppt_name").focus();
			return false;
		}
		if($("#stage").val().length==0) {
			alert("Stage required");
			$("#stage").focus();
			return false;
		}
		return true;
	}
	$(document).ready(function(){
		$('#close_date').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
	});
	var objname='';
	//Get Lookup
	function getLookup(rcname,obname) {
		objname = obname;
		var popboxhead = '';
		var ajxmethod='';
		if(rcname=="account") {
			popboxhead = 'Account Lookup';
			ajxmethod='accounts_lookup';
		} else if(rcname=="share") {
			popboxhead = 'Opportunity Owner';
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