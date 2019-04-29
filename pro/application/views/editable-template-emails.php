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


.btn {
  background-color: #fff;
  padding: 1em 3em;
  border-radius: 3px;
  text-decoration: none;
}

.modal-window {
  position: fixed;
  background-color: rgba(255, 255, 255, 0.25);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 999;
  opacity: 0;
  pointer-events: none;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
}

.modal-window:target {
  opacity: 1;
  pointer-events: auto;
}

.modal-window>div {
  width: 400px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 2em;
  background: #ffffff;
  color: #333333;
}

.modal-window header {
  font-weight: bold;
}

.modal-close {
  color: #aaa;
  line-height: 50px;
  font-size: 80%;
  position: absolute;
  right: 0;
  text-align: center;
  top: 0;
  width: 70px;
  text-decoration: none;
}

.modal-close:hover {
  color: #000;
}

.modal-window h1 {
  font-size: 150%;
  margin: 0 0 15px;
  color: #333333;
}
.shortcode_buttons button
{
	color: #65909a;
    font-weight: normal;
    background: transparent;
    border: 0px;
    margin-bottom: 10px;
}
i {
  vertical-align: middle;
}

</style>
<script type="text/javascript" src="<?php echo site_url('tiny_mce/tiny_mce.js'); ?>"></script>
<script type="text/javascript">


	tinyMCE.init({
		selector: "textarea.tinyMCE",
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
        $Schedules = array(
            'Follow up with a phone call',
            'Follow up with an email',
            'Stop by in person',
            'Follow up on social media',
            'Attend meeting',
            //'Date'
            );
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
                    <select name="activejob" style="float:right;" onchange="$('#changeform').submit();">
                        <option value="">Select</option>
                    <?php foreach($drop_jobpost  as $drop) { ?>
                        <option value="<?php echo $drop->post_id ?>" <?php if($drop->status == 1) {echo "selected";$jbid=$drop->post_id;}?>><?php echo $drop->job_title ?> </option>
                    <?php } ?>
                    </select>
                </td>
                <?php } else {?>
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
                <?php }?>
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
            <input type="hidden" name="remschids" id="remschids" value="" />
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
        
        
    	<div id="tabs_123" title="Edit Template" class="emltemplates">
        		<?php /*if(empty($template_content)){?>
                <h3 align="center" style="margin-top:30px;">No Custom Sections for this template.</h3>
                <?php }*/?>
				<?php 	
				$sort=0;
				$n=0;		
                //Customized contents		
				if(!empty($template_content)) {
					foreach($template_content as $tpldata) {$sort=$tpldata->sect_sort;						
						$n++;
					?>
					<div class="widget custompro tableTabsdb<?php echo $n; ?>">
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	<?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
                                    <tr>
                                        <td class="title" valign="middle">Title</td>
                                        <td>                                            
                                            <input type="text" class="theading" id="tsctitle<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][heading]" value="<?php echo $tpldata->sect_title; ?>"/>
                                            <span class="close" onclick="RemSection(<?php echo $tpldata->temp_aid; ?>,<?php echo $n; ?>);">X</span>
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[<?php echo $tpldata->temp_aid;?>][sorder]" value="<?php echo $tpldata->sect_sort;?>" class="sortorder" /></td>
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
                                                <select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
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
                                            <input type="hidden" name="cstm[<?php echo $tpldata->temp_aid;?>][slno]" value="<?php echo $n; ?>"/>

                                            <input type="hidden" name="record[emlindx][]" value="<?php echo $n?>" />         
                                            <input type="hidden" name="record[blocktype][]" class="blocktype" value="email" />
                                            <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $n?>" />

                                            <?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?>  
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
                                            <?php }?>
                                        </td>                                        
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Content</td>
                                        <td>
                                        	<div class="container" style="margin-bottom:10px;">
                                                  <div class="interior">
                                                    <a id="myBtn" href="#open-modal" class="buttonM bGreen" onclick="getpopUp(1);">Link Email to CRM Fields</a>
                                                  </div>
                                            </div>
                                            <textarea id="contentdb<?php echo $n; ?>" class="tinyMCE" name="cstm[<?php echo $tpldata->temp_aid;?>][value]"><?php echo $tpldata->sect_content;?></textarea>
                                        </td>
                                    </tr>
                                    <tr class="emailnode">
                                        <td></td>
                                        <td class="buttons"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onclick="DynamicAddRowStage(this)" /> 
                                        <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onclick="addtask(this)" data-colp="0" />
                                        </td>              
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
                    <!-- FOLLOW UP TASKS-->
                    <?php 
                        if(isset($email_tasks[$tpldata->temp_aid])) {
                            $subemail_tasks = $email_tasks[$tpldata->temp_aid];
                            foreach($subemail_tasks as $etask) {$n++;
                        ?>
                        <div class="widget custompro tableTabsdb<?php echo $n; ?>">
                            <div class="tab_container">
                                <div id="ttab1" class="tab_content">
                                    <div class="custom_content_table_data scftask">
                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                            <tr>
                                                <th class="Title one" width="225px">Follow-Up Task</th>
                                                <td colspan="2" align="right"><a href="javascript:void(0);" class="deletechild close" onclick="delete_sch(<?php echo $n?>,<?php echo $etask->id;?>)">X</a></td>
                                            </tr>
                                            <tr class="schrowTimes">
                                                <th class="one">Schedule Timing</th>
                                                <td colspan="2" class="two">
                                                    <input type="hidden" name="record[schindx][]" value="<?php echo $n;?>" />
                                                    <input type="hidden" name="record[blocktype][]" class="blocktype" value="task" />
                                                    <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $n?>" />
                                                    <input type="hidden" name="record[schids][]" value="<?php echo $etask->id?>" />
                                                    <?php
                                                        $task_duedate_parts = array('','');
                                                        if($etask->task_duedate) {
                                                            $task_duedate_parts = explode("-",$etask->task_duedate);
                                                        }
                                                        $schOpt=0;
                                                    ?>
                                                    <div>
                                                        <select name="record[tsk_schcounts][]" id="tsk_schcount<?php echo $n?>"><option value="">Select number</option><?php for($tn=1;$tn<=30;$tn++){ ?><option value="<?php echo $tn;?>"<?php if($task_duedate_parts[0]==$tn) echo ' selected="selected"'?>><?php echo $tn; ?></option><?php } ?></select> 
                                                        <select  name="record[tsk_schtypes][]" id="tsk_schtype<?php echo $n?>"><option value="">Select Day/Week</option><option value="1"<?php if($task_duedate_parts[1]=="1") echo ' selected="selected"'?>>Days</option><option value="2"<?php if($task_duedate_parts[1]=="2") echo ' selected="selected"'?>>Weeks</option></select>                                
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="one"></th>
                                                <td class="two">
                                                    <?php foreach($Schedules as $ci=>$option) {
                                                        if($etask->task_subject==$option) {$sel=' checked="checked"';$schOpt=1;} else $sel='';
                                                        ?>
                                                    <div><input type="radio" class="optval" <?php echo $sel?> name="record[schs][<?php echo $n;?>]" value="<?php echo $option;?>" onchange="inter_change(this)" /> <?php echo $option;?></div>
                                                    <?php }
                                                        $sel='';
                                                    ?>
                                                    <div>
                                                        <input type="radio" name="record[schs][<?php echo $n;?>]" class="optval schother" <?php echo $sel?> value="O" onchange="inter_change(this)" /> Other 
                                                        <span class="span_schother"  <?php echo ($sel?'':'style="display:none;"')?>>
                                                            <input name="record[sch_txts][]" type="text" value="<?php echo ($sel?$etask->task_subject:'')?>" class="scho_txt" />
                                                        </span>
                                                    </div>                                
                                                </td>
                                                <td class="two"><b>Notes:</b><br />
                                                    <textarea class="txtnotes" id="schinotes" name="record[schnotess][]" style="height:100px;"><?php echo $etask->task_info?></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }//end for tasks?>

                    <?php }//end if tasks?>
                    <!-- FOLLOW UP TASKS-->
               		<?php	
						//if($my_ip && $template_info->temp_type=="Emails and Letters") break;					
					} // foreach
				} else {	
                    //default contents				
					foreach($template_sections as $key => $tsection) {$sort=$tsection->sect_id;$n++;
					?>
                    <div class="widget custompro tableTabsdb<?php echo $n; ?>">                    	
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	<?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
                                    <span class="close" style="margin-top:-25px; padding-right:0px;" onclick="deleteSection(<?php echo $n; ?>);">X</span>
                                    <tr>
                                        <td class="title" valign="middle">Title</td>
                                        <td>
                                            <input type="text" class="theading" id="tsctitle<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][heading]" value="<?php echo $tsection->sect_title; ?>"/>
                                            
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[N<?php echo $n; ?>][sorder]" value="<?php echo $n;?>" class="sortorder"/></td>
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
                                            <select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,<?php echo $n; ?>)">
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
                                        <input type="hidden" name="cstm[N<?php echo $n; ?>][slno]" value="<?php echo $n; ?>"/>

                                        <input type="hidden" name="record[emlindx][]" value="<?php echo $n?>" />         
                                        <input type="hidden" name="record[blocktype][]" class="blocktype" value="email" />
                                        <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $n?>" />

                                        <?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?>                                        
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
                                        <?php }?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Content</td>
                                        <td>
                                        	<div class="container" style="margin-bottom:10px;">
                                                  <div class="interior">
                                                    <a id="myBtn" href="#open-modal" class="buttonM bGreen" onclick="getpopUp(1);">Link Email to CRM Fields</a>
                                                  </div>
                                            </div>
                                            <textarea id="contentdb<?php echo $n; ?>" data-sno="<?php echo $n; ?>" class="tinyMCE" name="cstm[N<?php echo $n; ?>][value]"><?php 
											$content_id=$tsection->content_id;
											include('outputs/custom_content/custom_etemplate_data.php');?></textarea>
                                        </td>
                                    </tr>
                                    <tr class="emailnode">
                                        <td></td>
                                        <td class="buttons"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onclick="DynamicAddRowStage(this)" /> 
                                        <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onclick="addtask(this)" data-colp="0" />
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

                <!-- FOLLOW UP TASK-->
                <?php /*<div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    <div class="tab_container">
                        <div id="ttab1" class="tab_content">
                            <div class="custom_content_table_data scftask">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <tr>
                                        <th class="Title one" width="225px">Follow-Up Task</th>
                                        <td colspan="2" align="right"><a href="javascript:void(0);" class="deletechild close" onClick="delete_sch(<?php echo $n?>,<?php echo $etask->id;?>)">X</a></td>
                                    </tr>
                                    <tr class="schrowTimes">
                                        <th class="one">Schedule Timing</th>
                                        <td colspan="2" class="two">
                                            <input type="hidden" name="record[schindx][]" value="<?php echo $n;?>" />
                                            <input type="hidden" name="record[blocktype][]" class="blocktype" value="task" />
                                            <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $n?>" />
                                            <input type="hidden" name="record[schids][]" value="0" />
                                            <div>
                                                <select name="record[tsk_schcounts][]" id="tsk_schcount<?php echo $n?>"><option value="">Select number</option><?php for($tn=1;$tn<=30;$tn++){ ?><option value="<?php echo $tn;?>"<?php if($task_duedate_parts[0]==$tn) echo ' selected="selected"'?>><?php echo $tn; ?></option><?php } ?></select> 
                                                <select  name="record[tsk_schtypes][]" id="tsk_schtype<?php echo $n?>"><option value="">Select Day/Week</option><option value="1"<?php if($task_duedate_parts[1]=="1") echo ' selected="selected"'?>>Days</option><option value="2"<?php if($task_duedate_parts[1]=="2") echo ' selected="selected"'?>>Weeks</option></select>                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="one"></th>
                                        <td class="two">
                                            <?php foreach($Schedules as $ci=>$option) {
                                                $sel='';
                                                ?>
                                            <div><input type="radio" class="optval" <?php echo $sel?> name="record[schs][<?php echo $n;?>]" value="<?php echo $option;?>" onChange="inter_change(this)" /> <?php echo $option;?></div>
                                            <?php }
                                                $sel='';
                                            ?>
                                            <div>
                                                <input type="radio" name="record[schs][<?php echo $n;?>]" class="optval schother" <?php echo $sel?> value="O" onChange="inter_change(this)" /> Other 
                                                <span class="span_schother"  <?php echo ($sel?'':'style="display:none;"')?>>
                                                    <input name="record[sch_txts][]" type="text" value="" class="scho_txt" />
                                                </span>
                                            </div>                                
                                        </td>
                                        <td class="two"><b>Notes:</b><br />
                                            <textarea class="txtnotes" id="schinotes" name="record[schnotess][]" style="height:100px;"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>*/?>
                <!-- FOLLOW UP TASK-->
         </div>       
		
		
		<?php /*if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
		<div align="right">
			<input type="button" onclick="DynamicAddRowStage(this)" class="buttonM bBlack" value="<?php echo (($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Add Email':'Add a Stage');?>" style="margin-top:10px;color:white !important;">	        	
		</div>	
        <?php }*/?>
        
        
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
	function RemSection(delid,sno)
	{
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: {'action_dev':'delete', 'id_dev':delid}
			}).done(function( data ) {
			if(data == 1) { $('.widget.tableTabsdb'+sno).remove(); }
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
	function DynamicAddRowStage(dis)
	{
        var sftb = $(dis).parents(".custompro");
		counter++;
		data = '<div class="widget custompro tableTabsdb'+counter+'"><div class="tab_container"><div id="ttab1" class="tab_content"><div class="custom_content_table_data"><table class="custom_content_tab"><span style="margin-top:-25px; padding-right:0px;" class="close" onclick="deleteSection('+counter+');">X</span><tr><td class="title" valign="middle">Title</td><td><input type="hidden" id="tsid'+counter+'" name="cstm[N'+counter+'][tsid]" value="0"/><input type="hidden" name="cstm[N'+counter+'][slno]" value="'+counter+'"/><input type="hidden" name="record[emlindx][]" value="'+counter+'" /> <input type="hidden" name="record[blocktype][]" class="blocktype" value="email" /> <input type="hidden" name="record[slno][]" class="slno" value="'+counter+'" /><input type="text" class="theading" id="tsctitle'+counter+'" name="cstm[N'+counter+'][heading]" value="<?php echo(($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Email':'Stage');?> '+counter+'"/></td></tr><tr style="display: none;"><td class="title" valign="middle">Sort Order</td><td><input type="text" name="cstm[N'+counter+'][sorder]" value="'+counter+'" class="sortorder"/></td></tr><?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?><tr><td class="title" valign="middle">Subject</td><td><input type="text" id="subject'+counter+'" name="cstm[N'+counter+'][subject]" value=""/></td></tr><tr><td class="title" valign="middle">Schedule Delivery</td><td class="sd'+counter+'"><select name="cstm[N'+counter+'][dowcount]"><?php for($n1=1;$n1<=30;$n1++){ ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select  name="cstm[N'+counter+'][dow]"><option value="1">Days</option><option value="2" selected="selected">Weeks</option></select></td></tr><tr><td class="title" valign="middle">Email Template</td><td style="padding-bottom: 4px;"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></td></tr><?php }?><tr><td></td><td><?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?><div class="filldiv"><div class="box1"><b>(Optional) Fill with SalesScripter generated content</b><br/><b>* Warning: this will replace any text that you have entered</b></div><div class="box2"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></div></div><?php }?></td><tr><tr><td class="title" valign="middle">Content</td><td><div class="container" style="margin-bottom:10px;"><div class="interior"><a id="myBtn" href="#open-modal" class="buttonM bGreen" onclick="getpopUp('+counter+');">Link Email to CRM Fields</a></div></div><textarea id="contentdb'+counter+'" class="tinyMCE" name="cstm[N'+counter+'][value]"></textarea></td></tr><tr class="emailnode"><td></td><td class="buttons"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onClick="DynamicAddRowStage(this)" /> <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" data-colp="0" /></td></tr></table></div></div></div><div class="clear"></div></div>';
		//$('#tabs_123').append(data);
        sftb.after(data);
		initTinyMCECUST(counter);
		<?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
		$(".sd"+counter+" select").uniform();
		<?php }?>
        setSortOrder();
	}
    //Set Sort Order
    function setSortOrder() {
        var storder=1;
        $("input.sortorder").each(function(){
            storder++;
            $(this).val(storder);
        });
    }

    //Add Task
    function addtask(dis) {
        var sftb = $(dis).parents(".custompro");
        counter++;

        var fehtml = '<div class="widget custompro tableTabsdb'+counter+'">'+
                    '<div class="tab_container">'+
                        '<div id="ttab1" class="tab_content">'+
                            '<div class="custom_content_table_data scftask">'+
                                '<table cellpadding="0" cellspacing="0" border="0" width="100%">'+
                                    '<tr>'+
                                        '<th class="Title one" width="225px">Follow-Up Task</th>'+
                                        '<td colspan="2" align="right"><a href="javascript:void(0);" class="deletechild close" onClick="deleteSection('+counter+')">X</a></td>'+
                                    '</tr>'+
                                    '<tr class="schrowTimes">'+
                                        '<th class="one">Schedule Timing</th>'+
                                        '<td colspan="2" class="two">'+
                                            '<input type="hidden" name="record[schindx][]" value="'+counter+'" />'+
                                            '<input type="hidden" name="record[blocktype][]" class="blocktype" value="task" />'+
                                            '<input type="hidden" name="record[slno][]" class="slno" value="'+counter+'" />'+
                                            '<input type="hidden" name="record[schids][]" value="0" />'+
                                            '<div>'+
                                                '<select name="record[tsk_schcounts][]" id="tsk_schcount'+counter+'"><option value="">Select number</option><?php for($tn=1;$tn<=30;$tn++){ ?><option value="<?php echo $tn;?>"><?php echo $tn; ?></option><?php } ?></select>'+ 
                                                '<select  name="record[tsk_schtypes][]" id="tsk_schtype'+counter+'"><option value="">Select Day/Week</option><option value="1">Days</option><option value="2">Weeks</option></select>'+                                
                                            '</div>'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<th class="one"></th>'+
                                        '<td class="two" width="400px">';
                                            <?php foreach($Schedules as $ci=>$option) {?>
                                    fehtml +='<div><input type="radio" class="optval" name="record[schs]['+counter+']" value="<?php echo $option;?>" onChange="inter_change(this)" /> <?php echo $option;?></div>';
                                            <?php }?>
                                    fehtml +='<div>'+
                                                '<input type="radio" name="record[schs]['+counter+']" class="optval schother" value="O" onChange="inter_change(this)" /> Other'+ 
                                                '<span class="span_schother">'+
                                                    '<input name="record[sch_txts][]" type="text" value="" class="scho_txt" />'+
                                                '</span>'+
                                            '</div>'+                                
                                        '</td>'+
                                        '<td class="two" ali><b>Notes:</b><br />'+
                                            '<textarea class="txtnotes" id="schinotes" name="record[schnotess][]"></textarea>'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr class="emailnode">'+
                                        '<td></td>'+
                                        '<td class="buttons"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onClick="DynamicAddRowStage(this)" /> '+
                                        '<input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" data-colp="0" />'+
                                        '</td><td></td>'+              
                                    '</tr>'+
                                '</table>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';

        sftb.after(fehtml);
        $(".tableTabsdb"+counter+" select").uniform();
        $(".tableTabsdb"+counter+" .optval").uniform();
    }

    //schedule task other
    function inter_change(dis) {
        var sftb = $(dis).parents(".scftask");
        sftb.find(".scho_txt").val('');
        if($(dis).val()=="O" && $(dis).prop("checked")==true) sftb.find(".span_schother").show();
        else sftb.find(".span_schother").hide();            
    }

    //Delete email task
    function delete_sch(schno,saved) {            
        if(saved!=0) {
            var etmids = $("#remschids").val();
            if(etmids) etmids += ",";
            etmids += saved;
            $("#remschids").val(etmids);
        }
        $('.widget.tableTabsdb'+schno).remove();
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
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/u3oBKNyMlcM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
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
<div id="open-modal" class="modal-window">
  <input type="hidden" id="textareaid" value="" />
  <div style="border:1px solid #666666;">
        <a href="#modal-close" title="Close" class="modal-close">Close</a>
        <h1>Link Email to CRM Fields</h1>
        <div class="shortcode_buttons"> 
            <button onClick="shortcodePoptext('{contact first name}');">First Name - {contact first name}</button><br />
            <button onClick="shortcodePoptext('{contact last name}');">Last Name - {contact last name}</button><br />
            <button onClick="shortcodePoptext('{user first name}');">User First Name - {user first name}</button><br />
            <button onClick="shortcodePoptext('{user last name}');">User Last Name - {user last name}</button><br />
            <button onClick="shortcodePoptext('{account name}');">Account Name - {account name}</button><br />
            <button onClick="shortcodePoptext('{contact title}');">Contact Title  - {contact title}</button><br />
            <button onClick="shortcodePoptext('{contact phone}');">Contact Phone - {contact phone}</button><br />
            <button onClick="shortcodePoptext('{user phone}');">User Phone - {user phone}</button><br />
            <button onClick="shortcodePoptext('{contact website}');">Company Website - {contact website}</button><br />
            <button onClick="shortcodePoptext('{email signature}');">Email Signature - {email signature}</button>  <br />        
            <button onClick="shortcodePoptext('{mailing street}');">Mailing Street - {mailing street}</button>  <br />          
            <button onClick="shortcodePoptext('{mailing city}');">Mailing City - {mailing city}</button>    <br />        
            <button onClick="shortcodePoptext('{mailing state}');">Mailing State/Province - {mailing state}</button>  <br />         
            <button onClick="shortcodePoptext('{mailing zip}');">Mailing Zip/Postal Code - {mailing zip}</button> <br />           
            <button onClick="shortcodePoptext('{mailing country}');">Mailing Country - {mailing country}</button> <br /> 
        </div>
    </div>
</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
		function shortcodePoptext(text)
		{		
			var textareaid = $("#textareaid").val();
			var prev = tinymce.get("contentdb"+textareaid).getContent() + text ;
			prev = prev.replace(/^\<p\>/,"").replace(/\<\/p\>$/,"");
			tinymce.get("contentdb"+textareaid).setContent(prev);
			$('#open-modal').hide();
		}
		function getpopUp(dis)
		{
			//alert(dis);
			$('#open-modal').show();
			$("#textareaid").val(dis);
			
		}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>