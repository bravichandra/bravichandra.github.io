
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

        alert("test");

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
<title>Test1</title>
</head>

<body>
<form>
<table border="1" cellpadding="0" cellspacing="0" align="center">
<tr>
<td>Name</td>
<td><input type="text" id="textid" name="text1" value="" onBlur="getValid()"/></td></tr>
	<tr>
<td>Father Name</td>
<td><input type="text" id="textid3" name="text13" value="" /></td></tr>
<tr>
<td>Mother Name</td>
<td><input type="text" id="textid3" name="text13" value="" /></td></tr>
<tr>
<td>College Name</td>
<td><input type="text" id="textid3" name="text13" value="" /></td></tr>
<tr>
<td>City Name</td>
<td><input type="text" id="textid3" name="text13" value="" /></td></tr>
<tr>
<td>State Name</td>
<td><input type="text" id="textid3" name="text13" value="" /></td></tr>
<tr>
<td>Country Name</td>
<td><input type="text" id="textid3" name="text13" value="" /></td></tr>
<tr> <span id="text_valid"></span>
<td colspan="2" align="center"><input type="submit" name="submit" value="submit" />
	<tr> <span id="text_valid"></span>
<td colspan="2" align="center"><input type="submit" name="cancel" value="Cancel" />
</table>
</form>
</body>
	</html>


