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
            <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>/view/<?php echo $record['sch_contact'];?>" class="buttonM bBlack">Back</a>
            <a href="<?php echo base_url();?>crm/emails/delete/<?php echo $record[sch_id]?>" onclick="if(!confirm('Are you sure you want to delete this email?')) return false;" class="buttonM bBlack">Delete</a>   
        </div>
		<!-- Main content -->
		<table cellpadding="0" cellspacing="0" border="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" align="center" class="contact-list view"> 
            <tbody>
                <tr>
                	<th class="one" style="width:5%;">Title</th><td class="two"><?php echo $record[sch_subject]?></td>
                </tr>
                <tr>
                	<th class="one" style="width:5%;">Email Template</th><td class="two"><?php echo $record[sch_etname]?></td>
                </tr>
                <tr>
                	<th class="one" style="width:5%;">Body</th><td class="two"><?php $task_content_nonhtml=strip_tags($record[sch_content]);
					if(strlen($task_content_nonhtml)<strlen($record[sch_content])) echo $record[sch_content];
					else echo str_replace("\n","<br>",$record[sch_content])?></td>
                </tr>
                <tr>
                	<th class="one" style="width:5%;">Date</th><td class="two"><?php echo date("m/d/Y h:i A",strtotime($record[sch_date])+date("Z"))?></td>
                </tr>
                <?php 
					$sch_date = date("Y-m-d H:i:s",strtotime($record[sch_date])+date("Z"));
					if(time()>strtotime($sch_date) && $record[sch_status]) {?>
                <tr>
                	<th class="one" style="width:5%;">Status</th><td class="two" style="color:#FF0000;"><?php echo $record[sch_status]?></td>
                </tr>    
                <?php }?>
            </tbody>
        </table>    
            
	</div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
