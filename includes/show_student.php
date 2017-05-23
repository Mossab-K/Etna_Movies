<?php

function 	show_student($argc, $argv, $collection)
{
	if ($argc == 3)
	{
		if (preg_match("/^[A-z]{2,6}_[A-z0-9]$/", $argv[2]) != 1)
			echo "Error: Invalid login!\n";
		else
			show_gestion($argv[2], $collection);
	}
	else if ($argc == 2)
	{
		show_gestion(0, $collection);
	}
	else
		echo "Error: invalid usage\n";
}

function	show_gestion($login = NULL, $collection)
{
	if ($login === NULL || $login === 0)
		show_all_students($collection);
	else {
		if (login_exists($login) == 0)
		{
			echo "Error: User does not exist!\n";
			return 0;
		}
		else
			show_login_student($login, $collection);
	}
}

function 	show_all_students($collection)
{
	$cursor = $collection->find();
	$i = 0;
	foreach ($cursor as $doc)
	{
		if ($i % 2 == 0)
			echo "\033[31m";
		else
			echo "\033[32m";
		echo "[login : " . $doc['login'] . " , ";
		echo "name  : " . $doc['name'] . " , ";
		echo "age   : " . $doc['age'] . " , ";
		echo "email : " . $doc['email'] . " , ";
		echo "phone : " . $doc['phone'] . "]\033[0m\n";
		++$i;
	}
	echo "*$i*\n";
}

function 	show_login_student($login, $collection)
{
	$criteria = array('login' => $login);
	$doc = $collection->findOne($criteria);
	echo "===========================================================\n";
	echo "\033[32m||  login  :  " . $doc['login'] . "\n";
	echo "||  name   :  " . $doc['name'] . "\n";
	echo "||  age    :  " . $doc['age'] . "\n";
	echo "||  email  :  " . $doc['email'] . "\n";
	echo "||  phone  :  " . $doc['phone'] . "\n\033[0m";
	echo "===========================================================\n";
}