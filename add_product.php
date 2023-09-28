<?php
include "./db_connection.php";
include "./helpers.php";

$title = $description = "";
$count = $price = $status = 0;
$titleErr = $descriptionErr = $countErr = $priceErr = $statusErr = $imageErr = "";
$error = 0;


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!empty($_POST['title'])) {
        $title = secureInput($_POST['title']);
        if (!ValidateOnlyLtrsAndSpcsAndNums($title)) {
            $error = 1;
            $titleErr = "Only Letters, Spaces And Numbers Are Allowed";
        }
    } else {
        $error = 1;
        $titleErr = "Title Is Required";
    }

    if (!empty($_POST['description'])) {
        $description = secureInput($_POST['description']);
        if (!ValidateOnlyLtrsAndSpcsAndNums($description)) {
            $error = 1;
            $descriptionErr = "Only Letters, Spaces And Numbers Are Allowed";
        }
    }
    // var_dump((int)$_POST['count']);
    if (isset($_POST['count'])) {

        if ($count === '' || $count === null) {
            $error = 1;
            $countErr = "The field is required";
        } else {
            if (!is_int($count)) {
                $error = 1;
                $countErr = "Only Integers Are Allowed";
            }
            if ($count < 0) {
                $error = 1;
                $countErr = "Please Enter A Correct Value";
            }
        }
    }


    // } else {
    //     $error = 1;
    //     $countErr = "Count Is Required";
    // }

    if (!empty($_POST['price'])) {
        $price = secureNumericInput($_POST['price']);
        if (!is_numeric($price)) {
            $error = 1;
            $priceErr = "Only Numeric Values Are Allowed";
        }
        if ($price <= 0) {
            $error = 1;
            $priceErr = "Please Enter A Correct Value";
        }
    } else {
        $error = 1;
        $priceErr = "Price Is Required";
    }

    if ($_POST['status'] !== null && $_POST['status'] !== '') {
        $status = secureNumericInput((int)$_POST['status']);
        if (!in_array($status, [0, 1])) {
            $error = 1;
            $statusErr = "Please Enter A Correct Value";
        }
    } else {
        $error = 1;
        $statusErr = "Status Is Required";
    }
}
?>






<h1>Add Product</h1>
<form action="" method="post">
    <label for="title">title</label>
    <input type="text" id="title" name="title">
    <span>* <?php echo $titleErr ?></span>
    <br><br>
    <label for="description">description</label>
    <input type="text" id="description" name="description">
    <span> <?php echo $descriptionErr ?></span>
    <br><br>
    <label for="count">count</label>
    <input type="number" id="count" name="count" step="1">
    <span>* <?php echo $countErr ?></span>
    <br><br>
    <label for="price">price</label>
    <input type="number" id="price" name="price" step="0.01">
    <span>* <?php echo $priceErr ?></span>
    <br><br>
    <label for="status">status</label>
    <select name="status" id="status">
        <option value="1">active</option>
        <option value="0">inactive</option>
    </select>
    <span>* <?php echo $statusErr ?></span>
    <br><br>
    <label for="image">image</label>
    <input type="file" id="image" name="image">
    <span>* <?php echo $imageErr ?></span>
    <br><br>
    <button type="submit">submit</button>

</form>