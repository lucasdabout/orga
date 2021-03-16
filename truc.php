<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PHP CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php require_once 'process.php';



if (isset($_SESSION['message'])): ?>

<div class="alert alert-<?=$_SESSION['msg_type']?>">

<?php echo $_SESSION['message'];
unset($_SESSION['message']);
?>
</div>
<?php endif ?>

    <div class="container">

    <?php
      $mysqli = new mysqli('localhost', 'root', '', 'groups') or die (mysqli_error($mysqli));
      $result = $mysqli->query("SELECT * FROM organization") or die($mysqli->error);
      //pre_r($result);
      ?>

      <div class="row justify-content-center">



<form name="search_form" method="post" action="process.php">
  Filtrer
  <input type="text" name="search" value=""/>
  <input type="submit" class="btn btn-info"name="submit-search" value="Rechercher"/>
</form>





          <table class="table">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Adresse mail</th>
                <th>Ville</th>
                <th colspan="2">Action</th>
              </tr>
            </thead>

          <?php
            while ($row = $result->fetch_assoc()):?>
              <tr>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['domain'];?></td>
                <td><?php echo $row['aliases'];?></td>
                <td>
                  <a href="truc.php?edit=<?php echo $row['id']; ?>"
                    class="btn btn-info">Modifier</a>
                    <a href="process.php?delete=<?php echo $row['id'];?>"
                      class="btn btn-danger">Supprimer</a>
                </td>
              </tr>
            <?php endwhile;?>
          </table>
      </div>


      <?php

      function pre_r( $array ){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
      }
     ?>

    <div class="row justify-content-center">

<h2>Ajouter une organisation</h2>
      <form action="process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">



        <div class="form-group">
          <label>Nom</label>
          <input type="text" name="nom" class="form-control"
                value="<?php echo $nom; ?>" placeholder="Entrez votre nom et votre prénom">
        </div>
        <div class="form-group">
          <label>Adresse mail</label>
          <input type="text" name="adressemail" class="form-control"
                value="<?php echo $adressemail; ?>" placeholder="Entrez votre adresse mail">
        </div>
        <div class="form-group">
          <label>Ville</label>
          <input type="text" name="ville" class="form-control"
                value="<?php echo $ville; ?>" placeholder="Entrez votre ville">
        </div>
        <div class="form-group">
          <?php if ($update == true):
          ?>
          <button type="submit" class="btn btn-info"name="update">Mettre à jour</button>
        <?php else: ?>
          <button type="submit" class="btn btn-primary"name="save">Enregistrer</button>
        <?php endif; ?>
        </div>
      </form>

  </div>
</body>
</html>
