<?php
include "./db_connection.php";
include "./helpers.php";
checkSession($db);


$email = $password = "";
$emailErr = $passwordErr = "";
$error = 0;



if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (!empty($_POST['email'])) {
        $email = secureInput($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 1;
            $emailErr = "Please Entar a Correct Email";
        } else {
            $sql = "select * from users where email = '" . $email . "'";
            $result = $db->query($sql);
            $emails_n = mysqli_num_rows($result);
            if ($emails_n != 1) {
                $error = 1;
                $emailErr = "You Don't Have an Account, Please Sign Up";
            }
        }
    } else {
        $error = 1;
        $emailErr = "Please Enter Your Email";
    }
    if (!empty($_POST['password'])) {
        $password = secureInput($_POST['password']);

        $sql = "select * from users where email = '" . $email . "'";
        $result = $db->query($sql);
        $user_data = $result->fetch_assoc();
        $user_id = ($user_data['id']);
        $stored_hashed_password = ($user_data['password']);
        if (!password_verify($password, $stored_hashed_password)) {
            $error = 1;
            $passwordErr = "Incorrect Password";
        }
    }

    if (!$error) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $user_id;
        header("location: ./index.php");
    }
}


?>



<html>

<head>
    <title>login</title>
</head>

<body>
    <form action="" method="post">
        <label for="email">Email</label>
        <input id="email" type="text" name="email">
        <span><?php echo $emailErr ?></span>
        <br><br>
        <label for="password">Password</label>
        <input id="password" type="text" name="password">
        <span><?php echo $passwordErr ?></span>
        <br><br>
        <button type="submit" name="login">login</button>
    </form>

    <br><br>
    <a href="./register.php">Sign Up</a>
    <br><br>
    <a href="./users.php">Users</a>


</body>

</html>