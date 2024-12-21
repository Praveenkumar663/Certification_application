<?php




header("Content-Type: application/json");
$conn = new mysqli("sql309.byetcluster.com", "cpfr_37749839", "0kNen2iW07", "cpfr_37749839_certificate");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$data = json_decode(file_get_contents("php://input"), true);
$certificateNumber = $data["certificateNumber"] ?? '';

$query = $conn->prepare("SELECT * FROM student_details WHERE certificate_no = ?");
$query->bind_param("s", $certificateNumber);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["exists" => true]);
} else {
    echo json_encode(["exists" => false]);
}

$query->close();
$conn->close();
?>
