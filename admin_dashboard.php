<?php
session_start();
include 'db.php';


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$stats_query = $conn->query("SELECT COUNT(*) as total_students, MAX(score) as max_score, MIN(score) as min_score, AVG(score) as avg_score, AVG(total_questions) as avg_total FROM results");
$stats = $stats_query->fetch_assoc();

$total_students = $stats['total_students'] ?? 0;
$max_score = $stats['max_score'] ?? 0;
$min_score = $stats['min_score'] ?? 0;
$avg_score = $stats['avg_score'] ?? 0;
$avg_total = $stats['avg_total'] ?? 15;
$avg_percentage = ($avg_total > 0) ? ($avg_score / $avg_total) * 100 : 0;


$results_query = $conn->query("SELECT * FROM results ORDER BY score DESC, exam_date ASC");


$questions_query = $conn->query("SELECT * FROM questions");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #2c3e50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-card h4 { margin: 0; font-size: 14px; color: #555; }
        .stat-card h2 { margin: 10px 0 0 0; font-size: 24px; color: #2c3e50; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 1000px;">
        <div class="quiz-header" style="background: #2c3e50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <h2>Admin Dashboard</h2>
            <div>
                <a href="admin_add_question.php" class="btn btn-success" style="padding: 8px 15px; text-decoration: none; border-radius: 4px; margin-right: 10px;">+ Add Question</a>
                <a href="admin_logout.php" class="btn" style="background: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">Logout</a>
            </div>
        </div>

        <!-- New Feature: Summary Statistics Cards (Max, Min, Avg Percentage) -->
        <div class="stats-container">
            <div class="stat-card">
                <h4>Total Students</h4>
                <h2><?php echo $total_students; ?></h2>
            </div>
            <div class="stat-card" style="border-left-color: #28a745;">
                <h4>Highest Score (Max)</h4>
                <h2><?php echo $max_score; ?> / 15</h2>
            </div>
            <div class="stat-card" style="border-left-color: #dc3545;">
                <h4>Lowest Score (Min)</h4>
                <h2><?php echo $min_score; ?> / 15</h2>
            </div>
            <div class="stat-card" style="border-left-color: #17a2b8;">
                <h4>Average Percentage</h4>
                <h2><?php echo number_format($avg_percentage, 1); ?>%</h2>
            </div>
        </div>

        <!-- Section 1: Student Results (Number-wise Ranked & Percentage) -->
        <div class="card" style="width: 100%; margin-bottom: 30px;">
            <h3>Student Quiz Results (Ranked)</h3>
            <br>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f4f4f4;">
                        <th>Rank (#)</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Score</th>
                        <th>Percentage</th>
                        <th>Exam Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($results_query->num_rows > 0): ?>
                        <?php 
                        $rank = 1; 
                        while ($row = $results_query->fetch_assoc()): 
                            $percentage = ($row['total_questions'] > 0) ? ($row['score'] / $row['total_questions']) * 100 : 0;
                        ?>
                            <tr>
                                <td><strong><?php echo $rank++; ?></strong></td>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                <td><strong><?php echo $row['score']; ?> / <?php echo $row['total_questions']; ?></strong></td>
                                <td><span style="color: #2e7d32; font-weight: bold;"><?php echo number_format($percentage, 1); ?>%</span></td>
                                <td><?php echo $row['exam_date']; ?></td>
                                <td>
                                    <a href="admin_delete_result.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Kya aap waqai is result ko delete karna chahte hain?');" style="color: red; text-decoration: none;">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No Any Student Submit the quiz !</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Section 2: Manage Questions -->
        <div class="card" style="width: 100%;">
            <h3>Manage Quiz Questions</h3>
            <br>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f4f4f4;">
                        <th>ID</th>
                        <th>Question</th>
                        <th>Correct Option</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($questions_query->num_rows > 0): ?>
                        <?php while ($q = $questions_query->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $q['id']; ?></td>
                                <td><?php echo htmlspecialchars($q['question']); ?></td>
                                <td><strong style="text-transform: uppercase;"><?php echo $q['correct_option']; ?></strong></td>
                                <td>
                                    <a href="admin_edit_question.php?id=<?php echo $q['id']; ?>" style="color: blue; text-decoration: none; margin-right: 10px;">Edit</a>
                                    <a href="admin_delete_question.php?id=<?php echo $q['id']; ?>" onclick="return confirm('Kya aap is question ko delete karna chahte hain?');" style="color: red; text-decoration: none;">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Koi question mojood nahi hai!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>