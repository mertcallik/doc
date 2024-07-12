<?php

include '../config.php';
session_start();

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

if (!isset($_POST['postId'])) {
    die("Hata: postId değeri alınamadı");
}
$comId = $_POST['postId'];

if ($link->connect_error) {
    die("Bağlantı başarısız: " . $link->connect_error);
}

$sql = $link->prepare("SELECT * FROM likedposts WHERE likePostId = ? AND likeUserId = ?");
$sql->bind_param("ss", $comId, $user_id);

$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $sql = $link->prepare("DELETE FROM likedposts WHERE likePostId = ? AND likeUserId = ?");
    $sql->bind_param("ss", $comId, $user_id);
    $sql->execute();

    $sql = $link->prepare("UPDATE comments SET `like` = `like` - 1 WHERE comId = ?");
    $sql->bind_param("s", $comId);
    $sql->execute();

    header("Location: ../gonderiDetay.php?id=" . $comId);
} else {
    $sql = $link->prepare("INSERT INTO likedposts (likePostId, likeUserId) VALUES (?, ?)");
    $sql->bind_param("ss", $comId, $user_id);
    $sql->execute();

    $sql = $link->prepare("UPDATE comments SET `like` = `like` + 1 WHERE comId = ?");
    $sql->bind_param("s", $comId);
    $sql->execute();
    header("Location: ../gonderiDetay.php?id=" . $comId);
}
