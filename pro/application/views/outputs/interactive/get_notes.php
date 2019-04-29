<?php
echo '<h1 align="center">Notes</h1>';
if(isset($action) && $action=="LogCall") $_POSTDATA = $postdata;
else $_POSTDATA = $_POST;
$dpartids = json_decode($_POSTDATA['partids']);
foreach($dpartids as $dpartid)
{
	if($_POSTDATA[$parts[$dpartid]['name']])
	{
?>
	<ul style="font-weight:bold; font-size:14px; font-family:Arial, Helvetica, sans-serif"><?php echo $parts[$dpartid]['title'];?>
		<li style="font-weight:normal; list-style:disc;margin-left:40px">
			<?php
				$dam = $_POSTDATA[$parts[$dpartid]['name']];
				$dam = str_replace("\n","<br/>",$dam);
				echo $dam;
			?>
		</li>
	</ul>
<?php }
 } 
?>