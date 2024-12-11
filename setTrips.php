<?php
session_start();
include 'databaseconnect.php';

if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bus_id = $_POST['bus_id'];
    $route_id = $_POST['route_id'];
    $driver1_id = $_POST['driver1_id'];
    $driver2_id = $_POST['driver2_id'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];

    // Combine date and time for the DATETIME column
    $start_datetime = "$date $start_time";

    // Insert trip details into the database
    $sql = "INSERT INTO trips (date, route_id, bus_id, driver1_id, driver2_id, start_time, status)
            VALUES ('$date', '$route_id', '$bus_id', '$driver1_id', '$driver2_id', '$start_datetime', 'scheduled')";

    if ($conn->query($sql) === TRUE) {
        $message = "Trip assigned successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Fetch data for dropdowns
$buses = $conn->query("SELECT id, name FROM buses WHERE status = 'parking'");
$routes = $conn->query("SELECT id, name FROM routes");
$drivers = $conn->query("SELECT id, name FROM drivers");

include 'header.php';
include 'drawer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Trip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        main {
            margin-left: 300px;
            padding: 20px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        form {
            background: lightgreen;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 18px;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .container {
            margin: auto;
            max-width: 600px;
        }

        .notification {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #007BFF;
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 18px;
            display: none;
            z-index: 1000;
        }

        .notification.show {
            display: block;
        }
    </style>
</head>
<body>

<div class="notification" id="notification">
    <?php if (!empty($message)) echo $message; ?>
</div>

<main>
    <h1>Assign a Trip</h1>
    <div class="container">
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

            <button type="submit">Assign Trip</button>
        </form>
    </div>
</main>

<script>
    // Show notification if there is a message
    const notification = document.getElementById('notification');
    if (notification.innerText.trim() !== "") {
        notification.classList.add('show');
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000); // Hide after 3 seconds
    }
</script>

</body>
</html>
