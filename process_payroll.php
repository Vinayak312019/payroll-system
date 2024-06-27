<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $present_days = $_POST['present_days'];
    $overtime_days = $_POST['overtime_days'];
    $other = $_POST['other'];
    $bonus = $_POST['bonus'];
    $pf = $_POST['pf'];
    $esic = $_POST['esic'];
    $loan_deducted = $_POST['loan_deducted'];
    $lwf = $_POST['lwf'];
    $profession_tax = $_POST['profession_tax'];

    // Fetch employee's basic salary from database
    $sql = "SELECT BasicSalary FROM Employees WHERE EmployeeID = $employee_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $basic_salary = $row['BasicSalary'];
    } else {
        echo "Error: Employee not found";
        exit;
    }

    // Calculate number of days in the specified month and year
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Calculate per day salary based on actual number of days in the month
    $per_day_salary = $basic_salary / $days_in_month;

    // Calculate other components based on per day salary
    $inhand_salary = $per_day_salary * $present_days;
    $overtime_pay = $per_day_salary * $overtime_days;
    $total_pay = $inhand_salary + $overtime_pay + $other + $bonus;
    $net_pay = $total_pay - ($pf + $esic + $loan_deducted + $lwf + $profession_tax);

    // Prepare SQL statement for inserting payroll data
    $sql = "INSERT INTO Payroll (EmployeeID, Month, Year, BasicSalary, PresentDays, OvertimeDays, Other, Bonus, PF, ESIC, LoanDeducted, LWF, ProfessionTax, InhandSalary, OvertimePay, TotalPay, NetPay) 
            VALUES ($employee_id, $month, $year, $basic_salary, $present_days, $overtime_days, $other, $bonus, $pf, $esic, $loan_deducted, $lwf, $profession_tax, $inhand_salary, $overtime_pay, $total_pay, $net_pay)";

    if ($conn->query($sql) === TRUE) {
        // Update LoanBalance in Employees table
        $sql = "SELECT LoanBalance FROM Employees WHERE EmployeeID=$employee_id";
        $result = $conn->query($sql);
        $employee = $result->fetch_assoc();
        $new_loan_balance = $employee['LoanBalance'] - $loan_deducted;

        $sql = "UPDATE Employees SET LoanBalance=$new_loan_balance WHERE EmployeeID=$employee_id";
        $conn->query($sql);

        echo "Payroll processed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all employees
$sql = "SELECT EmployeeID, Name FROM Employees";
$employees = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payroll</title>
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
            display: grid;
            gap: 10px;
        }
        label {
            font-weight: bold;
        }
        input[type="number"],
        input[type="submit"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #333;
            overflow: hidden;
        }
        li {
            float: left;
        }
        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Process Payroll</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="employee_id">Select Employee:</label>
            <select name="employee_id" id="employee_id" required>
                <?php while ($row = $employees->fetch_assoc()): ?>
                    <option value="<?php echo $row['EmployeeID']; ?>"><?php echo $row['Name']; ?></option>
                <?php endwhile; ?>
            </select>
            <label for="month">Month:</label>
            <input type="number" id="month" name="month" min="1" max="12" required>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required>
            <label for="present_days">Present Days:</label>
            <input type="number" id="present_days" name="present_days" required>
            <label for="overtime_days">Overtime Days:</label>
            <input type="number" id="overtime_days" name="overtime_days" required>
            <label for="other">Other:</label>
            <input type="number" id="other" name="other" step="0.01" required>
            <label for="bonus">Bonus:</label>
            <input type="number" id="bonus" name="bonus" step="0.01" required>
            <label for="pf">PF:</label>
            <input type="number" id="pf" name="pf" step="0.01" required>
            <label for="esic">ESIC:</label>
            <input type="number" id="esic" name="esic" step="0.01" required>
            <label for="loan_deducted">Loan Deducted:</label>
            <input type="number" id="loan_deducted" name="loan_deducted" step="0.01" required>
            <label for="lwf">LWF:</label>
            <input type="number" id="lwf" name="lwf" step="0.01" required>
            <label for="profession_tax">Profession Tax:</label>
            <input type="number" id="profession_tax" name="profession_tax" step="0.01" required>
            <input type="submit" value="Process Payroll">
        </form>
    </div>
    <ul>
            <li><a href="index.php">Main Page</a></li>
            <li><a href="list_employees.php">Edit/Delete Employee</a></li>
            <li><a href="add_employee.php">Add Employee</a></li>
            <li><a href="generate_report.php">Generate Report</a></li>
        </ul>

    <!-- Copyright Notice -->
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </footer>
</body>
</html>











