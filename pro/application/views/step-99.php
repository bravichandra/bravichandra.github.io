<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<?php //if($deleted_info!='') echo $deleted_info; else echo 'no';?>
<!-- Sidebar begins -->
<style>
.custom_content_tab
{
	float:left;
	width:65%;
}
.info_txt
{
	color:#757575;
	font-size: 12px;
}
.tab_container
{
	padding-bottom:20px;
}
.custom_content_tab tr td
{
	
}
.custom_content_tab tr td textarea
{
	width: 60%;
}
.custom_content_tab tr td input
{
	padding: 5px;
	width: 98%;
	border: 1px solid #CCCCCC;
}
.custom_content_tab .title
{
	padding: 20px;
	font-weight:bold;
	font-size: 12px;
	width: 20%;
	padding-left: 5px;
}
.custom_content_table_data
{
	padding: 20px;
}
.filldiv
{
	float: left;
	width: auto;
	margin: 13px;
	/*background: #000;
	color: #fff;*/
	padding: 10px;
}
</style>
<script type="text/javascript" src="<?php echo site_url('tiny_mce/tiny_mce.js'); ?>"></script>
<script type="text/javascript">


	tinyMCE.init({
		selector: "textarea",
		theme : "advanced",
		height : "350",
		
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom"
	});
</script>
<div id="sidebar">
	<?php echo $this->load->view('common/left_navigation');?>
    <!-- Secondary nav -->
    <div class="secNav">    
    	<div class="clear"></div>
   </div>
</div>

