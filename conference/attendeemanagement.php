<?php
// attendeemanagement.php 
require_once 'dbconnect.php';
$dbh = connectdb();

// messages for add/delete results
$addMessage = "";
$deleteMessage = "";

// if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // handle add attendee
  if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $attendeeid = $_POST['attendeeid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $isstudent = isset($_POST['isstudent']);
    $roomnumber = $_POST['roomnumber'];

    try {
      // insert into attendee
      $stmt = $dbh->prepare("
        INSERT INTO attendee (attendeeid, firstname, lastname, email)
        VALUES (:id, :fn, :ln, :em)
      ");
      $stmt->bindParam(':id', $attendeeid);
      $stmt->bindParam(':fn', $firstname);
      $stmt->bindParam(':ln', $lastname);
      $stmt->bindParam(':em', $email);
      $stmt->execute();

      // if student also insert into student table
      if ($isstudent) {
        $stmt2 = $dbh->prepare("
          INSERT INTO student (attendeeid, roomnumber)
          VALUES (:id, :rn)
        ");
        $actualroom = ($roomnumber === "") ? null : $roomnumber;
        $stmt2->bindParam(':id', $attendeeid);
        $stmt2->bindParam(':rn', $actualroom);
        $stmt2->execute();
      }

      $addMessage = "Attendee Added Successfully!";
    } catch (PDOException $e) {
      $addMessage = "Error: " . $e->getMessage();
    }
  }
  // handle delete attendee
  elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $deleteid = $_POST['deleteid'];
    try {
      // removing from attendee should cascade to student/professional/sponsor due to on delete cascade
      $stmt = $dbh->prepare("DELETE FROM attendee WHERE attendeeid = :aid");
      $stmt->bindParam(':aid', $deleteid);
      $stmt->execute();
      $deleteMessage = "Deleted Attendee!";
    } catch (PDOException $e) {
      $deleteMessage = "Error: " . $e->getMessage();
    }
  }
}

// fetch lists of students, professionals, sponsors
$students = $dbh->query("
  SELECT a.attendeeid, a.firstname, a.lastname
  FROM attendee a
  JOIN student s ON a.attendeeid = s.attendeeid
");

$pros = $dbh->query("
  SELECT a.attendeeid, a.firstname, a.lastname
  FROM attendee a
  JOIN professional p ON a.attendeeid = p.attendeeid
");

$sponsors = $dbh->query("
  SELECT a.attendeeid, a.firstname, a.lastname, s.companyname
  FROM attendee a
  JOIN sponsor s ON a.attendeeid = s.attendeeid
");
?>
<!doctype html>
<html>
<head>
  <title>Attendee Management</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>Attendee Management</h1>
  <h2>Add A New Attendee</h2>
  <?php if (!empty($addMessage)) { echo "<p>{$addMessage}</p>"; } ?>
  <form method="post" action="attendeemanagement.php">
    <input type="hidden" name="action" value="add">
    <div class="form-group">
      <label>Attendee ID:</label>
      <input type="number" name="attendeeid" required>
    </div>
    <div class="form-group">
      <label>First Name:</label>
      <input type="text" name="firstname" required>
    </div>
    <div class="form-group">
      <label>Last Name:</label>
      <input type="text" name="lastname" required>
    </div>
    <div class="form-group">
      <label>Email:</label>
      <input type="email" name="email" required>
    </div>
    <div class="form-group">
      <label><input type="checkbox" name="isstudent" value="yes"> Is Student?</label>
    </div>
    <div class="form-group">
      <label>Select Hotel Room (If Student):</label>
      <select name="roomnumber">
        <option value="">(None)</option>
        <?php
        // populate hotel room options
        $rooms = $dbh->query("SELECT roomnumber FROM hotelroom");
        foreach ($rooms as $r) {
          echo "<option value='{$r['roomnumber']}'>{$r['roomnumber']}</option>";
        }
        ?>
      </select>
    </div>
    <input type="submit" value="Add Attendee">
  </form>

  <h2>Delete An Attendee</h2>
  <?php if (!empty($deleteMessage)) { echo "<p>{$deleteMessage}</p>"; } ?>
  <form method="post" action="attendeemanagement.php">
    <input type="hidden" name="action" value="delete">
    <div class="form-group">
      <label>Attendee ID To Delete:</label>
      <input type="number" name="deleteid" required>
    </div>
    <input type="submit" value="Delete Attendee">
  </form>

  <h2>Attendees</h2>
  <h3>Students</h3>
  <table>
    <tr><th>ID</th><th>First Name</th><th>Last Name</th></tr>
    <?php while ($row = $students->fetch()) { ?>
      <tr>
        <td><?php echo $row['attendeeid']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
      </tr>
    <?php } ?>
  </table>

  <h3>Professionals</h3>
  <table>
    <tr><th>ID</th><th>First Name</th><th>Last Name</th></tr>
    <?php while ($row = $pros->fetch()) { ?>
      <tr>
        <td><?php echo $row['attendeeid']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
      </tr>
    <?php } ?>
  </table>

  <h3>Sponsors</h3>
  <table>
    <tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Company</th></tr>
    <?php while ($row = $sponsors->fetch()) { ?>
      <tr>
        <td><?php echo $row['attendeeid']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['lastname']; ?></td>
        <td><?php echo $row['companyname']; ?></td>
      </tr>
    <?php } ?>
  </table>
  <p class="return-link">
    <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
  </p>
</div>
</body>
</html>
