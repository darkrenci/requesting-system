<?php

use Sabberworm\CSS\Value\Value;

session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['savePoll'])) {
    $question = $_POST['question'];
    $options = $_POST['options'];
    $username = $_POST['created_by'];
    $poll_id = $_POST['poll_id'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_id) {
        if ($poll_id) {
            $stmt = $conn->prepare("UPDATE polls SET question = ? WHERE id = ?");
            $stmt->bind_param("si", $question, $poll_id);
            $stmt->execute();
            $stmt->close();

            $conn->query("DELETE FROM options WHERE poll_id = $poll_id");
        } else {
            $stmt = $conn->prepare("INSERT INTO polls (question, created_by) VALUES (?, ?)");
            $stmt->bind_param("si", $question, $user_id);
            $stmt->execute();
            $poll_id = $stmt->insert_id;
            $stmt->close();
        }

        $opt_stmt = $conn->prepare("INSERT INTO options (poll_id, text) VALUES (?, ?)");
        foreach ($options as $opt) {
            $opt_stmt->bind_param("is", $poll_id, $opt);
            $opt_stmt->execute();
        }
        $opt_stmt->close();

        $_SESSION['message'] = "✅ Poll saved!";
    } else {
        $_SESSION['message'] = "❌ User not found.";
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle Delete Poll
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePoll'])) {
    $poll_id = $_POST['poll_id'];
    $conn->query("DELETE FROM votes WHERE option_id IN (SELECT id FROM options WHERE poll_id = $poll_id)");
    $conn->query("DELETE FROM options WHERE poll_id = $poll_id");
    $conn->query("DELETE FROM polls WHERE id = $poll_id");

    $_SESSION['message'] = "🗑️ Poll deleted.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Admin Dashboard</title>
    <!-- <link rel="stylesheet" href="css/adminsample2.css"> -->
    <link rel="stylesheet" href="css/newAdmin.css">
    <link rel="icon" href="pics/logo.jpg">

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-VhAtZjHpP6X+C56q6lye9V3G6Xc1cf+5kHYB5Bv1qIhjmJw2+A0Gr9dPplT+RiE/" crossorigin="anonymous">
</head>
<body >

    <?php
        require_once 'connect.php';
        
        // Check if admin is logged in
        if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
            header('Location: signin.php');
            exit(); // Terminate script execution after redirection
            $query = "SELECT log_entry, log_date FROM logs ORDER BY log_date DESC";
        $result = $conn->query($query);
        $logs = [];
            while ($row = $result->fetch_assoc()) {
                $logs[] = $row;
        }

        // Return logs data as JSON
        header('Content-Type: application/json');
        echo json_encode(['logs' => $logs]);
        }
    ?>

<div class="holder">


        <?php

            $username = $_SESSION['username'];
            $role = $_SESSION['role'];

        ?>

    <!-- NAVIGATION BAR FOR LARGE SCREENS -->
    <nav class="sidebar d-lg-block d-none">
        <h3 class="text-white text-center pt-4 pb-3">Barangay Admin</h3>

        <p class="text-white text-center user">
            <?php
                echo "<b>User:</b> $username <br><b>Role:</b> $role";
            ?>
        </p>

        <div class="navList">
            <ul class="list-unstyled components">
                <li><a href="#" id="dashboardLink">Dashboard</a></li>
                <li><a href="#" id="docRequestLink">Document Request</a></li>
                <li><a href="#" id="listUsersLink">List of Users</a></li>
                <li><a href="#" id="councilImgLink">Add / Delete Council Image</a></li>
                <li><a href="#" id="eventImgLink">Add Events</a></li>
                <li><a href="#" id="pollSystemLink">Poll System</a></li>
                <li><a href="#" id="announcementLink">Post Announcement</a></li>
                <li><a href="#" id="logsLink">Logs</a></li>
                <li><a href="#" id="deleteAllLink" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete Accounts</a></li>
            </ul>

            <div class="logout">
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Log out</a>
            </div>
        </div>
        
    </nav>

    <!-- NAVIGATION BAR FOR SMALL SCREENS -->
    <div class="adminHead2 px-4 py-2 d-lg-none d-flex align-items-center justify-content-between">
        <i class="fa fa-bars iconbar d-block d-lg-none" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"></i>
        <img src="pics/logo.jpg" alt="">
    </div>
    
    <!-- <hr class="d-lg-none"> -->

    <div class="offcanvas offcanvas-start d-lg-none w-50" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title text-white text-center" id="offcanvasExampleLabel">Barangay Admin</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div>
                <nav class="sidebar">

                    <p class="text-white text-center user">
                        <?php
                            echo "<b>User:</b> $role $username";
                        ?>
                    </p>

                    <div class="navList">
                        <ul class="list-unstyled components">
                            <li><a href="#" id="dashboardLink">Dashboard</a></li>
                            <li><a href="#" id="docRequestLink">Document Request</a></li>
                            <li><a href="#" id="listUsersLink">List of Users</a></li>
                            <li><a href="#" id="councilImgLink">Add / Delete Council Image</a></li>
                            <li><a href="#" id="eventImgLink">Add Events</a></li>
                            <li><a href="#" id="pollSystemLink">Poll System</a></li>
                            <li><a href="#" id="announcementLink">Post Announcement</a></li>
                            <li><a href="#" id="logsLink">Logs</a></li>
                            <li><a href="#" id="deleteAllLink" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete Accounts</a></li>
                        </ul>

                        <div class="logout">
                            <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;Log out</a>
                        </div>
                    </div>
                    
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <!-- this modal will show when the generate document button was clicked
    and will ask for the serial number of the document they are generating -->
    <div class="modal fade" id="modalSerialNum" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Generate Document</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Type the serial number for this document</h5>
                    <form action="" method="post" class="mt-2">
                        <div class="serial d-flex align-items-center justify-content-center">
                            <input type="text" name="serialNum" id="serialNum">

                        </div>
                        <center><button type="submit" class="btn btn-primary p-1 mt-1" id="confirmButton" name="submit_serial">Enter</button></center>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- get the value of the serial input -->
    <?php

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_serial'])){
            $serialNum = $_POST['serialNum'];
            // echo htmlspecialchars($serialNum);

            $_SESSION['serialNumber'] = $serialNum;
        }
    ?>


    <div class="content mt-3">
        
        <div class="adminHead d-none d-lg-flex align-items-center justify-content-between">
            <h1>Barangay 635</h1>
            <div class="admin-content">
                <img src="pics/logo.jpg" alt="">
            </div>
        </div>

        <!-- Modal to delete all admin accounts -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered deleteAdmin">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="staticBackdropLabel">Delete Accounts</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>Are you sure you want to delete all admin accounts?</h5>
                        <p><b>Here's what will happen:</b></p>
                        <ul>
                            <li>Admin accounts will be deleted permanently</li>
                            <li>Unable to restore accounts</li>
                            <li>Admins will lose access to the dashboard</li>
                            <li>Admins may not see requests from the citizens</li>
                            <li>All accounts logged in will be logged out</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm">Understood</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered deleteAdmin">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="staticBackdropLabel">Delete Accounts</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Enter 3 admin accounts to complete the action</h6>

                        <form class="mt-1" action="deleteAcc.php" method="post">
                            <div class="input">
                                <label for="username1">Admin #1</label>
                                <div class="input-element">
                                    <input type="text" name="username[]" id="username1" placeholder="Username" required>
                                    <input type="password" name="password[]" id="password1" placeholder="Password" required>
                                </div>
                                
                            </div>
                            <div class="input">
                                <label for="username2">Admin #2</label>
                                <div class="input-element">
                                    <input type="text" name="username[]" id="username2" placeholder="Username" required>
                                    <input type="password" name="password[]" id="password2" placeholder="Password" required>
                                </div>
                                
                            </div>
                            <div class="input">
                                <label for="username3">Admin #3</label>
                                <div class="input-element">
                                    <input type="text" name="username[]" id="username3" placeholder="Username" required>
                                    <input type="password" name="password[]" id="password3" placeholder="Password" required>
                                </div>
                                
                            </div>
                            <center><button type="submit" class="btn btn-primary mt-3" name="delConfirm">Confirm</button></center>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Back</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="container">

            <!-- DASHBOARD -->
            <div id="dashboard" class="content-section active">
                <h2>Dashboard</h2>
                <div class="box-container">
                    <div class="box one" id="numUsers">
                        Users: 0
                    </div>
                    <div class="box two" id="numBarangayClearance">
                        Barangay Clearance Requests: 0
                    </div>
                    <div class="box four" id="numIndigency">
                        Certificate of Indigency Requests: 0
                    </div>
                    <div class="box five" id="numResidency">
                        Certificate of Residency Requests: 0
                    </div>
                    <div class="box six" id="numMaleUsers">
                        Male Users: 0
                    </div>
                    <div class="box seven" id="numFemaleUsers">
                        Female Users: 0
                    </div>
                </div>
                

            </div> <!-- closing div of .dashboard -->

            <!-- DOCUMENT REQUEST -->
            <div id="docRequest" class="content-section">
                <h2>Document Request</h2>
                <div class="rbox-container">
                    <div class="request-box" id="barangayClearanceRequests">
                        <h3>Barangay Clearance Requests</h3>
                        <!-- Table for displaying Barangay Clearance Requests will be inserted here -->
                    </div>
                    <div class="request-box" id="indigencyRequests">
                        <h3>Certificate of Indigency Requests</h3>
                        <!-- Table for displaying Certificate of Indigency Requests will be inserted here -->
                    </div>
                    <div class="request-box" id="residencyRequests">
                        <h3>Certificate of Residency Requests</h3>
                        <!-- Table for displaying Certificate of Residency Requests will be inserted here -->
                    </div>
                </div>
                <div id="requestDetails" style="display: none;">
                    <!-- Placeholder for displaying request details -->
                </div>
            </div>

            <!-- LIST OF USERS -->
            <div id="listUsers" class="content-section">
                <h2>List of Users</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Middle Name</th>
                                <th>Contact Number</th>
                                <th>Gender</th>
                                <th>Citizen</th>
                                <th>House Number</th>
                                <th>Street</th>
                                <th>Email</th>
                                <th>Birthday</th>

                            </tr>
                        </thead>
                        <tbody id="userList"></tbody>
                    </table>
                </div>
            </div>

            <!-- ADD COUNCIL IMAGE CODE -->
            <div id="councilImg" class="content-section">
                <h2>Add/Delete Council Image</h2>
                <!-- input image option -->
                <div class="containerWrap">
                    <form class="d-md-flex align-items-center justify-content-between" action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="image" required multiple>
                        <div class="btnHolder d-flex align-items-center justify-content-center">
                            <button class="btn btn-primary" type="submit" name="submit_council">Upload</button>
                        </div>
                        
                    </form>


                    <!-- UPLOAD IMAGE IN DATABASE -->
                    <?php
                        include("connect.php");

                        if (isset($_POST['submit_council'])) {
                            // Check if file was uploaded without errors
                            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                                $image = $_FILES['image']['tmp_name'];
                                $imgContent = addslashes(file_get_contents($image));
                                $imageType = $_FILES['image']['type'];
                                $imageName = $_FILES['image']['name'];

                                // Insert image content into database
                                $sql = "INSERT INTO img_upload (image, image_type, image_name) VALUES ('$imgContent', '$imageType', '$imageName')";

                                if ($conn->query($sql) === TRUE) {
                                    echo "File uploaded successfully.";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                            } else {
                                echo "Error uploading file.";
                            }
                        }

                        $conn->close();
                    ?>
                </div>
                

                <!-- display uploaded images in this container div -->
                <div class="display">
                    <?php
                        include("connect.php");

                        // Handle delete request
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id_council'])) {
                            $delete_id = $_POST['delete_id_council'];
                            $delete_sql = "DELETE FROM img_upload WHERE id = ?";
                            $stmt = $conn->prepare($delete_sql);
                            $stmt->bind_param("i", $delete_id);
                            if ($stmt->execute()) {
                                echo "Image deleted successfully.";
                            } else {
                                echo "Error deleting image: " . $conn->error;
                            }
                            $stmt->close();
                        }
                        
                        // Display images
                        $sql = "SELECT id, image, image_type, image_name FROM img_upload";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo '<div class="gallery">';
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="image">';
                                echo '<img src="data:' . $row['image_type'] . ';base64,' . base64_encode($row['image']) . '" alt="' . $row['image_name'] . '">';
                                // echo '<p>' . $row['image_name'] . '</p>';
                                echo '<form method="POST" onsubmit="return confirm(\'Are you sure you want to delete this image?\');">';
                                echo '<input type="hidden" name="delete_id_council" value="' . $row['id'] . '">';
                                echo '<center><button class="btn btn-primary" type="submit">Delete</button></center>';
                                echo '</form>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo "No images found.";
                        }
                        
                        $conn->close();
                    ?>
                        
                </div>

            </div>

            <div id="pollSystem" class="content-section">
                <h2>Poll System</h2>

                <!-- Add / Update Poll Form -->
                <div id="pollForm">
                    <h3 id="formTitle">Add Poll</h3>
                    <form method="post">
                        <input type="hidden" name="poll_id" id="poll_id">
                        <input type="text" name="question" id="question" placeholder="Poll Title" required>
                        <div id="optionFields">
                            <input type="text" name="options[]" placeholder="Option 1" required>
                            <input type="text" name="options[]" placeholder="Option 2" required>
                        </div>
                        <button type="button" onclick="addOptionField()">+ Add Option</button>
                        <input type="text" name="created_by" id="created_by" placeholder="Created By (username)" required>
                        <button type="submit" name="savePoll">Save Poll</button>
                        <button type="button" onclick="resetForm()">Cancel</button>
                    </form>
                </div>

                <hr/>

                <!-- Display Poll List -->
                <div>
                    <h3>Existing Polls</h3>
                    <?php
                    include("connect.php");

                    // Fetch Polls
                    $polls = $conn->query("SELECT p.id, p.question, u.username, u.role FROM polls p JOIN users u ON p.created_by = u.id");
                    while ($poll = $polls->fetch_assoc()) {
                        $poll_id = $poll['id'];
                        $options = $conn->query("SELECT o.id, o.text, (SELECT COUNT(*) FROM votes v WHERE v.option_id = o.id) AS vote_count FROM options o WHERE o.poll_id = $poll_id");

                        echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
                        echo "<strong>" . htmlspecialchars($poll['question']) . "</strong><br/>";
                        echo "<small>Created by: " . htmlspecialchars($poll['username']) . " (" . htmlspecialchars($poll['role']) . ")</small><ul>";

                        $option_texts = [];
                        $vote_counts = [];
                        while ($opt = $options->fetch_assoc()) {
                            echo "<li>" . htmlspecialchars($opt['text']) . " - " . $opt['vote_count'] . " vote(s)</li>";
                            $option_texts[] = addslashes($opt['text']);
                        }
                        echo "</ul>";

                        echo "<form method='post' style='display:inline;'>
                                <input type='hidden' name='poll_id' value='{$poll_id}'>
                                <button type='submit' name='deletePoll'>Delete</button>
                            </form>";

                        echo "<button onclick=\"editPoll(" . $poll_id . ", '" . addslashes($poll['question']) . "', ['" . implode("','", $option_texts) . "'], '" . addslashes($poll['username']) . "')\">Edit</button>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <!-- ADD IMAGE FOR EVENTS -->
            <div id="eventImg" class="content-section">
                <h2>Add Events</h2>
                    
                <div class="containerWrap">
                    <form class="d-md-flex align-items-center justify-content-between" action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="image" required multiple>
                        <div class="btnHolder d-flex align-items-center justify-content-center">
                            <button class="btn btn-primary" type="submit" name="submit_council">Upload</button>
                        </div>
                        
                    </form>


                    <?php
                        include("connect.php");

                        if (isset($_POST['submit_event'])) {
                            // Check if file was uploaded without errors
                            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                                $image = $_FILES['image']['tmp_name'];
                                $imgContent = addslashes(file_get_contents($image));
                                $imageType = $_FILES['image']['type'];
                                $imageName = $_FILES['image']['name'];

                                // Insert image content into database
                                $sql = "INSERT INTO img_events (image, image_type, image_name) VALUES ('$imgContent', '$imageType', '$imageName')";

                                if ($conn->query($sql) === TRUE) {
                                    echo "File uploaded successfully.";
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                            } else {
                                echo "Error uploading file.";
                            }
                        }

                        $conn->close();
                    ?>
                </div>

                <!-- display uploaded images in this container div -->
                <div class="display">
                    <?php
                        include("connect.php");

                        // Handle delete request
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id_events'])) {
                            $delete_id = $_POST['delete_id_events'];
                            $delete_sql = "DELETE FROM img_events WHERE id = ?";
                            $stmt = $conn->prepare($delete_sql);
                            $stmt->bind_param("i", $delete_id);
                            if ($stmt->execute()) {
                                echo "Image deleted successfully.";
                            } else {
                                echo "Error deleting image: " . $conn->error;
                            }
                            $stmt->close();
                        }

                        // Display images
                        $sql = "SELECT id, image, image_type, image_name FROM img_events";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo '<div class="gallery">';
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="image">';
                                echo '<img src="data:' . $row['image_type'] . ';base64,' . base64_encode($row['image']) . '" alt="' . $row['image_name'] . '">';
                                // echo '<p>' . $row['image_name'] . '</p>';
                                echo '<form method="POST" onsubmit="return confirm(\'Are you sure you want to delete this image?\');">';
                                echo '<input type="hidden" name="delete_id_events" value="' . $row['id'] . '">';
                                echo '<center><button class="btn btn-primary" type="submit">Delete</button></center>';
                                echo '</form>';
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo "No images found.";
                        }

                        $conn->close();
                    ?>
                </div>

            </div>

            <!-- ANNOUNCEMENT-->
            <div id="announcement" class="content-section">
                <h2>Post Announcement</h2>
                
                <form action="" method="post" class="announcementForm">

                    <!-- input title -->
                    <div class="input">
                        <label for="title">Input title:</label>
                        <input type="text" name="title" required>
                    </div>
                    
                    <!-- input text announcement -->
                    <div class="input main">
                        <label for="text">Input announcement:</label>
                        <textarea name="announcetext" id="textAnnouncement" required></textarea>
                    </div>
                    

                    <!-- input date -->
                    <div class="input">
                        <label for="date">Date:</label>
                        <input type="date" name="date" required>
                    </div>
                    
                    <div class="btnUpload mt-3 text-center">
                        <button class="btn btn-primary" type="submit" name="submit_text">Upload</button>
                    </div>

                </form>


                <!-- UPLOAD TEXT IN DATABASE -->
                <?php
                    include("connect.php");

                    if (isset($_POST['submit_text'])) {
                        $title = $_POST['title'];
                        $announcement = $_POST['announcetext'];
                        $date = $_POST['date'];
                    
                        // Sanitize input data
                        $title = mysqli_real_escape_string($conn, $title);
                        $announcement = mysqli_real_escape_string($conn, $announcement);
                        $date = mysqli_real_escape_string($conn, $date);
                    
                        // Check if the title already exists
                        $search = "SELECT title FROM announcement WHERE title = '$title'";
                        $result = mysqli_query($conn, $search);
                        $num = mysqli_num_rows($result);
                    
                        if ($num == 0) {
                            // Insert data into the database
                            $insert = "INSERT INTO announcement (`title`, `text`, `date`) VALUES ('$title', '$announcement', '$date')";
                            if (mysqli_query($conn, $insert)) {
                                echo "<div class='uploadResponse'><h3>Successfully added</h3></div>";
                            } else {
                                echo "<div class='uploadResponse'><h3>Error: " . mysqli_error($conn) . "</h3></div>";
                            }
                        } else {
                            echo "<div class='uploadResponse'><h3>Title of the announcement already exists</h3></div>";
                        }
                    }

                    // DELETE RECORDED ANNOUNCEMENT
                    if(isset($_POST['delete_announcement'])){

                        $delete = "DELETE FROM announcement WHERE id = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $delete)){
                            echo "SQL statement failed";
                            }else{
                                mysqli_stmt_bind_param($stmt, "i", $id);
                                $id = $_POST['delete_announcement'];
                                mysqli_stmt_execute($stmt);
                                echo "<div class = 'uploadResponse'>";
                                echo "<h3>Successfully deleted</h3>";
                                echo "</div>";
                            }
                    }

                    //DISPLAY ANNOUNCEMENTS
                    $search = "SELECT id, title, text, date FROM announcement ORDER BY id DESC";
                    $result = mysqli_query($conn, $search);

                    if ($result->num_rows > 0) {
                        echo "<div class='displayAnnouncement'>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='displayRow'>";
                            echo "<p id='date'>" . $row['date'] . "</p>";
                            echo "<h3 class='text-center'>" . htmlspecialchars($row['title']) . "</h3>";
                            echo "<div class='pre-wrap' style='white-space: pre-wrap;'>" . htmlspecialchars($row['text']) . "</div>";
                            
                            echo '<form method="POST" onsubmit="return confirm(\'Are you sure you want to delete this announcement?\');">';
                            echo '<input type="hidden" name="delete_announcement" value="' . $row['id'] . '">';
                            echo '<center><button type="submit" class="btn btn-danger mt-3 mb-2">Delete</button></center>';
                            echo '</form>';
                            echo "</div>";
                        }
                        echo "</div>";
                    } else {
                        echo "No results found.";
                    }
                    
                    $conn->close();

                

                ?>

            </div>

            <div class="content-section" id="logs">
                <h2>Logs</h2>
                <div id="logList"></div>
            </div>

            
        </div> <!-- closing div of .container -->

    </div> <!-- closing div of .content -->




