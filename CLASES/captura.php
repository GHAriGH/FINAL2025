<?php

require "../CONFIG/config.php";
require "../CONFIG/database.php";
  
$db = new Database();
$conex = $db->Conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json,true);

if(is_array($datos)) {

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $estado = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $sql = $conex->prepare("INSERT INTO ventas (Id_Transaccion, Fecha, Estado, Email, Id_Cliente, Total) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$id_transaccion, $fecha_nueva, $estado, $email, $id_cliente, $total]);
    $id = $conex->lastInsertId();

    if($id > 0) {
        var_dump($_SESSION['carrito']);

        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

        if($productos != null) {
            foreach($productos as $clave => $cantidad){
    
                $sql_prod = $conex->prepare("SELECT Id_Producto, Nombre, Precio FROM productos WHERE Id_Producto = ? AND Activo = 1");
                $sql_prod->execute([$clave]);
                $row_prod = $sql_prod->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['Precio'];

                $sql_detalle = $conex->prepare("INSERT INTO detalle_venta (Id_Venta, Id_Producto, Cantidad) VALUES (?, ?, ?)");
                $sql_detalle->execute([$id, $clave, $cantidad]);
    
            }
            include 'enviarEmail.php';
        }
        
        unset($_SESSION['carrito']);        
    }
}

?>