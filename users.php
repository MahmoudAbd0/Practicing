<?php
include "./db_connection.php";
include "./helpers.php";
checkSession($db);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>

<body>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include "./db_connection.php";
            $sql = "select * from users";
            $users = mysqli_query($db, $sql);
            while ($row = mysqli_fetch_assoc($users)) {
            ?>

                <tr>
                    <td scope="row">
                        <?php
                        echo $row["id"];
                        ?>
                    </td>
                    <td scope="row">
                        <?php
                        echo $row["name"];
                        ?>
                    </td>
                    <td scope="row">
                        <?php
                        echo $row["email"];
                        ?>
                    </td>
                    <td>
                        <a href="./user.php?id=<?php echo $row["id"]; ?>">edit</a>
                        <a href="./delete_user.php?id=<?php echo $row["id"]; ?>">delete</a>


                    </td>
                </tr>
            <?php
            }
            ?>


        </tbody>
    </table>
    <br><br>
    <a href="./register.php">Sign Up</a>
    <br><br>
    <a href="./login.php">Login</a>


</body>

</html>