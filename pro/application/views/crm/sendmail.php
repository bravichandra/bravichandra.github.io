<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<?php //if($deleted_info!='') echo $deleted_info; else echo 'no';
$Schedules = array(
	'Follow up with a phone call',
	'Follow up with an email',
	'Stop by in person',
	'Follow up on social media',
	'Attend meeting',
	//'Date'
	);
?>
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
.contact-edit .mceLayout{width: 90% !important;}
.addbtn{height: 30px !important;padding: 2px 20px !important;margin-left: 20px;}
</style>
<style type="text/css">

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
    <?php  echo $this->load->view('common/crm_nav');?>
    <!-- Main content -->
    <div class="main-wrapper crmlite composer"> 
    	<div class="formRow crmlite" id="cLookup">
            <div class="qrbox">
                <div class="abox1">Account Lookup</div>
                <div class="abox2"><a href="javascript:void(0)" onClick="$('#cLookup').hide();" style="font-weight:bold;">X</a></div><br clear="all" />
            </div>
            <div class="search-list"></div>
        </div> 
		<?php if ($err): ?><br>
			<h3 style="color:red !important;"><?php echo $err; ?></h3>
		<?php endif; ?>  
        
        <div align="center" class="dropdowns">
            <div style="float: right;"> 
                <a href="#" class="buttonM bRed dialog_help">Help Video</a>
            </div>
            <?php $this->load->view('common/drop_menu');?></div>        
        <b style="color:red !important;"><?php if ($smtp_info==0): ?><br />Please enter the SMTP details for your email account in order to send emails. <a href="<?php echo base_url()."crm/settings";?>">Click here</a> to set up.<?php endif; ?>
        </b>
        <form method="post" id="frmsmtp" onSubmit="return save_record();" action="<?php echo current_url();?>" style="margin-top: -50px;">
        	<input type="hidden" name="etids" id="etids" value="" />
            <input type="hidden" name="remschids" id="remschids" value="" />
            <input type="hidden" name="action" value="save" />
            <input type="hidden" name="record[act]" value="send" id="subaction" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="width:100%" id="frmsemail">             
            <tr>
                <th class="one">Send to a list</th>
                <td class="two">
                <select name="record[listid]" id="listid" onChange="contactChange(this.value);">
                    <option value="">Select Contact List</option>
                    <?php 
                        foreach($catlist as $t):                             
                        ?>
                    <option value="<?php echo $t->id;?>"><?php echo $t->name; ?></option>
                    <?php endforeach; ?>
                </select> 
                </td>
            </tr>
            <tr>
                <th class="one"></th><td class="two"> [ OR ]</td>
            </tr>
            <tr>
            	<th class="one">Search Contact</th><td class="two">
                	<?php /*?><select name="record[record_id]" id="record_id">
                        <option value="">Select</option>
                        <?php $emails = "";foreach($allContacts as $cont): $emails .= '<span id="em_'.$cont->contact_id.'">'.$cont->email.'</span>';?>
                        <option value="<?php echo $cont->contact_id;?>" <?php if($cont->contact_id==$parent_id) echo ' selected="selected"'?>><?php echo ucfirst($cont->user_first.' '.$cont->user_last); ?></option>
                        <?php endforeach; ?>
					</select> <?php */?>
                    <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact])?>" name="record[contact]" id="contact_id" />
                	<input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title])?>" name="record[contact_title]" id="contact_title" /><a href="javascript:void(0);" onClick="Records_getLookup('contact','contact');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                    <div class="displayNone"><?php foreach($allContacts as $cont) echo '<span id="em_'.$cont->contact_id.'">'.$cont->email.'</span>';?></div>
				</td>
            </tr>
            <tr>
            	<th class="one">Contact Name</th><td class="two">
                    <input type="text" value="<?php if(isset($contact_fname)) echo form_prep($contact_fname)?>" name="record[cname]" id="cname" placeholder="First Name" /> 
                    <input type="text" value="<?php if(isset($contact_lname)) echo form_prep($contact_lname)?>" name="record[lname]" id="lname" placeholder="Last Name" /> 
				</td>
            </tr>
            <tr>
                <th class="one">Email Address</th><td class="two"><input type="text" value="<?php if(isset($contact_email)) echo form_prep($contact_email)?>" name="record[cemail]" id="cemail" /></td>
            </tr>
            
            <tr>
            	<th class="one">
                	 Emails Sent this Month<br />
                     Emails Available to Send <br />
                     <div id="emailsmonthTitle" style="font-size:11px;"></div>  
                </th>
                <td class="two" style="padding-top:7px; padding-left:3px; float:left; color:#4a4a56; 
                font-size:11px; font-weight:bold;">
                	<?php echo $this->_data['emails_stmonth']; ?><br />
                    <?php echo $this->_data['emails_atsend']; ?><br />
                     <div id="emailsmonthValue" style="font-size:11px;"></div>                    
                </td>
            </tr>  
            <tr class="schrow1">
                <th class="one">Sales Playbook Email Templates</th>
                <td class="two">
                <input type="hidden" name="record[tname]" class="tname" id="tname1" value="" />
                <?php /*?><select name="record[tid]" id="tid1" onchange="setEditor(this,1,1)">
                    <option value="">Select Email Template</option>
					<?php 
						$tempid=0;
						$etemp_options = '<option value="">Select Email Template</option>';
						foreach($templates as $t): if($tempid==$t->temp_id) continue; 
							$etemp_options .= '<option value="'.$t->temp_id."-".$t->sect_id.'">'.$t->temp_title.'</option>';
						?>
                    <option value="<?php echo $t->temp_id."-".$t->sect_id;?>" <?php if($t->sect_id==$template_content_id) echo ' selected="selected"'?>><?php echo $t->temp_title; ?></option>
                    <?php $tempid=$t->temp_id;endforeach; ?>
				</select> <?php */?>   
                <select name="record[tid]" id="tid1" onChange="setEditor(this,1,1)">
                    <option value="">Select Email Template</option>
					<?php 
						$tempid=0;
						$etemp_options = '<option value="">Select Email Template</option>';
						foreach($templates as $t): if($tempid==$t->temp_id) continue; 
							if(!isset($t->temp_id)) continue;	
							if(isset($temphides[$t->temp_id])) continue;
							$tmptitle = isset($etemplate[$t->temp_id])?$etemplate[$t->temp_id]:$t->temp_title;
                            $section_id = isset($email_sections[$t->temp_id])?'t'.$email_sections[$t->temp_id]:'';							
							$etemp_options .= '<option value="'.$t->temp_id."-".$t->sect_id.'">'.$t->temp_title.'</option>';							
						?>
                    <option value="<?php echo $t->temp_id."-".$t->sect_id;?>" <?php if($t->sect_id==$template_content_id) echo ' selected="selected"'?>><?php echo $t->temp_title; ?></option>
                    <?php $tempid=$t->temp_id;endforeach; ?>
				</select>               
                <span class="loader2"></span>
                <br />
                <b id="ermessage" style="color:red !important;">
                    <?php if(isset($unsubscribed) && $unsubscribed=="1") echo $contact_fname.' '.$contact_lname.' Unsubscribed';?>
                </b>
                </td>
            </tr>
            <tr class="schrow1">
                <th class="one">User Saved Email Templates</th>
                <td class="two">         
                    <?php if(!isset($uemail_templates)){ ?>                          
                    <select name="record[stid]" id="stid1"><option value="">Select Email Template</option></select>
                    <?php } else { ?>
                    <select name="record[stid]" id="stid1" onChange="setEditor(this,2,1)"><?php if(isset($uemail_templates)) echo $uemail_templates?></select>
                    <?php } ?>
                </td>
            </tr>
            <tr class="schrow1 emailnode">
                <th class="one">Subject*</th><td class="two"><input type="text" value="<?php if(isset($record['subject'])) echo form_prep($record['subject'])?>" name="record[subject]" id="subject1" style="width: 400px;" /></td>
            </tr>
            <tr class="schrow1 emailnode">
                <th class="one">Email Content*</th><td class="two"> 
                	 <div class="container" style="margin-bottom:10px;">
                          <div class="interior">
                            <a id="myBtn" href="#open-modal" class="buttonM bGreen" onClick="getpopUp(1);">Link Email to CRM Fields</a>
                          </div>
                    </div>
                    <input type="hidden" name="record[blocktype][]" class="blocktype" value="email" /> 
                    <input type="hidden" name="record[slno][]" class="slno" value="1" />
                	<textarea id="econtent1" class="tinyMCE" name="record[info]"><?php if(isset($record['info']))echo $record['info']; ?></textarea>
                    <?php /*?><br />
                    <b>Note:</b> Use this short code to track your links in the email content when user click on it to gain interaction points. <br />This tag automatically adds hyperlinks instead of that tag.<br />
                    Shortcode: [[SSTAG TITLE="" URL=""]]<br />
                    Place your hyperlink text in between double quotes("") for <b>TITLE</b> option.<br />
                    Place your hyperlink url in between double quotes("") for <b>URL</b> option.<?php */?>
                </td>
            </tr>
            <tr class="schrow1 rowfue emailnode">
                <th class="one"></th>
                <td class="two">
                    <input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onClick="addeditor(this)" /> 
                    <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" />
                </td>              
            </tr>
            <?php 
                $ei=1;
                //Main thread email tasks
                if(isset($thread_id)) {                    
                    if(isset($email_tasks[$thread_id])) {
                        $subemail_tasks = $email_tasks[$thread_id];
                        foreach($subemail_tasks as $etask) {$ei++;
            ?>
            <tr class="schrow<?php echo $ei?> tasknode" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr> 
            <tr class="schrow<?php echo $ei?> tasknode">
                <td class="two" colspan="2">
                    <div class="csect scftask">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <th class="Title one" width="225px">Follow-Up Task</th>
                                <td colspan="2" align="right"><a href="javascript:void(0);" class="deletechild" onClick="delete_sch(<?php echo $ei?>,<?php echo $etask->id;?>)">X</a></td>
                            </tr>
                            <tr class="schrowTimes">
                                <th class="one">Schedule Timing</th>
                                <td colspan="2" class="two">
                                    <input type="hidden" name="record[schindx][]" value="<?php echo $ei;?>" />
                                    <input type="hidden" name="record[blocktype][]" class="blocktype" value="task" />
                                    <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $ei?>" />
                                    <input type="hidden" name="record[schids][]" value="<?php echo $etask->id?>" />
                                    <?php
                                        $task_duedate_parts = array('','');
                                        if($etask->task_duedate) {
                                            $task_duedate_parts = explode("-",$etask->task_duedate);
                                        }
                                        $schOpt=0;
                                    ?>
                                    <div>
                                        <select name="record[tsk_schcounts][]" id="tsk_schcount<?php echo $ei?>"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"<?php if($task_duedate_parts[0]==$n) echo ' selected="selected"'?>><?php echo $n; ?></option><?php } ?></select> 
                                        <select  name="record[tsk_schtypes][]" id="tsk_schtype<?php echo $ei?>"><option value="">Select Day/Week</option><option value="1"<?php if($task_duedate_parts[1]=="1") echo ' selected="selected"'?>>Days</option><option value="2"<?php if($task_duedate_parts[1]=="2") echo ' selected="selected"'?>>Weeks</option></select>
                        
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="one"></th>
                                <td class="two">
                                    <?php foreach($Schedules as $ci=>$option) {
                                        if($etask->task_subject==$option) {$sel=' checked="checked"';$schOpt=1;} else $sel='';
                                        ?>
                                    <div><input type="radio" class="optval" <?php echo $sel?> name="record[schs][<?php echo $ei;?>]" value="<?php echo $option;?>" onChange="inter_change(this)" /> <?php echo $option;?></div>
                                    <?php }
                                        if($etask->task_subject && !$schOpt) $sel=' checked="checked"'; else $sel='';
                                    ?>
                                    <div>
                                        <input type="radio" name="record[schs][<?php echo $ei;?>]" class="optval schother" <?php echo $sel?> value="O" onChange="inter_change(this)" /> Other 
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
                </td>              
            </tr>
            <?php                
                        }
                    }
                }
            ?>
            <?php 
                //Thread Emails
				if(isset($thread_sub)){				
				foreach($thread_sub as $et){$ei++;
			?>
            <tr class="schrow<?php echo $ei?>" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr>
			<tr class="schrowTimes schrow<?php echo $ei?>">
            	<th class="one">Schedule Delivery Timing*</th>
                <td class="two">                	
                	<input type="hidden" name="record[tid][]" class="edsno" value="<?php echo $et->tid?>" />
                	<select name="record[schcount][]" id="schcount<?php echo $ei?>" class="required"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"<?php if($et->schcount==$n) echo ' selected="selected"'?>><?php echo $n; ?></option><?php } ?></select> 
                    <select  name="record[schtype][]" id="schtype<?php echo $ei?>" class="required"><option value="">Select Day/Week</option><option value="1"<?php if($et->schtype=="1") echo ' selected="selected"'?>>Days</option><option value="2"<?php if($et->schtype=="2") echo ' selected="selected"'?>>Weeks</option></select>
                    <span class="schtimes">
                    <select name="record[schtime][]" class="required"><option value="">HH</option><?php for($n=1;$n<=12;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"<?php if($et->schtime==$n1) echo ' selected="selected"'?>><?php echo $n1; ?></option><?php } ?></select>
                    <select name="record[schmin][]" class="required"><option value="">MM</option><?php for($n=0;$n<60;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"<?php if($et->schmin==$n1) echo ' selected="selected"'?>><?php echo $n1; ?></option><?php } ?></select>
                    <select name="record[scham][]"><option value="0">AM</option><option value="1"<?php if($et->scham=="1") echo ' selected="selected"'?>>PM</option></select>
                    </span>  <span id="sametimeBox" style="display:none"><input type="checkbox" checked="checked" id="sametime" name="record[sametime][<?php echo $ei?>]" value="1" onChange="same_time()" /> Send at same time of day as first email.</span>
                </td>    
            </tr>
			<tr class="schrow<?php echo $ei?> schrow">
            	<th class="one">Email Template</th>
                <td class="two">           
                    <input type="hidden" name="record[emlindx][]" value="<?php echo $ei?>" />         
                    <input type="hidden" name="record[blocktype][]" class="blocktype" value="email" />
                    <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $ei?>" />
                	<input type="hidden" name="record[tnames][]" class="tname" value="" />
                	<select id="tid<?php echo $ei?>" onChange="setEditor(this,1,<?php echo $ei?>)"><?php echo $etemp_options?></select> 
                    <span <?php if(!isset($uemail_templates)) echo 'style="display:none;"';?>>[ Or ] <select id="stid<?php echo $ei?>" onChange="setEditor(this,2,<?php echo $ei?>)"><?php if(isset($uemail_templates)) echo $uemail_templates?></select></span>
                    <span class="loader2"></span>
                    <span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onClick="deletesch(<?php echo $ei?>)">X</span></td></tr>
            <tr class="schrow<?php echo $ei?> emailnode">
            	<th class="one">Subject*</th><td class="two"><input type="text" name="record[subjects][]" id="subject<?php echo $ei?>" class="required" value="<?php echo form_prep($et->subject)?>" style="width: 400px;" /></td></tr>
            <tr class="schrow<?php echo $ei?> emailnode" style="display:none;">
                <th class="one">Sort Order</th><td class="two"><input type="text" name="record[sorder][]" id="sorder<?php echo $ei?>" class="required sortorder" value="<?php echo ($et->sorder?$et->sorder:$ei)?>" style="width: 50px;" /></td></tr>
            <tr class="schrow<?php echo $ei?> emailnode"><th class="one">Email Content*</th><td class="two"><textarea id="econtent<?php echo $ei?>" class="tinyMCE erequired" name="record[infos][]"><?php echo $et->content;?></textarea></td></tr>
            <tr class="schrow<?php echo $ei?> rowfue emailnode">
                <th class="one"></th>
                <td class="two"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onClick="addeditor(this)" /> 
                <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" data-colp="0" />
                </td>              
            </tr> 
            <?php 
                //Sub email tasks
                if(isset($email_tasks[$et->tid])) {
                    $subemail_tasks = $email_tasks[$et->tid];
                    foreach($subemail_tasks as $etask) {$ei++;
            ?>  
            <tr class="schrow<?php echo $ei?> tasknode" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr>
            <tr class="schrow<?php echo $ei?> tasknode">
                <td class="two" colspan="2">
                    <div class="csect scftask">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <tr>
                                <th class="Title one" width="225px">Follow-Up Task</th>
                                <td colspan="2" align="right"><a href="javascript:void(0);" class="deletechild" onClick="delete_sch(<?php echo $ei?>,<?php echo $etask->id;?>)">X</a></td>
                            </tr>
                            <tr class="schrowTimes">
                                <th class="one">Schedule Timing</th>
                                <td colspan="2" class="two">
                                    <input type="hidden" name="record[schindx][]" value="<?php echo $ei;?>" />
                                    <input type="hidden" name="record[blocktype][]" class="blocktype" value="task" />
                                    <input type="hidden" name="record[slno][]" class="slno" value="<?php echo $ei?>" />
                                    <input type="hidden" name="record[schids][]" value="<?php echo $etask->id?>" />
                                    <?php
                                        $task_duedate_parts = array('','');
                                        if($etask->task_duedate) {
                                            $task_duedate_parts = explode("-",$etask->task_duedate);
                                        }
                                        $schOpt=0;
                                    ?>
                                    <div>
                                        <select name="record[tsk_schcounts][]" id="tsk_schcount<?php echo $ei?>"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"<?php if($task_duedate_parts[0]==$n) echo ' selected="selected"'?>><?php echo $n; ?></option><?php } ?></select> 
                                        <select  name="record[tsk_schtypes][]" id="tsk_schtype<?php echo $ei?>"><option value="">Select Day/Week</option><option value="1"<?php if($task_duedate_parts[1]=="1") echo ' selected="selected"'?>>Days</option><option value="2"<?php if($task_duedate_parts[1]=="2") echo ' selected="selected"'?>>Weeks</option></select>
                        
                                    </div>
                                    <span id="sametimeBox" style="display:none"><input type="checkbox" checked="checked" id="sametime" name="record[sametime][<?php echo $ei?>]" value="1" onChange="same_time()" /> Send at same time of day as first email.</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="one"></th>
                                <td class="two">
                                    <?php foreach($Schedules as $ci=>$option) {
                                        if($etask->task_subject==$option) {$sel=' checked="checked"';$schOpt=1;} else $sel='';
                                        ?>
                                    <div><input type="radio" class="optval" <?php echo $sel?> name="record[schs][<?php echo $ei;?>]" value="<?php echo $option;?>" onChange="inter_change(this)" /> <?php echo $option;?></div>
                                    <?php }
                                        if($etask->task_subject && !$schOpt) $sel=' checked="checked"'; else $sel='';
                                    ?>
                                    <div>
                                        <input type="radio" name="record[schs][<?php echo $ei;?>]" class="optval schother" <?php echo $sel?> value="O" onChange="inter_change(this)" /> Other 
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
                </td>              
            </tr>
            <?php }}?>

            <?php }}?>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="width:100%;margin-top: -50px;">            
            <!--<tr><td></td>
                <td><span id="sametimeBox" style="display:none"><input type="checkbox" checked="checked" id="sametime" name="record[sametime]" onChange="same_time()" /> Send at same time of day as first email.</span></td></tr>-->
            <tr class="setemprow">
                <th class="one" width="280px"><input type="checkbox" id="esave" name="record[esave]" /> Save Email Template</th>
                <td class="two">                    
                    <input type="hidden" value="<?php echo (isset($thread_id)?$thread_id:0);?>" name="record[eoid]" id="eoid" />
                    <input type="hidden" value="<?php if(isset($record['tempname'])) echo form_prep($record['tempname'])?>" name="record[eotitle]" id="eotitle" />
                    <input type="text" value="<?php if(isset($record['tempname'])) echo form_prep($record['tempname'])?>" name="record[etitle]" id="etitle" placeholder="Email Title" />
                    <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" onClick="$('#subaction').val('save');$('#esave').prop('checked',true)" />
                    <span class="edelete_box" <?php echo (isset($thread_id)?"":'style="display:none"')?>;><input type="button" onClick="remove_saved_template()" id="edelete" class="buttonM bRed" value="Delete Email Template" /></span></td>
            </tr> 

        </table>
            
        
        <div align="center">
            <span class="loader"></span>
            <input type="submit" class="buttonM bBlue" name="btnsave" id="btnsave" onClick="$('#subaction').val('send');" value="Send Mail" <?php if(isset($unsubscribed) && $unsubscribed=="1") echo ' style="display:none;"';?> />
        </div>
        </form>  
       

        	
        </div>
        </div>
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
	<script type="text/javascript">
        JSActionPage="CRM-COMPOSE";
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/OKXqTF7pi14" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
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
		var cfname = '<?php echo $contact_fname;?>';
		var emailContent=new Array();
		var etextcount = <?php echo $ei?>;
		//Load after tinymce
		function afterTinymce() {
			<?php if(isset($template_content_id) && $template_content_id<>161) {?>
			$( "#tid1" ).trigger( "change" );
			<?php } else if(isset($template_content_id) && $template_content_id==161) {?>
			//setEditor($( "#tid1" ),1,1);
			$( "#tid1" ).trigger( "change" );
			<?php }?>
		}
		function shortcodePoptext(text)
		{		
			var textareaid = $("#textareaid").val();
			var prev = tinymce.get("econtent"+textareaid).getContent() + text ;
			prev = prev.replace(/^\<p\>/,"").replace(/\<\/p\>$/,"");
			tinymce.get("econtent"+textareaid).setContent(prev);
			$('#open-modal').hide();
		}
		function getpopUp(dis)
		{
			//alert(dis);
			$('#open-modal').show();
			$("#textareaid").val(dis);
			
		}
		$(document).ready(function(){
			//Schedule Follow up Task
			$('.idate').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
				$(this).datepicker('hide');
			});			
			
			tinyMCE.init({
				selector: "textarea.tinyMCE",
				content_style: ".mceContentBody {font-size:12px;font-family:Arial,sans-serif;}",
				theme : "advanced",
				height : "350",
				convert_urls: false,
				
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,jbimages",
		
				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor,jbimages",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				oninit : afterTinymce
			});
			
			//Email template changed
			<?php /*?>$("#tid").change(function(){
				//hide delete section
				$(".edelete_box").hide();
				//$("#edelete").prop("checked",false);
				$(".loader2").html('');
				if($(this).val()=="") {
					tinyMCE.get('econtent').setContent("");
					return;
				}
				//$("#subject").val($(this).find(":selected").text());
				$(".loader2").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
				$.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>home/get_emailTemplate/"+$(this).val()
					}).done(function( data ) {
						$(".loader2").html('');
						var x1=data.split("</p>");
						var x2=x1[0]+'</p>';
						x2 = $(x2).text();
						x2 = x2.replace("Subject line:","");
						x2 = x2.replace(/\s{2,}/g, ' ');
						x2 = x2.replace("\n","");
						x2 = x2.replace("\r","");
						$("#subject").val(x2);
						x2 = x1[0]+'</p>';
						data = data.replace(x2,"");
						data = data.replace("<p><strong>Email body:</strong></p>","");
						data = data.replace(" edit_area","");
						emailContent=data;
						if(cfname) {
							x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
							data = data.replace(x2,cfname);
							x2 = '[Prospect First Name]';
							data = data.replace(x2,cfname);
						}
						tinyMCE.get('econtent').setContent(data);						
				  })
				  .fail(function() {
					alert( "Unable to load template, please try again" );
				  });
			});<?php */?>
			//Saved Email template changed
			<?php /*?>$("#stid").change(function(){
				//hide delete section
				$(".edelete_box").hide();
				//$("#edelete").prop("checked",false);
				$(".loader2").html('');
				if($(this).val()=="") {
					tinyMCE.get('econtent').setContent("");
					return;
				}
				$("#subject").val($(this).find(":selected").text());
				$("#etitle").val($(this).find(":selected").text());
				$("#eotitle").val($(this).find(":selected").text());
				$(".loader2").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
				$.ajax({
				  type: "POST",
				  url: "<?php echo base_url();?>crm/get_saved_emailTemplate/"+$(this).val()
					}).done(function( data ) {
						$(".loader2").html('');
						data = data.replace("<p><strong>Email body:</strong></p>","");
						data = data.replace(" edit_area","");
						emailContent=data;
						if(cfname) {
							x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
							data = data.replace(x2,cfname);
							x2 = '[Prospect First Name]';
							data = data.replace(x2,cfname);
						}
						tinyMCE.get('econtent').setContent(data);
						//show delete section
						$(".edelete_box").show();
						//$("#edelete").prop("checked",false);
				  })
				  .fail(function() {
					alert( "Unable to load template, please try again" );
				  });
			});<?php */?>
			//Existing Contact changed
			<?php /*?>$("#record_id").change(function(){
				if($(this).val()=="") return;
				cfname=$(this).find(":selected").text();
				$("#cname").val(cfname);
				$("#cemail").val($("#em_"+$(this).val()).text());
			});<?php */?>
			
			
			
			//Contact name changed
			$("#cname").change(function(){
				
				cfname = $(this).val();
				if(cfname) {
					var evar = '';console.log(emailContent);console.log(emailContent.length);
					for(var n1=0;n1<emailContent.length;n1++) {console.log(n1);
						evar = emailContent[n1];console.log(evar);
						if(evar==undefined) continue;
						if(evar.length==0) continue;
						while(evar.indexOf("[Prospect First Name]")!=-1) {
							x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
							evar = evar.replace(x2,cfname);
							x2 = '[Prospect First Name]';
							evar = evar.replace(x2,cfname);
							tinyMCE.get('econtent'+(n1+1)).setContent(evar);
							tinyMCE.triggerSave();
						}
					}
				}
			});
			//Contact email changed
			$("#cemail").change(function(){
				$("#ermessage").html("");
				$("#btnsave").show();
			});
			
			//Load email thread
			<?php if(isset($record)) {?>
			//Set contact data from browser storage				
			if(localStorage.getItem("cm_contact_lname")!=null) $("#lname").val(localStorage.getItem("cm_contact_lname"));
			if(localStorage.getItem("cm_contact_email")!=null) $("#cemail").val(localStorage.getItem("cm_contact_email"));
			var ecname='';
			if(localStorage.getItem("cm_contact_fname")!=null) {
				ecname=localStorage.getItem("cm_contact_fname");
				$("#cname").val(ecname);
			}
			$("textarea").each(function(){
				var evar = $(this).val();
				var x2;
				if(ecname && evar!=undefined && evar.length!=0) {
					while(evar.indexOf("[Prospect First Name]")!=-1) {
						x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
						evar = evar.replace(x2,ecname);
						x2 = '[Prospect First Name]';
						evar = evar.replace(x2,ecname);
						$(this).val(evar);
					}
				}
				emailContent.push($(this).val());
			});
			tinyMCE.triggerSave();
			<?php }else{?>
			//UnSet contact data from browser storage				
			if(localStorage.getItem("cm_contact_lname")!=null) localStorage.removeItem("cm_contact_lname");
			if(localStorage.getItem("cm_contact_email")!=null) localStorage.removeItem("cm_contact_email");
			if(localStorage.getItem("cm_contact_fname")!=null) localStorage.removeItem("cm_contact_fname");
			<?php }?>
			<?php 
				//set default thread email
				if(isset($thread_id)) {?>
			$("#stid1").val("T<?php echo $thread_id?>");
			$(".tname").val($("#stid1 option:selected").text());
			<?php }?>			
			if($(".schrow").length>0) $("#sametimeBox").show(); else $("#sametimeBox").hide();
			$(".schtimes").hide();
		});
		//Send Email
		function save_record(){
			//Same time schedules
			$(".schtimes select").removeClass('required');
			if($("#sametime").prop('checked')==false) {
				$(".schtimes select").addClass('required');
			}
			var sbaction = $("#subaction").val();
			$(".erborder").removeClass("erborder");
			if($(".loader").html().length>0) {
				alert("Sending mail inprocess....");
				return;
			}
			$(".loader").html('');
			if(sbaction=="send") {
                if($("#listid").val().length==0 && ($("#cname").val().length==0 || $("#lname").val().length==0) && $("#cemail").val().length==0) {
                    alert("Select contact list or enter contact name and email address");
                    return false;
                }
                if($("#listid").val().length==0) {
                    if($("#cname").val().length==0 || $("#lname").val().length==0 || $("#cemail").val().length==0) {
                        if($("#cname").val().length==0) {
                            alert("Contact first name required");
                            $("#cname").focus();
                            return false;
                        }
                        if($("#lname").val().length==0) {
                            alert("Contact last name required");
                            $("#lname").focus();
                            return false;
                        }
                        if($("#cemail").val().length==0) {
                            alert("Contact email required");
                            $("#cemail").focus();
                            return false;
                        }        
                    }
                }
				
			}
			if($("#subject1").val().length==0) {
				alert("Subject required");
				$("#subject1").focus();
				return false;
			}
			tinyMCE.triggerSave();
			if(tinyMCE.get('econtent1').getContent().length==0) {
				alert("Email content required");
				return false;
			}
			var er=0;
			//check required fields			
			$(".required").each(function(){
				if($(this).val()=="") {
					er=1;
					if($(this).attr("type")=="text") $(this).addClass("erborder");
					else $(this).parent().addClass("erborder");					
				}
			});
			//check required fields	for editors
			$(".erequired").each(function(){
				if(tinyMCE.get($(this).attr('id')).getContent().length==0) {
					er=1;
					$(this).parent().addClass("erborder");
				}
			});
			if(er) {
				alert("there are incompleted data on the form");
				return false;
			}
			if($("#esave").prop("checked")==true) {
				if($("#etitle").val().length==0) {
					alert("Save email template title required");
					$("#etitle").focus();
					return false;
				}
			}	
			//Schedule Follow up Task
			if($(".optval:checked").length>0) {
				if($(".schother").prop("checked")==true) {
					if($(".scho_txt").val()=="") {
						alert("Schedule Follow-Up Task other value required");
						return false;
					}
				}
				<?php /*?>if($("#schinotes").val().length==0) {
					alert("Schedule Follow-Up Task notes required");
					$("#schinotes").focus();
					return false;
				}<?php */?>
			}
			
			$("#btnsave").hide();			
			$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$.ajax({
			  type: "POST",
			  url: "<?php echo current_url();?>",
			  data: $('#frmsmtp').serialize()
				}).done(function( data ) {
					$("#btnsave").show();				
					$(".loader").html('');
					// n = data.search("SUCCESS");
					data = data.replace(/^\s*\n/gm, "");
					if(data.substring(0,7)=="SUCCESS") {
						alert("Email sent and interaction has been logged.");
						<?php /*?>location.replace("<?php echo current_url();?>");<?php */?>
						if($("#listid").val().length>0)
						{
							location.replace("<?php echo base_url();?>crm/contacts/all");
						}
						else
						{
							location.replace("<?php echo base_url();?>crm/contacts/view/"+data.substring(8));
						}
						return;
					} else if(data=="SAVEDTEMPLATEIDS") {	
						alert("Email template saved.");
						location.replace("<?php echo base_url();?>crm/compose");
						return;
					} else if(data.indexOf("SAVEDTEMPLATEIDS")!=-1) {	
						var tmp1 = data.split("SAVEDTEMPLATEIDS");
						var tmp2 = tmp1[1].split("-");
						$("#eoid").val(tmp2[0]);
						if($(".edsno").length>0) {
							var eidno=0;
							$(".edsno").each(function(){
								eidno++;
								$(this).val(tmp2[eidno]);
							});
						}
						data = tmp1[0];
						alert(data);
					} else {
						alert(data);
					}
			  });
			return false;
		}
		//Lookup
		var objname='';
		//Get Lookup
		function getLookup(rcname,obname) {
			objname = obname;
			var popboxhead = '';
			var ajxmethod='';
			if(rcname=="contact") {
				popboxhead = 'Contact Lookup';
				ajxmethod='contacts_lookup';
			}
			$("#cLookup .abox1").html(popboxhead);
			$("#cLookup").show();
			$("#cLookup .search-list").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$( "#cLookup .search-list" ).load( "<?php echo base_url()."crm/"?>"+ajxmethod, function() {
			  $('.dsTable').dataTable({
					"bJQueryUI": false,
					"bAutoWidth": false,
					"sPaginationType": "full_numbers",
					"sDom": '<"H"fl>t<"F"ip>'
				});
			});
		}
		//Set lookup
		function setLookup(dis) {
			var scname = $(dis).html();
			var scid = $(dis).attr("data_id");
			//Unsubscribe message
			$("#ermessage").html("");
			if($(dis).attr("data_uns")=="1") {$("#ermessage").html($(dis).text()+" Unsubscribed");$("#btnsave").hide();} else $("#btnsave").show();
			$("#"+objname+"_title").val(scname);
			$("#"+objname).val(scid);
			$("#cLookup").hide();
			var name_arr = scname.split(" ");
			$("#cname").val(name_arr[0]);
			cfname=name_arr[0];
			if(cfname) {
				var evar = '';
				for(var n1=0;n1<emailContent.length;n1++) {
					evar = emailContent[n1];
					if(evar==undefined) continue;
					if(evar.length==0) continue;
					while(evar.indexOf("[Prospect First Name]")!=-1) {
						x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
						evar = evar.replace(x2,cfname);
						x2 = '[Prospect First Name]';
						evar = evar.replace(x2,cfname);
						tinyMCE.get('econtent'+(n1+1)).setContent(evar);
						tinyMCE.triggerSave();
					}
				}
			}
			if(name_arr.length>1) $("#lname").val(scname.replace(name_arr[0],""));
			else $("#lname").val("");
			$("#cemail").val($("#em_"+scid).text());
		}
		//Apply tinymce editor
		function initTinyMCECUST(stageid) {
			tinyMCE.init({
				selector: "#econtent"+stageid,
				content_style: ".mceContentBody {font-size:12px;font-family:Arial,sans-serif;}",
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
		}
		//Add a Follow-Up Email
		function addeditor(dis){
			etextcount++;
            sortorder++;
			var ce="'ce'";
			//var saveTemp='<tr class="setemprow">'+$(".setemprow").html()+'</tr>';
            var saveTemp='';            
		<?php /*?>	var fehtml = '<tr class="schrow'+etextcount+'" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr>';
			fehtml += '<tr class="schrowTimes schrow'+etextcount+'"><th class="one">Schedule Delivery Timing*</th><td class="two"><input type="hidden" class="edsno" name="record[tid][]" value="0" /><select name="record[schcount][]" id="schcount'+etextcount+'" class="required"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"><?php echo $n; ?></option><?php } ?></select> <select  name="record[schtype][]" id="schtype'+etextcount+'" class="required"><option value="">Select Day/Week</option><option value="1">Days</option><option value="2">Weeks</option></select><span class="schtimes"><select name="record[schtime][]" class="required"><option value="">HH</option><?php for($n=1;$n<=12;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select name="record[schmin][]" class="required"><option value="">MM</option><?php for($n=0;$n<60;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select name="record[scham][]"><option value="0">AM</option><option value="1">PM</option></select></span>           <span id="sametimeBox"><input type="checkbox" checked="checked" id="sametime" name="record[sametime]['+etextcount+']" value="1" onChange="same_time_single(this)" /> Send at same time of day as first email.</span></td></tr>';
			fehtml += '<tr class="schrow'+etextcount+' schrow"><th class="one">Email Template</th><td class="two"><input type="hidden" name="record[tnames][]" class="tname" value="" /><select id="tid'+etextcount+'" onchange="setEditor(this,1,'+etextcount+')"><?php echo $etemp_options?></select> <span <?php if(!isset($uemail_templates)) echo 'style="display:none;"';?>>[ Or ] <select id="stid'+etextcount+'" onchange="setEditor(this,2,'+etextcount+')"><?php if(isset($uemail_templates)) echo str_replace("'","\'",$uemail_templates)?></select></span><span class="loader2"></span><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+etextcount+')">X</span></td></tr><tr class="schrow'+etextcount+' emailnode"><th class="one">Subject*</th><td class="two"><input type="text" value="" name="record[subjects][]" id="subject'+etextcount+'" class="required" style="width: 400px;" /></td></tr><tr class="schrow'+etextcount+' emailnode" style="display:none;"><th class="one">Sort Order</th><td class="two"><input type="text" value="'+sortorder+'" name="record[sorder][]" id="sorder'+etextcount+'" class="required sortorder" style="width: 50px;" /></td></tr><tr class="schrow'+etextcount+' emailnode"><th class="one">Email Content*</th><td class="two"><textarea id="econtent'+etextcount+'" class="tinyMCE erequired" name="record[infos][]"></textarea></td></tr><tr class="schrow'+etextcount+' rowfue emailnode"><th class="one"></th><td class="two"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onclick="addeditor(this)" /> <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" /><input type="hidden" name="record[emlindx][]" value="'+etextcount+'" /><input type="hidden" name="record[blocktype][]" class="blocktype" value="email" /><input type="hidden" name="record[slno][]" class="slno" value="'+etextcount+'" /></td></tr>'+saveTemp;<?php */?>
			
			
			var fehtml = '<tr class="schrowTimes schrow'+etextcount+'"><th class="one">Schedule Delivery Timing*</th><td class="two"><input type="hidden" class="edsno" name="record[tid][]" value="0" /><select name="record[schcount][]" id="schcount'+etextcount+'" class="required"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"><?php echo $n; ?></option><?php } ?></select> <select  name="record[schtype][]" id="schtype'+etextcount+'" class="required"><option value="">Select Day/Week</option><option value="1">Days</option><option value="2">Weeks</option></select><span class="schtimes"><select name="record[schtime][]" class="required"><option value="">HH</option><?php for($n=1;$n<=12;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select name="record[schmin][]" class="required"><option value="">MM</option><?php for($n=0;$n<60;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select name="record[scham][]"><option value="0">AM</option><option value="1">PM</option></select></span><span id="sametimeBox"><input type="checkbox" checked="checked" id="sametime" name="record[sametime]['+etextcount+']" value="1" onChange="same_time_single(this)" /> Send at same time of day as first email.</span></td></tr>';
				
			fehtml += '<tr class="schrow'+etextcount+' schrow"><th class="one">Email Template</th><td class="two"><input type="hidden" name="record[tnames][]" class="tname" value="" /><select id="tid'+etextcount+'" onchange="setEditor(this,1,'+etextcount+')"><?php echo $etemp_options; ?></select> <span <?php if(!isset($uemail_templates)) echo 'style="display:none;"';?>>[ Or ] <select id="stid'+etextcount+'" onchange="setEditor(this,2,'+etextcount+')"><?php if(isset($uemail_templates)) echo str_replace("'","\'",$uemail_templates)?></select></span><span class="loader2"></span><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+etextcount+')">X</span></td></tr><tr class="schrow'+etextcount+' emailnode"><th class="one">Subject*</th><td class="two"><input type="text" value="" name="record[subjects][]" id="subject'+etextcount+'" class="required" style="width: 400px;" /></td></tr><tr class="schrow'+etextcount+' emailnode" style="display:none;"><th class="one">Sort Order</th><td class="two"><input type="text" value="'+sortorder+'" name="record[sorder][]" id="sorder'+etextcount+'" class="required sortorder" style="width: 50px;" /></td></tr>';
			
			fehtml += '<tr class="schrow'+etextcount+' emailnode"><th class="one">Email Content*</th><td class="two"><div class="container" style="margin:5px 0px;"><div class="interior"><a id="myBtn" href="#open-modal" class="buttonM bGreen" onclick="getpopUp('+etextcount+');">Link Email to CRM Fields</a></div></div><textarea id="econtent'+etextcount+'" class="tinyMCE erequired" name="record[infos][]"></textarea></td></tr><tr class="schrow'+etextcount+' rowfue emailnode"><th class="one"></th><td class="two"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onclick="addeditor(this)" /> <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" /><input type="hidden" name="record[emlindx][]" value="'+etextcount+'" /><input type="hidden" name="record[blocktype][]" class="blocktype" value="email" /><input type="hidden" name="record[slno][]" class="slno" value="'+etextcount+'" /></td></tr>'+saveTemp;
            
			//$(".setemprow").remove();
			//$(".rowfue").remove();
			//$("#frmsemail").append(fehtml);
		   if(dis==null || dis==undefined || dis=="undefined") var tasknode = $(".emailnode:last");
		   else  var tasknode = $(dis).parents(".rowfue");
            while(tasknode.next().hasClass("emailnode")==true) tasknode = tasknode.next();
            tasknode.after(fehtml);
            //$(dis).parents(".rowfue").after(fehtml);
			initTinyMCECUST(etextcount);
			emailContent[etextcount]="";
			$(".schrow"+etextcount+" select").uniform();
			if($("#sametime").prop('checked')==false) {
				$(".schtimes select").addClass('required');
				$(".schtimes").show();
			} else {
				$(".schtimes select").removeClass('required');
				$(".schtimes").hide();
			}
			if($(".schrow").length>0) $("#sametimeBox").show(); else $("#sametimeBox").hide();
            setSortOrder();
		}
		//Delete editor
		function deletesch(schno) {
            var etid = $(".schrow"+schno+" .edsno").val();
            if(isNaN(etid)==false && parseInt(etid)>0) {
                var etmids = $("#etids").val();
                if(etmids) etmids += ",";
                etmids += parseInt(etid);
                $("#etids").val(etmids);
            }
			$(".schrow"+schno).remove();
			emailContent[schno-1]="";
			if($(".schrow").length>0) $("#sametimeBox").show(); else $("#sametimeBox").hide();
		}
		//Set email template
		function setEditor(tid,stype,rowno) {
			if($("#sametime").prop('checked')==false) {
				$(".schtimes select").addClass('required');
				$(".schtimes").show();
			} else {
				$(".schtimes select").removeClass('required');
				$(".schtimes").hide();
			}
			if($(".schrow").length>0) $("#sametimeBox").show(); else $("#sametimeBox").hide();
			//switch other template selectbox empty			
			if(stype==1) {
				$("#stid"+rowno).val('');
				$("#stid"+rowno).parent().find("span").html('Select Saved Email Template');
			} else {
				$("#tid"+rowno).val('');
				$("#tid"+rowno).parent().find("span").html('Select Email Template');
			}
			//hide delete section
			if(rowno==1) $(".edelete_box").hide();			
			//$("#edelete").prop("checked",false);
			$(".schrow"+rowno+" .loader2").html('');
			if(tid.value=="") {
				tinyMCE.get('econtent'+rowno).setContent("");
				tinyMCE.triggerSave();
				return;
			}
			//Set template name
			//var tempselbox = $(tid).parents("tr.two");
			//tempselbox.find(".tname").val($(tid).find(":selected").text());
            $("tr.schrow"+rowno).find(".tname").val($(tid).find(":selected").text());
			if(stype==2) {
				if(tid.value.substr(0,1)=="T") {
					//Store contact data
					localStorage.setItem("cm_contact_fname", $("#cname").val());
					localStorage.setItem("cm_contact_lname", $("#lname").val());
					localStorage.setItem("cm_contact_email", $("#cemail").val());	
					location.replace("<?php echo base_url();?>crm/compose/"+tid.value);
					return;
				}								
				if(rowno==1) {
					$("#eoid").val(tid.value);
					$("#etitle").val($(tid).find(":selected").text());
					$("#eotitle").val($(tid).find(":selected").text());
					
				}
			}<?php /*?> else {
				var et1=tid.value.split("-");
				if(et1[0]==68) {
					//Store contact data
					localStorage.setItem("cm_contact_fname", $("#cname").val());
					localStorage.setItem("cm_contact_lname", $("#lname").val());
					localStorage.setItem("cm_contact_email", $("#cemail").val());	
					location.replace("<?php echo base_url();?>crm/compose/t"+et1[1]);
					return;
				}
			}<?php */?>
			//$("#subject").val($(this).find(":selected").text());
			$(".schrow"+rowno+" .loader2").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
            var dpams = {};
			var ajaxurl="<?php echo base_url();?>home/get_emailTemplate/"+tid.value;
            dpams = {blockno:etextcount};
			if(stype==2) {
                ajaxurl="<?php echo base_url();?>crm/get_saved_emailTemplate/"+tid.value;
                dpams = {blockno:etextcount};
            }
			$.ajax({
			  type: "POST",
              data: dpams,
			  url: ajaxurl
				}).done(function( data ) {
					$(".schrow"+rowno+" .loader2").html('');
					//load email thread
					//if(tid.value=="68-161") 
					if(stype==1)
					{						
						getEmailThread(data,rowno,tid);                        
						return;
					} else {
                        var sevar = JSON.parse(data);
                        data = sevar.template;
                    }	
					var x1,x2,x3,x4=0;
					if(stype==1) {
						var x0='<p><strong>Subject line:';						
						while(data.indexOf(x0)!=-1) {
							x1=data.split(x0);
							x1=x1[1].split("</p>");
							x3=x0+x1[0]+'</p>';
							x2=x3;
							x2 = $(x2).text();
							x2 = x2.replace("Subject line:","");
							x2 = x2.replace(/\s{2,}/g, ' ');
							x2 = x2.replace("\n","");
							x2 = x2.replace("\r","");
							if(x4==0) $("#subject"+rowno).val(x2);
							x2 = x1[0]+'</p>';
							data = data.replace(x3,"");
							x4++;
						}
					} else {
						var eContent = data.split("[SUBJECT@SUBJECT]");
						data = eContent[0];
						$("#subject"+rowno).val(eContent[1]);
					}
					data = data.replace("<p><strong>Email body:</strong></p>","");
					data = data.replace(" edit_area","");
					//emailContent=data;
					emailContent[rowno-1]=data;
					if(cfname) {
						while(data.indexOf("[Prospect First Name]")!=-1) {
							x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
							data = data.replace(x2,cfname);
							x2 = '[Prospect First Name]';
							data = data.replace(x2,cfname);
						}
					}
					tinyMCE.get('econtent'+rowno).setContent(data);
					tinyMCE.triggerSave();
					if(rowno==1 && stype==2) $(".edelete_box").show();
                    setSortOrder();
                    //Saved email tasks
                    if(stype==2 && sevar.tasks!="" && sevar.tasks!=undefined) {
                        var emailnode = $(tid).parents("tr");
                        while(emailnode.next().hasClass("emailnode")==true) emailnode = emailnode.next();
                        emailnode.after(sevar.tasks);                        
                        $(".setnodes"+etextcount+" select").uniform();
                        $(".setnodes"+etextcount+" .optval").uniform();
                        etextcount = sevar.bno;
                    }
			  })
			  .fail(function(jqXHR, textStatus) {
				alert( "Unable to load template, please try again" );
			  });
		}
		//Delete saved email template
		function remove_saved_template(){
			if($(".loader").html().length>0) {
				alert("Sending mail inprocess....");
				return;
			}
			$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$.ajax({
			  type: "POST",
			  url: "<?php echo base_url()."crm/compose"?>",
			  data: {action:'delsTemplate',stid:$("#stid1").val()}
				}).done(function( data ) {				
					$(".loader").html('');						
					location.replace("<?php echo base_url()."crm/compose"?>");
			  });
		}
		//Split default email thread
        var sortorder=<?php echo $ei?>;
		function getEmailThread(evar2,rno,tid) {
			if($(".schrow").length>0 && rno==1) {
				etextcount=1;				
				var erowno;
				$(".schrowTimes").each(function(){
					erowno=$(this).attr("class").replace("schrowTimes schrow","");
					deletesch(erowno);
				});
			}
            sortorder=0;
			var evar = JSON.parse(evar2);
            var dis=null;
			$.each(evar, function(i, itm) {							
                sortorder++;
				if(i>0) addeditor(dis); 
				if(i==0) i=rno-1; else i=etextcount-1;
				emt=itm.info;				
				if(itm.saved==1) $("#subject"+(i+1)).val(itm.subject);
				else {
					//subject
					sndl="<p><strong>Subject line:</strong>";
					endl="</p>";
					emt2=emt.split(sndl);
					emt3=emt2[1].split(endl);
					emsub=emt3[0];
					em2=sndl+emt3[0]+endl;
					emt = emt.replace(em2,"");
					emsub = emsub.replace("<span>","");
					emsub = emsub.replace("</span>","");
					$("#subject"+(i+1)).val(emsub);
				}
                $("#sorder"+(i+1)).val(sortorder);
				emailContent[i]=emt;
				if(cfname) {
					x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
					emt = emt.replace(x2,cfname);
				}
				try {
					tinyMCE.get('econtent'+(i+1)).setContent(emt);					
				}
				catch(err) {console.log(err);
					alert("Unable to load Email content, please try reload the page once.");
					return;
					//$('#econtent'+(i+1)).html(emt);
				}				
				if(i>0) {
					$("#schcount"+(i+1)).val(itm.schcount);
					$("#schcount"+(i+1)).parent().find("span").html(itm.schcount);
					$("#schtype"+(i+1)).val(itm.schtype);
					$("#schtype"+(i+1)).parent().find("span").html(itm.schtype=="2"?"Week":"Day");
				}
				//$(".schrow"+(i+1)+" .tname").val($("#tname1").val());
				$(".schrow"+(i+1)+" .tname").val($(tid).find(":selected").text());

                //Saved email tasks
                //console.log("0. Tasks "+itm.bno);
                if(itm.bno!=undefined) etextcount = parseInt(itm.bno);
                //console.log(etextcount);
                if(itm.tasks!="" && itm.tasks!=undefined) 
                {
                    //console.log("1. Tasks started "+itm.bno);
                    
                    var emailnode = $(".schrow"+etextcount+".rowfue");
                    //console.log(emailnode);
                    emailnode.after(itm.tasks);
                    /*for(var tno=etextcount+1;tno<=etextcount+itm.taskcount;tno++) {
                        $(".setnodes"+tno+" select").uniform();
                        $(".setnodes"+tno+" .optval").uniform(); 
                        etextcount++;   
                    }*/ 
                    $(".setnodes"+itm.bno+" select").uniform();
                    $(".setnodes"+itm.bno+" .optval").uniform();
                    etextcount = parseInt(etextcount)+parseInt(itm.taskcount);
                    dis = $(".emailnode:last .addbtn.bRed");
                    //console.log("2. Tasks end "+tno);
                } else 
                dis = $(".schrow"+(etextcount)+".rowfue .addbtn.bRed");
			});
			//tinyMCE.triggerSave();
		}
		function getEmailThread2(evar) {
			if($(".schrow").length>0) {
				etextcount=1;				
				var erowno;
				$(".schrowTimes").each(function(){
					erowno=$(this).attr("class").replace("schrowTimes schrow","");
					deletesch(erowno);
				});
			}
			var etp = evar.split("<br /><hr />");
			var n1,emt,emsub,emt2,emt3,em2,sndl,endl,x2;
			for(n1=0;n1<6;n1++) {
				emt=etp[n1];
				//head1
				sndl="<p><strong>";
				endl="</strong></p>";
				emt2=emt.split(sndl);
				emt3=emt2[1].split(endl);
				em2=sndl+emt3[0]+endl;
				emt = emt.replace(em2,"");
				//head2
				if(n1>0) {
					emt2=emt.split(sndl);
					emt3=emt2[1].split(endl);
					em2=sndl+emt3[0]+endl;
					emt = emt.replace(em2,"");
				}
				//subject
				sndl="<p><strong>Subject line:</strong>";
				endl="</p>";
				emt2=emt.split(sndl);
				emt3=emt2[1].split(endl);
				emsub=emt3[0];
				em2=sndl+emt3[0]+endl;
				emt = emt.replace(em2,"");
				if(n1>0) addeditor();
				$("#subject"+(n1+1)).val(emsub);
				emailContent[n1]=emt;
				if(cfname) {
					x2 = '<span class="dynamic_value">[Prospect First Name]</span>';
					emt = emt.replace(x2,cfname);
				}
				tinyMCE.get('econtent'+(n1+1)).setContent(emt);				
			}
			tinyMCE.triggerSave();
		}
		
		//Same time changed
		function same_time() {
			if($("#sametime").prop('checked')==false) {
				$(".schtimes select").addClass('required');
				$(".schtimes").show();
			} else {
				$(".schtimes select").removeClass('required');
				$(".schtimes").hide();
			}
		}
		//Single time changed
		function same_time_single(dis) {
			if($(dis).prop('checked')==false) {
				$(dis).parents('td').find(".schtimes select").addClass('required');
				$(dis).parents('td').find(".schtimes").show();
			   // $(".schtimes").show();
			} else {
				$(dis).parents('td').find(".schtimes select").removeClass('required');
				$(dis).parents('td').find(".schtimes").hide();
			}
		}
		//Collapse
		function collapse_1(tid,dis) {
			if($(dis).attr("data-colp")=="1") {
				$("#sec"+tid).hide();
				$(dis).attr("data-colp","0");
				$(dis).find("span").removeClass("icon-arrow-down");
				$(dis).find("span").removeClass("icon-arrow-right");
				$(dis).find("span").addClass("icon-arrow-right");
			} else {
				$("#sec"+tid).show();
				$(dis).attr("data-colp","1");
				$(dis).find("span").removeClass("icon-arrow-down");
				$(dis).find("span").removeClass("icon-arrow-right");
				$(dis).find("span").addClass("icon-arrow-down");
			}
		}
        function collapse(dis) {
            var sftb = $(dis).parent().find(".scftask");
            if($(dis).attr("data-colp")=="1") {
                sftb.hide();
                $(dis).attr("data-colp","0");
            } else {
                sftb.show();
                $(dis).attr("data-colp","1");
            }
        }
		//Objection changes
		function inter_change_1(dis,type) {
			if(type=='rad') {
				$(".scho_txt").val('');
				if($(dis).val()=="O" && $(dis).prop("checked")==true) $(".span_schother").show();
				else $(".span_schother").hide();
			}
		}
		function contactChange(dis)
		{
			$.ajax({
				type : 'POST',
				url : '<?php echo base_url()."crm/totalContacts/" ?>', 
				data : { 'list_id': dis},
				success : function(data)
				{				
					$("#emailsmonthTitle").html("Emails Selected to be Sent ");
					$("#emailsmonthValue").html(data);
				} 
			});
		}
        function inter_change(dis) {
            var sftb = $(dis).parents(".scftask");
            sftb.find(".scho_txt").val('');
            if($(dis).val()=="O" && $(dis).prop("checked")==true) sftb.find(".span_schother").show();
            else sftb.find(".span_schother").hide();            
        }
        //Add Task
        function addtask(dis) {
            var sftb = $(dis).parents(".rowfue");
            etextcount++;
            var fehtml = '<tr class="schrow'+etextcount+' tasknode" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr>'+
                        '<tr class="schrow'+etextcount+' tasknode">'+
                            '<td class="two" colspan="2">'+
                                '<div class="csect scftask">'+
                                    '<table cellpadding="0" cellspacing="0" border="0" width="100%">'+
                                        '<tr>'+
                                            '<th class="Title one" width="225px">Follow-Up Task</th>'+
                                            '<td  colspan="2" align="right"><a href="javascript:void(0);" class="deletechild" onClick="delete_sch('+etextcount+',0)">X</a></td>'+
                                        '</tr>'+
                                        '<tr class="schrowTimes">'+
                                            '<th class="one">Schedule Timing</th>'+
                                            '<td colspan="2" class="two">'+
                                                '<input type="hidden" name="record[schids][]" value="0" /><input type="hidden" name="record[schindx][]" value="'+etextcount+'" /><input type="hidden" name="record[blocktype][]" class="blocktype" value="task" /><input type="hidden" name="record[slno][]" class="slno" value="'+etextcount+'" />'+
                                                '<div>'+
                                                    '<select name="record[tsk_schcounts][]" id="tsk_schcount'+etextcount+'"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"><?php echo $n; ?></option><?php } ?></select>'+ 
                                                    '<select  name="record[tsk_schtypes][]" id="tsk_schtype'+etextcount+'"><option value="">Select Day/Week</option><option value="1">Days</option><option value="2">Weeks</option></select>'+
                                                '</div>'+
                                            '</td>'+
                                        '</td>'+    
                                        '<tr>'+
                                            '<th class="one"></th>'+
                                            '<td class="two">'+                                                
                                                <?php foreach($Schedules as $ci=>$option) {?>
                                                '<div><input type="radio" class="optval" name="record[schs]['+etextcount+']" value="<?php echo $option;?>" onChange="inter_change(this)" /> <?php echo $option;?></div>'+
                                                <?php }?>
                                                '<div>'+
                                                    '<input type="radio" name="record[schs]['+etextcount+']" class="optval schother" value="O" onChange="inter_change(this)" /> Other '+
                                                    '<span class="span_schother" style="display:none;">'+
                                                        '<input name="record[sch_txts][]" type="text" value="" class="scho_txt" />'+
                                                    '</span>'+
                                                '</div>'+
                                            '</td>'+
                                            '<td class="two"><b>Notes:</b><br />'+
                                                '<textarea class="txtnotes" id="schinotes" name="record[schnotess][]" style="height:100px;"></textarea>'+
                                            '</td>'+
                                        '</tr>'+
                                    '</table>'+
                                '</div>'+
                            '</td>'+
                        '</tr>'+
					   '<tr class="schrow'+etextcount+' rowfue emailnode">'+
                		'<th class="one"></th>'+
               		   '<td class="two"><input type="button" class="buttonM bRed addbtn" value="Add a Follow-Up Email" onClick="addeditor(this)" /> '+
              			' <input type="button" class="buttonM bGreen addbtn" value="Add a Follow-Up Task" onClick="addtask(this)" data-colp="0" />'+
               		  '</td>'+              
            		  '</tr>' ;                                        
            //sftb.after(fehtml);
            var tasknode = sftb;
            while(tasknode.next().hasClass("emailnode")==true) tasknode = tasknode.next();
            tasknode.after(fehtml);
            $(".schrow"+etextcount+" select").uniform();
            $(".schrow"+etextcount+" .optval").uniform();
        }

        //Delete email task
        function delete_sch(schno,saved) {            
            if(saved!=0) {
                var etmids = $("#remschids").val();
                if(etmids) etmids += ",";
                etmids += saved;
                $("#remschids").val(etmids);
            }
            $(".schrow"+schno).remove();
        }
        //Set Sort Order
        function setSortOrder() {
            var storder=1;
            $("input.sortorder").each(function(){
                storder++;
                $(this).val(storder);
            });
        }
	</script>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>
