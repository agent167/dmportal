<?php
$page_name = basename($_SERVER['PHP_SELF']);
if ($page_name != 'index.php') {
?>
    <?php include('inc_php_funtions.php'); ?>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The biggest remittance software in the world by dpanel.co">
    <meta name="author" content="dpanel.co">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" integrity="sha512-8doNprLI7BCCBYRH642nRhdzbmgMNERNjaW7rZ2xtKbsgTI1HCqQKpQClTxjMZs/deq6y8OLW8IcV0PXUTgvWw==" crossorigin="anonymous" referrerpolicy="no-referrer" />