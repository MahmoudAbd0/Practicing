<?php
include "./db_connection.php";
include "./helpers.php";
checkSession($db);

$userNameErr = $emailErr = $passwordErr = $cpasswordErr = "";
$username = $email = $password = $cpassword = "";
$error = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["username"])) {
        $username = secureInput($_POST["username"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",  $username)) {
            $userNameErr = "Only Letters and Spaces are Allowed";
        }
    } else {
        $userNameErr = "name is Required";
    }


    if (!empty($_POST["email"])) {
        $email = secureInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Please Enter a Correct Email";
            $error = 1;
        }
    } else {
        $emailErr = "Email is Required";
        $error = 1;
    }


    if (!empty($_POST["password"]) && ($_POST["password"] == $_POST["cpassword"])) {
        $password = secureInput($_POST["password"]);
        $cpassword = secureInput($_POST["cpassword"]);
        if (strlen($_POST["password"]) < '8') {
            $error = 1;
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
        }
    } elseif (!empty($_POST["password"])) {
        $error = 1;
        $cpasswordErr = "Passwords doesn't match. Please confirm password";
    } else {
        $error = 1;
        $passwordErr = "Password is Required";
    }
}

$sql = "select * from users where email = '$email'";
$result = mysqli_query($db, $sql);
$emails_n = mysqli_num_rows($result);
if ($emails_n == 0 && !$error) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "insert into users (name, email, password) values ('" . $username . "','" . $email . "','" . $hash . "' )";
    $store_user = mysqli_query($db, $sql);
    if ($store_user) {
        die("User Created Successfully With ID: {$db->insert_id}");
    } else {
        die("An Error Occured During Creating User");
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>


    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

        <label for="username">name</label>
        <input id="username" type="text" name="username">
        <span class="error">* <?php echo $userNameErr ?></span>
        <br> <br>


        <label for="email">Email</label>
        <input id="email" type="text" name="email">
        <span class="error">*<?php echo $emailErr ?></span>
        <br> <br>

        <label for="password">Password</label>
        <input type="text" name="password">
        <span class="error">*<?php echo $passwordErr ?></span>
        <br> <br>

        <label for="cpassword">Confirm Password</label>
        <input type="text" name="cpassword">
        <span class="error">*<?php echo $cpasswordErr ?></span>
        <br> <br>

        <button type="submit">Submit</button>
    </form>
    <br><br>
    <a href="./login.php">Login</a>
    <br><br>
    <a href="./users.php">Users</a>


</body>

</html>