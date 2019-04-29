<?php echo $this->load->view('common/meta');?>

<?php echo $this->load->view('common/header');?>

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
                <?php echo $this->load->view('common/progress_bar');?>
    <!-- Breadcrumbs line -->

    <?php echo $this->load->view('common/top_navigation');?>
 
    <!-- Main content -->
    <div class="wrapper">     
       <form id="validate" action="<?php echo current_url(); ?>" method="post">
              
                <div class="fluid">
                
                       <div class="widget grid6">
		 					<div class="whead"><h6>Getting Started</h6><div class="clear"></div></div>
								<div class="body">
							<!--  <h4>Getting Started</h4> -->
					      
					      <strong>What to Expect</strong>
					      <ul style="margin-left:30px;list-style:disc;">
					      	<li>The scripter takes you through eight stages of questions and each stage will have between 10 to 15 questions.</li>
					      	<li>The answers you provide will be plugged into other scripter questions and then into a library of scripts, templates, and sales tools.</li>
					     	<li>Most of the questions will be very easy to answer. Some of the early stages will have questions that may require some thought and wordsmithing. We offer a scripter walkthrough service if you need help composing answers.</li>
					     	<li>Going through the entire tool can take between 30 to 60 minutes, depending on the amount of brainstorming and discussion on your side.</li>
					     	<li>The scripter output is listed along the left margin and the items will light up when they are ready and have been populated.</li>	
					      </ul>
					      <br/>
					      <strong>A Couple of Tips</strong>
					      <ul style="margin-left:30px;list-style:disc;">
					      <li>Your answers will be plugged into the middle of sentences in the scripts and templates. As a result, keep your answers fairly short and written as sentence fragments to make the scripter produce the best output.</li>
					      <li>Avoid using and sentence beginning and ending grammar like capital letters and end punctuation. </li>
					      <!-- <li>The scripter will install a cookie on your PC that will allow you to come back and pick up where you left off if you are not able complete in one sitting.</li>
					      <li>If your settings do not allow a cookie to be install, please try to complete the scripter at one time.</li> -->
					      </ul>
							</div>
					</div>
                	<div class="widget grid6">
	                    <div class="formRow">
	                        <div class="grid2"><label>First Name</label></div>
	                        <div class="grid10"><input type="text" class="validate[required]" name="first_name" id="first_name" value="<?php echo (isset($gereral->first_name) ? $gereral->first_name : Null);?>"></div>
	                        <div class="clear"></div>
	                    </div>
	                    <div class="formRow">
	                        <div class="grid2"><label>Last Name</label></div>
	                        <div class="grid10"><input type="text" class="validate[required]" name="last_name" id="last_name" value="<?php echo (isset($gereral->last_name) ? $gereral->last_name : Null);?>"></div>
	                        <div class="clear"></div>
	                    </div>
	                    <div class="formRow">
	                        <div class="grid2"><label>Company</label></div>
	                         <div class="grid10"><input type="text" class="validate[required]" name="company" id="company" value="<?php echo (isset($gereral->company) ? $gereral->company : Null);?>"></div>
	                        <div class="clear"></div>
	                    </div>
	                    <div class="formRow">
	                        <div class="grid2"><label>Your Title</label></div>
	                        <div class="grid10"><input type="text" name="title" class="validate[required]" id="title" value="<?php echo (isset($gereral->title) ? $gereral->title : Null);?>"></div>
	                        <div class="clear"></div>
	                    </div>
	                   <div class="formRow">
	                        <div class="grid2"><label>Your Phone</label></div>
	                        <div class="grid10"><input type="text" name="phone" class="validate[required]" id="phone" value="<?php echo (isset($gereral->phone) ? $gereral->phone : Null);?>"></div>
	                        <div class="clear"></div>
	                    </div>
	                   <div class="formRow">
	                        <div class="grid2"><label>Your Website</label></div>
	                        <div class="grid10"><input type="text" name="website" class="validate[required]" id="website" value="<?php echo (isset($gereral->website) ? $gereral->website : Null);?>"></div>
	                        <div class="clear"></div>
	                    </div>
                    </div>
                    

			<div class="grid6">&nbsp;</div>
            </div>
            
          	<div align="right"><input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" /><input style="margin-top: -25px;" type="submit" class="buttonM bRed" name="submit" value="Continue" /></div>
          	<input type="hidden" name="id" value="<?php echo (isset($gereral->user_id) ? $gereral->user_id : Null);?>">

        </form>   
    </div>
    <!-- Main wrapper ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>
