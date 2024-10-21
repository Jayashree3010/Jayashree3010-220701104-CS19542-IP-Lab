<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'emp_management');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding an employee
if (isset($_POST['add_employee'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept = $_POST['dept'];
    $working_hours = $_POST['working_hours'];
    $hourly_wage = $_POST['hourly_wage'];
    $salary = $working_hours * $hourly_wage; // Salary calculation

    $stmt = $conn->prepare("INSERT INTO employees (Name, email, dept, working_hours, hourly_wage, salary) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddi", $name, $email, $dept, $working_hours, $hourly_wage, $salary);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting an employee
if (isset($_POST['delete_employee'])) {
    $employee_id = $_POST['employee_id'];

    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $stmt->close();
}

// Handle editing an employee
if (isset($_POST['edit_employee'])) {
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dept = $_POST['dept'];
    $working_hours = $_POST['working_hours'];
    $hourly_wage = $_POST['hourly_wage'];
    $salary = $working_hours * $hourly_wage; // Salary calculation

    $stmt = $conn->prepare("UPDATE employees SET Name = ?, email = ?, dept = ?, working_hours = ?, hourly_wage = ?, salary = ? WHERE id = ?");
    $stmt->bind_param("sssddii", $name, $email, $dept, $working_hours, $hourly_wage, $salary, $employee_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch all employees to display
$employees = [];
$result = $conn->query("SELECT * FROM employees");
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Add Employee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Employee List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Employee Management System</h1>

        <!-- Add Employee Form -->
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                <h3>Add New Employee</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Employee Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Employee Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="dept" class="form-label">Department</label>
                        <input type="text" class="form-control" id="dept" name="dept" placeholder="Enter Department" required>
                    </div>
                    <div class="mb-3">
                        <label for="working_hours" class="form-label">Working Hours</label>
                        <input type="number" class="form-control" id="working_hours" name="working_hours" placeholder="Enter Working Hours" required>
                    </div>
                    <div class="mb-3">
                        <label for="hourly_wage" class="form-label">Hourly Wage</label>
                        <input type="number" class="form-control" id="hourly_wage" name="hourly_wage" placeholder="Enter Hourly Wage" required>
                    </div>
                    <button type="submit" name="add_employee" class="btn btn-success">Add Employee</button>
                </form>
            </div>
        </div>

        <!-- Employee List -->
        <div class="card mt-5">
            <div class="card-header bg-secondary text-white">
                <h3>Employee List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Department</th>
        <th>Working Hours</th>
        <th>Hourly Wage</th>
        <th>Salary</th>
        <th>Actions</th>
    </tr>
</thead>

                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                        <tr data-id="<?php echo $employee['id']; ?>">
                            <td><?php echo $employee['id']; ?></td>
                            <td class="name"><?php echo $employee['Name']; ?></td>
                            <td class="email"><?php echo $employee['email']; ?></td>
                            <td class="dept"><?php echo $employee['dept']; ?></td>
                            <td class="working_hours"><?php echo $employee['working_hours']; ?></td>
                            <td class="hourly_wage"><?php echo $employee['hourly_wage']; ?></td>
                            <td><?php echo $employee['salary']; ?></td>
                            <td>
                                <form action="" method="post" style="display:inline;">
                                    <input type="hidden" name="employee_id" value="<?php echo $employee['id']; ?>">
                                    <button type="submit" name="delete_employee" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?');">Delete</button>
                                </form>
                                <button class="btn btn-warning" onclick="openEditModal(<?php echo $employee['id']; ?>)">Edit</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal -->
    <div id="editEmployeeModal" style="display:none; position:fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
        <form action="" method="post" id="editEmployeeForm">
            <h3>Edit Employee</h3>
            <input type="hidden" name="employee_id" id="editEmployeeId">
            <input type="text" name="name" required placeholder="Name" id="editName">
            <input type="email" name="email" required placeholder="Email" id="editEmail">
            <input type="text" name="dept" required placeholder="Department" id="editDept">
            <input type="number" name="working_hours" required placeholder="Working Hours" id="editWorkingHours">
            <input type="number" name="hourly_wage" required placeholder="Hourly Wage" id="editHourlyWage">
            <button type="submit" name="edit_employee">Save Changes</button>
            <button type="button" onclick="closeModal('editEmployeeModal')">Cancel</button>
        </form>
    </div>

    <script>
    // Open edit modal with employee data
    function openEditModal(id) {
        const row = document.querySelector('tr[data-id="' + id + '"]');
        document.getElementById('editEmployeeId').value = id;
        document.getElementById('editName').value = row.querySelector('.name').innerText;
        document.getElementById('editEmail').value = row.querySelector('.email').innerText;
        document.getElementById('editDept').value = row.querySelector('.dept').innerText;
        document.getElementById('editWorkingHours').value = row.querySelector('.working_hours').innerText;
        document.getElementById('editHourlyWage').value = row.querySelector('.hourly_wage').innerText;
        document.getElementById('editEmployeeModal').style.display = 'block';
    }

    // Close modal
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
