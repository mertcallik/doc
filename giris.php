<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş | Doktorum.net</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include('includes/navbar.php'); ?>
    <div class="login-container">
        <div class="login-form">
            <h1>Hemen Giriş Yap</h1>
            <p>Olan Biten Doktorum.net'de</p>
            <form action="./actions/loginAction.php" method="POST">
                <input class="primary-input mb-5" type="text" name="email" placeholder="E-posta">
                <input class="primary-input mb-5" type="password" name="password" placeholder="Şifre">
                <a href="./sifremiUnuttum.php" class="mb-5">Şifrenizi mi unuttunuz?</a>
                <a href="./kayit.php" class="mb-5">Hesabınız yok mu? Kayıt olun.</a>
                <button type="submit" class="secondary-button">Giriş Yap</button>
            </form>
        </div>
    </div>
</body>

</html>