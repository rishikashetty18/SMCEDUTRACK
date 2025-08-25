<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login Form</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #ffffff;
        }
        
        .container {
            background-color: #ffffff;
            border: 1px solid #918f8f;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(15, 15, 15, 0.1);
            max-width: 400px;
            width: 100%;
            padding: 60px;
            box-sizing: border-box;
            animation: fadeIn 0.5s ease-out;
            text-align: center; /* Center text inside the container */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #413f3f;
            text-align: left; /* Align labels to the left */
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #161616;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #6BFFB0;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: blueviolet;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        button:hover {
            background: rgb(149, 116, 180);
        }

        #recovery-form {
            display: none;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        a.signup-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #3498db;
            transition: color 0.3s ease;
        }

        a.signup-link:hover {
            text-decoration: underline;
            color: #FF6B6B;
        }

        .forgot-password {
            display: block;
            text-align: center;
            font-size: 12px;
            margin-top: 10px;
            text-decoration: none;
            color: #3498db;
            transition: color 0.3s ease;
            margin-bottom: 10px;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #FF6B6B;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .button-container button {
            width: 48%;
        }

    </style>
</head>
<body>
    <?php
    include "connection.php";
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(isset($_POST['username'],$_POST['password']))
        {
            $studid=$_POST['username'];
            $pwd=$_POST['password'];
            $_SESSION['status']='student';
            $sql="SELECT * FROM students WHERE student_id='$studid' AND password='$pwd'";
            $result=$con->query($sql);
            if($result->num_rows>0)
            {
                $row=$result->fetch_assoc();
                $_SESSION['student_id']=$row['student_id'];//for printing added marks
                $_SESSION['class_of_student']=$row['class'];
                $_SESSION['first_name']=$row['first_name'];
                $_SESSION['last_name']=$row['last_name'];
                echo "<script>alert('{$row['first_name']} logged in successfully');
                window.location.href='studenthomepage.php';</script>";

            }
            else{
                $checkId="SELECT student_id from students where student_id='$studid'";
                $result=$con->query($checkId);
                if($result->num_rows>0)
                echo "<script>window.alert('password is incorrect')</script>";
                else
                echo "<script>window.alert('$studid is not registered')</script>";
            }
        }
    }
    ?>

<div class="container">
    <h2>Student Login Form</h2>
    <form id="login-form" action="" method="post">
        <label for="username">Student Id:</label>
        <input type="text" id="username" name="username"  required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"
               title="Password must be alphanumeric with at least one number, one letter, and minimum 8 characters" required>

        <button type="submit">Login</button>
        <div class="button-container">
            <button type="button" style="width:50%;margin-top:5px;margin-right:3px;" onclick="window.location.href='facultylogin.html'">Faculty</button>
            <button type="button" style="width:50%;margin-top:5px;" onclick="window.location.href='login.html'">Admin</button>
        </div>
    </form>
</div>

<script>
    function openRecoveryForm() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('recovery-form').style.display = 'block';
    }

    function resetPassword() {
        var newPassword = document.getElementById('new-password').value;
        var confirmPassword = document.getElementById('confirm-password').value;

        if (newPassword !== confirmPassword) {
            alert("Passwords do not match. Please try again.");
            return false;
        }
        console.log("New Password:", newPassword);
        alert("Password reset successful!");
        window.location.href = "facultylogin.html";
        return false;

        var email = document.getElementById('email').value;
        var securityQuestion = document.getElementById('security-question').value;
        var answer = document.getElementById('answer').value;

        console.log("Email:", email);
        console.log("Security Question:", securityQuestion);
        console.log("Answer:", answer);
    }

    function login() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        if (username === "admin" && password === "admin123") {
            window.location.href = "admin.html";
            return false;
        } else {
            return false;
        }
    }
</script>
</body>
</html>
