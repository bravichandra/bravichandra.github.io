<div id="only-one" data-accordion-group>   				
  <?php foreach( $all_attributes as  $singleattr  ) {?>
	<!-- <section data-accordion> -->
	 <div class="accordianBox" data-accordion>
		<!-- <div class="accordianLink" data-control><a href="javascript:void(0)"><?php echo $singleattr->attr_name ?></a></div> -->
			
			<div class="accordianLink" data-control><a href="javascript:void(0)"><?php echo $singleattr->attr_name ?></a></div>
			
			<div class="accordianDet12 " data-content>
			
			<?php  $allQuestion = $this->attribute->getQuestionWithAttr($singleattr->attr_id); ?>
			
			<div class="outerBox">
				
				   <div id="sortable2" class="connectedSortable dynamic-<?php echo $singleattr->attr_id ?>">
						<?php   if($allQuestion){  ?>		
						<?php foreach($allQuestion as $sngQuestion) { 
								if(in_array($sngQuestion->ques_id,$s3Ids)!==FALSE) continue;
							?>							
								<div class="ui-state-highlight" id="ques-<?= $sngQuestion->ques_id; ?>" ><?php echo $sngQuestion->question_name; ?>												
								<input type="hidden" name="Question_ID[]" class="Question_ID" value="<?php echo $sngQuestion->ques_id; ?>">
                                <?php if($sngQuestion->user_id==$_SESSION['ss_user_id']){?>
														<div style="float:right; width:8px;cursor:pointer; margin-top:-10px;"><a onclick="deleteQues(<?=$sngQuestion->ques_id;?>)"><span style="cursor:pointer; color:#C6C6C6; font-weight:bold; padding-top:2px; font-size:10px;">X</span></a></div><?php }?>
                              </div>
							
						<?php }  ?>
						<?php } ?>		
					</div>
														
			</div>									
			<div class="clearfix">
				<form action="" method="Post" class="form-inline" role="form">
					<div class="addCoustom">Add custom<span>Question </span></div>
					
					<div class="coustomInput">
						<input class="addNewAttrQuestion attrib" id="newAttr-<?php echo $singleattr->attr_id; ?>" name="newquestion" placeholder="add question">
					</div>
					<!-- <input class="btn btn-default" type="submit" value="add" > -->
				</form>
				
			</div>
		</div> 													
	 </div> 
	<!-- </section> -->
	<?php  } ?>	
</div>

