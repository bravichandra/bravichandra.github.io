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
	<?php  		
		//if(isset($crmdbuser) && $crmdbuser) $this->load->view('common/drop_menu');
	?>
	<!-- Main content -->
    <div class="main-wrapper crmlite">
    	<div class="quatabs nopadding">
            <div><a href="<?php echo base_url('crm/report')?>">Interaction Reports</a></div>
            <div><a href="<?php echo base_url('crm/ereport')?>">Email Reports</a></div>
            <div class="active"><a href="<?php echo base_url('crm/objections')?>">Objections</a></div>
            <div><a href="<?php echo base_url('crm/sreport')?>">Sales Reports</a></div>
            <div><a href="<?php echo base_url('crm/prospect')?>">Prospect Points</a></div>
        </div><br clear="all">
    	<?php if(isset($crmdbuser) && $crmdbuser) {?>
    	<div class="objections">
            <?php /*<table style='background: none repeat scroll 0 0 #E6E6E6; width:95%' class='tDefault'>
                <tbody>
                    <tr>
						<td class='no-border'>Objections Map</td>						
						<?php if ($is_paid) { ?>							
							<td width='7%' class='no-border'>
								<a  href="<?php echo base_url(); ?>output/objections-map"  target="_blank" title="Download" class="buttonM bBlue">HTML</a>
							</td>
							<td width='7%' class='no-border'>
							<a  title="Download" href="<?php echo base_url(); ?>output/objections-map/download" class="buttonM bBlue">MS Word</a></td>
							<td width='7%' class='no-border dont-consider'><?php if(!isset($is_prolite)) {?>
							<a href="<?php echo base_url();?>step/objection" class="buttonM bGreen">Edit</a>
							<?php } ?></td>
						<?php }else{ ?>
							<td width='7%' class='no-border' colspan="4" >
								<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
								<a id="32" href="https://salesscripter.com/members/signup" target="_blank" class="  fs1" ><strong>Upgrade Here</strong></a></span>
							</td>
						<?php } ?>
					</tr>
                </tbody>
            </table>*/?>
            <div style="width: 95%;" align="right">
            	<select onchange="location.replace('<?php echo base_url('crm/objections');?>/'+this.value+'-<?php echo $oDays;?>');">	
                    <option value="0">All Users</option>
                    <?php foreach($prospect_points as $prosp){?>
                    <option value="<?php echo $prosp->user_id;?>"<?php if($oUsr==$prosp->user_id) echo ' selected="selected"';?>><?php echo ucfirst($prosp->usrname);?></option>
                    <?php } ?>
                </select>
                <select onchange="location.replace('<?php echo base_url('crm/objections');?>/<?php echo $oUsr;?>-'+this.value);">	
                    <option value="">All Time</option>
                    <option value="0" <?php if($oDays=='0') echo ' selected="selected"';?>>Today</option>
                    <option value="1" <?php if($oDays==1) echo ' selected="selected"';?>>Last 7 Days</option>
                    <option value="2" <?php if($oDays==2) echo ' selected="selected"';?>>Last 30 Days</option>
                    <option value="3" <?php if($oDays==3) echo ' selected="selected"';?>>This Month</option>
                    <option value="4" <?php if($oDays==4) echo ' selected="selected"';?>>Last Month</option>
                    <option value="5" <?php if($oDays==5) echo ' selected="selected"';?>>Last 3 Months</option>
                    <option value="6" <?php if($oDays==6) echo ' selected="selected"';?>>Last 6 Months</option>
                    <option value="7" <?php if($oDays==7) echo ' selected="selected"';?>>Last 12 Months</option>
                </select>
            </div>
            <div class="subsections piechart">
            	<div id="piechart_div"></div>
            </div>
<script src="<?php echo base_url();?>js/chart-loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
	
	var data2 = google.visualization.arrayToDataTable([
	  ['Objection', 'Usage'],
	  ['Work',     11],
	  ['Eat',      2],
	  ['Commute',  2],
	  ['Watch TV', 2],
	  ['Sleep',    7]
	]);
	var data = google.visualization.arrayToDataTable(<?php echo $chartData;?>);
	
	var options = {
	  title: 'Objections Received'
	};
	
	var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
	
	chart.draw(data, options);
	}
</script>
        </div>	
        <?php } ?>	
	</div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>