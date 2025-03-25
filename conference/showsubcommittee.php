<?php
// showsubcommittee.php
require_once 'dbconnect.php';
$dbh = connectdb();
?>
<!doctype html>
<html>
<head>
    <title>Show Sub-Committee Members</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Choose Sub-Committee</h2>
    <form method="post" action="showsubcommittee.php">
        <div class="form-group">
            <label>Sub-Committee Name:</label>
            <select name="subcommitteename">
                <option value="">(Select One)</option>
                <?php
                $sql = "select subcommitteename from subcommittee";
                foreach ($dbh->query($sql) as $row) {
                    echo "<option value='{$row['subcommitteename']}'>{$row['subcommitteename']}</option>";
                }
                ?>
            </select>
        </div>
        <input type="submit" value="Show Members">
    </form>

    <?php
    if (isset($_POST['subcommitteename']) && $_POST['subcommitteename'] !== '') {
        $chosen = $_POST['subcommitteename'];
        $stmt = $dbh->prepare("
            select cm.committeememberid, cm.firstname, cm.lastname
            from subcommitteemember scm
            join committeemember cm on scm.committeememberid = cm.committeememberid
            where scm.subcommitteename = :sc
        ");
        $stmt->bindParam(':sc', $chosen);
        $stmt->execute();

        echo "<h3>Members Of {$chosen}</h3>";
        echo "<table>
                <tr><th>ID</th><th>First Name</th><th>Last Name</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['committeememberid']}</td>
                    <td>{$row['firstname']}</td>
                    <td>{$row['lastname']}</td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
