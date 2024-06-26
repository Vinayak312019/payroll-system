<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subhlakshmi MIDC Payroll System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative; /* To position the logo */
            text-align: center; /* Center align content */
        }
        img.logo {
            width: 200px; /* Adjust width as needed */
            height: auto;
            margin-bottom: 20px; /* Add space between logo and links */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* Soft shadow */
        }
        h1 {
            font-family: 'Roboto', sans-serif; /* Apply Roboto font */
            font-size: 2.5rem; /* Larger font size */
            color: #333; /* Darker text color */
            margin-bottom: 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }
        li {
            margin-bottom: 15px; /* Increased spacing between links */
        }
        li a {
            display: block;
            padding: 15px;
            text-decoration: none;
            color: #333;
            background-color: #f2f2f2;
            border-radius: 8px; /* Rounded buttons */
            transition: background-color 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Light shadow */
        }
        li a:hover {
            background-color: #e0e0e0;
        }
        .copyright {
            margin-top: 40px; /* Increased margin */
            font-size: 14px; /* Increased font size */
            color: #888;
            text-align: center; /* Center align text */
        }
    </style>
    <!-- Include Google Fonts link for Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <img src="download.png" alt="Subhlakshmi MIDC Payroll System" class="logo">
        <h1>Shree Subhlaxmi Dyeing pvt.Ltd</h1>
        <ul>
            <li><a href="add_employee.php">Add Employee</a></li>
            <li><a href="list_employees.php">Edit/Delete Employee</a></li>
            <li><a href="process_payroll.php">Process Payroll</a></li>
            <li><a href="generate_report.php">Generate Report</a></li>
        </ul>
    </div>

    <div class="copyright">
        <p>&copy; <?php echo date("Y"); ?> Vinayak Dhananjay Sharma. All rights reserved.</p>
    </div>
</body>
</html>













