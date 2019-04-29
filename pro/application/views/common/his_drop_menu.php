   <span class="his-dropmenu">
   		<?php
			$attributes = array('id' => 'changeform', 'method' => 'post','style'=>'margin:0px;float:left;');
			echo form_open('campaign/changeactiveelement', $attributes);
		?>
		<ul id="breadcrumbs" class="breadcrumbs" style="list-style-type:none; margin:0px;">
			<li style="display:inline-block;"><span style="color:#030303;font-weight:bold;font-size: 12px; padding: 0 10px;"> Sales Pitch </span></li>
			<li style="display:inline-block;">
			  <?php if(count($drop_campaign) > 0 ) { ?>
				<select name="activecompaignname" onchange="this.form.submit()" style="width: 150px;">
                	<option value="">Select</option>
					<?php foreach($drop_campaign  as $singlecampaign) { ?>
						<option value="<?php echo $singlecampaign->campaign_id ?>"  <?php if($singlecampaign->status == 1){ echo "selected";} ?> ><?php echo $singlecampaign->campaign_name ?> </option>
					<?php } ?>
				</select>
			  <?php } ?>
			</li>
			<li style="display:inline-block;"> <span style="color:#030303;font-weight:bold;font-size: 12px;  padding: 0 10px;">Name Drop </span></li>
			<li style="display:inline-block;">
				<?php if(count($drop_name) > 0 ) { ?>
					<select name="activedropname" onchange="this.form.submit()" style="width: 150px;">
                    		<option value="">Select</option>
							<?php foreach($drop_name  as $singledropname) { ?>
							<option value="<?php echo $singledropname->c_id ?>"  <?php if($singledropname->status == 1){ echo "selected";} ?>  ><?php //echo $singledropname->credibility_name ?><?php echo ($singledropname->value?$singledropname->value:$singledropname->credibility_name); ?></option>
							<?php } ?>
					</select>
				<?php } ?>	
					
			</li>
			<li style="display:inline-block;"><span style="color:#030303;font-weight:bold;font-size: 12px;  padding: 0 10px;"> Company </span></li>
			<li style="display:inline-block;">
				<?php if(count($drop_company) > 0 ) { ?>
					<select name="activecompanyname" onchange="this.form.submit()" style="width: 150px;">
                    		<option value="">Select</option>
						<?php foreach($drop_company  as $singlecompany) { ?>
							<option value="<?php echo $singlecompany->company_id; ?>" <?php if($singlecompany->status == 1){ echo "selected";} ?>   ><?php echo $singlecompany->company_name; ?> </option>
						<?php } ?>
					</select>
				<?php } ?>
			</li>
			</ul>
		</form>
   </span>