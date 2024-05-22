<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>Return Book</title>
</head>
<body>
<div class="container">
    <div id="library-interface">
        <h3>Return Book</h3>
        <form id="return-book-form">
            <label for="loan-id">Loan ID
                <input type="number" id="loan-id" placeholder="Enter loan ID" required></label>

            <button type="submit">Return Book</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const returnForm = document.getElementById('return-book-form');
        returnForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const loanId = document.getElementById('loan-id').value;

            try {
                const response = await fetch('add.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'returnBook',
                        loanId
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    alert('Book returned successfully!');
                    window.location.href = 'books_list.php';
                } else {
                    console.error('Error returning book:', result.error);
                    alert('Error returning book: ' + result.error);
                }
            } catch (error) {
                console.error('Fetch error:', error);
            }
        });
    });
</script>
</body>
</html>
