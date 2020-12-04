<?php

// print_r($_GET);

$clientId = "AXlAuQZdeYFxfSn4n5bDvvu6EGbeYAMQnT6XSd7v4C8CNzDa6PWIJOx56MiwatzyBjK5RVHekA-2WfaF";
$secret = "EBJyjKAO3VUKUo1zVZ23d-iATTOErOUA2XLjtEf0dIKKFa0iLiPHPAafUasJBnBexCvwM4r65Yh6gQet";

$login = curl_init("https://api-m.sandbox.paypal.com/v1/oauth2/token");

curl_setopt($login, CURLOPT_RETURNTRANSFER, true);

curl_setopt($login, CURLOPT_USERPWD, $clientId.":".$secret);

curl_setopt($login, CURLOPT_POSTFIELDS,"grant_type=client_credentials");

$reply = curl_exec($login);

$responseObject = json_decode($reply);

$accessToken = $responseObject->access_token;

// print_r($accessToken);

$sale = curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']);

curl_setopt($sale,CURLOPT_HTTPHEADER, array("Content-Type: application/json","Authorization: Bearer ".$accessToken));

curl_setopt($sale, CURLOPT_RETURNTRANSFER, true);

$saleResponse = curl_exec($sale);

// print_r($saleResponse);

$objectTransactionData = json_decode($saleResponse); 

// print_r($objectTransactionData);

$state = $objectTransactionData->state;
$email = $objectTransactionData->payer->payer_info->email;

$total = $objectTransactionData->transactions[0]->amount->total;
$currency = $objectTransactionData->transactions[0]->amount->currency;
$custom = $objectTransactionData->transactions[0]->custom;

echo "$total <br> $currency <br> $custom";
