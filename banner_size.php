<?php
include('inc_php_funtions.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $banner_types =  mysqli_query($link, "SELECT * FROM `banner_types` WHERE `id`= '$id'");
    foreach ($banner_types as $banner_type) {
        $array = json_decode($banner_type['sizes'], true);
        print_r($array);
       $normal = $array['normal'];
     $vertical = $array['vertical'];
        $landscape = $array['landscape'];
        
        $banner_size = $array['banner_size'];
        if (!empty($normal)) {
            echo "<option value='normal'>$normal</option>";
        }
        if (!empty($vertical)) {
            echo "<option value='vertical'> $vertical</option>";
        }
        if (!empty($landscape)) {
            echo "<option value='landscape'> $landscape</option>";
        }
        if (!empty($banner_size)) {
            echo "<option value='banner_size'>$banner_size</option>";
        }
    }
}
