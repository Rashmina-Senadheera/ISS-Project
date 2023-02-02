<?php include('partials-front/menu.php'); ?>

    <!-- sEARCH Section Starts Here -->
    <section class="material-search text-center">
        <div class="container">
        <?php
            //get the search key word
            $search = htmlspecialchars($_POST['search']);
            ?>
            <h2>Materials on Your Search "<?php echo $search; ?>"</h2>

        </div>
    </section>
    <!-- sEARCH Section Ends Here -->



    <!-- MEnu Section Starts Here -->
    <section class="material-menu">
        <div class="container">
            
            <?php 
            $conn = connect();
            //sql query to get materials based on search keyword
            $sql = "SELECT * FROM `tbl_materials` WHERE `title` LIKE CONCAT('%',:search_1,'%') OR `description` LIKE CONCAT('%',:search_2,'%')";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'search_1'=>$search,
                'search_2'=>$search
            ]);
            $rows = $stmt->fetchAll();
            
            $count = $stmt->rowCount();
            //check whether materils available or not
            if($count>0){
                //material available
                foreach($rows as $row){
                    //get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>
                    <div class="material-menu-box">
                        <div class="material-menu-img">
                            <?php 
                                //check whether image is available or not 
                                if($image_name ==""){
                                    //image not available
                                    echo "<div class='error'>Image Not Available. </div>";
                                }
                                else{
                                    //image is available
                                    ?>
                                        <img src="<?php echo SITE_URL;?>images/material/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
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
            }
            else{
                //not available
                echo "<div class='error'> Material is not available.</div>";
            }
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- Menu Section Ends Here -->
<?php include('partials-front/footer.php'); ?>

</body>
</html>