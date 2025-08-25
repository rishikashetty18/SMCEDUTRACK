<?php
session_start();
include("connection.php"); // $con should be your MySQLi connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname    = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($fname && $password) {
        // Login check with plain text password
        $stmt = $con->prepare("SELECT * FROM facreg WHERE fname = ? AND password = ?");
        $stmt->bind_param("ss", $fname, $password);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();

            $_SESSION['status']      = "faculty";
            $_SESSION['faculty_id']  = $row['id'];
            $_SESSION['fname']       = $row['fname'];
            $_SESSION['course']      = $row['course'];
            $_SESSION['semester']    = $row['semester'];
            $_SESSION['year']        = $row['year'];
            $_SESSION['full_class']  = $row['year'] . " " . $row['course'];

            echo "<script>alert('{$row['fname']} logged in successfully');
                  window.location.href='facultydash.php';</script>";
            exit;
        } else {
            echo "<script>alert('Invalid username or password');
                  window.location.href='facultylogin.html';</script>";
            exit;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Username and password are required');</script>";
    }
}
?>
