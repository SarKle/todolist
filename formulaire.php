<?php

$options=array(
  "tache" => FILTER_SANITIZE_STRING,
  "ajouter" => FILTER_SANITIZE_STRING,
  "boutton" => FILTER_SANITIZE_STRING,
  "tache_ligne" => FILTER_SANITIZE_STRING,
  "formafaire"=> FILTER_SANITIZE_STRING
  );
  $result = filter_input_array(INPUT_POST, $options);

    $_POST["ajouter"] = filter_var($_POST["ajouter"], FILTER_SANITIZE_STRING);
    $_POST["tache_ligne"] = filter_var($_POST["tache_ligne"], FILTER_SANITIZE_STRING);
    $_POST["tache"] = filter_var($_POST["tache"],FILTER_SANITIZE_STRING);
    $_POST["boutton"] = filter_var($_POST["boutton"],FILTER_SANITIZE_STRING);
    $_POST["formafaire"]=filter_var($POST["formafaire"],FILTER_SANITIZE_STRING);

$jsonURL="todo.json"; //source
$jsonReceived = file_get_contents($jsonURL); //prendre le fichier
$log = json_decode($jsonReceived, true); //décoder ( true = dans un tableau )
// @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  if (isset($_POST['ajouter']) AND end($log)['nomtache'] != $_POST['tache']){ //Si on appuie sur le boutton ajouter...
    $add_tache = $_POST['tache']; //je récupère la valeur que je veux ajouter
      $array_tache = array("nomtache" => $add_tache, // je la mets dans un tableau
                   "fin" => false);
    $log[] = $array_tache; // je crée un tableau multi dimensionnel
    $json_enc= json_encode($log, JSON_PRETTY_PRINT); // j'encore pour json ( avec passage à la ligne )
    file_put_contents($jsonURL, $json_enc); // j'envoie les données dans le json
    $log = json_decode($json_enc, true); // je décode le tout pour pouvoir le lire

  }
  if (isset($_POST['boutton'])){ //si j'enregistre ( je check la case )
    $choix=$_POST['tache']; // je récupère les valeurs checkée ("tache[]") des inputs ( qui sont alors dans un tableau )

  for ($init = 0; $init < count($log); $init ++){ // Pour chaque ligne du tableau
    if (in_array($log[$init]['nomtache'], $choix)){ // Je compare les valeurs checkée avec le tableau
// --> Si valeur de "nomtache" se trouve dans le tableau $choix alors...
      $log[$init]['fin'] = true; // Je transforme False en True
    }
  }
  $json_enc= json_encode($log, JSON_PRETTY_PRINT); // ///
// //
  file_put_contents($jsonURL, $json_enc); // /// :Same shit: //
// //
  $log = json_decode($json_enc, true); // ///
  }



?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- <link rel="stylesheet" href="style.css"> -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css?family=Mukta+Malar" rel="stylesheet">
<title>Pense-bete</title>
</head>
<body>
<div class="page">
  <section class="afaire">
    <h2>A faire</h2>
      <form action="formulaire.php" method="post" name="formafaire">
<?php
  foreach ($log as $key => $value){
//récupération valeur tableau multi dimension
    if ($value["fin"] == false){ // Si la valeur "fin" == false alors ...
      echo "<input type='checkbox' name='tache[]' value='".$value["nomtache"]."'/>
        <label for='choix'>".$value["nomtache"]."</label><br />"; // injecter input.//
    } // 'tache[]' en name pour..
  } // ..récupérer valeur checkée en tableau.
?>
  <input type="submit" name="boutton" value="check" >
    </form>
  </section>
  <section class="archive">
    <h2>Fait</h2>
      <form action="formulaire.php" method="post" name="formchecked">
<?php
  foreach ($log as $key => $value){
    if ($value["fin"] == true){
      echo "<input type='checkbox' name='tache[]' value='".$value."'checked/>
        <label for='choix'>".$value["nomtache"]."</label><br />";
    }
  }
?>
      </form>
  </section>
<hr>
<footer class="tache">
  <h2>Ajouter une tâche</h2>
    <form class="" action="formulaire.php" method="post">
<!-- <label for="tache">La tâche à effectuer</label> -->
      <input type="text" name="tache" value="">
      <input type="submit" name="ajouter" value="Ajouter">
    </form>
</footer>
</div>
</body>
</html>
