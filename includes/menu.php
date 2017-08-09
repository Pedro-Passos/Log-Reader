<?php
	#HO 6 extra using a function to create the unordered list
	#no need to include/functions.php as already included in parent html files
	$menu = array(); #slide 9
	$menu['index.php'] = 'Welcome';
	$menu['people.php'] = 'People';
	$menu['weather.php'] = 'Weather';
	$menu['strings.php'] = 'Strings'; #new in week 3
	#slide 22 on Foreach loops
	$menu = make_menu($menu); #defined in include/functions.php
	echo '<p>' . $menu . '</p>';
	
?>