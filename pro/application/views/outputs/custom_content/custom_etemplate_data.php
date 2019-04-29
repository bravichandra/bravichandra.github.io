<?php
//********************************************* SLAES SCRIPTS ***************************//


//$email_signature = "";
/*if($company_info->email_signature!='')
{ 
	$email_signature =  $company_info->email_signature;
} 
else 
{
	$mname = $aMember['yname'];
	if($mname=='') { $email_signature .='[First Name] [Last Name]'; } else { if($mname=="0 0") $email_signature .='[First Name] [Last Name]'; else $email_signature .= $mname; }
	
	$email_signature .='<br/>';
	
	$cname = $company_info->company_name;
	if($cname!='' || $cname!=0) $email_signature .= $cname; else $email_signature .='[Company Name]';
	
	$email_signature .='<br/>';
	
	$pnumber = $aMember['yphone'];
	if($pnumber!='' || $pnumber!=0) $email_signature .= $pnumber; else $email_signature .='[Phone Number]';	
	
	$email_signature .='<br/>';		
	
	$email = $aMember['yemail'];
	if($email=='') $email_signature .= '[Email Address]'; else { if($email=="0") $email_signature .='[Email Address]'; else $email_signature .= $email;}
	
	/*if($email=='') { $email_signature .='[Email Address]'; } else { if($email=="0") $email_signature .='[Email Address]'; else $email_signature .= $email; }
	
	$email_signature .='<br/>';
	
	$website_field = $company_info->company_website;
	if($website_field!='') $email_signature .= $website_field; else $email_signature .='[Website Address]';
}*/

//if(!isset($_REQUEST['/chrome/getTemplate']))
//{
	/*$amember_data = Am_Lite::getInstance()->getUser();
	$mfname = $amember_data['name_f'];
	$mlname = $amember_data['name_l'];
	$mname = $mfname." ".$mlname;
	if($mname=='') {$member_name ='[First Name] [Last Name]'; } else { if($mname=="0 0") $member_name ='[First Name] [Last Name]'; else $member_name = $mname; }
	
	$cname = $aMember['ycompany'];
	if($cname!='' || $cname!=0) $company_name = $cname; else $company_name ='[Company Name]';
	
	$pnumber = $amember_data['phone'];
	if($pnumber!='' || $pnumber!=0) $phone_number = $pnumber; else $phone_number ='[Phone Number]';										
	
	$email = $amember_data['email'];
	
	if($email=='') {$email_address ='[Email Address]'; } else { if($email=="0") $email_address ='[Email Address]'; else $email_address = $email; }
	
	$website_field = $aMember['ywebsite'];
	if($website_field!='') $website = $website_field; else $website='[Website Address]';
	
	if(isset($aMember['email_signature']) && $aMember['email_signature']!='') $email_signature =  $aMember['email_signature'];
	else $email_signature = $member_name."<br/>".$company_name."<br/>".$phone_number."<br/>".$email_address."<br/>".$website;
	
	$aMember['yphone'] = $pnumber;*/
	
	
/*	$amember_username = Am_Lite::getInstance()->getUsername();
	if($user_id = $this->home->get_user_by_username($amember_username))
	{
		$this->_data['user_id'] = $user_id;
	}
				
	$amember_data = Am_Lite::getInstance()->getUser();
	$mfname = $amember_data['name_f'];
	$mlname = $amember_data['name_l'];
	$mname = $mfname." ".$mlname;
	if($mname=='') {$member_name ='[First Name] [Last Name]'; } else { if($mname=="0 0") $member_name ='[First Name] [Last Name]'; else $member_name = $mname; }
	
	$cname = $aMember['ycompany'];
	if($cname!='' || $cname!=0) $company_name = $cname; else $company_name ='[Company Name]';
	
	$pnumber = $amember_data['phone'];
	if($pnumber!='' || $pnumber!=0) $phone_number = $pnumber; else $phone_number ='[Phone Number]';										
	
	$email = $amember_data['email'];
	
	if($email=='') {$email_address ='[Email Address]'; } else { if($email=="0") $email_address ='[Email Address]'; else $email_address = $email; }
	
	$website_field = $aMember['ywebsite'];
	if($website_field!='') $website = $website_field; else $website='[Website Address]';*/
		//echo '<pre>'; print_r($aMember); echo '</pre>';
		
		if(!isset($_REQUEST['/chrome/getTemplate']))
		{
			$amember_username = Am_Lite::getInstance()->getUsername();
			if($user_id = $this->home->get_user_by_username($amember_username))
			{
				$this->_data['user_id'] = $user_id;
			}
			
			$ced_esign = $aMember['email_signature'];
			$where = array();
			$where['user_id'] = $user_id;
			$where['field_type'] = 'smtp';
			$user_info = $this->home->getUserData($where);
			if($user_info && isset($user_info[0]))
			{
				$k = unserialize($user_info[0]->value);
				if(isset($k['email_signature']) && $k['email_signature'])
				{
					$ced_esign =  $k['email_signature'];
				}
			}
			$email_signature = $ced_esign;
		}
	/*$k = unserialize($user_info[0]->value);
	
	if(isset($aMember['email_signature']) && $aMember['email_signature']!='') $email_signature =  $k['email_signature'];
	else $email_signature = $member_name."<br/>".$company_name."<br/>".$phone_number."<br/>".$email_address."<br/>".$website;
	$aMember['yphone'] = $pnumber;*/
