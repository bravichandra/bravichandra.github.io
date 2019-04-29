(function() {

// Localize jQuery variable
//var jQuery;

/******** Load jQuery if not present *********/
if (window.jQuery === undefined) {
    var script_tag = document.createElement('script');
    script_tag.setAttribute("type","text/javascript");
    script_tag.setAttribute("src",
        "//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js");
    if (script_tag.readyState) {
      script_tag.onreadystatechange = function () { // For old versions of IE
          if (this.readyState == 'complete' || this.readyState == 'loaded') {
              scriptLoadHandler();
          }
      };
    } else { // Other browsers
      script_tag.onload = scriptLoadHandler;
    }
    // Try to find the head, otherwise default to the documentElement
    (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
} else {
    // The jQuery version on the window is the one we want to use
    jQuery = window.jQuery;
    main();
}

/******** Called once jQuery has loaded ******/
function scriptLoadHandler() {
    // Restore $ and window.jQuery to their previous values and store the
    // new jQuery in our local jQuery variable
    jQuery = window.jQuery.noConflict(true);
    // Call our main function
    main(); 
}

/******** Our main function ********/
function main() { 
    jQuery(document).ready(function($) { 
        // We can use jQuery 1.4.2 here
       	console.log("Widget loaded");
       	/*var widget_url = "https://salesscripter.com/betapro/widget/forms/2?callback=?"
		jQuery.getJSON(widget_url, function(data) {
		  jQuery('#example-widget-container').html(data);
		});*/


		/*$.ajax({
			url: "https://salesscripter.com/betapro/widget/ssform/2",
			dataType: "jsonp",
			jsonpCallback: "logResults"
	    });*/

	    var ssjsurl = document.getElementById("ssScriptSrc").src;
	    var ssjsurlA = ssjsurl.split("?");
	    var ssFormid = ssjsurlA[1];
	    //var ssFormid2 = ssFormid.split("&");
	    //ssFormid = ssFormid2[0];

	    jQuery.getJSON("//salesscripter.com/pro/widget/ssform/"+ssFormid+"?callback=?",function(json){
		  	//console.log(json);
		  	jQuery("#ssListForm").html(json.html);		  	
		  	jQuery("#ssFrmList").submit(function(){
			    console.log("Form submitted.");

			    $.ajax({ 
		            type: 'GET', 
		            cache: false,
		            dataType: "jsonp",
		            data: jQuery(this).serialize(),
		            url: "//salesscripter.com/pro/widget/ssformPost/"+ssFormid,
		            success: function(resp){  
		            	//console.log(resp);
		            	jQuery("#ssFormResult").html(resp.msg);

		            	if(resp.status==true) {
		            		//$("#ssFrmList").reset();
		            		$("#ssFrmList .ssforminput").each(function(){
						        $(this).val('');
						    });    
		            	}
		            }, 
		            error: function(xhr,textStatus,error){
		            	jQuery("#ssFormResult").html("Unable to submit form, please try again.");
		            	//console.log(xhr);
		            	//console.log(textStatus);
		            	//console.log(error);          
		                //$(".loader").html('');
		                //ajtimer = setTimeout(do_crawl, 5000);
		            }
		        });
			    
			    return false;
			});

		});
	});
}


/*function logResults(json){
	console.log(json);
}*/




})(); // We call our anonymous function immediately