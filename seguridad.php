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
            <link rel="stylesheet" type="text/css" href="css/categorias.css">
            <link rel="icon" href="img/icono_logo.png">

    </head>



    <div class="App">

        <div class="contenedor-principal-categoria">

            

            <div class="contenedor_cabecera"><?php include('componentes/cabecera.php'); ?></div>

            <div class="contenedor_menu"><?php include('componentes/menu.php'); ?></div>

        
             
            

            <div class="ofertas"> <h1>SEGURIDAD</h1>  </div>
        

            <div class="contenedor_productos"><?php include('componentes/productos-seguridad.php'); ?></div>

            <div class="contenedor_footer"><?php include('componentes/footer.php'); ?></div>

        </div>

    </div>
    