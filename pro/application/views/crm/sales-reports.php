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

	<?php //if(isset($contacts) && $contacts) {?>
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
    <?php //}?>
	<!-- Main content -->    
    <div class="main-wrapper crmlite">    	
		<!-- Main content -->
        <div class="quatabs nopadding">
            <div><a href="<?php echo base_url('crm/report')?>">Interaction Reports</a></div>
            <div><a href="<?php echo base_url('crm/ereport')?>">Email Reports</a></div>
            <div><a href="<?php echo base_url('crm/objections')?>">Objections</a></div>
            <div class="active"><a href="<?php echo base_url('crm/sreport')?>">Sales Reports</a></div>
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
			
			<tr>
            <th class="one">All Stages</th>
			<td class="two">
                <select name="record[stage]" id="stage">	
					<option value="">All</option> 
                    <?php foreach($stage as $aval){?>
                    <option value="<?php echo $aval;?>"<?php if($record['stage']==$aval) echo ' selected="selected"'?>><?php echo $aval;?></option>
                    <?php } ?>
                </select> 
			</td>
            </tr>            
			          
            <tr style="border-bottom:0px;">
                <th class="one">Date From*</th>
                <td class="two">
                <input type="text" value="<?php echo ($record[ifdate]?$record[ifdate]:date("m/d/Y"));?>" name="record[ifdate]" id="ifdate" class="idate" /> 
                To: <input type="text" value="<?php echo ($record[itdate]?$record[itdate]:date("m/d/Y"));?>" name="record[itdate]" id="itdate" class="idate" />
                </td>
            </tr>
            
            <tr>
            	<td colspan="2" align="center">
                    <div class="fluid" style="margin-top:15px;">
                    	<span class="loader"></span>
                        <?php /*?><input type="submit" class="buttonM bBlue" style="display: none;" name="form_submit" value="Run Report" />
                        <a href="javascript:void(0);" style="display: none;" onclick="stop_report()" class="buttonM bBlack stopreport">Stop Report</a>
                        <a href="javascript:void(0);" style="display: none;" onclick="catlist_popup()" class="buttonM bBlack addtolist">Add to List</a>
<?php */?>
                        <input type="button" class="buttonM bBlue" onclick="getEmailReportStatus()" name="btn_report" id="btn_report" value="Run Report" />

                        <div class="crm-error"></div>
                    </div>
                </td>
            </tr>                                    
        </table>
        </form>

        <table cellpadding="0" cellspacing="0" border="0" width="100%" class='tDefault' id="emailReports_2">
            <thead>
			    <tr>
                    <th width="13%">Opportunity Owner</th>
                    <th width="13%">Contact</th>
                    <th width="7%">Account</th>
                    <th width="15%">Amount</th>
                    <th width="20%" class="usubject">Close Date</th>
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
		/*if($('#user').val()=="") {
			alert("Select user");
			$('#user').focus();
			return false;
		}*/		
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
	function emailFilter(dis)
	{
		if(dis=='escheduled' || dis=='unsubscribes')
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
    //Email report report status
    /*function getEmailReportStatus() {
        if(ajtimer) clearTimeout(ajtimer);
        if(doProcess) ajrequest.abort();
        prntTable.clear().draw();
        $(".addtolist").hide();
        if(save_record()==false) return;  
        $(".crm-error").html('');
        $(".loader").html('<img src="<?php //echo base_url();?>images/spinner.gif" />');
        $(".ERcol7").html($("#efilter").val()=="2-1-7"?'URL Clicked':'Template Name');
        doProcess = 1;
        ajrequest = $.ajax({
          type: "POST",
          url: "<?php //echo base_url('crmbeta/SaleReportStatus');?>",
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
    }*/
    //Get email reports
    
    var doProcess = 0;
    var ajrequest;
    var ajtimer;
    function getEmailReportStatus() {
        ajtimer=false;
        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        doProcess = 1;
        ajrequest = $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/SaleReportStatus');?>",
          cache: false,
          dataType: 'json',
          data: $("#frm_qualifier").serialize(),
            }).done(function( resp ) {
                doProcess = 0;
                $(".loader").html(''); 
                $(".crm-error").html(resp.msg);               
                if(resp.status==true) {
                    prntTable.rows.add(resp.trs).draw();
					if(resp.totalAmount>0) 
					{
						var x = resp.totalAmount;
						var tot = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						$("#emailReports_2").append('<tr id="emailReports_3" style="border-top:1px solid #000;"><th width="13%">&nbsp;</th><th width="13%">&nbsp;</th><th width="7%" style="font-weight:normal;text-align:right;">Total</th><th width="15%" class="totalAmount" style="font-weight:bold;padding:0px 4px;">$'+tot+'</th><th width="20%" class="usubject">&nbsp;</th></tr>');
					}
                    $(".crm-error").html(resp.msg); 
                    if(resp.completed!=1){
                        $("#erpdone").val(resp.done);
                        ajtimer = setTimeout(getEmailReportStatus, 5000);
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