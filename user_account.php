<?php

include "./db_connection.php";
include "./helpers.php";
ini_set('display_errors', 1);
checkSession($db);


if (isset($_GET["id"])) {

    $user_id = $_GET["id"];
    $sql = "select * from users where id = '{$user_id}'";
    //die($sql);
    $result = $db->query($sql);
    $user_data = $result->fetch_assoc();
}


$username = $email = $password = "";
$userNameErr = $emailErr = $passwordErr = "";
$error = 0;


if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (!empty($_POST['username'])) {
        $username = secureInput($_POST['username']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
            $error = 1;
            $userNameErr = "Only Letters and Spaces are Allowed";
        }
    } else {
        $error = 1;
        $userNameErr = "Name is Required";
    }


    if (!empty($_POST['password'])) {
        $password = secureInput($_POST['password']);
        if (strlen($password) < '8') {
            $error = 1;
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "update users set name = '" . $username . "', password = '" . $hash . "' where id = '" . $user_id . "'";
        }
    } else {
        $sql = "update users set name = '" . $username . "' where id = '" . $user_id . "'";
    }
    if (!$error) {
        $update_user = $db->query($sql);
        echo "Updated Successfully";
    }
}





?>













<html>

<head>
    <title>Update User</title>
</head>

<body>
    <h1>Updating User of ID: <?php echo $user_id ?></h1>
    <form method="post">
        <label for="username">name</label>
        <input id="username" type="text" name="username" value="<?php echo $user_data['name'] ?>">
        <span class="error"> <?php echo $userNameErr ?></span>
        <br> <br>


        <label for="email">Email</label>
        <input id="email" type="text" name="email" value="<?php echo $user_data['email'] ?>" disabled>
        <span class="error"><?php echo $emailErr ?></span>
        <br> <br>

        <label for="password">Password</label>
        <input type="text" name="password">
        <span class="error"><?php echo $passwordErr ?></span>
        <br> <br>

        <button type="submit">Update</button>

    </form>
    <br><br>
    <a href="./index.php">Home</a>
</body>

</html>