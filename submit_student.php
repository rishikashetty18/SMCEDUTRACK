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

// Form data processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $class = $_POST['class'];
    $pwd = $_POST['pwd'];

    // *** New code added for checking duplicate student_id ***
    // Check if student_id already exists
    $check_sql = "SELECT * FROM students WHERE student_id='$student_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Error: Student ID '$student_id' is already taken. Please use a different ID.";
    } else {
        // SQL query to insert data into the table
        $sql = "INSERT INTO students(student_id, first_name, last_name, gender, address, class, password)
                VALUES ('$student_id', '$first_name', '$last_name', '$gender', '$address', '$class','$pwd')";

        if ($conn->query($sql) === TRUE) {
            // Write data to files based on class
            if ($class == 'First BCA' || $class == 'Second BCA' || $class == 'Third BCA') {
                $file = fopen("bca.php", "a"); // Open or create 'bca.php' for appending
                fwrite($file, "<p>$first_name $last_name - BCA</p>\n"); // Write student information to the file
                fclose($file); // Close the file
            } elseif ($class == 'First BCOM' || $class == 'Second BCOM' || $class == 'Third BCOM') {
                $file = fopen("bcom.php", "a"); // Open or create 'bcom.php' for appending
                fwrite($file, "<p>$first_name $last_name - BCOM</p>\n"); // Write student information to the file
                fclose($file); // Close the file
            } elseif ($class == 'First BA' || $class == 'Second BA' || $class == 'Third BA') {
                $file = fopen("ba.php", "a"); // Open or create 'bcom.php' for appending
                fwrite($file, "<p>$first_name $last_name - BA</p>\n"); // Write student information to the file
                fclose($file); // Close the file
            }
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
