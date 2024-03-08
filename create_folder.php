<?php

echo $folderPath = $_POST['folderPath'];

if (!file_exists($folderPath)) {
    if (mkdir($folderPath, 0777, true)) {
        echo "Folder created successfully.";
    } else {
        echo "Failed to create folder.";
    }
} else {
    echo "Folder already exists.ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ";
}
