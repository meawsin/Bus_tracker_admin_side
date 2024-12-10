<?php
include 'databaseconnect.php'; // Database connection
include 'header.php';
include 'drawer.php';

$busesInParking = $conn->query("SELECT COUNT(*) AS count FROM buses WHERE status = 'parking'")->fetch_assoc()['count'];
$availableDrivers = $conn->query("SELECT COUNT(*) AS count FROM drivers")->fetch_assoc()['count'];
$busesOnTrip = $conn->query("SELECT COUNT(*) AS count FROM trips WHERE status = 'in_progress'")->fetch_assoc()['count'];
$busesNeedingMaintenance = "-";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

<main style="margin-left: 300px; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="font-size: 32px; margin-bottom: 20px;">Dashboard</h1>

    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <div style="background: lightgreen; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Buses in Parking</h3>
            <p style="font-size: 20px;"><?php echo $busesInParking; ?></p>
        </div>
        <div style="background: lightgreen; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Available Drivers</h3>
            <p style="font-size: 20px;"><?php echo $availableDrivers; ?></p>
        </div>
    </div>

    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <div style="background: #ade7f9; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Buses on Trip</h3>
            <p style="font-size: 20px;"><?php echo $busesOnTrip; ?></p>
        </div>
        <div style="background: #ade7f9; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Buses Needing Maintenance</h3>
            <p style="font-size: 20px;"><?php echo $busesNeedingMaintenance; ?></p>
        </div>
        <div style="background: #f5f544; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); display: flex; justify-content: center; align-items: center;">
            <button 
                onclick="window.location.href='setTrips.php'"
                style="width: 100%; height: 100%; font-size: 24px; padding: 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; display: flex; justify-content: center; align-items: center; border-radius: 10px;">
                Create Trip
            </button>
        </div>
    </div>
</main>

</body>
</html>
