<?php

include '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = $link->prepare("SELECT * FROM comments WHERE comId = ?");
    $sql->bind_param('i', $id);
    $sql->execute();
    $result = $sql->get_result();
    $row = $result->fetch_assoc();
    $comment = $row['comment'];
    $date = $row['date'];
} else {
    header('Location: ../admin.php');
}

if (isset($_POST['comment']) && isset($_POST['date'])) {
    $comment = $_POST['comment'];
    $date = $_POST['date'];

    $sql = $link->prepare("UPDATE comments SET comment = ?, date = ? WHERE comId = ?");
    $sql->bind_param('ssi', $comment, $date, $id);
    $sql->execute();
    header('Location: ../admin.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guncelle</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="edit-post-container">
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <textarea id="editor" name="comment"><?php echo $comment; ?></textarea>
            <input type="text" name="date" value="<?php echo $date; ?>">
            <button type="submit">Guncelle</button>
        </form>
    </div>

    <script src="../assets/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="../assets/@ckeditor/form-editor.init.js"></script>
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