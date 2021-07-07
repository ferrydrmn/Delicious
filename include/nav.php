<header>
    <div class="icon">
        <h1><a href="index.php">Delicious</a></h1>
    </div>
    <nav>
        <ul>
            <?php
                if(isset($_SESSION['id_pengguna'])){
                    if(isset($_SESSION['level'])){
                        if($_SESSION['level'] == 'admin' or $_SESSION['level'] == 'owner'){
                            echo "<li><a href='management.php'>MANAGEMENT</a></li>";
                        }else{
                            echo "<li><a href='index.php'>HOME</a></li>";
                            echo "<li><a href='management.php'>MANAGEMENT</a></li>";
                        }
                        echo "<li><a href='logout.php'>LOGOUT</a></li>";
                    }
                }else{
                    echo "<li><a href='index.php'>HOME</a></li>";
                    echo "<li><a href='login.php'>LOG IN</a></li>";
                }
            ?>
        </ul>
    </nav>
</header>