<?php echo $this->load->view('common/meta');?>	
<?php echo $this->load->view('common/header');?>
<style type="text/css">.button {color:red;}.delete {font-size: 20px;}</style>
<!-- Sidebar begins -->
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
	<!-- Breadcrumbs line -->	   
	<?php echo $this->load->view('common/camp_coord_nav');?> 
		<h3 align="center" style="margin-bottom: 9px; margin-top: -19px;">
			<!-- Main content -->    
			<div class="wrapper" style="color: #000000;text-align: left;font-size: 15px;"><br clear="all" />  
            	<div class="fluid">
                    <div class="grid12" style="width:100%; margin-left:0%;">
                        <div class="myfolder" align="center" style="margin-left:0%;">
						<div class="myfloder_box">
                            <div class="box active">
                                <div class="bxtitle bxtitle1">
                                    <h3>Create Campaign Coordinates</h3></div>
                                     <div class="bxlink">        <a href="#" class="buttonM bRed dialog_help" >Help Video</a></div>
                                </div>
                            <div class="boxar">
                                <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                            </div>
                            <div class="box">
                                <div class="bxtitle"><h3>Create a Sales Pitch Campaign</h3></div>
                                <div class="bxlink">                
                                <a href="<?php echo base_url(); ?>folder/campaigns" class="buttonM bRed">Go Here</a></div>
                            </div>
                            <div class="boxar">
                                <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                            </div>
                            <div class="box">
                                <div class="bxtitle">
                                    <h3>Create Product Profile</h3>                
                                </div>
                                <div class="bxlink">
                                    <a href="<?php echo base_url(); ?>folder/product-profile" class="buttonM bRed">Go Here</a>
                                </div>
                            </div>
                            <div class="boxar">
                                <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                            </div>
                            
                            <div class="box">
                                <div class="bxtitle"><h3>Create a Company Profile</h3></div>
                                <div class="bxlink">
                                <a href="<?php echo base_url(); ?>folder/company-profiles" class="buttonM bRed">Go Here</a></div>
                            </div>
                            <div class="boxar">
                                <img src='<?php echo base_url(); ?>images/fold-arrow.png'/>
                            </div>
                            <div class="box">
                                <div class="bxtitle"><h3>Create a Name Drop</h3></div>
                                <div class="bxlink">
                                <a href="<?php echo base_url(); ?>folder/name-drop-examples" class="buttonM bRed">Go Here</a></div>
                            </div>
                        </div>
                	</div>
					</div>
							<div class="myfloder_box1 bxlink"> 
							 <div><img src='<?php echo base_url(); ?>images/fold-arrow1.jpg'/> </div>              
                                <b>You are Here</b></div>
                </div>          	
				<?php if ($msg): ?><br />
                    <h3 style="color:#CC3300 !important;"><?php echo $msg; ?></h3>
                <?php endif; ?> 
                
                	<form action="<?php echo current_url();?>" method="post" class="formRow" style="padding:0px">
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Products</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										<td class="no-border" style="width:70%;font-weight: initial;" id="ansListPQ">
                                        	<b>Brainstorm a list of products and services</b><br /><br />
                                            Enter some of the products , services, groups of products or services, and features that you sell. <br /><br />
											(Enter at least one)
										</td>
										<td class="no-border">
                                        	<div id="box_products">
                                            <?php $save=0;if ($product_profiles): ?>
												<?php foreach ($product_profiles as $product):$save=1; ?>
                                                	<div class="grid5" style="margin-bottom: 4px;">
                                                    	<input type="text" class="validate[required] txtinput" name="txt_product[]" value="<?php echo $product->product_name; ?>" />
                                                        <?php /*?><textarea class="validate[required] txtinput" style="width:500px;" name="txt_product[]" cols="" rows=""><?php echo $product->product_name; ?></textarea><?php */?>
                                                        <input type="hidden" name="prod_id[]" value="<?php echo $product->product_id; ?>" />
                                                    </div>                                     
												<?php endforeach; ?>					                           
                                            <?php endif; ?>
                                            	<?php /*?><textarea class="validate[required] txtinput" style="width:500px;" name="txt_product[]" cols="" rows=""></textarea><?php */?>
                                                <?php /*?><div class="grid5" style="margin-bottom: 4px;">
                                                	<input type="text" class="validate[required] txtinput" style="width:500px;height: 30px;border: 1px solid #cccccc;" name="txt_product[]" value="" />
                                                    <input type="hidden" name="prod_id[]" value="0" />
                                                </div><?php */?>
                                            </div>
                                            <div class="grid5" style="margin-bottom: 4px;">
                                                <div align="center" style="margin-top: 8px;">
                                                	<input type="button" class="buttonM bRed" onclick="add_product(1);" value="Add Another Product" />
                                                </div>
											</div>
										</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Target Prospects</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										<td class="no-border" style="width:70%;font-weight: initial;" id="ansListPD">
                                        	<b>Brainstorm a list of the target prospects</b><br /><br />
                                            Enter some  of the different types or groups of target prospects that you want to  sell to. <br /><br />
                                            You can enter a title, name of a department, type of company, industry description, size of business, description of individual.<br /><br />
                                            Examples:<br /><br />
											VP's of HR<br />
                                            CEOs<br />
                                            manufactures<br />
                                            finance departments<br />
                                            home owners<br />
                                            doctor offices<br />
                                            small businesses<br />
                                            Individuals
										</td>
										<td class="no-border">											 
                                        	<div id="box_prospects">
                                            	<?php if ($target_prospects): ?>
													<?php foreach ($target_prospects as $product):$save=1; ?>
                                                        <?php /*?><div class="grid5" style="margin-bottom: 4px;">
                                                        	<input type="text" class="validate[required] txtinput" name="txt_prospect[]" value="<?php echo $product->tp_text; ?>" />
                                                            <!--<textarea class="validate[required] txtinput" style="width:500px;" name="txt_prospect[]" cols="" rows=""><?php echo $product->tp_text; ?></textarea>-->
                                                            <input type="hidden" name="prospect_id[]" value="<?php echo $product->tp_id; ?>" />
                                                        </div><?php */?>
                                                        <div class="boxtp">
                                                            <div class="grid5" style="margin-bottom: 4px; float:left;width: 90%;">
                                                                <input type="text" class="validate[required] txtinput" name="txt_prospect[]" value="<?php echo $product->tp_text; ?>" />
                                                                <input type="hidden" name="prospect_id[]" value="<?php echo $product->tp_id; ?>" />                                                        	</div>
                                                            <div style="float:left;cursor: pointer;"><span class="ui-icon ui-icon-closethick" onclick="remove_tp(<?php echo $product->tp_id; ?>,this);">X</span></div><div style="clear:both;"></div>    
                                                        </div>
                                                    <?php endforeach; ?>					                           
                                                <?php endif; ?>
                                            	<?php /*?><div class="grid5" style="margin-bottom: 4px;">
                                                    <input type="text" class="validate[required] txtinput" style="width:500px;height: 30px;border: 1px solid #cccccc;" name="txt_prospect[]" value="" />
                                                    <input type="hidden" name="prospect_id[]" value="0" />
                                                </div><?php */?>
                                            </div>
                                            <div class="grid5" style="margin-bottom: 4px;">
                                                <div align="center" style="margin-top: 8px;">
                                                	<input type="button" class="buttonM bRed" onclick="add_product(2);" value="Add Another Prospect" />
                                                </div>
											</div>
										</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>					
                    <div class="fluid" style="margin-top:15px;">
                        <input style="margin-top: -25px; margin-right: 10px; <?php if(!$save) echo 'display:none;';?>" type="submit" class="buttonM bBlue" name="btn_save" id="btn_save" value="Save" />
                        <input type="submit" class="buttonM bRed" name="btn_next" value="Next" />                        
					</div>
					</form>
                <script type="text/javascript">
				function add_product(ptype) {
					var prod_data='';
					if(ptype==1) {
						prod_data = '<div class="grid5" style="margin-bottom: 4px;"><input type="text" class="validate[required] txtinput" name="txt_product[]" value="" /><input type="hidden" name="prod_id[]" value="0" /></div>';
						$("#box_products").append(prod_data);
					} else {
						//prod_data = '<div class="grid5" style="margin-bottom: 4px;"><input type="text" class="validate[required] txtinput" name="txt_prospect[]" value="" /><input type="hidden" name="prospect_id[]" value="0" /></div>';
						prod_data = '<div class="boxtp"><div class="grid5" style="margin-bottom: 4px; float:left;width: 90%;"><input type="text" class="validate[required] txtinput" name="txt_prospect[]" value="" /><input type="hidden" name="prospect_id[]" value="0" /></div><div style="float:left;cursor: pointer;"><span class="ui-icon ui-icon-closethick" onclick="remove_tp(0,this);">X</span></div><div style="clear:both;"></div></div>';
						$("#box_prospects").append(prod_data);
					}
					$("#btn_save").show();
				}
				//set Answer
				function validate(frm) {
					if($(frm).find(".txtinput").val()==''){
						$(frm).find(".txtinput").focus();
						alert("Enter name");
						return false;
					}
					return true;
				}
				//remove target prospect
				function remove_tp(tpid,dis) {
					$(dis).parent().parent().remove();
					if(tpid) {
						$.ajax({
							type : 'POST',
							url : '<?php echo current_url();?>', 
							data : { 'tpid' : tpid, 'action': 'removetp'},
							success : function(data){
								//nothing								
							}
						});
					}
				}
				</script>
			</div>
            </h3>
		</div>
		<script type="text/javascript">
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/xgRBEhTlo18?list=PLoUVJsDQgZII894paX8gfipNdgfKsBkmb" frameborder="0" allowfullscreen></iframe>';
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