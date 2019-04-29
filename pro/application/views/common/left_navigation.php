<?php

	$lle=0;

	$lnav_links = array(15,45,41,42,43,46,55,16,6,9,8,14,13,'nut','spb','spa','st','crmt',51,'trash',98,'question','ssc');

	$lnav_links2 = array(1,2,3,5,6,7);

	$crm_nav = array('contact','lead','account','opportunity','task','qualifier','prospect','objection','crm','report','compose','eguesser','lists','opp_statistics');    

    $ivs_list = array('ivs','applicant','employee','jobs','job','quests','quest','jobpost','builder','pool','emails','send_mail','qlf','prospect');

    $ivjs_list = array('ivjs','jobs','yourprofile');

    $crm_settings = array('settings','zone','fields','sign','organization','edata','teamsearch','invitation','dropdowns','layout','mailchimp');



    if(!isset($ivs)) $ivs='';

    if(!isset($ivjs)) $ivjs='';

	if(in_array($d_page,$lnav_links)!=false) $lle=1;

	else if(in_array($train,$lnav_links)!=false) $lle=1;

	else if(in_array($page,$lnav_links2)!=false) $lle=1;

	else if(in_array($lnav,array('Y1','Y2'))!=false) $lle=1;

	else if(in_array($crmlite,$crm_nav)!=false) $lle=1;

	else if(in_array($maildelv,$crm_settings)!=false) $lle=1;

    else if(in_array($ivs,$ivs_list)!=false) $lle=1;

    else if(in_array($ivjs,$ivjs_list)!=false) $lle=1;

	$cb=0;

	if($lle && in_array($d_page,array(45,55,41,42,43,46,16,51,'trash',98,'question','ssc'))!=false) $cb=1;

	else if($lle && in_array($page,array(1,2,3,5,6,7))!=false) $cb=1;

	else if($lle && in_array($lnav,array('Y1','Y2'))!=false) $cb=1;

    $ivsb=0;

    if(in_array($ivs,$ivs_list)!=false) $ivsb=1;

    $ivj=0;

    if(in_array($ivj,$ivj_list)!=false) $ivj=1;

?>



<style>

.setting-drop{

 margin-left: 2px;

    margin-top: 0px;

    width: 21px;

    position: relative;

}

.icon-arrow-down:before {

    content: "\e09f";

    font-size: 25px;

    position: absolute;

    top: -9px;

}

span.iconn {

    width: 16px;

}

</style>



