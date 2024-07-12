<?php

include('config.php'); // Veritabanı bağlantısını sayfaya dahil eder
session_start(); // Session'ı başlatır
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $link->prepare("SELECT * FROM comments WHERE catId = ?");
    $sql->bind_param('i', $id);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
} else {
    header('Location: index.php');
}

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

    <div class="body-container">
        <?php include('includes/LeftSidebar.php'); ?>
        <div class="feed-deimos">
            <div class="feed-contents">
                <div class="feed-contents">
                    <?php
                    $sql = $link->prepare("SELECT * FROM comments c INNER JOIN users u ON c.uid = u.id WHERE catId = ? ORDER BY c.date ASC");
                    $sql->bind_param('i', $id);
                    $sql->execute();
                    $result = $sql->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="comment-card" data-id="' . $row['comId'] . '">';
                        echo '<div class="comment-card-header">';
                        echo '<div class="comment-card-header-left">';
                        echo '<img src="./assets/images/healthcare-medical-staff-concept-portrait-600nw-2281024823.png" alt="user" class="comment-card-user-image">';
                        echo '<div class="comment-card-user-info">';
                        echo '<h3 class="comment-card-user-name">' . $row['name'] . '</h3>';
                        echo '<p class="comment-card-user-date">' . $row['title'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-card-header-right">';
                        echo '<p class="comment-card-user-rating"><i class="fa-solid fa-turn-up"></i> ' . $row['level'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment-card-body">';
                        echo '<div class="comment-card-text">' . $row['comment'] . '</div>';
                        echo '</div>';
                        echo '<div class="comment-card-footer">';
                        echo '<div>';
                        echo '<p class="comment-card-like-count"><i class="fa-regular fa-heart like-button" data-id="' . $row['id'] . '"></i> ' . $row['like'] . ' Beğeni</p>';
                        echo '<p class="comment-card-comment-count"><i class="fa-regular fa-comment"></i> 12 Yorum</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php include('includes/RightSidebar.php'); ?>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#ckeditor-classic'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.like-button').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'adminActions/like.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
</body>

</html>