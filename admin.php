<?php
include "connection.php";
$studentCount = 0;
$result = mysqli_query($con, "SELECT COUNT(*) AS total FROM students");
if ($row = mysqli_fetch_assoc($result)) {
  $studentCount = $row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<!-- Boxicons CSS -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
<title>Side Navigation Bar in HTML CSS JavaScript</title>
<link rel="stylesheet" href="adminstyle.css" />
</head>
<body>
  <?php include "connection.php";
  if($_SESSION['status']!='admin')echo "<script>alert('You are not an admin');
  window.location.href='login.html';</script>";?>
<!-- navbar -->
<nav class="navbar">
  <div class="logo_item">
    <i class="bx bx-menu" id="sidebarOpen"></i>
    <img src="images/logo1.png" alt=""></i>Edu Track
  </div>

  <div class="search_bar">
    <input type="text" placeholder="Search" />
  </div>

  <div class="navbar_content">
    <i class="bi bi-grid"></i>
    <i class='bx bx-sun' id="darkLight"></i>
    
    <!-- Profile Image -->
    <img src="images/profile.jpg" alt="" class="profile" id="profileImg" />
    
    <!-- Logout Button (initially hidden) -->
    <button id="logoutBtn" style="display: none;">Logout</button>
</div>
</nav>

<!-- sidebar -->
<nav class="sidebar">
  <div class="menu_content">
    <ul class="menu_items">
      <div class="menu_title menu_dahsboard"></div>
      <!-- start -->
      <li class="item">
        <a href="#" class="nav_link submenu_item">
          <span class="navlink_icon">
            <i class="bx bx-user"></i> <!-- Icon for Students -->
          </span>
          <span class="navlink">Student</span>
          <i class="bx bx-chevron-right arrow-left"></i>
        </a>

        <ul class="menu_items submenu">
          <a href="addstudent.php" class="nav_link sublink">Add Student</a>
          <a href="studentlist.php" class="nav_link sublink">View</a>
        </ul>
      </li>
      <!-- end -->

      <!-- start -->
      <li class="item">
        <a href="#" class="nav_link submenu_item">
          <span class="navlink_icon">
            <i class="bx bx-user-voice"></i> <!-- Icon for Faculty -->
          </span>
          <span class="navlink">Faculty</span>
          <i class="bx bx-chevron-right arrow-left"></i>
        </a>

        <ul class="menu_items submenu">
          <a href="addfaculty.php" class="nav_link sublink">Add Faculty</a>
          <a href="facultylist.php" class="nav_link sublink">View</a>
        </ul>

      </li>
      <!-- end -->

      <li class="item">
        <a href="#" class="nav_link submenu_item">
          <span class="navlink_icon">
          <i class="bx bx-file"></i>
          </span>
          <span class="navlink">Course</span>
          <i class="bx bx-chevron-right arrow-left"></i>
        </a>

        <ul class="menu_items submenu">
          <a href="bca.php" class="nav_link sublink">BCA</a>
          <a href="bcom.php" class="nav_link sublink">BCOM</a>
          <a href="ba.php" class="nav_link sublink">BA</a>
        </ul>
      </li>
      
      <li class="item">
        <a href="subform.php" class="nav_link submenu_item">
          <span class="navlink_icon">
          <i class="bx bx-file"></i>
          </span>
          <span class="navlink">Subject</span>
          <i class="bx bx-chevron-right arrow-left"></i>
        </a>

        
      </li>
      
      <!-- Sidebar Open / Close -->
      </ul>
    <div class="bottom_content">
      <div class="bottom expand_sidebar">
        <span> Expand</span>
        <i class='bx bx-log-in'></i>
      </div>
      <div class="bottom collapse_sidebar">
        <span> Logout</span>
        <a class='bx bx-log-out' style="text-decoration:none;" href="logoutfaculty.php"></a>
      </div>
    </div>
  </div>
</nav>
<script src="adminscript.js"></script>
<!-- DASHBOARD CONTENT START -->
<div class="main-content" style="margin-left:260px; padding: 2rem; background: #f1f5f9; min-height: 100vh;">
  <h2 style="font-weight: 600;">👋 Welcome, Admin</h2>
  <!-- <p style="color: gray;">Here’s a quick overview of EduTrack</p> -->

  <!-- Cards Section -->
  <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 2rem;">
    <div style="flex: 1; min-width: 220px; background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <h5>Total Students</h5>
      <div style="font-size: 2rem; color: #007bff;"><i class='bx bx-user'></i> <?php echo $studentCount; ?></div>
    </div>
    <div style="flex: 1; min-width: 220px; background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <h5>Total Faculty</h5>
      <div style="font-size: 2rem; color: #28a745;"><i class='bx bx-user-voice'></i> 45</div>
    </div>
    <div style="flex: 1; min-width: 220px; background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <h5>Classes Today</h5>
      <div style="font-size: 2rem; color: #ffc107;"><i class='bx bx-calendar'></i> 12</div>
    </div>
    <div style="flex: 1; min-width: 220px; background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <h5>Avg Attendance</h5>
      <div style="font-size: 2rem; color: #dc3545;"><i class='bx bx-line-chart'></i> 89%</div>
    </div>
  </div>

  <!-- Schedule and Recent Activity -->
  <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 3rem;">
    <div style="flex: 1; min-width: 300px; background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <h5>📅 Today’s Schedule</h5>
      <ul style="padding-left: 1rem;">
        <li>10:00 AM - DBMS (CS101)</li>
        <li>11:30 AM - Java Programming (CS102)</li>
        <li>2:00 PM - DSA Lab (CS103)</li>
      </ul>
    </div>
    <div style="flex: 1; min-width: 300px; background: #ffffff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
      <h5>📥 Recent Activity</h5>
      <ul style="padding-left: 1rem;">
        <li>Added Subject: "AI & ML"</li>
        <li>Faculty "Anita M" registered</li>
        <li>Attendance marked for "CS101"</li>
      </ul>
    </div>
  </div>
</div>
<!-- DASHBOARD CONTENT END -->

</body>
</html>
