<?php

session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['id'];

if ($link->connect_error) {
    die("Bağlantı başarısız: " . $link->connect_error);
}

$sql = $link->prepare("SELECT * FROM users WHERE id = ?");
$sql->bind_param("s", $user_id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows == 0) {
    die("Kullanıcı bulunamadı");
}

$user = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
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
        <?php include('includes/LeftSidebar.php'); ?>
        <div class="profile-content">
            <div class="profile-header">
                <div class="profile-header-left">
                    <?php
                    $photo = $user['photo'];
                    if ($photo) {
                        echo '<a href="./actions/editProfilePhoto.php?id=' . $user_id . '">';
                        echo '<img src="./upload/userProfiles/' . $photo . '" alt="user" class="profile-header-image">';
                        echo '</a>';
                    } else {
                        echo '<a href="./actions/editProfilePhoto.php?id=' . $user_id . '">';
                        echo '<img src="assets/images/default-user.png" alt="user" class="profile-header-image">';
                        echo '</a>';
                    }
                    ?>
                </div>
                <div class="profile-header-right">
                    <h1 class="profile-header-name">
                        <?php
                        echo htmlspecialchars($user['name']);
                        ?>
                    </h1>
                    <p class="profile-header-title">
                        <?php
                        echo htmlspecialchars($user['title']);
                        ?>
                    </p>
                </div>
            </div>
            <div class="profile-body">
                <form action="actions/updateProfile.php" method="POST">
                    <div class="form-g">
                        <label>Adınız & Soyadınız</label>
                        <input required maxlength="30" class="primary-input mb-5" value="<?php echo htmlspecialchars($user['name']); ?>" type="text" name="name" placeholder="Ad Soyad">
                    </div>
                    <div class="form-g">
                        <label>Mail Adresiniz</label>
                        <input required maxlength="30" class="primary-input mb-5" value="<?php echo htmlspecialchars($user['mail']); ?>" type="email" name="email" placeholder="E-posta">
                    </div>
                    <div class="form-g">
                        <label>Ünvanınız</label>
                        <select required class="primary-input mb-5" name="title" id="title">
                            <option value="pratisyenD" <?php echo ($user['title'] == 'pratisyenD') ? 'selected' : ''; ?>>Pratisyen Doktor</option>
                            <option value="uzmanD" <?php echo ($user['title'] == 'uzmanD') ? 'selected' : ''; ?>>Uzman Doktor</option>
                            <option value="operatorD" <?php echo ($user['title'] == 'operatorD') ? 'selected' : ''; ?>>Operatör Doktor</option>
                            <option value="yardimciD" <?php echo ($user['title'] == 'yardimciD') ? 'selected' : ''; ?>>Yardımcı Doçent</option>
                            <option value="docent" <?php echo ($user['title'] == 'docent') ? 'selected' : ''; ?>>Doçent</option>
                            <option value="profesor" <?php echo ($user['title'] == 'profesor') ? 'selected' : ''; ?>>Profesör</option>
                            <option value="ordinaryus" <?php echo ($user['title'] == 'ordinaryus') ? 'selected' : ''; ?>>Ordinaryüs </option>
                            <option value="stajyer" <?php echo ($user['title'] == 'stajyer') ? 'selected' : ''; ?>>Stajyer</option>
                            <option value="uye" <?php echo ($user['title'] == 'uye') ? 'selected' : ''; ?>>Üye</option>
                            <option value="diger" <?php echo ($user['title'] == 'diger') ? 'selected' : ''; ?>>Diğer</option>
                        </select>
                    </div>
                    <button type="submit" class="secondary-button">Profilimi Güncelle</button>
                </form>
            </div>
            <div class="feed-deimos">
                <div class="feed-contents">
                    <?php
                    $sql = $link->prepare("SELECT * FROM comments WHERE uid = ? ORDER BY `date` ASC");
                    $sql->bind_param("s", $user_id);
                    $sql->execute();
                    $result = $sql->get_result();
                    $usql = $link->prepare("SELECT * FROM users WHERE id = ?");
                    $usql->bind_param("s", $user_id);
                    $usql->execute();
                    $uresult = $usql->get_result();
                    $uRow = $uresult->fetch_assoc();
                    while ($row = $result->fetch_assoc()) {
                        echo '<a href="./gonderiDetay.php?id=' . $row['comId'] . '" class="comment-card" data-id="' . $row['comId'] . '">';
                        echo '<div class="comment-card-header">';
                        echo '<div class="comment-card-header-left">';
                        echo '<img src="' . $uRow['photo'] . '" alt="user" class="comment-card-user-image">';
                        echo '<div class="comment-card-user-info">';
                        echo '<h3 class="comment-card-user-name">' . $uRow['name'] . '</h3>';
                        echo '<p class="comment-card-user-date">' . $uRow['title'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-card-header-right">';
                        echo '<p class="comment-card-user-rating"><i class="fa-solid fa-turn-up"></i> ' . $uRow['level'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-card-body">';
                        echo '<div class="comment-card-text">' . $row['comment'] . '</div>';
                        echo '</div>';
                        echo '<div class="comment-card-footer">';
                        echo '</div>';
                        echo '</a>'; 
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php include('includes/RightSidebar.php'); ?>
    </div>
    </div>
</body>

</html>