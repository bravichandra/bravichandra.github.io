<?php $this->load->view('common/meta_outputs');?>
<title>Email Drip Campaign Guide</title>
</head>
<body>
<div id="content">
    <?php echo $this->load->view('common/logo');?>
    <h1 align="center">Email Drip Campaign Guide</h1>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
        <tr>
            <td class="border">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p>
                <strong>Audience Segmentation Key</strong>
                </p>
                <table border="1" width="100%" cellspacing="1" cellpadding="1">
                  <tr>
		    <th style="padding: 5px 0px !important; background: #A0A0A0; ">Segment</th>
                    <th style="padding: 5px 0px !important; background: #A0A0A0; ">Definition</th>
		  </tr>
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          New Prospects
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Targeted prospects that are being pursued but have not actively engaged, don't know who you are(suspects)
                      </td>
                  </tr>
                  
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Hot Prospects
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Actively engaged with discussions and meetings
                      </td>
                  </tr>
                  
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Warm Prospects
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Know who you are, want more information, on the fence, won't commit to forward movement
                      </td>
                  </tr>
                  
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Cold Prospects
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Not going to purchase in near future
                      </td>
                  </tr>
                  
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Closed Prospects
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Have communicated a firm no and zero interest - no potential to ever buy
                      </td>
                  </tr>
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Current Clients
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Currently purchasing products and services
                      </td>
                  </tr>
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Past Clients
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Have purchased products or services in the past
                      </td>
                  </tr>
                  <tr>
                      <td style="background: #DFDDD7;padding: 5px 20px !important;">
                          Referral Partners
                      </td>
                      <td style="padding: 5px 20px !important;">
                          Partners that refer business
                      </td>
                  </tr>
                </table>
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td class="border">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p>
                <strong>Tier 1 - Lead Generation</strong>
                </p>
                <table border="1" width="100%" cellspacing="1" cellpadding="1">
                  <tr>
		    <th  style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Audience Segment</th>
                    <td style="padding: 5px 5px !important;">New Prospects </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Goal</th>
                    <td style="padding: 5px 5px !important;">To generate leads </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Content Focus</th>
                    <td style="padding: 5px 5px !important;">Prospect focused </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Number of Emails</th>
                    <td style="padding: 5px 5px !important;">3 to 6 </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Frequency</th>
                    <td style="padding: 5px 5px !important;">Daily, Bi-daily, or weekly </td>
		  </tr>
                  
                  <tr>
                      <td colspan="2" style="background: #A0A0A0;padding: 1px 5px !important; text-align: center;">Potential Campaign Content Topics</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Value Points</th>
                    <td style="padding: 5px 5px !important;">
                        <table border="1" width="100%" cellspacing="1" cellpadding="1" class="matrix">
                                    <tr>
                                        <td colspan="2" style="text-align: left;">Content that shares the value that you have to offer<br><br></td>
                                    </tr>
                                    <tr>

                                      <th style="width:33%;">Technical Value</th>

                                      <th style="width:33%;">Business Value</th>

                                      <th style="width:33%;">Personal Value</th>

                                    </tr>

                                     <?php if (isset($products)):?>



                                          <?php $i = 0; foreach ($products as $product):?>

                                                          <?php $data = $this->home->get_meta_data($product->product_id, 'product', 'tpd');?>

                                                          <?php $p_1 	= isset($data['P_Q1']['value']) ? $data['P_Q1']['value'] : NULL;?>

                                                          <?php $p_2 	= isset($data['P_Q3']['value']) ? $data['P_Q3']['value'] : NULL;?>



                                                          <!-- Technical Value -->

                                                          <?php $technical_data = $this->home->get_value_pain($product->product_id, 'T');?>



                                                          <!-- Bussines Value -->

                                                          <?php $business_data  = $this->home->get_value_pain($product->product_id, 'B');?>



                                                          <!-- Personal Value -->

                                                          <?php $personal_data  = $this->home->get_value_pain($product->product_id, 'P');?>



                                                          <tr>
                                                                <td style="font-size: 13px;width:33%;">

                                                                  <ul >



                                                                                  <?php if(!empty($technical_data)): $counter = 1; foreach ($technical_data as $technical):?>

                                                                                  <?php if($counter == 1):?>

                                                                                          <?php echo '<li>' . $technical->value . '</li><br><br>';?>

                                                                                  <?php else:?>

                                                                                  <?php echo '<li>' . $technical->value . '</li>';?><?php endif;?><?php $counter++; endforeach; endif;?>



                                                                  </ul>

                                                                </td>

                                                          <td style="font-size: 13px;width:33%;">

                                                                  <ul >

                                                                          <?php if(!empty($business_data)):  $counter = 1; foreach ($business_data as $business):?>

                                                                          <?php if($counter == 1):?>

                                                                                  <?php echo '<li>' . $business->value . '</li><br><br>';?>

                                                                          <?php else:?>

                                                                                  <?php echo '<li>' . $business->value . '</li>';?><?php endif;?><?php $counter++; endforeach; endif;?>

                                                                  </ul>



                                                          </td>

                                                          <td style="font-size: 13px;width:33%;">

                                                                  <ul>

                                                                          <?php if(!empty($personal_data)):  $counter = 1; foreach ($personal_data as $personal):?>

                                                                          <?php if($counter == 1):?>

                                                                                  <?php echo '<li>' . $personal->value . '</li><br><br>';?>

                                                                          <?php else:?>

                                                                                  <?php echo '<li>' . $personal->value . '</li>';?><?php endif;?><?php $counter++; endforeach; endif;?>

                                                                  </ul>



                                                          </td>

                                                          </tr>

                                         <?php $i++; endforeach;?>



                                    <?php endif;?>

                        </table>
                        
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Pain Points</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                                    <tr>
                                        <td colspan="2" style="text-align: left;">Content that outlines the pain that your prospects often experience and that you help to resolve</td>
                                    </tr>
                                <tr>

                                        <td width="100%">

                                         <br><br>

                                        <strong>Technical</strong>

                                      <ul>

                                                <?php if (isset($products)):?>

                                                                <?php foreach ($products as $product):?>

                                                                        <?php $detail_tech_data = $this->home->get_value_pain($product->product_id, 'DT');?>

                                                                        <?php $technical_data = $this->home->get_value_pain($product->product_id, 'PT');?>

                                                                                <?php if(isset($detail_tech_data)):?>

                                                                                        <?php foreach ($technical_data as $technical):?>

                                                                                                <li><span class="<?php echo (!empty($technical->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $technical->id;?>__tech_pain__tpd"><?php echo $technical->value;?></span></li>

                                                                                        <?php endforeach;?>

                                                                                        <?php foreach ($detail_tech_data as $detail_tech):?>

                                                                                                <li><span class="<?php echo (!empty($detail_tech->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_tech->id;?>__desc_tech_pain__tpd"><?php echo $detail_tech->value;?></span></li>

                                                                                        <?php endforeach;?>

                                                                        <?php endif?>

                                                                <?php endforeach;?>

                                                        <?php endif;?> 

                                      </ul>

                                      <br>

                                      <strong>Business</strong>

                                      <ul>

                                                <?php if (isset($products)):?>

                                                                <?php foreach ($products as $product):?>

                                                                        <?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>

                                                                        <?php $business_data  = $this->home->get_value_pain($product->product_id, 'PB');?>

                                                                                <?php if(isset($detail_bus_data)):?>

                                                                                        <?php foreach ($business_data as $business):?>

                                                                                                <li><span class="<?php echo (!empty($business->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $business->id;?>__bus_pain__tpd"><?php echo $business->value;?></span></li>

                                                                                        <?php endforeach;?>

                                                                                        <?php foreach ($detail_bus_data as $detail_bus):?>

                                                                                                <li><span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span></li>

                                                                                        <?php endforeach;?>

                                                                        <?php endif?>

                                                                <?php endforeach;?>

                                                        <?php endif;?> 

                                      </ul>

                                      <br>

                                                <strong>Personal</strong>

                                              <ul>

                                                        <?php if (isset($products)):?>

                                                                                <?php foreach ($products as $product):?>

                                                                                        <?php $detail_pers_data  = $this->home->get_value_pain($product->product_id, 'DP'); ?>

                                                                                        <?php $personal_data  = $this->home->get_value_pain($product->product_id, 'PP');?>

                                                                                        <?php if(isset($detail_pers_data)):?>

                                                                                                <?php foreach ($personal_data as $personal):?>

                                                                                                        <li><span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_pain__tpd"><?php echo $personal->value;?></span></li>

                                                                                                <?php endforeach;?>

                                                                                                <?php foreach ($detail_pers_data as $detail_pers):?>

                                                                                                        <li><span class="<?php echo (!empty($detail_pers->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_pers->id;?>__desc_pers_pain__tpd"><?php echo $detail_pers->value;?></span></li>

                                                                                                <?php endforeach;?>

                                                                                        <?php endif?>

                                                                                <?php endforeach;?>

                                                                <?php endif;?> 

                                              </ul>

                                            <br><br> 

                                        </td>

                                </tr>

                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Qualify Questions</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                                    <tr>
                                        <td colspan="2" style="text-align: left;">Content based on the qualifying questions that you should be asking</td>
                                    </tr>
                                    <?php if (isset($credibilities)):?>

                                            <?php $i = 1; foreach ($credibilities as $credibility):?>

                                                            <?php 

                                                                    $data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');



                                                                            $customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;

                                                                            $customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;



                                                                            $worked_id = isset($data['worked']['id']) ? $data['worked']['id'] : NULL;

                                                                            $worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;



                                                                            $provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;

                                                                            $provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;



                                                                            $when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;

                                                                            $when_value = isset($data['when']['value']) ? $data['when']['value']: NULL;



                                                            ?>

                                            <tr>

                                                            <td><strong>Name Drop Statement #<?php echo $i;?></strong></td>

                                                    </tr>

                                                    <tr><td class="border">&nbsp;</td></tr>

                                                    <tr>

                                                            <td>

                                                                    <p>We worked with <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $customer_id;?>__customer__tcd"><?php echo $customer_value;?></span> and provided <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $worked_id;?>__worked__tcd"><?php echo $worked_value;?></span>.</p>

                                                    <p>This helped them to (with) <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> which lead to <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</p>

                                                                    <br>

                                                            </td>

                                            </tr>



                                    <?php $i++; endforeach;?>

                            <?php endif;?>
                        </table>
                    </td>
		  </tr>
                  
                </table>
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td class="border">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p>
                <strong>Tier 2 - Building Interest</strong>
                </p>
                <table border="1" width="100%" cellspacing="1" cellpadding="1">
                  <tr>
		    <th  style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Audience Segment</th>
                    <td style="padding: 5px 5px !important;">Warm Prospects</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Goal</th>
                    <td style="padding: 5px 5px !important;">To educate, to build interest, and stay in touch</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Content Focus</th>
                    <td style="padding: 5px 5px !important;">The product and company </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Number of Emails</th>
                    <td style="padding: 5px 5px !important;">5 to 10 </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Frequency</th>
                    <td style="padding: 5px 5px !important;">Daily, Bi-daily, or weekly</td>
		  </tr>
                  
                  <tr>
                      <td colspan="2" style="background: #A0A0A0;padding: 1px 5px !important; text-align: center;">Potential Campaign Content Topics</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">FAQs</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on frequently asked questions and responses to those</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Objection Responses</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on common objections and responses to those</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Credibility</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on a name drop, case study, customer success story, etc.</td>
                            </tr>   
                            <?php if (isset($credibilities)):?>

                                        <?php $i = 1; foreach ($credibilities as $credibility):?>

                                                        <?php 

                                                                $data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');



                                                                        $customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;

                                                                        $customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;



                                                                        $worked_id = isset($data['worked']['id']) ? $data['worked']['id'] : NULL;

                                                                        $worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;



                                                                        $provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;

                                                                        $provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;



                                                                        $when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;

                                                                        $when_value = isset($data['when']['value']) ? $data['when']['value']: NULL;



                                                        ?>

                                        <tr>

                                                        <td><strong>Name Drop Statement #<?php echo $i;?></strong></td>

                                                </tr>

                                                <tr><td class="border">&nbsp;</td></tr>

                                                <tr>

                                                        <td>

                                                                <p>We worked with <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $customer_id;?>__customer__tcd"><?php echo $customer_value;?></span> and provided <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $worked_id;?>__worked__tcd"><?php echo $worked_value;?></span>.</p>

                                                <p>This helped them to (with) <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> which lead to <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</p>

                                                                <br>

                                                        </td>

                                        </tr>



                                <?php $i++; endforeach;?>

                        <?php endif;?>		



                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Differentiation</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content that explains how you differ from your competition</td>
                            </tr>
                            <tr>

                            <td><strong>Differentiation Statement</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> A statement that outlines how you differ from the competition.</p>

                                            <ul>
                                                <li>Some ways that we differ from other options out there are <span class="<?php echo (!empty($interestB1[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['0']->user_data_id) ? $interestB1['0']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[0]->value) ? $interestB1[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interestB1[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['1']->user_data_id) ? $interestB1['1']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[1]->value) ? $interestB1[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interestB1[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['2']->user_data_id) ? $interestB1['2']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[2]->value) ? $interestB1[2]->value : NULL);?></span>

                                            <!--<?php if (isset($products)):?>

                                                    <?php foreach ($products as $product):?>

                                                            <?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>

                                                                    <?php if(isset($detail_bus_data)):?>

                                                                                    <?php foreach ($detail_bus_data as $detail_bus):?>

                                                                                            <span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span>,

                                                                                    <?php endforeach;?>

                                                                    <?php endif?>

                                                    <?php endforeach;?>

                                                <?php endif;?> -->

                                                </li>
                                            </ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">ROI Details</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content that outlines the ROI that you typically deliver</td>
                            </tr>
                            <tr>

                                    <td><strong>ROI Statements</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> These statements pull some details from your name drop statements to describe the ROI that you have to offer.</p>

                                            <ul>

                                                   <?php if (isset($credibilities)):?>

                                                            <?php $i = 1; foreach ($credibilities as $credibility):?>

                                                            <?php

                                                            $data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');



                                                            $customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;

                                                            $customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;



                                                            $worked_id = isset($data['worked']['id']) ? $data['worked']['id'] : NULL;

                                                            $worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;



                                                            $provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;

                                                            $provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;



                                                            $when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;

                                                            $when_value = isset($data['when']['value']) ? $data['when']['value']: NULL; 

                                                            ?>

                                                                    <li>We have helped <span class="dynamic_value edit_area" id="edit_vs__values"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to (with) 

                                                                    <span class="<?php echo (!empty($provided_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> and that led to <span class="<?php echo (!empty($when_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</li>

                                                            <?php $i++; endforeach;?>

                                              <?php endif;?>



                                            </ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Threats of Doing Nothing</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content that paints a picture of the impact of not purchasing something</td>
                            </tr>
                            <tr>

                                    <td><strong>Threats of Doing Nothing</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> A statement that outlines what could happen if the prospect does not purchase from you or do anything.</p>

                                            <ul><li>Some things to be concerned with when not doing anything in this area are <span class="<?php echo (!empty($interestB2[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['0']->user_data_id) ? $interestB2['0']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[0]->value) ? $interestB2[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interestB2[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['1']->user_data_id) ? $interestB2['1']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[1]->value) ? $interestB2[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interestB2[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['2']->user_data_id) ? $interestB2['2']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[2]->value) ? $interestB2[2]->value : NULL);?></span>

                                            <!-- <?php if (isset($products)):?>

                                                    <?php foreach ($products as $product):?>

                                                            <?php $personal_data  = $this->home->get_value_pain($product->product_id, 'PP'); ?>

                                                                            <?php if(isset($personal_data)):?>

                                                                                    <?php foreach ($personal_data as $personal):?>

                                                                                            <span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_pain__tpd"><?php echo $personal->value;?></span>,

                                                                                    <?php endforeach;?>

                                                                            <?php endif?>

                                                    <?php endforeach;?>

                                            <?php endif;?> --> 

                                            </li></ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Company Facts</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on company facts and bragging points</td>
                            </tr>
                            <tr>

                                    <td><strong>Company Facts Statement</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> A statement that outlines some facts about your company that are worth sharing with the prospect to trigger interest.</p>

                                            <ul>

                                                    <li>Other key details about us are that we <span class="<?php echo (!empty($interes[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['0']->user_data_id) ? $interes['0']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[0]->value) ? $interes[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interes[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['1']->user_data_id) ? $interes['1']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[1]->value) ? $interes[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interes[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['2']->user_data_id) ? $interes['2']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[2]->value) ? $interes[2]->value : NULL);?></span>.</li>

                                            </ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                </table>
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td class="border">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p>
                <strong>Tier 3 - Cross-selling for product #2</strong>
                </p>
                <table border="1" width="100%" cellspacing="1" cellpadding="1">
                  <tr>
		    <th  style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Audience Segment</th>
                    <td style="padding: 5px 5px !important;">Current Clients</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Goal</th>
                    <td style="padding: 5px 5px !important;">To cross-sell new products to existing and old clients</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Content Focus</th>
                    <td style="padding: 5px 5px !important;">New products that the client is not currently purchasing </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Number of Emails</th>
                    <td style="padding: 5px 5px !important;">1 to 3 </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Frequency</th>
                    <td style="padding: 5px 5px !important;">Daily, Bi-daily, or weekly</td>
		  </tr>
                  
                  <tr>
                      <td colspan="2" style="background: #A0A0A0;padding: 1px 5px !important; text-align: center;">Potential Campaign Content Topics</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">FAQs for Product #2</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on frequently asked questions and responses to those</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Objection Responses for Product #2</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on common objections and responses specific to product #2</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Credibility for Product #2</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content based on a name drop, case study, customer success story, etc. for product #2</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Differentiation for Product #2</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content that explains how product #2 differs from your competition  </td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">ROI Details for Product #2</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content that outlines the ROI that product #2 typically delivers</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Threats of Doing Nothing for Product #2</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr>
                                <td colspan="2" style="text-align: left;">Content that paints a picture of the impact of not purchasing product #2</td>
                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                </table>
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td class="border">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p>
                <strong>Tier 4 - Newsletter, keeping in touch</strong>
                </p>
                <table border="1" width="100%" cellspacing="1" cellpadding="1">
                  <tr>
		    <th  style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Audience Segment</th>
                    <td style="padding: 5px 5px !important;">New Prospects, Hot Prospects, Warm Prospects, Cold Prospects, Current Clients, Past Clients, Referral Partners (all except closed)</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Goal</th>
                    <td style="padding: 5px 5px !important;">To stay in touch and fresh in the recipient's mind</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Content Focus</th>
                    <td style="padding: 5px 5px !important;">Informational</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Number of Emails</th>
                    <td style="padding: 5px 5px !important;">6 to 12 </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Frequency</th>
                    <td style="padding: 5px 5px !important;">Monthly, bi-monthly, quarterly </td>
		  </tr>
                  
                  <tr>
                      <td colspan="2" style="background: #A0A0A0;padding: 1px 5px !important; text-align: center;">Potential Campaign Content Topics</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Industry News</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Articles and content based on industry news and events</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Best Practices/Tips</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content that provided tips and best practice advice - articles, blog posts, e-books, whitepapers, etc.</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Company News</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Information and news on the company</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Promotional</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Product promotions, discounts, special offers</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                </table>
                <br/><br/>
            </td>
        </tr>
        <tr>
            <td class="border">&nbsp;</td>
        </tr>
        <tr>
            <td>
                <p>
                <strong>Tier 5 - We want you back</strong>
                </p>
                <table border="1" width="100%" cellspacing="1" cellpadding="1">
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Audience Segment</th>
                    <td style="padding: 5px 5px !important;">Past clients</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Goal</th>
                    <td style="padding: 5px 5px !important;">To get client to come back, to educate, to build interest</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Content Focus</th>
                    <td style="padding: 5px 5px !important;">Reasons to come back - incentives, product, company</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Number of Emails</th>
                    <td style="padding: 5px 5px !important;">5 to 10 </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Frequency</th>
                    <td style="padding: 5px 5px !important;">Daily, Bi-daily, or weekly </td>
		  </tr>
                  
                  <tr>
                      <td colspan="2" style="background: #A0A0A0;padding: 1px 5px !important; text-align: center;">Potential Campaign Content Topics</td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Come back incentives</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Product promotions, discounts, special offers</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">FAQs</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content based on frequently asked questions and responses to those</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Objection Responses</th>
                    <td style="padding: 5px 5px !important;">                        
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content based on common objections and responses to those</td>
                            </tr>                        
                        </table>                    
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Credibility</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content based on a name drop, case study, customer success story, etc.</td>
                            </tr> 
                            <?php if (isset($credibilities)):?>

                                        <?php $i = 1; foreach ($credibilities as $credibility):?>

                                                        <?php 

                                                                $data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');



                                                                        $customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;

                                                                        $customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;



                                                                        $worked_id = isset($data['worked']['id']) ? $data['worked']['id'] : NULL;

                                                                        $worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;



                                                                        $provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;

                                                                        $provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;



                                                                        $when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;

                                                                        $when_value = isset($data['when']['value']) ? $data['when']['value']: NULL;



                                                        ?>

                                        <tr>

                                                        <td><strong>Name Drop Statement #<?php echo $i;?></strong></td>

                                                </tr>

                                                <tr><td class="border">&nbsp;</td></tr>

                                                <tr>

                                                        <td>

                                                                <p>We worked with <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $customer_id;?>__customer__tcd"><?php echo $customer_value;?></span> and provided <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $worked_id;?>__worked__tcd"><?php echo $worked_value;?></span>.</p>

                                                <p>This helped them to (with) <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> which lead to <span class="dynamic_value edit_area" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</p>

                                                                <br>

                                                        </td>

                                        </tr>



                                <?php $i++; endforeach;?>

                        <?php endif;?>		



                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Differentiation</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content that explains how you differ from your competition</td>
                            </tr> 
                            <tr>

                            <td><strong>Differentiation Statement</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> A statement that outlines how you differ from the competition.</p>

                                            <ul><li>Some ways that we differ from other options out there are <span class="<?php echo (!empty($interestB1[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['0']->user_data_id) ? $interestB1['0']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[0]->value) ? $interestB1[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interestB1[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['1']->user_data_id) ? $interestB1['1']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[1]->value) ? $interestB1[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interestB1[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB1['2']->user_data_id) ? $interestB1['2']->user_data_id : Null);?>__interestB1__tud"><?php echo (!empty($interestB1[2]->value) ? $interestB1[2]->value : NULL);?></span>

                                            <!-- <?php if (isset($products)):?>

                                                    <?php foreach ($products as $product):?>

                                                            <?php $detail_bus_data  = $this->home->get_value_pain($product->product_id, 'DB');?>

                                                                    <?php if(isset($detail_bus_data)):?>

                                                                                    <?php foreach ($detail_bus_data as $detail_bus):?>

                                                                                            <span class="<?php echo (!empty($detail_bus->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $detail_bus->id;?>__desc_bus_pain__tpd"><?php echo $detail_bus->value;?></span>,

                                                                                    <?php endforeach;?>

                                                                    <?php endif?>

                                                    <?php endforeach;?>

                                            <?php endif;?> -->

                                            </li></ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">ROI Details</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content that outlines the ROI that you typically deliver</td>
                            </tr> 
                            <tr>

                                    <td><strong>ROI Statements</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> These statements pull some details from your name drop statements to describe the ROI that you have to offer.</p>

                                            <ul>

                                                   <?php if (isset($credibilities)):?>

                                                            <?php $i = 1; foreach ($credibilities as $credibility):?>

                                                            <?php

                                                            $data = $this->home->get_meta_data($credibility->c_id, 'credibility', 'tcd');



                                                            $customer_id = isset($data['customer']['id']) ? $data['customer']['id']: NULL;

                                                            $customer_value = isset($data['customer']['value']) ? $data['customer']['value'] : NULL;



                                                            $worked_id = isset($data['worked']['id']) ? $data['worked']['id'] : NULL;

                                                            $worked_value = isset($data['worked']['value']) ? $data['worked']['value']: NULL;



                                                            $provided_id = isset($data['provided']['id']) ? $data['provided']['id'] : NULL;

                                                            $provided_value = isset($data['provided']['value']) ? $data['provided']['value'] : NULL;



                                                            $when_id = isset($data['when']['id']) ? $data['when']['id']: NULL;

                                                            $when_value = isset($data['when']['value']) ? $data['when']['value']: NULL; 

                                                            ?>

                                                                    <li>We have helped <span class="dynamic_value edit_area" id="edit_vs__values"><?php echo (isset($custome_fields['1']->value) ? $custome_fields['1']->value : Null);?></span> to (with) 

                                                                    <span class="<?php echo (!empty($provided_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $provided_id;?>__provided__tcd"><?php echo $provided_value;?></span> and that led to <span class="<?php echo (!empty($when_value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $credibility->c_id;?>_<?php echo $when_id;?>__when__tcd"><?php echo $when_value;?></span>.</li>

                                                            <?php $i++; endforeach;?>

                                              <?php endif;?>



                                            </ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Threats of Doing Nothing</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content that paints a picture of the impact of not purchasing something</td>
                            </tr> 
                            <tr>

                                    <td><strong>Threats of Doing Nothing</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> A statement that outlines what could happen if the prospect does not purchase from you or do anything.</p>

                                            <ul><li>Some things to be concerned with when not doing anything in this area are <span class="<?php echo (!empty($interestB2[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['0']->user_data_id) ? $interestB2['0']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[0]->value) ? $interestB2[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interestB2[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['1']->user_data_id) ? $interestB2['1']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[1]->value) ? $interestB2[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interestB2[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interestB2['2']->user_data_id) ? $interestB2['2']->user_data_id : Null);?>__interestB2__tud"><?php echo (!empty($interestB2[2]->value) ? $interestB2[2]->value : NULL);?></span>

                                            <!-- <?php if (isset($products)):?>

                                                    <?php foreach ($products as $product):?>

                                                            <?php $personal_data  = $this->home->get_value_pain($product->product_id, 'PP'); ?>

                                                                            <?php if(isset($personal_data)):?>

                                                                                    <?php foreach ($personal_data as $personal):?>

                                                                                            <span class="<?php echo (!empty($personal->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $product->product_id;?>_<?php echo $personal->id;?>__pers_pain__tpd"><?php echo $personal->value;?></span>,

                                                                                    <?php endforeach;?>

                                                                            <?php endif?>

                                                    <?php endforeach;?>

                                            <?php endif;?> --> 

                                            </li></ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                  
                  <tr>
		    <th style="width: 20%;padding: 5px 5px !important; background: #DFDDD7; text-align: left;">Company Facts</th>
                    <td style="padding: 5px 5px !important;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
                            <tr> 
                                <td colspan="2" style="text-align: left;">Content based on company facts and bragging points</td>
                            </tr>   
                            <tr>

                                    <td><strong>Company Facts Statement</strong></td>

                            </tr>

                            <tr><td class="border">&nbsp;</td></tr>

                            <tr>

                                    <td>

                                            <p><strong>Description:</strong> A statement that outlines some facts about your company that are worth sharing with the prospect to trigger interest.</p>

                                            <ul>

                                                    <li>Other key details about us are that we <span class="<?php echo (!empty($interes[0]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['0']->user_data_id) ? $interes['0']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[0]->value) ? $interes[0]->value : NULL);?></span>, <span class="<?php echo (!empty($interes[1]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['1']->user_data_id) ? $interes['1']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[1]->value) ? $interes[1]->value : NULL);?></span>, and <span class="<?php echo (!empty($interes[2]->value) ? 'dynamic_value edit_area' : '');?>" id="edit_<?php echo $user_id;?>_<?php echo (isset($interes['2']->user_data_id) ? $interes['2']->user_data_id : Null);?>__interest__tud"><?php echo (!empty($interes[2]->value) ? $interes[2]->value : NULL);?></span>.</li>

                                            </ul>

                                            <br>

                                    </td>

                            </tr>
                        </table>
                    </td>
		  </tr>
                </table>
                <br/><br/>
            </td>
        </tr>
    </table>
</div>
<?php echo $this->load->view('common/footer_outputs');?>