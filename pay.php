<?php

include 'global/config.php';
include 'global/conexion.php';
include 'cart.php';
include 'templates/_header.php';
?>

<?php

if ($_POST) {

    $total = 0;
    $sessionId = session_id();
    $email = $_POST['email'];

    foreach ($_SESSION['cart'] as $index => $product) {
        $total = $total + ($product['price'] * $product['quantity']);
    }

    $sentence = $pdo->prepare(
       "INSERT 
        INTO `create_sales_table` (`id`, `transaction_key`, `paypal_data`, `date`, `mail`, `total`, `status`)
        VALUES (NULL, :transaction_key, '', NOW() , :email, :total, 'pendiente');"
    );

    $sentence->bindParam(":transaction_key", $sessionId);
    $sentence->bindParam(":email", $email);
    $sentence->bindParam(":total", $total);
    $sentence->execute();
    $saleId = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $index => $product) {

    $sentence = $pdo->prepare( 
       "INSERT
        INTO `create_sale_detail_table` (`id`, `sale_id`, `product_id`, `price`, `quantity`, `download`)
        VALUES (NULL, :sale_id, :product_id, :price, :quantity , '0')");

        $sentence->bindParam(":sale_id", $saleId);
        $sentence->bindParam(":product_id", $product['id']);
        $sentence->bindParam(":price", $product['price']);
        $sentence->bindParam(":quantity", $product['quantity']);
        $sentence->execute();

        //print_r($sentence);
    }

    //echo "<h3>".$total."</h3>";
}
?> 

<div class="jumbotron text-center">
    <h1 class="display-4"> ! Paso final ¡</h1>
    <hr class="my-4">
    <p class="lead"> Estas a punto de pagar con paypal la cantidad de: 
        <h4> $ <?= number_format($total, 2); ?> </h4>
    </p>
    <p>Los productos podrán ser descargados una vez que se procese el pago
        <strong>( Para aclaraciones : uhperezoscar@gmail.com)</strong>
    </p>
</div>

<?php include 'templates/_footer.php'; ?>