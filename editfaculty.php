<?php
echo "<style>
    body {
        background-color: #f0f0f0; /* Light gray background for the page */
    }
    .form-container {
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .form-container h2 {
        color: #1E90FF; /* Dark blue color for headings */
        margin-bottom: 20px;
    }
    .form-container input[type='text'], .form-container input[type='submit'], .form-container select {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 3px;
        box-sizing: border-box;
    }
    .form-container input[type='submit'] {
        background-color: #1E90FF; /* Dark blue background for submit button */
        color: #fff;
        cursor: pointer;
    }
    .form-container input[type='submit']:hover {
        background-color: #0e74b8; /* Darker blue color on hover */
    }
    .form-container .success-message, .form-container .error-message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 3px;
    }
    .success-message {
        background-color: #dff0d8; /* Light green background for success message */
        border: 1px solid #3c763d;
        color: #3c763d;
    }
    .error-message {
        background-color: #f2dede; /* Light red background for error message */
        border: 1px solid #a94442;
        color: #a94442;
    }
</style>";

// Database connection
$servername = "localhost"; // Change this if your database is hosted elsewhere
$username = "root";
$password = "";
$dbname = "sample"; // Replace "sample" with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // Hidden input field in the form

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    // SQL query to update data in the table
    $sql = "UPDATE faculty SET first_name='$first_name', last_name='$last_name', gender='$gender', address='$address' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='form-container'>";
        echo "<div class='success-message'>Record updated successfully</div>";
        echo "</div>";
    } else {
        echo "<div class='form-container'>";
        echo "<div class='error-message'>Error updating record: " . $conn->error . "</div>";
        echo "</div>";
    }
}

// Check if ID parameter is passed in URL (e.g., edit.php?id=123)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch faculty details based on ID
    $sql = "SELECT * FROM faculty WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $gender = $row['gender'];
        $address = $row['address'];

        // Display edit form
        echo "<div class='form-container'>";
        echo "<h2>Edit Faculty Details</h2>";
        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "First Name: <input type='text' name='first_name' value='$first_name' placeholder='Enter your First Name'><br>";
        echo "Last Name: <input type='text' name='last_name' value='$last_name' placeholder='Enter your Last Name'><br>";
        echo "Gender: <select name='gender'>";
        echo "<option value='Male' " . ($gender == 'Male' ? 'selected' : '') . ">Male</option>";
        echo "<option value='Female' " . ($gender == 'Female' ? 'selected' : '') . ">Female</option>";
       
        echo "</select><br>";
        echo "Address: <input type='text' name='address' value='$address' placeholder='Enter your Address'><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<div class='form-container'>";
        echo "<div class='error-message'>Faculty member not found</div>";
        echo "</div>";
    }
}

$conn->close();
?>