//}
//echo $content_id;
if($content_id == 1) {//Objective
	?>Option A: <span class="dynamic_value edit_area" id="ccd_<?php echo $sale_process_close1->cam_com_id ?>_<?php echo $campaign_info->campaign_id; ?> "><?php echo (!empty($sale_process_close1->value) ? $sale_process_close1->value : $this->config->item('message'));?></span> 
			<br/> Option B:  <span class="dynamic_value edit_area" id="ccd_<?php $sale_process_close3->cam_com_id ?>_<?php echo $campaign_info->campaign_id; ?>"><?php echo (!empty($sale_process_close3->value) ? $sale_process_close3->value : $this->config->item('message'));?></span><?php
} else if ($content_id == 2) {//Introduction
	?><h3 class="sub-dev-head-sub2">Gatekeeper:</h3>
            	<p>
                    <b>If you have the contact's name:</b><br />
                    Hello, I am trying to connect with <span class="red-area">[Target Prospect]</span>.
                </p>
                <p>
                    <b>If you have the contact's title:</b><br />
                    Hello, I am trying to connect with the <span class="red-area">[Target Title]</span>.
                </p>
                <p>
                    <b>If you don't have the name or title:</b><br />
                    Hello, I am trying to connect with the person responsible for <span class="red-area">[Target Area]</span>. Can you point me in the right direction?
                </p>
                <h3 class="sub-dev-head-sub2">Prospect:</h3>
                <p>Hello  <span class="red-area">[Contact's Name]</span>, this is  <span><?php echo $aMember['yname'] ?></span> from  <span><?php echo  $company_info->company_name ; ?></span>, have I caught you in the middle of anything?</p><?php
} else if ($content_id == 3) {//Value Statement
	?>Great. The purpose of my call is that we help  
						<span class="dynamic_value edit_area_old" id=""><?php 
							
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}
						?></span> to:
				<ul style="padding-top: 10px;">
                	<?php 
					foreach($campaign_output_tech_val as $cur_tech_summary) { 
					if($cur_tech_summary->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
					?>
					<li> 
						<span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $cur_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($cur_tech_summary->value) ? $cur_tech_summary->value : NULL);?></span>
					</li>
                    <?php 
					}
					?>
				  </ul>
                <p><strong>(Optional) Disqualify Statement</strong></p>
                <span class="red-area">(Choose one of the following)</span>
                <ul style="padding-top: 10px;">
                	<li>I actually don't know if you need what our services provide so I just had a question or two</li>
                    <li>I actually don't know if you are a good fit for what we provide so I just had a question or two</li>
                    <li>I don't know if you are the right person to speak with but I have just a couple of questions</li>
                </ul><br/>
                <span class="red-area">(pause or ask for agreement or availability)</span>  If you have a couple of minutes?
				<?php
} else if ($content_id == 4) {//Pre-Qualifying Questions
	?><?php if(isset($CallScriptYes)){?><p>If I could ask you real quick:</p>
				<?php /*?><p><span class="red-area">(Ask 3 to 5 of the questions below)</span></p><?php */?><?php }?>
                    <?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?>
					<?php if(isset($CallScriptYes)){?><?php /*?><p><span class="red-area">(If you get an answer that justifies moving on to <?php echo $sale_process_close1->value ?>, skip ahead to closing for a <?php echo $sale_process_close1->value ?>)</span></p>

					<p><span class="red-area">(If you do not, move to next section) </span></p><?php */?><?php }?>
					<?php
} else if ($content_id == 5) {//Examples of Common Problems ?>
<?php if($method_name=="call-script-focus-pain"){//call-script-focus-pain?>
	<?php if(isset($CallScriptYes)){?><p>Great. The purpose for the call is that we talk with other <span class="dynamic_value "><?php 
		if($campaign_info->campaign_target == '1'){	
				echo $campaign_info->individual;
			}else{
				echo $campaign_info->organization;
		}
	?></span>, we have noticed that they often express challenges with <span class="red-area">(or concerns around)</span>:</p><?php }?>
	
	<?php if (isset($campaign_output_tech_pain)):?>
				<ul>
					<?php foreach ($campaign_output_tech_pain as $single_tech_pain):
						if($single_tech_pain->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
					?>
						<li><span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
					<?php endforeach;?>
				</ul>
			<?php endif;?> 
		<?php if(isset($CallScriptYes)){?><p><b>(Optional) Disqualify Statement</b></p>
		<p>I don't know if you are concerned about those areas or not and that is why I was calling with a couple of questions.</p>
		<p><span class="red-area">(pause or ask for agreement or availability)</span> If you have a couple of minutes?</p>        
		<?php }?>
<?php }else{?>
	<?php if(isset($CallScriptYes)){?><p>Oh, OK. Well, as we talk with other <span class="dynamic_value "><?php 
    if($campaign_info->campaign_target == '1'){	
            echo $campaign_info->individual;
        }else{
            echo $campaign_info->organization;
    }
    ?></span>, we have noticed that they often express challenges with <span class="red-area">(or concerns around)</span> :</p><?php }?>
    
    <?php if (isset($campaign_output_tech_pain)):?>
            <ul>
                <?php 
					foreach ($campaign_output_tech_pain as $single_tech_pain):
					if($single_tech_pain->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
				?>
                    <li><span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
                <?php endforeach;?>
            </ul>
        <?php endif;?> 
    <?php if(isset($CallScriptYes)){?><?php /*?><p>Can you relate to any of those?</p>
    <p><span class="red-area">-or-</span></p>
    <p>Which one of those are you most concerned with?</p>
    <p><span class="red-area">(If you get an answer that justifies moving on to <?php echo $sale_process_close1->value ?>, skip ahead to closing for a <?php echo $sale_process_close1->value ?>)</span></p>
    <p><span class="red-area">	(If you do not, move to next section)</span></p><?php */?><p>Are any of those areas that you are concerned about?</p><?php }?>
<?php }?> 
<?php } else if ($content_id == 6) {//Company and Product Info
	?><?php if(isset($CallScriptYes)){?><p>It might productive for us to talk in more detail.  The reason why is<br/><span class="red-area">(Share any of the below as appropriate as you try to trigger interest)</span></p><?php }?>
				<strong>Product Details:</strong>
				<ul>
					<li>As I said, I am with <span><?php  echo $company_info->company_name; ?></span> and we provide <?php echo $P_Q1->value; ?></li>
					
					<l	i>Our <span class="dynamic_value edit_area_old" id=""><?php echo $P_Q1->value; ?></span>  <?php echo $product_desc->value; ?></li>
				</ul>
				<br/>
                <strong>Benefits:</strong>
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
				<strong>Differentiation:</strong>
					
						<p>Some ways that we differ from other options out there are:</p>
                        <ul style="list-style:disk;">
                        	<li><span class="<?php echo 'dynamic_value edit_area_old'; ?>" id=""><?php echo (!empty($diff1->value) ? ucfirst($diff1->value) : NULL);?></span>.</li>
                            <li><span class="<?php echo 'dynamic_value edit_area_old';?>" id=""><?php echo (!empty($diff2->value) ? ucfirst($diff2->value) : NULL);?></span>.</li>
                            <li><span class="<?php echo  'dynamic_value edit_area'; ?>" id=""><?php echo (!empty($diff3->value) ? ucfirst($diff3->value) : NULL);?></span>.</li>
						</ul>
				<br>
				<strong>Name Drop: </strong>
				<ul>
				  <li> We worked with <?php echo $active_name_drop_exp['worked']->credibility_name ?> and provided <?php echo  $active_name_drop_exp['worked']->value ?>. </li> 
				  <li> This helped them to <?php echo  $active_name_drop_exp['provided']->value ?>, which led to <?php echo  $active_name_drop_exp['when']->value ?>. </li>
				</ul>
				<br/>
				<strong>Threats of Doing Nothing:</strong>
				<p>Some things to be concerned with when not doing anything in this area are: </p>
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
								<?php foreach ($campaign_output_tech_pain as $single_tech_pain):
									if($single_tech_pain->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
								?>
									<li><span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
								<?php endforeach;?>
					<?php endif;?>
				</ul>
				<br />
				<strong>Company Facts:</strong>
						<p>Other key details about us are that we: </p>
							<ul style="list-style:disk;">
								<li><?php echo ucfirst($company_meta['interest'][0]) ?>.</li>
                                <li><?php echo ucfirst($company_meta['interest'][1]) ?>.</li>
								<li><?php echo ucfirst($company_meta['interest'][2]) ?>.</li>
                            </ul>
				<?php
} else if ($content_id == 7) {//Close
	?>But, since I have called you out of the blue, I do not want to take any more of your time to talk right now.<br/>
				
                <p><span class="red-area">(Chose one of the following closing methods) </span></p>
				<strong>Option 1 - Trial Close: </strong>
				<ul>
					<li> What do you think about what we have discussed so far? </li>
					<li> Is this something that you are interested in discussing in more detail? </li>
				</ul>
				<br/>
				<strong>Option 2 - Soft Close:</strong>
				<ul>
					<li> A great next step would be for us to schedule <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close1->value ) ? $sale_process_close1->value: '');?></span> where we can <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close2->value) ? $sale_process_close2->value : '');?></span>.</li>
					<li> Is that something that you would like to put on the calendar? </li>
				</ul>
				<br/>
				<strong>Option 3 - Hard Close:</strong>
				<ul>
					<li> How does your calendar look next Tuesday or Thursday morning for us to schedule <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close1->value ) ? $sale_process_close1->value: '');?></span> where <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close2->value) ? $sale_process_close2->value : '');?></span>.</li>
				</ul><?php
} else if ($content_id == 8) {//Close - call-script-quick-close
	?><p>Purpose for the call is that I would like to do is schedule <?php echo $sale_process_close1->value ?> where we can <?php echo $sale_process_close2->value ?>.</p>
    <p>Are you available to put this on the calendar next Tuesday or Thursday morning?</p>
    <span class="red-area">(If not able to close for meeting, move to next section)</span><?php
} else if ($content_id == 9) {//Value Statement - call-script-quick-close
	?><span class="red-area">(If they want to know more about what you do)</span>
    <p>Great. The Purpose of my call is that &#45; <span class="red-area">(Choose one of below)</span></p>
        <ul>
            <?php 
            foreach($campaign_output_tech_val as $cur_tech_summary) { ?>
            <li>We help  
                <span class="dynamic_value edit_area_old" id=""><?php 
                    
                    if($campaign_info->campaign_target == '1'){	
                            echo $campaign_info->individual;
                        }else{
                            echo $campaign_info->organization;
                    }
					 if($cur_tech_summary->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
                ?></span> to  
                <span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $cur_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($cur_tech_summary->value) ? $cur_tech_summary->value : NULL);?></span>.
            </li>
            <?php 
            }
            ?>
          </ul>
    <br><?php
} else if ($content_id == 13) {//Name drop example - call-script-name-drop
	?>
    <p>Purpose for my call is that:</p>
    <ul>
      <li> We worked with <?php echo $active_name_drop_exp['worked']->credibility_name ?> and provided <?php echo  $active_name_drop_exp['worked']->value ?>. </li> 
      <li> This helped them to <?php echo  $active_name_drop_exp['provided']->value ?>, which led to <?php echo  $active_name_drop_exp['when']->value ?>. </li>
    </ul>
    <p><strong>(Optional) Disqualify Statement</strong></p>
    <?php /*?><span class="red-area">(Choose one of the following)</span><?php */?>
    <ul>
        <?php /*?><li>I actually don't know if you need what our services provide so I just had a question or two. </li>
        <li>I actually don't know if you are a good fit for what we provide so I just had a question or two.</li>
        <li>I don't know if you are the right person to speak with but I have just a couple of questions.</li><?php */?>
		<li>I don't know if you we can help you in the same way or not and that is why I was calling with a couple of questions.</li>
    </ul><br/>
    <span class="red-area">(pause or ask for agreement or availability)</span>  If you have a couple of minutes?
    <br><br/>
    <?php	
} else if ($content_id == 10) {//Value Statement - call-script-webinar-follow-up
	?><p>Great. The reason for the call is that I am just doing my part to follow up with some of the attendees that registered for our webinar. </p><br/><?php
} else if ($content_id == 14) {//Webinar Related Questions - call-script-webinar-follow-up
	?><ul style="list-style-type:decimal ";>
						<li>  Was the information provided what you were looking for?</li>
						<li> Is there anything else on that subject that I can send you? </li>
						<li> Do you mind if I ask what motivated you sign up and spend your valuable time on with us? <span class="red-area">(The answer to the question is important to note as the answer may be linked to a reason for create a lead or to a problem that needs to be fixed)</span></li>
					</ul>
					<br/><?php
} else if ($content_id == 11) {//Value Statement - call_script_email_follow_up_qualify
	?><p>Great. The purpose for the call is that I sent you an email with some information and I wanted to follow up with you. </p>
				<br/>
                <strong>(Optional) Disqualify Statement</strong><br/>
                <ul>
                	<li>I am not sure if you had a chance to look at it or not.</li>
                </ul>
                <P><span class="red-area">(Pause to see if they respond with something that signifies the saw it and looked at it) </span> </P>
				
				<P><span class="red-area">(Do not directly ask them if they saw it or read it as there is a good chance they have not and doing this can make the create an awkward or defensive feeling on the prospect's side) </span> </P>
				<br/><?php
} else if ($content_id == 15) {//Email Related Questions - call_script_email_follow_up_qualify
	?><p><span class="red-area">(If they saw and looked at your email, ask any of these questions)</span></p>
				    <ul style="list-style-type:decimal ";>
						<li> Was the information provided what you were looking for? </li> 
						<li> Did you find the information to be helpful? </li> 
						<li> Did you have any questions about what I sent over? </li> 
						<li> Is there any additional information on that subject that you would be interested in seeing? </li> 
						<li> Are you interested in getting together to discuss that information in more detail. </li> 
					</ul>
					
					<p><span class="red-area">(If they did not appear to look at your information, redirect to the questions below)</span></p>
                    <br/><?php
} else if ($content_id == 16) {//Greeting - inbound-call-script
	?><p>Hello, thank you for calling <?php echo $company_info->company_name ?> , this is <?php echo $aMember['yname'] ?> , how can I help you?</p><?php
} else if ($content_id == 17) {//Prospect's Request - inbound-call-script
	?><p><span class="red-area">(The prospect will have some sort of question or request. This may include questions about product information or pricing.)</span></p><br/><?php
} else if ($content_id == 18) {//Scheduling the next discussion - inbound-call-script
	?><p>Would you like to schedule <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close1->value ) ? $sale_process_close1->value: '');?></span> where we can <span class="dynamic_value edit_area_old" id=""><?php echo (!empty($sale_process_close2->value) ? $sale_process_close2->value : '');?></span>.<br/>Are you available to put this on the calendar next Tuesday or Thursday morning?</p><br><?php
} else if ($content_id == 19) {//Intro Questions - first-meeting-script
	?><ul>
					<li>How is your day going so far?</li>
					<li>How long have you been working here?</li>
					<li>What did you do before?</li>
					<li>Where are you from?</li>
					<li>What do you like most about what you do?</li>
					<li>I know why I wanted to meet with you. Is there anything that motivate you to want to meet with me?</li>
					<li>Is there anything in particular that you are hoping to get out of this time that we spend together?</li>
				</ul>
				<br/><?php
} /*else if ($content_id == 22) {Hard Qualifying Questions - first-meeting-script
	?><strong>Need vs. Want Questions:</strong>
			<ul>
				<li>What happens if you do not do anything and do not make a purchase or make any changes?</li>
				<li>What improvements will you see if move forward with this purchase?</li>
				<li>Is there at date when this purchase needs to be made?</li>
				<li>What happens if the purchase is not made by that date?</li>
				<li>What is the time frame that the project needs to work along?</li>
			</ul><br>
			<strong>Availability of Funding Questions:</strong>
			<ul>
				<li>Is there a budget approved for this project?</li>
				<li>What is the budget range that the project needs to fit in?</li>
				<li>Have the funds been allocated to this purchase?</li>
				<li>What budget (department) will this purchase be made under?</li>
				<li>Are there other purchases that this funding may end being used for?</li>
				<li>How does the project fit with other initiatives from a priority standpoint?</li>
			</ul><br>
			<strong>Decision Making Authority Questions:</strong>
			<ul>
				<li>What is the decision making process?</li>
				<li>What parties will be involved in making the decision?</li>
				<li>What functional areas (departments) will be impacted by the purchase?</li>
				<li>Who is the ultimate decision maker?</li>
				<li>Who is the person that will need to sign the agreement/contract?</li>
			</ul><br>
			<strong>Level of Competition Questions:</strong>
			<ul>
				<li>What other options are you considering?</li>
	          	<li>How far along are you with talking with them?</li>
	          	<li>How do you feel about their solution (product)?</li>
	          	<li>What do you like about their solution (product)?</li>
	          	<li>What do you not like about their solution (product)?</li>
	          	<li>How does their solution (product) compare with what we have to offer?</li>
	          	<li>Is there a reason why you would choose us over them?</li>
	          	<li>If you had to make a decision today, which way would you lean?</li>
	          	<li>What are the key factors that the decision to purchase will be based on?</li>
			</ul><br/><?php
}*/ else if ($content_id == 20) {//Intro Questions - networking-scripts
	?><ul>
					<li>How is your day going so far?</li>
					<li>What do you do?</li>
					<li>How long have you been doing that?</li>
					<li>What did you do before?</li>
					<li>What do you like most about what you do?</li>
					<li>Is there something that motivated you to get into that type of work?</li>
					<li>Where are you from?</li>
				</ul>
				<br /><?php
} else if ($content_id == 23) {//Networking Questions - networking-scripts
	?><ul>
					<li>What brought you to this event?</li>
					<li>Have you found this to be a productive event for you?</li>
					<li>Are there any other networking events that you recommend?</li>
					<li>How can I help you to be successful?</li>
					<li>What does a good prospect look like for you?</li>
				</ul>
				<br /><?php
} else if ($content_id == 12) {//Value Statement - networking-scripts
	?><p> <span class="red-area"> (When they ask you what you do, share one of below) </span> </p>
				We help  
                        <span class="dynamic_value edit_area_old" id=""><?php 
                            
                            if($campaign_info->campaign_target == '1'){	
                                    echo $campaign_info->individual;
                                }else{
                                    echo $campaign_info->organization;
                            }
                        ?></span> to: <br />
                <ul class="sub-dev-desc-ul">
					<?php 
                    foreach($campaign_output_tech_val as $cur_tech_summary) {
					if($cur_tech_summary->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
					?>
                    <li>  
                        <span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $cur_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($cur_tech_summary->value) ? $cur_tech_summary->value : NULL);?></span>.
                    </li>
                    <?php 
                    }
                    ?>
                </ul>
				
				<br /><?php
} else if ($content_id == 24) {//Closing - networking-scripts
	?><ul>
				<li>Do you want to get together on another day where I can learn more about what you do?</li>
				<li>Are you interested in meeting over coffee sometime so that I can learn more about what you do?</li>
				<li>Do you think it makes sense to keep this conversation going?</li>
				<li>What is the best way for us to stay in touch?</li>
				<li>When do you want to talk again?</li>
				
			</ul>
			<br /><?php
} else if ($content_id == 21) {//Intro Questions - meeting-for-coffee-script
	?><ul>
					<li>How is your day going so far?</li>
					<li>Tell me more about what you do?</li>
					<li>How long have you been doing that?</li>
					<li>What did you do before?</li>
					<li>What do you like most about what you do?</li>
					<li>Is there something that motivated you to get into that type of work?</li>
					<li>Where are you from?</li>
					<li>I know why I wanted to meet with you. Is there anything that motivated you to want to meet with me? </li>
					<li>Is there anything in particular that you are hoping to get out of this time that we spend together?</li>
				</ul>
				<br /><?php
} else if ($content_id == 34) {//Networking Questions - meeting-for-coffee-script
	?><ul>
        <li>I know why I wanted to meet with you. Is there anything that motivated you to want to meet with me?</li>
        <li>Is there anything in particular that you are hoping to get out of this time that we spend together?</li>
        
        <li>How can I help you to be successful?</li>
        <li>What does a good prospect look like for you?</li>
    </ul>
    <br /><?php	
}
//********************************************* end of SLAES SCRIPTS ***************************//	
//********************************************* EMAILS AND LETTERS ***************************//
else if ($content_id == 96) {//pre-call-email-technical-value-focus
?><p><strong>Subject line:</strong> <?php 
        //echo $campaign_tech_summary->value; 
		if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);
		?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>The reason I am reaching out is that I am with   
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p>
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
        
        <p>We help to improve all of those areas and that is why I am reaching out to you.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
        <br>
