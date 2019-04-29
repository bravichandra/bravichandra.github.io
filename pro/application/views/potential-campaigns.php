<?php echo $this->load->view('common/meta');?>	
<?php echo $this->load->view('common/header');?>
<style type="text/css">.button {color:red;}.delete {font-size: 20px;}</style>
<!-- Sidebar begins -->
<div id="sidebar">	
	<?php echo $this->load->view('common/left_navigation');?>	    
	<!-- Secondary nav -->    
	<div class="secNav">        	
		<div class="clear"></div>  
	</div>
</div>
<!-- Sidebar ends --> 

<!-- Content begins -->
<div id="content">                
	<!-- Breadcrumbs line -->	   
	<?php echo $this->load->view('common/camp_coord_nav');?> 
		<h3 align="center" style="margin-bottom: 9px; margin-top: -19px;">
			<!-- Main content -->    
			<div class="wrapper" style="color: #000000;text-align: left;font-size: 15px;"><br clear="all" />            	
				<?php if ($msg): ?><br />
                    <h3 style="color:#CC3300 !important;"><?php echo $msg; ?></h3>
                <?php endif; ?> 
                	<form action="<?php echo current_url();?>" method="post">
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Potential Sales Pitches</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										<td class="no-border" style="width:70%;font-weight: initial;">
                                        	Each intersection on the table below is a potential sales pitch that you could create. Select one for a sales pitch campaign that you would like to create.
										</td>										
									</tr>
									</tbody>
								</table><br clear="all" />
                                <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" style="font-weight: initial;border: 1px solid #cccccc;"> 
								  <tbody>
									 <tr> 
                                     	<td class="pcotdR" rowspan="2">Products</td>
										<td class="pcotd" align="center" colspan="<?php echo ($target_prospects?count($target_prospects):1);?>">Target Prospects</td>
									</tr>
                                     <tr> 
                                        <?php 
											$tds='';
											if ($target_prospects): ?>
											<?php foreach ($target_prospects as $product): $tds .='<td><input type="radio" name="pc_name[]" value="'.$product->tp_id.'-X" /></td>';?>
                                            	<td class="pcotd"><?php echo $product->tp_text; ?></td>
                                            <?php endforeach; ?>					                           
                                        <?php endif; ?>                                        
									</tr>
                                    <?php if ($product_profiles): ?>
										<?php foreach ($product_profiles as $product): $tdsN = str_replace("X",$product->product_id,$tds);?>
                                        	<tr>
                                            	<td class="pcotdR"><?php echo $product->product_name; ?></td><?php echo $tdsN;?>
                                            </tr>
                                        <?php endforeach; ?>					                           
                                    <?php endif; ?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>			
                    <div class="fluid" style="margin-top:15px;"><br />
                    	<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="btn_done" value="Done" />
                    	<?php /*?><a class="buttonM bRed" href="<?php echo base_url();?>folder/campaigns">Done</a><?php */?>
					</div>
					</form>
			</div>
		</div>
<?php $this->load->view('common/footer');?>