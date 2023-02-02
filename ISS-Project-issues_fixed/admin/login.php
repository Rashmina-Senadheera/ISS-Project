<?php include('../config/constants.php') ?>
<?php
// Initialise CSRFGuard library
csrfProtector::init();
//check the submit button

if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post") {
    //Process for login
    //get the data from form
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $conn = connect();

    //sql query to check the username and pwd existance
    $sql = "SELECT * FROM `tbl_admin` WHERE `username`= :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'username' => $username
    ]);
    $admin = $stmt->fetch();

    if ($stmt->rowCount() > 0) {
        $hashed_password = $admin['password'];
        if (password_verify($password, $hashed_password)) {
            // prevent session fixation attacks
            session_regenerate_id(true);
            //user exists
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = "<div class='admin-name'>$username</div>"; //to check whether the user is logged or not
            $_SESSION['id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];

            //redirect to home page
            header('Location: ' . SITE_URL . 'admin/');
        } else {
            //redirect to login page with error
            header('Location: ' . SITE_URL . 'admin/login.php?error=true');
        }
    }
    else{
        //redirect to login page with error
        header('Location: ' . SITE_URL . 'admin/login.php?error=true');
    }
}

?>

<html>
<head>
    <title>
        Login
    </title>
    <link rel="stylesheet" href="../css/adminLogin.css">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

</head>

<body>
    <main class="container" id="login-container">
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        if (isset($_SESSION['no-login-message'])) {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-message']);
        }
        ?>
        <article class="grid">
            <div>
                <hgroup>
                    <h1>Log in</h1>
                    <h2>Admin</h2>
                </hgroup>
                <form action="" method="POST" id="login">
                    <input type="text" name="username" placeholder="Username" aria-label="username" id="username">
                    <p style="color: red;" id="err-username"></p>
                    <input type="password" name="password" placeholder="Password" aria-label="Password" id="password">
                    <p style="color: red;" id="err-password"></p>
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "true") {
                            echo '<p style="color: red;">invalid username or password</p>';
                        }
                    }
                    ?>
                    <input type="submit" class="contrast" name="login" id="login-btn" value="Login">
                </form>
            </div>
            <div>
            </div>
        </article>
        <a href="<?php echo SITE_URL; ?>" style="text-align: center;">Home</a>
    </main>
    <!-- ./ Main -->
    <script src="../js/main.js"></script>
    <script src="../js/adminLogin.js"></script>
</body>
</html>