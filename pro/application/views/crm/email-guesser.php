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
    <div class="main-wrapper crmlite" style="margin-top: -20px;">
        <?php if($er) {?>
        <div class="crm-error"><?php echo implode("<br />",$er);?></div>
        <?php }?>
		<!-- Main content -->
		<div style="float: right;">
            <a href="#" class="buttonM bRed dialog_help">Help Video</a>
        </div>
        <form method="post" id="frmeguess" onsubmit="return save_record();" action="<?php echo current_url();?>">
        	<input type="hidden" name="action" value="save" />
        <table cellpadding="0" cellspacing="0" border="0" class="contact-edit">
            <tr>
                <th class="title" colspan="2"><input type="radio" name="eguess[egtype]" class="egtype" value="1" checked="checked" /> Guess Email</th>
            </tr>
            <tr>
                <th width="250px" class="one">First Name</th><td class="two"><input type="text" value="" name="eguess[fname]" id="fname" /></td>
            </tr>
            <tr>
                <th class="one">Last Name</th><td class="two"><input type="text" value="" name="eguess[lname]" id="lname" /></td>
            </tr>
            <tr>
                <th class="one">Company Website</th><td class="two"><input type="text" value="" name="eguess[website]" id="website" /></td>
            </tr>
            <tr>
                <th class="title" colspan="2"><input type="radio" name="eguess[egtype]" class="egtype" value="2" /> Search Exact Email</th>
            </tr>
            <tr>
                <th class="one">Enter exact email address</th><td class="two"><input type="text" value="" name="eguess[email]" id="email" /></td>
            </tr>
            <tr>
                <td colspan="2" class="two eglist"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <div class="fluid" style="margin-top:15px;">
                        <span class="loader"></span>
                        <input type="submit" class="buttonM bBlue" name="btnsave" value="Generate" id="egsubmit" />
                        <a href="<?php echo current_url();?>" class="buttonM bRed" style="display:none;" id="egback">Reset</a>
                    </div>      
                </td>
            </tr>            
        </table>
        </form>
	</div>
    <!-- Main content ends -->
</div>
<script type="text/javascript">
	//Skip hint
	function save_record(){
        $(".loader").html('');
        $(".eglist").html('');
        if($(".egtype:checked").val()=="2") {
            if($("#email").val().length==0) {
                alert("Exact email address required");
                $("#email").focus();
                return false;
            }
        } else {
            if($("#fname").val().length==0) {
                alert("First Name required");
                $("#fname").focus();
                return false;
            }
            if($("#lname").val().length==0) {
                alert("Last Name required");
                $("#lname").focus();
                return false;
            }
            if($("#website").val().length==0) {
                alert("Website required");
                $("#website").focus();
                return false;
            }    
        }
        
        $(".loader").html('Please bare with us, this can take a few seconds <img src="<?php echo base_url();?>images/spinner.gif" />');
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          data: $('#frmeguess').serialize()
            }).done(function( data ) {              
                $(".loader").html('');
				$k = data.substring(0,7).replace(/\s/g,'');
				console.log($k);
                if($k=="SUCCE") {
					//alert("test");
					var str = data.substring(7);
					var n=str.replace("SS","");
                    $(".eglist").html(n);   
                    $("#egback").show();
                } else alert(data);
          })
          .fail(function() {
            alert( "Unable to process, please try again" );
          });
        return false;
    }
	//Create Contact
	function create_contact(eml,etime) {
		//Store contact data
		localStorage.setItem("cm_cc"+etime+"_fname", $("#fname").val());
		localStorage.setItem("cm_cc"+etime+"_lname", $("#lname").val());
		localStorage.setItem("cm_cc"+etime+"_website", $("#website").val());
		localStorage.setItem("cm_cc"+etime+"_email", eml);
		return true;
	}
var iframe= '<iframe width="560" height="315" src="https://www.youtube.com/embed/ZzJ988Wgo7Y?list=PLoUVJsDQgZIKZ-TA8qGrWDHccKEiQNHvP" frameborder="0" allowfullscreen></iframe>';
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
<!-- Content ends -->
<?php $this->load->view('common/footer'); ?>