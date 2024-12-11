<?php
include 'header.php';
include 'drawer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <style>
        main {
            margin-left: 300px;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .filter-form, .send-message-form {
            margin-bottom: 20px;
        }

        .send-message-form input, .send-message-form textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 14px;
        }

        .send-message-form button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .send-message-form button:hover {
            background-color: #0056b3;
        }

        .print-btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }

        .success-msg {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<main>
    <h1>Send Message to Users</h1>

    <!-- Success message after sending message -->
    <?php if (isset($success_msg)): ?>
        <p class="success-msg"><?php echo $success_msg; ?></p>
    <?php endif; ?>

    <!-- Send Message Form -->
    <h2>Send a Message</h2>
    <form method="post" class="send-message-form">
        <label for="user_id">Select User:</label>
        <select name="user_id" required>
            <option value="" disabled selected>Select a User</option>
            <!-- Options for users will be dynamically filled with backend logic -->
            <option value="1">User 1</option>
            <option value="2">User 2</option>
            <option value="3">User 3</option>
        </select>

        <label for="message">Message:</label>
        <textarea name="message" rows="6" required></textarea>

        <button type="submit" name="send_message">Send Message</button>
    </form>

    <!-- Date Filter Form -->
    <form method="post" class="filter-form">
        <label for="filter_date">Filter by Date:</label>
        <input type="date" name="filter_date" required>
        <button type="submit">Filter</button>
    </form>

    <!-- Sent Messages Table -->
    <h2>Sent Messages</h2>
    <table id="sentMessagesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Message</th>
                <th>Date Sent</th>
            </tr>
        </thead>
        <tbody>
            <!-- The sent messages data will be dynamically populated later -->
            <tr>
                <td>1</td>
                <td>User 1</td>
                <td>Test message</td>
                <td>2024-12-10 08:00:00</td>
            </tr>
            <tr>
                <td>2</td>
                <td>User 2</td>
                <td>Another test message</td>
                <td>2024-12-09 10:30:00</td>
            </tr>
        </tbody>
    </table>
</main>

<script>
    function printTable(tableId) {
        const table = document.getElementById(tableId);
        const newWindow = window.open("", "", "width=800, height=600");
        newWindow.document.write("<html><head><title>Print Table</title></head><body>");
        newWindow.document.write(table.outerHTML);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.print();
    }
</script>
</body>
</html>
