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