<?php

    define("KEY_TOKEN", "ABC.123*");
    define("TOKEN_MP", "TEST-3222796715089548-072420-622d2f4b07f10162e8fa8e5caaf4095c-694287671");
    define("CLIENTE_ID", "AYXVaK_pTSP3lW60s3-VrNQstat-ciUXNWOE3T68Mj5SQ9v9xruCBKYYfWP-UY2pvfXCol3DzgOhA4x0");

    session_start();

    $num_cart = 0;

    if(isset($_SESSION['carrito']['productos'])) {
        $num_cart = count($_SESSION['carrito']['productos']);
    }

?>