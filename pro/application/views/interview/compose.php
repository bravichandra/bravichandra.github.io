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
    <div class="main-wrapper crmlite"> 
    	<div class="formRow crmlite" id="cLookup">
            <div class="qrbox">
                <div class="abox1">Account Lookup</div>
                <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>
            <div class="search-list"></div>
        </div> 
		<?php if ($err): ?><br>
			<h3 style="color:red !important;"><?php echo $err; ?></h3>
		<?php endif; ?>  
       <!-- <div align="center" class="dropdowns"><?php // $this->load->view('common/drop_menu');?></div> -->       
       <div align="center" class="dropdowns"><?php  		
				$this->load->view('interview/staffing_drop_menu');
			?></div><br>
        <b style="color:red !important;"><?php if ($smtp_info==0): ?><br />Please enter the SMTP details for your email account in order to send emails. <a href="<?php echo base_url()."crm/settings";?>">Click here</a> to set up.<?php endif; ?>
        </b>
        <form method="post" id="frmsmtp" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" value="save" />
            <input type="hidden" name="record[act]" value="send" id="subaction" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="width:100%" id="frmsemail">
            <tr>
            	<th class="one">Search Contact</th><td class="two">
                    <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact])?>" name="record[contact]" id="contact" />
                	<input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title])?>" name="record[contact_title]" id="contact_title" /><a href="javascript:void(0);" onclick="getLookup('contact','contact');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                    <div class="displayNone"><?php foreach($allContacts as $cont) echo '<span id="em_'.$cont->contact_id.'">'.$cont->email.'</span>';?></div>
				</td>
            </tr>
            <tr>
            	<th class="one">Contact Name*</th><td class="two">
                    <input type="text" value="<?php if(isset($contact_fname)) echo form_prep($contact_fname)?>" name="record[cname]" id="cname" placeholder="First Name" /> 
                    <input type="text" value="<?php if(isset($contact_lname)) echo form_prep($contact_lname)?>" name="record[lname]" id="lname" placeholder="Last Name" /> 
				</td>
            </tr>
            <tr>
                <th class="one">Email Address*</th><td class="two"><input type="text" value="<?php if(isset($contact_email)) echo form_prep($contact_email)?>" name="record[cemail]" id="cemail" /></td>
            </tr>
            <tr class="schrow1">
                <th class="one">Email Template</th>
                <td class="two">
                <input type="hidden" name="record[tname]" class="tname" id="tname1" value="" />
                <select name="record[tid]" id="tid1" onchange="setEditor(this,1,1)">
                    <option value="">Select Email Template</option>
					<?php 
						$tempid=0;
						$etemp_options = '<option value="">Select Email Template</option>';
						foreach($templates as $t): if($tempid==$t->temp_id) continue; 
							$etemp_options .= '<option value="'.$t->temp_id."-".$t->sect_id.'">'.$t->temp_title.'</option>';
						?>
                    <option value="<?php echo $t->temp_id."-".$t->sect_id;?>" <?php if($t->sect_id==$template_content_id) echo ' selected="selected"'?>><?php echo $t->temp_title; ?></option>
                    <?php $tempid=$t->temp_id;endforeach; ?>
				</select> 
                <span <?php if(!isset($uemail_templates)) echo 'style="display:none;"';?>>
                [ Or ] 
                <select name="record[stid]" id="stid1" onchange="setEditor(this,2,1)"><?php if(isset($uemail_templates)) echo $uemail_templates?></select>
                </span>
                <span class="loader2"></span>
                <br />
                <b id="ermessage" style="color:red !important;">
                    <?php if(isset($unsubscribed) && $unsubscribed=="1") echo $contact_fname.' '.$contact_lname.' Unsubscribed';?>
                </b>
                </td>
            </tr>
            <tr class="schrow1">
                <th class="one">Subject*</th><td class="two"><input type="text" value="<?php if(isset($record['subject'])) echo form_prep($record['subject'])?>" name="record[subject]" id="subject1" style="width: 400px;" /></td>
            </tr>
            <tr class="schrow1">
                <th class="one">Email Content*</th><td class="two">                	
                	<textarea id="econtent1" class="tinyMCE" name="record[info]"><?php if(isset($record['info']))echo $record['info']; ?></textarea>
                    <?php /*?><br />
                    <b>Note:</b> Use this short code to track your links in the email content when user click on it to gain interaction points. <br />This tag automatically adds hyperlinks instead of that tag.<br />
                    Shortcode: [[SSTAG TITLE="" URL=""]]<br />
                    Place your hyperlink text in between double quotes("") for <b>TITLE</b> option.<br />
                    Place your hyperlink url in between double quotes("") for <b>URL</b> option.<?php */?>
                </td>
            </tr>
            <?php 
				$ei=1;
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
                    </span>
                </td>    
            </tr>
			<tr class="schrow<?php echo $ei?> schrow">
            	<th class="one">Email Template</th>
                <td class="two">
                	<input type="hidden" name="record[tnames][]" class="tname" value="" />
                	<select id="tid<?php echo $ei?>" onchange="setEditor(this,1,<?php echo $ei?>)"><?php echo $etemp_options?></select> 
                    <span <?php if(!isset($uemail_templates)) echo 'style="display:none;"';?>>[ Or ] <select id="stid<?php echo $ei?>" onchange="setEditor(this,2,<?php echo $ei?>)"><?php if(isset($uemail_templates)) echo $uemail_templates?></select></span>
                    <span class="loader2"></span>
                    <span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch(<?php echo $ei?>)">X</span></td></tr>
            <tr class="schrow<?php echo $ei?>">
            	<th class="one">Subject*</th><td class="two"><input type="text" name="record[subjects][]" id="subject<?php echo $ei?>" class="required" value="<?php echo form_prep($et->subject)?>" style="width: 400px;" /></td></tr>
            <tr class="schrow<?php echo $ei?>"><th class="one">Email Content*</th><td class="two"><textarea id="econtent<?php echo $ei?>" class="tinyMCE erequired" name="record[infos][]"><?php echo $et->content;?></textarea></td></tr>
            <?php }}?>
            <tr class="rowfue">
                <th class="one"></th>
                <td class="two"><input type="button" class="buttonM bRed" value="Add a Follow-Up Email" onclick="addeditor()" /> 
                	<span id="sametimeBox" style="display:none"><input type="checkbox" checked="checked" id="sametime" name="record[sametime]" onchange="same_time()" /> Send at same time as first email.</span>
                </td>
            </tr>
            <tr class="setemprow">
                <th class="one"><input type="checkbox" id="esave" name="record[esave]" /> Save Email Template</th>
                <td class="two">                	
                    <input type="hidden" value="<?php echo (isset($thread_id)?$thread_id:0);?>" name="record[eoid]" id="eoid" />
                    <input type="hidden" value="<?php if(isset($record['tempname'])) echo form_prep($record['tempname'])?>" name="record[eotitle]" id="eotitle" />
                    <input type="text" value="<?php if(isset($record['tempname'])) echo form_prep($record['tempname'])?>" name="record[etitle]" id="etitle" placeholder="Email Title" />
                    <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" onclick="$('#subaction').val('save');$('#esave').prop('checked',true)" />
                    <span class="edelete_box" <?php echo (isset($thread_id)?"":'style="display:none"')?>;><input type="button" onclick="remove_saved_template()" id="edelete" class="buttonM bRed" value="Delete Email Template" /></span></td>
            </tr>    
        </table>
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" style="width:100%;margin-top: -50px;">
        	<tr>
                <td colspan="2">
                	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    	<tr>
                            <th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onclick="collapse('ce',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> Schedule Follow-Up Task</a></th>
                        </tr>
                        <tr class="csect scftask" id="secce" style="display:none;">
                            <td class="two">
                                <?php foreach($Schedules as $ci=>$option) {?>
                                <div><input type="radio" class="optval" name="record[sch]" value="<?php echo $option;?>" onchange="inter_change(this,'rad')" /> <?php echo $option;?></div>
                                <?php }?>
                                <div>
                                    <input type="radio" name="record[sch]" class="optval schother" value="O" onchange="inter_change(this,'rad')" /> Other 
                                    <span class="span_schother" style="display:none;">
                                        <input name="record[sch_txt]" type="text" value="" class="scho_txt" />
                                    </span>
                                </div>
                                <div>For Due Date: <input name="record[sdate]" type="text" readonly="readonly" value="" class="idate" /></div>
                            </td>
                            <td class="two"><b>Notes:</b><br />
                                <textarea class="txtnotes" id="schinotes" name="record[schnotes]" style="height:100px;"></textarea>
                            </td>
                        </tr>
                    </table>
                </th>
            </tr> 
        </table>    
        
        <div align="center">
            <span class="loader"></span>
            <input type="submit" class="buttonM bBlue" name="btnsave" id="btnsave" onclick="$('#subaction').val('send');" value="Send Mail" <?php if(isset($unsubscribed) && $unsubscribed=="1") echo ' style="display:none;"';?> />
        </div>
        </form>  
       

        	
        </div>
        </div>
    </div>
	<script type="text/javascript">
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
				
				plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks",
		
				// Theme options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
				theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor",
				theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
				theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				oninit : afterTinymce
			});
			
			//Email template changed
			//Saved Email template changed
			//Existing Contact changed
			
			
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
				if($("#cname").val().length==0) {
					alert("Contact name required");
					$("#cname").focus();
					return false;
				}
				if($("#cemail").val().length==0) {
					alert("Contact email required");
					$("#cemail").focus();
					return false;
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
					if(data.substring(0,7)=="SUCCESS") {
						alert("Email sent and interaction has been logged.");
						<?php /*?>location.replace("<?php echo current_url();?>");<?php */?>
						location.replace("<?php echo base_url();?>interviewer/<?php echo ($atype==1?'employee':'applicant')?>/view/"+data.substring(8));
						return;
					} else if(data=="SAVEDTEMPLATEIDS") {	
						alert("Email template saved.");
						location.replace("<?php echo base_url();?>interviewer/compose/<?php echo $parent_id?>");
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
				popboxhead = 'Applicant Lookup';
				ajxmethod='applicant_lookup';
			}
			$("#cLookup .abox1").html(popboxhead);
			$("#cLookup").show();
			$("#cLookup .search-list").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$( "#cLookup .search-list" ).load( "<?php echo base_url()."interviewer/"?>"+ajxmethod, function() {
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
			//$("#cemail").val($("#em_"+scid).text());
			$("#cemail").val($("#mail_"+scid).text());
		}
		//Apply tinymce editor
		function initTinyMCECUST(stageid) {
			tinyMCE.init({
				selector: "#econtent"+stageid,
				content_style: ".mceContentBody {font-size:12px;font-family:Arial,sans-serif;}",
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
		}
		//Add a Follow-Up Email
		function addeditor(){
			etextcount++;
			var saveTemp='<tr class="setemprow">'+$(".setemprow").html()+'</tr>';
			var fehtml = '<tr class="schrow'+etextcount+'" style="background-color:#FFFFFF;"><td colspan="2">&nbsp;</td></tr>';
			fehtml += '<tr class="schrowTimes schrow'+etextcount+'"><th class="one">Schedule Delivery Timing*</th><td class="two"><input type="hidden" class="edsno" name="record[tid][]" value="0" /><select name="record[schcount][]" id="schcount'+etextcount+'" class="required"><option value="">Select number</option><?php for($n=1;$n<=30;$n++){ ?><option value="<?php echo $n;?>"><?php echo $n; ?></option><?php } ?></select> <select  name="record[schtype][]" id="schtype'+etextcount+'" class="required"><option value="">Select Day/Week</option><option value="1">Days</option><option value="2">Weeks</option></select><span class="schtimes"><select name="record[schtime][]" class="required"><option value="">HH</option><?php for($n=1;$n<=12;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select name="record[schmin][]" class="required"><option value="">MM</option><?php for($n=0;$n<60;$n++){$n1=str_pad($n,2,'0',STR_PAD_LEFT) ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select name="record[scham][]"><option value="0">AM</option><option value="1">PM</option></select></span></td></tr>';
			fehtml += '<tr class="schrow'+etextcount+' schrow"><th class="one">Email Template</th><td class="two"><input type="hidden" name="record[tnames][]" class="tname" value="" /><select id="tid'+etextcount+'" onchange="setEditor(this,1,'+etextcount+')"><?php echo $etemp_options?></select> <span <?php if(!isset($uemail_templates)) echo 'style="display:none;"';?>>[ Or ] <select id="stid'+etextcount+'" onchange="setEditor(this,2,'+etextcount+')"><?php if(isset($uemail_templates)) echo str_replace("'","\'",$uemail_templates)?></select></span><span class="loader2"></span><span style="float:right;cursor:pointer;color: #FF0415;font-weight: bold;padding-left: 20px;" onclick="deletesch('+etextcount+')">X</span></td></tr><tr class="schrow'+etextcount+'"><th class="one">Subject*</th><td class="two"><input type="text" value="" name="record[subjects][]" id="subject'+etextcount+'" class="required" style="width: 400px;" /></td></tr><tr class="schrow'+etextcount+'"><th class="one">Email Content*</th><td class="two"><textarea id="econtent'+etextcount+'" class="tinyMCE erequired" name="record[infos][]"></textarea></td></tr><tr class="rowfue"><th class="one"></th><td class="two"><input type="button" class="buttonM bRed" value="Add a Follow-Up Email" onclick="addeditor()" /> <span id="sametimeBox" style="display:none"><input type="checkbox" checked="checked" id="sametime" name="record[sametime]" onchange="same_time()" /> Send at same time as first email.</span></td></tr>'+saveTemp;
			$(".setemprow").remove();
			$(".rowfue").remove();
			$("#frmsemail").append(fehtml);
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
		}
		//Delete editor
		function deletesch(schno) {
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
			var tempselbox = $(tid).parents(".two");
			tempselbox.find(".tname").val($(tid).find(":selected").text());
			if(stype==2) {
				if(tid.value.substr(0,1)=="T") {
					//Store contact data
					localStorage.setItem("cm_contact_fname", $("#cname").val());
					localStorage.setItem("cm_contact_lname", $("#lname").val());
					localStorage.setItem("cm_contact_email", $("#cemail").val());	
					location.replace("<?php echo base_url();?>interviewer/compose/"+tid.value);
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
			var ajaxurl="<?php echo base_url();?>home/get_emailTemplate/"+tid.value;
			if(stype==2) ajaxurl="<?php echo base_url();?>crm/get_saved_emailTemplate/"+tid.value;
			$.ajax({
			  type: "POST",
			  url: ajaxurl
				}).done(function( data ) {
					$(".schrow"+rowno+" .loader2").html('');
					//load email thread
					//if(tid.value=="68-161") 
					if(stype==1)
					{						
						getEmailThread(data,rowno,tid);
						return;
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
		function getEmailThread(evar2,rno,tid) {
			if($(".schrow").length>0 && rno==1) {
				etextcount=1;				
				var erowno;
				$(".schrowTimes").each(function(){
					erowno=$(this).attr("class").replace("schrowTimes schrow","");
					deletesch(erowno);
				});
			}
			var evar = JSON.parse(evar2);
			$.each(evar, function(i, itm) {							
				if(i>0) addeditor();		
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
		//Collapse
		function collapse(tid,dis) {
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
		//Objection changes
		function inter_change(dis,type) {
			if(type=='rad') {
				$(".scho_txt").val('');
				if($(dis).val()=="O" && $(dis).prop("checked")==true) $(".span_schother").show();
				else $(".span_schother").hide();
			}
		}
	</script>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>