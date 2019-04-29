<!-- Main content -->	
<div class="wrapper" style="margin:0px;">

	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 		
    <div class="bxlink" style="text-align:right; padding-bottom:0px; margin-right:30px;"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>  
	<div class="fluid">
    	
        <div class="grid12" style="width:100%; margin-left:0%;">
        
        	<div class="myfolder" align="center" style="margin-left:0%;">  
			<div class="myfloder_box">     
        	

	<!--  for company page  -->
	<!-- <div class="widget fluid"> --><br clear="all" />
		<div class="widget" style="padding-bottom:30px; margin:0px 30px;">
			<div class="body">							
				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
					<tbody>
                    	<tr style="border:none;-webkit-box-shadow:none;">
                        	<td class="no-border" style="-webkit-box-shadow:none;" colspan="4"><h2 class="pt10">Company Profiles</h2></td>
                            <td class="no-border">&nbsp;</td>
                        </tr>
                        <tr style="border:none; background:#f7f7f7;-webkit-box-shadow:none;">
                            <td colspan="4" class="no-border" style="-webkit-box-shadow:none;">&nbsp;<br /></td>
                            <td class="no-border" style="padding:0px; text-align:center;-webkit-box-shadow:none;">Order<br /></td>
                        </tr>
						<?php if(!empty($drop_company)): ?>
							<?php foreach ($drop_company as $singlecompany): ?>
								<?php //if ($sessions->status != '2'): ?>															
									<tr>
										<td class="no-border">
								 			<h6><span class="dynamic_value compamy_session" id="edit_<?php echo $singlecompany->company_id; ?>"><?php echo $singlecompany->company_name; ?></span></h6>
										</td>
										<?php //if($sessions->status == '0'):?>								                                	
										<td  width="20px;" class="no-border"><a href="#_" onClick="launchSessionCompany('<?php echo $singlecompany->company_id; ?>','no');"><input type="button" class="buttonM bGreen" name="launch" value="Edit" /></a></td>
                                        <td  width="20px" class="no-border"><a href="#_" onClick="RenameRecord(<?php echo $singlecompany->company_id; ?>);" ><input type="button" class="buttonM bGreyish" value="Rename" /></a></td>
										<td  width="20px;" class="no-border"><a href="#_" onClick="deleteSessionCompany('<?php echo $singlecompany->company_id; ?>','<?php echo $singlecompany->status; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>                                        
                                        <td width="60px" style="text-align: center;" class="no-border"><input type="text" onChange="update_record_sorder_txt(<?php echo $singlecompany->company_id; ?>,this)" size="2" class="rcorder" value="<?php echo $singlecompany->sorder; ?>" style="height: 25px;"/>
										<?php //endif;?>								                               
										<!--  <?php //if($sessions->status == '1'):?>
										<td  width="20px;" class="no-border"><a href="#_" onclick="deleteSession('<?php echo $sessions->session_id; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
										<?php //endif;?>  -->								                            
									</tr>
								<?php // endif; ?>						                            
							<?php endforeach; ?>					                           
						<?php endif; ?>					                            					                        
					</tbody>
				</table>
                <br />
                <div style="float:left;">
                	<a class="buttonM bRed" href="javascript:void(0);" onClick="return create_company_profile()">Create a Company Profile</a>
                </div>
			</div>
		</div>
	<!--</div> -->
		
	
</div>
	</div>
	<br/>
	
</div></div></div>

<script type="text/javascript">
	//Rename record
	function RenameRecord(rid) {
		$("#edit_"+rid).click();
	}
	//create company profile
	function create_company_profile() {
		$.ajax({
		  type: "POST",
		  url: BASE_URL + 'campaign/createcompanyprofile',
		  data: '',
		  cache: false,
		  dataType: 'json',
		  complete: function (jqxhr, txt_status) {
		  	location.replace(BASE_URL + 'step/interest');
		  }
		});
		return false;
	}
$(document).ready(function(){

	$('.compamy_session').editable('<?php echo base_url()?>campaign/edit_company', { 
		name    : 'value',
        id      : 'id',
		type 	: 'textarea',
		submit  : 'Update',
		width   : '200px',
        height  : '50px',
        tooltip : "Click to edit...",
        style : "",
        requireProductTxt : "Click to edit",
        callback : function(value, settings) {
             // console.log(value);
         }
	});
	
	
});

function launchSessionCompany(companyid,staus)
{
	$.ajax({
	    url : '<?php echo base_url(); ?>campaign/activatecompanysession',
		type : 'POST',
		data: {company_id : companyid},
		success : function(data){
		     window.location.href = "<?php echo base_url() ?>step/interest";
		},
	});
}



function deleteSessionCompany(company_id,status)
{
	var answer = confirm("Are you sure you want to proceed?")
	/** call ajax functionality to find and ajax call */
	if(answer){
		$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>campaign/deleteCompanySess/',
				data: {company_id : company_id,status : status },
				cache: false,
				dataType: 'json',
				success: function(response)
				{
					console.log(response);
					location.reload(true);
					// window.location.href = BASE_URL + 'step/value';
				}
			});
	}else{
		return;
	}
}
//update sort order from text box
function update_record_sorder_txt(rcid,oval) {
	var txtval = parseInt($(oval).val());
	if(isNaN(txtval) || txtval<0) txtval=0;
	$(oval).val(txtval);
	$.ajax({
		type : 'POST',
		url : '<?php echo current_url();?>',
		data: 'rcid='+rcid+'&action=SortOrderupdate&sord='+txtval,
		cache: false,
		dataType: 'json',
		success: function(responce)
		{
			
		}
	});	
}


</script>
<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/Z3f8E7RubxA?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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