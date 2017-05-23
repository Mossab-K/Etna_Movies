<?php

function	del_student($login, $collection)
{
	if (login_exists($login) == 0)
	{
		echo "Error: User does not exist!\n";
		return 0;
	}
	echo "Are you sure ?\n";
	$answer = my_readline();

	while (($answer != "yes") && ($answer != "oui") 
		&& ($answer != "non") && ($answer != "no"))
	{
		echo "Answer with yes or no !\n";
		$answer = my_readline();
	}
	if ($answer == "yes" || $answer == "oui")
	{
		$status = delete($login, $collection);
		if ($status == 1)
			echo "User deleted !\n";
	}
	else if ($answer == "no" || $answer == "non")
	{
		return 0;
	}
}

function 	delete($login, $collection)
{
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$coll_movies = $db->selectCollection("movies");
	$coll_students = $db->selectCollection("students");
	$info_student = student_getall($login);
	$tab_movies = $info_student['rented_movies'];

	for ($i = 0; isset($tab_movies[$i]); $i++)
	{
		$id = $tab_movies[$i];
		$info_movie = $coll_movies->findOne(array(
	    '_id' => new MongoId($id)));
		del_student_to_movie($coll_movies, $info_movie, $info_student);
	}
	$criteria = array('login' => $login);
	$removestatus = $collection->remove($criteria);

	if ($removestatus != TRUE)
		echo "\033[1;31mFatal Error!\n\033[0;0m";
	else
		return 1;
}