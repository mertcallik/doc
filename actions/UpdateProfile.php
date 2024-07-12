<?php

include '../config.php';

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

session_start();

if (!isset($_SESSION['id'])) {
    die("Error: User is not logged in");
}
$user_id = $_SESSION['id'];

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['title'])) {
    die("Error: Name, email, or title is not set");
}

$name = $_POST['name'];
$email = $_POST['email'];
$title = $_POST['title'];

$name = $link->real_escape_string($name);
$email = $link->real_escape_string($email);
$title = $link->real_escape_string($title);

$sql = $link->prepare("UPDATE users SET name = ?, mail = ?, title = ? WHERE id = ?");
$sql->bind_param("ssss", $name, $email, $title, $user_id);

if ($sql->execute()) {
    echo "Record updated successfully";
    header('Location: ../UserProfile.php?' . $user_id);
    exit();
} else {
    echo "Error: " . $sql->error;
}
