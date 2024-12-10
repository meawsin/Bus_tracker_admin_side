<?php
session_start();
include 'databaseconnect.php';
include 'header.php';
include 'drawer.php';
if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

$adminName = $_SESSION['adminName'];
$currentDateTime = date("d M Y | h:i:s A");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

    <main style="margin-left: 250px; padding: 20px;">
        <h1>Dashboard</h1>
        <button onclick="window.location.href='setTrips.php'">Assign a Trip</button>

        <div style="display: flex; gap: 20px;">
            <div style="background: lightgreen; padding: 20px;">On Route Buses: 5</div>
            <div style="background: lightgreen; padding: 20px;">Today's Trips: 12</div>
        </div>
        <div>
            <h2>Complaints</h2>
            <!-- Include complaints table here -->
        </div>
    </main>
</body>
</html>
