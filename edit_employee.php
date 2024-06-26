<?php
include 'config.php';

// Check if EmployeeID is provided via GET
if (isset($_GET['EmployeeID'])) {
    $employee_id = $_GET['EmployeeID'];

    // Fetch employee details
    $sql = "SELECT * FROM Employees WHERE EmployeeID = $employee_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Employee not found";
        exit;
    }
} else {
    echo "EmployeeID not provided";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
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
            min-height: 100vh; /* Ensure the page fills at least the viewport height */
            position: relative; /* Needed for absolute positioning */
        }
        .container {
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 50px; /* Space between container and copyright */
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
        input[type="text"],
        input[type="number"],
        input[type="date"] {
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
        .delete-button {
            margin-top: 10px;
            text-align: center;
        }
        .delete-button input[type="submit"] {
            background-color: #f44336;
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
        <h1>Edit Employee</h1>
        <form method="post" action="update_employee.php">
            <input type="hidden" name="employee_id" value="<?php echo $employee['EmployeeID']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $employee['Name']; ?>" required><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $employee['Age']; ?>" required><br>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?php echo $employee['DOB']; ?>" required><br>
            <label for="join_date">Join Date:</label>
            <input type="date" id="join_date" name="join_date" value="<?php echo $employee['JoinDate']; ?>" required><br>
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" value="<?php echo $employee['Department']; ?>" required><br>
            <label for="loan_balance">Loan Balance:</label>
            <input type="number" id="loan_balance" name="loan_balance" step="0.01" value="<?php echo $employee['LoanBalance']; ?>" required><br>
            <!-- Add Basic Salary field -->
            <label for="basic_salary">Basic Salary:</label>
            <input type="number" id="basic_salary" name="basic_salary" step="0.01" value="<?php echo $employee['BasicSalary']; ?>" required><br>
            <input type="submit" value="Update Employee">
        </form>
        <div class="delete-button">
            <form method="post" action="delete_employee.php" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                <input type="hidden" name="employee_id" value="<?php echo $employee['EmployeeID']; ?>">
                <input type="submit" value="Delete Employee">
            </form>
        </div>
    </div>

    <div class="copyright">
        <p>&copy; <?php echo date("Y"); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </div>
</body>
</html>










