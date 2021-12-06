<?php
session_start();
if(!isset($_SESSION['createJob'])){
    header('Location: index.php');
    exit();
  } else{
    $result = "job";
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta https-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
  echo "<h1>Super udalo ci sie dodac ogloszenie z $result </h1>";
  ?>
  <a href="index.php">strona glowna</a>
</body>
</html>