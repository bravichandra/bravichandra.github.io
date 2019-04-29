<html>
<head>
<?php include('interactive/styles.php'); ?>
<title><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title']; ?></title>
<style type="text/css">
		.list-items ul li, .q-resp li
		{
			display:list-item !Important;
		}
</style>
</head>
<body>
<?php include('interactive/preloadimages.php'); ?>
<div id="content" class="questions sales-templates">
	<?php if($action != 'download' && $action != 'download2' && !$partid){ ?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<?php include('interactive/left_navigation_is.php'); ?>
	<div class="main_content_sf" id="main_content_sf">
		<?php include('interactive/leftheader.php'); ?>
	<?php if(!$partid && $action!='download2') { ?>
	<h1 align="center"><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Inbound Call Script'; ?></h1>
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
			}  if(!empty($template_sections)) {
				foreach($template_sections as $tsection) {		
					if(isset($uCustTemplate['ignored_sections']) && $uCustTemplate['ignored_sections'])	{
						if(in_array($tsection->content_id,$uCustTemplate['ignored_sections'])!==FALSE) continue;
					}if($tsection->sect_title=='Hard Qualifying Questions'){} else { ?>
        <tr>
			<td class="td-pad-b">
            	<?php
					//echo '<pre>'; print_r($tabtitles); echo '</pre>';
					 if($tsection->content_id==4 || $tsection->content_id==212) {
						 if($tabtitles[0]->title!='') $title=$tabtitles[0]->title.' Questions'; else $title='Pre-Qualifying Questions';
                     }
					 else if($tsection->content_id==204  || $tsection->content_id==208) {
						 if($tabtitles[0]->title!='') $title=$tabtitles[1]->title.' Questions'; else $title='Need vs Want';
                     }
					 else if($tsection->content_id==205  || $tsection->content_id==209) {
						 if($tabtitles[0]->title!='') $title=$tabtitles[2]->title.' Questions'; else $title='Ability to Purchase';
                     }
					 else if($tsection->content_id==206  || $tsection->content_id==210) {
						 if($tabtitles[0]->title!='') $title=$tabtitles[3]->title.' Questions'; else $title='Decision Authority';
                     }
					 else if($tsection->content_id==207  || $tsection->content_id==211) {
						 if($tabtitles[0]->title!='') $title=$tabtitles[4]->title.' Questions'; else $title='Competition Level';
                     }
                    else $title = $tsection->sect_title;
				?>
            	<strong><?php echo $title; ?></strong><br>
            </td>
			<td>&nbsp;</td>
			<td>
            	<?php 
					$content_id=$tsection->content_id;
					include('custom_content/custom_etemplate_data.php');
				?>
			</td>
		</tr>
        <tr><td colspan="3" class="border-bottom"><hr class="hrline" /></td></tr>
        <?php }			
				}
			}		
		?>
	<?php if(!$partid && $action!='download2') { 
		include('interactive/footer.php');
	} ?>
<?php
}
else if($action == 'download2')
{
	include('interactive/get_notes.php');
}
else if($partid!='' && $partid <= $lastid && isset($parts[$partid]['content']))//By Dev@4489
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

	//echo " $ISleftNav && $partid && $lastid && ";
	//print_r($parts);

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
</div>
</body>
<?php include('interactive/script_interactive.php'); ?>
</html>