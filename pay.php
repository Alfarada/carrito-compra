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
        "   INSERT 
            INTO `create_sales_table` (`id`, `transaction_key`, `paypal_data`, `date`, `mail`, `total`, `status`)
            VALUES (NULL, :transaction_key, '', NOW() , :email, :total, 'pendiente');"
    );

    $sentence->bindParam(":transaction_key", $s_id);
    $sentence->bindParam(":email", $email);
    $sentence->bindParam(":total", $total);
    $sentence->execute();
    $saleId = $pdo->lastInsertId();

    echo "<h3>".$total."</h3>";
}
?> 

<?php include 'templates/_footer.php'; ?>