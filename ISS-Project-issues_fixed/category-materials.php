<?php include('partials-front/menu.php'); ?>
<?php
//check whether the id is passed or not
if (isset($_GET['category_id'])) {
    //category is set
    $category_id = $_GET['category_id'];
    $conn = connect();
    //get the category title according to id
    $sql = "SELECT `title` FROM `tbl_category` WHERE `id` = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'id' => $category_id
    ]);
    $row = $stmt->fetch();
    //get the title
    $category_title = $row['title'];
} else {
    //category not passed
    //redirect to home page
    header('location:' . SITE_URL);
}
?>

<!-- Material sEARCH Section Starts Here -->
<section class="material-search text-center">
    <div class="container">

        <h2>Materials on <a href="#" class="text-black">"<?php echo $category_title; ?>"</a></h2>

    </div>
</section>
<!-- Material sEARCH Section Ends Here -->



<!-- Material MEnu Section Starts Here -->
<section class="material-menu">
    <div class="container">
        <h2 class="text-center">Materials Menu</h2>
        <?php
        $conn = connect();
        //create sql querey to get materials based category
        $sql2 = "SELECT * FROM `tbl_materials` WHERE `category_id` = :category_id";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([
            'category_id' => $category_id
        ]);

        $rows2 = $stmt2->fetchAll();

        $count2 = $stmt2->rowCount();

        //check whether material is available or not
        if ($count2 > 0) {
            //material is available
            foreach ($rows2 as $row2) {
                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];
        ?>
                <div class="material-menu-box">
                    <div class="material-menu-img">
                        <?php
                        if ($image_name == "") {
                            //image is not available
                            echo "<div class='error'>Image Not Available</div>";
                        } else {
                            //image is available
                        ?>
                            <img src="<?php echo SITE_URL; ?>images/material/<?php echo $image_name; ?>" class="img-responsive img-curve">
                        <?php
                        }
                        ?>

                    </div>

                    <div class="material-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="material-price">$<?php echo $price; ?></p>
                        <p class="material-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <a href="<?php echo SITE_URL; ?>order.php?material_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>

        <?php
            }
        } else {
            //not available
            echo "<div class='error'>Material Is Not Available.</div>";
        }
        ?>




        <div class="clearfix"></div>



    </div>

</section>
<!-- Material Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>

</body>

</html>