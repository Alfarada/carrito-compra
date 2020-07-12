<?php

include 'global/config.php';
include 'global/conexion.php';
include 'cart.php';
include 'templates/_header.php';
?>

<?php

if ($_POST) {

    $total = 0;
    $s_id = session_id();
    
    foreach ($_SESSION['cart'] as $index => $product) {
        $total = $total + ($product['price'] * $product['quantity']);
    }

    echo "<h3>".$total."</h3>";
}
?> 

<?php include 'templates/_footer.php'; ?>