<?php	
    if($partid == $oblastid + 1)
	{
		include('about_us_data.php');
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'close',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
	else if($partid == $oblastid + 2)
	{
	 	include('common_problems_data.php');
	 	$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'close',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$noclose = false;
	}
	else if($partid == $oblastid + 3)
	{
		include('pre_qualify_data.php');
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'close',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$last_step = false;
	}
	else if($partid == $oblastid + 4)
	{
		include('close_data.php');
		$temp = end(explode('/',current_url()));
		$back_step = str_replace($temp,$parts[1]['name'],current_url());
		$front_step = str_replace($temp,'value-statement-intro',current_url());
		$fav_step = str_replace($temp,'close',current_url());
		$question_step = str_replace($temp,'',current_url());
		$last_step = false;
	}
?>