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

<style type="text/css">.datepicker{z-index: 90000;}</style>

<!-- Sidebar ends --> <!-- Content begins -->

<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">

<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>

<script type="text/javascript">

	$(document).ready(function(){

		$( "td.edtable" ).hover(

		  function() {

		  	var eicon = '<a href="javascript:void(0);" onclick="edit_column(this);" class="edit"><span class="iconn icon-pencil" data-icon="&amp;#e123;"></span></a>';

			$(this).append(eicon);

		  }, function() {

			$(this).find("a.edit").remove();

		  }		

		);

		$("#sla_expdate").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){

			$(this).datepicker('hide');

		});

	});

	var ectrl;

	var ebox;

	//view contact

	function view_column(dis) {

		$(".erbox").html('');

		ectrl = $(dis).parent();

		ebox = ectrl.attr("data-field");

		$("#eblock").val(ebox);

		$("#crmpopup1 .qebox .box").hide();

		

		$('#'+dis+'_hide').html();

		$('#crmpopup1 .two').html($('#'+dis+'_hide').html());

		

		$("#crmpopup1 .abox1 span").html($("#crmpopup1 .qebox .box_"+ebox).attr('title'));

		$("#crmpopup1 .qebox .box_"+ebox).show();

		$("#crmpopup1").show();

		$(".overlayBackground").show();

		if(ebox=="account_parent") Records_getLookup('account','account_parent');

	}

	//Hide custom view

	function hide_fade1(){

		$(".erbox").html('');

		$("#crmpopup1").hide();

		$(".overlayBackground").hide();

		$('#cLookup').hide();

	}

	//Edit Column

	function edit_column(dis) {

		$(".erbox").html('');

		ectrl = $(dis).parent();

		ebox = ectrl.attr("data-field");

		$("#eblock").val(ebox);

		$("#crmpopup .qebox .box").hide();

		$("#crmpopup .abox1 span").html($("#crmpopup .qebox .box_"+ebox).attr('title'));

		$("#crmpopup .qebox .box_"+ebox).show();

		$("#crmpopup").show();

		$(".overlayBackground").show();

	}

	//Hide Fade

	function hide_fade(){

		$(".erbox").html('');

		$("#crmpopup").hide();

		$(".overlayBackground").hide();

	}

	//Update 

	function save_record()

	{

		$(".erbox").html('');

		$.ajax({

			type : 'POST',

			url : '<?php echo current_url();?>',

			data: $("#frmRecord").serialize(),

			cache: false,

			dataType: 'json',

			success: function(responce)

			{

				if(responce.status=="Y") {

					if(ebox=="target") $("#target").prop('checked',responce.cinfo=="1"?true:false);

					else ectrl.html(responce.cinfo);

					$("#crmpopup .qebox .box_"+ebox).hide();

					hide_fade();

				} else if(responce.status=="N")

					$(".erbox").html('<div class="crm-error">'+responce.error+'</div>');				

			}

		});		

	}

	var objname='';

	//Get Lookup

	function getLookup(rcname,obname) {

		objname = obname;

		var popboxhead = '';

		var ajxmethod='';

		if(rcname=="account") {

			popboxhead = 'Account Lookup';

			ajxmethod='accounts_lookup';

		} else if(rcname=="share") {

			popboxhead = 'Account Owner';

			ajxmethod='share_user_lookup';

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

		if(objname=="share_user")

		$("#"+objname+"_id").val($(dis).attr("data_id"));

		else $("#"+objname+"_parent").val($(dis).attr("data_id"));

		$("#cLookup").hide();

	}

    /*Category List*/
    //Hide Fade
    function hide_catlist(){
        $("#crmlistpopup").hide();
        $(".overlayBackground").hide();
    }
    //Popup
    function catlist_popup(catg_act) {        
        $("#crmlistpopup .qrbox .abox1 span").html(catg_act==1?'Add to List':'Remove from List');        
        $("#crmlistpopup").show();
        $(".overlayBackground").show();
    }
    //Save Catlist
    function save_catlist_old() 
    {
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: $("#frmCatg").serialize(),
            cache: false,
            success: function(responce)
            {                
                hide_catlist();
                location.replace("<?php echo current_url();?>");
            }
        });
    }
    //Save Catlist
    function save_catlist() 
    {
        $(".loader2").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: $("#frmCatgSingle").serialize(),
            cache: false,
            success: function(responce)
            {     
                $(".loader2").html('');
                //hide_catlist();
                location.replace("<?php echo current_url();?>");
            }
        });
    }
    /*Category List*/

