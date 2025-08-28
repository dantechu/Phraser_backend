<?php

    //server database configuration
    $host       = 'localhost';
    $user       = 'amazingo_phraser';
    $pass       = 'Ab~wT1Th!vJ_';
    $database   = 'amazingo_phraser';


     //localhost database configuration
    // $host       = 'localhost';
    // $user       = 'root';
    // $pass       = '';
    // $database   = 'phraser';

    $connect = new mysqli($host, $user, $pass, $database);

    if (!$connect) {
        die ('connection failed: ' . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8mb4');
    }

    $ENABLE_RTL_MODE = 'false';

?>