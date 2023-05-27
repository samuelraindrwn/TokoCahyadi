<?php
$koneksi = new PDO("mysql:host=localhost;dbname=toko_cahyadi", "root", "");

function isUnik($id){
  $query = $GLOBALS['koneksi']->prepare("SELECT * FROM user WHERE user_id = ?");
  $query->execute([$id]); 
  if ($query->rowCount() > 0) return false; else return true; 
} 

function isUsernameUnik($username){ 
  $query = $GLOBALS['koneksi']->prepare("SELECT * FROM user WHERE username = ?");
  $query->execute([$username]); 
  if ($query->rowCount() > 0) return false; else return true; 
} 

$msg = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  if(isset($_POST['regist'])): 
    $unik = false; 
    while(!$unik){ 
        $id= "U" . "_" . rand(1, 10000); 
        $unik = isUnik($id); 
    } 
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name']; 
    $dob = $_POST['dob']; 
    $email =$_POST['email'];
    $username =$_POST['username']; 
    $profile_pict = "NoDirectory";
    if(!isUsernameUnik($username)){ 
        $msg = "Username already exists";
        header("Location: signUpPage.php");
        exit();
    }
    $password = md5($_POST['password']); 
    $query = "INSERT INTO user (user_id, first_name, last_name, dob, username, password, email, profile_pict) VALUES (?,?,?,?,?,?,?,?)"; 
    $result = $koneksi->prepare($query);
    $result->execute([$id, $first_name, $last_name, $dob, $username, $password, $email, $profile_pict]); 
    header('Location: loginPage.php'); 
  endif; 
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
        <h1>SIGN UP</h1>
        <p>Already Have Account? <a href="loginPage.php">Login Now</a></p>
        <form action="" method="post" class="form-wrapper">
            <div class="name-input-wrapper">
                <div class="input-wrapper">
                    <input type="text" placeholder="Firstname" name="first_name" required />
                </div>
                <div class="input-wrapper">
                    <input type="text" placeholder="Lastname" name="last_name" required />
                </div>
            </div>
            <div class="input-wrapper">
                <input title="date of birth" type="date" name="dob" required />
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" placeholder="Email" name="email" required />
            </div>
            <?php echo "<p style='color: red'>" . $msg . "</p>" ?>
            <div class="input-wrapper">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Username" name="username" required />
            </div>
            <div class="input-wrapper">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Password" name="password" required />
            </div>
            <button type="submit" name="regist">
                S I G N&nbsp;&nbsp;&nbsp;U P
            </button>
        </form>
    </main>
    <script src="../Script/main.js"></script>
</body>

</html>