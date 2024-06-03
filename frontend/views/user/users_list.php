<?php

use backend\core\Library;

include_once('../../../backend/core/Library.php');
$library = Library::getInstance();
$users = $library->getAllUsers();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List - Electronic Library</title>
    <link rel="stylesheet" href="../../static/css/style.css">
</head>
<body>
<h1>User List</h1>
<div id="user-list-container">
    <?php if (!empty($users)): ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</div>

<div class="container">
    <div id="library-interface">
        <h3>Delete User</h3>
        <form id="delete_user" method="post">
            <label for="userId">User ID:
                <input type="number" id="userId" placeholder="Enter user ID" required>
            </label>
            <button type="submit">Delete User</button>
        </form>
    </div>
    <div class="link">
        <a href="../../index.html">На головну</a>
    </div></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteUserForm = document.getElementById('delete_user');

        deleteUserForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const userId = document.getElementById('userId').value;

            try {
                const response = await fetch('delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        action: 'deleteUser',
                        userId: userId,
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    alert('User deleted successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            }
        });
    });
</script>
</body>
</html>
