<?php
  require 'db.php';
  require './libs/rb.php';
  R::setup('mysql:host=localhost;dbname=newPOOP', $user, $password);
  if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    $studPlan = R::dispense('studyplane');

    $studPlan -> specName = '';
    $studPlan -> indexPlan = $_POST[index];
    $studPlan -> name = $_POST[name];
    $studPlan -> allPlan = $_POST[all];
    $studPlan -> disciplines = $_POST[disciplines];
    $studPlan -> practices = $_POST[practices];
    $studPlan -> individualWork = $_POST[self_work];

    R::store($studPlan);
  }
  // $link = new mysqli($host, $user, $password, $database);

  // if ($_SERVER["REQUEST_METHOD"] === "GET"){
  //       $sql = "SELECT * FROM study_plan";
  //       $result = $link->query($sql);
    
  //       while($row = $result->fetch_assoc()){
  //           $items[] = $row;
    
  //       }
  //       echo json_encode($items);
  // }
  // elseif ($_SERVER["REQUEST_METHOD"] === "POST"){
  //   $_POST = json_decode(file_get_contents('php://input'), true);
  //   $sql = "INSERT INTO `study_plan`  VALUES(null,'','$_POST[index]', '$_POST[name]', '$_POST[all]', '$_POST[disciplines]', '$_POST[practices]', '$_POST[self_work]')";
  //   $result = $link->query($sql);
  //   echo $result;
  // }
?>