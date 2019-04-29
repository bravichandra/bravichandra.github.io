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
    <div class="main-wrapper applicanlite">
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
        <form method="post" onsubmit="return save_record();" action="<?php echo current_url();?>" enctype="multipart/form-data">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="4">Document Information
				</th>
            </tr>
            <tr>
                <th class="one">Title</th>
                <td class="two"><input type="text" value="<?php if(isset($record[notes_title])) echo form_prep($record[notes_title])?>" name="record[notes_title]" id="notes_title" /></td>
            </tr>
			<tr>
				<th class="one">Upload(Image|Doc|Excel|Pdf)</th><td class="two"><input type="file" name="upload" /></td>
			</tr>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <a href="<?php echo base_url();?>interviewer/<?php echo ($atype==2?'yourprofile':$parent_section."/view/".$parent_id);?>" class="buttonM bRed">Back</a>
                    </div>		
                </td>
            </tr>
        </table>
        </form>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
	//Skip hint
	function save_record(){
		if($("#notes_title").val().length==0) {
			alert("Title required");
			$("#notes_title").focus();
			return false;
		}
		return true;
	}
		
		
function hide_record(dis)
{		
		if($("#notes_private").is(":checked"))   
        $("#tomonth").hide();
    else
        $("#tomonth").show();
	}
</script>	
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>