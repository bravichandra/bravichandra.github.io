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
            <div class="title-bar"><a href="<?php echo base_url(); ?>interviewer/<?php echo $parent_section;?>/view/<?php echo $parent_id;?>" class="buttonM bRed">Back</a></div>
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>
                <thead>
                    <tr>                        
                        <th class='no-border'><?php if($ntype=="note" || $ntype=="skill" || $ntype=="exp") {?>Title<?php } else {?>School<?php } ?></th>
						<?php if($ntype=="edu" || $ntype=="exp") {?> <th class='no-border'><?php if($ntype=="edu"){ ?>Degree<?php } else if($ntype=="exp") { ?>Company<?php } ?></th><?php } ?>
			            <th class='no-border'><?php if($ntype=="note" ) { ?>Record Owner <?php } else {?>From <?php } ?></th>
                        <th class='no-border'><?php if($ntype=="note" ) { ?>Last Modified<?php } else {?>To <?php } ?></th>
                        <th class='no-border'>Action</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($notes as $crow)    {?>
                    <tr>
                        <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/notes/<?php echo $ntype;?>/view/<?php echo $crow->notes_id;?>"><?php if($ntype=="note" || $ntype=="skill" || $ntype=="exp")  { echo $crow->notes_title;} else{ echo $crow->notes_school; }?></a></td>
						<?php if($ntype=="edu" || $ntype=="exp") {?> <td class='no-border'><?php if($ntype=="exp") { echo $crow->notes_company; } else { echo $crow->notes_degree; } ?></td><?php } ?>
						
            			<td class='no-border'><?php if($ntype=="note"){ echo ucfirst($crow->usrname); } else { echo $crow->notes_fyear; }?></td>                        
                        <td class='no-border'><?php if($ntype=="note"){ echo date("m/d/Y",strtotime($crow->notes_modify)); } else if($ntype=='exp' && $crow->notes_private) echo 'Present'; else echo $crow->notes_tyear; ?></td>
                        <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/notes/<?php echo $ntype;?>/edit/<?php echo $crow->notes_id;?>">Edit</a> | <a href="<?php echo base_url(); ?>interviewer/notes/<?php echo $ntype;?>/delete/<?php echo $crow->notes_id;?>" onclick="if(!confirm('Are you sure you want to delete this record?')) return false;">Delete</a></td>
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
