<?php echo $this->load->view('common/meta');?>

<?php echo $this->load->view('common/header');?>
<script type="text/javascript">
function addRow(table_id,type) 
{

    var table = document.getElementById(table_id);
    var i = table.rows.length;


    if(type == 'O')
    {
       var numObj = i + 1;
       var field_name = "tod_[custom_obj_Q"+numObj+"][new][]"; 
    }

    $("#objections").show();
    $("#response").show();


	$.ajax({
	  type: "POST",
	  url: BASE_URL + 'home/addObjection/',
	  data: '',
	  cache: false,
	  dataType: 'json',
	  success: function(response)
	  {
		  $(".widget").css({"border":"1px solid #CDCDCD"});
		    var newRow = table.insertRow(-1);

		    newRow.innerHTML =
		                '<td class="no-border">Custom Objection</td>'
		                +'<td class="no-border" style="width: 50em;"></td>'
		                +'<td class="no-border"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tod_'+response.id+'[question][new][]" cols="" rows="" id="Q_'+ response.id +'"></textarea></td>'
		                +'<td class="no-border"><div class="grid4"><div id="27" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>'
		                +'\n'+ '\n';

		    var resp_table = document.getElementById('objection_2');
		    var i = resp_table.rows.length;

		    var r_newRow = resp_table.insertRow(-1);

		    r_newRow.innerHTML =
		                '<td class="no-border" style="width: 25em;">What would be the best response to</td>'
		                +'<td class="no-border" style="width: 46em;"><span class="TextColor dynamicTxt_Q_'+response.id+'"></span></td>'
		                +'<td class="no-border"><div class="grid6"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tod_'+response.id+'[answer][new][]" cols="" rows=""></textarea></div></td>'
		                +'<td class="no-border"><div class="grid4"><div id="28" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>'
		                +'\n'+ '\n';

		    dynamicText();
		}
	});

  }
</script>

<!-- Sidebar begins -->
<div id="sidebar">
	<?php $this->load->view('common/left_navigation');?>
	
    <!-- Secondary nav -->
    <div class="secNav">    
    	<div class="clear"></div>
   </div>
</div>
<!-- Sidebar ends -->
 
