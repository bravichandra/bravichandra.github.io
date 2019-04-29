<tr class="BizQualifyTrClass">		                            			
	<td class="no-border" colspan="3">
		What additional business question would you ask 
		<span class="TextColor">
			<?php 
				if($campaign_info->campaign_target == '1'){	
					echo $campaign_info->individual;
				}else{
					echo $campaign_info->organization;
				}
			?></span>? 
	</td>	
	<td class="no-border" style="width: 32%;">
		<div class="grid5">
			<div align="center" class="TextColorH">Yes - How</div>
			<textarea  class="validate[required]"  style="width:350px;" id="QQ_7" name="tbl[bqd][<?php echo $new_biz_qualify_id ?>][bus_qualify]" cols="" rows=""><?php echo 'Business qualify' ;?></textarea>
		</div>
													
	</td>								                
	<td class="no-border">
		<div class="grid5">
		  <div align="center" class="TextColorH">No </div>
		  <div align="center"><span class="ui-icon ui-icon-closethick" id="hide_<?php echo $new_biz_qualify_id;?>" onclick="hide_box_status('<?php echo $new_biz_qualify_id ;?>','bqd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
		</div>
	</td>										
</tr>