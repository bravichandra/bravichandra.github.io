<html>
<head>
<style type="text/css">
body {font-size:13px;font-family: Arial, Helvetica, sans-serif;color:#000;}
ul {margin-bottom:0;}
#content {margin:0 auto;width:990px;overflow:hidden;}
#content, table.output, table.output table {font-size:13px;font-weight: normal !important;line-height: 1.85px;}
table.output tr th {font-weight: bold;font-size:13px;}
table.output tr td span {}
table.output tr td.border {border-top:1px solid #000;}
table.output tr td.border-bottom {border-bottom:1px solid #000;}
h1 { font-size:16px;}
p.topTxt {font-size: 13px; text-align: center; font-weight:bold;}
span.red, span.red-area, .red-area {color:red;}
<?php if($action!='download' && $action!="download2"){?>
.qfQuest{list-style-type: none;}
.qfQuest .qfsublist{display:inline-block;text-decoration:none;font-size: 16px;color: #ff0000;margin-left: -18px;padding-right: 9px;}
.qfQuest ul{display:none;}
<?php } else {?>
.qfsublist{display:none;}
<?php } ?>
</style>
<?php if($button == True):?>
<style type="text/css">
table, caption, tbody, tfoot, thead, tr, th, td { margin: 0; padding: 0; border: 0; outline: 0; vertical-align: baseline; }
body, #content, table.output, table.output table {line-height: 18px;}

span.edit_area:hover {background: #F2F0A5;}
.td-pad-b { padding-bottom: 17px; width: 20%;}
.btnDownload {background:url("../images/btn-download.jpg");width:108px;height:69px;display:block;}
.btnDownload:hover {background-position:0 -69px;}

</style>
</style>
<link rel="shortcut icon" href="http://salesscripter.com/wp-content/themes/Avada/images/favicon.ico" />
<link href="<?php echo base_url();?>css/jeditable_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jeditable.js?body=<?php echo rand()?>"></script>
<script>
$(document).ready(function() {

    $('.edit_area').editable('<?php echo base_url();?>product/dy_cam_up_entry', { 
    	   name       : 'value',
           id         : 'id',
    	   type : 'textarea',
    	   submit   : 'Update',
    	   width      : '400px',
           height     : '100px',
           tooltip : "Click to edit...",
           style : "",
           requireProductTxt : "[Requires another product to be added]",
           clsName				: 'edit_area',
           callback : function(value, settings) {
           }
    });

});
</script>
<?php endif; ?>
<title><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Networking Script'; ?></title>
</head>

<body>
<div id="content">
	<?php if($action != 'download'){ ?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	
	<h1 align="center"><?php echo isset($uCustTemplate['template_title'])?$uCustTemplate['template_title']:'Networking Script'; ?></h1>
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
    <?php if($action != 'download' && $action!='download2') {
		include_once('interactive/go-through-button.php');
    }?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
		<tr><td colspan="3" class="border">&nbsp;</td></tr>
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
        <tr><td colspan="3" class="border-bottom">&nbsp;</td></tr>
        <?php			
				}
			}  if(!empty($template_sections)) {
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
        <tr><td colspan="3" class="border-bottom">&nbsp;</td></tr>
        <?php			
				}
			}		
		?> 
	</table>
</div>
<br />
<?php if($action!='download2') include_once('interactive/footer.php');?>
</div>

</body>
</html>