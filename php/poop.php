<?php
  require 'db.php';

  $link = new mysqli($host, $user, $password, $database);

  if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $_POST = json_decode(file_get_contents('php://input'), true);
    $sql = "INSERT INTO `study_plan`  VALUES(null,'','$_POST[index]', '$_POST[name]', '$_POST[all]', '$_POST[disciplines]', '$_POST[practices]', '$_POST[self_work]')";
    $result = $link->query($sql);
    echo $result;
  }
?>