<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Nexus</title>
<script>
function invitationSubmit()
{
	var email = $("#email").val();

	
	if(email == '' || email == null)
	{
		alert('Please insert E-mail Address.');
		return false;
	}

	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/invitationEmail/',
		  data: 'email='+email,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
		  	  //console.log(response);
			  $(".invitation_dialog").dialog("close");
			  window.location.href = BASE_URL + 'folder/team-folder';
			  
		  }
		});
}
</script>
</head>

<body>
		<form id="frm-session" name="frm-session" action="<?php echo base_url();?>home/invitationEmail" method="post">
			  <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">            
                        <tbody>
							<tr>
                                <td class="no-border"><h6>E-mail Address</h6></td>
                                <td class="no-border" style="width: 40em;">
                                	<input type="text" name="email" id="email"/>
                                </td>
                            </tr>

                        </tbody>
		       </table>
		       <div class="fluid" style="margin-top:15px;" align="center">
		       		<input type="button" class="buttonM bRed" value="Submit" onclick="invitationSubmit();"/>
		       </div>
		</form>
</body>
</html>