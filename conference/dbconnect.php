<?php
// dbconnect.php
function connectdb() {
  $dsn = 'mysql:host=localhost;dbname=conferenceDB';
  $username = 'root';
  $password = '';

  try {
    $dbh = new PDO($dsn, $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
  } catch (PDOException $e) {
    echo "connection failed: " . $e->getMessage();
    exit();
  }
}
?>
