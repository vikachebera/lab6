<?php

use backend\core\Library;

include_once('../../../backend/core/Library.php');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['action']) && $input['action'] === 'deleteUser') {
    $userId = $input['userId'];

    if ($userId) {
        $library = Library::getInstance();

        try {
            $library->deleteUser($userId);
            // Відправка успішної відповіді
            echo json_encode(['success' => true]);
            exit;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error in deleteUser method: ' . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input: User ID is missing']);
        exit;
    }
}

// Відправка відповіді про неправильний запит, якщо дія не визначена
echo json_encode(['success' => false, 'error' => 'Invalid request']);
?>
