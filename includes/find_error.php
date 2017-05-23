<?php

function 	login_exists($login)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("students");

	$criteria = array('login' => $login);

	$doc = $collection->findOne($criteria);
	if (!empty($doc))
		return 1;
	else
		return 0;
}

function 	funcs_array($number)
{
	if ($number == 1)
		$tab = array("add_student", "del_student",
		"update_student", "show_student");
	if ($number == 2)
		$tab = array("movies_storing", "show_movies", "rent_movie",
			"return_movie", "show_rented_movies");
	return $tab;
}

function	gestion_erreur($argv, $argc)
{
	if (in_array($argv[1], funcs_array(1)) == 1) {
		if ($argc >= 2 && $argv[1] == "show_student") {
			return 2;
		} else if ($argc != 3) {
			error_message(100, $argv);
			return 1;
		} else {
			if (preg_match("/^[A-z]{2,6}_[A-z0-9]$/", $argv[2]) != 1) {
				if ($argc == 3)
					error_message(102, $argv);
				else
					error_message(0, $argv);
				return 1;
			}
		}
	}
	else if (in_array($argv[1], funcs_array(2)) == 1)
		return 3;
	else {
		error_message(101, $argv);
		return 1;
	}
	return 0;
}

function 	error_message($code, $argv)
{
	switch ($code)
	{
		case 100:
		echo "Error: not enough arguments.\n";
		break;
		case 101:
		echo "Error: " . $argv[1] . ": command not found\n";
		break;
		case 102:
		echo "Error: " . $argv[2] . ": invalid argument\n";
		break;
		case 0:
		echo "Error: invalid usage\n";
		break;
	}
	return 0;
}