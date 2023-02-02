<?php

    //include constants.php
    include('../config/constants.php');
    //get the id
    $id = $_GET['id'];
    $conn = connect();
    //Create SQL query
    $sql = "DELETE FROM `tbl_admin` WHERE `id` = :id";

    $stmt = $conn->prepare($sql);

    $res = $stmt->execute([
        'id' => $id
    ]);

    //check the query execution
    if($res){
        //echo "Admin Deleted";
        //create session varibale to disply message
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        header('location:'.SITE_URL.'admin/manage-admin.php');
        
    }
    else{
        $_SESSION['delete'] = "<div class='error'>Falied to delete admin</div>";
        header('location:'.SITE_URL.'admin/manage-admin.php');
    }

    //Redirect to manage admin page


?>