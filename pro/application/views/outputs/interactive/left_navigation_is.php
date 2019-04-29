<?php
	if($partid && $action!='download2')
	{
?>
		<div class="is_loader" style="width:100%; height:100%;position:fixed;left:0;top:0;background:#666666;">
		<label class="loading_Text" style="position: absolute;top: 50%;left: 48%;font-size: 15px;font-weight: bold;color:#fff;">Loading...</label>
		</div>
		<div class="left_navigation_is">
			<p class="header_left_navigation_is">Interactive Script</p>
			<?php /*?><h1 class="sub-dev-head">Navigation</h1><?php */?>
			<div class="content_navigation_is">
				<?php
					$current_section_left = end(explode('/',current_url()));
					$template_url_left = str_replace("/".$current_section_left, '/', current_url());//By Dev@4489 for IS Last ID
					foreach($parts as $key => $titlepart)
					{
						if($titlepart['title']=='Pre-Qualifying Questions') {
						 //echo $tabtitles[0]->title;
						 if($tabtitles[0]->title!='') $title=$tabtitles[0]->title.' Questions'; else $title='Pre-Qualifying Questions';
						 }
						 else if($titlepart['title']=='Need vs Want') {
							 if($tabtitles[0]->title!='') $title=$tabtitles[1]->title.' Questions'; else $title='Need vs Want';
						 }
						 else if($titlepart['title']=='Ability to Purchase') {
							 if($tabtitles[0]->title!='') $title=$tabtitles[2]->title.' Questions'; else $title='Ability to Purchase';
						 }
						 else if($titlepart['title']=='Decision Authority') {
							 if($tabtitles[0]->title!='') $title=$tabtitles[3]->title.' Questions'; else $title='Decision Authority';
						 }
						  else if($titlepart['title']=='Competition Level') {
							 if($tabtitles[0]->title!='') $title=$tabtitles[4]->title.' Questions'; else $title='Competition Level';
						 }
						 else $title=$titlepart['title'];
						 
						if($lastid >= $key)
						{
							//$selected_left = $key == $partid?' selected_left':'';
							$selected_left = $titlepart['name'] == $action?' selected_left':'';
						?>
							<div class="navigation_link<?php echo $selected_left; ?>">
								<a href="<?php echo $template_url_left.$titlepart['name'];?>"><?php echo $title; ?></a>
							</div>
						<?php
						}
						else break;
					}
				?>
			</div>
			<div class="sub-nav-sf">
				<a style="float:right;margin-right: 124px;" class="buttonL bGreen" href="#" onClick="return downloadData('<?php echo $current_section_left;?>')">Get Notes</a>
				<?php if(isset($nts) && $nts) {
					$tempname = explode('output/',current_url());
					$tempname = explode('/',$tempname[1]);
					$tempname = $tempname[0];
				?>
				<a id="salesnotes" style="float:right;margin-right: 124px;  margin-top: 10px;" class="buttonL bGreen" href="javascript:void(0);" onClick="sfsaveStepData('<?php echo $current_section_left;?>',event,this);">Notes to Salesforce</a>
				<?php }?>
				<?php /*?><a style="float:left;margin-left: 53px;margin-top: 10px;" class="buttonL bBlue" href="<?php echo $template_url_left;?>">View Full Script</a><?php */?>
                <a style="float:left;margin-left: 53px;margin-top: 10px;" class="buttonL bBlue" onClick="return CreateLogCall('<?php echo $current_section_left;?>')" href="<?php echo $template_url_left;?>">Log Call</a>
			</div>
		</div>
<?php
	}
?>