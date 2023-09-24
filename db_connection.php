<?php
session_start();
$db = new mysqli("127.0.0.1", "root", "", "form", "3306");
if ($db->connect_errno) {
    die("Connection Error");
}
