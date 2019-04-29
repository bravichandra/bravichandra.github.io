<?php $this->load->view('common/meta');?>
<?php $this->load->view('common/header');?>
<style>
.delete {font-size: 20px;}
</style>
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
    <?php //echo $this->load->view('common/progress_bar');?>
    <!-- Breadcrumbs line -->
    <?php // echo $this->load->view('common/top_navigation');?>
    <?php echo $this->load->view('common/campaign_nav');?>
    <!-- Main content -->

    <div class="wrapper">     
       <form id="frm-input" action="<?php echo current_url();?>" method="post">  
         <?php if (isset($products)):?>
         <?php $total_products =  count($products);?>
       		<?php $i = 1; foreach ($products as $product):?>
                <?php 
                    $data = $this->home->get_meta_data($product->product_id, 'product', 'tpd');

                    $pro1_Q1 	= isset($data['v_Q1']['value']) ? $data['v_Q1']['value'] : NULL;
                    $pro2_Q2 	= isset($data['v_Q2']['value']) ? $data['v_Q2']['value'] : NULL;
                    $pro3_Q3 	= isset($data['v_Q3']['value']) ? $data['v_Q3']['value'] : NULL;

                    $p_S1_id 	= isset($data['pain_Q1']['id']) ? $data['pain_Q1']['id'] : '1';
                    $p_S2_id 	= isset($data['pain_Q2']['id']) ? $data['pain_Q2']['id'] : '2';
                    $p_S3_id 	= isset($data['pain_Q3']['id']) ? $data['pain_Q3']['id'] : '3';
                    $p_S4_id 	= isset($data['pain_Q4']['id']) ? $data['pain_Q4']['id'] : '4';
                    $p_S5_id 	= isset($data['pain_Q5']['id']) ? $data['pain_Q5']['id'] : '5';
                    $p_S6_id 	= isset($data['pain_Q6']['id']) ? $data['pain_Q6']['id'] : '6';

                    $technical_data = $this->home->get_value_pain($product->product_id, 'PT');
                    $business_data  = $this->home->get_value_pain($product->product_id, 'PB');
                    $personal_data  = $this->home->get_value_pain($product->product_id, 'PP');

                    $detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');
                    $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');
                    $detail_pers_data  = $this->home->get_value_pain($product->product_id, 'DP');

                    $value_technical_data = $this->home->get_value_pain($product->product_id, 'T');
                    $value_business_data  = $this->home->get_value_pain($product->product_id, 'B');
                    $value_personal_data  = $this->home->get_value_pain($product->product_id, 'P');
                ?>

       	  <!-- <h5 style="margin-top:30px;">Identify the environment that an ideal prospect for <?php echo (isset($data['P_Q1']['value']) ? $data['P_Q1']['value'] : NULL); ?> would have</h5> -->
          <?php if(isset($technical_data)):?> 
          <div class="widget tableTabs">
          <!-- <div class="whead"><h6>Ideal Prospect Environment</h6><div class="clear"></div></div> -->
            <div class="tab_container">
                <!--div id="ttab1" class="tab_content"-->
                    
                <div style="min-height: 180px; display: block;" class="tab_content" id="ttab1">
                    <div style="margin-top:10px;margin-bottom:10px;margin-left: 3px;">
								When <span class="TextColor">
									<?php 
										if($active_direct_campaign->value == 'individual'){	
											echo $active_target_audiance->value;
										}else{
											echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');
										}
									?>
								</span> have</div>
                                <div>
                                    <div id="tech-value" style="float:left;width:50%;">   
                                        <?php $number=0; $counterT=1; $T_RowCount=0;
                                            foreach ($technical_data as $technical):?>
                                               <?php if($technical->Qus_status == 1){ ?>
												
                                                <?php if($counterT == 1 AND $number != 0):?>
                                                        <p style="font-size: 100%;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S1_id;?> TextColor"><?php echo $technical->value;?></span></p>
                                                <?php else :?>
                                                        <p style="font-size: 100%;"><span class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $technical->id;?> TextColor" style="width: 20em;"><?php echo (!empty($technical_data[$number]->value) ? $technical_data[$number]->value : 'Added Technical Detail');?></span></p>
                                                <?php endif;?>
												
												<?php } ?>
												
                                            <?php $number++; $counterT++; $T_RowCount++;
                                        endforeach;?>
                                                        
                                         <!--- Business Data -->            
                                        <?php if(isset($business_data)):?>
                                            <?php $number=0; $counterB=1; $B_RowCount=0;
                                                foreach ($business_data as $business):?>
                                                    <?php if($business->Qus_status == 1){ ?> 
													
														<?php if($counterB == 1 AND $number != 0):?>
															<p style="font-size: 100%;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S3_id;?> TextColor"><?php echo $business->value;?></span></p>
														<?php else :?>
															<p style="font-size: 100%;"><span class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $business->id;?> TextColor" style="width: 20em;"><?php echo (!empty($business_data[$number]->value) ? $business_data[$number]->value : 'Added Business Detail');?></span></p>
														<?php endif;?>
													
													<?php } ?>
                                                    <?php $number++; $counterB++;$B_RowCount++; 
                                                    
                                                endforeach;?>
                                        <?php endif?> 
                                        <!-- End Business Data -->
                                        
                                        <!-- Personal Data -->
                                        <?php if(isset($personal_data)):?>
                                        <?php $number=0; $counterP=1; $P_RowCount=0;
                                            foreach ($personal_data as $personal):?>
                                                
												<?php if($personal->Qus_status == 1){ ?>
												
													<?php if($counterP == 1 AND $number != 0):?>
                                                          <p style="font-size: 100%;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S5_id;?> TextColor"><?php echo $personal->value;?></span></p>
													<?php else :?>
                                                          <p style="font-size: 100%;"><span class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $personal->id;?> TextColor" style="width: 20em;"><?php echo (!empty($personal_data[$number]->value) ? $personal_data[$number]->value : 'Added Personal Detail');?></span></p>
													<?php endif;?>													
												<?php } ?>
												  
                                              <?php $number++; $counterP++;$P_RowCount++;
                                            endforeach;?>
                                        <?php endif?> 
                                        <!-- End Personal Data -->
                                        
                                        <!-- <p style="font-size: 100%;"><span class="no-border">something that could be causing that is</span></p> -->
                                        <p style="font-size: 100%;"><span class="no-border">Is there a root cause on the prospect's side that could cause some of these challenges that you can help to resolve?</span></p>
                                    </div>
                                    <div style="float:left;width:50%;">
                                            <div align="right" style="margin-right: 42px; margin-top: -25px;">
                                                    <div align="center" style="margin-left: 190px;" class="TextColorH">Ideal Prospect Environment</div>
                                                    <!-- <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_tech_data[0]->field_type;?>][<?php echo $detail_tech_data[0]->id;?>][]" cols="" rows="" id="V<?php echo $product->product_id;?>_<?php echo $detail_tech_data[0]->field_type;?>"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_tech_data[0]->value) ? $detail_tech_data[0]->value : '[root cause for Pain '.$i.']');}else {echo (!empty($detail_tech_data[0]->value) ? $detail_tech_data[0]->value : NULL);} ?></textarea> -->
                                                    <!-- <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_tech_data[0]->field_type;?>][<?php echo $detail_tech_data[0]->id;?>][]" cols="" rows="" id="V<?php echo $product->product_id;?>_<?php echo $detail_tech_data[0]->field_type;?>"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_tech_data[0]->value) ? $detail_tech_data[0]->value : '[root cause for technical pain '.$i.']');}else {echo (!empty($detail_tech_data[0]->value) ? $detail_tech_data[0]->value : NULL);} ?><?php echo "\n";?><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_bus_data[0]->value) ? $detail_bus_data[0]->value : '[root cause for business pain '.$i.']');}else {echo (!empty($detail_bus_data[0]->value) ? $detail_bus_data[0]->value : NULL);} ?><?php echo "\n";?><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_pers_data[0]->value) ? $detail_pers_data[0]->value : '[root cause for personal pain '.$i.']');}else {echo (!empty($detail_pers_data[0]->value) ? $detail_pers_data[0]->value : NULL);} ?></textarea> -->
                                                    <textarea class="validate[required] dynamicTxt" style="width:350px;" placeholder="<?php foreach ($detail_tech_data as $detail_tech):?><?php if (empty($detail_tech->value)) {?><?php echo "[root cause for pain]"; } ?><?php endforeach;?>" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_tech_data[0]->field_type;?>][<?php echo $detail_tech_data[0]->id;?>][]" cols="" rows="" id="V<?php echo $product->product_id;?>_<?php echo $detail_tech_data[0]->field_type;?>"><?php foreach ($detail_tech_data as $detail_tech):?><?php if (!empty($detail_tech->value)) {?><?php echo $detail_tech->value;?><?php } ?><?php endforeach;?></textarea>
                                                    <!--
                                                    <div align="center" style="margin-left: 190px;" class="TextColorH">Answer Checker</div>
                                                        <div align="center" style="margin-left: 190px;">
                                                                    Do you have <span class="dynamicTxt_V<?php echo $product->product_id;?>_<?php echo $detail_tech_data[0]->field_type;?> TextColor"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_tech_data[0]->value) ? $detail_tech_data[0]->value : '[root cause for Pain '.$i.']');}else {echo (!empty($detail_tech_data[0]->value) ? $detail_tech_data[0]->value : NULL);} ?></span> ?
                                                        </div>
                                                    -->
                                                    
                                                    
                                                    <!-- <div id="10" data-icon="&#xe090;" style="margin-right: -23px;margin-top: -50px;" class="dialog_open fs1 iconb"></div> -->
                                            </div>
                                    </div>
	                       </div>
                    <table width="100%" cellspacing="0" cellpadding="0" class="tDefault">
                        <tbody> 
                        </tbody>
                    </table>
                </div>
                    
                    
                    <!--table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="p_table_<?php echo $i;?>">
                        <tbody>
                            <?php $number=0; $counterT=1; foreach ($technical_data as $technical):?>
                                      <?php if($counterT == 1 AND $number != 0):?>
                                          <tr>
                                              <td class="no-border" style="width: 25em;">When my customers have</td>
                                              <td class="no-border " style="width: 20em;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S1_id;?> TextColor"><?php echo $technical->value;?></span></td>
                                              <td class="no-border" style="width: 22em;">, something that could be causing that is </td>
                                              <td class="no-border">
                                              <div class="grid5">
                                              <div align="center" class="TextColorH"></div>
                                              <textarea  class="validate[required]"  style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_tech_data[$number]->field_type;?>][<?php echo $detail_tech_data[$number]->id;?>][]" cols="" rows="" id="P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S2_id;?>"><?php if($i == 1 AND $total_products > 1){echo (!empty($detail_tech_data[$number]->value) ? $detail_tech_data[$number]->value : '[root cause for Pain 1]');}else {echo (!empty($detail_tech_data[$number]->value) ? $detail_tech_data[$number]->value : NULL);} ?></textarea></div></td>
                                              <td class="no-border"><div class="grid5"><div id="10" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                                          </tr>
                                          <tr><td class="no-border"><div class="grid5"><div id="10" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td></tr>

                                      <?php else :?>
                                          <tr>
                                              <td class="no-border" style="width: 25em;">When my customers have</td>
                                              <td class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $technical->id;?> TextColor" style="width: 20em;"><?php echo (!empty($technical_data[$number]->value) ? $technical_data[$number]->value : 'Added Technical Detail');?></td>
                                              <td class="no-border" style="width: 22em;">, something that could be causing that is </td>
                                              <td class="no-border">
                                              <div class="grid5">
                                              <div align="center" class="TextColorH"></div>
                                              <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_tech_data[$number]->field_type;?>][<?php echo $detail_tech_data[$number]->id;?>][]" cols="" rows="" id=""><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_tech_data[$number]->value) ? $detail_tech_data[$number]->value : '[root cause for Pain '.$counterT.']');}else {echo (!empty($detail_tech_data[$number]->value) ? $detail_tech_data[$number]->value : NULL);} ?></textarea></div>
                                              </td>
                                              <td class="no-border" >
                                              <div class="grid5"><div id="10" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div>
                                              </td>
                                              <td class="no-border"></td>
                                        </tr>
                                    <?php endif;?>
                            <?php $number++; $counterT++; endforeach;?>
                            </tbody>
                    </table>
                </div-->
            </div>	
            <div class="clear"></div>		 
        </div>
		
        <?php endif?>
  
        <?php if(isset($business_data)):?>
