<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $file = $_FILES['file'];
    $folderPath = $_POST['folderPath'];
    // print_r($file);
   
    // Ensure the folder path is valid and exists
    if (!empty($folderPath) && is_dir($folderPath)) {
        echo $targetPath = $folderPath . '/' . $file['name'];
        // Move the uploaded file to the target path
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Image uploaded successfully
            echo 'Image uploaded successfully.';
        } else {
            // Failed to move the uploaded file
            echo 'Error moving the uploaded file.';
        }
    } else {
        // Invalid folder path
        echo 'Invalid folder path.';
    }
} else {
    // Invalid request method
    echo 'Invalid request method.';
}
