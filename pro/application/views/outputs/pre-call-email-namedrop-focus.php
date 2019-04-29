<?php $this->load->view('common/meta_outputs');?>
<title>Pre-Call Email – Name Drop Focus</title>
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
</style>
<?php if($button == True):?>
<style type="text/css">
table, caption, tbody, tfoot, thead, tr, th, td { margin: 0; padding: 0; border: 0; outline: 0; vertical-align: baseline; }
body, #content, table.output, table.output table {line-height: 18px;}
span.edit_area:hover {background: #F2F0A5;}
.td-pad-b {padding-bottom:17px;}
.btnDownload {background:url("../images/btn-download.jpg");width:108px;height:69px;display:block;}
.btnDownload:hover {background-position:0 -69px;}
</style>
<link rel="shortcut icon" href="http://salesscripter.com/wp-content/themes/Avada/images/favicon.ico" />
<link href="<?php echo base_url();?>css/jeditable_style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jeditable.js"></script>
<script>
$(document).ready(function() {
    $('.edit_area').editable('<?php echo base_url();?>product/dy_cam_up_entry', { 
    	   name     : 'value',
           id       : 'id',
    	   type 	: 'textarea',
    	   submit   : 'Update',
    	   width    : '400px',
           height   : '100px',
           tooltip  : "Click to edit...",
           style    : "",
           requireProductTxt : "[Requires another product to be added]",
           clsName	: 'edit_area',
           callback : function(value, settings) {
        }
    });
});
</script>
<?php endif; ?>
</head>
<body>
<div id="content">
	<?php
		$url = current_url();
		$templatename_ref = end(explode('/',$url));
		if($action != 'download'){
	?>
	<div class="sendtosalesforce"><a target="_blank" href="http://salesscripter.com/pro/page1.php?template=<?php echo $templatename_ref;?>" title="Send to Salesforce"><img src="http://salesscripter.com/pro/images/icons/download1.png"/></a></div>
    <?php } ?>

	<?php if($action != 'download'){?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">Pre&#45;Call Email &#45; Name Drop Focus</h1>
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
		<tr><td class="border">&nbsp;</td></tr>
		<tr>
		  <?php  // var_dump($active_name_drop_exp); die(); ?>
		  
			<td>
			<p>
				<p><strong>Subject line:</strong>   Helped <?php  echo  $active_name_drop_exp['worked']->credibility_name; ?> to <?php    echo $active_name_drop_exp['provided']->value; ?></p>
		        
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        <p>To quickly introduce myself, I am with  
		        <span><?php  echo $company_info->company_name; ?> </span> and we help 
		        <?php 
					if($campaign_info->campaign_target == '1'){	
							 echo $campaign_info->individual;
						}else{ 
							echo $campaign_info->organization;
					}
				?>
				to <?php echo ($campaign_tech_summary->value) ;?>.</p>
                        <p>
						Reason for the email is that we worked with  
						<?php  echo  $active_name_drop_exp['worked']->credibility_name; ?>
						and provided 
						<?php echo isset($active_name_drop_exp['worked']->value) ? $active_name_drop_exp[worked]->value : '[with]'; ?> .
						This helped them to
						<?php echo isset($active_name_drop_exp['provided']->value) ? $active_name_drop_exp['provided']->value : '[technical improvement]' ; ?>
						 which lead to 
						<?php echo isset($active_name_drop_exp['when']->value) ? $active_name_drop_exp['when']->value : '[business improvement]' ; ?>.	
                        </p>
		        <p>I don’t know if you are interested in any of those improvements and that is why I am reaching out to you. I will try to give you a call next week. 		</p>
				<p>If you are interested in talking before then, I can schedule a/an <?php echo $sale_process_close1->value; ?> next Tuesday or Thursday morning where we can <?php echo $sale_process_close2->value; ?>.</p>
		        
				<p>Best Regards,</p>
		        <p>
		        	<span><?php echo $company_meta['your_name'] ?></span>  <br />
		            <span><?php echo $company_meta['your_title'] ?></span> <br />
		            <span><?php echo $company_info->company_name ?></span> <br />
		            <span><?php echo $company_meta['your_phone'] ?></span> <br />
		            <span><?php echo $company_meta['your_email'] ?></span> <br />
		        </p>
		        <br/>
			</td>
		</tr>
	</table>
<?php echo $this->load->view('common/footer_outputs');?> 