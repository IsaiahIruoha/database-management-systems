<!doctype html>
<html>
<head>
  <title>Conference Organizer Portal</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <h1>Conference Organizer Portal</h1>
  <p>
    this portal allows you to manage all aspects of the conference, 
    including sub-committees, attendees, sponsors, schedules, and more.
  </p>
  <img src="conference.jpg" alt="conference banner" class="banner-image">

  <h2>Manage Your Conference Tasks</h2>
  <p>select an action below:</p>

  <div class="nav-buttons">
    <button class="nav-button" onclick="location.href='showsubcommittee.php'">Show Sub-Committee Members</button>
    <button class="nav-button" onclick="location.href='listhotelroom.php'">List Students By Hotel Room</button>
    <button class="nav-button" onclick="location.href='showschedule.php'">Display Schedule By Day</button>

    <button class="nav-button" onclick="location.href='sponsormanagement.php'">Sponsor Management</button>
    <button class="nav-button" onclick="location.href='companyjobs.php'">Jobs For A Company</button>
    <button class="nav-button" onclick="location.href='listalljobs.php'">List All Jobs</button>
    
    <button class="nav-button" onclick="location.href='attendeemanagement.php'">Attendee Management</button>
    
    <button class="nav-button" onclick="location.href='showintake.php'">Show Total Intake</button>
    <button class="nav-button" onclick="location.href='switchsession.php'">Switch Session Info</button>
  </div>
</div>
</body>
</html>
