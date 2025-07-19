<?php
    require 'vendor/autoload.php';

    MercadoPago\SDK::setAccessToken(TOKEN_MP);

    $item = new MercadoPago\Item();
    $item->id = '00001';
    $item->title = 'Producto';
    $item->quantity = 1;
    $item->unit_price = 150.00;
    $item->currency_id = 'ARS';

    $preference = new MercadoPago\Preference();
    $preference->items = array($item);
    $preference->back_urls = array(
        "success" => "http://localhost/FINAL/CLASES/capturamp.php",
        "failure" => "http://localhost/FINAL/CLASES/fallo.php"
    );
    $preference->auto_return = "approved";
    $preference->binary_mode = true;
    $preference->save();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h3>Mercado Pago</h3>
    <div class="checkout-btn"></div>
    <script>
        const mp = new MercadoPago('TEST-3716fa81-b5cb-49b8-9f72-f399ca469c74', {
            locale: 'es-AR'
        });
        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.checkout-btn',
                label: 'Pagar con MP'
            }
        })
    </script>
</body>
</html>