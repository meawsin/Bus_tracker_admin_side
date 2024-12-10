<?php 
session_start();
include 'databaseconnect.php';
$adminName = $_SESSION['adminName'];
?>

<?php
function renderHeader($adminName) {
    date_default_timezone_set("Asia/Dhaka");
    $currentDateTime = date('l, F d Y | h:i:s A');

    echo "
    <header style='background-color: #1d7f28; font-size: 20px; font-weight: bold; color: white; padding: 14px; display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif; position: fixed; top: 0; left: 0; width: 98%; z-index: 10;'>
        
        <span id='DateTime' style='font-size: 18px;'>$currentDateTime</span>
        <span style='font-size: 18px; font-weight: bold;'>Welcome, $adminName!
        <button onclick='window.location.href=\"logout.php\"' style='background: none; border: none; color: white; cursor: pointer; font-size: 18px;'>Logout</button></span>
    </header>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body> 
    <?php renderHeader($adminName); ?> 

    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };

            const formattedDateTime = now.toLocaleString('en-US', options);

            document.getElementById('DateTime').innerHTML = formattedDateTime;
        }
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>
