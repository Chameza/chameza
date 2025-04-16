<?php
// Database config
$server = "localhost";
$user = "root";
$password = "";
$dbname = "test";
$conn = "";

// Connect to database
$conn = new mysqli($server, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$firstname = $lastname = $phone = $comment = "";
$firstname_err = $lastname_err = $phone_err = $comment_err = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form data
    if (isset($_POST['firstname']) && !empty(trim($_POST['firstname']))) {
        $firstname = trim($_POST['firstname']);
    } else {
        $firstname_err = "First name is required.";
    }

    if (isset($_POST['lastname']) && !empty(trim($_POST['lastname']))) {
        $lastname = trim($_POST['lastname']);
    } else {
        $lastname_err = "Last name is required.";
    }

    if (isset($_POST['phone']) && !empty(trim($_POST['phone']))) {
        $phone = trim($_POST['phone']);
    } else {
        $phone_err = "Phone number is required.";
    }

    if (isset($_POST['comment']) && !empty(trim($_POST['comment']))) {
        $comment = trim($_POST['comment']);
    } else {
        $comment_err = "Comment is required.";
    }

    // Check if there are no errors
    if (empty($firstname_err) && empty($lastname_err) && empty($phone_err) && empty($comment_err)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO contact_messages (firstname, lastname, phone, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstname, $lastname, $phone, $comment);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Thank you! Your message has been received.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Display errors
        echo $firstname_err . "<br>";
        echo $lastname_err . "<br>";
        echo $phone_err . "<br>";
        echo $comment_err . "<br>";
    }
}

// Close the connection
$conn->close();
?>
