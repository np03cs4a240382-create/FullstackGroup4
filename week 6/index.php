<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        * { font-family: Arial, sans-serif; }
        body { margin: 40px; background: #f5f5f5; }
        h1 { color: #333; }
        h2 { color: #444; }
        table { border-collapse: collapse; width: 100%; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #4CAF50; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a { color: #2196F3; text-decoration: none; margin: 0 5px; }
        a:hover { text-decoration: underline; }
        .add-btn { 
            display: inline-block; 
            background: #4CAF50; 
            color: white; 
            padding: 10px 15px; 
            margin: 20px 0; 
            border-radius: 5px;
        }
        .delete-link { color: #f44336; }
        .container { max-width: 1200px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student List</h1>
        
        <a class="add-btn" href="create.php">Add New Student</a>
        
        <h2>Student Records</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM students ORDER BY id");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['course']}</td>
                        <td>
                            <a href='edit.php?id={$row['id']}'>Edit</a> | 
                            <a class='delete-link' href='index.php?delete={$row['id']}' onclick='return confirm(\"Delete student: {$row['name']}?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <?php
        // Delete functionality
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute([$id]);
            echo "<script>alert('Student deleted successfully!'); window.location.href='index.php';</script>";
        }
        ?>
    </div>
</body>
</html>