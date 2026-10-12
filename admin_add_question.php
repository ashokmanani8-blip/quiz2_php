<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) { 
    header("Location: admin_login.php"); 
    exit(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = trim($_POST['question']);
    $opt_a = trim($_POST['option_a']);
    $opt_b = trim($_POST['option_b']);
    $opt_c = trim($_POST['option_c']);
    $opt_d = trim($_POST['option_d']);
    $correct = strtolower(trim($_POST['correct_option']));

    $stmt = $conn->prepare("INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_option) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $question, $opt_a, $opt_b, $opt_c, $opt_d, $correct);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card form-card">
            <h2>Add New Question</h2>
            <p class="subtitle">Fill out the details to add a question to the quiz database</p>
            <form method="POST" class="form-box">
                <div class="input-group">
                    <label>Question Statement:</label>
                    <textarea name="question" rows="3" required placeholder="Type the question here..."></textarea>
                </div>
                <div class="options-grid">
                    <div class="input-group">
                        <label>Option A:</label>
                        <input type="text" name="option_a" required placeholder="Option A text">
                    </div>
                    <div class="input-group">
                        <label>Option B:</label>
                        <input type="text" name="option_b" required placeholder="Option B text">
                    </div>
                    <div class="input-group">
                        <label>Option C:</label>
                        <input type="text" name="option_c" required placeholder="Option C text">
                    </div>
                    <div class="input-group">
                        <label>Option D:</label>
                        <input type="text" name="option_d" required placeholder="Option D text">
                    </div>
                </div>
                <div class="input-group">
                    <label>Correct Option (Enter a, b, c, or d):</label>
                    <input type="text" name="correct_option" maxlength="1" required placeholder="e.g. a">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn primary-btn">Save Question</button>
                    <a href="admin_dashboard.php" class="btn secondary-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>