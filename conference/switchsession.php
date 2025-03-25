<?php
// switchsession.php
require_once 'dbconnect.php';
$dbh = connectdb();

$sessionid = $_POST['sessionid'];
$newstart = $_POST['starttime'];
$newend   = $_POST['endtime'];
$newroom  = $_POST['room'];

try {
    $stmt = $dbh->prepare("
        update session
        set starttime = :st,
            endtime   = :et,
            room      = :r
        where sessionid = :sid
    ");
    $stmt->bindParam(':st', $newstart);
    $stmt->bindParam(':et', $newend);
    $stmt->bindParam(':r', $newroom);
    $stmt->bindParam(':sid', $sessionid);
    $stmt->execute();

    echo "<div class='container'>";
    echo "<p>Session updated!</p>";
    echo "<p class='return-link'><a href='conference.php'>Return Home</a></p>";
    echo "</div>";
} catch (PDOException $e) {
    echo "<div class='container'>";
    echo "Error: " . $e->getMessage();
    echo "</div>";
}
?>
