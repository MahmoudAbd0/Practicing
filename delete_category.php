<?php
include "./db_connection.php";
include "./helpers.php";

if ($_GET['id']) {
    $category_id = secureInput($_GET['id']);
    $sql = "select image from categories where id = '" . $category_id . "'";

    if ($result = $db->query($sql)) {
        $image_path = mysqli_fetch_column($result);

        $sql = "delete from categories where id = '" . $category_id . "'";
        $result = $db->query($sql);
        unlink($image_path);
        header("location: ./categories.php ");
    } else {
        echo "An Error Occured During Deleted Category";
    }
}
