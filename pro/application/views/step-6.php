<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<script type="text/javascript" src="<?php echo site_url('tiny_mce/tiny_mce.js'); ?>"></script>
<script type="text/javascript">
	tinyMCE.init({
        document_base_url : "<?php echo base_url();?>",
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
		selector: "textarea",
		mode : "specific_textareas",
        editor_selector : "tinyMCE",
		theme : "advanced",
		height : "350",
		width: "900",
		
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,visualblocks,jbimages",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|preview,|,forecolor,backcolor,jbimages",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom"
	});
</script>
<style type="text/css">
	.widget {
		margin-bottom: 20px !important;
	}
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
	<?php //$this->load->view('common/progress_bar');?>    
	<!-- Breadcrumbs line -->    
	<?php // echo  $this->load->view('common/top_navigation');?>    
	<?php echo $this->load->view('common/company_nav');?>    
	<!-- Main content --> 

	<?php
	
		// var_dump($company_fact);
		$campid = $company_fact['0']->company_id ;
		$bus_exp = $this->campaign->findcompanyMetaData($campid,'business_exp');
		$awards_won = $this->campaign->findcompanyMetaData($campid,'awards_won');
		$area_operate = $this->campaign->findcompanyMetaData($campid,'area_operate');
		$your_name = $this->campaign->findcompanyMetaData($campid,'your_name');
		$your_title = $this->campaign->findcompanyMetaData($campid,'your_title');
		$your_phone = $this->campaign->findcompanyMetaData($campid,'your_phone');
		$your_email = $this->campaign->findcompanyMetaData($campid,'your_email');
		//amember profile
		$yname = $yemail = $yphone = "";
		if($aMember) {
			$yname = $aMember['name_f'].' '.$aMember['name_l'];
			$yemail = $aMember['email'];
			$yphone = $aMember['phone'];
		}
	
	?>

	
	<div class="wrapper">    
    	<input type="hidden" id="getanswer" value="0" />
        <div id="AnsBlock1" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                    <span class="TextColor">What are three company facts or bragging points that are worth mentioning?</span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
                    if($companyInterest_data)
                    foreach ($companyInterest_data  as $ansval) {
                        if(!empty($ansval->value)) {
                            if(in_array($ansval->value,$valtemps)!=false) continue;
                            echo '<div style="border:1px solid #999999; padding:4px;"><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
                            $valtemps[]=$ansval->value;
                        }	
                    }
                    unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock2" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0)" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                    <span class="TextColor">What are three company facts or bragging points that are worth mentioning?</span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
                    if($templateuser_companyInterest_data)
                    foreach ($templateuser_companyInterest_data  as $ansval) {
                        if(!empty($ansval->value)) {
                            if(in_array($ansval->value,$valtemps)!=false) continue;
                            echo '<div style="border:1px solid #999999; padding:4px;"><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',2)" id="anchor2_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
                            $valtemps[]=$ansval->value;
                        }	
                    }
                    unset($valtemps);
                ?>
                </div>
            </div>
        </div>       
		<form id="validate" action="<?php echo current_url();?>" method="post">
			<!-- <h3 style="margin-top:30px;">Identify the impact of doing nothing</h3> -->	
            
			
			
			
		<h3 style="margin-top:30px;color: black;">
					<span style="color: #B30814;">Company Info</span>
		</h3>
        <div class="widget tableTabs">
				<div class="tab_container">                
				<div id="ttab1" class="tab_content">   

				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
					<tbody>
						<thead>
						</thead>
							<tr> 
								<td class="no-border" style="width: 67%;" rowspan="3" >Enter the name of your company </td>
								<td class="no-border"><div class="grid5"><input name="cmp_[company_name][<?php echo $company_fact[0]->company_id ?>]" type="text" value="<?php echo $company_fact[0]->company_name ?>" style="-moz-box-sizing: border-box; background: none repeat scroll 0 0 #FDFDFD;border: 1px solid #D7D7D7; box-shadow: 0 1px 0 #FFFFFF; padding: 6px 5px; margin-left: 0px;width: 488px" /></div></td>
								<td class="no-border" >
									<!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
									</td>
							</tr>             
							 
						</tbody>                    
					</table>                
				</div>            
			</div>	            
			<div class="clear"></div>
		</div>
        <div class="widget tableTabs">
				<div class="tab_container">                
				<div id="ttab1" class="tab_content">   

				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
					<tbody>
						<thead>
						</thead>
							<tr> 
								<td class="no-border" style="width: 70%;" >Company Website Address </td>
                                <td class="no-border"><div class="grid5">
                                <?php
									$cwebsite = "";
									if($company_fact['0']->company_website!='') $cwebsite = $company_fact['0']->company_website;
									else $cwebsite='[website address]';
								?>
                                <input name="cmp_[company_website][<?php echo $company_fact[0]->company_id ?>]" type="text" value="<?php echo $cwebsite;?>" style="-moz-box-sizing: border-box; background: none repeat scroll 0 0 #FDFDFD;border: 1px solid #D7D7D7; box-shadow: 0 1px 0 #FFFFFF; padding: 6px 5px; margin-left: 0px;width: 488px" />
                                
                                </div></td>
                                
                                
								<td class="no-border" >
									<!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
									</td>
							</tr>             
							 
						</tbody>                    
					</table>                
				</div>            
			</div>	            
			<div class="clear"></div>
		</div>
        
        
        <div class="widget tableTabs">        
        <!-- <div class="whead"><h6>Company Facts</h6><div class="clear"></div></div>  -->
        <div class="tab_container">                
        <div id="ttab1" class="tab_content">      
        <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">         
            <tbody>                        	
                <thead>                            
                </thead>                            
                <tr>                                
                    <td class="no-border" style="width: 70%;"  rowspan="3" id="ansListhc" >What are three company facts or bragging points that are worth mentioning?</td>                                
                    <td class="no-border"><div class="grid5">
                    	<div class="answerbox">
                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('c1',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('c1',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div id="ansListc1"></div>
                        </div>
                    <textarea class="validate[required] dynamicTxt gansc1"  style="width:500px;height: 60px;" id="BI_7" name="cmpdt_[interest][<?php echo (isset($company_fact['0']->company_data_id) ? $company_fact['0']->company_data_id : 'new');?>]" cols="" rows=""><?php echo (isset($company_fact['0']->meta_value) ? $company_fact['0']->meta_value : '[company fact 1]');?></textarea>
                    
                    </div></td>                                 
                    <td class="no-border" >
                        <!-- <div class="grid5"><div id="22" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
                    </td>                            
                </tr>                            
                <tr>                                
                    <!-- <td class="no-border">One thing I may share with a prospect about my company to make a positive impression is</td> --> 
                    <td class="no-border"><div class="grid5">
                    	<div class="answerbox">
                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('c2',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('c2',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div id="ansListc2"></div>
                        </div>
                    <textarea class="validate[required] dynamicTxt gansc2"  style="width:500px;height: 60px;" id="BI_8" name="cmpdt_[interest][<?php echo (isset($company_fact['1']->company_data_id) ? $company_fact['1']->company_data_id : 'new');?>]" cols="" rows=""><?php echo (isset($company_fact['1']->meta_value) ? $company_fact['1']->meta_value : '[company fact 2]');?></textarea>
                    
                    </div></td>
                    <td class="no-border" >
                    <!-- <div class="grid5"><div id="22" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
                    
                    </td> 
                </tr>                            
                <tr>                                
                    <!-- <td class="no-border">One thing I may share with a prospect about my company to make a positive impression is</td>  -->                              
                    <td class="no-border"><div class="grid5">
                    	<div class="answerbox">
                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('c3',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('c3',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                            <div id="ansListc3"></div>
                        </div>
                        <textarea class="validate[required] dynamicTxt gansc3"  style="width:500px;height: 60px;" id="BI_9" name="cmpdt_[interest][<?php echo (isset($company_fact['2']->company_data_id) ? $company_fact['2']->company_data_id : 'new');?>]" cols="" rows=""><?php echo (isset($company_fact['2']->meta_value) ? $company_fact['2']->meta_value : '[company fact 3]');?></textarea>
                        
                        </div>                                
                            <!-- <div align="center" class="TextColorH">Answer Checker</div>	
                            <div align="center">  
                            Other key details about us are that we <span class="dynamicTxt_BI_7 TextColor">
                            <?php echo (isset($company_fact['0']->meta_value) ? $company_fact['0']->meta_value : '[company fact 1]');?></span>, <span class="dynamicTxt_BI_8 TextColor"><?php echo (isset($company_fact['1']->meta_value) ? $company_fact['1']->meta_value : '[company fact 2]');?></span>, and <span class="dynamicTxt_BI_9 TextColor"><?php echo (isset($company_fact['2']->meta_value) ? $company_fact['2']->meta_value : '[company fact 3]');?></span> 
                            </div>  -->                               
                            
                    </td>
                    <td class="no-border" >
                        <!-- <div class="grid5"><div id="22" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
                        </td>                            
                </tr>                        
            </tbody>                   
        </table>                
    </div>            
    </div>	            
    <div class="clear"></div>		         
    </div>
        
    
    <?php /*?> <h3 style="margin-top:30px;color: black;">
                <span style="color: #B30814;">Email Signature</span>
                <?php //echo '<pre>'; print_r($aMember); echo '</pre>'; ?>
    </h3>   
    <div class="widget tableTabs">
            <div class="tab_container">                
            <div id="ttab1" class="tab_content">   

            <table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
                <tbody>
                    <thead>
                    </thead>
                        <tr> 
                            <td class="no-border" style="width: 30%;" >&nbsp;</td>
                            <td class="no-border">
                                <div class="grid5">
                                	<?php 
										//echo '<pre>'; print_r($company_fact[0]); echo '</pre>'; 
										
										$mname = $aMember['yname'];
										if($mname=='') {$member_name ='[First Name] [Last Name]'; } else { if($mname=="0 0") $member_name ='[First Name] [Last Name]'; else $member_name = $mname; }
										
										$cname = $company_fact[0]->company_name;
										if($cname!='' || $cname!=0) $company_name = $cname; else $company_name ='[Company Name]';
										
										$pnumber = $aMember['yphone'];
										if($pnumber!='' || $pnumber!=0) $phone_number = $pnumber; else $phone_number ='[Phone Number]';										
										
										$email = $aMember['yemail'];
										
										if($email=='') {$email_address ='[Email Address]'; } else { if($email=="0") $email_address ='[Email Address]'; else $email_address = $email; }
										
										$website_field = $company_fact[0]->company_website;
										if($website_field!='') $website = $website_field; else $website='[Website Address]';
									?>
                                    <textarea id="contentdb<?php echo $n; ?>" class="tinyMCE" name="cmp_[email_signature][<?php echo $company_fact[0]->company_id ?>]"><?php if($company_fact[0]->email_signature!=''){ echo $company_fact[0]->email_signature;} else {  echo $member_name."<br/>".$company_name."<br/>".$phone_number."<br/>".$email_address."<br/>".$website; } ?></textarea>                            
                                </div>
                            </td>
                            <td class="no-border" >
                                <!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
                                </td>
                        </tr>             
                         
                    </tbody>                    
                </table>                
            </div>            
        </div>	            
        <div class="clear"></div>
    </div><?php */?>
    
    
    <h3 style="margin-top:30px;color: black;display:none;">
					<span style="color: #B30814;">Personal Info</span>
	</h3>

		<div class="widget tableTabs" style="display:none;">
				<div class="tab_container">                
				<div id="ttab1" class="tab_content">   

				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
					<tbody>
						<thead>
						</thead>
							<tr> 
								<td class="no-border" style="width: 70%;" rowspan="3" >What is your name ? </td>
								<td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt"  style="width:500px;" id="BI_4" name="cmpdt_[your_name][<?php echo (isset($your_name->company_data_id) ? $your_name->company_data_id : 'new');?>]" cols="" rows=""><?php echo $yname;?></textarea></div></td>
								<td class="no-border" >
									<!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
									</td>
							</tr>             
							 
						</tbody>                    
					</table>                
				</div>            
			</div>	            
			<div class="clear"></div>
		</div>
		
		
		<div class="widget tableTabs" style="display:none;">
				<div class="tab_container">                
				<div id="ttab1" class="tab_content">   

				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
					<tbody>
						<thead>
						</thead>
							<tr> 
								<td class="no-border" style="width: 70%;" rowspan="3" >What is your title ? </td>
								<td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt"  style="width:500px;" id="BI_4" name="cmpdt_[your_title][<?php echo (isset($your_title->company_data_id) ? $your_title->company_data_id : 'new');?>]" cols="" rows=""><?php echo (isset( $your_title->meta_value) ? $your_title->meta_value : '');?></textarea></div></td>
								<td class="no-border" >
									<!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
									</td>
							</tr>             
							 
						</tbody>                    
					</table>                
				</div>            
			</div>	            
			<div class="clear"></div>
		</div>
		
		
		<div class="widget tableTabs" style="display:none;">
				<div class="tab_container">                
				<div id="ttab1" class="tab_content">   

				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
					<tbody>
						<thead>
						</thead>
							<tr> 
								<td class="no-border" style="width: 70%;" >What is your email address ? </td>
								<td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt"  style="width:500px;" id="BI_4" name="cmpdt_[your_email][<?php echo (isset($your_email->company_data_id) ? $your_email->company_data_id : 'new');?>]" cols="" rows=""><?php echo $yemail;?></textarea></div></td>
								<td class="no-border" >
									<!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
									</td>
							</tr>             
							 
						</tbody>                    
					</table>                
				</div>            
			</div>	            
			<div class="clear"></div>
		</div>
		
		<div class="widget tableTabs" style="display:none;">
				<div class="tab_container">                
				<div id="ttab1" class="tab_content">   

				<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
					<tbody>
						<thead>
						</thead>
							<tr> 
								<td class="no-border" style="width: 70%;" >What is your phone number ? </td>
								<td class="no-border"><div class="grid5"><textarea class="validate[required] dynamicTxt"  style="width:500px;" id="BI_4" name="cmpdt_[your_phone][<?php echo (isset($your_phone->company_data_id) ? $your_phone->company_data_id : 'new');?>]" cols="" rows=""><?php echo $yphone;?></textarea></div></td>
								<td class="no-border" >
									<!-- <div class="grid5"><div id="21" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div> -->
									</td>
							</tr>             
							 
						</tbody>                    
					</table>                
				</div>            
			</div>	            
			<div class="clear"></div>
		</div>

		
	<!-- <h3 style="margin-top:30px;">Identify key company facts and details</h3>  -->
	        
<div class="fluid" style="margin-top:15px;"> 
	<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" />
	<input type="submit" class="buttonM bRed" name="submit" value="Done" />
	<input type="hidden" name="step" value="interest" /> 
	    
	</div>        
</form>        
</div>        
</div>    
</div>    
<!-- Main content ends -->
</div>
<!-- Content ends -->
<script type="text/javascript">
	//by Dev@4489
	//set Answer
	function set_answer(gans,uans) {
		$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_"+gans).html());
		$("#pastanswers").hide();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
	//set Answer id
	function set_answer_id(gans,uans,dis) {
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var AnList= $("#AnsBlock"+uans).html().replace("NNNNNNNN","pastanswers");
		//$("#ansList"+gans).prepend(AnList);
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
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
	////
</script>
<?php $this->load->view('common/footer');?>