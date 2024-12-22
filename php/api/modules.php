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
        $plans = $id ? R::find('modules', 'parent = ?', [$id]) : R::findAll('modules');
        echo json_encode($plans);
        break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        $parent = $data["parent"];
        $records = $data['items'];
        $plan = R::findOne('plans', 'id = ?', [$parent]);
        foreach ($records as $record) {
            $studPlan = R::dispense('modules');
            $studPlan->parent = $parent;
            $studPlan->nameSpeciality = $plan->nameSpeciality;
            $studPlan->nameModule = $plan->name;
            $studPlan->codeModule = $plan->index;
            $studPlan->codesPk = $record['codes-pk'];
            $studPlan->nameSection = $record['name-section'];
            $studPlan->all = (int)$record['all'];
            $studPlan->disciplines = (int)$record['disciplines'];
            $studPlan->courseworks = (int)$record['courseworks'];
            $studPlan->practices = (int)$record['practices'];
            $studPlan->individualWork = (int)$record['self-work'];
            R::store($studPlan);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        $type = $data['record']['type'];
        $id = $data['record']['id'];
        $record = $data['record']['record'];
        $module = R::findOne($type, 'id = ?', [$id]);
        if ($module) {
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
        break;
}
