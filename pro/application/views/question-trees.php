<?php $this->load->view('common/meta'); ?>	
<?php $this->load->view('common/header'); ?>
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
	<!-- Breadcrumbs line -->   
	<?php  $this->load->view('common/empty_nav');?>
	<div class="wrapper" style="min-height:500px;">
		<!-- Start Receiver Shared Data Listing if available -->							
		<?php $msg = $this->session->flashdata('session_msg');$n=0; ?>
		<?php if ($msg): ?><br>
			<h3 style="color:green !important;"><?php echo $this->session->flashdata('session_msg'); ?></h3>
		<?php endif; ?>    
        <h3 style="margin-top:30px;color: black" id="BusinessHeading">
            <span style="color: #B30814;">Question Trees</span> 					   
        </h3>    
        <br clear="all" />             
        <?php if($quest_row) {?>
        <div align="right">
        	<a href="<?php echo current_url();?>" class="buttonM bRed floatR">Return to Question List</a>
        	<?php if($qnext){ ?>
        	<form method="post" action="" class="floatR">
                <input type="submit" class="buttonM bRed" value="Move to Next Question"/>&nbsp;
                <input type="hidden" name="qid" value="<?php echo $qnext; ?>" />
            </form>
            <?php }?>
        </div>
        <?php }elseif($quest_add){?>
        <?php }else{?>
        <table class="custom_content_tab">
            <tr>
                <td class="title" valign="middle">Campaign &nbsp; </td>
                <td>
                	<form method="post" id="frmCampaign" action="<?php echo current_url();?>">
                        <select name="campgnid" style="float:right;" onchange="this.form.submit();">
                        <option value="">Select</option>
                        <?php foreach($drop_campaign as $singlecampaign): ?>
                        <option value="<?php echo $singlecampaign->campaign_id; ?>"  <?php if($singlecampaign->status == 1){ echo "selected";} ?>><?php echo $singlecampaign->campaign_name; ?></option>
                        <?php endforeach; ?>
                        </select>                    
                    </form>
                </td>                
            </tr>
        </table>   
        <?php }?>
        <br clear="all" />
        <?php if($quest_add) {//New question?>
        <div id="QNew">
            <div style="width:100%;border: 1px solid #cccccc;padding: 4px;">
            	<form method="post" id="frm1" onsubmit="return saveQuestion();">
                <div>
                    Enter qualify question: <br />
                    <textarea name="txtquest" id="txtquest"><?php echo $txtquest;?></textarea>
                    <input type="hidden" name="qedit" value="A" />
                </div><br />
                <div>
                	Enter Sort Order : <input type="text" value="<?php echo $txtorder;?>" name="txtorder" id="txtorder" style="height: 20px;border: 1px solid #999999;" />
                </div><br />
                <div>
                    <input type="submit" name="qsave" class="buttonM bBlue" value="Save"/> &nbsp; 
                    <a href="<?php echo base_url(); ?>folder/question-trees" class="buttonM bRed">Cancel</a>
                    <input type="hidden" name="eqid" value="<?php echo ($eqid?$eqid:"Y");?>" />
                </div>
                </form>
            </div>
        </div>
        <?php } else if($quest_row) {$quest_row = $quest_row[0];//$n++;?>
        <div id="Qresp">    
        	<div style="padding-left: 8px;"><b><?php echo $quest_row->value;?></b></div>
            <div style="padding-left: 8px;"><input type="button" class="buttonM bBlue bapresp" value="Add a Prospect Response" onclick="addpresp(0,this);" /></div>
            <div id="dqresp<?php echo $n; ?>">
                <div style="padding:4px; vertical-align:bottom;" id="rspsbox<?php echo $n; ?>">
                	<?php echo $quest_responses;?>
                    <?php if(!$quest_responses){?>
                    <div class="quest-resp fqrbox displayNone">
                        <div align="center"><b>Prospect Response</b></div>
                        <div class="divfrm">
                            Enter a possible answer that the prospect might give to this question
                             <br />
                            <span class="TextColor rsprootNO"><?php echo $quest_row->value;?></span>                    
                        </div>
                        <form method="post" class="frm_resp">
                            <input type="hidden" name="qid" id="qid" value="<?php echo $quest_row->tech_q_id; ?>" />
                            <input type="hidden" name="qrespid" id="qrespid" value="0" />
                            <input type="hidden" name="qpid" id="qpid" value="0" />
                            <textarea name="txtresp" class="txtresp" placeholder="Enter prospect response" style="margin-top:2px;margin-bottom:2px;"></textarea><br />
                            <span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span>
                            <input type="button" class="buttonM bBlue bsave" value="Save" onclick="saveresp(1,this);" />&nbsp;
                            <?php /*?><input type="button" class="buttonM bBlue bapresp" value="Add a Prospect Response" onclick="addpresp(1,this);" style="margin-top: 2px;display:none;" /><?php */?>
                            <input type="button" class="buttonM bBlue baresp" value="Add a Sales Response" onclick="addresp(1,this);" style="margin-top: 2px;display:none;" />
                            <input type="button" class="buttonM bRed bdel" value="Delete" onclick="delresp(1,this);" style="margin-top: 2px; display:none;" />
                        </form><br clear="all" /><hr style="margin:4px;" />   	
                    </div>
                    <?php }?>
                </div>
            </div>
        </div><br clear="all" />
        <?php } else {?>
        <div align="right"><b>Note:</b> Sort Order will be saved automatically when number changed.</div>
        <?php if (!empty($quest_tree)): ?>
        <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">
            <thead>
            	<tr>
                	<th>Question</th>
                    <th>Sort Order</th>
                </tr>
            </thead>
            <tbody>										
                						                        		
                    <?php foreach ($quest_tree as $quest): ?>															
                        <tr>
                            <td class="no-border">
                            <h6><span ><?php echo $quest->value; ?></span></h6>
                            <div align="right">
                            	<form method="post" action="" onsubmit="return confirm('Are u sure you want to delete this question?');" class="floatR">
                                	&nbsp;<input type="submit" class="buttonM bRed" value="Delete"/>
                                    <input type="hidden" name="qRmid" value="<?php echo $quest->tech_q_id; ?>" />
                                </form>
                                <form method="post" action="" class="floatR">
                                	&nbsp;<input type="submit" class="buttonM bGreen" value="Edit Question"/>
                                    <input type="hidden" name="qedit" value="E" />
                                    <input type="hidden" name="eqid" value="<?php echo $quest->tech_q_id; ?>" />
                                </form>
                                <?php /*?><a href="<?php echo base_url(); ?>folder/question-trees/<?php echo $quest->tech_q_id; ?>" class="buttonM bBlack floatR">Add a Follow up Response</a><?php */?>
                                <form method="post" action="" class="floatR">
                                	<input type="submit" class="buttonM bBlack" value="Edit Question Branch"/>
                                    <input type="hidden" name="qid" value="<?php echo $quest->tech_q_id; ?>" />
                                </form>                                
                            </div>
                            </td>
                            <td><input type="text" name="qorder" value="<?php echo $quest->qus_id; ?>" style="height:20px; border:1px solid #999999; text-align:center;" size="2" onchange="updateQorder(<?php echo $quest->tech_q_id; ?>,this.value)" /></td>   
                        </tr>																	                            
                    <?php endforeach; ?>						                            
                						                        
            </tbody>
        </table> 
        <?php endif; ?>
        <div align="right">
            <form method="post" action="" class="floatR">
                <input type="submit" class="buttonM bRed" value="Add a Question" style="margin-top:10px;color:white !important;"/>
                <input type="hidden" name="eqid" value="0" />
                <input type="hidden" name="qedit" value="A" />
            </form>                                
        </div>
        <?php }?>  					    		
	<!-- End Receiver Shared Data Listing if available -->						
	</div>
	<!-- Start Search for a Team Member Form -->						    
    																		      
