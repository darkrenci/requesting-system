<?php
session_start();
include 'connect.php';


$query = "
    SELECT p.id as poll_id, p.question 
    FROM polls p 
    JOIN users u ON p.created_by = u.id 
    ORDER BY p.id DESC
";

$polls = $conn->query("
    SELECT p.id as poll_id, p.question 
    FROM polls p
    ORDER BY p.id DESC
");

function getRequestedDocsCount($conn, $user_id) {
    $query = "
    SELECT COUNT(*) as count 
    FROM (
        SELECT id FROM barangay_clearance WHERE resident_id = ? 
        UNION ALL 
        SELECT id FROM business_clearance WHERE resident_id = ? 
        UNION ALL 
        SELECT id FROM certificate_of_indigency WHERE resident_id = ? 
        UNION ALL 
        SELECT id FROM certificate_of_residency WHERE resident_id = ?
    ) as all_requests";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

function getTotalRequestsCount($conn, $user_id) {
    return getRequestedDocsCount($conn, $user_id);
}

function getPendingDocsCount($conn, $user_id) {
    $query = "
    SELECT COUNT(*) as count 
    FROM (
        SELECT id FROM barangay_clearance WHERE resident_id = ? AND `Queue Status` = 'Pending' 
        UNION ALL 
        SELECT id FROM business_clearance WHERE resident_id = ? AND `Queue Status` = 'Pending' 
        UNION ALL 
        SELECT id FROM certificate_of_indigency WHERE resident_id = ? AND `Queue Status` = 'Pending' 
        UNION ALL 
        SELECT id FROM certificate_of_residency WHERE resident_id = ? AND `Queue Status` = 'Pending'
    ) as pending_requests";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT fname, lname, mname, email, phone, birthday, marital_status, gender, citizen, hnum, street, others FROM resident WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="icon" href="pics/logo.png">
    <link rel="stylesheet" href="css/user-interface2.css">
    <link rel="stylesheet" href="css/user-interface-responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>


<body>

      
      <div class="holder">
            
        <nav class="sidenav">

          <div class="list">
              <ul>
                <li><a href="#" id="dashboard-link" class="active"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                <li><a href="#profile-section" onclick="scrollToProfile(event)"><i class="fas fa-user"></i>Profile</a></li>
                <li><a href="#request-document" onclick="scrollToRequestDocument(event)"><i class="fas fa-file-alt"></i>Request Document</a></li>
                <li><a href="#voting-poll" onclick="scrollToRequestDocument(event)"><i class="fas fa-square-poll-horizontal"></i>Voting Poll</a></li>
              </ul>
          </div>    
          
          <div class="logout">
              <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
          </div>
        </nav>


        <!-- NAVIGATION BAR FOR SMALLER SCREENS -->
        <nav class="sidenav2">

          <div class="list">
          <i class="fa fa-xmark icon2"></i>
              <ul>
                <li>
                  <span><i class="fas fa-tachometer-alt"></i></span>
                  <span><a href="#" id="dashboard-link" class="active">Dashboard</a></li></span>
                <li>
                  <span><i class="fas fa-user"></i></span>
                  <span><a href="#profile-section" onclick="scrollToProfile(event)">Profile</a></li></span>        
                <li>
                  <span><i class="fas fa-file-alt"></i></span>
                  <span><a href="#request-document" onclick="scrollToRequestDocument(event)">Request Document</a></li></span>  
                
              </ul>
          </div>
          
          <div class="logout">
              <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
          </div>
        </nav>


        

        <div class="sub-main-content">

            <main class="main-content" id="dashboard-section">
              
            <i class="fa fa-bars icon"></i>

                <div class="hr"><hr></div>
                
                <div class="ints">
                  
                  <h1>Barangay 635</h1>
                </div>
                
                

                <div class="admin-content">
                  <h1>Welcome <?php echo htmlspecialchars($user['email']); ?> to your dashboard</h1>
                    <!-- <img src="pics/user.png" alt=""> -->
                </div>
            
              <div class="dashboard-widgets">
                <div class="widget">

                  <div class="widget-holder">

                      <i class="fas fa-folder"></i>

                      <div class="widget-text">
                        <h2>Your Requested Documents (<?php echo getRequestedDocsCount($conn, $_SESSION['user_id']); ?>)</h2>
                      </div>

                  </div>
                </div>

                <div class="widget">

                  <div class="widget-holder">
                      <i class="fas fa-file-alt"></i>

                      <div class="widget-text">
                        <h2>Number of Documents Requested (<?php echo getTotalRequestsCount($conn, $_SESSION['user_id']); ?>)</h2>
                      </div>
                  </div>
                </div>

                <div class="widget">
                  <div class="widget-holder">
                      <i class="fas fa-exclamation-circle"></i>
                      <div class="widget-text">
                        <h2>Pending Documents (<?php echo getPendingDocsCount($conn, $_SESSION['user_id']); ?>)</h2>
                      </div>
                  </div>
                </div>

              </div>


            </main>

                  
            <div class="dashboard-logs">
    <h2>Document Request Logs</h2>
    <table>
        <tr>
            <th>Document Type</th>
            <th>Requested By</th>
            <th>Processed By</th>
            <th>Status</th>
            <th>Submitted At</th>
            <!-- <th>Remarks</th> Added column for Remarks -->
        </tr>
        <?php
        $user_id = $_SESSION['user_id'];

        // Updated SQL query to include remarks
        $sql = "SELECT 'barangay_clearance' as type, bc.id, bc.req_name, bc.postal_address, bc.`Queue status`, r.fname, r.lname, bc.submitted_at
                FROM barangay_clearance bc
                INNER JOIN resident r ON bc.resident_id = r.id
                WHERE r.id = ? 
                UNION ALL
                SELECT 'business_clearance' as type, bp.id, bp.business_name, bp.business_address, bp.`Queue status`, r.fname, r.lname, bp.submitted_at
                FROM business_clearance bp
                INNER JOIN resident r ON bp.resident_id = r.id
                WHERE r.id = ? 
                UNION ALL
                SELECT 'certificate_of_indigency' as type, coi.id, coi.req_name_indigency, coi.postal_address_indigency, coi.`Queue status`, r.fname, r.lname, coi.submitted_at
                FROM certificate_of_indigency coi
                INNER JOIN resident r ON coi.resident_id = r.id
                WHERE r.id = ? 
                UNION ALL
                SELECT 'certificate_of_residency' as type, cor.id, cor.req_name_residency, cor.postal_address_residency, cor.`Queue status`, r.fname, r.lname, cor.submitted_at
                FROM certificate_of_residency cor
                INNER JOIN resident r ON cor.resident_id = r.id
                WHERE r.id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?= htmlspecialchars($row['type'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['req_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['fname'] . ' ' . $row['lname'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($row['Queue status'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= date("M d, Y h:i A", strtotime($row['submitted_at'])); ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>


              <section class="profile-section" id="profile-section">
                <h2>User Profile</h2>
                <form action="update_profile.php" method="POST">
    <div class="profile-info">
        <!-- Personal Info -->
        <div class="personal-info">
            <h3>Personal Information</h3>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">First Name:</span>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($user['fname']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Middle Name:</span>
                    <input type="text" name="mname" value="<?php echo htmlspecialchars($user['mname']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Last Name:</span>
                    <input type="text" name="lname" value="<?php echo htmlspecialchars($user['lname']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Birthdate:</span>
                    <input type="date" name="birthday" value="<?php echo htmlspecialchars($user['birthday']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Gender:</span>
                    <input type="text" name="gender" value="<?php echo htmlspecialchars($user['gender']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Citizenship:</span>
                    <input type="text" name="citizen" value="<?php echo htmlspecialchars($user['citizen']); ?>" class="info-value">
                </div>
            </div>
        </div>

        <!-- Address Info -->
        <div class="address-info">
            <h3>Address</h3>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">House No.:</span>
                    <input type="text" name="hnum" value="<?php echo htmlspecialchars($user['hnum']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Street:</span>
                    <input type="text" name="street" value="<?php echo htmlspecialchars($user['street']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Others:</span>
                    <input type="text" name="others" value="<?php echo htmlspecialchars($user['others']); ?>" class="info-value">
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
            <h3>Contact Information</h3>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Email Address:</span>
                    <input type="email" class="emailAdd" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="info-value">
                </div>
            </div>
            <div class="info-container">
                <div class="info-item">
                    <span class="info-label">Contact Number:</span>
                    <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" class="info-value">
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="change-password">
            <h3>Change Password</h3>
            <div class="change-password-container">
                <div class="change-password-item info-container">
                    <label class="change-password-label" for="current-password">Current Password:</label>
                    <input class="change-password-input" type="password" id="current-password" name="current-password">
                </div>

                <div class="change-password-item info-container">
                    <label class="change-password-label" for="new-password">New Password:</label>
                    <input class="change-password-input" type="password" id="new-password" name="new-password">
                </div>

                <div class="change-password-item info-container">
                    <label class="change-password-label" for="confirm-new-password">Confirm New Password:</label>
                    <input class="change-password-input" type="password" id="confirm-new-password" name="confirm-new-password">
                </div>
            </div>
        </div>

        <div class="info-container">
            <button class="submit" type="submit">Save Changes</button>
        </div>
    </div>
</form>

              </section>


              <section id="request-document">
                <div class="req-docs">

                    <h3>Request Document</h3>
                    <div class="doc-type">
                        <div class="doc1 docs" onclick="showForm('barangay')">Barangay Clearance</div>
                        <div class="doc3 docs" onclick="showForm('indigency')">Certificate of Indigency</div>
                        <div class="doc4 docs" onclick="showForm('residency')">Certificate of Residency</div>
                    </div>

                    <?php
// Assuming $user array contains the logged-in user's details
$full_name = htmlspecialchars($user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname']);
$postal_address = htmlspecialchars($user['hnum']. ' ' . $user['street']. ' '. $user['others']);
$marital_status = htmlspecialchars($user['marital_status']);
$citizen = htmlspecialchars($user['citizen']);
?>

<form action="document.php" method="post" class="doc-form" id="barangay-form" style="display:none;">
    <!-- Barangay Clearance Form Fields -->
    <div class="brgyClearance-form">
        <label for="req-name">Requestor's Name:</label>
        <input type="text" id="req-name" name="req-name" value="<?php echo $full_name; ?>" readonly required>
    </div>
    <div class="brgyClearance-form">
        <label for="postal-address">Postal Address:</label>
        <input type="text" id="postal-address" name="postal-address" value="<?php echo $postal_address; ?>" readonly required>
    </div>
    <div class="brgyClearance-form">
        <label for="marital-status">Marital Status:</label>
        <input type="text" id="marital-status" name="marital-status" value="<?php echo $marital_status; ?>" readonly required>
    </div>
    <div class="brgyClearance-form">
        <label for="citizenship">Citizenship:</label>
        <input type="text" id="citizenship" name="citizenship" value ="<?php echo $citizen; ?>" readonly required>
    </div>
    <div class="brgyClearance-form">
        <label for="purpose">Purpose:</label>
        <input type="text" id="purpose" name="purpose" required>
    </div>
    <div class="brgyClearance-form">
        <input type="hidden" name="form_id" value="barangay-form">
        <button type="submit">Submit</button>
    </div>
</form>

<form action="document.php" method="post" class="doc-form" id="business-form" style="display:none;">
<form action="document.php" method="post" class="doc-form" id="business-form" style="display:none;">
                    <!-- Business Clearance Form Fields -->
                    <!-- Business Entity Information -->

                    <div class="businessClearance-form">
                      <label for="business-name">Name of Business:</label>
                      <input type="text" id="business-name" name="business-name" required>
                    </div>

                    <div class="businessClearance-form">
                      <label for="business-address">Business Address:</label>
                      <input type="text" id="business-address" name="business-address" required>
                    </div>

                    <div class="businessClearance-form">
                      <label for="nature-business">Nature of Business:</label>
                      <input type="text" id="nature-business" name="nature-business" required>
                    </div>

                    <!-- Proprietor(s) Information -->
                    <div class="businessClearance-form">
                      <label for="proprietor">Proprietor(s):</label>
                      <input type="text" id="proprietor" name="proprietor" required>
                    </div>

                    <div class="businessClearance-form">
                      <label for="contact-number">Contact Number:</label>
                      <input type="text" id="contact-number" name="contact-number" required>
                    </div>
                    
                    <div class="businessClearance-form">
                      <label for="ownership-type">Ownership Type:</label>
                      <input type="text" id="ownership-type" name="ownership-type" required>
                    </div>

                    <div class="businessClearance-form">
                      <input type="hidden" name="form_id" value="business-form">
                      <button type="submit">Submit</button>
                    </div>
                    
                </form>
    <!-- No changes needed here as per instructions -->
</form>

                        
<form action="document.php" method="post" class="doc-form" id="indigency-form" style="display:none;">
    <!-- Certificate of Indigency Form Fields -->
    <div class="certOfIndigency-form">
        <label for="req-name-indigency">Requestor:</label>
        <input type="text" id="req-name-indigency" name="req-name-indigency" value="<?php echo $full_name; ?>" readonly required>
    </div>
    <div class="certOfIndigency-form">
        <label for="postal-address-indigency">Postal Address:</label>
        <input type="text" id="postal-address-indigency" name="postal-address-indigency" value="<?php echo $postal_address; ?>" readonly required>
    </div>
    <div class="certOfIndigency-form">
        <label for="purpose-indigency">Purpose:</label>
        <input type="text" id="purpose-indigency" name="purpose-indigency" required>
    </div>
    <div class="certOfIndigency-form">
        <input type="hidden" name="form_id" value="indigency-form">
        <button type="submit">Submit</button>
    </div>
</form>

<form action="document.php" method="post" class="doc-form" id="residency-form" style="display:none;">
    <!-- Certificate of Residency Form Fields -->
    <div class="certOfResidency-form">
        <label for="req-name-residency">Requestor's Name:</label>
        <input type="text" id="req-name-residency" name="req-name-residency" value="<?php echo $full_name; ?>" readonly required>
    </div>
    <div class="certOfResidency-form">
        <label for="postal-address-residency">Postal Address:</label>
        <input type="text" id="postal-address-residency" name="postal-address-residency" value= "<?php echo $postal_address; ?>" readonly required>
    </div>
    <div class="certOfResidency-form">
        <label for="purpose-residency">Purpose:</label>
        <input type="text" id="purpose-residency" name="purpose-residency" required>
    </div>
    <div class="certOfResidency-form">
        <input type="hidden" name="form_id" value="residency-form">
        <button type="submit">Submit</button>
    </div>
</form>


   <section id="voting-poll">
                <div class="voting">
                    <h3>Voting Polls</h3>

                    <?php while ($poll = $polls->fetch_assoc()): ?>
                    <?php
                        $poll_id = $poll['poll_id'];
                        $checkVote = $conn->query("
                            SELECT v.id FROM votes v 
                            JOIN options o ON v.option_id = o.id 
                            WHERE v.user_id = $user_id AND o.poll_id = $poll_id
                        ");
                        $hasVoted = $checkVote->num_rows > 0;
                    ?>

                    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
                        <strong><?= htmlspecialchars($poll['question']) ?></strong>

                        <?php if ($hasVoted): ?>
                            <p style="color: green;">You already voted in this poll.</p>
                        <?php else: ?>
                            <form method="post" action="vote.php">
                                <?php
                                $options = $conn->query("SELECT id, text FROM options WHERE poll_id = $poll_id");
                                while ($opt = $options->fetch_assoc()):
                                ?>
                                    <div>
                                        <input type="radio" name="option_id" value="<?= $opt['id'] ?>" required>
                                        <?= htmlspecialchars($opt['text']) ?>
                                    </div>
                                <?php endwhile; ?>
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <button type="submit">Vote</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
                </div>

              </div>

            </div>

    

          </section>
        <!-- closing div for sub-main-content -->
        </div>
    

  <!-- closing div for holder -->
  </div>
    
    
    


  

  
  

<script>
  function scrollToProfile(event) {
    event.preventDefault();
    const profileSection = document.getElementById("profile-section");
    profileSection.classList.add("scroll-animation");
    profileSection.scrollIntoView({ behavior: "smooth" });
    setTimeout(() => profileSection.classList.remove("scroll-animation"), 300);
  }

  function scrollToDashboard(event) {
    event.preventDefault();
    const dashboardSection = document.getElementById("dashboard-section");
    dashboardSection.classList.add("scroll-animation");
    dashboardSection.scrollIntoView({ behavior: "smooth" });
    setTimeout(() => dashboardSection.classList.remove("scroll-animation"), 300);
  }

  function scrollToRequestDocument(event) {
    event.preventDefault();
    const requestDocumentSection = document.getElementById("request-document");
    requestDocumentSection.classList.add("scroll-animation");
    requestDocumentSection.scrollIntoView({ behavior: "smooth" });
    setTimeout(() => requestDocumentSection.classList.remove("scroll-animation"), 300);
  }

  document.getElementById("dashboard-link").addEventListener("click", scrollToDashboard);

  function showForm(docType) {
    const forms = document.querySelectorAll('.doc-form');
    forms.forEach(form => {
      form.style.display = 'none';
    });

    const selectedForm = document.getElementById(`${docType}-form`);
    if (selectedForm) {
      selectedForm.style.display = 'block';
    }

    // Change color of clicked element
    const docTypes = document.querySelectorAll('.doc-type div');
    docTypes.forEach(doc => {
      doc.classList.remove('selected'); // Remove selected class from all elements
    });
    const selectedDoc = document.querySelector(`.${docType}`);
    selectedDoc.classList.add('selected'); // Add selected class to the clicked element
  }

  function scrollToProfile(event) {
  event.preventDefault();
  const profileSection = document.getElementById("profile-section");
  profileSection.classList.add("scroll-animation");
  profileSection.style.display = "block"; // Show the profile section
  profileSection.scrollIntoView({ behavior: "smooth" });
  setTimeout(() => profileSection.classList.remove("scroll-animation"), 300);
}

function scrollToRequestDocument(event) {
  event.preventDefault();
  const requestDocumentSection = document.getElementById("request-document");
  requestDocumentSection.classList.add("scroll-animation");
  requestDocumentSection.style.display = "block"; // Show the request document section
  requestDocumentSection.scrollIntoView({ behavior: "smooth" });
  setTimeout(() => requestDocumentSection.classList.remove("scroll-animation"), 300);
}

</script>
<script>
function changePassword() {
    var currentPassword = document.getElementById('current-password').value;
    var newPassword = document.getElementById('new-password').value;
    var confirmNewPassword = document.getElementById('confirm-new-password').value;

    if (newPassword !== confirmNewPassword) {
        alert('New password and confirm password do not match.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'change_password.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert(xhr.responseText);
        } else {
            alert('An error occurred while changing the password.');
        }
    };
    xhr.send('current-password=' + encodeURIComponent(currentPassword) + '&new-password=' + encodeURIComponent(newPassword));
}
</script>

<script src="js/user-interface-nav.js"></script>
</body>
</html>