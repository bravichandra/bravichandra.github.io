<!-- Main content -->
<?php
  $find_product = $this->campaign->getAllProduct();
  $find_all_campaign = $this->campaign->get_drop_campaign();
?>				    	
<div class="wrapper">
	<div style="text-align: right;">
        <a href="#" class="buttonM bRed dialog_help" >Help Video</a>
    </div>
	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 		
    
	<div class="fluid">
    	
        <div class="grid12" style="width:100%; margin-left:0%;" >
        	<div class="myfolder" align="center" style="margin-left:0%;">  
			<?php /*?><div class="myfloder_box">                 	
            <div class="box">
            	<div class="bxtitle">
	            	<h3>Create Campaign Coordinates</h3>                
                </div>
                <div class="bxlink">
            		<a href="<?php echo base_url(); ?>home/campaign-coordinates" class="buttonM bRed">Go Here</a>
                </div>
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
             <div class="box active">
            	<div class="bxtitle bxtitle1"><h3>Create a Sales Pitch Campaign</h3></div>
                            
            	 <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
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
            <div class="box">
            	<div class="bxtitle"><h3>Create a Name Drop</h3></div>
                <div class="bxlink">
            	<a href="<?php echo base_url(); ?>folder/name-drop-examples" class="buttonM bRed">Go Here</a></div>
            </div>
        </div>
		</div>
		<div class="myfloder_box1 myfloder_box2 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div><?php */?>
		<br clear="all" />
	
	<!--  for campaign page  -->
	 
		
			<div class="widget">
				<div class="body">															
					<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
						<tbody>
                            <tr style="border:none;-webkit-box-shadow:none;">
	                        	<td class="no-border" style="-webkit-box-shadow:none;"><h2 class="pt10">Sales Pitches</h2></td>
	                            <td class="no-border" style="padding:0px;text-align:center;-webkit-box-shadow:none;">&nbsp;</td>
	                            <td colspan="4" class="no-border" style="-webkit-box-shadow:none;">&nbsp;</td>
	                            <td class="no-border" style="padding:0px; text-align:center;-webkit-box-shadow:none;">&nbsp;</td>
	                        </tr>
	                        <tr style="border:none; background:#f7f7f7;-webkit-box-shadow:none;">
	                        	<td class="no-border" style="-webkit-box-shadow:none;">&nbsp;<br /></td>
	                            <td class="no-border" style="padding:0px;text-align:center;-webkit-box-shadow:none;">Hide<br /></td>
	                            <td colspan="4" class="no-border" style="-webkit-box-shadow:none;">&nbsp;<br /></td>
	                            <td class="no-border" style="padding:0px; text-align:center;-webkit-box-shadow:none;">Order<br /></td>
	                        </tr>
						    <?php //if($find_product){ ?>                        
							<?php if(!empty($find_all_campaign)): ?>
								<?php foreach($find_all_campaign as $singlecampaign): ?>
																								
										<tr>
											<td class="no-border">
												<h6><span class="dynamic_value edit_campaign_session" id="edit_<?php echo $singlecampaign->campaign_id; ?>"><?php echo $singlecampaign->campaign_name; ?></span></h6>
											</td>
											 <td  width="20px" class="no-border" style="text-align:center;"><input type="checkbox" value="<?php echo $singlecampaign->campaign_id; ?>" 
                                         onchange="primaryScript(<?php echo $singlecampaign->campaign_id; ?>,this);" <?php if($singlecampaign->hide==1) echo "checked='checked'"; else echo ""; ?>/></td>						                                	
											<td  width="20px;" class="no-border"><a href="#_" onClick="launchSessionCampaign('<?php echo $singlecampaign->campaign_id; ?>','no');"><input type="button" class="buttonM bGreen" name="launch" value="Edit" /></a></td>
                                        <td  width="20px" class="no-border"><a href="#_" onClick="cloneCampaign(<?php echo $singlecampaign->campaign_id; ?>);"><input type="button" class="buttonM bBlue" name="launch" value="Clone" /></a></td>
                                        <td  width="20px" class="no-border"><a href="#_" onClick="RenameRecord(<?php echo $singlecampaign->campaign_id; ?>);" ><input type="button" class="buttonM bGreyish" value="Rename" /></a></td>
											<td  width="20px;" class="no-border"><a href="#_" onClick="deleteSessionCampaign('<?php echo $singlecampaign->campaign_id; ?>','<?php echo '0'; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
                                            <td width="60px" class="no-border" style="text-align:center;"><input type="text" onChange="update_record_sorder_txt(<?php echo $singlecampaign->campaign_id; ?>,this)" size="2" class="rcorder" value="<?php echo $singlecampaign->sorder; ?>" style="height:25px;" />
                                        </td>
																			                            
										</tr>
														                            
								<?php endforeach; ?>					                           
							<?php endif; ?>	
                          <?php //} ?>  				                            					                        
						</tbody>
					</table>
					<br/>
					<?php /*?><a class="buttonM bRed" id="myfolder_create" href="<?php echo base_url(); ?>campaign/createcampaign">Create a Sales Pitch Campaign</a><?php */?>
                    <div style="float:left;"><a class="buttonM bRed" href="javascript:void(0);" onClick="return create_campaign_profile()">Create a Sales Pitch</a>
                <a class="buttonM bRed" href="javascript:void(0);" onClick="view_campaign_prebuilt();">View Prebuilt Sales Pitches</a></div>
                <br clear="all" />
				</div>
			</div>
		
    
		
	</div>
	</div>
	<br/>
	
