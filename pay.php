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

        print_r($sentence);
    }

    echo "<h3>".$total."</h3>";
}
?> 

<?php include 'templates/_footer.php'; ?>