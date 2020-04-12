

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
    <div class="navbar-header active">
      <a class="navbar-brand" href="index.php">Employee Database</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php?page=employee">Employees</a></li>
      <li><a href="index.php?page=department">Departments</a></li>
	  <li><a href="index.php?page=projects">Projects</a></li>
      <li><a href="https://docs.google.com/document/d/14_-3tbSXYzc-S6COwxPcD4MRT6ZFI-VjgxliNc0HT8E/edit?usp=sharing">Help</a></li>
    </ul>
  </div>
</nav>

<?php


function employee_page() {
	require('connect.php');
	$result = $conn->query("SELECT * FROM employee LEFT JOIN department ON department.dnumber = employee.dno");
	//WHERE not exists (SELECT * FROM  dependent WHERE ssn=essn) ORDER BY dname ASC, lname ASC;";
	echo "<div class='container'><h2>Employee Database</h2><table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";
    echo "<tr><th>First</th><th>Last</th><th>SSN</th><th>DOB</th><th>Address</th><th>Sex</th><th>Salary</th><th>SuperSSN</th><th>Department</th></tr>";
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
	 echo '</table></div>';
	 
	 



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
  print($lname.", ".$fname.", ".$ssn);
}
else {
	echo "<p>";

  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  echo "<input type='hidden' name='page' value='addemployee'/>";
  print("First Name: <input type=\"text\" name=\"first_name\" required>");
  echo "<br />";
  print("Last Name: <input type=\"text\" name=\"last_name\" required>");
  echo "<br />";
  print("SSN: <input type=\"number\" name=\"ssn\" required>");
  echo "<br />";
  print("DOB: <input type=\"text\" name=\"dob\" required>");
  echo "<br />";
  print("Address: <input type=\"text\" name=\"address\" required>");
  echo "<br />";
  print("Sex: <input type=\"text\" name=\"sex\" required>");
  echo "<br />";
  print("Salary: <input type=\"number\" name=\"salary\" required>");
  echo "<br />";
  print("Manager: <input type=\"number\" name=\"manager\" required>");
  /*<label for="mgr">Managers:</label>
<select id="mgr">
  <option value="volvo">Volvo</option>
  <option value="saab">Saab</option>
  <option value="vw">VW</option>
  <option value="audi" selected>Audi</option>
</select>
*/
  echo "<br />"; 
  print("Department: <input type=\"number\" name=\"dept_name\" required>");
  echo "<br />";
  print("<input type=\"submit\" value=\"Add Employee\">");
  print("</form>");
  echo "<p>";
}
$conn->close();
}




function add_employee() {
		//AUTO_COMMIT = 0;
		//BEGIN;
		//COMMIT;
		//ROLLBACK;

         //var_dump($_POST);
         require('connect.php');
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         $stmt = $conn->prepare("insert into employee(fname, lname, ssn, bdate, address, sex, salary, superssn, dno) values(?,?,?,?,?,?,?,?,?)");
		 $fname = $_POST['first_name'];
		 $lname = $_POST['last_name'];
		 $ssn = $_POST['ssn'];
		 $dob = $_POST['dob'];
		 $address = $_POST['address'];
		 $sex = $_POST['sex'];
		 $salary = $_POST['salary'];
		 $manager = $_POST['manager'];
	     $dept = $_POST['dept_name'];        
         $stmt->bind_param("ssiissiii", $fname, $lname, $ssn, $dob, $address, $sex, $salary, $manager, $dept);
         if ($stmt->execute()) {
              echo "ok <a href='employee_table.php'>Back</a>";
         } else 
         {
              echo "Fail";
              echo $stmt->error;
         }
         mysqli_close($conn);
		 employee_page();

}


function department_page() {
	echo "<div class='container'><h2>Departments</h2><table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";
	echo "<th>Department Name</th><th>Number</th><th>Manager</th>";
    echo "<tbody>";
	
	require('connect.php');

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


    echo '</tbody></table></div>';

if (isset($_POST['dept_name'])) {
  print("Department Added, ");
  //we should call $u = $conn->mysqli::real_escape_string()
  //if we have a database connection
  $u = $_POST['dept_name'];
  print($u);
}
else {
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  echo "<input type='hidden' name='page' value='adddepartment'/>";
  print("Add a new department: <input type=\"text\" name=\"dept_name\" required>");
  echo "<br />";
  print("Department Number: <input type=\"text\" name=\"dept_num\" required>");
  echo "<br />";
  print("Manager SSN: <input type=\"text\" name=\"dept_mgr\" required>");
  echo "<br />";
  print("<input type=\"submit\" value=\"Submit\">");
  print("</form>");
}
}

function add_department() {

  //var_dump($_POST);
         require('connect.php');
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         $stmt = $conn->prepare("insert into department(dname, dnumber, mgrssn, mgrstartdate) values(?,?,?,'2020-01-01')");
         $dname = $_POST['dept_name'];
         $dnum = $_POST['dept_num'];
         $mgrssn = $_POST['dept_mgr'];
         $stmt->bind_param("sii", $dname, $dnum, $mgrssn);
         if ($stmt->execute()) {
              echo "ok <a href='index.php'>Back</a>";
         } else 
         {
              echo "Fail";
              echo $stmt->error;
         }
         mysqli_close($conn);
		 department_page;
}


function projects_page() {
	
	
	echo "<div class='container'><h2>Employee Database</h2><table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";
	echo "<tr><th>Firstn</th><th>Lastn</th><th>Product Name</th></tr><tbody>";


require('connect.php');

$sql = "SELECT * FROM works_on LEFT JOIN employee ON employee.ssn = works_on.essn LEFT JOIN project ON project.pnumber = works_on.pno";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
	while($row = $result->fetch_assoc()){
	 echo "<tr>";
	 echo "<td>".$row["fname"]."</td>";
	 echo "<td>".$row["lname"]."</td>";
	 echo "<td>".$row["pname"]."</td>";
    
	 echo "</tr>";
	}
} else {
	echo "0 results";
}
$conn->close();

echo "</tbody></table></div>";
//$_GET["name"] index?page=ssn

}

?>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script> type="text/javascript"
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>



<?php
$page = "";
if (isset($_GET['page'])) { $page = $_GET['page']; }
if (isset($_POST['page'])) { $page = $_POST['page']; }

if ($page == "") { employee_page(); }
if ($page == "employee") { employee_page(); }
if ($page == "department") { department_page(); }
if ($page == "projects") { projects_page(); }
if ($page == "addemployee") { add_employee(); }
if ($page == "adddepartment") { add_department(); }


?>


</html>








