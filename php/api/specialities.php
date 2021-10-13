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
      $studPlan -> nameSpeciality = $record['name-speciality'];
      $studPlan -> updatedAt = date("d-m-Y");;
      R::store($studPlan);
    }
  }
?>