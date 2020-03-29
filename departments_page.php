

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Departments</title>
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
      <li><a href="employee_table.php">Employees</a></li>
      <li class="active"><a href="departments_page.php">Departments</a></li>
	  <li><a href="projects.php">Projects</a></li>
      <li><a href="https://docs.google.com/document/d/14_-3tbSXYzc-S6COwxPcD4MRT6ZFI-VjgxliNc0HT8E/edit?usp=sharing">Help</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <h2>Departments</h2>
  <p></p>    
	<table id="example" class="table table-striped table-inverse table-bordered table-hover" cellspacing="0" width="100%">
	<!––table class="table"––>  
    <thead>
	<th>Department Name</th>
	 <th>Number</th>
	 <th>Manager</th>
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

$sql = "SELECT * from department LEFT JOIN employee ON employee.ssn = department.mgrssn";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	while($row = $result->fetch_assoc()){
	 echo "<tr>";
	 echo "<td>".$row["dname"]."</td>";  
	 echo "<td>".$row["dnumber"]."</td>"; 
	  echo "<td>".$row["fname"]."</td>"; 
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

if (isset($_POST['dept_name'])) {
  print("Department Added, ");
  //we should call $u = $conn->mysqli::real_escape_string()
  //if we have a database connection
  $u = $_POST['dept_name'];
  print($u);
}
else {
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  print("Add a new department: <input type=\"text\" name=\"dept_name\" required>");
  print("<input type=\"submit\" value=\"Submit\">");
  print("</form>");
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
<!--<?php
         //var_dump($_POST);
         require('connect.php');
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         $stmt = $conn->prepare("insert into department(dname, dnumber, mgrssn, mgrstartdate) values(?,?,?,'2020-01-01')");
         $dname = $_POST['dname'];
         $dnum = $_POST['dno'];
         $mgrssn = $_POST['mgrssn'];
         $stmt->bind_param("sii", $dname, $dnum, $mgrssn);
         if ($stmt->execute()) {
              echo "ok <a href='index.php'>Back</a>";
         } else 
         {
              echo "Fail";
              echo $stmt->error;
         }
         mysqli_close($conn);
?>
-->
</html>


</html>






