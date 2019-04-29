<?php echo $this->load->view('common/meta');?>
<?php echo $this->load->view('common/header');?>
<!-- Sidebar begins -->

<div id="sidebar">
	<?php echo $this->load->view('common/left_navigation');?>
    <!-- Secondary nav -->
    <div class="secNav">    
    	<div class="clear"></div>
   </div>
</div>
<style type="text/css">
		#breadcrumbs {
    display: none;
}
</style>
<!-- Sidebar ends -->
<!-- Content begins -->
<div id="content">
    <!-- Breadcrumbs line -->
    <?php  echo $this->load->view('common/campaign_nav'); 
		/*$progress_data = json_decode($this->home->get_progress_data($campaign_info->campaign_id));
		$boxes = array();
		foreach($progress_data as $key => $value){
			if($key=='workflow' && $value > 0) $boxes[] = 'value';
			else if($key=='value' && $value > 0) $boxes[] = 'pain';
			else if($key=='pain' && $value > 0) $boxes[] = 'qualify';
			else if($key=='qualify' && $value > 0) $boxes[] = 'close';
		}*/?>
    <!-- Main content -->
    <div class="wrapper">  
    	<div class="fluid">
            	<div class="grid12" style="width:100%; margin-left:0%;">
                	<?php /*?><div class="myfolder" align="center" style="margin-left:0%;">
						<div class="myfloder_box">
                    	<div class="box">
                            <div class="bxtitle"><h3>Set Campaign Focus</h3></div>
                            <div class="bxlink">                
                            <a href="<?php echo base_url(); ?>campaign/startcampaigncreate" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php if(in_array('value',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box">
                            <div class="bxtitle">
                                <h3>Identify Benefits</h3>                
                            </div>
                            <div class="bxlink">
                                <a href="<?php echo base_url(); ?>step/value" class="buttonM bRed">Go Here</a>
                            </div>
                        </div>
                        <?php } if(in_array('pain',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>                        
                        <div class="box">
                            <div class="bxtitle">
                                <h3>Identify Pain Points</h3>                
                            </div>
                            <div class="bxlink">
                                <a href="<?php echo base_url(); ?>step/pain" class="buttonM bRed">Go Here</a>
                            </div>
                        </div>
                        <?php } if(in_array('qualify',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        
                        <div class="box">
                            <div class="bxtitle"><h3>Compose Probing Questions</h3></div>
                            <div class="bxlink">
                            <a href="<?php echo base_url(); ?>step/qualifying" class="buttonM bRed">Go Here</a></div>
                        </div>
                        <?php } if(in_array('close',$boxes)!==FALSE) {?>
                        <div class="boxar">
                            <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                        </div>
                        <div class="box active">
                            <div class="bxtitle bxtitle1"><h3>Identify Close Option</h3></div>
                           <div class="bxlink"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
                        </div>
                        <?php }?>
                    </div>
					</div>
					<div class="myfloder_box1 myfloder_box5 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div><br clear="all" /><?php */?>
                    <div class="quatabs" style="float:left; width:85%;">
                        <div class="first">
                            <a href="<?php echo base_url(); ?>campaign/startcampaigncreate" rel="box1">
                                Campaign Focus
                            </a>
                        </div>
                        <div class="second">
                            <a href="<?php echo base_url(); ?>step/value" rel="box2">
                                Benefits
                            </a>
                        </div>
                        <div>
                            <a href="<?php echo base_url(); ?>step/pain" rel="box3">
                                Pain Points
        
                            </a>
                        </div>
                        <div>
                            <a href="<?php echo base_url(); ?>step/qualifying" rel="box4">
                                Questions
                            </a>
                        </div>
                        <div  class="active">
                            <a href="<?php echo base_url(); ?>step/ideal-sales-process" rel="box5">
                                Close
                            </a>
                        </div>
                    </div><div class="bxlink" style="float:right;"><a href="#" class="buttonM bRed dialog_help" >Help Video</a></div><br clear="all" />
                </div>
            </div>
    	<input type="hidden" id="getanswer" value="0" />
        <div id="AnsBlock11" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					$ansArr = array('c1'=>'c1','c2'=>'c2','c3'=>'c3');
					if($spclose1)
                    foreach ($spclose1  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock21" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					if($spclose2)
                    foreach ($spclose2  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock31" style="display:none;">
            <div class="popupbox uapboxyr" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Reuse one of your past answers by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					if($spclose3)
                    foreach ($spclose3  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock12" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					$valtemps = array();
					$ansArr = array('c1'=>'c1','c2'=>'c2','c3'=>'c3');
					if($templateuser_spclose1)
                    foreach ($templateuser_spclose1  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock22" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					if($templateuser_spclose2)
                    foreach ($templateuser_spclose2  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>
        <div id="AnsBlock32" style="display:none;">
            <div class="popupbox uapboxor" id="NNNNNNNN">
                <div class="uapboxyr_box1">
                    <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                    <div class="abox2"><a href="javascript:void(0);" onClick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                </div>
                <div class="uapboxyr_box2 boldWeight">
                	<span></span> :
                </div>
                <div class="uapboxyr_box3">
                <?php
					if($templateuser_spclose3)
                    foreach ($templateuser_spclose3  as $ansval) {
                        if(!empty($ansval->value)) {
							if(in_array($ansval->value,$valtemps)!=false) continue;
							echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',1)" id="anchor1_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
							$valtemps[]=$ansval->value;
						}	
                    }
					unset($valtemps);
                ?>
                </div>
            </div>
        </div>   
       <form id="validate" action="<?php echo current_url();?>" method="post">
		<?php  
			// var_dump($sale_process_close3); 
		?>
    	<div class="widget tableTabs">
    		<!-- <div class="whead"><h6>First Meeting</h6><div class="clear"></div></div> -->
            <div class="tab_container">
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <tbody>
                            <tr>
                                <td class="no-border" colspan="3" width="70%" id="ansListh<?php echo $ansArr['c1'];?>">If you to try to schedule a meeting with a prospect for this campaign, what type of meeting would you try to schedule? <br /><br />
Examples: a brief 15 to 20 minute phone call, a meeting, an in-person meeting, a quick conversation, an online demo, etc.</td>
                                
                                <td class="no-border" style="padding-top: 30px;padding-bottom: 30px;">
									<div class="grid5">
	                                    <div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onClick="set_answer_id('<?php echo $ansArr['c1'];?>',1,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onClick="set_answer_id('<?php echo $ansArr['c1'];?>',1,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansList<?php echo $ansArr['c1'];?>"></div>
                                        </div>
                                    <textarea class="validate[required] dynamicTxt gans<?php echo $ansArr['c1'];?>" style="width:500px;" id="C_1" name="tbl[ccd][<?php echo $sale_process_close1->cam_com_id ?>][sale_process_close1]" cols="" rows=""><?php echo (isset($sale_process_close1->value) ? $sale_process_close1->value : 'a brief 15 to 20 minute meeting');?></textarea>
                                     
					  
									</div>
									</div>
								</td>
                                <?php /*?><td class="no-border" ><div class="grid5"><div id="29" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td><?php */?>
                            </tr>
                            <tr>
                                <td class="no-border" colspan="3" style="vertical-align:top" id="ansListh<?php echo $ansArr['c2'];?>"><br />When you meet with the prospect in
									<span class="dynamicTxt_C_1 TextColor"><?php echo (isset($sale_process_close1->value) ? $sale_process_close1->value : NULL);?></span>
									describe what will take place
									<div align="right">
										<span class="boldWeight" > Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
										In 
                                        <span class="dynamicTxt_C_1 TextColor"><?php echo (isset($sale_process_close1->value) ? $sale_process_close1->value : NULL);?></span>  we will <!-- where we can  <span class="dynamicTxt_C_2 TextColor"><?php echo (isset($sale_process_close2->value) ? $sale_process_close2->value : 'discuss your goals and challenges and share any value and insight that we have to offer');?></span>. -->
                                    </div>
									
								</td>
                                
								<!-- <td class="no-border" style="width:30%" ></td>
                                <td class="no-border" style="width:10%;"></td> -->
                                
								<td class="no-border" style="padding-top: 30px;padding-bottom: 30px;"><div class="grid5">
                                		<div class="answerbox">
                                            <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onClick="set_answer_id('<?php echo $ansArr['c2'];?>',2,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onClick="set_answer_id('<?php echo $ansArr['c2'];?>',2,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                            <div id="ansList<?php echo $ansArr['c2'];?>"></div>
                                        </div>
									<textarea class="validate[required] dynamicTxt gans<?php echo $ansArr['c2'];?>" style="width:500px;" id="C_2" name="tbl[ccd][<?php echo $sale_process_close2->cam_com_id ?>][sale_process_close2]" cols="" rows=""><?php echo (isset($sale_process_close2->value) ? $sale_process_close2->value : 'discuss your goals and challenges and share any value and insight that we have to offer');?></textarea>
                                     
				  
                                    </div>
                                    <!-- <div align="center" class="TextColorH">Answer Checker</div> -->
                                    
                                    </div>
								</td>
                                <?php /*?><td class="no-border" ><div class="grid5"><div id="30" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td><?php */?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>
        </div>
        <?php /*?><h3 style="margin-top:30px;">Step 2 : Identify your backup plan</h3>
		<div class="widget tableTabs">
       		<!-- <div class="whead"><h6>Secondary Option</h6><div class="clear"></div></div> -->
            <div class="tab_container">
                <div id="ttab1" class="tab_content">
                    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                        <tbody>
                            <tr>
                                <td class="no-border" colspan="3" width="70%" id="ansListh<?php echo $ansArr['c3'];?>">If you are not able to get the prospect to agree to
									<span class="dynamicTxt_C_1 TextColor"><?php echo (isset($sale_process_close1->value) ? $sale_process_close1->value : NULL);?></span>
									the next best option of to go for is
								</td>
                                <!-- <td class="no-border" style="width:30%" ></td>
                                <td class="no-border">the next best option of to go for is </td> -->
                                <td class="no-border"><div class="grid5">
                                	<div class="answerbox">
                                        <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('<?php echo $ansArr['c3'];?>',3,1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                        <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('<?php echo $ansArr['c3'];?>',3,2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                        <div id="ansList<?php echo $ansArr['c3'];?>"></div>
                                    </div>
                                <textarea class="validate[required] dynamicTxt gans<?php echo $ansArr['c3'];?>" style="width:500px;" id="C_5" name="tbl[ccd][<?php echo $sale_process_close3->cam_com_id ?>][sale_process_close3]" cols="" rows=""><?php echo (isset($sale_process_close3->value) ? $sale_process_close3->value : 'get email address and send email with information');?></textarea>                                 
			   
			                    </div></td>
                                <td class="no-border" ><div class="grid5"><div id="31" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div></div></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>	
            <div class="clear"></div>		 
        </div><?php */?>
        <div class="fluid" style="margin-top:15px;">
          	<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="submit" value="Save" />
			<input type="submit" class="buttonM bRed" name="submit" value="Done" />
          	<input type="hidden" name="step" value="sales_process">
        </div>
        </form>	
        </div>
        </div>
    </div>
    <!-- Main content ends -->  
</div>
<!-- Content ends -->
<script type="text/javascript">
	//set Answer
	function set_answer(gans,uans) {
		$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_"+gans).html());
		$("#pastanswers").hide();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
	//set Answer id
	function set_answer_id(gans,sno,uans,dis) {     
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
		$("#pastanswers").remove();
		$("#getanswer").val(gans);
		var qheader = $("#ansListh"+gans).html();
		var AnList= $("#AnsBlock"+sno+''+uans).html().replace("NNNNNNNN","pastanswers");
		$("#ansList"+gans).prepend(AnList);
		$("#pastanswers").width($(dis).parent().parent().width()-3);
		$("#pastanswers .uapboxyr_box2 span").html(qheader);
		$(dis).addClass('btactive');
		$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
		$(".btactive .ansdown").hide();
	}
	//Hide answer popup box
	function hide_answer() {
		$('#pastanswers').remove();
		$('.ansclose').remove();
		$(".btactive .ansdown").show();
		$(".btactive").removeClass('btactive');
	}
</script>
<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/4qRQla6puB0?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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

<?php $this->load->view('common/footer');?>