<?php
include 'databaseconnect.php'; // Database connection
include 'header.php';
include 'drawer.php';

// Fetch all buses
$buses = $conn->query("SELECT * FROM buses");

// Fetch all maintenance records
$maintenanceRecords = $conn->query("
    SELECT m.id, b.name AS bus_name, m.description, m.date 
    FROM maintenance m
    JOIN buses b ON m.bus_id = b.id
");

// Handle status change request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $bus_id = $_POST['bus_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE buses SET status = '$status' WHERE id = '$bus_id'");
    header('Location: buses.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buses Management</title>
</head>
<body>

<main style="margin-left: 300px; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="font-size: 32px; margin-bottom: 20px;">Buses Management</h1>

    <!-- List of Buses -->
    <div style="background: lightyellow; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">All Buses</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 18px;">
            <thead>
                <tr style="background-color: #f9f9f9; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">License Plate</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Type</th>
                    <th style="padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $buses->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 10px;"><?= $row['id'] ?></td>
                        <td style="padding: 10px;"><?= $row['name'] ?></td>
                        <td style="padding: 10px;"><?= $row['license_plate'] ?></td>
                        <td style="padding: 10px;"><?= ucfirst(str_replace('_', ' ', $row['status'])) ?></td>
                        <td style="padding: 10px;"><?= $row['bus_type'] ?></td>
                        <td style="padding: 10px;">
                            <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="bus_id" value="<?= $row['id'] ?>">
                                <select name="status" style="padding: 8px; border-radius: 5px; font-size: 16px;">
                                    <option value="in_service" <?= $row['status'] === 'in_service' ? 'selected' : '' ?>>In Service</option>
                                    <option value="out_of_service" <?= $row['status'] === 'out_of_service' ? 'selected' : '' ?>>Out of Service</option>
                                    <option value="maintenance" <?= $row['status'] === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                    <option value="parking" <?= $row['status'] === 'parking' ? 'selected' : '' ?>>Parking</option>
                                </select>
                                <button type="submit" name="update_status" style="padding: 8px 12px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Maintenance Records -->
    <div style="background: lightblue; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">Maintenance Records</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 18px;">
            <thead>
                <tr style="background-color: #f9f9f9; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Bus</th>
                    <th style="padding: 10px;">Description</th>
                    <th style="padding: 10px;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $maintenanceRecords->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 10px;"><?= $row['id'] ?></td>
                        <td style="padding: 10px;"><?= $row['bus_name'] ?></td>
                        <td style="padding: 10px;"><?= $row['description'] ?></td>
                        <td style="padding: 10px;"><?= $row['date'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
