<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pakistan Current Affairs Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Pakistan Current Affairs Quiz</h1>
        <form action="quiz.php" method="POST" class="form-box">
            <div class="input-group">
                <label>Student Name:</label>
                <input type="text" name="student_name" required placeholder="Enter your full name">
            </div>
            <div class="input-group">
                <label>Student ID:</label>
                <input type="text" name="student_id" required placeholder="Enter your student ID">
            </div>
            <button type="submit" class="btn">Start Quiz</button>
        </form>
        <div style="margin-top: 20px; text-align: center;">
            <a href="admin_login.php" style="color: #5ee0cb; text-decoration: none; font-weight: bold;">Admin Login</a>
        </div>
    </div>
</body>
</html>