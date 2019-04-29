<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Interview Questions<?php echo (isset($QuestionName)) ?  ' - '.$QuestionName : '' ?></title>
<style>
body {font-size:13px;font-family: Arial, Helvetica, sans-serif;color:#000;}
ul {margin-bottom:0;}
.Section1 {margin:0 auto;width:990px;overflow:hidden;}
.Section1, table.output, table.output table {font-size:13px;font-weight: normal !important;line-height: 1.85px;}
table.output tr th {font-weight: bold;font-size:13px;}
table.output tr td span {}
table.output tr td.border {border-top:1px solid #000;}
table.output tr td.border-bottom {border-bottom:1px solid #000;}
table.output td.border-bottom {border-bottom: none !important;height: 20px;border-top: 1px solid #000;}
h1 {font-size:16px;}
p.topTxt {font-size: 13px; text-align: center; font-weight:bold;}
span.red, span.red-area, .red-area {color:red;}
</style></head>
<body style="font-family:Arial, Helvetica, sans-serif;">

<div style="width:100%; margin:0 auto;" class="Section1">

<h1 align="center" style="font-size:12pt;">Interview Questions</h1>
<h1 align="center" style="font-size:10pt;">
	<?php echo (isset($QuestionName)) ?  $QuestionName : '' ?> 
</h1>
<h1 align="center" style="font-size:18px;">
	<?php echo $job_details_cur->job_name; ?> 
</h1>

<table align="center" border="0" cellspacing="0" cellpadding="0" class="output" style="font-family:Arial, Helvetica, sans-serif; font-size:10pt; width:100%;">
	<tr><td colspan="3" style="border-bottom:1px solid;">&nbsp;</td></tr>
	<tr style="border-bottom:1px solid #000;">
		<td align="left" style="width:15%;"><br/><strong>Desired Requirements:</strong></td>
		<td style="width:5%"><br/>&nbsp;</td> 
		<td align="left" style="width:80%;">
			<br/>
			<?php foreach($desired_attributes as $dattr){?>			
			<li><?php echo $dattr->attr_name;?></li>
			<?php }?>
		</td>
	</tr>
	<tr><td colspan="3" style="border-bottom:1px solid;">&nbsp;</td></tr>
	<?php
	//print_r($que_details_cur);
	//print_r($que_details_intro);
	//print_r($que_details_closing);
	$ki = 1;
	$print_border = false;
	foreach($que_details_intro as $sngQuestion) { 
			if($ki == 1)
			{
				?>
					<tr style="border-bottom:1px solid #000;">
						<td align="left" style="width:15%;"><br/><strong>Intro Questions:</strong></td>
						<td style="width:5%"><br/>&nbsp;</td> 
						<td align="left" style="width:80%;">
						<br/>
				<?php
				
				$ki++;
				$print_border = true;
			}
			//print_r($sngQuestion);
	?>
			<li><?php echo $sngQuestion->question_name; ?></li>
	<?php
	}
	?>
		</td>
	</tr>
	<?php if($print_border) { ?>
	<tr><td colspan="3" style="border-bottom:1px solid;">&nbsp;</td></tr>
	<?php } 
	
	
	if(!empty($interviewQuestionInfo)) {
	$ki = 1;
	$print_border = false;
	$catids=array();
	foreach($interviewQuestionInfo as $sngQuestion) {
		$curcat = $catnames[$sngQuestion->attr_id];
		if(empty($curcat)) continue;
		if(in_array($curcat,$catids)===FALSE) {
		if($catids) { ?> <tr><td colspan="3" style="border-bottom:1px solid;">&nbsp;</td></tr> <?php echo '</ul></td></tr>'; }
		$catids[]=$curcat;
		$curcat = str_replace('Requirements', '', $curcat);
			if($ki == 1)
			{
				?>
					<tr style="border-bottom:1px solid #000;">
						<td align="left" style="width:15%;"><br/><strong><?php echo $curcat;  ?>:</strong></td>
						<td style="width:5%"><br/>&nbsp;</td> 
						<td align="left" style="width:80%;">
						<br/>
				<?php
				
				
				//$ki++;
				$print_border = true;
			}
	}?>
			<li><?php echo $sngQuestion->question_name; ?></li>
	<?php
	}	
	echo '</td></tr>';
	?>
	<?php if($print_border) { ?>
	<tr><td colspan="3" style="border-bottom:1px solid;">&nbsp;</td></tr>
	<?php }   ?>
	<?php } 
	
	$ki = 1;
	$print_border = false;
	foreach($que_details_closing as $sngQuestion) { 
			if($ki == 1)
			{
				?>
					<tr style="border-bottom:1px solid #000;">
						<td align="left" style="width:15%;"><br/><strong>Closing Questions:</strong></td>
						<td style="width:5%"><br/>&nbsp;</td> 
						<td align="left" style="width:80%;">
						<br/>
				<?php
				
				$ki++;
				$print_border = true;
			}
			//print_r($sngQuestion);
	?>
			<li><?php echo $sngQuestion->question_name; ?></li>
	<?php
	}
	?>
		</td>
	</tr>
	<?php if($print_border) { ?>
	<tr><td colspan="3" style="border-bottom:1px solid;">&nbsp;</td></tr>
	<?php } ?>
</table>
<br/><br/><br/>
<div align="center" style="margin-top:15px; font-size:9pt; clear:both;">
Contact us at (713) 802-2026 / info@salesscripter.com<br />
Copyright 2012-2015 SalesScripter, LLC  All Rights Reserved
</div>
</div>
</body>
</html>