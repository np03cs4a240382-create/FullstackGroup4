<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO students (student_id, full_name, password_hash) VALUES (?,?,?)"
    );
    $stmt->execute([$id, $name, $pass]);

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<main>
<section>
    <h2>Register</h2>

    <form method="post">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</section>
</main>

</body>
</html>
