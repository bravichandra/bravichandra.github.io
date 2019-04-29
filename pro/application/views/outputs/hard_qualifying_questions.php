<?php $this->load->view('common/meta_outputs');?>
<title><?php if(isset($uCustTemplate['template_title'])) echo $uCustTemplate['template_title'];?></title>
<style type="text/css">
		.list-items ul li
		{
			display:list-item !Important;
		}
		.hrline
		{
				background: #000000;
				height: 1px;
				border: none;
		}
</style>
</head>
<body>
	<div id="content">		<?php if($action != 'download'){?>			<?php 	$this->load->view('common/logo');?>		<?php } ?>
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
        <?php if($action != 'download' && $action!='download2') {
			include_once('interactive/go-through-button.php');
		}?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="output">
            <?php 
                if(!empty($template_content)) {
                    foreach($template_content as $tpldata) {
            ?>
            <tr>
                <td><?php echo $tpldata->sect_content;?></td>
            </tr>
            <?php /*?><tr><td class="border-bottom">&nbsp;</td></tr><?php */?>
            <?php			
                    }
                } else if(!empty($template_sections)) {
                    foreach($template_sections as $tsection) {	if($tsection->sect_title=='Hard Qualifying Questions'){
		?>    
        <tr><td colspan="3"><hr class="hrline" /></td></tr> 
        <tr>
			<td class="td-pad-b"> <strong><?php if($tabtitles[0]->title!='') echo $tabtitles[0]->title; else echo 'Pre-Qualifying';  ?> Questions</strong></td>
			<td>&nbsp;</td>
			<td class="list-items">
            	 <?php if (isset($campaign_output_qualify)) echo $campaign_output_qualify;?><br/>
			</td>
		</tr>
        <tr><td colspan="3"><hr class="hrline" /></td></tr>   
        <tr>
			<td class="td-pad-b"> <strong><?php if($tabtitles[1]->title!='') echo $tabtitles[1]->title; else echo 'Need vs. Want';  ?> Questions</strong></td>
			<td>&nbsp;</td>
			<td class="list-items">
            	 <?php  
					if (isset($need_want_qus)) echo $need_want_qus."<br/>"; 
					else { 
					if(isset($Need_Want)){
				?>
				<ul>
					<?php
						foreach($Need_Want as $qns){
					?>
					<li><?php echo $qns; ?></li>
					<?php } ?>
				</ul><br/>
				<?php }} ?>  
			</td>
		</tr>
        <tr><td colspan="3"><hr class="hrline" /></td></tr>
        
        <tr>
			<td class="td-pad-b"> <strong><?php if($tabtitles[2]->title!='') echo $tabtitles[2]->title; else echo 'Availability of Funding';  ?> Questions</strong></td>
			<td>&nbsp;</td>
			<td class="list-items">
            	<?php  
					if (isset($funding_availability)) echo $funding_availability."<br/>"; 
					else { 
					if(isset($Funding_Availability)){
				?>
				<ul>
					<?php
						foreach($Funding_Availability as $qns){
					?>
					<li><?php echo $qns; ?></li>
					<?php } ?>
				</ul><br/>
				<?php }} ?>  
			</td>
		</tr>
        <tr><td colspan="3"><hr class="hrline" /></td></tr>
        
        <tr>
			<td class="td-pad-b"> <strong><?php if($tabtitles[3]->title!='') echo $tabtitles[3]->title; else echo 'Decision Making Authority';  ?> Questions</strong></td>
			<td>&nbsp;</td>
			<td class="list-items">
            	  <?php  
					if (isset($decision_authority)) echo $decision_authority."<br/>"; 
					else { 
					if(isset($Decision_Authority)){
				?>
				<ul>
					<?php
						foreach($Decision_Authority as $qns){
					?>
					<li><?php echo $qns; ?></li>
					<?php } ?>
				</ul><br/>
				<?php }} ?>
			</td>
		</tr>
        <tr><td colspan="3"><hr class="hrline" /></td></tr>
        
        <tr>
			<td class="td-pad-b"> <strong><?php if($tabtitles[4]->title!='') echo $tabtitles[4]->title; else echo 'Level of Competition';  ?> Questions</strong></td>
			<td>&nbsp;</td>
			<td class="list-items">
            	<?php  
					if (isset($intent_purchase)) echo $intent_purchase."<br/>"; 
					else { 
					if(isset($Competition_Level)){
				?>
				<ul>
					<?php
						foreach($Competition_Level as $qns){
					?>
					<li><?php echo $qns; ?></li>
					<?php } ?>
				</ul><br/>
				<?php }} ?>  	
			</td>
		</tr>
        <tr><td colspan="3"><hr class="hrline" /></td></tr>
        <?php 
					}else {
            ?>
            <tr>
                <td>
                    <?php 
                        $content_id=$tsection->content_id;
                        include('custom_content/custom_etemplate_data.php');
                    ?>
                </td>
            </tr>
            <?php }}}		
            ?>
        </table>
</div>
<?php echo $this->load->view('common/footer_outputs');?>