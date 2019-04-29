<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style type="text/css">
		.contact-list
		{
			border-bottom:0px !important;
			border-right:0px !important;
			border-left:0px !important;
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
       	<table cellpadding="0" cellspacing="0" style="width:100%;background: none repeat scroll 0 0 #f8f8f8;" border="0" class="contact-list">            
            <tr>
                <th class="one">Sales Pitch Campaign*</th>
                <td class="two">
                <select name="record[campaign]" id="campaign" onchange="get_campaign(this.value)">
                    <option value="">Select</option>
                    <?php foreach($drop_campaign as $singlecampaign): ?>
                    
                    <option value="<?php echo $singlecampaign->campaign_id; ?>" <?php if($singlecampaign->status == 1){ echo "selected";} ?>><?php echo $singlecampaign->campaign_name; ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
                 <td>
                	<div style="text-align: right;">
                        <a href="#" class="buttonM bRed dialog_help">Help Video</a>
                    </div>
                </td>
            </tr>
            <tr>
            	<td class="title" colspan="3">
                	<?php //echo '<pre>'; print_r($tabtitles); echo '</pre>'; ?>
                	<div class="quatabs">
                		<div class="active first"><a href="javascript:void(0);" rel="box1"><?php echo $tabtitles[0]->title;  ?></a></div>
                        <div class="second"><a href="javascript:void(0);" rel="box2"><?php echo $tabtitles[1]->title;  ?></a></div>
                        <div><a href="javascript:void(0);" rel="box3"><?php echo $tabtitles[2]->title;  ?></a></div>
                        <div><a href="javascript:void(0);" rel="box4"><?php echo $tabtitles[3]->title;  ?></a></div>
                        <div><a href="javascript:void(0);" rel="box5"><?php echo $tabtitles[4]->title;  ?></a></div>
                	</div>
                </td>
            </tr>
            
            <tr>
            	<td colspan="3" id="pqqlist">
                	<div class="quaboxes">
                		<div id="box1" class="active">
                        	 <?php include "squalify.php"; ?>
                        </div>
                        <div id="box2">
                        	 <?php include "need_want.php"; ?>
                        </div>
                        <div id="box3">
                        	 <?php include "funding_availability.php"; ?>
                        </div>
                        <div id="box4">
                        	 <?php include "decision_authority.php"; ?>
                        </div>
                        <div id="box5">
                        	<?php include "intent_purchase.php"; ?>
                        </div>
                	</div>
                </th>
            </tr>
         </table>
        </form>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
	//Update Tech qualify sort order by Dev@4489
	function updateSorder2(rcid,oval,obj)
	{
		if(rcid=='0') return;
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		if(oval) {
			$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: 'rcid='+rcid+'&action=SortOrderupdate2&sord='+oval,
				cache: false,
				dataType: 'json',
				success: function(responce)
				{
					$('.pleasewait').css('display','none');
				}
			});
		}
	}
	
	//Update Tech Value display option
    function updateNeedDisplay(rcid,dis,qp) {
        var vis = dis.checked?0:1;
		var position = $(dis).position();
		var offset = $(dis).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=NeedShowupdate&val='+vis+'&qp='+qp,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                $('.pleasewait').css('display','none'); 
            }
        });

    }
	 //Update Tech Value Highlight display option
    function updateNeedHighlight(rcid,dis,qp) {
        var vis = dis.checked?1:0;
		var position = $(dis).position();
		var offset = $(dis).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'rcid='+rcid+'&action=NeedShowHighlightupdate&val='+vis+'&qp='+qp,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                $('.pleasewait').css('display','none');
            }
        });

    }
	function hide_box_status2(sales_qid){
		if(!confirm('Are u sure you want to delete?')) return;
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."campaign/deletesquestion/" ?>', 
			data : { 'sq_id' : sales_qid},
			success : function(data){
				location.replace("<?php echo current_url();?>");
			}
		});
	}
	
	
	//Delete Response by Dev@4489
	function delsresp(qrespid) {
		if(!confirm('Are u sure you want to delete?')) return;
		$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: {action:'deletesResp',qrid:qrespid},
				cache: false,
				dataType: 'json',
				success: function(responce)
				{
					location.replace("<?php echo current_url();?>");
				}
			});	
	}	
	
	
	function DynamicAddRowSalesQuestion(obj,type)
	{
		var position = $(obj).position();
		var offset = $(obj).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
		var newiddy ;
		var numItems = $('.SalesQuestionTrClass').length;
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url()."product/dynamicSalesQuestion" ?>',
			data :  {'totalcount': numItems+1, 'type':type},
			success : function(data){
				if(type=='tab2') $('#SalesQuestionTbody').append(data);
				if(type=='tab3') $('#SalesQuestionTbody3').append(data);
				if(type=='tab4') $('#SalesQuestionTbody4').append(data);
				if(type=='tab5') $('#SalesQuestionTbody5').append(data);
				dynamicText();
				// console.log(data);
				// location.reload(true);
				$('.pleasewait').css('display','none');
				$('.qorder:last').val($('.qorder').length+1);//by Dev@4489
			}
		});
	}
	
	
	
	//Skip hint	
	function save_record(){
		var er=0;
		/*if($('#contact').val()=="" && $('#account').val()=="") {
			alert("Select contact or account or both");			
			return false;
		}*/
		if($('#campaign').val()=="") {
			alert("Select Sales Pitch Campaign");
			$('#campaign').focus();
			return false;
		}
		/*if($('.quaboxes input[value!="0"]:checked').length>0) er=1;
		else {
			$('.task_notes').each(function(e){
				if($(this).val()!="") {er=1;return false;}
			});
		}*/
		/*if(er==0) {
			alert("Please select quality points or enter notes atleast one");
			return false;
		}*/
		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: $('#frm_qualifier').serialize()
			}).done(function( data ) {
				if(data.substr(0,3)=="YES") { 
					var nid=data.split("-");
					//alert(nid);
					//location.replace("<?php// echo base_url() . 'crm/notes/view/';?>"+nid[1]);
					location.replace("<?php echo base_url() . 'crm/contacts/view/';?>"+nid[2]);
				} else alert();
		  });
		return false;
	}
	
	//Get campaign selected
    function get_campaign(dis) {
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'campid='+dis+'&action=questions',
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                location.replace("<?php echo base_url() . 'home/sales_question/';?>");
            }
        });

    }
	
	//get_campaign();
	$(document).ready(function(){
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
	function step2()
	{
		$(".quaboxes #box1").removeClass('active');
		$(".quaboxes #box2").addClass('active');
		$(".quatabs .first").removeClass('active');
		$("#quaboxes .second").addClass('active');
	}
	
	
	//Question trees show_qresponse
	//show response
	function show_fquestions(qfid,qrparent) {
		$("#qsresp").remove();
		$("#pastanswers").remove();
		var AnList= $("#qsResponse").html().replace("NNNNNNNN","qsresp");
		AnList = AnList.replace("noBorderB","");
		$("#ansListh"+qfid).prepend(AnList);
		if($("#ansListh"+qfid).width()>400)$("#qsresp").css("margin-left",($("#ansListh"+qfid).width()-400)+"px");
		$("#qsresp #qid").val(qfid);
		$("#qsresp #qpid").val(qrparent);
		console.log($(".gans"+qfid).val());
		if(qrparent>0){
			//alert($(".gansQR"+qrparent).val());
			$("#qsresp #parent_answer").html($(".gansQR"+qrparent).val());
		}
		else{
			//alert($(".gans"+qfid).val());
			$("#qsresp #parent_answer").html($(".gans"+qfid).val());
		}
		//Save Qualify answer
		save_sall_qanswers();		
	}	
	//Save Qualify all questions
	function save_sall_qanswers() {
		var tclass = '';
		var t1;
		var etext,eid,etype;
		$( "textarea[class*=' gans']" ).each(function( index ) {
			etext = $(this).val();
			tclass = $(this).attr("class");
			etext=='';
			eid='';
			etype='';
			if(tclass.indexOf("gansQR")!=-1) {
				t1 = tclass.split("gansQR");
				eid = t1[1];
				etype = 'qr';
			} else if(tclass.indexOf("gans")!=-1) {
				t1 = tclass.split("gans");
				eid = t1[1];
				etype = 'q';
			}
			if(etext && eid && etype) {
			$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: {action:'savesqrinfo',etext:etext,eid:eid,etype:etype},
				cache: false,
				success: function(responce)
				{
					//Saved
				}
			});
			}
		});
		return;
	}
	
	
	//Save Response
	function save_qsresponse(sbtn) {
		var rform = $(sbtn).parent();
		var rdiv = rform.parent();
		if($("#qsresp .txtresp1").val()=="") {
			$("#qsresp .txtresp1").focus();
			alert("Enter prospect response");
			return;
		}
		if($("#qsresp .txtresp2").val()=="") {
			$("#qsresp .txtresp2").focus();
			alert("Enter follow-up question");
			return;
		}
		
		$("#qsresp .loader").show();
		$.ajax({
				type : 'POST',
				url : '<?php echo current_url();?>',
				data: $("#qsresp form").serialize(),
				cache: false,
				dataType: 'json',
				success: function(responce)
				{
					$("#qsresp .loader").hide();
					location.replace("<?php echo current_url();?>");
				}
			});	
	}

var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/yVz6iR27PkY" frameborder="0" allowfullscreen></iframe>';
	$( document ).ready(function() {
		$('.help_dialog').dialog({
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
		$('.dialog_help').click(function (e) {
			 $('.video').html(iframe);
			 $('.help_dialog').dialog('open');
			 
			return false;
		});
		
		$('.ui-icon-closethick').click(function (e) {
			 $('.video').html('');
			  $('.help_dialog').dialog('close');
			return false;
		});
		
	});	
</script>
<!-- Content ends -->
<div class="help_dialog" title="Video">
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
<?php $this->load->view('common/footer'); ?>