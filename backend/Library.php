<?php

namespace backend;

use PDO;
use PDOException;

include_once('User.php');
include_once('Book.php');
include_once('config.php');

class Library
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Library();
        }
        return self::$instance;
    }

    public function addUser(User $user)
    {
        $stmt = $this->pdo->prepare("INSERT INTO user (id, name, email) VALUES (?, ?, ?)");
        $stmt->execute([$user->getUserId(), $user->getUserName(), $user->getUserEmail()]);
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBook(Book $book)
    {
        $stmt = $this->pdo->prepare("INSERT INTO notes (id, title, author, isbn) VALUES (?, ?, ?, ?)");
        $stmt->execute([$book->getId(), $book->getTitle(), $book->getAuthor(), $book->getISBN()]);
    }

    public function getAllBooks()
    {
        $stmt = $this->pdo->query("SELECT * FROM notes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addLoan(Loan $loan)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO loans (book_id, user_id, loan_date, return_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $loan->getBook()->getId(),
                $loan->getUser()->getUserId(),
                $loan->getLoanDate(),
                $loan->getReturnDate()
            ]);

            // Видалити книгу після позики
            $this->removeBookById($loan->getBook()->getId());
        } catch (PDOException $e) {
            error_log("Error adding loan: " . $e->getMessage());
            throw new Exception("Failed to add loan");
        }
    }


    public function getAllLoans()
    {
        $stmt = $this->pdo->query("SELECT * FROM loans WHERE is_returned = FALSE");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function returnBook($loanId)
    {
        try {
            // Get the book ID associated with the loan
            $stmt = $this->pdo->prepare("SELECT book_id FROM loans WHERE id = ?");
            $stmt->execute([$loanId]);
            $bookId = $stmt->fetchColumn();

            if (!$bookId) {
                throw new Exception("Loan ID not found or book already returned");
            }

            // Delete the loan record
            $stmt = $this->pdo->prepare("DELETE FROM loans WHERE id = ?");
            $stmt->execute([$loanId]);

            return true;
        } catch (PDOException $e) {
            error_log("Error returning book: " . $e->getMessage());
            throw new Exception("Failed to return book");
        }
    }


    public function removeBookById($bookId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM notes WHERE id = ?");
        $stmt->execute([$bookId]);
    }

    public function deleteUser($userId)
    {
        try {
            // Підготовка запиту для перевірки існування користувача за його ID
            $stmt = $this->pdo->prepare("SELECT id FROM user WHERE id = ?");
            $stmt->execute([$userId]);
            $userIdExist = $stmt->fetchColumn();

            // Перевірка, чи користувач існує
            if (!$userIdExist) {
                throw new Exception("User ID not found");
            }

            // Видалення користувача
            $stmt = $this->pdo->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$userId]);

            return true;
        } catch (PDOException $e) {
            // Обробка помилок бази даних
            error_log("Error deleting user: " . $e->getMessage());
            throw new Exception("Failed to delete user");
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

//    public function deleteUser($userId)
//    {
//        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE id = ?");
//        $stmt->execute([$userId]);
//        $userIdExist = $stmt->fetchColumn();
//
//        if (!$userIdExist) {
//            throw new Exception("User ID not found");
//        }
//
//        $stmt = $this->pdo->prepare("DELETE FROM user WHERE id = ?");
//        $stmt->execute([$userId]);
//
//        return true;
//    }


}

?>
