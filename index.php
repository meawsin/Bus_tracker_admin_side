<?php
include 'databaseconnect.php';
include 'header.php';
include 'drawer.php';

$busesInParking = $conn->query("SELECT COUNT(*) AS count FROM buses WHERE status = 'parking'")->fetch_assoc()['count'];
$availableDrivers = $conn->query("SELECT COUNT(*) AS count FROM drivers")->fetch_assoc()['count'];
$busesOnTrip = $conn->query("SELECT COUNT(*) AS count FROM trips WHERE status = 'in_progress'")->fetch_assoc()['count'];
$busesNeedingMaintenance = "-";

// Fetch unseen complaints with contact number
$unseenComplaints = $conn->query("SELECT id, Name, SUBJECT, Details, BUP_ID, Contact_no FROM complaints WHERE Status = 'unseen'");

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
            <p style="font-size: 24px;"><?php echo $busesInParking; ?></p>
        </div>
        <div style="background: lightgreen; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Available Drivers</h3>
            <p style="font-size: 24px;"><?php echo $availableDrivers; ?></p>
        </div>
    </div>

    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
        <div style="background: #ade7f9; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Buses on Trip</h3>
            <p style="font-size: 24px;"><?php echo $busesOnTrip; ?></p>
        </div>
        <div style="background: #ade7f9; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="font-size: 24px; margin-bottom: 10px;">Buses Needing Maintenance</h3>
            <p style="font-size: 24px;"><?php echo $busesNeedingMaintenance; ?></p>
        </div>
        <div style="background: #f5f544; padding: 20px; width: 48%; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); display: flex; justify-content: center; align-items: center;">
            <button 
                onclick="window.location.href='setTrips.php'"
                style="width: 100%; height: 100%; font-weight:bold; font-size: 24px; padding: 20px; background-color: #90ee90; color: black; border: none; cursor: pointer; display: flex; justify-content: center; align-items: center; border-radius: 10px;">
                Create Trip
            </button>
        </div>
    </div>

    <!-- Unseen Complaints Table -->
    <div style="background: #ffe6e6; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">Unseen Complaints</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 18px;">
            <thead>
                <tr style="background-color: #f9f9f9; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Subject</th>
                    <th style="padding: 10px;">Details</th>
                    <th style="padding: 10px;">BUP ID</th>
                    <th style="padding: 10px;">Contact No</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $unseenComplaints->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 10px;"><?= $row['id'] ?></td>
                        <td style="padding: 10px;"><?= $row['Name'] ?></td>
                        <td style="padding: 10px;"><?= $row['SUBJECT'] ?></td>
                        <td style="padding: 10px;"><?= nl2br(substr($row['Details'], 0, 150)) ?><?php if (strlen($row['Details']) > 150) echo '...'; ?></td>
                        <td style="padding: 10px;"><?= $row['BUP_ID'] ?></td>
                        <td style="padding: 10px;"><?= $row['Contact_no'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
