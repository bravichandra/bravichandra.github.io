<?php $this->load->view('common/meta'); ?>	

<?php $this->load->view('common/header'); ?>

<!-- Sidebar begins -->
<style type="text/css">
	   .crm-error {
		color: #FF0000;
		margin-left: 2.5%;
		position: absolute;
		background: #8c8181;
		width: 500px;
		/* height: 0px; */
		margin: 0px auto !important;
		border: 1px solid #383737;
		font-size: 16px;
		text-align: center;
		color: #FFF;
		font-weight: bold;
		left: 30%;
		top: 10%;
		opacity: 1;
	}
	.crm-error-content {
		padding: 67px 0px 50px;
		font-size: 24px;
		line-height: 30px;
	}	
	.crm-error-link
	{
		float: right;
		margin-right: 10px;
		margin-top: 10px;		
	}
	.crm-error-link a
	{
		color: #FFFFFF;
		font-size: 20px !important;
	}
</style>
<div id="sidebar">

    <?php $this->load->view('common/left_navigation'); ?>

	<!-- Secondary nav -->    

    <div class="secNav">

        <div class="clear"></div>

    </div>

</div>



<!-- Sidebar ends --> <!-- Content begins -->

<link href="<?php echo base_url();?>/css/datepicker.css" rel="stylesheet">

<script src="<?php echo base_url();?>js/bootstrap-datepicker.js"></script>



<div class="overlayBackground" onclick="hide_fade()"></div>

<div id="content">

	<!-- Breadcrumbs line -->

	<?php  		

	$this->load->view('common/crm_nav');

	?>

    <div class="formRow crmlite" id="cLookup">

        <div class="qrbox">

            <div class="abox1">Account Lookup</div>

            <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />

        </div>

        <div>

            <div class="new_account">

                <div style="float:left; padding:4px;">

                    <b>Enter name to create a new account</b>

                </div>

                <div style="float:left; padding:4px;">

                    <input type="text" id="new_account_name" />

                </div>

                <div style="float:left; padding:4px;">

                    <input type="button" class="buttonM bBlue" onclick="set_newaccount()" value="Add" />

                </div>                	

            </div>

            <div class="search-list"></div>

        </div>

    </div> 

    



     <!-- custom view-->

    <div id="crmpopup1">

        <div class="formRow">

            <div class="qrbox">

                <div class="abox1">View</div>

                <div class="abox2"><a href="javascript:void(0)" onclick="hide_fade1()"><span class="ui-icon ui-icon-closethick">close</span></a></div><br clear="all" />

            </div>

            <div class="box box_Custom" title="Custom">

                            	<table cellpadding="0" cellspacing="0"  border="0">	

                                    <tr>

                                        <td class="two"></td>

                                    </tr>

                                </table>

                            </div>

        </div> 

    </div>

    

	<!-- Main content -->

    <div class="main-wrapper crmlite">  

    	<div class="crm-menu"> 

            <?php /*?><a href="<?php echo base_url();?>crm/contacts" class="buttonM bBlack">Back</a> <?php */?>
            
            <INPUT TYPE="button" VALUE="Back" class="buttonM bBlack" onClick="history.go(-1);" style="cursor:pointer;"/>

            <a href="<?php echo base_url();?>crm/contacts/edit/<?php echo $record[contact_id]?>" class="buttonM bBlack">Edit</a> 
                
            <a href="<?php echo base_url();?>crm/contacts/clone/<?php echo $record[contact_id]?>" class="buttonM bBlack">Clone</a> 

            <a href="<?php echo base_url();?>crm/contacts/delete/<?php echo $record[contact_id]?>" onclick="if(!confirm('Are you sure you want to delete this contact?')) return false;" class="buttonM bBlack">Delete</a> 

            <a href="<?php echo base_url();?>crm/contacts/view/<?php echo $record[contact_id]?>/send" class="buttonM bBlack">Salesforce Sync</a> 

            <div align="center" style="float:right;">    
            
            
            <a href="<?php echo base_url().'output/'.$record[slug]; ?>/intro" class="buttonM bRed" target="_blank"> Script</a>     

            <a href="<?php echo base_url();?>crm/compose/<?php echo $record[contact_id]?>" class="buttonM bRed">Send Email</a> 

            <a href="<?php echo base_url();?>crm/interaction/contact/<?php echo $record[contact_id]?>" class="buttonM bRed">Log an Interaction</a>         

            <a href="<?php echo base_url();?>crm/qualifier/contact/<?php echo $record[contact_id]?>" class="buttonM bRed">Prospect Qualifier</a>           

            </div>   

        </div>    

        <?php /*?><?php if($error) { //echo '<pre>'; print_r($error); echo '</pre>';?>

        <div class="crm-error"><?php echo implode("<br />",$error);?></div>
        
        <div class="crm-error">
        	 <div class="crm-error-link"><a href="#" onclick="popclose();">X</a></div>
        	 <div class="crm-error-content"><?php echo implode("<br />",$error);?></div>
        </div>

        <?php }?><?php */?>

		<!-- Main content -->

        <div>

		<?php include("contact-view-layout.php");?>

        </div>

         <hr />

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

