<?php
    session_start();
    $koneksi = new PDO("mysql:host=localhost;dbname=toko_cahyadi", "root", "");
    if(!(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true)){
        header("location: Pages/loginPage.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>TOKO CAHAYA ABADI</title>
</head>

<body>
    <header id="index-header">
        <a href="index.php" class="logo" id="index-logo">
            <h1>Toko<span>Cahyadi</span></h1>
            <p>C a h a y a&nbsp;&nbsp;A b a d i</p>
        </a>
        <nav id="nav-index">
            <ul>
                <li><a href="#home">home</a></li>
                <li><a href="#product-section">product</a></li>
                <li><a href="#footer">about</a></li>
                <li><a href="#footer">contact</a></li>
                <li><a href="Pages/cart.php" class="view-cart"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li class="pp-wrapper">
                    <i class="fa-solid fa-user"></i>

                    <?php 
                    if($_SESSION['profile_pict'] != 'NoDirectory'){
                        $direktori = substr($_SESSION['profile_pict'], 3);
                        echo "<img src='".$direktori."'/>"; 
                    }
                    ?>
                </li>
            </ul>
        </nav>
        <div class="option">
            <a href="Pages/userSettings.php">User Settings</a>
            <a href="#">Favorite List</a>
            <a href="Pages/logout.php">Log Out</a>
        </div>
    </header>
    <div class="title-wrapper">
        <h1 class="title">OUR PRODUCTS</h1>
    </div>
    <section class="hero-container" id="home">
        <div class="welcome-wrapper fade-up">
            <?php
            
            $fullName = $_SESSION['first_name'] . $_SESSION['last_name'];
            $lengthName = strlen($fullName);
            if($lengthName > 10) echo "<h1 class='hello'>Hello, " . $_SESSION['first_name'] . "!</h1>";
            else echo "<h1 class='hello'>Hello, " . $_SESSION['first_name'] ." " . $_SESSION['last_name'] . "!</h1>";
            
            ?>
            <!-- <h1 class='hello'>Hello,  Ai Sha!</h1>" -->
            <h1 class="welcome-text">
                Feel Free to Unleash Your Shopping Desires
            </h1>
            <button class="btn" type="button">Shop Now</button>
        </div>
        <div class="hero-img-wrapper">
            <img src="Img/kebaya1.webp" alt="" class="hero-img fade-up"></img>
            <img src="Img/batik-pattern.png" class="batik-hero" alt="">
            <!-- <img src="Img/clouds.webp" alt="" class="hero-clouds" ></img> -->
        </div>
    </section>
    <h1 class="title arrivals">NEW ARRIVALS</h1>
    <section class="disc-product-wrapper">
        <div class="left">
            <img src="Img/product/mapple-red.jpg" alt="">
            <div class="detail-wrapper side">
                <h3>Mapple Red Batik</h3>
                <s>Rp 700.000</s>
                <p class="new-price">Rp 300.000</p>
            </div>
        </div>
        <div class="mid">
            <img src="Img/product/paket.jpg" alt="">
            <div class="detail-wrapper">
                <h3>Enchanted Forest Batik</h3>
                <p class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem quaerat possimus,
                    quocumvel
                    molestias labore repellendus deserunt temporibus fugiat eaque aperiam esse fuga debitis magni et
                    beatae
                    cumque corporis.</p>
                <s>Rp 1.500.000</s>
                <p class="new-price">Rp 800.000</p>
                <a>Discover More</a>
            </div>
        </div>
        <div class="right">
            <img src="Img/product/toba-lake.jpg" alt="">
            <div class="detail-wrapper side">
                <h3>Toba Lake Batik</h3>
                <s>Rp 400.000</s>
                <p class="new-price">Rp 150.000</p>
            </div>
        </div>
    </section>
    <div class="title-wrapper">
        <div id="product-section"></div>
        <h1 class="back-title">OUR PRODUCTS</h1>
        <h1 class="title">OUR PRODUCTS</h1>
    </div>
    <main class="product-list-container">
        <div class="product-wrapper">
            <?php 
            $stmt = $koneksi->query("SELECT * FROM product");
            while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <form class="product-form" action="Pages/cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id'];?>">
                <input type="hidden" name="product_stock" value="<?php echo $product['stock'];?>">
                <input type="hidden" name="product_name" value="<?php echo $product['product_name'];?>">
                <input type="hidden" name="product_price" value="<?php echo $product['product_price'];?>">
                <input type="hidden" name="product_pict" value="<?php echo $product['product_pict'];?>">
                <div class="card" id="<?php echo $product['product_id'];?>">
                    <div class="img-wrapper">
                        <img src="<?php echo $product['product_pict'];?>" alt="">
                        <div class="black-bar-product">
                            <?php 
                            if($product['stock'] < 0){
                                echo '
                                <button name="add_to_cart" type="button" class="addToCart" onclick="alert(\'Product is Out of Stock\')">
                                    <i class="fa-sharp fa-solid fa-cart-shopping"></i>
                                    <p>Add to cart</p>
                                </button> ';
                            } else{
                                echo '
                                <button name="add_to_cart" type="submit" class="addToCart">
                                    <i class="fa-sharp fa-solid fa-cart-shopping"></i>
                                    <p>Add to cart</p>
                                </button> ';
                            }
                            ?>
                            <i class="fa-sharp fa-solid fa-heart heart-icon"></i>
                        </div>
                    </div>
                    <div class="bottom-card">
                        <h3 class="product-name"><?php echo $product['product_name'];?>
                        </h3>
                        <p class="product">Rp
                            <span><?php echo number_format($product['product_price'], 0, ',', '.');?></span>
                        </p>
                        <a>More Details</a>
                    </div>
                </div>
            </form>
            <?php } ?>
        </div>
    </main>
    <footer id="footer">
        <div class="top">
            <div class="sosmed">
                <h3>Follow Us <div class="line"></div>
                </h3>
                <span class="insta">
                    <i class="fa-brands fa-instagram"></i>
                    <a href="#">Instagram</a>
                </span>
                <span class="fb">
                    <i class="fa-brands fa-facebook"></i>
                    <a href="#">Facebook</a>
                </span>
                <span class="twt">
                    <i class="fa-brands fa-twitter"></i>
                    <a href="#">Twitter</a>
                </span>
                <span class="tiktok">
                    <i class="fa-brands fa-tiktok"></i>
                    <a href="#">Tiktok</a>
                </span>
            </div>
            <div class="contact">
                <h3>Contact <div class="line"></div>
                </h3>
                <span class="email">
                    <i class="fa-solid fa-envelope"></i><a href="mailto:tokocahyadi@gmail.com">tokocahyadi@gmail.com</a>
                </span>
                <span class="phone">
                    <i class="fa-solid fa-phone"></i><a>+62 825 - 6121 - 3718</a>
                </span>
                <span class="alamat">
                    <i class="fa-solid fa-building"></i>
                    <a>Jl. Batik Pekalongan No. 10 C17, <br> Kabupaten Pekalongan, Jawa
                        Tengah</a>
                </span>
            </div>
            <div class="about">
                <h3>About Us <div class="line"></div>
                </h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit ea ducimus voluptatem cumque
                    quia amet
                    expedita inventore? Unde voluptatum ullam dolorem, nostrum tempora quibusdam architecto
                    consectetur
                    cupiditate eveniet placeat sed dolores harum quis sint suscipit, deleniti deserunt? Sit
                    officiis,
                    fugiat ipsam, possimus optio adipisci similique laborum quo dicta libero quam!</p>
            </div>
        </div>
        <p class="copy">Copyright &copy; <span id="year"></span> Toko Cahyadi All materials on this website are
            the
            property of our
            company. </p>
    </footer>
    <script src="Script/main.js"></script>
</body>

</html>