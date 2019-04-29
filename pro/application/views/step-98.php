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
.custom_content_table_data .custom_content_tab
{
    float:left;
    width:100%;
    border-top:1px solid #cccccc;
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
    <?php  //echo $this->load->view('common/campaign_nav');?>
    <?php  echo $this->load->view('common/empty_nav');?>
    <!-- Main content -->
    <div class="wrapper">  
		<?php if ($err): ?><br>
			<h3 style="color:red !important;"><?php echo $err; ?></h3>
		<?php endif; $sort_order=0;?>
        
       

	   <h3 style="margin-top:30px;">Response Builder</h3>
       <br clear="all" />
       <div>
       <div style="float: left;">
       <?php $this->load->view('common/drop_menu');?></div>   
       </div>
       <div style="float: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div> 

       
        <form class='form_123' id="validate" action="<?php echo current_url();?>" method="post">
        	<input type="hidden" name="campaignid" value="<?php echo $ecampaign_id; ?>"/> 
            <input type="hidden" name="sbremoved" id="sbremoved" value="<?php echo $campaign_rsb; ?>"/>   
        <?php if($ecampaign_id){?>
    	<div id="tabs_123" class="objectmap">
                <div class="widget custompro tableTabsdb<?php echo $pi;?>">
                    <div class="tab_container">
                        <div id="ttab1" class="tab_content">
                            <div class="custom_content_table_data">
                            
							<?php
								$nobjects_count=0;
								$objs=array();
								if(!empty($objectionInfo)) {
									foreach($objectionInfo as $key => $obj_info)
									{
										$key=$obj_info->ob_id;
										if($obj_info->ob_defid) $objs[]=$obj_info->ob_defid;
										if($obj_info->ob_id>$nobjects_count) $nobjects_count=$obj_info->ob_id;
                                        $sort_order++;
							?>
                            <div id="divobid<?php echo $key;?>" class="objbox">
                            <table width="100%">
                                <tr>                                    
                                    <td width="100px">                                        
                                        <span style="color:#00CC00;">&nbsp;Custom</span>
                                        <input type="checkbox" checked="checked" value="<?php echo $key;?>" class="chk_obj"/> 
                                    </td>
                                    <th align="left" id="objtitle<?php echo $key;?>"><?php echo $obj_info->ob_title; ?></th>
                                    <td class="delete" align="right">
                                        <?php if($obj_info->ob_defid) {?>
                                        This section is now customized and it will not be updated with changes made in the Sales Pitch Builder &nbsp; 
                                        <a href="javascript:void(0)" class="buttonM bGreen" onclick="del_object(<?php echo $key; ?>);">Reset and Reconnect</a>
                                        <?php }else{?>
                                        <span style="float:right;cursor:pointer;color: #ff0000;font-size: 15px;font-weight: bold;" onclick="del_object(<?php echo $key; ?>);">X</span>
                                        <?php }?>                                        
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="4px" class="custom_content_tab" cellspacing="4px" id="obj<?php echo $key;?>" style="display:none;">
                                <tr>
                                    <td valign="middle">Title*</td>
                                    <td>
                                    	<input type="hidden" name="cstm[new][<?php echo $key;?>][ob_defid]" value="0" id="txtobj<?php echo $key;?>"/>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[<?php echo $key;?>][ob_title]" value="<?php echo $obj_info->ob_title; ?>" onkeyup="set_obtitle(<?php echo $key;?>,this.value);"/>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Order</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;" name="cstm[<?php echo $key;?>][ob_order]" value="<?php echo $obj_info->ob_order; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 1 Label</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[<?php echo $key;?>][ob_rsptitle1]" value="<?php echo $obj_info->ob_rsptitle1; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 1*</td>
                                    <td>
                                        <textarea id="contentdb<?php echo $key;?>1" class="tinyMCE" name="cstm[<?php echo $key;?>][ob_rspcontent1]"><?php echo $obj_info->ob_rspcontent1; ?></textarea>                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 2 Label</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[<?php echo $key;?>][ob_rsptitle2]" value="<?php echo $obj_info->ob_rsptitle2; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 2</td>
                                    <td>
                                        <textarea id="contentdb<?php echo $key;?>2" class="tinyMCE" name="cstm[<?php echo $key;?>][ob_rspcontent2]"><?php echo $obj_info->ob_rspcontent2; ?></textarea>                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 3 Label</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[<?php echo $key;?>][ob_rsptitle3]" value="<?php echo $obj_info->ob_rsptitle3; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 3</td>
                                    <td>
                                        <textarea id="contentdb<?php echo $key;?>3" class="tinyMCE" name="cstm[<?php echo $key;?>][ob_rspcontent3]"><?php echo $obj_info->ob_rspcontent3; ?></textarea>                                    </td>
                                </tr>
                            </table>  
                            </div>
                            <?php			
									}
								}
							?>
               				<?php foreach($parts as $pi=>$pv){
								if($pi<=4) continue;
								if(in_array($pi,$objs)!=false) continue;
								$nobjects_count++;
								$oresp = $pv['resp'];
                                $sort_order++;
							?>  
                            <div id="divobid0<?php echo $pi;?>" class="objbox">              
                            <table width="100%">
                                <tr>                                    
                                    <td width="100px">                                        
                                        <span style="color:#0000ff">&nbsp;Standard</span>
                                        <input type="checkbox" checked="checked" value="0<?php echo $pi; ?>" class="chk_obj"/>
                                    </td>
                                    <th align="left" id="objtitle0<?php echo $pi;?>"><?php echo $pv['title']; ?></th>
                                    <td class="delete">
                                        <span style="float:right;cursor:pointer;color: #ff0000;font-size: 15px;font-weight: bold;" onclick="del_nobject('0<?php echo $pi; ?>');">X</span>
                                    </td>
                                </tr>
                            </table>
                            <table width="100%" cellpadding="4px" class="custom_content_tab" cellspacing="4px" id="obj0<?php echo $pi;?>" style="display:none;">
                                <tr>
                                    <td valign="middle">Title*</td>
                                    <td>
                                        <input type="hidden" name="cstm[new][<?php echo $pi;?>][ob_defid]" value="0" id="txtobj0<?php echo $pi;?>"/>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new][<?php echo $pi;?>][ob_title]" value="<?php echo $pv['title']; ?>" onkeyup="set_obtitle('0<?php echo $pi;?>',this.value);"/>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Order</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;" name="cstm[new][<?php echo $pi;?>][ob_order]" value="<?php echo ($pi-4); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 1 Label</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new][<?php echo $pi;?>][ob_rsptitle1]" value="<?php echo (isset($oresp['resp1'])?$oresp['resp1']:''); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 1*</td>
                                    <td>
                                        <textarea id="contentdb<?php echo $pi;?>1" class="tinyMCE" name="cstm[new][<?php echo $pi;?>][ob_rspcontent1]"><?php echo (isset($oresp['respc1'])?$oresp['respc1']:''); ?></textarea>                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 2 Label</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new][<?php echo $pi;?>][ob_rsptitle2]" value="<?php echo (isset($oresp['resp2'])?$oresp['resp2']:''); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 2</td>
                                    <td>
                                        <textarea id="contentdb<?php echo $pi;?>2" class="tinyMCE" name="cstm[new][<?php echo $pi;?>][ob_rspcontent2]"><?php echo (isset($oresp['respc2'])?$oresp['respc2']:''); ?></textarea>                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 3 Label</td>
                                    <td>
                                        <input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new][<?php echo $pi;?>][ob_rsptitle3]" value="<?php echo (isset($oresp['resp3'])?$oresp['resp3']:''); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="middle">Response 3</td>
                                    <td>
                                        <textarea id="contentdb<?php echo $pi;?>3" class="tinyMCE" name="cstm[new][<?php echo $pi;?>][ob_rspcontent3]"><?php echo (isset($oresp['respc3'])?$oresp['respc3']:''); ?></textarea>                                    </td>
                                </tr>
                            </table>  
                            </div>
                			<?php }?>	                			
                        </div>
                    </div>	
                    <div class="clear"></div>
                </div>
         </div>  <br clear="all" />     
		
		
		<div align="right">
			<input type="button" onclick="DynamicAddRowObject()" class="buttonM bBlack" value="Add an Objection or FAQ" style="margin-top:10px;color:white !important;"/>
		</div>
		
	
        <div class="fluid" style="margin-top:15px;">
          	<input id="save_button" style="margin-top: -25px; margin-right: 10px;" type="submit" class="buttonM bBlue" name="submit" value="Save" /> 
            <input id="done_button" style="margin-top: -25px; margin-right: 10px;" type="submit" class="buttonM bRed" name="submit_done" value="Done" />
          	<input type="hidden" name="step" value="objection">
        </div>
        </div>
        <?php }?>
        </form>	
        </div>
        </div>
    
	<script>
    var sort_order = <?php echo ($sort_order?$sort_order:0);?>;
	var counter = <?php $nobjects_count++;echo $nobjects_count; ?>;
	//Object title changed
	function set_obtitle(obtid,tval){
		$("#objtitle"+obtid).html(tval);
	}
	//Delete DB Object
	function del_object(delid)
	{
		$.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          data: {'action_dev':'delete', 'id_dev':delid}
            }).done(function( data ) {
            if(data == 1) { 
                $('#divobid'+delid).remove(); 
                location.replace("<?php echo current_url();?>");
            }
            else alert('Deletion not done, please try again');
          });
	}
	//Delete New object
	function del_nobject(delid)
	{
        //Maintain removed standard objections
        if(typeof delid == "string") {
            var sbremoved = $("#sbremoved").val();
            if(sbremoved) sbremoved +=",";
            sbremoved +=parseInt(delid);
            $("#sbremoved").val(sbremoved);
        }
		$('#divobid'+delid).remove();
	}
	//apply tinymce to new object contents
	function initTinyMCECUST(stageid)
	{
		tinyMCE.init({
		selector: "#contentdbo"+stageid,
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
		//$("#selectfilledjs"+stageid).uniform();
	}
	//Add New object
	function DynamicAddRowObject()
	{  
		    sort_order++;
			data = '<div id="divobid448900'+counter+'" class="objbox"><table width="100%"><tr><td width="100px"><span style="color:#FF6600;">&nbsp;Custom</span> <input type="checkbox" name="cstm[new]['+counter+'][ob_defid]" value="on'+counter+'" class="chk_obj'+counter+'"/></td><td width="60%" style="font-weight:bold;" id="objtitle448900'+counter+'">Objection '+sort_order+'</td><td class="delete"><span style="float:right;cursor:pointer;color: #ff0000;font-size: 15px;font-weight: bold;" onclick="del_nobject(448900'+counter+');">X</span></td></tr></table><table width="100%" cellpadding="4px" cellspacing="4px" id="objon'+counter+'"><tr><td valign="middle" width="150px">Title*</td><td><input type="hidden" name="cstm[new]['+counter+'][ob_defid]" value="on'+counter+'" id="txtobjo'+counter+'"/><input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new]['+counter+'][ob_title]" value="Objection '+sort_order+'" onkeyup="set_obtitle(448900'+counter+',this.value);"/></td></tr><tr><td valign="middle">Order</td><td><input type="text" style="height: 25px;margin-bottom: 4px;" name="cstm[new]['+counter+'][ob_order]" value="'+sort_order+'"/></td></tr><tr><td valign="middle">Response 1 Label</td><td><input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new]['+counter+'][ob_rsptitle1]" value=""/></td></tr><tr><td valign="middle">Response 1*</td><td><textarea class="tinyMCE" name="cstm[new]['+counter+'][ob_rspcontent1]" id="contentdbo'+counter+'1"></textarea></td></tr><tr><td valign="middle">Response 2 Label</td><td><input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new]['+counter+'][ob_rsptitle2]" value=""/></td></tr><tr><td valign="middle">Response 2</td><td><textarea class="tinyMCE" name="cstm[new]['+counter+'][ob_rspcontent2]" id="contentdbo'+counter+'2"></textarea></td></tr><tr><td valign="middle">Response 3 Label</td><td><input type="text" style="height: 25px;margin-bottom: 4px;width: 80%;" name="cstm[new]['+counter+'][ob_rsptitle3]" value=""/></td></tr><tr><td valign="middle">Response 3</td><td><textarea class="tinyMCE" name="cstm[new]['+counter+'][ob_rspcontent3]" id="contentdbo'+counter+'3"></textarea></td></tr></table></div>';
			$('.custom_content_table_data').append(data);
			initTinyMCECUST(counter+"1");
			initTinyMCECUST(counter+"2");
			initTinyMCECUST(counter+"3");
			$( ".chk_obj"+counter ).click(function() {
                if($(this).is(":checked")==false) {             
                    $("#txtobj"+$(this).val()).val($(this).val());
                    $("#obj"+$(this).val()).show();
                } else {
                    $("#obj"+$(this).val()).hide();
                    $("#txtobj"+$(this).val()).val("0");
                }
            });
			counter++;
		
	}
	$( document ).ready(function() {
		//Obect checkbox checked
		$( ".chk_obj" ).click(function() {
            if($(this).is(":checked")==false) {             
                $("#txtobj"+$(this).val()).val(parseInt($(this).val()));
                $("#obj"+$(this).val()).show();
            } else {
                $("#obj"+$(this).val()).hide();
                $("#txtobj"+$(this).val()).val("0");
            }
        });
		
	});
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/NSjpAc0a-x4?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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