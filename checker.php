<?php

include 'global/config.php';
include 'global/conexion.php';
include 'cart.php';
include 'templates/_header.php';
?>

<?php

$clientId = "AXlAuQZdeYFxfSn4n5bDvvu6EGbeYAMQnT6XSd7v4C8CNzDa6PWIJOx56MiwatzyBjK5RVHekA-2WfaF";
$secret = "EBJyjKAO3VUKUo1zVZ23d-iATTOErOUA2XLjtEf0dIKKFa0iLiPHPAafUasJBnBexCvwM4r65Yh6gQet";

$login = curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");

curl_setopt($login, CURLOPT_RETURNTRANSFER, true);

curl_setopt($login, CURLOPT_USERPWD, $clientId . ":" . $secret);

curl_setopt($login, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$reply = curl_exec($login);

$responseObject = json_decode($reply);

$accessToken = $responseObject->access_token;

$sale = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/" . $_GET['paymentID']);

curl_setopt($sale, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . $accessToken));

curl_setopt($sale, CURLOPT_RETURNTRANSFER, true);

$saleResponse = curl_exec($sale);

$objectTransactionData = json_decode($saleResponse);

$state = $objectTransactionData->state;
$email = $objectTransactionData->payer->payer_info->email;

$total = $objectTransactionData->transactions[0]->amount->total;
$currency = $objectTransactionData->transactions[0]->amount->currency;
$custom = $objectTransactionData->transactions[0]->custom;

$key = explode("#", $custom);

$saleId = $key[0];
$saleKey = openssl_decrypt($key[1], code, key);

curl_close($sale);
curl_close($login);

// echo $saleKey;

if ($state == "approved") {

    $paypalMessage = "<h3> Pago aprobado <h3/>";

    $sentence = $pdo->prepare("UPDATE `create_sales_table` SET `paypal_data` = :paypal_data , `status` = 'aprobado' WHERE `create_sales_table`.`id` = :id");

    $sentence->bindParam(":id", $saleKey);
    $sentence->bindParam(":paypal_data", $saleResponse);
    $sentence->execute();

    $sentence = $pdo->prepare("UPDATE create_sales_table SET status='completo' WHERE transaction_key = :transaction_key AND total = :total AND id = :id");

    $sentence->bindParam(":transaction_key", $saleId);
    $sentence->bindParam(":total", $total);
    $sentence->bindParam(":id", $saleKey);
    $sentence->execute();

    // obtiene la cantidad en filas de los registros modificados
    $completed = $sentence->rowCount();
} else {

    $paypalMessage = "<h3> Hay un problema con el pago de paypal <h3/>";
}

// echo $paypalMessage;

?>

<div class="jumbotron">
    <h1 class="display-4"> ¡ Listo !</h1>
    <hr class="my-4">
    <p class="lead"><?= $paypalMessage ?></p>
    <?php
    if ($completed >= 1) {

        $sentence = $pdo->prepare("SELECT * FROM create_sale_detail_table, create_products_table WHERE create_sale_detail_table.product_id=create_products_table.id AND create_sale_detail_table.sale_id = :id");

        $sentence->bindParam(":id", $saleKey);
        $sentence->execute();

        $productsList = $sentence->fetchAll(PDO::FETCH_ASSOC);

        print_r($productsList);
    }
    ?>
    <p>Content</p>
</div>