<?php
// addsponsor.php
require_once 'dbconnect.php';
$dbh = connectdb();

$companyname = $_POST['companyname'];
$sponsorlevel = $_POST['sponsorlevel'];

try {
    $stmt = $dbh->prepare("
        insert into sponsorcompany (companyname, sponsorlevel)
        values (:cname, :slevel)
    ");
    $stmt->bindParam(':cname', $companyname);
    $stmt->bindParam(':slevel', $sponsorlevel);
    $stmt->execute();

    echo "<div class='container'>";
    echo "<p>Sponsor company added!</p>";
    echo "<p class='return-link'><a href='conference.php'>Return Home</a></p>";
    echo "</div>";
} catch (PDOException $e) {
    echo "<div class='container'>";
    echo "Error: " . $e->getMessage();
    echo "</div>";
}
?>
