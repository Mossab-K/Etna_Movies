<?php

function 	show_rented_movies($argc, $argv, $collection)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection2 = $db->selectCollection("students");
	$doc = $collection2->find();
	$i = 0;
	foreach ($doc as $key)
	{
		$movies = $collection->find();
		foreach ($movies as $films)
		{
			if (in_array($films['_id'], $key['rented_movies']))
			{
				echo $films['title'] . "\n";
				++$i;
			}
		}
	}
	echo "*$i*\n";
}

function 	student_getall($login)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("students");
	$criteria = array('login' => $login);
	$doc = $collection->findOne($criteria);
	return $doc;
}

function 	movies_getall($imdb)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("movies");
	$criteria = array('imdb_code' => $imdb);
	$doc = $collection->findOne($criteria);
	return $doc;
}
?>