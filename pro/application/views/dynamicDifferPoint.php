<?php 
	/* find productinfo */
	$getProdcutinfo = $this->productModel->getProductinfo($campaign_info->product_id);
?>
<tr>                                
<tr  class="dynamicDifferPoints"> 
<td class="no-border" >
    <div align="right">
        <br /><br />
        <span class="boldWeight" > Finish this sentence:  </span>&nbsp;&nbsp;&nbsp;&nbsp;
        One way the we differ is that                                      
    </div>
</td>                               
<td class="no-border">
    <div class="grid5"><textarea class="validate[required] dynamicTxt"  style="width:350px;" id="BI_1" name="tbl[tpd][<?php echo$interestB1->product_data_id;?>][interestB1]" cols="" rows=""><?php echo (isset($interestB1->value) ? $interestB1->value : '[differentiation point 1]');?></textarea></div>
</td>                            	                          
</tr>