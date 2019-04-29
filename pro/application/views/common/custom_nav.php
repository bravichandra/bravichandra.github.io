<div class="breadLine">
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs">                                  
           <li>
			<a id="script1" href="<?php echo base_url();?>step/custom_content/<?php echo $ecampaign_id;?>-cg" <?php echo($page == '99' ? 'class="selected"' : Null);?> 
            <?php echo($page == '99' ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Script</a>
		   </li>        
           <?php /*if($page == '98')*/{?>
           <li>
			<a id="script2" href="<?php echo base_url();?>step/objection/<?php echo $ecampaign_id;?>" <?php echo(($page == '98') ? 'class="selected"' : Null);?> <?php echo($page == '98' ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Objections</a>
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