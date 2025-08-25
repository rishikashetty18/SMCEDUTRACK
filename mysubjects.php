<?php
session_start();
include "connection.php";

// ── Access check ──
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'faculty') {
    echo "<script>alert('Faculty should log in first'); location.href='facultylogin.html';</script>";
    exit;
}

$fid = $_SESSION['faculty_id'];
$fname = $_SESSION['fname'] ?? '';
$lname = $_SESSION['lname'] ?? '';

// ── Fetch assigned subjects ──
$stmt = $con->prepare("SELECT subject, class, semester FROM facultysubjects WHERE faculty_id = ? ORDER BY class, semester");
$stmt->bind_param("i", $fid);
$stmt->execute();
$subjects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Subjects</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f4f6fb; padding: 2rem; }
    h2 { margin-bottom: 1rem; }
    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 10px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #007bff;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .topbar {
      background: #fff;
      padding: 10px 20px;
      box-shadow: 0 1px 4px rgba(0,0,0,.1);
      margin-bottom: 20px;
    }
    .topbar span {
      font-size: 1.2rem;
      font-weight: bold;
    }
    .topbar .right {
      float: right;
    }
  </style>
</head>
<body>

<div class="topbar">
  <span>EduTrack – My Subjects</span>
  <span class="right">Welcome, <?= htmlspecialchars($fname . ' ' . $lname) ?></span>
</div>

<h2>Your Assigned Subjects</h2>

<?php if (count($subjects) > 0): ?>
  <table>
    <tr>
      <th>Subject</th>
      <th>Class</th>
      <th>Semester</th>
    </tr>
    <?php foreach ($subjects as $sub): ?>
      <tr>
        <td><?= htmlspecialchars($sub['subject']) ?></td>
        <td><?= htmlspecialchars($sub['class']) ?></td>
        <td>Semester <?= (int)$sub['semester'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php else: ?>
  <p>No subjects assigned to you yet.</p>
<?php endif; ?>

</body>
</html>
