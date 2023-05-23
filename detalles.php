<?php 
    require 'config/database.php';
    require 'config/config.php';

    $db = new Database();
    $con = $db->conectar();
    
    //l trim es para solucionar un error al generar el token unico, en la pagina y evitar errores
   
    $id = isset($_GET['id']) ? trim($_GET['id']) : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    //Validamos si esta vacio el token y el id generado

    if($id == '' || $token == ''){
        echo 'Error al procesar la peticion';
        exit;
    }else{

        $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

        if($token == $token_tmp){

            $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);
            if($sql->fetchColumn() > 0){

                
            $sql = $con->prepare("SELECT nombre, precio, descuento, descripcion , CONCAT('img/productos/img-', id, '.jpg') AS imagen FROM productos WHERE id=? AND activo=1");
            $sql->execute([$id]);
            $row  = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_descuento = $precio - ($precio * $descuento) / 100 ;
            $descripcion = $row['descripcion'];
            $imagen = $row['imagen']; 
 
            // $dir_imagenes = 'img/productos/img-'.$id.'.jpg';

           // $rutaImg = $dir_imagenes . 'img-1.jpg';
            
            //if(!file_exists($rutaImg)){
              //  $rutaImg = 'img/no-photo.jpg';
            //}

          /*  $imagenesArray = array();
            $dir = dir($dir_imagenes);

            while(($archivo = $dir->read()) != false){
                if($archivo != 'img-1.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))){

                    $imagenesArray[] = $dir_imagenes . $archivo;

                }
            }
            $dir->close();

                */


            }
        }else{
            echo 'Error al procesar la peticion por los tokens';
            exit;
        }
    }

   
    
?>





    <head>
            <link rel="stylesheet" type="text/css" href="css/index.css">
            <link rel="stylesheet" type="text/css" href="css/detalles.css">
            <link rel="icon" href="img/icono_logo.png">
           
    </head>



    <div class="App">

        <div class="contenedor-principal">


            <div class="contenedor_cabecera">

            <?php include('componentes/cabecera.php'); ?>

            </div>

            <div class="contenedor_menu">

            <?php include('componentes/menu.php'); ?>

            </div>

            

         
        

        <div class="contenedor_detalles">

                <div class ="contenedor-imagen">        

                <img class="imagen-fuente" src="<?php /*Agregar carrusel imagenes*/ echo $imagen; ?>">

                </div> 


            <div class="informacion-producto"> 

                <div class="nombre-producto"><p><?php echo $nombre; ?></p></div>

                <?php if($descuento > 0 ){ ?>

                    <div class="precio-producto-descuento"><p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p></div>

                    <div class="precio-producto">
                        <p><?php echo MONEDA . number_format($precio_descuento, 2, '.', ','); ?></p>
                    </div>

                    <div class="porcentaje-descuento"><?php echo $descuento; ?> % descuento </div>


                   <?php  }else { ?>
                
                    <div class="precio-producto"><p><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></p></div>

                    <?php  } ?>
               
                <div class = "descripcion-producto"> <p><?php echo $descripcion; ?></p></div> 

                <div class="contenedor-botones">

                    <button class="boton-comprar">Comprar ahora</button>

                    <button class="boton-carrito" type="button" onClick="agregarProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>' )" >Agregar al carrito</button>
                
                </div>

            </div>
                
        </div>

            <div class="contenedor_footer">

            <?php include('componentes/footer.php'); ?>

            </div>

            




        </div>

                <script> 
                    function agregarProducto(id, token){

                        let url = 'clases/carrito.php'
                        let formData = new FormData()
                        formData.append('id',id)
                        formData.append('token',token)
            
                        //Enviamos los datos de de formData mediante el metodo POST
                        //Y nos devuelve el resultado 

                        fetch(url, {
                            method: 'POST',
                            body: formData,
                            mode: 'cors'
                        }).then(response => response.json())
                        .then(data => {
                            if(data.ok){
                                let elemento = document.getElementById("num_cart");
                                elemento.innerHTML = data.numero;
                            }
                        })
                    }
                
                
                </script>


    </div>
    



