<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style type="text/css">
.pt10 a {color:black;}
.align-center{text-align: center;}
.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}
.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}#breadcrumbs {
    display: none;
}
/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/
</style>
<!-- Sidebar begins -->

<div id="sidebar">

    <?php $this->load->view('common/left_navigation'); ?>
	<!-- Secondary nav --> 
    <div class="secNav">
        <div class="clear"></div>	
    </div>
</div>

<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">

<?php //$this->load->view('common/progress_bar');?>
    
 <!-- Breadcrumbs line -->    
    <?php  // $this->load->view('common/top_navigation'); ?> 
    <?php  $this->load->view('common/campaign_nav'); 
		/*$progress_data = json_decode($this->home->get_progress_data($campaign_info->campaign_id));
		$boxes = array();
		foreach($progress_data as $key => $value){
			if($key=='workflow' && $value > 0) $boxes[] = 'value';
			else if($key=='value' && $value > 0) $boxes[] = 'pain';
			else if($key=='pain' && $value > 0) $boxes[] = 'qualify';
			else if($key=='qualify' && $value > 0) $boxes[] = 'close';
		} */?> 
		<div class="wrapper" >
        	<div class="fluid">
            	<div class="grid12" style="width:100%; margin-left:0%;">
                	<?php /*?><div class="myfolder" align="center" style="margin-left:0%;">
					<div class="myfloder_box">
                    	<div class="box active">
                            <div class="bxtitle bxtitle1"><h3>Set Campaign Focus</h3></div>
                            <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
                        </div>
                        <?php if(in_array('value',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box">
                            <div class="bxtitle">
                                <h3>Identify Benefits</h3>                
                            </div>
                            <div class="bxlink">
                                <a href="<?php echo base_url(); ?>step/value" class="buttonM bRed">Go Here</a>
                            </div>
                        </div>
                        <?php } if(in_array('pain',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>                        
                        <div class="box">
                            <div class="bxtitle">
                                <h3>Identify Pain Points</h3>                
                            </div>
                            <div class="bxlink">
                                <a href="<?php echo base_url(); ?>step/pain" class="buttonM bRed">Go Here</a>
                            </div>
                        </div>
                        <?php } if(in_array('qualify',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        
                        <div class="box">
                            <div class="bxtitle"><h3>Compose Probing Questions</h3></div>
                            <div class="bxlink">
                            <a href="<?php echo base_url(); ?>step/qualifying" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php } if(in_array('close',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box">
                            <div class="bxtitle"><h3>Identify Close Option</h3></div>
                            <div class="bxlink">
                            <a href="<?php echo base_url(); ?>step/ideal-sales-process" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php }?>
						</div>
					<div class="myfloder_box1 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div>

                    </div><br clear="all" /><?php */?>
                    <div class="quatabs" style="width:85%; float:left; margin:0px 0px -3px;">
                            <div  class="active">
                                <a href="<?php echo base_url(); ?>campaign/startcampaigncreate" rel="box1">
                                    Campaign Focus
                                </a>
                            </div>
                            <div>
                                <a href="<?php echo base_url(); ?>step/value" rel="box2">
                                    Benefits
                                </a>
                            </div>
                            <div>
                                <a href="<?php echo base_url(); ?>step/pain" rel="box3">
                                    Pain Points
            
                                </a>
                            </div>
                            <div>
                                <a href="<?php echo base_url(); ?>step/qualifying" rel="box4">
                                    Questions
                                </a>
                            </div>
                            <div>
                                <a href="<?php echo base_url(); ?>step/ideal-sales-process" rel="box5">
                                    Close
                                </a>
                            </div>
                        </div>
                       <div class="bxlink" style="float:right;"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
                </div>
            </div>
			<?php
				$findproduct = $this->campaign->getProduct($campaign_info->product_id);
				
			?>
            <input type="hidden" id="getanswer" value="0" />
            <?php /*?><div id="AnsBlock11" style="display:none;">
                <div class="popupbox uapboxyr" id="NNNNNNNN">
                    <div class="uapboxyr_box1">
                        <div class="abox1">Reuse one of your past answers by selecting from below</div>
                        <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                    </div>
                    <div class="uapboxyr_box2 boldWeight">
                        <span class="TextColor"></span> :
                    </div>
                    <div class="uapboxyr_box3">
                    <?php
                        $valtemps = array();
                        if($product_profiles)
                        foreach ($product_profiles  as $ansval) {
                            if(!empty($ansval->product_name)) {
                                if(in_array($ansval->product_name,$valtemps)!==FALSE) continue;
                                echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->product_id.',1)" id="anchor1_'.$ansval->product_id.'">'.$ansval->product_name.'</a></div>';
                                $valtemps[]=$ansval->product_name;
                            }
                        }
                        unset($valtemps);
                    ?>
                    </div>
                </div>
            </div>
            <div id="AnsBlock21" style="display:none;">
                <div class="popupbox uapboxyr" id="NNNNNNNN">
                    <div class="uapboxyr_box1">
                        <div class="abox1">Reuse one of your past answers by selecting from below</div>
                        <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                    </div>
                    <div class="uapboxyr_box2 boldWeight">
                        <span class="TextColor"></span> :
                    </div>
                    <div class="uapboxyr_box3">
                    <?php
                        $valtemps = array();
                        if($target_prospects)
                        foreach ($target_prospects  as $ansval) {
                            if(!empty($ansval->tp_text)) {
                                if(in_array($ansval->tp_text,$valtemps)!==FALSE) continue;
                                echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->tp_id.',1)" id="anchor1_'.$ansval->tp_id.'">'.$ansval->tp_text.'</a></div>';
                                $valtemps[]=$ansval->tp_text;
                            }
                        }
                        unset($valtemps);
                    ?>
                    </div>
                </div>
            </div>
            <div id="AnsBlock12" style="display:none;">
                <div class="popupbox uapboxor" id="NNNNNNNN">
                    <div class="uapboxyr_box1">
                        <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                        <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                    </div>
                    <div class="uapboxyr_box2 boldWeight">
                        <span class="TextColor"></span> :
                    </div>
                    <div class="uapboxyr_box3">
                    <?php
                        $valtemps = array();
                        if($template_product_profiles)
                        foreach ($template_product_profiles  as $ansval) {
                            if(!empty($ansval->product_name)) {
                                if(in_array($ansval->product_name,$valtemps)!==FALSE) continue;
                                echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->product_id.',2)" id="anchor2_'.$ansval->product_id.'">'.$ansval->product_name.'</a></div>';
                                $valtemps[]=$ansval->product_name;
                            }
                        }
                        unset($valtemps);
                    ?>
                    </div>
                </div>
            </div>
            <div id="AnsBlock22" style="display:none;">
                <div class="popupbox uapboxor" id="NNNNNNNN">
                    <div class="uapboxyr_box1">
                        <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                        <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                    </div>
                    <div class="uapboxyr_box2 boldWeight">
                        <span class="TextColor"></span> :
                    </div>
                    <div class="uapboxyr_box3">
                    <?php
                        $valtemps = array();
                        if($template_target_prospects)
                        foreach ($template_target_prospects  as $ansval) {
                            if(!empty($ansval->tp_text)) {
                                if(in_array($ansval->tp_text,$valtemps)!==FALSE) continue;
                                echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->tp_id.',2)" id="anchor2_'.$ansval->tp_id.'">'.$ansval->tp_text.'</a></div>';
                                $valtemps[]=$ansval->tp_text;
                            }
                        }
                        unset($valtemps);
                    ?>
                    </div>
                </div>
            </div><?php */?>
	
			<form action="<?php echo base_url()?>campaign/startcampaigncreate" method="POST" class="formRow" id="ccoord" style="padding:0px !important;" >   
							
				<!-- 
				<div class="changeCampaignTitle">
					<div class="widget tableTabs" style="width: 40%; margin: 20px auto">
						
						<div class="tab_container"> 
							<div id="ttab1" class="tab_content" style="height:33px; padding: 20px;">
								<label>Enter a name for this campaign </label>				   
								<input name="campaign[campaign_name]" type="text" value="<?php // echo $campaign_info->campaign_name ?>" style="-moz-box-sizing: border-box; background: none repeat scroll 0 0 #FDFDFD;border: 1px solid #D7D7D7; box-shadow: 0 1px 0 #FFFFFF; padding: 6px 5px; margin-left: 10px; float:right;" >
								<input type="hidden"  name="activeCampaign" value="<?php // echo $campaign_info->campaign_id ?>" />
							</div>
						</div>
					</div>
				</div>
				-->
				<div class="widget tableTabs">
					<!-- <div class="whead"><h6>Campaign Coordinate #1 – Product </h6><div class="clear"></div></div> -->
					<div class="tab_container">
						<div class="tab_content" id="ttab1" style="display: block;">
							<table width="100%" cellspacing="0" cellpadding="0" class="tDefault">
							<tbody>
								<tr>
									<td style="height:70px;" class="noBorderB">
                                    	<div style="padding-bottom: 30px;"><span class="hans1">Select the product that you want to build this campaign around.</span></div>
                                        
                                        <?php /*?><div><br />Or go back to <a href="<?php echo base_url();?>home/campaign-coordinates">Campaign Coordinates</a> to edit drop down list</div><?php */?>
									</td>
									<td class="no-border noBorderB">
                                    	<?php /*?><div class="row">
                                          <div class="col1"></div>
										  <div class="col2" style="width:23%;"><b>Select One</b></div> 	
                                        </div>
                                    	<div class="row">
                                          <div class="col1">
                                          	<div class="answerbox">
                                                <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('1',1,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('1',1,2,this)">User One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                <div id="ansList1"></div>
                                            </div>
                                          	<input type="text" class="txtinput gans1" name="product_id_txt" id="product_id_txt" value="" />
                                          
                                          </div>
                                          <div class="col2"><input type="radio" name="product_id_opt" class="product_id_opt" id="product_id_opt1" value="2" /></div>
                                        </div>									
										<?php
											// var_dump($allproduct);
											
										?><br /><br /><br /><br /><br /><?php */?>
                                        <div class="row">
										<?php $productName='';
											if(count($allproduct) > 0 ) { $productName=$allproduct[0]->product_name; ?>
                                        	<div class="col1">
											<select name="campaign[product_id]" style="width:305px; text-align:left;">
												<?php foreach($allproduct  as $singleproduct) { ?>
													<option value="<?php echo $singleproduct->product_id ?>" <?php if($singleproduct->product_id == $campaign_info->product_id) {echo 'selected';$productName=$singleproduct->product_name;} ?> > <?php echo $singleproduct->product_name ?> </option>
												<?php } ?>								
											</select>
                                            </div>
                                            <div class="col2" style="display:none"><input type="radio" name="product_id_opt" class="product_id_opt" id="product_id_opt2" value="1" /></div>
										  <?php } ?>
										<!-- <div class="dialog_open fs1 iconb" data-icon="" id="5"></div> -->
                                        </div>
									</td>
								</tr>
							</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div id="randerAjaxReg">						
                	<div class="widget tableTabs">						
						<div class="tab_container">
							<div id="ttab1" class="tab_content">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<tr id="TechTR" class="TechTrClass TechTR_<?php echo $campaign_info->campaign_id;?>">
												<td> 
                                                	<?php /*?><div><span class="hans2">Select the type of prospect that you want to target this campaign toward.</span></div>
                                                    <div><br />Or go back to <a href="<?php echo base_url();?>home/campaign-coordinates">Campaign Coordinates</a> to edit drop down list</div><?php */?>
                                                    <div>
                                                    	<span class="hans1">
                                                        	<p>Enter a label for target prospect that you want to direct this campiagn toward.</p>
                                                            <p>You can enter a title, name of company, industry description, size of business, description of individual.</p>
                                                            Examples:
                                                            <p>
                                                                <ul style="list-style:disc; padding-left:15px;">
                                                                	<li>VP's of HR</li>
                                                                    <li>CEOs</li>
                                                                    <li>Manufactures</li>
                                                                    <li>Finance Departments</li>
                                                                    <li>Home Owners</li>
                                                                    <li>Doctor offices</li>
                                                                    <li>Small Businesses</li>
                                                                    <li> Individuals</li>
                                                                </ul>                                                             
                                                            </p>
                                                    	</span>
                                                    </div>
                                                </td>
												<td class="no-border" style="vertical-align:top; text-align:right;float:right; padding-top:10px;">
                                                <?php /*?><div class="row">
                                                  <div class="col1"></div>
                                                  <div class="col2" style="width:23%;"><b>Select One</b></div> 	
                                                </div>
                                                <div class="row">
                                                  <div class="col1">
                                                  	<div class="answerbox">
                                                        <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('2',2,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                        <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('2',2,2,this)">User One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                        <div id="ansList2"></div>
                                                    </div>
                                                    <input type="text" class="txtinput gans2" name="tp_txt" id="tp_txt" value="" />                                                  
                                                  </div>
                                                  <div class="col2"><input type="radio" name="tp_opt" class="tp_opt" id="tp_opt1" value="2" /></div>
                                                </div>
                                                <br /><br /><br /><br /><br /><br /><?php */?>
                                                <div class="row">
                                                
                                                <?php $prospectName='';if($campaign_info->campaign_target == '1') { ?>
												<div class="col1">
													<?php /*?><textarea class="validate[required] dynamicTxt txttobech_<?php echo $campaign_info->campaign_id;?>_ind" style="width:350px;" name="campaign[individual]" id="V<?php  echo $campaign_info->campaign_id;?>" cols="" rows="" onkeyup="changetext('<?php echo  $campaign_info->campaign_id; ?>_ind')" ><?php echo (!empty($campaign_info->individual) ? $campaign_info->individual : NULL);?></textarea>
                                                <div align="center" class="TextColorH">Answer Checker</div>
                                                <div align="center">
                                                We want to sell <span class="dynamicFillTecArea TextColor"><?php // echo  isset($findproduct->product_name) ? $findproduct->product_name : '[my product]'?></span> to <span class="change_id_<?php echo $campaign_info->campaign_id; ?>_ind TextColor"><?php echo (!empty($campaign_info->individual) ? $campaign_info->individual : 'individual');?></span>.
                                                </div><?php */?>
                                                	<?php /*?><select name="campaign[individual]" >                                                    	
                                                    	<?php $sel=0;if(count($target_prospects) > 0 ) {$prospectName=$target_prospects[0]->tp_text; ?>
                                                        <?php foreach($target_prospects  as $singleproduct) { ?>
                                                            <option value="<?php echo $singleproduct->tp_text ?>" <?php if($singleproduct->tp_text == $campaign_info->individual) {echo 'selected';$sel=1;$prospectName=$singleproduct->tp_text;} ?> > <?php echo $singleproduct->tp_text ?> </option>
                                                        <?php } ?>								
                                                        <?php } ?>
                                                        <?php if(!$sel && !empty($campaign_info->individual)) {?>
                                                        <option value="<?php echo $campaign_info->individual ?>" selected="selected"><?php echo $campaign_info->individual;$prospectName=$campaign_info->individual; ?></option>
                                                        <?php } ?>
                                                    </select><?php */?>
                                                    
                                                    <input style="width:150px;" type="text" value="<?php echo $campaign_info->individual ?>"  name="campaign[individual]" id="prospect_sbox" />                                      
                                                    
                                               <input type="hidden" name="campaign[campaign_target]" value="1"  checked="checked" />
												</div>
                                                <?php } else { ?>
                                                <div class="col1">
													<?php /*?><textarea class="validate[required] dynamicTxt txttobech_<?php echo $campaign_info->campaign_id;?>_ind" style="width:350px;" name="campaign[organization]" id="V<?php  echo $campaign_info->campaign_id;?>" cols="" rows="" onkeyup="changetext('<?php echo  $campaign_info->campaign_id; ?>_ind')" ><?php echo (!empty($campaign_info->organization) ? $campaign_info->organization : NULL);?></textarea>
                                               <div align="center" class="TextColorH">Answer Checker</div>
                                                <div align="center">
                                                    We want to sell <span class=" TextColor "><?php // echo  isset($findproduct->product_name) ? $findproduct->product_name : '[my product]'?></span> to <span class="change_id_<?php echo $campaign_info->campaign_id;?>_org TextColor"><?php echo (!empty($campaign_info->organization) ? $campaign_info->organization : 'bussiness');?></span>. 
                                                </div><?php */?>
                                               <?php /*?> <select name="campaign[organization]" >                                                    	
                                                    	<?php $sel=0;if(count($target_prospects) > 0 ) {$prospectName=$target_prospects[0]->tp_text; ?>
                                                        <?php foreach($target_prospects  as $singleproduct) { ?>
                                                            <option value="<?php echo $singleproduct->tp_text ?>" <?php if($singleproduct->tp_text == $campaign_info->organization) {echo 'selected';$sel=1;$prospectName=$singleproduct->tp_text;} ?> > <?php echo $singleproduct->tp_text ?> </option>
                                                        <?php } ?>	
                                                        <?php } ?>
                                                        <?php if(!$sel && !empty($campaign_info->organization)) {?>
                                                        <option value="<?php echo $campaign_info->organization ?>" selected="selected"><?php echo $campaign_info->organization;$prospectName=$campaign_info->organization; ?></option>
                                                        <?php } ?>                                                        							
                                                    </select><?php */?>
                                                    
                                                    <input style="width:305px;" type="text" value="<?php echo $campaign_info->organization ?>"  name="campaign[organization]" id="prospect_sbox" />
                                                    
                                               <input type="hidden" name="campaign[campaign_target]" value="2"  checked="checked"/>
												</div>
                                                <?php } ?>
                                                <div class="col2" style="display:none"><input type="radio" name="tp_opt" class="tp_opt" id="tp_opt2" value="1" checked="checked" /></div>
                                                </div>
												</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
      
	   
                
                
					<?php /*?><div class="widget tableTabs">						
						<div class="tab_container">
							<div id="ttab1" class="tab_content">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<tr id="TechTR" class="TechTrClass TechTR_<?php echo $campaign_info->campaign_id;?>">
												<td  style="width: 70%;"> What is the title or role for the ideal individual that you want to direct this campaign at? 
														<br/> <br/> Examples: VP of IT, HR manager, Home owner, etc. </td>
												
												<td class="no-border" width="20%">
												<div class="grid5">
													<textarea class="validate[required] dynamicTxt txttobech_<?php echo $campaign_info->campaign_id;?>_ind" style="width:350px;" name="campaign[individual]" id="V<?php  echo $campaign_info->campaign_id;?>" cols="" rows="" onkeyup="changetext('<?php echo  $campaign_info->campaign_id; ?>_ind')" ><?php echo (!empty($campaign_info->individual) ? $campaign_info->individual : NULL);?></textarea>
													<div align="center" class="TextColorH">Answer Checker</div>
													<div align="center">
													We want to sell <span class="dynamicFillTecArea TextColor"><?php // echo  isset($findproduct->product_name) ? $findproduct->product_name : '[my product]'?></span> to <span class="change_id_<?php echo $campaign_info->campaign_id; ?>_ind TextColor"><?php echo (!empty($campaign_info->individual) ? $campaign_info->individual : 'individual');?></span>.
													</div>
												</div>
												</td>
												<td class="no-border"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="widget tableTabs">
						<div class="tab_container">
							<div id="ttab1" class="tab_content">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<tr>
											<td style="width: 70%;">What type of organization do you want to direct this campaign to?<br/><br/>Examples of organizations to target are businesses, small businesses, hospitals, IT departments, nonprofits, etc.<br/>
											</td>
											<td class="no-border">
											<textarea  class="validate[required] dynamicTxt txttobech_<?php echo $campaign_info->campaign_id; ?>_org" style="width:350px;" name="campaign[organization]" id="vs" cols="" rows="" onkeyup="changetext('<?php echo $campaign_info->campaign_id; ?>_org')" ><?php echo isset($campaign_info->organization) ?  $campaign_info->organization : 'businesses';?></textarea>
											<div align="center" class="TextColorH">Answer Checker</div>
											<div align="center">
												We want to sell <span class=" TextColor "><?php // echo  isset($findproduct->product_name) ? $findproduct->product_name : '[my product]'?></span> to <span class="change_id_<?php echo $campaign_info->campaign_id;?>_org TextColor"><?php echo (!empty($campaign_info->organization) ? $campaign_info->organization : 'bussiness');?></span>. 
											</div>
											</td>
											<td class="no-border">
												<!-- <div id="5" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div> -->
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					<div class="widget tableTabs">
						<div class="tab_container">
							<div id="ttab1" class="tab_content">
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
									<tbody>
										<tr id="TechTR<?php echo '';?>" class="TechTrClass TechTR_<?php echo '';?>">
												
												
												<td style="width: 70%;" > Do you want to direct this campaign at <span class="change_id_<?php echo $campaign_info->campaign_id; ?>_ind TextColor"><?php echo $campaign_info->individual; ?></span> or <span class="change_id_<?php  echo $campaign_info->campaign_id ; ?>_org TextColor"><?php echo $campaign_info->organization ; ?></span> ? </td>
												
												
												<!-- <td class="no-border" style="width: 38em;">a technical improvement (systems, processes, people) that it provides is that it helps to</td> -->
												<td class="no-border" width="20%">
												<div class="grid5">
													<div align="center" class="TextColorH">Select One</div>
													
													<input onClick="changeLastAnsChecker(this)" type="radio" name="campaign[campaign_target]" value="1"  <?php echo  ($campaign_info->campaign_target == '1') ?  'checked ' : '' ; ?> />  <span class="change_id_<?php echo $campaign_info->campaign_id; ?>_ind TextColor"><?php echo $campaign_info->individual; ?></span>
													<br/>
													<input onClick="changeLastAnsChecker(this)" type="radio" name="campaign[campaign_target]" value="2"  <?php echo  ($campaign_info->campaign_target == '2') ?  'checked ' : '' ; ?> /> <span class="change_id_<?php echo $campaign_info->campaign_id; ?>_org TextColor"><?php echo $campaign_info->organization; ?></span>
													
													<!-- 
													<div align="center" class="TextColorH">Answer Checker</div>
													<div align="center">
														We want to sell 
														<span class="TextColor ">
															<?php // echo  isset($findproduct->product_name) ? $findproduct->product_name : '[my product]'?>
														</span>  to 
														<span class="dynamicTxt_V<?php ?>_<?php ?> TextColor">
															
															<span id='individual' class="change_id_<?php //echo $campaign_info->campaign_id;?>_ind" style="display:<?php //if($campaign_info->campaign_target != '1') {echo 'none'; }?>" > <?php  // {echo $campaign_info->individual  ;}?></span>
															<span id='organization' class="change_id_<?php // echo $campaign_info->campaign_id;?>_org" style="display:<?php //if($campaign_info->campaign_target!= '2') {echo 'none';}?>" > <?php  // {  echo $campaign_info->organization ;} ?></span>
															
														</span>.
													</div> -->
												</div>
												</td>
												<td class="no-border"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div><?php */?>
					
					<script type="text/javascript" >
					
						function changeLastAnsChecker(obj){	
							var id = obj.value;
							
							console.log(id);

							
							if(id == 1){
								$('#individual').css('display','none');
								$('#organization').css('display','none');
								$('#individual').css('display','inline');
							
							}else{
								$('#individual').css('display','none');
								$('#organization').css('display','none');
								$('#organization').css('display','inline');
							}
						}
						
					</script>
		
				</div>
				
				<div class="fluid" style="margin-top:15px;">	
					<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
					<input type="submit" class="buttonM bRed" name="form_submit" value="Continue" />
					<input type="hidden" name="step" value="workflow" />
					<input type="hidden" id="redirect_url" name="redirect_url" value="" />
				</div>
		</form>		
	</div>	
