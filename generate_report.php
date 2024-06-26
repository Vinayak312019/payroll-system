<?php
include 'config.php';

// Function to get the number of days in a specific month and year
function getDaysInMonth($month, $year) {
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}

// Check if form is submitted and month/year are provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];

    $sql = "SELECT p.*, e.Name, e.Age, e.DOB, e.JoinDate, e.Department, e.LoanBalance
            FROM Payroll p 
            JOIN Employees e ON p.EmployeeID = e.EmployeeID 
            WHERE p.Month = $month AND p.Year = $year";

    $result = $conn->query($sql);
    if (!$result) {
        throw new mysqli_sql_exception($conn->error);
    }

    $payroll_data = $result->fetch_all(MYSQLI_ASSOC);

    // Calculate gross pay
    $gross_pay = 0;
    $earned_salary = 0;
    foreach ($payroll_data as $payroll) {
        $gross_pay += $payroll['NetPay'];
        $earned_salary += $payroll['TotalPay'];
    }
}

// Process form submission to edit payroll
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_employee_id'])) {
    $edit_employee_id = $_POST['edit_employee_id'];
    $edit_month = $_POST['edit_month'];
    $edit_year = $_POST['edit_year'];
    $edit_basic_salary = $_POST['edit_basic_salary'];
    $edit_present_days = $_POST['edit_present_days'];
    $edit_overtime_days = $_POST['edit_overtime_days'];
    $edit_other = $_POST['edit_other'];
    $edit_bonus = $_POST['edit_bonus'];
    $edit_pf = $_POST['edit_pf'];
    $edit_esic = $_POST['edit_esic'];
    $edit_loan_deducted = $_POST['edit_loan_deducted'];
    $edit_lwf = $_POST['edit_lwf'];
    $edit_profession_tax = $_POST['edit_profession_tax'];

    // Get the number of days in the specified month and year
    $days_in_month = getDaysInMonth($edit_month, $edit_year);
    
    // Calculate updated values
    $edit_per_day_salary = $edit_basic_salary / $days_in_month;
    $edit_inhand_salary = $edit_per_day_salary * $edit_present_days;
    $edit_overtime_pay = $edit_per_day_salary * $edit_overtime_days;
    $edit_total_pay = $edit_inhand_salary + $edit_overtime_pay + $edit_other + $edit_bonus;
    $edit_net_pay = $edit_total_pay - ($edit_pf + $edit_esic + $edit_loan_deducted + $edit_lwf + $edit_profession_tax);

    // Update Payroll record
    $sql_update = "UPDATE Payroll SET
                    BasicSalary = $edit_basic_salary,
                    PresentDays = $edit_present_days,
                    OvertimeDays = $edit_overtime_days,
                    Other = $edit_other,
                    Bonus = $edit_bonus,
                    PF = $edit_pf,
                    ESIC = $edit_esic,
                    LoanDeducted = $edit_loan_deducted,
                    LWF = $edit_lwf,
                    ProfessionTax = $edit_profession_tax,
                    InhandSalary = $edit_inhand_salary,
                    OvertimePay = $edit_overtime_pay,
                    TotalPay = $edit_total_pay,
                    NetPay = $edit_net_pay
                  WHERE EmployeeID = $edit_employee_id AND Month = $edit_month AND Year = $edit_year";

    if ($conn->query($sql_update) === TRUE) {
        // Update the loan balance in the Employees table
        $sql_update_loan_balance = "UPDATE Employees SET LoanBalance = LoanBalance - $edit_loan_deducted WHERE EmployeeID = $edit_employee_id";
        if ($conn->query($sql_update_loan_balance) === TRUE) {
            echo "Payroll and loan balance updated successfully";
        } else {
            echo "Error updating loan balance: " . $conn->error;
        }
    } else {
        echo "Error updating payroll record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Monthly Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
            overflow-x: hidden; /* Prevent horizontal overflow */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            overflow: hidden; /* Prevent content overflow */
        }
        h1, h2, h3 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        form input[type="number"], form input[type="submit"] {
            padding: 8px;
            margin: 5px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            overflow-x: auto; /* Allow horizontal scrolling for tables */
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-size: 16px;
        }
        td {
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .edit-form {
            text-align: center;
        }
        .edit-form input[type="number"] {
            width: 70px;
            padding: 5px;
            margin: 2px;
            font-size: 14px;
        }
        .edit-form input[type="submit"] {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .print-button {
            text-align: center;
            margin-top: 20px;
        }
        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
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
        <h1>Generate Monthly Report</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            Month: <input type="number" name="month" min="1" max="12" required>
            Year: <input type="number" name="year" required>
            <input type="submit" value="Generate Report">
        </form>

        <?php if (isset($payroll_data)): ?>
            <h2>Monthly Payroll Report for <?php echo $month . '/' . $year; ?></h2>
            <div style="overflow-x: auto;"> <!-- Allow horizontal scrolling -->
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>DOB</th>
                            <th>Join Date</th>
                            <th>Department</th>
                            <th>Loan Balance</th>
                            <th>Basic Salary</th>
                            <th>Present Days</th>
                            <th>Overtime Days</th>
                            <th>Other</th>
                            <th>Bonus</th>
                            <th>PF</th>
                            <th>ESIC</th>
                            <th>Loan Deducted</th>
                            <th>LWF</th>
                            <th>Profession Tax</th>
                            <th>Inhand Salary</th>
                            <th>Overtime Pay</th>
                            <th>Total Pay</th>
                            <th>Net Pay</th>
                            <th>Per Day Salary</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payroll_data as $payroll): ?>
                            <tr>
                                <td><?php echo $payroll['Name']; ?></td>
                                <td><?php echo $payroll['Age']; ?></td>
                                <td><?php echo $payroll['DOB']; ?></td>
                                <td><?php echo $payroll['JoinDate']; ?></td>
                                <td><?php echo $payroll['Department']; ?></td>
                                <td><?php echo $payroll['LoanBalance']; ?></td>
                                <td><?php echo $payroll['BasicSalary']; ?></td>
                                <td><?php echo $payroll['PresentDays']; ?></td>
                                <td><?php echo $payroll['OvertimeDays']; ?></td>
                                <td><?php echo $payroll['Other']; ?></td>
                                <td><?php echo $payroll['Bonus']; ?></td>
                                <td><?php echo $payroll['PF']; ?></td>
                                <td><?php echo $payroll['ESIC']; ?></td>
                                <td><?php echo $payroll['LoanDeducted']; ?></td>
                                <td><?php echo $payroll['LWF']; ?></td>
                                <td><?php echo $payroll['ProfessionTax']; ?></td>
                                <td><?php echo $payroll['InhandSalary']; ?></td>
                                <td><?php echo $payroll['OvertimePay']; ?></td>
                                <td><?php echo $payroll['TotalPay']; ?></td>
                                <td><?php echo $payroll['NetPay']; ?></td>
                                <td><?php echo number_format($payroll['BasicSalary'] / getDaysInMonth($payroll['Month'], $payroll['Year']), 2); ?></td>
                                <td>
                                    <form method="post" class="edit-form" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <input type="hidden" name="edit_employee_id" value="<?php echo $payroll['EmployeeID']; ?>">
                                        <input type="hidden" name="edit_month" value="<?php echo $payroll['Month']; ?>">
                                        <input type="hidden" name="edit_year" value="<?php echo $payroll['Year']; ?>">
                                        <input type="number" name="edit_basic_salary" value="<?php echo $payroll['BasicSalary']; ?>" required>
                                        <input type="number" name="edit_present_days" value="<?php echo $payroll['PresentDays']; ?>" required>
                                        <input type="number" name="edit_overtime_days" value="<?php echo $payroll['OvertimeDays']; ?>" required>
                                        <input type="number" name="edit_other" value="<?php echo $payroll['Other']; ?>" required>
                                        <input type="number" name="edit_bonus" value="<?php echo $payroll['Bonus']; ?>" required>
                                        <input type="number" name="edit_pf" value="<?php echo $payroll['PF']; ?>" required>
                                        <input type="number" name="edit_esic" value="<?php echo $payroll['ESIC']; ?>" required>
                                        <input type="number" name="edit_loan_deducted" value="<?php echo $payroll['LoanDeducted']; ?>" required>
                                        <input type="number" name="edit_lwf" value="<?php echo $payroll['LWF']; ?>" required>
                                        <input type="number" name="edit_profession_tax" value="<?php echo $payroll['ProfessionTax']; ?>" required>
                                        <input type="submit" value="Update">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <h3>Total Gross Pay for <?php echo $month . '/' . $year; ?>: <?php echo number_format($gross_pay, 2); ?></h3>
            <h3>Total Earned Salary for <?php echo $month . '/' . $year; ?>: <?php echo number_format($earned_salary, 2); ?></h3>
            <div class="print-button">
                <button onclick="window.print()">Print Report</button>
            </div>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </footer>
</body>
</html>











