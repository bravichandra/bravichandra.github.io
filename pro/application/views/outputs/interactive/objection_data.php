<?php	
	//Get default objection response
	$campgn_data = array();
	$campgn_data['campaign_output_tech_val']=$campaign_output_tech_val;
	$campgn_data['campaign_info']=$campaign_info;
	$campgn_data['campaign_tech_summary']=$campaign_tech_summary;
	$campgn_data['campaign_output_tech_qualify']=$campaign_output_tech_qualify;
	$campgn_data['campaign_output_tech_pain']=$campaign_output_tech_pain;
	$campgn_data['campaign_output_qualify']=$campaign_output_qualify;//By Dev@4489
	if(isset($getresp)) {		
		$gresp = get_is_response($objname,$rsp,$campgn_data);
		echo $gresp;
		return;
	}
	
	if($partid) $resp=$parts[$partid]['resp'];
	//if default objections saved by user
	//if($partid && ($obcstart<=$partid && $partid<=$obcend) && $parts[$partid] && isset($parts[$partid]['default'])) {
	if($partid && (($partid >= $lastid+1 && $partid <= $lastid+4) || ($obcstart<=$partid && $partid<=$obcend)) && $parts[$partid] && isset($parts[$partid]['default'])){
		$resp=$parts[$partid]['resp'];
	?>
    	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
        <?php if($resp['respc2'] || $resp['respc3']){?>
		<div class="section_tabs big">
        <div class="section_sf scnd active" data-sec="content_sec1"><h3 style="margin-top: 12px;"><?php echo ($resp['resp1']?$resp['resp1']:"Response 1");?></h3></div>
		<div class="section_sf scnd" data-sec="content_sec2"><h3><?php echo ($resp['resp2']?$resp['resp2']:"Response 2");?></h3></div>
		<?php if($resp['respc3']){?>
        <div class="section_sf scnd" data-sec="content_sec3"><h3><?php echo ($resp['resp3']?$resp['resp3']:"Response 3");?></h3></div>
		<?php }?>
        </div>
        <?php }?>
        <?php if($resp['respc2'] || $resp['respc3']){?>
        <div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo $resp['respc1'];?></div>
        <?php if($resp['respc2']){?>
        <div id="content_sec2" class="content_sec"><?php echo $resp['respc2'];?></div>
        <?php }?>
        <?php if($resp['respc3']){?>
        <div id="content_sec3" class="content_sec"><?php echo $resp['respc3'];?></div>
        <?php }?>
		</div>
        <?php }else echo $resp['respc1'];?>		
		</div>
    <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		if($partid == $lastid+5)
			$front_step = str_replace($temp,'value-statement-intro',current_url());
		else if($partid == $lastid+6)	
			$front_step = str_replace($temp,'pre-qualifying-questions',current_url());
		else if($partid == $lastid+7)	
			$front_step = str_replace($temp,'pre-qualifying-questions',current_url());
		else if($partid == $lastid+8)	
			$front_step = str_replace($temp,'value-statement-intro',current_url());
		else if($partid == $lastid+9)
			$front_step = str_replace($temp,'value-statement-intro',current_url());	
		else $front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	} 
	else if($partid == $lastid+7)//Is this a sales call?
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'pre-qualifying-questions',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+8)//They are no longer here
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
	else if($partid == $lastid+9)//I am not the right person
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
	else if($partid == $lastid+5)//I am busy right now.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
     <?php
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+6)//What is this in regards to?
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'pre-qualifying-questions',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+10)//I am not interested.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
		<div class="section_tabs">
        <div class="section_sf frst active" data-sec="content_sec1"><h3><?php echo $resp['resp1'];?></h3></div>
        <div class="section_sf" data-sec="content_sec2"><h3><?php echo $resp['resp2'];?></h3></div>
		</div>
		<div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
		<div id="content_sec2" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r2",$campgn_data);?></div>
			</div>
		</div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+12)//We are not looking to do anything/ make any changes right now.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
		<div class="section_tabs">
        <div class="section_sf frst active" data-sec="content_sec1"><h3><?php echo $resp['resp1'];?></h3></div>
		<div class="section_sf" data-sec="content_sec2"><h3><?php echo $resp['resp2'];?></h3></div>
		</div>
		<div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>        
        <div id="content_sec2" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r2",$campgn_data);?></div>
			</div>
		</div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+13)//We are not making any changes right now.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
		<div class="section_tabs">
        <div class="section_sf frst active" data-sec="content_sec1"><h3><?php echo $resp['resp1'];?></h3></div>
		<div class="section_sf" data-sec="content_sec2"><h3><?php echo $resp['resp2'];?></h3></div>
		</div>
		<div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>        
        <div id="content_sec2" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r2",$campgn_data);?></div>
		</div>
		</div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+14)//I can't change anything right now.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
		<div class="section_tabs">
        <div class="section_sf frst active" data-sec="content_sec1"><h3><?php echo $resp['resp1'];?></h3></div>
		<div class="section_sf" data-sec="content_sec2"><h3><?php echo $resp['resp2'];?></h3></div>
		</div>
		<div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
        
        <div id="content_sec2" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r2",$campgn_data);?></div>
			</div>
		</div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+15)//We do not have any budget / money right now.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
		<div class="section_tabs">
        <div class="section_sf frst active" data-sec="content_sec1"><h3><?php echo $resp['resp1'];?></h3></div>
		<div class="section_sf" data-sec="content_sec2"><h3><?php echo $resp['resp2'];?></h3></div>
		</div>
		<div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
        
        <div id="content_sec2" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r2",$campgn_data);?></div>
		</div>
		</div>
     <?php
	 	
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $lastid+11)//Just send me some information.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
     <?php
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+16)//We already use someone for that.
	{
	 ?>
     	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
		<div class="section_tabs big">
        <div class="section_sf scnd active" data-sec="content_sec1"><h3 style="margin-top: 12px;"><?php echo $resp['resp1'];?></h3></div>
		<div class="section_sf scnd" data-sec="content_sec2"><h3><?php echo $resp['resp2'];?></h3></div>
		<div class="section_sf scnd" data-sec="content_sec3"><h3><?php echo $resp['resp3'];?></h3></div>
		</div>
		<div class="tab_content">
        <div id="content_sec1" class="content_sec active"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
        
        <div id="content_sec2" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r2",$campgn_data);?></div>
        
        <div id="content_sec3" class="content_sec"><?php echo get_is_response($parts[$partid]['name'],"r3",$campgn_data);?></div>
		</div>
		</div>
     <?php
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+17)//Please call back in ___ weeks/ months
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf"><?php echo get_is_response($parts[$partid]['name'],"r1",$campgn_data);?></div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
		
	}
	else if($partid == $lastid+1)//Value Focus
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
        <p>Hello <span class="red-area">[Prospect First Name]</span>
		   this is <?php echo $aMember['yname']; ?> from <?php echo $company_info->company_name; ?>.
		</p>
		<p>Purpose for my call is that we help  
			<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?> to 
		</p>
		<p> <span class="red-area">(Pick three from below) </span>
			<ul>
			<?php if(isset($campaign_output_tech_val)){
				foreach($campaign_output_tech_val as $comp){
				?>
					<li>
						<?php echo ucfirst($comp->value) ?>
					</li>
				<?php 
				}
			}
			?>
		</ul>
		</p>
		<p><span class="red-area">(Optional disqualify statement) </span>I actually do not know if you are a fit for what we do and that is why I was calling you with a question or two.</p>
		<p>
			I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.
		</p>
		<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?>, <?php echo $aMember['yphone']; ?>.</p>
		<p>Thank you and I look forward to talking with you soon.</p>
		
        
		</div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'intro',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+2)//Pain Focus
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
        <p>Hello <span class="red-area">[Prospect First Name]</span> this is <?php echo $aMember['yname']; ?> from <?php echo $company_info->company_name; ?>.
		</p>
		<p>Purpose for my call is that we find that many  
			<?php 
				if($campaign_info->campaign_target == '1'){	
						 echo $campaign_info->individual;
					}else{ 
						echo $campaign_info->organization;
				}
			?> have challenges with:
			</p>
			<p>
			<span class="red-area">(Share up to three of below pain points)</span>
			</p>
			<p>
			<?php 
				if(isset($campaign_output_tech_pain)){
					echo '<ul>';
					foreach($campaign_output_tech_pain as $singlepain){
					
						echo '<li>'. ucfirst($singlepain->value) .'</li>';
					}
					echo '</ul>';
				}
			?>
		</p>
		<p><span class="red-area">(Optional disqualify statement) </span>I actually do not know if you are a fit for what we do and that is why I was calling you with a question or two.</p>
		<p>I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.</p>
		<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?>, <?php echo $aMember['yphone']; ?>.</p>
		<p>Thank you and I look forward to talking with you soon.</p>
		</div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'intro',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+3)//Name Drop Focus
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
        <p>Hello <span class="red-area" >[Prospect Name] </span>, this is <?php echo $aMember['yname']; ?>  from <?php echo $company_info->company_name; ?> . </p>
		<p>Purpose for my call is that 
			We worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?> and this led to <?php  echo  $active_name_drop_exp['when']->value; ?>.				</p>
		<p><span class="red-area"> (Optional disqualify statement) </span>I actually do not know if we can help you in the same way and that is why I was calling you with a question or two.</p>
		<p>I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.</p>
		<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?> ,  <?php echo $aMember['yphone']; ?>.</p>
		<p>Thank you and I look forward to talking with you soon.</p>
		</div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'intro',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	else if($partid == $lastid+4)//Product Focus
	{
		?>
        <h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
        <div class="scroll-bar_sf">
        <p>Hello <span class="red-area" >[Prospect Name] </span>, this is <?php echo $aMember['yname']; ?>  from <?php echo $company_info->company_name; ?> . </p>
		<p>Purpose for my call is that we provide <?php echo $P_Q1->value; ?>.</p>
		<p><span class="red-area"> (Optional disqualify statement) </span>I actually do not know if we can help you in the same way and that is why I was calling you with a question or two.</p>
		<p>I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.</p>
		<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?> ,  <?php echo $aMember['yphone']; ?>.</p>
		<p>Thank you and I look forward to talking with you soon.</p>
		</div>
        <?php
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,'intro',current_url());
		$front_step = str_replace($temp,'about-us',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = true;
	}
	?>
    <?php if($action != 'download2' && $action != 'download' && $partid) {?>
    <div class="leftheader_is">
        <p>
            <?php
            $vtemp = end(explode('/',current_url()));
            $voice_1 = str_replace($vtemp,'voice_1',current_url());
            $voice_2 = str_replace($vtemp,'voice_2',current_url());
            $voice_3 = str_replace($vtemp,'voice_3',current_url());
            $voice_4 = str_replace($vtemp,'voice_4',current_url());
            ?>
            <?php /*?><a href="<?php echo $voice_1;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_1') echo 'active';?>">Voicemail #1 - Value</a>
            <a href="<?php echo $voice_2;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_2') echo 'active';?>">Voicemail #2 - Pain</a>
            <a href="<?php echo $voice_3;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_3') echo 'active';?>">Voicemail #3 - Name Drop</a>
            <a href="<?php echo $voice_4;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_4') echo 'active';?>">Voicemail #4 - Product</a><?php */?>
            <a href="<?php echo $voice_1;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_1') echo 'active';?>" title="<?php echo $parts[$lastid+1]['title'];?>" onClick="return saveStepData('<?php echo $vtemp;?>',event,this);"><?php echo $parts[$lastid+1]['title'];?></a>
            <a href="<?php echo $voice_2;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_2') echo 'active';?>" title="<?php echo $parts[$lastid+2]['title'];?>" onClick="return saveStepData('<?php echo $vtemp;?>',event,this);"><?php echo $parts[$lastid+2]['title'];?></a>
            <a href="<?php echo $voice_3;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_3') echo 'active';?>" title="<?php echo $parts[$lastid+3]['title'];?>" onClick="return saveStepData('<?php echo $vtemp;?>',event,this);"><?php echo $parts[$lastid+3]['title'];?></a>
            <a href="<?php echo $voice_4;?>" class="is_voicemail_tab <?php if($vtemp == 'voice_4') echo 'active';?>" title="<?php echo $parts[$lastid+4]['title'];?>" onClick="return saveStepData('<?php echo $vtemp;?>',event,this);"><?php echo $parts[$lastid+4]['title'];?></a>
        </p>
    </div>
    <?php if($edittemp<>1){?>
    <div class="is_footer">
    <p style="text-align:center;"><textarea class="sub-dev-cont" name="part-content-<?php echo $partid;?>"></textarea></p>
    </div>
    <?php }?>
    <?php }?>
