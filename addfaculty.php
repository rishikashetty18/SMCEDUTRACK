<!-- <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Information Form</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0; /* Light gray background */
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff; /* White background */
    }
    h1 {
        text-align: center;
        color: #1E90FF; /* Dark blue color for heading */
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #333; /* Dark text color */
    }
    .form-group input[type="text"],input[type="password"],
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }
    .form-group input[type="submit"] {
        background-color: #1E90FF; /* Dark blue background */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 3px;
        cursor: pointer;
        text-align: center;
    }
    .form-group input[type="submit"]:hover {
        background-color: #0066cc; /* Darker blue on hover */
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Faculty Information Form</h1>
        <form action="submitfaculty.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br><br>
            </div>
            
            
            <div class="form-group">
                <label for="class">Class:</label>
                <select  id="class" name="class" required>
            <option>BCA</option>
            <option>Bcom</option>
            <option>BA</option>        
            </select><br><br>
            </div>

            <div class="formgroup">
                <label for="password">Password:</label>
                <input type="password" name="password">
            </div>

            <div style="margin-top:20px;" class="form-group">
                <input type="submit" style="width:100%;" value="Submit">
            </div>
        </form>
    </div>
</body>
</html> -->


<?php
include "connection.php"; // ensure this connects using mysqli ($con)

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name      = $_POST['name'];       // corresponds to fname
    $course    = $_POST['course'];
    $year      = $_POST['year'];
    $semester  = $_POST['semester'];
    $rawPass   = $_POST['password'];
    // $hash      = password_hash($rawPass, PASSWORD_DEFAULT); // hashed password
     $password  = $_POST['password']; 

    $stmt = $con->prepare("INSERT INTO facreg (fname, course, year, semester, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $name, $course, $year, $semester, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Faculty added successfully'); location.href='facultylist.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Add Faculty</title>
<style>
/* (styling unchanged, shortened for clarity) */
body{font-family:Arial;background:#f0f0f0}
.container{max-width:500px;margin:50px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.1)}
label{display:block;margin:.8rem 0 .2rem;font-weight:600}
input,select{width:100%;padding:.6rem;border:1px solid #ccc;border-radius:4px}
input[type=submit]{background:#1E90FF;color:#fff;border:none;cursor:pointer;margin-top:1rem}
input[type=submit]:hover{background:#0066cc}
</style>
</head>
<body>
<div class="container">
 <h1>Add Faculty</h1>

 <form method="post">
    <label>Name</label>
    <input required name="name">

    <label>Course</label>
    <select required name="course">
       <option value="">–select–</option>
       <option>BCA</option><option>BA</option><option>BCOM</option>
    </select>

    <label>Year</label>
    <select required name="year" id="year">
       <option value="">–select–</option>
       <option value="First">First Year</option>
       <option value="Second">Second Year</option>
       <option value="Third">Third Year</option>
    </select>

    <label>Semester</label>
    <select required name="semester" id="semester">
        <option value="">–select–</option>
    </select>

    <label>Password</label>
    <input required type="password" name="password">

    <input type="submit" value="Save">
 </form>
</div>

<script>
/* populate semester list when Year changes */
const yearSem={First:["1","2"],Second:["3","4"],Third:["5","6"]};
document.getElementById('year').addEventListener('change',e=>{
  const semSel=document.getElementById('semester');
  semSel.innerHTML='<option value="">–select–</option>';
  (yearSem[e.target.value]||[]).forEach(s=>{
    const o=document.createElement('option');
    o.value=s;o.textContent=s;semSel.appendChild(o);
  });
});
</script>
</body>
</html>
