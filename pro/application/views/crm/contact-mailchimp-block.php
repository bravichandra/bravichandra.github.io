<div class="mc-info"></div>
<script type="text/javascript">
    //Add to Mailchimp
    function mailchimp_add_contact(){
        $(".loader").html('');

        if($("#mc_list_id").val()=="") {
            alert("MailChimp List required");
            $("#mc_list_id").focus();
            return false;
        }

        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');

        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          dataType: 'json',
          data: 'mctype=addcontact&listid='+$("#mc_list_id").val()
            }).done(function( resp ) {
                $(".loader").html('');
                alert(resp.message);
                if(resp.status==true) location.replace("<?php echo current_url();?>");
          })
          .fail(function() {
            alert( "Unable to process, please try again" );
          });
        return false;
    }
    //Remove contact from Mailchimp
    function mailchimp_delete_contact(lid){
        $(".loader").html('');

        if(lid=="") {
            alert("MailChimp list id required");
            return false;
        }
        if(!confirm('Are you sure you want to delete this contact from list?')) return false;

        $(".loader").html('<img src="<?php echo base_url();?>images/spinner.gif" />');

        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          dataType: 'json',
          data: 'mctype=delcontact&listid='+lid
            }).done(function( resp ) {
                $(".loader").html('');
                alert(resp.message);
                if(resp.status==true) location.replace("<?php echo current_url();?>");                
          })
          .fail(function() {
            alert( "Unable to process, please try again" );
          });
        return false;
    }
    //Hide Fade
    function hide_mclist(){
        $("#mailchimplistpopup").hide();
        $(".overlayBackground").hide();
    }
    //Popup
    function mclist_popup(catg_act) {      
        $("#mailchimplistpopup").show();
        $(".overlayBackground").show();
    }
    //get Mailchimp inf
    function getMailchimpInfo(){
        $(".mc-info").html('');
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          data: 'mctype=mcinfo'
            }).done(function( resp ) {
                $(".mc-info").html(resp);
                $("#mc_list_id").uniform();
          })
          .fail(function() {
            $(".mc-info").html('');
          });
        return false;
    }

    //get Mailchimp inf
    function getContactChilds(){
        //$(".contact-childs").html('');
        $(".contact-childs1").hide();
        $("#Lists").hide();
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          data: 'ccblock=contactchilds'
            }).done(function( resp ) {
                //$(".contact-childs").html(resp);
                $(".contact-childs").hide().html(resp).fadeIn('slow');
                $(".contact-childs1").fadeIn('slow');
				//$("#Loader").hide();
				//$("#Lists").show();
          })
          .fail(function() {
            $(".contact-childs").html('');
            $(".contact-childs1").fadeIn('slow');
			//$("#Loader").hide();
			//$("#Lists").show();
          });
        return false;
    }
    //get Mailchimp inf
    function getContactChilds1(){
        //$(".contact-childs1").html('');
        $("#Lists").hide();
        $.ajax({
          type: "POST",
          url: "<?php echo current_url();?>",
          cache: false,
          data: 'ccblock=contactchilds1'
            }).done(function( resp ) {
                //$(".contact-childs").html(resp);
                $(".contact-childs1").html(resp);
        //$("#Loader").hide();
        $("#Lists").fadeIn('slow');
          })
          .fail(function() {
            $(".contact-childs1").html('');
      //$("#Loader").hide();
      $("#Lists").fadeIn('slow');
          });
        return false;
    }
    getContactChilds();
    getContactChilds1();
    getMailchimpInfo();
</script>