<?php 
			$temp = end(explode('/',current_url()));
			$stop_url = str_replace('/'.$temp,'/objection-responses',current_url());
			$question_step = str_replace('/'.$temp,'/pre-qualifying-questions',current_url());
			$problems_step = str_replace('/'.$temp,'/common-problems',current_url());
			$firstback_step = str_replace('/'.$temp,'/'.$parts[1]['name'],current_url());
			//For Titles
			foreach($parts as $titlepart)
			{
				if($titlepart['name'] == 'objection-responses') $objection_title = $titlepart['title'];
				if($titlepart['name'] == 'common-problems') $common_prob_title = $titlepart['title'];
				if($titlepart['name'] == 'about-us') $about_us_title1 = $titlepart['title'];
				if($titlepart['name'] == 'attention-grabbing') $about_us_title2 = $titlepart['title'];
				if($titlepart['name'] == 'close') $close_title = $titlepart['title'];
				if($titlepart['name'] == 'pre-qualifying-questions') $questionbutton_title = $titlepart['title'];
				if($titlepart['name'] == 'intro') $intro_title = $titlepart['title'];
				
				$ftemp = end(explode('/',$front_step));
				if($titlepart['name'] == $ftemp) $objection_front_title = $titlepart['title'];
				
				
				if($partid == 1) 
				{
					$backbutton_title = $intro_title;
					$back_step = $firstback_step; 
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
					$temp_ff = end(explode('/',$front_step));
					$front_step = str_replace("/".$temp_ff,'/',$front_step);//By Dev@4489 for IS Last ID
				}
				else if($partid > $lastid)
				{
					$backbutton_title = $intro_title;
					$frontbutton_title =  $objection_front_title;
				}
				
			}
			$temp_name = end(explode('/',$front_step));
			//print_r($parts);
			
			if(!in_array_custom4($temp_name,$parts) || $temp_name == 'objection-responses')
			{
				$frontbutton_title = 'View Full Script';
				$front_step = str_replace("/".end(explode('/',current_url())),'/',current_url());//By Dev@4489 for IS Last ID
				//echo $front_step;
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
    <div class="is_footer">
    <div class="sub-navigation1 is_footer">    	
    	<div class="a"><a class="navab" title="<?php echo $backbutton_title;?>" href="<?php echo $back_step;?>" onClick="return saveStepData('<?php echo $temp;?>',event,this);"></a></div>
		<div class="a"><a class="navaq" title="<?php echo $questionbutton_title;?>" href="<?php echo $question_step;?>" onClick="return saveStepData('<?php echo $temp;?>',event,this);"></a></div>
        <div class="a"><a class="navap" title="<?php echo $common_prob_title; ?>" href="<?php echo $problems_step;?>" onClick="return saveStepData('<?php echo $temp;?>',event,this);"></a></div>
        <div class="a"><a class="navaa" title="<?php echo $about_us_title; ?>" href="<?php echo $aboutus_step;?>" onClick="return saveStepData('<?php echo $temp;?>',event,this);"></a></div>        
        <div class="a"><a class="navas2" title="<?php echo $close_title; ?>" href="<?php echo $fav_step;?>" onClick="return saveStepData('<?php echo $temp;?>',event,this);"></a></div>
        <div class="a"><a class="navaf" title="<?php echo $frontbutton_title;?>" href="<?php echo $front_step;?>" onClick="return saveStepData('<?php echo $temp;?>',event,this);"></a></div>
    </div>
    <div class="sub-nav-sf-wr">
    
    </div>
    </div>
     <?php 
			} 
		?>
