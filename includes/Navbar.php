<div class="navbar-container">
    <div class="logo-container">
        <a href="index.php">Doktorum.net</a>
    </div>
    <div class="nav-items">
        <ul>
            <li><a href="index.php">Anasayfa</a></li>
            <li>
                <?php

                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                    echo '<a href="UserProfile.php?uId=' . $_SESSION['id'] . '">' . $_SESSION['name'] . '</a>';
                } else {
                    echo '<a href="giris.php">Giriş Yap</a>';
                }
                ?>
            </li>

            <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                echo '<li><a href="actions/logoutAction.php">Çıkış Yap</a></li>';
            }
            ?>
        </ul>
    </div>
</div>