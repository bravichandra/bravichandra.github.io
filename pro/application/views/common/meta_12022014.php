<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title>SalesScripter Application</title>

<link href="<?php echo base_url();?>css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="http://salesscripter.com/wp-content/themes/Avada/images/favicon.ico" />
<!--[if IE]> <link href="css/ie.css" rel="stylesheet" type="text/css"> <![endif]-->

<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script src="<?php echo base_url(); ?>js/handlebars.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jeditable.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo base_url(); ?>js/pop-up.js"></script> 

<script>
var BASE_URL = '<?php echo base_url(); ?>';
</script>

<style>
.is_paid {display:none;}
.wrapper-hide{display:none;}
span.edit_session:hover {background: #F2F0A5;}
</style>

<script type="text/javascript">
var product_data = new Array();

$(document).ready(function(){

	 $('.edit_session').editable('<?php echo base_url();?>home/editSession', { 
  	   name       : 'value',
         id         : 'id',
  	   type : 'textarea',
  	   submit   : 'Update',
  	   width      : '400px',
         height     : '50px',
         tooltip : "Click to edit...",
         style : "",
         requireProductTxt : "Click to edit",
         clsName				: 'edit_area',
         callback : function(value, settings) {
             //console.log(value);
         }
  });


	$('hide-class').removeClass('wrapper-hide')
	dynamicText();

		$('#btn1').click(function(e){

			$.ajax({
				  type: "POST",
				  url: BASE_URL + 'home/addCredibility/',
				  data: '',
				  cache: false,
				  dataType: 'json',
				  success: function(response)
				  {
						var source   = $("#template-credibility").html();
						var template = Handlebars.compile(source);

						// Add Template on PAGES
						$('.container-story').prepend(template(response));

						dynamicText();
				  }
				});

		});

		$('#Pbtn1').click(function(e){

			$.ajax({
				  type: "POST",
				  url: BASE_URL + 'home/addProduct/',
				  data: '',
				  cache: false,
				  dataType: 'json',
				  success: function(response)
				  {
				  	window.location = BASE_URL + 'step/product';
				  }
				});
		});

		$('#save-session').click(function(e){

			$.ajax({
				  type: "POST",
				  url: BASE_URL + 'home/updateSession/',
				  data: '',
				  cache: false,
				  dataType: 'json',
				  success: function(response)
				  {
				  	window.location = BASE_URL + 'step/product';
				  }
				});
		});

});

function autoFill(p_id)
{
	var tech_text = $('.dynamicFillTec_'+p_id).val();
	if(tech_text != null)
	{
		$('.dynamicFillTecArea_'+p_id).text(tech_text);
	}

	var bus_text = $('.dynamicFillBus_'+p_id).val();
	if(bus_text != null)
	{
		$('.dynamicFillBusArea_'+p_id).text(bus_text);
	}
}
function TechdynamicText()
{
    var TaCounter = 0;
    var ta_answer = "";
    
    jQuery('.TechValues').each(function() {
        var currentElement = $(this);
        if(TaCounter == 0)
            {
            //alert(currentElement[0].val());
            ta_answer += "" + currentElement.val();
            //var value = currentElement.val(); // if it is an input/select/textarea field
            // TODO: do something with the value
            }
            TaCounter++;
    });
    document.getElementById("Vtech-s").value =ta_answer;
}
function BusdynamicText()
{
    var BaCounter = 0;
    var ba_answer = "";
    jQuery('.BusValues').each(function() {
        var currentElement = $(this);

        if(BaCounter == 0)
        {
            //alert(currentElement[0].val());
            ba_answer += "" + currentElement.val();
            //var value = currentElement.val(); // if it is an input/select/textarea field
            // TODO: do something with the value
        }
        BaCounter++;
    });
    document.getElementById("Vbus-s").value =ba_answer;
} 
function PersdynamicText()
{
    var PaCounter = 0;
    var pa_answer = "";
    jQuery('.PersValues').each(function() {
        var currentElement = $(this);

        if(PaCounter == 0)
        {
            //alert(currentElement[0].val());
            pa_answer += "" + currentElement.val();
            //var value = currentElement.val(); // if it is an input/select/textarea field
            // TODO: do something with the value
        }
        PaCounter++;
    });
    document.getElementById("Vpers-s").value =pa_answer;
}
function dynamicText()
{
	$('.dynamicTxt').keyup(function(e){

		var obj 	= $(e.currentTarget);
		var id 		= obj.attr('id');
		var value 	= obj.val();
                
                
                
		var split_text = id.split('_');
		var text = split_text[0].split('V');
                
//                document.getElementById("Vtech-s").value = "" + 
//                "A:" + document.getElementById(id).value;

		var tech_text = $('.dynamicFillTec_'+text[1]).val();
		$('.dynamicFillTecArea_'+text[1]).text(tech_text);

		var bus_text = $('.dynamicFillBus_'+text[1]).val();

		$('.dynamicFillBusArea_'+text[1]).text(bus_text);

		var vs_bus = $('.vs_p_table_1').val();
		var vs_pers = $('.vsp_p_table_1').val();

		if(vs_bus != '')
		{
			$('#bus-s').text(vs_bus);
		}

		if(vs_pers != '')
		{
			$('#pers-s').text(vs_pers);
		}

		$('.dynamicTxt_'+id).text(value);			
	});
        

	$('.dynamicTxt').blur(function(e){

		var obj 	= $(e.currentTarget);
		var id 		= obj.attr('id');
		var value 	= obj.val();

		var split_text = id.split('_');
		var text = split_text[0].split('V');

		var tech_text = $('.dynamicFillTec_'+text[1]).val();
		$('.dynamicFillTecArea_'+text[1]).text(tech_text);

		var bus_text = $('.dynamicFillBus_'+text[1]).val();
		$('.dynamicFillBusArea_'+text[1]).text(bus_text);

		var vs_bus = $('.vs_p_table_1').val();
		var vs_pers = $('.vsp_p_table_1').val();

		if(vs_bus != '')
		{
			$('#bus-s').val(vs_bus);
		}

		if(vs_pers != '')
		{
			$('#pers-s').val(vs_pers);
		}

		$('.dynamicTxt_'+id).text(value);			
	});
}

function addRow(table_id,type,p_id) 
{
	//return;
    var table = document.getElementById(table_id);
    var i = table.rows.length;

    if(type == 'T')
    {
       var field_name = "tech_value";
       var table_name = "tpd_"+p_id;
    }

    if(type == 'B')
    {
       var field_name = "bus_value";
       var table_name = "tpd_"+p_id;
    }

    if(type == 'P')
    {
       var field_name = "pers_value";
       var table_name = "tpd_"+p_id;
    }

	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/add/'+p_id+'/'+type,
		  data: 'field_name='+field_name+'&table_name='+table_name,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  { 
                      if(response.tech_count > 1)
			{
			  $("#show-tech").show();
			  $("#show-tech-heading").show();
			}
                        if(response.bus_count > 1)
			{
			  $("#show-bus").show();
			  $("#show-tech-heading").show();
			}
                        if(response.pers_count > 1)
			{
			  
			  $("#show-pers").show();
			  $("#show-tech-heading").show();
			}
			if(response.tech_count > 1 || response.bus_count > 1 || response.pers_count > 1)
			{ /*
			  $("#show-tech").show();
			  $("#show-bus").show();
			  $("#show-pers").show();
			  $("#show-tech-heading").show();  */
			}
			else
			{
				  var b_value = '[business value 1]';
				  var p_value = '[personal value 1]';
			}
                    var KeyUPFun = "";
                    var TextClass = "";
                    
                    if(type == 'T')
                    {
                        var heading = 'Added Technical Benefit';
                        var field_name = "tpd_"+p_id+"[tech_value]["+response.id+"][]";
                        var lable = '<div align="center" class="TextColorH">Technical Value</div>';
                        TextClass = "TechValues";
                        KeyUPFun = 'onkeyup="TechdynamicText();"';
                    }

		    if(type == 'B')
		    {
		       var heading = 'Added Business Benefit';
		       var field_name = "tpd_"+p_id+"[bus_value]["+response.id+"][]";
		       var lable = '<div align="center" class="TextColorH">Business Value</div>';
                       TextClass = "BusValues";
                       KeyUPFun = 'onkeyup="BusdynamicText();"';
		    }

		    if(type == 'P')
		    {
		       var heading = 'Added Personal Benefit';
		       var field_name = "tpd_"+p_id+"[pers_value]["+response.id+"][]";
		       var lable = '<div align="center" class="TextColorH">Personal Value</div>';
                       TextClass = "PersValues";
                       KeyUPFun = 'onkeyup="PersdynamicText();"';
		    }

		    var id = "V"+p_id+'_'+response.id;

		    var newRow = table.insertRow(-1);

		    var blurClass = "class=dynamicTxt_V"+p_id+"_"+response.id;
                    
                    var DynamicSpan = "class=dynamicTxt_V"+p_id+"_"+response.id;
                    
		    var deladd = "delSingleAdditionalQus('"+response.id+"','value');";

		    var rowInnerHTML =

                '<td class="no-border">'+ heading + '</td>'

                +'<td class="no-border"></td>'

                +'<td class="no-border"></td>'

                +'<td class="no-border">'+lable+'<textarea id='+id+' class="validate[required] dynamicTxt '+TextClass+'" style="width:350px;" name="'+ field_name +'" cols="" rows="" '+KeyUPFun+'></textarea><div align="center" class="TextColorH">Answer Checker</div><div align="center">We help <span class="dynamicFillTecArea TextColor"><?php echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> to <span class="dynamicTxt_'+ id +' TextColor"></span>.</div></td>\n'+ '\n'

                +'<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="'+deladd+'">&times;</a></td>';
                
                
                
		    if(type == 'B' || type == 'P')
		    {
				if(type == 'B' && product_data[p_id]['business']['first_time'] == true)
				{
                                    rowInnerHTML = 

                                             '<td class="no-border" style="width: 13em;">When my customers are able to see the improvement of</td>'

                                 +'<td class="grid5 no-border" style="width: 20em;" ><span class="TextColor dynamicFillTecArea_'+p_id+'"></span></td>'

                                 +'<td class="no-border" style="width: 38em;">a business improvement (revenue, costs, services) that they can see is</td>'

                                 +'<div class="grid5"><div align="center" class="TextColorH">Business Value</div><textarea class="validate[required] vs_'+table_id+' dynamicTxt '+TextClass+' dynamicFillBus_'+p_id+'" style="width:350px;margin-left: 12px;margin-bottom: 9px;" name="'+ field_name +'" id='+id+' cols="" rows="" '+KeyUPFun+'>[business value 1]</textarea></div></td><td class="no-border"><div class="grid4"><div id="1" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>';

					product_data[p_id]['business']['first_time'] = false;

					newRow.innerHTML = rowInnerHTML;
                                        
					var RUN_AUTOFILL_METHOD = true;
				}
				else
				{
					newRow.innerHTML = rowInnerHTML;
				}

				if(type == 'P' && product_data[p_id]['personal']['first_time'] == true)
				{
					rowInnerHTML = 

						 '<td class="no-border" style="width: 13em;">When my customers are able to see the improvements of</td>'

			             +'<td class="grid5 no-border" style="width: 20em;" ><span class="TextColor dynamicFillTecArea_'+p_id+'"></span> and <span class="TextColor dynamicFillBusArea_'+p_id+'"></span></td>'

			             +'<td class="no-border" style="width: 38em;"> a personal improvement (career, compensation, work environment) that they can see is</td>'

			             +'<div class="grid5"><div align="center" class="TextColorH">Personal Value</div><textarea class="validate[required] dynamicTxt vsp_'+table_id+' '+TextClass+'" style="width:350px;margin-left: 12px;margin-bottom: 9px;" name="'+ field_name +'" id='+id+' cols="" rows="" '+KeyUPFun+'>[personal value 1]</textarea></div></td><td class="no-border"><div class="grid4"><div id="1" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>';

			        product_data[p_id]['personal']['first_time'] = false;

					newRow.innerHTML = rowInnerHTML;

					var RUN_AUTOFILL_METHOD = true;
				}
				else
				{
					newRow.innerHTML = rowInnerHTML;
				}
		    }
		    else
		    {
                        
		    	newRow.innerHTML = rowInnerHTML;
                        RadioRow.innerHTML = RadioTrInnerHTML;  // Added by Punit 
		    }
                                    
				    if(type == 'T')
				    {
				    	 $('#tech-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
                                       /*  $('#TechAnswerCheck').append("<p class='TextColor'><span "+DynamicSpan+"></p><span>");*/
				    }
				    if(type == 'B')
				    {
				    	 $('#bus-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
                                       /*  $('#BusAnswerCheck').append("<p class='TextColor'><span "+DynamicSpan+"></p><span>");*/
				    }
				    if(type == 'P')
				    {
				    	 $('#pers-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
                                       /*  $('#PersAnswerCheck').append("<p class='TextColor'><span "+DynamicSpan+"></p><span>");*/
				    }
                                    
				    dynamicText();
                                    /*
                                    TechdynamicText();
                                    BusdynamicText();
                                    PersdynamicText(); */

				    if(typeof RUN_AUTOFILL_METHOD != "undefined"){
				    	autoFill(p_id);
					}
		}
	});
    }

function addQualifyRow(table_id,type,p_id) 
{
    var table = document.getElementById(table_id);
    var i = table.rows.length;

    if(type == 'T')
    {
       var field_name = "single_tech_qualify";
       var table_name = "tpd_"+p_id;
    }
    if(type == 'B')
    {
       var field_name = "single_bus_qualify";
       var table_name = "tpd_"+p_id; 
    }
    if(type == 'P')
    {
       var field_name = "single_pers_qualify";
       var table_name = "tpd_"+p_id; 
    }

    var lable = '<div align="center" class="TextColorH">Qualifying Question</div>';
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/add/',
		  data: 'field_name='+field_name+'&table_name='+table_name,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
                    if(type == 'T')
		    {
		       var heading = 'What question would you ask the prospect to identify if they have';
		       var field_name = "tpd_"+p_id+"[single_tech_qualify]["+response.id+"][]";
		       var field_desc = "tpd_"+p_id+"[desc_tech_qualify]["+response.d_id+"][]";
		    }
		    if(type == 'B')
		    {
		       var heading = 'What question would you ask the prospect to identify if they have';
		       var field_name = "tpd_"+p_id+"[single_bus_qualify]["+response.id+"][]";
		       var field_desc = "tpd_"+p_id+"[desc_bus_qualify]["+response.d_id+"][]"; 
		    }
		    if(type == 'P')
		    {
		       var heading = 'What question would you ask the prospect to identify if they have';
		       var field_name = "tpd_"+p_id+"[single_pers_qualify]["+response.id+"][]";
		       var field_desc = "tpd_"+p_id+"[desc_pers_qualify]["+response.d_id+"][]";
		    }
		    var id = "V"+p_id+'_'+response.id;
		    var detail_id = "V"+p_id+'_'+response.d_id;

		    var newRow = table.insertRow(-1);
		    var newRow2 = table.insertRow(-1);

		    var blurClass = "class=dynamicTxt_V"+p_id+"_"+response.id;

		    var deladd = "delSingleAdditionalQus('"+response.id+"','qualifying');";

		    newRow.innerHTML =

		                '<td class="no-border">'+ heading + '</td>'

		                +'<td class="no-border"></td>'

		                +'<td class="no-border"></td>'

		                +'<td class="no-border">'+lable+'<textarea id='+id+' class="validate[required] dynamicTxt" style="width:350px;" name="'+ field_name +'" cols="" rows=""></textarea></td>\n'+ '\n'

		                +'<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="'+deladd+'">&times;</a></td>';

				    $('#tech-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
				    dynamicText();
				}
		});
}

