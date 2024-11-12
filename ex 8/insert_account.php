<?php 
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        form {
            width: 300px;
            margin: auto;
        }
        label, input, select {
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

<h2>Insert New Account</h2>

<form method="post">
    <label for="atype">Account Type:</label>
    <select name="atype" id="atype" required>
        <option value="S">Savings</option>
        <option value="C">Current</option>
    </select>

    <label for="balance">Initial Balance:</label>
    <input type="number" id="balance" name="balance" step="0.01" min="0" required>

    <label for="cid">Customer ID:</label>
    <input type="number" id="cid" name="cid" required>

    <input type="submit" value="Create Account">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $atype = $_POST["atype"];
    $balance = $_POST["balance"];
    $cid = $_POST["cid"];

    // Validate that the Customer ID exists
    $sql_check_cid = "SELECT * FROM CUSTOMER WHERE CID = $cid";
    $result = $conn->query($sql_check_cid);

    if ($result->num_rows > 0) {
        // Insert the new account
        $sql = "INSERT INTO ACCOUNT (ATYPE, BALANCE, CID) VALUES ('$atype', '$balance', '$cid')";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='message'>New account created successfully</p>";
        } else {
            echo "<p class='message'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    } else {
        echo "<p class='message'>Customer ID not found. Please enter a valid Customer ID.</p>";
    }
}
?>

<a href="index.php" class="back-button">Back to Main Page</a>

</body>
</html>
