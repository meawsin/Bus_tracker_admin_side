<?php
include 'databaseconnect.php';
include 'header.php';
include 'drawer.php';

if (!isset($_SESSION['adminName'])) {
    header("Location: login.php");
    exit;
}

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
    <div style="margin-bottom: 20px;">
        <form method="GET" action="drivers.php">
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
    <h2 style="font-size: 28px; margin-top: 20px;">Driver Details</h2>
    <table border="1" style="width: 80%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $drivers->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['contact'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Add New Driver Form -->
    <div style="margin-bottom: 20px;">
        <h3>Add New Driver</h3>
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
