<?php
   require '../db.php';
   require '../libs/rb.php';
   R::setup('mysql:host=localhost;dbname=u1026489_par', $user, $password);

  if ($_SERVER["REQUEST_METHOD"] === "GET")
  {
    $querys = explode('&', $_SERVER['QUERY_STRING']);
    foreach($querys as $query) {
      $param = explode('=', $query);
      $params[$param[0]] = $param[1];
    }
    if (isset($params['id'])) {
      $plans = R::find('plans', 'parent = ?', [$params['id']]);
    } else {
      $plans = R::findAll('plans');
    }
    echo json_encode($plans);
  } else if ($_SERVER["REQUEST_METHOD"] === "POST") 
  {
    $_POST = json_decode(file_get_contents('php://input'), true);

    $type = $_POST["type"];
    $parent = $_POST["parent"];
    $records = $_POST['items'];

    foreach ($records as $record) {
      $speciality = R::find('specialities', 'id = ?', [$parent]);

      $studPlan = R::dispense('plans');
      $studPlan -> parent = $parent;
      $studPlan -> nameSpeciality = $speciality[$parent]->nameSpeciality;
      $studPlan -> index = $record['index'];
      $studPlan -> name = $record['name'];
      $studPlan -> all = $record['all'];
      $studPlan -> disciplines = $record['disciplines'];
      $studPlan -> practices = $record['practices'];
      $studPlan -> individualWork = $record['self-work'];
      R::store($studPlan);
    }
  } else if($_SERVER["REQUEST_METHOD"] === "PUT") 
  {
    $_PUT = json_decode(file_get_contents('php://input'), true);

    $type = $_PUT['record']["type"];
    $id = $_PUT['record']["id"];
    $record = $_PUT['record']['record'];
    
    $plan = R::find($type, 'id = ?', [$id])[$id];
    $plan->index = $record['index'];
    $plan->name = $record['name'];
    $plan->all = $record['all'];
    $plan->disciplines = $record['disciplines'];
    $plan->practices = $record['practices'];
    $plan->individualWork = $record['individual_work'];
    R::store($plan);
  }
?>