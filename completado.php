<?php
    require "CONFIG/config.php";
    require "CONFIG/database.php";
       
    $db = new Database();
    $conex = $db->Conectar();

    $id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';
    $error = '';

    if($id_transaccion == '') {
        $error = 'Error al procesar la petición';
    } else {
        $sql = $conex->prepare("SELECT COUNT(Id_Venta) FROM ventas WHERE Id_Transaccion = ? AND Estado = ?");
        $sql->execute([$id_transaccion, 'COMPLETED']);
       
        if($sql->fetchColumn() > 0){

            $sql = $conex->prepare("SELECT Id_Venta, Fecha, Email, Total FROM ventas WHERE Id_Transaccion = ? AND Estado = ? LIMIT 1");
            $sql->execute([$id_transaccion, 'COMPLETED']);
            $rowVta = $sql->fetch(PDO::FETCH_ASSOC);

            $idVenta = $rowVta['Id_Venta'];
            $fecha = $rowVta['Fecha'];
            $total = $rowVta['Total'];

            $sqlDet = $conex->prepare("SELECT productos.Nombre, productos.Precio, detalle_venta.Cantidad FROM detalle_venta INNER JOIN productos ON detalle_venta.Id_Producto = productos.Id_Producto WHERE detalle_venta.Id_Venta = ?");
            $sqlDet->execute([$idVenta]);
            //$rowDet = $sqlDet->fetch(PDO::FETCH_ASSOC);

        } else {
            $error = 'Error al completar la venta';
        }    
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
    <link rel="stylesheet" href="CSS/estilo-tienda.css">
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

<!--test-->
    <main>
        <div class="container">

            <?php if(strlen($error) > 0) { ?>
                <div class="row">
                        <div class="col">
                            <h3><?php echo $error; ?></h3>
                        </div>
                </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col">
                            <b>ID de la Venta: <?php echo $id_transaccion; ?></b><br>
                            <b>Fecha: <?php echo $fecha; ?></b><br>
                            <b>Total: <?php echo '$ ' . number_format($total, 2, ',', '.'); ?></b><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($rowDet = $sqlDet->fetch(PDO::FETCH_ASSOC)) { 
                                        $importe = $rowDet['Cantidad'] * $rowDet['Precio']; ?>
                                        <tr>
                                            <td><?php echo $rowDet['Nombre']; ?></td>
                                            <td><?php echo $rowDet['Cantidad']; ?></td>
                                            <td><?php echo  '$ ' . number_format($importe, 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php } ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>            
            <?php } ?>   
        </div>        
    </main>
</body>
</html>