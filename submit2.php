//using sql insert query

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'formdata';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data into database

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$targetFile = $_FILES["file"]["name"] ?? '';

// File upload handling
if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);

    // Check file type and size (example: allow only image files less than 5MB)
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileSize = $_FILES["file"]["size"];

    if (!in_array($fileExtension, $allowedTypes) || $fileSize > $maxFileSize) {
        echo "Invalid file. Only JPG, JPEG, PNG, and GIF files up to 5MB are allowed.";
        exit;
    }

    // Upload the new file
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
        echo "<img  height='150px;' width='300px;' src='$targetFile' alt='Uploaded Image'>";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }
} else {
    echo "No file uploaded or error in uploading the file.";
    exit;
}

if(!empty($name) && !empty($email) && !empty($targetFile)) {
    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, file_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $targetFile);

    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Error inserting data: " . $stmt->error;
    }
} else {
    echo "Name, Email, and File are required.";
}

// Close connection
$conn->close();


?>

