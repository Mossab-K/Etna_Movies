<?php

function 	return_movie($argc, $argv, $collection)
{
	if ($argc != 4) {
		echo "Error: Not enough arguments !\n";
		return 0;
	}
	else if (login_exists($argv[2]) == 0) {
		echo "Error: User does not exist !\n";
		return 0;
	}
	else if (movie_exists($argv[3]) == 0) {
		echo "Error: Movie does not exist !\n";
		return 0;
	}
	else
	{
		$connection = new MongoClient();
		$db = $connection->db_etna;
		$status = check_and_return($argv[2], $argv[3], $db);
		if ($status != 0)
			echo "Returned\n";
	}
}

function 	check_is_rent($login, $imdb, $db)
{
	$coll_movies = $db->selectCollection("movies");
	$coll_students = $db->selectCollection("students");
	$info_student = student_getall($login);
	$info_movie = movies_getall($imdb);
		
	if (in_array($info_movie['_id'], $info_student['rented_movies'])
		&& in_array($info_student['_id'], $info_movie['renting_students']))
		return 1;
	else
		return 0;
}

function 	del_student_to_movie($coll_movies, $info_m, $info_student)
{
	$sav_tab = $info_m['renting_students'];

	for ($i = 0; isset($sav_tab[$i]); $i++ )
	{
		if ($sav_tab[$i] == $info_student['_id'])
			unset($sav_tab[$i]);
	}
	
	$sav_tab = array_values($sav_tab);
	$stock = movie_stock($info_m['imdb_code']) + 1;
	$coll_movies->update(array("imdb_code" => $info_m['imdb_code']),
			array('$set' => array("stock" => $stock)));

	if ($sav_tab != NULL)
	{
		$coll_movies->update(array("imdb_code" => $info_m['imdb_code']),
		array('$set' => array("renting_students" => $sav_tab)));
	}
	else
	{
		$coll_movies->update(array("imdb_code" => $info_m['imdb_code']),
		array('$set' => array("renting_students" => array())));
	}
}

function 	del_movie_to_student($coll_students, $info_movie, $info_student)
{
	$sav_tab = $info_student['rented_movies'];

	for ($i = 0; isset($sav_tab[$i]); $i++ )
	{
		if ($sav_tab[$i] == $info_movie['_id'])
			unset($sav_tab[$i]);
	}

	$sav_tab = array_values($sav_tab);

	if ($sav_tab != NULL)
	{
		$coll_students->update(array("login" => $info_student['login']),
		array('$set' => array("rented_movies" => $sav_tab)));
	}
	else
	{
		$coll_students->update(array("login" => $info_student['login']),
		array('$set' => array("rented_movies" => array())));
	}
}

function 	check_and_return($login, $imdb, $db)
{
	$coll_movies = $db->selectCollection("movies");
	$coll_students = $db->selectCollection("students");
	$info_student = student_getall($login);
	$info_movie = movies_getall($imdb);
		
	if (check_is_rent($login, $imdb, $db) == 1)
	{
		del_student_to_movie($coll_movies, $info_movie, $info_student);
		del_movie_to_student($coll_students, $info_movie, $info_student);
		return 1;
	}
	else 
	{
		echo "Error: This movie is not rented by this user !\n";
		return 0;
	}
}
?>