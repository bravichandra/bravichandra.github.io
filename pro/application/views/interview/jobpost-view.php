<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<?php //if($deleted_info!='') echo $deleted_info; else echo 'no';?>
<!-- Sidebar begins -->
<style>
.form_123{
padding:20px;
}
.custom_content_tab
{
	float:left;
	width:70%;
}
.info_txt
{
	color:#757575;
	font-size: 12px;
}
.tab_container
{
	padding-bottom:20px;
}
.custom_content_tab tr td
{
	padding-left:10px;
}
.custom_content_tab tr td textarea
{
	width: 60%;
}
.custom_content_tab tr td input
{
	padding: 5px;
	width: 98%;
	border: 1px solid #CCCCCC;
}
.custom_content_tab .title
{
	padding: 4px;
	font-weight:bold;
	font-size: 12px;
	width: 20%;
	padding-left: 5px;
}
.custom_content_table_data
{
	padding: 20px;
}
.filldiv
{margin:2px;
}
.filldiv .box1{float:left;}
.filldiv .box2{float:left;}
.job_font {
font-family:Arial, Helvetica, sans-serif;
font-size:15px;
}
.custom_content_tab ul{
	padding-left: 20px;
    list-style-type: disc;
}
</style>

<div id="sidebar">
	<?php echo $this->load->view('common/left_navigation');?>
    <!-- Secondary nav -->
    <div class="secNav">    
    	<div class="clear"></div>
   </div>
</div>

<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
<?php  		
	$this->load->view('common/crm_nav');
	?>
		
	   <?php //echo "<pre>"; print_r($record); echo "</pre>";?>      
     
    
  <div class="form_123">
  		
        <label><b>Job Title:</b> </label> <label class="job_font"><?php echo $record['job_title']; ?><label>
		<br />
		<label><b>Location:</b> </label> <label class="job_font"><?php echo $record['location']; ?></label><br />
		<label><b>Play Rate:</b> </label> <label class="job_font"><?php echo $record['playrate']; ?></label>
    	<div id="tabs_1234" title="Edit Job Post">
				<?php 	
				$n=0;
				if($section) { 
					foreach($section as $sect) {
					$section=(array)$sect;
					
					$n++;
					?>
					<div class="widget custompro tableTabsdb<?php echo "ets".$section->sect_id; ?>">
                    	<h5 align="right" style="padding-right: 20px;margin-top: 20px;font-size: 20px;"></h5>
                        <div class="tab_container">
                                <table class="custom_content_tab">
                                
                                    <tr>
                                       
                                        <td>                                            
                                          <b><?php echo  $section['title']; ?> </b>
                                        </td>
                                    </tr>
                                 
                                    <tr>
                                       
                                        <td>
                                            <br /><?php echo $section['content'];?>
                                        </td>
                                    </tr>
                                </table>
                        </div>	
                        <div class="clear"></div>
                    </div>
					
					<?php } }?>
					</div>
					</div>

    <!-- Main content ends -->
</div>
<!-- Content ends -->
<?php $this->load->view('common/footer');?>