<!-- Content begins -->
<div id="content">
	<?php //$this->load->view('common/progress_bar');?>
    <!-- Breadcrumbs line -->

    <?php $this->load->view('common/top_navigation');?>
 
    <!-- Main content -->
    <div class="wrapper">     
       <form id="validate" action="<?php echo current_url();?>" method="post">
       
          <div class="widget tableTabs">

           <div class="whead"><h6>Standard Objections</h6><div class="clear"></div></div>
            <div class="tab_container">

                <div id="ttab1" class="tab_content">
                    <table border="0" cellspacing="1" cellpadding="1" width="100%" class="tDefault">
                      <tr>
                        <td class="no-border">Here are standard objections that you are likely to run into regardless of what you are selling.</td>
                        <td class="no-border">I am busy right now. <br/>
                            What is this in regards to? <br/>
                            Who are you with?<br/>
                            What do you do?<br/>
                            I am not interested.<br/>
                            I can't change anything right now.<br/>
                            We are not doing anything right now.<br/>
                        </td>
                      </tr>
                      <tr>
                        <td class="no-border">There is nothing for you to enter here as the scripter will provide responses for you for all of these.</td>
                        <td class="no-border">We are not making any changes right now.<br/>
                            Just send me some information.  <br/>
                            We do not have any budget / money right now.<br/>
                            We already use someone.<br/>
                            How does it work? <br/>
                            How much does it cost?<br/>
                        </td>
                      </tr>
                      <tr>
                        <td class="no-border" colspan="2">The scripter will develop objection responses for all of the standard objections. If you there is an objection that you face that is not in the standard list, you can enter it here by pressing "Add Objection". Here are some questions that may help you to think about objections that are more specific to your situation.</td>
                      </tr>
                       <tr>
                        <td class="no-border" colspan="2">
                            What is an objection that you run into for your product? <br/>
                            What is an objection that you run into for your pricing? <br/>
                            What is an objection that you run into regarding your competing? <br/>
                            What is an objection that you face when competiting against the status quo / option to do nothing? <br/> 
                        </td>
                      </tr>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>		 
        </div>
        
       <?php if(!empty($objections)):?><h3 style="margin-top:2em;">Step 1: Identify custom objections that are likely to come up that are not included in the standard objections</h3><?php endif;?>
       <div class="widget tableTabs" <?php echo (empty($objections) ? 'style="border:none;"' : NULL); ?>>
       		<?php if(!empty($objections)):?><div class="whead"><h6>Custom Objections</h6><div class="clear"></div></div><?php endif;?>

            <div class="tab_container">
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="objection_1">
                        
                        <tbody>
                         <?php if(!empty($objections)):?>
                        <?php foreach ($objections as $objection):?>
        						<?php $data = $this->home->get_meta_data($objection->obj_id, 'objection', 'tod'); ?>
        						
        						<?php 
        						$question_id = $data['question']['id'];
        						$question_value = $data['question']['value'];
        						?>
					               <tr>
		                                <td class="no-border"><div class="grid6">Custom Objection.</div></td>
		                                <td class="grid5 no-border" style="width: 50em;" ></td>
		                                <td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tod_<?php echo $objection->obj_id;?>[question][<?php echo (isset($question_id) ? $question_id : 'new');?>][]" id="Q_<?php echo $objection->obj_id;?>_<?php echo $question_id;?>" cols="" rows=""><?php echo $question_value;?></textarea></div></td>	
		                            	<td class="no-border"><div class="grid4"><div id="27" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
		                            </tr>
			                <?php endforeach;?>
			                <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>
        </div>

        <div align="right">
        	<input type="button"  <?php if($is_paid) { ?> onclick='addRow("objection_1","O")' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?>  value="Add Objection" style="margin-top:10px;color:white !important;"/>
        </div>

	        <?php if(!empty($objections)):?><h3 style="margin-top:2em;">Step 2: Identify the best responses for your custom objections</h3><?php endif;?>
	        <div class="widget tableTabs" <?php echo (empty($objections) ? 'style="border:none;"' : NULL); ?>>
	        <?php if(!empty($objections)):?><div class="whead"><h6>Custom Objection Responses</h6><div class="clear"></div></div><?php endif;?>

            <div class="tab_container">
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="objection_2">
                        
                        <tbody>
                        <?php if(!empty($objections)):?>
                          <?php foreach ($objections as $objection):?>
        						<?php $data = $this->home->get_meta_data($objection->obj_id, 'objection', 'tod'); ?>
        						
        						<?php 
        						$answer_id = $data['answer']['id'];
        						$answer_value = $data['answer']['value'];
        						
        						$question_id = $data['question']['id'];
        						$question_value = $data['question']['value'];
        						
        						?>
			                      <tr>
			                        <td class="no-border" style="width: 25em;"><div class="grid6">What would be the best response to </div></td>
			                        <td class="grid5 no-border" style="width: 46em;" ><span class="TextColor dynamicTxt_Q_<?php echo $objection->obj_id;?>_<?php echo $question_id;?> "><?php echo (!empty($question_value) ? $question_value : NULL);?></span></td>
			                       	<td class="no-border"><div class="grid6"><textarea class="validate[required] dynamicTxt" style="width:350px;" name="tod_<?php echo $objection->obj_id?>[answer][<?php echo (isset($answer_id) ? $answer_id : 'new');?>][]" cols="" rows=""><?php echo $answer_value;?></textarea></div></td>
			                      	<td class="no-border"><div class="grid4"><div id="28" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
			                      </tr>
			                <?php endforeach;?>
						<?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>		 
        </div>

         <div class="fluid" style="margin-top:15px;">
          <input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" />	<input type="submit" class="buttonM bRed" name="submit" value="Continue" />
          	<input type="hidden" name="step" value="objection">
        </div>
        </form>
        </div>
        
        </div>
        
    </div>
    <!-- Main content ends -->
    
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>