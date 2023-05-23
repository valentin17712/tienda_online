<?php 

    require '../config/config.php';

    //Verificamos si nos estan enviando los datos

    if(isset($_POST['id'])){
        
        //Recibimos los datos 

        $id = $_POST['id'];
        $token = $_POST['token'];

        //Validamos que el Token este correcto

        $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

        if($token == $token_tmp){

            //Asignar la cantidad de productos
            /*Se podria agregar con un input para que el usuario lo pueda hacer*/

            if(isset($_SESSION['carrito']['productos'][$id])){

                $_SESSION['carrito']['productos'][$id] += 1;
            
            }else{
                
                $_SESSION['carrito']['productos'][$id] = 1;
        
            }

            //Conocemos la cantidad de productos almacenamos en el carrito

            $datos['numero'] = count($_SESSION['carrito']['productos']);
            $datos['ok'] = true;

        }else{
            $datos['ok'] = false;
        
        }

    }else{
        $datos['ok'] = false;
    }

    //Para recibirlo en el Ajax de detalles

echo json_encode($datos);

?>