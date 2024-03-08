<?php

include('including_connection.php');
if(isset($_POST['sending_country_id'])){
    $sending_country_id = $_POST['sending_country_id'];
    $query = "DELETE FROM sending_prefered_countries WHERE sending_country_id ='$sending_country_id'";
    $result = mysqli_query($link, $query);
    $insertData = [];
    foreach ($_POST['prefered_countries'] as $value) {
        $insertData[] = "($sending_country_id, $value, NOW())";
    }

    $values = implode(',', $insertData);
    $query = "INSERT INTO sending_prefered_countries (sending_country_id, prefered_country_id, date) VALUES $values";

    $result = mysqli_query($link, $query);

    if ($result) {
        echo json_encode(["Rows inserted successfully."]);
    } else {
        echo "Error inserting rows: " . mysqli_error($link);
    }
}