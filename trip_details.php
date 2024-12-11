<?php
include 'databaseconnect.php';
include 'header.php';
include 'drawer.php';

$conn->query("UPDATE trips SET status = 'in_progress' WHERE status = 'scheduled' AND start_time <= NOW()");

$ongoingTrips = $conn->query("
    SELECT t.id, t.date, t.start_time, t.status, b.name AS bus_name, r.name AS route_name,
           d1.name AS driver1_name, d2.name AS driver2_name
    FROM trips t
    JOIN buses b ON t.bus_id = b.id
    JOIN routes r ON t.route_id = r.id
    JOIN drivers d1 ON t.driver1_id = d1.id
    LEFT JOIN drivers d2 ON t.driver2_id = d2.id
    WHERE t.status = 'in_progress'
    ORDER BY t.date, t.start_time
");

$upcomingTrips = $conn->query("
    SELECT t.id, t.date, t.start_time, t.status, b.name AS bus_name, r.name AS route_name,
           d1.name AS driver1_name, d2.name AS driver2_name
    FROM trips t
    JOIN buses b ON t.bus_id = b.id
    JOIN routes r ON t.route_id = r.id
    JOIN drivers d1 ON t.driver1_id = d1.id
    LEFT JOIN drivers d2 ON t.driver2_id = d2.id
    WHERE t.status = 'scheduled' AND t.start_time > NOW()
    ORDER BY t.date, t.start_time
");

// Fetch past trips (completed or cancelled)
$pastTrips = $conn->query("
    SELECT t.id, t.date, t.start_time, t.status, b.name AS bus_name, r.name AS route_name,
           d1.name AS driver1_name, d2.name AS driver2_name
    FROM trips t
    JOIN buses b ON t.bus_id = b.id
    JOIN routes r ON t.route_id = r.id
    JOIN drivers d1 ON t.driver1_id = d1.id
    LEFT JOIN drivers d2 ON t.driver2_id = d2.id
    WHERE t.status IN ('completed', 'cancelled') AND t.start_time < NOW()
    ORDER BY t.date DESC, t.start_time DESC
");

// Handle date filter
$filteredTrips = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter_date'])) {
    $filterDate = $_POST['filter_date'];
    $filteredTrips = $conn->query("
        SELECT t.id, t.date, t.start_time, t.status, b.name AS bus_name, r.name AS route_name,
               d1.name AS driver1_name, d2.name AS driver2_name
        FROM trips t
        JOIN buses b ON t.bus_id = b.id
        JOIN routes r ON t.route_id = r.id
        JOIN drivers d1 ON t.driver1_id = d1.id
        LEFT JOIN drivers d2 ON t.driver2_id = d2.id
        WHERE t.date = '$filterDate'
        ORDER BY t.date, t.start_time
    ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Details</title>
    <style>
        main {
            margin-left: 300px;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .filter-form {
            margin-bottom: 20px;
        }

        .print-btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<main>
    <h1>Trip Details</h1>

    <!-- Date Filter Form -->
    <form method="post" class="filter-form">
        <label for="filter_date">Filter by Date:</label>
        <input type="date" name="filter_date" required>
        <button type="submit">Filter</button>
    </form>

    <?php if ($filteredTrips): ?>
        <h2>Filtered Trips</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>Bus</th>
                    <th>Route</th>
                    <th>Primary Driver</th>
                    <th>Secondary Driver</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $filteredTrips->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['bus_name']; ?></td>
                        <td><?php echo $row['route_name']; ?></td>
                        <td><?php echo $row['driver1_name']; ?></td>
                        <td><?php echo $row['driver2_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Ongoing Trips -->
    <h2>Ongoing Trips</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Bus</th>
                <th>Route</th>
                <th>Primary Driver</th>
                <th>Secondary Driver</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($ongoingTrips->num_rows > 0): ?>
                <?php while ($row = $ongoingTrips->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['bus_name']; ?></td>
                        <td><?php echo $row['route_name']; ?></td>
                        <td><?php echo $row['driver1_name']; ?></td>
                        <td><?php echo $row['driver2_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No ongoing trips</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Upcoming Trips -->
    <h2>Upcoming Trips</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Bus</th>
                <th>Route</th>
                <th>Primary Driver</th>
                <th>Secondary Driver</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($upcomingTrips->num_rows > 0): ?>
                <?php while ($row = $upcomingTrips->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['bus_name']; ?></td>
                        <td><?php echo $row['route_name']; ?></td>
                        <td><?php echo $row['driver1_name']; ?></td>
                        <td><?php echo $row['driver2_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No upcoming trips</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Past Trips -->
    <h2>Past Trips</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Start Time</th>
                <th>Bus</th>
                <th>Route</th>
                <th>Primary Driver</th>
                <th>Secondary Driver</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($pastTrips->num_rows > 0): ?>
                <?php while ($row = $pastTrips->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['start_time']; ?></td>
                        <td><?php echo $row['bus_name']; ?></td>
                        <td><?php echo $row['route_name']; ?></td>
                        <td><?php echo $row['driver1_name']; ?></td>
                        <td><?php echo $row['driver2_name']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No past trips</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<script>
    function printTable(tableId) {
        const table = document.getElementById(tableId);
        const newWindow = window.open("", "", "width=800, height=600");
        newWindow.document.write("<html><head><title>Print Table</title></head><body>");
        newWindow.document.write(table.outerHTML);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        newWindow.print();
    }
</script>
</body>
</html>
