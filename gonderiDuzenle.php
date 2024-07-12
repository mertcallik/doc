<?php
session_start();
include 'config.php';

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

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$comId = $_GET['id'];

$sql = $link->prepare("SELECT * FROM comments WHERE comId = ?");
$sql->bind_param("s", $comId);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

if ($row['uid'] != $user_id) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $sql = $link->prepare("UPDATE comments SET comment = ? WHERE comId = ?");
    $sql->bind_param("ss", $comment, $comId);
    $sql->execute();
    header('Location: gonderiDetay.php?id=' . $comId);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Düzenle : <?php echo $row['comId']; ?>
    </title>
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
            <form action="" method="post">
                <textarea id="ckeditor-classic" name="comment"><?php echo $row['comment']; ?></textarea>
                <button type="submit" class="sendPostButton">Gönder</button>
            </form>
        </div>

        <?php include('includes/RightSidebar.php'); ?>
    </div>
</body>
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