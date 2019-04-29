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
            <input type="hidden" name="record[campaign_name]" id="campaign_name" value="<?php if(isset($record[campaign_name])) echo form_prep($record[campaign_name])?>" />
        <table cellpadding="0" cellspacing="0" style="width:100%;background: none repeat scroll 0 0 #f8f8f8;" border="0" class="contact-list">
            <tr class="contact-edit">
                <th class="one" width="40%" style="text-align:left;">Applicant</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact])?>" name="record[contact]" id="applicant" />
                <input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title])?>" name="record[contact_title]" id="applicant_title" /><a href="javascript:void(0);" onclick="getLookup('applicant','applicant');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                
            </tr>
            <tr>
                <th class="one">Question List*</th>
                <td class="two">
                <select name="record[campaign]" id="campaign" onchange="get_campaign();">                    
                    <?php $qid=0;foreach($allIntvQuestion as $single): if(!$qid) $qid=$single->interv_ques_id;?>
                    <option value="<?php echo $single->interv_ques_id; ?>"><?php echo $single->interview_ques_name; ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
            </tr>
            <tr>
            	<td colspan="2" id="pqqlist">
            		<?php $this->load->view('interview/qualifier-ajax');?>
                </th>
            </tr>
            <tr>
            	<td colspan="2" align="center">
                    <div class="fluid" style="margin-top:15px;">
                    	<span class="loader"></span>
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <?php if($parent_id){?>
                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section."/view/".$parent_id;?>" class="buttonM bRed">Back</a>
                        <?php }?>
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
		if($('#applicant').val()=="") {
			alert("Select Applicant");			
			return false;
		}
		if($('#campaign').val()=="") {
			alert("Select Question List");
			$('#campaign').focus();
			return false;
		}
		if($('.quaboxes input[value!="0"]:checked').length>0) er=1;
		else {
			$('.task_notes').each(function(e){
				if($(this).val()!="") {er=1;return false;}
			});
		}
		if(er==0) {
			alert("Please select quality points or enter notes atleast one");
			return false;
		}
		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');		
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: $('#frm_qualifier').serialize()
			}).done(function( data ) {
				if(data.substr(0,3)=="YES") {
					var nid=data.split("-");
					//location.replace("<?php// echo base_url() . 'interviewer/notes/note/view/';?>"+nid[1]);
					location.replace("<?php echo base_url() . 'interviewer/applicant/view/';?>"+nid[2]);
				} else alert(data);
		  });
		return false;
	}
	//Get campaign selected
	function get_campaign() {
		if($('#campaign').val()!="") {
			$('.quatabs div').removeClass("active");
			$('.quatabs div:first-child').addClass("active");
			$('.quaboxes div').removeClass("active");
			$('.quaboxes #box1').addClass("active");			
			$("#pqqlist").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$("#campaign_name").val($('#campaign :selected').text());
			$.ajax({
			  type: "POST",
			  url: "<?php echo current_url();?>",
			  data: {'act':'questions', 'id':$('#campaign').val()}
				}).done(function( data ) {
					$("#pqqlist").html(data);
					$("#pqqlist input").uniform();
					$('.quatabs a').click(function(e){
						$('.quatabs div').removeClass("active");
						$(this).parent().addClass("active");
						$('.quaboxes div').removeClass("active");
						$('.quaboxes #'+$(this).attr("rel")).addClass("active");
					});
			  });			
		} else {
			$("#pqqlist").html('');
		}
	}
	get_campaign();
	$(document).ready(function(){
		/*$( ".quatabs a" ).bind( "click", function() {
		  	$('.quatabs div').removeClass("active");
			$(this).parent().addClass("active");
			$('.quaboxes div').removeClass("active");
			$('.quaboxes #'+$(this).attr("rel")).addClass("active");
		});*/
		$('.quatabs a').click(function(e){
			$('.quatabs div').removeClass("active");
			$(this).parent().addClass("active");
			$('.quaboxes div').removeClass("active");
			$('.quaboxes #'+$(this).attr("rel")).addClass("active");
		});
	});
	//Lookup
	var objname='';
	//Get Lookup
	function getLookup(rcname,obname) {
		objname = obname;
		var popboxhead = '';
		var ajxmethod='';
		if(rcname=="applicant") {
			popboxhead = 'Applicant Lookup';
			ajxmethod='applicant_lookup';
		}
		$("#cLookup .abox1").html(popboxhead);
		$("#cLookup").show();
		$("#cLookup .search-list").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		$( "#cLookup .search-list" ).load( "<?php echo base_url()."interviewer/"?>"+ajxmethod, function() {
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