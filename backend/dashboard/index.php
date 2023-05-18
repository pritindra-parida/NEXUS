<?php 
  include('../partials/_dbconnect.php');
  include('../partials/_functions.php');

  session_start();
  checkFDUser();
  $username = $_SESSION['username'];
  $dbname = "user_" . fetchUserId($username) . "_" . $username;
  $conn = new mysqli($dbserver, $dbusername, $dbpassword, $dbname);
  $tablename= "event_list";
  $sql = "SELECT * FROM " . $tablename;
  $result = mysqli_query($conn, $sql);
?>

<!-- Event Table Creation Query
CREATE TABLE `**user_db_name**`.`**event_id_details**` (`event_id` INT(3) NOT NULL AUTO_INCREMENT , `event_name` VARCHAR(250) NOT NULL , `event_description` VARCHAR(250) NOT NULL , `event_venue` VARCHAR(250) NOT NULL , `participants_number` INT(250) NOT NULL , `event_start_date` DATE NOT NULL , `event_end_date` DATE NOT NULL , `event_start_time` TIME NOT NULL , `event_end_time` TIME NOT NULL , `speaker_count` INT(10) NOT NULL , `organizer_count` INT(10) NOT NULL , `contact_email` VARCHAR(250) NOT NULL , PRIMARY KEY (`event_id`)) ENGINE = InnoDB;
 -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bruno+Ace+SC&display=swap" rel="stylesheet">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <title>NEXUS - Dashboard</title> 
