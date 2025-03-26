<?php
// listalljobs.php
require_once 'dbconnect.php';
$dbh = connectdb();

$stmt = $dbh->query("select companyname, jobadid, title, city, province, payrate from jobad");
?>
<!doctype html>
<html>
<head>
  <title>List All Jobs</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>All Available Jobs</h2>
    <table>
      <tr>
        <th>Company</th>
        <th>Job ID</th>
        <th>Title</th>
        <th>City</th>
        <th>Province</th>
        <th>Pay Rate</th>
      </tr>
      <?php
      while ($row = $stmt->fetch()) {
        echo "<tr>
                <td>{$row['companyname']}</td>
                <td>{$row['jobadid']}</td>
                <td>{$row['title']}</td>
                <td>{$row['city']}</td>
                <td>{$row['province']}</td>
                <td>{$row['payrate']}</td>
              </tr>";
      }
      ?>
    </table>
    <p class="return-link">
      <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
    </p>
  </div>
</body>
</html>
