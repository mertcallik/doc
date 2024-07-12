<?php

include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $uid = md5(uniqid() * rand(1, 1000));
    $name = $_POST['name']; 
    $mail = $_POST['email'];   
    $title = $_POST['title'];   
    $password = $_POST['password']; 
    $password2 = $_POST['password2'];  
    if ($password == $password2) { 
        $sql = "INSERT INTO users (name, mail, title, password,uid) VALUES ('$name', '$mail', '$title', '$password','$uid')";
        if (mysqli_query($link, $sql)) {  
            header('Location: ../giris.php');
        } else {
            header('Location: ../kayit.php');  
        }
    } else {  
        echo "Şifre uyuşmuyor";
    }
}
