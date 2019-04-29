<div class="quatabs">
	<?php
		if($Quest_attr) {
			foreach($Quest_attr as $ai=>$qattr){
				?>
				<div class="<?php echo ($ai==0?'active':'')?>"><a href="javascript:void(0);" data-id="<?php echo $qattr->cat_id?>" rel="box<?php echo $qattr->cat_id?>"><?php echo str_replace("Requirements","",$qattr->cat_name);?></a>
					<input type="hidden" name="record[qsections][<?php echo $qattr->cat_id?>]" value="<?php echo $qattr->cat_name?>" />
				</div>
				<?php
			}
		}
	?>
</div>
<div class="quaboxes">
	<?php // print_r($Quest_Id); // exit;
		if($Quest_questions) {
			$qi=-1;
			foreach($Quest_questions as $qatr=>$quest) {
				$c=$qatr;				
        		echo '<div id="box'.$qatr.'" class="'.($qatr==70?'active':'').'">';
        		foreach($quest as $qtn) {
				//print_r($qtn);
        			$qi++;
        			if(isset($qtn->question_name)) {
						if(!in_array($qtn->ques_id,$Quest_Id)) continue;
					    else $qname = $qtn->question_name; 
					}
        			//else if(isset($qtn->attr_name)) $qname = $qtn->attr_name;
        			else $qname = "";
        		?>
        		<div class="qualify">
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="box1"><?php echo $qname?></td>
							<td class="box2">
								<b>Quality Points:</b><br /> 
								<div class="qpoints">
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-3" /> -3</label> 
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-2" /> -2</label> 
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="-1" /> -1</label> 
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" checked="checked" class="optval" value="0" /> 0</label> 
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="1" /> 1</label> 
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="2" /> 2</label> 
									<label><input type="radio" name="record[section][<?php echo $c?>][qp][<?php echo $qi?>]" class="optval" value="3" /> 3</label><br />
								</div>
								<b>Notes</b><br />
								<textarea name="record[section][<?php echo $c?>][task_label][<?php echo $qi?>]" class="task_label"><?php echo $qname?></textarea>
								<textarea name="record[section][<?php echo $c?>][task_notes][<?php echo $qi?>]" class="task_notes"></textarea>
							</td>
						</tr>
					</table>                                
		        </div>
        		<?php
        		}
        		echo '</div>';
			}
		}
	?>
</div>
