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
    <div class="main-wrapper">
    	<div class="crmlite">
        <div class="title-bar" style="width: 900px;"> 
        		<a href="<?php echo base_url(); ?>interviewer/prospect/0-3-0" class="buttonM bBlack">All Applicants</a>                 
                <a href="<?php echo base_url(); ?>interviewer/prospect/1-3-0" class="buttonM bBlack">My Applicants</a> 
                <a href="<?php echo base_url(); ?>interviewer/prospect/2-3-0" class="buttonM bBlack">Target Applicants</a>
                 Stage:<select name="record[stage]" onchange="location.replace('<?php echo current_url();?>?stg='+this.value+'');">
                    <option value="">All</option>
                    <option value="Applied"<?php if($_GET['stg']=="Applied") echo $sel=' selected="selected"'?>>Applied</option>
                    <option value="Pre-Interview"<?php if($_GET['stg']=="Pre-Interview") echo $sel=' selected="selected"'?>>Pre-Interview</option>
                    <option value="Interview Round 1"<?php if($_GET['stg']=="Interview Round 1") echo $sel=' selected="selected"'?>>Interview Round 1</option>
                    <option value="Interview Round 2"<?php if($_GET['stg']=="Interview Round 2") echo $sel=' selected="selected"'?>>Interview Round 2</option>
                    <option value="Interview Round 3"<?php if( $_GET['stg']=="Interview Round 3") echo $sel=' selected="selected"'?>>Interview Round 3</option>
                    <option value="Offer Presented"<?php if($_GET['stg']=="Offer Presented") echo $sel=' selected="selected"'?>>Offer Presented</option>
                    <option value="Offer Accepted"<?php if($_GET['stg']=="Offer Accepted") echo $sel=' selected="selected"'?>>Offer Accepted</option>
                    <option value="Paperwork Processed"<?php if($_GET['stg']=="Paperwork Processed") echo $sel=' selected="selected"'?>>Paperwork Processed</option>
                    <option value="Converted to Employee"<?php if($_GET['stg']=="Converted to Employee") echo $sel=' selected="selected"'?>>Converted to Employee</option>
                    <option value="Disqualified"<?php if($_GET['stg']=="Disqualified") echo $sel=' selected="selected"'?>>Disqualified</option>
                </select>&nbsp;
                Job Applied For:<select name="record[job]" onchange="location.replace('<?php echo current_url();?>?job='+this.value+'');">
                    <option value="">All</option>
                     <?php   foreach($Jobs as $job ){?>
                     	<option value="<?php echo $job->job_applied_for; ?>"<?php if($_GET['job']== $job->job_applied_for) echo $jb=' selected="selected"'?>><?php echo $job->job_applied_for; ?></option>
                     <?php } ?>
                </select>
           </div>
        	<div style="width: 95%;position: absolute;margin-top: 40px;">   
            	<!-- <div style="width: 95%;" align="right">
            	<select onchange="location.replace('<?php echo base_url('interviewer/prospect');?>/'+this.value+'-<?php echo $oDays;?>-<?php echo $oCat;?>');">	
                    <option value="0" <?php if($oUsr==0) echo ' selected="selected"';?>>All Applicants</option>    
                    <option value="1"  <?php if($oUsr==1) echo ' selected="selected"';?>>My Applicants</option>
                    <option value="2"  <?php if($oUsr==2) echo ' selected="selected"';?>>Target Applicants</option>
                    
                </select>
                </div>  -->       
                <!--<div style="width: 95%;" align="right">
                    <select id="chartfilter" name="chartfilter" onchange="location.replace('<?php echo base_url('interviewer/prospect');?>/<?php echo $oUsr;?>-'+this.value+'-<?php echo $oCat;?>');">	
                        <?php /*?><option value="0">All</option><?php */?>
                        <option value="1" <?php if($oDays==1) echo ' selected="selected"';?>>Today</option>
                        <option value="2" <?php if($oDays==2) echo ' selected="selected"';?>>Last 7 Days</option>
                        <option value="3" <?php if($oDays==3) echo ' selected="selected"';?>>Last 30 Days</option>
                        <option value="4" <?php if($oDays==4) echo ' selected="selected"';?>>This Month</option>
                        <option value="5" <?php if($oDays==5) echo ' selected="selected"';?>>Last Month</option>
                        <option value="6" <?php if($oDays==6) echo ' selected="selected"';?>>Last 3 Months</option>
                        <option value="7" <?php if($oDays==7) echo ' selected="selected"';?>>Last 6 Months</option>
                        <option value="8" <?php if($oDays==8) echo ' selected="selected"';?>>Last Year</option>
                    </select>
                </div>-->
            </div>    
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:100%' class='tDefault pro-table'>
                <thead>
                    <tr>  
                        <th class='no-border'>Name</th>
                        <?php foreach($Quest_attr as $qcat) echo '<th class="no-border">'.str_replace('Requirements','',$qcat->cat_name).'</th>';?>
                        <th class='no-border'>Other</th>
                        <th class='no-border'>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 						
						foreach($dropdown_users as $prosp){?>
                    <tr>
                        <td class='no-border'><a href="<?php echo base_url(); ?>interviewer/applicant/view/<?php echo $prosp->contact_id;?>"><?php echo ucfirst($prosp->user_first.' '.$prosp->user_last);?></a></td>
                        <?php foreach($Quest_attr as $qcat) {$acat = 'cat'.$qcat->cat_id; echo '<td class="no-border">'.$prosp->{$acat}.'</td>';}?>
                        <td class='no-border'><?php echo $prosp->others;?></td>
                        <td class='no-border'><?php echo $prosp->qtotal;?></td>
                    </tr>
                    <?php  }?>
                </tbody>
            </table>
           <?php /*?> <div style="width: 95%;" align="right">
            	<select onchange="location.replace('<?php echo base_url('interviewer/prospect');?>/'+this.value+'-<?php echo $oDays;?>-<?php echo $oCat;?>');">	
                    <option value="0">All Users</option>
                    <?php foreach($dropdown_users as $prosp){?>
                    <option value="<?php echo $prosp->user_id;?>"<?php if($oUsr==$prosp->user_id) echo ' selected="selected"';?>><?php echo ucfirst($prosp->usrname);?></option>
                    <?php } ?>
                </select>
            </div><?php */?>
            <?php // $oDays= 3; ?>
           
