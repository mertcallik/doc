<div class="right-sidebar">
    <h2 class="right-sidebar-title">Kategoriler</h2>
    <ul>
        <?php
        if ($link->connect_error) {
            die("Connection failed: " . $link->connect_error);
        }

        $sql = $link->prepare("SELECT * FROM categories ORDER BY `id` DESC LIMIT 10");

        $sql->execute();
        $result = $sql->get_result();

        while ($row = $result->fetch_assoc()) {
            echo '<li><a href="category.php?id=' . $row['id'] . '"> # ' . $row['name'] . '</a></li>';
        }
        ?>
    </ul>
</div>