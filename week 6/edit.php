<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
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
        <h2>Edit Student</h2>
        
        <?php
        if (!isset($_GET['id'])) {
            die("Student ID not specified.");
        }
        
        $id = $_GET['id'];
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$student) {
            die("Student not found.");
        }
        ?>
        
        <form method="POST" action="">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
            
            <label>Course:</label>
            <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>" required>
            
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" name="update" value="Update Student">
        </form>

        <?php
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $course = $_POST['course'];
            
            // Check if email exists for other students
            $check = $pdo->prepare("SELECT id FROM students WHERE email = ? AND id != ?");
            $check->execute([$email, $id]);
            
            if ($check->rowCount() > 0) {
                echo "<p style='color:red;'>Email already exists for another student!</p>";
            } else {
                $stmt = $pdo->prepare("UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?");
                $stmt->execute([$name, $email, $course, $id]);
                echo "<script>alert('Student updated successfully!'); window.location.href='index.php';</script>";
            }
        }
        ?>
    </div>
</body>
</html>