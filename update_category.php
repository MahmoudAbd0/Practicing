<?php
include "./db_connection.php";
include "./helpers.php";

$name = "";
$nameErr = "";
$error = 0;
// print_r(!empty($_GET['id']));
// die();

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $category_id = secureInput($_GET['id']);
    $sql = "select * from categories where id = '" . $category_id . "' ";
    $result = $db->query($sql);
    if ($result && $result->num_rows > 0) {
        $category = mysqli_fetch_assoc($result);
    } else {
        http_response_code(404);
        die("Category Not Found");
    }
// } else {
//     http_response_code(404);
//     die("Category ID is Missing");
// }

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

    if (!empty($_POST['image'])) {
    }
}
?>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data" method="post">
    <label for="name">name</label>
    <input type="text" id="name" value="<?php echo $category['name'] ?>">
    <span><?php echo $nameErr ?></span>
    <br><br>
    <img src="<?php echo $category['image'] ?>" style="width: 100px">
    <br><br>
    <input type="file" name="image">
    <span><?php echo $nameErr ?></span>

    <button type="submit">submit</button>
</form>