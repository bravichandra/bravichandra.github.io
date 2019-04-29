<div id="only-one" data-accordion-group>   				
  <?php foreach($all_attributes as  $singleattr) {?>
	<!-- <section data-accordion> -->
	 <div class="accordianBox" data-accordion>
		<!-- <div class="accordianLink" data-control><a href="javascript:void(0)"><?php echo $singleattr->attr_name ?></a></div> -->
			
			<div class="accordianLink" data-control><a href="javascript:void(0)"><?php echo $singleattr->attr_name ?></a></div>
			
			<div class="accordianDet12 " data-content>
			
			<?php  $allQuestion = $this->attribute->getQuestionWithAttr($singleattr->attr_id); ?>
			
			<div class="outerBox">
				<?php   if($allQuestion){  ?>
				   <div id="sortable2" class="connectedSortable dynamic-<?php echo $singleattr->attr_id ?>">
						<?php // var_dump($pre_questionid); ?>
						<?php foreach($allQuestion as $sngQuestion) { ?>
							    <?php if(!in_array($sngQuestion->ques_id,$pre_questionid)) { ?>
								   <div class="ui-state-highlight" ><?php echo $sngQuestion->question_name; ?>												
								   <input type="hidden" name="Question_ID[]" value="<?php echo $sngQuestion->ques_id; ?>"></div>
							     <?php } ?>
						<?php }  ?>
						
					</div>
				<?php } ?>										
			</div>									
			<div class="clearfix">
				<form action="" method="Post" class="form-inline" role="form">
					<div class="addCoustom">Add custom<span>Question </span></div>
					
					<div class="coustomInput">
						<input class="addNewAttrQuestion" id="newAttr-<?php echo $singleattr->attr_id; ?>" name="newquestion" placeholder="add question">
					</div>
					<!-- <input class="btn btn-default" type="submit" value="add" > -->
				</form>
				
			</div>
		</div> 													
	 </div> 
	<!-- </section> -->
	<?php  } ?>	
</div>	