<?php

include '../config.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Düzenle</title>
    <link rel="stylesheet" href="../assets/styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = $link->prepare("SELECT * FROM categories WHERE id = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_assoc();
        $category = $row['name'];
    } else {
        header('Location: ../admin.php');
    }

    if (isset($_POST['category'])) {
        $category = $_POST['category'];

        $sql = $link->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $sql->bind_param('si', $category, $id);
        $sql->execute();
        header('Location: ../admin.php');
    }
    ?>
    <div class="edit-category-container">
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="category" value="<?php echo $category; ?>">
            <button type="submit">Guncelle</button>
        </form>
    </div>
</body>

</html>