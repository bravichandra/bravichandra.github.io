<?php
$temp = end(explode('/',current_url()));
$tmpurl = str_replace("/".$temp,'/',current_url());//By Dev@4489 for IS Last ID
?>
<?php if(isset($csobjects)) {?>
<ul class="sub-dev-head-sub2 objection-responses-dev">
	<?php foreach($csobjects as $csov) {?>
    <li><a class="<?php if($temp==$csov['name']) echo 'active';?>" href="<?php echo $tmpurl.$csov['name'];?>"><?php echo $csov['title'];?></a></li>
    <?php }?>
</ul>
<?php }else{?>
<ul class="sub-dev-head-sub2 objection-responses-dev">
	<?php for($n=$obcstart;$n<=$obcend;$n++) {if(!isset($parts[$n]['title'])) continue;?>
    <li><a class="<?php if($temp==$parts[$n]['name']) echo 'active';?>" href="<?php echo $tmpurl.$parts[$n]['name'];?>"><?php echo $parts[$n]['title'];?></a></li>
    <?php }?>
</ul>
<?php }?>
<?php include_once('script_interactive.php'); ?>