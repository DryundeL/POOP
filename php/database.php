<?php
  require 'db.php';
  require './libs/rb.php';
  R::setup('mysql:host=localhost;dbname=newPOOP', $user, $password);
  if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $_POST = json_decode(file_get_contents('php://input'), true);
    
    $type = $_POST["type"];
    $records = $_POST['items'];

    if ($type === 'plans') {
      foreach ($records as $record) {
        $studPlan = R::dispense('studyplane');
        $studPlan -> specName = '';
        $studPlan -> indexPlan = $record['index'];
        $studPlan -> name = $record['name'];
        $studPlan -> allPlan = $record['all'];
        $studPlan -> disciplines = $record['disciplines'];
        $studPlan -> practices = $record['practices'];
        $studPlan -> individualWork = $record['self_work'];
  
        R::store($studPlan);
      }
    }
  }
  else if($_SERVER["REQUEST_METHOD"] === "GET"){
    $studPlans = R::findAll('studyplane');
    echo json_encode($studPlans);
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