<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>
    .pt10 a {color:black;}
    .align-center{text-align: center;}
    .main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}
    .main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}
    /*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/
</style>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>	    <!-- Secondary nav -->
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>
<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">
<?php //$this->load->view('common/progress_bar');?><!-- Breadcrumbs line --><?php $this->load->view('common/empty_nav'); ?>
<div class="main-wrapper">
    <!-- Main content -->
    <div class="wrapper">
        <div class="widget fluid">
            <div class="grid12">
                <div class="body">
                    <h1 class="pt10"><a href="<?php echo base_url(); ?>output/sales-letter-value-focus" target="_blank" title="Download" >Sales Letter &#45; Value Focus</a></h1>
                    <p>A physical letter to send to a prospect that you have not met with when trying to get an appointment. This letter focuses on the value that you offer.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="widget fluid">
            <div class="grid12">
                <div class="body">
                    <h1 class="pt10"><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?> target="_blank" title="Download" >Pre&#45;Call Email &#45; Value Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                    <p>This is a brief email that is designed to be sent to a prospect before calling. The email focuses on the value that you offer.</p>
                    <!-- <ul class="middleFree" style="text-align:left;"><span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus/download" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> title="Download"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a <?php if ($is_paid) { ?> href="<?php echo base_url(); ?>output/pre-call-email-value-focus" class="bBlue" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1 bBlue" <?php } ?> target="_blank" title="Download" ><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li></ul> -->
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="widget fluid">
            <div class="grid12">
                <div class="body">
                    <h1 class="pt10"><a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>output/voicemail-value-focus" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?>target="_blank" title="Download" >Voicemail Script &#45; Value Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                    <p>A voicemail script that focuses on your value to get the prospect's attention.</p>
                </div>
            </div>
        </div>
    </div>
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
    <div class="wrapper">
        <div class="widget fluid">
            <div class="grid12">
                <div class="body">
                    <h1 class="pt10"><a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>output/indirect-cold-call-script" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?>target="_blank" title="Download">Call Script &#45; Qualify Focus</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                    <p>This is a script that can be used while cold calling prospects that you have never spoken to before and they do not know who you are. This script uses an indirect approach that utilizes questions to get more a of conversation going and gather information prior to going for a close.</p>
                    <!-- <ul class="middleFree" style="text-align:left;"><span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/indirect-cold-call-script/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/indirect-cold-call-script" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li></ul> -->
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="widget fluid">
            <div class="grid12">
                <div class="body">
                    <h1 class="pt10"><a <?php if ($is_paid) { ?>href="<?php echo base_url(); ?>output/objections-map" <?php } else { ?> id="32" data-icon="&#xe090;" class="dialog_open_pro fs1" <?php } ?>target="_blank" title="Download">Objections Map</a><?php if(!$is_paid){ ?> <span style="font-size:.6em;vertical-align:top;"> (Only on Pro)</span> <?php } ?></h1>
                    <p>This is a list of objections that you are likely to face while cold calling and there are responses that you can use to get around the objections to keep conversations going.</p>
                    <!-- <ul class="middleFree" style="text-align:left;">										<span class="note span-html">The HTML version allows you to edit your answers.</span>								            <li><a href="<?php echo base_url(); ?>output/objections-map/download" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>&nbsp;Download&nbsp;</span></a></li>								            <li><a href="<?php echo base_url(); ?>output/objections-map" target="_blank" title="Download" class="bBlue"><span class="iconb" data-icon="&#xe02f;"></span><span>HTML View</span></a></li></ul> -->
                </div>
            </div>
        </div>
    </div>    
</div>
</div>
            <!-- Main content ends --><?php $this->load->view('common/footer'); ?>