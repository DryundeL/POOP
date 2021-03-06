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

    if (isset($params['id'])) {
      $plans = R::find('modules', 'parent = ?', [$params['id']]);
    } else {
      $plans = R::findAll('modules');
    }
    
    echo json_encode($plans);
  } else if ($_SERVER["REQUEST_METHOD"] === "POST") 
  {
    $_POST = json_decode(file_get_contents('php://input'), true);

    $type = $_POST["type"];
    $parent = $_POST["parent"];
    $records = $_POST['items'];

    foreach ($records as $record) {
      $plans = R::find('plans', 'id = ?', [$parent]);

      $studPlan = R::dispense('modules');
      $studPlan -> parent = $parent;
      $studPlan -> nameSpeciality = $plans[$parent]->nameSpeciality;
      $studPlan -> nameModule = $plans[$parent]->name;
      $studPlan -> codeModule = $plans[$parent]->index;
      $studPlan -> codesPk = $record['codes-pk'];
      $studPlan -> nameSection = $record['name-section'];
      $studPlan -> all = (int)$record['all'];
      $studPlan -> disciplines = (int)$record['disciplines'];
      $studPlan -> courseworks = (int)$record['courseworks'];
      $studPlan -> practices = (int)$record['practices'];
      $studPlan -> individualWork = (int)$record['self-work'];

      R::store($studPlan);
    }
  } else if($_SERVER["REQUEST_METHOD"] === "PUT") 
  {
    $_PUT = json_decode(file_get_contents('php://input'), true);

    $type = $_PUT['record']["type"];
    $id = $_PUT['record']["id"];
    $record = $_PUT['record']['record'];

    $module = R::find($type, 'id = ?', [$id])[$id];
    $module->nameModule = $record['name_module'];
    $module->codeModule = $record['code_module'];
    $module->codesPk = $record['codes_pk'];
    $module->nameSection = $record['name_section'];
    $module->all = (int)$record['all'];
    $module->disciplines = (int)$record['disciplines'];
    $module->courseworks = (int)$record['courseworks'];
    $module->practices = (int)$record['practices'];
    $module->individualWork = (int)$record['individual_work'];
    R::store($module);
  }
?>