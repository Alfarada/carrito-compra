<?php
include 'global/config.php';
include 'cart.php';
include 'templates/_header.php';
?>

<br>
<h3>Lista del carrito</h3>

<!-- open_if -->
<?php if( !empty($_SESSION['cart'])) { ?>
<table class=" table table-bordered">
    <tbody>
        <tr>
            <th width="40%"> Descriptión</th>
            <th width="15" class="text-center"> Cantidad</th>
            <th width="20%" class="text-center"> Precio </th>
            <th width="20%" class="text-center"> Total </th>
            <th width="5%" class="text-center"> --- </th>
        </tr>
        <!-- default $total -->
        <?php $total = 0; ?>
        <!-- open-foreach -->
        <?php foreach ($_SESSION['cart'] as $index => $product ) {?>
        <tr>
            <td width="40%"> <?= $product['name']; ?> </td>
            <td width="15" class="text-center"> <?= $product['quantity']; ?> </td>
            <td width="20%" class="text-center"> <?= $product['price']; ?> </td>
            <td width="20%" class="text-center"> <?= number_format( $product['quantity'] * $product['price'], 2) ; ?> </td>
            <td width="5%">
                <!-- open form -->
                <form action="" method="post">
                    <input  id="id"
                            type="hidden"
                            name="id"
                            value=" <?= openssl_encrypt($product['id'], code, key); ?> ">
                    <button class="btn btn-danger" type="submit" name="btnAction" value="delete"> Eliminar </button>
                </form>
                <!-- close form -->
            </td>
        </tr>
        <!-- total resul t-->
        <?php $total = $total + ($product['quantity'] * $product['price']); ?>
        <?php } ?> 
        <!-- close foreach -->
        <tr>
            <td colspan="3" align="right"> <h3> Total </h3></td>
            <td align="right"> <h3> $ <?= number_format( $total, 2); ?> </h3></td>
            <td></td>
        </tr>
        <!-- request mail-->
        <tr>
            <td colspan="5">
                <form action="pay.php" method="post" >    
                    <div class="alert alert-success">
                        <div class="form-group">
                            <label for="my-input">Email de contacto :</label>
                            <input  id="email" 
                                    name="email" 
                                    class="form-control" 
                                    type="email"
                                    placeholder="Por favor, escribe tu correo."
                                    required >
                        </div>
                        <small id="emailHelp" class="form-text text-muted">
                                Los productos se enviarán a este correo </small>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" 
                            name="btnAction"        
                            type="submit"
                            value="proceed">
                            Proceder a pagar >>
                    </button>
                </form>
            </td>
        </tr>
        <!-- request mail-->
    </tbody>
</table>
<?php } else { ?>

    <div class="alert alert-success">
        No hay productos en el carro.

    </div>
<?php } ?>
<!-- end-else -->

<?php include 'templates/_footer.php'; ?>