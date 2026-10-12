<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$result_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM results WHERE id = ?");
$stmt->bind_param("i", $result_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Result not found!";
    exit();
}

$row = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Result Certificate - <?php echo htmlspecialchars($row['student_name']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #fff; }
        .print-container { max-width: 700px; margin: 40px auto; border: 2px solid #333; padding: 40px; border-radius: 10px; text-align: center; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .print-container { border: none; margin: 0; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-container">
        <h1>Pakistan Current Affairs Quiz</h1>
        <h3>Official Score Card</h3>
        <hr style="margin: 20px 0;">
        <p style="font-size: 18px;">Student Name: <strong><?php echo htmlspecialchars($row['student_name']); ?></strong></p>
        <p style="font-size: 18px;">Student ID: <strong><?php echo htmlspecialchars($row['student_id']); ?></strong></p>
        
        <div class="score-box" style="margin: 30px auto; width: 50%;">
            <p>Final Score</p>
            <h1 style="font-size: 40px; color: #007bff;"><?php echo $row['score']; ?> / <?php echo $row['total_questions']; ?></h1>
        </div>
        
        <p>Date & Time: <?php echo $row['quiz_date']; ?></p>
        
        <div class="no-print" style="margin-top: 30px;">
            <button onclick="window.print()" class="btn">Print Again</button>
            <a href="index.php" class="btn btn-secondary">Home Page</a>
        </div>
    </div>
</body>
</html>