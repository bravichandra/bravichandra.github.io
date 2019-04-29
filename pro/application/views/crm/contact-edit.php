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

        <div class="formRow crmlite" id="geLookup">
            <div class="qrbox">
                <div class="abox1">Guess Email</div>
                <div class="abox2"><a href="javascript:void(0)" onclick="$('#geLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>
            <div>
                <div class="new_account">
                    <form method="post" id="frmeguess1" class="frmeguess">
                    <input type="hidden" name="action" value="save">
                    <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="width:100%;">
                        <input type="hidden" name="eguess[egtype]" class="egtype" value="1">
                        <tr>
                            <th width="250px" class="one">First Name</th><td class="two"><input type="text" value="" id="first_name" name="eguess[fname]"></td>
                        </tr>
                        <tr>
                            <th class="one">Last Name</th><td class="two"><input type="text" value="" id="last_name" name="eguess[lname]"></td>
                        </tr>
                        <tr>
                            <th class="one">Company Website</th><td class="two"><input type="text" id="website" value="" name="eguess[website]"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center" class="noBorderB">
                                <div class="eglist1"></div>
                                <div class="fluid">
                                    <input type="button" class="buttonM bBlue" value="Submit" onclick="searchEmail(1);" />
                                    <span class="loader1"></span>
                                </div>      
                            </td>
                        </tr> 
                    </table>
                    </form>             
                </div>
            </div> 
        </div>           
        
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
        <form method="post" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="4">Contact Information</th>
            </tr>
            <?php /*?><tr>
                <th class="one">Shared User ID</th><td class="two"><input type="text" /></td><th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>
            </tr><?php */?>
            <tr>
                <th class="one">Contact Owner</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[share_user_id])) echo form_prep($record[share_user_id])?>" name="record[share_user_id]" id="share_user_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[share_user_title])) echo form_prep($record[share_user_title])?>" name="record[share_user_title]" id="share_user_title" />
                <?php //if(!$record[contact_id] || $record[userid]==$user_id){?>
                <a href="javascript:void(0);" onclick="getLookup('share','share_user');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                <?php //}?>
                </td>
                <th class="one">Target Contact</th><td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>
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
                <th class="one">Last Name*</th><td class="two"><input type="text" value="<?php if(isset($record[user_last])) echo form_prep($record[user_last])?>" name="record[user_last]" id="user_last" /></td>
            </tr>
            <tr>
                
                <th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>
                <th class="one">Mobile</th><td class="two"><input type="text" value="<?php if(isset($record[mobile])) echo form_prep($record[mobile])?>" name="record[mobile]" />
                </td>
            </tr>
            <tr>
            	<?php /*?><th class="one"><input type="button" class="buttonM bBlue"  onclick="guessEmail()" value="Guess Email"/></th><td class="two"><input type="text" value="<?php if(isset($record[email])) echo form_prep($record[email])?>" name="record[email]" id="user_email" /></td><?php */?>
                <th class="one">Email </th><th class="two"><input type="text" value="<?php if(isset($record[email])) echo form_prep($record[email])?>" name="record[email]" id="user_email" /><input style="padding:5px; height:auto;" type="button" class="buttonM bBlue"  onclick="guessEmail()" value="Guess Email"/></td>
                <th class="one">Other Phone</th><td class="two"><input type="text" value="<?php if(isset($record[other_phone])) echo form_prep($record[other_phone])?>" name="record[other_phone]" /></td>
            <tr>
                <th class="one">Title</th><td class="two"><input type="text" value="<?php if(isset($record[user_title])) echo form_prep($record[user_title])?>" name="record[user_title]" /></td>                
                <th class="one">Department</th><td class="two"><input type="text" value="<?php if(isset($record[department])) echo form_prep($record[department])?>" name="record[department]" /></td>
            </tr>
            <tr>
                
                <th class="one">Account Name</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[account_id])) echo form_prep($record[account_id])?>" name="record[account_id]" id="account_id" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_title" /><a href="javascript:void(0);" onclick="Records_getLookup('account','account');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>
                
                <th class="one">Lead Source</th><td class="two"><select name="record[lead_source]">
                	<option value="">None</option>
                 		<?php	foreach($lead as $led){ ?>
                 		<option value="<?php echo $led ?>"<?php $sel='';if(isset($record[lead_source]) && $record[lead_source]==$led) echo $sel=' selected="selected"'?>><?php echo $led; ?></option>
				<?php }  ?>
                 <?php if(!$sel && !empty($record[lead_source])){?>
                    <option value="<?php echo $record[lead_source];?>" selected="selected"><?php echo $record[lead_source];?></option>
                    <?php }?>
                </select>
                </td>
                
            </tr>
            <tr>
            	<th class="one">Reports To</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[report_id])) echo form_prep($record[report_id])?>" name="record[report_id]" id="report_id" />
                <input type="text" value="<?php if(isset($record[report_title])) echo form_prep($record[report_title])?>" name="record[report_title]" readonly="readonly" id="report_title" /><a href="javascript:void(0);" onclick="Records_getLookup('contact','report');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>
                <th class="one">Assistant</th><td class="two"><input type="text" value="<?php if(isset($record[assistant])) echo form_prep($record[assistant])?>" name="record[assistant]" /></td>
            </tr>
            <tr>
                
                <th class="one">Birthdate</th><td class="two"><input type="text" value="<?php if(isset($record[birthdate])) echo form_prep($record[birthdate])?>" name="record[birthdate]" id="birthdate" /></td>
                <th class="one">Asst. Phone</th><td class="two"><input type="text" value="<?php if(isset($record[asst_phone])) echo form_prep($record[asst_phone])?>" name="record[asst_phone]" /></td>
            </tr>
			<tr>
                <th class="one">LinkedIn Profile</th>
				<td class="two">
                <input type="text" value="<?php if(isset($record[linkedin])) echo form_prep($record[linkedin])?>" name="record[linkedin]" id="linkedin" /></td>
                <th class="one">Website</th><td class="two"><input id="website" type="text" value="<?php if(isset($record[website])) echo form_prep($record[website])?>" name="record[website]" /></td>
            </tr>
             <?php if($custom) {
                $kc=0;
                if($record['custom']) {
				$ekeys=array();
                    foreach($record['custom'] as $cv){ 
                        if(!isset($custom[$cv['ckey']])) continue;
					$ekeys[]= $cv['ckey'];
                        $kc++;
                        if($kc>1 && $kc%2==1) echo '</tr>';
                        if($kc%2==1) echo '<tr>';?>
                    <th class="one"><?php echo $custom[$cv['ckey']]?></th>
                    <td class="two">
                    <input type="text" value="<?php echo $cv['cval']?>" name="record[custom][<?php echo $cv['ckey']?>]" id="<?php echo $cv['ckey']?>" maxlength="100" /></td>
                    <?php }    
					 foreach($custom as $ck=>$cv){ 
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
                    foreach($custom as $ck=>$cv){ 
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
            <!--<tr>
                <th class="one"><?php if(isset($custom['field1'])) echo $custom['field1']?></th>
				<td class="two">
                <input type="text" value="<?php if(isset($record[custom1_value])) echo form_prep($record[custom1_value])?>" name="record[custom1_value]" id="custom1_value" maxlength="100" /></td>
                <th class="one"><?php if(isset($custom['field2'])) echo $custom['field2']?></th><td class="two"><input type="text" value="<?php if(isset($record[custom2_value])) echo form_prep($record[custom2_value])?>" name="record[custom2_value]" maxlength="100" /></td>
            </tr>
            <tr style="border-bottom:0px;">
                <th class="one"><?php if(isset($custom['field3'])) echo $custom['field3']?></th>
				<td class="two">
                <input type="text" value="<?php if(isset($record[custom3_value])) echo form_prep($record[custom3_value])?>" name="record[custom3_value]" id="custom3_value" maxlength="100" /></td>
                <th class="one" colspan="2"></td>
            </tr>-->
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
                        <a href="<?php echo base_url();?>crm/contacts" class="buttonM bRed">Back</a>
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
    JSActionPage="CONTACT-EDIT";

    function guessEmail()
    {
        var fname = $("#user_first").val();
        var lname = $("#user_last").val();
        var website = $("#website").val();
        $("#first_name").val(fname);
        $("#last_name").val(lname);
        $("#gwebsite").val(website);
        $("#geLookup").show();
    }
    function searchEmail(egt)
    {
        if($("#first_name").val().length==0) {
            alert("First Name required");
            $("#first_name").focus();
            return false;
        }
        if($("#last_name").val().length==0) {
            alert("Last Name required");
            $("#last_name").focus();
            return false;
        }   
        if($("#website").val().length==0) {
            alert("Website required");
            $("#website").focus();
            return false;
        }       
        $(".loader"+egt).html('Please bare with us, this can take a few seconds <img src="https://salesscripter.com/betapro/images/spinner.gif" />');
        $.ajax({
          type: "POST",
          url: "<?php echo base_url()."crm/emailCheck"?>",
          data: $('#frmeguess'+egt).serialize()
            }).done(function( data ) {              
                $(".loader"+egt).html('');
                data = data.replace(/^\s*\n/gm, "");
                $k = data.substring(0,7);
                 if($k=="SUCCESS") {
                    //alert("test");
                    var str = data.substring(7);
                    var n=str.replace("SS","");
                    $(".eglist"+egt).html(n);  
                } else alert(data);
          })
          .fail(function() {
            $(".loader"+egt).html('');
            alert( "Unable to process, please try again" );
          });
        return false;
    
    }
    function selectemail(dis)
    {
        $("#user_email").val(dis);
        $("#geLookup").hide();
    }

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
			
		if(localStorage.getItem("cm_<?php echo $pam4?>_website")!=null) 
			$("#website").val(localStorage.getItem("cm_<?php echo $pam4?>_website"));	
		<?php	
			}
		?>
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>