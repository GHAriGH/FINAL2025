<?php

    define("KEY_TOKEN", "ABC.123*");
    define("CLIENTE_ID", "AYXVaK_pTSP3lW60s3-VrNQstat-ciUXNWOE3T68Mj5SQ9v9xruCBKYYfWP-UY2pvfXCol3DzgOhA4x0");

    session_start();

    $num_cart = 0;

    if(isset($_SESSION['carrito']['productos'])) {
        $num_cart = count($_SESSION['carrito']['productos']);
    }

?>