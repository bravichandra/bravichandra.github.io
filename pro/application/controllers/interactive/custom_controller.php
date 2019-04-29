<?php
	$pks = array_keys($parts);
	sort($pks);
	$oblastid = end($pks);
	$parts[$oblastid+1]=array('name'=>'about-us','title'=>'Company and Product Info');
	$parts[$oblastid+2]=array('name'=>'common-problems','title'=>'Examples of Common Problems');
	$parts[$oblastid+3]=array('name'=>'pre-qualifying-questions','title'=>'Pre Qualifying Questions');
	$parts[$oblastid+4]=array('name'=>'close','title'=>'Close');
?>