</div><br clear="all" />
<!-- Main content ends -->
<script>
var curresp=<?php echo $n; ?>;
//Update question order
function updateQorder(qid,qoval)
{
	if(qoval) {
		$.ajax({
			type : 'POST',
			url : '<?php echo current_url();?>',
			data: 'qid='+qid+'&action=qaulifyupdate&qo='+qoval,
			cache: false,
			dataType: 'json',
			success: function(responce)
			{
				//	
			}
		});
	}
}
//Save Question
function saveQuestion() {
	if($("#txtquest").val()=="") {
		$("#txtquest").focus();
		alert("Enter question");
		return false;
	}
	if($("#txtorder").val()=="") {
		$("#txtorder").focus();
		alert("Enter sort order");
		return false;
	}
	if(isNaN($("#txtorder").val())==true) {
		$("#txtorder").focus();
		alert("Sort order number must be number");
		return false;
	}
	return true;
}
//Delete Response
function delresp(level,sbtn) {
	if(!confirm('Are u sure you want to delete?')) return;
	var rform = $(sbtn).parent();
	rform.find(".loader").show();
	$.ajax({
			type : 'POST',
			url : '<?php echo current_url();?>',
			data: {action:'deleteResp',qrid:rform.find("#qrespid").val()},
			cache: false,
			dataType: 'json',
			success: function(responce)
			{
				rform.find(".loader").hide();
				$("#dqresp"+rform.find("#qrespid").val()).remove();
				rform.find("#qrespid").val('');
				rform.find(".txtresp").val('');
				rform.find(".bapresp").hide();
				rform.find(".baresp").hide();
				rform.find(".bdel").hide();
				rform.find(".bsave").val('Save');
			}
		});	
}
//Save Response
function saveresp(level,sbtn) {
	var rform = $(sbtn).parent();
	var rdiv = rform.parent();
	if(rform.find(".txtresp").val()=="") {
		rform.find(".txtresp").focus();
		alert("Enter response");
		return;
	}
	rform.find(".loader").show();
	$.ajax({
			type : 'POST',
			url : '<?php echo current_url();?>',
			data: rform.serialize(),
			cache: false,
			dataType: 'json',
			success: function(responce)
			{
				rform.find(".loader").hide();
				if(responce.action=="new") {
					//var fapbtn=1;
					/*if((level==2 && $("#rspsbox"+rform.find("#qpid").val()+" .quest-resp").length==1) || level==3) fapbtn=0;
					if(level<3) {
						$("#rspsbox"+rform.find("#qpid").val()).append('<div class="quest-resp"><div>'+rdiv.html()+'</div></div>');
						$("#rspsbox"+rform.find("#qpid").val()+" div:last").find(".txtresp").val('');
						$("#rspsbox"+rform.find("#qpid").val()+" div:last").find(".txtresp").attr('placeholder','Enter new response');
					}*/
					$(sbtn).val('Update');
					//if(fapbtn==1) 
					rform.find(".baresp").show();
					rform.find(".bapresp").show();
					rform.find(".bdel").show();
					rform.find("#qrespid").val(responce.qrespid);
					rdiv.append('<div id="dqresp'+responce.qrespid+'"></div>');
				} else if(responce.action=="edit"){
					//console.log($("#frm"+fid+" #qrespid").val()+"--"+$("#frm"+fid+" .txtresp").val());
					$(".rsproot"+rform.find("#qrespid").val()).html(rform.find(".txtresp").val());
				}
				//$("#btnsave"+fid).hide();
				//$("#addresp"+fid).show();
				//$("#frm"+fid+" .txtresp").attr("readonly","readonly");
			}
		});	
}
//Add Follow-Up Respone box
function addresp(level,rfbtn) {
	var rform = $(rfbtn).parent();
	//var fupbtn = '&nbsp;<input type="button" class="buttonM bBlue bapresp" value="Add a Prospect Response"  onclick="addpresp('+(level+1)+',this);" style="margin-top: 2px;display:none;" />';
	var fupbtn = '&nbsp;<input type="button" class="buttonM bBlue baresp" value="'+((level+1)%2==0?'Add a Prospect Response':'Add a Sales Response')+'"  onclick="addresp('+(level+1)+',this);" style="margin-top: 2px;display:none;" />';
	fupbtn += '&nbsp;<input type="button" class="buttonM bRed bdel" value="Delete" onclick="delresp('+(level+1)+',this);" style="margin-top: 2px; display:none;" />';
	
	//if(level+1==3) fupbtn = '';
	var dta = '<div style="padding:4px; vertical-align:bottom;" id="rspsbox'+rform.find("#qrespid").val()+'"><div class="quest-resp"><div align="center"><b>'+((level+1)%2==0?'Sales Response':'Prospect Response')+'</b></div><div class="divfrm">'+((level+1)%2==0?'Enter a good response or question that you can say if the prospect has the response below':'Enter a possible answer that the prospect might give to this question')+' <br /><span class="TextColor rsproot'+rform.find("#qrespid").val()+'">'+rform.find(".txtresp").val()+'</span></div><form method="post" class="frm_resp"><input type="hidden" name="qid" id="qid" value="<?php echo $quest_row->tech_q_id; ?>" /><input type="hidden" name="qrespid" id="qrespid" value="0" /><input type="hidden" name="qpid" id="qpid" value="'+rform.find("#qrespid").val()+'" /><textarea name="txtresp" class="txtresp" placeholder="'+((level+1)%2==0?'Enter Sales Response':'Enter Prospect Response')+'" style="margin-top:2px;margin-bottom:2px;"></textarea><br /><span class="loader" style="display:none;"><img src="<?php echo base_url();?>images/spinner.gif" /></span><input type="button" class="buttonM bBlue bsave" value="Save" onclick="saveresp('+(level+1)+',this);" />'+fupbtn+'</form><br clear="all" /><hr style="margin:4px;" /></div></div>';
	$("#Qresp #dqresp"+rform.find("#qrespid").val()).append(dta);
	//$(rfbtn).hide();
	//$("#frm"+fid+" #addresp"+fid).hide();
	//$("#addresp"+fid).hide();
}

