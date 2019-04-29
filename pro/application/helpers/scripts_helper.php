<?php
	//List Qualify question responses with editable html format
	//http://salesscripter.com/betapro/step/qualifying
	function qualify_resplist_htmledit_view($qid,$campgid,$qp=0,$level=1,$qrclass) {
		$CI =get_instance();
		$CI->load->model('campaign_model','campaign');
		if($qresponses =$CI->campaign->getQualifyResponses($qid,$campgid,$qp)){
			foreach($qresponses as $qresp) {
            	$qresponses_reply =$CI->campaign->getQualifyResponses($qid,$campgid,$qresp->qr_id);
				if(!$qresponses_reply) return;
				$qres_reply = $qresponses_reply[0];
	            $qreply_desc = $qres_reply->qr_response;
				$qrclass2 = $qrclass." qr_".$qresp->qr_id;
        ?>
                <tr class="TechQualifyTrClass <?php echo $qrclass2; ?>" id="qrid_<?php echo $qresp->qr_id; ?>">
                    <td class="no-border qrlevel" width="70%" align="left" id="ansListhQR<?php echo $qres_reply->qr_id;?>">
                            <div style="width:<?php echo ($level*24);?>px;" class="qrbox1"><div class="qrlevelborder" style="width:<?php echo ($level*24+3);?>px;"></div></div>
                            <div class="qrbox2" style="margin-left:-<?php echo ($level*24+$level*12);?>px;">Prospect Response: <span class="TextColor"><?php echo $qresp->qr_response;?></span>
                            
                            </div>
                    </td>
                    <td class="no-border" style="width: 30%;">
                        <div class="grid5">    
                        	<div class="answerbox">
                                <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('QR<?php echo $qres_reply->qr_id;?>',14,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('QR<?php echo $qres_reply->qr_id;?>',24,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                <div id="ansListQR<?php echo $qres_reply->qr_id;?>"></div>
                            </div>                                                
                            <textarea class="validate[required] gansQR<?php echo $qres_reply->qr_id;?>" name="qrtbl[tqd][<?php echo $qres_reply->qr_id;?>]" style="width:500px;" cols="" rows=""><?php echo $qreply_desc;?></textarea>   
                            
                            <div style="margin-top:20px;">
                                <div><input type="checkbox" value="1" <?php if(!$qres_reply->visible) echo 'checked="checked"'; ?>  onchange="updateTechDisplay(<?php echo $qres_reply->qr_id; ?>,this,1);" /> Do not display answer in templates</div>
                                <div style="margin-top:10px;"> 
                                   <input type="checkbox" value="1" <?php if($qres_reply->highlight) echo 'checked="checked"';?> onChange="updateTechHighlightAnswer(<?php echo $qres_reply->qr_id; ?>,this,1);" /> Highlight answer in sales scripts
                                </div><br />
                            	<div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_qresponse(<?php echo $qid;?>,<?php echo $qres_reply->qr_id;?>)">Add a Follow-Up Question</a></div></div>                      
                        </div>
                    </td>
                    <td class="no-border" colspan="2" >
                        <div class="grid5">
                            <div align="center"><span class="ui-icon ui-icon-closethick" onclick="delresp(<?php echo $qresp->qr_id; ?>);">X</span></div>
                            <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                        </div>
                    </td>
                </tr>
        <?php 
				qualify_resplist_htmledit_view($qid,$campgid,$qres_reply->qr_id,$level+1,$qrclass2);
			}
        }
	}
	
	
	
	function sales_resplist_htmledit_view($qid,$campgid,$qp=0,$level=1,$qrclass) {
		$CI =get_instance();
		$CI->load->model('campaign_model','campaign');
		if($qresponses =$CI->campaign->getSalesResponses($qid,$campgid,$qp)){
			foreach($qresponses as $qresp) {
				//echo '<pre>'; print_r($qresp); echo '</pre>';
            	$qresponses_reply =$CI->campaign->getSalesResponses($qid,$campgid,$qresp->qr_id);
				if(!$qresponses_reply) return;
				$qres_reply = $qresponses_reply[0];
	            $qreply_desc = $qres_reply->qr_response;
				$qrclass2 = $qrclass." qr_".$qresp->qr_id;
        ?>
                <tr class="SalesQuestionTrClass <?php echo $qrclass2; ?>" id="qrid_<?php echo $qresp->qr_id; ?>">
                    <td class="no-border qrlevel" width="70%" align="left" id="ansListhQR<?php echo $qres_reply->qr_id;?>">
                            <div style="width:<?php echo ($level*24);?>px;" class="qrbox1"><div class="qrlevelborder" style="width:<?php echo ($level*24+3);?>px;"></div></div>
                            <div class="qrbox2" style="margin-left:-<?php echo ($level*24+$level*12);?>px;">Prospect Response: <span class="TextColor"><?php echo $qresp->qr_response;?></span>
                            	
                            </div>                    </td>
                    <td class="no-border" style="width: 30%;">
                        <div class="grid5">  
                            <textarea class="validate[required] gansQR<?php echo $qres_reply->qr_id;?>" name="qrtbl[tqd][<?php echo $qres_reply->qr_id;?>]" style="width:500px;" cols="" rows=""><?php echo $qreply_desc;?></textarea>
                            <div style="margin-top:20px;">
                                <div><input type="checkbox" value="1" <?php if(!$qres_reply->visible) echo 'checked="checked"'; ?>  onchange="updateNeedDisplay(<?php echo $qres_reply->qr_id; ?>,this,1);" /> Do not display answer in templates</div>
                                <div style="margin-top:10px;"> 
                                   <input type="checkbox" value="1" <?php if($qres_reply->highlight) echo 'checked="checked"';?> onChange="updateNeedHighlight(<?php echo $qres_reply->qr_id; ?>,this,1);" /> Highlight answer in sales scripts
                                                        </div><br />
                            	<div align="center"><a href="javascript:void(0);" class="buttonM bRed" onclick="show_fquestions(<?php echo $qid;?>,<?php echo $qres_reply->qr_id;?>)">Add a Follow-Up Question</a></div></div>
                        </div>
                    </td>
                    <td class="no-border" colspan="2" >
                        <div class="grid5">
                            <div align="center"><span class="ui-icon ui-icon-closethick" onclick="delsresp(<?php echo $qresp->qr_id; ?>);">X</span></div>
                            <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                        </div>
                    </td>
                </tr>
        <?php 
				sales_resplist_htmledit_view($qid,$campgid,$qres_reply->qr_id,$level+1,$qrclass2);
			}
        }
	}
	
	
	
	//CRM METHODS
	
	//Import Fields
	function import_fields($table = 'contact') {
		$CI =get_instance();
		$custom = $CI->_data['custom'];
		$customa = $CI->_data['customa'];
		if($table == 'contact') {
			$contacts = array(
						'user_prefix'=>'Salutation',
						'user_first'=>'First Name',
						'user_last'=>'Last Name',
						'account'=>'Account Name',
						'user_title'=>'Title',
						'department'=>'Department',
						'birthdate'=>'Birthdate(mm/dd/yyyy)',
						'target'=>'Target Contact(y/n)',
						'phone'=>'Phone',
						'mobile'=>'Mobile',
						'other_phone'=>'Other Phone',
						'lead_source'=>'Lead Source',
						'email'=>'Email',
						'assistant'=>'Assistant',
						'asst_phone'=>'Asst. Phone',
						'street'=>'Mailing Street',
						'city'=>'Mailing City',
						'state'=>'Mailing State/Province',
						'zipcode'=>'Mailing Zip/Postal Code',
						'country'=>'Mailing Country',
						'description'=>'Description',
						'website'=>'Website',
						'linkedin'=>'LinkedIn Profile',
						//'custom1_value'=>$custom['field1'],
						//'custom2_value'=>$custom['field2'],
						//'custom3_value'=>$custom['field3']
						);
					$contacts=array_merge($contacts,$custom);
				return 	$contacts;	
		} else if($table == 'account') {
			$accounts = array(
						'account_name'=>'Account Name',
						'account_number'=>'Account Number',
						'account_site'=>'Account Site',
						'account_type'=>'Type',
						'industry'=>'Industry',
						'revenue'=>'Annual Revenue',
						'rating'=>'Rating',
						'target'=>'Target Account(y/n)',
						'phone'=>'Phone',
						'fax'=>'Fax',
						'website'=>'Website',
						'ticker_symbol'=>'Ticker Symbol',
						'ownership'=>'Ownership',
						'employees'=>'Employees',
						'siccode'=>'SIC Code',
						'bstreet'=>'Billing Street',
						'bcity'=>'Billing City',
						'bstate'=>'Billing State/Province',
						'bzipcode'=>'Billing Zip/Postal Code',
						'bcountry'=>'Billing Country',
						'customer_priority'=>'Customer Priority',
						'sla_expdate'=>'SLA Expiration Date',
						'numlocations'=>'Number of Locations',
						'active'=>'Active',
						'sla'=>'SLA',
						'sla_serialno'=>'SLA Serial Number',
						'upsell_oppt'=>'Upsell Opportunity',						
						'description'=>'Description'
						//'custom1_value'=>$custom['field1'],
						//'custom2_value'=>$custom['field2'],
						//'custom3_value'=>$custom['field3']
						);
					$accounts=array_merge($accounts,$customa);
				return 	$accounts;
		} 
		return array();
	}
	//Qualifier Questions
	function qualifier_questions() {
		
		$qualifier_questions = array(
							"Need_Want" => array(
								/*"What happens if you do not do anything and do not make a purchase or make any changes?",
								"What improvements will you see if move forward with this purchase?",
								"Is there at date when this purchase needs to be made?",
								"What happens if the purchase is not made by that date?",
								"What is the time frame that the project needs to work along?"*/
								"What motivated you to look at us (brought you to us)?",
								"What are you doing today in this area?",
								"What is working well today? What is not?",
								"What will it mean to you if you make this purchase?",
								"Will there be any challenges for you if you do not purchase something in this area?",
								"Is there at date when this purchase needs to be made?",
								"What happens if the purchase is not made by that date?",
								"What is the time frame that the project needs to work along?",
								), 
							"Funding_Availability" => array(
								"Is there a budget approved for this project?",
								"What is the budget range that the project needs to fit in?",
								"Have the funds been allocated to this purchase?",
								"What budget (department) will this purchase be made under?",
								"Are there other purchases that this funding may end up being used for?",
								"How does the project fit with other initiatives from a priority standpoint?"
								), 
							"Decision_Authority" => array(
								"What is the decision making process?",
								"What parties will be involved in making the decision?",
								"What functional areas (departments) will be impacted by the purchase?",
								"Who is the ultimate decision maker?",
								"Who is the person that will need to sign the agreement/contract?"
								), 
							"Competition_Level" => array(
								"Why did you take time out of your schedule to meet with us? Why did you contact us?",
								"Do you recall what originally motivated you reach out and contact us?",
								"What other options are you considering?",
								"How far along are you with talking with them?",
								"How do you feel about their solution?",
								"What do you like about their solution?",
								"What do you not like about their solution?",
								"How does their solution (product) compare with what we have to offer?",
								"Is there a reason why you would choose us?",
								"If you had to make a decision today, which way would you lean?"
								) 
							);
							$qualifier_sections = array(
								1=>"Pre-Qualifying",
								2=>"Need vs. Want",
								3=>"Funding Availability",
								4=>"Decision Authority",
								5=>"Competition Level",
								);
		return array("questions"=>$qualifier_questions,"sections"=>$qualifier_sections);
	
	}
	
	//Interaction options
	function crm_introptions() {
		$CatgintOptions = array(
					//Category	Phone Call
					1=>array(
						//Section
						1=>array(
							'name'=>'Phone Call',
							'options'=>array(
								1=>array('name'=>'You called them',					'points'=>0,'pursuit'=>1,'label'=>'Calls Made'),
								2=>array('name'=>'They answered your call',			'points'=>1,'pursuit'=>0,'label'=>'Calls Answered'),
								3=>array('name'=>'They did not answer your call',	'points'=>0,'pursuit'=>0,'label'=>'Calls Unanswered'),
								4=>array('name'=>'They called you',					'points'=>5,'pursuit'=>0,'label'=>'Calls Received'),
								5=>array('name'=>'You left a voicemail',			'points'=>0,'pursuit'=>1,'label'=>'Voicemails Left'),
								6=>array('name'=>'You did not leave a voicemail',	'points'=>0,'pursuit'=>0,'label'=>'Calls with No Voicemail Left')
							)
						),//end of Section
					),
					//Category	Email
					2=>array(
						//Section
						1=>array(
							'name'=>'Email',
							'options'=>array(
								1=>array('name'=>'You sent them an email',					'points'=>0,'pursuit'=>1,'label'=>'Emails Sent'),
								5=>array('name'=>'They opened the email',					'points'=>1,'pursuit'=>0,'label'=>'Emails Opened'),
								7=>array('name'=>'They clicked on a link you your email',	'points'=>3,'pursuit'=>0,'label'=>'Email Links Clicked'),
								2=>array('name'=>'They responded to your email',			'points'=>3,'pursuit'=>0,'label'=>'Emails Responded To'),
								8=>array('name'=>'They forwarded your email',				'points'=>1,'pursuit'=>0,'label'=>'Emails Forwarded'),
								9=>array('name'=>'They introduced you to someone',			'points'=>3,'pursuit'=>0,'label'=>'Email Introductions'),
								3=>array('name'=>'They did not respond to an email',		'points'=>0,'pursuit'=>0,'label'=>'Emails Not Responded To'),
								4=>array('name'=>'They sent you an email',					'points'=>5,'pursuit'=>0,'label'=>'Emails Received'),
								6=>array('name'=>'Contact Unsubscribed',					'points'=>-5,'pursuit'=>0,'label'=>'Contacts that Unsubscribed'),
							)
						),//end of Section
					),
					//Category	Meeting
					5=>array(
						//Section
						1=>array(
							'name'=>'Meeting',
							'options'=>array(
								1=>array('name'=>'You had a meeting',									'points'=>5,'pursuit'=>5,'label'=>'Meetings Held'),
								2=>array('name'=>'You went to meet at their office',					'points'=>0,'pursuit'=>2,'label'=>"Meetings at the Prospect's Office"),
								3=>array('name'=>'They came to your office',							'points'=>2,'pursuit'=>0,'label'=>"Meetings at the Salesperson's Office"),
								4=>array('name'=>'They were on time',									'points'=>1,'pursuit'=>0,'label'=>'Meetings that Prospects Were On Time'),
								5=>array('name'=>'They were late',										'points'=>-1,'pursuit'=>0,'label'=>'Meetings that Prospects Were Late'),
								6=>array('name'=>'They asked to reschedule',							'points'=>-2,'pursuit'=>0,'label'=>'Meetings that Prospects Asked to Reschedule'),
								7=>array('name'=>'They invited/brought other people to the meeting',	'points'=>2,'pursuit'=>0,'label'=>'Meetings that Prospects Invited Other People To')
								
							)
						),//end of Section
					),
					//Category	Marketing
					6=>array(
						//Section
						1=>array(
							'name'=>'Marketing',
							'options'=>array(
								1=>array('name'=>'You invited them to an event',					'points'=>0,'pursuit'=>1,'label'=>'Prospects Invited to Events'),
								2=>array('name'=>'They registered for an event',					'points'=>3,'pursuit'=>0,'label'=>'Prospects that Registered for Events'),
								3=>array('name'=>'They attended your event',						'points'=>5,'pursuit'=>0,'label'=>'Prospects that Attended Events'),
								4=>array('name'=>'They visited your website',						'points'=>5,'pursuit'=>0,'label'=>'Prospects that Visited the Website'),
								5=>array('name'=>'They signed up for your newsletter',				'points'=>5,'pursuit'=>0,'label'=>'Prospects that Signed Up for Newsletter'),
								6=>array('name'=>'They download marketing documents',				'points'=>5,'pursuit'=>0,'label'=>'Prospects that Downloaded Marketing Documents'),
								7=>array('name'=>'They visited your booth at an event',				'points'=>3,'pursuit'=>0,'label'=>'Prospects that Visited Booths at Events'),
								8=>array('name'=>'You sent a direct mail marketing piece',			'points'=>0,'pursuit'=>3,'label'=>'Prospects that Were Sent Direct Mail Marketing Items'),
								9=>array('name'=>'They responded to a direct mail marketing piece',	'points'=>5,'pursuit'=>0,'label'=>'Prospects that Responded to Direct Mail Marketing'),
								10=>array('name'=>'They submitted an inquiry through your website',	'points'=>3,'pursuit'=>0,'label'=>'Prospects that Submitted Inquiries Through Website')
							)
						),//end of Section
					),
					//Category	Networking
					3=>array(
						//Section
						1=>array(
							'name'=>'Networking',
							'options'=>array(
								1=>array('name'=>'You started a conversation with them',	'points'=>0,'pursuit'=>5,'label'=>'Conversations Started with Prospects at Networking Events'),
								2=>array('name'=>'They started a conversation with you',	'points'=>5,'pursuit'=>0,'label'=>'Conversations Prospects Started at Networking Events'),
								3=>array('name'=>'You visited their booth',					'points'=>0,'pursuit'=>1,'label'=>"Prospects' Booths that Were Visited"),
								4=>array('name'=>'They visited your booth',					'points'=>2,'pursuit'=>0,'label'=>'Prospects that Visited Our Booth'),
								5=>array('name'=>'You attended their event',				'points'=>0,'pursuit'=>5,'label'=>"Prospects' Events Attended"),
								6=>array('name'=>'They attended your event',				'points'=>5,'pursuit'=>0,'label'=>'Prospects that Attended Our Events')
							)
						),//end of Section
					),
				);


		$intOptions = array(
						//Section
						2=>array(
							'name'=>'Current Environment',
							'options'=>array(
								1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1,'label'=>'Prospects that Use Something Similar to Us'),
								2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1,'label'=>"Prospect that Aren't Using Something Similar to US"),
								3=>array('name'=>'They need what we offer',									'points'=>1,'pursuit'=>1,'label'=>'Prospects that Need What We Offer'),
								4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1,'label'=>'Prospects that Do Not Need What We Offer'),
								5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1,'label'=>'Prospects that Have Pain and Are Aware of It'),
								6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1,'label'=>'Prospects that Have Pain and Are Unaware of It')
							)
						),//end of Section
						//Section
						3=>array(
							'name'=>'Engagement',
							'options'=>array(
								1=>array('name'=>'They asked you questions about your company or product/service','points'=>1,'pursuit'=>0,'label'=>'Prospects that Asked Questions About Our Company or Products'),
								2=>array('name'=>'They asked you to send them more information',				'points'=>1,'pursuit'=>0,'label'=>'Prospects that Asked for Us to Send More information'),
								3=>array('name'=>'They were open to sharing information about them',			'points'=>1,'pursuit'=>0,'label'=>'Prospects that Were Open to Sharing Information About Them'),
								4=>array('name'=>'They asked about pricing',									'points'=>1,'pursuit'=>0,'label'=>'Prospects that Asked About Pricing'),
								5=>array('name'=>'They asked for a demo/presentation',							'points'=>5,'pursuit'=>0,'label'=>'Prospects that Asked for a Demo or Presentation'),
								6=>array('name'=>'They asked for a quote/proposal',								'points'=>5,'pursuit'=>0,'label'=>'Prospects that Asked for a Quote or Proposal'),
								7=>array('name'=>'You provided a quote/proposal',								'points'=>0,'pursuit'=>5,'label'=>'Number of Quotes or Proposals Provided'),
								8=>array('name'=>'You provided a demo/presentation',							'points'=>0,'pursuit'=>5,'label'=>'Number of Demos or Presentations Provided')
							)
						),//end of Section
						//Section
						4=>array(
							'name'=>'Objections',
							'options'=>array(
								1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0,'label'=>'They said they were not intereted'),
								2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0,'label'=>'They asked for a call back (less than 30 days)'),
								3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0,'label'=>'They asked for a call back (more than 30 days)'),
								4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0,'label'=>'They are not the right person'),
								5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0,'label'=>'They already use somebody'),
								6=>array('name'=>'They do not have budget',							'points'=>-1,'pursuit'=>0,'label'=>'They do not have budget'),
								7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0,'label'=>'They asked to just send info'),
								8=>array('name'=>'They said we were too expensive',					'points'=>-1,'pursuit'=>0,'label'=>'They said we were too expensive'),
								9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0,'label'=>'They said it would be too complex switch'),
								10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0,'label'=>'They are locked in a contract'),
								11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0,'label'=>'They cannot make any changes'),
								12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0,'label'=>'They do not have time to look at this'),
								13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0,'label'=>'This area is not a priority'),
								14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3,'label'=>'You got around the objection'),
								15=>array('name'=>'The objection ended the call',					'points'=>-5,'pursuit'=>0,'label'=>'The objection ended the call'),
								"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0,'label'=>'Other')
							)
						),//end of Section
						//Section
						5=>array(
							'name'=>'Closing',
							'options'=>array(
								1=>array('name'=>'You closed them on the next step in the sales process',		'points'=>3,'pursuit'=>3,'label'=>'Prospects that Were Closed to Move to Next Sales Process Step'),
								2=>array('name'=>'You scheduled an appointment/meeting',						'points'=>3,'pursuit'=>3,'label'=>'Appointments or Meetings Scheduled'),
								3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3,'label'=>'Deals Closed'),
								4=>array('name'=>'You had an instant meeting right then',						'points'=>3,'pursuit'=>3,'label'=>'Number of Instant Meetings '),
								5=>array('name'=>'They asked you to move on the next step in the sales process','points'=>3,'pursuit'=>3,'label'=>'Prospects that Asked to Move to Next Sales Process Step'),
								6=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3,'label'=>'Prospects that Agreed to Purchase'),
								7=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0,'label'=>'Prospects that Delayed Purchasing'),
								8=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0,'label'=>'Prospects that Stopped Responding'),
								9=>array('name'=>'They did not agree to move forward',							'points'=>-5,'pursuit'=>0,'label'=>'Prospects that Would Not Agree to Move Forward')
							)
						)//end of Section
						
					);

		$Schedules = array(
						'Follow up with a phone call',
						'Follow up with an email',
						'Stop by in person',
						'Follow up on social media',
						'Attend meeting',
						//'Date'
						);


		$categories = 	array(
							'category'=>$CatgintOptions,
							'sections'=>$intOptions,
							'schedule'=>$Schedules
						);

		return $categories;
	}
	
	function crm_options() {
		//Phone Call Category : Sections
		$Cat1_Sections = array(
							//Section
							1=>array(
								'name'=>'Connecting',
								'options'=>array(
									1=>array('name'=>'You called them',				'points'=>0,'pursuit'=>2),
									2=>array('name'=>'They answered your call',		'points'=>1,'pursuit'=>0),
									3=>array('name'=>'They did not answer your call',	'points'=>0,'pursuit'=>0),
									4=>array('name'=>'They called you',				'points'=>5,'pursuit'=>0),
									5=>array('name'=>'You left a voicemail',			'points'=>0,'pursuit'=>1),
									6=>array('name'=>'You did not leave a voicemail',	'points'=>0,'pursuit'=>0)
								)
							),//end of Section
							//Section
							2=>array(
								'name'=>'Current Environment',
								'options'=>array(
									1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1),
									3=>array('name'=>'They need what we offer',								'points'=>1,'pursuit'=>1),
									4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1),
									5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1),
									6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1)
								)
							),//end of Section
							//Section
							3=>array(
								'name'=>'Engagement',
								'options'=>array(
									1=>array('name'=>'They asked you questions about your company or product/service',	'points'=>1,'pursuit'=>0),
									2=>array('name'=>'They asked you to send them more information',					'points'=>1,'pursuit'=>0),
									3=>array('name'=>'They were open to sharing information about them',				'points'=>1,'pursuit'=>0),
									4=>array('name'=>'They asked about pricing',										'points'=>1,'pursuit'=>0),
									5=>array('name'=>'They asked for a demo/presentation',								'points'=>5,'pursuit'=>0),
									6=>array('name'=>'They asked for a quote/proposal',								'points'=>5,'pursuit'=>0),
									7=>array('name'=>'You provided a quote/proposal',									'points'=>0,'pursuit'=>5),
									8=>array('name'=>'You provided a demo/presentation',								'points'=>0,'pursuit'=>5)
								)
							),//end of Section
							//Section
							4=>array(
								'name'=>'Objections',
								'options'=>array(
									1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0),
									2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0),
									3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0),
									4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0),
									5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They do not have budget',						'points'=>-1,'pursuit'=>0),
									7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0),
									8=>array('name'=>'They said we were too expensive',				'points'=>-1,'pursuit'=>0),
									9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0),
									10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0),
									11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0),
									12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0),
									13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0),
									14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3),
									15=>array('name'=>'The objection ended the call',					'points'=>-5,'pursuit'=>0),
									"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0)
								)
							),//end of Section
							//Section
							5=>array(
								'name'=>'Closing',
								'options'=>array(
									1=>array('name'=>'You closed them on the next step in the sales process',			'points'=>3,'pursuit'=>3),
									2=>array('name'=>'You scheduled an appointment/meeting',							'points'=>3,'pursuit'=>3),
									3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3),
									4=>array('name'=>'You had an instant meeting right then',							'points'=>3,'pursuit'=>3),
									5=>array('name'=>'They asked you to move on the next step in the sales process',	'points'=>3,'pursuit'=>3),
									6=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3),
									7=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0),
									8=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0),
									9=>array('name'=>'They did not agree to move forward',								'points'=>-5,'pursuit'=>0)
								)
							)//end of Section
							
						);
		$Cat1_Schedules = array(
								'Follow up with a phone call',
								'Follow up with an email',
								'Stop by in person',
								'Follow up on social media',
								'Attend meeting',
								//'Date'
								);
		
		//Email Category : Sections
		$Cat2_Sections = array(
							//Section
							1=>array(
								'name'=>'Connecting',
								'options'=>array(
									1=>array('name'=>'You sent them an email',				'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They responded to your email',		'points'=>3,'pursuit'=>0),
									3=>array('name'=>'They did not respond to an email',	'points'=>0,'pursuit'=>0),
									4=>array('name'=>'They sent you an email',				'points'=>5,'pursuit'=>0),
									5=>array('name'=>'They opened the email',				'points'=>1,'pursuit'=>0),
									6=>array('name'=>'Contact Unsubscribed',				'points'=>-5,'pursuit'=>0)
								)
							),//end of Section
							//Section
							2=>array(
								'name'=>'Current Environment',
								'options'=>array(
									1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1),
									3=>array('name'=>'They need what we offer',								'points'=>1,'pursuit'=>1),
									4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1),
									5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1),
									6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1)
								)
							),//end of Section	
							//Section
							3=>array(
								'name'=>'Engagement',
								'options'=>array(
									1=>array('name'=>'They clicked on a link in your email',							'points'=>3,'pursuit'=>0),
									2=>array('name'=>'They asked you questions about your company or product/service',	'points'=>1,'pursuit'=>0),
									3=>array('name'=>'They asked you to send them more informaiton',					'points'=>1,'pursuit'=>0),
									4=>array('name'=>'They were open to sharing information about them',				'points'=>1,'pursuit'=>0),
									5=>array('name'=>'They forwarded your email',										'points'=>1,'pursuit'=>0),
									6=>array('name'=>'They referred you to someone',									'points'=>1,'pursuit'=>0),
									7=>array('name'=>'They introduced you to someone',									'points'=>3,'pursuit'=>0),
									8=>array('name'=>'They asked about pricing',										'points'=>1,'pursuit'=>0),
									9=>array('name'=>'They asked for a demo/presentation',								'points'=>5,'pursuit'=>0),
									10=>array('name'=>'They asked for a quote/proposal',								'points'=>5,'pursuit'=>0),
									11=>array('name'=>'You provided a quote/proposal',									'points'=>0,'pursuit'=>5),
									12=>array('name'=>'You provided a demo/presentation',								'points'=>0,'pursuit'=>5)
								)	
							),//end of Section
							//Section
							4=>array(
								'name'=>'Objections',
								'options'=>array(
									1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0),
									2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0),
									3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0),
									4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0),
									5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They do not have budget',						'points'=>-1,'pursuit'=>0),
									7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0),
									8=>array('name'=>'They said we were too expensive',				'points'=>-1,'pursuit'=>0),
									9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0),
									10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0),
									11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0),
									12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0),
									13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0),
									14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3),
									15=>array('name'=>'The objection ended the interaction',			'points'=>-5,'pursuit'=>0),
									"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0)
								)	
							),//end of Section
							//Section
							5=>array(
								'name'=>'Closing',
								'options'=>array(
									1=>array('name'=>'You closed them on the next step in the sales process',			'points'=>3,'pursuit'=>3),
									2=>array('name'=>'You scheduled an appointment/meeting',							'points'=>3,'pursuit'=>3),
									3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3),
									4=>array('name'=>'They asked you to move on the next step in the sales process',	'points'=>3,'pursuit'=>3),
									5=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3),
									6=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0),
									7=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0),
									8=>array('name'=>'They did not agree to move forward',								'points'=>-5,'pursuit'=>0)
								)	
							),//end of Section
						);
		/*$Cat2_Schedules = array(
								'Follow up with a phone call',
								'Follow up with an email',
								'Stop by in person',
								'Follow up on social media',
								'Attend meeting',
								'Date'
								);*/				
		//Networking Category : Sections
		$Cat3_Sections = array(
							//Section
							1=>array(
								'name'=>'Connecting',
								'options'=>array(
									1=>array('name'=>'You started a conversation with them',	'points'=>0,'pursuit'=>5),
									2=>array('name'=>'They started a conversation with you',	'points'=>5,'pursuit'=>1),
									3=>array('name'=>'You visited their booth',				'points'=>0,'pursuit'=>1),
									4=>array('name'=>'They visited your booth',				'points'=>2,'pursuit'=>0),
									5=>array('name'=>'You attended their event',				'points'=>0,'pursuit'=>5),
									6=>array('name'=>'They attended your event',				'points'=>5,'pursuit'=>0)
								)
							),//end of Section
							//Section
							2=>array(
								'name'=>'Current Environment',
								'options'=>array(
									1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1),
									3=>array('name'=>'They need what we offer',								'points'=>1,'pursuit'=>1),
									4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1),
									5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1),
									6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1)
								)
							),//end of Section	
							//Section
							3=>array(
								'name'=>'Engagement',
								'options'=>array(
									1=>array('name'=>'They asked you questions about your company or product/service',	'points'=>1,'pursuit'=>0),
									2=>array('name'=>'They asked you to send them more information',					'points'=>1,'pursuit'=>0),
									3=>array('name'=>'They were open to sharing information about them',				'points'=>1,'pursuit'=>0),
									4=>array('name'=>'They asked about pricing',										'points'=>1,'pursuit'=>0),
									5=>array('name'=>'They asked for a demo/presentation',								'points'=>5,'pursuit'=>0),
									6=>array('name'=>'They asked for a quote/proposal',								'points'=>5,'pursuit'=>0),
									7=>array('name'=>'You provided a quote/proposal',									'points'=>0,'pursuit'=>5),
									8=>array('name'=>'You provided a demo/presentation',								'points'=>0,'pursuit'=>5),
									9=>array('name'=>'They referred you to someone',									'points'=>1,'pursuit'=>0),
									10=>array('name'=>'They introduced you to someone',									'points'=>3,'pursuit'=>0),
									11=>array('name'=>'They asked for your business card',								'points'=>1,'pursuit'=>0),
									12=>array('name'=>'You asked for their business card',								'points'=>0,'pursuit'=>1)
								)	
							),//end of Section
							//Section
							4=>array(
								'name'=>'Objections',
								'options'=>array(
									1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0),
									2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0),
									3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0),
									4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0),
									5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They do not have budget',						'points'=>-1,'pursuit'=>0),
									7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0),
									8=>array('name'=>'They said we were too expensive',				'points'=>-1,'pursuit'=>0),
									9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0),
									10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0),
									11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0),
									12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0),
									13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0),
									14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3),
									15=>array('name'=>'The objection ended the interaction',			'points'=>-5,'pursuit'=>0),
									"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0)
								)	
							),//end of Section
							//Section
							5=>array(
								'name'=>'Closing',
								'options'=>array(
									1=>array('name'=>'You closed them on the next step in the sales process',			'points'=>3,'pursuit'=>3),
									2=>array('name'=>'You scheduled an appointment/meeting',							'points'=>3,'pursuit'=>3),
									3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3),
									4=>array('name'=>'They asked you to move on the next step in the sales process',	'points'=>3,'pursuit'=>3),
									5=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3),
									6=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0),
									7=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0),
									8=>array('name'=>'They did not agree to move forward',								'points'=>-5,'pursuit'=>0)
								)	
							),//end of Section
						);
		
		//Social Media Category : Sections
		$Cat4_Sections = array(
							//Section
							1=>array(
								'name'=>'Connecting',
								'options'=>array(
									1=>array('name'=>'You sent them a friend/connection request',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They sent you a friend/connection request',		'points'=>5,'pursuit'=>0),									
									3=>array('name'=>'You accepted their friend/connection request',	'points'=>0,'pursuit'=>1),
									4=>array('name'=>'They accepted your friend/connection request',	'points'=>0.5,'pursuit'=>0),									
									5=>array('name'=>'You sent them a private message',				'points'=>0,'pursuit'=>1),
									6=>array('name'=>'They sent you a private message',				'points'=>5,'pursuit'=>0),
									7=>array('name'=>'They responded to a private message',			'points'=>3,'pursuit'=>0),
									8=>array('name'=>'They did not respond to a private message',		'points'=>-3,'pursuit'=>0)
								)
							),//end of Section
							//Section
							2=>array(
								'name'=>'Current Environment',
								'options'=>array(
									1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1),
									3=>array('name'=>'They need what we offer',								'points'=>1,'pursuit'=>1),
									4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1),
									5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1),
									6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1)
								)
							),//end of Section	
							//Section
							3=>array(
								'name'=>'Engagement',
								'options'=>array(
									1=>array('name'=>'They liked something of you posted (status, video, picture, etc.)',		'points'=>1,'pursuit'=>0),
									2=>array('name'=>'You liked something that they posted (status, video, picture, etc.)',	'points'=>0,'pursuit'=>1),
									3=>array('name'=>'They commented on something that you posted',							'points'=>2,'pursuit'=>0),
									4=>array('name'=>'You commented on something they posted',									'points'=>0,'pursuit'=>2),
									5=>array('name'=>'They tagged you in a photo or status update',							'points'=>2,'pursuit'=>0),
									6=>array('name'=>'You tagged them in a photo or status update',							'points'=>0,'pursuit'=>2),
									7=>array('name'=>'They asked you questions about your company or product/service',			'points'=>1,'pursuit'=>0),
									8=>array('name'=>'They were open to sharing information about them',						'points'=>1,'pursuit'=>0),
									9=>array('name'=>'They referred you to someone',											'points'=>1,'pursuit'=>0),
									10=>array('name'=>'They introduced you to someone',											'points'=>3,'pursuit'=>0),
									11=>array('name'=>'They asked about pricing',												'points'=>1,'pursuit'=>0),
									12=>array('name'=>'They asked for a demo/presentation',										'points'=>5,'pursuit'=>0),
									13=>array('name'=>'They asked for a quote/proposal',										'points'=>5,'pursuit'=>0),
									14=>array('name'=>'You provided a quote/proposal',											'points'=>0,'pursuit'=>5),
									15=>array('name'=>'You provided a demo/presentation',										'points'=>0,'pursuit'=>5),
									
								)	
							),//end of Section
							//Section
							4=>array(
								'name'=>'Objections',
								'options'=>array(
									1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0),
									2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0),
									3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0),
									4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0),
									5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They do not have budget',						'points'=>-1,'pursuit'=>0),
									7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0),
									8=>array('name'=>'They said we were too expensive',				'points'=>-1,'pursuit'=>0),
									9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0),
									10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0),
									11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0),
									12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0),
									13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0),
									14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3),
									15=>array('name'=>'The objection ended the interaction',			'points'=>-5,'pursuit'=>0),
									"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0)
								)	
							),//end of Section
							//Section
							5=>array(
								'name'=>'Closing',
								'options'=>array(
									1=>array('name'=>'You closed them on the next step in the sales process',			'points'=>3,'pursuit'=>3),
									2=>array('name'=>'You scheduled an appointment/meeting',							'points'=>3,'pursuit'=>3),
									3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3),
									4=>array('name'=>'They asked you to move on the next step in the sales process',	'points'=>3,'pursuit'=>3),
									5=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3),
									6=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0),
									7=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0),
									8=>array('name'=>'They did not agree to move forward',								'points'=>-5,'pursuit'=>0)
								)	
							),//end of Section
						);
						
		//Meeting Category : Sections
		$Cat5_Sections = array(
							//Section
							1=>array(
								'name'=>'Connecting',
								'options'=>array(
									1=>array('name'=>'You had a meeting',									'points'=>5,'pursuit'=>5),
									2=>array('name'=>'You went to meet at their office',					'points'=>0,'pursuit'=>2),
									3=>array('name'=>'They came to your office',							'points'=>2,'pursuit'=>0),
									4=>array('name'=>'They were on time',									'points'=>1,'pursuit'=>0),
									5=>array('name'=>'They were late',										'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They asked to reschedule',							'points'=>-2,'pursuit'=>0),
									7=>array('name'=>'They invited/brought other people to the meeting',	'points'=>2,'pursuit'=>0)
									
								)
							),//end of Section
							//Section
							2=>array(
								'name'=>'Current Environment',
								'options'=>array(
									1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1),
									3=>array('name'=>'They need what we offer',								'points'=>1,'pursuit'=>1),
									4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1),
									5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1),
									6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1)
								)
							),//end of Section
							//Section
							3=>array(
								'name'=>'Engagement',
								'options'=>array(
									1=>array('name'=>'They asked you questions about your company or product/service',	'points'=>1,'pursuit'=>0),
									2=>array('name'=>'They asked you to send them more information',					'points'=>1,'pursuit'=>0),
									3=>array('name'=>'They were open to sharing information about them',				'points'=>1,'pursuit'=>0),
									4=>array('name'=>'They asked about pricing',										'points'=>1,'pursuit'=>0),
									5=>array('name'=>'They asked for a demo/presentation',								'points'=>5,'pursuit'=>0),
									6=>array('name'=>'They asked for a quote/proposal',								'points'=>5,'pursuit'=>0),
									7=>array('name'=>'You provided a quote/proposal',									'points'=>0,'pursuit'=>5),
									8=>array('name'=>'You provided a demo/presentation',								'points'=>0,'pursuit'=>5)
								)
							),//end of Section
							//Section
							4=>array(
								'name'=>'Objections',
								'options'=>array(
									1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0),
									2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0),
									3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0),
									4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0),
									5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They do not have budget',						'points'=>-1,'pursuit'=>0),
									7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0),
									8=>array('name'=>'They said we were too expensive',				'points'=>-1,'pursuit'=>0),
									9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0),
									10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0),
									11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0),
									12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0),
									13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0),
									14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3),
									15=>array('name'=>'The objection ended the call',					'points'=>-5,'pursuit'=>0),
									"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0)
								)
							),//end of Section
							//Section
							5=>array(
								'name'=>'Closing',
								'options'=>array(
									1=>array('name'=>'You closed them on the next step in the sales process',			'points'=>3,'pursuit'=>3),
									2=>array('name'=>'You scheduled an appointment/meeting',							'points'=>3,'pursuit'=>3),
									3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3),
									4=>array('name'=>'You had an instant meeting right then',							'points'=>3,'pursuit'=>3),
									5=>array('name'=>'They asked you to move on the next step in the sales process',	'points'=>3,'pursuit'=>3),
									6=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3),
									7=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0),
									8=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0),
									9=>array('name'=>'They did not agree to move forward',								'points'=>-5,'pursuit'=>0)
								)
							)//end of Section
							
						);			
		//Marketing Category : Sections
		$Cat6_Sections = array(
							//Section
							1=>array(
								'name'=>'Connecting',
								'options'=>array(
									1=>array('name'=>'You invited them to an event',					'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They registered for an event',					'points'=>3,'pursuit'=>0),
									3=>array('name'=>'They attended your event',						'points'=>5,'pursuit'=>0),
									4=>array('name'=>'They visited your website',						'points'=>5,'pursuit'=>0),
									5=>array('name'=>'They signed up for your newsletter',				'points'=>5,'pursuit'=>0),
									6=>array('name'=>'They download marketing documents',				'points'=>5,'pursuit'=>0),
									7=>array('name'=>'They visited your booth at an event',				'points'=>3,'pursuit'=>0),
									8=>array('name'=>'You sent a direct mail marketing piece',			'points'=>0,'pursuit'=>3),
									9=>array('name'=>'The responded to a direct mail marketing piece',	'points'=>5,'pursuit'=>0),
									10=>array('name'=>'They submitted an inquiry through your website',	'points'=>3,'pursuit'=>0)
								)
							),//end of Section
							//Section
							2=>array(
								'name'=>'Current Environment',
								'options'=>array(
									1=>array('name'=>'They are using something similar to what we offer',		'points'=>0,'pursuit'=>1),
									2=>array('name'=>'They are not using anything similar to what we offer',	'points'=>1,'pursuit'=>1),
									3=>array('name'=>'They need what we offer',								'points'=>1,'pursuit'=>1),
									4=>array('name'=>'They do not need what we offer',							'points'=>-1,'pursuit'=>1),
									5=>array('name'=>'They have pain and are aware of it',						'points'=>2,'pursuit'=>1),
									6=>array('name'=>'They have pain but are unaware of it',					'points'=>1,'pursuit'=>1)
								)
							),//end of Section
							//Section
							3=>array(
								'name'=>'Engagement',
								'options'=>array(
									1=>array('name'=>'They asked you questions about your company or product/service',	'points'=>1,'pursuit'=>0),
									2=>array('name'=>'They asked you to send them more information',					'points'=>1,'pursuit'=>0),
									3=>array('name'=>'They were open to sharing information about them',				'points'=>1,'pursuit'=>0),
									4=>array('name'=>'They asked about pricing',										'points'=>1,'pursuit'=>0),
									5=>array('name'=>'They asked for a demo/presentation',								'points'=>5,'pursuit'=>0),
									6=>array('name'=>'They asked for a quote/proposal',								'points'=>5,'pursuit'=>0),
									7=>array('name'=>'You provided a quote/proposal',									'points'=>0,'pursuit'=>5),
									8=>array('name'=>'You provided a demo/presentation',								'points'=>0,'pursuit'=>5)
								)
							),//end of Section
							//Section
							4=>array(
								'name'=>'Objections',
								'options'=>array(
									1=>array('name'=>'They said they were not intereted',				'points'=>-1,'pursuit'=>0),
									2=>array('name'=>'They asked for a call back (less than 30 days)',	'points'=>-1,'pursuit'=>0),
									3=>array('name'=>'They asked for a call back (more than 30 days)',	'points'=>-1,'pursuit'=>0),
									4=>array('name'=>'They are not the right person',					'points'=>-1,'pursuit'=>0),
									5=>array('name'=>'They already use somebody',						'points'=>-1,'pursuit'=>0),
									6=>array('name'=>'They do not have budget',						'points'=>-1,'pursuit'=>0),
									7=>array('name'=>'They asked to just send info',					'points'=>-1,'pursuit'=>0),
									8=>array('name'=>'They said we were too expensive',				'points'=>-1,'pursuit'=>0),
									9=>array('name'=>'They said it would be too complex switch',		'points'=>-1,'pursuit'=>0),
									10=>array('name'=>'They are locked in a contract',					'points'=>-1,'pursuit'=>0),
									11=>array('name'=>'They cannot make any changes',					'points'=>-1,'pursuit'=>0),
									12=>array('name'=>'They do not have time to look at this',			'points'=>-1,'pursuit'=>0),
									13=>array('name'=>'This area is not a priority',					'points'=>-1,'pursuit'=>0),
									14=>array('name'=>'You got around the objection',					'points'=>0,'pursuit'=>3),
									15=>array('name'=>'The objection ended the call',					'points'=>-5,'pursuit'=>0),
									"O"=>array('name'=>'Other',											'points'=>-1,'pursuit'=>0)
								)
							),//end of Section
							//Section
							5=>array(
								'name'=>'Closing',
								'options'=>array(
									1=>array('name'=>'You closed them on the next step in the sales process',			'points'=>3,'pursuit'=>3),
									2=>array('name'=>'You scheduled an appointment/meeting',							'points'=>3,'pursuit'=>3),
									3=>array('name'=>'You closed the deal',											'points'=>3,'pursuit'=>3),
									4=>array('name'=>'You had an instant meeting right then',							'points'=>3,'pursuit'=>3),
									5=>array('name'=>'They asked you to move on the next step in the sales process',	'points'=>3,'pursuit'=>3),
									6=>array('name'=>'They agreed to purchase',										'points'=>3,'pursuit'=>3),
									7=>array('name'=>'They delayed purchasing',										'points'=>-3,'pursuit'=>0),
									8=>array('name'=>'They stopped responding',										'points'=>-5,'pursuit'=>0),
									9=>array('name'=>'They did not agree to move forward',								'points'=>-5,'pursuit'=>0)
								)
							)//end of Section
							
						);				
						
		$categories = 	array(
							//Category
							1=>array(
								'name'=>'Phone Call',
								'sections'=>$Cat1_Sections,
								'schedule'=>$Cat1_Schedules
							),
							//Category
							2=>array(
								'name'=>'Email',
								'sections'=>$Cat2_Sections,
								'schedule'=>$Cat1_Schedules
							),
							//Category
							3=>array(
								'name'=>'Networking',
								'sections'=>$Cat3_Sections,
								'schedule'=>$Cat1_Schedules
							),
							//Category
							4=>array(
								'name'=>'Social Media',
								'sections'=>$Cat4_Sections,
								'schedule'=>$Cat1_Schedules
							),
							//Category
							5=>array(
								'name'=>'Meeting',
								'sections'=>$Cat5_Sections,
								'schedule'=>$Cat1_Schedules
							),
							//Category
							6=>array(
								'name'=>'Marketing',
								'sections'=>$Cat6_Sections,
								'schedule'=>$Cat1_Schedules
							)
							
						);
		return 	$categories;			
		
	}
	//Get Random alpha string for given length
	function get_random_alpha_string($digits)
	{
		srand ((double) microtime() * 10000000);
		//Array of alphabets
		$input = array (1,2,3,4,5,6,7,8,9,0,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$random_generator="";// Initialize the string to store random numbers
		for($i=1;$i<$digits+1;$i++){ // Loop the number of times of required digits
		
			if(rand(1,2) == 1){// to decide the digit should be numeric or alphabet
			// Add one random alphabet 
			$rand_index = array_rand($input);
			$random_generator .=$input[$rand_index]; // One char is added
			
			}else{
			
			// Add one numeric digit between 1 and 10
			$random_generator .=rand(1,10); // one number is added
			} // end of if else
		
		} // end of for loop 
		
		return $random_generator;
	} // end of function
	//Adding email tracks to content
	function format_email_tracks($tdata) {
		$rand_key = substr(get_random_alpha_string(6),0,6).$tdata['userid'].substr(get_random_alpha_string(3),0,3);
		$rand_key2 = substr(get_random_alpha_string(6),0,6).$tdata['contactid'].substr(get_random_alpha_string(4),0,4);
		$href1=" href='";
		$href2=' href="';		
		$email_content = $tdata['content'];
		if($h1=strpos($email_content,$href1)!==FALSE || $h2=strpos($email_content,$href2)!==FALSE) {
			if($h1) {
				$s=$href1;
				$e="'";
				$s1 = explode($s,$email_content);
				if(count($s1)>1){
					unset($s1[0]);
					foreach($s1 as $sval) {
						$s2 = explode($e,$sval);
						if(count($s2)>1) {
							$hLink = $s2[0];
							if(strpos($hLink,"mailto:")!==FALSE || strpos($hLink,"tel:")!==FALSE) continue;
							$orgLink = $sstag.$hLink.$e;
						}
						if($orgLink) {
							$link_url = stripslashes($hLink);
							$link_url = base64_encode($link_url);
							$link_url = str_replace("=","-",$link_url);
							$email_link=base_url()."api/eclick/".$rand_key."/".$rand_key2."/$link_url/".$tdata['etime'];
							$email_link = $sstag.$email_link.$e;
							$email_content = str_replace($orgLink,$email_link,$email_content);
						}
					}
				}
			}
			if($h2) {
				$s=$href2;
				$e='"';
				$s1 = explode($s,$email_content);
				if(count($s1)>1){
					unset($s1[0]);
					foreach($s1 as $sval) {
						$s2 = explode($e,$sval);
						if(count($s2)>1) {
							$hLink = $s2[0];
							if(strpos($hLink,"mailto:")!==FALSE || strpos($hLink,"tel:")!==FALSE) continue;
							$orgLink = $sstag.$hLink.$e;
						}
						if($orgLink) {
							$link_url = stripslashes($hLink);
							$link_url = base64_encode($link_url);
							$link_url = str_replace("=","-",$link_url);
							$email_link=base_url()."api/eclick/".$rand_key."/".$rand_key2."/$link_url/".$tdata['etime'];
							$email_link = $sstag.$email_link.$e;
							$email_content = str_replace($orgLink,$email_link,$email_content);
						}
					}
				}
			}				
		}	
		//Email Template name
		if($tdata['template_name']) {
			$template_name = base64_encode($tdata['template_name']);
			$template_name = str_replace("=","-",$template_name);
			$template_name = "/".$template_name;
		} else $template_name = "";
		/*$email_hidden_image = '<div align="left"><a href="'.base_url()."api/euscribe/$rand_key/$rand_key2".'" style="font-size: 10px;font-family: arial,sans-serif;">Unsubscribe</a><img src="'.base_url()."api/eview/$rand_key/$rand_key2/".time().$template_name.'" width="0px" height="0px" alt="" style="mso-hide:all;display:none !important;max-height:0px;height:0px;width:0px;overflow:hidden; line-height:0px;" /></div>';*/
		$email_hidden_image = '<div align="left"><a href="'.base_url()."api/euscribe/$rand_key/$rand_key2".'" style="font-size: 10px;font-family: arial,sans-serif;">Unsubscribe</a><img width="1" height="1"  src="'.base_url()."api/eview/$rand_key/$rand_key2/".$tdata['etime'].$template_name.'" width="0px" height="0px" style="outline:0;text-decoration:none" /></div>';		
		$email_content .=$email_hidden_image;
		return $email_content;
	}
	//List of time zones
	function generate_timezone_list()
	{
		static $regions = array(
			DateTimeZone::AFRICA,
			DateTimeZone::AMERICA,
			DateTimeZone::ANTARCTICA,
			DateTimeZone::ASIA,
			DateTimeZone::ATLANTIC,
			DateTimeZone::AUSTRALIA,
			DateTimeZone::EUROPE,
			DateTimeZone::INDIAN,
			DateTimeZone::PACIFIC,
		);
	
		$timezones = array();
		/*foreach( $regions as $region )
		{
			$timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
		}*/
		$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
	
		$timezone_offsets = array();
		foreach( $timezones as $timezone )
		{
			$tz = new DateTimeZone($timezone);
			$timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
		}
	
		// sort timezone by offset
		asort($timezone_offsets);
	
		$timezone_list = array();
		foreach( $timezone_offsets as $timezone => $offset )
		{
			/*$offset_prefix = $offset < 0 ? 'UM' : 'UP';
			$offset_prefix .= gmdate( 'g', abs($offset) );
			if(gmdate( 'i', abs($offset) )==30) $offset_prefix .="5";
			else if(gmdate( 'i', abs($offset) )==45) $offset_prefix .="75";
			if(gmdate( 'G', abs($offset) )==0 && gmdate( 'i', abs($offset) )=="00") $offset_prefix ="UTC";
			$timezone_list[$timezone] = timezones($offset_prefix);*/			
			
			
			$offset_prefix = $offset < 0 ? '-' : '+';
			$offset_formatted = gmdate( 'H:i', abs($offset) );
	
			$pretty_offset = "UTC${offset_prefix}${offset_formatted}";
	
			$timezone_list[$timezone] = "(${pretty_offset}) $timezone";
		}
	
		return $timezone_list;
	}
	//End of CRM METHODS



	//SendGrid Mail send
	function sendgrid_mail($eparams){
		/*$eparams = array(
			'toname'=>'Roy',
			'tomail'=>'testerzttest@gmail.com',
			'fromname'=>'John',
			'frommail'=>'testerzttest@gmail.com',
			'subject'=>'SalesScripter Subject',
			'body'=>'SalesScripter Mail content'
		);*/
		//echo "SendGrid Mail System";
		//echo "\n<br><hr><br>\n";
		define('SENDGRID_APIKEY','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');
		$headers = array(
		    'Authorization: Bearer '.SENDGRID_APIKEY,
		    'Content-Type: application/json'
			);

		$epams = array(
			'personalizations' =>array(
				array(
					'to'=> array(
								array(
									"email"=>$eparams['tomail'],
									"name"=> $eparams['toname']
								)
							)
					)	
				),
			'from' =>array(
						"email"=>$eparams['frommail'],
						"name"=> $eparams['fromname']
					),
			"subject"=>$eparams['subject'],
			'content' => array(
					array(
						"type"=>"text/html",
						//"value"=>"SendGrid Heya!"
						"value" => $eparams['body']
					)
				)				
			);

		$epams_string = json_encode($epams);				

		$apiurl = "https://api.sendgrid.com/v3/mail/send";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,            $apiurl );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );		
		curl_setopt($ch, CURLOPT_POSTFIELDS,     "$epams_string" );
		curl_setopt($ch, CURLOPT_HTTPHEADER,     $headers);
		$result=curl_exec ($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		/*echo "\n<br><hr><br>\n";
		echo "--->".$result."<---";
		echo "\n<br><hr><br>\n";
		print_r($info);
		echo "\n<br><hr><br>\n";*/
		//if(isset($info['http_code']) && $info['http_code']==202) echo "Mail Sent"; else echo "Mail not sent.";
		if(isset($info['http_code']) && $info['http_code']==202) return true; else return fasle;
	}
	
	//Layout Fields
	function layout_fields() {
		$layout_keys = array(
			'target'=>array('label'=>'Target Contact','type'=>'checkbox'),
			'address'=>array('label'=>'Mailing Address'),
			'share_user_title'=>array('label'=>'Contact Owner'),
			'user_first'=>array('label'=>'Name'),
			'linkedin'=>array('label'=>'LinkedIn Profile'),
			'birthdate'=>array('label'=>'Birthdate'),
			'account_id'=>array('label'=>'Account Name'),
			'website'=>array('label'=>'Website'),
			'lead_source'=>array('label'=>'Lead Source'),
			'user_title'=>array('label'=>'Title'),
			'department'=>array('label'=>'Department'),
			'create_date'=>array('label'=>'Created'),
			'phone'=>array('label'=>'Phone'),
			'report_id'=>array('label'=>'Reports To'),
			'modify_date'=>array('label'=>'Last Modified'),
			'mobile'=>array('label'=>'Mobile'),
			'assistant'=>array('label'=>'Assistant'),
			'unsubscribed'=>array('label'=>'Subscribe Status'),
			'email'=>array('label'=>'Email'),
			'asst_phone'=>array('label'=>'Asst. Phone'),
			'other_phone'=>array('label'=>'Other Phone'),
			'description'=>array('label'=>'Description')
		);
		return $layout_keys;
	}