<div class="mainNav">

	<ul class="goo-collapsible goo-coll-stacked">



    <!-- 1. Dashboard -->

    <?php if(!isset($ejobseeker) && !isset($einterviewer)) {//Hide if job seeker, interviewer ?>

    <li class="nav-had" style="border-top: none;"><a style="background: none;" href="<?php echo base_url();?>dashboard" class="dashboard"><span class="iconn-h">Dashboard</span></a></li>

    <?php }?>



    <!-- 2. Sales Pitch Builder -->

    <?php if($AMuserShares['salespitch']) {// Sales Pitch Access //Hide Content builder ,interviewer?>

    <li class="nav-had"><a <?php if($cb) echo ' class="active"';?> href='#'><span class="iconn-h">Sales Message Builder</span></a>

   <!-- Main nav -->     

	<ul class="nav"<?php if(!$cb) echo ' style="display:none;"';?>>

        <li><a href="<?php echo base_url();?>folder/map" class="<?php if($d_page==55) echo 'active';?>"><span class="iconn icon-map_pin_fill" data-icon="&#xe015;"></span><span>Map</span></a></li>

    	<li><a href="<?php echo base_url();?>folder/prebuilt-campaigns" class="<?php if($d_page==46) echo 'active';?>"><span class="iconn icon-list" data-icon="&#xe015;"></span><span>Prebuilt Sales Pitches</span></a></li>

        <li><a href="<?php echo base_url();?>home/simplestart" class="<?php if($d_page=='ssc') echo 'active';?>"><span class="iconn icon-star" data-icon="&#xe015;"></span><span>Simple Start</span></a></li>

    	

	  <?php /*?> <li><a href="<?php echo base_url();?>home/campaign-coordinates" class="<?php if($d_page==51) echo 'active';?>"><span class="iconn icon-location" data-icon="&#xe015;"></span><span>Campaign Coordinates</span></a></li>	<?php */?>

        <li><a href="<?php echo base_url();?>folder/product-profile"  class="<?php if($d_page==45 || $lnav=='Y1') echo 'active';?>"><span class="iconn icon-steering_wheel" data-icon="&#xe015;"></span><span>Products</span></a></li>	              

       <li><a href="<?php echo base_url();?>folder/campaigns" class="<?php if($d_page==41 || $lnav=='Y2' || in_array($page,array(1,2,3,7))!=false) echo 'active';?>"><span class="iconn icon-target" data-icon="&#xe015;"></span><span>Sales Pitch Builder</span></a></li>

      

       <li><a href="<?php echo base_url();?>folder/company-profiles" class="<?php if($d_page==42 || $page==6) echo 'active';?>"><span class="iconn icon-libreoffice" data-icon="&#xe015;"></span><span>Company</span></a></li>

       <li><a href="<?php echo base_url();?>folder/name-drop-examples" class="<?php if($d_page==43 || $page==5) echo 'active';?>"><span class="iconn icon-user-4" data-icon="&#xe015;"></span><span>Name Drops</span></a></li>

       

       <li><a href="<?php echo base_url();?>home/sales_question" class="<?php if($d_page=="question") echo 'active';?>"><span class="iconn icon-clipboard" data-icon="&#e1ef;"></span><span>Question Builder</span></a></li>   

       

       

       <li><a href="<?php echo base_url();?>step/objection" class="<?php if($d_page==98) echo 'active';?>"><span class="iconn icol-stop" data-icon="&#e1ef;"></span><span>Response Builder</span></a></li>

		<!--<li><a <?php if($is_paid){ ?> href="<?php echo base_url();?>folder/pre-filled-campaigns" class="active" <?php } else {?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 active" <?php } ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Pre-Filled Campaigns</span></a></li>-->        

		

        <li><a href="<?php echo base_url();?>folder/trash"  class="<?php if($d_page=='trash') echo 'active';?>"><span class="iconn icol-trash" data-icon="&#xe015;"></span><span>Trash</span></a></li>

        

	</ul>	

    </li>

    <?php }// Sales Pitch Access?>



    <?php if(!isset($ejobseeker) && !isset($einterviewer)) {//Hide if job seeker ,interviwer?>



    <!-- 3. Sales Playbook -->
	
    <?php //if($AMuserShares['playbook']) {//Sales Playbook Access ?>

    

	<li class="nav-had"><a <?php if($lle && in_array($d_page,array(6,9,8,14,13,18,28))!=false) echo ' class="active"';?> href='#'><span class="iconn-h">Sales Playbook</span></a>	

	<ul class="nav"<?php if(in_array($d_page,array(6,9,8,14,13,18,28))==false) echo ' style="display:none;"';?>>

		<!-- <li><a href="<?php // echo base_url();?>folder/campaign-kits" class="active" ><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Campaign Kits</span></a></li> -->

		<li><a href="<?php echo base_url();?>folder/sales-scripts" class="<?php if($d_page==6) echo 'active';?>" ><span class="iconn icon-phone" data-icon="&#xe015;"></span><span>Sales Scripts</span></a></li>

		<li><a href="<?php echo base_url();?>folder/email-templates" class="<?php if($d_page==9) echo 'active';?>" ><span class="iconn icon-mail" data-icon="&#xe015;"></span><span>Prospecting Emails</span></a></li>

		<li><a  href="<?php echo base_url();?>folder/voicemail-script" class="<?php if($d_page==8) echo 'active';?>"><span class="iconn icon-loop-2" data-icon="&#xe015;"></span><span>Voicemail Scripts</span></a></li>

		<li><a href="<?php echo base_url();?>folder/responses-questions" class="<?php if($d_page==14) echo 'active';?>"><span class="iconn icon-list" data-icon="&#xe015;"></span><span>Key Questions</span></a></li>

		<?php /* //This section is commented to hide in PRO version Developer-A

		?><li><a <?php //if($class['step3'] == 'Active'){ ?> href="<?php echo base_url();?>folder/ideal-prospect-profile"  class="active" <?php // } ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Ideal Prospect</span></a></li><?php */?>

		<li><a href="<?php echo base_url();?>folder/marketing-output" class="<?php if($d_page==13) echo 'active';?>"><span class="iconn icon-star-3" data-icon="&#xe015;"></span><span>Marketing Documents</span></a></li>

		<!--  <li><a <?php //if($class['step1'] AND $class['step3'] == 'Active'){ ?> href="<?php echo base_url();?>folder/elevator-pitch" class="active" <?php //} ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Powerful Statements</span></a></li> -->         <!-- <li><a <?php //if($class['step2'] == 'Active'){ ?>  href="<?php echo base_url();?>folder/prospect-pain-points" class="active" <?php //} ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Prospect Pain Points</span></a></li> -->                  <!-- <li><a <?php //if($class['step4'] == 'Active'){ ?> href="<?php echo base_url();?>folder/qualifying-questions"  class="active" <?php //} ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Sales Questions</span></a></li> -->         <!-- <li><a <?php if($is_paid){ ?> href="<?php echo base_url();?>folder/building-interest" class="active" <?php } else {?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 active" <?php } ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Building Interest Silver Bullets</span></a></li> -->         <!-- <li><a <?php //if($class['step1'] == 'Active' AND $class['step2'] == 'Active' AND $class['step4'] == 'Active' AND $class['step8'] == 'Active'){ ?> href="<?php echo base_url();?>folder/objections-map" class="active" <?php //} ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Objections Map</span></a></li>  -->                                                                                                                                                                                                                                                                                                                                                                                          			<!-- <li><a <?php if($is_paid){ ?> href="<?php echo base_url();?>folder/name-drop-statments" class="active" <?php } else {?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 active" <?php } ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Name Drop Statement</span></a></li> -->		<!-- <li><a <?php if($is_paid){ ?> href="<?php echo base_url();?>folder/closing-questions" class="active" <?php } else {?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 active" <?php } ?>><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Closing Questions</span></a></li> -->		<!--  <li><a href="<?php echo base_url();?>folder/sales-presentation" class="active"><span style="font-size: 20px;" class="iconb" data-icon="&#xe015;"></span><span>Sales Presentation</span></a></li> -->		      

   </ul>

   </li>

   <?php //}//Sales Playbook Access?>



   <!-- 4. CRM Lite (Beta) -->

   <?php if($AMuserShares['crm']) {//CRM Lite Access?>



   <li class="nav-had" style="border-bottom: 1px solid #555555;"><a href='#'<?php if($lle && in_array($crmlite,$crm_nav)!=false) echo ' class="active"';?>><span class="iconn-h">CRM</span></a>

        <ul class="nav"<?php if(in_array($crmlite,$crm_nav)==false) echo ' style="display:none;"';?>>

			<li><a href="<?php echo base_url();?>crm/tasks" class="<?php if($crmlite=='task') echo 'active';?>"><span class="iconn icon-flag-2" data-icon="&#e123;"></span><span>Tasks</span></a></li>

            <li><a  href="<?php echo base_url();?>crm/contacts/all" class="<?php if($crmlite=='contact') echo 'active';?>"><span class="iconn icon-users" data-icon="&#e1e1"></span></span><span>Contacts</span></a></li>

            <li><a href="<?php echo base_url();?>crm/accounts/all" class="<?php if($crmlite=='account') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#e004"></span><span>Accounts</span></a></li>

            <?php /*?><li><a href="<?php echo base_url();?>crm/leads" class="<?php if($crmlite=='lead') echo 'active';?>"><span class="iconn icon-bars_alt" data-icon="&#e1b9;"></span><span>Leads</span></a></li><?php */?>

            <?php /*?><li><a href="<?php echo base_url();?>crm/opportunities" class="<?php if($crmlite=='opportunity') echo 'active';?>"><span class="iconn icon-thumbs-up-2" data-icon="&#e1ef;"></span><span>Opportunities</span></a></li>   <?php */?> 
			
			 <li><a href="<?php echo base_url();?>crm/opportunities" class="<?php if($crmlite=='opportunity' || $crmlite=='opp_statistics') echo 'active';?>"><span class="iconn icon-thumbs-up-2" data-icon="&#e1ef;"></span><span>Opportunities</span></a></li>
            

            <li><a href="<?php echo base_url();?>crm/lists" class="<?php if($crmlite=='lists') echo 'active';?>"><span class="iconn icon-list" data-icon="&#e1ef;"></span><span>Lists</span></a></li>

            <?php /*<li><a href="<?php echo base_url();?>crm/prospect" class="<?php if($crmlite=='prospect') echo 'active';?>"><span class="iconn icon-plus-2" data-icon="&#e1ef;"></span><span>Prospect Points</span></a></li>*/?>

            <li><a href="<?php echo base_url();?>crm/qualifier" class="<?php if($crmlite=='qualifier') echo 'active';?>"><span class="iconn icon-clipboard" data-icon="&#e1ef;"></span><span>Prospect Qualifier</span></a></li>

			<?php /*<li><a href="<?php echo base_url();?>crm/objections" class="<?php if($crmlite=='objection') echo 'active';?>"><span class="iconn icol-stop" data-icon="&#e1ef;"></span><span>Objections</span></a></li>*/?>

            <li><a href="<?php echo base_url();?>crm/report" class="<?php if($crmlite=='report') echo 'active';?>"><span class="iconn icon-bars" data-icon="&#e1ef;"></span><span>Reporting</span></a></li>

            <li><a href="<?php echo base_url();?>crm/compose" class="<?php if($crmlite=='compose') echo 'active';?>"><span class="iconn icon-mail" data-icon="&#e1ef;"></span><span>Send Prospecting Email</span></a></li>

            <li><a href="<?php echo base_url();?>crm/eguesser" class="<?php if($crmlite=='eguesser') echo 'active';?>"><span class="iconn icon-question_mark" data-icon="&#e1ef;"></span><span>Email Guesser</span></a></li>

            

            <li><a href="<?php echo base_url();?>crm/search" class="<?php if($crmlite=='search') echo 'active';?>"><span class="iconn icon-magnifying_glass" data-icon="&#e1ef;"></span><span>Advanced Search</span></a></li>

        </ul>

    </li>

    <?php }//CRM Lite Access?>



    <?php } ?>





    <?php if(!isset($ejobseeker)) {//Hide if job seeker?>



    <!-- 5. Staffing -->

    <?php if($AMuserShares['staffing']) {//Staffing Access?>

    <li class="nav-had" style="border-bottom: 1px solid #555555;"><a href='#'<?php if($ivsb) echo ' class="active"';?>><span class="iconn-h">Sales Recruiting</span></a>

        <ul class="nav"<?php if(!$ivsb) echo ' style="display:none;"';?>>

        	<li><a  href="<?php echo base_url();?>interviewer/builder" class="<?php if($ivs=='builder') echo 'active';?>"><span class="iconn icon-new" data-icon="&#xe015;"></span><span>Interview Builder</span></a></li>

            <li><a  href="<?php echo base_url();?>interviewer/applicant/all" class="<?php if($ivs=='applicant') echo 'active';?>"><span class="iconn icon-users" data-icon="&#e1e1"></span></span><span>Applicants</span></a></li>

             <li><a  href="<?php echo base_url();?>interviewer/qualifier" class="<?php if($ivs=='qlf') echo 'active';?>"><span class="iconn icon-clipboard" data-icon="&#e1ef;"></span><span>Applicant Qualifier</span></a></li>

             <li><a href="<?php echo base_url();?>interviewer/prospect" class="<?php if($ivs=='prospect') echo 'active';?>"><span class="iconn icon-arrow-up-2" data-icon="&#e1ef;"></span><span>Applicant Ranker</span></a></li>

            <li><a  href="<?php echo base_url();?>interviewer/employee/all" class="<?php if($ivs=='employee') echo 'active';?>"><span class="iconn icon-users" data-icon="&#e1e1"></span></span><span>Employees</span></a></li>

            <li><a  href="<?php echo base_url();?>interviewer/laborpool" class="<?php if($ivs=='pool') echo 'active';?>"><span class="iconn icon-users" data-icon="&#e1e1"></span></span><span>Labor Pool</span></a></li>  

            <li><a  href="<?php echo base_url();?>interviewer/jobpost" class="<?php if($ivs=='jobpost') echo 'active';?>"><span class="iconn icon-new" data-icon="&#xe015;"></span><span>Job Postings</span></a></li>

             <li><a  href="<?php echo base_url();?>interviewer/emails" class="<?php if($ivs=='emails') echo 'active';?>"><span class="iconn icon-mail" data-icon="&#xe015;"></span><span>Recruiting Emails</span></a></li>

              <li><a  href="<?php echo base_url();?>interviewer/compose" class="<?php if($ivs=='send_mail') echo 'active';?>"><span class="iconn icon-mail" data-icon="&#xe015;"></span><span>Send Recruiting Email</span></a></li>

             

        </ul>

    </li>

    <?php }//Staffing Access?>

    <?php }?>



    <?php if(!isset($is_prolite) && !isset($einterviewer)) {//Hide if prospect,interviewer?>

    <!-- 6. Staffing -->

    <li class="nav-had" style="border-bottom: 1px solid #555555;"><a href='#'<?php if($ivj) echo ' class="active"';?>><span class="iconn-h">Job Seeker</span></a>

        <ul class="nav"<?php if(!$ivjs) echo ' style="display:none;"';?>>   

            <li><a  href="<?php echo base_url();?>interviewer/yourprofile" class="<?php if($ivjs=='yourprofile') echo 'active';?>"><span class="iconn icon-users" data-icon="&#e1e1"></span></span><span>Your Profile</span></a></li>

            <li><a  href="<?php echo base_url();?>interviewer/jobs" class="<?php if($ivjs=='jobs') echo 'active';?>"><span class="iconn icon-new" data-icon="&#xe015;"></span><span>Jobs</span></a></li>

        </ul>

    </li> 

    <?php }?>

    



    <!-- 7. Training Resources -->

    <li class="nav-had" style="border-bottom: 1px solid #555555;"><a class='<?php if($lle && in_array($train,array('nut','sp101','rps'))!=false) echo ' class="active"';?>' href='#'><span class="iconn-h"><span>Training Resources</span></a>

            <ul class="nav"<?php if(in_array($train,array('nut','spb','spa','st','crmt'))==false) echo ' style="display:none;"';?>>

            	<?php if(!$is_prolite && !isset($ejobseeker)){?>

                <li><a  href="<?php echo base_url();?>folder/new-user-training" class="<?php if($train=='nut') echo 'active';?>"><span class="iconn icon-new" data-icon="&#xe015;"></span><span>SalesScripter Set Up</span></a></li>

                <?php }?>

                <?php if(!isset($ejobseeker)) {//Hide if job seeker?>

                <li><a  href="<?php echo base_url();?>folder/sales-training" class="<?php if($train=='st') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#xe015;"></span><span>Sales Playbook Training</span></a></li>

                <li><a  href="<?php echo base_url();?>folder/crm-training" class="<?php if($train=='crmt') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#xe015;"></span><span>CRM Training</span></a></li>

                <?php }?>

                <?php /*?><li><a href="<?php echo base_url();?>folder/sales-prospecting-101" class="<?php if($train=='sp101') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#xe015;"></span><span>SMART Sales Training</span></a></li>	                

                <li><a href="<?php echo base_url();?>folder/role-play-software" class="<?php if($train=='rps') echo 'active';?>"><span class="iconn icon-youtube-2" data-icon="&#xe015;"></span><span>Role-Play Software</span></a></li><?php */?>

                <li><a href="<?php echo base_url();?>folder/sales-prospecting-basics" class="<?php if($train=='spb') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#xe015;"></span><span>Sales Prospecting Basics</span></a></li>

                

                 <li><a href="<?php echo base_url();?>folder/sales-prospecting-techniques" class="<?php if($train=='spa') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#xe015;"></span><span>Sales Prospecting<br> Advanced Techniques</span></a></li>

                 

               <?php /*?> <li><a href="<?php echo base_url();?>folder/sales-prospecting-advanced" class="<?php if($train=='spa') echo 'active';?>"><span class="iconn icon-equalizer" data-icon="&#xe015;"></span><span>Sales Prospecting<br> Advanced Techniques</span></a></li><?php */?>

            </ul>

        </li>  



        <!-- 8. Settings -->

        <?php if(!isset($ejobseeker)) {//Hide if job seeker?>

        <li class="nav-had" style="border-bottom: 1px solid #555555;"><a href='#'<?php if($lle && in_array($maildelv,array('settings'))!=false) echo ' class="active"';?>><span class="iconn-h">Settings</span></a>

            <ul class="nav"<?php if($lle && in_array($maildelv,$crm_settings)==false) echo ' style="display:none;"';?>>                

                <li><a  href="<?php echo base_url();?>crm/settings" class="<?php if($maildelv=='settings') echo 'active';?>"><span class="iconn icon-mail" data-icon="&#xe015;"></span><span>Email</span></a></li>

                <li><a  href="<?php echo base_url();?>crm/settings/zone" class="<?php if($maildelv=='zone') echo 'active';?>"><span class="iconn icon-clock" data-icon="&#xe015;"></span><span>Time Zone</span></a></li>

                  <li><a  href="<?php echo base_url();?>crm/settings/dropdowns" class="<?php if($maildelv=='dropdowns') echo 'active';?>" style="padding-left:0px;"><span class="iconn icon-arrow-down setting-drop" data-icon="&#e1ef;" style="margin-left:2px;"></span><span style="padding-left:8px;">Edit Drop Downs</span></a></li>
                  
                  <li><a  href="<?php echo base_url();?>crm/settings/integrations" class="<?php if($maildelv=='integrations') echo 'active';?>"><span class="iconn icon-mail-2" data-icon="&#e1ef;"></span><span>Integrations</span></a></li>

                <?php if(isset($eScripter) && $eScripter){?>

                <li><a  href="<?php echo base_url();?>crm/settings/fields" class="<?php if($maildelv=='fields') echo 'active';?>"><span class="iconn icon-plus-2" data-icon="&#e1ef;"></span><span>Custom Fields</span></a></li>

                 <li><a  href="<?php echo base_url();?>crm/settings/layout" class="<?php if($maildelv=='layout') echo 'active';?>"><span class="iconn icon-plus-2" data-icon="&#e1ef;"></span><span>Fields Layout</span></a></li>

                 <li><a  href="<?php echo base_url();?>crm/settings/columns" class="<?php if($maildelv=='columns') echo 'active';?>"><span class="iconn icon-plus-2" data-icon="&#e1ef;"></span><span>Edit Columns</span></a></li>

                <li><a  href="<?php echo base_url();?>crm/settings/organization" class="<?php if($maildelv=='organization' || $maildelv=='invitation' || $maildelv=='teamsearch') echo 'active';?>"><span class="iconn icon-users" data-icon="&#e1ef;"></span><span>Organization</span></a></li>

				<?php /*?><li><a  href="<?php echo base_url();?>crm/settings/sign" class="<?php if($maildelv=='sign') echo 'active';?>"><span class="iconn icon-user" data-icon="&#xe015;"></span><span>Email Signature</span></a></li><?php */?>

               <li><a  href="<?php echo base_url();?>crm/settings/edata" class="<?php if($maildelv=='edata') echo 'active';?>"><span class="iconn icon-mail-2" data-icon="&#e1ef;"></span><span>Export Data</span></a></li>

                <?php }?>

            </ul>

        </li>       

        <?php }?>

    </ul>

</div>