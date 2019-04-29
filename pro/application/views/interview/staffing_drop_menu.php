<span class="his-dropmenu">
   		<?php
			$attributes = array('id' => 'changeform', 'method' => 'post','style'=>'margin:0px;float:left;');
			echo form_open('campaign/changeactiveelement', $attributes);
		?>
		<ul id="breadcrumbs" class="breadcrumbs" style="list-style-type:none;">
			<li style="display:inline-block;"><span style="color:#030303;font-weight:bold;font-size: 12px; padding: 0 10px;"> Job Posting </span></li>
			<li style="display:inline-block;">
				<select name="activejob" onchange="this.form.submit()">
                	<option value="">Select</option>
					<?php foreach($drop_jobpost  as $drop) { ?>
					<option value="<?php echo $drop->post_id ?>" <?php if($drop->status == 1) echo "selected";?>><?php echo $drop->job_title ?> </option>
					<?php } ?>
				</select>
			</li>
			<li style="display:inline-block;"><span style="color:#030303;font-weight:bold;font-size: 12px;  padding: 0 10px;"> Company </span></li>
			<li style="display:inline-block;">
				<?php if(count($drop_company) > 0 ) { ?>
					<select name="activecompanyname" onchange="this.form.submit()" style="width: 150px;">
                    		<option value="">Select</option>
                            <?php $dpselc = 0;
								if(isset($market_doc) && $market_doc) {
									echo '<option value="all"'.(isset($dpall_company)?' selected':'').'>All</option>';
									if(isset($dpall_company)) $dpselc = 1;
								}	
							?>
						<?php foreach($drop_company  as $singlecompany) { ?>
							<option value="<?php echo $singlecompany->company_id; ?>" <?php if($singlecompany->status == 1 && !$dpselc){ echo "selected";} ?>   ><?php echo $singlecompany->company_name; ?> </option>
						<?php } ?>
					</select>
				<?php } ?>
			</li>
			</ul>
		</form>
   </span>