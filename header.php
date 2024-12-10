<?php
session_start();
include 'databaseconnect.php';
$adminName = $_SESSION['adminName'];
?>
<?php
function renderHeader($adminName) {
    date_default_timezone_set("Asia/Dhaka");
    $currentDateTime = date('d F Y | h:i:s');

    echo "
    <header style='background-color: #13691df2; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; font-family: Arial, sans-serif;'>
        
        <span id='banglaDateTime' style='font-size: 18px;'>$currentDateTime</span>
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
    
    <script src="https://cdn.jsdelivr.net/npm/intl@1.2.5/locale-data/jsonp/bn-BD.js"></script>
</head>
<body>
    <?php renderHeader($adminName); ?> 

    <script>
        function updateDateTime() {
            const now = new Date();
            
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

            const currentDateTime = formattedDate + " | " + formattedTime;

            document.getElementById('banglaDateTime').innerHTML = currentDateTime;
        }
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>
