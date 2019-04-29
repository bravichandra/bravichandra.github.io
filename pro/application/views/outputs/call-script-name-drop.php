<html>
<head>
<?php include('interactive/styles.php'); ?>
<title><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Call Script - Name Drop Focus'; ?></title>
</head>
<body>
<?php include('interactive/preloadimages.php'); ?>
<div id="content" class="questions">
	<?php if($action != 'download' && $action != 'download2' && !$partid){ ?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<?php include('interactive/left_navigation_is.php'); ?>
	<div class="main_content_sf" id="main_content_sf">
		<?php include('interactive/leftheader.php'); ?>
	<?php if(!$partid && $action!='download2') { ?>	
	<h1 align="center"><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Call Script &#45; Name Drop Focus'; ?></h1>
	<p class="topTxt"  >
		<?php echo $P_Q1->value; ?>  for 
		<?php 
			if($campaign_info->campaign_target == '1'){	
					echo $campaign_info->individual;
				}else{
					echo $campaign_info->organization;
			}
		?>
	</p>
    <?php  if($action != 'download' && $action!='download2') {
		include('interactive/go-through-button.php');
    } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr><td colspan="3" class="border-bottom"><hr class="hrline" /></td></tr>
		<?php 
			if(!empty($template_content)) {
				foreach($template_content as $tpldata) {
		?>
        <tr>
			<td class="td-pad-b"><strong><?php echo $tpldata->sect_title;?></strong><br></td>
			<td>&nbsp;</td>
			<td><?php echo $tpldata->sect_content;?>
			</td>
		</tr>
        <tr><td colspan="3" class="border-bottom"><hr class="hrline" /></td></tr>
        <?php			
				}
			} if(!empty($template_sections)) {
				foreach($template_sections as $tsection) {		
					if(isset($uCustTemplate['ignored_sections']) && $uCustTemplate['ignored_sections'])	{
						if(in_array($tsection->content_id,$uCustTemplate['ignored_sections'])!==FALSE) continue;
					}
		?>
        <tr>
			<td class="td-pad-b"><strong><?php echo $tsection->sect_title; ?></strong><br></td>
			<td>&nbsp;</td>
			<td>
            	<?php 
					$content_id=$tsection->content_id;
					include('custom_content/custom_etemplate_data.php');
				?>
			</td>
		</tr>
        <tr><td colspan="3" class="border-bottom"><hr class="hrline" /></td></tr>
        <?php			
				}
			}		
		?>
	</table>

	<?php if(!$partid && $action!='download2') { 
		include('interactive/footer.php');
	} ?>
<?php } 
else if($action == 'download2')
{	
	include('interactive/get_notes.php');
}
	else if($ISleftNav && $partid!='' && $partid <= $lastid && isset($parts[$partid]['content']))//By Dev@4489
	{
		?>
		<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
		<div class="scroll-bar_sf">
		<p><?php echo $parts[$partid]['content']; ?></p>
		</div>
		
		<?php
	 	$temp = end(explode('/',current_url()));
		if($partid == 1)$back_step = str_replace($temp,'objection-responses',current_url());
		else $back_step = str_replace($temp,$parts[$partid-1]['name'],current_url());
		if($partid != count($parts))$front_step = str_replace($temp,$parts[$partid+1]['name'],current_url());
		else $front_step = str_replace($temp,'',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$last_step = false;		
	}
else if($partid == 1 && $partid <= $lastid)
{
include('interactive/introduction_data.php');
$temp = end(explode('/',current_url()));
$back_step = str_replace($temp,'objection-responses',current_url());
$front_step = str_replace($temp,$parts[$partid+1]['name'],current_url());
$fav_step = str_replace($temp,'close',current_url());
$last_step = false;
}
else if($partid == 2 && $partid <= $lastid)
{
?>
	<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
    <!-- Start -->
	<div class="scroll-bar_sf"><?php $content_id=13;include('custom_content/custom_etemplate_data.php');?></div>
    <!-- End -->
    
<?php
$temp = end(explode('/',current_url()));
$back_step = str_replace($temp,$parts[$partid-1]['name'],current_url());
$front_step = str_replace($temp,$parts[$partid+1]['name'],current_url());
$fav_step = str_replace($temp,'close',current_url());
$last_step = false;
}
else if($partid == 3 && $partid <= $lastid)
{
include('interactive/pre_qualify_data.php');
$temp = end(explode('/',current_url()));
$back_step = str_replace($temp,$parts[$partid-1]['name'],current_url());
$front_step = str_replace($temp,$parts[$partid+1]['name'],current_url());
$fav_step = str_replace($temp,'close',current_url());
$last_step = false;
}
else if($partid == 4 && $partid <= $lastid)
{
include('interactive/common_problems_data.php');
$temp = end(explode('/',current_url()));
$back_step = str_replace($temp,$parts[$partid-1]['name'],current_url());
$front_step = str_replace($temp,$parts[$partid+1]['name'],current_url());
$fav_step = str_replace($temp,'close',current_url());
$last_step = false;
}
else if($partid == 5 && $partid <= $lastid)
{
include('interactive/about_us_data.php');
$temp = end(explode('/',current_url()));
$back_step = str_replace($temp,$parts[$partid-1]['name'],current_url());
$front_step = str_replace($temp,$parts[$partid+1]['name'],current_url());
$fav_step = str_replace($temp,'close',current_url());
$last_step = false;
}
else if($partid == 6 && $partid <= $lastid)
{
include('interactive/close_data.php');
$temp = end(explode('/',current_url()));
$back_step = str_replace($temp,$parts[$partid-1]['name'],current_url());
$front_step = str_replace($temp,'',current_url());
$fav_step = str_replace($temp,'close',current_url());
$last_step = false;
}
if($ISleftNav) include_once('interactive/custom_data.php');//By Dev@4489
?>
<?php include('interactive/objection_data.php');?>
</div>
<?php if($action != 'download2' && $action != 'download' && $partid) {?>
<div class="objection_content_sf" id="objection_content_sf">
	<div class="objection_content_logo">
	<?php echo $this->load->view('common/logo');?>
	</div>
	<?php include('interactive/objection_content_side.php'); ?>
</div>
<?php } ?>
</body>
<?php include('interactive/script_interactive.php'); ?>
</html>