<?php
// Database connection
$servername = "sql309.byetcluster.com";
$username = "cpfr_37749839";
$password = "0kNen2iW07";
$dbname = "cpfr_37749839_certificate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Delete query
    $sql = "DELETE FROM Student_details WHERE certificate_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting record: {$conn->error}');</script>";
    }
}

// Fetch all details
$sql = "SELECT phone_no, sname, certificate_no, image_path FROM Student_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Uploaded Student Details</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S_no</th>
                    <th>Phone Number</th>
                    <th>Student Name</th>
                    <th>Certificate Number</th>
                    <th>Image</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $sno=0; ?>
                <?php if ($result->num_rows > 0): ?>
                        
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php $sno++; ?>
                         <td><?php echo $sno; ?></td>
                            <td><?php echo htmlspecialchars($row['phone_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['sname']); ?></td>
                            <td><?php echo htmlspecialchars($row['certificate_no']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Image" style="height: 50px; width: 50px;"></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['certificate_no']; ?>">
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
