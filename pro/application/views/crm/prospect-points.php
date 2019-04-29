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
    		<div class="quatabs nopadding">
	            <div><a href="<?php echo base_url('crm/report')?>">Interaction Reports</a></div>
	            <div><a href="<?php echo base_url('crm/ereport')?>">Email Reports</a></div>
	            <div><a href="<?php echo base_url('crm/objections')?>">Objections</a></div>
                <div><a href="<?php echo base_url('crm/sreport')?>">Sales Reports</a></div>
	            <div class="active"><a href="<?php echo base_url('crm/prospect')?>">Prospect Points</a></div>
	        </div>
        	<div style="width: 95%;position: absolute;margin-top: 40px;">            
                <div style="width: 95%;" align="right">
                	<select onchange="location.replace('<?php echo base_url('crm/prospect');?>/<?php echo $oUsr;?>-<?php echo $oDays;?>-'+this.value);">
                        <option value="0">All</option>
                        <?php foreach($categories['category'] as $ci=>$cat) :
                        	foreach($cat as $si=>$section) {
                         ?>
                        <option value="<?php echo $ci; ?>" <?php if($oCat==$ci) echo ' selected="selected"';?>><?php echo $section['name']; ?></option>
                        <?php } endforeach; ?>
					</select>
                    <select id="chartfilter" name="chartfilter" onchange="location.replace('<?php echo base_url('crm/prospect');?>/<?php echo $oUsr;?>-'+this.value+'-<?php echo $oCat;?>');">	
                        <?php /*?><option value="0">All</option><?php */?>
                        <option value="1" <?php if($oDays==1) echo ' selected="selected"';?>>Today</option>
                        <option value="2" <?php if($oDays==2) echo ' selected="selected"';?>>Last 7 Days</option>
                        <option value="3" <?php if($oDays==3) echo ' selected="selected"';?>>Last 30 Days</option>
                        <option value="4" <?php if($oDays==4) echo ' selected="selected"';?>>This Month</option>
                        <option value="5" <?php if($oDays==5) echo ' selected="selected"';?>>Last Month</option>
                        <option value="6" <?php if($oDays==6) echo ' selected="selected"';?>>Last 3 Months</option>
                        <option value="7" <?php if($oDays==7) echo ' selected="selected"';?>>Last 6 Months</option>
                        <option value="8" <?php if($oDays==8) echo ' selected="selected"';?>>Last 12 Months</option>
                    </select>
                </div>
            </div>    
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault dtskTable'>
                <thead>
                    <tr>  
                        <th class='no-border'>User</th>
                        <th class='no-border alcenter'>Quality Points</th>
            			<th class='no-border alcenter'>Pursuit Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
						$qp=0;
						$pp=0;
						foreach($dropdown_users as $prosp){
							$points = array(0,0);
							if(isset($prospect_users[$prosp->user_id])) {
								$points = $prospect_users[$prosp->user_id];
								$qp +=$points[0];
								$pp +=$points[1];
							}
					?>
                    <tr>
                    	<td class='no-border'><?php echo ucfirst($prosp->usrname);?></td>
                        <td class='no-border alcenter'><?php echo $points[0];?></td>
                        <td class='no-border alcenter'><?php echo $points[1];?></td>
                    </tr>
                    <?php }?>
                    <?php /*<tr>
                    	<th class='no-border'>Total Points</th>
                        <td class='no-border alcenter'><?php echo $qp;?></td>
                        <td class='no-border alcenter'><?php echo $pp;?></td>
                    </tr>*/?>
                </tbody>
            </table>
            <div style="width: 95%;" align="right">
            	<select onchange="location.replace('<?php echo base_url('crm/prospect');?>/'+this.value+'-<?php echo $oDays;?>-<?php echo $oCat;?>');">	
                    <option value="0">All Users</option>
                    <?php foreach($dropdown_users as $prosp){?>
                    <option value="<?php echo $prosp->user_id;?>"<?php if($oUsr==$prosp->user_id) echo ' selected="selected"';?>><?php echo ucfirst($prosp->usrname);?></option>
                    <?php } $usersCount = count($dropdown_users); ?>
                </select>
            </div>
<?php if($prospect_points) {?><br /><hr />   
			<div align="center"><b>Quality Points</b></div>
            <div id="chart_divqp"style="height: 400px;"></div><hr />
            <div align="center"><b>Pursuit Points</b></div>
            <div id="chart_divpp"style="height: 400px;"></div>
<script src="<?php echo base_url();?>js/chart-loader.js"></script>
<script type="text/javascript">
//var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
var graphData1 = <?php echo $chartData1;?>;
var graphData2 = <?php echo $chartData2;?>;
google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawLineColors);

	function drawLineColors() {
		  var data1 = new google.visualization.DataTable();
		  data1.addColumn('string', 'X');
		  var data2 = new google.visualization.DataTable();
		  data2.addColumn('string', 'X');
		  <?php foreach($prospect_points as $prosp) {?>
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
	  
			//Quality Points
		  var options1 = {
			hAxis: {
			  title: 'Date',
			  showTextEvery : sTE
			},
			vAxis: {
			  title: 'Quality Points'
			},
			<?php if($oUsr || $usersCount==1) echo "colors :[ '#009900'],";?>
			pointShape : 'circle',
			pointsVisible : false,
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
			<?php if($oUsr || $usersCount==1) echo "colors :[ '#FF0000'],";?>
			pointShape : 'circle',
			pointsVisible : false,
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
<script type="text/javascript">
	$(document).ready(function(){
		var oTaskTable = $('.dtskTable').dataTable({
			"bJQueryUI": false,
			"bAutoWidth": false,
			"iDisplayLength": 50,
			language: {
		        searchPlaceholder: "Find Record"
		    },
			"sPaginationType": "full_numbers",
			"sDom": '<"H"fl>t<"F"ip>',
			//"bSort": false,
		});
		oTaskTable.fnSort( [ [2,'desc'] ] );
	});
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>