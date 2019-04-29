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
                <?php /*?><div class="abox2"><a href="javascript:void(0)" onClick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" /><?php */?>
                  <div class="abox2"><a href="javascript:void(0)" onClick="clookup()" style="color: #000;font-size: 16px;font-weight: bold;"><span>X</span></a></div><br clear="all" />

            </div>
            <div class="search-list"></div>
        </div>
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
        <?php if(!$is_prolite){?>
        <div class="title-bar" style="float: right; width:95px; margin-bottom:10px;"> 
            <?php /*?><a href="javascript:void(0);" onclick="change_points(this);" class="buttonM bRed delete">Edit Points</a>  <?php */?>           
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
        <?php }?>
        <form method="post" id="frm_qualifier" onSubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" id="action" value="save" />
            <input type="hidden" id="epoints" value="0" />
        <table cellpadding="0" cellspacing="0" style="width:100%;background: none repeat scroll 0 0 #f8f8f8;" border="0" class="contact-edit interact">
            <?php /*<tr>
            <th class="one"><?php echo $parent_name?>*</th><td class="two">
                <select name="record[record_id]" id="record_id">
                    <option value="">Select</option>
                    <?php foreach($parent_record as $cont): $rcid = isset($cont->contact_id)?$cont->contact_id:$cont->account_id;?>
                    <option value="<?php echo (isset($cont->contact_id)?$cont->contact_id:$cont->account_id);?>" <?php if(isset($record_id) && $record_id==$rcid) echo ' selected="selected"'?>><?php echo (isset($cont->contact_id)?ucfirst($cont->user_first.' '.$cont->user_last):ucfirst($cont->account_name)); ?></option>
                    <?php endforeach; ?>
					</select>
				</td>
            </tr>*/?>
           <?php /*?> <?php if($parent_name=="Contact"){?>
            <tr>
                <th class="one">Contact</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[record_id])) echo form_prep($record[record_id]); else echo $record_id;?>" name="record[record_id]" id="record_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[record_title])) echo form_prep($record[record_title]); else echo $record_title;?>" name="record[record_title]" id="record_title" /><a href="javascript:void(0);" onClick="Records_getLookup('contact','record');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>
            </tr>
            <?php }?>
            <?php if($parent_name=="Account"){?>
            <tr>
                <th class="one">Account</th><td class="two">
                <input type="hidden" value="<?php if(isset($record[record_id])) echo form_prep($record[record_id]); else echo $record_id;?>" name="record[record_id]" id="record_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[record_title])) echo form_prep($record[record_title]); else echo $record_title;?>" name="record[record_title]" id="record_title" /><a href="javascript:void(0);" onClick="Records_getLookup('account','record');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>
            </tr>
            <?php }?><?php */?>
            
            
            <tr class="contact-edit">

                <th class="one" width="40%" style="text-align:left;">Contact</th><td class="two">

                <input type="hidden" value="<?php if(isset($record[contact])) echo form_prep($record[contact]); else echo $crecord_id;?>" name="record[contact]" id="contact_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[contact_title])) echo form_prep($record[contact_title]); else echo $crecord_id_title;?>" name="record[contact_title]" id="contact_id_title" /><a href="javascript:void(0);" onClick="Records_getLookup('contact','contact_id');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                

            </tr>

            <tr class="contact-edit">

                <th class="one" width="40%" style="text-align:left;">Account</th><td class="two">

                <input type="hidden" value="<?php if(isset($record[account])) echo form_prep($record[account]); else echo $arecord_id;?>" name="record[account]" id="account_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record['account_title'])) echo form_prep($record[account_title]); else echo $arecord_id_title;?>" name="record[account_title]" id="account_id_title" /><a href="javascript:void(0);" onClick="Records_getLookup('account','account_id');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                

            </tr>
            
            <tr class="contact-edit">

                <th class="one" width="40%" style="text-align:left;">Opportunity</th><td class="two">

                <input type="hidden" value="<?php if(isset($record[opportunity])) echo form_prep($record[opportunity]); else echo $orecord_id;?>" name="record[opportunity]" id="oppt_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[oppt_name])) echo form_prep($record[oppt_name]); else echo $orecord_id_title;?>" name="record[oppt_name]" id="oppt_id_title" /><a href="javascript:void(0);" onClick="Records_getLookup('opportunity','oppt_id');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>                

            </tr>
            
            
            <tr style="border-bottom:0px;">
                <th class="one">Date*</th>
                <td class="two">
                <input type="text" value="<?php echo date("m/d/Y");?>" name="record[idate]" id="idate" class="idate" />
                </td>
            </tr>
            <tr>
            	<td colspan="2" id="catlist" class="intoptions">
                	<?php if($categories) {?>						
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <!-- CATEGORIES -->
                        <?php foreach($categories['category'] as $ci=>$cat) {?>
        					<?php foreach($cat as $si=>$section) {?>
        					<tr>
        						<th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onClick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> <?php echo $section['name'];?></a> </th>
        					</tr>
                    		<tr class="csect" id="secc<?php echo $ci.$si?>" >
                                <td>
                                	<?php 
        								$oi=0;
        								$opti=0;
        								if($section['options']) {?>
        								<div class="iquest">
                                        	<div class="iqb1"></div>
                                            <div class="iqb2"><b>Quality Points</b></div>
                                            <div class="iqb3"><b>Pursuit Points</b></div><br clear="all" />
        								<?php $noc = count($section['options']);foreach($section['options'] as $oi=>$option) { if($si==4 && $oi=="O") continue;$opti=$oi;?>                                
                                            <div class="iqb1"><input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="<?php echo $oi;?>" /> <?php echo $option['name'];?></div>
                                            <div class="iqb2">
                                            	<div class="pedit"><input type="number" name="record[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['points'];?>" min="-10" max="10" <?php if(is_float($option['points'])) echo 'step="0.5"';?>/></div>
        										<div class="pview"><?php echo $option['points'];?></div>
                                            </div>
                                            <div class="iqb3">
                                            	<div class="pedit"><input type="number" name="record[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['pursuit'];?>" min="-10" max="10"/></div>
        										<div class="pview"><?php echo $option['pursuit'];?></div>
                                            </div><br clear="all" />
                                        <?php }?>
                                        </div>
                                    <?php }?>
                                </td>
                                <td><b>Notes:</b><br /><textarea class="txtnotes" name="record[secnotes][<?php echo $ci.'n'.$si;?>]" style="height:100px;"></textarea></td>
                            </tr>
                            <?php }?>
                        <?php }?>

                        <!-- OTHER SECTIONS -->
                        <?php 
                            $ci=1;
                            foreach($categories['sections'] as $si=>$section) {?>
                        <tr>
                            <th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onClick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> <?php echo $section['name'];?></a> </th>
                        </tr>
                        <tr class="csect" id="secc<?php echo $ci.$si?>">
                            <td>
                                <?php 
                                    $oi=0;
                                    $opti=0;
                                    if($section['options']) {?>
                                    <div class="iquest">
                                        <div class="iqb1"></div>
                                        <div class="iqb2"><b>Quality Points</b></div>
                                        <div class="iqb3"><b>Pursuit Points</b></div><br clear="all" />
                                    <?php $noc = count($section['options']);foreach($section['options'] as $oi=>$option) { if($si==4 && $oi=="O") continue;$opti=$oi;?>                                
                                        <div class="iqb1"><input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="<?php echo $oi;?>" /> <?php echo $option['name'];?></div>
                                        <div class="iqb2">
                                            <div class="pedit"><input type="number" name="record[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['points'];?>" min="-10" max="10" <?php if(is_float($option['points'])) echo 'step="0.5"';?>/></div>
                                            <div class="pview"><?php echo $option['points'];?></div>
                                        </div>
                                        <div class="iqb3">
                                            <div class="pedit"><input type="number" name="record[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['pursuit'];?>" min="-10" max="10"/></div>
                                            <div class="pview"><?php echo $option['pursuit'];?></div>
                                        </div><br clear="all" />
                                    <?php }?>
                                    </div>
                                <?php }?>
                                <?php if($si==4){                               
                                $objother = end($section['options']);
                                $oi = $opti;
                            ?>
                            <div class="iquest">
                                <?php foreach($CustObjections as $obval) : $oi++; ?>
                                <div class="iqb1">
                                    <input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="O" /> <?php echo $obval->obj_val; ?> 
                                    <?php /*?><textarea name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]"><?php echo $obval->obj_val; ?></textarea><?php */?>
                                    <input type="hidden" name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo form_prep($obval->obj_val); ?>" />
                                    <input type="hidden" name="record[opto_id<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo $obval->obj_id; ?>" />
                                </div>
                                <div class="iqb2">
                                    <div class="pedit"><input type="number" name="record[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['points'];?>" min="-10" max="10"/></div>
                                    <div class="pview"><?php echo $objother['points'];?></div>
                                </div>
                                <div class="iqb3">
                                    <div class="pedit"><input type="number" name="record[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['pursuit'];?>" min="-10" max="10"/></div>
                                    <div class="pview"><?php echo $objother['pursuit'];?></div>
                                </div><br clear="all" />
                                <?php endforeach; ?>
                                <?php foreach($ObjectionsCampaign as $obval) : $oi++; ?>
                                <div class="iqb1">
                                    <input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="O" /> <?php echo $obval->ob_title; ?>                                    <?php /*?><textarea name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]"><?php echo $obval->ob_title; ?></textarea><?php */?>
                                    <input type="hidden" name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo form_prep($obval->ob_title); ?>" />
                                    <input type="hidden" name="record[opto_id<?php echo $ci;?>][<?php echo $oi;?>]" value="0" />
                                </div>
                                <div class="iqb2">
                                    <div class="pedit"><input type="number" name="record[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['points'];?>" min="-10" max="10"/></div>
                                    <div class="pview"><?php echo $objother['points'];?></div>
                                </div>
                                <div class="iqb3">
                                    <div class="pedit"><input type="number" name="record[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['pursuit'];?>" min="-10" max="10"/></div>
                                    <div class="pview"><?php echo $objother['pursuit'];?></div>
                                </div><br clear="all" />
                                <?php endforeach; $oi++; ?>
                                <div class="iqb1">
                                    <input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval optother" value="O" onChange="inter_change(this,'chk',<?php echo $ci?>)" /> Other 
                                    <span class="span_objother">
                                        <input name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" type="text" value="" class="opto_txt" />
                                    </span>
                                </div>
                                <div class="iqb2">
                                    <div class="pedit"><input type="number" name="record[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['points'];?>" min="-10" max="10"/></div>
                                    <div class="pview"><?php echo $objother['points'];?></div>
                                </div>
                                <div class="iqb3">
                                    <div class="pedit"><input type="number" name="record[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['pursuit'];?>" min="-10" max="10"/></div>
                                    <div class="pview"><?php echo $objother['pursuit'];?></div>
                                </div><br clear="all" />
                            </div>
                            <?php }?>
                            </td>
                            <td><b>Notes:</b><br /><textarea class="txtnotes" name="record[secnotes][<?php echo $ci.'n'.$si;?>]" style="height:100px;"></textarea></td>
                        </tr>
                        <?php }
                            $si = 6;
                            $ci = 1;
                        ?>

                        <!-- SCHEDULES -->
                        <tr>
    						<th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onClick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> Schedule Follow-Up Task</a></th>
    					</tr>
                		<tr class="csect scftask" id="secc<?php echo $ci.$si?>">
                            <td>
                            	<?php foreach($categories['schedule'] as $oi=>$option) {?>
                                <div><input type="radio" class="optval" name="record[sch][<?php echo $ci;?>]" value="<?php echo $option;?>" onChange="inter_change(this,'rad',<?php echo $ci?>)" /> <?php echo $option;?></div>
                        		<?php }?>
                                <div>
                                    <input type="radio" name="record[sch][<?php echo $ci;?>]" class="optval schother" value="O" onChange="inter_change(this,'rad',<?php echo $ci?>)" /> Other 
                                    <span class="span_schother">
                                        <input name="record[sch_txt<?php echo $ci;?>]" type="text" value="" class="scho_txt" />
                                    </span>
                                </div>
                                <div>For Due Date: <input name="record[sdate][<?php echo $ci;?>]" type="text" readonly="readonly" value="" class="idate" /></div>
                            </td>
                            <td><b>Notes:</b><br /><textarea class="txtnotes" name="record[schnotes][<?php echo $ci;?>]" style="height:100px;"></textarea></td>
                        </tr>
                    </table>
					<?php }?>
                </th>
            </tr>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                    	<span class="loader"></span>
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section."/view/".$record_id;?>" class="buttonM bRed">Back</a>
                    </div>
                </td>
            </tr>
        </table>
        </form>
	</div>
    <!-- Main content ends -->
