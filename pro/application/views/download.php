<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/
  table th{ padding: 10px 0;}
</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>	    
	<!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>
<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
 <!-- Breadcrumbs line -->   

	<?php  
		if($d_page == 6 || $d_page == 8 || $d_page == 9 || $d_page == 13 || $d_page == 14) $this->load->view('common/empty_nav');
        if($d_page==6 || $d_page==9 || $d_page==8 || $d_page==14){?> 
        <div class="main-wrapper" style="text-align: right;margin: 0px 40px;float: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
        <?php }
		if($d_page == 15 || $d_page == 16 || $d_page == 41 || $d_page == 42 || $d_page == 43 || $d_page == 44 || $d_page == 45 || $d_page == 55){
			$this->load->view('common/empty_nav');
		}else{
			$this->load->view('common/drop_menu');
		}
	?> 
	
    <?php if ($d_page == 1) { ?>				
        <div class="main-wrapper">
            <!-- Main content -->    			
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/elevator-pitch"  title="Download" target="_blank"> Value Statements</a></h1>
                            <p>This is a list of statements that could be used as an elevator pitch to describe what you do. These statements are composed of different combinations of your value, pain, building interest, and building credibility points. Some of these may work well. Some might not. There are plenty to chose from.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">								<span class="note span-html">The HTML version allows you to edit your answers.</span>						            <li><a href="<?php echo base_url(); ?>output/elevator-pitch/download"  title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>						            <li><a href="<?php echo base_url(); ?>output/elevator-pitch" target="_blank" title="HTML" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>						        </ul> -->					        
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->    			
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/building-interest" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download"> Building Interest Points</a></h1>
                            <p>This is a list of statements that could be used to trigger interest when talking with prospects.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">								<span class="note span-html">The HTML version allows you to edit your answers.</span>						            <li><a href="<?php echo base_url(); ?>output/building-interest/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>						            <li><a href="<?php echo base_url(); ?>output/building-interest" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>						        </ul> -->					        
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->    			
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/name-drop-statments" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" > Name Drop Statement</a></h1>
                            <p>This is a document that summarizes your name drop statements.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">								<span class="note span-html">The HTML version allows you to edit your answers.</span>						            <li><a href="<?php echo base_url(); ?>output/name-drop-statments/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>						            <li><a href="<?php echo base_url(); ?>output/name-drop-statments" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>						        </ul> -->					        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($d_page == 2) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/prospect-pain" target="_blank" title="Download">Prospect Pain Points</a></h1>
                            <p>This is a summary of pain points that your ideal prospect will have.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/prospect-pain/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/prospect-pain" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->								      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } /* //This section is commented to hide in PRO version Developer-A
	elseif ($d_page == 3) { ?>	
		<div class="main-wrapper">
			<!-- Main content -->	
			<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault'>
				<tr>
					<th width='14%' style='text-align:center' class='no-border'>Type</th>
					<th width='35%' style='text-align:center' class='no-border'>Description</th>
					<th class='no-border'>Instructions</th>
					<th colspan='2' width='15%' style='text-align:center' class='no-border'>Access</th>
				</tr>
				
				<tr>
					<td class='no-border'>Ideal Prospect Profile</td>
					
					<td class='no-border'>This document provides a picture of the ideal prospect that you should be looking for when prospecting.</td>
					<td class='no-border'>Treat this as a drawing of the suspect that you are looking for and keep this picture in mind when talking with prospects so that you can quickly acknowledge if the prospects fits well or not.</td>
					<td width='7%' class='no-border'>
						<a href="<?php echo base_url(); ?>output/ideal-prospect-profile" target="_blank" title="Download" ><img src='<?php echo base_url(); ?>images/html2.png' height="58px"/></a>
					</td>
					<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/ideal-prospect-profile/download" target="_blank" title="Download" ><img src='<?php echo base_url(); ?>images/doc_down.png' height="58px"/></a></td>
				</tr>
				
				<tr>
					<td class='no-border'>Prospect Pain Points</td>
					<td class='no-border'>This is a summary of pain points that you help to resolve.</td>
					<td class='no-border'>This is something that is good to print and put on your wall as you should share these pain points when talking with prospects. </td>
				<?php if ($is_paid) { ?>
					<td width='7%' class='no-border'>
						<a href="<?php echo base_url(); ?>output/prospect-pain" target="_blank" title="Download" ><img src='<?php echo base_url(); ?>images/html2.png' height="58px"/></a>
					</td>
					<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/prospect-pain/download" target="_blank" title="Download" ><img src='<?php echo base_url(); ?>images/doc_down.png' height="58px"/></a></td>
				<?php } else { ?>
					<td width='7%' class='no-border' colspan="2" >
						<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
						<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
					</td>
				<?php } ?>
				</tr>
			</table>
		</div>
		
    <?php } */elseif ($d_page == 4) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/qualifying-questions" target="_blank"title="Download">Qualifying Questions</a></h1>
                            <p>This is a list of qualifying questions that you can ask at any stage of the sales cycle.</p>
                            			        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/closing-questions" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?>target="_blank" title="Download">Closing Questions</a></h1>
                            <p>This is a list of questions that can be asked while closing the prospect.</p>
                            		     			  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($d_page == 5) { ?>						
        <h1 class="pt10">Building Interest Points</h1>
        <p>This is a list of statements that could be used to trigger interest when talking with prospects.</p>
        <ul class="middleFree" style="text-align:left;">
            <span class="note span-html">The HTML version allows you to edit your answers.</span>				            
            <li><a href="<?php echo base_url(); ?>output/building-interest/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>
            <li><a href="<?php echo base_url(); ?>output/building-interest" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>
        </ul>
    <?php } elseif ($d_page == 6) { ?>
	
         <?php $this->load->view('outputs/sales_template'); ?>
		 
    <?php } elseif ($d_page == 7) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download">Objections Map</a></h1>
                            <p>This is a list of objections that you are likely to face while cold calling and there are responses that you can use to get around the objections to keep conversations going.</p>
                            			        			
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($d_page == 8) { ?>							     
        <div class="main-wrapper">
<style type="text/css">
td {padding: 4px !important;}
td .buttonM {
    width: 60px;
    text-align: center;
    padding: 7px 15px;
}
table.emtemp tr td:nth-child(4)
{
	display:none;
}
</style>        
			<!-- Main content -->	
            <?php $unhided_templates = '';$hided_templates = '';?>
			<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault emtemp'>
				<tr >
					<th width='79%' style='text-align:center' class='no-border'>Title</th>
					<th colspan='3' width='21%' style='text-align:center' class='no-border'>Version</th>
				</tr>
                <?php foreach($all_templates as $vtemp) {
						if(!isset($vtemp->temp_id)) continue;	
						if(isset($temphides[$vtemp->temp_id])) continue;
						$tmptitle = isset($etemplate[$vtemp->temp_id])?$etemplate[$vtemp->temp_id]:$vtemp->temp_title;
				?>
				<tr >
				<td class='no-border'><?php echo $tmptitle; ?></td>
				<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>" target="_blank" title="View" class="buttonM bBlue">View</a></td>
				<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
				<?php if(isset($eScripter)) {//Hide edit button for Pro Lite?>
				<td width='7%' class='no-border dont-consider'><a href="<?php echo base_url().'home/etemplate/'.$vtemp->temp_id; ?>" class="buttonM bGreen">Edit</a></td>
				<?php }?>
				</tr>
				<?php }?>
			</table>
		</div>
        <?php if(isset($eScripter) && $eScripter){?>
        <div class="wrapper" align="right"><a  href="<?php echo base_url();?>ehide/3" class="hide-temps">Edit List</a></div>
        <?php }?>
    <?php } elseif ($d_page == 9) {
			session_start();
			$dropcam = '';
			foreach($drop_campaign as $dropcamp) 
			{
				if($dropcamp->status==1)
				{
					$dropcam1 = $dropcamp->campaign_id;
					$dropcam2 = $dropcamp->campaign_name;
				}
			}
			$_SESSION['drop_campaign_id'] = $dropcam1;
			$_SESSION['drop_campaign_name'] = $dropcam2;
	?>
    				
			<div class="main-wrapper">
<style>
td {padding: 4px !important;}
td .buttonM {
    width: 60px;
    text-align: center;
    padding: 7px 15px;
}
table.emtemp tr td:nth-child(4)
{
	display:none;
}
</style>             
				<!-- Main content -->	
				<table id="sscts" style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault emtemp'>
					<tr >
						<th width='72%' style='text-align:center' class='no-border'>Title</th>
						<th colspan='4' width='28%' style='text-align:center' class='no-border'>Version</th>
					</tr>
                    <?php foreach($all_templates as $vtemp) {
							if(!isset($vtemp->temp_id)) continue;	
							if(isset($temphides[$vtemp->temp_id])) continue;
							$tmptitle = isset($etemplate[$vtemp->temp_id])?$etemplate[$vtemp->temp_id]:$vtemp->temp_title;
                            $section_id = isset($email_sections[$vtemp->temp_id])?'t'.$email_sections[$vtemp->temp_id]:'';
					?>
					<tr >
					<td class='no-border'><?php echo $tmptitle; ?></td>
					<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>" target="_blank" title="View" class="buttonM bBlue">View</a></td>
                    <td width='7%' class='no-border'><a href="<?php echo base_url().'crm/compose/'.$section_id; ?>" title="Send" class="buttonM bBlue">Send</a></td>
					<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
					<?php if(isset($eScripter)) {//Hide edit button for Pro Lite?>
					<td width='7%' class='no-border dont-consider' style="display: table-cell !important;"><a href="<?php echo base_url().'home/etemplate/'.$vtemp->temp_id; ?>" class="buttonM bGreen">Edit</a></td>
					<?php }?>
					</tr>
					<?php }?>
				</table>			
           </div>
           <?php if(isset($eScripter) && $eScripter){?>
            <div class="wrapper" align="right"><a  href="<?php echo base_url();?>ehide/2" class="hide-temps">Edit List</a></div>
            <?php }?>
            <!-- Campaign Development -->                                      					
                <?php } elseif ($d_page == 10) { ?>						
            <div class="main-wrapper">
                <!-- Main content -->					    	
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10">Name Drop Statement</h1>
                                <p>This is a document that summarizes your name drop statements.</p>
                                				        			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } elseif ($d_page == 11) { ?>						
            <div class="main-wrapper">
                <!-- Main content -->					    	
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10">Closing Question</h1>
                                <p>This is a list of questions that can be asked while closing the prospect.</p>
                                <ul class="middleFree" style="text-align:left;">
                                    <span class="note span-html">The HTML version allows you to edit your answers.</span>									            
                                    <li><a href="<?php echo base_url(); ?>output/closing-questions/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>
                                    <li><a href="<?php echo base_url(); ?>output/closing-questions" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } elseif ($d_page == 12) { ?>						
            <div class="main-wrapper">
                <!-- Main content -->					    	
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-presentation" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Presentation</a></h1>
                                <p>This is rough sales presentation that is produced by the scripter. This is likely not a presentation that you can take from here and walk straight into a meeting with, but it at least gives you a good starting point to build off of when needing a sales overview presentation.</p>
                                				        			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } elseif ($d_page == 13) { ?>
				<div class="main-wrapper">
<style type="text/css">
td {padding: 4px !important;}
td .buttonM {
    width: 60px;
    text-align: center;
    padding: 7px 15px;
}
</style>                
					<!-- Main content -->	
					<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault'>
						<tr>
							<th width='86%' style='text-align:center' class='no-border'>Title</th>
							<th colspan='2' width='14%' style='text-align:center' class='no-border'>Version</th>
						</tr>
						<tr >
							<td class='no-border'>Product Matrix</td>
							
							<td width='7%' class='no-border'>
								<a href="<?php echo base_url(); ?>output/product-matrix" target="_blank" title="View" class="buttonM bBlue">View</a>
							</td>
							<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/product-matrix/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
						</tr>
						
						<tr>
							<td class='no-border'>Email Marketing Topics</td>							
							
						<?php if ($is_paid) { ?>
							<td width='7%' class='no-border'>
								<a href="<?php echo base_url(); ?>output/email-marketing-topics" target="_blank" title="View" class="buttonM bBlue">View</a>
							</td>
							<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/email-marketing-topics/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
						<?php }else{ ?>
							<td width='7%' class='no-border' colspan="2" >
								<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
								<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
							</td>
						<?php } ?>
						</tr>
						
						<tr >
							<td class='no-border'>Content Marketing Topics</td>
							
							
						<?php if ($is_paid) { ?>
							<td width='7%' class='no-border'>
								<a href="<?php echo base_url(); ?>output/content-marketing-topics" target="_blank" title="View" class="buttonM bBlue">View</a>
							</td>
							<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/content-marketing-topics/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
						<?php }else{ ?>
							<td width='7%' class='no-border' colspan="2" >
								<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
								<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
							</td>
						<?php } ?>
						</tr>
						
						<tr >
							<td class='no-border'>Sales Presentation</td>
							
						<?php if ($is_paid) { ?>
							<td width='7%' class='no-border'>
								<a href="<?php echo base_url(); ?>output/sales-presentation" target="_blank" title="View" class="buttonM bBlue">View</a>
							</td>
							<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/sales-presentation/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
						<?php }else{ ?>
							<td width='7%' class='no-border' colspan="2" >
								<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
								<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
							</td>
						<?php } ?>
						</tr>
                        <tr>
								<td class='no-border'>Value Statements</td>								
								
							<?php if ($is_paid) { ?>
								<td width='7%' class='no-border'>
									<a href="<?php echo base_url(); ?>output/elevator-pitch" target="_blank" title="View"  class="buttonM bBlue">View</a>
								</td>
								<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/elevator-pitch/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
							<?php }else{ ?>
								<td width='7%' class='no-border' colspan="2" >
									<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
									<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
								</td>
							<?php } ?>
							</tr>
							
							<tr>
								<td class='no-border'>Building Interest Silver Bullets</td>
								
							<?php if ($is_paid) { ?>
								<td width='7%' class='no-border'>
									<a href="<?php echo base_url(); ?>output/building-interest" target="_blank" title="View"  class="buttonM bBlue">View</a>
								</td>
								<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/building-interest/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
							
							<?php }else{ ?>
								<td width='7%' class='no-border' colspan="2" >
									<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
									<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
								</td>
							<?php } ?>
							</tr>
							<tr>
								<td class='no-border'>Name Drop Statement</td>
								
							<?php if ($is_paid) { ?>
								<td width='7%' class='no-border'>
									<a href="<?php echo base_url(); ?>output/name-drop-statments" target="_blank" title="View"  class="buttonM bBlue">View</a>
								</td>
								<td width='7%' class='no-border'><a href="<?php echo base_url(); ?>output/name-drop-statments/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
							<?php } else{ ?>
								<td width='7%' class='no-border' colspan="2" >
									<span style="text-align:center; display: block;"><strong>Only Available in Pro</strong><br/>
									<a id="32" href="https://salesscripter.com/members/signup" target="_blank" ><strong>Upgrade Here</strong></a></span>
								</td>
							<?php } ?>
							</tr>
					</table>
				</div>
                <?php } elseif ($d_page == 14) { ?>                
					<div class="main-wrapper">
<style type="text/css">
td {padding: 4px !important;}
td .buttonM {
    width: 60px;
    text-align: center;
    padding: 7px 15px;
}
</style>                    
						<!-- Main content -->	
                        <?php $unhided_templates = '';$hided_templates = '';?>	
						<table style='margin: 6px 30px;width: 95%;background: none repeat scroll 0 0 #E6E6E6;' class='tDefault'>
							<tr >
								<th width='79%' style='text-align:center' class='no-border'>Title</th>								
								<th colspan='3' width='21%' style='text-align:center' class='no-border'>Version</th>
							</tr>
                            <?php foreach($all_templates as $vtemp) {
									if(!isset($vtemp->temp_id)) continue;	
									if(isset($temphides[$vtemp->temp_id])) continue;
									$tmptitle = isset($etemplate[$vtemp->temp_id])?$etemplate[$vtemp->temp_id]:$vtemp->temp_title;
							?>
							<tr >
							<td class='no-border'><?php echo $tmptitle; ?></td>
							<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>" target="_blank" title="View" class="buttonM bBlue">View</a></td>
							<td width='7%' class='no-border'><a href="<?php echo base_url().'output/'.$vtemp->temp_slug; ?>/download" title="Download" class="buttonM bBlue" onclick="return download_template(this);">Download</a></td>
							<?php if(isset($eScripter)) {//Hide edit button for Pro Lite?>
							<td width='7%' class='no-border dont-consider'><a href="<?php echo base_url().'home/etemplate/'.$vtemp->temp_id; ?>" class="buttonM bGreen">Edit</a></td>
							<?php }?>
							</tr>
							<?php }?>
						</table>
					</div>
                    <?php if(isset($eScripter) && $eScripter){?>
                    <div class="wrapper" align="right"><a  href="<?php echo base_url();?>ehide/4" class="hide-temps">Edit List</a></div>
                    <?php }?>
					
            
            <?php } elseif ($d_page == 15) { ?>	

					<?php $this->load->view('common/my-folder') ?>
			<?php } elseif ($d_page == 41) { ?>	
					<?php $this->load->view('folder-campaigns') ?>
            <?php } elseif ($d_page == 42) { ?>	
					<?php $this->load->view('folder-company-profiles') ?>
            <?php } elseif ($d_page == 43) { ?>	
					<?php $this->load->view('folder-name-drop-examples') ?>
            <?php } elseif ($d_page == 44) { ?>	
					<?php $this->load->view('folder-custom-content') ?> 
            <?php } elseif ($d_page == 45) { ?>	
					<?php $this->load->view('folder-product-profile') ?>        		
					
            <?php } elseif ($d_page == 55) { ?>	
					<?php $this->load->view('folder-map') ?>        		
					
            <?php } elseif ($d_page == 16) { ?>				    	
            <div class="wrapper">
                <!-- Start Receiver Shared Data Listing if available -->							
                <?php $msg = $this->session->flashdata('session_msg'); ?>
                <?php if ($msg): ?><br>
                    <h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
                <?php endif; ?>
                    
                <?php if (!empty($accept_invitations) OR !empty($accept_invitations_receiver)): ?>														
                <?php $sender = count($accept_invitations) . '<br>'; ?>							
                <?php $receiver = count($accept_invitations_receiver) . '<br>'; ?>					    		
                <div class="widget fluid">
                    <div class="grid12">
                    <?php if (!empty($accept_invitations)): ?>										
                        <?php if ($sender == 1): ?>
                    <h1 style="margin-left:10px;" class="pt10">Team Members Shared Data</h1>
                    <?php endif; ?>										
                    <?php foreach ($accept_invitations as $accept): ?>										
                    <?php $detail = $this->home->getDetailForManagementListing($accept->receiver_id, 'receiver'); ?>																		 		
                        <div class="body">
                            <h2 class="pt10"><?php echo $detail->first_name . ' ' . $detail->last_name; ?></h2>
                            <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                <tbody>
                                    <?php $all_team_sessions_receiver = $this->home->get_all_team_sessions($accept->receiver_id); ?> 												
                                    <?php if (!empty($all_team_sessions_receiver)): ?>						                        		
                                    <?php foreach ($all_team_sessions_receiver as $sessions): ?>						                        								                        			
                                    <?php if ($sessions->status != '2'): ?>																
                                        <tr>
                                            <td class="no-border">
                                            <h6><span class="dynamic_value edit_session" id="edit_<?php echo $sessions->session_id; ?>"><?php echo $sessions->session_name; ?></span></h6>
                                            </td>
                                            <?php if ($sessions->status == '0'): ?>									                                	
                                            <td  width="20px;" class="no-border"><a <?php if ($is_paid) { ?> href="#_" onclick="launchSession('<?php echo $sessions->session_id; ?>','yes');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="launch" value="Launch" /></a></td>
                                            <td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolder('<?php echo $sessions->session_id; ?>','<?php echo $sessions->session_name; ?>','<?php echo $sessions->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
                                            <?php endif; ?>									                               
                                            <?php if ($sessions->status == '1'): ?>									                                	
                                            <td  width="20px;" class="no-border"><a <?php if ($is_paid) { ?> href="#_" onclick="launchSession('<?php echo $sessions->session_id; ?>','yes');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="launch" value="Launch" /></a></td>
                                            <td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolder('<?php echo $sessions->session_id; ?>','<?php echo $sessions->session_name; ?>','<?php echo $sessions->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
                                            <?php endif; ?>									                            
                                        </tr>
                                    <?php endif; ?>							                            
                                    <?php endforeach; ?>						                            
                                    <?php endif; ?>						                        
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach; ?>					        		
                    <?php endif; ?>					        							        		
                    <?php if (!empty($accept_invitations_receiver)): ?>					        		
                    <?php if ($sender == 0 AND $receiver == 1): ?>
                        <h1 style="margin-left:10px;" class="pt10">Team Members Shared Data</h1>
                    <?php endif; ?>									
                    <?php foreach ($accept_invitations_receiver as $accept): ?>									
                        <?php $detail = $this->home->getDetailForManagementListing($accept->sender_id, 'receiver'); ?>																 		
                        <div class="body">
                            <h2 class="pt10"><?php echo $detail->first_name . ' ' . $detail->last_name; ?></h2>
                            <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                <tbody>
                                <?php $all_team_sessions_receiver = $this->home->get_all_team_sessions($accept->sender_id); ?> 											
                                <?php if (!empty($all_team_sessions_receiver)): ?>					                        		
                                    <?php foreach ($all_team_sessions_receiver as $sessions): ?>					                        							                        			
                                        <?php if ($sessions->status != '2'): ?>															
                                        <tr>
                                            <td class="no-border">
                                            <h6><span class="dynamic_value edit_session" id="edit_<?php echo $sessions->session_id; ?>"><?php echo $sessions->session_name; ?></span></h6>
                                            </td>
                                            <?php if ($sessions->status == '0'): ?>								                                	
                                            <td  width="20px;" class="no-border"><a <?php if ($is_paid) { ?> href="#_" onclick="launchSession('<?php echo $sessions->session_id; ?>','yes');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="launch" value="Launch" /></a></td>
                                            <td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolder('<?php echo $sessions->session_id; ?>','<?php echo $sessions->session_name; ?>','<?php echo $sessions->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
                                            <?php endif; ?>								                               <?php if ($sessions->status == '1'): ?>								                                	
                                            <td  width="20px;" class="no-border"><a <?php if ($is_paid) { ?> href="#_" onclick="launchSession('<?php echo $sessions->session_id; ?>','yes');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="launch" value="Launch" /></a></td>
                                            <td  width="20px;" class="no-border"><a href="#_" onclick="saveToMyFolder('<?php echo $sessions->session_id; ?>','<?php echo $sessions->session_name; ?>','<?php echo $sessions->user_id; ?>');" ><input type="button" class="buttonM bRed" name="save-to-folder" value="Save to My Folder" /></a></td>
                                        <?php endif; ?>								                            
                                        </tr>
                                        <?php endif; ?>						                            
                                    <?php endforeach; ?>					                            
                                <?php endif; ?>					                        
                                </tbody>
                            </table>
                        </div>
                    <?php endforeach; ?>				        		
                    <?php endif; ?>									
                    </div>
                </div>
                <?php endif; ?> 						
            <!-- End Receiver Shared Data Listing if available -->						
            </div>
            <!-- Start Search for a Team Member Form -->						    
            <!-- Main content -->						     
            <div class="wrapper">
            					    							    	
                <?php $msg = $this->session->flashdata('msg'); ?>						    	
				<?php if (isset($msg)): ?>
                <div style="margin-top:10px; color:green;"><?php echo $msg; ?></div>
                <?php endif; ?>						       	
                <form id="validate" name="SearchForm" action="<?php echo current_url(); ?>" method="POST">
                    <div class="fluid">
                        <div class="widget grid12">
                            <h1 style="margin-left:10px;" class="pt10">Search for team member</h1>
                                <div class="formRow">
                                    <div class="grid4"><label>Search By User Name</label></div>
                                    <div class="grid5"><input style="height:30px !important;" type="text" class="validate[required]" name="search_name" id="search_name" value=""></div>
                                    <div class="grid1"><input type="submit" class="buttonM bBlue" name="submit" value="Search" /></div>
                                    <div class="grid1"><input type="button" class="dialog_invitation buttonM bBlue" value="Invite New User" data-icon="&#xe090;"/>							                        </div>
                                    <div class="clear"></div>
                                </div>
                            <?php if (isset($message)): ?>
                            <h3 style="margin-left:10px;"><?php echo $message; ?></h3>
                            <?php endif; ?>							                    						                    
                        </div>
                    </div>
                </form>
                <!-- Search Result Start -->						        
                <?php if (!empty($user_data)): ?>							        
                <div class="fluid">
                    <div class="widget grid12">
                        <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                            <thead>
                                <tr>
                                <th class="no-border">
                                <h6>User Name</h6>
                                </th>
                                <th class="no-border">
                                <h6>First Name</h6>
                                </th>
                                <th class="no-border">
                                <h6>Last Name</h6>
                                </th>
                                <th class="no-border">
                                <h6>Action</h6>
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($user_data as $data): ?>												   
                                <tr class="align-center">
                                    <td class="no-border"><?php echo $data->username; ?></td>
                                    <td class="no-border"><?php echo $data->first_name; ?></td>
                                    <td class="no-border"><?php echo $data->last_name; ?></td>
                                    <td class="no-border">												         	
                                    <a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/send_invitation/<?php echo $data->user_id; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Send Invitaion" /></a>												         													       </td>
                                </tr>
                                <?php endforeach; ?>											  
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>								 
            <!-- Search Result End -->								 						
            </div>
            <!-- End Search for a Team Member Form -->												
            <!-- Start Invitation Listings if Available -->				    	
            <div class="wrapper">
                <!-- <div style="margin-top:10px;">				    			
                <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>user-management" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="User Management" /></a>&nbsp;				    			
                <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>for-team-member" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>				    		</div> -->				    		
                <div class="widget fluid">
                    <h1 style="margin-left:10px;" class="pt10">Open Invitations</h1>
                    <div class="grid12">
                        <div class="body">
                        <?php if (!empty($receive_invitations)): ?>								       	
                            <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                <thead>
                                    <tr>
                                        <th class="no-border">
                                            <h6>User Name</h6>
                                        </th>
                                        <th class="no-border">
											<h6>First Name</h6>
                                        </th>
                                        <th class="no-border">
                                            <h6>Last Name</h6>
                                        </th>
                                        <th class="no-border">
                                            <h6>Action</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($receive_invitations as $invitations): ?>												
                                    <?php $detail = $this->home->getDetailForManagementListing($invitations->sender_id, 'receiver'); ?>											   
                                        <tr class="align-center">
                                            <td class="no-border"><?php echo $detail->username; ?></td>
                                            <td class="no-border"><?php echo $detail->first_name; ?></td>
                                            <td class="no-border"><?php echo $detail->last_name; ?></td>
                                            <td class="no-border">											         	
                                            <a <?php if ($is_paid) { ?> href="#_" onclick="requestAccept('<?php echo $invitations->receiver_id; ?>');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bGreen" name="accept" value="Accept" /></a>&nbsp;											         	<a <?php if ($is_paid) { ?> href="#_" onclick="deleteFrndRequest('<?php echo $invitations->receiver_id; ?>','rec');" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>											       </td>
                                        </tr>
                                    <?php endforeach; ?>																					  
                                </tbody>
                            </table>
                        <?php else: ?>											
                        <div style="margin-left: -30px;font-size:14px;">There is no Invitation from your Team Members</div>
                        <?php endif; ?>				        			
                        </div>
                    </div>
                </div>
                <!-- End Invitation Listings if Available -->							
            </div>
            <!-- Start Existing Team Members Conection -->							    
                    <div class="wrapper">
                        <!-- <div style="margin-top:10px;">							    		
                        <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>for-team-member" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a> </div> -->
						<?php if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        
                            <div class="fluid">
                                <div class="widget grid12">
                                    <h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Existing Team Member Connections</h1>
                                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                        <thead>
                                            <tr>
                                                <th class="no-border">
                                                    <h6>User Name</h6>
                                                </th>
                                                <th class="no-border">
                                                    <h6>First Name</h6>
                                                </th>
                                                <th class="no-border">
                                                    <h6>Last Name</h6>
                                                </th>
                                                <th class="no-border">
                                                    <h6>Action</h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($all_requests)): ?>															  	
                                            <?php foreach ($all_requests as $requests): ?>															  		
                                            <?php $detail = $this->home->getDetailForManagementListing($requests->receiver_id, 'receiver'); ?>																   
                                            <tr class="align-center">
                                                <td class="no-border"><?php echo $detail->username; ?></td>
                                                <td class="no-border"><?php echo $detail->first_name; ?></td>
                                                <td class="no-border"><?php echo $detail->last_name; ?></td>
                                                <td class="no-border">																         	
                                                <a href="#_" onclick="deleteFrndRequest('<?php echo $requests->receiver_id; ?>','rec','<?php echo $requests->sender_id; ?>','<?php echo $requests->t_session_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>																         																	       </td>
                                            </tr>
                                            <?php endforeach; ?>														
                                            <?php endif; ?>	 														 
                                            <?php if (!empty($all_receiver_requests)): ?>															 
                                            <?php foreach ($all_receiver_requests as $requests): ?>														  		
                                            <?php $detail = $this->home->getDetailForManagementListing($requests->sender_id, 'receiver'); ?>															   
                                            <tr class="align-center">
                                                <td class="no-border"><?php echo $detail->username; ?></td>
                                                <td class="no-border"><?php echo $detail->first_name; ?></td>
                                                <td class="no-border"><?php echo $detail->last_name; ?></td>
                                                <td class="no-border">															         	
                                            <a href="#_" onclick="deleteFrndRequest('<?php echo $requests->sender_id; ?>','send','<?php echo $requests->sender_id; ?>','<?php echo $requests->t_session_id; ?>');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>															       
                                            </td>
                                            </tr>
                                            <?php endforeach; ?>														
                                            <?php endif; ?>																										  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>							
                    </div>
                    <!-- End Existing Team Members Conection -->																			
                    <?php
                    }elseif ($d_page == 17) {?>
                    
                    <div class="main-wrapper">
                        <!-- Main content -->
                        
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a href="<?php echo base_url(); ?>paincampaignkit" title="Pain Campaign Kit">Pain Campaign Kit</a></h1>
                                        <p>A campaign kit with scripts and emails that focus on the pain that you help to resolve.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-wrapper">
                        <!-- Main content -->
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a href="<?php echo base_url(); ?>valuecampaignkit" title="Value Campaign Kit">Value Campaign Kit</a></h1>
                                        <p>A campaign kit with scripts and emails that focus on the value that your products and services offer.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>          
                    <div class="main-wrapper">
                                             
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a href="<?php echo base_url(); ?>namedropcampaignkit" title="Name Drop Campaign Kit">Name Drop Campaign Kit</a></h1>
                                        <p>A campaign kit with scripts and emails that focus on the a name drop example.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>         
                    <?php }
                    elseif ($d_page == 18) { ?>						    	
                    <div class="wrapper">
                        <div class="widget fluid">
                            <div class="grid12">
                                <div class="body">
                                    <h1 class="pt10">Template Library</h1>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <?php
                } 
                ?>
            </div>
<?php 
    //Download template actions
    if ($d_page == 6 || $d_page == 9 || $d_page == 8 || $d_page == 14 || $d_page == 13) { ?>
<iframe id="DownloadTemplate" src="<?php echo base_url(); ?>crm/downdocx" style="visibility: hidden;"></iframe>
<script type="text/javascript">
    //download template
    function download_template(dis) {
        $("#DownloadTemplate").attr("src",$(dis).attr("href"));
        return false;
    }
	function primaryScript(tempid,dis)
	{
		var vis = dis.checked?1:0;
		var position = $(dis).position();
		var offset = $(dis).offset();
		$('.pleasewait').css('top',offset.top);
		$('.pleasewait').css('left',offset.left);
		$('.pleasewait').css('display','block');
        $.ajax({
            type : 'POST',
            url : '<?php echo current_url();?>',
            data: 'tempid='+tempid+'&action=PrimaryScriptupdate&val='+vis,
            cache: false,
            dataType: 'json',
            success: function(responce)
            {
                $('.pleasewait').css('display','none');
				//location.replace("<?php echo current_url();?>");
            }
        });
	}
</script>
<?php }?> 
<?php if($d_page==6 || $d_page==9 || $d_page==8 || $d_page==14){?> 
    <script type="text/javascript">
    <?php if($d_page==6){?> 
    var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/nyNMERgDVo4?list=PLoUVJsDQgZIJWf8vOR0B9TAORXP3atFfC" frameborder="0" allowfullscreen></iframe>';
    <?php } else if($d_page==9){?> 
    var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/MW7axfaUD_M" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';    
    <?php } else if($d_page==8){?> 
    var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/AswcPX5DyuE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';    
    <?php } else if($d_page==14){?> 
    var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/AswcPX5DyuE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';    
    <?php }?>
    $( document ).ready(function() {
        $('.help_dialog').dialog({
            autoOpen: false,
            height: 400,
            width: 600,
            buttons: {
                "Close": function () {
                    $('.video').html('');
                    $(this).dialog("close");
                    
                }
            }    
        });
        
        // Invitation Dialog Link
        $('.dialog_help').click(function (e) {
             $('.video').html(iframe);
             $('.help_dialog').dialog('open');
             
            return false;
        });
        
        $('.ui-icon-closethick').click(function (e) {
             $('.video').html('');
              $('.help_dialog').dialog('close');
            return false;
        });
        
    });    
    </script>
    <div class="help_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Video</title>
        </head>

        <body>
         <div class="video">

         </div>
        </body>
        </html></div>    
    <?php }?>            
<!-- Main content ends -->
</div>
<?php $this->load->view('common/footer'); ?>