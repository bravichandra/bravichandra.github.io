<?php $this->load->view('common/meta'); ?>  
<?php $this->load->view('common/header'); ?>
<style type="text/css">
	.crmlite th {
		text-align: center;
		padding: 8px 0px;
	}
	.tDefault tbody td {
		padding: 4px;
		vertical-align: middle;
		text-align: center;
	}
	th#ERcol7 {
		width: 106px !important;
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

    
    <!-- LIST POPUP -->
    <div id="crmlistpopup">
        <div class="formRow" style="border-bottom: 1px solid #999999 !important;">
            <div class="qrbox">
                <div class="abox1"><span>Add to List</span></div>
                <div class="abox2"><a href="javascript:void(0)" onclick="hide_catlist()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
            </div>            
            <form action="<?php echo current_url();?>" id="frmCatg" method="post">
                <input type="hidden" name="action" id="ecatlist" value="ereportrectolist" />
                <input type="hidden" name="catrecids" id="catrecids" value="" />
                <div id="gh_anbox">
                    <div>
                        <div class="qebox">
                            <div class="erbox"></div>
                            <div class="box" title="List" id="catglist" style="height: 200px;overflow-y: scroll;">
                                <?php foreach($catlist as $crow)    {?>
                                <div>
                                    <input type="checkbox" value="<?php echo $crow->id;?>" class="catlist" name="record[catg][]"/> <?php echo $crow->name;?>
                                </div>
                                <?php }?>
                            </div><br clear="all">
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
   
    <!-- Main content -->    
    <div class="main-wrapper crmlite">    	
		<!-- Main content -->
        <div class="quatabs nopadding">
            <div><a href="<?php echo base_url('crm/report')?>">Interaction Reports</a></div>
            <div class="active"><a href="<?php echo base_url('crm/ereport')?>">Email Reports</a></div>
            <div><a href="<?php echo base_url('crm/objections')?>">Objections</a></div>
            <div><a href="<?php echo base_url('crm/sreport')?>">Sales Reports</a></div>
            <div><a href="<?php echo base_url('crm/prospect')?>">Prospect Points</a></div>
        </div> 
        <form method="post" id="frm_qualifier" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" id="action" value="report" />
            <input type="hidden" id="epoints" name="record[cat]" value="2" />
            <input type="hidden" id="erpdone" name="record[erpdone]" value="0" />
            <input type="hidden" id="erptotal" name="record[erptotal]" value="0" />
            <table cellpadding="0" cellspacing="0" style="width:100%;background: none repeat scroll 0 0 #f8f8f8;" border="0" class="contact-edit interact">
                <tr>
                <th class="one">User*</th><td class="two">
                    <select name="record[user]" id="user">	
                        <option value="">All</option> 
                        <?php foreach($shared_users as $user){?>
                        <option value="<?php echo $user->user_id;?>"<?php if($record['user']==$user->user_id) echo ' selected="selected"'?>>
                        <?php echo ucfirst($user->usrname);?></option>
                        <?php } ?>
                    </select> 
                    </td>
                </tr>            
                <tr style="border-bottom:0px;"  id="sdates">
                    <th class="one">Date From*</th>
                    <td class="two">
                    <input type="text" value="<?php echo ($record[ifdate]?$record[ifdate]:date("m/d/Y"));?>" name="record[ifdate]" id="ifdate" class="idate" /> 
                    To: <input type="text" value="<?php echo ($record[itdate]?$record[itdate]:date("m/d/Y"));?>" name="record[itdate]" id="itdate" class="idate" />
                    </td>
                </tr>
                <tr>
                    <th class="one">Email Filter*</th>
                    <td class="two">
                        <select name="record[efilter]" id="efilter" onchange="emailFilter(this.value)">
                            <option value="">Select</option>                    
                            <option value="2-1-1"<?php if($record['efilter']=="2-1-1") echo ' selected="selected"'?>>Emails Sent</option>
                            <option value="2-1-5"<?php if($record['efilter']=="2-1-5") echo ' selected="selected"'?>>Emails Opened</option>
                            <option value="2-1-7"<?php if($record['efilter']=="2-1-7") echo ' selected="selected"'?>>Emails Clicked</option>
                            <option value="escheduled"<?php if($record['efilter']=="escheduled") echo ' selected="selected"'?>>Emails Scheduled</option>
                            <option value="unsubscribes"<?php if($record['efilter']=="unsubscribes") echo ' selected="selected"'?>>Unsubscribes</option>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <th class="one esubject" style="width:264px; display:none;">Email Subject Line</th><td class="two esubject" style="display:none;">
                    <select name="record[subject]" id="subject">  
                        <option value="">All</option>
                        <?php 
                            $allsubjects = "@#@";
                            foreach($email_subjects as $usubjects){
                                foreach($usubjects as $subj){
                                    if(strpos($allsubjects, "@#@".$subj."@#@")!==FALSE) continue;
                                    $allsubjects .= $subj."@#@";
                        ?>
                        <option value="<?php echo $subj;?>"<?php if($record['subject']==$subj) echo ' selected="selected"'?>><?php echo $subj;?></option>
                        <?php } }?>
                    </select> 
                    </td>
                </tr> 
                <tr>
                    <td colspan="2" align="center">
                        <div class="fluid" style="margin-top:15px;">
                            <span class="loader"></span>
                            <input type="submit" class="buttonM bBlue" style="display: none;" name="form_submit" value="Run Report" />
                            <a href="javascript:void(0);" style="display: none;" onclick="stop_report()" class="buttonM bBlack stopreport">Stop Report</a>
                            <a href="javascript:void(0);" style="display: none;" onclick="catlist_popup()" class="buttonM bBlack addtolist">Add to List</a>
    
                            <input type="button" class="buttonM bBlue" onclick="getEmailReportStatus()" name="btn_report" id="btn_report" value="Run Report" />
    
                            <div class="crm-error"></div>
                        </div>
                    </td>
                </tr>
                <tr> 
                    <td colspan="2" align="center">
                        <?php if(isset($ereportcounts) && $ereportcounts) {?>
                        <div align="left">
                            <h2>STATS:</h2>
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <th>Emails Sent:</th>
                                    <td><?php if($ereportcounts['s']) echo number_format($ereportcounts['s'][0]->ic); else echo "0";?></td>
                                </tr>
                                <tr>
                                    <th>Emails Opened:</th>
                                    <td><?php if($ereportcounts['v']) echo number_format($ereportcounts['v'][0]->ic); else echo "0";?></td>
                                </tr>
                                <tr>
                                    <th>Open Rate:</th>
                                    <td><?php if($ereportcounts['v']) echo round(($ereportcounts['v'][0]->ic/$ereportcounts['s'][0]->ic)*100,2).'%'; else echo "N/A"?></td>
                                </tr>
                                <tr>
                                    <th>Clicks:</th>
                                    <td><?php if($ereportcounts['c']) echo number_format($ereportcounts['c'][0]->ic); else echo "0";?></td>
                                </tr>
                                <tr>
                                    <th>Click-Through Rate:</th>
                                    <td><?php if($ereportcounts['c']) echo round(($ereportcounts['c'][0]->ic/$ereportcounts['v'][0]->ic)*100,2).'%'; else echo "N/A"?></td>
                                </tr>
                            </table>
                            <hr>
                        </div>
                        <?php }?>
                        <div class="emailReportStatus"></div>
                        <?php if(isset($contacts) && $contacts) {?>                    
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="emailReports">
                            <tr>
                                <th width="2%"><input type="checkbox" id="selectallc" /></th>
                                <th width="13%">Contact Name</th>
                                <th width="13%">Account</th>
                                <th width="7%">Phone</th>
                                <th width="15%">Email Address</th>
                                <th width="20%">Subject Line</th>
                                <?php if($record['efilter']=='escheduled') { ?>
                                <th style="width:130px;">Date Scheduled</th>
                                <?php } else { ?>
                                <th style="width:130px;"><?php echo ($record['efilter']=="2-1-7"?'URL Clicked':'Template Name')?></th>
                                <?php } ?>
                            </tr>
                            <?php 
                                $contact_id=0;
                                $trdata = '';
                                foreach($contacts as $ni=>$contact) {
                                    $einfo = array();
                                    if($contact->intr_info){
                                        $einfo = json_decode($contact->intr_info);
                                    }
                                    if($contact_id<>$contact->intr_recid) {
                                        if($ni>0) $trdata .= '</td></tr>';
                                        $trdata .= '<tr>
                                            <th><input type="checkbox" value="'.$contact->intr_recid.'"  name="recids[]" class="rcselect"/></th>
                                            <td><a href="'.base_url('crm/contacts/view').'/'.$contact->intr_recid.'">'.ucfirst($contact->user_first.' '.$contact->user_last).'</a></td>                                        <td>';
                                        if($contact->account_id) {
                                            $trdata .= '<a href="'.base_url('crm/accounts/view').'/'.$contact->account_id.'">'.ucfirst($contact->account_name).'</a>';
                                        }
                                        $trdata .= '</td>';
                                        $trdata .= '<td>'.($contact->phone?'<a href="tel:'.$contact->phone.'">'.$contact->phone.'</a>':'').'</td>';
                                        $trdata .= '<td>'.($contact->email?'<a href="mailto:'.$contact->email.'">'.$contact->email.'</a>':'').'</td>';
                                        if($record['efilter']!="unsubscribes")
                                        {
                                            $trdata .= '<td>';
                                            $esinfo = array();
                                            if($contact->intr_info){
                                                $esinfo = json_decode($contact->intr_info);
                                                if(isset($esinfo->subjects)) {
                                                    $esubjects = (array)$esinfo->subjects;
                                                    $trdata .= implode('<br>',$esubjects);
                                                }                                   
                                            }
                                            
                                            $trdata .= '</td>';
                                        }
                                        $trdata .= '<td>';
                                    }		
                                    
                                    if($einfo) {									
                                        if($record['efilter']=="2-1-7")	{
                                            $einfo = $einfo->elinks;
                                            foreach($einfo as $elink) $trdata .= '<a href="'.$elink.'" target="_blank">'.$elink.'</a><br>';
                                        } else $trdata .= implode('<br>',$einfo->tnames);
                                    }									
                                }
                                if($contacts) $trdata .= '</td></tr>';
                                echo $trdata;
                            ?>                        
                        </table>
                        <?php }?>
                        <?php if(isset($contacts) && !$contacts) {?>
                        <b>No records found.</b>
                        <?php }?>
    
                        
                    </td>
                </tr>                        
            </table>
        </form>

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class='tDefault' id="emailReports_2">
            <thead>
            	<tr>
                	<td colspan="7">
                    	<div id="delete_sch" style="width:165px; display:none;" >
                        	<a href="javascript:void(0);" onclick="delete_semails()" class="buttonM bBlack addtolist">Delete Scheduled Emails</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th width="2%"><input type="checkbox" id="selectallc" /></th>
                    <th width="13%">Contact Name</th>
                    <th width="13%">Account</th>
                    <th width="7%">Phone</th>
                    <th width="15%">Email Address</th>
                    <th width="20%" class="usubject">Subject Line</th>                    
                    <th style="width:130px !important;" id="ERcol7" class="ulink">Date Sent</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

	</div>
    <!-- Main content ends -->
