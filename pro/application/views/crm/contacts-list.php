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
    
    <!-- LIST POPUP -->
    <div id="crmlistpopup">
        <div class="formRow">
            <div class="qrbox">
                <div class="abox1"><span>Add to List</span></div>
                <div class="abox2"><a href="javascript:void(0)" onClick="hide_catlist()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>            
            <form action="<?php echo current_url();?>" id="frmCatg" method="post">
                <input type="hidden" name="action" id="ecatlist" value="rectolist" />
                <input type="hidden" name="catrecids" id="catrecids" value="" />
                <div id="gh_anbox">
                    <div>
                        <div class="qebox">
                            <div class="erbox"></div>

                            <div class="box" title="List" id="catglist">
                                <?php foreach($catlist as $crow)    {?>
                                <div>
                                    <input type="checkbox" value="<?php echo $crow->id;?>" name="record[catg][]"/> <?php echo $crow->name;?>
                                </div>
                                <?php }?>
                            </div>
                        </div><br clear="all" />

                        <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                            <a href="javascript:void(0);" class="buttonM bGreen" onClick="hide_catlist()">Cancel</a>
                            <a href="javascript:void(0);" class="buttonM bRed" onClick="save_catlist()">Save</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<!-- Main content -->
    <div class="main-wrapper">    	
		<!-- Main content -->
        <div class="crmlite">        
            <div class="title-bar">            	
                <a href="<?php echo base_url(); ?>crm/contacts/all" class="buttonM bBlack">All Contacts</a> 
                <a href="<?php echo base_url(); ?>crm/contacts/my" class="buttonM bBlack">My Contacts</a> 
                <a href="<?php echo base_url(); ?>crm/contacts" class="buttonM bBlack">Target Contacts</a>                
				<a href="<?php echo base_url(); ?>crm/contacts/edit" class="buttonM bBlack">Add New</a> 
                <a href="<?php echo base_url(); ?>crm/contacts/import" class="buttonM bBlack">Import</a> 
				<a href="javascript:void(0);" class="buttonM bBlack delete">Delete</a>  
                <a href="javascript:void(0);" onClick="catlist_popup()" class="buttonM bBlack addtolist">Add to List</a>  
                <a href="javascript:void(0);" class="buttonM bRed dialog_helpvideo">Help Video</a> 
            </div>
            <div align="center" style="float:right;width: 270px; margin-bottom:30px;">         
                <div class="search">
                    <label>
                       <!-- <input type="text" id="skey" class="searchkey" placeholder="Find Record" />-->
                        <div class="srch"></div>
                    </label>
                </div>
            </div>
			<form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="deleteall" />
                <div id="records_list"><?php include('contacts-ajax-list.php'); ?></div>           
                <div align="center"><span class="loader"></span></div>
			</form>
        </div>
	</div>
    <!-- Main content ends -->
</div>
<div class="helpvideo_dialog" title="Video">
          <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Video</title>
    </head>

    <body>
     <div class="video">

     </div>
    </body>
    </html></div>
