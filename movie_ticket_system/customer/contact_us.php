<?php
include('header.php'); // Include your header
include('../config/db.php'); // Include your database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Contact Us</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="js/script.js"></script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('img/bacc.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: white;
        }

        /* Contact Us Container */
        .contact-us-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            padding: 50px;
            gap: 20px;
        }

        /* Contact Section */
        .contact-us-section {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            flex: 1;
        }

        /* Section Titles */
        .contact-us-section h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 10px;
        }

        .contact-us-section h3 {
            color: #ccc;
        }

        /* Input Fields */
        .contact-us-section input,
        .contact-us-section textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Submit Button */
        .contact-us-section button {
            width: 100%;
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .contact-us-section button:hover {
            background-color: #0056b3;
        }

        /* Address & Info Section */
        .contact-us-section2 a {
            color: #007BFF;
            text-decoration: none;
        }

        .contact-us-section2 a:hover {
            text-decoration: underline;
        }

        /* Google Map */
        .gmap_canvas iframe {
            width: 100%;
            height: 100%;
            border-radius: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .contact-us-container {
                flex-direction: column;
                align-items: center;
            }

            .contact-us-section {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="contact-us-container">
        <div class="contact-us-section contact-us-section1">
            <h1>Contact</h1>
            <p>Feel Free to Contact Us</p>
            <form action="" method="POST" id="contactForm" onsubmit="return confirmSubmit();">
                <input type="text" placeholder="First Name" name="fName" required><br>
                <input placeholder="Last Name" name="lName"><br>
                <input type="email" placeholder="E-mail Address" name="eMail" required><br>
                <textarea placeholder="Enter your message!" name="feedback" rows="10" cols="30" required></textarea><br>
                <button type="submit" name="submit" value="submit">Send your Message</button>
                <?php
                if (isset($_POST['submit'])) {
                    // Get email from form
                    $email = $_POST['eMail'];

                    // Check if email is valid
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo "<p class='error'>Invalid email format. Please enter a valid email.</p>";
                    } else {
                        // Prepare and execute the SQL query
                        $insert_query = "INSERT INTO feedback (CustomerID, FeedbackDescription) 
                                         VALUES (NULL, '" . $_POST["feedback"] . "')";
                        
                        $insert_result = mysqli_query($conn, $insert_query);

                        if ($insert_result) {
                            echo "<script>alert('Submitted successfully!');</script>";
                        } else {
                            echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
                        }
                    }
                }
                ?>
            </form>
        </div>
        <div class="contact-us-section contact-us-section2">
            <h1>Address & Info</h1>
            <h3>Phone Numbers</h3>
            <p><a href="tel:01011391148">+2 010 11 39 11 48</a><br>
               <a href="tel:01011391148">+2 010 11 39 11 48</a></p>
            <h3>Address</h3>
            <p>Amhara, Debirebirehan, Hiywot Cinema</p>
            <h3>E-mail</h3>
            <p><a href="mailto:hiywotcinema@gmail.com">hiywotcinema@gmail.com</a></p>
        </div>
    </div>
    <div style="width: 75%; height: 350px; margin: 15%;">
        <div class="gmap_canvas"><iframe id="gmap_canvas" src="https://maps.google.com/maps?q=BUE&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
    </div>
    <?php include('../footer.php'); // Include your footer ?>
    <script src="scripts/jquery-3.3.1.min.js"></script>
    <script src="scripts/owl.carousel.min.js"></script>
    <script src="scripts/script.js"></script>
    <script>
        // Function to show a confirmation before submitting the form
        function validateEmail(email) {
            var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return re.test(String(email).toLowerCase());
        }

        function confirmSubmit() {
            var email = document.forms["contactForm"]["eMail"].value;
            if (!validateEmail(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            var isConfirmed = confirm("Are you sure you want to submit your message?");
            if (isConfirmed) {
                alert("Your message has been submitted successfully.");
            }
            return isConfirmed;
        }
    </script>
</body>
</html>
