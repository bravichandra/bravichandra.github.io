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

        	<div class="title-bar">            	                

                <a href="<?php echo base_url(); ?>crm/lists" class="buttonM bBlack">Contact List</a> 

                <a href="<?php echo base_url(); ?>crm/lists/2" class="buttonM bBlack">Account List</a>                
				<a href="<?php echo $secUrl; ?>/edit" class="buttonM bBlack">Add New</a>
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a>  
                <a href="#" class="buttonM bRed dialog_mchelp">Help Video</a>                         
            </div>

            <form method="post" action="<?php echo current_url();?>" id="frmlist">

				<input type="hidden" name="action" value="deleteall" />

            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>

                <thead>

                    <tr>                        
                    	<th class='no-border' width="50px"><input type="checkbox" id="selectall" /></th>
                        <th class='no-border'>Name</th>
                        <th class='no-border'>Description</th>                        
                        <th class='no-border' width="100px"><?php echo ($section==2?'Accounts':'Contacts')?></th>
                        <th class='no-border' width="100px">Shared</th>
                        <th class='no-border' width="100px">Date Modified</th>
                        <th class='no-border' width="100px">Edit</th>
                    </tr>

                </thead>

                <tbody>

                	<?php foreach($catlist as $crow)    {
                            $total_records = $this->crm->get_category_records($crow->id,$section,'');

					?>

                    <tr>
                    	<td class='no-border'><input type="checkbox" value="<?php echo $crow->id;?>" name="recids[]" class="rcselect" /></td>
                        <td class='no-border'><a href="<?php echo base_url(); ?>crm/lists/view/<?php echo $crow->id;?>"><?php echo $crow->name;?></a></td>
                        <td class='no-border'><?php echo $crow->info;?></td>
                        <td class='no-border'><?php echo number_format($total_records)?></td>
                        <td class='no-border'><?php echo ($crow->share?'Yes':'No');?></td>
                        <td class='no-border'><?php echo date("m/d/Y",strtotime($crow->modified));?></td>
                        <td class='no-border'><a href="<?php echo base_url(); ?>crm/lists/edit/<?php echo $crow->id;?>">Edit</a></td>
                    </tr>

                    <?php }?>

                </tbody>

            </table>

            </form>

        </div>

		

	</div>

    <!-- Main content ends -->

</div>

<style type="text/css">
		.crmlite .dataTables_length {
    display: none !important;
}
</style>

<script type="text/javascript">
    var iframe_mailchimp= '<iframe width="560" height="315" src="https://www.youtube.com/embed/mm-_KELWdXY" allow="autoplay; encrypted-media" frameborder="0" allowfullscreen></iframe>';

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

        $('.mchelp_dialog').dialog({
            autoOpen: false,
            height: 400,
            width: 600,
            buttons: {
                "Close": function () {
                    $('.mcvideo').html('');
                    $(this).dialog("close");
                    
                }
            }    
        });
        
        // Invitation Dialog Link
        $('.dialog_mchelp').click(function (e) {
             $('.mcvideo').html(iframe_mailchimp);
             $('.mchelp_dialog').dialog('open');
             
            return false;
        });
        
        $('.ui-icon-closethick').click(function (e) {
             $('.mcvideo').html('');
              $('.mchelp_dialog').dialog('close');
            return false;
        });

	});

</script>
<div class="mchelp_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video</title>
</head>

<body>
 <div class="mcvideo">

 </div>
</body>
</html></div>
<!-- Content ends -->

<?php $this->load->view('common/footer'); ?>

