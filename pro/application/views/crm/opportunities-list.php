<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style type="text/css">
	#DataTables_Table_0_filter
	{
		display:none;
	}
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
			width:50px !important;
			text-align:center !important;
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
        	<div class="title-bar" style="margin-bottom:20px;">
                <?php /*?><a href="<?php echo base_url(); ?>crm/opportunities" class="buttonM bBlack">My Opportunities</a> 
                <a href="<?php echo base_url(); ?>crm/opportunities/all" class="buttonM bBlack">All Opportunities</a> <?php */?>
				<a href="<?php echo base_url(); ?>crm/opportunities/edit" class="buttonM bBlack">Add New</a> 
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a> 
				 <?php if(isset($eScripter) && $eScripter){?>
                <select onchange="dashboard_statistics()" id="ausers">    
                    <option value="All">All Users</option>
                    <?php foreach($shared_users as $ushared){?>
                    <option value="<?php echo $ushared->user_id;?>" <?php if($ushared->user_id==$_GET['user_id']) echo "selected='selected'"; ?>><?php echo ucfirst($ushared->usrname);?></option>
                    <?php } ?>
                </select> 
				<select onchange="dashboard_statistics()" id="stage">    
                    <option value="All">All Stages</option>
                    <?php foreach($stage as $aval){?>
                    <option value="<?php echo $aval;?>"<?php if($aval==$_GET['sid']) echo ' selected="selected"'?>><?php echo $aval;?></option>
                 <?php }?>
                </select> 
                <?php } ?>
            </div>	
            <form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="deleteall" />
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
                <thead>
                <tr>
                	<th class='no-border' style="width:20px; text-align:center;"><?php if(!isset($listall)){?><input type="checkbox" id="selectall" /><?php }?></th>
                    <th class='no-border large'>Opportunity Name</th>
                    <th class='no-border medium'>Contact</th>
                    <th class='no-border medium'>Account Name</th>
                    <th class='no-border small'>Close Date</th>
                    <th class='no-border small'>Amount</th>
                    <th class='no-border small'>Stage</th>
                    <th class='no-border small'>Probability</th>
                    <th class='no-border small'>Quality Points</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($opportunities as $crow)    {?>
                <tr>
                	<td class='no-border' style="text-align:center;"><input type="checkbox" value="<?php echo $crow->oppt_id;?>" name="recids[]" class="rcselect" /></td>
                    <td class='no-border' style="text-align:left;"><a href="<?php echo base_url(); ?>crm/opportunities/view/<?php echo $crow->oppt_id;?>"><?php echo $crow->oppt_name;?></a></td>
                    <td class='no-border' style="text-align:center;"><?php if($crow->contact_id){?><a href="<?php echo base_url('crm/contacts/view').'/'.$crow->contact_id; ?>"><?php echo ucfirst($crow->user_first.' '.$crow->user_last);?></a><?php }?></td>
                    <td class='no-border' style="text-align:center;"><?php if($crow->account_id){?><a href="<?php echo base_url('crm/accounts/view').'/'.$crow->account_id; ?>"><?php echo ucfirst($crow->account_title);?></a><?php }?></td>
                    <td class='no-border' style="text-align:center; color:#000000 !important;"><?php if((int)$crow->close_date) echo date("m/d/Y",strtotime($crow->close_date));?></td>
                    <td class='no-border' style="text-align:center; color:#000000 !important;"><?php if($crow->amount) echo '$'.number_format($crow->amount);?></td>
                    <td class='no-border' style="text-align:center; color:#000000 !important;"><?php echo $crow->stage;?></td>
                    <td class='no-border' style="text-align:center; color:#000000 !important;"><?php if($crow->probability) echo $crow->probability.'%';?></td>
                    <td class='no-border' style="text-align:center; color:#000000 !important;"><?php if($crow->qpointst) echo $crow->qpointst;?></td>
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
            "bJQueryUI": true,
            "bAutoWidth": false,
            "iDisplayLength": 50,
			"lengthChange": false,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"fl>t<"F"ip>',
            language: {
                searchPlaceholder: "Find Record"
            },
            "deferRender": true,
            "bSort": false,
        });
	});
	
	function dashboard_statistics(dis) {
		var uid = $("#ausers").val();
		var sid = $("#stage").val();
		if(uid=='All' && sid=='All')
		location.replace("<?php echo base_url('crm/opportunities');?>");
		else if(uid=='All' && sid!='All')
        location.replace("<?php echo base_url('crm/opp_statistics');?>?sid="+sid);
		else if(uid!='All' && sid=='All')
        location.replace("<?php echo base_url('crm/opp_statistics');?>?user_id="+uid);
		else
		location.replace("<?php echo base_url('crm/opp_statistics');?>?user_id="+uid+"&sid="+sid);		
    }
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
