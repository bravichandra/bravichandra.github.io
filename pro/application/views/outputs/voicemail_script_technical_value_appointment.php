<?php $this->load->view('common/meta_outputs');?>
<title>Voicemail Script &#45; Value ( Appointment Request)</title>
</head>
<body>
<div id="content">
	<?php if($action != 'download'){?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">Voicemail Script &#45; Value Focus ( Appointment Request)</h1>
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
		        <p>Hello <span class="red-area" >[Prospect First Name]</span>
				   this is <?php echo $company_meta['your_name']; ?> from <?php echo $company_info->company_name; ?>.
				</p>
		        <p>The purpose of my call is to set up a 15 to 20 minute call with you to discuss how we might be able to help you to
				<?php echo $campaign_tech_summary->value ?>.
				</p>
		        <p>
					Please let me know if next Tuesday or Thursday at 10AM or 2PM would work for you. You can reach me at <?php echo $company_meta['your_phone']; ?>.
				</p
				><p>Again, this is <?php echo $company_meta['your_name']; ?> calling from <?php echo $company_info->company_name; ?>, <?php echo $company_meta['your_phone']; ?>.</p>
				<p>Thank you and I look forward to talking with you soon.</p>
			</td>
		</tr>
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 