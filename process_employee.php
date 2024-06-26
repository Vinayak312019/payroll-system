<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $join_date = $_POST['join_date'];
    $department = $_POST['department'];
    $loan_balance = $_POST['loan_balance'];
    $basic_salary = $_POST['basic_salary']; // New addition

    $sql = "INSERT INTO Employees (Name, Age, DOB, JoinDate, Department, LoanBalance, BasicSalary) 
            VALUES ('$name', $age, '$dob', '$join_date', '$department', $loan_balance, $basic_salary)";

    if ($conn->query($sql) === TRUE) {
        echo "Employee added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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
            max-width: 600px;
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Employee</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>
            
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            
            <label for="join_date">Join Date:</label>
            <input type="date" id="join_date" name="join_date" required>
            
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required>
            
            <label for="loan_balance">Loan Balance:</label>
            <input type="number" id="loan_balance" name="loan_balance" step="0.01" required>
            
            <label for="basic_salary">Basic Salary:</label>
            <input type="number" id="basic_salary" name="basic_salary" step="0.01" required>
            
            <input type="submit" value="Add Employee">
        </form>
    </div>
</body>
</html>






