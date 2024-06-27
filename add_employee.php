<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-top: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .copyright {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            text-align: center;
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
    <script>
        function calculateAge() {
            var dob = document.getElementById('dob').value;
            if (dob) {
                var today = new Date();
                var birthDate = new Date(dob);
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById('age').value = age;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Add Employee</h1>
        <form method="post" action="process_employee.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required readonly><br>
            
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required onchange="calculateAge()"><br>
            
            <label for="join_date">Join Date:</label>
            <input type="date" id="join_date" name="join_date" required><br>
            
            <label for="department">Department:</label>
            <input type="text" id="department" name="department" required><br>
            
            <label for="loan_balance">Loan Balance:</label>
            <input type="number" id="loan_balance" name="loan_balance" step="0.01" required><br>
            
            <!-- Added Basic Salary input -->
            <label for="basic_salary">Basic Salary:</label>
            <input type="number" id="basic_salary" name="basic_salary" step="0.01" required><br>
            
            <input type="submit" value="Add Employee">
        </form>
    </div>
    <ul>
            <li><a href="index.php">Main Page</a></li>
            <li><a href="list_employees.php">Edit/Delete Employee</a></li>
            <li><a href="process_payroll.php">Process Payroll</a></li>
            <li><a href="generate_report.php">Generate Report</a></li>
        </ul>
    <div class="copyright">
        <p>&copy; <?php echo date("Y"); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </div>

</body>
</html>










