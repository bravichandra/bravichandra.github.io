<!-- Main content -->   
<?php
  $find_product = $this->campaign->getAllProduct();
  $find_all_campaign = $this->campaign->get_drop_campaign();
?>
<div class="wrapper">

    <?php $msg = $this->session->flashdata('session_msg'); ?>
    <?php if ($msg): ?><br>
            <h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
        <?php endif; ?> 
    <div class="fluid dashboard">
    <div class="grid12" style="margin-left: 0px;">
        <div class="grid6">
            <div class="widget">
                <div class="body">
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(1,this)" id="bs12">
                            <option value="1" <?php if($oDays==1) echo ' selected="selected"';?>>Today</option>
                            <option value="2" <?php if($oDays==2) echo ' selected="selected"';?>>Last 7 Days</option>
                            <option value="3" <?php if($oDays==3) echo ' selected="selected"';?>>Last 30 Days</option>
                            <option value="4" <?php if($oDays==4) echo ' selected="selected"';?>>This Month</option>
                            <option value="5" <?php if($oDays==5) echo ' selected="selected"';?>>Last Month</option>
                            <option value="6" <?php if($oDays==6) echo ' selected="selected"';?>>Last 3 Months</option>
                            <option value="7" <?php if($oDays==7) echo ' selected="selected"';?>>Last 6 Months</option>
                            <option value="8" <?php if($oDays==8) echo ' selected="selected"';?>>Last 12 Months</option>
                        </select>
                        <select onchange="dashboard_statistics(1,this)" id="bs11">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Quality Points</h1>
                    <br>                                        
                    <div>
                        <div id="chart_divqp"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid6">
            <div class="widget">
                <div class="body">
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(2,this)" id="bs22">
                            <option value="1" <?php if($oDays==1) echo ' selected="selected"';?>>Today</option>
                            <option value="2" <?php if($oDays==2) echo ' selected="selected"';?>>Last 7 Days</option>
                            <option value="3" <?php if($oDays==3) echo ' selected="selected"';?>>Last 30 Days</option>
                            <option value="4" <?php if($oDays==4) echo ' selected="selected"';?>>This Month</option>
                            <option value="5" <?php if($oDays==5) echo ' selected="selected"';?>>Last Month</option>
                            <option value="6" <?php if($oDays==6) echo ' selected="selected"';?>>Last 3 Months</option>
                            <option value="7" <?php if($oDays==7) echo ' selected="selected"';?>>Last 6 Months</option>
                            <option value="8" <?php if($oDays==8) echo ' selected="selected"';?>>Last 12 Months</option>
                        </select>
                        <select onchange="dashboard_statistics(2,this)" id="bs21">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Pursuit Points</h1>
                    <br>                                        
                    <div>
                        <div id="chart_divpp"></div>
                    </div>
                </div>
            </div>
        </div>     
     </div>
    
     
     
     <div class="grid12 crmobjectchart" style="margin-left: 0px;">
        <div class="grid6">
            <div class="widget crmpiechart">
                <div class="body">
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(3,this)" id="bs32">
                            <option value="1">Today</option>
                            <option value="2">Last 7 Days</option>
                            <option value="3">Last 30 Days</option>
                            <option value="4">This Month</option>
                            <option value="5">Last Month</option>
                            <option value="6">Last 3 Months</option>
                            <option value="7">Last 6 Months</option>
                            <option value="8" selected="selected">Last 12 Months</option>
                        </select>
                        <select onchange="dashboard_statistics(3,this)" id="bs31">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Objections Received</h1>
                    <br>                                        
                    <div class="dashboard-piechart">
                        <div id="piechart_div"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid6">
            <div class="widget crmpiechart">
                <div class="body">
                    <h1 class="pt10">Prospect Points</h1>
                    <br>                                        
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
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
                                $pp=0;$n=0;
                                foreach($shared_users as $prosp){$n++;
                                    $points = array(0,0);
                                    if(isset($prospect_users[$prosp->user_id])) {
                                        $points = $prospect_users[$prosp->user_id];
                                        $qp +=$points[0];
                                        $pp +=$points[1];
                                    }
                                    if($n>5) continue;
                            ?>
                            <tr>
                                <td class='no-border'><?php echo ucfirst($prosp->usrname);?></td>
                                <td class='no-border' align="center"><?php echo ($points[0]?$points[0]:0);?></td>
                                <td class='no-border' align="center"><?php echo ($points[1]?$points[1]:0);?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th class='no-border'>Total Points</th>
                                <td class='no-border' align="center"><?php echo $qp;?></td>
                                <td class='no-border' align="center"><?php echo $pp;?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
     </div>
     
     <div class="grid12" style="margin-left: 0px;">
        <div class="grid6">
            <div class="widget">
                <div class="body">                    
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(5,this)" id="bs51">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Tasks</h1>
                    <br>                                        
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <thead>
                            <tr>
                                <th class='no-border'>Subject</th>
                                <th class='no-border'>Related To</th>
                                <th class='no-border'>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($tasks_list as $crow){
                                $parent_name ='';
                                if($crow->task_related=='C') {
                                    $parent_record =$this->crm->get_notes_parent($crow->task_relatedto,'C');
                                    if($parent_record) $parent_name=ucfirst($parent_record['user_first']." ".$parent_record['user_last']);
                                } else if($crow->task_related=='A') {
                                    $parent_record =$this->crm->get_notes_parent($crow->task_relatedto,'A');
                                    if($parent_record) $parent_name=ucfirst($parent_record['account_name']);
                                }
                            ?>
                            <tr>
                                <td class="no-border"><a href="<?php echo base_url(); ?>crm/tasks/view/<?php echo $crow->task_id;?>"><?php echo $crow->task_subject;?></a></td>
                                <td class='no-border'><a href="<?php echo base_url(); ?>crm/<?php echo ($crow->task_related=='A'?'accounts':'contacts');?>/view/<?php echo $crow->task_relatedto;?>"><?php echo $parent_name;?></a></td>
                                <td class='no-border'><?php if((int)$crow->task_duedate)echo date("m/d/Y",strtotime($crow->task_duedate))?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="grid6">
            <div class="widget">
                <div class="body">
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(6,this)" id="bs61">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Opportunities</h1>
                    <br>                                        
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <thead>
                            <tr>
                                <th class='no-border'>Opportunity Name</th>
                                <th class='no-border'>Amount</th>
                                <th class='no-border'>Close Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($opportunity_list as $crow){?>
                            <tr>
                                <td class="no-border"><a href="<?php echo base_url(); ?>crm/opportunities/view/<?php echo $crow->oppt_id;?>"><?php echo ucfirst($crow->oppt_name);?></a></td>
                                <td class='no-border'><?php if($crow->amount) echo '$'.number_format($crow->amount);?></td>
                                <td class='no-border'><?php if((int)$crow->close_date) echo date("m/d/Y",strtotime($crow->close_date));?></td>                    
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
     </div>
    
     <div class="grid12" style="margin-left: 0px;">
        <div class="grid6">
            <div class="widget">
                <div class="body">
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(7,this)" id="bs71">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Target Contacts</h1>
                    <br>                                        
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <thead>
                            <tr>
                                <th class='no-border'>Name</th>
                                <th class='no-border'>Account</th>
                                <th class='no-border'>Title</th>
                                <th class='no-border' align="center">Quality Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($contact_list as $crow){?>
                            <tr>
                                <td class="no-border"><a href="<?php echo base_url(); ?>crm/contacts/view/<?php echo $crow->contact_id;?>"><?php echo ucfirst($crow->user_first.' '.$crow->user_last);?></a></td>
                                <td class='no-border'><?php echo ucfirst($crow->account_name);?></td>
                                <td class='no-border'><?php echo ucfirst($crow->user_title);?></td>
                                <td class='no-border' align="center"><?php echo $crow->qpoints;?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="grid6">
            <div class="widget">
                <div class="body">
                    <div class="dashboard-sboxes">
                        <select onchange="dashboard_statistics(8,this)" id="bs81">    
                            <option value="0">All Users</option>
                            <?php foreach($shared_users as $ushared){?>
                            <option value="<?php echo $ushared->user_id;?>"><?php echo ucfirst($ushared->usrname);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <h1 class="pt10">Target Accounts</h1>
                    <br>                                        
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <thead>
                            <tr>
                                <th class='no-border'>Account Name</th>
                                <th class='no-border'>Phone</th>
                                <th class='no-border'>Quality Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($account_list as $crow){?>
                            <tr>
                                <td class="no-border"><a href="<?php echo base_url(); ?>crm/accounts/view/<?php echo $crow->account_id;?>"><?php echo ucfirst($crow->account_name);?></a></td>
                                <td class='no-border'><?php if($crow->phone) echo '<a href="tel:'.$crow->phone.'">'.$crow->phone.'</a>';?></td>
                                <td class='no-border' align="center"><?php echo $crow->qpoints;?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>     
     </div>
    
    </div>
    <br/>
    
</div>
<script src="<?php echo base_url();?>js/chart-loader.js"></script>
<?php /*?><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><?php */?>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart','bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        //Pie Chart
        var data = google.visualization.arrayToDataTable(<?php echo $chartData;?>);     
        var options = {
          legend: { position: 'none'},
          backgroundColor: '#f7f7f7'
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
        
        chart.draw(data, options);
        
        
        //Line Charts for Single User
        var graphData1 = <?php echo $chartData1;?>;
        var graphData2 = <?php echo $chartData2;?>;
        <?php if(!$oUsr) {?>
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string', 'X');
            data1.addColumn('number', 'Total Points');
            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'X');
            data2.addColumn('number', 'Total Points');
        <?php }else{?>
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string', 'X');
            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'X');
            <?php foreach($shared_users as $prosp) {
                //if(!isset($prospect_users[$prosp->user_id])) continue;
                if($oUsr && $prosp->user_id<>$oUsr) continue;
            ?>
            data1.addColumn('number', "<?php echo ucfirst($prosp->usrname);?>");
            data2.addColumn('number', "<?php echo ucfirst($prosp->usrname);?>");
            <?php }?>   
        <?php }?>       
        //var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
        data1.addRows(graphData1);
        data2.addRows(graphData2);
        var gDL=graphData1.length;
        var sTE=1;
        if($("#chartfilter").val()=="4") {
            if(gDL<=7) sTE=1;
            else if(gDL<=15) sTE=2;
            else if(gDL<=21) sTE=3;
            else sTE=4;
        } else if($("#chartfilter").val()=="3" || $("#chartfilter").val()=="5") sTE=4;
        else if($("#chartfilter").val()=="6") sTE=15;
        else if($("#chartfilter").val()=="7") sTE=25;
        else if($("#chartfilter").val()=="8") sTE=50;     
        //console.log(sTE);
      
          //Quality Points
          var options1 = {
            hAxis: {
              title: 'Date',
              showTextEvery : sTE
            },
            vAxis: {
              title: 'Quality Points'
            },
            colors :[ '#009900'],
            pointShape : 'circle',
            pointsVisible : false,
            chartArea: {  width: "80%" },
            legend: { position: 'none' }
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
            colors :[ '#FF0000'],
            pointShape : 'circle',
            pointsVisible : false,
            chartArea: {  width: "80%" },
            legend: { position: 'none' }
          };
          var chart2 = new google.visualization.LineChart(document.getElementById('chart_divpp'));
          chart2.draw(data2, options2);
    }

    //Prospect Points
    function PP_drawChart(box,Data) {
        
        //Line Charts for Single User
        var graphData2 = Data;
        var bs1 = $("#bs"+box+"1").val();
        var data2 = new google.visualization.DataTable();
        data2.addColumn('string', 'X');
        if(bs1=="0") {            
            data2.addColumn('number', 'Total Points');
        }else{
            data2.addColumn('number', $("#bs"+box+"1 option:selected").text());
        }
    
        //var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
        data2.addRows(graphData2);
        var gDL=graphData2.length;
        var sTE=1;
        if(bs1=="4") {
            if(gDL<=7) sTE=1;
            else if(gDL<=15) sTE=2;
            else if(gDL<=21) sTE=3;
            else sTE=4;
        } else if(bs1=="3" || bs1=="5") sTE=4;
        else if(bs1=="6") sTE=15;
        else if(bs1=="7") sTE=25;
        else if(bs1=="8") sTE=50;     
        //console.log(sTE);
      
         
          //Pursuit Points
          var options2 = {
            hAxis: {
              title: 'Date',
              showTextEvery : sTE
            },
            vAxis: {
              title: 'Pursuit Points'
            },
            colors :[ '#FF0000'],
            pointShape : 'circle',
            pointsVisible : false,
            chartArea: {  width: "80%" },
            legend: { position: 'none' }
          };
          var chart2 = new google.visualization.LineChart(document.getElementById('chart_divpp'));
          chart2.draw(data2, options2);
    }
    //Quality points
    function QP_drawChart(box,Data) {        
        
        //Line Charts for Single User
        var graphData1 = Data;
        var bs1 = $("#bs"+box+"1").val();
        var data1 = new google.visualization.DataTable();
        data1.addColumn('string', 'X');
        if(bs1=="0") {            
            data1.addColumn('number', 'Total Points');
        }else{
            data1.addColumn('number', $("#bs"+box+"1 option:selected").text());
        }      
        //var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];
        data1.addRows(graphData1);
        var gDL=graphData1.length;
        var sTE=1;
        if(bs1=="4") {
            if(gDL<=7) sTE=1;
            else if(gDL<=15) sTE=2;
            else if(gDL<=21) sTE=3;
            else sTE=4;
        } else if(bs1=="3" || bs1=="5") sTE=4;
        else if(bs1=="6") sTE=15;
        else if(bs1=="7") sTE=25;
        else if(bs1=="8") sTE=50;     
        //console.log(sTE);
      
          //Quality Points
          var options1 = {
            hAxis: {
              title: 'Date',
              showTextEvery : sTE
            },
            vAxis: {
              title: 'Quality Points'
            },
            colors :[ '#009900'],
            pointShape : 'circle',
            pointsVisible : false,
            chartArea: {  width: "80%" },
            legend: { position: 'none' }
          };    
          var chart1 = new google.visualization.LineChart(document.getElementById('chart_divqp'));
          chart1.draw(data1, options1);
    }

    //objections piechart
    function OBJ_drawChart(objData) {
        //Pie Chart
        var data = google.visualization.arrayToDataTable(objData);     
        var options = {
          legend: { position: 'none'},
          backgroundColor: '#f7f7f7'
        };
        
        var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
        
        chart.draw(data, options);
    }

    //Dashboard dropdown changes
    function dashboard_statistics(box,dis) {
        //$(".loader").html('');
        //$(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        var bs1 = $("#bs"+box+"1").val();
        var bs2 = $("#bs"+box+"2").val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('crmbeta/dashboard_statistics');?>",
          cache: false,
          dataType: 'json',
          data: "box="+box+"&u="+bs1+"&t="+bs2,
            }).done(function( resp ) {
                //$(".loader").html(''); 
                if(box==3) {
                    OBJ_drawChart(resp.content);
                } else if(box==1) {
                    QP_drawChart(box,resp.content);
                }  else if(box==2) {
                    PP_drawChart(box,resp.content);
                }
                else if(box==5 || box==6 || box==7 || box==8) {
                    $(dis).parents(".body").find(".tDefault tbody").html(resp.content);
                }
          })
          .fail(function() {
            //$(".loader").html('');
          });
    }
</script> 