<?php	
}
else if ($content_id == 213) {//pre-call-email-technical-value-focus
?><p><strong>Subject line:</strong> <?php 
        //echo $campaign_tech_summary->value; 
		if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);
		?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>I came across you on LinkedIn and wanted to reach out because we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p>
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
        <p>I don't know if those are areas that you want to improve so that is why I am reaching out.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
        
        <br>
<?php	
}

else if ($content_id == 97) {//pre_call_email_technical_pain
?><p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>The reason I am reaching out is that I am with  
    <span><?php echo $company_info->company_name ?></span> and we find that 
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?>
        can have challenges with:
    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>We help to improve all of those areas and that is why I am reaching out to you.</p>
    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    <br><br>
    <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
    <br>
<?php 
}
else if ($content_id == 214) {//pre_call_email_technical_pain
?><p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I came across you on LinkedIn and wanted to reach out because we find that 
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?>
        can have challenges with:
    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if those are areas that you are concerned about so that is why I am reaching out.</p>
    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    <br><br>
    <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
    <br>
<?php 
}
else if ($content_id == 98) {//pre_call_email_technical_qualify
?><p><strong>Subject line:</strong> <?php //echo $campaign_tech_summary->value
if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);
 ?></p>		        

<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>

<p>The reason I am reaching out is that I am with  
<span><?php echo $company_info->company_name ?></span> and we help 

		<?php 
			if($campaign_info->campaign_target == '1'){	
				echo $campaign_info->individual;
			}else{ 
				echo $campaign_info->organization;
			}
		?> to <?php echo $campaign_tech_summary->value; ?>.</p>

