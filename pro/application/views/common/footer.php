<?php $this->load->view('help/help');?>

<!-- Start Footer line begins -->

<div align="center" id="bottom" style="border-top: 1px solid #DFDFDF !important;clear:both;">

	<div class="fluid" align="center" style="margin-top: 15px;">Copyright <?php echo date("Y");?> SalesScripter, LLC &nbsp;&nbsp; <a href="http://salesscripter.com/terms-of-services/" target="_blank">Terms of Use and Privacy</a> </div> 

</div>

<div class="pleasewait" style="display:none;position: absolute;" >

<img src="<?php echo base_url()."images/spinner.gif" ?>"  />

</div>



<script type="text/javascript">

  window.intercomSettings = {

    app_id: "z03kj2f1"

  };

</script>

<script type="text/javascript">(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/z03kj2f1';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>



<!-- End Footer line ends -->



<!-- RingCentral -->

<?php

$ringCentral = $this->home->getUserData([

    'user_id'=>$this->_user_id,

    'field_type'=>'ringcentral'

]);

$rc = unserialize($ringCentral[0]->value);

if( $rc['display'] == 1 ){

?>

<script>

    (function () {

        var rcs = document.createElement('script');

        rcs.src = 'https://salesscripter.com/pro/ringcentral/adapter.js?notification=1&disableConferenceCall=false&disableActiveCallControl=false';

        var rcs0 = document.getElementsByTagName('script')[0];

        rcs0.parentNode.insertBefore(rcs, rcs0);

    })();

</script>

<?php } ?>

<!-- End RingCentral -->

</body>

</html>