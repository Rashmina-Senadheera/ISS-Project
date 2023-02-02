<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Categories</h2>
            <?php 
                //display all the categories which are active
                $conn = connect();
                $sql = "SELECT * FROM `tbl_category` WHERE active = :is_active";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'is_active'=>'Yes'
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
                                    if($image_name==""){
                                        //image not available
                                        echo "<div class='error'>Image Not Found</div>";
                                    }
                                    else{
                                        //image available
                                        ?>
                                            <img src="<?php echo SITE_URL; ?>images/category/<?php echo $image_name?>" class="img-responsive img-curve">

                                        <?php
                                    }
                                
                                ?>
                            

                            <h3 class="float-text text-black"><?php echo $title;?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else{
                    //Not Available
                    echo "<div class='error'>Category Not Found</div>";
                }
            ?>

        <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include('partials-front/footer.php'); ?>

</body>
</html>