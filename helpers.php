<?php
function secureInput($input)
{

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


function fetch_user_data_by_session_id($db)
{
    $sql = "select * from users where id = '" . $_SESSION['id'] . "' ";
    $result = $db->query($sql);
    $user_data = $result->fetch_assoc();
    return $user_data;
}


function checkCureentUrlLogin()
{
    $cureentage = $_SERVER['REQUEST_URI'];
    return in_array($cureentage, ['/belal/login.php', '/belal/register.php']);
}

function checkSession($db)
{


    if (!empty($_SESSION['id'])) {
        $user_data = fetch_user_data_by_session_id($db);

        if ($_SESSION['id'] != $user_data['id']) {
            header("location: ./login.php");
        }
    } else {
        if (!checkCureentUrlLogin()) {
            header("location: ./login.php");
        }
    }
}





function validateImage($image)
{

    $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
    $imageName = uniquifyFileName($image, $imageExtension);
    $images_Storage = "uploads/categories_images/";
    $error = 0;
    $imageErr = false;


    if ($image['tmp_name'] == null) {
        $error = 1;
        $imageErr = "Image is Required";
        return ['path' => $images_Storage, 'error' => $error, 'imageErro' => $imageErr];
    }
    if (!isIamge($image['tmp_name'])) {
        $error = 1;
        $imageErr = "upload a correct imaage";
        return ['path' => $images_Storage, 'error' => $error, 'imageErro' => $imageErr, 'imageName' => $imageName];
    }


    if ($image['size'] > MB) {
        $error = 1;
        $imageErr = "The Maximum Size Allowed is 1MB";
        return ['path' => $images_Storage, 'error' => $error, 'imageErro' => $imageErr, 'imageName' => $imageName];
    }


    $allowedImageFormats = ['jpg', 'jpeg', 'png'];
    if (!isPermitevPath($imageExtension)) {
        $error = 1;
        $imageErr = "The Allowed Image Formats are only jpg, jpeg, and png";
        return ['path' => $images_Storage, 'error' => $error, 'imageErro' => $imageErr, 'imageName' => $imageName];
    }



    createDir($images_Storage);

    return ['path' => $images_Storage, 'error' => $error, 'imageErro' => $imageErr, 'imageName' => $imageName];
}

function isIamge($image)
{
    $mime_type = mime_content_type($image);
    $allowed_file_types = ['image/png', 'image/jpeg', 'application/pdf'];
    return in_array($mime_type, $allowed_file_types);
}

function isPermitevPath($imageExtension)
{
    $allowedImageFormats = ['jpg', 'jpeg', 'png'];
    return in_array($imageExtension, $allowedImageFormats);
}


function createDir($images_Storage)
{
    if (!is_dir($images_Storage)) {
        if (!mkdir($images_Storage, 0777, true)) {
            die("Failed to create directory: " . $images_Storage);
        }
        chmod($images_Storage, 0777);
    }
}


function uploadImage($image, $path)
{
    return move_uploaded_file($image, $path);
}

function uniquifyFileName($file, $fileExtension)
{
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $uniqueFileName = uniqid("", true) . "." . $fileExtension;
    return $uniqueFileName;
}

function sanitizeFileName($uniqueFileName)
{
    $sanitizedFilename = preg_replace("/[^A-Za-z0-9\-_\.]/", '', $uniqueFileName);
    return $sanitizedFilename;
}


function ValidateOnlyLtrsAndSpcs($name)
{
    return preg_match("/^[a-zA-Z-' ]*$/",  $name);
}


function validateMimeType($imageExtension, $allowedMimes)
{
    return in_array($imageExtension, $allowedMimes);
}


// function checkSession($db)
// {

//     print_r($_SESSION);
//     die();
//     if (!empty($_SESSION['id'])) {
//         $user_data = fetch_user_data_by_session_id($db);

//         if ($_SESSION['id'] != $user_data['id']) {
//             header("location: ./login.php");
//         } elseif (checkCureentUrlLogin()) {
//             print_r(checkCureentUrlLogin());
//             die();
//             header("location: ./index.php");
//         }
//     } else {
//         header("location: ./login.php");
//     }
// }
