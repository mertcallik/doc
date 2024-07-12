<?php

include('../config.php');

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
session_start();

if (!isset($_POST['comment'])) {
    die("Error: Comment is not set");
}
$comment = $_POST['comment'];
$categoryId = $_POST['category'];
$comment = addslashes($comment);
if (!isset($_SESSION['id'])) {
    die("Error: User is not logged in");
}
$user_id = $_SESSION['id'];

$comment = $link->real_escape_string($comment);
$like = 0;
$id = uniqid(rand(1, 1000), true);
$date = date('Y-m-d H:i:s');

if (empty($comment)) {
    die("Error: Comment is empty");
} else {

    $sql = $link->prepare("INSERT INTO comments (comId, uid, comment, `like`, `catId`, `date`) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $id, $user_id, $comment, $like, $categoryId, $date);
    if ($sql->execute()) {
        echo "New record created successfully";
        $nsql = $link->prepare("UPDATE users SET level = level + 1 WHERE id = ?");
        $nsql->bind_param("s", $user_id);
        $nsql->execute();
        header('Location: ../index.php');
        exit();
    } else {
        echo "Error: " . $sql->error;
    }
}

$sql->close();
$link->close();