//Add Prospect or Sales Respone box
function addpresp(level,rpspbtn) {	
	if(level==0) {
		if($(".fqrbox").hasClass("displayNone")==true) {
			$(".displayNone").removeClass("displayNone");
			return;
		}
		var rform = $("#rspsbox0 form:first");		
	} else var rform = $(rpspbtn).parent();
	var rspar = rform.find("#qpid").val();
	var psbox = '<div class="quest-resp">';
	psbox += 		'<div align="center"><b>Prospect Response</b></div>';
	psbox += 		'<div class="divfrm">';
	psbox += 		$("#rspsbox"+rspar+" .divfrm:first").html();
	psbox += 		'</div>';
	psbox += 		'<form method="post" class="frm_resp">';
	psbox += 		$("#rspsbox"+rspar+" .frm_resp:first").html();
	psbox += 		'</form>';
	psbox += 		'<br clear="all" /><hr style="margin:4px;">';
	psbox += '</div>';
	$("#rspsbox"+rspar).append(psbox);
	var cpsbox = $("#rspsbox"+rspar+" .quest-resp:last .frm_resp");
	cpsbox.find("#qrespid").val(0);
	cpsbox.find(".txtresp").val("");
	cpsbox.find(".txtresp").attr("placeholder","Enter prospect response");
	cpsbox.find(".bsave").val('Save');
	cpsbox.find(".bapresp").hide();
	cpsbox.find(".baresp").hide();
	cpsbox.find(".bdel").hide();
}

function saveToMyFolderProduct(productid,userId)
{
	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/copyProductToMyFolder/',
		  data: 'product_id='+productid+'&user_id='+userId,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
			// window.location.href = BASE_URL + 'folder/team-folder';
			location.reload(true);
		  }
		});
}
/**
 *  Copy all campaign data to current user profile.
 */
function saveToMyFolderCampaign(campaign_id,userId)
{
    // return ;
	$.ajax({
		type: "POST",
		url: BASE_URL + 'campaign/copyCampaignToMyFolder/',
		data: 'campaign_id='+campaign_id+'&user_id='+userId,
		cache: false,
		dataType: 'json',
		success: function(response)
		{
			// window.location.href = BASE_URL + 'folder/team-folder';
			location.reload(true);
		}
	});
}

</script>
<?php $this->load->view('common/footer'); ?>