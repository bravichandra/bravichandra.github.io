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
            <!-- Search Contact/Account to add under list -->
            <div class="formRow crmlite" id="cLookup">
                <div class="qrbox">
                    <div class="abox1">Account Lookup</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
                </div>
                <div class="search-list"></div>
            </div>        

            <div class="title-bar">
                <?php if($section==1){?>
                <a href="javascript:void(0);" onclick="getLookup('contact','contact');" class="buttonM bBlack">Add Contact</a>
                <?php } else {?>
                <a href="javascript:void(0);" onclick="getLookup('account','account');" class="buttonM bBlack">Add Account</a>
                <?php }?>
				<a href="javascript:void(0);" class="buttonM bBlack delete">Remove from List</a>

            </div>
            <div align="center" style="float:right;width: 270px;">         
                <div class="search">
                    <label>
                        <input type="text" id="skey" class="searchkey" placeholder="Find Record" />
                        <div class="srch"></div>
                    </label>
                </div>
            </div>

			<form method="post" action="<?php echo current_url();?>" id="frmlist">
				<input type="hidden" name="action" value="records_deleteall" />
                <div id="records_list"><?php include('category-records-ajax-list.php'); ?></div>           
                <div align="center"><span class="loader"></span></div>
			</form>
            <!-- Record saving form -->
            <form method="post" action="<?php echo current_url();?>" id="frmrecord">
                <input type="hidden" name="action" id="action" value="saverecord" />
                <input type="hidden" name="rtype" value="<?php echo $section?>" />
                <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact])?>" name="record[contact]" id="contact_id" />

                <input type="hidden" value="<?php if(isset($record[account])) echo form_prep($record[account])?>" name="record[account]" id="account_id" />
            </form>
        </div>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
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
                   <?php /*?> <?php if($section==2){?>
                    oTaskTable.fnSort( [ [5,'desc'] ] );
                    <?php }else{?>    
                    oTaskTable.fnSort( [ [6,'desc'] ] );
                    <?php }?> <?php */?>   
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
          url: "<?php echo $pageurl?>",
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
                <?php if($section==2){?>
                oTaskTable.fnSort( [ [5,'desc'] ] );
                <?php }else{?>    
                oTaskTable.fnSort( [ [6,'desc'] ] );
                <?php }?>    
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
		//Delete records
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
        <?php /*?><?php if($section==2){?>
        oTaskTable.fnSort( [ [5,'desc'] ] );
        <?php }else{?>    
        oTaskTable.fnSort( [ [6,'desc'] ] );
        <?php }?>  <?php */?>  
        
		//oTable.fnSort( [ [<?php echo (!isset($mine)?6:6)?>,'desc'] ] );
		/*var searchlink = '<div align="center"><a href="<?php echo base_url(); ?>crm/search">Advanced</a></div>';
		$(".dataTables_filter").append(searchlink);*/
        get_more_pages_data();

	});
    //Lookup
    var objname='';
    //Get Lookup
    function getLookup(rcname,obname) {
        objname = obname;
        var popboxhead = '';
        var ajxmethod='';
        if(rcname=="account") {
            popboxhead = 'Account Lookup';
            ajxmethod='accounts_lookup';
        } else if(rcname=="contact") {
            popboxhead = 'Contact Lookup';
            ajxmethod='contacts_lookup';
        }
        Lookup_objname = obname;
        JSActionPage="CATG-LIST";
        $("#cLookup .abox1").html(popboxhead);
        $("#cLookup").show();
        $("#cLookup .search-list").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        $( "#cLookup .search-list" ).load( "<?php echo base_url()."crm/"?>"+ajxmethod, function() {
          $('.dsTable').dataTable({
                "bJQueryUI": false,
                "bAutoWidth": false,
                "sPaginationType": "full_numbers",
                "sDom": '<"H"fl>t<"F"ip>'
            });
        });
    }
    //Set lookup
    function setLookup(dis) {        
        $("#"+objname).val($(dis).attr("data_id"));
        $("#cLookup").hide();
        save_record();
    }    
    //Save List record
    function save_record(){        
        $(".loader").html('');
        <?php if($section==1){?>
        if($('#contact').val()=="") {
            alert("Contact not selected");            
            return false;
        }   
        <?php }else{ ?> 
        if($('#account').val()=="") {
            alert("Account not selected");
            return false;
        }
        <?php } ?>          
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          data: $('#frmrecord').serialize()
            }).done(function( resp ) {
				resp = resp.replace(/^\s*\n/gm, "");
                $(".loader").html('');
                if(resp=="R") {
                    location.replace("<?php echo current_url();?>");
                } else if(resp=="E") {
                    alert("Selected <?php echo ($section==2?'Account':'Contact')?> already exists.");
                } else alert(resp);
          });
    }
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
