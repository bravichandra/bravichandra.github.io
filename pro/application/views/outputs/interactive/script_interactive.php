<?php 
if($partid && !isset($isjspage))
{
	$temp = end(explode('/',current_url()));
	$temp2 = end(explode('/',str_replace('/'.$temp,'',current_url())));;
	$download2 = str_replace($temp,'download2',current_url());
?>
	<form id="hiddenForm99" target="_blank" method="post" action="<?php echo $download2;?>">
	<input type="hidden" id="partids" name="partids"/>
	<?php 
	foreach($parts as $part)
	{
		?>
	    	<input type="hidden" id="<?php echo $part['name']; ?>" name="<?php echo $part['name']; ?>"/>
	    <?php
	}
	?>
	</form>
	<?php if(isset($nts) && $nts && $this->session->userdata('ss_sfcomment')) {?>
	<!--Notes to salesforce-->
	<form id="frmntosf" name="frmntosf" target="_blank" method="post" action="<?php echo base_url().'index.php/createtemp/ntosf/';?>">
	<input type="hidden" name="sfaction" value="ntosf"/>
	<input type="hidden" id="sfpartids" name="sfpartids"/>
	<?php 
	foreach($parts as $part)
	{
		?>
	    	<input type="hidden" id="sf<?php echo $part['name']; ?>" name="<?php echo $part['name']; ?>"/>
	    <?php
	}
	?>
	</form>
	<!--Notes to salesforce-->
	<?php }?>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
	<?php //CRM LITE SEARCH?>
	<script type="text/javascript" src="<?php echo base_url();?>/js/plugins/tables/jquery.dataTables.js"></script>
	<script type="text/javascript">
		//Toggle Qualify Responses list
		function qfsublist(dis){
			if($(dis).text()=="+") {
				$(dis).text('-');
				$(dis).parent().find("ul").show();
			} else {
				$(dis).text('+');
				$(dis).parent().find("ul").hide();
			}
		}
		//CRM LITE SEARCH
		//Get Lookup
		function getLookup(rcname,obname) {
			objname = obname;
			var popboxhead = '';
			var ajxmethod='';
			if(rcname=="account") {
				popboxhead = 'Account Lookup';
				ajxmethod='accounts_lookup';
			} else if(rcname=="contact") {
				popboxhead = 'Contact Lookup';
				ajxmethod='contacts_lookup';
			}
			$("#cLookup .abox1").html(popboxhead);
			$("#cLookup").show();
			$("#cLookup .search-list").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$( "#cLookup .search-list" ).load( "<?php echo base_url()."crm/"?>"+ajxmethod, function() {
			  $('.dsTable').dataTable({
					"bJQueryUI": false,
					"bAutoWidth": false,
					"sPaginationType": "full_numbers",
					"sDom": '<"H"fl>t<"F"ip>'
				});
			});
		}
		//Set lookup
		function setLookup(dis) {
			$("#"+objname+"_title").val($(dis).html());
			$("#"+objname+"_id").val($(dis).attr("data_id"));
			$("#cLookup").hide();
			localStorage.setItem(objname+"_title",$(dis).html());
			localStorage.setItem(objname+"_id",$(dis).attr("data_id"));
		}

		function CreateLogCall(step)
		{   
			localStorage.setItem(step+'-'+template_name,$('.sub-dev-cont').val());
			//console.log(localStorage);
			var resp_data_val=[];
			var parts = <? echo json_encode($parts); ?>;
			var partids = [];
			//console.log(parts);
			$.each(parts, function(index, value){
				if(localStorage.getItem(value.name+'-'+template_name)!='')	$('#'+value.name).val(localStorage.getItem(value.name+'-'+template_name));
				//if(value == step) return false;
				partids.push(index);
			});
			//console.log(parts);
			$('#partids').val(JSON.stringify(partids));
			//console.log(JSON.stringify(partids));
			localStorage.clear();
			if($("#contact_id").val()!="") $('#hiddenForm99').append('<input type="hidden" value="'+$("#contact_id").val()+'" name="contact_id" id="contact_id">');
			if($("#account_id").val()!="") $('#hiddenForm99').append('<input type="hidden" value="'+$("#account_id").val()+'" name="account_id" id="account_id">');
			<?php
				$temp = end(explode('/',current_url()));
				$LogCallUrl = str_replace($temp,'logcall',current_url());
			?>
			$.ajax({
				type : 'POST',
				url : '<?php echo $LogCallUrl;?>',
				data :  $('#hiddenForm99').serialize(),
				success : function(data){
					if(data!="") {
						if(data=="Log Call created") {
							$("#contact_id").val('');
							$("#contact_title").val('');
							$("#account_id").val('');
							$("#account_title").val('');
						}
						alert(data);
					}	
					return; 
				}
			});
			$('#hiddenForm99 #contact_id').remove();
			$('#hiddenForm99 #account_id').remove();
			return false;
		}	
		//End of CRM LITE

	var cur_location = window.location.href;
	cur_location_parts = cur_location.split("/");
	var cur_step = cur_location_parts[cur_location_parts.length-1];
	var template_name = cur_location_parts[cur_location_parts.length-2];
	var template_url = cur_location.replace(cur_step,"");
	$(function(){
		readyFunction1();
	});
	function setScreenHeight()
	{
	/*********************Screen Height Adjustment*************************************/
	var scr_height = $(window).height();
	//var scht = Number(scr_height) - 75 - 200;
	var scht = Number(scr_height);
	var bodyh = Number(scr_height);
	$('body').css('height',bodyh+'px');
	$('body').css('overflow','hidden');
	$('body').css('margin','0px');
	<?php /*?>$('.scroll-bar_sf').css('height',(scht+40)+'px');
	$('.content_navigation_is').css('height',(Number(scht)+72)+'px');
	$('.objection-responses-dev').css('height',(Number(scht)+216)+'px');<?php */?>
	<?php /*?>
	//Layout 1
	$('.scroll-bar_sf').css('height',(scht+40+27)+'px');
	$('.content_navigation_is').css('height',(Number(scht)+72+27)+'px');
	$('.objection-responses-dev').css('height',(Number(scht)+220)+'px');
	//Layout 1
	<?php */?>
	//Layout 2
	$('.content_navigation_is').css('height',(Number(scht)-42)+'px');
	$('.scroll-bar_sf').css('height',(scht-74)+'px');
	$('.objection-responses-dev').css('height',(Number(scht)-55)+'px');
	//Layout 2
	$('.is_loader').css('display','none');
	//$('.scroll-bar_sf').css('height','340px');
	/*********************************************************************************/
	}

	function readyFunction1() {
	$(window).resize(setScreenHeight);
	setScreenHeight();
	var cur_location = window.location.href;
	cur_location_parts = cur_location.split("/");
	var cur_step = cur_location_parts[cur_location_parts.length-1];
	var template_name = cur_location_parts[cur_location_parts.length-2];
	var template_url = cur_location.replace(cur_step,"");


	$('.objection_content_sf ul li a').click(function(){
		
		//event.preventDefault();
		//console.log(this.href);
		$('body').load(this.href+' #content', function() {readyFunction1();});
		window.history.pushState({"html":$('document').html()},"", this.href);
		setScreenHeight();
	});
	$('.leftheader_is a').click(function(){
		
		//event.preventDefault();
		//console.log(this.href);
		$('body').load(this.href+' #content', function() {readyFunction1();});
		window.history.pushState({"html":$('document').html()},"", this.href);
		setScreenHeight();
	});
	$('.left_navigation_is .content_navigation_is .navigation_link a').click(function(){
		localStorage.setItem(cur_step+'-'+template_name,$('.sub-dev-cont').val());
		//event.preventDefault();
		//console.log(this.href);
		$('body').load(this.href+' #content', function() {readyFunction1();});
		window.history.pushState({"html":$('document').html()},"", this.href);
		setScreenHeight();
	});
	$('.section_sf').click(function(){
		$('.section_sf').removeClass('active');
		if($(this).attr('data-sec') != 'content_sec1') $('#content_sec1').removeClass('active');
		if($(this).attr('data-sec') != 'content_sec2') $('#content_sec2').removeClass('active');
		if($(this).attr('data-sec') != 'content_sec3') $('#content_sec3').removeClass('active');
		$('#'+$(this).attr('data-sec')).addClass('active');
		$(this).addClass('active');
	});

	/*var cur_step = '<?php echo $temp;?>';*/
	$('.sub-dev-cont').attr("placeholder", "Notes...");
	$('.sub-dev-cont').val(localStorage.getItem(cur_step+'-<?php echo $temp2;?>'));

	//CRM Lite Search
	if(localStorage.getItem('contact_title')!='')	$('#contact_title').val(localStorage.getItem('contact_title'));
	if(localStorage.getItem('contact_id')!='')	$('#contact_id').val(localStorage.getItem('contact_id'));
	if(localStorage.getItem('account_title')!='')	$('#account_title').val(localStorage.getItem('account_title'));
	if(localStorage.getItem('account_id')!='')	$('#account_id').val(localStorage.getItem('account_id'));

	}

	function saveStepData(step,myevent,dis)
	{
		var cur_location = window.location.href;
		cur_location_parts = cur_location.split("/");
		var cur_step = cur_location_parts[cur_location_parts.length-1];
		var template_name = cur_location_parts[cur_location_parts.length-2];
		var template_url = cur_location.replace("/"+cur_step,"/");//By Dev@4489 for IS Last ID
		
		localStorage.setItem(step+'-'+template_name,$('.sub-dev-cont').val());
		if(template_url != dis.href)
		{
			myevent.preventDefault();
			//console.log($('.sub-dev-cont').val());
			//console.log(dis.href);
			<?php /*?>$('body').load(dis.href+' #content', function() {readyFunction1();});<?php */?>
			$(".is_footer .a a.active").removeClass("active");
			var disclass=$(dis).attr("class");
			$('body').load(dis.href+' #content', function() {readyFunction1();if(disclass!="is_voicemail_tab ") $("."+disclass).addClass("active");});
			window.history.pushState({"html":$('document').html()},"", dis.href);
			setScreenHeight();
		}
	}
	function sfsaveStepData(step,myevent,dis)
	{
		if($('.sub-dev-cont').val()) {
			var cur_location = window.location.href;
			cur_location_parts = cur_location.split("/");
			var cur_step = cur_location_parts[cur_location_parts.length-1];
			var template_name = cur_location_parts[cur_location_parts.length-2];
			var template_url = cur_location.replace(cur_step,"");
			
			localStorage.setItem(step+'-'+template_name,$('.sub-dev-cont').val());
		}
		location.replace("<?php echo base_url();?>page1.php?template=<?php echo $tempname;?>&sfid=<?php echo $nts;?>");
	}
	function downloadData(step)
	{   
		localStorage.setItem(step+'-'+template_name,$('.sub-dev-cont').val());
		//console.log(localStorage);
		var resp_data_val=[];
		var parts = <? echo json_encode($parts); ?>;
		var partids = [];
		//console.log(parts);
		$.each(parts, function(index, value){
			if(localStorage.getItem(value.name+'-'+template_name)!='')	$('#'+value.name).val(localStorage.getItem(value.name+'-'+template_name));
			//if(value == step) return false;
			partids.push(index);
		});
		//console.log(parts);
		$('#partids').val(JSON.stringify(partids));
		//console.log(JSON.stringify(partids));
		localStorage.clear();
		$('#hiddenForm99').submit();
		//alert('da');
		window.setInterval(rediretmain, 2000);
	}
	<?php if(isset($nts) && $nts && $this->session->userdata('ss_sfcomment')) {?>
	function prepar_ntosf(step)
	{   
		console.log(localStorage);
		var resp_data_val=[];
		var parts = <? echo json_encode($parts); ?>;
		var partids = [];
		//console.log(parts);
		$.each(parts, function(index, value){
			if(localStorage.getItem(value.name+'-'+template_name)!=null) {
				//document.getElementById('sf'+value.name).value=localStorage.getItem(value.name+'-'+template_name);
				$('#sf'+value.name).val(localStorage.getItem(value.name+'-'+template_name));
				//alert($('#sf'+value.name).val());
				//alert(localStorage.getItem(value.name+'-'+template_name));
			}	
			//if(value == step) return false;
			partids.push(index);
		});
		$('#sfpartids').val(JSON.stringify(partids));
		//console.log(JSON.stringify(partids));
		localStorage.clear();
		$("#salesnotes").hide();
		$('#frmntosf').submit();
		//alert('Notes');return false;
		//window.setInterval(rediretmain, 2000);
	}
	$(function(){
	prepar_ntosf('<?php echo $tempname;?>');
	});
	<?php }?>

	function rediretmain() {
	 //window.location.replace(template_url); 
	 window.location.reload();
	}
	</script>

<?php $isjspage=1;}

?>