</div>
<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.idate').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
	});
	function clookup()
	{
		$("#cLookup").hide();
	}
	//Skip hint	
	function save_record(){
		var er=0;
		if($('#contact_id').val()=="" && $('#account_id').val()=="" &&  $('#oppt_id').val()=="") {
			alert("Select Account or Contact or Opportunity");
			$('#record_id').focus();
			return false;
		}
		if($('#idate').val()=="") {
			alert("Select date");
			$('#idate').focus();
			return false;
		}
		var optValid = 0;
		var ct = $('#cat').val();
		optValid +=$(".intoptions .optval:checked").length;
		if(optValid==0) {
			$(".intoptions .txtnotes").each(function(e){
				if($(this).val()!="") {optValid=1;return false;}
			});
		}
		if(optValid==0) {
			alert("Select checkbox options");
			return false;
		}
		if($(".intoptions .optother").prop("checked")==true) {
			//if($("#cat"+ct+" .opto_select").val()=="" && $("#cat"+ct+" .opto_txt").val()=="") {
			if($(".intoptions .opto_txt").val()=="") {
				alert("Objection other value required");
				return false;
			}
		}
		if($(".intoptions .schother").prop("checked")==true) {
			if($(".intoptions .scho_txt").val()=="") {
				alert("Schedule Follow-Up Task other value required");
				return false;
			}
		}
		//alert("Concept inprocess");
		//return false;
		//console.log($('#frm_qualifier').serialize());
		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		$.ajax({
		  type: "POST",
		  url: "<?php echo current_url();?>",
		  data: $('#frm_qualifier').serialize()
			}).done(function( data ) {
				data = data.replace(/^\s*\n/gm, "");
				if(data.substr(0,3)=="YES") {
					var nid=data.split("-");
					//location.replace("<?php echo base_url() . 'crm/'.$parent_section.'/view/';?>"+nid[1]);
					
					if($("#contact_id").val()!="") 

						location.replace("<?php echo base_url() . 'crm/contacts/view/';?>"+$("#contact_id").val());

					else if($("#account_id").val()!="") 

						location.replace("<?php echo base_url() . 'crm/accounts/view/';?>"+$("#account_id").val());
						
					else if($("#oppt_id").val()!="") 

						location.replace("<?php echo base_url() . 'crm/opportunities/view/';?>"+$("#oppt_id").val());
						
						
				} else {
					alert(data);
					$(".loader").html('');
				}	
		  });
		return false;
	}
	$(document).ready(function(){
		$('#cat').change(function(e){
			$("#catlist .optval").prop('checked',false);
			$("#catlist .span_objother").hide();
			$("#catlist .span_schother").hide();
			$("#catlist textarea").val('');
			$("#catlist .idate").val('');
			//$("#catlist .opto_select").val('');
			$("#catlist .opto_txt").val('');
			$("#catlist .scho_txt").val('');
			//$("#catlist .selector span").html('Select');
			$("#catlist .catbox").hide();
			$("#catlist tr.csect").hide();
			$("#catlist th span").removeClass("icon-arrow-down");
			$("#catlist th span").removeClass("icon-arrow-right");
			$("#catlist th span").addClass("icon-arrow-right");
			$("#catlist th a").attr("data-colp","0");
			if($(this).val()!="") {
				var catg= $(this).val();	
				//First section
				$("#catlist #cat"+catg+" .iconn:first").removeClass("icon-arrow-down");
				$("#catlist #cat"+catg+" .iconn:first").removeClass("icon-arrow-right");
				$("#catlist #cat"+catg+" .iconn:first").addClass("icon-arrow-down");
				$("#catlist #cat"+catg+" a:first").attr("data-colp","1");
				$("#catlist #cat"+catg+" .csect:first").show();
				//Last Section
				$("#catlist #cat"+catg+" .iconn:last").removeClass("icon-arrow-down");
				$("#catlist #cat"+catg+" .iconn:last").removeClass("icon-arrow-right");
				$("#catlist #cat"+catg+" .iconn:last").addClass("icon-arrow-down");
				$("#catlist #cat"+catg+" a:last").attr("data-colp","1");
				$("#catlist #cat"+catg+" .csect:last").show();
				//Visible category
				$("#catlist #cat"+catg).show();
			}
		});
	});
	var objname='';
	//Get Lookup
	function getLookup(obname) {
		var rcname=$("#task_related").val();
		objname = obname;
		var popboxhead = '';
		var ajxmethod='';
		if(rcname=="A") {
			popboxhead = 'Account Lookup';
			ajxmethod='accounts_lookup';
		} else if(rcname=="C") {
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
		$("#"+objname+"_id").val($(dis).attr("data_id"));
		$("#cLookup").hide();
	}
	//Collapse
	function collapse(tid,dis) {
		if($(dis).attr("data-colp")=="1") {
			$("#sec"+tid).hide();
			$(dis).attr("data-colp","0");
			$(dis).find("span").removeClass("icon-arrow-down");
			$(dis).find("span").removeClass("icon-arrow-right");
			$(dis).find("span").addClass("icon-arrow-right");
		} else {
			$("#sec"+tid).show();
			$(dis).attr("data-colp","1");
			$(dis).find("span").removeClass("icon-arrow-down");
			$(dis).find("span").removeClass("icon-arrow-right");
			$(dis).find("span").addClass("icon-arrow-down");
		}
	}
	//Objection changes
	function inter_change(dis,type,c) {
		if(type=='chk') {
			$("#cat"+c+" .opto_txt").val('');
			<?php /*?>$("#cat"+c+" .opto_select").val('');
			$("#cat"+c+" .selector span").html('Select');<?php */?>
			if($(dis).prop("checked")==true) $(dis).parent().find(".span_objother").show();
			else $(dis).parent().find(".span_objother").hide();
		} else if(type=='rad') {
			$(".scho_txt").val('');
			if($(dis).val()=="O" && $(dis).prop("checked")==true) $(".span_schother").show();
			else $(".span_schother").hide();
		}
		<?php /*?> else if(type=='sel') {
			$("#cat"+c+" .opto_txt").val('');
		} else if(type=='txt') {
			$("#cat"+c+" .opto_select").val('');
			$("#cat"+c+" .selector span").html('Select');
		}<?php */?>
	}
	//Change Points
	function change_points(dis) {
		if($("#epoints").val()=="0") {
			$("#epoints").val("1");
			$(dis).html("Lock Points");
			$(".pview").hide();
			$(".pedit").show();
		} else {
			$("#epoints").val("0");
			$(dis).html("Edit Points");
			$(".pedit").hide();
			$(".pview").show();
		}
	}
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/HSW7oLM32uM" frameborder="0" allowfullscreen></iframe>';
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