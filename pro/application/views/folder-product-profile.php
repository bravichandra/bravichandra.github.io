<!-- Main content -->
<?php
  $find_product = $this->campaign->getAllProduct();
  $find_all_campaign = $this->campaign->get_drop_campaign();
?>				    	
<div class="wrapper" style="margin:0px;">
	<div style="text-align: right; margin-right:30px;">
        <a href="#" class="buttonM bRed dialog_help" >Help Video</a>
    </div>
	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 
		
    
	<div class="fluid">
     <div class="grid12" style="width:100%; margin-left:0%;">
        <div class="myfolder" align="center" style="margin-left:0%;"> 
           <br clear="all" />
            <div class="widget" style="margin:0px 30px;">
                <div class="body">							
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <tbody>
                            <tr style="border:none;-webkit-box-shadow:none;">
                                <td class="no-border" style="-webkit-box-shadow:none;" colspan="4"><h2 class="pt10">Product Profiles</h2></td>
                                <td class="no-border">&nbsp;</td>
                            </tr>
                            <tr style="border:none; background:#f7f7f7;-webkit-box-shadow:none;">
                                <td colspan="4" class="no-border" style="-webkit-box-shadow:none;">&nbsp;<br /></td>
                                <td class="no-border" style="padding:0px; text-align:center;-webkit-box-shadow:none;">Order<br /></td>
                            </tr>
                            <?php if ($find_product): ?>
                                <?php foreach ($find_product as $product): ?>	
                                        <tr>
                                            <td class="no-border">
                                                <h6><span class="dynamic_value edit_session" id="edit_<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></span></h6>
                                            </td>
                                            <?php //if($sessions->status == '0'):?>								                                	
                                            <td  width="20px;" class="no-border"><a href="#_" onClick="launchSession('<?php echo $product->product_id; ?>','no');"><input type="button" class="buttonM bGreen" name="launch" value="Edit" /></a></td>
                                            <td  width="20px" class="no-border"><a href="#_" onClick="RenameRecord(<?php echo $product->product_id; ?>);" ><input type="button" class="buttonM bGreyish" value="Rename" /></a></td>
                                            <td  width="20px;" class="no-border"><a href="#_" onClick="deleteSession('<?php echo $product->product_id; ?>','2');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
                                            <td width="60px" style="text-align: center;" class="no-border"><input type="text" onChange="update_record_sorder_txt(<?php echo $product->product_id; ?>,this)" size="2" class="rcorder" value="<?php echo $product->sorder; ?>" style="height: 25px;" />
                                            <?php //endif;?> <!--  <?php //if($sessions->status == '1'):?> <td  width="20px;" class="no-border"><a href="#_" onclick="deleteSession('<?php echo $sessions->session_id; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td> <?php //endif;?>  -->								                            
                                        </tr>
                                                                                    
                                <?php endforeach; ?>					                           
                            <?php endif; ?>					                            					                        
                        </tbody>
                    </table>
                    <br/> 
                    
                    <?php /*?><a href="<?php echo base_url(); ?>product/create_product" class="buttonM bRed"   id="myfolder_create" >Create a Product Profile</a><?php */?>
                    <div style="float:left; overflow:hidden;"><a href="javascript:void(0);" class="buttonM bRed" onClick="return create_product_profile()">Create a Product Profile</a></div><br clear="all" />
                    <!-- <a <?php if ($is_paid AND $total_sessions > 0) { ?> href="<?php echo base_url(); ?>product/create_product" class="buttonM bRed"   id="myfolder_create" <?php } else { ?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php } ?>>Create a Product Profile</a> -->
                </div>
            </div>
		 </div>
    </div>
	<br/>	
</div>

<script type="text/javascript">
	//Rename record
	function RenameRecord(rid) {
		$("#edit_"+rid).click();
	}
	//create Product profile
	function create_product_profile() {
		$.ajax({
		  type: "POST",
		  url: BASE_URL + 'product/create_product',
		  data: '',
		  cache: false,
		  dataType: 'json',
		  complete: function (jqxhr, txt_status) {
		  	location.replace(BASE_URL + 'step/product');
		  }
		});
		return false;
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
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/zFHKECbSjkU" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
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