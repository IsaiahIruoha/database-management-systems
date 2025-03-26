<?php
// switchsession.php 
require_once 'dbconnect.php';
$dbh = connectdb();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessionid'])) {
  $sessionid = $_POST['sessionid'];
  $newstart = $_POST['starttime'];
  $newend = $_POST['endtime'];
  $newroom = $_POST['room'];

  try {
    $stmt = $dbh->prepare("
      update session
      set starttime = :st,
          endtime = :et,
          room = :r
      where sessionid = :sid
    ");
    $stmt->bindParam(':st', $newstart);
    $stmt->bindParam(':et', $newend);
    $stmt->bindParam(':r', $newroom);
    $stmt->bindParam(':sid', $sessionid);
    $stmt->execute();

    echo "<div class='container'><p>session updated!</p>";
    echo "<p class='return-link'><button class='return-button' type='button' onclick=\"location.href='conference.php'\">return home</button></p></div>";
  } catch (PDOException $e) {
    echo "<div class='container'><p>error: " . $e->getMessage() . "</p></div>";
  }
}
?>

<!doctype html>
<html>
<head>
  <title>Switch Session Info</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Switch Session Day/Time/Location</h2>
    <form method="post" action="switchsession.php">
      <div class="form-group">
        <label>Session ID To Update:</label>
        <input type="number" name="sessionid" required>
      </div>
      <div class="form-group">
        <label>New Start Datetime (YYYY-MM-DD HH:MM:SS):</label>
        <input type="text" name="starttime" placeholder="2025-02-10 10:00:00">
      </div>
      <div class="form-group">
        <label>New End Datetime (YYYY-MM-DD HH:MM:SS):</label>
        <input type="text" name="endtime" placeholder="2025-02-10 12:00:00">
      </div>
      <div class="form-group">
        <label>New Room:</label>
        <input type="text" name="room" placeholder="Hall A">
      </div>
      <input type="submit" value="Update Session">
    </form>
    <p class="return-link">
      <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
    </p>
  </div>
</body>
</html>
