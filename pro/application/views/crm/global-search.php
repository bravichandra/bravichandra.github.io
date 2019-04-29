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
		<!-- Main content -->
		<div class="title-bar">            	
            <a href="<?php echo base_url(); ?>crm/contacts/edit" class="buttonM bBlack">Add New Contact</a>                 
            <a href="<?php echo base_url(); ?>crm/accounts/edit" class="buttonM bBlack">Add New Account</a> 
			<a href="<?php echo base_url(); ?>crm/search" class="buttonM bBlack">Advanced Search</a> 
        </div><br clear="all"><br clear="all">
		<div class="quatabs nopadding">
            <div<?php if($actab=='contacts') echo ' class="active"';?>><a href="javascript:void(0);" rel="box1">Contacts</a></div>
            <div<?php if($actab=='accounts') echo ' class="active"';?>><a href="javascript:void(0);" rel="box2">Accounts</a></div>
        </div>
        <?php if($esearch) {?>
        <div class="tabcontents">        	
        	<?php if($esearch && !$search_list) {?>
        	<br clear="all" /><div class="crm-error">No results found.</div>
        	<?php }else{?>	        	
        	<!-- CONTACTS -->
        	<div class="box1 tabbox"<?php if($actab!='contacts') echo ' style="display: none;"';?>>
        		<?php if(!isset($search_list['contacts'])) {?>
	        	<br clear="all" /><div class="crm-error">No contacts found.</div>
	        	<?php } else if($search_list['contacts']) {$cids1 = "";?>
        		<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>

		            <thead>

		                <tr>
		                    <?php /*<th style="width: 40px;"><input type="checkbox" id="selectallc" /></th>*/?>
		                    <th class='no-border'>Contact</th>

		                    <th class='no-border'>Account</th>

		                    <th class='no-border'>Record Owner</th>

		                    <th class='no-border' style="width:100px;">Phone</th>

		                    <th class='no-border'  style="width:140px;">Quality Points</th>

		                </tr>

		            </thead>

		            <tbody>

		                <?php foreach($search_list['contacts'] as $crow)    {
		                	$curid = "-$crow->contact_id-";
		                	if(strpos($cids1,$curid)!==FALSE) continue;
		                	$cids1 .= "-$crow->contact_id-";
		                	?>

		                <tr>
		                    <?php /*<td class='no-border'><input type="checkbox" value="<?php echo 'C-'.$crow->contact_id;?>" name="recids[]" class="rcselect" /></td>*/?>

		                    <td class='no-border'>

		                    <?php if(isset($crow->user_first)) {?>

		                    <a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a>

		                	<?php }?>    

		                    </td>

		                    <td class='no-border'>

		                    <?php if(isset($crow->account_id)) {?>

							<a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo $crow->account_name;?></a>

		                    <?php }?>

		                   	</td>

		                    <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>

		                    <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>

		                    <td class='no-border'><?php echo $crow->qpoints;?></td>

		                </tr>

		                <?php }?>

		            </tbody>

		        </table>
		        <?php }?>
        	</div>        	

        	<!-- ACCOUNTS -->
        	<div class="box2 tabbox"<?php if($actab!='accounts') echo ' style="display: none;"';?>>
        		<?php if(!isset($search_list['accounts'])) {?>
	        	<br clear="all" /><div class="crm-error">No accounts found.</div>
	        	<?php } else if($search_list['accounts']) {$cids2 = "";?>
	        	<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%;' class='tDefault dTable'>

		            <thead>

		                <tr>
		                    <?php /*<th style="width: 40px;"><input type="checkbox" id="selectalla" /></th>*/?>
		                    <th class='no-border'>Account</th>
		                    <th class='no-border'>Contact</th>

		                    <th class='no-border'>Record Owner</th>

		                    <th class='no-border' style="width:100px;">Phone</th>

		                    <th class='no-border'  style="width:140px;">Quality Points</th>

		                </tr>

		            </thead>

		            <tbody>

		                <?php foreach($search_list['accounts'] as $crow)    {
		                	$curid = "-$crow->account_id-";
		                	if(strpos($cids2,$curid)!==FALSE) continue;
		                	$cids2 .= "-$crow->account_id-";
		                	?>

		                <tr>
		                    <?php /*<td class='no-border'><input type="checkbox" value="<?php echo 'A-'.$crow->account_id;?>" name="recids[]" class="rcselect" /></td>*/?>

		                    <td class='no-border'>

		                    <?php if(isset($crow->account_id)) {?>

		                    <a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo $crow->account_name;?></a>

		                    <?php }?>

		                    </td>

		                    <td class='no-border'>

		                    <?php if(isset($crow->user_first)) {?>

		                    <a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo $crow->user_first.' '.$crow->user_last;?></a>

		                    <?php }?>    

		                    </td>

		                    

		                    <td class='no-border'><?php echo ucfirst($crow->usrname);?></td>

		                    <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>

		                    <td class='no-border'><?php echo $crow->qpoints;?></td>

		                </tr>

		                <?php }?>

		            </tbody>

		        </table>
				<?php }?>
        	</div>
        	<?php }?>
        </div>
        <?php }else{?>
        <br clear="all" />
        <div class="crm-error">Enter search keyword.</div>
        <?php }?>
        
	</div>
    <!-- Main content ends -->
</div>
<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>js/chart-loader.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//search tabs
        $('.quatabs a').click(function(e){
            $('.quatabs div').removeClass("active");
            $(this).parent().addClass("active");
            //$('.quaboxes div').removeClass("active");
            $('.tabbox').hide();
            //$('.quaboxes #'+$(this).attr("rel")).addClass("active");
            $('.tabbox.'+$(this).attr("rel")).show();
        });
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>