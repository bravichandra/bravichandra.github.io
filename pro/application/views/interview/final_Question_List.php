<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>

<!--<link href="<?php echo base_url();?>css/theme.css" rel="stylesheet" type="text/css" />-->
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>
	<!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>
 <!-- Start: Content -->
 <section id="content">
 	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/crm_nav');
	?>
	<div class="wrapper">
		<div class="fluid">     
			<div class="grid12" style="width:100%; margin-left:0%;">
				<div class="myfolder" align="center" style="margin-left:0%;">
		     		<div class="myfloder_box box-myfolder">
                        <div class="box box2">
                            <div class="bxtitle1"><h3>Identify Requirements</h3></div>	                
                        </div>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box box3">
                            <div class="bxtitle">
                                <h3>Requirements Questions</h3>                
                            </div>
                        </div>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>            
                        <div class="box box4">
                            <div class="bxtitle"><h3>Intro Questions</h3></div>
                        </div>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>            
                        <div class="box box5">
                            <div class="bxtitle"><h3>Closing Questions</h3></div>
                        </div>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>            
                        <div class="box box6 active">
                            <div class="bxtitle"><h3>Edit Questions</h3></div>	
                        </div>
		     		</div>        	
		        </div>
		        <div>
                	<div class="myfloderbox arrowbox" style="width:615px;">&nbsp;</div>
			        <div class="myfloderbox"> 
						 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
			             <b>You are Here</b>
			        </div>
		        </div>
			</div> 
			<div class="col-md-12">
				   <?php  $this->load->view('interview/notification') ?>         
				 <div class="panel panel-visible">
								
					<!--<div class="rightInner">-->
						<div class="tableCon final_table">
							<h1>Question List Summary: <?php echo (isset($QuestionName)) ?  $QuestionName : '' ?></h1>
							<hr />
							<form action="" method="POST" id="editInterviewQuestion" >
								<div class="createJobCon">
									<div class="selectedAttributes">
										<?php if(!$isViewOnly) { ?>
										<div>Select the Questions for the Question List</div>
										<?php
											$introQuesID = $introQuestion_ID;
											$closingQuesID = $closingQuestion_ID;
										}
										else
										{
											$introQuesID = '70';
											$closingQuesID = '71';
										}?>										
												<!-- Desired Attributes -->
												<div class="attributesBox">
													<div class="hd">Desired Requirements</div>
													<div class="connectedSortable ui-sortable">													
														<?php foreach($desired_attributes as $dattr){?>
														<div class="ui-state-highlight">
															<?php echo $dattr->attr_name;?>
														</div>
														<?php }?>
													</div>
												</div>

												<!-- Display Intro Question First -->
												<?php if(!empty($interviewQuestionInfo)) :  ?>
												
												<?php 
												if($isViewOnly) $tempQuestionInfo = $interviewQuestionInfo;
												else $tempQuestionInfo = $interviewQuestionIntro;
												$ij = 0; $bottom_part_intro = false;
												foreach($tempQuestionInfo as $sngQuestionIntro) {
													if($sngQuestionIntro->attr_id == $introQuesID || !$isViewOnly) {
												?>
												<?php if($ij == 0)
												{?>												
													<div class="attributesBox">
														<div class="hd">Intro Questions</div>
														<div  id="sortable1" class="connectedSortable">
												<?php $bottom_part_intro = true; } $ij++; ?>	
														
														<div class="ui-state-highlight" id="ques-<?= $sngQuestionIntro->ques_id; ?>" ><?php echo $sngQuestionIntro->question_name; ?>												
														<input type="hidden" name="Question_ID[]" value="<?php echo $sngQuestionIntro->ques_id; ?>">
														<?php // if($sngQuestionIntro->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:18px;cursor:pointer;"><a onclick="deleteQues(<?=$sngQuestionIntro->ques_id;?>)"><span class="iconn icon-remove"></span></a></div>
														<?php // }?>
														</div>
												<?php } ?>
												<?php }  ?>
												<?php if($bottom_part_intro) { ?>
													</div>
												</div>
												<?php }  ?>												
												<?php endif; ?>
												<?php
												//echo '<pre>';
												//print_r(get_defined_vars());
												//echo '</pre>';
												?>

												

												<?php /*if(!empty($interviewQuestionInfo)) : 
												
												if(!$isViewOnly) $job_temp_id = $jobProfileID; else $job_temp_id = $job_dev_id;
												//$attrs = $this->attribute->getAttibuteWithJObID($job_temp_id);
												$attrs = $desired_attributes;			
												
												//echo '<pre>';
												//print_r(get_defined_vars());
												//echo '</pre>';
												foreach($attrs as $attr)
												{
												$ki = 0; $bottom_part = false;
												foreach($interviewQuestionInfo as $sngQuestion) { 
												if($attr->attr_id == $sngQuestion->attr_id)
												{
												if($sngQuestion->attr_id != $introQuesID && $sngQuestion->attr_id != $closingQuesID) {
														if($ki == 0) {
												?>
														<div class="attributesBox">
														<div class="hd"><?php echo $attr->attr_name;?></div>
														<div  id="sortable1" class="connectedSortable">
														<?php $bottom_part = true; } $ki++; ?>
														<div class="ui-state-highlight" id="ques-<?= $sngQuestion->ques_id; ?>" ><?php echo $sngQuestion->question_name; ?>												
														<input type="hidden" name="Question_ID[]" value="<?php echo $sngQuestion->ques_id; ?>">
														<?php // if($sngQuestion->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:18px;cursor:pointer;"><a onclick="deleteQues(<?=$sngQuestion->ques_id;?>)"><span class="iconn icon-remove"></span></a></div>
														<?php // }?>
														</div>
												<?php }  ?>
												<?php }  ?>
												<?php }  ?>
												<?php if($bottom_part) { ?>
												</div>
												</div>
												<?php }  ?>
												<?php	
												}
												?>
												<?php endif;*/ ?>

												<!---Display Desired Question List-->												
												<?php 
												if(!empty($interviewQuestionInfo)) {
													$catids=array();													
													foreach($interviewQuestionInfo as $dq) {
														$curcat = $catnames[$dq->attr_id];
														if(empty($curcat)) continue;
														if(in_array($curcat,$catids)===FALSE) {
															if($catids) echo '</div></div>';
															$catids[]=$curcat;
															$curcat = str_replace('Requirements', '', $curcat);
															?>
															<div class="attributesBox">
																<div class="hd"><?php echo $curcat;?></div>
																<div  id="sortable1" class="connectedSortable">
															<?php
														}
														?>
														<div class="ui-state-highlight" id="ques-<?= $dq->ques_id; ?>" >
															<?php echo $dq->question_name; ?>									
															<input type="hidden" name="Question_ID[]" value="<?php echo $dq->ques_id; ?>">
															<div style="float:right; width:18px;cursor:pointer;"><a onclick="deleteQues(<?=$dq->ques_id;?>)"><span class="iconn icon-remove"></span></a>
															</div>
														</div>
														<?php
													}
													echo '</div></div>';
													//echo '<pre>';print_r($catids);echo '</pre>';
												}

												?>

												<!---Display Closing Question Last-->
												<?php if(!empty($interviewQuestionInfo)) : ?>
												<div class="attributesBox">
												<div class="hd">Closing Questions</div>
												<div  id="sortable1" class="connectedSortable">
												<?php 
												if($isViewOnly) $tempQuestionInfo = $interviewQuestionInfo;
												else $tempQuestionInfo = $interviewQuestionClosing;
												foreach($tempQuestionInfo as $sngQuestionClosing) {
												//echo '<pre>';
												//print_r(get_defined_vars());
												//echo '</pre>';
													if($sngQuestionClosing->attr_id == $closingQuesID || !$isViewOnly) {
												?>
								
														<div class="ui-state-highlight" id="ques-<?= $sngQuestionClosing->ques_id; ?>" ><?php echo $sngQuestionClosing->question_name; ?>												
														<input type="hidden" name="Question_ID[]" value="<?php echo $sngQuestionClosing->ques_id; ?>">
														<?php //if($sngQuestionClosing->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:18px;cursor:pointer;"><a onclick="deleteQues(<?=$sngQuestionClosing->ques_id;?>)"><span class="iconn icon-remove"></span></a></div>
														<?php // }?>
														</div>														
												<?php }  ?>
												<?php }  ?>
												</div>
												</div>
												
												<?php endif; ?>
												
												
												
										
										<div class="clearfix">
										
											<form action="" method="Post" class="form-inline" role="form">
												<div class="addCoustom">Add Custom <span style="display:inline-block;">Question </span></div>
												
												<div class="coustomInput" style="width:85% !important">
													<input class="addNewAttrQuestion" id="newAttr-73" name="newquestion" placeholder="add Custom Question">
												</div>
												<!-- <input class="btn btn-default" type="submit" value="add" > -->
											</form>
										
				
			</div>
										<div style="padding-bottom:15px;"> 
											
											<input type="submit" value="Save" name="QUestionSubmit" class="buttonM bGreen btn-sm">
											<a href="<?php echo base_url('interviewer/question/'.$QuestionInfo->interv_ques_id);?>" title="Back" class="buttonM bRed">Back</a>
											<a href="<?php echo base_url('interviewer/builder');?>" title="Done" class="buttonM bGreen btn-sm">Done</a>
											<input type="submit" value="Download" name="QUestionSubmit" class="buttonM bBlue btn-sm" style="float:right">
											
										</div> 
									</div>  
								
							</form>
						</div>
					<!--</div>	-->
				</div> 
			</div>     
		</div>     
    </div>  
 </section>  
