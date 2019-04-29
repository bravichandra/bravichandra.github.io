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
    	<div style="text-align: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
        <?php if($error) {?>
        <div class="crm-error"><?php echo implode("<br />",$error);?></div>
        <?php }//echo "<pre>";print_r($rowsdata);print_r($rowsdata2);echo "</pre>";?>
		<!-- Main content -->
        <?php if(isset($mapping) && $rowsdata && !$error) {
			$column_keys = $rowsdata['keys'];
			$column_heads = $rowsdata['values'];
			$datarow = $rowsdata['rows'];
		?>
        <form method="post" id="frmAccountsImport" onsubmit="return save_accounts_imported();" action="<?php echo base_url('crmbeta/save_accounts_imported');?>">
        	<input type="hidden" name="action" value="save" />
            <input type="hidden" name="cbaction" value="save_accounts_imported" />
            <input type="hidden" name="record[cbrows]" value="<?php echo $rowsdata['total'];?>" />

        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="3"><?php echo ucfirst($parent_section);?> Feilds Mapping</th>
            </tr>
            <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[target]" /> Select here to make all imported <?php echo $parent_section;?> designated as target <?php echo $parent_section;?></td>
            </tr>
            <?php if($crmlite=="contact") {?>
            <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[target_account]" /> Select here to make all imported accounts designated as target accounts</td>
            </tr>
            <?php }?>
            
            <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[mapping]" /> Save Mapping</td>
            </tr>
            <?php 
			$info=unserialize($userinfo[0]->value);
			//echo "<pre>";
			//print_r($info);
			$res= array_diff($column_heads,$info['headers']);
			// print_r($res);
			 if(count($column_heads)!=count($res)){ ?>
			  <tr>
            	<td colspan="3" align="left"><input type="checkbox" value="1" name="record[old]" checked="checked" /> Mapping from Previous Import</td>
            </tr>
		<?php  
			 }
			
			?>
            <tr>
            	<td colspan="3">Assign Record Owner: 
                	<select name="record[share_user_id]">
                        <?php foreach($dropdown_users as $prosp){?>
                        <option value="<?php echo $prosp->user_id;?>"<?php if($user_id==$prosp->user_id) echo ' selected="selected"';?>><?php echo ucfirst($prosp->usrname);?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="3">Assign to a List: 
                    <select name="record[listid]">
                        <option value="0">Select List</option>
                        <?php foreach($catlist as $catg){?>
                        <option value="<?php echo $catg->id;?>"><?php echo $catg->name;?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="one"><?php echo ucfirst($crmlite);?> Field</th>
                <th class="two">Excel Column</th>
                <th class="two">Your Data</th>
            </tr>
            <?php 
				$ki=0;
				$value=$info['val'];
				//print_r($value);
				$default=array();
				foreach($column_keys as $ci=>$cv){
				$default=$value[$ci];
					//print_r($default);?>
            <tr>
                <td class="one">
                	<input type="hidden" name="record[excol][<?php echo $ki;?>]" value="<?php echo $ki;//echo $cv;?>" />
                	<select name="record[tbcol][<?php echo $ki;?>]" class="tbcol">
                    	<option value="">No Mapping</option>
						<?php foreach($table_fields as $ri=>$rv){?>
                        <option value="<?php echo $ri;?>"<?php if(isset($record['tbcol'][$ki]) && $record['tbcol'][$ki]==$ri) echo ' selected="selected"';  else if($default==$ri) echo ' selected="selected"';?> ><?php echo $rv;?></option>
                        <?php }?>
                    </select>
                </td>
                <td class="two"><?php echo $column_heads[$ci];?></td>
                <td class="two"><?php if($ext=="xls" || $ext=="xlsx") echo $datarow[$ci];else echo $datarow["$cv"];//echo $datarow["$cv"];?></td>
            </tr>
            <?php $ki++;}?>
             <tr>
                <td colspan="3" style="color: red;"><br><b>Add an Interaction to Imported Records(Optional)</b></td>
            </tr>
            <tr>
                <th class="one">Date</th>
                <td class="two">
                <input type="text" value="<?php echo date("m/d/Y");?>" name="record2[idate]" id="idate" class="idate" />
                </td>
            </tr>
            <tr>
                <td colspan="3" class="interact">
                    <div colspan="2" id="catlist" class="intoptions">
                        <?php if($categories) {?>                       
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                            <!-- CATEGORIES -->
                            <?php foreach($categories['category'] as $ci=>$cat) {?>
                                <?php foreach($cat as $si=>$section) {?>
                                <tr>
                                    <th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onclick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> <?php echo $section['name'];?></a> </th>
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
                                                <div class="iqb1"><input type="checkbox" name="record2[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="<?php echo $oi;?>" /> <?php echo $option['name'];?></div>
                                                <div class="iqb2">
                                                    <div class="pedit"><input type="number" name="record2[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['points'];?>" min="-10" max="10" <?php if(is_float($option['points'])) echo 'step="0.5"';?>/></div>
                                                    <div class="pview"><?php echo $option['points'];?></div>
                                                </div>
                                                <div class="iqb3">
                                                    <div class="pedit"><input type="number" name="record2[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['pursuit'];?>" min="-10" max="10"/></div>
                                                    <div class="pview"><?php echo $option['pursuit'];?></div>
                                                </div><br clear="all" />
                                            <?php }?>
                                            </div>
                                        <?php }?>
                                    </td>
                                    <td><b>Notes:</b><br /><textarea class="txtnotes" name="record2[secnotes][<?php echo $ci.'n'.$si;?>]" style="height:100px;"></textarea></td>
                                </tr>
                                <?php }?>
                            <?php }?>

                            <!-- OTHER SECTIONS -->
                            <?php 
                                $ci=1;
                                foreach($categories['sections'] as $si=>$section) {?>
                            <tr>
                                <th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onclick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> <?php echo $section['name'];?></a> </th>
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
                                            <div class="iqb1"><input type="checkbox" name="record2[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="<?php echo $oi;?>" /> <?php echo $option['name'];?></div>
                                            <div class="iqb2">
                                                <div class="pedit"><input type="number" name="record2[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['points'];?>" min="-10" max="10" <?php if(is_float($option['points'])) echo 'step="0.5"';?>/></div>
                                                <div class="pview"><?php echo $option['points'];?></div>
                                            </div>
                                            <div class="iqb3">
                                                <div class="pedit"><input type="number" name="record2[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $option['pursuit'];?>" min="-10" max="10"/></div>
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
                                        <input type="checkbox" name="record2[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="O" /> <?php echo $obval->obj_val; ?> 
                                        <?php /*?><textarea name="record2[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]"><?php echo $obval->obj_val; ?></textarea><?php */?>
                                        <input type="hidden" name="record2[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo form_prep($obval->obj_val); ?>" />
                                        <input type="hidden" name="record2[opto_id<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo $obval->obj_id; ?>" />
                                    </div>
                                    <div class="iqb2">
                                        <div class="pedit"><input type="number" name="record2[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['points'];?>" min="-10" max="10"/></div>
                                        <div class="pview"><?php echo $objother['points'];?></div>
                                    </div>
                                    <div class="iqb3">
                                        <div class="pedit"><input type="number" name="record2[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['pursuit'];?>" min="-10" max="10"/></div>
                                        <div class="pview"><?php echo $objother['pursuit'];?></div>
                                    </div><br clear="all" />
                                    <?php endforeach; ?>
                                    <?php foreach($ObjectionsCampaign as $obval) : $oi++; ?>
                                    <div class="iqb1">
                                        <input type="checkbox" name="record2[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="O" /> <?php echo $obval->ob_title; ?>                                    <?php /*?><textarea name="record2[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]"><?php echo $obval->ob_title; ?></textarea><?php */?>
                                        <input type="hidden" name="record2[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo form_prep($obval->ob_title); ?>" />
                                        <input type="hidden" name="record2[opto_id<?php echo $ci;?>][<?php echo $oi;?>]" value="0" />
                                    </div>
                                    <div class="iqb2">
                                        <div class="pedit"><input type="number" name="record2[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['points'];?>" min="-10" max="10"/></div>
                                        <div class="pview"><?php echo $objother['points'];?></div>
                                    </div>
                                    <div class="iqb3">
                                        <div class="pedit"><input type="number" name="record2[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['pursuit'];?>" min="-10" max="10"/></div>
                                        <div class="pview"><?php echo $objother['pursuit'];?></div>
                                    </div><br clear="all" />
                                    <?php endforeach; $oi++; ?>
                                    <div class="iqb1">
                                        <input type="checkbox" name="record2[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval optother" value="O" onchange="inter_change(this,'chk',<?php echo $ci?>)" /> Other 
                                        <span class="span_objother">
                                            <input name="record2[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" type="text" value="" class="opto_txt" />
                                        </span>
                                    </div>
                                    <div class="iqb2">
                                        <div class="pedit"><input type="number" name="record2[qp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['points'];?>" min="-10" max="10"/></div>
                                        <div class="pview"><?php echo $objother['points'];?></div>
                                    </div>
                                    <div class="iqb3">
                                        <div class="pedit"><input type="number" name="record2[pp][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="iprange" value="<?php echo $objother['pursuit'];?>" min="-10" max="10"/></div>
                                        <div class="pview"><?php echo $objother['pursuit'];?></div>
                                    </div><br clear="all" />
                                </div>
                                <?php }?>
                                </td>
                                <td><b>Notes:</b><br /><textarea class="txtnotes" name="record2[secnotes][<?php echo $ci.'n'.$si;?>]" style="height:100px;"></textarea></td>
                            </tr>
                            <?php }
                                $si = 6;
                                $ci = 1;
                            ?>

                            <!-- SCHEDULES -->
                            <tr>
                                <th colspan="2" class="title"><a href="javascript:void(0);" data-colp="0" onclick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> Schedule Follow-Up Task</a></th>
                            </tr>
                            <tr class="csect scftask" id="secc<?php echo $ci.$si?>">
                                <td>
                                    <?php foreach($categories['schedule'] as $oi=>$option) {?>
                                    <div><input type="radio" class="optval" name="record2[sch][<?php echo $ci;?>]" value="<?php echo $option;?>" onchange="inter_change(this,'rad',<?php echo $ci?>)" /> <?php echo $option;?></div>
                                    <?php }?>
                                    <div>
                                        <input type="radio" name="record2[sch][<?php echo $ci;?>]" class="optval schother" value="O" onchange="inter_change(this,'rad',<?php echo $ci?>)" /> Other 
                                        <span class="span_schother">
                                            <input name="record2[sch_txt<?php echo $ci;?>]" type="text" value="" class="scho_txt" />
                                        </span>
                                    </div>
                                    <div>For Due Date: <input name="record2[sdate][<?php echo $ci;?>]" type="text" readonly="readonly" value="" class="idate" /></div>
                                </td>
                                <td><b>Notes:</b><br /><textarea class="txtnotes" name="record2[schnotes][<?php echo $ci;?>]" style="height:100px;"></textarea></td>
                            </tr>
                        </table>
                        <?php }?>
                    </div>
                </td>
            </tr>
            <tr>
            	<td colspan="3" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Import" />
                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                        <div class="aistatus"></div>
                        <span class="loader"></span>
                    </div>
                </td>
            </tr>
        </table>
        </form>
        <?php } else {?>        
        
        <?php if(!isset($sfMode)) {?>
        <form method="post" onsubmit="return save_record();" enctype="multipart/form-data" action="<?php echo base_url('crm/'.$parent_section.'/import');?>">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
        	<tr>
            	<th class="title" colspan="2"><?php echo ucfirst($crmlite);?>s Upload</th>
            </tr>
            <tr>
                <th class="one">Browse CSV or Excel*</th><td class="two">
                	<input type="file" name="import_file" id="import_file" />
                    <br />Make Excel or CSV file first row should have Headings of your excel data.
                    </td>
            </tr>
            <tr>
            	<td colspan="2" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Upload" />
                        <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                    </div>		
                </td>
            </tr>
        </table>
        </form>
        <?php }?>
        
        <?php if($crmlite=="account") {?>
        <form method="post" action="<?php echo base_url('crm/'.$parent_section.'/import/salesforce');?>">
        	<input type="hidden" name="action" value="s2dimport" />
            <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
                <tr>
                    <th class="title" colspan="2"><?php echo ucfirst($crmlite);?>s Import from Salesforce</th>
                </tr>
                <tr>
                    <td colspan="2">
                    	<?php if($Salesforce_Records) {?>
                        <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dTable'>
                            <thead>
                                <tr>
                                    <th class='no-border'><input type="checkbox" id="selectall" /></th>
                                    <th class='no-border'>Account Name</th>
                                    <th class='no-border'>Billing City</th>
                                    <th class='no-border'>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($Salesforce_Records as $ci=>$crow) {?>
                                <tr>
                                	<td class='no-border'><input type="checkbox" value="<?php echo $crow->ID;?>" name="recids[]" class="rcselect" /></td>
                                    <td class='no-border'><?php echo $crow->Name;?></td>
                                    <td class='no-border'><?php echo $crow->BillingCity;?></td>
                                    <td class='no-border'><?php echo $crow->Phone;?></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <?php }?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <div class="fluid" style="margin-top:15px;">
                            <?php if(!$sflogin) {?>
                            <a href="<?php echo base_url();?>crm/salesforce/login/a" class="buttonM bBlue">Connect to Salesforce</a>
                            <?php } else if($Salesforce_Records){?>
                            <input type="submit" class="buttonM bBlue" name="btn_rcimport" id="btn_rcimport" value="Import Records" /> 
                            <input type="submit" class="buttonM bBlue" name="btn_disconnect" value="Disconnect" />                            
                            <?php }?>
                            <a href="<?php echo base_url();?>crm/<?php echo $parent_section;?>" class="buttonM bRed">Back</a>
                        </div>		
                    </td>
                </tr>
            </table>
        </form>
        <?php }?>
        
        <?php }?>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
    var doProcess = 0;
	//Check file
	function save_record(){
		if($("#import_file").val().length==0) {
			alert("Browse file");
			$("#import_file").focus();
			return false;
		}
		return true;
	}
	//Check fields mapping
	function save_record2(){
		var c=0;
		$(".tbcol").each(function(){
			if($(this).val()!="") {c=1;return;}
		});
		if(c==0) {
			alert("Select <?php echo $crmlite;?> fields.");
			return false;
		}
		return true;
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


    //Check fields mapping and import into db
    function save_accounts_imported(){
        var c=0;
        $(".tbcol").each(function(){
            if($(this).val()!="") {c=1;return;}
        });
        if(c==0) {
            alert("Select account fields.");
            return false;
        }
        $(".cistatus").html('');
        repeat_saving_accounts_imported();
        return false;
    }

    //Do loop for Saving accounta Import
    function repeat_saving_accounts_imported(){
        if(doProcess==1) {
            alert("Accounts importing inprocess");
            return false;
        }

        $(".loader").html('');        
        var c=0;
        $(".tbcol").each(function(){
            if($(this).val()!="") {c=1;return;}
        });
        if(c==0) {
            alert("Select account fields.");
            return false;
        }
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');

        $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/save_accounts_imported');?>",
          cache: false,
          dataType: 'json',
          data: $('#frmAccountsImport').serialize(),
            }).done(function( resp ) {
                $(".loader").html('');
                if(resp.status==true) {
                    $(".aistatus").html(resp.msg);
                    if(resp.completed!=1) repeat_saving_accounts_imported();
                }
                else if(resp.status==false) {
                    alert(resp.msg);
                    return;
                } else {
                    alert( "Unable to process, please try again" );        
                }
                //alert('concept inprocess');
          })
          .fail(function() {
            $(".loader").html('');
            alert( "Unable to process, please try again" );
          });
    }
	
	$(document).ready(function(){
		$(".tbcol").change(function(){
			var dis=$(this);
			if(dis.val()=="") return;
			var sval = dis.val();
			var c=0;
			$(".tbcol").each(function(){
				if($(this).val()==sval) c++;
			});
			if(c>=2) {
				dis.val("");
				dis.parent().find("span").text("Select");
				alert("Field already selected.");
			}
		});
		//Select/Deselect import records
		$("#selectall").change(function(){
			$(".rcselect").prop("checked",$(this).prop("checked"));
		});
		//Import Records
		$("#btn_rcimport").click(function(){
			if($(".rcselect:checked").length==0) {
				alert("Select records");
				return false;
			}
			return true;
		});
	});	var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/Znuv1QvHcsc" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
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