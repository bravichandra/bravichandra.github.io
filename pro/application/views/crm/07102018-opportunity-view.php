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
		$("#close_date").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
	});
	var ectrl;
	var ebox;
	
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
					if(ebox=="private") $("#private").prop('checked',responce.cinfo=="1"?true:false);
					else if(ebox=="amount") {
						$(".eamount").html(responce.cinfo);
					} else ectrl.html(responce.cinfo);
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
			popboxhead = 'Opportunity Owner';
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
		$("#"+objname+"_id").val($(dis).attr("data_id"));
		$("#cLookup").hide();
	}
</script>
<div class="overlayBackground" onclick="hide_fade()"></div>
<div id="content">
	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/crm_nav');
	//$stages= array("Prospecting","Qualification","Needs Analysis","Value Proposition","Id. Decision Makers","Perception Analysis","Proposal/Price Quote","Negotiation/Review","Closed Won","Closed Lost");
	?>
    <div class="formRow crmlite" id="cLookup">
        <div class="qrbox">
            <div class="abox1">Account Lookup</div>
            <div class="abox2"><a href="javascript:void(0)" onclick="$('#cLookup').hide();"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />
        </div>
        <div class="search-list"></div>
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
                            <div class="box box_amount" title="Amount">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Amount</th><td class="two"><input type="text" value="<?php if(isset($record[amount]) && $record[amount]) echo form_prep($record[amount])?>" name="record[amount]" /></td
                                    ></tr>
                                </table>
                            </div>
                            <div class="box box_order_number" title="Order Number">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Order Number</th><td class="two"><input type="text" value="<?php if(isset($record[order_number])) echo form_prep($record[order_number])?>" name="record[order_number]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_private" title="Private">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Private</th><td class="two"><input type="checkbox" value="1" <?php if(isset($record[user_private]) && $record[user_private]) echo ' checked="checked"'?> name="record[user_private]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_main_competitor" title="Main Competitor(s)">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Main Competitor(s)</th><td class="two"><input type="text" value="<?php if(isset($record[main_competitor])) echo form_prep($record[main_competitor])?>" name="record[main_competitor]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_oppt_name" title="Opportunity Name">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Opportunity Name</th><td class="two"><input type="text" value="<?php if(isset($record[oppt_name])) echo form_prep($record[oppt_name])?>" name="record[oppt_name]" id="oppt_name" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_close_date" title="Close Date">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Close Date</th><td class="two"><input type="text" value="<?php if(isset($record[close_date])) echo form_prep($record[close_date])?>" name="record[close_date]" id="close_date" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_cur_generators" title="Current Generator(s)">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Current Generator(s)</th><td class="two"><input type="text" value="<?php if(isset($record[cur_generators])) echo form_prep($record[cur_generators])?>" name="record[cur_generators]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_account_id" title="Account Name">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Account Name</th><td class="two">
                                        <input type="hidden" value="<?php if(isset($record[account_id])) echo form_prep($record[account_id])?>" name="record[account_id]" id="account_id" />
                                        <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_title" />
                                        </td>
                                        <td><a href="javascript:void(0);" onclick="Records_getLookup('account','account');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a>
                                        </td>
                                    </tr>    
                                </table>
                            </div>
                            <div class="box box_next_step" title="Next Step">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Next Step</th><td class="two"><input type="text" value="<?php if(isset($record[next_step])) echo form_prep($record[next_step])?>" name="record[next_step]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_delivery_status" title="Delivery/Installation Status">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Delivery/Installation Status</th><td class="two">
                                        <select name="record[delivery_status]">
                                            <option value="">None</option>
                                            <option value="In progress"<?php if(isset($record[delivery_status]) && $record[delivery_status]=="In progress") echo ' selected="selected"'?>>In progress</option>
                                            <option value="Yet to begin"<?php if(isset($record[delivery_status]) && $record[delivery_status]=="Yet to begin") echo ' selected="selected"'?>>Yet to begin</option>
                                            <option value="Completed"<?php if(isset($record[delivery_status]) && $record[delivery_status]=="Completed") echo ' selected="selected"'?>>Completed</option>
                                        </select>
                                        </td>
                                    </tr>   
                                </table>
                            </div>
                            <div class="box box_oppt_type" title="Type">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Type</th><td class="two">
                                        <select name="record[oppt_type]">
                                            <option value="">None</option>
                                            <option value="Existing Customer - Upgrade"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="Existing Customer - Upgrade") echo ' selected="selected"'?>>Existing Customer - Upgrade</option>
                                            <option value="Existing Customer - Replacement"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="Existing Customer - Replacement") echo ' selected="selected"'?>>Existing Customer - Replacement</option>
                                            <option value="Existing Customer - Downgrade"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="Existing Customer - Downgrade") echo ' selected="selected"'?>>Existing Customer - Downgrade</option>
                                            <option value="New Customer"<?php if(isset($record[oppt_type]) && $record[oppt_type]=="New Customer") echo ' selected="selected"'?>>New Customer</option>
                                        </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_stage" title="Stage">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Stage</th><td class="two">
                                        <select name="record[stage]" id="stage">
                                            <?php foreach($stage as $aval){?>
                  								  <option value="<?php echo $aval;?>"<?php if(isset($record[stage]) && $record[stage]==$aval) echo ' selected="selected"'?>><?php echo $aval;?></option>
                    						<?php }?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_track_number" title="Tracking Number">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Tracking Number</th><td class="two"><input type="text" value="<?php if(isset($record[track_number])) echo form_prep($record[track_number])?>" name="record[track_number]" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_lead_source" title="Lead Source">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Lead Source</th><td class="two"><select name="record[lead_source]">
                                         <option value="">None</option>
                                            <?php	foreach($lead as $led){ ?>
                 								<option value="<?php echo $led ?>"<?php $sel='';if(isset($record[lead_source]) && $record[lead_source]==$led) echo $sel=' selected="selected"'?>><?php echo $led; ?></option>
				<?php }  ?>
                                        </select></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="box box_probability" title="Probability">
                            	<table cellpadding="0" cellspacing="0" border="0">
                                	<tr>
                                        <th class="one">Probability (%)</th><td class="two"><input type="text" value="<?php if(isset($record[probability]) && $record[probability]) echo form_prep($record[probability])?>" name="record[probability]" /></td>
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
    <div class="main-wrapper crmlite"><?php /*?>
    	<div class="crm-menu">
            <a href="<?php echo base_url();?>crm/opportunities" class="buttonM bBlack">Back</a>        
            <a href="<?php echo base_url();?>crm/opportunities/edit/<?php echo $record[oppt_id]?>" class="buttonM bBlack">Edit</a> 
            <a href="<?php echo base_url();?>crm/opportunities/delete/<?php echo $record[oppt_id]?>" onclick="if(!confirm('Are you sure you want to delete this opportunity?')) return false;" class="buttonM bBlack">Delete</a>   
        </div><?php */?>
        <div class="crm-menu"> 
            <div style="float: left;margin-bottom: 18px;">
              <a href="<?php echo base_url();?>crm/opportunities" class="buttonM bBlack">Back</a>        
                <a href="<?php echo base_url();?>crm/opportunities/edit/<?php echo $record[oppt_id]?>" class="buttonM bBlack">Edit</a> 
                <a href="<?php echo base_url();?>crm/opportunities/delete/<?php echo $record[oppt_id]?>" 
                onclick="if(!confirm('Are you sure you want to delete this opportunity?')) return false;" class="buttonM bBlack">Delete</a>                
            </div>
            <div align="center" style="float:right;">  
                <a href="<?php echo base_url();?>crm/interaction/opportunities/<?php echo $record[oppt_id]?>" class="buttonM bRed">Log an Interaction</a>     
                <a href="<?php echo base_url();?>crm/qualifier/opportunities/<?php echo $record[oppt_id]?>" class="buttonM bRed">Prospect Qualifier</a>
            </div>
        </div>
		<!-- Main content -->
		<table cellpadding="0" cellspacing="0" border="0" style="width:95%;background: none repeat scroll 0 0 #f8f8f8;" align="center" class="contact-list view">
            <tbody>
                <tr>
                	<th class="one">Opportunity Owner</th><td class="two"><?php echo $record[share_user_title]?></td><td class="gap"></td>
                    <th class="one">Amount</th><td class="two edtable eamount" data-field="amount"><?php if($record[amount])echo '$'.number_format($record[amount])?></td><td class="gap"></td>	                    
                    <th class="one">Order Number</th><td class="two edtable" data-field="order_number"><?php echo $record[order_number]?></td>
                </tr>
                <tr>
                	<th class="one">Private</th><td class="two edtable" data-field="private"><input type="checkbox" id="private" disabled="disabled" <?php if($record[user_private]) echo ' checked="checked"'?> /></td><td class="gap"></td>
                    <th class="one">Expected Revenue</th><td class="two edtable eamount" data-field="amount"><?php if($record[amount])echo '$'.$record[amount]?></td><td class="gap"></td>                    
                    <th class="one">Main Competitor(s)</th><td class="two edtable" data-field="main_competitor"><?php echo $record[main_competitor]?></td>
                </tr>
                <tr>
                	<th class="one">Opportunity Name</th><td class="two edtable" data-field="oppt_name"><?php echo $record[oppt_name]?></td><td class="gap"></td>
                    <th class="one">Close Date</th><td class="two edtable" data-field="close_date"><?php echo $record[close_date]?></td><td class="gap"></td>
                    <th class="one">Current Generator(s)</th><td class="two edtable" data-field="cur_generators"><?php echo $record[cur_generators]?></td>
                </tr>
                <tr>
                	<th class="one">Account Name</th><td class="two edtable" data-field="account_id"><?php if($record[account_id]){ ?><a href="<?php echo base_url('crm/accounts/view').'/'. $record[account_id]; ?>"><?php echo $record[account_title]?></a><?php } ?></td><td class="gap"></td>
                      <th class="one">Contact</th><td class="two" data-field="contact_id" ><?php if($record[contact_id]){?><a href="<?php echo base_url('crm/contacts/view').'/'.$record[contact_id]; ?>"><?php echo $record[user_first]." ".$record[user_last]?><?php }?></td><td class="gap"></td>
                    <th class="one">Delivery/Installation Status</th><td class="two edtable" data-field="delivery_status"><?php echo $record[delivery_status]?></td>
                </tr>
                <tr>
                	<th class="one">Type</th><td class="two edtable" data-field="oppt_type"><?php echo $record[oppt_type]?></td><td class="gap"></td>
                    <th class="one">Stage</th><td class="two edtable" data-field="stage"><?php echo $record[stage]?></td><td class="gap"></td>
                    <th class="one">Tracking Number</th><td class="two edtable" data-field="track_number"><?php echo $record[track_number]?></td>
                </tr>
                <tr>
                	<th class="one">Lead Source</th><td class="two edtable" data-field="lead_source"><?php echo $record[lead_source]?></td><td class="gap"></td>
                    <th class="one">Probability</th><td class="two edtable" data-field="probability"><?php if($record[probability])echo $record[probability].'%'?></td><td class="gap"></td>
                    <th class="one">Created</th><td class="two"><?php echo date("m/d/Y",strtotime($record[create_date]))?></td>
                </tr>
                <tr>
                    <th class="one">Next Step</th><td class="two edtable" data-field="next_step"><?php echo $record[next_step]?></td><td class="gap"></td>            	
                    <th class="one">Primary Campaign Source</th><td class="two">&nbsp;</td><td class="gap"></td>
                    <th class="one">Last Modified</th><td class="two"><?php echo date("m/d/Y",strtotime($record[modify_date]))?></td>
                </tr>
                <tr>
                	<th class="one">Description</th><td class="two edtable" data-field="description" colspan="7"><?php echo str_replace("\n","<br>",$record[description])?></td>
                    
                </tr>
            </tbody>
        </table>  
        
        <?php /*?><div class="title-bar"><h2>Notes</h2> <a href="<?php echo base_url('crm/notes/opportunities/'.$record[oppt_id]);?>">View All</a> <a href="<?php echo base_url('crm/notes/opportunities/'.$record[oppt_id].'/edit');?>">New</a></div>
        <div>
        	<?php $this->load->view('crm/notes-list-few');?>
        </div><?php */?>
        
        <hr />
         
         
          <?php //echo $total_points; ?>

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
        
        google.charts.load('current', {packages: ['corechart']});
        
        //google.charts.setOnLoadCallback(drawLineColors);
        
        var sTE=1;
        //sTE = <?php echo $sTE;?>;
        
        function drawLineColors() {
        
              var data = new google.visualization.DataTable();
        
              data.addColumn('date', 'X');
        
              data.addColumn('number', 'Quality Points');
        
              data.addColumn('number', 'Pursuit Points');
        
              data.addRows(graphData);	
        
              if($("#chartfilter").val()=="7") lfromat="d-MMM-yyyy";
              else lfromat="d-MMM";  
        
              /*var gDL=graphData.length;	  
        
              var sTE=1;
        
              if($("#chartfilter").val()=="2") {
        
                if(gDL>15) sTE=3;
        
              } else if($("#chartfilter").val()=="1" || $("#chartfilter").val()=="3") sTE=3;
        
              else if($("#chartfilter").val()=="4") sTE=15;
        
              else if($("#chartfilter").val()=="5") sTE=15;
        
              else if($("#chartfilter").val()=="6") sTE=30;
              else if($("#chartfilter").val()=="7") sTE=30;*/
        
        
        
              var options = {
        
                hAxis: {
        
                  title: 'Date',
                  format: lfromat,
                  gridlines: {color:'none'}
                  //showTextEvery : sTE
        
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
        
                    data: 'gft='+val+'&cid=<?php echo $record[oppt_id]?>&action=graph',
        
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
        <div class="opportunit-childs"></div>   
        
	</div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<script type="text/javascript">
   //get Mailchimp inf
    function getOpportunityChilds(){
		//alert("Test123123");
        $(".opportunity-childs").html('');
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          data: 'ccblock=opportunitychilds'
            }).done(function( resp ) {
				//alert(resp);
                $(".opportunit-childs").html(resp);
          })
          .fail(function() {
            $(".opportunit-childs").html('');
          });
        return false;
    }
    $(document).ready(function(){
        getOpportunityChilds();
    });    
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>
