<div class="breadLine">
   <?php
     // var_dump($progress_data);
   ?>
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs">
         <!-- <li><a href="<?php echo base_url();?>" <?php echo(($page == 'register' and $page != '0') ? 'class="selected"' : 'style="color:#030303; font-size:12px; font-weight:bold;"');?>>Home</a>              		</li> -->                          
         <li <?php echo((!empty($progress_data->product) AND $progress_data->product == FALSE) ? 'class="current"' : NULL );?>>                			 <a href="<?php echo base_url();?>step/product" <?php echo(($page == '0') ? 'class="selected"' : Null);?><?php if(isset($progress_data->product) AND $next_page = 0){?> <?php } echo((isset($progress_data->product) AND $progress_data->product == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px; background: none !important;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;background: none !important;"' );?>>Product Details</a>              		 </li>
                  
      </ul>
   </div>
</div>