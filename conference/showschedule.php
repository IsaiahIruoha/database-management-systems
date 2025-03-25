<?php
// showschedule.php
require_once 'dbconnect.php';
$dbh = connectdb();
?>
<!doctype html>
<html>
<head>
    <title>Display Schedule By Day</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Enter Day (YYYY-MM-DD)</h2>
    <form method="post" action="showschedule.php">
        <div class="form-group">
            <label>Day:</label>
            <input type="text" name="thedate" placeholder="2025-02-10">
        </div>
        <input type="submit" value="Show Schedule">
    </form>

    <?php
    if (isset($_POST['thedate']) && $_POST['thedate'] !== '') {
        $thedate = $_POST['thedate'];
        $stmt = $dbh->prepare("
            select sessionname, starttime, endtime, room
            from session
            where date(starttime) = :d
            order by starttime
        ");
        $stmt->bindParam(':d', $thedate);
        $stmt->execute();

        echo "<h3>Schedule For {$thedate}</h3>";
        echo "<table>
                <tr><th>Session</th><th>Start</th><th>End</th><th>Room</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['sessionname']}</td>
                    <td>{$row['starttime']}</td>
                    <td>{$row['endtime']}</td>
                    <td>{$row['room']}</td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
