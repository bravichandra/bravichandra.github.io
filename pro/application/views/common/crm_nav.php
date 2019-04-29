<div class="breadLine">
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs"> 
      		<?php 
				$c=count($breadcrumbs)-1;
				if(isset($breadcrumbs[0]['single'])) {?>
            <?php 
				foreach($breadcrumbs as $bc) {?>
           	<li>            
            <a href="<?php echo ($bc['url']?$bc['url']:'#');?>" class="nc<?php if($bc['single']=='Y') echo " selected";?>"><?php echo $bc['label'];?></a>
		   </li>
            <?php }?>
            <?php }else{?>
            <?php 				
				foreach($breadcrumbs as $n=>$bc) {?>
           	<li>            
            <a href="<?php echo ($bc['url']?$bc['url']:'#');?>" class="<?php if($c==$n) echo "selected"; if($c==$n) echo ' nc';?>"><?php echo $bc['label'];?></a>            
		   </li>
            <?php }?>
            <?php }?>
           
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