<p> I have three quick questions to help determine if it makes sense to talk: </p>
<p>
	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation. </p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br>
<?php 
}else if ($content_id == 99) {//pre-call-email-namedrop-focus
?><p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
		        
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<?php /*?><p>To quickly introduce myself, I am with  
<span><?php  echo $company_info->company_name; ?> </span> and we help 
<?php 
    if($campaign_info->campaign_target == '1'){	
             echo $campaign_info->individual;
        }else{ 
            echo $campaign_info->organization;
    }
?>
to <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?>.</p><?php */?>
<p>One of the reason I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>.</p>
<p>This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
<p>I don't know if we can help you in the same way and that is why I am reaching out to you.</p>
<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br/>
<?php 
}else if ($content_id == 100) {//pre-call-email-product-focus
?><p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value edit_area">{contact first name}</span>,</p>
		        <p>The reason I am reaching out is that I am with 
					<span><?php  echo $company_info->company_name; ?> </span>

					and we help 
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?> to <?php if(isset($campaign_output_tech_val)){
							foreach($campaign_output_tech_val as $comp){echo $comp->value;break;}}
						?>.
				</p>
		        <p>We do this by providing <?php echo $P_Q1->value; ?> which <?php echo $product_desc->value; ?>.</p>
				<p>
					Some ways that we differ from other options out there:
				</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<?php /*?><p>We worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?> and this led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>
		        <p>I don’t know if you are interested in any of those improvements and that is why I am reaching out to you. I will try to give you a call next week. </p><?php */?>
				<p><?php /*?>If you are interested in talking before then, I can schedule<?php */?>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<?php 
}else if ($content_id == 101) {//internal-referral-email
?><p><strong>Subject line:</strong> <span>Appropriate person</span></p>		        		
		<p>Hi <span class="dynamic_value">{contact first name}</span>,</p>	
		<p>I hope this finds you well. I am reaching out to you in the hopes of finding the appropriate person who handles <span class="red-area"> [Insert the functional area that serve or sell to - ex: payroll, data backup, employee training]. Optional name drop) </span>- I also wrote to [Internal contact 1], [Internal contact 2] and [Internal contact 3] in regards to this. </p>

		<p>If you are the right person to speak with, let me know how your calendar looks. I am available next Tuesday morning and Thursday afternoon. If you are not, any help in pointing me in the right direction would be greatly appreciated.</p>
		<br><br>
        <p>Best Regards,</p>		       
		<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>		        
		<br>
