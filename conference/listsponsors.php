<?php
// listsponsors.php
require_once 'dbconnect.php';
$dbh = connectdb();

$stmt = $dbh->query("select companyname, sponsorlevel from sponsorcompany");
?>
<!doctype html>
<html>
<head>
    <title>List Sponsors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Sponsors & Levels</h2>
    <table>
        <tr><th>Company Name</th><th>Sponsor Level</th></tr>
        <?php
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['companyname']}</td>
                    <td>{$row['sponsorlevel']}</td>
                  </tr>";
        }
        ?>
    </table>
    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
