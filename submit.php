
<script>
    //alert('submit success');
</script>
<?php

// Validate form fields
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';

if(empty($name) || empty($email)) {
  echo "Name and Email are required!";
  exit;
}

// File upload handling
if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);

    // Check if a file with the same name already exists
    if(file_exists($targetFile)) {
        // If file exists, unlink (delete) the existing file
        unlink($targetFile);
    }

    // Upload the new file
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    echo "No file uploaded or error in uploading the file.";
}

// Display the uploaded file (for images)
echo "<p>Submitted Name: $name</p>";
echo "<p>Submitted Email: $email</p>";

$fileExtension = pathinfo($targetFile, PATHINFO_EXTENSION);
if (strtolower($fileExtension) === 'jpg' || strtolower($fileExtension) === 'jpeg' || strtolower($fileExtension) === 'png' || strtolower($fileExtension) === 'gif') {
    echo "<img  height='150px;' width='300px;' src='$targetFile' alt='Uploaded Image'>";
} else {
    echo "Uploaded file type not supported for display.";
}


?>

