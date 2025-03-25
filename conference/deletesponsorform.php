<!doctype html>
<html>
<head>
    <title>Delete A Sponsor Company</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Delete A Sponsor Company</h2>
    <form method="post" action="deletesponsor.php">
        <div class="form-group">
            <label>Company Name To Delete:</label>
            <input type="text" name="companyname" required>
        </div>
        <input type="submit" value="Delete Sponsor">
    </form>
    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
