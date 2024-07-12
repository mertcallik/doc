<?php

session_start();
include '../config.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['id'];
$sql = $link->prepare("SELECT * FROM users WHERE id = ?");
$sql->bind_param("s", $user_id);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();


if (isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $photoName = $photo['name'];
    $photoTmpName = $photo['tmp_name'];
    $photoSize = $photo['size'];
    $photoError = $photo['error'];
    $photoType = $photo['type'];

    $photoExt = explode('.', $photoName);
    $photoActualExt = strtolower(end($photoExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($photoActualExt, $allowed)) {
        if ($photoError === 0) {
            if ($photoSize < 1000000) {
                $photoNameNew = uniqid('', true) . "." . $photoActualExt;
                $photoDestination = '../upload/userProfiles/' . $photoNameNew;
                move_uploaded_file($photoTmpName, $photoDestination);

                $sql = $link->prepare("UPDATE users SET photo = ? WHERE id = ?");
                $sql->bind_param("ss", $photoNameNew, $user_id);
                $sql->execute();

                header('Location: ../UserProfile.php?id=' . $user_id);
                exit();
            } else {
                echo "Dosya boyutu çok büyük";
            }
        } else {
            echo "Dosya yüklenirken hata oluştu";
        }
    } else {
        echo "Bu dosya türü desteklenmiyor";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="editProfilePhoto.php" method="post" enctype="multipart/form-data">
        <input type="file" name="photo" id="photo">
        <button type="submit">Gönder</button>
    </form>

</body>

</html>