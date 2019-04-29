<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Nexus</title>
<script>
function sessionSubmit()
{
	var name = $("#session_name").val();
	if(name == '' || name == null)
	{
		alert('Please insert session name.');
		return false;
	}

	$.ajax({
		  type: "POST",
		  url: BASE_URL + 'home/updateSession/',
		  data: 'session_name='+name,
		  cache: false,
		  dataType: 'json',
		  success: function(response)
		  {
		  	  //console.log(response);
			  $(".session_dialog").dialog("close");

			  $("#frm-input").submit();
			  
		  }
		});

}
</script>
</head>

<body>
		<form id="frm-session" name="frm-session" action="<?php echo base_url();?>home/updateSession" method="post">
			  <table cellpadding="0" cellspacing="0" width="100%" class="tDefault">            
                        <tbody>
							<tr>
                                <td class="no-border"><h6>Session Name</h6></td>
                                <td class="no-border" style="width: 40em;">
                                	<input type="text" name="session_name" id="session_name"/>
                                </td>
                            </tr>

                        </tbody>
		       </table>
		       <div class="fluid" style="margin-top:15px;" align="center">
		       		<input type="button" class="buttonM bRed" value="Save" onclick="sessionSubmit();"/>
		       </div>
		</form>
</body>
</html>