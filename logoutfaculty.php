<?php
include "connection.php";
if(isset($_SESSION['status'])){
    $_SESSION['status']=null;
echo "<script>window.location.href='facultylogin.html'</script>;";}