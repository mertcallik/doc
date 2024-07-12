<?php
session_start();

include('../config.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $email = $_POST['email'];  
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE mail='$email' AND password='$password'"; 
    $result = mysqli_query($link, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);   

    if ($count == 1) {  
        $_SESSION['loggedin'] = true;   
        $_SESSION['name'] = $row['name']; 
        $_SESSION['title'] = $row['title']; 
        $_SESSION['mail'] = $row['mail']; 
        $_SESSION['id'] = $row['id']; 
        header('Location: ../index.php');   
    } else {   
        header('Location: ../giris.php');   
    }
}

?>