<?php
// switchsession.php - process session update if submitted and then display form and current sessions
require_once 'dbconnect.php';
$dbh = connectdb();

// if form submitted, process the update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sessionid'])) {
  $sessionid = $_POST['sessionid'];
  $newstart = $_POST['starttime'];
  $newend = $_POST['endtime'];
  $newroom = $_POST['room'];

  try {
    $stmt = $dbh->prepare("
      UPDATE session
      SET starttime = :st,
          endtime = :et,
          room = :r
      WHERE sessionid = :sid
    ");
    $stmt->bindParam(':st', $newstart);
    $stmt->bindParam(':et', $newend);
    $stmt->bindParam(':r', $newroom);
    $stmt->bindParam(':sid', $sessionid);
    $stmt->execute();

    $updateMessage = "Session Updated!";
  } catch (PDOException $e) {
    $updateMessage = "Error: " . $e->getMessage();
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
    <?php
      // display message if an update was processed
      if (isset($updateMessage)) {
        echo "<p>$updateMessage</p>";
      }
    ?>
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

    <h2>Current Sessions</h2>
    <?php
      // query to get current sessions ordered by start time
      $stmt = $dbh->query("SELECT sessionID, sessionName, startTime, endTime, room FROM session ORDER BY startTime");
      if ($stmt->rowCount() > 0) {
        echo "<table>";
        echo "<tr><th>Session ID</th><th>Session Name</th><th>Start Time</th><th>End Time</th><th>Room</th></tr>";
        while ($row = $stmt->fetch()) {
          echo "<tr>
                  <td>{$row['sessionID']}</td>
                  <td>{$row['sessionName']}</td>
                  <td>{$row['startTime']}</td>
                  <td>{$row['endTime']}</td>
                  <td>{$row['room']}</td>
                </tr>";
        }
        echo "</table>";
      } else {
        echo "<p>No sessions found.</p>";
      }
    ?>

    <p class="return-link">
      <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
    </p>
  </div>
</body>
</html>
