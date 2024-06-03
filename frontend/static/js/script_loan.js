document.addEventListener('DOMContentLoaded', () => {
    const loanForm = document.getElementById('loan-book-form');
    loanForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const userEmail = document.getElementById('user-email').value;
        const bookISBN = document.getElementById('book-isbn').value;
        const loanDate = document.getElementById('loan-date').value;
        const returnDate = document.getElementById('return-date').value;

        try {
            const response = await fetch('add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'addLoan',
                    userEmail,
                    bookISBN,
                    loanDate,
                    returnDate
                }),
            });

            const result = await response.json();
            if (result.success) {
                alert('Книгу взято успішно!');
                window.location.href = 'books_list.php'; // Redirect to books_list.php
            } else {
                console.error('Error adding loan:', result.error);
                alert('Error adding loan: ' + result.error);
            }
        } catch (error) {
            console.error('Fetch error:', error);
        }
    });
});
