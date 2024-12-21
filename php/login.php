<?php
// Start the session
session_start();


$servername = "sql309.byetcluster.com";
$username = "cpfr_37749839";
$password = "0kNen2iW07";
$dbname = "cpfr_37749839_certificate";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $admin_name = $_POST['text'];
    $pass = $_POST['pass'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM login WHERE admin_name = ? AND password = ?");
    $stmt->bind_param("ss", $admin_name, $pass);

    $stmt->execute();
    $result = $stmt->get_result();

    // Check if login credentials are correct
    if ($result->num_rows > 0) {
        header("Location: ../html/details.html");
        exit();
    } else {
        // If credentials are incorrect, show error message
        echo '<p
        style=" color:red; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;">
        Invalid username or password.
        </p>';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
