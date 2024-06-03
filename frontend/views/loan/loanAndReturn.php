<?php

use backend\core\Library;
use backend\model\Loan;
use backend\model\Book;
use backend\model\User;

include_once('../../../backend/core/Library.php');
include_once('../../../backend/model/Loan.php');
include_once('../../../backend/model/Book.php');
include_once('../../../backend/model/User.php');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false];

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
                    $returnDate
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
} elseif (isset($input['action']) && $input['action'] == 'returnBook') {
    $loanId = $input['loanId'];

    if ($loanId) {
        $library = Library::getInstance();

        try {
            $library->returnBook($loanId);
            $response['success'] = true;
        } catch (Exception $e) {
            $response['error'] = 'Error in returnBook method: ' . $e->getMessage();
        }
    } else {
        $response['error'] = 'Invalid input: Loan ID is missing';
    }
} else {
    $response['error'] = 'Invalid action';
}

echo json_encode($response);
?>