</div><br  clear="all"/>

<script type="text/javascript">
	//Rename record
	function RenameRecord(rid) {
		$("#edit_"+rid).click();
	}
	//create campaign profile
	function create_campaign_profile() {
		$.ajax({
		  type: "POST",
		  url: BASE_URL + 'campaign/createcampaign',
		  data: '',
		  cache: false,
		  dataType: 'json',
		  complete: function (jqxhr, txt_status) {
		  	location.replace(BASE_URL + 'campaign/startcampaigncreate');
		  }
		});
		return false;
	}
	
	function view_campaign_prebuilt() {
		$.ajax({
		  url: "<?php echo base_url()."home/prebuilt_campaigns_popup" ?>",
		  cache: false, 
		  success: function(response){
			$('.video1').html(response);
         	$('.help_dialog1').dialog('open');
		  }
		});
		return false;
	}
	
	
$(document).ready(function(){

	$('.edit_campaign_session').editable('<?php echo base_url()?>campaign/edit_campaign_session', { 
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


function launchSessionCampaign(session_id,t_m_session)
{
	$.ajax({
			type: "POST",
			url: BASE_URL + 'campaign/edit_campaign/',
			data: 'session_id='+session_id+'&t_m_session='+t_m_session,
			cache: false,
			dataType: 'json',
			success: function(response)
			{
				//console.log(response);
				window.location.href = BASE_URL + 'campaign/startcampaigncreate';
			}
		});
}



function deleteSessionCampaign(campaign_id,status)
{
	var answer = confirm("Are you sure you want to proceed?")
	/** call ajax functionality to find and ajax call */
	if(answer){
		$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>campaign/deleteCampaign/',
				data: {campaign_id : campaign_id,status : status },
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

/**
 *  Clone campaign to current user again
 */
function cloneCampaign(campaign_id)
{
    // return ;
	$.ajax({
		type: "POST",
		url: BASE_URL + 'campaign/cloneCampaignToCurUser/',
		data: 'campaign_id='+campaign_id,
		cache: false,
		dataType: 'json',
		success: function(response)
		{
			location.reload(true);
		}
	});
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
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/op8PdhNAbGk" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
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
	
	 $('.help_dialog1').dialog({
        autoOpen: false,
        height: 400,
        width: 600,
        buttons: {
            "Close": function () {
				$('.video1').html('');
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
		  
		 $('.video1').html('');
		 $('.help_dialog1').dialog('close');
        return false;
    });
	
});
function primaryScript(tempid,dis)
{
	var vis = dis.checked?1:0;
	var position = $(dis).position();
	var offset = $(dis).offset();
	$('.pleasewait').css('top',offset.top);
	$('.pleasewait').css('left',offset.left);
	$('.pleasewait').css('display','block');
	$.ajax({
		type : 'POST',
		url : '<?php echo base_url('campaign/hideCampaigns');?>',
		data: 'campaign_id='+tempid+'&val='+vis,
		cache: false,
		dataType: 'json',
		success: function(responce)
		{
			$('.pleasewait').css('display','none');
			location.replace("https://salesscripter.com/pro/folder/campaigns");
		}
	});
}  
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


<div class="help_dialog1" style="width:875px !important; margin:0px auto;" title="Prebuilt Campaigns">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prebuilt Campaigns</title>
</head>

<body>
 <div class="video1">
       
 </div>
</body>
</html></div>