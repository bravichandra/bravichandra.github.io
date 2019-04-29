<?php $this->load->view('common/meta_outputs');
?>
<title>Pre-Call Email - Qualify Focus</title>
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
	<h1 align="center">Pre-Call Email - Qualify Focus</h1>
	
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
			<td>
		        <p><strong>Subject line:</strong> 
		        
		        <?php echo $campaign_tech_summary->value ?>
		        </p>		        
		        
		        <p>Hello <span class="dynamic_value">[Prospect First Name]</span>,</p>
		        
		        <p>To quickly introduce myself, I am with  
		        <span><?php echo $company_info->company_name ?></span> and we help 

						<?php 
							if($campaign_info->campaign_target == '1'){	
								echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
							}
						?> to <?php echo $campaign_tech_summary->value; ?>.</p>
		        
		        <p> I have three quick questions to help determine if it makes sense to talk: </p>
				<p>
					<span class="red-area">(Choose three Yes/No questions from below to send)</span>
					
					<ul>
					<?php if(isset($campaign_output_tech_qualify)){
						foreach($campaign_output_tech_qualify as $comp){	?>
							<li>
							<?php echo $comp->value ?>
							</li>
						<?php 
						}
					}
					?>
					</ul>
				</p>
		        <p>If you answer "Yes" to any of those, we could likely have a very productive conversation. </p>
				<p>Let me know if you are interested in putting a few minutes on the calendar.</p>
		        
				<p>Best Regards,</p>
		        <p>
		        	<span><?php echo $company_meta['your_name'] ?></span><br />
		            <span><?php echo $company_meta['your_title'] ?></span> <br />
		            <span><?php echo $company_info->company_name ?></span> <br />
		            <span> <?php echo $company_meta['your_phone'] ?></span> <br />
		            <span><?php echo $company_meta['your_email'] ?></span> <br />
		        </p>
		        <br>
			</td>
		</tr>
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 