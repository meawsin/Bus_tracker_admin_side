<?php
session_start();
include 'databaseconnect.php';

if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

$buses = $conn->query("SELECT * FROM buses");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buses</title>
</head>
<body>
    <h1>Buses</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>License Plate</th>
                <th>Status</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $buses->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['license_plate'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['bus_type'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
