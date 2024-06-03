document.addEventListener('DOMContentLoaded', () => {
    const userForm = document.getElementById('add-user-form');
    const userList = document.getElementById('user-list');
    userForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = document.getElementById('user-name').value;
        const email = document.getElementById('user-email').value;

        try {
            const response = await fetch('add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({action: 'addUser', name, email}),
            });

            const result = await response.json();
            if (result.success) {
                window.location.href = 'users_list.php'; // Перенаправлення на сторінку зі списком користувачів
            } else {
                console.error('Error adding user:', result.error);
            }
        } catch (error) {
            console.error('Error in user submission:', error);
        }
    });


    const bookForm = document.getElementById('add-book-form');
    const booksList = document.getElementById('book-section');
    bookForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = document.getElementById('book-title').value;
        const author = document.getElementById('book-author').value;
        const isbn = document.getElementById('book-isbn').value;

        try {
            const response = await fetch('add.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({action: 'addBook', title, author, isbn}),
            });

            const result = await response.json();
            if (result.success) {
                window.location.href = 'books_list.php'; // Перенаправлення на сторінку зі списком книг
            } else {
                console.error('Error adding user:', result.error);
            }
        } catch (error) {
            console.error('Error in user submission:', error);
        }
    });



});


