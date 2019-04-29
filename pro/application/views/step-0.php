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
	<?php echo $this->load->view('common/product_nav');?> 
		<h3 align="center" style="margin-bottom: 9px; margin-top: -19px;">
		<?php echo $this->session->flashdata('session_msg');?></h3>   
			<!-- Main content -->    
			<div class="wrapper">
				<input type="hidden" id="getanswer" value="0" />
                <div id="NameBlock1" style="display:none;">
                    <div class="popupbox uapboxyr" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Reuse one of your past answers by selecting from below</div>
                            <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
							$valtemps = array();
                            if($product_names)
                            foreach ($product_names  as $ansval) {
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
                <div id="DescBlock1" style="display:none;">
                    <div class="popupbox uapboxyr" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Reuse one of your past answers by selecting from below</div>
                            <div class="abox2">
							<a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
							$valtemps = array();
                            if($product_desc)
                            foreach ($product_desc  as $ansval) {
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
                <div id="AnsBlock1" style="display:none;">
                    <div class="popupbox uapboxyr" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Reuse one of your past answers by selecting from below</div>
                            <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
                            if($product_profiles)
                            foreach ($product_profiles  as $ansval) {
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
                <div id="NameBlock2" style="display:none;">
                    <div class="popupbox uapboxor" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                            <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
							$valtemps = array();
                            if($template_product_names)
                            foreach ($template_product_names  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',2)" id="anchor2_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
                <div id="DescBlock2" style="display:none;">
                    <div class="popupbox uapboxor" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                            <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
							$valtemps = array();
                            if($template_product_desc)
                            foreach ($template_product_desc  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',2)" id="anchor2_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
                <div id="AnsBlock2" style="display:none;">
                    <div class="popupbox uapboxor" id="NNNNNNNN">
                        <div class="uapboxyr_box1">
                            <div class="abox1">Use one of the answers from the template library by selecting from below</div>
                            <div class="abox2"><a href="javascript:void(0);" onclick="$('#pastanswers').hide();$('.upaborder').removeClass('upaborder');"><span class="ui-icon ui-icon-closethick"></span></a></div><br clear="all" />
                        </div>
                        <div class="uapboxyr_box2 boldWeight">
                            <span class="TextColor"></span> :
                        </div>
                        <div class="uapboxyr_box3">
                        <?php
                            if($template_product_profiles)
                            foreach ($template_product_profiles  as $ansval) {
                                if(!empty($ansval->value)) {
									if(in_array($ansval->value,$valtemps)!=false) continue;
									echo '<div><a href="javascript:void(0);" onclick="set_answer('.$ansval->answid.',2)" id="anchor2_'.$ansval->answid.'">'.$ansval->value.'</a></div>';
									$valtemps[]=$ansval->value;
								}	
                            }
							unset($valtemps);
                        ?>
                        </div>
                    </div>
                </div>
				<?php
		         /* find each value form database */
				  $P_Q1 = $this->productModel->getProMetaData($edit_product->product_id,'P_Q1');
				  $interestB1 = $this->productModel->getProMetaData($edit_product->product_id,'interestB1');
				  $interestB2 = $this->productModel->getProMetaData($edit_product->product_id,'interestB2');
				  $interestB3 = $this->productModel->getProMetaData($edit_product->product_id,'interestB3');
				  $interestsB = array();
				  
				  $interestsB[1] = $interestB1;
				  $interestsB[2] = $interestB2;
				  $interestsB[3] = $interestB3;
				  // $negative_impact1 = $this->productModel->getProMetaData($edit_product->product_id,'negative_impact1');
				  // $negative_impact2 = $this->productModel->getProMetaData($edit_product->product_id,'negative_impact2');
				  // $negative_impact3 = $this->productModel->getProMetaData($edit_product->product_id,'negative_impact3');
				  
				  $product_describe = $this->productModel->getProMetaData($edit_product->product_id,'P_Desc');
				?>
				<form id="frm-input" action="<?php echo current_url();?>" method="post"> 	     
					<!-- 
					<div class="widget tableTabs" style="width: 40%; margin: 30px auto 10px">
						<div class="tab_container"> 
							<div id="ttab1" class="tab_content" style="height:33px; padding: 20px;">
								<label>Enter a name for this product profile</label>				   
								<input name="product_name" type="text" value="<?php echo $edit_product->product_name ?>" style="-moz-box-sizing: border-box; background: none repeat scroll 0 0 #FDFDFD;border: 1px solid #D7D7D7; box-shadow: 0 1px 0 #FFFFFF; padding: 6px 5px; margin-left: 10px; float:right;" >
							</div>
						</div>
					</div>
					-->
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Product Name</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										<td class="no-border" colspan="3" style="width:70%;vertical-align:top;" id="ansListhPQ">
											Enter the name of the product or service
											<div align="right" class="qspan" style="padding-top: 15px;">
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												We provide 
												<!-- <span class="dynamicTxt_P<?php echo  $edit_product->product_id ;?>_<?php echo $P_Q1->product_data_id;?> TextColor"><?php echo $P_Q1->value;?></span>. -->
											</div>
										</td>
										<td class="no-border">
											 <div class="grid5">
                                             	<div class="answerbox">
                                                    <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_pname_id('PQ',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_pname_id('PQ',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div id="ansListPQ"></div>
                                                </div>
												<textarea class="validate[required] dynamicTxt gansPQ" style="width:500px;" name="tbl[tpd][<?php echo ($P_Q1->product_data_id?$P_Q1->product_data_id:0);?>][P_Q1]" id="P<?php echo $edit_product->product_id ;?>_<?php echo $P_Q1->product_data_id; ?>" cols="" rows=""><?php echo $P_Q1->value; ?></textarea>
                                                 
	
	</div>
											<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											
										</td>
										<td class="no-border">
											<!-- <div id="5" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div> -->
										</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Product Description</span>
					</h3>
					<div class="widget tableTabs" style=" margin: 10px auto 10px" >		   
						<div class="tab_container">
							<div id="ttab1" class="tab_content"> 
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault"> 
								  <tbody>
									 <tr> 
										<td class="no-border" colspan="3" style="width:70%;vertical-align:top;" id="ansListhPD">
											Can you describe in one sentence what this product or service does.
											<div align="right" class="qspan" style="padding-top: 15px;">
												
												<span class="boldWeight"> Finish this sentence : </span>&nbsp;&nbsp;&nbsp;&nbsp;
												What our  
													 <span class="dynamicTxt_P<?php echo  $edit_product->product_id ;?>_<?php echo $P_Q1->product_data_id;?> TextColor"> <?php echo $P_Q1->value; ?></span> does is that it   
													 <!-- <span class="dynamicTxt_P<?php echo  $edit_product->product_id ;?>_<?php echo $product_describe->product_data_id;?> TextColor"><?php echo $product_describe->value;?></span>. -->
											</div>
										</td>
										<td class="no-border">
											<!-- <div align="center" class="TextColorH">Product/Service</div> -->
											 <div class="grid5">
                                             	<div class="answerbox">
                                                    <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_pdesc_id('PD',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_pdesc_id('PD',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                    <div id="ansListPD"></div>
                                                </div>
												<textarea class="validate[required] dynamicTxt gansPD" style="width:500px;" name="tbl[tpd][<?php echo ($product_describe->product_data_id?$product_describe->product_data_id:0);?>][P_Desc]" id="P<?php echo $edit_product->product_id ;?>_<?php echo $product_describe->product_data_id; ?>" cols="" rows=""><?php echo $product_describe->value; ?></textarea>
                                                
				  
				  						</div>
											<!-- <div align="center" class="TextColorH">Answer Checker</div> -->
											
										</td>
										<td class="no-border">
											<!-- <div id="5" data-icon="&#xe090;" class="dialog_open fs1 iconb"></div> -->
										</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<h3 style="margin-top:30px;color: black;">
						<span style="color: #B30814;">Product Differentiation</span>
					</h3>					
					<!--  this new section add  from company section step 1 -->
					<div class="widget tableTabs">		
						<div class="tab_container">                
							<div id="ttab1" class="tab_content">                    
								<table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="differntiate_points_table">  
									<tbody id="differentiate_id">                        	
										<thead>                            
										</thead>                            
										<tr>                                
											<td class="no-border" style="width: 70%;"  >Does <span class="dynamicTxt_P<?php echo  $edit_product->product_id ;?>_<?php echo $P_Q1->product_data_id;?> TextColor"> <?php echo $P_Q1->value; ?></span> differ from the competition in any way?
												<br />
                                                <font color="#757575">Note: To remove the differentiate point clear the value of the textbox and Save</font>
												<div align="right">
													                                      
												</div>
											</td>
                                            <td class="no-border" ></td>  
                                            <td class="no-border" ></td> 
                                         </tr>
                                         <?php 
										 $interest_count = 1;
										 $available_points = array();
										 foreach($interestsB as $key => $interest_b)
										 {
										 	if($interest_count<=3 && $interest_b->value!=''){
										 ?>
                                         <tr>  
                                         	<td class="no-border" id="ansListhPD<?php echo $key;?>" >
												<div align="right" class="qspan">
													<span class="boldWeight">Finish this sentence: <?php if($interest_count==1) echo 'One'; else echo 'Another';?> way that we differ is that                                      
												</div>
											</td>                        
											<td class="no-border">
												<div class="grid5">
                                                	<div class="answerbox">
                                                        <div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id('PD<?php echo $key;?>',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                        <div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id('PD<?php echo $key;?>',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div>
                                                        <div id="ansListPD<?php echo $key;?>"></div>
                                                    </div>
                                                <textarea class="validate[required] dynamicTxt gansPD<?php echo $key;?>"  style="width:500px;" id="BI_<?php echo $key;?>" name="tbl[tpd][<?php echo $interest_b->product_data_id;?>][interestB<?php echo $key;?>]" cols="" rows=""><?php echo (isset($interest_b->value) ? $interest_b->value : '[differentiation point 1]');?></textarea>
                                                
                  								</div>
											</td>                            	
											<td class="no-border" ></td>                            
										</tr>  
                                        <?php
											$interest_count++;
											}
											else
											{
												if($interest_b->value=='')
												{
													$available_points[] = array($key,(int)$interest_b->product_data_id);
												}
											}
										}
										
										?>   
                                                               
									</tbody>                    
								</table>
							</div>            
						</div>
						<div class="clear"></div>		         
					</div>		
                    <?php
					if($interest_count<=3)
					{
						?>
                        <div align="right">
						<button style="margin-top: 10px;" type="button" class="buttonM bRed" onclick="add_differpoint('<?php echo json_encode($available_points);?>');" id="add_differpoint_id">Add Differentiate Point</button>
                        </div>
						<?php
					}
					?>					
					<!--  this new section add  from company section step 2 -->
					
					
					<div class="fluid" style="margin-top:15px;">
						<?php if($session_status != '2'):?>
							<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
							<input type="submit" class="buttonM bRed" name="form_submit" value="Done" />
							<?php /* <a <?php if($is_paid AND $total_sessions > 0){ ?> href="<?php echo base_url();?>home/newSession" class="buttonM bRed" <?php }else {?> id="34" data-icon="&#xe090;" class="dialog_open_pro buttonM bRed" <?php }?>>Create New Session</a>          	*/?>
							
							<?php else:?>
								<!-- <input type="hidden" name="form_submit" id="from_hidden_submit" />
								<input style="margin-top: -25px; margin-right: 10px" type="button" class="dialog_session buttonM bBlue" value="Save" data-icon="&#xe090;"/>
								<input type="button" class="dialog_session buttonM bRed" value="Continue" data-icon="&#xe090;" /> -->
								<input style="margin-top: -25px; margin-right: 10px" type="submit" class="buttonM bBlue" name="form_submit" value="Save" />
								<input type="submit" class="buttonM bRed" name="form_submit" value="Done" />
							<?php endif;?>
							<input type="hidden" name="step" value="product" />
					</div>
				</form>
                <script type="text/javascript">
				//set Answer
				function set_answer(gans,uans) {
					$(".gans"+$("#getanswer").val()).val($("#anchor"+uans+"_"+gans).html());
					$("#pastanswers").hide();
					$(".btactive .ansdown").show();
					$(".btactive").removeClass('btactive');
				}
				//set Product name id
				function set_pname_id(gans,uans,dis) {
					$('.ansclose').remove();
					$(".btactive .ansdown").show();
					$(".btactive").removeClass('btactive');
					$("#pastanswers").remove();
					$("#getanswer").val(gans);
					var qheader = $("#ansListh"+gans+" .qspan").html();
					var AnList= $("#NameBlock"+uans).html().replace("NNNNNNNN","pastanswers");
					$("#ansList"+gans).prepend(AnList);
					$("#pastanswers").width($(dis).parent().parent().width()-3);
					$("#pastanswers .uapboxyr_box2 span").html(qheader);
					$(dis).addClass('btactive');
					$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
					$(".btactive .ansdown").hide();
				}
				//set Product name id
				function set_pdesc_id(gans,uans,dis) {
					$('.ansclose').remove();
					$(".btactive .ansdown").show();
					$(".btactive").removeClass('btactive');
					$("#pastanswers").remove();
					$("#getanswer").val(gans);
					var qheader = $("#ansListh"+gans+" .qspan").html();
					var AnList= $("#DescBlock"+uans).html().replace("NNNNNNNN","pastanswers");
					$("#ansList"+gans).prepend(AnList);
					$("#pastanswers").width($(dis).parent().parent().width()-3);
					$("#pastanswers .uapboxyr_box2 span").html(qheader);
					$(dis).addClass('btactive');
					$(dis).parent().append('<a href="javascript:void(0);" onclick="hide_answer()" class="ansclose"><span class="ui-icon ui-icon-closethick"></span></a>');
					$(".btactive .ansdown").hide();
				}
				//set Answer id
				function set_answer_id(gans,uans,dis) {
					$('.ansclose').remove();
					$(".btactive .ansdown").show();
					$(".btactive").removeClass('btactive');
					$("#pastanswers").remove();
					$("#getanswer").val(gans);
					var qheader = $("#ansListh"+gans+" .qspan").html();
					var AnList= $("#AnsBlock"+uans).html().replace("NNNNNNNN","pastanswers");
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
				var counter = 0;
				function add_differpoint(data)
				{
					var available = JSON.parse(data);
					
					if(available.length && available.length > counter)
					{
						var counterId = available[counter][0];
						var buttons = '<div class="answerbox"><div class="anbox1"><a class="buttonI bGreyishb" href="javascript:void(0);" onclick="set_answer_id(\'PD'+counterId+'\',1,this)">Use One of Your Past Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div><div class="anbox2"><a class="buttonI bGreyish" href="javascript:void(0);" onclick="set_answer_id(\'PD'+counterId+'\',2,this)">Use One of Our Answers<span class="ui-icon ui-icon-downthick ansdown"></span></a></div><div id="ansListPD'+counterId+'"></div></div>'
						<?php /*?>var buttons = '<div align="center" style="margin-top: 8px;">'+
                  					'<a href="javascript:void(0);" class="buttonM bBlue" onclick="set_answer_id(\'PD'+counterId+'\',1)">Your Answers</a> '+
				  					'<a href="javascript:void(0);" class="buttonM bGreen" onclick="set_answer_id(\'PD'+counterId+'\',2)">Our Answers</a></div>';<?php */?>
				  
						//alert(data);
						if(available.length == 3 && counter == 0) oneanother = 'Finish this sentence: One'; else oneanother = 'Finish this sentence: Another';
						data = '<tr><td class="no-border" width="70%" id="ansListhPD'+counterId+'" ><div align="right" class="qspan"><span class="boldWeight">'+oneanother+' way that we differ is that</div></td><td class="no-border"><div class="grid5">'+buttons +'<textarea class="validate[required] dynamicTxt gansPD'+counterId+'"  style="width:500px;" id="BI_'+available[counter][0]+'" name="tbl[tpd]['+available[counter][1]+'][interestB'+available[counter][0]+']" cols="" rows="">[differentiation point '+available[counter][0]+']</textarea></div></td><td class="no-border" ></td></tr>';
						$('#differntiate_points_table tbody:last').append(data);
						counter++;
					}
					else
					{
						alert('You can add maximum of three differetiate points');
					}
				}
				</script>
			</div>
		</div>
<?php $this->load->view('common/footer');?>