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
<?php
  $find_product = $this->campaign->getAllProduct();
  $find_all_campaign = $this->campaign->get_drop_campaign();
?>				    	
<div class="wrapper">

	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 
    <div style="text-align: right; margin-bottom:10px;">
        <a href="#" class="buttonM bRed dialog_help">Help Video</a>
    </div>
	<div class="fluid">
    	
	 <div class="grid12" style="width:100%; margin-left:0%;">     	
	 	<?php /*?><div class="myfolder" align="center" style="margin-left:0%;">
     		<div class="myfloder_box box-myfolder">
	            <div class="box box2">
	            	<div class="bxtitle"><h3>Identify Requirements</h3></div>	                
	            </div>
	            <div class="boxar">
	            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
	            </div>
	            <div class="box box3">
	            	<div class="bxtitle">
		            	<h3>Requirements Questions</h3>                
	                </div>
	            </div>
	            <div class="boxar">
	            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
	            </div>            
	            <div class="box box4">
	            	<div class="bxtitle"><h3>Intro Questions</h3></div>
	            </div>
	            <div class="boxar">
	            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
	            </div>            
	            <div class="box box5">
	            	<div class="bxtitle"><h3>Closing Questions</h3></div>
	            </div>
	            <div class="boxar">
	            	<img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
	            </div>            
	            <div class="box box6">
	            	<div class="bxtitle"><h3>Edit Questions</h3></div>	
	            </div>
     		</div>        	
        </div><?php */?><br clear="all">   	
		<div class="widget">
			<div class="body">
            	<form method="post" action="<?php echo current_url();?>" id="frmsort">
                	<input type="hidden" id="rcid" name="rcid" value="0" />
                    <input type="hidden" id="sord" name="sord" value="0" />
                    <input type="hidden" name="action" value="SortOrderupdate" />
                </form>
                <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                    <tbody>
                    	<tr style="border:none;">
                        	<td class="no-border" colspan="2"><h2 class="pt10">Question Lists</h2><br></td>
                        	<td class="no-border" colspan="2" align="right"></td>
                        </tr>
                        <?php if(!empty($allIntvQuestion)): ?>
                            <?php foreach($allIntvQuestion as $singleinterViewQes): ?>                                                                                            
                                    <tr>
                                        <td class="no-border">
                                            <h6><?php echo $singleinterViewQes->interview_ques_name; ?></h6>
                                        </td>                                                                                                        
                                        <td  width="20px" class="no-border"><a href="<?php echo base_url() ; ?>interviewer/question/<?php echo $singleinterViewQes->interv_ques_id; ?>" class="buttonM bGreen">Edit</a></td>
                                        <td  width="20px" class="no-border"><a href="<?php echo base_url() ; ?>questions/previewinterviewProfile/<?php echo $singleinterViewQes->interv_ques_id; ?>" class="buttonM bGreyish">View</a></td>
                                        <?php /*?><td  width="20px" class="no-border"><a href="<?php echo base_url() ; ?>questions/previewinterviewProfile/<?php echo $singleinterViewQes->job_id; ?>/<?php echo $singleinterViewQes->interv_ques_id; ?>" onClick="cloneCampaign(<?php echo $singleinterViewQes->interv_ques_id; ?>,<?php echo $singleinterViewQes->interv_ques_id; ?>);"><input type="button" class="buttonM bBlue" name="launch" value="Clone" /></a></td><?php */?>
                                        <td  width="20px" class="no-border"><a href="<?php echo base_url() ; ?>questions/delQuestion/<?php echo $singleinterViewQes->interv_ques_id; ?>" class="buttonM bRed">Delete</a></td>
                                        </td>                                                            
                                    </tr>                                                                                
                            <?php endforeach; ?>					                           
                        <?php endif; ?>					                            					                        
                    </tbody>
                </table>
                <br/>
                <a class="buttonM bRed" href="<?php echo base_url(); ?>interviewer/question">Create a Question List</a>
            </div>
		</div>
		

	</div>
	</div>
	<br/>
	
</div>
    <!-- Main content ends -->
</div>
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
<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/SvUj9hfAbxE?list=PLoUVJsDQgZILULYLgkn138N9GdMUPMlfc" frameborder="0" allowfullscreen></iframe>';
	//Rename record
	function RenameRecord(rid) {
		$("#edit_"+rid).click();
	}
	//create company profile
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
$(document).ready(function(){

//help button
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
function cloneCampaign(campaign_id,userId)
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

//Update Campaign Sort Order by Dev@4489
function update_record_sorder_submit(rcid,op,oval) {
	var std = $(oval).parent().parent();
	var txtval = parseInt(std.find(".rcorder").val());
	if(op==1) txtval++; else txtval--;
	//if(txtval<0) txtval=0;
	$("#rcid").val(rcid);
	$("#sord").val(txtval);
	$("#frmsort").submit();
}
//update sort order by arrows
function update_record_sorder(rcid,op,oval) {
	var std = $(oval).parent().parent().parent();
	var txtval = parseInt(std.find("input").val());
	if(op==1) txtval++; else txtval--;
	if(txtval<0) txtval=0;
	std.find("input").val(txtval);
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
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>