</head>
<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="black_logo.png" alt="NEXUS-LOGO">
                </span>

                <div class="text logo-text">
                    <span class="name" id="nexus">NEXUS</span>
                    <span class="profession"><?php print($_SESSION['username']) ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <ul class="menu-links" style="padding-left: 0;">
                    <li class="nav-link" id="home_btn">
                        <a href="#">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>

                    <li class="nav-link" id="your_events_btn">
                        <a href="#">
                            <i class='bx bx-calendar-event icon'></i>
                            <span class="text nav-text">Your Events</span>
                        </a>
                    </li>

                    <li class="nav-link" id="attendees_btn">
                        <a href="#">
                            <i class='bx bx-group icon' ></i>
                            <span class="text nav-text">Attendees</span>
                        </a>
                    </li>

                    <li class="nav-link" id="notification_btn">
                        <a href="#">
                            <i class='bx bx-bell icon' ></i>
                            <span class="text nav-text">Notification</span>
                        </a>
                    </li>

                    <li class="nav-link" id="calender_btn">
                        <a href="#">
                            <i class='bx bx-cog icon' ></i>
                            <span class="text nav-text">Settings</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">

                <li class="">
                    <a href="#">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>

    </nav>

    <!--============
    Home Section
    ============ -->
    <section class="home visible" id="home">
        <div class="text">Hiii, Welcome To Your Dashboard</div>
        <div class="text"><button class="btn btn-primary" id="create-event">Create Event</button></div>

    </section>

    <!--============
    Your Events Section
    ============ -->
    <section class="intro home invisible" id="your_events">
        <div class="mask d-flex align-items-center h-100">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
                      <table class="table table-striped mb-0">
                        <thead style="background-color: #002d72;">
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Venue</th>
                            <th scope="col">Attendees</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <td><?php echo $row['event_id'] ?></td>
                                <td><?php echo $row['event_name'] ?></td>
                                <td><?php echo $row['event_date'] ?></td>
                                <td><?php echo $row['event_venue'] ?></td>
                                <td><?php echo $row['participants_number'] ?></td>
                            </tr>   
                            <?php
                                }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>


    <!--============
    Event Attendees Section
    ============ -->
    <section class="intro home invisible" id="event_attendees">
        <div class="mask d-flex align-items-center h-100">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
                        <h1 style="text-align: center;">Event Attendees</h1>
                      <table class="table table-striped mb-0">
                        <thead style="background-color: #002d72;">
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Degignation</th>
                            <th scope="col">Organization</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <?php
                                $sql = "SELECT * FROM " . $tablename; //this will not work mate
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['degignation'] ?></td>
                                <td><?php echo $row['organization'] ?></td>
                            </tr>   
                            <?php
                                }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

    <!--============
    Notification Section
    ============ -->
    <section class="intro home notification invisible" id="notification">
        <div class="text">This is the notification Section</div>
    </section>


    <!--============
    Calender Section
    ============ -->
    <section class="intro home calender invisible" id="calender">
        <div class="text">This is the Calender Section</div>
    </section>

    <!--============
    Event Form Section
    ============ -->
    <section class="intro home invisible" id="event-form">
        <div class="mask d-flex align-items-center h-200">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12">
        <div class="card" style="line-height: 2.5rem;">
            <div class="card-header">
                <h3 class="card-title">Event Creation Form</h3>
            </div>
        <div class="card-body">
          <form action="create_event.php" method="POST" id="form-1">
            <div class="form-group">
              <label for="event-name">Name of Event</label>
              <input type="text" class="form-control" id="event-name" name="event-name" placeholder="Enter event name">
            </div>
            <div class="form-group">
              <label for="event-description">Event Description</label>
              <textarea class="form-control" id="event-description" name="event-description" rows="3"></textarea>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="event-venue">Venue</label>
                <input type="text" class="form-control" id="event-venue" name="event-venue" placeholder="Enter event venue">
              </div>
              <div class="col-md-6">
                <label for="event-participants">Number of Participants</label>
                <input type="number" class="form-control" id="event-participants-number" name="event-participants-number" placeholder="Enter number of participants">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="event-start-date">Start Date</label>
                <input type="date" class="form-control" id="event-start-date" name="event-start-date">
              </div>
              <div class="col-md-6">
                <label for="event-end-date">End Date</label>
                <input type="date" class="form-control" id="event-end-date" name="event-end-date">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label for="event-start-time">Start Time</label>
                <input type="time" class="form-control" id="event-start-time" name="event-start-time">
              </div>
              <div class="col-md-6">
                <label for="event-end-time">End Time</label>
                <input type="time" class="form-control" id="event-end-time" name="event-end-time">
              </div>
            </div>
          <!-- </form> -->
          <hr>
          <h3 class="card-title">Speakers Details</h3>
          <!-- <form method="POST" action="" id="form-2"> -->
            <div class="form-group">
              <label for="speaker-number">Number of Speakers</label>
              <input type="number" class="form-control" id="speaker-number" name="speaker-number" placeholder="Enter number of speakers">
            </div>
            <div id="speaker-details">
              <!-- Speaker details fields will be generated here -->
            </div>
          <!-- </form> -->
          <hr>
          <h3 class="card-title">Organizers Details</h3>
          <!-- <form> -->
            <div class="form-group">
              <label for="organizer-number">Number of Organizers</label>
              <input type="number" class="form-control" id="organizer-number" name="organizer-number" placeholder="Enter number of organizers">
            </div>
            <div id="organizer-names">
              <!-- Organizer name input fields will be generated here -->
            </div>
          <!-- </form> -->
          <hr>
          <h3 class="card-title">Contact Details</h3>
          <!-- <form method="POST" action="contact.php" id="form-3"> -->
            <div class="form-group row">
              <div class="col-md-6">
                <label for="event-venue">Contact Email</label>
                <input type="text" class="form-control" id="contact-email" name="contact-email" placeholder="Enter contact email">
              </div>
              <div class="col-md-6">
                <label for="event-participants">Contact Mobile Number</label>
                <input type="number" class="form-control" id="contact-phone" name="contact-phone" placeholder="Enter contact mobile number">
              </div>
            </div>
            <div class="form-group buttons" >
              <button type="submit" class="btn btn-primary" id="submit">Submit</button>
              <button type="button" class="btn btn-secondary" id="cancel">Cancel</button>
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
</div>
</div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="script.js"></script>

</body>
</html>