<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
    <!-- Breadcrumbs line -->
    <?php  echo $this->load->view('common/empty_nav');?>
    <?php
		//By Dev@4489
		$active_company=0;
		$active_namedrop=0;
		////
	?>
    <!-- Main content -->
    <div class="wrapper"> 
    	<?php if ($err): ?><br>
			<h3 style="color:red !important;"><?php echo $err; ?></h3>
		<?php endif; ?>    
       

	   <h3 style="margin-top:30px;">Custom Scripts Section (Optional)</h3>
	   <label class="info_txt">You only need to enter information on this page if you want to create a custom script. You can come back to this later after you view the scripts that are produced by the system and decide that you would like to edit more or create a custom flow</label><br clear="all" />
       <form id="changeform" action="<?php echo base_url();?>campaign/changeactiveelement" method="post">
        <table class="custom_content_tab">
            <tr>
                <td valign="middle">Sales Pitch</td>
                <td>
                    <select name="activecompaignname" style="float:right;" onchange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_campaign as $singlecampaign): ?>
                    <option value="<?php echo $singlecampaign->campaign_id; ?>"  <?php if($singlecampaign->status == 1){ echo "selected";} ?>><?php echo $singlecampaign->campaign_name; ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
                <td valign="middle">Name Drop</td>
                <td>
                    <select name="activedropname" style="float:right;" onchange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_name  as $singledropname): ?>
                    <option value="<?php echo $singledropname->c_id; ?>" <?php if($singledropname->status == 1){ $active_namedrop=$singledropname->c_id;echo "selected";} ?>><?php echo ($singledropname->value?$singledropname->value:$singledropname->credibility_name); ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
                <td valign="middle">Company</td>
                <td>
                    <select name="activecompanyname" style="float:right;" onchange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_company  as $singlecompany): ?>
                    <option value="<?php echo $singlecompany->company_id; ?>" <?php if($singlecompany->status == 1){ $active_company=$singlecompany->company_id;echo "selected";} ?>><?php echo $singlecompany->company_name; ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
            </tr>
        </table>
        </form>
       <form class='form_123' id="validate" action="<?php echo current_url();?>" method="post"><br/><br/>
       	<label><b>Template Name:</b> </label> 
	        <input type="text" name="cstm[title]" value="<?php echo $template_user?$template_user->temp_title:'Custom Script'; ?>" style="border:1px solid #CCCCCC; font-size:15px;width: 500px;"/>
            <input type="checkbox" name="cstm[hide]" value="1" <?php if($template_user->temp_hide) echo ' checked="checked"'; ?> /> Hide Template
        	<input type="hidden" name="campaignid" value="<?php echo $ecampaign_id; ?>"/> 
        <br clear="all" />
        <?php if($ecampaign_id){?>
    	<div id="tabs_123">
					<?php 
					$available_Ids = array();
					$stage_count = 0;
					if(!empty($customTemplateInfo))
					{
					foreach($customTemplateInfo as $key => $template_info)
					{
						
						?>
					<div class="widget custompro tableTabsdb<?php echo $template_info->id; ?>">
            <div class="tab_container">
                <div id="ttab1" class="tab_content">
					<div class="custom_content_table_data">
					<h5><span style="float:right;padding:30px;cursor:pointer;" onclick="deletefromDatabase(<?php echo $template_info->id; ?>);">X</span></h5>
                    <table class="custom_content_tab">
						<tr>
							<td class="title" valign="middle">Title</td>
							<td>
                            	<input type="hidden" name="cstm[<?php echo $template_info->id;?>][companyid]" value="<?php echo ($template_info->companyid)? $template_info->companyid : $active_company; ?>"/>
								<input type="hidden" name="cstm[<?php echo $template_info->id;?>][namedrop]" value="<?php echo ($template_info->namedrop)? $template_info->namedrop : $active_namedrop; ?>"/>
								<input type="text" name="cstm[<?php echo $template_info->id;?>][heading]" value="<?php echo ($template_info->heading!='')? $template_info->heading : ''; ?>"/>
								
							</td>
							
						</tr>
						<tr>
							<td class="title" valign="middle">Content</td>
							<td>
								<textarea id="contentdb<?php echo $template_info->id; ?>" class="tinyMCE" name="cstm[<?php echo $template_info->id; ?>][value]"><?php echo $template_info->value; ?></textarea>
								
							</td>
						</tr>
					</table>
					<div class="filldiv"><b>(Optional) Fill with SalesScripter generated content</b><br/>
					<b>* Warning: this will replace any text that you have entered</b>
					<br/>
					<select id="selectfilleddb<?php echo $template_info->id; ?>" onchange="changeContent(<?php echo $template_info->id; ?>,this, 'db')" style="float:right;">
					<option value="">Select</option>
					<option value="1">Introduction</option>
					<option value="2">Attention Grabbing Statement (Value)</option>
					<option value="3">Attention Grabbing Statement (Pain)</option>
					<option value="4">Attention Grabbing Statement (Name Drop)</option>
					<option value="5">Pre-Qualifying Questions</option>
					<option value="6">Examples of Common Problems</option>
					<option value="7">Company and Product Info</option>
					<option value="8">Close</option>
					</select>
					</div>
					</div>
					</div>
            </div>	
            <div class="clear"></div>
        </div>
               		<?php 
						$stage_count++;
						
					} // foreach
				} // if
				else
				{
				?>
					<div class="widget custompro tableTabsdb<?php echo $stage_count;?>">
            <div class="tab_container">
                <div id="ttab1" class="tab_content">
					<div class="custom_content_table_data">
					<h5><?php /*?><span style="float:right;padding:30px;cursor:pointer;" onclick="deletefromView(0, this);">X</span><?php */?></h5>
                    <table class="custom_content_tab">
						<tr>
							<td class="title" valign="middle">Title</td>
							<td>
                            	<input type="hidden" name="cstm[new][<?php echo $stage_count;?>][companyid]" value="<?php echo $active_company; ?>"/>
								<input type="hidden" name="cstm[new][<?php echo $stage_count;?>][namedrop]" value="<?php echo $active_namedrop; ?>"/>
								<input type="text" name="cstm[new][<?php echo $stage_count;?>][heading]" value="<?php echo ($template_info->heading!='')? $template_info->heading : 'Stage '.($stage_count+1); ?>"/>
								
							</td>
							
						</tr>
						<tr>
							<td class="title" valign="middle">Content</td>
							<td>
								<textarea id="contentdb<?php echo $stage_count;?>" class="tinyMCE" name="cstm[new][<?php echo $stage_count;?>][value]"><?php echo $template_info->value; ?></textarea>
								
							</td>
						</tr>
					</table>
					<div class="filldiv"><b>(Optional) Fill with SalesScripter generated content</b><br/>
					<b>* Warning: this will replace any text that you have entered</b>
					<br/>
					<select id="selectfilleddb<?php echo $stage_count;?>" onchange="changeContent(<?php echo $stage_count;?>,this,'db')" style="float:right;">
					<option value="">Select</option>
					<option value="1">Introduction</option>
					<option value="2">Attention Grabbing Statement (Value)</option>
					<option value="3">Attention Grabbing Statement (Pain)</option>
					<option value="4">Attention Grabbing Statement (Name Drop)</option>
					<option value="5">Pre-Qualifying Questions</option>
					<option value="6">Examples of Common Problems</option>
					<option value="7">Company and Product Info</option>
					<option value="8">Close</option>
					</select>
					</div>
					</div>
					</div>
            </div>	
            <div class="clear"></div>
        </div>			
				<?php
				$stage_count++;
				} ?>
         </div>       
		
		
		<div align="right">
			<input type="button" onclick="DynamicAddRowStage('<?php echo json_encode($available_Ids);?>')" class="buttonM bBlack" value="Add a Stage" style="margin-top:10px;color:white !important;">	        	
		</div>
		
	
        <div class="fluid" style="margin-top:15px;">
          	<input id="save_button" style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" /><input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bRed" name="submit_done" value="Done" />
          	<input type="hidden" name="step" value="custom_content">
            <?php /*?><a href="<?php echo base_url();?>folder/sales-scripts" class="buttonM bRed">Done</a><?php */?>
        </div>
        <?php }?>
        </form>	
        </div>
        </div>
    </div>
	<script>
	var pd_data = {1:['Introduction',''],
				   2:['Attention Grabbing Statement (Value)',''],
				   3:['Attention Grabbing Statement (Pain)',''],
				   4:['Attention Grabbing Statement (Name Drop)',''],
				   5:['Pre-Qualifying Questions',''],
				   6:['Examples of Common Problems',''],
				   7:['Company and Product Info',''],
				   8:['Close','']};
	console.log(pd_data);
	var counter = Number('<?php echo $stage_count; ?>');
	function changeContent(stageid, dis, frm)
	{
		$('.widget.tableTabs'+frm+stageid).find('input[type="text"]').val(pd_data[$(dis).val()][0]);
		//alert($('.widget.tableTabs'+stageid).find('input[type="text"]').val());
		//tinyMCE.get('content'+frm+stageid).setContent('');
		var dataContent = '';
		$(dis).attr('disabled','disabled');
		$($(dis).parent()).css('background','url("<?php echo base_url();?>images/spinner.gif") no-repeat');
		var jqxhr = $.ajax('<?php echo base_url();?>custom/getCustomContent/'+$(dis).val()).done(function(data) {
															console.log('Custom content retrieved successfully');
															$(dis).removeAttr('disabled');
															$($(dis).parent()).css('background','');
															tinyMCE.get('content'+frm+stageid).setContent(data);}).fail(function(){$('.custom_content_table_data').find('select').attr('disabled','disabled');alert('Unable to get the custom content, please refresh the page');});
															
		
		//$('#content'+frm+stageid).val(pd_data[$(dis).val()][1]);
	}
	function deletefromDatabase(delid)
	{
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: {'action_dev':'delete', 'id_dev':delid}
			}).done(function( data ) {
			if(data == 1) { $('.widget.tableTabsdb'+delid).fadeOut(); }
			else alert('not');
		  });
	}
	function deletefromView(delid,dis)
	{
		$(dis).parent().parent().parent().parent().parent().remove();
		counter--;
	}
	function initTinyMCECUST(stageid)
	{
		tinyMCE.init({
		selector: "#contentjs"+stageid,
		theme : "advanced",
		height : "350",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom"
		});
		$("#selectfilledjs"+stageid).uniform();
	}
	function DynamicAddRowStage(data)
	{
		
			data = '<div class="widget custompro tableTabsjs'+counter+'"><div class="tab_container"><div id="ttab1" class="tab_content"><div class="custom_content_table_data"><h5><span style="float:right;padding:30px;cursor:pointer;" onclick="deletefromView('+counter+', this);">X</span></h5><table class="custom_content_tab"><tr><td class="title" valign="middle">Title</td><td><input type="text" name="cstm[new]['+counter+'][heading]" value="Stage '+(Number(counter)+1)+'"/><input type="hidden" name="cstm[new]['+counter+'][companyid]" value="<?php echo $active_company;?>"/><input type="hidden" name="cstm[new]['+counter+'][namedrop]" value="<?php echo $active_namedrop;?>"/></td></tr><tr><td class="title" valign="middle">Content</td><td><textarea id="contentjs'+counter+'" class="tinyMCE" name="cstm[new]['+counter+'][value]"></textarea></td></tr></table><div class="filldiv"><b>(Optional) Fill with SalesScripter generated content</b><br/><b>* Warning: this will replace any text that you have entered</b><br/><select id="selectfilledjs'+counter+'" onchange="changeContent('+counter+',this,\'js\')" style="float:right;"><option value="">Select</option><option value="1">Introduction</option><option value="2">Attention Grabbing Statement (Value)</option><option value="3">Attention Grabbing Statement (Pain)</option><option value="4">Attention Grabbing Statement (Name Drop)</option><option value="5">Pre-Qualifying Questions</option><option value="6">Examples of Common Problems</option><option value="7">Company and Product Info</option><option value="8">Close</option></select></div></div></div></div><div class="clear"></div></div>';
			$('#tabs_123').append(data);
			initTinyMCECUST(counter);
			counter++;
		
	}
	</script>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>