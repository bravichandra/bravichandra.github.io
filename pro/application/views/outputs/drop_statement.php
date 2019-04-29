<?php $this->load->view('common/meta_outputs');?>
<title>NAME DROP STATEMENTS</title>
</head>
<body>
	<div id="content">
		<?php if($action != 'download'){?>			<?php 	$this->load->view('common/logo');?>		<?php } ?>		<h1 align="center">NAME DROP STATEMENTS</h1>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
				<tr>
						
					</tr>
					<tr><td><hr class="hrline" /></td></tr>
					<tr>
						<td>
							<p>We worked with  <?php echo $active_name_drop_exp['provided']->credibility_name; ?> and provided <span class=""> <?php echo $active_name_drop_exp['worked']->value; ?> </span>.</p>
							<p>This helped them to <?php echo $active_name_drop_exp['provided']->value; ?> which lead to  <?php echo $active_name_drop_exp['when']->value; ?> .</p>
							<br>
						</td>
				</tr>
					
		</table>
	</div>
<?php echo $this->load->view('common/footer_outputs');?>