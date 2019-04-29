<?php if($goth_btn_ctr!='') $intro = $goth_btn_ctr; else $intro = 'intro';
$cstemp = end(explode('/',current_url()));
 ?>
<p><?php 
	if($uCustTemplate['template_type']=='Interview Emails') $this->load->view('interview/staffing_drop_menu');
	else $this->load->view('common/his_drop_menu');
	?>
<span style="display:inline-block; margin-left:10px;padding-top: 6px;">
<?php if($uCustTemplate['template_type']=='Sales Scripts') {?>
<a class="gothrough" href="<?php echo base_url(); ?>output/<?php echo $method_name;?>/<?php echo $intro; ?>">Interactive Script</a>
<?php }?>
<?php if(($cstemp=='first-meeting-script' || $cstemp=='networking-scripts' || $cstemp=='meeting-for-coffee-script') && $uCustTemplate && !isset($is_prolite)) {?>
<a class="gothrough" href="<?php echo base_url(); ?>home/etemplate/<?php echo $uCustTemplate['temp_no']; ?>">Edit</a>
<?php } else if($uCustTemplate && !isset($is_prolite)) {?>
 | <a class="gothrough" href="<?php echo base_url(); ?>home/etemplate/<?php echo $uCustTemplate['temp_no']; ?>">Edit</a>
<?php }else if($cstemp=='custom-script' && !isset($is_prolite)) {?>
 | <a class="gothrough" href="<?php echo base_url(); ?>step/custom_content">Edit</a>
<?php }?>
</span>
</p>
<?php //print_r($parts); ?>
