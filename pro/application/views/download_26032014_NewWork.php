<?php $this->load->view('common/meta'); ?>	<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>	    <!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>
<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">
<?php //$this->load->view('common/progress_bar');?>    <!-- Breadcrumbs line -->    
    <?php $this->load->view('common/top_navigation'); ?> 				    
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
    <?php } elseif ($d_page == 3) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/ideal-prospect-profile" target="_blank" title="Download">Ideal Prospect Profile</a></h1>
                            <p>This document provides a picture of the ideal prospect for what you are selling.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/ideal-prospect-profile/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/ideal-prospect-profile" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				       			   
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/prospect-pain" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Prospect Pain Points</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is a summary of pain points that your ideal prospect will have.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">											<span class="note span-html">The HTML version allows you to edit your answers.</span>									            <li><a href="<?php echo base_url(); ?>output/prospect-pain/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>									            <li><a href="<?php echo base_url(); ?>output/prospect-pain" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>									        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($d_page == 4) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/qualifying-questions" target="_blank"title="Download">Qualifying Questions</a></h1>
                            <p>This is a list of qualifying questions that you can ask at any stage of the sales cycle.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/qualifying-questions/download"  title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/qualifying-questions" target="_blank"title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
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
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/closing-questions/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/closing-questions" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				     			  
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
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/indirect-cold-call-script" target="_blank" title="Download">Call Script &#45; Qualify Focus</a></h1>
                            <p>This is a script that can be used while cold calling prospects that you have never spoken to before and they do not know who you are. This script uses an indirect approach that utilizes questions to get more a of conversation going and gather information prior to going for a close.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/indirect-cold-call-script/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/indirect-cold-call-script" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/direct-cold-call-script" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Call Script &#45; Close Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is a script that can be used while cold calling prospects that you have never spoken to before and they do not know who you are. This script uses an direct approach that goes for the close very early in the call.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/direct-cold-call-script/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/direct-cold-call-script" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/first-meeting-script" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?>target="_blank" title="Download">First Meeting Script</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is an outline of questions and statements that can be made when you are in a formal first meeting with a prospect.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">											<span class="note span-html">The HTML version allows you to edit your answers.</span>									            <li><a href="<?php echo base_url(); ?>output/first-meeting-script/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>									            <li><a href="<?php echo base_url(); ?>output/first-meeting-script" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>									        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/call-script-name-drop" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Call Script &#45; Name Drop</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This script uses a name drop early in the call to try to open and grab the prospect's attention.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/call-script-name-drop/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/call-script-name-drop" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/call-script-focus-product" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Call Script &#45; Product Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This script focuses more on detail around the products and services that you sell.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/call-script-focus-product/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/call-script-focus-product" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/call-script-focus-pain" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Call Script &#45; Pain Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This script focuses more on the pain that you resolve early in the call to try to grab the prospect's attention.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/call-script-focus-pain/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/call-script-focus-pain" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- INBOUND CALL SCRIPT -->                                                                                
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/inbound-call-script" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Inbound Call Script</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is a script that can be used while cold calling prospects that you have never spoken to before and they do not know who you are. This script uses an indirect approach that utilizes questions to get more a of conversation going and gather information prior to going for a close.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- INBOUND CALL SCRIPT -->				     
        </div>
    <?php } elseif ($d_page == 7) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download">Objections Map</a></h1>
                            <p>This is a list of objections that you are likely to face while cold calling and there are responses that you can use to get around the objections to keep conversations going.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/objections-map/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($d_page == 8) { ?>					<!-- <div class="main-wrapper">				    	<div class="wrapper">				    		<div class="widget fluid">								<div class="grid12">							 		<div class="body">										<h1 class="pt10"><a href="<?php echo base_url(); ?>output/voicemail-script" target="_blank" title="Download" >Voicemail Script</a></h1>										<p>These are individual voicemail scripts that can be left when leaving a message for a prospect.These messages might not be perfect for what you want to say, but they should either be close or at least be a good starting point for you to build off of.</p>				        			</div>								</div>							</div>						</div>				     </div> -->				     
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/voicemail-value-focus" target="_blank" title="Download" >Voicemail Script &#45; Value Focus</a></h1>
                            <p>A voicemail script that focuses on your value to get the prospect's attention.</p>
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
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-value-focus-appoint" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Value Focus (Appointment)</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>A voicemail script that focuses on your value and includes a request for an appointment.</p>
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
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-pain-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Pain Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>A voicemail script that focuses on the pain you resolve to get the prospect's attention.</p>
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
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-pain-focus-appoint" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Pain Focus (Appointment)</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>A voicemail script that focuses on the pain you resolve and includes a request for an appointment.</p>
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
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-name-drop-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Name Drop Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>A voicemail script that focuses on a name drop example to get the prospect's attention.</p>
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
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-name-drop-appoint" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Name Drop Focus (Appointment)</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>A voicemail script that focuses on a name drop example and includes a request for an appointment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif ($d_page == 9) { ?>					
        <div class="main-wrapper">
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a href="<?php echo base_url(); ?>output/pre-call-email-pain-focus" target="_blank" title="Download" >Pre&#45;Call Email &#45; Pain Focus</a></h1>
                            <p>This is a brief email that is designed to be sent to a prospect before calling. The email focuses on the pain that you resolve.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-pain-focus/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-pain-focus" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Pre&#45;Call Email &#45; Value Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is a brief email that is designed to be sent to a prospect before calling. The email focuses on the value that you offer.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-namedrop-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Pre&#45;Call Email &#45; Name Drop Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is a brief email that is designed to be sent to a prospect before calling. The email mentions an example of how you helped a client.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-product-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Pre&#45;Call Email &#45; Product Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is a brief email that is designed to be sent to a prospect before calling. The email focuses on details about what you sell.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-product-focus/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-product-focus" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-thread" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Pre&#45;Call Email Thread</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is an email thread that can be sent to a prospect before your cold call and is designed to help make your cold call more warm. This thread includes three separate emails that are designed to build off of one another and be sent to a prospect spread out over a period of 4 weeks. These emails might not be perfect for what you want to say, but they should either be close or at least be a good starting point for you to build off of.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-thread/download"  class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-thread"  class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main content -->				    	
            <div class="wrapper">
                <div class="widget fluid">
                    <div class="grid12">
                        <div class="body">
                            <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-call-email-thread" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Post&#45;Call Email Thread</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                            <p>This is an email thread that can be sent to a prospect after you speak to them during a cold call. This thread includes three separate emails that are designed to build off of one another and be sent to a prospect spread out over a period of 4 weeks. These emails might not be perfect for what you want to say, but they should either be close or at least be a good starting point for you to build off of.</p>
                            <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-call-email-thread/download"  class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-call-email-thread" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-voicemail-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Post&#45;Voicemail Email &#45; Value Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>An email that is mentions the value that you offer. This is designed to go out after you leave the voicemail message that has a value focus.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-voicemail-pain-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Post&#45;Voicemail Email &#45; Pain Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>An email that is mentions the pain you resolve. This is designed to go out after you leave the voicemail message that has a pain focus.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-voicemail-name-drop-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Post&#45;Voicemail Email &#45; Name Drop Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>An email that is mentions a name drop story. This is designed to go out after you leave the voicemail message that has a name drop focus.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-letter-pain-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Letter &#45; Pain Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>A physical letter to send to a prospect that you have not met with when trying to get an appointment. This letter focuses on the pain you resolve.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-letter-name-drop-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Letter &#45; Name Drop Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>A physical letter to send to a prospect that you have not met with when trying to get an appointment. This letter focuses on a name drop of a client that you have worked with.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-letter-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Letter &#45; Value Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>A physical letter to send to a prospect that you have not met with when trying to get an appointment. This letter focuses on the value that you offer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Internal Referral Email -->                                        
            <div class="main-wrapper">
                <!-- Main content -->				    	
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/internal-referral-email" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Internal Referral Email</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>This is a brief email that is designed to be sent to a prospect after calling. The email focuses on the internal referral system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Internal Referral Email -->  <!-- Campaign Development -->                                        
            <div class="main-wrapper">
                <!-- Main content -->                                                
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/campaign-development" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Email Drip Campaign Guide</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>A document that outlines 5 tiers of drip campaigns and the content that can be developed for each.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                <!-- <ul class="middleFree" style="text-align:left;">											<span class="note span-html">The HTML version allows you to edit your answers.</span>									            <li><a href="<?php echo base_url(); ?>output/name-drop-statments/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>									            <li><a href="<?php echo base_url(); ?>output/name-drop-statments" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>									        </ul> -->					        			
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
                                <!-- <ul class="middleFree" style="text-align:left;">											<span class="note span-html">The HTML version allows you to edit your answers.</span>									            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-presentation/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>									            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-presentation" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>									        </ul> -->					        			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } elseif ($d_page == 13) { ?>						
            <div class="main-wrapper">
                <!-- Main content -->					    	
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10"><a href="<?php echo base_url(); ?>output/product-matrix" target="_blank" title="Download">Product Matrix</a></h1>
                                <p>This is a matrix that outlines your products and the benefits they provide.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/content-marketing-topics" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Content Marketing Topics</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>This document includes topics that you can use when developing blog posts, articles, and emails messages.</p>
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
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-presentation" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Presentation</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>This is rough sales presentation that is produced by the scripter. This is likely not a presentation that you can take from here and walk straight into a meeting with, but it at least gives you a good starting point to build off of when needing a sales overview presentation.</p>
                                <!-- <ul class="middleFree" style="text-align:left;">											<span class="note span-html">The HTML version allows you to edit your answers.</span>									            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-presentation/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>									            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-presentation" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>									        </ul> -->					        			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Campaign Development -->                                        
            <div class="main-wrapper">
                <!-- Main content -->                                                
                <div class="wrapper">
                    <div class="widget fluid">
                        <div class="grid12">
                            <div class="body">
                                <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/campaign-development" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Email Drip Campaign Guide</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                <p>A document that outlines 5 tiers of drip campaigns and the content that can be developed for each.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } elseif ($d_page == 14) { ?>					
                    <div class="main-wrapper">
                        <!-- Main content -->				    	
                        <!--<div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a href="<?php echo base_url(); ?>output/qualifying-questions" target="_blank"title="Download">Qualifying Questions</a></h1>
                                        <p>This is a list of qualifying questions that you can ask at any stage of the sales cycle.</p>
                                    </div>
                                </div>
                            </div>
                        </div>-->                        
                        <!-- Main content -->				    	
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a href="<?php echo base_url(); ?>output/pre-qualifying-questions" target="_blank"title="Download">Pre &#45; Qualifying Questions</a></h1>
                                        <p>These are the questions that you should ask a prospect in the initial contact and first appointment stages of a sales cycle to identify if it makes sense to even spend time talking.</p>
                                        <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/qualifying-questions/download"  title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/qualifying-questions" target="_blank"title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main content -->				    	
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>output/hard-qualifying-questions" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank"title="Download">Hard Qualifying Questions</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                        <p>These are the questions that you should ask when you are ready to assess how real the opportunity is in terms of potential to move forward.</p>
                                        <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/qualifying-questions/download"  title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/qualifying-questions" target="_blank"title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main content -->				    	
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/closing-questions" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Closing Questions</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                        <p>This is a list of questions that can be asked while closing the prospect.</p>
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
                                        <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/elevator-pitch"  <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> title="Download" target="_blank"> Value Statements</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                        <p>This is a list of statements that could be used as an elevator pitch to describe what you do. These statements are composed of different combinations of your value, pain, building interest, and building credibility points. Some of these may work well. Some might not. There are plenty to chose from.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main content -->    			
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/building-interest" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download"> Building Interest Points</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                        <p>This is a list of statements that could be used to trigger interest when talking with prospects.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Main content -->    			
                        <div class="wrapper">
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/name-drop-statments" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" > Name Drop Statement</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                        <p>This is a document that summarizes your name drop statements.</p>
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
                                        <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/objections-map" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Objections Map</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                                        <p>This is a list of objections that you are likely to face while cold calling and there are responses that you can use to get around the objections to keep conversations going.</p>
                                        <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/objections-map/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li>								        </ul> -->				        			
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
                <?php } elseif ($d_page == 15) { ?>						<!-- Main content -->				    	
                    <div class="wrapper">
                        <div class="widget fluid">
                            <div class="grid12">
                                <div class="body">
                                    <h1 class="pt10">My Folder</h1>
                                    <br>										
                                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                        <tbody>
                                            <?php if (!empty($all_sessions)): ?>																                        		<?php foreach ($all_sessions as $sessions): ?>					                        			<?php if ($sessions->status != '2'): ?>															
                                                        <tr>
                                                            <td class="no-border">
                                                                <h6><span class="dynamic_value edit_session" id="edit_<?php echo $sessions->session_id; ?>"><?php echo $sessions->session_name; ?></span></h6>
                                                            </td>
                                                            <?php //if($sessions->status == '0'):?>								                                	
                                                            <td  width="20px;" class="no-border"><a href="#_" onclick="launchSession('<?php echo $sessions->session_id; ?>','no');"><input type="button" class="buttonM bGreen" name="launch" value="Launch" /></a></td>
                                                            <td  width="20px;" class="no-border"><a href="#_" onclick="deleteSession('<?php echo $sessions->session_id; ?>','<?php echo $sessions->status; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>
                                                            <?php //endif;?>								                               <!--  <?php //if($sessions->status == '1'):?>								                                	<td  width="20px;" class="no-border"><a href="#_" onclick="deleteSession('<?php echo $sessions->session_id; ?>');" ><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a></td>								                                <?php //endif;?>  -->								                            
                                                        </tr>
                                                    <?php endif; ?>						                            <?php endforeach; ?>					                            <?php endif; ?>					                            					                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <a <?php if ($is_paid AND $total_sessions > 0) { ?> href="<?php echo base_url(); ?>home/newSession" class="buttonM bRed" <?php } else { ?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php } ?>>Create New Campaign</a>						
                        <br><br>
                        
                        <strong>Access scripts and campaigns already filled out!</strong>
                        <br>Go to Team Folder, search for user "templates"
                    </div>
                    <?php
                } elseif ($d_page == 16) {
                    ?>				    	
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
            <!-- <div style="margin-top:10px;">						    		
                <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>user-management" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="User Management" /></a>						    	</div> -->						    							    	
                <?php $msg = $this->session->flashdata('msg'); ?>						    	<?php if (isset($msg)): ?>
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
                        <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>for-team-member" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									<?php if (!empty($all_requests) or !empty($all_receiver_requests)): ?>								        
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
                                            <?php if (!empty($all_requests)): ?>															  	
                                            <?php foreach ($all_requests as $requests): ?>															  		
                                            <?php $detail = $this->home->getDetailForManagementListing($requests->receiver_id, 'receiver'); ?>																   
                                            <tr class="align-center">
                                                <td class="no-border"><?php echo $detail->username; ?></td>
                                                <td class="no-border"><?php echo $detail->first_name; ?></td>
                                                <td class="no-border"><?php echo $detail->last_name; ?></td>
                                                <td class="no-border">																         	
                                                <a href="#_" onclick="deleteFrndRequest('<?php echo $requests->receiver_id; ?>','rec');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>																         																	       </td>
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
                                            <a href="#_" onclick="deleteFrndRequest('<?php echo $requests->sender_id; ?>','send');"><input type="button" class="buttonM bRed" name="delete" value="Delete" /></a>															       
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
                    
                    <!-- This Code is for Searching the email templates from the database.
                         The Code is added by Aavid Developer on 26-March - 2014 -->
                    
                    <div class="wrapper">
                    <!-- <div style="margin-top:10px;">						    		
                        <a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>user-management" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="request" value="User Management" /></a>						    	</div> -->						    							    	
                        <?php $msg = $this->session->flashdata('msg'); ?>						    	<?php if (isset($msg)): ?>
                        <div style="margin-top:10px; color:green;"><?php echo $msg; ?></div>
                        <?php endif; ?>						       	
                        <form id="validate" name="SearchForm" action="<?php echo current_url(); ?>" method="POST">
                            <div class="fluid">
                                <div class="widget grid12">
                                    <h1 style="margin-left:10px;" class="pt10">Search for Templates</h1>
                                        <div class="formRow">
                                            <div class="grid4"><label>Search By Template Name</label></div>
                                            <div class="grid5"><input style="height:30px !important;" type="text" class="validate[required]" name="template_name" id="template_name" <?php if(!empty($serchedtemplate)) { ?> value="<?php echo $serchedtemplate; ?>" <?php } ?>></div>
                                            <div class="grid1"><input type="submit" class="buttonM bBlue" name="searchtemplate" value="Search Template" /></div>
                                            <div class="clear"></div>
                                        </div>
                                    <?php if (isset($templatemessage)): ?>
                                    <h3 style="margin-left:10px;"><?php echo $templatemessage; ?></h3>
                                    <?php endif; ?>							                    						                    
                                </div>
                            </div>
                        </form>
                        <!-- Search Result Start -->						        
                        <?php if (!empty($template_data)): ?>							        
                        <div class="fluid">
                            <div class="widget grid12">
                                <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                    <thead>
                                        <tr>
                                            <th class="no-border grid4">
                                            <h6>Template Name</h6>
                                            </th>
                                            <th class="no-border grid8">
                                            <h6>Description</h6>
                                            </th>
                                            <th class="no-border">
                                            <h6>Action</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($template_data as $data): ?>												   
                                        <tr class="align-left">
                                            <td class="no-border grid4"><?php echo $data->TemplateName; ?></td>
                                            <td class="no-border grid8"><?php echo $data->Description; ?></td>
                                            <td class="no-border">												         	
                                            <a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>home/share_template/<?php echo $data->TemplateId; ?>" <?php } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php } ?>><input type="button" class="buttonM bRed" name="sharetempalte" value="Share Template" /></a>												         													       </td>
                                        </tr>
                                        <?php endforeach; ?>											  
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>								 
                    <!-- Search Result End -->								 						
                    </div>
                    
                    <!-- Code by Aavid developer ends here -->
                    
                    
                    
                    
                    
                    
                    
                    
                        <?php
                    }
                    elseif ($d_page == 17) {
                        ?>
                    
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
<!--                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-letter-pain-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Letter &#45; Pain Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a href="<?php echo base_url(); ?>output/pre-call-email-pain-focus" target="_blank" title="Download" >Pre&#45;Call Email &#45; Pain Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/call-script-focus-pain" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download">Call Script &#45; Pain Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-pain-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Pain Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-voicemail-pain-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Post&#45;Voicemail Email &#45; Pain Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download">Objections Map</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>-->
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
<!--                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-letter-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Letter &#45; Value Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Pre&#45;Call Email &#45; Value Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a href="<?php echo base_url(); ?>output/voicemail-value-focus" target="_blank" title="Download" >Voicemail Script &#45; Value Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/post-voicemail-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Post&#45;Voicemail Email &#45; Value Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                       <li style="list-style: none;"><h1 class="pt10"><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download">Objections Map</a></h1></li> 
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    
                        
                                
                                
                                
                       <div class="main-wrapper">
                        <!-- Main content -->                        
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
<!--                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/sales-letter-name-drop-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Sales Letter &#45; Name Drop Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/voicemail-name-drop-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Voicemail Script &#45; Name Drop Focus</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"></li>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper" style="margin-left: 7%;">                            
                            <div class="widget fluid">
                                <div class="grid12">
                                    <div class="body">
                                        <li style="list-style: none;"><h1 class="pt10"><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download">Objections Map</a></h1></li>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>         
                                  
                                
                    <?php
                    }
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
            <!-- Main content ends --><?php $this->load->view('common/footer'); ?>
