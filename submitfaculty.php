<?php
// Database connection
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$dbname = "sample"; // Replace "sample" with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $pwd = $_POST['password'];
    $class = $_POST['class'];
    

    // SQL query to insert data into the table
    $sql = "INSERT INTO `facreg`( `username`, `password`, `class`)
     VALUES ('$name','$pwd','$class')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Faculty details added');
        window.location.href='addfaculty.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
