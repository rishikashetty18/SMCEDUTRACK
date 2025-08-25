<?php
include "connection.php";

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['name'],$_POST['email'],$_POST['subject'],$_POST['message']))
    {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $sub=$_POST['subject'];
    $msg=$_POST['message'];
    $query="INSERT INTO `feedback`( `name`, `email`, `subject`, `message`) 
    VALUES ('$name','$email','$sub','$msg')";
    $res=$con->query($query);
    if($res)
    echo "<script>alert('Feedback submitted successfully');
window.location.href='home.html';</script>";
    }
}