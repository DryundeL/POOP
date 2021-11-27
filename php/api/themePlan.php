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
      $plans = R::find('themePlan', 'id_module = ?', [$params['id']]);
      
    } else {
      $plans = R::findAll('themePlan');
    }
    
    echo json_encode($plans);
  } else if ($_SERVER["REQUEST_METHOD"] === "POST") 
  {
    $_POST = json_decode(file_get_contents('php://input'), true);

    $type = $_POST["type"];
    $parent = $_POST["parent"];
    $records = $_POST['items'];
    var_dump($records);

    foreach ($records as $record) {
      $module = R::find('modules', 'id = ?', [$parent]);

      $studPlan = R::dispense('themeplan');
      $studPlan -> idModule = $module[$parent]->id;
      $studPlan -> moduleTheme = $record['module-theme'];
      $studPlan -> content = $record['content'];
      $studPlan -> lessonType = $record['lesson-type'];
      $studPlan -> hoursCount = (int)$record['hours-count'];
      R::store($studPlan);
    }
  }
  // } else if($_SERVER["REQUEST_METHOD"] === "PUT") 
  // {
  //   $_PUT = json_decode(file_get_contents('php://input'), true);

  //   $type = $_PUT['record']["type"];
  //   $id = $_PUT['record']["id"];
  //   $record = $_PUT['record']['record'];

  //   $skill = R::find($type, 'id = ?', [$id])[$id];
  //   $skill->skill = $record['skill'];
  //   $skill->type = $record['type'];
  //   R::store($skill);
  // }
?>