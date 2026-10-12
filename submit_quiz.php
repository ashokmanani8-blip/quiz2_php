<?php
session_start();
include 'db.php';

if (!isset($_SESSION['student_name']) || !isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$student_name = $_SESSION['student_name'];
$student_id = $_SESSION['student_id'];
$score = 0;
$total_questions = 15;

$result = $conn->query("SELECT id, correct_option FROM questions LIMIT 15");
$correct_answers = [];
while ($row = $result->fetch_assoc()) {
    $correct_answers[$row['id']] = $row['correct_option'];
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'q_') === 0) {
        $q_id = str_replace('q_', '', $key);
        if (isset($correct_answers[$q_id]) && $correct_answers[$q_id] === $value) {
            $score++;
        }
    }
}


try {
    $stmt = $conn->prepare("INSERT INTO results (student_name, student_id, score, total_questions) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $student_name, $student_id, $score, $total_questions);
    $stmt->execute();
    $result_id = $stmt->insert_id;
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    // Error code 1062 is for duplicate entry in MySQL
    if ($e->getCode() == 1062) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Quiz Error</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <div class="card result-card" style="border-left: 5px solid #dc3545;">
                    <h2 style="color: #dc3545;">Quiz Already Submitted!</h2>
                    <p>Sorry, Student ID <strong><?php echo htmlspecialchars($student_id); ?></strong> has already attempted this quiz.</p>
                    <p>Each student ID can only be registered once.</p>
                    <br>
                    <a href="index.php" class="btn">Back to Home</a>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    } else {
        throw $e;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card result-card">
            <h2>Quiz Completed!</h2>
            <p>Thank you, <strong><?php echo htmlspecialchars($student_name); ?></strong>.</p>
            <div class="score-box">
                <p>Your Score:</p>
                <h1><?php echo $score; ?> / <?php echo $total_questions; ?></h1>
            </div>
            
            <div class="nav-buttons" style="justify-content: center; gap: 15px;">
                <a href="print_result.php?id=<?php echo $result_id; ?>" target="_blank" class="btn btn-success">Print / Download Result</a>
                <a href="index.php" class="btn">Home Page</a>
            </div>
        </div>
    </div>
</body>
</html>