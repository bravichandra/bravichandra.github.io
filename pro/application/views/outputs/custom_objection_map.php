<?php echo $this->load->view('common/meta_outputs');?>
<title>CUSTOM OBJECTIONS MAP</title>
</head>
<body>
<div id="content">
	<?php if($action != 'download'){?>
		<?php 	$this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">CUSTOM OBJECTIONS MAP</h1>	
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
		 <tr><td colspan="3" class="border-bottom">&nbsp;</td></tr>
  <tr style="border-bottom:1px solid #000;">
    <th style="width:20%;">Objection</th>
    <th style="width:5%">&nbsp;</th>
    <th style="width:75%;">Response</th>
  </tr>
  
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php
		$objs=array();
		if(!empty($objectionInfo)) {
			foreach($objectionInfo as $key => $obj_info)
		{
				if($obj_info->ob_defid) $objs[]=$obj_info->ob_defid;
	?>
  <tr>
    <td><strong><?php echo $obj_info->ob_title; ?></strong><br/><br/></td>
    <td>&nbsp;</td>
    <td>
    	<?php if($obj_info->ob_rsptitle1){ ?>
        <p><b>Option 1: <?php echo $obj_info->ob_rsptitle1; ?></b></p>
        <?php }?>
		<?php echo $obj_info->ob_rspcontent1; ?>
        <br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php if($obj_info->ob_rsptitle2){ ?>
  <tr>
    <td><strong><?php echo $obj_info->ob_title; ?></strong><br/><br/></td>
    <td>&nbsp;</td>
    <td>
    	<?php if($obj_info->ob_rsptitle2){ ?>
        <p><b>Option 2: <?php echo $obj_info->ob_rsptitle2; ?></b></p>
        <?php }?>
		<?php echo $obj_info->ob_rspcontent2; ?>
        <br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php }?>
  <?php if($obj_info->ob_rsptitle3){ ?>
  <tr>
    <td><strong><?php echo $obj_info->ob_title; ?></strong><br/><br/></td>
    <td>&nbsp;</td>
    <td>
    	<?php if($obj_info->ob_rsptitle3){ ?>
        <p><b>Option 3: <?php echo $obj_info->ob_rsptitle3; ?></b></p>
        <?php }?>
		<?php echo $obj_info->ob_rspcontent3; ?>
        <br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php }?>
  
  <?php }?>
  <?php }?>
  
  <?php  	
		if(!empty($parts)) {
			foreach($parts as $pi=>$pv)
		{
				if($pi<=4) continue;
				if(in_array($pi,$objs)!=false) continue;
				$oresp = $pv['resp'];
	?>
  <tr>
    <td><strong><?php echo $pv['title']; ?></strong><br/><br/></td>
    <td>&nbsp;</td>
    <td>
    	<?php if($oresp['resp1']){ ?>
        <p><b>Option 1: <?php echo $oresp['resp1']; ?></b></p>
        <?php }?>
		<?php echo (isset($oresp['respc1'])?$oresp['respc1']:''); ?>
        <br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php if($oresp['resp2']){ ?>
  <tr>
    <td><strong><?php echo $pv['title']; ?></strong><br/><br/></td>
    <td>&nbsp;</td>
    <td>
    	<?php if($oresp['resp2']){ ?>
        <p><b>Option 2: <?php echo $oresp['resp2']; ?></b></p>
        <?php }?>
		<?php echo (isset($oresp['respc2'])?$oresp['respc2']:''); ?>
        <br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php }?>
  <?php if($oresp['resp3']){ ?>
  <tr>
    <td><strong><?php echo $pv['title']; ?></strong><br/><br/></td>
    <td>&nbsp;</td>
    <td>
    	<?php if($oresp['resp3']){ ?>
        <p><b>Option 3: <?php echo $oresp['resp3']; ?></b></p>
        <?php }?>
		<?php echo (isset($oresp['respc3'])?$oresp['respc3']:''); ?>
        <br>
	</td>
  </tr>
  <tr><td colspan="3" class="border">&nbsp;</td></tr>
  <?php }?>
  
  <?php }?>
  <?php }?>
	</table>
</div>
<?php $this->load->view('common/footer_outputs'); ?>