<?php 
$erreur = false;
$idExiste = false;
$entree;

$tousLesId = explode(",", $_GET["tousLesId"]); 
unset($_GET["tousLesId"]);

// $premiereVisite permet de vérifier si c'est la première fois qu'on vient sur la page
if($_SERVER['REQUEST_METHOD'] == "POST"){
	foreach ($_POST as $name => $value){
		if($name == "id"){
			($value == null) ? $erreur = true : false;
		}

		if($name == "titre"){
			($value == null) ? $erreur = true : false;
		}

		if($name == "auteur"){
			($value == null) ? $erreur = true : false;
		}

		if($name == "maisonEdition"){
			($value == null) ? $erreur = true : false;
		}

		if($name == "lien"){
			($value == null) ? $erreur = true : false;
		}

		if($name == "listeType"){
			($value == null) ? $erreur = true : false;
		}

		if($name != "tousLesId"){
			$entree[$name] = $value;
		}
	}

	for ($i=0; $i < count($tousLesId) && !$idExiste; $i++) { 
		$idExiste = ($entree['id'] == $tousLesId[$i]) ? true : false; 
	}
		
	if($erreur){
		print ("Veuillez rentrer tous les champs obligatoires");
	}elseif($idExiste){
		print ("Ettt mémé l'id existe déjà!!!");
	}else{
		fopen("biblio.txt", 'a+');
		var_dump(filesize(file_get_contents("biblio.txt")));
		if(filesize(file_get_contents("biblio.txt"))){
			file_put_contents('./biblio.txt', "\n", FILE_APPEND);
		}
	  	file_put_contents('./biblio.txt', implode("\n", $entree), FILE_APPEND);
	  	$delimite = ($entree[9] == "") ? "\n" . "* * *": "* * *";
		file_put_contents('./biblio.txt', $delimite, FILE_APPEND);
		file_put_contents('./biblio.txt', $endOfFile, FILE_APPEND); //il faut l'enlever
		header("Location: index.php");
 		exit;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Biblio - Ajouter un livre</title>
</head>
<body>
	<p> Ajouter un livre </p>
	<form method = "POST">
		<label for = "id">Identifiant<input type = "text" name = "id" id = "id" 
			value = <?= $erreur ? $_POST['id'] : ""; ?>></label>
		
		<label for = "titre">Titre<input type = "text" name = "titre" id = "titre" 
			value = <?= $erreur ? $_POST['titre'] : ""; ?>></label>
		
		<label for = "auteur">Auteur(s)<input type = "text" name = "auteur" id = "auteur" 
			value = <?= $erreur ? $_POST['auteur'] : ""; ?>></label>
		
		<label for = "annee">Année de publication<input type = "text" name = "annee" id = "annee" 
			value = <?= $erreur ? $_POST['annee'] : ""; ?>></label>
		
		<label for = "maisonEd">Maison d'édition<input type = "text" name = "maisonEdition" id = "maisonEd" 
			value = <?= $erreur ? $_POST['maisonEdition'] : ""; ?>></label>
		
		<label for = "edition">Édition<input type = "text" name = "edition" id = "edition" 
			value = <?= $erreur ? $_POST['edition'] : ""; ?>></label>
		
		<label for = "lien">Lien<input type = "text" name = "lien" id = "lien" 
			value = <?= $erreur ? $_POST['lien'] : ""; ?>></label>
		
		<label for = "image">Lien de la couverture<input type = "text" name = "image" id = "image" 
			value = <?= $erreur ? $_POST['image'] : ""; ?>></label>
		
		<label for = "listeType">Type</label>
		<input name = "listeType" list = "types" id = "listeType" value = <?= $erreur ? $_POST['listeType'] : ""; ?>>
		<datalist id = "types">
			<option value = "L">
			<option value = "A">
			<option value = "P">
			<option value = "X">
		</datalist>
		<label for = "autreType">Autre type<input type = "text" name = "type" id = "autreType"
			value = <?= $erreur ? $_POST['type'] : ""; ?>></label>

		<input type="hidden" name="tousLesId" value= <?php implode("," , $tousLesId)  ?>>
		<button>Ajouter</button>

	</form>
</body>
</html>
