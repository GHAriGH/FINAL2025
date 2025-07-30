 <?php
    require "CONFIG/config.php";
    require "CONFIG/database.php";
      
    $db = new Database();
    $conex = $db->Conectar(); 

    $enviado = false;

    //////Carga de tabla mensajes con los datos del formulario de Contacto//////

    if (isset($_POST['enviar'])){
        $name=trim($_POST['name']);
        $email=trim($_POST['email']);
        $telefono=trim($_POST['telefono']);
        $domicilio=trim($_POST['domicilio']);
        $plan=trim($_POST['plan']);
        $mensaje=trim($_POST['mensaje']);
        $fecha=date("d-m-y");
        $sql = $conex->prepare("INSERT INTO mensajes(Nombre, Email, Telefono, Domicilio, Id_Plan, Mensaje, Fecha) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $enviado = $sql->execute([$name, $email, $telefono, $domicilio, $plan, $mensaje, $fecha]);
    } 
    
?>    

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="IMG/icono.png">
    <title>Tucumán Gym</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/estilo.css">   
</head>

<body>

    <!--Header-------------------------------------------------------------------------------------------->

    <header>

        <div class="menu container">
            <a href="#" class="logo"><img src="IMG/pesasrojas.png" width="50" height="50"></a>
            <input type="checkbox" id="menu">
            <label for="menu">
                <img class="menu-icono" src="IMG/menu.png">
            </label>
            <nav class="navbar">
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#sucursales">Sucursales</a></li>
                    <li><a href="#planes">Planes</a></li>
                    <li><a href="#horarios">Horarios</a></li>
                    <li><a href="tienda.php">Tienda</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#inscripcion">Contacto</a></li>
                </ul>
            </nav>
        </div>

        <div class="header-text">
            <h1>Tucumán Gym</h1>
            <p>"Superá tus límites, transformá tu cuerpo, transformá tu vida"<p>
            <a href="#planes" class=btn-1>Empezá ya</a>   
        </div>

    </header>

    <!--Contenedor de tarjetas de Servicios--------------------------------------------------------------->

    <main class="servicios container" id="servicios">

        <h2>Servicios</h2>
        <p class="txt-1">
            Nuestro gimnasio ofrece una amplia gama de servicios diseñados para ayudarte a alcanzar tus metas de acondicionamiento físico y promover un estilo de vida saludable. 
        </p>

        <div class="grupo-servicios"> 

            <div class="servicio">
                <div class="face front">
                    <img src="IMG/imgServ1.jpg" alt="Bicicletas en gimnasio">
                    <h3>Equipo de entrenamiento</h3>
                </div>
                <div class="face back">
                    <h3>Equipo de entrenamiento</h3>
                    <p>
                        Proporcionamos una amplia variedad de equipos de entrenamiento, como máquinas cardiovasculares (cintas de correr, elípticas, bicicletas estáticas), máquinas de fuerza (máquinas de pesas, poleas) y pesas libres (mancuernas, barras, discos)
                    </p>
                </div>
            </div>

            <div class="servicio">
                <div class="face front">
                    <img src="IMG/imgServ2.jpg" alt="Clase grupal en gimnasio">
                    <h3>Clases grupales</h3>
                </div>
                <div class="face back">
                    <h3>Clases grupales</h3>
                    <p>
                        Ofrecemos una variedad de clases grupales dirigidas por instructores capacitados. Estas clases pueden incluir aeróbicos, entrenamiento en circuito, yoga, pilates, zumba, spinning, entrenamiento de alta intensidad (HIIT), entre otros. 
                    </p>
                </div>
            </div>

            <div class="servicio">
                <div class="face front">
                    <img src="IMG/imgServ3.jpg" alt="Entrenador en gimnasio">
                    <h3>Entrenamiento personalizado</h3>
                </div>
                <div class="face back">
                    <h3>Entrenamiento personalizado</h3>
                    <p>
                        Podrás trabajar individualmente con un entrenador certificado que evaluará tus necesidades y metas, diseñará un programa de entrenamiento personalizado y te brindará instrucción, motivación y supervisión durante las sesiones. 
                    </p>
                </div>
            </div>

            <div class="servicio">
                <div class="face front">
                    <img src="IMG/imgServ4.jpg" alt="Asesor nutricional en gimnasio">
                    <h3>Asesoramiento nutricional</h3>
                </div>
                <div class="face back">
                    <h3>Asesoramiento nutricional</h3>
                    <p>
                        Nuestro servicio de asesoramiento con profesionales en nutrición incluye evaluaciones de la dieta, planificación de comidas, recomendaciones de suplementos y seguimiento regular para mantener un estilo de vida saludable.
                    </p>
                </div>
            </div>

        </div>

    </main>

    <!--Contenedor de tarjetas de Sucursales y sus ubicaciones-------------------------------------------->

    <section class="sucursales container" id="sucursales">

        <div class="sucursal-txt">
            <h2>Sucursales</h2>
            <p>
                Nuestro enfoque se basa en tres pilares fundamentales: entrenamiento de calidad, instalaciones de vanguardia y un ambiente motivador. Contamos con un equipo de entrenadores altamente calificados está siempre para guiarte en cada paso del camino. Ya sea que desees perder peso, tonificar tu cuerpo, aumentar tu fuerza o mejorar tu resistencia, diseñaremos un programa personalizado que se ajuste a tus necesidades y te mantenga motivado.
            </p>
        </div>

        <div class="sucursal">

            <div class="card-suc">
                <div class="cara frente">
                    <img src="IMG/frente1.jpg" alt="Frente de Sucursal Norte">
                    <h3>Barrio Norte</h3>
                </div>
                <div class="cara atras">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4266.328459157357!2d-73.03806560065483!3d5.835106478994212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e6a3f08c8fb829b%3A0x985b8feb16d03dc9!2sACTIVE%20LIFE%20GYM!5e0!3m2!1ses!2sar!4v1685923086028!5m2!1ses!2sar" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div>
                        <h4>Arenales 943</h4>
                        <h4>(381) 4546474</h4>
                    </div>
                </div>
            </div>

            <div class="card-suc">
                <div class="cara frente">
                    <img src="IMG/frente2.jpg" alt="Frente de Sucursal Centro">
                    <h3>Centro</h3>
                </div>
                <div class="cara atras">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6073.427061694005!2d-3.724460222290039!3d40.437341800000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4228437ed13883%3A0xdfcd752b3813afc6!2sGimnasio%20SCG!5e0!3m2!1ses!2sar!4v1685923864150!5m2!1ses!2sar" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div>
                        <h4>Rosales 384</h4>
                        <h4>(381) 4482948</h4>
                    </div>
                </div>
            </div>

            <div class="card-suc">
                <div class="cara frente">
                    <img src="IMG/frente3.jpg" alt="Frente de Sucursal Sur">
                    <h3>Barrio Sur</h3>
                </div>
                <div class="cara atras">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6072.65202365797!2d-3.7007113222900445!3d40.44592080000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4228efdcc0413b%3A0xc4c62cf654a68a32!2sGimnasio%20McFIT!5e0!3m2!1ses!2sar!4v1685924147388!5m2!1ses!2sar" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div>
                        <h4>Las Palmas 273</h4>
                        <h4>(381) 4930201</h4>
                    </div>
                </div>
            </div>
        </div>
       
    </section>

    <!--Encabezado de sección de Planes disponibles------------------------------------------------------>

    <section class="bg-sec" id="planes">
        <div class="bg-txt container">
            <h2>Tu plan</h2>
            <p>
                Elegí la opción que más se adapte a tus necesidades y comenzá a entrenar
            </p>
        </div>
    </section>

    <!--Contenedor de Planes disponibles----------------------------------------------------------------->                        

    <section class="precios container">

        <div class="precio">
           <h3>$45000</h3> 
           <h2>Pase x clase</h2>
           <ul>
                <li>Derecho a una clase</li>
                <li>Ingreso 3 veces/semana a la misma clase</li>
                <li>Horario sujeto a clase</li>
           </ul>
           <a href="#inscripcion" class="btn-1">Inscribite</a>
        </div>

        <div class="precio">
            <h3>$50000</h3> 
            <h2>Low cost</h2>
            <ul>
                <li>Lunes a Viernes de 6.30 a 14</li>
                <li>Sábados de 9 a 17 hs</li>
                <li>Instructor en el salón</li>
            </ul>
            <a href="#inscripcion" class="btn-1">Inscribite</a>
         </div>

         <div class="precio">
            <h3>$60000</h3> 
            <h2>Pase libre multisedes</h2>
            <ul>
                <li>Acceso a todos los servicios</li>
                <li>Clases libres</li>  
                <li>Eventos exclusivos</li>
            </ul>
            <a href="#inscripcion" class="btn-1">Inscribite</a>
         </div>

    </section>

    <!--Contenedor de carrousel con horarios de Clases--------------------------------------------------->

    <section class="horarios" id="horarios">

        <h2>Horarios</h2> 

        <div class="horarios container">

            <div id="carouselExampleCaptions" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="IMG/Horario1.png" class="d-block w-50 mx-auto" alt="Imagen de clase de Funcional">
                    </div>
                    <div class="carousel-item">
                        <img src="IMG/Horarios2.png" class="d-block w-50 mx-auto" alt="Imagen de clase de Spinning">
                    </div>
                    <div class="carousel-item">
                        <img src="IMG/Horarios3.png" class="d-block w-50 mx-auto" alt="Imagen de Clase de Pilates">
                    </div>
                </div>
                
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>   

        </div>
    </section>   
    
    <!--Contenedor de sección Sobre Nosotros------------------------------------------------------------>
    
    <section class="nosotros container" id="nosotros">

        <div class="nosotros">
            <h2>Sobre nosotros</h2>
            <p>
                En Tucumán Gym, creemos que el bienestar es un estilo de vida. Somos un gimnasio con más de una década comprometido con ayudarte a alcanzar tus metas físicas y mejorar tu calidad de vida en un ambiente motivador, profesional y cercano.                
                Contamos con un equipo de instructores calificados que te acompañará en cada paso, ya sea que estés comenzando o busques superar tus propios límites. Ofrecemos una amplia variedad de servicios pensados para todas las edades y niveles de entrenamiento.
                Nuestro objetivo es que cada persona que ingrese a nuestro gimnasio se sienta parte de una comunidad que se apoya, se motiva y crece junta.
                Te invitamos a visitarnos y comenzar hoy mismo a transformar tu cuerpo y tu salud.
            </p>
            <a href="#inscripcion" class="btn-1">Empezá ya</a>
        </div>

    </section>   
    
    <!--Formulario de Contacto-------------------------------------------------------------------------->

    <section class="inscripcion container" id="inscripcion">
        <form method="post">
            <a href="#" class="logo"><img src="IMG/pesasrojas.png" width="50" height="50"></a>
            <h2>Inscribite ahora</h2>
            <h5>Dejanos tus datos, te contactaremos para que inicies tu transformación</h5>
            <div class="input-wrapper">
                <input type="text" name="name" placeholder="Nombre" required>
                <img class="input-icon" src="IMG/usuario.png" alt="Icono de Usuario">
            </div>
            <div class="input-wrapper">
                <input type="email" name="email" placeholder="Email" required>
                <img class="input-icon" src="IMG/mail.png" alt="Icono de Email">
            </div>
            <div class="input-wrapper">
                <input type="tel" name="telefono" placeholder="Telefono" required>
                <img class="input-icon" src="IMG/telefono.png" alt="Icono de Teléfono">
            </div>
            <div class="input-wrapper">
                <input type="text" name="domicilio" placeholder="Domicilio" required>
                <img class="input-icon" src="IMG/ubicacion.png" alt="Icono de Ubicación">
            </div>
            <div class="input-wrapper">
                <select name="plan" required>
                    <option value="" selected disabled>Seleccioná tu plan...</option>
                    <option value=1>Pase x Clase</option>
                    <option value=2>Low Cost</option>
                    <option value=3>Pase Libre Multisedes</option>
                </select>  
                <img class="input-icon" src="IMG/plan.png" alt="Icono de Plan">             
            </div>
            <div class="input-wrapper">
                <input type="textarea" name="mensaje" placeholder="Mensaje" rows="5" cols="50" required>
                <img class="input-icon" src="IMG/mensaje.png" alt="Icono de Mensaje">
            </div>
            <div class="boton-modal">
                <input for="btn-modal" class="btn-modal" type="submit" name="enviar" value="Enviar">                
            </div>      
               
        </form>
        
        <div class="container-modal" id="modal" <?php if ($enviado): ?> style="display: flex;" <?php else: ?> style="display: none;" <?php endif; ?>>
            <div class="content-modal">
                <h2>¡Mensaje enviado!</h2>
                <p>En breve nos comunicaremos con vos</p>
                <div class="btn-cerrar">
                    <a href="index.php"><button class="btn-cerrar">Cerrar</button></a>
                </div>
            </div>
        </div>

    </section> 

    <!--Footer------------------------------------------------------------------------------------------>

    <footer class="footer">

        <div class="container">

            <div class="footer-row">

                <div class="footer-links">
                    <h4>Gimnasio</h4>
                    <ul>
                        <li><a href="#nosotros">Nosotros</a></li>
                        <li><a href="#sucursales">Nuestras sucursales</a></li>
                        <li><a href="#">Política de privacidad</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Planes</h4>
                    <ul>
                        <li><a href="#servicios">Servicios</a></li>
                        <li><a href="#inscripcion">Consultas</a></li>
                        <li><a href="#planes">Inscribite</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Tienda</h4>
                    <ul>
                        <li><a href="tienda.php">Comprar</a></li>
                        <li><a href="#inscripcion">Reclamos</a></li>
                    </ul>
                </div>

                <div class="footer-links">
                    <h4>Seguinos</h4>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></i></a>
                        </div>
                </div>

            </div>

        </div>

    </footer> 

    <!--scripts de BOOTSTRAP V5.0----------------------------------------------------------------------------------------->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>

</body>
</html>