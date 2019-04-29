<div class="breadLine">
   <?php
	// echo $campaign_info->campaign_id ;
	$progress_data = json_decode($this->home->get_progress_data($campaign_info->campaign_id));
	// var_dump($progress_data);
   ?> 
   <div class="bc">
      <ul id="breadcrumbs" class="breadcrumbs">
                                  
           <li <?php echo((!empty($progress_data->product) AND $progress_data->product == FALSE) ? 'class="current"' : NULL );?>>
			<a href="<?php echo base_url();?>campaign/startcampaigncreate" <?php echo(($page == '0') ? 'class="selected"' : Null);?>
				<?php if(isset($progress_data->product) AND $next_page = 0){?> 
						<?php }  echo((isset($progress_data->product) AND $progress_data->product == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Sales Pitch Coordinates</a>
			</li>
			<?php  foreach($progress_data as $key => $value){				
						if($key=='workflow' && $value > 0){ ?>             
								<li <?php echo((!empty($progress_data->value) AND $progress_data->value == FALSE) ? 'class="current"' : NULL );?>> 
									<a href="<?php echo base_url();?>step/value" <?php echo(($page == 1) ? 'class="selected"' : Null);?><?php if(isset($progress_data->value)  AND $next_page = 1){?> <?php } echo((isset($progress_data->value) AND $progress_data->value == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Value</a> 
								</li>
						<?php }
						
						
						
						/** This section is commented to hide these in PRO version - Developer-A
						if($key=='value' && $value > 0){ ?>              
								<li <?php echo((!empty($progress_data->value) AND $progress_data->value == FALSE) ? 'class="current"' : NULL );?>>
									<a href="<?php echo base_url();?>step/value2" <?php echo(($page == 10) ? 'class="selected"' : Null);?><?php if(isset($progress_data->value)  AND $next_page = 1){?> <?php } echo((isset($progress_data->value) AND $progress_data->value == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Value Biz</a>
								</li>
						<?php }
						if($key=='value2' && $value > 0){ ?>              
								<li <?php echo((!empty($progress_data->value) AND $progress_data->value == FALSE) ? 'class="current"' : NULL );?>>
									<a href="<?php echo base_url();?>step/value3" <?php echo(($page == 11) ? 'class="selected"' : Null);?><?php if(isset($progress_data->value)  AND $next_page = 1){?> <?php } echo((isset($progress_data->value) AND $progress_data->value == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Value Personal</a>
								</li>
						<?php }**/
						
						
						
						
						if($key=='value' && $value > 0){ ?>              
								<li <?php echo((!empty($progress_data->pain) AND $progress_data->pain == FALSE) ? 'class="current"' : NULL );?>>
									<a href="<?php echo base_url();?>step/pain" <?php echo(($page == 2) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->pain) AND $next_page = 2){?> <?php } echo((isset($progress_data->pain) AND $progress_data->pain == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Pain</a> 
								</li>
						<?php }
						
						/**
						if($key=='pain' && $value > 0){ ?>              
								<li <?php echo((!empty($progress_data->ideal_prospect_environment) AND $progress_data->ideal_prospect_environment == FALSE) ? 'class="current"' : NULL );?>> 
									<a href="<?php echo base_url();?>step/ideal-prospect-environment" <?php echo(($page == 9) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->ideal_prospect_environment) AND $next_page = 9){?> <?php } echo((isset($progress_data->ideal_prospect_environment) AND $progress_data->ideal_prospect_environment == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Ideal Prospect</a>
								</li>
						<?php } 
						 */
						
						if($key=='pain' && $value > 0) { ?>              
								<li <?php echo((!empty($progress_data->qualify) AND $progress_data->qualify == FALSE) ? 'class="current"' : NULL );?>> 
									<a href="<?php echo base_url();?>step/qualifying" <?php echo(($page == 3) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->qualify) AND $next_page = 3){?> <?php } echo((isset($progress_data->qualify) AND $progress_data->qualify == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Qualify</a> 
								</li>
						<?php /*} 
						if($key=='sales_process' && $value > 0) { ?>
							<li <?php echo((!empty($progress_data->credibility) AND $progress_data->credibility == FALSE) ? 'class="current"' : NULL );?>> 
								<a href="<?php echo base_url();?>step/credibility" <?php echo(($page == 5) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->credibility) AND $next_page = 6){?> <?php } echo((isset($progress_data->credibility) AND $progress_data->credibility == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Credibility</a> 
							</li>
						<?php */}
						
						if($key=='credibility' && $value > 0) { ?>              
							<li <?php echo((!empty($progress_data->interest) AND $progress_data->interest == FALSE) ? 'class="current"' : NULL );?>> 
								<a href="<?php echo base_url();?>step/interest" <?php echo(($page == 6) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->interest)){?> <?php } echo((isset($progress_data->interest) AND $progress_data->interest == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Company</a>
							</li>
						<?php } 
						if($key=='interest' && $value > 0){ ?>              
								<!-- <li <?php echo((!empty($progress_data->objection) AND $progress_data->objection == FALSE) ? 'class="current"' : NULL );?>>                  		 <a href="<?php echo base_url();?>step/objections" <?php echo(($page == 8) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->objection)){?> <?php } echo((isset($progress_data->objection) AND $progress_data->objection == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Objections</a>              		 </li> -->
						<?php } 
						if($key=='qualify' && $value > 0) { ?> 		 
							<li <?php echo((!empty($progress_data->sales_process) AND $progress_data->sales_process == FALSE) ? 'class="current"' : NULL );?>> 
								<a  id="sales_process" href="<?php echo base_url();?>step/ideal-sales-process" <?php echo(($page == 7) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->sales_process)){?> <?php } echo((isset($progress_data->sales_process) AND $progress_data->sales_process == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Close</a> 
							</li>
                            <style>
							#sales_process
							{
								background: none !important;
							}
							</style>
						<?php }
							/*if($key=='custom_content' && $value > 0) { ?>
							<li <?php echo((!empty($progress_data->custom_content) AND $progress_data->custom_content == FALSE) ? 'class="current"' : NULL );?>> 
								<a id="custom_content_id" href="<?php echo base_url();?>step/custom_content" <?php echo(($page == 99) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->custom_content)){?> <?php } echo((isset($progress_data->custom_content) AND $progress_data->custom_content == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;background: none !important;"' );?>>Custom Content</a> 
							</li>
							<style>
							#custom_content_id
							{
								background: none !important;
							}
							</style>
						
					<?php }*/ } ?>          
      </ul>
   </div>
</div>