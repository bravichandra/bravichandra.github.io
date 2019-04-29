<!-- Main content -->
<?php
  $find_product = $this->campaign->getAllProduct();
  $find_all_campaign = $this->campaign->get_drop_campaign();
?>				    	
<div class="wrapper">

	<?php $msg = $this->session->flashdata('session_msg'); ?>
	<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?> 
        
	<div class="fluid">
    	
	 <div class="grid12  map-box" style="width:100%; margin-left:0%;">
     	<div class="myfolder" align="center" style="margin-left:0%;">
		<div class="myfloder_box">
        	<div class="box">
            	<div class="bxtitle">
	            	<h3>Prebuilt Campaigns</h3>                
                </div>
                <div class="bxlink">
            		<a href="<?php echo base_url(); ?>folder/prebuilt-campaigns"  class="buttonM bRed">Go Here</a>
                    
                    <a href="#" onclick="help_video('-OexXFgg_KA');"  class="buttonM bRed dialog_help">Help Video</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow2.png'/>
            </div>
            <div class="box">
            	 <div class="bxtitle">
                 	   <h3>Simple Start</h3>
                 </div>
                 <div class="bxlink">
                 	  <a href="<?php echo base_url(); ?>home/simplestart"  class="buttonM bRed">Go Here</a>
                      
                       <a href="#" onclick="help_video('4DW-nVf8TZ8');"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
            </div>
            <div class="boxar">
            	 <img src='<?php echo base_url(); ?>images/fold-arrow2.png' />
            </div>
            <div class="box">
            	<div class="bxtitle">
	            	<h3>Create Product Profile</h3>                
                </div>
                <div class="bxlink">
            		<a href="<?php echo base_url(); ?>folder/product-profile"  class="buttonM bRed">Go Here</a>
                    
                    <a href="#" onclick="help_video('zFHKECbSjkU');"  class="buttonM bRed dialog_help">Help Video</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow2.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Sales Pitch Campaign</h3></div>
                <div class="bxlink">                
            		 <a href="<?php echo base_url(); ?>folder/campaigns"  class="buttonM bRed">Go Here</a>
                     
                     <a href="#" onclick="help_video('op8PdhNAbGk');"  class="buttonM bRed dialog_help">Help Video</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow2.png'/>
            </div>
        	
            
            <div class="box">
            	<div class="bxtitle bxtitle1"><h3>Create a Company Profile</h3></div>
                <div class="bxlink">                
            		 <a href="<?php echo base_url(); ?>folder/company-profiles"  class="buttonM bRed">Go Here</a>
                     
                     <a href="#" onclick="help_video('Z3f8E7RubxA');"  class="buttonM bRed dialog_help">Help Video</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow2.png'/>
            </div>
            <div class="box">
            	<div class="bxtitle"><h3>Create a Name Drop</h3></div>
                <div class="bxlink">
            		 <a href="<?php echo base_url(); ?>folder/name-drop-examples"  class="buttonM bRed">Go Here</a>
                     
                     <a href="#" onclick="help_video('ec2fndme0B8');"  class="buttonM bRed dialog_help">Help Video</a>
                </div>
            </div>
            <div class="boxar">
            	 <img src='<?php echo base_url(); ?>images/fold-arrow2.png' />
            </div>
            <div class="box">
            	 <div class="bxtitle"><h3>Response<br /> Builder</h3></div>
                 <div class="bxlink">
                 	   <a href="<?php echo base_url(); ?>step/objection"  class="buttonM bRed">Go Here</a>
                       
                       <a href="#" onclick="help_video('NSjpAc0a-x4');"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
            </div>
            <div class="boxar">
            	 <img src='<?php echo base_url(); ?>images/fold-arrow2.png' />
            </div>
            <div class="box">
            	 <div class="bxtitle"><h3>Question<br /> Builder</h3></div>
                 <div class="bxlink">
                 	   <a href="<?php echo base_url(); ?>home/sales_question"  class="buttonM bRed">Go Here</a>
                       
                       <a href="#" onclick="help_video('yVz6iR27PkY');"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
            </div>
        </div>  
        <div class="myfloder_box strip">
        	 <div class="box1">
             	  <div class="topstrip"></div>
                  <div class="top-arrow"><img src='<?php echo base_url(); ?>images/fold-arrow.png'/></div>
             </div>
             <div class="box2"></div>
             <div class="box3"></div>
        </div>
        <div class="myfloder_box secondbox">
        	<div class="box">
            	<div class="bxtitle">
	            	<h3>Set Campaign Focus</h3>                
                </div>
                <div class="bxlink">
            		<a href="<?php echo base_url(); ?>campaign/startcampaigncreate"  class="buttonM bRed">Go Here</a>
                    
                    <a href="#" onclick="help_video('cp6iccrOIgE');"  class="buttonM bRed dialog_help">Help Video</a>
                </div>
            </div>
            <div class="boxar">
            	<img src='<?php echo base_url(); ?>images/fold-arrow2.png'/>
            </div>
            <div class="box">
            	 <div class="bxtitle">
                 	  <h3>Identify Benefits</h3>
                 </div>
                 <div class="bxlink">
                 	  <a href="<?php echo base_url(); ?>step/value"  class="buttonM bRed">Go Here</a>
                      
                      <a href="#" onclick="help_video('pVm0Xurd2YE');"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
            </div>
            <div class="boxar">
            	 <img src='<?php echo base_url(); ?>images/fold-arrow2.png' />
            </div>
            <div class="box">
            	 <div class="bxtitle">
                 	  <h3>Identify Pain Points</h3>
                 </div>
                 <div class="bxlink">
                 	  <a href="<?php echo base_url(); ?>step/pain"  class="buttonM bRed">Go Here</a>
                      
                       <a href="#" onclick="help_video('BI6OffmiiDE');"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
            </div>
            <div class="boxar">
            	 <img src='<?php echo base_url(); ?>images/fold-arrow2.png' />
            </div>
            <div class="box">
            	 <div class="bxtitle">
                 	  <h3>Compose Probing Questions</h3>
                 </div>
                 <div class="bxlink">
                 	  <a href="<?php echo base_url(); ?>step/qualifying"  class="buttonM bRed">Go Here</a>
                      
                      <a href="#" onclick="help_video('IaxnAdzR63w');"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
            </div>
            <div class="boxar">
            	 <img src='<?php echo base_url(); ?>images/fold-arrow2.png' />
            </div>
            <div class="box">
            	 <div class="bxtitle">
                 	  <h3>Identify Close Option</h3>
                 </div>
                 <div class="bxlink">
                 	  <a href="<?php echo base_url(); ?>step/ideal-sales-process"  class="buttonM bRed">Go Here</a>
                      
                      <a href="#" onclick="help_video('4qRQla6puB0')"  class="buttonM bRed dialog_help">Help Video</a>
                 </div>
             </div>
         </div>
		</div>
	</div>
	</div>
	<br/>
	
</div>
<style type="text/css">
		.ui-dialog
		{
			position:fixed;
			top:200;
		}
</style>
<script type="text/javascript">
	//var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/AswcPX5DyuE?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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
		
		/* Invitation Dialog Link
		$('.dialog_help').click(function (e) {
			 
			 var vtitle = $('.dialog_help').data('vtitle'); //getter
			 
			 alert(vtitle);
			 
			 $('.video').html(iframe);
			 $('.help_dialog').dialog('open');
			 
			return false;
		});*/
		
		$('.ui-icon-closethick').click(function (e) {
			 $('.video').html('');
			  $('.help_dialog').dialog('close');
			return false;
		});

	});
	
	function help_video(video)
	{
		var iframe = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'+video+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
		//alert(iframe);
		$('.video').html(iframe);
		$('.help_dialog').dialog('open');		 
		return false;
	}
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
    <!-- Main content ends -->
</div>