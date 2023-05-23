<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <title>Flash Electronics</title>

    <link rel="stylesheet" type="text/css" href="css/cabecera.css">
    
 
</head>
<body> 
     

<header class='contenedor-header'>



            <div class='cabeceraContenedorPrincipal'>

            <strong class='logo'>

                <a href="index.php">  <img src="img/logoElectronics.png" alt="Logo de la Tienda" /> </a> 
                    
                </strong>

                <div class='block-search'>


                    <input class='search' type='text' placeholder='Buscar en toda la tienda....' autoComplete='off' >
                    </input>

                    <button class='boton-search'>

                    
                        <img src="img/lupa-busqueda.png" alt="Boton de Busqueda" />
                        
                    </button>


                </div>

                <div class='iniciarSesion'>

                 <label class='tag-sesion' ><strong>Iniciar sesión</strong> </label>
                  
                 <img class='icono-sesion' src="img/acceso.png" alt="Iniciar Sesion"  />
                 

                </div>

                <div class='carritoCompras'><a href="checkout.php">

                 <label class='tag-carrito' ><strong>
                    Carrito<span id="num_cart">(<?php echo $num_cart ?>)</span>
                </strong> </label>
                  
                 <img class='icono-carrito' src="img/carrito.png" alt="Carrito de compras"  />
                 
                </a>
                </div>




            </div>


        </header>


        </body>
</html>