</div>
<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    var prntTable;
    $(document).ready(function(){
        $('.idate').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
            $(this).datepicker('hide');
        });
        /*Category List*/
        $("#selectallc").change(function(){
            $(".rcselect").prop("checked",$(this).prop("checked"));
        });
        prntTable = $('#emailReports_2').DataTable({"iDisplayLength": 50,"lengthMenu": [ 10, 25, 50, 75, 100,200,500,1000 ]});
    });
    //Skip hint 
    function save_record(){
        $(".loader").html('');
        var er=0;
       /* if($('#user').val()=="") {
            alert("Select user");
            $('#user').focus();
            return false;
        }  */      
        if($('#ifdate').val()=="") {
            alert("Select from date");
            $('#ifdate').focus();
            return false;
        }
        if($('#itdate').val()=="") {
            alert("Select to date");
            $('#itdate').focus();
            return false;
        }
        if($('#efilter').val()=="") {
            alert("Select email filter");
            $('#efilter').focus();
            return false;
        }
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');      
        return true;
    }

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
        if($(".catlist:checked").length==0) {
            alert("Select lists");
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
                alert(responce);
                hide_catlist();
                //location.replace("<?php echo current_url();?>");
            }
        });
    }
    /*Category List*/
    //Stop report
    function stop_report() {
        if(ajtimer) clearTimeout(ajtimer);
        if(doProcess) ajrequest.abort();
        $(".stopreport").hide();
        $(".crm-error").html('');
    }
	
	
	function delete_semails()
	{
		var emailFilter = $("#efilter").val();
		if(emailFilter=='escheduled')
		{
			if($(".rcselect:checked").length==0) {
				alert("Select records");
				return false;
			}
			var recids = '';
			var j=0;
			$(".rcselect:checked").each(function(){
				if(recids) recids += ',';
				recids += $(this).val();
				j=j+1;
				
			});
			 $.ajax({
				type : 'POST',
				url : '<?php echo base_url('crmbeta/deleteSEmails');?>',
				data: 'rcid='+recids,
				cache: false,
				success: function(responce)
				{
					alert(j+" Scheduled Emails Deleted Successfully");
					location.replace("<?php echo current_url();?>");
				}
			});
		}
	}
	
	function emailFilterold(dis)
	{
		if(dis=='escheduled')
		{
			$("#uniform-subject").hide();
			$('.esubject').html("");
		}
		else
		{
			$("#uniform-subject").show();
			$('.esubject').html("Email Subject line");
		}
	}
	
	function emailFilter(dis)
	{
		var action = "";
		var suser = $("#user").val();
		if(dis=='2-1-1' || dis=='2-1-5' || dis=='2-1-7') action = 'Emails';
		else if(dis=='escheduled') action = 'Scheduled';
		else if(dis=='unsubscribes') action = 'Unsubscribes';
		var ifdate = $("#ifdate").val();
		var itdate = $("#itdate").val();
		$.ajax({
			type : 'POST',
			url : '<?php echo base_url('crmbeta/getallSubjectsEmails');?>',
			data: 'action='+action+'&uid='+suser+'&ifdate='+ifdate+'&itdate='+itdate+'&ename='+dis,
			cache: false,
			success: function(response)
			{
			   $('#subject').html('');
			   if(response){
			    jq_json_obj = $.parseJSON(response);
				if(typeof jq_json_obj == 'object'){ //Test if variable is a [JSON] object
					obj = eval (jq_json_obj); 			
					//Convert back to an array
					jq_array = [];
					$('#subject').find('option').not(':first').remove();
					$('#subject').append('<option value="">All</option>');
					for (var prop in obj) {
					  if (obj.hasOwnProperty(prop)) {
					  console.log(obj[prop]); 
					  $('#subject').append('<option value="'+obj[prop]+'">'+obj[prop]+'</option>');
					  }
					}
				  }else{
					console.log("Error occurred!"); 
				  }
				}
			}
		});
		if(dis=='escheduled')
		{
			$("#sdates").hide();
			$(".esubject").show();
		}
		else if(dis=='unsubscribes')
		{			
			$("#sdates").show();
			$(".esubject").hide();
		}
		else if(dis=='2-1-7')
		{
			$(".esubject").hide();
			$("#sdates").show();
		}
		else 
		{
			$("#sdates").show();
			$(".esubject").show();
		}
	}
	
	
    //Email report report status
    function getEmailReportStatus() {
        if(ajtimer) clearTimeout(ajtimer);
        if(doProcess) ajrequest.abort();
        prntTable.clear().draw();
        $(".addtolist").hide();
        if(save_record()==false) return;        
        $(".crm-error").html('');
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        $(".ERcol7").html($("#efilter").val()=="2-1-7"?'URL Clicked':'Template Name');
        doProcess = 1;
        ajrequest = $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/EmailReportStatus');?>",
          cache: false,
          dataType: 'json',
          data: $("#frm_qualifier").serialize(),
            }).done(function( resp ) {
                doProcess = 0;
                $(".loader").html('');                
                if(resp.status==true) {
                    $("#erpdone").val(0);
                    $("#erptotal").val(0);
                    $(".emailReportStatus").html(resp.msg);
                    if(resp.total>0) {
                        $("#erptotal").val(resp.total);
                        $(".stopreport").show();
                        getEmailReport();
                    }
                }
                else if(resp.status==false) {
                    $(".crm-error").html(resp.msg);
                    return;
                } else {
                    alert( "Unable to process, please try again" );        
                }
          })
          .fail(function() {
            doProcess = 0;
            $(".loader").html('');
            alert( "Unable to process, please try again" );
          });
    }
    //Get email reports
    
    var doProcess = 0;
    var ajrequest;
    var ajtimer;
	
	function getEmailReport() {
        ajtimer=false;
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        doProcess = 1;
        ajrequest = $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/EmailReports');?>",
          cache: false,
          dataType: 'json',
          data: $("#frm_qualifier").serialize(),
            }).done(function( resp ) {
                doProcess = 0;
                $(".loader").html(''); 
                $(".crm-error").html(resp.msg);               
                if(resp.status==true) {
                    if(resp.type=='escheduled') {
					   $("#ERcol7").html("Date Scheduled");
                       $("#delete_sch").show(); 
                       $(".usubject").show();   
                    }
                    else if(resp.type=='unsubscribes') {
                       $("#delete_sch").hide();  
                       $(".usubject").hide(); 
					   $("#ERcol7").html("Date Sent");
                    }
                    else {
                        $("#delete_sch").hide(); 
                        $(".usubject").show(); 
						$("#ERcol7").html("Date Sent");
                    }
                    prntTable.rows.add(resp.trs).draw();
                    $(".crm-error").html(resp.msg); 
                    if(resp.completed!=1){
                        $("#erpdone").val(resp.done);
                        ajtimer = setTimeout(getEmailReport, 5000);
                    } else {$(".addtolist").show();$(".stopreport").hide();}
                }
                //alert('concept inprocess');
          })
          .fail(function() {
            doProcess = 0;
            $(".loader").html('');
            $(".stopreport").hide();
            //alert( "Unable to process, please try again" );
            //setTimeout(do_emailverify, 4000);
          });
    }
	
    function getEmailReportold() {
        ajtimer=false;
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        doProcess = 1;
        ajrequest = $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/EmailReports');?>",
          cache: false,
          dataType: 'json',
          data: $("#frm_qualifier").serialize(),
            }).done(function( resp ) {
                doProcess = 0;
                $(".loader").html(''); 
                $(".crm-error").html(resp.msg);               
                if(resp.status==true) {
					if(resp.type=='escheduled') {
                       $("#delete_sch").show(); 
                       $(".usubject").show();   
                    }
                    else if(resp.type=='unsubscribes') {
                       $("#delete_sch").hide();  
                       $(".usubject").hide(); 
                    }
                    else {
                        $("#delete_sch").hide(); 
                        $(".usubject").show(); 
                    }
                    prntTable.rows.add(resp.trs).draw();
                    $(".crm-error").html(resp.msg); 
                    if(resp.completed!=1){
                        $("#erpdone").val(resp.done);
                        ajtimer = setTimeout(getEmailReport, 5000);
                    } else {$(".addtolist").show();$(".stopreport").hide();}
                }
                //alert('concept inprocess');
          })
          .fail(function() {
            doProcess = 0;
            $(".loader").html('');
            $(".stopreport").hide();
            //alert( "Unable to process, please try again" );
            //setTimeout(do_emailverify, 4000);
          });
    }
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>