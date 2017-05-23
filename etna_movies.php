#!/usr/bin/php
<?php

// ======================== USAGE ========================
if ($argc == 1) {
	echo "Wrong Usage!\n";
	return 0;
}
// ======================== USAGE ========================

// ======================== Librarie ========================
require_once("includes/supp_funcs.php");
require_once("includes/add_student.php");
require_once("includes/del_student.php");
require_once("includes/show_student.php");
require_once("includes/update_student.php");
require_once("includes/find_error.php");
require_once("includes/show_movies.php");
require_once("includes/movies_storing.php");
require_once("includes/rent_movie.php");
require_once("includes/return_movie.php");
require_once("includes/show_rented_movies.php");
// ======================== Librarie ========================

// ======================== Readline ========================
function     my_readline()
{
	echo "> ";
	$open = fopen("php://stdin", "r");
	$str = fread($open, 1024);
	fclose($open);

	return rtrim($str, "\n");
}
// ======================== Readline ========================

// ======================== Main ========================
function main($argv, $argc)
{
	$error = gestion_erreur($argv, $argc);
	$connection = new MongoClient();
	$db = $connection->db_etna;
	$collection = $db->selectCollection("students");

	if ($error === 1)
		return 0;
	else if ($error === 0)
		$argv[1]($argv[2], $collection);
	else if ($error === 3)
	{
		$collection = $db->selectCollection("movies");
		$argv[1]($argc, $argv, $collection);
	}
	else
		$argv[1]($argc, $argv, $collection);
}
// ======================== Main ========================

// ======================== Start ========================
main($argv, $argc);
// ========================  End  ========================