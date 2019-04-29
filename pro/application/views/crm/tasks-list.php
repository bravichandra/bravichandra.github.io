<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style type="text/css">
	.large
		{
			width:200px !important;
			text-align:center !important;
		}
		.medium
		{
			width:100px !important;
			text-align:center !important;
		}
		.small
		{
			width:70px !important;
			text-align:center !important;
		}
		.crmlite th
		{
			text-align:center;
		}
	
</style>
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
				<a href="<?php echo base_url(); ?>crm/tasks/edit" class="buttonM bBlack">Add New</a> 
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a> 
				<?php if($parent_id){?>
				<a href="<?php echo base_url(); ?>crm/<?php echo $parent_section;?>/view/<?php echo $parent_id;?>" class="buttonM bRed">Back</a>
				<?php }?>
				<span class="loader"></span>
            </div> 
            <form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="deleteall" />           
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
                <thead>
                    <tr>  
                    	<th class='no-border' style="width:20px; text-align:center;"><input type="checkbox" id="selectall" /></th>
                        <?php /*?><th class='no-border'>Action</th><?php */?>
                       <?php if($parent_id){?>
                        <th class='no-border' width="200px">Type</th>
                        <th class='no-border'>Details</th>
                        <th class='no-border' width="150px">Date Modified</th>
                        <?php }else{?>
                        <th class='no-border large'>Subject</th>
                        <?php if($parent_section=="contacts"){?>
                        <th class='no-border'>Email Template</th>
                        <?php }?>
            			<?php /*?><th class='no-border'>Record Owner</th><?php */?>
						<th class='no-border medium'>Contact</th>
                        <th class='no-border medium'>Account</th>
                        <th class='no-border small'>Phone</th>
                        <th class='no-border small'>Due Date</th>                        
                        <th class='no-border small'>Priority</th>
						<th class='no-border small'>Quality Points</th> 
						<?php }?>
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
						if(!$parent_id){
							if($crow->task_related=='C') {
								$parent_record =$this->crm->get_notes_parent($crow->task_relatedto,'C');
								if($parent_record) {
									$contact_id =$crow->task_relatedto;
									$contact_name=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);
									$phone=$parent_record['phone'];
									if($parent_record['account_id']) {
										$parent_record =$this->crm->get_notes_parent($parent_record['account_id'],'A');
										if($parent_record) {
											$account_id =$parent_record['account_id'];
											$account_name=ucfirst($parent_record['account_name']);
										}
									}
								}	
							} else if($crow->task_related=='A') {
								$parent_record =$this->crm->get_notes_parent($crow->task_relatedto,'A');
								if($parent_record) {
									$account_id =$crow->task_relatedto;
									$account_name=ucfirst($parent_record['account_name']);
									$phone=$parent_record['phone'];
								}
							}
						}
					?>
                    <tr>
                    	<td class='no-border' style="text-align:center;"><input type="checkbox" value="<?php echo $crow->task_id;?>" name="recids[]" class="rcselect" /></td>
                        <?php /*?><td class='no-border'><a href="<?php echo base_url("crm/tasks/edit/".$crow->task_id);?>">Edit</a><?php */?>
						<?php /*?> | <a href="<?php echo base_url("crm/tasks/delete/".$crow->task_id);?>" onclick="if(!confirm('Are you sure you want to delete this task?')) return false;">Delete</a><?php */?></td>
						<?php if($parent_id){?>
						<td class='no-border'><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
						<td class='no-border'  style="text-align:center;color:#000000 !important;;"><?php echo ucfirst($crow->task_name);?></td>
						<td class='no-border'  style="text-align:center;color:#000000 !important;;"><?php echo date("m/d/Y",strtotime($crow->task_modified))?></td>
						<?php }else{?>
                        <td class='no-border' style="text-align:center;"><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
                        <?php if($parent_section=="contacts"){?>
                        <td class='no-border'  style="text-align:center;color:#000000 !important;"><?php echo ucfirst($crow->task_name);?></td>
                        <?php }?>
                        <?php /*?><td class='no-border'><?php echo ucfirst($crow->usrname);?></td><?php */?>
                        <?php /*?><td class='no-border'><a href="<?php echo base_url(); ?>crm/<?php echo ($crow->task_related=='A'?'accounts':'contacts');?>/view/<?php echo $crow->task_relatedto;?>"><?php echo $parent_name;?></a></td><?php */?>
                        <td class='no-border' style="text-align:center;">
						<?php if($contact_id){?><a href="<?php echo base_url(); ?>crm/<?php echo 'contacts';?>/view/<?php echo $contact_id;?>"><?php echo $contact_name;?></a><?php }?></td>
						<td class='no-border'><?php if($account_id){?><a href="<?php echo base_url(); ?>crm/<?php echo 'accounts';?>/view/<?php echo $account_id;?>"><?php echo $account_name;?></a><?php }?></td>
                        <td class='no-border'  style="text-align:center;color:#000000 !important;"><?php if($phone) echo '<a href="tel:'.$phone.'">'.$phone.'</a>';?></td>
						<td class='no-border'  style="text-align:center;color:#000000 !important;"><?php if((int)$crow->task_duedate)echo date("m/d/Y",strtotime($crow->task_duedate))?></td>
                        <td class='no-border'  style="text-align:center;color:#000000 !important;"><?php echo $crow->task_priority;?></td>
                        <td class='no-border' style="text-align:center;color:#000000 !important;"><?php echo number_format($crow->qpoints);?></td>
                        <?php }?>
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
			//delete tasks by ajax
			deleteTasks();
			//$("#frmlist").submit();
		});
		var oTaskTable = $('.dtskTable').dataTable({
			"bJQueryUI": false,
			"bAutoWidth": false,
			"iDisplayLength": 50,
			language: {
		        searchPlaceholder: "Find Record"
		    },
			"sPaginationType": "full_numbers",
			"sDom": '<"H"fl>t<"F"ip>',
			//"bSort": false,
		});
		//oTaskTable.fnSort( [ [<?php echo ($parent_section=="contacts"?6:5)?>,'asc'] ] );
		$("select").uniform();
	});

	var ajrequest;
    var ajtimer;
	function deleteTasks() {
		//delete tasks by ajax
		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" /> Please wait.');

        ajrequest = $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/deleteTasks');?>",
          cache: false,
          dataType: 'json',
          data: $('#frmlist').serialize()
            }).done(function( resp ) {
                $(".loader").html('');
                if(resp.status==true) {
                	$(".loader").html(resp.msg);
                    if(resp.completed==1) {
                    	location.replace("<?php echo current_url();?>");
                    	return;
                    }
                    if(resp.rcount>0) {
                    	$("#done").val(resp.done);
                    	ajtimer = setTimeout(deleteTasks, 5000);
                    }
                }                
          })
          .fail(function() {
            $(".loader").html('');
            ajtimer = setTimeout(deleteTasks, 5000);
          });

	}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
