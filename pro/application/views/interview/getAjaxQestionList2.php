<div id="only-one" data-accordion-group>   				
	<!-- <section data-accordion> -->
	 <div class="accordianBox" data-accordion>
		<!-- <div class="accordianLink" data-control><a href="javascript:void(0)"><?php echo $singleattr->attr_name ?></a></div> -->
			
			<div class="accordianLink" data-control><a href="javascript:void(0)"><?php echo $attribute_info->attr_name ?></a></div>
			
			<div class="accordianDet12 " data-content>
			
			<?php  $allQuestion = $this->attribute->getQuestionWithAttr($attribute_info->attr_id); ?>
			
			<div class="outerBox">
				<?php   if($allQuestion){  ?>
				   <div id="sortable2" class="connectedSortable dynamic-<?php echo $attribute_info->attr_id ?>">
						<?php // var_dump($pre_questionid); ?>
						<?php foreach($allQuestion as $sngQuestion) { 
								if($nsIds && in_array($sngQuestion->ques_id,$nsIds)!==FALSE) continue;
							?>
							   
								   <div class="ui-state-highlight" id="ques-<?= $sngQuestion->ques_id; ?>" ><?php echo $sngQuestion->question_name; ?>												
								   <input type="hidden" name="Question_ID[]" class="intr_questions" value="<?php echo $sngQuestion->ques_id; ?>">
                                    <?php if($sngQuestion->user_id==$_SESSION['ss_user_id']){?>
										<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteQues(<?=$sngQuestion->ques_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; padding-top:2px; font-size:10px;">X</span></a></div><?php }?>
                                     </div>
							   
						<?php }  ?>
						
					</div>
				<?php } ?>										
			</div>									
			<div class="clearfix">
				<form action="" method="Post" class="form-inline" role="form">
					<div class="addCoustom">Add custom<span>Question </span></div>					
					<div class="coustomInput">
						<input class="addNewAttrQuestion <?php echo ($attribute_info->attr_id==70?'intro':'closing')?>" id="newAttr-<?php echo $attribute_info->attr_id; ?>" name="newquestion" placeholder="add question">
					</div>					
				</form>				
			</div>
		</div> 													
	 </div> 
	<!-- </section> -->
	
</div>	