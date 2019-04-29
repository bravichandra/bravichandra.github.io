<?php

if($content_id == 1)
{
	?>
	<h3 class="sub-dev-head-sub2">Gatekeeper:</h3>
	<p>
        <b>If you have the contact's name:</b>
        Hello, I am trying to connect with <span class="red-area">[Target Prospect]</span>.
    </p>
    <p>
        <b>If you have the contact's title:</b>
        Hello, I am trying to connect with the <span class="red-area">[Target Title]</span>.
    </p>
    <p>
        <b>If you don't have the name or title:</b>
        Hello, I am trying to connect with the person responsible for <span class="red-area">[Target Area]</span>. Can you point me in the right direction?
    </p>
	<h3 class="sub-dev-head-sub2">Prospect:</h3>
	<p>Hello  <span class="red-area">[Contact's Name]</span>, this is  <span><?php echo $aMember['yname'] ?></span> from  <span><?php echo  $company_info->company_name ; ?></span>, have I caught you in the middle of anything?</p>
	<?php
}
else if ($content_id == 2)
{
	?>
	<h3 class="sub-dev-head-sub2">Value Statement</h3>
	<p>Great. The purpose of my call is that we help <span class="dynamic_value edit_area_old" id=""><?php 
				
				if($campaign_info->campaign_target == '1'){	
						echo $campaign_info->individual;
					}else{
						echo $campaign_info->organization;
				}
			?></span> to:
	<ul class="sub-dev-desc-ul">
		<?php 
		foreach($campaign_output_tech_val as $cur_tech_summary) { ?>
		<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $cur_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($cur_tech_summary->value) ? $cur_tech_summary->value : NULL);?></span>
		</li>
		<?php 
		}
		?>
		<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $campaign_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : NULL);?></span>.
		</li>
	</ul>
	<br/>
	<h3 class="sub-dev-head-sub2">(Optional) Disqualify Statement</h3>
    <span class="red-area">(Choose one of the following)</span>
    <ul>
    	<li>I actually don't know if you need what our services provide so I just had a question or two.</li>
        <li>I actually don't know if you are a good fit for what we provide so I just had a question or two.</li>
        <li>I don't know if you are the right person to speak with but I have just a couple of questions.</li>
    </ul>
	<p>		
	<span class="red-area">(pause or ask for agreement or availability)</span>  If you have a couple of minutes?
	</p>
	<?php
}
else if ($content_id == 3)
{
	?>
	<h3 class="sub-dev-head-sub1">Common Pain Problems</h3>
	<p>Purpose of my call is that we talk with other <span class="dynamic_value "><?php 
			if($campaign_info->campaign_target == '1'){	
					echo $campaign_info->individual;
				}else{
					echo $campaign_info->organization;
			}
		?></span>, and they often express challenges with <span class="red-area">(or concerns around)</span> :</p>
		<p><span class="red-area">(Share upto three of below)</span></p>
		<?php if (isset($campaign_output_tech_pain)):?>
			<ul>
				<?php foreach ($campaign_output_tech_pain as $single_tech_pain):?>
					<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
				<?php endforeach;?>
			</ul>
		<?php endif;?> 
		<p>Can you relate to any of those?</p>
		<p><span class="red-area">-or-</span></p>
		<p>Which one of those are you most concerned with?</p>
	<h3 class="sub-dev-head-sub2">(Optional) Disqualify Statement</h3>
	<p>I am not sure if you are concerned with any of those and that is why I was calling with a couple of questions. </p>
	<p><span class="red-area">(pause or ask for agreement or availability)</span>  If you have a couple of minutes?</p>
	<?php
}
else if ($content_id == 4)
{
	?>
	<h3 class="sub-dev-head-sub1">Name Drop Example</h3>
    <p>Purpose for my call is that:</p>
    <ul>
      <li> We worked with <?php echo $active_name_drop_exp['worked']->credibility_name ?> and provided <?php echo  $active_name_drop_exp['worked']->value ?>. </li> 
      <li> This helped them to <?php echo  $active_name_drop_exp['provided']->value ?>, which led to <?php echo  $active_name_drop_exp['when']->value ?>. </li>
    </ul>
    <h3 class="sub-dev-head-sub2">(Optional) Disqualify Statement</h3>
    <p>
		<?php /*?>I am not sure if you are interested in those types of improvements and that is why I was calling with a couple of questions.<?php */?>
		I don't know if you we can help you in the same way or not and that is why I was calling with a couple of questions.
	</p>
    <p><span class="red-area">(pause or ask for agreement or availability)</span>  If you have a couple of minutes?</p>
	<?php
}
else if ($content_id == 5)
{
	?>
	<?php /*?><p>If I could ask you real quick:</p>
	<p><span class="red-area">(Ask 3 to 5 of the questions below)</span></p><?php */?>
	<?php /*?><?php if (isset($campaign_output_tech_qualify)):?>
		<ul>
			<?php foreach ($campaign_output_tech_qualify as $single_tech_qualify):?>
				<?php // print_r($single_tech_value) ?>
				<li><span class="<?php echo 'dynamic_value edit_area'; ?>" id="tqd_<?php echo $single_tech_qualify->tech_q_id ?>_<?php echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_qualify->value;?></span></li>
			<?php endforeach;?>
		</ul>
	<?php endif;?><?php */?><div><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div> 
	<br/>
	<?php
}
else if ($content_id == 6)
{
	?>
	<?php /*?><p>Oh, OK. Well, as we talk with other <span class="dynamic_value "><?php 
		if($campaign_info->campaign_target == '1'){	
				echo $campaign_info->individual;
			}else{
				echo $campaign_info->organization;
		}
	?></span>, we have noticed that they often express challenges with <span class="red-area">(or concerns around)</span> :</p><?php */?><br/>
	
			<?php if (isset($campaign_output_tech_pain)):?>
				<ul>
					<?php foreach ($campaign_output_tech_pain as $single_tech_pain):?>
						<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
					<?php endforeach;?>
				</ul>
			<?php endif;?> 
	<br/>
	<?php /*?><p>Can you relate to any of those?</p>
	<p><span class="red-area">-or-</span></p>
	<p>Which one of those are you most concerned with?</p><?php */?>
	<?php
}
else if ($content_id == 7)
{
	?>
	<?php /*?><p>Well, based on what you shared, it might productive for us to talk in more detail.  The reason why is<br/><span class="red-area">(Share any of the below as appropriate as you try to trigger interest)</span></p><?php */?>
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
	<strong class="sub-dev-head-sub2">Connect Pain with Value:</strong>
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
			</span> to <?php echo $active_name_drop_exp['provided']->value   ?> and that led to <span class="<?php echo 'dynamic_value edit_area_old' ?>" id=""><?php echo $active_name_drop_exp['when']->value   ?></span>.
		</li>
	</ul>
	<br/>
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
	
	<strong class="sub-dev-head-sub2">Company Facts:</strong>
	<p>Other key details about us are that we: </p>
	<ul style="list-style:disk;">
		<li><?php echo ucfirst($company_meta['interest'][0]) ?>.</li>
		<li><?php echo ucfirst($company_meta['interest'][1]) ?>.</li>
		<li><?php echo ucfirst($company_meta['interest'][2]) ?>.</li>
	</ul>
	<?php
}
else if ($content_id == 8)
{
	?>
	<p>Well, based on what you shared, it might productive for us to talk in more detail.<br/><br/>
But, since I have called you out of the blue, I do not want to take any more of your time to talk right now.</p>
	<br/>		
	<strong class="sub-dev-head-sub2">Trial Close: </strong>
	<ul>
		<li> What do you think about what we have discussed so far? </li>
		<li> Is this something that you are interested in discussing in more detail? </li>
	</ul>
	<br/>
	<strong class="sub-dev-head-sub2">Soft Close:</strong>
	<ul>
		<li> A great next step would be for us to schedule <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close1->value ) ? $sale_process_close1->value: '');?></span> where we can <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close2->value) ? $sale_process_close2->value : '');?></span>.</li>
		<li> Is that something that you would like to put on the calendar? </li>
	</ul>
	<br/>
	<strong class="sub-dev-head-sub2">Hard Close:</strong>
	<ul>
		<li> How does your calendar look next Tuesday or Thursday morning for us to schedule <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close1->value ) ? $sale_process_close1->value: '');?></span> where <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close2->value) ? $sale_process_close2->value : '');?></span>.
		</li>
	</ul>
	</p>
	<?php
}
?>