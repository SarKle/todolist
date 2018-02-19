<?php
$todo=$_POST['tache'];
if (isset($_POST['ajouter'])) {
$todo_clean = filter_var ( $todo, FILTER_SANITIZE_STRING);
trim($todo_clean);
}
$json_url="todo.json";
$contenu_json= json_encode($todo_clean);
file_put_contents($json_url, $contenu_json);
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
  print_r($todo_clean);
    echo"<input type='checkbox' name='tache'";
      if (isset($_POST['tache'])) { echo " value='checked'"; }
    echo $contenu_json ."/>";
?>
          <form action="index.php" method="post">
            <input type="submit" name="enregistrer" value="Fait">

      </section>
      <section class="fait">
        <h3> FAIT </h3>
        <textarea name="tache" id="tache" rows="1" cols="30"> </textarea>
        <input type="submit" name="ajouter" value="Ajouter une tâche">
      </section>
    </form>
  </section>
</body>
</html>
