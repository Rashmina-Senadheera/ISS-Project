<?php include('partials/menu.php'); ?>
<?php
// Initialise CSRFGuard library
csrfProtector::init();

if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post") {
    $full_name = htmlspecialchars($_POST['full_name']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT); //BCrypt is used for encrypting the password

    $conn = connect();

    $sql = "SELECT * FROM `tbl_admin` WHERE `username` = :username";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        'username' => $username
    ]);

    $res = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        header('Location: ' . SITE_URL . 'admin/add-admin.php?username=true');
    } else {
        //inserting data to the admin table
        $sql2 = "INSERT INTO `tbl_admin` SET `full_name` = :full_name,`username` = :username,`password` = :password";

        $stmt2 = $conn->prepare($sql2);

        $res2 = $stmt2->execute([
            'full_name' => $full_name,
            'username' => $username,
            'password' => $password
        ]);

        if ($res2) {
            $_SESSION['add'] = '<div class="success">Admin Added Successfully</div>';
            echo "<script>alert('Admin Added Successfully')</script>";
            //redirect to the manage admin page
            header("location:" . SITE_URL . 'admin/manage-admin.php');
        } else {
            $_SESSION['add'] = '<div class="error">Failed to add admin</div>';
            echo "<script>alert('Failed to add admin')</script>";
            //redirect to the add admin page
            header("location:" . SITE_URL . 'admin/add-admin.php');
        }
    }
}
?>

<html>

<head>
    <title>
        Add Admin
    </title>
    <link rel="stylesheet" href="../css/adminLogin.css">
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
</head>

<body>
    <main class="container" id="login-container">
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); //Remove session message
        }
        ?>
        <article class="grid">
            <div>
                <hgroup>
                    <h1>Add Admin</h1>
                </hgroup>
                <form action="" method="POST" id="add-form">
                    <?php
                        if (isset($_GET['username'])) {
                            if ($_GET['username'] == "true") {
                                echo '<p style="color: red;">user already exists</p>';
                            }
                        }
                    ?>
                    <input type="text" name="full_name" placeholder="Full Name" aria-label="full-name" id="full-name">
                    <p style="color: red;" id="err-full-name"></p>
                    <input type="text" name="username" placeholder="Username" aria-label="username" id="username">
                    <p style="color: red;" id="err-username"></p>
                    <input type="password" name="password" placeholder="Password" aria-label="Password" id="password">
                    <p style="color: red;" id="err-password"></p>
                    <input type="submit" class="contrast" name="add" id="add-admin-btn" value="Add Admin">
                </form>
            </div>
        </article>
        <a href="<?php echo SITE_URL; ?>" style="text-align: center;">Home</a>
    </main>
    <script src="../js/main.js"></script>
    <script src="../js/addAdmin.js"></script>
</body>

</html>
<?php include('partials/footer.php');  ?>