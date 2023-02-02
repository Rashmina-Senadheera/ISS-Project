<?php include('partials-front/menu.php'); ?>

    <!-- Material sEARCH Section Starts Here -->
    <section class="materials-search text-center">
        <div class="container">
            
            <form action="<?php echo SITE_URL; ?>material-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Materials.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Material sEARCH Section Ends Here -->
    <?php 
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Materials</h2>
            <?php 
                //sql query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active=:is_active AND featured=:is_featured LIMIT 3";
                $conn = connect();
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'is_active'=>'Yes',
                    'is_featured'=>'Yes'
                ]);

                $rows = $stmt->fetchAll();
                $count = $stmt->rowCount();

                if($count>0){
                    //categories are available
                    foreach($rows as $row){
                        //get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php echo SITE_URL;?>category-materials.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php 
                                //check tha availability of the image
                                    if($image_name==""){
                                        //display the message
                                        echo "<div class='error'>Image Not Availabale</div>";
                                    }
                                    else{
                                        ?>
                                        <img src="<?php echo SITE_URL; ?>images/category/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                                        <?php
                                    }

                                ?>
                                

                                <h3 class="float-text text-black"><?php echo $title; ?></h3>
                            </div>
                        </a>
                        <?php
                    }
                }
                else{
                    //no categories
                    echo "<div class='error'>Category Not Added</div>";
                }
            ?>

            

            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- Materials MEnu Section Starts Here -->
    <section class="material-menu">
        <div class="container">
            <h2 class="text-center">Materials</h2>
            <?php 
            //getting materials from database which are featured and active
            $conn = connect();
            $sql2 = "SELECT * FROM `tbl_materials` WHERE `active` = :is_active AND `featured` = :is_featured LIMIT 6";
            $stmt = $conn->prepare($sql2);
            $stmt->execute([
                'is_active'=>'Yes',
                'is_featured'=>'Yes'
            ]);
            $rows2 = $stmt->fetchAll();
            $count2 = $stmt->rowCount();

            if($count2>0){
                //materials are available
                foreach($rows2 as $row2){
                    $id = $row2['id'];
                    $title = $row2['title'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                    <div class="material-menu-box">
                        <div class="material-menu-img">
                            <?php 
                                //image availability
                                if($image_name==""){
                                    //image is not available
                                    echo "<div class='error'>Image is not available.</div>";

                                }
                                else{
                                    //image available
                                    ?>
                                    <img src="<?php echo SITE_URL; ?>images/material/<?php echo $image_name; ?>" class="img-responsive img-curve">


                                    <?php
                                }

                            ?>
                            
                        </div>

                        <div class="material-menu-desc">
                            <h4><?php echo $title; ?> </h4>
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
                //materials are not available
                echo "<div class='error'>Material IS Not Availabale</div>";
            }


            ?>

    
            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="<?php echo SITE_URL;?>materials.php">See All Materials</a>
        </p>
    </section>
    <!-- Material Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>