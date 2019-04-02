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
