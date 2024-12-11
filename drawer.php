<?php
function renderDrawer() {
    echo "
    <nav style='background-color: #1d7f28; color: white; width: 250px; padding: 20px; position: fixed; height: 100%; font-family: Arial, sans-serif; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);'>
        <div style='margin-bottom: 40px; text-align: center;'>
            <h3 style='color: white; font-size: 30px; font-weight: bold;'>Admin Panel</h3>
        </div>
        <ul style='list-style: none; padding: 0;'>
            <li style='margin-bottom: 25px;'>
                <a href='index.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-tachometer-alt' style='margin-right: 15px; font-size: 22px;'></i>
                    Dashboard
                </a>
            </li>
            <li style='margin-bottom: 25px;'>
                <a href='buses.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-bus' style='margin-right: 15px; font-size: 22px;'></i>
                    Buses
                </a>
            </li>
            <li style='margin-bottom: 25px;'>
                <a href='drivers.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-user' style='margin-right: 15px; font-size: 22px;'></i>
                    Drivers
                </a>
            </li>
            <li style='margin-bottom: 25px;'>
                <a href='routes.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-route' style='margin-right: 15px; font-size: 22px;'></i>
                    Routes
                </a>
            </li>
            <li style='margin-bottom: 25px;'>
                <a href='send_messages.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-paper-plane' style='margin-right: 15px; font-size: 22px;'></i>
                    Send Message to Users
                </a>
            </li>
            <li style='margin-bottom: 25px;'>
                <a href='trip_details.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-calendar-check' style='margin-right: 15px; font-size: 22px;'></i>
                    Trip Details
                </a>
            </li>
            <li style='margin-bottom: 25px;'>
                <a href='complaints.php' style='color: white; text-decoration: none; display: flex; align-items: center; padding: 15px 20px; border-radius: 10px; font-size: 18px; transition: background-color 0.3s, transform 0.3s;'>
                    <i class='fas fa-exclamation-circle' style='margin-right: 15px; font-size: 22px;'></i>
                    Complaints
                </a>
            </li>
        </ul>
    </nav>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php renderDrawer(); ?>
</body>
</html>
