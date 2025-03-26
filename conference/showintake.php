<?php
// showintake.php
require_once 'dbconnect.php';
$dbh = connectdb();

// function to map sponsor levels to amounts
function sponsorlevelamount($level) {
  switch($level) {
    case 'Platinum': return 5000;
    case 'Gold': return 3000;
    case 'Silver': return 2000;
    case 'Bronze': return 1000;
  }
  return 0;
}

$totalsponsorship = 0;
$sponsquery = $dbh->query("select sponsorlevel from sponsorcompany");
while ($row = $sponsquery->fetch()) {
  $totalsponsorship += sponsorlevelamount($row['sponsorlevel']);
}

$countnonsponsor = $dbh->query("
  select count(*) as c
  from attendee
  where attendeeid not in (select attendeeid from sponsor)
")->fetch();
$registrationcount = $countnonsponsor['c'];
$registrationtotal = $registrationcount * 200;
?>
<!doctype html>
<html>
<head>
  <title>Show Total Intake</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Total Intake</h2>
    <p>Registration Amount: $<?php echo $registrationtotal; ?></p>
    <p>Sponsorship Amount: $<?php echo $totalsponsorship; ?></p>
    <p><strong>Grand Total:</strong> $<?php echo ($registrationtotal + $totalsponsorship); ?></p>
    <p class="return-link">
      <button class="return-button" type="button" onclick="location.href='conference.php'">Return Home</button>
    </p>
  </div>
</body>
</html>
