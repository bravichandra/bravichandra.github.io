<!-- Main content -->	
<div class="wrapper">

	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 		
    	<div class="bxlink" style="text-align:right; padding-bottom:22px;"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
	<div class="fluid">
    	
        <div class="grid12" style="width:100%; margin-left:0%;" >
			<div class="myfolder" align="center" style="margin-left:0%;">
            <?php /*?><div class="box">
                <div class="bxtitle">
                    <h3>Create Campaign Coordinates</h3>                
                </div>
                <div class="bxlink">                
                <a href="<?php echo base_url(); ?>home/campaign-coordinates" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
                <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            
        	<div class="box">
            	<div class="bxtitle">
	            	<h3>Create Product Profile</h3>                
                </div>
                <div class="bxlink">
            		<a href="<?php echo base_url(); ?>folder/product-profile" class="buttonM bRed">Go Here</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Sales Pitch Campaign</h3></div>
                <div class="bxlink">                
            	<a href="<?php echo base_url(); ?>folder/campaigns" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Company Profile</h3></div>
                <div class="bxlink">
            	<a href="<?php echo base_url(); ?>folder/company-profiles" class="buttonM bRed">Go Here</a></div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
            </div>
            <div class="box active">
            	<div class="bxtitle bxtitle1"><h3>Create a Name Drop</h3></div>
                <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
            </div>
        </div>
		</div>
		<div class="myfloder_box1 myfloder_box4 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div><br clear="all" /><?php */?>
		
		<!--  for name drop page  -->
		<!-- <div class="widget fluid"> -->
			<div class="widget" style="padding-bottom:30px;">
				<div class="body">							
					<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
						<tbody>
							<tr style="border:none;-webkit-box-shadow:none;">
	                        	<td class="no-border" style="-webkit-box-shadow:none;" colspan="4"><h2 class="pt10">Name Drop Examples</h2></td>
	                            <td class="no-border">&nbsp;</td>
	                        </tr>
	                        <tr style="border:none; background:#f7f7f7;-webkit-box-shadow:none;">
	                            <td colspan="4" class="no-border" style="-webkit-box-shadow:none;">&nbsp;<br /></td>
	                            <td class="no-border" style="padding:0px; text-align:center;-webkit-box-shadow:none;">Order<br /></td>
	                        </tr>
						<?php if (!empty($drop_name)): ?>
								<?php foreach ($drop_name as $singledropname): ?>
									<?php //if ($sessions->status != '2'): ?>															
										<tr>
											<td class="no-border">
												<h6><span class="dynamic_value dropnamepn_session" id="edit_<?php echo $singledropname->c_id; ?>_<?php echo (int)$singledropname->c_data_id; ?>"><?php echo ($singledropname->value?$singledropname->value:$singledropname->credibility_name); ?></span></h6>
											</td>
											<?php //if($sessions->status == '0'):?>								                                	
											<td  width="20px;" class="no-border"><a href="#_" onClick="launchSessionDrop('<?php echo $singledropname->c_id; ?>','no');"><input type="button" class="buttonM bGreen" name="launch" value="Edit" /></a></td>
                                        <td  width="20px" class="no-border"><a href="#_" onClick="RenameRecord('<?php echo $singledropname->c_id; ?>_<?php echo (int)$singledropname->c_data_id; ?>');" ><input type="button" class="buttonM bGreyish" value="Rename" /></a></td>
											<td  width="20px;" class="no-border"><a href="#_" onClick="deleteDropname('<?php echo $singledropname->c_id; ?>','<?php echo $singledropname->status; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
											<?php //endif;?>								                               
											<!--  <?php //if($sessions->status == '1'):?>
											<td  width="20px;" class="no-border"><a href="#_" onclick="deleteSession('<?php echo $sessions->session_id; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
											<?php //endif;?>  -->	
                                            <td width="60px" class="no-border" style="text-align:center;">
                                            <input type="text" class="rcorder" value="<?php echo $singledropname->sorder; ?>" onChange="update_record_sorder_txt(<?php echo $singledropname->c_id; ?>,this)" size="2" 
                                            style="height: 25px;"/>
                                        </td>                  							                            
										</tr>
									<?php // endif; ?>						                            
								<?php endforeach; ?>					                           
							<?php endif; ?>					                            					                        
						</tbody>
					</table>
					<br/>
					<?php /*?><a class="buttonM bRed" id="myfolder_create" href="<?php echo base_url(); ?>campaign/createdropname">Create a Name Drop </a><?php */?>
                    <a class="buttonM bRed" href="javascript:void(0);" onClick="return create_namedro_profile()" style="float:left;">Create a Name Drop </a>
				</div>
			</div>
		<!-- </div> -->
	</div>
	</div>
	<br/>
	
</div></div></div>

<script type="text/javascript">
	//Rename record
	function RenameRecord(rid) {
		$("#edit_"+rid).click();
	}
	//create namedrop profile
	function create_namedro_profile() {
		$.ajax({
		  type: "POST",
		  url: BASE_URL + 'campaign/createdropname',
		  data: '',
		  cache: false,
		  dataType: 'json',
		  complete: function (jqxhr, txt_status) {
		  	location.replace(BASE_URL + 'step/credibility');
		  }
		});
		return false;
	}
$(document).ready(function(){
	//By Dev@4489
	$('.dropnamepn_session').editable('<?php echo base_url()?>campaign/edit_drop_prname', { 
		name       : 'value',
        id         : 'id',
		type : 'textarea',
		submit   : 'Update',
		width      : '200px',
        height     : '50px',
        tooltip : "Click to edit...",
        style : "",
        requireProductTxt : "Click to edit",
        callback : function(value, settings) {
             // console.log(value);
         }
	});
	
});


function launchSessionDrop(dropname_id,staus)
{
	$.ajax({
	    url : '<?php echo base_url(); ?>campaign/activatecredibilitysession',
		type : 'POST',
		data: {namedrop_id : dropname_id},
		success : function(data){
		    window.location.href = "<?php echo base_url() ?>step/credibility";
		},
	});
}



function deleteDropname(credibility_id,status)
{
	var answer = confirm("Are you sure you want to proceed?")
	/** call ajax functionality to find and ajax call */
	if(answer){
		$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>campaign/deleteNameDropSess/',
				data: {credibility_id : credibility_id,status : status },
				cache: false,
				dataType: 'json',
				success: function(response)
				{
					console.log(response);
					location.reload(true);
					window.location.href = BASE_URL + 'folder/name-drop-examples';
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
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/ec2fndme0B8?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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