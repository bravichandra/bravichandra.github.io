<html>
<?php //error_reporting(E_ALL); ?>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<?php include_once('interactive/styles.php'); 
//echo $partid;
?>
<title><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Custom Script'; ?></title>
</head>
<body>
<?php include_once('interactive/preloadimages.php'); ?>
<div id="content" class="questions">
	
	<?php if($action != 'download' && $action != 'download2' && !$partid){ ?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<?php include('interactive/left_navigation_is.php'); ?>
    <div class="main_content_sf" id="main_content_sf">
		<?php include_once('interactive/leftheader.php'); ?>
<?php if(!$partid && $action!='download2') { ?>	
	<h1 align="center"><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Custom Script'; ?></h1>
	<p class="topTxt">
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
		include_once('interactive/go-through-button.php');
    } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
	<?php foreach($customTemplateInfo as $key => $temp_info)
		{
		
	?>
		<tr><td colspan="3" class="border-bottom">&nbsp;</td></tr>
		<tr style="border-bottom:1px solid #000;">
			<td style="width:15%;"><strong><?php echo $temp_info->heading; ?>:</strong></td>
			<td style="width:5%">&nbsp;</td> 
			<td style="width:80%;">
				<?php echo $temp_info->value; ?>
				<br/>
			</td>
		</tr>
		
     <?php
	 	 
		 }
	 ?>
	<tr><td colspan="3" class="border">&nbsp;</td></tr>
	</table>
    <?php if(!$partid && $action!='download2') { 
		include_once('interactive/footer.php');
	} ?>
    <?php }
	else if($action == 'download2')
	{	
		include_once('interactive/get_notes.php');
	}
	else if($partid!='' && $partid <= $lastid)
	{
		?>
		<h1 class="sub-dev-head"><?php echo $parts[$partid]['title'];?></h1>
		<div class="scroll-bar_sf">
		<p><?php echo $customTemplateInfo[$partid]->value; ?></p>
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
	?>
	<?php include_once('interactive/custom_data.php');?>
    <?php include_once('interactive/objection_data.php');?>
    </div>
    <?php if($action != 'download2' && $action != 'download' && $partid) {?>
    <div class="objection_content_sf" id="objection_content_sf">
    	<div class="objection_content_logo">
    	<?php echo $this->load->view('common/logo');?>
        </div>
   		<?php include_once('interactive/objection_content_side.php'); ?>
    </div>
    <?php } ?>
</div>
</body>
</html>