<div class="breadLine">
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs">                                  
           <li>
			<a id="script1" href="<?php echo base_url();?>folder/prebuilt-campaigns" <?php echo($tb_insurance ? '':'class="selected"');?> 
            <?php echo($page == '99' ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>General</a>
		   </li>        
           <?php /*if($page == '98')*/{?>
           <li>
			<a id="script2" href="<?php echo base_url();?>folder/prebuilt-campaigns?insurance" <?php echo($tb_insurance ? 'class="selected"' : '');?> <?php echo($page == '98' ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Insurance</a>
		   </li>
           <?php }?>
      </ul>
   </div>
</div>
<style>
<?php /*?><?php if($page == '99'){?>
#script1
{
	background: none !important;
}
<?php }else{?>
#script2
{
	background: none !important;
}
<?php }?><?php */?>
#script2
{
	background: none !important;
}
</style>