<?php
// Include the database configuration file
include 'config.php';

// Start the session
session_start();

// Check if the user is logged in
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

// Handle form submission
if (isset($_POST['send'])) {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    // Debugging: Ensure all form fields are captured
    if (!$name || !$email || !$number || !$msg) {
        die('Error: Missing form data.');
    }

    // Check if the message already exists
    $select_message_query = "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'";
    $select_message = mysqli_query($conn, $select_message_query) or die('Select Query Failed: ' . mysqli_error($conn));

    if (mysqli_num_rows($select_message) > 0) {
        $message[] = 'Message already sent!';
    } else {
        // Insert the new message into the database
        $insert_query = "INSERT INTO `message` (user_id, name, email, number, message) VALUES ('$user_id', '$name', '$email', '$number', '$msg')";
        if (mysqli_query($conn, $insert_query)) {
            $message[] = 'Message sent successfully!';
        } else {
            die('Insert Query Failed: ' . mysqli_error($conn));
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .contact-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .contact-container h1 {
            margin-bottom: 20px;
            color: #0056b3;
        }

        .contact-container p {
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.6;
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group label {
            font-size: 0.9rem;
            font-weight: bold;
            text-align: left;
            display: block;
            margin-bottom: 8px;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .form-group input:focus, .form-group textarea:focus {
            border-color: #0056b3;
            outline: none;
        }

        .submit-btn {
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #003d80;
        }

        @media (max-width: 768px) {
            .contact-container {
                padding: 15px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>We’d love to hear from you! Please fill out the form below or use the provided contact information.</p>

        <form id="contactForm" class="contact-form" method="POST">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="number">Your Number</label>
                <input type="number" id="number" name="number" placeholder="Enter your number" required>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Write your message here" required></textarea>
            </div>
            <button type="submit" class="submit-btn" name="send">Send Message</button>
        </form>

        <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo "<p style='color: green;'>$msg</p>";
            }
        }
        ?>
    </div>
</body>
</html>
