<h1>Student Homepage</h1>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #1E90FF;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
    .submit {
        background-color: blue;
        color: white;
        padding: 5px;
        cursor: pointer;
    }
    
    </style>
     
<?php include "connection.php";if($_SESSION['status']!='student' or !(isset($_SESSION['username'])))
echo "<script>alert('Student should login first');window.location.href='studentlogin.php';</script>";?>
<p style="font-size:2.2rem;">
<div style="display:grid;width:25%;grid-template-columns:repeat(4,1fr);">
<strong>Stud_ID </strong><?php  
echo $_SESSION['student_id'];?>    
<strong>First Name </strong><?php echo $_SESSION['first_name'];?>
    <strong>Last Name </strong> <?php echo $_SESSION['last_name'];?>
    <strong>Class</strong> <?php echo $_SESSION['class_of_student'];?>
   
    </div> </p>
<?php 

$obtainQuery = "SELECT * FROM `result` WHERE `student_id`='{$_SESSION['student_id']}'  
        AND `class`='{$_SESSION['class_of_student']}' ";
        $result=$con->query($obtainQuery);


if ($result->num_rows > 0) {
    echo "<table>
<tr>
<th>Semester</th>
<th>Subject</th>
    <th>Internal 1</th>
    <th>Internal 2</th>
    <th>Assignment</th>
    <th>Seminar</th>
    <th>Marks Obtained</th>
    <th>Total Marks</th>
    <th>Percentage</th>
    <th>Grade</th>
    
</tr>";
    while($row=$result->fetch_assoc()){
    echo "<tr>
    <td>{$row['semester']}</td>
    <td>{$row['subject']}</td>
    <td>{$row['internal1']}</td>
    <td>{$row['internal2']}</td>
    <td>{$row['seminar']}</td>
    <td>{$row['assignment']}</td>
    <td>{$row['marks_obtained']}</td>
    <td>40</td>
    <td>{$row['percentage']}</td>
    <td>{$row['grade']}</td>
    </tr>";}
    echo "</table>";
}
    else{
        echo "<span>Marks have not been entered yet</span>";
    }
?>