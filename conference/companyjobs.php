<?php
// companyjobs.php
require_once 'dbconnect.php';
$dbh = connectdb();
?>
<!doctype html>
<html>
<head>
    <title>Jobs For A Company</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Enter Company Name</h2>
    <form method="post" action="companyjobs.php">
        <div class="form-group">
            <label>Company Name:</label>
            <input type="text" name="companyname" placeholder="E.g. TechCorp">
        </div>
        <input type="submit" value="Show Jobs">
    </form>

    <?php
    if (isset($_POST['companyname'])) {
        $company = $_POST['companyname'];
        $stmt = $dbh->prepare("
            select jobadid, title, city, province, payrate
            from jobad
            where companyname = :cn
        ");
        $stmt->bindParam(':cn', $company);
        $stmt->execute();

        echo "<h3>Jobs For {$company}</h3>";
        echo "<table>
                <tr><th>Job ID</th><th>Title</th><th>City</th><th>Province</th><th>Pay</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['jobadid']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['city']}</td>
                    <td>{$row['province']}</td>
                    <td>{$row['payrate']}</td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
