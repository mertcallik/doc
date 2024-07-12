<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$gmail = $_POST['eposta'];
include '../config.php';

// Veritabanı sorgusunu gerçekleştirin
$query = "SELECT * FROM users WHERE mail='$gmail'";
$result = mysqli_query($link, $query);

if (!$result) {
    die('Veritabanı hatası: ' . mysqli_error($link));
}

$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($num_row >= 1) {
    $gideceksifre = $row['password'];

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        // Sunucu ayarları
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'afkanozdemir45@gmail.com';
        $mail->Password = 'vxln nwbk gfyo sysg';

        // Alıcı ve gönderici bilgileri
        $mail->setFrom('afkanozdemir45@gmail.com', 'doktorum.net');
        $mail->addAddress($gmail);

        // E-posta içeriği
        $mail->Subject = 'Hatirlatma Maili';
        $mail->Body = 'Şifreniz: ' . $gideceksifre;

        $mail->send();
        echo 'Gönderildi';
    } catch (Exception $e) {
        echo 'Gönderilemedi. Mailer Hatası: ' . $mail->ErrorInfo;
    }
} else {
    echo 'Bu eposta adresiyle eşleşen kullanıcı bulunamadı.';
}
