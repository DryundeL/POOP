<?php
   require '../db.php';
   require '../libs/rb.php';
   R::setup('mysql:host=localhost;dbname=newPOOP', $user, $password);

  if ($_SERVER["REQUEST_METHOD"] === "GET")
  {
    $plans = R::findAll('specialities');
    echo json_encode($plans);
  } else if ($_SERVER["REQUEST_METHOD"] === "POST") 
  {
    $_POST = json_decode(file_get_contents('php://input'), true);

    $type = $_POST["type"];
    $records = $_POST['items'];

    foreach ($records as $record) {
      $studPlan = R::dispense('specialities');
      $studPlan -> codeSpeciality = $record['code-speciality'];
      $studPlan -> name = $record['name-speciality'];
      $studPlan -> updatedAt = $record['update-date'];;
      R::store($studPlan);
    }
  } else if($_SERVER["REQUEST_METHOD"] === "PUT") 
  {
    $_PUT = json_decode(file_get_contents('php://input'), true);

    $id = intval($_PUT['record']["id"]);
    $type = $_PUT['record']["type"];
    $record = $_PUT['record']['record'];
    
    $speciality = R::find($type, 'id = ?', [$id])[$id];
    var_dump($speciality);
    $speciality->codeSpeciality = $record['code_speciality'];
    $speciality->name = $record['name'];
    R::store($speciality);
  }
?>