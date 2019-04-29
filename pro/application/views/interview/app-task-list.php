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
    	<div class="crmlite">
			<div class="title-bar">
				<a href="<?php echo base_url(); ?>interviewer/tasks/edit" class="buttonM bBlack">Add New</a> 
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a> 
				<?php if($parent_id){?>
				<a href="<?php echo base_url(); ?>interviewer/<?php echo $parent_section;?>/view/<?php echo $parent_id;?>" class="buttonM bRed">Back</a>
				<?php }?>
            </div> 
            <form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="deleteall" />           
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
                <thead>
                    <tr>  
                    	<th class='no-border'><input type="checkbox" id="selectall" /></th>
                        <?php /*?><th class='no-border'>Action</th><?php */?>
                        <th class='no-border'>Subject</th>
                        <?php if($parent_section=="applicant"){?>
                        <th class='no-border'>Email Template</th>
                        <?php }?>
            			<?php /*?><th class='no-border'>Record Owner</th><?php */?>
						<th class='no-border'>Contact</th>
                        <th class='no-border'>Account</th>
                        <th class='no-border'>Phone</th>
                        <th class='no-border'>Due Date</th>                        
                        <th class='no-border'>Priority</th>
						<th class='no-border'>Quality Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
						$output ="";
						$output_top ="";
						$cDt = date("Y-m-d");
						foreach($tasks_list as $crow){
						$parent_name ='';
						$contact_name ='';
						$contact_id ='';
						$account_name ='';
						$account_id ='';
						$phone ='';
						if($crow->task_related=='C') {
							$parent_record =$this->applicant->get_notes_parent($crow->task_relatedto,'C');
							if($parent_record) {
								$contact_id =$crow->task_relatedto;
								$contact_name=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);
								$phone=$parent_record['phone'];
								if($parent_record['account_id']) {
									$parent_record =$this->applicant->get_notes_parent($parent_record['account_id'],'A');
									if($parent_record) {
										$account_id =$parent_record['account_id'];
										$account_name=ucfirst($parent_record['account_name']);
									}
								}
							}	
						} else if($crow->task_related=='A') {
							$parent_record =$this->applicant->get_notes_parent($crow->task_relatedto,'A');
							if($parent_record) {
								$account_id =$crow->task_relatedto;
								$account_name=ucfirst($parent_record['account_name']);
								$phone=$parent_record['phone'];
							}
						}
					?>
                    <tr>
                    	<td class='no-border'><input type="checkbox" value="<?php echo $crow->task_id;?>" name="recids[]" class="rcselect" /></td>
                        <?php /*?><td class='no-border'><a href="<?php echo base_url("crm/tasks/edit/".$crow->task_id);?>">Edit</a><?php */?>
						<?php /*?> | <a href="<?php echo base_url("crm/tasks/delete/".$crow->task_id);?>" onclick="if(!confirm('Are you sure you want to delete this task?')) return false;">Delete</a><?php */?></td>
                        <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
                        <?php if($parent_section=="applicant"){?>
                        <td class='no-border'><?php echo ucfirst($crow->task_name);?></td>
                        <?php }?>
                        <?php /*?><td class='no-border'><?php echo ucfirst($crow->usrname);?></td><?php */?>
						<?php /*?><td class='no-border'><a href="<?php echo base_url(); ?>crm/<?php echo ($crow->task_related=='A'?'accounts':'contacts');?>/view/<?php echo $crow->task_relatedto;?>"><?php echo $parent_name;?></a></td><?php */?>
                        <td class='no-border'>
						<?php if($contact_id){?><a href="<?php echo base_url(); ?>interviewer/<?php echo 'applicant';?>/view/<?php echo $contact_id;?>"><?php echo $contact_name;?></a><?php }?></td>
						<td class='no-border'><?php if($account_id){?><a href="<?php echo base_url(); ?>interviewer/<?php echo 'accounts';?>/view/<?php echo $account_id;?>"><?php echo $account_name;?></a><?php }?></td>
                        <?php /*?><td class='no-border'><?php echo ($crow->task_related=='A'?'Account':'Contact');?></td><?php */?>
                        <td class='no-border'><?php if($phone) echo '<a href="tel:'.$phone.'">'.$phone.'</a>';?></td>
						<td class='no-border'><?php if((int)$crow->task_duedate)echo date("m/d/Y",strtotime($crow->task_duedate))?></td>
                        <td class='no-border'><?php echo $crow->task_priority;?></td>
						<td class='no-border' style="text-align:center"><?php echo number_format($crow->qpoints);?></td>
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
		var oTaskTable = $('.dtskTable').dataTable({
			"bJQueryUI": false,
			"bAutoWidth": false,
			"iDisplayLength": 50,
			"sPaginationType": "full_numbers",
			"sDom": '<"H"fl>t<"F"ip>',
			//"bSort": false,
		});
		oTaskTable.fnSort( [ [<?php echo ($parent_section=="applicant"?6:5)?>,'asc'] ] );
		$("select").uniform();
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
