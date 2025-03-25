<?php
// addattendee.php
require_once 'dbconnect.php';
$dbh = connectdb();

$attendeeid = $_POST['attendeeid'];
$firstname  = $_POST['firstname'];
$lastname   = $_POST['lastname'];
$email      = $_POST['email'];
$isstudent  = isset($_POST['isstudent']);
$roomnumber = $_POST['roomnumber'];

try {
    $stmt = $dbh->prepare("
        insert into attendee (attendeeid, firstname, lastname, email)
        values (:id, :fn, :ln, :em)
    ");
    $stmt->bindParam(':id', $attendeeid);
    $stmt->bindParam(':fn', $firstname);
    $stmt->bindParam(':ln', $lastname);
    $stmt->bindParam(':em', $email);
    $stmt->execute();

    if ($isstudent) {
        $stmt2 = $dbh->prepare("
            insert into student (attendeeid, roomnumber)
            values (:id, :rn)
        ");
        $actualroom = ($roomnumber == "") ? null : $roomnumber;
        $stmt2->bindParam(':id', $attendeeid);
        $stmt2->bindParam(':rn', $actualroom);
        $stmt2->execute();
    }

    echo "<div class='container'>";
    echo "<p>Attendee added successfully!</p>";
    echo "<p class='return-link'><a href='conference.php'>Return Home</a></p>";
    echo "</div>";
} catch (PDOException $e) {
    echo "<div class='container'>";
    echo "Error: " . $e->getMessage();
    echo "</div>";
}
?>
