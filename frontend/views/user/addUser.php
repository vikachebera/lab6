<?php

use backend\core\Library;
use backend\model\User;

include_once('../../../backend/core/Library.php');
include_once('../../../backend/model/User.php');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

if (isset($input['action']) && $input['action'] == 'addUser') {
    $name = $input['name'];
    $email = $input['email'];

    if ($name && $email) {
        $library = Library::getInstance();
        $user = new User(null, $name, $email);

        try {
            $library->addUser($user);
            $response['success'] = true;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
    } else {
        $response['error'] = 'Invalid input';
    }
} else {
    $response['error'] = 'Invalid action';
}

echo json_encode($response);
?>
