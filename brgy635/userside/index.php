<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="pics/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Barangay 635</title>

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- css files -->
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/login.css">

    <!-- swiperjs link for image carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

</head>
<body>
    
<!-- NAVIGATION BAR -->
    <nav class="px-2 py-3 px-sm-4">
        <div class="navigation d-flex align-items-center justify-content-between">

            <div class="head">
                <img src="pics/logo.png" alt="" srcset="">
            </div>

            <div class="d-none d-lg-flex align-items-center justify-content-center">
                <ul class="p-0 m-0 text-center d-flex align-items-center justify-content-center">
                    <li tabindex="0" class="p-1 m-2 list">
                        <a href="#" id="btnNav">Home</a>
                    </li>

                    <li tabindex="0" class="p-1 m-2 list">
                        <a href="#objectives" id="btnNav">About Us</a>
                    </li>

                    <li tabindex="0" class="p-1 m-2 list">
                        <a href="#footer" id="btnNav">Contact Us</a>
                    </li>

                    <!-- DROPDOWN SERVICES -->
                    <li class="dropdown list dropdown-toggle text-white m-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        Services

                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item">Barangay Business Clearance</a></li>

                            <li><a class="dropdown-item">Certificate of Indigency</a></li>

                            <li><a class="dropdown-item">Barangay Clearance</a></li>

                            <li><a class="dropdown-item">Certificate of Residency</a></li>

                        </ul>

                    </li>
                </ul>
            </div>

            <div class="register d-none d-lg-flex">
                <button type="button" class="btn bg-secondary-subtle" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Register</button>
            </div>

            <!-- NAVIGATION FOR SMALLER SCREENS -->
            <button class="bars d-lg-none btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                <i class="fa fa-bars icon"></i>
            </button>

            <!-- OFFCANVA -->
            <div class="offcanvas offcanvas-start w-50 d-lg-none p-0" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header py-4">
                    <p class="offcanvas-title text-center text-white " id="offcanvasExampleLabel">Barangay 635</p>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> -->
                </div>
                <div class="offcanvas-body p-0">
                    <h3 class="py-3 text-center">Services:</h3>
                    <ul class="offcanva-items text-black p-0 m-0">

                        <li class="mb-2 mx-sm-3 bg-light p-2 rounded"><a class="text-black" href="">Barangay Business Clearance</a></li>

                        <li class="mb-2 mx-sm-3 bg-light p-2 rounded"><a class="text-black" href="">Certificate of Indigency</a></li>

                        <li class="mb-2 mx-sm-3 bg-light p-2 rounded"><a class="text-black" href="">Barangay Clearance</a></li>

                        <li class="mb-2 mx-sm-3 bg-light p-2 rounded"><a class="text-black" href="">Certificate of Residency</a></li>

                    </ul>
                </div>
            </div>

        </div>
    </nav>
    <br><br><br>

    <!-- HOME CONTENT -->
    <div class="home bg-body-secondary text-dark" id="home">
        <div class="home-content">
            <!-- bg image in css (css/index.css => .home-content) -->
            <!-- this message will show in larger screens -->
            <div class="inside text-white d-none d-lg-grid" data-aos="fade-right" data-aos-duration="2000">
                <h1>Barangay 635</h1>
                <p>Pababagong nasimulan, ating ipagpapatuloy! <br>Nagkakaisang barangay tungo sa isang marilag na Maynila</p>
            </div>
        </div>

        <!-- this message will show in smaller screens -->
        <div class="brgytext m-3 d-lg-none" data-aos="fade-right" data-aos-duration="2000">
            <h3 class="py-3">Barangay 635</h3>
            <p>Pababagong nasimulan, ating ipagpapatuloy! Nagkakaisang barangay tungo sa isang marilag na Maynila</p>
        </div>

        <!-- REGISTRATION BUTTON -->
        <div class="registration d-lg-none mt-4 ms-3 pb-5">
            <button class="bg-primary py-2 px-3 shadow-3 text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Registration</button>
        </div>
    </div>