function addPainRow(table_id,type,p_id)
{
    var table = document.getElementById(table_id);
    var i = table.rows.length;

            if(type == 'T')
	    {
	       var field_name = "tech_pain";
	       var table_name = "tpd_"+p_id;
	       var lable = '<div align="center" class="TextColorH">Technical Pain</div>';
	    }
	    if(type == 'B')
	    {
	       var field_name = "bus_pain";
	       var table_name = "tpd_"+p_id;
	       var lable = '<div align="center" class="TextColorH">Business Pain</div>';
	    }
	    if(type == 'P')
	    {
	       var field_name = "pers_pain";
	       var table_name = "tpd_"+p_id;
	       var lable = '<div align="center" class="TextColorH">Personal Pain</div>';
	    }

	    var lable_detail = '<div align="center" class="TextColorH">Ideal Prospect Environment</div>';

	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/addPain/',
		  data: 'field_name='+field_name+'&table_name='+table_name+'&p_id='+p_id+'&type='+type,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {

		    if(type == 'T')
		    {
		       var heading = response.first_value;
		       var desc_heading = 'Added Technical Detail';
		       var field_name = "tpd_"+p_id+"[tech_pain]["+response.id+"][]";
		       var field_desc = "tpd_"+p_id+"[desc_tech_pain]["+response.d_id+"][]";
		    }
		    if(type == 'B')
		    {
			   var heading = response.first_value;
		       var desc_heading = 'Added Business Detail';
		       var field_name = "tpd_"+p_id+"[bus_pain]["+response.id+"][]";
		       var field_desc = "tpd_"+p_id+"[desc_bus_pain]["+response.d_id+"][]";
				  if(response.total_q > 1)
				  {
					  var qus_text = '';
					  var detail_text = '';
				  }
				  else
				  {
					  var qus_text = '[business pain 1]';
					  var detail_text = '[cause of business pain 1]';
				  }
		    }
		    if(type == 'P')
		    {
		       var heading = response.first_value;
		       var desc_heading = 'Added Personal Detail';
		       var field_name = "tpd_"+p_id+"[pers_pain]["+response.id+"][]";
		       var field_desc = "tpd_"+p_id+"[desc_pers_pain]["+response.d_id+"][]";

		       if(response.total_q > 1)
				  {
					  var qus_text = '';
					  var detail_text = '';
				  }
				  else
				  {
					  var qus_text = '[personal pain 1]';
					  var detail_text = '[cause of personal pain 1]';
				  }
		    }

		    var newRow1 = table.insertRow(-1);
		    var newRow2 = table.insertRow(-1);

		    var deladd = "delAdditionalQus('"+response.id+"','"+response.d_id+"','pain');";

		    newRow1.innerHTML =

			    		'<td class="grid5 no-border" style="width: 25em;" >When my customers are interested in seeing the technical improvement of</td>'

		                +'<td class="no-border TextColor" style="width: 20em;">'+ heading + '</td>'

		                +'<td class="no-border" style="width: 22em;">they are usually having a technical challenge of</td>'

		                +'<td class="no-border"><div class="grid5">'+lable+'<textarea id="P'+p_id+'_'+response.d_id+'" class="validate[required] dynamicTxt" style="width:350px;" name="'+ field_name +'" cols="" rows="" >'+qus_text+'</textarea></div></td>'

		                +'<td class="no-border"><div class="grid5"></div></td>\n'+ '\n'

		                +'<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="'+deladd+'">&times;</a></td>';

		    newRow2.innerHTML =

			    '';
                    
                    /*
                    newRow2.innerHTML =

			    '<td class="no-border" style="width: 25em;">When my customers have</td>'

		        +'<td class="no-border dynamicTxt_P'+p_id+'_'+response.d_id+' TextColor" style="width: 20em;">'+ desc_heading + '</td>'

		        +'<td class="no-border" style="width: 22em;">, something that could be causing that is </td>'

		        +'<td class="no-border"><div class="grid5">'+lable_detail+'<textarea class="validate[required] dynamicTxt" style="width:350px;" name="'+ field_desc +'" cols="" rows="" >'+detail_text+'</textarea></div></td>'

		        +'<td class="no-border"><div class="grid5"></div></td>\n'+ '\n';
                    */

				    dynamicText();
				}
		});
}

