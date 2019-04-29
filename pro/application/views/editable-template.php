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
		document_base_url : "<?php echo base_url();?>",
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,jbimages",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor,jbimages",
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
		if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails") $temp68=1;
		////
	?>
    <!-- Main content -->
    <div class="wrapper">  
		<?php if ($err): ?><br>
			<h3 style="color:red !important;"><?php echo $err; ?></h3>
		<?php endif; ?>
        <?php if($my_ip==0 && 0){?><h1 style="color:#FF0000">Currently working on this email thread template</h1><?php }?>    
		
	   <?php /*?><h3 style="margin-top:30px;"><?php echo $template_info->temp_title;?></h3><?php */?>      
       <div style="text-align: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
       <br clear="all" />
       <form id="changeform" action="<?php echo base_url();?>campaign/changeactiveelement" method="post">
        <table class="custom_content_tab">
            <tr>
                <?php $jbid=0;if($template_info->temp_type=="Interview Emails") {?>
                <td valign="middle">Job Posting</td>
                <td>
                    <select name="activejob" style="float:right;" onChange="$('#changeform').submit();">
                        <option value="">Select</option>
                    <?php foreach($drop_jobpost  as $drop) { ?>
                        <option value="<?php echo $drop->post_id ?>" <?php if($drop->status == 1) {echo "selected";$jbid=$drop->post_id;}?>><?php echo $drop->job_title ?> </option>
                    <?php } ?>
                    </select>
                </td>
                <?php } else {?>
                <td valign="middle">Sales Pitch</td>
                <td>
                    <select name="activecompaignname" style="float:right;" onChange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_campaign as $singlecampaign): ?>
                    <option value="<?php echo $singlecampaign->campaign_id; ?>"  <?php if($singlecampaign->status == 1){ echo "selected";} ?>><?php echo $singlecampaign->campaign_name; ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
                <td valign="middle">Name Drop</td>
                <td>
                    <select name="activedropname" style="float:right;" onChange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_name  as $singledropname): ?>
                    <option value="<?php echo $singledropname->c_id; ?>" <?php if($singledropname->status == 1){ $active_namedrop=$singledropname->c_id;echo "selected";} ?>><?php echo ($singledropname->value?$singledropname->value:$singledropname->credibility_name); ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
                <?php }?>
                <td valign="middle">Company</td>
                <td>
                    <select name="activecompanyname" style="float:right;" onChange="$('#changeform').submit();">
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
        <?php //if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions"){?>
        <input type="checkbox" name="cstm[hide]" value="1" <?php if($template_user->temp_hide) echo ' checked="checked"'; ?> /> Hide Template 
        <?php if(!empty($template_content)) {?>
        <br />
        <b style="color:red !important;">This is now a customized template and this template is currently disconnected from the Sales Pitch Builder.</b>
        <a href="<?php echo current_url();?>/reset" class="buttonM bGreen">Reset and Reconnect</a>
        <?php }?>
        <?php if($template_info->temp_type=="Interview Emails" && !$jbid) {?>
        <br />
        <b style="color:red !important;">Job Posting not selected.</b>
        <?php }?>
        <input type="hidden" value="<?php echo $template_info->temp_id;?>" name="cstm[temp_id]" />
        <input type="hidden" value="<?php if($template_info->temp_type=="Interview Emails") echo $jbid; elseif($ecampaign_id) echo $ecampaign_id;?>" name="campaignid" />
        <?php if(($template_info->temp_type=="Interview Emails" && $jbid) || ($template_info->temp_type<>"Interview Emails" && $ecampaign_id)){?>
        
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
                        <h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onClick="RemSection(<?php echo $kindx; ?>);">X</span></h5>
						<?php }else{?>
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onClick="deleteSection(<?php echo $key; ?>);">X</span></h5>
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
    	<div id="tabs_123" title="Edit Template">
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
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onClick="RemSection(<?php echo $tpldata->temp_aid; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	<?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions" || $template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
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
                                    <?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
                                    <tr>
                                        <td class="title" valign="middle">Subject</td>
                                        <td>
                                            <input type="text" id="subject<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid; ?>][subject]" value="<?php echo form_prep($tpldata->sect_subject);?>"/>
                                        </td>
                                    </tr>
                                    <tr <?php if($n==1) echo 'style="display:none;"'?>>
                                        <td class="title" valign="middle">Schedule Delivery</td>
                                        <td>
                                            <select name="cstm[<?php echo $tpldata->temp_aid; ?>][dowcount]"><?php for($n1=1;$n1<=30;$n1++){ ?><option value="<?php echo $n1;?>"<?php if($tpldata->sect_dowcount==$n1) echo ' selected="selected"'?>><?php echo $n1; ?></option><?php } ?></select> 
                                            <select  name="cstm[<?php echo $tpldata->temp_aid; ?>][dow]"><option value="1">Days</option><option value="2"<?php if($tpldata->sect_dow==2) echo ' selected="selected"'?>>Weeks</option></select>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Email Template</td>
                                        <td style="padding-bottom: 4px;">
                                                <select onChange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
                                                <?php echo $tsections;?>
                                                </select>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                    	<td></td>
                                        <td>
                                        	<?php if($template_info->temp_type<>"Sales Scripts" && $template_info->temp_type<>"Key Questions" && $template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?>
                           					<input type="hidden" id="tsctitle<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][heading]" value="<?php echo $tpldata->sect_title; ?>"/>
                                            <input type="hidden" name="cstm[<?php echo $tpldata->temp_aid;?>][sorder]" value="<?php echo $tpldata->sect_sort;?>"/>                                            <?php }?>
                                        	<input type="hidden" id="tsid<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][tsid]" value="<?php echo $tpldata->sect_id; ?>"/>
                                            <?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?>  
                                            <div class="filldiv">                                
                                                <div class="box1">
                                                <b>(Optional) Fill with SalesScripter generated content</b><br/>
                                                <b>* Warning: this will replace any text that you have entered</b>
                                                </div>
                                                <div class="box2">
                                                <select onChange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
                                                <?php echo $tsections;?>
                                                </select>
                                                </div>
                                            </div>
                                            <?php }?>
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
						//if($my_ip && $template_info->temp_type=="Emails and Letters") break;					
					} // foreach
				} else {					
					foreach($template_sections as $key => $tsection) {$sort=$tsection->sect_id;$n++;
					?>
                    <div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onClick="deleteSection(<?php echo $n; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	<?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions" || $template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
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
                                    <?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
                                    <tr>
                                        <td class="title" valign="middle">Subject</td>
                                        <td>
                                            <input type="text" id="subject<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][subject]" value=""/>
                                        </td>
                                    </tr>
                                    <tr <?php if($n==1) echo 'style="display:none;"'?>>
                                        <td class="title" valign="middle">Schedule Delivery</td>
                                        <td>
                                            <select name="cstm[N<?php echo $n; ?>][dowcount]"><?php for($n1=1;$n1<=30;$n1++){ ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select> 
                                            <select  name="cstm[N<?php echo $n; ?>][dow]"><option value="1">Days</option><option value="2" selected="selected">Weeks</option></select>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Email Template</td>
                                        <td style="padding-bottom: 4px;">
                                            <select onChange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
                                            <?php echo $tsections;?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                    	<td></td>
                                        <td>
                                        <?php if($template_info->temp_type<>"Sales Scripts" && $template_info->temp_type<>"Key Questions" && $template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?>
                                        <input type="hidden" id="tsctitle<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][heading]" value="<?php echo $tsection->sect_title; ?>"/>
                                        <input type="hidden" name="cstm[N<?php echo $n; ?>][sorder]" value="<?php echo $n;?>"/>
                                        <?php }?>
                                        <input type="hidden" id="tsid<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][tsid]" value="<?php echo $tsection->content_id; ?>"/>
                                        <?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?>                                        
                                        <div class="filldiv"> 
                                        <div class="box1">                               
                                        <b>(Optional) Fill with SalesScripter generated content</b><br/>
                                        <b>* Warning: this will replace any text that you have entered</b>
                                        </div>
                                        <div class="box2">
                                        <select onChange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
                                        <?php echo $tsections;?>
                                        </select>
                                        </div>
                                        </div>
                                        <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Content</td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" data-sno="<?php echo $n; ?>" class="tinyMCE" name="cstm[N<?php echo $n; ?>][value]"><?php 
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
						//if($my_ip && $template_info->temp_type=="Emails and Letters") break;
					}
				}
				?>
         </div>       
		
		
		<?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions" || $template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
		<div align="right">
			<input type="button" onClick="DynamicAddRowStage()" class="buttonM bBlack" value="<?php echo (($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Add Email':'Add a Stage');?>" style="margin-top:10px;color:white !important;">	        	
		</div>	
        <?php }?>
        
        <?php }?>
        
        <div class="fluid" style="margin-top:15px;<?php if($my_ip==0 && 0) echo 'display:none;';?>"><br clear="all" />
          	<input id="save_button" style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" />
            <input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bRed" name="submit_done" value="Done" />
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
		if(tsid=="") return;
		<?php //if($eid==68)
				if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")
			{?>
			var n1=tsid.split("-");
			var contentid =n1[1]; 
			$("#tsctitle"+tdid).val(tsc_titles[contentid]);
			$("#tsid"+tdid).val(contentid);
			var dataContent = '';
			//$(dis).hide();
			$($(dis).parent()).css('background','url("<?php echo base_url();?>images/spinner.gif") no-repeat');
			var jqxhr = $.ajax({ type: "POST",cache: false,  url: '<?php echo base_url();?>home/get_emailTemplate/'+tsid, data: { action: 'etemplate' }
					}).done(function(data) {
					//console.log('Custom content retrieved successfully');
					$(dis).show();
					$($(dis).parent()).css('background','');
					var evar = JSON.parse(data);
					$.each(evar, function(i, itm) {
						data = itm.info;
					});
					if(data.length==0) return;					
					var sndl="<p><strong>Subject line:</strong>";
					var endl="</p>";
					var emt2=data.split(sndl);
					var emt3=emt2[1].split(endl);
					var emsub=emt3[0];
					emsub = emsub.replace("<span>","");
					emsub = emsub.replace("</span>","");
					var em2=sndl+emt3[0]+endl;
					data = data.replace(em2,"");
					data = data.replace("<p><strong>Email body:</strong></p>","");
					data = data.replace(" edit_area","");
					$("#subject"+tdid).val(emsub);
					tinyMCE.get('contentdb'+tdid).setContent(data);
				}).fail(function(){
					$('.custom_content_table_data').find('select').attr('disabled','disabled');alert('Unable to get the custom content, please refresh the page');
				});
		<?php }else{?>
			$("#tsctitle"+tdid).val(tsc_titles[tsid]);
			$("#tsid"+tdid).val(tsid);
			var dataContent = '';
			//$(dis).hide();
			$($(dis).parent()).css('background','url("<?php echo base_url();?>images/spinner.gif") no-repeat');
			var jqxhr = $.ajax('<?php echo base_url();?>custom/getetemplate/'+tid+'-'+tsid).done(function(data) {
				//console.log('Custom content retrieved successfully');
					$(dis).show();
					$($(dis).parent()).css('background','');
					tinyMCE.get('contentdb'+tdid).setContent(data);
				}).fail(function(){
					$('.custom_content_table_data').find('select').attr('disabled','disabled');alert('Unable to get the custom content, please refresh the page');
				});
		<?php }?>	
			
			
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
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,jbimages",
	
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor,jbimages",
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
		data = '<div class="widget custompro tableTabsdb'+counter+'"><h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection('+counter+');">X</span></h5><div class="tab_container"><div id="ttab1" class="tab_content"><div class="custom_content_table_data"><table class="custom_content_tab"><tr><td class="title" valign="middle">Title</td><td><input type="hidden" id="tsid'+counter+'" name="cstm[N'+counter+'][tsid]" value="0"/><input type="text" id="tsctitle'+counter+'" name="cstm[N'+counter+'][heading]" value="<?php echo(($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Email':'Stage');?> '+counter+'"/></td></tr><tr><td class="title" valign="middle">Sort Order</td><td><input type="text" name="cstm[N'+counter+'][sorder]" value="'+counter+'" style="width: 40px;"/></td></tr><?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?><tr><td class="title" valign="middle">Subject</td><td><input type="text" id="subject'+counter+'" name="cstm[N'+counter+'][subject]" value=""/></td></tr><tr><td class="title" valign="middle">Schedule Delivery</td><td class="sd'+counter+'"><select name="cstm[N'+counter+'][dowcount]"><?php for($n1=1;$n1<=30;$n1++){ ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select  name="cstm[N'+counter+'][dow]"><option value="1">Days</option><option value="2" selected="selected">Weeks</option></select></td></tr><tr><td class="title" valign="middle">Email Template</td><td style="padding-bottom: 4px;"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></td></tr><?php }?><tr><td></td><td><?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?><div class="filldiv"><div class="box1"><b>(Optional) Fill with SalesScripter generated content</b><br/><b>* Warning: this will replace any text that you have entered</b></div><div class="box2"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></div></div><?php }?></td><tr><tr><td class="title" valign="middle">Content</td><td><textarea id="contentdb'+counter+'" class="tinyMCE" name="cstm[N'+counter+'][value]"></textarea></td></tr></table></div></div></div><div class="clear"></div></div>';
		$('#tabs_123').append(data);
		initTinyMCECUST(counter);
		<?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
		$(".sd"+counter+" select").uniform();
		<?php }?>
	}
	<?php if(isset($temp68)){?>
	$(document).ready(function(){
		$("textarea").each(function(){
			var evar = $(this).val();
			var x1=$(this).attr("data-sno");
			if(evar!=undefined && evar.length!=0) {
				var sndl="<p><strong>Subject line:</strong>";
				var endl="</p>";
				var emt2=evar.split(sndl);
				var emt3=emt2[1].split(endl);
				var emsub=emt3[0];
				emsub = emsub.replace("<span>","");
				emsub = emsub.replace("</span>","");
				var em2=sndl+emt3[0]+endl;
				evar = evar.replace(em2,"");
				$("#subject"+x1).val(emsub);
				$(this).val(evar);
			}
		});
	});	
	<?php }?>
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/AswcPX5DyuE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>