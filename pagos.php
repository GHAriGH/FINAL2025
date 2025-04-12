<?php

    require "CONFIG/config.php";
    require "CONFIG/database.php";
      
    $db = new Database();
    $conex = $db->Conectar();

    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    $lista_carrito = array();

    if($productos != null) {
        foreach($productos as $clave => $cantidad){

            $sql = $conex->prepare("SELECT Id_Producto, Nombre, Precio, $cantidad AS cantidad FROM Productos WHERE Id_Producto = ? AND Activo = 1");
            $sql->execute([$clave]);
            $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);

        }
    } else {
        header("Location: tienda.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="IMG/icono.png">
    <title>Tucuman Gym: Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS\estilo-tienda.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>
<body>

    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="tienda.php" class="navbar-brand">
                    <img src="IMG/pesasrojas.png" width="50" height="50">
                    <strong>Tienda Online Tucumán Gym</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="#" class="nav-link active">Tu esfuerzo merece lo mejor
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
           
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de Pago</h4>
                    <div id="paypal-button-container"></div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $total = 0;
                                    if($lista_carrito == null){
                                        echo '<tr><td colspan="4" class="text-center"><b>Carrito Vacío</b></td></tr>';
                                    } else {
                                        foreach($lista_carrito as $producto){
                                            $_id = $producto['Id_Producto'];
                                            $nombre = $producto['Nombre'];
                                            $precio = $producto['Precio'];
                                            $cantidad = $producto['cantidad'];
                                            $subtotal = $cantidad * $precio;
                                            $total += $subtotal;
                                            ?>    
                                            <tr>
                                                <td><?php echo $nombre; ?></td>
                                                <td>
                                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                                        <?php echo '$ ' . number_format($subtotal, 2, ',', '.'); ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }    
                                    } ?>
                                    <tr>
                                        <td colspan="2">
                                            <p class="h3 text-end" id="total"><?php echo '$ ' . number_format($total, 2, ',', '.'); ?></p>
                                        </td>

                                    </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>                    
        </div>
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>"></script>

    <script>
        paypal.Buttons({
            style:{
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total;?>
                        }
                    }]
                });
            },
            onApprove: function(data, actions){
                let url = 'CLASES/captura.php'
                actions.order.capture().then(function(detalles){
                    alert("Su pago fue exitoso");
                    /*window.location.href = "tienda.php"*/
                    return fetch(url, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response){
                        window.location.href = "completado.php?key=" + detalles['id'];
                    })
                });
                
            },
            onCancel: function(data){
                alert("Pago Cancelado")
                console.log(data)
            }
        }).render('#paypal-button-container');
    </script>

</body>
</html>

