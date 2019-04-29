<?php
	//Get current template details
	$this->_data['goth_btn_ctr'] = 'intro';
	if($this->_data['edittemp'] <> 1 && $this->_data['campaign_info']) {		
		$params = explode("output/",uri_string());
		$cslug = explode("/",$params[1]);
		//For Call Scriptes templates
		if(strpos($cslug[0],"call-script")!==FALSE) $this->_data['CallScriptYes'] = 1;
		//$ISPage = count($cslug)>1?'Y':'N';
		$ISPage='N';
		if(count($cslug)==1 || $cslug[1]=='download') $ISPage='N';
		else if(count($cslug)>1) $ISPage='Y';

		$uCustTemplate = $this->campaign->get_template_byslug($cslug[0],$this->_data['campaign_info']->campaign_id);
		if($uCustTemplate) {
			$sstemplates = 0;
			if($uCustTemplate['template_type']=="Sales Scripts") $sstemplates = 1;
			//set part id in Parts array
			foreach($parts as $pi=>$pv) {
				$parts[$pi]['html']='Y';
				$parts[$pi]['partid']=$pi;
			}
			$tmpParts = $parts;
			$tsections = $this->campaign->get_template_sections($uCustTemplate['temp_no']);
			$this->_data['template_sections'] = $tsections;
			//IGNORED SECTIONS
			$temp_sections = array();
			$deftemp_section_titles = array();
			$deftemp_section_order = array();
			foreach($tsections as $sect) {
				$temp_sections[$sect->content_id] = $sect;
				$deftemp_section_titles['"'.$sect->sect_title.'"'] = $sect->content_id;
				$deftemp_section_order['"'.$sect->sect_title.'"'] = $sect->sorting;
			}
			if($uCustTemplate['ignored_sections']) {
				$ignored_sections = $uCustTemplate['ignored_sections'];
				if($ignored_sections && $tsections) {						
					foreach($ignored_sections as $ignst) {
						$section = $temp_sections[$ignst];
						foreach($tmpParts as $tpi=>$tpv) {
							$tpv['title2']=$tpv['title'];
							$tpv['title3']=$tpv['title'];
							if($tpv['name']=='attention-grabbing') {
								if($uCustTemplate['temp_no']==3) {								
									$tpv['title2'] = 'Examples of Common Problems';	
									$tpv['title3']=$tpv['title2'];
								} else if($uCustTemplate['temp_no']==4) {								
									$tpv['title2'] = 'Name drop example';	
									$tpv['title3']=$tpv['title2'];
								} else if($uCustTemplate['temp_no']==5) {								
									$tpv['title2'] = 'Information About Us';	
									$tpv['title3']='Company and Product Info';
								} else if($uCustTemplate['temp_no']==2) {								
									$tpv['title2'] = 'Value Statement';	
									$tpv['title3']=$tpv['title2'];
								} else if($uCustTemplate['temp_no']==6) {								
									$tpv['title2'] = 'Value Statement';	
									$tpv['title3']=$tpv['title2'];
								} else if($uCustTemplate['temp_no']==7) {								
									$tpv['title2'] = 'Value Statement';
									$tpv['title3']=$tpv['title2'];
								}
							}
							if($tpv['title2']==$section->sect_title || $tpv['title3']==$section->sect_title) unset($tmpParts[$tpi]);
						}
					}
				}					
				if(!$temp_content) {
					$isSlug = '';
					$parts=$tmpParts;
					foreach($parts as $t2) {
						if(!$isSlug) $isSlug = $t2['name'];
						if($t2['name']=='intro') {
							$isSlug = $t2['name'];
							break;
						}
					}
					if($isSlug) $this->_data['goth_btn_ctr'] = $isSlug;
				} 
			}

			$temp_content = $this->campaign->get_template_content($uCustTemplate['temp_no'],$this->_data['campaign_info']->campaign_id);
			if($temp_content) {
				if($sstemplates) {
					
					$ISleftNav=0;
									
					//echo '1<pre>';print_r($uCustTemplate);print_r($parts);print_r($tmpParts);echo '</pre>';				
					
					//Sort	
					$sorders = array();
					$t1= array();$ti=1;
					//foreach($newsections as $t2) $t1[$ti++]=$t2;
					//foreach($tmpParts as $t2) $t1[$ti++]=$t2;
					
					$si = 0;
					$intros = '';
					foreach($tmpParts as $t2i=>$t2) {
						$t2['title2'] = $t2['title'];
						$t2['partid'] = $t2i;
						if($ISPage=='N' && $t2['name']=='attention-grabbing'){
							if($uCustTemplate['temp_no']==3) {								
								$t2['title'] = 'Examples of Common Problems';	
							} else if($uCustTemplate['temp_no']==4) {								
								$t2['title'] = 'Name drop example';	
							} else if($uCustTemplate['temp_no']==5) {								
								$t2['title'] = 'Information About Us';	
							} else if($uCustTemplate['temp_no']==2) {								
								$t2['title'] = 'Value Statement';	
							} else if($uCustTemplate['temp_no']==6) {								
								$t2['title'] = 'Value Statement';	
							} else if($uCustTemplate['temp_no']==7) {								
								$t2['title'] = 'Value Statement';	
							}
							$t2['title2'] = $t2['title'];
						} else if($ISPage=='Y' && $t2['name']=='attention-grabbing'){							
							if($uCustTemplate['temp_no']==3) {								
								$t2['title2'] = 'Examples of Common Problems';	
							} else if($uCustTemplate['temp_no']==4) {								
								$t2['title2'] = 'Name drop example';	
							} else if($uCustTemplate['temp_no']==5) {								
								$t2['title2'] = 'Information About Us';	
							} else if($uCustTemplate['temp_no']==2) {								
								$t2['title2'] = 'Value Statement';	
							} else if($uCustTemplate['temp_no']==6) {								
								$t2['title2'] = 'Value Statement';	
							} else if($uCustTemplate['temp_no']==7) {								
								$t2['title2'] = 'Value Statement';	
							}
						}
						//Sort value
						$t2['sorder'] = isset($deftemp_section_order['"'.$t2['title2'].'"'])?$deftemp_section_order['"'.$t2['title2'].'"']:$t2i;
						if($t2['title2'] == 'Information About Us' || $t2['title2'] == 'Company and Product Info') {
							if(!isset($deftemp_section_order['"'.'Information About Us'.'"'])) {
								$t2['title2'] = 'Company and Product Info';
								$t2['sorder'] = isset($deftemp_section_order['"'.'Company and Product Info'.'"'])?$deftemp_section_order['"'.'Company and Product Info'.'"']:$t2i;
							}
						}
						$sid = $deftemp_section_titles['"'.$t2['title2'].'"'];
						//neglect ignored section
						if($uCustTemplate['ignored_sections'] && $sid) {
							if(in_array($sid,$uCustTemplate['ignored_sections'])!==FALSE) continue;
						}
						if(!$intros && $t2['name']=='intro') {
							$intros=1;
						}
						$indx = $ti++;
						//Standard sections
						
							
							if(!$sid) {
								if($t2['title2'] == 'Information About Us' || $t2['title2'] == 'Company and Product Info') {
									if(!isset($deftemp_section_order['"'.'Information About Us'.'"'])) {
										$sid = $deftemp_section_titles['"'.'Company and Product Info'.'"'];
									}
								}
							}
							$scontent = '';
							if($sid) {
								$this->_data['content_id']=$sid;
								$this->_data['method_name'] = $cslug[0];
								//$this->_data['edittemp']=1;
								$scontent = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, TRUE);
							}
							$t2['sect_content'] = $scontent;
							$t2['content'] = $scontent;
							$t2['sect_title'] = $t2['title'];	
						
						$t2['partid'] = $indx;
						$t1[$indx]=$t2;
						//$si++;
						$si = isset($deftemp_section_order['"'.$t2['title'].'"'])?$deftemp_section_order['"'.$t2['title'].'"']:($t2['sorder']?$t2['sorder']:$t2i);
						$sorders[$indx]=$si;
					}
					if($temp_content) {
						foreach($temp_content as $tmpv) {
							$indx = $ti++;
							$t2=array('title'=>$tmpv->sect_title,'sect_title'=>$tmpv->sect_title,'content'=>$tmpv->sect_content,'sect_content'=>$tmpv->sect_content,'sorder'=>$tmpv->sect_sort);							
							$t2['name'] = 'intro'.$intros;
							$t2['html'] = 'Y';
							$t2['custom'] = 'yes';
							if(!$intros) $intros=0;

							$intros++;							
							$t1[$indx]=$t2;						
							$sorders[$indx]=$tmpv->sect_sort;
						}
					}

					//Sorting template sections
					asort($sorders);
					$finalSort = array();
					$finalContents = array();
					//$intros = '';
					foreach($sorders as $si=>$sval) {
						$ft1 = $t1[$si];
						if(isset($ft1['custom']))  $ft1['partid']=$si;
						$finalSort[$si] = $ft1;
						$finalContents[$si] = (object)$ft1;
					}
					$this->_data['template_sections'] = array();
					$temp_content=$finalContents;

					$tmpParts = $finalSort;
					$ISleftNav=$ti-1;
					
					
					$parts=$tmpParts;
					$pks = array_keys($parts);
					sort($pks);
					$lastid = end($pks);	
				} else {
					$ISleftNav=0;
					foreach($temp_content as $tmpv) {
						$ISleftNav++;
						if($ISleftNav==1) $parts=array();
						$parts[$ISleftNav]=array('name'=>'intro'.($ISleftNav>1?$ISleftNav:''),'title'=>$tmpv->sect_title,'content'=>$tmpv->sect_content);
					}
					if($ISleftNav) $lastid = $ISleftNav;
				}
			}
			$this->_data['template_content'] = $temp_content;
			$this->_data['uCustTemplate'] = $uCustTemplate;			
		}
		//Prepare Objections
		$cs_objects = $this->campaign->getCampaignObjections($this->_data['campaign_info']->campaign_id);
		$this->_data['objectionInfo'] = $cs_objects;
		//voicemails
		$is_voicemails = $this->campaign->IS_voicemails($this->_data['campaign_info']->campaign_id);
	}
	////
	/*$parts[$lastid+1]=array('name'=>'voice_1','title'=>'Value Focus');
	$parts[$lastid+2]=array('name'=>'voice_2','title'=>'Pain Focus');
	$parts[$lastid+3]=array('name'=>'voice_3','title'=>'Name Drop Focus');
	$parts[$lastid+4]=array('name'=>'voice_4','title'=>'Product Focus');*/
	$parts[$lastid+1]=array('name'=>'voice_1','title'=>'Voicemail Script - Value Focus');
	$parts[$lastid+2]=array('name'=>'voice_2','title'=>'Voicemail Script - Pain Focus');
	$parts[$lastid+3]=array('name'=>'voice_3','title'=>'Voicemail Script - Name Drop Focus');
	$parts[$lastid+4]=array('name'=>'voice_4','title'=>'Voicemail Script - Product Focus');
	//Voicemails
	if($is_voicemails) {
		foreach($is_voicemails as $vmobj) {
			$teid = $lastid+$vmobj->temp_id-30;
			$parts[$teid]['title']=$vmobj->temp_title;
			$parts[$teid]['default']=3;
			$parts[$teid]['resp']=array('respc1'=>$vmobj->sect_content);
		}
	}	
	//Objections start here +4
	$obcs=$lastid+5;
	$this->_data['obcstart'] = $obcs;
	$obcst=$obcs;
	$obcparts=array();
	//Get deleted standard objections
	$obj_removed = array();
	if(isset($this->_data['campaign_arsb'])) {
		$obj_removed = $this->_data['campaign_arsb'];//print_r($obj_removed);
	} else {
		$where = array();
		$where['user_id'] = $_SESSION['OrgUser'];
		$where['field_type'] = 'objections';
		$user_info = $this->home->getUserData($where);
		if($user_info) {
			$user_info = $user_info[0];
			if($user_info->value) {
				$objrsb=unserialize($user_info->value);
				if(isset($objrsb[$this->_data['campaign_info']->campaign_id])) $obj_removed = $objrsb[$this->_data['campaign_info']->campaign_id];
			}
		}
	}
	if(in_array(5,$obj_removed)==FALSE) $obcparts[$lastid+5]=array('name'=>'objection1','title'=>'I am busy right now.','sorder'=>1,'resp'=>array());
	if(in_array(6,$obj_removed)==FALSE) $obcparts[$lastid+6]=array('name'=>'objection2','title'=>'What is this in regards to?','sorder'=>2,'resp'=>array());
	if(in_array(7,$obj_removed)==FALSE) $obcparts[$lastid+7]=array('name'=>'objection3','title'=>'Is this a sales call?','sorder'=>3,'resp'=>array());
	if(in_array(8,$obj_removed)==FALSE) $obcparts[$lastid+8]=array('name'=>'objection4','title'=>'They are no longer here','sorder'=>4,'resp'=>array());
	if(in_array(9,$obj_removed)==FALSE) $obcparts[$lastid+9]=array('name'=>'objection5','title'=>'I am not the right person','sorder'=>5,'resp'=>array());
	if(in_array(10,$obj_removed)==FALSE) $obcparts[$lastid+10]=array('name'=>'objection6','title'=>'I am not interested.','sorder'=>5,'resp'=>array('resp1'=>'Redirect to Pre-Qualifying Questions','resp2'=>'Redirect to Common Problems'));
	if(in_array(11,$obj_removed)==FALSE) $obcparts[$lastid+11]=array('name'=>'objection7','title'=>'Just send me some information.','sorder'=>6,'resp'=>array());
	if(in_array(12,$obj_removed)==FALSE) $obcparts[$lastid+12]=array('name'=>'objection8','title'=>'We are not doing anything right now.','sorder'=>7,'resp'=>array('resp1'=>'Redirect to Pre-Qualifying Questions','resp2'=>'Redirect to Common Problems'));
	if(in_array(13,$obj_removed)==FALSE) $obcparts[$lastid+13]=array('name'=>'objection9','title'=>'We are not making any changes right now.','sorder'=>8,'resp'=>array('resp1'=>'Redirect to Pre-Qualifying Questions','resp2'=>'Redirect to Common Problems'));
	if(in_array(14,$obj_removed)==FALSE) $obcparts[$lastid+14]=array('name'=>'objection10','title'=>"I can't change anything right now.",'sorder'=>9,'resp'=>array('resp1'=>'Redirect to Pre-Qualifying Questions','resp2'=>'Redirect to Common Problems'));
	if(in_array(15,$obj_removed)==FALSE) $obcparts[$lastid+15]=array('name'=>'objection11','title'=>'We do not have any budget / money right now.','sorder'=>10,'resp'=>array('resp1'=>'Redirect to Pre-Qualifying Questions','resp2'=>'Redirect to Common Problems'));	
	if(in_array(16,$obj_removed)==FALSE) $obcparts[$lastid+16]=array('name'=>'objection12','title'=>'We already use someone for that.','sorder'=>11,'resp'=>array('resp1'=>'Direct Response','resp2'=>'Redirect to Pre-Qualifying Questions','resp3'=>'Redirect to Common Problems','sorder'=>12));
	if(in_array(17,$obj_removed)==FALSE) $obcparts[$lastid+17]=array('name'=>'objection13','title'=>'Please call back in ___ weeks/ months','sorder'=>13,'resp'=>array());
	$obcs=$lastid+17;
	$obced=$lastid+17;	
	if($cs_objects) {
		$objections = $obcparts;
		$cobjects = array();
		$obc=14;	
		foreach($cs_objects as $key => $obj_info) {
			if($obj_info->ob_defid) {
				if(array_key_exists($obj_info->ob_defid+$lastid,$obcparts)!=false) {
					$part=$obcparts[$obj_info->ob_defid+$lastid];
					$part['title']=$obj_info->ob_title;
					$part['default']=1;
					$part['resp']['resp1']=$obj_info->ob_rsptitle1;					
					$part['resp']['respc1']=$obj_info->ob_rspcontent1;
					$part['resp']['resp2']=$obj_info->ob_rsptitle2;					
					$part['resp']['respc2']=$obj_info->ob_rspcontent2;
					$part['resp']['resp3']=$obj_info->ob_rsptitle3;					
					$part['resp']['respc3']=$obj_info->ob_rspcontent3;
					$obcparts[$obj_info->ob_defid+$lastid]=$part;
					unset($objections[$obj_info->ob_defid+$lastid]);
					$cobjects[] = $part;
				}
			} elseif(!isset($objedit)) {
				$obcs++;
				$part=array(
					'ob_id'=>$obj_info->ob_id,
					'name'=>'objection'.$obc++,
					'title'=>$obj_info->ob_title,
					'default'=>2,
					'resp'=>array(
						'resp1'=>$obj_info->ob_rsptitle1,
						'respc1'=>$obj_info->ob_rspcontent1,
						'resp2'=>$obj_info->ob_rsptitle2,
						'respc2'=>$obj_info->ob_rspcontent2,
						'resp3'=>$obj_info->ob_rsptitle3,
						'respc3'=>$obj_info->ob_rspcontent3
						)
					);
				$parts[$obcs]=$part;
				$cobjects[] = $part;
			}			
		}
		foreach($objections as $oi=>$ov) {
			$cobjects[]=$ov;
		}
		$this->_data['csobjects'] = $cobjects;
	}
	foreach($obcparts as $oi=>$ov) {
		$parts[$oi]=$ov;
	}
	//echo "<pre>";print_r($parts);echo "</pre>";
	$this->_data['obcend'] = $obcs;
	//Interactive script Bottom buttons by Dev@4489
	if($ISleftNav) {
		//$oblastid = count($parts);
		$pks = array_keys($parts);
		sort($pks);
		$oblastid = end($pks);
		//echo $oblastid.'-';
		include('custom_controller.php');
		$this->_data['oblastid'] = $oblastid;
		$this->_data['ISleftNav'] = $ISleftNav;
	}
	////
	
	//Create CRM Log Call
	if($action == 'logcall') {		
		$notes_arr = $_POST;
		$contact_id = $_POST['contact_id'];
		$account_id = $_POST['account_id'];
		if(!$contact_id && !$account_id) {
			echo "Search Contact or Account";exit;
		}
		unset($_POST['contact_id']);
		unset($_POST['account_id']);
		unset($notes_arr['partids']);
		unset($notes_arr['contact_id']);
		unset($notes_arr['account_id']);
		$notes_arr = array_filter($notes_arr);
		if(!$notes_arr) {
			echo "There is no notes";exit;
		}
		
		$this->_data['action']="LogCall";
		$this->_data['postdata']=$_POST;
		$this->_data['lastid'] = $lastid;
		$this->_data['parts'] = $parts;
		$html = $this->load->view('outputs/interactive/get_notes', $this->_data, TRUE);
		if($html) {
			$html = str_replace("<br>","",$html);
			$this->load->model('crm_model', 'crm');
			$n=0;
			if($contact_id) {				
				$record = array(
							'notes_title'=>'Call',
							'notes_parent'=>'C',
							'notes_parentid'=>$contact_id,
							'notes_user'=>$_SESSION['OrgUser'],
							'notes_info'=>$html
							);
				$cid = $this->crm->save_notes($record,0);
				
				
				$n++;
			}
			if($account_id) {				
				$record = array(
							'notes_title'=>'Call',
							'notes_parent'=>'A',
							'notes_parentid'=>$account_id,
							'notes_user'=>$_SESSION['OrgUser'],
							'notes_info'=>$html
							);
				$cid = $this->crm->save_notes($record,0);
				
				$n++;
			}
			if($n) echo "Log Call created"; else echo "Log Call not submitted, please try to submit after reload the page.";
			exit;
		}
		exit;
	}
	////
	//Get IS Response	
	function get_is_response($objname,$rsp,$campgn_data) {
		$campaign_output_tech_val=$campgn_data['campaign_output_tech_val'];
		$campaign_info=$campgn_data['campaign_info'];
		$campaign_tech_summary=$campgn_data['campaign_tech_summary'];
		$campaign_output_tech_qualify=$campgn_data['campaign_output_tech_qualify'];
		$campaign_output_tech_pain=$campgn_data['campaign_output_tech_pain'];
		$campaign_output_qualify=$campgn_data['campaign_output_qualify'];//By Dev@4489
		ob_start();
		//I am busy right now.
		if($objname=="objection1") {			
			if($rsp=="r1") {
			?><p>Oh, OK. I can be very brief or I can call you back at another time.</p>
		<p><span class="red-area">OR</span></p>
		<p>Oh, OK. When is the best time for me to call you back?</p><?php
			}			
		}
		//What is this in regards to?
		else if($objname=="objection2") {
			if($rsp=="r1") {
			?><p>Well, the purpose for my call is that we help <span class="dynamic_value edit_area_old" id=""><?php 
							
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}
						?></span> to - <span class="red-area">(Redirect to your value statement by answering with one of below) </span></p>
    	<ul>
    	<?php 
					foreach($campaign_output_tech_val as $cur_tech_summary) { ?>
					<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $cur_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($cur_tech_summary->value) ? $cur_tech_summary->value : NULL);?></span>.
					</li>
                    <?php 
					}
					?>
		</ul><?php
			}			
		}
		//Is this a sales call?
		else if($objname=="objection3") {
			if($rsp=="r1") {
			?><p>Well, the purpose for my call is that we help <span class="dynamic_value edit_area_old" id=""><?php 
							
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}
						?></span> to - <span class="red-area">(Redirect to your value statement by answering with one of below) </span></p>
    	<ul>
    	<?php 
					foreach($campaign_output_tech_val as $cur_tech_summary) { ?>
					<li><span class="<?php echo 'dynamic_value edit_area' ;?>" id="ccd_<?php echo $cur_tech_summary->cam_com_id; ?>_<?php echo $campaign_info->campaign_id ?>"><?php echo (isset($cur_tech_summary->value) ? $cur_tech_summary->value : NULL);?></span>.
					</li>
                    <?php 
					}
					?>
    	</ul>
            <?php
			}			
		}
		//They are no longer here
		else if($objname=="objection4") {
			if($rsp=="r1") {
			?><p>Oh, OK. Do you know who took their place?</p>
		<p><span class="red-area">OR</span></p>
        <p>Oh, OK. I have them down as the <span class="red-area">(insert title)</span>. Do you know who took that role?</p><?php
			}			
		}
		//I am not the right person
		else if($objname=="objection5") {
			if($rsp=="r1") {
			?><p>Oh, OK. Do you know who the right person that I should connect with is?</p>
		<p><span class="red-area">OR</span></p>
		<p>Oh, OK. Can you point me in the right direction of who I should try to connect with?</p><?php
			}			
		}
		//I am not interested.
		else if($objname=="objection6") {
			if($rsp=="r1") {
			?><p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			
			<?php /*?><ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div><?php
			} else if($rsp=="r2") {
			?><p>
					I understand. Sometimes when we talk with other 
						<?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}	
						?>, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo ucfirst($singlepain->value) ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br /><?php
			}
		}
		//Just send me some information.
		else if($objname=="objection7") {
			if($rsp=="r1") {
			?><p>I can certainly do that. So that I know exactly what to send you, do you mind if I ask:</p>
			<p class="red-area">(Redirect to one of the qualifying questions)</p>
			
			<?php /*?><ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div><?php
			}			
		}
		//We are not doing anything right now.
		else if($objname=="objection8") {
			if($rsp=="r1") {
			?><p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			
			<?php /*?><ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div><?php
			} else if($rsp=="r2") {
			?><p>
					I understand. Sometimes when we talk with other 
						<?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}	
						?>, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo ucfirst($singlepain->value) ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br /><?php
			}			
		}
		//We are not making any changes right now.
		else if($objname=="objection9") {
			if($rsp=="r1") {
			?><p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			
			<?php /*?><ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div><?php
			} else if($rsp=="r2") {
			?><p>
					I understand. Sometimes when we talk with other 
						<?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}	
						?>, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo ucfirst($singlepain->value) ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br /><?php
			}
		}
		//I can't change anything right now.
		else if($objname=="objection10") {
			if($rsp=="r1") {
			?><p>I understand. </p>
			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			
			<?php /*?><ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div><?php
			} else if($rsp=="r2") {
			?><p>
					I understand. Sometimes when we talk with other 
						<?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}	
						?>, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo ucfirst($singlepain->value) ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br /><?php
			}
		}
		//We do not have any budget / money right now.
		else if($objname=="objection11") {
			if($rsp=="r1") {
			?><p>I understand. </p>

			<p><span class="red-area">(OPTIONAL) </span> And I want you to know that we are not trying to sell anything at this point.</p>
			<p><span class="red-area">(OPTIONAL) </span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p><span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			<p>If I could ask you real quick: </p>
			
			<?php /*?><ul>
				<?php if (isset($campaign_output_tech_qualify)):?>
					<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
					
						<li> <?php echo $singlequalify->value ?> </li>
					
					<?php } ?>
				<?php endif; ?>
						
			</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div><?php
			} else if($rsp=="r2") {
			?><p>
					I understand. Sometimes when we talk with other 
						<?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}	
						?>, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo ucfirst($singlepain->value) ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br /><?php
			}
		}
		//We already use someone for that.
		else if($objname=="objection12") {
			if($rsp=="r1") {
			?><p>Oh, I see. <span class="red-area">(Ask any or all of the following questions) </span></p>
				<ul>
					<li>How long have you been using them / with them / purchasing from them?</li>
					<li>How is everything going?</li>
					<li>What are some of the things you like about what they provide?</li>
					<li>What are some things that you think could be better?</li>
					<li>If you could change one thing about their product/service, what would it be?</li>
					<li>When was the last time you considered other options in this area?</li>
				</ul>
				<br /><?php
			} else if($rsp=="r2") {
			?><p>I understand.</p>
            <p> <span class="red-area">(OPTIONAL )</span> And I want you to know that we are not trying to sell anything at this point. </p>
			<p> <span class="red-area">(OPTIONAL)</span> I am not even really sure if what we have is a good fit for you. That is why I had a question or two, if you have a couple of minutes.</p>
			<p> <span class="red-area">(Redirect to one of the qualifying questions)</span></p>
			
				<?php /*?><ul>
					<?php if (isset($campaign_output_tech_qualify)):?>
						<?php foreach($campaign_output_tech_qualify as $singlequalify) { ?>
						
							<li> <?php echo $singlequalify->value ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul><?php */?><div style="margin-left: -24px;"><?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?></div>
				
				<br /><?php
			} else if($rsp=="r3") {
			?><p>
					I understand. Sometimes when we talk with other 
						<?php 
							if($campaign_info->campaign_target == '1'){	
									echo $campaign_info->individual;
								}else{
									echo $campaign_info->organization;
							}	
						?>, we have noticed that they often express challenges with 
					<span class="red-area">(or concerns around)</span>:
				</p>
				
				<ul>
					<?php if (isset($campaign_output_tech_pain)):?>
						<?php foreach($campaign_output_tech_pain as $singlepain) { ?>
						
							<li> <?php echo ucfirst($singlepain->value) ?> </li>
						
						<?php } ?>
					<?php endif; ?>
							
				</ul>
				
				<p>Can you relate to any of those?</p>
				<span class="red-area">OR</span>
				<p>Which one of those are you most concerned with?</p>
				<br /><?php
			}
		}
		//Please call back in ___ weeks/ months
		else if($objname=="objection13") {
			if($rsp=="r1") {
			?><p>Sure, I definitely can. Just so I can update my notes correctly, is there something that will make that a better time for us to get back together?</p>
        <p><span class="red-area">OR</span></p>
        <p>Sure, I definitely can. But I want you to know, I am not reaching out to you to try to sign you up or sell you anything. More so, we are just looking to open the dialogue between our two companies and have an initial conversation.</p> 
        <p>We would like to learn a little more about you and possibly share some information about us if it makes sense. That way, when you are ready to look at doing something, you can know who we are and how we can help.</p><?php
			}
		}
		$rscontent = ob_get_contents();
		ob_end_clean();		
		return $rscontent;
	}
	//getting name from template url
	function in_array_custom4($needle, $haystack) {
		foreach ($haystack as $item) {
			if($item['name'] == $needle){
				return true;
			}
		}
	  return false;
	}
	//NOTES TO SALESFORCE
	$params = explode("/",uri_string());
	$nts='';
	if(isset($params) && ($params[count($params)-2]=="intro" || $params[count($params)-2]=="cstmstage1") && $params[count($params)-1]) {
		//$_SESSION['ss_vrcid']=$params[count($params)-1];
		//echo $params[count($params)-1];
		$sfobjid = $params[count($params)-1];		
		$this->session->unset_userdata('ss_vrcid');
		$this->session->set_userdata('ss_vrcid', $sfobjid);
		$nts=$sfobjid;
		$_SESSION['ss_vrcid']=$sfobjid;
		redirect(base_url()."output/".$params[count($params)-3]."/".$params[count($params)-2]);
	}//echo $this->session->userdata('ss_vrcid');	
	if($this->session->userdata('ss_vrcid')) {
		$nts=$this->session->userdata('ss_vrcid');
	}
	if($nts) $this->_data['nts']=$nts;
	//echo $_SESSION['ss_vrcid'];
	////
?>