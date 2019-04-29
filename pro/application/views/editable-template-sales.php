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
    padding-bottom:20px; display: none;
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
.rowhead{border: none;padding: 2px;padding-left: 40px;height: 20px;border-bottom: none !important;}
.etclose{padding-right: 20px;font-size: 20px;float: right;color: #b30814;font-weight: bold;}
.etreset{float: right;}
.etreset a{height: 10px;padding-top: 3px;margin: 4px;}
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
        $sort=0;
        ////
    ?>
    <!-- Main content -->
    <div class="wrapper">  
        <?php if ($err): ?><br>
            <h3 style="color:red !important;"><?php echo $err; ?></h3>
        <?php endif; ?>
        
       <?php /*?><h3 style="margin-top:30px;"><?php echo $template_info->temp_title;?></h3><?php */?>      
       <div style="text-align: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
       <br clear="all" />
       <form id="changeform" action="<?php echo base_url();?>campaign/changeactiveelement" method="post">
        <table class="custom_content_tab">
            <tr>
                <?php $jbid=0;if($template_info->temp_type=="Interview Emails") {?>
                <th valign="middle">Job Posting</th>
                <td>
                    <select name="activejob" style="float:right;" onchange="$('#changeform').submit();">
                        <option value="">Select</option>
                    <?php foreach($drop_jobpost  as $drop) { ?>
                        <option value="<?php echo $drop->post_id ?>" <?php if($drop->status == 1) {echo "selected";$jbid=$drop->post_id;}?>><?php echo $drop->job_title ?> </option>
                    <?php } ?>
                    </select>
                </td>
                <?php } else {?>
                <th valign="middle">Sales Pitch</th>
                <td>
                    <select name="activecompaignname" style="float:right;" onchange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_campaign as $singlecampaign): ?>
                    <option value="<?php echo $singlecampaign->campaign_id; ?>"  <?php if($singlecampaign->status == 1){ echo "selected";} ?>><?php echo $singlecampaign->campaign_name; ?></option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <th valign="middle">Name Drop</th>
                <td>
                    <select name="activedropname" style="float:right;" onchange="$('#changeform').submit();">
                    <option value="">Select</option>
                    <?php foreach($drop_name  as $singledropname): ?>
                    <option value="<?php echo $singledropname->c_id; ?>" <?php if($singledropname->status == 1){ $active_namedrop=$singledropname->c_id;echo "selected";} ?>><?php echo ($singledropname->value?$singledropname->value:$singledropname->credibility_name); ?></option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <?php }?>
                <th valign="middle">Company</th>
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
        <?php //if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions"){?>
        <input type="checkbox" name="cstm[hide]" value="1" <?php if($template_user->temp_hide) echo ' checked="checked"'; ?> /> Hide Template 
        <?php /*if(!empty($template_content) || $template_user->ignored_sections) {?>
        <br />
        <b style="color:red !important;">This is now a customized template and some of sections of this template is currently disconnected from the Sales Pitch Builder.</b>
        <a href="<?php echo current_url();?>/reset" class="buttonM bGreen">Reset and Reconnect</a>
        <?php }*/?>
        <?php if($template_info->temp_type=="Interview Emails" && !$jbid) {?>
        <br />
        <b style="color:red !important;">Job Posting not selected.</b>
        <?php }?>
        <input type="hidden" value="<?php if($template_user) echo $template_user->ignored_sections;?>" id="ignored" name="cstm[ignore]" />
        <input type="hidden" value="<?php echo $template_info->temp_id;?>" name="cstm[temp_id]" />
        <input type="hidden" value="<?php if($template_info->temp_type=="Interview Emails") echo $jbid; elseif($ecampaign_id) echo $ecampaign_id;?>" name="campaignid" />
        <?php if(($template_info->temp_type=="Interview Emails" && $jbid) || ($template_info->temp_type<>"Interview Emails" && $ecampaign_id)){?>        

        <div id="tabs_123" title="Edit Template">
                <?php   
                $n=0;               
                if(!empty($template_content)) {
                    foreach($template_content as $tpldata) {
                        if($tpldata->sect_sort>$sort) $sort=$tpldata->sect_sort;
                        $n++;
                    ?>
                    <div class="widget etbox custompro tableTabsdb<?php echo "ets".$tpldata->temp_aid; ?>">
                        <div class="rowhead">
                            Custom <input type="checkbox" checked="checked" onchange="togglebox(this)" style="width: 40px;margin-left: 8px;"/> <b class="etlable"><?php echo $tpldata->sect_title; ?></b>
                            <?php /*<div align="right" class="etclose"><span style="cursor:pointer;" onclick="RemSection(<?php echo $tpldata->temp_aid; ?>)">X</span></div>*/?>
                            <div align="right" class="etreset">This section is now customized and it will not be updated with changes made in the Sales Pitch Builder &nbsp; <a href="<?php echo current_url();?>/reset/<?php echo $tpldata->temp_aid; ?>" class="buttonM bGreen">Reset and Reconnect</a></div>
                        </div>                        
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab"
                                    <?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions" || $template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
                                    <tr>
                                        <td class="title" valign="middle">Title</td>
                                        <td>                                            
                                            <input type="text" onchange="setLable(this)" id="tsctitle<?php echo $n; ?>" name="cstm[<?php echo $tpldata->temp_aid;?>][heading]" value="<?php echo $tpldata->sect_title; ?>"/>
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
                }
                    $ignored_sections = array();
                    if($template_user) $ignored_sections = explode(",",$template_user->ignored_sections);
                    if($template_sections)
                    foreach($template_sections as $key => $tsection) {
                        if($tsection->sorting>$sort) $sort=$tsection->sorting;
                        $n++;
                        if(in_array($tsection->content_id,$ignored_sections)!==FALSE) continue;
                    ?>
                    <div class="widget etbox custompro tableTabsdb<?php echo $n; ?>">
                        <div class="rowhead">
                            Standard <input type="checkbox" checked="checked" onchange="togglebox(this)" name="cstm[N<?php echo $n; ?>][standard]" value="<?php echo $n;?>" style="width: 40px;"/> <b class="etlable"><?php echo $tsection->sect_title; ?></b>
                            <div align="right" class="etclose"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $n; ?>,<?php echo $tsection->content_id; ?>);">X</span></div>
                        </div>
                        
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">                                    
                                    <?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions" || $template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
                                    <tr>
                                        <td class="title" valign="middle">Title</td>
                                        <td>
                                            <input type="text" onchange="setLable(this)" id="tsctitle<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][heading]" value="<?php echo $tsection->sect_title; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[N<?php echo $n; ?>][sorder]" value="<?php echo $tsection->sorting;?>" style="width: 40px;"/></td>
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
                                        <input type="hidden" name="cstm[N<?php echo $n; ?>][sorder]" value="<?php echo $tsection->sorting;?>"/>
                                        <?php }?>
                                        <input type="hidden" id="tsid<?php echo $n; ?>" name="cstm[N<?php echo $n; ?>][tsid]" value="<?php echo $tsection->content_id; ?>"/>
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
                
                ?>
         </div>       
        
        
        <?php if($template_info->temp_type=="Sales Scripts" || $template_info->temp_type=="Key Questions" || $template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?>
        <div align="right">
            <input type="button" onclick="DynamicAddRowStage()" class="buttonM bBlack" value="<?php echo (($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Add Email':'Add a Stage');?>" style="margin-top:10px;color:white !important;">                
        </div>  
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
    var sort_counter = <?php echo $sort;?>;
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
    function deleteSection(delid,sid)
    {
        //Ignored sections
        if(sid!='0') {
            var ignores = $("#ignored").val();
            if(ignores) ignores +=',';
            ignores +=sid;
            $("#ignored").val(ignores);
        }  
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
        sort_counter++;
        data = '<div class="widget etbox custompro tableTabsdb'+counter+'"><div class="rowhead">Custom <input type="checkbox" onchange="togglebox(this)" style="width: 40px;margin-left: 8px;"> <b class="etlable"><?php echo(($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Email':'Stage');?> '+counter+'</b><div align="right" class="etclose"><span style="cursor:pointer;" onclick="deleteSection('+counter+',0)">X</span></div></div><div class="tab_container" style="display:block"><div id="ttab1" class="tab_content"><div class="custom_content_table_data"><table class="custom_content_tab"><tr><td class="title" valign="middle">Title</td><td><input type="hidden" id="tsid'+counter+'" name="cstm[N'+counter+'][tsid]" value="0"/><input type="text" id="tsctitle'+counter+'" name="cstm[N'+counter+'][heading]" value="<?php echo(($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails")?'Email':'Stage');?> '+counter+'"/></td></tr><tr><td class="title" valign="middle">Sort Order</td><td><input type="text" name="cstm[N'+counter+'][sorder]" value="'+sort_counter+'" style="width: 40px;"/></td></tr><?php if($template_info->temp_type=="Emails and Letters" || $template_info->temp_type=="Interview Emails"){?><tr><td class="title" valign="middle">Subject</td><td><input type="text" id="subject'+counter+'" name="cstm[N'+counter+'][subject]" value=""/></td></tr><tr><td class="title" valign="middle">Schedule Delivery</td><td class="sd'+counter+'"><select name="cstm[N'+counter+'][dowcount]"><?php for($n1=1;$n1<=30;$n1++){ ?><option value="<?php echo $n1;?>"><?php echo $n1; ?></option><?php } ?></select><select  name="cstm[N'+counter+'][dow]"><option value="1">Days</option><option value="2" selected="selected">Weeks</option></select></td></tr><tr><td class="title" valign="middle">Email Template</td><td style="padding-bottom: 4px;"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></td></tr><?php }?><tr><td></td><td><?php if($template_info->temp_type<>"Emails and Letters" && $template_info->temp_type<>"Interview Emails"){?><div class="filldiv"><div class="box1"><b>(Optional) Fill with SalesScripter generated content</b><br/><b>* Warning: this will replace any text that you have entered</b></div><div class="box2"><select onchange="changeContent(<?php echo $template_info->temp_id;?>,this.value,this,'+counter+')" id="sb'+counter+'"><?php echo $tsections;?></select></div></div><?php }?></td><tr><tr><td class="title" valign="middle">Content</td><td><textarea id="contentdb'+counter+'" class="tinyMCE" name="cstm[N'+counter+'][value]"></textarea></td></tr></table></div></div></div><div class="clear"></div></div>';
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
function togglebox(dis) {
    $(dis).parents('.etbox').find('.tab_container').toggle();
}
function setLable(dis){
    $(dis).parents('.etbox').find('.etlable').html($(dis).val());   
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
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>