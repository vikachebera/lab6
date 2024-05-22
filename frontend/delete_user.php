<?php

use backend\Library;

include_once('../backend/Library.php');

// Отримання JSON-даних
$input = json_decode(file_get_contents('php://input'), true);

// Перевірка, чи існують дані і дія є deleteUser
if (isset($input['action']) && $input['action'] === 'deleteUser') {
    // Отримання userId з JSON-даних
    $userId = $input['userId'];

    if ($userId) {
        $library = Library::getInstance();

        try {
            // Видалення користувача
            $library->deleteUser($userId);
            // Відправка успішної відповіді
            echo json_encode(['success' => true]);
            exit;
        } catch (Exception $e) {
            // Відправка відповіді з помилкою
            echo json_encode(['success' => false, 'error' => 'Error in deleteUser method: ' . $e->getMessage()]);
            exit;
        }
    } else {
        // Відправка відповіді про неправильний вхідний ID
        echo json_encode(['success' => false, 'error' => 'Invalid input: User ID is missing']);
        exit;
    }
}

// Відправка відповіді про неправильний запит, якщо дія не визначена
echo json_encode(['success' => false, 'error' => 'Invalid request']);
?>
