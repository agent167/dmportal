<?php
include('inc_php_funtions.php');
if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $banner_types =  mysqli_query($link, "SELECT * FROM `banner_types` WHERE `id`= '$id'");
          foreach ($banner_types as $banner_type) {
                    $array = json_decode($banner_type['sizes'], true);
                    $normal = $array['normal'];
                    $banner_size = $array['banner_size'];
                    if (!empty($normal)) {
                              echo "<option value='normal'>$normal</option>";
                    }
                    if (!empty($banner_size)) {
                              echo "<option value='banner_size'>$banner_size</option>";
                    }
          }
}