<?php 
}else if ($content_id == 102) {//linkedin-technical-value
?><p><strong>Subject line:</strong> Thanks for connecting<?php 
				 // echo $campaign_tech_summary->value; ?></p>		        
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        
		        <p>Thank you for connecting, I came across your profile because I work a lot with
					 <span class="red-area">[insert contact's title]</span>
					and they are often interested in improving some of the following areas:
				
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
		        
		        <p>If any of those are areas that you are happen to be interested in, we might be able to have a productive conversation as those are the types of things that we help with. </p>
				<p>Let me know if you want to put a brief conversation on the calendar. I would be very interested in learning more about what you all are doing.</p>
		        <p>Look forward to possibly talking with you.</p>
		        <p>
		        	<span><?php echo $aMember['yname'] ?></span>
		            
		        </p>
		        <br />
<?php 
}else if ($content_id == 103) {//linkedin-technical-pain
?><p><strong>Subject line:</strong> Thanks for connecting<?php 
				 // echo $campaign_tech_summary->value; ?></p>		        
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        
		        <p>Thank you for connecting, I came across your profile because I work a lot with
					 <span class="red-area">[insert contact's title]</span>
					and I know that they often express concerns with:
				
					<ul>
						<?php if(isset($campaign_output_tech_pain)){
							foreach($campaign_output_tech_pain as $comp){
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
		        
		        <p>If you are concerned with any of those, we might be able to have a productive conversation as those are the types of challenges that we help to resolve.</p>
				<p>Let me know if you want to put a brief conversation on the calendar. I would be very interested in learning more about what you all are doing.</p>
		        <p>Look forward to possibly talking with you.</p>
		        <p>
		        	<span><?php echo $aMember['yname'] ?></span>
		            
		        </p>
		        <br />
<?php 
}else if ($content_id == 104) {//post-call-email-value-focus
?><p><strong>Subject line:</strong> <?php 
				//echo $campaign_tech_summary->value;
				if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);
				 ?></p>		        
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        
		        <p>It was good to briefly speak with you today. As I mentioned, I am with   
					<span><?php echo $company_info->company_name ?></span> and we help  
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?> to:<?php /*?> deal with <?php echo  $campaign_output_tech_pain[0]->value ; ?>.<?php */?>
				</p> 
		        
		        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
		        
		        <?php /*?><p>I don’t know if you are interested in any of those and that is why I am reaching out to you. I will try to give you a call next week.  </p>
				<p>If you are interested in talking before then, I can schedule a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p><?php */?>
                <p>I don't know if you are interested in any of those and that is why I reached out to you.</p>
                <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php 
}else if ($content_id == 105) {//post-call-email-pain-focus
?><p><strong>Subject line:</strong> <?php //echo $campaign_output_tech_pain[0]->value
				if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value);
				 ?></p>		        
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        
		        <p>It was good to briefly speak with you today. As I mentioned, I am with  
		        <span><?php echo $company_info->company_name ?></span> and we<?php /*?> help to <?php echo $campaign_tech_summary->value; ?>.</p>
		        
		        <p>
					Reason for the email is that we<?php */?> find that  
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
							}
					?>
					can have challenges with:
				
					<ul>
					<?php if(isset($campaign_output_tech_pain)){
						foreach($campaign_output_tech_pain as $comp){	?>
							<li>
							<?php echo ucfirst($comp->value) ?>
							</li>
						<?php 
						}
					}
					?>
					</ul>
				</p>
		        <?php /*?><p><!--We help to decrease all of those-->I am not sure if you are concerned about any of those and that is why I am reaching out to you. I will try to give you a call next week.  </p>
				<p>If you are interested in talking before then, I can schedule a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p><?php */?>
                <p>I am not sure if you are concerned about any of those and that is why I reached out to you.</p>
                <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php 
}else if ($content_id == 106) {//your-information
?><p><strong>Subject line:</strong> Following up our conversation - <span> <?php echo $company_info->company_name; ?> </span> </p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        <p>It was good to briefly talk with you today. Here is some more information on us and why I am reaching out to you.</p>
				
				<p>
					A lot of  <?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>. that we work with have challenges with or concerns around:
					
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $single_tech_pain):
							if($single_tech_pain->highlight==1) $ssansbg = ' style="background-color:#ffff00"'; else $ssansbg = '';
							?>
								<li><span <?php echo $ssansbg;?> class="<?php echo 'dynamic_value edit_area' ;?>" id="tpnd_<?php echo $single_tech_pain->tech_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_pain->value);?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $single_biz_pain):?>
								<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="bpd_<?php echo $single_biz_pain->biz_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_biz_pain->value;?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						<?php if (isset($campaign_output_per_pain)):?>
								<?php foreach ($campaign_output_per_pain as $single_per_pain):?>
									<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ppd_<?php echo $single_per_pain->per_p_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_per_pain->value;?></span></li>
								<?php endforeach;?>
						<?php endif;?><?php */?>
					</ul>
				</p>
		        
		        <p>I don't know if you are concerned about any of those but we help to resolve and mitigate those challenges by driving the following improvements:  
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $single_tech_value):?>
								<li><span class="<?php echo 'dynamic_value edit_area1' ;?>" id="tpnd_<?php echo $single_tech_value->tech_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo ucfirst($single_tech_value->value);?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $single_biz_val):?>
								<li><span class="<?php echo 'dynamic_value edit_area1' ;?>" id="bpd_<?php echo $single_biz_val->biz_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_biz_val->value;?></span></li>
							<?php endforeach;?>
						<?php endif;?>
						<?php if (isset($campaign_output_per_val)):?>
								<?php foreach ($campaign_output_per_val as $single_per_val):?>
									<li><span class="<?php echo 'dynamic_value edit_area1' ;?>" id="ppd_<?php echo $single_per_val->per_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_per_val->value;?></span></li>
								<?php endforeach;?>
						<?php endif;?><?php */?>
					</ul>
				
				</p>
				<p>We do this by providing <?php echo $P_Q1->value; ?> which <?php echo $product_desc->value; ?>.</p>
				<p>
					Some ways that we differ from other options out there are <?php echo $diff1->value; ?>  <?php echo $diff2->value; ?>, and <?php echo $diff3->value; ?>.
				</p>
				
				<p>
					For example, if we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo  $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.
				</p>
				
				<p> Other details about us are: 
					<ul>
						<li>We have been in business for  <?php echo isset($company_meta['business_exp']) ? $company_meta['business_exp'] : 'experience'  ?>.</li>
						<li>We operate in <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
						<li>We have won awards for <?php echo isset($company_meta['area_operate']) ? $company_meta['area_operate'] : 'area operate'  ?>.</li>
						<li>Other key details about us are that we <?php echo $company_meta['interest'][0] ?> , <?php echo $company_meta['interest'][1] ?> and <?php echo $company_meta['interest'][2] ?>.</li>
					</ul>
				
				</p>
				
		        <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php 
}else if ($content_id == 107) {//post_call_email_technical_value_focus
?><p><strong>Subject line:</strong> Following up my voicemail - <?php 
				echo $company_info->company_name ?></p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        
		        <p>As I mentioned in a voicemail I just left you, I am with <?php echo $company_info->company_name ?> and we help 
					<?php 
					if($campaign_info->campaign_target == '1'){	
							 echo $campaign_info->individual;
						}else{ 
							echo $campaign_info->organization;
					}
					?> to:<?php /*?> deal with <?php echo $campaign_output_tech_pain[0]->value ?>.
				</p>
				
		        <p>We do this by helping to drive the following improvements::<?php */?>
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
				
		        <p>I don't know if you are interested in any of those improvements and that is why I am reaching out to you. I will try to give you a call next week. </p>
				<p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php 
}else if ($content_id == 108) {//post_call_email_technical_pain_focus
?><p><strong>Subject line:</strong> Following up my voicemail- <?php 
					echo $company_info->company_name ?></p>		        
		       
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        
		        <p>As I mentioned in a voicemail I just left you, I am with  <?php echo $company_info->company_name ?> and we find that  
                	<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?> can have challenges with:
				</p>
				<p>
					<ul>
						<?php if(isset($campaign_output_tech_pain)){
						foreach($campaign_output_tech_pain as $comp){
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
				
		        <p>We help to improve all of those areas and that is why I am reaching out to you.</p>
				<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php 
}else if ($content_id == 109) {//post-voicemail-name-drop-focus
?><p><strong>Subject line:</strong> Following up my voicemail - <?php 
					  echo $company_info->company_name ; ?></p>
					
					<p>Hello {contact first name},</p>
					<p>As I mentioned in a voicemail I just left you, the reason I am reaching out is that we worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided  <?php  echo $active_name_drop_exp['worked']->value; ?>.</p> 
					<p>This helped them to  <?php  echo  $active_name_drop_exp['provided']->value; ?>,  which led to <?php  echo  $active_name_drop_exp['when']->value; ?> .</p>
					
					<p>I don't know if you are interested in any of those improvements and that is why I am reaching out to you.</p>
					<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<?php 
}else if ($content_id == 110) {//post-voicemail-email-product
?><p><strong>Subject line:</strong>  Following up my voicemail - <?php  echo $company_info->company_name; ?>  </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
		        <p>As I mentioned in a voicemail I just left you, I am with 
					<span><?php  echo $company_info->company_name; ?> </span>

					and we help to 
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>to <?php echo $campaign_tech_summary->value ?>.
				</p>
		        <p>We do this by providing <?php echo $P_Q1->value; ?> which <?php echo $product_desc->value; ?>.</p>
				<p>
					Some ways that we differ from other options out there:<?php /*?> are <?php echo $diff1->value; ?>  <?php echo $diff2->value; ?>, and <?php echo $diff3->value; ?><?php */?>
				</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<?php /*?><p>We worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?> and this led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>
		        <p>I don't know if you are interested in any of those improvements and that is why I am reaching out to you. I will try to give you a call next week. </p><?php */?>
				<p><?php /*?>If you are interested in talking before then, I can schedule<?php */?>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<?php 
}else if ($content_id == 111) {//last-attempt-email-technical-value
?><p><strong>Subject line:</strong> <?php // echo $campaign_per_summary->value; ?>Checking In </p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file. </p>
		        <p>No problem if that is the direction you prefer.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php
}else if ($content_id == 185) {//checking-back-in-email-pain
?>
<p><strong>Subject line:</strong> Following back up with you </p>
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>

<p>It has been a little while since we spoke so I thought I would check back in with you.</p>

<p>One reason I thought it might make sense to continue our discussion is if you are having any of the challenges that we help  
    <?php 
        if($campaign_info->campaign_target == '1'){	
                 echo $campaign_info->individual;
            }else{ 
                echo $campaign_info->organization;
        }
    ?>
    to resolve:</p>
<ul>
    <?php if(isset($campaign_output_tech_pain)){
		foreach($campaign_output_tech_pain as $comp){	?>
			<li><?php echo ucfirst($comp->value) ?></li>
		<?php 
		}
	}
	?>
</ul>

<p>Are you concerned about any of those areas? If so, it might be productive to get back together at some point.</p>
<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br>                
<?php
} else if ($content_id == 161) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Value Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>The reason I am reaching out is that I am with   
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:<?php /*?> deal with <?php echo  $campaign_output_tech_pain[0]->value ; ?>.<?php */?>
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 162) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Pain Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I want to follow up with you on an email that I sent you last week. The reason that I am reaching out to you is that  
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?> can have challenges with:    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you.</p>

    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    
    <br><br>
        <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 163) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you.</p>
					<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 164) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 165) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 166) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
         
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        		        <br>                
<?php 
}


else if ($content_id == 215) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Value Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php 
        //echo $campaign_tech_summary->value; 
		if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);
		?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>I came across you on LinkedIn and wanted to reach out because we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p>
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
        <p>I don't know if those are areas that you want to improve so that is why I am reaching out.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
        
        <br>
<?php
} else if ($content_id == 216) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Pain Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I want to follow up with you on an email that I sent you last week. The reason that I am reaching out to you is that  
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?> can have challenges with:    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you.</p>

    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    
    <br><br>
        <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 217) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you.</p>
					<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
					<br><br>            
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 218) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 219) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 220) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>                
<?php 
}





else if ($content_id == 221) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Pain Message</strong></p><?php }?>

<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I came across you on LinkedIn and wanted to reach out because we find that 
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?>
        can have challenges with:
    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if those are areas that you are concerned about so that is why I am reaching out.</p>
    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    <br><br>
    <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
    <br>
<?php
} else if ($content_id == 222) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Value Message</strong></p><?php }?>
<p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>I want to follow up with you on an email that I sent you last week. The reason I am reaching out is that I am with 
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 223) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>.</p>
                    <p>This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you.</p>
					<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 224) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" or have some thoughts to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 225) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo trim($product_desc->value); ?>.</p>
		    	<p>Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 226) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>                
