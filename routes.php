<?php
session_start();
include 'databaseconnect.php';

if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

$routes = $conn->query("SELECT * FROM routes");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routes</title>
</head>
<body>
    <h1>Routes</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Start Point</th>
                <th>End Point</th>
                <th>Stoppages</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $routes->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['start_point'] ?></td>
                    <td><?= $row['end_point'] ?></td>
                    <td><?= $row['stoppages'] ?></td>
                    <td><?= $row['route_type'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
