<!doctype html>
<html>
<head>
    <title>Switch Session Info</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Switch Session Day/Time/Location</h2>
    <form method="post" action="switchsession.php">
        <div class="form-group">
            <label>Session ID To Update:</label>
            <input type="number" name="sessionid" required>
        </div>
        <div class="form-group">
            <label>New Start Datetime (YYYY-MM-DD HH:MM:SS):</label>
            <input type="text" name="starttime" placeholder="2025-02-10 10:00:00">
        </div>
        <div class="form-group">
            <label>New End Datetime (YYYY-MM-DD HH:MM:SS):</label>
            <input type="text" name="endtime" placeholder="2025-02-10 12:00:00">
        </div>
        <div class="form-group">
            <label>New Room:</label>
            <input type="text" name="room" placeholder="Hall A">
        </div>
        <input type="submit" value="Update Session">
    </form>
    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
