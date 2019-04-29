<?php 
	/* find productinfo */
	$getProdcutinfo = $this->productModel->getProduct($campaign_info->product_id);
?>
<tr id="PersTR" class="PerTrClass">
	<td class="no-border" colspan="3">
		Does 
		<span class="TextColor">
			<?php echo $getProdcutinfo->product_name; ?>
		</span>help 
		<span class="dynamicFillTecArea TextColor">
			<?php 
				if($campaign_info->campaign_target == '1'){	
						echo $campaign_info->individual;
					}else{
						echo $campaign_info->organization;
				}
			?>
		</span>
		to create any other personal improvements?
		<br /><br />
		<div align="right">
			<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
			We help 
			<span class="dynamicFillTecArea TextColor">
				<?php 
					echo $campaign_info->individual;
					
					/*
					if($campaign_info->campaign_target == '1'){	
							echo $campaign_info->individual;
						}else{
							echo $campaign_info->organization;
					}
					*/
				?>
			</span> to 
			<!-- <span class="dynamicTxt_V<?php // echo $campaign_info->campaign_id ;?>_<?php // echo $new_per_val_id ?> TextColor"><?php // echo 'Personal value';?></span>. -->
		</div>
	</td>
	
	<td class="no-border">
		<div align="center" class="TextColorH">Personal Value</div>
		<textarea class="validate[required] dynamicTxt PersValuesDy" style="width:350px;" name="tbl[pvd][<?php echo $new_per_val_id;?>][pers_value]" id="V<?php echo $campaign_info->campaign_id ;?>_<?php echo $new_per_val_id ;?>" cols="" rows="" onkeyup="PersdynamicText();"><?php echo 'Personal value';?></textarea>
		<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
	</td>
	<td class="no-border"><a class="ui-icon ui-icon-closethick" title="Delete" href="#;" onclick="hide_box_status('<?php echo $new_per_val_id ;?>','pvd','<?php echo $campaign_info->campaign_id ?>');">X</a></td>
</tr>