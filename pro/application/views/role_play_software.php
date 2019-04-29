<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/</style>
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
	<!-- Breadcrumbs line -->
	<?php  		
	$this->load->view('common/empty_nav');
	?> 	
	<!-- Start Search for a Team Member Form -->						    
	<!-- Main content -->
	<!-- Start Existing Team Members Conection -->							    
			<div class="wrapper">
				<!-- <div style="margin-top:10px;">							    		
				<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									
				<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        
					<div class="fluid">
						<div class="grid10">
							<div class="widget">
								<h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Role-Play Software</h1>
                                <iframe allowfullscreen="" frameborder="0" height="315" src="//www.youtube.com/embed/H07mVr7Yres" width="600"></iframe><br /><br />
<div class="roleplay">                                
<span style="font-size:16px;"><span style="font-family: arial,helvetica,sans-serif;">The role-play system allows you to practice your script and your pitch. Simply select a scenario from the drop down option below, enter your email address and phone number, and then your phone will ring.<br />
<br />
Once you go through the scenario and hang up, you will then be emailed a recording on what you did.<br />
<br />
Good luck and have fun with it! &nbsp; &nbsp; &nbsp;&nbsp; </span></span><br />
<div style="text-align: right;">
	&nbsp;</div>
<script language="JavaScript">
function Submitdata (form) {

var phone = form.npa.value .concat(form.nnx.value) .concat(form.line.value);

var script = form.selection.value;
var url = "http://secure.ifbyphone.com/click_to_xyz.php?app=CTS&phone_to_call="+escape(phone)+
                         "&survo_id="+script+ 
                        "&key=a774f459a72317830c7db5889657dbd8f7c07eb2"+
			"&p_t=" + escape(form.email.value);
if ((validate_script(script))*(validate_phone(phone))){
		window.location.href = url;    }

}

// Simple phone number validation that confirms that the data entered was 10 digits.

            function validate_phone(phone) {
             if (phone.length != 10) {
                    alert("Sorry, the phone number you entered does not have 10 digits! ");
                    return 0;
               }
             
            return 1;
            }
            
 // Validate that the value of the script is different than 1
             function validate_script(script) {
             if (script==1) {
                    alert("Please, select a valid script");
                    return 0;
               }
             
            return 1;
            }
</script>
<form method="get" name="myform" class="formRow">
	<p>&nbsp;
		</p>
	<p>
		<span style="font-family: arial;">Select a script</span> <select name="selection" size="1"><option selected="true" value="1">Select</option><option value="931694">Call Script - Qualify Focus (Guided)</option><option value="930354">Call Script - Qualify Focus (No Instructions)</option><option value="935594">Call Script - Custom</option><option value="931714">Objections Drill</option><option value="935604">Objections Drill - Custom Objections</option><option value="931724">Voicemail Message</option></select></p>
	<p>&nbsp;
		</p>
	<table>
		<tbody>
			<tr height="60">
				<td>
					<p>
						<span style="font-family: arial;">Enter your email address</span> <input id="email" name="email" size="50" type="text" /></p>
				</td>
			</tr>
		</tbody>
	</table>
	<table height="54" width="455">
		<tbody>
			<tr>
				<td>
					<span style="font-family: arial;">Enter your phone number</span> &nbsp; 1+( <input id="npa" maxlength="3" name="npa" size="3" type="text" style="width: 70px;" /> )- <input id="nnx" maxlength="3" name="nnx" size="3" type="text" style="width: 70px;" />- <input id="line" maxlength="4" name="line" size="4" type="text" style="width: 70px;" /></td>
			</tr>
		</tbody>
	</table>
	<input name="button" onclick="Submitdata(this.form)" type="button" value="Submit" class="buttonM bBlue" />&nbsp;</form>
<br />
</div>
							</div>
						</div>						
					</div>
				<?php // endif; ?>							
			</div>
			<!-- End Existing Team Members Conection -->
	<!-- End Search for a Team Member Form -->      
	</div>
	<!-- Main content ends -->
<?php $this->load->view('common/footer'); ?>