<?php /*<script src="<?php echo base_url();?>js/chart-loader.js"></script>*/?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

<script type="text/javascript">

//var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];

var graphData = <?php echo $chartData;?>;//alert(graphData);
$.each(graphData, function (i, item) {
    var d = new Date(item[0][0],item[0][1],item[0][2]);                    
    graphData[i][0] = d;
});

google.charts.load('current', {packages: ['corechart', 'line']});

google.charts.setOnLoadCallback(drawLineColors);

var sTE=1;
sTE = <?php echo $sTE;?>;
var chartrefresh=1;

	function drawLineColors() {

		  var data = new google.visualization.DataTable();

		  data.addColumn('date', 'X');

		  data.addColumn('number', 'Quality Points');

		  data.addColumn('number', 'Pursuit Points');

	

		  //var graphData = [['Day 1', 0, 0],['Day 2', 10, 5]];

		  data.addRows(graphData);	  

		  /*var gDL=graphData.length;	  

		  var sTE=1;

		  if($("#chartfilter").val()=="2") {

			if(gDL>15) sTE=3;

		  } else if($("#chartfilter").val()=="1" || $("#chartfilter").val()=="3") sTE=3;

		  else if($("#chartfilter").val()=="4") sTE=15;

		  else if($("#chartfilter").val()=="5") sTE=15;

		  else if($("#chartfilter").val()=="6") sTE=30;
          else if($("#chartfilter").val()=="7") sTE=30;*/

          if($("#chartfilter").val()=="7") lfromat="d-MMM-yyyy";
            else lfromat="d-MMM";
	

		  var options = {

			hAxis: {

			  title: 'Date',

			  format: lfromat,///,
              //showTextEvery : sTE,
              //format: 'd-MMM'//,
              gridlines: {color:'none'}

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

			data: 'gft='+val+'&cid=<?php echo $record[contact_id]?>&action=graph',

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
    /*$(document).ready(function(){
        updategraph($("#chartfilter").val());
    });*/

</script> 

	<?php }?>
        <div class="contact-childs"></div> 
        <div class="contact-childs1"></div>       
        <div id="Lists" style="display: none;">
            <div class="subsections"><b>Lists</b></div>
            <div class="subsections" style="display: none;"><b class="subtitle">SalesScripter Lists</b> 
                <a href="javascript:void(0);" onclick="catlist_popup(0)">&nbsp;Remove from List</a>
                <a href="javascript:void(0);" onclick="catlist_popup(1)">&nbsp;Add to List | </a>             
            </div>
            <div>
                <form action="<?php echo current_url();?>" id="frmCatgSingle" method="post">
                    <input type="hidden" name="action" id="ecatlist" value="listupdate" />
                <table cellpadding="0" cellspacing="0" border="0" style="margin: 6px 30px;">  
                    <tr>
                        <th class="one" width="120px">SalesScripter Lists</th>
                        <td class="two" width="120px">
                            <select name="record[catg][]">
                                <option value="">Select List</option>
                                <?php foreach($catlist as $crow)    {?>
                                <option value="<?php echo $crow->id;?>"><?php echo $crow->name;?></option>
                                <?php }?>
                            </select>            
                        </td>
                        <td class="one" width="120px">&nbsp;<input type="button" class="buttonM bBlue" onclick="save_catlist()" value="Add to List" style="height: 27px;padding: 5px 15px;" /></td>
                        <td><div class="loader2"></div></td>
                    </tr>
                </table> 
                </form>   
            </div>
            <div id="catg_list_show">
                <?php $this->load->view('crm/catg-list-few');?>
            </div>
            <?php include("contact-mailchimp-block.php");?>
        </div>

        
        

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

                            <div class="box box_target" title="Target Contact">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Target Contact</th>

                                        <td class="two"><input type="checkbox" value="1" <?php if(isset($record[target]) && $record[target]) echo ' checked="checked"'?> name="record[target]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_address" title="Mailing Address">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Mailing Street</th><td class="two"><textarea name="record[amail][street]"><?php if(isset($record[amail][street])) echo $record[amail][street]?></textarea></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Mailing City</th><td class="two"><input type="text" value="<?php if(isset($record[amail][city])) echo form_prep($record[amail][city])?>" name="record[amail][city]" /></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Mailing State/Province</th><td class="two"><input type="text" value="<?php if(isset($record[amail][state])) echo form_prep($record[amail][state])?>" name="record[amail][state]" /></td>

                                    </tr>

                                    <tr>

                                        <th class="one">Mailing Zip/Postal Code</th><td class="two"><input type="text" value="<?php if(isset($record[amail][zipcode])) echo form_prep($record[amail][zipcode])?>" name="record[amail][zipcode]" /></td>

                                    </tr>

                                    <tr style="border-bottom:0px;">

                                        <th class="one">Mailing Country</th><td class="two"><input type="text" value="<?php if(isset($record[amail][country])) echo form_prep($record[amail][country])?>" name="record[amail][country]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_user_first" title="Name">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th>Name</th>

                                        <td>

                                        <select name="record[user_prefix]">

                                            <option value="">None</option>

                                            <option value="Mr."<?php $sel='';if(isset($record[user_prefix]) && $record[user_prefix]=="Mr.") echo $sel=' selected="selected"'?>>Mr.</option>

                                            <option value="Ms."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Ms.") echo $sel=' selected="selected"'?>>Ms.</option>

                                            <option value="Mrs."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Mrs.") echo $sel=' selected="selected"'?>>Mrs.</option>

                                            <option value="Dr."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Dr.") echo $sel=' selected="selected"'?>>Dr.</option>

                                            <option value="Prof."<?php if(isset($record[user_prefix]) && $record[user_prefix]=="Prof.") echo $sel=' selected="selected"'?>>Prof.</option>

                                            <?php if(!$sel && !empty($record[user_prefix])){?>

                                            <option value="<?php echo $record[user_prefix];?>" selected="selected"><?php echo $record[user_prefix];?></option>

                                            <?php }?>

                                        </select>

                                        </td>

                                        <td>

                                        <input type="text" value="<?php if(isset($record[user_first])) echo form_prep($record[user_first])?>" name="record[user_first]" id="user_first" />

                                        </td>

                                        <td><input type="text" value="<?php if(isset($record[user_last])) echo form_prep($record[user_last])?>" name="record[user_last]" id="user_last" /></td>

                                    </tr>

                                </table>

                            </div>                            

                            <div class="box box_department" title="Department">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Department</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[department])) echo form_prep($record[department])?>" name="record[department]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_linkedin" title="LinkedIn Profile">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">LinkedIn Profile</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[linkedin])) echo form_prep($record[linkedin])?>" name="record[linkedin]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_website" title="Website">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Website</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[website])) echo form_prep($record[website])?>" name="record[website]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_birthdate" title="Birthdate">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Birthdate</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[birthdate])) echo form_prep($record[birthdate])?>" name="record[birthdate]" id="birthdate" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_account_id" title="Account Name">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Account Name</th>

                                        <td class="two">

                <input type="hidden" value="<?php if(isset($record[account_id])) echo form_prep($record[account_id])?>" name="record[account_id]" id="account_id" />

                <input type="text" readonly="readonly" value="<?php if(isset($record[account_title])) echo form_prep($record[account_title])?>" name="record[account_title]" id="account_title" />

                                        </td>

                                        <td>

                <a href="javascript:void(0);" onclick="Records_getLookup('account','account');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_report_id" title="Reports To">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Reports To</th>

                                        <td class="two">

                <input type="hidden" value="<?php if(isset($record[report_id])) echo form_prep($record[report_id])?>" name="record[report_id]" id="report_id" />

                <input type="text" value="<?php if(isset($record[report_title])) echo form_prep($record[report_title])?>" name="record[report_title]" readonly="readonly" id="report_title" /></td>

                                        <td><a href="javascript:void(0);" onclick="Records_getLookup('contact','report');"><img border="0" src="<?php echo base_url('images/icons');?>/find.png" /></a></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_lead_source" title="Lead Source">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Lead Source</th>

                                        <td class="two"><select name="record[lead_source]">
                                            <option value="">None</option>
                                            <?php   foreach($lead as $led){ ?>
                                             <option value="<?php echo $led ?>"<?php $sel='';if(isset($record[lead_source]) && $record[lead_source]==$led) echo $sel=' selected="selected"'?>><?php echo $led; ?></option>
                                        <?php }  ?>
                                         <?php if(!$sel && !empty($record[lead_source])){?>
                                            <option value="<?php echo $record[lead_source];?>" selected="selected"><?php echo $record[lead_source];?></option>
                                            <?php }?>

                                        </select></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_user_title" title="Title">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Title</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[user_title])) echo form_prep($record[user_title])?>" name="record[user_title]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_assistant" title="Assistant">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Assistant</th><td class="two"><input type="text" value="<?php if(isset($record[assistant])) echo form_prep($record[assistant])?>" name="record[assistant]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_phone" title="Phone">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Phone</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[phone])) echo form_prep($record[phone])?>" name="record[phone]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_asst_phone" title="Asst. Phone">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Asst. Phone</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[asst_phone])) echo form_prep($record[asst_phone])?>" name="record[asst_phone]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_mobile" title="Mobile">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Mobile</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[mobile])) echo form_prep($record[mobile])?>" name="record[mobile]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_other_phone" title="Other Phone">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Other Phone</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[other_phone])) echo form_prep($record[other_phone])?>" name="record[other_phone]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_email" title="Email">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <th class="one">Email</th>

                                        <td class="two"><input type="text" value="<?php if(isset($record[email])) echo form_prep($record[email])?>" name="record[email]" /></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="box box_description" title="Description">

                                <table cellpadding="0" cellspacing="0" border="0">  

                                    <tr>

                                        <td class="two"><textarea name="record[description]" style="height:100px;"><?php if(isset($record[description])) echo $record[description]?></textarea></td>

                                    </tr>

                                </table>

                            </div>

                             <?php   $kc=0;

                           $ekeys=array();

                            foreach($record['custom'] as $cv){ 
                                    if(!isset($custom[$cv['ckey']])) continue;
                                     $ekeys[]= $cv['ckey'];

                                        $kc++;?>

                            <div class="box box_<?php echo $cv['ckey']; ?>" title="<?php if(isset($custom[$cv['ckey']])) echo $custom[$cv['ckey']]?>">

                                <table cellpadding="0" cellspacing="0" width="100%" border="0">

                                    <tr>

                                        <th class="one"><?php if(isset($custom[$cv['ckey']])) echo $custom[$cv['ckey']]?></th>

                                        <td class="two"><!--<input type="text" value="<?php if(isset($cv['cval'])) echo $cv['cval'];?>" name="record[custom][<?php echo $cv['ckey']; ?>]" />-->  

                                        <textarea name="record[custom][<?php echo $cv['ckey']?>]" style="height:100px;width: 500px;"><?php if(isset($cv['cval'])) echo $cv['cval'];?></textarea></td>

                                    </tr>

                                </table>

                            </div>

                            <?php }

                            //print_r($custom);

                            foreach($custom as $ck=>$cv){

                                if(in_array($ck,$ekeys)!==FALSE) continue;

                                  $kc++;

                             ?>

                              <div class="box box_<?php echo $ck ?>" title="<?php echo $cv;?>">

                                <table cellpadding="0" width="100%" cellspacing="0" border="0">

                                    <tr>

                                        <th class="one"><?php if(isset($ck)) echo $cv; ?></th>

                                        <td class="two"><!--<input type="text" value="" name="record[custom][<?php echo $ck; ?>]"/>-->

                                        <textarea name="record[custom][<?php echo $ck; ?>]" style="height:100px;width: 500px;"><?php //if(isset($cv)) echo $cv;?></textarea></td>

                                    </tr>

                                </table>

                            </div>

                            <?php } ?>

                                                     

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

    <!-- Main content ends -->

