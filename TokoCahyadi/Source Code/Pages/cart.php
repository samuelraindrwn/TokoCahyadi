<?php
    

    session_start();

    $koneksi = new PDO("mysql:host=localhost;dbname=toko_cahyadi", "root", "");

    if(!(isset($_SESSION['isLogged']) && $_SESSION['isLogged'] == true)){
        header("location: loginPage.php");
        exit();
    }

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    function checkIfItemExistInCart($productId) {
        foreach ($_SESSION['cart'] as $product) {
            if ($product['product_id'] == $productId) {
                return true;
            }
        }
        return false;
    }

    function isUnik($id, $tableName, $columnName) {
        $query = $GLOBALS['koneksi']->prepare("SELECT * FROM $tableName WHERE $columnName = ?");
        $query->execute([$id]); 
        if ($query->rowCount() > 0) return false; else return true; 
    } 

    function generateUUID() {
        $uuid = uniqid('', true);
        $hash = sha1($uuid);
        return $hash;
    }
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        header('Location: cart.php');
        
        if (isset($_POST['buy'])) {
            $isUnique = false;
            while (!$isUnique) {
                $transaksiId = 'TID' . substr(generateUUID(), 0, 7);
                $isUnique = isUnik($transaksiId, 'transaksi', 'transaksi_id');
            }
    
            $tanggal = date('Y-m-d');
            $address = $_POST['address'];
            $city = $_POST['city'];
            $region = $_POST['region'];
            $postCode = $_POST['postal_code'];
            $totalPrice = preg_replace('/\D/', '', $_POST['money']);
            $userId = $_SESSION['user_id'];
            
            $queryToTransaksi = 
            "INSERT INTO transaksi 
            (
                transaksi_id, user_id, transaksi_date, shipping_address, cust_city, cust_region, post_code, total_price
            ) 
            VALUES (?,?,?,?,?,?,?,?)
            "; 
            
            $result = $koneksi->prepare($queryToTransaksi);
            $result->execute([$transaksiId, $userId, $tanggal, $address, $city, $region, $postCode, $totalPrice]); 

            $queryToTransaksiDetail =  "INSERT INTO transaksi_detail 
            (
                transDetail_id, transaksi_id, product_id, quantity
            ) 
            VALUES (?,?,?,?)
            "; 
            
            $result = $koneksi->prepare($queryToTransaksiDetail);
            foreach($_SESSION['cart'] as $product){
                $isUnik = false;
                while (!$isUnik) {
                    $transDetailId = 'TDID' . substr(generateUUID(), 0, 6);
                    $isUnik = isUnik($transDetailId, 'transaksi_detail', 'transDetail_id');
                }
                $quantity = $_POST['quantity'][$product['product_id']];
                $result->execute([$transDetailId, $transaksiId, $product['product_id'], $quantity]); 
                
                $queryUpdateStock = "UPDATE product SET stock = stock - ? WHERE product_id = ?";
                $stmt = $koneksi->prepare($queryUpdateStock);
                $stmt->execute([$quantity, $product['product_id']]);
            }
            header("Location: reciept.php?transaction=". $transaksiId);
            unset($_SESSION['cart']);
        }
        if(isset($_POST['add_to_cart'])) {
            $productId = $_POST['product_id'];
            $quantity = 1;
            $item = array(
                "product_id" => $_POST['product_id'],
                "product_name" => $_POST['product_name'],
                "product_stock" => $_POST['product_stock'],
                "product_price" => $_POST['product_price'],
                "product_pict" => $_POST['product_pict'],
                "quantity" => $quantity,
                "total_harga" => $_POST['product_price']
            );

            
            if (checkIfItemExistInCart($productId)) {
                foreach ($_SESSION['cart'] as $index => $product) {
                    if ($product['product_id'] == $productId) {
                        $_SESSION['cart'][$index]['quantity']++;
                        $_SESSION['cart'][$index]['total_harga'] = $_SESSION['cart'][$index]['quantity'] *
                        $_SESSION['cart'][$index]['product_price'];
                        break;
                    } 
                }
        } else {array_push($_SESSION['cart'], $item);}
    }
}

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    foreach ($_SESSION['cart'] as $index => $product) {
        if ($product['product_id'] == $id) {
            unset($_SESSION['cart'][$index]);
        }
    }
}

