<?php
include 'config.php';

$message = '';
$error_message = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];

    // Delete from Payroll first to avoid foreign key constraint issue
    $sql_payroll = "DELETE FROM Payroll WHERE EmployeeID=$employee_id";
    if ($conn->query($sql_payroll) === TRUE) {
        // Then delete from Employees
        $sql_employees = "DELETE FROM Employees WHERE EmployeeID=$employee_id";
        if ($conn->query($sql_employees) === TRUE) {
            $message = "Employee deleted successfully";
        } else {
            $error_message = "Error deleting employee: " . $conn->error;
        }
    } else {
        $error_message = "Error deleting employee payroll: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="number"] {
            padding: 8px;
            margin-bottom: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            border-radius: 4px;
        }
        .error {
            margin-top: 20px;
            padding: 10px;
            background-color: #f44336;
            color: white;
            text-align: center;
            border-radius: 4px;
        }
        .copyright {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Employee</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php elseif ($error_message): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php else: ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="employee_id">Employee ID:</label>
                <input type="number" id="employee_id" name="employee_id" required>
                <input type="submit" value="Delete Employee">
            </form>
        <?php endif; ?>
    </div>

    <div class="copyright">
        <p>&copy; <?php echo date("Y"); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </div>
</body>
</html>






