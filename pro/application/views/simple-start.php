<?php $this->load->view('common/meta'); ?>  
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/</style>
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
    $this->load->view('common/trash_nav');
    ?>  
    <!-- Start Search for a Team Member Form -->                            
    <!-- Main content -->
    <!-- Start Existing Team Members Conection -->                              
            <div class="wrapper">
            	 <div style="text-align: right;">
                    <a href="#" class="buttonM bRed dialog_help">Help Video</a>
                </div>
                <!-- <div style="margin-top:10px;">                                     
                <a <?php // if ($is_paid) { ?>              href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>                                 </div> -->                                  
                <?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>                                       
                    <div class="fluid">
                        <div class="grid12 gssbox">
                            <div class="widget trash">
                                <form method="post" onSubmit="return save_simple_campaign(0);" id="frmSSC">
                                <div id="page0">
                                    <table cellpadding="0" cellspacing="0"  class="contact-edit">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" align="left">
                                                    <b class="page0-info">The Sales Pitch Builder will take some time to fully go through. We don't want that to slow down your testing or adoption of SalesScripter so we have created this "Simple Start" option where you only have to answer 3 questions and we will use that to fill up enough of your scripts and templates you that you can view and start using the Sales Playbook.</b><br /><br />
                                                </th>                        
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <br><input type="button" class="buttonM bBlue btn" onClick="ssbox();" value="Yes, Use Simple Start" /> 
                                                    <?php /*?><a href="<?php echo base_url();?>home/campaign-coordinates" class="buttonM bGreen btn">No, Use Full Sales Pitch Builder</a><?php */?>
                                                    <a href="<?php echo base_url();?>folder/product-profile" class="buttonM bGreen btn">No, Use Full Sales Pitch Builder</a>
                                                </td>                        
                                            </tr>
                                        </tbody>
                                    </table>    
                                </div>
                                  

                                <div id="page1" class="sscbox">
                                    
                                        <input type="hidden" name="action" value="sst">
                                    <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" align="center">
                                                    <b class="heading">Question 1 - Enter 3 benefits that your product offers.</b><br /><br />
                                                </th>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Our product helps to:</b></td>
                                                <td class="two">
                                                    <textarea class="sval" name="value[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Our product helps to:</b></td>
                                                <td class="two">
                                                    <textarea class="sval" name="value[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Our product helps to:</b></td>
                                                <td class="two">
                                                    <textarea class="sval" name="value[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <br /><br /><b>Hint: If your customer uses your product, is there anything that ends up working better, faster, cheaper, etc.?</b><br /><br />
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td align="center" colspan="2">
                                                    <input type="submit" class="buttonM bBlue btn" value="Next" onClick="return save_simple_campaign(1);" /></td>       
                                            </tr>
                                        </tbody>
                                    </table>    
                                
                                </div>

                                <div id="page2" class="sscbox">
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" align="center">
                                                    <b class="heading">Question 2: Enter 3 common problems or pain points that your product helps your customers to resolve, minimize, or avoid.</b><br /><br />
                                                </th>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Common Problem 1</b></td>
                                                <td class="two">
                                                    <textarea class="pval" name="pain[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Common Problem 2</b></td>
                                                <td class="two">
                                                    <textarea class="pval" name="pain[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Common Problem 3</b></td>
                                                <td class="two">
                                                    <textarea class="pval" name="pain[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <br /><br /><b>Hint: Each benefit that you offer usually fixes some sort of problem or pain point.</b><br /><br />
                                                    <ul class="page1ans"></ul>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td align="center" colspan="2">
                                                    <br /><br /><input type="submit" class="buttonM bBlue btn" value="Next" onClick="return save_simple_campaign(2);" /></td>       
                                            </tr>
                                        </tbody>
                                    </table>    
                                
                                </div>

                                <div id="page3" class="sscbox">
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
                                        <tbody>
                                            <tr>
                                                <th colspan="2" align="center">
                                                    <b class="heading">Question 3: Enter 3 questions that you should ask a prospect to see if they might need what you sell.</b><br /><br />
                                                </th>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Probing Question 1</b></td>
                                                <td class="two">
                                                    <textarea class="qval" name="quest[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Probing Question 2</b></td>
                                                <td class="two">
                                                    <textarea class="qval" name="quest[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td class="one"><b>Probing Question 3</b></td>
                                                <td class="two">
                                                    <textarea class="qval" name="quest[]"></textarea>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <br /><br /><b>Hint: For each problem that you fix, there is usually a question that you can ask to see it is a concern for your prospect.</b><br /><br />
                                                    <ul class="page2ans"></ul>
                                                </td>                        
                                            </tr>
                                            <tr>
                                                <td align="center" colspan="2">
                                                    <br /><br /><input type="submit" class="buttonM bBlue btn" value="Submit" onClick="return save_simple_campaign(3);" /></td>       
                                            </tr>
                                        </tbody>
                                    </table>    
                                
                                </div>  
                                </form>                
                            </div>
                        </div>                      
                    </div>
                <?php // endif; ?>                          
            </div>
            <!-- End Existing Team Members Conection -->
    <!-- End Search for a Team Member Form -->      
    </div>
    <!-- Main content ends -->
    <script type="text/javascript">
    function ssbox()
    {
        $("#page0").hide();
        $("#page1").show();
    }

    //save campaign
    function save_simple_campaign(ps){
        var er='';
        var bnf=0;
        var pageul='';
        if(ps==0 || ps==1) {
            $("#frmSSC .sval").each(function(){                
                if($(this).val()=="") {
                    //er +="Benefit "+bnf+" required\n";
                    bnf++;
                }
                pageul += '<li>'+$(this).val()+'</li>';
            });
            if(bnf) {
                $(".sscbox").hide();
                $("#page1").show();
                alert("One of benefit required");
                return false;
            }
            if(ps==1) {
                $(".sscbox").hide();
                $("#page2").show();
                $(".page1ans").html(pageul);
                return false;
            }
        }
        bnf=0;
        if(ps==0 || ps==2) {
            $("#frmSSC .pval").each(function(){
                bnf++;
                if($(this).val()=="") er +="Common Problem "+bnf+" required\n";
                pageul += '<li>'+$(this).val()+'</li>';
            });
            if(er!="") {
                $(".sscbox").hide();
                $("#page2").show();
                alert(er);
                return false;
            }
            if(ps==2) {
                $(".sscbox").hide();
                $("#page3").show();
                $(".page2ans").html(pageul);
                return false;
            }
        }
        bnf=0;
        if(ps==0 || ps==3) {
            $("#frmSSC .qval").each(function(){
                bnf++;
                if($(this).val()=="") er +="Probing Question "+bnf+" required\n";
            });
            if(er!="") {
                $(".sscbox").hide();
                $("#page3").show();
                alert(er);
                return false;
            }
        }
        return true;
    }
	var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/4DW-nVf8TZ8" frameborder="0" allowfullscreen></iframe>';
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
<?php $this->load->view('common/footer'); ?>
