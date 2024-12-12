<?php
include 'databaseconnect.php';

// Fetch complaints
$complaints = $conn->query("SELECT * FROM complaints order by id Desc");

// Handle status change request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];
    $conn->query("UPDATE complaints SET Status = '$status' WHERE id = '$complaint_id'");
    header('Location: complaints.php');
    exit;
}

include 'header.php';
include 'drawer.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
</head>
<body>

<main style="margin-left: 300px; padding: 20px; font-family: Arial, sans-serif;">
    <h1 style="font-size: 32px; margin-bottom: 20px;">Complaints</h1>

    <!-- Complaints Table -->
    <div style="background: lightpink; padding: 20px; margin-bottom: 20px; border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);">
        <h3 style="font-size: 24px; margin-bottom: 10px;">All Complaints</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 18px;">
            <thead>
                <tr style="background-color: #f9f9f9; text-align: left;">
                    <th style="padding: 10px;">ID</th>
                    <th style="padding: 10px;">Name</th>
                    <th style="padding: 10px;">Subject</th>
                    <th style="padding: 10px;">Details</th>
                    <th style="padding: 10px;">BUP ID</th>
                    <th style="padding: 10px;">Contact No.</th>
                    <th style="padding: 10px;">Status</th>
                    <th style="padding: 10px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $complaints->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 10px;"><?= $row['id'] ?></td>
                        <td style="padding: 10px;"><?= $row['Name'] ?></td>
                        <td style="padding: 10px;"><?= $row['SUBJECT'] ?></td>
                        <td style="padding: 10px;"><?= nl2br(substr($row['Details'], 0, 150)) ?><?php if (strlen($row['Details']) > 250) echo '...'; ?></td>
                        <td style="padding: 10px;"><?= $row['BUP_ID'] ?></td>
                        <td style="padding: 10px;"><?= $row['Contact_No'] ?></td>
                        <td style="padding: 10px;"><?= ucfirst(str_replace('_', ' ', $row['Status'])) ?></td>
                        <td style="padding: 10px;">
                            <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="complaint_id" value="<?= $row['id'] ?>">
                                <select name="status" style="padding: 8px; border-radius: 5px; font-size: 16px;">
                                    <option value="unseen" <?= $row['Status'] === 'unseen' ? 'selected' : '' ?>>Unseen</option>
                                    <option value="solved" <?= $row['Status'] === 'solved' ? 'selected' : '' ?>>Solved</option>
                                    <option value="pending/working" <?= $row['Status'] === 'pending/working' ? 'selected' : '' ?>>Pending/Working</option>
                                </select>
                                <button type="submit" name="update_status" style="padding: 8px 12px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>

</body>
</html>
