<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<!-- Sidebar begins -->
<div id="sidebar">
    <?php $this->load->view('common/left_navigation'); ?>
	<!-- Secondary nav -->    
    <div class="secNav">
        <div class="clear"></div>
    </div>
</div>

<!-- Sidebar ends --> <!-- Content begins -->
<div id="content">
	<!-- Breadcrumbs line -->
    <?php  		
	$this->load->view('common/crm_nav');
	?>	
	<!-- Main content -->
    <div class="main-wrapper">    	
    	
    	<div class="objections">
    		<div style="padding-bottom:25px;">
			<?php  		
				$this->load->view('interview/staffing_drop_menu');
			?></div><br clear="all" />
            <table style='background: none repeat scroll 0 0 #E6E6E6; width:95%;margin:4px 30px;' class='tDefault'>
                <tbody>
                    <tr >
						<th width='79%' style='text-align:center;padding:10px 0px;' class='no-border'>Title</th>
						<th colspan='3' width='21%' style='text-align:center;padding:10px 0px;' class='no-border'>Version</th>
					</tr>
                    <?php foreach($all_templates as $vtemp) {
							if(!isset($vtemp->temp_id)) continue;	
							if(isset($temphides[$vtemp->temp_id])) continue;
							if($vtemp->temp_id=="74" || $vtemp->temp_id=="75") continue;
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
                </tbody>
            </table>                        

        </div>	
        
	</div>
    <!-- Main content ends -->
</div>
<iframe id="DownloadTemplate" src="<?php echo base_url(); ?>crm/downdocx" style="visibility: hidden;"></iframe>
<script type="text/javascript">
    //download template
    function download_template(dis) {
        $("#DownloadTemplate").attr("src",$(dis).attr("href"));
        return false;
    }
</script>
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>