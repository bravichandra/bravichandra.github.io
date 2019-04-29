<?php 
	/* find productinfo */
	$getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
?>
<tr class="BiZPainTrClass">
	<td class="grid5 no-border" style="" colspan="3" >
		What is another business challenge or problem that 
		<span class="TextColor">
				<?php echo $getProdcutinfo->product_name; ?>
		</span> 
		helps 	
		<span class="TextColor">
			<?php 
				if($campaign_info->campaign_target == '1'){	
					echo $campaign_info->individual;
				}else{
					echo $campaign_info->organization;
				}
			?>
		</span>to resolve?
			<br /><br />
			<div align="right">
				<span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
				A lot of <span class="dynamicFillTecArea TextColor">
					<?php 
						if($campaign_info->campaign_target == '1'){	
							echo $campaign_info->individual;
						}else{
							echo $campaign_info->organization;
						}
					?>
					
				</span> express concerns with  
				<!-- <span class="dynamicTxt_P<?php // echo $campaign_info->campaign_id ;?>_<?php // echo $new_biz_pain_id ;?> TextColor"><?php  // echo 'Business pain'; ?></span>. -->
			</div>
	  </td>
	<td class="no-border">
		<div class="grid5">
			<div align="center" class="TextColorH">Business Pain</div>
			<textarea class="validate[required] dynamicTxt" style="width:350px;" name="tbl[bpd][<?php echo $new_biz_pain_id;?>][bus_pain]" cols="" rows="" id="P<?php echo $campaign_info->campaign_id ;?>_<?php echo $new_biz_pain_id ;?>"><?php  echo 'Business pain'; ?></textarea>
			<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
		</div>
	</td>
	<td class="no-border" >
		<div class="grid5">
			<div align="center" class="TextColorH">No </div>
			<div><span class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $new_biz_pain_id ?>','bpd','<?php echo $campaign_info->campaign_id ?>');">X</span></div>
		</div>
	</td>
	
</tr>