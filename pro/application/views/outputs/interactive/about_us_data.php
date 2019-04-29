<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
<div class="scroll-bar_sf">
<!-- Start -->
<p>It might productive for us to talk in more detail.  The reason why is<br/><span class="red-area">(Share any of the below as appropriate as you try to trigger interest)</span></p>
<strong class="sub-dev-head-sub2">Product Details:</strong>
<ul>
    <li>As I said, I am with <span><?php  echo $company_info->company_name; ?></span> and we provide <?php echo $P_Q1->value; ?></li>
    
    <li>Our <span class="dynamic_value edit_area_old" id=""><?php echo $P_Q1->value; ?></span>  <?php echo $product_desc->value; ?></li>
</ul>
<br/>
<strong class="sub-dev-head-sub2">Benefits:</strong>
<?php
  $findproduct = $this->campaign->getProduct($campaign_info->product_id);
?>
<p>Our <?php echo $findproduct->product_name;?> can help you to:</p>
<?php if($campaign_output_tech_val_asnwers){?>
<ul>
	<?php foreach($campaign_output_tech_val_asnwers as $valans) echo '<li>'.ucfirst($valans->value).'</li>';?>
</ul>
<?php }?>
<br/>
<?php /*?><strong class="sub-dev-head-sub2">Connect Pain with Value:</strong>
    <ul>
        <li>We help <?php 
                if($campaign_info->campaign_target == '1'){	
                        echo $campaign_info->individual;
                    }else{
                        echo $campaign_info->organization;
                }
            ?> to deal with <?php echo $campaign_output_tech_pain[0]->value ?> by helping to
            <?php echo $campaign_output_tech_val[0]->value ?>and this can typically lead to <?php echo $campaign_output_biz_val[0]->value ?>
        </li>
    </ul>
<br/>
<strong class="sub-dev-head-sub2">ROI Statements:</strong>
    <ul>
    
        <li>We have helped  
            <span class="<?php echo 'dynamic_value edit_area_old' ?>" id="">
                <?php 
                    if($campaign_info->campaign_target == '1'){	
                            echo $campaign_info->individual;
                        }else{
                            echo $campaign_info->organization;
                    }
                ?>
            </span> to <?php echo $active_name_drop_exp['provided']->value   ?> and that led to <span class="<?php echo 'dynamic_value edit_area_old' ?>" id=""><?php echo $active_name_drop_exp['when']->value   ?></span>.</li>
            


    </ul>
<br/><?php */?>
<strong class="sub-dev-head-sub2">Differentiation:</strong>
    <p>Some ways that we differ from other options out there are:</p>
    <ul style="list-style:disk;">
        <li><span class="<?php echo 'dynamic_value edit_area_old'; ?>" id=""><?php echo (!empty($diff1->value) ? ucfirst($diff1->value) : NULL);?></span>.</li>
        <li><span class="<?php echo 'dynamic_value edit_area_old';?>" id=""><?php echo (!empty($diff2->value) ? ucfirst($diff2->value) : NULL);?></span>.</li>
        <li><span class="<?php echo  'dynamic_value edit_area'; ?>" id=""><?php echo (!empty($diff3->value) ? ucfirst($diff3->value) : NULL);?></span>.</li>
    </ul>
<br>
<strong class="sub-dev-head-sub2">Name Drop: </strong>
<ul>
  <li> We worked with <?php echo $active_name_drop_exp['worked']->credibility_name ?> and provided <?php echo  $active_name_drop_exp['worked']->value ?>. </li> 
  <li> This helped them to <?php echo  $active_name_drop_exp['provided']->value ?>, which led to <?php echo  $active_name_drop_exp['when']->value ?>. </li>
</ul>
<br/>
<strong class="sub-dev-head-sub2">Threats of Doing Nothing:</strong>
<p>Some things to be concerned with when not doing anything in this area are: </p>
<ul>
    <?php if (isset($campaign_output_tech_pain)):?>
                <?php foreach ($campaign_output_tech_pain as $single_tech_pain):?>
                    <li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
                <?php endforeach;?>
    <?php endif;?>
</ul>
<br />
<strong class="sub-dev-head-sub2">Company Facts:</strong>
	<p>Other key details about us are that we: </p>
		<ul style="list-style:disk;">
			<li><?php echo ucfirst($company_meta['interest'][0]) ?>.</li>
			<li><?php echo ucfirst($company_meta['interest'][1]) ?>.</li>
			<li><?php echo ucfirst($company_meta['interest'][2]) ?>.</li>
		</ul>
<!-- End -->
</div>