<?php
require '../db.php';
require '../libs/rb.php';
R::setup(
    'pgsql:host=localhost;port=5432;dbname=' . $database,
    $user,
    $password
);

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $plans = $id ? R::find('skills', 'parent = ?', [$id]) : R::findAll('skills');
        echo json_encode($plans);
        break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        $parent = $data["parent"];
        $records = $data['items'];
        $module = R::findOne('modules', 'id = ?', [$parent]);
        foreach ($records as $record) {
            $studPlan = R::dispense('skills');
            $studPlan->parent = $parent;
            $studPlan->code = $module->codeModule;
            $studPlan->skill = $record['spell'];
            $studPlan->type = $record['spell-type'];
            R::store($studPlan);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        $type = $data['record']['type'];
        $id = $data['record']['id'];
        $record = $data['record']['record'];
        $skill = R::findOne($type, 'id = ?', [$id]);
        if ($skill) {
            $skill->skill = $record['skill'];
            $skill->type = $record['type'];
            R::store($skill);
        }
        break;
}
