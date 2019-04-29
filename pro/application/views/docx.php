<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>SalesScripter</title>
  <script src="<?php echo base_url();?>js/jquery.js"></script>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script src="<?php echo base_url();?>js/FileSaver.js"></script>
  <script src="<?php echo base_url();?>js/html-docx.js"></script>
</head>
<body>
  <div style="visibility: hidden;">
    <textarea id="content" cols="60" rows="10"><?php echo $html;?></textarea>
  
    <div class="page-orientation">
      <span>Page orientation:</span>
      <label><input type="radio" name="orientation" value="portrait">Portrait</label>
      <label><input type="radio" name="orientation" value="landscape" checked>Landscape</label>
    </div>
    <button id="convert">Convert</button>
  </div>
  <script>
    tinymce.init({
      selector: '#content',
      plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen fullpage",
        "insertdatetime media table contextmenu paste"
      ],
      init_instance_callback : "myCustomInitInstance",
      toolbar: "insertfile undo redo | styleselect | bold italic | " +
        "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | " +
        "link image"      
    });
    document.getElementById('convert').addEventListener('click', function(e) {
      e.preventDefault();
      convertImagesToBase64()
      // for demo purposes only we are using below workaround with getDoc() and manual
      // HTML string preparation instead of simple calling the .getContent(). Becasue
      // .getContent() returns HTML string of the original document and not a modified
      // one whereas getDoc() returns realtime document - exactly what we need.
      var contentDocument = tinymce.get('content').getDoc();
      var content = '<!DOCTYPE html>' + contentDocument.documentElement.outerHTML;
      var orientation = document.querySelector('.page-orientation input:checked').value;
      var converted = htmlDocx.asBlob(content, {orientation: orientation});

      saveAs(converted, '<?php echo $file;?>.docx');

    });

    function convertImagesToBase64 () {
      contentDocument = tinymce.get('content').getDoc();
      var regularImages = contentDocument.querySelectorAll("img");
      var canvas = document.createElement('canvas');
      var ctx = canvas.getContext('2d');
      [].forEach.call(regularImages, function (imgElement) {
        // preparing canvas for drawing
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        canvas.width = imgElement.width;
        canvas.height = imgElement.height;

        ctx.drawImage(imgElement, 0, 0);
        // by default toDataURL() produces png image, but you can also export to jpeg
        // checkout function's documentation for more details
        var dataURL = canvas.toDataURL();
        imgElement.setAttribute('src', dataURL);
      })
      canvas.remove();
    }

    function myCustomInitInstance(inst) {
        //alert("Editor: is now initialized.");
        $("#convert").trigger("click");
    }

    $(document).ready(function(){ 
      //console.log("2. Download word file");
      //$("#convert").trigger("click");        
    });
  </script>
</body>
</html>
