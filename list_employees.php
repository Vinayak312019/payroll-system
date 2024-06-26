<?php
include 'config.php';

// Fetch all employees
$sql = "SELECT EmployeeID, Name FROM Employees";
$employees = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Employees</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        li:hover {
            background-color: #e0e0e0;
        }
        li a {
            text-decoration: none;
            padding: 6px 12px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        li a.edit {
            background-color: #4CAF50;
        }
        li a.delete {
            background-color: #f44336;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>List of Employees</h1>
        <ul>
            <?php while ($row = $employees->fetch_assoc()): ?>
                <li>
                    <?php echo htmlspecialchars($row['Name']); ?>
                    <div>
                        <a href="edit_employee.php?EmployeeID=<?php echo $row['EmployeeID']; ?>" class="edit">Edit</a>
                        <a href="delete_employee.php?EmployeeID=<?php echo $row['EmployeeID']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- Copyright Notice -->
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </footer>
</body>
</html>




