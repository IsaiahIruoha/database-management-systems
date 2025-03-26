<?php
// sponsormanagement.php 
require_once 'dbconnect.php';
$dbh = connectdb();

// messages for add/delete results
$addMessage = "";
$deleteMessage = "";

// if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // handle add sponsor
  if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $companyname = $_POST['companyname'];
    $sponsorlevel = $_POST['sponsorlevel'];
    try {
      $stmt = $dbh->prepare("
        INSERT INTO sponsorcompany (companyname, sponsorlevel)
        VALUES (:cname, :slevel)
      ");
      $stmt->bindParam(':cname', $companyname);
      $stmt->bindParam(':slevel', $sponsorlevel);
      $stmt->execute();
      $addMessage = "Sponsor Company Added!";
    } catch (PDOException $e) {
      $addMessage = "Error: " . $e->getMessage();
    }
  }
  // handle delete sponsor
  elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $delCompany = $_POST['delcompany'];
    try {
      $stmt = $dbh->prepare("DELETE FROM sponsorcompany WHERE companyname = :cn");
      $stmt->bindParam(':cn', $delCompany);
      $stmt->execute();
      $deleteMessage = "Deleted Sponsor Company!";
    } catch (PDOException $e) {
      $deleteMessage = "Error: " . $e->getMessage();
    }
  }
}

// get sponsor list for display
$stmt = $dbh->query("SELECT companyname, sponsorlevel FROM sponsorcompany");
$sponsorRows = "";
while ($row = $stmt->fetch()) {
  $sponsorRows .= "<tr>
      <td>{$row['companyname']}</td>
      <td>{$row['sponsorlevel']}</td>
    </tr>";
}
?>
<!doctype html>
<html>
<head>
  <title>Sponsor Management</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>Sponsor Management</h1>

  <h2>Add New Sponsor Company</h2>
  <?php if ($addMessage !== "") { echo "<p>$addMessage</p>"; } ?>
  <form method="post" action="sponsormanagement.php">
    <input type="hidden" name="action" value="add">
    <div class="form-group">
      <label>Company Name:</label>
      <input type="text" name="companyname" required>
    </div>
    <div class="form-group">
      <label>Sponsor Level:</label>
      <select name="sponsorlevel">
        <option value="Platinum">Platinum</option>
        <option value="Gold">Gold</option>
        <option value="Silver">Silver</option>
        <option value="Bronze">Bronze</option>
      </select>
    </div>
    <input type="submit" value="Add Sponsor">
  </form>

  <h2>Delete A Sponsor Company</h2>
  <?php if ($deleteMessage !== "") { echo "<p>$deleteMessage</p>"; } ?>
  <form method="post" action="sponsormanagement.php">
    <input type="hidden" name="action" value="delete">
    <div class="form-group">
      <label>Company Name To Delete:</label>
      <input type="text" name="delcompany" required>
    </div>
    <input type="submit" value="Delete Sponsor">
  </form>

  <h2>Sponsors & Levels</h2>
  <table>
    <tr>
      <th>Company Name</th>
      <th>Sponsor Level</th>
    </tr>
    <?php echo $sponsorRows; ?>
  </table>
  <p class="return-link">
    <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
  </p>
</div>
</body>
</html>
