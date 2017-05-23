<?php

function 	show_movies($argc, $argv, $collection)
{
	if ($argc == 2)
		movies_show($collection);
	else if ($argc == 4) {
		switch (strtolower($argv[2])) {
			case "rate":
			movies_rate($argv[3], $collection);
			break;
			case "year":
			movies_year($argv[3], $collection);
			break;
			case "genre":
			movies_genre(strtolower($argv[3]), $collection);
			break;
			default:
			echo "Invalid Argument!\n";
			break;
		}
	}
	else if ($argc == 3 && strtolower($argv[2]) == "desc")
		movies_desc($collection);
	else {
		echo "Invalid Argument!\n";
		return 0;
	}
}

function 	movies_rate($rate, $collection)
{
	$cursor = $collection->find();
	$i = 0;

	foreach ($cursor as $doc)
	{
		if ($doc['rate'] >= $rate && $doc['rate'] < $rate + 1)
		{
			echo "Titre: \033[1;31m" . $doc['title'] .
			"\033[0;0m  Rate: \033[1;32m" .
			$doc['rate'] . "\033[0;0m Imdb: \033[1;31m" .
			$doc['imdb_code'] . "\033[0;0m\n";
			++$i;
		}
	}
	echo "*$i*\n";
}

function 	movies_year($year, $collection)
{
	$cursor = $collection->find();
	$i = 0;
	foreach ($cursor as $doc) {
		if ($doc['year'] == $year) {
			echo "Titre: \033[1;31m" . $doc['title'] .
			"\033[0;0m  Year: \033[1;32m" .
			$doc['year'] . "\033[0;0m Imdb: \033[1;31m" .
			$doc['imdb_code'] . "\033[0;0m\n";
			++$i;
		}
	}
	echo "*$i*\n";
}

function 	movies_genre($genre, $collection)
{
	$cursor = $collection->find();
	$i = 0;
	foreach ($cursor as $doc)
	{
		if (in_array($genre, $doc['genres']))
		{
			$multi_genre = implode(',', $doc['genres']);
			echo "Titre: \033[1;31m" . $doc['title'] .
			"\033[0;0m  Genres: \033[1;32m" . $multi_genre .
			"\033[0;0m Imdb: \033[1;31m" . $doc['imdb_code'] . "\033[0;0m\n";
			++$i;
		}
	}
	echo "*$i*\n";
}

function 	movies_desc($collection)
{
	$cursor = $collection->find();
	$i = 0;
	$titres = array();
	foreach ($cursor as $doc)
	{
		$titres[] = $doc['title'];
	}
	rsort($titres);
	foreach ($titres as $key)
	{
		echo "Titre: \033[1;31m" . $key . "\033[0;0m\n";
		++$i;
	}
	echo "*$i*\n";
}