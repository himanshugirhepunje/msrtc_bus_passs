<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contactus (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("SQL Error: " . $conn->error);  // Print the actual MySQL error
        }

        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Message sent successfully!');</script>";
        } else {
            echo "<script>alert(''Error: '. $stmt->error');</script>";
        }

        $stmt->close();
    } else {
    
        echo "<script>alert('All fields are required!');</script>";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Pass System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        /* Container */
        .containers {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Form styles */
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-form label {
            font-weight: bold;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .contact-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .contact-form button:hover {
            background-color: #45a049;
        }

        /* Flexbox for larger screens */
        .contact-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .contact-info div {
            flex: 1;
            min-width: 280px;
            margin: 10px;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .contact-info {
                flex-direction: column;
                align-items: center;
            }

            .contact-info div {
                margin-bottom: 15px;
            }

            .container {
                padding: 10px;
            }
        }
    </style>
    
    <style>
        .navbar{
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: url('') no-repeat center center/cover;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            padding: 20px;
           
        }
        .overlay {
            background: rgba(0, 0, 0, 0.6);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        .features, .contact, .about, .services, .testimonials {
            padding: 60px 20px;
        }
        .features h2, .contact h2, .about h2, .services h2, .testimonials h2 {
            margin-bottom: 30px;
            font-weight: bold;
            color: #007bff;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        footer {
            background: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .footer-links a, .social-links a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }
        .footer-links a:hover, .social-links a:hover {
            text-decoration: underline;
        }
        .social-links a {
            font-size: 20px;
        }
        .admin{
            color: aliceblue;
        }
        .admin:hover {
            transform: scale(1.05);
        }
        .logo a:hover{
            color:rgb(35, 233, 35);
        }
        .navbar-brand:hover{
            color:green
        }
        .nav-link:hover{
            color:green
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.html"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="25" fill="currentColor" class="bi bi-bus-front" viewBox="0 0 16 16">
                <path d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0m8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9s3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44 44 0 0 0 8 4m0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44 44 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43 43 0 0 0 8 3"/>
                <path d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A44 44 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2zM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A43 43 0 0 1 8 1"/>
              </svg> Bus Pass System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.html"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
                      </svg> Home</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="#about"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-person" viewBox="0 0 16 16">
                        <path d="M12 1a1 1 0 0 1 1 1v10.755S12 11 8 11s-5 1.755-5 1.755V2a1 1 0 0 1 1-1zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        <path d="M8 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                      </svg> About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
                      </svg> Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="./HTML file/contactus.html"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                      </svg> Contact</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="../HTML file/login.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                      </svg> User Login</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="#">Contact</a></li> -->
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="containers">
        <h1>Contact Us</h1>
        <center>Send your Feedback here</center>

        <!-- Contact Form -->
        <form class="contact-form" method="post" action="contactus.php">
            <label for="name">Your Name</label>
            <input type="text" id="name" placeholder="Enter your name" name="name" required>

            <label for="email">Your Email</label>
            <input type="email" id="email" placeholder="Enter your Email Address" name="email" required>

            <label for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here" required></textarea>

            <button type="submit">Send Message</button>
        </form>

        <div class="contact-info">
            <div>
                <h3>Our Address</h3>
                <p>MSRTC sakoli 441802</p>
            </div>
            <div>
                <h3>Phone</h3>
                <p>(+123) 456-7890</p>
            </div>
            <div>
                <h3>Email</h3>
                <p>MSRTC_SAKOLI@gmail.com</p>
            </div>
        </div>
    </div>
    <br>
    <footer class="logo">


<div class="social-links mt-2">
    <a href="https://www.facebook.com/msrtcofficial"><i class="fab fa-facebook"></i></a>
    <a href="https://x.com/msrtcofficial"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com/msrtc_official"><i class="fab fa-instagram"></i></a>
        </div>
        <br>
        <p>&copy; 2025 Bus Pass System. All Rights Reserved.</p>
       
        
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
