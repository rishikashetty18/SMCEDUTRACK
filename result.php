<?php
include "connection.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if faculty is logged in
if (!isset($_SESSION['username']) || $_SESSION['status'] !== 'faculty') {
    echo "<script>alert('Unauthorized access'); window.location.href='facultylogin.html';</script>";
    exit;
}

// Faculty details
$facultyId = $_SESSION['faculty_id'];
$classOfStudents = $_GET['class'] ?? null;
$semester = $_GET['semester'] ?? null;
$filterStudentId = $_GET['student_id'] ?? null;
$subjectFromURL = $_GET['subject'] ?? null;



echo "<pre>DEBUG — class: '$classOfStudents' | semester: '$semester' | student_id: '$filterStudentId'</pre>";

// Then build your SQL:
$sql = $filterStudentId
  ? "SELECT * FROM students WHERE student_id = '$filterStudentId'"
  : "SELECT * FROM students WHERE class = '$classOfStudents'";

echo "<pre>DEBUG — SQL: $sql</pre>";


// Auto-fill class & semester from result table if student ID is passed
if ($filterStudentId && (!$classOfStudents || !$semester)) {
    $autoFill = $con->query("SELECT class, semester FROM result WHERE student_id = '$filterStudentId' LIMIT 1");
    if ($autoFill && $autoFill->num_rows > 0) {
        $r = $autoFill->fetch_assoc();
        $classOfStudents = $r['class'];
        $semester = $r['semester'];
    }
}

// Get subject list
$subjectQuery = $con->query("SELECT subject_name FROM subjects 
    WHERE faculty_id = '$facultyId' AND course = '$classOfStudents' AND semester = '$semester'");

if ($subjectQuery->num_rows > 1) {
    echo "<form method='post'><select name='changedsubject'>";
    while ($row = $subjectQuery->fetch_assoc()) {
        $sub = $row['subject_name'];
        $selected = (isset($_SESSION['subject']) && $_SESSION['subject'] == $sub) ? "selected" : "";
        echo "<option $selected value='$sub'>$sub</option>";
    }
    echo "</select><button type='submit'>View</button></form>";
}

// Set subject
if (isset($_POST['changedsubject'])) {
    $_SESSION['subject'] = $_POST['changedsubject'];
}
if ($subjectFromURL) {
    $_SESSION['subject'] = $subjectFromURL;
}

$subject = $_SESSION['subject'] ?? ($subjectQuery->fetch_assoc()['subject_name'] ?? null);

// Show error if no subject found
if (!$subject) {
    echo "<script>alert('Your subject is not registered for this semester'); window.location.href='facultydash.php';</script>";
    exit;
}

echo "<h2>$classOfStudents - Semester $semester - $subject</h2>";

// Save marks
if (isset($_POST['save'])) {
    $studid = $_POST['studid'];
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $inter1 = $_POST['internal1'];
    $inter2 = $_POST['internal2'];
    $assign = $_POST['assignment'];
    $seminar = $_POST['seminar'];
    $marks = $_POST['marksobtained'];
    $percentage = $_POST['percentage'];
    $grade = $_POST['grade'];

    $exists = $con->query("SELECT * FROM result WHERE student_id='$studid' 
        AND class='$classOfStudents' AND semester='$semester' AND subject='$subject'");

    if ($exists->num_rows <= 0) {
        $con->query("INSERT INTO result (student_id, first_name, last_name, internal1, internal2, seminar, assignment, marks_obtained, total_marks, percentage, grade, class, semester, subject) 
        VALUES ('$studid', '$fname', '$lname', '$inter1', '$inter2', '$seminar', '$assign', '$marks', '40', '$percentage', '$grade', '$classOfStudents', '$semester', '$subject')");
    } else {
        $con->query("UPDATE result SET internal1='$inter1', internal2='$inter2', seminar='$seminar', assignment='$assign', marks_obtained='$marks', percentage='$percentage', grade='$grade' 
        WHERE student_id='$studid' AND class='$classOfStudents' AND semester='$semester' AND subject='$subject'");
    }
    echo "<script>alert('Saved');</script>";
}

// Get student list
$sql = $filterStudentId 
    ? "SELECT * FROM students WHERE student_id = '$filterStudentId'" 
    : "SELECT * FROM students WHERE class = '$classOfStudents'";

echo "<pre>Looking for class: '$classOfStudents'</pre>";

$res = $con->query($sql);
if (!$res || $res->num_rows === 0) {
    echo "<script>alert('No students found for the selected class. Please see that students are registered'); window.location.href='facultydash.php';</script>";
    exit;
}

echo "<p>Found {$res->num_rows} students.</p>";
echo "<table>
<tr>
<th>Stud_ID</th><th>First Name</th><th>Last Name</th>
<th>Internal 1</th><th>Internal 2</th><th>Assignment</th><th>Seminar</th>
<th>Marks Obtained</th><th>Total Marks</th><th>Percentage</th><th>Grade</th><th>Save</th>
</tr>";

while ($row = $res->fetch_assoc()) {
    $sid = $row['student_id'];
    $markQuery = $con->query("SELECT * FROM result WHERE student_id='$sid' 
        AND class='$classOfStudents' AND semester='$semester' AND subject='$subject'");
    $m = $markQuery->fetch_assoc() ?? [];

    echo "<form method='post'><tr>
        <td><input type='text' name='studid' value='{$sid}' readonly></td>
        <td><input type='text' name='firstname' value='{$row['first_name']}' readonly></td>
        <td><input type='text' name='lastname' value='{$row['last_name']}' readonly></td>
        <td><input type='number' name='internal1' value='{$m['internal1'] ?? ''}' min='0' max='10' onkeyup='calculatemarks("$sid")' class='$sid'></td>
        <td><input type='number' name='internal2' value='{$m['internal2'] ?? ''}' min='0' max='10' onkeyup='calculatemarks("$sid")' class='$sid'></td>
        <td><input type='number' name='assignment' value='{$m['assignment'] ?? ''}' min='0' max='10' onkeyup='calculatemarks("$sid")' class='$sid'></td>
        <td><input type='number' name='seminar' value='{$m['seminar'] ?? ''}' min='0' max='10' onkeyup='calculatemarks("$sid")' class='$sid'></td>
        <td><input type='number' name='marksobtained' value='{$m['marks_obtained'] ?? ''}' readonly class='$sid'></td>
        <td><input type='number' value='40' readonly></td>
        <td><input type='text' name='percentage' value='{$m['percentage'] ?? ''}%' readonly class='$sid'></td>
        <td><input type='text' name='grade' value='{$m['grade'] ?? ''}' readonly class='$sid'></td>
        <td><input type='submit' name='save' value='Save' class='submit'></td>
    </tr></form>";
}
echo "</table>";
$con->close();
?>

<script>
function calculatemarks(cn) {
    const fields = document.getElementsByClassName(cn);
    let i1 = Number(fields[0].value) || 0;
    let i2 = Number(fields[1].value) || 0;
    let asn = Number(fields[2].value) || 0;
    let sem = Number(fields[3].value) || 0;
    let total = i1 + i2 + asn + sem;
    let perc = (total / 40) * 100;
    fields[4].value = total;
    fields[6].value = perc.toFixed(2) + "%";

    let grade = 'F';
    if (perc >= 90) grade = 'A+';
    else if (perc >= 80) grade = 'A';
    else if (perc >= 70) grade = 'B+';
    else if (perc >= 60) grade = 'B';
    else if (perc >= 50) grade = 'C+';
    else if (perc >= 35) grade = 'C';

    fields[7].value = grade;
}
</script>