<?php if($prospect_points) {?><br /><hr />   
			<!--<div align="center"><b>Quality Points</b></div>
            <div id="chart_divqp" style="height: 400px;"></div>-->
           <!-- <hr />
            <div align="center"><b>Pursuit Points</b></div>
            <div id="chart_divpp" style="height: 400px;"></div>-->
<script src="<?php echo base_url();?>js/chart-loader.js"></script>
<script type="text/javascript">
//var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
var graphData1 = <?php echo $chartData1;?>;
//console.log(graphData1);
var graphData2 = <?php echo $chartData2;?>;
google.charts.load('current', {packages: ['corechart', 'line']});
google.charts.setOnLoadCallback(drawLineColors);

	function drawLineColors() {
		  var data1 = new google.visualization.DataTable();
		  data1.addColumn('string', 'X');
		  var data2 = new google.visualization.DataTable();
		  data2.addColumn('string', 'X');
		  <?php foreach($prospect_points as $prosp) { //if($oUsr && $oUsr<>$prosp->user_id) continue;?>
		  data1.addColumn('number', "<?php echo ucfirst($prosp->usrname);?>");
		  data2.addColumn('number', "<?php echo ucfirst($prosp->usrname);?>");
		  <?php }?>	
		  //var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
		  data1.addRows(graphData1);
		  data2.addRows(graphData2);
		  <?php /*?>data.addRows([
			  ['2004', 1000, '1M$ sales in 2004', 400,  '$0.4M expenses in 2004'],
			  ['2005', 1170, '1.17M$ sales in 2005', 460, '$0.46M expenses in 2005'],
			  ['2006', 660,  '.66$ sales in 2006', 1120, '$1.12M expenses in 2006'],
			  ['2007', 1030, '1.03M$ sales in 2007', 540, '$0.54M expenses in 2007']
			]);<?php */?>
		  var gDL=graphData1.length;
		  <?php /*?>var sTE=1;
		  if(gDL>15 && gDL<=30) sTE=3;
		  else if(gDL>30 && gDL<=180) sTE=15;
		  else if(gDL>180) sTE=30;<?php */?>
		  
		  var sTE=1;
		  if($("#chartfilter").val()=="4") {
			if(gDL>15) sTE=3;
		  } else if($("#chartfilter").val()=="3" || $("#chartfilter").val()=="5") sTE=3;
		  else if($("#chartfilter").val()=="6" || $("#chartfilter").val()=="7") sTE=15;
		  else if($("#chartfilter").val()=="8") sTE=30;	
		  else  sTE=3;
	  
			//Quality Points
		  var options1 = {
			hAxis: {
			  title: 'Date',
			  showTextEvery : sTE
			},
			vAxis: {
			  title: 'Quality Points'
			},
			pointShape : 'circle',
			pointsVisible : true,
			legend: { position: 'top', alignment: 'center' }
		  };	
		  var chart1 = new google.visualization.LineChart(document.getElementById('chart_divqp'));
		  chart1.draw(data1, options1);
		  
		  //Pursuit Points
		  var options2 = {
			hAxis: {
			  title: 'Date',
			  showTextEvery : sTE
			},
			vAxis: {
			  title: 'Pursuit Points'
			},
			pointShape : 'circle',
			pointsVisible : true,
			legend: { position: 'top', alignment: 'center' }
		  };
		  var chart2 = new google.visualization.LineChart(document.getElementById('chart_divpp'));
		  chart2.draw(data2, options2);
    }
</script>
<?php }?>
        </div>		
	</div>
    <!-- Main content ends -->
</div>

<script>
var oTaskTable = $('.pro-table').dataTable({
			"bJQueryUI": false,
			"bAutoWidth": false,
			"iDisplayLength": 50,
			"sPaginationType": "full_numbers",
			"sDom": '<"H"fl>t<"F"ip>',
			//"bSort": false,
		});
		oTaskTable.fnSort( [ [10,'desc'] ] );
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>