function delAdditionalQus(q_id,d_id,step)
{
	$("#redirect_url").val(BASE_URL + 'home/delete_ques/?qus_id='+q_id+'&detail_id='+d_id+'&step='+step);
	$('#frm-input').submit();
	//return;
	//show confirm message
	/*var answer = confirm("Please make sure save your work before delete anything?")
	if (answer){
		$('#frm-input').submit();

		//window.location.href = BASE_URL + 'step/' + step;

		$.ajax({
			  type: "POST",
			  url: BASE_URL + 'home/delete_ques/',
			  data: 'qus_id='+q_id+'&detail_id='+d_id,
			  cache: false,
			  dataType: 'json',
			  success: function(response)
			  {
				$("#frm-input").submit();
			  }
			});
	}
	else
	{
		return;
	}*/
}

function delSingleAdditionalQus(q_id,step)
{
	//show confirm message
	$("#redirect_url").val(BASE_URL + 'home/delete_single_ques/?qus_id='+q_id+'&step='+step);
	$('#frm-input').submit();

	/*var answer = confirm("Your changes will be saved automatically and selected item will be deleted.")
	if (answer){

		$('#frm-input').submit();

		$.ajax({
			  type: "POST",
			  url: BASE_URL + 'home/delete_single_ques/',
			  data: 'qus_id='+q_id+'&step='+step,
			  cache: false,
			  dataType: 'json',
			  success: function(response)
			  {
			  	window.location.href = BASE_URL + 'step/' + step;
			  }
			});
	}
	else
	{
		return;
	}*/

}