</script>

<div class="overlayBackground" onclick="hide_fade()"></div>

<div id="content">

	<!-- Breadcrumbs line -->

	<?php  		

	$this->load->view('common/crm_nav');

	?>

    <div class="formRow crmlite" id="cLookup">

        <div class="qrbox">

            <div class="abox1">Account Lookup</div>

            <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />

        </div>

        <div class="search-list"></div>

    </div>

    

    <div id="crmlistpopup">
        <div class="formRow">
            <div class="qrbox">
                <div class="abox1"><span>Add to List</span></div>
                <div class="abox2"><a href="javascript:void(0)" onclick="hide_catlist()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>            
            <form action="<?php echo current_url();?>" id="frmCatg" method="post">
                <input type="hidden" name="action" id="ecatlist" value="listupdate" />
                <div id="gh_anbox">
                    <div>
                        <div class="qebox">
                            <div class="erbox"></div>

                            <div class="box" title="List" id="catglist">
                                <?php foreach($catlist as $crow)    {?>
                                <div>
                                    <input type="checkbox" value="<?php echo $crow->id;?>" name="record[catg][]" <?php if(in_array($crow->id,$checked_catg)!==FALSE) echo ' checked="checked"'?>  /> <?php echo $crow->name;?>
                                </div>
                                <?php }?>
                            </div>
                        </div><br clear="all" />

                        <div align="center" style="margin-top: 5px;margin-bottom: 5px;">
                            <a href="javascript:void(0);" class="buttonM bGreen" onclick="hide_catlist()">Cancel</a>
                            <a href="javascript:void(0);" class="buttonM bRed" onclick="save_catlist()">Save</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

     <!-- custom view-->

     <div id="crmpopup1">

        <div class="formRow">

            <div class="qrbox">

                <div class="abox1">View</div>

                <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade1()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />

            </div>

            <div class="box box_Custom" title="Custom">

                            	<table cellpadding="0" cellspacing="0"  border="0">	

                                    <tr>

                                        <td class="two"></td>

                                    </tr>

                                </table>

                            </div>

        </div> 

    </div>

    <div id="crmpopup">

        <div class="formRow">

            <div class="qrbox">

                <div class="abox1">Edit <span>Name</span></div>

                <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />

            </div>

            <form action="<?php echo current_url();?>" id="frmRecord" method="post">

            	<input type="hidden" name="action" value="update" />

                <input type="hidden" name="eblock" id="eblock" value="" />

                <div id="gh_anbox">     

                    <div>

                    	<div class="qebox">

                        	<div class="erbox"></div>

                            <div class="box box_target" title="Target Account">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                    	<th class="one">Target Account</th>

                                        <td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_billing" title="Billing Address">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Billing Street</th><td class="two"><textarea name="record[billing][street]"><?php if(isset($record[billing][street])) echo $record[billing][street]?></textarea></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Billing City</th><td class="two"><input type="text" value="<?php if(isset($record[billing][city])) echo form_prep($record[billing][city])?>" name="record[billing][city]" /></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Billing State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[billing][state])) echo form_prep($record[billing][state])?>" name="record[billing][state]" /></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Billing Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[billing][zipcode])) echo form_prep($record[billing][zipcode])?>" name="record[billing][zipcode]" /></td>

                                    </tr>

                                    <tr style="border-bottom:0px;">

                                        <th class="one">Billing Country</th><td class="two"><input type="text" value="<?php if(isset($record[billing][country])) echo form_prep($record[billing][country])?>" name="record[billing][country]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_account_name" title="Account Name">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Account Name</th><td class="two"><input type="text" value="<?php if(isset($record[account_name])) echo form_prep($record[account_name])?>" name="record[account_name]" id="account_name" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_phone" title="Phone">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Phone</th><td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_shipping" title="Shipping Address">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Shipping Street</th><td class="two"><textarea name="record[shipping][street]"><?php if(isset($record[shipping][street])) echo $record[shipping][street]?></textarea></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Shipping City</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][city])) echo form_prep($record[shipping][city])?>" name="record[shipping][city]" /></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Shipping State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][state])) echo form_prep($record[shipping][state])?>" name="record[shipping][state]" /></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Shipping Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][zipcode])) echo form_prep($record[shipping][zipcode])?>" name="record[shipping][zipcode]" /></td>

                                    </tr>

                                    <tr style="border-bottom:0px;">

                                        <th class="one">Shipping Country</th><td class="two"><input type="text" value="<?php if(isset($record[shipping][country])) echo form_prep($record[shipping][country])?>" name="record[shipping][country]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_account_parent" title="Parent Account">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Parent Account</th><td class="two">

                                        <input type="hidden" value="<?php if(isset($record[account_parent])) echo form_prep($record[account_parent])?>" name="record[account_parent]" id="account_parent_id" />

                                        <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_parent_title" />

                                        </td>

                                        <td><a href="javascript:void(0);" onclick="Records_getLookup('account','account_parent');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_fax" title="Fax">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Fax</th><td class="two"><input type="text" value="<?php if(isset($record[fax])) echo form_prep($record[fax])?>" name="record[fax]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_customer_priority" title="Customer Priority">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Customer Priority</th><td class="two"><select name="record[customer_priority]">

                                        <option value="">None</option>

                                            <option value="High"<?php $sel='';if(isset($record[customer_priority]) && $record[customer_priority]=="High") echo $sel=' selected="selected"'?>>High</option>

                                            <option value="Low"<?php if(isset($record[customer_priority]) && $record[customer_priority]=="Low") echo $sel=' selected="selected"'?>>Low</option>

                                            <option value="Medium"<?php if(isset($record[customer_priority]) && $record[customer_priority]=="Medium") echo $sel=' selected="selected"'?>>Medium</option>

                                            <?php if(!$sel && !empty($record[customer_priority])){?>

                                            <option value="<?php echo $record[customer_priority];?>" selected="selected"><?php echo $record[customer_priority];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_account_number" title="Account Number">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Account Number</th><td class="two"><input type="text" value="<?php if(isset($record[account_number])) echo form_prep($record[account_number])?>" name="record[account_number]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_website" title="Website">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Website</th><td class="two"><input type="text" value="<?php if(isset($record[website])) echo form_prep($record[website])?>" name="record[website]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_sla" title="SLA">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                    	<th class="one">SLA</th>

                                        <td class="two"><select name="record[sla]">

                                            <option value="">None</option>

                                            <option value="Gold"<?php $sel='';if(isset($record[sla]) && $record[sla]=="Gold") echo $sel=' selected="selected"'?>>Gold</option>

                                            <option value="Silver"<?php if(isset($record[sla]) && $record[sla]=="Silver") echo $sel=' selected="selected"'?>>Silver</option>

                                            <option value="Platinum"<?php if(isset($record[sla]) && $record[sla]=="Platinum") echo $sel=' selected="selected"'?>>Platinum</option>

                                            <option value="Bronze"<?php if(isset($record[sla]) && $record[sla]=="Bronze") echo $sel=' selected="selected"'?>>Bronze</option>

                                            <?php if(!$sel && !empty($record[sla])){?>

                                            <option value="<?php echo $record[sla];?>" selected="selected"><?php echo $record[sla];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_account_site" title="Account Site">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Account Site</th><td class="two"><input type="text" value="<?php if(isset($record[account_site])) echo form_prep($record[account_site])?>" name="record[account_site]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_ticker_symbol" title="Ticker Symbol">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Ticker Symbol</th><td class="two"><input type="text" value="<?php if(isset($record[ticker_symbol])) echo form_prep($record[ticker_symbol])?>" name="record[ticker_symbol]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_sla_expdate" title="SLA Expiration Date">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">SLA Expiration Date	</th><td class="two"><input type="text" value="<?php if(isset($record[sla_expdate])) echo form_prep($record[sla_expdate])?>" name="record[sla_expdate]" id="sla_expdate" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_account_type" title="Type">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Type</th><td class="two"><select name="record[account_type]">

                                            <option value="">None</option>

                                            <?php $sel='';foreach($account_types as $aval){?>

                                            <option value="<?php echo $aval;?>"<?php if(isset($record[account_type]) && $record[account_type]==$aval) echo $sel=' selected="selected"'?>><?php echo $aval;?></option>

                                            <?php }?>

                                            <?php if(!$sel && !empty($record[account_type])){?>

                                            <option value="<?php echo $record[account_type];?>" selected="selected"><?php echo $record[account_type];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_ownership" title="Ownership">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Ownership</th><td class="two"><select name="record[ownership]">

                                            <option value="">None</option>

                                            <option value="Public"<?php $sel='';if(isset($record[ownership]) && $record[ownership]=="Public") echo $sel=' selected="selected"'?>>Public</option>

                                            <option value="Private"<?php if(isset($record[ownership]) && $record[ownership]=="Private") echo $sel=' selected="selected"'?>>Private</option>

                                            <option value="Subsidiary"<?php if(isset($record[ownership]) && $record[ownership]=="Subsidiary") echo $sel=' selected="selected"'?>>Subsidiary</option>

                                            <option value="Other"<?php if(isset($record[ownership]) && $record[ownership]=="Other") echo $sel=' selected="selected"'?>>Other</option>

                                            <?php if(!$sel && !empty($record[ownership])){?>

                                            <option value="<?php echo $record[ownership];?>" selected="selected"><?php echo $record[ownership];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_sla_serialno" title="SLA Serial Number">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">SLA Serial Number</th><td class="two"><input type="text" value="<?php if(isset($record[sla_serialno])) echo form_prep($record[sla_serialno])?>" name="record[sla_serialno]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_industry" title="Industry">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Industry</th><td class="two"><select name="record[industry]">

                                            <option value="">None</option>

                                            <?php $sel='';foreach($industries as $aval){?>

                                            <option value="<?php echo $aval;?>"<?php if(isset($record[industry]) && $record[industry]==$aval) echo $sel=' selected="selected"'?>><?php echo $aval;?></option>

                                            <?php }?>

                                            <?php if(!$sel && !empty($record[industry])){?>

                                            <option value="<?php echo $record[industry];?>" selected="selected"><?php echo $record[industry];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_employees" title="Employees">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Employees</th><td class="two"><input type="text" value="<?php if(isset($record[employees]) && $record[employees]) echo form_prep($record[employees])?>" name="record[employees]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_numlocations" title="Number of Locations">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Number of Locations</th><td class="two"><input type="text" value="<?php if(isset($record[numlocations]) && $record[numlocations]) echo form_prep($record[numlocations])?>" name="record[numlocations]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_revenue" title="Annual Revenue">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Annual Revenue</th><td class="two"><input type="text" value="<?php if(isset($record[revenue]) && $record[revenue]) echo form_prep($record[revenue])?>" name="record[revenue]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_siccode" title="SIC Code">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">SIC Code</th><td class="two"><input type="text" value="<?php if(isset($record[siccode])) echo form_prep($record[siccode])?>" name="record[siccode]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_upsell_oppt" title="Upsell Opportunity">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Upsell Opportunity</th><td class="two"><select name="record[upsell_oppt]">

                                        <option value="">None</option>

                                            <option value="Maybe"<?php $sel='';if(isset($record[upsell_oppt]) && $record[upsell_oppt]=="Maybe") echo $sel=' selected="selected"'?>>Maybe</option>

                                            <option value="No"<?php if(isset($record[upsell_oppt]) && $record[upsell_oppt]=="No") echo $sel=' selected="selected"'?>>No</option>

                                            <option value="Yes"<?php if(isset($record[upsell_oppt]) && $record[upsell_oppt]=="Yes") echo $sel=' selected="selected"'?>>Yes</option>

                                            <?php if(!$sel && !empty($record[upsell_oppt])){?>

                                            <option value="<?php echo $record[upsell_oppt];?>" selected="selected"><?php echo $record[upsell_oppt];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_rating" title="Rating">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Rating</th><td class="two"><select name="record[rating]">

                                        <option value="">None</option>

                                            <option value="Hot"<?php $sel='';if(isset($record[rating]) && $record[rating]=="Hot") echo $sel=' selected="selected"'?>>Hot</option>

                                            <option value="Warm"<?php if(isset($record[rating]) && $record[rating]=="Warm") echo $sel=' selected="selected"'?>>Warm</option>

                                            <option value="Cold"<?php if(isset($record[rating]) && $record[rating]=="Cold") echo $sel=' selected="selected"'?>>Cold</option>

                                            <?php if(!$sel && !empty($record[rating])){?>

                                            <option value="<?php echo $record[rating];?>" selected="selected"><?php echo $record[rating];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_active" title="Active">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                        <th class="one">Active</th><td class="two"><select name="record[active]">

                                        <option value="">None</option>

                                            <option value="No"<?php $sel='';if(isset($record[active]) && $record[active]=="No") echo $sel=' selected="selected"'?>>No</option>

                                            <option value="Yes"<?php if(isset($record[active]) && $record[active]=="Yes") echo $sel=' selected="selected"'?>>Yes</option>

                                            <?php if(!$sel && !empty($record[active])){?>

                                            <option value="<?php echo $record[active];?>" selected="selected"><?php echo $record[active];?></option>

                                            <?php }?>

                                            </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_description" title="Description">

                            	<table cellpadding="0" cellspacing="0" border="0">

                                	<tr>

                                    	<td class="two"><textarea name="record[description]" style="height:100px;width: 500px;"><?php if(isset($record[description])) echo $record[description]?></textarea></td>

                                    </tr>

                                </table>

                            </div> 

                               <?php   $kc=0;

						   $ekeys=array();

						    foreach($record['custom'] as $cv){ 
                                    if(!isset($customa[$cv['ckey']])) continue;
						  			 $ekeys[]= $cv['ckey'];

                        				$kc++;?>

                            <div class="box box_<?php echo $cv['ckey']; ?>" title="<?php if(isset($customa[$cv['ckey']])) echo $customa[$cv['ckey']]?>">

                            	<table cellpadding="0" cellspacing="0" width="100%" border="0">

                                    <tr>

                                    	<th class="one"><?php if(isset($customa[$cv['ckey']])) echo $customa[$cv['ckey']]?></th>

                                        <td class="two"><!--<input type="text" value="<?php if(isset($cv['cval'])) echo $cv['cval'];?>" name="record[custom][<?php echo $cv['ckey']; ?>]" />-->  

                                        <textarea name="record[custom][<?php echo $cv['ckey']?>]" style="height:100px;width: 500px;"><?php if(isset($cv['cval'])) echo $cv['cval'];?></textarea></td>

                                    </tr>

                                </table>

                            </div>

                            <?php }

							//print_r($custom);

							foreach($customa as $ck=>$cv){

								if(in_array($ck,$ekeys)!==FALSE) continue;

                      			  $kc++;

							 ?>

                              <div class="box box_<?php echo $ck ?>" title="<?php echo $cv;?>">

                            	<table cellpadding="0" width="100%" cellspacing="0" border="0">

                                    <tr>

                                    	<th class="one"><?php if(isset($ck)) echo $cv; ?></th>

                                        <td class="two"><!--<input type="text" value="" name="record[custom][<?php echo $ck; ?>]"/>-->

                                        <textarea name="record[custom][<?php echo $ck; ?>]" style="height:100px;width: 500px;"><?php //if(isset($cv)) echo $cv;?></textarea></td>

                                    </tr>

                                </table>

                            </div>

                            <?php } ?>                             

                        </div>

                        <div align="center" style="margin-top: 5px;margin-bottom: 5px;">

                            <a href="javascript:void(0);" class="buttonM bGreen" onclick="hide_fade()">Cancel</a>

                            <a href="javascript:void(0);" class="buttonM bRed" onclick="save_record()">Save</a>

                        </div>

                    </div><br clear="all" />

                </div>                

            </form>

        </div>

    </div>

	<!-- Main content -->

    <div class="main-wrapper crmlite"> 

    	<div class="crm-menu">

           <?php /*?> <a href="<?php echo base_url();?>crm/accounts" class="buttonM bBlack">Back</a> <?php */?>
           
            <INPUT TYPE="button" VALUE="Back" class="buttonM bBlack" onClick="history.go(-1);" style="cursor:pointer;"/>

            <a href="<?php echo base_url();?>crm/accounts/edit/<?php echo $record[account_id]?>" class="buttonM bBlack">Edit</a> 

            <a href="<?php echo base_url();?>crm/accounts/delete/<?php echo $record[account_id]?>" onclick="if(!confirm('Are you sure you want to delete this account?')) return false;" class="buttonM bBlack">Delete</a>

            <a href="<?php echo base_url();?>crm/accounts/view/<?php echo $record[account_id]?>/send" class="buttonM bBlack">Salesforce Sync</a>  

            <div align="center" style="float:right;">

                <a href="<?php echo base_url();?>crm/interaction/account/<?php echo $record[account_id]?>" class="buttonM bRed">Log an Interaction</a> 

                <a href="<?php echo base_url();?>crm/qualifier/account/<?php echo $record[account_id]?>" class="buttonM bRed">Prospect Qualifier</a>         	

            </div>   

        </div>

        <?php if($error) {?>

        <div class="crm-error"><?php echo implode("<br />",$error);?></div>

        <?php }?>

		<!-- Main content -->

		 <?php include("account-view-layout.php");?>

        <hr />

        <?php if($total_points){?> 

        <div class="subsections chart">

        	<table cellpadding="0" cellspacing="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" width="100%" border="0" align="center" class="contact-list view">

            	<tr>

                	<th>Quality Points:<?php echo $total_points[ipt]?></th>

                    <th>Pursuit Points:<?php echo $total_points[ppt]?></th>

                    <th>

                    	<select id="chartfilter" onchange="updategraph(this.value)">	

                        	<?php echo $dayfilter?>

                        </select>

                    </th>

                </tr>

            </table>

            <div id="chart_div"></div>

        </div><hr />

<script src="<?php echo base_url();?>js/chart-loader.js"></script>

<script type="text/javascript">

var graphData = []<?php //echo $chartData;?>;
/*$.each(graphData, function (i, item) {
    var d = new Date(item[0][0],item[0][1],item[0][2]);                    
    graphData[i][0] = d;
});*/
google.charts.load('current', {packages: ['corechart', 'line']});

//google.charts.setOnLoadCallback(drawLineColors);

var sTE=1;
//sTE = <?php echo $sTE;?>;

function drawLineColors() {

      var data = new google.visualization.DataTable();

      data.addColumn('date', 'X');

      data.addColumn('number', 'Quality Points');

      data.addColumn('number', 'Pursuit Points');

	  data.addRows(graphData);	  

	  /*var gDL=graphData.length;	  

	  var sTE=1;

	  if($("#chartfilter").val()=="2") {

	  	if(gDL>15) sTE=3;

	  } else if($("#chartfilter").val()=="1" || $("#chartfilter").val()=="3") sTE=3;

	  else if($("#chartfilter").val()=="4") sTE=15;

	  else if($("#chartfilter").val()=="5") sTE=15;

	  else if($("#chartfilter").val()=="6") sTE=30;
      else if($("#chartfilter").val()=="7") sTE=30;*/

      if($("#chartfilter").val()=="7") lfromat="d-MMM-yyyy";
      else lfromat="d-MMM";


      var options = {

        hAxis: {

          title: 'Date',

		  format: lfromat,///,
              //showTextEvery : sTE,
              //format: 'd-MMM'//,
              gridlines: {color:'none'}

        },

        vAxis: {

          title: 'Points'

        },

        colors: [ '#009900','#FF0000'],

		pointShape : 'circle',

		pointsVisible : false

      };



      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

      chart.draw(data, options);

    }

	var gd3;

	//update graph data

	function updategraph(val)

	{

		$.ajax({

			type : 'POST',

			url : '<?php echo current_url();?>',

			data: 'gft='+val+'&cid=<?php echo $record[account_id]?>&action=graph',

			cache: false,

			dataType: 'json',

			success: function(responce)

			{

				graphData=responce.chartData;
                $.each(graphData, function (i, item) {
                    var d = new Date(item[0][0],item[0][1],item[0][2]);                    
                    graphData[i][0] = d;
                });
                sTE=responce.sTe;

				drawLineColors();	

			}

		});

	}

    $(document).ready(function(){
        updategraph($("#chartfilter").val());
    });

</script>

	<?php }?> 

        <div class="account-childs"></div>       

        <div class="subsections"><b>Lists</b></div>
        <div class="subsections" style="display: none;"><b>Lists</b> 
            <a href="javascript:void(0);" onclick="catlist_popup(0)">&nbsp;Remove from List</a>
            <a href="javascript:void(0);" onclick="catlist_popup(1)">&nbsp;Add to List | </a>             
        </div>
        <div>
            <form action="<?php echo current_url();?>" id="frmCatgSingle" method="post">
                <input type="hidden" name="action" id="ecatlist" value="listupdate" />
            <table cellpadding="0" cellspacing="0" border="0" style="margin: 6px 30px;">  
                <tr>
                    <th class="one" width="120px">SalesScripter Lists</th>
                    <td class="two" width="120px">
                        <select name="record[catg][]">
                            <option value="">Select List</option>
                            <?php foreach($catlist as $crow)    {?>
                            <option value="<?php echo $crow->id;?>"><?php echo $crow->name;?></option>
                            <?php }?>
                        </select>            
                    </td>
                    <td class="one" width="120px">&nbsp;<input type="button" class="buttonM bBlue" onclick="save_catlist()" value="Add to List" style="height: 27px;padding: 5px 15px;" /></td>
                    <td><div class="loader2"></div></td>
                </tr>
            </table> 
            </form>   
        </div>

        <div id="catg_list_show">
            <?php $this->load->view('crm/catg-list-few');?>
        </div> 

	</div>

    <!-- Main content ends -->

</div>

<script type="text/javascript">
   //get Mailchimp inf
    function getAccountChilds(){
        $(".account-childs").html('');
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          data: 'ccblock=accountchilds'
            }).done(function( resp ) {
                $(".account-childs").html(resp);
          })
          .fail(function() {
            $(".account-childs").html('');
          });
        return false;
    }
    $(document).ready(function(){
        getAccountChilds();
    });    
</script>
<!-- Content ends -->

<?php $this->load->view('common/footer'); ?>

