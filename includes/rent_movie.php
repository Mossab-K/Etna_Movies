<?php

function 	movie_exists($imdb)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("movies");
	$criteria = array('imdb_code' => $imdb);
	$doc = $collection->findOne($criteria);
	if (!empty($doc))
		return 1;
	else
		return 0;
}

function 	movie_stock($imdb)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("movies");
	$criteria = array('imdb_code' => $imdb);
	$doc = $collection->findOne($criteria);
	return $doc['stock'];
}

function 	movie_rent($imdb)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("movies");
	$criteria = array('imdb_code' => $imdb);
	$doc = $collection->findOne($criteria);
	return $doc['renting_students'];
}

function 	rent_it($argv, $collectionmovie, $collectionstudents)
{
	if (is_rent($argv[2], $argv[3]) == 0)
	{
		echo "Error: This movie is already rented to this user !\n";
		return 0;
	}
	$stock = movie_stock($argv[3]) - 1;
	$tabs = movie_rent($argv[3]);
	$tabm = stud_rent($argv[2]);
	$tabs[] = student_getid($argv[2]);
	$tabm[] = movies_getid($argv[3]);
	$collectionmovie->update(array("imdb_code" => $argv[3]), 
		array('$set' => array("stock" => $stock)));
	$collectionmovie->update(array("imdb_code" => $argv[3]), 
		array('$set' => array("renting_students" => $tabs)));
	$collectionstudents->update(array("login" => $argv[2]), 
		array('$set' => array("rented_movies" => $tabm)));
	return 1;
}

function 	rent_movie($argc, $argv, $collection)
{
	if ($argc != 4)
	{
		echo "Error: Not enough arguments!\n";
		return 0;
	} else if (login_exists($argv[2]) == 0) {
		echo "Error: User does not exist !\n";
		return 0;
	} else if (movie_exists($argv[3]) == 0) {
		echo "Error: Movie does not exist !\n";
		return 0;
	} else {
		if (movie_stock($argv[3]) <= 0) {
			echo "Stock-out !\n";
			return 0;
		} else {
			$connection = new MongoClient();
			$db = $connection->db_etna;
			$collection2 = $db->selectCollection("students");
			$status = rent_it($argv, $collection, $collection2);
			if ($status != 0)
				echo "Rented !\n";
		}
	}
}