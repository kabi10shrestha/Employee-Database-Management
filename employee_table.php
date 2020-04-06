

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Employee Database</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

</head>
<body>


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="employee_table.php">Employee Database</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="employee_table.php">Home</a></li>
      <li class="active"><a href="employee_table.php">Employees</a></li>
      <li><a href="departments_page.php">Departments</a></li>
	  <li><a href="projects.php">Projects</a></li>
      <li><a href="https://docs.google.com/document/d/14_-3tbSXYzc-S6COwxPcD4MRT6ZFI-VjgxliNc0HT8E/edit?usp=sharing">Help</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <h3>Navigation Bar</h3>
  <p>A navigation bar is a navigation header that is placed at the top of the page.</p>
</div>


<div class="container">
  <h2>Employee Database</h2>
  <p>Employees:</p>            
  <table id="example" class="table table-striped table-inverse table-bordered table-hover" cellspacing="0" width="100%">
	<!––table class="table"––>
    <thead>
      <tr>
      <th>Firstn</th>
	  <th>Lastn</th>
	  <th>SSN</th>
	  <th>DOB</th>
	  <th>Address</th>
	  <th>Sex</th>
	  <th>Salary</th>
	  <th>SuperSSN</th>
	  <th>Department</th>
      </tr>
    </thead>
    <tbody>

<?php
require('connect.php');
/*
$servername = "localhost";
$username = "root";
$password = "db4168038";
$dbname = "borg";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
*/

$sql = "SELECT * FROM employee LEFT JOIN department ON department.dnumber = employee.dno";
//WHERE not exists (SELECT * FROM  dependent WHERE ssn=essn) ORDER BY dname ASC, lname ASC;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	while($row = $result->fetch_assoc()){
	 echo "<tr>";
	 echo "<td>".$row["fname"]."</td>";
	 echo "<td>".$row["lname"]."</td>";
	 echo "<td>".$row["ssn"]."</td>";
	 echo "<td>".$row["bdate"]."</td>";
	 echo "<td>".$row["address"]."</td>";
	 echo "<td>".$row["sex"]."</td>";
	 echo "<td>".$row["salary"]."</td>";
	 echo "<td>".$row["superssn"]."</td>";
	 echo "<td>".$row["dname"]."</td>";    
	 echo "</tr>";
	}
} else {
	echo "0 results";
}
$conn->close();
?>

 </tbody>
 </table>
 
 <?php
 if (isset($_POST['first_name'])) {
  print("Employee Added, ");
  //we should call $u = $conn->mysqli::real_escape_string()
  //if we have a database connection
  $fname = $_POST['first_name'];
  $lname = $_POST['last_name'];
  $ssn = $_POST['ssn'];
  $dob = $_POST['dob'];
  $address = $_POST['address'];
  $sex = $_POST['sex'];
  $salary = $_POST['salary'];
  $manager = $_POST['manager'];
  $dept = $_POST['dept_name'];
  print($ssn);
}
else {
	echo "<p>";

  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("First Name: <input type=\"text\" name=\"first_name\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Last Name: <input type=\"text\" name=\"last_name\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("SSN: <input type=\"text\" name=\"ssn\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("DOB: <input type=\"text\" name=\"dob\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Address: <input type=\"text\" name=\"address\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Sex: <input type=\"text\" name=\"sex\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Salary: <input type=\"text\" name=\"salary\" required>");
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Manager: <input type=\"text\" name=\"manager\" required>");
  
  /*<label for="mgr">Managers:</label>

<select id="mgr">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="vw">VW</option>
  <option value="audi" selected>Audi</option>
</select>
*/
  
  echo "<br />";
  
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Department: <input type=\"text\" name=\"dept_name\" required>");
  
  echo "<br />";
  
  print("<input type=\"submit\" value=\"Add Employee\">");
  print("</form>");
  
  echo "<p>";
}
?>

</div>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script> type="text/javascript"
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>




<html>
<?php
		//AUTO_COMMIT = 0;
		//BEGIN;
		//COMMIT;
		//ROLLBACK;

         //var_dump($_POST);
         require('connect.php');
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         $stmt = $conn->prepare("insert into employee(fname, lname, ssn, dob, address, sex, salary, manager,dept) values(?,?,?,?,?,?,?,?,?)");
		 $fname = $_POST['first_name'];
		 $lname = $_POST['last_name'];
		 $ssn = $_POST['ssn'];
		 $dob = $_POST['dob'];
		 $address = $_POST['address'];
		 $sex = $_POST['sex'];
		 $salary = $_POST['salary'];
		 $manager = $_POST['manager'];
	     $dept = $_POST['dept_name'];        
         $stmt->bind_param("ssisssiii", $fname, $lname, $ssn, $dob, $address, $sex, $salacy, $manager, $dept);
         if ($stmt->execute()) {
              echo "ok <a href='employee_table.php'>Back</a>";
         } else 
         {
              echo "Fail";
              echo $stmt->error;
         }
         mysqli_close($conn);
?>

</html>








</html>








