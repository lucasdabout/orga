<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '', 'groups') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$nom = '';
$adressemail = '';
$ville = '';


if(isset($_POST['submit-search'])){
  $search=mysqli_real_escape_string($mysqli,$_POST['search']);
  $result = $mysqli->query("SELECT * FROM organization WHERE name LIKE '%$search%' OR domain LIKE '%$search%' OR aliases LIKE '%$search%'");
  $queryresult = mysqli_num_rows($result);
?>

<div class="container" "row justify-content-center">
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

  if($queryresult > 0){
    while($row = mysqli_fetch_assoc($result)):
    ?>
      <tr>
        <td><?php echo $row['name'];?></td>
        <td><?php echo $row['domain'];?></td>
        <td><?php echo $row['aliases'];?></td>
        <td>
          <a href="truc.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
          <a href="process.php?delete=<?php echo $row['id'];?>" class="btn btn-danger">Delete</a>
        </td>
      </tr>
  </table>

<?php
endwhile;
}
  else{
    echo "Aucun résultat ne correspond à votre recherche";
}
}
?>
</div>

<?php
if(isset($_POST['save'])){
  $nom = $_POST['nom'];
  $adressemail = $_POST['adressemail'];
  $ville = $_POST['ville'];

  $mysqli->query("INSERT INTO organization(name, domain, aliases) VALUES ('$nom', '$adressemail', '$ville')") or die($mysqli->error);

  $_SESSION['message']= "Enregistrement effectué";
  $_SESSION['msg_type']="success";

  header("location: truc.php");
}

if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $mysqli->query("DELETE FROM organization WHERE id=$id") or die($mysqli->error());

  $_SESSION['message']= "Enregistrement supprimé";
  $_SESSION['msg_type']="danger";

  header("location: truc.php");

}

if (isset($_GET['edit'])){
  $id = $_GET['edit'];
  $update = true;
  $result = $mysqli->query("SELECT * FROM organization WHERE id=$id") or die($mysqli->error("cc"));
  if ($row = $result->fetch_array()){
    $nom = $row['name'];
    $adressemail = $row['domain'];
    $ville = $row['aliases'];
  }
}

if(isset($_POST['update'])){
  $id = $_POST['id'];
  $nom = $_POST['nom'];
  $adressemail = $_POST ['adressemail'];
  $ville = $_POST['ville'];

  $mysqli->query("UPDATE organization SET name='$nom', domain='$adressemail', aliases='$ville' WHERE id='$id'") or die($mysqli->error);

  $_SESSION['message'] = "L'enregistrement a été mis à jour";
  $_SESSION['msg_type'] = "warning";

  header('location: truc.php');
}



?>
