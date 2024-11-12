<!DOCTYPE html>
<html>
<head>
    <title>Employee Management</title>
</head>
<body>

<h2>Employee Management System</h2>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Enter your MySQL password if any
$dbname = "EmployeeDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert new employee record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $ename = $_POST['ename'];
    $desig = $_POST['desig'];
    $dept = $_POST['dept'];
    $doj = $_POST['doj'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO EMPDETAILS (ENAME, DESIG, DEPT, DOJ, SALARY)
            VALUES ('$ename', '$desig', '$dept', '$doj', '$salary')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>New employee added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Update employee record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $empid = $_POST['empid'];
    $ename = $_POST['ename'];
    $desig = $_POST['desig'];
    $dept = $_POST['dept'];
    $doj = $_POST['doj'];
    $salary = $_POST['salary'];

    $sql = "UPDATE EMPDETAILS SET 
            ENAME = IF('$ename' = '', ENAME, '$ename'), 
            DESIG = IF('$desig' = '', DESIG, '$desig'), 
            DEPT = IF('$dept' = '', DEPT, '$dept'),
            DOJ = IF('$doj' = '', DOJ, '$doj'),
            SALARY = IF('$salary' = '', SALARY, '$salary')
            WHERE EMPID = '$empid'";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Employee details updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Fetch and display employee records
$sql = "SELECT EMPID, ENAME, DESIG, DEPT, DOJ, SALARY FROM EMPDETAILS";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h3>Employee List</h3>";
    echo "<table border='1'>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Department</th>
                <th>Date of Joining</th>
                <th>Salary</th>
            </tr>";
    
    // Fetch and display each row of data
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["EMPID"] . "</td>
                <td>" . $row["ENAME"] . "</td>
                <td>" . $row["DESIG"] . "</td>
                <td>" . $row["DEPT"] . "</td>
                <td>" . $row["DOJ"] . "</td>
                <td>" . $row["SALARY"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No employee records found.</p>";
}
?>

<h3>Add New Employee</h3>
<form method="post" action="">
    Name: <input type="text" name="ename" required><br><br>
    Designation: <input type="text" name="desig" required><br><br>
    Department: <input type="text" name="dept" required><br><br>
    Date of Joining: <input type="date" name="doj" required><br><br>
    Salary: <input type="text" name="salary" required><br><br>
    <input type="submit" name="add" value="Add Employee">
</form>

<h3>Update Employee</h3>
<form method="post" action="">
    Employee ID (to update): <input type="text" name="empid" required><br><br>
    Name: <input type="text" name="ename"><br><br>
    Designation: <input type="text" name="desig"><br><br>
    Department: <input type="text" name="dept"><br><br>
    Date of Joining: <input type="date" name="doj"><br><br>
    Salary: <input type="text" name="salary"><br><br>
    <input type="submit" name="update" value="Update Employee">
</form>

</body>
</html>

<?php
$conn->close();
?>
