<?php

use backend\core\Library;

include_once('../../../backend/core/Library.php');
$library = Library::getInstance();
$books = $library->getAllBooks();
$loans = $library->getAllLoans();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List - Electronic Library</title>
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body>
<div class="container_loans">

    <div id="books-list-container">
        <h4>Books List</h4>
        <?php if (!empty($books)): ?>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['id']); ?></td>
                        <td><?php echo htmlspecialchars($book['title']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>

    <div><h4>Loaned Books List</h4>
        <?php if (!empty($loans) || !empty($loanedBooksDetails)): ?>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Book ID</th>
                    <th>User ID</th>
                    <th>Loan Date</th>
                    <th>Return Date</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($loans as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['id']); ?></td>
                        <td><?php echo htmlspecialchars($detail['book_id']); ?></td>
                        <td><?php echo htmlspecialchars($detail['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($detail['loan_date']); ?></td>
                        <td><?php echo htmlspecialchars($detail['return_date']); ?></td>


                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No loaned books found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../static/css/style.css">
    <title>Loan book</title>
</head>
<body>
<div class="container">
    <div id="library-interface">
        <h3>Loan book</h3>
        <form id="loan-book-form">
            <label for="user-email">Пошта користувача
                <input type="email" id="user-email" placeholder="user@gmail.com" required></label>
            <label for="book-isbn">ISBN
                <input type="text" id="book-isbn" placeholder="" required></label>
            <label for="loan-date">Дата взяття книги
                <input type="date" id="loan-date" required></label>
            <label for="return-date">Дата повернення книги
                <input type="date" id="return-date"></label>

            <button type="submit">Взяти книгу</button>
        </form>
    </div>
    <div class="links">
        <div class="link">
            <a href="return_book.php">Повернути книгу</a>
        </div>
        <div class="link">
            <a href="../../index.html">На головну</a>
        </div></div>

</div>
<script src="../../static/js/script_loan.js"></script>
</body>
</html>
