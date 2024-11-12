<?php 
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Information</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {background-color: #f5f5f5;}
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

<h2>Customer Information</h2>

<table>
    <tr>
        <th>CID</th>
        <th>Name</th>
    </tr>

    <?php
    $sql = "SELECT * FROM CUSTOMER";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["CID"] . "</td>";
            echo "<td>" . $row["CNAME"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No customers found</td></tr>";
    }
    ?>
    
</table>

<a href="index.php" class="back-button">Back to Main Page</a>

</body>
</html>
