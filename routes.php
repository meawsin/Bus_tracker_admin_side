<?php
include 'databaseconnect.php';

// Fetch all routes
$routes = $conn->query("SELECT * FROM routes");

// Add a new route
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_route'])) {
    $name = $_POST['name'];
    $start_point = $_POST['start_point'];
    $end_point = $_POST['end_point'];
    $stoppages = $_POST['stoppages'];
    $route_type = $_POST['route_type'];

    $stmt = $conn->prepare("INSERT INTO routes (name, start_point, end_point, stoppages, route_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $start_point, $end_point, $stoppages, $route_type);
    if ($stmt->execute()) {
        $successMessage = 'Route added successfully!';
    }
    $stmt->close();
}

include 'header.php';
include 'drawer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Routes Management</title>
    <style>
        /* Modal styling */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
        }
        .modal-content h3 {
            margin-top: 0;
        }
        .modal-content input, .modal-content select, .modal-content textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .modal-content button {
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .success-message {
            background: lightgreen;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 18px;
            color: darkgreen;
        }
    </style>
</head>
<body>

<main style="margin-left: 300px; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="font-size: 32px; margin-bottom: 20px;">Routes Management</h1>

    <!-- Success Message -->
    <?php if (!empty($successMessage)): ?>
        <div class="success-message"><?= $successMessage ?></div>
    <?php endif; ?>

    <!-- List of Routes -->
    <div style="background: lightgreen; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">All Routes</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 18px;">
            <thead>
                <tr style="background-color: #f9f9f9; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Start Point</th>
                    <th style="padding: 10px;">End Point</th>
                    <th style="padding: 10px;">Stoppages</th>
                    <th style="padding: 10px;">Type</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $routes->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 10px;"><?= $row['id'] ?></td>
                        <td style="padding: 10px;"><?= $row['name'] ?></td>
                        <td style="padding: 10px;"><?= $row['start_point'] ?></td>
                        <td style="padding: 10px;"><?= $row['end_point'] ?></td>
                        <td style="padding: 10px;"><?= $row['stoppages'] ?></td>
                        <td style="padding: 10px;"><?= ucfirst($row['route_type']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Route Button -->
    <button id="addRouteBtn" style="padding: 10px 20px; font-size: 18px; background: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer;">Add Route</button>
</main>

<!-- Modal for Adding Route -->
<div class="modal" id="addRouteModal">
    <div class="modal-content">
        <h3>Add New Route</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Route Name" required>
            <input type="text" name="start_point" placeholder="Start Point" required>
            <input type="text" name="end_point" placeholder="End Point" required>
            <textarea name="stoppages" placeholder="Stoppages (comma separated)" required></textarea>
            <select name="route_type" required>
                <option value="up">Up</option>
                <option value="down">Down</option>
            </select>
            <button type="submit" name="add_route">Add Route</button>
        </form>
    </div>
</div>

<script>
    const addRouteBtn = document.getElementById('addRouteBtn');
    const addRouteModal = document.getElementById('addRouteModal');

    addRouteBtn.addEventListener('click', () => {
        addRouteModal.classList.add('active');
    });

    // Close modal when clicking outside the modal content
    addRouteModal.addEventListener('click', (e) => {
        if (e.target === addRouteModal) {
            addRouteModal.classList.remove('active');
        }
    });
</script>

</body>
</html>
