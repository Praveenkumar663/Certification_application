<?php
// Database connection
$servername = "sql309.byetcluster.com";
$username = "cpfr_37749839";
$password = "0kNen2iW07";
$dbname = "cpfr_37749839_certificate";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $student_name = $_POST['studentName'];
    $phone_number = $_POST['phoneNumber'];
    $certificate_number = $_POST['certificateNumber'];

    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    

    // Check if file already exists
    if (file_exists($target_file)) {
        echo '<p 
         style=" color:red; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;"
        >Sorry, file already exists.</p>';
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        echo '<p 
         style=" color:red; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;"
        >Sorry, your file is too large.</p>';
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo '<p 
         style=" color:red; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;"
        >Sorry, your file was not uploaded.</p>';
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert data into database
            $sql = "INSERT INTO student_details (sname, phone_no, certificate_no, image_path)
                    VALUES ('$student_name', '$phone_number', '$certificate_number', '$target_file')";

            if ($conn->query($sql) === TRUE) {
                echo '<p 
         style=" color:green; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;"
        >Record uploaded successfully.</p>';
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo '<p 
         style=" color:red; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;"
        >Sorry, there was an error uploading your file.</p>';
        }
    }
}

$conn->close();
?>
