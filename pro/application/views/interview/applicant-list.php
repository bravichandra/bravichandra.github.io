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
            <div class="title-bar" style="width: 900px;"> 
			<?php 
				if($atype<>2){
				if($ivs=='employee') {?>           	
                <a href="<?php echo base_url(); ?>interviewer/employee/all" class="buttonM bBlack">All Employees</a>                 
                <a href="<?php echo base_url(); ?>interviewer/employee/my" class="buttonM bBlack">My Employees</a> 
                <a href="<?php echo base_url(); ?>interviewer/employee" class="buttonM bBlack">Target Employees</a>
				<a href="<?php echo base_url(); ?>interviewer/employee/edit" class="buttonM bBlack">Add New</a>
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a>
			<?php } else {?>
				<a href="<?php echo base_url(); ?>interviewer/applicant/all" class="buttonM bBlack">All Applicants</a>                 
                <a href="<?php echo base_url(); ?>interviewer/applicant/my" class="buttonM bBlack">My Applicants</a> 
                <a href="<?php echo base_url(); ?>interviewer/applicant" class="buttonM bBlack">Target Applicants</a>
				<a href="<?php echo base_url(); ?>interviewer/applicant/edit" class="buttonM bBlack">Add New</a> 
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a>
			<?php }} ?>
            <?php if($atype==2){?>
            <b>These are SalesScripter users that have applied for jobs and are available to be contacted and hired by any other SalesScripter user.</b>
            <?php }?>
            </div>
			<form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="deleteall" />
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
                <thead>
                    <tr>
						<!--<th class='no-border' style="width:30px;text-align:center"><?php if(!isset($listall)){?><input type="checkbox" id="selectall" /><?php }?></th>-->
                        <th class='no-border' style="width:100px;text-align:center">Name</th>
                        <th class='no-border' style="width:100px;text-align:center">Phone</th>
						<th class='no-border' style="width:100px;text-align:center">Mobile</th>
                        <th class='no-border' style="width:150px;text-align:center">Email</th>
                        <?php if($ivs=='applicant') {?>
                        <th class='no-border' style="width:100px;text-align:center">Job</th>
                        <th class='no-border' style="width:100px;text-align:center">Pay Rate</th>
                        <th class='no-border' style="width:100px;text-align:center">Stage</th>                        
                        <?php }else{?>
                        <th class='no-border' style="width:50px;text-align:center">Pay Rate</th>
                        <?php }?>
                        <?php if($atype==2){?>
                          <th class='no-border' style="width:50px;text-align:center">Projects w/ SalesScripter</th>
                          <th class='no-border' style="width:50px;text-align:center">Months w/ SalesScripter</th>
                        <?php }?>
                           <th class='no-border' style="text-align:center; width:50px;">Modified</th>
                    </tr>
                </thead>
                <tbody style="text-align: center;">
                	<?php foreach($contacts as $crow)    {
					?>
                    <tr>
						<!--<td class='no-border'><input type="checkbox" value="<?php echo $crow->contact_id;?>" name="recids[]" class="rcselect" /></td>-->
                        <td class='no-border'>
                        <?php if($atype==2){?>
                        <a href="<?php echo base_url(); ?>interviewer/laborpool/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a>
                        <?php } else {?>
                        <a href="<?php echo base_url(); ?>interviewer/<?php echo ($ivs=='employee'?'employee':'applicant');?>/view/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a>
                        <?php }?>
                        </td>
                        <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>
						<td class='no-border'><?php if($crow->mobile) echo '<a href="tel:'.$crow->mobile.'">'.$crow->mobile.'</a>';?></td>
                        <td class='no-border'><?php if($crow->email) echo '<a href="mailto:'.$crow->email.'">'.$crow->email.'</a>';?></td>
                        <?php if($ivs=='applicant') {?>
                        <td class='no-border'><?php echo $crow->job_applied_for?></td>
                        <td class='no-border'><?php echo ($crow->pay_rate>0?'$'.number_format($crow->pay_rate,2):'')?></td>
                        <td class='no-border'><?php echo $crow->stage?></td>                        
                        <?php }else{?>
                        <td class='no-border'><?php echo ($crow->pay_rate>0?'$'.number_format($crow->pay_rate,2):'')?></td>
                        <?php }?>
                        
                        <?php if($atype==2){?>
                        <td class='no-border'><?php echo ($crow->sstrained?$crow->sstrained:'')?></td>
                        <td class='no-border'><?php echo ($crow->sstrained2?$crow->sstrained2:'')?></td>
                        <?php }?>
                        <td class='no-border'><?php echo date("m/d/Y",strtotime($crow->modify_date))?></td>
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
        $('.dtskTable').dataTable({
            /* Disable initial sort */
            "aaSorting": [],
            "iDisplayLength": 50,
            language: {
                searchPlaceholder: "Find Record"
            },
        });
		//oTable.fnSort( [ [1,'asc'] ] );
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
