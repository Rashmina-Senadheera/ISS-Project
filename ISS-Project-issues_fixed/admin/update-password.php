<?php include('partials/menu.php') ?>
<?php 
    //check whether the submit button is click
    if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post"){
        //get the data
        $id =$_POST['id'];
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        //check whether the current password holder exists
        $conn = connect();
        $sql = "SELECT * FROM `tbl_admin` WHERE `id` = :id";
        $stmt = $conn->prepare($sql);
        $res = $stmt->fetch();
        $count = $stmt->rowCount();
        
        if($count>0){
            $password = $res['password'];
            if(password_verify($current_password, $password)){
                if($new_password == $confirm_password){
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql2 = "UPDATE `tbl_admin` SET `password` = :new_password WHERE `id` = :id";
                    $stmt2 = $conn->prepare($sql2);
                    $res2 = $stmt2->execute([
                        'new_password' => $hashed_new_password,
                        'id' => $id
                    ]);

                    if($res2){
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully</div>";
                        header("location:".SITE_URL.'admin/manage-admin.php');
                    }
                    else{
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change password</div>";
                        header("location:".SITE_URL.'admin/manage-admin.php');
                    }
                }else{
                    //redirect to manage admin
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match</div>";
                    header("location:".SITE_URL.'admin/manage-admin.php');
                }
            }
            else{
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                header("location:".SITE_URL.'admin/manage-admin.php');
            }
        }
    }

?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br />
        <br />
        <?php 
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="table-30">
                <tr>
                    <td>
                        Current Password:
                    </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">

                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>
                        Confirm Password: 
                    </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-update">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>
<?php include('partials/footer.php') ?>