<!-- Modal for sign up -->
    <div class="modal modal-signup fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-secondary-subtle">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Sign Up Here</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form for sign up -->
                    <form action="signup.php" method="post" onsubmit="return validateForm()" id="signup-form">
                        <div class="form">
                            <!-- FORM FOR PERSONAL INFORMATION -->
                            <p>Put N/A if not applicable</p>
                            <h5>Personal Information <sup class="text-danger fs-4">*</sup> </h5>
                            
                            <div class="personal">
                                <div class="input fname">
                                    <label for="fname">First name: </label>
                                    <input type="text" name="fname" id="" required>
                                </div>

                                <div class="input mname">
                                    <label for="mname">Middle name: </label>
                                    <input type="text" name="mname" id="" required>
                                </div>

                                <div class="input lname">
                                    <label for="lname">Last name: </label>
                                    <input type="text" name="lname" id="" required>
                                </div>

                                <div class="input email">
                                    <label for="email">Email: </label>
                                    <input type="text" name="email" id="email" required>
                                </div>

                                <div class="input password">
                                    <label for="password">Password: </label>
                                    <input type="password" id="password" name="password" required>
                                </div>

                                <div class="input confirmpassword">
                                    <label for="confirmpassword">Confirm Password: </label>
                                    <input type="password" id="confirmpassword" name="confirmpassword" required>
                                </div>

                                <div class="input phone">
                                    <label for="phone">Contact number: </label>
                                    <input type="text" id="phone" name="phone" maxlength="11" required>
                                </div>

                                <div class="input date">
                                    <label for="">Date of birth:</label>
                                    <input type="date" name="birthday" id="birthday" placeholder="Birthday" required>
                                </div>


                                <div class="d-flex align-items-center justify-content-evenly">
                                    <div class="status">
                                        <select id="options" name="options" class="p-1 rounded">
                                            <option value="">Marital Status</option>
                                            <option value="option">Married</option>
                                            <option value="option">Single</option>
                                            <option value="option">Widowed</option>
                                        </select>
                                    </div>
                    
                                    <div class="gender">
                                        <input type="radio" name="gender" value="male"> Male
                                        <input type="radio" name="gender" value="female"> Female
                                    </div>
                                </div>
                            </div>

                            <br><br>
                            
                            <!--ADDRESS  -->
                            <h5>Address <sup class="text-danger fs-4">*</sup> </h5>
                            <div class="address">
                                <div class="input">
                                    <label for="hnum">House number: </label>
                                    <input type="text" name="hnum" id="" required>
                                </div>

                                <div class="input">
                                    <label for="street">Street: </label>
                                    <input type="text" name="street" id="" required>
                                </div>

                                <div class="input">
                                    <label for="others">Other information: </label>
                                    <input type="text" name="others" id="">
                                </div> 

                            </div>
                            
                            <!-- <center><button type="submit" class="mt-4 mb-2 bg-primary">Submit</button></center> -->
                            <center><button class="bg-primary" id="submit" type="submit" onclick="validateAndSubmit()">Submit</button></center>

                        </div>
                    </form>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Login</button>
                        <!-- <button type="submit" name="submit" class="btn btn-primary" onclick="validateAndSubmit()">Submit</button> -->
                    </div>
            </div>
        </div>
    </div>


    <!-- ------------------------------------------------- -->
    <!-- modal for login -->
    <div class="modal modal-signup fade" id="exampleModalToggle2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-secondary-subtle">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Log In Here</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form for login -->
                    <form action="login.php" method="post" id="login-form">
                        <div class="form-login">
                            <div class="input email">
                                <label for="email">Email: </label>
                                <input type="text" name="email" id="email" required>
                            </div>
                            <div class="input password">
                                <label for="password">Password: </label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <center><button class="bg-primary" id="submit" type="submit">Submit</button></center>
                        </div>
                    </form>
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" data-bs-target="#staticBackdrop" data-bs-toggle="modal">Sign Up</button>
                        <!-- <button type="submit" name="submit" class="btn btn-primary" onclick="validateAndSubmit()">Submit</button> -->
                    </div>
            </div>
        </div>
    </div>
    


    
    <br> 
    <!-- MISSION AND VISION OF BARANGAY -->
    <!-- this will be hidden if the screen is 768px above -->
    <div class="brgyObj border py-3 mx-3 rounded-3 d-md-none" data-aos="fade-up" data-aos-duration="2000">
        <div class="section mx-4 rounded" id="abtUs">
            <div class="btn-group shadow rounded-4 p-1 mx-sm-5 d-flex align-items-center justify-content-between bg-secondary-subtle">
                <button id="btnmission" class="btn bg-primary text-white rounded-4">
                    Mission
                </button>
                <button id="btnvision" class="btn rounded-4">
                    Vision
                </button>
            </div>
            
            <div class="content px-3 py-2 px-sm-4 py-sm-3 bg-light rounded shadow mt-2 mx-sm-5">
                <div id="mission">
                Provide the legal foundation and governance policies, forge vital partnerships advantageous to the city, and harness urban assets for green, resilient, equitable, smart, and sustainable development, with its capable and committed public servants, working together, in providing quality and proactive legislation and corruption-free services for the general welfare of the people and the progress of this magnificent, premier city.
                </div>

                <div id="vision" class="collapse">
                To become the magnificent and world-class capital city of the country, with its rich history and distinct character, diverse hubs of knowledge and creativity and centers for social, cultural, educational commerce and trade, linking the nation to the world, inspiring the hopes of its people and putting God first, at all times.
                </div>
            </div>
        </div>
    </div>

    <!-- initially hidden then show up when the screen is 768px above -->
    <div class="objectives d-none d-md-flex align-items-center justify-content-center px-5 my-3" id="objectives">
        <div class="obj mission shadow" data-aos="fade-up" data-aos-duration="2000">
            <h2 class="text-center">Mission</h2>
            <p>Provide the legal foundation and governance policies, forge vital partnerships advantageous to the city, and harness urban assets for green, resilient, equitable, smart, and sustainable development, with its capable and committed public servants, working together, in providing quality and proactive legislation and corruption-free services for the general welfare of the people and the progress of this magnificent, premier city.</p>
        </div>

        <div class="obj vision shadow" data-aos="fade-up" data-aos-duration="3000">
            <h2 class="text-center">Vision</h2>
            <p>To become the magnificent and world-class capital city of the country, with its rich history and distinct character, diverse hubs of knowledge and creativity and centers for social, cultural, educational commerce and trade, linking the nation to the world, inspiring the hopes of its people and putting God first, at all times.</p>
        </div>
    </div>


    <!-- COUNCILORS -->
    <div class="text-center mt-5" data-aos="fade-right" data-aos-duration="2000">
            <p id="councilText">Meet Our Councils<br>Brgy. 635</p>
        </div>
    <div class="councilor swiper" data-aos="fade-right" data-aos-duration="2000">

        <div class="slider-wrapper">
            <div class="card-list swiper-wrapper pb-4">

                <?php
                    include("connect.php");

                    $sql = "SELECT id, image, image_type, image_name FROM img_upload";
                    $result = $conn->query($sql);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo "<div class='card-item swiper-slide'>";
                            // echo "<a href='#' class='card-link'>";
                                echo ' <img src="data:' . $row['image_type'] . ';base64,' . base64_encode($row['image']) . '" alt="' . htmlspecialchars($row['image_name']) . '">';
                            // echo "</a>";
                            echo "</div>";
                        }

                    }
                ?>
            </div>

            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>
    </div>
    

    <div class="holder d-block d-md-flex">

        <!-- BARANGAY EVENTS -->
        <div class="events" data-aos="fade-right" data-aos-duration="2000">

            <div class="text">
                <p class="bg-danger py-2 px-3 rounded-end">Barangay 635 Events &nbsp; <i class="bi bi-calendar2"></i></p>
            </div>

            <div class="events-page mx-2">
                <!-- <div class="inside"> -->

                <?php
                include("connect.php");

                    // Display images
                    $sql = "SELECT id, image, image_type, image_name FROM img_events";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<div class="gallery mx-2 py-1">';
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="image">';
                            echo '<img src="data:' . $row['image_type'] . ';base64,' . base64_encode($row['image']) . '" alt="' . $row['image_name'] . '">';
                            echo '</div>';
                        }
                        echo '</div>';
                    } else {
                        echo "No images found.";
                    }

                    $conn->close();
                ?>
                <!-- </div> -->
            </div>
        </div>

        <!-- ANNOUNCEMENT -->
        <div class="announcement rounded-4 bg-secondary-subtle" data-aos="fade-left" data-aos-duration="2000">
            <div class="textAnnouncement">
                <p class="px-4 py-2 bg-primary rounded-end">Announcement &nbsp;<i class="bi bi-megaphone"></i></p>
            </div>

            <?php
                include("connect.php");

                $search = "SELECT id, title, text, date FROM announcement ORDER BY id ASC";
                $result = $conn->query($search);

                if($result->num_rows > 0){
                    echo '<div class="accordion accordion-flush m-1 py-2 px-3" id="accordionExample">';             
                    while($row = $result->fetch_assoc()){
                        echo '<div class="accordion-item">';
                            echo '<h2 class="accordion-header border">';
                                echo '<button class="accordion-button collapsed p-2 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $row['id'] . '" aria-expanded="false" aria-controls="collapse' . $row['id'] . '">';
                                    echo htmlspecialchars($row['title']);
                                echo '</button>';
                            echo '</h2>';

                            echo '<div id="collapse' . $row['id'] . '" class="accordion-collapse collapse" data-bs-parent="#accordionExample">';
                                echo '<div class="accordion-body mx-1">';
                                    echo '<div class="date text-end fw-bold">' . ($row['date']) . '</div>';
                                    echo "<div class='pre-wrap' style='white-space: pre-wrap;'>" . htmlspecialchars($row['text']) . "</div>";
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                echo '</div>';
            }
            ?>
        </div>

    </div>
        

    <!-- ------------- -->
    <!-- FOOTER -->
    <footer class="p-2" id="footer">
        <div class="footer d-flex align-items-center justify-content-between">
            <div class="botlogo mx-1">
                <img src="pics/logo.png" alt="">
            </div>

            <div class="bottomPage d-flex align-items-center justify-content-center">

                <div class="morePages">
                    <table>
                        <thead>
                            <tr>
                                <th>More</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td><a href="#home">Home</a></td>
                            </tr>
                            <tr>
                                <td><a href="#abtUs">About Us</a></td>
                            </tr>
                            <tr>
                                <td><a href="#councils">Councils</a></td>
                            </tr>
                            <tr>
                                <td><a href="#offcanvasExample">Services</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="contactUs">
                    <table>
                        <thead>
                            <tr>
                                <th>Contact Us</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>02 7005 5492</td>
                            </tr>
                            <tr>
                                <td>311 Ruiloba St., Manila, Philippines, 1016</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </footer>


<script>

// MISSION AND VISION TRANSITION
    const btnmission = document.getElementById('btnmission');
    const btnvision = document.getElementById('btnvision');

    btnmission.addEventListener('click', () => {
        setTimeout(() => {
            document.getElementById('mission').classList.remove('collapse');
            document.getElementById('vision').classList.add('collapse');
        }, 200);
        btnmission.classList.add('bg-primary', 'text-white');
        // btnmission.classList.add('text-white');
        btnvision.classList.remove('bg-primary', 'text-white');
    });

    
    btnvision.addEventListener('click', () => {
        setTimeout(() => {
            document.getElementById('mission').classList.add('collapse');
            document.getElementById('vision').classList.remove('collapse');
        }, 200);
        
        btnmission.classList.remove('bg-primary', 'text-white');
        btnvision.classList.add('bg-primary', 'text-white');
        // btnvision.classList.add('text-white');
    });


    function validateForm() {
        // Get the phone number and email input values
        var phone = document.getElementById("phone").value;
        var email = document.getElementById("email").value;

        // Regular expression for validating phone number (must be 11 digits and start with 09)
        var phoneRegex = /^09\d{9}$/;
        // Regular expression for validating email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Phone number validation
        if (!phoneRegex.test(phone)) {
            alert("Invalid phone number. It must be 11 digits and start with '09'.");
            return false; // Prevent form submission
        }

        // Email validation
        if (!emailRegex.test(email)) {
            alert("Invalid email address. Please enter a valid email.");
            return false; // Prevent form submission
        }

        // check if password matches confirm password
        const password = document.querySelector("#password").value;
        const confirmpassword = document.querySelector("#confirmpassword").value;

        if(password === confirmpassword){
            return true;
        }else{
            alert("password do not match");
            return false
        }

        // If all validations pass, return true to allow form submission
        return true;
    }

    function validateAndSubmit() {
        // Check if the form is valid
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    }

</script>





    <!-- SCRIPT PACKAGES -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
    <script src="js/navbar.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
    AOS.init();
    </script>


    <!-- script package for swiperjs -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/swiperjs.js"></script>

</body>
</html>