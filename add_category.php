<?php
include "./db_connection.php";
// include "./layout/header.php";
// include "./layout/footer.php";
include "./helpers.php";
ini_set('display_errors', 1);
ini_set('error_reporting', 1);
$imageErr = $nameErr = "";
$name = "";
$error = 0;
define('MB', 1048576);
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (!empty($_POST['name'])) {
        $name = secureInput($_POST['name']);
        if (!ValidateOnlyLtrsAndSpcs($name)) {
            $error = 1;
            $nameErr =  "Only Letters and Spaces are Allowed";
        }
    } else {
        $error = 1;
        $nameErr = "Category Name is Required";
    }
    $image = validateImage($_FILES['image']);
    $storedImagePath = $image['path'] . $image['imageName'];

    $imageErr = $image['imageErro'];

    if ($image['error'] === 0) {
        if (uploadImage($_FILES['image']['tmp_name'], $storedImagePath)) {
        } else {
            $error = 1;
        }
    }
    if (!$error) {
        $sql = "insert into categories (name, image) values ('" . $name . "', '" . $storedImagePath . "') ";
        $result = $db->query($sql);
        chmod($storedImagePath, 0777);
        if ($result) {
            header("Refresh:2");
            echo ("Category Added Successfully");
        } else {
            print_r("An Error Occured - Category Not Saved");
        }
    }
}
?>



<h1>Add Category</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data">
    <label for="name">name</label>
    <input type="text" value="<?= @$_POST['name'] ?>" name="name" id="name">
    <span>*<?php echo $nameErr ?></span>

    <br><br>
    <label for="image">Image</label>
    <input type="file" id="image" name="image">
    <span>*<?php echo $imageErr ?></span>
    <button type="submit">Add Category</button>

</form>