-- Create the payroll_system database if it does not exist
CREATE DATABASE IF NOT EXISTS payroll_system;

-- Use the payroll_system database
USE payroll_system;

-- Drop existing tables if needed
DROP TABLE IF EXISTS Payroll;
DROP TABLE IF EXISTS Employees;

-- Create the Employees table
CREATE TABLE IF NOT EXISTS Employees (
    EmployeeID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Age INT NOT NULL,
    DOB DATE NOT NULL,
    JoinDate DATE NOT NULL,
    Department VARCHAR(255) NOT NULL,
    LoanBalance DECIMAL(10, 2) DEFAULT 0,
    BasicSalary DECIMAL(10, 2) NOT NULL  -- Added BasicSalary column
);

-- Create the Payroll table
CREATE TABLE IF NOT EXISTS Payroll (
    PayrollID INT AUTO_INCREMENT PRIMARY KEY,
    EmployeeID INT NOT NULL,
    Month INT NOT NULL,
    Year INT NOT NULL,
    BasicSalary DECIMAL(10, 2) NOT NULL,
    PresentDays INT NOT NULL,
    OvertimeDays INT NOT NULL,
    Other DECIMAL(10, 2) NOT NULL,
    Bonus DECIMAL(10, 2) NOT NULL,
    PF DECIMAL(10, 2) NOT NULL,
    ESIC DECIMAL(10, 2) NOT NULL,
    LoanDeducted DECIMAL(10, 2) NOT NULL,
    LWF DECIMAL(10, 2) NOT NULL,
    ProfessionTax DECIMAL(10, 2) NOT NULL,
    InhandSalary DECIMAL(10, 2) NOT NULL,
    OvertimePay DECIMAL(10, 2) NOT NULL,
    TotalPay DECIMAL(10, 2) NOT NULL,
    NetPay DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID) ON DELETE CASCADE
);








