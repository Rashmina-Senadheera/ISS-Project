<?php include('partials/menu.php'); ?>

<?php

// Initialise CSRFGuard library
csrfProtector::init();

if ($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "post") {

    //get all the details from the form
    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $current_image = htmlspecialchars($_POST['current_image']);
    $category = htmlspecialchars($_POST['category']);
    $featured = htmlspecialchars($_POST['featured']);
    $active = htmlspecialchars($_POST['active']);

    //upload the image if selected
    //check whether the upload button is clicked or not
    if (isset($_FILES['image']['name'])) {
        //upload button clicked
        $image_name = $_FILES['image']['name']; //new image name

        //check whether the file is available or not
        if ($image_name != "") {
            //uploading new image
            //image is available
            //rename the image

            $ext1 = explode('.', $image_name); //gets the extention of the image
            $ext = end($ext1);
            $image_name = "Material-Name-" . rand(0000, 9999) . '.' . $ext; //renamed image

            //get the source path and destination path
            $src_path = $_FILES['image']['tmp_name'];  //source path
            $dest_path = "../images/material/" . $image_name; //destination path

            //upload the image
            $upload = move_uploaded_file($src_path, $dest_path);

            //check whether the image is uploaded or not
            if ($upload == false) {
                //failed to upload
                $_SESSION['upload'] = "<div class='error'>Failed to Upload new image file.</div>";

                //redirect to manage materials
                header('location:' . SITE_URL . 'admin/manage-materials.php');

                //stop the process 
                die();
            }


            //remove the image if new image is uploaded and current image exists
            //remove current image if available
            if ($current_image != "") {
                //current image is available
                //remove the image
                $remove_path = "../images/material/" . $current_image;

                $remove = unlink($remove_path);

                //check whether the image is removed or not
                if ($remove == false) {
                    //failed to remove the current image
                    $_SESSION['upload'] = "<div class='error'>Failed to Remove Current Image.</div>";

                    //redirect to manage materials
                    header('location:' . SITE_URL . 'admin/manage-materials.php');

                    //stop the process of deleting material
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }
    $conn = connect();
    //update the database
    $sql3 = "UPDATE `tbl_materials` SET
                                `title` = :title,
                                `description` = :description,
                                `price` = :price,
                                `image_name` = :image_name',
                                `category_id` = :category',
                                `featured` = :featured,
                                `active` = :active
                                WHERE `id` = :id";

    $stmt3 = $conn->prepare($sql3);
    $res3 = $stmt3->execute([
        'title' => $title,
        'description' => $description,
        'price' => $price,
        'image_name' => $image_name,
        'category' => $category,
        'featured' => $featured,
        'active' => $active,
        'id' => $id
    ]);

    //check whether the query is executed or not
    if ($res3) {

        //query executed and updated material
        $_SESSION['update'] = "<div class='success'>Material Updated Successfully.</div>";
        header('location:' . SITE_URL . 'admin/manage-materials.php');
    } else {
        //failed to update material
        $_SESSION['update'] = "<div class='error'>Failed to Update Material.</div>";
        header('location:' . SITE_URL . 'admin/manage-materials.php');
    }
}
?>

<?php
//check whether id is set or not
if (isset($_GET['id'])) {
    //get all the details
    $id = $_GET['id'];
    $conn = connect();
    $sql2 = "SELECT * FROM `tbl_materials` WHERE `id` = :id";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([
        'id' => $id
    ]);

    $row2 = $stmt2->fetch();
    $count2 = $stmt2->rowCount();

    //get the individual values of the selected material
    $title = htmlspecialchars($row2['title']);
    $description = htmlspecialchars($row2['description']);
    $price = htmlspecialchars($row2['price']);
    $current_image = htmlspecialchars($row2['image_name']);
    $current_category = htmlspecialchars($row2['category_id']);
    $featured = htmlspecialchars($row2['featured']);
    $active = htmlspecialchars($row2['active']);
} else {
    //redirect to manage materials
    header('location:' . SITE_URL . 'admin/manage-materials.php');
}
?>


<div class="main-content">

    <div class="wrapper">
        <h1>Update Materials</h1>
        </br></br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="table-50">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="text" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            //image not available
                            echo "<div class='error'>Image is not available.</div>";
                        } else {
                            //image avilable
                        ?>
                            <img src="<?php echo SITE_URL; ?>images/material/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                            //php code to display categories from database
                            //SQL to get the active categories from database
                            $conn = connect();
                            $sql = "SELECT * FROM `tbl_category` WHERE `active` = :active";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([
                                ':active' => 'Yes'
                            ]);

                            $rows = $stmt->fetchAll();
                            $count = $stmt->rowCount();

                            if ($count > 0) {
                                foreach ($rows as $row) {
                                    //get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value=" . $id . ">" . $title . "</option>";
                                }
                            } else {
                                //no categories
                                echo "<option value='0'>No Categories Found</option>";
                                //have categories
                            }

                            ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No">No

                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No">No

                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update" class="btn-update">
                    </td>

                </tr>

            </table>
        </form>
    </div>
</div>
<?php include('partials/footer.php'); ?>