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
			<form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="deleteall" />
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>
                <thead>
                    <tr>
						<th class='no-border' style="width:30px;"><?php if(!isset($listall)){?><input type="checkbox" id="selectall" /><?php }?></th>
                        <th class='no-border'>Job Title</th>
                        <th class='no-border'>Location</th>
                        <th class='no-border'>Play Rate</th>
						<th class='no-border'>Modified</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($jobs as $jrow)    {
					?>
                    <tr>
						<td class='no-border'><input type="checkbox" value="<?php echo $jrow->post_id;?>" name="recids[]" class="rcselect" /></td>
                        <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/jobs/view/<?php echo $jrow->post_id;?>"><?php echo $jrow->job_title;?></a></td>
                        <td class='no-border'><?php echo $jrow->location;?></td>
                        <td class='no-border'><?php echo $jrow->playrate;?></td>
						<td class='no-border'><?php  echo $new = date("m/d/Y", strtotime($jrow->modify_date)); ?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
			</form>
        </div>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#selectall").change(function(){
			$(".rcselect").prop("checked",$(this).prop("checked"));
		});	
		$(".delete").click(function(){
			if($(".rcselect:checked").length==0) {
				alert("Select records");
				return false;
			}
			if(!confirm('Are you sure you want to delete these records?')) return false;
			$("#frmlist").submit();
		});
		//oTable.fnSort( [ [1,'asc'] ] );
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
