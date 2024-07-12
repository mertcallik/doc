<?php

include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $link->prepare("DELETE FROM users WHERE id = ?");
    $sql->bind_param('i', $id);
    $sql->execute();
    header('Location: ../admin.php');
} else {
    header('Location: ../admin.php');
}

?>