//Account Layout Fields
	function alayout_fields() {
		$alayout_keys = array(
			'account_name'=>array('label'=>'Account Name'),
			'target'=>array('label'=>'Target Account','type'=>'checkbox'),
			'billing'=>array('label'=>'Billing Address'),
			'share_user_title'=>array('label'=>'Account Owner'),
			'phone'=>array('label'=>'Phone'),
			'shipping'=>array('label'=>'Shipping Address'),
			'account_parent'=>array('label'=>'Parent Account'),
			'fax'=>array('label'=>'Fax'),
			'customer_priority'=>array('label'=>'Customer Priority'),
			'account_number'=>array('label'=>'Account Number'),
			'website'=>array('label'=>'Website'),
			'sla'=>array('label'=>'SLA'),
			'account_site'=>array('label'=>'Account Site'),
			'ticker_symbol'=>array('label'=>'Ticker Symbol'),
			'sla_expdate'=>array('label'=>'SLA Expiration Date'),
			'account_type'=>array('label'=>'Type'),
			'ownership'=>array('label'=>'Ownership'),
			'sla_serialno'=>array('label'=>'SLA Serial Number'),
			'employees'=>array('label'=>'Employees'),
			'industry'=>array('label'=>'Industry'),
			'numlocations'=>array('label'=>'Number of Locations'),
			'revenue'=>array('label'=>'Annual Revenue'),
			'siccode'=>array('label'=>'SIC Code'),
			'upsell_oppt'=>array('label'=>'Upsell Opportunity'),
			'rating'=>array('label'=>'Rating'),
			'create_date'=>array('label'=>'Created'),
			'active'=>array('label'=>'Active'),
			'modify_date'=>array('label'=>'Last Modified'),
			'description'=>array('label'=>'Description'),			
			'ipoints'=>array('label'=>'Quality Points'),
			'ppoints'=>array('label'=>'Pursuit Points')
		);
		return $alayout_keys;
	}

	function col_fields() {
		$layout_keys = array(
			'target'=>array('label'=>'Target Contact','type'=>'checkbox','size'=>'M'),
			'address'=>array('label'=>'Mailing Address','size'=>'M'),
			'share_user_title'=>array('label'=>'Contact Owner','size'=>'M'),
			'user_first'=>array('label'=>'Name','size'=>'M'),
			'user_title'=>array('label'=>'Title','size'=>'M'),
			'account_id'=>array('label'=>'Account','size'=>'L'),
			'linkedin'=>array('label'=>'LinkedIn Profile','size'=>'S'),
			'birthdate'=>array('label'=>'Birthdate','size'=>'M'),
			'website'=>array('label'=>'Website','size'=>'M'),
			'lead_source'=>array('label'=>'Lead Source','size'=>'M'),
			'department'=>array('label'=>'Department','size'=>'M'),
			'create_date'=>array('label'=>'Created','size'=>''),
			'phone'=>array('label'=>'Phone','size'=>'M'),
			'report_id'=>array('label'=>'Reports To','size'=>''),
			'modify_date'=>array('label'=>'Last Modified','size'=>''),
			'mobile'=>array('label'=>'Mobile','size'=>'M'),
			'assistant'=>array('label'=>'Assistant','size'=>'M'),
			'unsubscribed'=>array('label'=>'Subscribe Status','size'=>'M'),
			'email'=>array('label'=>'Email','size'=>'L'),
			'asst_phone'=>array('label'=>'Asst. Phone','size'=>'M'),
			'other_phone'=>array('label'=>'Other Phone','size'=>'M'),
			'description'=>array('label'=>'Description','size'=>'L'),
			'ipoints'=>array('label'=>'Quality Points','size'=>'S'),
			'ppoints'=>array('label'=>'Pursuit Points','size'=>'S')
		);
		return $layout_keys;
	}
	
	
	// ACCOUNT COL FIELDS
	
		function acol_fields() {
		$alayout_keys = array(
			'account_name'=>array('label'=>'Account Name','size'=>'L'),
			'target'=>array('label'=>'Target Account','type'=>'checkbox'),
			'billing'=>array('label'=>'Billing Address','size'=>'L'),
			'share_user_title'=>array('label'=>'Account Owner','size'=>'M'),
			'phone'=>array('label'=>'Phone','size'=>'M'),
			'shipping'=>array('label'=>'Shipping Address','size'=>'L'),
			'account_parent'=>array('label'=>'Parent Account','size'=>'L'),
			'fax'=>array('label'=>'Fax','size'=>'M'),
			'customer_priority'=>array('label'=>'Customer Priority','size'=>'S'),
			'account_number'=>array('label'=>'Account Number','size'=>'S'),
			'website'=>array('label'=>'Website','size'=>'M'),
			'sla'=>array('label'=>'SLA'),
			'account_site'=>array('label'=>'Account Site','size'=>'M'),
			'ticker_symbol'=>array('label'=>'Ticker Symbol','size'=>'S'),
			'sla_expdate'=>array('label'=>'SLA Expiration Date','size'=>'S'),
			'account_type'=>array('label'=>'Type','size'=>'M'),
			'ownership'=>array('label'=>'Ownership','size'=>'M'),
			'sla_serialno'=>array('label'=>'SLA Serial Number','size'=>'M'),
			'employees'=>array('label'=>'Employees','size'=>'S'),
			'industry'=>array('label'=>'Industry','size'=>'M'),
			'numlocations'=>array('label'=>'Number of Locations','size'=>'S'),
			'revenue'=>array('label'=>'Annual Revenue','size'=>'S'),
			'siccode'=>array('label'=>'SIC Code','size'=>'S'),
			'upsell_oppt'=>array('label'=>'Upsell Opportunity','size'=>'M'),
			'rating'=>array('label'=>'Rating','size'=>'S'),
			'create_date'=>array('label'=>'Created','size'=>'S'),
			'active'=>array('label'=>'Active','size'=>'S'),
			'modify_date'=>array('label'=>'Last Modified','size'=>'S'),
			'description'=>array('label'=>'Description','size'=>'L'),			
			'ipoints'=>array('label'=>'Quality Points','size'=>'S'),
			'ppoints'=>array('label'=>'Pursuit Points','size'=>'S')
		);
		return $alayout_keys;
	}

	//Amember Shared pages information
	function amb_share_verify($dis_data) {
		$CI =get_instance();
		$CI->load->model('home_model', 'home');

		//Shared User Information
        $AMuserShares = array('all'=>0,'salespitch'=>0,'playbook'=>0,'crm'=>0,'staffing'=>0);
        if(isset($dis_data['eScripter'])) $AMuserShares = array('all'=>1,'salespitch'=>1,'playbook'=>1,'crm'=>1,'staffing'=>1);
        else if(isset($dis_data['is_prolite'])) {
        	$shareduser = $CI->home->SharedUserInfo($dis_data['user_id']);
        	if($shareduser) {
        		if($shareduser->access) {
        			$access = explode(",",$shareduser->access);
        			if(in_array('sales-playback', $access)!=FALSE) $AMuserShares['playbook']=1;
        			if(in_array('crm', $access)!=FALSE) $AMuserShares['crm']=1;
        			if(in_array('staffing', $access)!=FALSE) $AMuserShares['staffing']=1;
        		}
        	} else {
        		$AMuserShares['playbook']=1;
        		$AMuserShares['crm']=1;
        	}
        }
        else if(isset($dis_data['einterviewer'])) $AMuserShares['staffing']=1;
        else if(isset($dis_data['ejobseeker'])) $AMuserShares['staffing']=1;
        return $AMuserShares;
        //End of Shared User Information		
	}
	
	// GET CUSTOM FILED VALUE
	function get_custom_fields($ckey,$refid) {
		$CI =get_instance();
		$CI->load->model('crm_model', 'crm');
		
		$val = $CI->crm->get_custom_val_option($ckey,$refid);
		
		 return $val;
		//Trigger Event: 2-Added to SalesScripter List
		
	}
	
		// GET ACCOUNT CUSTOM FILED VALUE
	function get_account_custom_fields($ckey,$refid) {
		$CI =get_instance();
		$CI->load->model('crm_model', 'crm');
		
		$val = $CI->crm->get_custom_account_val_option($ckey,$refid);
		
		return $val;
		//Trigger Event: 2-Added to SalesScripter List
		
	}

?>