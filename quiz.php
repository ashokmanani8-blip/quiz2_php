<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['student_name'] = trim($_POST['student_name']);
    $_SESSION['student_id'] = trim($_POST['student_id']);
}


if (!isset($_SESSION['student_name']) || !isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

$student_id = $_SESSION['student_id'];


$check_stmt = $conn->prepare("SELECT id FROM results WHERE student_id = ?");
$check_stmt->bind_param("s", $student_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    $check_stmt->close();
    
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
                <h2 style="color: #dc3545;">Quiz Already Attempted!</h2>
                <p>Sorry, Student ID <strong><?php echo htmlspecialchars($student_id); ?></strong> has already taken this quiz.</p>
                <p>Each student ID can only be registered once.</p>
                <br>
                <a href="index.php" class="btn">Back to Home</a>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}
$check_stmt->close();


$result = $conn->query("SELECT * FROM questions LIMIT 15");
$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pakistan Current Affairs Quiz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="quiz-header">
            <h2>Student: <?php echo htmlspecialchars($_SESSION['student_name']); ?> (ID: <?php echo htmlspecialchars($_SESSION['student_id']); ?>)</h2>
            <div id="timer">Time Left: <span id="time">10:00</span></div>
        </div>

        <form id="quizForm" action="submit_quiz.php" method="POST">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-card" id="q-<?php echo $index; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                    <h3>Question <?php echo $index + 1; ?> of 15</h3>
                    <p class="q-text"><?php echo htmlspecialchars($q['question']); ?></p>
                    
                    <div class="options">
                        <label><input type="radio" name="q_<?php echo $q['id']; ?>" value="a" required> a) <?php echo htmlspecialchars($q['option_a']); ?></label>
                        <label><input type="radio" name="q_<?php echo $q['id']; ?>" value="b"> b) <?php echo htmlspecialchars($q['option_b']); ?></label>
                        <label><input type="radio" name="q_<?php echo $q['id']; ?>" value="c"> c) <?php echo htmlspecialchars($q['option_c']); ?></label>
                        <label><input type="radio" name="q_<?php echo $q['id']; ?>" value="d"> d) <?php echo htmlspecialchars($q['option_d']); ?></label>
                    </div>

                    <div class="nav-buttons">
                        <?php if ($index > 0): ?>
                            <button type="button" class="btn-secondary" onclick="prevQuestion(<?php echo $index; ?>)">Previous</button>
                        <?php endif; ?>
                        
                        <?php if ($index < count($questions) - 1): ?>
                            <button type="button" class="btn" onclick="nextQuestion(<?php echo $index; ?>, <?php echo count($questions); ?>)">Next</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success">Submit Quiz</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>