<?php
// listattendees.php
require_once 'dbconnect.php';
$dbh = connectdb();

// students
$students = $dbh->query("
    select a.attendeeid, a.firstname, a.lastname
    from attendee a
    join student s on a.attendeeid = s.attendeeid
");

// professionals
$pros = $dbh->query("
    select a.attendeeid, a.firstname, a.lastname
    from attendee a
    join professional p on a.attendeeid = p.attendeeid
");

// sponsors
$sponsors = $dbh->query("
    select a.attendeeid, a.firstname, a.lastname, s.companyname
    from attendee a
    join sponsor s on a.attendeeid = s.attendeeid
");
?>
<!doctype html>
<html>
<head>
    <title>Show Attendees</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Students</h2>
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

    <h2>Professionals</h2>
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

    <h2>Sponsors</h2>
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

    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
