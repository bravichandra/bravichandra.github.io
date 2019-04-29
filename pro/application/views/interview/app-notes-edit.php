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
            	<th class="title" colspan="4"><?php if($ntype=="exp"){ ?> Experience Information 
											<?php } else if($ntype=="edu"){ ?>Education Information
											<?php } else if($ntype=="skill"){ ?>Skills, Certifications, Associations, and Hobbies Information
											<?php } else {?>Note Information <?php } ?>
				</th>
            </tr>
            <?php if($ntype=="note") {?><tr>
                <th class="one">Private </th><td class="two"><input type="checkbox" value="1"<?php if(isset($record[notes_private]) && $record[notes_private]) echo ' checked="checked"'?> name="record[notes_private]"/></td>
            </tr><?php } ?>
			
			 <?php if($ntype=="exp") {?><tr>
                <th class="one">I currently work here</th><td class="two"><input type="checkbox" value="1"<?php if(isset($record[notes_private]) && $record[notes_private]) echo ' checked="checked"'?> name="record[notes_private]" id="notes_private" onchange="hide_record(this)"/></td>
            </tr><?php } ?>
            <?php if($ntype=="note" || $ntype=="exp" || $ntype=="skill" || $ntype=="docu") {?><tr>
                <th class="one"><?php if($ntype=="note"){ ?>Subject*<?php }else if($ntype=="exp" || $ntype=="skill" || $ntype=="docu") {?>Title<?php } ?></th><td class="two"><input type="text" value="<?php if(isset($record[notes_title])) echo form_prep($record[notes_title])?>" name="record[notes_title]" id="notes_title" /></td>
            </tr> <?php } ?>
			<?php if($ntype=="docu") {?><tr>
				<th class="one">Upload(Image|Doc|Excel|Pdf)</th><td class="two"><input type="file" name="upload" /></td>
			</tr><?php } ?>
			<?php if($ntype=="exp") {?><tr>
                <th class="one">Company</th><td class="two"><input type="text" value="<?php if(isset($record[notes_company])) echo form_prep($record[notes_company])?>" name="record[notes_company]" id="notes_company" /></td>
            </tr>
			<tr>
                <th class="one">Location</th><td class="two"><input type="text" value="<?php if(isset($record[notes_location])) echo form_prep($record[notes_location])?>" name="record[notes_location]" id="notes_location" /></td>
            </tr><?php } ?>
			<?php if($ntype=="edu") {?><tr>
                <th class="one">School</th><td class="two"><input type="text" value="<?php if(isset($record[notes_school])) echo form_prep($record[notes_school])?>" name="record[notes_school]" id="notes_school" /></td>
            </tr>
			<tr>
                <th class="one">Degree</th><td class="two"><input type="text" value="<?php if(isset($record[notes_degree])) echo form_prep($record[notes_degree])?>" name="record[notes_degree]" id="notes_degree" /></td>
            </tr>
			<tr>
                <th class="one">Field Of Study</th><td class="two"><input type="text" value="<?php if(isset($record[notes_field])) echo form_prep($record[notes_field])?>" name="record[notes_field]" id="notes_field" /></td>
            </tr>
			<tr>
                <th class="one">Grade</th><td class="two"><input type="text" value="<?php if(isset($record[notes_grade])) echo form_prep($record[notes_grade])?>" name="record[notes_grade]" id="notes_grade" /></td>
            </tr>
			<tr style="border-bottom:0px;">
                <th class="one">Activities And Societies</th><td class="two"><textarea name="record[notes_activity]" style="height:250px;"><?php if(isset($record[notes_activity])) echo $record[notes_activity]?></textarea></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr><?php } ?>
			<?php if($ntype=="exp") {?><tr><th class="one">From</th>
                <td class="two"><select name="record[notes_fmonth]">
										<option value="">Month</option>
										<option value="jan" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="jan") echo 'selected = "selecetd"' ; ?>>Jan</option>
										<option value="feb" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="feb") echo 'selected = "selecetd"' ; ?>>Feb</option>
										<option value="mar" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="mar") echo 'selected = "selecetd"' ; ?>>Mar</option>
										<option value="jun" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="jun") echo 'selected = "selecetd"' ; ?>>Jun</option>
										<option value="jul" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="jul") echo 'selected = "selecetd"' ; ?>>Jul</option>
										<option value="aug" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="aug") echo 'selected = "selecetd"' ; ?>>Aug</option>
										<option value="sep" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="sep") echo 'selected = "selecetd"' ; ?>>Sep</option>
										<option value="oct" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="oct") echo 'selected = "selecetd"' ; ?>>Oct</option>
										<option value="nov" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="nov") echo 'selected = "selecetd"' ; ?>>Nov</option>
										<option value="dec" <?php if(isset($record[notes_fmonth])&& $record[notes_fmonth]=="dec") echo 'selected = "selecetd"' ; ?>>Dec</option>
								</select>
								 <select name="record[notes_fyear]">
									<option value="">Year</option>
									 <?php for($i=1950;$i<=2017;$i++) {?>
									 <option value="<?php echo $i; ?>" <?php if(isset($record[notes_fyear])&& $record[notes_fyear]==$i) echo 'selected = "selecetd"' ; ?> ><?php echo $i; ?></option>
									 <?php } ?>
								</select></td></tr>
				<tr id="tomonth"><th class="one">To</th>
				<td class="two"><select name="record[notes_tmonth]">
									<option value="">Month</option>
									<option value="jan" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="jan") echo 'selected = "selecetd"' ; ?>>Jan</option>
									<option value="feb" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="feb") echo 'selected = "selecetd"' ; ?>>Feb</option>
									<option value="mar" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="mar") echo 'selected = "selecetd"' ; ?>>Mar</option>
									<option value="jun" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="jun") echo 'selected = "selecetd"' ; ?>>Jun</option>
									<option value="jul" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="jul") echo 'selected = "selecetd"' ; ?>>Jul</option>
									<option value="aug" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="aug") echo 'selected = "selecetd"' ; ?>>Aug</option>
									<option value="sep" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="sep") echo 'selected = "selecetd"' ; ?>>Sep</option>
									<option value="oct" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="oct") echo 'selected = "selecetd"' ; ?>>Oct</option>
									<option value="nov" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="nov") echo 'selected = "selecetd"' ; ?>>Nov</option>
									<option value="dec" <?php if(isset($record[notes_tmonth])&& $record[notes_tmonth]=="dec") echo 'selected = "selecetd"' ; ?>>Dec</option>
								</select>
								<select name="record[notes_tyear]">
									<option value="">Year</option>
									<?php for($i=1950;$i<=2017;$i++) {?>
									 <option value="<?php echo $i; ?>" <?php if(isset($record[notes_tyear])&& $record[notes_tyear]==$i) echo 'selected = "selecetd"' ; ?>><?php echo $i; ?></option>
									 <?php } ?>
							    </select></td>
								
            </tr>
			<?php } ?>
			<?php if($ntype=="edu" || $ntype=="skill") {?><tr><th class="one">From</th>
                <td class="two"><select name="record[notes_fyear]">
									<option value="">Year</option>
									 <?php for($i=1950;$i<=2017;$i++) {?>
									 <option value="<?php echo $i; ?>" <?php if(isset($record[notes_fyear])&& $record[notes_fyear]==$i) echo 'selected = "selecetd"' ; ?> ><?php echo $i; ?></option>
									 <?php } ?>
								</select></td></tr>
				<tr><th class="one">To</th>				
				<td class="two"><select name="record[notes_tyear]">
									<option value="">Year</option>
									<?php for($i=1950;$i<=2017;$i++) {?>
									 <option value="<?php echo $i; ?>" <?php if(isset($record[notes_tyear])&& $record[notes_tyear]==$i) echo 'selected = "selecetd"' ; ?>><?php echo $i; ?></option>
									 <?php } ?>
							    </select></td>
            </tr><?php } ?>
            <?php if($ntype=="note" || $ntype=="exp" || $ntype=="edu" || $ntype=="skill" ){ ?><tr style="border-bottom:0px;">
                <th class="one"><?php if($ntype=="note"){ ?>Body<?php }else if($ntype=="exp" ||$ntype=="edu"|| $ntype=="skill" ) {?>Description<?php } ?></th><td class="two"><textarea name="record[notes_info]" style="height:250px;"><?php if(isset($record[notes_info])) echo $record[notes_info]?></textarea></td><th class="one">&nbsp;</th><td class="two">&nbsp;</td>
            </tr><?php } ?>
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
			alert("Subject required");
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