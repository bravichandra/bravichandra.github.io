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

<div id="top">
    
    <div class="wrapper">
        <div class="fluid">
        	<div class="grid4">
        		<h1 class="logo"><img src="<?php echo base_url();?>images/logo.jpg"/></h1>
        	</div>
        	<div class="grid8 textR" style="margin-top:8px;">
        		<a href="http://salesscripter.com/members/member" target="_blank" class="buttonM bRed opt"><span class="iconb" data-icon="&#xe1bb;"></span> &nbsp;Account Profile</a>
        	</div>
        	<!-- <div class="grid10 textR" style="margin-left: 91px;margin-top: -32px;">
        		<a href="<?php echo $gerenral_page_url;?>" class="buttonM bRed opt"><span class="iconb" data-icon="&#xe1bb;"></span> &nbsp;Home</a>
        	</div> -->
        </div>
    </div>

</div>
<!-- Top line ends -->
