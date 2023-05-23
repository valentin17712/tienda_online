<?php

    //Reducir los datos al llamar al paypal
    define("CLIENT_ID","AUYbtkYuATflJq9T6GjuLmtxHwfkxHx6UNlT-GvJD5a7xwzXvRAFDayyMqc9szq6xx4YQ8InAPJ3TeA0");
    define("CURRENCY","MXN");
    
    //Clave de cifrado productos
    define("KEY_TOKEN","APR.wqc-354*");
    
    //Nomenclatura para conversion Moneda
    define("MONEDA","$");

        //Iniciar la sesion para el carrito
        session_start();


    $num_cart = 0;

    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
        
    }


?>