function delCredibility(c_id,step)
{
	//show confirm message
	var answer = confirm("Please make sure save your work before delete anything?")
	if (answer){
		$.ajax({
			  type: "POST",
			  url: BASE_URL + 'home/delete_credibility/',
			  data: 'c_id='+c_id+'&step='+step,
			  cache: false,
			  dataType: 'json',
			  success: function(response)
			  {
			  	window.location.href = BASE_URL + 'step/' + step;
			  }
			});
	}
	else
	{
		return;
	}
}

function deleteSession(session_id,status)
{
	//show confirm message
	var answer = confirm("Are you sure you want to proceed?")
	if (answer){
		$.ajax({
			  type: "POST",
			  url: BASE_URL + 'home/delete_session/',
			  data: 'session_id='+session_id+'&status='+status,
			  cache: false,
			  dataType: 'json',
			  success: function(response)
			  {
			  	window.location.href = BASE_URL + 'folder/my-folder';
			  }
			});
	}
	else
	{
		return;
	}

}

function launchSession(session_id,t_m_session)
{
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/launch_session/',
		  data: 'session_id='+session_id+'&t_m_session='+t_m_session,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
		  	//console.log(response);
		  	window.location.href = BASE_URL + 'step/product';
		  }
		});
}

function deleteFrndRequest(frnd_id,action)
{
	//show confirm message
	var answer = confirm("Are you sure you want to proceed?")
	if (answer){
		$.ajax({
			  type: "POST",
			  url: BASE_URL + 'home/delete_frnd_request/',
			  data: 'frnd_id='+frnd_id+'&action='+action,
			  cache: false,
			  dataType: 'json',
			  success: function(response)
			  {
			  	window.location.href = BASE_URL + 'folder/team-folder';
			  }
			});
	}
	else
	{
		return;
	}

}

function requestAccept(invitation_user_id)
{
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/invitation_accept/',
		  data: 'invitation_user_id='+invitation_user_id,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
			window.location.href = BASE_URL + 'folder/team-folder';
		  }
		});
}

function saveToMyFolder(sessionId,sessionName,userId)
{
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/saveToMyFolder/',
		  data: 'session_id='+sessionId+'&session_name='+sessionName+'&user_id='+userId,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
			window.location.href = BASE_URL + 'folder/team-folder';
		  }
		});
}
</script>

