<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/
  table th{ padding: 10px 0;}
</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>	    
	<!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>
<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
 <!-- Breadcrumbs line -->  
	<?php  		
  	  $this->load->view('common/crm_nav');
	  
	  $this->load->view('common/drop_menu');
	  
    ?>
	<div class="main-wrapper">
		<!-- Main content -->
        <form class='form_123' id="validate" action="<?php echo current_url();?>" method="post">
        	<input type="hidden" name="action" value="save-template-hiddens" />
            <table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault'>
                <thead>
                    <tr>                        
                        <th width="90%" class='no-border'>Title</th>
                        <th width='5%' class='no-border'>Hide</th>
                        <th width="5%" class='no-border'>Sort Order</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($all_templates as $vtemp) {
						if(!isset($vtemp->temp_id)) continue;
						$tmptitle = isset($etemplate[$vtemp->temp_id])?$etemplate[$vtemp->temp_id]:$vtemp->temp_title;
				?>
                    <tr>
                    	<td class='no-border'><?php echo $tmptitle; ?></td>
                        <td class='no-border' align="center">
                        	<input type="checkbox" value="<?php echo $vtemp->temp_id; ?>" name="hide[<?php echo $vtemp->temp_id; ?>]" <?php if(isset($temphides[$vtemp->temp_id])) echo 'checked="checked"';?> />
                            <input type="hidden" value="<?php echo form_prep($tmptitle);?>" name="tmp[<?php echo $vtemp->temp_id; ?>]" />                            
                        </td>                        
                        <td class='no-border'><input type="text" value="<?php echo (isset($tempsort[$vtemp->temp_id])?$tempsort[$vtemp->temp_id]:0);?>" class="rcorder" style="width: 30px;" name="sorts[<?php echo $vtemp->temp_id; ?>]" //></td>
                    </tr>
                <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"><input type="submit" class="buttonM bBlue" name="btn_hide" value="Save" /></th>
                    </tr>
                </tfoot>
            </table>
        </form>
	</div>
</div>
<!-- Main content ends -->
<?php $this->load->view('common/footer'); ?>