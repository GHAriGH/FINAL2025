<?php

    require "CONFIG/config.php";
    require "CONFIG/database.php";
    
    $db = new Database();
    $conex = $db->Conectar();

    $id = isset($_GET["id"]) ? $_GET["id"] : "";
    $token = isset($_GET["token"]) ? $_GET["token"] : "";

    if($id == "" || $token == "") {
        echo "Error al procesar la petición";
        exit;
    } else {
        $token_tmp = hash_hmac("sha1", $id, KEY_TOKEN);

        if($token == $token_tmp) {

            $sql = $conex->prepare("SELECT COUNT(Id_Producto) FROM Productos WHERE Id_Producto = ? AND Activo = 1");
            $sql->execute([$id]);

            if($sql->fetchColumn() > 0){

                $sql = $conex->prepare("SELECT Nombre, Descripcion, Precio FROM Productos WHERE Id_Producto =? AND Activo = 1 LIMIT 1");
                $sql->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $nombre = $row["Nombre"];
                $descripcion = $row["Descripcion"];
                $precio = $row["Precio"];
                $preciodesc = $precio * 0.9;
                $dir_imagen = "IMG/PRODUCTOS/" . $id . "/";
                $imagen = $dir_imagen . "principal.png";

                if(!file_exists($imagen)) {
                    $imagen = "IMG/PRODUCTOS/No-Foto.png";
                }

                $imagenes = array();
                if(file_exists($dir_imagen)){
                    $dir = dir($dir_imagen);

                    while(($archivo = $dir->read()) != false){
                        if($archivo != "principal.png" && (strpos($archivo, ".png"))){
                            $imagenes[] = $dir_imagen . $archivo;
                        }
                    }
                $dir->close();
                }    
            } 
            
        } else {
            echo "Error al procesar la petición";
            exit;
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
            <div class="row">
                <div class="col-md-6 order-md-1">
                    <div id="carouselImg" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $imagen ?>"class="d-block w-100">
                            </div>
                            <?php foreach($imagenes as $img) { ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img ?>"class="d-block w-100">
                                </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImg" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImg" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><strong><?php echo $nombre ?></strong></h2>
                    <h3><strong>$ <?php echo number_format($precio, 2, ",", ".") ?></strong></h3>
                    <h4>Precio p/Socio: $ <?php echo number_format($preciodesc, 2, ",", ".") ?></h4>
                    <p class="lead">
                        <?php echo $descripcion ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-light" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Agregar al Carrito</button>
                    </div>
                </div>
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