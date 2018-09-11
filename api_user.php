<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");


$url = 'testtakers.json'; // path to JSON file
$data = file_get_contents($url); 
$users = json_decode($data); // decode the JSON feed


$users_array = (object) array();
$nb = 0;

if (isset($_GET['id']) && is_numeric($_GET['id']))
{
	foreach ($users as $key => $value) {

		$chaine = $value->picture; 
		$chaine = preg_replace('#api.#', '$1', $chaine);
		$chaine = preg_replace('#0.2#', 'api', $chaine);

		if ($value->gender == "female")
			$title = "mrs";
		else
			$title = "mr";
		if ($_GET['id'] == $key)
		{
			$users_array->userId = $nb;
			$users_array->login = $value->login;
			$users_array->password = $value->password;
			$users_array->title = $title;
			$users_array->lastName = $value->lastname;
			$users_array->firstName = $value->firstname;
			$users_array->gender = $value->gender;
			$users_array->email = $value->email;
			$users_array->picture = $chaine;
			$users_array->address = $value->address;
		}
		$nb++;
	}
}


exit(json_encode($users_array));


?>