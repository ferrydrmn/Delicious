<?php
    session_start();
    include ('include/class/connect.php');
    include ('include/class/product.php');
    include ('include/class/photo.php');
    include ('include/class/rating.php');
?>

<?php
    $product = new Product();
    if(isset($_GET['id_produk'])){
        $id_produk = $_GET['id_produk'];
        $resultProduk = $product->showSingleProduct($id_produk);
        if($resultProduk == false){
            header('location:index.php');
        }
        if($resultProduk['status'] == 'nonaktif'){
            if(isset($_SESSION['id_pengguna'])){
                if($_SESSION['level'] != 'admin' or $_SESSION['level'] != 'owner'){
                    header('location:index.php');
                }
            }
        }
    }else{
        header('location:index.php');
    }
?>

<?php
    $review = new Rating();
    if(isset($_POST['submit'])){
        $ratingProduk = $_POST['rating'];
        $komentar = $_POST['komentar'];
        if(isset($_SESSION['id_pengguna'])){
            $id_pengguna = $_SESSION['id_pengguna'];
        }else{
            header('location:index.php');
        }
        $queryKomentar = $review->insertReview($id_produk,$id_pengguna,$ratingProduk,$komentar);
        foreach($_POST as $key=>$values){
            $_POST[$key] = NULL;
        }
    }
?>

<?php
    $reviewProduk = $review->review($id_produk);
    if($reviewProduk == false){
        $rating = 0;
    }else{
        $rating = $review->avgRating($id_produk);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include ('include/head.php') ?>
    <link rel="stylesheet" href="style/management-data.css" type="text/css">
    <link rel="stylesheet" href="style/slide.css" type="text/css">
    <link rel="stylesheet" href="style/detail.css" type="text/css">
    <title>Delicious - Informasi Makanan</title>
</head>
<body>
    <?php include ('include/nav.php') ?>
    <main>
    <div class="main-container">
            <h1 class="title">Informasi Produk</h1>
            <div class="management-button-main-container">
            </div>
            <div class="sub-container" style="width: 75%;">
                <h3 class="sub-title"><?php echo $resultProduk['nama_produk'] ?></h3>
                <div class="insert-form">
                <div class="slideshow-container">
                    <?php
                        $photo = new Photo();
                        $nomor = 1; 
                        $resultFoto = $photo->showAllPhoto($id_produk);
                        foreach($resultFoto as $fotoProduk):
                    ?>
                        <!-- Full-width images with number and caption text -->
                        <div class="mySlides fade">
                        <div class="numbertext"><?php echo $nomor ?> / 3</div>
                        <img src="<?php echo $fotoProduk ?>" style="width: 500px; height: 500px; object-fit: cover; border-radius: 10px;">
                        </div>
                        <?php $nomor ++; ?>    
                    <?php  endforeach ?>
                     
                    <!-- Next and previous buttons -->
                    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <br>

                    <!-- The dots/circles -->
                    <div style="text-align:center">
                    <span class="dot" onclick="currentSlide(1)"></span>
                    <span class="dot" onclick="currentSlide(2)"></span>
                    <span class="dot" onclick="currentSlide(3)"></span>
                    </div>

                    <div class="rating-container">
                        <h3>Rating:</h3>
                        <?php if($reviewProduk == false): ?>
                            <p>Belum ada rating yang diberikan customer.</p>
                        <?php else: ?>
                        <div class="rating">
                            <?php for($i = 1; $i <= $rating; $i++): ?>
                                <img src="pictures/star.png" width="5%;">
                            <?php endfor ?>
                        </div>
                        <p><?php echo number_format((float)$rating, 2, '.', ''); ?>/5.00</p>
                        <?php endif ?>
                    </div>

                    <hr style="margin: 15px 0;">

                    <div class="product-content">
                        <h3>Harga</h3>
                        <p><b>Rp. <?php echo number_format($resultProduk['harga'] , 0, ',', '.') ?>/sajian</b></p>
                    </div>

                    <hr style="margin: 15px 0;">

                    <div class="product-content">
                        <h3>Jenis Produk</h3>
                        <p><?php echo ucfirst($resultProduk['jenis_produk']) ?> </p>
                    </div>      

                    <hr style="margin: 15px 0;">

                    <div class="product-content">
                        <h3>Deskripsi</h3>
                        <p><?php echo nl2br($resultProduk['deskripsi']) ?></p>
                    </div>
                    
                    <?php if(isset($_SESSION['id_pengguna'])): ?>
                        <?php if($_SESSION['level'] != 'admin' and $_SESSION['level'] !='owner' and $_SESSION['level'] !='cashier'): ?>
                            <hr style="margin: 15px 0;">  
                            <div class="product-content">
                                <h3>Berikan Review:</h3>
                                <div class="coment-container">
                                    <form action="" method="POST">
                                        <label for="rating">Rating:</label>
                                        <select id="rating" name="rating" required>
                                            <?php for($i=5; $i>0; $i--): ?>
                                            <option value =<?php echo $i ?>><?php echo $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                        <h6><label for="komentar">Komentar:</label></h6>
                                        <textarea id="komentar" class="textArea" name="komentar" rows="4" required></textarea>
                                        <div class="submit-button">
                                            <input type="submit" value="Submit" name="submit">
                                        </div>
                                    </form>
                                </div>
                            <?php endif ?>
                        <?php endif ?>


                        <hr style="margin: 15px 0;">
                        <?php if($reviewProduk == false): ?>
                            <p>Belum ada review yang diberikan customer!</p>
                        <?php else: ?>
                            <div class="product-content">
                                <h3 style="font-size: 20px;">Review Pelanggan:</h3>
                                <?php foreach($reviewProduk as $resultReviewProduk): ?>
                                    <?php
                                        $id_pengguna_komentar =  $resultReviewProduk['id_pengguna'];
                                        $infoPengguna = $review->getUserInformationComment($id_pengguna_komentar);
                                    ?>
                                    <div class="comment-container">
                                        <div class="comment-profile">
                                            <div class="block-rating"><img src="<?php echo $infoPengguna['foto_profil'] ?>" alt="Foto Profil" style="width: 44px; height: 44px; border-radius: 10px; object-fit: cover;"></div>
                                            <div class="block-rating"><h5><?php echo ucfirst($infoPengguna['nama']) ?></h5></div>
                                            <div class="block-rating"><p>memberikan</p></div>
                                            <div class="block-rating">
                                                <?php for($i=1; $i<=$resultReviewProduk['rating']; $i++): ?>
                                                    <img src="pictures/star.png" width="32px" >
                                                <?php endfor ?>
                                            </div>
                                            
                                        </div>
                                        <div class="block-rating"><p><?php echo $resultReviewProduk['tanggal'] ?></div>
                                        <div class="comment-content"> 
                                            <p><?php echo nl2br($resultReviewProduk['komentar']) ?></p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include ('include/footer.php')?>
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
        showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
        showSlides(slideIndex = n);
        }

        function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        }
    </script>
</body>
</html>