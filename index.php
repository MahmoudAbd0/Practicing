<?php
include "./db_connection.php";
include "./helpers.php";


checkSession($db);
$user_data = fetch_user_data_by_session_id($db);
echo "<h1> Welcome </h1>";

?>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <a href="./logout.php">Log Out</a>
    <br><br>
    <a href="./user_account.php?id=<?php echo $user_data['id'] ?>">My Account</a>
</body>

</html>