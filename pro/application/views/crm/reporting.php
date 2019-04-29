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
		<!-- Main content -->
        <form method="post" id="frm_qualifier" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" id="action" value="report" />
            <input type="hidden" id="epoints" value="0" />
        <table cellpadding="0" cellspacing="0" style="width:100%;background: none repeat scroll 0 0 #f8f8f8;" border="0" class="contact-edit interact">
            <tr>
            <th class="one">User*</th><td class="two">
                <select name="record[user]" id="user">	
                    <option value="">Select User</option>
                    <?php foreach($shared_users as $user){?>
                    <option value="<?php echo $user->user_id;?>"><?php echo ucfirst($user->usrname);?></option>
                    <?php } ?>
                </select>
				</td>
            </tr>
            <tr>
                <th class="one">Category*</th>
                <td class="two">
                <select name="record[cat]" id="cat">
                    <option value="">Select</option>
                    <?php foreach($categories as $ci=>$cat) : ?>
                    <option value="<?php echo $ci; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
					</select>
                </td>
            </tr>
            <tr style="border-bottom:0px;">
                <th class="one">Date From*</th>
                <td class="two">
                <input type="text" value="<?php echo date("m/d/Y");?>" name="record[ifdate]" id="ifdate" class="idate" /> 
                To: <input type="text" value="<?php echo date("m/d/Y");?>" name="record[itdate]" id="itdate" class="idate" />
                </td>
            </tr>
            <tr>
            	<td colspan="2" id="catlist">
                	<?php if($categories) {
						foreach($categories as $ci=>$cat) {?>
                    <div id="cat<?php echo $ci;?>" class="catbox" style="display:none;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
					<?php foreach($cat['sections'] as $si=>$section) {?>
					<tr>
						<th class="title"><a href="javascript:void(0);" data-colp="0" onclick="collapse('c<?php echo $ci.$si?>',this)"><span class="iconn icon-arrow-right" data-icon="&#xe015;"></span> <?php echo $section['name'];?></a> </th>
					</tr>
            		<tr class="csect" id="secc<?php echo $ci.$si?>">
                        <td>
                        	<?php 
								$oi=0;
								$opti=0;
								if($section['options']) {?>
								<div class="iquest">
                                	<div class="iqb1"></div><br clear="all" />
								<?php $noc = count($section['options']);foreach($section['options'] as $oi=>$option) { if($si==4 && $oi=="O") continue;$opti=$oi;?>                                
                                    <div class="iqb1"><input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="<?php echo $oi;?>" /> <?php echo $option['name'];?></div><br clear="all" />
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
                                    <input type="hidden" name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo form_prep($obval->obj_val); ?>" />
                                    <input type="hidden" name="record[opto_id<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo $obval->obj_id; ?>" />
                                </div><br clear="all" />
                                <?php endforeach; ?>
                                <?php /*foreach($ObjectionsCampaign as $obval) : $oi++; ?>
                                <div class="iqb1">
                                	<input type="checkbox" name="record[opt][<?php echo $ci.'n'.$si;?>][<?php echo $oi;?>]" class="optval" value="O" /> <?php echo $obval->ob_title; ?>                                    <input type="hidden" name="record[opto_txt<?php echo $ci;?>][<?php echo $oi;?>]" value="<?php echo form_prep($obval->ob_title); ?>" />
                                    <input type="hidden" name="record[opto_id<?php echo $ci;?>][<?php echo $oi;?>]" value="0" />
                                </div><br clear="all" />
                                <?php endforeach; $oi++;*/ ?>
                            </div>
                            <?php }?>
                        </td>
                    </tr>
                    <?php }?>
                    </table>
                    </div>
					<?php }}?>
                </th>
            </tr>
            <tr>
            	<td colspan="4" align="center">
                    <div class="fluid" style="margin-top:15px;">
                    	<span class="loader"></span>
                        <input type="submit" class="buttonM bBlue" name="form_submit" value="Run Report" />
                    </div>
                </td>
            </tr>
        </table>
        </form>
        <div class="subsections">
            <div id="chart_line"></div>
        </div>
        <a name="chart" id="chart"></a>
	</div>
    <!-- Main content ends -->
</div>
<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">
<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url();?>js/chart-loader.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.idate').datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){
			$(this).datepicker('hide');
		});
	});
	//Skip hint	
	function save_record(){
		$(".loader").html('');
		var er=0;
		if($('#user').val()=="") {
			alert("Select user");
			$('#user').focus();
			return false;
		}
		if($('#cat').val()=="") {
			alert("Select category");
			$('#cat').focus();
			return false;
		}
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
		var optValid = 0;
		var ct = $('#cat').val();
		optValid +=$("#cat"+ct+" .optval:checked").length;
		if(optValid==0) {
			$("#cat"+ct+" .txtnotes").each(function(e){
				if($(this).val()!="") {optValid=1;return false;}
			});
		}
		if(optValid==0) {
			alert("Select checkbox options");
			return false;
		}
		$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
		$.ajax({
			type : 'POST',
			url : '<?php echo current_url();?>',
			data: $('#frm_qualifier').serialize(),
			cache: false,
			success: function(resp)
			{
				$(".loader").html('');
				var responce = resp.split("@");
				if(responce[0]=="ERROR") alert(responce[1]);
				else {
					var gData = JSON.parse(resp);
					glabels = gData.labels;
					graphData = gData.cdata;
					drawChart();
				}				
			}
		});
		return false;
	}
	$(document).ready(function(){
		$('#cat').change(function(e){
			$("#catlist .optval").prop('checked',false);
			$("#catlist .catbox").hide();
			$("#catlist tr.csect").hide();
			$("#catlist th span").removeClass("icon-arrow-down");
			$("#catlist th span").removeClass("icon-arrow-right");
			$("#catlist th span").addClass("icon-arrow-right");
			$("#catlist th a").attr("data-colp","0");
			if($(this).val()!="") {
				var catg= $(this).val();	
				$("#catlist #cat"+catg+" .iconn:first").removeClass("icon-arrow-down");
				$("#catlist #cat"+catg+" .iconn:first").removeClass("icon-arrow-right");
				$("#catlist #cat"+catg+" .iconn:first").addClass("icon-arrow-down");
				$("#catlist #cat"+catg+" a:first").attr("data-colp","1");
				$("#catlist #cat"+catg+" .csect:first").show();
				$("#catlist #cat"+catg).show();
			}
		});
	});
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
	//Pie Chart for Interactions
	var graphData=null;
	var glabels=null;
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
	function drawChart() {
		if(graphData==null) return;
		
		var data1 = new google.visualization.DataTable();
		data1.addColumn('string', 'X');
		for(key in glabels) {
			data1.addColumn('number', glabels[key]);
		}
		//var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
		data1.addRows(graphData);
		var gDL=graphData.length;
		var sTE=1;
		if(gDL>15 && gDL<=30) sTE=3;
		else if(gDL>30 && gDL<=180) sTE=15;
		else if(gDL>180) sTE=30;
		//Legend Max lines
		var mxlines = (glabels.length/3).toFixed(0);
		
		//Interactions
		var options1 = {
		hAxis: {
		  title: 'Date',
		  showTextEvery : sTE
		},
		vAxis: {
		  title: 'Interactions'
		},
		pointShape : 'circle',
		pointsVisible : true,
		legend: { position: 'top', alignment: 'center', maxLines: mxlines}
		};	
		var chart1 = new google.visualization.LineChart(document.getElementById('chart_line'));
		chart1.draw(data1, options1);		
		
		$(document).scrollTop( $("#chart").offset().top );
	}
	function drawChart2() {
		if(graphData==null) return;
		var data = google.visualization.arrayToDataTable(graphData);
		var options = {
		  title: 'Interactions'
		};
		var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
		chart.draw(data, options);
		$(document).scrollTop( $("#chart").offset().top );
	}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>