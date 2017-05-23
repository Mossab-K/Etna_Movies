<?php

function movies_storing($argc, $argv, $collection)
{
	$tab = null;
	if (($file = fopen("csv/movies.csv", "r"))) 
	{
		while (($data = fgetcsv($file, 1000, ',')) !== FALSE) 
			$tab[] = $data;

		fclose($file);
	}
	$tab_asso = get_asso_tab($tab);
	insert_movies($tab_asso, $collection);
}

function get_asso_tab($tab)
{
	$i = 1;
	$u = 0;
	$tab_asso[] = array();
	while (isset($tab[$i]))
	{
		$tab_asso[$u] = array_combine($tab[0], $tab[$i]);
		$i++;		
		$u++;		
	}
	return $tab_asso;
}

function insert_movies($tab, $c)
{	
	$stored = 0;
	for ($i = 0; isset($tab[$i]); $i++) {
		$tab_genres = explode(', ', $tab[$i]['Genres']);
		$tab_directors = explode(', ', $tab[$i]['Directors']);
		$stock = rand(0, 5);
		foreach($tab_genres as $index => $word)
				$tab_genres[$index] = trim($word);

		if (!$c->findOne(array('imdb_code' => $tab[$i]['const']))) {
			$doc = array(
						"imdb_code" => $tab[$i]['const'],
						"title" => $tab[$i]['Title'],
						"year" => intval($tab[$i]['Year']),
						"genres" => $tab_genres,
						"directors" => $tab_directors,
						"rate" => floatval($tab[$i]['IMDb Rating']),
						"link" => $tab[$i]['URL'],
						"stock" => $stock,
						"renting_students" => array()
						);
			if ($c->insert($doc))
				$stored++;
		}
	}
	echo $stored . " movies successfully stored !\n";
}
