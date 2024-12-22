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
        $plans = R::findAll('specialities');
        echo json_encode($plans);
        break;

    case "POST":
        $data = json_decode(file_get_contents('php://input'), true);
        $records = $data['items'] ?? [];

        foreach ($records as $record) {
            // Check if at least one required field is present and not empty
            if (
                !empty($record['code-speciality']) ||
                !empty($record['name-speciality']) ||
                !empty($record['update-date'])
            ) {
                $studPlan = R::dispense('specialities');
                $studPlan->codeSpeciality = $record['code-speciality'] ?? null;
                $studPlan->name = $record['name-speciality'] ?? null;
                $studPlan->updatedAt = $record['update-date'] ?? null;
                R::store($studPlan);
            }
        }
        break;

    case "PUT":
        $data = json_decode(file_get_contents('php://input'), true);
        $id = isset($data['record']['id']) ? (int)$data['record']['id'] : 0;
        $type = $data['record']['type'] ?? '';
        $record = $data['record']['record'] ?? [];

        if ($id && $type) {
            $speciality = R::findOne($type, 'id = ?', [$id]);
            if ($speciality) {
                $hasUpdate = false;

                if (!empty($record['code_speciality'])) {
                    $speciality->codeSpeciality = $record['code_speciality'];
                    $hasUpdate = true;
                }

                if (!empty($record['name'])) {
                    $speciality->name = $record['name'];
                    $hasUpdate = true;
                }

                if ($hasUpdate) {
                    R::store($speciality);
                }
            }
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}