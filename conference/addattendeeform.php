<!doctype html>
<html>
<head>
    <title>Add A New Attendee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add A New Attendee</h2>
    <form method="post" action="addattendee.php">
        <div class="form-group">
            <label>Attendee ID:</label>
            <input type="number" name="attendeeid" required>
        </div>

        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="firstname" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="lastname" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="isstudent" value="yes"> Is Student?</label>
        </div>

        <div class="form-group">
            <label>Select Hotel Room (If Student):</label>
            <select name="roomnumber">
                <option value="">(None)</option>
                <?php
                require_once 'dbconnect.php';
                $dbh = connectdb();
                $rooms = $dbh->query("select roomnumber from hotelroom");
                foreach ($rooms as $r) {
                    echo "<option value='{$r['roomnumber']}'>{$r['roomnumber']}</option>";
                }
                ?>
            </select>
        </div>

        <input type="submit" value="Add Attendee">
    </form>

    <p class="return-link"><a href="conference.php">Return Home</a></p>
</div>
</body>
</html>
