# Employee-Database-Management
COSC 4120 - Database Application Project

This is an Employee Management Database with example data imported.
Use the the install.sql file to import and setup the MySQL database.

mysql -u username -p dbname < install.sql

To connect server to database you will need to create a connect.php file containing the following:

/*
<?php
$conn = new mysqli("servername", "username", "password", "dbname");
       if ($conn->connect_error) {
           echo "Connection failed<br/>";
           die("Connection failed: " . $conn->connect_error);
       }
?>
*/

The database contains tables for department, dependent, dept_locations, employee, project and works_on.
The index.php file is used to link the database to a web server and allow user interaction with the database.

Employee Databse Management has tabs for employee, department, and projects.
It allows users to add new employees to the database as well as manage employee information.
Users can input employee details in the form as well as department options to manage employees with the “Add Employee” button.
Click the “departments” tab on the navigation bar to view company departments to add new departments or update existing department information.
Click on an employee to see the company project assignment.

For more information click the 'Help' tab to view user documentation.