<script type="text/javascript">
    var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/lspMmPMp4D0" frameborder="0" allowfullscreen></iframe>';
    var oTaskTable;
    var coln;
    var cols;
    //Get more pages data
    function get_more_pages_data() {
        
        //Column sort
        $(".rhsort").on('click', function() {
            coln= $(this).data("col");
            cols= $(this).data("sort");
            search_records()
        });
        $("#morepages a").click(function(){
            coln='';
            cols='';
            $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
            $.ajax({
              type: "GET",
              url: $(this).attr("href")
                }).done(function( resp ) {   
                    $(".loader").html('');
                    $("#records_list").html(resp);
                    get_more_pages_data();
                    oTaskTable = $('.dtskTable').dataTable({
                        "bJQueryUI": true,
                        "bAutoWidth": false,
                        "iDisplayLength": 50,
                        "sPaginationType": "full_numbers",
                        "sDom": '<"H"fl>t<"F"ip>',
                        "deferRender": true,
                        paging: false,
                        "bInfo" : false,
                        searching: false,
                        "bSort": false,
                    });
                    //oTaskTable.fnSort( [ [<?php echo (!isset($mine)?6:6)?>,'desc'] ] );
              })
              .fail(function() {
                $(".loader").html('');
                $("#records_list").html( "Unable to load page, please try to refresh the page" );
              });
            return false;
        }); 
        $("#selectall").change(function(){
            $(".rcselect").prop("checked",$(this).prop("checked"));
        }); 
    }
    //Search records
    function search_records() {
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        $.ajax({
          type: "GET",
          url: $(this).attr("href"),
          data: 'search='+$("#skey").val()+'&col='+coln+'&sort='+cols,
            }).done(function( resp ) {   
                $(".loader").html('');
                $("#records_list").html(resp);
                get_more_pages_data();
                oTaskTable = $('.dtskTable').dataTable({
                    "bJQueryUI": true,
                    "bAutoWidth": false,
                    "iDisplayLength": 50,
                    "sPaginationType": "full_numbers",
                    "sDom": '<"H"fl>t<"F"ip>',
                    "deferRender": true,
                    paging: false,
                    "bInfo" : false,
                    searching: false,
                    "bSort": false,
                });
                //oTaskTable.fnSort( [ [<?php echo (!isset($mine)?6:6)?>,'desc'] ] );
          })
          .fail(function() {
            $(".loader").html('');
            $("#records_list").html( "Unable to search, please try to refresh the page" );
          });        
    }
	$(document).ready(function(){
        $("#skey").on('input', function() {
            coln='';
            cols='';
            search_records()
        });

        //Column sort
        $(".rhsort").on('click', function() {
            coln= $(this).data("col");
            cols= $(this).data("sort");
            search_records()
        });
        //Video
        $('.helpvideo_dialog').dialog({
            autoOpen: false,
            height: 400,
            width: 600,
            buttons: {
                "Close": function () {
                    $('.video').html('');
                    $(this).dialog("close");
                    
                }
            }    
        });
        // Invitation Dialog Link
        $('.dialog_helpvideo').click(function (e) {
             $('.video').html(iframe);
             $('.helpvideo_dialog').dialog('open');
             
            return false;
        });
        
        $('.ui-icon-closethick').click(function (e) {
             $('.video').html('');
              $('.helpvideo_dialog').dialog('close');
            return false;
        });
        
		
		$(".delete").click(function(){
			if($(".rcselect:checked").length==0) {
				alert("Select records");
				return false;
			}
			if(!confirm('Are you sure you want to delete these records?')) return false;
			$("#frmlist").submit();
		});

		oTaskTable = $('.dtskTable').dataTable({
            "bJQueryUI": true,
            "bAutoWidth": false,
            "iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "sDom": '<"H"fl>t<"F"ip>',
            "deferRender": true,
            paging: false,
            "bInfo" : false,
            searching: false,
            "bSort": false,
        });
        //oTaskTable.fnSort( [ [<?php echo (!isset($mine)?6:6)?>,'desc'] ] );
		/*var searchlink = '<div align="center"><a href="<?php echo base_url(); ?>crm/search">Advanced</a></div>';
		$(".dataTables_filter").append(searchlink);*/
        get_more_pages_data();

	});


    /*Category List*/
    //Hide Fade
    function hide_catlist(){
        $("#crmlistpopup").hide();
        $(".overlayBackground").hide();
    }
    //Popup
    function catlist_popup() {        
        if($(".rcselect:checked").length==0) {
            alert("Select records");
            return false;
        }
        $("#crmlistpopup .qrbox .abox1 span").html('Add to List');
        $("#crmlistpopup").show();
        $(".overlayBackground").show();
    }
    //Save Catlist
    function save_catlist() 
    {
        if($(".rcselect:checked").length==0) {
            alert("Select records");
            return false;
        }
        var recids = '';
        $(".rcselect:checked").each(function(){
            if(recids) recids += ',';
            recids += $(this).val();
        });
        $("#catrecids").val(recids);
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: $("#frmCatg").serialize(),
            cache: false,
            success: function(responce)
            {                
                if(responce==1) alert("Records added to List successfully.");
                hide_catlist();
                location.replace("<?php echo current_url();?>");
            }
        });
    }
    /*Category List*/
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
