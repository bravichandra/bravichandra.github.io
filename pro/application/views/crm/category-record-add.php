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
    	<div class="formRow crmlite" id="cLookup">
            <div class="qrbox">
                <div class="abox1">Account Lookup</div>
                <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>
            <div class="search-list"></div>
        </div>
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
        <form method="post" id="frm_qualifier" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" id="action" value="save" />
	        <table cellpadding="0" cellspacing="0" style="width:100%;background: none repeat scroll 0 0 #f8f8f8;" border="0" class="contact-list">
	        	<?php if($section==1){?>
	            <tr class="contact-edit">
	                <th class="one" width="40%" style="text-align:left;">Contact</th><td class="two">
	                <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact])?>" name="record[contact]" id="contact" />
	                <input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title])?>" name="record[contact_title]" id="contact_title" /><a href="javascript:void(0);" onclick="getLookup('contact','contact');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                
	            </tr>
	            <?php } else {?>
	            <tr class="contact-edit">
	                <th class="one" width="40%" style="text-align:left;">Account</th><td class="two">
	                <input type="hidden" value="<?php if(isset($record[account])) echo form_prep($record[account])?>" name="record[account]" id="account" />
	                <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_title" /><a href="javascript:void(0);" onclick="getLookup('account','account');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                
	            </tr>
	            <?php } ?>
	            <tr>
	            	<td colspan="2" align="center">
	                    <div class="fluid" style="margin-top:15px;">
	                    	<span class="loader"></span>
	                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
	                        <a href="<?php echo base_url('crm/lists/view/'.$record['id']);?>" class="buttonM bRed">Back</a>
	                    </div>
	                </td>
	            </tr>
	        </table>
        </form>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
	//Skip hint	
	function save_record(){
		var er=0;
		$(".loader").html('');
		<?php if($section==1){?>
		if($('#contact').val()=="") {
			alert("Select contact");			
			return false;
		}	
		<?php }else{ ?>	
		if($('#account').val()=="") {
			alert("Select account");
			return false;
		}
		<?php } ?>			
		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: $('#frm_qualifier').serialize()
			}).done(function( resp ) {
				$(".loader").html('');
				if(resp=="R") {
					location.replace("<?php echo base_url('crm/lists/view/'.$record['id']);?>");
				} else if(resp=="E") {
					alert("Selected <?php echo ($section==2?'Account':'Contact')?> already exists.");
				} else alert(resp);
		  });
		return false;
	}
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
		$("#"+objname+"_title").val($(dis).html());
		$("#"+objname).val($(dis).attr("data_id"));
		$("#cLookup").hide();
	}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>