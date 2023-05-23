<head>
<link rel="stylesheet" type="text/css" href="css/productos.css">
</head>

<div class='contenedor-producto'>
    <?php foreach ($resultado as $row) { 
        if ($row['id'] < 17) {
            continue; // Salta los productos con ID menor a 5
        }
        
        if ($row['id'] == 21) {
            break; // Detiene el ciclo cuando el ID es mayor a 9
        }
        ?>

        <a class='enlace-producto' href='detalles.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>'>

            <?php 
            $id = $row['id'];
            $imagen = "img/productos/img-" . $id . ".jpg";

            if (!file_exists($imagen)) {
                $imagen = "img/no-photo.jpg";
            }
            ?>

            <img class='img-producto-1' src="<?php echo $imagen; ?>" alt='Imagen Camaras Seguridad'/>

            <p class='nombre-producto'><?php echo $row['nombre']; ?></p>

            <hr></hr>

            

            <p class='precio-producto-descuento'>$<?php echo number_format($row['precio'], 2, '.', ','); ?> MXN</p>

            <p class='botonCompra'>
                COMPRAR AHORA
            </p>

        </a>
    <?php } ?>
</div>


<div class='contenedor-producto'>
    <?php foreach ($resultado as $row) { 
        if ($row['id'] < 21) {
            continue; // Salta los productos con ID menor 
        }
         
        if ($row['id'] == 23) {
            break; // Detiene el ciclo cuando el ID es mayor 
        }
        ?>

        <a class='enlace-producto' href='detalles.php?id=<?php echo $row['id'];?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>'>

            <?php 
            $id = $row['id'];
            $imagen = "img/productos/img-" . $id . ".jpg";

            if (!file_exists($imagen)) {
                $imagen = "img/no-photo.jpg";
            }
            ?>

            <img class='img-producto-1' src="<?php echo $imagen; ?>" alt='Imagen Camaras Seguridad'/>

            <p class='nombre-producto'><?php echo $row['nombre']; ?></p>

            <hr></hr>

            

            <p class='precio-producto-descuento'>$<?php echo number_format($row['precio'], 2, '.', ','); ?> MXN</p>

            <p class='botonCompra'>
                COMPRAR AHORA
            </p>

        </a>
    <?php } ?>
</div>


