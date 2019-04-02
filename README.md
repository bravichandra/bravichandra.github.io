<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
<script>
    function isEmpty(str){
        return !str.replace(/\s+/, '').length;
    }
    function getValid(){
         var text=document.getElementById('textid').value;
         if(isEmpty(franch_Name)){
         document.getElementById("textid").innerHTML = "Enter Text";
         document.getElementById("text_name").focus();
         }
         else{
         document.getElementById("textid").innerHTML = "";
         }       
    }
</script>
</html>
