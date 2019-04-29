<?php	
    if($partid == $lastid+1)
	{
		$temp = end(explode('/',current_url()));
		$busy_url = str_replace($temp,'busy-right-now',current_url());
		$regards_url = str_replace($temp,'regards-to',current_url());
		$nointerest_url = str_replace($temp,'no-interest',current_url());
		$notlookingurl = str_replace($temp,'not-looking-todo',current_url());
		$notmakingchangesurl = str_replace($temp,'not-making-changes',current_url());
		$cantchangeurl = str_replace($temp,'cant-change',current_url());
		$nobudgeturl = str_replace($temp,'no-budget',current_url());
		$information_url = str_replace($temp,'information',current_url());
		$usesomeone_url = str_replace($temp,'use-someone',current_url());
		$notrightperson_url = str_replace($temp,'notright-person',current_url());
		$nologerhere_url = str_replace($temp,'nolonger-here',current_url());
		$callbackafter_url = str_replace($temp,'callback-after',current_url());
		$issalescall_url = str_replace($temp,'is-salescall',current_url());
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <ul class="sub-dev-head-sub2 objection-responses-dev">
        	<li><a href="<?php echo $busy_url;?>">I am busy right now.</a></li>
            <li><a href="<?php echo $issalescall_url;?>">Is this a sales call?</a></li>
            <li><a href="<?php echo $nologerhere_url;?>">They are no longer here.</a></li>
            <li><a href="<?php echo $notrightperson_url;?>">Iam not the right person.</a></li>
            <li><a href="<?php echo $regards_url;?>">What is this in regards to?</a></li>
            <li><a href="<?php echo $nointerest_url;?>">I am not interested.</a></li>
            <li><a href="<?php echo $information_url;?>">Just send me some information.</a></li>
            <li><a href="<?php echo $notlookingurl;?>">We are not looking to do anything/ make any changes right now.</a></li>
            <li><a href="<?php echo $notmakingchangesurl;?>">We are not making any changes right now.</a></li>
            <li><a href="<?php echo $cantchangeurl;?>">I can't change anything right now. </a></li>
            <li><a href="<?php echo $nobudgeturl;?>">We do not have any budget / money right now.</a></li>
            <li><a href="<?php echo $usesomeone_url;?>">We already use someone for that.</a></li>
            <li><a href="<?php echo $callbackafter_url;?>">Please call back in ___ weeks/ months.</a></li>
            
		</ul>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
	else if($partid == $lastid+2)
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <p>Well, the purpose for my call is that: <span class="red-area">(Redirect to your value statement by answering with one of below) </span></p>
    <ul>
    	<li>We help 
				<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
			to <span class="" id="">
				<?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : Null);?>
				
			</span></li>
		<li>We help 
				<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
			to <span class="" id="">
				<?php echo (isset($campaign_biz_summary->value) ? $campaign_biz_summary->value : Null);?>
				
			</span>
		</li>
		<li>We help 
				<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
			to <span class="" id="">
				<?php echo (isset($campaign_per_summary->value) ? $campaign_per_summary->value : Null);?>
				
			</span>
		</li>
		<li>We provide <?php echo $P_Q1->value; ?>.</li>
    </ul>
	<br>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'pre-qualifying-questions',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+3)
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <p>Oh, OK. Do you know who took their place?</p>
		<p><span class="red-area">OR</span></p>
        <p>Oh, OK. I have them down as the <span class="red-area">(insert title)</span>. Do you know who took that role?</p>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
	else if($partid == $lastid+4)
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
		<p>Oh, OK. Do you know who the right person that I should connect with is?</p>
		<p><span class="red-area">OR</span></p>
		<p>Oh, OK. Can you point me in the right direction of who I should try to connect with?</p>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
	else if($partid == $lastid+5)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <p>Oh, OK. I can be very brief or I can call you back at another time.</p>
		<p><span class="red-area">OR</span></p>
		<p>Oh, OK. When is the best time for me to call you back?</p>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+6)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <p>Well, the purpose for my call is that: <span class="red-area">(Redirect to your value statement by answering with one of below) </span></p>
    <ul>
    	<li>We help 
				<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
			to <span class="" id="">
				<?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : Null);?>
				
			</span></li>
		<li>We help 
				<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
			to <span class="" id="">
				<?php echo (isset($campaign_biz_summary->value) ? $campaign_biz_summary->value : Null);?>
				
			</span>
		</li>
		<li>We help 
				<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?>
			to <span class="" id="">
				<?php echo (isset($campaign_per_summary->value) ? $campaign_per_summary->value : Null);?>
				
			</span>
		</li>
		<li>We provide <?php echo $P_Q1->value; ?>.</li>
    </ul>
	<br>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'pre-qualifying-questions',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+7)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <div class="section_sf" data-sec="content_sec1"><h3>Redirect to pre-qualifying questions</h3><label class="arrows">+</label></div>
        <div id="content_sec1" class="content_sec">
        	<p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			<br />
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul>
			<br />
			<strong class="sub-dev-head-sub2">Business Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_biz_qualify)):?>
					<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
			</ul>
			<br/>
			<strong class="sub-dev-head-sub2">Personal Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_per_qualify)):?>
					<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>	
			</ul>
		</div>
        <div class="section_sf" data-sec="content_sec2"><h3>Redirect to examples of common problems</h3><label class="arrows">+</label></div>
        <div id="content_sec2" class="content_sec">
				<p>
					I understand. Sometimes when we talk with other 
						<?php 
							echo $campaign_info->individual;	
						?>
					, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				<strong class="sub-dev-head-sub2">Technical Pain:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business pain:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_pain)):?>
						<?php foreach($campaign_output_biz_pain as $singlepain) {?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal pain:</strong>
				<ul>
					<?php if (isset($campaign_output_per_pain)):?>
						<?php foreach($campaign_output_per_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br />
          	</div>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+8)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <div class="section_sf" data-sec="content_sec1"><h3>Redirect to pre-qualifying questions</h3><label class="arrows">+</label></div>
        <div id="content_sec1" class="content_sec">
        	<p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			<br />
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul>
			<br />
			<strong class="sub-dev-head-sub2">Business Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_biz_qualify)):?>
					<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
			</ul>
			<br/>
			<strong class="sub-dev-head-sub2">Personal Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_per_qualify)):?>
					<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>	
			</ul>
		</div>
        <div class="section_sf" data-sec="content_sec2"><h3>Redirect to examples of common problems</h3><label class="arrows">+</label></div>
        <div id="content_sec2" class="content_sec">
				<p>
					I understand. Sometimes when we talk with other 
						<?php 
							echo $campaign_info->individual;	
						?>
					, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				<strong class="sub-dev-head-sub2">Technical Pain:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business pain:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_pain)):?>
						<?php foreach($campaign_output_biz_pain as $singlepain) {?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal pain:</strong>
				<ul>
					<?php if (isset($campaign_output_per_pain)):?>
						<?php foreach($campaign_output_per_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br />
          	</div>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+9)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <div class="section_sf" data-sec="content_sec1"><h3>Redirect to pre-qualifying questions</h3><label class="arrows">+</label></div>
        <div id="content_sec1" class="content_sec">
        	<p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			<br />
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul>
			<br />
			<strong class="sub-dev-head-sub2">Business Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_biz_qualify)):?>
					<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
			</ul>
			<br/>
			<strong class="sub-dev-head-sub2">Personal Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_per_qualify)):?>
					<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>	
			</ul>
		</div>
        <div class="section_sf" data-sec="content_sec2"><h3>Redirect to examples of common problems</h3><label class="arrows">+</label></div>
        <div id="content_sec2" class="content_sec">
				<p>
					I understand. Sometimes when we talk with other 
						<?php 
							echo $campaign_info->individual;	
						?>
					, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				<strong class="sub-dev-head-sub2">Technical Pain:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business pain:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_pain)):?>
						<?php foreach($campaign_output_biz_pain as $singlepain) {?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal pain:</strong>
				<ul>
					<?php if (isset($campaign_output_per_pain)):?>
						<?php foreach($campaign_output_per_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br />
          	</div>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+10)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <div class="section_sf" data-sec="content_sec1"><h3>Redirect to pre-qualifying questions</h3><label class="arrows">+</label></div>
        <div id="content_sec1" class="content_sec">
        	<p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			<br />
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul>
			<br />
			<strong class="sub-dev-head-sub2">Business Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_biz_qualify)):?>
					<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
			</ul>
			<br/>
			<strong class="sub-dev-head-sub2">Personal Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_per_qualify)):?>
					<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>	
			</ul>
		</div>
        <div class="section_sf" data-sec="content_sec2"><h3>Redirect to examples of common problems</h3><label class="arrows">+</label></div>
        <div id="content_sec2" class="content_sec">
				<p>
					I understand. Sometimes when we talk with other 
						<?php 
							echo $campaign_info->individual;	
						?>
					, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				<strong class="sub-dev-head-sub2">Technical Pain:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business pain:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_pain)):?>
						<?php foreach($campaign_output_biz_pain as $singlepain) {?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal pain:</strong>
				<ul>
					<?php if (isset($campaign_output_per_pain)):?>
						<?php foreach($campaign_output_per_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br />
          	</div>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+11)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <div class="section_sf" data-sec="content_sec1"><h3>Redirect to pre-qualifying questions</h3><label class="arrows">+</label></div>
        <div id="content_sec1" class="content_sec">
        	<p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			<br />
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul>
			<br />
			<strong class="sub-dev-head-sub2">Business Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_biz_qualify)):?>
					<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
			</ul>
			<br/>
			<strong class="sub-dev-head-sub2">Personal Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_per_qualify)):?>
					<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>	
			</ul>
		</div>
        <div class="section_sf" data-sec="content_sec2"><h3>Redirect to examples of common problems</h3><label class="arrows">+</label></div>
        <div id="content_sec2" class="content_sec">
				<p>
					I understand. Sometimes when we talk with other 
						<?php 
							echo $campaign_info->individual;	
						?>
					, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				<strong class="sub-dev-head-sub2">Technical Pain:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business pain:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_pain)):?>
						<?php foreach($campaign_output_biz_pain as $singlepain) {?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal pain:</strong>
				<ul>
					<?php if (isset($campaign_output_per_pain)):?>
						<?php foreach($campaign_output_per_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br />
          	</div>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+12)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <p>I understand. So that I know exactly what to send you, do you mind if I ask:</p>
			<p class="red-area">(Redirect to any of the common pain points)</p>
			<br />   
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul>
			<br />
			<strong class="sub-dev-head-sub2">Business Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_biz_qualify)):?>
					<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
			</ul>
			<br/>
			<strong class="sub-dev-head-sub2">Personal Questions:</strong>
			<ul>
				<?php if (isset($campaign_output_per_qualify)):?>
					<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>	
			</ul>
			<br />
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+13)
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <div class="section_sf" data-sec="content_sec1"><h3>Direct Response</h3><label class="arrows">+</label></div>
        <div id="content_sec1" class="content_sec">
        <p>Oh, I see. <span class="red-area">(Ask any or all of the following questions) </span></p>
				<ul>
					<li>How long have you been using them / with them / purchasing from them?</li>
					<li>How is everything going?</li>
					<li>What are some of the things you like about what they provide?</li>
					<li>What are some things that you think could be better?</li>
					<li>If you could change one thing about their product/service, what would it be?</li>
					<li>When was the last time you considered other options in this area?</li>
				</ul>
				<br />
			<?php /*?><div class="border" style="border-bottom: 1px solid #000;" ></div><?php */?>
        </div>
        <div class="section_sf" data-sec="content_sec2"><h3>Redirect to pre-qualifying questions</h3><label class="arrows">+</label></div>
        <div id="content_sec2" class="content_sec">
			<p>I understand.</p>
            <p> <span class="red-area">(OPTIONAL )</span> And I want you to know that we are not trying to sell anything at this point. </p>
			<p> <span class="red-area">(OPTIONAL)</span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p> <span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<br />
			
			<strong class="sub-dev-head-sub2">Technical Questions:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_qualify)):?>
						<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
						
							<li> <?php echo $singlequalify->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business Questions:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_qualify)):?>
						<?php foreach($campaign_output_biz_qualify as $singlequalify) {?>
						
							<li> <?php echo $singlequalify->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal Questions:</strong>
				<ul>
					<?php if (isset($campaign_output_per_qualify)):?>
						<?php foreach($campaign_output_per_qualify as $singlequalify) { ?>
						
							<li> <?php echo $singlequalify->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<br /> 
				<?php /*?><div class="border" style="border-bottom: 1px solid #000;" ></div><?php */?>
              </div>
        <div class="section_sf" data-sec="content_sec3"><h3>Redirect to examples of common problems</h3><label class="arrows">+</label></div>
        <div id="content_sec3" class="content_sec">
				<p>
					I understand. Sometimes when we talk with other 
						<?php 
							echo $campaign_info->individual;	
						?>
					, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				<strong class="sub-dev-head-sub2">Technical Pain:</strong>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Business pain:</strong>
				<ul>
					<?php if (isset($campaign_output_biz_pain)):?>
						<?php foreach($campaign_output_biz_pain as $singlepain) {?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
				</ul>
				<br />
				<strong class="sub-dev-head-sub2">Personal pain:</strong>
				<ul>
					<?php if (isset($campaign_output_per_pain)):?>
						<?php foreach($campaign_output_per_pain as $singlepain) { ?>
						
							<li> <?php echo $singlepain->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>	
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br />
          	</div>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
     <?php
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+14)
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <br/>
        <p>Sure, I definitely can. Just so I can update my notes correctly, is there something that will make that a better time for us to get back together?</p>
        <p><span class="red-area">OR</span></p>
        <p>Sure, I definitely can. But I want you to know, I am not reaching out to you to try to sign up or sell you anything. More so, we are just looking to open the dialogue and have a conversation.</p> 
        <p>We would like to learn a little more about you and possibly share some information about us if it makes sense. That way, when you are ready to look at doing something, you can know who we are and how we can help.</p>
        <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-obj-<?php echo $partid;?>"></textarea></p>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'objection-responses',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
		
	}
	?>
<?php 
			$temp = end(explode('/',current_url()));
			$stop_url = str_replace('/'.$temp,'/objection-responses',current_url());
			$question_step = str_replace('/'.$temp,'/pre-qualifying-questions',current_url());
			$problems_step = str_replace('/'.$temp,'/common-problems',current_url());
			
			//For Titles
			foreach($parts as $titlepart)
			{
				if($titlepart['name'] == 'objection-responses') $objection_title = $titlepart['title'];
				if($titlepart['name'] == 'common-problems') $common_prob_title = $titlepart['title'];
				if($titlepart['name'] == 'about-us') $about_us_title1 = $titlepart['title'];
				if($titlepart['name'] == 'attention-grabbing') $about_us_title2 = $titlepart['title'];
				if($titlepart['name'] == 'close') $close_title = $titlepart['title'];
				$ftemp = end(explode('/',$front_step));
				if($titlepart['name'] == $ftemp) $objection_front_title = $titlepart['title'];
				
				
				if($partid == 1) 
				{
					$backbutton_title = $objection_title;
					$frontbutton_title =  $parts[$partid+1]['title'];
				}
				else if($partid < $lastid)
				{
					$backbutton_title = $parts[$partid-1]['title'];
					$frontbutton_title =  $parts[$partid+1]['title'];
				}
				else if($partid == $lastid)
				{
					$backbutton_title = $parts[$partid-1]['title'];
					$frontbutton_title =  'View Full Script';
				}
				else if($partid > $lastid)
				{
					$backbutton_title = $objection_title;
					$frontbutton_title =  $objection_front_title;
				}
				
			}
			
			
			$aboutus_step = str_replace('/'.$temp,'/about-us',current_url());
			$is_about_exists = false;
			foreach($parts as $dpart)
			{
				if($dpart['name'] == 'about-us') { $is_about_exists = true; break;}
			}
			if($is_about_exists) {$aboutus_step = str_replace('/'.$temp,'/about-us',current_url()); $about_us_title=$about_us_title1; }
			else { $aboutus_step = str_replace('/'.$temp,'/attention-grabbing',current_url()); $about_us_title=$about_us_title2; }
			if($temp!='objection-responses' && $partid)
			{
	?>
    <div class="sub-navigation">
        <div class="a"><a class="navas" title="<?php echo $objection_title; ?>" href="<?php echo $stop_url;?>" onClick="return saveStepData('<?php echo $temp;?>');"></a></div>
    	<div class="a"><a class="navab" title="<?php echo $backbutton_title;?>" href="<?php echo $back_step;?>" onClick="return saveStepData('<?php echo $temp;?>');"></a></div>
        <div class="a"><a class="navap" title="<?php echo $common_prob_title; ?>" href="<?php echo $problems_step;?>" onClick="return saveStepData('<?php echo $temp;?>');"></a></div>
        <div class="a"><a class="navaa" title="<?php echo $about_us_title; ?>" href="<?php echo $aboutus_step;?>" onClick="return saveStepData('<?php echo $temp;?>');"></a></div>
        <div class="a"><a class="navaf" title="<?php echo $frontbutton_title;?>" href="<?php echo $front_step;?>" onClick="return saveStepData('<?php echo $temp;?>');"></a></div>
        <div class="a"><a class="navas2" title="<?php echo $close_title; ?>" href="<?php echo $fav_step;?>" onClick="return saveStepData('<?php echo $temp;?>');"></a></div>
    </div>
    <div class="sub-nav-sf-wr">
    <div class="sub-nav-sf">
        	<a style="float:left;" class="buttonL bBlue" href="<?php echo str_replace($temp,'',current_url());?>">View Full Script</a>
            <a style="float:right;" class="buttonL bGreen" href="#" onClick="return downloadData('<?php echo $temp;?>')">Get Notes</a>
    </div>
    </div>
     <?php 
			} 
		?>
