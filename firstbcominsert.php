<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sample";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare SQL statement
        $sql = "INSERT INTO fbcomsubjects (subject_code, subject_name, faculty_name) 
                VALUES (:subject_code, :subject_name, :faculty_name)";
        $stmt = $conn->prepare($sql);

        // Bind parameters from form inputs
        $stmt->bindParam(':subject_code', $_POST['subject_code']);
        $stmt->bindParam(':subject_name', $_POST['subject_name']);
        $stmt->bindParam(':faculty_name', $_POST['faculty_name']);

        // Execute the statement
        $stmt->execute();

        echo "Subject details inserted successfully.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
