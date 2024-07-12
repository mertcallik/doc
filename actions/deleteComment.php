<?php

session_start();
include '../config.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}


$comId = $_GET['id'];

if (!isset($comId)) {
    header('Location: ../index.php');
    exit();
}


if ($link->connect_error) {
    die("Bağlantı başarısız: " . $link->connect_error);
}

$sql = $link->prepare("DELETE FROM comments WHERE comId = ?");
$sql->bind_param("s", $comId);
$sql->execute();


header('Location: ../index.php');
exit();
