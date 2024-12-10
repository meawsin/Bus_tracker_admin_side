<?php
session_start();
include 'databaseconnect.php';

if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

$complaints = $conn->query("SELECT * FROM complaints");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
</head>
<body>
    <h1>Complaints</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Subject</th>
                <th>Details</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $complaints->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['Name'] ?></td>
                    <td><?= $row['SUBJECT'] ?></td>
                    <td><?= $row['Details'] ?></td>
                    <td><?= $row['Status'] ?></td>
                    <td>
                        <a href="resolveComplaint.php?id=<?= $row['id'] ?>">Resolve</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
