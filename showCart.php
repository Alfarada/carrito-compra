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
            <td width="5%"><button class="btn btn-danger" type="button"> Eliminar </button></td>
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
    </tbody>
</table>
<?php } else { ?>

    <div class="alert alert-success">
        No hay productos en el carro.

    </div>
<?php } ?>
<!-- end-else -->

<?php include 'templates/_footer.php'; ?>