<?php // echo "<pre>"; print_r($mailchimp); echo "</pre>"; exit; ?>
<div class="main-wrapper crmlite">
    <div class="quatabs"  style="padding-top:20px;">
        <div class="active first">
            <a href="javascript:void(0);" rel="box1">
               MailChimp
            </a>
        </div>
        <div class="second">
            <a href="javascript:void(0);" rel="box2">
               	RingCentral
            </a>
        </div>
    </div>
    <div class="quaboxes">
    	  <div id="box1" class="active">
          	  <div class="helpvideo" style="position:absolute; right:30px; top:80px;">
                    <a href="#" class="buttonM bRed dialog_mchelp">Help Video</a>
               </div>
                <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100% !important;" >
                    <tr>
                        <th class="title" colspan="2">Integrations</th>
                    </tr>
                    <tr>
                        <th class="one">MailChimp API Key</th>
                        <td class="two"><input type="text" value="<?php if(isset($mailchimp['apikey'])) echo form_prep($mailchimp['apikey'])?>" name="mailchimp[apikey]" id="mailchimp_apikey" size="70" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <div class="fluid" style="margin-top:15px;">
                                <span class="loader"></span>
                                <input type="submit" id="mc-submit" class="buttonM bBlue" name="btnsave" value="Save" />
                            </div>
                            <div style="text-align: left;padding-left: 10px;" class="esettings"></div>      
                        </td>
                    </tr>            
                </table>
          </div>
          <div id="box2">
          		<div class="helpvideo" style="position:absolute; right:30px; top:80px;">
                    <a href="#" class="buttonM bRed dialog_rhelp">Help Video</a>
                </div>
          	   <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100% !important;" >
                    <tr>
                        <th class="title" colspan="2">RingCentral Settings</th>
                    </tr>  
                    <tr>
                        <th style="width: 177px;" class="one">Display</th>
                        <td class="two"><input placeholder="display" type="checkbox" value="1" name="rc-display" id="rc-display" size="70" <?php if(isset($ringcentral['display']) && $ringcentral['display'] == 1) echo "checked"; ?> /></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" align="center">
                            <div class="fluid" style="margin-top:15px;">
                                <span class="loader"></span>
                                <input id="rc-submit" type="submit" class="buttonM bBlue" name="btnsave" value="Save" />
                            </div>
                            <div style="text-align: left;padding-left: 10px;" class="rc-message"></div>      
                        </td>
                    </tr>        
                </table>
          </div>
          <div id="box3">
          	   <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100% !important;" >
                    <tr>
                        <th class="title" colspan="2">Hubspot Settings</th>
                    </tr>  
                    <tr>
                    	<td height="90px">&nbsp;
                        	
                        </td>
                    </tr>        
                </table>
          </div>
          <div id="box4">
          	   <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100% !important;" >
                    <tr>
                        <th class="title" colspan="2">Salesforce Settings</th>
                    </tr>  
                    <tr>
                    	<td height="90px">&nbsp;
                        	
                        </td>
                    </tr>        
                </table>
          </div>
    </div>
</div>
<script type="text/javascript">
    var iframe_mailchimp= '<iframe width="560" height="315" src="https://www.youtube.com/embed/VUckelEZvEU" allow="autoplay; encrypted-media" frameborder="0" allowfullscreen></iframe>';
	
	var iframe_ringcenter= '<iframe width="560" height="315" src="https://www.youtube.com/embed/0M7SkDEXv5w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	

    var base_url = '<?php echo base_url(); ?>';
    $( document ).ready(function() {
	
		 $('#mc-submit').click(function(e){
           e.preventDefault();
            mKey = $('#mailchimp_apikey').val();
            $.ajax({
			  type: "POST",	
			  url: "<?PHP echo base_url('crm/mkeySave'); ?>",	
			  data: {mKey:mKey}
				}).done(function( data ) {
				alert(data);
			})
        });
		
		
        $('#rc-submit').click(function(e){
            e.preventDefault();
            user_name = $('#rc-username').val();
            password = $('#rc-password').val();
            extension = $('#rc-extension').val();
            display = $('input[name="rc-display"]:checked').val();
            $.ajax({
                type: "POST",
                url: base_url+'ringcentral/saveRingCentralInfo',
                data: {user_name:user_name,extension:extension,password:password,display:display,bypass:true},
                dataType: 'json',
                success: function(res){
                    if( res == 'success' ){
                        $('.rc-message').html('<span style="color:#5fba7d;">Save Successful!</span>');
                    }else{
                        $('.rc-message').html('<span style="color:#FF0415;">Opss! Something whent wrong.</span>');
                    }
                    setTimeout(function(){ $('.rc-message').html(''); }, 2000);
                }
                
            });
        });

        $('.mchelp_dialog').dialog({
            autoOpen: false,
            height: 400,
            width: 600,
            buttons: {
                "Close": function () {
                    $('.mcvideo').html('');
                    $(this).dialog("close");
                    
                }
            }    
        });
		
		$('.rhelp_dialog').dialog({
            autoOpen: false,
            height: 400,
            width: 600,
            buttons: {
                "Close": function () {
                    $('.rvideo').html('');
                    $(this).dialog("close");
                    
                }
            }    
        });

        
        // Invitation Dialog Link
        $('.dialog_mchelp').click(function (e) {
             $('.mcvideo').html(iframe_mailchimp);
             $('.mchelp_dialog').dialog('open');
             
            return false;
        });
		
		$('.dialog_rhelp').click(function (e) {
             $('.rvideo').html(iframe_ringcenter);
             $('.rhelp_dialog').dialog('open');
             
            return false;
        });
        
        $('.ui-icon-closethick').click(function (e) {
            $('.mcvideo').html('');
            $('.mchelp_dialog').dialog('close');			  
			$('.rvideo').html('');
            $('.rhelp_dialog').dialog('close');
            return false;
        });
		
		$('.quatabs a').click(function(e){

			$('.quatabs div').removeClass("active");

			$(this).parent().addClass("active");

			$('.quaboxes div').removeClass("active");

			$('.quaboxes #'+$(this).attr("rel")).addClass("active");

		});
        
    }); 
</script>
<div class="mchelp_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video</title>
</head>

<body>
 <div class="mcvideo">

 </div>
</body>
</html></div>

<div class="rhelp_dialog" title="Video">
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Video</title>
</head>

<body>
  <div class="rvideo">

 </div>
</body>
</html></div>