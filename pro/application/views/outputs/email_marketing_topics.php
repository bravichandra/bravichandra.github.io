<?php $this->load->view('common/meta_outputs');?>
<title>EMAIL MARKETING TOPICS</title>
</head>
<body>
<div id="content">
	<?php if($action != 'download'){?>
		<?php 	$this->load->view('common/logo');?>
	<?php } ?>
	<h1 align="center">EMAIL MARKETING TOPICS</h1>
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
	<br />
	<p style="font-size:14px">The following are topics that you can use when developing blog posts, articles, and emails. You can use this as a tool to develop your own content marketing topics and feel free to mix up the titles and points brought over to form combinations that might fit your situation better.</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
			<tr>
				<td><strong>TOPICS FOCUSED ON PAIN</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li> 4 ways to decrease <?php echo $techpain->value ?></li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>4 ways to decrease <?php echo $bizpain->value ?></li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>4 ways to decrease  <?php echo $personalpain->value ?></li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li> Nip <?php echo $techpain->value ?> in the bud </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>Nip <?php echo $bizpain->value ?> in the bud </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>Nip <?php echo $personalpain->value ?> in the bud </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li> is <?php echo $techpain->value ?> becoming your nemesis? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>is <?php echo $bizpain->value ?> becoming your nemesis? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>is <?php echo $personalpain->value ?> becoming your nemesis? </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li>3 impacts from having <?php echo $techpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>3 impacts from having <?php echo $bizpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>3 impacts from having <?php echo $personalpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li> is <?php echo $techpain->value ?> keeping you up at night? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>is <?php echo $bizpain->value ?> keeping you up at night? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>is <?php echo $personalpain->value ?> keeping you up at night? </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li>What to do when you have <?php echo $techpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>What to do when you have <?php echo $bizpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>What to do when you have <?php echo $personalpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li>How to deal with <?php echo $techpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>How to deal with <?php echo $bizpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>How to deal with <?php echo $personalpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li>Are you troubled by  <?php echo $techpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>Are you troubled by  <?php echo $bizpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>Are you troubled by   <?php echo $personalpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_pain)):?>
							<?php foreach ($campaign_output_tech_pain as $techpain):?>
									<li>Some options when facing  <?php echo $techpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_pain)):?>
							<?php foreach ($campaign_output_biz_pain as $bizpain):?>
									<li>Some options when facing  <?php echo $bizpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_pain)):?>
							<?php foreach ($campaign_output_per_pain as $personalpain):?>
									<li>Some options when facing   <?php echo $personalpain->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
				</td>
			</tr>
			<tr>
				<td><strong>TOPICS FOCUSED ON VALUE</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
					<?php /*?><ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li>How  <?php echo $techval->value ?> can improve your business </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>How   <?php echo $bizval->value ?> can improve your business</li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>How  <?php echo $personalval->value ?>  can improve your business</li>
							<?php endforeach;?>
						<?php endif?>
						
					</ul>
					<br /><?php */?>
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li>How to get   <?php echo $techval->value ?>  to happen for you </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>How to get  <?php echo $bizval->value ?>  to happen for you</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>How to get   <?php echo $personalval->value ?>   to happen for you</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li>   <?php echo $techval->value ?> is in your grasp </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li> <?php echo $bizval->value ?>  is in your grasp</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li><?php echo $personalval->value ?>   is in your grasp</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li> Does  <?php echo $techval->value ?> interest you? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>Does  <?php echo $bizval->value ?>  interest you?</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>Does <?php echo $personalval->value ?>   interest you? </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li> Does  <?php echo $techval->value ?> interest you? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>Does  <?php echo $bizval->value ?>  interest you?</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>Does <?php echo $personalval->value ?>   interest you? </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li> 3 ways to get <?php echo $techval->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>3 ways to get  <?php echo $bizval->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>3 ways to get <?php echo $personalval->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li> What having <?php echo $techval->value ?>  can mean for you</li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>What having <?php echo $bizval->value ?>  can mean for you</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>What having <?php echo $personalval->value ?>  can mean for you</li>
							<?php endforeach;?>
						<?php endif?><?php */?>
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li> What if you could  <?php echo $techval->value ?>  </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>What if you could  <?php echo $bizval->value ?>  </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>What if you could  <?php echo $personalval->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li>3 benefits from <?php echo $techval->value ?>  </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>3 benefits from  <?php echo $bizval->value ?>  </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>3 benefits from  <?php echo $personalval->value ?> </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_tech_val)):?>
							<?php foreach ($campaign_output_tech_val as $techval):?>
									<li>Does  <?php echo $techval->value ?> feel impossible to achieve? </li>
							<?php endforeach;?>
						<?php endif?>
						
						<?php /*?><?php if (isset($campaign_output_biz_val)):?>
							<?php foreach ($campaign_output_biz_val as $bizval):?>
									<li>Does  <?php echo $bizval->value ?> feel impossible to achieve? </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
						
						<?php /*?><?php if (isset($campaign_output_per_val)):?>
							<?php foreach ($campaign_output_per_val as $personalval):?>
									<li>Does   <?php echo $personalval->value ?> feel impossible to achieve? </li>
							<?php endforeach;?>
						<?php endif?><?php */?>
					</ul>
					<br />
				</td>
			</tr>
			<tr>
				<td><strong>TOPICS FOCUSED ON QUALIFYING</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
					<ul>
						<?php if (isset($campaign_output_tech_qualify)):?>
							<?php foreach ($campaign_output_tech_qualify as $techqualify):?>
									<li> <?php echo $techqualify->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_biz_qualify)):?>
							<?php foreach ($campaign_output_biz_qualify as $bizqualify):?>
									<li><?php echo $bizqualify->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
					</ul>
					<br />
					<ul>
						<?php if (isset($campaign_output_per_qualify)):?>
							<?php foreach ($campaign_output_per_qualify as $perqualify):?>
									<li><?php echo $perqualify->value ?> </li>
							<?php endforeach;?>
						<?php endif?>
					</ul>
					<br />
				</td>
			</tr>
			<tr>
				<td><strong>TOPICS FOCUSED AROUND YOUR PRODUCTS AND COMPANY</strong></td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
			<tr>
				<td>
					<ul>
						<li>What it takes to implement <?php echo $P_Q1->value; ?>  </li>
						<li>Implementing  <?php echo $P_Q1->value; ?> in 3 Easy Steps  </li>
					</ul>
					<ul>
						<li>Why chose a provider that  <?php echo $company_meta['interest'][0]; ?></li>
						<li>Why chose a provider that  <?php echo $company_meta['interest'][1]; ?></li>
						<li>Why chose a provider that  <?php echo $company_meta['interest'][2]; ?></li>
					</ul>	
					<ul>	 
						<li>Why   <?php echo $company_meta['interest'][0]; ?> is important</li>
						<li>Why  <?php echo $company_meta['interest'][1]; ?> is important</li>
						<li>Why  <?php echo $company_meta['interest'][2]; ?> is important</li>	
		            </ul>
					<ul>	 
						<li><?php echo $company_meta['interest'][0]; ?> is the difference that matters</li>
						<li><?php echo $company_meta['interest'][1]; ?> is the difference that matters</li>
						<li><?php echo $company_meta['interest'][2]; ?> is the difference that matters</li>	
		            </ul>
					<br />
					
					<ul>	 
						<li>How we are able to <?php echo $diff1->value; ?> </li>
						<li>How we are able to <?php echo $diff2->value; ?> </li>
						<li>How we are able to <?php echo $diff3->value; ?> </li>	
		            </ul>
					<ul>	 
						<li>Why  <?php echo $diff1->value; ?> should be important to you</li>
						<li>Why  <?php echo $diff2->value; ?> should be important to you</li>
						<li>Why  <?php echo $diff3->value; ?> should be important to you</li>	
		            </ul>
					
					<ul>	 
						<li><?php echo $company_info->company_name ?> helps <?php echo $active_name_drop_exp['provided']->credibility_name ; ?> to <?php echo $active_name_drop_exp['provided']->value ?> </li>
						<li><?php echo $company_info->company_name ?> helps <?php echo $active_name_drop_exp['provided']->credibility_name ; ?> to <?php  echo $active_name_drop_exp['when']->value ?> </li>
						<li>How <?php echo $company_info->company_name ?> helps <?php echo $active_name_drop_exp['provided']->credibility_name ; ?> to <?php echo  $active_name_drop_exp['provided']->value ?> </li>
						<li>How <?php echo $company_info->company_name ?> helps <?php echo $active_name_drop_exp['provided']->credibility_name ; ?> to <?php echo  $active_name_drop_exp['when']->value ?> </li>	
		            </ul>
					<br />
				</td>
			</tr>
			<tr><td><hr class="hrline" /></td></tr>
	</table>
</div>
<?php echo $this->load->view('common/footer_outputs');?>