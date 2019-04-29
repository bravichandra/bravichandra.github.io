<?php $BusRowCounter= 1; ?>
<?php
   /* find productinfo */
	$getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
?>
<tr id="BusTR<?php echo $BusRowCounter;?>">
	<td class="no-border" colspan="3">
		Does 
		<span class="TextColor">
			<?php echo $getProdcutinfo->product_name; ?>
		</span> help 
		<span class="dynamicFillTecArea TextColor">
			<?php 
				if($campaign_info->campaign_target == '1'){	
						echo $campaign_info->individual;
					}else{
						echo $campaign_info->organization;
				}
			?>
		</span>
		to create any other business improvements?
		
		<div align="right">
			<span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
			We help 
			<span class="dynamicFillTecArea TextColor">
				<?php 
					if($campaign_info->campaign_target == '1'){	
							echo $campaign_info->individual;
						}else{
							echo $campaign_info->organization;
					}
				?>
			</span> to 
			<!-- <span class="dynamicTxt_V<?php echo $campaign_info->campaign_id;?>_<?php echo $new_biz_val_id;?> TextColor"><?php echo 'Business value' ;?></span>. -->
		</div>
		
	</td>
	
	<td class="no-border">
		<div align="center" class="TextColorH">Business Value</div>
		<textarea class="validate[required] dynamicTxt BusValuesDY " style="width:350px;" name="tbl[bvd][<?php echo $new_biz_val_id; ?>][biz_value]" id="V<?php echo $campaign_info->campaign_id;?>_<?php echo $new_biz_val_id;?>" cols="" rows="" onkeyup="BusdynamicText();"><?php echo 'Business value';?></textarea>
		<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
		
	</td>
	<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $new_biz_val_id;?>', 'bvd','<?php echo $campaign_info->campaign_id ?>');">X</a></td>
</tr>