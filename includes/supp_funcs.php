<?php

function 	stud_rent($login)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("students");
	$criteria = array('login' => $login);
	$doc = $collection->findOne($criteria);
	return $doc['rented_movies'];
}

function 	movies_show($collection)
{
	$cursor = $collection->find();
	$i = 0;
	$titres = array();
	foreach ($cursor as $doc)
	{
		$titres[] = $doc['title'];
	}
	sort($titres);
	foreach ($titres as $key)
	{
		echo "Titre: \033[1;31m" . $key . "\033[0;0m\n";
		++$i;
	}
	echo "*$i*\n";
}

function 	is_rent($login, $imdb)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("students");
	$criteria = array('login' => $login);
	$doc = $collection->findOne($criteria);
	if (in_array(movies_getid($imdb), $doc['rented_movies']))
		return 0;
	else
		return 1;
}

function 	student_getid($login)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("students");
	$criteria = array('login' => $login);
	$doc = $collection->findOne($criteria);
	return $doc['_id'];
}

function 	movies_getid($imdb)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("movies");
	$criteria = array('imdb_code' => $imdb);
	$doc = $collection->findOne($criteria);
	return $doc['_id'];
}