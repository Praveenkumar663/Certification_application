<?php
$conn = new mysqli("sql309.byetcluster.com", "cpfr_37749839", "0kNen2iW07", "cpfr_37749839_certificate");

if ($conn->connect_error) {
    die("Database connection failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["studentName"];
    $phone = $_POST["phoneNumber"];
    $certificate = $_POST["certificateNumber"];
    $image = $_FILES["image"]["name"];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($image);

    // Validate uploaded file and move it
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Update the record
        $query = $conn->prepare("UPDATE student_details SET sname = ?, phone_no = ?, certificate_no = ?, image_path = ? WHERE certificate_no = ?");
        $query->bind_param("sssss", $name, $phone, $certificate, $targetFile, $certificate);
        if ($query->execute()) {
            echo "Student details updated successfully!";
        } else {
            echo "Error updating details.";
        }
        $query->close();
    } else {
        echo "File upload failed.";
    }
}

$conn->close();
?>
