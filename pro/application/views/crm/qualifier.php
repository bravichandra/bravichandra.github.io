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
    
    	<div style="float: right;"> 
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div><br clear="all" /><br />

    	<div class="formRow crmlite" id="cLookup">

            <div class="qrbox">

                <div class="abox1">Account Lookup</div>

                 <div class="abox2"><a href="javascript:void(0)" onclick="clookup()" style="color: #000;font-size: 16px;font-weight: bold;"><span>X</span></a></div><br clear="all" />

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

            <?php /*?><tr>

                <th class="one" width="40%">Contact*</th><td class="two">

                <select name="record[contact]" id="contact">

                <option value="">Select</option>

                <?php foreach($contacts as $cont): ?>

                <option value="<?php echo $cont->contact_id;?>" <?php if(isset($parent_id) && $parent_id==$cont->contact_id) echo ' selected="selected"'?>><?php echo ucfirst($cont->user_first.' '.$cont->user_last); ?></option>

                <?php endforeach; ?>

                </select></td>

            </tr><?php */?>

            <tr class="contact-edit">

                <th class="one" width="40%" style="text-align:left;">Contact</th><td class="two">

                <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact])?>" name="record[contact]" id="contact_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title])?>" name="record[contact_title]" id="contact_title" /><a href="javascript:void(0);" onclick="Records_getLookup('contact','contact');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                

            </tr>

            <tr class="contact-edit">

                <th class="one" width="40%" style="text-align:left;">Account</th><td class="two">

                <input type="hidden" value="<?php if(isset($record[account])) echo form_prep($record[account])?>" name="record[account]" id="account_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_title" /><a href="javascript:void(0);" onclick="Records_getLookup('account','account');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                

            </tr>
            
            
            <tr class="contact-edit">

                <th class="one" width="40%" style="text-align:left;">Opportunity</th><td class="two">

                <input type="hidden" value="<?php if(isset($record[opportunity])) echo form_prep($record[opportunity])?>" name="record[opportunity]" id="oppt_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[oppt_name])) echo form_prep($record[oppt_name])?>" name="record[oppt_name]" id="oppt_id_title" /><a href="javascript:void(0);" onclick="Records_getLookup('opportunity','oppt_id');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                

            </tr>


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

            </tr>

            <tr>

            	<td class="title" colspan="2">

                	<div class="quatabs">
                		<div class="active first">
                        	<a href="javascript:void(0);" rel="box1">
								<?php 
									if($tabtitles[0]->title!='') $title=$tabtitles[0]->title; else $title='Pre-Qualifying';
									echo $title;
								?>
                            </a>
                        </div>
                        <div class="second">
                        	<a href="javascript:void(0);" rel="box2">
								<?php 
									if($tabtitles[1]->title!='') $title=$tabtitles[1]->title; else $title='Need vs Want';
									echo $title;
								?>
                            </a>
                        </div>
                        <div class="">
                        	<a href="javascript:void(0);" rel="box3">
								<?php 
									if($tabtitles[2]->title!='') $title=$tabtitles[2]->title; else $title='Ability to Purchase';
									echo $title;
								?>
                            </a>
                        </div>
                        <div class="">
                        	<a href="javascript:void(0);" rel="box4">
								<?php 
									if($tabtitles[3]->title!='') $title=$tabtitles[3]->title; else $title='Decision Authority';
									echo $title;
								?>
                            </a>
                        </div>
                        <div class="">
                        	<a href="javascript:void(0);" rel="box5">
								<?php 
									if($tabtitles[4]->title!='') $title=$tabtitles[4]->title; else $title='Competition Level';
									echo $title;
								?>
                            </a>
                        </div>
                	</div>
                </td>

            </tr>

            <tr>

            	<td colspan="2" id="pqqlist">

                	<div class="quaboxes">

                		<div id="box1" class="active">

                        	<?php 
								 if($questions) {
								 $qi=-1;
								 $c=1;
								 foreach($questions as $qns) {
								 //echo '<pre>'; print_r($qns); echo '</pre>';
								 $qi++; 
							?>

                        	<div class="qualify">

								<table cellpadding="0" cellspacing="0" width="100%">

									<tr>

										<td class="box1"><?php echo $qns->value;?></td>

										<td class="box2">

											<b>Quality Points:</b><br /> 

											<div class="qpoints">

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-3" /> -3</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-2" /> -2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-1" /> -1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" checked="checked" class="optval" value="0" /> 0</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="1" /> 1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="2" /> 2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="3" /> 3</label><br />

											</div>

											<b>Notes</b><br />

											<textarea name="record[section][<?php echo $c?>][task_label][<?php echo $qi?>]" class="task_label"><?php echo $qns->value;?></textarea>

											<textarea name="record[section][<?php echo $c?>][task_notes][<?php echo $qi?>]" class="task_notes"></textarea>

										</td>

									</tr>

								</table>                                

                            </div>

                            <?php }}?>

                        </div>

                        <div id="box2">

                        	<?php $c=2;$qi=-1;
								//foreach($qualifier_questions['Need_Want'] as $qns){$qi++;
								if($need_want_qus) {
								 $q_cols_counts += count($need_want_qus);
								 foreach($need_want_qus as $qns) {
								 //echo '<pre>'; print_r($qns); echo '</pre>';
								 $qi++; 
							?>

                        	<div class="qualify">

								<table cellpadding="0" cellspacing="0" width="100%">

									<tr>

										<td class="box1"><?php echo $qns->question;?></td>

										<td class="box2">

											<b>Quality Points:</b><br /> 

											<div class="qpoints">

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-3" /> -3</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-2" /> -2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-1" /> -1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" checked="checked" class="optval" value="0" /> 0</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="1" /> 1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="2" /> 2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="3" /> 3</label><br />

											</div>

											<b>Notes</b><br />

											<textarea name="record[section][<?php echo $c?>][task_label][<?php echo $qi?>]" 
                                            class="task_label"><?php echo $qns->question;?></textarea>

											<textarea name="record[section][<?php echo $c?>][task_notes][<?php echo $qi?>]" class="task_notes"></textarea>

										</td>

									</tr>

								</table>                                

                            </div>

                            <?php }}?>

                        </div>

                        <div id="box3">

                        	<?php 
								$c++;$qi=-1;
								if($funding_availability) {
								$q_cols_counts += count($funding_availability);
								foreach($funding_availability as $qns){$qi++;?>

                        	<div class="qualify">

                                <table cellpadding="0" cellspacing="0" width="100%">

									<tr>

										<td class="box1"><?php echo $qns->question;?></td>

										<td class="box2">

											<b>Quality Points:</b><br /> 

											<div class="qpoints">

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-3" /> -3</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-2" /> -2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-1" /> -1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" checked="checked" class="optval" value="0" /> 0</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="1" /> 1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="2" /> 2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="3" /> 3</label><br />

											</div>

											<b>Notes</b><br />

											<textarea name="record[section][<?php echo $c?>][task_label][<?php echo $qi?>]" 
                                            class="task_label"><?php echo $qns->question;?></textarea>

											<textarea name="record[section][<?php echo $c?>][task_notes][<?php echo $qi?>]" class="task_notes"></textarea>

										</td>

									</tr>

								</table>

                            </div>

                            <?php }}?>

                        </div>

                        <div id="box4">

                        	<?php 
								$c++;$qi=-1;
								if($decision_authority) {
								$q_cols_counts += count($decision_authority);
								foreach($decision_authority as $qns){
								$qi++;
							?>

                        	<div class="qualify">

                                <table cellpadding="0" cellspacing="0" width="100%">

									<tr>

										<td class="box1"><?php echo $qns->question;?></td>

										<td class="box2">

											<b>Quality Points:</b><br /> 

											<div class="qpoints">

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-3" /> -3</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-2" /> -2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-1" /> -1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" checked="checked" class="optval" value="0" /> 0</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="1" /> 1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="2" /> 2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="3" /> 3</label><br />

											</div>

											<b>Notes</b><br />

											<textarea name="record[section][<?php echo $c?>][task_label][<?php echo $qi?>]" 
                                            class="task_label"><?php echo $qns->question;?></textarea>

											<textarea name="record[section][<?php echo $c?>][task_notes][<?php echo $qi?>]" class="task_notes"></textarea>

										</td>

									</tr>

								</table>

                            </div>

                            <?php }}?>

                        </div>

                        <div id="box5">

                        	<?php 
							$c++;$qi=-1;
							if($intent_purchase) {$q_cols_counts += count($intent_purchase);
							foreach($intent_purchase as $qns){$qi++;?>

                        	<div class="qualify">

                                <table cellpadding="0" cellspacing="0" width="100%">

									<tr>

										<td class="box1"><?php echo $qns->question?></td>

										<td class="box2">

											<b>Quality Points:</b><br /> 

											<div class="qpoints">

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-3" /> -3</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-2" /> -2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-1" /> -1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" 
                                            checked="checked" class="optval" value="0" /> 0</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="1" /> 1</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="2" /> 2</label> 

											<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="3" /> 3</label><br />

											</div>

											<b>Notes</b><br />

											<textarea name="record[section][<?php echo $c?>][task_label][<?php echo $qi?>]"
                                             class="task_label"><?php echo $qns->question;?></textarea>

											<textarea name="record[section][<?php echo $c?>][task_notes][<?php echo $qi?>]" class="task_notes"></textarea>

										</td>

									</tr>

								</table>

                            </div>

                            <?php }}?>

                        </div>

                	</div>

                </th>

            </tr>

            <tr>

            	<td colspan="2" align="center">

                    <div class="fluid" style="margin-top:15px;">

                    	<span class="loader"></span>

                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />

                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section."/view/".$parent_id;?>" class="buttonM bRed">Back</a>

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
	
	function clookup()
	{
		$("#cLookup").hide();
	}

	function save_record(){

		var er=0;

		if($('#contact_id').val()=="" && $('#account_id').val()=="" &&  $('#oppt_id').val()=="") {

			alert("Select Account or Contact or Opportunity");	

			return false;

		}

		if($('#campaign').val()=="") {

			alert("Select Sales Pitch Campaign");

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
				data = data.replace(/^\s*\n/gm, "");
				if(data.substr(0,3)=="YES") {

					var nid=data.split("-");

					//alert(nid);

					//location.replace("<?php// echo base_url() . 'crm/notes/view/';?>"+nid[1]);

					if($("#contact_id").val()!="") 

						location.replace("<?php echo base_url() . 'crm/contacts/view/';?>"+$("#contact_id").val());

					else if($("#account_id").val()!="") 

						location.replace("<?php echo base_url() . 'crm/accounts/view/';?>"+$("#account_id").val());
						
					else if($("#oppt_id").val()!="") 

						location.replace("<?php echo base_url() . 'crm/opportunities/view/';?>"+$("#oppt_id").val());

				} else alert(data);

		  });

		return false;

	}

	//Get campaign selected

	/*function get_campaign() {

		if($('#campaign').val()!="") {

			$('.quatabs div').removeClass("active");

			$('.quatabs div:first-child').addClass("active");

			$('.quaboxes div').removeClass("active");

			$('.quaboxes #box1').addClass("active");			

			$("#box1").html('<img src="<?php echo base_url();?>images/spinner.gif" />');

			$("#campaign_name").val($('#campaign :selected').text());

			$.ajax({

			  type: "POST",

			  url: "<?php echo current_url();?>",

			  data: {'act':'questions', 'id':$('#campaign').val()}

				}).done(function( data ) {

					$("#box1").html(data);

					$("#box1 input").uniform();

			  });			

		} else {

			$("#box1").html('');

		}

	}*/
	
	
	function get_campaign(dis) {
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'id='+dis+'&act=questions',
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                location.replace("<?php echo base_url() . 'crm/qualifier/';?>");
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
		
		else if(rcname=="opportunity") {

			popboxhead = 'Opportunities Lookup';

			ajxmethod='opportunity_lookup';

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

<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/pKVM_7PhXjw" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
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
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>