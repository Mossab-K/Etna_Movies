(Un projet parmis d'autre en première année de prépa) 

README : Comment utiliser le service etna_movies ?
===================================================

DESCRIPTION
===========

NOM 					: ETNA_MOVIES

LANGAGES				: PHP et MongoDB

AUTEUR					: Mossab Kaimouni 

DESCRIPTION 			: Etna_movies est un service de location de de films 						   		     				 pour les etudiant de l'Etna.

UTILISATION
===========

STUDENTS
-------------------------------------------------------------------------------

- Ajouter un etudiant :
	Tapez : ./etna_movies.php add_student "le_login"

	(Le login doit contenir six lettres avant l'underscore 
	et une lettre ou un chiffre après celui-ci)


- Supprimer un etudiant :
	Tapez : ./etna_movies.php del_student "le_login"
	(Lors de la suppression de l'etudiant, les films qu'il a loués sont automatiquement retournés)


- Modifier une information d'un etudiant :
	Tapez : ./etna_movies.php update_student "le_login"

	Il vous sera demandé quelle information modifier :
	(What do you want to update?)
	> 
	
	(Tapez l'information à modifier age/nom/email/phone)
	> name

	(Tapez la nouvelle valeur)
	New name ?
	> "nouveau_nom"


- Afficher tous les etudiants
	Tapez : ./etna_movies.php show_student


- Afficher les informations d'un etudiant en particulier
	Tapez : ./etna_movies.php show_student "le_login"


MOVIES
-------------------------------------------------------------------------------

- Importer tous les films disponible à l'Etna :
	Tapez : ./etna_movies.php movies_storing


- Afficher tous les films dans l'ordre alphabetique
	Tapez : ./etna_movies.php show_movies


- Afficher tous les films dans l'ordre inverse
	Tapez : ./etna_movies.php show_movies desc


- Afficher les films par Genre
	Tapez : ./etna_movies.php show_movies genre "le_genre"


- Afficher les films par Année
	Tapez : ./etna_movies.php show_movies year "l_annee"


- Afficher les films par Note
	Tapez : ./etna_movies.php show_movies rate "la_note"


LOCATION
------------------------------------------------------------------------------

imd_code = Code unique attribué à chaque film. 
	(On se sert de ce code pour la location du film)


- Louer un film :
	Tapez : ./etna_movies.php rent_movie "le_login" "imdb_code_du_film"


- Rendre un film :
	Tapez : ./etna_movies.php return_movie "le_login" "imdb_code_du_film"


- Afficher tous les films loués
	Tapez : ./etna_movies.php show_rented_movies