</div>


<script>// Function to switch sections

        function switchSection(event, sectionId) {
            event.preventDefault();
        
            // Hide all sections
            sections.forEach(section => {
                section.classList.remove("active");
            });
        
            // Show the clicked section
            document.getElementById(sectionId).classList.add("active");
        
            // Highlight the active link
            links.forEach(link => {
                link.classList.remove("active");
            });
            event.target.classList.add("active");
        
            // Fetch data for the section
            fetchSectionData(sectionId);
        }
        
        // Event listeners for navigation links
        links.forEach(link => {
            link.addEventListener("click", function(event) {
                const sectionId = link.id.replace("Link", "");
                switchSection(event, sectionId);
            });
        });
        
        // Fetch data for the selected section
        function fetchSectionData(sectionId) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", `fetch_data.php?section=${sectionId}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    updateSection(sectionId, response);
                }
            };
            xhr.send();
        }

        function addOptionField() {
        const container = document.getElementById('optionFields');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'options[]';
        input.placeholder = 'New Option';
        input.required = true;
        container.appendChild(input);
        }

        function editPoll(id, question, options, username) {
            document.getElementById('poll_id').value = id;
            document.getElementById('question').value = question;
            document.getElementById('created_by').value = username;

            const container = document.getElementById('optionFields');
            container.innerHTML = '';
            options.forEach(opt => {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'options[]';
                input.value = opt;
                input.required = true;
                container.appendChild(input);
            });
        }

            document.getElementById('formTitle').innerText = "Update Poll";

        function resetForm() {
            document.getElementById("poll_id").value = "";
            document.getElementById("question").value = "";
            document.getElementById("created_by").value = "";
            document.getElementById("formTitle").innerText = "Add Poll";
            const optionContainer = document.getElementById("optionFields");
            optionContainer.innerHTML = `
                <input type="text" name="options[]" placeholder="Option 1" required>
                <input type="text" name="options[]" placeholder="Option 2" required>
            `;
        }

</script>

<script src="js/admin.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/logs.js"></script>

<?php

?>

</body>
</html>