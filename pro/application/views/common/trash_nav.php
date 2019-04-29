<div class="breadLine">
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs"> 
      		<?php 
				$c=count($breadcrumbs)-1;
				foreach($breadcrumbs as $n=>$bc) {?>
           	<li>            
            <a href="<?php echo ($bc['url']?$bc['url']:'#');?>" class="<?php if($c==$n) echo "selected"; if($c==$n) echo ' nc';?>"><?php echo $bc['label'];?></a>            
		   </li>
            <?php }?>
           <?php /*?><li >
			<a href="<?php echo base_url();?>folder/sales-prospecting-101?w=4" <?php echo(!empty($week) && $week==4 ? 'class="selected"' : NULL );?> style="font-weight:bold;font-size: 12px;">Week 4</a>            
		   </li><?php */?>
           
      </ul>
   </div>
</div>
<style>
#breadcrumbs li a
{
	font-weight:bold;font-size: 12px;
}
#breadcrumbs li a.nc
{
	background: none !important;
}
</style>