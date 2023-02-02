<?php include("partials/menu.php")?>
<?php
    //check whter the submit button is clicked or not
    if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post"){
        //get all the values from form to update
        $id = mysqli_real_escape_string($conn,htmlspecialchars($_POST['id'])) ;
        $full_name = htmlspecialchars($_POST['full_name']);
        $username = htmlspecialchars($_POST['username']);

        $conn = connect(); 

        //create sql query to update admin
        $sql = "UPDATE tbl_admin SET full_name = :full_name, username = :username WHERE id= :id";

        $stmt = $conn->prepare($sql);

        $res = $stmt->execute([
            'full_name' => $full_name,
            'username' => $username,
            'id' => $id
        ]);
        
        if($res){
            $_SESSION['update']= '<div class="success">Admin Updated Successfully</div>';
            header('location:'.SITE_URL.'admin/manage-admin.php');
        }
        else{
            $_SESSION['update']= '<div class="error">Falied to update Admin</div>';
            header('location:'.SITE_URL.'admin/manage-admin.php');
        }
    }
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br />
        <br />
        <?php 
            $conn = connect();
            //get the id of the admin
            $id = $_GET['id'];
            //SQL query to get the details
            $sql = "SELECT * FROM `tbl_admin` WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'id' => $id
            ]);

            $row = $stmt->fetch();
            $count = $stmt->rowCount();

                if($count==1){
                    //echo "Admin Available";
                    $full_name = $row['full_name'];
                    $username = $row['username']; 
                }
                else{
                    //redirect to manage-admin
                    header('location:'.SITE_URL.'admin/manage-admin.php');
                }
        ?>

        <form method="POST">
            <table class="table-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username ?>">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2">
                    <br />
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-update"> 

                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>
<?php include("partials/footer.php")?>