<?php
session_start();
include 'db.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Galat Password! (Wrong Password)";
        }
    } else {
        $error = "Yeh Username mojood nahi hai! (Invalid Username)";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pakistan Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card login-card">
            <h2>Admin Portal</h2>
            <p class="subtitle">Sign in to manage quiz questions & results</p>
            <?php if (!empty($error)): ?>
                <div class="alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="" method="POST" class="form-box">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" required value="admin" placeholder="Enter username">
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required value="admin123" placeholder="Enter password">
                </div>
                <button type="submit" class="btn primary-btn">Secure Login</button>
            </form>
            <div class="back-link">
                <a href="index.php">&larr; Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>