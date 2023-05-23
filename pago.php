<?php

require 'config/database.php';
require 'config/config.php';

$db = new Database();
$con = $db->conectar();


//Recibir los datos del arreglo

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

//print_r($_SESSION);

$lista_carrito = array();

//Vaciamos el arreglo con un foreach

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    header("Location: index.php");
    exit;
}

?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/pago.css">

    <link rel="icon" href="img/icono_logo.png">
</head>



<div class="App">

    <div class="contenedor-principal">

        <div class="contenedor_cabecera"><?php include('componentes/cabecera.php'); ?></div>

        <div class="contenedor_menu"><?php include('componentes/menu.php'); ?></div>


        <div class="contenedor-carrito">


            <div class="row">
                <div class="col-6" id="texto-detalles-pago">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>

                <div class="col-6">

                    <div class="tabla-productos">
                        <table class="tabla">
                            <thead>

                                <tr>

                                    <th>Producto
                                        <hr class="sombreado-titulo">
                                    </th>
                                    <th>Subtotal
                                        <hr class="sombreado-titulo">
                                    </th>
                                    <th> &nbsp;
                                        <hr class="sombreado-titulo">
                                    </th>

                                </tr>

                            </thead>



                            <tbody class="datos-productos">

                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        foreach ($producto as $item) {
                                            $_id = $item['id'];
                                            $nombre = $item['nombre'];
                                            $precio = $item['precio'];
                                            $descuento = $item['descuento'];
                                            $cantidad = $item['cantidad'];
                                            $precio_descuento = $precio - (($precio * $descuento) / 100);
                                            $subtotal = $cantidad * $precio_descuento;
                                            $total += $subtotal; ?>


                                            <tr>
                                                <td> <?php echo $nombre ?>
                                                    <hr class="sombreado-producto">
                                                </td>

                                                <td>
                                                    <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">

                                                        <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>

                                                    </div>
                                                    <hr class="sombreado-producto">
                                                </td>

                                            </tr>

                                        <?php } ?>
                                    <?php } ?>

                            </tbody>

                            <tr class="cantidad-total">
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                </td>
                            </tr>

                        <?php } ?>
                        </table>
                    </div>
                </div> 


            </div>



            <!-- Option 1: Bootstrap Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

            <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>

            <script>
                paypal.Buttons({

                    style: {
                        color: 'blue',
                        shape: 'pill',
                        label: 'pay'


                    },
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: <?php echo $total; ?>
                                }
                            }]
                        })
                    },

                    onApprove: function(data, actions) {


                        let url ='clases/captura.php';
                        actions.order.capture().then(function(detalles) {
                            console.log(detalles);
                            window.location.href = "index.php";


                            // Enviamos la informacion de la compra

                            return fetch(url, {
                                method: 'post',
                                headers: {
                                    'content-type': 'application/json'
                                },
                                body: JSON.stringify({
                                    detalles: detalles
                                })

                            })/** .then(function(response){
                                window.location.href="completado.html";
                            })**/

                        }); 

                    },

                    onCancel: function(data) {
                        alert("Pago cancelado");
                        console.log(data);
                    }

                }).render('#paypal-button-container');
            </script>


        </div>


        <div class="contenedor_footer">

            <?php include('componentes/footer.php'); ?>

        </div>


    </div>

</div>