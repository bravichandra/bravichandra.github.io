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
            <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>/view/<?php echo $record['notes_parentid'];?>" class="buttonM bBlack">Back</a>
            <a href="<?php echo base_url();?>crm/notes/edit/<?php echo $record[notes_id]?>" class="buttonM bBlack">Edit</a> 
            <a href="<?php echo base_url();?>crm/notes/delete/<?php echo $record[notes_id]?>" onclick="if(!confirm('Are you sure you want to delete this notes?')) return false;" class="buttonM bBlack">Delete</a>   
        </div>
		<!-- Main content -->
		<table cellpadding="0" cellspacing="0" border="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" align="center" class="contact-list view">
            <tbody>
            	<tr>
                	<th class="one">Note Owner</th><td class="two" colspan="4"><?php 
					$sUser = $this->crm->get_CurrentUser($record['notes_user']);
					if($sUser) echo ucfirst($sUser[0]->usrname);?></td>
                </tr>
            	<tr>
                	<th class="one">Related To</th><td class="two" colspan="4">
                    <?php if($parent_name) {?>
                    <a href="<?php echo base_url();?>crm/<?php echo $parent_section."/view/".$record['notes_parentid'];?>"><?php echo $parent_name;?></a>
                    <?php }?>
                    </td>
                </tr>
                <tr>
                	<th class="one">Private</th><td class="two" colspan="4"><input type="checkbox" disabled="disabled" <?php if($record[notes_private]) echo ' checked="checked"'?> /></td>
                </tr>
                <tr>
                	<th class="one">Title</th><td class="two" colspan="4"><?php echo $record[notes_title]?></td>
                </tr>
                <tr>
                	<th class="one">Body</th><td class="two" colspan="4"><?php echo str_replace("\n","<br>",$record[notes_info])?></td>
                </tr>
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
