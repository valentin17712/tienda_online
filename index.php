<?php 
  
    require 'config/database.php';
    require 'config/config.php';

    $db = new Database();
    $con = $db->conectar();

    $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    //session_destroy();


?>

    <head>
            <link rel="stylesheet" type="text/css" href="css/index.css">
            <link rel="icon" href="img/icono_logo.png">

    </head>



    <div class="App">

        <div class="contenedor-principal">


            <div class="contenedor_cabecera"><?php include('componentes/cabecera.php'); ?></div>

            <div class="contenedor_menu"><?php include('componentes/menu.php'); ?></div>

            <div class="contenedor_carrusel">

            <?php
            $imagenes = ['img/carrusel/slide-1.webp',
                         'img/carrusel/slide-2.webp',
                         'img/carrusel/slide-3.webp' ];?> 

                    <div class="carousel">
                        <?php foreach ($imagenes as $index => $imagen): ?>
                            <img src="<?php echo $imagen; ?>" <?php echo ($index === 0) ? 'class="active"' : ''; ?>>
                        <?php endforeach; ?>
                    </div>

             <script>
                    var images = document.querySelectorAll('.carousel img');
                    var index = 0;

                        function showImage() {
                            for (var i = 0; i < images.length; i++) {
                                 images[i].classList.remove('active');
                            }

                                 images[index].classList.add('active');
                        }

                            function nextImage() {
                                index = (index + 1) % images.length;
                                showImage();
                            }

                            function previousImage() {
                                index = (index - 1 + images.length) % images.length;
                                showImage();
                            }

                                setInterval(nextImage, 5000); // Cambiar la imagen cada 3 segundos
            </script>      

             
            </div>

            <div class="ofertas"> <h1>Aprovechas las ultimas ofertas disponibles!!</h1>  </div>
        

            <div class="contenedor_productos"><?php include('componentes/productos.php'); ?></div>

            <div class="contenedor_footer"><?php include('componentes/footer.php'); ?></div>

        </div>

    </div>
    



