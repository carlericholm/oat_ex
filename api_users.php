<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");


$url = 'testtakers.json'; // path to JSON file
$data = file_get_contents($url); // put the contents of the file into a variable
$users = json_decode($data); // decode the JSON feed

$users_array = array();
$nb = 0;


function users_param($users, $limit, $offset, $name)
{
	$users_array = array();

// //////////////////////////////////////////// Does not work when trying to replace the value of the filter in the UI


// 	// if (isset($name))
// 	// {
// 	// 	$nb = 0;
// 	// 	$count = 1;
// 	// 	while ($nb < sizeof($users))
// 	// 	{
// 	// 		if ($name == $users[$nb]->lastname)
// 	// 		{
// 	// 			$temp = array("userId" => $nb, "firstName" => $users[$nb]->firstname, "lastName" => $users[$nb]->lastname);
// 	// 			array_push($users_array, $temp);
// 	// 			if ($count >= $limit)
// 	// 			{
// 	// 				return $users_array;
// 	// 			}
// 	// 			$count++;
// 	// 		}
// 	// 		$nb++;
// 	// 	}
// 	// 	return $users_array;
// 	// }
// ///////////////////////////////////////////// Does not work when trying to replace the value of the filter in the UI


	if (!isset($offset))
		$offset = 0;
	if ($offset >= 0) 
	{
		$count = 1;
		if ($limit == 0)
			exit;
		while ($offset < sizeof($users))
		{
			$temp = array("userId" => $offset, "firstName" => $users[$offset]->firstname, "lastName" => $users[$offset]->lastname);
			array_push($users_array, $temp);
			if ($count >= $limit)
				return $users_array;
			$offset++;
			$count++;
		}
		return $users_array;
	}

}

foreach ($users as $key => $value) {
	$temp = array("userId" => $nb, "firstName" => $value->firstname, "lastName" => $value->lastname);
	$nb++;
	array_push($users_array, $temp);
}

if (empty($_GET)) 
{
	exit(json_encode($users_array));
}
else
{
	if ((isset($_GET['offset']) && is_numeric($_GET['offset'])) || (isset($_GET['limit']) && is_numeric($_GET['limit'])) || 
		isset($_GET['name']))
	{
		exit(json_encode(users_param($users, $_GET['limit'], $_GET['offset'], $_GET['name'])));
	}
}

?>