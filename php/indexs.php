<?php

session_start();

// Database connection
$servername = "sql309.byetcluster.com";
$username = "cpfr_37749839";
$password = "0kNen2iW07";
$dbname = "cpfr_37749839_certificate";


$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    $cert_no = $_POST['cnum'];
    $phone_no = $_POST['phone'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM student_details WHERE certificate_no = ? AND phone_no = ?");
    $stmt->bind_param("ss", $cert_no, $phone_no );

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    

    if ($result->num_rows > 0) {
        // If a match is found, fetch the file path
        while ($row = $result->fetch_assoc()) {
            $file_path = $row['image_path'];
            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

            echo '<div>';

            if ($file_extension === 'pdf') {
                // Display PDF with download link
                echo '<div style="margin-top:20px">';
                echo '<center>';
                echo '<iframe src="' . $file_path . '" width="85%" height="550px" style="align-items:center"></iframe>';
                echo '<div style="width:100px;height:50px;background-color:green; margin:10px;padding-top:5px;border-radius:8px;">
                <a href="' . $file_path . '" download style="text-decoration:none;color:white;
                font-weight:bold; ">Download<br>PDF</a></div>';
                echo '</center>';
                echo '</div>';
            } elseif (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                // Display Image with download link
                echo '<div style="margin-top:20px">';
                echo '<center>';
                echo '<img src="' . $file_path . '" alt="Uploaded file" style="min-width:500px; max-height:700px;">';
                echo '<div style="width:100px;height:50px;background-color:green; margin:10px;padding-top:5px;border-radius:8px;">
                <a href="' . $file_path . '" download style="text-decoration:none;color:white; 
                font-weight:bold;">Download<br>Image</a></div>';
            echo '</center>';
                echo '</div>';
            } else {
                echo '<p>Unsupported file format.</p>';
            }

            echo '</div>';
        }
        
       
       
    } 
    
    else {
        echo '<p 
         style=" color:red; text-align:center; font-weight:bold;font-size:20px;font-family:arial;
         margin-top:5%;"
        >No records found. Please check your certificate and phone number.</p>';
    }
    
    

    $stmt->close();
    $conn->close();
}
?>
