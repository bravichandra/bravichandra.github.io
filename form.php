
<!DOCTYPE html>
<html>
<head>
	<title>Test Master</title>
</head>
<body>


</body>
<script>
    function isEmpty(str){
        return !str.replace(/\s+/, '').length;
    }
    function getValid(){
			alert();

         var text=document.getElementById('textid').value;
         if(isEmpty(text)){
         document.getElementById("text_valid").innerHTML = "Enter Text";
         document.getElementById("textid").focus();
         }
         else{
         document.getElementById("textid").innerHTML = "";
         }       
    }
</script>
</html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test</title>
</head>

<body>
<form>
<table border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
<td>Name</td>
<td><input type="text" id="textid" name="text1" value="" onblur="getValid()"/></td></tr>
<tr><span id="text_valid"></span>
<td colspan="2" align="center"><input type="submit" name="submit" value="submit" />
</table>
</form>
</body
></html>


