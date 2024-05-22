<?php

use backend\Book;
use backend\Library;
use backend\Loan;
use backend\User;

include_once('../backend/Library.php');
include_once('../backend/User.php');
include_once('../backend/Book.php');
include_once('../backend/Loan.php');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

if (isset($input['action']) && $input['action'] == 'addUser') {
    $title = $input['name'];
    $author = $input['email'];

    if ($title && $author) {
        $library = Library::getInstance();
        $user = new User(null, $title, $author);

        try {
            $library->addUser($user);
            $response['success'] = true;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
    } else {
        $response['error'] = 'Invalid input';
    }
}

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
}

if (isset($input['action']) && $input['action'] == 'addLoan') {
    $userEmail = $input['userEmail'];
    $bookISBN = $input['bookISBN'];
    $loanDate = $input['loanDate'];
    $returnDate = $input['returnDate'];

    if ($userEmail && $bookISBN && $loanDate) {
        $library = Library::getInstance();

        // Find user by email
        $stmt = $library->getPDO()->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$userEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userId = $user['id'];

            // Find book by ISBN
            $stmt = $library->getPDO()->prepare("SELECT * FROM notes WHERE isbn = ?");
            $stmt->execute([$bookISBN]);
            $book = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($book) {
                $loan = new Loan(
                    new Book($book['id'], $book['title'], $book['author'], $book['isbn']),
                    new User($user['id'], $user['name'], $user['email']),
                    $loanDate,
                    $returnDate,

                );

                try {
                    $library->addLoan($loan);
                    $response['success'] = true;
                } catch (Exception $e) {
                    $response['error'] = $e->getMessage();
                }
            } else {
                $response['error'] = 'Book not found';
            }
        } else {
            $response['error'] = 'User not found';
        }
    } else {
        $response['error'] = 'Invalid input';
    }
}


try {
    if (isset($input['action']) && $input['action'] == 'returnBook') {
        $userId = $input['loanId'];

        if ($userId) {
            $library = Library::getInstance();

            try {
                $library->returnBook($userId);
                $response['success'] = true;
            } catch (Exception $e) {
                $response['error'] = 'Error in returnBook method: ' . $e->getMessage();
            }
        } else {
            $response['error'] = 'Invalid input: Loan ID is missing';
        }
    }
} catch (Exception $e) {
    $response['error'] = 'Unexpected error: ' . $e->getMessage();
}



echo json_encode($response);
?>
