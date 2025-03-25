<!doctype html>
<html>
<head>
    <title>Add New Sponsor Company</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add New Sponsor Company</h2>
    <form method="post" action="addsponsor.php">
        <div class="form-group">
            <label>Company Name:</label>
            <input type="text" name="companyname" required>
        </div>

        <div class="form-group">
            <label>Sponsor Level:</label>
            <select name="sponsorlevel">
                <option value="Platinum">Platinum</option>
                <option value="Gold">Gold</option>
                <option value="Silver">Silver</option>
                <option value="Bronze">Bronze</option>
            </select>
        </div>

        <input type="submit" value="Add Sponsor">
    </form>

    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
