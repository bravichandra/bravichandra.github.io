<div style="background: none;height: auto;">
   <?php
     // var_dump($drop_campaign);
	 // die();
   ?>
   <div class="bc" style="margin-bottom: 10px;">
	  <form id="changeform" action="<?php echo base_url()?>campaign/changeactiveelement" method="post" >
		<ul id="breadcrumbs" class="breadcrumbs">
			<li><span style="color:#030303;font-weight:bold;font-size: 12px; padding: 0 10px;"> Sales Pitch </span></li>
			<li>
			  <?php if(count($drop_campaign) > 0 ) { ?>
				<select name="activecompaignname" onchange="submitForm()">
					<option value="">Select</option>
					<?php foreach($drop_campaign  as $singlecampaign) { ?>
						<option value="<?php echo $singlecampaign->campaign_id ?>"  <?php if($singlecampaign->status == 1){ echo "selected";} ?> ><?php echo $singlecampaign->campaign_name ?> </option>
					<?php } ?>
				</select>
			  <?php } ?>
			</li>
			<li> <span style="color:#030303;font-weight:bold;font-size: 12px;  padding: 0 10px;">Name Drop </span></li>
			<li>
				<?php if(count($drop_name) > 0 ) { ?>
					<select name="activedropname" onchange="submitForm()">
							<option value="">Select</option>
							<?php foreach($drop_name  as $singledropname) { ?>
							<option value="<?php echo $singledropname->c_id ?>"  <?php if($singledropname->status == 1){ echo "selected";} ?>  ><?php //echo $singledropname->credibility_name ?><?php echo ($singledropname->value?$singledropname->value:$singledropname->credibility_name); ?> </option>
							<?php } ?>
					</select>
				<?php } ?>	
					
			</li>
			<li><span style="color:#030303;font-weight:bold;font-size: 12px;  padding: 0 10px;"> Company </span></li>
			<li>
				<?php if(count($drop_company) > 0 ) { ?>
					<select name="activecompanyname" onchange="submitForm()">
						<option value="">Select</option>
						<?php foreach($drop_company  as $singlecompany) { ?>
							<option value="<?php echo $singlecompany->company_id; ?>" <?php if($singlecompany->status == 1){ echo "selected";} ?>   ><?php echo $singlecompany->company_name; ?> </option>
						<?php } ?>
					</select>
				<?php } ?>
			</li>
			</ul>
		</form>
   </div>
</div><br clear="all" />
<script type="text/javascript">
  function submitForm()
  {
	$("#changeform").submit();
  }
</script>