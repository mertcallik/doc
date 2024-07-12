<?php
session_start();

$id = $_GET['id'];

include('config.php');

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

$sql = $link->prepare("SELECT * FROM comments WHERE comId = ?");
$sql->bind_param("s", $id);
$sql->execute();
$result = $sql->get_result();

$row = $result->fetch_assoc();

$userSql = $link->prepare("SELECT * FROM users WHERE id = ?");
$userSql->bind_param("s", $row['uid']);
$userSql->execute();
$userResult = $userSql->get_result();


$userRow = $userResult->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>
        Gönderi : <?php echo $row['comId']; ?>
    </title>
</head>

<body>
    <?php include('includes/navbar.php'); ?>
    <div class="body-container">
        <?php include('includes/LeftSidebar.php'); ?>
        <div class="feed-deimos">
            <div class="feed-contents">
                <div class="comment-card" data-id="<?php echo $row['comId']; ?>">
                    <div class="comment-card-header">
                        <div class="comment-card-header-left">
                            <img src="./assets/images/healthcare-medical-staff-concept-portrait-600nw-2281024823.png" alt="user" class="comment-card-user-image">
                            <div class="comment-card-user-info">
                                <h3 class="comment-card-user-name"><?php echo $userRow['name']; ?></h3>
                                <p class="comment-card-user-date"><?php echo $userRow['title']; ?></p>
                            </div>
                        </div>
                        <div class="comment-card-header-right">
                            <p class="comment-card-user-rating"><i class="fa-solid fa-turn-up"></i> <?php echo $userRow['level']; ?></p>

                            <?php
                            if ($_SESSION['id'] == $row['uid']) {
                            ?>
                                <div class="comment-card-header-right">
                                    <a href="gonderiDuzenle.php?id=<?php echo $row['comId']; ?>" class="edit-button">
                                        <i class="fa-solid fa-edit"></i> Düzenle
                                    </a>
                                    <a href="actions/deleteComment.php?id=<?php echo $row['comId']; ?>" class="delete-button">
                                        <i class="fa-solid fa-trash"></i> Sil
                                    </a>
                                </div>
                            <?php
                            }
                            ?>



                        </div>
                    </div>
                    <div class="comment-card-body">
                        <div class="comment-card-text"><?php echo $row['comment']; ?></div>
                    </div>
                    <div class="comment-card-footer">
                        <div>
                            <form action="actions/likeComment.php" method="POST">
                                <input type="text" id="" name="postId" value="<?php echo $row['comId']; ?>" hidden>
                                <button>

                                    <?php
                                    $likeSql = $link->prepare("SELECT * FROM likedposts WHERE likePostId = ? AND likeUserId = ?");
                                    $likeSql->bind_param("ss", $row['comId'], $_SESSION['id']);
                                    $likeSql->execute();
                                    $likeResult = $likeSql->get_result();

                                    if ($likeResult->num_rows > 0) {
                                    ?>
                                        <i class="fa-solid fa-heart like-button"></i> <?php echo $row['like'] . " " . "Beğeni"  ?>
                                    <?php
                                    } else {
                                    ?>
                                        <i class="fa-regular fa-heart like-button"></i> <?php echo $row['like'] . " " . "Beğeni"  ?>
                                    <?php
                                    }
                                    ?>



                                </button>
                            </form>
                            <p class="comment-card-comment-count"><i class="fa-regular fa-comment"></i> 0 Yorum</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="./actions/sendUnderComment.php" method="POST" style="margin-top: 40px;">
                <input type="text" name="postId" value="<?php echo $row['comId']; ?>" hidden>
                <textarea id="ckeditor-classic" name="comment"></textarea>
                <button type="submit" class="sendPostButton">Gönder</button>
            </form>

            <div class="other-comments-section">
        
                <?php

                $underCommentSql = $link->prepare("SELECT * FROM under_comments WHERE postId = ?");
                $underCommentSql->bind_param("s", $row['comId']);
                $underCommentSql->execute();
                $underCommentResult = $underCommentSql->get_result();

                while ($underCommentRow = $underCommentResult->fetch_assoc()) {
                    $underUserSql = $link->prepare("SELECT * FROM users WHERE id = ?");
                    $underUserSql->bind_param("s", $underCommentRow['uId']);
                    $underUserSql->execute();
                    $underUserResult = $underUserSql->get_result();

                    $underUserRow = $underUserResult->fetch_assoc();

                ?>
                    <div class="comment-card">
                        <div class="comment-card-header">
                            <div class="comment-card-header-left">
                                <img src="./assets/images/healthcare-medical-staff-concept-portrait-600nw-2281024823.png" alt="user" class="comment-card-user-image">
                                <div class="comment-card-user-info">
                                    <h3 class="comment-card-user-name"><?php echo $underUserRow['name']; ?></h3>
                                    <p class="comment-card-user-date"><?php echo $underUserRow['title']; ?></p>
                                </div>
                            </div>
                            <div class="comment-card-header-right">
                                <p class="comment-card-user-rating"><i class="fa-solid fa-turn-up"></i> <?php echo $underUserRow['level']; ?></p>
                            </div>
                        </div>
                        <div class="comment-card-body">
                            <div class="comment-card-text"><?php echo $underCommentRow['uCom']; ?></div>
                        </div>
                    </div>
                <?php
                }
                

                ?>
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
</body>

</html>