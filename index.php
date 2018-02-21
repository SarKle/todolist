<?php
if(isset($_POST["tache"])){
//récuprer les données
$todo=$_POST['tache'];
//sanitizer
$todo_clean=filter_var($todo, FILTER_SANITIZE_STRING);
//fichier json
$url="todo.json";
//preciser d'ou les données seront prises
$datareceived=file_get_contents($url);
//decoder le json
$log=json_decode($datareceived);
//mettre un array avec les données
$log []= $todo_clean;
//réencoder les données en json
$datasent=json_encode($log);
//mettre les données dans le json
file_put_contents($url,$datasent);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Allez en route!</title>
</head>
<body>
  <section class="container">
    <h1>Allez en route!</h1>
      <section class="A_faire">
        <h3> A FAIRE </h3>
<?php
  foreach ($log as $key => $value) {
      echo "<input type='checkbox' name='check' value=".$value.">".$value."<br>";
  }
?>
  <form action="index.php" method="post">
    <input type="submit" name="enregistrer" value="Fait">
  </form>
      </section>

        <h3> FAIT </h3>
<?php

echo "<input type=\"checkbox\" id=". $key .">" . $value["tache"] . "<br>";
?>


        <textarea name="tache" id="tache" rows="1" cols="30"> </textarea>
        <input type="submit" name="ajouter" value="Ajouter une tâche">
  </body>
</html>
