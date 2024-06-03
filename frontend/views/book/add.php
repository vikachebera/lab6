<?php

use backend\core\Library;
use backend\model\Book;

include_once('../../../backend/core/Library.php');
include_once('../../../backend/model/Book.php');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

if (isset($input['action']) && $input['action'] == 'addBook') {
    $title = $input['title'];
    $author = $input['author'];
    $isbn = $input['isbn'];

    if ($title && $author && $isbn) {
        $library = Library::getInstance();
        $book = new Book(null, $title, $author, $isbn);

        try {
            $library->addBook($book);
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
