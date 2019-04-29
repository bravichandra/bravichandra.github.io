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
		<?php if($ivs=="pool") echo "$('.edtable').removeClass('edtable');";?>
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
			url : '<?php echo base_url('interviewer/applicant/view/'.$record[contact_id])?>',
			data: $("#frmRecord").serialize(),
			cache: false,
			dataType: 'json',
			success: function(responce)
			{
				if(responce.status=="Y") {
					if(ebox=="target") $("#target").prop('checked',responce.cinfo=="1"?true:false);
                  //  else if(ebox=="sstrained") $("#sstrained").prop('checked',responce.cinfo=="1"?true:false);
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
                <?php if($ivs<>'pool'){?>
                <div id="gh_anbox">     
                    <div>
                    	<div class="qebox">
                        	<div class="erbox"></div>
                        	<div class="box box_target" title="Profile visible to employers">
                            	<table cellpadding="0" cellspacing="0" border="0">	
                                    <tr>
                                    	<th class="one">Profile visible to employers</th>
                                        <td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_sstrained" title="Experience Using SalesScripter">
                                <table cellpadding="0" cellspacing="0" border="0">  
                                    <tr>
                                       <!-- <th class="one">Amount of experience with SalesScripter (amount of time or number of projects)</th>-->
                                       <th class="one">Number of projects using SalesScripter</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[sstrained])) echo $record[sstrained]?>" name="record[sstrained]" /></td>
                                    </tr>
                                </table>
                            </div>
                             <div class="box box_sstrained2" title="Experience Using SalesScripter">
                                <table cellpadding="0" cellspacing="0" border="0">  
                                    <tr>
                                       <!-- <th class="one">Amount of experience with SalesScripter (amount of time or number of projects)</th>-->
                                       <th class="one">Number of months using SalesScripter</th>
                                        <td class="two"><input type="text" value="<?php if(isset($record[sstrained2])) echo $record[sstrained2]?>" name="record[sstrained2]" /></td>
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
                <?php }?>
                
            </form>
        </div>
    </div>
	<!-- Main content -->
    <div class="main-wrapper crmlite"> 
    	<div class="crm-menu"> 
		<?php if(!$record && $ivs<>'pool') {?>
		<a href="<?php echo base_url();?>interviewer/applicant/edit" class="buttonM bBlack">Create Profile</a>
		
		<?php }else {?>
			<?php if($ivs<>'pool'){?>
            <a href="<?php echo base_url();?>interviewer/applicant/edit/<?php echo $record[contact_id]?>" class="buttonM bBlack">Edit</a> 
            <?php }?>
            
            <?php if($ivs=='pool'){?>
            <div align="center" style="float:right;"> 
             <a href="<?php echo base_url();?>interviewer/laborpool/<?php echo $record['contact_id']; ?>/get" class="buttonM bRed">Add to Applicants</a>
            </div>	
            <?php }?>
           
			
        <?php if($error) {?>
        <div class="crm-error"><?php echo implode("<br />",$error);?></div>
        <?php }//echo "<pre>";print_r($rowsdata);echo "</pre>";?>
		<!-- Main content -->
        <div>
		<table cellpadding="0" cellspacing="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" width="100%" border="0" align="center" class="contact-list view">
            <tbody>
                <tr>
                   	<th class="one">Profile visible to employers</th><td class="two edtable" data-field="target"><input type="checkbox" id="target" disabled="disabled"<?php if($record[target]) echo ' checked="checked"';?> /></td>                    
                    <td class="gap"></td>
                    <th class="one">Name</th><td class="two edtable" data-field="user_first"><?php echo $record[user_prefix].' '.ucfirst($record[user_first].' '.$record[user_last])?></td><td class="gap"></td>                   
                </tr>
                 <tr>
                	 <th class="one">Number of projects using SalesScripter</th>
                    <td class="two edtable" data-field="sstrained"><?php if(isset($record['sstrained'])) echo $record['sstrained']?></td><td class="gap"></td>
                    <th class="one">Number of months using SalesScripter</th>
                    <td class="two edtable" data-field="sstrained2"><?php if(isset($record['sstrained2'])) echo $record['sstrained2']?></td>
                </tr> 
                              
                <tr>
                	
					<th class="one">Phone</th><td class="two edtable" data-field="phone"><?php if($record[phone]) echo '<a href="tel:'.$record[phone].'">'.$record[phone].'</a>';?></td><td class="gap"></td>
                    <th class="one">Created</th><td class="two"><?php echo date("m/d/Y",strtotime($record[create_date]))?></td>
                </tr>
                <tr>
                	<th class="one">Mobile</th><td class="two edtable" data-field="mobile"><?php if($record[mobile]) echo '<a href="tel:'.$record[mobile].'">'.$record[mobile].'</a>';?></td><td class="gap"></td>
					 <th class="one">Last Modified</th><td class="two"><?php echo date("m/d/Y",strtotime($record[modify_date]))?></td>
                </tr>
               
                <tr>
                	<th class="one">Email</th><td class="two edtable" data-field="email"><?php if($record[email]) echo '<a href="mailto:'.$record[email].'">'.$record[email].'</a>';?></td><td class="gap"></td>
                   <th class="one">Birthdate</th><td class="two edtable" data-field="birthdate"><?php echo $record[birthdate]?></td>   
                </tr>
                <tr>
                	<th class="one">Mailing Address</th><td class="two edtable" data-field="address"><?php $adr_mail=array_filter($record[amail]);unset($adr_mail['parent_id']);unset($adr_mail['adr_type']);unset($adr_mail['parent_type']); echo implode(", ",$adr_mail);?></td>  <td class="gap"></td>
                    <th class="one">How much do you want to be paid per hour</th><td class="two edtable" data-field="pay_rate"><?php echo ((isset($record['pay_rate']) && $record['pay_rate']>0)?'$'.number_format($record['pay_rate'],2):'')?></td>    
                </tr>
                 <tr>
                <th class="one">LinkedIn Profile</th><td class="two edtable" data-field="linkedin"><?php if($record[linkedin]) echo '<a href="'.$record[linkedin].'" target="_blank">View Profile</a>';?></td>
               
                   	                     
                </tr>
               
            </tbody>
        </table>
        </div>
         <hr /> 
		  
		 
		
		
		
		<div class="subsections"><b>Attached Documents</b>  <?php if($ivs<>'pool'){?><a href="<?php echo base_url('interviewer/notes/docu/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a><?php }?></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list5,"ntype"=>"docu"));?>
        </div><hr />
		 
		 <div class="subsections"><b>Experience</b> <?php if($ivs<>'pool'){?><a href="<?php echo base_url('interviewer/notes/exp/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/exp/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a><?php }?></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list2,"ntype"=>"exp"));?>
        </div><hr />
		
		 <div class="subsections"><b>Education</b> <?php if($ivs<>'pool'){?><a href="<?php echo base_url('interviewer/notes/edu/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/edu/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a><?php }?></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list3,"ntype"=>"edu"));?>
        </div><hr />
		
		 <div class="subsections"><b>Skills, Certifications, Associations, and Hobbies</b> <?php if($ivs<>'pool'){?><a href="<?php echo base_url('interviewer/notes/skill/applicant/'.$record[contact_id]);?>">&nbsp;View All</a> <a href="<?php echo base_url('interviewer/notes/skill/applicant/'.$record[contact_id].'/edit');?>">New&nbsp;</a><?php }?></div>
        <div>
        	<?php $this->load->view('interview/app-notes-list-few',array("notes_list"=>$notes_list4,"ntype"=>"skill"));?>
        </div><hr />
		
		
		<?php } ?>
		    
	</div>
    <!-- Main content ends -->
</div>

<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
