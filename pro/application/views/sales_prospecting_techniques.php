<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
<style>.pt10 a {color:black;}.align-center{text-align: center;}.main-wrapper div.wrapper:nth-child(odd) > :first-child {background: #B9B9BD;}.main-wrapper div.wrapper:nth-child(even) > :first-child {background: #B9B9BD;}/*.main-wrapper div.wrapper:nth-child(odd) {  color: #ccc;}*/
.sales_video_questions
{
	display:none;
}
#quiz_qans
{
	width: 100%;
    float: none;
    margin: 0px auto;
    background: #F7F7F7;
    padding: 20px;
    border: 1px solid #CCC;
    border-radius: 5px;
    margin-bottom: 20px;
}
#quiz_qans h3
{
	padding:25px 0px 10px;
}
#quiz_qans ul
{
	background-color:#FFFFFF;
	border:1px solid #CCC;
	padding:10px;
}
#quiz_qans ul li
{
	padding-bottom:10px;
}
h2.pt10
{
	font-size:14px;
	text-align:center;
}
.required
{
	border:1px solid #FF0000 !important;
}
</style>
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
	$this->load->view('common/empty_nav');
	?> 	
	<!-- Start Search for a Team Member Form -->						    
	<!-- Main content -->
	<!-- Start Existing Team Members Conection -->	
    		<input type="hidden" name="video_id" id="video_id" value="" />								    
			<div class="wrapper">
				<!-- <div style="margin-top:10px;">							    		
				<a <?php // if ($is_paid) { ?> 				href="<?php // echo base_url(); ?>for-team-member" <?php // } else { ?> id="35" data-icon="&#xe090;" class="dialog_open_pro" <?php // } ?>><input type="button" class="buttonM bRed" name="request" value="Search for a Team Member" /></a>							    	</div> -->									
				<?php // if (!empty($all_requests) or !empty($all_receiver_requests)): ?>		
          <div class="fluid sales_video" style="display: none;">
                    <div class="grid6" style="width:90%;float:none;margin: 0px auto;">
                      <div class="widget" style="padding-right:20px;">
                        <!--<iframe width="600" height="315" src="https://www.youtube.com/embed/EbDbEe3ASHk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br/>-->
                        <div style="position:relative;padding-top:56.25%;">
                          <iframe id="video_url" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
                            style="position:absolute;top:0;left:0;width:98%;height:94%;padding:20px;"></iframe><br/>
                        </div>
                        <div style="padding-left: 20px;" id="mark_docs"><input  id="" type="checkbox" name="" onchange="updateBasicDetails(this,0);"/> Mark to document that you have watched training module</div>
                        <div style="text-align:center; margin-bottom:10px;">
                        	<div id="finalQuiz"><input type="button" class="buttonM bGreen" name="launch" value="TAKE Quiz" onclick="takeQuiz(0);"></div>
                         </div>
                      </div>
                    </div>            
                  </div>						        
          <div class="fluid sales_video_questions">
                <form method="post" id="form">
                    <div class="grid6" id="quiz_qans"></div>
                    <div style="text-align:center; margin-bottom:20px;">
                         <div id="qbutton"><input type="button" class="buttonM bGreen" name="launch" value="SUBMIT" onclick="submitQuiz(this);"></div>
                    </div>
                </form>
                <div class="summary"></div>
          </div>						        
		  <div class="fluid sales_basis">
						<div class="grid6" style="width:initial;">
							<div class="widget" style="padding-right:20px;">
								<div class="body">
                     <h1 style="margin-left:10px; margin-bottom:10px;" class="pt10">Sales Prospecting Advanced Techniques</h1>
                                <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
                                    <tbody>
                                           <?php
                                                $i=0;
                                                foreach($videos_list as $key=>$value)
                                                {
                                                $quizstatus = $this->crm->sptquizstatus($value->id,'');
                                                if($value->id==1) $k=$tstatus1;
                                                if($value->id==2) $k=$tstatus2;
                                                if($value->id==3) $k=$tstatus3;
                                                if($value->id==4) $k=$tstatus4;
                                                if($value->id==5) $k=$tstatus5;
                                                if($value->id==6) $k=$tstatus6;
                                                if($value->id==7) $k=$tstatus7;
                                                if($value->id==8) $k=$tstatus8;
                                                if($value->id==9) $k=$tstatus9;
                                                if($value->id==10) $k=$tstatus10;
                                                if($value->id==11) $k=$tstatus11;
                                                if($value->id==12) $k=$tstatus12;
                                                $i++;
                                              ?>  
                                            <tr>
                                              <td><?php echo $i; ?></td>
                                                <td class="no-border">
                                                    <h6><span><?php echo $value->title;?></span></h6>
                                                </td>                                               
                                                <td class="no-border" style="width:100px; text-align:center;">
                                                   <input type="button" class="buttonM bGreen" name="launch" 
                                                   value="Watch" 
                                                   onclick="watchTraining('<?php echo $value->video_url;?>','topic<?php echo $value->id;?>_status',<?php echo $value->id;?>);" />
                                                </td>
                                                <td class="no-border" style="text-align: center; width:100px; color:black; font-weight:bold;">
                                                    <?php if($k==1) echo 'Watched'; else echo ""; ?>
                                                </td>
                                                <td class="no-border" style="text-align: center;width:100px;">
                                                	<?php if($value->status==1) { 
													if($quizstatus=="Passed" || $quizstatus=="Fail") { ?>
                                                    <input type="button" class="buttonM bGreen" name="launch" onclick="takeQuiz(1,<?php echo $value->id;?>);" value="Take Quiz" />
                                                    <?php }  else { ?>
                                                    <input type="button" class="buttonM bGreen" name="launch" onclick="takeQuiz(0,<?php echo $value->id;?>);" value="Take Quiz" />
                                                    <?php }} ?>
                                                </td>
                                                <td class="no-border" style="text-align: center;width:100px; color:black; font-weight:bold;">
                                                   <?php
														
														if($quizstatus=="Passed") echo "Passed"; else echo "";
													?>
                                                </td>
                                           </tr>
                                           <?php } ?>                                 					                        
                                    </tbody>
                                </table>
                            </div>
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
			//Email report report status
			function watchTraining(dis,status) {
			 ajrequest = $.ajax({
			 type: "POST",
			 url: "<?php echo base_url('scripts/salesProspectingTechniques');?>",
			 cache: false,
			 dataType: 'json',
			 data: 'ctype='+dis+'&status='+status,
			}).done(function( resp ) {
           // alert(resp.tstatus);
            $(".sales_basis").hide();
            $(".sales_video").show();
            $("#video_url").attr("src","https://www.youtube.com/embed/"+resp.record);
			if(resp.tstatus==1)
            $("#mark_docs").html("<input type='checkbox' checked='checked' id='"+status+"' class='mstatus' name='"+status+"' onchange='updateBasicDetails(this,0);'/> Mark to document that you have watched training module");
			else
			$("#mark_docs").html("<input type='checkbox' id='"+status+"' name='"+status+"' class='mstatus' onchange='updateBasicDetails(this,0);'/> Mark to document that you have watched training module");
				  })
			}
      function updateBasicDetails(dis,qp) {
            var vis = dis.checked?1:0;
			var status = $(this).attr('id');
			var obj = document.getElementsByClassName("mstatus");
    		status= obj[0].id;
            $.ajax({
                type : 'POST',
                url : '<?php echo base_url('crm/salesprospectingtechniquesdetails');?>',
                data: 'val='+vis+'&qp='+qp+'&status='+status,
                cache: false,
                dataType: 'json',
                success: function(responce)
                {
                    location.replace("sales-prospecting-techniques"); 
                }
            });

        }

        function takeQuiz(dis,$vid)
        {
          var vid;
          if($vid) vid=$vid;
          else vid=$("#video_id").val();
          $.ajax({
                    type : 'POST',
                    url : '<?php echo base_url('crm/sptquestions');?>',
                    data: 'vid='+vid+'&type='+dis,
                    cache: false,
                    dataType: 'json',
                    success: function(responce)
                    {
              $(".sales_basis").hide();
              $(".sales_video_questions").show();
              $(".sales_video").hide();
                      $("#quiz_qans").html(responce['content']);
              var res = responce['status'];
              if(res=="Passed") $("#qbutton").html('<a href="/betapro/folder/sales-prospecting-basics" class="buttonM bGreen">Return to Training</a>');
              else $("#qbutton").html('<input type="button" class="buttonM bGreen" name="launch" value="SUBMIT" onclick="submitQuiz(this);">'); 
              $("#video_id").val(vid);
              $(".summary").html("");
                    }
                });
        }
        function checkQuizStatus()
        {
          var vid=$("#video_id").val();
          $.ajax({
                    type : 'POST',
                    url : '<?php echo base_url('crm/sptquizstatus');?>',
                    data: 'vid='+vid,
                    cache: false,
                    dataType: 'json',
                    success: function(responce)
                    {
						$('.pleasewait').css('display','none');
              			$("#quiz_qans").html(responce);
              			$("#qbutton").html("");
                    }
                });
        }
        function submitQuiz(obj)
        {
		  var position = $(obj).position();
		  var offset = $(obj).offset();
          var vid=$("#video_id").val();
          var check="";
          $("input:radio").each(function(){
            var name = $(this).attr("name");
            if($("input:radio[name="+name+"]:checked").length == 0){
              $(this).parents().closest("ul").addClass('required');
              check = false;
            }
            else
            {
              $(this).parents().closest("ul").removeClass('required');
              check = true;
            }
          });
          if(check){
		  
		  $('.pleasewait').css('top',offset.top);
		  $('.pleasewait').css('left',offset.left);
		  $('.pleasewait').css('display','block');
          $.ajax({
		  	
				type: "POST",
				url: "<?php echo base_url('crm/submitsptquestions');?>",
				dataType: "text",
				async:false,
				data: $('#form').serialize()+'&vid='+vid,
				success: function (data) {
					checkQuizStatus();
					Success = true;//doesnt goes here
				},
				error: function (textStatus, errorThrown) {
					Success = false;//doesnt goes here
				}
			
		  });
		  
          }return false;
    }
	</script>
<?php $this->load->view('common/footer'); ?>
