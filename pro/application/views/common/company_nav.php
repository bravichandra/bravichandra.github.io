<div class="breadLine">

   <?php
     // var_dump($progress_data);
   ?>
   
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs">
                      
		<li <?php echo 'class="current"'; ?>> 
			<a href="<?php echo base_url();?>step/interest" <?php echo(($page == 6) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->interest)){?> <?php } echo((isset($progress_data->interest) AND $progress_data->interest == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Company</a>
		</li>
						           
      </ul>
   </div>
</div>