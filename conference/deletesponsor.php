<?php
// deletesponsor.php
require_once 'dbconnect.php';
$dbh = connectdb();

$companyname = $_POST['companyname'];

try {
    $stmt = $dbh->prepare("delete from sponsorcompany where companyname = :cn");
    $stmt->bindParam(':cn', $companyname);
    $stmt->execute();

    echo "<div class='container'>";
    echo "<p>Deleted sponsor company!</p>";
    echo "<p class='return-link'><a href='conference.php'>Return Home</a></p>";
    echo "</div>";
} catch (PDOException $e) {
    echo "<div class='container'>";
    echo "Error: " . $e->getMessage();
    echo "</div>";
}
?>
