<?php
include 'config.php';

$message = '';
$error_message = '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $join_date = $_POST['join_date'];
    $department = $_POST['department'];
    $loan_balance = $_POST['loan_balance'];

    // Update employee details in database
    $sql = "UPDATE Employees SET Name='$name', Age=$age, DOB='$dob', JoinDate='$join_date', Department='$department', LoanBalance=$loan_balance 
            WHERE EmployeeID=$employee_id";

    if ($conn->query($sql) === TRUE) {
        $message = "Employee updated successfully";
    } else {
        $error_message = "Error updating employee: " . $conn->error;
    }

    // Fetch updated employee details from database
    $sql_fetch = "SELECT * FROM Employees WHERE EmployeeID = $employee_id";
    $result = $conn->query($sql_fetch);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    }
}

// Fetch employee details for editing
if (isset($_GET['EmployeeID'])) {
    $employee_id = $_GET['EmployeeID'];

    // Fetch employee details from database
    $sql = "SELECT * FROM Employees WHERE EmployeeID = $employee_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        $error_message = "Employee not found";
    }
} else {
    $error_message = "Employee ID not provided";
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
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
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
        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="employee_id" value="<?php echo $employee['EmployeeID']; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($employee['Name']) ? $employee['Name'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" value="<?php echo isset($employee['Age']) ? $employee['Age'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo isset($employee['DOB']) ? $employee['DOB'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="join_date">Join Date:</label>
                <input type="date" id="join_date" name="join_date" value="<?php echo isset($employee['JoinDate']) ? $employee['JoinDate'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo isset($employee['Department']) ? $employee['Department'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="loan_balance">Loan Balance:</label>
                <input type="number" id="loan_balance" name="loan_balance" step="0.01" value="<?php echo isset($employee['LoanBalance']) ? $employee['LoanBalance'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Update Employee">
            </div>
        </form>
    </div>

    <div class="copyright">
        <p>&copy; <?php echo date("Y"); ?> Your Company Name. All rights reserved.</p>
    </div>
</body>
</html>


