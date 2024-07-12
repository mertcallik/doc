<?php

include '../config.php';
if ($link->connect_error) {
    die("Bağlantı başarısız: " . $link->connect_error);
}

if (!isset($_POST['category'])) {
    die("Hata: Kategori adı alınamadı");
}

$category = $_POST['category'];

$sql = $link->prepare("INSERT INTO categories (name) VALUES (?)");
$sql->bind_param("s", $category);

if ($sql->execute()) {
    echo "Kategori başarıyla eklendi";
    header('Location: ../admin.php');
    exit();
} else {
    echo "Hata: " . $sql->error;
}
