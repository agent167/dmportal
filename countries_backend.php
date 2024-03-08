<?php
//Banner
function input_keys($sending_country)
{
    $banner_FileName = '';
    $i = 0;
    if (isset($_POST['submit_btn'])) {
        if (isset($_POST['sending_country'])) {
            $sending_country = $_POST['sending_country'];
        } else {
            $sending_country = '';
        }
    }
    $banner_type = $_POST['banner_type'];
    if (isset($_POST['banner_sub_type'])) {
        $banner_sub_type = $_POST['banner_sub_type'];
    } else {
        $banner_sub_type = 1;
    }
    $banner_type_size = $_POST['banner_type_size'];
    return [
        'banner_FileName' => $banner_FileName,
        'i' => $i,
        'sending_country' => $sending_country,
        'banner_type' => $banner_type,
        'banner_sub_type' => $banner_sub_type,
        'banner_type_size' => $banner_type_size
    ];
}
function file_type($error_array, $file_count)
{
    for ($i = 0; $i < $file_count; $i++) {
        if ($_FILES["banner"]["type"][$i] == "image/jpeg" || $_FILES["banner"]["type"][$i] == "image/png" || $_FILES["banner"]["type"][$i] == "image/jpg") {
        } else {
            $banner_FileName = $_FILES["banner"]["name"][$i];
            $error_array[] = "<div class='alert alert-danger'>
                                            <div class='container'><strong>This type of file " . $banner_FileName . " is not allowed to upload.</strong></div>
                                        </div>";
        }
    }
    return $error_array;
}
// check if country exists then move banner to directory
function banner_file_upload($i, $banner_FileName, $banner_type, $link)
{
    $banner_types = mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE `id` = '$banner_type'"));
    $banner_folder = $banner_types['name'];
    $banner_validation = "SELECT `name` FROM `countries` WHERE `iso3` = ";
    $path = "images/" . $banner_folder . "/";
    (!is_dir($path)) ? mkdir($path, 0770, true) : '';
    if (is_array($_FILES["banner"]["name"])) {
        $withoutExt = explode('.', $_FILES["banner"]["name"][$i]);
        $FileType = "Type: " . $_FILES["banner"]["type"][$i] . "<br />";
        $FileSize = "Size: " . ($_FILES["banner"]["size"][$i] / 99999999) . " Kb<br />";
        // For Banner File Start
        if (file_exists($path . $_FILES["banner"]["name"][$i])) {
            $PIN = rand(100000, 999999);
            $main = $withoutExt[0] . '-' . $PIN . '.' . $withoutExt[1];
            move_uploaded_file(
                $_FILES["banner"]["tmp_name"][$i],
                $path . $main
            );
            $StrNotice = "File Uploaded and Renamed in: " . $path . $main;
            $banner_FileName =   $main;
        } else {
            $main = str_replace(" ", "_", $_FILES["banner"]["name"][$i]);
            move_uploaded_file(
                $_FILES["banner"]["tmp_name"][$i],
                $path . $main
            );
            $StrNotice = "File Uploaded in: " . $path . $main;
            $banner_FileName = $main;
        }
    } else {
        $withoutExt = explode('.', $_FILES["banner"]["name"]);
        $country_id = isset($_GET['country_id']) ? $_GET['country_id'] : (!empty(($_POST['sending_country'])) ? $_POST['sending_country'] : '');
        if (file_exists($path . $_FILES["banner"]["name"])) {
            $PIN = rand(100000, 999999);
            $main = $withoutExt[0] . '-' . $PIN . '.' . $withoutExt[1];
            $StrNotice = "File Uploaded and Renamed in: " . $path . $main . $PIN;
            $banner_FileName =   $main;
            $main_validation = explode('-', $main);
        } else {
            $main = str_replace(" ", "_", $_FILES["banner"]["name"]);
            $main_validation = explode('.', $main);
            $banner_FileName =   $main;
        }
        // AND `id` = '$country_id'
        $query = $banner_validation . "'$main_validation[0]' AND `id` = '$country_id' ";
        $main_result = $link->query($query);
        $main_count = 0;
        $main_count = ($main_result) ? $main_result->num_rows : $main_count;
        if ($main_count == 0) {
            $banner_FileName = NULL;
        } elseif ($main_count == 1) {
            move_uploaded_file($_FILES["banner"]["tmp_name"], $path . $main);
        }
    }
    return $banner_FileName;
}
function sending_validation($link, $sending_country)
{
    $query_select = mysqli_query($link, "SELECT * FROM `countries_currencies` WHERE `country_id`='$sending_country'");
    $query_select_count = mysqli_num_rows($query_select);
    if ($query_select_count == 0) {
        mysqli_query($link, "INSERT INTO `countries_currencies`(`country_id`,`status`, `created_at`) VALUES ('$sending_country','1',NOW())");
        $get_id = mysqli_insert_id($link);
    } else {
        $query_select = mysqli_fetch_array(mysqli_query($link, "SELECT `id` FROM `countries_currencies` WHERE `country_id`='$sending_country'"));
        $get_id = $query_select['id'];
    }
    return $get_id;
}
function banner_validation($link, $get_id, $banner_type)
{
    $query_select = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$get_id' AND `type`='$banner_type'"));
    // echo $query_select;
    // exit;
    return $query_select;
}
function banner_insertion($get_id,  $banner_FileName, $banner_type, $link, $banner_sub_type, $banner_type_size, $i)
{
    // $sql_query = "INSERT INTO `banners` (`count_curr_id`,`image`,`type`,`sub_type`,`size`, `status`, `created_at`) VALUES ('$get_id','$banner_FileName','$banner_type','$banner_sub_type','$banner_type_size','1',NOW())";
    // if (!mysqli_query($link, $sql_query)) {
    //     echo "ERROR: Could not able to execute $sql_query. " . mysqli_error($link);
    // }
    // // exit;
    //    echo 'heloo'. $banner_FileName;
    //     exit;
    //     echo "INSERT INTO `banners` (`count_curr_id`,`image`,`type`,`sub_type`,`size`, `status`, `created_at`) VALUES ('$get_id','$banner_FileName','$banner_type','$banner_sub_type','$banner_type_size','1',NOW())";
    //    exit;
    // addded by umair naveed
    // delete from banner where banner tyoe and countr curr id except banner type 3 becasye 3 is individaul and code is writeen in banner history funcion for individual
    $query2 = "SELECT b.id as banner_id, b.image, bt.id as bannertype_id, bt.name
          FROM banners b
          LEFT JOIN banner_types as bt ON b.type = bt.id
          WHERE b.count_curr_id = '$get_id' AND b.type = '$banner_type' AND b.type != '3'";
    $get_data_query = mysqli_query($link, $query2);
    if (mysqli_num_rows($get_data_query) > 0) {
        $result_data = mysqli_fetch_assoc($get_data_query);
        echo $banner_id = $result_data['banner_id'];
        echo  $image = $result_data['image'];
        echo  $bannertype_id = $result_data['bannertype_id'];
        echo $bannertype_name = $result_data['name'];
        $image_path = 'images/' . $bannertype_name . '/' . $image;
        mysqli_query($link, "INSERT INTO banners_history SELECT * FROM banners WHERE `count_curr_id`='$get_id' AND `type`='$banner_type' AND `id` ='$banner_id'");
        if (file_exists($image_path)) {
            unlink($image_path);
            mysqli_query($link, "DELETE FROM `banners` WHERE `id` = '$banner_id'");
        }
    }
    // ended by umair naveed
    mysqli_query($link, "INSERT INTO `banners` (`count_curr_id`,`image`,`type`,`sub_type`,`size`, `status`, `created_at`) VALUES ('$get_id','$banner_FileName','$banner_type','$banner_sub_type','$banner_type_size','1',NOW())");
}
function banner_multiple($get_id,  $file_count, $banner_type, $link, $banner_sub_type, $banner_FileName, $banner_type_size)
{
    $min_size = 0;
    $max_size = 40000000;
    for ($i = 0; $i < $file_count; $i++) {
        $min_size += $_FILES["banner"]["size"][$i];
        if (
            ($_FILES["banner"]["type"][$i] == "image/jpeg" || $_FILES["banner"]["type"][$i] == "image/png" || $_FILES["banner"]["type"][$i] == "image/jpg") && ($_FILES["banner"]["size"][$i] < 1024000 && $min_size <= $max_size)
        ) {
            $banner_FileName = banner_file_upload($i, $banner_FileName, $banner_type, $link);
            banner_insertion($get_id,  $banner_FileName, $banner_type, $link, $banner_sub_type, $banner_type_size, $i);
        } else {
            return false;
        }
    }
    return true;
}
// function banner_multiple($get_id,  $file_count, $banner_type, $link, $banner_sub_type, $banner_FileName, $banner_type_size)
// {
//     for ($i = 0; $i < $file_count; $i++) {
//         if (
//             ($_FILES["banner"]["type"][$i] == "image/jpeg" || $_FILES["banner"]["type"][$i] == "image/png" || $_FILES["banner"]["type"][$i] == "image/jpg") && ($_FILES["banner"]["size"][$i] < 99999999)
//         ) {
//             $banner_FileName = banner_file_upload($i, $banner_FileName, $banner_type, $link);
//             if (!empty($banner_FileName)) {
//                 banner_insertion($get_id,  $banner_FileName, $banner_type, $link, $banner_sub_type, $banner_type_size, $i);
//             }
//         }
//     }
// }
function banner_history($cc_id, $link, $banner_type, $query_select)
{
    if ($query_select != 0) {
        $sql =   "UPDATE `banners` SET `status`='0' WHERE `count_curr_id`='$cc_id' AND `type`='$banner_type';";
        $sql .=   "INSERT INTO banners_history SELECT * FROM banners WHERE `count_curr_id`='$cc_id' AND `type`='$banner_type' AND `status`='0';";
        // $sql .=  "DELETE FROM banners WHERE `count_curr_id`='$cc_id' AND `type`='$banner_type';";
        $bannerResult = mysqli_query($link, "SELECT `id`, `image` FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '$banner_type'");
        while ($banner = mysqli_fetch_array($bannerResult)) {
            $banner_type_nameResult = mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE `id`='$banner_type'");
            $banner_type_name = mysqli_fetch_array($banner_type_nameResult);
            unlink('images/' . $banner_type_name['name'] . '/' . $banner['image']);
            mysqli_query($link, "DELETE FROM `banners` WHERE `id`='$banner[id]'");
        }
        if (mysqli_multi_query($link, $sql)) {
            do {
                if ($result = mysqli_store_result($link)) {
                    while ($row = mysqli_fetch_row($result)) {
                        printf("%s\n", $row[0]);
                    }
                    mysqli_free_result($result);
                }
            } while (mysqli_next_result($link));
        }
    }
}
function country_delete($link, $id)
{
    $query_banner = "SELECT b.id as banner_id, b.image, bt.id as bannertype_id, bt.name
                     FROM banners b
                     LEFT JOIN banner_types as bt ON b.type = bt.id
                     WHERE b.count_curr_id = '$id'";
    $get_data_query = mysqli_query($link, $query_banner);
    // Use a foreach loop to iterate over the results
    foreach ($get_data_query as $result_data) {
        $banner_id = $result_data['banner_id'];
        $image = $result_data['image'];
        $bannertype_id = $result_data['bannertype_id'];
        $bannertype_name = $result_data['name'];
        $image_path = 'images/' . $bannertype_name . '/' . $image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        // Delete the row from the banners table
        mysqli_query($link, "DELETE FROM `banners` WHERE `id` = '$banner_id'");
        // Delete the row from the countries_currencies table
        mysqli_query($link, "DELETE FROM `countries_currencies` WHERE `id`='$id'");
    }
}
function currencies_delete($link, $id)
{
    $currency_banner_del = mysqli_query($link, "SELECT b.id as banner_id, b.image, bt.id as bannertype_id, bt.name
        FROM banners b
        LEFT JOIN banner_types as bt ON b.type = bt.id
        WHERE b.count_curr_id = '$id' AND b.type IN (2,6,8)");
    foreach ($currency_banner_del as $result_data) {
        $banner_id = $result_data['banner_id'];
        $image = $result_data['image'];
        $bannertype_name = $result_data['name'];
        $image_path = 'images/' . $bannertype_name . '/' . $image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        // Delete the row from the banners table
        mysqli_query($link, "DELETE FROM `banners` WHERE `id` = '$banner_id' AND `type` IN (2,6,8)");
    }
    // Delete the row from the countries_currencies table
    mysqli_query($link, "DELETE FROM `countries_currencies` WHERE `id`='$id'");
}
function multiple_single($link, $cc_id, $country_id, $get_id, $sending_country)
{
    $FileType = "";
    $FileSize = "";
    // echo $get_id;
    $banner_FileName = input_keys($sending_country)['banner_FileName'];
    $i = input_keys($sending_country)['i'];
    $sending_country = input_keys($sending_country)['sending_country'];
    $banner_type = input_keys($sending_country)['banner_type'];
    $banner_sub_type = input_keys($sending_country)['banner_sub_type'];
    $banner_type_size = input_keys($sending_country)['banner_type_size'];
    //insert recrod into countries_currencies and returen  countries_currencies (id)
    $get_id = sending_validation($link, $sending_country, $get_id);
    // check number of rows in banner where count_curr_id = countries_currencies (id)
    $query_select = banner_validation($link, $get_id, $banner_type);
    // exit;
    if (is_array($_FILES["banner"]["name"])) { //For Multiple Banner
        $error_array = [];
        $file_count = count($_FILES["banner"]["name"]);
        $error_array = file_type($error_array, $file_count);
        if (empty($error_array)) {
            if ($query_select == 0) {
                if (banner_multiple($get_id,  $file_count, $banner_type, $link, $banner_sub_type, $banner_FileName, $banner_type_size)) {
                    echo routes($cc_id, $country_id)['success'];
                } else {
                    echo routes($cc_id, $country_id)['failes5'];
                }
            } else {
                if (isset($_POST['edit_submit'])) {
                    banner_history($cc_id, $link, $banner_type, $query_select);
                    if (banner_multiple($get_id,  $file_count, $banner_type, $link, $banner_sub_type, $banner_FileName, $banner_type_size)) {
                        echo routes($cc_id, $country_id)['success'];
                    } else {
                        echo routes($cc_id, $country_id)['failes5'];
                    }
                } else {
                    echo routes($cc_id, $country_id)['failes1'];
                }
            }
        }
    } 
    else {  //For one Banner
        if (
            ($_FILES["banner"]["type"] == "image/jpeg" || $_FILES["banner"]["type"] == "image/png" || $_FILES["banner"]["type"] == "image/jpg") && ($_FILES["banner"]["size"] < 99999999)
        ) {
            if ($_FILES["banner"]["error"] > 0) {
                $StrNotice = "Return Code: " . $_FILES["banner"]["error"] . "<br />";
            } else {
                if (empty($_FILES["banner"]["error"])) {
                    $FileType = "Type: " . $_FILES["banner"]["type"] . "<br />";
                    $FileSize = "Size: " . ($_FILES["banner"]["size"] / 99999999) . " Kb<br />";
                    $banner_FileName = banner_file_upload($i, $banner_FileName, $banner_type, $link);
                    if ($banner_FileName == NULL) {
                        // fails 1
                        echo routes($cc_id, $country_id)['failes3'];
                    } elseif (!empty($banner_FileName)) {
                        if (isset($_POST['edit_submit'])) { // For Edit
                            //  banner_history($cc_id, $link, $banner_type, $query_select);
                            banner_insertion($get_id,  $banner_FileName, $banner_type, $link, $banner_sub_type, $banner_type_size, $i);
                            echo routes($cc_id, $country_id)['success'];
                        } elseif (isset($_POST['submit_btn'])) {
                            if ($query_select == 0) { // For Create
                                banner_insertion($get_id,  $banner_FileName, $banner_type, $link, $banner_sub_type, $banner_type_size, $i);
                                echo routes($cc_id, $country_id)['success'];
                            } else {
                                echo routes($cc_id, $country_id)['failes2'];
                            }
                        }
                    }
                }
            }
        }
    }
}
function routes($cc_id, $country_id)
{
    $type = $_GET['type'];
    if (isset($_POST['edit_submit'])) {
        $success = ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&type=$type&success=y'</script>");
        $failes1 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&type=$type&failes=1'</script>");
        $failes3 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&type=$type&failes3=1'</script>");
        $failes5 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&type=$type&failes5=1'</script>");
    } else {
        $success =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?type=$type&success=y'</script>");
        $failes1 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?type=$type&failes=1'</script>");
        $failes5 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?type=$type&failes5=1'</script>");
        $failes3 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?type=$type&failes3=1'</script>");
    }
    $failes2 =  ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?type=$type&failes=2'</script>");
    return [
        'success' => $success,
        'failes1' => $failes1,
        'failes2' => $failes2,
        'failes3' => $failes3,
        'failes5' => $failes5,
    ];
}
//CSV File Upload Start
function csv_file_upload($link, $upload_FileName, $cc_id, $country_id)
{
    if (
        ($_FILES["upload_file"]["type"] == "text/csv") && ($_FILES["upload_file"]["size"] < 99999999)
    ) {
        if ($_FILES["upload_file"]["error"] > 0) {
            $StrNotice = "Return Code: " . $_FILES["upload_file"]["error"] . "<br />";
        } else {
            // For CSV File Start
            if (empty($_FILES["upload_file"]["error"])) {
                $upload_FileName = $_FILES["upload_file"]["name"];
                $upload_FileName = $_FILES["upload_file"]["tmp_name"];
                $i = 0;
                $upload_FileNameSubStr = substr($upload_FileName, 0, -4);
                // For Sending Country Validation Start
                if ($_FILES["upload_file"]["size"] > 0) {
                    $file = fopen($upload_FileName, "r");
                    //  $result_array = $file
                    $result_array = file_map($file, $i, $link);
                    // echo "<pre>";
                    // print_r($result_array);
                    // exit;
                    $countries_currencies = mysqli_num_rows(mysqli_query($link, "SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id'"));
                    if ($countries_currencies > 0) {
                        rates_history($link, $cc_id);
                    }
                    foreach ($result_array as $result_arr) {  // File insertion
                        rates_insertion($link, $result_arr, $cc_id);
                    }
                    echo ("<script>location='" . basename($_SERVER['PHP_SELF']) . "?id=$cc_id&country_id=$country_id&success=y'</script>");
                } else {
                    $strNotice = "<strong>Invalid File:</strong> <strong><u>" . $upload_FileName . "</u></strong> <em>Please Upload CSV File.</em>";
                }
                // echo routes($cc_id, $country_id)['success'];
            }
            // For CSV File End
        }
    } else {
        echo routes($cc_id, $country_id)['failes1'];
    }
}
function file_map($file, $i, $link)
{
    $array = [];
    $result_array = [];
    while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
        $emapData = str_replace(",", " ", $emapData);
        if ($i > 0) {
            // echo $emapData[1];
            // echo "<br>";
            // exit;
            $array[$emapData[2]][] = [
                'country' =>  $emapData[1],
                'currency' =>  $emapData[2],
                'rate' =>  $emapData[3]
            ];
        }
        $i++;
    }
    fclose($file);
    // echo '<pre>';
    //For Data Mapping
    foreach ($array as $arr_index => $arr) {
        foreach ($arr as $inner_arr) {
            $country_name = $inner_arr['country'];
            //  echo '<br>';
            $select_sql = mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`name` FROM `countries` WHERE  `name`='$country_name'"));
            // $select_sql = mysqli_fetch_array(mysqli_query($link, "SELECT `id`,`name` FROM `countries` WHERE `currency`='$arr_index' AND `name`='$country_name'"));
            if (!empty($select_sql)) {
                $currency_id = $select_sql['id'];
                $currency_id_array = [
                    'currency_id' => $currency_id,
                ];
                $result_array[] = array_merge($inner_arr, $currency_id_array);
            }
            // else
            // {
            //     echo $country_name;
            //      echo '<br>';
            // }
        }
    }
    // exit;
    return $result_array;
}
function rates_history($link, $cc_id)
{
    // print_r($cc_id);
    // exit;
    $sql =   "UPDATE `countries_currencies_rates` SET `status`='0' WHERE `count_curr_id`='$cc_id';";
    $sql .=   "INSERT INTO `currencies_rates_history` SELECT * FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id' AND `status`='0';";
    $sql .=  "DELETE FROM `countries_currencies_rates` WHERE `count_curr_id`='$cc_id';";
    if (mysqli_multi_query($link, $sql)) {
        do {
            if ($result = mysqli_store_result($link)) {
                while ($row = mysqli_fetch_row($result)) {
                    printf("%s\n", $row[0]);
                }
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($link));
    }
    // print_r($link->error);
    // exit;
}
function rates_insertion($link, $result_arr, $cc_id)
{
    $currency_id = $result_arr['currency_id'];
    $rate = $result_arr['rate'];
    mysqli_query($link, "INSERT INTO `countries_currencies_rates`(`count_curr_id`, `currency_id`, `rate`, `status`, `created_at`) VALUES ('$cc_id','$currency_id','$rate','1',NOW())");
}
//On download Page history
function specific_rates_history($link, $i, $rate_id)
{
    $sql =   "INSERT INTO `currencies_rates_history` (`count_curr_id`, `currency_id`, `rate`, `status`, `preferrence`, `created_at`, `upated_at`) SELECT `count_curr_id`, `currency_id`, `rate`, `status`, `preferrence`, `created_at`, `upated_at` FROM `countries_currencies_rates` WHERE `id`=$rate_id[$i];";
    $sql .=   "UPDATE `countries_currencies_rates` SET `status`= 0;";
    if (mysqli_multi_query($link, $sql)) {
        do {
            if ($result = mysqli_store_result($link)) {
                while ($row = mysqli_fetch_row($result)) {
                    printf("%s\n", $row[0]);
                }
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($link));
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    // exit;
}
//CSV File Upload End
function str_contains($haystack, $needle): bool
{
    if (is_string($haystack) && is_string($needle)) {
        return '' === $needle || false !== strpos($haystack, $needle);
    } else {
        return false;
    }
}
// function file_max_map($array)
// {
//     $result_array = [];
//     foreach ($array as $arr) {
//         $rate_array = [];
//         foreach ($arr as $inner_arr) {
//             array_push($rate_array, $inner_arr['rate']);
//         }
//         $result_array[] = [
//             'country' => $inner_arr['country'],
//             'currency' => $inner_arr['currency'],
//             'rate' => max($rate_array),
//         ];
//     }
//     return $result_array;
// }
//Edit sending country html Start
function edit_sending_country_html($link, $cc_id, $country_id)
{
    // $sending_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '1'");
    $sending_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` IN (1,5,7)");
    // $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '1'"));
    // $banner_path = $banner_types['name'];
    foreach ($sending_banners as $sending_banner) {
        $type =   $sending_banner['type'];
        $id_del = $sending_banner['id'];
        $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '$type'"));
        $banner_path = $banner_types['name'];
        $sending_image = $sending_banner['image'];
        if (!empty($sending_image)) {
?>
            <!-- <span style="color: red;"><i class="fa fa-trash"></i></span> -->
            <a href="<?= basename($_SERVER['PHP_SELF']) . "?id=" . $cc_id; ?>&country_id=<?= $country_id; ?>&banner_type=<?= $type; ?>&delid=<?= $id_del; ?>&delete=y" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
            <img src="images/<?= $banner_path; ?>/<?= $sending_image; ?>" alt="" class="" style="width:200px;left: -10%;top: 58%; padding-top: 24px; position: relative;
    padding: 0;">
        <?php
        }
    }
}
//Edit sending country html End
//Edit receving country html Start
function edit_receving_country_html($link, $cc_id, $country_id)
{
    // $receving_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '2'");
    $receving_banners =  mysqli_query($link, "SELECT * FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` IN (2,6,8)");
    // $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '2'"));
    // $banner_path = $banner_types['name'];
    foreach ($receving_banners as $receving_banner) {
        // $receving_image = $receving_banner['image'];
        $receving_type = $receving_banner['type'];
        $id_del =  $receving_banner['id'];
        $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '$receving_type'"));
        $banner_path = $banner_types['name'];
        $receving_image = $receving_banner['image'];
        if (!empty($receving_image)) {
        ?>
            <a href="<?= basename($_SERVER['PHP_SELF']) . "?id=" . $cc_id; ?>&country_id=<?= $country_id; ?>&banner_type=<?= $receving_type; ?>&delid=<?= $id_del; ?>&delete=y" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
            <img src="images/<?= $banner_path; ?>/<?= $receving_image; ?>" alt="" class="" style="width:200px;left: -10%;top: 58%; padding-top: 24px; position: relative;
    padding: 0;">
        <?php
        }
    }
}
//Edit receving country html End
//Edit individual country html Start
function edit_individual_country_html($link, $cc_id, $country_id)
{
    $individual_banners =  mysqli_query($link, "SELECT `id`, `count_curr_id`, `image`, `type` FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '3'");
    while ($row = mysqli_fetch_assoc($individual_banners)) {
        $delid = $row['id'];
        $count_curr_id = $row['count_curr_id'];
        $image = $row['image'];
        $type = $row['type'];
    }
    $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '3'"));
    $banner_path = $banner_types['name'];
    if (mysqli_num_rows($individual_banners) > 0) {
        ?>
        <?php
        foreach ($individual_banners as $individual_banner) {
            $individual_image = $individual_banner['image'];
            $ind_delete = $individual_banner['id'];
            if (str_contains("$individual_image", "-")) {
                $individual_image = explode('-', $individual_image);
                $individual_extention = explode('.', $individual_image[1]);
            }
            $image_name = is_array($individual_image) ?  $individual_image[0]  . '-' . $individual_extention[0] . '.' . $individual_extention[1] : $individual_image;
        ?>
         <a href="<?= basename($_SERVER['PHP_SELF']) . "?id=" . $cc_id; ?>&country_id=<?= $country_id; ?>&banner_type=<?=$type;?>&delid=<?=$ind_delete;?>&delete=y" onclick="javascript:return confirm('Are you sure you want to delete ?')" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-sm delindividual" style="margin-right:28px;margin-top:26px"><i class="fa fa-trash"></i></a><br>
            <img src="images/<?= $banner_path; ?>/<?= $image_name; ?>" alt="" class="col-lg-12 col-md-12" style="margin-top: 3%;">
    <?php
        }
    }
}
// added by umair
function banner_delete($link, $cc_id, $banner_type, $delid)
{
    $bannerResult = mysqli_query($link, "SELECT `image` FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '$banner_type' AND `id` = '$delid'");
$banner = mysqli_fetch_array($bannerResult);
$banner_type_nameResult = mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE `id`='$banner_type'");
$banner_type_name = mysqli_fetch_array($banner_type_nameResult);
    unlink('images/' . $banner_type_name['name'] . '/' . $banner['image']);
    mysqli_query($link, "DELETE FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '$banner_type' AND `id` = '$delid'");
}
// ended by umair
function edit_banner_delete($link, $cc_id, $banner_type)
{
    $banner =  mysqli_fetch_array(mysqli_query($link, "SELECT `image` FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '$banner_type'"));
    $banner_type_name =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE `id`='$banner_type'"));
    unlink('images/' . $banner_type_name['name'] . '/' . $banner['image']);
    mysqli_query($link, "DELETE FROM `banners` WHERE `count_curr_id`='$cc_id' AND `type` = '$banner_type'");
}
//Edit Banner delete End
//Download individual country html Start
function individual_html($link, $individual_image, $currency_code, $rate, $individual_currency, $iso, $individual_iso, $countries, $individual_extention, $count, $sending_currecy_code, $flag_status)
{
    $banner_types =  mysqli_fetch_array(mysqli_query($link, "SELECT `name` FROM `banner_types` WHERE  `id` = '3'"));
    $banner_path = $banner_types['name'];
    // print_r($banner_path);
    // exit;
    $id = $_GET['id']; // Assuming you have already validated and sanitized the input
    // Prepare the query with a placeholder for the parameter
    $banner_sub_type = $link->query("SELECT sub_type FROM `banners` WHERE count_curr_id = '$id'  limit 1")->fetch_assoc();
    $sub_type = $banner_sub_type['sub_type'];
    $image_name = is_array($individual_extention) ?  $individual_image[0]  . '-' . $individual_extention[0] . '.' . $individual_extention[1] : $individual_image[0] . '.' . $individual_image[1];
    ?>
    <div>
        <input type="hidden" name="currency_code" id="currency_code_<?= $count; ?>" value="<?= $individual_currency; ?>">
        <div data-id="currency_code_<?= $count; ?>" style="background-image: url(images/<?= $banner_path . '/' . $image_name; ?>);background-repeat: no-repeat;background-size: contain;background-position: center;" class="individual_content_download col-lg-6 col-md-6 col-sm-6 col-xs-6 content-align-center">
            <div class="guinea-rates">
                <div class="">
                    <p class="guinea-rate-fill">1 <?= $sending_currecy_code . ' = ' . $rate . ' ' . $individual_currency; ?></p>
                </div>
                <div class="guinea-mains">
                    <?php if ($flag_status == 0) { ?>
                        <img src="rect_flag/<?= $iso; ?>.png" alt="">
                    <?php
                    } else { ?>
                        <img src="rect_flag/europe.png" alt="">
                    <?php
                    }
                    ?>
                    <img src="rect_flag/<?= $individual_iso; ?>.png" alt="">
                </div>
            </div>
        </div>
        <h1 class="text-center"><?= $countries['name']; ?></h1>
    </div>
<?php
}
//Download individual country html End
