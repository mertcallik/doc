<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt ol | Doktorum.net</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include('includes/navbar.php'); ?>
    <div class="register-container">
        <div class="register-form">
            <h1>Hemen Kayıt Ol</h1>
            <p>Olan Biten Doktorum.net'de</p>
            <form action="./actions/registerAction.php" method="POST">
                <label>Adınız & Soyadınız</label>
                <input required maxlength="30" class="primary-input mb-5" type="text" name="name" placeholder="Ad Soyad">
                <label>Mail Adresiniz</label>
                <input required maxlength="30" class="primary-input mb-5" type="email" name="email" placeholder="E-posta">
                <label>Ünvanınız</label>
                <select required class="primary-input mb-5" name="title" id="title">
                    <option value="pratisyenD">Pratisyen Doktor</option>
                    <option value="uzmanD">Uzman Doktor</option>
                    <option value="operatorD">Operatör Doktor</option>
                    <option value="yardimciD">Yardımcı doçent</option>
                    <option value="docent">Doçent</option>
                    <option value="profesor">Profesör</option>
                    <option value="ordinaryus">Ordinaryüs </option>
                    <option value="stajyer">Stajyer</option>
                    <option value="uye">Üye</option>
                    <option value="diger">Diğer</option>
                </select>
                <label>Şifreniz</label>
                <input required class="primary-input mb-5" type="password" name="password" placeholder="Şifre">
                <label>Tekrar Şifreniz</label>
                <input required class="primary-input mb-5" type="password" name="password2" placeholder="Şifre Tekrar">
                <a href="./giris.php" class="mb-5">Zaten bir hesabınız var mı? Giriş yapın.</a>
                <button type="submit" class="secondary-button">Kayıt Ol</button>
            </form>

        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('form').submit(function(e) {
            e.preventDefault();
            var password = $('input[name="password"]').val(); 
            var password2 = $('input[name="password2"]').val();
            var email = $('input[name="email"]').val(); 
            if (password !== password2) {
                Swal.fire({ 
                    icon: 'error',  
                    title: 'Şifre eşleşmiyor!', 
                    text: 'Lütfen şifrelerinizi kontrol edin.',
                    confirmButtonText: 'Tamam' 
                });
                return false; 
            }
            if (password.length < 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Şifre çok kısa!',  
                    text: 'Şifreniz en az 8 karakter olmalıdır.',  
                    confirmButtonText: 'Tamam'
                });
                return false;
            }
            if (!email.includes('@')) {
                Swal.fire({
                    icon: 'error',  // Hata ikonu
                    title: 'Geçersiz e-posta adresi!', 
                    text: 'Lütfen geçerli bir e-posta adresi girin.',  
                    confirmButtonText: 'Tamam' 
                });
                return false; 
            }
            this.submit(); 
        });
    });
</script>

</html>