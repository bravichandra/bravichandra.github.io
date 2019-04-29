<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<?php //if($deleted_info!='') echo $deleted_info; else echo 'no';?>
<!-- Sidebar begins -->
<style>
.custom_content_tab
{
	float:left;
	width:70%;
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
	padding: 4px;
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
{margin:2px;
}
.filldiv .box1{float:left;}
.filldiv .box2{float:left;}
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
    <?php  //echo $this->load->view('common/etemplate_nav');?>
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
		
	   <?php /*?><h3 style="margin-top:30px;"><?php echo $template_info->temp_title;?></h3><?php */?>      
       <br clear="all" />
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
        <br clear="all" /><br />
        <form class='form_123' id="validate" action="<?php echo current_url();?>" method="post">
        <label><b>Template Name:</b> </label> 
        <input type="text" name="cstm[title]" value="<?php echo $template_user?$template_user->temp_title:$template_info->temp_title; ?>" style="border:1px solid #CCCCCC; font-size:15px;width: 500px;"/>
        <input type="checkbox" name="cstm[hide]" value="1" <?php if($template_user->temp_hide) echo ' checked="checked"'; ?> /> Hide Template 
        <a href="<?php echo current_url();?>/reset" class="buttonM bGreen">Reset Template</a>
        <input type="hidden" value="<?php echo $template_info->temp_id;?>" name="cstm[temp_id]" />
        <?php if($ecampaign_id){?>
        
        <?php if($eIS) {//Interactive Script?>
        <div id="tabs_123">
        		<?php /*if(empty($template_content)){?>
                <h3 align="center" style="margin-top:30px;">No Custom Sections for this template.</h3>
                <?php }*/?>
				<?php 	
					$sort=0;
					$n=0;
					foreach($IStemplate as $key => $sect) {
						$sort=$sect->sect_id;$n++;
						if(is_object($sect)) $kindx = $sect->temp_aid; else $kindx = "N".$key;
					?>
                    <div class="widget custompro tableTabsdb<?php echo is_object($sect)?"ets".$sect->temp_aid:$key; ?>">                    	
                    	<?php if(is_object($sect)){?>
                        <h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="RemSection(<?php echo $kindx; ?>);">X</span></h5>
						<?php }else{?>
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $key; ?>);">X</span></h5>
                        <?php }?>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                    <tr>
                                        <td class="title" valign="middle">Voicemail #<?php echo $key; ?> Title</td>
                                        <td>
                                        	<input type="hidden" id="tsid<?php echo $key; ?>" name="cstm[<?php echo $kindx;?>][tsid]" value="-<?php echo $key; ?>"/>
                                            <input type="hidden" name="cstm[<?php echo $kindx;?>][sorder]" value="<?php echo $key; ?>"/>
                                            <input type="text" id="tsctitle<?php echo $key; ?>" name="cstm[<?php echo $kindx;?>][heading]" value="<?php echo is_object($sect)?$sect->sect_title:$sect['heading']; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Content</td>
                                        <td>
                                            <textarea id="contentdb<?php echo $key; ?>" class="tinyMCE" name="cstm[<?php echo $kindx;?>][value]"><?php echo is_object($sect)?$sect->sect_content:$sect['value']; ?></textarea>
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
                    <?php
					}
				
				?>
         </div>
        <?php }else {//General Script?>
    	<div id="tabs_123">
        		<?php /*if(empty($template_content)){?>
                <h3 align="center" style="margin-top:30px;">No Custom Sections for this template.</h3>
                <?php }*/?>
				<?php 	
				$sort=0;
				$n=0;				
				if(!empty($template_content)) {
					foreach($template_content as $tpldata) {$sort=$tpldata->sect_sort;						
						$n++;
					?>
					<div class="widget custompro tableTabsdb<?php echo "ets".$tpldata->temp_aid; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="RemSection(<?php echo $tpldata->temp_aid; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	<?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions"){?>
                                    <tr>
                                        <td class="title" valign="middle">Title</td>
                                        <td>                                            
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][heading]" value="<?php echo $tpldata->sect_title; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[<?php echo $tpldata->temp_aid;?>][sorder]" value="<?php echo $tpldata->sect_sort;?>" style="width: 40px;"/></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                    	<td></td>
                                        <td>
                                        	<?php if($template_info->temp_type<>"Sales Scripts" && $template_info->temp_type<>"Key Questions"){?>
                           					<input type="hidden" id="tsctitle<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][heading]" value="<?php echo $tpldata->sect_title; ?>"/>
                                            <input type="hidden" name="cstm[<?php echo $tpldata->temp_aid;?>][sorder]" value="<?php echo $tpldata->sect_sort;?>"/>                                            <?php }?>
                                        	<input type="hidden" id="tsid<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][tsid]" value="<?php echo $tpldata->sect_id; ?>"/>
                                        <div class="filldiv">                                
                                            <div class="box1">
                                            <b>(Optional) Fill with SalesScripter generated content</b><br/>
                                            <b>* Warning: this will replace any text that you have entered</b>
                                            </div>
                                            <div class="box2">
                                            <select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
                                            <?php echo $tsections;?>
                                            </select>
                                            </div>
                                        </div>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Content</td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" class="tinyMCE" name="cstm[<?php echo $tpldata->temp_aid;?>][value]"><?php echo $tpldata->sect_content;?></textarea>
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
               		<?php						
						if($template_info->temp_type=="Emails and Letters") break;
					} // foreach
				} else {
					foreach($template_sections as $key => $tsection) {$sort=$tsection->sect_id;$n++;
					?>
                    <div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $n; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	<?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions"){?>
                                    <tr>
                                        <td class="title" valign="middle">Title</td>
                                        <td>
                                        	
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][heading]" value="<?php echo $tsection->sect_title; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[N<?php echo $n; ?>][sorder]" value="<?php echo $n;?>" style="width: 40px;"/></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                    	<td></td>
                                        <td>
                                        <?php if($template_info->temp_type<>"Sales Scripts" && $template_info->temp_type<>"Key Questions"){?>
                                        <input type="hidden" id="tsctitle<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][heading]" value="<?php echo $tsection->sect_title; ?>"/>
                                        <input type="hidden" name="cstm[N<?php echo $n; ?>][sorder]" value="<?php echo $n;?>"/>
                                        <?php }?>
                                        <input type="hidden" id="tsid<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][tsid]" value="<?php echo $tsection->content_id; ?>"/>
                                        <div class="filldiv"> 
                                        <div class="box1">                               
                                        <b>(Optional) Fill with SalesScripter generated content</b><br/>
                                        <b>* Warning: this will replace any text that you have entered</b>
                                        </div>
                                        <div class="box2">
                                        <select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
                                        <?php echo $tsections;?>
                                        </select>
                                        </div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Content</td>
                                        <td>
                                            <textarea id="contentdb<?php echo$n; ?>" class="tinyMCE" name="cstm[N<?php echo $n; ?>][value]"><?php 
											$content_id=$tsection->content_id;
											include('outputs/custom_content/custom_etemplate_data.php');?></textarea>
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
                    <?php
						if($template_info->temp_type=="Emails and Letters") break;
					}
				}
				?>
         </div>       
		
		
		<?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions"){?>
		<div align="right">
			<input type="button" onclick="DynamicAddRowStage()" class="buttonM bBlack" value="Add a Stage" style="margin-top:10px;color:white !important;">	        	
		</div>	
        <?php }?>
        
        <?php }?>
        <div class="fluid" style="margin-top:15px;"><br clear="all" />
          	<input id="save_button" style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" /><input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bRed" name="submit_done" value="Done" />
          	<input type="hidden" name="step" value="custom_content"> 
            <?php /*?><a href="<?php echo base_url();?>folder/<?php if($template_info->temp_type=='Emails and Letters') echo 'email-templates';else if($template_info->temp_type=='Voicemail Scripts') echo 'voicemail-script'; else echo 'sales-scripts';?>" class="buttonM bRed">Done</a><?php */?>
        </div>
        <?php }?>
        </form>	
        </div>
        </div>
    </div>
	<script>
	var tsc_titles = {<?php echo $sbox_js;?>};
	var counter = <?php echo $n;?>;
	//Get Template section
	function changeContent(tid, tsid, dis,tdid)
	{
		if(tsid=="") return;console.log(tsc_titles[tsid][0]);
		$("#tsctitle"+tdid).val(tsc_titles[tsid]);
		$("#tsid"+tdid).val(tsid);
		var dataContent = '';
		//$(dis).hide();
		$($(dis).parent()).css('background','url("<?php echo base_url();?>images/spinner.gif") no-repeat');
		var jqxhr = $.ajax('<?php echo base_url();?>custom/getetemplate/'+tid+'-'+tsid).done(function(data) {
															//console.log('Custom content retrieved successfully');
															$(dis).show();
															$($(dis).parent()).css('background','');
															tinyMCE.get('contentdb'+tdid).setContent(data);}).fail(function(){$('.custom_content_table_data').find('select').attr('disabled','disabled');alert('Unable to get the custom content, please refresh the page');});
	}
	//Delete Template section
	function RemSection(delid)
	{
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: {'action_dev':'delete', 'id_dev':delid}
			}).done(function( data ) {
			if(data == 1) { $('.widget.tableTabsdbets'+delid).remove(); }
			else alert('not');
		  });
	}
	//Delete Template section
	function deleteSection(delid)
	{
		$('.widget.tableTabsdb'+delid).remove();
	}
	function initTinyMCECUST(stageid)
	{
		tinyMCE.init({
			selector: "#contentdb"+stageid,
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
		$("#sb"+stageid).uniform();
	}
	function DynamicAddRowStage()
	{
		counter++;
		data = '<div class="widget custompro tableTabsdb'+counter+'"><h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection('+counter+');">X</span></h5><div class="tab_container"><div id="ttab1" class="tab_content"><div class="custom_content_table_data"><table class="custom_content_tab"><tr><td class="title" valign="middle">Title</td><td><input type="hidden" id="tsid'+counter+'" name="cstm[N'+counter+'][tsid]" value="0"/><input type="text" id="tsctitle'+counter+'" name="cstm[N'+counter+'][heading]" value="Stage '+counter+'"/></td></tr><tr><td class="title" valign="middle">Sort Order</td><td><input type="text" name="cstm[N'+counter+'][sorder]" value="'+counter+'" style="width: 40px;"/></td></tr><tr><td></td><td><div class="filldiv"><div class="box1"><b>(Optional) Fill with SalesScripter generated content</b><br/><b>* Warning: this will replace any text that you have entered</b></div><div class="box2"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></div></div></td><tr><tr><td class="title" valign="middle">Content</td><td><textarea id="contentdb'+counter+'" class="tinyMCE" name="cstm[N'+counter+'][value]"></textarea></td></tr></table></div></div></div><div class="clear"></div></div>';
		$('#tabs_123').append(data);
		initTinyMCECUST(counter);
		
	}
	</script>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>