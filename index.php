

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script> type="text/javascript"
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>


 
</head>
<body>


<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header active">
      <a class="navbar-brand" href="index.php">Employee Database</a>
    </div>
    <ul class="nav navbar-nav">
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
	echo "<div class='container'><h2>Employee Database</h2><table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%' >";
    echo "<thead><tr><th>First</th><th>Last</th><th>SSN</th><th>DOB</th><th>Address</th><th>Sex</th><th>Salary</th><th>SuperSSN</th><th>Department</th></tr></thead><tbody>";
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
	 echo '</tbody></table>';
	 
	 
$manager_result = $conn->query("SELECT DISTINCT mgrssn, fname, lname FROM employee, department where mgrssn = ssn");
$department_result = $conn->query("SELECT dnumber, dname FROM department");


 if (isset($_POST['submit'])) {
  print("Employee Added, ");
  //we should call $u = $conn->mysqli::real_escape_string()
  //if we have a database connection
  $fname = $_POST['first_name'];
  $lname = $_POST['last_name'];
  $ssn = $_POST['ssn'];
  /*
  $dob = $_POST['dob'];
  $address = $_POST['address'];
  $sex = $_POST['sex'];
  $salary = $_POST['salary'];
  $manager = $_POST['mgr'];
  $dept = $_POST['dept'];
  */
  print($fname." ".$lname.", ".$ssn);
}
else {
	echo "<p><table>";
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  echo "<input type='hidden' name='page' value='addemployee'/>";
  print("<tr><th>First Name: </th><th><input type=\"text\" name=\"first_name\" maxlength=\"10\" required></th></tr>");
  print("<tr><th>Last Name: </th><th><input type=\"text\" name=\"last_name\" maxlength=\"20\" required></th></tr>");
  print("<tr><th>SSN: </th><th><input type=\"number\" name=\"ssn\" max=\"999999999\" required></th></tr>");
  print("<tr><th>DOB: </th><th><input type=\"date\" name=\"dob\" required></th></tr>");
  print("<tr><th>Address: </th><th><input type=\"text\" name=\"address\" maxlength=\"30\" required></th></tr>");
  print("<tr><th>Sex: </th><th><input type=\"text\" name=\"sex\" maxlength=\"1\" required></th></tr>");
  print("<tr><th>Salary: </th><th><input type=\"number\" name=\"salary\" max=\"99999\" required></th></tr>");
  
  print("<tr><th><label for=\"mgr\">Manager:</label></th><th><select id=\"mgr\" name=\"mgr\">");
  echo "<option disabled selected value> -- select a manager -- </option>";
  while($row = $manager_result->fetch_assoc()){
  echo "<option value=".$row["mgrssn"].">".$row["fname"]." ".$row["lname"]."</option>";
  }
  echo "</select></th></tr>";
  
  print("<tr><th><label for=\"dept\">Department:</label></th><th><select id=\"dept\" name=\"dept\" required>");
  echo "<option disabled selected value> -- select a department -- </option>";
  while($row = $department_result->fetch_assoc()){
  echo "<option value=".$row["dnumber"].">".$row["dname"]."</option>";
  }
  echo "</select></th></tr>";
  
  echo "<br /></table>";
  print("<input type=\"submit\" name=\"submit\" value=\"Add Employee\">");
  print("</form>");
  echo "</p></div>";
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
		 $manager = $_POST['mgr'];
	     $dept = $_POST['dept'];        
         $stmt->bind_param("ssisssiii", $fname, $lname, $ssn, $dob, $address, $sex, $salary, $manager, $dept);
         if ($stmt->execute()) {
              echo "ok <a href='index.php?page=employee'>Back</a>";
         } else 
         {
              echo "Fail";
              echo $stmt->error;
         }
         mysqli_close($conn);
		 employee_page();

}


function department_page() {
	require('connect.php');
$sql = "SELECT * from department LEFT JOIN employee ON employee.ssn = department.mgrssn";
$result = $conn->query($sql);
	
	echo "<div class='container'><h2>Departments</h2><table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%' >";
	echo "<thead><tr><th>Department Name</th><th>Number</th><th>Manager</th></tr></thead><tbody>";
	while($row = $result->fetch_assoc()){
	 echo "<tr>";
	 echo "<td>".$row["dname"]."</td>";  
	 echo "<td>".$row["dnumber"]."</td>"; 
	  echo "<td>".$row["fname"]."</td>"; 
	 echo "</tr>";
	}
	echo '</tbody></table>';


    $dept_manager_result = $conn->query("SELECT ssn, fname, lname FROM employee");

if (isset($_POST['submit2'])) {
  print("Department Added, ");
  //we should call $u = $conn->mysqli::real_escape_string()
  //if we have a database connection
  $u = $_POST['dept_name'];
  print($u);
}
else {
	echo "<p><table>";
  print("<form method=\"post\" action=\"$_SERVER[PHP_SELF]\">");
  echo "<input type='hidden' name='page' value='adddepartment'/>";
  print("<tr><th>Department Name: </th><th><input type=\"text\" name=\"dept_name\" maxlength=\"20\" required></th></tr>");
  print("<tr><th>Department Number: </th><th><input type=\"number\" name=\"dept_num\" max=\"9\" required></th></tr>");
  
   print("<tr><th><label for=\"dept_mgr\">Manager:</label></th><th><select id=\"dept_mgr\" name=\"dept_mgr\" required>");
  echo "<option disabled selected value> -- select a manager -- </option>";
  while($row = $dept_manager_result->fetch_assoc()){
  echo "<option value=".$row["ssn"].">".$row["fname"]." ".$row["lname"]."</option>";
  }
  echo "</select></th></tr>";
  
  
  
  echo "<br /></table>";
  print("<input type=\"submit\" name=\"submit2\" value=\"Add Department\">");
  print("</form>");
   echo "</p></div>";
}
$conn->close();
}

function add_department() {

$today = date("Y-m-d");


  //var_dump($_POST);
         require('connect.php');
         if(! $conn ) {
            die('Could not connect: ' . mysqli_error());
         }
         $stmt = $conn->prepare("insert into department(dname, dnumber, mgrssn, mgrstartdate) values(?,?,?, '".$today."')");
         $dname = $_POST['dept_name'];
         $dnum = $_POST['dept_num'];
         $mgrssn = $_POST['dept_mgr'];
         $stmt->bind_param("sii", $dname, $dnum, $mgrssn);
         if ($stmt->execute()) {
              echo "ok <a href='index.php?page=department'>Back</a>";
         } else 
         {
              echo "Fail";
              echo $stmt->error;
         }
         mysqli_close($conn);
		 department_page();
}


function projects_page() {
	
	
	echo "<div class='container'><h2>Projects</h2><table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";
	echo "<thead><tr><th>First</th><th>Last</th><th>Product Name</th></tr></thead><tbody>";


require('connect.php');

$sql = "SELECT * FROM works_on LEFT JOIN employee ON employee.ssn = works_on.essn LEFT JOIN project ON project.pnumber = works_on.pno";
$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
	 echo "<tr>";
	 echo "<td>".$row["fname"]."</td>";
	 echo "<td>".$row["lname"]."</td>";
	 echo "<td>".$row["pname"]."</td>";
    
	 echo "</tr>";

}

echo "</tbody></table></div>";

$conn->close();


//$_GET["name"] index?page=ssn

}

?>
</body>





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