<!-- Script Added By Aavid Developer -->
<script>
    $(document).ready(function() {
        
    if ($(".TechQuestion").is(":checked")) {
        if ($(this).val() == "Yes") {
            $("#TechnicalDiv").show();
        }
     }    
      
    if ($(".BusQuestion").is(":checked")) {
        if ($(this).val() == "Yes") {
            $("#BusinessDiv").show();
        }
     }
     
    if ($(".PersQuestion").is(":checked")) {
        if ($(this).val() == "Yes") {
            $("#PersonalDiv").show();
        }
     }
     
    $(".TechQuestion").change(function() {
        if ($(this).val() == "Yes") {
            $("#TechnicalDiv").show();
            /*$("#BusinessHeading").show();
            $("#BusYesNoQuestion").show();*/
        }
        if ($(this).val() == "No") {
            $("#TechnicalDiv").hide();
            $("#BusinessHeading").show();
            $("#BusYesNoQuestion").show();
        }
    });
    
    $(".BusQuestion").change(function() {
        if ($(this).val() == "Yes") {
            $("#BusinessDiv").show();
            /*$("#PersonalHeading").show();
            $("#PersYesNoQuestion").show();*/
        }
        if ($(this).val() == "No") {
            $("#BusinessDiv").hide();
            $("#PersonalHeading").show();
            $("#PersYesNoQuestion").show();
        }
    });
    
    $(".PersQuestion").change(function() {
        if ($(this).val() == "Yes") {
            $("#PersonalDiv").show();
        }
        if ($(this).val() == "No") {
            $("#PersonalDiv").hide();
        }
    });
});
function DynamicAddRow(table_id,type,p_id,OnClickVal,pro_1_value)
{   
    if(type == 'T')
    {
      var NumberOne = 1;
      if(OnClickVal == "Yes")
        {   
            var TechTrRowCount = $('#Tech_table_1 tr').length;
            var LastTechTrId = $('#Tech_table_1 tr:visible:last').prev('tr').attr("id");
            var ExpVal = LastTechTrId.split("TechTR");
            
            var TblRowNumber = parseInt(ExpVal[1]) + parseInt(NumberOne);
            var NextRowId  = "TechTR"+TblRowNumber;
            var RadioTrId = "TechTRRadio"+TblRowNumber;
            
            if(document.getElementById(NextRowId))
            {
                //alert("Row Found");
                document.getElementById(NextRowId).style.display = 'block';
                document.getElementById(RadioTrId).style.display = 'block';
                $('#'+RadioTrId).removeAttr('style');
                $('#Tech_table_1 tr:visible').removeAttr('style');
            }
            else
            {                
                AddingDynamicRow("Tech_table_1","T",p_id,NextRowId,pro_1_value);  
                $('#'+RadioTrId).removeAttr('style');
                $('#Tech_table_1 tr:visible').removeAttr('style');
            }      
            /*       
            $(".TechTrClass").each(function() {
                    //alert( this.id );
            }); */
        }
        if(OnClickVal == "No")
        {
            var TechTrRowCount = $('#Tech_table_1 tr').length;
            if(TechTrRowCount > 2)
            {
              $("#show-tech-heading").show();
              $("#show-tech").show();
            }
                        
            $("#BusinessHeading").show();
            $("#BusYesNoQuestion").show();
        }  
    }
    if(type == 'B')
    {
      var NumberOne = 1;      
      if(OnClickVal == "Yes")
        {   
            var BusTrRowCount = $('#Bus_table_1 tr').length;
            var LastTechTrId = $('#Bus_table_1 tr:visible:last').prev('tr').attr("id");
            
            if(BusTrRowCount > 0)
            {
                var ExpVal = LastTechTrId.split("BusTR");
            
                var TblRowNumber = parseInt(ExpVal[1]) + parseInt(NumberOne);
                var NextRowId  = "BusTR"+TblRowNumber;
                var RadioTrId = "BusTRRadio"+TblRowNumber;
                
                if(document.getElementById(NextRowId))
                {
                    //alert("Row Found");
                    document.getElementById(NextRowId).style.display = 'block'; 
                    document.getElementById(RadioTrId).style.display = 'block';
                    $('#'+RadioTrId).removeAttr('style');
                    $('#Bus_table_1 tr:visible').removeAttr('style');
                }
                else
                {
                    AddingDynamicRow("Bus_table_1","B",p_id,NextRowId,pro_1_value);
                    $('#'+RadioTrId).removeAttr('style');
                    $('#Bus_table_1 tr:visible').removeAttr('style');
                }
            }
            else
            {
                AddingDynamicRow("Bus_table_1","B",p_id,"BusTR1",pro_1_value);
                $('#'+RadioTrId).removeAttr('style');
                $('#Bus_table_1 tr:visible').removeAttr('style');
            }    
            
        }
        if(OnClickVal == "No")
        {
            var BusTrRowCount = $('#Bus_table_1 tr').length;
            if(BusTrRowCount > 2)
            {
              $("#show-tech-heading").show();
              $("#show-bus").show();
            }
            
            $("#PersonalHeading").show();
            $("#PersYesNoQuestion").show();
        }  
    }
    
    if(type == 'P')
    {
        var NumberOne = 1;
        if(OnClickVal == "Yes")
        {   
            var TechTrRowCount = $('#Pers_table_1 tr').length;
            var LastTechTrId = $('#Pers_table_1 tr:visible:last').prev('tr').attr("id");
            
            if(TechTrRowCount > 1)
            {
                var ExpVal = LastTechTrId.split("PersTR");
            
                var TblRowNumber = parseInt(ExpVal[1]) + parseInt(NumberOne);
                var NextRowId  = "PersTR"+TblRowNumber;
                var RadioTrId = "PersTRRadio"+TblRowNumber;
                    
                if(document.getElementById(NextRowId))
                {
                    //alert("Row Found");
                    document.getElementById(NextRowId).style.display = 'block'; 
                    document.getElementById(RadioTrId).style.display = 'block';
                    $('#'+RadioTrId).removeAttr('style');
                    $('#Pers_table_1 tr:visible').removeAttr('style');
                }
                else
                {
                    AddingDynamicRow("Pers_table_1","P",p_id,NextRowId,pro_1_value); 
                    $('#'+RadioTrId).removeAttr('style');
                    $('#Pers_table_1 tr:visible').removeAttr('style');
                } 
            }
            else
            {
                AddingDynamicRow("Pers_table_1","P",p_id,"PersTR1",pro_1_value);    
                $('#'+RadioTrId).removeAttr('style');
                $('#Pers_table_1 tr:visible').removeAttr('style');
            }
             
        }
        if(OnClickVal == "No")
        {
            var PersTrRowCount = $('#Pers_table_1 tr').length;
            if(PersTrRowCount > 2)
            {
              $("#show-tech-heading").show();
              $("#show-pers").show();
            }
        }
    }    
}
function AddNewRow(table_id,type,p_id,table_rowid,OnClickVal,pro_1_value)
{
    //return;
    var table = document.getElementById(table_id);
    var i = table.rows.length;
    var NumberOne = 1;
    var tableRowId = "";
    var tableRadioRow = "";
    if(type == 'T')
    {
       var field_name = "tech_value";
       var table_name = "tpd_"+p_id;
       
       var ExpVal = table_rowid.split("TechTR");
       var TblRowNumber = parseInt(ExpVal[1]) + parseInt(NumberOne);
       tableRowId  = "TechTR"+TblRowNumber;
       tableRadioRow = "TechTRRadio"+TblRowNumber;
    }

    if(type == 'B')
    {
      var NumberOne = 1;      
      if(OnClickVal == "Yes")
        {   
            var BusTrRowCount = $('#Bus_table_1 tr').length;
            var LastBusTrId = $('#Bus_table_1 tr:visible:last').prev('tr').attr("id");
            
            if(BusTrRowCount > 0)
            {
                var ExpVal = LastBusTrId.split("BusTR");
            
                var TblRowNumber = parseInt(ExpVal[1]) + parseInt(NumberOne);
                var NextRowId  = "BusTR"+TblRowNumber;
                var RadioTrId = "BusTRRadio"+TblRowNumber;
                
                if(document.getElementById(NextRowId))
                {
                    document.getElementById(NextRowId).style.display = 'block'; 
                    document.getElementById(RadioTrId).style.display = 'block';
                }
                else
                {
                    AddingDynamicRow("Bus_table_1","B",p_id,NextRowId,pro_1_value);
                }
            }
            else
            {
                AddingDynamicRow("Bus_table_1","B",p_id,"BusTR1",pro_1_value);
            }
        }
    }

    if(type == 'P')
    {
       var NumberOne = 1;      
      if(OnClickVal == "Yes")
        {   
            var PersTrRowCount = $('#Pers_table_1 tr').length;
            var LastPersTrId = $('#Pers_table_1 tr:visible:last').prev('tr').attr("id");
            
            if(PersTrRowCount > 0)
            {
                var ExpVal = LastPersTrId.split("PersTR");
            
                var TblRowNumber = parseInt(ExpVal[1]) + parseInt(NumberOne);
                var NextRowId  = "PersTR"+TblRowNumber;
                var RadioTrId = "PersTRRadio"+TblRowNumber;
                
                if(document.getElementById(NextRowId))
                {
                    document.getElementById(NextRowId).style.display = 'block'; 
                    document.getElementById(RadioTrId).style.display = 'block';
                    $('#'+RadioTrId).removeAttr('style');
                }
                else
                {
                    AddingDynamicRow("Pers_table_1","P",p_id,NextRowId,pro_1_value);
                    $('#'+RadioTrId).removeAttr('style');
                    
                }
            }
            else
            {
                AddingDynamicRow("Pers_table_1","P",p_id,"PersTR1",pro_1_value);
                $('#'+RadioTrId).removeAttr('style');
            }
        }
    }
    
}
function AddingDynamicRow(table_id,type,p_id,NewTrName,pro_1_value)
{
   var table = document.getElementById(table_id);
    var i = table.rows.length;

    if(type == 'T')
    {
       var field_name = "tech_value";
       var table_name = "tpd_"+p_id;
    }

    if(type == 'B')
    {
       var field_name = "bus_value";
       var table_name = "tpd_"+p_id;
    }

    if(type == 'P')
    {
       var field_name = "pers_value";
       var table_name = "tpd_"+p_id;
    }

	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/add/'+p_id+'/'+type,
		  data: 'field_name='+field_name+'&table_name='+table_name,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  { 
                      /*if(response.tech_count > 1)
			{
			  $("#show-tech").show();
			  $("#show-tech-heading").show();
			}
                        if(response.bus_count > 1)
			{
			  $("#show-bus").show();
			  $("#show-tech-heading").show();
			}
                        if(response.pers_count > 1)
			{
			  
			  $("#show-pers").show();
			  $("#show-tech-heading").show();
			}
			if(response.tech_count > 1 || response.bus_count > 1 || response.pers_count > 1)
			{ /*
			  $("#show-tech").show();
			  $("#show-bus").show();
			  $("#show-pers").show();
			  $("#show-tech-heading").show();  */
			/*}
			else
			{
				  var b_value = '[business value 1]';
				  var p_value = '[personal value 1]';
			}*/
                    var KeyUPFun = "";
                    var TextClass = "";
                    
                    //Radio Button Information
                    var BtnName = "";
                    var BtnId = "";
                    var BtnClass = "";
                    var RadioTrId = "";
                    
                    if(type == 'T')
                    {
                        var heading = 'Added Technical Benefit';
                        var field_name = "tpd_"+p_id+"[tech_value]["+response.id+"][]";
                        var lable = '<div align="center" class="TextColorH">Technical Value</div>';
                        TextClass = "TechValues";
                        KeyUPFun = 'onkeyup="TechdynamicText();"';
                        
                        BtnName = "TechAnswer";
                        BtnId = "TechAnswerRadioId";
                        BtnClass = "TechAnswer";
                        
                        RadioTrId = "TechTRRadio";
                    }

		    if(type == 'B')
		    {
		       var heading = 'Added Business Benefit';
		       var field_name = "tpd_"+p_id+"[bus_value]["+response.id+"][]";
		       var lable = '<div align="center" class="TextColorH">Business Value</div>';
                       TextClass = "BusValues";
                       KeyUPFun = 'onkeyup="BusdynamicText();"';
                       
                       BtnName = "BusAnswer";
                       BtnId = "BusAnswerRadioId";
                       BtnClass = "BusAnswer";
                       
                       RadioTrId = "BusTRRadio";
		    }

		    if(type == 'P')
		    {
		       var heading = 'Added Personal Benefit';
		       var field_name = "tpd_"+p_id+"[pers_value]["+response.id+"][]";
		       var lable = '<div align="center" class="TextColorH">Personal Value</div>';
                       TextClass = "PersValues";
                       KeyUPFun = 'onkeyup="PersdynamicText();"';
                       
                       BtnName = "PersAnswer";
                       BtnId = "PersAnswerRadioId";
                       BtnClass = "PersAnswer";
                       
                       RadioTrId = "PersTRRadio";
		    }

		    var id = "V"+p_id+'_'+response.id;

		    var newRow = table.insertRow(-1);
                    
                    var RadioRow = table.insertRow(-1);
                    
                    newRow.setAttribute("id", NewTrName);
                    
                    RadioRow.setAttribute("id", RadioTrId);
                    
		    var blurClass = "class=dynamicTxt_V"+p_id+"_"+response.id;
                    
                    var DynamicSpan = "class=dynamicTxt_V"+p_id+"_"+response.id;
                    
		    var deladd = "delSingleAdditionalQus('"+response.id+"','value');";  
                    
                    var pro_1_val = pro_1_value;
                    
                    var rowInnerHTML =

                    '<td class="no-border">'+ heading + '</td>'

                    +'<td class="no-border"></td>'

                    +'<td class="no-border"></td>'

                    +'<td class="no-border">'+lable+'<textarea id='+id+' class="validate[required] dynamicTxt '+TextClass+'" style="width:350px;" name="'+ field_name +'" cols="" rows="" '+KeyUPFun+'></textarea><div align="center" class="TextColorH">Answer Checker</div><div align="center">We help <span class="dynamicFillTecArea TextColor"><?php echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> to <span class="dynamicTxt_'+ id +' TextColor"></span>.</div></td>\n'+ '\n'

                    +'<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="'+deladd+'">&times;</a></td>';

                    
                
                    var RadioTrInnerHTML = "<td colspan='5'>"+
                        "Does <a title'' href='<?php echo base_url();?>index.php/step/product'> "+pro_1_value+" </a>deliver any other technical improvements?<br/>"+
                        "<input type='radio' name='"+BtnName+"' id='"+BtnId+"' class='"+BtnClass+"' onclick='DynamicAddRow(\""+table_id+"\",\""+type+"\",\""+p_id+"\",this.value,\""+pro_1_val+"\");' value='Yes'>Yes </br>"+
                        "<input type='radio' name='"+BtnName+"' id='"+BtnId+"' class='"+BtnClass+"' onclick='DynamicAddRow(\""+table_id+"\",\""+type+"\",\""+p_id+"\",this.value,\""+pro_1_val+"\");' value='No'>No </br>"+
                        "</td>";
                    
                /*
		    var rowInnerHTML =

                '<td class="no-border" style="width:60%;">'+ heading + '</td>'

                +'<td class="no-border"></td>'

                +'<td class="no-border"></td>'

                +'<td class="no-border">'+lable+'<textarea id='+id+' class="validate[required] dynamicTxt '+TextClass+'" style="width:350px;" name="'+ field_name +'" cols="" rows="" '+KeyUPFun+'></textarea><div align="center" class="TextColorH">Answer Checker</div><div align="center">We help <span class="dynamicFillTecArea TextColor"><?php echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> to <span class="dynamicTxt_'+ id +' TextColor"></span>.</div></td>\n'+ '\n'

                +'<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="'+deladd+'">&times;</a></td>';
                */
		    if(type == 'B' || type == 'P')
		    {
				if(type == 'B' && product_data[p_id]['business']['first_time'] == true)
				{
                                        rowInnerHTML = 

                                        '<td class="no-border" style="width: 13em;">When my customers are able to see the improvement of</td>'

                                        +'<td class="grid5 no-border" style="width: 20em;" ><span class="TextColor dynamicFillTecArea_'+p_id+'"></span></td>'

                                        +'<td class="no-border" style="width: 38em;">a business improvement (revenue, costs, services) that they can see is</td>'

                                        +'<div class="grid5"><div align="center" class="TextColorH">Business Value</div><textarea class="validate[required] vs_'+table_id+' dynamicTxt dynamicFillBus_'+p_id+'" style="width:350px;margin-left: 12px;margin-bottom: 9px;" name="'+ field_name +'" id='+id+' cols="" rows="">[business value 1]</textarea></div></td><td class="no-border"><div class="grid4"><div id="1" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>';

					product_data[p_id]['business']['first_time'] = false;

					newRow.innerHTML = rowInnerHTML;

					var RUN_AUTOFILL_METHOD = true;
				}
				else
				{
					newRow.innerHTML = rowInnerHTML;
                                        RadioRow.innerHTML = RadioTrInnerHTML;  // Added by Punit 
				}

				if(type == 'P' && product_data[p_id]['personal']['first_time'] == true)
				{
					rowInnerHTML = 

                                            '<td class="no-border" style="width: 13em;">When my customers are able to see the improvements of</td>'

                                            +'<td class="grid5 no-border" style="width: 20em;" ><span class="TextColor dynamicFillTecArea_'+p_id+'"></span> and <span class="TextColor dynamicFillBusArea_'+p_id+'"></span></td>'

                                            +'<td class="no-border" style="width: 38em;"> a personal improvement (career, compensation, work environment) that they can see is</td>'

                                            +'<div class="grid5"><div align="center" class="TextColorH">Personal Value</div><textarea class="validate[required] dynamicTxt vsp_'+table_id+'" style="width:350px;margin-left: 12px;margin-bottom: 9px;" name="'+ field_name +'" id='+id+' cols="" rows="">[personal value 1]</textarea></div></td><td class="no-border"><div class="grid4"><div id="1" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>';

                                        product_data[p_id]['personal']['first_time'] = false;

					newRow.innerHTML = rowInnerHTML;
                                        RadioRow.innerHTML = RadioTrInnerHTML;  // Added by Punit 

					var RUN_AUTOFILL_METHOD = true;
				}
				else
				{
					newRow.innerHTML = rowInnerHTML;
                                        RadioRow.innerHTML = RadioTrInnerHTML;  // Added by Punit 
				}
		    }
		    else
		    {
		    	newRow.innerHTML = rowInnerHTML;
                        RadioRow.innerHTML = RadioTrInnerHTML;  // Added by Punit 
		    }
                                    
				    if(type == 'T')
				    {
				    	 $('#tech-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
                                       /*  $('#TechAnswerCheck').append("<p class='TextColor'><span "+DynamicSpan+"></p><span>");*/
				    }
				    if(type == 'B')
				    {
				    	 $('#bus-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
                                       /*  $('#BusAnswerCheck').append("<p class='TextColor'><span "+DynamicSpan+"></p><span>");*/
				    }
				    if(type == 'P')
				    {
				    	 $('#pers-value').append("<p class='TextColor'><span "+blurClass+"></p><span>");
                                       /*  $('#PersAnswerCheck').append("<p class='TextColor'><span "+DynamicSpan+"></p><span>");*/
				    }
                                    
				    dynamicText();

				    if(typeof RUN_AUTOFILL_METHOD != "undefined"){
				    	autoFill(p_id);
					}
                                        
                                    if(type == 'T')
                                    {
                                        //$('#Tech_table_1 tr:nth-child(2)').removeAttr("display");
                                        //$('#Tech_table_1 tr:nth-child(1)').removeAttr("style");
                                        //$('#Tech_table_1 tr:nth-child(2)').removeAttr("style");
                                        $('#Tech_table_1 tr:visible').removeAttr('style');
                                        
                                    }
                                    if(type == 'B')
                                    {
                                        //$('#Bus_table_1 tr:nth-child(2)').removeAttr("style");
                                        //$('#Bus_table_1 tr.:nth-child(2)').removeAttr("style");
                                        $('#Bus_table_1 tr:visible').removeAttr('style');
                                    }
                                    if(type == 'P')
                                    {
                                        //$('#Pers_table_1 tr:nth-child(2)').removeAttr("style");
                                        //$('#Pers_table_1 tr:nth-child(2)').removeAttr("style");
                                        $('#Pers_table_1 tr:visible').removeAttr('style');
                                    }
                                  //$("input:radio").uniform();
                                  //$("select, .check, .check :checkbox, input:radio, input:file").uniform();  	
                	}
                        
	}); 
}
</script>
<!-- Script Added By Aavid Developer Ends here -->
<script id="template-credibility" type="text/x-handlebars-template">
    	<div class="widget tableTabs">
    		 <div class="whead"><h6>Add New Client Story </h6><div align="right"style="margin-top:2px; margin-right: 10px;"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="delCredibility('{{id}}', 'credibility');"></a></div><div class="clear"></div></div>
          <div class="tab_container">
                <div id="ttab1" class="tab_content">
                                      <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <tbody>
                        	<thead>
                            </thead>
                            <tr>
                                <td class="no-border" colspan="5">Share a current or past customer of yours that is name droppable.</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tcd_{{id}}[customer][new][]" id="BC_1" cols="" rows=""></textarea></div></td>
                            	<td class="no-border" ><div class="grid5"><div id="16" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            <tr>
                                <td class="no-border" style="width: 13%;">When you worked with</td>
                                <td class="no-border"><span class="dynamicTxt_BC_1 TextColor"></span></td>
                                <td class="no-border" colspan="3">, what product or service did you provide?</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tcd_{{id}}[worked][new][]" id="BC_4"  cols="" rows=""></textarea></div></td>
                            	<td class="no-border" ><div class="grid5"><div id="17" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            <tr>
                                <td class="no-border">When you provided</td>
                                <td class="no-border" style="width:20%"><span class="dynamicTxt_BC_1 TextColor"></span></td>
                                <td class="no-border">with</td>
                                <td class="no-border" style="width:20%"><span class="dynamicTxt_BC_4 TextColor"></span></td>
                                <td class="no-border" style="width: 20%;">what was the technical improvement that was achieved (systems, processes, people)?</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tcd_{{id}}[provided][new][]" id="BC_7" cols="" rows=""></textarea></div></td>
                            	<td class="no-border" ><div class="grid5"><div id="18" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                             <tr>
                                <td class="no-border">When</td>
                                <td class="no-border" ><span class="dynamicTxt_BC_1 TextColor"></td>
                                <td class="no-border" style="width: 7%;" >was able to</td>
                                <td class="no-border"> <span class="dynamicTxt_BC_7 TextColor"></td>
                                <td class="no-border" >what was the business improvement that was achieved (revenue, costs, services)?</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tcd_{{id}}[when][new][]" id="BC_10" cols="" rows=""></textarea></div></td>
                            	<td class="no-border" ><div class="grid5"><div id="19" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>
