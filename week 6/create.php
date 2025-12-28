<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Student</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f5f5f5; }
        .container { max-width: 500px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; }
        input[type=text], input[type=email] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; }
        input[type=submit] { background: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; }
        input[type=submit]:hover { background: #45a049; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #2196F3; }
    </style>
</head>
<body>
    <div class="container">
        <a class="back-link" href="index.php">← Back to Student List</a>
        <h2>Add New Student</h2>
        
        <form method="POST" action="">
            <label>Name:</label>
            <input type="text" name="name" placeholder="Enter full name" required>
            
            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter email" required>
            
            <label>Course:</label>
            <input type="text" name="course" placeholder="Enter course" required>
            
            <input type="submit" name="submit" value="Add Student">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $course = $_POST['course'];
            
            // Check if email already exists
            $check = $pdo->prepare("SELECT id FROM students WHERE email = ?");
            $check->execute([$email]);
            
            if ($check->rowCount() > 0) {
                echo "<p style='color:red;'>Email already exists!</p>";
            } else {
                $stmt = $pdo->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
                $stmt->execute([$name, $email, $course]);
                echo "<script>alert('Student added successfully!'); window.location.href='index.php';</script>";
            }
        }
        ?>
    </div>
</body>
</html>