<?php
ob_start(); // Start output buffering
include 'databaseconnect.php';
// Handle add driver form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];

    // Insert new driver into the database
    $stmt = $conn->prepare("INSERT INTO drivers (name, contact) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $contact);
    $stmt->execute();
    $stmt->close();
    header("Location: drivers.php");
    exit;
}

$drivers = $conn->query("SELECT * FROM drivers");
$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $drivers = $conn->query("SELECT * FROM drivers WHERE name LIKE '%$searchQuery%' OR contact LIKE '%$searchQuery%'");
}
include 'header.php';
include 'drawer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drivers</title>
</head>
<body>

<main style="margin-left: 300px; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="font-size: 32px; margin-bottom: 20px;">Drivers</h1>

    <!-- Search Bar Section -->
    <div style="background: lightblue; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">Search Drivers</h3>
        <form method="GET" action="drivers.php" style="display: flex; gap: 10px; align-items: center;">
            <input 
                type="text" 
                name="search" 
                value="<?= htmlspecialchars($searchQuery) ?>" 
                placeholder="Search drivers by name or contact" 
                style="padding: 10px; width: 80%; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;"/>
            <button type="submit" 
                    style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Search
            </button>
        </form>
    </div>

    <!-- Drivers Table Section -->
    <div style="background: lightblue; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">Driver Details</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 18px;">
            <thead>
                <tr style="background-color: #f9f9f9; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Contact</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $drivers->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 10px;"><?= $row['id'] ?></td>
                        <td style="padding: 10px;"><?= $row['name'] ?></td>
                        <td style="padding: 10px;"><?= $row['contact'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add New Driver Form -->
    <div style="background: lightyellow; padding: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">Add New Driver</h3>
        <form method="POST" action="drivers.php">
            <label for="name" style="font-size: 18px;">Name:</label><br>
            <input type="text" name="name" id="name" required style="padding: 10px; width: 80%; font-size: 16px; margin-bottom: 10px;"/><br>

            <label for="contact" style="font-size: 18px;">Contact:</label><br>
            <input type="text" name="contact" id="contact" required style="padding: 10px; width: 80%; font-size: 16px; margin-bottom: 10px;"/><br>

            <button type="submit" 
                    style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
                Add Driver
            </button>
        </form>
    </div>

</main>

</body>
</html>
