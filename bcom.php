<?php
// Database connection
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$dbname = "sample";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the classes you want to filter (First BCA, Second BCA, Third BCA)
$classesToDisplay = "'First Bcom', 'Second Bcom', 'Third Bcom'";

// SQL query to fetch student details for specific classes
$sql = "SELECT * FROM students WHERE class IN ($classesToDisplay)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in a styled table format
    echo "<h1>BACHELOR OF COMMERCE</h1>";
    echo "<style>
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
    echo "<table>
    <tr>
    <th>Student ID</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Gender</th>
    <th>Address</th>
    <th>Class</th>
    <th class='action-column'>Actions</th>
    </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["student_id"]. "</td>";
        echo "<td>" . $row["first_name"]. "</td>";
        echo "<td>" . $row["last_name"]. "</td>";
        echo "<td>" . $row["gender"]. "</td>";
        echo "<td>" . $row["address"]. "</td>";
        echo "<td>" . $row["class"]. "</td>";
        echo "<td class='action-column'><a href='editstudent.php?id=" . $row["student_id"] . "'>Edit</a> | <a href='removestudent.php?id=" . $row["student_id"] . "'>Remove</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No students found for the selected classes";
}

$conn->close();



