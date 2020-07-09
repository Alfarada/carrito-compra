<?php
include 'global/config.php';
include 'cart.php';
include 'templates/_header.php';
?>

<br>
<h3>Lista del carrito</h3>

<table class=" table table-bordered">
    <tbody>
        <tr>
            <th width="40%"> Descriptión</th>
            <th width="15" class="text-center"> Cantidad</th>
            <th width="20%" class="text-center"> Precio </th>
            <th width="20%" class="text-center"> Total </th>
            <th width="5%" class="text-center"> --- </th>
        </tr>
        <tr>
            <td width="40%"> Libro php </td>
            <td width="15" class="text-center"> 1 </td>
            <td width="20%" class="text-center"> Precio </td>
            <td width="20%" class="text-center"> Total </td>
            <td width="5%"><button class="btn btn-danger" type="button"> Eliminar </button></td>
        </tr>
        <tr>
            <td width="40%"> Libro vue </td>
            <td width="15" class="text-center"> 1 </td>
            <td width="20%" class="text-center"> Precio </td>
            <td width="20%" class="text-center"> Total </td>
            <td width="5%"><button class="btn btn-danger" type="button"> Eliminar </button></td>
        </tr>
        <tr>
            <td colspan="3" align="right"> <h3> Total </h3></td>
            <td align="right"> <h3> $ <?= number_format(300,2); ?> </h3></td>
            <td></td>
        </tr>
    </tbody>
</table>

<?php include 'templates/_footer.php'; ?>