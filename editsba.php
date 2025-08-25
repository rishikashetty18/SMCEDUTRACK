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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Get form data
        $subject_id = $_POST['subject_id'];
        $subject_code = $_POST['subject_code'];
        $subject_name = $_POST['subject_name'];
        $faculty_name = $_POST['faculty_name'];

        // Prepare SQL statement
        $sql = "UPDATE sbasubjects SET subject_code=:subject_code, subject_name=:subject_name, faculty_name=:faculty_name WHERE id=:subject_id";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':subject_code', $subject_code);
        $stmt->bindParam(':subject_name', $subject_name);
        $stmt->bindParam(':faculty_name', $faculty_name);
        $stmt->bindParam(':subject_id', $subject_id);

        // Execute the statement
        $stmt->execute();

        echo "Subject details updated successfully.";
    } elseif (isset($_GET['id'])) { // Check if subject ID is provided via GET request
        $subject_id = $_GET['id'];

        // Fetch subject data based on ID
        $stmt = $conn->prepare("SELECT * FROM sbasubjects WHERE id=:subject_id");
        $stmt->bindParam(':subject_id', $subject_id);
        $stmt->execute();
        $subject = $stmt->fetch(PDO::FETCH_ASSOC);

        // Display form with pre-filled data
        if ($subject) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Edit Subject</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f0f0f0;
                    }

                    h2 {
                        color: #1E90FF;
                        margin-bottom: 20px;
                    }

                    form {
                        max-width: 500px;
                        margin: 20px auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }

                    label {
                        display: block;
                        margin-bottom: 10px;
                        color: #333;
                    }

                    input[type='text'] {
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 3px;
                        box-sizing: border-box;
                        margin-bottom: 15px;
                    }

                    input[type='submit'] {
                        background-color: #1E90FF;
                        color: #fff;
                        border: none;
                        padding: 10px 20px;
                        border-radius: 3px;
                        cursor: pointer;
                    }

                    input[type='submit']:hover {
                        background-color: #0e74b8;
                    }
                </style>
            </head>
            <body>
                <h2>Edit Subject</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="subject_id" value="<?php echo $subject['id']; ?>">
                    <label for="subject_code">Subject Code:</label>
                    <input type="text" id="subject_code" name="subject_code" value="<?php echo $subject['subject_code']; ?>" required><br><br>
                    <label for="subject_name">Subject Name:</label>
                    <input type="text" id="subject_name" name="subject_name" value="<?php echo $subject['subject_name']; ?>" required><br><br>
                    <label for="faculty_name">Faculty Name:</label>
                    <input type="text" id="faculty_name" name="faculty_name" value="<?php echo $subject['faculty_name']; ?>" required><br><br>
                    <input type="submit" name="submit" value="Update">
                </form>
            </body>
            </html>
            <?php
        } else {
            echo "Subject not found.";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