</div>
<script>
	//set Answer
	function set_answer(gans,uans) {
		$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_"+gans).html());
		$("#pastanswers").hide();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
	//set Answer id
	function set_answer_id(gans,sno,uans,dis) {
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		//var qheader = $("#ansList"+gans+" span").html();
		var qheader = $(".hans"+gans).html();
		var AnList= $("#AnsBlock"+sno+''+uans).html().replace("NNNNNNNN","pastanswers");
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$("#pastanswers .uapboxyr_box2 span").html(qheader);
		//if($("#ansList"+gans).width()>400) $("#pastanswers").css("margin-left",($("#ansList"+gans).width()-400)+"px");
		//$(".gans"+gans).addClass('upaborder');
		$(dis).addClass('btactive');
		$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
		$(".btactive .ansdown").hide();
	}
	//Hide answer popup box
	function hide_answer() {
		$('#pastanswers').remove();
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
	 
 function fetchAssociateddata(product_id)
 {
    $.ajax({
		url : "<?php echo base_url();?>campaign/ajaxrender/"+product_id,
		type : 'POST',
		success : function(data){
				// console.log(data);
				$('#randerAjaxReg').html(data);
		}
	});
	
	$.ajax({
		url : "<?php echo base_url();?>campaign/changeTitle/"+product_id,
		type : 'POST',
		success : function(data){
				// console.log(data);
				$('.changeCampaignTitle').html(data);
		}
	});
 }
 
 function changetext(id)
 {
	 var texttochane = $('.txttobech_'+id).val();
	 console.log(texttochane);
	 $(".change_id_"+id).html(texttochane);
 }
 	//Open field changes
	$( document ).ready(function() {
		$("#product_id_txt").val("<?php echo $productName?>");
		$("#tp_txt").val("<?php echo $prospectName?>");
		//Product
		$( "#product_id_txt" ).change(function() {
			var productName = $(this).val();
			var productID = "";
			$( "#product_id_sbox option" ).each(function() {
				if(productName.toLowerCase()==$(this).text().toLowerCase()) productID = $(this).attr("value");
			});
			if(productID) {
				$( "#product_id_sbox" ).val(productID);
				$("#product_id_sbox").parent().find("span").html(productName);
			}
		});
		//Prospect
		$( "#tp_txt" ).change(function() {
			var prospectName = $(this).val();
			var prospectID = "";
			$( "#prospect_sbox option" ).each(function() {
				if(prospectName.toLowerCase()==$(this).text().toLowerCase()) prospectID = $(this).attr("value");
			});
			if(prospectID) {
				$( "#prospect_sbox" ).val(prospectID);
				$("#prospect_sbox").parent().find("span").html(prospectName);
			}
		});
		
		$( "#ccoord" ).submit(function() {
			//Product
			if($(".product_id_opt:checked").val()=="2") {
				var productName = $("#product_id_txt").val();
				var productID = "";
				$( "#product_id_sbox option" ).each(function() {
					if(productName.toLowerCase()==$(this).text().toLowerCase()) productID = $(this).attr("value");
				});
				if(productID) {
					$( "#product_id_sbox" ).val(productID);
					$("#product_id_sbox").parent().find("span").html(productName);
					$("#product_id_opt2").prop("checked",true);
				}
			}	
			//Prospect
			if($(".tp_opt:checked").val()=="2") {
				var prospectName = $("#tp_txt").val();
				var prospectID = "";
				$( "#prospect_sbox option" ).each(function() {
					if(prospectName.toLowerCase()==$(this).text().toLowerCase()) prospectID = $(this).attr("value");
				});
				if(prospectID) {
					$( "#prospect_sbox" ).val(prospectID);
					$("#prospect_sbox").parent().find("span").html(prospectName);
					$("#tp_opt2").prop("checked",true);
				}						
			}	
		});
	});
</script>
<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/cp6iccrOIgE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
$( document ).ready(function() {
    $('.help_dialog').dialog({
        autoOpen: false,
        height: 400,
        width: 600,
        buttons: {
            "Close": function () {
				$('.video').html('');
                $(this).dialog("close");
				
            }
        }    
    });
    
    // Invitation Dialog Link
    $('.dialog_help').click(function (e) {
		 $('.video').html(iframe);
         $('.help_dialog').dialog('open');
		 
        return false;
    });
	
	$('.ui-icon-closethick').click(function (e) {
		 $('.video').html('');
		  $('.help_dialog').dialog('close');
        return false;
    });
	
});
    
</script>
<div class="help_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video</title>
</head>

<body>
 <div class="video">
    




 </div>
</body>
</html></div>

<!-- Main content ends -->
<?php $this->load->view('common/footer'); ?>