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
    <div class="main-wrapper crmlite">
    	<div class="crm-menu">
            <a href="<?php echo base_url();?>interviewer/<?php echo ($atype==2?'yourprofile':$parent_section.'/view/'.$record['notes_parentid']);?>" class="buttonM bBlack">Back</a>
            <a href="<?php echo base_url();?>interviewer/notes/<?php echo $ntype;?>/edit/<?php echo $record[notes_id]?>" class="buttonM bBlack">Edit</a> 
            <a href="<?php echo base_url();?>interviewer/notes/<?php echo $ntype;?>/delete/<?php echo $record[notes_id]?>" onclick="if(!confirm('Are you sure you want to delete this notes?')) return false;" class="buttonM bBlack">Delete</a>
        </div>
            
		<!-- Main content -->
		<table cellpadding="0" cellspacing="0" border="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" align="center" class="contact-list view">
            <tbody>
            	<tr>
                	<th class="one">Note Owner</th><td class="two" colspan="4"><?php 
					$sUser = $this->applicant->get_CurrentUser($record['notes_user']);
					if($sUser) echo ucfirst($sUser[0]->usrname);?></td>
                </tr>
            	<tr>
                	<th class="one">Related To</th><td class="two" colspan="4">
                    <?php if($parent_name) {?>
                    <a href="<?php echo base_url();?>interviewer/<?php echo $parent_section."/view/".$record['notes_parentid'];?>"><?php echo $parent_name;?></a>
                    <?php }?>
                    </td>
                </tr>
               <?php if($ntype=="note" || $ntype=="exp" ) { ?> <tr>
                	<th class="one"><?php if($ntype=="note") {?>Private <?php } else {?>I currently work here<?php } ?></th><td class="two" colspan="4"><input type="checkbox" disabled="disabled" <?php if($record[notes_private]) echo ' checked="checked"'?> /></td>
                </tr><?php  } ?>
                 <?php if($ntype=="note" || $ntype=="exp" || $ntype=="skill") {?><tr>
                	<th class="one"><?php if($ntype=="note"){ ?>Subject*<?php }else if($ntype=="exp" || $ntype=="skill") {?>Title<?php } ?></th><td class="two" colspan="4"><?php echo $record[notes_title]?></td>
                </tr><?php } ?>
				
				<?php if($ntype=="exp") {?> <tr>
                	<th class="one">Company</th><td class="two" colspan="4"><?php echo  $record[notes_company]; ?></td>
                </tr>
				<tr>
                	<th class="one">Location</th><td class="two" colspan="4"><?php echo  $record[notes_location]; ?></td>
                </tr>
				<?php } ?>
			<?php if($ntype=="edu") {?>
				<tr>
                	<th class="one">School</th><td class="two" colspan="4"><?php echo  $record[notes_school]; ?></td>
                </tr>
				<tr>
                	<th class="one">Degree</th><td class="two" colspan="4"><?php echo  $record[notes_degree]; ?></td>
                </tr>
				<tr>
                	<th class="one">Field Of Study</th><td class="two" colspan="4"><?php echo  $record[notes_field]; ?></td>
                </tr>
				<tr>
                	<th class="one">Grade</th><td class="two" colspan="4"><?php echo  $record[notes_grade]; ?></td>
                </tr>
				<tr>
                	<th class="one">Activities And Societies</th><td class="two" colspan="4"><?php echo  str_replace("\n","<br>",$record[notes_activity]); ?></td>
                </tr><?php } ?>
			<?php if($ntype=="exp") {?>    
                <tr>
                    <th class="one">From</th><td class="two" ><?php echo  $record[notes_fmonth].' '.$record[notes_fyear]; ?></td><td class="gap"></td>
                    <th class="one">To</th><td class="two" ><?php echo ($record[notes_tyear]?'Present':$record[notes_tmonth].' '.$record[notes_tyear]); ?></td>
                </tr>
            <?php }?>
            <?php if($ntype=="skill" || $ntype=="edu") {?>
                <tr>
                    <th class="one">From</th><td class="two" ><?php echo  $record[notes_fyear]; ?></td><td class="gap"></td>
                    <th class="one">To</th><td class="two" ><?php echo  $record[notes_tyear]; ?></td>
                </tr><?php } ?>
            <?php if($ntype=="note" || $ntype=="exp" || $ntype=="edu" ||$ntype=="skill" ){ ?>
                <tr>
                	<th class="one"><?php if($ntype=="note"){ ?>Body<?php }else if($ntype=="exp" ||$ntype=="edu" ||$ntype=="skill" ) {?>Description<?php } ?></th><td class="two" colspan="4"><?php echo str_replace("\n","<br>",$record[notes_info])?></td>
                </tr><?php } ?>
                <tr>
                	<th class="one">Created</th><td class="two"><?php echo date("m/d/Y",strtotime($record[notes_created]))?></td><td class="gap"></td>
                    <th class="one">Last Modified</th><td class="two"><?php echo date("m/d/Y",strtotime($record[notes_modify]))?></td>
                </tr>
                
            </tbody>
        </table>    
            
	</div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
