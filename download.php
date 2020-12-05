<?php
include 'global/config.php';
include 'global/conexion.php';
include 'cart.php';
include 'templates/_header.php';
?>

<?php
print_r($_POST);
// var_dump($_POST);

if ($_POST) {
    $sale_id = $_POST['sale_id'];
    $product_id = $_POST['product_id'];

    $sentence = $pdo->prepare("SELECT * FROM `create_sale_detail_table` 
                                WHERE sale_id=:sale_id 
                                AND product_id=:product_id 
                                AND download < 1"
                            );

    $sentence->bindParam(":sale_id",$sale_id);
    $sentence->bindParam(":product_id",$product_id);
    $sentence->execute();

    $products = $sentence->fetchAll(PDO::FETCH_ASSOC);

    print_r($products);
}
?>

<?php include 'templates/_footer.php'; ?>