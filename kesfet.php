<?php
Session_start(); // Session'ı başlatır
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <div class="discover-container">
        <div class="dicover-heading">
            <h1>Doktorum ile keşfet!</h1>
        </div>

        <div class="discover-content">
            <a href="#" class="discover-card">
                <i class="fa-solid fa-book-open discover-card-icon"></i>
                <div class="discover-card-content">
                    <h2 class="discover-card-title">Makale & İnceleme</h2>
                    <p class="discover-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt ultricies. Nullam nec purus nec nunc tincidunt ultricies.</p>

                </div>
            </a>
            <a href="#" class="discover-card">
                <i class="fa-solid fa-book discover-card-icon"></i>
                <div class="discover-card-content">
                    <h2 class="discover-card-title">Etkinlik & İlan</h2>
                    <p class="discover-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt ultricies. Nullam nec purus nec nunc tincidunt ultricies.</p>

                </div>
            </a>
            <a href="#" class="discover-card">
                <i class="fa-solid fa-book discover-card-icon"></i>
                <div class="discover-card-content">
                    <h2 class="discover-card-title">Soru & Cevap</h2>
                    <p class="discover-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt ultricies. Nullam nec purus nec nunc tincidunt ultricies.</p>

                </div>
            </a>
            <a href="#" class="discover-card">
                <i class="fa-solid fa-book discover-card-icon"></i>
                <div class="discover-card-content">
                    <h2 class="discover-card-title">Son İçerikler</h2>
                    <p class="discover-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc tincidunt ultr
                </div>
            </a>
        </div>
</body>

</html>