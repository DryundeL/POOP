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
        $plans = $id ? R::find('themePlan', 'id_module = ?', [$id]) : R::findAll('themePlan');
        echo json_encode($plans);
        break;
    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        $parent = $data["parent"];
        $records = $data['items'];
        $module = R::findOne('modules', 'id = ?', [$parent]);
        if ($module) {
            foreach ($records as $record) {
                $studPlan = R::dispense('themeplan');
                $studPlan->idModule = $module->id;
                $studPlan->moduleTheme = $record['module-theme'];
                $studPlan->content = $record['content'];
                $studPlan->lessonType = $record['lesson-type'];
                $studPlan->hoursCount = (int)$record['hours-count'];
                R::store($studPlan);
            }
        }
        break;
}
