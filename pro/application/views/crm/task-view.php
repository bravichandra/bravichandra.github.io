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
		$("#task_duedate").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
		$('#task_related').change(function(e){
			$("#related_title").val('');
			$("#related_id").val(0);
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
	}
	//Hide Fade
	function hide_fade(){
		$(".erbox").html('');
		$("#crmpopup").hide();
		$(".overlayBackground").hide();
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
					ectrl.html(responce.cinfo);
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
<div class="overlayBackground" onclick="hide_fade()"></div>
<div id="content">
	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/crm_nav');
	?>
    <div class="formRow crmlite" id="cLookup">
        <div class="qrbox">
            <div class="abox1">Account Lookup</div>
            <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
        </div>
        <div class="search-list"></div>
    </div>
    <div id="crmpopup">
        <div class="formRow">
            <div class="qrbox">
                <div class="abox1">Edit <span>Name</span></div>
                <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>
            <form action="<?php echo current_url();?>" id="frmRecord" method="post">
            	<input type="hidden" name="action" value="update" />
                <input type="hidden" name="eblock" id="eblock" value="" />
                <div id="gh_anbox">     
                    <div>
                    	<div class="qebox">
                        	<div class="erbox"></div>
                            <div class="box box_task_priority" title="Priority">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Priority</th><td class="two">
                                        <select name="record[task_priority]">
                                            <option value="High">High</option>
                                            <option value="Normal"<?php if(isset($record[task_priority]) && $record[task_priority]=="Normal") echo ' selected="selected"'?>>Normal</option>
                                            <option value="Low"<?php if(isset($record[task_priority]) && $record[task_priority]=="Low") echo ' selected="selected"'?>>Low</option>
                                        </select>
                                        </td>                
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_subject" title="Subject">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Subject*</th><td class="two"><input type="text" value="<?php if(isset($record[task_subject])) echo form_prep($record[task_subject])?>" name="record[task_subject]" id="task_subject" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_status" title="Status">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Status*</th><td class="two">
                                        <select name="record[task_status]">
                                            <option value="Not Started">Not Started</option>
                                            <option value="In Progress"<?php if(isset($record[task_status]) && $record[task_status]=="In Progress") echo ' selected="selected"'?>>In Progress</option>
                                            <option value="Completed"<?php if(isset($record[task_status]) && $record[task_status]=="Completed") echo ' selected="selected"'?>>Completed</option>
                                            <option value="Waiting on someone else"<?php if(isset($record[task_status]) && $record[task_status]=="Waiting on someone else") echo ' selected="selected"'?>>Waiting on someone else</option>
                                            <option value="Deferred"<?php if(isset($record[task_status]) && $record[task_status]=="Deferred") echo ' selected="selected"'?>>Deferred</option>
                                        </select></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_duedate" title="Due Date">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Due Date</th><td class="two"><input type="text" value="<?php if(isset($record[task_duedate])) echo form_prep($record[task_duedate])?>" name="record[task_duedate]" id="task_duedate" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_relatedto" title="Related To">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Related To</th>
                                        <td class="two">
                                        <select name="record[task_related]" id="task_related">
                                            <option value="C">Contacts</option>
                                            <option value="A"<?php if(isset($record[task_related]) && $record[task_related]=="A") echo ' selected="selected"'?>>Account</option>
                                            <?php /*?><option value="O"<?php if(isset($record[task_related]) && $record[task_related]=="O") echo ' selected="selected"'?>>Opportunity</option><?php */?>
                                        </select>
                                        </td>
                                        <td>
                                        <input type="hidden" value="<?php if(isset($record[task_relatedto])) echo form_prep($record[task_relatedto])?>" name="record[task_relatedto]" id="related_id" />
                                        <input type="text" readonly="readonly" value="<?php if(isset($record[related_title])) echo form_prep($record[related_title])?>" name="record[related_title]" id="related_title" />
                                        </td>
                                        <td><a href="javascript:void(0);" onclick="getLookup('related','related');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_phone" title="Phone">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[task_phone])) echo form_prep($record[task_phone])?>" name="record[task_phone]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_email" title="Email">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Email</th><td class="two"><input type="text" value="<?php if(isset($record[task_email])) echo form_prep($record[task_email])?>" name="record[task_email]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_task_info" title="Comments">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Comments</th><td class="two"><textarea name="record[task_info]" style="height:100px; width:500px;"><?php if(isset($record[task_info])) echo $record[task_info]?></textarea></td>
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
        
           <?php /*?> <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>/view/<?php echo $parent_id?>" class="buttonM bBlack">Back</a>   <?php */?>   
            <INPUT TYPE="button" VALUE="Back" class="buttonM bBlack" onClick="history.go(-1);" style="cursor:pointer;"/>      
            <a href="<?php echo base_url();?>crm/tasks/edit/<?php echo $record[task_id]?>" class="buttonM bBlack">Edit</a> 
            <a href="<?php echo base_url();?>crm/tasks/delete/<?php echo $record[task_id]?>" onclick="if(!confirm('Are you sure you want to delete this tasks?')) return false;" class="buttonM bBlack">Delete</a>   
        </div>
        
		<!-- Main content -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" align="center" class="contact-list view">
            <tbody>
            	<tr>
                	<th class="one">Assigned To</th><td class="two"><?php echo $record[share_user_title]?></td><td class="gap"></td>
					<th class="one">Priority</th><td class="two edtable" data-field="task_priority"><?php echo $record[task_priority]?></td>
                </tr>
                <tr>
                	<th class="one">Subject</th><td class="two edtable" data-field="task_subject"><?php echo $record[task_subject]?></td><td class="gap"></td>
                    <th class="one">Status</th><td class="two edtable" data-field="task_status"><?php echo $record[task_status]?></td>
                </tr>
                <tr>
                	<th class="one">Due Date</th><td class="two edtable" data-field="task_duedate"><?php echo $record[task_duedate]?></td><td class="gap"></td>
                    <th class="one">Related To</th><td class="two edtable" data-field="task_relatedto"><a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>/view/<?php echo $parent_id?>"><?php echo $parent_name?></a></td>
                </tr>
                <tr>
                	<th class="one">Phone</th><td class="two edtable" data-field="task_phone"><?php if($record[task_phone]) echo '<a href="tel:'.$record[task_phone].'">'.$record[task_phone].'</a>';?></td><td class="gap"></td>
                    <th class="one">Email</th><td class="two edtable" data-field="task_email"><?php if($record[task_email]) echo '<a href="mailto:'.$record[task_email].'">'.$record[task_email].'</a>';?></td>
                </tr>
                <tr>
                	<th class="one">Created</th><td class="two"><?php echo date("m/d/Y",strtotime($record[task_created]))?></td><td class="gap"></td>
                    <th class="one">Last Modified</th><td class="two"><?php echo date("m/d/Y",strtotime($record[task_modified]))?></td>
                </tr>
                <?php if($record[task_name]){?>
                <tr>
                	<th class="one">Details</th><td class="two" class="4"><?php echo $record[task_name]?></td>
                </tr>
                <?php }?>
                <tr>
                	<th class="one">Comments</th><td class="two task_info edtable" data-field="task_info" colspan="4"><?php $task_content_nonhtml=strip_tags($record[task_info]);
					if(strlen($task_content_nonhtml)<strlen($record[task_info])) echo $record[task_info];
					else echo str_replace("\n","<br>",$record[task_info])?></td>
                </tr>
            </tbody>
        </table>  
              
	</div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
