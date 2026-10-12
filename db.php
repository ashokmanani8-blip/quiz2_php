<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; 
$db_name = 'pakistan_quiz_db';

$conn = new mysqli('localhost', 'root', '', 'pakistan_quiz_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>