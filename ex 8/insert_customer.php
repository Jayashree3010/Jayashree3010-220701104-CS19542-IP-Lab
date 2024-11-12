<?php 
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        form {
            width: 300px;
            margin: auto;
        }
        label, input {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            font-weight: bold;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>Insert New Customer</h2>

<form method="post">
    <label for="cname">Customer Name:</label>
    <input type="text" id="cname" name="cname" required>

    <input type="submit" value="Create Customer">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cname = $_POST["cname"];

    // Insert the new customer
    $sql = "INSERT INTO CUSTOMER (CNAME) VALUES ('$cname')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='message'>New customer created successfully</p>";
    } else {
        echo "<p class='message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}
?>

<a href="index.php" class="back-button">Back to Main Page</a>

</body>
</html>
