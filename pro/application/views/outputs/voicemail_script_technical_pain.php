<?php $this->load->view('common/meta_outputs');?>
<title>Voicemail Script - Pain </title>
</head>
<body>
<div id="content">
	<?php if($action != 'download'){?>
		<?php echo $this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">Voicemail Script &#45; Pain Focus</h1>
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
		<tr><td class="border-bottom">&nbsp;</td></tr>
		<tr style="border-bottom:1px solid #000;">
			<td><br/>
			<p>Hello <span class="red-area">[Prospect First Name]</span>
				
				   this is <?php echo $company_meta['your_name']; ?> from <?php echo $company_info->company_name; ?>.
				
				</p>
		        <p>Purpose for my call is that we find that many  
					<?php 
						if($campaign_info->campaign_target == '1'){	
								 echo $campaign_info->individual;
							}else{ 
								echo $campaign_info->organization;
						}
					?> have challenges with:
					</p>
					<p>
					<span class="red-area">(Share up to three of below pain points)</span>
					</p>
					<p>
					<?php 
						if(isset($campaign_output_tech_pain)){
							echo '<ul>';
							foreach($campaign_output_tech_pain as $singlepain){
							
								echo '<li>'. $singlepain->value .'</li>';
							}
							echo '</ul>';
						}
					?>
				</p>
		        <p><span class="red-area">(Optional disqualify statement) </span>I actually do not know if you are a fit for what we do and that is why I was calling you with a question or two.</p>
				<p>
					I will try you again next week. If you would like to reach me in the meantime, my number is <?php echo $company_meta['your_phone']; ?>.
				</p>
				<p>Again, this is <?php echo $company_meta['your_name']; ?> calling from <?php echo $company_info->company_name; ?>, <?php echo $company_meta['your_phone']; ?>.</p>
				<p>Thank you and I look forward to talking with you soon.</p>
			<br></td>
		</tr>
		<tr><td class="border-bottom">&nbsp;</td></tr>
	</table>
</div>	
<?php echo $this->load->view('common/footer_outputs');?> 