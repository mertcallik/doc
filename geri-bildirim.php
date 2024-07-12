<?php

session_start(); // Session'ı başlatır

include('config.php'); // Veritabanı bağlantısını sayfaya dahil eder

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Eğer form gönderilmişse
    $head = $_POST['head']; // Formdan gelen başlık verisini alır
    $content = $_POST['content']; // Formdan gelen içerik verisini alır
    $uid = $_SESSION['id']; // Session'dan gelen kullanıcı id'sini alır

    $sql = $link->prepare("INSERT INTO feedback (head, content, uid) VALUES (?, ?, ?)"); // Veritabanına ekleme yapacak sorguyu hazırlar
    $sql->bind_param('sss', $head, $content, $uid); // Sorguya değişkenleri bağlar
    $sql->execute(); // Sorguyu çalıştırır

    header('Location: index.php'); // Kullanıcıyı anasayfaya yönlendirir
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geri Bildirim</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body>
    <?php
    include('includes/navbar.php'); 
    if (!$_SESSION['loggedin']) {   
        header('Location: giris.php'); 
    }
    ?>
    <div class="body-container">
        <div class="feedback-container">
            <h1>Bizlere Geri Bildirim Gönder</h1>
            <form action="" method="POST">
                <label for="">Başlık</label>
                <input type="text" name="head" id="">
                <label for="">İçerik</label>
                <textarea class="fb-content" name="content"></textarea>
                <button type="submit" class="sendPostButton">Gönder</button>
            </form>
        </div>
    </div>
</body>

</html>