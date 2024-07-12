<?php
session_start();

include '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

if (isset($_POST['comment'])) {
    if (isset($_SESSION['id']) && isset($_POST['postId']) && isset($_POST['comment'])) {
        $uId = $_SESSION['id'];
        $postId = $_POST['postId'];
        $uCom = $_POST['comment'];
        $date = date('Y-m-d H:i:s');

        $sql = $link->prepare("INSERT INTO under_comments (uId, postId, uCom, date) VALUES (?, ?, ?, ?)");
        $sql->bind_param("iiss", $uId, $postId, $uCom, $date);

        if ($sql->execute()) {
            header("Location: ../gonderiDetay.php?id=$postId");
            exit();
        } else {
            echo "Hata: " . $sql->error;
        }
    } else {
        echo "Form verileri eksik.";
    }
} else {
    echo "Form gönderilmedi.";
}
?>