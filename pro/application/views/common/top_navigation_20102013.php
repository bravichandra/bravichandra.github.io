<div class="breadLine">
     <div class="bc">
           <ul id="breadcrumbs" class="breadcrumbs">
             <!-- <li>
                	<a href="<?php echo base_url();?>" <?php echo(($page == 'register' and $page != '0') ? 'class="selected"' : 'style="color:#030303; font-size:12px; font-weight:bold;"');?>>Home</a>
              </li> -->
             <li <?php echo((!empty($progress_data->product) AND $progress_data->product == FALSE) ? 'class="current"' : NULL );?>>
                	<a href="<?php echo base_url();?>step/product" <?php echo(($page == '0') ? 'class="selected"' : Null);?><?php if(isset($progress_data->product) AND $next_page = 0){?> <?php } echo((isset($progress_data->product) AND $progress_data->product == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Product</a>
              </li>
              <li <?php echo((!empty($progress_data->value) AND $progress_data->value == FALSE) ? 'class="current"' : NULL );?>>
                	<a href="<?php echo base_url();?>step/value" <?php echo(($page == 1) ? 'class="selected"' : Null);?><?php if(isset($progress_data->value)  AND $next_page = 1){?> <?php } echo((isset($progress_data->value) AND $progress_data->value == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Value</a>
              </li>
              <li <?php echo((!empty($progress_data->pain) AND $progress_data->pain == FALSE) ? 'class="current"' : NULL );?>>
              		<a href="<?php echo base_url();?>step/pain" <?php echo(($page == 2) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->pain) AND $next_page = 2){?> <?php } echo((isset($progress_data->pain) AND $progress_data->pain == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Pain</a>
              </li>
              <li <?php echo((!empty($progress_data->qualify) AND $progress_data->qualify == FALSE) ? 'class="current"' : NULL );?>>
              		<a href="<?php echo base_url();?>step/qualifying" <?php echo(($page == 3) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->qualify) AND $next_page = 3){?> <?php } echo((isset($progress_data->qualify) AND $progress_data->qualify == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Qualify</a>
              </li>
              <li <?php echo((!empty($progress_data->target) AND $progress_data->target == FALSE) ? 'class="current"' : NULL );?>>
             		 <a href="<?php echo base_url();?>step/ideal-prospect" <?php echo(($page == 4) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->target) AND $next_page = 4){?> <?php } echo((isset($progress_data->target) AND $progress_data->target == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Target</a>
              </li>
              <li <?php echo((!empty($progress_data->credibility) AND $progress_data->credibility == FALSE) ? 'class="current"' : NULL );?>>
              		<a href="<?php echo base_url();?>step/credibility" <?php echo(($page == 5) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->credibility) AND $next_page = 6){?> <?php } echo((isset($progress_data->credibility) AND $progress_data->credibility == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Credibility</a>
              </li>
              <li <?php echo((!empty($progress_data->interest) AND $progress_data->interest == FALSE) ? 'class="current"' : NULL );?>>
              		<a href="<?php echo base_url();?>step/interest" <?php echo(($page == 6) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->interest)){?> <?php } echo((isset($progress_data->interest) AND $progress_data->interest == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Company</a>
              </li>
              <li <?php echo((!empty($progress_data->objection) AND $progress_data->objection == FALSE) ? 'class="current"' : NULL );?>>
                  <a href="<?php echo base_url();?>step/objections" <?php echo(($page == 8) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->objection)){?> <?php } echo((isset($progress_data->objection) AND $progress_data->objection == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;"' );?>>Objections</a>
              </li>
              <li <?php echo((!empty($progress_data->sales_process) AND $progress_data->sales_process == FALSE) ? 'class="current"' : NULL );?>>
              		<a  href="<?php echo base_url();?>step/ideal-sales-process" <?php echo(($page == 7) ? 'class="selected"' : Null);?> <?php if(isset($progress_data->sales_process)){?> <?php } echo((isset($progress_data->sales_process) AND $progress_data->sales_process == TRUE) ? 'style="color:#030303;font-weight:bold;font-size: 12px;background:none !important;"' : 'style="color:#030303;font-weight:bold;font-size: 12px;background:none !important;"' );?>>Ideal Sales Process</a>
              </li>
            </ul>
     </div>
</div>