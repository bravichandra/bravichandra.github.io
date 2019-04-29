<div class="breadLine">
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs">    
           <li >
			<a id="script1" href="<?php echo base_url();?>folder/sales-prospecting-101" <?php echo(empty($week) ? 'class="selected"' : NULL );?>  style="font-weight:bold;font-size: 12px;">Week 1</a>            
		   </li>
           <li >
			<a id="script1" href="<?php echo base_url();?>folder/sales-prospecting-101?w=2" <?php echo(!empty($week) && $week==2 ? 'class="selected"' : NULL );?> style="font-weight:bold;font-size: 12px;">Week 2</a>            
		   </li>
           <li >
			<a id="script1" href="<?php echo base_url();?>folder/sales-prospecting-101?w=3" <?php echo(!empty($week) && $week==3 ? 'class="selected"' : NULL );?> style="font-weight:bold;font-size: 12px;">Week 3</a>            
		   </li>
           <li >
			<a id="script1" href="<?php echo base_url();?>folder/sales-prospecting-101?w=4" <?php echo(!empty($week) && $week==4 ? 'class="selected"' : NULL );?> style="font-weight:bold;font-size: 12px;">Week 4</a>            
		   </li>
           
      </ul>
   </div>
</div>
<style>
#script1
{
	background: none !important;
}
</style>