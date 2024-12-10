<?php
session_start();
include 'databaseconnect.php';

// Assuming $adminName is stored in the session after login
$adminName = $_SESSION['adminName'];
?>
<?php
function renderHeader($adminName) {
    date_default_timezone_set("Asia/Dhaka");
    // Current Date and Time in Bengali format
    $currentDateTime = date('d F Y | h:i:s A');

    echo "
    <header style='background-color: #1d7f28; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif;'>
        <span></span>
        <span id='banglaDateTime' style='font-size: 18px;'>$currentDateTime</span>
        <span style='font-size: 18px; font-weight: bold;'>Welcome, $adminName!</span>
        <button onclick='window.location.href=\"logout.php\"' style='background: none; border: none; color: white; cursor: pointer; font-size: 18px;'>Logout</button>
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
    
    <!-- Include Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- JavaScript for Bengali Clock -->
    <script src="https://cdn.jsdelivr.net/npm/intl@1.2.5/locale-data/jsonp/bn-BD.js"></script>
</head>
<body>
    <?php renderHeader($adminName); ?> <!-- Call the header rendering function -->

    <!-- Main content area -->
    <div style="margin-left: 320px; padding: 20px;">
        <h1 style="font-size: 32px; font-weight: bold;">Welcome to the Admin Panel</h1>
        <p style="font-size: 20px;">This is your control dashboard.</p>
        <!-- Your content goes here -->
    </div>

    <!-- Include JavaScript for updating date/time -->
    <script>
        function updateDateTime() {
            const now = new Date();
            
            // Date formatting for Bengali locale
            const banglaDateFormatter = new Intl.DateTimeFormat('bn-BD', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
            
            const banglaTimeFormatter = new Intl.DateTimeFormat('bn-BD', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            const formattedDate = banglaDateFormatter.format(now);
            const formattedTime = banglaTimeFormatter.format(now);

            // Combine formatted date and time
            const currentDateTime = formattedDate + " | " + formattedTime;
            
            // Update the date-time in the header
            document.getElementById('banglaDateTime').innerHTML = currentDateTime;
        }

        // Update every second
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>
