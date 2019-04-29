<style>
.drop{
height: 25px;
    width: 300px;
	    padding: 6px 7px;
    border: 1px solid #d7d7d7;
	}
</style><!--<form action="<?php echo current_url();?>" method="post" class="formRow" style="padding:0px">-->
					
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Lead Source</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										
										<td class="no-border">											 
                                        	<div id="box_prospects">
                                            	<?php if ($lead): ?>
													<?php foreach ($lead as $key=>$val):$save=1; ?>
                                                    	<div class="boxtp<?php echo $key; ?>">
                                                            <div class="grid5" style="margin-bottom: 4px; float:left;width: 90%;">
                                                                <input type="text" class="txtinput drop" name="lead[]" value="<?php echo $val ?>" />
                                                               
                                                                <!--<input type="hidden" name="lead_id[]" value="<?php echo $product->tp_id; ?>" />-->                                                        	</div>
                                                            <div style="float:left;cursor: pointer;"><span class="ui-icon ui-icon-closethick" onclick="remove_tp(<?php echo $key; ?>,this);">X</span></div><div style="clear:both;"></div>   
                                                        </div>
                                                    <?php endforeach; ?>					                           
                                                <?php endif; ?>
                                            	<?php /*?><div class="grid5" style="margin-bottom: 4px;">
                                                    <input type="text" class="validate[required] txtinput" style="width:500px;height: 30px;border: 1px solid #cccccc;" name="txt_prospect[]" value="" />
                                                    <input type="hidden" name="prospect_id[]" value="0" />
                                                </div><?php */?>
                                            </div>
                                            <div class="grid5" style="margin-bottom: 4px;">
                                                <div align="center" style="margin-top: 8px;">
                                                	<input type="button" class="buttonM bRed" onclick="add_product(1);" value="Add" />
                                                </div>
											</div>
										</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>	
                    <h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Stage</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										<td class="no-border">
                                        	<div id="box_products">
                                            <?php if ($stage): ?>
												<?php foreach ($stage as $key=>$val):$save=1; ?>
                                                <div class="boxtps<?php echo $key; ?>">
                                                	<div class="grid5" style="margin-bottom: 4px;  float:left;width: 90%;">
                                                    	<input type="text" class="txtinput drop" name="stage[]" value="<?php echo $val; ?>" />
                                                       
                                                        <!--<input type="hidden" name="prod_id[]" value="<?php echo $product->product_id; ?>" />-->
                                                    </div>   
                                                     <div style="float:left;cursor: pointer;"><span class="ui-icon ui-icon-closethick" onclick="remove_tp(<?php echo $key; ?>,this);">X</span></div><div style="clear:both;"></div>     
                                                     </div>                                
												<?php endforeach; ?>					                           
                                            <?php endif; ?>
                                            	
                                            </div>
                                            <div class="grid5" style="margin-bottom: 4px;">
                                                <div align="center" style="margin-top: 8px;">
                                                	<input type="button" class="buttonM bRed" onclick="add_product(2);" value="Add" />
                                                </div>
											</div>
										</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>	
                    
                    <div class="fluid"  align="center" style="margin-top:15px;">

                    	<span class="loader"></span>

                        <input type="submit" class="buttonM bBlue" name="btnsave" value="Save" />

                    </div>

                    <div style="text-align: left;padding-left: 10px;" id="esettings"></div>					
                    <!--<div class="fluid" style="margin-top:15px;">
                        <input style="margin-top: -25px; margin-right: 10px; <?php if(!$save) echo 'display:none;';?>" type="submit" class="buttonM bBlue" name="btn_save" id="btn_save" value="Save" />
                        <input type="submit" class="buttonM bRed" name="btn_next" value="Next" />                        
					</div>-->
					<!--</form>-->
                    
                    
                    
  <script type="text/javascript">
				function add_product(ptype) {
					var prod_data='';
				if(ptype==1) {
						prod_data = '<div class="boxtp"><div class="grid5" style="margin-bottom: 4px; float:left;width: 90%;"><input type="text" class="txtinput drop" name="lead[]" value="" /></div><div style="float:left;cursor: pointer;"><span class="ui-icon ui-icon-closethick" onclick="remove_tp(0,this);">X</span></div><div style="clear:both;"></div></div>';
						$("#box_prospects").append(prod_data);
					} else {
						prod_data = '<div class="boxtp"><div class="grid5" style="margin-bottom: 4px; float:left;width: 90%;"><input type="text" class="txtinput drop" name="stage[]" value="" /></div><div style="float:left;cursor: pointer;"><span class="ui-icon ui-icon-closethick" onclick="remove_tp(0,this);">X</span></div><div style="clear:both;"></div></div>';
						$("#box_products").append(prod_data);
					}
					/*$("#btn_save").show();*/
				}
				
			function remove_tp(tpid,dis) {
					$(dis).parent().parent().remove();
					/*if(tpid) {
						$.ajax({
							type : 'POST',
							url : '<?php echo current_url();?>', 
							data : { 'tpid' : tpid, 'action': 'removetp'},
							success : function(data){
								//nothing								
							}
						});
					}*/
				}
				</script>