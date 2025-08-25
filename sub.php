<?php

include "connection.php";

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare SQL statement
        $course=$_POST['course'];
        $yoc=$_POST['year_of_course'];
        $sem=$_POST['semester'];
        $sc=$_POST['subject_code'];
        $sname=$_POST['subject_name'];
        $fname=$_POST['faculty_name'];
        $fid=$_POST['f_id'];

        $sql = "INSERT INTO `subjects`(`course`, `year_of_course`,
         `semester`, `subject_code`, `subject_name`, `faculty_name`, `faculty_id`) VALUES 
        ('$course','$yoc','$sem','$sc','$sname','$fname','$fid')";
        
        $res = $con -> query($sql);
        if($res)
        echo "Subject details inserted successfully.";
    }


// Close the connection
$conn = null;
?>