<?php
}


else if ($content_id == 203) {//opt-in
?><p><strong>Subject line:</strong> Email ap</p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>Hello <span class="dynamic_value"><?php echo $aMember['yname']?></span> from  <span class="dynamic_value">
        <?php echo  $company_info->company_name ; ?></span> would like to send you an email.</p>
        
        <p>
           <?php if (isset($scripts_helper)) { ?>
           Click here
           <?php } else { ?>
           <a href="[Subscribe Email OPT]">Click here</a>
           <?php } ?>
           to provide permission to receive email from <span class="dynamic_value"><?php echo $aMember['yname']?></span>.
        </p>
        <br>
<?php	
}   else if ($content_id == 1610) {//pre-call-email-thread
?>
<p><strong>Email #1 - Value Message</strong></p>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>The reason I am reaching out is that I am with   
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:<?php /*?> deal with <?php echo  $campaign_output_tech_pain[0]->value ; ?>.<?php */?>
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>
        <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br /><hr />
<p><strong>Delay: 1 to 2 weeks</strong></p>
<p><strong>Email #2 - Pain Message</strong></p>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I want to follow up with you on an email that I sent you last week. The reason that I am reaching out to you is that I know a lot of 
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?> often have challenges with:    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>

    <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
    
    <br><br>
        <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br /><hr />
<p><strong>Delay: 1 to 2 weeks</strong></p>
<p><strong>Email #3 - Name Drop Message</strong></p>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you. I will try to give you a call next week.</p>
					<p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br /><hr />
<p><strong>Delay: 1 to 2 weeks</strong></p>
<p><strong>Email #4 - Qualify Message</strong></p>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br /><hr />
<p><strong>Delay: 1 to 2 weeks</strong></p>
<p><strong>Email #5 - Product Message</strong></p>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br /><hr />
<p><strong>Delay: 1 to 2 weeks</strong></p>
<p><strong>Email #6 - Last Attempt</strong></p>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php /*?>Pre-Call Email Thread - Pain/Value/Name Drop/Qualify/Product/Last Attempt<?php */?>
<?php
} else if ($content_id == 167) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Pain Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>The reason I am reaching out is that I am with <span><?php echo $company_info->company_name ?></span> and know a lot of  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> often have challenges with:
        </p>
    
    <p>
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you.</p>

    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    
    <br><br>
        <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 168) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Value Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>I want to follow up with you on an email that I sent you last week. The reason I am reaching out is that I am with 
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 169) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>.</p> 
                    <p>This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you.</p>
					<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 170) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" or have some thoughts to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 171) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo trim($product_desc->value); ?>.</p>
		        <p>Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 172) {//pre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>                
<?php
}
//LinkedIn Connection Accept Follow-Up Thread - Value/Pain/Name Drop/Qualify/Product/Last Attempt
else if ($content_id == 173) {//linkedin-value-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Value Message</strong></p><?php }?>
<p><strong>Subject line:</strong> Thanks for connecting</p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>Great to add you to my network. I came across your profile because we help <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?> to:
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>
        <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 174) {//linkedin-value-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Pain Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I want to follow up with you on an email that I sent you last week. The reason that I am reaching out to you is that I know a lot of 
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?> often have challenges with:    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>

    <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
    
    <br><br>
        <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 175) {//linkedin-value-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you. I will try to give you a call next week.</p>
					<p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 176) {//linkedin-value-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 177) {//linkedin-value-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 178) {//linkedin-value-thread
?>

<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php
}
//LinkedIn Connection Accept Follow-Up Thread - Pain/Value/Name Drop/Qualify/Product/Last Attempt
else if ($content_id == 179) {//linkedin-pain-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Pain Message</strong></p><?php }?>
<p><strong>Subject line:</strong> Thanks for connecting</p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>Great to add you to my network. I came across your profile because I work witha lot of 
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> and they often have challenges with:
        </p>
    
    <p>
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>

    <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
    
    <br><br>
        <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 180) {//linkedin-pain-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Value Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>I want to follow up with you on an email that I sent you last week. The reason I am reaching out is that I am with 
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>
        <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 181) {//linkedin-pain-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you. I will try to give you a call next week.</p>
					<p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
				
					<br><br>
        <p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 182) {//linkedin-pain-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>

<br><br>
        <p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 183) {//linkedin-pain-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 184) {//linkedin-pain-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
                
<?php
}
//********************************************* end of EMAILS AND LETTERS ***************************//
//********************************************* VOICEMAIL SCRIPTS ***************************//
else if ($content_id == 112) {//voicemail-script-technical-value
?>
<br/>
				<p>Hello <span class="red-area">{contact first name}</span>
				
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
				<br/>
<?php 
}else if ($content_id == 113) {//voicemail-script-technical-pain
?>
<br/>
			<p>Hello <span class="red-area">{contact first name}</span>
				
				   this is <?php echo $aMember['yname']; ?> from <?php echo $company_info->company_name; ?>.
				
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
				<p>
					I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.
				</p>
				<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?>, <?php echo $aMember['yphone']; ?>.</p>
				<p>Thank you and I look forward to talking with you soon.</p>
			<br>
<?php 
}else if ($content_id == 114) {//voicemail-name-drop-focus
?>
<br>
			<p>Hello <span class="red-area" >[Prospect Name] </span>, this is <?php echo $aMember['yname']; ?>  from <?php echo $company_info->company_name; ?> . </p>
			<p>
				Purpose for my call is that 
				We worked with  <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?> and this led to <?php  echo  $active_name_drop_exp['when']->value; ?>.				</p>
			<p><span class="red-area"> (Optional disqualify statement) </span>I actually do not know if we can help you in the same way and that is why I was calling you with a question or two.</p>
			<p>I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.</p>
			<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?> ,  <?php echo $aMember['yphone']; ?>.</p>
			<p>Thank you and I look forward to talking with you soon.</p>
			<br>
<?php 
}else if ($content_id == 115) {//voicemail-script-product
?>
<br/>
			<p>Hello <span class="red-area" >[Prospect Name] </span>, this is <?php echo $aMember['yname']; ?>  from <?php echo $company_info->company_name; ?> . </p>
			<p>
				Purpose for my call is that we provide <?php echo $P_Q1->value; ?>. 
				
			</p>
			<p><span class="red-area"> (Optional disqualify statement) </span>I actually do not know if we can help you in the same way and that is why I was calling you with a question or two.</p>
			<p>I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $aMember['yphone']; ?>.</p>
			<p>Again, this is <?php echo $aMember['yname']; ?> calling from <?php echo $company_info->company_name; ?> ,  <?php echo $aMember['yphone']; ?>.</p>
			<p>Thank you and I look forward to talking with you soon.</p>
			<br/>
<?php 
}
//********************************************* End of VOICEMAIL SCRIPTS ***************************//
//********************************************* Key Questions ***************************//
else if ($content_id == 35) {//Value Statement - networking-question / meeting-over-coffee-questions
	?><p> <span class="red-area"> (When they ask you what you do, share one of below) </span> </p>
		We help  
                        <span class="dynamic_value edit_area_old" id=""><?php 
                            if($campaign_info->campaign_target == '1'){	
                                    echo $campaign_info->individual;
                                }else{
                                    echo $campaign_info->organization;
                            }
                        ?></span> to:<br />
    <ul>
        
        <?php if (isset($campaign_output_tech_val)):?>
                    <?php foreach ($campaign_output_tech_val as $single_tech_val):?>
                        <li> <span class="<?php echo 'dynamic_value ' ;?>" id="tvd_<?php echo $single_tech_val->tech_v_id ?>_<?php  echo $campaign_info->campaign_id; ?>"><?php echo $single_tech_val->value;?></span></li>
                    <?php endforeach;?>
        <?php endif;?>
        
        <li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $campaign_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($campaign_tech_summary->value) ? $campaign_tech_summary->value : NULL);?></span>.
        </li>
       
    </ul><?php
} else if ($content_id == 36) {//Closing Questions - closing-questions
	?><strong>Trial Closing Questions</strong><hr />
    	<p><strong>Description</strong> These are trial closing questions that check in with the prospect to gather details on what they are thinking. These questions should be asked during each stage of the sales cycle.</p>
        <ul>
            <li>What do you think of what we have discussed so far?</li>
            <li>How would that feature help your operation?</li>
            <li>Is this something you could see your employees (organization) using?</li>
            <li>Are we heading in the right direction?</li>
            <li>Does this agenda match up with your expectations today?</li>
            <li>Is this what you were expecting to see?</li>
        </ul><br>            
			<strong>Soft Closing Questions</strong><hr />
            <p><strong>Description</strong> These are questions that try to softly close the prospect by letting them lead to the next step. If you have done a good job of qualifying, finding pain, building interest, and building rapport, you can softly close and still see consistent forward movement. Soft closing can have a very positive impact on the level of rapport and the quality of leads that are in your pipeline.</p>
            <ul>
                <li>What would you like to do next?</li>
                <li>What direction would you like to go in?</li>
                <li>Do you want to continue talking about this?</li>
                <li>When would you like to talk again?</li>
            </ul>
            <br>           
			<strong>Hard Closing Questions</strong><hr />
            <p><strong>Description</strong> These are hard closing questions that apply a little more directness and pressure for forward movement. These questions can trigger action, but they can also have a negative impact on rapport.</p>
            <ul>
                <li>Are you ready to move forward to the next step in the process?</li>
                <li>What would you need to be able to make a commitment to move forward?</li>
                <li>If you had everything that you want, are you prepared to move forward?</li>
                <li>If we were able to give you what you are asking for, would you be able to move forward with the purchase?</li>
                <li>When are you going to make your final decision?</li>
                <li>(If delaying the decision for a period of time - X months) OK, but do you mind if I ask if there will be a change or something different at that time that will make that a better time to look at moving forward?</li>
                <li>Is there anything that is preventing you from being able to move forward with this purchase?</li>
            </ul><br><?php
} /*else if ($content_id == 37) {//Hard Qualifying Questions - hard-qualifying-questions
	?><strong>Need vs. Want Questions</strong><hr />
    	<p><strong>Description:</strong> These are hard qualifying questions to determine if there prospect's level of interest is more built on a true need or if it is more of a "want". If it is a want, the prospect is not as qualified.</p>
			<ul>
                <li>What happens if you do not do anything and do not make a purchase or make any changes?</li>
                <li>What improvements will you see if move forward with this purchase?</li>
                <li>Is there at date when this purchase needs to be made?</li>
                <li>What happens if the purchase is not made by that date?</li>
                <li>What is the time frame that the project needs to work along?</li> 
            </ul><br>            
			<strong>Availability of Funding Questions</strong><hr />
            <p><strong>Description:</strong> These are hard qualifying questions to determine how available funding is should the prospect decide to move forward with a purchase.</p>
			<ul>
                <li>Is there a budget approved for this project?</li>
                <li>What is the budget range that the project needs to fit in?</li>
                <li>Have the funds been allocated to this purchase?</li>
                <li>What budget (department) will this purchase be made under?</li>
                <li>Are there other purchases that this funding may end being used for?</li>
                <li>How does the project fit with other initiatives from a priority standpoint?</li> 
            </ul>
            <br />            
			<strong>Decision Making Authority Questions</strong><hr />
            <p><strong>Description:</strong> These are hard qualifying questions to determine how much purchasing and decision making power the prospect has.</p>
			<ul>
                <li>What is the decision making process?</li>
                <li>What parties will be involved in making the decision?</li>
                <li>What functional areas (departments) will be impacted by the purchase?</li>
                <li>Who is the ultimate decision maker?</li>
                <li>Who is the person that will need to sign the agreement/contract?</li> 
            </ul><br>            
			<strong>Level of Competition Questions</strong><hr />
            <p><strong>Description:</strong> These are hard qualifying questions to determine how much competition you have.</p>
			<ul>
                <li>Why did you take time out of your schedule to meet with us? Why did you contact us?</li>
                <li>What other options are you considering?</li>
                <li>How do you feel about their solution (product)?</li>
                <li>What do you like about their solution (product)?</li>
                <li>What do you not like about their solution (product)?</li>
                <li>How does their solution (product) compare with what we have to offer?</li>
                <li>Is there a reason why you would choose us?</li>
                <li>If you had to make a decision today, which way would you lean?</li>
                <li>What are the key factors that the decision to purchase will be based on?</li>  
            </ul>
            <br/><?php
} 
*/else if ($content_id == 38) {//Pre-Qualifying Questions - pre-qualifying-questions
	?><br/>
	<?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?>
    <br/><?php
}
//********************************************* End of Key Questions ***************************//
//********************************************* Interview Emails ***************************//
 else if ($content_id == 191) {//pre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Value Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>The reason I am reaching out is that I am with   
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:<?php /*?> deal with <?php echo  $campaign_output_tech_pain[0]->value ; ?>.<?php */?>
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you.</p>
        <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p><br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 192) {//ipre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Pain Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>I want to follow up with you on an email that I sent you last week. The reason that I am reaching out to you is that  
        <?php 
            if($campaign_info->campaign_target == '1'){	
                     echo $campaign_info->individual;
                }else{ 
                    echo $campaign_info->organization;
                }
        ?> can have challenges with:    
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you.</p>

    <p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
    <br><br>
    <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 193) {//ipre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you.</p>
					<p>Are you available for <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
					<br><br>
					<p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 194) {//ipre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>
<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 195) {//ipre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
				<br><br>
		        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 196) {//ipre-call-email-thread
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
		        <br><br>
				<p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
<?php
} else if ($content_id == 197) {//ipre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #1 - Pain Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_pain) && $campaign_output_tech_pain) echo ucfirst($campaign_output_tech_pain[0]->value) ?></p>		        
    
    <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
    
    <p>The reason I am reaching out is that I am with <span><?php echo $company_info->company_name ?></span> and know a lot of  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> often have challenges with:
        </p>
    
    <p>
        <ul>
        <?php if(isset($campaign_output_tech_pain)){
            foreach($campaign_output_tech_pain as $comp){	?>
                <li>
                <?php echo ucfirst($comp->value) ?>
                </li>
            <?php 
            }
        }
        ?>
        </ul>
    </p>
    <p>I don't know if you are concerned about any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>

    <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
    <br><br>
    <p>Best Regards,</p>
    <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 198) {//ipre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #2 - Value Message</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>		        
        
        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
        
        <p>I want to follow up with you on an email that I sent you last week. The reason I am reaching out is that I am with 
            <span><?php echo $company_info->company_name ?></span> and we help  
            <?php 
                if($campaign_info->campaign_target == '1'){	
                         echo $campaign_info->individual;
                    }else{ 
                        echo $campaign_info->organization;
                }
            ?> to:
        </p> 
        
        <p><?php /*?>We do this by helping to drive the following improvements:<?php */?>
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
        
        <p>I don't know if you are interested in any of those and that is why I am reaching out to you. I will try to give you a call next week.</p>
        <p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
        <br><br>
        <p>Best Regards,</p>
        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 199) {//ipre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #3 - Name Drop Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong><?php if(isset($campaign_output_tech_val) && $campaign_output_tech_val) echo ucfirst($campaign_output_tech_val[0]->value);?></p>
					
					<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                    <p>One of the reasons I am reaching out to you is that we worked with <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> and provided <?php  echo $active_name_drop_exp['worked']->value; ?>. This helped them to <?php  echo  $active_name_drop_exp['provided']->value; ?>, which led to <?php  echo  $active_name_drop_exp['when']->value; ?>.</p>					
					<p>I don't know if we can help you in the same way and that is why I am reaching out to you. I will try to give you a call next week.</p>
					<p>If you are interested in talking before then, I can schedule <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
					<br><br>
					<p>Best Regards,</p>
					
					<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 200) {//ipre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #4 - Qualify Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_tech_qualify) && $campaign_output_tech_qualify) echo ucfirst($campaign_output_tech_qualify[0]->value);?></p>		
<p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
<p>I am trying to determine if it makes sense for us to talk at some point. Here are some of the questions that I would ask you to get a better idea on that:	
	<ul>
	<?php if(isset($campaign_output_tech_qualify)){
		foreach($campaign_output_tech_qualify as $comp){	?>
			<li>
			<?php echo ucfirst($comp->value) ?>
			</li>
		<?php 
		}
	}
	?>
	</ul>
</p>
<p>If you answer "Yes" to any of those, we could likely have a very productive conversation.</p>
<p>Let me know if you are interested in putting a few minutes on the calendar.</p>
<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 201) {//ipre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #5 - Product Message</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong>  <?php echo ucfirst($P_Q1->value); ?> </p>
		        
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
                <p>If we were to meet and determine that we might be able to help you, it might lead us in a direction of talking about our <?php echo $P_Q1->value; ?>.</p>
		        <p>What that provides is <?php echo $product_desc->value; ?>. Some ways that this differs from other options out there are:</p>
                <ul>
                	<li><?php echo ucfirst($diff1->value); ?></li>
                    <li><?php echo ucfirst($diff2->value); ?></li>
                    <li><?php echo ucfirst($diff3->value); ?></li>
                </ul>
				<p>Are you interested in <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>?</p>
		        <br><br>
		        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br />
<?php
} else if ($content_id == 202) {//ipre-call-email-thread-v3
?>
<?php if(!isset($edittemp)){?><p><strong>Email #6 - Last Attempt</strong></p><p><strong>Schedule Delivery: 1 to 2 weeks</strong></p><?php }?>
<p><strong>Subject line:</strong> Checking In</p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>Hope all is well. I never heard back from you and sometimes "no response" is indeed a response, but I thought I would follow up with you one last time.</p>
		        
				<p>The reason I am trying to connect with you is that we help 
		        
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?>
					with some of the below areas.</p>
		        
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
				
		        <p>If I don't hear back from you, I will assume that you are the not right person to speak with or that those are improvements that you are not interested and I will close the file.</p>
		        <p>No problem if that is the direction you prefer. If I should be contacting someone else regarding this, I would greatly appreciate any pointing in the right direction that you can provide.</p>
		        <br><br>
				<p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>
                
<?php
}else if ($content_id == 186) {//iautomated-screening-interview-email
?>
<p><strong>Subject line:</strong> Automated Interview with <?php echo $company_info->company_name ?> for the <?php 
if($job_post) echo $job_post['job_title']; ?> position </p>		        

<p>Hello <span class="dynamic_value">[Applicant Record First Name]</span>,</p>

<p>Thank you for applying to <?php echo $company_info->company_name ?>  for the <?php
if($job_post) echo $job_post['job_title'] ?> position. </p>
<p>The first step in our process is for you to call into [insert phone number that has a voicemail box set up specifically for this] and provide answers to any of the three questions. </p>
<p> 1. [insert question 1]</p> 
<p> 2. [insert question 2] </p>
<p> 3. [insert question 3] </p>
<p>This automated process is designed to minimize the amount of time and effort you have to spend while we try to learn a little more information about you in order to determine how well you fit with this position</p>
<p>
<p>Once we review your answers, we will be back in touch with you to discuss any next potential steps.</p>
<p>Thank you and we look forward to learning more about you.</p>
<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br>
<?php
}else if ($content_id == 187) {//schedule-phone-interview-email
?>
<p><strong>Subject line:</strong> Phone interview with <?php  echo $company_info->company_name ?> for the <?php 
if($job_post) echo $job_post['job_title']; ?> position </p>		        

<p>Hello <span class="dynamic_value">[Applicant Record First Name]</span>,</p>

<p>Thank you for applying to <?php  echo $company_info->company_name ?>.</p>

<p>I would like to have a phone discussion about your application for the <?php if($job_post) echo $job_post['job_title'] ?> role.</p>

<p>I'd like to learn a little more about you and share some information about <?php  echo $company_info->company_name ?> and the <?php 
if($job_post) echo $job_post['job_title'] ?> position.</p>
<p>Would you be available for a short introductory phone call?</p>
<p>Looking forward to hearing from you,</p>

<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br>
<?php
}else if ($content_id == 189) {// schedule-interview-email
?>
<p><strong>Subject line:</strong> Interview with  <?php  echo $company_info->company_name ?> for the <?php if($job_post) echo $job_post['job_title']; ?> position </p>		        
<p>Hello [Applicant Record First Name],</p>

<p>Thank you for applying to <?php  echo $company_info->company_name ?>.</p>
<p>Your application for the <?php if($job_post) echo $job_post['job_title']; ?> position stood out to us and we would like to invite you for an interview.</p>
<p>You will meet with [insert either title or name of interviewer]. The interview will last about [X] minutes and you'll have the chance to discuss the <?php if($job_post) echo $job_post['job_title']; ?> position and learn more about our company.</p>
<p>Would you be available on [insert suggested date(s) and time(s)]?</p>
<p>Thank you and we look forward to meeting with you.</p>


<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br/>
<?php
}else if ($content_id == 188) {//ischedule-second-interview-email
?>
<p><strong>Subject line:</strong>Invitation for second interview with <?php  echo $company_info->company_name ?> for the <?php if($job_post) echo $job_post['job_title']; ?> position</p>
		        
<p>Hello [Applicant Record First Name],</p>
<p>Thank you for taking the time to meet with us to discuss the <?php if($job_post) echo $job_post['job_title']; ?> position. We enjoyed getting to know you and we'd like to invite you for a second interview at our office.</p>
<p>Your interview will be with [insert either title or name of interviewer] and will last approximately [X] minutes.</p>
<p>Would you be available on [insert suggested date(s) and time(s)]?</p>
<p>Thank you and we look forward to meeting with you again.</p>

<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<br>
<?php
}else if ($content_id == 190) {//icandidate-rejection-letter-email
?>
<p><strong>Subject line:</strong>Your application to <?php  echo $company_info->company_name ?></p>
		        
<p>Dear [Applicant Record First Name],</p>
<p>Thank you for taking the time to consider <?php  echo $company_info->company_name ?>. After careful consideration, we regret to inform you that we will not be pursuing your application for the <?php if($job_post) echo $job_post['job_title']; ?> position.</p>
<p>We will retain your information in our candidate database and if we find you to be a fit for any of our future job postings, we will be sure to reach back out to you.</p>
<p>Thank you for your application. We wish you all the best in your career search.</p>

<br><br>
<p>Best Regards,</p>
<?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
<?php
}

else if ($content_id == 212) {//icandidate-rejection-letter-email
	if (isset($campaign_output_qualify)) echo $campaign_output_qualify;
}
else if ($content_id == 204 ||  $content_id == 208) {//icandidate-rejection-letter-email
	if (isset($need_want_qus)) echo $need_want_qus."<br/>"; 
	else { 
		if(isset($Need_Want)){
		?>
		<ul>
			<?php
				foreach($Need_Want as $qns){
			?>
			<li><?php echo $qns; ?></li>
			<?php } ?>
		</ul><br>
	<?php }
	}  
}

else if ($content_id == 205 ||  $content_id == 209) {//icandidate-rejection-letter-email
  if (isset($funding_availability)) echo $funding_availability."<br/>"; 
	else { 
		if(isset($Funding_Availability)){
		?>
		<ul>
			<?php
				foreach($Funding_Availability as $qns){
			?>
			<li><?php echo $qns; ?></li>
			<?php } ?>
		</ul><br>
	<?php }
	}  
}


 else if ($content_id == 227) {//pre-call-email-thread
 $findproduct = $this->productModel->getProduct($campaign_info->product_id,'P_Q1');
 $campaign_output_per_pain = $this->campaign->getOutputTechPain($campaign_info->campaign_id,1);
 $campaign_output_tech_val = $this->campaign->getOutputTechValue($campaign_info->campaign_id,1);
 //echo '<pre>'; print_r($campaign_output_tech_pains ); echo '</pre>';
?>
<p><strong>Subject line:</strong> <?php if(isset($campaign_output_per_pain[0]->value)) echo $campaign_output_per_pain[0]->value; ?></p>
		        <p>Hello <span class="dynamic_value">{contact first name}</span>,</p>
				
				<p>I  work with a lot of {contact title}s and they often find it very difficult to <?php if(isset($campaign_output_per_pain[0]->value)) echo $campaign_output_per_pain[0]->value; ?>.
		        
				<p>The reason for the message is that we help solve this challenge through our <?php if(isset($findproduct->product_name)) echo $findproduct->product_name; ?>.
				
		        <p>Would love to have a brief chat with you to see if we can help your company to <?php if(isset($campaign_output_tech_val[0]->value)) echo $campaign_output_tech_val[0]->value; ?>.</p>
                
		        <p>Here is a link to my calendar to schedule a brief call - </p>
				<br><br>
        <p>Best Regards,</p>
		        <?php if(isset($email_signature) && $email_signature) echo '{email signature}'; else echo '[Email Signature]';?>
		        <br>                
<?php 
}

else if ($content_id == 206 ||  $content_id == 210) {
  if (isset($decision_authority)) echo $decision_authority."<br/>"; 
	else { 
		if(isset($Decision_Authority)){
		?>
		<ul>
			<?php
				foreach($Decision_Authority as $qns){
			?>
			<li><?php echo $qns; ?></li>
			<?php } ?>
		</ul><br>
	<?php }
	}  
}


else if ($content_id == 207 ||  $content_id == 211) {
  if (isset($intent_purchase)) echo $intent_purchase."<br/>"; 
	else { 
		if(isset($Competition_Level)){
		?>
		<ul>
			<?php
				foreach($Competition_Level as $qns){
			?>
			<li><?php echo $qns; ?></li>
			<?php } ?>
		</ul><br>
	<?php }
	}  
}

//********************************************* End of Interview Emails ***************************//
?>