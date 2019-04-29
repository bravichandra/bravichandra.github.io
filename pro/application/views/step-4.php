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
                <?php //$this->load->view('common/progress_bar');?>
    <!-- Breadcrumbs line -->

    <?php echo $this->load->view('common/top_navigation');?>
 
    <!-- Main content -->
    <div class="wrapper">     
	<form id="validate" action="<?php echo current_url();?>" method="post">
	<h3 style="margin-top:30px;">Identify the demographic details of your ideal prospect</h3>
       <div class="widget tableTabs">
                <div class="whead" align="center"><h6>Demographic Details</h6><div class="clear"></div></div>
            <div class="tab_container">
            
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        
                        <tbody>
                        <thead>
                        </thead>
                            <tr>
                                <td class="grid5 no-border"><b>Geography</b></td>
                                <td class="no-border">Enter the geographical area that it makes sense for you to focus on.</td>
                                <td class="no-border"><div class="grid5"><textarea class="validate[required]" id="IP_1" name="tud_[target][<?php echo (isset($target['0']->user_data_id) ? $target['0']->user_data_id : 'new');?>][]" style="width:350px;" cols="" rows=""><?php echo (!empty($target['0']->value) ? $target['0']->value : '[target geography]');?></textarea></div></td>
                            	<td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            
                            <tr>
                                <td class="grid5 no-border" rowspan="2"><b>Size</b></td>
                                <td class="no-border">Enter the smallest size of business that you should spend your valuable time trying to sell to. Enter either an annual revenue figure or total employee count.</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" id="IP_2" name="tud_[target][<?php echo (isset($target['1']->user_data_id) ? $target['1']->user_data_id : 'new');?>][]" style="width:350px;" cols="" rows=""><?php echo (!empty($target['1']->value) ? $target['1']->value : '[smallest prospect]');?></textarea></div></td>
                            	<td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                           <tr style="background:#F2F2F2;">
                                <!-- <td class="grid5 no-border" style="width: 25em;" >&nbsp;</td>  -->
                                <td class="no-border">Enter the largest size of business that you should spend your valuable time trying to sell to. Enter either an annual revenue figure or total employee count.</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" id="IP_10" name="tud_[target][<?php echo (isset($target['2']->user_data_id) ? $target['2']->user_data_id : 'new');?>][]" style="width:350px;" cols="" rows=""><?php echo (!empty($target['2']->value) ? $target['2']->value : '[largest prospect]');?></textarea></div></td>
                            	<td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            
                            <tr style="background:none;">
                              <td class="grid5 no-border" rowspan="2"><b>Industry</b></td>
                                <td class="no-border">What industries do you fit best with?</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" style="width:350px;" id="IP_3" name="tud_[target][<?php echo (isset($target['3']->user_data_id) ? $target['3']->user_data_id : 'new');?>][]" cols="" rows="2"><?php echo (!empty($target['3']->value) ? $target['3']->value : '[target industries]');?></textarea></div></td>
                                <td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            <tr>
                              	<!-- <td class="grid5 no-border" style="width: 25em;" ><b></b></td> -->
                                <td class="no-border">What industry do you not fit well with?</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" style="width:350px;" id="IP_14" name="tud_[target][<?php echo (isset($target['4']->user_data_id) ? $target['4']->user_data_id : 'new');?>][]" cols="" rows="2"><?php echo (!empty($target['4']->value) ? $target['4']->value : '[excluded industries]');?></textarea></div></td>
                                <td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            
                             <tr>
                              	<td class="grid5 no-border" rowspan="2"><b>Departments</b></td>
                                <td class="no-border">What is the best department for you sell into?</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" style="width:350px;" id="IP_4" name="tud_[target][<?php echo (isset($target['5']->user_data_id) ? $target['5']->user_data_id : 'new');?>][]" cols="" rows="2"><?php echo (!empty($target['5']->value) ? $target['5']->value : '[target department]');?></textarea></div></td>
                                <td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                             <tr style="background:#F2F2F2;">
                              	<!-- <td class="grid5 no-border" style="width: 25em;" ><b></b></td> -->
                                <td class="no-border">When you are not able to get into the primary target department, what is a secondary department that may buy from you?</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" style="width:350px;" id="IP_18" name="tud_[target][<?php echo (isset($target['6']->user_data_id) ? $target['6']->user_data_id : 'new');?>][]" cols="" rows="2"><?php echo (!empty($target['6']->value) ? $target['6']->value : '[target department]');?></textarea></div></td>
                                <td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            
                             <tr style="background:none;">
                              	<td class="grid5 no-border" rowspan="2"><b>Title</b></td>
                                <td class="no-border">What is the title of the decision maker that you are trying to reach?</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" style="width:350px;" id="IP_5" name="tud_[target][<?php echo (isset($target['7']->user_data_id) ? $target['7']->user_data_id : 'new');?>][]" cols="" rows="2"><?php echo (!empty($target['7']->value) ? $target['7']->value : '[target title]');?></textarea></div></td>
                                <td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            <tr>
                              	<!-- <td class="grid5 no-border" style="width: 25em;" ><b></b></td> -->
                                <td class="no-border">If you are not able to reach the decision make, what is another position to try to reach?</td>
                                <td class="no-border"><div class="grid5"><textarea  class="validate[required]" style="width:350px;" id="IP_6" name="tud_[target][<?php echo (isset($target['8']->user_data_id) ? $target['8']->user_data_id : 'new');?>][]" cols="" rows="2"><?php echo (!empty($target['8']->value) ? $target['8']->value : '[target title]');?></textarea></div></td>
                                <td class="no-border"><div class="grid5"><div id="9" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>		 
        </div>
        
        
        <div class="fluid" style="margin-top:15px;">
          	<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" /><input type="submit" class="buttonM bRed" name="submit" value="Continue" />
          	<input type="hidden" name="step" value="target">
          	
          	<div align="right"><a href="http://leadferret.com/search" target="_blank"><img src="<?php echo base_url();?>images/lf.jpg" width="200" style="border: 0 none;"/></a></div>
        </div>
        </form>
        </div>
            
        </div>
        
        
        
    </div>
    <!-- Main content ends -->
            
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>
