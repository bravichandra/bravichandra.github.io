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
    <div class="main-wrapper">    	
		<!-- Main content -->
        <div class="crmlite">        
            <div class="title-bar"><a href="<?php echo base_url(); ?>crm/<?php echo $parent_section;?>/view/<?php echo $parent_id;?>" class="buttonM bRed">Back</a></div>
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>
                <thead>
                    <tr>                        
                        <th class='no-border'>Subject</th>
                        <th class='no-border'>Email Template</th>
                        <th class='no-border'>Record Owner</th>
                        
                        
                        <th class='no-border'>Date Scheduled</th>
                        <th class='no-border'>Action</th>
                    </tr> 
                </thead>
                <tbody>
                	<?php foreach($emails_list as $crow)    {?> 
                    <tr>
                        <td class='no-border'><a href="<?php echo base_url(); ?>crm/emails/view/<?php echo $crow->sch_id;?>"><?php echo $crow->sch_subject;?></a></td>
                        <td class='no-border'><?php echo $crow->sch_etname;?></td>
						<td class='no-border'><?php echo ucfirst($crow->usrname);?></td>
            			<td class='no-border'><?php echo date("m/d/Y h:i A",strtotime($crow->sch_date)+date("Z"))?></td>                        
                        <td class='no-border'><a href="<?php echo base_url(); ?>crm/emails/delete/<?php echo $crow->sch_id;?>" onclick="if(!confirm('Are you sure you want to delete this email?')) return false;">Delete</a></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
	</div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
