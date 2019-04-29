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
	<?php  		
	$this->load->view('common/crm_nav');
	?>
    <!-- Main content -->
    <div class="wrapper">  
		<?php if ($er): ?><br>
			<h3 style="color:red !important;"><?php echo implode("<br/>",$er); ?></h3>
		<?php endif; ?>
		
	   <?php //echo "<pre>"; print_r($record); echo "</pre>";?>      
     
    
        <br clear="all" /><br />
        <form class='form_123' id="validate" action="<?php echo current_url();?>" method="post">
        <label><b>Job Title:</b> </label> 
        <input type="text" name="cstm[job_title]" value="<?php echo $record['job_title']; ?>" style="border:1px solid #CCCCCC; font-size:15px;width: 500px;"/>
        
		<br />
		<label><b>Location:</b> </label> 
        <input type="text" name="cstm[location]" value="<?php echo $record['location']; ?>" style="border:1px solid #CCCCCC; font-size:15px;width: 500px;"/>
        <br />
		<label><b>Play Rate:</b> </label> 
        <input type="text" name="cstm[playrate]" value="<?php echo $record['playrate']; ?>" maxlength="250" style="border:1px solid #CCCCCC; font-size:15px;width: 500px;"/>
      	  <input type="hidden" value="<?php echo $record['post_id'];?>" name="cstm[post_id]" />
        
    	<div id="tabs_1234" title="Edit Job Post">
				<?php 	
				$n=0;
				if(!empty($record)) {
					foreach($record['section'] as $section) {
					$section=(array)$section;
					
					$n++;
					
					?>
					<div class="widget custompro tableTabsdb<?php echo "ets".$section['sect_id']; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="RemSection(<?php echo $section['sect_id']; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                
                                    <tr>
                                        <td class="title" valign="middle">Section Heading</td>
                                        <td>                                            
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[section][<?php echo $n;?>][title]" value="<?php echo  $section['title']; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[section][<?php echo $n;?>][sorder]" value="<?php echo $section['sorder'];?>" style="width: 40px;"/></td>
                                    </tr>
                                 
                                    <tr>
                                        <td class="title" valign="middle"></td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" class="tinyMCE" name="cstm[section][<?php echo $n;?>][content]"><?php echo $section['content'];?></textarea>
											  <input type="hidden" value="<?php echo $section['sect_id'];?>" name="cstm[section][<?php echo $n;?>][sect_id]" />
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
               		<?php	
							
					} // foreach
				} else {	
									
					$n++;
					?>
					<?php //Job Description  ?>
                    <div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $n; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                         
                                    <tr>
                                        <td class="title" valign="middle">Section Heading</td>
                                        <td>
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[section][N<?php echo $n; ?>][title]" value="Job Description"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[section][N<?php echo $n; ?>][sorder]" value="<?php echo $n; ?>" style="width: 40px;"/></td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle"></td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" data-sno="<?php echo $n; ?>" class="tinyMCE" name="cstm[section][N<?php echo $n; ?>][content]"></textarea>
											 <input type="hidden" value="0" name="cstm[section][N<?php echo $n; ?>][sect_id]" />
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
					<?php $n++; //Roles and Responsibilities ?>	
					<div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $n; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	
                                    <tr>
                                        <td class="title" valign="middle">Section Heading</td>
                                        <td>
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[section][N<?php echo $n; ?>][title]" value="Roles and Responsibilities"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[section][N<?php echo $n; ?>][sorder]" value="<?php echo $n; ?>" style="width: 40px;"/></td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle"></td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" data-sno="<?php // echo ($n?$n:2); ?>" class="tinyMCE" name="cstm[section][N<?php echo $n; ?>][content]"></textarea>
											 <input type="hidden" value="0" name="cstm[section][N<?php echo $n; ?>][sect_id]" />
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
					 <?php $n++; //Preferred Skills and Experience ?>
					<div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $n; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                                	
                                    <tr>
                                        <td class="title" valign="middle">Section Heading</td>
                                        <td>
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[section][N<?php echo $n; ?>][title]" value="Preferred Skills and Experience"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[section][N<?php echo $n; ?>][sorder]" value="<?php echo $n; ?>" style="width: 40px;"/></td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle"></td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" data-sno="<?php //echo ($n?$n:3); ?>" class="tinyMCE" name="cstm[section][N<?php echo $n; ?>][content]"></textarea>
											 <input type="hidden" value="0" name="cstm[section][N<?php echo $n; ?>][sect_id]" />
                                        </td>
                                    </tr>
                                </table>
                                
                                </div>
                                </div>
                        </div>	
                        <div class="clear"></div>
                    </div>
					

					<?php $n++; //Compensation Details ?>		
 					<div class="widget custompro tableTabsdb<?php echo $n; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection(<?php echo $n; ?>);">X</span></h5>
                        <div class="tab_container">
                            <div id="ttab1" class="tab_content">
                                <div class="custom_content_table_data">
                                <table class="custom_content_tab">
                            
                                    <tr>
                                        <td class="title" valign="middle">Section Heading</td>
                                        <td>
                                            <input type="text" id="tsctitle<?php echo $n; ?>" name="cstm[section][N<?php echo $n; ?>][title]" value="Compensation Details"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle">Sort Order</td>
                                        <td><input type="text" name="cstm[section][N<?php echo $n; ?>][sorder]" value="<?php echo $n; ?>" style="width: 40px;"/></td>
                                    </tr>
                                    <tr>
                                        <td class="title" valign="middle"></td>
                                        <td>
                                            <textarea id="contentdb<?php echo $n; ?>" data-sno="<?php //echo ($n?$n:4); ?>" class="tinyMCE" name="cstm[section][N<?php echo $n; ?>][content]"></textarea>
											 <input type="hidden" value="0" name="cstm[section][N<?php echo $n; ?>][sect_id]" />
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
		      
	  
		<div align="right">
			<input type="button" onclick="DynamicAddRowStage()" class="buttonM bBlack" value="Add a Stage" style="margin-top:10px;color:white !important;">	        	
		</div>	
        <div class="fluid" style="margin-top:15px;"><br clear="all" />
          	<input id="save_button" style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" />
			<?php if($record['post_id']){?> <a href="<?php echo base_url(); ?>interviewer/jobpost/view/<?php echo $record['post_id'];?>" style="margin-top: -25px; margin-right: 10px" class="buttonM bGreen">View</a><?php } ?>
            <input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bRed" name="submit_done" value="Done" />
     
        </div>
      
        </form>	
        </div>
	<script>
	var counter = <?php echo $n ?>;
	
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
		data = '<div class="widget custompro tableTabsdb'+counter+'"><h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"><span style="cursor:pointer;" onclick="deleteSection('+counter+');">X</span></h5><div class="tab_container"><div id="ttab1" class="tab_content"><div class="custom_content_table_data"><table class="custom_content_tab"><tr><td class="title" valign="middle">Section Heading</td><td><input type="hidden" id="tsid'+counter+'" name="cstm[section][N'+counter+'][tsid]" value="0"/><input type="text" id="tsctitle'+counter+'" name="cstm[section][N'+counter+'][title]" value="Stage '+counter+'"/></td></tr><tr><td class="title" valign="middle">Sort Order</td><td><input type="text" name="cstm[section][N'+counter+'][sorder]" value="'+counter+'" style="width: 40px;"/></td></tr><tr><td></td><td></td><tr><tr><td class="title" valign="middle"></td><td><textarea id="contentdb'+counter+'" class="tinyMCE" name="cstm[section][N'+counter+'][content]"></textarea></td></tr></table></div></div></div><div class="clear"></div></div>';
		$('#tabs_1234').append(data);
		initTinyMCECUST(counter);
		
	}
	
	if(counter==0) DynamicAddRowStage();
	</script>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>