<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_POST["choix"] == "non"){
		header("Location: index.php");
		exit;
	}else{
		$ouvrages = array_chunk(array_map('rtrim', file('./biblio.txt')), 11);
		$index = 0;
		fopen("biblio.txt", "w+");
		foreach ($ouvrages as $ouvrage) {
			if($ouvrage[0] != $_GET['id']){
				$ouvrageImploder = implode("\n", $ouvrage);
				file_put_contents("./biblio.txt",  $ouvrageImploder, FILE_APPEND);
				if(count($ouvrages) > 2){
					if($index != (count($ouvrages) -1)){
						file_put_contents("./biblio.txt", "\n", FILE_APPEND);
					}
				}
			}
			$index++;
		}

		fclose("biblio.txt");
		header("Location: index.php");
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h4>Etes-vous sûr?</h4>
	<form method="POST">
		<label for="oui">Oui
		<input type="radio" name="choix" value="oui" id="oui">
		</label>
		<label for="non">Non
		<input type="radio" name="choix" value="non" id="non">
		</label>
		<button>valider</button>
	</form>
</body>
</html>