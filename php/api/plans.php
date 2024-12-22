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
        $plans = $id ? R::find('plans', 'parent = ?', [$id]) : R::findAll('plans');
        echo json_encode($plans);
        break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        $parent = $data["parent"];
        $records = $data['items'];
        $speciality = R::findOne('specialities', 'id = ?', [$parent]);
        foreach ($records as $record) {
            $studPlan = R::dispense('plans');
            $studPlan->parent = $parent;
            $studPlan->nameSpeciality = $speciality->name;
            $studPlan->index = $record['index'];
            $studPlan->name = $record['name'];
            $studPlan->all = (int)$record['all'];
            $studPlan->disciplines = (int)$record['disciplines'];
            $studPlan->practices = (int)$record['practices'];
            $studPlan->individualWork = (int)$record['individual_work'];
            R::store($studPlan);
        }
        break;
    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        $type = $data['record']['type'];
        $id = $data['record']['id'];
        $record = $data['record']['record'];
        $plan = R::findOne($type, 'id = ?', [$id]);
        if ($plan) {
            $plan->index = $record['index'];
            $plan->name = $record['name'];
            $plan->all = (int)$record['all'];
            $plan->disciplines = (int)$record['disciplines'];
            $plan->practices = (int)$record['practices'];
            $plan->individualWork = (int)$record['individual_work'];
            R::store($plan);
        }
        break;
}