<!--        <div class="widget tableTabs">
          <div class="whead"><h6>Business Pain - Ideal Prospect Environment</h6><div class="clear"></div></div>
            <div class="tab_container">
                
                <div style="min-height: 180px; display: block;" class="tab_content" id="ttab1">
                    <div style="margin-top:10px;margin-bottom:10px;margin-left: 3px;">When <span class="TextColor"><?php  echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> have</div>
                                <div>
                                    <div id="tech-value" style="float:left;width:50%;">   
                            <?php $number=0; $counterB=1; foreach ($business_data as $business):?>
                                      <?php if($counterB == 1 AND $number != 0):?>
                                        <p style="font-size: 100%;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S3_id;?> TextColor"><?php echo $business->value;?></span></p>
                                <?php else :?>
                                        <p style="font-size: 100%;"><span class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $business->id;?> TextColor" style="width: 20em;"><?php echo (!empty($business_data[$number]->value) ? $business_data[$number]->value : 'Added Business Detail');?></span></p>
                                <?php endif;?>
                            <?php $number++; $counterB++; 
                            endforeach;?>
                                         <p style="font-size: 100%;"><span class="no-border">something that could be causing that is</span></p> 
                                        <p style="font-size: 100%;"><span class="no-border">Is there a root cause on the prospect's side that could cause some of these challenges that you can help to resolve?</span></p>
                                    </div>
                                    <div style="float:left;width:50%;">
                                            <div align="right" style="margin-right: 42px; margin-top: -25px;">
                                                    <div align="center" style="margin-left: 190px;" class="TextColorH">Ideal Prospect Environment</div>
                                                    <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_bus_data[0]->field_type;?>][<?php echo $detail_bus_data[0]->id;?>][]" cols="" rows="" id="V<?php echo $product->product_id;?>_<?php echo $detail_bus_data[0]->field_type;?>"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_bus_data[0]->value) ? $detail_bus_data[0]->value : '[root cause for Pain '.$i.']');}else {echo (!empty($detail_bus_data[0]->value) ? $detail_bus_data[0]->value : NULL);} ?></textarea>
                                                    
                                                    <div align="center" style="margin-left: 190px;" class="TextColorH">Answer Checker</div>
                                                        <div align="center" style="margin-left: 190px;">
                                                                    Do you have <span class="dynamicTxt_V<?php echo $product->product_id;?>_<?php echo $detail_bus_data[0]->field_type;?> TextColor"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_bus_data[0]->value) ? $detail_bus_data[0]->value : '[root cause for Pain '.$i.']');}else {echo (!empty($detail_bus_data[0]->value) ? $detail_bus_data[0]->value : NULL);} ?></span> ?
                                                        </div>
                                                    
                                                    <div id="10" data-icon="&#xe090;" style="margin-right: -23px;margin-top: -50px;" class="dialog_open fs1 iconb"></div>
                                            </div>
                                    </div>
	                       </div>
                    <table width="100%" cellspacing="0" cellpadding="0" class="tDefault">
                        <tbody> 
                        </tbody>
                    </table>
                </div>
                
                div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="p_table_<?php echo $i;?>">
                        <tbody>
                            <?php $number=0; $counterB=1; foreach ($business_data as $business):?>
                                      <?php if($counterB == 1 AND $number != 0):?>
                                          <tr>
                                              <td class="no-border" style="width: 25em;">When my customers have</td>
                                              <td class="no-border TextColor" style="width: 20em;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S3_id;?> TextColor"><?php echo $business->value;?></span></td>
                                              <td class="no-border" style="width: 22em;">, something that could be causing that is </td>
                                              <td class="no-border">
                                              <div class="grid5">
                                              <div align="center" class="TextColorH"></div>
                                              <textarea  class="validate[required]"  style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_bus_data[$number]->field_type;?>][<?php echo $detail_bus_data[$number]->id;?>][]" cols="" rows="" id="P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S4_id;?>"><?php echo $detail_bus_data[$number]->value;?></textarea></div></td>
                                              <td class="no-border"><div class="grid5"><div id="11" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                                          </tr>
                                      <?php else :?>
                                          <tr>
                                              <td class="no-border" style="width: 25em;">When my customers have</td>
                                              <td class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $business->id;?> TextColor" style="width: 20em;"><?php echo (!empty($business_data[$number]->value) ? $business_data[$number]->value : 'Added Business Detail');?></td>
                                              <td class="no-border" style="width: 22em;">, something that could be causing that is </td>
                                              <td class="no-border">
                                              <div align="center" class="TextColorH"></div>
                                              <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_bus_data[$number]->field_type;?>][<?php echo $detail_bus_data[$number]->id;?>][]" cols="" rows="" id=""><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_bus_data[$number]->value) ? $detail_bus_data[$number]->value : '[root cause for Pain '.$counterB.']');}else {echo (!empty($detail_bus_data[$number]->value) ? $detail_bus_data[$number]->value : NULL);} ?></textarea>
                                              </td>
                                              <td class="no-border" >
                                              <div class="grid5"><div id="11" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div>
                                              </td>
                                              <td class="no-border"></td>
                                          </tr>
                                      <?php endif;?>
                              <?php $number++; $counterB++; endforeach;?>
                         </tbody>
                    </table>
                </div
            </div>
            <div class="clear"></div>
        </div>-->

	<?php endif?>
          
	<?php if(isset($personal_data)):?>
