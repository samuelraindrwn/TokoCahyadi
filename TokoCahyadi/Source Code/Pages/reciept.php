<?php

session_start();

$koneksi = new PDO("mysql:host=localhost;dbname=toko_cahyadi", "root", "");

$transaksiID = $_GET['transaction'];

$query = 
"SELECT product.product_name, product.product_price, transaksi_detail.quantity, (transaksi_detail.quantity * product.product_price) AS total_price, SUM(transaksi_detail.quantity * product.product_price) AS total_amount
FROM transaksi_detail INNER JOIN product 
ON transaksi_detail.product_id = product.product_id
WHERE transaksi_detail.transaksi_id = :transaksi_id
GROUP BY product.product_id";

$stmt = $koneksi->prepare($query);
$stmt->bindParam(':transaksi_id', $transaksiID);
$stmt->execute();


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>TOKO CAHAYA ABADI</title>
</head>

<body id="recieptBody">
    <main class="reciept-container">
        <img src="../Img/check-mark.png" width="170px">
        <h1>Thank you <br> Your purchase has been successful</h1>
        <p class="idTrans">Transaction ID: <?php echo $transaksiID ?> </p>
        <div class="reciept-wrapper">
            <table class="list-reciept">
                <tr>
                    <td>Product Name</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total Price</td>
                </tr>
                <?php 
                $totalAmount = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                    $totalAmount += $row['total_amount'];
                ?>

                <tr>
                    <td><?= $row['product_name'] ?></td>
                    <td>Rp <?= number_format($row['product_price'], 0, ',', '.') ?></td>
                    <td><?= $row['quantity'] ?></td>
                    <td>Rp <?= number_format($row['total_price'], 0, ',', '.')?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div class="bottom">
            <div class="total-wrapper">
                <h3 class="total">
                    <span>Total Amount</span> : Rp<?= number_format($totalAmount, 0, ',', '.') ?>
                </h3>
                <h3 class="total">
                    <span>Payment Amount</span> : Rp<?= number_format($totalAmount, 0, ',', '.') ?>
                </h3>
            </div>
            <a href="../index.php">Back to Home</a>
        </div>
    </main>
    <script src="../Script/main.js"></script>
</body>

</html>