<?php 
$next_page= $page + 1;
if($page == 'register' and $page != '0')
{
	$next_page = '0';
}

?>
<?php //echo 'Page ' . $page;echo 'Next Page ' . $next_page;?>
<?php 

$user_id = get_cookie('user_id');
if (!empty($user_id))
{
$gerenral_page_url = base_url() . 'home/index/' . $user_id;
}
else 
{
	$gerenral_page_url = base_url() . 'home/';
}
?>

<!-- Top line begins -->
<div class="logo"><img src="<?php echo base_url();?>images/logo.jpg"/></div>
<div class="head-menu">
    <form action="<?php echo base_url('crm/searchall');?>" id="frmgsearch" method="post">
        <input type="text" name="gskey" class="gskey" placeholder="Search" title="Search Contacts, Accounts, Applicants, Employees" value="<?php if(isset($gskey)) echo $gskey?>"/>
    </form>
	<?php //User notifcations?>
    <a href="javascript:void(0);" class="enotify" title="Notifications"><i class="iconn icon-flag-2" data-icon="&#xe1bb;"></i><?php if(isset($user_notifiys) && $user_notifiys['ncount']) {?><span class="notification-counter"><?php echo $user_notifiys['ncount'];?></span><?php }?></a>
    <div id="crm-notify">                	
        <div class="nbar">
            <div class="abox1">Notifications</div>
            <div class="abox2"><a href="javascript:void(0)" id="enotfclose" onclick="notify_close();" class="ui-icon ui-icon-closethick"></a></div><br clear="all" />
        </div>
        <div class="enotify-box">
        <?php 
			$nid = 0;
            if(isset($user_notifiys) && $user_notifiys['nlist']) {			
            foreach($user_notifiys['nlist'] as $notif){$nid=$notif->nid;?>
        <div class="row<?php if($notif->view=='0')echo " enshade";?>"><?php echo $notif->info;?> on <span class="entfdate"><?php if($notif->view=='0')echo "<b>";echo date("m/d/Y h:i A",strtotime($notif->datetime));if($notif->view=='0')echo "</b>";?></span></div>
        <?php }?>
        <?php /*?><div class="row more" align="center"><a href="javascript:void(0);" onclick="notify_more(<?php echo $nid;?>)"><b>View More</b></a></div><?php */?>
        <?php } else {?>
        <div class="row">No notifications</div>
        <?php }?>
        </div>
    </div>
    <script type="text/javascript">
        var notifys_viewd=<?php echo (isset($user_notifiys) && $user_notifiys['ncount']?0:1);?>;
		//View more notifications
		function notify_more(pgno) {
			$(".enotify-box div.more").html('<img src="<?php echo base_url();?>images/spinner.gif" />');
			$.ajax({
			  type: "POST",
			  cache: false,
			  data: {pageNo:pgno},
			  url: "<?php echo base_url();?>crm/getusr_notifys"
				}).done(function( response ) {
					$(".enotify-box div.more").remove();
					$(".enotify-box").append(response);
				});
		}
        //close notifications
        function notify_close(){
            $('#crm-notify').hide();
            $(".enotify-box div.enshade").removeClass('enshade');
        }
        $(document).ready(function(){
            $(".enotify").click(function(){
                $("#crm-notify").css("right",($(window).width()-parseInt($(".enotify").offset().left)-30)+"px");
                $("#crm-notify").show();				
                if(notifys_viewd==0) {
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url();?>crm/clear_notifys"
                        }).done(function( data ) {notifys_viewd=1;$('.enotify .notification-counter').hide();});
                }
            });            
        });
    </script>
    <a href="/members/member" title="Membership Area" class="amconfing"><i class="iconn icon-settings" data-icon="&#xe1bb;"></i></a>
    <?php /*?><a href="/members/member" target="_blank" class="buttonM bRed opt"><span class="iconb" data-icon="&#xe1bb;"></span> &nbsp; Membership Area</a><?php */?>
</div>
<!-- Top line ends -->
<?php if($this->session->flashdata('flashInfo')):?>
<div class='flashMsg flashInfo' style="text-align: center;width: 100%;position: absolute;top: 50px;color: red;font-weight: bold;z-index: 2000;"><?php echo $this->session->flashdata('flashInfo');?></div>
<?php endif?>
