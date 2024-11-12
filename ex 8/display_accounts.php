<?php 
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 25px auto;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
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
            text-align: center;
        }
        .back-button:hover {
            background-color: #45a049;
        }
        .button-container {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Account Information</h2>

<table>
    <tr>
        <th>Account Number (ANO)</th>
        <th>Account Type (ATYPE)</th>
        <th>Balance</th>
        <th>Customer ID (CID)</th>
    </tr>

    <?php
    $sql = "SELECT * FROM ACCOUNT";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ANO"] . "</td>";
            echo "<td>" . ($row["ATYPE"] == 'S' ? 'Savings' : 'Current') . "</td>";
            echo "<td>" . $row["BALANCE"] . "</td>";
            echo "<td>" . $row["CID"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No accounts found</td></tr>";
    }
    ?>
</table>

<div class="button-container">
    <a href="index.php" class="back-button">Back to Main Page</a>
</div>

</body>
</html>
