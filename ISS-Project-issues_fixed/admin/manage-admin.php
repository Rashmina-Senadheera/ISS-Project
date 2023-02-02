<?php include('partials/menu.php'); ?>
<!---Main Content--->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>

        <br />
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); //Remove session message              
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }
        if (isset($_SESSION['pwd-not-match'])) {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if (isset($_SESSION['change-pwd'])) {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }

        ?>
        <br />
        <br />
        <br />

        <!--Add New Admin-->
        <a href="add-admin.php" class="btn-add">Add Admin</a>
        <br />
        <br />

        <table class="table_full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            $conn = connect();
            $sql = "SELECT * FROM `tbl_admin`";
            $stmt = $conn->query($sql);
            $rows = $stmt->fetchAll();
            $count = $stmt->rowCount();

                $sn = 1;

                if ($count > 0) {

                    foreach($rows as $row){
                        $id = $row['id'];
                        $full_name = $row['full_name'];
                        $username = $row['username'];

                        //display valus in the table
            ?>
                        <tr>
                            <td><?php echo $sn++; ?> </td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITE_URL;  ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-add">Change Password</a>
                                <a href="<?php echo SITE_URL;  ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-update">Update</a>
                                <a href="<?php echo SITE_URL;  ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-delete">Delete</a>

                            </td>
                        </tr>

            <?php
                    }
                } else {
                }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php');  ?>