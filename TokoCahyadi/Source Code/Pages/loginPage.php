<?php

session_start();

$koneksi = new PDO("mysql:host=localhost;dbname=toko_cahyadi", "root", "");

$msg = null;
$isLogged = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['login'])){ 
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['password'] = $password;
    $query = $koneksi->prepare("SELECT * FROM user WHERE username = ?");
    $query->execute([$username]); 
    $user = $query->fetch(PDO::FETCH_ASSOC); 
        if($user){
            if(substr(md5($password), 0, 30) == $user['password']){
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['dob'] = $user['dob'];
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['profile_pict'] = $user['profile_pict'];
                $cookie_name = "user";
                $cookie_value = $user['user_id'];
                setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); 
                if (isset($_POST['remember'])) {
                    $cookie_name = "user";
                    $cookie_value = $user['user_id'];
                    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 
                }
                $isLogged = true;
                $_SESSION['isLogged'] = $isLogged;
                header("Location: ../index.php"); 
                exit(); 
            } else{
                $msg = "Incorrect username or password ";
            }
        } else{
            $msg = "Incorrect username or password ";
        }
    }
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
    <main class="login-container fade-up">
        <h1>LOGIN</h1>
        <p>New user? <a href="signUpPage.php">Create Account</a></p>
        <form action="" method="post" class="form-wrapper">
            <?php echo "<p style='color: red'>" . $msg . "</p>" ?>
            <div class="input-wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Username" name="username" required />
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password" name="password" required />
            </div>
            <button type="submit" name="login">L O G I N</button>
            <div class="additional-input">
                <div>
                    <input id="remember" name="remember" type="checkbox" />
                    <label for="remember">Remember Me</label>
                </div>
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </main>
    <script src="../Script/main.js"></script>
</body>

</html>