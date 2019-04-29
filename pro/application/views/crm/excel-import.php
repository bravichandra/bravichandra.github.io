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
    	<div style="text-align: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
        <?php if($error) {?>
        <div class="crm-error"><?php echo implode("<br />",$error);?></div>
        <?php }//echo "<pre>";print_r($rowsdata);echo "</pre>";?>
		<!-- Main content -->
        <?php if(isset($mapping) && $rowsdata && !$error) {
			$column_keys = $rowsdata['keys'];
			$column_heads = $rowsdata['values'];
			$datarow = $rowsdata['rows'];
		?>
        <form method="post" onsubmit="return save_record2();" action="<?php echo base_url('crm/'.$parent_section.'/import/map');?>">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="3"><?php echo ucfirst($parent_section);?> Feilds Mapping</th>
            </tr>
            <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[target]" /> Select here to make all imported <?php echo $parent_section;?> designated as target <?php echo $parent_section;?></td>
            </tr>
            <?php if($crmlite=="contact") {?>
            <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[target_account]" /> Select here to make all imported accounts designated as target accounts</td>
            </tr>
            <?php }?>
            <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[mapping]" /> Save Mapping</td>
            </tr>
            <?php 
			$info=unserialize($userinfo[0]->value);
			//echo "<pre>";
			//print_r($info);
			$res= array_diff($column_heads,$info['headers']);
			// print_r($res);
			 if(count($column_heads)!=count($res)){ ?>
			  <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[old]" checked="checked" /> Mapping from Previous Import</td>
            </tr>
		<?php  
			 }
			
			?>
            <tr>
            	<td colspan="3">Assign Record Owner: 
                	<select name="record[share_user_id]">
                        <?php foreach($sharedUsers as $prosp){?>
                        <option value="<?php echo $prosp->user_id;?>"<?php if($user_id==$prosp->user_id) echo ' selected="selected"';?>><?php echo ucfirst($prosp->usrname);?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="3">Assign to a List: 
                    <select name="record[listid]">
                        <option value="0">Select List</option>
                        <?php foreach($catlist as $catg){?>
                        <option value="<?php echo $catg->id;?>"><?php echo $catg->name;?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="one"><?php echo ucfirst($crmlite);?> Field</th>
                <th class="two">Excel Column</th>
                <th class="two">Your Data</th>
            </tr>
            <?php 
				$ki=0;
				$value=$info['val'];
				//print_r($value);
				$default=array();
				foreach($column_keys as $ci=>$cv){
				$default=$value[$ci];
					//print_r($default);?>
            <tr>
                <td class="one">
                	<input type="hidden" name="record[excol][<?php echo $ki;?>]" value="<?php echo $cv;?>" />
                	<select name="record[tbcol][<?php echo $ki;?>]" class="tbcol">
                    	<option value="">No Mapping</option>
						<?php foreach($table_fields as $ri=>$rv){?>
                        <option value="<?php echo $ri;?>"<?php if(isset($record['tbcol'][$ki]) && $record['tbcol'][$ki]==$ri) echo ' selected="selected"'; else if($default==$ri) echo ' selected="selected"'; ?>><?php echo $rv;?></option>
                        <?php }?>
                    </select>
                </td>
                <td class="two"><?php echo $column_heads[$ci];?></td>
                <td class="two"><?php echo $datarow["$cv"];?></td>
            </tr>
            <?php $ki++;}?>
            <tr>
            	<td colspan="3" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Import" />
                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                    </div>
                </td>
            </tr>
        </table>
        </form>
        <?php } else {?>        
        
        <?php if(!isset($sfMode)) {?>
        <form method="post" onsubmit="return save_record();" enctype="multipart/form-data" action="<?php echo base_url('crm/'.$parent_section.'/import');?>">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="2"><?php echo ucfirst($crmlite);?>s Upload</th>
            </tr>
            <tr>
                <th class="one">Browse CSV or Excel*</th><td class="two">
                	<input type="file" name="import_file" id="import_file" />
                    <br />Make Excel or CSV file first row should have Headings of your excel data.
                    </td>
            </tr>
            <tr>
            	<td colspan="2" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Upload" />
                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                    </div>		
                </td>
            </tr>
        </table>
        </form>
        <?php }?>
        
        <?php if($crmlite=="contact") {?>
        <form method="post" action="<?php echo base_url('crm/'.$parent_section.'/import/salesforce');?>">
        	<input type="hidden" name="action" value="s2dimport" />
            <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
                <tr>
                    <th class="title" colspan="2"><?php echo ucfirst($crmlite);?>s Import from Salesforce</th>
                </tr>
                <tr>
                    <td colspan="2">
                    	<?php if($Salesforce_Records) {?>
                        <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>
                            <thead>
                                <tr>
                                    <th class='no-border'><input type="checkbox" id="selectall" /></th>
                                    <th class='no-border'>Name</th>
                                    <th class='no-border'>Phone</th>
                                    <th class='no-border'>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($Salesforce_Records as $ci=>$crow) {?>
                                <tr>
                                	<td class='no-border'><input type="checkbox" value="<?php echo $crow->ID;?>" name="recids[]" class="rcselect" /></td>
                                    <td class='no-border'><?php echo $crow->FirstName.' '.$crow->LastName;?></td>
                                    <td class='no-border'><?php echo $crow->Phone;?></td>
                                    <td class='no-border'><?php echo $crow->Email;?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <?php }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div class="fluid" style="margin-top:15px;">
                            <?php if(!$sflogin) {?>
                            <a href="<?php echo base_url();?>crm/salesforce/login/c" class="buttonM bBlue">Connect to Salesforce</a>
                            <?php } else if($Salesforce_Records){?>
                            <input type="submit" class="buttonM bBlue" name="btn_rcimport" id="btn_rcimport" value="Import Records" /> 
                            <input type="submit" class="buttonM bBlue" name="btn_disconnect" value="Disconnect" />  
                            <?php }?>
                            <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                        </div>		
                    </td>
                </tr>
            </table>
        </form>
        <?php } else if($crmlite=="account") {?>
        <form method="post" action="<?php echo base_url('crm/'.$parent_section.'/import/salesforce');?>">
        	<input type="hidden" name="action" value="s2dimport" />
            <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
                <tr>
                    <th class="title" colspan="2"><?php echo ucfirst($crmlite);?>s Import from Salesforce</th>
                </tr>
                <tr>
                    <td colspan="2">
                    	<?php if($Salesforce_Records) {?>
                        <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>
                            <thead>
                                <tr>
                                    <th class='no-border'><input type="checkbox" id="selectall" /></th>
                                    <th class='no-border'>Account Name</th>
                                    <th class='no-border'>Billing City</th>
                                    <th class='no-border'>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($Salesforce_Records as $ci=>$crow) {?>
                                <tr>
                                	<td class='no-border'><input type="checkbox" value="<?php echo $crow->ID;?>" name="recids[]" class="rcselect" /></td>
                                    <td class='no-border'><?php echo $crow->Name;?></td>
                                    <td class='no-border'><?php echo $crow->BillingCity;?></td>
                                    <td class='no-border'><?php echo $crow->Phone;?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <?php }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div class="fluid" style="margin-top:15px;">
                            <?php if(!$sflogin) {?>
                            <a href="<?php echo base_url();?>crm/salesforce/login/a" class="buttonM bBlue">Connect to Salesforce</a>
                            <?php } else if($Salesforce_Records){?>
                            <input type="submit" class="buttonM bBlue" name="btn_rcimport" id="btn_rcimport" value="Import Records" /> 
                            <input type="submit" class="buttonM bBlue" name="btn_disconnect" value="Disconnect" />                            
                            <?php }?>
                            <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                        </div>		
                    </td>
                </tr>
            </table>
        </form>
        <?php }?>
        
        <?php }?>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
	//Check file
	function save_record(){
		if($("#import_file").val().length==0) {
			alert("Browse file");
			$("#import_file").focus();
			return false;
		}
		return true;
	}
	//Check fields mapping
	function save_record2(){
		var c=0;
		$(".tbcol").each(function(){
			if($(this).val()!="") {c=1;return;}
		});
		if(c==0) {
			alert("Select <?php echo $crmlite;?> fields.");
			return false;
		}
		return true;
	}
	
	$(document).ready(function(){
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
		//Select/Deselect import records
		$("#selectall").change(function(){
			$(".rcselect").prop("checked",$(this).prop("checked"));
		});
		//Import Records
		$("#btn_rcimport").click(function(){
			if($(".rcselect:checked").length==0) {
				alert("Select records");
				return false;
			}
			return true;
		});
	});
	var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/Znuv1QvHcsc" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
$( document ).ready(function() {
    $('.help_dialog').dialog({
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
    $('.dialog_help').click(function (e) {
         $('.video').html(iframe);
         $('.help_dialog').dialog('open');
         
        return false;
    });
    
    $('.ui-icon-closethick').click(function (e) {
         $('.video').html('');
          $('.help_dialog').dialog('close');
        return false;
    });
    
});	
</script>	
<div class="help_dialog" title="Video">
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
</html></div>
</script> 	
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>