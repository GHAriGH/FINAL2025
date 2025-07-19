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
              
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total = 0;
                            if($lista_carrito == null){
                                echo '<tr><td colspan="5" class="text-center"><b>Carrito Vacío</b></td></tr>';
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
                                        <td><?php echo '$ ' . number_format($precio, 2, ',', '.'); ?></td>
                                        <td>
                                            <input type="number" min="1" max="100" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                                        </td>
                                        <td>
                                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                                <?php echo '$ ' . number_format($subtotal, 2, ',', '.'); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php }    
                            } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo '$ ' . number_format($total, 2, ',', '.'); ?></p>
                                </td>

                            </tr>
                    </tbody>

                </table>
            </div>
            <?php if($lista_carrito != null) { ?>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <a href="pagos.php" class="btn btn-primary btn-lg">Pagar</a> 
                    <a href="tienda.php" class="btn btn-dark">Volver a la Tienda</a>          
                </div> 
            </div>
            <?php } ?>               
        </div>
        
    </main>

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="eliminaModalLabel">Atención</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            ¿Desea eliminar el producto del carrito?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" id="btn-elimina" class="btn btn-primary" onclick="eliminar()">Eliminar</button>
        </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>

        let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id
        })
        
        function actualizaCantidad(cantidad, id){
            let url = 'CLASES/actualizarCarrito.php'
            let formData = new FormData()
            formData.append('cantidad', cantidad)
            formData.append('id', id)
            formData.append('action', 'agregar')
            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data=> {
                if(data.ok) {

                    let divsubtotal = document.getElementById('subtotal_' + id)
                    divsubtotal.innerHTML = data.sub

                    let total = 0.00
                    let list = document.getElementsByName('subtotal[]')

                    for(let i = 0; i < list.length; i++){
                        total += parseFloat(list[i].innerHTML.replace(/[$ .]/g, ''))
                    }

                    total = new Intl.NumberFormat('es-ES', {minimumFractionDigits: 2}).format(total)

                    document.getElementById('total').innerHTML = '<?php echo '$ '; ?>' + total
                    
                } 
            })
        }

        function eliminar(){

            let botonElimina = document.getElementById('btn-elimina')
            let id = botonElimina.value
            let url = 'CLASES/actualizarCarrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('action', 'eliminar')
            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data=> {
                if(data.ok) {
                    location.reload()                   
                } 
            })
        }


    </script>

</body>
</html>