<!-- End: Content -->
</div>
<style type="text/css">
#sortable1 {min-height: 400px;}
.attributesRight {
    margin-right: 30px;
}
.selectedAttributes{width:100%;}
.searchInputR{
	width: 400px;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.accordion.js"></script>
<script type="text/javascript">
$(function(){
    $('#jobprofileEvent').change(function(obj){
		getallQuetionList(); 
	 });
	 
	 $('#editInterviewQuestion').validate({
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
	
});
function getallQuetionList()
{
		
		// console.log(jobID);
		// if(jobId !='')
		var str = $( "form" ).serialize();
		if(str){
		
			$.ajax({
				url : '<?php echo base_url() ?>questions/getAjaxQestionList/',
				type:  'POST',
				data: str,
				success : function(data){ 
					$('#dynamic_display_Question').html(data);
				},
				complete : function(){
						 
						 $("#sortable1, #sortable2" ).sortable({
							connectWith: ".connectedSortable",
							cursor: 'move',
							forcePlaceholderSize: true,
							zIndex : 999999,
							appendTo: 'body',
							helper: 'clone',
							start : function (event, ul) {
										  // $(this).css("z-index", 99999);
										  console.log($('.connectedSortable').css("z-index"));
										  // console.log(ul);
									},
							sort : function (event, ui){
									// console.log('a');
								}
						}).disableSelection(); 
						
						 $(document).ready(function(){
							 $('#only-one [data-accordion]').accordion();
						}); 
						
						// alert('fsdfsdfsd');
				}
			})
		}
}

$(window).bind("load", function() {
   // code here  
   getallQuetionList(); 
});


$('body').on("keypress",'.addNewAttrQuestion', function(e) {
        if (e.keyCode == 13) {
            // alert("Enter pressed");	
			if($(this).val() == ''){
				
				$(this).css('border-color','#A94442');
					alert('Field should be non empty');
				//$(this).parent().append('<span style="color:red" class="model_fexsin" >Field should be non empty </span>');
				return false;
			}
			
			
			var myString = $(this).attr('id');
			var questionstring = $(this).val();
			var e_id = myString.replace('newAttr-','');
			console.log(questionstring);
			// return false;
			
			$.ajax({
				type : 'POST',
				url   : '<?php echo base_url()?>questions/addAttrQuestionDynamic',
				data : {questionstring: questionstring, attr_id: e_id},
				success : function (data){
					// console.log(data);
					$('#sortable1').append(data);
	
					$( "#sortable1, #sortable2" ).sortable({
							connectWith: ".connectedSortable",
							cursor: 'move',
							zIndex : 9999
							}).disableSelection();
					$('#'+myString).val('');
					$('#'+myString).css('border-color','#CCCCCC');
				},
				complete : function(){
						
						$("#sortable1, #sortable2" ).sortable({
							connectWith: ".connectedSortable",
							cursor: 'move',
							forcePlaceholderSize: true,
							zIndex : 999999,
							appendTo: 'body',
							helper: 'clone',
							start : function (event, ul) {
										  // $(this).css("z-index", 99999);
										  console.log($('.connectedSortable').css("z-index"));
										  // console.log(ul);
									},
							sort : function (event, ui){
									// console.log('a');
								}
						}).disableSelection();
						
						$(document).ready(function(){
							 $('#only-one [data-accordion]').accordion();
						  
						});
						
						// alert('fsdfsdfsd');
				}
			});
			return false; // prevent the button click from happening
        }
});


/////********************* To Add Question Dynamically ***************************////////////////////

function deleteQues(quesId)
{
		var divID="ques-"+quesId;
		if(confirm('Do you really want to delete this question ?'))
		{
			$.ajax({
				type : 'POST',
				url   : '<?php echo base_url()?>questions/deleteListQuestion/'+quesId,
				success : function (data){
					// console.log(data);
					//alert(data);
					$('#'+divID).remove().fadeOut('slow');
				},
				
			});
		}
}




</script>
<style>
#sortable1
{
	min-height:0px;
}
.attributesBox
{
	min-height:0px;
}
</style>
<!-- End: Main -->
<?php $this->load->view('common/footer'); ?>