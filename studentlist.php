<?php
// Database connection
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "sample";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// =================== UPDATE STUDENT DETAILS IF FORM IS SUBMITTED ===================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id'])) {
    // Retrieve updated data from editstudent.php form
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $class = $_POST['class'];

    // Update query
    $query = "UPDATE `students` SET 
                `first_name`='$first_name',
                `last_name`='$last_name',
                `gender`='$gender',
                `address`='$address',
                `class`='$class' 
              WHERE `student_id`='$student_id'";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Student updated successfully!');</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// =================== DISPLAY STUDENT LIST ===================
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data as styled table
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
            background-color: #1E90FF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .action-column {
            width: 100px;
        }
    </style>";

    echo "<h2>Student List</h2>";
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
        echo "<td>" . $row["student_id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["class"] . "</td>";
        echo "<td class='action-column'>
                <a href='editstudent.php?id=" . $row["student_id"] . "'>Edit</a> | 
                <a href='removestudent.php?id=" . $row["student_id"] . "'>Remove</a>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No students found";
}

// Close connection
$conn->close();
?>
