<?php session_start();

include('config.php');

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doktorum.net</title>
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
            <form action="actions/sendComment.php" method="POST">
                <textarea id="ckeditor-classic" name="comment"></textarea>
                <select name="category" id="category">
                    <?php
                    $sql = $link->prepare("SELECT * FROM categories");

                    $sql->execute();
                    $result = $sql->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
                <button type="submit" class="sendPostButton">Gönder</button>
            </form>

            <div class="feed-contents">
                <?php
                $sql = $link->prepare("SELECT * FROM comments c inner join users u on c.uid = u.id ORDER BY `like` Desc");

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
        <?php include('includes/RightSidebar.php'); ?>
    </div>
    <script src="./assets/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="./assets/@ckeditor/form-editor.init.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.log("");
            });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.like-button').on('click', function() {
                var commentId = $(this).data('id');
                console.log(commentId);
                $.ajax({
                    url: 'actions/likeComment.php',
                    type: 'POST',
                    data: {
                        id: commentId
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('AJAX hatası: ' + error);
                    }
                });
            });
        });
    </script>

    <script>
        $('.comment-card').on('click', function() {
            var commentId = $(this).data('id');
            window.location.href = 'gonderiDetay.php?id=' + commentId;
        });
    </script>
</body>

</html>