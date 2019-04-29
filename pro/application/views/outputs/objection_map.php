<?php echo $this->load->view('common/meta_outputs');?>
<title><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></title>
<?php include_once('interactive/styles.php'); ?>
</head>
<body>
<?php include_once('interactive/preloadimages.php');?>   
<div id="content" class="questions objectionmap">
	<?php if($action != 'download' && $action != 'download2' && !$partid){ ?>
		<?php 	$this->load->view('common/logo');?>
	<?php } ?>
  <div class="main_content_sf" id="main_content_sf">
    <?php include_once('interactive/leftheader.php'); ?>
    <?php if(!$partid && $action!='download2') { ?>
  	<h1 align="center"><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></h1>	
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
  	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
  		 <tr><td colspan="3" class="border-bottom"><hr class="hrline" /></td></tr>
    <tr style="border-bottom:1px solid #000;">
      <th style="width:20%;">Objection</th>
      <th style="width:5%">&nbsp;</th>
      <th style="width:75%;">Response</th>
    </tr>
    
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php
  		$objs=array();
      $obj_autoids=array();
  		if(!empty($objectionInfo)) {
  			foreach($objectionInfo as $key => $obj_info)
  		{
  				if($obj_info->ob_defid) $objs[]=$obj_info->ob_defid;
          $obj_autoids[] = $obj_info->ob_id;
  	?>
    <tr>
      <td class="td-pad-bobm"><strong><?php echo $obj_info->ob_title; ?></strong><br/><br/></td>
      <td>&nbsp;</td>
      <td>
      	<?php if($obj_info->ob_rsptitle1){ ?>
          <p><b>Option 1: <?php echo $obj_info->ob_rsptitle1; ?></b></p>
          <?php }?>
  		<?php echo $obj_info->ob_rspcontent1; ?>
          <br>
  	</td>
    </tr>
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php if($obj_info->ob_rsptitle2){ ?>
    <tr>
      <td class="td-pad-bobm"><strong><?php echo $obj_info->ob_title; ?></strong><br/><br/></td>
      <td>&nbsp;</td>
      <td>
      	<?php if($obj_info->ob_rsptitle2){ ?>
          <p><b>Option 2: <?php echo $obj_info->ob_rsptitle2; ?></b></p>
          <?php }?>
  		<?php echo $obj_info->ob_rspcontent2; ?>
          <br>
  	</td>
    </tr>
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php }?>
    <?php if($obj_info->ob_rsptitle3){ ?>
    <tr>
      <td class="td-pad-bobm"><strong><?php echo $obj_info->ob_title; ?></strong><br/><br/></td>
      <td>&nbsp;</td>
      <td>
      	<?php if($obj_info->ob_rsptitle3){ ?>
          <p><b>Option 3: <?php echo $obj_info->ob_rsptitle3; ?></b></p>
          <?php }?>
  		<?php echo $obj_info->ob_rspcontent3; ?>
          <br>
  	</td>
    </tr>
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php }?>
    
    <?php }?>
    <?php }?>
    
    <?php  	
  		if(!empty($parts)) {
  			foreach($parts as $pi=>$pv)
  		{
  				if($pi<=4) continue;
  				if(in_array($pi,$objs)!=false) continue;
          if(in_array($pv['ob_id'],$obj_autoids)!=false) continue;
  				$oresp = $pv['resp'];
  	?>
    <tr>
      <td class="td-pad-bobm"><strong><?php echo $pv['title']; ?></strong><br/><br/></td>
      <td>&nbsp;</td>
      <td>
      	<?php if($oresp['resp1']){ ?>
          <p><b>Option 1: <?php echo $oresp['resp1']; ?></b></p>
          <?php }?>
  		<?php echo (isset($oresp['respc1'])?$oresp['respc1']:''); ?>
          <br>
  	</td>
    </tr>
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php if($oresp['resp2']){ ?>
    <tr>
      <td class="td-pad-bobm"><strong><?php echo $pv['title']; ?></strong><br/><br/></td>
      <td>&nbsp;</td>
      <td>
      	<?php if($oresp['resp2']){ ?>
          <p><b>Option 2: <?php echo $oresp['resp2']; ?></b></p>
          <?php }?>
  		<?php echo (isset($oresp['respc2'])?$oresp['respc2']:''); ?>
          <br>
  	</td>
    </tr>
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php }?>
    <?php if($oresp['resp3']){ ?>
    <tr>
      <td class="td-pad-bobm"><strong><?php echo $pv['title']; ?></strong><br/><br/></td>
      <td>&nbsp;</td>
      <td>
      	<?php if($oresp['resp3']){ ?>
          <p><b>Option 3: <?php echo $oresp['resp3']; ?></b></p>
          <?php }?>
  		<?php echo (isset($oresp['respc3'])?$oresp['respc3']:''); ?>
          <br>
  	</td>
    </tr>
    <tr><td colspan="3" class="border"><hr class="hrline" /></td></tr>
    <?php }?>
    
    <?php }?>
    <?php }?>
  	</table>
    <?php }?>
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
<?php $this->load->view('common/footer_outputs'); ?>