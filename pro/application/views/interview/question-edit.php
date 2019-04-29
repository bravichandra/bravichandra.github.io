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
<?php
  $find_product = $this->campaign->getAllProduct();
  $find_all_campaign = $this->campaign->get_drop_campaign();
?>				    	
<div class="wrapper">

	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 
	<div class="fluid">
    	
	 <div class="grid12" style="width:100%; margin-left:0%;">
     	<div class="myfolder" align="center" style="margin-left:0%;">
     		<div class="myfloder_box box-myfolder">
	            <div class="box box2 active">
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
	            <div class="box box6">
	            	<div class="bxtitle"><h3>Edit Questions</h3></div>	
	            </div>
     		</div>        	
        </div>
        <div>
	        <div class="myfloderbox arrowbox" style="width: 0px;">&nbsp;</div>
	        <div class="myfloderbox"> 
				 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
	             <b>You are Here</b>
	        </div>
        </div>
        <br clear="all" /> <br />

		<div class="widget">
			<div class="body">
				<h2><?php echo ($qinfo['interv_ques_id']?'Edit Question List':'New Question List')?></h2>	
            	<form method="post" id="frmQuestion" action="<?php echo current_url();?>" id="frmsort">
            		<input type="hidden" name="quest_id" class="quest_id" id="quest_id" value="<?php echo ($qinfo['interv_ques_id']?$qinfo['interv_ques_id']:0)?>" />
                	<input type="hidden" id="step" name="step" value="2" />
                    <div class="section1">
                    	<div class="fl col-org">Please create a name for this question list: : <input type="text" name="job_title" class="searchInputR" id="qtitle" value="<?php echo $qinfo['interview_ques_name']?>" /><span id="save_loader"></span></div>
                    	<br /><hr />
                    </div>
                    <div class="section section2">
                    	<div class="set_txt"><div style="padding-bottom:10px;"><label><b>Identify Requirements</b><br/><label>Drag and drop the requirements that you would like in an applicant</label></div></div>
                    	<div class="createJobCon">
							<div class="selectedAttributes">
							<!--	<div>Select the Desired Attributes for this Job </div> -->
								<div class="attributesBox">
									<div class="hd">Selected Requirements</div>
									
									<div  id="sortable1" class="connectedSortable section2_attribs">
										<?php 
											$prof_attr = array();
											if($qinfo['identify_attributes']) {
												foreach($qinfo['identify_attributes'] as $singelAtt) { 
													$prof_attr[] = $singelAtt->attr_id;											
										?>
											<div class="ui-state-highlight" id="attr-<?= $singelAtt->attr_id; ?>" ><?php echo $singelAtt->attr_name; ?>												
											<input type="hidden" name="attribute[]" class="idattrbs" value="<?php echo $singelAtt->attr_id; ?>">
                                            <?php if($singelAtt->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteAttr(<?=$singelAtt->attr_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; font-size:10px;">X</span></a></div><?php }?>
                                                        </div>											
										<?php }} ?>
									</div>
								</div> 
								<div style="padding-bottom:15px;"> <input type="button" value="Next" onclick="move_step(2,1)" class="buttonM bBlue" ></div>
						   </div>
						</div>
						<div class="attributesRight">
							<div class="inner">						
							  <?php foreach( $profile_attribs as  $singlecat  ) {?>
								<div class="accordianBox">
									<div class="accordianLink"><a href="javsscript:void(0)"><?php echo $singlecat->cat_name ?></a></div>
										<div class="accordianDet">
										
										<?php  
										$allatribute = $this->attribute->fetchAttributeWithCatID($singlecat->cat_id); 
										?>
										
										<div class="outerBox">
											<?php   if($allatribute){  ?>
											   <div id="sortable2" class="connectedSortable dynamic-<?php echo $singlecat->cat_id ?>">
													
													<?php foreach($allatribute as $singelAtt) { 
															if(in_array($singelAtt->attr_id,$prof_attr)!==FALSE) continue;
										
														?>
															<div class="ui-state-highlight" id="attr-<?= $singelAtt->attr_id; ?>"><?php echo $singelAtt->attr_name; ?>												
															<input type="hidden" name="attribute[]" class="idattrbs" value="<?php echo $singelAtt->attr_id; ?>">
                                                             <?php if($singelAtt->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteAttr(<?=$singelAtt->attr_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; font-size:10px;">X</span></a></div><?php }?>
                                                        </div>
													<?php }  ?>
													
												</div>
											<?php } ?>										
										</div>									
										<div class="clearfix">
											
												<div class="addCoustom">Add custom<span><?php echo $singlecat->cat_name; ?></span></div>
												
												<div class="coustomInput">
													<input class="addNewAttr" id="newAttr-<?php echo $singlecat->cat_id; ?>" name="newAttr" placeholder="add attribute">
												</div>
											
											
										</div>
									</div> 													
								</div>
								<?php  } ?>							
							</div>
						</div>
						<div class="clr"></div>
                    </div>
                    <div class="section section3" style="display: none;">
                    	<hr />
                    	<div class="set_txt">
							<label>
								Drag and drop the interview questions below that you would like to ask for each of the requirements that you selected 
							</label>
						</div>
						<div class="selectedAttributes">
							<?php 
								/* <div>Select the Questions for the Attribute</div> */ 
							?>
							<div class="attributesBox">
								<div class="hd">Selected Questions</div>
								<div  id="sortable1" name="questionShortableID" class="connectedSortable sortableVal">
									<?php 
										if(isset($qinfo['questions']['attrib']) && $qinfo['questions']['attrib']) {
											foreach($qinfo['questions']['attrib'] as $sngQuestion) {
											if($sngQuestion->ques_id!=""){
									?>
										<div class="ui-state-highlight" id="ques-<?= $sngQuestion->ques_id; ?>" ><?php echo $sngQuestion->question_name; ?>												
										<input type="hidden" name="Question_ID[]" class="Question_ID" value="<?php echo $sngQuestion->ques_id; ?>">
                                        <?php if($sngQuestion->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteQues(<?=$sngQuestion->ques_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; padding-top:2px; font-size:10px;">X</span></a></div><?php }?>
                                         </div>
									<?php } }} ?>
                                 </div> 
							</div>
							
							<div style="padding-bottom:15px;"> 
								<input type="button" value="Back" onclick="move_step(2,0)" class="buttonM bBlue">
								<input type="button" value="Next" onclick="move_step(3,1)" name="QUestionSubmit" class="buttonM bBlue">
							</div> 
						</div>  
						<div class="attributesRight" style="margin-top:25px;">
								<div class="inner"  id="section3_dynamic_display_Question" >
								    <span>This Step Concept is inprocess</span>	
								</div>
						</div>
						<div class="clr"></div>
                    </div>

                    <div class="section section4" style="display: none;">
                    	<hr />
                    	<div class="set_txt">
							<label>
								Drag and drop the interview questions below that you would like to ask for each of the attributes that you selected 
							</label>
						</div>
						<div class="selectedAttributes">
							<?php 
								/* <div>Select the Questions for the Attribute</div> */ 
							?>
							<div class="attributesBox">
								<div class="hd">Selected Questions</div>
								<div  id="sortable1" name="questionShortableID" class="connectedSortable sortableVal">
									<?php 
										if(isset($qinfo['questions']['intro']) && $qinfo['questions']['intro']) {
											foreach($qinfo['questions']['intro'] as $sngQuestion) {
											if($sngQuestion->ques_id!=""){
									?>
										<div class="ui-state-highlight" id="ques-<?= $sngQuestion->ques_id; ?>"><?php echo $sngQuestion->question_name; ?>												
										<input type="hidden" name="Question_ID[]" class="intr_questions" value="<?php echo $sngQuestion->ques_id; ?>">
                                         <?php if($sngQuestion->user_id==$_SESSION['ss_user_id']){?>
										<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteQues(<?=$sngQuestion->ques_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; font-size:10px;">X</span></a></div><?php }?></div>
									<?php } }} ?>
								</div> 
							</div>
							
							<div style="padding-bottom:15px;"> 
								<input type="button" value="Back" onclick="move_step(3,0)" class="buttonM bBlue">
								<input type="button" value="Next" onclick="move_step(4,1)" name="QUestionSubmit" class="buttonM bBlue">
							</div> 
						</div>  
						<div class="attributesRight" style="margin-top:25px;">
								<div class="inner"  id="section4_dynamic_display_Question" >
								    <span>This Step Concept is inprocess</span>	
								</div>
						</div>
						<div class="clr"></div>
                    </div>

                    <div class="section section5" style="display: none;">
                    	<hr />
                    	<div class="set_txt">
							<label>
								Drag and drop the interview questions below that you would like to ask for each of the attributes that you selected 
							</label>
						</div>
						<div class="selectedAttributes">
							<?php 
								/* <div>Select the Questions for the Attribute</div> */ 
							?>
							<div class="attributesBox">
								<div class="hd">Selected Questions</div>
								<div  id="sortable1" name="questionShortableID" class="connectedSortable sortableVal">
									<?php 
										if(isset($qinfo['questions']['closing']) && $qinfo['questions']['closing']) {
											foreach($qinfo['questions']['closing'] as $sngQuestion) {
											if($sngQuestion->ques_id!=""){
									?>
										<div class="ui-state-highlight" id="ques-<?= $sngQuestion->ques_id; ?>" ><?php echo $sngQuestion->question_name; ?>												
										<input type="hidden" name="Question_ID[]" class="intr_questions" value="<?php echo $sngQuestion->ques_id; ?>">
                                         <?php if($sngQuestion->user_id==$_SESSION['ss_user_id']){?>
										<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteQues(<?=$sngQuestion->ques_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; font-size:10px;">X</span></a></div><?php }?>
                                        </div>
									<?php } }} ?>
								</div> 
							</div>
							
							<div style="padding-bottom:15px;"> 
								<input type="button" value="Back" onclick="move_step(4,0)" class="buttonM bBlue">
								<input type="button" value="Next" onclick="move_step(5,1)" name="QUestionSubmit" class="buttonM bBlue">
							</div> 
						</div>  
						<div class="attributesRight" style="margin-top:25px;">
								<div class="inner"  id="section5_dynamic_display_Question" >
								    <span>This Step Concept is inprocess</span>	
								</div>
						</div>
						<div class="clr"></div>
                    </div>

                </form>
                
            </div>
		</div>
		

	</div>
	</div>
	<br/>
	
</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/ddaccordion.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.accordion.js"></script>
<script type="text/javascript">
//Move next step
function move_step(stepno,mode){
	if(stepno==2 && mode==0) {
		$(".section3").hide();
		$(".section2").show();

		$(".box.active .bxtitle1").addClass("bxtitle");
		$(".box.active .bxtitle1").removeClass("bxtitle1");
		$(".box.active").removeClass("active");

		$(".box2 .bxtitle").addClass("bxtitle1");
		$(".box2 .bxtitle1").removeClass("bxtitle");
		$(".box2").addClass("active");
		$(".arrowbox").width(0*150);
	} else if(stepno==2 && mode==1) {
		if($("#qtitle").val()=="") {
			alert("Enter name of question list");
			return;
		}
		if($(".section2_attribs .idattrbs").length==0) {
			alert("Select Attributes");
			return;
		}
		save_question_info();
		section3_randerDYnamicContent();
		$(".section2").hide();
		$(".section3").show();

		$(".box.active .bxtitle1").addClass("bxtitle");
		$(".box.active .bxtitle1").removeClass("bxtitle1");
		$(".box.active").removeClass("active");

		$(".box3 .bxtitle").addClass("bxtitle1");
		$(".box3 .bxtitle1").removeClass("bxtitle");
		$(".box3").addClass("active");
		$(".arrowbox").width(1*150);
	} else if(stepno==3 && mode==0) {
		$(".section4").hide();
		$(".section3").show();

		$(".box.active .bxtitle1").addClass("bxtitle");
		$(".box.active .bxtitle1").removeClass("bxtitle1");
		$(".box.active").removeClass("active");

		$(".box3 .bxtitle").addClass("bxtitle1");
		$(".box3 .bxtitle1").removeClass("bxtitle");
		$(".box3").addClass("active");
		$(".arrowbox").width(1*150);
	} else if(stepno==3 && mode==1) {
		if($(".section3 #sortable1 .Question_ID").length==0) {
			alert("Select Attribute Questions");
			return;
		}
		save_question_info();
		section4_randerDYnamicContent();
		$(".section3").hide();
		$(".section4").show();

		$(".box.active .bxtitle1").addClass("bxtitle");
		$(".box.active .bxtitle1").removeClass("bxtitle1");
		$(".box.active").removeClass("active");

		$(".box4 .bxtitle").addClass("bxtitle1");
		$(".box4 .bxtitle1").removeClass("bxtitle");
		$(".box4").addClass("active");
		$(".arrowbox").width(2*150);
	} else if(stepno==4 && mode==0) {
		$(".section5").hide();
		$(".section4").show();

		$(".box.active .bxtitle1").addClass("bxtitle");
		$(".box.active .bxtitle1").removeClass("bxtitle1");
		$(".box.active").removeClass("active");

		$(".box4 .bxtitle").addClass("bxtitle1");
		$(".box4 .bxtitle1").removeClass("bxtitle");
		$(".box4").addClass("active");
		$(".arrowbox").width(2*150);
	} else if(stepno==4 && mode==1) {
		if($(".section4 #sortable1 .intr_questions").length==0) {
			alert("Select Intro Questions");
			return;
		}
		save_question_info();
		section5_randerDYnamicContent();
		$(".section4").hide();
		$(".section5").show();

		$(".box.active .bxtitle1").addClass("bxtitle");
		$(".box.active .bxtitle1").removeClass("bxtitle1");
		$(".box.active").removeClass("active");

		$(".box5 .bxtitle").addClass("bxtitle1");
		$(".box5 .bxtitle1").removeClass("bxtitle");
		$(".box5").addClass("active");
		$(".arrowbox").width(3*150);
	} else if(stepno==5 && mode==1) {
		if($(".section5 #sortable1 .intr_questions").length==0) {
			alert("Select Closing Questions");
			return;
		}
		save_question_info();		
		var qId = $("#quest_id").val();
		location.replace("<?php echo base_url('questions/previewinterviewProfile')?>/"+qId);
		return;
	} 
}
ddaccordion.init({
 headerclass: "accordianLink", //Shared CSS class name of headers group that are expandable
 contentclass: "accordianDet", //Shared CSS class name of contents group
 revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
 collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
 defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
 animatedefault: false, //Should contents open by default be animated into view?
 persiststate: false, //persist state of opened contents within browser session?
 toggleclass: ["selected", "active"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
 togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
 animatespeed: "slow", //speed of animation: "fast", "normal", or "slow"
 oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
  //do nothing
  //alert('asd');
 },
 onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
  //do nothing
 }
});
$('body').on("keypress",'.section2 .addNewAttr', function(e) {
        if (e.keyCode == 13) {
            // alert("Enter pressed");	
			if($(this).val() == ''){
				
				$(this).css('border-color','#A94442');
					alert('Field should be non empty');
				//$(this).parent().append('<span style="color:red" class="model_fexsin" >Field should be non empty </span>');
				return false;
			}
			
			var myString = $(this).attr('id');
			var attrname = $(this).val();
			var e_id = myString.replace('newAttr-','');
			// console.log(e_id);
			$.ajax({
				type : 'POST',
				url   : '<?php echo base_url()?>jobprofile/addAttrDynamic',
				data : {attrname: attrname, attr_id: e_id},
				success : function (data){
					// console.log(data);
					$('.section2 .dynamic-'+e_id).append(data);
					
					$( ".section2 #sortable1, .section2 #sortable2" ).sortable({
							connectWith: ".section2 .connectedSortable",
							cursor: 'move',
							zIndex : 9999
							}).disableSelection();
					$('#'+myString).val('');
					$('#'+myString).css('border-color','#CCCCCC');
				}
			});
			return false; // prevent the button click from happening
        }
});

$(function() {
	$( ".section2 #sortable1, .section2 #sortable2" ).sortable({
		connectWith: ".section2 .connectedSortable",
		cursor: 'move',
		zIndex : 9999,
		appendTo: 'body',
		helper: 'clone',
		sort : function (event, ui){
				// console.log('a');
			}
	}).disableSelection();
	
});

function section3_randerDYnamicContent()
{
	var s3ids = "";
	$( ".section3 #sortable1 .Question_ID" ).each(function( index ) {
		s3ids += ","+$( this ).val();
	});

	var s2ids = "";
	$( ".section2_attribs .idattrbs" ).each(function( index ) {
		s2ids += ","+$( this ).val();
	});
	if(s2ids) s2ids = s2ids.substring(1);
	if(s3ids) s3ids = s3ids.substring(1);
	if(s2ids){
		$("#section3_dynamic_display_Question").html('<img src="<?php echo base_url()?>assets/img/ajax_loader.gif" />');
		$.ajax({
			url : '<?php echo base_url() ?>interviewer/AjaxQuestAttrs',
			type:  'POST',
			data: 'aids='+s2ids+'&s3ids='+s3ids,
			success : function(data){
				$('#section3_dynamic_display_Question').html(data);
			},
			complete : function(){
					
					$(".section3 #sortable1, .section3 #sortable2" ).sortable({
						connectWith: ".section3 .connectedSortable",
						cursor: 'move',
						forcePlaceholderSize: true,
						placeholder : 'moving',
						zIndex : 999999,
						appendTo: 'body',
						helper: 'clone',
						start : function (event, ui) {
									 ui.helper.css('box-shadow','5px 5px 5px #add8e6');
								},
						sort : function (event, ui){
								// console.log('a');
							},
						stop : function (event, ui){
							ui.item.css('border','');
						}
					}).disableSelection();
					
					$(document).ready(function(){
						 $('.section3 #only-one [data-accordion]').accordion();
					  
					});
			}
		})
	}
}

function section4_randerDYnamicContent()
{
	var s4ids = "";
	$( ".section4 #sortable1 .intr_questions" ).each(function( index ) {
		s4ids += ","+$( this ).val();
	});
	if(s4ids) s4ids = s4ids.substring(1);
	var  attrID = 70;
	if(attrID){
		$("#section4_dynamic_display_Question").html('<img src="<?php echo base_url()?>assets/img/ajax_loader.gif" />');
		$.ajax({
			url : '<?php echo base_url() ?>interviewer/getQuesByAttribute',
			type:  'POST',
			data: 'aid='+attrID+'&nsIds='+s4ids,
			success : function(data){
				
				$('#section4_dynamic_display_Question').html(data);
				//accordianReinit();
				
				//alert('sdsd');
				
			},
			complete : function(){
					
					$(".section4 #sortable1, .section4 #sortable2" ).sortable({
						connectWith: ".section4 .connectedSortable",
						cursor: 'move',
						forcePlaceholderSize: true,
						placeholder : 'moving',
						zIndex : 999999,
						appendTo: 'body',
						helper: 'clone',
						start : function (event, ui) {
									  // $(this).css("z-index", 99999);
									  // console.log($('.connectedSortable').css("z-index"));
									  // console.log(event);
									 ui.helper.css('box-shadow','5px 5px 5px #add8e6');
									 //console.log('a');
								},
						sort : function (event, ui){
								// console.log('a');
							},
						stop : function (event, ui){
							ui.item.css('border','');
						}
					}).disableSelection();
					
					$(document).ready(function(){
						 $('.section4 #only-one [data-accordion]').accordion();
						$('.section4 #only-one .accordianBox .accordianLink').trigger('click');
					});
					
					// alert('fsdfsdfsd');
			}
		})
	}
}

function section5_randerDYnamicContent()
{
	var s5ids = "";
	$( ".section5 #sortable1 .intr_questions" ).each(function( index ) {
		s5ids += ","+$( this ).val();
	});
	if(s5ids) s5ids = s5ids.substring(1);
	//var  jobID = $("#jobprofileEvent").val();
	var  attrID = 71;
	// console.log(jobID);
	// if(jobId !='')
	if(attrID){
		$("#section5_dynamic_display_Question").html('<img src="<?php echo base_url()?>assets/img/ajax_loader.gif" />');
		$.ajax({
			url : '<?php echo base_url() ?>interviewer/getQuesByAttribute',
			type:  'POST',
			data: 'aid='+attrID+'&nsIds='+s5ids,
			success : function(data){
				
				$('#section5_dynamic_display_Question').html(data);
			},
			complete : function(){
					
					$(".section5 #sortable1, .section5 #sortable2" ).sortable({
						connectWith: ".section5 .connectedSortable",
						cursor: 'move',
						forcePlaceholderSize: true,
						placeholder : 'moving',
						zIndex : 999999,
						appendTo: 'body',
						helper: 'clone',
						start : function (event, ui) {
									  // $(this).css("z-index", 99999);
									  // console.log($('.connectedSortable').css("z-index"));
									  // console.log(event);
									 ui.helper.css('box-shadow','5px 5px 5px #add8e6');
									 console.log('a');
								},
						sort : function (event, ui){
								// console.log('a');
							},
						stop : function (event, ui){
							ui.item.css('border','');
						}
					}).disableSelection();
					
					$(document).ready(function(){
						 $('.section5 #only-one [data-accordion]').accordion();
					  	 $('.section5 #only-one .accordianBox .accordianLink').trigger('click');
					});
					
					// alert('fsdfsdfsd');
			}
		})
	}
}

//Save Question Information
function save_question_info()
{	
	var qTitle = $("#qtitle").val();
	var qId = $("#quest_id").val();

	var qJIAttrib = "";
	$( ".section2 #sortable1 .idattrbs" ).each(function( index ) {
		qJIAttrib += ","+$( this ).val();
	});
	if(qJIAttrib) qJIAttrib = qJIAttrib.substring(1);

	var qQuestions = "";
	$( ".section3 #sortable1 .Question_ID" ).each(function( index ) {
		qQuestions += ","+$( this ).val();
	});
	$( ".section4 #sortable1 .intr_questions" ).each(function( index ) {
		qQuestions += ","+$( this ).val();
	});
	$( ".section5 #sortable1 .intr_questions" ).each(function( index ) {
		qQuestions += ","+$( this ).val();
	});
	if(qQuestions) qQuestions = qQuestions.substring(1);	

	$("#save_loader").html('<img src="<?php echo base_url()?>assets/img/ajax_loader.gif" />');
	$.ajax({
		url : '<?php echo base_url() ?>interviewer/Question_save',
		type:  'POST',
		data: "qTitle="+qTitle+"&qId="+qId+"&qJIAttrib="+qJIAttrib+"&qQuestions="+qQuestions,
		success : function(data){			
			if(isNaN(data)==false) $("#quest_id").val(data);
			else alert(data);
			console.log("Q Success");
		},
		complete : function(){
			console.log("Q Complete");
			//$("#quest_id").val(0);
			$("#save_loader").html('');
		}
	})
	
}

$('body').on("keypress",'.addNewAttrQuestion', function(e) {
        if (e.keyCode == 13) {
            // alert("Enter pressed");	
			if($(this).val() == ''){
				
				$(this).css('border-color','#A94442');
					alert('Field should be non empty');
				//$(this).parent().append('<span style="color:red" class="model_fexsin" >Field should be non empty </span>');
				return false;
			}

			var sect = '';
			if($(this).hasClass('attrib')==true) sect = '.section3 ';
			else if($(this).hasClass('intro')==true) sect = '.section4 ';
			else if($(this).hasClass('closing')==true) sect = '.section5 ';
			else return false;
			
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
					$(sect+'.dynamic-'+e_id).append(data);
					
					$( sect+"#sortable1, "+sect+"#sortable2" ).sortable({
							connectWith: sect+".connectedSortable",
							cursor: 'move',
							zIndex : 9999
							}).disableSelection();
					$('#'+myString).val('');
					$('#'+myString).css('border-color','#CCCCCC');
				},
				complete : function(){
						
						$(sect+"#sortable1, "+sect+"#sortable2" ).sortable({
							connectWith: sect+".connectedSortable",
							cursor: 'move',
							forcePlaceholderSize: true,
							zIndex : 999999,
							appendTo: 'body',
							helper: 'clone',
							start : function (event, ul) {
										  // $(this).css("z-index", 99999);
										  console.log($(sect+'.connectedSortable').css("z-index"));
										  // console.log(ul);
									},
							sort : function (event, ui){
									// console.log('a');
								}
						}).disableSelection();
						
						$(document).ready(function(){
							 $(sect+'#only-one [data-accordion]').accordion();
						});
						// alert('fsdfsdfsd');
				}
			});
			return false; // prevent the button click from happening
        }
});



function deleteQues(quesId)
{
		var divID="ques-"+quesId;
		if(confirm('Are you sure you want to permanently delete this question?'))
		{
			$.ajax({
				type : 'POST',
				url   : '<?php echo base_url()?>questions/deleteQuestionFromList/'+quesId,
				success : function (data){
					// console.log(data);
					//alert(data);
					$('#'+divID).remove().fadeOut('slow');
				},
				
			});
		}
}


function deleteAttr(attrId)
{
		var divID="attr-"+attrId;
		if(confirm('Are you sure you want to permanently delete this question?'))
		{
			$.ajax({
				type : 'POST',
				url   : '<?php echo base_url()?>interviewer/deleteAttributeFromList/'+attrId,
				success : function (data){
					// console.log(data);
					//alert(data);
					$('#'+divID).remove().fadeOut('slow');
				},
				
			});
		}
}
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>