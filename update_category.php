<?php
include "./db_connection.php";
include "./helpers.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$name = "";
$nameErr = $imageErr = "";
$error = 0;
define('MB', 1048576);

if (!empty($_GET['id'])) {

    $category_id = secureInput($_GET['id']);
    $sql = "select * from categories where id = '" . $category_id . "' ";
    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        $category = mysqli_fetch_assoc($result);
    } else {
        http_response_code(404);
        die("Category Not Found");
    }
} else {
    http_response_code(404);
    die("Category ID is Missing");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['name'])) {
        $name = secureInput($_POST['name']);
        if (!ValidateOnlyLtrsAndSpcs($name)) {
            $error = 1;
            $nameErr = "Only Letters and Spaces are Allowed";
        }
    } else {
        $name = $category['name'];
    }


    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image'];
        $image_storage = "uploads/categories_images/";
        $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $targetImageName = uniqid("", true) . "." . $imageExtension;
        $targetImagePath = $image_storage . $targetImageName;
        $allowedMimes = ['jpg', 'jpeg', 'png'];

        // validate if image

        if (!getimagesize($image['tmp_name'])) {
            $error = 1;
            $imageErr = "File is Not an Image";
        }

        // validate mime type
        if (!validateMimeType($imageExtension, $allowedMimes)) {
            $error = 1;
            $imageErr =  "Only JPG, JPEG, and PNG files are allowed";
        }

        // validate image size
        if ($image['size'] > MB) {
            $error = 1;
            $imageErr = "Maximum Image Is 1MB";
        }
        if (!$error) {
            if (!is_dir($image_storage)) {
                mkdir($image_storage, 0777, true);
            }
        }
    } else {
        $targetImagePath = $category['image'];
    }
    if (!$error) {

        $sql = "update categories set name = '" . $name . "', image = '" . $targetImagePath . "' where id = '" . $category_id . "'";
        $result = $db->query($sql);
        header("location: ./update_category.php?id=$category_id");
    }
}



?>


<form action="" enctype="multipart/form-data" method="post">s
    <label for="name">name</label>
    <input name="name" type="text" id="name" value="<?php echo $category['name'] ?>">
    <span><?php echo $nameErr ?></span>
    <br><br>
    <img src="<?php echo $category['image'] ?>" style="width: 100px">
    <br><br>
    <input type="file" name="image">
    <span><?php echo $imageErr ?></span>

    <button type="submit">submit</button>
    <br><br>
    <a href="./categories.php">categories</a>
</form>