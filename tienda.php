<?php

    require "CONFIG/config.php";
    require "CONFIG/database.php";
      
    $db = new Database();
    $conex = $db->Conectar();
    $sql = $conex->prepare("SELECT Id_Producto, Nombre, Precio FROM Productos WHERE Activo= 1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

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
                <a href="index.php" class="navbar-brand">
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
                    <a href="checkout.php" >
                        <img src="IMG/carrito-de-compras.png" id="Carrito" width="50" height="50">
                        <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
           
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                <?php foreach($resultado as $row) { ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <?php
                            $id = $row["Id_Producto"];
                            $imagen = "IMG/PRODUCTOS/" . $id . "/principal.png";
                            if(!file_exists($imagen)) {
                                $imagen = "IMG/PRODUCTOS/No-Foto.png";
                            }
                        ?>
                        <img src = "<?php echo $imagen ?>" class="w-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["Nombre"] ?></h5>
                            <p class="card-text"><?php echo "$ " . number_format($row["Precio"], 2, ",", ".") ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="detalles.php?id=<?php echo $row["Id_Producto"]; ?>&token=<?php echo hash_hmac("sha1", $row["Id_Producto"], KEY_TOKEN); ?>" class="btn btn-primary">Ver más</a>
                                </div>
                                <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $row['Id_Producto']; ?>, '<?php echo hash_hmac('sha1', $row['Id_Producto'], KEY_TOKEN); ?>')">Agregar</button>
                            </div>
                        </div>
                    </div>   
                </div>     
                <?php } ?>
            </div>    
        </div>
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token){
            let url = 'CLASES/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)
            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response=>response.json())
            .then(data=>{
                if(data.ok){
                    let elementos = document.getElementById('num_cart');
                    elementos.innerHTML = data.numero
                } 
            })
        }
    </script>
</body>
</html>