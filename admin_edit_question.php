<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) { 
    header("Location: admin_login.php"); 
    exit(); 
}

$id = intval($_GET['id']);
$stmt_get = $conn->prepare("SELECT * FROM questions WHERE id = ?");
$stmt_get->bind_param("i", $id);
$stmt_get->execute();
$q = $stmt_get->get_result()->fetch_assoc();
$stmt_get->close();

if (!$q) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = trim($_POST['question']);
    $opt_a = trim($_POST['option_a']);
    $opt_b = trim($_POST['option_b']);
    $opt_c = trim($_POST['option_c']);
    $opt_d = trim($_POST['option_d']);
    $correct = strtolower(trim($_POST['correct_option']));

    $stmt = $conn->prepare("UPDATE questions SET question=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE id=?");
    $stmt->bind_param("ssssssi", $question, $opt_a, $opt_b, $opt_c, $opt_d, $correct, $id);
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
    <title>Edit Question - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card form-card">
            <h2>Edit Question</h2>
            <p class="subtitle">Modify question details or change the correct answer</p>
            <form method="POST" class="form-box">
                <div class="input-group">
                    <label>Question Statement:</label>
                    <textarea name="question" rows="3" required><?php echo htmlspecialchars($q['question']); ?></textarea>
                </div>
                <div class="options-grid">
                    <div class="input-group">
                        <label>Option A:</label>
                        <input type="text" name="option_a" value="<?php echo htmlspecialchars($q['option_a']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Option B:</label>
                        <input type="text" name="option_b" value="<?php echo htmlspecialchars($q['option_b']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Option C:</label>
                        <input type="text" name="option_c" value="<?php echo htmlspecialchars($q['option_c']); ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Option D:</label>
                        <input type="text" name="option_d" value="<?php echo htmlspecialchars($q['option_d']); ?>" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>Correct Option (a/b/c/d):</label>
                    <input type="text" name="correct_option" value="<?php echo htmlspecialchars($q['correct_option']); ?>" maxlength="1" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn primary-btn">Update Question</button>
                    <a href="admin_dashboard.php" class="btn secondary-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>