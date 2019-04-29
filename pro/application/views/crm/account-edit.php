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
	$account_types= array("Prospect","Customer - Direct","Customer - Channel","Channel Partner / Reseller","Installation Partner","Technology Partner","Other");
	$industries = array("Agriculture","Apparel","Banking","Biotechnology","Chemicals","Communications","Construction","Consulting","Education","Electronics","Energy","Engineering","Entertainment","Environmental","Finance","Food & Beverage","Government","Healthcare","Hospitality","Insurance","Machinery","Manufacturing","Media","Not For Profit","Recreation","Retail","Shipping","Technology","Telecommunications","Transportation","Utilities","Other");
	?>
	<!-- Main content -->
    <div class="main-wrapper">
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
            	<th class="title" colspan="4">Account Information</th>
            </tr>
            <tr>
                <th class="one">Account Owner</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[share_user_id])) echo form_prep($record[share_user_id])?>" name="record[share_user_id]" id="share_user_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[share_user_title])) echo form_prep($record[share_user_title])?>" name="record[share_user_title]" id="share_user_title" />
                <?php //if(!$record[account_id] || $record[userid]==$user_id){?>
                <a href="javascript:void(0);" onclick="getLookup('share','share_user');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                <?php //}?>
                </td>
                <th class="one">Target Account</th><td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>
            </tr>
            <tr>
                <th class="one">Account Name*</th><td class="two"><input type="text" value="<?php if(isset($record[account_name])) echo form_prep($record[account_name])?>" name="record[account_name]" id="account_name" /></td><th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>
            </tr>
            <tr>
                <th class="one">Parent Account</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[account_parent])) echo form_prep($record[account_parent])?>" name="record[account_parent]" id="account_parent_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_parent_title" /><a href="javascript:void(0);" onclick="Records_getLookup('account','account_parent');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                </td><th class="one">Fax</th><td class="two"><input type="text" value="<?php if(isset($record[fax])) echo form_prep($record[fax])?>" name="record[fax]" /></td>
            </tr>
            <tr>
                <th class="one">Account Number</th><td class="two"><input type="text" value="<?php if(isset($record[account_number])) echo form_prep($record[account_number])?>" name="record[account_number]" /></td><th class="one">Website</th><td class="two"><input type="text" value="<?php if(isset($record[website])) echo form_prep($record[website])?>" name="record[website]" /></td>
            <tr>
                <th class="one">Account Site</th><td class="two"><input type="text" value="<?php if(isset($record[account_site])) echo form_prep($record[account_site])?>" name="record[account_site]" /></td><th class="one">Ticker Symbol</th><td class="two"><input type="text" value="<?php if(isset($record[ticker_symbol])) echo form_prep($record[ticker_symbol])?>" name="record[ticker_symbol]" /></td>
            </tr>
            <tr>
                <th class="one">Type</th><td class="two"><select name="record[account_type]">
                	<option value="">None</option>
                	<?php $sel='';foreach($account_types as $aval){?>
                    <option value="<?php echo $aval;?>"<?php if(isset($record[account_type]) && $record[account_type]==$aval) echo $sel=' selected="selected"'?>><?php echo $aval;?></option>
                    <?php }?>
                    <?php if(!$sel && !empty($record[account_type])){?>
                    <option value="<?php echo $record[account_type];?>" selected="selected"><?php echo $record[account_type];?></option>
                    <?php }?>
                    </select></td><th class="one">Ownership</th><td class="two"><select name="record[ownership]">
                    <option value="">None</option>
                    <option value="Public"<?php $sel='';if(isset($record[ownership]) && $record[ownership]=="Public") echo $sel=' selected="selected"'?>>Public</option>
                    <option value="Private"<?php if(isset($record[ownership]) && $record[ownership]=="Private") echo $sel=' selected="selected"'?>>Private</option>
                    <option value="Subsidiary"<?php if(isset($record[ownership]) && $record[ownership]=="Subsidiary") echo $sel=' selected="selected"'?>>Subsidiary</option>
                    <option value="Other"<?php if(isset($record[ownership]) && $record[ownership]=="Other") echo $sel=' selected="selected"'?>>Other</option>
                    <?php if(!$sel && !empty($record[ownership])){?>
                    <option value="<?php echo $record[ownership];?>" selected="selected"><?php echo $record[ownership];?></option>
                    <?php }?>
                    </select></td>
            </tr>
            <tr>
                <th class="one">Industry</th><td class="two"><select name="record[industry]">
                	<option value="">None</option>
                	<?php $sel='';foreach($industries as $aval){?>
                    <option value="<?php echo $aval;?>"<?php if(isset($record[industry]) && $record[industry]==$aval) echo $sel=' selected="selected"'?>><?php echo $aval;?></option>
                    <?php }?>
                    <?php if(!$sel && !empty($record[industry])){?>
                    <option value="<?php echo $record[industry];?>" selected="selected"><?php echo $record[industry];?></option>
                    <?php }?>
                    </select></td><th class="one">Employees</th><td class="two"><input type="text" value="<?php if(isset($record[employees]) && $record[employees]) echo form_prep($record[employees])?>" name="record[employees]" /></td>
            </tr>
            <tr>
                <th class="one">Annual Revenue</th><td class="two"><input type="text" value="<?php if(isset($record[revenue]) && $record[revenue]) echo form_prep($record[revenue])?>" name="record[revenue]" /></td><th class="one">SIC Code</th><td class="two"><input type="text" value="<?php if(isset($record[siccode])) echo form_prep($record[siccode])?>" name="record[siccode]" /></td>
            </tr>
            <tr>
            	<th class="one">Rating</th><td class="two"><select name="record[rating]">
                <option value="">None</option>
                    <option value="Hot"<?php $sel='';if(isset($record[rating]) && $record[rating]=="Hot") echo $sel=' selected="selected"'?>>Hot</option>
                    <option value="Warm"<?php if(isset($record[rating]) && $record[rating]=="Warm") echo $sel=' selected="selected"'?>>Warm</option>
                    <option value="Cold"<?php if(isset($record[rating]) && $record[rating]=="Cold") echo $sel=' selected="selected"'?>>Cold</option>
                    <?php if(!$sel && !empty($record[rating])){?>
                    <option value="<?php echo $record[rating];?>" selected="selected"><?php echo $record[rating];?></option>
                    <?php }?>
                    </select></td>
                    <th class="one"></th>
                    <td class="two">
                   </td>
            </tr>
            <?php if($customa) {
                $kc=0;
                if($record['custom']) {
				$ekeys=array();
                    foreach($record['custom'] as $cv){ 
                        if(!isset($customa[$cv['ckey']])) continue;
					$ekeys[]= $cv['ckey'];
                        $kc++;
                        if($kc>1 && $kc%2==1) echo '</tr>';
                        if($kc%2==1) echo '<tr>';?>
                    <th class="one"><?php echo $customa[$cv['ckey']]?></th>
                    <td class="two">
                    <input type="text" value="<?php echo $cv['cval']?>" name="record[custom][<?php echo $cv['ckey']?>]" id="<?php echo $cv['ckey']?>" maxlength="100" /></td>
                    <?php }    
					 foreach($customa as $ck=>$cv){ 
						if(in_array($ck,$ekeys)!==FALSE) continue;
                        $kc++;   
                        if($kc>1 && $kc%2==1) echo '</tr>';
                        if($kc%2==1) echo '<tr>';?>
                    <th class="one"><?php echo $cv?></th>
                    <td class="two">
                    <input type="text" value="<?php if(isset($record[$ck])) echo form_prep($record[custom][$ck])?>" name="record[custom][<?php echo $ck?>]" id="<?php echo $ck?>" maxlength="100" /></td>
                    <?php }    
                    echo '</tr>';
					
                } else {
                    foreach($customa as $ck=>$cv){ 
                        $kc++;
                        if($kc>1 && $kc%2==1) echo '</tr>';
                        if($kc%2==1) echo '<tr>';?>
                    <th class="one"><?php echo $cv?></th>
                    <td class="two">
                    <input type="text" value="<?php if(isset($record[$ck])) echo form_prep($record[custom][$ck])?>" name="record[custom][<?php echo $ck?>]" id="<?php echo $ck?>" maxlength="100" /></td>
                    <?php }    
                    echo '</tr>';
                }                
            }?>
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Address Information</th>
            </tr>
            <tr>
                <th class="one">Billing Street</th><td class="two"><textarea name="record[billing][street]"><?php if(isset($record[billing][street])) echo $record[billing][street]?></textarea></td><th class="one">Shipping Street</th><td class="two"><textarea name="record[shipping][street]"><?php if(isset($record[shipping][street])) echo $record[shipping][street]?></textarea></td>
            </tr>
            <tr>
                <th class="one">Billing City</th><td class="two"><input type="text" value="<?php if(isset($record[billing][city])) echo form_prep($record[billing][city])?>" name="record[billing][city]" /></td><th class="one">Shipping City</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][city])) echo form_prep($record[shipping][city])?>" name="record[shipping][city]" /></td>
            </tr>
            <tr>
                <th class="one">Billing State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[billing][state])) echo form_prep($record[billing][state])?>" name="record[billing][state]" /></td><th class="one">Shipping State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][state])) echo form_prep($record[shipping][state])?>" name="record[shipping][state]" /></td>
            </tr>
            <tr>
                <th class="one">Billing Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[billing][zipcode])) echo form_prep($record[billing][zipcode])?>" name="record[billing][zipcode]" /></td><th class="one">Shipping Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][zipcode])) echo form_prep($record[shipping][zipcode])?>" name="record[shipping][zipcode]" /></td>
            </tr>
            <tr style="border-bottom:0px;">
                <th class="one">Billing Country</th><td class="two"><input type="text" value="<?php if(isset($record[billing][country])) echo form_prep($record[billing][country])?>" name="record[billing][country]" /></td><th class="one">Shipping Country</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][country])) echo form_prep($record[shipping][country])?>" name="record[shipping][country]" /></td>
            </tr>
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Additional Information</th>
            </tr>
            <tr>
                <th class="one">Customer Priority</th><td class="two"><select name="record[customer_priority]">
                <option value="">None</option>
                    <option value="High"<?php $sel='';if(isset($record[customer_priority]) && $record[customer_priority]=="High") echo $sel=' selected="selected"'?>>High</option>
                    <option value="Low"<?php if(isset($record[customer_priority]) && $record[customer_priority]=="Low") echo $sel=' selected="selected"'?>>Low</option>
                    <option value="Medium"<?php if(isset($record[customer_priority]) && $record[customer_priority]=="Medium") echo $sel=' selected="selected"'?>>Medium</option>
                    <?php if(!$sel && !empty($record[customer_priority])){?>
                    <option value="<?php echo $record[customer_priority];?>" selected="selected"><?php echo $record[customer_priority];?></option>
                    <?php }?>
                    </select></td><th class="one">SLA</th><td class="two"><select name="record[sla]">
                    <option value="">None</option>
                    <option value="Gold"<?php $sel='';if(isset($record[sla]) && $record[sla]=="Gold") echo $sel=' selected="selected"'?>>Gold</option>
                    <option value="Silver"<?php if(isset($record[sla]) && $record[sla]=="Silver") echo $sel=' selected="selected"'?>>Silver</option>
                    <option value="Platinum"<?php if(isset($record[sla]) && $record[sla]=="Platinum") echo $sel=' selected="selected"'?>>Platinum</option>
                    <option value="Bronze"<?php if(isset($record[sla]) && $record[sla]=="Bronze") echo $sel=' selected="selected"'?>>Bronze</option>
                    <?php if(!$sel && !empty($record[sla])){?>
                    <option value="<?php echo $record[sla];?>" selected="selected"><?php echo $record[sla];?></option>
                    <?php }?>
                    </select></td>
            </tr>
            <tr>
                <th class="one">SLA Expiration Date	</th><td class="two"><input type="text" value="<?php if(isset($record[sla_expdate])) echo form_prep($record[sla_expdate])?>" name="record[sla_expdate]" id="sla_expdate" /></td><th class="one">SLA Serial Number</th><td class="two"><input type="text" value="<?php if(isset($record[sla_serialno])) echo form_prep($record[sla_serialno])?>" name="record[sla_serialno]" /></td>
            </tr>
            <tr>
                <th class="one">Number of Locations</th><td class="two"><input type="text" value="<?php if(isset($record[numlocations]) && $record[numlocations]) echo form_prep($record[numlocations])?>" name="record[numlocations]" /></td><th class="one">Upsell Opportunity</th><td class="two"><select name="record[upsell_oppt]">
                <option value="">None</option>
                    <option value="Maybe"<?php $sel='';if(isset($record[upsell_oppt]) && $record[upsell_oppt]=="Maybe") echo $sel=' selected="selected"'?>>Maybe</option>
                    <option value="No"<?php if(isset($record[upsell_oppt]) && $record[upsell_oppt]=="No") echo $sel=' selected="selected"'?>>No</option>
                    <option value="Yes"<?php if(isset($record[upsell_oppt]) && $record[upsell_oppt]=="Yes") echo $sel=' selected="selected"'?>>Yes</option>
                    <?php if(!$sel && !empty($record[upsell_oppt])){?>
                    <option value="<?php echo $record[upsell_oppt];?>" selected="selected"><?php echo $record[upsell_oppt];?></option>
                    <?php }?>
                    </select></td>
            </tr>
            <tr style="border-bottom:0px;">
                <th class="one">Active</th><td class="two"><select name="record[active]">
                <option value="">None</option>
                    <option value="No"<?php $sel='';if(isset($record[active]) && $record[active]=="No") echo $sel=' selected="selected"'?>>No</option>
                    <option value="Yes"<?php if(isset($record[active]) && $record[active]=="Yes") echo $sel=' selected="selected"'?>>Yes</option>
                    <?php if(!$sel && !empty($record[active])){?>
                    <option value="<?php echo $record[active];?>" selected="selected"><?php echo $record[active];?></option>
                    <?php }?>
                    </select></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr>
            <tr><th>&nbsp;</th></tr>
        	<tr>
            	<th class="title" colspan="4">Description Information</th>
            </tr>
            <tr>
                <th class="one">Description</th><td class="two"><textarea style="height:100px;" name="record[description]"><?php if(isset($record[description])) echo $record[description]?></textarea></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <a href="<?php echo base_url();?>crm/accounts" class="buttonM bRed">Back</a>
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
		if($("#account_name").val().length==0) {
			alert("Account Name required");
			$("#account_name").focus();
			return false;
		}
		return true;
	}
	$(document).ready(function(){
		$('#sla_expdate').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
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
			popboxhead = 'Account Owner';
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
		if(objname=="share_user")
		$("#"+objname+"_id").val($(dis).attr("data_id"));
		else $("#"+objname+"_parent").val($(dis).attr("data_id"));
		$("#cLookup").hide();
	}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>