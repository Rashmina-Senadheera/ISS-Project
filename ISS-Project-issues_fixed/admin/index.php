<?php include('partials/menu.php'); ?>
<!---Main Content--->
<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br /><br />
        <?php
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        ?>

        <div class="col-4 text-center">
            <?php
            $conn = connect();
            $sql = "SELECT * FROM `tbl_category`";
            $stmt = $conn->query($sql);
            $res = $stmt->fetchAll();
            $category_count = $stmt->rowCount();

            ?>
            <h1><?php echo htmlspecialchars($category_count); ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">
            <?php
            $conn = connect();
            $sql2 = "SELECT * FROM `tbl_materials`";
            $stmt2 = $conn->query($sql2);
            //execute query
            $res2 = $stmt2->fetchAll();
            $material_count =$stmt2->rowCount();

            ?>
            <h1><?php echo htmlspecialchars($material_count); ?></h1>
            <br />
            Materials
        </div>

        <div class="col-4 text-center">
            <?
            $conn = connect();
            $sql3 = "SELECT * FROM `tbl_order`";
            $stmt3 = $conn->query($sql3);
            $res3 = $stmt3->fetchAll();
            $order_count = $stmt3->rowCount();

            ?>
            <h1><?php echo htmlspecialchars($order_count); ?></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">
            <?php
            $conn = connect();
            $sql4 = "SELECT SUM(total) as `Total` FROM `tbl_order` WHERE `status` = :status";
            //execute query
            $stmt4 = $conn->prepare($sql4);
            $stmt4->execute([
                'status'=>'Delivered'
            ]);
            $row4 = $stmt4->fetch();
            $total_revenue = $row4['Total'];
            ?>
            <h1>$<?php echo htmlspecialchars($total_revenue); ?></h1>

            <br />
            Revenue
        </div>
        <div class="clearfix">

        </div>


    </div>

</div>
<?php include('partials/footer.php'); ?>