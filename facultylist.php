<?php
echo "<style>
    .faculty-details {
        color: darkblue;
        margin-bottom: 10px;
    }
    .faculty-details hr {
        border-color: darkblue;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #1E90FF; /* Dark blue background for headers */
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2; /* Light gray background for even rows */
    }
    .action-column {
        width: 100px; /* Adjust the width as needed */
    }
</style>";

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// fetch from facreg table
$sql = "SELECT * FROM facreg";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Class</th><th class='action-column'>Actions</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["fname"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        // echo "<td>" . $row["class"] . "</td>";
        echo "<td class='action-column'><a href='editfaculty.php?id=" . $row["id"] . "'>Edit</a> | <a href='removefaculty.php?id=" . $row["id"] . "'>Remove</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$con->close();
?>