<!--        <div class="widget tableTabs">
          <div class="whead"><h6>Personal Pain - Ideal Prospect Environment</h6><div class="clear"></div></div>
            <div class="tab_container">
                
                <div style="min-height: 180px; display: block;" class="tab_content" id="ttab1">
                    <div style="margin-top:10px;margin-bottom:10px;margin-left: 3px;">When <span class="TextColor"><?php  echo (!empty($custome_fields['1']->value) ? $custome_fields['1']->value : 'businesses');?></span> have</div>
                                <div>
                                    <div id="tech-value" style="float:left;width:50%;">   
                            <?php $number=0; $counterP=1; foreach ($personal_data as $personal):?>
                                          <?php if($counterP == 1 AND $number != 0):?>
                                        <p style="font-size: 100%;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S5_id;?> TextColor"><?php echo $personal->value;?></span></p>
                                <?php else :?>
                                        <p style="font-size: 100%;"><span class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $personal->id;?> TextColor" style="width: 20em;"><?php echo (!empty($personal_data[$number]->value) ? $personal_data[$number]->value : 'Added Personal Detail');?></span></p>
                                <?php endif;?>
                            <?php $number++; $counterP++;
                            endforeach;?>
                                         <p style="font-size: 100%;"><span class="no-border">something that could be causing that is</span></p> 
                                        <p style="font-size: 100%;"><span class="no-border">Is there a root cause on the prospect's side that could cause some of these challenges that you can help to resolve?</span></p>
                                    </div>
                                    <div style="float:left;width:50%;">
                                            <div align="right" style="margin-right: 42px; margin-top: -25px;">
                                                    <div align="center" style="margin-left: 190px;" class="TextColorH">Ideal Prospect Environment</div>
                                                    <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_pers_data[0]->field_type;?>][<?php echo $detail_pers_data[0]->id;?>][]" cols="" rows="" id="V<?php echo $product->product_id;?>_<?php echo $detail_pers_data[0]->field_type;?>"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_pers_data[0]->value) ? $detail_pers_data[0]->value : '[root cause for Pain '.$i.']');}else {echo (!empty($detail_pers_data[0]->value) ? $detail_pers_data[0]->value : NULL);} ?></textarea>
                                                    
                                                    <div align="center" style="margin-left: 190px;" class="TextColorH">Answer Checker</div>
                                                        <div align="center" style="margin-left: 190px;">
                                                                    Do you have <span class="dynamicTxt_V<?php echo $product->product_id;?>_<?php echo $detail_pers_data[0]->field_type;?> TextColor"><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_pers_data[0]->value) ? $detail_pers_data[0]->value : '[root cause for Pain '.$i.']');}else {echo (!empty($detail_pers_data[0]->value) ? $detail_pers_data[0]->value : NULL);} ?></span> ?
                                                        </div>
                                                    
                                                    <div id="10" data-icon="&#xe090;" style="margin-right: -23px;margin-top: -50px;" class="dialog_open fs1 iconb"></div>
                                            </div>
                                    </div>
	                       </div>
                    <table width="100%" cellspacing="0" cellpadding="0" class="tDefault">
                        <tbody> 
                        </tbody>
                    </table>
                </div>
                
                div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="p_table_<?php echo $i;?>">
                        <tbody>
                                <?php $number=0; $counterP=1; foreach ($personal_data as $personal):?>
                                          <?php if($counterP == 1 AND $number != 0):?>
                                                <tr>
                                                    <td class="no-border" style="width: 25em;">When my customers have</td>
                                                    <td class="no-border TextColor" style="width: 20em;"><span class="dynamicTxt_P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S5_id;?> TextColor"><?php echo $personal->value;?></span></td>
                                                    <td class="no-border" style="width: 22em;">, something that could be causing that is </td>
                                                    <td class="no-border">
                                                    <div class="grid5">
                                                    <div align="center" class="TextColorH"></div>
                                                    <textarea  class="validate[required]"  style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_pers_data[$number]->field_type;?>][<?php echo $detail_pers_data[$number]->id;?>][]" cols="" rows="" id="P<?php echo (isset($product->product_id) ? $product->product_id : $product_id);?>_<?php echo $p_S6_id;?>"><?php echo $detail_pers_data[$number]->value;?></textarea></div></td>
                                                    <td class="no-border"><div class="grid5"><div id="12" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                                                </tr>
                                                <?php else :?>
                                                <tr>
                                                    <td class="no-border" style="width: 25em;">When my customers have</td>
                                                    <td class="no-border dynamicTxt_P<?php echo $product->product_id;?>_<?php echo $personal->id;?> TextColor" style="width: 20em;"><?php echo (!empty($personal_data[$number]->value) ? $personal_data[$number]->value : 'Added Personal Detail');?></td>
                                                    <td class="no-border" style="width: 22em;">, something that could be causing that is </td>
                                                    <td class="no-border">
                                                    <div align="center" class="TextColorH"></div>
                                                    <textarea class="validate[required] dynamicTxt" style="width:350px;" name="tpd_<?php echo $product->product_id;?>[<?php echo $detail_pers_data[$number]->field_type;?>][<?php echo $detail_pers_data[$number]->id;?>][]" cols="" rows="" id=""><?php if($i == 1 AND $total_products > 1 OR $total_products == '1' ){echo (!empty($detail_pers_data[$number]->value) ? $detail_pers_data[$number]->value : '[root cause for Pain '.$counterP.']');}else {echo (!empty($detail_pers_data[$number]->value) ? $detail_pers_data[$number]->value : NULL);} ?></textarea>
                                                    </td>
                                                    <td class="no-border" >
                                                    <div class="grid5"><div id="12" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div>
                                                    </td>
                                                    <td class="no-border"></td>
                                                </tr> 
                                          <?php endif;?>
                                <?php $number++; $counterP++; endforeach;?>
                        </tbody>
                    </table>
                </div
                
            </div>	
            <div class="clear"></div>		 
        </div>-->
        
       <?php endif?>
          
          <!--
          <?php if($is_paid): ?>

        		<div align="right">

		        	<input type="button" <?php if($is_paid) { ?> onclick='addPainRow("p_table_<?php echo $i;?>","T","<?php echo $product->product_id;?>")' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Technical Pain" style="margin-top:10px;color:white !important;"/>

		        	<input type="button" <?php if($is_paid) { ?> onclick='addPainRow("p_table_<?php echo $i;?>","B","<?php echo $product->product_id;?>")' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Business Pain" style="margin-top:10px;color:white !important;"/>

		        	<input type="button" <?php if($is_paid) { ?> onclick='addPainRow("p_table_<?php echo $i;?>","P","<?php echo $product->product_id;?>")' class="buttonM bBlack" <?php }else {?> id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack" <?php }?> value="Add Personal Pain" style="margin-top:10px;color:white !important;"/>

		        </div>

		 <?php else:?>

		 	<div align="right">

		        	<input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Technical Pain" style="margin-top:10px;color:white !important;"/>

		        	<input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Business Pain" style="margin-top:10px;color:white !important;"/>

		        	<input type="button" id="33" data-icon="&#xe090;" class="dialog_open_pro buttonM bBlack show" value="Add Personal Pain" style="margin-top:10px;color:white !important;"/>

			 </div>

		 <?php endif;?>
          -->
          
      	<?php $i++; endforeach;?>
 <?php endif;?>
        <div class="fluid" style="margin-top:15px;">
        <?php if($session_status != '2'):?>
          	<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
          	<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
          	<!--a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a-->
          	<input type="hidden" name="step" value="ideal_prospect_environment">
          	<input type="hidden" id="redirect_url" name="redirect_url" value="">
         <?php else:?>
          		<input type="hidden" name="form_submit" id="from_hidden_submit" />
          		<input style="margin-top: -25px; margin-right: 10px" type="button" class="dialog_session buttonM bBlue" value="Save" data-icon="&#xe090;"/>
          		<input type="button" class="dialog_session buttonM bRed" value="Continue" data-icon="&#xe090;" />
         <?php endif;?>
        </div>
        </form>
     </div>

        </div>

    </div>
    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>