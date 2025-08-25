<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FBCA Subjects List</title>
    <style>
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
</style>
</head>

<body>
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

        // Fetch data from fbcasubjects table
        $stmt = $conn->prepare("SELECT * FROM fbasubjects");
        $stmt->execute();
        $subjects = $stmt->fetchAll();

        // Display data in a table
        echo "<h2> Subjects List</h2>";
        echo "<table>";
        echo "<tr><th>Subject Code</th><th>Subject Name</th><th>Faculty Name</th><th>Actions</th></tr>";
        foreach ($subjects as $subject) {
            echo "<tr>";
            echo "<td>".$subject['subject_code']."</td>";
            echo "<td>".$subject['subject_name']."</td>";
            echo "<td>".$subject['faculty_name']."</td>";
            echo "<td class='action-buttons'>";
            echo "<button class='edit-btn' onclick='editSubject(".$subject['id'].")'>Edit</button>";
            echo "<button class='remove-btn' onclick='removeSubject(".$subject['id'].")'>Remove</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
    ?>

    <script>
        function editSubject(id) {
            // Redirect to editfbca.php with subject ID parameter
            window.location.href = "editfba.php?id=" + id;
        }

        function removeSubject(id) {
            // Redirect or handle removal logic here
            window.location.href = "removefba.php?id=" + id;
        }
    </script>
</body>

</html>
