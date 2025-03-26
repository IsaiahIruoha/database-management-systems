<?php
// listhotelroom.php 
require_once 'dbconnect.php';
$dbh = connectdb();
?>
<!doctype html>
<html>
<head>
  <title>List Students By Hotel Room</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Select A Hotel Room</h2>
    <form method="post" action="listhotelroom.php">
      <div class="form-group">
        <label>Room Number:</label>
        <select name="roomnumber">
          <option value="">(Choose A Room)</option>
          <?php
          $rooms = $dbh->query("select roomnumber from hotelroom");
          foreach ($rooms as $r) {
            echo "<option value='{$r['roomnumber']}'>{$r['roomnumber']}</option>";
          }
          ?>
        </select>
      </div>
      <input type="submit" value="Show Students">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roomnumber']) && $_POST['roomnumber'] !== '') {
      $roomnum = $_POST['roomnumber'];
      $stmt = $dbh->prepare("
        select a.attendeeid, a.firstname, a.lastname
        from student s
        join attendee a on a.attendeeid = s.attendeeid
        where s.roomnumber = :rn
      ");
      $stmt->bindParam(':rn', $roomnum);
      $stmt->execute();

      echo "<h3>Students In Room {$roomnum}</h3>";
      echo "<table>
              <tr><th>Attendee ID</th><th>First Name</th><th>Last Name</th></tr>";
      while ($row = $stmt->fetch()) {
        echo "<tr>
                <td>{$row['attendeeid']}</td>
                <td>{$row['firstname']}</td>
                <td>{$row['lastname']}</td>
              </tr>";
      }
      echo "</table>";
    }
    ?>
    <p class="return-link">
      <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
    </p>
  </div>
</body>
</html>
