<?php

include "./db_connection.php";
if (isset($_GET['id'])) {
    $user_id = secureInput($_GET['id']);
    $sql = "delete from users where id = '" . $user_id . "'";
    $delete_user = $db->query($sql);
    if ($delete_user) {
        echo "User with ID: {$user_id} Deleted Successfully";
    } else {
        echo "An Error Occured During Deleting User";
    }
}
