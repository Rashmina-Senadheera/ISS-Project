<?php 
    //start session

    session_start();
    define('SITE_URL','http://localhost/IS1109/');
    define('API_KEY', '4f2ed61f9d974c3ea1848e563efa7f82');

    /* composer autoload */
    require SITE_URL . 'vendor/autoload.php';
    include_once '../libs/CSRF-Protector-PHP/libs/csrf/csrfprotector.php';

    /* load PHP dotenv library */
    // $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    // $dotenv->load();

    include 'connection.php';    
    // $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error($conn));
    // $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
?>