<?php
session_start();
$koneksi = new PDO("mysql:host=localhost;dbname=toko_cahyadi", "root", "");

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if(isset($_POST['submit'])) { 
    $maxFileSize = 2 * 1024 * 1024; 
    $direktori = '../Img/pp/'.$_FILES['profile_picture']['name'];
    $imageFileType = strtolower(pathinfo($direktori,PATHINFO_EXTENSION));
    $file = $_FILES['profile_picture'];
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name']; 
    $dob = $_POST['dob']; 
    $email = $_POST['email'];
    $username = $_POST['username']; 
    $user_id = $_SESSION['user_id'];
    $profile_pict = $_SESSION['profile_pict'];
    
    if ($_FILES['profile_picture']['size'] > 0) {
        if (file_exists($direktori)) {
            unlink($direktori);
        }
        if ($_FILES['profile_picture']['size'] > $maxFileSize) {
            echo "File terlalu besar. Maksimal $maxFileSize byte.";
            exit;
        }
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $direktori);
        $profile_pict = $direktori;
    }
    
    $update = $koneksi->prepare("UPDATE user SET 
        first_name = :first_name,
        last_name = :last_name,
        dob = :dob,
        email = :email,
        username = :username,
        profile_pict = :profile_pict
        WHERE user_id = :user_id");

    $update->bindParam(':first_name', $first_name);
    $update->bindParam(':last_name', $last_name);
    $update->bindParam(':dob', $dob);
    $update->bindParam(':email', $email);
    $update->bindParam(':username', $username);
    $update->bindParam(':profile_pict', $profile_pict);
    $update->bindParam(':user_id', $user_id);
    $update->execute();

    // simpan data baru ke session
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['dob'] = $dob;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['profile_pict'] = $profile_pict;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>TOKO CAHAYA ABADI</title>
</head>

<body id="loginPageBody">
    <button type="button" class="btn back-btn" onclick="window.location.href='../index.php';">Back</button>
    <main class="user-wrapper fade-up">
        <form class="form-wrapper settings" id="upload-form" method="post" enctype="multipart/form-data">
            <div class="pp-settings">
                <i class="fa-solid fa-user"></i>
                <?php 
                    if($_SESSION['profile_pict'] != 'NoDirectory'){
                        $direktori = $_SESSION['profile_pict'];
                        echo "<img id='preview-gambar' src='".$direktori."'/>"; 
                    } else{
                        echo "<img id='preview-gambar' src=''/>";
                    }
                ?>
            </div>
            <button type="button" title="Edit profile picture" id="edit_pp">
                <i class="fa-solid fa-pen-to-square edit-pp"></i> Edit Profile Picture
            </button>
            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
            <div class=" name-input-wrapper">
                <div class="input-wrapper">
                    <input type="text" placeholder="Firstname" value="<?= $_SESSION['first_name']; ?>" name="first_name"
                        required />
                </div>
                <div class="input-wrapper">
                    <input type="text" placeholder="Lastname" value="<?= $_SESSION['last_name']; ?>" name="last_name"
                        required />
                </div>
            </div>
            <div class="input-wrapper">
                <input title="date of birth" value="<?= $_SESSION['dob']; ?>" type="date" name="dob" required />
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" placeholder="Email" value="<?= $_SESSION['email']; ?>" name="email" required />
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Username" value="<?= $_SESSION['username']; ?>" name="username"
                    required />
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password" value="<?= $_SESSION['password']; ?>" name="password"
                    required />
            </div>
            <button type="submit" name="submit" id="upload-btn">EDIT</button>
        </form>
    </main>
    <script src="../Script/main.js"></script>
</body>

</html>