if (isset($_POST['clear-cart'])) {
    unset($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>TOKO CAHAYA ABADI</title>
</head>

<body>
    <header id="cart-header">
        <a href="../index.php" class="logo" id="cart-logo">
            <h1>Toko<span>Cahyadi</span></h1>
            <p>C a h a y a&nbsp;&nbsp;A b a d i</p>
        </a>
        <nav id="cart-nav">
            <ul>
                <li><a href="../index.php">home</a></li>
                <li><a href="../index.php#product-section">product</a></li>
                <li><a href="../index.php#footer">about</a></li>
                <li><a href="../index.php#footer">contact</a></li>
                <li>
                    <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
                </li>
                <li class="pp-wrapper">
                    <i class="fa-solid fa-user"></i>

                    <?php 
                    if($_SESSION['profile_pict'] != 'NoDirectory'){
                        $direktori = $_SESSION['profile_pict'];
                        echo "<img src='".$direktori."'/>"; } ?>
                </li>
            </ul>
        </nav>
        <div class="option">
            <a href="userSettings.php">User Settings</a>
            <a href="#">Favorite List</a>
            <a href="logout.php">Log Out</a>
        </div>
    </header>
    <main class="item-cart-container">
        <h1 class="title">Your Shopping Cart <div class="line"></div>
        </h1>
        <?php if(isset($_SESSION['cart']) && $_SESSION['cart'] !== [] ){ ?>
        <div class="cart-wrapper">
            <div class="item-list">
                <?php 
                $grandTotal = 0;
                $prev_product_id = -1; 
                foreach ($_SESSION['cart'] as $product) {
                    if ($product['product_id'] != $prev_product_id) {
                    
                ?>
                <div class="cart-card fade-up" id="<?php echo $product['product_id'] ?>">
                    <div class="img-wrapper">
                        <img src="<?= "../".$product['product_pict'] ?>" alt="">
                    </div>
                    <div class="detail-wrapper">
                        <div class="detail">
                            <div class="top-detail">
                                <h1><?= $product['product_name'] ?></h1>
                                <p class="price">Rp
                                    <span><?= number_format($product['product_price'], 0, ',', '.') ?></span>
                                </p>
                                <p>Stock : <span class="product-stock"><?php 
                                    if($product['product_stock'] < 0){
                                        echo 'Out of Stock';
                                    } else{
                                        echo $product['product_stock'];
                                    }
                                    
                                    ?></span></p>
                            </div>
                            <div class="qty-wrapper">
                                <button type="button" class="decrement-button"><i
                                        class="fa-sharp fa-solid fa-minus"></i></button>
                                <input type="text" class="quantity" id="<?php echo $product['product_id'] ?>" value="<?php
                                if($product['product_stock'] < 0){
                                    echo '';
                                } else{
                                    echo $product['quantity'];
                                } 
                                        
                                    ?>" max="<?php echo $product['product_stock'] ?>" min="1">
                                <button type="button" class="increment-button"><i
                                        class="fa-sharp fa-solid fa-plus"></i></button>
                            </div>
                            <div class="bottom">
                                <p>Total: Rp <span class="total"><?php 
                                if($product['product_stock'] < 0){
                                    echo '';
                                } else{
                                    echo number_format($product['total_harga'], 0, ',', '.');       
                                }
                                ?></span>
                                </p>
                                <a href=" cart.php?remove=<?= $product['product_id'] ?>" id="del-item">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $grandTotal += $product['total_harga']; }$prev_product_id = $product['product_id'];}?>
            </div>
        </div>
        <form class="checkout-wrapper" method="POST" action="cart.php">
            <div class="top">
                <h3>Total Amount: Rp <span id="lastTotal"><?php 

                echo number_format($grandTotal, 0, ',', '.')
                
                ?></span>
                </h3>
                <button type="submit" name="clear-cart">Clear Cart</button>
            </div>
            <div class="bottom">
                <button id="checkout-btn" type="button">Checkout</button>
            </div>
        </form>
        <?php } else echo "
        <div class='noProduct'>
            <p>It seems like you haven't added any products yet.</p>
            <a href='../index.php#product-section'>Add some products to your cart now.</a>
        </div>
        "?>
    </main>
    <div class="checkout-modal">
        <form action="" class="form-wrapper" id="checkout-form" method="post">
            <?php foreach($_SESSION['cart'] as $product){ ?>
            <input type="hidden" name="quantity[<?= $product['product_id'] ?>]" id="<?= $product['product_id'] ?>">
            <?php }?>
            <i id="cancel-modal" title="Cancel" class="fa-solid fa-x cancel-buy"></i>
            <h1>Checkout <div class="line"></div>
            </h1>
            <small>*Please provide your information for the checkout process.</small>
            <div class="name-input-wrapper">
                <div class="input-wrapper">
                    <input type="text" name="firstname" value="<?= $_SESSION['first_name'];?>" placeholder="Firstname"
                        required>
                </div>
                <div class="input-wrapper">
                    <input type="text" name="firstname" value="<?= $_SESSION['last_name'];?>" placeholder="Lastname"
                        required>
                </div>
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" value="<?= $_SESSION['email'];?>" placeholder="Email" required>
            </div>
            <div class="input-wrapper">
                <i class="fa-sharp fa-solid fa-location-dot"></i>
                <input type="text" name="address" placeholder="Address" required>
            </div>
            <div class="input-wrapper">
                <i class="fa-sharp fa-solid fa-city"></i>
                <input type="text" name="city" placeholder="City" required>
            </div>
            <div class="input-wrapper">
                <i class="fa-sharp fa-solid fa-globe"></i>
                <input type="text" name="region" placeholder="Region" required>
            </div>
            <div class="input-wrapper">
                <i class="fa-sharp fa-solid fa-signs-post"></i>
                <input type="text" name="postal_code" placeholder="Postal Code" required>
            </div>

            <p>Total Amount: Rp <span id="lastTotalCheckOut"><?php
                echo number_format($grandTotal, 0, ',', '.')
            ?></span></p>
            <div class="input-wrapper">
                Rp
                <input type="text" id="money" name="money" placeholder="Input the amount of money" required>
            </div>
            <button id="submit" type="submit" name="buy">Buy
                Now</button>
        </form>
    </div>
    <footer id="footer">
        <div class="top">
            <div class="sosmed">
                <h3>
                    Follow Us
                    <div class="line"></div>
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
                <h3>
                    Contact
                    <div class="line"></div>
                </h3>
                <span class="email">
                    <i class="fa-solid fa-envelope"></i><a href="mailto:tokocahyadi@gmail.com">tokocahyadi@gmail.com</a>
                </span>
                <span class="phone">
                    <i class="fa-solid fa-phone"></i><a>+62 825 - 6121 - 3718</a>
                </span>
                <span class="alamat">
                    <i class="fa-solid fa-building"></i>
                    <a>Jl. Batik Pekalongan No. 10 C17, <br />
                        Kabupaten Pekalongan, Jawa Tengah</a>
                </span>
            </div>
            <div class="about">
                <h3>
                    About Us
                    <div class="line"></div>
                </h3>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit ea
                    ducimus voluptatem cumque quia amet expedita inventore? Unde
                    voluptatum ullam dolorem, nostrum tempora quibusdam architecto
                    consectetur cupiditate eveniet placeat sed dolores harum quis sint
                    suscipit, deleniti deserunt? Sit officiis, fugiat ipsam, possimus
                    optio adipisci similique laborum quo dicta libero quam!
                </p>
            </div>
        </div>
        <p class="copy">
            Copyright &copy; <span id="year"></span> Toko Cahyadi All materials on
            this website are the property of our company.
        </p>
    </footer>
    <script src="../Script/main.js"></script>
</body>

</html>