</div>

<!-- Content ends -->
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

        $("#birthdate").datepicker({format: 'mm/dd/yyyy'}).on('changeDate', function(ev){

            $(this).datepicker('hide');

        });

    });

    var ectrl;

    var ebox;

    

    //view custom

    function view_column(dis) {

        $(".erbox").html('');

        ectrl = $(dis).parent();

        ebox = ectrl.attr("data-field");

        $("#eblock").val(ebox);

        $("#crmpopup1 .qebox .box").hide();

        

        $('#'+dis+'_hide').html();

        $('#crmpopup1 .two').html($('#'+dis+'_hide').html());

        

        $("#crmpopup1 .abox1 span").html($("#crmpopup1 .qebox .box_"+ebox).attr('title'));

        $("#crmpopup1 .qebox .box_"+ebox).show();

        $("#crmpopup1").show();

        $(".overlayBackground").show();

        if(ebox=="account_id") Records_getLookup('account','account');

    }

    

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

        if(ebox=="account_id") Records_getLookup('account','account');

    }

    //Hide Fade

    function hide_fade(){

        $(".erbox").html('');

        $("#crmpopup").hide();

        $(".overlayBackground").hide();

        $('#cLookup').hide();

    }

    //hide custom

    function hide_fade1(){

        $(".erbox").html('');

        $("#crmpopup1").hide();

        $(".overlayBackground").hide();

        $('#cLookup').hide();

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

                    if(ebox=="target") $("#target").prop('checked',responce.cinfo=="1"?true:false);

                    else ectrl.html(responce.cinfo);

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

        $(".new_account").hide();

        if(rcname=="account") {

            popboxhead = 'Account Lookup';

            ajxmethod='accounts_lookup';

            $("#new_account_name").val('');

            $(".new_account").show();

        } else if(rcname=="contact") {

            popboxhead = 'Contact Lookup';

            ajxmethod='contacts_lookup';

        } else if(rcname=="share") {

            popboxhead = 'Contact Owner';

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

            if(rcname=="account") {

                $(".dataTables_filter label span").html("Search to find existing account");

                $(".dataTables_filter").width(370);

            }

        });

    }

    //Set lookup

    function setLookup(dis) {

        $("#"+objname+"_title").val($(dis).html());

        $("#"+objname+"_id").val($(dis).attr("data_id"));

        $("#cLookup").hide();

    }

    //Set New Account Name

    function set_newaccount() {

        if($("#new_account_name").val()=="") {

            alert("Enter new account name");

            $("#new_account_name").focus();

            return;

        }

        $("#account_title").val($("#new_account_name").val());

        $("#account_id").val(0);

        $("#cLookup").hide();

    }

    /*Category List*/
    //Hide Fade
    function hide_catlist(){
        $("#crmlistpopup").hide();
        $(".overlayBackground").hide();
    }
    //Popup
    function catlist_popup(catg_act) {        
        $("#crmlistpopup .qrbox .abox1 span").html(catg_act==1?'Add to List':'Remove from List');        
        $("#crmlistpopup").show();
        $(".overlayBackground").show();
    }
    //Save Catlist
    function save_catlist_old() 
    {
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: $("#frmCatg").serialize(),
            cache: false,
            success: function(responce)
            {                
                hide_catlist();
                location.replace("<?php echo current_url();?>");
            }
        });
    }
    //Save Catlist
    function save_catlist() 
    {
        $(".loader2").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: $("#frmCatgSingle").serialize(),
            cache: false,
            success: function(responce)
            {     
                $(".loader2").html('');
                //hide_catlist();
                location.replace("<?php echo current_url();?>");
            }
        });
    }
    /*Category List*/
	
	<?php if($error) { ?>

       alert("<?php echo implode("\n",$error);?>");

        <?php }?>

</script>
<?php $this->load->view('common/footer'); ?>