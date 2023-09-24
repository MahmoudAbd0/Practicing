<?php
include "./db_connection.php";
include "./helpers.php";

if ($_GET['id']) {
    $category_id = secureInput($_GET['id']);
    print_r($category_id);
}
