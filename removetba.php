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

    // Check if subject ID is provided via GET request
    if (isset($_GET['id'])) {
        // Get the subject ID from the URL parameter
        $subject_id = $_GET['id'];

        // Prepare SQL statement to delete subject by ID
        $sql = "DELETE FROM tbasubjects WHERE id = :subject_id";
        $stmt = $conn->prepare($sql);

        // Bind the subject ID parameter
        $stmt->bindParam(':subject_id', $subject_id);

        // Execute the statement
        $stmt->execute();

        echo "Subject details deleted successfully.";
    } else {
        echo "Subject ID not provided.";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
