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
    <link rel="stylesheet" href="css/contract.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error { color: red; font-size: 14px; display: block; margin-top: 5px; }
    </style>
</head>
<body>
    
    <?php include 'header.php'; ?>

    <div class="contact-container">
        <h1>Contact Us</h1>
        <p>We’d love to hear from you! Please fill out the form below or use the provided contact information.</p>

        <form id="contactForm" class="contact-form" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" onblur="validateName()" required>
                <span class="error" id="nameError"></span>
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" onblur="validateEmail()" required>
                <span class="error" id="emailError"></span>
            </div>
            <div class="form-group">
                <label for="number">Your Number</label>
                <input type="number" id="number" name="number" placeholder="Enter your number" onblur="validateNumber()" required>
                <span class="error" id="numberError"></span>
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Write your message here" onblur="validateMessage()" required></textarea>
                <span class="error" id="messageError"></span>
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

    <script>
       
    function validateName() {
        let name = document.getElementById('name').value.trim();
        let error = document.getElementById('nameError');
        // Check if name is at least 4 alphabetic characters
        if (!/^[A-Za-z]{4,}$/.test(name)) {
            error.textContent = 'Name must be at least 4 alphabetic characters.';
            return false;
        } else {
            error.textContent = '';
            return true;
        }
    }

    function validateEmail() {
        let email = document.getElementById('email').value.trim();
        let error = document.getElementById('emailError');
        // Regular expression for email with letters, numbers, and the @domain format
        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regex.test(email)) {
            error.textContent = 'Enter a valid email address (e.g., abc34@gmail.com).';
            return false;
        } else {
            error.textContent = '';
            return true;
        }
    }

    function validateNumber() {
        let number = document.getElementById('number').value.trim();
        let error = document.getElementById('numberError');
        // Regular expression to check if number starts with 98 or 97 and has 10 digits
        let regex = /^(98|97)\d{8}$/;
        if (!regex.test(number)) {
            error.textContent = 'Number must start with 98 or 97 and be 10 digits long.';
            return false;
        } else {
            error.textContent = '';
            return true;
        }
    }

    function validateMessage() {
        let message = document.getElementById('message').value.trim();
        let error = document.getElementById('messageError');
        // Check if message is at least 10 characters long
        if (message.length < 10) {
            error.textContent = 'Message must be at least 10 characters long.';
            return false;
        } else {
            error.textContent = '';
            return true;
        }
    }

    function validateForm() {
        let isValid = validateName() && validateEmail() && validateNumber() && validateMessage();
        return isValid;
    }

    document.addEventListener('DOMContentLoaded', function () {
        let inputs = document.querySelectorAll('.contact-form input, .contact-form textarea');
        inputs.forEach((input, index) => {
            input.addEventListener('keydown', function (event) {
                if (event.key === 'Tab' || event.key === 'Enter') {
                    event.preventDefault();
                    let nextInput = inputs[index + 1];
                    if (nextInput && nextInput.disabled) {
                        nextInput.focus();
                    }
                }
            });
        });
    });
</script>

    

</body>
</html>
