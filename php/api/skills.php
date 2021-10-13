<?php
   require '../db.php';
   require '../libs/rb.php';
   R::setup('mysql:host=localhost;dbname=newPOOP', $user, $password);

  if ($_SERVER["REQUEST_METHOD"] === "GET")
  {
    $querys = explode('&', $_SERVER['QUERY_STRING']);
    foreach($querys as $query) {
      $param = explode('=', $query);
      $params[$param[0]] = $param[1];
    }

    $plans = R::find('skills', 'parent = ?', [$params['id']]);
    echo json_encode($plans);
  } else if ($_SERVER["REQUEST_METHOD"] === "POST") 
  {
    $_POST = json_decode(file_get_contents('php://input'), true);

    $type = $_POST["type"];
    $parent = $_POST["parent"];
    $records = $_POST['items'];

    foreach ($records as $record) {
      $module = R::find('modules', 'id = ?', [$parent]);

      $studPlan = R::dispense('skills');
      $studPlan -> parent = $parent;
      $studPlan -> code = $module[$parent]->codeModule;
      $studPlan -> skill = $record['spell'];
      $studPlan -> type = $record['spell-type'];
      R::store($studPlan);
    }
  }
?>