</div>
</script>
<script id="template-product" type="text/x-handlebars-template">
        <div class="widget tableTabs">
        <div class="whead"><h6>Add New Product</h6><div class="clear"></div></div>
            <div class="tab_container">
                <div id="ttab1" class="tab_content">

                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <tbody>
                           <tr>
                                <td class="no-border" colspan="3">One of the products, services, or features that I sell is</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_{{id}}[P_Q1][new][]" id="P_Q1" cols="" rows=""></textarea></div></td>
                            </tr>
                            <tr>
                                <td class="no-border">A quick way to describe what</td>
                                <td class="grid5 no-border" style="width: 25em;" ><span class="dynamicTxt_P_Q1 TextColor"></span></td>
                                <td class="no-border">does (provides) would be to say that it</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" name="tpd_{{id}}[P_Q2][new][]" id="P_Q2" style="width:350px;" cols="" rows=""></textarea></div></td>
                            	<td class="no-border"><div class="grid4"><div id="1" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                             <tr>
                                <td class="no-border">One way that our</td>
                                <td class="grid5 no-border" style="width: 25em;" ><span class="dynamicTxt_P_Q2 TextColor"></span></td>
                                <td class="no-border">differs from our competition is</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" name="tpd_{{id}}[P_Q3][new][]" id="P_Q3" style="width:350px;" cols="" rows=""></textarea></div></td>
                            	<td class="no-border"><div class="grid4"><div id="2" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                             <tr>
                                <td class="no-border">If a prospect decides to not purchase</td>
                                <td class="grid5 no-border" style="width: 25em;" ><span class="dynamicTxt_P_Q3 TextColor"></span></td>
                                <td class="no-border"> and stay with the status quo, something negative that could happen and that they may want to be concerned about is </td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" name="tpd_{{id}}[P_Q4][new][]" id="P_Q4" style="width:350px;" cols="" rows=""></textarea></div></td>
                            	<td class="no-border"><div class="grid4"><div id="3" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>		 
        </div>
</script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/ui.spinner.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.mousewheel.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/charts/excanvas.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/charts/jquery.flot.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/charts/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/charts/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/charts/jquery.flot.resize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/charts/jquery.sparkline.min.js"></script> 

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/tables/jquery.sortable.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/tables/jquery.resizable.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/autogrowtextarea.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.uniform.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.autotab.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.chosen.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.dualListBox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.cleditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.ibutton.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/forms/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/uploader/plupload.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/wizards/jquery.form.wizard.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/wizards/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/wizards/jquery.form.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.breadcrumbs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.progress.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.colorpicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.fancybox.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.fileTree.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.sourcerer.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/others/jquery.fullcalendar.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/plugins/others/jquery.elfinder.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/plugins/ui/jquery.easytabs.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/files/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/files/functions.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/charts/chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/charts/hBar_side.js"></script>
</head>
<body>
