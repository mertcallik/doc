<!-- Admin.php -->

<?php
include 'config.php';
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['id'];
$sql = $link->prepare("SELECT * FROM users WHERE id = ?");
$sql->bind_param("s", $user_id);
$sql->execute();
$result = $sql->get_result();
$user = $result->fetch_assoc();
if ($user['role'] != 'admin') {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php
    include('includes/navbar.php'); // Navbar'ı sayfaya dahil eder
    if (!$_SESSION['loggedin']) {   // Eğer kullanıcı giriş yapmamışsa
        header('Location: giris.php');  // Kullanıcıyı giriş sayfasına yönlendirir
    }
    ?>
    <div class="admin-content">
        <div class="content-box-head">
            <h1>
                Yönetim Paneli
            </h1>
        </div>
        <div class="content-box-container">
            <div class="content-box">
                <h2>
                    Toplam Kullanıcı :
                    <?php
                    $sql = $link->prepare("SELECT COUNT(*) as total FROM users"); // Kullanıcı sayısını veritabanından çeker
                    $sql->execute();    // Sorguyu çalıştırır
                    $result = $sql->get_result();   // Sorgudan dönen sonucu alır
                    $row = $result->fetch_assoc();  // Sonucu dizi olarak alır
                    echo $row['total']; // Sonucun içindeki 'total' değerini ekrana yazdırır
                    ?>
                </h2>
            </div>

            <div class="content-box">
                <h2>
                    Toplam Gönderi :
                    <?php
                    $sql = $link->prepare("SELECT COUNT(*) as total FROM comments");    // Gönderi sayısını veritabanından çeker
                    $sql->execute();    // Sorguyu çalıştırır
                    $result = $sql->get_result();   // Sorgudan dönen sonucu alır
                    $row = $result->fetch_assoc();  // Sonucu dizi olarak alır
                    echo $row['total']; // Sonucun içindeki 'total' değerini ekrana yazdırır
                    ?>
                </h2>
            </div>

            <div class="content-box">
                <h2>
                    Toplam Yorum :
                    <?php
                    $sql = $link->prepare("SELECT COUNT(*) as total FROM under_comments"); 
                    $sql->execute();  
                    $result = $sql->get_result(); 
                    $row = $result->fetch_assoc();  
                    echo $row['total'];
                    ?>
                </h2>
            </div>

            <div class="content-box">
                <h2>
                    Toplam Beğeni :
                    <?php
                    $sql = $link->prepare("SELECT COUNT(*) as total FROM likedposts"); 
                    $sql->execute();   
                    $result = $sql->get_result(); 
                    $row = $result->fetch_assoc(); 
                    echo $row['total'];
                    ?>
                </h2>
            </div>
        </div>
        
        <div class="content-box-2-group">
            <div class="content-box">
                <h2>
                    Kategoriler
                </h2>
                <form action="./adminActions/addCategory.php" method="POST">
                    <input type="text" name="category" placeholder="Kategori Adı">
                    <button type="submit">Ekle</button>
                </form>
                <table>
                    <tr>
                        <th>Kategori Adı</th>
                        <th>Güncelleme İşlemi</th>
                        <th>Silme İşlemi</th>
                    </tr>
                    <?php
                    $sql = $link->prepare("SELECT * FROM categories");
                    $sql->execute();
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td><a href="./adminActions/editCategory.php?id=' . $row['id'] . '">Güncelle</a></td>';
                        echo '<td><a href="./adminActions/deleteCategory.php?id=' . $row['id'] . '">Sil</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="content-box">
                <h2>
                    Gönderiler
                </h2>

                <table>
                    <tr>
                        <th>ID</th>
                        <th>Yorum</th>
                        <th>Görüntüle</th>
                        <th>Güncelleme İşlemi</th>
                        <th>Silme İşlemi</th>
                    </tr>
                    <?php
                    $sql = $link->prepare("SELECT * FROM comments");
                    $sql->execute();
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['comId'] . '</td>';
                        echo '<td>' . (strlen($row['comment']) > 60 ? substr($row['comment'], 0, 20) . '...' : $row['comment']) . '</td>';
                        echo '<td><a href="gonderiDetay.php?id=' . $row['comId'] . '">Görüntüle</a></td>';
                        echo '<td><a href="./adminActions/editPost.php?id=' . $row['comId'] . '">Güncelle</a></td>';
                        echo '<td><a href="./adminActions/deletePost.php?id=' . $row['comId'] . '">Sil</a></td>';
                        echo '</tr>';
                    }
                    ?>
                </table>


            </div>
        </div>
        <div class="show-all-users-container">
            <h2>
                Kullanıcılar
            </h2>
            <table>
                <tr>
                    <th>Ad</th>
                    <th>E-posta</th>
                    <th>Ünvan</th>
                    <th>Yetki</th>
                    <th>İşlem</th>
                </tr>
                <?php
                $sql = $link->prepare("SELECT * FROM users");
                $sql->execute();
                $result = $sql->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['mail'] . '</td>';
                    echo '<td>' . $row['title'] . '</td>';
                    echo '<td>' . $row['level'] . '</td>';
                    echo '<td><a href="./adminActions/deleteUser.php?id=' . $row['id'] . '">Sil</a></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

        <div class="show-all-feedbacks-container">
            <h2>
                Geri Bildirimler
            </h2>
            <table>
                <tr>
                    <th>Ad</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Mesaj</th>
                </tr>
                <?php
                $sql = $link->prepare("SELECT * FROM feedback f inner join users u on f.uId = u.id");
                $sql->execute();
                $result = $sql->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['mail'] . '</td>';
                    echo '<td>' . $row['head'] . '</td>';
                    echo '<td>' . $row['content'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>

    </div>
</body>

</html>