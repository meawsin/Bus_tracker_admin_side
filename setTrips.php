<?php
session_start();
include 'databaseconnect.php';

if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];
    $route_id = $_POST['route_id'];
    $driver1_id = $_POST['driver1_id'];
    $driver2_id = $_POST['driver2_id'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];

    $sql = "INSERT INTO trips (date, route_id, bus_id, driver1_id, driver2_id, start_time, status)
            VALUES ('$date', '$route_id', '$bus_id', '$driver1_id', '$driver2_id', '$start_time', 'scheduled')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Trip assigned successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch data for dropdowns
$buses = $conn->query("SELECT id, name FROM buses WHERE status = 'in_service'");
$routes = $conn->query("SELECT id, name FROM routes");
$drivers = $conn->query("SELECT id, name FROM drivers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Trip</title>
</head>
<body>
    <h1>Assign a Trip</h1>
    <form method="post" action="setTrips.php">
        <label for="bus_id">Bus:</label>
        <select name="bus_id" required>
            <?php while ($row = $buses->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="route_id">Route:</label>
        <select name="route_id" required>
            <?php while ($row = $routes->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="driver1_id">Primary Driver:</label>
        <select name="driver1_id" required>
            <?php while ($row = $drivers->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="driver2_id">Secondary Driver (Optional):</label>
        <select name="driver2_id">
            <option value="">None</option>
            <?php $drivers->data_seek(0); while ($row = $drivers->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php endwhile; ?>
        </select>

        <label for="date">Date:</label>
        <input type="date" name="date" required>

        <label for="start_time">Start Time:</label>
        <input type="time" name="start_time" required>

        <button type="submit">Assign</button>
    </form>
</body>
</html>
