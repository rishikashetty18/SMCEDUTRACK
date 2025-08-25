<?php
session_start();
include "connection.php";
echo "<pre>Logged-in faculty_id = " . ($_SESSION['faculty_id'] ?? 'NOT SET') . "</pre>";

// ── Login check ──
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'faculty') {
  echo "<script>alert('Faculty should log in first'); location.href='facultylogin.html';</script>";
  exit;
}

// ── Session data ──
$fid   = $_SESSION['faculty_id'] ?? 0;
$fname = $_SESSION['fname'] ?? '';
$lname = $_SESSION['lname'] ?? '';

// ── Fetch subjects/classes/semester ──
$subq = "
  SELECT subject, class, semester
  FROM facultysubjects
  WHERE faculty_id = ?
  ORDER BY class, semester
";
$stmt = $con->prepare($subq);
$stmt->bind_param("i", $fid);
$stmt->execute();
$subs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// ── Check for pending marks ──
if ($subs) {
  $whereParts = [];
  foreach ($subs as $s) {
    $whereParts[] = "(subject='".$con->real_escape_string($s['subject'])."' AND class='".$con->real_escape_string($s['class'])."')";
  }
  $whereSQL = implode(" OR ", $whereParts);

  // ✅ Debug print
  echo "<pre>WHERE SQL: $whereSQL</pre>";

  $pendingSQL = "
    SELECT *
    FROM result
    WHERE ($whereSQL)
      AND (internal1 IS NULL OR internal2 IS NULL OR seminar IS NULL OR assignment IS NULL)
  ";

  echo "<pre>Final SQL: $pendingSQL</pre>";

  $pending = $con->query($pendingSQL);
  if ($pending === false) {
      echo "<pre>SQL Error: " . $con->error . "</pre>";
  }
  $pendingCount = $pending->num_rows;
} else {
  $whereSQL     = "1=0";
  $pending      = false;
  $pendingCount = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Faculty Dashboard</title>
<link rel="stylesheet" href="adminstyle.css">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<style>
body{font-family:Arial;margin:0;background:#f4f6fb}
.card-box{flex:1;min-width:220px;background:#fff;border-radius:12px;padding:1.4rem;
          box-shadow:0 4px 10px rgba(0,0,0,0.1);cursor:pointer}
.card-box:hover{box-shadow:0 6px 14px rgba(0,0,0,0.15)}
.card-box h5{margin:0 0 8px;color:#555;font-weight:500}
.card-value{font-size:1.8rem;color:#007bff}
.hide{display:none}
table{width:100%;border-collapse:collapse;margin-top:15px}
th,td{border:1px solid #ccc;padding:6px 8px;font-size:.9rem;text-align:left}
th{background:#007bff;color:#fff}
</style>
</head>
<body>

<!-- ==== Top Bar ==== -->
<div style="background:#fff;padding:10px 20px;box-shadow:0 1px 4px rgba(0,0,0,.1);">
  <span style="font-size:1.2rem;font-weight:bold">EduTrack – Faculty</span>
  <span style="float:right">Welcome, <?= htmlspecialchars($fname . " " . $lname) ?></span>
</div>

<!-- ==== Dashboard Cards ==== -->
<div style="padding:2rem;display:flex;flex-wrap:wrap;gap:20px">

  <!-- My Classes -->
  <div class="card-box" onclick="toggleList('classList')">
    <h5>My Classes</h5>
    <div class="card-value">
      <i class='bx bx-building-house'></i>
      <?= $subs ? count($subs) : 0 ?>
    </div>
  </div>

  <!-- Subjects Assigned -->
  <div class="card-box" onclick="location.href='mysubjects.php'">
    <h5>Subjects Assigned</h5>
    <div class="card-value"><i class='bx bx-book'></i> <?= $subs ? count($subs) : 0 ?></div>
  </div>

  <!-- Marks to Assign -->
 <div class="card-box" onclick="location.href='result.php?class=<?= urlencode($subs[0]['class']) ?>&semester=<?= urlencode($subs[0]['semester']) ?>&subject=<?= urlencode($subs[0]['subject']) ?>'">
  <h5>Marks to Assign</h5>
  <div class="card-value"><i class='bx bx-pencil'></i> <?= $pendingCount ?></div>
</div>

</div>

<!-- ==== My Classes List ==== -->
<div id="classList" class="hide" style="padding:0 2rem;">
  <h3>My Classes / Semesters</h3>
  <ul>
    <?php if ($subs): ?>
      <?php foreach ($subs as $s): ?>
        <li>
          <?= htmlspecialchars($s['class']) ?> – <?= htmlspecialchars($s['subject']) ?> (Sem <?= (int)$s['semester'] ?>)
          |
          <a href='result.php?class={$sub['class']}&semester={$sub['semester']}'>Enter Marks</a>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <li>No classes assigned</li>
    <?php endif; ?>
  </ul>
</div>

<!-- ==== JS Toggle ==== -->
<script>
function toggleList(id){
  document.getElementById(id).classList.toggle('hide');
}
</script>
</body>
</html>
