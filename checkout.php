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
}



//session_destroy();


?>


<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/checkout.css">

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


        <div class="contenedor-carrito">

            <div class="tabla-productos">
                <table class="tabla">


                    <thead>

                        <tr>

                            <th>Producto
                                <hr class="sombreado-titulo">
                            </th>
                            <th>Precio
                                <hr class="sombreado-titulo">
                            </th>
                            <th>Cantidad
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
                                    $total += $subtotal;

                        ?>


                                    <tr>
                                        <td> <?php echo $nombre ?>
                                            <hr class="sombreado-producto">
                                        </td>
                                        <td> <?php echo MONEDA . number_format($precio_descuento, 2, '.', ','); ?>
                                            <hr class="sombreado-producto">
                                        </td>
                                        <td>

                                            <input type="number" min="1" max="10" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">

                                            <hr class="sombreado-producto">
                                        </td>
                                        <td>
                                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">

                                                <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>

                                            </div>
                                            <hr class="sombreado-producto">
                                        </td>
                                        <td>
                                            <a id="eliminar" class="boton-eliminar" data-bs-id="<?php echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>
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



            <?php if ($lista_carrito != null) { ?>

                <div class="row">
                    <div class="boton-comprar">
                        <a href="pago.php" class="boton-raiz">Realizar compra</a>
                    </div>
                </div>

            <?php } ?>




            <!-- Modal -->
            <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eliminaModalLabel">Alerta</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Desea eliminar el producto de la lista?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Option 1: Bootstrap Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>








            <script>
                let eliminaModal = document.getElementById('eliminaModal');
                eliminaModal.addEventListener('show.bs.modal', function(event) {
                    let button = event.relatedTarget;
                    let id = button.getAttribute('data-bs-id');
                    let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina');
                    buttonElimina.value = id;
                })




                //////////////////////////////////////////////////////////////////

                function actualizaCantidad(cantidad, id) {

                    let url = 'clases/actualizar-carrito.php'
                    let formData = new FormData()
                    formData.append('id', id)
                    formData.append('cantidad', cantidad)
                    formData.append('action', 'agregar')


                    //Enviamos los datos de de formData mediante el metodo POST
                    //Y nos devuelve el resultado 

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            mode: 'cors'
                        }).then(response => response.json())
                        .then(data => {
                            if (data.ok) {

                                let divsubtotal = document.getElementById('subtotal_' + id);
                                divsubtotal.innerHTML = data.sub;

                                let total = 0.0;
                                let list = document.getElementsByName('subtotal[]');

                                for (let i = 0; i < list.length; i++) {
                                    total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
                                }

                                total = new Intl.NumberFormat('en-US', {
                                    minimumFractionDigits: 2
                                }).format(total)
                                document.getElementById('total').innerHTML = '<?php echo  MONEDA; ?>' + total;


                            }
                        })
                }

                function eliminar() {

                    let botonElimina = document.getElementById('btn-elimina');
                    let id = botonElimina.value;


                    let url = 'clases/actualizar-carrito.php'
                    let formData = new FormData()
                    formData.append('id', id)
                    formData.append('action', 'eliminar')


                    //Enviamos los datos de de formData mediante el metodo POST
                    //Y nos devuelve el resultado 

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            mode: 'cors'
                        }).then(response => response.json())
                        .then(data => {
                            if (data.ok) {

                                location.reload();

                            }
                        })
                }
            </script>



        </div>





        <div class="contenedor_footer">

            <?php include('componentes/footer.php'); ?>

        </div>






    </div>

</div>