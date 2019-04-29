<div class="main-wrapper crmlite">
        <div class="quatabs">
            <div class="active first">
                <a href="javascript:void(0);" rel="box1">
                   Export CRM Contacts
                </a>
            </div>
            <div class="second">
                <a href="javascript:void(0);" rel="box2">
                    Export CRM Accounts
                </a>
            </div>
        </div>
        <div class="quaboxes">
              <div id="box1" class="active">
                    <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100% !important;">
                        <tr>
                            <td style="padding:10px;">
                                 Export CRM Contacts: <a href='<?= base_url() ?>crm/exportContactCSV' class="buttonM bBlue">Export</a>
                            </td>
                        </tr>        
                    </table>
              	   
              </div>
              <div id="box2">
                   <table cellpadding="0" cellspacing="0" border="0" class="contact-edit" id="settings" style="margin-top: 0px;margin-bottom: 0px; width:100% !important;">
                        <tr>
                            <td style="padding:10px;">
                                 Export CRM Accounts: <a href='<?= base_url() ?>crm/exportAccountCSV' class="buttonM bBlue">Export</a>
                            </td>
                        </tr>        
                    </table>
              </div>
        </div>
  </div>
</div>
<script type="text/javascript">
	$( document ).ready(function() { 
		$('.quatabs a').click(function(e){
			$('.quatabs div').removeClass("active");
			$(this).parent().addClass("active");
			$('.quaboxes div').removeClass("active");
			$('.quaboxes #'+$(this).attr("rel")).addClass("active");
		});
	}); 
</script>